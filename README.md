# TechStore - Website bán đồ công nghệ

TechStore là một trang web thương mại điện tử được xây dựng bằng PHP thuần, chuyên bán các sản phẩm công nghệ.

## Chức năng chính

### Người dùng
- Xem danh sách sản phẩm
- Tìm kiếm và lọc sản phẩm
- Xem chi tiết sản phẩm
- Đăng ký, đăng nhập tài khoản
- Quản lý giỏ hàng
- Đặt hàng và thanh toán
- Xem lịch sử đơn hàng
- Đánh giá sản phẩm

### Quản trị viên
- Đăng nhập vào trang quản trị
- Quản lý sản phẩm (thêm, sửa, xóa)
- Quản lý đơn hàng
- Quản lý chương trình khuyến mãi
- Thống kê doanh thu

## Cài đặt

1.  **Clone project về máy của bạn**
2.  **Database:**
    -   Tạo một database mới có tên là `techstore`.
    -   Import file `database.sql` trong thư mục `sql` vào database vừa tạo.
3.  **Cấu hình:**
    -   Mở file `config/config.php` và chỉnh sửa các đường dẫn cho phù hợp với môi trường của bạn.
    -   Mở file `config/database.php` và chỉnh sửa thông tin kết nối database.
4.  **Chạy dự án:**
    -   Khởi động XAMPP hoặc một web server tương tự.
    -   Truy cập vào đường dẫn `http://localhost/TechStore/` để xem trang web.
    -   Truy cập vào đường dẫn `http://localhost/TechStore/admin.php` để vào trang quản trị.

## Cấu trúc thư mục

-   `/assets`: Chứa các file css, js, hình ảnh.
-   `/config`: Chứa các file cấu hình.
-   `/controllers`: Chứa các file xử lý logic.
-   `/models`: Chứa các file tương tác với database.
-   `/services`: Chứa các file xử lý các tác vụ ngầm (AJAX).
-   `/sql`: Chứa file sql để tạo database.
-   `/views`: Chứa các file giao diện.
-   `index.php`: File chạy chính cho người dùng.
-   `admin.php`: File chạy chính cho quản trị viên.