<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once dirname(__DIR__) . '/models/Feedback.php';

class FeedbackController {
    // Lấy lịch sử feedback cho tab account
    public function indexByUser($userId) {
        global $feedbacks;
        $model = new Feedback();
        $feedbacks = $model->getByUser($userId);
    }

    // Xử lý gửi feedback (AJAX, form hoặc modal)
    public function submitForm() {
        header('Content-Type: application/json');
        $userId = $_SESSION['user_id'] ?? ($_SESSION['user']['id'] ?? 0);
        $productId = intval($_POST['product_id'] ?? 0);
        $comment = trim($_POST['comment'] ?? '');
        $rating = intval($_POST['rating'] ?? 0);

        // Không ràng buộc order_id, chỉ kiểm tra các trường cần thiết
        if ($userId < 1 || $productId < 1 || $rating < 1 || $rating > 5 || strlen($comment) < 3) {
            echo json_encode(['success'=>false, 'message'=>'Thiếu hoặc sai dữ liệu!']);
            exit;
        }
        $feedbackModel = new Feedback();
        // Nếu cho phép feedback nhiều lần thì bỏ check này:
        if ($feedbackModel->isExist($userId, $productId)) {
             echo json_encode(['success'=>false, 'message'=>'Bạn đã đánh giá sản phẩm này!']);
             exit;
        }
        $success = $feedbackModel->createFeedback($userId, $productId, $comment, $rating);
        if ($success) {
            echo json_encode(['success'=>true, 'message'=>'Đánh giá thành công!']);
        } else {
            echo json_encode(['success'=>false, 'message'=>'Có lỗi xảy ra: '.$feedbackModel->getLastError()]);
        }
        exit;
    }
}

// Gọi xử lý khi nhận AJAX POST từ form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'submitForm') {
    (new FeedbackController())->submitForm();
}
?>
