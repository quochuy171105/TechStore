
<!-- views/admin/register.php -->
<?php
// Đặt tiêu đề trang cho giao diện đăng ký admin
$page_title = 'Đăng ký Admin';
// Nạp header giao diện admin (chứa menu, css, js chung)
include VIEWS_PATH . 'layouts/admin_header.php';
?>
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Tiêu đề form đăng ký -->
                    <h2 class="card-title text-center mb-4">Đăng ký Admin</h2>
                    
                    <!-- Hiển thị thông báo lỗi nếu có -->
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Hiển thị thông báo thành công nếu có -->
                    <?php if (isset($success)): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i>
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>
                    
                    <!-- Form đăng ký admin -->
                    <form action="<?php echo BASE_URL; ?>admin.php?url=register" method="POST" id="registerForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <!-- Nhập họ và tên -->
                                    <label for="name" class="form-label">
                                        <i class="fas fa-user me-1"></i>Họ và tên *
                                    </label>
                                    <input type="text" class="form-control" id="name" name="name" 
                                           value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>" 
                                           required minlength="2" maxlength="100">
                                    <div class="invalid-feedback">
                                        Họ tên phải có ít nhất 2 ký tự
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <!-- Nhập số điện thoại -->
                                    <label for="phone" class="form-label">
                                        <i class="fas fa-phone me-1"></i>Số điện thoại *
                                    </label>
                                    <input type="tel" class="form-control" id="phone" name="phone" 
                                           value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" 
                                           required pattern="^(0[3|5|7|8|9])+([0-9]{8})$">
                                    <div class="invalid-feedback">
                                        Số điện thoại không hợp lệ (VD: 0901234567)
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <!-- Nhập email -->
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>Email *
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                                   required maxlength="255">
                            <div class="invalid-feedback">
                                Vui lòng nhập email hợp lệ
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <!-- Nhập mật khẩu -->
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Mật khẩu *
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password" name="password" 
                                       required minlength="6" maxlength="50">
                                <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                    <i class="fas fa-eye" id="togglePasswordIcon"></i>
                                </button>
                            </div>
                            <div class="form-text">
                                Mật khẩu phải có ít nhất 6 ký tự, bao gồm chữ hoa, chữ thường và số
                            </div>
                            <div class="invalid-feedback">
                                Mật khẩu không đủ mạnh
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <!-- Nhập lại mật khẩu -->
                            <label for="confirm_password" class="form-label">
                                <i class="fas fa-lock me-1"></i>Xác nhận mật khẩu *
                            </label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                                       required minlength="6" maxlength="50">
                                <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                    <i class="fas fa-eye" id="toggleConfirmPasswordIcon"></i>
                                </button>
                            </div>
                            <div class="invalid-feedback">
                                Mật khẩu xác nhận không khớp
                            </div>
                        </div>
                        
                        <!-- Thông tin địa chỉ (tùy chọn) -->
                        <div class="card mb-3">
                            <div class="card-header bg-light">
                                <h6 class="mb-0"><i class="fas fa-map-marker-alt me-1"></i>Thông tin địa chỉ (Tùy chọn)</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <!-- Nhập địa chỉ chi tiết -->
                                    <label for="address_line" class="form-label">Địa chỉ chi tiết</label>
                                    <textarea class="form-control" id="address_line" name="address_line" 
                                              rows="2" maxlength="500"><?php echo isset($_POST['address_line']) ? htmlspecialchars($_POST['address_line']) : ''; ?></textarea>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <!-- Nhập thành phố -->
                                            <label for="city" class="form-label">Thành phố</label>
                                            <input type="text" class="form-control" id="city" name="city" 
                                                   value="<?php echo isset($_POST['city']) ? htmlspecialchars($_POST['city']) : ''; ?>" 
                                                   maxlength="100">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <!-- Nhập mã bưu điện -->
                                            <label for="postal_code" class="form-label">Mã bưu điện</label>
                                            <input type="text" class="form-control" id="postal_code" name="postal_code" 
                                                   value="<?php echo isset($_POST['postal_code']) ? htmlspecialchars($_POST['postal_code']) : ''; ?>" 
                                                   maxlength="20">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <!-- Chọn quốc gia -->
                                            <label for="country" class="form-label">Quốc gia</label>
                                            <select class="form-select" id="country" name="country">
                                                <option value="Vietnam" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Vietnam') ? 'selected' : ''; ?>>Việt Nam</option>
                                                <option value="USA" <?php echo (isset($_POST['country']) && $_POST['country'] === 'USA') ? 'selected' : ''; ?>>Hoa Kỳ</option>
                                                <option value="Japan" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Japan') ? 'selected' : ''; ?>>Nhật Bản</option>
                                                <option value="Korea" <?php echo (isset($_POST['country']) && $_POST['country'] === 'Korea') ? 'selected' : ''; ?>>Hàn Quốc</option>
                                                <option value="China" <?php echo (isset($_POST['country']) && $_POST['country'] === 'China') ? 'selected' : ''; ?>>Trung Quốc</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <!-- Checkbox đồng ý điều khoản -->
                            <input type="checkbox" class="form-check-input" id="agree_terms" name="agree_terms" required>
                            <label class="form-check-label" for="agree_terms">
                                Tôi đồng ý với <a href="#" target="_blank">Điều khoản dịch vụ</a> và <a href="#" target="_blank">Chính sách bảo mật</a> *
                            </label>
                            <div class="invalid-feedback">
                                Bạn phải đồng ý với điều khoản để tiếp tục
                            </div>
                        </div>
                        
                        <!-- Nút đăng ký -->
                        <button type="submit" class="btn btn-primary w-100 mb-3" id="submitBtn">
                            <i class="fas fa-user-edit me-2"></i>Đăng ký
                        </button>
                        
                        <div class="text-center">
                            <p class="mb-0">Đã có tài khoản? 
                                <a href="<?php echo BASE_URL; ?>admin.php?url=login" class="text-decoration-none">
                                    Đăng nhập ngay
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Script kiểm tra hợp lệ form đăng ký admin
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('registerForm');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const togglePassword = document.getElementById('togglePassword');
    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    
    // Hiện/ẩn mật khẩu khi nhấn vào icon con mắt
    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        const icon = document.getElementById('togglePasswordIcon');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
    
    toggleConfirmPassword.addEventListener('click', function() {
        const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmPassword.setAttribute('type', type);
        const icon = document.getElementById('toggleConfirmPasswordIcon');
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
    
    // Hàm kiểm tra độ mạnh mật khẩu (ít nhất 6 ký tự, có chữ hoa, chữ thường và số)
    function validatePassword(password) {
        const minLength = password.length >= 6;
        const hasUpper = /[A-Z]/.test(password);
        const hasLower = /[a-z]/.test(password);
        const hasNumber = /\d/.test(password);
        return minLength && hasUpper && hasLower && hasNumber;
    }
    
    // Kiểm tra mật khẩu realtime
    password.addEventListener('input', function() {
        const isValid = validatePassword(this.value);
        this.setCustomValidity(isValid ? '' : 'Mật khẩu phải có ít nhất 6 ký tự, bao gồm chữ hoa, chữ thường và số');
        
        if (confirmPassword.value) {
            confirmPassword.dispatchEvent(new Event('input'));
        }
    });
    
    // Kiểm tra xác nhận mật khẩu realtime
    confirmPassword.addEventListener('input', function() {
        const isMatch = this.value === password.value;
        this.setCustomValidity(isMatch ? '' : 'Mật khẩu xác nhận không khớp');
    });
    
    // Kiểm tra hợp lệ khi submit form
    form.addEventListener('submit', function(e) {
        if (!validatePassword(password.value)) {
            e.preventDefault();
            password.classList.add('is-invalid');
            return false;
        }
        
        if (password.value !== confirmPassword.value) {
            e.preventDefault();
            confirmPassword.classList.add('is-invalid');
            return false;
        }
        
        // Hiển thị trạng thái loading khi đang xử lý
        const submitBtn = document.getElementById('submitBtn');
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Đang xử lý...';
        submitBtn.disabled = true;
    });
    
    // Định dạng số điện thoại chỉ cho phép nhập số và tối đa 10 ký tự
    const phoneInput = document.getElementById('phone');
    phoneInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 10) {
            value = value.substring(0, 10);
        }
        this.value = value;
    });
});
</script>

<?php include VIEWS_PATH . 'layouts/admin_footer.php'; ?>