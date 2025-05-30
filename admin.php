<?php
// admin.php
// Bật hiển thị lỗi để debug trong quá trình phát triển
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Khởi động session nếu chưa có (dùng để lưu thông tin đăng nhập, thông báo, ...)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log('Session started, ID: ' . session_id());
} else {
    error_log('Session already active, ID: ' . session_id());
}

// Nạp các file cấu hình và controller cần thiết
require_once 'config/config.php'; // Định nghĩa các hằng số cấu hình
require_once 'config/database.php'; // Kết nối CSDL
require_once CONTROLLERS_PATH . 'AdminController.php'; // Controller chính cho admin
require_once CONTROLLERS_PATH . 'AdminProductController.php'; // Controller quản lý sản phẩm
require_once CONTROLLERS_PATH . 'AdminOrderController.php'; // Controller quản lý đơn hàng
require_once CONTROLLERS_PATH . 'AdminPromotionController.php'; // Controller quản lý khuyến mãi
require_once CONTROLLERS_PATH . 'AdminRevenueController.php'; // Controller thống kê doanh thu

// Định tuyến: lấy tham số url trên đường dẫn (?url=controller/action/param)
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'dashboard';
error_log('Processing URL: ' . $url);

// Phân tích url thành các phần: controller, action, param
$parts = explode('/', $url);
$controller_name = $parts[0] ?? 'dashboard'; // Tên controller, mặc định là dashboard
$action = $parts[1] ?? 'index'; // Tên action (hàm), mặc định là index
$param = $parts[2] ?? null; // Tham số truyền vào action (nếu có)

error_log("Controller: $controller_name, Action: $action, Param: $param");

// Các route không cần kiểm tra quyền admin (đăng nhập, đăng ký, quên mật khẩu, đăng xuất)
$public_routes = ['login', 'register', 'forgot-password', 'logout'];
if (in_array($controller_name, $public_routes)) {
    $controller = new AdminController();
    
    try {
        // Xử lý từng route công khai
        switch ($controller_name) {
            case 'login':
                // Gọi hàm đăng nhập admin
                $controller->login();
                return;
            case 'register':
                // Gọi hàm đăng ký admin
                $controller->register();
                return;
            case 'forgot-password':
                // Gọi hàm quên mật khẩu admin
                $controller->forgotPassword();
                return;
            case 'logout':
                // Gọi hàm đăng xuất admin
                $controller->logout();
                return;
        }
    } catch (Exception $e) {
        // Nếu có lỗi, ghi log và chuyển hướng về trang đăng nhập với thông báo lỗi
        error_log('Error in public route: ' . $e->getMessage());
        error_log('Trace: ' . $e->getTraceAsString());
        
        $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        header('Location: ' . BASE_URL . 'admin.php?url=login');
        exit;
    }
}

// Kiểm tra quyền admin cho các route còn lại
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    // Nếu chưa đăng nhập hoặc không phải admin thì chuyển hướng về trang đăng nhập
    error_log('Redirecting to login, user not admin or not logged in');
    header('Location: ' . BASE_URL . 'admin.php?url=login');
    exit;
}

// Khởi tạo controller tương ứng với route
$controller = null;
switch ($controller_name) {
    case 'dashboard':
    case '':
        // Trang tổng quan admin
        $controller = new AdminController();
        break;
    case 'products':
        // Quản lý sản phẩm
        $controller = new AdminProductController();
        break;
    case 'orders':
        // Quản lý đơn hàng
        $controller = new AdminOrderController();
        break;
    case 'promotions':
        // Quản lý khuyến mãi
        $controller = new AdminPromotionController();
        break;
    case 'revenue':
        // Thống kê doanh thu
        $controller = new AdminRevenueController();
        break;
    default:
        // Nếu controller không tồn tại, trả về trang 404
        error_log('Unknown controller: ' . $controller_name);
        http_response_code(404);
        include VIEWS_PATH . 'layouts/404.php';
        exit;
}

// Kiểm tra controller đã được khởi tạo chưa
if (!$controller) {
    error_log('Controller not initialized for: ' . $controller_name);
    http_response_code(404);
    include VIEWS_PATH . 'layouts/404.php';
    exit;
}

// Thực thi action tương ứng trên controller, có try-catch để bắt lỗi
try {
    // Nếu có param và action tồn tại trong controller thì gọi action với param
    if ($param && method_exists($controller, $action)) {
        error_log("Calling {$controller_name}::{$action} with param: {$param}");
        $controller->$action($param);
    } elseif (method_exists($controller, $action)) {
        // Nếu chỉ có action thì gọi action không truyền param
        error_log("Calling {$controller_name}::{$action}");
        $controller->$action();
    } else {
        // Nếu action không tồn tại thì gọi hàm index (nếu có), ngược lại trả về 404
        error_log("Action {$action} not found in {$controller_name}, falling back to index");
        if (method_exists($controller, 'index')) {
            $controller->index();
        } else {
            error_log("No index method in {$controller_name}");
            http_response_code(404);
            include VIEWS_PATH . 'layouts/404.php';
        }
    }
} catch (Exception $e) {
    // Nếu có lỗi khi thực thi controller, ghi log và chuyển hướng về trang tương ứng với thông báo lỗi
    error_log('Error in controller: ' . $e->getMessage());
    error_log('Trace: ' . $e->getTraceAsString());
    
    $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
    header('Location: ' . BASE_URL . 'admin.php?url=' . $controller_name);
    exit;
}
?>