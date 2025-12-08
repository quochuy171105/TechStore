<?php
// views/user/home.php
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../config/config.php';

$db = Database::getInstance();
$productController = new ProductController($db);
$featuredProducts = $productController->getFeaturedProducts(8);
$recommendedProducts = $productController->getRecommendedProducts(8);
$categories = (new Category($db))->getAllCategories();
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>
<div class="container">
    <meta name="description" content="Khám phá các sản phẩm công nghệ mới nhất tại cửa hàng điện tử của chúng tôi">
    <meta name="keywords" content="điện thoại, laptop, phụ kiện, công nghệ, khuyến mãi">
    <title>Trang chủ - Cửa hàng điện tử</title>

    <!-- Carousel Banner -->
    <div id="bannerCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <video class="d-block w-100" autoplay loop muted playsinline>
                    <source src="<?= IMAGES_PATH ?>banners/watch.mp4" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ video.
                </video>
            </div>
            <div class="carousel-item">
                <video class="d-block w-100" autoplay loop muted playsinline>
                    <source src="<?= IMAGES_PATH ?>banners/xlarge_2x.mp4" type="video/mp4">
                    Trình duyệt của bạn không hỗ trợ video.
                </video>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Danh mục gợi ý -->
    <h3 class="mb-4 text-center">Khám phá danh mục</h3>
    <div class="row mb-4">
        <?php foreach ($categories as $category): ?>
            <div class="col-6 col-sm-6 col-md-3 mb-3">
                <a href="<?= BASE_URL ?>views/user/product_list.php?category_id=<?= htmlspecialchars($category['id']) ?>" class="card category-card text-center text-decoration-none h-100 d-flex align-items-center justify-content-center">
                    <div class="card-body p-3 d-flex align-items-center justify-content-center">
                        <h5 class="card-title mb-0 text-truncate" title="<?= htmlspecialchars($category['name']) ?>" style="color:#222; font-size:1rem; font-weight:500; width:100%;">
                            <?= htmlspecialchars($category['name']) ?>
                        </h5>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
    <style>
        .category-card {
            border-radius: 1rem;
            background: #fff;
            border: 1px solid #e3e6ea;
            box-shadow: 0 1px 4px 0 #0000000d;
            transition: box-shadow 0.15s, border 0.15s;
            min-height: 60px;
        }
        .category-card:hover, .category-card:focus {
            border-color: #0d6efd;
            box-shadow: 0 2px 12px 0 #0d6efd22;
            text-decoration: none;
        }
        .category-card .card-body {
            padding: 0.8rem 0.5rem;
        }
        .category-card .card-title {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        @media (max-width: 576px) {
            .category-card .card-body {
                padding: 0.6rem 0.3rem;
            }
            .category-card .card-title {
                font-size: 0.95rem;
            }
        }
    </style>

    <!-- Sản phẩm nổi bật -->
    <h3 class="mb-4 text-center">Sản phẩm nổi bật</h3>
    <div class="row mb-4">
        <?php foreach ($featuredProducts as $product): ?>
            <div class="col-6 col-sm-6 col-md-3 mb-3">
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

    <!-- Sản phẩm đề xuất -->
    <h3 class="mb-4 text-center">Dành cho bạn</h3>
     <div class="row mb-4" id="product-list">
        <?php foreach ($recommendedProducts as $product): ?>
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
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/categories.css">

</div>
<?php include __DIR__ . '/../layouts/footer.php'; ?>