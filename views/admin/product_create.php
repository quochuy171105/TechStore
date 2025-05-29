<!-- views/admin/product_create.php -->
<?php
$page_title = isset($product) ? 'Sửa sản phẩm' : 'Thêm sản phẩm';
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4"><?php echo $page_title; ?></h2>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($error); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <form id="product-create-form" method="POST" enctype="multipart/form-data">
                        <?php if (isset($product)): ?>
                            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                            <input type="hidden" name="existing_image" value="<?php echo htmlspecialchars($product['image']); ?>">
                        <?php endif; ?>
                        
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="category_id" class="form-label">Danh mục</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="">Chọn danh mục</option>
                                    <?php foreach ($categories as $category): ?>
                                        <option value="<?php echo $category['id']; ?>" <?php echo isset($product) && $product['category_id'] == $category['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="brand_id" class="form-label">Thương hiệu</label>
                                <select class="form-select" id="brand_id" name="brand_id" required>
                                    <option value="">Chọn thương hiệu</option>
                                    <?php foreach ($brands as $brand): ?>
                                        <option value="<?php echo $brand['id']; ?>" <?php echo isset($product) && $product['brand_id'] == $brand['id'] ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($brand['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm</label>
                            <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($product) ? htmlspecialchars($product['name']) : ''; ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?php echo isset($product) ? htmlspecialchars($product['description']) : ''; ?></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-12 col-md-6 mb-3">
                                <label for="price" class="form-label">Giá (VND)</label>
                                <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo isset($product) ? $product['price'] : ''; ?>" required>
                            </div>
                            <div class="col-12 col-md-6 mb-3">
                                <label for="stock" class="form-label">Tồn kho</label>
                                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo isset($product) ? $product['stock'] : ''; ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Hình ảnh</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <?php if (isset($product) && $product['image']): ?>
                                <div class="mt-2">
                                    <img src="<?php echo IMAGES_PATH . htmlspecialchars($product['image']); ?>" alt="Current image" class="img-thumbnail" style="max-width: 200px; height: auto;">
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Phần thuộc tính động -->
                        <div class="mb-3">
                            <label class="form-label">Thuộc tính sản phẩm</label>
                            <div id="attributes-container">
                                <?php if (isset($product_attributes) && !empty($product_attributes)): ?>
                                    <?php foreach ($product_attributes as $index => $attr): ?>
                                        <div class="attribute-row mb-2">
                                            <div class="row g-2">
                                                <div class="col-12 col-sm-5">
                                                    <input type="text" class="form-control" name="attributes[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($attr['attribute_name']); ?>" placeholder="Tên thuộc tính (VD: RAM)" required>
                                                </div>
                                                <div class="col-12 col-sm-5">
                                                    <input type="text" class="form-control" name="attributes[<?php echo $index; ?>][value]" value="<?php echo htmlspecialchars($attr['attribute_value']); ?>" placeholder="Giá trị (VD: 8GB)" required>
                                                </div>
                                                <div class="col-12 col-sm-2">
                                                    <button type="button" class="btn btn-danger w-100 remove-attribute">Xóa</button>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <div class="attribute-row mb-2">
                                        <div class="row g-2">
                                            <div class="col-12 col-sm-5">
                                                <input type="text" class="form-control" name="attributes[0][name]" placeholder="Tên thuộc tính (VD: RAM)" required>
                                            </div>
                                            <div class="col-12 col-sm-5">
                                                <input type="text" class="form-control" name="attributes[0][value]" placeholder="Giá trị (VD: 8GB)" required>
                                            </div>
                                            <div class="col-12 col-sm-2">
                                                <button type="button" class="btn btn-danger w-100 remove-attribute">Xóa</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <button type="button" id="add-attribute" class="btn btn-outline-primary mt-2">Thêm thuộc tính</button>
                        </div>
                        
                        <div class="d-flex flex-column flex-sm-row gap-2">
                            <button type="submit" class="btn btn-primary"><?php echo isset($product) ? 'Cập nhật' : 'Thêm'; ?> sản phẩm</button>
                            <a href="<?php echo BASE_URL; ?>admin.php?url=products" class="btn btn-secondary">Hủy</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>