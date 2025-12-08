
<!-- views/admin/revenue.php -->
<?php
// Đặt tiêu đề trang cho giao diện thống kê doanh thu
$page_title = 'Thống kê doanh thu';
// Biến để xác định có nạp thư viện chart.js không
$include_chart_js = true;
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <h2 class="mb-4">Thống kê doanh thu</h2>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <!-- Form lọc doanh thu -->
            <form id="revenue-filter" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="filter_type" class="form-label fw-bold">Lọc theo</label>
                    <select id="filter_type" name="filter_type" class="form-select">
                        <option value="range" <?php echo (!isset($_GET['filter_type']) || $_GET['filter_type'] == 'range') ? 'selected' : ''; ?>>Khoảng ngày</option>
                        <option value="month" <?php echo (isset($_GET['filter_type']) && $_GET['filter_type'] == 'month') ? 'selected' : ''; ?>>Theo tháng</option>
                        <option value="year" <?php echo (isset($_GET['filter_type']) && $_GET['filter_type'] == 'year') ? 'selected' : ''; ?>>Theo năm</option>
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div class="col-md-6" id="range_filter_group">
                    <div class="row">
                        <div class="col">
                            <label for="start_date" class="form-label">Từ ngày</label>
                            <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($_GET['start_date'] ?? date('Y-m-01')); ?>">
                        </div>
                        <div class="col">
                            <label for="end_date" class="form-label">Đến ngày</label>
                            <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($_GET['end_date'] ?? date('Y-m-t')); ?>">
                        </div>
                    </div>
                </div>

                <!-- Month Filter -->
                <div class="col-md-2" id="month_filter_group" style="display: none;">
                    <label for="month" class="form-label">Chọn tháng</label>
                    <input type="month" name="month" id="month" class="form-control" value="<?php echo htmlspecialchars($_GET['month'] ?? date('Y-m')); ?>">
                </div>

                <!-- Year Filter -->
                <div class="col-md-2" id="year_filter_group" style="display: none;">
                    <label for="year" class="form-label">Chọn năm</label>
                    <input type="number" name="year" id="year" class="form-control" min="2020" max="<?php echo date('Y'); ?>" value="<?php echo htmlspecialchars($_GET['year'] ?? date('Y')); ?>">
                </div>

                <div class="col-md-2">
                    <label for="chart-type" class="form-label">Loại biểu đồ</label>
                    <select name="chart_type" id="chart-type" class="form-select">
                        <option value="bar" <?php echo (isset($_GET['chart_type']) && $_GET['chart_type'] == 'bar') ? 'selected' : ''; ?>>Cột</option>
                        <option value="line" <?php echo (isset($_GET['chart_type']) && $_GET['chart_type'] == 'line') ? 'selected' : ''; ?>>Đường</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <button type="submit" class="btn btn-gradient w-100">Lọc</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <!-- Hiển thị tổng doanh thu -->
            <h5 class="card-title">Tổng doanh thu: <span id="total-revenue"><?php echo number_format($total_revenue, 0, ',', '.'); ?></span></h5>
            
            <!-- Vùng hiển thị biểu đồ doanh thu -->
            <div style="position: relative; height: 400px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Debug section (ẩn, chỉ dùng cho phát triển) -->
<div class="container-fluid mt-4" style="display: none;" id="debug-section">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Debug Information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h6>Revenue Data:</h6>
                    <pre id="debug-data"><?php echo isset($revenue_data) ? print_r($revenue_data, true) : 'No data'; ?></pre>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>