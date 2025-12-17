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
        <h1 class="policy-header">Chính Sách Đổi Trả</h1>
        <div class="policy-content">

            <h2 class="policy-section-title"><i class="fas fa-box-open"></i>1. Thời Gian Đổi Trả</h2>
            <p>TechStore hỗ trợ đổi trả sản phẩm trong vòng <strong>7 ngày</strong> kể từ ngày quý khách nhận hàng nếu sản phẩm gặp lỗi từ nhà sản xuất hoặc không đúng như mô tả.</p>

            <h2 class="policy-section-title"><i class="fas fa-clipboard-check"></i>2. Điều Kiện Đổi Trả</h2>
            <ul>
                <li>Sản phẩm phải còn nguyên vẹn, chưa qua sử dụng, đầy đủ tem mác, phụ kiện và quà tặng đi kèm (nếu có).</li>
                <li>Sản phẩm bị lỗi kỹ thuật do nhà sản xuất, được xác nhận bởi đội ngũ kỹ thuật của TechStore.</li>
                <li>Sản phẩm giao không đúng mẫu mã, chủng loại mà khách hàng đã đặt.</li>
                <li>Hóa đơn mua hàng hoặc biên nhận giao hàng phải được giữ lại để đối chiếu.</li>
            </ul>

            <h2 class="policy-section-title" style="color: #dc3545;"><i class="fas fa-ban"></i>3. Trường Hợp Không Áp Dụng Đổi Trả</h2>
            <ul>
                <li>Sản phẩm đã quá thời hạn 7 ngày đổi trả.</li>
                <li>Sản phẩm bị hư hỏng do người dùng, không phải lỗi từ nhà sản xuất.</li>
                <li>Sản phẩm không còn đầy đủ phụ kiện, hộp, hoặc tem mác bị rách, biến dạng.</li>
                <li>Các sản phẩm trong chương trình khuyến mãi, giảm giá đặc biệt (sẽ được ghi chú rõ).</li>
            </ul>

            <h2 class="policy-section-title"><i class="fas fa-exchange-alt"></i>4. Quy Trình Đổi Trả</h2>
            <p><strong>Bước 1:</strong> Liên hệ bộ phận chăm sóc khách hàng của TechStore qua hotline hoặc email để yêu cầu đổi trả.</p>
            <p><strong>Bước 2:</strong> Đóng gói sản phẩm cẩn thận và gửi về địa chỉ do TechStore cung cấp.</p>
            <p><strong>Bước 3:</strong> Sau khi nhận được sản phẩm, chúng tôi sẽ tiến hành kiểm tra và thông báo kết quả cho quý khách trong vòng 3-5 ngày làm việc.</p>
            <p><strong>Bước 4:</strong> Nếu đủ điều kiện, TechStore sẽ tiến hành đổi sản phẩm mới hoặc hoàn lại tiền cho quý khách.</p>

            <div class="contact-info">
                <h2 class="policy-section-title" style="color: #28a745;"><i class="fas fa-headset"></i>5. Liên Hệ Hỗ Trợ</h2>
                <p>Mọi thắc mắc về quy trình đổi trả, vui lòng liên hệ:</p>
                <p><strong>Hotline:</strong> 1900 1234<br><strong>Email:</strong> support@HNQNHstore.com</p>
            </div>
        </div>
    </div>
</div>
<?php
require_once __DIR__ . '/../../layouts/footer.php';
?>