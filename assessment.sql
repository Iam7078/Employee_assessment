-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2024 at 03:09 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `assessment`
--

-- --------------------------------------------------------

--
-- Table structure for table `assessment_category`
--

CREATE TABLE `assessment_category` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `status` int(11) NOT NULL,
  `category` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessment_category`
--

INSERT INTO `assessment_category` (`id`, `year`, `status`, `category`, `weight`) VALUES
(1, 2024, 1, 'INTERPERSONAL SKILLS', 20),
(2, 2024, 2, 'KUALITAS KEPRIBADIAN', 10),
(3, 2024, 3, 'KEAHLIAN TEKNIS', 20),
(4, 2024, 4, 'TARGET DEPARTEMEN', 50);

-- --------------------------------------------------------

--
-- Table structure for table `assessment_department_target`
--

CREATE TABLE `assessment_department_target` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `status` int(11) NOT NULL,
  `status_detail` int(11) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `parameter` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `assessment_parameter`
--

CREATE TABLE `assessment_parameter` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `status` int(11) NOT NULL,
  `status_detail` int(11) NOT NULL,
  `parameter` varchar(255) NOT NULL,
  `remark` varchar(255) NOT NULL,
  `weight` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assessment_parameter`
--

INSERT INTO `assessment_parameter` (`id`, `year`, `status`, `status_detail`, `parameter`, `remark`, `weight`) VALUES
(1, 2024, 2, 1, 'TINGKAT KEHADIRAN', '-', 2),
(2, 2024, 1, 1, 'KEPEMIMPINAN', 'Kemampuan menggunakan kewenangan untuk mempengaruhi, mengarahkan, memotivasi, dan mendidik untuk memaksimalkan sumber daya yang dimiliki dalam rangka mencapai tujuan perusahaan', 5),
(3, 2024, 1, 2, 'INDEPENDENSI & INISIATIF', 'Kemampuan bekerja secara profesional meskipun tidak diawasi langsung oleh pimpinan\nKemampuan menemukan cara baru untuk mempermudan dan mempercepat pekerjaan', 3),
(4, 2024, 1, 3, 'KERJASAMA TIM', 'Kemampuan bekerjasama secara internal departemen maupun eksternal departemen sehubungan dengan kelancaran proses pekerjaan', 3),
(5, 2024, 1, 4, 'PEMECAHAN MASALAH', 'Kemampuan mengidentifikasi dan menganalisis masalah, mengemukakan alternatif-alternatif penyelesaiaan serta kemampuan menentukan cara penyelesaian paling efektif dan efisien', 3),
(6, 2024, 1, 5, 'HUBUNGAN DENGAN PELANGGAN', 'Pemahaman tentang pentingnya pelanggan serta kualitas pelayanan terhadap pelanggan', 3),
(7, 2024, 1, 6, 'PERILAKU', 'Antusiasme, keinginan, dan motivasi untuk maju dan berkembang', 3),
(8, 2024, 2, 2, 'KETEPATAN WAKTU', '-', 2),
(9, 2024, 2, 3, 'HUBUNGAN DENGAN ATASAN', '-', 2),
(10, 2024, 2, 4, 'HUBUNGAN ANTAR REKAN KERJA', '-', 2),
(11, 2024, 2, 5, 'HUBUNGAN DENGAN PROSES BERIKUTNYA', '-', 2),
(12, 2024, 3, 1, 'PRODUKTIVITAS', 'Ketepatan waktu dan hasil kerja', 5),
(13, 2024, 3, 2, 'KUALITAS KERJA', 'Akurasi, ketelitian, dan konsistensi dalam penyelesaian tugas yang diberikan', 5),
(14, 2024, 3, 3, 'WAWASAN KERJA', 'Memiliki keahlian dan pengetahuan untuk memenuhi standar yang telah ditentukan', 4),
(15, 2024, 3, 4, 'DAYA PAHAM', 'Kemampuan belajar, menyerap konsep yang esensial bagi pekerjaan, dan mengikuti instruksi', 3),
(16, 2024, 3, 5, 'ORGANISASI', 'Kemampuan menangani banyak proyek secara bersamaan, menyusun skala prioritas tugas dan menyelesaikannya sesuai jadwal', 3);

-- --------------------------------------------------------

--
-- Table structure for table `employee_account`
--

