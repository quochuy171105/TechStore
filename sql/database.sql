-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2025 at 10:29 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `doancuoikylaptrinhweb`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
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
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `user_id`, `address_line`, `city`, `postal_code`, `country`, `is_default`) VALUES
(1, 1, '123 Duong Lang', 'Ha Noi', '100000', 'Vietnam', 0),
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
(12, 11, 'Chung cư Intela huyện Bình Chánh', 'Hà Nội', '9999999', 'Vietnam', 0),
(13, 1, 'Chung cư SaiGon Intela, KDC 13E, huyện Bình Chánh', 'TP. Hồ Chí Minh', '99', 'Vietnam', 1);

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `logo` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
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
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `added_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `added_at`) VALUES
(2, 2, 2, 1, '2025-05-02 04:00:00'),
(3, 3, 3, 3, '2025-05-03 05:00:00'),
(4, 4, 4, 1, '2025-05-04 06:00:00'),
(5, 5, 5, 2, '2025-05-05 07:00:00'),
(6, 6, 6, 4, '2025-05-06 08:00:00'),
(7, 7, 7, 1, '2025-05-07 09:00:00'),
(8, 8, 8, 2, '2025-05-08 10:00:00'),
(9, 9, 9, 1, '2025-05-09 11:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Điện Thoại', 'Cac dong dien thoai thong minh'),
(2, 'Laptop', 'May tinh xach tay'),
(3, 'Máy Tính Bảng', 'Thiet bi di dong co lon'),
(4, 'Phụ Kiện', 'Tai nghe, sac, op lung'),
(5, 'Đồng Hồ Thông Minh', 'Thiet bi deo tay thong minh'),
(6, 'Loa Bluetooth', 'Thiet bi am thanh di dong'),
(7, 'Máy Ảnh', 'May anh ky thuat so'),
(8, 'Máy Chơi Game', 'Thiet bi choi game cam tay'),
(9, 'PC', 'May tinh de ban'),
(10, 'Màn Hình', 'Man hinh may tinh');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
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
-- Dumping data for table `feedback`
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
(13, 11, 18, 3, 'quá mệt', '2025-05-29 15:23:21'),
(14, 1, 20, 1, 'hơi dổm nha', '2025-12-05 01:32:37'),
(15, 1, 2, 1, 'QUÁ XẤU, NHƯ QUẦN QUÈ', '2025-12-07 11:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
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
-- Dumping data for table `orders`
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
(21, 11, 11, 40000000, NULL, '', 'shipped', '2025-05-29 16:44:28', '2025-05-29 17:46:03'),
(22, 1, 1, 97200000, NULL, '', 'pending', '2025-12-02 08:49:44', '2025-12-02 08:49:44'),
(23, 11, 11, 99000000, NULL, '', 'pending', '2025-12-02 09:13:47', '2025-12-02 09:13:47'),
(24, 11, 11, 18000000, NULL, '', 'pending', '2025-12-02 09:16:34', '2025-12-02 09:16:34'),
(25, 11, 11, 139000000, NULL, '', 'pending', '2025-12-02 09:18:43', '2025-12-02 09:18:43'),
(26, 1, 1, 127000000, NULL, '', 'delivered', '2025-12-05 01:31:11', '2025-12-07 17:20:06'),
(27, 1, 1, 43000000, NULL, '', 'pending', '2025-12-06 03:58:58', '2025-12-06 03:58:58'),
(28, 1, 13, 30000000, NULL, '', 'pending', '2025-12-07 07:58:18', '2025-12-07 07:58:18'),
(29, 1, 13, 30000000, NULL, '', 'pending', '2025-12-07 08:06:02', '2025-12-07 08:06:02'),
(30, 1, 13, 25500000, NULL, '', 'delivered', '2025-12-07 08:08:41', '2025-12-07 17:19:45'),
(31, 1, 13, 75000000, NULL, '', 'delivered', '2025-12-07 11:17:02', '2025-12-07 11:19:15'),
(32, 1, 13, 339000000, NULL, '', 'pending', '2025-12-08 09:28:42', '2025-12-08 09:28:42');

--
-- Triggers `orders`
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
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
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
(30, 21, 20, 1, 23000000),
(31, 22, 20, 1, 23000000),
(32, 22, 18, 1, 9000000),
(33, 22, 19, 1, 26000000),
(34, 22, 6, 1, 50000000),
(35, 23, 21, 1, 30000000),
(36, 23, 20, 3, 23000000),
(37, 24, 18, 2, 9000000),
(38, 25, 20, 1, 23000000),
(39, 25, 19, 1, 26000000),
(40, 25, 18, 10, 9000000),
(41, 26, 20, 1, 23000000),
(42, 26, 19, 4, 26000000),
(43, 27, 18, 2, 9000000),
(44, 27, 2, 1, 25000000),
(45, 28, 21, 1, 30000000),
(46, 29, 21, 1, 30000000),
(47, 30, 3, 1, 30000000),
(48, 31, 2, 1, 25000000),
(49, 31, 6, 1, 50000000),
(50, 32, 3, 1, 30000000),
(51, 32, 19, 2, 26000000),
(52, 32, 1, 2, 9000000),
(53, 32, 18, 24, 9000000),
(54, 32, 20, 1, 23000000);

-- --------------------------------------------------------

--
-- Table structure for table `products`
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
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'iPhone 14 Pro', 'iPhone 14 Pro là dòng smartphone cao cấp ra mắt năm 2022, nổi bật với chip A16 Bionic mạnh mẽ, màn hình Super Retina XDR 120Hz ProMotion cùng thiết kế Dynamic Island (thay thế notch), cụm camera chính 48MP lần đầu tiên cho ảnh sắc nét, và nhiều tính năng chuyên nghiệp như Always-On Display, chống nước IP68, khung thép không gỉ, có các màu Tím Đậm, Bạc, Vàng, Đen. \nCác điểm nổi bật chính:\nMàn hình: Super Retina XDR OLED 6.1 inch, tần số quét 120Hz ProMotion (tự điều chỉnh), độ sáng cao, hỗ trợ Always-On Display. \nThiết kế: Khung thép không gỉ, mặt lưng kính nhám, chống nước IP68, có màu Tím Đậm độc đáo, Bạc, Vàng, Đen. \nDynamic Island: Thay thế notch tai thỏ bằng một khu vực tương tác mới, hiển thị thông báo, hoạt động nền linh hoạt. \nHiệu năng: Chip Apple A16 Bionic mạnh mẽ, hiệu quả, RAM 6GB, cho trải nghiệm mượt mà mọi tác vụ. \nCamera:\nChính: 48MP (nâng cấp lớn), chụp ảnh ProRAW, Photonic Engine, Deep Fusion, quay video 4K. \nUltra Wide & Telephoto: 12MP. \nTrước (TrueDepth): 12MP với tự động lấy nét, khẩu độ f/1.9, cải thiện selfie và Face ID. \nPin & Sạc: Thời lượng pin cả ngày, hỗ trợ sạc nhanh. \nHệ điều hành: Chạy iOS (ban đầu iOS 16, có thể nâng cấp lên iOS 17+), mang đến nhiều tính năng bảo mật và phần mềm. \nTóm lại:\niPhone 14 Pro là bước nhảy vọt về camera và trải nghiệm tương tác (Dynamic Island), mang lại hiệu năng vượt trội và màn hình xuất sắc, là lựa chọn cao cấp cho những ai cần công nghệ đỉnh cao, nhiếp ảnh chuyên nghiệp và thiết kế hiện đại. ', 9000000, 404, 'products/1748535440_0006831_iphone-12-64gb_550.png', '2025-05-20 07:17:47', '2025-12-08 08:24:43'),
(2, 2, 2, 'MSI Modern 14 F13MG', 'MSI Modern 14 F13MG là dòng laptop văn phòng mỏng nhẹ, thanh lịch, hướng đến người dùng năng động, kết hợp thiết kế gọn gàng (khoảng 1.4-1.5kg, màu bạc sang trọng) với hiệu năng ổn định từ CPU Intel Core i5 thế hệ 13 (như i5-1335U), RAM 16GB, SSD PCIe Gen4 tốc độ cao, màn hình 14 inch FHD IPS sắc nét, bàn phím có đèn, bản lề 180 độ và các kết nối hiện đại, chạy Windows 11 bản quyền, lý tưởng cho học tập, làm việc và giải trí di động. \nĐiểm nổi bật:\nThiết kế: Mỏng nhẹ (khoảng 1.4-1.5kg), vỏ bạc thanh lịch, bản lề mở 180 độ tiện lợi, phù hợp di chuyển nhiều.\nHiệu năng: Bộ vi xử lý Intel Core i5 thế hệ 13 (ví dụ i5-1335U), RAM 16GB DDR4, SSD 512GB NVMe PCIe Gen4 cho đa nhiệm mượt mà và tốc độ nhanh.\nMàn hình: 14 inch Full HD (1920x1080), tấm nền IPS, tần số quét 60Hz, chống chói, hiển thị rõ nét.\nBàn phím & Âm thanh: Bàn phím Full-size có đèn LED trắng, webcam có màng che bảo mật và Micro kép lọc ồn.\nKết nối: Đầy đủ cổng USB-C (PD, DisplayPort), USB 3.2, HDMI, Wi-Fi 6E, Bluetooth 5.3.\nHệ điều hành: Windows 11 Home bản quyền. \nPhù hợp với:\nSinh viên, nhân viên văn phòng cần máy tính di động, đa năng.\nNgười dùng làm việc cơ bản (soạn thảo, duyệt web, họp online) và giải trí nhẹ. \nCấu hình phổ biến (có thể khác tùy phiên bản):\nCPU: Intel Core i5-1335U / i5-1334U (Gen 13th).\nRAM: 16GB DDR4 3200MHz (2x8GB), có thể nâng cấp.\nSSD: 512GB NVMe PCIe Gen4.\nVGA: Intel UHD Graphics / Intel Iris Xe Graphics.\nTrọng lượng: ~1.4 - 1.5 kg. \nTóm lại, đây là chiếc laptop cân bằng giữa hiệu năng, tính di động và thiết kế, đáng cân nhắc trong phân khúc laptop văn phòng tầm trung. ', 25000000, 30, 'products/1748536184_1024_5b3ad2cff4444235bdb9897806ebbc40_medium.png', '2025-05-20 07:17:47', '2025-12-08 08:29:28'),
(3, 1, 3, 'Xiaomi 13', 'Xiaomi 13 là một flagship cao cấp nổi bật với thiết kế vuông vức, màn hình AMOLED 120Hz rực rỡ, hiệu năng cực mạnh từ chip Snapdragon 8 Gen 2, hệ thống camera Leica chuyên nghiệp, pin bền bỉ và sạc siêu nhanh, mang đến trải nghiệm cao cấp với mức giá \"vừa túi tiền\" hơn so với bản Pro, tập trung vào sự nhỏ gọn, tiện lợi và hiệu năng mạnh mẽ. \nThiết kế & Màn hình:\nThiết kế: Cầm nắm thoải mái, vuông vức, sang trọng, dễ dán cường lực hơn bản Pro.\nMàn hình: OLED 6.36 inch, tần số quét 120Hz, bốn viền siêu mỏng, hiển thị sống động, rực rỡ. \nHiệu năng:\nChip: Snapdragon 8 Gen 2 mạnh mẽ.\nRAM/Bộ nhớ: Nhiều tùy chọn (8GB/12GB RAM, 128GB/256GB/512GB ROM), sử dụng bộ nhớ tốc độ cao UFS 4.0 (cho bản 256GB/512GB). \nCamera:\nHợp tác Leica: Camera chính (50MP), tele Leica (12MP), góc siêu rộng (10MP), cho ảnh chuyên nghiệp.\nCamera trước: 32MP. \nPin & Sạc:\nPin: 4500mAh, cho thời gian sử dụng dài (hơn 10 tiếng test).\nSạc: Sạc nhanh hỗ trợ công nghệ mới. \nĐiểm cộng lớn:\nHiệu năng mạnh mẽ hơn cả bản 13 Pro trong một số trường hợp.\nKích thước nhỏ gọn, dễ mang theo.\nCamera chất lượng cao, hợp tác Leica. \nTóm lại: Xiaomi 13 là lựa chọn flagship cân bằng, kết hợp giữa thiết kế cao cấp, hiệu năng đỉnh cao và hệ thống camera ấn tượng, phù hợp cho người dùng muốn một chiếc điện thoại mạnh mẽ nhưng gọn nhẹ. ', 30000000, 60, 'products/1748536211_0012169_black.png', '2025-05-20 07:17:47', '2025-12-08 08:29:49'),
(4, 2, 4, 'ASUS ExpertBook B1', 'ASUS ExpertBook B1 là dòng laptop doanh nhân/văn phòng giá rẻ, tập trung vào hiệu năng ổn định (chip Intel Core thế hệ mới), tính di động cao (mỏng nhẹ, pin khá), độ bền chuẩn quân đội MIL-STD 810H, bảo mật doanh nghiệp (TPM 2.0, cảm biến vân tay) và khả năng kết nối đa dạng (Wi-Fi 6E), lý tưởng cho các chuyên gia cần một máy làm việc linh hoạt, an toàn và đáng tin cậy. \nĐặc điểm nổi bật:\nHiệu năng: Trang bị chip Intel Core i5/i7 thế hệ 12/13 (ví dụ i7-1355U), RAM DDR4 và SSD NVMe PCIe 4.0, cho tốc độ xử lý nhanh các ứng dụng văn phòng và đa nhiệm.\nThiết kế: Nhẹ (khoảng 1.49kg), mỏng (khoảng 1.99cm), màu đen thanh lịch, dễ dàng di chuyển.\nMàn hình: 14 inch Full HD (1920x1080), tấm nền IPS chống chói, hiển thị rõ nét.\nBảo mật: Chip TPM 2.0, cảm biến vân tay (tùy model) đảm bảo an toàn dữ liệu.\nĐộ bền: Đạt chuẩn quân đội Mỹ MIL-STD 810H, chống va đập tốt hơn.\nKết nối: Hỗ trợ Wi-Fi 6E, Bluetooth 5.3, cổng kết nối đa dạng.\nPin: Pin 3 cell 42WHrs đủ dùng cho công việc hàng ngày. \nTóm lại: ExpertBook B1 là lựa chọn phù hợp cho doanh nghiệp và người dùng cá nhân cần một chiếc laptop hiệu năng khá, nhỏ gọn, nhiều tính năng bảo mật và độ bền cao trong phân khúc giá phải chăng.', 60000000, 20, 'products/1748536232_expertbook_b1_b1402_product_phot_c52b18232c29486283bb114a2faef66e_medium.png', '2025-05-20 07:17:47', '2025-12-08 08:30:08'),
(5, 3, 1, 'iPad Air 5', 'iPad Air 5 (2022) là máy tính bảng mạnh mẽ, thiết kế viền phẳng, màn hình Liquid Retina 10.9 inch, được trang bị chip Apple M1 siêu tốc độ, RAM 8GB, hỗ trợ Apple Pencil 2 & Magic Keyboard, camera trước Ultra Wide 12MP có Center Stage, kết nối 5G/Wi-Fi 6 và cổng USB-C, phù hợp cho sáng tạo, giải trí lẫn công việc, với các màu sắc trẻ trung như Tím, Hồng, Xanh Dương. \nThiết kế & Màn hình:\nThiết kế: Màn hình tràn viền, thiết kế phẳng cạnh, có các màu Xám Bạc, Ánh Sao, Hồng, Tím, Xanh Dương.\nMàn hình: 10.9 inch Liquid Retina (IPS LCD), độ phân giải 2360x1640, True Tone, dải màu rộng P3, chống phản chiếu. \nHiệu năng & Lưu trữ:\nChip: Apple M1 mạnh mẽ, nhanh hơn đáng kể so với thế hệ trước.\nRAM: 8GB RAM, hỗ trợ đa nhiệm mượt mà.\nLưu trữ: Tùy chọn 64GB or 256GB. \nCamera:\nCamera sau: 12MP Wide.\nCamera trước: 12MP Ultra Wide (Góc Siêu Rộng) với tính năng Center Stage (Tự động giữ khuôn hình). \nKết nối & Tính năng khác:\nKết nối: Wi-Fi 6, tùy chọn 5G, cổng USB-C (USB 3.1 Gen 2) tốc độ cao.\nÂm thanh: Loa Stereo ở cạnh trên/dưới, hỗ trợ Dolby Atmos.\nBảo mật: Touch ID tích hợp ở nút nguồn.\nPhụ kiện: Tương thích Apple Pencil thế hệ 2 (sạc nam châm) và Magic Keyboard. \nPin & Hệ điều hành:\nPin: Sử dụng cả ngày (lên đến 10 giờ).\nHệ điều hành: iPadOS (khởi chạy với iPadOS 15). \niPad Air 5 là lựa chọn cân bằng giữa hiệu năng cao (nhờ chip M1) và giá cả hợp lý, nâng tầm trải nghiệm từ học tập, sáng tạo đến giải trí. ', 70000000, 44, 'products/1748536259_0006309_space-gray_550.png', '2025-05-20 07:17:47', '2025-12-08 08:30:31'),
(6, 4, 5, 'PC Gaming', 'PC Gaming (Máy tính chơi game) là dòng máy tính cá nhân được tối ưu hóa với cấu hình mạnh mẽ (CPU, GPU, RAM, SSD), tản nhiệt, nguồn chất lượng và thiết bị ngoại vi chuyên dụng, nhằm mang lại trải nghiệm chơi game mượt mà, đồ họa đẹp, tốc độ khung hình cao (FPS), độ phản hồi thấp, và có tính linh hoạt cao trong việc nâng cấp, tùy biến so với PC văn phòng thông thường, thường có thiết kế hầm hộ với đèn LED bắt mắt. \nCác thành phần cốt lõi\nCPU (Bộ xử lý): Thường là các dòng Intel Core i5/i7 hoặc AMD Ryzen 5/7 trở lên, có nhiều nhân/luồng để xử lý game và đa nhiệm hiệu quả.\nGPU (Card đồ họa): Linh kiện quan trọng nhất, quyết định chất lượng hình ảnh; thường là card rời mạnh như NVIDIA GeForce RTX series hoặc AMD Radeon.\nRAM: Tối thiểu 16GB (tốt nhất 32GB) DDR4/DDR5 để đảm bảo đa nhiệm mượt mà.\nỔ cứng: SSD NVMe tốc độ cao (tối thiểu 500GB) giúp giảm thời gian tải game và khởi động hệ thống.\nTản nhiệt: Hệ thống tản nhiệt tốt (khí hoặc AIO) để giữ nhiệt độ ổn định, đảm bảo hiệu năng khi chơi game lâu.\nNguồn (PSU): Bộ nguồn chất lượng, công suất đủ lớn để cung cấp điện ổn định cho toàn hệ thống.\nMàn hình: Tần số quét cao (144Hz, 240Hz, ...) và thời gian phản hồi thấp (1ms) để hình ảnh mượt mà, không giật lag.\nThiết bị ngoại vi: Bàn phím, chuột gaming chuyên dụng, tai nghe, thảm lót chuột với độ nhạy cao, thiết kế công thái học. \nĐặc điểm nổi bật\nHiệu năng cao: Xử lý mượt các tựa game nặng, đồ họa cao (Full HD, 2K, 4K).\nKhả năng tùy biến và nâng cấp: Dễ dàng thay thế linh kiện (CPU, GPU, RAM,...) để tăng sức mạnh khi cần.\nThiết kế ấn tượng: Thường có vỏ case hầm hố, hệ thống đèn LED RGB, tạo cá tính.\nĐa nhiệm: Ngoài chơi game, còn dùng tốt cho các công việc sáng tạo nội dung, edit video.\nƯu điểm so với laptop: Hiệu năng mạnh hơn, tản nhiệt tốt hơn, dễ nâng cấp, trải nghiệm hiển thị lớn hơn (dùng nhiều màn hình). ', 50000000, 100, 'products/1748536718_pc_asus_tuf_btf_-_3_2d54bb55a893411d8ba905a11eb5a05c_grande.png', '2025-05-20 07:17:47', '2025-12-08 08:30:57'),
(7, 5, 6, 'Apple Watch Series 7', 'Apple Watch Series 7 là thế hệ đồng hồ thông minh tập trung vào trải nghiệm người dùng với màn hình lớn hơn, viền siêu mỏng, thiết kế bền bỉ (chống bụi IP6X, chống nước), sạc nhanh hơn và các tính năng sức khỏe/thể chất toàn diện như đo SpO2, ECG, theo dõi giấc ngủ, cùng bàn phím QWERTY tiện lợi, hoạt động độc lập hơn nhờ hỗ trợ eSIM. \nThiết kế và Màn hình\nMàn hình lớn hơn: Màn hình Retina LTPO OLED luôn bật (Always-On) lớn hơn Series 6 gần 20%, viền mỏng chỉ 1.7mm.\nĐộ bền: Mặt kính trước dày hơn 50%, chống nứt tốt nhất, đạt chuẩn chống bụi IP6X.\nKích thước: Có hai tùy chọn 41mm và 45mm, giữ nguyên kích thước tổng thể so với Series 6 nhờ viền mỏng hơn.\nMàu sắc: Đa dạng với các tùy chọn nhôm (Đen, Trắng, Xanh dương, Xanh lá, Đỏ) và thép không gỉ. \nTính năng sức khỏe & thể chất\nTheo dõi sức khỏe: Đo nồng độ oxy trong máu (SpO2), đo điện tâm đồ (ECG), cảnh báo nhịp tim bất thường, theo dõi giấc ngủ.\nTheo dõi tập luyện: Hỗ trợ nhiều chế độ tập luyện mới, theo dõi hoạt động hàng ngày.\nỨng dụng mới: Có ứng dụng Chú Tâm (Mindfulness) và các mặt đồng hồ mới như Chân Dung. \nKết nối & Sử dụng\neSIM: Phiên bản Cellular hỗ trợ eSIM, cho phép gọi điện, nhắn tin, nghe nhạc độc lập không cần iPhone.\nBàn phím: Bàn phím QWERTY đầy đủ, có thể vuốt (QuickPath) để gõ nhanh hơn.\nSạc nhanh: Sạc nhanh hơn 33% so với Series 6, sạc 80% chỉ trong 45 phút (với bộ sạc USB-C đi kèm). \nPin\nThời lượng: Pin dùng cả ngày, tối ưu hóa cho sạc nhanh, đủ dùng cho một đêm theo dõi giấc ngủ chỉ với 8 phút sạc. \nTóm lại, Apple Watch Series 7 là một bản nâng cấp đáng giá với trải nghiệm màn hình lớn và bền bỉ hơn, cùng các tính năng sức khỏe và tiện ích được cải tiến, mang lại sự thoải mái và kết nối hiệu quả. ', 26000000, 70, 'products/1748536673_xiaomi-watch-s4-den-tn-600x600.png', '2025-05-20 07:17:47', '2025-12-08 08:31:12'),
(8, 6, 2, 'Loa Bluetooth JBL Flip 7', 'Loa Bluetooth JBL Flip 7 là mẫu loa di động nâng cấp với âm thanh mạnh mẽ (35W) nhờ driver woofer và tweeter riêng biệt cùng công nghệ AI Sound Boost, chống nước bụi IP68, pin 14-16 giờ, kết nối Bluetooth 5.4, hỗ trợ Auracast™ và cổng USB-C cho âm thanh lossless, thiết kế nhỏ gọn, bền bỉ với vật liệu tái chế, lý tưởng cho mọi hoạt động ngoài trời. \nĐặc điểm nổi bật\nÂm thanh JBL Pro Sound nâng cấp: Công suất 35W, có woofer và tweeter riêng, cho âm thanh cân bằng, bass sâu, treble trong trẻo. Công nghệ AI Sound Boost tự động tối ưu hóa âm thanh theo thời gian thực, giảm méo tiếng.\nChống nước và bụi IP68: Hoạt động bền bỉ ở hồ bơi, bãi biển, dã ngoại, có thể ngâm nước sâu 1.5m trong 30 phút.\nPin ấn tượng: Pin dung lượng lớn cho 14-16 giờ phát nhạc, hỗ trợ sạc nhanh qua USB-C (2.5 giờ đầy pin).\nKết nối hiện đại: Bluetooth 5.4, Auracast™ cho phép ghép nối nhiều loa; cổng USB-C hỗ trợ phát nhạc lossless.\nThiết kế di động: Gọn nhẹ (0.56kg), bền bỉ, thân thiện môi trường (77% nhựa tái chế), có thể đeo thêm dây.\nỨng dụng JBL Portable: Tinh chỉnh âm thanh, cập nhật phần mềm dễ dàng. \nThông số kỹ thuật chính\nCông suất: 35W (25W woofer + 10W tweeter).\nTần số đáp ứng: 60 Hz - 20k Hz.\nBluetooth: 5.4.\nPin: 4800mAh, 14-16 giờ.\nSạc: USB-C, 2.5 giờ đầy pin.\nKích thước: 182.5 x 69.5 x 71.5 mm.\nTrọng lượng: 0.56 kg. \nTóm lại\nJBL Flip 7 là lựa chọn lý tưởng cho người dùng cần một chiếc loa di động nhỏ gọn nhưng mạnh mẽ, bền bỉ, chất âm tốt, pin lâu và nhiều tính năng thông minh để mang đi bất cứ đâu, từ tiệc tùng ngoài trời đến thư giãn cá nhân. ', 17777800, 50, 'products/1748536620_loa-bluetooth-jbl-flip-7-160525-022117-037-600x600.png', '2025-05-20 07:17:47', '2025-12-08 08:31:27'),
(9, 2, 7, 'Asus ROG Zephyrus', 'Asus ROG Zephyrus là dòng laptop gaming cao cấp, nổi bật với thiết kế siêu mỏng nhẹ, sang trọng (kiểu dáng Ultrabook) nhưng ẩn chứa sức mạnh hiệu năng đỉnh cao từ CPU AMD Ryzen AI/Intel Core Ultra và GPU NVIDIA RTX 50 series, màn hình OLED/IPS chất lượng cao (tần số quét cao, màu sắc chuẩn), tản nhiệt thông minh (ROG Intelligent Cooling) và pin trâu có sạc nhanh PD, hướng đến game thủ và nhà sáng tạo nội tạo di động, thông minh. \nDưới đây là các đặc điểm chính:\nThiết kế & Chất liệu:\nMỏng nhẹ, vỏ nhôm CNC nguyên khối, hoàn thiện cao cấp, phong cách tinh tế và sắc sảo, dễ mang đi.\nTrọng lượng siêu nhẹ, khoảng 1.5kg (G14).\nHiệu năng:\nCPU: AMD Ryzen AI 9 HX (tích hợp NPU mạnh mẽ cho AI) hoặc Intel Core Ultra 9 (có NPU).\nGPU: NVIDIA GeForce RTX 50 series (RTX 5060, 5070, 5090...) kiến trúc Blackwell.\nRAM & SSD: RAM LPDDR5X tốc độ cao, SSD PCIe 4.0 NVMe dung lượng lớn.\nMàn hình (ROG Nebula Display):\nOLED/IPS độ phân giải cao (2.5K, 2.8K, 3K), tỷ lệ 16:10.\nTần số quét cao (120Hz, 240Hz), màu sắc chuẩn (100% DCI-P3), Pantone Validated, Dolby Vision HDR.\nTản nhiệt: Hệ thống ROG Intelligent Cooling hiện đại, hiệu quả.\nPin & Sạc: Pin dung lượng lớn (73Whr, 90Whr), sạc nhanh qua cổng USB-C (PD 100W), hỗ trợ sạc nhanh.\nKết nối: Đầy đủ cổng hiện đại: USB-C Thunderbolt 4, USB-A, HDMI 2.1, Wi-Fi 7, Bluetooth 5.4.\nTính năng khác: Camera 1080P IR (Windows Hello), 4 loa chất lượng cao, hỗ trợ Dolby Atmos, có MUX Switch + Advanced Optimus. \nĐối tượng sử dụng:\nGame thủ di động đòi hỏi hiệu năng cao và tính thẩm mỹ.\nNhà sáng tạo nội dung, đồ họa cần màn hình màu chuẩn và sức mạnh xử lý AI.\nNgười dùng chuyên nghiệp cần sự cân bằng giữa sức mạnh, di động và tính năng thông minh. ', 40000000, 15, 'products/1748536440_vobook_14_oled_x1405v_m1405y_cool_silver_black_keyboard_13_fingerprint_6701c548b729416d90498bdac33dec13_medium.png', '2025-05-20 07:17:47', '2025-12-08 08:31:50'),
(18, 1, 1, 'iPhone 14 Plus', 'iPhone 14 Plus là phiên bản màn hình lớn (6.7 inch) của dòng iPhone 14 tiêu chuẩn, nổi bật với thiết kế khung nhôm viền vuông vức, màn hình Super Retina XDR OLED sắc nét, chip A15 Bionic mạnh mẽ, hệ thống camera kép cải tiến với Photonic Engine, pin trâu và các tính năng an toàn mới như Phát hiện Va chạm và SOS khẩn cấp qua vệ tinh, mang lại trải nghiệm cao cấp hơn mà không cần đến dòng Pro, theo nhiều nguồn thông tin từ Apple Support, FPT Shop, và Viettel Store. \nThiết kế & Màn hình\nMàn hình lớn: 6.7 inch Super Retina XDR (OLED) với độ phân giải cao 2778x1284 pixel, cho hình ảnh chi tiết và màu sắc sống động, theo Apple Support.\nKhung viền: Nhôm hàng không vũ trụ chắc chắn với mặt trước Ceramic Shield bền bỉ, thiết kế vuông vức đặc trưng, theo FPT Shop.\nChống nước: Đạt chuẩn IP68, chịu được độ sâu 6m trong 30 phút, theo Apple Support. \nHiệu năng\nChip: A15 Bionic 6 lõi (2 hiệu năng, 4 tiết kiệm điện) cùng GPU 5 lõi và Neural Engine 16 lõi, mang lại hiệu suất mạnh mẽ cho game và tác vụ nặng, theo Apple Support. \nCamera\nCamera kép sau: Cảm biến chính 12MP khẩu độ ƒ/1.5 (chống rung quang học dịch chuyển cảm biến) và camera góc siêu rộng 12MP, theo Apple Support.\nCamera trước: TrueDepth 12MP với tự động lấy nét, theo Apple Support.\nCông nghệ mới: Photonic Engine (cải thiện ảnh thiếu sáng) và Chế độ Điện Ảnh 4K, theo Apple Support. \nPin & Sạc\nThời lượng pin: Pin trâu, cho thời gian xem video lên đến 26 giờ, theo Apple Support.\nSạc: Hỗ trợ sạc nhanh 20W và sạc MagSafe, theo Apple Support. \nTính năng nổi bật khác\nAn toàn: Phát hiện Va chạm, SOS khẩn cấp qua vệ tinh (tính năng mới), theo Apple Support.\nKết nối: 5G siêu tốc, theo Apple Support. ', 9000000, 32, 'products/1748536353_0012169_black.png', '2025-05-23 08:56:31', '2025-12-08 08:32:25'),
(19, 2, 7, 'Laptop Dell Inspiron', 'Laptop Dell Inspiron là dòng máy tính xách tay phổ thông, đa năng của Dell, nổi bật với thiết kế hiện đại, bền bỉ, hiệu năng ổn định (từ cơ bản đến khá mạnh mẽ), cấu hình đa dạng (CPU Intel Core, RAM DDR5, SSD), màn hình sắc nét, phù hợp cho học sinh, sinh viên, nhân viên văn phòng và người dùng cá nhân cần một thiết bị đáng tin cậy cho công việc hàng ngày, học tập và giải trí với mức giá phải chăng. Dòng này có nhiều phân khúc như Inspiron 3000 (giá rẻ, cơ bản), 5000 (tầm trung), và 7000 (cao cấp hơn, hiệu năng mạnh). \nĐặc điểm nổi bật:\nThiết kế: Trẻ trung, hiện đại, nhiều mẫu mỏng nhẹ, sang trọng (vỏ nhôm) hoặc hầm hố (phiên bản gaming).\nCấu hình đa dạng: Trang bị chip Intel Core i/AMD Ryzen mới nhất, RAM DDR4/DDR5, SSD NVMe cho tốc độ cao, card đồ họa tích hợp Intel Iris Xe hoặc rời NVIDIA (tùy model).\nMàn hình: Kích thước phổ biến 14-15.6 inch, độ phân giải Full HD/2.5K, công nghệ chống chói, góc nhìn rộng.\nBàn phím & Touchpad: Bàn phím gõ êm, hành trình phím tốt, có đèn nền (tùy model), touchpad nhạy bén.\nKết nối: Đầy đủ cổng cơ bản (USB-A, USB-C, HDMI, jack 3.5mm), Wi-Fi 6, Bluetooth 5.x.\nTính năng tiện ích: Bảo mật vân tay (tùy model), bản lề nâng (tăng trải nghiệm gõ).\nPhân khúc: Đa dạng từ giá rẻ (Inspiron 3000) đến cao cấp (Inspiron 7000) đáp ứng nhiều nhu cầu khác nhau. \nĐối tượng sử dụng:\nHọc sinh, sinh viên.\nNhân viên văn phòng.\nNgười dùng cá nhân.\nNgười cần laptop \"đa-zi-năng\" cho công việc và giải trí cơ bản. \nTóm lại: Dell Inspiron là dòng laptop \"quốc dân\" của Dell, cân bằng tốt giữa hiệu năng, tính năng, thiết kế và giá cả, là lựa chọn đáng tin cậy cho người dùng phổ thông. ', 26000000, 46, 'products/1748536289_ava_450b62dbedc44663a3d7bf2bf0c735b3_medium.png', '2025-05-25 08:28:35', '2025-12-08 08:32:43'),
(20, 9, 9, 'Samsung Odyssey G5', 'Samsung Odyssey G5 là dòng màn hình gaming tầm trung nổi bật với thiết kế cong 1000R ôm sát tầm mắt, độ phân giải QHD sắc nét (2K), tốc độ làm mới cao (144Hz/165Hz/180Hz) cùng thời gian phản hồi 1ms, hỗ trợ công nghệ HDR10 và AMD FreeSync Premium/Pro, mang đến trải nghiệm gaming mượt mà, chân thực và đắm chìm với nhiều phiên bản kích thước (27 inch, 32 inch, 34 inch) và tấm nền VA hoặc IPS tùy model. \nCác đặc điểm nổi bật:\nThiết kế cong 1000R: Mô phỏng theo đường cong mắt người, giúp bao quát toàn bộ màn hình, tăng cảm giác nhập vai và giảm mỏi mắt khi dùng lâu.\nĐộ phân giải QHD (2K): Cung cấp hình ảnh sắc nét hơn Full HD, với mật độ điểm ảnh cao, cho thấy nhiều chi tiết hơn trong game.\nTần số quét cao & Thời gian phản hồi 1ms: Đảm bảo hình ảnh chuyển động siêu mượt, loại bỏ hiện tượng giật lag, bóng mờ (ghosting) trong các cảnh game tốc độ cao.\nCông nghệ HDR10: Mở rộng dải tương phản màu sắc, cho hình ảnh có chiều sâu và chân thực hơn (trên một số model).\nAMD FreeSync Premium/Pro: Đồng bộ hóa tốc độ khung hình giữa màn hình và GPU, loại bỏ hiện tượng xé hình.\nTấm nền đa dạng: Có cả tấm nền VA (chống lóa tốt, tương phản cao) và IPS (màu sắc chính xác, góc nhìn rộng) tùy model.\nTính năng bổ trợ: Bao gồm chế độ Eye Saver, Flicker-Free (giảm nháy), và Virtual Aim Point (tâm ngắm ảo) cho game thủ. \nCác phiên bản phổ biến:\nG5 (G50D - phẳng, IPS): 27 inch/2K/180Hz (ví dụ LS27DG502EEXXV).\nG5 (G55C - cong, VA): 27 inch/2K/165Hz (ví dụ LS27CG552EEXXV).\nG5 (G55T - cong, VA): 32 inch/2K/144Hz (ví dụ LC32G55TQBEXXV).\nG5 (34 inch Ultrawide): 34 inch/WQHD/165Hz/Cong (ví dụ LC34G55TWWEXXV). \nTóm lại, Samsung Odyssey G5 là lựa chọn cân bằng giữa hiệu năng gaming và giá cả, phù hợp cho những game thủ muốn nâng cấp trải nghiệm với hình ảnh mượt mà, sắc nét và công nghệ hiện đại.', 23000000, 29, 'products/1748536638_vn-odyssey-g5-g55c-ls27cg552eexxv-538902440_78a9c69df6074de698740d3fa28e55a5_grande.png', '2025-05-29 02:35:40', '2025-12-08 08:33:00'),
(21, 5, 4, 'Huawei Watch Fit 4 Pro', 'Huawei Watch Fit 4 Pro là đồng hồ thông minh cao cấp, nổi bật với thiết kế siêu nhẹ, màn hình AMOLED 1.82 inch sắc nét (sáng 3000 nits), hỗ trợ theo dõi sức khỏe toàn diện (nhịp tim, SpO2, ECG, giấc ngủ), hơn 100 chế độ tập luyện, GPS đa dải tần kép chính xác, nghe gọi Bluetooth trực tiếp, kháng nước 5ATM, pin dùng 10 ngày, và tương thích cả Android/iOS, lý tưởng cho người dùng năng động và yêu công nghệ. \nThiết kế & Hiển thị\nMàn hình: AMOLED 1.82 inch, độ phân giải cao (480x408), sáng 3000 nits, rõ nét dưới nắng.\nChất liệu & Trọng lượng: Thân hợp kim nhôm siêu nhẹ (khoảng 30.4g), viền Titan, mặt trước kính Sapphire, dây silicone hoặc nylon.\nTính năng: Nút xoay haptic phản hồi tốt, loa ngoài & micro cho đàm thoại, kháng nước 5ATM. \nSức khỏe & Thể thao\nTheo dõi sức khỏe: Công nghệ TruSense thế hệ mới, đo nhịp tim 24/7, SpO2, phân tích giấc ngủ (TruSleep), theo dõi stress, ECG, phân tích độ cứng động mạch.\nBài tập: Hơn 100 chế độ tập luyện, bao gồm các môn chuyên sâu như Golf, chạy địa hình.\nĐịnh vị: GPS L1+L5 đa hệ thống (GPS, GLONASS, GALILEO, BDS, QZSS) cho độ chính xác cao, hỗ trợ bản đồ ngoại tuyến. \nTính năng thông minh & Pin\nGọi điện & Thông báo: Nghe gọi qua Bluetooth, nhận thông báo, điều khiển nhạc trực tiếp.\nHệ điều hành: Hoạt động mượt mà trên HarmonyOS (và tương thích với Android/iOS).\nThời lượng pin: Lên đến 10 ngày (sử dụng thường), 4-5 ngày (GPS liên tục), sạc nhanh (10 phút sạc dùng cả ngày). \nTóm lại\nHuawei Watch Fit 4 Pro là sự nâng cấp đáng giá, kết hợp giữa thiết kế cao cấp, tính năng theo dõi sức khỏe chuyên sâu (ECG, độ cứng động mạch) và trải nghiệm thể thao thông minh, phù hợp cho người dùng muốn một chiếc smartwatch toàn diện trên cổ tay. ', 30000000, 30, 'products/1748540915_huawei-watch-fit-4-pro-nylon-tb-600x600.png', '2025-05-29 17:48:35', '2025-12-08 08:33:18');

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_name` varchar(100) NOT NULL,
  `attribute_value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_attributes`
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
-- Table structure for table `promotions`
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
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `promotions`
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
-- Table structure for table `recently_viewed`
--

