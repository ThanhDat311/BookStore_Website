-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 08, 2025 at 03:53 AM
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
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(6, 'Literature & Arts'),
(7, 'Social Sciences & Humanities'),
(8, 'Natural Sciences'),
(9, 'Technology & Engineering'),
(10, 'Travel & Culture');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `order_code` varchar(255) NOT NULL,
  `note` text DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL,
  `tax_fee` decimal(10,2) DEFAULT NULL,
  `total` decimal(10,2) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `order_code`, `note`, `status`, `subtotal`, `tax_fee`, `total`, `created_at`, `updated_at`) VALUES
(3, 2, 'OD20250806081808908', NULL, 'pending', 564.00, 28.20, 592.20, NULL, NULL),
(5, 2, 'OD20250806082319618', NULL, 'pending', 1329.00, 66.45, 1395.45, NULL, NULL),
(6, 2, 'OD20250806083410241', NULL, 'pending', 1217.00, 60.85, 1277.85, '2025-08-06 13:34:10', '2025-08-06 13:34:10'),
(7, 1, 'OD20250806181526720', NULL, 'pending', 1251.00, 62.55, 1313.55, '2025-08-06 23:15:26', '2025-08-06 23:15:26'),
(8, 1, 'OD20250806194631944', NULL, 'pending', 520.00, 26.00, 546.00, '2025-08-07 00:46:31', '2025-08-07 00:46:31');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`id`, `order_id`, `product_id`, `price`, `quantity`, `subtotal`) VALUES
(1, 3, 10, 166.00, 1, 166.00),
(2, 3, 11, 199.00, 2, 398.00),
(3, 5, 7, 199.00, 2, 398.00),
(4, 5, 8, 122.00, 2, 244.00),
(5, 5, 9, 229.00, 3, 687.00),
(6, 6, 5, 99.00, 2, 198.00),
(7, 6, 6, 229.00, 3, 687.00),
(8, 6, 10, 166.00, 2, 332.00),
(9, 7, 9, 229.00, 3, 687.00),
(10, 7, 10, 166.00, 1, 166.00),
(11, 7, 11, 199.00, 2, 398.00),
(12, 8, 7, 199.00, 1, 199.00),
(13, 8, 8, 122.00, 1, 122.00),
(14, 8, 11, 199.00, 1, 199.00);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `descriptions` text DEFAULT NULL,
  `thumbnail` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT 0,
  `category_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `descriptions`, `thumbnail`, `stock`, `category_id`, `created_at`, `updated_at`) VALUES
(2, 'mjacn akcah ckajcna hacvakcja cmanc', 199.00, 'abc xyz', 'thumb_68921656e744a.webp', 255, 6, '2025-08-05 08:13:45', '2025-08-05 16:33:58'),
(3, 'Product 02', 199.00, 'abc xyz', 'thumb_6892163fa2470.jpg', 112, 7, '2025-08-05 08:15:19', '2025-08-05 16:33:35'),
(4, 'Product 03', 199.00, 'abc xyz', 'thumb_6892161b1a9e9.jpg', 211, 8, '2025-08-05 08:16:13', '2025-08-05 16:32:59'),
(5, 'Product 04', 99.00, 'abc xyz', 'thumb_689215ff4da9d.jpg', 100, 8, '2025-08-05 08:17:02', '2025-08-05 16:32:31'),
(6, 'Product 05', 229.00, 'abc xyz', 'thumb_689215e0de909.webp', 50, 6, '2025-08-05 08:17:33', '2025-08-05 16:32:00'),
(7, 'Product 06', 199.00, 'abc xyz', 'thumb_689215c9afc95.jpg', 223, 7, '2025-08-05 08:18:10', '2025-08-05 16:31:37'),
(8, 'Product 07', 122.00, 'abc xyz', 'thumb_689215a9a1d7d.webp', 220, 7, '2025-08-05 08:18:44', '2025-08-05 21:29:56'),
(9, 'Product 08', 229.00, 'abc xyz', 'thumb_68921593d7c57.jpg', 60, 8, '2025-08-05 08:19:24', '2025-08-05 16:30:43'),
(10, 'Product 09', 166.00, 'abc xyz', 'thumb_68921568dbd01.jpg', 223, 7, '2025-08-05 08:19:53', '2025-08-05 16:30:13'),
(11, 'Product 10', 199.00, 'abc xyz', 'thumb_689215432a66c.jpg', 255, 6, '2025-08-05 08:20:27', '2025-08-05 21:30:11');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int(11) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `product_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `image_url`, `product_id`) VALUES
(36, 'img_689215432aa07.jpg', 11),
(37, 'img_68921568dc010.jpg', 10),
(38, 'img_68921593d8c0c.jpg', 9),
(39, 'img_689215a9a26b9.webp', 8),
(40, 'img_689215c9b09ca.jpg', 7),
(41, 'img_689215e0df435.webp', 6),
(42, 'img_689215ff4e8fc.jpg', 5),
(43, 'img_6892161b1b6e2.jpg', 4),
(44, 'img_6892163fa3323.jpg', 3),
(45, 'img_68921656e81be.webp', 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `phone`, `password`, `role`, `address`) VALUES
(1, 'user', 'user@user.com', '0901236789', '$2y$10$A7T8x5ugec95xuxVVlmgSOTMdL1qJKvxM1YrL35/gVzJDvbk9HGtq', 'user', NULL),
(2, 'Administrator', 'admin@admin.com', '0901883131', '$2y$10$s50zHq.AvXxaRopguHNJR.T28YooDt/pnZOKzTUZ28NQN8XZVufia', 'admin', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `order_details_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
