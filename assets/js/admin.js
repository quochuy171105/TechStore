$(document).ready(function() {
    console.log('admin.js loaded');
    
    // Xử lý sidebar responsive
    $('.sidebar').on('mouseenter', function() {
        $(this).removeClass('active');
    }).on('mouseleave', function() {
        if ($('#sidebarCollapse').hasClass('active')) {
            $(this).addClass('active');
        }
    });
    
    // Xử lý xóa sản phẩm (chuyển sang non-AJAX)
    $(document).on('click', '.delete-product', function(e) {
        e.preventDefault();
        if (confirm('Bạn có chắc muốn xóa sản phẩm này?')) {
            let id = $(this).data('id');
            window.location.href = BASE_URL + 'admin.php?url=products/delete/' + id;
        }
    });

    // Xử lý hủy đơn hàng (chuyển sang non-AJAX)
    $(document).on('click', '.cancel-order', function(e) {
        e.preventDefault();
        if (confirm('Bạn có chắc muốn hủy đơn hàng này?')) {
            let id = $(this).data('id');
            window.location.href = BASE_URL + 'admin.php?url=orders/cancel/' + id;
        }
    });

    // Xử lý xóa khuyến mãi (chuyển sang non-AJAX)
    $(document).on('click', '.delete-promotion', function(e) {
        e.preventDefault();
        if (confirm('Bạn có chắc muốn xóa khuyến mãi này?')) {
            let id = $(this).data('id');
            window.location.href = BASE_URL + 'admin.php?url=promotions/delete/' + id;
        }
    });

    // Kiểm tra form product_create
    $('#product-create-form').validate({
        rules: {
            category_id: { required: true },
            brand_id: { required: true },
            name: { required: true, minlength: 3 },
            price: { required: true, number: true, min: 0 },
            stock: { required: true, number: true, min: 0 }
        },
        messages: {
            category_id: "Vui lòng chọn danh mục",
            brand_id: "Vui lòng chọn thương hiệu",
            name: {
                required: "Vui lòng nhập tên sản phẩm",
                minlength: "Tên sản phẩm phải có ít nhất 3 ký tự"
            },
            price: {
                required: "Vui lòng nhập giá",
                number: "Giá phải là số",
                min: "Giá phải lớn hơn hoặc bằng 0"
            },
            stock: {
                required: "Vui lòng nhập số lượng tồn kho",
                number: "Số lượng tồn kho phải là số",
                min: "Số lượng tồn kho phải lớn hơn hoặc bằng 0"
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
        // Loại bỏ submitHandler để form được xử lý mặc định
    });

    // Kiểm tra form order_update
    $('#order-update-form').validate({
        rules: {
            status: { required: true }
        },
        messages: {
            status: "Vui lòng chọn trạng thái"
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
        // Loại bỏ submitHandler để form được xử lý mặc định
    });

    
    // Kiểm tra form promotion_create
    $('#promotion-create-form').validate({
        rules: {
            code: { required: true, minlength: 3 },
            discount_type: { required: true },
            discount_value: {
                required: true,
                number: true,
                min: 0,
                max: function() {
                    return $('#discount_type').val() === 'percentage' ? 100 : undefined;
                }
            },
            start_date: { required: true },
            end_date: {
                required: true,
                dateGreaterThan: '#start_date'
            },
            min_order_amount: { number: true, min: 0 }
        },
        messages: {
            code: {
                required: "Vui lòng nhập mã khuyến mãi",
                minlength: "Mã khuyến mãi phải có ít nhất 3 ký tự"
            },
            discount_type: "Vui lòng chọn loại khuyến mãi",
            discount_value: {
                required: "Vui lòng nhập giá trị khuyến mãi",
                number: "Giá trị khuyến mãi phải là số",
                min: "Giá trị khuyến mãi phải lớn hơn hoặc bằng 0",
                max: "Giá trị khuyến mãi phần trăm không được vượt quá 100"
            },
            start_date: "Vui lòng chọn ngày bắt đầu",
            end_date: {
                required: "Vui lòng chọn ngày kết thúc",
                dateGreaterThan: "Ngày kết thúc phải sau ngày bắt đầu"
            },
            min_order_amount: {
                number: "Số tiền đơn hàng tối thiểu phải là số",
                min: "Số tiền đơn hàng tối thiểu phải lớn hơn hoặc bằng 0"
            }
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        highlight: function(element) {
            $(element).addClass('is-invalid');
        },
        unhighlight: function(element) {
            $(element).removeClass('is-invalid');
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        }
        // Loại bỏ submitHandler để form được xử lý mặc định
    });

    // Quy tắc tùy chỉnh để kiểm tra ngày kết thúc lớn hơn ngày bắt đầu
    $.validator.addMethod('dateGreaterThan', function(value, element, param) {
        let startDate = $(param).val();
        return !startDate || !value || new Date(value) >= new Date(startDate);
    }, 'Ngày kết thúc phải sau ngày bắt đầu');

    // Cập nhật nhãn discount_value dựa trên discount_type
    $('#discount_type').on('change', function() {
        let unit = $(this).val() === 'percentage' ? '%' : 'VND';
        $('#discount_value').attr('placeholder', 'Nhập giá trị (' + unit + ')');
    });

    // Xử lý thuộc tính động trong form product_create
    if ($('#attributes-container').length) {
        console.log('Attributes container found');
        let attributeIndex = $('.attribute-row').length;

        // Thêm thuộc tính mới
        $('#add-attribute').on('click', function() {
            console.log('Add attribute clicked, index:', attributeIndex);
            const newRow = `
                <div class="attribute-row mb-2 d-flex gap-2">
                    <input type="text" class="form-control" name="attributes[${attributeIndex}][name]" placeholder="Tên thuộc tính (VD: RAM)" required>
                    <input type="text" class="form-control" name="attributes[${attributeIndex}][value]" placeholder="Giá trị (VD: 8GB)" required>
                    <button type="button" class="btn btn-danger remove-attribute">Xóa</button>
                </div>`;
            $('#attributes-container').append(newRow);
            attributeIndex++;
            // Kích hoạt validate cho các input mới
            $('#product-create-form').validate().element(`[name="attributes[${attributeIndex-1}][name]"]`);
            $('#product-create-form').validate().element(`[name="attributes[${attributeIndex-1}][value]"]`);
        });

        // Xóa thuộc tính
        $(document).on('click', '.remove-attribute', function() {
            console.log('Remove attribute clicked');
            if ($('.attribute-row').length > 1) {
                $(this).closest('.attribute-row').remove();
                console.log('Attribute row removed, remaining:', $('.attribute-row').length);
            } else {
                alert('Phải có ít nhất một thuộc tính!');
            }
        });
    } 
});