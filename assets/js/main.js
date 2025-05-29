// assets/js/main.js

// Tìm kiếm sản phẩm
function searchProducts() {
    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        let query = $('#search-input').val();
        window.location.href = `${BASE_URL}views/user/search.php?q=${encodeURIComponent(query)}`;
    });

    $('#search-filter-form').on('submit', function(e) {
        e.preventDefault();
        /*$.ajax({
            url: `${BASE_URL}services/search_product.php`,
            method: 'GET',
            data: $(this).serialize(),
            success: function(data) {
                $('#search-results').html(data.html);
            },
            error: function() {
                alert('Lỗi khi tìm kiếm sản phẩm.');
            }
        });*/
    });
}

// Lọc sản phẩm
function filterProducts() {
    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: `${BASE_URL}services/filter_product.php`,
            method: 'GET',
            data: $(this).serialize(),
            success: function(data) {
                $('#product-list').html(data.html);
            },
            error: function() {
                alert('Lỗi khi lọc sản phẩm.');
            }
        });
    });
}

// Lấy chi tiết sản phẩm (không sử dụng trong giao diện tĩnh, để dành cho tích hợp động nếu cần)
function getProductDetail(productId) {
    $.ajax({
        url: `${BASE_URL}services/get_product.php`,
        method: 'GET',
        data: { id: productId },
        success: function(data) {
            // Xử lý dữ liệu chi tiết sản phẩm nếu cần
            console.log(data);
        },
        error: function() {
            alert('Lỗi khi lấy chi tiết sản phẩm.');
        }
    });
}

// Gọi các hàm

// function addToCart(productId) {}
function updateCart(productId, quantity) {
    $.ajax({
        url: 'services/update_cart.php',
        method: 'POST',
        data: { product_id: productId, quantity: quantity },
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                // Cập nhật lại tổng tiền trên trang
                $('#cart-total').text(new Intl.NumberFormat('vi-VN', { style: 'currency', currency: 'VND' }).format(response.total));
            } else {
                alert('Cập nhật giỏ hàng thất bại: ' + response.message);
            }
        },
        error: function() {
            alert('Lỗi hệ thống, vui lòng thử lại!');
        }
    });
}

$(document).on('change', '.cart-quantity-input', function() {
    var productId = $(this).data('product-id');
    var quantity = parseInt($(this).val());
    if (quantity < 1) {
        quantity = 1;
        $(this).val(quantity);
    }
    updateCart(productId, quantity);
});

$(document).on('click', '.btn-remove-cart-item', function() {
    var productId = $(this).data('product-id');
    updateCart(productId, 0);
    // Xóa dòng sản phẩm trên giao diện ngay lập tức (tùy chọn)
    $(this).closest('tr').remove();
});
$(document).ready(function() {
    searchProducts();
    filterProducts();
});