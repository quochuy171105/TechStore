<?php
require_once __DIR__ . '/../../layouts/header.php';
?>
<style>
    .policy-container {
        max-width: 900px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
        padding: 40px 50px;
        margin: 40px auto;
    }
    .policy-header {
        color: #1a2533;
        font-weight: 700;
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e9ecef;
    }
    .policy-section-title {
        color: #007bff;
        font-weight: 600;
        font-size: 1.25rem;
        margin-top: 30px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    .policy-section-title i {
        margin-right: 12px;
        font-size: 1.5rem;
    }
    .policy-content p, .policy-content li {
        color: #495057;
        line-height: 1.8;
        margin-bottom: 10px;
    }
    .policy-content ul {
        padding-left: 25px;
        list-style-type: disc;
    }
    .policy-content li::marker {
        color: #007bff;
    }
    .contact-info {
        background-color: #f8f9fa;
        border-top: 2px solid #e9ecef;
        padding: 20px;
        margin-top: 30px;
        text-align: center;
        border-radius: 0 0 15px 15px;
    }
</style>
<div class="container">
    <div class="policy-container">
        <h1 class="policy-header">Chính Sách Giao Hàng</h1>
        <div class="policy-content">

            <h2 class="policy-section-title"><i class="fas fa-shipping-fast"></i>1. Phí Vận Chuyển</h2>
            <p>TechStore áp dụng biểu phí vận chuyển linh hoạt tùy thuộc vào địa chỉ nhận hàng và trọng lượng của đơn hàng. Phí vận chuyển sẽ được hiển thị rõ ràng ở bước thanh toán.</p>
            <ul>
                <li><strong>Miễn phí vận chuyển</strong> cho các đơn hàng có giá trị từ <strong>1.000.000 VNĐ</strong> trở lên tại khu vực nội thành TP.HCM và Hà Nội.</li>
                <li>Đối với các khu vực khác, phí vận chuyển sẽ được tính theo bảng giá của đối tác vận chuyển uy tín.</li>
            </ul>

            <h2 class="policy-section-title"><i class="far fa-clock"></i>2. Thời Gian Giao Hàng</h2>
            <ul>
                <li><strong>Nội thành TP.HCM và Hà Nội:</strong> Giao hàng trong vòng 24 giờ kể từ khi xác nhận đơn hàng.</li>
                <li><strong>Các tỉnh thành khác:</strong> Từ 2-5 ngày làm việc tùy thuộc vào địa chỉ của quý khách.</li>
                <li>Thời gian giao hàng không bao gồm Chủ Nhật và các ngày lễ, Tết.</li>
            </ul>

            <h2 class="policy-section-title"><i class="fas fa-check-square"></i>3. Kiểm Tra Hàng Hóa</h2>
            <p>Quý khách vui lòng kiểm tra kỹ lưỡng sản phẩm ngay khi nhận hàng. Nếu phát hiện sản phẩm bị hư hỏng, trầy xước, hoặc không đúng như mô tả, quý khách có quyền từ chối nhận hàng và liên hệ ngay với chúng tôi để được hỗ trợ.</p>

            <div class="contact-info">
                <h2 class="policy-section-title" style="color: #28a745;"><i class="fas fa-headset"></i>4. Liên Hệ Hỗ Trợ</h2>
                <p>Mọi thắc mắc về quá trình giao hàng, vui lòng liên hệ:</p>
                <p><strong>Hotline:</strong> 1900 1234<br><strong>Email:</strong> support@HNQNHstore.com</p>
            </div>
        </div>
    </div>
</div>
<?php
require_once __DIR__ . '/../../layouts/footer.php';
?>