-- Tạo cơ sở dữ liệu
CREATE DATABASE IF NOT EXISTS doancuoikylaptrinhweb;
USE doancuoikylaptrinhweb;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 29, 2025 lúc 09:30 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `doancuoikylaptrinhweb`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_line` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `postal_code` varchar(20) DEFAULT NULL,
  `country` varchar(100) NOT NULL,
  `is_default` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line`, `city`, `postal_code`, `country`, `is_default`) VALUES
(1, 1, '123 Duong Lang', 'Ha Noi', '100000', 'Vietnam', 1),
(2, 2, '456 Nguyen Hue', 'TP.HCM', '700000', 'Vietnam', 1),
(3, 3, '789 Le Loi', 'Da Nang', '550000', 'Vietnam', 0),
(4, 4, '101 Tran Phu', 'Hai Phong', '180000', 'Vietnam', 1),
(5, 5, '202 Nguyen Thi Minh Khai', 'Can Tho', '900000', 'Vietnam', 0),
(6, 6, '303 Pham Ngu Lao', 'Ha Noi', '100000', 'Vietnam', 1),
(7, 7, '404 Ly Thuong Kiet', 'TP.HCM', '700000', 'Vietnam', 0),
(8, 8, '505 Nguyen Van Cu', 'Da Nang', '550000', 'Vietnam', 1),
(9, 9, '606 Hoang Dieu', 'Hai Phong', '180000', 'Vietnam', 0),
(10, 10, '707 Nguyen Trai', 'Can Tho', '900000', 'Vietnam', 1),
(11, 11, 'Chung cư Intela huyện Bình Chánh 1', 'Hồ Chí Minh', '9999999', 'Vietnam', 1),
(12, 11, 'Chung cư Intela huyện Bình Chánh', 'Hà Nội', '9999999', 'Vietnam', 0);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `brands`
--

INSERT INTO `brands` (`id`, `name`, `logo`) VALUES
(1, 'Apple', '/images/brands/apple.png'),
(2, 'Samsung', '/images/brands/samsung.png'),
(3, 'Xiaomi', '/images/brands/xiaomi.png'),
(4, 'Dell', '/images/brands/dell.png'),
(5, 'Sony', '/images/brands/sony.png'),
(6, 'Huawei', '/images/brands/huawei.png'),
(7, 'Asus', '/images/brands/asus.png'),
(8, 'HP', '/images/brands/hp.png'),
(9, 'Lenovo', '/images/brands/lenovo.png'),
(10, 'Oppo', '/images/brands/oppo.png');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(2, 2, 2, 1, '2025-05-02 04:00:00'),
(3, 3, 3, 3, '2025-05-03 05:00:00'),
(4, 4, 4, 1, '2025-05-04 06:00:00'),
(5, 5, 5, 2, '2025-05-05 07:00:00'),
(6, 6, 6, 4, '2025-05-06 08:00:00'),
(7, 7, 7, 1, '2025-05-07 09:00:00'),
(8, 8, 8, 2, '2025-05-08 10:00:00'),
(9, 9, 9, 1, '2025-05-09 11:00:00'),
(15, 1, 20, 9, '2025-05-29 08:57:36'),
(20, 1, 18, 1, '2025-05-29 13:09:47'),
(25, 11, 21, 1, '2025-05-29 18:12:11'),
(26, 11, 20, 3, '2025-05-29 19:02:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Dien thoai', 'Cac dong dien thoai thong minh'),
(2, 'Laptop', 'May tinh xach tay'),
(3, 'May tinh bang', 'Thiet bi di dong co lon'),
(4, 'Phu kien', 'Tai nghe, sac, op lung'),
(5, 'Dong ho thong minh', 'Thiet bi deo tay thong minh'),
(6, 'Loa Bluetooth', 'Thiet bi am thanh di dong'),
(7, 'May anh', 'May anh ky thuat so'),
(8, 'May choi game', 'Thiet bi choi game cam tay'),
(9, 'PC', 'May tinh de ban'),
(10, 'Man hinh', 'Man hinh may tinh');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `feedback`
--

CREATE TABLE `feedback` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` >= 1 and `rating` <= 5),
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `feedback`
--

INSERT INTO `feedback` (`id`, `user_id`, `product_id`, `rating`, `comment`, `created_at`) VALUES
(1, 1, 1, 5, 'San pham tuyet voi, dung rat muot!', '2025-01-01 03:00:00'),
(2, 2, 2, 4, 'Laptop manh, nhung pin hoi nhanh het.', '2025-01-02 04:00:00'),
(3, 3, 3, 3, 'Dien thoai OK, nhung camera chup dem kem.', '2025-01-03 05:00:00'),
(4, 4, 4, 5, 'Laptop sieu mong, thiet ke dep.', '2025-01-04 06:00:00'),
(5, 5, 5, 4, 'iPad muot, nhung gia hoi cao.', '2025-01-05 07:00:00'),
(6, 6, 6, 5, 'Tai nghe chat luong am thanh tuyet voi.', '2025-01-06 08:00:00'),
(7, 7, 7, 3, 'Dong ho dep, nhung ket noi hoi cham.', '2025-01-07 09:00:00'),
(8, 8, 8, 4, 'Loa Bluetooth am thanh to, thiet ke dep.', '2025-01-08 10:00:00'),
(9, 9, 9, 5, 'Laptop gaming manh me, choi game muot.', '2025-01-09 11:00:00'),
(11, 11, 1, 3, 'xấu', '2025-05-29 07:49:55'),
(12, 11, 20, 3, 'xấu', '2025-05-29 07:56:16'),
(13, 11, 18, 3, 'quá mệt', '2025-05-29 15:23:21');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `address_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `promotion_id` int(11) DEFAULT NULL,
  `payment_method` enum('cod','bank_transfer','e_wallet') NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `address_id`, `total_amount`, `promotion_id`, `payment_method`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 27000000, 1, 'cod', 'delivered', '2025-01-01 03:00:00', '2025-05-24 16:57:10'),
(2, 2, 2, 17000000, NULL, 'bank_transfer', 'pending', '2025-01-02 04:00:00', '2025-05-24 16:57:18'),
(3, 3, 3, 23500000, 2, 'e_wallet', 'processing', '2025-01-03 05:00:00', '2025-05-25 16:57:26'),
(4, 4, 4, 15000000, 3, 'cod', 'processing', '2025-01-04 06:00:00', '2025-05-24 16:57:38'),
(5, 5, 5, 28000000, NULL, 'bank_transfer', 'processing', '2025-01-05 07:00:00', '2025-05-24 16:57:54'),
(6, 6, 6, 25555600, 4, 'e_wallet', 'delivered', '2025-01-06 08:00:00', '2025-05-24 17:00:48'),
(8, 8, 8, 13000000, NULL, 'bank_transfer', 'cancelled', '2025-01-08 10:00:00', '2025-05-24 17:00:30'),
(9, 9, 9, 27000000, 6, 'e_wallet', 'shipped', '2025-01-09 11:00:00', '2025-05-24 17:00:33'),
(11, 1, 1, 999999, NULL, 'cod', 'cancelled', '2025-05-24 16:34:17', '2025-05-24 17:08:25'),
(12, 2, 2, 24000000, 1, 'e_wallet', 'delivered', '2025-05-22 16:34:17', '2025-05-24 17:15:03'),
(13, 3, 3, 32999000, 3, 'bank_transfer', 'delivered', '2025-05-23 16:34:17', '2025-05-24 17:14:58'),
(14, 4, 4, 22000000, NULL, 'cod', 'processing', '2025-05-24 16:34:17', '2025-05-24 17:00:25'),
(15, 5, 5, 17000000, 2, 'e_wallet', 'delivered', '2025-05-24 16:34:17', '2025-05-24 17:14:54'),
(16, 1, 1, 8100000, NULL, '', 'pending', '2025-05-29 06:48:14', '2025-05-29 06:48:14'),
(17, 1, 1, 23000000, NULL, '', 'shipped', '2025-05-29 06:52:48', '2025-05-29 07:04:06'),
(18, 1, 1, 18400000, NULL, '', 'pending', '2025-05-29 07:30:46', '2025-05-29 07:30:46'),
(19, 1, 1, 9000000, NULL, '', 'delivered', '2025-05-29 07:48:11', '2025-05-29 09:44:46'),
(20, 11, 11, 258000000, NULL, '', 'delivered', '2025-05-29 14:35:58', '2025-05-29 14:37:43'),
(21, 11, 11, 40000000, NULL, '', 'shipped', '2025-05-29 16:44:28', '2025-05-29 17:46:03');

--
-- Bẫy `orders`
--
DELIMITER $$
CREATE TRIGGER `after_order_delivered_insert_revenue` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF NEW.status = 'delivered' AND OLD.status <> 'delivered' THEN
        -- Chỉ thêm nếu chưa tồn tại
        IF NOT EXISTS (
            SELECT 1 FROM revenue WHERE order_id = NEW.id
        ) THEN
            INSERT INTO revenue (order_id, total_amount, revenue_date, created_at)
            VALUES (NEW.id, NEW.total_amount, DATE(NEW.created_at), NOW());
        END IF;
    END IF;
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `after_order_undelivered_delete_revenue` AFTER UPDATE ON `orders` FOR EACH ROW BEGIN
    IF OLD.status = 'delivered' AND NEW.status <> 'delivered' THEN
        DELETE FROM revenue WHERE order_id = NEW.id;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 1, 2, 999.99),
