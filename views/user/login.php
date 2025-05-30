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

<div class="login-section">
    <div class="login-form">
        <?php if (!empty($errors['general'])): ?>
            <p class="error text-center"><?php echo htmlspecialchars($errors['general']); ?></p>
        <?php endif; ?>

        <h2>Đăng nhập</h2>

        <form method="POST" action="">
            <div class="mb-4">
                <input type="text" name="email" class="form-control" placeholder="Email hoặc số điện thoại" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
                <?php if (isset($errors['email'])): ?>
                    <p class="error"><?php echo htmlspecialchars($errors['email']); ?></p>
                <?php endif; ?>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu">
                <?php if (isset($errors['password'])): ?>
                    <p class="error"><?php echo htmlspecialchars($errors['password']); ?></p>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary w-100 mb-3">ĐĂNG NHẬP</button>

            <div class="link-group">
                <p class="mb-1">Chưa có tài khoản?</p>
                <a href="register.php" class="link-item">Đăng ký</a>
                <span class="mx-2 text-muted">|</span>
                <a href="forgot_password.php" class="link-item">Quên mật khẩu?</a>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/login.css">
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>