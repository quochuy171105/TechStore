
<?php
// controllers/AdminPromotionController.php
require_once 'models/Promotion.php';

// Controller quản trị khuyến mãi (CRUD khuyến mãi)
class AdminPromotionController {
    // Thuộc tính lưu model Promotion
    private $promotionModel;

    // Hàm khởi tạo controller, khởi tạo kết nối DB và model Promotion
    public function __construct() {
        $pdo = Database::getInstance(); // Lấy kết nối PDO từ singleton Database
        $this->promotionModel = new Promotion($pdo); // Khởi tạo model Promotion
    }

    // Trang danh sách khuyến mãi (quản lý khuyến mãi)
    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
        $search = isset($_GET['search']) ? trim($_GET['search']) : ''; // Từ khóa tìm kiếm
        $items_per_page = ITEMS_PER_PAGE; // Số khuyến mãi mỗi trang

        // Lấy danh sách khuyến mãi theo trang và tìm kiếm
        $promotions = $this->promotionModel->getAll($page, $items_per_page, $search);
        // Đếm tổng số khuyến mãi (phục vụ phân trang)
        $total_promotions = $this->promotionModel->countAll($search);
        $total_pages = ceil($total_promotions / $items_per_page);

        // Chuẩn bị dữ liệu truyền sang view
        $data = [
            'promotions' => $promotions,
            'current_page' => $page,
            'total_pages' => $total_pages
        ];

