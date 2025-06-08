-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 26, 2025 at 10:48 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `he&she_coffee`
--

-- --------------------------------------------------------

--
-- Table structure for table `badges`
--

CREATE TABLE `badges` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `purchase_threshold` int NOT NULL,
  `icon_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `badges`
--

INSERT INTO `badges` (`id`, `name`, `description`, `purchase_threshold`, `icon_url`) VALUES
(2, 'Rising Star', 'Purchase more than 5 items.', 5, 'icons/rising.png'),
(3, 'Loyalty Star', 'Purchase more than 10 items.', 10, 'icons/loyalty.png'),
(5, 'VIP Member', 'Purchase more than 50 ', 50, 'icons/vip.png');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `quantity` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `product_id`, `quantity`, `created_at`) VALUES
(24, 14, 7, 1, '2025-01-14 15:55:11'),
(25, 14, 8, 1, '2025-01-14 15:55:14'),
(53, 16, 17, 1, '2025-01-15 14:41:27'),
(54, 16, 16, 1, '2025-01-15 14:41:39'),
(55, 6, 6, 1, '2025-01-15 14:46:07'),
(57, 17, 2, 1, '2025-01-15 19:17:42'),
(58, 9, 2, 1, '2025-01-16 02:42:02'),
(60, 13, 2, 1, '2025-01-16 03:53:56');

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE `contact` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `submitted_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `name`, `email`, `message`, `submitted_at`) VALUES
(1, 'Alia Natasha', 'alnatasha28@gmail.com', 'Tambah button sort/search pada product page', '2025-01-10 23:47:47'),
(2, 'Huda Nabila', 'hudanabila@gmail.com', 'Tambah makanan chicken chop', '2025-01-12 08:28:53'),
(3, 'Sarang', 'sarangizna@gmail.com', 'boleh ke nak request tambah makanan donut', '2025-01-12 18:46:55'),
(4, 'Izzat', 'hudanabila@gmail.com', 'Tambah produk', '2025-01-13 03:20:06');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `address` text NOT NULL,
  `building_name` varchar(255) NOT NULL,
  `notes` text,
  `product_name` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `quantity` int NOT NULL,
  `total_price` decimal(10,2) NOT NULL,
  `payment_method` enum('online','cash') NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(20) NOT NULL DEFAULT 'Not Paid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `name`, `phone`, `address`, `building_name`, `notes`, `product_name`, `price`, `quantity`, `total_price`, `payment_method`, `created_at`, `status`) VALUES
