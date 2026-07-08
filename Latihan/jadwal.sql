-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 08, 2026 at 11:16 AM
-- Server version: 5.7.33
-- PHP Version: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jadwal2`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `Id_admin` int(11) NOT NULL,
  `Nama_lengkap` varchar(50) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `Password` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`Id_admin`, `Nama_lengkap`, `Username`, `Password`) VALUES
(2, 'Delpiah Wahyuningsih', 'admin', 12345),
(3, 'Muhammad Azka Nazhan', 'siswa', 12345),
(4, 'Udin Bengkel', 'guru', 12345);

-- --------------------------------------------------------

--
-- Table structure for table `detail_jadwal`
--

CREATE TABLE `detail_jadwal` (
  `Kd_jadwal` varchar(5) NOT NULL,
  `Kd_mapel` varchar(5) NOT NULL,
  `Hari` varchar(15) NOT NULL,
  `Jam` varchar(20) NOT NULL,
  `Kelas` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_jadwal`
--

INSERT INTO `detail_jadwal` (`Kd_jadwal`, `Kd_mapel`, `Hari`, `Jam`, `Kelas`) VALUES
('J-001', 'M-019', 'Sabtu', '12.30-14.00', 'XII A'),
('J-002', 'M-018', 'Senin', '08.00-10.00', 'XII A'),
('J-002', 'M-018', 'Selasa', '08.00-09.30', 'XII B'),
('J-002', 'M-018', 'Rabu', '10.30-12.00', 'XII A'),
('J-002', 'M-018', 'Kamis', '12.30-14.00', 'XII C'),
('J-002', 'M-018', 'Jumat', '10.30-12.00', 'XII B'),
('J-002', 'M-018', 'Sabtu', '08.00-10.00', 'XII C'),
('J-003', 'M-020', 'Senin', '08.00-10.00', 'XII A');

-- --------------------------------------------------------

--
-- Table structure for table `detail_kelas`
--