        // Nạp view quản lý khuyến mãi
        include VIEWS_PATH . 'admin/promotion_manage.php';
    }

    // Thêm mới khuyến mãi (hiển thị form và xử lý submit)
    public function create() {
        error_log('AdminPromotionController::create called');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form POST, kiểm tra và validate dữ liệu
            $data = [
                'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING),
                'discount_type' => filter_input(INPUT_POST, 'discount_type', FILTER_SANITIZE_STRING),
                'discount_value' => filter_input(INPUT_POST, 'discount_value', FILTER_VALIDATE_FLOAT),
                'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
                'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
                'min_order_amount' => filter_input(INPUT_POST, 'min_order_amount', FILTER_VALIDATE_FLOAT) ?: null
            ];

            // Kiểm tra dữ liệu đầu vào (bắt buộc)
            if (!$data['code'] || !$data['discount_type'] || !$data['discount_value'] || !$data['start_date'] || !$data['end_date']) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hợp lệ';
                error_log('Invalid input data for promotion creation');
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }

            // Kiểm tra mã khuyến mãi trùng lặp
            $existingPromotion = $this->promotionModel->getByCode($data['code']);
            if ($existingPromotion) {
                $_SESSION['error'] = 'Mã khuyến mãi đã tồn tại';
                error_log('Duplicate promotion code: ' . $data['code']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }

            // Kiểm tra giá trị khuyến mãi hợp lệ theo loại
            if ($data['discount_type'] === 'percentage' && ($data['discount_value'] <= 0 || $data['discount_value'] > 100)) {
                $_SESSION['error'] = 'Giá trị khuyến mãi phần trăm phải từ 0 đến 100';
                error_log('Invalid percentage discount value: ' . $data['discount_value']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }
            if ($data['discount_type'] === 'fixed' && $data['discount_value'] <= 0) {
                $_SESSION['error'] = 'Giá trị khuyến mãi cố định phải lớn hơn 0';
                error_log('Invalid fixed discount value: ' . $data['discount_value']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }

            // Kiểm tra ngày bắt đầu và kết thúc hợp lệ
            if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
                $_SESSION['error'] = 'Ngày bắt đầu không được sau ngày kết thúc';
                error_log('Invalid date range: start_date=' . $data['start_date'] . ', end_date=' . $data['end_date']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }
            if (strtotime($data['start_date']) < strtotime(date('Y-m-d'))) {
                $_SESSION['error'] = 'Ngày bắt đầu không được là ngày trong quá khứ';
                error_log('Start date in past: ' . $data['start_date']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }

            // Kiểm tra số tiền đơn hàng tối thiểu hợp lệ
            if ($data['min_order_amount'] !== null && $data['min_order_amount'] < 0) {
                $_SESSION['error'] = 'Số tiền đơn hàng tối thiểu phải lớn hơn hoặc bằng 0';
                error_log('Invalid min_order_amount: ' . $data['min_order_amount']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }

            // Thực hiện thêm khuyến mãi vào DB
            if ($this->promotionModel->create($data)) {
                $_SESSION['success'] = 'Thêm khuyến mãi thành công';
                error_log('Promotion created successfully, redirecting to promotions');
                header('Location: ' . BASE_URL . 'admin.php?url=promotions');
                exit;
            } else {
                $_SESSION['error'] = 'Thêm khuyến mãi thất bại';
                error_log('Failed to create promotion');
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/create');
                exit;
            }
        }

        // Nếu là GET, hiển thị form thêm khuyến mãi
        include VIEWS_PATH . 'admin/promotion_create.php';
    }

    // Cập nhật khuyến mãi (hiển thị form và xử lý submit)
    public function update($id) {
        error_log('AdminPromotionController::update called with id: ' . $id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form POST, kiểm tra và validate dữ liệu
            $data = [
                'code' => filter_input(INPUT_POST, 'code', FILTER_SANITIZE_STRING),
                'discount_type' => filter_input(INPUT_POST, 'discount_type', FILTER_SANITIZE_STRING),
                'discount_value' => filter_input(INPUT_POST, 'discount_value', FILTER_VALIDATE_FLOAT),
                'start_date' => filter_input(INPUT_POST, 'start_date', FILTER_SANITIZE_STRING),
                'end_date' => filter_input(INPUT_POST, 'end_date', FILTER_SANITIZE_STRING),
                'min_order_amount' => filter_input(INPUT_POST, 'min_order_amount', FILTER_VALIDATE_FLOAT) ?: null
            ];

            // Kiểm tra dữ liệu đầu vào (bắt buộc)
            if (!$data['code'] || !$data['discount_type'] || !$data['discount_value'] || !$data['start_date'] || !$data['end_date']) {
                $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin hợp lệ';
                error_log('Invalid input data for promotion update');
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/update/' . $id);
                exit;
            }

            // Kiểm tra mã khuyến mãi trùng lặp (trừ mã hiện tại)
            $existingPromotion = $this->promotionModel->getByCode($data['code']);
            if ($existingPromotion && $existingPromotion['id'] != $id) {
                $_SESSION['error'] = 'Mã khuyến mãi đã tồn tại';
                error_log('Duplicate promotion code: ' . $data['code']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/update/' . $id);
                exit;
            }

            // Kiểm tra giá trị khuyến mãi hợp lệ theo loại
            if ($data['discount_type'] === 'percentage' && ($data['discount_value'] <= 0 || $data['discount_value'] > 100)) {
                $_SESSION['error'] = 'Giá trị khuyến mãi phần trăm phải từ 0 đến 100';
                error_log('Invalid percentage discount value: ' . $data['discount_value']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/update/' . $id);
                exit;
            }
            if ($data['discount_type'] === 'fixed' && $data['discount_value'] <= 0) {
                $_SESSION['error'] = 'Giá trị khuyến mãi cố định phải lớn hơn 0';
                error_log('Invalid fixed discount value: ' . $data['discount_value']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/update/' . $id);
                exit;
            }

            // Kiểm tra ngày bắt đầu và kết thúc hợp lệ
            if (strtotime($data['start_date']) > strtotime($data['end_date'])) {
                $_SESSION['error'] = 'Ngày bắt đầu không được sau ngày kết thúc';
                error_log('Invalid date range: start_date=' . $data['start_date'] . ', end_date=' . $data['end_date']);
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/update/' . $id);
                exit;
            }

            // Thực hiện cập nhật khuyến mãi vào DB
            if ($this->promotionModel->update($id, $data)) {
                $_SESSION['success'] = 'Cập nhật khuyến mãi thành công';
                error_log('Promotion updated successfully, redirecting to promotions');
                header('Location: ' . BASE_URL . 'admin.php?url=promotions');
                exit;
            } else {
                $_SESSION['error'] = 'Cập nhật khuyến mãi thất bại';
                error_log('Failed to update promotion');
                header('Location: ' . BASE_URL . 'admin.php?url=promotions/update/' . $id);
                exit;
            }
        } else {
            // Nếu là GET, hiển thị form cập nhật khuyến mãi
            $promotion = $this->promotionModel->getById($id);
            if (!$promotion) {
                error_log('Promotion not found: ' . $id);
                include VIEWS_PATH . 'layouts/404.php';
                exit;
            }
            include VIEWS_PATH . 'admin/promotion_create.php';
        }
    }

    // Xóa khuyến mãi theo id (có hỗ trợ AJAX và xử lý lỗi liên quan dữ liệu ràng buộc)
    public function delete($id) {
        error_log('AdminPromotionController::delete called with id: ' . $id);
        // Kiểm tra nếu là yêu cầu AJAX
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        try {
            // Gọi model để xóa khuyến mãi
            if ($this->promotionModel->delete($id)) {
                $_SESSION['success'] = 'Xóa khuyến mãi thành công';
                error_log('Promotion deleted successfully');
                if ($isAjax) {
                    echo json_encode(['success' => true, 'message' => 'Xóa khuyến mãi thành công']);
                } else {
                    header('Location: ' . BASE_URL . 'admin.php?url=promotions');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Xóa khuyến mãi thất bại';
                error_log('Failed to delete promotion');
                if ($isAjax) {
                    echo json_encode(['success' => false, 'message' => 'Xóa khuyến mãi thất bại']);
                } else {
                    header('Location: ' . BASE_URL . 'admin.php?url=promotions');
                    exit;
                }
            }
        } catch (PDOException $e) {
            // Nếu xóa thất bại do ràng buộc dữ liệu (ví dụ khuyến mãi đã áp dụng cho đơn hàng)
            error_log('Delete promotion failed: ' . $e->getMessage());
            $_SESSION['error'] = 'Không thể xóa khuyến mãi do có dữ liệu liên quan';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa khuyến mãi do có dữ liệu liên quan']);
            } else {
                header('Location: ' . BASE_URL . 'admin.php?url=promotions');
                exit;
            }
        }
        if (!$isAjax) {
            // Nếu không phải AJAX, thực hiện chuyển hướng
            header('Location: ' . BASE_URL . 'admin.php?url=promotions');
            exit;
        }
    }
}
// Kết thúc class AdminPromotionController
?>