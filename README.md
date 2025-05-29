DoAnCuoiKiLapTrinhWeb/
├── assets/                     # Tài nguyên tĩnh
│   ├── css/                   # CSS tùy chỉnh
│   │   ├── style.css          # CSS cho giao diện người dùng
│   │   ├── admin.css          # CSS cho giao diện admin
│   │   ├── login.css          # CSS cho trang đăng nhập
│   │   ├── register.css       # CSS cho trang đăng ký
│   │   ├── forgot_password.css # CSS cho trang khôi phục mật khẩu
│   │   ├── categories.css     # CSS cho menu danh mục
│   │   ├── revenue.css        # CSS cho trang thống kê doanh thu
│   ├── js/                    # JavaScript
│   │   ├── main.js            # Tìm kiếm, lọc, giỏ hàng
│   │   ├── admin.js           # Thao tác admin
│   │   ├── bootstrap.min.js   # Bootstrap JS
│   │   ├── mainTV3.js         # Quản lý địa chỉ AJAX
│   │   ├── cart.js            # Xử lý giỏ hàng
│   │   ├── chart.min.js       # Chart.js cho biểu đồ
│   ├── image/                 # Hình ảnh
│   │   ├── products/          # Hình ảnh sản phẩm
│   │   ├── banners/           # Hình ảnh banner
│   │   ├── maqr2.png          # Mã QR
│   │   ├── logo1.png          # Logo website
│   ├── fonts/                 # Font chữ
│   ├── lib/                   # Thư viện bên thứ ba
│   │   ├── bootstrap/         # Bootstrap
│   │   ├── font-awesome/      # Font Awesome
├── config/                    # Cấu hình
│   ├── database.php           # Kết nối cơ sở dữ liệu
│   ├── config.php             # Hằng số, cấu hình chung
├── controllers/               # Bộ điều khiển
│   ├── UserController.php     # Quản lý tài khoản người dùng
│   ├── ProductController.php  # Xử lý sản phẩm
│   ├── CartController.php     # Xử lý giỏ hàng
│   ├── OrderController.php    # Xử lý đơn hàng
│   ├── FeedbackController.php # Xử lý đánh giá
│   ├── PromotionController.php # Xử lý khuyến mãi
│   ├── AdminController.php    # Quản lý admin
│   ├── AdminProductController.php # Quản lý sản phẩm admin
│   ├── AdminOrderController.php   # Quản lý đơn hàng admin
│   ├── AdminPromotionController.php # Quản lý khuyến mãi admin
│   ├── AdminRevenueController.php  # Thống kê doanh thu admin
├── models/                    # Mô hình
│   ├── User.php               # Quản lý người dùng
│   ├── Product.php            # Quản lý sản phẩm
│   ├── Category.php           # Quản lý danh mục
│   ├── Cart.php               # Quản lý giỏ hàng
│   ├── Order.php              # Quản lý đơn hàng
│   ├── OrderDetail.php        # Quản lý chi tiết đơn hàng
│   ├── Feedback.php           # Quản lý đánh giá
│   ├── Promotion.php          # Quản lý khuyến mãi
│   ├── Revenue.php            # Thống kê doanh thu
│   ├── Password_Admin_User.php # Xử lý mật khẩu
│   ├── Database.php           # Kết nối PDO
├── views/                     # Giao diện
│   ├── user/                  # Giao diện người dùng
│   │   ├── home.php           # Trang chủ
│   │   ├── login.php          # Đăng nhập
│   │   ├── logout.php         # Đăng xuất
│   │   ├── register.php       # Đăng ký
│   │   ├── forgot_password.php # Khôi phục mật khẩu
│   │   ├── account.php        # Quản lý tài khoản
│   │   ├── product_list.php   # Danh sách sản phẩm
│   │   ├── product_detail.php # Chi tiết sản phẩm
│   │   ├── search.php         # Kết quả tìm kiếm
│   │   ├── cart.php           # Giỏ hàng
│   │   ├── checkout.php       # Thanh toán
│   │   ├── feedback_history.php # Lịch sử đánh giá
│   │   ├── feedback.php  # Form đánh giá
│   │   ├── promotions.php     # Khuyến mãi
│   │   ├── order_history.php  # Lịch sử đơn hàng
│   ├── admin/                 # Giao diện admin
│   │   ├── login.php          # Đăng nhập admin
│   │   ├── dashboard.php      # Tổng quan
│   │   ├── product_manage.php # Quản lý sản phẩm
│   │   ├── product_create.php # Tạo sản phẩm
│   │   ├── order_manage.php   # Quản lý đơn hàng
│   │   ├── order_update.php   # Cập nhật đơn hàng
│   │   ├── promotion_manage.php # Quản lý khuyến mãi
│   │   ├── promotion_create.php # Tạo khuyến mãi
│   │   ├── register.php       # Đăng ký admin
│   │   ├── forgot_password.php # Khôi phục mật khẩu admin
│   │   ├── revenue.php        # Thống kê doanh thu
│   ├── layouts/               # Template chung
│   │   ├── header.php         # Header người dùng
│   │   ├── footer.php         # Footer người dùng
│   │   ├── 404.php            # Trang lỗi
│   │   ├── admin_header.php   # Header admin
│   │   ├── admin_footer.php   # Footer admin
├── services/                  # AJAX/Webservice
│   ├── search_product.php     # Tìm kiếm sản phẩm
│   ├── filter_product.php     # Lọc sản phẩm
│   ├── update_cart.php        # Cập nhật giỏ hàng
│   ├── add_to_cart.php        # Thêm vào giỏ hàng
│   ├── get_product.php        # Lấy chi tiết sản phẩm
│   ├── get_revenue.php        # Lấy dữ liệu doanh thu
├── sql/                       # File SQL
│   ├── database.sql           # Script tạo bảng
├── .htaccess                  # URL thân thiện
├── index.php                  # Điểm vào người dùng
├── admin.php                  # Điểm vào admin
├── README.md                  # Hướng dẫn dự án

