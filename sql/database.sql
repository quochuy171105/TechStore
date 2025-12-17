-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 17, 2025 at 04:00 PM
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
-- Database: `techstore`
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
(9, 9, 9, 1, '2025-05-09 11:00:00'),
(50, 1, 21, 4, '2025-12-08 10:11:46'),
(51, 1, 20, 2, '2025-12-11 05:59:13');

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
(32, 1, 13, 339000000, NULL, '', 'pending', '2025-12-08 09:28:42', '2025-12-08 09:28:42'),
(33, 1, 13, 30000000, NULL, '', 'pending', '2025-12-08 09:45:58', '2025-12-08 09:45:58');

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
(54, 32, 20, 1, 23000000),
(55, 33, 3, 1, 30000000);

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
(7, 5, 6, 'Apple Watch Series 7', 'Apple Watch Series 7 là thế hệ đồng hồ thông minh tập trung vào trải nghiệm người dùng với màn hình lớn hơn, viền siêu mỏng, thiết kế bền bỉ (chống bụi IP6X, chống nước), sạc nhanh hơn và các tính năng sức khỏe/thể chất toàn diện như đo SpO2, ECG, theo dõi giấc ngủ, cùng bàn phím QWERTY tiện lợi, hoạt động độc lập hơn nhờ hỗ trợ eSIM. \r\nThiết kế và Màn hình\r\nMàn hình lớn hơn: Màn hình Retina LTPO OLED luôn bật (Always-On) lớn hơn Series 6 gần 20%, viền mỏng chỉ 1.7mm.\r\nĐộ bền: Mặt kính trước dày hơn 50%, chống nứt tốt nhất, đạt chuẩn chống bụi IP6X.\r\nKích thước: Có hai tùy chọn 41mm và 45mm, giữ nguyên kích thước tổng thể so với Series 6 nhờ viền mỏng hơn.\r\nMàu sắc: Đa dạng với các tùy chọn nhôm (Đen, Trắng, Xanh dương, Xanh lá, Đỏ) và thép không gỉ. \r\nTính năng sức khỏe & thể chất\r\nTheo dõi sức khỏe: Đo nồng độ oxy trong máu (SpO2), đo điện tâm đồ (ECG), cảnh báo nhịp tim bất thường, theo dõi giấc ngủ.\r\nTheo dõi tập luyện: Hỗ trợ nhiều chế độ tập luyện mới, theo dõi hoạt động hàng ngày.\r\nỨng dụng mới: Có ứng dụng Chú Tâm (Mindfulness) và các mặt đồng hồ mới như Chân Dung. \r\nKết nối & Sử dụng\r\neSIM: Phiên bản Cellular hỗ trợ eSIM, cho phép gọi điện, nhắn tin, nghe nhạc độc lập không cần iPhone.\r\nBàn phím: Bàn phím QWERTY đầy đủ, có thể vuốt (QuickPath) để gõ nhanh hơn.\r\nSạc nhanh: Sạc nhanh hơn 33% so với Series 6, sạc 80% chỉ trong 45 phút (với bộ sạc USB-C đi kèm). \r\nPin\r\nThời lượng: Pin dùng cả ngày, tối ưu hóa cho sạc nhanh, đủ dùng cho một đêm theo dõi giấc ngủ chỉ với 8 phút sạc. \r\nTóm lại, Apple Watch Series 7 là một bản nâng cấp đáng giá với trải nghiệm màn hình lớn và bền bỉ hơn, cùng các tính năng sức khỏe và tiện ích được cải tiến, mang lại sự thoải mái và kết nối hiệu quả. ', 7600000, 70, 'products/1748536673_xiaomi-watch-s4-den-tn-600x600.png', '2025-05-20 07:17:47', '2025-12-17 13:52:25'),
(8, 6, 2, 'Loa Bluetooth JBL Flip 7', 'Loa Bluetooth JBL Flip 7 là mẫu loa di động nâng cấp với âm thanh mạnh mẽ (35W) nhờ driver woofer và tweeter riêng biệt cùng công nghệ AI Sound Boost, chống nước bụi IP68, pin 14-16 giờ, kết nối Bluetooth 5.4, hỗ trợ Auracast™ và cổng USB-C cho âm thanh lossless, thiết kế nhỏ gọn, bền bỉ với vật liệu tái chế, lý tưởng cho mọi hoạt động ngoài trời. \nĐặc điểm nổi bật\nÂm thanh JBL Pro Sound nâng cấp: Công suất 35W, có woofer và tweeter riêng, cho âm thanh cân bằng, bass sâu, treble trong trẻo. Công nghệ AI Sound Boost tự động tối ưu hóa âm thanh theo thời gian thực, giảm méo tiếng.\nChống nước và bụi IP68: Hoạt động bền bỉ ở hồ bơi, bãi biển, dã ngoại, có thể ngâm nước sâu 1.5m trong 30 phút.\nPin ấn tượng: Pin dung lượng lớn cho 14-16 giờ phát nhạc, hỗ trợ sạc nhanh qua USB-C (2.5 giờ đầy pin).\nKết nối hiện đại: Bluetooth 5.4, Auracast™ cho phép ghép nối nhiều loa; cổng USB-C hỗ trợ phát nhạc lossless.\nThiết kế di động: Gọn nhẹ (0.56kg), bền bỉ, thân thiện môi trường (77% nhựa tái chế), có thể đeo thêm dây.\nỨng dụng JBL Portable: Tinh chỉnh âm thanh, cập nhật phần mềm dễ dàng. \nThông số kỹ thuật chính\nCông suất: 35W (25W woofer + 10W tweeter).\nTần số đáp ứng: 60 Hz - 20k Hz.\nBluetooth: 5.4.\nPin: 4800mAh, 14-16 giờ.\nSạc: USB-C, 2.5 giờ đầy pin.\nKích thước: 182.5 x 69.5 x 71.5 mm.\nTrọng lượng: 0.56 kg. \nTóm lại\nJBL Flip 7 là lựa chọn lý tưởng cho người dùng cần một chiếc loa di động nhỏ gọn nhưng mạnh mẽ, bền bỉ, chất âm tốt, pin lâu và nhiều tính năng thông minh để mang đi bất cứ đâu, từ tiệc tùng ngoài trời đến thư giãn cá nhân. ', 17777800, 50, 'products/1748536620_loa-bluetooth-jbl-flip-7-160525-022117-037-600x600.png', '2025-05-20 07:17:47', '2025-12-08 08:31:27'),
(9, 2, 7, 'Asus ROG Zephyrus', 'Asus ROG Zephyrus là dòng laptop gaming cao cấp, nổi bật với thiết kế siêu mỏng nhẹ, sang trọng (kiểu dáng Ultrabook) nhưng ẩn chứa sức mạnh hiệu năng đỉnh cao từ CPU AMD Ryzen AI/Intel Core Ultra và GPU NVIDIA RTX 50 series, màn hình OLED/IPS chất lượng cao (tần số quét cao, màu sắc chuẩn), tản nhiệt thông minh (ROG Intelligent Cooling) và pin trâu có sạc nhanh PD, hướng đến game thủ và nhà sáng tạo nội tạo di động, thông minh. \nDưới đây là các đặc điểm chính:\nThiết kế & Chất liệu:\nMỏng nhẹ, vỏ nhôm CNC nguyên khối, hoàn thiện cao cấp, phong cách tinh tế và sắc sảo, dễ mang đi.\nTrọng lượng siêu nhẹ, khoảng 1.5kg (G14).\nHiệu năng:\nCPU: AMD Ryzen AI 9 HX (tích hợp NPU mạnh mẽ cho AI) hoặc Intel Core Ultra 9 (có NPU).\nGPU: NVIDIA GeForce RTX 50 series (RTX 5060, 5070, 5090...) kiến trúc Blackwell.\nRAM & SSD: RAM LPDDR5X tốc độ cao, SSD PCIe 4.0 NVMe dung lượng lớn.\nMàn hình (ROG Nebula Display):\nOLED/IPS độ phân giải cao (2.5K, 2.8K, 3K), tỷ lệ 16:10.\nTần số quét cao (120Hz, 240Hz), màu sắc chuẩn (100% DCI-P3), Pantone Validated, Dolby Vision HDR.\nTản nhiệt: Hệ thống ROG Intelligent Cooling hiện đại, hiệu quả.\nPin & Sạc: Pin dung lượng lớn (73Whr, 90Whr), sạc nhanh qua cổng USB-C (PD 100W), hỗ trợ sạc nhanh.\nKết nối: Đầy đủ cổng hiện đại: USB-C Thunderbolt 4, USB-A, HDMI 2.1, Wi-Fi 7, Bluetooth 5.4.\nTính năng khác: Camera 1080P IR (Windows Hello), 4 loa chất lượng cao, hỗ trợ Dolby Atmos, có MUX Switch + Advanced Optimus. \nĐối tượng sử dụng:\nGame thủ di động đòi hỏi hiệu năng cao và tính thẩm mỹ.\nNhà sáng tạo nội dung, đồ họa cần màn hình màu chuẩn và sức mạnh xử lý AI.\nNgười dùng chuyên nghiệp cần sự cân bằng giữa sức mạnh, di động và tính năng thông minh. ', 40000000, 15, 'products/1748536440_vobook_14_oled_x1405v_m1405y_cool_silver_black_keyboard_13_fingerprint_6701c548b729416d90498bdac33dec13_medium.png', '2025-05-20 07:17:47', '2025-12-08 08:31:50'),
(18, 1, 1, 'iPhone 14 Plus', 'iPhone 14 Plus là phiên bản màn hình lớn (6.7 inch) của dòng iPhone 14 tiêu chuẩn, nổi bật với thiết kế khung nhôm viền vuông vức, màn hình Super Retina XDR OLED sắc nét, chip A15 Bionic mạnh mẽ, hệ thống camera kép cải tiến với Photonic Engine, pin trâu và các tính năng an toàn mới như Phát hiện Va chạm và SOS khẩn cấp qua vệ tinh, mang lại trải nghiệm cao cấp hơn mà không cần đến dòng Pro, theo nhiều nguồn thông tin từ Apple Support, FPT Shop, và Viettel Store. \nThiết kế & Màn hình\nMàn hình lớn: 6.7 inch Super Retina XDR (OLED) với độ phân giải cao 2778x1284 pixel, cho hình ảnh chi tiết và màu sắc sống động, theo Apple Support.\nKhung viền: Nhôm hàng không vũ trụ chắc chắn với mặt trước Ceramic Shield bền bỉ, thiết kế vuông vức đặc trưng, theo FPT Shop.\nChống nước: Đạt chuẩn IP68, chịu được độ sâu 6m trong 30 phút, theo Apple Support. \nHiệu năng\nChip: A15 Bionic 6 lõi (2 hiệu năng, 4 tiết kiệm điện) cùng GPU 5 lõi và Neural Engine 16 lõi, mang lại hiệu suất mạnh mẽ cho game và tác vụ nặng, theo Apple Support. \nCamera\nCamera kép sau: Cảm biến chính 12MP khẩu độ ƒ/1.5 (chống rung quang học dịch chuyển cảm biến) và camera góc siêu rộng 12MP, theo Apple Support.\nCamera trước: TrueDepth 12MP với tự động lấy nét, theo Apple Support.\nCông nghệ mới: Photonic Engine (cải thiện ảnh thiếu sáng) và Chế độ Điện Ảnh 4K, theo Apple Support. \nPin & Sạc\nThời lượng pin: Pin trâu, cho thời gian xem video lên đến 26 giờ, theo Apple Support.\nSạc: Hỗ trợ sạc nhanh 20W và sạc MagSafe, theo Apple Support. \nTính năng nổi bật khác\nAn toàn: Phát hiện Va chạm, SOS khẩn cấp qua vệ tinh (tính năng mới), theo Apple Support.\nKết nối: 5G siêu tốc, theo Apple Support. ', 9000000, 32, 'products/1748536353_0012169_black.png', '2025-05-23 08:56:31', '2025-12-08 08:32:25'),
(19, 2, 7, 'Laptop Dell Inspiron', 'Laptop Dell Inspiron là dòng máy tính xách tay phổ thông, đa năng của Dell, nổi bật với thiết kế hiện đại, bền bỉ, hiệu năng ổn định (từ cơ bản đến khá mạnh mẽ), cấu hình đa dạng (CPU Intel Core, RAM DDR5, SSD), màn hình sắc nét, phù hợp cho học sinh, sinh viên, nhân viên văn phòng và người dùng cá nhân cần một thiết bị đáng tin cậy cho công việc hàng ngày, học tập và giải trí với mức giá phải chăng. Dòng này có nhiều phân khúc như Inspiron 3000 (giá rẻ, cơ bản), 5000 (tầm trung), và 7000 (cao cấp hơn, hiệu năng mạnh). \nĐặc điểm nổi bật:\nThiết kế: Trẻ trung, hiện đại, nhiều mẫu mỏng nhẹ, sang trọng (vỏ nhôm) hoặc hầm hố (phiên bản gaming).\nCấu hình đa dạng: Trang bị chip Intel Core i/AMD Ryzen mới nhất, RAM DDR4/DDR5, SSD NVMe cho tốc độ cao, card đồ họa tích hợp Intel Iris Xe hoặc rời NVIDIA (tùy model).\nMàn hình: Kích thước phổ biến 14-15.6 inch, độ phân giải Full HD/2.5K, công nghệ chống chói, góc nhìn rộng.\nBàn phím & Touchpad: Bàn phím gõ êm, hành trình phím tốt, có đèn nền (tùy model), touchpad nhạy bén.\nKết nối: Đầy đủ cổng cơ bản (USB-A, USB-C, HDMI, jack 3.5mm), Wi-Fi 6, Bluetooth 5.x.\nTính năng tiện ích: Bảo mật vân tay (tùy model), bản lề nâng (tăng trải nghiệm gõ).\nPhân khúc: Đa dạng từ giá rẻ (Inspiron 3000) đến cao cấp (Inspiron 7000) đáp ứng nhiều nhu cầu khác nhau. \nĐối tượng sử dụng:\nHọc sinh, sinh viên.\nNhân viên văn phòng.\nNgười dùng cá nhân.\nNgười cần laptop \"đa-zi-năng\" cho công việc và giải trí cơ bản. \nTóm lại: Dell Inspiron là dòng laptop \"quốc dân\" của Dell, cân bằng tốt giữa hiệu năng, tính năng, thiết kế và giá cả, là lựa chọn đáng tin cậy cho người dùng phổ thông. ', 26000000, 46, 'products/1748536289_ava_450b62dbedc44663a3d7bf2bf0c735b3_medium.png', '2025-05-25 08:28:35', '2025-12-08 08:32:43'),
(20, 9, 9, 'Samsung Odyssey G5', 'Samsung Odyssey G5 là dòng màn hình gaming tầm trung nổi bật với thiết kế cong 1000R ôm sát tầm mắt, độ phân giải QHD sắc nét (2K), tốc độ làm mới cao (144Hz/165Hz/180Hz) cùng thời gian phản hồi 1ms, hỗ trợ công nghệ HDR10 và AMD FreeSync Premium/Pro, mang đến trải nghiệm gaming mượt mà, chân thực và đắm chìm với nhiều phiên bản kích thước (27 inch, 32 inch, 34 inch) và tấm nền VA hoặc IPS tùy model. \nCác đặc điểm nổi bật:\nThiết kế cong 1000R: Mô phỏng theo đường cong mắt người, giúp bao quát toàn bộ màn hình, tăng cảm giác nhập vai và giảm mỏi mắt khi dùng lâu.\nĐộ phân giải QHD (2K): Cung cấp hình ảnh sắc nét hơn Full HD, với mật độ điểm ảnh cao, cho thấy nhiều chi tiết hơn trong game.\nTần số quét cao & Thời gian phản hồi 1ms: Đảm bảo hình ảnh chuyển động siêu mượt, loại bỏ hiện tượng giật lag, bóng mờ (ghosting) trong các cảnh game tốc độ cao.\nCông nghệ HDR10: Mở rộng dải tương phản màu sắc, cho hình ảnh có chiều sâu và chân thực hơn (trên một số model).\nAMD FreeSync Premium/Pro: Đồng bộ hóa tốc độ khung hình giữa màn hình và GPU, loại bỏ hiện tượng xé hình.\nTấm nền đa dạng: Có cả tấm nền VA (chống lóa tốt, tương phản cao) và IPS (màu sắc chính xác, góc nhìn rộng) tùy model.\nTính năng bổ trợ: Bao gồm chế độ Eye Saver, Flicker-Free (giảm nháy), và Virtual Aim Point (tâm ngắm ảo) cho game thủ. \nCác phiên bản phổ biến:\nG5 (G50D - phẳng, IPS): 27 inch/2K/180Hz (ví dụ LS27DG502EEXXV).\nG5 (G55C - cong, VA): 27 inch/2K/165Hz (ví dụ LS27CG552EEXXV).\nG5 (G55T - cong, VA): 32 inch/2K/144Hz (ví dụ LC32G55TQBEXXV).\nG5 (34 inch Ultrawide): 34 inch/WQHD/165Hz/Cong (ví dụ LC34G55TWWEXXV). \nTóm lại, Samsung Odyssey G5 là lựa chọn cân bằng giữa hiệu năng gaming và giá cả, phù hợp cho những game thủ muốn nâng cấp trải nghiệm với hình ảnh mượt mà, sắc nét và công nghệ hiện đại.', 23000000, 29, 'products/1748536638_vn-odyssey-g5-g55c-ls27cg552eexxv-538902440_78a9c69df6074de698740d3fa28e55a5_grande.png', '2025-05-29 02:35:40', '2025-12-08 08:33:00'),
(21, 5, 4, 'Huawei Watch Fit 4 Pro', 'Huawei Watch Fit 4 Pro là đồng hồ thông minh cao cấp, nổi bật với thiết kế siêu nhẹ, màn hình AMOLED 1.82 inch sắc nét (sáng 3000 nits), hỗ trợ theo dõi sức khỏe toàn diện (nhịp tim, SpO2, ECG, giấc ngủ), hơn 100 chế độ tập luyện, GPS đa dải tần kép chính xác, nghe gọi Bluetooth trực tiếp, kháng nước 5ATM, pin dùng 10 ngày, và tương thích cả Android/iOS, lý tưởng cho người dùng năng động và yêu công nghệ. \r\nThiết kế & Hiển thị\r\nMàn hình: AMOLED 1.82 inch, độ phân giải cao (480x408), sáng 3000 nits, rõ nét dưới nắng.\r\nChất liệu & Trọng lượng: Thân hợp kim nhôm siêu nhẹ (khoảng 30.4g), viền Titan, mặt trước kính Sapphire, dây silicone hoặc nylon.\r\nTính năng: Nút xoay haptic phản hồi tốt, loa ngoài & micro cho đàm thoại, kháng nước 5ATM. \r\nSức khỏe & Thể thao\r\nTheo dõi sức khỏe: Công nghệ TruSense thế hệ mới, đo nhịp tim 24/7, SpO2, phân tích giấc ngủ (TruSleep), theo dõi stress, ECG, phân tích độ cứng động mạch.\r\nBài tập: Hơn 100 chế độ tập luyện, bao gồm các môn chuyên sâu như Golf, chạy địa hình.\r\nĐịnh vị: GPS L1+L5 đa hệ thống (GPS, GLONASS, GALILEO, BDS, QZSS) cho độ chính xác cao, hỗ trợ bản đồ ngoại tuyến. \r\nTính năng thông minh & Pin\r\nGọi điện & Thông báo: Nghe gọi qua Bluetooth, nhận thông báo, điều khiển nhạc trực tiếp.\r\nHệ điều hành: Hoạt động mượt mà trên HarmonyOS (và tương thích với Android/iOS).\r\nThời lượng pin: Lên đến 10 ngày (sử dụng thường), 4-5 ngày (GPS liên tục), sạc nhanh (10 phút sạc dùng cả ngày). \r\nTóm lại\r\nHuawei Watch Fit 4 Pro là sự nâng cấp đáng giá, kết hợp giữa thiết kế cao cấp, tính năng theo dõi sức khỏe chuyên sâu (ECG, độ cứng động mạch) và trải nghiệm thể thao thông minh, phù hợp cho người dùng muốn một chiếc smartwatch toàn diện trên cổ tay. ', 3199000, 30, 'products/1748540915_huawei-watch-fit-4-pro-nylon-tb-600x600.png', '2025-05-29 17:48:35', '2025-12-17 13:51:54'),
(23, 3, 5, 'Sony Xperia Z2', 'Sony Xperia Z2 Tablet là máy tính bảng Android cao cấp, nổi bật với thiết kế siêu mỏng nhẹ (6.4mm, 439g), chống nước/bụi IP55/IP58, màn hình 10.1&#34; Full HD Triluminos sắc nét, hiệu năng mạnh mẽ với chip Snapdragon 801 và RAM 3GB. Máy có camera 8MP Exmor RS, pin 6000mAh, âm thanh vòm và công nghệ khử ồn khi dùng tai nghe, chạy Android KitKat 4.4, được xem là một trong những máy tính bảng mỏng nhẹ nhất thời bấy giờ. \r\nThiết kế và Màn hình\r\nThiết kế: Siêu mỏng chỉ 6.4mm, siêu nhẹ 439g, phong cách OmniBalance đặc trưng của Sony, chống nước/bụi.\r\nMàn hình: 10.1 inch Full HD (1920x1080), công nghệ TRILUMINOS Display và X-Reality cho màu sắc sống động, góc nhìn rộng. \r\nHiệu năng và Cấu hình\r\nChip xử lý: Snapdragon 801 4 nhân.\r\nRAM: 3GB, giúp xử lý đa nhiệm mượt mà.\r\nHệ điều hành: Android 4.4 KitKat. \r\nCamera\r\nCamera sau: 8.1 MP với cảm biến Exmor RS, hỗ trợ quay video Full HD, HDR.\r\nCamera trước: 2.2 MP. \r\nÂm thanh và Pin\r\nÂm thanh: Công nghệ S-Force Surround, khử ồn kỹ thuật số khi dùng tai nghe (giảm 98% tạp âm).\r\nPin: 6000mAh, thời lượng sử dụng lâu dài. \r\nĐặc điểm nổi bật khác\r\nKết nối: Hỗ trợ LTE (tùy phiên bản).\r\nBộ nhớ: Có tùy chọn 16GB/32GB, hỗ trợ thẻ nhớ microSD. \r\nTóm lại, Xperia Z2 Tablet là một chiếc máy tính bảng cao cấp với thiết kế đẹp, cấu hình mạnh và nhiều tính năng giải trí ấn tượng, kế thừa và nâng cấp từ dòng Xperia Tablet Z tiền nhiệm.', 8950000, 31, 'products/1765975521_tablet_PNG8600.png', '2025-12-17 12:45:21', '2025-12-17 12:45:21'),
(24, 3, 2, 'Samsung Galaxy Tab S10 ', 'Samsung Galaxy Tab S10 là dòng máy tính bảng cao cấp với nhiều phiên bản (Ultra, +, FE), nổi bật với thiết kế siêu mỏng, màn hình Dynamic AMOLED 2X (bản Ultra) hoặc LCD (bản FE) sắc nét, chip mạnh mẽ (MediaTek Dimensity 9300+ / Exynos 1580), hỗ trợ bút S Pen với AI, hệ sinh thái ứng dụng đa nhiệm và các tính năng Galaxy AI như dịch thuật, ghi chú thông minh, giúp thay thế laptop cho công việc sáng tạo và giải trí đỉnh cao. \r\nCác phiên bản chính\r\nGalaxy Tab S10 Ultra: Màn hình lớn 14.6 inch AMOLED, chip Dimensity 9300+, RAM 12/16GB, pin 11200mAh, camera kép trước, hỗ trợ S Pen và bàn phím, kháng nước IP68.\r\nGalaxy Tab S10+: Kích thước màn hình 12.4 inch, cấu hình cao cấp, pin 10090mAh, hỗ trợ S Pen.\r\nGalaxy Tab S10 FE (Fan Edition): Màn hình LCD (10.9 inch hoặc 13.1 inch), chip Exynos 1580, RAM 8/12GB, hỗ trợ S Pen, pin lớn hơn, giá phải chăng hơn. \r\nĐiểm nổi bật chung\r\nHiệu năng: Chip mạnh mẽ, RAM lớn, đa nhiệm mượt mà.\r\nGalaxy AI: Tích hợp các tính năng AI thông minh như Trợ lý Google Gemini, Khoanh vùng tìm kiếm, Dịch thuật trực tiếp, Chỉnh sửa ảnh/video AI.\r\nThiết kế: Siêu mỏng, nhẹ (đặc biệt bản Ultra), khung nhôm Armor Aluminum bền bỉ, kháng nước/bụi IP68.\r\nMàn hình: Dynamic AMOLED 2X (Ultra) hoặc LCD (FE) chất lượng cao, tần số quét 120Hz, chống chói tốt.\r\nBút S Pen: Độ trễ cực thấp, tích hợp AI nhận diện chữ viết, hỗ trợ vẽ, ghi chú, điều khiển.\r\nÂm thanh: Chất lượng cao với loa AKG (trên bản Ultra).\r\nHệ sinh thái: Kết nối liền mạch với các thiết bị Galaxy khác, hỗ trợ ứng dụng chuyên nghiệp (Goodnotes, LumaFusion). \r\nĐối tượng phù hợp\r\nTab S10 Ultra: Nhà sáng tạo nội dung, kiến trúc sư, lập trình viên, người cần máy tính bảng thay thế laptop.\r\nTab S10 FE: Người dùng phổ thông, học sinh, sinh viên, cần thiết bị đa năng, bền bỉ, giá hợp lý. ', 19500000, 20, 'products/1765976054_ipadair11-digitalmat-gallery-1-202404-removebg-preview.png', '2025-12-17 12:53:36', '2025-12-17 12:54:14'),
(25, 3, 5, 'Surface Pro 8', 'Surface Pro 8 là thiết bị lai tablet-laptop 2-in-1 đa năng của Microsoft, nổi bật với thiết kế viền mỏng hơn, màn hình PixelSense 13 inch, tần số quét 120Hz mượt mà, chip Intel Gen 11 mạnh mẽ, 2 cổng Thunderbolt 4, và hỗ trợ bút Surface Slim Pen 2 với khe sạc, mang đến hiệu năng cao, thời lượng pin ấn tượng và trải nghiệm làm việc, giải trí linh hoạt với Windows 11. \r\nĐặc điểm nổi bật:\r\nThiết kế & Màn hình:\r\nThiết kế kim loại nguyên khối, mỏng nhẹ, tinh tế, viền màn hình mỏng hơn các thế hệ trước.\r\nMàn hình cảm ứng 13 inch PixelSense™, độ phân giải cao (2880x1920), tỷ lệ 3:2, hỗ trợ cảm ứng đa điểm.\r\nTần số quét lên đến 120Hz (mặc định 60Hz) cho chuyển động hình ảnh siêu mượt, hỗ trợ Dolby Vision®.\r\nHiệu năng & Cấu hình:\r\nBộ xử lý Intel Core i5/i7 thế hệ 11 (1135G7/1185G7) và GPU Intel Iris Xe mạnh mẽ.\r\nTùy chọn RAM 8GB, 16GB, 32GB (LPDDR4x) và SSD NVMe tốc độ cao.\r\nHệ điều hành Windows 11 cài sẵn, tối ưu hóa hiệu năng.\r\nKết nối & Tiện ích:\r\n2 cổng USB-C® hỗ trợ Thunderbolt™ 4 (USB 4.0), cho tốc độ truyền dữ liệu 40Gbps, kết nối eGPU.\r\nCổng tai nghe 3.5mm, cổng Surface Connect.\r\nCamera trước 5MP (Windows Hello) và sau 10MP.\r\nTương thích bút Surface Slim Pen 2 có khe sạc tiện lợi trên bàn phím.\r\nPin & Âm thanh:\r\nPin dung lượng cao (51.5 Whr), cho thời lượng sử dụng lên tới 16 giờ (tùy điều kiện).\r\nÂm thanh Dolby Atmos®. \r\nTóm lại:\r\nSurface Pro 8 là sự kết hợp hoàn hảo giữa máy tính bảng và laptop, mạnh mẽ hơn, có màn hình đẹp hơn, kết nối nhanh hơn và thời lượng pin tốt hơn thế hệ trước, phục vụ tốt nhu cầu làm việc sáng tạo, văn phòng và giải trí, thích hợp cho người dùng cần một thiết bị di động linh hoạt nhưng không hy sinh hiệu năng. ', 15500000, 40, 'products/1765976449_shopping.webp', '2025-12-17 13:00:49', '2025-12-17 13:00:49'),
(26, 4, 6, 'Xiaomi 33W Power', 'Xiaomi 33W Power thường đề cập đến các sản phẩm sạc (củ sạc tường hoặc sạc dự phòng) có công suất sạc nhanh tối đa 33W, hỗ trợ chuẩn PD (Power Delivery) và Quick Charge, cho phép sạc nhanh cho điện thoại thông minh Xiaomi, iPhone, máy tính bảng, thậm chí cả laptop (ở mức độ nhất định) với thiết kế nhỏ gọn, đa dạng cổng (USB-C, USB-A), tích hợp cáp sạc (ở một số mẫu), và nhiều tính năng bảo vệ an toàn. \r\nĐặc điểm chính:\r\nCông suất cao: Đầu ra lên tới 33W, sạc nhanh cho nhiều thiết bị, đặc biệt điện thoại Xiaomi hỗ trợ Turbo Charge.\r\nĐa cổng: Thường có cả cổng USB-C và USB-A, cho phép sạc đồng thời 2-3 thiết bị.\r\nSạc nhanh 2 chiều: Cổng USB-C có thể vừa sạc ra, vừa sạc vào (tự sạc) nhanh chóng (tối đa 30W).\r\nThiết kế nhỏ gọn: Thường dùng vật liệu PC+ABS, có góc bo tròn, dễ mang theo.\r\nTích hợp cáp (tùy mẫu): Một số mẫu có sẵn cáp USB-C tích hợp ngay trên thân, tiện lợi.\r\nHỗ trợ sạc dòng điện thấp: Dành cho tai nghe, đồng hồ thông minh.\r\nBảo vệ an toàn: Tích hợp chip thông minh chống quá tải, quá nhiệt, đoản mạch. \r\nPhân loại sản phẩm phổ biến:\r\nSạc dự phòng (Power Bank) (10000mAh/20000mAh): Dung lượng lớn, có mẫu có cáp tích hợp, nam châm (Magnetic Power Bank 10000), sạc nhanh cả có dây và không dây.\r\nCủ sạc tường (Wall Charger) (33W): Thường có 2 cổng (USB-C + USB-A) hoặc 1 cổng USB-C (củ GaN 33W), nhỏ gọn, lý tưởng cho di chuyển. \r\nTóm lại, &#34;Xiaomi 33W Power&#34; là dòng sản phẩm sạc hiệu năng cao, tiện lợi, đa năng, đáp ứng nhu cầu sạc nhanh nhiều thiết bị trong đời sống di động. ', 490000, 69, 'products/1765976840_pin-sac-du-phong-10000mah-type-c-pd-qc-3-0-33w-xiaomi-pb1033mi-thumb-638730682186329587-600x600.png', '2025-12-17 13:05:50', '2025-12-17 13:07:20'),
(27, 4, 4, 'Giá đỡ laptop N314', 'Giá đỡ laptop N314 là loại giá đỡ bằng hợp kim nhôm, thiết kế gấp gọn, có nhiều mức độ (thường 6-7 nấc) điều chỉnh độ cao theo chuẩn công thái học để giảm mỏi cổ vai lưng, có đệm silicone chống trượt và bề mặt thoáng khí giúp tản nhiệt, phù hợp với nhiều dòng laptop 11-15 inch, vừa tiện lợi di chuyển, vừa chắc chắn. \r\nĐặc điểm nổi bật:\r\nChất liệu: Hợp kim nhôm bền chắc, nhẹ, tản nhiệt tốt.\r\nThiết kế: Gấp gọn, di động, dễ dàng mang theo, chiếm ít không gian.\r\nĐiều chỉnh: 6-7 cấp độ nâng cao, tối ưu góc nhìn, giảm căng thẳng cho cổ, vai, gáy.\r\nTản nhiệt: Bề mặt có lỗ thoáng khí, kết hợp chất liệu nhôm giúp máy tính mát hơn.\r\nChống trượt: Có đệm silicone ở các điểm tiếp xúc để giữ laptop ổn định, chống trầy xước.\r\nTương thích: Hỗ trợ laptop có kích thước 11-15 inch và cả máy tính bảng/điện thoại. \r\nCông dụng:\r\nNâng cao màn hình laptop ngang tầm mắt, cải thiện tư thế ngồi làm việc, tránh gù lưng.\r\nHỗ trợ lưu thông không khí, giúp laptop không bị quá nóng khi sử dụng lâu.\r\nLý tưởng cho làm việc tại nhà, văn phòng, quán cafe hoặc khi di chuyển. ', 119000, 200, 'products/1765978255_shopping.webp', '2025-12-17 13:30:55', '2025-12-17 13:30:55'),
(28, 4, 2, 'Tai nghe bluetooth', 'Tai nghe Bluetooth là thiết bị âm thanh không dây kết nối với điện thoại, laptop qua sóng Bluetooth, cho phép nghe nhạc, gọi điện thoải mái, không vướng dây, thường có thiết kế đa dạng (nhét tai, chụp tai), tích hợp mic, nút điều khiển, pin sạc, chống ồn, và có thể kết nối nhiều thiết bị cùng lúc, mang lại sự tiện lợi và hiện đại cho người dùng. \r\nĐặc điểm chính\r\nKết nối không dây: Sử dụng công nghệ Bluetooth (sóng radio) thay vì dây cáp, giúp người dùng di chuyển tự do.\r\nĐa dạng kiểu dáng: Có nhiều loại như In-ear (nhét tai), On-ear (đeo ngoài), Over-ear (trùm tai).\r\nTích hợp tính năng: Tích hợp mic để đàm thoại, nút điều khiển (âm lượng, bài hát, nhận cuộc gọi), trợ lý ảo.\r\nPin sạc: Sử dụng pin sạc (thường là Li-ion), thời lượng sử dụng ngày càng được cải thiện.\r\nChống ồn & kháng nước: Nhiều mẫu có công nghệ chống ồn (ANC) và kháng nước/mồ hôi (IPX).\r\nTương thích rộng: Kết nối dễ dàng với hầu hết các thiết bị có Bluetooth (điện thoại, máy tính bảng, laptop). \r\nCấu tạo cơ bản\r\nVỏ ngoài (Housing): Bảo vệ linh kiện.\r\nDriver (Củ loa): Tái tạo âm thanh.\r\nPin sạc: Cung cấp năng lượng.\r\nMạch điều khiển (Chip Bluetooth): Xử lý kết nối không dây.\r\nMicro: Thu âm.\r\nĂng-ten: Truyền/nhận tín hiệu. \r\nƯu điểm nổi bật\r\nTiện lợi: Không bị vướng víu, dễ dàng mang theo.\r\nLinh hoạt: Kết nối được nhiều thiết bị, tự kết nối lại.\r\nHiện đại: Nhiều tính năng thông minh, trải nghiệm âm thanh tốt (với các công nghệ như aptX). ', 1345000, 34, 'products/1765978581_download.jpg', '2025-12-17 13:36:21', '2025-12-17 13:36:21'),
(29, 5, 3, 'HUAWEI Watch Fit 4', 'HUAWEI Watch Fit 4 là đồng hồ thông minh thiết kế &#34;Fashion Active&#34; siêu nhẹ, màn hình AMOLED 1.82 inch sắc nét, hỗ trợ hơn 100+ chế độ luyện tập, theo dõi sức khỏe toàn diện (nhịp tim, SpO2, giấc ngủ, stress), kháng nước 5ATM, pin 10 ngày, sạc nhanh và kết nối đa năng (Android/iOS), mang lại sự kết hợp giữa phong cách thanh lịch, tiện ích và tính năng thể thao chuyên nghiệp. \r\nThiết kế & Màn hình\r\nMàn hình: AMOLED 1.82 inch, độ sáng cao, hiển thị rõ ngoài trời.\r\nChất liệu: Khung hợp kim nhôm, siêu nhẹ (khoảng 27g), thoải mái đeo cả ngày.\r\nPhong cách: Thiết kế vuông vắn hiện đại, đa dạng màu sắc dây đeo và mặt đồng hồ tùy biến. \r\nTính năng Sức khỏe & Thể thao\r\nTheo dõi sức khỏe: Nhịp tim (TruSense), SpO2 liên tục, giấc ngủ (TruSleep™), căng thẳng, sức khỏe cảm xúc (với thú cưng minh họa).\r\nLuyện tập: Hơn 100 chế độ, tự động nhận diện hoạt động, phân tích tư thế chạy, hỗ trợ bơi lội.\r\nĐịnh vị: 5 hệ thống định vị (GPS, GLONASS,...) và băng tần kép cho độ chính xác cao.\r\nỨng dụng: Stay Fit (theo dõi calo) tích hợp trên đồng hồ. \r\nPin & Kết nối\r\nThời lượng pin: Tối đa 10 ngày, sử dụng thường xuyên 7 ngày (tùy cài đặt).\r\nSạc: Hỗ trợ sạc nhanh tiện lợi.\r\nKết nối: Bluetooth 5.2, tương thích Android & iOS, nhận thông báo cuộc gọi/tin nhắn. \r\nKhác\r\nKháng nước: 5ATM, an toàn khi bơi lội.\r\nPhiên bản Pro: Có thêm tính năng cao cấp (ví dụ: sạc không dây, vật liệu cao cấp hơn). \r\nTóm lại\r\nHUAWEI Watch Fit 4 là lựa chọn toàn diện cho người dùng hiện đại, yêu thích thể thao, quan tâm đến sức khỏe và muốn một thiết bị thời trang, đa năng, pin bền bỉ. ', 2990000, 54, 'products/1765979348_lovepik-intelligent-watch-png-image_400948724_wh860.png', '2025-12-17 13:47:55', '2025-12-17 13:51:25'),
(30, 5, 2, 'Samsung Galaxy Watch 8', 'Samsung Galaxy Watch 8 (mã L330, bản 44mm, Bluetooth) là đồng hồ thông minh cao cấp với thiết kế mỏng nhẹ (chỉ 8.6mm), màn hình Super AMOLED 1.47 inch siêu sáng 3000 nits, kính Sapphire bền bỉ, chip Exynos W1000 mạnh mẽ, chạy One UI 8 Watch, hỗ trợ theo dõi sức khỏe toàn diện (ECG, SpO2, huyết áp, giấc ngủ), kháng nước 5ATM/IP68, pin ~40 giờ và nhiều tính năng AI tiện lợi, kết nối ổn định qua Bluetooth 5.3. \r\nThiết kế & Màn hình\r\nThiết kế: Mỏng nhẹ, thanh lịch với khung nhôm nguyên khối và kính Sapphire chống xước, dáng tròn cổ điển nhưng hiện đại.\r\nKích thước: 44mm, phù hợp cổ tay vừa và lớn, trọng lượng nhẹ (khoảng 33.8g).\r\nMàn hình: Super AMOLED 1.47 inch, độ phân giải 480x480, độ sáng đỉnh 3000 nits cho hiển thị rõ nét dưới nắng. \r\nHiệu năng & Kết nối\r\nChip: Exynos W1000 3nm mạnh mẽ, RAM 2GB, xử lý mượt mà.\r\nHệ điều hành: One UI 8 Watch (trên nền Wear OS 6).\r\nKết nối: Bluetooth 5.3, NFC. \r\nSức khỏe & Thể thao\r\nCảm biến: ECG, SpO2, huyết áp, nhiệt độ cơ thể, BIA (phân tích thành phần cơ thể).\r\nTheo dõi: Giấc ngủ, mức độ stress, hơn 90 bài tập thể thao, tính năng huấn luyện chạy bộ.\r\nChống nước: 5ATM / IP68, thoải mái bơi lội. \r\nTính năng nổi bật\r\nSạc: Sạc nhanh không dây (80% trong 45 phút).\r\nPin: Khoảng 40 giờ sử dụng (tắt Always-On).\r\nAI: Gợi ý trả lời tin nhắn, trợ lý ảo (Bixby/Google Assistant) điều khiển bằng giọng nói.\r\nAn toàn: Phát hiện té ngã, gửi SOS khẩn cấp.\r\nLưu trữ: 32GB bộ nhớ trong. ', 6999000, 23, 'products/1765979441_1752221208053_samsung_galaxy_watch8_l330_44mm_didongviet.avif', '2025-12-17 13:50:41', '2025-12-17 13:50:41'),
(31, 6, 2, 'Marshall Willen II', 'Marshall Willen II là loa Bluetooth di động siêu nhỏ gọn, bền bỉ (IP67), pin 17+ giờ, kết nối Bluetooth 5.3 hỗ trợ Auracast, mang âm thanh mạnh mẽ đặc trưng Marshall với chất âm cân bằng, dải bass sâu hơn nhờ cải tiến bên trong, có mic thoại rảnh tay, làm từ vật liệu tái chế, lý tưởng cho mọi chuyến đi và hoạt động ngoài trời. \r\nĐặc điểm nổi bật\r\nÂm thanh mạnh mẽ: Dù nhỏ gọn (chỉ 0.36kg), loa có công suất 10W, âm thanh rõ ràng, chi tiết với dải trầm sâu hơn nhờ thiết kế cải tiến so với phiên bản trước, mang chất âm đặc trưng của Marshall.\r\nThiết kế siêu di động & bền bỉ: Kích thước nhỏ gọn (100.5 x 100.5 x 43.4 mm), dễ dàng mang theo. Chuẩn chống nước/bụi IP67 giúp hoạt động tốt ở bãi biển, hồ bơi hoặc mưa.\r\nThân thiện môi trường: Sử dụng 70% nhựa tái chế từ rác thải điện tử và đĩa CD, không chứa PVC.\r\nPin &#34;khủng&#34;: Hơn 17 giờ phát nhạc liên tục sau 2.5 giờ sạc đầy, lý tưởng cho cả ngày dài.\r\nKết nối hiện đại: Bluetooth 5.3 LE Audio và Auracast, kết nối đa thiết bị và chuyển đổi mượt mà.\r\nTiện ích: Tích hợp micrô, cho phép nhận/từ chối cuộc gọi rảnh tay ngay trên loa. Có nút điều khiển đa năng và thanh báo pin tiện lợi. \r\nThông số kỹ thuật chính\r\nCông suất: 10W\r\nDải tần: 75 - 20.000 Hz\r\nTrọng lượng: 0.36 kg\r\nPin: ~17+ giờ\r\nThời gian sạc: 2.5 giờ\r\nChống nước: IP67\r\nBluetooth: 5.3 LE Audio \r\nTổng kết\r\nMarshall Willen II là sự kết hợp hoàn hảo giữa thiết kế nhỏ gọn, phong cách retro đặc trưng, chất lượng âm thanh vượt trội và độ bền cao, là người bạn đồng hành đáng tin cậy cho mọi nhu cầu nghe nhạc di động, từ bàn làm việc, dã ngoại đến các chuyến đi xa. ', 2700000, 47, 'products/1765979727_1741580483875_loa_marshall_wilen_ii_didongviet.avif', '2025-12-17 13:55:27', '2025-12-17 13:55:27'),
(32, 6, 8, 'Sennheiser Momentum 4', 'Sennheiser Momentum 4 (Wireless) là tai nghe chụp tai cao cấp nổi bật với thiết kế hiện đại, siêu nhẹ, mang lại sự thoải mái tối đa và thời lượng pin ấn tượng lên tới 60 giờ, kết hợp công nghệ chống ồn chủ động (ANC) thích ứng, âm thanh chi tiết chuẩn Audiophile nhờ driver 42mm, hỗ trợ nhiều codec (aptX Adaptive) và kết nối đa điểm, lý tưởng cho cả công việc văn phòng và giải trí di động. \r\nThiết kế & Thoải mái\r\nPhong cách: Trẻ trung, tối giản, sang trọng và tinh tế.\r\nChất liệu: Cực kỳ nhẹ, với headband và đệm tai mềm mại, dày dặn, tạo cảm giác êm ái, không gây áp lực khi đeo lâu.\r\nCơ chế: Bản lề ma sát thấp, dễ dàng điều chỉnh phù hợp với nhiều kích cỡ đầu. \r\nÂm thanh & Công nghệ\r\nDriver: Củ loa 42mm, mang lại âm thanh sâu, chi tiết và động lực cao.\r\nChống ồn (ANC): Adaptive Noise Cancelling (ANC thích ứng) điều chỉnh theo môi trường, loại bỏ tiếng ồn hiệu quả.\r\nÂm thanh xung quanh (Transparency Mode): Cho phép nghe môi trường xung quanh.\r\nCodec hỗ trợ: SBC, AAC, aptX™️, aptX adaptive™️, đảm bảo chất lượng âm thanh cao. \r\nKết nối & Pin\r\nBluetooth: Phiên bản 5.2, kết nối ổn định và nhanh chóng.\r\nKết nối đa điểm: Ghép nối cùng lúc 2 thiết bị (điện thoại & máy tính).\r\nPin: Lên đến 60 giờ (Bluetooth + ANC), sạc đầy trong 2 giờ; sạc nhanh 5 phút cho 4 giờ sử dụng (qua USB-C). \r\nTính năng khác\r\nMicro: Hệ thống 2 micro mỗi bên (MEMS) với công nghệ beamforming, cho chất lượng đàm thoại rõ ràng.\r\nỨng dụng: Sennheiser Smart Control, tùy chỉnh EQ và tính năng âm thanh.\r\nTrợ lý ảo: Hỗ trợ Google Assistant, Siri. \r\nTóm lại: Momentum 4 Wireless là lựa chọn lý tưởng cho người dùng tìm kiếm sự kết hợp giữa thiết kế cao cấp, sự thoải mái tuyệt vời, thời lượng pin &#34;khủng&#34; và chất âm đặc trưng của Sennheiser, rất phù hợp cho công việc, di chuyển và giải trí hàng ngày. ', 6590000, 32, 'products/1765979861_1742799970423_1741578428895_tai_nghe_sennheiser_momentum_4_didongviet.avif', '2025-12-17 13:57:41', '2025-12-17 13:57:41'),
(33, 6, 10, 'JBL Live 670NC', 'Tai nghe chụp tai Bluetooth JBL Live 670NC là mẫu tai nghe không dây cao cấp của JBL, nổi bật với công nghệ Chống ồn chủ động thích ứng (ANC), chất âm JBL Signature Sound mạnh mẽ từ củ loa 40mm, kết nối Bluetooth 5.3 đa điểm (kết nối 2 thiết bị cùng lúc) và thời lượng pin khủng lên đến 65 giờ (50 giờ khi bật ANC), hỗ trợ sạc nhanh 5 phút cho 4 giờ nghe. Thiết kế gọn nhẹ, thoải mái cùng ứng dụng JBL Headphones tùy biến EQ và các tính năng như Smart Ambient (Ambient Aware/TalkThru) và hỗ trợ trợ lý ảo, mang đến trải nghiệm âm thanh sống động, tập trung và linh hoạt cho giải trí, học tập và làm việc. \r\nĐiểm nổi bật:\r\nChất âm JBL: Âm thanh sống động, bass mạnh mẽ đặc trưng của JBL nhờ củ loa 40mm và công nghệ Personi-Fi 2.0.\r\nChống ồn chủ động (ANC): Tự động thích ứng để loại bỏ tiếng ồn, giúp bạn tập trung.\r\nSmart Ambient (Ambient Aware & TalkThru): Nghe rõ âm thanh xung quanh hoặc giọng nói mà không cần tháo tai nghe.\r\nThời lượng pin dài: 65 giờ (BT) / 50 giờ (BT+ANC), có sạc nhanh.\r\nKết nối tiện lợi: Bluetooth 5.3, kết nối 2 thiết bị cùng lúc (Multi-point).\r\nMicro chất lượng: 2 micro cho cuộc gọi rõ ràng, giảm tiếng ồn.\r\nĐiều khiển & Ứng dụng: Phím vật lý tiện lợi, tùy chỉnh sâu qua ứng dụng JBL Headphones (EQ, cài đặt).\r\nThiết kế: Nhẹ nhàng, thoải mái (on-ear), có nhiều màu sắc. \r\nThông số kỹ thuật chính:\r\n** driver:** 40mm.\r\nBluetooth: 5.3 (hỗ trợ LE Audio).\r\nCổng sạc: Type-C.\r\nKhối lượng: Khoảng 217g. \r\nJBL Live 670NC là lựa chọn lý tưởng cho người dùng muốn trải nghiệm âm thanh chất lượng cao, chống ồn hiệu quả và pin trâu trong một thiết kế hiện đại, thoải mái, phù hợp mọi hoạt động. ', 2690000, 54, 'products/1765980000_1741686032906_tai_nghe_jbl_live_670nc_didongviet.avif', '2025-12-17 14:00:00', '2025-12-17 14:00:00'),
(34, 6, 6, 'Acefast Crystal T8', 'Tai nghe Acefast Crystal T8 là dòng tai nghe True Wireless trong suốt, nổi bật với thiết kế độc đáo, màn hình LED hiển thị pin 3D, sử dụng chip BES2600IHC Bluetooth 5.3, âm thanh ổn định (SBC/AAC), hỗ trợ chống nước IPX4, thời lượng pin khá (khoảng 7 giờ nghe nhạc), và điều khiển cảm ứng toàn diện trên tai nghe, mang lại trải nghiệm tốt trong tầm giá, dù chất lượng micro khi gọi điện chưa tối ưu. \r\nĐặc điểm nổi bật:\r\nThiết kế trong suốt: Thân tai nghe và dock sạc trong suốt (có nhiều màu tùy chọn), tạo vẻ ngoài &#34;cool ngầu&#34; và độc đáo.\r\nMàn hình LED 3D: Dock sạc có màn hình kỹ thuật số hiển thị dung lượng pin chính xác, có hiệu ứng ánh sáng &#34;breathing light&#34;.\r\nÂm thanh & Kết nối:\r\nChip BES2600IHC, Bluetooth 5.3 cho kết nối ổn định, độ trễ thấp.\r\nDriver 13mm, hỗ trợ codec SBC/AAC.\r\nCông nghệ giảm tiếng ồn cuộc gọi SVE AI (nhưng micro có hạn chế).\r\nPin & Sạc:\r\nTai nghe: Khoảng 7 giờ nghe nhạc (âm lượng 70%).\r\nDock sạc (500mAh): Cho tổng thời gian lên đến 30 giờ.\r\nSạc nhanh: 10 phút sạc cho 2 giờ sử dụng.\r\nCổng sạc USB-C.\r\nTính năng tiện ích:\r\nChống nước IPX4 (chống mồ hôi, mưa nhỏ).\r\nĐiều khiển cảm ứng toàn diện (tăng/giảm âm lượng, next/prev bài, tạm dừng, từ chối/trả lời cuộc gọi, kích hoạt trợ lý ảo, chế độ game). \r\nƯu điểm:\r\nThiết kế đẹp, độc lạ, bắt mắt.\r\nChất âm và khả năng kết nối tốt trong phân khúc.\r\nThời lượng pin ấn tượng.\r\nNhiều tính năng điều khiển đầy đủ. \r\nHạn chế:\r\nChất lượng micro cuộc gọi chưa thực sự xuất sắc, âm thanh có thể bị bóp méo.\r\nKích thước dock sạc không quá nhỏ gọn (khó bỏ túi quần jean). \r\nTóm lại, Acefast Crystal T8 là lựa chọn tuyệt vời nếu bạn ưu tiên thiết kế, thời lượng pin và tính năng đầy đủ, chấp nhận được hạn chế về chất lượng micro khi đàm thoại. ', 649000, 52, 'products/1765980111_1744274560439_tai_nghe_truewireless_acefast_crystal_t8_didongviet.avif', '2025-12-17 14:01:51', '2025-12-17 14:01:51'),
(35, 10, 5, 'VSP IP2510W1', 'Màn hình VSP IP2510W1 là màn hình phẳng 24.5 inch Full HD (1920x1080) sử dụng tấm nền IPS cho màu sắc sống động và góc nhìn rộng, nổi bật với tần số quét 100Hz và thời gian phản hồi 5ms, mang lại trải nghiệm hình ảnh mượt mà, giảm giật lag khi chơi game hoặc làm việc. Màn hình có thiết kế viền mỏng, kết nối đa dạng (HDMI, VGA) và tích hợp loa nhỏ, phù hợp cho cả văn phòng lẫn giải trí cơ bản. \r\nĐặc điểm nổi bật:\r\nKích thước & Độ phân giải: 24.5 inch, Full HD (1920x1080).\r\nTấm nền: IPS/WLED cho màu sắc chân thực và góc nhìn rộng (178°/178°).\r\nTần số quét: 100Hz, giúp hình ảnh chuyển động nhanh mượt mà hơn.\r\nThời gian phản hồi: 5ms (OD), giảm hiện tượng bóng mờ.\r\nĐộ sáng: 280 cd/m².\r\nĐộ tương phản: 1000:1.\r\nMàu sắc: Phủ 100% sRGB, cho màu sắc sống động.\r\nThiết kế: Phẳng, viền mỏng 3 cạnh, chân đế chắc chắn, hỗ trợ VESA 100x100mm.\r\nKết nối: 1x HDMI, 1x VGA, 1x Audio out.\r\nÂm thanh: Tích hợp loa 3W. \r\nƯu điểm:\r\nHiệu năng tốt: Tần số quét 100Hz và 5ms response time mang lại trải nghiệm chơi game/xem phim tốt trong phân khúc.\r\nChất lượng hình ảnh: Tấm nền IPS và độ phủ màu 100% sRGB cho hình ảnh đẹp, chi tiết.\r\nThiết kế hiện đại: Viền mỏng, phù hợp nhiều không gian.\r\nĐa dụng: Phù hợp cho công việc văn phòng, giải trí và chơi game cơ bản. \r\nĐối tượng phù hợp:\r\nNgười dùng cần màn hình có hình ảnh đẹp, mượt mà cho giải trí và công việc văn phòng.\r\nGame thủ không yêu cầu tần số quét quá cao (trên 144Hz). ', 1690000, 44, 'products/1765980684_images.jpg', '2025-12-17 14:04:54', '2025-12-17 14:12:55'),
(36, 10, 5, 'HKC ANTTEQ ', 'Màn hình HKC ANTTEQ ANT-27F270 là màn hình cong 27 inch Full HD (1920x1080) dùng tấm nền VA, có tần số quét 75Hz, mang lại trải nghiệm hình ảnh sống động, chiều sâu cho game thủ và người dùng phổ thông với giá phải chăng, hỗ trợ kết nối đa dạng (VGA, HDMI) và đi kèm phụ kiện đầy đủ (cáp HDMI, adapter). \r\nThông số kỹ thuật chính:\r\nKích thước: 27 inch.\r\nTấm nền: VA, cong (R1800).\r\nĐộ phân giải: Full HD (1920x1080).\r\nTần số quét: 75Hz.\r\nThời gian đáp ứng: 8ms (GTG).\r\nGóc nhìn: Rộng (178°/178°).\r\nĐộ tương phản: 3000:1.\r\nMàu sắc: 16.7 triệu màu.\r\nKết nối: VGA, HDMI, Audio out.\r\nPhụ kiện: Cáp HDMI, nguồn, adapter.\r\nTính năng khác: Flicker-Free, Blue Light Filter, Free-Sync. \r\nĐiểm nổi bật:\r\nTrải nghiệm cong 1800R: Tạo cảm giác đắm chìm, sâu hơn khi xem phim và chơi game.\r\nTấm nền VA: Cung cấp màu sắc tốt và độ tương phản cao, chống chói hiệu quả.\r\nTần số quét 75Hz: Xử lý chuyển động nhanh mượt mà hơn màn hình 60Hz thông thường.\r\nGiá tốt: Là lựa chọn kinh tế cho màn hình cong 27 inch Full HD. \r\nTình trạng: Hàng mới (New Full Box), nguyên hộp, có bảo hành. ', 4050000, 65, 'products/1765981096_270.png', '2025-12-17 14:18:16', '2025-12-17 14:18:16'),
(37, 1, 1, 'iphone 17', 'iPhone 17 là dòng điện thoại thông minh mới nhất của Apple, nổi bật với chip A19/A19 Pro, màn hình ProMotion 120Hz siêu mượt, hệ thống camera 48MP với công nghệ Dual Fusion, và tích hợp sâu Apple Intelligence AI, mang đến hiệu năng mạnh mẽ, trải nghiệm hình ảnh sống động và tính năng thông minh vượt trội, đi kèm thiết kế khung nhôm (bản thường) hoặc titan (bản Pro) và iOS 19 tối ưu. \r\nĐiểm nổi bật của iPhone 17 (bản thường):\r\nMàn hình: Super Retina XDR 6.3 inch, ProMotion 120Hz, độ sáng 3000 nits, Dynamic Island, Always-On.\r\nHiệu năng: Chip A19 mạnh mẽ, tối ưu cho AI và game.\r\nCamera: Hệ thống camera kép 48MP Dual Fusion, camera trước 18MP Center Stage.\r\nThiết kế: Khung nhôm nguyên khối, bền bỉ hơn.\r\nPin: Thời lượng xem video lên đến 30 giờ.\r\nKết nối: USB-C, Wi-Fi 7. \r\nĐiểm nổi bật của iPhone 17 Pro/Pro Max:\r\nChip: A19 Pro, mạnh hơn bản thường, với Neural Engine 16 lõi.\r\nThiết kế: Khung titan (Pro Max) hoặc nhôm (Pro), bền chắc.\r\nCamera: Camera trước 18MP, camera sau 3 camera Fusion 48MP.\r\nPin: Pin trâu hơn, Pro Max xem video đến 39 giờ.\r\nTính năng: Nút Tác Vụ, Điều Khiển Camera, hỗ trợ Apple Intelligence sâu hơn. \r\nTính năng chung (iOS 19 & Apple Intelligence):\r\nApple Intelligence: AI tích hợp giúp viết lại, tóm tắt, tạo ảnh, nâng cao Siri.\r\nHệ điều hành: iOS 19 với giao diện Liquid Glass mới.\r\nSạc: Cổng USB-C, sạc nhanh.\r\nChống nước: IP68. ', 35000000, 45, 'products/1765981662_1765981613_iphone-17-pro-256-gb_1-removebg-preview.png', '2025-12-17 14:26:53', '2025-12-17 14:27:42'),
(38, 1, 1, 'Iphone 15 Promax', 'iPhone 15 Pro Max là flagship cao cấp của Apple, nổi bật với thiết kế khung viền Titanium siêu nhẹ và bền, màn hình Super Retina XDR 6.7 inch mượt mà 120Hz, chip A17 Pro mạnh mẽ cho hiệu năng đồ họa đỉnh cao, hệ thống camera Pro 48MP với zoom quang học 5x ấn tượng, nút Tác Vụ (Action Button) tùy biến, và chuyển sang cổng sạc USB-C tốc độ cao. \r\nĐiểm nổi bật:\r\nThiết kế: Khung viền Titan cấp độ hàng không vũ trụ (Grade 5 Titanium), nhẹ hơn và sang trọng hơn các thế hệ trước. Viền bo cong nhẹ, mặt lưng kính nhám.\r\nMàn hình: 6.7 inch, Super Retina XDR OLED, ProMotion (tần số quét thích ứng 120Hz), Dynamic Island, độ sáng cao, Always-On Display.\r\nHiệu năng: Chip A17 Pro (3nm) 6 nhân CPU, 6 nhân GPU, 8GB RAM. Hiệu năng đồ họa vượt trội, hỗ trợ Ray Tracing (dò tia) cho game.\r\nCamera: Hệ thống camera Pro 48MP (chính), zoom quang 5x (thấu kính tiềm vọng). Quay video chuyên nghiệp, chụp ảnh thiếu sáng tốt.\r\nCổng kết nối: USB-C hỗ trợ USB 3, cho tốc độ truyền dữ liệu 10Gbps.\r\nTính năng mới: Nút Tác Vụ (Action Button) thay thế cần gạt im lặng, cho phép tùy chỉnh chức năng nhanh chóng. Hỗ trợ eSIM tiện lợi.\r\nPin: Thời lượng pin sử dụng lâu dài, lên đến 29 giờ phát video. \r\nTóm lại, iPhone 15 Pro Max là một bước tiến lớn về vật liệu, hiệu năng xử lý, khả năng nhiếp ảnh (đặc biệt là zoom) và tiện ích (USB-C, Nút Tác Vụ), hướng tới người dùng chuyên nghiệp và yêu thích công nghệ cao cấp. ', 24500000, 56, 'products/1765981790_iphone-15-pro-max-blue-thumbnew-600x600.jpg', '2025-12-17 14:29:50', '2025-12-17 14:29:50');
INSERT INTO `products` (`id`, `category_id`, `brand_id`, `name`, `description`, `price`, `stock`, `image`, `created_at`, `updated_at`) VALUES
(39, 1, 1, 'iPhone 16 Pro Max', 'iPhone 16 Pro Max là một flagship cao cấp với thiết kế khung titan siêu bền, màn hình OLED 6.9 inch lớn nhất từ trước đến nay, tần số quét ProMotion 120Hz siêu mượt, chip A18 Pro mạnh mẽ, hệ thống camera 48MP chuyên nghiệp (chính, siêu rộng, tele 5x), thời lượng pin dài, và nhiều tính năng mới như nút Điều Khiển Camera (Capture Button). \r\nThiết kế & Màn hình\r\nChất liệu: Khung titan siêu bền, mặt lưng kính nhám, mặt trước Ceramic Shield.\r\nMàn hình: Super Retina XDR 6.9 inch, công nghệ OLED, độ phân giải cao, Dynamic Island, Màn hình Luôn Bật, ProMotion 120Hz.\r\nViền màn hình: Cực mỏng, tạo cảm giác hiển thị rộng rãi, tinh tế. \r\nHiệu năng & Pin\r\nChip: A18 Pro mạnh mẽ, hiệu năng vượt trội cho gaming và tác vụ nặng.\r\nPin: Thời lượng xem video lên đến 33 giờ nhờ tối ưu hóa bên trong và chip tiết kiệm năng lượng.\r\nSạc: Hỗ trợ sạc nhanh qua USB-C. \r\nCamera\r\nCamera chính: 48MP (tiêu chuẩn) cho chi tiết sắc nét, khẩu độ f/1.8.\r\nCamera góc siêu rộng: 48MP, f/2.2, chụp ảnh chi tiết ấn tượng.\r\nCamera tele: 12MP, zoom quang 5x, OIS.\r\nQuay Video: 4K Dolby Vision ở 120 fps, chất lượng studio.\r\nCamera trước: 12MP, PDAF. \r\nTính năng nổi bật\r\nNút Điều Khiển Camera (Capture Button): Truy cập nhanh các chức năng như lấy nét, thu phóng, chụp ảnh.\r\nHệ điều hành: iOS 18.\r\nKết nối: Wi-Fi 7, 5G, USB-C 3.0.\r\nAn toàn: Phát Hiện Va Chạm (Crash Detection). \r\nCấu hình & Lưu trữ\r\nRAM: 8GB (có thể thay đổi).\r\nBộ nhớ: 256GB, 512GB, 1TB. \r\nTóm lại: iPhone 16 Pro Max là sự kết hợp giữa thiết kế titan sang trọng, màn hình lớn và sáng nhất, chip A18 Pro mạnh mẽ, hệ thống camera nâng cấp toàn diện, và thời lượng pin ấn tượng, mang lại trải nghiệm cao cấp và chuyên nghiệp. ', 30999000, 45, 'products/1765981934_0045512_iphone-16-pro-128gb.png', '2025-12-17 14:32:14', '2025-12-17 14:32:14'),
(40, 10, 4, 'Dell P2425H', 'Màn hình Dell P2425H là màn hình 23.8 inch, IPS, Full HD (1920x1080) với tần số quét 100Hz và thời gian phản hồi 5ms, mang lại hình ảnh sắc nét, màu sắc chính xác (99% sRGB) và chuyển động mượt mà, rất phù hợp cho văn phòng, thiết kế và giải trí nhẹ nhàng; nổi bật với công nghệ ComfortView Plus giảm ánh sáng xanh, thiết kế viền mỏng InfinityEdge và chân đế công thái học linh hoạt. \r\nĐặc điểm nổi bật:\r\nKích thước & Độ phân giải: 23.8 inch, Full HD (1920x1080).\r\nTấm nền & Màu sắc: IPS cho góc nhìn rộng, màu sắc sống động, độ phủ màu 99% sRGB, hiển thị 16.7 triệu màu.\r\nHiệu suất: Tần số quét 100Hz và thời gian phản hồi 5ms giúp cuộn trang mượt mà, giảm mờ nhòe, phù hợp cho đa nhiệm và xem video.\r\nThoải mái cho mắt: Công nghệ ComfortView Plus giảm ánh sáng xanh có hại (≤35%) mà vẫn giữ màu sắc chính xác, cùng thiết kế chống nhấp nháy.\r\nThiết kế & Công thái học: Viền siêu mỏng (InfinityEdge), chân đế điều chỉnh độ cao, xoay, nghiêng, giúp tối ưu không gian và tư thế làm việc.\r\nKết nối: Đa dạng cổng HDMI, DisplayPort (DP), VGA và có cả cổng USB-C (chỉ dữ liệu 15W PD).\r\nPhân khúc: Màn hình văn phòng chuyên nghiệp (Dell Pro) đáng giá trong tầm giá. \r\nPhù hợp cho:\r\nNgười dùng văn phòng, lập trình viên, nhà thiết kế đồ họa cơ bản.\r\nNgười dùng muốn trải nghiệm hình ảnh mượt mà hơn so với màn hình 60Hz truyền thống.\r\nAi cần một màn hình có tính năng bảo vệ mắt và thiết kế công thái học tốt. ', 4450000, 22, 'products/1765982050_image-removebg-preview.png', '2025-12-17 14:34:10', '2025-12-17 14:34:10'),
(41, 10, 3, 'Xiaomi G34WQi', 'Màn hình cong Gaming Xiaomi G34WQi (hoặc G34I) là màn hình 34 inch Ultrawide, độ phân giải WQHD (3440x1440), tần số quét 180Hz, thời gian phản hồi 1ms, tấm nền VA, cong 1500R, hỗ trợ FreeSync Premium, bao phủ màu rộng (95% DCI-P3/100% sRGB) và có tính năng bảo vệ mắt, mang đến trải nghiệm game mượt mà, sống động và chân thực. \r\nĐặc điểm nổi bật:\r\nKích thước & Thiết kế: Màn hình 34 inch, cong 1500R, tỷ lệ 21:9, viền mỏng, mang đến không gian làm việc và chơi game rộng lớn, bao quát.\r\nHiệu năng Gaming:\r\nTần số quét 180Hz, thời gian phản hồi 1ms (MPRT) cho hình ảnh cực kỳ mượt mà, giảm thiểu nhòe hình trong game tốc độ cao.\r\nCông nghệ AMD FreeSync Premium chống xé hình, đảm bảo sự đồng bộ giữa card đồ họa và màn hình.\r\nChất lượng hình ảnh:\r\nĐộ phân giải 3K (WQHD), sắc nét, chi tiết cao.\r\nDải màu rộng (95% DCI-P3, 100% sRGB), màu sắc rực rỡ, sống động, độ chính xác màu cao (ΔE', 6850000, 75, 'products/1765982176_image-removebg-preview (1).png', '2025-12-17 14:35:55', '2025-12-17 14:36:16'),
(42, 7, 6, 'Canon G9X', 'Canon G9X (và bản nâng cấp G9X Mark II) là dòng máy ảnh compact siêu nhỏ gọn, bỏ túi với cảm biến 1-inch lớn cho chất lượng ảnh vượt trội điện thoại, kết hợp thiết kế thời trang, mỏng nhẹ, màn hình cảm ứng, cùng kết nối Wi-Fi/Bluetooth tiện lợi để chia sẻ, phù hợp cho người dùng cần sự cơ động và ảnh đẹp, dễ dùng, có phiên bản Mark II cải thiện tốc độ xử lý đáng kể với bộ xử lý DIGIC 7. \r\nĐiểm nổi bật của Canon G9X và G9X Mark II:\r\nThiết kế & Tính di động:\r\nRất nhỏ gọn, mỏng nhẹ, dễ dàng bỏ túi, lý tưởng để mang theo hàng ngày.\r\nThiết kế phong cách, hiện đại (có màu đen, bạc).\r\nGiao diện trực quan, điều khiển qua màn hình cảm ứng và vòng điều khiển (Control Ring).\r\nChất lượng hình ảnh:\r\nCảm biến CMOS 1-inch 20.1MP (G9X II) / 20.2MP (G9X): Lớn hơn cảm biến compact thông thường, cho ảnh sắc nét, chi tiết, hiệu suất tốt trong điều kiện ánh sáng yếu.\r\nỐng kính Zoom quang học 3x (tương đương 28-84mm), khẩu độ F/2.0-4.9, có chống rung quang học (IS).\r\nXử lý màu sắc và chi tiết tốt.\r\nHiệu suất:\r\nG9X Mark II (với DIGIC 7): Nhanh hơn, bộ nhớ đệm lớn hơn, tốc độ chụp liên tiếp cải thiện so với bản gốc (G9X có DIGIC 6).\r\nQuay video Full HD 1080p lên tới 60fps, nhưng không có 4K.\r\nKết nối & Tiện ích:\r\nTích hợp Wi-Fi, NFC, Bluetooth (trên Mark II).\r\nSạc pin qua cổng USB tiện lợi.\r\nHỗ trợ xử lý ảnh RAW ngay trong máy (trên Mark II). \r\nPhù hợp cho: Người dùng muốn nâng cấp chất lượng ảnh từ điện thoại nhưng vẫn cần sự gọn gàng, dễ sử dụng, chia sẻ nhanh chóng. \r\nĐiểm cần cân nhắc (đặc biệt với bản đầu): Tốc độ chụp liên tục và AF có thể chậm (đã cải thiện ở Mark II), không có kính ngắm điện tử/quang học, màn hình không lật.  (và bản nâng cấp G9X Mark II) là dòng máy ảnh compact siêu nhỏ gọn, bỏ túi với cảm biến 1-inch lớn cho chất lượng ảnh vượt trội điện thoại, kết hợp thiết kế thời trang, mỏng nhẹ, màn hình cảm ứng, cùng kết nối Wi-Fi/Bluetooth tiện lợi để chia sẻ, phù hợp cho người dùng cần sự cơ động và ảnh đẹp, dễ dùng, có phiên bản Mark II cải thiện tốc độ xử lý đáng kể với bộ xử lý DIGIC 7. \r\nĐiểm nổi bật của Canon G9X và G9X Mark II:\r\nThiết kế & Tính di động:\r\nRất nhỏ gọn, mỏng nhẹ, dễ dàng bỏ túi, lý tưởng để mang theo hàng ngày.\r\nThiết kế phong cách, hiện đại (có màu đen, bạc).\r\nGiao diện trực quan, điều khiển qua màn hình cảm ứng và vòng điều khiển (Control Ring).\r\nChất lượng hình ảnh:\r\nCảm biến CMOS 1-inch 20.1MP (G9X II) / 20.2MP (G9X): Lớn hơn cảm biến compact thông thường, cho ảnh sắc nét, chi tiết, hiệu suất tốt trong điều kiện ánh sáng yếu.\r\nỐng kính Zoom quang học 3x (tương đương 28-84mm), khẩu độ F/2.0-4.9, có chống rung quang học (IS).\r\nXử lý màu sắc và chi tiết tốt.\r\nHiệu suất:\r\nG9X Mark II (với DIGIC 7): Nhanh hơn, bộ nhớ đệm lớn hơn, tốc độ chụp liên tiếp cải thiện so với bản gốc (G9X có DIGIC 6).\r\nQuay video Full HD 1080p lên tới 60fps, nhưng không có 4K.\r\nKết nối & Tiện ích:\r\nTích hợp Wi-Fi, NFC, Bluetooth (trên Mark II).\r\nSạc pin qua cổng USB tiện lợi.\r\nHỗ trợ xử lý ảnh RAW ngay trong máy (trên Mark II). \r\nPhù hợp cho: Người dùng muốn nâng cấp chất lượng ảnh từ điện thoại nhưng vẫn cần sự gọn gàng, dễ sử dụng, chia sẻ nhanh chóng. \r\nĐiểm cần cân nhắc (đặc biệt với bản đầu): Tốc độ chụp liên tục và AF có thể chậm (đã cải thiện ở Mark II), không có kính ngắm điện tử/quang học, màn hình không lật. ', 12399000, 22, 'products/1765982442_image-removebg-preview.png', '2025-12-17 14:40:42', '2025-12-17 14:40:42'),
(43, 7, 5, 'Fujifilm Instax Mini 12 ', 'Fujifilm Instax Mini 12 (Pastel Blue) là máy ảnh chụp lấy liền nhỏ gọn, màu xanh pastel dễ thương, có thiết kế bo tròn như bong bóng, cực kỳ dễ dùng với một lần xoay ống kính để bật máy và chuyển sang chế độ chụp cận cảnh (selfie), có gương selfie tích hợp để căn chỉnh, đèn flash tự động giúp chụp ảnh đẹp mọi lúc, mọi nơi, lý tưởng cho người trẻ yêu thích chụp ảnh nhanh, tiện lợi. \r\nĐặc điểm nổi bật:\r\nThiết kế: Dáng &#34;bong bóng&#34; bo tròn, màu xanh Pastel Blue trẻ trung, hiện đại, nhỏ gọn, cầm nắm dễ dàng.\r\nThao tác đơn giản: Chỉ cần vặn ống kính để bật máy và chuyển chế độ chụp thông thường/cận cảnh.\r\nSelfie dễ dàng: Tích hợp gương selfie ngay cạnh ống kính, kết hợp với chế độ Close-up cho ảnh selfie nét căng, không bị mờ.\r\nPhơi sáng tự động: Tự động điều chỉnh tốc độ màn trập và công suất đèn flash phù hợp môi trường, cho ảnh rõ nét trong nhiều điều kiện sáng.\r\nChụp cận cảnh (Close-up): Chế độ chụp ở khoảng cách gần (tối thiểu 30cm) lý tưởng cho chân dung hoặc vật thể nhỏ.\r\nKích thước & Trọng lượng: Khoảng 104 x 66.6 x 122 mm, nặng 306g (chưa gồm pin, film, dây đeo).\r\nSử dụng Film: Fujifilm Instax Mini Instant Film. \r\nThích hợp cho:\r\nNgười mới bắt đầu sử dụng máy ảnh lấy liền.\r\nNhững ai yêu thích chụp ảnh nhanh, có ảnh in liền sau vài phút.\r\nCác buổi tiệc, du lịch, hoặc ghi lại khoảnh khắc đời thường một cách vui nhộn.\r\nNgười thích phong cách dễ thương, màu sắc pastel nhẹ nhàng, hiện đại.  (Pastel Blue) là máy ảnh chụp lấy liền nhỏ gọn, màu xanh pastel dễ thương, có thiết kế bo tròn như bong bóng, cực kỳ dễ dùng với một lần xoay ống kính để bật máy và chuyển sang chế độ chụp cận cảnh (selfie), có gương selfie tích hợp để căn chỉnh, đèn flash tự động giúp chụp ảnh đẹp mọi lúc, mọi nơi, lý tưởng cho người trẻ yêu thích chụp ảnh nhanh, tiện lợi. \r\nĐặc điểm nổi bật:\r\nThiết kế: Dáng &#34;bong bóng&#34; bo tròn, màu xanh Pastel Blue trẻ trung, hiện đại, nhỏ gọn, cầm nắm dễ dàng.\r\nThao tác đơn giản: Chỉ cần vặn ống kính để bật máy và chuyển chế độ chụp thông thường/cận cảnh.\r\nSelfie dễ dàng: Tích hợp gương selfie ngay cạnh ống kính, kết hợp với chế độ Close-up cho ảnh selfie nét căng, không bị mờ.\r\nPhơi sáng tự động: Tự động điều chỉnh tốc độ màn trập và công suất đèn flash phù hợp môi trường, cho ảnh rõ nét trong nhiều điều kiện sáng.\r\nChụp cận cảnh (Close-up): Chế độ chụp ở khoảng cách gần (tối thiểu 30cm) lý tưởng cho chân dung hoặc vật thể nhỏ.\r\nKích thước & Trọng lượng: Khoảng 104 x 66.6 x 122 mm, nặng 306g (chưa gồm pin, film, dây đeo).\r\nSử dụng Film: Fujifilm Instax Mini Instant Film. \r\nThích hợp cho:\r\nNgười mới bắt đầu sử dụng máy ảnh lấy liền.\r\nNhững ai yêu thích chụp ảnh nhanh, có ảnh in liền sau vài phút.\r\nCác buổi tiệc, du lịch, hoặc ghi lại khoảnh khắc đời thường một cách vui nhộn.\r\nNgười thích phong cách dễ thương, màu sắc pastel nhẹ nhàng, hiện đại. ', 7980000, 53, 'products/1765982516_image-removebg-preview (1).png', '2025-12-17 14:41:56', '2025-12-17 14:41:56'),
(44, 7, 6, 'Fujifilm Instax Mini 12', 'Máy ảnh Fujifilm Instax Mini 12 là dòng máy chụp ảnh lấy liền nhỏ gọn, trẻ trung, nổi bật với thiết kế bo tròn dễ cầm, sử dụng film Instax Mini và có các màu sắc pastel tươi sáng, tích hợp tính năng phơi sáng tự động (AE), đèn flash tự động, gương selfie và chế độ chụp cận cảnh (Close-up) dễ dàng chỉ bằng thao tác xoay ống kính, giúp người dùng lưu lại khoảnh khắc tức thì một cách đơn giản và tiện lợi. \r\nThiết kế & Ngoại hình:\r\nDáng vẻ: Thiết kế bo tròn mềm mại, vuông vức hơn phiên bản trước (Mini 11), mang lại cảm giác cầm nắm thoải mái.\r\nMàu sắc: 5 tùy chọn màu trẻ trung: Blossom Pink, Clay White, Lilac Purple, Mint Green, Pastel Blue.\r\nKích thước: Nhỏ gọn, dễ mang theo (khoảng 104 x 66.6 x 122 mm). \r\nTính năng chính:\r\nPhơi sáng tự động (AE) & Flash Tự động: Tự động điều chỉnh độ sáng và cường độ flash để có bức ảnh cân bằng, không bị dư sáng.\r\nChế độ Cận cảnh (Close-up): Chỉ cần xoay ống kính để kích hoạt, cho phép chụp vật thể trong khoảng 30-50 cm, lý tưởng cho selfie hoặc vật thể nhỏ.\r\nGương Selfie: Tích hợp ngay trên ống kính, giúp căn chỉnh khung hình khi chụp tự sướng.\r\nIn ảnh lấy liền: Sử dụng film Instax Mini, tốc độ in khoảng 12 giây/tấm.\r\nKính ngắm quang học: Hỗ trợ căn khung hình.\r\nNguồn: Dùng 2 pin AA. \r\nTrải nghiệm người dùng:\r\nĐơn giản: Thao tác sử dụng cực kỳ dễ dàng, phù hợp với người mới bắt đầu.\r\nLinh hoạt: Chụp ảnh và nhận ảnh ngay lập tức, lưu giữ kỷ niệm tức thì. \r\nTóm lại, Instax Mini 12 là một chiếc máy ảnh lấy liền dễ thương, dễ dùng, tự động hóa nhiều khâu để người dùng tập trung vào việc chụp những bức ảnh vui vẻ, sống động, đặc biệt là ảnh chân dung và selfie. ', 9600000, 54, 'products/1765982583_image-removebg-preview (2).png', '2025-12-17 14:43:03', '2025-12-17 14:43:03'),
(45, 7, 7, 'Fujifilm Instax Mini 12', 'Fujifilm Instax Mini 12 là máy ảnh lấy liền chính hãng, thiết kế tròn trịa, màu sắc tươi sáng, siêu dễ dùng với thao tác xoay ống kính đơn giản để bật máy và chuyển sang chế độ Cận cảnh/Selfie, tích hợp gương selfie và đèn flash tự động, tự động cân bằng sáng, cho ảnh in tức thì cỡ thẻ tín dụng, lý tưởng để lưu giữ khoảnh khắc vui vẻ một cách nhanh chóng, độc đáo. \r\nĐặc điểm nổi bật\r\nThiết kế: Nhỏ gọn, bo tròn mềm mại với 5 màu pastel (Hồng, Tím, Xanh Mint, Trắng, Xanh Pastel), dễ mang theo.\r\nDễ sử dụng: Chỉ cần xoay ống kính để bật/tắt máy và chuyển sang chế độ chụp cận cảnh (Close-up).\r\nChế độ Cận cảnh & Selfie:\r\nXoay ống kính ra ngoài để kích hoạt chế độ Cận cảnh (chụp gần 30-50cm).\r\nGương selfie tích hợp ngay phía trước ống kính giúp căn chỉnh góc chụp dễ dàng.\r\nPhơi sáng & Flash tự động: Tự động điều chỉnh độ sáng và flash phù hợp, chụp đẹp ngay cả trong điều kiện thiếu sáng.\r\nIn ảnh tức thì: Sử dụng phim Instax Mini (54x86mm), in ảnh trong vài phút.\r\nThông số cơ bản: Ống kính Fujinon 60mm, lấy nét cố định, dùng 2 pin AA. \r\nPhù hợp cho\r\nNgười mới bắt đầu sử dụng máy ảnh lấy liền.\r\nGhi lại những khoảnh khắc vui vẻ, tiệc tùng, du lịch.\r\nTạo ra những bức ảnh hữu hình, độc đáo ngay lập tức. ', 2900000, 55, 'products/1765982650_image-removebg-preview (3).png', '2025-12-17 14:44:10', '2025-12-17 14:44:10'),
(46, 8, 2, 'PlayStation 4 Pro', 'Bộ máy chơi game PlayStation 4 Pro Party Bundle là phiên bản cao cấp của PS4, có ổ cứng 1TB, thiết kế 3 tầng màu đen nhám, trang bị chip mạnh mẽ cho game 4K/HDR, đi kèm 2 tay cầm DualShock 4, đĩa game FIFA 20 và Crash Team Racing cùng phụ kiện tiêu chuẩn, tối ưu hóa cho trải nghiệm chơi game giải trí nhóm sôi động. \r\nĐặc điểm chính:\r\nTên gọi: PlayStation 4 Pro 1TB Party Bundle (Mã CUH-7218B).\r\nHiệu năng cao: Chip AMD Jaguar 8 nhân, GPU mạnh mẽ, hỗ trợ độ phân giải 4K và HDR, mang lại hình ảnh sắc nét, sống động.\r\nBộ nhớ: 1TB, đủ không gian lưu trữ game và dữ liệu.\r\nThiết kế: Vỏ đen nhám, kiểu dáng 3 tầng, lớn hơn và nặng hơn PS4 Slim, nhưng vẫn gọn gàng. \r\nPhụ kiện đi kèm (trong gói Party Bundle):\r\n1 Máy PlayStation 4 Pro 1TB.\r\n2 Tay cầm không dây DualShock 4 (DS4).\r\n1 Đĩa game FIFA 20.\r\n1 Đĩa game Crash Team Racing.\r\nCáp nguồn, cáp HDMI, tai nghe mono, cáp sạc tay cầm và sách hướng dẫn. \r\nLợi ích:\r\nChơi game đa dạng: Tương thích với mọi game PS4, mang lại trải nghiệm mượt mà hơn trên game được hỗ trợ.\r\nTrải nghiệm nhóm: Có sẵn 2 tay cầm và game đối kháng/đua xe để chơi cùng bạn bè ngay lập tức, phù hợp cho các bữa tiệc game.\r\nHình ảnh đỉnh cao: Tận dụng tối đa TV 4K với chi tiết và màu sắc chân thực. ', 12999000, 33, 'products/1765982964_download.png', '2025-12-17 14:49:24', '2025-12-17 14:49:24'),
(47, 8, 6, 'PlayStation 5', 'Máy chơi game PlayStation 5 (PS5) phiên bản ASIA-00441 là bộ sản phẩm tiêu chuẩn có ổ đĩa, bao gồm máy PS5 Standard, hai tay cầm DualSense và game cài sẵn, trang bị CPU AMD Zen 2, GPU RDNA 2, SSD tốc độ cao, hỗ trợ hình ảnh 8K, âm thanh 3D và tương thích ngược với game PS4, mang lại trải nghiệm game mạnh mẽ, chân thực với đồ họa đỉnh cao, công nghệ Ray Tracing và âm thanh sống động. \r\nĐặc điểm nổi bật của bộ sản phẩm:\r\nMã sản phẩm: ASIA-00441 (thường là phiên bản quốc tế/châu Á).\r\nLoại máy: PlayStation 5 (PS5) phiên bản Standard (có ổ đĩa).\r\nSố lượng tay cầm: 2 tay cầm DualSense (một tay cầm đi kèm máy, một tay cầm bổ sung).\r\nBộ nhớ trong: Tùy phiên bản có thể là 825GB (bản gốc) hoặc 1TB (bản Slim), tốc độ cực cao.\r\nĐồ họa & Hiệu năng:\r\nCPU AMD Zen 2 8 nhân 16 luồng.\r\nGPU AMD RDNA 2 hỗ trợ Ray Tracing (tạo bóng và phản chiếu chân thực).\r\nHỗ trợ độ phân giải 4K @ 120Hz, 8K @ 60Hz.\r\nÂm thanh: Công nghệ âm thanh 3D &#34;Tempest&#34;.\r\nTính năng khác: Tương thích ngược hoàn toàn với thư viện game PS4.\r\nPhụ kiện đi kèm: Game Astro&#39;s Playroom cài sẵn. \r\nTóm lại: Đây là gói sản phẩm hoàn chỉnh để bạn và một người nữa có thể bắt đầu chơi game PS5 ngay lập tức, có đủ sức mạnh xử lý đồ họa và âm thanh ấn tượng, cùng với lợi thế chơi game đĩa vật lý nhờ ổ đĩa tích hợp. ', 18990000, 53, 'products/1765983054_image-removebg-preview.png', '2025-12-17 14:50:54', '2025-12-17 14:50:54'),
(48, 8, 6, 'Nintendo Switch Lite', 'Nintendo Switch Lite màu Coral là phiên bản máy chơi game cầm tay thuần túy, nhỏ gọn, nhẹ hơn bản Switch thường, có thiết kế nguyên khối với màu hồng san hô (Coral) đặc trưng, màn hình 5.5 inch, tích hợp bộ điều khiển và D-Pad thay vì các nút tách rời, lý tưởng cho việc chơi game di động mọi lúc mọi nơi nhưng không xuất ra TV được và thiếu tính năng HD Rumble/IR Camera. \r\nĐặc điểm nổi bật:\r\nThiết kế & Màu sắc: Vỏ máy màu hồng san hô (Coral) mờ, bề mặt nhám chống trượt, siêu gọn nhẹ và liền mạch.\r\nMàn hình: Màn hình cảm ứng 5.5 inch, độ phân giải 720p, nhỏ hơn Switch tiêu chuẩn.\r\nĐiều khiển: Bộ điều khiển (Joy-Con) gắn liền, thay thế nút D-Pad truyền thống, không có tính năng HD Rumble và IR Camera.\r\nChơi game: Chỉ chơi ở chế độ cầm tay (handheld), không có dock xuất ra TV như Switch thường.\r\nPin: Thời lượng pin từ 3-7 giờ tùy game, nhờ phần cứng hiệu quả và màn hình nhỏ hơn.\r\nKết nối: Hỗ trợ Wi-Fi, kết nối Bluetooth, có cổng tai nghe 3.5mm, có thể kết nối không dây với máy Switch khác or tay cầm rời để chơi game multiplayer.\r\nBộ nhớ: 32GB bộ nhớ trong, hỗ trợ thẻ nhớ mở rộng lên tới 2TB. \r\nĐối tượng:\r\nTuyệt vời cho người chơi yêu thích trải nghiệm game di động, các tựa game độc quyền Switch và muốn thiết bị nhỏ gọn để mang theo. \r\nTóm lại, Switch Lite Coral là phiên bản di động hóa của Switch, tập trung vào trải nghiệm chơi game cầm tay với mức giá hợp lý, phù hợp cho người dùng chỉ có nhu cầu chơi trên máy và không cần tính năng TV mode hay Joy-Con tách rời. ', 3799000, 58, 'products/1765983121_image-removebg-preview (1).png', '2025-12-17 14:52:01', '2025-12-17 14:52:01'),
(49, 8, 7, 'MSI Claw A1M-049VN', 'MSI Claw A1M-049VN là máy chơi game cầm tay cao cấp của MSI, nổi bật với chip Intel Core Ultra 7 155H mạnh mẽ, màn hình 7 inch FHD 120Hz siêu mượt, thiết kế công thái học (ergonomic) độc đáo, tản nhiệt hiệu quả, pin 53Whr lớn nhất phân khúc và hỗ trợ kết nối hiện đại (Thunderbolt 4, Wi-Fi 7), chạy Windows 11, mang đến trải nghiệm gaming di động đỉnh cao với giá tốt,. \r\nCấu hình nổi bật\r\nCPU: Intel Core Ultra 7 155H (16 nhân, xung nhịp đến 4.8GHz) tích hợp NPU AI Boost.\r\nGPU: Intel Arc Graphics (tích hợp).\r\nRAM: 16GB LPDDR5 6400MHz (onboard).\r\nSSD: 512GB PCIe 4.0 NVMe M.2 2230.\r\nHệ điều hành: Windows 11 Home. \r\nTrải nghiệm & Thiết kế\r\nMàn hình: 7 inch IPS-Level, FHD (1920x1080), 120Hz, cảm ứng, 100% sRGB, 500 nits, cho hình ảnh sắc nét, màu sắc sống động.\r\nThiết kế: Vỏ nhựa cao cấp màu Bão Cát (Sandstorm), công thái học, báng cầm chắc tay, trọng lượng 675g.\r\nĐiều khiển: Phím bấm và cần analog dùng công nghệ Hall Effect chống drift, đèn LED RGB đẹp mắt.\r\nÂm thanh: Hi-Res Audio chất lượng cao. \r\nPin & Tản nhiệt\r\nPin: 53Whr (dung lượng cao nhất phân khúc), cho 2-4 tiếng chơi game tùy game.\r\nSạc: Hỗ trợ sạc nhanh 65W qua USB-PD.\r\nTản nhiệt: Hệ thống Cooler Boost HyperFlow hiệu quả, không làm nóng tay khi dùng lâu. \r\nKết nối & Phần mềm\r\nKết nối: Thunderbolt 4 (USB-C), Wi-Fi 7, Bluetooth 5.4.\r\nPhần mềm: MSI Center M (tối ưu giao diện), MSI AI Engine (tự động điều chỉnh). \r\nĐiểm cộng lớn\r\nHiệu năng: Chip Intel Core Ultra mạnh mẽ, xử lý tốt game AAA ở mức đồ họa phù hợp.\r\nMàn hình: Tần số quét cao 120Hz, độ phủ màu rộng.\r\nĐộ bền & Cảm giác: Phím Hall Effect, thiết kế cầm nắm thoải mái, chắc chắn.\r\nPin & Sạc: Pin lớn 53Whr & sạc nhanh 65W.\r\nHệ điều hành: Windows 11 bản quyền, đa năng.', 11550000, 33, 'products/1765983189_image-removebg-preview (2).png', '2025-12-17 14:53:09', '2025-12-17 14:53:09'),
(50, 9, 9, 'GTX 1660 Ti/Super', 'Một bộ PC Gaming Full Option với GTX 1660 Ti/Super thường xoay quanh CPU Intel Core i5 (thế hệ 10-12 như 10400F, 12400F) hoặc i3 10105F, kết hợp RAM 16GB DDR4 3200Mhz, SSD NVMe 256-512GB, nguồn 650W, đi kèm màn hình Full HD 75Hz (IPS), đủ sức chiến mượt các game eSports lẫn AAA ở mức High-Ultra 1080p, rất phù hợp cho game thủ tầm trung. \r\nCấu hình PC Gaming Full Bộ (Ví dụ)\r\nCPU: Intel Core i5-12400F (6 nhân/12 luồng) hoặc i3 10105F (4 nhân/8 luồng).\r\nMainboard: Chipset H610 hoặc B760 (Socket LGA 1700).\r\nRAM: 16GB DDR4 3200Mhz (2x8GB hoặc 1x16GB).\r\nVGA: NVIDIA GeForce GTX 1660 Super/Ti 6GB GDDR6 (Đủ sức chơi mượt Full HD).\r\nSSD: SSD NVMe 256GB - 512GB (Khởi động siêu tốc).\r\nPSU: 550W - 650W 80Plus Bronze (Đảm bảo ổn định).\r\nVỏ Case + Tản Nhiệt: Vỏ case kính/lưới thoáng mát + Tản nhiệt khí Jonsbo CR-1000. \r\nMàn hình đi kèm (Ví dụ)\r\nMàn hình: ViewSonic VA2409-H 24 inch (hoặc tương đương).\r\nTấm nền: IPS (Màu sắc đẹp, góc nhìn rộng).\r\nĐộ phân giải: Full HD (1920x1080).\r\nTần số quét: 75Hz (Tăng sự mượt mà so với 60Hz). \r\nHiệu năng thực tế\r\nGame eSports: Liên Minh Huyền Thoại, Valorant, CS:GO, Dota 2 chơi ở thiết lập cao nhất, FPS ổn định cao (High/Ultra).\r\nGame AAA (Tựa game nặng): Cyberpunk 2077, GTA V, Red Dead Redemption 2 chơi mượt ở độ phân giải Full HD (1080p) với cài đặt High hoặc Medium-High, tùy game. \r\nAi nên mua?\r\nGame thủ muốn trải nghiệm tốt tất cả game ở mức giá hợp lý.\r\nStreamer bán chuyên, người làm đồ họa/video cơ bản.\r\nƯu tiên hiệu năng/giá (Performance/Price) cho trải nghiệm gaming Full HD. ', 11980000, 22, 'products/1765983385_image-removebg-preview (3).png', '2025-12-17 14:56:25', '2025-12-17 14:56:25'),
(51, 9, 8, 'GTX 1650, RAM 16GB', 'PC Gaming với cấu hình i7 10700, GTX 1650, RAM 16GB và SSD 256GB là một bộ máy tầm trung, mạnh mẽ, cân bằng giữa giá cả và hiệu năng, có thể xử lý tốt các game esport phổ biến (LOL, Valorant, FO4) ở mức setting cao, các game AAA cũ/mới ở mức Medium-High, đa nhiệm mượt mà, làm việc văn phòng và đồ họa cơ bản nhờ CPU i7 8 nhân 16 luồng, 16GB RAM và SSD tốc độ cao, mang lại trải nghiệm chơi game ổn định với hình ảnh sắc nét. \r\nTổng quan cấu hình\r\nCPU: Intel Core i7-10700 (8 nhân 16 luồng, xung nhịp cao) - mạnh mẽ cho cả gaming và đa nhiệm, xử lý tác vụ nặng tốt.\r\nVGA: NVIDIA GeForce GTX 1650 - đáp ứng tốt game eSports, và các game AAA ở thiết lập hợp lý.\r\nRAM: 16GB DDR4 - đủ cho đa nhiệm nặng, chơi game không bị giật, lag.\r\nLưu trữ: 256GB SSD NVMe - tốc độ khởi động Windows và load game cực nhanh. \r\nHiệu năng & Trải nghiệm\r\nChơi Game:\r\nEsports (LOL, Valorant, FO4): Max setting, FPS cao, mượt mà.\r\nAAA (GTA V, Apex, CS2): Thiết lập High/Medium-High, 1080p, 60+ FPS ổn định.\r\nĐa nhiệm & Công việc: Xử lý mượt nhiều ứng dụng cùng lúc, phù hợp cho học tập, văn phòng, đồ họa cơ bản (Photoshop, AI), chỉnh sửa video nhẹ nhàng.\r\nTốc độ: Khởi động máy, mở ứng dụng nhanh chóng nhờ SSD. \r\nPhù hợp cho đối tượng\r\nGame thủ muốn trải nghiệm mượt mà các game hot hiện nay với ngân sách hợp lý.\r\nSinh viên, người làm văn phòng cần máy tính ổn định, mạnh mẽ cho cả công việc và giải trí.\r\nLưu ý\r\nGTX 1650 có thể hơi &#34;đuối&#34; với các game AAA mới nhất ở Ultra settings.\r\nỔ SSD 256GB có thể nhanh đầy nếu cài nhiều game và ứng dụng, nên cân nhắc thêm HDD hoặc SSD lớn hơn. \r\nTóm lại, đây là bộ PC cân bằng, hiệu năng tốt, đáp ứng đa dạng nhu cầu, mang lại trải nghiệm đáng tiền trong phân khúc tầm trung. ', 8700000, 44, 'products/1765983484_image-removebg-preview (4).png', '2025-12-17 14:58:04', '2025-12-17 14:58:04'),
(52, 9, 10, 'RTX 3060 Ultra', 'Bộ PC Gaming i5-12400F, RAM 16GB, RTX 3060 Ultra White 12GB OC là cấu hình tầm trung mạnh mẽ, lý tưởng cho game thủ và nhà sáng tạo nội dung, kết hợp CPU Intel Core i5-12400F (6 nhân/12 luồng) mạnh mẽ với card đồ họa RTX 3060 12GB cho hiệu năng tuyệt vời ở độ phân giải Full HD/QHD, đa nhiệm mượt mà với RAM 16GB, và nổi bật với thiết kế case/linh kiện màu trắng cực kỳ thẩm mỹ, phù hợp stream và setup gaming &#34;tone-sur-tone&#34; đẹp mắt, có cả tản nhiệt và SSD tốc độ cao, nguồn ổn định, sẵn sàng chiến mọi game AAA và ứng dụng đồ họa nặng. \r\nMô tả chi tiết các thành phần chính:\r\nCPU Intel Core i5-12400F: &#34;Ông vua phân khúc tầm trung&#34;, kiến trúc Alder Lake, 6 nhân 12 luồng, xung nhịp boost lên 4.4GHz, cân mượt game và ứng dụng đồ họa, nền tảng LGA 1700.\r\nGPU RTX 3060 12GB Ultra White OC: Card đồ họa NVIDIA thế hệ Ampere, VRAM 12GB GDDR6, hỗ trợ Ray Tracing & DLSS, cho trải nghiệm game AAA mượt mà Full HD/QHD (Cyberpunk 2077, Elden Ring...), phiên bản OC (Overclocked) và màu trắng cực đẹp.\r\nRAM 16GB (2x8GB) DDR4 Bus 3200MHz: Đủ dung lượng cho đa nhiệm nặng, xử lý video, đồ họa, tốc độ 3200MHz giúp giảm lag, tăng hiệu suất.\r\nMainboard (B760M/H610M): Thường đi kèm chipset B760 hoặc H610, hỗ trợ CPU 12th Gen, cung cấp nguồn ổn định, khả năng tản nhiệt tốt.\r\nSSD NVMe M.2: Tốc độ cao (thường 500GB-1TB), giúp khởi động Windows, game và ứng dụng cực nhanh (VD: SSD 512GB M.2 PCIe NVMe).\r\nNguồn (PSU): Công suất 600W-650W 80 Plus Bronze/Silver, đảm bảo hoạt động bền bỉ, an toàn (VD: Gigabyte P650B, AIGO VK650).\r\nVỏ Case (Case): Thiết kế màu trắng chủ đạo, kính cường lực, kèm Fan LED RGB, tạo không gian gaming thẩm mỹ, sang trọng.\r\nTản nhiệt CPU: Tản nhiệt khí tháp đôi hoặc tản nhiệt khí đơn mạnh mẽ (VD: Centaur, ID-COOLING) để giữ CPU luôn mát mẻ. \r\nHiệu năng và ứng dụng:\r\nGaming: Chơi mượt các game AAA ở 1080p (Full HD) và 1440p (2K) với thiết lập cao, FPS ổn định (Valorant, CS2, COD, Cyberpunk 2077, Elden Ring).\r\nĐồ họa & Sáng tạo: Xử lý Adobe Premiere Pro, Photoshop, After Effects, Blender mượt mà, render video 4K tốt, phù hợp cho Streamer.\r\nĐa nhiệm: Mở hàng chục tab Chrome, làm việc văn phòng, học tập, stream game cùng lúc không giật lag. \r\nĐiểm nhấn:\r\nThẩm mỹ trắng: Thiết kế đồng bộ màu trắng (case, card, RAM, tản nhiệt) tạo nên bộ PC cực kỳ đẹp mắt, &#34;sang&#34; và &#34;chất&#34;.\r\nGiá trị/Hiệu năng: Cấu hình tối ưu ', 14599000, 53, 'products/1765983555_image-removebg-preview (5).png', '2025-12-17 14:59:15', '2025-12-17 14:59:15');

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
(74, 6, 'CPU', 'Intel Core i5'),
(77, 23, 'RAM', '4GB'),
(78, 23, 'ROM', '256GB'),
(80, 24, 'RAM', '16GB'),
(81, 25, 'Man hinh', '10.9 inch'),
(83, 26, 'Dung lượng', '10000mAh'),
(84, 27, 'Chất liệu', 'Hợp kim nhôm'),
(85, 28, 'Dung lượng', '5000mAh'),
(88, 30, 'Chất liệu', 'Nhựa cao cấp'),
(89, 29, 'Chất liệu', 'Nhựa cao cấp'),
(90, 21, 'Màu', 'Xanh lá'),
(91, 7, 'CPU', '8GB'),
(92, 31, 'Màn hình', '4k '),
(93, 32, 'Màn hình', '4K'),
(94, 33, 'Màn hình', '4K'),
(95, 34, 'Màn hình', '4K'),
(101, 35, 'Màn hình', '4K'),
(102, 36, 'Màn hình', '4K'),
(105, 37, 'RAM', '16GB'),
(106, 37, 'ROM', '512GB'),
(107, 38, 'RAM', '16GB'),
(108, 38, 'ROM', '256GB'),
(109, 39, 'RAM', '8GB'),
(110, 39, 'ROM', '256GB'),
(111, 40, 'Màn hình', '4K'),
(113, 41, 'Màn hình', '4K'),
(114, 42, 'Màn hình', '4K'),
(115, 43, 'Màn hình', '4K'),
(116, 44, 'Màn hình', '4K'),
(117, 45, 'Màn hình', '4K'),
(118, 46, 'Chất liệu', 'Nhựa cao cấp'),
(119, 47, 'Chất liệu', 'Nhựa cao cấp'),
(120, 48, 'Chất liệu', 'Nhựa cao cấp'),
(121, 49, 'Chất liệu', 'Nhựa cao cấp'),
(122, 50, 'CPU', '16GB'),
(123, 51, 'RAM', '16GB'),
(124, 52, 'CPU', '16GB');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=125;

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
