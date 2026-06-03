-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2026 at 10:07 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avg_store`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` text NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `total_price` varchar(50) NOT NULL,
  `status` varchar(50) DEFAULT 'Chờ xử lý',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_name`, `phone`, `address`, `product_name`, `total_price`, `status`, `created_at`) VALUES
(1, 'Nguyễn Văn A', '0912345678', '123 Đường Lê Lợi, Quận 1, TPHCM', 'ĐẦM NGÂN TAY BỒNG', '1.899.000 VND', 'Chờ xử lý', '2026-06-02 17:56:10'),
(2, 'Trần Thị B', '0987654321', '456 Đường Nguyễn Huệ, Quận 3, TPHCM', 'ĐẦM SATIN REN ZW COLLECTION', '1.899.000 VND', 'Đang giao', '2026-06-02 17:56:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` varchar(50) NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `category`, `price`, `image`) VALUES
(1, 'ĐẦM SATIN REN ZW COLLECTION', 'Váy & Đầm', '1.899.000 VND', 'https://static.zara.net/assets/public/86fa/d222/413d40b8b2e9/44539b23649f/02678047800-a3/02678047800-a3.jpg?ts=1778168158415&w=658'),
(2, 'ĐẦM MIDI DỆT KIM CỔ YẾM BUỘC DÂY', 'Váy & Đầm', '1.699.000 VND', 'https://static.zara.net/assets/public/ad39/3640/626c42deb048/4abcf2a6d962/02142142505-p/02142142505-p.jpg?ts=1775657512566&w=658'),
(3, 'ĐẦM NGẮN TAY BỒNG', 'Váy & Đầm', '1.899.000 VND', 'https://static.zara.net/assets/public/fc15/5de6/21b44648860c/f0ee7f3750d2/02175536712-p/02175536712-p.jpg?ts=1773411722751&w=658'),
(4, 'ĐẦM DÁNG NGẮN VẢI INTERLOCK', 'Váy & Đầm', '1.199.000 VND', 'https://static.zara.net/assets/public/4da8/22ac/3da04bcaae5a/2a4023dd947d/02335168660-a2/02335168660-a2.jpg?ts=1769767892654&w=658'),
(5, 'ĐẦM DÁNG NGẮN TAY BỒNG', 'Váy & Đầm', '1.899.000 VND', 'https://static.zara.net/assets/public/9ebc/e164/389e4d2fbec0/dbf13175093e/03897114064-p/03897114064-p.jpg?ts=1774957887055&w=658'),
(6, 'ĐẦM NGẮN XẾP NẾP REN', 'Váy & Đầm', '1.299.000 VND', 'https://static.zara.net/assets/public/0c58/ca8f/a2c74b7a89e3/411132ed30a3/07484061700-a1/07484061700-a1.jpg?ts=1780050879927&w=658'),
(7, 'ĐẦM MINI KÈM THẮT LƯNG', 'Váy & Đầm', '1.399.000 VND', 'https://static.zara.net/assets/public/5844/42c7/b4ee4b9582c7/817512dd2391/00387057800-p/00387057800-p.jpg?ts=1775661997365&w=658'),
(8, 'ĐẦM MIDI DỆT KIM CỔ YẾM BUỘC DÂY', 'Váy & Đầm', '1.699.000 VND', 'https://static.zara.net/assets/public/ad39/3640/626c42deb048/4abcf2a6d962/02142142505-p/02142142505-p.jpg?ts=1775657512566&w=658'),
(9, 'ÁO KHOÁC BLAZER DÁNG ÔM PHA LEN ZW COLLECTION LIMITED EDITION', 'Áo Sơ Mi & Blazer', '4.999.000 VND', 'https://static.zara.net/assets/public/c332/57b2/e78745749346/4f6a8894ce2a/03002143800-p/03002143800-p.jpg?ts=1779378513810&w=658'),
(10, 'ÁO KHOÁC BLAZER VIỀN PHỐI MÀU TƯƠNG PHẢN', 'Áo Sơ Mi & Blazer', '2.199.000 VND', 'https://static.zara.net/assets/public/cc5a/f9b4/c87347d78c2a/e1119466a22a/08657599401-p/08657599401-p.jpg?ts=1771417941035&w=292'),
(11, 'ÁO KHOÁC BLAZER CHIẾT EO CÓ ĐỆM VAI', 'Áo Sơ Mi & Blazer', '1.899.000 VND', 'https://static.zara.net/assets/public/8f5b/be6e/43934f089e24/275d6c408db2/07740876052-a1/07740876052-a1.jpg?ts=1780049670989&w=292'),
(12, 'ÁO BLAZER BẤT ĐỐI XỨNG ZW COLLECTION', 'Áo Sơ Mi & Blazer', '3.599.000 VND', 'https://static.zara.net/assets/public/7aba/b08f/05614e27935a/ae4f6093c49d/02821606800-p/02821606800-p.jpg?ts=1777559322315&w=292'),
(13, 'ÁO KHOÁC BLAZER DÁNG LỬNG CỘC TAY ZW COLLECTION', 'Áo Sơ Mi & Blazer', '2.599.000 VND', 'https://static.zara.net/assets/public/8f84/ea1f/f01b434ea0d8/3d50c0006a9e/02438198712-a1/02438198712-a1.jpg?ts=1780048131144&w=292'),
(14, 'ÁO KHOÁC ĐỆM VAI CÀI KHUY', 'Áo Sơ Mi & Blazer', '2.499.000 VND', 'https://static.zara.net/assets/public/5d83/5872/e5ac4f7f91ac/aefaff7e2e00/02811593800-a1/02811593800-a1.jpg?ts=1777567134794&w=292'),
(15, 'ÁO KHOÁC BLAZER CHIẾT EO PHỐI ĐƯỜNG VIỀN KHÁC MÀU', 'Áo Sơ Mi & Blazer', '2.499.000 VND', 'https://static.zara.net/assets/public/f7ff/a29d/d07c4ebe9df1/8f558dd6c94e/02727111712-a1/02727111712-a1.jpg?ts=1775490592201&w=292'),
(16, 'ÁO KHOÁC BLAZER CỔ CAO CÀI KHUY ZW COLLECTION', 'Áo Sơ Mi & Blazer', '3.599.000 VND', 'https://static.zara.net/assets/public/3149/42e8/140048eeb153/3f0cb75ae336/02237570800-a1/02237570800-a1.jpg?ts=1772191985782&w=292'),
(17, 'ÁO KHOÁC BLAZER VẢI DỆT ĐỆM VAI CHỈ KIM TUYẾN', 'Áo Sơ Mi & Blazer', '2.499.000 VND', 'https://static.zara.net/assets/public/094a/fab8/549840949218/b2dcfef685c8/02293120712-p/02293120712-p.jpg?ts=1776845988532&w=292'),
(18, 'VÒNG CỔ KIM LOẠI ĐÍNH ĐÁ', 'Phụ Kiện', '1.199.000 VND', 'https://static.zara.net/assets/public/27ec/9491/25ce4c70bb30/3f8920a857f2/04548215303-ult23/04548215303-ult23.jpg?ts=1780059803133&w=395'),
(19, 'VÒNG CỔ DÂY DÙ MẶT CHỮ CÁI', 'Phụ Kiện', '359.000 VND', 'https://static.zara.net/assets/public/b365/b1e0/d0884c44b83a/23265e37dc7c/01599202300-ult23/01599202300-ult23.jpg?ts=1780052169742&w=395'),
(20, 'VÒNG CỔ PHỐI HẠT NHIỀU MÀU', 'Phụ Kiện', '699.000VND', 'https://static.zara.net/assets/public/25ed/142e/2e284bc6a98d/713708f6775d/01011203330-e1/01011203330-e1.jpg?ts=1779264873469&w=579'),
(21, 'SET 2 VÒNG CỔ DÂY XÍCH VÀ DÂY DÙ PHỐI KIM SA', 'Phụ Kiện', '699.000 VND', 'https://static.zara.net/assets/public/98dc/f271/352248fe9049/49a05ca3d952/01856246630-e1/01856246630-e1.jpg?ts=1780059806747&w=395'),
(22, 'VÒNG CỔ XÍCH MAXI', 'Phụ Kiện', '799.000 VND', 'https://static.zara.net/assets/public/7388/c833/3555467c8af9/c75b0f1d0ef7/04548211303-e1/04548211303-e1.jpg?ts=1780059782437&w=395'),
(23, 'SET 3 VÒNG CỔ KẾT CƯỜM VÀ ĐÁ', 'Phụ Kiện', '999.000 VND', 'https://static.zara.net/assets/public/0866/6b53/a6c04bda8468/a7bc1386626b/01856113330-e1/01856113330-e1.jpg?ts=1773220612527&w=395'),
(24, 'VÒNG CỔ PHỐI NHIỀU MẢNH KIM LOẠI', 'Phụ Kiện', '899.000 VND', 'https://static.zara.net/assets/public/9a94/679e/c1a24b788314/688d957958cc/01049002881-e1/01049002881-e1.jpg?ts=1774017502980&w=395'),
(25, 'VÒNG CỔ DÂY THỪNG HÌNH RẮN', 'Phụ Kiện', '599.000 VND', 'https://static.zara.net/assets/public/5afd/5d98/f1124cc09ee5/0b60038616e8/04548204303-e1/04548204303-e1.jpg?ts=1779441150618&w=395'),
(26, 'SET 3 VÒNG CỔ XÍCH PHỐI ĐÁ VÀ CHARM', 'Phụ Kiện', '999.000 VND', 'https://static.zara.net/assets/public/86e0/e4a7/ddcd41eaaae8/c3c7f083c797/04548208303-e1/04548208303-e1.jpg?ts=1779205404833&w=395'),
(27, 'VÒNG CỔ DÂY THỪNG PHỐI ĐÁ ĐEO NHIỀU KIỂU', 'Phụ Kiện', '999.000 VND', 'https://static.zara.net/assets/public/268b/5152/184047468244/239bcb451294/04736076700-e1/04736076700-e1.jpg?ts=1772727540351&w=395');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) DEFAULT 'customer'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(1, 'admin', '123456', 'admin'),
(2, 'ngọc ánh', '123456', 'admin');

--
-- Indexes for dumped tables
--

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
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
