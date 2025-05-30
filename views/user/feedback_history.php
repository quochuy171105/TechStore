<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

?>

<div class="container my-4">
    <h2 class="mb-4">Lịch sử đánh giá sản phẩm</h2>
    <?php if (!empty($feedbacks)): ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>Sản phẩm</th>
          <th>Bình luận</th>
          <th>Điểm</th>
          <th>Ngày</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($feedbacks as $fb): ?>
          <tr>
            <td><?= htmlspecialchars($fb['product_name']) ?></td>
            <td><?= htmlspecialchars($fb['comment']) ?></td>
            <td><?= str_repeat('⭐', $fb['rating']) ?></td>
            <td><?= date('d/m/Y', strtotime($fb['created_at'])) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="alert alert-info">Bạn chưa gửi đánh giá nào.</div>
    <?php endif; ?>
</div>

