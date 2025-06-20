-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost:3306
-- Vytvořeno: Úte 17. čen 2025, 21:27
-- Verze serveru: 10.5.23-MariaDB-0+deb11u1
-- Verze PHP: 8.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `adaj12`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
(1, 'Dlaždice'),
(2, 'Kreativní'),
(3, 'Slovní'),
(4, 'Vlaková');

-- --------------------------------------------------------

--
-- Struktura tabulky `genres`
--

CREATE TABLE `genres` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Strategická'),
(2, 'Rodinná'),
(3, 'Párty');

-- --------------------------------------------------------

--
-- Struktura tabulky `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` datetime NOT NULL,
  `status` varchar(50) NOT NULL,
  `shipping_address` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `date`, `status`, `shipping_address`) VALUES
(1, 2, '2025-06-16 19:05:38', 'nová', '{\"name\":\"Marek Gernert\",\"street\":\"Micmanice 333\",\"postal_code\":\"67129\",\"city\":\"Strachotice\",\"phone\":\"739832783\",\"email\":\"flintaf963@gmail.com\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"prevod\"}'),
(2, 2, '2025-06-16 19:09:15', 'zpracovává se', '{\"name\":\"Marek Gernert\",\"street\":\"Micmanice 333\",\"city\":\"Strachotice\",\"postal_code\":\"25555\",\"email\":\"flintaf963@gmail.com\",\"phone\":\"739832783\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"prevod\"}'),
(3, 2, '2025-06-16 19:12:01', 'nová', '{\"name\":\"Marek Gernert\",\"street\":\"Micmanice 333\",\"city\":\"Strachotice\",\"psc\":\"255\",\"email\":\"\",\"phone\":\"\"}'),
(5, NULL, '2025-06-16 19:37:05', 'dodáno', '{\"name\":\"Jakub Adam\",\"street\":\"Micmanice 333\",\"city\":\"Strachotice\",\"psc\":\"67129\",\"email\":\"\",\"phone\":\"\"}'),
(6, 2, '2025-06-16 20:00:29', 'dodáno', '{\"name\":\"Frantim\\u00edr Pe\\u0161ek\",\"street\":\"Micmanice 222\",\"postal_code\":\"465456\",\"city\":\"Znojmo\",\"phone\":\"739832735\",\"email\":\"flintaf963@gmail.com\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"online\"}'),
(7, 2, '2025-06-16 22:49:52', 'dodáno', '{\"name\":\"Frantim\\u00edr Pe\\u0161ek\",\"street\":\"Micmanice 222\",\"postal_code\":\"465456\",\"city\":\"Znojmo\",\"phone\":\"739832735\",\"email\":\"flintaf963@gmail.com\",\"shipping_method\":\"zasilkovna\",\"payment_method\":\"prevod\"}'),
(8, 2, '2025-06-17 12:19:36', 'dodáno', '{\"name\":\"Frantimír Pešek\",\"street\":\"Micmanice 222\",\"city\":\"Znojmo\",\"psc\":\"255\",\"email\":\"\",\"phone\":\"\"}'),
(9, NULL, '2025-06-17 12:36:23', 'dodáno', '{\"name\":\"Marek Slaný\",\"street\":\"Sadová 22\",\"city\":\"Kamenice\",\"postal_code\":\"564654\",\"email\":\"slany.marek@gmail.com\",\"phone\":\"6000000\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"prevod\"}'),
(10, 8, '2025-06-17 18:19:56', 'nová', '{\"name\":\"sda\",\"street\":\"sad\",\"postal_code\":\"dsa\",\"city\":\"sda\",\"phone\":\"sda\",\"email\":\"janik@michael.cz\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"prevod\"}'),
(11, 8, '2025-06-17 18:40:08', 'nová', '{\"name\":\"Marek Glaber\",\"street\":\"Sadov\\u00e1 23\",\"postal_code\":\"25168\",\"city\":\"Znojmo\",\"phone\":\"789789789\",\"email\":\"janik@michael.cz\",\"shipping_method\":\"zasilkovna\",\"payment_method\":\"prevod\"}'),
(12, NULL, '2025-06-17 18:48:01', 'dodáno', '{\"name\":\"Marek Tomášc\",\"street\":\"Sadová 23\",\"city\":\"Kamenice\",\"postal_code\":\"25168\",\"email\":\"martinos@adaj.cz\",\"phone\":\"789789789\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"dobirka\"}'),
(13, 13, '2025-06-17 19:18:03', 'nová', '{\"name\":\"Jakub Adam\",\"street\":\"Sadov\\u00e1 23\",\"postal_code\":\"25168\",\"city\":\"Kamenice\",\"phone\":\"739789789\",\"email\":\"adaj12@vse.cz\",\"shipping_method\":\"zasilkovna\",\"payment_method\":\"prevod\"}'),
(14, NULL, '2025-06-17 21:12:18', 'dodáno', '{\"name\":\"Marek Marek\",\"street\":\"Sadová 23\",\"city\":\"Kamenice\",\"postal_code\":\"25168\",\"email\":\"martinos@adaj.cz\",\"phone\":\"789789789\",\"shipping_method\":\"ceska_posta\",\"payment_method\":\"online\"}');

