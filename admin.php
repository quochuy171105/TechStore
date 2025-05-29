<?php
// admin.php
// Bật hiển thị lỗi để debug
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Khởi động session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    error_log('Session started, ID: ' . session_id());
} else {
    error_log('Session already active, ID: ' . session_id());
}

require_once 'config/config.php';
require_once 'config/database.php';
require_once CONTROLLERS_PATH . 'AdminController.php';
require_once CONTROLLERS_PATH . 'AdminProductController.php';
require_once CONTROLLERS_PATH . 'AdminOrderController.php';
require_once CONTROLLERS_PATH . 'AdminPromotionController.php';
require_once CONTROLLERS_PATH . 'AdminRevenueController.php';

// Định tuyến
$url = isset($_GET['url']) ? rtrim($_GET['url'], '/') : 'dashboard';
error_log('Processing URL: ' . $url);
$parts = explode('/', $url);
$controller_name = $parts[0] ?? 'dashboard';
$action = $parts[1] ?? 'index';
$param = $parts[2] ?? null;

error_log("Controller: $controller_name, Action: $action, Param: $param");

// Xử lý các route đặc biệt không cần kiểm tra quyền admin
$public_routes = ['login', 'register', 'forgot-password', 'logout'];
if (in_array($controller_name, $public_routes)) {
    $controller = new AdminController();
    
    try {
        switch ($controller_name) {
            case 'login':
                $controller->login();
                return;
            case 'register':
                $controller->register();
                return;
            case 'forgot-password':
                $controller->forgotPassword();
                return;
            case 'logout':
                $controller->logout();
                return;
        }
    } catch (Exception $e) {
        error_log('Error in public route: ' . $e->getMessage());
        error_log('Trace: ' . $e->getTraceAsString());
        
        $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        header('Location: ' . BASE_URL . 'admin.php?url=login');
        exit;
    }
}

// Kiểm tra quyền admin cho các route khác
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    error_log('Redirecting to login, user not admin or not logged in');
    header('Location: ' . BASE_URL . 'admin.php?url=login');
    exit;
}

// Xử lý các controller chính cho admin đã đăng nhập
$controller = null;
switch ($controller_name) {
    case 'dashboard':
    case '':
        $controller = new AdminController();
        break;
    case 'products':
        $controller = new AdminProductController();
        break;
    case 'orders':
        $controller = new AdminOrderController();
        break;
    case 'promotions':
        $controller = new AdminPromotionController();
        break;
    case 'revenue':
        $controller = new AdminRevenueController();
        break;
    default:
        error_log('Unknown controller: ' . $controller_name);
        http_response_code(404);
        include VIEWS_PATH . 'layouts/404.php';
        exit;
}

// Kiểm tra controller tồn tại
if (!$controller) {
    error_log('Controller not initialized for: ' . $controller_name);
    http_response_code(404);
    include VIEWS_PATH . 'layouts/404.php';
    exit;
}

// Sử dụng try-catch để xử lý lỗi và log
try {
    // Gọi phương thức trên controller
    if ($param && method_exists($controller, $action)) {
        error_log("Calling {$controller_name}::{$action} with param: {$param}");
        $controller->$action($param);
    } elseif (method_exists($controller, $action)) {
        error_log("Calling {$controller_name}::{$action}");
        $controller->$action();
    } else {
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
    // Log lỗi và hiển thị trang lỗi 
    error_log('Error in controller: ' . $e->getMessage());
    error_log('Trace: ' . $e->getTraceAsString());
    
    $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
    header('Location: ' . BASE_URL . 'admin.php?url=' . $controller_name);
    exit;
}
?>