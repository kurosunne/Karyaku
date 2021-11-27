-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 27, 2021 at 10:09 AM
-- Server version: 10.4.21-MariaDB
-- PHP Version: 8.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karyaku_db`
--
CREATE DATABASE IF NOT EXISTS `karyaku_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `karyaku_db`;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `discount`
--

DROP TABLE IF EXISTS `discount`;
CREATE TABLE `discount` (
  `discount_id` int(11) NOT NULL,
  `discount_name` varchar(100) NOT NULL,
  `product_id` int(11) NOT NULL,
  `discount_value` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `discount`
--

INSERT INTO `discount` (`discount_id`, `discount_name`, `product_id`, `discount_value`) VALUES
(1, 'Back To School', 1, 20);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

DROP TABLE IF EXISTS `history`;
CREATE TABLE `history` (
  `History_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `qty` int(11) NOT NULL,
  `rate` int(11) DEFAULT 0,
  `review` varchar(500) NOT NULL,
  `order_info` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`History_id`, `product_id`, `user_id`, `date`, `qty`, `rate`, `review`, `order_info`) VALUES
(3, 1, 1, '2021-11-23', 2, 3, 'Mangstab', 'completed'),
(4, 6, 1, '2021-11-26', 2, 0, '', 'menunggu konfirmasi'),
(5, 5, 1, '2021-11-26', 1, 0, '', 'menunggu konfirmasi'),
(6, 1, 1, '2021-11-27', 5, 0, '', 'menunggu konfirmasi'),
(7, 2, 1, '2021-11-27', 5, 0, '', 'menunggu konfirmasi'),
(8, 4, 1, '2021-11-27', 2, 0, '', 'menunggu konfirmasi'),
(9, 3, 1, '2021-11-27', 3, 0, '', 'menunggu konfirmasi');

-- --------------------------------------------------------

--
-- Table structure for table `list_category`
--

DROP TABLE IF EXISTS `list_category`;
CREATE TABLE `list_category` (
  `category_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list_category`
--

INSERT INTO `list_category` (`category_id`, `nama`) VALUES
(1, 'Bolpoin'),
(2, 'Pensil'),
(3, 'Penghapus'),
(4, 'Tipe X'),
(5, 'Penggaris'),
(6, 'Gunting'),
(7, 'Alat Tulis'),
(8, 'Kertas'),
(9, 'Staples'),
(10, 'Alat Kantor'),
(11, 'Map'),
(12, 'Buku'),
(13, 'Cutter'),
(14, 'Sticky Note'),
(15, 'Stempel');

-- --------------------------------------------------------

--
-- Table structure for table `list_product`
--

DROP TABLE IF EXISTS `list_product`;
CREATE TABLE `list_product` (
  `product_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` double NOT NULL,
  `stock` int(11) NOT NULL,
  `description` varchar(400) NOT NULL,
  `brand_name` varchar(100) NOT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list_product`
--

INSERT INTO `list_product` (`product_id`, `name`, `price`, `stock`, `description`, `brand_name`, `image`) VALUES
(1, 'Buku Tulis Sinar Dunia isi 38 Lembar', 26900, 30, 'Buku Tulis Sinar Dunia SIDU Isi 38 lembar\r\n\r\nUkuran buku : 210 x 160 mm\r\n\r\nHarga per pak isi 10 buku\r\n\r\nGambar buku random / acak, tidak bisa pilih gambar', 'Sinar Dunia', 'asset/product/1.jpg'),
(2, 'Map L /clear sleeves folio/f4 map plastik - Biru ', 900, 90, 'Map L plastik untuk penyimpanan kertas dan dokumen\r\n-ukuran folio / f4\r\n-tersedia warna merah,kuning,hijau,biru,putih\r\n-berkualitas dan jaminan harga murah dan jauh di bawah pasaran', 'Jenia', 'asset/product/2.jpg'),
(3, 'Staples / Stapler Hd 10 Kenko', 5700, 29, 'stapler kecil hd 10', 'Kenko', 'asset/product/3.jpg'),
(4, 'Pencil 12 warna Faber Castel', 25000, 20, 'Pensil warna faber castell classic 12 panjang\r\n\r\nAman digunakan untuk anak2\r\n\r\nHarga diatas merupakan harga per set ', 'Faber Castel', 'asset/product/4.jpg'),
(5, 'Cutter Kenko A-300', 5500, 25, 'CUTTER KECIL Kenko A300 ', 'Kenko', 'asset/product/5.jpg'),
(6, 'Date Stamp Joyko D-3', 8500, 71, 'Spesifikasi Produk :\r\nUkuran Produk : 38 x 26 x 80 mm\r\nUkuran Packaging : 43 x 27 x 80 mm', 'Joyko', 'asset/product/6.jpg'),
(7, 'Bolpoin Standard AE7 / Satuan', 1500, 321, 'PULPEN YANG SANGAT BAIK DENGAN HARGA YANG SANGAT TERJANGKAU.', 'Standard', 'asset/product/7.jpg'),
(8, 'Gel Pen My Gel Dong a ', 5250, 200, 'MADE IN KOREA\r\n100% ORIGINAL.\r\nGel pen My Gel, gel pen kwalitas premium,,mata jarum dengan banyak pilihan warna dan ukuran.\r\nTinta gel ini cocok untuk tulisan pada arsip, karena memiliki karakter tahan air, tidak luntur, sehingga sangat ideal juga untuk cek, dokumen hukum, scrapbook, dan apa pun di mana usia catatan begitu penting.\r\nCocok untuk menulis dan menggambar.', 'Dong a', 'asset/product/8.jpg'),
(9, 'TIP-EX KERTAS Joyko  CT-552 12m', 5999, 50, 'TIPEX JOYKO MODEL KERTAS (ROLL)', 'Joyko', 'asset/product/9.jpg'),
(10, 'Kertas HVS A4 | 75 Grm | PaperOne', 36700, 100, '75g/m2 || A4 (210x297mm) 500 sheets\r\nHarga : Rp 38.800/pack\r\n1 DUS = 5 RIM', 'PaperOne', 'asset/product/10.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `list_user`
--

DROP TABLE IF EXISTS `list_user`;
CREATE TABLE `list_user` (
  `users_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(200) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone_number` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `list_user`
--

INSERT INTO `list_user` (`users_id`, `username`, `password`, `name`, `email`, `address`, `phone_number`) VALUES
(1, 'kitsunne', '4a7d1ed414474e4033ac29ccb8653d9b', 'Daniel Gamaliel', 'danielgamalie06@gmail.com', 'Jl Airlangga No 5', '085954519045'),
(2, 'kosmas', 'e00b29d5b34c3f78df09d45921c9ec47', 'Kenny', 'Kenny@gmail.com', 'Jl Durian Runtuh No 1', '08114354051');

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

DROP TABLE IF EXISTS `payment`;
CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `status_code` varchar(3) NOT NULL,
  `status_message` varchar(50) NOT NULL,
  `transaction_id` varchar(100) NOT NULL,
  `order_id` varchar(10) NOT NULL,
  `gross_amount` decimal(20,2) NOT NULL,
  `payment_type` varchar(40) NOT NULL,
  `transaction_time` datetime NOT NULL,
  `transaction_status` varchar(40) NOT NULL,
  `bank` varchar(40) NOT NULL,
  `va_number` varchar(40) NOT NULL,
  `fraud_status` varchar(40) NOT NULL,
  `pdf_url` varchar(200) NOT NULL,
  `finish_redirect_url` varchar(200) NOT NULL,
  `bill_key` varchar(20) NOT NULL,
  `biller_code` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`id`, `status_code`, `status_message`, `transaction_id`, `order_id`, `gross_amount`, `payment_type`, `transaction_time`, `transaction_status`, `bank`, `va_number`, `fraud_status`, `pdf_url`, `finish_redirect_url`, `bill_key`, `biller_code`) VALUES
(0, '201', 'Transaksi sedang diproses', 'e1e7059c-0955-4526-83c2-705ba98a77bb', '200540354', '58300.00', 'bank_transfer', '2021-11-26 23:00:14', 'pending', 'bca', '36466123921', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/5ca2b020-0fde-4faa-83ff-ac2521e3f626/pdf', 'http://example.com?order_id=200540354&status_code=201&transaction_status=pending', '-', '-'),
(0, '201', 'Transaksi sedang diproses', '937335e3-3d9f-4d74-8d9e-3e73957fac15', '633355714', '22500.00', 'bank_transfer', '2021-11-26 23:12:13', 'pending', 'bca', '36466452395', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/3eb674af-7308-4872-ad59-778391af9f52/pdf', 'http://example.com?order_id=633355714&status_code=201&transaction_status=pending', '-', '-'),
(0, '201', 'Transaksi sedang diproses', '92d7da60-6a35-4e57-84f0-388694d366e7', '1849185583', '112100.00', 'bank_transfer', '2021-11-27 14:23:06', 'pending', 'bca', '36466688943', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/8bb3a736-9b97-4901-bea5-853eff5cd514/pdf', 'http://example.com?order_id=1849185583&status_code=201&transaction_status=pending', '-', '-'),
(0, '201', 'Transaksi sedang diproses', '2f4e0f26-5f99-4a67-a414-ffab570414f9', '1984210042', '112100.00', 'bank_transfer', '2021-11-27 14:27:27', 'pending', 'bca', '36466021439', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/4c2b85e6-6747-4c8d-b1eb-2402c26e3b34/pdf', 'http://example.com?order_id=1984210042&status_code=201&transaction_status=pending', '-', '-'),
(0, '201', 'Transaksi sedang diproses', '69db48b2-884f-4191-90d1-33d350f0f744', '1041140852', '67100.00', 'bank_transfer', '2021-11-27 16:03:39', 'pending', 'bca', '36466422500', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/4f789071-22b4-471f-9fe7-ddacabaa979e/pdf', 'http://example.com?order_id=1041140852&status_code=201&transaction_status=pending', '-', '-');

-- --------------------------------------------------------

--
-- Table structure for table `product_category`
--

DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
  `product_category_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `product_category`
--

INSERT INTO `product_category` (`product_category_id`, `product_id`, `category_id`) VALUES
(9, 1, 4),
(10, 1, 7),
(11, 2, 1),
(12, 2, 8),
(13, 3, 1),
(14, 3, 12),
(15, 4, 2),
(16, 4, 11),
(17, 5, 1),
(18, 5, 5),
(19, 6, 1),
(20, 6, 13),
(21, 7, 1),
(22, 7, 2),
(23, 7, 3),
(24, 8, 1),
(25, 8, 2),
(26, 8, 3),
(27, 9, 1),
(28, 9, 2),
(29, 9, 15),
(30, 10, 1),
(31, 10, 7);

-- --------------------------------------------------------

--
-- Table structure for table `wishlist`
--

DROP TABLE IF EXISTS `wishlist`;
CREATE TABLE `wishlist` (
  `wishlist_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `wishlist`
--

INSERT INTO `wishlist` (`wishlist_id`, `product_id`, `user_id`) VALUES
(7, 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`discount_id`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`History_id`);

--
-- Indexes for table `list_category`
--
ALTER TABLE `list_category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `list_product`
--
ALTER TABLE `list_product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `list_user`
--
ALTER TABLE `list_user`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `product_category`
--
ALTER TABLE `product_category`
  ADD PRIMARY KEY (`product_category_id`);

--
-- Indexes for table `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`wishlist_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `History_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `list_category`
--
ALTER TABLE `list_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `list_product`
--
ALTER TABLE `list_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `list_user`
--
ALTER TABLE `list_user`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
