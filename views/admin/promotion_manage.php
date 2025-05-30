
<!-- views/admin/promotion_manage.php -->
<?php
// Đặt tiêu đề trang cho giao diện quản lý khuyến mãi
$page_title = 'Quản lý khuyến mãi';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <h2 class="mb-4">Quản lý khuyến mãi</h2>
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
    <!-- Thanh công cụ: Thêm khuyến mãi và tìm kiếm -->
    <div class="mb-3 d-flex justify-content-between">
        <!-- Nút thêm khuyến mãi mới -->
        <a href="<?php echo BASE_URL; ?>admin.php?url=promotions/create" class="btn btn-success">Thêm khuyến mãi</a>
        <!-- Form tìm kiếm khuyến mãi -->
        <form action="<?php echo BASE_URL; ?>admin.php?url=promotions" method="GET" class="d-flex">
            <input type="hidden" name="url" value="promotions">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm khuyến mãi..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-primary">Tìm</button>
        </form>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <!-- Bảng danh sách khuyến mãi -->
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Mã</th>
                            <th>Loại</th>
                            <th>Giá trị</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Hiển thị từng khuyến mãi -->
                        <?php if (isset($promotions) && !empty($promotions)): ?>
                            <?php foreach ($promotions as $promotion): ?>
                                <?php
                                // Xác định trạng thái khuyến mãi dựa vào ngày bắt đầu/kết thúc
                                $today = date('Y-m-d');
                                $status = $promotion['start_date'] > $today ? 'Chưa bắt đầu' :
                                          ($promotion['end_date'] < $today ? 'Hết hạn' : 'Đang hoạt động');
                                $status_class = $promotion['start_date'] > $today ? 'text-warning' :
                                                ($promotion['end_date'] < $today ? 'text-danger' : 'text-success');
                                ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($promotion['id']); ?></td>
                                    <td><?php echo htmlspecialchars($promotion['code']); ?></td>
                                    <td><?php echo htmlspecialchars($promotion['discount_type'] === 'percentage' ? 'Phần trăm' : 'Cố định'); ?></td>
                                    <td><?php echo htmlspecialchars($promotion['discount_value']) . ($promotion['discount_type'] === 'percentage' ? '%' : ' VND'); ?></td>
                                    <td><?php echo htmlspecialchars($promotion['start_date']); ?></td>
                                    <td><?php echo htmlspecialchars($promotion['end_date']); ?></td>
                                    <td><span class="<?php echo $status_class; ?>"><?php echo $status; ?></span></td>
                                    <td>
                                        <!-- Nút sửa khuyến mãi -->
                                        <a href="<?php echo BASE_URL; ?>admin.php?url=promotions/update/<?php echo $promotion['id']; ?>" class="btn btn-warning btn-sm me-1 update-promotion" data-id="<?php echo $promotion['id']; ?>">Sửa</a>
                                        <!-- Nút xóa khuyến mãi -->
                                        <a href="#" class="btn btn-danger btn-sm delete-promotion" data-id="<?php echo $promotion['id']; ?>">Xóa</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="8" class="text-center">Không có khuyến mãi nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Phân trang -->
            <?php if (isset($total_pages) && $total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <!-- Nút về trang trước -->
                        <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=promotions&page=<?php echo $current_page - 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>">Trước</a>
                        </li>
                        <!-- Hiển thị số trang -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=promotions&page=<?php echo $i; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <!-- Nút sang trang sau -->
                        <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=promotions&page=<?php echo $current_page + 1; ?><?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>">Sau</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>