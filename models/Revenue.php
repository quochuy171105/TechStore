<?php
// models/Revenue.php
require_once 'Database.php';

// Lớp Revenue quản lý các thao tác liên quan đến doanh thu
class Revenue {
    // Thuộc tính PDO để thao tác với database
    private $pdo;
    private $lastQuery;

    // Hàm khởi tạo, nhận kết nối PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getLastQuery() {
        return $this->lastQuery;
    }

    // Lấy dữ liệu doanh thu theo khoảng ngày (trả về mảng các ngày và tổng doanh thu từng ngày)
    public function getRevenueByDateRange($start_date, $end_date) {
        $query = "SELECT DATE(revenue_date) as date, SUM(total_amount) as total FROM revenue WHERE revenue_date BETWEEN :start_date AND :end_date GROUP BY DATE(revenue_date) ORDER BY DATE(revenue_date) ASC";
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenueByDateRange($start_date, $end_date) {
        $query = "SELECT SUM(total_amount) as total FROM revenue WHERE revenue_date BETWEEN :start_date AND :end_date";
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRevenueByMonth($year_month) {
        $query = "SELECT DATE(revenue_date) as date, SUM(total_amount) as total 
                  FROM revenue 
                  WHERE DATE_FORMAT(revenue_date, '%Y-%m') = :year_month
                  GROUP BY date 
                  ORDER BY date ASC";
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':year_month', $year_month);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenueByMonth($year_month) {
        $query = "SELECT SUM(total_amount) as total_revenue FROM revenue WHERE DATE_FORMAT(revenue_date, '%Y-%m') = :year_month";
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':year_month', $year_month);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRevenueByYear($year) {
        $query = "SELECT DATE_FORMAT(revenue_date, '%Y-%m') as month, SUM(total_amount) as monthly_revenue 
                  FROM revenue 
                  WHERE YEAR(revenue_date) = :year
                  GROUP BY DATE_FORMAT(revenue_date, '%Y-%m') 
                  ORDER BY month ASC";
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenueByYear($year) {
        $query = "SELECT SUM(total_amount) as total FROM revenue WHERE YEAR(revenue_date) = :year";
        $this->lastQuery = $query;
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenueAllTime() {
        $query = "SELECT SUM(total_amount) as total_revenue FROM revenue";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function truncateRevenueTable() {
        try {
            $query = "TRUNCATE TABLE revenue";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            error_log('Revenue table truncated.');
        } catch (PDOException $e) {
            error_log('Error truncating revenue table: ' . $e->getMessage());
            throw $e; // Ném lại ngoại lệ để controller có thể xử lý
        }
    }

    // Thêm phương thức để tạo dữ liệu mẫu nếu bảng revenue đang trống
    public function generateSampleDataIfEmpty() {
        try {
            // Kiểm tra xem bảng đã có dữ liệu chưa
            $query = "SELECT COUNT(*) FROM revenue";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            
            if ($stmt->fetchColumn() > 0) {
                return; // Đã có dữ liệu, không cần tạo mẫu
            }
            
            // Kiểm tra và tạo đơn hàng mẫu nếu cần
            $this->createSampleOrdersIfEmpty();

            // Lấy tất cả các order_id hiện có
            $order_ids_query = "SELECT id FROM orders";
            $order_ids_stmt = $this->pdo->prepare($order_ids_query);
            $order_ids_stmt->execute();
            $order_ids = $order_ids_stmt->fetchAll(PDO::FETCH_COLUMN);

            if (empty($order_ids)) {
                error_log('No orders found to generate revenue data.');
                return;
            }

            // Mở rộng phạm vi dữ liệu mẫu để bao gồm năm 2024 và 2025
            $start_date = '2024-01-01';
            $end_date = '2025-12-31';
            
            $this->pdo->beginTransaction();
            
            // Lặp qua từng ngày, tạo doanh thu ngẫu nhiên cho mỗi ngày
            for ($date = strtotime($start_date); $date <= strtotime($end_date); $date = strtotime('+1 day', $date)) {
                $current_date = date('Y-m-d H:i:s', $date);
                $amount = rand(500000, 5000000); // Random amount
                $order_id = $order_ids[array_rand($order_ids)]; // Chọn một order_id ngẫu nhiên
                
                $insert_query = "INSERT INTO revenue (order_id, revenue_date, total_amount) VALUES (:order_id, :date, :amount)";
                $insert_stmt = $this->pdo->prepare($insert_query);
                $insert_stmt->bindParam(':order_id', $order_id);
                $insert_stmt->bindParam(':date', $current_date);
                $insert_stmt->bindParam(':amount', $amount);
                $insert_stmt->execute();
            }
            
            $this->pdo->commit();
            error_log('Generated sample revenue data');
            
        } catch (PDOException $e) {
            // Nếu có lỗi, rollback transaction nếu đang trong transaction
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log('Error generating sample data: ' . $e->getMessage());
        }
    }

    private function createSampleOrdersIfEmpty() {
        try {
            $query = "SELECT COUNT(*) FROM orders";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            if ($stmt->fetchColumn() == 0) {
                // Cần tạo người dùng mẫu trước
                $this->createSampleUsersIfEmpty();

                $this->pdo->beginTransaction();
                $insert_query = "INSERT INTO orders (user_id, total_amount, status, created_at) VALUES (:user_id, :total_amount, :status, :created_at)";
                $statuses = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];

                // Lấy tất cả user_id
                $user_ids_query = "SELECT id FROM users";
                $user_ids_stmt = $this->pdo->prepare($user_ids_query);
                $user_ids_stmt->execute();
                $user_ids = $user_ids_stmt->fetchAll(PDO::FETCH_COLUMN);

                if (empty($user_ids)) {
                    error_log('No users found to create sample orders.');
                    $this->pdo->rollBack();
                    return;
                }

                for ($i = 0; $i < 20; $i++) { // Tạo 20 đơn hàng mẫu
                    $user_id = $user_ids[array_rand($user_ids)];
                    $total_amount = rand(100000, 10000000);
                    $status = $statuses[array_rand($statuses)];
                    $created_at = date('Y-m-d H:i:s', rand(strtotime('2024-01-01'), strtotime('2025-12-31')));

                    $insert_stmt = $this->pdo->prepare($insert_query);
                    $insert_stmt->bindParam(':user_id', $user_id);
                    $insert_stmt->bindParam(':total_amount', $total_amount);
                    $insert_stmt->bindParam(':status', $status);
                    $insert_stmt->bindParam(':created_at', $created_at);
                    $insert_stmt->execute();
                }
                $this->pdo->commit();
                error_log('Generated sample orders.');
            }
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log('Error creating sample orders: ' . $e->getMessage());
        }
    }

    private function createSampleUsersIfEmpty() {
        try {
            $query = "SELECT COUNT(*) FROM users";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();

            if ($stmt->fetchColumn() == 0) {
                $this->pdo->beginTransaction();
                $insert_query = "INSERT INTO users (username, password, email, full_name, role, created_at) VALUES (:username, :password, :email, :full_name, :role, :created_at)";
                
                for ($i = 1; $i <= 10; $i++) {
                    $username = 'user' . $i;
                    $password = password_hash('password' . $i, PASSWORD_DEFAULT);
                    $email = 'user' . $i . '@example.com';
                    $full_name = 'User ' . $i;
                    $role = 'customer';
                    $created_at = date('Y-m-d H:i:s');

                    $insert_stmt = $this->pdo->prepare($insert_query);
                    $insert_stmt->bindParam(':username', $username);
                    $insert_stmt->bindParam(':password', $password);
                    $insert_stmt->bindParam(':email', $email);
                    $insert_stmt->bindParam(':full_name', $full_name);
                    $insert_stmt->bindParam(':role', $role);
                    $insert_stmt->bindParam(':created_at', $created_at);
                    $insert_stmt->execute();
                }
                $this->pdo->commit();
                error_log('Generated sample users.');
            }
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log('Error creating sample users: ' . $e->getMessage());
        }
    }
}
// Kết thúc class Revenue
?>