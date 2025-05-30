<?php
// views/user/product_detail.php
require_once __DIR__ . '/../../controllers/ProductController.php';
require_once __DIR__ . '/../../models/Database.php';
require_once __DIR__ . '/../../config/config.php';
require_once __DIR__ . '/../../models/Feedback.php';

$db = Database::getInstance();
$productController = new ProductController($db);
$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $productController->getProductById($product_id);
$attributes = $productController->getProductAttributes($product_id);
// Feedback sẽ được lấy từ FeedbackController (Thành viên 3)
$feedbackModel = new Feedback();
$feedbacks = $feedbackModel->getByProduct($product_id);
// Tính trung bình số sao và tổng số đánh giá
$totalRating = 0;
$totalFeedback = count($feedbacks);
if ($totalFeedback > 0) {
    foreach ($feedbacks as $fb) {
        $totalRating += (int)$fb['rating'];
    }
    $avgRating = round($totalRating / $totalFeedback, 1);
} else {
    $avgRating = 0;
}
?>

<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="product-detail-container">
    <meta name="description" content="<?= htmlspecialchars($product['name']) ?> - Mua sản phẩm chất lượng tại cửa hàng điện tử">
    <meta name="keywords" content="<?= htmlspecialchars($product['name']) ?>, công nghệ, sản phẩm">
    <title><?= htmlspecialchars($product['name']) ?> - Cửa hàng điện tử</title>

    <!-- Breadcrumb -->
    <div class="container">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="home.php"><i class="fas fa-home"></i> Trang chủ</a></li>
                <li class="breadcrumb-item"><a href="product_list.php">Sản phẩm</a></li>
                <li class="breadcrumb-item active"><?= htmlspecialchars($product['name']) ?></li>
            </ol>
        </nav>
    </div>

    <!-- Main Product Section -->
    <div class="container product-main-section">
        <div class="row">
            <!-- Product Images -->
            <div class="col-lg-6 col-md-6">
                <div class="product-image-section">
                    <div id="productCarousel" class="carousel slide product-carousel">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="product-image-wrapper">
                                    <img src="<?= IMAGES_PATH . htmlspecialchars($product['image']) ?>"
                                        class="product-main-image"
                                        alt="<?= htmlspecialchars($product['name']) ?>"
                                        loading="lazy">
                                    <div class="image-zoom-overlay">
                                        <i class="fas fa-search-plus"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon"></span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon"></span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Product Info -->
            <div class="col-lg-6 col-md-6">
                <div class="product-info-section">
                    <div class="product-header">
                        <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
                        <div class="product-rating">
                            <div class="stars">
                                <?php
                                $fullStars = floor($avgRating);
                                $halfStar = ($avgRating - $fullStars) >= 0.5;
                                for ($i = 1; $i <= 5; $i++):
                                    if ($i <= $fullStars): ?>
                                        <i class="fas fa-star"></i>
                                    <?php elseif ($halfStar && $i == $fullStars + 1): ?>
                                        <i class="fas fa-star-half-alt"></i>
                                    <?php else: ?>
                                        <i class="far fa-star"></i>
                                <?php endif;
                                endfor;
                                ?>
                            </div>
                            <span class="rating-text">
                                (<?= $avgRating ?>)
                                <?= $totalFeedback ?> đánh giá
                            </span>
                        </div>
                    </div>

                    <div class="product-price-section">
                        <div class="current-price"><?= number_format($product['price'], 0, ',', '.') ?>₫</div>
                        <div class="original-price"><?= number_format($product['price'] * 1.2, 0, ',', '.') ?>₫</div>
                        <div class="discount-badge">-17%</div>
                    </div>

                    

                    <div class="product-features">
                        <h5><i class="fas fa-cogs"></i> Thông số kỹ thuật</h5>
                        <div class="features-grid">
                            <?php foreach ($attributes as $attr): ?>
                                <div class="feature-item">
                                    <span class="feature-label"><?= htmlspecialchars($attr['attribute_name']) ?>:</span>
                                    <span class="feature-value"><?= htmlspecialchars($attr['attribute_value']) ?></span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="product-actions">
                        <div class="quantity-selector">
                            <label>Số lượng:</label>
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn minus"><i class="fas fa-minus"></i></button>
                                <input type="number" id="quantity" value="1" min="1" max="99">
                                <button type="button" class="qty-btn plus"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>

                        <div class="action-buttons">
                            <button class="btn btn-add-cart" onclick="addToCart(<?= $product['id'] ?>)">
                                <i class="fas fa-shopping-cart"></i>
                                Thêm vào giỏ hàng
                            </button>
                            <button class="btn btn-buy-now">
                                <i class="fas fa-bolt"></i>
                                Mua ngay
                            </button>
                            <button class="btn btn-wishlist">
                                <i class="far fa-heart"></i>
                            </button>
                        </div>
                    </div>

                    <div class="product-guarantees">
                        <div class="guarantee-item">
                            <i class="fas fa-truck"></i>
                            <span>Miễn phí vận chuyển</span>
                        </div>
                        <div class="guarantee-item">
                            <i class="fas fa-undo"></i>
                            <span>Đổi trả trong 7 ngày</span>
                        </div>
                        <div class="guarantee-item">
                            <i class="fas fa-shield-alt"></i>
                            <span>Bảo hành chính hãng</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Details Tabs -->
    <div class="container product-details-section">
        <div class="product-tabs">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button">
                        <i class="fas fa-info-circle"></i> Mô tả sản phẩm
                    </button>
                    <button class="nav-link" id="nav-specs-tab" data-bs-toggle="tab" data-bs-target="#nav-specs" type="button">
                        <i class="fas fa-list"></i> Thông số kỹ thuật
                    </button>
                    <button class="nav-link" id="nav-reviews-tab" data-bs-toggle="tab" data-bs-target="#nav-reviews" type="button">
                        <i class="fas fa-star star-gold"></i> Đánh giá<span class="rating-text">
                            (<?= $avgRating ?>)
                        </span>
                    </button>
                </div>
            </nav>
            <div class="tab-content" id="nav-tabContent">
                <div class="tab-pane fade show active" id="nav-description" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <h4>Mô tả chi tiết sản phẩm</h4>
                        <p><?= htmlspecialchars($product['description']) ?></p>
                        <div class="description-features">
                            <h5>Tính năng nổi bật:</h5>
                            <ul class="feature-list">
                                <li><i class="fas fa-check"></i> Thiết kế hiện đại, sang trọng</li>
                                <li><i class="fas fa-check"></i> Công nghệ tiên tiến</li>
                                <li><i class="fas fa-check"></i> Hiệu suất cao, ổn định</li>
                                <li><i class="fas fa-check"></i> Tiết kiệm năng lượng</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-specs" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <h4>Thông số kỹ thuật chi tiết</h4>
                        <div class="specs-table">
                            <?php foreach ($attributes as $attr): ?>
                                <div class="spec-row">
                                    <div class="spec-label"><?= htmlspecialchars($attr['attribute_name']) ?></div>
                                    <div class="spec-value"><?= htmlspecialchars($attr['attribute_value']) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="nav-reviews" role="tabpanel">
                    <div class="tab-content-wrapper">
                        <div class="row">
                            <div class="col-lg-5 col-md-8 col-12">
                                <h3 class="mb-3">Đánh giá sản phẩm</h3>
                                <?php if (empty($feedbacks)): ?>
                                    <div class="no-reviews">
                                        <i class="fas fa-comment-slash"></i>
                                        <p>Chưa có đánh giá nào.</p>
                                    </div>
                                <?php else: ?>
                                    <?php foreach ($feedbacks as $feedback): ?>
                                        <div class="card mb-2 shadow-sm">
                                            <div class="card-body text-start">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <strong class="feedback-user-name"><?= htmlspecialchars($feedback['user_name']) ?></strong>
                                                    <span class="star-rating">
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <?php if ($i <= $feedback['rating']): ?>
                                                                <i class="fas fa-star"></i>
                                                            <?php else: ?>
                                                                <i class="far fa-star"></i>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </span>
                                                </div>
                                                <div class="feedback-comment"><?= nl2br(htmlspecialchars($feedback['comment'])) ?></div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function addToCart(productId) {
        const quantity = document.getElementById('quantity').value;

        $.ajax({
            url: '../../services/add_to_cart.php',
            type: 'POST',
            data: {
                product_id: productId,
                quantity: quantity
            },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    // Show success animation
                    showNotification('Đã thêm vào giỏ hàng!', 'success');
                } else {
                    showNotification('Lỗi: ' + response.message, 'error');
                }
            },
            error: function() {
                showNotification('Lỗi kết nối đến server', 'error');
            }
        });
    }

    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
        <span>${message}</span>
    `;
        document.body.appendChild(notification);

        setTimeout(() => {
            notification.classList.add('show');
        }, 100);

        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => document.body.removeChild(notification), 300);
        }, 3000);
    }

    // Quantity controls
    document.addEventListener('DOMContentLoaded', function() {
        const minusBtn = document.querySelector('.qty-btn.minus');
        const plusBtn = document.querySelector('.qty-btn.plus');
        const quantityInput = document.getElementById('quantity');

        minusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
            }
        });

        plusBtn.addEventListener('click', function() {
            let currentValue = parseInt(quantityInput.value);
            if (currentValue < 99) {
                quantityInput.value = currentValue + 1;
            }
        });
    });
</script>

<?php include __DIR__ . '/../layouts/footer.php'; ?>