
<?php
// index.php
// File định tuyến chính cho giao diện người dùng

// Khởi tạo session để lưu thông tin đăng nhập, giỏ hàng, v.v.
session_start();

// Tải cấu hình và kết nối cơ sở dữ liệu
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/models/Database.php';

// Tải các controller cần thiết cho từng chức năng
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/FeedbackController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/PromotionController.php';

// Khởi tạo kết nối PDO từ class Database
$db = Database::getInstance();
$pdo = $db;

// Khởi tạo các controller với tham số là kết nối PDO
$productController = new ProductController($pdo);
$cartController = new CartController($pdo);
$userController = new UserController($pdo);
$feedbackController = new FeedbackController($pdo);
$orderController = new OrderController($pdo);
$promotionController = new PromotionController($pdo);

// Lấy URL người dùng truy cập (ví dụ: ?url=product_list)
$request = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'];

// Hàm kiểm tra đăng nhập, nếu chưa đăng nhập thì chuyển hướng về trang login
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}

// Định tuyến các đường dẫn (route) của website
switch ($request) {
    // Trang chủ (giao diện người dùng)
    case '':
    case 'home':
        // Hiển thị trang chủ
        require_once __DIR__ . '/views/user/home.php';
        break;

    case 'product_list':
        // Hiển thị danh sách sản phẩm
        require_once __DIR__ . '/views/user/product_list.php';
        break;

    case 'product_detail':
        // Hiển thị chi tiết sản phẩm theo id truyền trên URL (?id=...)
        if (isset($_GET['id'])) {
            require_once __DIR__ . '/views/user/product_detail.php';
        } else {
            http_response_code(404);
            echo '<h1>404 - Không tìm thấy sản phẩm</h1>';
        }
        break;

    case 'search':
        // Trang tìm kiếm sản phẩm
        require_once __DIR__ . '/views/user/search.php';
        break;

    // Các chức năng liên quan đến giỏ hàng và thanh toán
    case 'cart':
        // Trang giỏ hàng (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/cart.php';
        break;

    case 'checkout':
        // Trang thanh toán (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/checkout.php';
        break;

    case 'order_history':
        // Lịch sử đơn hàng của người dùng (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/order_history.php';
        break;

    case 'apply_promotion':
        // Áp dụng mã khuyến mãi (AJAX, chỉ nhận POST)
        if ($method === 'POST') {
            require_once __DIR__ . '/services/apply_promotion.php';
        } else {
            http_response_code(405);
            echo 'Method Not Allowed';
        }
        break;

    // Các chức năng đăng nhập, đăng ký, quên mật khẩu, đánh giá
    case 'login':
        // Trang đăng nhập
        if ($method === 'POST') {
            // Xử lý đăng nhập khi submit form
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $result = $userController->login($email, $password);
            if ($result['success']) {
                header('Location: ' . BASE_URL . 'home');
            } else {
                $error = $result['message'];
                require_once __DIR__ . '/views/user/login.php';
            }
        } else {
            // Hiển thị form đăng nhập
            require_once __DIR__ . '/views/user/login.php';
        }
        break;

    case 'register':
        // Trang đăng ký tài khoản
        if ($method === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            $phone = filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_STRING);
            $result = $userController->register($email, $password, $name, $phone);
            if ($result['success']) {
                header('Location: ' . BASE_URL . 'login');
            } else {
                $error = $result['message'];
                require_once __DIR__ . '/views/user/register.php';
            }
        } else {
            // Hiển thị form đăng ký
            require_once __DIR__ . '/views/user/register.php';
        }
        break;

    case 'forgot_password':
        // Trang khôi phục mật khẩu
        require_once __DIR__ . '/views/user/forgot_password.php';
        break;

    case 'account':
        // Trang quản lý tài khoản (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/account.php';
        break;

    case 'feedback_form':
        // Form đánh giá sản phẩm (yêu cầu đăng nhập, cần có product_id)
        requireLogin();
        if (isset($_GET['product_id'])) {
            require_once __DIR__ . '/views/user/feedback_form.php';
        } else {
            http_response_code(404);
            echo '<h1>404 - Không tìm thấy sản phẩm</h1>';
        }
        break;

    case 'feedback_history':
        // Lịch sử đánh giá của người dùng (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/feedback_history.php';
        break;

    // Các dịch vụ AJAX cho sản phẩm và giỏ hàng
    case 'services/search_product':
        // AJAX: Tìm kiếm sản phẩm
        require_once __DIR__ . '/services/search_product.php';
        break;

    case 'services/filter_product':
        // AJAX: Lọc sản phẩm
        require_once __DIR__ . '/services/filter_product.php';
        break;

    case 'services/get_product':
        // AJAX: Lấy chi tiết sản phẩm
        require_once __DIR__ . '/services/get_product.php';
        break;

    case 'services/update_cart':
        // AJAX: Cập nhật giỏ hàng
        require_once __DIR__ . '/services/update_cart.php';
        break;

    // Chính sách
    case 'policy/warranty':
        require_once __DIR__ . '/views/user/policy/warranty.php';
        break;
    case 'policy/returns':
        require_once __DIR__ . '/views/user/policy/returns.php';
        break;
    case 'policy/privacy':
        require_once __DIR__ . '/views/user/policy/privacy.php';
        break;
    case 'policy/delivery':
        require_once __DIR__ . '/views/user/policy/delivery.php';
        break;

    // Nếu không khớp bất kỳ route nào ở trên thì trả về trang 404
    default:
        http_response_code(404);
        echo '<h1>404 - Trang không tìm thấy</h1>';
        break;
}
?>