(2, 1, 5, 1, 599.99),
(3, 2, 2, 1, 1299.99),
(4, 2, 6, 1, 249.99),
(5, 3, 3, 3, 699.99),
(6, 3, 7, 1, 199.99),
(7, 4, 4, 1, 1499.99),
(8, 4, 8, 1, 299.99),
(9, 5, 5, 2, 599.99),
(10, 5, 9, 1, 1799.99),
(11, 6, 6, 4, 249.99),
(15, 8, 8, 2, 299.99),
(16, 8, 1, 1, 999.99),
(17, 9, 9, 1, 1799.99),
(18, 9, 3, 1, 699.99),
(21, 16, 1, 1, 9000000),
(22, 17, 20, 1, 23000000),
(23, 18, 20, 1, 23000000),
(24, 19, 18, 1, 9000000),
(25, 20, 20, 2, 23000000),
(26, 20, 18, 4, 9000000),
(27, 20, 6, 3, 50000000),
(28, 20, 7, 1, 26000000),
(29, 21, 18, 3, 9000000),
(30, 21, 20, 1, 23000000);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `price` float NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'iPhone 14 Pro', 'Màn Hình: Màn hình có các góc bo tròn theo đường cong tuyệt đẹp và nằm gọn theo một hình chữ nhật chuẩn. Khi tính theo hình chữ nhật chuẩn, kích thước màn hình theo đường chéo là 5,42 inch (iPhone 13 mini, iPhone 12 mini), 5,85 inch (iPhone 11 Pro, iPhone XS, iPhone X), 6,06 inch (iPhone 14, iPhone 13 Pro, iPhone 13, iPhone 12 Pro, iPhone 12, iPhone 11, iPhone XR), 6,12 inch (iPhone 15 Pro, iPhone 15, iPhone 14 Pro), 6,46 inch (iPhone 11 Pro Max, iPhone XS Max), 6,68 inch (iPhone 14 Plus, iPhone 13 Pro Max, iPhone 12 Pro Max), hoặc 6,69 inch (iPhone 15 Pro Max, iPhone 15 Plus, iPhone 14 Pro Max). Diện tích hiển thị thực tế nhỏ hơn.\r\n\r\n \r\nPin Và Nguồn Điện: Tất cả các xác nhận về thời lượng pin phụ thuộc vào cấu hình mạng và nhiều yếu tố khác; các kết quả thực tế sẽ khác nhau. Pin có giới hạn chu kỳ sạc và cuối cùng có thể cần được thay thế. Thời lượng pin và chu kỳ sạc khác nhau tùy theo cách sử dụng và cài đặt. Truy cập  và  để biết thêm thông tin.\r\n\r\n \r\nUSB-C: Cáp Sạc USB-C đi kèm các phiên bản iPhone 15 tương thích với AirPods Pro (thế hệ thứ 2) có Hộp Sạc MagSafe (USB-C).\r\n\r\n \r\nPhát Hiện Va Chạm: iPhone 14, iPhone 14 Pro, iPhone 15 và iPhone 15 Pro có thể phát hiện tình huống va chạm ô tô nghiêm trọng và gọi trợ giúp. Yêu cầu kết nối mạng di động hoặc cuộc gọi Wi-Fi.\r\n\r\n \r\nUSB 3: Yêu cầu cáp USB 3 với tốc độ 10Gb/s để đạt tốc độ truyền nhanh hơn đến 20x trên các phiên bản iPhone 15 Pro.\r\n\r\n \r\nMạng Di Động Và Không Dây: Cần có gói cước dữ liệu. Mạng 5G và LTE chỉ khả dụng ở một số thị trường và được cung cấp qua một số nhà mạng. Tốc độ phụ thuộc vào thông lượng lý thuyết và có thể thay đổi tùy địa điểm và nhà mạng. Để biết thông tin về hỗ trợ mạng 5G và LTE, vui lòng liên hệ nhà mạng và truy cập .\r\n\r\n \r\nPhụ Kiện MagSafe: Các màu chỉ nhằm mục đích minh họa. Phụ kiện MagSafe được bán riêng.\r\n\r\n \r\nƯu Đãi Apple TV+: Chỉ dành cho thuê bao mới và thuê bao đã từng sử dụng đủ điều kiện. 179.000đ/tháng cho đến khi bị hủy. Một ưu đãi cho mỗi ID Apple và nhóm Chia Sẻ Trong Gia Đình. Có áp dụng các điều khoản; vui lòng truy cập ....\r\n\r\n \r\nTính Năng Khả Dụng: Một số tính năng không khả dụng tại một số quốc gia hoặc khu vực.', 9000000, 404, 'products/1748535440_0006831_iphone-12-64gb_550.png', '2025-05-20 07:17:47', '2025-05-29 16:17:20'),
(2, 2, 2, 'Samsung Galaxy Book', 'Lịch sử hình thành, phát triển của iPhone\r\niPhone là dòng điện thoại thông minh được phát triển từ Apple Inc, được ra mắt lần đầu tiên bởi Steve Jobs và mở bán năm 2007. Bên cạnh tính năng của một máy điện thoại thông thường, iPhone còn được trang bị màn hình cảm ứng, camera, khả năng chơi nhạc và chiếu phim, trình duyệt web... Phiên bản thứ hai là iPhone 3G ra mắt tháng 7 năm 2008, được trang bị thêm hệ thống định vị toàn cầu, mạng 3G tốc độ cao. Trải qua 15 năm tính đến nay đã có đến 34 mẫu iPhone được sản xuất từ dòng 2G cho đến iPhone 13 Pro Max và Apple là một trong những thương hiệu điện thoại được yêu thích và sử dụng phổ biến nhất trên thế giới.\r\n\r\niPhone có những mã máy nào?\r\nNhững chiếc iPhone do Apple phân phối tại thị trường nước nào thì sẽ mang mã của nước đó. Ví dụ: LL: Mỹ, ZA: Singapore, TH: Thái Lan, JA: Nhật Bản, Những mã này xuất hiện tại Việt Nam đều là hàng xách tay, nhập khẩu. Còn tại Việt Nam, iPhone sẽ được mang mã VN/A. Tất cả các mã này đều là hàng chính hãng phân phối của Apple. Lợi thế khi bạn sử dụng iPhone mã VN/A đó là chế độ bảo hành tốt hơn với 12 tháng theo tiêu chuẩn của Apple. iPhone của bạn sẽ được bảo hành tại tất cả các trung tâm bảo hành Apple tại Việt Nam, một số mã quốc tế bị từ chối bảo hành và phải đem ra các trung tâm bảo hành Apple tại nước ngoài. Rất là phức tạp đúng không nào?\r\n\r\nApple đã khai tử những dòng iPhone nào?\r\nTính đến nay, Apple đã khai tử (ngừng sản xuất) các dòng iPhone đời cũ bao gồm: iPhone 2G, iPhone 3G, iPhone 4, iPhone 5 series, iPhone 6 series, iPhone 7 series, iPhone 8 series, iPhone X series, iPhone SE (thế hệ 1), iPhone SE (thế hệ 2), iPhone 11 Pro, iPhone 11 Pro Max, iPhone 12 Pro, iPhone 12 Pro Max.\r\n\r\nShopDunk cung cấp những dòng iPhone nào?\r\nShopDunk là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng...\r\n\r\nNhững chiếc iPhone do Apple Việt Nam phân phối tại nước ta đều mang mã VN/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các dòng iPhone được cung cấp tại ShopDunk gồm:\r\n\r\niPhone 11 được trang bị màn hình LCD và không hỗ trợ HDR, nâng cấp với chế độ chụp đêm Night Mode cùng Deep Fusion. Camera trước được nâng độ phân giải từ 7MP lên thành 12MP. Được trang bị chip A13 Bionic và hỗ trợ công nghệ WiFi 6. Với 6 màu sắc bắt mắt: Đen, Trắng, Xanh Mint, Đỏ, Vàng, Tím.\r\n\r\niPhone 12 mini, iPhone 12 là những chiếc iPhone đầu tiên của hãng hỗ trợ mạng di động 5G. Apple đã thay đổi thiết kế của iPhone từ khung viền bo tròn thành khung viền vuông vức như những dòng iPhone 5 và sử dụng mặt kính trước Ceramic Shield. Ngoài ra, hộp của thiết bị iPhone 12 và các dòng iPhone sau đều đã được loại bỏ củ sạc.\r\n\r\nTháng 9 năm 2021, Apple đã chính thức ra mắt 4 chiếc iPhone mới của hãng bao gồm iPhone 13 mini, iPhone 13, iPhone 13 Pro, iPhone 13 Pro Max. Các cụm Camera trên bộ 4 iPhone mới của Apple đều to hơn một chút so với thế hệ tiền nhiệm và phần tai thỏ ở mặt trước cũng được làm nhỏ hơn. Đối với iPhone 13 Pro và iPhone 13 Pro Max, Apple đã nâng cấp bộ nhớ tối đa của máy lên đến 1TB. Đi cùng với đó là tần số quét của dòng iPhone 13 cũng đã được nâng cấp lên 120Hz.\r\n\r\niPhone SE thế hệ 3 (còn gọi là iPhone SE 3 hay iPhone SE 2022) được Apple công bố vào tháng 3 năm 2022, kế nhiệm iPhone SE 2. Đây là một phần của iPhone thế hệ thứ 15, cùng với iPhone 13 và iPhone 13 Pro. Thế hệ thứ 3 có kích thước và yếu tố hình thức của thế hệ trước, trong khi các thành phần phần cứng bên trong được lựa chọn từ dòng iPhone 13, bao gồm cả hệ thống trên chip A15 Bionic.\r\n\r\n>>> Tham khảo thêm:  \r\n\r\nMua iPhone giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại  luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu iPhone mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.', 25000000, 30, 'products/1748536184_1024_5b3ad2cff4444235bdb9897806ebbc40_medium.png', '2025-05-20 07:17:47', '2025-05-29 16:29:44'),
(3, 1, 3, 'Xiaomi 13', 'Lịch sử hình thành, phát triển của iPhone\r\niPhone là dòng điện thoại thông minh được phát triển từ Apple Inc, được ra mắt lần đầu tiên bởi Steve Jobs và mở bán năm 2007. Bên cạnh tính năng của một máy điện thoại thông thường, iPhone còn được trang bị màn hình cảm ứng, camera, khả năng chơi nhạc và chiếu phim, trình duyệt web... Phiên bản thứ hai là iPhone 3G ra mắt tháng 7 năm 2008, được trang bị thêm hệ thống định vị toàn cầu, mạng 3G tốc độ cao. Trải qua 15 năm tính đến nay đã có đến 34 mẫu iPhone được sản xuất từ dòng 2G cho đến iPhone 13 Pro Max và Apple là một trong những thương hiệu điện thoại được yêu thích và sử dụng phổ biến nhất trên thế giới.\r\n\r\niPhone có những mã máy nào?\r\nNhững chiếc iPhone do Apple phân phối tại thị trường nước nào thì sẽ mang mã của nước đó. Ví dụ: LL: Mỹ, ZA: Singapore, TH: Thái Lan, JA: Nhật Bản, Những mã này xuất hiện tại Việt Nam đều là hàng xách tay, nhập khẩu. Còn tại Việt Nam, iPhone sẽ được mang mã VN/A. Tất cả các mã này đều là hàng chính hãng phân phối của Apple. Lợi thế khi bạn sử dụng iPhone mã VN/A đó là chế độ bảo hành tốt hơn với 12 tháng theo tiêu chuẩn của Apple. iPhone của bạn sẽ được bảo hành tại tất cả các trung tâm bảo hành Apple tại Việt Nam, một số mã quốc tế bị từ chối bảo hành và phải đem ra các trung tâm bảo hành Apple tại nước ngoài. Rất là phức tạp đúng không nào?\r\n\r\nApple đã khai tử những dòng iPhone nào?\r\nTính đến nay, Apple đã khai tử (ngừng sản xuất) các dòng iPhone đời cũ bao gồm: iPhone 2G, iPhone 3G, iPhone 4, iPhone 5 series, iPhone 6 series, iPhone 7 series, iPhone 8 series, iPhone X series, iPhone SE (thế hệ 1), iPhone SE (thế hệ 2), iPhone 11 Pro, iPhone 11 Pro Max, iPhone 12 Pro, iPhone 12 Pro Max.\r\n\r\nShopDunk cung cấp những dòng iPhone nào?\r\nShopDunk là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng...\r\n\r\nNhững chiếc iPhone do Apple Việt Nam phân phối tại nước ta đều mang mã VN/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các dòng iPhone được cung cấp tại ShopDunk gồm:\r\n\r\niPhone 11 được trang bị màn hình LCD và không hỗ trợ HDR, nâng cấp với chế độ chụp đêm Night Mode cùng Deep Fusion. Camera trước được nâng độ phân giải từ 7MP lên thành 12MP. Được trang bị chip A13 Bionic và hỗ trợ công nghệ WiFi 6. Với 6 màu sắc bắt mắt: Đen, Trắng, Xanh Mint, Đỏ, Vàng, Tím.\r\n\r\niPhone 12 mini, iPhone 12 là những chiếc iPhone đầu tiên của hãng hỗ trợ mạng di động 5G. Apple đã thay đổi thiết kế của iPhone từ khung viền bo tròn thành khung viền vuông vức như những dòng iPhone 5 và sử dụng mặt kính trước Ceramic Shield. Ngoài ra, hộp của thiết bị iPhone 12 và các dòng iPhone sau đều đã được loại bỏ củ sạc.\r\n\r\nTháng 9 năm 2021, Apple đã chính thức ra mắt 4 chiếc iPhone mới của hãng bao gồm iPhone 13 mini, iPhone 13, iPhone 13 Pro, iPhone 13 Pro Max. Các cụm Camera trên bộ 4 iPhone mới của Apple đều to hơn một chút so với thế hệ tiền nhiệm và phần tai thỏ ở mặt trước cũng được làm nhỏ hơn. Đối với iPhone 13 Pro và iPhone 13 Pro Max, Apple đã nâng cấp bộ nhớ tối đa của máy lên đến 1TB. Đi cùng với đó là tần số quét của dòng iPhone 13 cũng đã được nâng cấp lên 120Hz.\r\n\r\niPhone SE thế hệ 3 (còn gọi là iPhone SE 3 hay iPhone SE 2022) được Apple công bố vào tháng 3 năm 2022, kế nhiệm iPhone SE 2. Đây là một phần của iPhone thế hệ thứ 15, cùng với iPhone 13 và iPhone 13 Pro. Thế hệ thứ 3 có kích thước và yếu tố hình thức của thế hệ trước, trong khi các thành phần phần cứng bên trong được lựa chọn từ dòng iPhone 13, bao gồm cả hệ thống trên chip A15 Bionic.\r\n\r\n>>> Tham khảo thêm:  \r\n\r\nMua iPhone giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại  luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu iPhone mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.', 30000000, 60, 'products/1748536211_0012169_black.png', '2025-05-20 07:17:47', '2025-05-29 16:30:11'),
(4, 2, 4, 'Dell XPS 13', 'Laptop sieu mong tu Dell', 60000000, 20, 'products/1748536232_expertbook_b1_b1402_product_phot_c52b18232c29486283bb114a2faef66e_medium.png', '2025-05-20 07:17:47', '2025-05-29 16:30:32'),
(5, 3, 1, 'iPad Air 5', 'iPad là gì ?\r\n là máy tính bảng do Apple Inc. phát triển. Được công bố vào ngày 27 tháng 1 năm 2010, thiết bị này tạo ra một phân loại mới giữa điện thoại thông minh và máy tính xách tay.\r\n\r\nTương tự về tính năng so với thiết bị nhỏ và yếu hơn là iPhone hoặc iPod touch, iPad cũng hoạt động trên cùng hệ điều hành iPhone OS đã được sửa đổi với giao diện được thiết kế lại để phù hợp với màn hình lớn.\r\n\r\nTại sao nên mua iPad ?\r\niPad được trang bị các tính năng tiện ích để phục vụ công việc, nhu cầu giải trí hiệu quả. Trên thực tế vai trò của iPad trong học tập hay làm việc cũng không hề nhỏ nhờ các tính năng:\r\n\r\nThiết kế hiện đại và sang chảnh, nhiều màu sắc đa dạng: Xám, Bạc, Vàng Hồng, Xanh Green, Xanh Blue, Tím,..\r\nGọn nhẹ chỉ khoảng 300g. Bạn có thể mang theo mọi nơi một cách thuận tiện.\r\nMàn hình sắc nét, rộng, với cảm ứng đa điểm, góc nhìn thoáng giúp cho việc xem phim, đọc báo hay chơi game dễ dàng và thú vị hơn.\r\nKết nối mạng 4G, 5G mọi lúc mọi nơi, phục vụ nhu cầu sử dụng một cách nhanh nhất.\r\nThời lượng pin lên đến 10 tiếng thoải mái sử dụng cả ngày, mang đến trải nghiệm trọn vẹn nhất.\r\nHơn một triệu ứng dụng được thiết kế riêng cho iPad để làm việc hiệu quả, trò chơi, du lịch, hình ảnh, AR, học tập, v.v.\r\nShopDunk cung cấp những dòng iPad nào ?\r\n là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng,…\r\n\r\nNhững chiếc máy tính Mac do Apple Việt Nam phân phối tại nước ta đều mang mã ZA/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các sản phẩm có tem của công ty TNHH Apple Việt Nam đều là hàng chính hãng. Mã ZA/A là vì iPad hiện chưa có mã riêng VN/A, trước đây iPad còn có mã THA.\r\n\r\nCác dòng máy tính Mac được cung cấp tại ShopDunk gồm: , , iPad gen 9, iPad Air 4, iPad Air 5, iPad mini 6, iPad Pro M1, iPad Air M2, iPad Air M3, iPad Pro M4\r\n\r\niPad gen 9: iPad sở hữu màn hình Retina 10,2 inch tuyệt đẹp có True Tone, chip A13 Bionic mạnh mẽ với Neural Engine, camera trước 12MP Ultra Wide có tính năng Trung tâm màn hình, cùng với tất cả các khả năng của iPadOS 15. \r\nThiết bị hỗ trợ Apple Pencil (thế hệ đầu tiên) và Smart Keyboard, đồng thời cung cấp kết nối Wi-Fi nhanh và LTE Gigabit. iPad giá cả phải chăng nhất rất phù hợp cho những người sở hữu iPad lần đầu tiên, những khách hàng quan tâm đến việc nâng cấp cũng như sinh viên và giáo viên muốn trải nghiệm sự linh hoạt của iPad.\r\n iPad Air 4: iPad Air 4 là thiết bị gần giống với thiết kế của iPad Pro 11 inch (thế hệ 3) và có một số tính năng trước đây chỉ dành riêng cho dòng iPad Pro, chẳng hạn như hỗ trợ Bàn phím ảo. Tương thích với Apple Pencil thế hệ 2. Có sẵn 5 màu: Xám không gian, Bạc, Vàng hồng, Xanh lục và Xanh da trời.\r\niPad Air 5: iPad Air 5 trang bị chip M1 đột phá của Apple, mang đến hiệu suất ở một đẳng cấp mới gói gọn trong thiết kế mỏng nhẹ, toàn màn hình. Máy có màn hình Liquid Retina 10,9 inch sống động và có sẵn với 5 màu sản phẩm. Camera trước Ultra Wide với tính năng Trung tâm màn hình giúp giữ bạn luôn trong khung hình để tương tác trong những cuộc gọi video tốt hơn, và camera sau Wide giúp ghi lại những bức ảnh và video tuyệt đẹp.\r\nLuôn giữ kết nối với 5G tốc độ cực cao và Wi-Fi 6, tăng khả năng linh hoạt của iPad Air bằng Apple Pencil (thế hệ thứ 2) và Magic Keyboard. Và với Touch ID trên nút nguồn, cổng USB-C nhanh hơn, iPadOS 15 và hơn một triệu ứng dụng trên App Store, iPad Air mang đến sự linh hoạt và những tính năng tiên tiến. Máy hoàn hảo cho những ai muốn nâng cấp lên một chiếc iPad mạnh mẽ hơn, đa năng hơn.\r\niPad mini 6: iPad mini thế hệ 6 mang đến bản cập nhật lớn nhất từ trước đến nay cho iPad mini. Thiết bị có thiết kế viền mỏng với bốn màu tuyệt đẹp và màn hình Liquid Retina 8.3 inch lớn hơn, đẹp hơn với cùng một kích thước nhỏ gọn mà khách hàng yêu thích. Chip A15 Bionic cung cấp tốc độ xử lý cực nhanh.\r\nTận hưởng camera trước Ultra Wide với tính năng Trung tâm màn hình cho các cuộc gọi video thú vị và camera sau Wide cho những bức ảnh và video đẹp mắt. iPad mini cũng có USB-C, Touch ID ở nút trên cùng, Wi-Fi 6 cực nhanh và iPadOS 15. Và với Apple Pencil (thế hệ 2), iPad mini thậm chí còn trở nên đa năng hơn. Đơn giản là không có gì giống như iPad mini.\r\n iPad Pro M1: iPad Pro mang đến trải nghiệm iPad đỉnh cao. Chip M1 đột phá cung cấp hiệu suất ở tầm cao mới. Màn hình Liquid Retina XDR trên iPad Pro (12,9 inch) cung cấp Độ lệch tương phản cực cao cho trải nghiệm hình ảnh tuyệt vời hơn nữa. Và kiểu máy 11 inch có màn hình Liquid Retina trang bị các công nghệ tiên tiến.\r\nCác kiểu máy có mạng di động hiện có thể tận dụng kết nối 5G siêu nhanh. Camera TrueDepth có camera Ultra Wide 12MP với Trung tâm màn hình, giúp bạn giữ khung hình hoàn hảo trong các cuộc gọi video. Magic Keyboard kết hợp trải nghiệm đánh máy thoải mái với bàn di chuột. Và Apple Pencil (thế hệ 2) mang lại sự chính xác bất kể bạn viết vẽ hay thiết kế. iPad Pro vượt qua giới hạn những việc bạn có thể làm trên iPad.\r\n với chip xử lý M2 mới nhất có sức mạnh vô địch: hiệu suất GPU tăng 35%, hiệu suất CPU tăng 18% so với M1.\r\niPad 11 (A16): dòng iPad mới nhất của Apple được ra mắt trong Tháng 4/2025. iPad A16 với 11 inches màn hình hiển thị chất lượng cao, sử dụng chip A16 siêu mạnh mẽ và dung lượng lưu trữ khởi điểm từ 128GB. iPad hỗ trợ hoàn thành công việc và giải trí mọi nơi, chạy mượt mà mọi tác vụ. \r\nLà đại lý ủy quyền của Apple, ShopDunk luôn cập nhập những dòng sản phẩm mới nhất với giá tốt nhất từ nhà Táo. Đã có những dòng như iPad 2 khai tử, iPad 3 ngừng sản xuất,.... nhưng hiện tại thì các sản phẩm Ipad đang có vẫn rất đa dạng. Bạn cần biết cách  từ 2010 đến nay để tìm mua cho mình sản phẩm phù hợp nhất.\r\n\r\nMua iPad giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại ShopDunk luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu  mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.\r\n\r\n ', 70000000, 44, 'products/1748536259_0006309_space-gray_550.png', '2025-05-20 07:17:47', '2025-05-29 16:30:59'),
(6, 4, 5, 'Sony WF-1000XM4', 'Thiết bị âm thanh - Mang lại trải nghiệm nghe nhạc cực đã\r\nNghe nhạc, xem phim là nhu cầu thường ngày trong cuộc sống, giúp chúng ta thư giãn sau quãng thời gian học tập và làm việc căng thẳng. Tuy nhiên, để nâng cao trải nghiệm và có được những giây phút giải trí ấn tượng hơn, người dùng nên mua những  chuyên dụng.\r\n\r\n \r\n\r\nCác thiết bị âm thanh hiện đại đang có mặt tại ShopDunk?\r\nTai nghe dây\r\n\r\n dành riêng cho các sản phẩm Apple, kết nối với thiết bị thông qua jack cắm lightning. \r\n\r\nĐiểm nổi bật:\r\n\r\nĐầu tai nghe nhỏ, áp sát, nằm gọn trong tai.\r\nTăng giảm âm lượng với nút bấm dễ dàng.\r\nChiều dài dây tai nghe 1.2m, dễ dàng kết nối và nghe nhạc với điện thoại bỏ trong túi hoặc balo.\r\nCác sản phẩm  tiêu biểu tại ShopDunk đến từ thương hiệu Earpods của Apple, tối ưu hóa về chất lượng âm thanh, mang lại những bản nhạc có chất âm rõ ràng, trung thực và sâu lắng.\r\n\r\nTai nghe Bluetooth\r\n\r\n sử dụng giao tiếp Bluetooth như  để kết nối không dây với các thiết bị di động, rất thuận tiện cho những người thường xuyên di chuyển.\r\n\r\nĐiểm nổi bật: \r\n\r\nThiết kế tinh tế, toát lên vẻ thời trang, tích hợp công nghệ loại bỏ tiếng ồn, truyền tải âm thanh chân thực, hỗ trợ micro cho phép đàm thoại rảnh tay (không cần đụng đến điện thoại).\r\n nhỏ gọn, dễ dàng mang theo mọi nơi. Thiết kế hiện đại, kiểu dáng hợp thời trang, thể hiện được cá tính của người trẻ, cộng với màu sắc thu hút, đang là những điểm mạnh thu hút nhiều người dùng chuyển từ tai nghe dây sang tai nghe Bluetooth bất chấp giá cả có phần cao hơn.\r\nDòng sản phẩm tiêu biểu: AirPods, Beats, JBL.\r\nLoa Bluetooth di động\r\n\r\nLoa nghe nhạc kết nối thông qua Bluetooth, có kích thước từ nhỏ gọn đến vừa phải để dễ dàng mang theo. \r\n\r\nĐiểm nổi bật: \r\n\r\nChức năng kết nối Bluetooth nhanh nhạy với tất cả các thiết bị khác. Duy trì kết nối không dây mượt mà trong bán kính lên tới 10m.\r\nTích hợp tiêu chuẩn chống nước, chống bụi giảm thiểu rủi ro hư hỏng, cung cấp âm thanh mạnh mẽ, có thể kết nối nhiều loa lại với nhau, hỗ trợ micro nhận – trả lời cuộc gọi tiện lợi và thời lượng pin tốt.\r\nDòng sản phẩm tiêu biểu: JBL, Google, Harman Kardon.\r\n \r\n\r\nTại sao người dùng cần đến sự hỗ trợ của các thiết bị âm thanh?\r\nNghe nhạc, xem phim với âm thanh không chỉ chân thực, sống động hơn, gia tăng sự thoải mái mà còn trong trẻo, rõ ràng, âm bass chi tiết.\r\nCác sản phẩm tai nghe duy trì sự riêng tư, mang lại trải nghiệm cá nhân thêm phần ấn tượng.\r\nNhiều loại mang tính di động cao, dễ dàng mang theo bên mình khi di chuyển.\r\nTích hợp nhiều công nghệ, tính năng hiện đại và hữu ích.\r\nNhững loại tai nghe Bluetooth được chú trọng về kiểu dáng thiết kế cũng như màu sắc, tạo nên sự thời thượng, phù hợp phong cách giới trẻ\r\n \r\n\r\nĐịa chỉ mua Thiết bị âm thanh uy tín?\r\nNếu như bạn yêu thích cũng như đang có nhu cầu sở hữu các sản phẩm Tai nghe hay Loa Bluetooth hiện đại, đến ngay ShopDunk để lựa chọn cho mình sản phẩm ưa thích và phù hợp nhất hoặc tham khảo các sản phẩm tại  qua Website:  . \r\n\r\n – Đại lý ủy quyền Apple, chúng tôi cam kết mang đến sự hài lòng cho khách hàng không chỉ bởi luôn cập nhật thường xuyên các mẫu mã sản phẩm âm thanh mới nhất từ các thương hiệu lớn trên thị trường: Apple, JBL, Google,… mà còn bởi đội ngũ nhân viên trẻ trung, luôn nắm bắt xu hướng công nghệ mới cũng như luôn nhiệt tình tư vấn cho khách hàng', 50000000, 100, 'products/1748536718_pc_asus_tuf_btf_-_3_2d54bb55a893411d8ba905a11eb5a05c_grande.png', '2025-05-20 07:17:47', '2025-05-29 16:38:38'),
(7, 5, 6, 'Huawei Watch GT 3', 'Thiết bị âm thanh - Mang lại trải nghiệm nghe nhạc cực đã\r\nNghe nhạc, xem phim là nhu cầu thường ngày trong cuộc sống, giúp chúng ta thư giãn sau quãng thời gian học tập và làm việc căng thẳng. Tuy nhiên, để nâng cao trải nghiệm và có được những giây phút giải trí ấn tượng hơn, người dùng nên mua những  chuyên dụng.\r\n\r\n \r\n\r\nCác thiết bị âm thanh hiện đại đang có mặt tại ShopDunk?\r\nTai nghe dây\r\n\r\n dành riêng cho các sản phẩm Apple, kết nối với thiết bị thông qua jack cắm lightning. \r\n\r\nĐiểm nổi bật:\r\n\r\nĐầu tai nghe nhỏ, áp sát, nằm gọn trong tai.\r\nTăng giảm âm lượng với nút bấm dễ dàng.\r\nChiều dài dây tai nghe 1.2m, dễ dàng kết nối và nghe nhạc với điện thoại bỏ trong túi hoặc balo.\r\nCác sản phẩm  tiêu biểu tại ShopDunk đến từ thương hiệu Earpods của Apple, tối ưu hóa về chất lượng âm thanh, mang lại những bản nhạc có chất âm rõ ràng, trung thực và sâu lắng.\r\n\r\nTai nghe Bluetooth\r\n\r\n sử dụng giao tiếp Bluetooth như  để kết nối không dây với các thiết bị di động, rất thuận tiện cho những người thường xuyên di chuyển.\r\n\r\nĐiểm nổi bật: \r\n\r\nThiết kế tinh tế, toát lên vẻ thời trang, tích hợp công nghệ loại bỏ tiếng ồn, truyền tải âm thanh chân thực, hỗ trợ micro cho phép đàm thoại rảnh tay (không cần đụng đến điện thoại).\r\n nhỏ gọn, dễ dàng mang theo mọi nơi. Thiết kế hiện đại, kiểu dáng hợp thời trang, thể hiện được cá tính của người trẻ, cộng với màu sắc thu hút, đang là những điểm mạnh thu hút nhiều người dùng chuyển từ tai nghe dây sang tai nghe Bluetooth bất chấp giá cả có phần cao hơn.\r\nDòng sản phẩm tiêu biểu: AirPods, Beats, JBL.\r\nLoa Bluetooth di động\r\n\r\nLoa nghe nhạc kết nối thông qua Bluetooth, có kích thước từ nhỏ gọn đến vừa phải để dễ dàng mang theo. \r\n\r\nĐiểm nổi bật: \r\n\r\nChức năng kết nối Bluetooth nhanh nhạy với tất cả các thiết bị khác. Duy trì kết nối không dây mượt mà trong bán kính lên tới 10m.\r\nTích hợp tiêu chuẩn chống nước, chống bụi giảm thiểu rủi ro hư hỏng, cung cấp âm thanh mạnh mẽ, có thể kết nối nhiều loa lại với nhau, hỗ trợ micro nhận – trả lời cuộc gọi tiện lợi và thời lượng pin tốt.\r\nDòng sản phẩm tiêu biểu: JBL, Google, Harman Kardon.\r\n \r\n\r\nTại sao người dùng cần đến sự hỗ trợ của các thiết bị âm thanh?\r\nNghe nhạc, xem phim với âm thanh không chỉ chân thực, sống động hơn, gia tăng sự thoải mái mà còn trong trẻo, rõ ràng, âm bass chi tiết.\r\nCác sản phẩm tai nghe duy trì sự riêng tư, mang lại trải nghiệm cá nhân thêm phần ấn tượng.\r\nNhiều loại mang tính di động cao, dễ dàng mang theo bên mình khi di chuyển.\r\nTích hợp nhiều công nghệ, tính năng hiện đại và hữu ích.\r\nNhững loại tai nghe Bluetooth được chú trọng về kiểu dáng thiết kế cũng như màu sắc, tạo nên sự thời thượng, phù hợp phong cách giới trẻ\r\n \r\n\r\nĐịa chỉ mua Thiết bị âm thanh uy tín?\r\nNếu như bạn yêu thích cũng như đang có nhu cầu sở hữu các sản phẩm Tai nghe hay Loa Bluetooth hiện đại, đến ngay ShopDunk để lựa chọn cho mình sản phẩm ưa thích và phù hợp nhất hoặc tham khảo các sản phẩm tại  qua Website:  . \r\n\r\n – Đại lý ủy quyền Apple, chúng tôi cam kết mang đến sự hài lòng cho khách hàng không chỉ bởi luôn cập nhật thường xuyên các mẫu mã sản phẩm âm thanh mới nhất từ các thương hiệu lớn trên thị trường: Apple, JBL, Google,… mà còn bởi đội ngũ nhân viên trẻ trung, luôn nắm bắt xu hướng công nghệ mới cũng như luôn nhiệt tình tư vấn cho khách hàng', 26000000, 70, 'products/1748536673_xiaomi-watch-s4-den-tn-600x600.png', '2025-05-20 07:17:47', '2025-05-29 16:37:53'),
(8, 6, 2, 'Samsung Soundbar', 'Thiết bị âm thanh - Mang lại trải nghiệm nghe nhạc cực đã\r\nNghe nhạc, xem phim là nhu cầu thường ngày trong cuộc sống, giúp chúng ta thư giãn sau quãng thời gian học tập và làm việc căng thẳng. Tuy nhiên, để nâng cao trải nghiệm và có được những giây phút giải trí ấn tượng hơn, người dùng nên mua những  chuyên dụng.\r\n\r\n \r\n\r\nCác thiết bị âm thanh hiện đại đang có mặt tại ShopDunk?\r\nTai nghe dây\r\n\r\n dành riêng cho các sản phẩm Apple, kết nối với thiết bị thông qua jack cắm lightning. \r\n\r\nĐiểm nổi bật:\r\n\r\nĐầu tai nghe nhỏ, áp sát, nằm gọn trong tai.\r\nTăng giảm âm lượng với nút bấm dễ dàng.\r\nChiều dài dây tai nghe 1.2m, dễ dàng kết nối và nghe nhạc với điện thoại bỏ trong túi hoặc balo.\r\nCác sản phẩm  tiêu biểu tại ShopDunk đến từ thương hiệu Earpods của Apple, tối ưu hóa về chất lượng âm thanh, mang lại những bản nhạc có chất âm rõ ràng, trung thực và sâu lắng.\r\n\r\nTai nghe Bluetooth\r\n\r\n sử dụng giao tiếp Bluetooth như  để kết nối không dây với các thiết bị di động, rất thuận tiện cho những người thường xuyên di chuyển.\r\n\r\nĐiểm nổi bật: \r\n\r\nThiết kế tinh tế, toát lên vẻ thời trang, tích hợp công nghệ loại bỏ tiếng ồn, truyền tải âm thanh chân thực, hỗ trợ micro cho phép đàm thoại rảnh tay (không cần đụng đến điện thoại).\r\n nhỏ gọn, dễ dàng mang theo mọi nơi. Thiết kế hiện đại, kiểu dáng hợp thời trang, thể hiện được cá tính của người trẻ, cộng với màu sắc thu hút, đang là những điểm mạnh thu hút nhiều người dùng chuyển từ tai nghe dây sang tai nghe Bluetooth bất chấp giá cả có phần cao hơn.\r\nDòng sản phẩm tiêu biểu: AirPods, Beats, JBL.\r\nLoa Bluetooth di động\r\n\r\nLoa nghe nhạc kết nối thông qua Bluetooth, có kích thước từ nhỏ gọn đến vừa phải để dễ dàng mang theo. \r\n\r\nĐiểm nổi bật: \r\n\r\nChức năng kết nối Bluetooth nhanh nhạy với tất cả các thiết bị khác. Duy trì kết nối không dây mượt mà trong bán kính lên tới 10m.\r\nTích hợp tiêu chuẩn chống nước, chống bụi giảm thiểu rủi ro hư hỏng, cung cấp âm thanh mạnh mẽ, có thể kết nối nhiều loa lại với nhau, hỗ trợ micro nhận – trả lời cuộc gọi tiện lợi và thời lượng pin tốt.\r\nDòng sản phẩm tiêu biểu: JBL, Google, Harman Kardon.\r\n \r\n\r\nTại sao người dùng cần đến sự hỗ trợ của các thiết bị âm thanh?\r\nNghe nhạc, xem phim với âm thanh không chỉ chân thực, sống động hơn, gia tăng sự thoải mái mà còn trong trẻo, rõ ràng, âm bass chi tiết.\r\nCác sản phẩm tai nghe duy trì sự riêng tư, mang lại trải nghiệm cá nhân thêm phần ấn tượng.\r\nNhiều loại mang tính di động cao, dễ dàng mang theo bên mình khi di chuyển.\r\nTích hợp nhiều công nghệ, tính năng hiện đại và hữu ích.\r\nNhững loại tai nghe Bluetooth được chú trọng về kiểu dáng thiết kế cũng như màu sắc, tạo nên sự thời thượng, phù hợp phong cách giới trẻ\r\n \r\n\r\nĐịa chỉ mua Thiết bị âm thanh uy tín?\r\nNếu như bạn yêu thích cũng như đang có nhu cầu sở hữu các sản phẩm Tai nghe hay Loa Bluetooth hiện đại, đến ngay ShopDunk để lựa chọn cho mình sản phẩm ưa thích và phù hợp nhất hoặc tham khảo các sản phẩm tại  qua Website:  . \r\n\r\n – Đại lý ủy quyền Apple, chúng tôi cam kết mang đến sự hài lòng cho khách hàng không chỉ bởi luôn cập nhật thường xuyên các mẫu mã sản phẩm âm thanh mới nhất từ các thương hiệu lớn trên thị trường: Apple, JBL, Google,… mà còn bởi đội ngũ nhân viên trẻ trung, luôn nắm bắt xu hướng công nghệ mới cũng như luôn nhiệt tình tư vấn cho khách hàng', 17777800, 50, 'products/1748536620_loa-bluetooth-jbl-flip-7-160525-022117-037-600x600.png', '2025-05-20 07:17:47', '2025-05-29 16:37:00'),
(9, 2, 7, 'Asus ROG Zephyrus', 'Lịch sử hình thành, phát triển của iPhone\r\niPhone là dòng điện thoại thông minh được phát triển từ Apple Inc, được ra mắt lần đầu tiên bởi Steve Jobs và mở bán năm 2007. Bên cạnh tính năng của một máy điện thoại thông thường, iPhone còn được trang bị màn hình cảm ứng, camera, khả năng chơi nhạc và chiếu phim, trình duyệt web... Phiên bản thứ hai là iPhone 3G ra mắt tháng 7 năm 2008, được trang bị thêm hệ thống định vị toàn cầu, mạng 3G tốc độ cao. Trải qua 15 năm tính đến nay đã có đến 34 mẫu iPhone được sản xuất từ dòng 2G cho đến iPhone 13 Pro Max và Apple là một trong những thương hiệu điện thoại được yêu thích và sử dụng phổ biến nhất trên thế giới.\r\n\r\niPhone có những mã máy nào?\r\nNhững chiếc iPhone do Apple phân phối tại thị trường nước nào thì sẽ mang mã của nước đó. Ví dụ: LL: Mỹ, ZA: Singapore, TH: Thái Lan, JA: Nhật Bản, Những mã này xuất hiện tại Việt Nam đều là hàng xách tay, nhập khẩu. Còn tại Việt Nam, iPhone sẽ được mang mã VN/A. Tất cả các mã này đều là hàng chính hãng phân phối của Apple. Lợi thế khi bạn sử dụng iPhone mã VN/A đó là chế độ bảo hành tốt hơn với 12 tháng theo tiêu chuẩn của Apple. iPhone của bạn sẽ được bảo hành tại tất cả các trung tâm bảo hành Apple tại Việt Nam, một số mã quốc tế bị từ chối bảo hành và phải đem ra các trung tâm bảo hành Apple tại nước ngoài. Rất là phức tạp đúng không nào?\r\n\r\nApple đã khai tử những dòng iPhone nào?\r\nTính đến nay, Apple đã khai tử (ngừng sản xuất) các dòng iPhone đời cũ bao gồm: iPhone 2G, iPhone 3G, iPhone 4, iPhone 5 series, iPhone 6 series, iPhone 7 series, iPhone 8 series, iPhone X series, iPhone SE (thế hệ 1), iPhone SE (thế hệ 2), iPhone 11 Pro, iPhone 11 Pro Max, iPhone 12 Pro, iPhone 12 Pro Max.\r\n\r\nShopDunk cung cấp những dòng iPhone nào?\r\nShopDunk là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng...\r\n\r\nNhững chiếc iPhone do Apple Việt Nam phân phối tại nước ta đều mang mã VN/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các dòng iPhone được cung cấp tại ShopDunk gồm:\r\n\r\niPhone 11 được trang bị màn hình LCD và không hỗ trợ HDR, nâng cấp với chế độ chụp đêm Night Mode cùng Deep Fusion. Camera trước được nâng độ phân giải từ 7MP lên thành 12MP. Được trang bị chip A13 Bionic và hỗ trợ công nghệ WiFi 6. Với 6 màu sắc bắt mắt: Đen, Trắng, Xanh Mint, Đỏ, Vàng, Tím.\r\n\r\niPhone 12 mini, iPhone 12 là những chiếc iPhone đầu tiên của hãng hỗ trợ mạng di động 5G. Apple đã thay đổi thiết kế của iPhone từ khung viền bo tròn thành khung viền vuông vức như những dòng iPhone 5 và sử dụng mặt kính trước Ceramic Shield. Ngoài ra, hộp của thiết bị iPhone 12 và các dòng iPhone sau đều đã được loại bỏ củ sạc.\r\n\r\nTháng 9 năm 2021, Apple đã chính thức ra mắt 4 chiếc iPhone mới của hãng bao gồm iPhone 13 mini, iPhone 13, iPhone 13 Pro, iPhone 13 Pro Max. Các cụm Camera trên bộ 4 iPhone mới của Apple đều to hơn một chút so với thế hệ tiền nhiệm và phần tai thỏ ở mặt trước cũng được làm nhỏ hơn. Đối với iPhone 13 Pro và iPhone 13 Pro Max, Apple đã nâng cấp bộ nhớ tối đa của máy lên đến 1TB. Đi cùng với đó là tần số quét của dòng iPhone 13 cũng đã được nâng cấp lên 120Hz.\r\n\r\niPhone SE thế hệ 3 (còn gọi là iPhone SE 3 hay iPhone SE 2022) được Apple công bố vào tháng 3 năm 2022, kế nhiệm iPhone SE 2. Đây là một phần của iPhone thế hệ thứ 15, cùng với iPhone 13 và iPhone 13 Pro. Thế hệ thứ 3 có kích thước và yếu tố hình thức của thế hệ trước, trong khi các thành phần phần cứng bên trong được lựa chọn từ dòng iPhone 13, bao gồm cả hệ thống trên chip A15 Bionic.\r\n\r\n>>> Tham khảo thêm:  \r\n\r\nMua iPhone giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại  luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu iPhone mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.', 40000000, 15, 'products/1748536440_vobook_14_oled_x1405v_m1405y_cool_silver_black_keyboard_13_fingerprint_6701c548b729416d90498bdac33dec13_medium.png', '2025-05-20 07:17:47', '2025-05-29 16:34:00'),
(18, 1, 1, 'iPhone 14 Pro', 'Lịch sử hình thành, phát triển của iPhone\r\niPhone là dòng điện thoại thông minh được phát triển từ Apple Inc, được ra mắt lần đầu tiên bởi Steve Jobs và mở bán năm 2007. Bên cạnh tính năng của một máy điện thoại thông thường, iPhone còn được trang bị màn hình cảm ứng, camera, khả năng chơi nhạc và chiếu phim, trình duyệt web... Phiên bản thứ hai là iPhone 3G ra mắt tháng 7 năm 2008, được trang bị thêm hệ thống định vị toàn cầu, mạng 3G tốc độ cao. Trải qua 15 năm tính đến nay đã có đến 34 mẫu iPhone được sản xuất từ dòng 2G cho đến iPhone 13 Pro Max và Apple là một trong những thương hiệu điện thoại được yêu thích và sử dụng phổ biến nhất trên thế giới.\r\n\r\niPhone có những mã máy nào?\r\nNhững chiếc iPhone do Apple phân phối tại thị trường nước nào thì sẽ mang mã của nước đó. Ví dụ: LL: Mỹ, ZA: Singapore, TH: Thái Lan, JA: Nhật Bản, Những mã này xuất hiện tại Việt Nam đều là hàng xách tay, nhập khẩu. Còn tại Việt Nam, iPhone sẽ được mang mã VN/A. Tất cả các mã này đều là hàng chính hãng phân phối của Apple. Lợi thế khi bạn sử dụng iPhone mã VN/A đó là chế độ bảo hành tốt hơn với 12 tháng theo tiêu chuẩn của Apple. iPhone của bạn sẽ được bảo hành tại tất cả các trung tâm bảo hành Apple tại Việt Nam, một số mã quốc tế bị từ chối bảo hành và phải đem ra các trung tâm bảo hành Apple tại nước ngoài. Rất là phức tạp đúng không nào?\r\n\r\nApple đã khai tử những dòng iPhone nào?\r\nTính đến nay, Apple đã khai tử (ngừng sản xuất) các dòng iPhone đời cũ bao gồm: iPhone 2G, iPhone 3G, iPhone 4, iPhone 5 series, iPhone 6 series, iPhone 7 series, iPhone 8 series, iPhone X series, iPhone SE (thế hệ 1), iPhone SE (thế hệ 2), iPhone 11 Pro, iPhone 11 Pro Max, iPhone 12 Pro, iPhone 12 Pro Max.\r\n\r\nShopDunk cung cấp những dòng iPhone nào?\r\nShopDunk là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng...\r\n\r\nNhững chiếc iPhone do Apple Việt Nam phân phối tại nước ta đều mang mã VN/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các dòng iPhone được cung cấp tại ShopDunk gồm:\r\n\r\niPhone 11 được trang bị màn hình LCD và không hỗ trợ HDR, nâng cấp với chế độ chụp đêm Night Mode cùng Deep Fusion. Camera trước được nâng độ phân giải từ 7MP lên thành 12MP. Được trang bị chip A13 Bionic và hỗ trợ công nghệ WiFi 6. Với 6 màu sắc bắt mắt: Đen, Trắng, Xanh Mint, Đỏ, Vàng, Tím.\r\n\r\niPhone 12 mini, iPhone 12 là những chiếc iPhone đầu tiên của hãng hỗ trợ mạng di động 5G. Apple đã thay đổi thiết kế của iPhone từ khung viền bo tròn thành khung viền vuông vức như những dòng iPhone 5 và sử dụng mặt kính trước Ceramic Shield. Ngoài ra, hộp của thiết bị iPhone 12 và các dòng iPhone sau đều đã được loại bỏ củ sạc.\r\n\r\nTháng 9 năm 2021, Apple đã chính thức ra mắt 4 chiếc iPhone mới của hãng bao gồm iPhone 13 mini, iPhone 13, iPhone 13 Pro, iPhone 13 Pro Max. Các cụm Camera trên bộ 4 iPhone mới của Apple đều to hơn một chút so với thế hệ tiền nhiệm và phần tai thỏ ở mặt trước cũng được làm nhỏ hơn. Đối với iPhone 13 Pro và iPhone 13 Pro Max, Apple đã nâng cấp bộ nhớ tối đa của máy lên đến 1TB. Đi cùng với đó là tần số quét của dòng iPhone 13 cũng đã được nâng cấp lên 120Hz.\r\n\r\niPhone SE thế hệ 3 (còn gọi là iPhone SE 3 hay iPhone SE 2022) được Apple công bố vào tháng 3 năm 2022, kế nhiệm iPhone SE 2. Đây là một phần của iPhone thế hệ thứ 15, cùng với iPhone 13 và iPhone 13 Pro. Thế hệ thứ 3 có kích thước và yếu tố hình thức của thế hệ trước, trong khi các thành phần phần cứng bên trong được lựa chọn từ dòng iPhone 13, bao gồm cả hệ thống trên chip A15 Bionic.\r\n\r\n>>> Tham khảo thêm:  \r\n\r\nMua iPhone giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại  luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu iPhone mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.', 9000000, 32, 'products/1748536353_0012169_black.png', '2025-05-23 08:56:31', '2025-05-29 17:46:03'),
(19, 2, 7, 'asus pro 2', 'iPad là gì ?\r\n là máy tính bảng do Apple Inc. phát triển. Được công bố vào ngày 27 tháng 1 năm 2010, thiết bị này tạo ra một phân loại mới giữa điện thoại thông minh và máy tính xách tay.\r\n\r\nTương tự về tính năng so với thiết bị nhỏ và yếu hơn là iPhone hoặc iPod touch, iPad cũng hoạt động trên cùng hệ điều hành iPhone OS đã được sửa đổi với giao diện được thiết kế lại để phù hợp với màn hình lớn.\r\n\r\nTại sao nên mua iPad ?\r\niPad được trang bị các tính năng tiện ích để phục vụ công việc, nhu cầu giải trí hiệu quả. Trên thực tế vai trò của iPad trong học tập hay làm việc cũng không hề nhỏ nhờ các tính năng:\r\n\r\nThiết kế hiện đại và sang chảnh, nhiều màu sắc đa dạng: Xám, Bạc, Vàng Hồng, Xanh Green, Xanh Blue, Tím,..\r\nGọn nhẹ chỉ khoảng 300g. Bạn có thể mang theo mọi nơi một cách thuận tiện.\r\nMàn hình sắc nét, rộng, với cảm ứng đa điểm, góc nhìn thoáng giúp cho việc xem phim, đọc báo hay chơi game dễ dàng và thú vị hơn.\r\nKết nối mạng 4G, 5G mọi lúc mọi nơi, phục vụ nhu cầu sử dụng một cách nhanh nhất.\r\nThời lượng pin lên đến 10 tiếng thoải mái sử dụng cả ngày, mang đến trải nghiệm trọn vẹn nhất.\r\nHơn một triệu ứng dụng được thiết kế riêng cho iPad để làm việc hiệu quả, trò chơi, du lịch, hình ảnh, AR, học tập, v.v.\r\nShopDunk cung cấp những dòng iPad nào ?\r\n là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng,…\r\n\r\nNhững chiếc máy tính Mac do Apple Việt Nam phân phối tại nước ta đều mang mã ZA/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các sản phẩm có tem của công ty TNHH Apple Việt Nam đều là hàng chính hãng. Mã ZA/A là vì iPad hiện chưa có mã riêng VN/A, trước đây iPad còn có mã THA.\r\n\r\nCác dòng máy tính Mac được cung cấp tại ShopDunk gồm: , , iPad gen 9, iPad Air 4, iPad Air 5, iPad mini 6, iPad Pro M1, iPad Air M2, iPad Air M3, iPad Pro M4\r\n\r\niPad gen 9: iPad sở hữu màn hình Retina 10,2 inch tuyệt đẹp có True Tone, chip A13 Bionic mạnh mẽ với Neural Engine, camera trước 12MP Ultra Wide có tính năng Trung tâm màn hình, cùng với tất cả các khả năng của iPadOS 15. \r\nThiết bị hỗ trợ Apple Pencil (thế hệ đầu tiên) và Smart Keyboard, đồng thời cung cấp kết nối Wi-Fi nhanh và LTE Gigabit. iPad giá cả phải chăng nhất rất phù hợp cho những người sở hữu iPad lần đầu tiên, những khách hàng quan tâm đến việc nâng cấp cũng như sinh viên và giáo viên muốn trải nghiệm sự linh hoạt của iPad.\r\n iPad Air 4: iPad Air 4 là thiết bị gần giống với thiết kế của iPad Pro 11 inch (thế hệ 3) và có một số tính năng trước đây chỉ dành riêng cho dòng iPad Pro, chẳng hạn như hỗ trợ Bàn phím ảo. Tương thích với Apple Pencil thế hệ 2. Có sẵn 5 màu: Xám không gian, Bạc, Vàng hồng, Xanh lục và Xanh da trời.\r\niPad Air 5: iPad Air 5 trang bị chip M1 đột phá của Apple, mang đến hiệu suất ở một đẳng cấp mới gói gọn trong thiết kế mỏng nhẹ, toàn màn hình. Máy có màn hình Liquid Retina 10,9 inch sống động và có sẵn với 5 màu sản phẩm. Camera trước Ultra Wide với tính năng Trung tâm màn hình giúp giữ bạn luôn trong khung hình để tương tác trong những cuộc gọi video tốt hơn, và camera sau Wide giúp ghi lại những bức ảnh và video tuyệt đẹp.\r\nLuôn giữ kết nối với 5G tốc độ cực cao và Wi-Fi 6, tăng khả năng linh hoạt của iPad Air bằng Apple Pencil (thế hệ thứ 2) và Magic Keyboard. Và với Touch ID trên nút nguồn, cổng USB-C nhanh hơn, iPadOS 15 và hơn một triệu ứng dụng trên App Store, iPad Air mang đến sự linh hoạt và những tính năng tiên tiến. Máy hoàn hảo cho những ai muốn nâng cấp lên một chiếc iPad mạnh mẽ hơn, đa năng hơn.\r\niPad mini 6: iPad mini thế hệ 6 mang đến bản cập nhật lớn nhất từ trước đến nay cho iPad mini. Thiết bị có thiết kế viền mỏng với bốn màu tuyệt đẹp và màn hình Liquid Retina 8.3 inch lớn hơn, đẹp hơn với cùng một kích thước nhỏ gọn mà khách hàng yêu thích. Chip A15 Bionic cung cấp tốc độ xử lý cực nhanh.\r\nTận hưởng camera trước Ultra Wide với tính năng Trung tâm màn hình cho các cuộc gọi video thú vị và camera sau Wide cho những bức ảnh và video đẹp mắt. iPad mini cũng có USB-C, Touch ID ở nút trên cùng, Wi-Fi 6 cực nhanh và iPadOS 15. Và với Apple Pencil (thế hệ 2), iPad mini thậm chí còn trở nên đa năng hơn. Đơn giản là không có gì giống như iPad mini.\r\n iPad Pro M1: iPad Pro mang đến trải nghiệm iPad đỉnh cao. Chip M1 đột phá cung cấp hiệu suất ở tầm cao mới. Màn hình Liquid Retina XDR trên iPad Pro (12,9 inch) cung cấp Độ lệch tương phản cực cao cho trải nghiệm hình ảnh tuyệt vời hơn nữa. Và kiểu máy 11 inch có màn hình Liquid Retina trang bị các công nghệ tiên tiến.\r\nCác kiểu máy có mạng di động hiện có thể tận dụng kết nối 5G siêu nhanh. Camera TrueDepth có camera Ultra Wide 12MP với Trung tâm màn hình, giúp bạn giữ khung hình hoàn hảo trong các cuộc gọi video. Magic Keyboard kết hợp trải nghiệm đánh máy thoải mái với bàn di chuột. Và Apple Pencil (thế hệ 2) mang lại sự chính xác bất kể bạn viết vẽ hay thiết kế. iPad Pro vượt qua giới hạn những việc bạn có thể làm trên iPad.\r\n với chip xử lý M2 mới nhất có sức mạnh vô địch: hiệu suất GPU tăng 35%, hiệu suất CPU tăng 18% so với M1.\r\niPad 11 (A16): dòng iPad mới nhất của Apple được ra mắt trong Tháng 4/2025. iPad A16 với 11 inches màn hình hiển thị chất lượng cao, sử dụng chip A16 siêu mạnh mẽ và dung lượng lưu trữ khởi điểm từ 128GB. iPad hỗ trợ hoàn thành công việc và giải trí mọi nơi, chạy mượt mà mọi tác vụ. \r\nLà đại lý ủy quyền của Apple, ShopDunk luôn cập nhập những dòng sản phẩm mới nhất với giá tốt nhất từ nhà Táo. Đã có những dòng như iPad 2 khai tử, iPad 3 ngừng sản xuất,.... nhưng hiện tại thì các sản phẩm Ipad đang có vẫn rất đa dạng. Bạn cần biết cách  từ 2010 đến nay để tìm mua cho mình sản phẩm phù hợp nhất.\r\n\r\nMua iPad giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại ShopDunk luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu  mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.\r\n\r\n ', 26000000, 50, 'products/1748536289_ava_450b62dbedc44663a3d7bf2bf0c735b3_medium.png', '2025-05-25 08:28:35', '2025-05-29 16:31:29'),
(20, 9, 9, 'PC chơi game hơi dổm', 'Lịch sử hình thành, phát triển của iPhone\r\niPhone là dòng điện thoại thông minh được phát triển từ Apple Inc, được ra mắt lần đầu tiên bởi Steve Jobs và mở bán năm 2007. Bên cạnh tính năng của một máy điện thoại thông thường, iPhone còn được trang bị màn hình cảm ứng, camera, khả năng chơi nhạc và chiếu phim, trình duyệt web... Phiên bản thứ hai là iPhone 3G ra mắt tháng 7 năm 2008, được trang bị thêm hệ thống định vị toàn cầu, mạng 3G tốc độ cao. Trải qua 15 năm tính đến nay đã có đến 34 mẫu iPhone được sản xuất từ dòng 2G cho đến iPhone 13 Pro Max và Apple là một trong những thương hiệu điện thoại được yêu thích và sử dụng phổ biến nhất trên thế giới.\r\n\r\niPhone có những mã máy nào?\r\nNhững chiếc iPhone do Apple phân phối tại thị trường nước nào thì sẽ mang mã của nước đó. Ví dụ: LL: Mỹ, ZA: Singapore, TH: Thái Lan, JA: Nhật Bản, Những mã này xuất hiện tại Việt Nam đều là hàng xách tay, nhập khẩu. Còn tại Việt Nam, iPhone sẽ được mang mã VN/A. Tất cả các mã này đều là hàng chính hãng phân phối của Apple. Lợi thế khi bạn sử dụng iPhone mã VN/A đó là chế độ bảo hành tốt hơn với 12 tháng theo tiêu chuẩn của Apple. iPhone của bạn sẽ được bảo hành tại tất cả các trung tâm bảo hành Apple tại Việt Nam, một số mã quốc tế bị từ chối bảo hành và phải đem ra các trung tâm bảo hành Apple tại nước ngoài. Rất là phức tạp đúng không nào?\r\n\r\nApple đã khai tử những dòng iPhone nào?\r\nTính đến nay, Apple đã khai tử (ngừng sản xuất) các dòng iPhone đời cũ bao gồm: iPhone 2G, iPhone 3G, iPhone 4, iPhone 5 series, iPhone 6 series, iPhone 7 series, iPhone 8 series, iPhone X series, iPhone SE (thế hệ 1), iPhone SE (thế hệ 2), iPhone 11 Pro, iPhone 11 Pro Max, iPhone 12 Pro, iPhone 12 Pro Max.\r\n\r\nShopDunk cung cấp những dòng iPhone nào?\r\nShopDunk là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng...\r\n\r\nNhững chiếc iPhone do Apple Việt Nam phân phối tại nước ta đều mang mã VN/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các dòng iPhone được cung cấp tại ShopDunk gồm:\r\n\r\niPhone 11 được trang bị màn hình LCD và không hỗ trợ HDR, nâng cấp với chế độ chụp đêm Night Mode cùng Deep Fusion. Camera trước được nâng độ phân giải từ 7MP lên thành 12MP. Được trang bị chip A13 Bionic và hỗ trợ công nghệ WiFi 6. Với 6 màu sắc bắt mắt: Đen, Trắng, Xanh Mint, Đỏ, Vàng, Tím.\r\n\r\niPhone 12 mini, iPhone 12 là những chiếc iPhone đầu tiên của hãng hỗ trợ mạng di động 5G. Apple đã thay đổi thiết kế của iPhone từ khung viền bo tròn thành khung viền vuông vức như những dòng iPhone 5 và sử dụng mặt kính trước Ceramic Shield. Ngoài ra, hộp của thiết bị iPhone 12 và các dòng iPhone sau đều đã được loại bỏ củ sạc.\r\n\r\nTháng 9 năm 2021, Apple đã chính thức ra mắt 4 chiếc iPhone mới của hãng bao gồm iPhone 13 mini, iPhone 13, iPhone 13 Pro, iPhone 13 Pro Max. Các cụm Camera trên bộ 4 iPhone mới của Apple đều to hơn một chút so với thế hệ tiền nhiệm và phần tai thỏ ở mặt trước cũng được làm nhỏ hơn. Đối với iPhone 13 Pro và iPhone 13 Pro Max, Apple đã nâng cấp bộ nhớ tối đa của máy lên đến 1TB. Đi cùng với đó là tần số quét của dòng iPhone 13 cũng đã được nâng cấp lên 120Hz.\r\n\r\niPhone SE thế hệ 3 (còn gọi là iPhone SE 3 hay iPhone SE 2022) được Apple công bố vào tháng 3 năm 2022, kế nhiệm iPhone SE 2. Đây là một phần của iPhone thế hệ thứ 15, cùng với iPhone 13 và iPhone 13 Pro. Thế hệ thứ 3 có kích thước và yếu tố hình thức của thế hệ trước, trong khi các thành phần phần cứng bên trong được lựa chọn từ dòng iPhone 13, bao gồm cả hệ thống trên chip A15 Bionic.\r\n\r\n>>> Tham khảo thêm:  \r\n\r\nMua iPhone giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại  luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu iPhone mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.', 23000000, 30, 'products/1748536638_vn-odyssey-g5-g55c-ls27cg552eexxv-538902440_78a9c69df6074de698740d3fa28e55a5_grande.png', '2025-05-29 02:35:40', '2025-05-29 17:46:03');
INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(21, 5, 4, 'Đồng hồ PRO', 'Lịch sử hình thành, phát triển của iPhone\r\niPhone là dòng điện thoại thông minh được phát triển từ Apple Inc, được ra mắt lần đầu tiên bởi Steve Jobs và mở bán năm 2007. Bên cạnh tính năng của một máy điện thoại thông thường, iPhone còn được trang bị màn hình cảm ứng, camera, khả năng chơi nhạc và chiếu phim, trình duyệt web... Phiên bản thứ hai là iPhone 3G ra mắt tháng 7 năm 2008, được trang bị thêm hệ thống định vị toàn cầu, mạng 3G tốc độ cao. Trải qua 15 năm tính đến nay đã có đến 34 mẫu iPhone được sản xuất từ dòng 2G cho đến iPhone 13 Pro Max và Apple là một trong những thương hiệu điện thoại được yêu thích và sử dụng phổ biến nhất trên thế giới.\r\n\r\niPhone có những mã máy nào?\r\nNhững chiếc iPhone do Apple phân phối tại thị trường nước nào thì sẽ mang mã của nước đó. Ví dụ: LL: Mỹ, ZA: Singapore, TH: Thái Lan, JA: Nhật Bản, Những mã này xuất hiện tại Việt Nam đều là hàng xách tay, nhập khẩu. Còn tại Việt Nam, iPhone sẽ được mang mã VN/A. Tất cả các mã này đều là hàng chính hãng phân phối của Apple. Lợi thế khi bạn sử dụng iPhone mã VN/A đó là chế độ bảo hành tốt hơn với 12 tháng theo tiêu chuẩn của Apple. iPhone của bạn sẽ được bảo hành tại tất cả các trung tâm bảo hành Apple tại Việt Nam, một số mã quốc tế bị từ chối bảo hành và phải đem ra các trung tâm bảo hành Apple tại nước ngoài. Rất là phức tạp đúng không nào?\r\n\r\nApple đã khai tử những dòng iPhone nào?\r\nTính đến nay, Apple đã khai tử (ngừng sản xuất) các dòng iPhone đời cũ bao gồm: iPhone 2G, iPhone 3G, iPhone 4, iPhone 5 series, iPhone 6 series, iPhone 7 series, iPhone 8 series, iPhone X series, iPhone SE (thế hệ 1), iPhone SE (thế hệ 2), iPhone 11 Pro, iPhone 11 Pro Max, iPhone 12 Pro, iPhone 12 Pro Max.\r\n\r\nShopDunk cung cấp những dòng iPhone nào?\r\nShopDunk là một trong những thương hiệu bán lẻ được Apple uỷ quyền tại Việt Nam, đáp ứng được các yêu cầu khắt khe từ Apple như: dịch vụ kinh doanh, dịch vụ chăm sóc khách hàng, vị trí đặt cửa hàng...\r\n\r\nNhững chiếc iPhone do Apple Việt Nam phân phối tại nước ta đều mang mã VN/A và được bảo hành 12 tháng theo theo tiêu chuẩn tại các trung tâm bảo hành Apple. Các dòng iPhone được cung cấp tại ShopDunk gồm:\r\n\r\niPhone 11 được trang bị màn hình LCD và không hỗ trợ HDR, nâng cấp với chế độ chụp đêm Night Mode cùng Deep Fusion. Camera trước được nâng độ phân giải từ 7MP lên thành 12MP. Được trang bị chip A13 Bionic và hỗ trợ công nghệ WiFi 6. Với 6 màu sắc bắt mắt: Đen, Trắng, Xanh Mint, Đỏ, Vàng, Tím.\r\n\r\niPhone 12 mini, iPhone 12 là những chiếc iPhone đầu tiên của hãng hỗ trợ mạng di động 5G. Apple đã thay đổi thiết kế của iPhone từ khung viền bo tròn thành khung viền vuông vức như những dòng iPhone 5 và sử dụng mặt kính trước Ceramic Shield. Ngoài ra, hộp của thiết bị iPhone 12 và các dòng iPhone sau đều đã được loại bỏ củ sạc.\r\n\r\nTháng 9 năm 2021, Apple đã chính thức ra mắt 4 chiếc iPhone mới của hãng bao gồm iPhone 13 mini, iPhone 13, iPhone 13 Pro, iPhone 13 Pro Max. Các cụm Camera trên bộ 4 iPhone mới của Apple đều to hơn một chút so với thế hệ tiền nhiệm và phần tai thỏ ở mặt trước cũng được làm nhỏ hơn. Đối với iPhone 13 Pro và iPhone 13 Pro Max, Apple đã nâng cấp bộ nhớ tối đa của máy lên đến 1TB. Đi cùng với đó là tần số quét của dòng iPhone 13 cũng đã được nâng cấp lên 120Hz.\r\n\r\niPhone SE thế hệ 3 (còn gọi là iPhone SE 3 hay iPhone SE 2022) được Apple công bố vào tháng 3 năm 2022, kế nhiệm iPhone SE 2. Đây là một phần của iPhone thế hệ thứ 15, cùng với iPhone 13 và iPhone 13 Pro. Thế hệ thứ 3 có kích thước và yếu tố hình thức của thế hệ trước, trong khi các thành phần phần cứng bên trong được lựa chọn từ dòng iPhone 13, bao gồm cả hệ thống trên chip A15 Bionic.\r\n\r\n>>> Tham khảo thêm:  \r\n\r\nMua iPhone giá tốt nhất tại ShopDunk\r\nShopDunk là đại lý uỷ quyền Apple tại Việt Nam với hệ thống 40 cửa hàng trên toàn quốc, trong đó có 11 Mono Store. Đến nay, ShopDunk đã trở thành điểm dừng chân lý tưởng cho iFans nói chung và thế hệ GenZ nói riêng bởi độ chuẩn và chất. Không gian thiết kế và bài trí sản phẩm theo tiêu chuẩn của Apple, chia theo từng khu vực rõ ràng, bàn trải nghiệm rộng rãi và đầy đủ sản phẩm.\r\n\r\nTại  luôn có mức giá tốt nhất cho người dùng cùng với nhiều chương trình hấp dẫn diễn ra liên tục trong tháng. Hãy đến với chúng tôi và trải nghiệm ngay những mẫu iPhone mới nhất với đội ngũ chuyên viên tư vấn được đào tạo bài bản từ Apple, sẵn sàng hỗ trợ bạn về sản phẩm, kỹ thuật hay các công nghệ mới nhất từ Apple.', 30000000, 30, 'products/1748540915_huawei-watch-fit-4-pro-nylon-tb-600x600.png', '2025-05-29 17:48:35', '2025-05-29 17:48:35');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(100) NOT NULL,
  `attribute_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product_attributes`
