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

        if (quantity < 1) quantity = 1;
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
                url: '../../services/update_cart.php',
                type: 'POST',
                data: {
                    action: 'delete',
                    cart_id: cartId
                },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        button.closest('tr').remove();
                        updateTotal();
                        if ($('#cart-body tr').length === 0) {
                            $('.main-section').html('<p class="text-center">Giỏ hàng của bạn đang trống.</p>');
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
            url: '../../services/update_cart.php',
            type: 'POST',
            data: {
                action: 'update',
                cart_id: cartId,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    button.closest('.quantity-group').find('.quantity-input').val(quantity);

                    let priceText = button.closest('tr').find('.price').text().replace('VNĐ', '');
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

    // Hàm định dạng số nguyên
    function numberFormat(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    // Hàm cập nhật tổng tiền
    function updateTotal() {
        let total = 0;
        $('.subtotal').each(function() {
            let text = $(this).text().replace('VNĐ', '');
            let number = parseInt(text.replace(/\./g, ''));
            total += number;
        });

        $('#total-price').text(numberFormat(total) + 'VNĐ');
    }
});