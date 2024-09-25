-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th8 19, 2024 lúc 11:36 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `mysql_shoewebsite`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `total_price` decimal(10,2) NOT NULL,
  `status` enum('paid','in delivery') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_date`, `total_price`, `status`) VALUES
(1, 2, '2024-07-28 09:21:50', 312.00, 'paid'),
(2, 2, '2024-08-09 12:35:50', 245.00, 'in delivery'),
(3, 3, '2024-08-15 21:42:52', 355.00, 'in delivery'),
(4, 3, '2024-08-15 21:45:59', 125.00, 'in delivery'),
(5, 3, '2024-08-15 21:55:33', 337.00, 'in delivery'),
(6, 4, '2024-08-16 11:50:51', 125.00, 'in delivery'),
(7, 3, '2024-08-16 12:19:32', 237.00, 'in delivery');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(1, 1, 28, 1, 312.00),
(2, 2, 23, 2, 220.00),
(3, 3, 23, 3, 330.00),
(4, 4, 29, 1, 100.00),
(5, 5, 28, 1, 312.00),
(6, 6, 27, 1, 100.00),
(7, 7, 25, 1, 212.00);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `quantity`, `image`, `created_at`) VALUES
(23, 'Air Max Electric', NULL, 110.00, 18, 'air-max-1-essential-shoes-Vz0BS9 (1).png', '2024-07-27 16:00:46'),
(24, 'Air Vapormax 2023', NULL, 132.00, 21, 'air-vapormax-2023-flyknit-electric-shoes-1q11q1.png', '2024-07-27 16:01:43'),
(25, 'Alphafly Electric', NULL, 212.00, 31, 'alphafly-3-electric-road-racing-shoes-MtPh37.jpg', '2024-07-27 16:02:19'),
(26, 'Infiniry Electric', NULL, 100.00, 31, 'infinityrn-4-electric-road-running-shoes-FkGQcG.png', '2024-07-27 16:03:35'),
(27, 'Invincible Electric', NULL, 100.00, 10, 'invincible-3-electric-road-running-shoes-nhn3wf.png', '2024-07-27 16:04:09'),
(28, 'Jordan Stadium 90', NULL, 312.00, 4, 'jordan-stadium-90-shoes-Jn6ZH4.png', '2024-07-27 16:04:50'),
(29, 'Air Jordan 1 Low', NULL, 100.00, 49, 'air-jordan-1-low-se-shoes-FTrFvs.png', '2024-07-27 17:42:02'),
(31, 'Nike Invincible 3', NULL, 150.00, 0, 'NIKE+ZOOMX+INVINCIBLE+RUN+FK+3.jpg', '2024-08-16 03:00:52'),
(32, 'Air Force 1', NULL, 150.00, 10, 'AIR+FORCE+1+\'07.png', '2024-08-16 03:12:06');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_vietnamese_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `phone_number`, `address`, `created_at`) VALUES
(2, 'Tuan', 'Nguyen', '2251120395@ut.edu.vn', '$2y$10$h3.Qnup9QAzXv3rLqyC8YeD9pfqrK0H1SNI6MtE38CFtWmBzMiteO', '0788713056', '123, duong 456, phuong Tan Phu, TP Thu Duc', '2024-07-27 06:25:04'),
(3, 'Tuan', 'Nguyen', 'anhtuannguyen112004@gmail.com', '$2y$10$p1tyW3k6JsZF4KWuIqSAOu6ZIAWTXUTrMEZfpAGuV4P4m/iS6Egsy', '012346789', '123, phuong abc, xyz', '2024-08-16 02:42:02'),
(4, 'Lien', 'Nguyen', 'phuoclien2k4@gmail.com', '$2y$10$Iy4rlE5kF.FOWU3HKaqIieYbAIPC.1xNxbklSbUgpDvtAXn6jB03C', '01234645', '123, duong 456, phuong 789, quan go vap', '2024-08-16 16:24:38');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Chỉ mục cho bảng `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `customer_id` (`customer_id`);

--
-- Chỉ mục cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Chỉ mục cho bảng `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT cho bảng `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`);

--
-- Các ràng buộc cho bảng `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
