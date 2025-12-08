<?php
// controllers/AdminController.php
require_once 'config/config.php';
require_once 'models/Database.php';
require_once 'models/Product.php';
require_once 'models/Order.php';
require_once 'models/Revenue.php';

// Controller quản trị tổng hợp cho admin (dashboard, đăng nhập, đăng ký, quên mật khẩu, ...)
class AdminController {
    // Các thuộc tính lưu kết nối PDO và các model
    private $pdo;
    private $productModel;
    private $orderModel;
    private $revenueModel;

    // Hàm khởi tạo controller, khởi tạo kết nối DB và các model
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->pdo = Database::getInstance();
        $this->productModel = new Product($this->pdo);
        $this->orderModel = new Order($this->pdo);
        $this->revenueModel = new Revenue($this->pdo);
    }

    // Trang dashboard tổng quan cho admin
    public function index() {
        // Kiểm tra quyền truy cập admin
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            header('Location: ' . BASE_URL . 'admin.php?url=login');
            exit;
        }

        // Lấy tổng doanh thu
        $total_revenue_data = $this->revenueModel->getTotalRevenueAllTime();
        $total_revenue = $total_revenue_data['total_revenue'] ?? 0;
        error_log('Total revenue: ' . $total_revenue);

        // Lấy tổng số đơn hàng
        $total_orders = $this->orderModel->countAll();
        error_log('Total orders: ' . $total_orders);

        // Lấy tổng số sản phẩm
        $total_products = $this->productModel->countAll();
        error_log('Total products: ' . $total_products);

        // Lấy tổng số khách hàng
        $total_users = $this->pdo->query("SELECT COUNT(*) FROM users WHERE role = 'customer'")->fetchColumn();
        error_log('Total users: ' . $total_users);

        // Lấy danh sách khách hàng (có tìm kiếm, phân trang)
        $search = isset($_GET['search_customer']) ? trim($_GET['search_customer']) : '';
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $items_per_page = 5;
        $offset = ($page - 1) * $items_per_page;

        try {
            $query = "SELECT id, name, email, phone, created_at 
                      FROM users 
                      WHERE role = 'customer'";
            if ($search) {
                $query .= " AND (name LIKE :search OR email LIKE :search)";
            }
            $query .= " ORDER BY created_at DESC LIMIT :offset, :items_per_page";
            $stmt = $this->pdo->prepare($query);
            if ($search) {
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
            }
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
            $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
            $stmt->execute();
            $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Customers fetched: ' . count($customers) . ' records');
        } catch (PDOException $e) {
            error_log('Error fetching customers: ' . $e->getMessage());
            $customers = [];
        }

        // Đếm tổng số khách hàng cho phân trang
        $total_customers_query = "SELECT COUNT(*) FROM users WHERE role = 'customer'";
        if ($search) {
            $total_customers_query .= " AND (name LIKE :search OR email LIKE :search)";
        }
        $stmt = $this->pdo->prepare($total_customers_query);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
        }
        $stmt->execute();
        $total_customers = $stmt->fetchColumn();
        $total_customer_pages = ceil($total_customers / $items_per_page);
        error_log('Total customers: ' . $total_customers . ', Pages: ' . $total_customer_pages);

        // Thống kê số lượng đơn hàng theo từng trạng thái
        $order_status_counts = [
            'pending' => 0,
            'processing' => 0,
            'shipped' => 0,
            'delivered' => 0,
            'cancelled' => 0
        ];
        try {
            $status_query = "SELECT status, COUNT(*) as count FROM orders GROUP BY status";
            $status_stmt = $this->pdo->query($status_query);
            while ($row = $status_stmt->fetch(PDO::FETCH_ASSOC)) {
                if (array_key_exists($row['status'], $order_status_counts)) {
                    $order_status_counts[$row['status']] = $row['count'];
                }
            }
            error_log('Order status counts: ' . print_r($order_status_counts, true));
        } catch (PDOException $e) {
            error_log('Error fetching order status counts: ' . $e->getMessage());
        }

        // Lấy doanh thu 7 ngày gần nhất
        $end_date = date('Y-m-d');
        $start_date = date('Y-m-d', strtotime('-6 days')); // 7 ngày
        try {
            $recent_revenue = $this->revenueModel->getRevenueByDateRange($start_date, $end_date);
            error_log('Recent revenue data: ' . print_r($recent_revenue, true));
        } catch (Exception $e) {
            error_log('Error fetching recent revenue: ' . $e->getMessage());
            $recent_revenue = [];
        }

        // Chuẩn bị dữ liệu truyền sang view dashboard
        $data = [
            'total_revenue' => $total_revenue,
            'total_orders' => $total_orders,
            'total_products' => $total_products,
            'total_users' => $total_users,
            'customers' => $customers,
            'current_page' => $page,
            'total_customer_pages' => $total_customer_pages,
            'search_customer' => $search,
            'order_status_counts' => $order_status_counts,
            'recent_revenue' => $recent_revenue
        ];

        include VIEWS_PATH . 'admin/dashboard.php';
    }

    // Đăng ký tài khoản admin mới
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form POST
            $name = trim($_POST['name'] ?? '');
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $address_line = trim($_POST['address_line'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $postal_code = trim($_POST['postal_code'] ?? '');
            $country = trim($_POST['country'] ?? 'Vietnam');

            // Mảng lưu lỗi validate
            $errors = [];

            // Validate các trường bắt buộc
            if (empty($name) || strlen($name) < 2) {
                $errors[] = "Họ tên phải có ít nhất 2 ký tự.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Email không hợp lệ.";
            }
            if (empty($phone) || !preg_match('/^(0[3|5|7|8|9])+([0-9]{8})$/', $phone)) {
                $errors[] = "Số điện thoại không hợp lệ (VD: 0901234567).";
            }
            if (empty($password) || strlen($password) < 6) {
                $errors[] = "Mật khẩu phải có ít nhất 6 ký tự.";
            }
            // Kiểm tra độ mạnh mật khẩu
            if (!empty($password)) {
                if (!preg_match('/[A-Z]/', $password)) {
                    $errors[] = "Mật khẩu phải chứa ít nhất 1 chữ hoa.";
                }
                if (!preg_match('/[a-z]/', $password)) {
                    $errors[] = "Mật khẩu phải chứa ít nhất 1 chữ thường.";
                }
                if (!preg_match('/[0-9]/', $password)) {
                    $errors[] = "Mật khẩu phải chứa ít nhất 1 số.";
                }
            }
            if ($password !== $confirm_password) {
                $errors[] = "Mật khẩu xác nhận không khớp.";
            }

            // Kiểm tra email đã tồn tại chưa
            try {
                $check_email_query = "SELECT COUNT(*) FROM users WHERE email = :email";
                $stmt = $this->pdo->prepare($check_email_query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->fetchColumn() > 0) {
                    $errors[] = "Email này đã được sử dụng.";
                }
            } catch (PDOException $e) {
                $errors[] = "Lỗi kiểm tra email: " . $e->getMessage();
                error_log("Error checking email: " . $e->getMessage());
            }

            // Kiểm tra số điện thoại đã tồn tại chưa
            try {
                $check_phone_query = "SELECT COUNT(*) FROM users WHERE phone = :phone";
                $stmt = $this->pdo->prepare($check_phone_query);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->execute();
                if ($stmt->fetchColumn() > 0) {
                    $errors[] = "Số điện thoại này đã được sử dụng.";
                }
            } catch (PDOException $e) {
                $errors[] = "Lỗi kiểm tra số điện thoại: " . $e->getMessage();
                error_log("Error checking phone: " . $e->getMessage());
            }

            // Nếu có lỗi, hiển thị lại form đăng ký
            if (!empty($errors)) {
                $error = implode('<br>', $errors);
                include VIEWS_PATH . 'admin/register.php';
                return;
            }

            // Hash mật khẩu
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            try {
                // Bắt đầu transaction
                $this->pdo->beginTransaction();

                // Thêm user mới vào bảng users
                $user_query = "INSERT INTO users (name, email, phone, password, role, created_at, updated_at) 
                              VALUES (:name, :email, :phone, :password, 'admin', NOW(), NOW())";
                $stmt = $this->pdo->prepare($user_query);
                $stmt->bindParam(':name', $name, PDO::PARAM_STR);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':phone', $phone, PDO::PARAM_STR);
                $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
                $stmt->execute();

                $user_id = $this->pdo->lastInsertId();

                // Thêm địa chỉ nếu có nhập
                if (!empty($address_line) || !empty($city)) {
                    $address_query = "INSERT INTO addresses (user_id, address_line, city, postal_code, country, is_default) 
                                     VALUES (:user_id, :address_line, :city, :postal_code, :country, 1)";
                    $stmt = $this->pdo->prepare($address_query);
                    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
                    $stmt->bindParam(':address_line', $address_line, PDO::PARAM_STR);
                    $stmt->bindParam(':city', $city, PDO::PARAM_STR);
                    $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
                    $stmt->bindParam(':country', $country, PDO::PARAM_STR);
                    $stmt->execute();
                }

                // Commit transaction
                $this->pdo->commit();

                // Log đăng ký thành công
                error_log("New admin registered: ID=$user_id, Email=$email, Name=$name");

                // Chuyển hướng về trang đăng nhập với thông báo thành công
                $_SESSION['registration_success'] = "Đăng ký thành công! Vui lòng đăng nhập.";
                header('Location: ' . BASE_URL . 'admin.php?url=login');
                exit;

            } catch (PDOException $e) {
                // Rollback nếu có lỗi
                $this->pdo->rollBack();
                $error = "Lỗi khi tạo tài khoản: " . $e->getMessage();
                error_log("Registration error: " . $e->getMessage());
                include VIEWS_PATH . 'admin/register.php';
                return;
            }
        } else {
            include VIEWS_PATH . 'admin/register.php';
        }
    }

    // Đăng nhập admin
    public function login() {
        // Hiển thị thông báo đăng ký thành công nếu có
        if (isset($_SESSION['registration_success'])) {
            $success = $_SESSION['registration_success'];
            unset($_SESSION['registration_success']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = $_POST['password'] ?? '';
            $remember_me = isset($_POST['remember_me']);

            if (empty($email) || empty($password)) {
                $error = "Email và mật khẩu không được để trống.";
                include VIEWS_PATH . 'admin/login.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Email không hợp lệ.";
                include VIEWS_PATH . 'admin/login.php';
                return;
            }

            try {
                $query = "SELECT * FROM users WHERE email = :email AND role = 'admin' LIMIT 1";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user && password_verify($password, $user['password'])) {
                    // Đăng nhập thành công, tạo session
                    session_regenerate_id(true);
                    $_SESSION['user'] = $user;
                    $_SESSION['login_time'] = time();

                    // Cập nhật thời gian đăng nhập cuối
                    $update_query = "UPDATE users SET updated_at = NOW() WHERE id = :user_id";
                    $stmt = $this->pdo->prepare($update_query);
                    $stmt->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                    $stmt->execute();

                    // Xử lý "remember me" nếu có
                    if ($remember_me) {
                        $token = bin2hex(random_bytes(32));
                        $expire = time() + (30 * 24 * 60 * 60); // 30 ngày
                        // Lưu token vào cookie (có thể lưu vào DB nếu muốn)
                        setcookie('remember_admin', $token, $expire, '/', '', true, true);
                    }

                    // Log đăng nhập thành công
                    error_log("Admin login successful: " . $user['email']);

                    // Chuyển hướng về dashboard
                    header('Location: ' . BASE_URL . 'admin.php?url=dashboard');
                    exit;
                } else {
                    $error = "Email hoặc mật khẩu không đúng.";
                    error_log("Failed login attempt for email: " . $email);
                }
            } catch (PDOException $e) {
                $error = "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
                error_log("Database error during login: " . $e->getMessage());
            }
            include VIEWS_PATH . 'admin/login.php';
        } else {
            include VIEWS_PATH . 'admin/login.php';
        }
    }

    // Đăng xuất admin
    public function logout() {
        // Xóa cookie remember me nếu có
        if (isset($_COOKIE['remember_admin'])) {
            setcookie('remember_admin', '', time() - 3600, '/', '', true, true);
        }

        // Log logout
        if (isset($_SESSION['user'])) {
            error_log("Admin logout: " . $_SESSION['user']['email']);
        }

        // Xóa session
        $_SESSION = [];
        session_destroy();
        
        header('Location: ' . BASE_URL . 'admin.php?url=login');
        exit;
    }

    // Quên mật khẩu admin (gửi link đặt lại mật khẩu)
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Vui lòng nhập email hợp lệ.";
                include VIEWS_PATH . 'admin/forgot_password.php';
                return;
            }

            try {
                // Kiểm tra email có tồn tại không
                $query = "SELECT id, name FROM users WHERE email = :email AND role = 'admin' LIMIT 1";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($user) {
                    // Sinh token đặt lại mật khẩu (chưa lưu vào DB)
                    $token = bin2hex(random_bytes(32));
                    $expire = date('Y-m-d H:i:s', time() + 3600); // 1 giờ

                    // Thông báo thành công (thực tế cần gửi email)
                    $success = "Nếu email tồn tại, chúng tôi đã gửi link đặt lại mật khẩu đến email của bạn.";
                    error_log("Password reset requested for: " . $email);
                } else {
                    // Không tiết lộ email không tồn tại
                    $success = "Nếu email tồn tại, chúng tôi đã gửi link đặt lại mật khẩu đến email của bạn.";
                }
            } catch (PDOException $e) {
                $error = "Lỗi hệ thống. Vui lòng thử lại sau.";
                error_log("Forgot password error: " . $e->getMessage());
            }
            
            include VIEWS_PATH . 'admin/forgot_password.php';
        } else {
            include VIEWS_PATH . 'admin/forgot_password.php';
        }
    }

    // Helper kiểm tra độ mạnh mật khẩu (ít nhất 6 ký tự, có hoa, thường, số)
    private function validatePasswordStrength($password) {
        return strlen($password) >= 6 && 
               preg_match('/[A-Z]/', $password) && 
               preg_match('/[a-z]/', $password) && 
               preg_match('/[0-9]/', $password);
    }

    // Helper để làm sạch input (chống XSS)
    private function sanitizeInput($input) {
        return htmlspecialchars(trim($input), ENT_QUOTES, 'UTF-8');
    }
}
// Kết thúc class AdminController
?>