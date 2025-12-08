
<!-- views/admin/product_manage.php -->
<?php
// Đặt tiêu đề trang cho giao diện quản lý sản phẩm
$page_title = 'Quản lý sản phẩm';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
// Giải nén mảng data để dễ sử dụng các biến trong view
if (isset($data) && is_array($data)) { extract($data); }
?>
<div class="container-fluid py-4">
    <h2 class="mb-4">Quản lý sản phẩm</h2>
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
    <!-- Thanh công cụ: Thêm sản phẩm và tìm kiếm -->
    <div class="mb-3 d-flex justify-content-between">
        <!-- Nút thêm sản phẩm mới -->
        <a href="<?php echo BASE_URL; ?>admin.php?url=products/create" class="btn btn-success">Thêm sản phẩm</a>
        <!-- Form tìm kiếm sản phẩm -->
        <form action="<?php echo BASE_URL; ?>admin.php?url=products" method="get" class="d-flex">
            <input type="hidden" name="url" value="products">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button type="submit" class="btn btn-gradient">Tìm</button>
        </form>
    </div>
    
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="table-responsive">
                <!-- Bảng danh sách sản phẩm -->
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th style="width: 5%;">ID</th>
                            <th style="width: 15%;">Tên</th>
                            <th style="width: 10%;">Danh mục</th>
                            <th style="width: 10%;">Thương hiệu</th>
                            <th style="width: 20%;">Mô tả</th>
                            <th style="width: 20%;">Thuộc tính</th>
                            <th style="width: 10%;">Giá (VND)</th>
                            <th style="width: 5%;">Tồn kho</th>
                            <th style="width: 15%;">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Hiển thị từng sản phẩm -->
                        <?php if (isset($products) && !empty($products)): ?>
                            <?php foreach ($products as $product): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['id']); ?></td>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['category_name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['brand_name']); ?></td>
                                    <td class="desc-cell"><?php echo htmlspecialchars($product['description']); ?></td>
                                    <td class="attr-cell">
                                        <?php
                                        // Lấy và hiển thị các thuộc tính sản phẩm
                                        $attributes = $this->productModel->getAttributes($product['id']);
                                        echo implode('<br>', array_map(function($attr) {
                                            return htmlspecialchars($attr['attribute_name']) . ': ' . htmlspecialchars($attr['attribute_value']);
                                        }, $attributes));
                                        ?>
                                    </td>
                                    <td><?php echo number_format($product['price'], 2); ?></td>
                                    <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                    <td>
                                        <!-- Nút sửa sản phẩm -->
                                        <a href="<?php echo BASE_URL; ?>admin.php?url=products/update/<?php echo $product['id']; ?>" class="btn btn-warning btn-sm me-1 update-product" data-id="<?php echo $product['id']; ?>">Sửa</a>
                                        <!-- Nút xóa sản phẩm -->
                                        <a href="#" class="btn btn-danger btn-sm delete-product" data-id="<?php echo $product['id']; ?>">Xóa</a>
                                    </td>  
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="7" class="text-center">Không có sản phẩm nào.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <!-- Phân trang sản phẩm -->
            <?php if (isset($total_pages) && $total_pages > 1): ?>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center mt-4">
                        <!-- Nút về trang trước -->
                        <li class="page-item <?php echo $current_page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=products&page=<?php echo $current_page - 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Trước</a>
                        </li>
                        <!-- Hiển thị số trang -->
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <li class="page-item <?php echo $i == $current_page ? 'active' : ''; ?>">
                                <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=products&page=<?php echo $i; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                        <!-- Nút sang trang sau -->
                        <li class="page-item <?php echo $current_page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="<?php echo BASE_URL; ?>admin.php?url=products&page=<?php echo $current_page + 1; ?><?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?>">Sau</a>
                        </li>
                    </ul>
                </nav>
            <?php endif; ?>
        </div>
    </div>
</div>
<style>
    /* Giới hạn chiều rộng mô tả và thuộc tính để bảng gọn gàng */
    .desc-cell {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .attr-cell {
        max-width: 150px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
</style>
<script>
    // Khởi tạo tooltip của Bootstrap (nếu có sử dụng tooltip)
    $(document).ready(function() {
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>