Giải thích chi tiết
1. assets/
css/: Chứa các file CSS tùy chỉnh cho giao diện người dùng (style.css), admin (admin.css), và các trang cụ thể (đăng nhập, danh mục, doanh thu).
js/: Chứa JavaScript xử lý tìm kiếm, giỏ hàng (main.js), admin (admin.js), và thư viện (bootstrap.min.js, chart.min.js).
image/: Lưu trữ hình ảnh sản phẩm, banner, logo, mã QR.
fonts/: Font chữ tùy chỉnh.
lib/: Thư viện Bootstrap, Font Awesome.
2. config/
database.php: Cấu hình kết nối MySQL (host, user, password).
config.php: Định nghĩa hằng số (BASE_URL, IMAGES_PATH).
3. controllers/
Người dùng:
UserController.php: Quản lý đăng nhập, đăng ký, thông tin tài khoản.
ProductController.php: Hiển thị, tìm kiếm, lọc sản phẩm.
CartController.php: Quản lý giỏ hàng.
OrderController.php: Xử lý đặt hàng, lịch sử đơn hàng.
FeedbackController.php: Quản lý đánh giá sản phẩm.
PromotionController.php: Quản lý mã khuyến mãi.
Admin:
AdminController.php: Đăng nhập, dashboard admin.
AdminProductController.php: Quản lý sản phẩm.
AdminOrderController.php: Quản lý đơn hàng.
AdminPromotionController.php: Quản lý khuyến mãi.
AdminRevenueController.php: Thống kê doanh thu.
4. models/
Người dùng:
User.php: Quản lý thông tin người dùng.
Product.php: Quản lý sản phẩm.
Category.php: Quản lý danh mục.
Cart.php: Quản lý giỏ hàng.
Order.php, OrderDetail.php: Quản lý đơn hàng và chi tiết.
Feedback.php: Quản lý đánh giá.
Promotion.php: Quản lý khuyến mãi.
Admin:
Revenue.php: Thống kê doanh thu.
Password_Admin_User.php: Xử lý mật khẩu.
Database.php: Kết nối PDO.
5. views/
user/:
home.php: Trang chủ với banner, sản phẩm nổi bật.
login.php, register.php, forgot_password.php: Giao diện đăng nhập/đăng ký/khôi phục mật khẩu.
account.php: Quản lý thông tin cá nhân, đơn hàng.
product_list.php, product_detail.php, search.php: Hiển thị sản phẩm, chi tiết, tìm kiếm.
cart.php, checkout.php: Giỏ hàng và thanh toán.
feedback_history.php, feedback_form.php: Lịch sử và form đánh giá.
promotions.php: Danh sách khuyến mãi.
order_history.php: Lịch sử đơn hàng.
admin/:
login.php, dashboard.php: Đăng nhập và tổng quan admin.
product_manage.php, product_create.php: Quản lý và tạo sản phẩm.
order_manage.php, order_update.php: Quản lý và cập nhật đơn hàng.
promotion_manage.php, promotion_create.php: Quản lý và tạo khuyến mãi.
revenue.php: Thống kê doanh thu.
layouts/:
header.php, footer.php: Template người dùng.
admin_header.php, admin_footer.php: Template admin.
404.php: Trang lỗi.
6. services/
Người dùng:
search_product.php, filter_product.php: Tìm kiếm, lọc sản phẩm (JSON).
update_cart.php, add_to_cart.php: Cập nhật, thêm giỏ hàng (JSON).
get_product.php: Lấy chi tiết sản phẩm (JSON).
Admin:
get_revenue.php: Lấy dữ liệu doanh thu (JSON).
7. sql/
database.sql: Script tạo bảng: users, addresses, categories, brands, products, product_attributes, cart, promotions, orders, order_details, feedback, revenue.
8. Root files
.htaccess: Cấu hình URL thân thiện.
index.php: Điểm vào người dùng.
admin.php: Điểm vào admin.
README.md: Hướng dẫn dự án.
Phân tích yêu cầu và nguyên tắc phân chia
Yêu cầu dự án
Frontend: Giao diện responsive (Bootstrap), hỗ trợ trang chủ, tìm kiếm, giỏ hàng, thanh toán, đánh giá, quản lý tài khoản, admin.
Backend: Lập trình OOP, mô hình MVC, xử lý đăng ký/đăng nhập, sản phẩm, đơn hàng, khuyến mãi, doanh thu.
AJAX/Webservice: Tích hợp AJAX cho tìm kiếm, giỏ hàng, đánh giá, trả về JSON.
Cơ sở dữ liệu: Sử dụng bảng trong database.sql.
Chức năng:
Người dùng: Đăng ký/đăng nhập, tìm kiếm/lọc sản phẩm, giỏ hàng, thanh toán, đánh giá, khuyến mãi, lịch sử đơn hàng.
Admin: Quản lý sản phẩm, đơn hàng, khuyến mãi, thống kê doanh thu.
Nguyên tắc phân chia
Độc lập file: Mỗi file chỉ do 1 thành viên xử lý. File chung (index.php, admin.php, Database.php) do Quốc Huy quản lý.
Tách biệt module:
Phước Hưng: Giao diện và backend sản phẩm (trang chủ, danh sách, chi tiết, tìm kiếm).
Quốc Khánh: Giỏ hàng, thanh toán, lịch sử đơn hàng.
Nguyên Thảo: Quản lý tài khoản, đánh giá, khuyến mãi người dùng.
Quốc Huy: Giao diện và backend admin, cấu hình hệ thống, tích hợp AJAX.
Phối hợp AJAX: Mỗi thành viên viết AJAX cho module của mình, Quốc Huy kiểm tra tích hợp.
Quản lý mã nguồn: Sử dụng Git, branch riêng cho mỗi thành viên, Quốc Huy merge code.
Tổng quan khối lượng công việc
Views: 26 file (15 user, 11 admin).
Layouts: 5 file.
Controllers: 11 file.
Models: 11 file.
Services: 6 file.
Assets: 7 file CSS, 5 file JS tùy chỉnh.
Config/Root: 5 file.
Tổng: ~76 file 
Phân chia công việc
Phước Hưng: Giao diện và backend sản phẩm
Nhiệm vụ: Thiết kế giao diện trang chủ, danh sách sản phẩm, chi tiết sản phẩm, tìm kiếm; xây dựng backend sản phẩm; tích hợp AJAX tìm kiếm/lọc.
views/user/home.php  : Trang chủ với carousel banner, sản phẩm nổi bật. Sử dụng Bootstrap, gọi ProductController.php, tối ưu SEO.
views/user/product_list.php  : Danh sách sản phẩm với bộ lọc, phân trang. Tích hợp AJAX (filter_product.php), responsive.
views/user/product_detail.php  : Chi tiết sản phẩm, hình ảnh, đánh giá. Gọi AJAX (get_product.php), nút thêm giỏ hàng.
views/user/search.php  : Kết quả tìm kiếm với bộ lọc. Gọi AJAX (search_product.php), responsive.
views/layouts/header.php  : Header với tìm kiếm, menu danh mục. Gọi AJAX, responsive.
views/layouts/footer.php  : Footer với thông tin liên hệ, mạng xã hội. Responsive.
controllers/ProductController.php  : Xử lý danh sách, chi tiết, tìm kiếm, lọc sản phẩm. Gọi Product.php, Category.php.
models/Product.php  : Truy vấn sản phẩm (tìm kiếm, lọc, phân trang). Sử dụng PDO.
models/Category.php  : Truy vấn danh mục. Sử dụng PDO.
services/search_product.php  : Tìm kiếm sản phẩm, trả JSON. Gọi Product.php.
services/filter_product.php  : Lọc sản phẩm, trả JSON. Gọi Product.php, Category.php.
services/get_product.php  : Lấy chi tiết sản phẩm, trả JSON. Gọi Product.php.
assets/css/style.css  : CSS cho giao diện người dùng, responsive.
assets/css/categories.css  : CSS cho menu danh mục, responsive.
assets/js/main.js  : AJAX cho tìm kiếm, lọc, chi tiết sản phẩm (hàm searchProducts, filterProducts, getProductDetail).
Tổng: 15 file
Lưu ý:
Đảm bảo responsive, tối ưu SEO (meta tags).
Phối hợp với Quốc Huy kiểm tra AJAX.
Không chỉnh sửa phần giỏ hàng trong main.js.
Quốc Khánh: Giỏ hàng, thanh toán, lịch sử đơn hàng
Nhiệm vụ: Thiết kế giao diện và backend giỏ hàng, thanh toán, lịch sử đơn hàng; tích hợp AJAX giỏ hàng.
views/user/cart.php  : Giỏ hàng với danh sách sản phẩm, chỉnh sửa/xóa. Tích hợp AJAX (update_cart.php), responsive.
views/user/checkout.php  : Thanh toán với form địa chỉ, phương thức thanh toán. Gọi OrderController.php, responsive.
views/user/order_history.php  : Lịch sử đơn hàng với bảng danh sách. Gọi OrderController.php, hỗ trợ phân trang.
controllers/CartController.php  : Xử lý thêm, sửa, xóa giỏ hàng. Gọi Cart.php.
controllers/OrderController.php  : Xử lý đặt hàng, lịch sử đơn hàng. Gọi Order.php, OrderDetail.php.
models/Cart.php  : Quản lý giỏ hàng. Sử dụng PDO, lưu theo user_id.
models/Order.php  : Quản lý đơn hàng. Sử dụng PDO, tối ưu truy vấn.
models/OrderDetail.php  : Quản lý chi tiết đơn hàng. Sử dụng PDO.
services/update_cart.php  : Cập nhật giỏ hàng, trả JSON. Gọi Cart.php.
services/add_to_cart.php  : Thêm sản phẩm vào giỏ hàng, trả JSON. Gọi Cart.php.
assets/css/cart.css  : CSS cho giỏ hàng, thanh toán, responsive.
assets/js/cart.js  : AJAX cho giỏ hàng, thanh toán (hàm updateCart, checkout).
Tổng: 12 file
Lưu ý:
Giao diện trực quan, dễ dùng.
Phối hợp với Quốc Huy kiểm tra AJAX.
Chỉ đọc Product.php (Phước Hưng).
Nguyên Thảo: Quản lý tài khoản, đánh giá, khuyến mãi
Nhiệm vụ: Thiết kế giao diện và backend đăng nhập, đăng ký, khôi phục mật khẩu, tài khoản, đánh giá, khuyến mãi; tích hợp AJAX đánh giá, khuyến mãi.
views/user/login.php  : Form đăng nhập. Gọi UserController.php, responsive.
views/user/register.php  : Form đăng ký. Kiểm tra client-side, gọi UserController.php.
views/user/forgot_password.php  : Form khôi phục mật khẩu. Gọi UserController.php.
views/user/account.php  : Quản lý tài khoản, lịch sử đơn hàng. Gọi UserController.php, responsive.
views/user/feedback_form.php  : Form đánh giá sản phẩm. Gọi FeedbackController.php qua AJAX.
views/user/feedback_history.php  : Lịch sử đánh giá. Gọi FeedbackController.php, responsive.
views/user/promotions.php  : Danh sách khuyến mãi. Gọi PromotionController.php, hỗ trợ phân trang.
controllers/UserController.php  : Xử lý đăng nhập, đăng ký, khôi phục mật khẩu, cập nhật tài khoản. Gọi User.php.
controllers/FeedbackController.php  : Xử lý đánh giá qua AJAX. Gọi Feedback.php.
controllers/PromotionController.php  : Xử lý khuyến mãi, áp dụng mã. Gọi Promotion.php.
models/User.php  : Quản lý người dùng, mã hóa mật khẩu. Sử dụng PDO.
models/Feedback.php  : Quản lý đánh giá. Sử dụng PDO.
models/Promotion.php  : Quản lý khuyến mãi. Sử dụng PDO.
assets/css/login.css  : CSS cho đăng nhập, đăng ký, khôi phục mật khẩu, responsive.
assets/css/register.css  : CSS cho đăng ký, responsive.
assets/js/main.js  : AJAX cho đánh giá, khuyến mãi (hàm submitFeedback, applyPromotion).
Tổng: 16 file
Lưu ý:
Đảm bảo bảo mật (mã hóa mật khẩu, chống XSS).
Phối hợp với Quốc Khánh cho lịch sử đơn hàng trong account.php.
Chỉ viết phần đánh giá/khuyến mãi trong main.js.
Quốc Huy: Quản lý admin, cấu hình hệ thống
Nhiệm vụ: Thiết kế giao diện và backend admin; cấu hình hệ thống; giám sát AJAX; viết tài liệu.
views/admin/login.php  : Form đăng nhập admin. Gọi AdminController.php, responsive.
views/admin/dashboard.php  : Tổng quan admin (đơn hàng, doanh thu). Gọi AdminController.php.
views/admin/product_manage.php  : Quản lý sản phẩm, phân trang. Gọi AdminProductController.php.
views/admin/product_create.php  : Form tạo sản phẩm. Gọi AdminProductController.php.
views/admin/order_manage.php  : Quản lý đơn hàng, phân trang. Gọi AdminOrderController.php.
views/admin/order_update.php  : Form cập nhật trạng thái đơn hàng. Gọi AdminOrderController.php.
views/admin/promotion_manage.php  : Quản lý khuyến mãi. Gọi AdminPromotionController.php.
views/admin/promotion_create.php  : Form tạo khuyến mãi. Gọi AdminPromotionController.php.
views/admin/revenue.php  : Thống kê doanh thu, biểu đồ Chart.js. Gọi AdminRevenueController.php.
views/layouts/admin_header.php  : Header admin, responsive.
views/layouts/admin_footer.php  : Footer admin, tối ưu JS.
controllers/AdminController.php  : Đăng nhập, dashboard admin. Gọi Revenue.php.
controllers/AdminProductController.php  : Thêm, sửa, xóa sản phẩm. Gọi Product.php.
controllers/AdminOrderController.php  : Quản lý đơn hàng. Gọi Order.php.
controllers/AdminPromotionController.php  : Quản lý khuyến mãi. Gọi Promotion.php.
controllers/AdminRevenueController.php  : Thống kê doanh thu. Gọi Revenue.php.
models/Revenue.php  : Thống kê doanh thu. Sử dụng PDO.
models/Database.php  : Kết nối PDO, xử lý truy vấn.
models/Password_Admin_User.php  : Xử lý mật khẩu admin, người dùng.
config/database.php  : Cấu hình kết nối MySQL.
config/config.php  : Định nghĩa hằng số.
.htaccess  : Cấu hình URL thân thiện.
index.php  : Định tuyến người dùng.
admin.php  : Định tuyến admin.
README.md  : Hướng dẫn cài đặt, sử dụng.
assets/css/admin.css  : CSS cho giao diện admin, responsive.
assets/css/revenue.css  : CSS cho thống kê doanh thu, responsive.
assets/js/admin.js  : AJAX cho admin, biểu đồ doanh thu.
sql/database.sql  : Script tạo bảng, dữ liệu mẫu.
Tổng: 29 file
Lưu ý:
Chỉ ghi dữ liệu vào Product.php, Order.php, Promotion.php (đọc bởi các thành viên khác).
Giám sát tích hợp AJAX toàn hệ thống.
Kiểm tra index.php, admin.php.

