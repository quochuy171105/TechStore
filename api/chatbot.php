<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
file_put_contents(__DIR__ . '/test_log.log', "Permission test successful at " . date('Y-m-d H:i:s') . "\n");
error_reporting(E_ALL);

// Log execution start
file_put_contents(__DIR__ . '/debug.log', "chatbot.php execution started at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// ============================================\n// SMART CHATBOT API - BACKEND HANDLER V2.1 (Patched)
// File: api/chatbot.php
// ============================================

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../config/database.php';

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    file_put_contents(__DIR__ . '/debug.log', 'Database connection failed: ' . $e->getMessage() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
    exit();
}

class ChatbotAPI {
    private $pdo;
    private $entities;
    private $context;
    private $history;
    
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function handleRequest() {
        try {
            $action = $_POST['action'] ?? '';
            $this->entities = json_decode($_POST['entities'] ?? '{}', true);
            $this->context = json_decode($_POST['context'] ?? '{}', true);
            $this->history = json_decode($_POST['history'] ?? '[]', true);
            
            $this->logRequest($action, $this->entities, $this->context);
            
            switch($action) {
                case 'product_inquiry':
                case 'budget_filter':
                    return $this->handleProductInquiry();
                case 'product_specs':
                case 'product_availability':
                    return $this->handleProductDetails();
                case 'promotion_inquiry':
                    return $this->handlePromotionInquiry();
                case 'order_status':
                    return $this->handleOrderStatus();
                case 'order_cancellation':
                    return $this->handleOrderCancellation();
                case 'account_support':
                    return $this->handleAccountSupport();
                case 'comparison':
                    return $this->handleComparison();
                default:
                    return $this->successResponse(['message' => "Tôi chưa được huấn luyện để xử lý yêu cầu này."]);
            }
            
        } catch(Exception $e) {
            file_put_contents(__DIR__ . '/debug.log', "Handler Error: " . $e->getMessage() . "\nStack Trace: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            return $this->errorResponse('Đã có lỗi xảy ra trong quá trình xử lý: ' . $e->getMessage());
        }
    }

    // ============================================\n    // HANDLER METHODS
    // ============================================

    private function handleProductInquiry() {
        $priceRange = $this->entities['priceRange'] ?? null;
        $brands = $this->entities['brands'] ?? [];
        $features = $this->entities['features'] ?? [];
        $productType = $this->entities['product_type'][0] ?? $this->context['lastProductType'] ?? null;
        
        $sql = "SELECT p.id as MaSP, p.name as TenSP, p.price as Gia, p.image as HinhAnh, p.stock as SoLuong, c.name as LoaiSP, b.name as ThuongHieu
                FROM products p
                LEFT JOIN categories c ON p.category_id = c.id
                LEFT JOIN brands b ON p.brand_id = b.id
                WHERE p.stock > 0";
        
        $params = [];
        
        if ($priceRange && isset($priceRange['min']) && isset($priceRange['max'])) {
            $sql .= " AND p.price BETWEEN :price_min AND :price_max";
            $params[':price_min'] = $priceRange['min'];
            $params[':price_max'] = $priceRange['max'];
        }
        
        if (!empty($brands)) {
            $brandConditions = [];
            foreach ($brands as $i => $brand) {
                $key = ":brand_$i";
                $brandConditions[] = "b.name LIKE $key";
                $brandConditions[] = "p.name LIKE $key";
                $params[$key] = "%$brand%";
            }
            $sql .= " AND (" . implode(' OR ', $brandConditions) . ")";
        }
        
        if ($productType) {
            $sql .= " AND (c.name LIKE :product_type OR p.name LIKE :product_type)";
            $params[':product_type'] = "%$productType%";
        }

        $sql .= " ORDER BY p.created_at DESC LIMIT 10";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $products = $stmt->fetchAll();
        
        foreach($products as &$product) {
            $product['Gia'] = (float)$product['Gia'];
            $product['HinhAnh'] = $this->getImageUrl($product['HinhAnh']);
        }
        
        return $this->successResponse(['products' => $products]);
    }

    private function handleProductDetails() {
        $productId = $this->entities['product_id'] ?? $this->context['focusedProduct']['id'] ?? null;

        if (!$productId) {
            return $this->successResponse(['message' => 'Để kiểm tra, bạn vui lòng cho tôi biết bạn đang quan tâm đến sản phẩm cụ thể nào nhé.']);
        }

        $sql = "SELECT p.name, p.stock, p.description, p.price, GROUP_CONCAT(DISTINCT pa.value ORDER BY pa.value SEPARATOR ', ') AS attributes
                FROM products p
                LEFT JOIN product_attributes pa ON p.id = pa.product_id
                WHERE p.id = :product_id
                GROUP BY p.id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':product_id' => $productId]);
        $product = $stmt->fetch();

        if (!$product) {
            return $this->errorResponse("Không tìm thấy thông tin cho sản phẩm này.");
        }

        $action = $_POST['action'] ?? '';
        $message = "";

        if ($action === 'product_availability') {
            if ($product['stock'] > 0) {
                $message = "Sản phẩm **" . $product['name'] . "** hiện còn **" . $product['stock'] . "** sản phẩm. Bạn có thể đặt hàng ngay!";
            } else {
                $message = "Rất tiếc, sản phẩm **" . $product['name'] . "** đã tạm hết hàng.";
            }
        } elseif ($action === 'product_specs') {
            $message = "Thông tin chi tiết về **" . $product['name'] . "**:\n";
            $message .= "- **Giá:** " . number_format($product['price']) . " VNĐ\n";
            if (!empty($product['attributes'])) {
                $message .= "- **Các phiên bản (màu sắc/dung lượng):** " . $product['attributes'] . "\n";
            }
            $message .= "- **Mô tả:** " . strip_tags($product['description']);
        }

        return $this->successResponse(['message' => $message]);
    }

    private function handlePromotionInquiry() {
        $sql = "SELECT code, discount_type, discount_value, start_date, end_date, min_order_amount, 
                       CONCAT('Giảm ', discount_value, IF(discount_type = 'percentage', '%', 'K'), ' cho đơn hàng từ ', min_order_amount, 'K') as description
                FROM promotions
                WHERE CURDATE() BETWEEN start_date AND end_date AND is_active = 1";
        
        $stmt = $this->pdo->query($sql);
        $promotions = $stmt->fetchAll();
        
        return $this->successResponse(['promotions' => $promotions]);
    }
    
    private function handleOrderStatus() {
        $orderCode = $this->entities['orderCode'] ?? null;
        $phone = $this->entities['phone'] ?? null;

        if(!$orderCode && !$phone) {
            return $this->successResponse(['message' => 'Để tra cứu, bạn vui lòng cung cấp mã đơn hàng hoặc số điện thoại đặt hàng nhé.']);
        }
        
        $sql = "SELECT o.id, o.status, o.total_amount, o.created_at, u.fullname 
                FROM orders o
                LEFT JOIN users u ON o.user_id = u.id
                WHERE";
        
        $params = [];
        if ($orderCode) {
            $sql .= " o.id = :order_code";
            $params[':order_code'] = $orderCode;
        } else {
            $sql .= " u.phone = :phone ORDER BY o.created_at DESC LIMIT 1";
            $params[':phone'] = $phone;
        }
                
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        $order = $stmt->fetch();
        
        if(!$order) {
            return $this->successResponse(['message' => "Không tìm thấy đơn hàng nào phù hợp với thông tin bạn cung cấp."]);
        }
        
        return $this->successResponse(['order' => $order]);
    }

    private function handleOrderCancellation() {
        $orderCode = $this->entities['orderCode'] ?? null;
        $phone = $this->entities['phone'] ?? null;

        if(!$orderCode && !$phone) {
            return $this->successResponse(['message' => 'Để hủy đơn, bạn vui lòng cung cấp mã đơn hàng hoặc số điện thoại đã dùng để đặt hàng.']);
        }

        $findSql = "SELECT o.id, o.status FROM orders o LEFT JOIN users u ON o.user_id = u.id WHERE";
        $params = [];
        if ($orderCode) {
            $findSql .= " o.id = :order_code";
            $params[':order_code'] = $orderCode;
        } else {
            $findSql .= " u.phone = :phone ORDER BY o.created_at DESC LIMIT 1";
            $params[':phone'] = $phone;
        }

        $stmt = $this->pdo->prepare($findSql);
        $stmt->execute($params);
        $order = $stmt->fetch();

        if (!$order) {
            return $this->successResponse(['message' => "Tôi không tìm thấy đơn hàng nào khớp với thông tin bạn cung cấp."]);
        }

        if ($order['status'] === 'pending' || $order['status'] === 'processing') {
            $updateSql = "UPDATE orders SET status = 'cancelled' WHERE id = :order_id";
            $updateStmt = $this->pdo->prepare($updateSql);
            $updateStmt->execute(['order_id' => $order['id']]);
            return $this->successResponse(['message' => "Đã gửi yêu cầu hủy cho đơn hàng #" . $order['id'] . ". Bạn sẽ nhận được thông báo xác nhận sớm."]);
        } else {
            return $this->successResponse(['message' => "Rất tiếc, đơn hàng #" . $order['id'] . " đang ở trạng thái ‘" . $order['status'] . "’ nên không thể tự động hủy. Vui lòng liên hệ hotline để được hỗ trợ trực tiếp."]);
        }
    }

    private function handleAccountSupport() {
        $email = $this->entities['email'] ?? null;

        if (!$email) {
            return $this->successResponse(['message' => 'Để kiểm tra, bạn vui lòng cung cấp email đã đăng ký tài khoản.']);
        }

        $sql = "SELECT id, fullname, email FROM users WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            return $this->successResponse(['message' => "Tôi đã tìm thấy tài khoản của bạn (" . $user['fullname'] . "). Nếu bạn quên mật khẩu, hãy sử dụng chức năng 'Quên mật khẩu' trên trang đăng nhập nhé."]);
        } else {
            return $this->successResponse(['message' => "Email bạn cung cấp chưa được đăng ký tài khoản nào trên hệ thống."]);
        }
    }
    
    private function handleComparison() {
        $product_ids = $this->entities['product_ids'] ?? [];
        if(count($product_ids) < 2) {
            return $this->errorResponse('Cần ít nhất 2 sản phẩm để so sánh.');
        }
        $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
        $sql = "SELECT p.id, p.name, p.price, p.image as image_url, p.description, b.name as brand_name 
                FROM products p 
                LEFT JOIN brands b ON p.brand_id = b.id 
                WHERE p.id IN ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($product_ids);
        $products = $stmt->fetchAll();
        return $this->successResponse(['products' => $products]);
    }
    
    // ============================================\n    // HELPER FUNCTIONS
    // ============================================
    
    private function getImageUrl($imagePath) {
        if (empty($imagePath)) {
            return '';
        }
        return basename(str_replace('\\', '/', $imagePath));
    }
    
    private function logRequest($action, $entities, $context) {
        $logData = [
            'timestamp' => date('Y-m-d H:i:s'),
            'action' => $action,
            'entities' => $entities,
            'context' => $context,
            'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown'
        ];
        file_put_contents(__DIR__ . '/debug.log', json_encode($logData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n", FILE_APPEND);
    }
    
    private function successResponse($data) {
        return ['success' => true, 'data' => $data];
    }
    
    private function errorResponse($message) {
        return ['success' => false, 'message' => $message];
    }
}

// ============================================\n// MAIN EXECUTION
// ============================================

try {
    $chatbot = new ChatbotAPI($pdo);
    $response = $chatbot->handleRequest();
    
    $jsonResponse = json_encode($response, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    
    if ($jsonResponse === false) {
        throw new Exception('JSON encoding failed: ' . json_last_error_msg());
    }
    
    echo $jsonResponse;
    
} catch(Exception $e) {
    file_put_contents(__DIR__ . '/debug.log', "Main execution error: " . $e->getMessage() . "\nStack Trace: " . $e->getTraceAsString() . "\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Internal Server Error. Please check debug.log for details.'
    ], JSON_UNESCAPED_UNICODE);
}
?>