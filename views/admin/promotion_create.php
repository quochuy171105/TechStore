
<!-- views/admin/promotion_create.php -->
<?php
// Đặt tiêu đề trang cho giao diện thêm/sửa khuyến mãi
$page_title = isset($promotion) ? 'Sửa khuyến mãi' : 'Thêm khuyến mãi';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <!-- Tiêu đề trang -->
            <h2 class="mb-4"><?php echo $page_title; ?></h2>
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
                    <!-- Form thêm/sửa khuyến mãi -->
                    <form id="promotion-create-form" method="POST">
                        <?php if (isset($promotion)): ?>
                            <!-- Nếu là sửa thì truyền id khuyến mãi -->
                            <input type="hidden" name="id" value="<?php echo $promotion['id']; ?>">
                        <?php endif; ?>
                        
                        <div class="mb-3">
                            <!-- Nhập mã khuyến mãi -->
                            <label for="code" class="form-label">Mã khuyến mãi</label>
                            <input type="text" class="form-control" id="code" name="code" value="<?php echo isset($promotion) ? htmlspecialchars($promotion['code']) : ''; ?>" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <!-- Chọn loại khuyến mãi -->
                                <label for="discount_type" class="form-label">Loại khuyến mãi</label>
                                <select class="form-select" id="discount_type" name="discount_type" required>
                                    <option value="percentage" <?php echo isset($promotion) && $promotion['discount_type'] === 'percentage' ? 'selected' : ''; ?>>Phần trăm</option>
                                    <option value="fixed" <?php echo isset($promotion) && $promotion['discount_type'] === 'fixed' ? 'selected' : ''; ?>>Cố định</option>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <!-- Nhập giá trị khuyến mãi -->
                                <label for="discount_value" class="form-label">Giá trị khuyến mãi</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discount_value" name="discount_value" step="0.01" value="<?php echo isset($promotion) ? $promotion['discount_value'] : ''; ?>" required>
                                    <span class="input-group-text" id="discount_value_unit"><?php echo isset($promotion) && $promotion['discount_type'] === 'percentage' ? '%' : 'VND'; ?></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <!-- Ngày bắt đầu khuyến mãi -->
                                <label for="start_date" class="form-label">Ngày bắt đầu</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo isset($promotion) ? $promotion['start_date'] : ''; ?>" required min="<?php echo isset($promotion) ? '' : date('Y-m-d'); ?>">
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <!-- Ngày kết thúc khuyến mãi -->
                                <label for="end_date" class="form-label">Ngày kết thúc</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo isset($promotion) ? $promotion['end_date'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <!-- Nhập số tiền đơn hàng tối thiểu để áp dụng khuyến mãi -->
                            <label for="min_order_amount" class="form-label">Số tiền đơn hàng tối thiểu (VND)</label>
                            <input type="number" class="form-control" id="min_order_amount" name="min_order_amount" step="0.01" value="<?php echo isset($promotion) ? $promotion['min_order_amount'] : ''; ?>">
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <!-- Nút lưu khuyến mãi -->
                            <button type="submit" class="btn btn-primary"><?php echo isset($promotion) ? 'Cập nhật' : 'Thêm'; ?> khuyến mãi</button>
                            <!-- Nút quay lại danh sách khuyến mãi -->
                            <a href="<?php echo BASE_URL; ?>admin.php?url=promotions" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>