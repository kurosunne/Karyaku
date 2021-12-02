-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 02, 2021 at 03:32 PM
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
(1, 3, 1, '2021-12-02', 3, 0, '', 'menunggu konfirmasi'),
(2, 2, 1, '2021-12-02', 3, 0, '', 'menunggu konfirmasi'),
(3, 7, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(4, 10, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(5, 4, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(6, 6, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi');

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
(8, 'Alat Kantor'),
(9, 'Staples'),
(10, 'Kertas'),
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
(1, 'Buku Tulis Sinar Dunia isi 38 Lembar', 26900, 30, 'Buku Tulis Sinar Dunia isi 38 (SIDU) merupakan buku tulis dengan kualitas kertas yang bagus, kertas tebal, dan tidak mudah robek. Tampilan gambar menarik. Back to school with Sinar Dunia.\r\n\r\nSpesifikasi:\r\n- Dimensi : 21X16cm\r\n- Satuan Kemasan : Pak\r\n- Isi Perkemasan : 10 PCS\r\n- Isi Perbiji : 38 lembar', 'Sinar Dunia', 'asset/product/1.jpg'),
(2, 'Map L /clear sleeves folio/f4 map plastik - Biru ', 900, 90, 'Map L plastik untuk penyimpanan kertas dan dokumen\r\n-ukuran folio / f4\r\n-tersedia warna merah,kuning,hijau,biru,putih\r\n-berkualitas dan jaminan harga murah dan jauh di bawah pasaran\r\n-stok banyak dan selalu ready kartonan pun tersedia', 'Jenia', 'asset/product/2.jpg'),
(3, 'Staples / Stapler Hd 10 Kenko', 5700, 29, 'stapler kecil hd 10', 'Kenko', 'asset/product/3.jpg'),
(4, 'Pencil 12 warna Faber Castel', 25000, 20, 'Aman untuk anak-anak\r\nTidak beracun -warna-warna yang cemerlang\r\nSistem SV Bonding, ujung pensil tidak mudah patah', 'Faber Castel', 'asset/product/4.jpg'),
(5, 'Cutter Kenko A-300', 5500, 70, 'CUTTER KECIL Kenko A300', 'Kenko', 'asset/product/5.jpg'),
(6, 'Date Stamp Joyko D-3', 8500, 125, 'Stempel Joyko D-3\r\n- Stempel Tanggal Bulan Tahun\r\n- Tinggi hasil stempel : 4mm\r\n- 1 Warna\r\n', 'Joyko', 'asset/product/6.jpg'),
(7, 'Bolpoin Standard AE7 / Satuan', 1500, 321, 'Bolpoin yang sanagt baik dengan harga yang sangat terjangkau', 'Standard', 'asset/product/7.jpg'),
(8, 'Gel Pen My Gel Dong a ', 5250, 200, 'MADE IN KOREA\r\n100% ORIGINAL.\r\nGel pen My Gel, gel pen kwalitas premium,,mata jarum dengan banyak pilihan warna dan ukuran.\r\nTinta gel ini cocok untuk tulisan pada arsip, karena memiliki karakter tahan air, tidak luntur, sehingga sangat ideal juga untuk cek, dokumen hukum, scrapbook, dan apa pun di mana usia catatan begitu penting.\r\nCocok untuk menulis dan menggambar.', 'Dong a', 'asset/product/8.jpg'),
(9, 'TIP-EX KERTAS Joyko  CT-552 12m', 6000, 50, 'TIPEX JOYKO MODEL KERTAS (ROLL) 12m', 'Joyko', 'asset/product/9.jpg'),
(10, 'Kertas HVS A4 | 75 Grm | PaperOne', 37000, 300, 'kertas HVS merk PaperOne\r\n75g/m2 A4 210x297mm 500 sheets', 'PaperOne', 'asset/product/10.jpg'),
(11, 'Sticky Notes 9 Warna TT-225', 4500, 67, 'Sticky Notes 9 Warna TT-225', '-', 'asset/product/11.jpg'),
(12, 'Deli Penggaris 30 cm', 4500, 70, 'Deli Penggaris 30 cm, 12 inch tidak mudah patah & Tahan Lama EH654', 'Deli', 'asset/product/12.jpg'),
(13, 'penggaris elastis deli', 8700, 122, 'Material bahan Eco-PVC\r\npengukuran yang akurat\r\nMudah digenggam\r\nLentur\r\nBahan transparan untuk pengukuran yang jelas\r\npanjang : 30cm', 'deli', 'asset/product/13.jpg'),
(14, 'Bolpoin Pulpen Snowman V3 Pen gel 0.5mm', 2100, 84, 'Spesifikasi Produk:\r\n- Merk: Snowman V3\r\n- Jenis: gel pen - Hitam 0.5mm\r\n- Isi: 12 Pcs / Pack\r\n- Keterangan: Kualitas Super & Bagus', 'Snowman', 'asset/product/14.jpg');

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
(1, 'kitsunne', '4a7d1ed414474e4033ac29ccb8653d9b', 'Daniel', 'danielgamalie06@gmail.com', 'Jl Airlangga No 5', '085954519045');

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
(1, '201', 'Transaksi sedang diproses', '79b8734b-5ac9-4a93-b5e2-0164a40fe520', '547470470', '17100.00', 'bank_transfer', '2021-12-02 21:00:36', 'pending', 'bca', '36466899796', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/0414ec8f-6082-4cc2-866a-a808fc160d4c/pdf', 'http://example.com?order_id=547470470&status_code=201&transaction_status=pending', '-', '-'),
(2, '201', 'Transaksi sedang diproses', '09407253-14b5-4cd4-9c6b-69792baddb2b', '510543012', '17100.00', 'bank_transfer', '2021-12-02 21:02:26', 'pending', 'bca', '36466172545', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/02261e28-6a3e-4bf7-9b36-9dce18de4b09/pdf', 'http://example.com?order_id=510543012&status_code=201&transaction_status=pending', '-', '-'),
(3, '201', 'Transaksi sedang diproses', '09407253-14b5-4cd4-9c6b-69792baddb2b', '510543012', '17100.00', 'bank_transfer', '2021-12-02 21:02:26', 'pending', 'bca', '36466172545', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/02261e28-6a3e-4bf7-9b36-9dce18de4b09/pdf', 'http://example.com?order_id=510543012&status_code=201&transaction_status=pending', '-', '-'),
(4, '201', 'Transaksi sedang diproses', '8ebfe8b7-4998-4f3d-a7bf-c18a96911fda', '1913827662', '41200.00', 'bank_transfer', '2021-12-02 21:03:45', 'pending', 'bca', '36466118684', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/b753a647-6dab-4488-a1de-abd346b6a024/pdf', 'http://example.com?order_id=1913827662&status_code=201&transaction_status=pending', '-', '-'),
(5, '201', 'Transaksi sedang diproses', '586a72b1-2890-400d-8ef6-fdc8fe765585', '314159312', '33500.00', 'bank_transfer', '2021-12-02 21:04:09', 'pending', 'bca', '36466591375', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/0ea99c3e-07b6-4a28-bcf5-e827e36e386d/pdf', 'http://example.com?order_id=314159312&status_code=201&transaction_status=pending', '-', '-');

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
(1, 1, 8),
(2, 1, 12),
(3, 2, 8),
(4, 2, 11),
(5, 3, 8),
(6, 3, 9),
(7, 4, 2),
(8, 4, 7),
(9, 5, 8),
(10, 5, 13),
(11, 6, 8),
(12, 6, 15),
(13, 7, 1),
(14, 7, 7),
(15, 7, 8),
(16, 8, 1),
(17, 8, 7),
(18, 8, 8),
(19, 9, 4),
(20, 9, 7),
(21, 9, 8),
(22, 10, 10),
(23, 11, 14),
(24, 12, 5),
(25, 12, 7),
(26, 12, 8),
(27, 13, 5),
(28, 13, 7),
(29, 14, 1),
(30, 14, 7),
(31, 14, 8);

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
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `History_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `list_category`
--
ALTER TABLE `list_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `list_product`
--
ALTER TABLE `list_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `list_user`
--
ALTER TABLE `list_user`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
