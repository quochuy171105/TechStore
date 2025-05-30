<?php
require_once dirname(__DIR__) . '/models/Database.php';

class Feedback {
    private $pdo, $lastError = '';
    public function __construct() {
        $this->pdo = Database::getInstance();
    }
    public function getByProduct($productId) {
    $stmt = $this->pdo->prepare("
        SELECT f.*, u.name AS user_name
        FROM feedback f
        JOIN users u ON f.user_id = u.id
        WHERE f.product_id = ?
        ORDER BY f.created_at DESC
    ");
    $stmt->execute([$productId]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
    public function createFeedback($userId, $productId, $comment, $rating) {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO feedback (user_id, product_id, comment, rating, created_at) VALUES (?, ?, ?, ?, NOW())");
            $result = $stmt->execute([$userId, $productId, $comment, $rating]);
            return $result;
        } catch (PDOException $e) {
            $this->lastError = $e->getMessage();
            return false;
        }
    }
    public function isExist($userId, $productId) {
        $stmt = $this->pdo->prepare("SELECT id FROM feedback WHERE user_id=? AND product_id=? LIMIT 1");
        $stmt->execute([$userId, $productId]);
        return $stmt->fetchColumn() !== false;
    }
    public function getByUser($userId) {
        $stmt = $this->pdo->prepare("SELECT f.*, p.name AS product_name, p.image AS product_image FROM feedback f JOIN products p ON f.product_id = p.id WHERE f.user_id = ? ORDER BY f.created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getLastError() { return $this->lastError; }
}
?>