
<!-- views/admin/forgot_password.php -->
<?php
// Đặt tiêu đề trang cho giao diện quên mật khẩu admin
$page_title = 'Quên mật khẩu Admin';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <!-- Tiêu đề và mô tả -->
                    <div class="text-center mb-4">
                        <div class="bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 80px; height: 80px;">
                            <i class="fas fa-key text-white" style="font-size: 2rem;"></i>
                        </div>
                        <h2 class="card-title fw-bold text-dark">Quên mật khẩu?</h2>
                        <p class="text-muted mb-0">Nhập email để nhận link đặt lại mật khẩu</p>
                    </div>
                    
                    <!-- Hiển thị thông báo lỗi nếu có -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Hiển thị thông báo thành công nếu có -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($success); ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Form quên mật khẩu -->
                    <form action="<?php echo BASE_URL; ?>admin.php?url=forgot-password" method="POST" id="forgotPasswordForm" novalidate>
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                <i class="fas fa-envelope me-2 text-warning"></i>Email Admin
                            </label>
                            <input type="email" 
                                   class="form-control form-control-lg" 
                                   id="email" 
                                   name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                                   placeholder="admin@example.com"
                                   required>
                            <div class="invalid-feedback">
                                Vui lòng nhập email hợp lệ
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-warning btn-lg w-100 mb-4 text-white" id="resetBtn">
                            <i class="fas fa-paper-plane me-2"></i>Gửi link đặt lại
                        </button>
                    </form>
                    
                    <!-- Link quay lại đăng nhập -->
                    <div class="text-center">
                        <p class="mb-0 text-muted">Nhớ lại mật khẩu?</p>
                        <a href="<?php echo BASE_URL; ?>admin.php?url=login" 
                           class="btn btn-outline-secondary btn-sm mt-2">
                            <i class="fas fa-arrow-left me-2"></i>Quay lại đăng nhập
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Help Card -->
            <div class="card mt-3 border-info">
                <div class="card-body py-3">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-info-circle text-info me-3" style="font-size: 1.2rem;"></i>
                        <div>
                            <small class="text-muted">
                                <strong>Lưu ý:</strong> Link đặt lại mật khẩu sẽ hết hạn sau 1 giờ. 
                                Nếu không nhận được email, vui lòng kiểm tra thư mục spam.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 
    CSS tuỳ chỉnh cho giao diện quên mật khẩu admin
    - Hiệu ứng hover, border, màu sắc cho card, button, input, alert...
-->
<style>
.card {
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
}

.form-control:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

.btn-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%);
    border: none;
    transition: all 0.3s ease;
}

.btn-warning:hover {
    background: linear-gradient(135deg, #e0a800 0%, #e6800a 100%);
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
}

.alert {
    border: none;
    border-radius: 10px;
}

.bg-warning {
    background: linear-gradient(135deg, #ffc107 0%, #ff8c00 100%) !important;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.card {
    animation: fadeInUp 0.6s ease-out;
}

.form-control-lg {
    border-radius: 10px;
    padding: 12px 16px;
}

.btn-lg {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
}
</style>

<!-- 
    Script xử lý kiểm tra hợp lệ form quên mật khẩu, 
    realtime validation, loading state, tự động ẩn alert...
-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('forgotPasswordForm');
    const resetBtn = document.getElementById('resetBtn');
    
    // Form validation khi submit
    form.addEventListener('submit', function(e) {
        const email = document.getElementById('email');
        let isValid = true;
        
        // Reset validation states
        email.classList.remove('is-invalid', 'is-valid');
        
        // Validate email
        if (!email.value.trim()) {
            email.classList.add('is-invalid');
            email.nextElementSibling.textContent = 'Vui lòng nhập email';
            isValid = false;
        } else if (!isValidEmail(email.value)) {
            email.classList.add('is-invalid');
            email.nextElementSibling.textContent = 'Email không hợp lệ';
            isValid = false;
        } else {
            email.classList.add('is-valid');
        }
        
        if (!isValid) {
            e.preventDefault();
            return false;
        }
        
        // Show loading state
        resetBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang gửi...';
        resetBtn.disabled = true;
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
    
    // Tự động ẩn thông báo alert sau 5 giây
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.querySelector('.btn-close')) {
                alert.querySelector('.btn-close').click();
            }
        }, 5000);
    });
});
</script>

<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>