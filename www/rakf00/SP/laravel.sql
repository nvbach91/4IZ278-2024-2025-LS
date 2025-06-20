-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Pát 20. čen 2025, 11:11
-- Verze serveru: 8.0.42-0ubuntu0.24.04.1
-- Verze PHP: 8.2.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `laravel`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `accounts`
--

CREATE TABLE `accounts` (
  `id` int NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` decimal(12,2) DEFAULT '0.00',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `balance`, `created_at`, `updated_at`) VALUES
(373876195, '-', 0.00, '2025-06-20 09:26:07', '2025-06-20 09:26:07'),
(525377808, 'Na dovolenou', 49509.00, '2025-06-17 12:28:38', '2025-06-20 10:17:18'),
(739614986, 'hjhjh', 1130760.00, '2025-06-17 12:13:56', '2025-06-20 11:07:23'),
(784582044, 'Test account', 99799.00, '2025-06-17 09:09:43', '2025-06-19 09:55:59'),
(784582045, 'Hlavní účet', 10500.75, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582046, 'Spořicí účet', 8230.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582047, 'Denní peněženka', 150.40, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582048, 'Nouzový fond', 21500.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582049, 'Investiční účet', 375.90, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582050, 'Cestovní rozpočet', 9000.25, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582051, 'Účet pro domácnost', 720.10, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582052, 'Rezerva na auto', 13200.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582053, 'Zábava & volný čas', 4800.60, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582054, 'Účet pro dárky', 250.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582055, 'Účet na nájem', 11750.33, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582056, 'Dovolená 2025', 623.40, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582057, 'Fond na vzdělání', 45600.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582058, 'Technologie & gadgety', 895.75, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582059, 'Zdravotní výdaje', 1200.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582060, 'Jídlo & restaurace', 999.99, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582061, 'Sportovní vybavení', 305.50, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582062, 'Účet pro děti', 6050.20, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582063, 'Projekt \"Nová kuchyň\"', 7000.00, '2025-06-17 11:33:28', '2025-06-17 11:33:28'),
(784582064, 'Bitcoin & Krypto', 945.15, '2025-06-17 11:33:28', '2025-06-17 12:26:12'),
(885295836, 'another acc', 4343.00, '2025-06-17 11:42:52', '2025-06-17 12:12:38'),
(919692992, 'pikachu', 6499.00, '2025-06-19 08:36:02', '2025-06-20 09:31:52');

-- --------------------------------------------------------

--
-- Struktura tabulky `account_memberships`
--

CREATE TABLE `account_memberships` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `user_id` int NOT NULL,
  `role` enum('admin','moderator','member') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `joined_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `account_memberships`
--

INSERT INTO `account_memberships` (`id`, `account_id`, `user_id`, `role`, `joined_at`) VALUES
(16, 784582044, 112, 'admin', '2025-06-17 11:27:36'),
(17, 784582044, 114, 'moderator', '2025-06-17 11:27:36'),
(18, 784582044, 115, 'member', '2025-06-17 11:27:36'),
(59, 784582045, 116, 'admin', '2023-01-10 00:00:00'),
(60, 784582045, 117, 'member', '2023-03-15 00:00:00'),
(61, 784582046, 118, 'admin', '2022-11-08 00:00:00'),
(62, 784582046, 119, 'moderator', '2023-02-01 00:00:00'),
(63, 784582047, 120, 'admin', '2023-06-17 00:00:00'),
(64, 784582047, 121, 'member', '2023-07-03 00:00:00'),
(65, 784582048, 122, 'admin', '2024-01-05 00:00:00'),
(66, 784582048, 123, 'member', '2024-02-10 00:00:00'),
(67, 784582049, 124, 'admin', '2023-12-25 00:00:00'),
(68, 784582049, 125, 'moderator', '2024-01-14 00:00:00'),
(69, 784582050, 126, 'admin', '2022-10-20 00:00:00'),
(70, 784582050, 127, 'member', '2023-01-30 00:00:00'),
(71, 784582051, 128, 'admin', '2024-05-04 00:00:00'),
(72, 784582051, 129, 'moderator', '2024-05-22 00:00:00'),
(73, 784582052, 130, 'admin', '2023-08-08 00:00:00'),
(74, 784582052, 116, 'member', '2023-08-22 00:00:00'),
(75, 784582053, 117, 'admin', '2023-11-19 00:00:00'),
(76, 784582053, 118, 'moderator', '2023-12-01 00:00:00'),
(77, 784582054, 119, 'admin', '2024-03-03 00:00:00'),
(78, 784582054, 120, 'member', '2024-03-15 00:00:00'),
(79, 784582055, 121, 'admin', '2023-09-27 00:00:00'),
(80, 784582055, 122, 'moderator', '2023-10-10 00:00:00'),
(81, 784582056, 123, 'admin', '2022-12-12 00:00:00'),
(82, 784582056, 124, 'member', '2023-01-01 00:00:00'),
(83, 784582057, 125, 'admin', '2023-04-04 00:00:00'),
(84, 784582057, 126, 'moderator', '2023-04-20 00:00:00'),
(85, 784582058, 127, 'admin', '2023-05-05 00:00:00'),
(86, 784582058, 128, 'member', '2023-06-06 00:00:00'),
(87, 784582059, 129, 'admin', '2024-02-02 00:00:00'),
(88, 784582059, 130, 'moderator', '2024-03-03 00:00:00'),
(89, 784582060, 116, 'admin', '2023-07-07 00:00:00'),
(90, 784582060, 117, 'member', '2023-07-21 00:00:00'),
(91, 784582061, 118, 'admin', '2024-04-04 00:00:00'),
(92, 784582061, 119, 'moderator', '2024-04-18 00:00:00'),
(93, 784582062, 120, 'admin', '2022-09-09 00:00:00'),
(94, 784582062, 121, 'member', '2022-10-01 00:00:00'),
(95, 784582063, 122, 'admin', '2023-11-11 00:00:00'),
(96, 784582063, 123, 'moderator', '2023-11-22 00:00:00'),
(97, 784582064, 124, 'admin', '2023-06-06 00:00:00'),
(98, 784582064, 125, 'member', '2023-06-20 00:00:00'),
(99, 784582044, 117, 'member', '2023-02-14 00:00:00'),
(101, 784582044, 121, 'member', '2023-08-10 00:00:00'),
(103, 784582044, 126, 'member', '2023-11-17 00:00:00'),
(105, 885295836, 112, 'admin', '2025-06-17 11:42:52'),
(106, 739614986, 103, 'admin', '2025-06-17 12:13:56'),
(107, 525377808, 115, 'admin', '2025-06-17 12:28:38'),
(108, 919692992, 131, 'admin', '2025-06-19 08:36:02'),
(111, 739614986, 131, 'moderator', '2025-06-20 09:24:00'),
(112, 373876195, 131, 'admin', '2025-06-20 09:26:07'),
(114, 784582052, 103, 'admin', '2025-06-17 11:27:36'),
(115, 784582055, 103, 'member', '2025-06-17 11:27:36');

-- --------------------------------------------------------

--
-- Struktura tabulky `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `account_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `recipient_account_id` int DEFAULT NULL,
  `type_id` int NOT NULL,
  `amount` decimal(12,2) NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `transactions`
--

INSERT INTO `transactions` (`id`, `account_id`, `user_id`, `recipient_account_id`, `type_id`, `amount`, `description`, `created_at`) VALUES
(31, 739614986, 103, 5, 1, -10.00, 'test', '2025-06-20 10:15:40'),
(32, 739614986, 103, 525377808, 1, -9.00, 'testik', '2025-06-20 10:17:18'),
(33, 739614986, NULL, 525377808, 1, 9.00, 'testik', '2025-06-20 10:17:18'),
(34, 739614986, 103, NULL, 2, 90909.00, NULL, '2025-06-20 10:25:00'),
(35, 739614986, 103, 8898, 1, -9.00, NULL, '2025-06-20 11:07:23');

-- --------------------------------------------------------

--
-- Struktura tabulky `transaction_types`
--

CREATE TABLE `transaction_types` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `transaction_types`
--

INSERT INTO `transaction_types` (`id`, `name`) VALUES
(1, 'Platba'),
(2, 'Vklad');

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `surname` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `avatar_path` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `username`, `email`, `password`, `avatar_path`, `created_at`, `updated_at`) VALUES
(103, 'Filip', 'Rakus', 'rakf000', 'test@test.com', '$2y$12$KRKjNo/.M5Mm2mmful7sVuoUhikXwtjygkhaOsWWJgqjce.lD0GUK', 'images/profilePhotos/685525c26461e.jpg', '2025-05-04 17:16:54', '2025-06-20 09:11:30'),
(112, 'Admin', 'Dominatore', 'adtes578', 'admin@test.com', '$2y$12$x9ENz98YkzQDQXeytVKeX.wjBgXvM99P06/IYmbzBYoqXAEw4kNV2', 'images/profilePhotos/68515f311fb7f.jpg', '2025-06-17 11:23:29', '2025-06-17 12:27:52'),
(114, 'Moderator', 'Test', 'motes578', 'moderator@test.com', '$2y$12$x9ENz98YkzQDQXeytVKeX.wjBgXvM99P06/IYmbzBYoqXAEw4kNV2', '', '2025-06-17 11:23:29', '2025-06-17 11:23:29'),
(115, 'Member', 'Test', 'metes578', 'member@test.com', '$2y$12$x9ENz98YkzQDQXeytVKeX.wjBgXvM99P06/IYmbzBYoqXAEw4kNV2', '', '2025-06-17 11:23:29', '2025-06-17 11:27:50'),
(116, 'Adam', 'Novák', 'abc123', 'adam.novak@example.com', '$2y$10$abcde1234567890fghijklm', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(117, 'Eva', 'Dvořáková', 'xyz456', 'eva.dvorakova@example.com', '$2y$10$12345abcde67890fghij', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(118, 'Jan', 'Svoboda', 'qwe789', 'jan.svoboda@example.com', '$2y$10$qwert123456asdfghjkl', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(119, 'Petra', 'Bílá', 'zxc321', 'petra.bila@example.com', '$2y$10$zxcvb09876asdfghjklm', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(120, 'Lukáš', 'Král', 'asd654', 'lukas.kral@example.com', '$2y$10$asdfg56789qwertyuio', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(121, 'Lucie', 'Malá', 'fgh987', 'lucie.mala@example.com', '$2y$10$fghij23456zxcvbnmlk', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(122, 'Tomáš', 'Horák', 'jkl012', 'tomas.horak@example.com', '$2y$10$jklop12345asdfghjkl', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(123, 'Martina', 'Pokorná', 'vbn345', 'martina.pokorna@example.com', '$2y$10$vbnmqw09876lkjhgfds', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(124, 'Radek', 'Sedlák', 'ert678', 'radek.sedlak@example.com', '$2y$10$ertyui98765zxcvbnml', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(125, 'Hana', 'Urbanová', 'uio901', 'hana.urbanova@example.com', '$2y$10$uiop09876asdfghjklz', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(126, 'David', 'Černý', 'mnb234', 'david.cerny@example.com', '$2y$10$mnbvcx23456lkjhgfds', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(127, 'Tereza', 'Kučerová', 'lkj567', 'tereza.kucerova@example.com', '$2y$10$lkjhgf09876zxcvbnmq', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(128, 'Josef', 'Růžička', 'poi890', 'josef.ruzicka@example.com', '$2y$10$poiuyt56789asdfghjk', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(129, 'Barbora', 'Fialová', 'ghj123', 'barbora.fialova@example.com', '$2y$10$ghjkl09876qwertyui', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(130, 'Michal', 'Procházka', 'nmz456', 'michal.prochazka@example.com', '$2y$10$nmzxcv56789asdfghj', NULL, '2025-06-17 11:32:19', '2025-06-17 11:32:19'),
(131, 'Nguv', 'Nguv', 'ngngu708', 'nguv03@vse.cz', '$2y$12$XYXV7FJ9qBcEQs5kFDWWr.HX0xa.AubUgO65VMWYR01cpKMspUjA2', 'images/profilePhotos/6855261b04bdb.jpg', '2025-06-19 08:35:51', '2025-06-20 09:12:59');

--
-- Indexy pro exportované tabulky
--

--
-- Indexy pro tabulku `accounts`
--
ALTER TABLE `accounts`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `account_memberships`
--
ALTER TABLE `account_memberships`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uq_account_user` (`account_id`,`user_id`),
  ADD KEY `account_id` (`account_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexy pro tabulku `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`),
  ADD KEY `idx_transaction_account` (`account_id`),
  ADD KEY `idx_transaction_user` (`user_id`),
  ADD KEY `idx_transaction_type` (`type_id`);

--
-- Indexy pro tabulku `transaction_types`
--
ALTER TABLE `transaction_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexy pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `accounts`
--
ALTER TABLE `accounts`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=919692993;

--
-- AUTO_INCREMENT pro tabulku `account_memberships`
--
ALTER TABLE `account_memberships`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=116;

--
-- AUTO_INCREMENT pro tabulku `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pro tabulku `transaction_types`
--
ALTER TABLE `transaction_types`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `account_memberships`
--
ALTER TABLE `account_memberships`
  ADD CONSTRAINT `account_memberships_ibfk_1` FOREIGN KEY (`account_id`) REFERENCES `accounts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `account_memberships_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Omezení pro tabulku `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `transactions_ibfk_3` FOREIGN KEY (`type_id`) REFERENCES `transaction_types` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
