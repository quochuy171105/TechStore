<?php
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/OrderDetail.php';
require_once __DIR__ . '/../models/Database.php';

class OrderController {
    private $orderModel;
    private $orderDetailModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->orderModel = new Order($pdo);
        $this->orderDetailModel = new OrderDetail($pdo);
    }

    public function createOrder($userId, $addressId, $totalAmount, $paymentMethod, $cartItems) {
        try {
            if (empty($cartItems)) {
                throw new Exception("Giỏ hàng trống.");
            }

            $orderId = $this->orderModel->createOrder($userId, $addressId, $totalAmount, $paymentMethod);

            foreach ($cartItems as $item) {
                $this->orderDetailModel->createOrderDetail(
                    $orderId,
                    $item['product_id'],
                    $item['quantity'],
                    $item['price'] // Không chia 1,000,000
                );
            }

            $this->orderModel->clearCart($userId);

            return ['success' => true, 'order_id' => $orderId];
        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    public function getOrderHistory($userId) {
        return $this->orderModel->getOrderHistory($userId);
    }
}
