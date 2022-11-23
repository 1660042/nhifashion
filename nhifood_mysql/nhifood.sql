-- MySQL dump 10.13  Distrib 8.0.25, for Win64 (x86_64)
--
-- Host: 192.168.10.10    Database: nhifood
-- ------------------------------------------------------
-- Server version	8.0.25-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `chitietdonhang`
--

DROP TABLE IF EXISTS `chitietdonhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `chitietdonhang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `madonhang` int NOT NULL,
  `mamonan` int NOT NULL,
  `tenmonan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `giatien` int NOT NULL,
  `soluong` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `chitietdonhang`
--

LOCK TABLES `chitietdonhang` WRITE;
/*!40000 ALTER TABLE `chitietdonhang` DISABLE KEYS */;
INSERT INTO `chitietdonhang` VALUES (8,12,15,'CHIFFON PHÔ MAI CHẢY',50000,1),(9,12,13,'BÔNG LAN 4 VỊ',39000,5),(10,13,15,'CHIFFON PHÔ MAI CHẢY',50000,2),(11,13,10,' Full xúc xích - Hotdog Hàn Quốc',29000,3),(12,14,15,'CHIFFON PHÔ MAI CHẢY',50000,4),(13,15,15,'CHIFFON PHÔ MAI CHẢY',50000,1),(14,16,13,'BÔNG LAN 4 VỊ',39000,1),(15,16,11,'BÁNH KEM CHANH DÂY LÁT',27000,1),(16,17,14,'BÔNG LAN TRỨNG MUỐI',55000,1),(17,17,4,'CAFE ĐÁ XAY',35000,1);
/*!40000 ALTER TABLE `chitietdonhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `donhang`
--

DROP TABLE IF EXISTS `donhang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `donhang` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `idkh` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `donhang`
--

LOCK TABLES `donhang` WRITE;
/*!40000 ALTER TABLE `donhang` DISABLE KEYS */;
INSERT INTO `donhang` VALUES (16,'Lương Bảo','Hồ Chí Minh',1,'2021-11-11 10:34:25','2021-11-11 10:34:25'),(17,'Nhi Lương','Hồ Chí Minh',2,'2021-11-11 10:41:08','2021-11-11 10:41:08');
/*!40000 ALTER TABLE `donhang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `menu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tenmon` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `gia` int NOT NULL,
  `idtheloai` int NOT NULL,
  `idth` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'Trà đào','Nguyên liệu: 2 kg đào lai mận (mua loại 30.000 đồng/kg), 1 kg đường (nửa đỏ, nửa trắng), 3 quả chanh.','https://product.hstatic.net/1000075078/product/tra_dao_5f3925d9bfca4d0abc17f95b05fff5f7_master.jpg',29000,1,2,NULL,NULL),(2,'Bạc sỉu','Ngon tuyệt','http://bonpasbakery.com/image/cache/data/N%C6%B0%E1%BB%9Bc%20m%E1%BB%9Bi%202018/N%C6%B0%E1%BB%9Bc%20ly%20th%E1%BB%A7y%20tinh/1-472x378f.jpg',30000,1,2,NULL,NULL),(3,'CÀ PHÊ DỪA','CÀ PHÊ DỪA ngon tuyệt','http://bonpasbakery.com/image/cache/data/N%C6%B0%E1%BB%9Bc%20m%E1%BB%9Bi%202018/N%C6%B0%E1%BB%9Bc%20ly%20th%E1%BB%A7y%20tinh/cafe%20dua-472x378f.jpg',37000,1,2,NULL,NULL),(4,'CAFE ĐÁ XAY','ngon ngon ngon','http://bonpasbakery.com/image/cache/data/N%C6%B0%E1%BB%9Bc%20m%E1%BB%9Bi%202018/N%C6%B0%E1%BB%9Bc%20ly%20th%E1%BB%A7y%20tinh/cafe%20%C4%91%C3%A1%20xay-472x378f.jpg',35000,1,2,NULL,NULL),(5,'TRÀ DÂU RỪNG','TRÀ DÂU RỪNG siêu ngon','http://bonpasbakery.com/image/cache/data/N%C6%B0%E1%BB%9Bc%20m%E1%BB%9Bi%202018/N%C6%B0%E1%BB%9Bc%20ly%20th%E1%BB%A7y%20tinh/tr%C3%A0%20d%C3%A2u-472x378f.jpg',37000,1,2,NULL,NULL),(6,'SINH TỐ DÂU TƯƠI','SINH TỐ DÂU TƯƠI ngon ngon ngon','http://bonpasbakery.com/image/cache/data/N%C6%B0%E1%BB%9Bc%20m%E1%BB%9Bi%202018/N%C6%B0%E1%BB%9Bc%20ly%20th%E1%BB%A7y%20tinh/sinh%20t%E1%BB%91%20d%C3%A2u-472x378f.jpg',43000,1,2,NULL,NULL),(7,'Combo 2','Full phomai mozza + hotdog phomai Hàn Quốc','https://images.foody.vn/res/g81/800131/s120x120/712fe389-3607-4d8c-a345-dc139397e6dd.jpg',59000,2,1,NULL,NULL),(8,' Combo 1','Full hotdog bọc khoai tây + full hotdog + khoai tây chiên','https://images.foody.vn/res/g81/800131/s120x120/dc8ca11f-a2da-4716-b99d-4a3fe4e91585.jpg',59000,2,1,NULL,NULL),(9,'Hotdog phômai Hàn Quốc','Nhân một nữa là phomai mozza một nữa xúc xích','https://images.foody.vn/res/g81/800131/s120x120/a3cf142e-4028-4279-8301-17a5ed902ac5.jpg',59000,2,1,NULL,NULL),(10,' Full xúc xích - Hotdog Hàn Quốc','Xúc xích và lớp vỏ bánh giòn giòn','https://images.foody.vn/res/g81/800131/s120x120/9648abd8-5e4a-4127-ad97-f7afc369273f.jpg',29000,2,1,NULL,NULL),(12,'BÔNG LAN PHÔ MAI NHẬT BẢN MINI','bông lan','http://bonpasbakery.com/image/cache/data/20160222/46.1-472x378f.jpg',18000,3,3,NULL,NULL),(13,'BÔNG LAN 4 VỊ','bông lan 4 vị','http://bonpasbakery.com/image/cache/data/S%E1%BA%A3n%20ph%E1%BA%A9m%20m%E1%BB%9Bi/3-472x378f.png',39000,3,3,NULL,NULL),(14,'BÔNG LAN TRỨNG MUỐI','bông lan và trứng muối','http://bonpasbakery.com/image/cache/data/lam%2020.6.2018/bong%20lan%20trung%20muoi-472x378f.jpg',55000,3,3,NULL,NULL),(15,'CHIFFON PHÔ MAI CHẢY','CHIFFON PHÔ MAI CHẢY','http://bonpasbakery.com/image/cache/data/lam%2020.6.2018/9-472x378f.png',50000,3,3,NULL,NULL),(20,'bún mắm','ngon','https://beptruong.edu.vn/wp-content/uploads/2014/06/bun-ca-ha-noi.jpg',59000,2,1,NULL,NULL),(21,'gà','ngon','https://ameovat.com/wp-content/uploads/2016/05/cach-lam-ga-ran.jpg',59000,2,1,NULL,NULL),(28,'Đồ uống 1','test do uong','http://nhifood.test/upload/618cf0b8961d7_default-avatar.png',123,1,1,'2021-11-11 17:30:16','2021-11-11 17:30:16');
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2014_10_12_000000_create_users_table',2);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `theloai`
--