Kế hoạch tổng thể
Lộ trình thực hiện (15 ngày)
13-15/5: Chuẩn bị, thiết kế giao diện 
Cả nhóm: Thiết kế giao diện (views/, CSS, JS) bằng Bootstrap.
Quốc Huy: Thiết lập cơ sở dữ liệu (database.sql), cấu hình database.php, config.php, .htaccess, index.php, admin.php.
Kiểm tra: Responsive trên Chrome DevTools.
16-20/5: Backend (OOP, MVC)
Cả nhóm: Xây dựng controllers, models (OOP, PDO).
Quốc Huy: Kiểm tra kết nối PDO, route chính.
Kiểm tra: Unit test cơ bản (đăng nhập, giỏ hàng).
21-24: Tích hợp AJAX
Cả nhóm: Tích hợp AJAX (services/, JS).
Quốc Huy: Kiểm tra JSON, hiệu suất AJAX (<500ms).
Kiểm tra: AJAX trên Chrome, Firefox.
25-28: Hoàn thiện, tối ưu 
Cả nhóm: Sửa lỗi, tối ưu (minify CSS/JS, lazy load hình ảnh, index bảng).
Quốc Huy: Viết README.md, kiểm tra toàn hệ thống.
Kiểm tra: Chạy thử flow người dùng, admin trên localhost.

