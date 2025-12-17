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
        <h1 class="policy-header">Chính Sách Bảo Mật</h1>
        <div class="policy-content">

            <h2 class="policy-section-title"><i class="fas fa-bullseye"></i>1. Mục Đích Thu Thập Thông Tin</h2>
            <p>TechStore thu thập thông tin cá nhân của khách hàng (như tên, email, số điện thoại, địa chỉ) nhằm mục đích:</p>
            <ul>
                <li>Xử lý đơn hàng, giao hàng và thanh toán.</li>
                <li>Cung cấp thông tin về sản phẩm, dịch vụ và các chương trình khuyến mãi.</li>
                <li>Nâng cao chất lượng dịch vụ và hỗ trợ khách hàng tốt hơn.</li>
                <li>Giải quyết các khiếu nại, tranh chấp phát sinh.</li>
            </ul>

            <h2 class="policy-section-title"><i class="fas fa-users"></i>2. Phạm Vi Sử Dụng Thông Tin</h2>
            <p>Thông tin cá nhân của khách hàng chỉ được sử dụng trong nội bộ TechStore. Chúng tôi có thể chia sẻ thông tin cho các đối tác vận chuyển để thực hiện việc giao hàng.</p>

            <h2 class="policy-section-title" style="color: #28a745;"><i class="fas fa-shield-alt"></i>3. Cam Kết Bảo Mật</h2>
            <p>TechStore cam kết bảo mật tuyệt đối thông tin cá nhân của khách hàng bằng các phương pháp kỹ thuật và quản lý tiên tiến nhất. Chúng tôi cam kết:</p>
            <ul>
                <li>Không bán, trao đổi hoặc chia sẻ thông tin cho bất kỳ bên thứ ba nào khác vì mục đích thương mại.</li>
                <li>Chỉ sử dụng thông tin trong phạm vi đã được nêu ở mục 2.</li>
                <li>Áp dụng các biện pháp an ninh để bảo vệ dữ liệu khỏi truy cập trái phép.</li>
            </ul>

            <h2 class="policy-section-title"><i class="fas fa-user-edit"></i>4. Quyền Của Khách Hàng</h2>
            <p>Khách hàng có quyền yêu cầu truy cập, chỉnh sửa hoặc xóa bỏ thông tin cá nhân của mình bằng cách liên hệ với chúng tôi qua các kênh hỗ trợ.</p>

            <div class="contact-info">
                <h2 class="policy-section-title" style="color: #17a2b8;"><i class="fas fa-headset"></i>5. Liên Hệ</h2>
                <p>Mọi thắc mắc về chính sách bảo mật, vui lòng liên hệ:</p>
                <p><strong>Hotline:</strong> 1900 1234<br><strong>Email:</strong> privacy@HNQNHstore.com</p>
            </div>
        </div>
    </div>
</div>
<?php
require_once __DIR__ . '/../../layouts/footer.php';
?>