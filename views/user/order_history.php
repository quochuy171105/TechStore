<?php
session_start();

// Kiểm tra nếu chưa đăng nhập thì chuyển hướng về trang login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
// Lấy user_id từ session đã đăng nhập
$userId = $_SESSION['user_id'];

require_once __DIR__ . '/../../models/Database.php';

$pdo = Database::getInstance();

// Lấy danh sách đơn hàng của người dùng
$stmtOrders = $pdo->prepare("
    SELECT o.id, o.total_amount, o.status, o.created_at, a.address_line, a.city, a.postal_code, a.country
    FROM orders o
    JOIN addresses a ON o.address_id = a.id
    WHERE o.user_id = :user_id
    ORDER BY o.created_at DESC
");
$stmtOrders->execute(['user_id' => $userId]);
$orders = $stmtOrders->fetchAll(PDO::FETCH_ASSOC);

// Hàm ánh xạ trạng thái sang tiếng Việt
function translateStatus($status) {
    $statusMap = [
        'pending' => 'Chờ duyệt',
        'processing' => 'Đang xử lý',
        'shipped' => 'Đã giao',
        'delivered' => 'Hoàn thành',
        'cancelled' => 'Đã hủy'
    ];
    return $statusMap[$status] ?? $status;
}

$orderHistory = [];
foreach ($orders as $order) {
    // Lấy chi tiết sản phẩm của đơn hàng từ bảng order_details
    $stmtItems = $pdo->prepare("
        SELECT p.id AS product_id, p.name, p.price, od.quantity, p.image
        FROM order_details od
        JOIN products p ON od.product_id = p.id
        WHERE od.order_id = :order_id
    ");
    $stmtItems->execute(['order_id' => $order['id']]);
    $items = $stmtItems->fetchAll(PDO::FETCH_ASSOC);

    // Tính tổng tiền ban đầu (trước giảm giá) từ chi tiết sản phẩm
    $totalBeforeDiscount = 0;
    foreach ($items as $item) {
        $totalBeforeDiscount += $item['price'] * $item['quantity'];
    }

    // Tính tỷ lệ giảm giá dựa trên total_amount (sau giảm giá) và tổng tiền ban đầu
    $totalAfterDiscount = $order['total_amount'];
    $discountRatio = $totalBeforeDiscount > 0 ? $totalAfterDiscount / $totalBeforeDiscount : 1;

    // Áp dụng tỷ lệ giảm giá cho từng sản phẩm
    $formattedItems = array_map(function ($item) use ($discountRatio) {
        $price = (int)$item['price'];
        $subtotalBeforeDiscount = $price * $item['quantity'];
        $subtotalAfterDiscount = $subtotalBeforeDiscount * $discountRatio; // Áp dụng tỷ lệ giảm giá
        return [
            'product_id' => $item['product_id'],
            'name' => $item['name'],
            'price' => number_format($price, 0, ',', '.') . 'đ',
            'quantity' => $item['quantity'],
            'image' => $item['image'],
            'subtotal' => number_format($subtotalAfterDiscount, 0, ',', '.') . 'đ' // Thành tiền sau giảm giá
        ];
    }, $items);

    $orderHistory[] = [
        'id' => $order['id'],
        'date' => date('d/m/Y', strtotime($order['created_at'])),
        'total' => number_format($order['total_amount'], 0, ',', '.') . 'đ', // Sử dụng total_amount từ bảng orders
        'status' => translateStatus($order['status']),
        'address' => $order['address_line'] . ', ' . $order['city'] . ', ' . $order['postal_code'] . ', ' . $order['country'],
        'items' => $formattedItems
    ];
}

// Lấy order_id từ URL (nếu có)
$highlightOrderId = isset($_GET['order_id']) ? (int)$_GET['order_id'] : null;
include __DIR__ . '/../layouts/header.php';
?>

<meta charset="UTF-8">
<title>Lịch Sử Đơn Hàng - Shop TMĐT Điện Thoại</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- Order-history styles moved to assets/css/style.css -->

<div class="main-section container">
    <h2>Lịch sử đơn hàng</h2>
    <?php if (empty($orderHistory)): ?>
        <p class="text-center">Bạn chưa có đơn hàng nào.</p>
    <?php else: ?>
        <?php foreach ($orderHistory as $order): ?>
            <div class="order-details mb-4 <?php echo $order['id'] === $highlightOrderId ? 'highlight' : ''; ?>" id="order-<?php echo htmlspecialchars($order['id']); ?>">
                <div class="order-header">
                    <div class="row">
                        <div class="col-md-3"><strong>Mã đơn:</strong> #<?php echo htmlspecialchars($order['id']); ?></div>
                        <div class="col-md-3"><strong>Ngày đặt:</strong> <?php echo htmlspecialchars($order['date']); ?></div>
                        <div class="col-md-3"><strong>Tổng tiền:</strong> <?php echo htmlspecialchars($order['total']); ?></div>
                        <div class="col-md-3"><strong>Trạng thái:</strong> <?php echo htmlspecialchars($order['status']); ?></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-12"><strong>Địa chỉ giao hàng:</strong> <?php echo htmlspecialchars($order['address']); ?></div>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table cart-table">
                        <thead>
                            <tr>
                                <th style="width: 40%;">Sản phẩm</th>
                                <th style="width: 15%;">Đơn giá</th>
                                <th style="width: 15%;">Số lượng</th>
                                <th style="width: 15%;">Thành tiền</th>
                                <th style="width: 15%;">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($order['items'] as $item): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img class="product-img me-3" src="<?= IMAGES_PATH . htmlspecialchars($item['image']) ?>" alt="<?php echo htmlspecialchars($item['name']); ?>">
                                            <span><?php echo htmlspecialchars($item['name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($item['price']); ?></td>
                                    <td><?php echo htmlspecialchars($item['quantity']); ?></td>
                                    <td><?php echo htmlspecialchars($item['subtotal']); ?></td>
                                    <?php if ($order['status'] === 'Đã giao' || $order['status'] === 'Hoàn thành'): ?>
                                        <td>
                                            <a href="feedback.php?order_id=<?php echo htmlspecialchars($order['id']); ?>&product_id=<?php echo htmlspecialchars($item['product_id']); ?>" class="btn-rate">Đánh giá</a>
                                        </td>
                                    <?php else: ?>
                                        <td></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<script>
    // Cuộn đến đơn hàng được chỉ định trong URL (nếu có)
    document.addEventListener('DOMContentLoaded', function() {
        const highlightOrderId = <?php echo json_encode($highlightOrderId); ?>;
        if (highlightOrderId) {
            const orderElement = document.getElementById('order-' + highlightOrderId);
            if (orderElement) {
                orderElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>