Bảo mật
Frontend: Kiểm tra form (HTML escape, jQuery validate).
Backend: Mã hóa mật khẩu (password_hash), prepared statements, chống XSS.
Cơ sở dữ liệu: Index cột truy vấn, sao lưu database.sql hàng tuần.
Công nghệ sử dụng
Frontend: HTML, CSS, JavaScript, Bootstrap 5, jQuery, Font Awesome, Chart.js.
Backend: PHP 8.x, MySQL 8.x, PDO.
IDE: Visual Studio Code (PHP Intelephense, Prettier, GitLens).
Server: XAMPP/WAMP, Apache.
Quản lý mã nguồn: Git, GitHub/GitLab.
Tính năng chính
Người dùng
Quản lý tài khoản: Đăng ký, đăng nhập, khôi phục mật khẩu, cập nhật thông tin.
Duyệt sản phẩm: Tìm kiếm, lọc, xem chi tiết sản phẩm.
Giỏ hàng: Thêm, sửa, xóa sản phẩm.
Thanh toán: Đặt hàng, chọn phương thức thanh toán (COD, chuyển khoản).
Đánh giá: Gửi đánh giá, bình luận sản phẩm.
Khuyến mãi: Áp dụng mã giảm giá.
Lịch sử đơn hàng: Xem đơn đã đặt.
Admin
Quản lý sản phẩm: Thêm, sửa, xóa sản phẩm.
Quản lý đơn hàng: Xem, cập nhật trạng thái.
Quản lý khuyến mãi: Tạo, sửa, xóa mã.
Thống kê doanh thu: Biểu đồ, bảng theo ngày/tháng/năm.
Luồng tương tác người dùng
Người dùng
Truy cập home.php, xem sản phẩm nổi bật, danh mục.
Tìm kiếm/lọc sản phẩm qua product_list.php, search.php.
Xem chi tiết sản phẩm tại product_detail.php, thêm vào giỏ hàng.
Điều chỉnh giỏ hàng (cart.php), áp dụng mã khuyến mãi (promotions.php), thanh toán (checkout.php).
Xem lịch sử đơn hàng (order_history.php), gửi đánh giá (feedback_form.php).
Admin
Đăng nhập qua admin/login.php.
Xem tổng quan tại dashboard.php.
Quản lý sản phẩm (product_manage.php), đơn hàng (order_manage.php), khuyến mãi (promotion_manage.php), doanh thu (revenue.php).
