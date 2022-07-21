-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2022 at 07:17 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce`
--

-- --------------------------------------------------------

--
-- Table structure for table `left_menu`
--

CREATE TABLE `left_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `url` text NOT NULL,
  `icon` varchar(50) NOT NULL,
  `menu_order` int(11) NOT NULL,
  `menu_table` varchar(50) NOT NULL,
  `active_file` text NOT NULL,
  `menu_type` varchar(100) NOT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `show_home` enum('yes','no') NOT NULL DEFAULT 'yes',
  `color` varchar(100) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `left_menu`
--

INSERT INTO `left_menu` (`id`, `name`, `url`, `icon`, `menu_order`, `menu_table`, `active_file`, `menu_type`, `menu_id`, `status`, `show_home`, `color`) VALUES
(2, 'Manage Pages', 'list-page', 'file-o', 5, 'pages', 'list-page,add-page', 'sub-menu', 7, 'active', 'no', '#E91E63'),
(3, 'Manage News', 'list-news', 'newspaper-o', 12, 'news', 'list-news,list-news/search,add-news,edit-news', 'menu', 0, 'inactive', 'yes', '#3498DB'),
(4, 'Admin Users', 'list-adminusers', 'users', 15, 'admin', 'list-adminusers', 'menu', 0, 'active', 'yes', 'blue'),
(6, 'Dashboard', 'home', 'th-large', 1, '232', 'home', 'menu', 0, 'active', 'no', 'green'),
(7, 'Manage Content', '', 'edit', 13, '', 'list-page,add-page', 'menu', 0, 'inactive', 'no', ''),
(9, 'Manage Masters', '', 'folder', 3, '', 'category,sub-category,tax,attribute,attribute-values,shipping-charge', 'menu', 0, 'active', 'no', ''),
(31, 'Manage Attributes', 'attribute', 'file-o', 7, 'attributes', 'attribute', 'sub-menu', 9, 'active', 'no', ''),
(32, 'Home Sliders', 'sliders', 'star', 2, 'slider', 'sliders', 'menu', 0, 'active', 'no', 'blue'),
(12, 'Category', 'category', 'star', 3, 'category', 'category', 'sub-menu', 9, 'active', 'no', ''),
(28, 'Sub Category', 'sub-category', 'file-o', 4, 'sub_category', 'sub-category', 'sub-menu', 9, 'active', 'no', ''),
(29, 'Manage Tax', 'tax', 'file-o', 6, 'tax', 'tax', 'sub-menu', 9, 'active', 'no', ''),
(30, 'Manage Shipping Charge', 'shipping-charge', 'file-o', 8, 'shipping_charge', 'shipping-charge', 'sub-menu', 9, 'active', 'no', ''),
(33, 'Manage Product', 'list-product', 'cart-plus', 4, 'product', 'list-product,add-product,more-details', 'menu', 0, 'active', 'yes', '#E91E63');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `left_menu`
--
ALTER TABLE `left_menu`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `left_menu`
--
ALTER TABLE `left_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
