-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: todo1
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `attachment`
--

DROP TABLE IF EXISTS `attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachment` (
  `id_attachment` int(11) NOT NULL AUTO_INCREMENT,
  `id_tugas` int(11) DEFAULT NULL,
  `type` enum('teks','photo','link','file','maps') DEFAULT NULL,
  `file` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id_attachment`),
  KEY `id_task` (`id_tugas`)
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `attachment`
--

LOCK TABLES `attachment` WRITE;
/*!40000 ALTER TABLE `attachment` DISABLE KEYS */;
INSERT INTO `attachment` VALUES (8,5,'photo',NULL,'ffff'),(13,17,'photo','1745046401_62cb88602afa3924f3ba.png',''),(14,18,'photo','1745047791_625ffa5a6324cf43d9f4.png','asas'),(15,15,'photo','1745049843_bc745e1f734b87b24c21.png','sdddd'),(18,10,'photo','1745206535_896e9b5f79ef2681f0b2.png','saya'),(20,10,'photo','avatar.png','asasaaa'),(21,10,'link','avatar.png','almamun'),(22,10,'link','avatar.png','ini almamun'),(25,10,'photo',NULL,'ini akuuuu'),(28,19,'photo',NULL,'ini akuuuuu'),(29,20,'photo',NULL,'');
/*!40000 ALTER TABLE `attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `id_groups` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(100) NOT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_date` datetime DEFAULT current_timestamp(),
  `photo` text DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  PRIMARY KEY (`id_groups`),
  KEY `created_by` (`created_by`),
  CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user` (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (5,'seblakersss',1,'2025-04-20 07:42:16','1745134954_d1f014bde30a427ee6f9.png','$2y$10$tVtlixsXk6LvAXybRp4z6uU8aDBFWR0pi5pfsHcAUSOoaYVjmSsna','biolisfans23'),(6,'kentang',1,'2025-04-21 19:04:13','1745262253_ce1ad8f37800953df98a.png','$2y$10$mW9mBm8ukai2OT5UsGbW4uLhl/lltj8PDuZAUttjG90mDld8f6zi.','gatua');
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `id_members` int(11) NOT NULL AUTO_INCREMENT,
  `id_groups` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `member_level` enum('admin','member') DEFAULT NULL,
  PRIMARY KEY (`id_members`),
  KEY `id_groups` (`id_groups`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
INSERT INTO `members` VALUES (3,4,1,''),(4,4,1,'admin'),(5,5,1,'admin'),(6,5,5,'member'),(7,5,6,'admin');
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `shared`
--

DROP TABLE IF EXISTS `shared`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `shared` (
  `id_shared` int(11) NOT NULL AUTO_INCREMENT,
  `id_tugas` int(11) DEFAULT NULL,
  `id_user` int(11) DEFAULT NULL,
  `shared_by_user_id` int(11) DEFAULT NULL,
  `accepted` enum('yes','no','pending') DEFAULT 'pending',
  `share_date` datetime DEFAULT current_timestamp(),
  `accept_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id_shared`),
  KEY `id_task` (`id_tugas`),
  KEY `id_user` (`id_user`),
  KEY `shared_by_user_id` (`shared_by_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `shared`
--

LOCK TABLES `shared` WRITE;
/*!40000 ALTER TABLE `shared` DISABLE KEYS */;
INSERT INTO `shared` VALUES (1,NULL,7,NULL,'pending','2025-04-21 16:21:37',NULL),(2,NULL,5,NULL,'pending','2025-04-21 16:27:35',NULL),(3,NULL,5,NULL,'pending','2025-04-21 16:35:54',NULL),(4,NULL,5,NULL,'pending','2025-04-21 16:40:28',NULL),(5,NULL,1,NULL,'pending','2025-04-21 16:46:14',NULL),(6,NULL,7,NULL,'pending','2025-04-21 16:48:45',NULL),(7,NULL,5,NULL,'pending','2025-04-21 16:54:15',NULL),(8,NULL,1,NULL,'pending','2025-04-21 17:12:23',NULL),(9,NULL,5,NULL,'pending','2025-04-21 18:41:13',NULL);
/*!40000 ALTER TABLE `shared` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tugas`
--

DROP TABLE IF EXISTS `tugas`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tugas` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `tugas` text NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `status` enum('To do','Berjalan','Selesai','Batal') NOT NULL,
  `alarm` enum('yes','no') NOT NULL,
  `created` int(6) NOT NULL,
  `date_due` date NOT NULL,
  `time_due` time(6) DEFAULT NULL,
  `date_finished` date DEFAULT NULL,
  `time_finished` time(6) DEFAULT NULL,
  `creator_id` int(11) DEFAULT NULL,
  `foto` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tugas`
--

LOCK TABLES `tugas` WRITE;
/*!40000 ALTER TABLE `tugas` DISABLE KEYS */;
INSERT INTO `tugas` VALUES (15,'mengaji','2025-04-19','13:21:00','Selesai','yes',1745043727,'2025-04-19','00:00:00.000000',NULL,NULL,1,''),(18,'mandi','2025-04-19','15:20:00','To do','yes',1745047165,'2025-04-19','00:00:00.000000',NULL,NULL,1,''),(19,'memasak','2025-04-21','16:14:00','To do','yes',1745223241,'2025-04-22','16:14:00.000000',NULL,NULL,1,''),(20,'murojaah','2025-04-22','10:52:00','To do','yes',1745254094,'2025-04-23','12:12:00.000000',NULL,NULL,1,'');
/*!40000 ALTER TABLE `tugas` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `level` enum('admin','user') DEFAULT 'user',
  `photo` text DEFAULT NULL,
  PRIMARY KEY (`id_user`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'nidia gitania','$2y$10$NGN/9z3p5UtLzyIGS.6.aeXHYWLf5YdHwIDa/tqmX5jmCOMt190OG','admin','1744605071_f64fcc9ddaeb2844ea28.png'),(5,'nidia','$2y$10$SFvlRzeB7cw9hL66BHXsCOB80Rr.i0EtwgTD5AIk1/7A7Jo.RK/au','user','1744775593_90f64448f723eb985ef9.png'),(6,'gitania','$2y$10$MieXk9MDTDyakDuwD2iyWe5s.7q/nafHHLrt1vTN1DWP1J1gLOqMu','admin','1745043965_069c95af10de802cd5a9.png'),(7,'aidina tania','$2y$10$6rjJB5HQgIiSizeAZjRK1OYLizWMJglRtmoqg1rNkxLCT6CjkXwaC','admin','1745251649_4662e58197b1330cd73e.png');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-04-22  2:04:46
