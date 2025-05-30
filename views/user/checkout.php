<?php
//session_start();

require_once '../../controllers/OrderController.php';

// ✅ Kiểm tra người dùng đã đăng nhập hay chưa
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['user_id']; // Đảm bảo đã đăng nhập mới dùng được

$pdo = Database::getInstance();
$orderController = new OrderController($pdo); // Khởi tạo controller

// ✅ Kết nối cơ sở dữ liệu (nên viết trong file config/database.php để tái sử dụng)
$host = 'localhost';
$dbname = 'doancuoikylaptrinhweb';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Lỗi kết nối CSDL: " . $e->getMessage());
}

// Lấy thông tin người dùng từ bảng users
$stmtUser = $pdo->prepare("SELECT name, phone FROM users WHERE id = :user_id");
$stmtUser->execute(['user_id' => $userId]);
$userData = $stmtUser->fetch(PDO::FETCH_ASSOC);

if (!$userData) {
    die("Không tìm thấy thông tin người dùng với ID: " . $userId);
}

$name = $userData['name'] ?? '';
$phone = $userData['phone'] ?? '';

// Lấy địa chỉ mặc định từ bảng addresses
$stmtAddress = $pdo->prepare("SELECT address_line, city, postal_code, country FROM addresses WHERE user_id = :user_id AND is_default = TRUE");
$stmtAddress->execute(['user_id' => $userId]);
$addressData = $stmtAddress->fetch(PDO::FETCH_ASSOC);

if (!$addressData) {
    $addressLine = '';
    $city = 'Hà Nội';
    $postalCode = '';
    $country = 'Vietnam';
} else {
    $addressLine = $addressData['address_line'] ?? '';
    $city = $addressData['city'] ?? 'Hà Nội';
    $postalCode = $addressData['postal_code'] ?? '';
    $country = $addressData['country'] ?? 'Vietnam';
}

