<!-- views/admin/order_manage.php -->
<?php
// Đặt tiêu đề trang cho giao diện quản lý đơn hàng
$page_title = 'Quản lý đơn hàng';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <h2 class="mb-4">Quản lý đơn hàng</h2>

    <!-- Hiển thị thông báo thành công nếu có -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Hiển thị thông báo lỗi nếu có -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Form tìm kiếm đơn hàng -->
    <div class="mb-3 d-flex justify-content-between">
        <div></div>
        <form action="<?php echo BASE_URL; ?>admin.php?url=orders" method="GET" class="d-flex">
            <input type="hidden" name="url" value="orders">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm đơn hàng..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Tìm</button>
        </form>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <!-- Bảng danh sách đơn hàng -->
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Khách hàng</th>
                            <th>Tổng tiền (VND)</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Hiển thị từng đơn hàng -->
                        <?php if (isset($orders) && !empty($orders)): ?>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['id']); ?></td>
                                    <td><?php echo htmlspecialchars($order['user_name']); ?></td>
                                    <td><?php echo number_format($order['total_amount'], 2); ?></td>
                                    <td>
                                        <!-- Hiển thị trạng thái đơn hàng với màu sắc khác nhau -->
                                        <span class="badge 
                                            <?php 
                                                switch ($order['status']) {
                                                    case 'pending': echo 'bg-warning'; break;
                                                    case 'processing': echo 'bg-info'; break;
                                                    case 'shipped': echo 'bg-primary'; break;
                                                    case 'delivered': echo 'bg-success'; break;
                                                    case 'cancelled': echo 'bg-danger'; break;
                                                }
                                            ?>">
                                            <?php echo htmlspecialchars(ucfirst($order['status'])); ?>
                                        </span>
                                    </td>
                                    <td><?php echo htmlspecialchars($order['created_at']); ?></td>
                                    <td>
                                        <!-- Nút cập nhật trạng thái đơn hàng -->
                                        <a href="<?php echo BASE_URL; ?>admin.php?url=orders/update/<?php echo $order['id']; ?>" class="btn btn-warning btn-sm me-1 update-order" data-id="<?php echo $order['id']; ?>">Cập nhật</a>
                                        <!-- Nút hủy đơn hàng (chỉ hiện nếu chưa giao hoặc chưa vận chuyển) -->
                                        <?php if ($order['status'] !== 'delivered' && $order['status'] !== 'shipped'): ?>
                                            <a href="#" class="btn btn-danger btn-sm cancel-order" data-id="<?php echo $order['id']; ?>">Hủy</a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="6" class="text-center">Không có đơn hàng nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Phân trang đơn hàng -->
            <?php if (isset($total_pages) && $total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <!-- Nút về trang trước -->
                        <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=orders&page=<?php echo $current_page - 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>">Trước</a>
                        </li>
                        <!-- Hiển thị số trang -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=orders&page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <!-- Nút sang trang sau -->
                        <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=orders&page=<?php echo $current_page + 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>">Sau</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php 
// Nạp footer giao diện admin
include VIEWS_PATH . 'layouts/admin_footer.php'; 
?>