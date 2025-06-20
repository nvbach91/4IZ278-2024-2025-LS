-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 20, 2025 at 12:32 PM
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
-- Database: `veji03`
--

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `brands`
--

INSERT INTO `brands` (`id`, `name`) VALUES
(1, 'Apple'),
(5, 'Motorola'),
(4, 'OnePlus'),
(2, 'Samsung'),
(12, 'test'),
(3, 'Xiaomi');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_method` varchar(50) NOT NULL,
  `note` text DEFAULT NULL,
  `status` enum('processing','shipped','delivered','cancelled') NOT NULL DEFAULT 'processing'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `street`, `city`, `zip`, `country`, `created_at`, `payment_method`, `note`, `status`) VALUES
(9, 3, 'Testovací 10', 'Praha', '100 00', 'Česká republika', '2025-06-17 21:52:32', 'kartou', '', 'processing'),
(10, 3, 'Testovací 10', 'Praha', '100 00', 'Česká republika', '2025-06-17 21:54:34', 'dobírka', '', 'processing'),
(11, 3, 'Testovací 10', 'Praha 2', '100 00', 'Česká republika', '2025-06-17 21:55:17', 'dobírka', 'poznámka xd', 'processing'),
(12, 10, 'abc', 'def', '32165', 'AA', '2025-06-19 12:24:30', 'kartou', '', 'processing'),
(13, 10, 'abc', 'def', '32165', 'AA', '2025-06-19 12:28:45', 'dobírka', '', 'processing'),
(16, 3, 'Testovací 10', 'Praha 2', '100 00', 'Česká republika', '2025-06-20 09:35:40', 'dobírka', '', 'cancelled'),
(17, 3, 'Testovací 10', 'Praha 2', '100 00', 'Česká republika', '2025-06-20 10:52:05', 'dobírka', 'poznámka', 'processing'),
(18, 14, 'Pražská sídliště', 'Znojmo', '669 02', 'Česko', '2025-06-20 11:30:50', 'dobírka', '', 'delivered'),
(19, 14, 'Pražská sídliště', 'Znojmo', '669 02', 'Česko', '2025-06-20 12:04:08', 'dobírka', '', 'delivered'),
(20, 14, 'Pražská sídliště', 'Znojmo', '669 02', 'Česko', '2025-06-20 12:04:14', 'dobírka', '', 'processing');

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(12, 9, 1, 2, '22000.00'),
(13, 9, 4, 1, '17990.00'),
(14, 10, 1, 1, '22000.00'),
(15, 11, 4, 2, '17990.00'),
(16, 12, 1, 3, '22000.00'),
(17, 12, 5, 3, '7990.00'),
(18, 13, 4, 1, '17990.00'),
(21, 16, 1, 1, '2000.00'),
(22, 17, 1, 1, '2000.00'),
(23, 18, 1, 1, '2001.00'),
(24, 19, 1, 1, '2001.00'),
(25, 20, 5, 1, '7990.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `brand_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `display_size` decimal(4,2) NOT NULL,
  `ram` int(11) NOT NULL,
  `release_year` int(11) NOT NULL,
  `battery_capacity` int(11) NOT NULL,
  `deactivated` tinyint(1) DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `brand_id`, `name`, `price`, `description`, `image`, `display_size`, `ram`, `release_year`, `battery_capacity`, `deactivated`, `last_updated`) VALUES
(1, 1, 'iPhone 13', '2001.00', 'Výkonný iPhone s A15 Bionic čipem. test', 'iphone13.jpg', '6.00', 4, 2021, 3240, 0, '2025-06-20 10:21:55'),
(2, 2, 'Samsung Galaxy S22', '18990.00', 'Špičkový displej a výkon.', 'samsung_s22.jpg', '6.10', 8, 2022, 3700, 0, '2025-06-20 08:34:33'),
(3, 3, 'Xiaomi Redmi Note 12', '5990.00', 'Levný telefon s výdrží.', 'xiaomi12.jpg', '6.67', 6, 2023, 5000, 0, '2025-06-19 21:47:23'),
(4, 5, 'OnePlus 11', '17990.00', 'Vlajková loď OnePlus.', 'oneplus11.jpg', '6.70', 12, 2023, 5000, 0, '2025-06-20 08:58:33'),
(5, 5, 'Motorola Edge 30', '7990.00', 'Lehký a elegantní telefon.', 'motorola30.jpg', '6.50', 8, 2022, 4020, 0, '2025-06-19 21:47:23'),
(15, 1, 'testovací produkt', '3000.00', 'test', 'iphone13.jpg', '6.00', 6, 2025, 3000, 0, '2025-06-20 08:40:10'),
(17, 3, 'pikachu test', '6000.00', '', 'test2.jpg', '5.00', 10, 2022, 50, 0, '2025-06-19 23:29:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) DEFAULT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(100) NOT NULL,
  `is_admin` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `street`, `city`, `zip`, `country`, `is_admin`) VALUES
(3, 'test', 'test', 'test@test.test', '$2y$10$SccCGx2xfPoUvwk0UPab5OVPSxCZ0XGroOmI6Ccb19B1G0tcYBD6C', 'Testovací 10', 'Praha 2', '100 00', 'Česká republika', 0),
(9, 'admin', 'admin', 'admin@example.cz', '$2y$10$lqdLEgmPtGSYQoJpEGJ8Me5DYCSQPQkuHmBKADAczNpLMOwU1X2hi', 'Testovací', 'Test', '100 00', 'Česká republika', 1),
(10, 'abc', 'def', 'nguv03@vse.cz', '$2y$10$BqG.3AbJBwfwjIvr7BJZ7e4ENMzwCZtSkD.eeUzYPooNOWILRMG6y', 'abc', 'def', '32165', 'AA', 0),
(13, 'admin', 'admin', 'admin@example.com', '$2y$10$Cp9cgKBf8WzSSIXXBO1pJuTsfzC26VlxVYJSW7duqF1evJmBnbnqC', 'asd', 'asd', 'asd', 'asd', 1),
(14, 'Ivo', 'Vejmelka', 'veji03@vse.cz', '$2y$10$fZa7NIMDL4rusPOcNfZ5z.jSgaSJK3n/CTmMYhNXCrS.LwEctAgRy', 'Pražská sídliště', 'Znojmo', '669 02', 'Česko', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `brand_id` (`brand_id`);

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
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`brand_id`) REFERENCES `brands` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
