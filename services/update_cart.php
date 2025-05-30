<?php
header('Content-Type: application/json');
require_once '../controllers/CartController.php';

$cartController = new CartController();
$response = ['success' => false, 'message' => ''];

$action = isset($_POST['action']) ? $_POST['action'] : '';
$cartId = isset($_POST['cart_id']) ? (int)$_POST['cart_id'] : 0;

if ($cartId <= 0) {
    $response['message'] = 'ID giỏ hàng không hợp lệ';
    echo json_encode($response);
    exit();
}

try {
    if ($action === 'update') {
        $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
        if ($quantity < 1) {
            $response['message'] = 'Số lượng không hợp lệ';
            echo json_encode($response);
            exit();
        }

        $result = $cartController->updateCartItem($cartId, $quantity);
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Cập nhật số lượng thành công';
        } else {
            $response['message'] = 'Không tìm thấy mục trong giỏ hàng hoặc số lượng không hợp lệ';
        }
    } elseif ($action === 'delete') {
        $result = $cartController->deleteCartItem($cartId);
        if ($result) {
            $response['success'] = true;
            $response['message'] = 'Xóa sản phẩm thành công';
        } else {
            $response['message'] = 'Không tìm thấy mục trong giỏ hàng';
        }
    } else {
        $response['message'] = 'Hành động không hợp lệ';
    }
} catch (Exception $e) {
    $response['message'] = 'Lỗi: ' . $e->getMessage();
}

echo json_encode($response);
exit();