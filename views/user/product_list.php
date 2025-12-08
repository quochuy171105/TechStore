<?php
// views/user/product_list.php
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../config/config.php';

$db = Database::getInstance();
$productController = new ProductController($db);

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$brand_id = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : 0;
$price_min = isset($_GET['price_min']) ? (float)$_GET['price_min'] : 0;
$price_max = isset($_GET['price_max']) ? (float)$_GET['price_max'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

$products = $productController->getProducts($page, 10, $category_id, $brand_id, $price_min, $price_max, $sort);
$totalPages = $productController->getTotalPages(10, $category_id, $brand_id, $price_min, $price_max);

$categories = (new Category($db))->getAllCategories();
$brands = $db->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
include __DIR__ . '/../layouts/header.php';
?>


<div class="container">
    <meta name="description" content="Danh sách sản phẩm công nghệ mới nhất với các bộ lọc theo danh mục, giá, thương hiệu">
    <meta name="keywords" content="sản phẩm, công nghệ, điện thoại, laptop, phụ kiện">
    <title>Danh sách sản phẩm - Cửa hàng điện tử</title>

    <div class="d-flex justify-content-between align-items-center mb-3 position-relative z-index-1">
        <h2 class="page-title mb-0">Danh sách sản phẩm</h2>
        <button class="btn btn-gradient w-70 " type="text" data-bs-toggle="offcanvas" data-bs-target="#offcanvasFilter" aria-controls="offcanvasFilter">
            <i class="fas fa-filter me-2"></i>Bộ lọc
        </button>
    </div>

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasFilter" aria-labelledby="offcanvasFilterLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasFilterLabel">Bộ lọc sản phẩm</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="filter-form">
                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_id" class="form-select">
                        <option value="0">Tất cả</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>" <?= $category_id == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thương hiệu</label>
                    <select name="brand_id" class="form-select">
                        <option value="0">Tất cả</option>
                        <?php foreach ($brands as $brand): ?>
                            <option value="<?= $brand['id'] ?>" <?= $brand_id == $brand['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($brand['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá từ</label>
                    <input type="number" name="price_min" class="form-control" value="<?= $price_min ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá đến</label>
                    <input type="number" name="price_max" class="form-control" value="<?= $price_max ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Sắp xếp</label>
                    <select name="sort" class="form-select">
                        <option value="newest" <?= $sort == 'newest' ? 'selected' : '' ?>>Mới nhất</option>
                        <option value="price_asc" <?= $sort == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                        <option value="price_desc" <?= $sort == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-gradient w-100">Lọc sản phẩm</button>
            </form>
        </div>
    </div>

    <div class="row">
        <!-- Danh sách sản phẩm -->
        <div class="mb-4 text-center">
            <div class="row mb-4" id="product-list">
                <?php foreach ($products as $product): ?>
                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card product-card h-100">
                            <div class="product-img-wrapper">
                                <img src="<?= IMAGES_PATH . htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy" onerror="this.src='<?= BASE_URL ?>assets/images/fallback-image.png'">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                                <p class="card-text text-danger fw-bold mt-auto"><?= number_format($product['price'], 0, ',', '.') ?> VNĐ</p>
                                <a href="<?= BASE_URL ?>views/user/product_detail.php?id=<?= htmlspecialchars($product['id']) ?>" class="btn btn-gradient w-100">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/categories.css">
    </div>

</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>