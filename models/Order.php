<?php
// models/Order.php
class Order {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll($page = 1, $items_per_page = ITEMS_PER_PAGE, $search = '') {
        $offset = ($page - 1) * $items_per_page;
        $query = "SELECT o.*, u.name as user_name 
                  FROM orders o 
                  JOIN users u ON o.user_id = u.id";
        if ($search) {
            $query .= " WHERE u.name LIKE :search OR o.id LIKE :search";
        }
        $query .= " ORDER BY o.created_at DESC LIMIT :offset, :items_per_page";
        
        $stmt = $this->pdo->prepare($query);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindValue(':items_per_page', $items_per_page, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll($search = '') {
        $query = "SELECT COUNT(*) FROM orders o JOIN users u ON o.user_id = u.id";
        if ($search) {
            $query .= " WHERE u.name LIKE :search OR o.id LIKE :search";
        }
        $stmt = $this->pdo->prepare($query);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getById($id) {
        $query = "SELECT o.*, u.name as user_name 
                  FROM orders o 
                  JOIN users u ON o.user_id = u.id 
                  WHERE o.id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE orders SET status = :status, updated_at = NOW() WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':status', $status);
        return $stmt->execute();
    }

    public function cancel($id) {
        return $this->updateStatus($id, 'cancelled');
    }

    public function createOrder($userId, $addressId, $totalAmount, $paymentMethod) {
        $stmt = $this->pdo->prepare("INSERT INTO orders (user_id, address_id, total_amount, payment_method, created_at, updated_at) 
                                     VALUES (:user_id, :address_id, :total_amount, :payment_method, NOW(), NOW())");
        $stmt->execute([
            'user_id' => $userId,
            'address_id' => $addressId,
            'total_amount' => $totalAmount,
            'payment_method' => $paymentMethod
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getOrderHistory($userId) {
        $stmt = $this->pdo->prepare("SELECT id, created_at, total_amount, status 
                                     FROM orders 
                                     WHERE user_id = :user_id 
                                     ORDER BY created_at DESC");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearCart($userId) {
        $stmt = $this->pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->rowCount();
    }
}
?>