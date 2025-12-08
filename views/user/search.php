<?php
// views/user/search.php
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../config/config.php';

$db = Database::getInstance();
$productController = new ProductController($db);
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$categories = (new Category($db))->getAllCategories();
$products = $productController->searchProducts($query, $category_id);
include __DIR__ . '/../layouts/header.php';
?>

<div class="container">
    <meta name="description" content="Kết quả tìm kiếm cho '<?= htmlspecialchars($query) ?>' - Cửa hàng điện tử">
    <meta name="keywords" content="tìm kiếm, sản phẩm, công nghệ, <?= htmlspecialchars($query) ?>">
    <title>Kết quả tìm kiếm - Cửa hàng điện tử</title>
    <div>


    </div>
    <h2 class="mb-4">Kết quả tìm kiếm cho: <?= htmlspecialchars($query) ?></h2>
    <form class="mb-4" id="search-filter-form" method="GET" action="">
        <div class="row">
            <div class="col-md-6">
                <input type="text" name="q" class="form-control" value="<?= htmlspecialchars($query) ?>" placeholder="Tìm kiếm...">
            </div>

        </div>
    </form>
    <div class="row" id="search-results">
        <?php if (empty($products)): ?>
            <p>Không tìm thấy sản phẩm nào.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-6 col-sm-6 col-md-3 mb-3">
                    <div class="card product-card h-100">
                        <div class="product-img-wrapper">
                            <img src="<?= IMAGES_PATH . htmlspecialchars($product['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['name']) ?>" loading="lazy">
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><?= number_format($product['price'], 2) ?> VNĐ</p>
                            <a href="<?= BASE_URL ?>views/user/product_detail.php?id=<?= $product['id'] ?>" class="btn btn-gradient w-100">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/categories.css">

</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>