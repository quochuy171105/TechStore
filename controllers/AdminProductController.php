<?php
// controllers/AdminProductController.php
require_once 'models/Product.php';
require_once 'models/Database.php';

class AdminProductController {
    private $productModel;
    private $pdo;

    public function __construct() {
        $this->pdo = Database::getInstance();
        $this->productModel = new Product($this->pdo);
    }

    public function index() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
        $items_per_page = ITEMS_PER_PAGE;

        $products = $this->productModel->getAll($page, $items_per_page, $search);
        $total_products = $this->productModel->countAll($search);
        $total_pages = ceil($total_products / $items_per_page);

        $data = [
            'products' => $products,
            'current_page' => $page,
            'total_pages' => $total_pages
        ];

        include VIEWS_PATH . 'admin/product_manage.php';
    }

    public function create() {
        error_log('AdminProductController::create called');
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'brand_id' => filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'price' => filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT),
                'stock' => filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT),
                'image' => ''
            ];

            // Xử lý upload hình ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_name = time() . '_' . basename($_FILES['image']['name']);
                $target_path = UPLOADS_PATH . 'products/' . $image_name;
                if (!is_dir(UPLOADS_PATH . 'products/')) {
                    mkdir(UPLOADS_PATH . 'products/', 0777, true);
                }
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $data['image'] = 'products/' . $image_name;
                } else {
                    error_log('Failed to move uploaded file to ' . $target_path);
                    $_SESSION['error'] = 'Lỗi khi upload hình ảnh';
                    header('Location: ' . BASE_URL . 'admin.php?url=products/create');
                    exit;
                }
            }

            // Bắt đầu giao dịch để đảm bảo tính toàn vẹn dữ liệu
            $this->pdo->beginTransaction();
            try {
                if ($this->productModel->create($data)) {
                    $product_id = $this->pdo->lastInsertId();
                    // Lưu thuộc tính
                    if (isset($_POST['attributes']) && is_array($_POST['attributes'])) {
                        foreach ($_POST['attributes'] as $attr) {
                            if (!empty($attr['name']) && !empty($attr['value'])) {
                                $this->productModel->addAttribute($product_id, $attr['name'], $attr['value']);
                            }
                        }
                    }
                    $this->pdo->commit();
                    $_SESSION['success'] = 'Thêm sản phẩm thành công';
                    error_log('Product created successfully, redirecting to products');
                    header('Location: ' . BASE_URL . 'admin.php?url=products');
                    exit;
                } else {
                    $this->pdo->rollBack();
                    $_SESSION['error'] = 'Thêm sản phẩm thất bại';
                    error_log('Failed to create product');
                    header('Location: ' . BASE_URL . 'admin.php?url=products/create');
                    exit;
                }
            } catch (Exception $e) {
                $this->pdo->rollBack();
                error_log('Error creating product: ' . $e->getMessage());
                $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
                header('Location: ' . BASE_URL . 'admin.php?url=products/create');
                exit;
            }
        }

        $categories = $this->pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
        $brands = $this->pdo->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
        $data = [
            'categories' => $categories,
            'brands' => $brands
        ];
        include VIEWS_PATH . 'admin/product_create.php';
    }

    public function update($id) {
        error_log('AdminProductController::update called with id: ' . $id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'category_id' => filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT),
                'brand_id' => filter_input(INPUT_POST, 'brand_id', FILTER_VALIDATE_INT),
                'name' => filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING),
                'description' => filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING),
                'price' => filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT),
                'stock' => filter_input(INPUT_POST, 'stock', FILTER_VALIDATE_INT),
                'image' => filter_input(INPUT_POST, 'existing_image', FILTER_SANITIZE_STRING) ?? ''
            ];

            // Xử lý upload hình ảnh
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $image_name = time() . '_' . basename($_FILES['image']['name']);
                $target_path = UPLOADS_PATH . 'products/' . $image_name;
                if (!is_dir(UPLOADS_PATH . 'products/')) {
                    mkdir(UPLOADS_PATH . 'products/', 0777, true);
                }
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_path)) {
                    $data['image'] = 'products/' . $image_name;
                } else {
                    error_log('Failed to move uploaded file to ' . $target_path);
                    $_SESSION['error'] = 'Lỗi khi upload hình ảnh';
                    header('Location: ' . BASE_URL . 'admin.php?url=products/update/' . $id);
                    exit;
                }
            }

            // Bắt đầu giao dịch
            $this->pdo->beginTransaction();
            try {
                if ($this->productModel->update($id, $data)) {
                    // Xóa thuộc tính cũ
                    $this->productModel->deleteAttributes($id);
                    // Thêm thuộc tính mới
                    if (isset($_POST['attributes']) && is_array($_POST['attributes'])) {
                        foreach ($_POST['attributes'] as $attr) {
                            if (!empty($attr['name']) && !empty($attr['value'])) {
                                $this->productModel->addAttribute($id, $attr['name'], $attr['value']);
                            }
                        }
                    }
                    $this->pdo->commit();
                    $_SESSION['success'] = 'Cập nhật sản phẩm thành công';
                    error_log('Product updated successfully, redirecting to products');
                    header('Location: ' . BASE_URL . 'admin.php?url=products');
                    exit;
                } else {
                    $this->pdo->rollBack();
                    $_SESSION['error'] = 'Cập nhật sản phẩm thất bại';
                    error_log('Failed to update product');
                    header('Location: ' . BASE_URL . 'admin.php?url=products/update/' . $id);
                    exit;
                }
            } catch (Exception $e) {
                $this->pdo->rollBack();
                error_log('Error updating product: ' . $e->getMessage());
                $_SESSION['error'] = 'Lỗi: ' . $e->getMessage();
                header('Location: ' . BASE_URL . 'admin.php?url=products/update/' . $id);
                exit;
            }
        } else {
            $product = $this->productModel->getById($id);
            if (!$product) {
                error_log('Product not found: ' . $id);
                include VIEWS_PATH . 'layouts/404.php';
                exit;
            }
            $product_attributes = $this->productModel->getAttributes($id);
            $categories = $this->pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);
            $brands = $this->pdo->query("SELECT * FROM brands")->fetchAll(PDO::FETCH_ASSOC);
            $data = [
                'product' => $product,
                'product_attributes' => $product_attributes,
                'categories' => $categories,
                'brands' => $brands
            ];
            include VIEWS_PATH . 'admin/product_create.php';
        }
    }

    public function delete($id) {
        error_log('AdminProductController::delete called with id: ' . $id);
        // Kiểm tra nếu là yêu cầu AJAX
        $isAjax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
        
        try {
            if ($this->productModel->delete($id)) {
                $_SESSION['success'] = 'Xóa sản phẩm thành công';
                error_log('Product deleted successfully');
                if ($isAjax) {
                    echo json_encode(['success' => true, 'message' => 'Xóa sản phẩm thành công']);
                } else {
                    header('Location: ' . BASE_URL . 'admin.php?url=products');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Xóa sản phẩm thất bại';
                error_log('Failed to delete product');
                if ($isAjax) {
                    echo json_encode(['success' => false, 'message' => 'Xóa sản phẩm thất bại']);
                } else {
                    header('Location: ' . BASE_URL . 'admin.php?url=products');
                    exit;
                }
            }
        } catch (PDOException $e) {
            error_log('Delete product failed: ' . $e->getMessage());
            $_SESSION['error'] = 'Không thể xóa sản phẩm do có dữ liệu liên quan';
            if ($isAjax) {
                echo json_encode(['success' => false, 'message' => 'Không thể xóa sản phẩm do có dữ liệu liên quan']);
            } else {
                header('Location: ' . BASE_URL . 'admin.php?url=products');
                exit;
            }
        }
        if (!$isAjax) {
            // Nếu không phải AJAX, thực hiện chuyển hướng
            header('Location: ' . BASE_URL . 'admin.php?url=products');
            exit;
        }
    }
}
?>