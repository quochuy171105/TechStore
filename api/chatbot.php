<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
file_put_contents(__DIR__ . '/test_log.log', "Permission test successful at " . date('Y-m-d H:i:s') . "\n");
error_reporting(E_ALL);

// Log execution start
file_put_contents(__DIR__ . '/debug.log', "chatbot.php execution started at " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

// Check if cURL is enabled
if (!function_exists('curl_init')) {
    file_put_contents(__DIR__ . '/debug.log', "FATAL ERROR: cURL extension is not enabled.\n", FILE_APPEND);
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server configuration error: cURL is not enabled.']);
    exit();
}

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

require_once __DIR__ . '/../vendor/autoload.php';
try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
} catch (Throwable $e) {
    file_put_contents(__DIR__ . '/debug.log', "Error loading .env file: " . $e->getMessage() . "\n", FILE_APPEND);
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
            $userInput = $_POST['userInput'] ?? '';
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
                    return $this->handleGeneralQuery($userInput);
            }
            
        } catch(Exception $e) {
            file_put_contents(__DIR__ . '/debug.log', "Handler Error: " . $e->getMessage() . "\nStack Trace: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            return $this->errorResponse('Đã có lỗi xảy ra trong quá trình xử lý: ' . $e->getMessage());
        }
    }

    // ============================================\n    // HANDLER METHODS
    // ============================================

    private function handleGeneralQuery($userInput) {
        if (empty($userInput)) {
            return $this->successResponse(['message' => "Tôi chưa hiểu ý bạn. Bạn có thể nói rõ hơn được không?"]);
        }

        // Check for policy keywords
        $normalizedInput = mb_strtolower($userInput, 'UTF-8');
        $policyKeywords = [
            'bảo hành' => [
                'message' => 'Bạn có thể tìm hiểu chi tiết về chính sách bảo hành sản phẩm của chúng tôi tại đây:',
                'actions' => [['label' => 'Xem Chính sách Bảo hành', 'url' => 'index.php?url=policy/warranty']]
            ],
            'đổi trả' => [
                'message' => 'Bạn có thể tìm hiểu chi tiết về quy trình và điều kiện đổi trả sản phẩm của chúng tôi tại đây:',
                'actions' => [['label' => 'Xem Chính sách Đổi trả', 'url' => 'index.php?url=policy/returns']]
            ],
            'giao hàng' => [
                'message' => 'Thông tin về phí vận chuyển, thời gian và khu vực giao hàng có đầy đủ tại đây:',
                'actions' => [['label' => 'Xem Chính sách Giao hàng', 'url' => 'index.php?url=policy/delivery']]
            ],
            'bảo mật' => [
                'message' => 'Chúng tôi rất coi trọng việc bảo vệ thông tin của bạn. Vui lòng xem chi tiết tại đây:',
                'actions' => [['label' => 'Xem Chính sách Bảo mật', 'url' => 'index.php?url=policy/privacy']]
            ]
        ];

        foreach ($policyKeywords as $keyword => $data) {
            if (strpos($normalizedInput, $keyword) !== false) {
                return $this->successResponse(['message' => $data['message'], 'actions' => $data['actions']]);
            }
        }

        // --- START KNOWLEDGE BASE LOOKUP (ADVANCED) ---
        $knowledgeBase = include(__DIR__ . '/knowledge_base.php');

        // Helper function to normalize string for KB search (lowercase, no accents)
        if (!function_exists('normalize_string_for_kb_search')) {
            function normalize_string_for_kb_search($str) {
                $str = mb_strtolower($str, 'UTF-8');
                // Convert Vietnamese characters to basic latin
                $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/u", 'a', $str);
                $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/u", 'e', $str);
                $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/u", 'i', $str);
                $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/u", 'o', $str);
                $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/u", 'u', $str);
                $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/u", 'y', $str);
                $str = preg_replace("/(đ)/u", 'd', $str);
                // Remove punctuation, but keep spaces
                $str = preg_replace('/[^\p{L}\p{N}\s]/u', '', $str);
                return $str;
            }
        }

        $normalized_kb_input = normalize_string_for_kb_search($userInput);

        foreach ($knowledgeBase as $rule) {
            $keywords = $rule['keywords'];
            $match_type = $rule['match_type'];
            $answer = $rule['answer'];
            $match_found = false;

            if ($match_type === 'all') {
                $all_keywords_found = true;
                foreach ($keywords as $keyword) {
                    if (strpos($normalized_kb_input, $keyword) === false) {
                        $all_keywords_found = false;
                        break;
                    }
                }
                if ($all_keywords_found) {
                    $match_found = true;
                }
            } elseif ($match_type === 'any') {
                foreach ($keywords as $keyword) {
                    if (strpos($normalized_kb_input, $keyword) !== false) {
                        $match_found = true;
                        break;
                    }
                }
            }

            if ($match_found) {
                return $this->successResponse(['message' => $answer]);
            }
        }
        // --- END KNOWLEDGE BASE LOOKUP ---

        // --- START CACHING LOGIC ---
        $cacheFile = __DIR__ . '/ai_cache.json';
        $cacheDuration = 86400; // 24 hours
        $cacheKey = md5(mb_strtolower($userInput, 'UTF-8'));

        if (file_exists($cacheFile)) {
            $cache = json_decode(file_get_contents($cacheFile), true);
            if (is_array($cache) && isset($cache[$cacheKey]) && (time() - $cache[$cacheKey]['timestamp']) < $cacheDuration) {
                return $this->successResponse(['message' => $cache[$cacheKey]['response']]);
            }
        }
        // --- END CACHING LOGIC ---

        // --- START AI INTEGRATION ---

        $apiKey = $_ENV['GEMINI_API_KEY'] ?? getenv('GEMINI_API_KEY');
        if (!$apiKey) {
            return $this->errorResponse('API key for Gemini is not configured.');
        }
        
        $url = 'https://generativelanguage.googleapis.com/v1/models/gemini-2.5-flash:generateContent?key=' . $apiKey;

        $data = [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [['text' => $userInput]]
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            file_put_contents(__DIR__ . '/debug.log', "AI API cURL Error: " . $curlError . "\n", FILE_APPEND);
            return $this->successResponse(['message' => "Xin lỗi, tôi đang gặp sự cố kết nối với trí tuệ nhân tạo. Vui lòng thử lại sau."]);
        }

        if ($httpCode !== 200) {
            file_put_contents(__DIR__ . '/debug.log', "AI API HTTP Error: Code " . $httpCode . " | Response: " . $response . "\n", FILE_APPEND);
            if ($httpCode === 429) {
                return $this->successResponse(['message' => "Xin lỗi, hệ thống AI hiện đang nhận được rất nhiều yêu cầu và tạm thời bị quá tải. Bạn vui lòng thử lại sau ít phút nhé."]);
            } 
            return $this->successResponse(['message' => "Xin lỗi, có lỗi xảy ra khi xử lý yêu cầu của bạn với AI. (Code: " . $httpCode . ")"]);
        }

        $result = json_decode($response, true);

        if (isset($result['candidates'][0]['content']['parts'][0]['text'])) {
            $aiResponse = $result['candidates'][0]['content']['parts'][0]['text'];
            
            // --- START CACHING LOGIC ---
            $cacheData = file_exists($cacheFile) ? json_decode(file_get_contents($cacheFile), true) : [];
            if (!is_array($cacheData)) {
                $cacheData = [];
            }
            $cacheData[$cacheKey] = [
                'timestamp' => time(),
                'response' => $aiResponse
            ];
            file_put_contents($cacheFile, json_encode($cacheData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            // --- END CACHING LOGIC ---

        } else {
            file_put_contents(__DIR__ . '/debug.log', "AI API Unexpected Response: " . $response . "\n", FILE_APPEND);
            $aiResponse = "Tôi đã nhận được phản hồi từ AI nhưng không thể diễn giải được. Vui lòng thử lại.";
        }

        // --- END AI INTEGRATION ---

        return $this->successResponse(['message' => $aiResponse]);

    }

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