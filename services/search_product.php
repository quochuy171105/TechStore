<?php
// services/search_product.php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../config/config.php';

$db = new Database();
$productModel = new Product($db->getConnection());
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;

$products = $productModel->searchProducts($query, $category_id);
$html = '';

foreach ($products as $product) {
    $html .= '<div class="col-md-3 col-sm-6 mb-3">';
    $html .= '<div class="card">';
    $html .= '<img src="' . IMAGES_PATH . htmlspecialchars($product['image']) . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '" loading="lazy">';
    $html .= '<div class="card-body">';
    $html .= '<h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>';
    $html .= '<p class="card-text">' . number_format($product['price'], 2) . ' USD</p>';
    $html .= '<a href="' . BASE_URL . 'views/user/product_detail.php?id=' . $product['id'] . '" class="btn btn-primary">Xem chi tiết</a>';
    $html .= '</div></div></div>';
}

header('Content-Type: application/json');
echo json_encode(['html' => $html]);