TechStore/
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
   •	css/: Chứa các file CSS tùy chỉnh cho giao diện người dùng (style.css), admin (admin.css), và các trang cụ thể (đăng nhập, danh mục, doanh thu).
   •	js/: Chứa JavaScript xử lý tìm kiếm, giỏ hàng (main.js), admin (admin.js), và thư viện (bootstrap.min.js, chart.min.js).
   •	image/: Lưu trữ hình ảnh sản phẩm, banner, logo, mã QR.
   •	fonts/: Font chữ tùy chỉnh.
   •	lib/: Thư viện Bootstrap, Font Awesome.
2. config/
   •	database.php: Cấu hình kết nối MySQL (host, user, password).
   •	config.php: Định nghĩa hằng số (BASE_URL, IMAGES_PATH).
3. controllers/
   •	Người dùng:
   o	UserController.php: Quản lý đăng nhập, đăng ký, thông tin tài khoản.
   o	ProductController.php: Hiển thị, tìm kiếm, lọc sản phẩm.
   o	CartController.php: Quản lý giỏ hàng.
   o	OrderController.php: Xử lý đặt hàng, lịch sử đơn hàng.
   o	FeedbackController.php: Quản lý đánh giá sản phẩm.
   o	PromotionController.php: Quản lý mã khuyến mãi.
   •	Admin:
   o	AdminController.php: Đăng nhập, dashboard admin.
   o	AdminProductController.php: Quản lý sản phẩm.
   o	AdminOrderController.php: Quản lý đơn hàng.
   o	AdminPromotionController.php: Quản lý khuyến mãi.
   o	AdminRevenueController.php: Thống kê doanh thu.
4. models/
   •	Người dùng:
   o	User.php: Quản lý thông tin người dùng.
   o	Product.php: Quản lý sản phẩm.
   o	Category.php: Quản lý danh mục.
   o	Cart.php: Quản lý giỏ hàng.
   o	Order.php, OrderDetail.php: Quản lý đơn hàng và chi tiết.
   o	Feedback.php: Quản lý đánh giá.
   o	Promotion.php: Quản lý khuyến mãi.
   •	Admin:
   o	Revenue.php: Thống kê doanh thu.
   o	Password_Admin_User.php: Xử lý mật khẩu.
   o	Database.php: Kết nối PDO.
5. views/
   •	user/:
   o	home.php: Trang chủ với banner, sản phẩm nổi bật.
   o	login.php, register.php, forgot_password.php: Giao diện đăng nhập/đăng ký/khôi phục mật khẩu.
   o	account.php: Quản lý thông tin cá nhân, đơn hàng.
   o	product_list.php, product_detail.php, search.php: Hiển thị sản phẩm, chi tiết, tìm kiếm.
   o	cart.php, checkout.php: Giỏ hàng và thanh toán.
   o	feedback_history.php, feedback_form.php: Lịch sử và form đánh giá.
   o	promotions.php: Danh sách khuyến mãi.
   o	order_history.php: Lịch sử đơn hàng.
   •	admin/:
   o	login.php, dashboard.php: Đăng nhập và tổng quan admin.
   o	product_manage.php, product_create.php: Quản lý và tạo sản phẩm.
   o	order_manage.php, order_update.php: Quản lý và cập nhật đơn hàng.
   o	promotion_manage.php, promotion_create.php: Quản lý và tạo khuyến mãi.
   o	revenue.php: Thống kê doanh thu.
   •	layouts/:
   o	header.php, footer.php: Template người dùng.
   o	admin_header.php, admin_footer.php: Template admin.
   o	404.php: Trang lỗi.
6. services/
   •	Người dùng:
   o	search_product.php, filter_product.php: Tìm kiếm, lọc sản phẩm (JSON).
   o	update_cart.php, add_to_cart.php: Cập nhật, thêm giỏ hàng (JSON).
   o	get_product.php: Lấy chi tiết sản phẩm (JSON).
   •	Admin:
   o	get_revenue.php: Lấy dữ liệu doanh thu (JSON).
7. sql/
   •	database.sql: Script tạo bảng: users, addresses, categories, brands, products, product_attributes, cart, promotions, orders, order_details, feedback, revenue.
