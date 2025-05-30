<!-- views/admin/dashboard.php -->
<?php
// Đặt tiêu đề trang cho giao diện admin
$page_title = 'Tổng quan';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<style>
    .container-fluid {
        background: rgba(255, 255, 255, 0);
        /* Nền trắng */
        color: #5a5c69;
        /* Chữ xám đậm */
        font-family: 'Nunito', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
    }

    .stats-card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s ease;
    }

    .stats-card:hover {
        transform: translateY(-3px);
    }

    .stats-card .card-body {
        padding: 1.5rem;
    }

    .stats-card .card-title {
        font-size: 1rem;
        color: #5a5c69;
        margin-bottom: 0.5rem;
    }

    .stats-card .card-text {
        font-size: 1.5rem;
        font-weight: bold;
    }

    .data-table {
        background: #fff;
        border-radius: 10px;
        padding: 1.5rem;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 1.5rem;
    }

    .table {
        background: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        color: #5a5c69;
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f3f5;
    }

    .btn-quick-action {
        background: #4e73df;
        color: #fff;
        border-radius: 5px;
        transition: background-color 0.2s ease;
    }

    .btn-quick-action:hover {
        background: #2e59d9;
        color: #fff;
    }

    h2,
    h4 {
        color: #4e73df;
        font-weight: 600;
    }