CREATE TABLE `recently_viewed` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `viewed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `recently_viewed`
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
-- Table structure for table `revenue`
--

CREATE TABLE `revenue` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `total_amount` float NOT NULL,
  `revenue_date` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revenue`
--

INSERT INTO `revenue` (`id`, `order_id`, `total_amount`, `revenue_date`, `created_at`) VALUES
(12, 1, 2599.97, '2025-01-01', '2025-05-24 15:12:25'),
(21, 6, 25555600, '2025-01-06', '2025-05-24 17:00:48'),
(24, 15, 17000000, '2025-05-24', '2025-05-24 17:14:54'),
(25, 13, 32999000, '2025-05-23', '2025-05-24 17:14:58'),
(26, 12, 24000000, '2025-05-22', '2025-05-24 17:15:03'),
(29, 19, 9000000, '2025-05-29', '2025-05-29 09:44:46'),
(30, 20, 258000000, '2025-05-29', '2025-05-29 14:37:43'),
(32, 31, 75000000, '2025-12-07', '2025-12-07 11:19:15'),
(33, 30, 25500000, '2025-12-07', '2025-12-07 17:19:45'),
(34, 26, 127000000, '2025-12-05', '2025-12-07 17:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `users`
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
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `name`, `phone`, `role`, `created_at`, `updated_at`) VALUES
(1, 'customer1@example.com', '$2y$10$Jmp25OI1uyYmZE3EMhuWUuFa70/RhMIqofW3Yz9sdG/LSgjsbdop2', 'Nguyen Van A', '0123456789', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:21:27'),
(2, 'admin@example.com', '$2y$10$VKqk4CnBZScz1lL8OhcbG.9Xyv1aVbI4V7Piy74ntzxkGKaDeQdHO', 'Admin User', '0987654321', 'admin', '2025-05-20 07:17:47', '2025-12-07 11:17:31'),
(3, 'customer2@example.com', '$2y$10$9Qsp5bRbkvmsuIb7bGwW/.cQzEl5dOeUWITYtH4v4TzoLEs2yTxCq', 'Tran Thi B', '0123456790', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:22:55'),
(4, 'customer3@example.com', '$2y$10$ixwTiLkzWBqksFz8SK5tAOwUEOPI27epLjCkT2.Ppp0oeq8FVDHb2', 'Le Van C', '0123456791', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:23:07'),
(5, 'customer4@example.com', '$2y$10$qvd/c/tPaHDQKf5ppvq8lOSEkEfGSNqimn41OiJzqLPdbmyqxMa92', 'Pham Thi D', '0123456792', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:23:17'),
(6, 'customer5@example.com', '$2y$10$L1WC0td0ko/GNLF8YjuIlec4FkDg0TH2jSrVWxbJY55THdaPAzAvu', 'Hoang Van E', '0123456793', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:46'),
(7, 'customer6@example.com', '$2y$10$m/X67YNftdV2R4LG57MJRecEELt5s1UqnpCatRvX3eV.rGNgfNT4W', 'Nguyen Thi F', '0123456794', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:22'),
(8, 'customer7@example.com', '$2y$10$Uz6DSBjqX15FtNAINSHbee6TcV542nNKMBfI4FkP5o1kcZq3j3t.i', 'Tran Van G', '0123456795', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:14'),
(9, 'customer8@example.com', '$2y$10$J9VRrlkSZ2Rr2gq7BxyskuyJ1mw6ZW36155O1OBYGYLtDdA2.Ex7S', 'Le Thi H', '0123456796', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:24:06'),
(10, 'customer9@example.com', '$2y$10$bZdvJofNRrJ9uUHIl3kBYODswvAbaZJ4i3cAenNc1OrfxyXZHCxL.', 'Pham Van I', '0123456797', 'customer', '2025-05-20 07:17:47', '2025-05-20 07:23:54'),
(11, 'huydeptrai171105@gmail.com', '$2y$10$dbA2fWKsBxb.eF7yQo.wXeta09sOxnU7RfZCZ8.EnA5P0UUhCHj7m', 'Nguyễn Quốc Huy', '0916076557', 'admin', '2025-05-25 16:41:17', '2025-12-02 09:58:33'),
(12, 'huydeptrai@gmail.com', '$2y$10$KVG2SpvZ4OtDmscURF8Rv.X1m6hcuxFc456k0QxiwJxisvLoDJAxS', 'A B C', NULL, 'customer', '2025-05-29 15:39:21', '2025-05-29 15:39:21');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `address_id` (`address_id`),
  ADD KEY `promotion_id` (`promotion_id`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `brand_id` (`brand_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promotions`
--
ALTER TABLE `promotions`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`);

--
-- Indexes for table `recently_viewed`
--
ALTER TABLE `recently_viewed`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `revenue`
--
ALTER TABLE `revenue`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=77;

--
-- AUTO_INCREMENT for table `promotions`
--
ALTER TABLE `promotions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `recently_viewed`
--
ALTER TABLE `recently_viewed`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `revenue`
--
ALTER TABLE `revenue`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `addresses`
--
ALTER TABLE `addresses`
  ADD CONSTRAINT `addresses_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `feedback_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `feedback_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`),
  ADD CONSTRAINT `orders_ibfk_3` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`);

--
-- Constraints for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD CONSTRAINT `product_attributes_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `recently_viewed`
--
ALTER TABLE `recently_viewed`
  ADD CONSTRAINT `recently_viewed_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `recently_viewed_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `revenue`
--
ALTER TABLE `revenue`
  ADD CONSTRAINT `revenue_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