(1, 6, 'Natt', '0136756261', 'Uitm', 'Library', 'Nanti dah sampai, call saya', 'Americano Coffee', '8.90', 1, '8.90', 'online', '2025-01-09 06:52:04', 'Paid'),
(2, 6, 'Natt', '0136756261', 'Uitm', 'Library', 'Nanti dah sampai, call saya', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-09 06:52:04', 'Paid'),
(3, 6, 'Natt', '0136756261', 'Uitm', 'Library', 'Nanti dah sampai, call saya', 'Fries', '5.00', 2, '10.00', 'online', '2025-01-09 06:52:04', 'Paid'),
(4, 6, 'Natt', '0136756261', 'Uitm', 'Library', 'Nanti dah sampai, call saya', 'Churros', '11.90', 1, '11.90', 'online', '2025-01-09 06:52:04', 'Paid'),
(5, 8, 'Jayy', '0111143212', 'Uitm', 'Music Studio', 'Dah sampai nanti masuk je studio tu, pastu panggil nama saya ', 'Lungo Coffee', '7.90', 1, '7.90', 'cash', '2025-01-09 06:59:21', 'Paid'),
(6, 8, 'Jayy', '0111143212', 'Uitm', 'Music Studio', 'Dah sampai nanti masuk je studio tu, pastu panggil nama saya ', 'Spaghetti Aglio Olio', '12.90', 1, '12.90', 'cash', '2025-01-09 06:59:21', 'Paid'),
(7, 8, 'Jayy', '0111143212', 'Uitm', 'Music Studio', 'Dah sampai nanti masuk je studio tu, pastu panggil nama saya ', 'Chocolate Tiramisu', '12.90', 1, '12.90', 'cash', '2025-01-09 06:59:21', 'Paid'),
(8, 7, 'Joyul ', '0123456789', 'Uitm', 'Mini Theater', 'Sampai nanti gantung je dekat tombol pintu', 'Hazelnut Coffee', '8.90', 2, '17.80', 'online', '2025-01-09 07:03:34', 'Paid'),
(9, 7, 'Joyul ', '0123456789', 'Uitm', 'Mini Theater', 'Sampai nanti gantung je dekat tombol pintu', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-09 07:03:34', 'Paid'),
(10, 7, 'Joyul ', '0123456789', 'Uitm', 'Mini Theater', 'Sampai nanti gantung je dekat tombol pintu', 'Spaghetti Aglio Olio', '12.90', 3, '38.70', 'online', '2025-01-09 07:03:34', 'Paid'),
(11, 7, 'Joyul ', '0123456789', 'Uitm', 'Mini Theater', 'Sampai nanti gantung je dekat tombol pintu', 'Fries', '5.00', 2, '10.00', 'online', '2025-01-09 07:03:34', 'Paid'),
(12, 6, 'Natasha', '0123456789', 'Uitm', 'Block A, A508', 'Nak sudu', 'Churros', '11.90', 1, '11.90', 'online', '2025-01-09 15:51:23', 'Paid'),
(13, 6, 'Natasha', '0123456789', 'Uitm', 'Block A, A508', 'Nak sudu', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-09 15:51:23', 'Paid'),
(14, 6, 'Natasha', '0123456789', 'Uitm', 'Block A, A508', 'Nak sudu', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-09 15:51:23', 'Paid'),
(15, 9, 'Sarang', '0134510124', 'Uitm', 'Pusat Islam', 'Bahagian perempuan', 'Buttercream Latte Biscoff', '14.90', 1, '14.90', 'online', '2025-01-11 04:42:56', 'Not Paid'),
(16, 9, 'Sarang', '0134510124', 'Uitm', 'Pusat Islam', 'Bahagian perempuan', 'Cinnamon Sugar Pretzel', '6.70', 1, '6.70', 'online', '2025-01-11 04:42:56', 'Not Paid'),
(17, 8, 'Jayy', '0121243212', 'Uitm', 'Kolej DO, Blok D', 'Dah sampai call, pastu letak bawah pondok', 'Croffle Strawberry ', '4.90', 1, '4.90', 'online', '2025-01-11 07:27:19', 'Not Paid'),
(18, 10, 'Iroha', '0167665466', 'Uitm', 'Block A, A301', 'Letak dalam rak kasut', 'Spaghetti Aglio Olio', '12.90', 1, '12.90', 'online', '2025-01-11 13:52:39', 'Canceled'),
(19, 10, 'Iroha', '0167665466', 'Uitm', 'Block A, A301', 'Letak dalam rak kasut', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-11 13:52:39', 'Canceled'),
(20, 11, 'Huda Nabila', '0199825432', 'UiTM', 'Pusat Islam', 'Call bila sampai, nanti saya ambik', 'Fries', '5.00', 2, '10.00', 'cash', '2025-01-12 08:24:31', 'Paid'),
(21, 11, 'Huda Nabila', '0199825432', 'UiTM', 'Pusat Islam', 'Call bila sampai, nanti saya ambik', 'Lungo Coffee', '7.90', 1, '7.90', 'cash', '2025-01-12 08:24:31', 'Paid'),
(25, 5, 'Izzat ', '0155464322', 'UiTM', 'Pusat Sukan A', 'Nanti call ', 'Cinnamon Sugar Pretzel', '6.70', 1, '6.70', 'cash', '2025-01-12 12:25:08', 'Not Paid'),
(26, 5, 'Izzat ', '0155464322', 'UiTM', 'Pusat Sukan A', 'Nanti call ', 'Chicken Chop Yum', '11.90', 1, '11.90', 'cash', '2025-01-12 12:25:08', 'Paid'),
(27, 5, 'Izzat ', '0155464322', 'UiTM', 'Pusat Sukan A', 'Nanti call ', 'Buttercream Latte Biscoff', '14.90', 1, '14.90', 'cash', '2025-01-12 12:25:08', 'Paid'),
(28, 10, 'Iroha', '0176778317', 'UiTM', 'Pusat Islam', 'Call ', 'Americano Coffee', '8.90', 1, '8.90', 'cash', '2025-01-12 18:26:47', 'Not Paid'),
(29, 10, 'Iroha', '0176778317', 'UiTM', 'Pusat Islam', 'Call ', 'Churros', '11.90', 1, '11.90', 'cash', '2025-01-12 18:26:47', 'Paid'),
(30, 9, 'Sarang ', '0141142134', 'UiTM', 'HEP', 'Letak di kaunter pertanyaan', 'Cream Mushroom Soup', '7.90', 1, '7.90', 'online', '2025-01-12 18:45:42', 'Not Paid'),
(31, 9, 'Sarang ', '0141142134', 'UiTM', 'HEP', 'Letak di kaunter pertanyaan', 'Garlic Bread', '7.00', 1, '7.00', 'online', '2025-01-12 18:45:42', 'Not Paid'),
(32, 9, 'Sarang ', '0141142134', 'UiTM', 'HEP', 'Letak di kaunter pertanyaan', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-12 18:45:42', 'Not Paid'),
(33, 12, 'Muhammad', '0199872321', 'UiTM', 'HEA', 'Counter', 'Hazelnut Coffee', '8.90', 1, '8.90', 'online', '2025-01-13 02:55:43', 'Not Paid'),
(34, 12, 'Muhammad', '0199872321', 'UiTM', 'HEA', 'Counter', 'Fries', '5.00', 1, '5.00', 'online', '2025-01-13 02:55:43', 'Paid'),
(37, 6, 'Nat', '0136756261', 'UiTM', 'Block B, B201', 'Gantung kat tombol pintu', 'Hazelnut Coffee', '8.90', 1, '8.90', 'cash', '2025-01-13 16:29:49', 'Not Paid'),
(38, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', 'Call me', 'Chicken Chop Cremy', '11.90', 1, '11.90', 'online', '2025-01-13 16:49:33', 'Not Paid'),
(39, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', 'Call me', 'Strawberry Frappuccino ', '13.90', 1, '13.90', 'online', '2025-01-13 16:49:33', 'Not Paid'),
(40, 6, 'Nat', '0136756261', 'UiTM', 'Office', 'Letak di counter pertanyaan', 'Cinnamon Sugar Pretzel', '6.70', 1, '6.70', 'online', '2025-01-13 17:01:24', 'Not Paid'),
(41, 6, 'Nat', '0136756261', 'UiTM', 'Office', 'Letak di counter pertanyaan', 'Croffle Strawberry', '4.90', 1, '4.90', 'online', '2025-01-13 17:01:24', 'Not Paid'),
(42, 6, 'Nat', '0136756261', 'UiTM', 'Office', 'Letak di counter pertanyaan', 'Americano Coffee', '8.90', 1, '8.90', 'online', '2025-01-13 17:01:24', 'Not Paid'),
(43, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Sukan B', 'Nanti elo', 'Buttercream Latte Biscoff', '14.90', 1, '14.90', 'online', '2025-01-13 17:13:44', 'Not Paid'),
(44, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Sukan B', 'Nanti elo', 'Cream Mushroom Soup', '7.90', 1, '7.90', 'online', '2025-01-13 17:13:44', 'Not Paid'),
(45, 9, 'Sarang ', '0141142134', 'UiTM', 'Kolej DO', 'Jumpa di lobby', 'Chocolate Tiramisu', '12.90', 1, '12.90', 'cash', '2025-01-13 17:27:10', 'Not Paid'),
(46, 9, 'Sarang ', '0141142134', 'UiTM', 'Kolej DO', 'Jumpa di lobby', 'Chocolate Chip Cookies', '10.00', 1, '10.00', 'cash', '2025-01-13 17:27:10', 'Not Paid'),
(47, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', 'Elo', 'Dalgona Coffee', '9.90', 1, '9.90', 'cash', '2025-01-13 18:29:04', 'Not Paid'),
(48, 6, 'Nat', '0136756261', 'UiTM', 'HEA', 'Call', 'Dalgona Coffee', '9.90', 1, '9.90', 'cash', '2025-01-13 18:48:04', 'Not Paid'),
(49, 6, 'Nat', '0136756261', 'UiTM', 'HEA', 'Call', 'Chocolate Croissant', '10.90', 1, '10.90', 'cash', '2025-01-13 18:48:04', 'Not Paid'),
(50, 6, 'Nat', '0136756261', 'UiTM', 'HEA', 'Call', 'Churros', '11.90', 1, '11.90', 'cash', '2025-01-13 18:48:04', 'Not Paid'),
(51, 6, 'Nat', '0136756261', 'UiTM', 'HEA', 'Call', 'Buttercream Latte Biscoff', '14.90', 1, '14.90', 'cash', '2025-01-13 18:48:04', 'Not Paid'),
(52, 6, 'Nat', '0136756261', 'UiTM', 'HEA', 'Call', 'Chocolate Chip Cookies', '10.00', 1, '10.00', 'cash', '2025-01-13 18:48:04', 'Not Paid'),
(53, 6, 'Nat', '0136756261', 'UiTM', 'Office', 'Nanti panggil', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-13 18:53:36', 'Not Paid'),
(54, 6, 'Nat', '0136756261', 'UiTM', 'Office', 'Nanti panggil', 'Fries', '5.00', 1, '5.00', 'online', '2025-01-13 18:53:36', 'Not Paid'),
(55, 6, 'Nat', '0136756261', 'UiTM', 'Office', 'Nanti panggil', 'Cinnamon Sugar Pretzel', '6.70', 1, '6.70', 'online', '2025-01-13 18:53:36', 'Not Paid'),
(58, 6, 'Nat', '0136756261', 'UiTM', 'PB THO', 'Mausk pejabat', 'Lungo Coffee', '7.90', 1, '7.90', 'online', '2025-01-14 07:11:17', 'Not Paid'),
(59, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', 'Nanti call', 'Chocolate Tiramisu', '12.90', 1, '12.90', 'online', '2025-01-14 07:22:03', 'Not Paid'),
(60, 6, 'Nat', '0136756261', 'UiTM', 'THO PANTRY', '', 'Churros', '11.90', 1, '11.90', 'online', '2025-01-14 07:27:26', 'Not Paid'),
(62, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', '', 'Fries', '5.00', 1, '5.00', 'online', '2025-01-14 07:34:48', 'Not Paid'),
(63, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', 'Call', 'Cinnamon Sugar Pretzel', '6.70', 1, '6.70', 'online', '2025-01-14 12:57:15', 'Not Paid'),
(64, 6, 'Nat', '0136756261', 'UiTM', 'Masmed', 'Bagi kat makcik', 'Hazelnut Coffee', '8.90', 1, '8.90', 'online', '2025-01-14 13:00:23', 'Not Paid'),
(65, 6, 'Nat', '0136756261', 'UiTM', 'Masmed', 'Bagi kat makcik', 'Fries', '5.00', 1, '5.00', 'online', '2025-01-14 13:00:23', 'Not Paid'),
(66, 6, 'Nat', '0136756261', 'UiTM', 'Masmed', 'Bagi kat makcik', 'Chocolate Tiramisu', '12.90', 1, '12.90', 'online', '2025-01-14 13:00:23', 'Not Paid'),
(67, 6, 'Nat', '0136756261', 'UiTM', 'HEA', '', 'Hazelnut Coffee', '8.90', 1, '8.90', 'cash', '2025-01-14 15:26:14', 'Not Paid'),
(68, 6, 'Nat', '0136756261', 'UiTM', 'HEA', '', 'Lungo Coffee', '7.90', 1, '7.90', 'online', '2025-01-14 15:35:50', 'Not Paid'),
(69, 6, 'Nat', '0136756261', 'UiTM', 'HEA', '', 'Americano Coffee', '8.90', 1, '8.90', 'online', '2025-01-14 15:35:50', 'Not Paid'),
(70, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Islam', '', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-14 15:36:46', 'Not Paid'),
(71, 14, 'Minju', '0187865586', 'UiTM', 'PB TR', '', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-14 15:52:43', 'Not Paid'),
(72, 14, 'Minju', '0187865586', 'UiTM', 'UK', '', 'Hazelnut Coffee', '8.90', 1, '8.90', 'online', '2025-01-14 15:54:54', 'Not Paid'),
(73, 14, 'Minju', '0187889679', 'UiTM', 'Pusat Islam', '', 'Fries', '5.00', 1, '5.00', 'online', '2025-01-14 15:55:41', 'Not Paid'),
(74, 14, 'Minju', '0187889679', 'UiTM', 'Pusat Islam', '', 'Churros', '11.90', 1, '11.90', 'online', '2025-01-14 15:55:41', 'Not Paid'),
(75, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Sukan A', '', 'Chicken Chop Cremy', '11.90', 1, '11.90', 'online', '2025-01-14 15:57:30', 'Not Paid'),
(76, 6, 'Nat', '0136756261', 'UiTM', 'Pusat Sukan A', '', 'Lungo Coffee', '7.90', 1, '7.90', 'online', '2025-01-14 15:57:30', 'Not Paid'),
(77, 9, 'Sarang', '015879654', 'UiTM', 'Smartclass', '', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-14 17:15:05', 'Not Paid'),
(78, 9, 'Sarang', '015879654', 'UiTM', 'Smartclass', '', 'Strawberry Frappuccino ', '13.90', 1, '13.90', 'online', '2025-01-14 17:15:05', 'Not Paid'),
(79, 1, 'Anas', '0199627223', 'UiTM', 'Student Center', 'Nanti pergi dekat parcel', 'Hazelnut Coffee', '8.90', 1, '8.90', 'cash', '2025-01-14 17:48:22', 'Not Paid'),
(80, 1, 'Anas', '0199627223', 'UiTM', 'Student Center', 'Nanti pergi dekat parcel', 'Chocolate Chip Cookies', '10.00', 1, '10.00', 'cash', '2025-01-14 17:48:22', 'Not Paid'),
(81, 1, 'Anas', '0199627223', 'UiTM', 'Student Center', 'Nanti pergi dekat parcel', 'Spaghetti Aglio Olio', '12.90', 1, '12.90', 'cash', '2025-01-14 17:48:22', 'Not Paid'),
(82, 6, 'Nat', '0136756261', 'UiTM', 'Kolej TAR', 'Nanti call', 'Churros', '11.90', 1, '11.90', 'online', '2025-01-14 17:50:01', 'Not Paid'),
(83, 6, 'Nat', '0136756261', 'UiTM', 'Kolej TAR', 'Nanti call', 'Strawberry Frappuccino ', '13.90', 1, '13.90', 'online', '2025-01-14 17:50:01', 'Not Paid'),
(84, 1, 'Anas', '0199627223', 'UiTM', 'Block B, B203', 'Nanti letak dalam rak', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-14 17:54:18', 'Paid'),
(85, 1, 'Anas', '0199627223', 'UiTM', 'Block B, B203', 'Nanti letak dalam rak', 'Americano Coffee', '8.90', 1, '8.90', 'online', '2025-01-14 17:54:18', 'Paid'),
(86, 15, 'Asa', '0163467669', 'UiTM', 'Smart Classroom', 'Naik tingkat 1 block A', 'Strawberry Frappuccino ', '13.90', 1, '13.90', 'online', '2025-01-14 18:02:36', 'Paid'),
(87, 15, 'Asa', '0163467669', 'UiTM', 'Smart Classroom', 'Naik tingkat 1 block A', 'Croffle Strawberry', '4.90', 1, '4.90', 'online', '2025-01-14 18:02:36', 'Paid'),
(88, 6, 'Nat', '0136756261', 'UiTM', 'Block D, D306', '', 'Cinnamon Sugar Pretzel', '6.70', 1, '6.70', 'online', '2025-01-15 04:36:30', 'Paid'),
(89, 6, 'Nat', '0136756261', 'UiTM', 'Block D, D306', '', 'Strawberry Frappuccino ', '13.90', 1, '13.90', 'online', '2025-01-15 04:36:30', 'Paid'),
(90, 6, 'Nat', '0136756261', 'UiTM', 'Dewan Pro', 'Nanti tunggu kat luar', 'Chocolate Tiramisu', '12.90', 1, '12.90', 'online', '2025-01-15 05:45:15', 'Not Paid'),
(91, 6, 'Nat', '0136756261', 'UiTM', 'Dewan Pro', 'Nanti tunggu kat luar', 'Buttercream Latte Biscoff', '14.90', 1, '14.90', 'online', '2025-01-15 05:45:15', 'Not Paid'),
(92, 16, 'Ayleen', '0123243314', 'UiTM', 'Dewan Pro', '', 'Chicken Chop Cremy', '11.90', 1, '11.90', 'online', '2025-01-15 14:42:29', 'Not Paid'),
(93, 16, 'Ayleen', '0123243314', 'UiTM', 'Dewan Pro', '', 'Strawberry Frappuccino ', '13.90', 1, '13.90', 'online', '2025-01-15 14:42:29', 'Not Paid'),
(94, 6, 'Nat', '0136756261', 'UiTM', 'HEA', '', 'Chocolate Croissant', '10.90', 1, '10.90', 'online', '2025-01-15 14:46:24', 'Not Paid'),
(95, 1, 'Anas', '0199627223', 'UiTM', 'Library', '', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-15 18:04:06', 'Not Paid'),
(96, 17, 'Rora', '0156152135', 'UiTM', 'Office', '', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-15 19:18:08', 'Not Paid'),
(97, 9, 'Minju', '0136756261', 'UiTM', 'Pusat Islam', '', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-16 02:42:20', 'Not Paid'),
(98, 13, 'Pulut', '0136756261', 'UiTM', 'Pusat Islam', '', 'Dalgona Coffee', '9.90', 1, '9.90', 'online', '2025-01-16 03:54:20', 'Not Paid');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `price`, `description`, `image`, `created_at`) VALUES
(1, 'Hazelnut Coffee', '8.90', 'Handpicked hazelnuts and freshly roasted coffee beans make every taste creamy and nutty.', 'https://i.pinimg.com/736x/f9/55/3d/f9553d624750d7f12705460f4078dc1d.jpg', '2025-01-06 17:10:19'),
(2, 'Dalgona Coffee', '9.90', 'A frothy, sweet, and milky coffee drink made by whipping instant coffee, sugar, and hot water until it\'s creamy, then spooning it over milk', 'https://i.pinimg.com/736x/39/91/c7/3991c7c73977068585e9a2204b386957.jpg', '2025-01-06 18:59:05'),
(3, 'Lungo Coffee', '7.90', 'An Italian coffee drink that\'s made by pulling an espresso shot with double the amount of water than normal', 'https://i.pinimg.com/736x/01/cc/97/01cc978a0fd95c50ad6ee8bf0d7f0ecb.jpg', '2025-01-06 19:00:39'),
(4, 'Americano Coffee', '8.90', 'Espresso shots topped with cold water produce a light layer of crema, then served over ice', 'https://i.pinimg.com/736x/bc/0c/ff/bc0cffc8b21c24b4b571e98b9ab5da12.jpg', '2025-01-06 19:01:50'),
(5, 'Chocolate Tiramisu', '12.90', 'Layers of cocoa-coffee soaked lady fingers, silky mascarpone cream, and rich chocolate', 'https://i.pinimg.com/736x/b7/46/ee/b746ee2653c180da2c34f6cfb3df2570.jpg', '2025-01-06 19:03:23'),
(6, 'Chocolate Croissant', '10.90', 'Flaky chocolate-filled croissant', 'https://i.pinimg.com/736x/e2/72/c4/e272c40b76a347b1cacea7b259643f97.jpg', '2025-01-06 19:04:18'),
(7, 'Fries', '5.00', 'Golden crispy fries with a side of dipping sauce.', 'https://i.pinimg.com/736x/0e/ef/14/0eef14ca02562ddf490f54f02cae57ef.jpg', '2025-01-06 19:05:12'),
(8, 'Churros', '11.90', 'Warm, crispy served with a chocolate dip', 'https://i.pinimg.com/736x/c1/af/91/c1af910825197a74ada21677aa3f0a7b.jpg', '2025-01-06 19:06:06'),
(9, 'Spaghetti Aglio Olio', '12.90', 'Spaghetti aglio e olio with garlic, olive oil, red pepper flakes and parmesan', 'https://www.piattorecipes.com/wp-content/uploads/2024/01/Spaghetti-Aglio-Olio-and-Bottarga.jpg', '2025-01-08 12:41:04'),
(10, 'Buttercream Latte Biscoff', '14.90', 'Offers a signature buttercream latte, as well as versions with espresso and pecan praline', 'https://i.pinimg.com/736x/47/a7/65/47a76570a3eaab2be2462bbf689aa85b.jpg', '2025-01-09 15:56:46'),
(11, 'Cinnamon Sugar Pretzel', '6.70', 'A sweeter take on the original twist, sprinkled with fresh cinnamon and sugar.', 'https://i.pinimg.com/736x/44/8a/d2/448ad28a830d3b73d78a31c61b0472ca.jpg', '2025-01-10 16:14:41'),
(12, 'Croffle Strawberry', '4.90', 'A pastry topped with fresh strawberry cubes and combining the layers of a croissant and the crispy texture of a waffle with strawberry puree', 'https://i.pinimg.com/736x/c6/9a/a5/c69aa5387fc8932ba843df4c2a4c3860.jpg', '2025-01-11 05:06:56'),
(13, 'Cream Mushroom Soup', '7.90', 'A soup prepared using cream, light cream, half and half, or milk as a key ingredient.', 'https://i.pinimg.com/736x/3e/a4/ac/3ea4acccee88ba7b2f1bfa10148efe9b.jpg', '2025-01-11 08:37:40'),
(14, 'Garlic Bread', '7.00', 'This Italian garlic bread is drenched in garlicky herb butter, oven-baked until crisp, topped with melted mozzarella cheese', 'https://i.pinimg.com/736x/b9/63/64/b96364f329277b2899c8c73a7b894059.jpg', '2025-01-11 08:43:05'),
(15, 'Chocolate Chip Cookies', '10.00', 'A drop cookie that features chocolate chips or chocolate morsels as its distinguishing ingredient', 'https://i.pinimg.com/736x/fd/33/3c/fd333c09a0ad32e69695cca1ec684533.jpg', '2025-01-11 09:09:04'),
(16, 'Strawberry Frappuccino ', '13.90', 'Blended iced drink with a fresh, creamy fruit taste. Made with ice and strawberry coulis.', 'http://cdn-masterop.xilnex.com/binarydatacom8444/8BOMjg4Nzbx9rziXfNGLHQnb1xGb9LiByigobsbQxxFfkPDJeNP-lBAGJggUwAmup3My-d7i7vJtkAuJzUWCoA.jpeg', '2025-01-11 09:16:15'),
(17, 'Chicken Chop Cremy', '11.90', 'The bone is separated from the whole leg leaving the meat with the knuckle on.', 'https://i.pinimg.com/736x/e0/53/5a/e0535aec9169659e43aceac27d6e6136.jpg', '2025-01-12 08:34:02');

-- --------------------------------------------------------

--
-- Table structure for table `redeemable_items`
--

CREATE TABLE `redeemable_items` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `image_url` varchar(255) NOT NULL,
  `points_required` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `redeemable_items`
--

INSERT INTO `redeemable_items` (`id`, `name`, `image_url`, `points_required`) VALUES
(1, 'Free Yumm Donut x7', 'images/donut.jpg', 5),
(2, 'Free Nugget x20', 'images/nugget.jpg', 7),
(3, 'Free Dumpling x10', 'images/dumpling.jpg', 9),
(4, 'Free Strawberry Frappuccino', 'images/frape.jpeg', 11),
(5, 'Free Lungo Coffee x2', 'images/lungo.jpg', 13),
(6, 'Free Buttercream Latte Biscoff', 'https://cdn-masterop.xilnex.com/binarydatacom8444/8BOMjg4Nzbx9rziXfNGLHQnb1xGb9LiByigobsbQxxFfkPDJeNP-lBAGJggUwAmup3My-d7i7vJtkAuJzUWCoA.jpeg', 15),
(7, 'Free Pouch Mofusand', 'images/pouch.jpg', 30),
(8, 'Free Blackpink Tumbler', 'images/tumbler.jpg', 40),
(9, 'Free Official Labubu', 'images/labubu.jpg', 50),
(10, 'Free MagSafe Apple', 'images/magsafe.jpg', 100),
(11, 'Airpods Pro 2', 'images/airpods.jpg', 180),
(12, 'Airpods Max', 'images/max.jpg', 200);

-- --------------------------------------------------------

--
-- Table structure for table `redemption_history`
--

CREATE TABLE `redemption_history` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `item_id` int NOT NULL,
  `redeemed_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `redemption_history`
--

INSERT INTO `redemption_history` (`id`, `user_id`, `item_id`, `redeemed_at`) VALUES
(1, 6, 1, '2025-01-14 12:30:00'),
(2, 1, 9, '2025-01-15 01:54:37'),
(3, 1, 8, '2025-01-15 02:10:26'),
(4, 1, 7, '2025-01-15 02:37:09'),
(5, 6, 2, '2025-01-15 22:46:36'),
(6, 1, 1, '2025-01-16 09:10:04');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` enum('admin','user') DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Muhammad Anas Bin Azmi', 'anasazmi2702@gmail.com', 'anas123', '2025-01-09 06:41:32', 'admin'),
(2, 'Dayana Batreisya Binti Mohd Sollehudin', 'sdayanaams@gmail.com', 'dayana123', '2025-01-09 06:43:26', 'admin'),
(3, 'Siti Nurfarahin Jannah Binti Samsudin', 'farahadik640@gmail.com', 'farah123', '2025-01-09 06:43:45', 'admin'),
(4, 'Nur Athirah Binti Remeli @ Rameli', 'nurathirah.remeli@gmail.com', 'athirah123', '2025-01-09 06:44:12', 'admin'),
(5, 'Muhammad Izzat Bin Mazlan', 'izzat.skullgreymon@gmail.com', 'izzat123', '2025-01-09 06:44:34', 'admin'),
(6, 'Nur Alia Natasha Binti Suhaimi', 'alnatasha28@gmail.com', 'Suhaimi@28', '2025-01-09 06:44:56', 'user'),
(7, 'Jo Yuri', 'joyuri2001@gmail.com', 'joyuri123', '2025-01-09 06:45:33', 'user'),
(8, 'Park Jong Seong', 'jayjongseong@gmail.com', 'jay123', '2025-01-09 06:46:42', 'user'),
(9, 'Ryu Sarang', 'sarangizna@gmail.com', 'sarang123', '2025-01-11 04:35:39', 'user'),
(10, 'Hokazono Iroha', 'irohaillit@gmail.com', 'iroha123', '2025-01-11 13:45:00', 'user'),
(11, 'Huda Nabila', 'hudanabila@gmail.com', 'huda123', '2025-01-12 08:15:39', 'user'),
(12, 'Muhammad Bin Abdullah', 'muhammad123@gmail.com', 'muhammad123', '2025-01-13 02:52:06', 'user'),
(13, 'Pulut Pintal', 'pulut123@gmail.com', 'pulut123', '2025-01-13 03:14:20', 'user'),
(14, 'Park Minju', 'minjuillit@gmail.com', 'minju123', '2025-01-14 15:43:15', 'user'),
(15, 'Asa Enami', 'asabaemon@gmail.com', 'asa123', '2025-01-14 17:57:25', 'user'),
(16, 'Ayleen Nayla Binti Muhammad Anas', 'ayleen123@gmail.com', 'ayleen123', '2025-01-15 14:34:02', 'user'),
(17, 'Lee Dain', 'rora123@gmail.com', 'rora123', '2025-01-15 19:13:56', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `user_profiles`
--

CREATE TABLE `user_profiles` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `gender` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `coffee_preference` varchar(255) NOT NULL,
  `student_number` varchar(50) NOT NULL,
  `semester` varchar(50) NOT NULL,
  `course` varchar(255) NOT NULL,
  `points` int DEFAULT '0',
  `total_orders` int DEFAULT '0',
  `badges_earned` json DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_profiles`
--

INSERT INTO `user_profiles` (`id`, `user_id`, `profile_image`, `name`, `email`, `gender`, `phone`, `address`, `coffee_preference`, `student_number`, `semester`, `course`, `points`, `total_orders`, `badges_earned`) VALUES
(1, 6, 'uploads/1736873789_nat.jpg', 'Nur Alia Natasha Binti Suhaimi', 'alnatasha28@gmail.com', 'Female', '0136756261', 'Taman Hijrah, Kampung Rantau Panjang, Klang, Selangor', 'Hazelnut', '2021494504', '7', 'Bachelor of Information System Engineering (Honors)', 1, 26, '[\"1\", \"2\"]'),
(2, 8, NULL, 'Park Jong Seong', 'jayjongseong@gmail.com', 'Male', '0111143212', 'Seattle, Washington, United States', 'Black coffee or Milk Coffee', '2021917889', '7', 'Bachelor of Music Education (Honors)', 0, 0, '[]'),
(3, 7, NULL, 'Jo Yuri', 'joyuri2001@gmail.com', 'Female', '0123456789', 'Munhyeon-dong, Nam-gu, Busan, South Korea', 'Espresso', '2023412343', '4', 'Bachelor of Theatre (Honours) Theatre Production', 0, 0, '[]'),
(4, 9, 'uploads/1736874924_sarang.jpg', 'Ryu Sa-rang', 'sarangizna@gmail.com', 'Female', '0158796549', 'Garak-dong, Yeongdo-gu, Busan, South Korea', 'Latte', '2024251118', '3', 'Foundation in Law', 2, 2, '[\"1\"]'),
(5, 10, NULL, 'Hokazono Iroha', 'irohaillit@gmail.com', 'Female', '0167665466', 'Koganei, Tokyo, Japan', 'Matcha', '2024250324', '5', 'Diploma in Drama & Dance Technology', 0, 0, '[]'),
(6, 11, NULL, 'Huda Nabila Binti Abudul', 'hudanabila@gmail.com', 'Female', '0165342172', 'Terengganu. Malaysia', 'Mocha', '2024721876', '5', 'IM', 0, 0, '[]'),
(7, 12, NULL, 'Muhammad Bin Abdullah', 'muhammad123@gmail.com', 'Male', '0199825432', 'Machang', 'Koko', '2023456789', '2', 'Business Admin', 0, 0, '[]'),
(8, 13, 'uploads/1736999197_doraemon.png', 'Pulut Pintal', 'pulut123@gmail.com', 'Female', '0155464324', 'Mache', 'Kokok', '2012345678', '1', 'Business', 1, 1, '[\"1\"]'),
(9, 14, NULL, 'Park Min-ju', 'minjuillit@gmail.com', 'Female', '0187889679', ' Namyangju-si, South Korea', 'Pistachio', '2024778456', '3', 'Business Study', 4, 4, '[]'),
(10, 1, 'uploads/1736876606_me.jpg', 'Muhammad Anas Bin Azmi', 'anasazmi2702@gmail.com', 'Male', '0199627223', 'Taman Kenerak Jaya, Lati, Pasir Mas, Kelantan', 'Hazelnut', '2023365737', '4', 'Bachelor of Information System Management (Honors)', 12, 102, '[\"1\", \"2\", \"3\", \"4\"]'),
(11, 15, 'uploads/1736877657_asa.jpg', 'Asa Enami', 'asabaemon@gmail.com', 'Female', '0123245214', 'Tokyo, Japan', 'Black Ivory', '2024657651', '4', 'Diploma in Drama & Dance Technology', 1, 1, NULL),
(12, 16, 'uploads/1736951993_photo_6071245137335402366_y.jpg', 'Ayleen Nayla Binti Muhammad Anas', 'ayleen123@gmail.com', 'Female', '0123243314', 'Rantau Panjang, Klang', 'Susu', '2029916534', '1', 'Culinary', 1, 1, NULL),
(13, 17, 'uploads/1736968641_rora.jpg', 'Lee Dain @ Rora', 'rora123@gmail.com', 'Female', '0156152135', 'Gangneun-si, Ganwon-do, South Korea', 'Matcha', '2024131452', '2', 'Accountancy', 1, 1, '[\"1\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `badges`
--
ALTER TABLE `badges`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redeemable_items`
--
ALTER TABLE `redeemable_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `redemption_history`
--
ALTER TABLE `redemption_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `item_id` (`item_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `badges`
--
ALTER TABLE `badges`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `redeemable_items`
--
ALTER TABLE `redeemable_items`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `redemption_history`
--
ALTER TABLE `redemption_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `user_profiles`
--
ALTER TABLE `user_profiles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `redemption_history`
--
ALTER TABLE `redemption_history`
  ADD CONSTRAINT `redemption_history_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user_profiles` (`id`),
  ADD CONSTRAINT `redemption_history_ibfk_2` FOREIGN KEY (`item_id`) REFERENCES `redeemable_items` (`id`);

--
-- Constraints for table `user_profiles`
--
ALTER TABLE `user_profiles`
  ADD CONSTRAINT `user_profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
