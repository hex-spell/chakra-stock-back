-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-09-2020 a las 18:42:18
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `chakra_stock`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `contacts`
--

CREATE TABLE `contacts` (
  `created_at` date NOT NULL,
  `deleted_at` date DEFAULT NULL,
  `address` varchar(30) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `money` float NOT NULL,
  `name` varchar(30) NOT NULL,
  `role` char(1) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `contacts`
--

INSERT INTO `contacts` (`created_at`, `deleted_at`, `address`, `contact_id`, `money`, `name`, `role`, `phone`, `updated_at`) VALUES
('2020-07-29', '2020-09-04', 'AV 10 23124', 1, 0, 'Dietetica', 'c', '3214123412', '2020-09-04 16:57:25'),
('2020-07-29', NULL, 'mardel', 2, 0, 'shaday', 'p', '3214113411', '2020-08-05 11:11:43'),
('2020-07-29', NULL, 'mardel', 3, 0, 'garmendia', 'p', '3214143411', '2020-08-05 11:11:43'),
('2020-07-31', NULL, 'la dulce 123', 4, 100, 'cerealera', 'p', '3211143411', '2020-08-05 11:11:43'),
('2020-07-31', NULL, 'buenos aires av 131', 5, -300, 'oreganista', 'p', '32111441211', '2020-08-05 11:11:43'),
('2020-07-31', NULL, 'AV 60 355', 6, 0, 'Miguel Luz', 'c', '321114412210', '2020-08-06 02:24:36'),
('2020-07-31', NULL, 'AV 83 entre 4 y 6', 7, 0, 'Valerio', 'c', '2262412312', '2020-08-12 15:26:26'),
('2020-07-31', NULL, 'AV 83 entre 6 y 8', 8, 0, 'Pizzeria el patriota', 'c', '2262462690', '2020-08-05 11:25:30'),
('2020-07-31', NULL, 'AV Esquina de la 55 y 60', 9, 0, 'Restaurant de la esquina', 'c', '2262142690', '2020-08-31 07:06:19'),
('2020-07-31', NULL, 'AV 10 y 67', 10, 0, 'Fruteria del pollo', 'c', '2262142691', '2020-08-06 02:24:49'),
('2020-07-31', NULL, 'AV 22 2888', 11, 0, 'Carniceria \"El Gordo\" Max', 'c', '2262142651', '2020-08-05 11:26:22'),
('2020-07-31', NULL, 'AV 110 entre 85 y 87', 12, 0, 'Pedro Aznar', 'c', '2262142630', '2020-08-31 07:05:55'),
('2020-08-03', NULL, 'AV El Cielo', 13, 0, 'Horacio Guarani', 'c', '2262142621', '2020-08-06 02:24:56'),
('2020-08-03', NULL, 'AV Buenos Aires', 14, 0, 'Florencia Vegana', 'c', '2262142521', '2020-08-06 02:25:08'),
('2020-08-03', NULL, 'AV 48 442', 15, 0, 'D\'Urbanowsky', 'c', '2262142420', '2020-08-05 11:11:43'),
('2020-08-03', NULL, 'AV 13 412', 16, 0, 'Pizzería Carrasco', 'c', '2262141510', '2020-08-31 07:06:09'),
('2020-08-03', NULL, 'AV 10 122', 17, -1495, 'Roticería Siglo XXI', 'c', '2262141211', '2020-09-02 11:01:33'),
('2020-08-05', NULL, '63 2331f', 18, 0, 'Alberto Núñez', 'c', '6814379181', '2020-08-06 02:27:50'),
('2020-08-05', NULL, '23 1241', 19, -187, 'Agustina', 'c', '2262679556', '2020-09-02 10:47:58'),
('2020-09-01', NULL, 'AV 48 442', 20, 0, 'Cecilia', 'c', '2262609925', '2020-09-01 14:32:33');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expenses`
--

CREATE TABLE `expenses` (
  `description` varchar(30) DEFAULT NULL,
  `sum` float NOT NULL,
  `created_at` date NOT NULL,
  `expense_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `deleted_at` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `expenses`
--

INSERT INTO `expenses` (`description`, `sum`, `created_at`, `expense_id`, `category_id`, `updated_at`, `deleted_at`) VALUES
('factura nro 141231', 2000, '2020-08-07', 1, 1, '2020-08-12', '2020-08-12'),
('factura nro 111231', 2000, '2020-08-07', 2, 1, '2020-08-08', NULL),
('asdasd', 4231, '2020-08-07', 3, 1, '2020-08-09', '2020-08-09'),
('Pizza', -200, '2020-08-08', 4, 11, '2020-09-02', '2020-09-02');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `expense_categories`
--

CREATE TABLE `expense_categories` (
  `name` varchar(30) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `expense_categories`
--

INSERT INTO `expense_categories` (`name`, `category_id`) VALUES
('Facturas de luz', 1),
('Comida', 11);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `orders`
--

CREATE TABLE `orders` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `order_id` int(11) NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0,
  `delivered` tinyint(1) NOT NULL DEFAULT 0,
  `type` char(1) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `orders`
--

INSERT INTO `orders` (`created_at`, `order_id`, `completed`, `delivered`, `type`, `updated_at`, `deleted_at`, `contact_id`) VALUES
('2020-09-02 12:09:38', 1, 1, 1, 'b', '2020-09-02 12:09:38', NULL, 11),
('2020-08-31 06:21:31', 2, 0, 0, 'b', '2020-08-31 06:21:31', '2020-08-31 06:21:31', 11),
('2020-09-02 11:48:09', 3, 1, 1, 'b', '2020-09-02 11:48:09', NULL, 12),
('2020-08-24 07:22:07', 4, 0, 0, 'b', '2020-08-24 07:22:07', '2020-08-24 07:22:07', 15),
('2020-08-26 14:54:38', 5, 0, 0, 'b', '2020-08-26 14:54:38', '2020-08-26 14:54:38', 5),
('2020-08-26 14:54:42', 6, 0, 0, 'b', '2020-08-26 14:54:42', '2020-08-26 14:54:42', 7),
('2020-09-02 10:47:58', 7, 1, 1, 'a', '2020-09-02 10:47:58', NULL, 19),
('2020-09-02 12:09:46', 8, 1, 1, 'b', '2020-09-02 12:09:46', NULL, 8),
('2020-08-31 05:04:12', 9, 0, 1, 'b', '2020-08-31 05:04:12', '2020-08-31 05:04:12', 1),
('2020-09-02 12:09:42', 10, 1, 1, 'b', '2020-09-02 12:09:42', NULL, 9),
('2020-08-31 07:20:44', 11, 0, 0, 'b', '2020-08-31 07:20:44', '2020-08-31 07:20:44', 16),
('2020-08-31 07:20:41', 12, 0, 0, 'b', '2020-08-31 07:20:41', '2020-08-31 07:20:41', 17),
('2020-08-31 07:20:39', 13, 0, 0, 'b', '2020-08-31 07:20:39', '2020-08-31 07:20:39', 13),
('2020-08-31 07:20:36', 14, 0, 0, 'b', '2020-08-31 07:20:36', '2020-08-31 07:20:36', 18),
('2020-08-31 07:20:34', 15, 0, 0, 'b', '2020-08-31 07:20:34', '2020-08-31 07:20:34', 9),
('2020-08-31 07:20:28', 16, 0, 0, 'b', '2020-08-31 07:20:28', '2020-08-31 07:20:28', 10),
('2020-08-31 07:20:25', 17, 0, 0, 'b', '2020-08-31 07:20:25', '2020-08-31 07:20:25', 15),
('2020-08-31 07:20:22', 18, 0, 0, 'b', '2020-08-31 07:20:22', '2020-08-31 07:20:22', 1),
('2020-08-31 13:39:13', 19, 0, 0, 'b', '2020-08-31 13:39:13', '2020-08-31 13:39:13', 1),
('2020-09-02 10:47:37', 20, 1, 1, 'a', '2020-09-02 10:47:37', NULL, 1),
('2020-09-02 11:01:33', 21, 1, 1, 'a', '2020-09-02 11:01:33', NULL, 17),
('2020-09-02 11:51:23', 22, 1, 1, 'a', '2020-09-02 11:51:23', NULL, 1),
('2020-09-04 14:42:22', 23, 1, 1, 'b', '2020-09-04 14:42:22', NULL, 1),
('2020-09-04 16:20:18', 24, 0, 0, 'b', '2020-09-04 16:20:18', '2020-09-04 16:20:18', 1),
('2020-09-04 16:24:39', 25, 0, 0, 'b', '2020-09-04 16:24:39', '2020-09-04 16:24:39', 1),
('2020-09-04 16:26:34', 26, 0, 0, 'b', '2020-09-04 16:26:34', '2020-09-04 16:26:34', 1),
('2020-09-04 16:32:26', 27, 0, 0, 'b', '2020-09-04 16:32:26', NULL, 1),
('2020-09-04 17:19:40', 28, 0, 1, 'b', '2020-09-04 17:19:40', '2020-09-04 17:19:40', 19),
('2020-09-05 16:11:48', 29, 1, 1, 'b', '2020-09-05 16:11:48', NULL, 19),
('2020-09-05 16:30:30', 30, 0, 0, 'b', '2020-09-05 16:30:30', NULL, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_products`
--

CREATE TABLE `order_products` (
  `ammount` int(11) NOT NULL,
  `delivered` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_history_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `order_products`
--

INSERT INTO `order_products` (`ammount`, `delivered`, `order_id`, `product_id`, `product_history_id`) VALUES
(3, 3, 1, 24, 89),
(1, 1, 1, 25, 91),
(1, 1, 1, 26, 72),
(1, 0, 2, 24, 89),
(6, 0, 2, 25, 91),
(3, 0, 2, 26, 72),
(1, 1, 3, 24, 89),
(5, 5, 3, 28, 92),
(1, 1, 7, 24, 89),
(2, 2, 7, 25, 91),
(1, 1, 7, 26, 72),
(1, 1, 8, 24, 89),
(1, 1, 8, 27, 73),
(4, 4, 10, 24, 89),
(1, 1, 10, 25, 91),
(1, 1, 10, 26, 72),
(3, 0, 19, 24, 89),
(2, 0, 19, 27, 73),
(1, 1, 20, 24, 89),
(7, 7, 20, 25, 91),
(20, 20, 20, 27, 73),
(20, 20, 20, 28, 92),
(2, 2, 21, 24, 89),
(3, 3, 22, 24, 89),
(1, 1, 23, 24, 96),
(1, 0, 25, 31, 98),
(1, 0, 27, 32, 99),
(1, 1, 29, 34, 101),
(4, 0, 30, 24, 96);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `stock` int(11) NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `product_id` int(11) NOT NULL,
  `product_history_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`stock`, `deleted_at`, `created_at`, `updated_at`, `product_id`, `product_history_id`, `category_id`) VALUES
(7, NULL, '2020-08-11 13:27:04', '2020-09-04 14:42:13', 24, 96, 1),
(12, NULL, '2020-08-11 14:20:13', '2020-09-02 12:09:29', 25, 91, 1),
(3, NULL, '2020-08-11 14:20:18', '2020-09-02 12:09:29', 26, 72, 1),
(23, NULL, '2020-08-11 14:20:25', '2020-09-02 08:28:19', 27, 73, 1),
(25, NULL, '2020-08-11 14:20:34', '2020-09-02 07:52:53', 28, 92, 1),
(3, NULL, '2020-08-11 14:20:40', '2020-08-13 13:16:19', 29, 75, 1),
(7, NULL, '2020-08-13 12:52:43', '2020-08-31 13:47:28', 30, 94, 2),
(1, '2020-09-04 16:23:10', '2020-09-04 16:22:24', '2020-09-04 16:23:10', 31, 98, 2),
(1, '2020-09-04 16:32:36', '2020-09-04 16:26:15', '2020-09-04 16:32:36', 32, 99, 2),
(1, '2020-09-04 17:00:38', '2020-09-04 16:59:19', '2020-09-04 17:00:38', 33, 100, 2),
(1, '2020-09-05 16:01:19', '2020-09-04 17:20:08', '2020-09-05 16:11:26', 34, 101, 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_categories`
--

CREATE TABLE `product_categories` (
  `name` varchar(30) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product_categories`
--

INSERT INTO `product_categories` (`name`, `category_id`) VALUES
('Especias', 1),
('Cereales', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product_history`
--

CREATE TABLE `product_history` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `name` varchar(30) NOT NULL,
  `sell_price` float NOT NULL,
  `buy_price` float NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_history_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `product_history`
--

INSERT INTO `product_history` (`created_at`, `name`, `sell_price`, `buy_price`, `product_id`, `product_history_id`, `updated_at`, `deleted_at`) VALUES
('2020-08-11 03:00:00', 'Adobo para pizza', 30, 30, 24, 51, '2020-08-11 03:00:00', NULL),
('2020-08-11 03:00:00', 'Adobo para picsa', 30, 30, 24, 52, '2020-08-11 03:00:00', NULL),
('2020-08-11 03:00:00', 'Condimento para arroz', 30, 30, 25, 53, '2020-08-11 03:00:00', NULL),
('2020-08-11 03:00:00', 'Condimento para aves', 30, 30, 26, 54, '2020-08-11 03:00:00', NULL),
('2020-08-11 03:00:00', 'Orégano', 30, 30, 27, 55, '2020-08-11 03:00:00', NULL),
('2020-08-11 03:00:00', 'Ají molido', 30, 30, 28, 56, '2020-08-11 03:00:00', NULL),
('2020-08-11 03:00:00', 'Provenzal', 30, 30, 29, 57, '2020-08-11 03:00:00', NULL),
('2020-08-13 03:00:00', 'Adobo para pizza', 30, 30, 24, 58, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Adobo para pizza', 30, 30, 24, 59, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Adobo para pizza', 100, 30, 24, 60, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Adobo para pizza', 100000, 30, 24, 61, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Adobo para pizza', 100, 30, 24, 62, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Condimento para arroz', 100, 30, 25, 63, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Condimento para aves', 100, 30, 26, 64, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Orégano', 100, 30, 27, 65, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Ají molido', 100, 30, 28, 66, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Provenzal', 100, 30, 29, 67, '2020-08-13 03:00:00', NULL),
('2020-08-13 03:00:00', 'Copos azucarados', 300, 100, 30, 68, '2020-08-13 03:00:00', NULL),
('2020-08-13 13:15:35', 'Adobo para pizza', 101, 30, 24, 69, '2020-08-13 13:15:35', NULL),
('2020-08-13 13:15:54', 'Condimento para arroz 1kg', 100, 30, 25, 70, '2020-08-13 13:15:54', NULL),
('2020-08-13 13:16:00', 'Adobo para pizza 1kg', 101, 30, 24, 71, '2020-08-13 13:16:00', NULL),
('2020-08-13 13:16:05', 'Condimento para aves 1kg', 100, 30, 26, 72, '2020-08-13 13:16:05', NULL),
('2020-08-13 13:16:09', 'Orégano 1kg', 100, 30, 27, 73, '2020-08-13 13:16:09', NULL),
('2020-08-13 13:16:14', 'Ají molido 1kg', 100, 30, 28, 74, '2020-08-13 13:16:14', NULL),
('2020-08-13 13:16:19', 'Provenzal 1kg', 100, 30, 29, 75, '2020-08-13 13:16:19', NULL),
('2020-08-13 13:16:23', 'Copos azucarados 1kg', 300, 100, 30, 76, '2020-08-13 13:16:23', NULL),
('2020-08-13 14:14:26', 'Adobo para pizza 1kg', 101, 3000000, 24, 77, '2020-08-13 14:14:26', NULL),
('2020-08-13 14:14:37', 'Adobo para pizza 1kg', 101, 30000000000, 24, 78, '2020-08-13 14:14:37', NULL),
('2020-08-13 14:32:57', 'Adobo para pizza 1kg', 101, 300, 24, 79, '2020-08-13 14:32:57', NULL),
('2020-08-13 14:33:14', 'Adobo para pizza 1kg', 30000, 100, 24, 80, '2020-08-13 14:33:14', NULL),
('2020-08-13 14:33:22', 'Adobo para pizza 1kg', 3000000, 100, 24, 81, '2020-08-13 14:33:22', NULL),
('2020-08-13 14:33:27', 'Adobo para pizza 1kg', 300000000000000, 100, 24, 82, '2020-08-13 14:33:27', NULL),
('2020-08-13 14:33:34', 'Adobo para pizza 1kg', 3000, 100, 24, 83, '2020-08-13 14:33:34', NULL),
('2020-08-13 14:33:39', 'Adobo para pizza 1kg', 300, 100, 24, 84, '2020-08-13 14:33:39', NULL),
('2020-08-13 14:34:33', 'Adobo para pizza 1kg', 300, 100000, 24, 85, '2020-08-13 14:34:33', NULL),
('2020-08-13 14:34:45', 'Adobo para pizza 1kg', 300, 100, 24, 86, '2020-08-13 14:34:45', NULL),
('2020-08-13 14:47:56', 'Condimento para arroz 1kg', 10000000, 30, 25, 87, '2020-08-13 14:47:56', NULL),
('2020-08-13 14:56:33', 'Condimento para arroz 1kg', 100, 30, 25, 88, '2020-08-13 14:56:33', NULL),
('2020-08-15 15:43:51', 'Adobo para pizza 1kg', 300, 100, 24, 89, '2020-08-15 15:43:51', NULL),
('2020-08-16 16:26:21', 'Condimento para arroz 2kg', 100, 30, 25, 90, '2020-08-16 16:26:21', NULL),
('2020-08-23 06:42:47', 'Condimento para arroz 2kg', 100, 30, 25, 91, '2020-08-23 06:42:47', NULL),
('2020-08-26 15:20:19', 'Ají molido 1kg', 100, 30, 28, 92, '2020-08-26 15:20:19', NULL),
('2020-08-31 13:41:02', 'Copos azucarados 1kg', 300, 100, 30, 93, '2020-08-31 13:41:02', NULL),
('2020-08-31 13:47:28', 'Copos azucarados 1kg', 300, 101, 30, 94, '2020-08-31 13:47:28', NULL),
('2020-09-04 14:28:41', 'Adobo para picza 1kg', 300, 100, 24, 95, '2020-09-04 14:28:41', NULL),
('2020-09-04 14:28:47', 'Adobo para pizza 1kg', 300, 100, 24, 96, '2020-09-04 14:28:47', NULL),
('2020-09-04 16:22:24', 'eliminable1', 0, 0, 31, 97, '2020-09-04 16:22:24', NULL),
('2020-09-04 16:22:34', 'eliminable', 0, 0, 31, 98, '2020-09-04 16:22:34', NULL),
('2020-09-04 16:26:15', 'Eliminable', 100, 0, 32, 99, '2020-09-04 16:26:15', NULL),
('2020-09-04 16:59:19', 'eliminable', 0, 0, 33, 100, '2020-09-04 16:59:19', NULL),
('2020-09-04 17:20:08', 'Eliminable1', 0, 0, 34, 101, '2020-09-05 16:01:19', '2020-09-05 16:01:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `transactions`
--

CREATE TABLE `transactions` (
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `sum` float NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `contact_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `transactions`
--

INSERT INTO `transactions` (`created_at`, `sum`, `transaction_id`, `updated_at`, `deleted_at`, `contact_id`, `order_id`) VALUES
('2020-08-21 01:57:17', 12, 1, '2020-08-21 01:57:17', NULL, 12, 3),
('2020-08-21 02:11:06', 100, 2, '2020-08-21 02:11:06', NULL, 12, 3),
('2020-08-21 02:13:12', 600, 3, '2020-08-21 02:13:12', NULL, 12, 3),
('2020-08-22 16:38:09', 600, 4, '2020-08-22 16:38:09', NULL, 11, 1),
('2020-08-22 16:53:34', 1000, 5, '2020-08-22 16:53:34', NULL, 15, 4),
('2020-09-02 10:21:02', 1510, 6, '2020-09-02 10:21:02', NULL, 1, 20),
('2020-09-02 10:21:42', 190, 7, '2020-09-02 10:21:42', NULL, 19, 7),
('2020-09-02 10:25:11', 400, 8, '2020-09-02 10:25:11', NULL, 8, 8),
('2020-09-02 10:26:44', 88, 9, '2020-09-02 10:26:44', NULL, 12, 3),
('2020-09-02 10:29:56', 500, 10, '2020-09-02 10:29:56', NULL, 11, 1),
('2020-09-02 10:35:54', 1400, 11, '2020-09-02 10:35:54', NULL, 9, 10),
('2020-09-02 10:36:24', -200, 12, '2020-09-02 10:36:24', NULL, 8, 8),
('2020-09-02 10:36:29', 200, 13, '2020-09-02 10:36:29', NULL, 8, 8),
('2020-09-02 10:53:00', 300, 14, '2020-09-02 10:53:00', NULL, 17, 21),
('2020-09-02 11:51:09', 300, 15, '2020-09-02 11:51:09', NULL, 1, 22),
('2020-09-04 15:45:19', 500, 16, '2020-09-04 15:45:19', NULL, 1, 23);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `password` varchar(60) NOT NULL,
  `email` varchar(60) NOT NULL,
  `name` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`user_id`, `password`, `email`, `name`) VALUES
(1, '$2y$10$QXwCkHXYzzCtGG9VbvoVE.CVqaAbWwI7264e0LBph01XJAAev/jeC', 'cecilia@gmail.com', 'Cecilia');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

--
-- Indices de la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD PRIMARY KEY (`expense_id`),
  ADD KEY `expense_category` (`category_id`);

--
-- Indices de la tabla `expense_categories`
--
ALTER TABLE `expense_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `orders_contacts` (`contact_id`);

--
-- Indices de la tabla `order_products`
--
ALTER TABLE `order_products`
  ADD PRIMARY KEY (`order_id`,`product_id`,`product_history_id`),
  ADD KEY `order_product_history` (`product_history_id`),
  ADD KEY `order_product` (`product_id`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`,`product_history_id`),
  ADD UNIQUE KEY `product_history_id` (`product_history_id`) USING BTREE,
  ADD KEY `products_categories` (`category_id`);

--
-- Indices de la tabla `product_categories`
--
ALTER TABLE `product_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indices de la tabla `product_history`
--
ALTER TABLE `product_history`
  ADD PRIMARY KEY (`product_history_id`),
  ADD KEY `history_product` (`product_id`);

--
-- Indices de la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `contact_id` (`contact_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indices de la tabla `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT de la tabla `expenses`
--
ALTER TABLE `expenses`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `expense_categories`
--
ALTER TABLE `expense_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT de la tabla `product_categories`
--
ALTER TABLE `product_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `product_history`
--
ALTER TABLE `product_history`
  MODIFY `product_history_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT de la tabla `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `expenses`
--
ALTER TABLE `expenses`
  ADD CONSTRAINT `expense_category` FOREIGN KEY (`category_id`) REFERENCES `expense_categories` (`category_id`);

--
-- Filtros para la tabla `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_contacts` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`);

--
-- Filtros para la tabla `order_products`
--
ALTER TABLE `order_products`
  ADD CONSTRAINT `order_order` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_product_history` FOREIGN KEY (`product_history_id`) REFERENCES `product_history` (`product_history_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_categories` FOREIGN KEY (`category_id`) REFERENCES `product_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `products_history` FOREIGN KEY (`product_history_id`) REFERENCES `product_history` (`product_history_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `product_history`
--
ALTER TABLE `product_history`
  ADD CONSTRAINT `history_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`product_id`);

--
-- Filtros para la tabla `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `transactions_ibfk_1` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`contact_id`),
  ADD CONSTRAINT `transactions_ibfk_2` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
