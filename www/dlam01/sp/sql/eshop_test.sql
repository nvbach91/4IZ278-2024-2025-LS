-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 06, 2025 at 01:23 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `eshop_test`
--

-- --------------------------------------------------------

--
-- Table structure for table `animals`
--

CREATE TABLE `animals` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `animals`
--

INSERT INTO `animals` (`id`, `name`, `description`) VALUES
(1, 'Dog', 'Loyal companion animals with various breeds and sizes'),
(2, 'Cat', 'Independent and graceful felines with different coat patterns'),
(3, 'Bird', 'Feathered pets ranging from small parakeets to large parrots'),
(4, 'Fish', 'Aquatic pets for freshwater or saltwater aquariums'),
(5, 'Reptile', 'Cold-blooded animals including turtles, lizards, and snakes'),
(6, 'Small Mammal', 'Includes hamsters, guinea pigs, rabbits, and ferrets');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'Food', 'Nutritional products for various pets'),
(2, 'Toys', 'Entertainment and exercise items'),
(3, 'Housing', 'Cages, tanks, beds, and habitats'),
(4, 'Health', 'Medicines, supplements, and grooming products'),
(5, 'Accessories', 'Collars, leashes, bowls, and other pet gear');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` int(11) DEFAULT NULL,
  `shipping_method_id` int(11) NOT NULL,
  `shipping_price` int(11) DEFAULT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `city` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `zip_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `status`, `shipping_method_id`, `shipping_price`, `total_price`, `city`, `street`, `zip_code`) VALUES
