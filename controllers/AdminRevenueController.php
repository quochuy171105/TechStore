<?php
// controllers/AdminRevenueController.php
require_once 'models/Revenue.php';

class AdminRevenueController {
    private $revenueModel;

    public function __construct() {
        $pdo = Database::getInstance();
        $this->revenueModel = new Revenue($pdo);
    }

    public function index() {
        try {
            // Thêm log để debug
            error_log('AdminRevenueController::index() called');
            
            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
            
            error_log("Querying revenue from $start_date to $end_date in controller");

            $revenue_data = $this->revenueModel->getRevenueByDateRange($start_date, $end_date);
            $total_revenue = array_sum(array_column($revenue_data, 'total')); // Đổi sang tính trực tiếp từ dữ liệu đã lấy

            // Log dữ liệu đã lấy được
            error_log('Revenue data: ' . print_r($revenue_data, true));
            error_log('Total revenue: ' . $total_revenue);
            
            $data = [
                'revenue_data' => $revenue_data,
                'total_revenue' => $total_revenue,
                'start_date' => $start_date,
                'end_date' => $end_date
            ];

            // Truyền biến data ra view
            extract($data);
            
            include VIEWS_PATH . 'admin/revenue.php';
        } catch (Exception $e) {
            error_log('Error in AdminRevenueController::index(): ' . $e->getMessage());
            error_log('Trace: ' . $e->getTraceAsString());
            
            $_SESSION['error'] = 'Có lỗi khi tải dữ liệu doanh thu: ' . $e->getMessage();
            include VIEWS_PATH . 'admin/revenue.php';
        }
    }
}
?>