--

INSERT INTO `product_attributes` (`id`, `product_id`, `attribute_name`, `attribute_value`) VALUES
(55, 1, 'RAM', '7GB'),
(56, 1, 'ROM', '128GB'),
(59, 2, 'CPU', 'Intel Core i7'),
(60, 2, 'Dung luong', '512GB'),
(61, 3, 'RAM', '8GB'),
(62, 3, 'Dung luong', '256GB'),
(63, 4, 'CPU', 'Intel Core i5'),
(64, 4, 'Dung luong', '1TB'),
(65, 5, 'Man hinh', '10.9 inch'),
(66, 5, 'ROM', '4GB'),
(67, 19, 'CPU', 'Intel Core i7'),
(69, 18, 'ram', '32GB'),
(70, 9, 'Man hinh', '10.9 inch'),
(71, 8, 'RAM', '7GB'),
(72, 20, 'Man hinh', '10.9 inch'),
(73, 7, 'CPU', '8GB'),
(74, 6, 'CPU', 'Intel Core i5'),
(75, 21, 'Màu', 'Xanh lá');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `promotions`
--

CREATE TABLE `promotions` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `discount_type` enum('percentage','fixed') NOT NULL,
  `discount_value` float NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `min_order_amount` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ;

--
-- Đang đổ dữ liệu cho bảng `promotions`
--

