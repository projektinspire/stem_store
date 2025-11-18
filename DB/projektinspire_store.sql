-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 18, 2025 at 07:06 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projektinspire_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `AddedDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cart`
--

INSERT INTO `cart` (`ID`, `UserID`, `ProductID`, `Quantity`, `AddedDate`) VALUES
(3387, 31, 193, 1, '2025-05-26 11:38:10'),
(3397, 3, 161, 1, '2025-11-17 13:06:50'),
(3398, 3, 65, 1, '2025-11-17 13:07:00');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `CustomerID` int(11) NOT NULL,
  `CustomerName` varchar(255) NOT NULL,
  `TINNumber` varchar(255) NOT NULL,
  `VRN` varchar(50) NOT NULL,
  `LPO` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `AddedDate` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`CustomerID`, `CustomerName`, `TINNumber`, `VRN`, `LPO`, `Address`, `AddedDate`) VALUES
(99, 'Kelvin John', '', '', NULL, NULL, '2025-05-22 09:28:16');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `ID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `LPO` int(11) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Status` varchar(50) NOT NULL DEFAULT '''Pending''',
  `TotalPrice` decimal(10,2) NOT NULL,
  `PaymentMode` varchar(255) NOT NULL,
  `MobileProvider` varchar(50) DEFAULT NULL,
  `AddedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `PaymentStatus` enum('Unpaid','Pending','Paid') DEFAULT 'Unpaid',
  `attachment_path` varchar(255) DEFAULT NULL,
  `return_status` enum('Returned','Not Returned','Processed','Rejected') DEFAULT 'Not Returned'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`ID`, `UserID`, `CustomerID`, `LPO`, `Address`, `Status`, `TotalPrice`, `PaymentMode`, `MobileProvider`, `AddedDate`, `UpdatedDate`, `PaymentStatus`, `attachment_path`, `return_status`) VALUES
(19, 32, 99, NULL, NULL, 'Rejected', 0.82, 'cash', NULL, '2025-08-18 10:45:50', '2025-08-18 11:52:39', 'Unpaid', NULL, 'Not Returned');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `ID` int(11) NOT NULL,
  `OrderID` int(11) NOT NULL,
  `ProductID` int(11) NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Price` decimal(10,2) NOT NULL,
  `AddedDate` timestamp NOT NULL DEFAULT current_timestamp(),
  `UpdatedDate` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`ID`, `OrderID`, `ProductID`, `Quantity`, `Price`, `AddedDate`, `UpdatedDate`) VALUES