8. Root files
   •	.htaccess: Cấu hình URL thân thiện.
   •	index.php: Điểm vào người dùng.
   •	admin.php: Điểm vào admin.
   •	README.md: Hướng dẫn dự án.
   Phân tích yêu cầu và nguyên tắc phân chia
   Yêu cầu dự án
   •	Frontend: Giao diện responsive (Bootstrap), hỗ trợ trang chủ, tìm kiếm, giỏ hàng, thanh toán, đánh giá, quản lý tài khoản, admin.
   •	Backend: Lập trình OOP, mô hình MVC, xử lý đăng ký/đăng nhập, sản phẩm, đơn hàng, khuyến mãi, doanh thu.
   •	AJAX/Webservice: Tích hợp AJAX cho tìm kiếm, giỏ hàng, đánh giá, trả về JSON.
   •	Cơ sở dữ liệu: Sử dụng bảng trong database.sql.
   •	Chức năng:
   o	Người dùng: Đăng ký/đăng nhập, tìm kiếm/lọc sản phẩm, giỏ hàng, thanh toán, đánh giá, khuyến mãi, lịch sử đơn hàng.
   o	Admin: Quản lý sản phẩm, đơn hàng, khuyến mãi, thống kê doanh thu.
   Nguyên tắc phân chia
   •	Độc lập file: Mỗi file chỉ do 1 thành viên xử lý. File chung (index.php, admin.php, Database.php) do Quốc Huy quản lý.
   •	Tách biệt module:
   o	Phước Hưng: Giao diện và backend sản phẩm (trang chủ, danh sách, chi tiết, tìm kiếm).
   o	Quốc Khánh: Giỏ hàng, thanh toán, lịch sử đơn hàng.
   o	Nguyên Thảo: Quản lý tài khoản, đánh giá, khuyến mãi người dùng.
   o	Quốc Huy: Giao diện và backend admin, cấu hình hệ thống, tích hợp AJAX.
   •	Phối hợp AJAX: Mỗi thành viên viết AJAX cho module của mình, Quốc Huy kiểm tra tích hợp.
   •	Quản lý mã nguồn: Sử dụng Git, branch riêng cho mỗi thành viên, Quốc Huy merge code.
   Tổng quan khối lượng công việc
   •	Views: 26 file (15 user, 11 admin).
   •	Layouts: 5 file.
   •	Controllers: 11 file.
   •	Models: 11 file.
   •	Services: 6 file.
   •	Assets: 7 file CSS, 5 file JS tùy chỉnh.
   •	Config/Root: 5 file.
   •	Tổng: ~76 file

Kế hoạch tổng thể
Lộ trình thực hiện (15 ngày)

1. 13-15/5: Chuẩn bị, thiết kế giao diện
   o	Cả nhóm: Thiết kế giao diện (views/, CSS, JS) bằng Bootstrap.
   o	Quốc Huy: Thiết lập cơ sở dữ liệu (database.sql), cấu hình database.php, config.php, .htaccess, index.php, admin.php.
   o	Kiểm tra: Responsive trên Chrome DevTools.
2. 16-20/5: Backend (OOP, MVC)
   o	Cả nhóm: Xây dựng controllers, models (OOP, PDO).
   o	Quốc Huy: Kiểm tra kết nối PDO, route chính.
   o	Kiểm tra: Unit test cơ bản (đăng nhập, giỏ hàng).
3. 21-24: Tích hợp AJAX
   o	Cả nhóm: Tích hợp AJAX (services/, JS).
   o	Quốc Huy: Kiểm tra JSON, hiệu suất AJAX (<500ms).
   o	Kiểm tra: AJAX trên Chrome, Firefox.
4. 25-28: Hoàn thiện, tối ưu
   o	Cả nhóm: Sửa lỗi, tối ưu (minify CSS/JS, lazy load hình ảnh, index bảng).
   o	Quốc Huy: Viết README.md, kiểm tra toàn hệ thống.
   o	Kiểm tra: Chạy thử flow người dùng, admin trên localhost.

Bảo mật
•	Frontend: Kiểm tra form (HTML escape, jQuery validate).
•	Backend: Mã hóa mật khẩu (password_hash), prepared statements, chống XSS.
•	Cơ sở dữ liệu: Index cột truy vấn, sao lưu database.sql hàng tuần.
Công nghệ sử dụng
•	Frontend: HTML, CSS, JavaScript, Bootstrap 5, jQuery, Font Awesome, Chart.js.
•	Backend: PHP 8.x, MySQL 8.x, PDO.
•	IDE: Visual Studio Code (PHP Intelephense, Prettier, GitLens).
•	Server: XAMPP/WAMP, Apache.
•	Quản lý mã nguồn: Git, GitHub/GitLab.
Tính năng chính
Người dùng
•	Quản lý tài khoản: Đăng ký, đăng nhập, khôi phục mật khẩu, cập nhật thông tin.
•	Duyệt sản phẩm: Tìm kiếm, lọc, xem chi tiết sản phẩm.
•	Giỏ hàng: Thêm, sửa, xóa sản phẩm.
•	Thanh toán: Đặt hàng, chọn phương thức thanh toán (COD, chuyển khoản).
•	Đánh giá: Gửi đánh giá, bình luận sản phẩm.
•	Khuyến mãi: Áp dụng mã giảm giá.
•	Lịch sử đơn hàng: Xem đơn đã đặt.
Admin
•	Quản lý sản phẩm: Thêm, sửa, xóa sản phẩm.
•	Quản lý đơn hàng: Xem, cập nhật trạng thái.
•	Quản lý khuyến mãi: Tạo, sửa, xóa mã.
•	Thống kê doanh thu: Biểu đồ, bảng theo ngày/tháng/năm.
Luồng tương tác người dùng
Người dùng

1. Truy cập home.php, xem sản phẩm nổi bật, danh mục.
2. Tìm kiếm/lọc sản phẩm qua product_list.php, search.php.
3. Xem chi tiết sản phẩm tại product_detail.php, thêm vào giỏ hàng.
4. Điều chỉnh giỏ hàng (cart.php), áp dụng mã khuyến mãi (promotions.php), thanh toán (checkout.php).
5. Xem lịch sử đơn hàng (order_history.php), gửi đánh giá (feedback_form.php).
   Admin
6. Đăng nhập qua admin/login.php.
7. Xem tổng quan tại dashboard.php.
8. Quản lý sản phẩm (product_manage.php), đơn hàng (order_manage.php), khuyến mãi (promotion_manage.php), doanh thu (revenue.php).