-- --------------------------------------------------------

--
-- Struktura tabulky `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `game_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `game_id`, `quantity`, `price`) VALUES
(1, 2, 13, 9, '499.00'),
(2, 2, 14, 1, '599.00'),
(3, 3, 14, 1, '599.00'),
(4, 3, 13, 1, '499.00'),
(7, 5, 13, 2, '499.00'),
(8, 5, 14, 1, '599.00'),
(9, 5, 15, 1, '349.00'),
(10, 6, 14, 9, '599.00'),
(11, 7, 14, 1, '599.00'),
(12, 8, 13, 1, '499.00'),
(13, 9, 14, 1, '599.00'),
(14, 10, 13, 4, '499.00'),
(15, 10, 15, 2, '349.00'),
(16, 10, 14, 2, '599.00'),
(17, 11, 14, 1, '599.00'),
(18, 12, 13, 1, '499.00'),
(19, 12, 14, 1, '599.00'),
(20, 13, 13, 1, '499.00'),
(21, 14, 13, 1, '499.00'),
(22, 14, 14, 1, '599.00'),
(23, 14, 15, 4, '349.00');

-- --------------------------------------------------------

--
-- Struktura tabulky `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `stock` int(11) NOT NULL,
  `min_age` int(11) DEFAULT NULL,
  `max_age` int(11) DEFAULT NULL,
  `tag` varchar(255) DEFAULT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `detail`, `price`, `image`, `stock`, `min_age`, `max_age`, `tag`, `genre_id`, `category_id`) VALUES
(13, 'Carcassonne', 'Strategická hra s kartičkami.', 'Strategická hra s kartičkami, kde hráči společně vytváří krajinu středověkého města Carcassonne. Každý hráč pokládá dílky, čímž staví města, cesty a kláštery a umisťuje své figurky, aby získal co nejvíce bodů.', '499.00', 'carcassonne.jpg', 12, 7, 99, 'strategická', 1, 1),
(14, 'Dixit', 'Kreativní hra pro rodiny.', 'Kreativní hra pro rodiny i přátele, která rozvíjí představivost a fantazii. Hráči pomocí nádherně ilustrovaných karet vytváří příběhy, hádají, která karta patří ke kterému příběhu, a snaží se přelstít ostatní. Dixit je plná originálních ilustrací a nečekaných nápadů.', '599.00', 'dixit.jpg', 8, 8, 99, 'kreativní', 2, 2),
(15, 'Codenames', 'Párty hra se slovy.', 'Párty hra se slovy, kde dva týmy soupeří v odhalování správných slov podle nápověd svého kapitána. Kapitán může říct jediné slovo a číslo, a jeho tým se snaží správně určit, které karty má na mysli. Hra prověří vaši schopnost asociace a týmové spolupráce.', '349.00', 'codenames.jpg', 15, 10, 99, 'párty', 3, 3),
(16, 'Ticket to Ride', 'Cestujte po světě vlaky a sbírejte body.', 'Cestujte po světě vlaky, sbírejte body za propojení měst a splnění tajných tras. Ticket to Ride je pohodová, ale napínavá strategická hra s jednoduchými pravidly, kde si plánujete vlastní železniční síť a soupeříte o nejlepší tratě s ostatními hráči.', '899.00', 'ticket.jpg', 10, 8, 99, 'vlaková', 1, 4),
(17, 'Azul', 'Strategická abstraktní hra s dlaždicemi.', 'Strategická abstraktní hra s dlaždicemi inspirovaná portugalským uměním. Hráči střídavě vybírají a skládají barevné dlaždice do svého vzoru na herním plánu, čímž získávají body za chytré kombinace a estetickou skladbu. Jednoduchá pravidla a krásné komponenty z ní dělají hit každého stolu.', '799.00', 'azul.jpg', 7, 8, 99, 'abstraktní', 2, 2),
(18, 'Dobble', 'Rychlá postřehová hra pro každého.', 'Rychlá postřehová hra pro každého. Na každé kartě je několik různých symbolů a hráči musí co nejrychleji najít a pojmenovat společný symbol mezi dvěma kartami. Dobble je ideální na párty, do rodiny i na cesty díky své jednoduchosti a svižnému tempu.', '500.00', 'dobble.jpg', 15, 6, 99, 'postřehová', 3, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `role` varchar(50) NOT NULL,
  `shipping_name` varchar(255) DEFAULT NULL,
  `shipping_street` varchar(255) DEFAULT NULL,
  `shipping_postal_code` varchar(20) DEFAULT NULL,
  `shipping_city` varchar(100) DEFAULT NULL,
  `shipping_phone` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `avatar`, `role`, `shipping_name`, `shipping_street`, `shipping_postal_code`, `shipping_city`, `shipping_phone`) VALUES
(2, 'Majkl', 'flintaf963@gmail.com', '$2y$10$FRmOHRCrdj7AWyM0J.UFFe82Rn79j7fZtN3jL2BEWaKsgAT60zFcy', '/~adaj12/test/assets/avatars/girl3.png', 'user', 'Vlastimír Majkl', 'Znojmo 255', '465456', 'Znojmo', '789545789'),
(4, 'Jacob', 'Jakudasdasdadasdad@gmail.com', '$2y$10$6iYWwUyeAlGS/gNW/dxDlefSS2ID2PU35PIi1vKghUrNgsjyaO/sC', '/~adaj12/test/assets/avatars/girl1.png', 'user', NULL, NULL, NULL, NULL, NULL),
(5, 'admin', 'admin@deskovkarna.cz', '$2y$10$B..KET1YJReOvF.Nl7/5W.G8BrhHON3CQCJIghk2MCzHpzkMCi7CS', NULL, 'admin', NULL, NULL, NULL, NULL, NULL),
(6, 'Mirek marek', 'neco@neco.cz', '$2y$10$YrJS8XMdPDkk5AimNm.MO.XtTVDLis7Wze3EjvkwRjkBd8.GPs8TS', NULL, 'user', NULL, NULL, NULL, NULL, NULL),
(8, 'Michael Janík', 'janik@michael.cz', '$2y$10$DGAvqpfLiDSb1GRT0dHfge.rU1W6fZT.a20pN/BESZSkyVMO13Tai', '', 'user', 'Marek Glaber', 'Sadová 23', '25168', 'Znojmo', '789789789'),
(9, 'neco neco', 'janda@novak.cz', '$2y$10$el0lE.g5860F5fY5EGOWBOigxqCX4RLybKDUhMhvVtF64dG24JCru', NULL, 'user', NULL, NULL, NULL, NULL, NULL),
(10, 'asda', 'asda@asda.cz', '$2y$10$nYYA4gkiPLCwQe6gj9p5t.9Q2FMAAy4DF7bJSZbDk6EmreFnkhSyq', NULL, 'user', NULL, NULL, NULL, NULL, NULL),
(11, 'asdasd', 'asdasd@asdasd.cz', '$2y$10$pn9aEzm7nXl9G3jM5aKUROff8yp0uz/LwTKGtuwVvPVk8D7tA4J5u', NULL, 'user', NULL, NULL, NULL, NULL, NULL),
(13, 'Jakub', 'adaj12@vse.cz', '$2y$10$SoaHI6sFNJ6m1qNxRteDoOKRIG/onILZD6Z1Ubl4mdy.2ftr5QJA6', NULL, 'user', 'Jakub Adam', 'Sadová 23', '25168', 'Kamenice', '739789789'),
(14, 'admi', 'admin@admin.cz', '$2y$10$LZVCSdE7GywvgHWplvET6OMuGHwxhN7LhmpFMy7YZFIHQprw93ZoK', NULL, 'admin', NULL, NULL, NULL, NULL, NULL);

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexy pro tabulku `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `game_id` (`game_id`);

--
-- Indexy pro tabulku `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pro tabulku `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pro tabulku `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pro tabulku `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT pro tabulku `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Omezení pro tabulku `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`game_id`) REFERENCES `products` (`id`);

--
-- Omezení pro tabulku `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
