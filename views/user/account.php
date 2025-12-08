<?php

if (session_status() === PHP_SESSION_NONE) session_start();

// Nếu chưa đăng nhập thì về login
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once dirname(__DIR__, 2) . '/controllers/UserController.php';
$controller = new UserController();
$controller->account();

global $userData;
$user = $userData ?? [];
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    require_once dirname(__DIR__, 2) . '/controllers/UserController.php';
    $controller = new UserController();
    $controller->logout();
}
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="account-container">
  <div class="account-header">
    <h2 class="page-title">Quản lý tài khoản</h2>
    <p class="text-muted">Cập nhật thông tin cá nhân và quản lý tài khoản của bạn</p>
  </div>

  <div class="account-box">
    <ul class="nav nav-tabs custom-tabs mb-0" id="accountTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
          <i class="bi bi-person-circle me-2"></i>Thông tin cá nhân
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="address-tab" data-bs-toggle="tab" data-bs-target="#address" type="button" role="tab">
          <i class="bi bi-geo-alt me-2"></i>Địa chỉ giao hàng
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="voucher-tab" data-bs-toggle="tab" data-bs-target="#voucher" type="button" role="tab">
          <i class="bi bi-wallet2 me-2"></i>Ví voucher
        </button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="feedback-tab" data-bs-toggle="tab" data-bs-target="#feedback" type="button" role="tab">
          <i class="bi bi-star me-2"></i>Lịch sử đánh giá
        </button>
      </li>
    </ul>
    
    <div class="tab-content" id="accountTabContent">
      <!-- TAB THÔNG TIN CÁ NHÂN -->
      <div class="tab-pane fade show active" id="info" role="tabpanel">
        <form method="POST" id="accountForm" autocomplete="off">
          <input type="hidden" name="update_info" value="1">
          <div class="row">
            <div class="mb-3 col-md-6">
              <label for="name" class="form-label">
                <i class="bi bi-person me-2"></i>Tên
              </label>
              <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name'] ?? ''); ?>">
              <div class="form-error" id="error-name"></div>
            </div>
            <div class="mb-3 col-md-6">
              <label for="email" class="form-label">
                <i class="bi bi-envelope me-2"></i>Email
              </label>
              <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email'] ?? ''); ?>">
              <div class="form-error" id="error-email"></div>
            </div>
            <div class="mb-3 col-md-6">
              <label for="phone" class="form-label">
                <i class="bi bi-telephone me-2"></i>Số điện thoại
              </label>
              <input type="text" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone'] ?? ''); ?>">
              <div class="form-error" id="error-phone"></div>
            </div>
            <div class="mb-3 col-md-6">
              <label for="password" class="form-label">
                <i class="bi bi-lock me-2"></i>Mật khẩu mới
              </label>
              <input type="password" class="form-control" id="password" name="password">
              <div class="form-error" id="error-password"></div>
            </div>
            <div class="mb-3 col-md-6">
              <label for="confirm_password" class="form-label">
                <i class="bi bi-lock-fill me-2"></i>Xác nhận mật khẩu
              </label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password">
              <div class="form-error" id="error-confirm_password"></div>
            </div>
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-gradient">
              <i class="bi bi-check-circle me-2"></i>Cập nhật thông tin
            </button>
          </div>
          <div id="info-message"></div>
        </form>
      </div>

      <!-- TAB ĐỊA CHỈ GIAO HÀNG -->
      <div class="tab-pane fade" id="address" role="tabpanel">
        <!-- Danh sách địa chỉ -->
        <div id="address-list">
          <?php
          $addresses = [];
          if (!empty($user['id'])) {
            $addresses = (new User())->getAddresses($user['id']);
          }
          if (empty($addresses)) {
            echo '<div class="text-center py-5">';
            echo '<i class="bi bi-geo-alt-fill icon-large"></i>';
            echo '<p class="text-muted mt-3 mb-4">Bạn chưa có địa chỉ nào. Vui lòng thêm địa chỉ giao hàng:</p>';
            echo '</div>';
          } else {
            foreach ($addresses as $ad) {
              $default = $ad['is_default'];
              echo '<div class="card mb-3 shadow-sm address-item '.($default ? 'border-default' : '').'" data-id="'.$ad['id'].'">';
              echo    '<div class="card-body d-flex justify-content-between align-items-center flex-wrap">';
              echo        '<div class="flex-grow-1">';
              echo            '<div class="addr-title">'.htmlspecialchars($ad['address_line']).'</div>';
              echo            '<div class="text-muted addr-sub">'.htmlspecialchars($ad['city']).', '.htmlspecialchars($ad['country']);
              if ($ad['postal_code']) echo ', '.htmlspecialchars($ad['postal_code']);
              echo            '</div>';
              if ($default) echo '<span class="badge bg-info mt-2"><i class="bi bi-star-fill me-1"></i>Mặc định</span>';
              echo        '</div>';
              echo        '<div class="btn-group mt-2 mt-md-0 ms-md-3">';
              echo            '<button type="button" class="btn btn-outline-secondary btn-sm edit-address" data-id="'.$ad['id'].'"';
              echo                ' data-address="'.htmlspecialchars($ad['address_line']).'"';
              echo                ' data-city="'.htmlspecialchars($ad['city']).'"';
              echo                ' data-country="'.htmlspecialchars($ad['country']).'"';
              echo                ' data-postal="'.htmlspecialchars($ad['postal_code']).'"';
              echo                ' data-default="'.$default.'">';
              echo                '<i class="bi bi-pencil me-1"></i>Sửa';
              echo            '</button>';
              if (!$default) {
                echo '<button type="button" class="btn btn-outline-primary btn-sm set-default ms-1" data-id="'.$ad['id'].'"><i class="bi bi-star"></i></button>';
                echo '<button type="button" class="btn btn-outline-danger btn-sm ms-1 delete-address" data-id="'.$ad['id'].'"><i class="bi bi-trash"></i></button>';
              } else {
                echo '<button type="button" class="btn btn-outline-secondary btn-sm ms-1" disabled><i class="bi bi-trash"></i></button>';
              }
              echo        '</div>';
              echo    '</div>';
              // Khung sửa inline (ẩn mặc định)
              echo    '<div class="edit-form-container">';
              echo      '<form class="edit-address-form" method="post" data-id="'.$ad['id'].'">';
              echo        '<div class="row g-3 align-items-end">';
              echo          '<div class="col-12 col-md-5">';
              echo            '<label class="form-label">Địa chỉ</label>';
              echo            '<input type="text" class="form-control" name="address_line" value="'.htmlspecialchars($ad['address_line']).'" required>';
              echo          '</div>';
              echo          '<div class="col-6 col-md-3">';
              echo            '<label class="form-label">Thành phố</label>';
              echo            '<input type="text" class="form-control" name="city" value="'.htmlspecialchars($ad['city']).'" required>';
              echo          '</div>';
              echo          '<div class="col-6 col-md-2">';
              echo            '<label class="form-label">Mã bưu điện</label>';
              echo            '<input type="text" class="form-control" name="postal_code" value="'.htmlspecialchars($ad['postal_code']).'">';
              echo          '</div>';
              echo          '<div class="col-6 col-md-2">';
              echo            '<label class="form-label">Quốc gia</label>';
              echo            '<input type="text" class="form-control" name="country" value="'.htmlspecialchars($ad['country']).'" required>';
              echo          '</div>';
              echo          '<div class="col-6 col-md-2">';
              echo            '<div class="form-check mt-3">';
              echo              '<input class="form-check-input" type="checkbox" name="is_default" '.($default?'checked':'').'>';
              echo              '<label class="form-check-label">Mặc định</label>';
              echo            '</div>';
              echo          '</div>';
              echo          '<div class="col-12 text-end">';
              echo            '<button type="submit" class="btn btn-gradient btn-sm me-2">';
              echo              '<i class="bi bi-check me-1"></i>Lưu';
              echo            '</button>';
              echo            '<button type="button" class="btn btn-light btn-sm cancel-edit">';
              echo              '<i class="bi bi-x me-1"></i>Hủy';
              echo            '</button>';
              echo          '</div>';
              echo        '</div>';
              echo      '</form>';
              echo    '</div>';
              echo '</div>';
            }
          }
          ?>
        </div>
        
        <hr>
        
        <!-- FORM ADD ADDRESS (AJAX) -->
        <div class="card add-address-card">
          <div class="card-body">
            <h5 class="card-title mb-3">
              <i class="bi bi-plus-circle me-2"></i>Thêm địa chỉ mới
            </h5>
            <form id="addAddressForm" method="post" autocomplete="off">
              <input type="hidden" name="address_action" value="1">
              <input type="hidden" name="action" value="add">
              <div class="row">
                <div class="mb-3 col-md-5">
                  <label class="form-label">
                    <i class="bi bi-geo-alt me-2"></i>Địa chỉ
                  </label>
                  <input type="text" name="address_line" class="form-control" required>
                </div>
                <div class="mb-3 col-md-3">
                  <label class="form-label">
                    <i class="bi bi-building me-2"></i>Thành phố
                  </label>
                  <input type="text" name="city" class="form-control" required>
                </div>
                <div class="mb-3 col-md-2">
                  <label class="form-label">
                    <i class="bi bi-mailbox me-2"></i>Mã bưu điện
                  </label>
                  <input type="text" name="postal_code" class="form-control" placeholder="Không bắt buộc">
                </div>
                <div class="mb-3 col-md-2">
                  <label class="form-label">
                    <i class="bi bi-globe me-2"></i>Quốc gia
                  </label>
                  <input type="text" name="country" class="form-control" required>
                </div>
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-gradient">
                  <i class="bi bi-plus-circle me-2"></i>Thêm địa chỉ
                </button>
              </div>
              <div id="address-msg"></div>
            </form>
          </div>
        </div>
      </div>

      <!-- TAB VOUCHER -->
      <div class="tab-pane fade" id="voucher" role="tabpanel">
        <?php
        require_once dirname(__DIR__, 2) . '/controllers/PromotionController.php';
        $promotionController = new PromotionController();
        $promotionController->index();
        global $promotions;
        include __DIR__ . '/promotions.php';
        ?>
      </div>

      <div class="tab-pane fade" id="feedback" role="tabpanel">
        <?php
        require_once dirname(__DIR__, 2) . '/controllers/FeedbackController.php';
        $feedbackController = new FeedbackController();
        $feedbackController->indexByUser($user['id'] ?? 0);
        include __DIR__ . '/feedback_history.php';
        ?>
      </div>
    </div>
  </div>
</div>

<!-- Custom JavaScript -->
<script src="<?= BASE_URL ?>assets/js/mainTV3.js"></script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>