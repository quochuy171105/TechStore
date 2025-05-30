<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Người dùng chưa đăng nhập, chuyển hướng về login
    header("Location: login.php");
    exit();
}
$userId = $_SESSION['user_id'];
require_once '../../controllers/CartController.php';

// Khởi tạo CartController
$cartController = new CartController();

// Lấy danh sách sản phẩm trong giỏ hàng
$cartItems = $cartController->getCartItems($userId);
?>
<?php include __DIR__ . '/../layouts/header.php'; ?>

<!-- Custom CSS for cart page -->
<style>
    .product-img {
        width: 60px;
        height: auto;
        max-width: 100%;
        object-fit: contain;
        border-radius: 8px;
    }

    .main-section {
        padding: 30px;
        flex: 1;
        min-height: calc(100vh - 200px);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        color: #1a1a1a;
    }

    .btn-checkout {
        background: linear-gradient(90deg, #40c4ff, #0288d1);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        padding: 12px 28px; 
        width: auto;       
        min-width: 0;      
        display: inline-block;
        transition: 0.3s;
        text-align: center;
    }
    .btn-checkout:hover {
        background: linear-gradient(90deg, #0288d1, #01579b);
    }

    .product-item img {
        width: 40px;
        height: auto;
        margin-right: 10px;
        vertical-align: middle;
    }

    .cart-table {
        background: white;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .cart-table th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #dee2e6;
        font-weight: 600;
    }

    .quantity-group {
        max-width: 120px;
    }
</style>

<div class="main-section container">
    <h2>Giỏ hàng của bạn</h2>

    <?php if (empty($cartItems)): ?>
        <div class="text-center">
            <p class="mb-4">Giỏ hàng của bạn đang trống.</p>
            <a href="<?= BASE_URL ?>" class="btn btn-primary">Tiếp tục mua sắm</a>
        </div>
    <?php else: ?>
        <div class="table-responsive mb-4">
            <table class="table cart-table">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Thành tiền</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-body">
                    <?php
                    $totalAmount = 0;
                    foreach ($cartItems as $item):
                        $subtotal = $item['price'] * $item['quantity'];
                        $totalAmount += $subtotal;
                    ?>
                        <tr data-cart-id="<?php echo $item['id']; ?>">
                            <td>
                                <div class="d-flex align-items-center">
                                    <img class="product-img" src="<?= IMAGES_PATH . htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <span class="product-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                </div>
                            </td>
                            <td class="price"><?php echo number_format($item['price'], 0, ',', '.'); ?>VNĐ</td>
                            <td>
                                <div class="input-group input-group-sm quantity-group">
                                    <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                    <input type="text" class="form-control text-center quantity-input" value="<?php echo $item['quantity']; ?>" readonly>
                                    <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                                </div>
                            </td>
                            <td class="subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?>VNĐ</td>
                            <td>
                                <button class="btn btn-sm btn-danger btn-delete" type="button">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Tổng cộng:</th>
                        <th id="total-price"><?php echo number_format($totalAmount, 0, ',', '.'); ?>VNĐ</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="text-end">
            <a href="<?= BASE_URL ?>views/user/checkout.php" class="btn btn-checkout">TIẾN HÀNH THANH TOÁN</a>
        </div>
    <?php endif; ?>
</div>

<!-- Custom JavaScript for cart functionality -->
<script>
    $(document).ready(function() {
        // Xử lý nút tăng số lượng
        $('.btn-increase').click(function() {
            let button = $(this);
            let quantityElement = button.closest('.quantity-group').find('.quantity-input');
            let cartId = parseInt(button.closest('tr').attr('data-cart-id'));
            let quantity = parseInt(quantityElement.val()) + 1;
            
            console.log('cartId:', cartId);
            console.log('quantity:', quantity);

            updateCart(cartId, quantity, button);
        });

        // Xử lý nút giảm số lượng
        $('.btn-decrease').click(function() {
            let button = $(this);
            let quantityElement = button.closest('.quantity-group').find('.quantity-input');
            let cartId = parseInt(button.closest('tr').attr('data-cart-id'));
            let quantity = parseInt(quantityElement.val()) - 1;

            if (quantity < 1) quantity = 1; // Không cho phép số lượng nhỏ hơn 1
            console.log('cartId:', cartId);
            console.log('quantity:', quantity);

            updateCart(cartId, quantity, button);
        });

        // Xử lý nút xóa sản phẩm
        $('.btn-delete').click(function() {
            if (confirm('Bạn có chắc chắn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                let button = $(this);
                let cartId = button.closest('tr').data('cart-id');

                $.ajax({
                    url: BASE_URL + 'services/update_cart.php',
                    type: 'POST',
                    data: {
                        action: 'delete',
                        cart_id: cartId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            button.closest('tr').remove(); // Xóa hàng khỏi giao diện
                            updateTotal(); // Cập nhật tổng tiền
                            if ($('#cart-body tr').length === 0) {
                                $('.main-section').html('<div class="text-center"><p class="mb-4">Giỏ hàng của bạn đang trống.</p><a href="' + BASE_URL + '" class="btn btn-primary">Tiếp tục mua sắm</a></div>');
                            }
                        } else {
                            alert('Lỗi: ' + response.message);
                        }
                    },
                    error: function() {
                        alert('Lỗi kết nối đến server');
                    }
                });
            }
        });

        // Hàm gửi yêu cầu AJAX để cập nhật số lượng
        function updateCart(cartId, quantity, button) {
            $.ajax({
                url: BASE_URL + 'services/update_cart.php',
                type: 'POST',
                data: {
                    action: 'update',
                    cart_id: cartId,
                    quantity: quantity
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        button.closest('.quantity-group').find('.quantity-input').val(quantity);// Cập nhật số lượng

                        // Lấy giá trị chuỗi gốc kiểu "24.900.000VNĐ"
                        let priceText = button.closest('tr').find('.price').text().replace('VNĐ', '');
                        // Chuyển chuỗi thành số nguyên (VD: "24.900.000" -> 24900000)
                        let price = parseInt(priceText.replace(/\./g, ''));

                        let subtotal = price * quantity;

                        button.closest('tr').find('.subtotal').text(
                            numberFormat(subtotal) + 'VNĐ'
                        );

                        updateTotal();
                    } else {
                        alert('Lỗi: ' + response.message);
                    }
                }
            });
        }

        // Hàm định dạng số nguyên (loại bỏ .00)
        function numberFormat(number) {
            return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Hàm cập nhật tổng tiền
        function updateTotal() {
            let total = 0;
            $('.subtotal').each(function() {
                let text = $(this).text().replace('VNĐ', '');
                // Bỏ dấu chấm để tính toán
                let number = parseInt(text.replace(/\./g, ''));
                total += number;
            });

            // Hiển thị tổng tiền chỉ với số nguyên
            $('#total-price').text(numberFormat(total) + 'VNĐ');
        }
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>