CREATE TABLE `detail_kelas` (
  `Id_jadwal` varchar(20) NOT NULL,
  `Kd_mapel` varchar(5) NOT NULL,
  `Kd_guru` varchar(5) NOT NULL,
  `Hari` varchar(15) NOT NULL,
  `Jam` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `detail_kelas`
--

INSERT INTO `detail_kelas` (`Id_jadwal`, `Kd_mapel`, `Kd_guru`, `Hari`, `Jam`) VALUES
('001', 'M-019', 'K-006', 'Selasa', '08.00-10.00'),
('002', 'M-018', 'K-004', 'Senin', '08.00-10.00'),
('002', 'M-014', 'K-006', 'Senin', '10.30-12.00'),
('003', 'M-019', 'K-006', 'Jumat', '10.30-12.00');

-- --------------------------------------------------------

--
-- Table structure for table `ekstra_2511500089`
--

CREATE TABLE `ekstra_2511500089` (
  `id_ekstra089` varchar(5) NOT NULL,
  `nama_ekstra089` varchar(50) NOT NULL,
  `ket089` varchar(20) NOT NULL,
  `semester089` int(5) NOT NULL,
  `thn_ajaran089` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ekstra_2511500089`
--

INSERT INTO `ekstra_2511500089` (`id_ekstra089`, `nama_ekstra089`, `ket089`, `semester089`, `thn_ajaran089`) VALUES
('E-003', 'futsal', 'hadir', 2, 2026);

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `Kd_guru` varchar(5) NOT NULL,
  `Nm_guru` varchar(50) NOT NULL,
  `Jenkel` varchar(10) NOT NULL,
  `Pend_terakhir` varchar(20) NOT NULL,
  `Hp` varchar(13) NOT NULL,
  `Alamat` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`Kd_guru`, `Nm_guru`, `Jenkel`, `Pend_terakhir`, `Hp`, `Alamat`) VALUES
('K-002', 'Sity', 'fmsofao', 'S1', '087457523954', 'Selindung'),
('K-003', 'eki', 'fmsofao', 'S3', '0004503495034', 'Gabek keren'),
('K-004', 'Dedi', 'fklfsdlf', 'S1', '0800323449443', 'Sungailiat'),
('K-006', 'bambang', 'dsslffk', 'S2', '5834545853405', 'apapun');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal`
--

CREATE TABLE `jadwal` (
  `Kd_jadwal` varchar(5) NOT NULL,
  `Kd_guru` varchar(5) NOT NULL,
  `Semester` enum('Ganjil','Genap') NOT NULL,
  `Tahun_ajaran` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal`
--

INSERT INTO `jadwal` (`Kd_jadwal`, `Kd_guru`, `Semester`, `Tahun_ajaran`) VALUES
('J-001', 'K-002', 'Ganjil', '2024-2025'),
('J-002', 'K-004', 'Ganjil', '2025-2026'),
('J-003', 'K-002', 'Ganjil', '2025-2026');

-- --------------------------------------------------------

--
-- Table structure for table `jadwal_kelas`
--

CREATE TABLE `jadwal_kelas` (
  `Id_jadwal` varchar(20) NOT NULL,
  `Id_kelas` int(11) NOT NULL,
  `Thn_ajaran` varchar(20) NOT NULL,
  `Semester` enum('Ganjil','Genap') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `jadwal_kelas`
--

INSERT INTO `jadwal_kelas` (`Id_jadwal`, `Id_kelas`, `Thn_ajaran`, `Semester`) VALUES
('001', 126, '2025-2026', 'Ganjil'),
('002', 126, '2025-2026', 'Ganjil'),
('003', 126, '2025-2026', 'Ganjil');

-- --------------------------------------------------------

--
-- Table structure for table `kelas`
--

CREATE TABLE `kelas` (
  `Id_kelas` int(11) NOT NULL,
  `Nm_kelas` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `kelas`
--

INSERT INTO `kelas` (`Id_kelas`, `Nm_kelas`) VALUES
(126, 'XII A'),
(127, 'XII B'),
(128, 'XII C');

-- --------------------------------------------------------

--
-- Table structure for table `mapel`
--

CREATE TABLE `mapel` (
  `Kd_mapel` varchar(5) NOT NULL,
  `Nm_mapel` varchar(35) NOT NULL,
  `Kkm` int(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `mapel`
--

INSERT INTO `mapel` (`Kd_mapel`, `Nm_mapel`, `Kkm`) VALUES
('M-014', 'Bahasa Inggris', 75),
('M-015', 'Bahasa Indonesia', 75),
('M-016', 'PJOK', 75),
('M-017', 'Agama', 80),
('M-018', 'MATEMATIKA', 65),
('M-019', 'PPKN', 70),
('M-020', 'Seni Budaya', 75);

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `Nis` varchar(10) NOT NULL,
  `Nm_siswa` varchar(50) NOT NULL,
  `Jenkel` varchar(10) NOT NULL,
  `Hp` varchar(13) NOT NULL,
  `Id_kelas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`Nis`, `Nm_siswa`, `Jenkel`, `Hp`, `Id_kelas`) VALUES
('S-001', 'Farhel', 'XII', '087457523954', 128);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id_user`, `username`, `password`, `role`) VALUES
(1, 'Dephiah Wahyuningsih', '1234', 'admin'),
(4, 'Budi', '1234', 'guru'),
(12, '2511500089', '1234', 'admin'),
(13, 'Farhel', '1234', 'siswa');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`Id_admin`);

--
-- Indexes for table `ekstra_2511500089`
--
ALTER TABLE `ekstra_2511500089`
  ADD PRIMARY KEY (`id_ekstra089`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`Kd_guru`);

--
-- Indexes for table `jadwal`
--
ALTER TABLE `jadwal`
  ADD PRIMARY KEY (`Kd_jadwal`);

--
-- Indexes for table `jadwal_kelas`
--
ALTER TABLE `jadwal_kelas`
  ADD PRIMARY KEY (`Id_jadwal`);

--
-- Indexes for table `kelas`
--
ALTER TABLE `kelas`
  ADD PRIMARY KEY (`Id_kelas`);

--
-- Indexes for table `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`Kd_mapel`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`Nis`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `Id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
