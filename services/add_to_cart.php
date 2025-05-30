<?php
// filepath: c:\xampp\htdocs\DoAnCuoiKiLapTrinhWeb2\services\add_to_cart.php
session_start();
require_once '../controllers/CartController.php';

$userId = $_SESSION['user_id'] ?? 1;
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

$response = ['success' => false, 'message' => ''];

if ($productId <= 0 || $quantity < 1) {
    $response['message'] = 'Dữ liệu không hợp lệ';
    echo json_encode($response);
    exit;
}

$cartController = new CartController();
$result = $cartController->addToCart($userId, $productId, $quantity);

if ($result) {
    $response['success'] = true;
    $response['message'] = 'Đã thêm vào giỏ hàng';
} else {
    $response['message'] = 'Không thể thêm vào giỏ hàng';
}

echo json_encode($response);