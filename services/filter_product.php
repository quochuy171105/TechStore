<?php
// services/filter_product.php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../config/config.php';

$db = Database::getInstance();
$productModel = new Product($db);
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$brand_id = isset($_GET['brand_id']) ? (int)$_GET['brand_id'] : 0;
$price_min = isset($_GET['price_min']) ? (float)$_GET['price_min'] : 0;
$price_max = isset($_GET['price_max']) ? (float)$_GET['price_max'] : 0;
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';

$products = $productModel->getProducts(1, 10, $category_id, $brand_id, $price_min, $price_max, $sort);
$html = '';

foreach ($products as $product) {
    $html .= '<div class="col-12 col-sm-6 col-md-4 col-lg-3">';
    $html .= '    <div class="card product-card h-100">';
    $html .= '        <a href="' . BASE_URL . 'views/user/product_detail.php?id=' . $product['id'] . '" class="d-flex flex-column h-100 text-decoration-none">';
    $html .= '            <div class="product-img-wrapper">';
    $html .= '                <img src="' . IMAGES_PATH . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
    $html .= '            </div>';
    $html .= '            <div class="card-body d-flex flex-column">';
    $html .= '                <h5 class="card-title text-dark">' . htmlspecialchars($product['name']) . '</h5>';
    $html .= '                <p class="card-text text-danger fw-bold mt-auto">' . number_format($product['price'], 0, ',', '.') . ' VNĐ</p>';
    $html .= '                <div class="mt-auto">';
    $html .= '                    <span class="btn btn-gradient w-100">Xem chi tiết</span>';
    $html .= '                </div>';
    $html .= '            </div>';
    $html .= '        </a>';
    $html .= '    </div>';
    $html .= '</div>';
}

header('Content-Type: application/json');
echo json_encode(['html' => $html]);