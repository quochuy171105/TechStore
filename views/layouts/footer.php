<?php
// views/layouts/footer.php
require_once __DIR__ . '/../../config/config.php';
// Giả sử các biến BASE_URL và APP_NAME đã được định nghĩa trong config.php
// Ví dụ: const BASE_URL = 'http://localhost/yourstore/';
defined('APP_NAME') or define('APP_NAME', 'HNQNH Store');
?>

<footer class="bg-dark text-white pt-5 pb-4 border-top border-secondary">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-3 col-md-6">
                <a class="d-flex align-items-center text-decoration-none mb-3" href="<?= BASE_URL ?>">
                    <span class="fs-4 fw-bold text-white"><?= APP_NAME ?></span>
                </a>
                <p class="text-secondary small">Cửa hàng bán lẻ thiết bị công nghệ hàng đầu, cam kết mang đến sản phẩm chính hãng và dịch vụ tốt nhất.</p>
                <div class="social-icons mt-3">
                    <a href="https://facebook.com/yourstore" target="_blank" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fab fa-facebook-f fa-lg"></i></a>
                    <a href="https://twitter.com/yourstore" target="_blank" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fab fa-twitter fa-lg"></i></a>
                    <a href="https://instagram.com/yourstore" target="_blank" class="text-white me-3 opacity-75 hover-opacity-100"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="https://youtube.com/yourstore" target="_blank" class="text-white opacity-75 hover-opacity-100"><i class="fab fa-youtube fa-lg"></i></a>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 text-uppercase border-start border-primary border-3 ps-2">Thông tin</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= BASE_URL ?>about" class="text-secondary text-decoration-none hover-white">Về chúng tôi</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>contact" class="text-secondary text-decoration-none hover-white">Liên hệ</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>careers" class="text-secondary text-decoration-none hover-white">Tuyển dụng</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>store-locator" class="text-secondary text-decoration-none hover-white">Hệ thống cửa hàng</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 text-uppercase border-start border-primary border-3 ps-2">Chính sách</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="<?= BASE_URL ?>policy/warranty" class="text-secondary text-decoration-none hover-white">Chính sách bảo hành</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>policy/returns" class="text-secondary text-decoration-none hover-white">Chính sách đổi trả</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>policy/privacy" class="text-secondary text-decoration-none hover-white">Chính sách bảo mật</a></li>
                    <li class="mb-2"><a href="<?= BASE_URL ?>policy/delivery" class="text-secondary text-decoration-none hover-white">Chính sách giao hàng</a></li>
                </ul>
            </div>

            <div class="col-lg-3 col-md-6">
                <h5 class="mb-3 text-uppercase border-start border-primary border-3 ps-2">Liên hệ</h5>
                <p class="text-secondary mb-1"><i class="fas fa-map-marker-alt me-2 text-primary"></i>Chung cư SG Intela, KDC 13E, Đường số 5, huyện Bình Chánh, TP. Sài Gòn</p>
                <p class="text-secondary mb-1"><i class="fas fa-phone-alt me-2 text-primary"></i>Hotline: 1900 1234 (7h30 - 22h00)</p>
                <p class="text-secondary mb-1"><i class="fas fa-envelope me-2 text-primary"></i>Email: support@HNQNHstore.com</p>
                <p class="text-secondary mb-1"><i class="fas fa-clock me-2 text-primary"></i>Mở cửa: Thứ 2 - Chủ Nhật</p>
            </div>
        </div>

        <hr class="my-4 border-secondary opacity-25">

        <div class="row">
            <div class="col-12 text-center text-md-start">
                <p class="text-secondary mb-0 small">&copy; <?php echo date('Y'); ?> <?= APP_NAME ?>. Bản quyền đã được đăng ký.</p>
            </div>
        </div>
    </div>
    
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "Organization",
        "name": "<?= APP_NAME ?>",
        "url": "<?= BASE_URL ?>",
        "logo": "<?= BASE_URL ?>assets/images/logo.png",
        "contactPoint": {
            "@type": "ContactPoint",
            "telephone": "+84916076557",
            "contactType": "customer service",
            "email": "support@HNQNHstore.com",
            "areaServed": "VN"
        },
        "sameAs": [
            "https://facebook.com/HMQNH",
            "https://twitter.com/HMQNH",
            "https://instagram.com/HMQNH"
        ],
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Chung cư SG Intela, KDC 13E, Đường số 5, xã Bình Chánh",
            "addressLocality": "Sài Gòn",
            "addressCountry": "Vietnam"
        }
    }
    </script>
</footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= BASE_URL ?>assets/js/main.js"></script>
    <!-- Chatbox Feature -->
    <link rel="stylesheet" href="<?= BASE_URL ?>assets/css/chat.css">
    <div id="chat-bubble" class="chat-bubble">
        <i class="fas fa-comments"></i>
    </div>
    <div id="chat-window" class="chat-window">
        <div class="chat-header">
            <h5 class="m-0">HNQNH Assistant</h5>
            <button id="close-chat" class="btn-close"></button>
        </div>
        <div class="chat-body">
            <div class="message received">
                <p>Xin chào! Tôi là trợ lý ảo của HNQNH. Tôi có thể giúp gì cho bạn?</p>
            </div>
        </div>
        <div class="chat-footer">
            <input type="text" id="chat-input" placeholder="Nhập tin nhắn...">
            <button id="send-chat" class="btn btn-primary"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
    <div id="chat-url-container" style="display: none;">
        <div id="view-new-products" data-url="<?= BASE_URL ?>views/user/product_list.php"></div>
        <div id="view-phones" data-url="<?= BASE_URL ?>views/user/product_list.php?category_id=1"></div>
        <div id="view-laptops" data-url="<?= BASE_URL ?>views/user/product_list.php?category_id=2"></div>
        <div id="view-all-products" data-url="<?= BASE_URL ?>views/user/product_list.php"></div>
        <div id="view-promotions" data-url="<?= BASE_URL ?>views/user/promotions.php"></div>
    </div>

    <script src="<?= BASE_URL ?>assets/js/chat.js"></script>
    <!-- End Chatbox Feature -->