// Lấy dữ liệu trực tiếp từ bảng cart theo user_id
$stmtCart = $pdo->prepare("
    SELECT c.product_id, c.quantity, p.name, p.price, p.image
    FROM cart c
    JOIN products p ON c.product_id = p.id
    WHERE c.user_id = :user_id
");
$stmtCart->execute(['user_id' => $userId]);
$cartItems = $stmtCart->fetchAll(PDO::FETCH_ASSOC);

$totalPrice = 0;
foreach ($cartItems as $item) {
    $totalPrice += $item['price'] * $item['quantity'];
}

$originalTotalPrice = $totalPrice; // Lưu giá trị ban đầu để hiển thị tổng tiền hàng

// Lấy danh sách mã giảm giá hợp lệ
$currentDate = date('Y-m-d');
$promoOptions = [];
$promoData = []; // Lưu dữ liệu chi tiết của mã giảm giá để sử dụng trong JavaScript
$stmtPromos = $pdo->prepare("
    SELECT code, discount_type, discount_value, min_order_amount 
    FROM promotions 
    WHERE start_date <= :current_date 
    AND end_date >= :current_date 
    AND min_order_amount <= :total_price
");
$stmtPromos->execute([
    'current_date' => $currentDate,
    'total_price' => $totalPrice
]);
$promotions = $stmtPromos->fetchAll(PDO::FETCH_ASSOC);
foreach ($promotions as $promo) {
    $promoOptions[$promo['code']] = $promo['code'] . ' (' . ($promo['discount_type'] === 'percentage' ? $promo['discount_value'] . '%' : number_format($promo['discount_value'], 0, ',', '.') . 'đ') . ')';
    $promoData[$promo['code']] = [
        'discount_type' => $promo['discount_type'],
        'discount_value' => $promo['discount_value']
    ];
}

// Chuyển dữ liệu mã giảm giá sang JavaScript
$promoDataJson = json_encode($promoData);

// Xử lý yêu cầu AJAX để lưu đơn hàng
if (isset($_POST['action']) && $_POST['action'] === 'confirm_payment') {
    header('Content-Type: application/json');

    $paymentMethod = $_POST['paymentMethod'] ?? '';
    $promoCode = $_POST['promoCode'] ?? '';
    $totalPrice = floatval($_POST['totalPrice'] ?? $originalTotalPrice);

    // Áp dụng mã giảm giá
    $discount = 0;
    if (!empty($promoCode) && isset($promoData[$promoCode])) {
        $promo = $promoData[$promoCode];
        if ($promo['discount_type'] === 'percentage') {
            $discount = $totalPrice * ($promo['discount_value'] / 100);
        } else {
            $discount = $promo['discount_value'];
        }
        $discount = min($discount, $totalPrice);
        $totalPrice -= $discount;
    }

    $response = ['success' => false, 'message' => 'Lỗi không xác định'];

    try {
        $pdo->beginTransaction();

        // Lưu địa chỉ vào bảng addresses
        $stmtAddressCheck = $pdo->prepare("SELECT id FROM addresses WHERE user_id = :user_id AND is_default = TRUE");
        $stmtAddressCheck->execute(['user_id' => $userId]);
        $existingAddress = $stmtAddressCheck->fetch(PDO::FETCH_ASSOC);

        if (!$existingAddress) {
            $stmtAddressInsert = $pdo->prepare("INSERT INTO addresses (user_id, address_line, city, postal_code, country, is_default) VALUES (:user_id, :address_line, :city, :postal_code, :country, TRUE)");
            $stmtAddressInsert->execute([
                'user_id' => $userId,
                'address_line' => $addressLine,
                'city' => $city,
                'postal_code' => $postalCode,
                'country' => $country
            ]);
            $addressId = $pdo->lastInsertId();
        } else {
            $addressId = $existingAddress['id'];
        }

        // Tạo đơn hàng
        $result = $orderController->createOrder($userId, $addressId, $totalPrice, $paymentMethod, $cartItems);

        if ($result['success']) {
            // Xóa giỏ hàng
            $deleteStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
            $deleteStmt->execute(['user_id' => $userId]);
            $response = ['success' => true, 'order_id' => $result['order_id']];
        } else {
            $response = ['success' => false, 'message' => $result['message']];
        }

        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        $response = ['success' => false, 'message' => 'Lỗi khi lưu đơn hàng: ' . $e->getMessage()];
    }

    echo json_encode($response);
    exit;
}

// Xử lý khi nhấn "Xác nhận đặt hàng"
$paymentMethod = '';
$promoCode = '';
$isOrderPending = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_order'])) {
    $paymentMethod = $_POST['paymentMethod'];
    $promoCode = $_POST['promo_code'] ?? '';

    if (empty($paymentMethod)) {
        $error = "Vui lòng chọn phương thức thanh toán!";
    } elseif (empty($cartItems)) {
        $error = "Giỏ hàng của bạn đang trống. Vui lòng thêm sản phẩm trước khi thanh toán!";
    } else {
        // Nếu là COD, lưu đơn hàng ngay
        if ($paymentMethod === 'tiền_mặt') {
            try {
                $totalPriceAfterDiscount = $originalTotalPrice;
                if (!empty($promoCode) && isset($promoData[$promoCode])) {
                    $promo = $promoData[$promoCode];
                    $discount = $promo['discount_type'] === 'percentage' ? $totalPriceAfterDiscount * ($promo['discount_value'] / 100) : $promo['discount_value'];
                    $discount = min($discount, $totalPriceAfterDiscount);
                    $totalPriceAfterDiscount -= $discount;
                }

                $pdo->beginTransaction();

                // Lưu địa chỉ
                $stmtAddressCheck = $pdo->prepare("SELECT id FROM addresses WHERE user_id = :user_id AND is_default = TRUE");
                $stmtAddressCheck->execute(['user_id' => $userId]);
                $existingAddress = $stmtAddressCheck->fetch(PDO::FETCH_ASSOC);

                if (!$existingAddress) {
                    $stmtAddressInsert = $pdo->prepare("INSERT INTO addresses (user_id, address_line, city, postal_code, country, is_default) VALUES (:user_id, :address_line, :city, :postal_code, :country, TRUE)");
                    $stmtAddressInsert->execute([
                        'user_id' => $userId,
                        'address_line' => $addressLine,
                        'city' => $city,
                        'postal_code' => $postalCode,
                        'country' => $country
                    ]);
                    $addressId = $pdo->lastInsertId();
                } else {
                    $addressId = $existingAddress['id'];
                }

                // Tạo đơn hàng
                $result = $orderController->createOrder($userId, $addressId, $totalPriceAfterDiscount, $paymentMethod, $cartItems);

                $pdo->commit();
                if ($result['success']) {
                    $success = true;
                    $orderId = $result['order_id'];

                    // Xóa giỏ hàng
                    $deleteStmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
                    $deleteStmt->execute(['user_id' => $userId]);

                    // Cập nhật trạng thái
                    $cartItems = [];
                    $totalPrice = 0;
                    $originalTotalPrice = 0;
                    // Chuyển hướng ngay sau khi thành công
                    header("Location: order_history.php?order_id=" . $orderId);
                    exit;
                } else {
                    $error = $result['message'];
                }
            } catch (Exception $e) {
                $pdo->rollBack();
                $error = "Lỗi khi đặt hàng: " . $e->getMessage();
            }
        } else if ($paymentMethod === 'chuyển_khoản') {
            // Với chuyển khoản, chỉ đặt trạng thái chờ xác nhận
            $isOrderPending = true;
        }
    }
}
include __DIR__ . '/../layouts/header.php';
?>




    <meta charset="UTF-8">
    <title>Thanh Toán - Shop TMĐT Điện Thoại</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>

        .main-content {
            padding: 30px 0;
        }

        .form-section,
        .summary-section {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
        }

        h2 {
            font-size: 1.8rem;
            font-weight: 600;
            text-align: center;
            margin-bottom: 30px;
        }

        .btn-checkout {
            background: linear-gradient(to right, #40c4ff, #0288d1);
            color: #fff;
            font-weight: 600;
            padding: 12px;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn-checkout:hover {
            background: linear-gradient(to right, #0288d1, #01579b);
        }

        .btn-confirm-payment {
            background: linear-gradient(to right, #28a745, #218838);
            color: #fff;
            font-weight: 600;
            padding: 10px;
            border: none;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        .btn-confirm-payment:hover {
            background: linear-gradient(to right, #218838, #1e7e34);
        }

        .product-img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            border-radius: 8px;
            margin-right: 10px;
        }

        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .product-details {
            display: flex;
            align-items: center;
        }

        .price-details {
            margin: 20px 0;
        }

        .price-detail {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .price-detail .label {
            font-weight: bold;
        }

        .price-detail .value {
            font-weight: bold;
            color: #000;
        }

        .price-detail.discount {
            color: #ff0000;
        }

        .final-price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #000;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
        }
    </style>



    <div class="main-content container">
        <h2>Thanh toán đơn hàng</h2>
        <div class="row g-4">
            <!-- Form Thông Tin Giao Hàng -->
            <div class="col-md-7">
                <div class="form-section">
                    <h5 class="mb-3">Thông tin giao hàng</h5>
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <form method="POST" id="checkout-form">
                        <div class="mb-3">
                            <label class="form-label">Họ tên</label>
                            <input name="name" type="text" class="form-control" value="<?php echo htmlspecialchars($name); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại</label>
                            <input name="phone" type="tel" class="form-control" value="<?php echo htmlspecialchars($phone); ?>" readonly>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Địa chỉ</label>
                            <textarea name="address" class="form-control" rows="3" readonly>
                                <?php echo htmlspecialchars($addressLine . ', ' . $city . ', ' . $postalCode . ', ' . $country); ?>
                            </textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Mã giảm giá</label>
                            <select name="promo_code" id="promo-code" class="form-select">
                                <option value="">-- Chọn mã giảm giá --</option>
                                <?php foreach ($promoOptions as $code => $label): ?>
                                    <option value="<?php echo htmlspecialchars($code); ?>" <?php echo ($_POST['promo_code'] ?? '') === $code ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($label); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Phương thức thanh toán</label>
                            <select name="paymentMethod" id="payment-method" class="form-select" required>
                                <option value="" disabled <?php echo !isset($_POST['paymentMethod']) ? 'selected' : ''; ?>>-- Chọn phương thức --</option>
                                <option value="tiền_mặt" <?php echo ($_POST['paymentMethod'] ?? '') === 'tiền_mặt' ? 'selected' : ''; ?>>Thanh toán khi nhận hàng (COD)</option>
                                <option value="chuyển_khoản" <?php echo ($_POST['paymentMethod'] ?? '') === 'chuyển_khoản' ? 'selected' : ''; ?>>Chuyển khoản ngân hàng</option>
                            </select>
                        </div>
                        <div class="price-details">
                            <div class="price-detail">
                                <span class="label">Tổng tiền hàng</span>
                                <span class="value" id="original-price"><?php echo number_format($originalTotalPrice, 0, ',', '.'); ?>đ</span>
                            </div>
                            <div class="price-detail discount" id="discount-section" style="display: none;">
                                <span class="label">Mã giảm giá</span>
                                <span class="value" id="discount-amount"></span>
                            </div>
                            <div class="final-price">
                                <span>Thành tiền:</span>
                                <span id="final-price"><?php echo number_format($originalTotalPrice, 0, ',', '.'); ?>đ</span>
                            </div>
                        </div>
                        <button type="submit" name="confirm_order" class="btn btn-checkout w-100">Xác nhận đặt hàng</button>
                    </form>
                </div>
            </div>

            <!-- Tóm tắt đơn hàng -->
            <div class="col-md-5">
                <div class="summary-section">
                    <h5 class="mb-3">Đơn hàng của bạn</h5>
                    <?php if (empty($cartItems)): ?>
                        <p class="text-muted text-center">Giỏ hàng của bạn đang trống.</p>
                    <?php else: ?>
                        <ul class="list-group mb-3">
                            <?php foreach ($cartItems as $item): ?>
                                <li class="list-group-item product-item">
                                    <div class="product-details">
                                        <img src="<?= BASE_URL ?>assets/image/<?= htmlspecialchars($item['image']) ?>" class="product-img" alt="Ảnh sản phẩm">
                                        <div>
                                            <strong><?php echo htmlspecialchars($item['name']); ?></strong><br>
                                            x<?php echo $item['quantity']; ?>
                                        </div>
                                    </div>
                                    <div>
                                        <strong><?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?>đ</strong>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <!-- Nếu là chuyển khoản và đang chờ xác nhận -->
                    <?php if ($isOrderPending && $paymentMethod === 'chuyển_khoản'): ?>
                        <div class="mt-3 text-center">
                            <p>Vui lòng quét mã QR để chuyển khoản:</p>
                            <?php if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/DoAnCuoiKiLapTrinhWeb2/assets/image/maqr2.png")): ?>
                                <img src="/DoAnCuoiKiLapTrinhWeb2/assets/image/maqr2.png" alt="QR Code" class="img-fluid" style="max-width:200px;">
                            <?php else: ?>
                                <p class="text-muted">[Không tìm thấy mã QR]</p>
                            <?php endif; ?>
                            <button id="confirm-payment-btn" class="btn btn-confirm-payment w-100 mt-3">Xác nhận thanh toán</button>
                            <div id="payment-status" class="alert alert-info mt-2" style="display: none;">
                                Đơn hàng đang chờ xác nhận thanh toán. Vui lòng liên hệ nếu cần hỗ trợ.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const originalPrice = <?php echo $originalTotalPrice; ?>;
            const promoData = <?php echo $promoDataJson; ?>;
            const formatNumber = (num) => num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');

            const promoSelect = document.getElementById('promo-code');
            const discountSection = document.getElementById('discount-section');
            const discountAmount = document.getElementById('discount-amount');
            const finalPrice = document.getElementById('final-price');

            promoSelect.addEventListener('change', function() {
                const promoCode = this.value;

                if (!promoCode || !promoData[promoCode]) {
                    discountSection.style.display = 'none';
                    finalPrice.textContent = formatNumber(originalPrice) + 'đ';
                    return;
                }

                const promo = promoData[promoCode];
                let discount = 0;

                if (promo.discount_type === 'percentage') {
                    discount = originalPrice * (promo.discount_value / 100);
                } else {
                    discount = promo.discount_value;
                }

                discount = Math.min(discount, originalPrice);
                const finalPriceValue = originalPrice - discount;

                discountSection.style.display = 'flex';
                discountAmount.textContent = '-' + formatNumber(discount) + 'đ (' + promoCode + ')';
                finalPrice.textContent = formatNumber(finalPriceValue) + 'đ';
            });

            // Xử lý nút "Xác nhận thanh toán"
            const confirmPaymentBtn = document.getElementById('confirm-payment-btn');
            const paymentStatus = document.getElementById('payment-status');

            if (confirmPaymentBtn) {
                confirmPaymentBtn.addEventListener('click', function() {
                    // Vô hiệu hóa nút để tránh nhấn lại
                    confirmPaymentBtn.disabled = true;
                    confirmPaymentBtn.textContent = 'Đang xử lý...';

                    // Chờ 3 giây trước khi gửi yêu cầu AJAX
                    setTimeout(function() {
                        const paymentMethod = document.getElementById('payment-method').value;
                        const promoCode = document.getElementById('promo-code').value;

                        fetch(window.location.href, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/x-www-form-urlencoded',
                                },
                                body: 'action=confirm_payment&paymentMethod=' + encodeURIComponent(paymentMethod) + '&promoCode=' + encodeURIComponent(promoCode) + '&totalPrice=' + originalPrice
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    // Chuyển hướng sau khi thành công
                                    window.location.href = 'order_history.php?order_id=' + data.order_id;
                                } else {
                                    paymentStatus.classList.remove('alert-info');
                                    paymentStatus.classList.add('alert-danger');
                                    paymentStatus.textContent = 'Lỗi: ' + data.message;
                                    paymentStatus.style.display = 'block';
                                    confirmPaymentBtn.disabled = false;
                                    confirmPaymentBtn.textContent = 'Xác nhận thanh toán';
                                }
                            })
                            .catch(error => {
                                paymentStatus.classList.remove('alert-info');
                                paymentStatus.classList.add('alert-danger');
                                paymentStatus.textContent = 'Lỗi server: ' + error;
                                paymentStatus.style.display = 'block';
                                confirmPaymentBtn.disabled = false;
                                confirmPaymentBtn.textContent = 'Xác nhận thanh toán';
                            });
                    }, 2000); // Chờ 2 giây
                });
            }
        });
    </script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>