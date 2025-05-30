<?php
// controllers/ProductController.php
require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/Category.php';

class ProductController {
    private $productModel;
    private $categoryModel;

    public function __construct($pdo) {
        $this->productModel = new Product($pdo);
        $this->categoryModel = new Category($pdo);
    }

    public function getFeaturedProducts($limit) {
        return $this->productModel->getFeaturedProducts($limit);
    }

    public function getRecommendedProducts($limit) {
        return $this->productModel->getRecommendedProducts($limit);
    }

    public function getProducts($page, $limit, $category_id, $brand_id, $price_min, $price_max, $sort) {
        return $this->productModel->getProducts($page, $limit, $category_id, $brand_id, $price_min, $price_max, $sort);
    }

    public function getTotalPages($limit, $category_id, $brand_id, $price_min, $price_max) {
        $total = $this->productModel->getTotalProducts($category_id, $brand_id, $price_min, $price_max);
        return ceil($total / $limit);
    }

    public function getProductById($id) {
        return $this->productModel->getProductById($id);
    }

    public function getProductAttributes($product_id) {
        return $this->productModel->getProductAttributes($product_id);
    }

    public function searchProducts($query, $category_id) {
        return $this->productModel->searchProducts($query, $category_id);
    }
}