INSERT INTO `sp_roles` (`id`, `name`) VALUES 
(1, 'admin'),
(2, 'user');

INSERT INTO `sp_users` (`id`, `name`, `email`, `password_hash`, `role_id`) VALUES
(1, 'Admin User', 'admin@example.com', '$2y$10$VXzqO8skBSKpUmyEzVR65OVUKO4BMFoT2ddMZ8M6cG09fkznkRHmW', 1),
(2, 'John Doe', 'john@example.com', '$2y$10$VXzqO8skBSKpUmyEzVR65OVUKO4BMFoT2ddMZ8M6cG09fkznkRHmW', 2),
(3, 'Jane Smith', 'jane@example.com', '$2y$10$VXzqO8skBSKpUmyEzVR65OVUKO4BMFoT2ddMZ8M6cG09fkznkRHmW', 2),
(4, 'Robert Johnson', 'robert@example.com', '$2y$10$VXzqO8skBSKpUmyEzVR65OVUKO4BMFoT2ddMZ8M6cG09fkznkRHmW', 2),
(5, 'Emily Wilson', 'emily@example.com', '$2y$10$VXzqO8skBSKpUmyEzVR65OVUKO4BMFoT2ddMZ8M6cG09fkznkRHmW', 2),
(6, 'Admin User2', 'admin2@example.com', '$2y$10$VXzqO8skBSKpUmyEzVR65OVUKO4BMFoT2ddMZ8M6cG09fkznkRHmW', 1);

INSERT INTO `sp_event_types` (`id`, `name`) VALUES
(1, 'Concert'),
(2, 'Theater'),
(3, 'Sports'),
(4, 'Conference'),
(5, 'Festival');

INSERT INTO `sp_events` (`id`, `title`, `description`, `location`, `start_datetime`, `end_datetime`, `event_type_id`, `created_by`) VALUES
(1, 'Summer Music Festival', 'Annual summer music festival featuring local and international artists.', 'Central Park Arena', '2025-07-15 18:00:00', '2025-07-15 23:00:00', 1, 1),
(2, 'Hamlet', 'Shakespeare\'s classic tragedy performed by the National Theater Company.', 'City Theater', '2025-06-20 19:00:00', '2025-06-20 22:00:00', 2, 1),
(3, 'Football Championship Final', 'The final match of the national football championship.', 'National Stadium', '2025-06-20 15:00:00', '2025-06-20 17:00:00', 3, 1),
(4, 'Tech Innovations Conference', 'Annual conference showcasing the latest technological innovations.', 'Convention Center', '2025-08-05 09:00:00', '2025-08-07 18:00:00', 4, 1),
(5, 'Jazz Night', 'An evening of jazz music with renowned jazz musicians.', 'Blue Note Club', '2025-06-25 20:00:00', '2025-06-25 23:30:00', 1, 1),
(6, 'Ballet: Swan Lake', 'Classical ballet performance by the City Ballet Company.', 'Grand Opera House', '2025-07-30 19:30:00', '2025-07-30 22:00:00', 2, 1),
(7, 'Winter Festival', 'Celebrate the winter season with music, food, and activities.', 'City Square', '2025-12-15 16:00:00', '2025-12-15 22:00:00', 5, 1),
(8, 'Rock Legends Reunion', 'Legendary rock bands reunite for an epic concert experience.', 'Stadium Arena', '2025-08-12 17:00:00', '2025-08-12 23:30:00', 1, 1),
(9, 'A Midsummer Night\'s Dream', 'Shakespeare\'s beloved comedy brought to life on stage.', 'Community Theater', '2025-09-05 19:00:00', '2025-09-05 21:30:00', 2, 1),
(10, 'Basketball Tournament Finals', 'Championship game of the regional basketball tournament.', 'Sports Complex', '2025-08-28 19:00:00', '2025-08-28 21:00:00', 3, 1),
(11, 'AI and Machine Learning Summit', 'Conference focused on the latest advancements in AI technology.', 'Tech Center', '2025-10-15 09:00:00', '2025-10-17 17:00:00', 4, 1),
(12, 'Food & Wine Festival', 'Annual celebration of culinary arts featuring top chefs and wineries.', 'Riverside Park', '2025-09-22 12:00:00', '2025-09-24 20:00:00', 5, 1),
(13, 'Classical Symphony Orchestra', 'Performance of Beethoven\'s greatest symphonies.', 'Concert Hall', '2025-11-10 19:30:00', '2025-11-10 22:00:00', 1, 1),
(14, 'The Nutcracker Ballet', 'Annual holiday performance of the classic ballet.', 'Opera House', '2025-12-20 19:00:00', '2025-12-20 21:30:00', 2, 1),
(15, 'Tennis Championship', 'Final match of the international tennis tournament.', 'Tennis Stadium', '2025-01-15 14:00:00', '2025-01-15 17:00:00', 3, 1),
(16, 'Web Development Conference', 'Learn the latest trends and technologies in web development.', 'Digital Hub', '2025-02-05 09:00:00', '2025-02-07 17:00:00', 4, 1),
(17, 'Spring Flower Festival', 'Annual celebration of spring with flower displays and garden tours.', 'Botanical Gardens', '2025-04-10 10:00:00', '2025-04-10 18:00:00', 5, 1);

