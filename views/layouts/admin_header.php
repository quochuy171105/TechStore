<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? htmlspecialchars($page_title) . ' | Admin Panel' : 'Admin Panel'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/admin.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fc;
        }

        /* Header Navbar */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            padding: 0.8rem 1rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.5rem;
            text-decoration: none;
            letter-spacing: 0.5px;
        }

        .navbar-brand:hover {
            color: #e8f4fd !important;
        }

        /* Hamburger Menu Button */
        .menu-toggle {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: #fff;
            padding: 10px 12px;
            border-radius: 8px;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .menu-toggle:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.05);
        }

        .menu-toggle i {
            font-size: 1.2rem;
        }

        /* Account Dropdown */
        .account-btn {
            color: #fff !important;
            font-weight: 600;
            border-radius: 25px;
            padding: 8px 20px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .account-btn:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff !important;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .dropdown-menu {
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.15);
            border: none;
            min-width: 280px;
            padding: 0.5rem 0;
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
        }

        .dropdown-item {
            color: #5a5c69;
            padding: 12px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .dropdown-item:hover {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            transform: translateX(5px);
        }

        .dropdown-item i {
            margin-right: 12px;
            width: 20px;
            text-align: center;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 0;
            left: -300px;
            width: 300px;
            height: 100vh;
            background: linear-gradient(180deg, #fff 0%, #f8f9fc 100%);
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1050;
            padding-top: 80px;
            overflow-y: auto;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar-header {
            padding: 20px;
            border-bottom: 1px solid #e3e6f0;
            margin-bottom: 10px;
        }

        .sidebar-header h4 {
            color: #5a5c69;
            font-weight: 700;
            margin: 0;
            font-size: 1.25rem;
        }

        .sidebar .nav-link {
            color: #5a5c69;
            padding: 15px 25px;
            margin: 5px 15px;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }

        .sidebar .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            transition: all 0.4s ease;
            z-index: -1;
        }

        .sidebar .nav-link:hover::before,
        .sidebar .nav-link.active::before {
            left: 0;
        }

        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: #fff;
            transform: translateX(5px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .sidebar .nav-link i {
            margin-right: 15px;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* Overlay */
        .sidebar-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.5);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 1000;
            backdrop-filter: blur(3px);
        }

        .sidebar-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        /* Main Content */
        .main-content {
            margin-top: 80px;
            padding: 30px 20px;
            min-height: calc(100vh - 80px);
            transition: all 0.3s ease;
        }

        /* Modal Styles */
        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: #fff;
            border: none;
            padding: 20px 25px;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .modal-body {
            padding: 25px;
            background: #fff;
        }

        .modal-body p {
            margin: 15px 0;
            color: #5a5c69;
            font-weight: 500;
            padding: 10px 0;
            border-bottom: 1px solid #f1f3f4;
        }

        .modal-body p:last-child {
            border-bottom: none;
        }

        .modal-body strong {
            color: #2d3748;
            margin-right: 10px;
        }

        .btn-close {
            filter: brightness(0) invert(1);
        }

        /* Responsive Design */
        @media (min-width: 992px) {
            .menu-toggle {
                display: none;
            }
            
            .sidebar {
                position: fixed;
                left: 0;
                width: 280px;
                padding-top: 80px;
            }
            
            .main-content {
                margin-left: 280px;
                padding: 30px 40px;
            }
            
            .sidebar-overlay {
                display: none;
            }
        }

        @media (max-width: 991.98px) {
            .navbar {
                padding: 0.8rem 1rem;
            }
            
            .main-content {
                padding: 20px 15px;
            }
            
            .sidebar {
                width: 280px;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-brand {
                font-size: 1.25rem;
            }
            
            .main-content {
                padding: 15px 10px;
            }
            
            .dropdown-menu {
                min-width: 250px;
            }
        }

        /* Animation Classes */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Scrollbar Styling */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 3px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
    </style>
</head>
<body>
    <!-- Header Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <!-- Menu Toggle Button (Mobile) -->
            <button class="menu-toggle d-lg-none" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            
            <!-- Brand -->
            <a class="navbar-brand mx-auto mx-lg-0" href="<?php echo BASE_URL; ?>admin.php?url=dashboard">
                <i class="fas fa-user-shield me-2"></i>Admin Panel
            </a>
            
            <!-- Account Dropdown -->
            <div class="dropdown">
                <a class="account-btn dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user-edit me-2"></i>
                    <span class="d-none d-sm-inline">
                        <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'Admin'; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
                            <i class="fas fa-address-card"></i> Xem hồ sơ
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item" href="<?php echo BASE_URL; ?>admin.php?url=logout">
                            <i class="fas fa-sign-out-alt"></i> Đăng xuất
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-th-large me-2"></i>Danh mục</h4>
        </div>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link <?php echo isset($page_title) && $page_title == 'Tổng quan' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>admin.php?url=dashboard">
                    <i class="fas fa-tachometer-alt"></i> Tổng quan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isset($page_title) && $page_title == 'Quản lý sản phẩm' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>admin.php?url=products">
                    <i class="fas fa-box"></i> Sản phẩm
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isset($page_title) && $page_title == 'Quản lý đơn hàng' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>admin.php?url=orders">
                    <i class="fas fa-shopping-cart"></i> Đơn hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isset($page_title) && $page_title == 'Quản lý khuyến mãi' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>admin.php?url=promotions">
                    <i class="fas fa-tags"></i> Khuyến mãi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php echo isset($page_title) && $page_title == 'Thống kê doanh thu' ? 'active' : ''; ?>" 
                   href="<?php echo BASE_URL; ?>admin.php?url=revenue">
                    <i class="fas fa-chart-line"></i> Doanh thu
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content fade-in">
        <!-- Profile Modal -->
        <div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="profileModalLabel">
                            <i class="fas fa-user-circle me-2"></i>Thông tin tài khoản
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong><i class="fas fa-user me-2"></i>Tên:</strong> 
                           <?php echo isset($_SESSION['user']['name']) ? htmlspecialchars($_SESSION['user']['name']) : 'N/A'; ?>
                        </p>
                        <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong> 
                           <?php echo isset($_SESSION['user']['email']) ? htmlspecialchars($_SESSION['user']['email']) : 'N/A'; ?>
                        </p>
                        <p><strong><i class="fas fa-shield-alt me-2"></i>Vai trò:</strong> Administrator</p>
                        <p><strong><i class="fas fa-calendar-alt me-2"></i>Ngày tạo:</strong> 
                           <?php echo isset($_SESSION['user']['created_at']) ? date('d/m/Y H:i', strtotime($_SESSION['user']['created_at'])) : 'N/A'; ?>
                        </p>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Đóng
                        </button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdpVzZR8aY8F2hvH" crossorigin="anonymous"></script>

    <!-- Custom JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            // Toggle sidebar
            function toggleSidebar() {
                sidebar.classList.toggle('active');
                sidebarOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
            }

            // Close sidebar
            function closeSidebar() {
                sidebar.classList.remove('active');
                sidebarOverlay.classList.remove('active');
                document.body.style.overflow = '';
            }

            // Event listeners
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', toggleSidebar);
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Close sidebar when clicking on nav links (mobile)
            const navLinks = sidebar.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 992) {
                        setTimeout(closeSidebar, 200);
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 992) {
                    closeSidebar();
                }
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && sidebar.classList.contains('active')) {
                    closeSidebar();
                }
            });

            // Add smooth scroll behavior
            document.documentElement.style.scrollBehavior = 'smooth';
        });
    </script>
</body>
</html>