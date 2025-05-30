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
        height: 60px;
        max-width: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    .main-section {
        padding: 20px 15px;
        flex: 1;
        min-height: calc(100vh - 200px);
    }

    h2 {
        text-align: center;
        margin-bottom: 30px;
        font-weight: 600;
        color: #1a1a1a;
        font-size: 1.8rem;
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
        color: white;
        text-decoration: none;
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
        padding: 12px 8px;
        white-space: nowrap;
    }

    .cart-table td {
        padding: 12px 8px;
        vertical-align: middle;
    }

    .quantity-group {
        max-width: 120px;
        margin: 0 auto;
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .product-name {
        font-weight: 500;
        line-height: 1.3;
    }

    .price-text {
        font-weight: 600;
        color: #e74c3c;
        white-space: nowrap;
    }

    .subtotal {
        font-weight: 600;
        color: #27ae60;
        white-space: nowrap;
    }

    .empty-cart {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .empty-cart p {
        font-size: 1.2rem;
        color: #6c757d;
        margin-bottom: 30px;
    }

    .checkout-section {
        background: white;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-top: 20px;
    }

    .total-row {
        background-color: #f8f9fa;
        font-weight: 700;
        font-size: 1.1rem;
    }

    .total-row td, .total-row th {
        padding: 15px 8px;
    }

    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        .main-section {
            padding: 15px 10px;
        }

        h2 {
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        .product-img {
            width: 50px;
            height: 50px;
        }

        .cart-table {
            font-size: 0.9rem;
        }

        .cart-table th,
        .cart-table td {
            padding: 8px 4px;
        }

        .product-info {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }

        .product-name {
            font-size: 0.9rem;
            line-height: 1.2;
        }

        .quantity-group {
            max-width: 100px;
        }

        .quantity-group .btn {
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        .quantity-group input {
            padding: 4px;
            font-size: 0.8rem;
        }

        .btn-delete {
            padding: 4px 8px;
            font-size: 0.8rem;
        }

        .btn-checkout {
            width: 100%;
            padding: 15px;
            font-size: 1rem;
            margin-top: 15px;
        }

        .checkout-section {
            text-align: center;
        }

        /* Hide table headers on mobile and show card layout */
        .cart-table thead {
            display: none;
        }

        .cart-table,
        .cart-table tbody,
        .cart-table tr,
        .cart-table td {
            display: block;
        }

        .cart-table tr {
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 15px;
            padding: 15px;
            position: relative;
        }

        .cart-table td {
            border: none;
            padding: 8px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-table td:before {
            content: attr(data-label);
            font-weight: 600;
            color: #666;
            flex-basis: 40%;
            text-align: left;
        }

        .cart-table td:first-child {
            flex-direction: column;
            align-items: flex-start;
        }

        .cart-table td:first-child:before {
            display: none;
        }

        .total-row {
            background: none !important;
            border-top: 2px solid #dee2e6;
            margin-top: 10px;
            padding-top: 15px;
        }

        .total-row td {
            font-size: 1.1rem;
            font-weight: 700;
            color: #27ae60;
        }
    }

    @media (max-width: 480px) {
        .product-img {
            width: 40px;
            height: 40px;
        }

        .product-name {
            font-size: 0.85rem;
        }

        .cart-table {
            font-size: 0.85rem;
        }

        .quantity-group {
            max-width: 90px;
        }

        .btn-checkout {
            padding: 12px;
            font-size: 0.95rem;
        }
    }

    /* Tablet styles */
    @media (min-width: 769px) and (max-width: 1024px) {
        .main-section {
            padding: 25px 20px;
        }

        .product-img {
            width: 55px;
            height: 55px;
        }

        .cart-table th,
        .cart-table td {
            padding: 10px 6px;
        }
    }

    /* Large screen optimizations */
    @media (min-width: 1200px) {
        .main-section {
            padding: 40px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .product-img {
            width: 70px;
            height: 70px;
        }

        .cart-table th,
        .cart-table td {
            padding: 15px 12px;
        }

        .quantity-group {
            max-width: 140px;
        }
    }
</style>

<div class="main-section container-fluid">
    <h2>Giỏ hàng của bạn</h2>

    <?php if (empty($cartItems)): ?>
        <div class="empty-cart">
            <p>Giỏ hàng của bạn đang trống.</p>
            <a href="<?= BASE_URL ?>" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a>
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
                            <td data-label="Sản phẩm">
                                <div class="product-info">
                                    <img class="product-img" src="<?= IMAGES_PATH . htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                                    <span class="product-name"><?php echo htmlspecialchars($item['name']); ?></span>
                                </div>
                            </td>
                            <td data-label="Đơn giá" class="price price-text"><?php echo number_format($item['price'], 0, ',', '.'); ?>VNĐ</td>
                            <td data-label="Số lượng">
                                <div class="input-group input-group-sm quantity-group">
                                    <button class="btn btn-outline-secondary btn-decrease" type="button">-</button>
                                    <input type="text" class="form-control text-center quantity-input" value="<?php echo $item['quantity']; ?>" readonly>
                                    <button class="btn btn-outline-secondary btn-increase" type="button">+</button>
                                </div>
                            </td>
                            <td data-label="Thành tiền" class="subtotal"><?php echo number_format($subtotal, 0, ',', '.'); ?>VNĐ</td>
                            <td data-label="">
                                <button class="btn btn-sm btn-danger btn-delete" type="button">Xóa</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="total-row">
                        <th colspan="3" class="text-end">Tổng cộng:</th>
                        <th id="total-price"><?php echo number_format($totalAmount, 0, ',', '.'); ?>VNĐ</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="checkout-section">
            <div class="text-end">
                <a href="<?= BASE_URL ?>views/user/checkout.php" class="btn btn-checkout">TIẾN HÀNH THANH TOÁN</a>
            </div>
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
                                $('.main-section').html('<div class="empty-cart"><p>Giỏ hàng của bạn đang trống.</p><a href="' + BASE_URL + '" class="btn btn-primary btn-lg">Tiếp tục mua sắm</a></div>');
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