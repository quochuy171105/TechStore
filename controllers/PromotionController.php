 <?php
class PromotionController {
    private $promotion;

    public function __construct() {
        require_once dirname(__DIR__) . '/models/Promotion.php';
        $this->promotion = new Promotion();
    }

public function index() {
    global $promotions;

    $limit = 10;
    $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

    $promotions = $this->promotion->getPromotions($currentPage, $limit);
    if (!$promotions) {
        $promotions = [];
    }

    // Sắp xếp theo trạng thái hiệu lực
    usort($promotions, function ($a, $b) {
        $today = strtotime(date('Y-m-d'));
        $aStart = strtotime($a['start_date']);
        $aEnd   = strtotime($a['end_date']);
        $bStart = strtotime($b['start_date']);
        $bEnd   = strtotime($b['end_date']);

        $getStatus = function($start, $end, $now) {
            if ($now < $start) return 1; // Chưa bắt đầu
            if ($now > $end)   return 2; // Hết hạn
            return 0;                     // Có thể dùng
        };

        $statusA = $getStatus($aStart, $aEnd, $today);
        $statusB = $getStatus($bStart, $bEnd, $today);

        // So sánh theo trạng thái
        if ($statusA !== $statusB) {
            return $statusA - $statusB;
        }

        // Nếu trạng thái giống nhau, sắp theo ngày bắt đầu tăng dần
        return $aStart - $bStart;
    });
}


    public function getAllPromotions() {
        return $this->promotion->getAllPromotions();
    }

} 
