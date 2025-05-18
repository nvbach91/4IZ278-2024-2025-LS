CREATE TABLE `sp_roles` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_sp_roles_name` (`name`)
);

CREATE TABLE `sp_users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password_hash` VARCHAR(255) NOT NULL,
  `role_id` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `facebook_id` VARCHAR(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_sp_users_email` (`email`),
  UNIQUE KEY `ux_sp_users_facebook_id` (`facebook_id`),
  CONSTRAINT `fk_users_role` FOREIGN KEY (`role_id`) REFERENCES `sp_roles`(`id`)
);

CREATE TABLE `sp_event_types` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `version` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

CREATE TABLE `sp_events` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `description` TEXT,
  `location` VARCHAR(255),
  `start_datetime` DATETIME NOT NULL,
  `end_datetime` DATETIME NOT NULL,
  `event_type_id` INT NOT NULL,
  `created_by` INT NOT NULL,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `version` INT NOT NULL DEFAULT 1,
  `lock_timestamp` DATETIME DEFAULT NULL,
  `locked_by_user_id` INT DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_events_type` FOREIGN KEY (`event_type_id`) REFERENCES `sp_event_types`(`id`),
  CONSTRAINT `fk_events_user` FOREIGN KEY (`created_by`) REFERENCES `sp_users`(`id`),
  CONSTRAINT `fk_events_locked_by` FOREIGN KEY (`locked_by_user_id`) REFERENCES `sp_users`(`id`) ON DELETE SET NULL,
  INDEX `idx_lock_user` (`locked_by_user_id`, `lock_timestamp`)
);

CREATE TABLE `sp_seat_categories` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(50) NOT NULL,
  `price` DECIMAL(10,2) NOT NULL,
  `version` INT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`)
);

CREATE TABLE `sp_seats` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `event_id` INT NOT NULL,
  `row_index` SMALLINT NOT NULL,
  `col_index` SMALLINT NOT NULL,
  `seat_category_id` INT NOT NULL,
  `status` ENUM('free','reserved','sold') NOT NULL DEFAULT 'free',
  PRIMARY KEY (`id`),
  UNIQUE KEY `ux_seat_unique` (`event_id`,`row_index`,`col_index`),
  CONSTRAINT `fk_seats_event` FOREIGN KEY (`event_id`) REFERENCES `sp_events`(`id`),
  CONSTRAINT `fk_seats_category` FOREIGN KEY (`seat_category_id`) REFERENCES `sp_seat_categories`(`id`)
);

CREATE TABLE `sp_orders` (
  `order_id` INT NOT NULL AUTO_INCREMENT,
  `user_id` INT NOT NULL,
  `order_date` DATETIME DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`),
  CONSTRAINT `fk_orders_user` FOREIGN KEY (`user_id`) REFERENCES `sp_users`(`id`)
);

CREATE TABLE `sp_tickets` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `seat_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_tickets_order` FOREIGN KEY (`order_id`) REFERENCES `sp_orders`(`order_id`),
  CONSTRAINT `fk_tickets_seat` FOREIGN KEY (`seat_id`) REFERENCES `sp_seats`(`id`)
);

CREATE TABLE `sp_payments` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `order_id` INT NOT NULL,
  `amount` DECIMAL(10,2) NOT NULL,
  `payment_method` VARCHAR(50) NOT NULL,
  `status` VARCHAR(50) NOT NULL,
  `paid_at` DATETIME,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_payments_order` FOREIGN KEY (`order_id`) REFERENCES `sp_orders`(`order_id`)
);
