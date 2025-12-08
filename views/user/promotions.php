<div class="container-fluid px-3 px-md-4 my-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 text-center text-md-start">Danh sách voucher/khuyến mãi</h2>
        </div>
    </div>

    <?php if (!empty($promotions)): ?>

        <!-- Desktop View - Hidden on mobile -->
        <div class="d-none d-lg-block">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-blue">
                        <tr>
                            <th>Mã code</th>
                            <th>Loại giảm</th>
                            <th>Giá trị</th>
                            <th>Bắt đầu</th>
                            <th>Kết thúc</th>
                            <th>Đơn tối thiểu</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($promotions as $promo): ?>
                            <tr>
                                <td><code class="bg-light px-2 py-1 rounded"><?= htmlspecialchars($promo['code']) ?></code></td>
                                <td><?= htmlspecialchars($promo['discount_type']) ?></td>
                                <td class="fw-bold text-primary">
                                    <?= $promo['discount_type'] == 'percentage'
                                        ? $promo['discount_value'] . '%'
                                        : number_format($promo['discount_value']) . '₫' ?>
                                </td>
                                <td><?= date('d/m/Y', strtotime($promo['start_date'])) ?></td>
                                <td><?= date('d/m/Y', strtotime($promo['end_date'])) ?></td>
                                <td><?= number_format($promo['min_order_amount']) ?>₫</td>
                                <td>
                                    <?php
                                    $today = strtotime(date('Y-m-d'));
                                    $start = strtotime($promo['start_date']);
                                    $end   = strtotime($promo['end_date']);

                                    if ($today < $start) {
                                        echo '<span class="badge bg-warning text-dark">Chưa bắt đầu</span>';
                                    } elseif ($today > $end) {
                                        echo '<span class="badge bg-danger">Hết hạn</span>';
                                    } else {
                                        echo '<span class="badge bg-success">Có thể dùng</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile/Tablet Card View - Hidden on desktop -->
        <div class="d-lg-none">
            <div class="row g-3">
                <?php foreach ($promotions as $promo): ?>
                    <div class="col-12 col-md-6">
                        <div class="card h-100 shadow-sm border-0">
                            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                                <code class="bg-white text-primary px-2 py-1 rounded"><?= htmlspecialchars($promo['code']) ?></code>
                                <?php
                                $today = strtotime(date('Y-m-d'));
                                $start = strtotime($promo['start_date']);
                                $end   = strtotime($promo['end_date']);

                                if ($today < $start) {
                                    echo '<span class="badge bg-warning text-dark">Chưa bắt đầu</span>';
                                } elseif ($today > $end) {
                                    echo '<span class="badge bg-danger">Hết hạn</span>';
                                } else {
                                    echo '<span class="badge bg-success">Có thể dùng</span>';
                                }
                                ?>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <small class="text-muted d-block">Loại giảm</small>
                                        <span class="fw-medium"><?= htmlspecialchars($promo['discount_type']) ?></span>
                                    </div>
                                    <div class="col-6">
                                        <small class="text-muted d-block">Giá trị</small>
                                        <span class="fw-bold text-primary fs-5">
                                            <?= $promo['discount_type'] == 'percentage'
                                                ? $promo['discount_value'] . '%'
                                                : number_format($promo['discount_value']) . '₫' ?>
                                        </span>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <small class="text-muted d-block">Bắt đầu</small>
                                        <span class="fw-medium"><?= date('d/m/Y', strtotime($promo['start_date'])) ?></span>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <small class="text-muted d-block">Kết thúc</small>
                                        <span class="fw-medium"><?= date('d/m/Y', strtotime($promo['end_date'])) ?></span>
                                    </div>
                                    <div class="col-12 mt-3">
                                        <small class="text-muted d-block">Đơn tối thiểu</small>
                                        <span class="fw-bold text-success"><?= number_format($promo['min_order_amount']) ?>₫</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

    <?php else: ?>
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="alert alert-info text-center py-4">
                    <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                    <h5>Không có voucher khả dụng</h5>
                    <p class="mb-0">Hiện tại chưa có voucher nào được phát hành.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Promotion styles moved to assets/css/style.css -->