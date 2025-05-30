<?php
require_once __DIR__ . '/../models/Cart.php';
require_once __DIR__ . '/../models/Database.php';

class CartController {
    private $cartModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->cartModel = new Cart($pdo);
    }

    // Lấy danh sách sản phẩm trong giỏ hàng
    public function getCartItems($userId) {
        if (!$userId) {
            return [];
        }
        return $this->cartModel->getCartItems($userId);
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart($userId, $productId, $quantity) {
        // Kiểm tra số lượng tồn kho (giả sử có hàm trong Product model)
        // $stock = $this->productModel->getStock($productId);
        // if ($quantity > $stock) {
        //     return false;
        // }
        if ($quantity < 1 || $productId <= 0 || $userId <= 0) {
            return false;
        }
        return $this->cartModel->addToCart($userId, $productId, $quantity);
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCartItem($cartId, $quantity) {
        if ($quantity < 1 || $cartId <= 0) {
            return false;
        }
        return $this->cartModel->updateCartItem($cartId, $quantity);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCartItem($cartId) {
        if ($cartId <= 0) {
            return false;
        }
        return $this->cartModel->deleteCartItem($cartId);
    }
}