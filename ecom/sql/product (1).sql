-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 20, 2022 at 07:13 AM
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
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `create_date` date NOT NULL,
  `model_no` varchar(100) NOT NULL,
  `brand` varchar(200) NOT NULL,
  `category` int(11) NOT NULL,
  `sub_category` int(11) NOT NULL,
  `cat_name` varchar(100) NOT NULL,
  `sub_name` varchar(100) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `our_price` float NOT NULL,
  `price_percentage` varchar(100) NOT NULL,
  `status` varchar(100) NOT NULL,
  `used` enum('used','notused') NOT NULL DEFAULT 'notused',
  `quantity` int(11) NOT NULL,
  `country` int(11) NOT NULL,
  `remark` text DEFAULT NULL,
  `prod_desc` blob NOT NULL,
  `actual_price` float NOT NULL,
  `ship_id` int(11) DEFAULT NULL,
  `attr_id` varchar(100) NOT NULL,
  `taxt_id` int(11) NOT NULL,
  `p_status` enum('active','inactive') NOT NULL DEFAULT 'active',
  `best_seller` enum('yes','no') NOT NULL DEFAULT 'no',
  `featured` enum('yes','no') NOT NULL DEFAULT 'no',
  `shipp_type` varchar(100) NOT NULL,
  `shipp_id` int(11) NOT NULL,
  `shipp_name` varchar(100) NOT NULL,
  `shipp_amount` float NOT NULL,
  `feature1_title` varchar(100) NOT NULL,
  `feature2_title` varchar(100) NOT NULL,
  `feature3_title` varchar(100) NOT NULL,
  `feature4_title` varchar(100) NOT NULL,
  `feature5_title` varchar(100) NOT NULL,
  `feature1_desc` varchar(100) NOT NULL,
  `feature2_desc` varchar(100) NOT NULL,
  `feature3_desc` varchar(100) NOT NULL,
  `feature4_desc` varchar(100) NOT NULL,
  `feature5_desc` varchar(100) NOT NULL,
  `youtube_link` varchar(200) DEFAULT NULL,
  `deal_date` datetime DEFAULT NULL,
  `deal_price` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `create_date`, `model_no`, `brand`, `category`, `sub_category`, `cat_name`, `sub_name`, `product_name`, `our_price`, `price_percentage`, `status`, `used`, `quantity`, `country`, `remark`, `prod_desc`, `actual_price`, `ship_id`, `attr_id`, `taxt_id`, `p_status`, `best_seller`, `featured`, `shipp_type`, `shipp_id`, `shipp_name`, `shipp_amount`, `feature1_title`, `feature2_title`, `feature3_title`, `feature4_title`, `feature5_title`, `feature1_desc`, `feature2_desc`, `feature3_desc`, `feature4_desc`, `feature5_desc`, `youtube_link`, `deal_date`, `deal_price`) VALUES
