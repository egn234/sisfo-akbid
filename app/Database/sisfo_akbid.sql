-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2023 at 08:46 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sisfo_akbid`
--

-- --------------------------------------------------------

--
-- Table structure for table `rel_dos_matkul_koor`
--

CREATE TABLE `rel_dos_matkul_koor` (
  `id` int(11) NOT NULL,
  `dosenID` int(11) DEFAULT NULL,
  `matakuliahID` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rel_dsn_kls`
--

CREATE TABLE `rel_dsn_kls` (
  `id` int(11) NOT NULL,
  `dosenID` int(11) DEFAULT NULL,
  `kelasID` int(11) DEFAULT NULL,
  `flag` binary(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `rel_mhs_kls`
--

CREATE TABLE `rel_mhs_kls` (
  `id` int(11) NOT NULL,
  `mahasiswaID` int(11) DEFAULT NULL,
  `kelasID` int(11) DEFAULT NULL,
  `flag` binary(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id` int(11) NOT NULL,
  `nik` varchar(200) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `jenisKelamin` enum('L','P') NOT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id`, `nik`, `nama`, `jenisKelamin`, `alamat`, `email`, `kontak`, `foto`, `created_at`, `updated_at`, `userID`) VALUES
(1, '3407665915819326', 'John Doe', 'L', '50 Lakeview Ave,Tupper Lake, New York(NY), 12986', 'john@example.com', '(518) 359-9166', 'image.jpg', '2023-02-06 22:30:47', '2023-02-06 22:30:47', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_bap`
--

CREATE TABLE `tb_bap` (
  `id` int(11) NOT NULL,
  `mingguPertemuan` int(11) NOT NULL,
  `materiPertemuan` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `jadwalID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_dosen`
--

CREATE TABLE `tb_dosen` (
  `id` int(11) NOT NULL,
  `kodeDosen` varchar(100) NOT NULL,
  `nip` varchar(200) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `jenisKelamin` enum('L','P') NOT NULL,
  `nik` varchar(200) NOT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_dosen`
--

INSERT INTO `tb_dosen` (`id`, `kodeDosen`, `nip`, `nama`, `jenisKelamin`, `nik`, `alamat`, `email`, `kontak`, `foto`, `created_at`, `updated_at`, `userID`) VALUES
(1, 'KSZ', '28561910', 'Kristeen Suzanne', 'P', '8444274810044556', '3338 Wilson Rd, Oak Harbor, Washington(WA), 98277', 'kristeen@yahoo.com', '(360) 675-6289', 'image.jpg', '2023-02-06 22:40:05', '2023-02-06 22:40:05', 3);

-- --------------------------------------------------------

--
-- Table structure for table `tb_jadwal`
--

CREATE TABLE `tb_jadwal` (
  `id` int(11) NOT NULL,
  `startTime` time NOT NULL,
  `endTime` time NOT NULL,
  `day` enum('Senin','Selasa','Rabu','Kamis','Jumat','Sabtu') DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `flag` binary(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `matakuliahID` int(11) DEFAULT NULL,
  `dosenID` int(11) DEFAULT NULL,
  `ruanganID` int(11) DEFAULT NULL,
  `periodeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jawaban`
--

CREATE TABLE `tb_jawaban` (
  `id` int(11) NOT NULL,
  `jawaban` text NOT NULL,
  `flag` binary(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `pertanyaanID` int(11) DEFAULT NULL,
  `mahasiswaID` int(11) DEFAULT NULL,
  `periodeID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kehadiran`
--

CREATE TABLE `tb_kehadiran` (
  `id` int(11) NOT NULL,
  `status` enum('hadir','alfa','izin','sakit') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `mahasiswaID` int(11) DEFAULT NULL,
  `bapID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id` int(11) NOT NULL,
  `kodeKelas` varchar(6) NOT NULL,
  `angkatan` int(11) NOT NULL,
  `tahunAngkatan` int(4) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `flag` binary(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kuesioner`
--

CREATE TABLE `tb_kuesioner` (
  `id` int(11) NOT NULL,
  `judul_kuesioner` varchar(100) NOT NULL,
  `flag` binary(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_mahasiswa`
--

CREATE TABLE `tb_mahasiswa` (
  `id` int(11) NOT NULL,
  `nim` varchar(200) NOT NULL,
  `nama` varchar(75) NOT NULL,
  `jenisKelamin` enum('L','P') NOT NULL,
  `nik` varchar(16) NOT NULL,
  `tempatLahir` varchar(50) NOT NULL,
  `tanggalLahir` date NOT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kontak` varchar(20) DEFAULT NULL,
  `namaIbu` varchar(75) NOT NULL,
  `nikIbu` varchar(16) NOT NULL,
  `kontakIbu` varchar(20) DEFAULT NULL,
  `namaAyah` varchar(75) NOT NULL,
  `nikAyah` varchar(16) NOT NULL,
  `kontakAyah` varchar(20) DEFAULT NULL,
  `namaWali` varchar(75) DEFAULT NULL,
  `nikWali` varchar(16) DEFAULT NULL,
  `kontakWali` varchar(20) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `statusAkademik` enum('aktif','cuti','keluar','lulus','mangkir','meninggal','dropout') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `userID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_mahasiswa`
--

INSERT INTO `tb_mahasiswa` (`id`, `nim`, `nama`, `jenisKelamin`, `nik`, `tempatLahir`, `tanggalLahir`, `alamat`, `email`, `kontak`, `namaIbu`, `nikIbu`, `kontakIbu`, `namaAyah`, `nikAyah`, `kontakAyah`, `namaWali`, `nikWali`, `kontakWali`, `foto`, `statusAkademik`, `created_at`, `updated_at`, `deleted_at`, `userID`) VALUES
(1, '35837226781', 'Kim Jaxton', 'L', '1980066446538298', 'Bandung', '1996-02-08', '24441 State 76 Hwy\r\nBlanchard, Oklahoma(OK), 73010', 'kimjax@gmail.com', '(405) 344-7110', 'Brittani Mervin', '0', '(405) 344-7110', 'Kori Daniel', '0', '(405) 344-7110', NULL, '0', NULL, 'image.jpg', 'aktif', '2023-02-06 22:43:06', '2023-02-06 22:43:06', NULL, 2);

-- --------------------------------------------------------

--
-- Table structure for table `tb_matakuliah`
--

CREATE TABLE `tb_matakuliah` (
  `id` int(11) NOT NULL,
  `kodeMatkul` varchar(30) NOT NULL,
  `namaMatkul` varchar(200) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tingkat` int(1) NOT NULL DEFAULT 1,
  `semester` enum('ganjil','genap') NOT NULL DEFAULT 'ganjil',
  `sks` int(1) NOT NULL,
  `flag` binary(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai_matkul`
--

CREATE TABLE `tb_nilai_matkul` (
  `id` int(11) NOT NULL,
  `nilaiUTS` double NOT NULL,
  `nilaiUAS` double NOT NULL,
  `nilaiPraktek` double NOT NULL,
  `nilaiTugas` double NOT NULL,
  `nilaiKehadiran` double NOT NULL,
  `nilaiAkhir` double DEFAULT 0,
  `indeksNilai` enum('A','B','C','D','E') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `matakuliahID` int(11) DEFAULT NULL,
  `mahasiswaID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_param_nilai`
--

CREATE TABLE `tb_param_nilai` (
  `id` int(11) NOT NULL,
  `paramKehadiran` double NOT NULL,
  `paramUTS` double NOT NULL,
  `paramUAS` double NOT NULL,
  `paramTugas` double NOT NULL,
  `paramPraktek` double NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `koorID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_periode`
--

CREATE TABLE `tb_periode` (
  `id` int(11) NOT NULL,
  `tahunPeriode` varchar(9) NOT NULL,
  `semester` enum('ganjil','genap','pendek') DEFAULT 'ganjil',
  `deskripsi` text DEFAULT NULL,
  `flag` binary(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pertanyaan`
--

CREATE TABLE `tb_pertanyaan` (
  `id` int(11) NOT NULL,
  `pertanyaan` varchar(255) NOT NULL,
  `jenis_pertanyaan` enum('PG','Essay') DEFAULT NULL,
  `flag` binary(1) DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `kuesionerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_posting`
--

CREATE TABLE `tb_posting` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `attachment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` datetime DEFAULT NULL,
  `adminID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ruangan`
--

CREATE TABLE `tb_ruangan` (
  `id` int(11) NOT NULL,
  `kodeRuangan` varchar(30) NOT NULL,
  `namaRuangan` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `flag` binary(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `flag` enum('0','1') DEFAULT '1',
  `userType` enum('admin','mahasiswa','dosen') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`id`, `username`, `password`, `created_at`, `updated_at`, `flag`, `userType`) VALUES
(1, 'admin001', '$2y$12$xdn69QfrN9SIEYNummL6COvdDA/1qYfq5qtF8AwAM5dWtOApxIYlW', '2023-02-04 02:57:03', '2023-02-04 02:57:03', '1', 'admin'),
(2, 'mhs001', '$2y$12$zIUPCkkCAdhCMeefeRMc4eIEadMV2wobVGiomMVj9gBgLnaNvZDzO', '2023-02-04 02:57:03', '2023-02-06 23:46:42', '1', 'mahasiswa'),
(3, 'dosen001', '$2y$12$CnygMcBreSHXWSi/x4KWEuqIKjoPXfhWZ.hd9LQ2VM2VaL2PbGtqu', '2023-02-04 02:57:03', '2023-02-04 02:57:03', '1', 'dosen');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rel_dos_matkul_koor`
--
ALTER TABLE `rel_dos_matkul_koor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_koord_dos_1` (`dosenID`),
  ADD KEY `fk_koord_mat_1` (`matakuliahID`);

--
-- Indexes for table `rel_dsn_kls`
--
ALTER TABLE `rel_dsn_kls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kls_dsn_1` (`dosenID`),
  ADD KEY `fk_kls_dsn_2` (`kelasID`);

--
-- Indexes for table `rel_mhs_kls`
--
ALTER TABLE `rel_mhs_kls`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kls_mhs_1` (`mahasiswaID`),
  ADD KEY `fk_kls_mhs_2` (`kelasID`);

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_admin_key` (`userID`);

--
-- Indexes for table `tb_bap`
--
ALTER TABLE `tb_bap`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_bap_jad_1` (`jadwalID`);

--
-- Indexes for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_dosen_key` (`userID`);

--
-- Indexes for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_jad_matkul_1` (`matakuliahID`),
  ADD KEY `fk_jad_dos_1` (`dosenID`),
  ADD KEY `fk_jad_rua_1` (`ruanganID`),
  ADD KEY `fk_jad_per_1` (`periodeID`);

--
-- Indexes for table `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_ans_que_1` (`pertanyaanID`),
  ADD KEY `fk_ans_mhs_1` (`mahasiswaID`),
  ADD KEY `fk_ans_per_1` (`periodeID`);

--
-- Indexes for table `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_kehadiran_mhs_1` (`mahasiswaID`),
  ADD KEY `fk_kehadiran_bap_1` (`bapID`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_kuesioner`
--
ALTER TABLE `tb_kuesioner`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_mahasiwa_key` (`userID`);

--
-- Indexes for table `tb_matakuliah`
--
ALTER TABLE `tb_matakuliah`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_nilai_matkul`
--
ALTER TABLE `tb_nilai_matkul`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nilai_mhs_1` (`mahasiswaID`),
  ADD KEY `fk_nilai_mat_1` (`matakuliahID`);

--
-- Indexes for table `tb_param_nilai`
--
ALTER TABLE `tb_param_nilai`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_nilai_koord_1` (`koorID`);

--
-- Indexes for table `tb_periode`
--
ALTER TABLE `tb_periode`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_pertanyaan`
--
ALTER TABLE `tb_pertanyaan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_que_title_1` (`kuesionerID`);

--
-- Indexes for table `tb_posting`
--
ALTER TABLE `tb_posting`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_pos_adm_1` (`adminID`);

--
-- Indexes for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `rel_dos_matkul_koor`
--
ALTER TABLE `rel_dos_matkul_koor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rel_dsn_kls`
--
ALTER TABLE `rel_dsn_kls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rel_mhs_kls`
--
ALTER TABLE `rel_mhs_kls`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_bap`
--
ALTER TABLE `tb_bap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kuesioner`
--
ALTER TABLE `tb_kuesioner`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_matakuliah`
--
ALTER TABLE `tb_matakuliah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_nilai_matkul`
--
ALTER TABLE `tb_nilai_matkul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_param_nilai`
--
ALTER TABLE `tb_param_nilai`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_periode`
--
ALTER TABLE `tb_periode`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pertanyaan`
--
ALTER TABLE `tb_pertanyaan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_posting`
--
ALTER TABLE `tb_posting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_ruangan`
--
ALTER TABLE `tb_ruangan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rel_dos_matkul_koor`
--
ALTER TABLE `rel_dos_matkul_koor`
  ADD CONSTRAINT `fk_koord_dos_1` FOREIGN KEY (`dosenID`) REFERENCES `tb_dosen` (`id`),
  ADD CONSTRAINT `fk_koord_mat_1` FOREIGN KEY (`matakuliahID`) REFERENCES `tb_matakuliah` (`id`);

--
-- Constraints for table `rel_dsn_kls`
--
ALTER TABLE `rel_dsn_kls`
  ADD CONSTRAINT `fk_kls_dsn_1` FOREIGN KEY (`dosenID`) REFERENCES `tb_dosen` (`id`),
  ADD CONSTRAINT `fk_kls_dsn_2` FOREIGN KEY (`kelasID`) REFERENCES `tb_kelas` (`id`);

--
-- Constraints for table `rel_mhs_kls`
--
ALTER TABLE `rel_mhs_kls`
  ADD CONSTRAINT `fk_kls_mhs_1` FOREIGN KEY (`mahasiswaID`) REFERENCES `tb_mahasiswa` (`id`),
  ADD CONSTRAINT `fk_kls_mhs_2` FOREIGN KEY (`kelasID`) REFERENCES `tb_kelas` (`id`);

--
-- Constraints for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD CONSTRAINT `user_admin_key` FOREIGN KEY (`userID`) REFERENCES `tb_user` (`id`);

--
-- Constraints for table `tb_bap`
--
ALTER TABLE `tb_bap`
  ADD CONSTRAINT `fk_bap_jad_1` FOREIGN KEY (`jadwalID`) REFERENCES `tb_jadwal` (`id`);

--
-- Constraints for table `tb_dosen`
--
ALTER TABLE `tb_dosen`
  ADD CONSTRAINT `user_dosen_key` FOREIGN KEY (`userID`) REFERENCES `tb_user` (`id`);

--
-- Constraints for table `tb_jadwal`
--
ALTER TABLE `tb_jadwal`
  ADD CONSTRAINT `fk_jad_dos_1` FOREIGN KEY (`dosenID`) REFERENCES `tb_dosen` (`id`),
  ADD CONSTRAINT `fk_jad_matkul_1` FOREIGN KEY (`matakuliahID`) REFERENCES `tb_matakuliah` (`id`),
  ADD CONSTRAINT `fk_jad_per_1` FOREIGN KEY (`periodeID`) REFERENCES `tb_periode` (`id`),
  ADD CONSTRAINT `fk_jad_rua_1` FOREIGN KEY (`ruanganID`) REFERENCES `tb_ruangan` (`id`);

--
-- Constraints for table `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  ADD CONSTRAINT `fk_ans_mhs_1` FOREIGN KEY (`mahasiswaID`) REFERENCES `tb_mahasiswa` (`id`),
  ADD CONSTRAINT `fk_ans_per_1` FOREIGN KEY (`periodeID`) REFERENCES `tb_periode` (`id`),
  ADD CONSTRAINT `fk_ans_que_1` FOREIGN KEY (`pertanyaanID`) REFERENCES `tb_pertanyaan` (`id`);

--
-- Constraints for table `tb_kehadiran`
--
ALTER TABLE `tb_kehadiran`
  ADD CONSTRAINT `fk_kehadiran_bap_1` FOREIGN KEY (`bapID`) REFERENCES `tb_bap` (`id`),
  ADD CONSTRAINT `fk_kehadiran_mhs_1` FOREIGN KEY (`mahasiswaID`) REFERENCES `tb_mahasiswa` (`id`);

--
-- Constraints for table `tb_mahasiswa`
--
ALTER TABLE `tb_mahasiswa`
  ADD CONSTRAINT `user_mahasiwa_key` FOREIGN KEY (`userID`) REFERENCES `tb_user` (`id`);

--
-- Constraints for table `tb_nilai_matkul`
--
ALTER TABLE `tb_nilai_matkul`
  ADD CONSTRAINT `fk_nilai_mat_1` FOREIGN KEY (`matakuliahID`) REFERENCES `tb_matakuliah` (`id`),
  ADD CONSTRAINT `fk_nilai_mhs_1` FOREIGN KEY (`mahasiswaID`) REFERENCES `tb_mahasiswa` (`id`);

--
-- Constraints for table `tb_param_nilai`
--
ALTER TABLE `tb_param_nilai`
  ADD CONSTRAINT `fk_nilai_koord_1` FOREIGN KEY (`koorID`) REFERENCES `rel_dos_matkul_koor` (`id`);

--
-- Constraints for table `tb_pertanyaan`
--
ALTER TABLE `tb_pertanyaan`
  ADD CONSTRAINT `fk_que_title_1` FOREIGN KEY (`kuesionerID`) REFERENCES `tb_kuesioner` (`id`);

--
-- Constraints for table `tb_posting`
--
ALTER TABLE `tb_posting`
  ADD CONSTRAINT `fk_pos_adm_1` FOREIGN KEY (`adminID`) REFERENCES `tb_admin` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