INSERT INTO `promotions` (`id`, `code`, `discount_type`, `discount_value`, `start_date`, `end_date`, `min_order_amount`, `created_at`) VALUES
(1, 'SALE2024', 'percentage', 50, '2025-05-20', '2025-05-22', 500, '2025-05-20 07:17:47'),
(2, 'BLACKFRIDAY', 'fixed', 50, '2025-11-01', '2025-11-30', 300, '2025-05-20 07:17:47'),
(3, 'SUMMER2025', 'percentage', 15, '2025-06-01', '2025-08-31', 400, '2025-05-20 07:17:47'),
(4, 'WELCOME10', 'percentage', 10, '2025-01-01', '2025-12-31', 200, '2025-05-20 07:17:47'),
(5, 'VIP20', 'percentage', 20, '2025-01-01', '2025-12-31', 1000, '2025-05-20 07:17:47'),
(6, 'FLASH50', 'fixed', 50, '2025-05-01', '2025-05-07', 250, '2025-05-20 07:17:47'),
(7, 'BACKTOSCHOOL', 'percentage', 12, '2025-08-01', '2025-09-30', 300, '2025-05-20 07:17:47'),
(8, 'NEWUSER30', 'fixed', 30, '2025-01-01', '2025-12-31', 150, '2025-05-20 07:17:47'),
(9, 'HOLIDAY15', 'percentage', 15, '2025-12-01', '2025-12-31', 500, '2025-05-20 07:17:47'),
(11, 'SALE2027', 'fixed', 500000, '2025-05-20', '2025-05-31', 2000000, '2025-05-20 08:47:40'),
(15, 'SALE2029', 'percentage', 10, '2025-05-29', '2025-05-31', 500000, '2025-05-29 17:45:48');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `recently_viewed`
--

