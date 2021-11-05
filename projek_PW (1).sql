-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 05, 2021 at 04:08 PM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `projek_PW`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang_category`
--

CREATE TABLE `barang_category` (
  `product_id` varchar(5) NOT NULL,
  `category_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `list_barang`
--

CREATE TABLE `list_barang` (
  `num_id` int(11) NOT NULL,
  `product_id` varchar(5) NOT NULL,
  `product_name` varchar(50) NOT NULL,
  `product_price` int(11) NOT NULL,
  `product_description` int(250) NOT NULL,
  `product_brand` varchar(50) NOT NULL,
  `product_image_url` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `list_category`
--

CREATE TABLE `list_category` (
  `category_num_id` int(11) NOT NULL,
  `category_id` varchar(5) NOT NULL,
  `category_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list_category`
--

INSERT INTO `list_category` (`category_num_id`, `category_id`, `category_name`) VALUES
(1, 'BU001', 'Buku');

-- --------------------------------------------------------

--
-- Table structure for table `list_history`
--

CREATE TABLE `list_history` (
  `history_num_id` int(11) NOT NULL,
  `history_id` varchar(5) NOT NULL,
  `user_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `list_user`
--

CREATE TABLE `list_user` (
  `user_code` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(500) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `place_residence` varchar(250) NOT NULL,
  `phone_number` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `list_wishlist`
--

CREATE TABLE `list_wishlist` (
  `wishlist_num_id` int(11) NOT NULL,
  `wishlist_id` varchar(5) NOT NULL,
  `id_user` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `product_history`
--

CREATE TABLE `product_history` (
  `history_code` varchar(5) NOT NULL,
  `product_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `wishlist_items`
--

CREATE TABLE `wishlist_items` (
  `product_id` varchar(5) NOT NULL,
  `wishlist_id` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang_category`
--
ALTER TABLE `barang_category`
  ADD KEY `category_id` (`category_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `list_barang`
--
ALTER TABLE `list_barang`
  ADD PRIMARY KEY (`product_id`),
  ADD KEY `index_num_product_1` (`num_id`);

--
-- Indexes for table `list_category`
--
ALTER TABLE `list_category`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `index_num_1_category` (`category_num_id`);

--
-- Indexes for table `list_history`
--
ALTER TABLE `list_history`
  ADD PRIMARY KEY (`history_id`),
  ADD KEY `history_num_id` (`history_num_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `list_user`
--
ALTER TABLE `list_user`
  ADD PRIMARY KEY (`user_code`);

--
-- Indexes for table `list_wishlist`
--
ALTER TABLE `list_wishlist`
  ADD PRIMARY KEY (`wishlist_id`),
  ADD KEY `wishlist_num_id` (`wishlist_num_id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `product_history`
--
ALTER TABLE `product_history`
  ADD PRIMARY KEY (`history_code`,`product_code`),
  ADD KEY `history_code` (`history_code`),
  ADD KEY `product_code` (`product_code`);

--
-- Indexes for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD PRIMARY KEY (`product_id`,`wishlist_id`),
  ADD KEY `fkWishlist` (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list_category`
--
ALTER TABLE `list_category`
  MODIFY `category_num_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `list_history`
--
ALTER TABLE `list_history`
  MODIFY `history_num_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `list_wishlist`
--
ALTER TABLE `list_wishlist`
  MODIFY `wishlist_num_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang_category`
--
ALTER TABLE `barang_category`
  ADD CONSTRAINT `fkBarang` FOREIGN KEY (`product_id`) REFERENCES `list_barang` (`product_id`),
  ADD CONSTRAINT `fkKategori` FOREIGN KEY (`category_id`) REFERENCES `list_category` (`category_id`);

--
-- Constraints for table `list_history`
--
ALTER TABLE `list_history`
  ADD CONSTRAINT `fkHistory1` FOREIGN KEY (`user_id`) REFERENCES `list_user` (`user_code`);

--
-- Constraints for table `list_wishlist`
--
ALTER TABLE `list_wishlist`
  ADD CONSTRAINT `fkWishlist1` FOREIGN KEY (`id_user`) REFERENCES `list_user` (`user_code`);

--
-- Constraints for table `product_history`
--
ALTER TABLE `product_history`
  ADD CONSTRAINT `fkHistory` FOREIGN KEY (`history_code`) REFERENCES `list_history` (`history_id`),
  ADD CONSTRAINT `fkHistory_barang` FOREIGN KEY (`product_code`) REFERENCES `list_barang` (`product_id`);

--
-- Constraints for table `wishlist_items`
--
ALTER TABLE `wishlist_items`
  ADD CONSTRAINT `fkProduct` FOREIGN KEY (`product_id`) REFERENCES `list_barang` (`product_id`),
  ADD CONSTRAINT `fkWishlist` FOREIGN KEY (`wishlist_id`) REFERENCES `list_wishlist` (`wishlist_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
