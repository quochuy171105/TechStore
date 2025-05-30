<!-- views/admin/login.php -->
<?php
// Đặt tiêu đề trang cho giao diện đăng nhập admin
$page_title = 'Đăng nhập Admin';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center py-3">
    <div class="row w-100 justify-content-center">
        <div class="col-md-8 col-lg-6 ">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">
                    <div class="text-center mb-3">
                        <!-- Icon và tiêu đề đăng nhập -->
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-2"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-user-shield text-white" style="font-size: 1.5rem;"></i>
                        </div>
                        <h2 class="card-title fw-bold text-dark mb-1">Đăng nhập Admin</h2>
                        <p class="text-muted mb-0 small">Truy cập hệ thống quản lý</p>
                    </div>

                    <!-- Hiển thị thông báo lỗi nếu có -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show py-2" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <small><?php echo htmlspecialchars($error); ?></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Hiển thị thông báo thành công nếu có -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show py-2" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <small><?php echo htmlspecialchars($success); ?></small>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <!-- Form đăng nhập admin -->
                    <form action="<?php echo BASE_URL; ?>admin.php?url=login" method="POST" id="loginForm" novalidate>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="email" class="form-label fw-semibold small">
                                    <i class="fas fa-envelope me-1 text-primary"></i>Email
                                </label>
                                <!-- Trường nhập email -->
                                <input type="email"
                                    class="form-control"
                                    id="email"
                                    name="email"
                                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                    placeholder="admin@example.com"
                                    required>
                                <div class="invalid-feedback small">
                                    Vui lòng nhập email hợp lệ
                                </div>
                            </div>

                            <div class="col-12 mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <label for="password" class="form-label fw-semibold small mb-0">
                                        <i class="fas fa-lock me-1 text-primary"></i>Mật khẩu
                                    </label>
                                    <!-- Link quên mật khẩu -->
                                    <a href="<?php echo BASE_URL; ?>admin.php?url=forgot-password"
                                        class="text-decoration-none small">
                                        Quên mật khẩu?
                                    </a>
                                </div>
                                <div class="input-group">
                                    <!-- Trường nhập mật khẩu -->
                                    <input type="password"
                                        class="form-control"
                                        id="password"
                                        name="password"
                                        placeholder="Nhập mật khẩu"
                                        required>
                                    <!-- Nút hiện/ẩn mật khẩu -->
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback small">
                                    Vui lòng nhập mật khẩu
                                </div>
                            </div>
                        </div>

                        <div class="row align-items-center mb-3">
                            <div class="col-12">
                                <!-- Checkbox ghi nhớ đăng nhập -->
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me">
                                    <label class="form-check-label small" for="remember_me">
                                        Ghi nhớ đăng nhập
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <!-- Nút đăng nhập -->
                                <button type="submit" class="btn btn-primary w-100" id="loginBtn">
                                    <i class="fas fa-sign-in-alt me-2"></i>Đăng nhập
                                </button>
                            </div>
                        </div>

                        <div class="text-center pt-2 border-top">
                            <div class="d-flex justify-content-between align-items-center flex-wrap">
                                <span class="mb-0 text-muted small">Chưa có tài khoản admin?</span>
                                <!-- Link đăng ký admin -->
                                <a href="<?php echo BASE_URL; ?>admin.php?url=register"
                                    class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-user-edit me-1"></i>Đăng ký ngay
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Thông báo bảo mật -->
            <div class="text-center mt-2">
                <small class="text-muted d-flex align-items-center justify-content-center">
                    <i class="fas fa-shield-alt text-success me-1"></i>
                    Kết nối được bảo mật bằng SSL
                </small>
            </div>
        </div>
    </div>
</div>

<style>
    .vh-100 {
        min-height: 100vh;
    }

    .card {
        transition: all 0.3s ease;
        border-radius: 15px;
    }

    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1) !important;
    }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.25);
    }

    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 8px 16px;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #5a67d8 0%, #6b46a3 100%);
        transform: translateY(-1px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .alert {
        border: none;
        border-radius: 8px;
    }

    .bg-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .card {
        animation: fadeInUp 0.5s ease-out;
    }

    .form-control {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #dee2e6;
    }

    .btn {
        border-radius: 8px;
        font-weight: 600;
    }

    .btn-sm {
        padding: 6px 12px;
        font-size: 0.875rem;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .col-md-6 {
            margin-bottom: 1rem !important;
        }

        .text-md-end {
            text-align: center !important;
            margin-top: 1rem;
        }
    }

    @media (min-width: 1200px) {
        .col-xl-5 {
            max-width: 35%;
        }
    }

    /* Remove extra spacing on smaller screens */
    @media (max-height: 700px) {
        .py-3 {
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
        }

        .mb-3 {
            margin-bottom: 0.75rem !important;
        }

        .mb-2 {
            margin-bottom: 0.5rem !important;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('loginForm');
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const loginBtn = document.getElementById('loginBtn');

        // Chức năng hiện/ẩn mật khẩu khi nhấn vào icon con mắt
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            const icon = document.getElementById('togglePasswordIcon');
            icon.classList.toggle('fa-eye');
            icon.classList.toggle('fa-eye-slash');
        });

        // Kiểm tra hợp lệ form khi submit
        form.addEventListener('submit', function(e) {
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            let isValid = true;

            // Reset trạng thái kiểm tra
            [email, password].forEach(field => {
                field.classList.remove('is-invalid', 'is-valid');
            });

            // Kiểm tra email
            if (!email.value.trim()) {
                email.classList.add('is-invalid');
                isValid = false;
            } else if (!isValidEmail(email.value)) {
                email.classList.add('is-invalid');
                email.nextElementSibling.textContent = 'Email không hợp lệ';
                isValid = false;
            } else {
                email.classList.add('is-valid');
            }

            // Kiểm tra mật khẩu
            if (!password.value.trim()) {
                password.classList.add('is-invalid');
                isValid = false;
            } else if (password.value.length < 6) {
                password.classList.add('is-invalid');
                password.closest('.input-group').nextElementSibling.textContent = 'Mật khẩu phải có ít nhất 6 ký tự';
                isValid = false;
            } else {
                password.classList.add('is-valid');
            }

            if (!isValid) {
                e.preventDefault();
                return false;
            }

            // Hiển thị trạng thái loading khi đang đăng nhập
            loginBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang đăng nhập...';
            loginBtn.disabled = true;
        });

        // Hàm kiểm tra định dạng email hợp lệ
        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        // Kiểm tra email realtime khi rời khỏi trường nhập
        const email = document.getElementById('email');
        email.addEventListener('blur', function() {
            if (this.value.trim() && !isValidEmail(this.value)) {
                this.classList.add('is-invalid');
                this.nextElementSibling.textContent = 'Email không hợp lệ';
            } else if (this.value.trim()) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });

        // Tự động ẩn thông báo alert sau 4 giây
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                if (alert.querySelector('.btn-close')) {
                    alert.querySelector('.btn-close').click();
                }
            }, 4000);
        });
    });
</script>

<?php
// Nạp footer giao diện admin
include VIEWS_PATH . 'layouts/admin_footer.php';
?>