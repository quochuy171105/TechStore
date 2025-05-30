<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__, 2) . '/controllers/UserController.php';

$controller = new UserController();
$registerSuccess = $controller->register();

$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);

if ($registerSuccess) {
    $_SESSION['message'] = 'Đăng ký thành công! Vui lòng đăng nhập.';
    header('Location: login.php');
    exit();
}
require_once __DIR__ . '/../layouts/header.php';
?>

<div class="register-wrapper">
    <div class="register-card">
        <?php if (!empty($errors['general'])): ?>
            <p class="form-error text-center"><?php echo htmlspecialchars($errors['general']); ?></p>
        <?php endif; ?>

        <h2>Tạo tài khoản</h2>

        <form method="POST" action="" onsubmit="return validateRegisterFormData()">
            <div class="mb-3">
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên của bạn" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>">
                <?php if (isset($errors['name'])): ?><div class="form-error"><?php echo htmlspecialchars($errors['name']); ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="text" id="email" name="email" class="form-control" placeholder="Nhập email hoặc số điện thoại" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">
                <?php if (isset($errors['email'])): ?><div class="form-error"><?php echo htmlspecialchars($errors['email']); ?></div><?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu">
                <?php if (isset($errors['password'])): ?><div class="form-error"><?php echo htmlspecialchars($errors['password']); ?></div><?php endif; ?>
            </div>
            <div class="mb-4">
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu">
                <?php if (isset($errors['confirm_password'])): ?><div class="form-error"><?php echo htmlspecialchars($errors['confirm_password']); ?></div><?php endif; ?>
            </div>
            <button type="submit" class="btn btn-gradient w-100">TẠO TÀI KHOẢN</button>
        </form>

        <div class="link-group text-center mt-3">
            <p class="mb-1">Đã có tài khoản?</p>
            <a href="login.php" class="link-item">Đăng nhập</a>
            <span class="mx-2 text-muted">|</span>
            <a href="forgot_password.php" class="link-item">Quên mật khẩu?</a>
        </div>
    </div>
</div>

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/register.css">
<script src="<?= BASE_URL ?>assets/js/mainTV3.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>