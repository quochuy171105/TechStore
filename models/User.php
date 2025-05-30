<?php
require_once dirname(__DIR__) . '/models/Database.php';

class User {
    private $conn;
    private $table_name = "users";

    public function __construct() {
        $this->conn = Database::getInstance(); // PDO instance
    }

    // Kiểm tra email hoặc SĐT đã tồn tại cho user khác
    public function contactExistsForOther($contact, $userId) {
        $query = "SELECT id FROM {$this->table_name} WHERE (email = :contact OR phone = :contact) AND id <> :userId";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':contact' => $contact, ':userId' => $userId]);
        return $stmt->fetch() !== false;
    }

    // Kiểm tra email hoặc SĐT đã tồn tại
    public function contactExists($contact) {
        $query = "SELECT id FROM {$this->table_name} WHERE email = :contact OR phone = :contact";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':contact' => $contact]);
        return $stmt->fetch() !== false;
    }

    // Đăng ký tài khoản
    public function create($name, $contact, $password) {
        $isEmail = filter_var($contact, FILTER_VALIDATE_EMAIL);
        $field = $isEmail ? "email" : "phone";
        $query = "INSERT INTO {$this->table_name} (name, $field, password, created_at) VALUES (:name, :contact, :password, NOW())";
        $stmt = $this->conn->prepare($query);
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $stmt->execute([
            ':name' => $name,
            ':contact' => $contact,
            ':password' => $passwordHash
        ]);
    }

    // Lấy thông tin user theo ID
    public function getUser($userId) {
        $query = "SELECT id, name, email, phone FROM {$this->table_name} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: false;
    }

    // Xác thực đăng nhập
    public function authenticate($identifier, $password) {
        $query = "SELECT id, name, email, phone, password FROM {$this->table_name} WHERE email = :identifier OR phone = :identifier";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([':identifier' => $identifier]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    // Cập nhật thông tin user
    public function updateUser($userId, $name, $email, $phone, $password) {
        $params = [
            ':name' => $name,
            ':email' => $email,
            ':phone' => $phone,
            ':id' => $userId
        ];
        $sql = "UPDATE {$this->table_name} SET name = :name, email = :email, phone = :phone";
        if (!empty($password)) {
            $sql .= ", password = :password";
            $params[':password'] = password_hash($password, PASSWORD_BCRYPT);
        }
        $sql .= " WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute($params);
    }

    // Lấy danh sách địa chỉ của user
    public function getAddresses($userId) {
        $stmt = $this->conn->prepare("SELECT * FROM addresses WHERE user_id = :userId ORDER BY is_default DESC, id ASC");
        $stmt->execute([':userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Thêm địa chỉ mới
    public function addAddress($userId, $address, $city, $postal, $country) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) as cnt FROM addresses WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
        $count = $stmt->fetch(PDO::FETCH_ASSOC)['cnt'] ?? 0;

        $isDefault = ($count == 0) ? 1 : 0;
        if ($isDefault) $this->unsetDefault($userId);

        $stmt = $this->conn->prepare("INSERT INTO addresses (user_id, address_line, city, postal_code, country, is_default) VALUES (:userId, :address, :city, :postal, :country, :isDefault)");
        return $stmt->execute([
            ':userId' => $userId,
            ':address' => $address,
            ':city' => $city,
            ':postal' => $postal,
            ':country' => $country,
            ':isDefault' => $isDefault
        ]);
    }

    // Bỏ chọn mặc định tất cả địa chỉ
    public function unsetDefault($userId) {
        $stmt = $this->conn->prepare("UPDATE addresses SET is_default = 0 WHERE user_id = :userId");
        $stmt->execute([':userId' => $userId]);
    }

    // Đặt 1 địa chỉ làm mặc định
    public function setDefaultAddress($userId, $addressId) {
        $this->unsetDefault($userId);
        $stmt = $this->conn->prepare("UPDATE addresses SET is_default = 1 WHERE user_id = :userId AND id = :addressId");
        $stmt->execute([':userId' => $userId, ':addressId' => $addressId]);
    }

    // Sửa địa chỉ
    public function editAddress($userId, $addressId, $address, $city, $postal, $country, $isDefault) {
        if ($isDefault) $this->unsetDefault($userId);
        $stmt = $this->conn->prepare("UPDATE addresses SET address_line = :address, city = :city, postal_code = :postal, country = :country, is_default = :isDefault WHERE id = :addressId AND user_id = :userId");
        return $stmt->execute([
            ':address' => $address,
            ':city' => $city,
            ':postal' => $postal,
            ':country' => $country,
            ':isDefault' => $isDefault,
            ':addressId' => $addressId,
            ':userId' => $userId
        ]);
    }

    // Xóa địa chỉ (chỉ xóa nếu không phải mặc định)
    public function deleteAddress($userId, $addressId) {
        $stmt = $this->conn->prepare("SELECT is_default FROM addresses WHERE id = :addressId AND user_id = :userId");
        $stmt->execute([':addressId' => $addressId, ':userId' => $userId]);
        $is_default = $stmt->fetch(PDO::FETCH_ASSOC)['is_default'] ?? 0;
        if ($is_default) return false;
        $stmt = $this->conn->prepare("DELETE FROM addresses WHERE id = :addressId AND user_id = :userId");
        return $stmt->execute([':addressId' => $addressId, ':userId' => $userId]);
    }
}
?>
