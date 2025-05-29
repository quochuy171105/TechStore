<?php
// index.php

// Khởi tạo session
session_start();

// Tải cấu hình và kết nối cơ sở dữ liệu
require_once __DIR__ . '/config/config.php';
require_once __DIR__ . '/models/Database.php';

// Tải các controller
require_once __DIR__ . '/controllers/ProductController.php';
require_once __DIR__ . '/controllers/CartController.php';
require_once __DIR__ . '/controllers/UserController.php';
require_once __DIR__ . '/controllers/FeedbackController.php';
require_once __DIR__ . '/controllers/OrderController.php';
require_once __DIR__ . '/controllers/PromotionController.php';

// Khởi tạo kết nối PDO

$db = Database::getInstance();
// ...existing code...
$pdo = $db;

// Khởi tạo các controller
$productController = new ProductController($pdo);
$cartController = new CartController($pdo);
$userController = new UserController($pdo);
$feedbackController = new FeedbackController($pdo);
$orderController = new OrderController($pdo);
$promotionController = new PromotionController($pdo);

// Xử lý URL
$request = isset($_GET['url']) ? trim($_GET['url'], '/') : '';
$method = $_SERVER['REQUEST_METHOD'];

// Hàm kiểm tra đăng nhập
function requireLogin() {
    if (!isset($_SESSION['user'])) {
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}

// Định tuyến
switch ($request) {
    // Thành viên 1: Giao diện người dùng cơ bản
    case '':
    case 'home':
        // Trang chủ
        require_once __DIR__ . '/views/user/home.php';
        break;

    case 'product_list':
        // Danh sách sản phẩm
        require_once __DIR__ . '/views/user/product_list.php';
        break;

    case 'product_detail':
        // Chi tiết sản phẩm
        if (isset($_GET['id'])) {
            require_once __DIR__ . '/views/user/product_detail.php';
        } else {
            http_response_code(404);
            echo '<h1>404 - Không tìm thấy sản phẩm</h1>';
        }
        break;

    case 'search':
        // Tìm kiếm sản phẩm
        require_once __DIR__ . '/views/user/search.php';
        break;

    // Thành viên 2: Giỏ hàng và thanh toán
    case 'cart':
        // Giỏ hàng
        requireLogin();
        require_once __DIR__ . '/views/user/cart.php';
        break;

    case 'checkout':
        // Thanh toán (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/checkout.php';
        break;

    case 'order_history':
        // Lịch sử đơn hàng (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/order_history.php';
        break;

    case 'apply_promotion':
        // Áp dụng mã khuyến mãi (AJAX)
        if ($method === 'POST') {
            require_once __DIR__ . '/services/apply_promotion.php';
        } else {
            http_response_code(405);
            echo 'Method Not Allowed';
        }
        break;

    // Thành viên 3: Đăng nhập/đăng ký và đánh giá
    case 'login':
        // Đăng nhập
        if ($method === 'POST') {
            // Xử lý đăng nhập
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
            require_once __DIR__ . '/views/user/login.php';
        }
        break;

    case 'register':
        // Đăng ký
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
            require_once __DIR__ . '/views/user/register.php';
        }
        break;

    case 'forgot_password':
        // Khôi phục mật khẩu
        require_once __DIR__ . '/views/user/forgot_password.php';
        break;

    case 'account':
        // Quản lý tài khoản (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/account.php';
        break;

    case 'feedback_form':
        // Form đánh giá sản phẩm (yêu cầu đăng nhập)
        requireLogin();
        if (isset($_GET['product_id'])) {
            require_once __DIR__ . '/views/user/feedback_form.php';
        } else {
            http_response_code(404);
            echo '<h1>404 - Không tìm thấy sản phẩm</h1>';
        }
        break;

    case 'feedback_history':
        // Lịch sử đánh giá (yêu cầu đăng nhập)
        requireLogin();
        require_once __DIR__ . '/views/user/feedback_history.php';
        break;

    // AJAX services (Thành viên 1 & 2)
    case 'services/search_product':
        // Tìm kiếm sản phẩm (AJAX)
        require_once __DIR__ . '/services/search_product.php';
        break;

    case 'services/filter_product':
        // Lọc sản phẩm (AJAX)
        require_once __DIR__ . '/services/filter_product.php';
        break;

    case 'services/get_product':
        // Lấy chi tiết sản phẩm (AJAX)
        require_once __DIR__ . '/services/get_product.php';
        break;

    case 'services/update_cart':
        // Cập nhật giỏ hàng (AJAX)
        require_once __DIR__ . '/services/update_cart.php';
        break;

    // Trang không tìm thấy
    default:
        http_response_code(404);
        echo '<h1>404 - Trang không tìm thấy</h1>';
        break;
}
?>