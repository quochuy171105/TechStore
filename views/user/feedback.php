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

<meta charset="UTF-8">
<title>Đánh giá sản phẩm</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>
    body {
        font-family: 'Inter', sans-serif;
        background: #f6faff;
        min-height: 100vh;
    }

    .feedback-outer {
        min-height: 86vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .feedback-card {
        background: #fff;
        border-radius: 2.3rem;
        box-shadow: 0 10px 38px 0 rgba(40, 70, 175, 0.08);
        width: 100%;
        max-width: 490px;
        margin: 48px 0 36px 0;
        padding: 48px 40px 34px 40px;
    }

    @media (max-width: 600px) {
        .feedback-card {
            padding: 18px 3vw 18px 3vw;
            max-width: 100vw;
            margin: 20px 0 18px 0;
        }
    }

    .feedback-card h2 {
        font-weight: 800;
        font-size: 2.1rem;
        margin-bottom: 29px;
        text-align: center;
        letter-spacing: .5px;
        color: rgb(117, 194, 233);
    }

    .product-info {
        display: flex;
        align-items: center;
        gap: 17px;
        margin-bottom: 18px;
    }

    .product-info img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 18px;
        background: #f5f5f7;
        border: 1.5px solid #eef1f6;
        box-shadow: 0 2px 10px #d7ecfd1a;
    }

    .product-info .name {
        font-weight: 700;
        font-size: 1.13rem;
        color: #233;
    }

    .product-info .qty {
        font-size: 1.01rem;
        color: #92a4bc;
    }

    .star-label {
        font-weight: 700;
        margin-bottom: 6px;
        background: linear-gradient(90deg, #41c5f8 10%, #2684ff 70%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .star-rating-wrap {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-bottom: 5px;
    }

    .star-rating {
        font-size: 2.53rem;
        display: flex;
        gap: 12px;
        width: 100%;
        justify-content: center;
    }

    @media (max-width: 430px) {
        .star-rating {
            font-size: 2.16rem;
            gap: 7px;
        }
    }

    .star-rating .bi-star,
    .star-rating .bi-star-fill {
        cursor: pointer;
        color: #E5E7EB;
        transition: color 0.18s, transform 0.18s;
        border-radius: 50%;
    }

    .star-rating .bi-star-fill,
    .star-rating .bi-star.active {
        color: #FFD600 !important;
        text-shadow: 0 2px 8px #ffe0842a;
    }

    .star-rating .bi-star.hover {
        color: #FFCB05 !important;
        transform: scale(1.13);
    }

    .star-rating .bi.animate {
        animation: starPop 0.33s cubic-bezier(.31, 1.56, .63, 1) both;
    }

    @keyframes starPop {
        0% {
            transform: scale(1);
        }

        70% {
            transform: scale(1.38);
        }

        100% {
            transform: scale(1);
        }
    }

    .form-label {
        font-weight: 500;
        color: #25304c;
        margin-bottom: 8px;
    }

    .form-control {
        border-radius: 18px;
        border: 1.7px solid #e4eaf5;
        font-size: 1.11rem;
        padding: 18px 19px;
        background: #fafdff;
        transition: border-color 0.21s, box-shadow 0.19s;
    }

    .form-control:focus {
        border-color: #82d6ff !important;
        box-shadow: 0 0 0 .32rem #b3e8fe4d !important;
        background: #f6fbff;
    }

    textarea.form-control {
        min-height: 122px;
        max-height: 340px;
    }

    .btn-gradient {
        background: linear-gradient(90deg, #41c5f8 0%, #2698fc 100%);
        color: white;
        font-weight: 700;
        border-radius: 16px;
        border: none;
        padding: 13px 0;
        font-size: 1.15rem;
        box-shadow: 0 2px 9px #40d6ef11;
        transition: background 0.18s, box-shadow 0.18s, filter 0.16s;
    }

    .btn-gradient:hover,
    .btn-gradient:focus {
        background: linear-gradient(90deg, #2698fc 0%, #41c5f8 100%);
        filter: brightness(1.09) saturate(1.1);
        box-shadow: 0 3px 14px #45c8ed2a;
    }

    .btn-back {
        background: linear-gradient(90deg, #f3f6fb, #c3d7f0);
        color: #0a2540;
        font-weight: 600;
        border-radius: 16px;
        border: none;
        padding: 13px 0;
        font-size: 1.08rem;
        margin-top: 7px;
        transition: background 0.17s, color 0.11s;
        box-shadow: none;
    }

    .btn-back:hover,
    .btn-back:focus {
        background: linear-gradient(90deg, #e1effc 0%, #e2e6f4 100%);
        color: #209af2;
    }


</style>


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
            <a href="order_history.php" class="btn btn-back w-100">Quay về lịch sử đơn hàng</a>
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