(1, 2, 12, 2, 2000.00, '2025-05-22 06:47:20', '2025-05-22 06:47:20'),
(2, 2, 13, 1, 18000.00, '2025-05-22 06:47:20', '2025-05-22 06:47:20'),
(3, 2, 19, 1, 28000.00, '2025-05-22 06:47:20', '2025-05-22 06:47:20'),
(4, 3, 14, 1, 23000.00, '2025-05-22 07:54:42', '2025-05-22 07:54:42'),
(5, 4, 608, 1, 10000.00, '2025-05-22 12:39:23', '2025-05-22 12:39:23'),
(6, 5, 608, 1, 10000.00, '2025-05-22 19:15:34', '2025-05-22 19:15:34'),
(7, 8, 608, 1, 10000.00, '2025-05-22 20:01:47', '2025-05-22 20:01:47'),
(8, 9, 608, 1, 10000.00, '2025-05-22 20:29:33', '2025-05-22 20:29:33'),
(9, 10, 52, 1, 70000.00, '2025-05-22 20:35:12', '2025-05-22 20:35:12'),
(10, 11, 20, 1, 4500.00, '2025-05-22 21:10:20', '2025-05-22 21:10:20'),
(11, 12, 54, 1, 30000.00, '2025-05-22 21:35:56', '2025-05-22 21:35:56'),
(12, 12, 83, 1, 500.00, '2025-05-22 21:35:56', '2025-05-22 21:35:56'),
(13, 12, 95, 3, 3000.00, '2025-05-22 21:35:56', '2025-05-22 21:35:56'),
(14, 13, 24, 1, 821000.00, '2025-05-23 08:20:36', '2025-05-23 08:20:36'),
(15, 14, 91, 1, 2000.00, '2025-05-23 09:24:46', '2025-05-23 09:24:46'),
(16, 15, 140, 1, 3000.00, '2025-05-23 11:10:58', '2025-05-23 11:10:58'),
(17, 15, 175, 1, 200.00, '2025-05-23 11:10:58', '2025-05-23 11:10:58'),
(18, 15, 608, 1, 10000.00, '2025-05-23 11:10:58', '2025-05-23 11:10:58'),
(22, 17, 193, 1, 1439000.00, '2025-05-26 11:38:20', '2025-05-26 11:38:20'),
(23, 18, 89, 1, 110000.00, '2025-05-27 11:01:31', '2025-05-27 11:01:31'),
(24, 18, 87, 1, 40000.00, '2025-05-27 11:01:31', '2025-05-27 11:01:31'),
(25, 18, 130, 1, 10000.00, '2025-05-27 11:01:31', '2025-05-27 11:03:59'),
(26, 19, 660, 1, 10000.00, '2025-08-18 10:45:50', '2025-08-18 10:45:50');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `PaymentID` int(11) NOT NULL,
  `CustomerID` int(11) NOT NULL,
  `Amount` decimal(10,2) NOT NULL,
  `PaymentDate` date NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `ID` int(11) NOT NULL,
  `ProductName` varchar(255) DEFAULT NULL,
  `Image` varchar(255) DEFAULT NULL,
  `Description` text DEFAULT NULL,
  `prod_price` decimal(10,2) DEFAULT NULL,
  `Quantity` int(11) DEFAULT NULL,
  `prod_cat` varchar(100) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `AddedDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`ID`, `ProductName`, `Image`, `Description`, `prod_price`, `Quantity`, `prod_cat`, `location`, `AddedDate`) VALUES
(12, 'Spout brush', 'products/1754469319_689313c7f207d.jpg', 'New one', 2000.00, 3, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(13, 'Math figure stick', NULL, 'Full packed', 18000.00, 2, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(14, 'TDS', NULL, 'One black , five white', 23000.00, 5, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(15, 'Rice grains ', NULL, '1000grams', 10000.00, 3, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(16, 'conical flask (2000 ml)', NULL, '2000 ml', 25000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(17, 'Glue rod', NULL, 'One packet 1kg', 30000.00, 80, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(18, 'Vitamin C', 'products/1761074206_68f7dc1e977e6.jpg', '1gms per bottle ', 9500.00, 7, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(19, 'Sodium hydroxide', NULL, '500g', 28000.00, 0, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(21, 'Sunflower oil', NULL, '5000 mil', 33000.00, 1, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(22, 'HISENSE AIR CONDITION', NULL, 'DIRECTOR OFFICE\\r\\nAS-12TR4SYEDB04', 1500000.00, 4, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(23, 'WHITE BOARD ', NULL, 'STAFF OFFICE', 165000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(24, 'BALL-IN-AIR STREAM', NULL, 'RECEPTION', 821000.00, 0, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(25, 'Seed starter trays', NULL, '144 cells  (24 trays- 6cell per tray )', 25812.00, 28, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(26, 'Measuring cylinder ( 1000mls) ', NULL, '1000  mls (glass)', 15000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(27, 'Battery ', NULL, '9V', 9000.00, 10, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(28, 'GYROSCOPE + ROTATING CHAIR', NULL, 'FRONT SIDE OF THE PREMISES', 695000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(29, 'Plastic spoon', NULL, '50pcs', 4500.00, 225, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(30, 'Balance balls', NULL, 'Full packed', 66000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(31, 'Povidone iodine ', NULL, '250mls', 6500.00, 10, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(32, 'science lab coat', NULL, 'white coat', 93960.00, 2, 'Protective_Gamets', 'Dar es Salaam', '0000-00-00 00:00:00'),
(33, 'laser pointer', NULL, 'high power tacticak green beam flashlight laser pointer rechargeble USB laser pointer cat toys with star cap adjustable focus for teaching outdoor hunting ', 260739.00, 2, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(34, 'BICYCLE PAINT', NULL, 'LEFT SIDE OF THE PREMISES', 1492000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(35, 'Tissue', NULL, 'viva (napkin) \r\n100sheets', 1500.00, 18, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(36, 'Cool Blue water ', 'products/1761073078_68f7d7b6b3d03.jpg', '15000ml', 6500.00, 15, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(37, 'cotton   gloves', 'products/1761073291_68f7d88b79061.jpg', 'white', 1000.00, 9, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(39, 'Highlighters ', NULL, '4 Pcs', 4000.00, 5, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(40, 'Teabag', NULL, '100g per box', 1200.00, 4, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(41, 'HISENSE AIR CONDITION', NULL, 'BOARD ROOM\r\nPI OFFICE FAN 0003', 17076000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(42, 'Petri dish', NULL, 'Medium size ', 500.00, 21, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(43, 'Color stamp', NULL, 'Blue', 4000.00, 3, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(44, 'Glass jar', NULL, 'glass ', 900.00, 52, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(46, 'Beans ', NULL, 'Yellow beans', 4000.00, 0, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(47, 'Stick glue', NULL, 'Single', 1000.00, 5, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(48, 'Filter paper ', NULL, '1A, 100 strips', 35000.00, 1, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(49, 'Rechargeable batteries ', NULL, '12 V 3A and holder', 33000.00, 0, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(50, 'Biological specimen', NULL, 'Contain plant,insect,human tissue and microorganism specimens', 130000.00, 5, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(51, 'Black pepper powder', NULL, '400gm', 3800.00, 2, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(53, 'glucose', NULL, '500 g', 28000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(54, 'Beam balance', NULL, 'One black, four whites', 30000.00, 4, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(55, 'mini A-B  positive negative motor  repair', NULL, '4pcs\r\n', 234639.00, 2, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(56, 'LED', NULL, 'green ,white, red,yellow', 200.00, 177, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(57, 'Copper rod', NULL, '2L', 5000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(58, 'Micro Oral Gel', NULL, '30g', 5000.00, 4, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(59, 'Straw', NULL, 'Packets contains 150 straws inside\r\n', 1500.00, 850, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(60, 'Pheniphythalein indicator', NULL, '40ml', 45000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(62, 'Snap circuits ', NULL, 'Build over 100 electronics project ', 51000.00, 2, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(63, 'HISENSE AIR CONDITION', NULL, 'BOARD ROOM\r\nPI OFFICE CABINATE 0001', 100000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(64, 'Prism', NULL, 'Two red, four black', 25000.00, 6, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(65, 'Ammonia ', NULL, '1L', 35000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(66, 'Slime activactor', NULL, '946ml', 35240.10, 5, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(67, 'Corn Flour', 'products/1761073142_68f7d7f671ef3.jpg', '400g', 2500.00, 12, 'Kitchen Equipment', 'Dar es Salaam', '0000-00-00 00:00:00'),
(68, 'Triple scale hydrometer', NULL, 'Full packed', 50000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(69, 'Thermochromic pigment', NULL, 'colormagic pigment\r\n5color,3 grams each', 4149405.00, 2, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(70, 'Ruler', NULL, '30cm rulers', 500.00, 30, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(71, 'SOUND DISH', NULL, 'BACKYARD', 2780000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(72, 'Tealight candles', NULL, '10g', 10000.00, 2, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(73, 'Pocket microscope', 'products/WhatsApp Image 2024-12-04 at 18.24.27.jpeg', 'Full packed', 55000.00, 15, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(74, 'droppers', NULL, 'white plastic funnel', 500.00, 800, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(75, 'Magnesium hydroxide', NULL, '500g', 35000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(76, 'facial interface& face cover ', NULL, 'face cover pad for oculus quest 2 ,swaet proof PU foam cushion ', 44343.90, 4, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(77, 'Cupric sulphate anhydrous', NULL, 'Blue color, one bottle', 45000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(78, 'calcium carbonate', NULL, '500g', 32000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(79, 'CHILDREN CHAIR', NULL, 'BETA CLASS', 85000.00, 20, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(80, 'Petri dish', NULL, 'Medium size ', 500.00, 21, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(81, 'zip bag (small size)', NULL, '50 bags (18cm*21cm)\r\n', 13000.00, 100, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(82, 'DOACT tiny whoop race gate ', NULL, 'drone race gate', 24975.00, 2, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(84, 'Burette ( 50mls) ', NULL, '50 millilitres', 20000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(85, 'Spirit', NULL, '4000 ml', 12000.00, 2000, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(86, 'plastic plate', NULL, 'plastic plate ', 7000.00, 250, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(87, 'Clean water science kit', 'products/1761068068_68f7c4243a3ae.jpg', 'Full packed', 40000.00, 29, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(88, 'Electronic Digital Caliper', NULL, 'Full packed', 61000.00, 6, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(89, 'BRANG RANGRANG', NULL, 'RIGHT SIDE OF THE PREMISES', 110000.00, 0, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(90, 'Staple pins', NULL, 'Packet', 1500.00, 1, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(92, 'Beaker (25 ml)', NULL, '25 milliliters (ml)', 2500.00, 0, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(93, 'Lithium Battery (Box)', NULL, 'CR2032\r\n3V', 2000.00, 2, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(94, 'TV(HISENSE)', NULL, 'DIRECTOR OFFICE', 1100000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(95, 'Blueband', NULL, '200 Grams', 3000.00, 2, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(96, 'dry ice', NULL, 'ice', 41300.00, 0, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(97, 'Nappy pins', NULL, '2 packets', 5000.00, 1, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(98, 'cotton', NULL, 'white', 6000.00, 5, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(99, 'Hydrogen peroxide ', NULL, '100ml (6%)', 1000.00, 94, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(100, 'Correction fluid', NULL, 'Single', 3000.00, 8, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(101, 'LED Black Light', NULL, '10W', 35700.00, 2, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(102, 'Balloon pump', NULL, '1 green, 1 red', 8000.00, 4, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(103, 'Plastic containers ', NULL, 'Three containers', 25000.00, 0, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(104, 'Motor and Pestle', NULL, 'Small size', 8000.00, 14, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(105, 'Spirit ', NULL, '5litre ', 20000.00, 1, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(106, 'White Manila', NULL, 'A4 Brief card 180gm @100 sheets\r\n', 6000.00, 2, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(107, 'Jumper wire', NULL, 'Male to male\r\nMale to Female\r\n', 100.00, 380, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(108, 'Plastic funnel', NULL, '2 -Red\r\n3- Blue\r\n1- yellow\r\n2-green', 1000.00, 8, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(109, 'Sodium Fluoride ', NULL, '500gm ', 40000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(110, 'Rubber Band ', NULL, 'Single', 8500.00, 1, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(111, 'Nutrients solution ', NULL, '1 litres', 10000.00, 1, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(112, 'Gram stain kit', NULL, 'One kit used half', 28000.00, 1, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(113, 'Raisin', NULL, '400gm', 5000.00, 2, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(114, 'Goggles', NULL, 'Black in colour', 23000.00, 25, 'Protective_Gamets', 'Dar es Salaam', '0000-00-00 00:00:00'),
(115, 'coffee mate', NULL, '180g', 16500.00, 0, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(116, 'Batteries ', NULL, '1.5 v', 500.00, 28, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(117, 'HISENSE AIR CONDITION', NULL, 'BOARD ROOM\r\nBQB9P9CT800272T2022', 2000000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(118, 'Powdered Gloves.', NULL, 'Powder Gloves Medium 100 gloves ', 8000.00, 10, 'Hospital', 'Dar es Salaam', '0000-00-00 00:00:00'),
(119, 'HISENSE AIR CONDITION', NULL, 'EXPLORATORIUM ROOM\r\nAS-12TR4SYEDB04', 1500000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(120, 'MAGNET BED EXHIBIT', NULL, 'LEFT SIDE OF THE PREMISES', 346000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(121, 'potasium carbonate', NULL, '50000g', 36000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(122, 'coin battery', 'products/1761072908_68f7d70c0c2b0.jpg', 'CR2025 (box)', 30000.00, 15, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(123, 'Goldenrod paper', NULL, 'color : gold\r\n100sheets', 9079905.00, 2, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(124, 'glow stick', NULL, '500pcs', 23725.00, 1, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(125, 'Dialysis tubing', NULL, '3m', 40000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(126, 'marker pen', NULL, 'kai  kai pen make\r\n10pcs', 2000.00, 2, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(127, 'Tonic Water', NULL, 'carbonated soft drink\r\n500ml', 950.00, 5, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(128, 'ROTATING DISK ILLUSION', NULL, 'FRONT SIDE OF THE PREMISES', 678000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(129, 'Spinach seed', NULL, '25gm', 3000.00, 2, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(130, 'Conical flask (500ml) ', NULL, '500 millilitres ( ml) ', 10000.00, 10, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(131, 'Zip bag (Large size)', NULL, '30 bags (30cm*40cm)', 10000.00, 60, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(132, 'Simple kits microscope ', NULL, 'Use batteries ', 100000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(133, 'SAND BED', NULL, 'LEFT SIDE OF THE PREMISES', 780000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(134, 'sodium acetate ', NULL, '500g', 26856.00, 2, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(135, 'hands on lightning  rod', NULL, 'electricity and circuit -human electricity conductor', 2556470.00, 2, 'Electronics', 'Dar es Salaam', '0000-00-00 00:00:00'),
(136, 'Lighter', NULL, 'Blue', 6000.00, 4, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(137, 'Saw', NULL, 'New full packed', 5000.00, 8, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(138, 'propane torch head ', NULL, 'propane torch with self ignition &adjustable knob', 46953.90, 1, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(139, 'Push pins', NULL, 'Packets', 2000.00, 6, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(140, 'Thread', NULL, 'Full bundles', 3000.00, 0, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(141, 'Powder food color ', NULL, 'Powder food color  (100gm)', 4500.00, 12, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(142, 'Measuring cylinder (500mls)', NULL, '500 ml (glass)', 12000.00, 5, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(143, 'Potassium Thiocyanite', NULL, '500gm\r\n', 48000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(144, 'COLORED SHADOW', NULL, 'RECEPTION', 180000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(145, 'WATER DISPENSER', NULL, 'STAFF OFFICE', 350000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(146, 'Litmus Paper (Red&Blue)', NULL, '100 Pieces Litmus Papers in one pack ( 5 books each with 20 pages). ', 23000.00, 2, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(147, 'Olive oil', NULL, 'miles', 19500.00, 1, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(148, 'Wipes', NULL, '80Pcs', 5000.00, 0, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(149, 'Potassium hydroxide pellets', NULL, 'Half used', 40000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(150, 'Masking Tape ', NULL, 'masking tape @ 2000', 2000.00, 5, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(151, 'Bleach', 'products/1761067884_68f7c36ca3196.png', '700ml', 10000.00, 1, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(152, 'Ballon ', 'products/1762773246_6911c8fe5ff59.jpg', 'Packet ', 8000.00, 5, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(153, 'Potassium permanganate ', NULL, '6l500g', 40000.00, 2, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(154, 'HISENSE AIR CONDITION', NULL, 'RECEIPTION\r\nPI OFFICE FAN 0001', 17076000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(155, 'Manila ', NULL, 'A4\r\nwhite color\r\nSize  :210  *297mm\r\nbrief card  180gm\r\n', 6500.00, 2, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(156, 'Pipete', NULL, '20 mls', 20000.00, 2, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(157, 'Vinegar', 'products/1761074149_68f7dbe55bbc0.jpg', '1000 ml', 1800.00, 13, 'Kitchen Equipment', 'Dar es Salaam', '0000-00-00 00:00:00'),
(158, 'Salt', NULL, '1kg per each packet', 800.00, 6, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(159, 'HISENSE AIR CONDITION', NULL, 'BABY CLASS\r\nPI OFFICE TABLE 0002', 200000.00, 2, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(160, 'Plastic cups ', NULL, '500mls', 7000.00, 125, 'Kitchen', 'Dar es Salaam', '0000-00-00 00:00:00'),
(161, 'Astronaut suit', NULL, 'orange suit', 206190.00, 2, 'Protective_Gamets', 'Dar es Salaam', '0000-00-00 00:00:00'),
(162, 'verdenu seed trays with grow light', NULL, '5 pack seed starter tray with timing controller ,60 -cells seed starter kit adjustable brightiness and humidity ', 46927.00, 18, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(163, 'ring and ball   apparatus', NULL, 'Thermal expansion and contraction material', 365139.00, 4, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(164, 'pencil (box)', NULL, 'Pencil - HB - Red - 6621', 2500.00, 5, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(165, 'Selo Tape', NULL, 'Office Sellotape', 4900.00, 1, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(166, 'PLANKS + PLANKS BOX', NULL, 'ENTRANCE', 1231000.00, 2, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(167, 'Projector', NULL, 'Epson', 1500000.00, 2, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(168, 'SOUND PIPE/NDALA SOUND', NULL, 'FRONT SIDE OF THE PREMISES', 962000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(169, 'HISENSE AIR CONDITION', NULL, 'PI OFFICE TABLE 0001\r\nCLASS ROOM', 100000.00, 4, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(170, 'Measuring cylinder ( 500mls)', NULL, '500 mls', 2000.00, 7, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(171, 'Fermentation kit', NULL, '500mls', 8000.00, 9, 'Agriculture', 'Dar es Salaam', '0000-00-00 00:00:00'),
(172, 'breadboard', NULL, 'long', 8000.00, 13, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(173, 'Retort stand', NULL, 'Mild bending type', 15000.00, 3, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(174, 'Magnetic stir', NULL, 'Full packed', 75000.00, 4, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(175, 'Resistor', NULL, '1k ohms', 200.00, 199, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(176, 'TORNADO BOTTLE', NULL, 'ENTRANCE', 429000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(177, 'helium tank', NULL, 'helium gas', 150000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(179, 'Molecular model kit', NULL, 'Full packed', 60000.00, 5, 'Instruments', 'Dar es Salaam', '0000-00-00 00:00:00'),
(180, 'SHELF', NULL, 'STAFF OFFICE', 112500.00, 8, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(181, 'Dilute hydrochloric acid (HCl)', NULL, 'Hydrochloric acid 35% Extrapure', 40000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(182, 'Knives ', 'products/1754478484_689337948aaab.jpg', 'For Rss Session ', 3000.00, 27, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(183, 'PLASTIC TABLE', NULL, 'BOARD ROOM', 80000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(184, 'SHELF', NULL, 'STAFF OFFICE', 100000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(185, 'Iron (iii) Chloride ', NULL, '500gm', 38000.00, 1, 'Chemical', 'Dar es Salaam', '0000-00-00 00:00:00'),
(187, 'Makey Makey ', 'products/1000070308.jpg', 'Hands-on Technology Learning Fun - Science Education - 1000s of Engineering and Computer Coding Activities ', 100000.00, 9, 'IT', 'Dar es Salaam', '0000-00-00 00:00:00'),
(189, 'JBL', NULL, 'STAFF STORE', 2014000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(190, 'Knife Cutter ', NULL, 'Amartisan 14-Piece Retractable Box Cutter, Utility Knifes for Boxes, Cartons, Cardboard Cutting, 18mm & 9mm Wide Blade Cutter, Very Suitable for Office and Home ...', 3000.00, 10, 'Stationary', 'Dar es Salaam', '0000-00-00 00:00:00'),
(191, 'HISENSE AIR CONDITION', NULL, 'RECEIPTION\r\nPI OFFICE TABLE 0005', 120000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(192, 'JASTROW (Optical illusion Exhibits)', NULL, 'FRONT SIDE OF THE PREMISES', 560000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(193, 'ANT-GRAVITY MIRROR', NULL, 'BACKYARD', 1439000.00, 0, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(194, 'plastic Cups ', NULL, '500ml', 9000.00, 200, 'Kitchen Equipment', 'Dar es Salaam', '0000-00-00 00:00:00'),
(195, 'DOWN HILL RACE ', NULL, 'LEFT SIDE OF THE PREMISES', 602000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(196, 'HISENSE AIR CONDITION', NULL, 'AS-12TR4SYEDB04\r\nSTAFF OFFICE', 1100000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(197, 'NOTE BOARD', NULL, 'STAFF OFFICE', 177000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(198, 'HISENSE AIR CONDITION', NULL, 'DIRECTOR OFFICE\r\nPI OFFICE FAN 0002', 17076000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(199, 'HISENSE AIR CONDITION', NULL, 'COMPUTER ROOM\r\nPI OFFICE TABLE 0003', 90000.00, 6, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(200, 'STEADY HAND EXHIBITS', NULL, 'ENTRANCE', 615500.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(201, 'HISENSE AIR CONDITION', NULL, 'BOARD ROOM\\r\\n3TE55F2001113FOIC33260877', 1100000.00, 4, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(202, 'Compass (Oxford)', 'products/1755242726_689ee0e6b2c69.png', 'Oxford Helix Math\\\'s Set with Storage Tin', 8500.00, 10, '', 'Dar es Salaam', '0000-00-00 00:00:00'),
(203, 'WOOD CHAIR', NULL, 'STORE ', 35000.00, 8, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(204, 'STRIPY MIRRORS', NULL, 'RIGHT SIDE OF THE PREMISES', 968000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(205, 'MAGIC SWING', NULL, 'BACKYARD', 2200000.00, 1, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(206, 'OFFICE CHAIR', NULL, 'STAFF OFFICE', 160000.00, 8, 'Office', 'Dar es Salaam', '0000-00-00 00:00:00'),
(609, 'Mini juice blender ', NULL, '420ml', 15000.00, 1, 'Kitchen Equipment', NULL, '2025-08-11 09:12:11'),
(610, 'Mini juice blender ', NULL, '420ml', 15000.00, 1, 'Kitchen Equipment', NULL, '2025-08-11 09:12:45'),
(611, 'Office glue', NULL, '1mls', 10000.00, 6, 'Stationery', NULL, '2025-08-11 09:13:06'),
(612, 'Office glue', NULL, '1000ml', 10000.00, 6, 'Stationery', NULL, '2025-08-11 09:19:05'),
(613, 'Office glue', NULL, '1000ml', 10000.00, 6, 'Stationery', NULL, '2025-08-11 09:19:47'),
(614, 'Fruit juicer ', NULL, '450mls', 15000.00, 1, 'Kitchen Equipment', NULL, '2025-08-11 09:21:01'),
(615, 'Blue band', 'products/1761067940_68f7c3a45444e.jpg', '500g', 5000.00, 2, 'Kitchen Equipment', NULL, '2025-08-11 09:22:42'),
(616, 'Wood glue ', NULL, '500mls', 10000.00, 6, 'Stationery', NULL, '2025-08-11 09:22:42'),
(617, 'Modelling clay', NULL, '6 per box', 10000.00, 7, 'Stationery', NULL, '2025-08-11 10:01:44'),
(618, 'Glue stick', NULL, '36g ', 2000.00, 4, 'Stationery', NULL, '2025-08-11 10:05:09'),
(619, 'Glue stick', NULL, '21g', 2000.00, 1, 'Stationery', NULL, '2025-08-11 10:08:19'),
(620, 'Glue stick ', NULL, '9g', 1000.00, 1, 'Stationery', NULL, '2025-08-11 10:10:40'),
(621, 'Glue stick ', NULL, '9g', 1000.00, 1, 'Stationery', NULL, '2025-08-11 10:10:44'),
(622, 'Highlighter', 'products/1761074420_68f7dcf4f3499.jpg', '10 per each ', 2000.00, 4, 'Stationery', NULL, '2025-08-11 10:13:15'),
(623, 'Marbles ', NULL, '2 boxes ', 2000.00, 2, 'Stationery', NULL, '2025-08-11 10:16:43'),
(624, 'Thumb pin ', NULL, '1 pocket ', 5000.00, 1, 'Stationery', NULL, '2025-08-11 10:18:12'),
(625, 'Glitter ', NULL, '1 box', 2000.00, 1, 'Stationery', NULL, '2025-08-11 10:19:42'),
(626, 'Rubber ', NULL, '1 box ', 5000.00, 1, 'Stationery', NULL, '2025-08-11 10:27:03'),
(627, 'Playing cards ', NULL, '5 boxes ', 2000.00, 5, 'Stationery', NULL, '2025-08-11 10:29:13'),
(628, 'Silver Crest Blender ', 'products/1754908198_6899c62638bc5.jpg', 'Multifunction Blender 4500 ml', 60000.00, 1, 'Kitchen Equipment', NULL, '2025-08-11 10:29:58'),
(629, 'Pencils', NULL, 'HB', 2000.00, 16, 'Stationery', NULL, '2025-08-11 10:31:18'),
(630, 'Gas lighter ', 'products/1761073424_68f7d910329c6.jpg', 'Gas lighter ', 7000.00, 3, 'Kitchen Equipment', NULL, '2025-08-11 10:32:16'),
(632, 'Mathematical set', NULL, 'Nataraji', 2000.00, 1, 'Stationery', NULL, '2025-08-11 10:36:38'),
(633, 'Mathematical set', NULL, 'Nataraj', 2000.00, 1, 'Stationery', NULL, '2025-08-11 10:37:54'),
(635, 'Rubber band ', NULL, '1 packet ', 2000.00, 1, 'Stationery', NULL, '2025-08-11 10:39:09'),
(636, 'Rubber band ', NULL, '1 packet ', 2000.00, 1, 'Stationery', NULL, '2025-08-11 10:39:11'),
(637, 'Balloon rocket ', NULL, 'Mixed colour ', 10000.00, 40, 'Stationery', NULL, '2025-08-11 10:41:16'),
(638, 'Borosilicate glass ', 'products/1754908911_6899c8ef202e3.jpg', '1.6litres', 20000.00, 1, 'Kitchen Equipment', NULL, '2025-08-11 10:41:51'),
(639, 'Borosilicate ', 'products/1754908967_6899c92730deb.jpg', '2.4 litres', 20000.00, 2, 'Kitchen Equipment', NULL, '2025-08-11 10:42:47'),
(640, 'Tennis balls ', NULL, '3 packet ', 4000.00, 9, 'Stationery', NULL, '2025-08-11 10:43:10'),
(641, 'Borosilicate glass', 'products/1754909024_6899c96090a08.jpg', '3 litres', 20000.00, 1, 'Kitchen Equipment', NULL, '2025-08-11 10:43:44'),
(642, 'Glass', 'products/1754909156_6899c9e48d4c9.jpg', '300ml', 15000.00, 5, 'Kitchen Equipment', NULL, '2025-08-11 10:45:56'),
(643, 'Glass bowl', 'products/1754909293_6899ca6dcd42d.jpg', '2000 ml', 4000.00, 3, '', NULL, '2025-08-11 10:48:13'),
(644, 'Glass bowl', 'products/1754909436_6899cafc51d20.jpg', '5400ml', 4000.00, 4, 'Kitchen Equipment', NULL, '2025-08-11 10:50:36'),
(645, 'Glass bowl', 'products/1755087248_689c819036d53.jpg', '200ml', 4000.00, 1, 'Kitchen Equipment', NULL, '2025-08-13 12:14:08'),
(646, 'Tealight candle', 'products/1755087337_689c81e9f1871.jpg', '49 pieces instead of 50 per box ', 50000.00, 6000, 'Kitchen Equipment', NULL, '2025-08-13 12:15:37'),
(647, 'Tiger candle long lasting ', 'products/1755087451_689c825b63a19.jpg', '4 full package \\r\\n2 candles out of package ', 3500.00, 26, 'Kitchen Equipment', NULL, '2025-08-13 12:17:31'),
(648, 'Tumeric powder ', 'products/1755087534_689c82ae4639c.jpg', '500ml bottle ', 500.00, 4, 'Kitchen Equipment', NULL, '2025-08-13 12:18:54'),
(649, 'Powdered food colour ', 'products/1755087673_689c833943758.jpg', '1 red 100 gms\\r\\n2 orange 100 gms\\r\\n1 green 100gms\\r\\n1 chocolate 100gms\\r\\n1 yellow 100gms ', 500.00, 6, 'Kitchen Equipment', NULL, '2025-08-13 12:21:13'),
(650, 'Liquid food colour ', 'products/1755087760_689c8390982f6.jpg', '1 green\\r\\n1 yellow\\r\\n2 red\\r\\n1 black\\r\\n1 pink\\r\\n1 purple \\r\\n140gms all bottles ', 500.00, 7, 'Kitchen Equipment', NULL, '2025-08-13 12:22:40'),
(651, 'Small Plastic plate ', 'products/1755088397_689c860d9db81.jpg', 'Plastic plates ', 200.00, 210, 'Kitchen Equipment', NULL, '2025-08-13 12:24:31'),
(652, 'Large plastic plate', 'products/1755088266_689c858a645a6.jpg', 'Plastic plate ', 200.00, 28, 'Kitchen Equipment', NULL, '2025-08-13 12:31:06'),
(653, 'Disposable plate', 'products/1755088378_689c85fa10754.jpg', 'Disposable plate', 200.00, 17, 'Kitchen Equipment', NULL, '2025-08-13 12:32:58'),
(654, 'Popsticle stick', 'products/1755088534_689c86968aa67.jpg', 'Some are in package and other are not packaged', 500.00, 1066, 'Kitchen Equipment', NULL, '2025-08-13 12:35:34'),
(655, 'Toothpicks Box', 'products/1755088596_689c86d4744c4.jpg', '150pcs', 1000.00, 45, 'Kitchen Equipment', NULL, '2025-08-13 12:36:36'),
(656, 'clothes hangers', 'products/1755088664_689c87182d838.jpg', 'hanging device for Rss activities\\r\\n', 1200.00, 20, 'Kitchen Equipment', NULL, '2025-08-13 12:37:44'),
(657, 'Toothpicks ', 'products/1755088699_689c873b60d16.jpg', '', 1000.00, 45, 'Kitchen Equipment', NULL, '2025-08-13 12:38:19'),
(658, 'Manilla paper', NULL, 'Mixed colours ', 5000.00, 6, 'Stationery', NULL, '2025-08-13 12:46:37'),
(659, 'Gillette shave foam', 'products/1755090336_689c8da06f39c.jpeg', '300ml', 10000.00, 3, 'Stationery', NULL, '2025-08-13 12:47:55'),
(661, 'Glycerin', 'products/1755089461_689c8a3570104.jpeg', '500ml', 5000.00, 1, 'Chemistry Tools', NULL, '2025-08-13 12:51:01'),
(662, 'Safety Goggles ', NULL, 'Large goggles ', 10000.00, 20, 'Stationery', NULL, '2025-08-13 12:51:18'),
(663, 'Safety glasses ', NULL, 'Small  glasses ', 10000.00, 35, 'Stationery', NULL, '2025-08-13 12:52:47'),
(664, 'Balloon pump', 'products/1755089620_689c8ad4e09d9.jpeg', 'mixed colors', 5000.00, 2, 'Stationery', NULL, '2025-08-13 12:53:40'),
(665, 'Magnets ', NULL, 'Black different  shapes ', 20000.00, 34, 'Electronics', NULL, '2025-08-13 12:55:49'),
(666, 'Ping-pong balls ', NULL, 'Orange color ', 20000.00, 20, 'Stationery', NULL, '2025-08-13 12:58:08'),
(668, 'Coin battery ', 'products/1761072706_68f7d6420fc72.png', '3v', 15000.00, 80, 'Electronics', NULL, '2025-08-13 13:05:20'),
(671, 'Coper tape ', NULL, '4 small\\r\\n2 large ', 20000.00, 6, 'Stationery', NULL, '2025-08-13 13:16:38'),
(672, 'Coper tape ', NULL, '4 small\\r\\n2 large ', 20000.00, 6, 'Stationery', NULL, '2025-08-13 13:16:41'),
(673, 'Amazon battery charger ', 'products/1760532098_68ef968264ac5.jpg', 'Black', 20000.00, 1, 'Electronics', NULL, '2025-08-13 13:17:31'),
(674, 'Baking soda', 'products/1755091167_689c90df1ea9b.jpg', '23 package \\r\\n2 packet ', 500.00, 278, 'Kitchen Equipment', NULL, '2025-08-13 13:19:27'),
(675, 'Baking powder ', 'products/1755091291_689c915b5cdf1.jpg', 'Packets ', 300.00, 57, 'Kitchen Equipment', NULL, '2025-08-13 13:21:31'),
(676, 'Corn flour ', 'products/1755091392_689c91c0eee2f.jpg', '9 boxes \\r\\n400g each ', 1200.00, 9, 'Kitchen Equipment', NULL, '2025-08-13 13:23:12'),
(677, 'Dry Yeast ', 'products/1755091519_689c923fd4105.jpg', '2 boxes\\r\\n450g each ', 1000.00, 2, 'Kitchen Equipment', NULL, '2025-08-13 13:25:19'),
(678, 'White vinegar ', 'products/1755091615_689c929fb0025.jpg', '1 bottle contain ml', 1200.00, 41, 'Kitchen Equipment', NULL, '2025-08-13 13:26:55'),
(679, 'Plastic spoon ', 'products/1755091726_689c930e4090a.jpg', 'Disposable spoon ', 200.00, 174, 'Kitchen Equipment', NULL, '2025-08-13 13:28:46'),
(680, 'Salt', 'products/1755091810_689c93623e8b6.jpg', '500g each packet ', 500.00, 49, 'Kitchen Equipment', NULL, '2025-08-13 13:30:10'),
(681, 'Clay cup', 'products/1755091911_689c93c77614a.jpg', '', 1000.00, 9, 'Kitchen Equipment', NULL, '2025-08-13 13:31:51'),
(682, 'Coca-Cola ', 'products/1755092007_689c9427e3857.jpg', '1.25 litres', 2500.00, 3, 'Kitchen Equipment', NULL, '2025-08-13 13:33:27'),
(684, 'Cork ', 'products/1755092237_689c950dbb5e3.jpg', 'Piece of wood', 250.00, 23, 'Kitchen Equipment', NULL, '2025-08-13 13:37:17'),
(685, 'Mile cores', 'products/1755092361_689c958939095.jpg', '500g packet ', 6500.00, 1, 'Kitchen Equipment', NULL, '2025-08-13 13:39:21'),
(686, 'Mountain dew', 'products/1755092456_689c95e87c01c.jpg', '600mls', 1000.00, 4, 'Kitchen Equipment', NULL, '2025-08-13 13:40:56'),
(687, 'Toothpick', 'products/1755513334_68a301f6510ef.jpeg', 'Packet ', 1200.00, 1, 'Kitchen Equipment', NULL, '2025-08-18 10:35:34'),
(689, 'Toilet paper ', NULL, 'Packet ', 10800.00, 2, '', NULL, '2025-08-18 10:41:26'),
(690, 'Pyodine idone ', 'products/1755518367_68a3159f4c2ce.jpg', '450mls bottle', 20000.00, 1, 'Chemistry Tools', NULL, '2025-08-18 11:59:27'),
(691, 'Povidone ', 'products/1755518700_68a316ec76df3.jpg', 'Bottle 250mls', 15000.00, 2, 'Chemistry Tools', NULL, '2025-08-18 12:05:00'),
(692, 'Povidone ', 'products/1755518975_68a317ff0347e.jpg', 'Bottle 250mls', 1000.00, 2, '', NULL, '2025-08-18 12:09:35'),
(693, 'stack of clear plastic cups', NULL, 'Small Plastic cups 14.8 ml', 5000.00, 67, 'Kitchen Equipment', NULL, '2025-08-18 12:20:20'),
(694, 'Plastic Cup', 'products/1755519890_68a31b92a0123.jpeg', 'Plastic \\r\\n', 7000.00, 67, 'Kitchen Equipment', NULL, '2025-08-18 12:24:50'),
(695, 'Insulated cup ', 'products/1755520284_68a31d1ca6146.jpeg', 'Insulated cup for hot and cold drink', 4500.00, 65, 'Kitchen Equipment', NULL, '2025-08-18 12:25:30'),
(696, 'Plastic Cup', 'products/1755519985_68a31bf1168b4.jpeg', 'Transparent cups', 8000.00, 95, 'Kitchen Equipment', NULL, '2025-08-18 12:26:25'),
(697, 'Paper Cup ', 'products/1755520147_68a31c938ed87.jpeg', 'Paper Cup Size Small 2.5 oz', 7000.00, 133, 'Kitchen Equipment', NULL, '2025-08-18 12:29:07'),
(700, 'Plastic cup', 'products/1755520776_68a31f089ad7d.jpg', 'Coloured plastic cup\\r\\n50 green\\r\\n43 light blue\\r\\n24 mixed colour ', 500.00, 117, 'Kitchen Equipment', NULL, '2025-08-18 12:39:36'),
(701, 'Plastic cup', 'products/1755520808_68a31f28a844d.jpg', 'Coloured plastic cup\\r\\n50 green\\r\\n43 light blue\\r\\n24 mixed colour ', 500.00, 117, 'Kitchen Equipment', NULL, '2025-08-18 12:40:08'),
(702, 'Plastic Bowl', NULL, 'Plastic Bowl 300ml size', 7000.00, 95, 'Kitchen Equipment', NULL, '2025-08-18 12:40:16'),
(703, 'Film canister ', 'products/1755520965_68a31fc5c885c.jpg', '20ml', 200.00, 124, 'Kitchen Equipment', NULL, '2025-08-18 12:42:45'),
(704, 'Bamboo skewers ', 'products/1755521076_68a3203420345.jpg', '8 packets @100 piece \\r\\n76 half packet ', 5000.00, 876, 'Kitchen Equipment', NULL, '2025-08-18 12:44:36'),
(705, 'Small zipbag', 'products/1755521194_68a320aae08b8.jpg', '20 ml', 500.00, 117, 'Kitchen Equipment', NULL, '2025-08-18 12:46:34'),
(706, 'Medium zipbag', 'products/1755521260_68a320ec92166.jpg', '50 ml', 500.00, 39, 'Kitchen Equipment', NULL, '2025-08-18 12:47:40'),
(707, 'Super ziper', 'products/1755521385_68a321699d6f2.jpg', '30cm × 40cm', 500.00, 2, '', NULL, '2025-08-18 12:49:45'),
(708, 'Falcon clean film', 'products/1755521763_68a322e3e62db.jpg', '100sqft×30cm', 1000.00, 3, 'Kitchen Equipment', NULL, '2025-08-18 12:56:03'),
(709, 'Tea bags', 'products/1755521898_68a3236a02977.jpg', '1 box with 80 bag\\r\\n38 pieces ', 5000.00, 118, 'Kitchen Equipment', NULL, '2025-08-18 12:58:18'),
(710, 'Liquid soap', 'products/1755522150_68a32466ea11e.jpg', '9 yellow \\r\\n1 pink\\r\\n3 purple ', 1500.00, 13, 'Kitchen Equipment', NULL, '2025-08-18 13:02:30'),
(711, 'Hand sanitizer ', 'products/1755522249_68a324c91a9ea.jpg', '500 ml', 1500.00, 4, 'Kitchen Equipment', NULL, '2025-08-18 13:04:09'),
(712, 'Sugar ', 'products/1755522409_68a325693dcae.jpeg', 'Kilombero Packet 1kg', 3000.00, 12, 'Kitchen Equipment', NULL, '2025-08-18 13:06:49'),
(713, 'Shower gel', 'products/1755522654_68a3265e0bd1d.jpg', '500ml ', 9000.00, 1, 'Kitchen Equipment', NULL, '2025-08-18 13:10:54'),
(714, 'Paper wrapped drinking straw', 'products/1755522846_68a3271ea831f.jpg', '1 packets @150 piece \\r\\n24 piece ', 8000.00, 174, 'Kitchen Equipment', NULL, '2025-08-18 13:14:06'),
(715, 'Plastic straw ', 'products/1755522936_68a327788c06c.jpg', '12mm', 6000.00, 14, 'Kitchen Equipment', NULL, '2025-08-18 13:15:36'),
(716, 'vetmycine', 'products/1756210346_68ada4aaeb4d5.jpg', 'oxytetracycline HCL 20%', 120000.00, 1, 'Chemistry Tools', NULL, '2025-08-26 12:12:26'),
(717, 'supper feed', NULL, '1 kg', 120000.00, 1, '', NULL, '2025-08-26 12:15:34'),
(718, 'job guard blue ', NULL, 'multpulpose gloves', 120000.00, 1, 'Chemistry Tools', NULL, '2025-08-26 12:18:07'),
(719, 'marspark', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:21:27'),
(720, 'falcon zipper bag ', NULL, '', 4500.00, 3, '', NULL, '2025-08-26 12:26:09'),
(721, 'smart mini laber maker', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:27:39'),
(722, 'smart mini laber maker', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:27:55'),
(723, 'plant food ', NULL, '', 4500.00, 2, '', NULL, '2025-08-26 12:30:08'),
(724, 'v multinor bolus', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:33:40'),
(725, 'v multinor bolus', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:34:14'),
(726, 'vocrs', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:36:00'),
(727, 'v multinor', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:38:28'),
(728, 'tetranor', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:40:23'),
(729, 'keen mavuno', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:42:23'),
(730, 'down ph', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:44:38'),
(731, 'ivanor', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:48:16'),
(732, 'up ph', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 12:49:06'),
(733, 'PLASTER OF PARIS', NULL, '', 4500.00, 1, 'Chemistry Tools', NULL, '2025-08-26 12:51:35'),
(734, 'PLASTER OF PARIS', NULL, '', 4500.00, 1, 'Chemistry Tools', NULL, '2025-08-26 12:51:37'),
(735, 'saw dust', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 13:03:59'),
(737, 'thermal bag', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 13:14:08'),
(738, 'white sponge', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 13:15:50'),
(739, 'green container ', NULL, '', 4500.00, 14, '', NULL, '2025-08-26 13:17:57'),
(740, 'small black trays', NULL, '', 4500.00, 25, '', NULL, '2025-08-26 13:20:12'),
(741, 'hydroponic net pot', NULL, '', 4500.00, 25, '', NULL, '2025-08-26 13:32:42'),
(742, 'small black trays', NULL, '', 4500.00, 25, '', NULL, '2025-08-26 13:36:56'),
(743, 'trays', NULL, '', 4500.00, 8, '', NULL, '2025-08-26 13:39:04'),
(744, 'ball baloon', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 13:42:13'),
(745, 'Methylated spirit', NULL, '', 4500.00, 1, 'Chemistry Tools', NULL, '2025-08-26 13:47:52'),
(747, 'povidone Iodine', NULL, '', 4500.00, 5, '', NULL, '2025-08-26 13:55:05'),
(748, 'Effy-rexy', NULL, '', 4500.00, 4, '', NULL, '2025-08-26 13:57:51'),
(749, 'xazano fizz', NULL, '', 4500.00, 1, '', NULL, '2025-08-26 14:03:50'),
(750, 'Kangaroo staples', 'products/1756276344_68aea678d73b4.jpg', '10 staples per box', 100.00, 10, 'Stationery', NULL, '2025-08-27 06:32:24'),
(751, 'large balancing ball', 'products/1756280987_68aeb89b850b7.jpg', 'one balancing ball', 20000.00, 1, 'Engineering Devices', NULL, '2025-08-27 07:49:47'),
(752, 'small balancing ball', 'products/1756281131_68aeb92b2d047.jpg', 'two small balancing ball', 20000.00, 2, 'Engineering Devices', NULL, '2025-08-27 07:52:11'),
(753, 'colorful math figure sticks', 'products/1756281384_68aeba285c7b1.jpg', 'one contain 19 pcs', 10000.00, 3, 'Engineering Devices', NULL, '2025-08-27 07:56:24'),
(754, 'Conical Flask 50mls', 'products/1756281542_68aebac697b0f.jpg', 'conical flask of 50mls', 1000.00, 1, 'Chemistry Tools', NULL, '2025-08-27 07:59:02'),
(755, 'conical flask 500mls', 'products/1756281769_68aebba92987f.jpg', 'conical flask 500mls', 3000.00, 2, 'Chemistry Tools', NULL, '2025-08-27 08:02:49'),
(756, 'conical flask 1000ml', 'products/1756281988_68aebc84010a7.jpg', 'conical flask 1000mls', 3000.00, 3, 'Chemistry Tools', NULL, '2025-08-27 08:06:27'),
(757, 'conical flask 250mls', 'products/1756282170_68aebd3a910dc.jpg', 'conical flask 250mls', 2000.00, 3, 'Chemistry Tools', NULL, '2025-08-27 08:09:30'),
(758, 'conical flask 2000mls', 'products/1756282282_68aebdaa69b16.jpg', 'conical flask 2000mls', 5000.00, 2, 'Chemistry Tools', NULL, '2025-08-27 08:11:22'),
(759, 'measuring cylinder 250mls', 'products/1756282430_68aebe3ebbd76.jpg', 'measuring cylinder 250mls', 5000.00, 5, 'Chemistry Tools', NULL, '2025-08-27 08:13:50'),
(760, 'Motor and pestle', 'products/1756282530_68aebea276fce.jpg', '18 large\\r\\n4 small', 5200.00, 22, 'Chemistry Tools', NULL, '2025-08-27 08:15:30'),
(761, 'plastic measuring cylinder', 'products/1756282652_68aebf1ca9124.jpg', 'plastic measuring cylinder 250mls', 4000.00, 14, 'Chemistry Tools', NULL, '2025-08-27 08:17:32'),
(762, 'measuring cylinder 500mls', 'products/1756282795_68aebfabef6a5.jpg', 'measuring cylinder 500mls', 5000.00, 3, 'Chemistry Tools', NULL, '2025-08-27 08:19:55'),
(763, 'Motor and pestle', 'products/1756282813_68aebfbd14034.jpg', '18 large\\r\\n4 small', 5200.00, 22, 'Chemistry Tools', NULL, '2025-08-27 08:20:13'),
(764, 'Petri dish', 'products/1756282866_68aebff294887.jpg', 'Plastic petridish', 5000.00, 94, 'Chemistry Tools', NULL, '2025-08-27 08:21:06'),
(765, 'plane mirror', 'products/1756283023_68aec08f9fddf.jpg', '105 plane mirror of different size', 500.00, 105, 'Chemistry Tools', NULL, '2025-08-27 08:23:43'),
(766, 'Flat bottom flask 100mls', 'products/1756283224_68aec158364f5.jpg', 'Flat bottom flask 100mls', 2000.00, 1, 'Chemistry Tools', NULL, '2025-08-27 08:27:04'),
(767, 'Flat bottom flask 250mls', 'products/1756283321_68aec1b9899f9.jpg', '250ml flat bottom flask ', 4000.00, 5, 'Chemistry Tools', NULL, '2025-08-27 08:28:41'),
(768, 'flat bottom flask 500mls', 'products/1756283443_68aec233ae2cf.jpg', '500mls flat bottom flask', 5000.00, 2, 'Chemistry Tools', NULL, '2025-08-27 08:30:43'),
(769, 'Flat bottom flask 250mls', 'products/1756283454_68aec23e1762f.jpg', '250ml flat bottom flask ', 4000.00, 5, 'Chemistry Tools', NULL, '2025-08-27 08:30:54'),
(770, 'glass dropper', 'products/1756283565_68aec2ad2a8ed.jpg', 'glass dropper', 300.00, 13, 'Chemistry Tools', NULL, '2025-08-27 08:32:45'),
(771, 'National geographic microscope ', NULL, 'National geographical microscope ', 50000.00, 6, 'Electronics', NULL, '2025-08-27 08:35:10'),
(773, 'Glass jar', 'products/1756284000_68aec4604cfd7.jpg', 'Glass jar', 1000.00, 65, 'Chemistry Tools', NULL, '2025-08-27 08:40:00'),
(775, 'Big microscope ', 'products/1756284163_68aec503e9409.jpg', 'Big microscope with lens', 100000.00, 1, 'Electronics', NULL, '2025-08-27 08:42:43'),
(776, 'Padlock', 'products/1756284276_68aec57400bba.jpg', 'Padlock with keys', 5000.00, 16, 'Engineering Devices', NULL, '2025-08-27 08:44:35'),
(777, 'Molecular model set', 'products/1756284434_68aec6121b918.jpg', '2 Large contain 444 pieces\\r\\n3 Small contain 122 pieces ', 120000.00, 5, 'Chemistry Tools', NULL, '2025-08-27 08:47:14'),
(778, 'Pocket microscope ', 'products/1756284624_68aec6d0dcf94.jpg', 'Pocket microscope ', 20000.00, 14, 'Electronics', NULL, '2025-08-27 08:50:24'),
(779, 'empty microscope slide', 'products/1756284770_68aec7620e217.jpg', 'one box contain 50 slides\\r\\n(2 box 100 slides)', 1000.00, 100, 'Electronics', NULL, '2025-08-27 08:52:50'),
(780, 'biological specimen (prepared slides)', 'products/1756285091_68aec8a3ec04a.jpg', 'one box contain 100 prepared specimen slides', 500000.00, 5, '', NULL, '2025-08-27 08:58:11'),
(781, 'Insect specimen ', 'products/1756285246_68aec93ea46e8.jpg', '1 box contain 6insects', 60000.00, 1, '', NULL, '2025-08-27 09:00:46'),
(782, 'grasshopper life cycle ', 'products/1756285395_68aec9d34d8d3.jpg', 'one box of life cycle', 60000.00, 1, '', NULL, '2025-08-27 09:03:15'),
(783, 'Insect specimen ', 'products/1756285411_68aec9e3b9c15.jpg', '1 box contain 6insects', 60000.00, 1, '', NULL, '2025-08-27 09:03:31'),
(784, 'Black slide', 'products/1756285506_68aeca4258bcb.jpg', 'Black slide ', 50000.00, 10, '', NULL, '2025-08-27 09:05:06'),
(785, 'lubor\\\'s lenses', 'products/1756285759_68aecb3f95c73.jpg', 'lubor\\\'s lenses', 5000.00, 16, '', NULL, '2025-08-27 09:09:19'),
(786, 'Microscope reflection mirror ', 'products/1756285877_68aecbb55e9a5.jpg', 'Microscope reflection mirror ', 50000.00, 2, '', NULL, '2025-08-27 09:11:17'),
(787, 'gyroscope', 'products/1756286103_68aecc974e5d0.jpg', 'gyroscope', 40000.00, 5, '', NULL, '2025-08-27 09:15:03'),
(788, 'Tunning fork', 'products/1756286319_68aecd6f4099c.jpg', 'Large 10\\r\\nSmall 4 boxes 8 fork@ box', 30000.00, 42, '', NULL, '2025-08-27 09:18:39'),
(789, 'Math puzzle', 'products/1756286601_68aece892c9c0.jpg', 'Math puzzle', 25000.00, 14, '', NULL, '2025-08-27 09:23:21'),
(790, 'Prism', 'products/1756286698_68aeceea9410d.jpg', 'Prism box ', 50000.00, 5, 'Engineering Devices', NULL, '2025-08-27 09:24:58'),
(791, 'handlens', 'products/1756286995_68aed013702b9.jpg', 'handlens', 5000.00, 39, '', NULL, '2025-08-27 09:29:55'),
(792, 'Math puzzle ', 'products/1756287223_68aed0f75f438.jpg', 'Math puzzle 52 2-5', 1500.00, 13, '', NULL, '2025-08-27 09:33:43'),
(793, 'personal scale weigh balance', 'products/1756287572_68aed254237f8.jpg', 'weigh balance', 25000.00, 6, 'Engineering Devices', NULL, '2025-08-27 09:39:32');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('Admin','User') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `can_manage_admins` tinyint(1) DEFAULT 0,
  `can_manage_users` tinyint(1) DEFAULT 0,
  `can_view_reports` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `role`, `created_at`, `can_manage_admins`, `can_manage_users`, `can_view_reports`) VALUES
(3, 'simon', 'simon@projektinspire.co.tz', 'simon@2025', 'Admin', '2024-10-09 18:30:36', 1, 1, 1),
(5, 'kelvin kimath', 'kelvin@projektinspire.co.tz', 'kelvin@2025', 'Admin', '2024-10-10 19:52:42', 1, 1, 1),
(27, 'Lucy', 'admin@projektinspire.co.tz', 'admin@2025', 'Admin', '2025-05-24 10:09:49', 1, 1, 1),
(30, 'Lwidiko', 'lwidiko@projektinspire.co.tz', 'lwidiko@2025', 'Admin', '2025-05-26 09:17:56', 1, 1, 1),
(31, 'Elisifa', 'reception@projektinspire.co.tz', 'store@2025', 'Admin', '2025-05-26 11:36:56', 1, 1, 1),
(32, 'Kelvin John', 'kelvin.john@projektinspire.co.tz', 'kelvinjohn@2025', 'Admin', '2025-05-28 06:53:54', 0, 0, 0),
(33, 'Gift', 'gift@projektinspire.co.tz', 'gift@2025', 'Admin', '2025-08-06 10:34:53', 0, 0, 0),
(34, 'Grace', 'grace@projektinspire.co.tz', 'grace@2025', 'Admin', '2025-08-06 10:34:53', 0, 0, 0),
(35, 'Mbuke', 'mbuke@projektinspire.co.tz', 'mbuke@2025', 'Admin', '2025-08-06 10:45:42', 0, 0, 0),
(36, 'Dafrosa', 'dafrosa@projektinspire.co.tz', 'dafrosa@2025', 'Admin', '2025-08-06 10:45:42', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`CustomerID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `OrderID` (`OrderID`),
  ADD KEY `ProductID` (`ProductID`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `CustomerID` (`CustomerID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3399;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `CustomerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=794;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`ProductID`) REFERENCES `products` (`ID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`CustomerID`) REFERENCES `customers` (`CustomerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
