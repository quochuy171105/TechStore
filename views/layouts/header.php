<?php
// views/layouts/header.php
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Database.php';

$db = Database::getInstance();
$categoryModel = new Category($db);
$categories = $categoryModel->getAllCategories();
if (!$categories) {
    $categories = []; // Fallback nếu không lấy được danh mục
}
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #000 !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.8rem 0;
            position: relative;
            z-index: 1000;
        }
        
        .navbar-brand {
            transition: transform 0.2s ease;
        }
        
        .navbar-brand:hover {
            transform: scale(1.02);
        }
        
        .logo-circle {
            border-radius: 50%;
            box-shadow: 0 2px 8px rgba(255,255,255,0.1);
            transition: all 0.2s ease;
            border: 2px solid rgba(255,255,255,0.1);
        }
        
        .logo-circle:hover {
            box-shadow: 0 4px 12px rgba(255,255,255,0.2);
        }
        
        .nav-link {
            transition: all 0.2s ease;
            font-weight: 500;
            color: #fff !important;
            padding: 0.6rem 1rem !important;
            border-radius: 6px;
            margin: 0 0.2rem;
        }
        
        .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff !important;
        }
        
        .dropdown-menu {
            background-color: #fff;
            border: 1px solid rgba(0,0,0,0.1);
            border-radius: 8px;
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
            margin-top: 0.5rem;
            z-index: 9999 !important;
            position: absolute !important;
        }
        
        .dropdown-item {
            transition: all 0.2s ease;
            padding: 0.7rem 1.2rem;
            color: #333;
        }
        
        .dropdown-item:hover {
            background-color: #f8f9fa;
            color: #000;
        }
        
        #search-form {
            max-width: 400px;
            margin: 0 1rem;
        }
        
        #search-input {
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.3);
            background-color: rgba(255,255,255,0.1);
            color: white;
            padding: 0.6rem 1rem;
            transition: all 0.2s ease;
        }
        
        #search-input::placeholder {
            color: rgba(255,255,255,0.7);
        }
        
        #search-input:focus {
            background-color: rgba(255,255,255,0.15);
            border-color: rgba(255,255,255,0.5);
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.1);
            color: white;
        }
        
        .btn-outline-primary {
            border-radius: 6px;
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            background-color: transparent;
            transition: all 0.2s ease;
            padding: 0.6rem 1rem;
            font-weight: 500;
        }
        
        .btn-outline-primary:hover {
            background-color: rgba(255,255,255,0.1);
            border-color: rgba(255,255,255,0.5);
            color: white;
        }
        
        .navbar-toggler {
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 4px;
            padding: 0.5rem;
        }
        
        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(255,255,255,0.1);
        }
        
        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='rgba%28255, 255, 255, 1%29' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='m4 7h22M4 15h22M4 23h22'/%3e%3c/svg%3e");
        }
        
        /* Đảm bảo dropdown không bị che */
        .navbar-nav .dropdown-menu {
            position: absolute !important;
            z-index: 9999 !important;
            top: 100% !important;
            left: 0 !important;
        }
        
        .navbar-nav .dropdown-menu-end {
            left: auto !important;
            right: 0 !important;
        }
        
        /* Fix cho mobile */
        @media (max-width: 991.98px) {
            #search-form {
                max-width: 100%;
                margin: 1rem 0;
            }
            
            .navbar-nav {
                padding-top: 1rem;
            }
            
            .nav-link {
                margin: 0.2rem 0;
            }
            
            .dropdown-menu {
                position: static !important;
                float: none !important;
                width: 100% !important;
                margin-top: 0.2rem !important;
                border: none !important;
                box-shadow: none !important;
                background-color: rgba(255,255,255,0.95) !important;
            }
        }
        
        @media (max-width: 575.98px) {
            .navbar {
                padding: 0.5rem 0;
            }
            
            .logo-circle {
                height: 50px !important;
            }
            
            #search-input {
                font-size: 0.9rem;
            }
            
            .btn-outline-primary {
                padding: 0.5rem 0.8rem;
                font-size: 0.9rem;
            }
        }
        
        /* Hiệu ứng cho icons */
        .nav-link i {
            transition: transform 0.2s ease;
        }
        
        .nav-link:hover i {
            transform: scale(1.05);
        }
        
        /* Cải thiện spacing */
        .navbar-nav .nav-item {
            margin: 0 0.1rem;
        }
        
        .dropdown-toggle::after {
            margin-left: 0.5rem;
        }
        
        /* Đảm bảo text không bị wrap */
        .nav-link {
            white-space: nowrap;
        }
        
        /* Hover effect cho brand */
        .navbar-brand img {
            transition: all 0.2s ease;
        }
        
        .navbar-brand:hover img {
            filter: brightness(1.1);
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container">
                <a class="navbar-brand" href="<?= BASE_URL ?>">
                    <img src="<?= IMAGES_PATH ?>logo1.png" alt="Your Store Logo" class="logo-circle" height="64" onerror="this.src='<?= BASE_URL ?>assets/images/fallback-logo.png'">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <!-- Thanh tìm kiếm -->
                    <form class="d-flex ms-auto my-2 my-lg-0" id="search-form" action="<?= BASE_URL ?>views/user/search.php" method="get">
                        <input class="form-control me-2" type="search" name="q" placeholder="Tìm kiếm sản phẩm..." id="search-input">
                        <button class="btn btn-outline-primary" type="submit" name="search">
                            <i class="fas fa-search"></i> <span class="d-none d-md-inline">Tìm kiếm</span>
                        </button>
                    </form>
                    <!-- Menu danh mục -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-th-large me-1"></i>Danh mục
                            </a>
                            <ul class="dropdown-menu">
                                <?php foreach ($categories as $category): ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>views/user/product_list.php?category_id=<?= $category['id'] ?>">
                                        <i class="fas fa-tag me-2"></i><?= htmlspecialchars($category['name']) ?>
                                    </a></li>
                                <?php endforeach; ?>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= BASE_URL ?>views/user/cart.php">
                                <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user-circle me-1"></i>
                                <span class="d-none d-lg-inline">Tài khoản</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                                <?php if (isset($_SESSION['user_id'])): ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>views/user/account.php">
                                        <i class="fas fa-user me-2"></i>Tài khoản của bạn
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>views/user/logout.php">
                                        <i class="fas fa-sign-out-alt me-2"></i>Đăng xuất
                                    </a></li>
                                <?php else: ?>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>views/user/login.php">
                                        <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= BASE_URL ?>views/user/register.php">
                                        <i class="fas fa-user-plus me-2"></i>Đăng ký
                                    </a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>