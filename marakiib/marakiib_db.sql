-- MySQL dump 10.13  Distrib 8.0.43, for Linux (x86_64)
--
-- Host: localhost    Database: marakiib_api_db
-- ------------------------------------------------------
-- Server version	8.0.43-0ubuntu0.24.04.1

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
-- Table structure for table `bookings`
--

DROP TABLE IF EXISTS `bookings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `bookings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `end_date` datetime NOT NULL,
  `total` decimal(8,2) NOT NULL,
  `extra_options` json DEFAULT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `contact_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `bookings_slug_unique` (`slug`),
  KEY `bookings_car_id_foreign` (`car_id`),
  KEY `bookings_customer_id_foreign` (`customer_id`),
  CONSTRAINT `bookings_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `bookings_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `bookings`
--

LOCK TABLES `bookings` WRITE;
/*!40000 ALTER TABLE `bookings` DISABLE KEYS */;
INSERT INTO `bookings` VALUES (1,53,9,'2025-09-03 10:00:00','2025-09-05 10:00:00',100.00,NULL,'completed','123456789','male','sayed-car1-1756711863804-1756713609-9',NULL,1,0,'2025-09-01 05:00:09','2025-09-01 05:33:43',NULL),(2,60,9,'2025-09-03 10:00:00','2025-09-05 10:00:00',200.00,NULL,'cancelled','123456789','male','sdfsdfsdfds55-1756713978-9',NULL,0,0,'2025-09-01 05:06:18','2025-09-01 05:25:42',NULL),(3,59,9,'2025-09-02 10:00:00','2025-09-03 10:00:00',10.00,NULL,'rejected','01095990437','male','sayed-1756712133154-1756715413-9',NULL,0,0,'2025-09-01 05:30:13','2025-09-01 05:43:12',NULL);
/*!40000 ALTER TABLE `bookings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('pos-api-cache-spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:16:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:14:\"view-dashboard\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"manage-cars\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:11:\"manage cars\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:15:\"manage-bookings\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:15:\"chat-with-users\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:13:\"manage-wallet\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:6;a:4:{s:1:\"a\";i:7;s:1:\"b\";s:15:\"manage-features\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:1:{i:0;i:1;}}i:7;a:4:{s:1:\"a\";i:8;s:1:\"b\";s:10:\"create-car\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:1:{i:0;i:1;}}i:8;a:4:{s:1:\"a\";i:9;s:1:\"b\";s:13:\"view-bookings\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:9;a:4:{s:1:\"a\";i:10;s:1:\"b\";s:8:\"book-car\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:10;a:4:{s:1:\"a\";i:11;s:1:\"b\";s:14:\"cancel-booking\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:11;a:4:{s:1:\"a\";i:12;s:1:\"b\";s:15:\"confirm-booking\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:3:{i:0;i:1;i:1;i:3;i:2;i:4;}}i:12;a:4:{s:1:\"a\";i:13;s:1:\"b\";s:13:\"manage-offers\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:4;}}i:13;a:4:{s:1:\"a\";i:14;s:1:\"b\";s:12:\"write-review\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:14;a:4:{s:1:\"a\";i:15;s:1:\"b\";s:12:\"view-reviews\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:4:{i:0;i:1;i:1;i:2;i:2;i:3;i:3;i:4;}}i:15;a:4:{s:1:\"a\";i:16;s:1:\"b\";s:17:\"manage-favourites\";s:1:\"c\";s:3:\"api\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}}s:5:\"roles\";a:4:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"api\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:8:\"customer\";s:1:\"c\";s:3:\"api\";}i:2;a:3:{s:1:\"a\";i:3;s:1:\"b\";s:14:\"private_renter\";s:1:\"c\";s:3:\"api\";}i:3;a:3:{s:1:\"a\";i:4;s:1:\"b\";s:13:\"rental_office\";s:1:\"c\";s:3:\"api\";}}}',1756803420);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_category`
--

DROP TABLE IF EXISTS `car_category`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_category` (
  `car_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`car_id`,`category_id`),
  KEY `car_category_category_id_foreign` (`category_id`),
  CONSTRAINT `car_category_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `car_category_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_category`
--

LOCK TABLES `car_category` WRITE;
/*!40000 ALTER TABLE `car_category` DISABLE KEYS */;
INSERT INTO `car_category` VALUES (1,3,NULL,NULL),(1,4,NULL,NULL),(2,3,NULL,NULL),(2,4,NULL,NULL),(2,5,NULL,NULL),(3,2,NULL,NULL),(3,4,NULL,NULL),(4,3,NULL,NULL),(4,4,NULL,NULL),(4,6,NULL,NULL),(5,2,NULL,NULL),(5,4,NULL,NULL),(6,3,NULL,NULL),(6,4,NULL,NULL),(6,6,NULL,NULL),(7,2,NULL,NULL),(7,3,NULL,NULL),(7,4,NULL,NULL),(8,2,NULL,NULL),(8,5,NULL,NULL),(9,1,NULL,NULL),(9,2,NULL,NULL),(9,3,NULL,NULL),(10,3,NULL,NULL),(11,3,NULL,NULL),(11,6,NULL,NULL),(12,1,NULL,NULL),(12,3,NULL,NULL),(12,5,NULL,NULL),(13,2,NULL,NULL),(13,3,NULL,NULL),(14,2,NULL,NULL),(14,6,NULL,NULL),(15,3,NULL,NULL),(15,4,NULL,NULL),(15,5,NULL,NULL),(16,1,NULL,NULL),(16,2,NULL,NULL),(16,5,NULL,NULL),(17,1,NULL,NULL),(17,4,NULL,NULL),(18,1,NULL,NULL),(18,6,NULL,NULL),(19,1,NULL,NULL),(20,1,NULL,NULL),(20,5,NULL,NULL),(20,6,NULL,NULL),(21,3,NULL,NULL),(21,6,NULL,NULL),(22,2,NULL,NULL),(22,4,NULL,NULL),(23,5,NULL,NULL),(23,6,NULL,NULL),(24,4,NULL,NULL),(25,3,NULL,NULL),(25,6,NULL,NULL),(26,1,NULL,NULL),(26,2,NULL,NULL),(26,4,NULL,NULL),(27,1,NULL,NULL),(27,4,NULL,NULL),(27,5,NULL,NULL),(28,1,NULL,NULL),(28,5,NULL,NULL),(28,6,NULL,NULL),(29,2,NULL,NULL),(29,3,NULL,NULL),(30,4,NULL,NULL),(30,6,NULL,NULL),(31,5,NULL,NULL),(31,6,NULL,NULL),(32,4,NULL,NULL),(33,3,NULL,NULL),(33,5,NULL,NULL),(33,6,NULL,NULL),(34,6,NULL,NULL),(35,2,NULL,NULL),(35,3,NULL,NULL),(36,2,NULL,NULL),(37,3,NULL,NULL),(38,1,NULL,NULL),(38,3,NULL,NULL),(38,4,NULL,NULL),(39,1,NULL,NULL),(39,2,NULL,NULL),(39,3,NULL,NULL),(40,4,NULL,NULL),(41,6,NULL,NULL),(42,2,NULL,NULL),(43,3,NULL,NULL),(43,6,NULL,NULL),(44,3,NULL,NULL),(44,4,NULL,NULL),(44,6,NULL,NULL),(45,1,NULL,NULL),(46,1,NULL,NULL),(46,2,NULL,NULL),(46,3,NULL,NULL),(47,1,NULL,NULL),(47,4,NULL,NULL),(48,1,NULL,NULL),(48,3,NULL,NULL),(48,5,NULL,NULL),(49,2,NULL,NULL),(49,3,NULL,NULL),(49,4,NULL,NULL),(50,2,NULL,NULL),(50,3,NULL,NULL),(50,6,NULL,NULL),(51,6,NULL,NULL),(52,1,NULL,NULL),(53,3,NULL,NULL),(54,3,NULL,NULL),(55,3,NULL,NULL),(56,3,NULL,NULL),(57,3,NULL,NULL),(58,3,NULL,NULL),(59,1,NULL,NULL),(60,1,NULL,NULL),(60,2,NULL,NULL),(62,6,NULL,NULL);
/*!40000 ALTER TABLE `car_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_extra_options`
--

DROP TABLE IF EXISTS `car_extra_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_extra_options` (
  `car_id` bigint unsigned NOT NULL,
  `extra_option_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`car_id`,`extra_option_id`),
  KEY `car_extra_options_extra_option_id_foreign` (`extra_option_id`),
  CONSTRAINT `car_extra_options_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `car_extra_options_extra_option_id_foreign` FOREIGN KEY (`extra_option_id`) REFERENCES `extra_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_extra_options`
--

LOCK TABLES `car_extra_options` WRITE;
/*!40000 ALTER TABLE `car_extra_options` DISABLE KEYS */;
INSERT INTO `car_extra_options` VALUES (1,3,'2025-08-31 16:48:03','2025-08-31 16:48:03'),(2,1,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(2,3,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(2,4,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(3,1,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(3,3,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(3,4,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(4,1,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(4,2,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(4,4,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(5,3,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(5,4,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(6,3,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(7,2,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(7,3,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(7,4,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(8,1,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(8,3,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(9,4,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(10,3,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(10,4,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(11,4,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(12,1,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(13,2,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(13,4,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(14,3,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(15,4,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(16,1,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(16,4,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(17,1,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(17,2,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(18,1,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(18,2,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(18,3,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(18,4,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(19,1,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(19,3,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(19,4,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(20,1,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(20,2,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(20,4,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(22,1,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(22,4,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(23,1,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(23,2,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(24,1,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(25,1,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(25,2,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(26,1,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(26,3,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(26,4,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(27,3,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(27,4,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(28,4,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(29,1,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(29,2,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(29,3,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(29,4,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(30,1,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(30,3,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(31,1,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(31,3,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(32,2,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(32,3,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(32,4,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(33,1,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(34,1,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(34,4,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(35,1,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(35,4,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(36,1,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(37,3,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(38,3,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(39,1,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(39,3,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(40,1,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(40,2,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(41,2,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(42,1,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(42,3,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(43,1,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(43,2,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(43,4,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(44,1,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(44,2,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(45,1,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(45,3,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(45,4,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(46,1,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(46,3,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(47,1,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(47,2,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(47,3,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(48,2,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(48,3,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(48,4,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(49,1,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(49,4,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(50,1,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(50,2,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(50,3,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(50,4,'2025-08-31 16:48:26','2025-08-31 16:48:26');
/*!40000 ALTER TABLE `car_extra_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_feature_values`
--

DROP TABLE IF EXISTS `car_feature_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_feature_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint unsigned NOT NULL,
  `feature_value_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `car_feature_values_car_id_foreign` (`car_id`),
  KEY `car_feature_values_feature_value_id_foreign` (`feature_value_id`),
  CONSTRAINT `car_feature_values_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `car_feature_values_feature_value_id_foreign` FOREIGN KEY (`feature_value_id`) REFERENCES `feature_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=301 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_feature_values`
--

LOCK TABLES `car_feature_values` WRITE;
/*!40000 ALTER TABLE `car_feature_values` DISABLE KEYS */;
INSERT INTO `car_feature_values` VALUES (1,1,4,'2025-08-31 16:48:02','2025-08-31 16:48:02'),(2,1,8,'2025-08-31 16:48:02','2025-08-31 16:48:02'),(3,1,13,'2025-08-31 16:48:02','2025-08-31 16:48:02'),(4,1,15,'2025-08-31 16:48:02','2025-08-31 16:48:02'),(5,1,19,'2025-08-31 16:48:03','2025-08-31 16:48:03'),(6,2,6,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(7,2,8,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(8,2,10,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(9,2,17,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(10,2,18,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(11,3,6,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(12,3,8,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(13,3,11,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(14,3,14,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(15,3,18,'2025-08-31 16:48:04','2025-08-31 16:48:04'),(16,4,6,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(17,4,8,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(18,4,10,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(19,4,16,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(20,4,19,'2025-08-31 16:48:05','2025-08-31 16:48:05'),(21,5,7,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(22,5,8,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(23,5,13,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(24,5,15,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(25,5,18,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(26,6,1,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(27,6,9,'2025-08-31 16:48:06','2025-08-31 16:48:06'),(28,6,12,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(29,6,16,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(30,6,19,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(31,7,2,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(32,7,9,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(33,7,13,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(34,7,15,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(35,7,18,'2025-08-31 16:48:07','2025-08-31 16:48:07'),(36,8,7,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(37,8,8,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(38,8,10,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(39,8,14,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(40,8,18,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(41,9,7,'2025-08-31 16:48:08','2025-08-31 16:48:08'),(42,9,9,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(43,9,11,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(44,9,14,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(45,9,19,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(46,10,7,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(47,10,9,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(48,10,13,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(49,10,14,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(50,10,19,'2025-08-31 16:48:09','2025-08-31 16:48:09'),(51,11,5,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(52,11,8,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(53,11,10,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(54,11,17,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(55,11,18,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(56,12,2,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(57,12,9,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(58,12,11,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(59,12,15,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(60,12,18,'2025-08-31 16:48:10','2025-08-31 16:48:10'),(61,13,4,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(62,13,8,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(63,13,13,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(64,13,16,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(65,13,18,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(66,14,6,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(67,14,9,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(68,14,12,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(69,14,16,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(70,14,18,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(71,15,3,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(72,15,9,'2025-08-31 16:48:11','2025-08-31 16:48:11'),(73,15,11,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(74,15,17,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(75,15,19,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(76,16,7,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(77,16,8,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(78,16,13,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(79,16,16,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(80,16,18,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(81,17,6,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(82,17,8,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(83,17,11,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(84,17,14,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(85,17,18,'2025-08-31 16:48:12','2025-08-31 16:48:12'),(86,18,7,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(87,18,8,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(88,18,12,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(89,18,16,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(90,18,19,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(91,19,4,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(92,19,9,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(93,19,13,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(94,19,15,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(95,19,19,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(96,20,1,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(97,20,9,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(98,20,11,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(99,20,17,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(100,20,19,'2025-08-31 16:48:13','2025-08-31 16:48:13'),(101,21,2,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(102,21,9,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(103,21,12,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(104,21,14,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(105,21,19,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(106,22,1,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(107,22,8,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(108,22,11,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(109,22,16,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(110,22,18,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(111,23,3,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(112,23,8,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(113,23,12,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(114,23,17,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(115,23,19,'2025-08-31 16:48:14','2025-08-31 16:48:14'),(116,24,1,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(117,24,8,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(118,24,12,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(119,24,14,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(120,24,19,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(121,25,3,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(122,25,8,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(123,25,12,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(124,25,14,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(125,25,19,'2025-08-31 16:48:15','2025-08-31 16:48:15'),(126,26,3,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(127,26,8,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(128,26,13,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(129,26,15,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(130,26,18,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(131,27,2,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(132,27,9,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(133,27,11,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(134,27,17,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(135,27,18,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(136,28,6,'2025-08-31 16:48:16','2025-08-31 16:48:16'),(137,28,8,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(138,28,13,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(139,28,15,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(140,28,18,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(141,29,6,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(142,29,9,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(143,29,13,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(144,29,17,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(145,29,18,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(146,30,3,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(147,30,9,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(148,30,11,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(149,30,15,'2025-08-31 16:48:17','2025-08-31 16:48:17'),(150,30,18,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(151,31,2,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(152,31,8,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(153,31,13,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(154,31,15,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(155,31,19,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(156,32,2,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(157,32,8,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(158,32,10,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(159,32,14,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(160,32,18,'2025-08-31 16:48:18','2025-08-31 16:48:18'),(161,33,7,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(162,33,8,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(163,33,11,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(164,33,15,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(165,33,18,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(166,34,6,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(167,34,8,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(168,34,11,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(169,34,16,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(170,34,19,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(171,35,7,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(172,35,8,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(173,35,10,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(174,35,17,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(175,35,19,'2025-08-31 16:48:19','2025-08-31 16:48:19'),(176,36,5,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(177,36,9,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(178,36,12,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(179,36,15,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(180,36,18,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(181,37,4,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(182,37,9,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(183,37,13,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(184,37,14,'2025-08-31 16:48:20','2025-08-31 16:48:20'),(185,37,18,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(186,38,5,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(187,38,9,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(188,38,13,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(189,38,15,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(190,38,18,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(191,39,1,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(192,39,9,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(193,39,13,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(194,39,14,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(195,39,19,'2025-08-31 16:48:21','2025-08-31 16:48:21'),(196,40,2,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(197,40,8,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(198,40,11,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(199,40,17,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(200,40,19,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(201,41,7,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(202,41,8,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(203,41,12,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(204,41,16,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(205,41,18,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(206,42,4,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(207,42,9,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(208,42,12,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(209,42,15,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(210,42,19,'2025-08-31 16:48:22','2025-08-31 16:48:22'),(211,43,3,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(212,43,8,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(213,43,12,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(214,43,14,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(215,43,18,'2025-08-31 16:48:23','2025-08-31 16:48:23'),(216,44,3,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(217,44,9,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(218,44,10,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(219,44,15,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(220,44,18,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(221,45,2,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(222,45,8,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(223,45,11,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(224,45,15,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(225,45,18,'2025-08-31 16:48:24','2025-08-31 16:48:24'),(226,46,5,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(227,46,8,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(228,46,11,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(229,46,15,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(230,46,18,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(231,47,7,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(232,47,9,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(233,47,10,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(234,47,16,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(235,47,19,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(236,48,4,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(237,48,8,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(238,48,13,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(239,48,14,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(240,48,19,'2025-08-31 16:48:25','2025-08-31 16:48:25'),(241,49,1,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(242,49,9,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(243,49,12,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(244,49,17,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(245,49,18,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(246,50,4,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(247,50,9,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(248,50,11,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(249,50,17,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(250,50,19,'2025-08-31 16:48:26','2025-08-31 16:48:26'),(251,51,1,NULL,NULL),(252,51,8,NULL,NULL),(253,51,10,NULL,NULL),(254,51,16,NULL,NULL),(255,51,18,NULL,NULL),(256,52,1,NULL,NULL),(257,52,8,NULL,NULL),(258,52,10,NULL,NULL),(259,52,17,NULL,NULL),(260,52,18,NULL,NULL),(261,53,1,NULL,NULL),(262,53,8,NULL,NULL),(263,53,10,NULL,NULL),(264,53,17,NULL,NULL),(265,53,18,NULL,NULL),(266,54,1,NULL,NULL),(267,54,8,NULL,NULL),(268,54,10,NULL,NULL),(269,54,17,NULL,NULL),(270,54,18,NULL,NULL),(271,55,1,NULL,NULL),(272,55,8,NULL,NULL),(273,55,10,NULL,NULL),(274,55,17,NULL,NULL),(275,55,18,NULL,NULL),(276,56,1,NULL,NULL),(277,56,8,NULL,NULL),(278,56,10,NULL,NULL),(279,56,17,NULL,NULL),(280,56,18,NULL,NULL),(281,57,1,NULL,NULL),(282,57,8,NULL,NULL),(283,57,10,NULL,NULL),(284,57,17,NULL,NULL),(285,57,18,NULL,NULL),(286,58,1,NULL,NULL),(287,58,8,NULL,NULL),(288,58,10,NULL,NULL),(289,58,17,NULL,NULL),(290,59,3,NULL,NULL),(291,60,1,NULL,NULL),(292,60,8,NULL,NULL),(293,60,10,NULL,NULL),(294,60,16,NULL,NULL),(295,60,18,NULL,NULL),(296,62,1,NULL,NULL),(297,62,8,NULL,NULL),(298,62,10,NULL,NULL),(299,62,17,NULL,NULL),(300,62,18,NULL,NULL);
/*!40000 ALTER TABLE `car_feature_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_options`
--

DROP TABLE IF EXISTS `car_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_options` (
  `car_id` bigint unsigned NOT NULL,
  `option_value_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`car_id`,`option_value_id`),
  KEY `car_options_option_value_id_foreign` (`option_value_id`),
  CONSTRAINT `car_options_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `car_options_option_value_id_foreign` FOREIGN KEY (`option_value_id`) REFERENCES `option_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_options`
--

LOCK TABLES `car_options` WRITE;
/*!40000 ALTER TABLE `car_options` DISABLE KEYS */;
/*!40000 ALTER TABLE `car_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_tag`
--

DROP TABLE IF EXISTS `car_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_tag` (
  `car_id` bigint unsigned NOT NULL,
  `tag_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`car_id`,`tag_id`),
  KEY `car_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `car_tag_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `car_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_tag`
--

LOCK TABLES `car_tag` WRITE;
/*!40000 ALTER TABLE `car_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `car_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_translations`
--

DROP TABLE IF EXISTS `car_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `insurance_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usage_nature` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_translations_car_id_locale_unique` (`car_id`,`locale`),
  KEY `car_translations_locale_index` (`locale`),
  CONSTRAINT `car_translations_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=123 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_translations`
--

LOCK TABLES `car_translations` WRITE;
/*!40000 ALTER TABLE `car_translations` DISABLE KEYS */;
INSERT INTO `car_translations` VALUES (1,1,'en','Schuster LLC 2001','Comprehensive','Personal','Sit provident sit cum.','Rem eos excepturi aspernatur qui molestias.','Et inventore sit qui quam sunt neque ut qui. Reprehenderit magnam eaque facere deleniti voluptatibus. Quos molestias sint voluptatibus dolorem occaecati ut.','Consectetur beatae est.'),(2,1,'ar','سيارة 1','شامل','شخصي','Sint asperiores rerum est saepe ut commodi incidunt.','سيارة 1','وصف السيارة 1','صورة سيارة 1'),(3,2,'en','Windler, Moore and Pfeffer 2000','Comprehensive','Personal','Animi perferendis repellendus assumenda accusamus nihil nihil.','Harum est dolorem vitae libero occaecati veniam dolores et.','Cumque et omnis earum error ad. Ut dolore dicta tempore.','Maxime maxime sit aut.'),(4,2,'ar','سيارة 2','شامل','شخصي','Voluptas error velit voluptas aut fuga ipsa voluptatem.','سيارة 2','وصف السيارة 2','صورة سيارة 2'),(5,3,'en','Macejkovic Ltd 2005','Comprehensive','Personal','Et inventore delectus et sint autem aut.','Similique sint quia nesciunt et sit.','Iste vel qui accusamus et eligendi dignissimos. Et voluptas porro eaque rerum dolorum. Est dolorum commodi voluptas a quos consequatur quae ut. Ut ipsa et accusamus voluptatem accusamus.','Accusantium incidunt molestiae.'),(6,3,'ar','سيارة 3','شامل','شخصي','Voluptatem consequatur similique non magni.','سيارة 3','وصف السيارة 3','صورة سيارة 3'),(7,4,'en','Klein, Yost and Witting 1970','Comprehensive','Personal','Et qui vitae ipsa.','Aut repellendus molestiae cum.','Veritatis molestiae ut et qui laborum quae distinctio id. Eligendi quisquam corporis assumenda mollitia est similique. Deserunt reiciendis suscipit voluptatem aut molestiae in. Voluptatem inventore tempora et facilis quo ratione molestiae.','Accusamus iusto repudiandae explicabo ut.'),(8,4,'ar','سيارة 4','شامل','شخصي','Harum inventore autem ut totam.','سيارة 4','وصف السيارة 4','صورة سيارة 4'),(9,5,'en','Dach, Lemke and Frami 2017','Comprehensive','Personal','Suscipit dolor sint non quibusdam repudiandae.','Non eos est veniam fugiat vel.','Aut qui quia quasi ut et aut. Nobis libero aut id vero reiciendis dolorum ad laudantium. Suscipit magnam sint ex quis voluptatem iure tempore quo. Nihil possimus porro minus ratione.','Rerum quo in et.'),(10,5,'ar','سيارة 5','شامل','شخصي','Voluptas repudiandae neque in sequi voluptatem.','سيارة 5','وصف السيارة 5','صورة سيارة 5'),(11,6,'en','Gerhold, Padberg and Brakus 1980','Comprehensive','Personal','Nostrum aut dignissimos quia.','Quo cumque aliquid natus voluptatem asperiores.','Reiciendis assumenda est mollitia officiis. Quod qui quo fugiat qui fuga rerum magnam.','Aut aut voluptatibus sed.'),(12,6,'ar','سيارة 6','شامل','شخصي','Porro natus eaque provident aliquam sint.','سيارة 6','وصف السيارة 6','صورة سيارة 6'),(13,7,'en','O\'Conner, Berge and Abbott 2023','Comprehensive','Personal','Omnis ut aut perspiciatis quam id cumque qui.','Qui aperiam quia iste ea qui ut autem tenetur.','Doloremque eos dolore temporibus magni cupiditate velit. Nesciunt aut officiis vitae voluptas. Atque quia sequi fugit consequatur suscipit. Et accusantium quidem et veritatis. Eius sed at eum veritatis qui sit nemo.','Doloremque dicta voluptatibus.'),(14,7,'ar','سيارة 7','شامل','شخصي','Sit et ipsa quia quis nostrum nihil inventore.','سيارة 7','وصف السيارة 7','صورة سيارة 7'),(15,8,'en','Raynor, Weimann and Harvey 1977','Comprehensive','Personal','Est dolorem sint est est velit laborum at.','In deserunt sunt tempora ex ut eum ad vero.','Vitae minus aut commodi est et laboriosam. Ipsum id qui sit maiores dignissimos maxime. Ut vitae accusantium tenetur dignissimos voluptatum mollitia culpa. Ea ut quos corrupti deserunt rem fugit officia voluptate.','Quae et ut blanditiis omnis.'),(16,8,'ar','سيارة 8','شامل','شخصي','Sed non modi maxime iusto esse ullam sed.','سيارة 8','وصف السيارة 8','صورة سيارة 8'),(17,9,'en','Stokes, Kemmer and Wilderman 1986','Comprehensive','Personal','Eaque ea quam dolor voluptatum.','Autem molestiae aut ea molestias deserunt et nobis.','Id aut quas aut assumenda velit. Illo qui minima laborum nostrum. Labore minima non ut corrupti velit tempore modi. Eaque aut voluptas optio quia in.','Ratione illo dolore voluptatem.'),(18,9,'ar','سيارة 9','شامل','شخصي','Et autem ducimus eligendi placeat ducimus numquam fugiat.','سيارة 9','وصف السيارة 9','صورة سيارة 9'),(19,10,'en','Rolfson PLC 2024','Comprehensive','Personal','Ducimus fugiat reprehenderit tempore vel libero facilis sequi.','Tempora voluptatum rerum quas.','Dolorum modi eaque officia eligendi rerum veritatis beatae. Ut id quod veniam.','Dolores atque facere labore nulla.'),(20,10,'ar','سيارة 10','شامل','شخصي','Necessitatibus nobis sed qui accusamus.','سيارة 10','وصف السيارة 10','صورة سيارة 10'),(21,11,'en','Schuppe-Braun 2021','Comprehensive','Personal','Ea adipisci consequatur repellat at aliquid repellat.','Itaque ab est reiciendis est eveniet.','Quas dolor est velit ut sequi nulla. Quas rem voluptate impedit occaecati sint blanditiis. Rerum at sit sint vitae consequuntur.','Ut nam nam non.'),(22,11,'ar','سيارة 11','شامل','شخصي','Deleniti voluptates praesentium assumenda est iste veritatis assumenda.','سيارة 11','وصف السيارة 11','صورة سيارة 11'),(23,12,'en','Nolan-Langworth 2002','Comprehensive','Personal','Sed consequatur sit laudantium deserunt est.','Repudiandae perferendis fuga sit.','Expedita a dolorem hic. Aut minima voluptatibus alias quia. Quas et deserunt dolores.','Vel et soluta porro.'),(24,12,'ar','سيارة 12','شامل','شخصي','Hic aut quia itaque commodi dolor iusto.','سيارة 12','وصف السيارة 12','صورة سيارة 12'),(25,13,'en','Boyer, Pagac and Baumbach 2011','Comprehensive','Personal','Doloremque quo officiis illum.','Incidunt unde aut asperiores fugit quod.','Laudantium voluptatem unde enim iusto quae. Qui non illum voluptas suscipit a. Quia dignissimos tenetur eaque velit maiores et et. Et soluta nihil perspiciatis sunt cupiditate labore.','Eveniet velit.'),(26,13,'ar','سيارة 13','شامل','شخصي','Voluptatem et et dolor.','سيارة 13','وصف السيارة 13','صورة سيارة 13'),(27,14,'en','DuBuque Group 2024','Comprehensive','Personal','Temporibus quia sequi aperiam.','Et autem dolorum aperiam et assumenda nostrum tempore.','Fuga perferendis vel in tempora et voluptatem. Natus culpa quae sapiente ut. Natus debitis doloribus omnis officia pariatur ut illo. Nisi qui accusantium qui possimus consectetur.','Rerum tenetur facere ipsum.'),(28,14,'ar','سيارة 14','شامل','شخصي','Eum vero aliquam delectus.','سيارة 14','وصف السيارة 14','صورة سيارة 14'),(29,15,'en','Hayes Inc 2004','Comprehensive','Personal','Minus aperiam quis fugiat enim facilis atque aut doloribus.','Debitis beatae assumenda molestias debitis.','Unde error at sint cum eveniet. Animi sit sit error sit quae aut. Soluta deleniti incidunt suscipit nemo autem nemo a pariatur. Eos provident dignissimos rerum dolor cum quia.','Debitis dolorum aut.'),(30,15,'ar','سيارة 15','شامل','شخصي','Necessitatibus in quidem molestiae qui id eveniet officiis quis.','سيارة 15','وصف السيارة 15','صورة سيارة 15'),(31,16,'en','O\'Connell-Padberg 1976','Comprehensive','Personal','Rerum aliquam ut voluptatem accusamus.','Est asperiores et suscipit eum molestiae voluptatum magnam.','Vero qui totam omnis corrupti sunt amet tempore est. Optio maiores ut praesentium quibusdam et consequuntur. Ut qui quae harum alias et. Eum voluptas qui eum.','Autem quia dolorum.'),(32,16,'ar','سيارة 16','شامل','شخصي','Nam architecto sed voluptatibus tempora quis ipsa molestias.','سيارة 16','وصف السيارة 16','صورة سيارة 16'),(33,17,'en','Pacocha PLC 2006','Comprehensive','Personal','Modi et beatae rem dolorum minima.','Excepturi eos quia aut voluptate et.','Blanditiis pariatur accusamus et atque quod quia. Adipisci eos nemo sed quis eos dolores. Nisi maiores ea consequatur eius.','Eaque molestiae corrupti.'),(34,17,'ar','سيارة 17','شامل','شخصي','In quidem aut enim dolor iure et.','سيارة 17','وصف السيارة 17','صورة سيارة 17'),(35,18,'en','Kutch, Leannon and Pagac 1973','Comprehensive','Personal','Enim in libero aliquam soluta blanditiis recusandae.','Autem enim qui cupiditate ut.','Repudiandae non unde repudiandae nisi. Placeat beatae placeat suscipit consequatur maxime. At ipsam nihil autem sit saepe magni et. Dignissimos aspernatur iure odit et explicabo sint qui.','Autem velit neque harum.'),(36,18,'ar','سيارة 18','شامل','شخصي','Nisi in quos consectetur architecto blanditiis.','سيارة 18','وصف السيارة 18','صورة سيارة 18'),(37,19,'en','Blick Ltd 1997','Comprehensive','Personal','Incidunt dicta sapiente et.','Consectetur iste culpa ullam commodi aliquid autem.','Cupiditate et suscipit rerum labore nihil est. Sed maiores earum in nihil et expedita. Eos nam dolorum aperiam quia ratione et. Dignissimos accusamus laudantium sint voluptatibus sed.','Soluta illo quam placeat.'),(38,19,'ar','سيارة 19','شامل','شخصي','Est accusamus corporis accusamus est non.','سيارة 19','وصف السيارة 19','صورة سيارة 19'),(39,20,'en','Murray, Hudson and Daugherty 1985','Comprehensive','Personal','Quas sit ex iste quam maxime nisi eius.','Dolorem ut maxime dolorum totam facere ut est.','Minus ut fugiat eveniet quia. Doloremque molestias doloremque a nulla. Blanditiis repudiandae earum itaque accusantium sunt est.','Non maxime dignissimos.'),(40,20,'ar','سيارة 20','شامل','شخصي','Laudantium dolorem molestiae eaque similique.','سيارة 20','وصف السيارة 20','صورة سيارة 20'),(41,21,'en','Tillman, Feest and Hill 1997','Comprehensive','Personal','Perferendis sit est dolore iure officia.','Distinctio commodi eligendi ut ea.','Autem et rerum aliquam. Vitae aut aspernatur iure beatae delectus accusantium voluptatibus. Unde et ut culpa dolorem ipsam est unde. Ex dolorum officiis consectetur facere molestiae et et.','Omnis quo eius.'),(42,21,'ar','سيارة 21','شامل','شخصي','Minima eum eligendi et velit.','سيارة 21','وصف السيارة 21','صورة سيارة 21'),(43,22,'en','Konopelski Inc 2025','Comprehensive','Personal','Ut unde voluptas corrupti eum assumenda.','Nesciunt dolorum vel nihil aut sequi sunt.','Ut aut excepturi natus ex rerum aut. Et iure pariatur velit consequatur doloribus repudiandae deleniti. Voluptate corrupti omnis earum et est repellendus officia.','Asperiores in iusto.'),(44,22,'ar','سيارة 22','شامل','شخصي','Praesentium a laboriosam itaque nulla rerum recusandae amet porro.','سيارة 22','وصف السيارة 22','صورة سيارة 22'),(45,23,'en','Abernathy, Mayert and Tromp 1987','Comprehensive','Personal','Enim quis id doloribus aut provident accusamus consequuntur.','Fugit perferendis voluptatem neque officiis maxime consectetur molestiae.','Aut repellendus laudantium repellat tempore incidunt. Aliquam eos debitis sed eum omnis et. Nihil maxime hic alias excepturi. Omnis accusamus aperiam voluptatum repudiandae deserunt.','Ut qui quis.'),(46,23,'ar','سيارة 23','شامل','شخصي','Non officiis autem quod aperiam et.','سيارة 23','وصف السيارة 23','صورة سيارة 23'),(47,24,'en','Murray-Nienow 2022','Comprehensive','Personal','Et voluptates sint quaerat culpa ut.','Consequatur praesentium id sapiente ex omnis.','Quo et et eius et at molestias aut ullam. Sequi at vero voluptas inventore. Et voluptas magnam aut adipisci ab. Maxime voluptas veritatis accusamus aliquid.','Nostrum ipsum.'),(48,24,'ar','سيارة 24','شامل','شخصي','Blanditiis aperiam ducimus rerum similique quis ducimus nemo.','سيارة 24','وصف السيارة 24','صورة سيارة 24'),(49,25,'en','Maggio-Borer 2000','Comprehensive','Personal','Numquam facere vel aut voluptas consequatur saepe omnis a.','Minus quaerat aut ut enim.','Aut exercitationem consequuntur occaecati facere. Exercitationem sed occaecati distinctio rerum autem et. Voluptas ullam ullam qui repellendus odit consequuntur consectetur.','Voluptas aspernatur ea sunt ut.'),(50,25,'ar','سيارة 25','شامل','شخصي','Deserunt voluptas eaque ullam hic corporis qui vel.','سيارة 25','وصف السيارة 25','صورة سيارة 25'),(51,26,'en','O\'Conner-Effertz 1971','Comprehensive','Personal','Quam qui totam velit cupiditate rerum odio.','Id dicta et unde fugiat expedita voluptas est.','Voluptas et sint officia odio debitis sequi. Rem et itaque pariatur aspernatur vel. Praesentium et tempore ea repellendus. Quia est corporis mollitia aut et repudiandae.','Voluptates voluptatum ut.'),(52,26,'ar','سيارة 26','شامل','شخصي','Quibusdam fugit asperiores enim velit hic totam sunt.','سيارة 26','وصف السيارة 26','صورة سيارة 26'),(53,27,'en','Schinner, Franecki and Kertzmann 2021','Comprehensive','Personal','Aut a maiores molestiae.','Consectetur id beatae illo molestiae quia dolores.','Quod nisi ab id iure aut. Provident culpa et dolores error deleniti. Consequuntur et consequatur quaerat ullam nihil repellendus velit maiores. Enim et fugiat dolore est.','Doloribus voluptatem ut ipsam.'),(54,27,'ar','سيارة 27','شامل','شخصي','Dignissimos consectetur sed nihil pariatur quisquam quaerat error.','سيارة 27','وصف السيارة 27','صورة سيارة 27'),(55,28,'en','Walter and Sons 1996','Comprehensive','Personal','Ut laudantium fugiat est unde.','Sit quo deserunt corporis non molestias aut omnis.','Incidunt suscipit enim tenetur. Et in ex corrupti nemo adipisci repellat magnam non. Soluta consequatur rerum fugit dolore nemo ut. Rem doloribus animi suscipit et laudantium doloremque.','Sit nemo quaerat.'),(56,28,'ar','سيارة 28','شامل','شخصي','Ratione quaerat exercitationem ratione et id.','سيارة 28','وصف السيارة 28','صورة سيارة 28'),(57,29,'en','Emmerich-Deckow 2022','Comprehensive','Personal','Doloribus doloremque perferendis voluptate amet expedita sunt.','Perspiciatis quia aut nisi explicabo eveniet nulla ut atque.','Aliquid sit quia et id placeat nihil sunt. Vitae itaque voluptate aperiam voluptas id maxime.','Blanditiis fuga ea quia dolor.'),(58,29,'ar','سيارة 29','شامل','شخصي','Corporis rerum culpa sed nisi temporibus explicabo.','سيارة 29','وصف السيارة 29','صورة سيارة 29'),(59,30,'en','Schmeler Group 1997','Comprehensive','Personal','Sunt autem officia labore eos sunt perferendis quibusdam.','Asperiores eius vitae consequatur pariatur qui.','Natus harum consequatur maxime. Magni ab autem rem placeat pariatur. Quia quas vitae est aut. Et a aspernatur inventore quis excepturi qui. Qui voluptatibus eligendi facere.','Rem et sint.'),(60,30,'ar','سيارة 30','شامل','شخصي','Est explicabo et eum qui ducimus.','سيارة 30','وصف السيارة 30','صورة سيارة 30'),(61,31,'en','Hermann and Sons 2016','Comprehensive','Personal','Ut blanditiis modi quia et.','Explicabo ea molestiae cumque repudiandae quibusdam repellat.','Excepturi labore odio odit provident tenetur. Nihil velit dolore dolorum dicta aperiam sit necessitatibus. Neque quia et laudantium placeat placeat deserunt.','Rerum nisi optio suscipit.'),(62,31,'ar','سيارة 31','شامل','شخصي','Ab magni eos et impedit.','سيارة 31','وصف السيارة 31','صورة سيارة 31'),(63,32,'en','Lowe PLC 1985','Comprehensive','Personal','Dolore distinctio cupiditate architecto qui dolor.','Enim voluptatibus quo repellendus.','Sint saepe temporibus cumque illo ipsum excepturi. Praesentium harum qui in molestias. Id aut eum voluptas neque.','Amet aliquid ut.'),(64,32,'ar','سيارة 32','شامل','شخصي','Accusantium est sunt blanditiis id rerum laborum.','سيارة 32','وصف السيارة 32','صورة سيارة 32'),(65,33,'en','Bogisich-Schneider 2016','Comprehensive','Personal','Reprehenderit et voluptas quia.','Temporibus maxime assumenda accusantium impedit maxime et quas.','Harum vel et et facere. Vitae sint quis tempora quia nisi. Rem ea molestiae nihil cumque similique consectetur totam voluptas. Et sit aspernatur libero odit.','Quisquam corrupti.'),(66,33,'ar','سيارة 33','شامل','شخصي','Itaque dolorem tempore ut at.','سيارة 33','وصف السيارة 33','صورة سيارة 33'),(67,34,'en','Feeney, Huels and Ferry 2020','Comprehensive','Personal','Reiciendis ullam quos aliquid pariatur.','Pariatur voluptatem ea laborum distinctio sit accusantium.','Eligendi maiores id provident dolor. Vel placeat error omnis quibusdam. Eveniet soluta voluptas est sunt odio ducimus. Est libero autem similique et eum.','Laboriosam error vel ut.'),(68,34,'ar','سيارة 34','شامل','شخصي','Delectus ea sint ab blanditiis.','سيارة 34','وصف السيارة 34','صورة سيارة 34'),(69,35,'en','Hackett, Casper and Brekke 2002','Comprehensive','Personal','Omnis veniam quibusdam ad distinctio voluptatibus.','Excepturi sapiente beatae eos ducimus aliquid labore.','Doloribus quasi vel numquam eius et et. Sit quos voluptatem nulla. In quo quia laboriosam voluptate enim fuga est. Cupiditate maxime iusto a similique iste ab enim.','Non iusto qui ut.'),(70,35,'ar','سيارة 35','شامل','شخصي','Ducimus qui libero maxime enim.','سيارة 35','وصف السيارة 35','صورة سيارة 35'),(71,36,'en','Shanahan Group 1994','Comprehensive','Personal','Maiores consequatur quo rerum illo reprehenderit sed eius.','Sunt et fugiat nostrum nihil.','Voluptas quia eos voluptatibus dolores ea cupiditate. Mollitia tempore necessitatibus doloribus aut earum fugiat alias. Et tempora est fugiat rerum et asperiores officia.','Eos porro autem nostrum.'),(72,36,'ar','سيارة 36','شامل','شخصي','Explicabo ducimus nobis culpa sed dolor ea.','سيارة 36','وصف السيارة 36','صورة سيارة 36'),(73,37,'en','Kautzer, Mante and Ortiz 1997','Comprehensive','Personal','Magnam voluptatum est qui est vero quae vel minus.','Qui aut sint magni quia.','Necessitatibus et vero ipsum beatae molestiae sapiente. Voluptatum vel est vel ad ut. Molestiae eum ab omnis nobis doloribus deserunt non. Vel et occaecati dolor modi provident illum rem autem.','Blanditiis rerum explicabo.'),(74,37,'ar','سيارة 37','شامل','شخصي','Ipsum officiis nam quaerat quo perspiciatis minima.','سيارة 37','وصف السيارة 37','صورة سيارة 37'),(75,38,'en','Mraz PLC 1992','Comprehensive','Personal','Labore hic dolor vero et non unde impedit.','Dolore minima non qui quaerat non molestiae commodi.','Et praesentium sit fugiat ut. Perspiciatis delectus alias nemo aliquid error eos. Cumque nihil debitis corporis unde non rerum voluptate doloremque. Officia rerum ullam impedit sed quos.','Quasi hic molestiae eius id.'),(76,38,'ar','سيارة 38','شامل','شخصي','Voluptate repellendus quia asperiores.','سيارة 38','وصف السيارة 38','صورة سيارة 38'),(77,39,'en','Glover, Windler and Friesen 1998','Comprehensive','Personal','Aut est hic qui in dicta molestiae dignissimos vel.','Reiciendis commodi cumque aspernatur et corrupti.','Nihil sunt culpa fuga qui doloribus quis. Nemo reiciendis voluptatibus cum qui ipsum pariatur.','Nam minus veniam et.'),(78,39,'ar','سيارة 39','شامل','شخصي','Sit quidem ea quos in ad.','سيارة 39','وصف السيارة 39','صورة سيارة 39'),(79,40,'en','Weimann-Will 1977','Comprehensive','Personal','Autem aperiam velit tempore pariatur aspernatur.','Porro qui sint quia reiciendis veniam et.','Autem impedit voluptate sed qui non et. Ullam sapiente nihil dolor autem qui deserunt. Sed voluptatibus assumenda inventore ut error.','Qui qui veritatis maxime quis.'),(80,40,'ar','سيارة 40','شامل','شخصي','Voluptatum quia minus sint optio iste unde.','سيارة 40','وصف السيارة 40','صورة سيارة 40'),(81,41,'en','Batz Ltd 1985','Comprehensive','Personal','Optio nam accusamus recusandae quidem vel ut.','Voluptas quidem consectetur quis ipsa rerum ut.','Dolorem aliquid et mollitia et beatae. Velit et aut et consequuntur dolores consequatur.','Quam molestiae autem totam exercitationem.'),(82,41,'ar','سيارة 41','شامل','شخصي','Asperiores ut hic architecto sed nesciunt hic recusandae.','سيارة 41','وصف السيارة 41','صورة سيارة 41'),(83,42,'en','Orn and Sons 2011','Comprehensive','Personal','Saepe non ratione ratione quia.','Voluptates perferendis harum minima corporis.','Id veniam id perferendis quo dolores fugit ex. Quia iure molestiae sed ipsa asperiores nihil. Laboriosam tenetur nihil nulla quibusdam suscipit. Nobis laborum occaecati aut vitae.','Saepe aut cupiditate ipsum.'),(84,42,'ar','سيارة 42','شامل','شخصي','Repudiandae ut id nulla voluptatibus ullam fuga.','سيارة 42','وصف السيارة 42','صورة سيارة 42'),(85,43,'en','Satterfield Ltd 2024','Comprehensive','Personal','Nesciunt veniam tempora consequatur omnis.','Corporis nulla accusantium est aliquid mollitia minus ut.','Numquam iste odio fugiat. Architecto nemo explicabo magnam esse enim. Molestiae temporibus omnis rerum ipsa. Nisi sed debitis dolorum.','Non quo error.'),(86,43,'ar','سيارة 43','شامل','شخصي','Asperiores et consectetur ut.','سيارة 43','وصف السيارة 43','صورة سيارة 43'),(87,44,'en','Cummerata Group 2016','Comprehensive','Personal','Explicabo qui ut deserunt autem officiis ea quis.','Aut eum ipsa hic nam nulla.','Recusandae ad accusantium animi ea. Consequatur rerum laborum odio cum unde.','Et iusto ut voluptas.'),(88,44,'ar','سيارة 44','شامل','شخصي','Est sit id nostrum facere praesentium quia.','سيارة 44','وصف السيارة 44','صورة سيارة 44'),(89,45,'en','Stroman-Schuster 1976','Comprehensive','Personal','Facere repellat ratione beatae aut eos libero voluptatem.','Eius error excepturi reprehenderit molestias odit vero ut.','Veritatis quis alias maxime qui id. Laudantium quo pariatur illum. Velit sapiente non consequatur eos. Quisquam amet ea aperiam rerum debitis sequi soluta.','Laboriosam cupiditate ut.'),(90,45,'ar','سيارة 45','شامل','شخصي','Pariatur ducimus rerum veniam neque quidem molestiae aut.','سيارة 45','وصف السيارة 45','صورة سيارة 45'),(91,46,'en','Frami-Kerluke 2023','Comprehensive','Personal','Illum corrupti perspiciatis tenetur commodi doloribus adipisci.','Et omnis nisi et.','Reiciendis autem doloribus nulla vel in repellat. Voluptates repellat minima laborum est magni similique et. Esse qui ut enim architecto ea. Provident et qui repellendus sequi.','Est non qui.'),(92,46,'ar','سيارة 46','شامل','شخصي','Voluptatem consequatur quae quo ut recusandae enim sunt.','سيارة 46','وصف السيارة 46','صورة سيارة 46'),(93,47,'en','Hammes and Sons 1980','Comprehensive','Personal','Aut quia sunt alias.','Beatae velit illum sit voluptatem.','Iste nesciunt sapiente facilis officia ut. Voluptas maxime fugit eum dolorem quia officiis aspernatur. Cumque corrupti qui tenetur sint est. Distinctio officia aspernatur aut eum quae at pariatur. Harum officiis in sint aut sapiente aut.','Delectus aperiam maiores et.'),(94,47,'ar','سيارة 47','شامل','شخصي','Ex est est rem recusandae voluptas aut impedit.','سيارة 47','وصف السيارة 47','صورة سيارة 47'),(95,48,'en','Schumm, Spencer and Pfannerstill 1987','Comprehensive','Personal','Accusantium sapiente minus dolorem reiciendis exercitationem.','Beatae non aperiam ea cum debitis.','Corporis tenetur voluptatem et maxime. Sequi provident quisquam non. Quidem ipsum soluta quisquam deleniti reiciendis. Esse mollitia quia culpa rerum ipsam omnis voluptatem.','Quia aut atque.'),(96,48,'ar','سيارة 48','شامل','شخصي','Consequatur sit error quia fugit nesciunt quibusdam odio.','سيارة 48','وصف السيارة 48','صورة سيارة 48'),(97,49,'en','Christiansen Ltd 1987','Comprehensive','Personal','Ut sint enim ut facilis expedita ut repudiandae quia.','Nam hic dolore itaque.','Dolorem officiis enim sint cumque et expedita alias voluptatem. Voluptatem sint dicta non voluptatem delectus quisquam. Incidunt similique consequuntur quasi molestiae ipsum non et.','Placeat id sed.'),(98,49,'ar','سيارة 49','شامل','شخصي','Recusandae nobis neque officia corporis cum voluptas.','سيارة 49','وصف السيارة 49','صورة سيارة 49'),(99,50,'en','Howell-Prosacco 1985','Comprehensive','Personal','Est quae nesciunt sit ea ab libero mollitia.','Esse ea aliquid earum voluptate atque.','Quis unde inventore possimus optio voluptatem. Ipsum voluptate excepturi et ab. Veniam saepe optio at exercitationem dolorem.','Omnis fuga.'),(100,50,'ar','سيارة 50','شامل','شخصي','Odit et porro perferendis quod est atque.','سيارة 50','وصف السيارة 50','صورة سيارة 50'),(101,51,'en','marcedes','Comprehensive','Personal','marcedes car','marcedes','marcedes car',NULL),(102,51,'ar','مرسيدس','شامل','شخصي','سياره مرسيدس AMG','مرسيدس','سياره مرسيدس AMG',NULL),(103,52,'en','sayed','Comprehensive','Personal','vxvsvvs','sayed','vxvsvvs',NULL),(104,52,'ar','sayed','شامل','شخصي','bsbshhs','sayed','bsbshhs',NULL),(105,53,'en','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(106,53,'ar','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(107,54,'en','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(108,54,'ar','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(109,55,'en','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(110,55,'ar','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(111,56,'en','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(112,56,'ar','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(113,57,'en','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(114,57,'ar','sayed car1','Third Party','Family','gzgzhzhgsgs','sayed car1','gzgzhzhgsgs',NULL),(115,58,'en','sayesd','Full Coverage','Commercial','hdhshahahahsh','sayesd','hdhshahahahsh',NULL),(116,58,'ar','sayesd','Full Coverage','Commercial','hdhshahahahsh','sayesd','hdhshahahahsh',NULL),(117,59,'en','sayed','Comprehensive','Personal','gsgsgsggsa','sayed','gsgsgsggsa',NULL),(118,59,'ar','sayed','Comprehensive','Personal','gsgsgsggsa','sayed','gsgsgsggsa',NULL),(119,60,'en','sayed car100100','Comprehensive','Personal','A comfortable sedan','Toyota Camry 2023 for Rent','Rent a comfortable Toyota Camry 2023 in Mansoura.','Toyota Camry 2023'),(120,60,'ar','مارسيدس','شامل','شخصي','سيدان مريحة','تويوتا كامري 2023 للإيجار','استأجر تويوتا كامري 2023 المريحة في المنصورة.','تويوتا كامري 2023'),(121,62,'en','sayes','شامل','شخصي','hbbd','sayes','hbbd',NULL),(122,62,'ar','sayes','شامل','شخصي','hbbd','sayes','hbbd',NULL);
/*!40000 ALTER TABLE `car_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_type_translations`
--

DROP TABLE IF EXISTS `car_type_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_type_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_type_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_type_translations_car_type_id_locale_unique` (`car_type_id`,`locale`),
  KEY `car_type_translations_locale_index` (`locale`),
  CONSTRAINT `car_type_translations_car_type_id_foreign` FOREIGN KEY (`car_type_id`) REFERENCES `car_types` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_type_translations`
--

LOCK TABLES `car_type_translations` WRITE;
/*!40000 ALTER TABLE `car_type_translations` DISABLE KEYS */;
INSERT INTO `car_type_translations` VALUES (1,1,'en','Sedan','Sedan cars',NULL,NULL,NULL),(2,1,'ar','Sedan','Sedan سيارات',NULL,NULL,NULL),(3,2,'en','SUV','SUV cars',NULL,NULL,NULL),(4,2,'ar','SUV','SUV سيارات',NULL,NULL,NULL),(5,3,'en','Hatchback','Hatchback cars',NULL,NULL,NULL),(6,3,'ar','Hatchback','Hatchback سيارات',NULL,NULL,NULL),(7,4,'en','Coupe','Coupe cars',NULL,NULL,NULL),(8,4,'ar','Coupe','Coupe سيارات',NULL,NULL,NULL),(9,5,'en','Convertible','Convertible cars',NULL,NULL,NULL),(10,5,'ar','Convertible','Convertible سيارات',NULL,NULL,NULL);
/*!40000 ALTER TABLE `car_type_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `car_types`
--

DROP TABLE IF EXISTS `car_types`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `car_types` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_svg` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `car_types_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `car_types`
--

LOCK TABLES `car_types` WRITE;
/*!40000 ALTER TABLE `car_types` DISABLE KEYS */;
INSERT INTO `car_types` VALUES (1,'sedan','sedan.jpg',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00',NULL),(2,'suv','suv.jpg',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00',NULL),(3,'hatchback','hatchback.jpg',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00',NULL),(4,'coupe','coupe.jpg',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00',NULL),(5,'convertible','convertible.jpg',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00',NULL);
/*!40000 ALTER TABLE `car_types` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cars`
--

DROP TABLE IF EXISTS `cars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cars` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `car_type_id` bigint unsigned NOT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `main_image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `extra_images` json DEFAULT NULL,
  `engine_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plate_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rental_price` decimal(8,2) NOT NULL,
  `availability_start` datetime NOT NULL,
  `availability_end` datetime NOT NULL,
  `latitude` decimal(10,7) DEFAULT NULL,
  `longitude` decimal(10,7) DEFAULT NULL,
  `long_term_guarantee` tinyint(1) NOT NULL DEFAULT '0',
  `pickup_delivery` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cars_slug_unique` (`slug`),
  KEY `cars_user_id_foreign` (`user_id`),
  KEY `cars_car_type_id_foreign` (`car_type_id`),
  CONSTRAINT `cars_car_type_id_foreign` FOREIGN KEY (`car_type_id`) REFERENCES `car_types` (`id`) ON DELETE CASCADE,
  CONSTRAINT `cars_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=63 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cars`
--

LOCK TABLES `cars` WRITE;
/*!40000 ALTER TABLE `cars` DISABLE KEYS */;
INSERT INTO `cars` VALUES (1,2,1,'2001','Blue','car1.jpg','[\"https://via.placeholder.com/640x480.png/0066aa?text=est\", \"https://via.placeholder.com/640x480.png/0000bb?text=ipsam\"]','V4','sedan-1','green',71.32,'2025-08-31 19:48:02','2025-12-01 19:48:02',31.0628000,31.4063810,0,1,1,0,'2025-08-31 16:48:02','2025-08-31 16:48:02',NULL),(2,2,5,'2000','Red','car2.jpg','[\"https://via.placeholder.com/640x480.png/00dd33?text=et\", \"https://via.placeholder.com/640x480.png/006688?text=ipsam\"]','V8','convertible-2','white',56.46,'2025-08-31 19:48:03','2025-10-31 19:48:03',31.0432760,31.3917940,0,1,1,0,'2025-08-31 16:48:03','2025-08-31 16:48:03',NULL),(3,2,4,'2005','Gray','car3.jpg','[\"https://via.placeholder.com/640x480.png/002233?text=animi\", \"https://via.placeholder.com/640x480.png/00dd99?text=dolorem\"]','V4','coupe-3','green',66.23,'2025-08-31 19:48:04','2026-01-31 19:48:04',31.0400630,31.4106840,1,0,1,0,'2025-08-31 16:48:04','2025-08-31 16:48:04',NULL),(4,2,1,'1970','White','car4.jpg','[\"https://via.placeholder.com/640x480.png/00aa00?text=ea\", \"https://via.placeholder.com/640x480.png/00dd99?text=eveniet\"]','V6','sedan-4','green',116.87,'2025-08-31 19:48:05','2025-12-01 19:48:05',31.0408840,31.4135950,0,1,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(5,2,5,'2017','Blue','car5.jpg','[\"https://via.placeholder.com/640x480.png/004444?text=harum\", \"https://via.placeholder.com/640x480.png/009955?text=qui\"]','V8','convertible-5','white',196.54,'2025-08-31 19:48:06','2026-01-31 19:48:06',31.0392030,31.4047220,1,1,1,0,'2025-08-31 16:48:06','2025-08-31 16:48:06',NULL),(6,2,1,'1980','Red','car6.jpg','[\"https://via.placeholder.com/640x480.png/003322?text=exercitationem\", \"https://via.placeholder.com/640x480.png/0055cc?text=numquam\"]','V8','sedan-6','white',108.69,'2025-08-31 19:48:06','2026-01-31 19:48:06',31.0565200,31.4012130,1,1,1,0,'2025-08-31 16:48:06','2025-08-31 16:48:06',NULL),(7,2,4,'2023','Black','car7.jpg','[\"https://via.placeholder.com/640x480.png/00bb22?text=autem\", \"https://via.placeholder.com/640x480.png/0022cc?text=dolore\"]','V8','coupe-7','white',142.57,'2025-08-31 19:48:07','2026-01-31 19:48:07',31.0519790,31.3985910,0,0,1,0,'2025-08-31 16:48:07','2025-08-31 16:48:07',NULL),(8,2,5,'1977','White','car8.jpg','[\"https://via.placeholder.com/640x480.png/00ffaa?text=facilis\", \"https://via.placeholder.com/640x480.png/000022?text=eos\"]','V8','convertible-8','green',191.14,'2025-08-31 19:48:07','2025-10-31 19:48:07',31.0395900,31.3909130,1,0,1,0,'2025-08-31 16:48:07','2025-08-31 16:48:07',NULL),(9,2,4,'1986','White','car9.jpg','[\"https://via.placeholder.com/640x480.png/002244?text=iste\", \"https://via.placeholder.com/640x480.png/00eeff?text=adipisci\"]','V4','coupe-9','white',123.68,'2025-08-31 19:48:08','2025-12-31 19:48:08',31.0488120,31.4078950,1,1,1,0,'2025-08-31 16:48:08','2025-08-31 16:48:08',NULL),(10,2,5,'2024','Black','car10.jpg','[\"https://via.placeholder.com/640x480.png/00dd11?text=distinctio\", \"https://via.placeholder.com/640x480.png/0044aa?text=itaque\"]','V4','convertible-10','green',148.69,'2025-08-31 19:48:09','2025-12-01 19:48:09',31.0630470,31.3910270,1,1,1,0,'2025-08-31 16:48:09','2025-08-31 16:48:09',NULL),(11,2,2,'2021','Red','car11.jpg','[\"https://via.placeholder.com/640x480.png/00cc44?text=qui\", \"https://via.placeholder.com/640x480.png/00ee55?text=quisquam\"]','V8','suv-11','green',71.16,'2025-08-31 19:48:09','2026-03-03 19:48:09',31.0603820,31.4004430,1,1,1,0,'2025-08-31 16:48:09','2025-08-31 16:48:09',NULL),(12,2,1,'2002','Red','car12.jpg','[\"https://via.placeholder.com/640x480.png/0088bb?text=nemo\", \"https://via.placeholder.com/640x480.png/00ccaa?text=fuga\"]','V6','sedan-12','white',67.87,'2025-08-31 19:48:10','2026-03-03 19:48:10',31.0465700,31.4096330,0,0,1,0,'2025-08-31 16:48:10','2025-08-31 16:48:10',NULL),(13,2,4,'2011','Blue','car13.jpg','[\"https://via.placeholder.com/640x480.png/008855?text=neque\", \"https://via.placeholder.com/640x480.png/00ff66?text=dolore\"]','V6','coupe-13','white',97.30,'2025-08-31 19:48:10','2025-12-01 19:48:10',31.0641190,31.4056950,1,0,1,0,'2025-08-31 16:48:10','2025-08-31 16:48:10',NULL),(14,2,1,'2024','Black','car14.jpg','[\"https://via.placeholder.com/640x480.png/00ff55?text=qui\", \"https://via.placeholder.com/640x480.png/000077?text=est\"]','V8','sedan-14','white',135.14,'2025-08-31 19:48:11','2025-12-31 19:48:11',31.0634660,31.3942050,1,0,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(15,2,3,'2004','Blue','car15.jpg','[\"https://via.placeholder.com/640x480.png/0055bb?text=nam\", \"https://via.placeholder.com/640x480.png/007788?text=magnam\"]','V4','hatchback-15','green',55.79,'2025-08-31 19:48:11','2025-10-01 19:48:11',31.0375680,31.3966810,1,0,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(16,2,4,'1976','Black','car16.jpg','[\"https://via.placeholder.com/640x480.png/008888?text=quam\", \"https://via.placeholder.com/640x480.png/0099cc?text=occaecati\"]','V6','coupe-16','green',145.38,'2025-08-31 19:48:12','2025-12-01 19:48:12',31.0444190,31.3955420,1,0,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(17,2,4,'2006','White','car17.jpg','[\"https://via.placeholder.com/640x480.png/004444?text=magnam\", \"https://via.placeholder.com/640x480.png/007733?text=qui\"]','V6','coupe-17','green',125.66,'2025-08-31 19:48:12','2026-03-03 19:48:12',31.0470320,31.3898140,0,1,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(18,2,2,'1973','Black','car18.jpg','[\"https://via.placeholder.com/640x480.png/0099bb?text=explicabo\", \"https://via.placeholder.com/640x480.png/00cc88?text=doloremque\"]','V6','suv-18','white',182.08,'2025-08-31 19:48:12','2025-12-01 19:48:12',31.0437140,31.3852890,1,1,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(19,2,1,'1997','Black','car19.jpg','[\"https://via.placeholder.com/640x480.png/006688?text=reiciendis\", \"https://via.placeholder.com/640x480.png/003366?text=dolore\"]','V4','sedan-19','green',59.91,'2025-08-31 19:48:13','2025-10-31 19:48:13',31.0498400,31.4013830,1,0,1,0,'2025-08-31 16:48:13','2025-08-31 16:48:13',NULL),(20,2,2,'1985','Blue','car20.jpg','[\"https://via.placeholder.com/640x480.png/001133?text=et\", \"https://via.placeholder.com/640x480.png/00bbaa?text=est\"]','V6','suv-20','green',64.27,'2025-08-31 19:48:13','2026-01-31 19:48:13',31.0580740,31.3824680,0,1,1,0,'2025-08-31 16:48:13','2025-08-31 16:48:13',NULL),(21,2,5,'1997','Gray','car21.jpg','[\"https://via.placeholder.com/640x480.png/007700?text=magni\", \"https://via.placeholder.com/640x480.png/00aa55?text=praesentium\"]','V6','convertible-21','green',124.80,'2025-08-31 19:48:14','2025-10-31 19:48:14',31.0566850,31.3854400,0,1,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(22,2,3,'2025','Black','car22.jpg','[\"https://via.placeholder.com/640x480.png/00ccbb?text=dolores\", \"https://via.placeholder.com/640x480.png/00ff55?text=aut\"]','V6','hatchback-22','green',124.31,'2025-08-31 19:48:14','2026-01-31 19:48:14',31.0453000,31.3804400,0,0,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(23,2,1,'1987','Red','car23.jpg','[\"https://via.placeholder.com/640x480.png/0077cc?text=dolor\", \"https://via.placeholder.com/640x480.png/009999?text=ea\"]','V4','sedan-23','green',140.05,'2025-08-31 19:48:14','2026-03-03 19:48:14',31.0620020,31.4118780,1,1,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(24,2,1,'2022','Gray','car24.jpg','[\"https://via.placeholder.com/640x480.png/00ee00?text=reprehenderit\", \"https://via.placeholder.com/640x480.png/00ee99?text=exercitationem\"]','V4','sedan-24','white',125.01,'2025-08-31 19:48:15','2025-12-01 19:48:15',31.0454250,31.3916010,1,1,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(25,2,3,'2000','Gray','car25.jpg','[\"https://via.placeholder.com/640x480.png/007733?text=repellat\", \"https://via.placeholder.com/640x480.png/002266?text=modi\"]','V6','hatchback-25','white',107.50,'2025-08-31 19:48:15','2026-01-31 19:48:15',31.0372340,31.4003140,0,1,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(26,2,5,'1971','Blue','car26.jpg','[\"https://via.placeholder.com/640x480.png/00cc11?text=suscipit\", \"https://via.placeholder.com/640x480.png/0055ee?text=officiis\"]','V8','convertible-26','green',177.66,'2025-08-31 19:48:15','2025-12-01 19:48:15',31.0505580,31.4044150,0,0,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(27,2,2,'2021','Red','car27.jpg','[\"https://via.placeholder.com/640x480.png/00aa88?text=culpa\", \"https://via.placeholder.com/640x480.png/0088ee?text=esse\"]','V6','suv-27','white',104.77,'2025-08-31 19:48:16','2025-10-31 19:48:16',31.0460990,31.3950430,0,1,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(28,2,1,'1996','Red','car28.jpg','[\"https://via.placeholder.com/640x480.png/0033dd?text=dolorum\", \"https://via.placeholder.com/640x480.png/00ee66?text=tenetur\"]','V6','sedan-28','green',63.74,'2025-08-31 19:48:16','2025-12-31 19:48:16',31.0456700,31.4052250,0,1,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(29,2,1,'2022','Blue','car29.jpg','[\"https://via.placeholder.com/640x480.png/007799?text=molestiae\", \"https://via.placeholder.com/640x480.png/0077ff?text=nemo\"]','V4','sedan-29','green',155.71,'2025-08-31 19:48:17','2025-12-01 19:48:17',31.0540030,31.4125190,0,1,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(30,2,1,'1997','Red','car30.jpg','[\"https://via.placeholder.com/640x480.png/0022cc?text=laboriosam\", \"https://via.placeholder.com/640x480.png/005544?text=eaque\"]','V4','sedan-30','green',169.99,'2025-08-31 19:48:17','2026-03-03 19:48:17',31.0562650,31.3910190,1,1,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(31,2,2,'2016','Red','car31.jpg','[\"https://via.placeholder.com/640x480.png/004455?text=quisquam\", \"https://via.placeholder.com/640x480.png/004455?text=a\"]','V6','suv-31','white',195.47,'2025-08-31 19:48:18','2025-12-31 19:48:18',31.0377050,31.3891270,0,1,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(32,2,2,'1985','Blue','car32.jpg','[\"https://via.placeholder.com/640x480.png/000011?text=adipisci\", \"https://via.placeholder.com/640x480.png/00ccff?text=eveniet\"]','V6','suv-32','green',185.07,'2025-08-31 19:48:18','2025-12-31 19:48:18',31.0437710,31.3888580,0,0,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(33,2,5,'2016','Black','car33.jpg','[\"https://via.placeholder.com/640x480.png/004444?text=iste\", \"https://via.placeholder.com/640x480.png/00ccff?text=cupiditate\"]','V6','convertible-33','white',180.40,'2025-08-31 19:48:18','2025-12-01 19:48:18',31.0458580,31.4014120,1,0,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(34,2,3,'2020','Red','car34.jpg','[\"https://via.placeholder.com/640x480.png/0099cc?text=accusantium\", \"https://via.placeholder.com/640x480.png/004444?text=mollitia\"]','V8','hatchback-34','white',61.29,'2025-08-31 19:48:19','2026-03-03 19:48:19',31.0575330,31.4109440,1,0,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(35,2,4,'2002','Red','car35.jpg','[\"https://via.placeholder.com/640x480.png/004433?text=omnis\", \"https://via.placeholder.com/640x480.png/007700?text=non\"]','V8','coupe-35','green',130.47,'2025-08-31 19:48:19','2026-03-03 19:48:19',31.0447220,31.3889780,1,0,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(36,2,2,'1994','Gray','car36.jpg','[\"https://via.placeholder.com/640x480.png/0000cc?text=in\", \"https://via.placeholder.com/640x480.png/008800?text=dolorem\"]','V6','suv-36','white',69.96,'2025-08-31 19:48:20','2025-12-31 19:48:20',31.0496490,31.3946100,0,1,1,0,'2025-08-31 16:48:20','2025-08-31 16:48:20',NULL),(37,2,1,'1997','White','car37.jpg','[\"https://via.placeholder.com/640x480.png/00dd00?text=molestias\", \"https://via.placeholder.com/640x480.png/0077aa?text=voluptas\"]','V8','sedan-37','white',62.12,'2025-08-31 19:48:20','2025-12-01 19:48:20',31.0406250,31.4104740,1,1,1,0,'2025-08-31 16:48:20','2025-08-31 16:48:20',NULL),(38,2,4,'1992','Blue','car38.jpg','[\"https://via.placeholder.com/640x480.png/0000dd?text=itaque\", \"https://via.placeholder.com/640x480.png/001122?text=dolore\"]','V6','coupe-38','white',149.99,'2025-08-31 19:48:21','2025-10-31 19:48:21',31.0398220,31.4013680,1,1,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(39,2,5,'1998','Black','car39.jpg','[\"https://via.placeholder.com/640x480.png/000033?text=et\", \"https://via.placeholder.com/640x480.png/00dd88?text=illo\"]','V8','convertible-39','white',134.16,'2025-08-31 19:48:21','2026-03-03 19:48:21',31.0587050,31.3978620,1,0,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(40,2,4,'1977','Gray','car40.jpg','[\"https://via.placeholder.com/640x480.png/0011ff?text=sunt\", \"https://via.placeholder.com/640x480.png/003344?text=consectetur\"]','V8','coupe-40','white',66.66,'2025-08-31 19:48:22','2026-01-31 19:48:22',31.0464760,31.3986860,1,1,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(41,2,2,'1985','Blue','car41.jpg','[\"https://via.placeholder.com/640x480.png/00aa99?text=minus\", \"https://via.placeholder.com/640x480.png/00aacc?text=fugit\"]','V8','suv-41','green',162.37,'2025-08-31 19:48:22','2025-12-01 19:48:22',31.0533220,31.3792120,1,1,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(42,2,2,'2011','Red','car42.jpg','[\"https://via.placeholder.com/640x480.png/00ff66?text=dolorum\", \"https://via.placeholder.com/640x480.png/001166?text=maxime\"]','V4','suv-42','white',52.05,'2025-08-31 19:48:22','2025-12-01 19:48:22',31.0415930,31.4016940,0,1,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(43,2,5,'2024','Red','car43.jpg','[\"https://via.placeholder.com/640x480.png/00ddee?text=laborum\", \"https://via.placeholder.com/640x480.png/000099?text=dolorum\"]','V6','convertible-43','white',137.35,'2025-08-31 19:48:23','2025-10-31 19:48:23',31.0607800,31.3999250,0,1,1,0,'2025-08-31 16:48:23','2025-08-31 16:48:23',NULL),(44,2,1,'2016','Blue','car44.jpg','[\"https://via.placeholder.com/640x480.png/00ee88?text=corporis\", \"https://via.placeholder.com/640x480.png/005599?text=quae\"]','V8','sedan-44','white',163.07,'2025-08-31 19:48:24','2025-12-31 19:48:24',31.0531740,31.3895720,1,0,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(45,2,5,'1976','Gray','car45.jpg','[\"https://via.placeholder.com/640x480.png/005555?text=et\", \"https://via.placeholder.com/640x480.png/0033bb?text=explicabo\"]','V6','convertible-45','white',93.32,'2025-08-31 19:48:24','2025-12-01 19:48:24',31.0510980,31.3871500,0,1,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(46,2,2,'2023','Black','car46.jpg','[\"https://via.placeholder.com/640x480.png/008833?text=voluptatem\", \"https://via.placeholder.com/640x480.png/001155?text=voluptas\"]','V4','suv-46','white',150.94,'2025-08-31 19:48:24','2025-10-01 19:48:24',31.0623050,31.3833470,1,0,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(47,2,2,'1980','Red','car47.jpg','[\"https://via.placeholder.com/640x480.png/002244?text=cum\", \"https://via.placeholder.com/640x480.png/00ff00?text=voluptatem\"]','V8','suv-47','white',54.40,'2025-08-31 19:48:25','2025-10-31 19:48:25',31.0440960,31.3903480,1,1,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(48,2,5,'1987','Blue','car48.jpg','[\"https://via.placeholder.com/640x480.png/0022cc?text=dolorem\", \"https://via.placeholder.com/640x480.png/009977?text=distinctio\"]','V8','convertible-48','white',59.33,'2025-08-31 19:48:25','2026-01-31 19:48:25',31.0618800,31.3805310,1,1,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(49,2,3,'1987','Black','car49.jpg','[\"https://via.placeholder.com/640x480.png/0099cc?text=maiores\", \"https://via.placeholder.com/640x480.png/0044bb?text=quae\"]','V6','hatchback-49','white',51.49,'2025-08-31 19:48:25','2025-10-01 19:48:25',31.0441190,31.3841820,0,1,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(50,2,2,'1985','Blue','car50.jpg','[\"https://via.placeholder.com/640x480.png/0066aa?text=aperiam\", \"https://via.placeholder.com/640x480.png/008811?text=laboriosam\"]','V8','suv-50','white',92.79,'2025-08-31 19:48:26','2025-12-01 19:48:26',31.0531840,31.4065880,1,1,1,0,'2025-08-31 16:48:26','2025-08-31 16:48:26',NULL),(51,7,1,'672','Red','/storage/cars/main/V0aU3VS4VNjB8Lv6cJkSlwaeBKzsq7m7MPlosCi6.jpg','[\"/storage/cars/extra/MGhZ5ZnR76VanJ5eqfoTFvj8rfulgQYQJjJSNLgz.jpg\"]','Petrol','marcedes--1756671054262','Private',200.00,'2025-08-31 00:00:00','2026-02-27 00:00:00',31.0554629,31.4099189,1,1,1,0,'2025-08-31 17:11:44','2025-08-31 17:11:44',NULL),(52,8,1,'hsbshsha','Black','/storage/cars/main/5yWR5oeokk1ORNePRX8RegWQQrt4uZr7zcKyGOGi.jpg','[\"/storage/cars/extra/9xVvy6Doc2bwJMgLNRBzdnJpNHXgPctCb5JqaVUf.jpg\"]','Petrol','sayed-1756672333828','Commercial',100.00,'2025-08-31 00:00:00','2025-09-01 00:00:00',31.2723135,30.7879820,1,1,1,0,'2025-08-31 17:32:18','2025-09-01 04:29:22','2025-09-01 04:29:22'),(53,8,1,'ggggg','Black','/storage/cars/main/iwzqjQdv8XAgbWETKZBOGkGN2nOap9JHahUwmV2k.jpg','[\"/storage/cars/extra/Az7f9qpvJvgtKqQJEGvddMRu8ToI2QTtkrjSdP1b.jpg\"]','Petrol','sayed-car1-1756711863804','Commercial',50.00,'2025-09-02 00:00:00','2025-09-06 00:00:00',31.0556579,31.4098575,1,1,1,0,'2025-09-01 04:31:05','2025-09-01 04:31:05',NULL),(54,8,1,'ggggg','Black','/storage/cars/main/yiv515jdlosJCCv3vExjqIG4gOonmxygNiwoSgs2.jpg','[\"/storage/cars/extra/rHNQO1LHqKNfxJfpPyu89E2Vk2VdBFl6VvfQNAsZ.jpg\"]','Petrol','sayed-car1-1756711906966','Commercial',50.00,'2025-09-02 00:00:00','2025-09-06 00:00:00',31.0556579,31.4098575,1,1,1,0,'2025-09-01 04:31:48','2025-09-01 04:31:48',NULL),(55,8,1,'ggggg','Black','/storage/cars/main/ohH3i7Mbfs6RBswJy4Q5GDWVA4xz0m6c2A16K4ye.jpg','[\"/storage/cars/extra/1vNbxzxAw1kdPjcuOKL9578pfYjcmx0Jn258LNhI.jpg\"]','Petrol','sayed-car1-1756711933673','Commercial',50.00,'2025-09-02 00:00:00','2025-09-06 00:00:00',31.0556579,31.4098575,1,1,1,0,'2025-09-01 04:32:14','2025-09-01 04:32:14',NULL),(56,8,1,'ggggg','Black','/storage/cars/main/aDqNQQfGauRRJC7HDFTDuC0A1wrXiI55oZHanwJL.jpg','[\"/storage/cars/extra/Fit62TjfzKUopGqW9VzRIa5BcuVJ0tKNKVeamnpI.jpg\"]','Petrol','sayed-car1-1756711951266','Commercial',50.00,'2025-09-02 00:00:00','2025-09-06 00:00:00',31.0556579,31.4098575,1,1,1,0,'2025-09-01 04:32:33','2025-09-01 04:32:33',NULL),(57,8,1,'ggggg','Black','/storage/cars/main/TDyXdJtnCIeMbJZwuMWkiHJsXu4Ihy51jZ0HJCHM.jpg','[\"/storage/cars/extra/yDbZ9Rmhz2RbTlYIu66f0OPpN4jP33FXX9T0XMqW.jpg\"]','Petrol','sayed-car1-1756711970078','Commercial',50.00,'2025-09-02 00:00:00','2025-09-06 00:00:00',31.0556579,31.4098575,1,1,1,0,'2025-09-01 04:32:50','2025-09-01 04:32:50',NULL),(58,8,1,'bnnn','Black','/storage/cars/main/14myJ9mzbJrNdUbZgvcAIMlDWLlKJ2B6vLTTAAlW.jpg','[\"/storage/cars/extra/XYY7n5wt0oBZr1mNZS6lqn0s52vRrCFQwcBTODMS.jpg\"]','Petrol','sayesd-1756712060504','Commercial',50.00,'2025-09-01 00:00:00','2025-09-28 00:00:00',31.0556663,31.4098422,1,1,1,0,'2025-09-01 04:34:21','2025-09-01 04:34:21',NULL),(59,8,1,'hsshhaha','Black','/storage/cars/main/GBcCK8YEd1Z79CDrToeic5iUplDEWwSZIPD6E5O6.jpg','[\"/storage/cars/extra/mbZTwocNRgMPxLhZQzPJkWzHBFMS2Hw3aWEytC8d.jpg\"]','Petrol','sayed-1756712133154','Private',10.00,'2025-09-01 00:00:00','2025-09-29 00:00:00',31.0556663,31.4098422,1,1,1,0,'2025-09-01 04:35:33','2025-09-01 04:35:33',NULL),(60,11,1,'Camry 2023','Black','/storage/cars/main/9oYXYHO1PZrVmQW97131MCbo072hsL9UPh4Y54Hy.jpg','[\"/storage/cars/extra/440B7hbEbq5fN0oqOscgA6790w35tFcUBVYwwFqq.jpg\"]','V6','sdfsdfsdfds55','Private',100.00,'2025-08-31 00:00:00','2025-12-01 00:00:00',24.7136000,46.6753000,1,1,1,0,'2025-09-01 05:05:52','2025-09-01 05:05:52',NULL),(61,8,1,'55555','Black','/storage/cars/main/xVMOtZ2R5Z7SSlBZpR3jngBSU8hCJOTFm0TXRZl6.jpg','[\"/storage/cars/extra/WAPkdJi9RY2WXtWqG4vKh8KftDpIKrbwT3t01P8I.jpg\"]','Petrol','sayes-1756731195380','private',10.00,'2025-09-01 00:00:00','2025-09-26 00:00:00',31.0556476,31.4098689,1,1,1,0,'2025-09-01 09:53:16','2025-09-01 09:53:16',NULL),(62,8,1,'55555','Black','/storage/cars/main/E8YRGejeDHyIp5GdghoiaeXvoXsiBOq0HJ2MFnFk.jpg','[\"/storage/cars/extra/qblKtRKhSpIxMTuNK36ygW07R2nEo87C7uNZBETD.jpg\"]','Petrol','sayes-1756731204923','private',10.00,'2025-09-01 00:00:00','2025-09-26 00:00:00',31.0556476,31.4098689,1,1,1,0,'2025-09-01 09:53:26','2025-09-01 09:53:26',NULL);
/*!40000 ALTER TABLE `cars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'sedan','https://images.unsplash.com/photo-1502877338535-766e1452684a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,1,'2025-08-31 16:47:58','2025-08-31 16:47:58',NULL),(2,'suv','https://images.unsplash.com/photo-1580273916550-ebdde4c6421a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,2,'2025-08-31 16:47:58','2025-08-31 16:47:58',NULL),(3,'hatchback','https://images.unsplash.com/photo-1494976384344-0b8f9e3c6b1a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,3,'2025-08-31 16:47:58','2025-08-31 16:47:58',NULL),(4,'coupe','https://images.unsplash.com/photo-1503376780353-7e6692767b70?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,4,'2025-08-31 16:47:58','2025-08-31 16:47:58',NULL),(5,'convertible','https://images.unsplash.com/photo-1550355291-bbee04a92027?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,5,'2025-08-31 16:47:58','2025-08-31 16:47:58',NULL),(6,'pickup','https://images.unsplash.com/photo-1502741126168-b0f46260bddd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80',1,6,'2025-08-31 16:47:58','2025-08-31 16:47:58',NULL);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_translations`
--

DROP TABLE IF EXISTS `category_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `category_translations_category_id_locale_unique` (`category_id`,`locale`),
  KEY `category_translations_locale_index` (`locale`),
  CONSTRAINT `category_translations_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_translations`
--

LOCK TABLES `category_translations` WRITE;
/*!40000 ALTER TABLE `category_translations` DISABLE KEYS */;
INSERT INTO `category_translations` VALUES (1,1,'en','Sedan','Comfortable and fuel-efficient cars suitable for city driving.',NULL,NULL,NULL),(2,1,'ar','سيدان','سيارات مريحة وموفرة للوقود مناسبة للقيادة في المدينة.',NULL,NULL,NULL),(3,2,'en','SUV','Spacious and versatile vehicles for family trips and off-road adventures.',NULL,NULL,NULL),(4,2,'ar','SUV','سيارات فسيحة ومتعددة الاستخدامات للرحلات العائلية والمغامرات خارج الطريق.',NULL,NULL,NULL),(5,3,'en','Hatchback','Compact cars with a rear door for easy cargo access.',NULL,NULL,NULL),(6,3,'ar','هاتشباك','سيارات مدمجة بباب خلفي لسهولة الوصول للأمتعة.',NULL,NULL,NULL),(7,4,'en','Coupe','Sporty two-door cars with sleek designs.',NULL,NULL,NULL),(8,4,'ar','كوبيه','سيارات رياضية ببابين بتصميم أنيق.',NULL,NULL,NULL),(9,5,'en','Convertible','Cars with retractable roofs for an open-air driving experience.',NULL,NULL,NULL),(10,5,'ar','مكشوفة','سيارات بسقف قابل للطي لتجربة قيادة في الهواء الطلق.',NULL,NULL,NULL),(11,6,'en','Pickup','Rugged trucks designed for heavy-duty tasks and towing.',NULL,NULL,NULL),(12,6,'ar','بيك أب','شاحنات قوية مصممة للمهام الشاقة والسحب.',NULL,NULL,NULL);
/*!40000 ALTER TABLE `category_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `conversations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user1_id` bigint unsigned NOT NULL,
  `user2_id` bigint unsigned NOT NULL,
  `last_message_id` bigint unsigned DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `conversations_user1_id_user2_id_unique` (`user1_id`,`user2_id`),
  KEY `conversations_user2_id_foreign` (`user2_id`),
  KEY `conversations_last_message_id_foreign` (`last_message_id`),
  CONSTRAINT `conversations_last_message_id_foreign` FOREIGN KEY (`last_message_id`) REFERENCES `messages` (`id`) ON DELETE SET NULL,
  CONSTRAINT `conversations_user1_id_foreign` FOREIGN KEY (`user1_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `conversations_user2_id_foreign` FOREIGN KEY (`user2_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

LOCK TABLES `conversations` WRITE;
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
INSERT INTO `conversations` VALUES (1,1,6,1,1,0,'2025-08-31 17:07:22','2025-08-31 17:09:16',NULL),(2,8,9,3,1,0,'2025-09-01 05:26:22','2025-09-01 05:43:29',NULL),(3,10,11,NULL,1,0,'2025-09-01 05:26:31','2025-09-01 05:26:31',NULL);
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extra_option_translations`
--

DROP TABLE IF EXISTS `extra_option_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extra_option_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `extra_option_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `extra_option_translations_extra_option_id_locale_unique` (`extra_option_id`,`locale`),
  KEY `extra_option_translations_locale_index` (`locale`),
  CONSTRAINT `extra_option_translations_extra_option_id_foreign` FOREIGN KEY (`extra_option_id`) REFERENCES `extra_options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extra_option_translations`
--

LOCK TABLES `extra_option_translations` WRITE;
/*!40000 ALTER TABLE `extra_option_translations` DISABLE KEYS */;
INSERT INTO `extra_option_translations` VALUES (1,1,'en','GPS',NULL,NULL,NULL,NULL),(2,1,'ar','نظام تحديد المواقع',NULL,NULL,NULL,NULL),(3,2,'en','Child Seat',NULL,NULL,NULL,NULL),(4,2,'ar','كرسي أطفال',NULL,NULL,NULL,NULL),(5,3,'en','Insurance',NULL,NULL,NULL,NULL),(6,3,'ar','تأمين',NULL,NULL,NULL,NULL),(7,4,'en','WiFi',NULL,NULL,NULL,NULL),(8,4,'ar','انترنت',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `extra_option_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `extra_options`
--

DROP TABLE IF EXISTS `extra_options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `extra_options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `price` decimal(8,2) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `extra_options_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `extra_options`
--

LOCK TABLES `extra_options` WRITE;
/*!40000 ALTER TABLE `extra_options` DISABLE KEYS */;
INSERT INTO `extra_options` VALUES (1,'gps',NULL,15.00,'checkbox',1,0,'2025-08-31 16:48:02','2025-08-31 16:48:02',NULL),(2,'child_seat',NULL,5.00,'checkbox',1,0,'2025-08-31 16:48:02','2025-08-31 16:48:02',NULL),(3,'insurance',NULL,20.00,'checkbox',1,0,'2025-08-31 16:48:02','2025-08-31 16:48:02',NULL),(4,'wifi',NULL,10.00,'checkbox',1,0,'2025-08-31 16:48:02','2025-08-31 16:48:02',NULL);
/*!40000 ALTER TABLE `extra_options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `favorites`
--

DROP TABLE IF EXISTS `favorites`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `favorites` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `car_id` bigint unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `favorites_slug_unique` (`slug`),
  KEY `favorites_user_id_foreign` (`user_id`),
  KEY `favorites_car_id_foreign` (`car_id`),
  CONSTRAINT `favorites_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `favorites_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `favorites`
--

LOCK TABLES `favorites` WRITE;
/*!40000 ALTER TABLE `favorites` DISABLE KEYS */;
INSERT INTO `favorites` VALUES (1,10,60,'user-10-car-60-1756717020',NULL,1,0,'2025-09-01 05:57:00','2025-09-01 05:57:00',NULL),(2,10,53,'user-10-car-53-1756717184',NULL,1,0,'2025-09-01 05:59:44','2025-09-01 05:59:44',NULL),(3,13,1,'user-13-car-1-1756717745',NULL,1,0,'2025-09-01 06:09:05','2025-09-01 06:09:05',NULL),(4,4,6,'user-4-car-6-1756748454',NULL,1,0,'2025-09-01 14:40:54','2025-09-01 14:40:54',NULL),(5,10,59,'user-10-car-59-1756748555',NULL,1,0,'2025-09-01 14:42:35','2025-09-01 14:42:35',NULL),(6,14,3,'user-14-car-3-1756748828',NULL,1,0,'2025-09-01 14:47:08','2025-09-01 14:47:08',NULL),(7,10,4,'user-10-car-4-1756748891',NULL,1,0,'2025-09-01 14:48:11','2025-09-01 14:48:11',NULL),(8,10,42,'user-10-car-42-1756749457',NULL,1,0,'2025-09-01 14:57:37','2025-09-01 14:57:37',NULL),(9,10,1,'user-10-car-1-1756749918',NULL,1,0,'2025-09-01 15:05:18','2025-09-01 15:05:18',NULL),(10,10,39,'user-10-car-39-1756750108',NULL,1,0,'2025-09-01 15:08:28','2025-09-01 15:08:28',NULL);
/*!40000 ALTER TABLE `favorites` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feature_translations`
--

DROP TABLE IF EXISTS `feature_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feature_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_translations_feature_id_locale_unique` (`feature_id`,`locale`),
  KEY `feature_translations_locale_index` (`locale`),
  CONSTRAINT `feature_translations_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feature_translations`
--

LOCK TABLES `feature_translations` WRITE;
/*!40000 ALTER TABLE `feature_translations` DISABLE KEYS */;
INSERT INTO `feature_translations` VALUES (1,1,'en','Color',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(2,1,'ar','اللون',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(3,2,'en','Transmission',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(4,2,'ar','نوع القير',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(5,3,'en','Fuel Type',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(6,3,'ar','نوع الوقود',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(7,4,'en','Seats',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(8,4,'ar','عدد المقاعد',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(9,5,'en','Air Conditioning',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(10,5,'ar','مكيف',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01');
/*!40000 ALTER TABLE `feature_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feature_value_translations`
--

DROP TABLE IF EXISTS `feature_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feature_value_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_value_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_value_translations_feature_value_id_locale_unique` (`feature_value_id`,`locale`),
  KEY `feature_value_translations_locale_index` (`locale`),
  CONSTRAINT `feature_value_translations_feature_value_id_foreign` FOREIGN KEY (`feature_value_id`) REFERENCES `feature_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feature_value_translations`
--

LOCK TABLES `feature_value_translations` WRITE;
/*!40000 ALTER TABLE `feature_value_translations` DISABLE KEYS */;
INSERT INTO `feature_value_translations` VALUES (1,1,'en','Black',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(2,1,'ar','أسود',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(3,2,'en','White',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(4,2,'ar','أبيض',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(5,3,'en','Red',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(6,3,'ar','أحمر',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(7,4,'en','Blue',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(8,4,'ar','أزرق',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(9,5,'en','Gray',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(10,5,'ar','رمادي',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(11,6,'en','Silver',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(12,6,'ar','فضي',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(13,7,'en','Green',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(14,7,'ar','أخضر',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(15,8,'en','Automatic',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(16,8,'ar','أوتوماتيك',NULL,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(17,9,'en','Manual',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(18,9,'ar','يدوي',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(19,10,'en','Petrol',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(20,10,'ar','بنزين',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(21,11,'en','Diesel',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(22,11,'ar','سولار',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(23,12,'en','Electric',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(24,12,'ar','كهرباء',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(25,13,'en','Hybrid',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(26,13,'ar','هايبرد',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(27,14,'en','2',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(28,14,'ar','مقعدين',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(29,15,'en','4',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(30,15,'ar','4 مقاعد',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(31,16,'en','5',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(32,16,'ar','5 مقاعد',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(33,17,'en','7',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(34,17,'ar','7 مقاعد',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(35,18,'en','Yes',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(36,18,'ar','نعم',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(37,19,'en','No',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(38,19,'ar','لا',NULL,'2025-08-31 16:48:01','2025-08-31 16:48:01');
/*!40000 ALTER TABLE `feature_value_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `feature_values`
--

DROP TABLE IF EXISTS `feature_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `feature_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `feature_id` bigint unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `feature_values_slug_unique` (`slug`),
  KEY `feature_values_feature_id_foreign` (`feature_id`),
  CONSTRAINT `feature_values_feature_id_foreign` FOREIGN KEY (`feature_id`) REFERENCES `features` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `feature_values`
--

LOCK TABLES `feature_values` WRITE;
/*!40000 ALTER TABLE `feature_values` DISABLE KEYS */;
INSERT INTO `feature_values` VALUES (1,1,'black',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(2,1,'white',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(3,1,'red',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(4,1,'blue',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(5,1,'gray',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(6,1,'silver',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(7,1,'green',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(8,2,'automatic',NULL,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(9,2,'manual',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(10,3,'petrol',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(11,3,'diesel',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(12,3,'electric',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(13,3,'hybrid',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(14,4,'2',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(15,4,'4',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(16,4,'5',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(17,4,'7',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(18,5,'yes',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(19,5,'no',NULL,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01');
/*!40000 ALTER TABLE `feature_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `features` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'select',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_required` tinyint(1) NOT NULL DEFAULT '1',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `features_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `features`
--

LOCK TABLES `features` WRITE;
/*!40000 ALTER TABLE `features` DISABLE KEYS */;
INSERT INTO `features` VALUES (1,'color','select',NULL,1,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(2,'transmission','select',NULL,1,1,0,'2025-08-31 16:48:00','2025-08-31 16:48:00'),(3,'fuel','select',NULL,1,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(4,'seats','select',NULL,1,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01'),(5,'ac','select',NULL,1,1,0,'2025-08-31 16:48:01','2025-08-31 16:48:01');
/*!40000 ALTER TABLE `features` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `booking_id` bigint unsigned DEFAULT NULL,
  `sender_id` bigint unsigned NOT NULL,
  `receiver_id` bigint unsigned NOT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `conversation_id` bigint unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `messages_slug_unique` (`slug`),
  KEY `messages_booking_id_foreign` (`booking_id`),
  KEY `messages_sender_id_foreign` (`sender_id`),
  KEY `messages_receiver_id_foreign` (`receiver_id`),
  KEY `messages_conversation_id_foreign` (`conversation_id`),
  CONSTRAINT `messages_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `bookings` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_conversation_id_foreign` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_receiver_id_foreign` FOREIGN KEY (`receiver_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `messages_sender_id_foreign` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,NULL,6,1,'اههههه4',NULL,'ahhhhh4-qdtds6',NULL,1,0,'2025-08-31 17:09:16','2025-08-31 17:09:16',NULL,1),(2,NULL,9,8,'gygy','2025-09-01 05:43:25','gygy-fx2som',NULL,1,0,'2025-09-01 05:26:27','2025-09-01 05:43:25',NULL,2),(3,NULL,8,9,'🖕🏻',NULL,'ywc3ub',NULL,1,0,'2025-09-01 05:43:29','2025-09-01 05:43:29',NULL,2);
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_07_13_173204_create_personal_access_tokens_table',1),(5,'2025_07_13_173601_create_permission_tables',1),(6,'2025_07_13_182708_create_translations_table',1),(7,'2025_07_26_182519_create_otps_table',1),(8,'2025_08_16_115600_create_car_types_table',1),(9,'2025_08_16_132100_create_cars_table',1),(10,'2025_08_16_132110_create_tags_table',1),(11,'2025_08_16_132207_create_options_table',1),(12,'2025_08_16_132400_create_extra_options_table',1),(13,'2025_08_16_132638_create_wallets_table',1),(14,'2025_08_16_132751_create_bookings_table',1),(15,'2025_08_16_132907_create_reviews_table',1),(16,'2025_08_16_142024_create_favorites_table',1),(17,'2025_08_17_132003_create_categories_table',1),(18,'2025_08_18_142425_create_messages_table',1),(19,'2025_08_23_000312_create_features_table',1),(20,'2025_08_23_000511_create_feature_values_table',1),(21,'2025_08_23_000624_create_car_feature_values_table',1),(22,'2025_08_29_222306_add_read_at_to_messages_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1),(3,'App\\Models\\User',2),(2,'App\\Models\\User',3),(2,'App\\Models\\User',4),(3,'App\\Models\\User',5),(2,'App\\Models\\User',6),(4,'App\\Models\\User',7),(3,'App\\Models\\User',8),(2,'App\\Models\\User',9),(2,'App\\Models\\User',10),(3,'App\\Models\\User',11),(2,'App\\Models\\User',12),(2,'App\\Models\\User',13),(2,'App\\Models\\User',14);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_translations`
--

DROP TABLE IF EXISTS `option_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `option_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_translations_option_id_locale_unique` (`option_id`,`locale`),
  KEY `option_translations_locale_index` (`locale`),
  CONSTRAINT `option_translations_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_translations`
--

LOCK TABLES `option_translations` WRITE;
/*!40000 ALTER TABLE `option_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `option_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_value_translations`
--

DROP TABLE IF EXISTS `option_value_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `option_value_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_value_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_value_translations_option_value_id_locale_unique` (`option_value_id`,`locale`),
  KEY `option_value_translations_locale_index` (`locale`),
  CONSTRAINT `option_value_translations_option_value_id_foreign` FOREIGN KEY (`option_value_id`) REFERENCES `option_values` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_value_translations`
--

LOCK TABLES `option_value_translations` WRITE;
/*!40000 ALTER TABLE `option_value_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `option_value_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `option_values`
--

DROP TABLE IF EXISTS `option_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `option_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `option_id` bigint unsigned NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `option_values_slug_unique` (`slug`),
  KEY `option_values_option_id_foreign` (`option_id`),
  CONSTRAINT `option_values_option_id_foreign` FOREIGN KEY (`option_id`) REFERENCES `options` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `option_values`
--

LOCK TABLES `option_values` WRITE;
/*!40000 ALTER TABLE `option_values` DISABLE KEYS */;
/*!40000 ALTER TABLE `option_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `options`
--

DROP TABLE IF EXISTS `options`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `options` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `options_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `options`
--

LOCK TABLES `options` WRITE;
/*!40000 ALTER TABLE `options` DISABLE KEYS */;
/*!40000 ALTER TABLE `options` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `otps`
--

DROP TABLE IF EXISTS `otps`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `otps` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `otp_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expires_at` timestamp NOT NULL,
  `is_used` tinyint(1) NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `otps_user_id_foreign` (`user_id`),
  CONSTRAINT `otps_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `otps`
--

LOCK TABLES `otps` WRITE;
/*!40000 ALTER TABLE `otps` DISABLE KEYS */;
INSERT INTO `otps` VALUES (10,12,'728238','2025-09-01 06:12:09',0,1,0,'2025-09-01 06:07:09','2025-09-01 06:07:09',NULL),(12,8,'022391','2025-09-01 09:00:30',0,1,0,'2025-09-01 08:55:30','2025-09-01 08:55:30',NULL);
/*!40000 ALTER TABLE `otps` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'view-dashboard','api','2025-08-31 16:47:56','2025-08-31 16:47:56'),(2,'manage-cars','api','2025-08-31 16:47:56','2025-08-31 16:47:56'),(3,'manage cars','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(4,'manage-bookings','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(5,'chat-with-users','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(6,'manage-wallet','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(7,'manage-features','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(8,'create-car','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(9,'view-bookings','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(10,'book-car','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(11,'cancel-booking','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(12,'confirm-booking','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(13,'manage-offers','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(14,'write-review','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(15,'view-reviews','api','2025-08-31 16:47:57','2025-08-31 16:47:57'),(16,'manage-favourites','api','2025-08-31 16:47:57','2025-08-31 16:47:57');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (2,'App\\Models\\User',5,'auth_token','56be6f972526a584ad4d5909534a058a67992c5f02fc3cc8f16646cd2d285ec5','[\"*\"]',NULL,NULL,'2025-08-31 16:59:00','2025-08-31 16:59:00'),(3,'App\\Models\\User',6,'auth_token','23acbcc259166d5b3464491bfa17c8d75a57a5275c08627f8b6cbc2a03a52e87','[\"*\"]','2025-09-01 04:37:26',NULL,'2025-08-31 17:06:12','2025-09-01 04:37:26'),(4,'App\\Models\\User',7,'auth_token','e36399b0b0216482135756e2f701b8e99e19548665ff2763c55824b0ad78c93c','[\"*\"]',NULL,NULL,'2025-08-31 17:07:17','2025-08-31 17:07:17'),(5,'App\\Models\\User',7,'auth_token','15f2794da1defe41db217c1671cb047cbdc69e703970930f502004fd7aaaf06c','[\"*\"]','2025-08-31 17:17:41',NULL,'2025-08-31 17:08:22','2025-08-31 17:17:41'),(6,'App\\Models\\User',8,'auth_token','7ab9881d649cf8d6ebe4eb5cb2918612fd105448f04d745e89747f599967829d','[\"*\"]',NULL,NULL,'2025-08-31 17:23:28','2025-08-31 17:23:28'),(7,'App\\Models\\User',8,'auth_token','ec1788c19f6ce94422892906700c2141ebd2019d157442955c79b0e00c719eaa','[\"*\"]','2025-09-01 04:41:42',NULL,'2025-08-31 17:24:02','2025-09-01 04:41:42'),(8,'App\\Models\\User',9,'auth_token','8ea993d4ddedbe77e3eddc6f59f49142d7a6dabafdf868879f0d1cb038463fc3','[\"*\"]',NULL,NULL,'2025-09-01 04:41:27','2025-09-01 04:41:27'),(9,'App\\Models\\User',9,'auth_token','8de2fc6861d20eeea35c04d3a9954393bd9ebecc3c96269c6d3290ec8ad88b5b','[\"*\"]','2025-09-01 04:43:31',NULL,'2025-09-01 04:42:16','2025-09-01 04:43:31'),(10,'App\\Models\\User',9,'auth_token','44c22671eb05350b4ff96b89c75628f29c7d78da66c24dfc98bb9a67741186df','[\"*\"]','2025-09-01 05:00:27',NULL,'2025-09-01 04:46:29','2025-09-01 05:00:27'),(11,'App\\Models\\User',10,'auth_token','e58da08563dc480c11c29fef152d0b57047fa5a2f1683a83ef641f2453edbee3','[\"*\"]','2025-09-01 05:13:11',NULL,'2025-09-01 04:47:46','2025-09-01 05:13:11'),(12,'App\\Models\\User',10,'auth_token','f970f31510c3c6e40d3116a78f915f6db0f0ea142829e95ed16c6538def8e41e','[\"*\"]','2025-09-01 15:28:24',NULL,'2025-09-01 04:49:24','2025-09-01 15:28:24'),(13,'App\\Models\\User',9,'auth_token','a0b2f33d9a6021cf175e3a9473d90dcdf7edc1dfcad21e0654d7cfaf17cf82b3','[\"*\"]','2025-09-01 05:06:45',NULL,'2025-09-01 04:51:54','2025-09-01 05:06:45'),(14,'App\\Models\\User',8,'auth_token','8d156f376d58d4aae6c542fb56bebe947c22ebeb583c538a5d115d0543ce5e4c','[\"*\"]','2025-09-01 04:53:34',NULL,'2025-09-01 04:53:08','2025-09-01 04:53:34'),(15,'App\\Models\\User',9,'auth_token','594b8ae3aa5a13accae888340f5052a35cad721af9cfcb28d5d1d6cd880693a5','[\"*\"]',NULL,NULL,'2025-09-01 04:55:38','2025-09-01 04:55:38'),(16,'App\\Models\\User',8,'auth_token','5da8eea8634dfcd1d05967a63f571d12e63999acd1cb0c7cb4067d507fe445fe','[\"*\"]','2025-09-01 05:07:34',NULL,'2025-09-01 05:01:02','2025-09-01 05:07:34'),(17,'App\\Models\\User',8,'auth_token','c6b7ee0e86998d24cb821de04d9fcb31a47adb43e8e2017ecb18d349e5d45824','[\"*\"]','2025-09-01 05:21:16',NULL,'2025-09-01 05:02:49','2025-09-01 05:21:16'),(18,'App\\Models\\User',11,'auth_token','7b5cf21de935327777b1ff48e8ff58b5816276b458761a61a6efe448cb210e7d','[\"*\"]','2025-09-01 05:31:59',NULL,'2025-09-01 05:05:16','2025-09-01 05:31:59'),(19,'App\\Models\\User',9,'auth_token','ad2684394803cbb42b19e7a65df700bf5157f756799da3e4e21126049231d457','[\"*\"]','2025-09-01 05:26:33',NULL,'2025-09-01 05:07:55','2025-09-01 05:26:33'),(20,'App\\Models\\User',8,'auth_token','99b810be6cc140a939eaa8cb81da13ec7d46acede40863c8e4ea88a00f14f8bb','[\"*\"]','2025-09-01 05:28:20',NULL,'2025-09-01 05:26:50','2025-09-01 05:28:20'),(21,'App\\Models\\User',9,'auth_token','86a665e1e702b09b3c82b04acb239855ffcda0e1568a66a38052ab9d08c5de4d','[\"*\"]','2025-09-01 05:30:21',NULL,'2025-09-01 05:28:34','2025-09-01 05:30:21'),(22,'App\\Models\\User',8,'auth_token','09d684bd1627a0ba68bb68cc4248b6e7ae35cba39663ec84c57ec93c4bac663f','[\"*\"]','2025-09-01 05:43:41',NULL,'2025-09-01 05:30:38','2025-09-01 05:43:41'),(23,'App\\Models\\User',8,'auth_token','a9f1ef0529e25fd1268d1e27e562b83378f5febaca5b9bd382a49fa9c2fd2718','[\"*\"]','2025-09-01 05:32:24',NULL,'2025-09-01 05:32:07','2025-09-01 05:32:24'),(24,'App\\Models\\User',9,'auth_token','a5dad0479329469cdd94fb208a6acac54fbb76b7effce87bf2cc2e2a07026f94','[\"*\"]','2025-09-01 05:32:46',NULL,'2025-09-01 05:32:38','2025-09-01 05:32:46'),(25,'App\\Models\\User',8,'auth_token','91903796e34c0dc79450d9bb3492d93d9b59feed5857f764b657914f9d290bda','[\"*\"]','2025-09-01 14:32:47',NULL,'2025-09-01 05:33:21','2025-09-01 14:32:47'),(26,'App\\Models\\User',9,'auth_token','e00045842cbe08b4b2df05cb9f8f99420c0b20ccd760589a5dbc423e87c2c639','[\"*\"]','2025-09-01 07:23:01',NULL,'2025-09-01 05:44:45','2025-09-01 07:23:01'),(27,'App\\Models\\User',8,'auth_token','14baaeabdfaa9378508dda498982d66f4923b3ee8c4b12d826f79fce77c90c6b','[\"*\"]',NULL,NULL,'2025-09-01 05:45:26','2025-09-01 05:45:26'),(28,'App\\Models\\User',9,'auth_token','78b5df29509e776ab704f368addce0dfa8f688c4cb2890a241e870aa8795b299','[\"*\"]','2025-09-01 05:45:54',NULL,'2025-09-01 05:45:37','2025-09-01 05:45:54'),(29,'App\\Models\\User',13,'auth_token','eddac67573fcdf4913149a69f98305074418d7b8f5bf79620bed937c521c0164','[\"*\"]','2025-09-01 06:14:53',NULL,'2025-09-01 06:08:30','2025-09-01 06:14:53'),(30,'App\\Models\\User',8,'auth_token','0e59e138e52c8778c95e3fd7cd63877d33d6e255be9277f1f4c630f864d67866','[\"*\"]','2025-09-01 10:48:46',NULL,'2025-09-01 09:38:50','2025-09-01 10:48:46'),(31,'App\\Models\\User',4,'auth_token','16785ba0dc5080701b3ad28e33dd3818d4cea1ad824d6e45b84a7f5f3121df4f','[\"*\"]','2025-09-01 14:41:25',NULL,'2025-09-01 14:33:47','2025-09-01 14:41:25'),(32,'App\\Models\\User',14,'auth_token','4a2b38f710f27fcc975826a18a7a76eb8b26e38146ce29b548ef8b37eebed5d0','[\"*\"]','2025-09-01 15:29:27',NULL,'2025-09-01 14:46:17','2025-09-01 15:29:27');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `car_id` bigint unsigned NOT NULL,
  `user_id` bigint unsigned NOT NULL,
  `rating` int unsigned NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `reviews_slug_unique` (`slug`),
  KEY `reviews_car_id_foreign` (`car_id`),
  KEY `reviews_user_id_foreign` (`user_id`),
  CONSTRAINT `reviews_car_id_foreign` FOREIGN KEY (`car_id`) REFERENCES `cars` (`id`) ON DELETE CASCADE,
  CONSTRAINT `reviews_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=119 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (1,1,3,5,'Pariatur esse illum temporibus soluta et.','7review-1-1',NULL,1,0,'2025-08-31 16:48:03','2025-08-31 16:48:03',NULL),(2,1,3,3,'Autem tenetur qui quod adipisci qui.','7review-1-2',NULL,1,0,'2025-08-31 16:48:03','2025-08-31 16:48:03',NULL),(3,1,3,4,'Doloremque ea aut tempora soluta.','7review-1-3',NULL,1,0,'2025-08-31 16:48:03','2025-08-31 16:48:03',NULL),(4,1,3,5,'Voluptas cupiditate sequi fuga rerum impedit alias incidunt doloremque.','7review-1-4',NULL,1,0,'2025-08-31 16:48:03','2025-08-31 16:48:03',NULL),(5,1,3,3,'Sint nihil animi aut ab pariatur velit.','7review-1-5',NULL,1,0,'2025-08-31 16:48:03','2025-08-31 16:48:03',NULL),(6,2,3,3,'Explicabo veritatis fugiat similique quas.','7review-2-1',NULL,1,0,'2025-08-31 16:48:04','2025-08-31 16:48:04',NULL),(7,2,3,5,'Quam asperiores cum possimus sapiente.','7review-2-2',NULL,1,0,'2025-08-31 16:48:04','2025-08-31 16:48:04',NULL),(8,3,3,3,'Eligendi doloribus ad quia iure voluptates labore quia reprehenderit.','7review-3-1',NULL,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(9,3,3,5,'Sequi voluptatem blanditiis reiciendis praesentium labore omnis.','7review-3-2',NULL,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(10,3,3,5,'Vel aspernatur non beatae ut dolore sed sed expedita.','7review-3-3',NULL,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(11,3,3,5,'Nihil est quod sit quam.','7review-3-4',NULL,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(12,4,3,4,'Facilis qui id earum id.','7review-4-1',NULL,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(13,4,3,5,'Voluptate distinctio quod ea animi et laboriosam iste.','7review-4-2',NULL,1,0,'2025-08-31 16:48:05','2025-08-31 16:48:05',NULL),(14,5,3,3,'Quidem accusantium expedita ut et omnis eum repellat.','7review-5-1',NULL,1,0,'2025-08-31 16:48:06','2025-08-31 16:48:06',NULL),(15,5,3,3,'Exercitationem accusantium officiis consequatur veniam dolor consequuntur.','7review-5-2',NULL,1,0,'2025-08-31 16:48:06','2025-08-31 16:48:06',NULL),(16,6,3,4,'Et magni tenetur consectetur a iusto in quaerat voluptatum.','7review-6-1',NULL,1,0,'2025-08-31 16:48:07','2025-08-31 16:48:07',NULL),(17,6,3,3,'Et iure placeat quis et amet molestiae quaerat.','7review-6-2',NULL,1,0,'2025-08-31 16:48:07','2025-08-31 16:48:07',NULL),(18,7,3,5,'Totam qui unde ab consequatur id.','7review-7-1',NULL,1,0,'2025-08-31 16:48:07','2025-08-31 16:48:07',NULL),(19,7,3,5,'Eum temporibus facilis soluta maiores omnis sit dolores non.','7review-7-2',NULL,1,0,'2025-08-31 16:48:07','2025-08-31 16:48:07',NULL),(20,8,3,5,'Corrupti dolorem fugiat et ut.','7review-8-1',NULL,1,0,'2025-08-31 16:48:08','2025-08-31 16:48:08',NULL),(21,8,3,3,'Voluptate nihil at mollitia voluptatibus ut magnam dolor.','7review-8-2',NULL,1,0,'2025-08-31 16:48:08','2025-08-31 16:48:08',NULL),(22,8,3,4,'Quo dolorum dolore ipsum quibusdam.','7review-8-3',NULL,1,0,'2025-08-31 16:48:08','2025-08-31 16:48:08',NULL),(23,9,3,3,'Ipsa recusandae quas odio sed.','7review-9-1',NULL,1,0,'2025-08-31 16:48:09','2025-08-31 16:48:09',NULL),(24,9,3,5,'Quibusdam natus a numquam beatae.','7review-9-2',NULL,1,0,'2025-08-31 16:48:09','2025-08-31 16:48:09',NULL),(25,10,3,5,'Distinctio et quisquam corrupti aut.','7review-10-1',NULL,1,0,'2025-08-31 16:48:09','2025-08-31 16:48:09',NULL),(26,11,3,3,'Voluptatibus eum perferendis aut quasi.','7review-11-1',NULL,1,0,'2025-08-31 16:48:10','2025-08-31 16:48:10',NULL),(27,12,3,4,'Labore eos minima aut in consequatur.','7review-12-1',NULL,1,0,'2025-08-31 16:48:10','2025-08-31 16:48:10',NULL),(28,12,3,5,'Dolores cupiditate soluta harum enim.','7review-12-2',NULL,1,0,'2025-08-31 16:48:10','2025-08-31 16:48:10',NULL),(29,13,3,4,'Nostrum et quaerat recusandae nisi id.','7review-13-1',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(30,13,3,5,'Voluptatem quod perferendis ipsa qui.','7review-13-2',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(31,13,3,3,'Magni velit tempora ipsa est cum.','7review-13-3',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(32,13,3,5,'Enim facere aut vel.','7review-13-4',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(33,14,3,3,'Fuga quia accusamus voluptatum.','7review-14-1',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(34,14,3,3,'Natus fuga animi officia recusandae debitis.','7review-14-2',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(35,14,3,5,'Est quia beatae nobis quod ut sunt quod expedita.','7review-14-3',NULL,1,0,'2025-08-31 16:48:11','2025-08-31 16:48:11',NULL),(36,15,3,5,'Ea quis aut tenetur provident et sequi magnam.','7review-15-1',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(37,15,3,4,'Corrupti explicabo officia soluta natus possimus quis similique.','7review-15-2',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(38,15,3,3,'Illo est fuga dolores.','7review-15-3',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(39,16,3,4,'Delectus nam omnis eveniet.','7review-16-1',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(40,16,3,3,'Laboriosam et vel quos perspiciatis soluta ex unde.','7review-16-2',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(41,16,3,4,'Et cum necessitatibus sint beatae omnis.','7review-16-3',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(42,17,3,5,'Repellat quia occaecati molestias quia neque fuga cum aut.','7review-17-1',NULL,1,0,'2025-08-31 16:48:12','2025-08-31 16:48:12',NULL),(43,18,3,3,'Quia unde magni quo quis.','7review-18-1',NULL,1,0,'2025-08-31 16:48:13','2025-08-31 16:48:13',NULL),(44,18,3,3,'Et at veritatis et doloremque praesentium provident sint.','7review-18-2',NULL,1,0,'2025-08-31 16:48:13','2025-08-31 16:48:13',NULL),(45,19,3,4,'Ut nostrum rem eum architecto qui libero.','7review-19-1',NULL,1,0,'2025-08-31 16:48:13','2025-08-31 16:48:13',NULL),(46,19,3,3,'Saepe sit dolorum sed.','7review-19-2',NULL,1,0,'2025-08-31 16:48:13','2025-08-31 16:48:13',NULL),(47,20,3,4,'Sed sed enim quasi dolor consectetur.','7review-20-1',NULL,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(48,20,3,3,'Non culpa sunt sed et.','7review-20-2',NULL,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(49,21,3,3,'Eligendi sit voluptatem vel illo et et doloremque.','7review-21-1',NULL,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(50,21,3,3,'Eum earum ipsa exercitationem ullam amet et nisi.','7review-21-2',NULL,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(51,21,3,5,'Et architecto eos odit qui amet.','7review-21-3',NULL,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(52,22,3,5,'Sint et magni sit reiciendis et consectetur debitis.','7review-22-1',NULL,1,0,'2025-08-31 16:48:14','2025-08-31 16:48:14',NULL),(53,23,3,5,'Deserunt perspiciatis dicta rerum at ex numquam.','7review-23-1',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(54,23,3,3,'Aut quam impedit accusantium quo repudiandae voluptas accusamus explicabo.','7review-23-2',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(55,23,3,5,'Consectetur sit totam dolorem.','7review-23-3',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(56,24,3,4,'Quis a et nemo molestias ut sapiente.','7review-24-1',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(57,24,3,4,'Ducimus facilis molestias voluptates mollitia quibusdam iusto vitae ut.','7review-24-2',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(58,24,3,5,'Ipsam eos unde ex aspernatur et.','7review-24-3',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(59,25,3,3,'Nesciunt nobis dolor fuga in.','7review-25-1',NULL,1,0,'2025-08-31 16:48:15','2025-08-31 16:48:15',NULL),(60,26,3,4,'Consectetur praesentium aut voluptas accusamus.','7review-26-1',NULL,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(61,26,3,3,'Id voluptates atque in doloremque incidunt beatae.','7review-26-2',NULL,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(62,27,3,5,'Sed magnam sit voluptate ut perspiciatis et consectetur.','7review-27-1',NULL,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(63,27,3,4,'Quaerat exercitationem amet omnis.','7review-27-2',NULL,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(64,27,3,3,'Aut omnis quisquam incidunt vel voluptatum a nulla.','7review-27-3',NULL,1,0,'2025-08-31 16:48:16','2025-08-31 16:48:16',NULL),(65,28,3,3,'Asperiores eos expedita assumenda eaque reprehenderit nisi.','7review-28-1',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(66,28,3,4,'Adipisci mollitia eligendi unde deserunt.','7review-28-2',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(67,28,3,5,'Iure sit maxime tempore voluptatem voluptate vitae.','7review-28-3',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(68,29,3,5,'Enim sit adipisci doloribus vero consequatur nemo.','7review-29-1',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(69,29,3,4,'Perspiciatis temporibus aut in aliquam.','7review-29-2',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(70,29,3,3,'Sed eos porro consequuntur id.','7review-29-3',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(71,29,3,4,'Repudiandae assumenda dolorum dignissimos autem eum amet.','7review-29-4',NULL,1,0,'2025-08-31 16:48:17','2025-08-31 16:48:17',NULL),(72,30,3,4,'Sunt quas aut incidunt iure.','7review-30-1',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(73,30,3,4,'Dolores illo labore optio illo corporis.','7review-30-2',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(74,31,3,4,'Est et nobis dicta.','7review-31-1',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(75,31,3,4,'Dolore voluptates numquam placeat asperiores provident excepturi dolor.','7review-31-2',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(76,32,3,4,'Unde delectus tenetur sit accusantium voluptatum.','7review-32-1',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(77,32,3,4,'Omnis vel omnis est quia rerum dolor velit.','7review-32-2',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(78,32,3,3,'Ducimus repellendus ut id pariatur sint natus aut.','7review-32-3',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(79,32,3,3,'Neque mollitia id amet sunt cum.','7review-32-4',NULL,1,0,'2025-08-31 16:48:18','2025-08-31 16:48:18',NULL),(80,33,3,5,'Adipisci qui expedita quaerat sapiente quam voluptatibus.','7review-33-1',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(81,33,3,5,'Magnam neque ab adipisci enim possimus.','7review-33-2',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(82,34,3,4,'Harum et laboriosam aut voluptatem.','7review-34-1',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(83,35,3,4,'Inventore odio provident aut aut quas voluptas officiis.','7review-35-1',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(84,35,3,3,'Ea vel aut eos laborum.','7review-35-2',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(85,35,3,5,'Est dolorem eaque dignissimos.','7review-35-3',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(86,35,3,3,'Recusandae ab omnis distinctio nesciunt vel aspernatur vel.','7review-35-4',NULL,1,0,'2025-08-31 16:48:19','2025-08-31 16:48:19',NULL),(87,36,3,5,'Beatae odio dolores nisi ullam dicta.','7review-36-1',NULL,1,0,'2025-08-31 16:48:20','2025-08-31 16:48:20',NULL),(88,36,3,3,'Enim excepturi quo vero in non debitis omnis.','7review-36-2',NULL,1,0,'2025-08-31 16:48:20','2025-08-31 16:48:20',NULL),(89,36,3,4,'Ea harum quibusdam tenetur possimus ut eum vel.','7review-36-3',NULL,1,0,'2025-08-31 16:48:20','2025-08-31 16:48:20',NULL),(90,37,3,3,'Quia aperiam ratione optio dolorem sunt.','7review-37-1',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(91,37,3,3,'Facere eligendi aperiam dolor ex.','7review-37-2',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(92,38,3,3,'Qui sunt ullam ut accusamus voluptate aut.','7review-38-1',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(93,38,3,3,'Dolore est molestiae possimus perspiciatis incidunt assumenda.','7review-38-2',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(94,38,3,3,'Non est mollitia consequatur minima.','7review-38-3',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(95,38,3,4,'Ullam velit facere distinctio enim praesentium neque.','7review-38-4',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(96,39,3,4,'Laboriosam molestiae incidunt provident excepturi.','7review-39-1',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(97,39,3,5,'Dolor iusto iste dolorem exercitationem consectetur maiores vel voluptas.','7review-39-2',NULL,1,0,'2025-08-31 16:48:21','2025-08-31 16:48:21',NULL),(98,39,3,4,'Voluptate quod animi asperiores eaque sint.','7review-39-3',NULL,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(99,40,3,3,'Fugiat et sed quisquam iste ut.','7review-40-1',NULL,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(100,40,3,3,'Ipsa recusandae natus quo est doloribus perspiciatis.','7review-40-2',NULL,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(101,41,3,4,'Odio facere nisi ad.','7review-41-1',NULL,1,0,'2025-08-31 16:48:22','2025-08-31 16:48:22',NULL),(102,42,3,4,'Ullam et et aperiam totam in neque qui nam.','7review-42-1',NULL,1,0,'2025-08-31 16:48:23','2025-08-31 16:48:23',NULL),(103,42,3,5,'Ut voluptatem ut optio eaque.','7review-42-2',NULL,1,0,'2025-08-31 16:48:23','2025-08-31 16:48:23',NULL),(104,43,3,5,'Ipsa quis consequatur non aut sed neque.','7review-43-1',NULL,1,0,'2025-08-31 16:48:23','2025-08-31 16:48:23',NULL),(105,43,3,3,'Alias cupiditate et itaque distinctio libero magni ut.','7review-43-2',NULL,1,0,'2025-08-31 16:48:23','2025-08-31 16:48:23',NULL),(106,44,3,5,'Eos eveniet non aut saepe quia a.','7review-44-1',NULL,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(107,44,3,3,'Velit ut et ut quam et.','7review-44-2',NULL,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(108,44,3,5,'Laboriosam occaecati placeat maiores optio ipsa soluta libero.','7review-44-3',NULL,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(109,45,3,3,'Incidunt quia quo est.','7review-45-1',NULL,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(110,45,3,4,'Commodi hic consequuntur culpa consequatur cum odio amet.','7review-45-2',NULL,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(111,45,3,5,'Aperiam mollitia cumque quibusdam voluptatem.','7review-45-3',NULL,1,0,'2025-08-31 16:48:24','2025-08-31 16:48:24',NULL),(112,46,3,5,'Alias cumque maxime aut sed consequatur et.','7review-46-1',NULL,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(113,47,3,3,'Animi illum est consequatur.','7review-47-1',NULL,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(114,47,3,4,'Dolorem repellendus dolores neque magni quos et.','7review-47-2',NULL,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(115,48,3,4,'Voluptas error rerum in consequatur molestiae.','7review-48-1',NULL,1,0,'2025-08-31 16:48:25','2025-08-31 16:48:25',NULL),(116,49,3,5,'Voluptatem id reprehenderit neque.','7review-49-1',NULL,1,0,'2025-08-31 16:48:26','2025-08-31 16:48:26',NULL),(117,50,3,3,'Veritatis hic qui nihil minus ratione ex voluptas.','7review-50-1',NULL,1,0,'2025-08-31 16:48:26','2025-08-31 16:48:26',NULL),(118,50,3,4,'Asperiores quia quibusdam sit ducimus rerum.','7review-50-2',NULL,1,0,'2025-08-31 16:48:26','2025-08-31 16:48:26',NULL);
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(7,1),(8,1),(9,1),(10,1),(11,1),(12,1),(13,1),(14,1),(15,1),(16,1),(1,2),(9,2),(10,2),(11,2),(14,2),(15,2),(16,2),(1,3),(2,3),(3,3),(4,3),(6,3),(9,3),(11,3),(12,3),(15,3),(1,4),(2,4),(3,4),(4,4),(6,4),(9,4),(11,4),(12,4),(13,4),(15,4);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','api','2025-08-31 16:47:56','2025-08-31 16:47:56'),(2,'customer','api','2025-08-31 16:47:56','2025-08-31 16:47:56'),(3,'private_renter','api','2025-08-31 16:47:56','2025-08-31 16:47:56'),(4,'rental_office','api','2025-08-31 16:47:56','2025-08-31 16:47:56');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('52Bwn4jhd7WpfQPOyNGD7pycldQOgYj6YB7BlxCz',NULL,'127.0.0.1','WhatsApp/2.23.20.0','YTozOntzOjY6Il90b2tlbiI7czo0MDoiVUloMjl3b29jbEZpNE95QUE0bnd6aU9pc0Vtc2JrdXdXQmpiVllBMCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xZmY2MzAyNGM5ZjAubmdyb2stZnJlZS5hcHAiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19',1756711589);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tag_translations`
--

DROP TABLE IF EXISTS `tag_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tag_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tag_id` bigint unsigned NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `image_alt` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tag_translations_tag_id_locale_unique` (`tag_id`,`locale`),
  KEY `tag_translations_locale_index` (`locale`),
  CONSTRAINT `tag_translations_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tag_translations`
--

LOCK TABLES `tag_translations` WRITE;
/*!40000 ALTER TABLE `tag_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `tag_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `transactions`
--

DROP TABLE IF EXISTS `transactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `wallet_id` bigint unsigned NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `transactions_slug_unique` (`slug`),
  KEY `transactions_wallet_id_foreign` (`wallet_id`),
  CONSTRAINT `transactions_wallet_id_foreign` FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `transactions`
--

LOCK TABLES `transactions` WRITE;
/*!40000 ALTER TABLE `transactions` DISABLE KEYS */;
INSERT INTO `transactions` VALUES (1,6,100.00,'payment','completed','payment-booking-1-1756713609',NULL,1,0,'2025-09-01 05:00:09','2025-09-01 05:00:09',NULL),(2,6,200.00,'payment','completed','payment-booking-2-1756713978',NULL,1,0,'2025-09-01 05:06:18','2025-09-01 05:06:18',NULL),(3,6,200.00,'refund','completed','refund-booking-2-1756715142',NULL,1,0,'2025-09-01 05:25:42','2025-09-01 05:25:42',NULL),(4,6,10.00,'payment','completed','payment-booking-3-1756715413',NULL,1,0,'2025-09-01 05:30:13','2025-09-01 05:30:13',NULL),(5,5,100.00,'payment','completed','payment-booking-1-1756715623',NULL,1,0,'2025-09-01 05:33:43','2025-09-01 05:33:43',NULL),(6,6,10.00,'refund','completed','refund-booking-3-1756716192',NULL,1,0,'2025-09-01 05:43:12','2025-09-01 05:43:12',NULL);
/*!40000 ALTER TABLE `transactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `translations`
--

DROP TABLE IF EXISTS `translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `translations`
--

LOCK TABLES `translations` WRITE;
/*!40000 ALTER TABLE `translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'customer',
  `driving_license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_license_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `car_license_expiry_date` date DEFAULT NULL,
  `commercial_registration_number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('pending','active','inactive') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'suber admin','admin1@example.com','2025-08-22 21:58:28','$2y$12$Fn0yPT7kyzBau8Lpu1cqQuf027b9N1q6.sdF16AUoDbvmggHMmN8m',NULL,'123445167890','Mansoura',NULL,NULL,'admin',NULL,'licenses/JJlTY6MVjWTRDRst3QI9e9kPBvmDR0D5ipIOxeKe.jpg','2026-01-09','7894824999',NULL,NULL,'pending','suber-admin1',NULL,1,0,NULL,'2025-08-31 16:47:59','2025-08-31 16:47:59',NULL),(2,'Test Renter','renter7@example.com','2025-08-22 21:58:28','$2y$12$QxTjw5RaGtK7LFmnUkdGse.jRUBg.UWU9FcAl2Mw8koEzvGa8MNSm',NULL,'12345167890','Mansoura',NULL,NULL,'private_renter',NULL,'licenses/JJlTY6MVjWTRDRst3QI9e9kPBvmDR0D5ipIOxeKe.jpg','2026-01-09','7894824999',NULL,NULL,'pending','7test-renter',NULL,1,0,NULL,'2025-08-31 16:47:59','2025-08-31 16:47:59',NULL),(3,'mohamed alzohery','2mohamedmohasenalzohery@gmail.com','2025-08-22 21:58:28','$2y$12$Zal8Dr3IeTB7JxqgW9w4I.kbPU3WAf6WMLVCgILjshM0rUI/.LslW',NULL,'09187654321','Mansoura',NULL,NULL,'customer',NULL,'licenses/JJlTY6MVjWTRDRst3QI9e9kPBvmDR0D5ipIOxeKe.jpg','2026-01-09','7894824999',NULL,NULL,'pending','2mohamed-mohasen-alzohery',NULL,1,0,NULL,'2025-08-31 16:47:59','2025-08-31 16:47:59',NULL),(4,'osama','xotin45871@cavoyar.com','2025-08-31 16:54:52','$2y$12$dQWDBcRPFaudizuRogJLN.yfV1ve68wFiuDuPf4COjJGoodZBP.Vy',NULL,'0109389581111','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/ftIuyY7z1fCb650DOgLfoI7ZzrbqL0jHVzmjzJYI.jpg',NULL,NULL,NULL,NULL,NULL,'active','osama-uxessy',NULL,1,0,NULL,'2025-08-31 16:52:40','2025-08-31 16:54:52',NULL),(5,'mo Alzohery','pacewol773@cavoyar.com','2025-08-31 16:58:59','$2y$12$dbx.eZu19W/fu1tE8ziwceZF0bJNGXPqdBWT06x8h.MG7t6sOrYLm',NULL,'0109389545587','شارع النيل، الجيزة',30.0595,31.2234,'private_renter',NULL,'licenses/dl06cPFS2JQTYOQR3GpPcOq8epuHBCqJhksPCORr.jpg','2026-01-09',NULL,NULL,NULL,'active','mo-alzohery-svzjgf',NULL,1,0,NULL,'2025-08-31 16:57:42','2025-08-31 16:58:59',NULL),(6,'osama','jadenwu39+qoht5@gmail.com','2025-08-31 17:06:12','$2y$12$YoOiF0rrFdG1Ir.Jpvjj2uW7nkLM4xF1k2zIM3U0Laf3iJsAVLQL6',NULL,'0109389576999','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/3bqWOmBKMfRtacEED3cWBHzvsOYm0WR71nS5kYRy.jpg',NULL,NULL,NULL,NULL,NULL,'active','osama-swlcdz',NULL,1,0,NULL,'2025-08-31 17:05:38','2025-08-31 17:06:12',NULL),(7,'mohamed Hamdy','mohamedalzohery2002@gmail.com','2025-08-31 17:07:17','$2y$12$3HyKYYbJs4dPlL7Xw3X83eRJ2vEko6x1jJYMK9I64R5yBVJyyDEne',NULL,'01093895432','3C46+428, Mansoura Qism 2, Dakahlia Governorate, Egypt',31.0554629,31.4099189,'rental_office',NULL,'licenses/4yKpuXFnfX8uOFUigBTHEUsG9iR2y2cI2ehIrnk8.jpg','2025-11-20','010019',NULL,NULL,'active','mohamed-hamdy-jrgxn1',NULL,1,0,NULL,'2025-08-31 17:06:26','2025-08-31 17:07:17',NULL),(8,'mo Alzohery','sm4679313@gmail.com','2025-08-31 17:23:28','$2y$12$rCph28Ooszm0NnDIMjFMR.D3pK7K1dKewzJZ0b80Wk0Xrmai0rotW',NULL,'01093895432','شارع النيل، الجيزة',30.0595,31.2234,'private_renter',NULL,'licenses/wFgXYwEGLXMQeZOdH7CsCGnGswfBnApWFWxG1BQV.jpg','2027-02-19','45345345345',NULL,NULL,'active','mo-alzohery-rnvvp9',NULL,1,0,NULL,'2025-08-31 17:22:23','2025-08-31 17:23:28',NULL),(9,'mo','biyile2003@skateru.com','2025-09-01 04:41:27','$2y$12$OYRTtE21BGI0GP.GQgaTQe2eTea7eFoVhqI9HQYiECzpEBtWkDKKy',NULL,'01093895432','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/ctFbvvKZrldCdnp1yUEoPx695RKfvERtu6F8TeIl.jpg',NULL,NULL,NULL,NULL,NULL,'active','mo-q8xk9q',NULL,1,0,NULL,'2025-09-01 04:40:40','2025-09-01 04:41:27',NULL),(10,'osama','ohe.maaa.bo.a.te.ng4@gmail.com','2025-09-01 04:47:46','$2y$12$GLDLqCeGvGrwBCd/DZz0cuE05TYr1M1E0NTrq2ksrIfcj0xCYYFq2',NULL,'010025678253669','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/smdU5s3pJCha7pIazfppiYnvyoLhJskZnz8WuOUZ.jpg',NULL,NULL,NULL,NULL,NULL,'active','osama-gus2lu',NULL,1,0,NULL,'2025-09-01 04:47:10','2025-09-01 04:47:46',NULL),(11,'mo Alzohery','nakono9925@noidem.com','2025-09-01 05:05:16','$2y$12$HlnnyGcEWttAuVtCTzWde.uNA5T1Ks7JQJ1.EG/NjKNNGeFJEp3lG',NULL,'01093895432','شارع النيل، الجيزة',30.0595,31.2234,'private_renter',NULL,'licenses/JlCMlVrU4NDLsEpkQSuSnUuh4h6vRw4WAlC1VLyQ.jpg','2026-01-09',NULL,NULL,NULL,'active','mo-alzohery-4yfd1m',NULL,1,0,NULL,'2025-09-01 05:04:53','2025-09-01 05:05:16',NULL),(12,'osama','orfbhdt@smartnator.com',NULL,'$2y$12$XQY8kQ5uQEFGRCtIAdG1E.wcaJu2TvS7LT9sm1v7pBioIpl2PxYHC',NULL,'0100256782536697','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/CbyN28t4s3GSsJiYMPcowvuWAqNSLeSvG0qETJt5.jpg',NULL,NULL,NULL,NULL,NULL,'active','osama-wrhp7b',NULL,1,0,NULL,'2025-09-01 06:07:09','2025-09-01 06:07:09',NULL),(13,'osama','daratmp+5vr3m@gmail.com','2025-09-01 06:08:30','$2y$12$1yGM6zCTJRkkNJ3qoVDuNeXUoUZQwy2VrpSLvErqlHnVLeMcJJnke',NULL,'0100256782536476','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/KW82OnoSpNO0HvyR2eUC2SfGtXO0EYKDRnoJw6kW.jpg',NULL,NULL,NULL,NULL,NULL,'active','osama-yj4wsi',NULL,1,0,NULL,'2025-09-01 06:07:58','2025-09-01 06:08:30',NULL),(14,'osama','tinytmp+m2m3w@gmail.com','2025-09-01 14:46:17','$2y$12$72yQ5Sp9SJrSKNjtcim8meqjKe7RITlN30TEsh8DHbCQ2PbARiLCK',NULL,'0100256782574369','شارع النيل، الجيزة',30.0595,31.2234,'customer','licenses/KddcBUmZBxdVoViCvlt0rkVuaPQMbWDEbhFjK6AG.jpg',NULL,NULL,NULL,NULL,NULL,'active','osama-wcydre',NULL,1,0,NULL,'2025-09-01 14:45:30','2025-09-01 14:46:17',NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wallets`
--

DROP TABLE IF EXISTS `wallets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wallets` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `balance` decimal(8,2) NOT NULL DEFAULT '0.00',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_slug_unique` (`slug`),
  KEY `wallets_user_id_foreign` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wallets`
--

LOCK TABLES `wallets` WRITE;
/*!40000 ALTER TABLE `wallets` DISABLE KEYS */;
INSERT INTO `wallets` VALUES (1,4,0.00,'wallet-4-dqqoaa',NULL,1,0,'2025-08-31 16:52:40','2025-08-31 16:52:40',NULL),(2,5,0.00,'wallet-5-ukvbsf',NULL,1,0,'2025-08-31 16:57:42','2025-08-31 16:57:42',NULL),(3,6,0.00,'wallet-6-o566eq',NULL,1,0,'2025-08-31 17:05:38','2025-08-31 17:05:38',NULL),(4,7,0.00,'wallet-7-ehwfwk',NULL,1,0,'2025-08-31 17:06:26','2025-08-31 17:06:26',NULL),(5,8,100.00,'wallet-8-ib5c2r',NULL,1,0,'2025-08-31 17:22:24','2025-09-01 05:33:43',NULL),(6,9,29900.00,'wallet-9-71sxus',NULL,1,0,'2025-09-01 04:40:40','2025-09-01 05:43:12',NULL),(7,10,0.00,'wallet-10-pwq33d',NULL,1,0,'2025-09-01 04:47:10','2025-09-01 04:47:10',NULL),(8,11,0.00,'wallet-11-qx7fto',NULL,1,0,'2025-09-01 05:04:53','2025-09-01 05:04:53',NULL),(9,12,0.00,'wallet-12-upgqiq',NULL,1,0,'2025-09-01 06:07:09','2025-09-01 06:07:09',NULL),(10,13,0.00,'wallet-13-5bo4um',NULL,1,0,'2025-09-01 06:07:58','2025-09-01 06:07:58',NULL),(11,14,0.00,'wallet-14-mng6x0',NULL,1,0,'2025-09-01 14:45:30','2025-09-01 14:45:30',NULL);
/*!40000 ALTER TABLE `wallets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `withdrawal_requests`
--

DROP TABLE IF EXISTS `withdrawal_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `withdrawal_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `amount` decimal(8,2) NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `withdrawal_requests_slug_unique` (`slug`),
  KEY `withdrawal_requests_user_id_foreign` (`user_id`),
  CONSTRAINT `withdrawal_requests_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `withdrawal_requests`
--

LOCK TABLES `withdrawal_requests` WRITE;
/*!40000 ALTER TABLE `withdrawal_requests` DISABLE KEYS */;
/*!40000 ALTER TABLE `withdrawal_requests` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-09-01 21:30:35
