<!-- views/admin/revenue.php -->
<?php
$page_title = 'Thống kê doanh thu';
$include_chart_js = true;
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <h2 class="mb-4">Thống kê doanh thu</h2>
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form id="revenue-filter" method="GET" action="<?php echo BASE_URL; ?>admin.php?url=revenue" class="row g-3">
                <div class="col-md-3">
                    <label for="start_date" class="form-label">Từ ngày</label>
                    <input type="date" name="start_date" id="start_date" class="form-control" value="<?php echo htmlspecialchars($start_date); ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="end_date" class="form-label">Đến ngày</label>
                    <input type="date" name="end_date" id="end_date" class="form-control" value="<?php echo htmlspecialchars($end_date); ?>" required>
                </div>
                <div class="col-md-3">
                    <label for="chart-type" class="form-label">Loại biểu đồ</label>
                    <select name="chart_type" id="chart-type" class="form-control">
                        <option value="line">Đường</option>
                        <option value="bar">Cột</option>
                        <option value="area">Khu vực</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary flex-grow-1">Lọc</button>
                    <button type="button" id="reset-filter" class="btn btn-secondary flex-grow-1">Đặt lại</button>
                </div>
            </form>
        </div>
    </div>
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title">Tổng doanh thu: <span id="total-revenue"><?php echo number_format($total_revenue, 0, ',', '.'); ?></span></h5>
            
            <div style="position: relative; height: 400px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Debug section -->
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