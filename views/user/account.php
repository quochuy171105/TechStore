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

<!-- Custom CSS for account page -->
<style>
  body { 
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    min-height: 100vh; 
    padding: 0px 0;
  }
  
  .account-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 15px;
  }
  
  .account-header {
    text-align: center;
    margin-bottom: 40px;
    color: white;
  }
  
  .account-header h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 8px;
    text-shadow: 0 2px 4px rgba(0,0,0,0.3);
  }
  
  .account-header p {
    font-size: 1.1rem;
    opacity: 0.9;
    margin: 0;
  }
  
  .account-box { 
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(20px);
    border-radius: 24px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
    padding: 0;
    overflow: hidden;
    border: 1px solid rgba(255, 255, 255, 0.2);
  }
  
  .nav-tabs { 
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    padding: 25px 30px 0;
    margin: 0;
    border-bottom: none;
    justify-content: center;
    gap: 8px;
  }
  
  .nav-tabs .nav-link { 
    border: none; 
    padding: 12px 24px; 
    border-radius: 16px; 
    background: rgba(255, 255, 255, 0.7);
    color:rgb(78, 73, 73); 
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    font-weight: 500;
    font-size: 0.95rem;
    position: relative;
    overflow: hidden;
    backdrop-filter: blur(10px);
  }
  
  .nav-tabs .nav-link:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.8), transparent);
    transition: left 0.5s;
  }
  
  .nav-tabs .nav-link:hover { 
    background: rgba(255, 255, 255, 0.9);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
  }
  
  .nav-tabs .nav-link:hover:before {
    left: 100%;
  }
  
  .nav-tabs .nav-link.active { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white; 
    font-weight: 600;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
  }
  
  .tab-content { 
    background: white;
    padding: 40px;
    margin: 0;
    min-height: 500px;
  }
  
  .form-control { 
    border-radius: 12px;
    border: 2px solid #e2e8f0;
    padding: 12px 16px;
    font-size: 0.95rem;
    transition: all 0.3s ease;
    background: rgba(248, 250, 252, 0.5);
  }
  
  .form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
    background: white;
  }
  
  .form-label {
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
    font-size: 0.9rem;
  }
  
  .btn-gradient { 
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white; 
    font-weight: 600; 
    padding: 12px 28px; 
    border-radius: 12px; 
    border: none; 
    transition: all 0.3s ease;
    font-size: 0.95rem;
    position: relative;
    overflow: hidden;
  }
  
  .btn-gradient:before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
  }
  
  .btn-gradient:hover { 
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(102, 126, 234, 0.4);
  }
  
  .btn-gradient:hover:before {
    left: 100%;
  }
  
  .address-item {
    border-radius: 16px !important;
    transition: all 0.3s ease;
    background: rgba(248, 250, 252, 0.5);
    backdrop-filter: blur(10px);
  }
  
  .address-item:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1) !important;
  }
  
  .address-item.border-default {
    border: 2px solid #667eea !important;
    background: rgba(102, 126, 234, 0.05);
  }
  
  .card-body {
    padding: 24px;
  }
  
  .btn-outline-secondary, .btn-outline-primary, .btn-outline-danger {
    border-radius: 8px;
    font-weight: 500;
    padding: 6px 12px;
    font-size: 0.85rem;
    transition: all 0.3s ease;
  }
  
  .btn-outline-secondary:hover {
    background: #6c757d;
    transform: translateY(-1px);
  }
  
  .btn-outline-primary:hover {
    background: #667eea;
    transform: translateY(-1px);
  }
  
  .btn-outline-danger:hover {
    background: #ef4444;
    transform: translateY(-1px);
  }
  
  .badge {
    border-radius: 8px;
    padding: 6px 12px;
    font-weight: 500;
    font-size: 0.8rem;
  }
  
  .bg-info {
    background: linear-gradient(135deg, #06b6d4 0%, #0891b2 100%) !important;
  }
  
  .edit-form-container {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%) !important;
    border-radius: 16px !important;
    border: 1px solid rgba(102, 126, 234, 0.1);
  }
  
  .form-error { 
    color: #ef4444; 
    font-size: 0.85rem; 
    margin-top: 6px;
    font-weight: 500;
  }
  
  #info-message, #address-msg { 
    margin-top: 16px;
    padding: 12px 16px;
    border-radius: 12px;
    font-weight: 500;
  }
  
  .text-muted {
    color: #64748b !important;
  }
  
  hr {
    border: none;
    height: 2px;
    background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
    margin: 32px 0;
    border-radius: 2px;
  }
  
  .promotion-card, .feedback-card {
    border-radius: 16px;
    transition: all 0.3s ease;
    background: rgba(248, 250, 252, 0.5);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(226, 232, 240, 0.8);
  }
  
  .promotion-card:hover, .feedback-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.1);
  }
  
  /* Responsive Design */
  @media (max-width: 768px) {
    .account-header h1 {
      font-size: 2rem;
    }
    
    .account-box {
      margin: 20px 10px;
      border-radius: 20px;
    }
    
    .nav-tabs {
      padding: 20px 15px 0;
      flex-wrap: wrap;
    }
    
    .nav-tabs .nav-link {
      padding: 10px 16px;
      font-size: 0.9rem;
      margin-bottom: 8px;
    }
    
    .tab-content {
      padding: 25px 20px;
    }
    
    .card-body {
      padding: 20px;
    }
    
    .btn-group {
      flex-direction: column;
      width: 100%;
    }
    
    .btn-group .btn {
      margin-bottom: 4px;
    }
  }
  
  @media (max-width: 575px) {
    .account-container {
      padding: 0 10px;
    }
    
    .account-header {
      margin-bottom: 20px;
    }
    
    .account-header h1 {
      font-size: 1.75rem;
    }
    
    .nav-tabs {
      padding: 15px 10px 0;
    }
    
    .nav-tabs .nav-link {
      padding: 8px 12px;
      font-size: 0.85rem;
    }
    
    .tab-content {
      padding: 20px 15px;
    }
  }
  
  /* Animation cho form elements */
  .form-control, .btn, .card {
    animation: fadeInUp 0.6s ease-out;
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
  
  /* Loading states */
  .btn-gradient:disabled {
    background: #9ca3af;
    cursor: not-allowed;
    transform: none;
  }
  
  .btn-gradient:disabled:hover {
    transform: none;
    box-shadow: none;
  }
  .nav-tabs .nav-link {
    color: #222 !important;
    background: rgba(255,255,255,0.85);
    font-weight: 600;
    opacity: 1 !important;
}
</style>

<div class="account-container">
  <div class="account-header">
    <h1>Quản lý tài khoản</h1>
    <p>Cập nhật thông tin cá nhân và quản lý tài khoản của bạn</p>
  </div>

  <div class="account-box">
    <ul class="nav nav-tabs mb-0" id="accountTab" role="tablist">
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
            echo '<i class="bi bi-geo-alt-fill" style="font-size: 3rem; color: #cbd5e1;"></i>';
            echo '<p class="text-muted mt-3 mb-4">Bạn chưa có địa chỉ nào. Vui lòng thêm địa chỉ giao hàng:</p>';
            echo '</div>';
          } else {
            foreach ($addresses as $ad) {
              $default = $ad['is_default'];
              echo '<div class="card mb-3 shadow-sm address-item" data-id="'.$ad['id'].'" style="border:'.($default?'2px solid #667eea;':'1px solid #e2e8f0;').'">';
              echo    '<div class="card-body d-flex justify-content-between align-items-center flex-wrap">';
              echo        '<div class="flex-grow-1">';
              echo            '<div style="font-size:17px;font-weight:600;color:#374151">'.htmlspecialchars($ad['address_line']).'</div>';
              echo            '<div class="text-muted" style="font-size:15px">'.htmlspecialchars($ad['city']).', '.htmlspecialchars($ad['country']);
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
              echo    '<div class="edit-form-container" style="display:none; padding:24px; margin:12px;">';
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
        <div class="card" style="border: 2px dashed #cbd5e1; background: rgba(248, 250, 252, 0.5);">
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