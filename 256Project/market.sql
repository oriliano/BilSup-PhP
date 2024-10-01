-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 17, 2018 at 09:23 AM
-- Server version: 5.7.14
-- PHP Version: 7.0.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--


-- --------------------------------------------------------

--
-- Table structure for table `motorbikes`
--

DROP TABLE IF EXISTS `admin`;
CREATE TABLE IF NOT EXISTS `admin` (
    `email` VARCHAR(100) PRIMARY KEY,
    `market_name` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `city` VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
    `district` VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
    `address` VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
    `remember` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- passwords 6686, 1234, 1235, oriliano 
--

INSERT INTO `admin` (`email`, `market_name`, `password`, `city`, `district`, `address`, `remember`) VALUES
('bilkent@bilsup.com', 'Bilkent@BilSup', '$2y$10$A/f7eGpiU2eaKx9l5czjT.aoegZId3EWSSdzOJI6K8EC.lwnRkcQe', 'Ankara', 'Çankaya', 'Bilkent', NULL),
('bahceli@bilsup.com', 'Bahceli@BilSup', '$2y$10$A/f7eGpiU2eaKx9l5czjT.aoegZId3EWSSdzOJI6K8EC.lwnRkcQe', 'Ankara', 'Çankaya', 'Bahçeli', NULL),
('cekmekoy@bilsup.com', 'Cekmekoy@BilSup', '$2y$10$qN59VFcA/LLvrh18vnIJ7.LQISRj7wHkJSQxgU7P7XH5E/lGb8keO', 'İstanbul', 'Çekmeköy', 'Merkez', NULL),
('oriliano@bilsup.com', 'Oriliano@BilSup', '$2y$10$TyBKM6UPj7oDTTM6YR0TJOw69Mf0irbBUagzh3Cbv4HeBldU8hSom', 'İstanbul', 'Beykoz', 'Merkez', NULL);

        


DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
    `email` VARCHAR(100) PRIMARY KEY,
    `username` VARCHAR(100) NOT NULL,
    `password` VARCHAR(100) NOT NULL,
    `city` VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
    `district` VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
    `address` VARCHAR(100) COLLATE utf8mb4_turkish_ci NOT NULL,
    `remember` varchar(200) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

INSERT INTO `users` (`email`, `username`, `password`, `city`, `district`, `address`, `remember`) VALUES
('ali.eray@ug.bilkent.edu.tr', 'alieray', '$2y$10$w2lUOBP.E/LSLCNfo3JGfelIc3TZHYNbaKA207iWkUYHGLDg1nh/O', 'Ankara', 'Çankaya', '81. Yurt', NULL),
('emir.inaner@ug.bilkent.edu.tr', 'einaner', '$2y$10$w2lUOBP.E/LSLCNfo3JGfelIc3TZHYNbaKA207iWkUYHGLDg1nh/O', 'Ankara', 'Çankaya', '77. Yurt', NULL),
('cavit.ergul@ug.bilkent.edu.tr', 'cvtmrt', '$2y$10$w2lUOBP.E/LSLCNfo3JGfelIc3TZHYNbaKA207iWkUYHGLDg1nh/O', 'Ankara', 'Çankaya', 'Bahçeli ev', NULL),
('orhan.koc@ug.bilkent.edu.tr', 'oriliano', '$2y$10$w2lUOBP.E/LSLCNfo3JGfelIc3TZHYNbaKA207iWkUYHGLDg1nh/O', 'Ankara', 'Gölbaşı', 'İncek', NULL);



DROP TABLE IF EXISTS `products`;
CREATE TABLE IF NOT EXISTS `products` (
  `id` int NOT NULL AUTO_INCREMENT,
  `market_email` varchar(100) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `price` decimal(8,2) NOT NULL,
  `discounted_price` decimal(8,2) NOT NULL,
  `expdate` date NOT NULL DEFAULT '2024-05-14',
  `path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_turkish_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1014 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;


INSERT INTO `products` (`id`, `market_email`, `title`, `stock`, `price`, `discounted_price`, `expdate`, `path`) VALUES
(1001, 'bilkent@bilsup.com','Hardline BCAA 630gr',10, 570.00, 570.00, '2025-12-13', 'hardlinebcaa.jpg'),
(1002, 'bilkent@bilsup.com','Weider Premium Whey Protein Tozu 2300 Gr', 5, 5020.00, 5020.00, '2024-05-30', 'weider_protein_tozu.jpg'),
(1003, 'bilkent@bilsup.com','Weider Mega Mass 2000 3000 Gr', 2, 2670.00, 2670.00, '2034-06-23', 'weider_mass.jpg'),
(1004, 'bilkent@bilsup.com','Weider Premium BCAA Professional 450 Gr', 1, 1350.00, 1350.00, '2024-05-22', 'weider_bcaa.jpg'),
(1005, 'bilkent@bilsup.com','Weider Arginine Xplode 500 Gr', 2, 670.00, 670.00, '2024-06-06', 'weider_arginine.jpg'),
(1006, 'bilkent@bilsup.com','Hardline Thermo L-Karnitin Sıvı 1000 mL', 7, 470.00, 470.00, '2024-06-13', 'hardlinecarnitin.jpg'),
(1007, 'bilkent@bilsup.com', 'Hardline Gainer 5000gr', 10, 1200.00, 1200.00, '2024-06-21', 'hardlinegainer.jpg'),
(1008, 'bilkent@bilsup.com','Hiq Protein Tozu 2000gr', 14, 3200.00, 3200.00, '2024-12-18', 'hiqproteintozu2kg.jpg'),
(1009, 'bilkent@bilsup.com','Protein Ocean Thermo Burner 30 kapsül', 20, 430.00, 430.00, '2024-12-02', 'proteinoceanthermo.jpg'),
(1010, 'bilkent@bilsup.com','Hardline Protein Tozu 900gr', 30, 760.00, 760.00, '2024-06-18', 'hardlineprotein.jpg'),
(1011, 'bilkent@bilsup.com','Hiq Creatine 600gr', 30, 950.00, 950.00, '2015-07-22', 'hiqcreatine.jpg'),
(1012, 'bilkent@bilsup.com','Big Joy L-Carnitin 1000ml', 6, 700.00, 700.00, '2034-11-08', 'bigjoycarnitin.jpg'),
(1013, 'bilkent@bilsup.com','Hiq Flavn Rice 840gr Chocolate Flavored', 15, 225.00, 225.00, '2019-05-11', 'hiqflavndream.jpg'),
(1014, 'bilkent@bilsup.com','Protein Ocean pre-workout 300gr', 3, 620.00, 620.00, '2024-05-24', 'proteinoceanpre-workout.jpg'),
(1015, 'bilkent@bilsup.com','Kingsize Nutrition BCAA 1000gr', 10, 900.00, 900.00, '2024-12-12', 'kingsizeBCAA.jpg'),
(1016, 'bilkent@bilsup.com','Hiq Fıstık Ezmesi 500gr', 4, 120.00, 120.00, '2024-08-09', 'hiqfistikezmesi.jpg'),
(1017, 'bilkent@bilsup.com','Big Joy Creatine 300gr', 3, 640.00, 640.00, '2025-03-01', 'bigjoycreatine.jpg'),
(1018, 'bilkent@bilsup.com','Protein Ocean C Vitamini 30 kapsül', 1, 350.00, 350.00, '2024-06-10', 'proteinoceanCvit.jpg'),
(1019, 'bilkent@bilsup.com','Big Joy Gainer 5000gr', 8, 1550.00, 1550.00, '2024-06-01', 'bigjoygainer.jpg'),
(1020, 'bilkent@bilsup.com','Hiq Maltodextrin 1500gr', 5, 450.00, 450.00, '2025-10-05', 'hiqmalto.jpg'),
(1021, 'bilkent@bilsup.com','Protein Ocean ZMA 30 kapsül', 2, 290.00, 290.00, '2026-07-18', 'proteinoceanzma.jpg'),
(1022, 'bahceli@bilsup.com','Hardline BCAA 630gr',20, 535.00, 535.00, '2026-02-13', 'hardlinebcaa.jpg'),
(1023, 'bahceli@bilsup.com','Weider Premium Whey Protein Tozu 2300 Gr', 6, 9000.00, 9000.00, '2024-12-20', 'weider_protein_tozu.jpg'),
(1024, 'bahceli@bilsup.com','Weider Mega Mass 2000 3000 Gr', 20, 3670.00, 3670.00, '2029-11-13', 'weider_mass.jpg'),
(1025, 'bahceli@bilsup.com','Weider Premium BCAA Professional 450 Gr', 2, 1200.00, 1200.00, '2024-08-22', 'weider_bcaa.jpg'),
(1026, 'bahceli@bilsup.com','Weider Arginine Xplode 500 Gr', 2, 670.00, 670.00, '2024-06-06', 'weider_arginine.jpg'),
(1027, 'bahceli@bilsup.com','Hardline Thermo L-Karnitin Sıvı 1000 mL', 6, 470.00, 470.00, '2024-06-13', 'hardlinecarnitin.jpg'),
(1028, 'bahceli@bilsup.com', 'Hardline Gainer 5000gr', 5, 1200.00, 1200.00, '2024-07-21', 'hardlinegainer.jpg'),
(1029, 'bahceli@bilsup.com','Hiq Protein Tozu 2000gr', 4, 3200.00, 3200.00, '2024-05-22', 'hiqproteintozu2kg.jpg'),
(1030, 'bahceli@bilsup.com','Protein Ocean Thermo Burner 30 kapsül', 10, 430.00, 430.00, '2024-05-29', 'proteinoceanthermo.jpg'),
(1031, 'bahceli@bilsup.com','Hardline Protein Tozu 900gr', 13, 760.00, 760.00, '2024-06-05', 'hardlineprotein.jpg'),
(1032, 'bahceli@bilsup.com','Hiq Creatine 600gr', 1, 950.00, 950.00, '2015-06-12', 'hiqcreatine.jpg'),
(1033, 'bahceli@bilsup.com','Big Joy L-Carnitin 1000ml', 6, 700.00, 700.00, '2034-11-08', 'bigjoycarnitin.jpg'),
(1034, 'bahceli@bilsup.com','Hiq Flavn Rice 840gr Chocolate Flavored', 15, 225.00, 225.00, '2026-05-11', 'hiqflavndream.jpg'),
(1035, 'bahceli@bilsup.com','Protein Ocean pre-workout 300gr', 5, 620.00, 620.00, '2022-05-24', 'proteinoceanpre-workout.jpg'),
(1036, 'bahceli@bilsup.com','Kingsize Nutrition BCAA 1000gr', 10, 900.00, 900.00, '2024-12-12', 'kingsizeBCAA.jpg'),
(1037, 'bahceli@bilsup.com','Hiq Fıstık Ezmesi 500gr', 8, 120.00, 120.00, '2024-08-09', 'hiqfistikezmesi.jpg'),
(1038, 'bahceli@bilsup.com','Big Joy Creatine 300gr', 9, 640.00, 640.00, '2025-02-01', 'bigjoycreatine.jpg'),
(1039, 'bahceli@bilsup.com','Protein Ocean C Vitamini 30 kapsül', 10, 350.00, 350.00, '2024-06-10', 'proteinoceanCvit.jpg'),
(1040, 'bahceli@bilsup.com','Big Joy Gainer 5000gr', 8, 1550.00, 1550.00, '2024-06-01', 'bigjoygainer.jpg'),
(1041, 'bahceli@bilsup.com','Hiq Maltodextrin 1500gr', 7, 450.00, 450.00, '2025-10-05', 'hiqmalto.jpg'),
(1042, 'bahceli@bilsup.com','Protein Ocean ZMA 30 kapsül', 2, 290.00, 290.00, '2026-07-18', 'proteinoceanzma.jpg'),
(1043, 'cekmekoy@bilsup.com','Hardline BCAA 630gr',3, 390.00, 390.00, '2026-12-13', 'hardlinebcaa.jpg'),
(1044, 'cekmekoy@bilsup.com','Weider Premium Whey Protein Tozu 2300 Gr', 30, 5000.00, 5000.00, '2024-12-30', 'weider_protein_tozu.jpg'),
(1045, 'cekmekoy@bilsup.com','Weider Mega Mass 2000 3000 Gr', 26, 2770.00, 2770.00, '2024-05-22', 'weider_mass.jpg'),
(1046, 'cekmekoy@bilsup.com','Weider Premium BCAA Professional 450 Gr', 24, 1050.00, 1050.00, '2024-05-12', 'weider_bcaa.jpg'),
(1047, 'cekmekoy@bilsup.com','Weider Arginine Xplode 500 Gr', 6, 690.00, 690.00, '2034-06-06', 'weider_arginine.jpg'),
(1048, 'cekmekoy@bilsup.com','Hardline Thermo L-Karnitin Sıvı 1000 mL', 16, 470.00, 470.00, '2024-12-13', 'hardlinecarnitin.jpg'),
(1049, 'cekmekoy@bilsup.com', 'Hardline Gainer 5000gr', 15, 1200.00, 1200.00, '2024-06-21', 'hardlinegainer.jpg'),
(1050, 'cekmekoy@bilsup.com','Hiq Protein Tozu 2000gr', 14, 3200.00, 3200.00, '2024-05-29', 'hiqproteintozu2kg.jpg'),
(1051, 'cekmekoy@bilsup.com','Protein Ocean Thermo Burner 30 kapsül', 10, 430.00, 430.00, '2024-06-05', 'proteinoceanthermo.jpg'),
(1052, 'cekmekoy@bilsup.com','Hardline Protein Tozu 900gr', 13, 760.00, 760.00, '2025-06-18', 'hardlineprotein.jpg'),
(1053, 'cekmekoy@bilsup.com','Hiq Creatine 600gr', 1, 950.00, 950.00, '2024-06-19', 'hiqcreatine.jpg'),
(1054, 'cekmekoy@bilsup.com','Big Joy L-Carnitin 1000ml', 6, 700.00, 700.00, '2034-11-08', 'bigjoycarnitin.jpg'),
(1055, 'cekmekoy@bilsup.com','Hiq Flavn Rice 840gr Chocolate Flavored', 15, 225.00, 225.00, '2019-05-11', 'hiqflavndream.jpg'),
(1056, 'cekmekoy@bilsup.com','Protein Ocean pre-workout 300gr', 3, 620.00, 620.00, '2024-05-24', 'proteinoceanpre-workout.jpg'),
(1057, 'cekmekoy@bilsup.com','Kingsize Nutrition BCAA 1000gr', 20, 900.00, 900.00, '2024-12-12', 'kingsizeBCAA.jpg'),
(1058, 'cekmekoy@bilsup.com','Hiq Fıstık Ezmesi 500gr', 8, 120.00, 120.00, '2024-08-09', 'hiqfistikezmesi.jpg'),
(1059, 'cekmekoy@bilsup.com','Big Joy Creatine 300gr', 3, 640.00, 640.00, '2025-06-01', 'bigjoycreatine.jpg'),
(1060, 'cekmekoy@bilsup.com','Protein Ocean C Vitamini 30 kapsül', 1, 350.00, 350.00, '2024-06-10', 'proteinoceanCvit.jpg'),
(1061, 'cekmekoy@bilsup.com','Big Joy Gainer 5000gr', 8, 1550.00, 1550.00, '2024-10-01', 'bigjoygainer.jpg'),
(1062, 'cekmekoy@bilsup.com','Hiq Maltodextrin 1500gr', 5, 450.00, 450.00, '2025-09-05', 'hiqmalto.jpg'),
(1063, 'cekmekoy@bilsup.com','Protein Ocean ZMA 30 kapsül', 20, 290.00, 290.00, '2024-07-18', 'proteinoceanzma.jpg'),
(1064, 'oriliano@bilsup.com','Hardline BCAA 630gr', 30, 670.00, 670.00, '2024-06-03', 'hardlinebcaa.jpg'),
(1065, 'oriliano@bilsup.com','Weider Premium Whey Protein Tozu 2300 Gr', 5, 5070.00, 5070.00, '2019-06-03', 'weider_protein_tozu.jpg'),
(1066, 'oriliano@bilsup.com','Weider Mega Mass 2000 3000 Gr', 9, 2670.00, 2670.00, '2034-06-23', 'weider_mass.jpg'),
(1067, 'oriliano@bilsup.com','Weider Premium BCAA Professional 450 Gr', 1, 1350.00, 1350.00, '2024-12-22', 'weider_bcaa.jpg'),
(1068, 'oriliano@bilsup.com','Weider Arginine Xplode 500 Gr', 2, 670.00, 670.00, '2022-01-12', 'weider_arginine.jpg'),
(1069, 'oriliano@bilsup.com','Hardline Thermo L-Karnitin Sıvı 1000 mL', 6, 470.00, 470.00, '2026-05-12', 'hardlinecarnitin.jpg'),
(1070, 'oriliano@bilsup.com', 'Hardline Gainer 5000gr', 5, 1200.00, 1200.00, '2024-08-16', 'hardlinegainer.jpg'),
(1071, 'oriliano@bilsup.com','Hiq Protein Tozu 2000gr', 14, 3200.00, 3200.00, '2025-12-18', 'hiqproteintozu2kg.jpg'),
(1072, 'oriliano@bilsup.com','Protein Ocean Thermo Burner 30 kapsül', 10, 430.00, 430.00, '2024-12-02', 'proteinoceanthermo.jpg'),
(1073, 'oriliano@bilsup.com','Hardline Protein Tozu 900gr', 3, 760.00, 760.00, '2024-06-19', 'hardlineprotein.jpg'),
(1074, 'oriliano@bilsup.com','Hiq Creatine 600gr', 10, 950.00, 950.00, '2025-07-22', 'hiqcreatine.jpg'),
(1075, 'oriliano@bilsup.com','Big Joy L-Carnitin 1000ml', 6, 800.00, 800.00, '2024-96-12', 'bigjoycarnitin.jpg'),
(1076, 'oriliano@bilsup.com','Hiq Flavn Rice 840gr Chocolate Flavored', 5, 325.00, 325.00, '2025-05-11', 'hiqflavndream.jpg'),
(1077, 'oriliano@bilsup.com','Protein Ocean pre-workout 300gr', 3, 710.00, 710.00, '2024-10-04', 'proteinoceanpre-workout.jpg'),
(1078, 'oriliano@bilsup.com','Kingsize Nutrition BCAA 1000gr', 11, 1000.00, 1000.00, '2024-02-22', 'kingsizeBCAA.jpg'),
(1079, 'oriliano@bilsup.com','Hiq Fıstık Ezmesi 500gr', 18, 150.00, 150.00, '2024-06-12', 'hiqfistikezmesi.jpg'),
(1080, 'oriliano@bilsup.com','Big Joy Creatine 300gr', 4, 540.00, 540.00, '2025-03-01', 'bigjoycreatine.jpg'),
(1081, 'oriliano@bilsup.com','Protein Ocean C Vitamini 30 kapsül', 11, 330.00, 330.00, '2025-06-05', 'proteinoceanCvit.jpg'),
(1082, 'oriliano@bilsup.com','Big Joy Gainer 5000gr', 1, 1450.00, 1450.00, '2025-05-30', 'bigjoygainer.jpg'),
(1083, 'oriliano@bilsup.com','Hiq Maltodextrin 1500gr', 7, 410.00, 410.00, '2024-05-29', 'hiqmalto.jpg'),
(1084, 'oriliano@bilsup.com','Protein Ocean ZMA 30 kapsül', 4, 300.00, 300.00, '2024-05-22', 'proteinoceanzma.jpg')
;

UPDATE `products`
SET `discounted_price` = CASE
    WHEN DATEDIFF(expdate, CURDATE()) > 30 THEN price
    WHEN DATEDIFF(expdate, CURDATE()) BETWEEN 22 AND 30 THEN price * 0.9
    WHEN DATEDIFF(expdate, CURDATE()) BETWEEN 15 AND 21 THEN price * 0.8
    WHEN DATEDIFF(expdate, CURDATE()) BETWEEN 8 AND 14 THEN price * 0.7
    WHEN DATEDIFF(expdate, CURDATE()) BETWEEN 1 AND 7 THEN price * 0.5   
END;
COMMIT;