(1, '2022-07-12', '', '', 0, 0, '', '', '', 0, '', '', 'notused', 0, 0, NULL, '', 0, NULL, '', 0, 'active', 'no', 'no', '', 0, '', 0, '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL),
(2, '2022-07-12', '', '', 0, 0, '', '', '', 0, '', '', 'notused', 0, 0, NULL, '', 0, NULL, '', 0, 'active', 'no', 'no', '', 0, '', 0, '', '', '', '', '', '', '', '', '', '', NULL, NULL, NULL),
(3, '2022-07-13', '12', '', 3, 0, '', '', 'pro1', 123, '', 'Sold', 'used', 1, 101, 'aaaaaaaaaaaa', 0x5048412b6332526b5a47526b5a47526b5a4751384c33412b, 233, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, '', 0, 'ft', 'ft', 'ft', 'ft', 'ft', 'fd', 'fd', 'fd', 'fd', 'fd', NULL, NULL, NULL),
(4, '2022-07-13', '13', '', 3, 0, '', '', 'pro1', 123, '', 'Sold', 'used', 1, 101, 'aaaaaaaaaaaa', 0x5048412b6332526b5a47526b5a47526b5a4751384c33412b, 233, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, '', 0, 'ft', 'ft', 'ft', 'ft', 'ft', 'fd', 'fd', 'fd', 'fd', 'fd', 'zdcx.vv', NULL, NULL),
(5, '2022-07-13', '14', 'qw', 3, 0, '', '', 'pro1', 123, '', 'Not sold', 'used', 1, 101, 'aaaaaaaaaaaa', 0x5048412b6332526b5a47526b5a47526b5a4751384c33412b, 233, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, '', 0, 'ft', 'ft', 'ft', 'ft', 'ft', 'fd', 'fd', 'fd', 'fd', 'fd', '', NULL, NULL),
(7, '2022-07-19', '16', 'zxv', 3, 0, '', '', 'zxzx', 0, '', 'Not sold', 'notused', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'no', 'no', 'template', 3, '', 0, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcd', 'dshkbkdcb', '1970-01-01 00:00:00', '200'),
(8, '2022-07-18', '17', 'zxv', 3, 0, '', '', 'zxzx', 0, '', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, '', 0, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'xcxxxx', '1970-01-01 00:00:00', '200'),
(9, '2022-07-18', '18', 'zxv', 3, 0, 'Animals', 'Lion', 'zxzx', 0, '', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, '', 0, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'fdbvcx', '1970-01-01 00:00:00', '200'),
(10, '2022-07-18', '19', 'zxv', 3, 0, '', 'Lion', 'zxzx', 0, '', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'manual', 2, 'shipppppp', 122, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'cv', '1970-01-01 00:00:00', '200'),
(11, '2022-07-18', '20', 'zxv', 2, 0, '', 'Crow', 'zxzx', 0, '10', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'manual', 2, 'shp', 122, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'cx', '1970-01-01 00:00:00', '200'),
(12, '2022-07-18', '21', 'zxvas', 3, 0, '', 'Tiger', 'zxzxsa', 0, '10', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'manual', 2, 'shp', 122, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'cv', '1970-01-01 00:00:00', '200'),
(13, '2022-07-18', '22', 'zxvas', 2, 0, '', 'Crow', 'zxzxsa', 0, '10', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, 'shp', 122, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'vhg', '1970-01-01 00:00:00', '200'),
(14, '2022-07-18', '23', 'zxvas', 2, 0, 'Birds', 'Crow', 'zxzxsa', 0, '10', 'Not sold', 'used', 1, 101, 'jnnlo', 0x5048412b5a475a6e646d646f5043397750673d3d, 14, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 2, 'shp', 122, 'ca', 'vc', 'sd', 'cx', 'DSd', 'xz', 'we', 'zx', 'bvx', 'vcdc', 'jk', '1970-01-01 00:00:00', '200'),
(15, '2022-07-18', '24', 'xzcawd', 3, 0, 'Animals', 'Lion', 'cxz', 0, '4', 'Sold', 'used', 1, 101, 'xzczxz', 0x5048412b6332466a6547466b5043397750673d3d, 234, NULL, '15', 1, 'active', 'no', 'no', 'template', 3, '', 0, 'xcx', 'cxes', 'xdzc', 'sd', 'dfz', 'xc', 'acd', 'sds', 'sd', 'sxdb', 'adade.cs', '1970-01-01 00:00:00', '230'),
(16, '2022-07-18', '25', 'xzcawd', 3, 0, 'Animals', 'Lion', 'cxz', 0, '4', 'Not sold', 'used', 1, 101, 'dsaadw', 0x5048412b6332466a6547466b5043397750673d3d, 234, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 3, '', 0, 'xcx', 'cxes', 'xdzc', 'sd', 'dfz', 'xc', 'acd', 'sds', 'sd', 'sxdb', 'dascasd', '1970-01-01 00:00:00', '230'),
(17, '2022-07-19', '26', 'mi', 3, 0, 'Animals', 'Lion', 'note 4', 555, '1', 'Not sold', 'notused', 1, 101, '', 0x5048412b646d4e6a596e59384c33412b, 0, NULL, '15', 1, 'active', 'no', 'no', 'template', 3, '', 0, 'bc', 'b', 'bv', 'vcd', 'cvbbvc', 'bvbv', 'b', 'vbc', 'vvbb', 'bvc', 'gb', '1970-01-01 00:00:00', '666'),
(18, '2022-07-19', 'q', 'q', 3, 0, 'Animals', 'Tiger', 'q', 2, '1', 'Sold', 'used', 3, 6, '', 0x5048412b5a6e59384c33412b, 0, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 3, '', 0, 'sd', 'ds', 'xce', 'eas', 'sdg', 'a', 'cx', 'xc', 'asd', 'xca', 'bbcv', '1970-01-01 00:00:00', '1'),
(19, '2022-07-19', '27', 'hn', 3, 0, 'Animals', 'Tiger', 'cxc', 66, '1', 'Sold', 'used', 4, 101, '', 0x5048412b61327476623239735043397750673d3d, 0, NULL, '15', 2, 'active', 'yes', 'yes', 'template', 2, '', 0, 'bv', 'bv', 'v', 'd', 'c', 'vb', 'vb', 'dfa', 'afc', 'xc', 'xcgff', '1970-01-01 00:00:00', '55'),
(20, '2022-07-19', '29', 'dz', 3, 0, 'Animals', 'Tiger', 'jghvdf', 21, '1', 'Not sold', 'used', 12, 3, 'asdf', 0x5048412b61327874625778725043397750673d3d, 0, NULL, '15', 1, 'active', 'yes', 'no', 'template', 3, '', 0, 'mk', 'vz', 'cz', 'bdf', 'ssdd', 'nbb', 'vc', 'xc', 'xs', 'SSd', 'vczzzzzz', '1970-01-01 00:00:00', '12'),
(21, '2022-07-19', '28', 'xca', 3, 4, 'Animals', 'Tiger', 'sc', 33, '2', 'Sold', 'used', 2, 3, 'bbcb', 0x5048412b626d5a6b5a6a77766344343d, 0, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 3, '', 0, 'vfd', 'sd', 'sdf', 'wedd', 'sda', 'fdv', 'dsw', 'sdf', 'aaa', 'fff', 'cvc', '1970-01-01 00:00:00', '34'),
(22, '2022-07-19', '30', 'sds', 2, 2, 'Birds', 'Crow', 'asdaa', 22, '1', 'Sold', 'used', 11, 4, 'dffsd', 0x5048412b596d356b5a6d63384c33412b, 12, NULL, '15', 1, 'active', 'yes', 'yes', 'template', 3, '', 0, 'fgdf', 'fsa', 'dfs', 'agg', 'gh', 'fgd', 'erse', 'sda', 'fgd', 'fdg', 'dfdad', '1970-01-01 00:00:00', '123'),
(23, '2022-07-19', 'dsf', 'dfs', 3, 4, 'Animals', 'Tiger', 'ds', 111, '1', 'Sold', 'used', 1, 10, 'dsd', 0x5048412b656e686a654477766344343d, 123, NULL, '15', 1, 'active', 'yes', 'no', 'template', 3, '', 0, 'dfs', 'df', 'a', 'qwe', 'dsf', 'df', 'f', 'cv', 'dvs', 'sdf', 'sdfvca', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
