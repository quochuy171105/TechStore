$(document).ready(function() {
    // Lấy url động từ đường dẫn hiện tại (có thể fix cứng nếu biết chắc)
    console.log("JS mainTV3.js đã chạy!");

    var accountUrl = window.location.pathname + window.location.search;

    // Cập nhật thông tin tài khoản (AJAX)
    $('#accountForm').on('submit', function(e) {
        e.preventDefault();
        $('.form-error').text('');
        $('#info-message').removeClass('alert alert-success alert-danger').text('');
        $.ajax({
            type: 'POST',
            url: accountUrl,
            data: $(this).serialize(),
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    $('#info-message').addClass('alert alert-success').text(res.message || 'Cập nhật thành công!');
                    if(res.user) {
                        $('#name').val(res.user.name);
                        $('#email').val(res.user.email);
                        $('#phone').val(res.user.phone);
                    }
                    $('#password').val('');
                    $('#confirm_password').val('');
                } else {
                    $('#info-message').addClass('alert alert-danger').text(res.message || 'Có lỗi, vui lòng kiểm tra lại.');
                    if(res.errors) {
                        Object.keys(res.errors).forEach(function(field) {
                            $('#error-' + field).text(res.errors[field]);
                        });
                    }
                }
            },
            error: function() {
                $('#info-message').addClass('alert alert-danger').text('Có lỗi hệ thống!');
            }
        });
    });

    // Thêm địa chỉ mới
    $('#addAddressForm').on('submit', function(e) {
        e.preventDefault();
        $('#address-msg').removeClass('text-success text-danger').text('');
        $.ajax({
            type: 'POST',
            url: accountUrl,
            data: $(this).serialize() + '&address_action=1&action=add',
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    $('#address-msg').addClass('text-success').text('Thêm địa chỉ thành công!');
                    reloadAddressList();
                    $('#addAddressForm')[0].reset();
                } else {
                    $('#address-msg').addClass('text-danger').text(res.message || 'Không thể thêm địa chỉ!');
                }
            },
            error: function() {
                $('#address-msg').addClass('text-danger').text('Lỗi hệ thống!');
            }
        });
    });

    // Hiện form sửa địa chỉ
    $(document).on('click', '.edit-address', function() {
        $('.edit-form-container').hide();
        $(this).closest('.address-item').find('.edit-form-container').show();
    });

    // Đóng form sửa
    $(document).on('click', '.cancel-edit', function() {
        $(this).closest('.edit-form-container').hide();
    });

    // Submit sửa địa chỉ
    $(document).on('submit', '.edit-address-form', function(e) {
        e.preventDefault();
        var form = $(this);
        var addressId = form.data('id');
        var data = form.serialize() + '&address_action=1&action=edit&address_id=' + addressId;
        $.ajax({
            type: 'POST',
            url: accountUrl,
            data: data,
            dataType: 'json',
            success: function(res) {
                if(res.success) {
                    reloadAddressList();
                } else {
                    alert(res.message || 'Cập nhật địa chỉ thất bại!');
                }
            },
            error: function() {
                alert('Lỗi hệ thống khi cập nhật địa chỉ!');
            }
        });
    });

    // Đặt làm mặc định
    $(document).on('click', '.set-default', function() {
        var id = $(this).data('id');
        $.post(accountUrl, {address_action:1, action:'set_default', address_id:id}, function(res) {
            if(res.success) reloadAddressList();
            else alert(res.message || 'Không thể đổi mặc định');
        },'json');
    });

    // Xóa địa chỉ
    $(document).on('click', '.delete-address', function() {
        if(!confirm('Bạn chắc chắn muốn xóa địa chỉ này?')) return;
        var id = $(this).data('id');
        $.post(accountUrl, {address_action:1, action:'delete', address_id:id}, function(res) {
            if(res.success) reloadAddressList();
            else alert(res.message || 'Không thể xóa');
        },'json');
    });

    // Load lại danh sách địa chỉ
    function reloadAddressList() {
        $.post(accountUrl, {address_action:1, action:'list'}, function(listres) {
            if(listres.success) {
                $('#address-list').html(listres.html);
            }
        }, 'json');
    }
});
