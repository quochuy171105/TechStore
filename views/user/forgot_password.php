<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/controllers/UserController.php';

$controller = new UserController();
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

require_once __DIR__ . '/../layouts/header.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/auth.css">

<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Quên mật khẩu</h2>
        <p class="text-muted mb-4">Nhập email của bạn để nhận liên kết đặt lại mật khẩu.</p>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errors['general']); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
                <?php if (isset($errors['email'])): ?>
                    <p class="error"><?php echo htmlspecialchars($errors['email']); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-gradient w-100 mb-3 d-flex justify-content-center">GỬI YÊU CẦU</button>

            <div class="link-group">
                <p class="mb-1">Đã có tài khoản? <a href="login.php" class="link-item">Đăng nhập</a></p>
                <p class="mb-0">Chưa có tài khoản? <a href="register.php" class="link-item">Đăng ký</a></p>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>