CREATE TABLE `recently_viewed` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `recently_viewed`
--

INSERT INTO `recently_viewed` (`id`, `user_id`, `product_id`, `viewed_at`) VALUES
(1, 1, 1, '2025-05-01 03:00:00'),
(2, 2, 2, '2025-05-02 04:00:00'),
(3, 3, 3, '2025-05-03 05:00:00'),
(4, 4, 4, '2025-05-04 06:00:00'),
(5, 5, 5, '2025-05-05 07:00:00'),
(6, 6, 6, '2025-05-06 08:00:00'),
(7, 7, 7, '2025-05-07 09:00:00'),
(8, 8, 8, '2025-05-08 10:00:00'),
(9, 9, 9, '2025-05-09 11:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `revenue`
--

CREATE TABLE `revenue` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `revenue_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `revenue`
--

INSERT INTO `revenue` (`id`, `order_id`, `total_amount`, `revenue_date`, `created_at`) VALUES
(12, 1, 2599.97, '2025-01-01', '2025-05-24 15:12:25'),
(21, 6, 25555600, '2025-01-06', '2025-05-24 17:00:48'),
(24, 15, 17000000, '2025-05-24', '2025-05-24 17:14:54'),
(25, 13, 32999000, '2025-05-23', '2025-05-24 17:14:58'),
(26, 12, 24000000, '2025-05-22', '2025-05-24 17:15:03'),
(29, 19, 9000000, '2025-05-29', '2025-05-29 09:44:46'),
(30, 20, 258000000, '2025-05-29', '2025-05-29 14:37:43');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` enum('customer','admin') DEFAULT 'customer',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'customer1@example.com', '$2y$10$Jmp25OI1uyYmZE3EMhuWUuFa70/RhMIqofW3Yz9sdG/LSgjsbdop2', 'Nguyen Van A', '0123456789', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:21:27'),
(2, 'admin@example.com', '$2y$10$VKqk4CnBZScz1lL8OhcbG.9Xyv1aVbI4V7Piy74ntzxkGKaDeQdHO', 'Admin User', '0987654321', 'admin', '2025-05-20 07:17:47', '2025-05-29 03:25:52'),
(3, 'customer2@example.com', '$2y$10$9Qsp5bRbkvmsuIb7bGwW/.cQzEl5dOeUWITYtH4v4TzoLEs2yTxCq', 'Tran Thi B', '0123456790', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:22:55'),
(4, 'customer3@example.com', '$2y$10$ixwTiLkzWBqksFz8SK5tAOwUEOPI27epLjCkT2.Ppp0oeq8FVDHb2', 'Le Van C', '0123456791', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:23:07'),
(5, 'customer4@example.com', '$2y$10$qvd/c/tPaHDQKf5ppvq8lOSEkEfGSNqimn41OiJzqLPdbmyqxMa92', 'Pham Thi D', '0123456792', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:23:17'),
(6, 'customer5@example.com', '$2y$10$L1WC0td0ko/GNLF8YjuIlec4FkDg0TH2jSrVWxbJY55THdaPAzAvu', 'Hoang Van E', '0123456793', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:46'),
(7, 'customer6@example.com', '$2y$10$m/X67YNftdV2R4LG57MJRecEELt5s1UqnpCatRvX3eV.rGNgfNT4W', 'Nguyen Thi F', '0123456794', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:22'),
(8, 'customer7@example.com', '$2y$10$Uz6DSBjqX15FtNAINSHbee6TcV542nNKMBfI4FkP5o1kcZq3j3t.i', 'Tran Van G', '0123456795', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:14'),
(9, 'customer8@example.com', '$2y$10$J9VRrlkSZ2Rr2gq7BxyskuyJ1mw6ZW36155O1OBYGYLtDdA2.Ex7S', 'Le Thi H', '0123456796', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:06'),
(10, 'customer9@example.com', '$2y$10$bZdvJofNRrJ9uUHIl3kBYODswvAbaZJ4i3cAenNc1OrfxyXZHCxL.', 'Pham Van I', '0123456797', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:23:54'),
(11, 'huydeptrai171105@gmail.com', '$2y$10$dbA2fWKsBxb.eF7yQo.wXeta09sOxnU7RfZCZ8.EnA5P0UUhCHj7m', 'Nguyễn Quốc Huy', '0916076557', 'admin', '2025-05-25 16:41:17', '2025-05-29 19:09:43'),
(12, 'huydeptrai@gmail.com', '$2y$10$KVG2SpvZ4OtDmscURF8Rv.X1m6hcuxFc456k0QxiwJxisvLoDJAxS', 'A B C', NULL, 'customer', '2025-05-29 15:39:21', '2025-05-29 15:39:21');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Chỉ mục cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `promotion_id` (`promotion_id`);

--
-- Chỉ mục cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Chỉ mục cho bảng `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Chỉ mục cho bảng `recently_viewed`
--
ALTER TABLE `recently_viewed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT cho bảng `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT cho bảng `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT cho bảng `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT cho bảng `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `recently_viewed`
--
ALTER TABLE `recently_viewed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT cho bảng `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Các ràng buộc cho bảng `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Các ràng buộc cho bảng `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `recently_viewed`
--
ALTER TABLE `recently_viewed`
  ADD CONSTRAINT `recently_viewed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recently_viewed_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `revenue`
--
ALTER TABLE `revenue`
  ADD CONSTRAINT `revenue_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
