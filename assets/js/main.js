// assets/js/main.js

// Tìm kiếm sản phẩm
function searchProducts() {
    const searchInput = $('#search-input');
    const searchResults = $('#search-results-dropdown');

    searchInput.on('input', function() {
        let query = $(this).val();

        if (query.length < 2) { // Chỉ tìm kiếm khi có ít nhất 2 ký tự
            searchResults.hide();
            return;
        }

        $.ajax({
            url: `${BASE_URL}services/search_product.php`,
            method: 'GET',
            data: { q: query },
            dataType: 'json',
            success: function(data) {
                searchResults.empty();
                if (data.success && data.html) {
                    searchResults.html(data.html).show();
                } else {
                    searchResults.hide();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                searchResults.hide();
            }
        });
    });

    // Ẩn kết quả khi click ra ngoài
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#search-form').length) {
            searchResults.hide();
        }
    });

    $('#search-form').on('submit', function(e) {
        e.preventDefault();
        let query = searchInput.val();
        if (query) {
            window.location.href = `${BASE_URL}views/user/search.php?q=${encodeURIComponent(query)}`;
        }
    });
}

// Lọc sản phẩm
function filterProducts() {
    function handleFilterSubmit(form) {
        $.ajax({
            url: `${BASE_URL}services/filter_product.php`,
            method: 'GET',
            data: form.serialize(),
            success: function(data) {
                $('#product-list').html(data.html);
                // Đóng offcanvas sau khi lọc thành công
                var offcanvasElement = document.getElementById('offcanvasFilter');
                var offcanvas = bootstrap.Offcanvas.getInstance(offcanvasElement);
                if (offcanvas) {
                    offcanvas.hide();
                }
            },
            error: function() {
                alert('Lỗi khi lọc sản phẩm.');
            }
        });
    }

    $('#filter-form').on('submit', function(e) {
        e.preventDefault();
        handleFilterSubmit($(this));
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