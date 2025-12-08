# TechStore - Website Thương mại điện tử

Đây là dự án website thương mại điện tử được xây dựng bằng PHP thuần, mô phỏng một cửa hàng bán lẻ các sản phẩm công nghệ. Dự án bao gồm các chức năng cho cả người dùng (khách hàng) và quản trị viên.

## Kiến trúc

Dự án được xây dựng theo mô hình **MVC (Model-View-Controller)**:

*   **Models**: Xử lý logic nghiệp vụ và tương tác với cơ sở dữ liệu. Các file model nằm trong thư mục `models/`.
*   **Views**: Hiển thị giao diện người dùng. Các file view nằm trong thư mục `views/`.
*   **Controllers**: Tiếp nhận yêu cầu từ người dùng, gọi đến các Model tương ứng để xử lý và trả kết quả về cho View. Các file controller nằm trong thư mục `controllers/`.

## Công nghệ sử dụng

*   **Backend**: PHP 8.x
*   **Frontend**: HTML, CSS, JavaScript, Bootstrap 5, jQuery
*   **Cơ sở dữ liệu**: MySQL
*   **Web server**: Apache (khuyến nghị sử dụng XAMPP)
*   **Thư viện khác**:
    *   Chart.js: Để vẽ biểu đồ thống kê doanh thu.
    *   Font Awesome: Để sử dụng các icon.

## Chức năng chính

### Chức năng dành cho người dùng (User)

*   **Đăng ký, đăng nhập, đăng xuất**: Quản lý tài khoản người dùng.
*   **Quản lý thông tin cá nhân**: Cập nhật thông tin, thay đổi mật khẩu, quản lý địa chỉ giao hàng.
*   **Xem sản phẩm**:
    *   Xem danh sách sản phẩm theo danh mục.
    *   Tìm kiếm sản phẩm theo tên.
    *   Lọc sản phẩm theo giá, thương hiệu.
    *   Xem chi tiết sản phẩm.
    *   Xem các sản phẩm đã xem gần đây.
*   **Giỏ hàng**: Thêm, xóa, cập nhật số lượng sản phẩm trong giỏ hàng.
*   **Đặt hàng**:
    *   Tiến hành đặt hàng từ giỏ hàng.
    *   Áp dụng mã khuyến mãi.
    *   Chọn địa chỉ giao hàng.
    *   Chọn phương thức thanh toán (COD, chuyển khoản).
*   **Lịch sử mua hàng**: Xem lại các đơn hàng đã đặt và trạng thái của chúng.
*   **Gửi phản hồi**: Đánh giá và bình luận về sản phẩm đã mua.
*   **Xem các chương trình khuyến mãi**.

### Chức năng dành cho quản trị viên (Admin)

*   **Đăng nhập, đăng xuất an toàn**.
*   **Dashboard**:
    *   Thống kê tổng quan (doanh thu, đơn hàng mới, số lượng khách hàng).
    *   Biểu đồ thống kê doanh thu theo ngày/tháng/năm.
*   **Quản lý sản phẩm**: Thêm, sửa, xóa sản phẩm.
*   **Quản lý đơn hàng**:
    *   Xem danh sách đơn hàng.
    *   Cập nhật trạng thái đơn hàng (đang xử lý, đang giao, đã giao, đã hủy).
*   **Quản lý khuyến mãi**: Thêm, sửa, xóa các mã khuyến mãi.
*   **Quản lý người dùng**: Xem danh sách người dùng.
*   **Quản lý danh mục, thương hiệu**.

## Cấu trúc cơ sở dữ liệu

Cơ sở dữ liệu `techstore` bao gồm các bảng sau:

| Tên bảng             | Mô tả                                                                      |
| --------------------- | -------------------------------------------------------------------------- |
| `users`               | Lưu trữ thông tin tài khoản của người dùng và quản trị viên.               |
| `addresses`           | Lưu trữ các địa chỉ giao hàng của người dùng.                              |
| `categories`          | Lưu trữ các danh mục sản phẩm (VD: Điện thoại, Laptop).                    |
| `brands`              | Lưu trữ các thương hiệu sản phẩm (VD: Apple, Samsung).                     |
| `products`            | Lưu trữ thông tin chi tiết của sản phẩm.                                   |
| `product_attributes`  | Lưu trữ các thuộc tính mở rộng của sản phẩm (VD: Màu sắc, RAM, CPU).       |
| `cart`                | Lưu trữ thông tin giỏ hàng của người dùng.                                 |
| `promotions`          | Lưu trữ thông tin về các chương trình khuyến mãi, mã giảm giá.              |
| `orders`              | Lưu trữ thông tin các đơn hàng của khách hàng.                             |
| `order_details`       | Lưu trữ chi tiết các sản phẩm trong mỗi đơn hàng.                          |
| `feedback`            | Lưu trữ các đánh giá, bình luận của người dùng về sản phẩm.                |
| `recently_viewed`     | Lưu trữ lịch sử các sản phẩm mà người dùng đã xem gần đây.                  |
| `revenue`             | Lưu trữ dữ liệu doanh thu từ các đơn hàng đã hoàn thành (được cập nhật tự động qua trigger). |

### Chi tiết các bảng

1.  **`users`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `email`: UNIQUE, VARCHAR(255)
    *   `password`: VARCHAR(255) (được mã hóa)
    *   `name`: VARCHAR(100)
    *   `phone`: VARCHAR(20)
    *   `role`: ENUM('customer', 'admin')
    *   `created_at`, `updated_at`: TIMESTAMP

2.  **`addresses`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `user_id`: Khóa ngoại tham chiếu đến `users(id)`
    *   `address_line`, `city`, `country`: VARCHAR
    *   `postal_code`: VARCHAR(20)
    *   `is_default`: TINYINT (1: là địa chỉ mặc định)

3.  **`categories`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `name`: UNIQUE, VARCHAR(100)
    *   `description`: TEXT

4.  **`brands`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `name`: UNIQUE, VARCHAR(100)
    *   `logo`: VARCHAR(255) (đường dẫn đến file ảnh)

5.  **`products`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `category_id`: Khóa ngoại tham chiếu đến `categories(id)`
    *   `brand_id`: Khóa ngoại tham chiếu đến `brands(id)`
    *   `name`: VARCHAR(255)
    *   `description`: TEXT
    *   `price`: FLOAT
    *   `stock`: INT (số lượng tồn kho)
    *   `image`: VARCHAR(255)
    *   `created_at`, `updated_at`: TIMESTAMP

6.  **`product_attributes`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `product_id`: Khóa ngoại tham chiếu đến `products(id)`
    *   `attribute_name`: VARCHAR(100)
    *   `attribute_value`: VARCHAR(255)

7.  **`cart`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `user_id`: Khóa ngoại tham chiếu đến `users(id)`
    *   `product_id`: Khóa ngoại tham chiếu đến `products(id)`
    *   `quantity`: INT
    *   `added_at`: TIMESTAMP

8.  **`promotions`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `code`: UNIQUE, VARCHAR(50)
    *   `discount_type`: ENUM('percentage', 'fixed')
    *   `discount_value`: FLOAT
    *   `start_date`, `end_date`: DATE
    *   `min_order_amount`: FLOAT
    *   `created_at`: TIMESTAMP

9.  **`orders`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `user_id`: Khóa ngoại tham chiếu đến `users(id)`
    *   `address_id`: Khóa ngoại tham chiếu đến `addresses(id)`
    *   `total_amount`: FLOAT
    *   `promotion_id`: Khóa ngoại tham chiếu đến `promotions(id)`
    *   `payment_method`: ENUM('cod', 'bank_transfer', 'e_wallet')
    *   `status`: ENUM('pending', 'processing', 'shipped', 'delivered', 'cancelled')
    *   `created_at`, `updated_at`: TIMESTAMP

