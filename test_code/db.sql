DROP DATABASE IF EXISTS `jongjis`;
CREATE DATABASE IF NOT EXISTS `jongjis`
    COLLATE utf8mb4_unicode_ci;

USE `jongjis`;

DROP TABLE IF EXISTS `tbl_advertisements`;
CREATE TABLE `tbl_advertisements` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `ads_name` varchar(30) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `banner_image` blob NOT NULL,
  `description` varchar(100) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `location` int(1) NOT NULL,
  `amount` float NOT NULL,
  `user_id` int(11),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_bike_categories`;
CREATE TABLE `tbl_bike_categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `category_name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_bike_brands`;
CREATE TABLE `tbl_bike_brands` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `brand_name` varchar(30) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_bikes`;
CREATE TABLE `tbl_bikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bike_category_id` int(11),
  `shop_id` int(11),
  `bike_name` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `weight` varchar(10),
  `height` varchar(10),
  `rent_price` float NOT NULL,
  `availability` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_clients`;
CREATE TABLE `tbl_clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `client_code` varchar(15) NOT NULL,
  `profile` varchar(255),
  `client_name` varchar(30) NOT NULL,
  `email_address` varchar(30) NOT NULL,
  `contact_number` varchar(15) NOT NULL,
  `complete_address` varchar(100) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_payments`;
CREATE TABLE `tbl_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `rental_id` int(11),
  `payment_type` int(1) NOT NULL,
  `paid_by` varchar(30) NOT NULL,
  `payment_date` date NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `user_id` int(11),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_penalties`;
CREATE TABLE `tbl_penalties` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `rental_id` int(11),
  `penalty_amount` float NOT NULL,
  `payment_status` int(1) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `paid_by` varchar(30) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_rentals`;
CREATE TABLE `tbl_rentals` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `bike_id` int(11),
  `client_id` int(11),
  `rental_start_date` date NOT NULL,
  `rental_end_date` date NOT NULL,
  `total_amount` float NOT NULL,
  `payment_status` int(1) NOT NULL,
  `rental_status` int(1) NOT NULL,
  `remarks` varchar(100) NOT NULL,
  `user_id` int(11),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_shops`;
CREATE TABLE `tbl_shops` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `shop_name` varchar(50) NOT NULL,
  `owner_name` varchar(30) NOT NULL,
  `address` varchar(100) NOT NULL,
  `email_address` varchar(30) NOT NULL,
  `contact_no` varchar(50) NOT NULL,
  `website` varchar(30) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `map_lat` varchar(20),
  `map_lng` varchar(20),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_users`;
CREATE TABLE `tbl_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `email` varchar(30) NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile` varchar(255),
  `username` varchar(30) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `contact` varchar(15) NOT NULL,
  `user_group_id` int(11),
  `remember_token` varchar(100),
  `status` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_images`;
CREATE TABLE `tbl_images` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `is_featured` int(1) NOT NULL,
  `file` varchar(255) NOT NULL,
  `image_type` enum('type_bike', 'type_shop'),
  `related_id` int(11),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

DROP TABLE IF EXISTS `tbl_user_groups`;
CREATE TABLE `tbl_user_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `group_name` varchar(30) NOT NULL,
  `description` varchar(50) NOT NULL,
  `allow_add` int(1) NOT NULL,
  `allow_edit` int(1) NOT NULL,
  `allow_delete` int(1) NOT NULL,
  `allow_print` int(1) NOT NULL,
  `allow_import` int(1) NOT NULL,
  `allow_export` int(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
);

ALTER TABLE `tbl_advertisements`
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_bikes`
  ADD KEY `bike_category_id` (`bike_category_id`),
  ADD KEY `shop_id` (`shop_id`);

ALTER TABLE `tbl_payments`
  ADD KEY `rental_id` (`rental_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_penalties`
  ADD KEY `rental_id` (`rental_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_rentals`
  ADD KEY `bike_id` (`bike_id`),
  ADD KEY `client_id` (`client_id`),
  ADD KEY `user_id` (`user_id`);

ALTER TABLE `tbl_shops`
  ADD KEY `updated_by` (`updated_by`);

ALTER TABLE `tbl_users`
  ADD KEY `user_category_id` (`user_group_id`);

ALTER TABLE `tbl_advertisements`
  ADD CONSTRAINT `tbl_advertisements_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_advertisements_ibfk_2` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shops` (`id`);

ALTER TABLE `tbl_bikes`
  ADD CONSTRAINT `tbl_bikes_ibfk_2` FOREIGN KEY (`bike_category_id`) REFERENCES `tbl_bike_categories` (`id`),
  ADD CONSTRAINT `tbl_bikes_ibfk_3` FOREIGN KEY (`shop_id`) REFERENCES `tbl_shops` (`id`);

ALTER TABLE `tbl_payments`
  ADD CONSTRAINT `tbl_payments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_payments_ibfk_2` FOREIGN KEY (`rental_id`) REFERENCES `tbl_rentals` (`id`);

ALTER TABLE `tbl_penalties`
  ADD CONSTRAINT `tbl_penalities_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_penalities_ibfk_2` FOREIGN KEY (`rental_id`) REFERENCES `tbl_rentals` (`id`);

ALTER TABLE `tbl_rentals`
  ADD CONSTRAINT `tbl_rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `tbl_users` (`id`),
  ADD CONSTRAINT `tbl_rentals_ibfk_2` FOREIGN KEY (`bike_id`) REFERENCES `tbl_bikes` (`id`),
  ADD CONSTRAINT `tbl_rentals_ibfk_3` FOREIGN KEY (`client_id`) REFERENCES `tbl_clients` (`id`);

ALTER TABLE `tbl_shops`
  ADD CONSTRAINT `tbl_shop_info_ibfk_1` FOREIGN KEY (`updated_by`) REFERENCES `tbl_users` (`id`);

ALTER TABLE `tbl_users`
  ADD CONSTRAINT `tbl_users_ibfk_1` FOREIGN KEY (`user_group_id`) REFERENCES `tbl_user_groups` (`id`);
ALTER TABLE `tbl_clients` 
 CHANGE `email_address` `email` VARCHAR(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `tbl_clients`
 CHANGE `complete_address` `address` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `tbl_clients` CHANGE `password` `password` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;

ALTER TABLE `tbl_shops` ADD `cover` VARCHAR(255) NOT NULL AFTER `map_lng`;

ALTER TABLE `tbl_rentals` DROP FOREIGN KEY `tbl_rentals_ibfk_1`;
ALTER TABLE `tbl_rentals` DROP INDEX `user_id`;
ALTER TABLE `tbl_rentals` DROP `user_id`;