</style>
<div class="container-fluid py-4">
    <h2 class="mb-4">Tổng quan</h2>

    <!-- Thẻ thống kê tổng quan: doanh thu, đơn hàng, sản phẩm, khách hàng -->
    <div class="row mb-4">
        <!-- Tổng doanh thu -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-primary">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-dollar-sign mr-2"></i> Tổng doanh thu</h5>
                    <!-- Hiển thị tổng doanh thu (đơn vị triệu VND) -->
                    <p class="card-text text-primary"><?php echo isset($data['total_revenue']) ? number_format($data['total_revenue'] / 1000000, 2) : '0'; ?> triệu VND</p>
                </div>
            </div>
        </div>
        <!-- Tổng đơn hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-shopping-cart mr-2"></i> Tổng đơn hàng</h5>
                    <p class="card-text text-success"><?php echo isset($data['total_orders']) ? $data['total_orders'] : '0'; ?></p>
                </div>
            </div>
        </div>
        <!-- Tổng sản phẩm -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-info">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-box mr-2"></i> Tổng sản phẩm</h5>
                    <p class="card-text text-info"><?php echo isset($data['total_products']) ? $data['total_products'] : '0'; ?></p>
                </div>
            </div>
        </div>
        <!-- Tổng khách hàng -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card border-left-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users mr-2"></i> Tổng khách hàng</h5>
                    <p class="card-text text-warning"><?php echo isset($data['total_users']) ? $data['total_users'] : '0'; ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Các nút hành động nhanh cho admin -->
    <div class="row mb-4">
        <div class="col-12">
            <h4 class="mb-3">Hành động nhanh</h4>
            <div class="d-flex gap-2 flex-wrap">
                <!-- Thêm sản phẩm mới -->
                <a href="<?php echo BASE_URL; ?>admin.php?url=products/create" class="btn btn-quick-action">Thêm sản phẩm</a>
                <!-- Quản lý đơn hàng -->
                <a href="<?php echo BASE_URL; ?>admin.php?url=orders" class="btn btn-quick-action">Quản lý đơn hàng</a>
                <!-- Quản lý khuyến mãi -->
                <a href="<?php echo BASE_URL; ?>admin.php?url=promotions" class="btn btn-quick-action">Quản lý khuyến mãi</a>
                <!-- Xem thống kê doanh thu -->
                <a href="<?php echo BASE_URL; ?>admin.php?url=revenue" class="btn btn-quick-action">Xem doanh thu</a>
            </div>
        </div>
    </div>

    <!-- Bảng thống kê doanh thu 7 ngày gần nhất -->
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="data-table">
                <h5 class="mb-3">Doanh thu 7 ngày gần nhất</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ngày</th>
                                <th>Doanh thu (VND)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recent_revenue'])): ?>
                                <?php foreach ($data['recent_revenue'] as $rev): ?>
                                    <tr>
                                        <td><?php echo date('d/m/Y', strtotime($rev['date'])); ?></td>
                                        <td><?php echo number_format($rev['total'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="2" class="text-center">Không có dữ liệu doanh thu.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Bảng thống kê trạng thái đơn hàng -->
        <div class="col-md-6 mb-4">
            <div class="data-table">
                <h5 class="mb-3">Trạng thái đơn hàng</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Trạng thái</th>
                                <th>Số đơn</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Chờ xử lý</td>
                                <td><?php echo $data['order_status_counts']['pending']; ?></td>
                            </tr>
                            <tr>
                                <td>Đang xử lý</td>
                                <td><?php echo $data['order_status_counts']['processing']; ?></td>
                            </tr>
                            <tr>
                                <td>Đã giao</td>
                                <td><?php echo $data['order_status_counts']['shipped']; ?></td>
                            </tr>
                            <tr>
                                <td>Hoàn thành</td>
                                <td><?php echo $data['order_status_counts']['delivered']; ?></td>
                            </tr>
                            <tr>
                                <td>Đã hủy</td>
                                <td><?php echo $data['order_status_counts']['cancelled']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Danh sách khách hàng mới nhất, có tìm kiếm và phân trang -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0">
                <div class="card-body">
                    <h4 class="mb-3">Danh sách khách hàng</h4>
                    <!-- Form tìm kiếm khách hàng -->
                    <form action="<?php echo BASE_URL; ?>admin.php?url=dashboard" method="get" class="d-flex mb-3">
                        <input type="hidden" name="url" value="dashboard">
                        <input type="text" name="search_customer" class="form-control me-2" placeholder="Tìm kiếm khách hàng..." value="<?php echo isset($data['search_customer']) ? htmlspecialchars($data['search_customer']) : ''; ?>">
                        <button type="submit" class="btn btn-primary">Tìm</button>
                    </form>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Ngày đăng ký</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Hiển thị danh sách khách hàng -->
                                <?php if (!empty($data['customers'])): ?>
                                    <?php foreach ($data['customers'] as $customer): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($customer['id']); ?></td>
                                            <td><?php echo htmlspecialchars($customer['name']); ?></td>
                                            <td><?php echo htmlspecialchars($customer['email']); ?></td>
                                            <td><?php echo htmlspecialchars($customer['phone'] ?: 'N/A'); ?></td>
                                            <td><?php echo date('d/m/Y', strtotime($customer['created_at'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="text-center">Không có khách hàng nào phù hợp.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- Phân trang khách hàng -->
                    <?php if (isset($data['total_customer_pages']) && $data['total_customer_pages'] > 1): ?>
                        <nav aria-label="Customer pagination">
                            <ul class="pagination justify-content-center mt-4">
                                <!-- Nút về trang trước -->
                                <li class="page-item <?php echo $data['current_page'] <= 1 ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=dashboard&page=<?php echo $data['current_page'] - 1; ?><?php echo isset($data['search_customer']) ? '&search_customer=' . urlencode($data['search_customer']) : ''; ?>">Trước</a>
                                </li>
                                <!-- Hiển thị số trang -->
                                <?php for ($i = 1; $i <= $data['total_customer_pages']; $i++): ?>
                                    <li class="page-item <?php echo $i == $data['current_page'] ? 'active' : ''; ?>">
                                        <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=dashboard&page=<?php echo $i; ?><?php echo isset($data['search_customer']) ? '&search_customer=' . urlencode($data['search_customer']) : ''; ?>"><?php echo $i; ?></a>
                                    </li>
                                <?php endfor; ?>
                                <!-- Nút sang trang sau -->
                                <li class="page-item <?php echo $data['current_page'] >= $data['total_customer_pages'] ? 'disabled' : ''; ?>">
                                    <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=dashboard&page=<?php echo $data['current_page'] + 1; ?><?php echo isset($data['search_customer']) ? '&search_customer=' . urlencode($data['search_customer']) : ''; ?>">Sau</a>
                                </li>
                            </ul>
                        </nav>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Nạp footer giao diện admin
include VIEWS_PATH . 'layouts/admin_footer.php';
?>