(2, 3, '2023-06-05 11:30:00', 3, 2, 13, 87.97, 'Chicago', '456 Oak Ave', '60601'),
(8, 3, '2025-06-04 08:18:21', 2, 4, 20, 119.98, 'City', 'Street', 'Zip'),
(9, 3, '2025-06-04 08:32:55', 2, 1, 6, 109.98, 's', 's', 's'),
(10, 3, '2025-06-04 08:34:39', 3, 1, 6, 109.98, 's', 's', 's'),
(11, 3, '2025-06-04 08:35:47', 2, 1, 6, 109.98, 's', 's', 's'),
(12, 3, '2025-06-04 08:36:07', 3, 1, 6, 109.98, 's', 's', 's'),
(13, 4, '2025-06-04 09:57:39', 2, 3, 0, 99.99, 'City', 'Street', 's'),
(14, 6, '2025-06-06 10:01:33', 1, 4, 20, 87.94, 'City', 'Street', '300'),
(15, 4, '2025-06-06 11:24:44', 1, 1, 6, 44.96, 'City', 'Street', '30100'),
(16, 4, '2025-06-06 11:32:11', 1, 1, 6, 14.98, 'City', 'Street', '30100'),
(17, 4, '2025-06-06 11:47:58', 1, 2, 13, 49.96, 'City', 'Street', '30000'),
(18, 5, '2025-06-06 12:30:43', 1, 1, 6, 23.97, 'City', 'Street', '30011'),
(19, 5, '2025-06-06 12:32:42', 2, 1, 6, 23.97, 'City', 'Street', '30100'),
(20, 5, '2025-06-06 13:01:34', 1, 4, 20, 56.96, 'City', 'Street', '30013'),
(21, 5, '2025-06-06 13:03:01', 1, 2, 13, 49.96, 'City', 'Street', '30011');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `price`) VALUES
(4, 12, NULL, 1, 99.99),
(5, 12, NULL, 1, 4.00),
(6, 13, NULL, 1, 99.99),
(7, 14, NULL, 1, 15.99),
(8, 14, 9, 1, 8.99),
(9, 14, 10, 1, 14.99),
(10, 14, 9, 1, 8.99),
(11, 14, NULL, 1, 18.99),
(12, 15, 10, 1, 14.99),
(13, 15, 9, 1, 8.99),
(14, 16, 9, 1, 8.99),
(15, 17, 9, 1, 8.99),
(16, 17, NULL, 1, 18.99),
(17, 18, 9, 1, 8.99),
(18, 19, 9, 2, 8.99),
(19, 20, 9, 2, 8.99),
(20, 20, NULL, 1, 18.99),
(21, 21, 9, 2, 8.99),
(22, 21, NULL, 1, 18.99);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `last_updated` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `price`, `stock`, `image`, `last_updated`, `category_id`) VALUES
(9, 'Fish Food Flakes', 'Complete nutrition for tropical fish, 5oz container', 8.99, 104, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 1),
(10, 'Dog Leash', '6-foot durable nylon leash with padded handle', 14.99, 0, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 5),
(13, 'Dog Bed', 'Orthopedic memory foam bed, large size', 59.99, 25, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 3),
(14, 'Aquarium Decor', 'Assorted plants and ornaments for fish tanks', 16.99, 90, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 5),
(15, 'Cat Dental Treats', 'Oral care treats that reduce plaque and tartar', 9.99, 150, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 1),
(16, 'Dog Training Treats', 'Soft, bite-sized treats perfect for obedience training, 8oz bag', 12.99, 85, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 1),
(17, 'Automatic Cat Feeder', 'Programmable 4-meal feeder with ice pack for wet food', 59.99, 25, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 5),
(18, 'Parrot Swing Toy', 'Colorful wooden swing with bells for medium to large birds', 16.99, 39, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 2),
(19, 'Reptile Terrarium Decor', 'Naturalistic rock cave and basking platform for reptiles', 34.99, 30, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 3),
(20, 'Dog Raincoat', 'Waterproof coat with reflective stripes, adjustable fit', 29.99, 45, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 5),
(21, 'Aquarium Filter Media', 'Bio-ceramic rings for superior biological filtration', 18.99, 120, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 4),
(22, 'Hamster Maze Set', 'Modular plastic tunnel system for small animals', 22.99, 35, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 2),
(23, 'Cat Window Perch', 'Suction cup mounted bed for window viewing', 27.99, 50, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 3),
(24, 'Dog Toothbrush Kit', 'Dual-headed brush with poultry-flavored toothpaste', 9.99, 95, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 4),
(25, 'Bird Calcium Block', 'Mineral supplement for beak health and egg production', 5.99, 200, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 4),
(26, 'Fish Net Set', '3-size aquarium net kit with extendable handles', 11.99, 60, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 5),
(27, 'Dog Cooling Mat', 'Self-cooling gel pad for hot weather, large size', 39.99, 40, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 3),
(28, 'Rabbit Hay Feeder', 'Hanging rack that keeps hay clean and accessible', 14.99, 55, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 5),
(29, 'Aquarium Heater', 'Adjustable 100W submersible heater with thermostat', 32.99, 30, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 3),
(30, 'Cat Laser Toy', 'Automatic rotating laser with 3 pattern modes', 19.99, 65, 'https://cdn.myshoptet.com/usr/www.petcenter.cz/user/shop/big/16335-1_biokat-s-bianco-fresh-control-podestylka-10kg.jpg?66929e46', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `product_animals`
--

CREATE TABLE `product_animals` (
  `product_id` int(11) NOT NULL,
  `animal_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product_animals`
--

INSERT INTO `product_animals` (`product_id`, `animal_id`) VALUES
(9, 4),
(10, 1),
(13, 1),
(14, 4),
(15, 2),
(16, 1),
(17, 2),
(18, 3),
(19, 5),
(20, 1),
(21, 4),
(22, 6),
(23, 2),
(24, 1),
(25, 3),
(26, 4),
(27, 1),
(28, 6),
(29, 4),
(30, 2);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `rating` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `shipping_method`
--

CREATE TABLE `shipping_method` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shipping_method`
--

INSERT INTO `shipping_method` (`id`, `name`, `price`) VALUES
(1, 'Standard Shipping', 5.99),
(2, 'Express Shipping', 12.99),
(3, 'In-Store Pickup', 0.00),
(4, 'Next Day Delivery', 19.99);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `secondName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `privilege` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `secondName`, `email`, `password`, `privilege`) VALUES
(3, 'manageres', 'druhe', 'manager@test.com', '$2y$10$Gcz9rSPzt3No07hd.n1W6OiNq3.xhb1CKPcyj2ePoQbM17r8O/74m', 2),
(4, 'admin', 'second', 'admin@test.com', '$2y$10$eewU1fUuXwEFeHf5IZNdouyglshblv2TC1oXmww72uxV9s.gR2Dee', 3),
(5, 'user', 'user2', 'user@email.com', '$2y$10$idhEJdzVbwEdfyarYuLIT.izDzSZLRDZN/pancj6WU5c2F.1nRJsW', 3),
(6, 'Jmeno', 'Prijmeni', 'test3@email.com', '$2y$10$oC0aCxKrahdapte9xUyqx./ecJW/btWiZzxE/oL4tiiq6LHXK9BpK', 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `animals`
--
ALTER TABLE `animals`
  ADD PRIMARY KEY (`id`);

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
  ADD KEY `user_id` (`user_id`),
  ADD KEY `shipping_method_id` (`shipping_method_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `fk_order_items_product` (`product_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category` (`category_id`);

--
-- Indexes for table `product_animals`
--
ALTER TABLE `product_animals`
  ADD PRIMARY KEY (`product_id`,`animal_id`),
  ADD KEY `animal_id` (`animal_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `shipping_method`
--
ALTER TABLE `shipping_method`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `animals`
--
ALTER TABLE `animals`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `shipping_method`
--
ALTER TABLE `shipping_method`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`shipping_method_id`) REFERENCES `shipping_method` (`id`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `fk_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `product_animals`
--
ALTER TABLE `product_animals`
  ADD CONSTRAINT `fk_product_animals_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `product_animals_ibfk_2` FOREIGN KEY (`animal_id`) REFERENCES `animals` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
