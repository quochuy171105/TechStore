<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: home.php');
    exit();
}
require_once dirname(__DIR__, 2) . '/controllers/UserController.php';

$controller = new UserController();
$loginSuccess = false;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loginSuccess = $controller->login();
    if ($loginSuccess) {
        header('Location: home.php');
        exit();
    } else {
        $errors['general'] = 'Sai tài khoản hoặc mật khẩu!';
    }
}
require_once __DIR__ . '/../layouts/header.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/auth.css">

<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Đăng nhập</h2>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errors['general']); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="mb-4">
                <input type="text" name="email" class="form-control" placeholder="Email hoặc số điện thoại" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
            </div>
            <button type="submit" class="btn btn-gradient w-100 mb-3 d-flex justify-content-center">ĐĂNG NHẬP</button>

            <div class="link-group">
                <p class="mb-1">Chưa có tài khoản? <a href="register.php" class="link-item">Đăng ký</a></p>
                <a href="forgot_password.php" class="link-item">Quên mật khẩu?</a>
            </div>
        </form>
    </div>
</div>

<?php require_once __DIR__ . '/../layouts/footer.php'; ?>