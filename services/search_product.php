<?php
// services/search_product.php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../config/config.php';

header('Content-Type: application/json');

$pdo = Database::getInstance();
$productModel = new Product($pdo);
$query = isset($_GET['q']) ? trim($_GET['q']) : '';
$html = '';
$success = false;

if (!empty($query)) {
    // Giới hạn kết quả trả về là 5 để làm gợi ý
    $products = $productModel->searchProducts($query, 0, 5);

    if (!empty($products)) {
        $success = true;
        $html .= '<ul class="list-group">';
        foreach ($products as $product) {
            $product_url = BASE_URL . 'views/user/product_detail.php?id=' . $product['id'];
            $image_url = IMAGES_PATH . htmlspecialchars($product['image']);
            $product_name = htmlspecialchars($product['name']);
            $product_price = number_format($product['price'], 0, ',', '.') . ' ₫';

            $html .= '<li class="list-group-item list-group-item-action">';
            $html .= '<a href="' . $product_url . '" class="d-flex align-items-center text-decoration-none text-dark">';
            $html .= '<img src="' . $image_url . '" alt="' . $product_name . '" style="width: 50px; height: 50px; object-fit: cover; margin-right: 15px;">';
            $html .= '<div>';
            $html .= '<h6 class="mb-0">' . $product_name . '</h6>';
            $html .= '<p class="mb-0 text-danger">' . $product_price . '</p>';
            $html .= '</div>';
            $html .= '</a>';
            $html .= '</li>';
        }
        $html .= '</ul>';
    }
}

echo json_encode(['success' => $success, 'html' => $html]);