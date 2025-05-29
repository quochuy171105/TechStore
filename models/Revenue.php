<?php
// models/Revenue.php
require_once 'Database.php';

class Revenue {
   private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getRevenueByDateRange($start_date, $end_date) {
        try {
            // Log thông tin để debug
            error_log("Revenue::getRevenueByDateRange($start_date, $end_date) called");
            
            $query = "SELECT DATE(revenue_date) as date, SUM(total_amount) as total 
                      FROM revenue 
                      WHERE revenue_date BETWEEN :start_date AND :end_date 
                      GROUP BY DATE(revenue_date)
                      ORDER BY revenue_date ASC";
            
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':start_date', $start_date);
            $stmt->bindParam(':end_date', $end_date);
            $stmt->execute();
            
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            error_log('Query result: ' . print_r($result, true));
            
            // Nếu không có dữ liệu, trả về mảng trống thay vì null
            return $result ?: [];
            
        } catch (PDOException $e) {
            error_log('Database error in Revenue::getRevenueByDateRange: ' . $e->getMessage());
            // Ném ngoại lệ để controller xử lý
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }

    public function getTotalRevenue() {
        try {
            $query = "SELECT SUM(total_amount) as total FROM revenue";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            
            $total = $stmt->fetchColumn();
            return $total ?: 0; // Trả về 0 nếu không có dữ liệu
            
        } catch (PDOException $e) {
            error_log('Database error in Revenue::getTotalRevenue: ' . $e->getMessage());
            // Ném ngoại lệ để controller xử lý
            throw new Exception('Database error: ' . $e->getMessage());
        }
    }
    
    // Thêm phương thức để tạo dữ liệu mẫu nếu bảng trống
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
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            error_log('Error generating sample data: ' . $e->getMessage());
        }
    }
}
?>