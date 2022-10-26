-- Adminer 4.8.1 MySQL 5.5.5-10.8.3-MariaDB-1:10.8.3+maria~jammy dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP DATABASE IF EXISTS `product`;
CREATE DATABASE `product` /*!40100 DEFAULT CHARACTER SET utf8mb4 */;
USE `product`;

DROP TABLE IF EXISTS `category`;
CREATE TABLE `category` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `category`;
INSERT INTO `category` (`id`, `name`) VALUES
(1,	'category 1'),
(2,	'category 2');

DROP TABLE IF EXISTS `exchange_rate`;
CREATE TABLE `exchange_rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `currency` varchar(3) NOT NULL,
  `amount` float NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `exchange_rate`;

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(20,2) NOT NULL,
  `category` int(5) NOT NULL,
  `active` int(1) NOT NULL,
  `published_at` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `category` (`category`),
  CONSTRAINT `product_ibfk_1` FOREIGN KEY (`category`) REFERENCES `category` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `product`;
INSERT INTO `product` (`id`, `name`, `price`, `category`, `active`, `published_at`, `created_at`) VALUES
(1,	'Product 1',	10.00,	1,	1,	'2022-10-26 00:00:00',	'2022-10-26 09:11:21'),
(2,	'Product 2',	20.00,	2,	1,	'2022-10-26 00:00:00',	'2022-10-26 09:11:40'),
(3,	'Product 3',	165.00,	1,	1,	'2022-10-26 00:00:00',	'2022-10-26 09:12:18'),
(4,	'Product 4',	10.00,	1,	1,	'2022-10-26 00:00:00',	'2022-10-26 09:12:40');

DROP TABLE IF EXISTS `product_tag`;
CREATE TABLE `product_tag` (
  `product_id` int(11) NOT NULL,
  `tag_id` int(5) NOT NULL,
  PRIMARY KEY (`product_id`,`tag_id`),
  KEY `tag_id_product_id` (`tag_id`,`product_id`),
  CONSTRAINT `product_tag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `tag` (`id`),
  CONSTRAINT `product_tag_ibfk_6` FOREIGN KEY (`product_id`) REFERENCES `product` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `product_tag`;
INSERT INTO `product_tag` (`product_id`, `tag_id`) VALUES
(1,	1),
(1,	2),
(2,	1),
(2,	2),
(3,	3),
(4,	4);

DROP TABLE IF EXISTS `tag`;
CREATE TABLE `tag` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

TRUNCATE `tag`;
INSERT INTO `tag` (`id`, `name`) VALUES
(1,	'tag 1'),
(2,	'tag 2'),
(3,	'tag 3'),
(4,	'tag 4');

-- 2022-10-26 10:34:43