INSERT INTO `sp_seat_categories` (`id`, `name`, `price`) VALUES
(1, 'VIP', 1500.00),
(2, 'Premium', 1000.00),
(3, 'Standard', 750.00),
(4, 'Economy', 500.00);

INSERT INTO `sp_orders` (`order_id`, `user_id`, `order_date`) VALUES
(1, 2, DATE_SUB(NOW(), INTERVAL 7 DAY)),
(2, 3, DATE_SUB(NOW(), INTERVAL 5 DAY)),
(3, 4, DATE_SUB(NOW(), INTERVAL 3 DAY)),
(4, 2, DATE_SUB(NOW(), INTERVAL 2 DAY)),
(5, 5, DATE_SUB(NOW(), INTERVAL 1 DAY));

INSERT INTO `sp_seats` (`id`, `event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) VALUES
(1, 1, 1, 1, 1, 'sold'),
(2, 1, 1, 2, 1, 'sold'),
(3, 1, 1, 3, 1, 'sold'),
(4, 2, 1, 1, 1, 'sold'),
(5, 2, 2, 1, 2, 'sold'),
(6, 2, 2, 2, 2, 'sold');

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 1, 1, c, 1, 
    CASE 
        WHEN RAND() < 0.3 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 4 AS c UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS cols;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 1, 2, c, 1, 
    CASE 
        WHEN RAND() < 0.3 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 4 AS c UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS cols;

ALTER TABLE `sp_seats` AUTO_INCREMENT = 100;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 1, r, c, 2, 
    CASE 
        WHEN RAND() < 0.3 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 3 AS r UNION SELECT 4 UNION SELECT 5) AS row_vals,
    (SELECT 1 AS c UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS col_vals;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 1, r, c, 3, 
    CASE 
        WHEN RAND() < 0.3 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 6 AS r UNION SELECT 7 UNION SELECT 8) AS row_vals,
    (SELECT 1 AS c UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS col_vals;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 1, r, c, 4, 
    CASE 
        WHEN RAND() < 0.3 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 9 AS r UNION SELECT 10) AS row_vals,
    (SELECT 1 AS c UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10) AS col_vals;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 2, 1, c, 1, 
    CASE 
        WHEN RAND() < 0.4 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 2 AS c UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) AS cols;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 2, 2, c, 2, 
    CASE 
        WHEN RAND() < 0.4 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 3 AS c UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) AS cols;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 2, 3, c, 2, 
    CASE 
        WHEN RAND() < 0.4 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 1 AS c UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) AS cols;

INSERT INTO `sp_seats` (`event_id`, `row_index`, `col_index`, `seat_category_id`, `status`) 
SELECT 2, r, c, 3, 
    CASE 
        WHEN RAND() < 0.4 THEN 'sold'
        ELSE 'free'
    END
FROM 
    (SELECT 4 AS r UNION SELECT 5) AS row_vals,
    (SELECT 1 AS c UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION SELECT 7 UNION SELECT 8) AS col_vals;

INSERT INTO `sp_tickets` (`order_id`, `seat_id`) VALUES
(1, 1),
(1, 2),
(2, 3),
(3, 4),
(4, 5),
(4, 6);

INSERT INTO `sp_payments` (`id`, `order_id`, `amount`, `payment_method`, `status`, `paid_at`) VALUES
(1, 1, 2500.00, 'card', 'completed', DATE_SUB(NOW(), INTERVAL 7 DAY)),
(2, 2, 750.00, 'card', 'completed', DATE_SUB(NOW(), INTERVAL 5 DAY)),
(3, 3, 1000.00, 'test', 'completed', DATE_SUB(NOW(), INTERVAL 3 DAY)),
(4, 4, 1750.00, 'card', 'completed', DATE_SUB(NOW(), INTERVAL 2 DAY));