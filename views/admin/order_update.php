<!-- views/admin/order_update.php -->
<?php
// Đặt tiêu đề trang cho giao diện cập nhật đơn hàng
$page_title = 'Cập nhật đơn hàng';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Tiêu đề trang và hiển thị mã đơn hàng -->
            <h2 class="mb-4">Cập nhật đơn hàng #<?php echo htmlspecialchars($order['id']); ?></h2>
            <!-- Hiển thị thông báo lỗi nếu có -->
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <!-- Hiển thị thông báo lỗi từ session nếu có -->
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <!-- Form cập nhật trạng thái đơn hàng -->
                    <form id="order-update-form" method="POST">
                        <!-- Truyền id đơn hàng ẩn -->
                        <input type="hidden" name="id" value="<?php echo $order['id']; ?>">
                        <div class="mb-3">
                            <label for="status" class="form-label">Trạng thái</label>
                            <!-- Chọn trạng thái đơn hàng -->
                            <select class="form-select" id="status" name="status" required>
                                <option value="pending" <?php echo $order['status'] === 'pending' ? 'selected' : ''; ?>>Chờ xử lý</option>
                                <option value="processing" <?php echo $order['status'] === 'processing' ? 'selected' : ''; ?>>Đang xử lý</option>
                                <option value="shipped" <?php echo $order['status'] === 'shipped' ? 'selected' : ''; ?>>Đã giao</option>
                                <option value="delivered" <?php echo $order['status'] === 'delivered' ? 'selected' : ''; ?>>Hoàn thành</option>
                            </select>
                        </div>
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <!-- Nút cập nhật -->
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <!-- Nút quay lại danh sách đơn hàng -->
                            <a href="<?php echo BASE_URL; ?>admin.php?url=orders" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
// Nạp footer giao diện admin
include VIEWS_PATH . 'layouts/admin_footer.php'; 
?>