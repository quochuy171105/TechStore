<?php
class UserController {
    private $user;

    public function __construct() {
        require_once dirname(__DIR__) . '/models/User.php';
        $this->user = new User();
    }

    // Đăng ký tài khoản
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $errors = [];
            $name = trim($_POST['name'] ?? '');
            $contact = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            if (empty($name) || mb_strlen($name) < 2) {
                $errors['name'] = 'Tên phải có ít nhất 2 ký tự.';
            }
            if (empty($contact)) {
                $errors['email'] = 'Vui lòng nhập email hoặc số điện thoại.';
            } elseif (!filter_var($contact, FILTER_VALIDATE_EMAIL) && !preg_match('/^[0-9]{10}$/', $contact)) {
                $errors['email'] = 'Nhập đúng email hoặc số điện thoại gồm 10 số.';
            } elseif ($this->user->contactExists($contact)) {
                $errors['email'] = 'Email hoặc số điện thoại đã được sử dụng.';
            }
            if (empty($password) || strlen($password) < 6) {
                $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
            }
            if ($password !== $confirm_password) {
                $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
            }
            if (empty($errors)) {
                if ($this->user->create($name, $contact, $password)) {
                    $_SESSION['message'] = 'Đăng ký thành công!';
                } else {
                    $errors['general'] = 'Đăng ký thất bại. Vui lòng thử lại.';
                }
            }
            if (!empty($errors)) $_SESSION['errors'] = $errors;
        }
    }

    // Đăng nhập
public function login() {
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $identifier = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        if (empty($identifier)) $errors['email'] = 'Vui lòng nhập email hoặc số điện thoại.';
        if (empty($password)) $errors['password'] = 'Vui lòng nhập mật khẩu.';
        if (empty($errors)) {
            $user = $this->user->authenticate($identifier, $password);
            if ($user) {
                // GÁN SESSION Ở ĐÂY
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                return [
                    'success' => true,
                    'user' => [
                        'id' => $user['id'],
                        'name' => $user['name'],
                        'email' => $user['email']
                    ]
                ];
            } else {
                $errors['general'] = 'Tài khoản hoặc mật khẩu không đúng.';
            }
        }
    }
    return ['success' => false, 'errors' => $errors];
}
    // // Quên mật khẩu (giả lập)
    // public function forgotPassword() {
    //     if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         $errors = [];
    //         $email = trim($_POST['email'] ?? '');
    //         if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    //             $errors['email'] = 'Email không hợp lệ.';
    //         }
    //         if (empty($errors)) {
    //             $resetResult = $this->user->generateResetToken($email);
    //             if ($resetResult) {
    //                 $_SESSION['message'] = "Link đặt lại mật khẩu đã gửi! (Demo: <a href='reset_password.php?token={$resetResult['token']}'>Nhấn vào đây để đặt lại</a>)";
    //             } else {
    //                 $errors['general'] = 'Email không tồn tại.';
    //             }
    //         }
    //         if (!empty($errors)) $_SESSION['errors'] = $errors;
    //     }
    // }
