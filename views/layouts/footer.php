<?php
// views/layouts/footer.php
require_once __DIR__ . '/../../config/config.php';
?>
<footer class="bg-dark text-white py-4">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>Thông tin liên hệ</h5>
                <p>Email: support@yourstore.com</p>
                <p>Điện thoại: 0123 456 789</p>
                <p>Địa chỉ: 123 Đường Láng, Hà Nội</p>
            </div>
            <div class="col-md-4">
                <h5>Liên kết nhanh</h5>
                <ul class="list-unstyled">
                    <li><a href="<?= BASE_URL ?>policy" class="text-white">Chính sách bảo hành</a></li>
                    <li><a href="<?= BASE_URL ?>support" class="text-white">Hỗ trợ khách hàng</a></li>
                    <li><a href="<?= BASE_URL ?>about" class="text-white">Về chúng tôi</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Kết nối với chúng tôi</h5>
                <a href="https://facebook.com/yourstore" class="text-white me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="https://twitter.com/yourstore" class="text-white me-2"><i class="fab fa-twitter"></i></a>
                <a href="https://instagram.com/yourstore" class="text-white"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="text-center mt-3">
            <p>© <?php echo date('Y'); ?> Your Store Name. All rights reserved.</p>
        </div>
    </div>
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "Your Store Name",
        "email": "support@yourstore.com",
        "telephone": "0123 456 789",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Đường Láng",
            "addressLocality": "Hà Nội",
            "addressCountry": "VN"
        }
    }
    </script>
</footer>
<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>window.jQuery || document.write('<script src="<?= BASE_URL ?>assets/js/jquery.min.js"><\/script>');</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
<script>
    document.getElementById('search-form').addEventListener('submit', function(e) {
        const searchInput = document.getElementById('search-input').value.trim();
        if (!searchInput) {
            e.preventDefault();
            alert('Vui lòng nhập từ khóa tìm kiếm!');
        }
    });
</script>