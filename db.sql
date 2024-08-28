-- MySQL dump 10.13  Distrib 8.0.39, for Linux (x86_64)
--
-- Host: localhost    Database: PROJECT
-- ------------------------------------------------------
-- Server version	8.0.39-0ubuntu0.24.04.2

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(32) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `userId` bigint DEFAULT NULL,
  `status` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (2,'Shohjahon','$2y$10$znrZNF2uBwaIMyzJo.VuaOkMYJhqQG8nLI2pytxpyGEGQCEY5rl0S',6901874772,NULL),(8,'Nurullayev','$2y$10$cT4b.SEQWifStWHM/zowhuYMsLifILpYQM2mL7bZqXvId7xWH.uN6',7203034777,NULL);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ads`
--

DROP TABLE IF EXISTS `ads`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `ads` (
  `id` int NOT NULL AUTO_INCREMENT,
  `chatId` bigint DEFAULT NULL,
  `messageId` bigint DEFAULT NULL,
  `status` varchar(32) DEFAULT 'pending',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ads`
--

LOCK TABLES `ads` WRITE;
/*!40000 ALTER TABLE `ads` DISABLE KEYS */;
INSERT INTO `ads` VALUES (1,6901874772,649,'pending'),(2,6901874772,659,'pending'),(3,6901874772,667,'pending'),(4,931026030,679,'pending'),(5,6901874772,687,'pending'),(6,6901874772,711,'pending'),(7,7203034777,8009,'pending'),(8,7203034777,8014,'pending'),(9,7203034777,8016,'pending'),(10,7203034777,8019,'pending'),(11,7203034777,8023,'pending');
/*!40000 ALTER TABLE `ads` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `channels`
--

DROP TABLE IF EXISTS `channels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `channels` (
  `id` int NOT NULL AUTO_INCREMENT,
  `channel_id` bigint NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `channels`
--

LOCK TABLES `channels` WRITE;
/*!40000 ALTER TABLE `channels` DISABLE KEYS */;
INSERT INTO `channels` VALUES (29,-1002170814544),(30,-1002154267779);
/*!40000 ALTER TABLE `channels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `survey_variants`
--

DROP TABLE IF EXISTS `survey_variants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `survey_variants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `survey_variants_fk2` (`survey_id`),
  CONSTRAINT `survey_variants_fk2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=96 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `survey_variants`
--

LOCK TABLES `survey_variants` WRITE;
/*!40000 ALTER TABLE `survey_variants` DISABLE KEYS */;
INSERT INTO `survey_variants` VALUES (56,20,'Alisher Bekzod'),(57,20,'Diyorbek Shahzod'),(58,20,'Nodir Shavkat'),(59,20,'Sarvar Javlon'),(60,20,'Azizbek Mansur'),(61,20,'Farruh Sherzod'),(62,20,'Odilbek Sardor'),(63,20,'Dilshod Asqar'),(64,20,'Anvarbek Jamshid'),(65,20,'Nuriddin Bahodir'),(66,20,'Ulug\'bek Mirjalol'),(67,20,'Hasan Ali'),(68,20,'Bobur Islom'),(69,20,'Sherali Doniyor'),(70,20,'Zafarbek Akrom'),(71,20,'Shoxrux Ulug\'bek'),(72,20,'Shoxrux Ulug\'bek'),(73,20,'Tohir Alimardon'),(74,20,'Rustam Jafar'),(75,20,'Orifbek Sohib'),(76,21,'Toshkent Davlat Iqtisodiyot Universiteti'),(77,21,'Toshkent Davlat Yuridik Universiteti'),(78,21,'O\'zbekiston Milliy Universiteti'),(79,21,'Toshkent Tibbiyot Akademiyasi'),(80,21,'Toshkent Axborot Texnologiyalari Universiteti'),(81,21,'Samarqand Davlat Universiteti'),(82,21,'Toshkent Davlat Texnika Universiteti'),(83,21,'Toshkent Moliya Instituti'),(84,21,'Farg\'ona Davlat Universiteti'),(85,21,'Buxoro Davlat Universiteti'),(86,21,'Qarshi Davlat Universiteti'),(87,21,'Namangan Davlat Universiteti'),(88,21,'Nukus Davlat Pedagogika Instituti'),(89,21,'Guliston Davlat Universiteti'),(90,21,'Andijon Davlat Universiteti'),(91,21,'Toshkent Kimyo-Texnologiya Instituti'),(92,21,'Urganch Davlat Universiteti'),(93,21,'Toshkent Arxitektura va Qurilish Instituti'),(94,21,'Toshkent Davlat Pedagogika Universiteti'),(95,21,'Toshkent Davlat Sharqshunoslik Universiteti');
/*!40000 ALTER TABLE `survey_variants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `surveys`
--

DROP TABLE IF EXISTS `surveys`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `surveys` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `desc` text,
  `expired_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `surveys`
--

LOCK TABLES `surveys` WRITE;
/*!40000 ALTER TABLE `surveys` DISABLE KEYS */;
INSERT INTO `surveys` VALUES (20,'Maktablar','Maktablar o\'rtasid  so\'rovnoma','2024-08-21 23:34:00'),(21,'Universitedlar o\'rtasida','Universitedlar o\'rtasida so\'rovnoma\r\n','2024-08-22 10:00:00');
/*!40000 ALTER TABLE `surveys` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `name` varchar(255) NOT NULL,
  `phone_number` bigint DEFAULT NULL,
  `captcha_code` int DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created_at` date NOT NULL,
  `link` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  UNIQUE KEY `phone_number` (`phone_number`)
) ENGINE=InnoDB AUTO_INCREMENT=460 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `votes`
--

DROP TABLE IF EXISTS `votes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `votes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `survey_id` int NOT NULL,
  `survey_variant_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`),
  KEY `votes_fk1` (`user_id`),
  KEY `votes_fk2` (`survey_id`),
  KEY `votes_fk3` (`survey_variant_id`),
  CONSTRAINT `votes_fk1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `votes_fk2` FOREIGN KEY (`survey_id`) REFERENCES `surveys` (`id`),
  CONSTRAINT `votes_fk3` FOREIGN KEY (`survey_variant_id`) REFERENCES `survey_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=546 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `votes`
--

LOCK TABLES `votes` WRITE;
/*!40000 ALTER TABLE `votes` DISABLE KEYS */;
/*!40000 ALTER TABLE `votes` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-08-28 15:07:16
