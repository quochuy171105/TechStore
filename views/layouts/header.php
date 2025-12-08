<?php
// views/layouts/header.php
// GIỮ NGUYÊN LOGIC PHP
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Database.php';

$db = Database::getInstance();
$categoryModel = new Category($db);
$categories = $categoryModel->getAllCategories();
if (!$categories) {
    $categories = []; // Fallback nếu không lấy được danh mục
}
// Giả định IMAGES_PATH đã được định nghĩa trong config.php
defined('IMAGES_PATH') or define('IMAGES_PATH', BASE_URL . 'assets/images/');
?>
<script>
    const BASE_URL = "<?= BASE_URL ?>";
</script>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cửa hàng điện tử - Mua sắm sản phẩm công nghệ chất lượng cao">
    <meta name="keywords" content="điện thoại, laptop, phụ kiện, công nghệ">
    <meta name="author" content="Your Store Name">
    <title>Cửa hàng điện tử</title>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="icon" type="image/png" href="<?= BASE_URL ?>assets/images/favicon.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/categories.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark shadow-sm border-bottom border-primary">
            <div class="container py-0">
                <a class="navbar-brand d-flex align-items-center me-4" href="<?= BASE_URL ?>">
                    <img src="<?= IMAGES_PATH ?>logo1.png" alt="Your Store Logo" class="logo-circle me-2" height="20px" onerror="this.src='<?= BASE_URL ?>assets/images/fallback-logo.png'">
                    <span class="fw-bold fs-5 text-uppercase text-primary">HNQNH Store</span> </a>

                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarNav">
                    <form class="d-flex align-items-center mx-auto my-2 my-lg-0" id="search-form" action="<?= BASE_URL ?>views/user/search.php" method="get" autocomplete="off" style="max-width:400px;width:100%;">
                        <div class="position-relative w-100">
                            <input
                                class="form-control ps-5 pe-4 py-2 rounded-pill border border-primary-subtle shadow-sm"
                                type="search"
                                name="q"
                                placeholder="Tìm kiếm sản phẩm, thương hiệu..."
                                id="search-input"
                                aria-label="Tìm kiếm"
                                style="background: #fff; font-size: 1rem;">
                            <div id="search-results-dropdown" class="position-absolute w-100" style="top: 100%; z-index: 1050; display: none;"></div>
                            <span class="position-absolute top-50 start-0 translate-middle-y search-icon-wrapper" style="pointer-events:none;">
                                <i class="fas fa-search search-icon"></i>
                            </span>
                            <button
                                class="btn btn-primary rounded-pill position-absolute top-50 end-0 translate-middle-y me-1 py-1 px-3"
                                type="submit"
                                name="search"
                                aria-label="Tìm kiếm">
                                <i class="fas fa-arrow-right d-none d-md-inline"></i> <span class="d-inline d-md-none">Tìm</span>
                            </button>
                        </div>
                    </form>

                    <ul class="navbar-nav ms-auto align-items-lg-center">
                        <li class="nav-item dropdown me-lg-2">
                            <a class="nav-link dropdown-toggle text-white fw-bold d-flex align-items-center" href="#" data-bs-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fas fa-th-large me-2 fa-lg text-warning"></i>
                                <span class="d-inline d-lg-inline">Danh mục</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <?php foreach ($categories as $category): ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>views/user/product_list.php?category_id=<?= $category['id'] ?>">
                                            <i class="fas fa-microchip me-2 text-uppercase text-primary"></i><?= htmlspecialchars($category['name']) ?>
                                        </a></li>
                                <?php endforeach; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item text-info" href="<?= BASE_URL ?>views/user/product_list.php?category_id=all">
                                        <i class="fas fa-store me-2"></i>Xem tất cả
                                    </a></li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown me-lg-2">
                            <a class="nav-link text-white fw-bold d-flex align-items-center text-nowrap" href="<?= BASE_URL ?>views/user/cart.php">
                                <i class="fas fa-shopping-cart me-2 fa-lg text-danger"></i>
                                <span class="d-inline d-lg-inline">Giỏ hàng</span>
                            </a>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-white fw-bold d-flex align-items-center" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true">
                                <i class="fas fa-user-circle me-2 fa-lg text-info"></i>
                                <span class="d-inline d-lg-inline">Tài khoản</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" aria-labelledby="accountDropdown">
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>views/user/account.php">
                                        <i class="fas fa-user me-2 text-primary"></i>Tài khoản của bạn
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="<?= BASE_URL ?>views/user/order_history.php">
                                        <i class="fas fa-history me-2 text-success"></i>Lịch sử đơn hàng
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="<?= BASE_URL ?>views/user/logout.php">
                                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập/Đăng xuất
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <style>
        .navbar-brand .text-primary {
            /* brand gradient */
            background: linear-gradient(90deg, #4dd0e1, #0288d1);
            background-clip: text;
            -webkit-text-fill-color: transparent;
            display: inline-block;
            /* giúp gradient hiển thị đều trên text */
        }

        /* Fallback cho trình duyệt không hỗ trợ background-clip: text */
        @supports not ((-webkit-background-clip: text) or (background-clip: text)) {
            .navbar-brand .text-primary {
                color: #4dd0e1;
                -webkit-text-fill-color: initial;
            }
        }

        /* Custom Navbar Height */
        .navbar {
            padding-top: 0.25rem;
            padding-bottom: 0.25rem;
        }

        .navbar-brand img.rounded-circle {
            border: 2px solid #fff;
            /* Thêm viền trắng để nổi bật */
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        /* CSS tuỳ chỉnh để Footer nhìn hiện đại trên nền tối */
        .navbar-dark .navbar-nav .nav-link:hover {
            color: var(--bs-primary) !important;
            /* Dùng màu chủ đạo khi hover */
        }

        .navbar-dark .dropdown-menu {
            background-color: #212529;
            /* Nền tối cho dropdown */
            border-color: var(--bs-primary);
        }

        .navbar-dark .dropdown-item:hover {
            background-color: var(--bs-primary);
            /* Màu chủ đạo khi hover item */
            color: #fff !important;
        }

        #search-form .form-control {
            border-color: #ffffffff !important;
        }

        #search-form .form-control:focus {
            border-color: #4dd0e1;
            box-shadow: 0 0 0 2px rgba(77, 208, 225, 0.2);
        }

        .search-icon {
            background: linear-gradient(90deg, #4dd0e1, #0288d1);
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent !important;
            color: transparent !important;
            display: inline-block;
        }

        .search-icon-wrapper {
            left: 20px !important;
            /* tăng giá trị để icon không sát lề; chỉnh 8/12/16 theo ý bạn */
            transform: translateY(-50%);
            /* chính xác hơn so với translate-middle-y */
        }

        .search-icon {
            font-size: 0.95rem;
        }


        /* Đảm bảo logo nhỏ gọn và tròn */
        .logo-circle {
            border-radius: 50%;
            border: 2px solid var(--bs-primary);
            padding: 2px;
            object-fit: contain;
        }

        /* Hiển thị thanh tìm kiếm to hơn trên desktop */
        @media (min-width: 992px) {
            #search-form {
                max-width: 500px !important;
            }
        }
    </style>