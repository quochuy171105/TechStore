<?php
// controllers/AdminOrderController.php
require_once 'models/Order.php';

class AdminOrderController
{
    private $orderModel;

    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance();
        $this->orderModel = new Order($this->pdo);
    }

    public function index()
    {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $items_per_page = ITEMS_PER_PAGE;

        $orders = $this->orderModel->getAll($page, $items_per_page, $search);
        $total_orders = $this->orderModel->countAll($search);
        $total_pages = ceil($total_orders / $items_per_page);

        $data = [
            'orders' => $orders,
            'current_page' => $page,
            'total_pages' => $total_pages
        ];

        include VIEWS_PATH . 'admin/order_manage.php';
    }

    public function update($id)
    {
        error_log('AdminOrderController::update called with id: ' . $id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_STRING);

            // Lấy trạng thái cũ
            $order = $this->orderModel->getById($id);
            $oldStatus = $order['status'] ?? '';

            if ($this->orderModel->updateStatus($id, $status)) {

                // Nếu chuyển sang trạng thái 'shipped' (hoặc 'delivered') lần đầu
                if ($oldStatus !== 'shipped' && $status === 'shipped') {
                    // Lấy danh sách sản phẩm trong đơn hàng
                    $stmt = $this->pdo->prepare("SELECT product_id, quantity FROM order_details WHERE order_id = ?");
                    $stmt->execute([$id]);
                    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Giảm tồn kho từng sản phẩm
                    foreach ($products as $item) {
                        $stmtUpdate = $this->pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
                        $stmtUpdate->execute([$item['quantity'], $item['product_id']]);
                    }
                }

                $_SESSION['success'] = 'Cập nhật đơn hàng thành công';
                error_log('Order updated successfully, redirecting to orders');
                header('Location: ' . BASE_URL . 'admin.php?url=orders');
                exit;
            } else {
                $_SESSION['error'] = 'Cập nhật đơn hàng thất bại';
                error_log('Failed to update order');
                header('Location: ' . BASE_URL . 'admin.php?url=orders/update/' . $id);
                exit;
            }
        } else {
            $order = $this->orderModel->getById($id);
            if (!$order) {
                error_log('Order not found: ' . $id);
                include VIEWS_PATH . 'layouts/404.php';
                exit;
            }
            include VIEWS_PATH . 'admin/order_update.php';
        }
    }

    public function cancel($id)
    {
        error_log('AdminOrderController::cancel called with id: ' . $id);
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