public function logout() {
    if (session_status() === PHP_SESSION_NONE) session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit;
}

    // Cập nhật thông tin tài khoản (AJAX) và xử lý địa chỉ (add, edit, set_default, delete, list)
    public function account() {
        $userId = $_SESSION['user_id'] ?? null;
        if (!$userId) {
            header("Location: login.php");
            exit();
        }

        // XỬ LÝ AJAX ĐỊA CHỈ
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['address_action'])) {
            $action = $_POST['action'] ?? '';
            header('Content-Type: application/json; charset=utf-8');

            if ($action == 'add') {
                $address = trim($_POST['address_line'] ?? '');
                $city = trim($_POST['city'] ?? '');
                $postal = trim($_POST['postal_code'] ?? '');
                $country = trim($_POST['country'] ?? '');
                if ($address && $city && $country) {
                    $result = $this->user->addAddress($userId, $address, $city, $postal, $country);
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Điền đầy đủ thông tin']);
                }
                exit;
            }

            if ($action == 'edit') {
                $addressId = intval($_POST['address_id'] ?? 0);
                $address = trim($_POST['address_line'] ?? '');
                $city = trim($_POST['city'] ?? '');
                $postal = trim($_POST['postal_code'] ?? '');
                $country = trim($_POST['country'] ?? '');
                $isDefault = !empty($_POST['is_default']) ? 1 : 0;

                if ($address && $city && $country) {
                    $result = $this->user->editAddress($userId, $addressId, $address, $city, $postal, $country, $isDefault);
                    echo json_encode(['success' => $result]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Điền đầy đủ thông tin']);
                }
                exit;
            }

            if ($action == 'set_default') {
                $addressId = intval($_POST['address_id'] ?? 0);
                $this->user->setDefaultAddress($userId, $addressId);
                echo json_encode(['success' => true]);
                exit;
            }

            if ($action == 'delete') {
                $addressId = intval($_POST['address_id'] ?? 0);
                $result = $this->user->deleteAddress($userId, $addressId);
                if ($result) echo json_encode(['success' => true]);
                else echo json_encode(['success' => false, 'message' => 'Không thể xóa địa chỉ mặc định!']);
                exit;
            }

            if ($action == 'list') {
                $addresses = $this->user->getAddresses($userId);
                ob_start();
                foreach ($addresses as $ad) {
                    $default = $ad['is_default'];
                    echo '<div class="card mb-3 shadow-sm address-item" data-id="'.$ad['id'].'" style="border-radius:16px; border:'.($default?'2px solid #0288d1;':'1px solid #e0e0e0;').'">';
                    echo    '<div class="card-body d-flex justify-content-between align-items-center flex-wrap">';
                    echo        '<div class="flex-grow-1">';
                    echo            '<div style="font-size:17px;font-weight:600">'.htmlspecialchars($ad['address_line']).'</div>';
                    echo            '<div class="text-muted" style="font-size:15px">'.htmlspecialchars($ad['city']).', '.htmlspecialchars($ad['country']);
                    if ($ad['postal_code']) echo ', '.htmlspecialchars($ad['postal_code']);
                    echo            '</div>';
                    if ($default) echo '<span class="badge bg-info mt-1" style="font-size:13px;">Mặc định</span>';
                    echo        '</div>';
                    echo        '<div class="btn-group mt-2 mt-md-0 ms-md-3">';
                    echo            '<button type="button" class="btn btn-outline-secondary btn-sm edit-address" data-id="'.$ad['id'].'"';
                    echo                ' data-address="'.htmlspecialchars($ad['address_line']).'"';
                    echo                ' data-city="'.htmlspecialchars($ad['city']).'"';
                    echo                ' data-country="'.htmlspecialchars($ad['country']).'"';
                    echo                ' data-postal="'.htmlspecialchars($ad['postal_code']).'"';
                    echo                ' data-default="'.$default.'">';
                    echo                '<i class="bi bi-pencil"></i> Sửa';
                    echo            '</button>';
                    if (!$default) {
                        echo '<button type="button" class="btn btn-outline-primary btn-sm set-default ms-1" data-id="'.$ad['id'].'"><i class="bi bi-star"></i></button>';
                        echo '<button type="button" class="btn btn-outline-danger btn-sm ms-1 delete-address" data-id="'.$ad['id'].'"><i class="bi bi-trash"></i></button>';
                    } else {
                        echo '<button type="button" class="btn btn-outline-secondary btn-sm ms-1" disabled><i class="bi bi-trash"></i></button>';
                    }
                    echo        '</div>';
                    echo    '</div>';
                    // Khung sửa inline (ẩn mặc định)
                    echo    '<div class="edit-form-container" style="display:none; background:#f8fafd; border-radius:12px; padding:18px 20px 10px 20px; margin:0 12px 10px 12px;">';
                    echo      '<form class="edit-address-form" method="post" data-id="'.$ad['id'].'">';
                    echo        '<div class="row g-2 align-items-center">';
                    echo          '<div class="col-12 col-md-5">';
                    echo            '<input type="text" class="form-control" name="address_line" value="'.htmlspecialchars($ad['address_line']).'" required placeholder="Địa chỉ">';
                    echo          '</div>';
                    echo          '<div class="col-6 col-md-3">';
                    echo            '<input type="text" class="form-control" name="city" value="'.htmlspecialchars($ad['city']).'" required placeholder="Thành phố">';
                    echo          '</div>';
                    echo          '<div class="col-6 col-md-2">';
                    echo            '<input type="text" class="form-control" name="postal_code" value="'.htmlspecialchars($ad['postal_code']).'" placeholder="Mã bưu điện">';
                    echo          '</div>';
                    echo          '<div class="col-6 col-md-2">';
                    echo            '<input type="text" class="form-control" name="country" value="'.htmlspecialchars($ad['country']).'" required placeholder="Quốc gia">';
                    echo          '</div>';
                    echo          '<div class="col-6 col-md-2">';
                    echo            '<div class="form-check mt-1">';
                    echo              '<input class="form-check-input" type="checkbox" name="is_default" '.($default?'checked':'').'>';
                    echo              '<label class="form-check-label" style="font-size:13px">Mặc định</label>';
                    echo            '</div>';
                    echo          '</div>';
                    echo          '<div class="col-12 col-md-2 text-end">';
                    echo            '<button type="submit" class="btn btn-sm btn-gradient">Lưu</button> ';
                    echo            '<button type="button" class="btn btn-sm btn-light cancel-edit">Hủy</button>';
                    echo          '</div>';
                    echo        '</div>';
                    echo      '</form>';
                    echo    '</div>';
                    echo '</div>';
                }
                $html = ob_get_clean();
                echo json_encode(['success' => true, 'html' => $html]);
                exit;
            }
            exit;
        }

        // XỬ LÝ UPDATE THÔNG TIN TÀI KHOẢN
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_info'])) {
            $errors = [];
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            if ($name === '' || mb_strlen($name) < 2) {
                $errors['name'] = 'Tên phải có ít nhất 2 ký tự.';
            }
            if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ.';
            } elseif ($this->user->contactExistsForOther($email, $userId)) {
                $errors['email'] = 'Email đã được sử dụng.';
            }
            if ($phone === '' || !preg_match('/^[0-9]{10}$/', $phone)) {
                $errors['phone'] = 'Số điện thoại không hợp lệ.';
            } elseif ($this->user->contactExistsForOther($phone, $userId)) {
                $errors['phone'] = 'Số điện thoại đã được sử dụng.';
            }
            if (!empty($password)) {
                if (strlen($password) < 6) {
                    $errors['password'] = 'Mật khẩu phải có ít nhất 6 ký tự.';
                }
                if ($password !== $confirm_password) {
                    $errors['confirm_password'] = 'Mật khẩu xác nhận không khớp.';
                }
            }
            if (empty($errors)) {
                $success = $this->user->updateUser($userId, $name, $email, $phone, $password);
                if ($success) {
                    $_SESSION['user_name'] = $name;
                    $user = $this->user->getUser($userId);
                    echo json_encode(['success' => true, 'message' => 'Cập nhật thành công!', 'user' => $user]);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Cập nhật thất bại. Vui lòng thử lại.']);
                }
            } else {
                echo json_encode(['success' => false, 'errors' => $errors]);
            }
            exit();
        }

        global $userData;
        $userData = $this->user->getUser($userId);
    }
}
?>
