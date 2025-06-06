-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 06, 2025 at 01:21 PM
-- Server version: 10.5.23-MariaDB-0+deb11u1
-- PHP Version: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `valp07`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `address1` varchar(255) NOT NULL,
  `address2` varchar(255) DEFAULT NULL,
  `address3` varchar(255) DEFAULT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) DEFAULT NULL,
  `county` varchar(100) DEFAULT NULL,
  `postal_code` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `addresses`
--

INSERT INTO `addresses` (`id`, `address1`, `address2`, `address3`, `city`, `state`, `county`, `postal_code`) VALUES
(1, 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
(2, 'test', 'ahoj', 'b', 'agartha', 'stredocesky kraj', 'hyperborea', '123'),
(3, 'a', 'ahoj', 'a', 'agartha', 'stredocesky kraj', 'hyperborea', '123'),
(4, 'a', 'ahoj', 'a', 'agartha', 'stredocesky kraj', 'hyperborea', '123'),
(5, 'a', 'ahoj', 'a', 'agartha', 'stredocesky kraj', 'hyperborea', '123'),
(6, 'test', 'a', 'b', 'Líbeznice', 'stredocesky kraj', 'hyperborea', '2'),
(7, 'test', 'a', 'b', 'Praha', 'stredocesky kraj', 'hyperborea', '2'),
(8, 'tset', 'asdgdfgs', 'gsedtrgh', 'gdsg', 'ghtrhd', 'tjktyufj', '3254345'),
(9, 'Zlonínská', '577', '', 'Líbeznice', 'Středočeský kraj', 'Česko', '25065'),
(10, 'test', 'a', 'b', 'template city', 'random state', 'testopia', '123test'),
(11, 'test', 'testy', 'test', 'test', 'test', 'test', 'test'),
(12, 'testy', 'test', 'test', 'test', 'test', 'test', 'test'),
(13, 'b', 'a', 'a', 'b', 'a', 'a', 'a'),
(14, 'b', 'a', 'a', 'b', 'a', 'a', 'a'),
(15, 'b', 'a', 'a', 'b', 'a', 'a', 'a'),
(16, 'b', 'a', 'a', 'b', 'a', 'a', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `cart_items`
--

CREATE TABLE `cart_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cart_items`
--

INSERT INTO `cart_items` (`id`, `user_id`, `product_id`, `quantity`) VALUES
(2, 2, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` enum('pending','processing','shipped','delivered','cancelled') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  `payment_method` varchar(100) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `status`, `created_at`, `payment_method`, `address_id`) VALUES
(1, 3, 'pending', '2025-06-02 14:19:36', 'cash', 1),
(2, 3, 'pending', '2025-06-02 14:22:26', 'cash', 1),
(3, 3, 'processing', '2025-06-02 14:24:16', 'cash', 1),
(4, 3, 'shipped', '2025-06-02 14:29:51', 'card', 1),
(5, 3, 'cancelled', '2025-06-02 14:31:49', 'card', 1),
(6, 3, 'pending', '2025-06-03 13:39:53', 'cash', 1),
(7, 6, 'pending', '2025-06-03 20:16:00', 'cash', 1),
(8, 3, 'pending', '2025-06-04 08:31:47', 'cash', 1),
(9, 8, 'shipped', '2025-06-05 21:55:38', 'cash', 1),
(10, 8, 'pending', '2025-06-05 21:58:10', 'card', 1),
(11, 3, 'pending', '2025-06-05 22:48:40', 'cash', 1),
(12, 3, 'pending', '2025-06-05 23:26:05', 'card', 1),
(13, 3, 'pending', '2025-06-05 23:28:19', 'cash', 1),
(14, 3, 'pending', '2025-06-05 23:30:13', 'cash', 1),
(15, 3, 'pending', '2025-06-05 23:32:19', 'card', 1),
(16, 3, 'pending', '2025-06-05 23:35:05', 'card', 1),
(17, 3, 'pending', '2025-06-05 23:53:03', 'cash', 2),
(18, 3, 'pending', '2025-06-06 00:08:55', 'card', 3),
(19, 3, 'pending', '2025-06-06 00:11:18', 'card', 4),
(20, 3, 'pending', '2025-06-06 07:36:04', 'cash', 5),
(21, 3, 'pending', '2025-06-06 07:44:31', 'card', 6),
(22, 5, 'pending', '2025-06-06 07:45:10', 'card', 8),
(23, 3, 'pending', '2025-06-06 09:44:15', 'cash', 11),
(24, 3, 'delivered', '2025-06-06 09:46:11', 'cash', 12),
(25, 3, 'pending', '2025-06-06 12:25:23', 'card', 13),
(26, 3, 'pending', '2025-06-06 13:10:36', 'cash', 15),
(27, 3, 'pending', '2025-06-06 13:12:58', 'card', 16);

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(7, 7, 2, 1, '899.99'),
(9, 9, 2, 1, '899.99'),
(10, 9, 3, 8, '799.99'),
(13, 11, 2, 4, '899.99'),
(15, 12, 3, 1, '799.99'),
(16, 12, 2, 2, '899.99'),
(17, 12, 4, 1, '699.99'),
(18, 13, 2, 1, '899.99'),
(19, 14, 2, 1, '899.99'),
(20, 15, 2, 1, '899.99'),
(21, 16, 2, 1, '899.99'),
(22, 17, 2, 1, '899.99'),
(23, 19, 2, 5, '899.99'),
(24, 20, 2, 1, '899.99'),
(25, 21, 2, 1, '899.99'),
(26, 22, 2, 1, '899.99'),
(27, 23, 2, 3, '899.99'),
(28, 24, 3, 1, '799.99'),
(35, 27, 3, 1, '799.99');

-- --------------------------------------------------------

--
-- Table structure for table `phones`
--

CREATE TABLE `phones` (
  `product_id` int(11) NOT NULL,
  `screen_size` decimal(4,2) NOT NULL,
  `ram` int(11) NOT NULL,
  `storage` int(11) NOT NULL,
  `battery` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `phones`
--

INSERT INTO `phones` (`product_id`, `screen_size`, `ram`, `storage`, `battery`) VALUES
(2, '6.10', 8, 128, 3900),
(3, '6.20', 8, 128, 4575),
(4, '6.70', 16, 256, 5000),
(6, '6.50', 12, 256, 5000),
(7, '6.78', 16, 512, 6000),
(8, '6.55', 8, 256, 4400),
(9, '6.74', 16, 256, 5000),
(10, '6.43', 6, 128, 4200),
(11, '4.70', 4, 64, 2018),
(12, '6.40', 8, 128, 5000),
(13, '6.10', 8, 128, 4385),
(14, '6.72', 8, 128, 5000),
(15, '6.67', 6, 128, 5000),
(16, '6.10', 6, 128, 5000),
(17, '5.90', 8, 128, 4300),
(18, '6.50', 8, 256, 5000),
(19, '6.70', 12, 256, 5000),
(20, '6.58', 6, 128, 4500),
(21, '1.00', 1, 1, 1),
(22, '6.50', 8, 128, 4500),
(23, '6.50', 8, 128, 4500),
(24, '6.50', 8, 128, 4500),
(25, '6.50', 8, 128, 4500),
(26, '6.50', 8, 128, 4500),
(28, '6.50', 8, 128, 4500),
(29, '6.50', 8, 128, 4500),
(30, '6.50', 8, 128, 4500),
(31, '6.50', 8, 128, 4500),
(32, '6.50', 8, 128, 4500);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `brand` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `locked_by` int(11) DEFAULT NULL,
  `locked_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `image`, `description`, `brand`, `price`, `stock`, `locked_by`, `locked_at`) VALUES
(2, 'Samsung Galaxy S26', 'https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-s23-5g-3.jpg', 'Top-tier Android experience', 'Samsung', '899.99', 40, 3, '2025-06-05 22:24:38'),
(3, 'Google Pixel 8', 'https://fdn2.gsmarena.com/vv/pics/google/google-pixel-8-1.jpg', 'Pure Android, excellent camera', 'Google', '799.99', 30, NULL, '2025-06-04 08:13:08'),
(4, 'OnePlus 11', 'https://fdn2.gsmarena.com/vv/pics/oneplus/oneplus-11-2.jpg', 'Fast and smooth performance', 'OnePlus', '699.99', 25, NULL, NULL),
(6, 'Sony Xperia 1 V', 'https://fdn2.gsmarena.com/vv/pics/sony/sony-xperia-1-v-0.jpg', '4K display, great audio', 'Sony', '1099.99', 15, NULL, NULL),
(7, 'Asus ROG Phone 7', 'https://fdn2.gsmarena.com/vv/pics/asus/asus-rog-phone-7-1.jpg', 'Ultimate gaming phone', 'Asus', '999.99', 20, NULL, '2025-06-04 08:13:10'),
(8, 'Motorola Edge 40', 'https://fdn2.gsmarena.com/vv/pics/motorola/motorola-edge40-1.jpg', 'Sleek design, great battery', 'Motorola', '599.99', 40, NULL, NULL),
(9, 'Realme GT Neo 5', 'https://fdn2.gsmarena.com/vv/pics/realme/realme-gt-neo5-1.jpg', 'Budget powerhouse', 'Realme', '499.99', 60, NULL, NULL),
(10, 'Nokia X30', 'https://fdn2.gsmarena.com/vv/pics/nokia/nokia-x30-5g-1.jpg', 'Durable and clean Android', 'Nokia', '399.99', 50, NULL, NULL),
(11, 'iPhone SE 3rd Gen', 'https://fdn2.gsmarena.com/vv/pics/apple/apple-iphone-se-2022-0.jpg', 'Compact and powerful', 'Apple', '429.99', 70, NULL, NULL),
(12, 'Samsung Galaxy A54', 'https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-a54-5.jpg', 'Solid midrange option', 'Samsung', '449.99', 55, NULL, NULL),
(13, 'Google Pixel 7a', 'https://fdn2.gsmarena.com/vv/pics/google/google-pixel7-2.jpg', 'Affordable Google phone', 'Google', '499.99', 65, NULL, NULL),
(14, 'OnePlus Nord CE 3', 'https://fdn2.gsmarena.com/vv/pics/oneplus/oneplus-nord-ce3-5g-1.jpg', 'Affordable and efficient', 'OnePlus', '329.99', 75, NULL, NULL),
(15, 'Xiaomi Redmi Note 12', 'https://fdn2.gsmarena.com/vv/pics/xiaomi/redmi-note-12-5g-international-0.jpg', 'Great value for money', 'Xiaomi', '279.99', 80, NULL, NULL),
(16, 'Sony Xperia 10 V', 'https://fdn2.gsmarena.com/vv/pics/sony/sony-xperia-10-v-1.jpg', 'Midrange Sony option', 'Sony', '499.99', 25, NULL, NULL),
(17, 'Asus Zenfone 10', 'https://fdn2.gsmarena.com/vv/pics/asus/asus-zenfone10-0.jpg', 'Compact flagship', 'Asus', '749.99', 30, NULL, NULL),
(18, 'Motorola Moto G73', 'https://fdn2.gsmarena.com/vv/pics/motorola/motorola-moto-g73-1.jpg', 'Good specs for price', 'Motorola', '299.99', 60, NULL, NULL),
(19, 'Realme 11 Pro+', 'https://fdn2.gsmarena.com/vv/pics/realme/realme-11-pro-plus-2.jpg', 'Stylish and capable', 'Realme', '349.99', 45, NULL, NULL),
(20, 'Nokia G60', 'https://fdn2.gsmarena.com/vv/pics/nokia/nokia-g60-5g-1.jpg', 'Eco-friendly build', 'Nokia', '319.99', 50, NULL, NULL),
(21, 'Placeholder Phone', '', 'This is a placeholder phone product.', 'PlaceholderBrand', '1.00', 1, NULL, NULL),
(22, 'mock', '', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(23, 'test', '', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(24, 'test', '', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(25, 'Mock Phone', '', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(26, 'Mock Phone', '', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(28, 'Mock Phone', '', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(29, 'Mock Phone', 'https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-s23-5g-3.jpg', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, NULL, NULL),
(30, 'Mock Phonexxx', '/images/mock-image.jpg', 'This is a mock phone used for testing UI.', 'MockBrand', '100.00', 20, NULL, NULL),
(31, 'Mock Phone', 'https://pngimg.com/uploads/smartphone/smartphone_PNG8501.png', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, 3, '2025-06-05 22:20:49'),
(32, 'Mock Phone', 'https://www.startpage.com/av/proxy-image?piurl=https%3A%2F%2Fm.media-amazon.com%2Fimages%2FI%2F61JZPjaaaLL._AC_SL1500_.jpg&sp=1749203153T7d5a6afe2896c79c2bab977f69c68ab8f4f51f814bd6205515ef19693e740959', 'This is a mock phone used for testing UI.', 'MockBrand', '499.99', 20, 3, '2025-06-06 11:46:02');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` varchar(255) DEFAULT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `reset_token` varchar(255) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `reset_token`, `address_id`) VALUES
(2, 'JOE', 'joe2@vse.cz', '$2y$10$VQV7Z/X64CNzDGrCallZrOO3dM1oOgz3kbpOdB0ql8UVTk08DazD.', 'admin', '76990814e96c60136d764ea2f5db2788', NULL),
(3, '', 'petr.n4.valach@gmail.com', NULL, 'admin', '6ebd9971367d72c632ffe85223ff7d0b', 14),
(5, '', 'houboman@gmail.com', NULL, 'admin', NULL, NULL),
(6, 'valp', 'valp07@vse.cz', '$2y$10$wUvuV2hmIHeyyzRRaamAvux8BtYDUn4n04vEo5t1mz9ag8IQSza3e', 'user', NULL, NULL),
(7, 'Admin', 'admin@admin.cz', '$2y$10$pGhcSkRouYJu3Y2i8iSpNeWSQFYKsq.I22IfD9FUaGnn2KjcXs1lG', 'admin', NULL, NULL),
(8, 'nguv03@vse.cz', 'nguv03@vse.cz', '$2y$10$4Whe1t0G4sttm1qpqwO4IOqQhi/zVrBhbeGkmKCccVOgWbcl/wFkS', 'admin', NULL, NULL),
(9, 'joe', 'joe@joe.cz', '$2y$10$SIRKdWVlqc/VMVaEDeuCOOnxmRvqPl4mzoWiQt18U6wlT8c2/jbCO', 'user', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_orders_address` (`address_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `phones`
--
ALTER TABLE `phones`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locked_by` (`locked_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_users_address` (`address_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `cart_items`
--
ALTER TABLE `cart_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `cart_items_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cart_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orders_address` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `phones`
--
ALTER TABLE `phones`
  ADD CONSTRAINT `phones_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`locked_by`) REFERENCES `users` (`id`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_users_address` FOREIGN KEY (`address_id`) REFERENCES `addresses` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