CREATE TABLE `employee_account` (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `user_id` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_account`
--

INSERT INTO `employee_account` (`id`, `user_name`, `user_id`, `role`, `email`, `password`) VALUES
(1, 'Admin Assessment', '7078', 'admin', 'adminassessment@gmail.com', 'admintimw1'),
(2, 'KAZUNARI HIROSE', '001', 'leader', 'kazunarihirose1@gmail.com', 'kazunari1'),
(3, 'TADASHI MIYAMOTO', '002', 'leader', 'tadashimiyamoto2@gmail.com', 'tadashi2'),
(4, 'SENIOR GM', '003', 'seniorGm', 'seniorgmtimw@gmail.com', 'seniorGMtimw3'),
(5, 'RAHMASARI', '20120700002', 'leader', '20120700002@gmail.com', '20120700002'),
(6, 'AGOES KARTIKA ADI', '20120800003', 'leader', '20120800003@gmail.com', '20120800003'),
(7, 'SUNARTI', '20120900005', 'employee', '20120900005@gmail.com', '20120900005'),
(8, 'JOKO CAHYONO', '20120900006', 'employee', '20120900006@gmail.com', '20120900006'),
(9, 'KISWANTO', '20121100007', 'employee', '20121100007@gmail.com', '20121100007'),
(10, 'MUHAMMAD ZAINAL ARIFIN', '20121100008', 'employee', '20121100008@gmail.com', '20121100008'),
(11, 'RETNO SETYORINI PAMUNGKAS', '20121200009', 'employee', '20121200009@gmail.com', '20121200009'),
(12, 'TATIK SUTARTI', '20121200010', 'leader', '20121200010@gmail.com', '20121200010'),
(13, 'ERNAWATI A', '20121200014', 'employee', '20121200014@gmail.com', '20121200014'),
(14, 'UMIYATUN', '20121200015', 'employee', '20121200015@gmail.com', '20121200015'),
(15, 'SITI ANDRIYANI', '20121200016', 'employee', '20121200016@gmail.com', '20121200016'),
(16, 'TASMIYATI', '20121200020', 'employee', '20121200020@gmail.com', '20121200020'),
(17, 'SRI RAHAYU A', '20121200035', 'employee', '20121200035@gmail.com', '20121200035'),
(18, 'ANIS PUJI MINDARNI', '20121200037', 'employee', '20121200037@gmail.com', '20121200037'),
(19, 'SURATI', '20121200038', 'employee', '20121200038@gmail.com', '20121200038'),
(20, 'MUHAMMAT YASIN', '20121200042', 'leader', '20121200042@gmail.com', '20121200042'),
(21, 'TUMIYATI', '20121200043', 'employee', '20121200043@gmail.com', '20121200043'),
(22, 'JARMI', '20121200050', 'employee', '20121200050@gmail.com', '20121200050'),
(23, 'FINDA MUSTIKANINGRUM', '20121200056', 'employee', '20121200056@gmail.com', '20121200056'),
(24, 'MARGA NAWANG YUNITANINGRUM', '20121200064', 'employee', '20121200064@gmail.com', '20121200064'),
(25, 'RETNO HANDAYANI', '20130100083', 'leader', '20130100083@gmail.com', '20130100083'),
(26, 'TRI SUHESTI INDRA IBAWATI', '20130300090', 'employee', '20130300090@gmail.com', '20130300090'),
(27, 'NGATENI', '20130300093', 'employee', '20130300093@gmail.com', '20130300093'),
(28, 'ELIK MAHYI DANI', '20130300102', 'employee', '20130300102@gmail.com', '20130300102'),
(29, 'PUTRI OKTA AYUNINGTYAS', '20130300139', 'employee', '20130300139@gmail.com', '20130300139'),
(30, 'YUMROTUN ', '20130400188', 'employee', '20130400188@gmail.com', '20130400188'),
(31, 'RETNO WINDARTI ', '20130400205', 'employee', '20130400205@gmail.com', '20130400205'),
(32, 'WAHYUNING', '20130400212', 'leader', '20130400212@gmail.com', '20130400212'),
(33, 'MOHAMAD RIDWAN', '20130400305', 'employee', '20130400305@gmail.com', '20130400305'),
(34, 'RAGIL MARGI RAHAYU', '20130400353', 'employee', '20130400353@gmail.com', '20130400353'),
(35, 'TUGINI', '20130500430', 'employee', '20130500430@gmail.com', '20130500430'),
(36, 'WAHYU FERDIANSYAH', '20130500445', 'employee', '20130500445@gmail.com', '20130500445'),
(37, 'PERANANDARI', '20130500453', 'employee', '20130500453@gmail.com', '20130500453'),
(38, 'RIANA LISTIAWATI', '20130500489', 'employee', '20130500489@gmail.com', '20130500489'),
(39, 'INDRIAWATI AGUSTINA', '20130500491', 'employee', '20130500491@gmail.com', '20130500491'),
(40, 'AMBAR WAHYUNINGSIH', '20130600519', 'employee', '20130600519@gmail.com', '20130600519'),
(41, 'WAHONO', '20130600543', 'employee', '20130600543@gmail.com', '20130600543'),
(42, 'ARI SETYANINGSIH', '20130600548', 'employee', '20130600548@gmail.com', '20130600548'),
(43, 'SITI UMARIYAH', '20130700611', 'employee', '20130700611@gmail.com', '20130700611'),
(44, 'IKA NOVITASARI', '20130800669', 'employee', '20130800669@gmail.com', '20130800669'),
(45, 'RULIYAH', '20130800711', 'employee', '20130800711@gmail.com', '20130800711'),
(46, 'NOVIA DESI KRISNAWATI', '20130900734', 'employee', '20130900734@gmail.com', '20130900734'),
(47, 'ROUDHOTUL HUDA', '20130900877', 'employee', '20130900877@gmail.com', '20130900877'),
(48, 'ANI RACHMAWATI', '20130900978', 'employee', '20130900978@gmail.com', '20130900978'),
(49, 'TRI HARYANI', '20131000998', 'employee', '20131000998@gmail.com', '20131000998'),
(50, 'NUR KHAYATI A', '20131001068', 'employee', '20131001068@gmail.com', '20131001068'),
(51, 'NUR KHOMARIYAH', '20131001069', 'employee', '20131001069@gmail.com', '20131001069'),
(52, 'MULYADI', '20131001077', 'employee', '20131001077@gmail.com', '20131001077'),
(53, 'ANGGUN MEI HERSANDI', '20131101107', 'employee', '20131101107@gmail.com', '20131101107'),
(54, 'SENI PURWANTI', '20131101113', 'employee', '20131101113@gmail.com', '20131101113'),
(55, 'VINCENTIA GAYATRI GALUH L S', '20131201157', 'employee', '20131201157@gmail.com', '20131201157'),
(56, 'ALFIYANI', '20140201457', 'employee', '20140201457@gmail.com', '20140201457'),
(57, 'AGUS SALEH ALVAN', '20140201471', 'employee', '20140201471@gmail.com', '20140201471'),
(58, 'MULYANINGRUM', '20140301524', 'employee', '20140301524@gmail.com', '20140301524'),
(59, 'CHOIRUNNISA', '20140301605', 'employee', '20140301605@gmail.com', '20140301605'),
(60, 'YUNANIK A', '20140301630', 'employee', '20140301630@gmail.com', '20140301630'),
(61, 'SETI PRIHATIN', '20140301671', 'employee', '20140301671@gmail.com', '20140301671'),
(62, 'RETNO ANDRIYANI', '20140401793', 'employee', '20140401793@gmail.com', '20140401793'),
(63, 'ROFIAH', '20140501901', 'employee', '20140501901@gmail.com', '20140501901'),
(64, 'FADHILAH ARUM MERNAYATI', '20140601986', 'employee', '20140601986@gmail.com', '20140601986'),
(65, 'MUNDAYATI', '20140802067', 'employee', '20140802067@gmail.com', '20140802067'),
(66, 'KURNIAWATI BUDI UTAMI', '20140902126', 'employee', '20140902126@gmail.com', '20140902126'),
(67, 'SRI WIGATI', '20140902135', 'employee', '20140902135@gmail.com', '20140902135'),
(68, 'LAILA IKA ANGGRAINI', '20141002267', 'employee', '20141002267@gmail.com', '20141002267'),
(69, 'SUSIYANTI', '20150202395', 'employee', '20150202395@gmail.com', '20150202395'),
(70, 'ARIYANI', '20150402544', 'employee', '20150402544@gmail.com', '20150402544'),
(71, 'NOVIA NINGSIH', '20150402567', 'employee', '20150402567@gmail.com', '20150402567'),
(72, 'TEGUH YUWONO', '20150502642', 'employee', '20150502642@gmail.com', '20150502642'),
(73, 'SULIS SUTYONO', '20150502678', 'employee', '20150502678@gmail.com', '20150502678'),
(74, 'ERNAWATI APRILIA', '20150602787', 'leader', '20150602787@gmail.com', '20150602787'),
(75, 'BAMBANG TRIADI', '20150602851', 'employee', '20150602851@gmail.com', '20150602851'),
(76, 'UCIK PRIHATINI', '20150803120', 'employee', '20150803120@gmail.com', '20150803120'),
(77, 'FITRI AYU INDRIYANTI', '20150803121', 'employee', '20150803121@gmail.com', '20150803121'),
(78, 'DENOK RATNA SARI', '20150903183', 'employee', '20150903183@gmail.com', '20150903183'),
(79, 'NURUL UMIYATI', '20150903240', 'employee', '20150903240@gmail.com', '20150903240'),
(80, 'SRI ASTUTIK', '20151003275', 'employee', '20151003275@gmail.com', '20151003275'),
(81, 'SUKENI', '20151003309', 'employee', '20151003309@gmail.com', '20151003309'),
(82, 'SLAMET DWI LESTARI', '20151203488', 'employee', '20151203488@gmail.com', '20151203488'),
(83, 'LITA WIDIYANTI', '20160103512', 'employee', '20160103512@gmail.com', '20160103512'),
(84, 'ELYAS NUGROHO', '20160103539', 'employee', '20160103539@gmail.com', '20160103539'),
(85, 'BUSROL KARIM', '20160103540', 'employee', '20160103540@gmail.com', '20160103540'),
(86, 'PRIHATI SRI MULYANINGSIH', '20160203652', 'employee', '20160203652@gmail.com', '20160203652'),
(87, 'DANI YULIYANI', '20160303755', 'employee', '20160303755@gmail.com', '20160303755'),
(88, 'RUHIYATUL PARHI', '20160403844', 'employee', '20160403844@gmail.com', '20160403844'),
(89, 'AYUK SETYANINGRUM', '20161004276', 'employee', '20161004276@gmail.com', '20161004276'),
(90, 'MUZAZANAH', '20161204428', 'employee', '20161204428@gmail.com', '20161204428'),
(91, 'RIA WIDYASTUTI', '20170104514', 'employee', '20170104514@gmail.com', '20170104514'),
(92, 'BINTI RO\'IKHANATIN', '20170204534', 'employee', '20170204534@gmail.com', '20170204534'),
(93, 'YULIASARI', '20170804725', 'employee', '20170804725@gmail.com', '20170804725'),
(94, 'SHARA MONICA CACILIA', '20171004819', 'employee', '20171004819@gmail.com', '20171004819'),
(95, 'ALFIYAH B', '20171004856', 'leader', '20171004856@gmail.com', '20171004856'),
(96, 'AMALIA THAHIRA', '20171104961', 'employee', '20171104961@gmail.com', '20171104961'),
(97, 'DIAN CAHYANI', '20180705460', 'employee', '20180705460@gmail.com', '20180705460'),
(98, 'YUYUN ISMAWATI', '20180805503', 'employee', '20180805503@gmail.com', '20180805503'),
(99, 'DELLA NOVITA', '20180805505', 'employee', '20180805505@gmail.com', '20180805505'),
(100, 'ISNANDA LAILA QORIDA SAPUTRI', '20180805508', 'employee', '20180805508@gmail.com', '20180805508'),
(101, 'ANNISYA VEGA SORAYA', '20180805529', 'employee', '20180805529@gmail.com', '20180805529'),
(102, 'DIAN ANGGRAENI SUTADI PUTRI', '20210706940', 'employee', '20210706940@gmail.com', '20210706940'),
(103, 'LIDIA ERNANDA', '20210906971', 'employee', '20210906971@gmail.com', '20210906971'),
(104, 'WULAN SEPTIYORINI', '20211006988', 'employee', '20211006988@gmail.com', '20211006988'),
(105, 'TOMY AFRIYANTO', '20220306995', 'employee', '20220306995@gmail.com', '20220306995'),
(106, 'RESTIANA', '20220506996', 'employee', '20220506996@gmail.com', '20220506996'),
(107, 'RITA YULIYANI', '20220607026', 'employee', '20220607026@gmail.com', '20220607026'),
(108, 'DWI VERA HANDAYANI', '20220607127', 'employee', '20220607127@gmail.com', '20220607127'),
(109, 'OKTAVIA INDRIYANI', '20220707140', 'employee', '20220707140@gmail.com', '20220707140'),
(110, 'CICILIA SEPTINA', '20220707145', 'employee', '20220707145@gmail.com', '20220707145'),
(111, 'NURYATI', '20220707146', 'employee', '20220707146@gmail.com', '20220707146'),
(112, 'RINA ANGGRAENI', '20220707147', 'employee', '20220707147@gmail.com', '20220707147'),
(113, 'DEWI FITRIYAWATIK', '20220707152', 'employee', '20220707152@gmail.com', '20220707152'),
(114, 'YENI LANTARI', '20220807153', 'employee', '20220807153@gmail.com', '20220807153'),
(115, 'KHOIRUR ROZIKIN', '20220807154', 'employee', '20220807154@gmail.com', '20220807154'),
(116, 'INDRA HIMAWAN FIKRI', '20220907155', 'employee', '20220907155@gmail.com', '20220907155'),
(117, 'NURRI WIDIANINGSIH', '20220907177', 'employee', '20220907177@gmail.com', '20220907177'),
(118, 'SRI INDRAYANI', '20220907179', 'employee', '20220907179@gmail.com', '20220907179'),
(119, 'DEWI KURNIAWATI', '20221007182', 'employee', '20221007182@gmail.com', '20221007182'),
(120, 'HENI MUKASIH', '20230207186', 'employee', '20230207186@gmail.com', '20230207186'),
(121, 'NURYANTI', '20230207187', 'employee', '20230207187@gmail.com', '20230207187'),
(122, 'RITA PUJIATI', '20230207188', 'employee', '20230207188@gmail.com', '20230207188'),
(123, 'PAULUS BAMBANG KUSMARTONO', '20230507190', 'employee', '20230507190@gmail.com', '20230507190'),
(124, 'JARIYAH', '20230607191', 'employee', '20230607191@gmail.com', '20230607191'),
(125, 'NOVIAN TEDI PRATAMA', '20230607193', 'employee', '20230607193@gmail.com', '20230607193'),
(126, 'DWI NOVIANI', '20230707199', 'employee', '20230707199@gmail.com', '20230707199'),
(127, 'ELIYTA PRAMESDA VALENT', '20231007411', 'employee', '20231007411@gmail.com', '20231007411'),
(128, 'KINANTI AYU ASHARI', '20231007412', 'employee', '20231007412@gmail.com', '20231007412'),
(129, 'ENDAH SUPARTI', '20231007414', 'employee', '20231007414@gmail.com', '20231007414'),
(130, 'LAURENTINA LARASATI', '20231007416', 'employee', '20231007416@gmail.com', '20231007416');

-- --------------------------------------------------------

--
-- Table structure for table `employee_detail`
--

CREATE TABLE `employee_detail` (
  `id` int(11) NOT NULL,
  `employee_name` varchar(255) NOT NULL,
  `employee_id` varchar(255) NOT NULL,
  `department` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `direct_leader` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `employee_detail`
--

INSERT INTO `employee_detail` (`id`, `employee_name`, `employee_id`, `department`, `unit`, `direct_leader`) VALUES
(1, 'RAHMASARI', '20120700002', 'PPIC', 'PPIC 1', 'KAZUNARI HIROSE'),
(2, 'AGOES KARTIKA ADI', '20120800003', 'HRD', 'GA', 'TADASHI MIYAMOTO'),
(3, 'SUNARTI', '20120900005', 'CAD/CAM', 'SAMPLE', 'RAHMASARI'),
(4, 'JOKO CAHYONO', '20120900006', 'PACKING', 'LEADER', 'ALFIYAH'),
(5, 'KISWANTO', '20121100007', 'CAD/CAM', 'MARKER', 'RAHMASARI'),
(6, 'MUHAMMAD ZAINAL ARIFIN', '20121100008', 'PACKING', 'STAFF', 'RAHMASARI'),
(7, 'RETNO SETYORINI PAMUNGKAS', '20121200009', 'HRD', 'ATTENDANCE', 'AGOES KARTIKA ADI'),
(8, 'TATIK SUTARTI', '20121200010', 'ACCOUNTING', 'ASST. MANAGER', 'AGOES KARTIKA ADI'),
(9, 'ERNAWATI A', '20121200014', 'SEWING', 'LEADER', 'WAHYUNING'),
(10, 'UMIYATUN', '20121200015', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(11, 'SITI ANDRIYANI', '20121200016', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(12, 'TASMIYATI', '20121200020', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(13, 'SRI RAHAYU A', '20121200035', 'CUTTING', 'LEADER', 'RAHMASARI'),
(14, 'ANIS PUJI MINDARNI', '20121200037', 'CUTTING', 'LEADER', 'RAHMASARI'),
(15, 'SURATI', '20121200038', 'FINISHING', 'LEADER', 'ALFIYAH'),
(16, 'MUHAMMAT YASIN', '20121200042', 'MECHANICS', 'SEWING MECHANICS', 'KAZUNARI HIROSE'),
(17, 'TUMIYATI', '20121200043', 'FINISHING', 'LEADER', 'ALFIYAH'),
(18, 'JARMI', '20121200050', 'FINISHING', 'LEADER', 'ALFIYAH'),
(19, 'FINDA MUSTIKANINGRUM', '20121200056', 'CUTTING', 'LEADER', 'RAHMASARI'),
(20, 'MARGA NAWANG YUNITANINGRUM', '20121200064', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(21, 'RETNO HANDAYANI', '20130100083', 'QC', 'MANAGER', 'KAZUNARI HIROSE'),
(22, 'TRI SUHESTI INDRA IBAWATI', '20130300090', 'CAD/CAM', 'SUPERVISOR', 'WAHYUNING'),
(23, 'NGATENI', '20130300093', 'FINISHING', 'LEADER', 'ALFIYAH'),
(24, 'ELIK MAHYI DANI', '20130300102', 'SEWING', 'LEADER', 'WAHYUNING'),
(25, 'PUTRI OKTA AYUNINGTYAS', '20130300139', 'QC', 'SUPERVISOR', 'RETNO HANDAYANI'),
(26, 'YUMROTUN ', '20130400188', 'FINISHING', 'SUPERVISOR', 'ALFIYAH'),
(27, 'RETNO WINDARTI ', '20130400205', 'QC', 'SUPERVISOR', 'RETNO HANDAYANI'),
(28, 'WAHYUNING', '20130400212', 'SEWING', 'MANAGER', 'KAZUNARI HIROSE'),
(29, 'MOHAMAD RIDWAN', '20130400305', 'WAREHOUSE', 'LEADER', 'RAHMASARI'),
(30, 'RAGIL MARGI RAHAYU', '20130400353', 'QC', 'ADM', 'RETNO HANDAYANI'),
(31, 'TUGINI', '20130500430', 'SEWING', 'LEADER', 'WAHYUNING'),
(32, 'WAHYU FERDIANSYAH', '20130500445', 'TRANSLATOR', 'STAFF', 'KAZUNARI HIROSE'),
(33, 'PERANANDARI', '20130500453', 'PURCHASING', 'STAFF', 'AGOES KARTIKA ADI'),
(34, 'RIANA LISTIAWATI', '20130500489', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(35, 'INDRIAWATI AGUSTINA', '20130500491', 'ACCOUNTING', 'ACCOUNTING', 'TATIK SUTARTI'),
(36, 'AMBAR WAHYUNINGSIH', '20130600519', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(37, 'WAHONO', '20130600543', 'MECHANICS', 'SEWING MECHANICS', 'MUHAMMAT YASIN'),
(38, 'ARI SETYANINGSIH', '20130600548', 'SEWING', 'LEADER', 'WAHYUNING'),
(39, 'SITI UMARIYAH', '20130700611', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(40, 'IKA NOVITASARI', '20130800669', 'SEWING', 'SUPERVISOR', 'WAHYUNING'),
(41, 'RULIYAH', '20130800711', 'FINISHING', 'LEADER', 'ALFIYAH'),
(42, 'NOVIA DESI KRISNAWATI', '20130900734', 'PACKING', 'SUPERVISOR', 'ALFIYAH'),
(43, 'ROUDHOTUL HUDA', '20130900877', 'MECHANICS', 'ELECTRICAL', 'AGOES KARTIKA ADI'),
(44, 'ANI RACHMAWATI', '20130900978', 'SEWING', 'LEADER', 'WAHYUNING'),
(45, 'TRI HARYANI', '20131000998', 'PANTRY', 'STAFF', 'AGOES KARTIKA ADI'),
(46, 'NUR KHAYATI A', '20131001068', 'SEWING', 'LEADER', 'WAHYUNING'),
(47, 'NUR KHOMARIYAH', '20131001069', 'SEWING', 'LEADER', 'WAHYUNING'),
(48, 'MULYADI', '20131001077', 'SEWING', 'GM', 'KAZUNARI HIROSE'),
(49, 'ANGGUN MEI HERSANDI', '20131101107', 'MECHANICS', 'SEWING MECHANICS', 'MUHAMMAT YASIN'),
(50, 'SENI PURWANTI', '20131101113', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(51, 'VINCENTIA GAYATRI GALUH L S', '20131201157', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(52, 'ALFIYANI', '20140201457', 'SEWING', 'LEADER', 'WAHYUNING'),
(53, 'AGUS SALEH ALVAN', '20140201471', 'MECHANICS', 'SEWING MECHANICS', 'MUHAMMAT YASIN'),
(54, 'MULYANINGRUM', '20140301524', 'FINISHING', 'LEADER', 'ALFIYAH'),
(55, 'CHOIRUNNISA', '20140301605', 'NURSE', 'STAFF', 'AGOES KARTIKA ADI'),
(56, 'YUNANIK A', '20140301630', 'SEWING', 'ASST. MANAGER', 'WAHYUNING'),
(57, 'SETI PRIHATIN', '20140301671', 'FINISHING', 'LEADER', 'ALFIYAH'),
(58, 'RETNO ANDRIYANI', '20140401793', 'HRD', 'PAYROLL', 'AGOES KARTIKA ADI'),
(59, 'ROFIAH', '20140501901', 'SEWING', 'LEADER', 'WAHYUNING'),
(60, 'FADHILAH ARUM MERNAYATI', '20140601986', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(61, 'MUNDAYATI', '20140802067', 'SEWING', 'LEADER', 'WAHYUNING'),
(62, 'KURNIAWATI BUDI UTAMI', '20140902126', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(63, 'SRI WIGATI', '20140902135', 'SEWING', 'SUPERVISOR', 'WAHYUNING'),
(64, 'LAILA IKA ANGGRAINI', '20141002267', 'PPIC', 'PPIC 2', 'ALFIYAH'),
(65, 'SUSIYANTI', '20150202395', 'SEWING', 'LEADER', 'WAHYUNING'),
(66, 'ARIYANI', '20150402544', 'WAREHOUSE', 'LEADER', 'RAHMASARI'),
(67, 'NOVIA NINGSIH', '20150402567', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(68, 'TEGUH YUWONO', '20150502642', 'CUTTING', 'SUPERVISOR', 'RAHMASARI'),
(69, 'SULIS SUTYONO', '20150502678', 'MECHANICS', 'SEWING MECHANICS', 'MUHAMMAT YASIN'),
(70, 'ERNAWATI APRILIA', '20150602787', 'HRD', 'COMPLIANCE', 'AGOES KARTIKA ADI'),
(71, 'BAMBANG TRIADI', '20150602851', 'SECURITY', 'KEPALA SECURITY', 'AGOES KARTIKA ADI'),
(72, 'UCIK PRIHATINI', '20150803120', 'SEWING', 'SUPERVISOR', 'WAHYUNING'),
(73, 'FITRI AYU INDRIYANTI', '20150803121', 'PPIC', 'PPIC 2', 'ALFIYAH'),
(74, 'DENOK RATNA SARI', '20150903183', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(75, 'NURUL UMIYATI', '20150903240', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(76, 'SRI ASTUTIK', '20151003275', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(77, 'SUKENI', '20151003309', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(78, 'SLAMET DWI LESTARI', '20151203488', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(79, 'LITA WIDIYANTI', '20160103512', 'PURCHASING', 'STAFF', 'AGOES KARTIKA ADI'),
(80, 'ELYAS NUGROHO', '20160103539', 'MECHANICS', 'SEWING MECHANICS', 'MUHAMMAT YASIN'),
(81, 'BUSROL KARIM', '20160103540', 'MECHANICS', 'SEWING MECHANICS', 'MUHAMMAT YASIN'),
(82, 'PRIHATI SRI MULYANINGSIH', '20160203652', 'SEWING', 'LEADER', 'WAHYUNING'),
(83, 'DANI YULIYANI', '20160303755', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(84, 'RUHIYATUL PARHI', '20160403844', 'SEWING', 'LEADER', 'WAHYUNING'),
(85, 'AYUK SETYANINGRUM', '20161004276', 'QC', 'LEADER', 'RETNO HANDAYANI'),
(86, 'MUZAZANAH', '20161204428', 'SEWING', 'LEADER', 'WAHYUNING'),
(87, 'RIA WIDYASTUTI', '20170104514', 'SEWING', 'LEADER', 'WAHYUNING'),
(88, 'BINTI RO\'IKHANATIN', '20170204534', 'HRD', 'RECRUITMENT', 'AGOES KARTIKA ADI'),
(89, 'YULIASARI', '20170804725', 'NURSE', 'STAFF', 'AGOES KARTIKA ADI'),
(90, 'SHARA MONICA CACILIA', '20171004819', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(91, 'ALFIYAH B', '20171004856', 'PPIC', 'PPIC 2', 'KAZUNARI HIROSE'),
(92, 'AMALIA THAHIRA', '20171104961', 'PURCHASING', 'STAFF', 'AGOES KARTIKA ADI'),
(93, 'DIAN CAHYANI', '20180705460', 'SEWING', 'LEADER', 'WAHYUNING'),
(94, 'YUYUN ISMAWATI', '20180805503', 'ACCOUNTING', 'ACCOUNTING', 'TATIK SUTARTI'),
(95, 'DELLA NOVITA', '20180805505', 'CAD/CAM', 'SAMPLE', 'RAHMASARI'),
(96, 'ISNANDA LAILA QORIDA SAPUTRI', '20180805508', 'CUTTING', 'LEADER', 'RAHMASARI'),
(97, 'ANNISYA VEGA SORAYA', '20180805529', 'PPIC', 'MINGALA', 'RAHMASARI'),
(98, 'DIAN ANGGRAENI SUTADI PUTRI', '20210706940', 'HRD', 'ASST. COMPLIANCE', 'ERNAWATI APRILIA'),
(99, 'LIDIA ERNANDA', '20210906971', 'HRD', 'BPJS', 'AGOES KARTIKA ADI'),
(100, 'WULAN SEPTIYORINI', '20211006988', 'CAD/CAM', 'MARKER', 'RAHMASARI'),
(101, 'TOMY AFRIYANTO', '20220306995', 'IT', 'IT', 'AGOES KARTIKA ADI'),
(102, 'RESTIANA', '20220506996', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(103, 'RITA YULIYANI', '20220607026', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(104, 'DWI VERA HANDAYANI', '20220607127', 'EXIM', 'EXPORT', 'AGOES KARTIKA ADI'),
(105, 'OKTAVIA INDRIYANI', '20220707140', 'EXIM', 'IMPORT', 'AGOES KARTIKA ADI'),
(106, 'CICILIA SEPTINA', '20220707145', 'PPIC', 'PPIC 2', 'ALFIYAH'),
(107, 'NURYATI', '20220707146', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(108, 'RINA ANGGRAENI', '20220707147', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(109, 'DEWI FITRIYAWATIK', '20220707152', 'EXIM', 'EXPORT', 'AGOES KARTIKA ADI'),
(110, 'YENI LANTARI', '20220807153', 'PPIC', 'PPIC 2', 'ALFIYAH'),
(111, 'KHOIRUR ROZIKIN', '20220807154', 'IT', 'IT', 'AGOES KARTIKA ADI'),
(112, 'INDRA HIMAWAN FIKRI', '20220907155', 'MECHANICS', 'ELECTRICAL', 'AGOES KARTIKA ADI'),
(113, 'NURRI WIDIANINGSIH', '20220907177', 'SEWING', 'LEADER', 'WAHYUNING'),
(114, 'SRI INDRAYANI', '20220907179', 'SEWING', 'LEADER', 'WAHYUNING'),
(115, 'DEWI KURNIAWATI', '20221007182', 'SEWING', 'LEADER', 'WAHYUNING'),
(116, 'HENI MUKASIH', '20230207186', 'SEWING', 'LEADER', 'WAHYUNING'),
(117, 'NURYANTI', '20230207187', 'SEWING', 'LEADER', 'WAHYUNING'),
(118, 'RITA PUJIATI', '20230207188', 'SEWING', 'LEADER', 'WAHYUNING'),
(119, 'PAULUS BAMBANG KUSMARTONO', '20230507190', 'MECHANICS', 'BOILER', 'AGOES KARTIKA ADI'),
(120, 'JARIYAH', '20230607191', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(121, 'NOVIAN TEDI PRATAMA', '20230607193', 'MECHANICS', 'BOILER', 'AGOES KARTIKA ADI'),
(122, 'DWI NOVIANI', '20230707199', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(123, 'ELIYTA PRAMESDA VALENT', '20231007411', 'PPIC', 'PPIC 1', 'RAHMASARI'),
(124, 'KINANTI AYU ASHARI', '20231007412', 'CAD/CAM', 'TECHNICAL', 'RAHMASARI'),
(125, 'ENDAH SUPARTI', '20231007414', 'SEWING', 'SUPERVISOR', 'WAHYUNING'),
(126, 'LAURENTINA LARASATI', '20231007416', 'PPIC', 'PPIC 1', 'RAHMASARI');

-- --------------------------------------------------------

--
-- Table structure for table `leader_assessment`
--

CREATE TABLE `leader_assessment` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `employee_id` varchar(255) NOT NULL,
  `final_grades` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leader_assessment_detail`
--

CREATE TABLE `leader_assessment_detail` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `employee_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `status_detail` int(11) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `score_proportion`
--

CREATE TABLE `score_proportion` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `self` int(11) NOT NULL,
  `leader` int(11) NOT NULL,
  `senior_gm` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `score_proportion`
--

INSERT INTO `score_proportion` (`id`, `year`, `self`, `leader`, `senior_gm`) VALUES
(1, 2024, 30, 35, 35);

-- --------------------------------------------------------

--
-- Table structure for table `self_assessment`
--

CREATE TABLE `self_assessment` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `employee_id` varchar(255) NOT NULL,
  `final_grades` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `self_assessment_detail`
--

CREATE TABLE `self_assessment_detail` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `employee_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `status_detail` int(11) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `senior_gm_assessment`
--

CREATE TABLE `senior_gm_assessment` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `employee_id` varchar(255) NOT NULL,
  `final_grades` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `senior_gm_assessment_detail`
--

CREATE TABLE `senior_gm_assessment_detail` (
  `id` int(11) NOT NULL,
  `year` int(11) NOT NULL DEFAULT year(current_timestamp()),
  `employee_id` varchar(255) NOT NULL,
  `status` int(11) NOT NULL,
  `status_detail` int(11) NOT NULL,
  `value` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `assessment_category`
--
ALTER TABLE `assessment_category`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_department_target`
--
ALTER TABLE `assessment_department_target`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assessment_parameter`
--
ALTER TABLE `assessment_parameter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_account`
--
ALTER TABLE `employee_account`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_detail`
--
ALTER TABLE `employee_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leader_assessment`
--
ALTER TABLE `leader_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `leader_assessment_detail`
--
ALTER TABLE `leader_assessment_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `score_proportion`
--
ALTER TABLE `score_proportion`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `self_assessment`
--
ALTER TABLE `self_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `self_assessment_detail`
--
ALTER TABLE `self_assessment_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `senior_gm_assessment`
--
ALTER TABLE `senior_gm_assessment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `senior_gm_assessment_detail`
--
ALTER TABLE `senior_gm_assessment_detail`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `assessment_category`
--
ALTER TABLE `assessment_category`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `assessment_department_target`
--
ALTER TABLE `assessment_department_target`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `assessment_parameter`
--
ALTER TABLE `assessment_parameter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `employee_account`
--
ALTER TABLE `employee_account`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=131;

--
-- AUTO_INCREMENT for table `employee_detail`
--
ALTER TABLE `employee_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=127;

--
-- AUTO_INCREMENT for table `leader_assessment`
--
ALTER TABLE `leader_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leader_assessment_detail`
--
ALTER TABLE `leader_assessment_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `score_proportion`
--
ALTER TABLE `score_proportion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `self_assessment`
--
ALTER TABLE `self_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `self_assessment_detail`
--
ALTER TABLE `self_assessment_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `senior_gm_assessment`
--
ALTER TABLE `senior_gm_assessment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `senior_gm_assessment_detail`
--
ALTER TABLE `senior_gm_assessment_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