DROP TABLE IF EXISTS `theloai`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `theloai` (
  `id` int NOT NULL,
  `ten` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `theloai`
--

LOCK TABLES `theloai` WRITE;
/*!40000 ALTER TABLE `theloai` DISABLE KEYS */;
INSERT INTO `theloai` VALUES (1,'Đồ uống','https://png.pngtree.com/png-clipart/20190516/original/pngtree-cartoon-cute-tea-drink-beverages-can-be-commercial-elements-teadrinkdrinkcartoonlovely-png-image_4076364.jpg',NULL,NULL),(2,'Ăn vặt','https://png.pngtree.com/png-clipart/20190619/original/pngtree-food-delicious-snacks-hand-painted-features-delicious-food-png-image_3964096.jpg',NULL,NULL),(3,'Bánh ','https://encrypted-tbn0.gstatic.com/images?q=tbn%3AANd9GcR1y-O-_rUZ7hWm-0oJWQdUbeT3SBB9CXZ1iA&usqp=CAU',NULL,NULL);
/*!40000 ALTER TABLE `theloai` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `thuonghieu`
--

DROP TABLE IF EXISTS `thuonghieu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `thuonghieu` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `anh` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mota` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `diachi` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `thuonghieu`
--

LOCK TABLES `thuonghieu` WRITE;
/*!40000 ALTER TABLE `thuonghieu` DISABLE KEYS */;
INSERT INTO `thuonghieu` VALUES (1,'Lá Food','https://images.foody.vn/res/g81/800131/prof/s576x330/foody-upload-api-foody-mobile-4feb21ad425aa004f94b-190325085546.jpg','siêu đình đám','2 Khánh An 5,  Quận Liên Chiểu, Đà Nẵng',NULL,NULL),(2,'BONPAS BAKERY & COFFEE','http://bonpasbakery.com/image/data/logo/logo_bonpas_fa_newc.png','Bản quyền thuộc về BonPas Bakery & Coffee \r\nPhát triển bởi Kovo','BONPAS BAKERY & COFFEE\r\nĐịa chỉ: 35-37-39-41 Nguyễn Văn Linh - P.Bình Hiên - Q.Hải Châu - TP. Đà Nẵn',NULL,NULL),(3,'Sasin','http://micaysasin.vn/upload/hinhanh/logo-2662-84690.png','Sasin Mì Cay 7 Cấp Độ Hàn Quốc','Email: dotuan@sasin.vn hoặc ngoc.le@sasin.vn',NULL,NULL);
/*!40000 ALTER TABLE `thuonghieu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_nhi`
--

DROP TABLE IF EXISTS `user_nhi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_nhi` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ten` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_nhi`
--

LOCK TABLES `user_nhi` WRITE;
/*!40000 ALTER TABLE `user_nhi` DISABLE KEYS */;
INSERT INTO `user_nhi` VALUES (1,'Nhi','nhi@gmail.com','12345',792241611,NULL,NULL),(2,'Oanh','oanh@gmail.com','12345',935507395,NULL,NULL),(3,'khang','khang@gmail.com','12345',984728276,NULL,NULL);
/*!40000 ALTER TABLE `user_nhi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `ten` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sdt` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password_text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `chuc_vu` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_sdt_unique` (`sdt`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Lương Bảo','0355007111','admin@gmail.com',NULL,'$2y$10$yKaptSWM9Zj19OqD5TGEw.aJPeQlXHpKlenluRCL86WX5NEz9Laoa','12345678',1,NULL,'2021-11-11 02:54:39','2021-11-11 02:54:39'),(2,'Nhi Lương','123456789','nhiluong@gmail.com',NULL,'$2y$10$E2dxQ9kJvvsEQRrqblLS7eqWF7ZHraD.bdzpLTQ3BFeBhz9No2eDu','12345678',0,NULL,'2021-11-11 10:40:32','2021-11-11 10:40:32');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-11 18:26:43
