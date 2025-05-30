<?php
// models/Promotion.php
require_once 'Database.php';

class Promotion {
    private $pdo;

    public function __construct($pdo = null) {
        $this->pdo = $pdo ?: Database::getInstance(); // Linh hoạt truyền PDO hoặc dùng mặc định
    }

    public function getAll($page = 1, $items_per_page = ITEMS_PER_PAGE, $search = '') {
        $offset = ($page - 1) * $items_per_page;
        $query = "SELECT * FROM promotions";
        if ($search) {
            $query .= " WHERE code LIKE :search";
        }
        $query .= " ORDER BY created_at DESC LIMIT :offset, :items_per_page";

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
        $query = "SELECT COUNT(*) FROM promotions";
        if ($search) {
            $query .= " WHERE code LIKE :search";
        }
        $stmt = $this->pdo->prepare($query);
        if ($search) {
            $stmt->bindValue(':search', '%' . $search . '%');
        }
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPromotions($page = 1, $limit = 10) {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT * FROM promotions ORDER BY start_date DESC LIMIT :limit OFFSET :offset";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalPromotions() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as total FROM promotions");
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }

    public function getAllPromotions() {
        $stmt = $this->pdo->query("SELECT * FROM promotions ORDER BY start_date DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM promotions WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByCode($code) {
        $stmt = $this->pdo->prepare("SELECT * FROM promotions WHERE code = :code LIMIT 1");
        $stmt->execute([':code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO promotions (code, discount_type, discount_value, start_date, end_date, min_order_amount, created_at) 
                  VALUES (:code, :discount_type, :discount_value, :start_date, :end_date, :min_order_amount, NOW())";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':code', $data['code']);
        $stmt->bindParam(':discount_type', $data['discount_type']);
        $stmt->bindParam(':discount_value', $data['discount_value']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':min_order_amount', $data['min_order_amount']);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE promotions 
                  SET code = :code, discount_type = :discount_type, discount_value = :discount_value, 
                      start_date = :start_date, end_date = :end_date, min_order_amount = :min_order_amount 
                  WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':code', $data['code']);
        $stmt->bindParam(':discount_type', $data['discount_type']);
        $stmt->bindParam(':discount_value', $data['discount_value']);
        $stmt->bindParam(':start_date', $data['start_date']);
        $stmt->bindParam(':end_date', $data['end_date']);
        $stmt->bindParam(':min_order_amount', $data['min_order_amount']);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM promotions WHERE id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
