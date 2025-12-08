
<?php
// controllers/AdminOrderController.php
require_once 'models/Order.php';

// Controller quản trị đơn hàng (Admin)
class AdminOrderController
{
    // Thuộc tính lưu model Order
    private $orderModel;

    // Thuộc tính PDO để thao tác DB trực tiếp khi cần
    private $pdo;

    // Hàm khởi tạo controller, khởi tạo kết nối DB và model Order
    public function __construct()
    {
        $this->pdo = Database::getInstance(); // Lấy kết nối PDO từ singleton Database
        $this->orderModel = new Order($this->pdo); // Khởi tạo model Order
    }

    // Trang danh sách đơn hàng (quản lý đơn hàng)
    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Trang hiện tại
        $search = isset($_GET['search']) ? trim($_GET['search']) : ''; // Từ khóa tìm kiếm
        $items_per_page = ITEMS_PER_PAGE; // Số đơn hàng mỗi trang

        // Lấy danh sách đơn hàng theo trang và tìm kiếm
        $orders = $this->orderModel->getAll($page, $items_per_page, $search);
        // Đếm tổng số đơn hàng (phục vụ phân trang)
        $total_orders = $this->orderModel->countAll($search);
        $total_pages = ceil($total_orders / $items_per_page);

        // Chuẩn bị dữ liệu truyền sang view
        $data = [
            'orders' => $orders,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'search' => $search
        ];

        // Nạp view quản lý đơn hàng
        include VIEWS_PATH . 'admin/order_manage.php';
    }

    // Cập nhật trạng thái đơn hàng (giao diện và xử lý cập nhật)
    public function update($id)
    {
        error_log('AdminOrderController::update called with id: ' . $id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy trạng thái mới từ form POST
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

            // Lấy trạng thái cũ của đơn hàng
            $order = $this->orderModel->getById($id);
            $oldStatus = $order['status'] ?? '';

            // Thực hiện cập nhật trạng thái đơn hàng
            if ($this->orderModel->updateStatus($id, $status)) {

                // Nếu chuyển sang trạng thái 'shipped' lần đầu thì giảm tồn kho sản phẩm
                if ($oldStatus !== 'shipped' && $status === 'shipped') {
                    // Lấy danh sách sản phẩm trong đơn hàng
                    $stmt = $this->pdo->prepare("SELECT product_id, quantity FROM order_details WHERE order_id = ?");
                    $stmt->execute([$id]);
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Giảm tồn kho từng sản phẩm theo số lượng đã bán
                    foreach ($products as $item) {
                        $stmtUpdate = $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                        $stmtUpdate->execute([$item['quantity'], $item['product_id']]);
                    }
                }

                // Đặt thông báo thành công và chuyển hướng về danh sách đơn hàng
                $_SESSION['success'] = 'Cập nhật đơn hàng thành công';
                error_log('Order updated successfully, redirecting to orders');
                header('Location: ' . BASE_URL . 'admin.php?url=orders');
                exit;
            } else {
                // Nếu cập nhật thất bại, đặt thông báo lỗi và chuyển hướng lại form cập nhật
                $_SESSION['error'] = 'Cập nhật đơn hàng thất bại';
                error_log('Failed to update order');
                header('Location: ' . BASE_URL . 'admin.php?url=orders/update/' . $id);
                exit;
            }
        } else {
            // Nếu là GET, hiển thị form cập nhật đơn hàng
            $order = $this->orderModel->getById($id);
            if (!$order) {
                error_log('Order not found: ' . $id);
                include VIEWS_PATH . 'layouts/404.php';
                exit;
            }
            include VIEWS_PATH . 'admin/order_update.php';
        }
    }

    // Hủy đơn hàng (chuyển trạng thái, không xóa vật lý)
    public function cancel($id)
    {
        error_log('AdminOrderController::cancel called with id: ' . $id);
        // Gọi model để hủy đơn hàng (thường là cập nhật trạng thái)
        if ($this->orderModel->cancel($id)) {
            $_SESSION['success'] = 'Hủy đơn hàng thành công';
            error_log('Order cancelled successfully, redirecting to orders');
            header('Location: ' . BASE_URL . 'admin.php?url=orders');
            exit;
        } else {
            $_SESSION['error'] = 'Hủy đơn hàng thất bại';
            error_log('Failed to cancel order');
            header('Location: ' . BASE_URL . 'admin.php?url=orders');
            exit;
        }
    }
}
// Kết thúc class AdminOrderController