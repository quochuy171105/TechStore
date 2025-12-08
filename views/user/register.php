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

<link rel="stylesheet" href="<?= BASE_URL ?>assets/css/auth.css">

<div class="auth-wrapper">
    <div class="auth-card">
        <h2>Tạo tài khoản</h2>

        <?php if (!empty($errors['general'])): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($errors['general']); ?></div>
        <?php endif; ?>

        <form method="POST" action="" onsubmit="return validateRegisterFormData()">
            <div class="mb-3">
                <input type="text" id="name" name="name" class="form-control" placeholder="Nhập tên của bạn" value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" required>
                <?php if (isset($errors['name'])): ?><p class="error"><?php echo htmlspecialchars($errors['name']); ?></p><?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="text" id="email" name="email" class="form-control" placeholder="Nhập email hoặc số điện thoại" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" required>
                <?php if (isset($errors['email'])): ?><p class="error"><?php echo htmlspecialchars($errors['email']); ?></p><?php endif; ?>
            </div>
            <div class="mb-3">
                <input type="password" id="password" name="password" class="form-control" placeholder="Nhập mật khẩu" required>
                <?php if (isset($errors['password'])): ?><p class="error"><?php echo htmlspecialchars($errors['password']); ?></p><?php endif; ?>
            </div>
            <div class="mb-4">
                <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Xác nhận mật khẩu" required>
                <?php if (isset($errors['confirm_password'])): ?><p class="error"><?php echo htmlspecialchars($errors['confirm_password']); ?></p><?php endif; ?>
            </div>
            <button type="submit" class="btn btn-gradient w-100 d-flex justify-content-center">TẠO TÀI KHOẢN</button>
        </form>

        <div class="link-group text-center mt-3">
            <p class="mb-1">Đã có tài khoản? <a href="login.php" class="link-item">Đăng nhập</a></p>
        </div>
    </div>
</div>
<script src="<?= BASE_URL ?>assets/js/mainTV3.js"></script>
<?php require_once __DIR__ . '/../layouts/footer.php'; ?>