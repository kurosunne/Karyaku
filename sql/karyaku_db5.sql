-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 12, 2021 at 07:31 PM
-- Server version: 10.2.41-MariaDB-log-cll-lve
-- PHP Version: 7.3.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `karyakum_karyaku_db`
--
CREATE DATABASE IF NOT EXISTS `karyaku_db` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
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
(1, 'Back To School 2021', 8, 10);

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
(1, 3, 1, '2021-12-02', 3, 0, '', 'sedang dikirim'),
(2, 2, 1, '2021-12-02', 3, 4, 'Kualitas Barang Baik ', 'completed'),
(3, 7, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(4, 10, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(5, 4, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(6, 6, 1, '2021-12-02', 1, 0, '', 'menunggu konfirmasi'),
(7, 82, 1, '2021-12-11', 2, 0, '', 'menunggu konfirmasi'),
(8, 28, 1, '2021-12-11', 1, 0, '', 'menunggu konfirmasi'),
(9, 91, 3, '2021-12-11', 3, 4, 'Barang sudah diterima. Sesuai dengan deskripsi.', 'completed'),
(10, 36, 3, '2021-12-11', 2, 3, 'Kualitas bagus cuma harganya mahal untuk 2 bolpen.', 'completed');

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
(15, 'Stempel'),
(16, 'Highlighter'),
(17, 'Oil & Dry Pastel'),
(18, 'Amplop'),
(19, 'Spidol Warna');

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
(2, 'Map L /clear sleeves folio/f4 map plastik - Biru ', 900, 87, 'Map L plastik untuk penyimpanan kertas dan dokumen\r\n-ukuran folio / f4\r\n-tersedia warna merah,kuning,hijau,biru,putih\r\n-berkualitas dan jaminan harga murah dan jauh di bawah pasaran\r\n-stok banyak dan selalu ready kartonan pun tersedia', 'Jenia', 'asset/product/2.jpg'),
(3, 'Staples / Stapler Hd 10 Kenko', 5700, 26, 'stapler kecil hd 10', 'Kenko', 'asset/product/3.jpg'),
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
(14, 'Bolpoin Pulpen Snowman V3 Pen gel 0.5mm', 2100, 84, 'Spesifikasi Produk:\r\n- Merk: Snowman V3\r\n- Jenis: gel pen - Hitam 0.5mm\r\n- Isi: 12 Pcs / Pack\r\n- Keterangan: Kualitas Super & Bagus', 'Snowman', 'asset/product/14.jpg'),
(15, 'Spidol Snowman Permanent Marker', 5500, 300, 'Spidol Snowman cocok untuk menulis di papan tulis atau di berbagai bidang lainya dengan merk yang sudah lama terkenal dijamin kualitasnya.\r\n', 'Snowman', 'asset/product/15.jpg'),
(16, 'Stabillo Boss Original (1 pack)', 80000, 50, 'Spesifikasi Produk :\r\n- Merk : Stabilo Boss\r\n- Warna : 8 Warna\r\n- 1 Pak = 8 Pcs', 'Stabillo Boss', 'asset/product/16.png'),
(17, 'Buku Tulis Kwarto 100lembar', 7000, 100, 'Buku Tulis Kwarto Hard Cover. Motif random', 'Clairefontaine', 'asset/product/17.png'),
(20, 'Kalkulator Casio 12digit', 130000, 50, 'Kalkulator Casio DJ-120D Plus merupakan kalkulator 12 digit yang memiliki fungsi check 300 langkah dan dengan tampilan layar besar sehingga sangat mudah dalam penggunaannya. Menggunakan 2 tenaga yaitu solar dan baterai.', 'CASIO', 'asset/product/20.png'),
(21, 'Lem Kertas Glue Stick', 6300, 100, 'Lem Kertas berbentuk stik, lebih simpel dan mudah dipakai.', 'Deli Glue Stick', 'asset/product/21.png'),
(22, 'Penghapus Pensil Mini Softy', 4400, 200, 'Penghapus serbaguna Maped, dapat digunakan untuk menghapus bersih segala macam pensil warna dan pensil Maped. Tekstur permukaan lembut dengan ampas penghapus yang rapi.', 'Maped', 'asset/product/22.png'),
(23, 'Rautan Pensil MIni', 2800, 100, '- Mata pisau lebih tajam dan tahan lama\n- Dapat digunakan untuk pensil standar dengan diameter 8 mm', 'Joyko', 'asset/product/23.png'),
(24, 'Penghapus 2in1', 13500, 200, 'WARNA BIRU UNTUK MENGHAPUS TINTA BOLPEN ,WARNA MERAH UNTUK TINTA PENSIL', 'Pelikan', 'asset/product/24.png'),
(25, 'Highlighter kuning', 7000, 200, 'Standard highlighter dengan warna yang cerah dan terang', 'Artline660', 'asset/product/25.png'),
(26, 'Stapler Metal no.10', 255000, 30, 'Stapler No. 10 metal Leitz \"Nexxt Wow\"', 'Leitz', 'asset/product/26.png'),
(27, 'Stapler F18 - Merah', 135000, 50, 'Metal Body with plastic casing, quick loading mechanism.\r\n', 'Rapid', 'asset/product/27.png'),
(28, 'Map Leitz Elasticated folder WOW 4599 4599-00-23 A4 Biru', 76000, 100, 'PP berkualitas tinggi dalam warna WOW yang cemerlang. Ideal untuk pengarsipan dokumen dan dokumen harian.\r\n', 'Leitz', 'asset/product/28.png'),
(29, 'Gunting Biru Sedang', 12000, 200, 'Kegunaan untuk memotong kertas,kain,plastik,dll.\r\nKualitas Terbaik dengan bahan Stainless Steel yang kuat dan Handgrip anti slip menjadikan anda lincah dalam memotong.\r\n', 'Kodei', 'asset/product/29.png'),
(30, 'Paper Clips DELI Warna warni 33mm - E39716 (1 box)', 3900, 300, 'Isi : 100 Pcs\r\nMaterial Nikel plating untuk melindungi klip terhadap korosi\r\nuntuk memudahkan penyimpanan\r\nPermukaan halus mencegah robekan\r\n', 'DELI', 'asset/product/30.png'),
(32, 'Isi staples kangaro no 10', 30000, 500, '1 pak isi 20 kotak kecil', 'Kangaro', 'asset/product/31.png'),
(33, 'Isi staples kangaro no 10', 30000, 500, '1 pak isi 20 kotak kecil', 'Kangaro', 'asset/product/33.webp'),
(34, 'Pensil warna Cuya - 48 warna', 22000, 200, 'Pensil warna Cuya 48 warna cerah. Bentuk heksagonal supaya nyaman saat digenggam.', 'Cuya', 'asset/product/34.png'),
(35, 'Stic â€“ Colorstix Sketch Pens Set (12 +1 Warna)', 33000, 200, 'Tidak beracun\r\nTinta yang bisa dicuci\r\nTutup pengaman berventilasi\r\nAneka Warna', 'Stic', 'asset/product/35.png'),
(36, 'Gift Bolpoin isi 2', 143000, 28, 'Bolpoin isi 2 dalam case yang dapat dijadikan hadiah istimewa.', 'Agift', 'asset/product/36.png'),
(37, 'Sharpie tinta permanen (1 set = 5 warna)', 45000, 100, '- Tinta permanen\r\n- Tidak mudah pudar dan tahan air\r\n- Cepat kering dan berlisensi tidak beracun\r\n- Bisa digunakan untuk menulis di permukaan kertas, plastik, kaca, dan sebagainya\r\n- Bisa untuk coret-coret di atas foto polaroid/instax', 'Sharpie', 'asset/product/37.png'),
(38, 'Tempat Pensil Meja Kotak - Merah Muda', 12000, 50, 'Model kotak - besi motif', 'V-Tec', 'asset/product/38.png'),
(39, 'Clipboard Plastics 8815 - folio size plastic Material', 22000, 200, 'Terbuat dari bahan plastik, kuat dan tidak mudah pecah. ', 'Bantex', 'asset/product/39.png'),
(40, 'Binder Clips No 260 Kenko / Clip Hitam / Klip Jepit Kertas Besar (1 box = 12 pcs)', 14300, 500, 'Binder Clips merk kenko terbuat dari bahan besi yg berkualitas, kuat, tidak mudah karat dan tahan lama. memiliki 6 varian ukuran no. 105, 107, 111, 155, 200, 260. biasa di gunakan untuk menjepit kertas, berkas file laporan, agar tidak lepas dan menjadi 1 kesatuan tanpa staples atau merusak kertas tersebut. sangat umum digunakan dikalangan kantor, sekolah dan toko.\r\n', 'Kenko', 'asset/product/40.png'),
(41, 'PELIKAN CRAYON CAT OIL PASTEL 2296-12 WRN ROUND', 26000, 100, 'crayon merk pelikan, ada 12 pilihan warna.', 'Pelikan', 'asset/product/41.png'),
(42, 'Cutter besar merah L500 Joyko bonus isi cutter L150', 14000, 100, 'Beli 1 pc bonus isi cutter 1 tube (5 lembar pisau)\r\nTerdapat pengunci putar agar pisau mudah turun saat digunakan maupun saat tidak digunakan.\r\nDisertai pemotong mata pisau.', 'Joyko', 'asset/product/42.png'),
(43, 'Post It 3M 670 5AN Warna Warni', 33000, 200, '1 pak terdapat 5 warna:\r\n- Fireball Fuschia\r\n- Neon Orange\r\n- Yellow\r\n- Neon Green\r\n- Electric Blue\r\n\r\n100 Sheets/Color\r\nSize = 0.5\"x2\"', 'Post-it', 'asset/product/43.png'),
(44, 'ALAT TEMBAK GLUE GUN 20 W / ALAT LEM BAKAR CAIR LEM LILIN', 16500, 100, 'Alat ini sangat cocok diaplikasikan pada produk kerajinan tangan / prakarya, lem kaca, produk rumah tangga dan lain-lain.\r\nSPESIFIKASI\r\n- Ada On/Off\r\n- Power : 20 Watt\r\n- Input : AC 110-240V\r\n- Frequency : 50-60Hz', 'Glue Gun', 'asset/product/44.jpg'),
(45, 'Lem cair UHU The All Purpose Adhesive made in GERMANY uk 35ml', 14800, 200, 'Lem UHU merupakan lem serba bisa yang dapat digunakan untuk sehari - hari baik dari prakarya sekolah, kantor, maupun rumah tangga.', 'UHU', 'asset/product/45.jpg'),
(46, 'Kertas HVS Sinar Dunia A4 80 Gram (isi 500 lembar)', 52000, 300, 'Kertas HVS merk Sinar Dunia memiliki kualitas yang terbaik. Kertasnya sangat putih dan gramatur tiap lembar sama sehingga sangat nyaman digunakan. Cocok digunakan untuk mesin printer dan fotocopy. ', 'Sinar Dunia', 'asset/product/46.jpg'),
(47, 'Kertas HVS Sinar Dunia SIDU A4 70 Gram (isi 500 lembar)', 48000, 300, 'Kertas HVS merk Sinar Dunia memiliki kualitas yang terbaik. Kertasnya sangat putih dan gramatur tiap lembar sama sehingga sangat nyaman digunakan. Cocok digunakan untuk mesin printer dan fotocopy.', 'Sinar Dunia', 'asset/product/47.webp'),
(48, 'Kertas F4 70Gr Bola Dunia / Kertas HVS Folio 70Gram Bola Dunia', 42000, 300, 'Kertas F4 70Gr Bola Dunia / Kertas HVS Folio 70Gram Bola Dunia\r\nSize : 215 x 330 mm (Folio)\r\n70Gram\r\nMerk. Bola Dunia\r\n1 Rim = 500 lembar\r\n1 Dus = 5 rim\r\nHarga diatas / Rim', 'Bola Dunia', 'asset/product/48.webp'),
(49, 'Kertas Hvs Bola Dunia F4 80 Gram Kertas Folio 1 Rim', 60000, 300, 'Kertas Hvs Bola Dunia F4 80 Gram Kertas Folio 1 Rim\r\nharga 1 rim', 'Bola Dunia', 'asset/product/49.webp'),
(50, 'OIL PASTEL / CRAYON PENTEL 12 WARNA', 21000, 200, 'Krayon / Crayon Pentel Oil Pastel Regurer Stick 36 warna, memiliki kandungan minyak lebih banyak sehingga tekstur oil pastel lebih lunak/ lembut dan nyaman pada saat digunakan. Oil Pastel ini aman digunakan untuk semua jenis usia. \r\n', 'Pentel', 'asset/product/50.jfif'),
(51, 'Crayon Oil Pastel Pentel Arts 50 Warna', 78000, 100, 'Crayon atau oil pastel terdiri dari 50 warna. Bertexture basah seperti crayon pada umumnya. Mudah menempel pada kertas. Mudah diblend. Cocok digunakan untuk anak-anak maupun orang dewasa.', 'Pentel', 'asset/product/51.webp'),
(52, 'Terbaru Pensil Warna Faber Castell Polychromos 120 Warna', 3200000, 100, 'Kemasan : metal (kaleng)\r\n.\r\nPigmen berkualitas tinggi sehingga warna lebih cemerlang\r\nWarna tidak mudah pudar\r\nWarna yang lembut\r\nSistem SV Bonding membuat pensil tidak mudah patah\r\n', 'Faber Castell', 'asset/product/52.jpeg'),
(53, 'CAT MINYAK MARIES 12 OIL COLOUR ALAT LUKIS GAMBAR CAT LUKIS', 76000, 100, '*Cat minyak Maries isi 12 warna @12ml\r\n*Dapat di aplikasikan ke semua media (kanvas, kertas, kulit, dll)\r\n*Hasil cat halus, jelas, & tahan lama\r\n*Cocok dari pemula-profesional\r\n*Untuk mengencerkan cat,gunakan Maries Painting Medium (cairan pengencer cat minyak) secukupnya pada cat', 'Maries', 'asset/product/53.jfif'),
(54, '1 SET KUAS LUKIS BAHAN NYLON UNTUK CAT ACRYLIC', 12500, 100, 'Kuas lukis bahan nylon. ', 'Joyko', 'asset/product/54.jpg'),
(55, 'Kanvas Lukis Spanram 10x10 cm Canvas Frame 10x10cm', 6000, 50, 'Kanvas Ukuran : 10x10cm\r\nTebal Spanram : 2 cm\r\nKayu Albasia', 'Spanram', 'asset/product/55.jpg'),
(56, 'Kalkulator Penggaris Mini', 164800, 50, 'Kalkulator Mini Gaya Korea Dengan Penggaris Untuk Pelajar', 'Bitoon', 'asset/product/56.jpg'),
(57, 'Tip Ex Kenko CT-902 Tip-ex Tip X Kertas Correction Tape [ 1 Pcs ]', 5800, 100, 'Panjang : 12 meter\r\nRandom Warna.', 'Kenko', 'asset/product/57.jpg'),
(58, 'penghapus / stip / eraser crayon/ pensil warna/ pensil faber castell', 7000, 200, 'Penghapus ini bisa di gunakan untuk menghapus crayon, pensil warna dan pensil dengan bentuk Bulat, oval dan segitiga sehingga memudahkan kita untuk menghapus dengan sudut tertentu. Dengan aneka warna menarik seperti merah, biru, kuning dan hijau. Tidak beracun dan aman untuk anak-anak.\r\nBentuk ergonomis dengan kontrol yang lebih baik.', 'Faber Castell', 'asset/product/58.webp'),
(59, 'Pensil, pensil unik, pensil lucu, pensil penghapus, penghapus lucu', 4000, 200, 'panjang : += 17, 2 cm\r\nharga : pensil dan penghapus\r\npenghapus di bungkus plastik', 'Kayo', 'asset/product/59.png'),
(60, 'Terbaru Kotak Pensil Lucu Dan Unik - Milk Pensil Case - Tempat Pensil Susu', 34000, 100, 'Kotak pensil lucu dan unik - Milk Pensil Case - tempat pensil susu\r\n- Random\r\n- Ukuran: p 25, l 8,5 cm t 1 cm (Bentuknya Pipih, bukan Kotak )\r\n- Bahan: Kulit sintetis', 'Original', 'asset/product/60.jpg'),
(61, 'Penghapus Pensil Mekanik Lantu', 5000, 240, 'UKURAN: 2 X 11 CM\r\nBERAT: 40 GRAM\r\nWARNA: RANDOM SESUAI STOK', 'Lantu', 'asset/product/61.jfif'),
(62, 'Rautan pensil Lucu bentuk sepatu', 3000, 100, 'Rautan tangan buat pensil dengan bentuk sepatu yang lucu.', 'Shoes', 'asset/product/62.jfif'),
(63, 'Rautan Pensil Otomatis Dua Lubang Dengan Saklar Sentuh Untuk Alat', 156600, 100, '1.Sharpe blade for safe and easy operation.\r\n\r\n2.Premium shell, strudy and durable for a long term use.\r\n\r\n3.Suitable for Dia 6.5mm - 12mm pencils.', 'Sharper', 'asset/product/63.jfif'),
(64, 'Peralatan Tulis Set Sekolah Anak-Anak / Stationery Set / Perlengkapan Sekolah - X255', 12800, 100, 'Alat tulis set, Cocok sebagai Hadiah tuk si kecil agar lebih bersemangat dalam belajar :)\r\n\r\nKelengkapan : \r\n- 2 pcs Pensil Serut\r\n- 1 pcs BallPoint\r\n- 1 pcs Penggaris (15 cm)\r\n- 1 pcs Rautan Pensil (0.5 mm)\r\n- 1 pcs Penghapus\r\n- 1 psc Lem\r\n- 1 pcs Gunting (aman digunakan karena tanpa pisau besi)', 'Stationery Set', 'asset/product/64.jfif'),
(65, 'Joyko S-68 Date Stempel Lunas', 12000, 100, 'Joyko S-68 Date Stempel Lunas merupakan date stamp berbahan kualitas tinggi yang didesain praktis & ergonomic. Stampel ini dapat diputar dengan mudah. Ideal digunakan untuk kebutuhan toko dan lainnya. Ukuran Produk : 7.9 x 4.8 x 3.4 cm.', 'Joyko', 'asset/product/65.jpg'),
(66, 'Date Stamp / Stempel Tanggal Joyko D-4', 8500, 100, '>Ukuran Produk : 7.8 x 3.6 x 2.5 cm\r\n>Hasil stempel : Tanggal ', 'Joyko', 'asset/product/66.jfif'),
(67, 'Faber Castel Eraser Dust Free 7120 Big White.- Penghapus', 6500, 150, 'Eraser / Penhapus Faber Castel.\r\nTidak meninggalkan kotoran sisa hapusan;\r\nmenghapus pensil Putih dan mekanik dengan jelas;\r\ntidak beracun dan aman bagi anak-anak', 'Faber Castell', 'asset/product/67.jpeg'),
(68, 'Faber-Castell Connector Pen Set-30 Gift Set', 89000, 25, 'Ini dia spidol warna paling kreatif dan unik dari Faber-Castell, \"Connector Pen\". Connector pen  memiliki warna yang cerah , aman untuk anak-anak dan tahan lama. Bentuk tutupnya yang unik membuatnya dapat disambung--sambungkan sehingga menjadi rapi dan tidak mudah menggelinding jatuh ke lantai.Selain digunakan untuk menggambar dan mewarnai, Connector pen dapat digunakan untuk membuat craft  kreati', 'Faber Castell', 'asset/product/68.jpeg'),
(69, 'Faber - Castell Textliner 48 Translucent Yellow Ink', 8000, 50, 'â€¢ Tinta lebih cepat kering pada permukaan kertas\nâ€¢ Dapat dipakai untuk kertas biasa dan kertas fax', 'Faber Castell', 'asset/product/69.webp'),
(70, 'Faber-Castell | Soft Pastel 48', 320000, 20, 'Pastel yang sangat kering dan lembut tanpa pelumas\r\nWarna yang cemerlang\r\nIdeal untuk mengambar spontan\r\nMudah dihapus menggunakan jari, kain, paper wiper, sikat pastel\r\nTerdiri dari 48 warna', 'Faber Castell', 'asset/product/70.jpeg'),
(71, 'Date Stamp / Stempel Tanggal Joyko D-4', 8500, 100, '>Ukuran Produk : 7.8 x 3.6 x 2.5 cm\r\n>Hasil stempel : Tanggal ', 'Joyko', 'asset/product/71.jfif'),
(72, 'Pensil 2B Faber Castell 9000', 35000, 50, 'Pensil 2B Faber Castell\r\n1pack isi 12pcs\r\nharga tercantum harga perlusin, pembelian minimal 1lsn', 'Faber Castell', 'asset/product/72.jpeg'),
(73, 'Kalkulator Hello kitty Kalkulator kartun calculator Hello kitty KT3399', 65000, 50, 'Color : pink/red\r\nSize : 12cm(length)*13cm(Height)\r\nDescription : support battery and solar power calculator', 'Sanrio', 'asset/product/73.jfif'),
(74, '[Kalkulator/Calculator] Kamus Bahasa Inggris Alfalink EI 21 SE Kalkulator/Ilmiah/Elektronik', 755000, 50, 'Layar: Tidak berwarna\r\nTampilan Layar: 4 Baris\r\nUkuran: 110 x 70 x 12 mm\r\nBerat: 80 gr\r\nBaterai: 2 x CR2032 Lithium\r\nKamus: 15 Kamus (Inggris-Indonesia, Indonesia-Inggris, Inggris-Inggris, Indonesia-Indonesia, TOEFL, Kamus Praktis, Kamus Profesional,  Kamus Akuntansi, Kamus Biologi, Kamus Fisika, Kamus Kedokteran, Kamus Komputer, Kamus Matematika, Kamus Mekanik, Kamus Perbankan, Kamus Perdagangan,', 'Alfalink', 'asset/product/74.jfif'),
(75, 'Kalkulator Casio Graphic fx 9860GIISD Garansi resmi[212]', 1777000, 65, 'Garansi Resmi Casio 1 Tahun\r\n\r\nOriginal Product\r\nCalculator Casio Graphic\r\nSupport SD card\r\n64kb RAM\r\n1.5MB Flash Memory\r\nLarge Display ( 21 columns x 8 lines, 127 x 63 dots )', 'Casio', 'asset/product/75.jpg'),
(76, 'Casio HR 100 RC Kalkulator Printer cetak Struk - calculator print', 535800, 100, '* Reprint Function yang bisa mencetak ulang atau mencetak lebih dari 1x.\r\n* Check Function yang bisa mengecheck ulang hasil hitungan sebelum dicetak/diprint sebanyak 150 steps.\r\n* Clock / Calender Function untuk menampilkan Jam dan Tanggal yang bisa disetting.\r\n* 12 Digit with Large Display.\r\n* 2 Colour-Printing.\r\n\r\nUntuk ukuran dari Kalkulator Printing ini 65 x 165 x 295 mm, dan ukuran kertas str', 'Casio', 'asset/product/76.jpg'),
(77, 'Kalkulator Calculator Print Printing Struck Struk Meja Casio FR-2650 FR 2650 Garansi Resmi 1 Tahun', 925000, 45, '- Fitur Reprint: Cetak berkali-kali di sejarah kalkulasi tanpa input data kembali.\r\n- Fitur Reprint: Sejarah kalkulasi bisa sewaktu-waktu diprint.\r\n- Fitur Check: Check sejarah kalkulasi tanpa print.\r\n- Jam/Kalendar: Bisa print waktu dan tanggal.\r\n- Mudah digunakan: Textured Finish dan lampu LCD untuk memudahkan membaca.\r\nSpesifikasi\r\n- Tipe Desktop\r\n- 12 Digit\r\n- Cetak 2 Warna: Nominal positif ak', 'Casio', 'asset/product/77.jpeg'),
(78, 'Kalkulator Unik Calculator Mini Warna Warni', 37600, 100, 'Ukuran : 3.9 x 5.7 cm\r\nRandom', 'Star', 'asset/product/78.jfif'),
(79, 'Kertas HVS Struck Struk Roll 58 x 48 mm Untuk Kalkulator Casio Printing (10 roll)', 55000, 100, 'Kertas HVS ukuran 58 mm x 48mm\r\n1 PLY\r\n1 pak isi : 10 ROLL\r\nCocok untuk kalkulator struk Casio :\r\nHR 8 RC, HR8RC\r\nHR 100 RC , HR100RC\r\nDR 120 TM\r\nDR 140 TM\r\nDR 240 TM', 'PaperStruck', 'asset/product/79.jpg'),
(80, 'Faber Castell Connector Pen 30 Warna Gift Set Spidol Colouring Pen', 77800, 100, '- warna yang cerah\r\n- dapat digabung-gabungkan agar tidak hilang\r\n- dapat dicuci dan tidak meninggalkan noda pada pakaian\r\n- tidak beracun, aman untuk anak-anak\r\n- bisa dirangkai menjadi aneka bentuk craft\r\n- dikemas dalam kotak plastik, sangat cocok diberikan sebagai hadiah\r\n\r\nIsi terdiri dari :\r\n- 30 buah Connector pen / spidol warna\r\n- 12 buah Connector clips / penyambung\r\n- DVD kreatif\r\n- 2 Ga', 'Faber Castell', 'asset/product/80.jfif'),
(81, 'BAOER Pena Pulpen Tanda Tangan Tinta Fountain Pen Ballpoint 1 PCS 3035', 133000, 77, 'Pena tinta ballpoint dengan tinta warna hitam. Body pena terbuat dari plastik berkualitas sehingga terlihat elegan dan berkelas saat digunakan. Cocok untuk tanda tangan karena bentuk ujungnya yang runcing.', 'Baoer', 'asset/product/81.jpeg'),
(82, 'Map plastik kancing - Putih (1 lusin)', 20000, 300, 'Map plastik dengan kancing berpunggung\r\nBisa memuat kertas ataupun map kertas ukuran folio\r\n1 lusin 1 warna', 'Jenia', 'asset/product/82.jpg'),
(83, 'Map Plastik Resleting / Zipper Bag - Hijau', 9500, 300, 'Map Plastik Resleting ukuran Folio', 'Daiichi', 'asset/product/83.jpg'),
(84, 'Stop Map Kingco - HIjau ( 1 pak )', 44000, 200, 'Isi 50 pcs', 'Kingco', 'asset/product/84.jpg'),
(85, 'Amplop Polos Besar (Pak)', 18000, 500, 'Amplop putih polos 90 Paperline 110mm x 230mm. Amplop putih polos dengan perekat. Merk Paperline. Ketebalan kertas 80gsm. Ukuran 110mm x 230mm. Isi 100 lembar. Warna putih polos. ', 'Paperline', 'asset/product/85.jpg'),
(86, '(10 Lembar)Amplop/Envelope/Surat Coklat Airmail/Air Mail Tali 304', 7300, 500, '-Ukuran 13,3 x 27 cm\r\n-Isi 10 lembar\r\n-Terdapat tali\r\n-Cocok untuk surat menyurat/keperluan lainnya', 'Executive', 'asset/product/86.jpg'),
(87, 'AMPLOP COKLAT TALI AIRMAIL 312 TEBAL ISI 10 LEMBAR', 14000, 300, 'AMPLOP COKLAT AIRMAIL TALI 312 TEBAL ISI 10 LEMBAR\r\n\r\nUKURAN 30 CM X 40 CM \r\n\r\nISI PER PAK 10 LEMBAR', 'Eds-On', 'asset/product/87.jfif'),
(88, 'AMPLOP COKLAT 312 TALI@10 AIR MAIL', 26000, 300, 'Panjang: 39cm\r\nLebar: 28.8cm\r\nTinggi: 1.5cm', 'Globe', 'asset/product/88.jfif'),
(89, 'DOUBLE TAPE 24 MM TACHIMITA BERKUALITAS / DOUBLE TAPE KERTAS', 5500, 500, 'Lebar 24 MM\r\nPanjang 13,5 M\r\nGood Quality . \r\n\r\nDOUBLE TAPE terbuat dari kertas tisu yang kedua sisinya dilapisi dengan acrylic base disobek dan mampu menempel di segala permukaan baik terbuat dari metal / besi, kaca, kayu, maupun plastic. Lakban ini cocok untuk mounting, menyambung, dan penggunaan di Elektronik, industri percetakan, perkantoran, dan sekolahan,', 'Tachimita', 'asset/product/89.jfif'),
(90, 'Joyko isolasi kecil bening - 6 pcs', 16000, 600, 'Isolasi ukuran 12 MM Ã— 33M\r\nJoyko STT- 30\r\nBening', 'Joyko', 'asset/product/90.jfif'),
(91, 'Buku Tulis Ukuran A5 (14.8 x 21 cm) 1 pack', 58000, 997, 'Buku Tulis Ukuran A5 (14.8 x 21 cm)\r\nIsi : 30 Lembar\r\n\r\n1 pack isi 20 buku', 'Plus', 'asset/product/91.jpg'),
(92, 'KIKY Buku Tulis BX 42 Lembar - 10 Buku / Motif Random', 48800, 1000, 'Ukuran Kertas\r\nA5\r\nJumlah Lembar\r\n100', 'Kiky', 'asset/product/92.jfif'),
(93, 'Buku Gambar ukuran A4, 20 X 30 cm', 8500, 1000, 'Buku Gambar ukuran 20 X 30 cm, ukuran A4, motif random ', 'Drawing', 'asset/product/93.jpg'),
(94, 'Buku halus kasar standart (1 pack)', 27000, 1000, 'Buku tulis halus kasar\r\nIsi 30lembar\r\nMerk Standart\r\n1 pack isi 10 buku', 'Standart', 'asset/product/94.jfif'),
(95, 'PAPERLINE Buku Kwitansi Sedang KT 40 T', 4700, 1000, 'Buku Kwitansi\r\nUkuran: 9 x 28.5 cm\r\nIsi: 40 lembar', 'Paperline', 'asset/product/95.jpg'),
(96, 'Nota Kontan Kiky Kecil NCR 2ply ( 1 pack)', 24000, 200, 'Kiky Buku Nota Kontan 2 Ply Kecil\r\n25 Lembar 2 Rangkap \r\nNCR Warna Putih Merah\r\n1 pack = 10 pcs', 'Kiky', 'asset/product/96.jfif'),
(97, 'Buku Ekspedisi', 9900, 1000, 'Isi : 100 Lembar\r\nUkuran : 10,5cm x 31cm, harga per pcs', 'Kiky', 'asset/product/97.jpg'),
(98, '20 lembar / 1pack sampul coklat ukuran KWARTO/ sampul coklat buku tulis biasa', 7200, 1000, '> 1 pack isi 20 pcs\r\n> Bahan: kertas Samson (tebal)\r\n> Ukuran: Kwarto (Buku tulis biasa/standard)> sampul coklat uk 25,5 cm x 19 cm', 'No Brand', 'asset/product/98.jpg'),
(99, 'Sampul Kopi Coklat Buku Kecil Kwarto - Kertas Cokelat Samson Tebal', 6000, 1000, 'Sampul cokelat untuk ukuran buku kwarto. Kertas berbentuk lembaran, terdapat sisa di bagian samping sampul untuk dilipat ke bagian dalam, agar tersampul rapi.\r\n- Warna: coklat muda\r\n- Harga tertera untuk 10 lembar sampul.\r\n- Permukaan yang lebih licin menghadap ke bagian luar.', 'Renke', 'asset/product/99.jfif'),
(100, 'Sampul Buku Plastik OPP BIG Kwarto 25 lembar - 1001', 11200, 1000, '\r\nKondisi Barang\r\nBARU\r\nSpesifikasi\r\nKategori	:	Buku & Organizer\r\nBerat	:	130 gram\r\nAsal Barang	:	Lokal\r\nDeskripsi\r\nSampul Buku Plastik OPP BIG Kwarto 25 lembar - 1001\r\n\r\nUkuran : Kwarto (21,7 cm X 37,5 cm)\r\nIsi 1 Pack : 25 Lembar\r\nSampul Plastik BIG terbuat dari OPP + Lem\r\nMemiliki ketebalan 0,50 milimicron\r\nKegunaan Sampul Plastik untuk menghindari debu dan kotoran\r\nMudah dipakai, Melindungi buk', 'BIG', 'asset/product/100.jfif'),
(101, 'Sampul buku plastik roll mika 45 cm', 11200, 1000, 'Sampul Mika Roll dengan panjang 45 x 500 cm\r\nCocok digunakan berbagai keperluan\r\n* Buku tulis berbagai ukuran\r\n* Accessories\r\n* Dll\r\n', 'Kiky', 'asset/product/101.jpg'),
(102, 'BUKU TULIS BESAR FOLIO AKUTANSI 200 LBR ISI 3 BUKU ATK BEL44', 178000, 100, '* Buku Ukuran Folio.\r\n* Isi 200 lembar.\r\n* Harga/pack.\r\n* Isi 3 buku/pack.\r\n* For office,home and school.', 'Kiky', 'asset/product/102.jpg'),
(103, 'Stopmap Batik Murah Folio / Map Kertas Batik Folio (4pcs)', 10000, 1000, 'Stopmap Batik Murah Folio / Map Kertas Batik Folio\r\nSize : Folio\r\nBahan Kertas Karton\r\nMotif Batik', 'Kiky', 'asset/product/103.jpg'),
(104, 'SHARPIE Fine Point Permanent Marker 8 Set', 100000, 25, 'Spidol permanen original style\r\n\r\nStandard Industri\r\nBisa digunakan di hampir segala media\r\nTidak mudah pudar dan tahan air\r\nTinta mudah kering dan berlisensi tidak beracun', 'Sharpie', 'asset/product/104.jpg');

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
(1, 'kitsunne', '4a7d1ed414474e4033ac29ccb8653d9b', 'Daniel', 'danielgamalie06@gmail.com', 'Jl Airlangga No 5', '085954519045'),
(2, 'cung', '4a7d1ed414474e4033ac29ccb8653d9b', 'Andrew Anderson', 'Andrew01@gmail.com', 'Jl Durian Runtuh No 1', '081352138823'),
(3, 'someone21', 'd27ba2eb409606d3efcf494715650186', 'Marcell', 'mar@gmail.com', 'Jln Mawar no 26', '081233444111');

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
(1, '201', 'Transaksi sedang diproses', '79b8734b-5ac9-4a93-b5e2-0164a40fe520', '547470470', 17100.00, 'bank_transfer', '2021-12-02 21:00:36', 'pending', 'bca', '36466899796', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/0414ec8f-6082-4cc2-866a-a808fc160d4c/pdf', 'http://example.com?order_id=547470470&status_code=201&transaction_status=pending', '-', '-'),
(2, '201', 'Transaksi sedang diproses', '09407253-14b5-4cd4-9c6b-69792baddb2b', '510543012', 17100.00, 'bank_transfer', '2021-12-02 21:02:26', 'pending', 'bca', '36466172545', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/02261e28-6a3e-4bf7-9b36-9dce18de4b09/pdf', 'http://example.com?order_id=510543012&status_code=201&transaction_status=pending', '-', '-'),
(3, '201', 'Transaksi sedang diproses', '09407253-14b5-4cd4-9c6b-69792baddb2b', '510543012', 17100.00, 'bank_transfer', '2021-12-02 21:02:26', 'pending', 'bca', '36466172545', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/02261e28-6a3e-4bf7-9b36-9dce18de4b09/pdf', 'http://example.com?order_id=510543012&status_code=201&transaction_status=pending', '-', '-'),
(4, '201', 'Transaksi sedang diproses', '8ebfe8b7-4998-4f3d-a7bf-c18a96911fda', '1913827662', 41200.00, 'bank_transfer', '2021-12-02 21:03:45', 'pending', 'bca', '36466118684', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/b753a647-6dab-4488-a1de-abd346b6a024/pdf', 'http://example.com?order_id=1913827662&status_code=201&transaction_status=pending', '-', '-'),
(5, '201', 'Transaksi sedang diproses', '586a72b1-2890-400d-8ef6-fdc8fe765585', '314159312', 33500.00, 'bank_transfer', '2021-12-02 21:04:09', 'pending', 'bca', '36466591375', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/0ea99c3e-07b6-4a28-bcf5-e827e36e386d/pdf', 'http://example.com?order_id=314159312&status_code=201&transaction_status=pending', '-', '-'),
(6, '201', 'Transaksi sedang diproses', 'f1e1f8b6-4fae-43a6-ad3c-a8c06e51f5d9', '107373385', 40000.00, 'bank_transfer', '2021-12-11 22:35:55', 'pending', 'bca', '36466273563', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/8565292e-10b9-4797-813e-fa3c6a441e00/pdf', 'http://example.com?order_id=107373385&status_code=201&transaction_status=pending', '-', '-'),
(7, '200', 'Transaksi sedang diproses', '8d2edda7-38ce-41b8-a192-7a37ad10b98b', '2044421269', 76000.00, 'bank_transfer', '2021-12-11 22:52:21', 'settlement', 'bca', '36466496160', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/f6a07b73-3067-481d-a48e-89176e118947/pdf', 'http://example.com?order_id=2044421269&status_code=201&transaction_status=pending', '-', '-'),
(8, '202', 'Transaksi sedang diproses', '67616f90-b0dd-4fad-9499-f4f8968265a7', '672052474', 174000.00, 'bank_transfer', '2021-12-11 22:56:21', 'expire', 'bca', '36466760188', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/66e03d1a-71d5-4a9c-946e-a6d700c24153/pdf', 'http://example.com?order_id=672052474&status_code=201&transaction_status=pending', '-', '-'),
(9, '202', 'Transaksi sedang diproses', '67a3d004-3ca3-4b6e-9bf0-60ac4aa69e84', '727238993', 286000.00, 'bank_transfer', '2021-12-11 23:10:49', 'expire', 'bca', '36466438674', 'accept', 'https://app.sandbox.midtrans.com/snap/v1/transactions/f032c809-5612-49d1-9ac6-1d38c651c373/pdf', 'http://example.com?order_id=727238993&status_code=201&transaction_status=pending', '-', '-');

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
(31, 14, 8),
(32, 26, 8),
(33, 26, 9),
(34, 27, 8),
(35, 27, 9),
(36, 28, 8),
(37, 28, 11),
(38, 29, 8),
(39, 30, 8),
(41, 31, 8),
(42, 33, 8),
(43, 34, 7),
(44, 35, 7),
(45, 36, 1),
(46, 36, 7),
(47, 37, 7),
(48, 37, 8),
(49, 38, 7),
(50, 38, 8),
(51, 39, 7),
(52, 39, 8),
(53, 40, 8),
(54, 41, 7),
(55, 42, 7),
(56, 42, 8),
(57, 42, 13),
(58, 43, 14),
(59, 44, 8),
(60, 45, 8),
(61, 46, 7),
(62, 46, 8),
(63, 46, 10),
(64, 47, 7),
(65, 47, 8),
(66, 47, 10),
(67, 48, 7),
(68, 48, 8),
(69, 48, 10),
(70, 49, 7),
(71, 49, 8),
(72, 49, 10),
(73, 50, 7),
(74, 51, 7),
(75, 52, 7),
(76, 53, 7),
(77, 54, 7),
(78, 55, 7),
(79, 56, 5),
(80, 56, 7),
(81, 57, 4),
(82, 57, 7),
(83, 57, 8),
(84, 58, 3),
(85, 58, 7),
(86, 58, 8),
(87, 59, 2),
(88, 59, 3),
(89, 59, 7),
(90, 59, 8),
(91, 60, 7),
(92, 60, 8),
(93, 61, 3),
(94, 61, 7),
(95, 61, 8),
(96, 62, 7),
(97, 62, 8),
(98, 63, 7),
(99, 63, 8),
(100, 64, 2),
(101, 64, 3),
(102, 64, 5),
(103, 64, 6),
(104, 64, 7),
(105, 66, 8),
(106, 66, 15),
(107, 67, 3),
(108, 67, 7),
(109, 68, 1),
(110, 68, 7),
(111, 69, 7),
(112, 69, 8),
(113, 69, 16),
(114, 70, 17),
(115, 71, 8),
(116, 71, 15),
(117, 72, 2),
(118, 72, 7),
(119, 73, 8),
(120, 74, 8),
(121, 75, 8),
(122, 76, 8),
(123, 77, 8),
(124, 78, 7),
(125, 78, 8),
(126, 79, 8),
(127, 79, 10),
(128, 80, 7),
(129, 81, 1),
(130, 81, 7),
(131, 81, 8),
(132, 82, 7),
(133, 82, 8),
(134, 82, 11),
(135, 83, 7),
(136, 83, 8),
(137, 83, 11),
(138, 84, 8),
(139, 84, 11),
(140, 85, 8),
(141, 86, 8),
(142, 87, 8),
(143, 87, 18),
(144, 88, 8),
(145, 88, 18),
(146, 89, 8),
(147, 90, 8),
(148, 91, 7),
(149, 91, 12),
(150, 92, 7),
(151, 92, 12),
(152, 93, 7),
(153, 93, 12),
(154, 94, 7),
(155, 94, 12),
(156, 95, 8),
(157, 95, 12),
(158, 96, 8),
(159, 96, 12),
(160, 97, 7),
(161, 97, 8),
(162, 97, 12),
(163, 98, 7),
(164, 98, 12),
(165, 99, 7),
(166, 99, 8),
(167, 99, 12),
(168, 100, 7),
(169, 100, 12),
(170, 101, 7),
(171, 101, 12),
(172, 102, 7),
(173, 102, 8),
(174, 102, 12),
(175, 103, 7),
(176, 103, 8),
(177, 103, 11);

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
(1, 91, 3),
(2, 104, 3);

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
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `discount`
--
ALTER TABLE `discount`
  MODIFY `discount_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `History_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `list_category`
--
ALTER TABLE `list_category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `list_product`
--
ALTER TABLE `list_product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `list_user`
--
ALTER TABLE `list_user`
  MODIFY `users_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `product_category`
--
ALTER TABLE `product_category`
  MODIFY `product_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=178;

--
-- AUTO_INCREMENT for table `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `wishlist_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
