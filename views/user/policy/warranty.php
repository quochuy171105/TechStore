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
        <h1 class="policy-header">Chính Sách Bảo Hành Sản Phẩm</h1>
        <div class="policy-content">

            <h2 class="policy-section-title"><i class="fas fa-shield-alt"></i>1. Phạm Vi và Thời Gian Bảo Hành</h2>
            <p>TechStore cam kết tất cả sản phẩm bán ra đều là hàng chính hãng và được hưởng chế độ bảo hành theo quy định của nhà sản xuất. Thời gian bảo hành tiêu chuẩn là <strong>12 tháng</strong>, một số sản phẩm đặc biệt có thể có thời gian bảo hành dài hơn, được ghi rõ trong phần mô tả chi tiết.</p>

            <h2 class="policy-section-title"><i class="fas fa-check-circle"></i>2. Điều Kiện Bảo Hành Hợp Lệ</h2>
            <ul>
                <li>Sản phẩm còn trong thời hạn bảo hành được tính từ ngày mua hàng.</li>
                <li>Sản phẩm gặp lỗi kỹ thuật từ phía nhà sản xuất, không phải do tác động từ người dùng.</li>
                <li>Phiếu bảo hành, tem niêm phong và số serial trên sản phẩm phải còn nguyên vẹn, không có dấu hiệu tẩy xóa hay sửa đổi.</li>
                <li>Sản phẩm không thuộc các trường hợp từ chối bảo hành.</li>
            </ul>

            <h2 class="policy-section-title" style="color: #dc3545;"><i class="fas fa-times-circle"></i>3. Các Trường Hợp Từ Chối Bảo Hành</h2>
            <ul>
                <li>Sản phẩm bị hư hỏng do tai nạn, thiên tai, hoặc do người dùng sử dụng sai cách (rơi vỡ, vào nước, biến dạng).</li>
                <li>Sản phẩm có dấu hiệu đã bị tháo gỡ, sửa chữa hoặc can thiệp bởi cá nhân hoặc đơn vị không được TechStore ủy quyền.</li>
                <li>Hết thời hạn bảo hành hoặc tem bảo hành, số serial bị rách, mờ, hoặc không thể xác định.</li>
                <li>Lỗi phần mềm hoặc các hư hỏng do virus, quá trình cài đặt phần mềm không tương thích.</li>
            </ul>

            <h2 class="policy-section-title"><i class="fas fa-cogs"></i>4. Quy Trình Bảo Hành</h2>
            <p><strong>Bước 1:</strong> Quý khách vui lòng liên hệ với bộ phận hỗ trợ khách hàng của TechStore qua hotline hoặc email để thông báo về tình trạng sản phẩm.</p>
            <p><strong>Bước 2:</strong> Mang sản phẩm kèm phiếu bảo hành đến trung tâm bảo hành của TechStore hoặc gửi sản phẩm qua đường bưu điện (chi phí vận chuyển do khách hàng chi trả).</p>
            <p><strong>Bước 3:</strong> Kỹ thuật viên sẽ kiểm tra và xác định tình trạng lỗi. Thời gian xử lý dự kiến từ 7-15 ngày làm việc.</p>
            <p><strong>Bước 4:</strong> TechStore sẽ thông báo kết quả và phương án xử lý (sửa chữa, đổi mới) cho quý khách.</p>

            <div class="contact-info">
                <h2 class="policy-section-title" style="color: #28a745;"><i class="fas fa-headset"></i>5. Liên Hệ Hỗ Trợ</h2>
                <p>Nếu có bất kỳ thắc mắc nào về chính sách bảo hành, quý khách vui lòng liên hệ với chúng tôi:</p>
                <p><strong>Hotline:</strong> 1900 1234<br><strong>Email:</strong> support@HNQNHstore.com</p>
            </div>
        </div>
    </div>
</div>
<?php
require_once __DIR__ . '/../../layouts/footer.php';
?>