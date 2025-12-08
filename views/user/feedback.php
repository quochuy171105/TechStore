<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$userId = $_SESSION['user_id'] ?? 0;
if (!$userId) {
    header('Location: login.php');
    exit;
}
require_once dirname(__DIR__, 2) . '/models/Database.php';


$order_id = isset($_GET['order_id']) ? (int)$_GET['order_id'] : 0;
$product_id = isset($_GET['product_id']) ? (int)$_GET['product_id'] : 0;
if (!$order_id || !$product_id) {
    die('Tham số không hợp lệ!');
}

$db = Database::getInstance();
$stmt = $db->prepare("
    SELECT od.*, p.name, p.image, o.status
    FROM order_details od
    JOIN products p ON od.product_id = p.id
    JOIN orders o ON od.order_id = o.id
    WHERE od.order_id = ? AND od.product_id = ? AND o.user_id = ?
");
$stmt->execute([$order_id, $product_id, $userId]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$product) die('Sản phẩm này không thuộc đơn hàng của bạn hoặc đơn hàng không tồn tại!');
if ($product['status'] !== 'delivered' && $product['status'] !== 'shipped') die('Bạn chỉ có thể đánh giá sản phẩm sau khi đơn hàng đã được giao thành công!');
include __DIR__ . '/../layouts/header.php';
?>


<div class="feedback-outer">
    <div class="feedback-card">
        <h2>Đánh giá sản phẩm</h2>
        <div class="product-info mb-3">
            <img src="<?= BASE_URL ?>assets/image/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <div>
                <div class="name"><?= htmlspecialchars($product['name']) ?></div>
                <div class="qty">Số lượng: <?= (int)$product['quantity'] ?></div>
            </div>
        </div>
        <div id="feedback-alert"></div>
        <form id="feedbackForm" method="POST" autocomplete="off">
            <div class="mb-3">
                <div class="star-label">Đánh giá của bạn:</div>
                <div class="star-rating-wrap">
                    <div id="starRating" class="star-rating w-100">
                        <i class="bi bi-star" data-value="1"></i>
                        <i class="bi bi-star" data-value="2"></i>
                        <i class="bi bi-star" data-value="3"></i>
                        <i class="bi bi-star" data-value="4"></i>
                        <i class="bi bi-star" data-value="5"></i>
                    </div>
                </div>
                <input type="hidden" name="rating" id="ratingInput" value="0" required>
            </div>
            <div class="mb-4">
                <label for="comment" class="form-label">Nhận xét của bạn</label>
                <textarea class="form-control" id="comment" name="comment" rows="4" placeholder="Nhập cảm nhận về sản phẩm..." required></textarea>
            </div>
            <input type="hidden" name="order_id" value="<?= $order_id ?>">
            <input type="hidden" name="product_id" value="<?= $product_id ?>">
            <input type="hidden" name="action" value="submitForm">
            <button type="submit" class="btn btn-gradient w-100 mb-2">Gửi đánh giá</button>
            <a href="order_history.php" class="btn btn-gradient w-100">Quay về lịch sử đơn hàng</a>
        </form>
    </div>
</div>

<script>
    $(function() {
        // Xử lý ngôi sao
        let rating = 0;
        const $stars = $('#starRating .bi');
        $stars.on('mouseenter', function() {
            let val = $(this).data('value');
            $stars.each(function(i) {
                if (i < val) $(this).addClass('hover');
                else $(this).removeClass('hover');
            });
        }).on('mouseleave', function() {
            $stars.removeClass('hover');
        });
        $stars.on('click', function() {
            rating = $(this).data('value');
            $('#ratingInput').val(rating);
            $stars.each(function(i) {
                if (i < rating) $(this).removeClass('bi-star').addClass('bi-star-fill').addClass('active');
                else $(this).removeClass('bi-star-fill active').addClass('bi-star');
            });
            $(this).addClass('animate');
            setTimeout(() => {
                $(this).removeClass('animate');
            }, 340);
        });

        // AJAX submit feedback
        $('#feedbackForm').on('submit', function(e) {
            e.preventDefault();
            $('#feedback-alert').html('');
            let formData = $(this).serialize();
            $('.btn-gradient').prop('disabled', true).text('Đang gửi...');
            $.ajax({
                url: '../../controllers/FeedbackController.php',
                method: 'POST',
                data: formData,
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#feedback-alert').html(
                            `<div class="alert alert-success text-center mb-2" role="alert">
                            <i class="bi bi-patch-check-fill"></i> ${res.message}
                        </div>`
                        );
                        $('#feedbackForm textarea, #feedbackForm input').prop('disabled', true);
                        $('.btn-gradient').hide();
                    } else {
                        $('#feedback-alert').html(
                            `<div class="alert alert-danger text-center mb-2" role="alert">
                            <i class="bi bi-exclamation-triangle-fill"></i> ${res.message}
                        </div>`
                        );
                    }
                },
                error: function(xhr) {
                    $('#feedback-alert').html(
                        `<div class="alert alert-danger text-center mb-2" role="alert">
                        <i class="bi bi-exclamation-triangle-fill"></i> Lỗi máy chủ! Vui lòng thử lại sau.
                    </div>`
                    );
                },
                complete: function() {
                    $('.btn-gradient').prop('disabled', false).text('Gửi đánh giá');
                }
            });
        });
    });
</script>
<?php include __DIR__ . '/../layouts/footer.php'; ?>