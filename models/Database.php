<?php
// models/Database.php
require_once __DIR__ . '/../config/database.php';

// Lớp Database dùng để quản lý kết nối PDO theo mô hình Singleton
class Database {
    // Thuộc tính tĩnh lưu instance duy nhất của Database
    private static $instance = null;

    // Các thuộc tính cấu hình kết nối
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $username = DB_USER;
    private $password = DB_PASS;

    // Thuộc tính lưu kết nối PDO
    private $conn;

    // Hàm khởi tạo private để ngăn tạo instance bên ngoài (Singleton)
    private function __construct() {
        try {
            // Tạo kết nối PDO với thông tin cấu hình
            $this->conn = new PDO(
                "mysql:host=$this->host;dbname=$this->db_name;charset=utf8",
                $this->username,
                $this->password
            );
            // Thiết lập chế độ báo lỗi cho PDO (ném ngoại lệ)
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Ghi log lỗi và dừng chương trình nếu kết nối thất bại
            error_log("Connection Error: " . $e->getMessage());
            die("Không thể kết nối cơ sở dữ liệu.");
        }
    }

    // Phương thức tĩnh lấy instance duy nhất của Database (Singleton)
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        // Trả về đối tượng PDO để sử dụng truy vấn DB
        return self::$instance->conn;
    }

    // Phương thức trả về kết nối PDO (nếu cần dùng instance thay vì static)
    public function getConnection() {
        return $this->conn;
    }
}
// Kết thúc class Database
?>