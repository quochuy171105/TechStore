<?php
// controllers/AdminRevenueController.php
require_once 'models/Revenue.php';

// Controller quản trị thống kê doanh thu
class AdminRevenueController {
    // Thuộc tính lưu model Revenue
    private $revenueModel;

    // Hàm khởi tạo controller, khởi tạo kết nối DB và model Revenue
    public function __construct() {
        $pdo = Database::getInstance(); // Lấy kết nối PDO từ singleton Database
        $this->revenueModel = new Revenue($pdo); // Khởi tạo model Revenue
    }

    // Trang thống kê doanh thu (hiển thị biểu đồ, tổng doanh thu, lọc theo ngày)
    public function index() {
        try {
            // Thêm log để debug
            error_log('AdminRevenueController::index() called');
            
            // Lấy ngày bắt đầu và kết thúc từ query string, mặc định 30 ngày gần nhất
            $start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
            $end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
            
            error_log("Querying revenue from $start_date to $end_date in controller");

            // Lấy dữ liệu doanh thu theo khoảng ngày
            $revenue_data = $this->revenueModel->getRevenueByDateRange($start_date, $end_date);
            // Tính tổng doanh thu từ dữ liệu đã lấy
            $total_revenue = array_sum(array_column($revenue_data, 'total'));

            // Log dữ liệu đã lấy được để debug
            error_log('Revenue data: ' . print_r($revenue_data, true));
            error_log('Total revenue: ' . $total_revenue);
            
            // Chuẩn bị dữ liệu truyền sang view
            $data = [
                'revenue_data' => $revenue_data,
                'total_revenue' => $total_revenue,
                'start_date' => $start_date,
                'end_date' => $end_date
            ];

            // Truyền biến data ra view (extract để dùng trực tiếp tên biến)
            extract($data);
            
            // Nạp view thống kê doanh thu
            include VIEWS_PATH . 'admin/revenue.php';
        } catch (Exception $e) {
            // Ghi log lỗi nếu có exception
            error_log('Error in AdminRevenueController::index(): ' . $e->getMessage());
            error_log('Trace: ' . $e->getTraceAsString());
            
            // Đặt thông báo lỗi vào session và nạp lại view
            $_SESSION['error'] = 'Có lỗi khi tải dữ liệu doanh thu: ' . $e->getMessage();
            include VIEWS_PATH . 'admin/revenue.php';
        }
    }
}
// Kết thúc class AdminRevenueController
?>