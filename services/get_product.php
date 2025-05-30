<?php
// services/get_product.php
require_once __DIR__ . '/../models/Database.php';
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../config/config.php';

$db = new Database();
$productModel = new Product($db->getConnection());
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$product = $productModel->getProductById($product_id);
$attributes = $productModel->getProductAttributes($product_id);

header('Content-Type: application/json');
echo json_encode([
    'id' => $product['id'],
    'name' => $product['name'],
    'price' => $product['price'],
    'description' => $product['description'],
    'image' => IMAGES_PATH . $product['image'],
    'attributes' => $attributes
]);