10. **`order_details`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `order_id`: Khóa ngoại tham chiếu đến `orders(id)`
    *   `product_id`: Khóa ngoại tham chiếu đến `products(id)`
    *   `quantity`: INT
    *   `price`: FLOAT (giá sản phẩm tại thời điểm đặt hàng)

11. **`feedback`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `user_id`: Khóa ngoại tham chiếu đến `users(id)`
    *   `product_id`: Khóa ngoại tham chiếu đến `products(id)`
    *   `rating`: INT (từ 1 đến 5)
    *   `comment`: TEXT
    *   `created_at`: TIMESTAMP

12. **`recently_viewed`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `user_id`: Khóa ngoại tham chiếu đến `users(id)`
    *   `product_id`: Khóa ngoại tham chiếu đến `products(id)`
    *   `viewed_at`: TIMESTAMP

13. **`revenue`**
    *   `id`: Khóa chính, INT, AUTO_INCREMENT
    *   `order_id`: Khóa ngoại tham chiếu đến `orders(id)`
    *   `total_amount`: FLOAT
    *   `revenue_date`: DATE
    *   `created_at`: TIMESTAMP

## Hướng dẫn cài đặt

1.  **Clone project**:
    ```bash
    git clone <your-repository-url> TechStore
    ```
2.  **Di chuyển vào thư mục `htdocs`**:
    *   Di chuyển thư mục `TechStore` vừa clone vào thư mục `htdocs` của XAMPP.

3.  **Cơ sở dữ liệu**:
    *   Mở phpMyAdmin.
    *   Tạo một cơ sở dữ liệu mới có tên là `techstore`.
    *   Chọn cơ sở dữ liệu `techstore` vừa tạo, vào tab "Import".
    *   Chọn file `sql/database.sql` trong thư mục dự án và thực hiện import.

4.  **Cấu hình kết nối**:
    *   Mở file `config/database.php`.
    *   Chỉnh sửa các thông tin `DB_HOST`, `DB_USER`, `DB_PASS`, `DB_NAME` cho phù hợp với cấu hình MySQL của bạn.
    ```php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root'); // Thay đổi nếu bạn có user khác
    define('DB_PASS', ''); // Thay đổi nếu bạn có đặt mật khẩu
    define('DB_NAME', 'techstore');
    ```

5.  **Chạy dự án**:
    *   Khởi động Apache và MySQL trong XAMPP Control Panel.
    *   Mở trình duyệt và truy cập vào địa chỉ: `http://localhost/TechStore`
    *   Trang quản trị: `http://localhost/TechStore/admin.php`
    *   Tài khoản admin mặc định:
        *   Email: `admin@example.com`
        *   Password: `adminpassword`
    *   Tài khoản khách hàng mẫu:
        *   Email: `customer1@example.com`
        *   Password: `customerpassword`

## Cấu trúc thư mục

```
/
├── .htaccess
├── README.md
├── admin.php           # Entry point cho trang quản trị
├── api/                # Chứa các file API (ví dụ: chatbot)
├── assets/             # Chứa các tài nguyên tĩnh (CSS, JS, images)
│   ├── css/
│   ├── js/
│   └── image/
├── config/
│   ├── config.php      # Cấu hình chung của website
│   └── database.php    # Cấu hình kết nối cơ sở dữ liệu
├── controllers/        # Chứa các file Controller
├── index.php           # Entry point chính cho trang người dùng
├── models/             # Chứa các file Model
├── services/           # Chứa các file xử lý AJAX
├── sql/
│   └── database.sql    # File dump cơ sở dữ liệu
└── views/              # Chứa các file View
    ├── admin/          # Giao diện trang quản trị
    ├── layouts/        # Chứa header, footer, các layout chung
    └── user/           # Giao diện trang người dùng
```