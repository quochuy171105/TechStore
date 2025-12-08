<?php
// models/Revenue.php
require_once 'Database.php';

// Lớp Revenue quản lý các thao tác liên quan đến doanh thu
class Revenue {
    // Thuộc tính PDO để thao tác với database
    private $pdo;

    // Hàm khởi tạo, nhận kết nối PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Lấy dữ liệu doanh thu theo khoảng ngày (trả về mảng các ngày và tổng doanh thu từng ngày)
    public function getRevenueByDateRange($start_date, $end_date) {
        $query = "SELECT DATE(revenue_date) as date, SUM(total_amount) as total FROM revenue WHERE revenue_date BETWEEN :start_date AND :end_date GROUP BY DATE(revenue_date) ORDER BY date ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenue($start_date, $end_date) {
        $query = "SELECT SUM(total_amount) as total_revenue FROM revenue WHERE revenue_date BETWEEN :start_date AND :end_date";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getRevenueByYear($year) {
        $query = "SELECT MONTH(revenue_date) as month, SUM(total_amount) as monthly_revenue FROM revenue WHERE YEAR(revenue_date) = :year GROUP BY MONTH(revenue_date) ORDER BY month ASC";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalRevenueForYear($year) {
        $query = "SELECT SUM(total_amount) as total_revenue FROM revenue WHERE YEAR(revenue_date) = :year";
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
            
            // Tạo dữ liệu mẫu cho 30 ngày gần nhất
            $end_date = date('Y-m-d');
            $start_date = date('Y-m-d', strtotime('-30 days'));
            
            $this->pdo->beginTransaction();
            
            // Lặp qua từng ngày, tạo doanh thu ngẫu nhiên cho mỗi ngày
            for ($date = strtotime($start_date); $date <= strtotime($end_date); $date = strtotime('+1 day', $date)) {
                $current_date = date('Y-m-d', $date);
                $amount = rand(500000, 5000000); // Random amount
                
                $insert_query = "INSERT INTO revenue (revenue_date, total_amount) VALUES (:date, :amount)";
                $insert_stmt = $this->pdo->prepare($insert_query);
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
}
// Kết thúc class Revenue
?>