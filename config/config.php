<?php
// config/config.php
define('ROOT_PATH', __DIR__ . '/'); // Đường dẫn đến thư mục gốc của dự án
define('BASE_URL', 'http://localhost/TechStore/');
define('ASSETS_PATH', BASE_URL . 'assets/');
define('IMAGES_PATH', ASSETS_PATH . 'image/');
define('UPLOADS_PATH', __DIR__ . '/../assets/image/');
define('VIEWS_PATH', __DIR__ . '/../views/');
define('CONTROLLERS_PATH', __DIR__ . '/../controllers/');
define('ITEMS_PER_PAGE', 12);
define('SESSION_COOKIE_LIFETIME', 86400);
?>