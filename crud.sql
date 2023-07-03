-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2023 at 11:35 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `crud`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id` varchar(2) NOT NULL,
  `nomor` varchar(13) DEFAULT NULL,
  `nama` varchar(30) DEFAULT NULL,
  `jenis_kelamin` char(2) DEFAULT NULL,
  `alamat` varchar(20) DEFAULT NULL,
  `no_hp` varchar(15) DEFAULT NULL,
  `tanggal_terdaftar` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id`, `nomor`, `nama`, `jenis_kelamin`, `alamat`, `no_hp`, `tanggal_terdaftar`) VALUES
('1', '02', 'Arie Pramudya', 'L', 'Jalan Kusuma', '081263547378', '2023-06-26'),
('3', '03', 'Ardhan Ferliandra', 'L', 'Jalan Kusuma', '085298675434', '2023-06-26');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id` varchar(2) NOT NULL,
  `kode` varchar(10) DEFAULT NULL,
  `kode_kategori` varchar(10) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `pengarang` varchar(100) DEFAULT NULL,
  `penerbit` varchar(100) DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `tanggal_input` date DEFAULT NULL,
  `harga` bigint(200) DEFAULT NULL,
  `file_cover` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id`, `kode`, `kode_kategori`, `judul`, `pengarang`, `penerbit`, `tahun`, `tanggal_input`, `harga`, `file_cover`) VALUES
('1', 'B010', '', '', '', '', 0000, '0000-00-00', 0, ''),
('2', 'B001', 'MGA', 'Doraemon vol 1', 'Fujiko F.Fujio', 'Shogakukan', 1970, '2023-06-19', 35000, 'Doraemon1.jpg'),
('3', 'B003', 'MNA', 'Lookism', 'Park Te Joon', 'Naver', 2014, '2023-06-19', 60000, 'Lookism1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` varchar(20) NOT NULL,
  `kode` varchar(20) DEFAULT NULL,
  `kategori` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kode`, `kategori`) VALUES
('1', '', ''),
('2', 'MCG', 'MNA'),
('3', 'MGA', 'Manga'),
('4', 'MNA', 'Manwha');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_detail`
--

CREATE TABLE `peminjaman_detail` (
  `id` varchar(2) NOT NULL,
  `id_peminjaman_master` varchar(2) DEFAULT NULL,
  `kode_buku` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman_detail`
--

INSERT INTO `peminjaman_detail` (`id`, `id_peminjaman_master`, `kode_buku`) VALUES
('1', '1', 'B001'),
('2', '2', 'B003');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_master`
--

CREATE TABLE `peminjaman_master` (
  `id` varchar(2) NOT NULL,
  `tanggal_peminjaman` date DEFAULT NULL,
  `nomor_anggota` varchar(13) DEFAULT NULL,
  `status_peminjaman` varchar(15) DEFAULT NULL,
  `tanggal_pengembalian` date DEFAULT NULL,
  `durasi_keterlambatan` int(15) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman_master`
--

INSERT INTO `peminjaman_master` (`id`, `tanggal_peminjaman`, `nomor_anggota`, `status_peminjaman`, `tanggal_pengembalian`, `durasi_keterlambatan`) VALUES
('1', '2023-07-03', '02', 'DIPINJAM', '2023-07-10', 1),
('2', '2023-07-03', '02', 'DIKEMBALIKAN', '2023-07-10', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nomor` (`nomor`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`),
  ADD KEY `kategori` (`kode_kategori`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode` (`kode`);

--
-- Indexes for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_buku` (`kode_buku`),
  ADD KEY `peminjaman` (`id_peminjaman_master`);

--
-- Indexes for table `peminjaman_master`
--
ALTER TABLE `peminjaman_master`
  ADD PRIMARY KEY (`id`),
  ADD KEY `anggota` (`nomor_anggota`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `buku`
--
ALTER TABLE `buku`
  ADD CONSTRAINT `kategori` FOREIGN KEY (`kode_kategori`) REFERENCES `kategori` (`kode`);

--
-- Constraints for table `peminjaman_detail`
--
ALTER TABLE `peminjaman_detail`
  ADD CONSTRAINT `buku` FOREIGN KEY (`kode_buku`) REFERENCES `buku` (`kode`),
  ADD CONSTRAINT `peminjaman` FOREIGN KEY (`id_peminjaman_master`) REFERENCES `peminjaman_master` (`id`);

--
-- Constraints for table `peminjaman_master`
--
ALTER TABLE `peminjaman_master`
  ADD CONSTRAINT `anggota` FOREIGN KEY (`nomor_anggota`) REFERENCES `anggota` (`nomor`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
