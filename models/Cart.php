<?php
require_once 'Database.php';

class Cart {
    private $pdo;

    public function __construct($pdo = null) {
        // Nếu không truyền vào thì lấy từ Database singleton
        $this->pdo = $pdo ?: Database::getInstance();
    }

    public function getCartItems($userId) {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.user_id, c.product_id, c.quantity, p.name, p.price, p.image
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = :user_id
        ");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($userId, $productId, $quantity) {
        $stmt = $this->pdo->prepare("SELECT id, quantity FROM cart WHERE user_id = :user_id AND product_id = :product_id");
        $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
        $stmt->execute();
        $existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($existingItem) {
            $newQuantity = $existingItem['quantity'] + $quantity;
            $stmt = $this->pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
            $stmt->bindValue(':quantity', $newQuantity, PDO::PARAM_INT);
            $stmt->bindValue(':id', $existingItem['id'], PDO::PARAM_INT);
            return $stmt->execute();
        } else {
            $stmt = $this->pdo->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (:user_id, :product_id, :quantity)");
            $stmt->bindValue(':user_id', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':product_id', $productId, PDO::PARAM_INT);
            $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
            return $stmt->execute();
        }
    }

    public function updateCartItem($cartId, $quantity) {
        $stmt = $this->pdo->prepare("UPDATE cart SET quantity = :quantity WHERE id = :id");
        $stmt->bindValue(':quantity', $quantity, PDO::PARAM_INT);
        $stmt->bindValue(':id', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function deleteCartItem($cartId) {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE id = :id");
        $stmt->bindValue(':id', $cartId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}