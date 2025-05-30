<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/controllers/UserController.php';

$controller = new UserController();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

require_once __DIR__ . '/../layouts/header.php';
?>

<div class="forgot-password-section">
    <div class="forgot-password-form">
        <?php if (!empty($errors['general'])): ?>
            <p class="error text-center"><?php echo htmlspecialchars($errors['general']); ?></p>
        <?php endif; ?>

        <h2>Quên mật khẩu</h2>
        <p class="text-center text-muted mb-4">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>

        <form method="POST" action="">
            <div class="mb-4">
                <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <p class="error"><?php echo htmlspecialchars($errors['email']); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">GỬI YÊU CẦU</button>

            <div class="link-group">
                <p class="mb-1">Đã có tài khoản?</p>
                <a href="login.php" class="link-item">Đăng nhập</a>
                <span class="mx-2 text-muted">|</span>
                <a href="register.php" class="link-item">Đăng ký</a>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/forgot_password.css">
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>