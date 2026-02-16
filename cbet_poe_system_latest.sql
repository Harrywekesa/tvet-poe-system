-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: cbet_poe_system
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
-- Table structure for table `activity_logs`
--

DROP TABLE IF EXISTS `activity_logs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activity_logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `action` varchar(255) NOT NULL,
  `details` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `activity_logs_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=422 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_logs`
--

LOCK TABLES `activity_logs` WRITE;
/*!40000 ALTER TABLE `activity_logs` DISABLE KEYS */;
INSERT INTO `activity_logs` VALUES (1,2,'Logout','User  logged out.','::1','2026-01-25 07:15:32'),(2,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:15:40'),(3,3,'Logout','User  logged out.','::1','2026-01-25 07:24:00'),(4,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:24:45'),(5,3,'Logout','User  logged out.','::1','2026-01-25 07:25:38'),(6,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-01-25 07:25:46'),(7,2,'Logout','User  logged out.','::1','2026-01-25 07:27:14'),(8,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:27:19'),(9,3,'Logout','User  logged out.','::1','2026-01-25 07:27:29'),(10,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:32:59'),(11,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:36:42'),(12,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:48:25'),(13,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-01-25 07:51:52'),(14,2,'Logout','User  logged out.','::1','2026-01-25 07:52:13'),(15,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:52:17'),(16,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 07:56:05'),(17,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 08:00:04'),(18,3,'Logout','User  logged out.','::1','2026-01-25 08:00:34'),(19,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 08:00:46'),(20,1,'Logout','User  logged out.','::1','2026-01-25 08:00:58'),(21,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 08:01:05'),(22,3,'Logout','User  logged out.','::1','2026-01-25 08:38:03'),(23,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 08:38:24'),(24,3,'Logout','User  logged out.','::1','2026-01-25 08:44:21'),(25,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-01-25 08:44:28'),(26,2,'Logout','User  logged out.','::1','2026-01-25 08:44:42'),(27,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 08:45:05'),(28,1,'Logout','User  logged out.','::1','2026-01-25 09:46:32'),(29,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 09:46:48'),(30,3,'Logout','User  logged out.','::1','2026-01-25 09:47:00'),(31,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 09:47:21'),(32,1,'Logout','User  logged out.','::1','2026-01-25 09:57:11'),(33,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 09:57:47'),(34,1,'Logout','User  logged out.','::1','2026-01-25 09:58:11'),(35,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 10:03:15'),(36,1,'Logout','User  logged out.','::1','2026-01-25 10:03:39'),(37,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 14:50:46'),(38,3,'Logout','User  logged out.','::1','2026-01-25 14:51:18'),(39,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 14:52:09'),(40,1,'Logout','User  logged out.','::1','2026-01-25 14:53:14'),(41,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 14:53:54'),(42,1,'Logout','User  logged out.','::1','2026-01-25 14:54:48'),(43,5,'Password Change','User ID 5 changed password.','::1','2026-01-25 14:55:36'),(44,5,'Logout','User  logged out.','::1','2026-01-25 14:55:48'),(45,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 14:56:31'),(46,1,'Logout','User  logged out.','::1','2026-01-25 14:57:23'),(47,5,'Login','User mimi@gmail.com logged in.','::1','2026-01-25 14:57:39'),(48,5,'Logout','User  logged out.','::1','2026-01-25 14:59:35'),(49,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 15:00:01'),(50,3,'Logout','User  logged out.','::1','2026-01-25 15:01:30'),(51,1,'Login','User admin@cbet.local logged in.','::1','2026-01-25 15:02:06'),(52,1,'Logout','User  logged out.','::1','2026-01-25 16:12:57'),(53,6,'Password Change','User ID 6 changed password.','::1','2026-01-25 16:13:23'),(54,6,'Logout','User  logged out.','::1','2026-01-25 16:18:15'),(55,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-25 16:18:26'),(56,3,'Logout','User  logged out.','::1','2026-01-25 16:20:22'),(57,5,'Login','User mimi@gmail.com logged in.','::1','2026-01-25 16:20:54'),(58,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-26 04:51:43'),(59,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:04'),(60,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:06'),(61,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:17'),(62,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:18'),(63,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:18'),(64,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:18'),(65,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:19'),(66,5,'IV Verification','IV marked Submission 6 as Rejected. Reason: ','::1','2026-01-26 04:53:20'),(67,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:53:20'),(68,3,'Prof Doc Upload','Trainer uploaded Course Outline for Unit 2, Class 1','::1','2026-01-26 04:55:16'),(69,3,'Prof Doc Upload','Trainer uploaded Class Attendance for Unit 2, Class 1','::1','2026-01-26 04:55:27'),(70,3,'Prof Doc Upload','Trainer uploaded Marksheet for Unit 2, Class 1','::1','2026-01-26 04:55:41'),(71,3,'Prof Doc Upload','Trainer uploaded Curriculum for Unit 2, Class 1','::1','2026-01-26 04:55:51'),(72,3,'Prof Doc Upload','Trainer uploaded Occupational Standards for Unit 2, Class 1','::1','2026-01-26 04:56:00'),(73,3,'Prof Doc Upload','Trainer uploaded Class Attendance for Unit 1, Class 1','::1','2026-01-26 04:56:44'),(74,3,'Prof Doc Upload','Trainer uploaded Class Attendance for Unit 1, Class 1','::1','2026-01-26 04:56:51'),(75,3,'Prof Doc Upload','Trainer uploaded Marksheet for Unit 1, Class 1','::1','2026-01-26 04:56:57'),(76,3,'Prof Doc Upload','Trainer uploaded Curriculum for Unit 1, Class 1','::1','2026-01-26 04:57:09'),(77,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:58:50'),(78,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:58:51'),(79,5,'IV Verification','IV marked Submission 6 as Accepted. Reason: ','::1','2026-01-26 04:58:51'),(80,5,'Logout','User  logged out.','::1','2026-01-26 05:08:45'),(81,1,'Login','User admin@cbet.local logged in.','::1','2026-01-26 05:09:03'),(82,1,'User Update','Updated user details for ID 2 (harrisonwekesa009@gmail.com)','::1','2026-01-26 05:09:42'),(83,1,'User Update','Updated user details for ID 6 (hod@gmail.com)','::1','2026-01-26 05:09:56'),(84,1,'User Update','Updated user details for ID 4 (harrisonwekes019@gmail.com)','::1','2026-01-26 05:10:10'),(85,1,'User Update','Updated user details for ID 3 (harrisonwekesa09@gmail.com)','::1','2026-01-26 05:10:20'),(86,1,'User Update','Updated user details for ID 1 (admin@cbet.local)','::1','2026-01-26 05:10:32'),(87,1,'Logout','User  logged out.','::1','2026-01-26 05:10:55'),(88,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-01-26 05:11:23'),(89,3,'Logout','User  logged out.','::1','2026-01-26 05:11:58'),(90,5,'Login','User mimi@gmail.com logged in.','::1','2026-01-26 05:12:32'),(91,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 05:13:22'),(92,5,'IV Verification','IV marked Submission 2 as Accepted. Reason: ','::1','2026-01-26 05:14:06'),(93,5,'IV Verification','IV marked Submission 3 as Accepted. Reason: ','::1','2026-01-26 05:14:07'),(94,5,'IV Verification','IV marked Submission 4 as Rejected. Reason: NO VISIBLE','::1','2026-01-26 05:16:36'),(95,5,'IV Verification','IV marked Submission 4 as Rejected. Reason: HGHJG','::1','2026-01-26 05:16:43'),(96,5,'IV Verification','IV marked Submission 5 as Rejected. Reason: HGJHG','::1','2026-01-26 05:18:33'),(97,3,'Logout','User  logged out.','::1','2026-01-26 06:58:45'),(98,5,'Login','User mimi@gmail.com logged in.','::1','2026-01-26 06:58:58'),(99,5,'IV Verification','IV marked Submission 1 as Rejected. Reason: BASD','::1','2026-01-26 06:59:19'),(100,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 06:59:44'),(101,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 06:59:45'),(102,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 06:59:46'),(103,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 07:01:48'),(104,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 07:04:58'),(105,5,'Login','User mimi@gmail.com logged in.','::1','2026-01-26 07:05:37'),(106,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-01-26 07:05:46'),(107,1,'Login','User admin@cbet.local logged in.','::1','2026-02-04 03:59:48'),(108,1,'Logout','User  logged out.','::1','2026-02-04 04:00:30'),(109,1,'Login','User admin@cbet.local logged in.','::1','2026-02-04 04:02:15'),(110,1,'User Update','Updated user details for ID 5 (mimi@gmail.com)','::1','2026-02-04 04:02:34'),(111,1,'Logout','User  logged out.','::1','2026-02-04 04:02:37'),(112,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-04 04:02:41'),(113,5,'IV Verification','IV marked Submission 1 as Accepted. Reason: ','::1','2026-02-04 04:03:40'),(114,5,'Logout','User  logged out.','::1','2026-02-04 04:16:55'),(115,1,'Login','User admin@cbet.local logged in.','::1','2026-02-04 04:18:17'),(116,1,'Logout','User  logged out.','::1','2026-02-04 04:18:49'),(117,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-04 04:19:01'),(118,5,'Logout','User  logged out.','::1','2026-02-04 04:19:25'),(119,1,'Login','User admin@cbet.local logged in.','::1','2026-02-04 04:19:42'),(120,1,'User Update','Updated user details for ID 3 (harrisonwekesa09@gmail.com)','::1','2026-02-04 04:20:09'),(121,1,'User Update','Updated user details for ID 2 (harrisonwekesa009@gmail.com)','::1','2026-02-04 04:20:22'),(122,1,'User Update','Updated user details for ID 6 (hod@gmail.com)','::1','2026-02-04 04:20:33'),(123,1,'Logout','User  logged out.','::1','2026-02-04 04:20:34'),(124,6,'Login','User hod@gmail.com logged in.','::1','2026-02-04 04:20:46'),(125,6,'Logout','User  logged out.','::1','2026-02-04 04:21:14'),(126,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-04 04:21:20'),(127,3,'Logout','User  logged out.','::1','2026-02-04 04:21:58'),(128,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-04 04:22:05'),(129,1,'Login','User admin@cbet.local logged in.','::1','2026-02-11 18:45:01'),(130,1,'Logout','User  logged out.','::1','2026-02-11 18:45:35'),(131,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 18:45:48'),(132,3,'Logout','User  logged out.','::1','2026-02-11 18:53:35'),(133,1,'Login','User admin@cbet.local logged in.','::1','2026-02-11 18:53:44'),(134,1,'Logout','User  logged out.','::1','2026-02-11 18:58:58'),(135,1,'Login','User admin@cbet.local logged in.','::1','2026-02-11 18:59:13'),(136,1,'Logout','User  logged out.','::1','2026-02-11 18:59:48'),(137,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 18:59:59'),(138,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 19:02:29'),(139,3,'Logout','User  logged out.','::1','2026-02-11 19:02:39'),(140,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-11 19:02:59'),(141,2,'Logout','User  logged out.','::1','2026-02-11 19:03:20'),(142,3,'Logout','User  logged out.','::1','2026-02-11 19:03:27'),(143,1,'Login','User admin@cbet.local logged in.','::1','2026-02-11 19:03:34'),(144,1,'User Update','Updated user details for ID 4 (harrisonwekes019@gmail.com)','::1','2026-02-11 19:05:08'),(145,1,'Logout','User  logged out.','::1','2026-02-11 19:05:26'),(146,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-11 19:05:34'),(147,5,'Logout','User  logged out.','::1','2026-02-11 19:05:59'),(148,6,'Login','User hod@gmail.com logged in.','::1','2026-02-11 19:06:06'),(149,6,'Prof Doc Reviewed','HOD marked Doc 1 as Approved','::1','2026-02-11 19:06:12'),(150,6,'Prof Doc Reviewed','HOD marked Doc 3 as Approved','::1','2026-02-11 19:06:14'),(151,6,'Prof Doc Reviewed','HOD marked Doc 5 as Approved','::1','2026-02-11 19:06:16'),(152,6,'Prof Doc Reviewed','HOD marked Doc 7 as Approved','::1','2026-02-11 19:06:18'),(153,6,'Prof Doc Reviewed','HOD marked Doc 9 as Approved','::1','2026-02-11 19:06:20'),(154,6,'Prof Doc Reviewed','HOD marked Doc 6 as Approved','::1','2026-02-11 19:06:22'),(155,6,'Prof Doc Reviewed','HOD marked Doc 4 as Approved','::1','2026-02-11 19:06:23'),(156,6,'Prof Doc Reviewed','HOD marked Doc 8 as Approved','::1','2026-02-11 19:06:24'),(157,6,'Prof Doc Reviewed','HOD marked Doc 2 as Approved','::1','2026-02-11 19:06:25'),(158,6,'Login','User hod@gmail.com logged in.','::1','2026-02-11 19:06:36'),(159,6,'Logout','User  logged out.','::1','2026-02-11 19:09:47'),(160,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 19:09:55'),(161,3,'Logout','User  logged out.','::1','2026-02-11 19:10:46'),(162,6,'Login','User hod@gmail.com logged in.','::1','2026-02-11 19:10:56'),(163,6,'Logout','User  logged out.','::1','2026-02-11 19:12:18'),(164,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 19:12:28'),(165,3,'Logout','User  logged out.','::1','2026-02-11 19:44:37'),(166,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 19:44:43'),(167,3,'Logout','User  logged out.','::1','2026-02-11 19:44:46'),(168,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-11 19:44:54'),(169,2,'Evidence Upload','Student 2 uploaded evidence for Slot 7','::1','2026-02-11 19:45:44'),(170,2,'Evidence Upload','Student 2 uploaded evidence for Slot 8','::1','2026-02-11 19:45:50'),(171,2,'Evidence Upload','Student 2 uploaded evidence for Slot 9','::1','2026-02-11 19:47:01'),(172,2,'Evidence Upload','Student 2 uploaded evidence for Slot 10','::1','2026-02-11 19:47:07'),(173,2,'Evidence Upload','Student 2 uploaded evidence for Slot 11','::1','2026-02-11 19:47:14'),(174,2,'Evidence Upload','Student 2 uploaded evidence for Slot 12','::1','2026-02-11 19:47:20'),(175,2,'Evidence Upload','Student 2 uploaded evidence for Slot 13','::1','2026-02-11 19:47:28'),(176,2,'Evidence Upload','Student 2 uploaded evidence for Slot 14','::1','2026-02-11 19:47:35'),(177,2,'Evidence Upload','Student 2 uploaded evidence for Slot 15','::1','2026-02-11 19:47:42'),(178,2,'Evidence Upload','Student 2 uploaded evidence for Slot 16','::1','2026-02-11 19:47:49'),(179,2,'Evidence Upload','Student 2 uploaded evidence for Slot 17','::1','2026-02-11 19:47:59'),(180,2,'Evidence Upload','Student 2 uploaded evidence for Slot 18','::1','2026-02-11 19:48:07'),(181,2,'Logout','User  logged out.','::1','2026-02-11 19:48:12'),(182,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 19:48:20'),(183,3,'Assessment Graded','Trainer graded Submission 7 as Approved','::1','2026-02-11 19:48:36'),(184,3,'Assessment Graded','Trainer graded Submission 8 as Approved','::1','2026-02-11 19:48:40'),(185,3,'Assessment Graded','Trainer graded Submission 9 as Rejected','::1','2026-02-11 19:48:42'),(186,3,'Assessment Graded','Trainer graded Submission 10 as Rejected','::1','2026-02-11 19:48:45'),(187,3,'Assessment Graded','Trainer graded Submission 11 as Approved','::1','2026-02-11 19:48:49'),(188,3,'Assessment Graded','Trainer graded Submission 12 as Approved','::1','2026-02-11 19:49:00'),(189,3,'Assessment Graded','Trainer graded Submission 18 as Approved','::1','2026-02-11 19:49:04'),(190,3,'Assessment Graded','Trainer graded Submission 17 as Rejected','::1','2026-02-11 19:49:07'),(191,3,'Assessment Graded','Trainer graded Submission 16 as Approved','::1','2026-02-11 19:49:10'),(192,3,'Assessment Graded','Trainer graded Submission 15 as Approved','::1','2026-02-11 19:49:13'),(193,3,'Assessment Graded','Trainer graded Submission 14 as Approved','::1','2026-02-11 19:49:16'),(194,3,'Assessment Graded','Trainer graded Submission 13 as Approved','::1','2026-02-11 19:49:18'),(195,3,'Logout','User  logged out.','::1','2026-02-11 19:52:54'),(196,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-11 19:53:15'),(197,2,'Evidence Upload','Student 2 uploaded evidence for Slot 9','::1','2026-02-11 19:53:43'),(198,2,'Evidence Upload','Student 2 uploaded evidence for Slot 10','::1','2026-02-11 19:53:51'),(199,2,'Evidence Upload','Student 2 uploaded evidence for Slot 17','::1','2026-02-11 19:53:58'),(200,2,'Evidence Upload','Student 2 uploaded evidence for Slot 17','::1','2026-02-11 19:54:06'),(201,2,'Logout','User  logged out.','::1','2026-02-11 19:54:22'),(202,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 19:54:28'),(203,3,'Assessment Graded','Trainer graded Submission 19 as Approved','::1','2026-02-11 19:54:40'),(204,3,'Assessment Graded','Trainer graded Submission 20 as Approved','::1','2026-02-11 19:54:42'),(205,3,'Assessment Graded','Trainer graded Submission 22 as Approved','::1','2026-02-11 19:54:46'),(206,3,'Logout','User  logged out.','::1','2026-02-11 20:45:31'),(207,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-11 20:45:42'),(208,3,'Logout','User  logged out.','::1','2026-02-11 20:45:45'),(209,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-11 20:45:52'),(210,2,'Logout','User  logged out.','::1','2026-02-11 20:58:12'),(211,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-11 20:58:19'),(212,5,'IV Verification','IV marked Submission 7 as Accepted. Reason: ','::1','2026-02-11 20:58:37'),(213,5,'IV Verification','IV marked Submission 8 as Accepted. Reason: ','::1','2026-02-11 20:58:39'),(214,5,'IV Verification','IV marked Submission 11 as Accepted. Reason: ','::1','2026-02-11 20:58:40'),(215,5,'IV Verification','IV marked Submission 12 as Accepted. Reason: ','::1','2026-02-11 20:58:41'),(216,5,'IV Verification','IV marked Submission 13 as Accepted. Reason: ','::1','2026-02-11 20:58:42'),(217,5,'IV Verification','IV marked Submission 14 as Accepted. Reason: ','::1','2026-02-11 20:58:42'),(218,5,'IV Verification','IV marked Submission 15 as Accepted. Reason: ','::1','2026-02-11 20:58:43'),(219,5,'IV Verification','IV marked Submission 16 as Rejected. Reason: ','::1','2026-02-11 20:58:51'),(220,5,'IV Verification','IV marked Submission 18 as Accepted. Reason: ','::1','2026-02-11 20:58:56'),(221,5,'IV Verification','IV marked Submission 19 as Accepted. Reason: ','::1','2026-02-11 20:58:59'),(222,5,'IV Verification','IV marked Submission 20 as Accepted. Reason: ','::1','2026-02-11 20:59:00'),(223,5,'IV Verification','IV marked Submission 22 as Accepted. Reason: ','::1','2026-02-11 20:59:04'),(224,5,'Logout','User  logged out.','::1','2026-02-11 20:59:31'),(225,1,'Login','User admin@cbet.local logged in.','::1','2026-02-12 05:42:27'),(226,1,'Logout','User  logged out.','::1','2026-02-12 05:43:16'),(227,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-12 05:43:37'),(228,2,'Logout','User  logged out.','::1','2026-02-12 05:43:58'),(229,1,'Login','User admin@cbet.local logged in.','::1','2026-02-12 05:44:05'),(230,1,'Logout','User  logged out.','::1','2026-02-12 05:44:22'),(231,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-12 05:44:28'),(232,5,'IV Verification','IV marked Submission 7 as Accepted. Reason: ','::1','2026-02-12 05:44:54'),(233,5,'IV Verification','IV marked Submission 7 as Accepted. Reason: ','::1','2026-02-12 05:49:52'),(234,5,'IV Verification','IV marked Submission 8 as Accepted. Reason: ','::1','2026-02-12 05:49:57'),(235,5,'IV Verification','IV marked Submission 7 as Accepted. Reason: ','::1','2026-02-12 05:50:02'),(236,5,'IV Verification','IV marked Submission 7 as Accepted. Reason: ','::1','2026-02-12 05:50:04'),(237,5,'IV Verification','IV marked Submission 8 as Accepted. Reason: ','::1','2026-02-12 05:50:05'),(238,5,'IV Verification','IV marked Submission 7 as Verified. Reason: ','::1','2026-02-12 05:53:54'),(239,5,'IV Verification','IV marked Submission 8 as IV_Rejected. Reason: ','::1','2026-02-12 05:53:59'),(240,5,'IV Verification','IV marked Submission 8 as Verified. Reason: ','::1','2026-02-12 05:54:01'),(241,5,'IV Verification','IV marked Submission 11 as Verified. Reason: ','::1','2026-02-12 05:54:02'),(242,5,'IV Verification','IV marked Submission 15 as Verified. Reason: ','::1','2026-02-12 05:54:04'),(243,5,'IV Verification','IV marked Submission 12 as Verified. Reason: ','::1','2026-02-12 05:54:06'),(244,5,'IV Verification','IV marked Submission 13 as Verified. Reason: ','::1','2026-02-12 05:54:07'),(245,5,'IV Verification','IV marked Submission 14 as IV_Rejected. Reason: BASD','::1','2026-02-12 05:54:11'),(246,5,'IV Verification','IV marked Submission 16 as Verified. Reason: ','::1','2026-02-12 05:54:14'),(247,5,'IV Verification','IV marked Submission 19 as Verified. Reason: ','::1','2026-02-12 05:54:16'),(248,5,'IV Verification','IV marked Submission 18 as Verified. Reason: ','::1','2026-02-12 05:54:17'),(249,5,'IV Verification','IV marked Submission 20 as Verified. Reason: ','::1','2026-02-12 05:54:19'),(250,5,'IV Verification','IV marked Submission 22 as Verified. Reason: ','::1','2026-02-12 05:54:21'),(251,5,'Logout','User  logged out.','::1','2026-02-12 05:54:46'),(252,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-12 05:55:08'),(253,2,'Logout','User  logged out.','::1','2026-02-12 05:55:16'),(254,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-12 05:55:31'),(255,3,'Logout','User  logged out.','::1','2026-02-12 05:57:00'),(256,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-12 05:57:10'),(257,5,'Logout','User  logged out.','::1','2026-02-12 17:13:23'),(258,1,'Login','User admin@cbet.local logged in.','::1','2026-02-12 17:26:33'),(259,1,'Logout','User  logged out.','::1','2026-02-12 17:43:17'),(260,1,'Login','User admin@cbet.local logged in.','::1','2026-02-12 17:47:55'),(261,1,'Logout','User  logged out.','::1','2026-02-12 17:48:24'),(262,1,'Login','User admin@cbet.local logged in.','::1','2026-02-12 17:49:56'),(263,1,'Logout','User  logged out.','::1','2026-02-12 17:50:21'),(264,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-12 17:50:27'),(265,3,'Logout','User  logged out.','::1','2026-02-12 17:57:33'),(266,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-12 17:58:17'),(267,5,'IV Verification','IV marked Submission 14 as Verified. Reason: ','::1','2026-02-14 17:28:08'),(268,5,'Logout','User  logged out.','::1','2026-02-14 17:31:40'),(269,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 17:31:51'),(270,5,'Logout','User  logged out.','::1','2026-02-14 17:31:57'),(271,1,'Login','User admin@cbet.local logged in.','::1','2026-02-14 17:32:08'),(272,1,'Logout','User  logged out.','::1','2026-02-14 17:32:16'),(273,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 17:32:29'),(274,6,'Logout','User  logged out.','::1','2026-02-14 17:50:21'),(275,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 17:50:31'),(276,5,'Logout','User  logged out.','::1','2026-02-14 17:50:46'),(277,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 17:50:54'),(278,3,'Logout','User  logged out.','::1','2026-02-14 17:53:02'),(279,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 17:53:12'),(280,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 17:58:31'),(281,5,'Logout','User  logged out.','::1','2026-02-14 17:59:46'),(282,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 17:59:55'),(283,6,'Logout','User  logged out.','::1','2026-02-14 18:07:06'),(284,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 18:07:22'),(285,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 18:12:48'),(286,6,'Logout','User  logged out.','::1','2026-02-14 18:12:51'),(287,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 18:13:03'),(288,3,'Logout','User  logged out.','::1','2026-02-14 18:14:24'),(289,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 18:14:31'),(290,5,'Logout','User  logged out.','::1','2026-02-14 18:17:20'),(291,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-14 18:17:26'),(292,2,'Logout','User  logged out.','::1','2026-02-14 18:17:37'),(293,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 18:17:43'),(294,3,'Logout','User  logged out.','::1','2026-02-14 18:20:18'),(295,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-14 18:20:23'),(296,2,'Evidence Upload','Student 2 uploaded evidence for Slot 19','::1','2026-02-14 18:20:47'),(297,2,'Evidence Upload','Student 2 uploaded evidence for Slot 20','::1','2026-02-14 18:20:52'),(298,2,'Evidence Upload','Student 2 uploaded evidence for Slot 21','::1','2026-02-14 18:20:57'),(299,2,'Evidence Upload','Student 2 uploaded evidence for Slot 22','::1','2026-02-14 18:21:03'),(300,2,'Evidence Upload','Student 2 uploaded evidence for Slot 23','::1','2026-02-14 18:21:10'),(301,2,'Evidence Upload','Student 2 uploaded evidence for Slot 24','::1','2026-02-14 18:21:17'),(302,2,'Evidence Upload','Student 2 uploaded evidence for Slot 25','::1','2026-02-14 18:21:25'),(303,2,'Evidence Upload','Student 2 uploaded evidence for Slot 26','::1','2026-02-14 18:21:38'),(304,2,'Logout','User  logged out.','::1','2026-02-14 18:21:51'),(305,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 18:22:02'),(306,3,'Assessment Graded','Trainer graded Submission 23 as Approved','::1','2026-02-14 18:22:35'),(307,3,'Assessment Graded','Trainer graded Submission 24 as Approved','::1','2026-02-14 18:22:36'),(308,3,'Assessment Graded','Trainer graded Submission 25 as Approved','::1','2026-02-14 18:22:37'),(309,3,'Assessment Graded','Trainer graded Submission 26 as Approved','::1','2026-02-14 18:22:38'),(310,3,'Assessment Graded','Trainer graded Submission 27 as Approved','::1','2026-02-14 18:22:42'),(311,3,'Assessment Graded','Trainer graded Submission 30 as Approved','::1','2026-02-14 18:22:45'),(312,3,'Assessment Graded','Trainer graded Submission 29 as Approved','::1','2026-02-14 18:22:48'),(313,3,'Assessment Graded','Trainer graded Submission 28 as Approved','::1','2026-02-14 18:22:50'),(314,3,'Logout','User  logged out.','::1','2026-02-14 18:23:11'),(315,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 18:23:16'),(316,6,'Logout','User  logged out.','::1','2026-02-14 18:24:15'),(317,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 18:24:24'),(318,5,'IV Verification','IV marked Submission 23 as Verified. Reason: ','::1','2026-02-14 18:24:43'),(319,5,'IV Verification','IV marked Submission 24 as Verified. Reason: ','::1','2026-02-14 18:24:44'),(320,5,'IV Verification','IV marked Submission 25 as Verified. Reason: ','::1','2026-02-14 18:24:45'),(321,5,'IV Verification','IV marked Submission 26 as Verified. Reason: ','::1','2026-02-14 18:24:47'),(322,5,'IV Verification','IV marked Submission 27 as Verified. Reason: ','::1','2026-02-14 18:24:48'),(323,5,'IV Verification','IV marked Submission 30 as Verified. Reason: ','::1','2026-02-14 18:24:50'),(324,5,'IV Verification','IV marked Submission 29 as Verified. Reason: ','::1','2026-02-14 18:24:52'),(325,5,'IV Verification','IV marked Submission 28 as Verified. Reason: ','::1','2026-02-14 18:24:54'),(326,5,'Logout','User  logged out.','::1','2026-02-14 18:33:51'),(327,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 18:34:00'),(328,5,'Logout','User  logged out.','::1','2026-02-14 18:34:46'),(329,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 18:34:54'),(330,3,'Logout','User  logged out.','::1','2026-02-14 18:35:05'),(331,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-14 18:35:15'),(332,2,'Logout','User  logged out.','::1','2026-02-14 18:35:21'),(333,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 18:35:38'),(334,6,'Logout','User  logged out.','::1','2026-02-14 18:35:49'),(335,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 18:35:58'),(336,5,'Logout','User  logged out.','::1','2026-02-14 18:37:51'),(337,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 18:37:57'),(338,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-14 18:39:05'),(339,5,'Logout','User  logged out.','::1','2026-02-14 18:55:58'),(340,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 18:56:08'),(341,6,'Logout','User  logged out.','::1','2026-02-14 19:30:55'),(342,1,'Login','User admin@cbet.local logged in.','::1','2026-02-14 19:31:09'),(343,1,'Logout','User  logged out.','::1','2026-02-14 19:37:44'),(344,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-14 19:37:52'),(345,2,'Logout','User  logged out.','::1','2026-02-14 19:56:40'),(346,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 19:56:47'),(347,3,'Logout','User  logged out.','::1','2026-02-14 19:57:55'),(348,1,'Login','User admin@cbet.local logged in.','::1','2026-02-14 19:58:01'),(349,1,'User Created','Created user student2@gmail.com (student2)','::1','2026-02-14 19:58:53'),(350,1,'User Deleted','Deleted User ID 7','::1','2026-02-14 20:00:28'),(351,1,'User Created','Created user student209@gmail.com (student2)','::1','2026-02-14 20:01:48'),(352,1,'Logout','User  logged out.','::1','2026-02-14 20:01:51'),(353,8,'Password Change','User ID 8 changed password.','::1','2026-02-14 20:02:09'),(354,8,'Logout','User  logged out.','::1','2026-02-14 20:03:11'),(355,1,'Login','User admin@cbet.local logged in.','::1','2026-02-14 20:03:21'),(356,1,'User Enrolled','Enrolled user 8 in Class ID 1 via Edit','::1','2026-02-14 20:05:45'),(357,1,'User Update','Updated user details for ID 8 (student209@gmail.com)','::1','2026-02-14 20:05:45'),(358,1,'Logout','User  logged out.','::1','2026-02-14 20:05:48'),(359,8,'Login','User student209@gmail.com logged in.','::1','2026-02-14 20:06:01'),(360,8,'Logout','User  logged out.','::1','2026-02-14 20:10:43'),(361,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-14 20:10:49'),(362,2,'Logout','User  logged out.','::1','2026-02-14 20:11:07'),(363,1,'Login','User admin@cbet.local logged in.','::1','2026-02-14 20:11:15'),(364,1,'Logout','User  logged out.','::1','2026-02-14 20:50:42'),(365,6,'Login','User hod@gmail.com logged in.','::1','2026-02-14 20:50:50'),(366,6,'Class Created','Created class DICTL 241 in cohort 1','::1','2026-02-14 21:01:37'),(367,6,'Class Created','Created class CICTL 239 in cohort 1','::1','2026-02-14 21:01:47'),(368,6,'Class Created','Created class CICTL 241 in cohort 1','::1','2026-02-14 21:01:57'),(369,6,'Logout','User  logged out.','::1','2026-02-14 21:04:02'),(370,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-14 21:04:10'),(371,3,'Logout','User  logged out.','::1','2026-02-15 04:36:29'),(372,6,'Login','User hod@gmail.com logged in.','::1','2026-02-15 04:36:39'),(373,6,'Logout','User  logged out.','::1','2026-02-15 04:37:52'),(374,1,'Login','User admin@cbet.local logged in.','::1','2026-02-15 04:38:08'),(375,1,'Class Created','Created class DEI 239 in cohort 1','::1','2026-02-15 04:39:06'),(376,1,'Class Created','Created class DEI 241 in cohort 1','::1','2026-02-15 04:39:20'),(377,1,'Unit Created','Created unit ENG/DEI/001/26 - Demonstrate Electrical Principles','::1','2026-02-15 04:42:50'),(378,1,'Unit Created','Created unit ENG/DEI/002/26 - Demonstrate Basic Electronics Principles','::1','2026-02-15 04:43:38'),(379,1,'Department Created','Created department: HOSPITALITY','::1','2026-02-15 04:44:08'),(380,1,'Department Created','Created department: APPLIED SCIENCES','::1','2026-02-15 04:44:24'),(381,1,'Department Created','Created department: HEALTH SCIENCES','::1','2026-02-15 04:44:39'),(382,1,'Department Created','Created department: MECHANICAL','::1','2026-02-15 04:44:46'),(383,1,'Department Created','Created department: BUILDINGAND CIVIL ENGINEERING','::1','2026-02-15 04:44:59'),(384,1,'Bulk Import','Imported 3 department(s)','::1','2026-02-15 05:50:51'),(385,1,'Bulk Import','Imported 3 department(s)','::1','2026-02-15 05:52:10'),(386,1,'Bulk Import','Imported 3 department(s)','::1','2026-02-15 05:52:43'),(387,1,'Bulk Import','Imported 2 course(s)','::1','2026-02-15 05:55:47'),(388,1,'Department Deleted','Deleted department ID 8','::1','2026-02-15 05:55:55'),(389,1,'Department Deleted','Deleted department ID 9','::1','2026-02-15 05:56:08'),(390,1,'Bulk Import','Imported 2 unit(s)','::1','2026-02-15 06:02:15'),(391,1,'Class Created','Created class LS-DSWCD 239 in cohort 1','::1','2026-02-15 06:05:23'),(392,1,'Class Created','Created class LS-CSWCD 239 in cohort 1','::1','2026-02-15 06:05:47'),(393,1,'Bulk User Import','Imported 1 users.','::1','2026-02-15 06:10:04'),(394,9,'Login','User john@example.com logged in.','::1','2026-02-15 06:15:32'),(395,9,'Password Change','User ID 9 changed password.','::1','2026-02-15 06:15:40'),(396,9,'Logout','User  logged out.','::1','2026-02-15 06:15:45'),(397,1,'Enrollment','Enrolled user 9 into class 7','::1','2026-02-15 06:18:01'),(398,9,'Login','User john@example.com logged in.','::1','2026-02-15 06:20:17'),(399,1,'Logout','User  logged out.','::1','2026-02-15 06:49:32'),(400,3,'Login','User harrisonwekesa09@gmail.com logged in.','::1','2026-02-15 06:49:50'),(401,3,'Logout','User  logged out.','::1','2026-02-15 06:51:09'),(402,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-15 06:51:27'),(403,9,'Logout','User  logged out.','::1','2026-02-15 07:00:51'),(404,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-15 07:00:58'),(405,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-15 07:01:35'),(406,2,'Logout','User  logged out.','::1','2026-02-15 07:03:10'),(407,1,'Login','User admin@cbet.local logged in.','::1','2026-02-15 07:03:22'),(408,1,'Logout','User  logged out.','::1','2026-02-15 07:11:19'),(409,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-15 07:11:24'),(410,5,'Logout','User  logged out.','::1','2026-02-15 07:27:05'),(411,1,'Login','User admin@cbet.local logged in.','::1','2026-02-15 07:27:11'),(412,1,'Unit Allocation','Allocated Unit 3 in Class 1 to Trainer 3','::1','2026-02-15 07:27:31'),(413,1,'Unit Allocation','Allocated Unit 2 in Class 1 to Trainer 3','::1','2026-02-15 07:27:34'),(414,1,'Logout','User  logged out.','::1','2026-02-15 07:27:37'),(415,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-15 07:27:46'),(416,5,'Logout','User  logged out.','::1','2026-02-15 09:15:42'),(417,2,'Login','User harrisonwekesa009@gmail.com logged in.','::1','2026-02-15 09:15:50'),(418,2,'Logout','User  logged out.','::1','2026-02-15 09:17:45'),(419,6,'Login','User hod@gmail.com logged in.','::1','2026-02-15 09:17:54'),(420,2,'Logout','User  logged out.','::1','2026-02-15 09:22:03'),(421,5,'Login','User mimi@gmail.com logged in.','::1','2026-02-16 17:41:42');
/*!40000 ALTER TABLE `activity_logs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `assessment_slots`
--

DROP TABLE IF EXISTS `assessment_slots`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `assessment_slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `topic_id` int(11) DEFAULT NULL,
  `title` varchar(150) NOT NULL,
  `type` enum('Written','Practical') NOT NULL,
  `instructions` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `max_marks` int(11) DEFAULT 100,
  `sequence_order` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  KEY `fk_assessment_topic` (`topic_id`),
  CONSTRAINT `assessment_slots_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_assessment_topic` FOREIGN KEY (`topic_id`) REFERENCES `unit_topics` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `assessment_slots`
--

LOCK TABLES `assessment_slots` WRITE;
/*!40000 ALTER TABLE `assessment_slots` DISABLE KEYS */;
INSERT INTO `assessment_slots` VALUES (7,3,1,'Written assessment 1','Written','',NULL,100,1),(8,3,1,'Practical Assessment','Practical','',NULL,100,1),(9,3,2,'Written assessment 2','Written','',NULL,100,1),(10,3,2,'Practical assessment 2','Practical','',NULL,100,1),(11,3,3,'Written assessment 3','Written','',NULL,100,1),(12,3,3,'Practical assessment 3','Practical','',NULL,100,1),(13,3,4,'Written assessment 4','Written','',NULL,100,1),(14,3,4,'Practical assessment 4','Practical','',NULL,100,1),(15,3,5,'Written assessment 5','Written','',NULL,100,1),(16,3,5,'Practical assessment 5','Practical','',NULL,100,1),(17,3,6,'Practical assessment 6','Practical','',NULL,100,1),(18,3,6,'Written assessment 6','Written','',NULL,100,1),(19,1,7,'wa1','Written','',NULL,100,1),(20,1,7,'pa1','Practical','',NULL,100,1),(21,1,8,'wa2','Written','',NULL,100,1),(22,1,8,'pa2','Practical','',NULL,100,1),(23,1,9,'wa3','Written','',NULL,100,1),(24,1,9,'pa3','Practical','',NULL,100,1),(25,1,12,'wa4','Written','',NULL,100,1),(26,1,12,'pa4','Practical','',NULL,100,1);
/*!40000 ALTER TABLE `assessment_slots` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_samples`
--

DROP TABLE IF EXISTS `audit_samples`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_samples` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `audit_session_id` int(11) NOT NULL,
  `student_user_id` int(11) NOT NULL,
  `status` enum('Pending','Compliant','Non-Compliant') DEFAULT 'Pending',
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_session_student` (`audit_session_id`,`student_user_id`),
  KEY `student_user_id` (`student_user_id`),
  CONSTRAINT `audit_samples_ibfk_1` FOREIGN KEY (`audit_session_id`) REFERENCES `audit_sessions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `audit_samples_ibfk_2` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_samples`
--

LOCK TABLES `audit_samples` WRITE;
/*!40000 ALTER TABLE `audit_samples` DISABLE KEYS */;
INSERT INTO `audit_samples` VALUES (1,2,2,'Compliant','','2026-02-15 07:26:38'),(2,2,8,'Non-Compliant','','2026-02-15 07:26:38'),(5,3,2,'Compliant','','2026-02-15 07:33:40'),(6,3,8,'Non-Compliant','','2026-02-15 07:33:40');
/*!40000 ALTER TABLE `audit_samples` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `audit_sessions`
--

DROP TABLE IF EXISTS `audit_sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit_sessions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `verifier_user_id` int(11) NOT NULL,
  `sample_size` int(11) NOT NULL,
  `status` enum('Pending','In Progress','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `completed_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  KEY `class_id` (`class_id`),
  KEY `verifier_user_id` (`verifier_user_id`),
  CONSTRAINT `audit_sessions_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `audit_sessions_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`),
  CONSTRAINT `audit_sessions_ibfk_3` FOREIGN KEY (`verifier_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit_sessions`
--

LOCK TABLES `audit_sessions` WRITE;
/*!40000 ALTER TABLE `audit_sessions` DISABLE KEYS */;
INSERT INTO `audit_sessions` VALUES (1,1,1,5,2,'Pending','2026-02-15 07:26:01',NULL),(2,1,1,5,2,'Completed','2026-02-15 07:26:38','2026-02-15 07:57:28'),(3,3,1,5,2,'Completed','2026-02-15 07:33:40','2026-02-15 07:34:38');
/*!40000 ALTER TABLE `audit_sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `classes`
--

DROP TABLE IF EXISTS `classes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_code` varchar(50) NOT NULL,
  `course_id` int(11) NOT NULL,
  `cohort_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `class_code` (`class_code`),
  KEY `course_id` (`course_id`),
  KEY `cohort_id` (`cohort_id`),
  CONSTRAINT `classes_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE,
  CONSTRAINT `classes_ibfk_2` FOREIGN KEY (`cohort_id`) REFERENCES `cohorts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `classes`
--

LOCK TABLES `classes` WRITE;
/*!40000 ALTER TABLE `classes` DISABLE KEYS */;
INSERT INTO `classes` VALUES (1,'DICTL 239',1,1,'2026-01-25 06:44:46'),(2,'DICTL 241',1,1,'2026-02-14 21:01:37'),(3,'CICTL 239',2,1,'2026-02-14 21:01:47'),(4,'CICTL 241',2,1,'2026-02-14 21:01:57'),(5,'DEI 239',3,1,'2026-02-15 04:39:06'),(6,'DEI 241',3,1,'2026-02-15 04:39:20'),(7,'LS-DSWCD 239',4,1,'2026-02-15 06:05:22'),(8,'LS-CSWCD 239',5,1,'2026-02-15 06:05:47');
/*!40000 ALTER TABLE `classes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cohorts`
--

DROP TABLE IF EXISTS `cohorts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `cohorts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `start_date` date DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cohorts`
--

LOCK TABLES `cohorts` WRITE;
/*!40000 ALTER TABLE `cohorts` DISABLE KEYS */;
INSERT INTO `cohorts` VALUES (1,'JAN - APRIL2026','2026-01-05','2026-03-31',1);
/*!40000 ALTER TABLE `cohorts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `courses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `code` varchar(50) NOT NULL,
  `department_id` int(11) NOT NULL,
  `level` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `department_id` (`department_id`),
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `courses`
--

LOCK TABLES `courses` WRITE;
/*!40000 ALTER TABLE `courses` DISABLE KEYS */;
INSERT INTO `courses` VALUES (1,'INFORMATION COMMUNICATION TECHNOLOGY','DICT',1,'Level 6 (Diploma)'),(2,'INFORMATION COMMUNICATION TECHNOLOGY','CICT',1,'Level 5 (Certificate)'),(3,'Diploma in Electrical Installation','DEI',2,'Level 6 (Diploma)'),(4,'Diploma in Social Work And Community Development','LS-DSWCD',11,'6'),(5,'Certificate in Social Work And Community Development','LS-CSWCD',11,'5');
/*!40000 ALTER TABLE `courses` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `head_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`),
  KEY `head_user_id` (`head_user_id`),
  CONSTRAINT `departments_ibfk_1` FOREIGN KEY (`head_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (1,'COMPUTING AND INFORMATICS',NULL,'2026-01-25 06:22:06'),(2,'ELECTRICAL AND ELECTRONICS ENGINEERING',NULL,'2026-01-25 08:48:30'),(3,'HOSPITALITY',NULL,'2026-02-15 04:44:07'),(4,'APPLIED SCIENCES',NULL,'2026-02-15 04:44:24'),(5,'HEALTH SCIENCES',NULL,'2026-02-15 04:44:39'),(6,'MECHANICAL',NULL,'2026-02-15 04:44:46'),(7,'BUILDINGAND CIVIL ENGINEERING',NULL,'2026-02-15 04:44:59'),(10,'AGRICULTURE',NULL,'2026-02-15 05:50:51'),(11,'LIBERAL STUDIES',NULL,'2026-02-15 05:52:10'),(12,'BUSINESS STUDIES',NULL,'2026-02-15 05:52:10');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `enrolled_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`,`class_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `enrollments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `enrollments_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `enrollments`
--

LOCK TABLES `enrollments` WRITE;
/*!40000 ALTER TABLE `enrollments` DISABLE KEYS */;
INSERT INTO `enrollments` VALUES (1,2,1,'2026-01-25 06:45:03'),(2,8,1,'2026-02-14 20:05:45'),(3,11,8,'2026-02-15 06:10:04'),(4,9,7,'2026-02-15 06:18:01');
/*!40000 ALTER TABLE `enrollments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `institution`
--

DROP TABLE IF EXISTS `institution`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `institution` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `tvet_code` varchar(50) DEFAULT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `system_name` varchar(255) DEFAULT 'CBET POE System',
  `logo_path` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `contact_phone` varchar(50) DEFAULT NULL,
  `about_text` text DEFAULT NULL,
  `hero_image_path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `institution`
--

LOCK TABLES `institution` WRITE;
/*!40000 ALTER TABLE `institution` DISABLE KEYS */;
INSERT INTO `institution` VALUES (1,'The Kitale National Polytechnic','0260026',NULL,'2162, 30200','2026-01-25 06:21:56','POE POINT','/uploads/settings/logo_1770918178.png','harrisonwekesa09@gmail.com','0741947264','Protecting Competence','/uploads/settings/hero_1770918501.jpg');
/*!40000 ALTER TABLE `institution` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `marksheet_status`
--

DROP TABLE IF EXISTS `marksheet_status`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `marksheet_status` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `status` enum('Draft','Submitted_to_HOD','HOD_Rejected','HOD_Approved','IQS_Rejected','IQS_Approved') DEFAULT 'Draft',
  `submitted_at` datetime DEFAULT NULL,
  `submitted_by` int(11) DEFAULT NULL,
  `hod_action_at` datetime DEFAULT NULL,
  `hod_user_id` int(11) DEFAULT NULL,
  `hod_comments` text DEFAULT NULL,
  `iqs_action_at` datetime DEFAULT NULL,
  `iqs_user_id` int(11) DEFAULT NULL,
  `iqs_comments` text DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `class_id` (`class_id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `marksheet_status_ibfk_1` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `marksheet_status_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `marksheet_status`
--

LOCK TABLES `marksheet_status` WRITE;
/*!40000 ALTER TABLE `marksheet_status` DISABLE KEYS */;
INSERT INTO `marksheet_status` VALUES (1,1,3,'IQS_Approved','2026-02-12 08:56:07',3,'2026-02-12 08:56:18',3,'p','2026-02-12 09:04:47',5,''),(2,1,1,'IQS_Approved','2026-02-14 21:23:04',3,'2026-02-14 21:23:56',6,'done','2026-02-14 21:25:30',5,'');
/*!40000 ALTER TABLE `marksheet_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) DEFAULT NULL,
  `executed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'001_initial_schema.sql','2026-01-25 06:02:55');
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poe_reviews`
--

DROP TABLE IF EXISTS `poe_reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poe_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) NOT NULL,
  `reviewer_user_id` int(11) NOT NULL,
  `role_at_time` varchar(50) DEFAULT NULL,
  `decision` enum('Approved','Rejected') NOT NULL,
  `comments` text DEFAULT NULL,
  `reviewed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `submission_id` (`submission_id`),
  KEY `reviewer_user_id` (`reviewer_user_id`),
  CONSTRAINT `poe_reviews_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `poe_submissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `poe_reviews_ibfk_2` FOREIGN KEY (`reviewer_user_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poe_reviews`
--

LOCK TABLES `poe_reviews` WRITE;
/*!40000 ALTER TABLE `poe_reviews` DISABLE KEYS */;
INSERT INTO `poe_reviews` VALUES (26,7,3,'Trainer','Approved','Quick Approval','2026-02-11 19:48:36'),(27,8,3,'Trainer','Approved','Quick Approval','2026-02-11 19:48:40'),(28,9,3,'Trainer','Rejected','Quick Rejection','2026-02-11 19:48:42'),(29,10,3,'Trainer','Rejected','Quick Rejection','2026-02-11 19:48:45'),(30,11,3,'Trainer','Approved','Quick Approval','2026-02-11 19:48:49'),(31,12,3,'Trainer','Approved','Quick Approval','2026-02-11 19:49:00'),(32,18,3,'Trainer','Approved','Quick Approval','2026-02-11 19:49:04'),(33,17,3,'Trainer','Rejected','Quick Rejection','2026-02-11 19:49:07'),(34,16,3,'Trainer','Approved','Quick Approval','2026-02-11 19:49:10'),(35,15,3,'Trainer','Approved','Quick Approval','2026-02-11 19:49:13'),(36,14,3,'Trainer','Approved','Quick Approval','2026-02-11 19:49:16'),(37,13,3,'Trainer','Approved','Quick Approval','2026-02-11 19:49:18'),(38,19,3,'Trainer','Approved','Quick Approval','2026-02-11 19:54:40'),(39,20,3,'Trainer','Approved','Quick Approval','2026-02-11 19:54:42'),(40,22,3,'Trainer','Approved','Quick Approval','2026-02-11 19:54:46'),(41,7,5,'InternalVerifier','','','2026-02-11 20:58:37'),(42,8,5,'InternalVerifier','','','2026-02-11 20:58:39'),(43,11,5,'InternalVerifier','','','2026-02-11 20:58:40'),(44,12,5,'InternalVerifier','','','2026-02-11 20:58:41'),(45,13,5,'InternalVerifier','','','2026-02-11 20:58:42'),(46,14,5,'InternalVerifier','','','2026-02-11 20:58:42'),(47,15,5,'InternalVerifier','','','2026-02-11 20:58:43'),(48,16,5,'InternalVerifier','Rejected','','2026-02-11 20:58:51'),(49,18,5,'InternalVerifier','','','2026-02-11 20:58:56'),(50,19,5,'InternalVerifier','','','2026-02-11 20:58:59'),(51,20,5,'InternalVerifier','','','2026-02-11 20:59:00'),(52,22,5,'InternalVerifier','','','2026-02-11 20:59:04'),(53,7,5,'InternalVerifier','','','2026-02-12 05:44:54'),(54,7,5,'InternalVerifier','','','2026-02-12 05:49:52'),(55,8,5,'InternalVerifier','','','2026-02-12 05:49:57'),(56,7,5,'InternalVerifier','','','2026-02-12 05:50:02'),(57,7,5,'InternalVerifier','','','2026-02-12 05:50:03'),(58,8,5,'InternalVerifier','','','2026-02-12 05:50:05'),(59,7,5,'InternalVerifier','','','2026-02-12 05:53:54'),(60,8,5,'InternalVerifier','','','2026-02-12 05:53:59'),(61,8,5,'InternalVerifier','','','2026-02-12 05:54:01'),(62,11,5,'InternalVerifier','','','2026-02-12 05:54:02'),(63,15,5,'InternalVerifier','','','2026-02-12 05:54:04'),(64,12,5,'InternalVerifier','','','2026-02-12 05:54:06'),(65,13,5,'InternalVerifier','','','2026-02-12 05:54:07'),(66,14,5,'InternalVerifier','','BASD','2026-02-12 05:54:11'),(67,16,5,'InternalVerifier','','','2026-02-12 05:54:14'),(68,19,5,'InternalVerifier','','','2026-02-12 05:54:16'),(69,18,5,'InternalVerifier','','','2026-02-12 05:54:17'),(70,20,5,'InternalVerifier','','','2026-02-12 05:54:19'),(71,22,5,'InternalVerifier','','','2026-02-12 05:54:21'),(72,14,5,'InternalVerifier','','','2026-02-14 17:28:08'),(73,23,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:35'),(74,24,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:36'),(75,25,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:37'),(76,26,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:38'),(77,27,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:42'),(78,30,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:45'),(79,29,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:48'),(80,28,3,'Trainer','Approved','Quick Approval','2026-02-14 18:22:50'),(81,23,5,'InternalVerifier','','','2026-02-14 18:24:43'),(82,24,5,'InternalVerifier','','','2026-02-14 18:24:44'),(83,25,5,'InternalVerifier','','','2026-02-14 18:24:45'),(84,26,5,'InternalVerifier','','','2026-02-14 18:24:47'),(85,27,5,'InternalVerifier','','','2026-02-14 18:24:48'),(86,30,5,'InternalVerifier','','','2026-02-14 18:24:50'),(87,29,5,'InternalVerifier','','','2026-02-14 18:24:52'),(88,28,5,'InternalVerifier','','','2026-02-14 18:24:54'),(89,29,5,'InternalVerifier','','','2026-02-14 18:25:10'),(90,24,5,'InternalVerifier','','','2026-02-14 18:25:11'),(91,25,5,'InternalVerifier','','','2026-02-14 18:25:12'),(92,28,5,'InternalVerifier','','','2026-02-14 18:25:12'),(93,26,5,'InternalVerifier','','','2026-02-14 18:25:13'),(94,23,5,'InternalVerifier','','','2026-02-14 18:25:14'),(95,30,5,'InternalVerifier','','','2026-02-14 18:25:14'),(96,27,5,'InternalVerifier','','','2026-02-14 18:25:16');
/*!40000 ALTER TABLE `poe_reviews` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `poe_submissions`
--

DROP TABLE IF EXISTS `poe_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `poe_submissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_user_id` int(11) NOT NULL,
  `assessment_slot_id` int(11) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(50) DEFAULT NULL,
  `status` enum('Pending','Submitted','Rejected','Approved') DEFAULT 'Pending',
  `verification_status` enum('None','Sampled','Verified','IV_Rejected') DEFAULT 'None',
  `version` int(11) DEFAULT 1,
  `submitted_at` datetime DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `student_user_id` (`student_user_id`),
  KEY `assessment_slot_id` (`assessment_slot_id`),
  CONSTRAINT `poe_submissions_ibfk_1` FOREIGN KEY (`student_user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `poe_submissions_ibfk_2` FOREIGN KEY (`assessment_slot_id`) REFERENCES `assessment_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `poe_submissions`
--

LOCK TABLES `poe_submissions` WRITE;
/*!40000 ALTER TABLE `poe_submissions` DISABLE KEYS */;
INSERT INTO `poe_submissions` VALUES (7,2,7,'2_7_1770839144.pdf','pdf','Approved','Verified',1,'2026-02-11 22:45:44','2026-02-12 05:53:54'),(8,2,8,'2_8_1770839150.pdf','pdf','Approved','Verified',1,'2026-02-11 22:45:50','2026-02-12 05:54:01'),(9,2,9,'2_9_1770839221.pdf','pdf','Rejected','None',1,'2026-02-11 22:47:01','2026-02-11 19:48:42'),(10,2,10,'2_10_1770839227.pdf','pdf','Rejected','None',1,'2026-02-11 22:47:07','2026-02-11 19:48:45'),(11,2,11,'2_11_1770839234.pdf','pdf','Approved','Verified',1,'2026-02-11 22:47:14','2026-02-12 05:54:02'),(12,2,12,'2_12_1770839240.pdf','pdf','Approved','Verified',1,'2026-02-11 22:47:20','2026-02-12 05:54:06'),(13,2,13,'2_13_1770839248.pdf','pdf','Approved','Verified',1,'2026-02-11 22:47:28','2026-02-12 05:54:07'),(14,2,14,'2_14_1770839255.pdf','pdf','Approved','Verified',1,'2026-02-11 22:47:35','2026-02-14 17:28:08'),(15,2,15,'2_15_1770839262.pdf','pdf','Approved','Verified',1,'2026-02-11 22:47:42','2026-02-12 05:54:04'),(16,2,16,'2_16_1770839269.pdf','pdf','Approved','Verified',1,'2026-02-11 22:47:49','2026-02-12 05:54:14'),(17,2,17,'2_17_1770839279.pdf','pdf','Rejected','None',1,'2026-02-11 22:47:59','2026-02-11 19:49:07'),(18,2,18,'2_18_1770839287.pdf','pdf','Approved','Verified',1,'2026-02-11 22:48:07','2026-02-12 05:54:17'),(19,2,9,'2_9_1770839623.pdf','pdf','Approved','Verified',2,'2026-02-11 22:53:43','2026-02-12 05:54:16'),(20,2,10,'2_10_1770839631.pdf','pdf','Approved','Verified',2,'2026-02-11 22:53:51','2026-02-12 05:54:19'),(21,2,17,'2_17_1770839638.pdf','pdf','Submitted','None',2,'2026-02-11 22:53:58','2026-02-11 19:53:58'),(22,2,17,'2_17_1770839646.pdf','pdf','Approved','Verified',3,'2026-02-11 22:54:06','2026-02-12 05:54:21'),(23,2,19,'2_19_1771093247.png','png','','Verified',1,'2026-02-14 21:20:47','2026-02-14 18:25:14'),(24,2,20,'2_20_1771093252.jpg','jpg','','Verified',1,'2026-02-14 21:20:52','2026-02-14 18:25:11'),(25,2,21,'2_21_1771093257.png','png','','Verified',1,'2026-02-14 21:20:57','2026-02-14 18:25:12'),(26,2,22,'2_22_1771093263.pdf','pdf','','Verified',1,'2026-02-14 21:21:03','2026-02-14 18:25:13'),(27,2,23,'2_23_1771093270.pdf','pdf','','Verified',1,'2026-02-14 21:21:10','2026-02-14 18:25:15'),(28,2,24,'2_24_1771093277.docx','docx','','Verified',1,'2026-02-14 21:21:17','2026-02-14 18:25:12'),(29,2,25,'2_25_1771093285.docx','docx','','Verified',1,'2026-02-14 21:21:25','2026-02-14 18:25:10'),(30,2,26,'2_26_1771093298.docx','docx','','Verified',1,'2026-02-14 21:21:38','2026-02-14 18:25:14');
/*!40000 ALTER TABLE `poe_submissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `professional_documents`
--

DROP TABLE IF EXISTS `professional_documents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `professional_documents` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trainer_user_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `type` varchar(50) NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `status` varchar(20) DEFAULT 'Pending',
  `comments` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `approved_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `trainer_user_id` (`trainer_user_id`),
  KEY `unit_id` (`unit_id`),
  KEY `class_id` (`class_id`),
  CONSTRAINT `professional_documents_ibfk_1` FOREIGN KEY (`trainer_user_id`) REFERENCES `users` (`id`),
  CONSTRAINT `professional_documents_ibfk_2` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`),
  CONSTRAINT `professional_documents_ibfk_3` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `professional_documents`
--

LOCK TABLES `professional_documents` WRITE;
/*!40000 ALTER TABLE `professional_documents` DISABLE KEYS */;
INSERT INTO `professional_documents` VALUES (1,3,2,1,'Course Outline','DOC_1_2_1769403316.pdf','Approved','','2026-01-26 04:55:16',NULL,NULL),(2,3,2,1,'Class Attendance','DOC_1_2_1769403327.pdf','Approved','','2026-01-26 04:55:27',NULL,NULL),(3,3,2,1,'Marksheet','DOC_1_2_1769403341.pdf','Approved','','2026-01-26 04:55:41',NULL,NULL),(4,3,2,1,'Curriculum','DOC_1_2_1769403351.pdf','Approved','','2026-01-26 04:55:51',NULL,NULL),(5,3,2,1,'Occupational Standards','DOC_1_2_1769403360.pdf','Approved','','2026-01-26 04:56:00',NULL,NULL),(6,3,1,1,'Class Attendance','DOC_1_1_1769403404.pdf','Approved','','2026-01-26 04:56:44',NULL,NULL),(7,3,1,1,'Class Attendance','DOC_1_1_1769403411.pdf','Approved','','2026-01-26 04:56:51',NULL,NULL),(8,3,1,1,'Marksheet','DOC_1_1_1769403417.pdf','Approved','','2026-01-26 04:56:57',NULL,NULL),(9,3,1,1,'Curriculum','DOC_1_1_1769403429.pdf','Approved','','2026-01-26 04:57:09',NULL,NULL);
/*!40000 ALTER TABLE `professional_documents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'Admin'),(3,'HOD'),(4,'InternalVerifier'),(5,'Student'),(2,'Trainer');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_marks`
--

DROP TABLE IF EXISTS `student_marks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_marks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `assessment_slot_id` int(11) NOT NULL,
  `marks_obtained` decimal(5,2) NOT NULL,
  `graded_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `graded_by_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_student_assessment` (`student_id`,`assessment_slot_id`),
  KEY `assessment_slot_id` (`assessment_slot_id`),
  CONSTRAINT `student_marks_ibfk_1` FOREIGN KEY (`student_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `student_marks_ibfk_2` FOREIGN KEY (`assessment_slot_id`) REFERENCES `assessment_slots` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_marks`
--

LOCK TABLES `student_marks` WRITE;
/*!40000 ALTER TABLE `student_marks` DISABLE KEYS */;
INSERT INTO `student_marks` VALUES (1,2,7,80.00,'2026-02-14 17:52:31',3),(2,2,8,84.00,'2026-02-14 17:52:31',3),(3,2,9,85.00,'2026-02-14 17:52:31',3),(4,2,10,82.00,'2026-02-14 17:52:31',3),(5,2,11,86.00,'2026-02-14 17:52:31',3),(6,2,12,83.00,'2026-02-14 17:52:31',3),(7,2,13,87.00,'2026-02-14 17:52:31',3),(8,2,14,90.00,'2026-02-14 17:52:31',3),(9,2,15,85.00,'2026-02-14 17:52:31',3),(10,2,16,85.00,'2026-02-14 17:52:31',3),(11,2,17,82.00,'2026-02-14 17:52:31',3),(12,2,18,89.00,'2026-02-14 17:52:31',3),(13,2,19,43.00,'2026-02-14 18:22:26',3),(14,2,20,78.00,'2026-02-14 18:22:26',3),(15,2,21,90.00,'2026-02-14 18:22:26',3),(16,2,22,67.00,'2026-02-14 18:22:26',3),(17,2,23,65.00,'2026-02-14 18:22:26',3),(18,2,24,87.00,'2026-02-14 18:22:26',3),(19,2,25,80.00,'2026-02-14 18:22:26',3),(20,2,26,64.00,'2026-02-14 18:22:26',3);
/*!40000 ALTER TABLE `student_marks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_allocations`
--

DROP TABLE IF EXISTS `unit_allocations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_allocations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `class_id` int(11) NOT NULL,
  `trainer_user_id` int(11) DEFAULT NULL,
  `verifier_user_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  KEY `class_id` (`class_id`),
  KEY `trainer_user_id` (`trainer_user_id`),
  KEY `verifier_user_id` (`verifier_user_id`),
  CONSTRAINT `unit_allocations_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE,
  CONSTRAINT `unit_allocations_ibfk_2` FOREIGN KEY (`class_id`) REFERENCES `classes` (`id`) ON DELETE CASCADE,
  CONSTRAINT `unit_allocations_ibfk_3` FOREIGN KEY (`trainer_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `unit_allocations_ibfk_4` FOREIGN KEY (`verifier_user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_allocations`
--

LOCK TABLES `unit_allocations` WRITE;
/*!40000 ALTER TABLE `unit_allocations` DISABLE KEYS */;
INSERT INTO `unit_allocations` VALUES (1,1,1,3,5,'2026-01-25 06:44:56'),(2,2,1,3,5,'2026-01-25 08:41:31'),(3,3,1,3,5,'2026-02-11 19:37:18');
/*!40000 ALTER TABLE `unit_allocations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `unit_topics`
--

DROP TABLE IF EXISTS `unit_topics`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `unit_topics` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `weight_percentage` decimal(5,2) DEFAULT 0.00,
  `sequence_order` int(11) DEFAULT 1,
  PRIMARY KEY (`id`),
  KEY `unit_id` (`unit_id`),
  CONSTRAINT `unit_topics_ibfk_1` FOREIGN KEY (`unit_id`) REFERENCES `units` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `unit_topics`
--

LOCK TABLES `unit_topics` WRITE;
/*!40000 ALTER TABLE `unit_topics` DISABLE KEYS */;
INSERT INTO `unit_topics` VALUES (1,3,'Introduction to Computer Operations',29.00,1),(2,3,'excel',24.00,2),(3,3,'access',9.00,3),(4,3,'word',14.00,4),(5,3,'powepoint',5.00,5),(6,3,'publisher',19.00,6),(7,1,'topic 1',32.00,1),(8,1,'topic 2',12.00,2),(9,1,'topic 3',23.00,3),(12,1,'topic 4',33.00,4);
/*!40000 ALTER TABLE `unit_topics` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `units`
--

DROP TABLE IF EXISTS `units`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `units` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unit_code` varchar(50) NOT NULL,
  `unit_title` varchar(255) NOT NULL,
  `category` enum('Basic','Common','Core') NOT NULL,
  `course_id` int(11) NOT NULL,
  `description` text DEFAULT NULL,
  `assessment_level` enum('Level 4','Level 5','Level 6') NOT NULL DEFAULT 'Level 6',
  PRIMARY KEY (`id`),
  UNIQUE KEY `unit_code` (`unit_code`),
  KEY `course_id` (`course_id`),
  CONSTRAINT `units_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `units`
--

LOCK TABLES `units` WRITE;
/*!40000 ALTER TABLE `units` DISABLE KEYS */;
INSERT INTO `units` VALUES (1,'CU/ICT/232/12/21','DEVELOP A COMPUTER PROGRAM','Core',1,'','Level 6'),(2,'435E','Artificial intelligence','Core',1,'','Level 6'),(3,'CU/ICT/232/12/22','Perform Computer Operations','Core',1,'Perform Computer Operations','Level 4'),(4,'ENG/DEI/001/26','Demonstrate Electrical Principles','Common',3,'','Level 6'),(5,'ENG/DEI/002/26','Demonstrate Basic Electronics Principles','Basic',3,'','Level 6'),(6,'LS/DLSU/001','Communication Skills','Basic',4,'Intro to communication skills','Level 6'),(7,'LS/DLSU/002','OSH Skills','Basic',4,'Intro to OSH skills','Level 6');
/*!40000 ALTER TABLE `units` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(150) NOT NULL,
  `identifier` varchar(50) DEFAULT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `full_name` varchar(150) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role_id` int(11) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `must_change_password` tinyint(1) DEFAULT 0,
  `department_id` int(11) DEFAULT NULL,
  `suspension_reason` text DEFAULT NULL,
  `is_deleted` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `users_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'admin@cbet.local','A1','',NULL,'$2y$10$/vV7LLpY5ZITDbrnDhAzW.nIIHaBpfHf/ZmMczdArz9VY5jAHb9Eu','Harrison',NULL,1,1,'2026-01-25 06:02:55',0,NULL,NULL,0),(2,'harrisonwekesa009@gmail.com','IT-DICTL/1234/26',NULL,NULL,'$2y$10$cX3qnzb63qV0DtobA3lxTeq3KD.2jMgCCHJ.6FF4w4wtOkES6q93i','Wekesa Harrison',NULL,5,1,'2026-01-25 06:26:45',0,1,NULL,0),(3,'harrisonwekesa09@gmail.com','T1',NULL,NULL,'$2y$10$s6HfugsfoNDy1hci9PsAgu8grv3lcDaD0wqWdYo1sL0b7GwylxDnO','Harrison Wekesa Wanjala',NULL,2,1,'2026-01-25 06:42:34',0,1,NULL,0),(4,'harrisonwekes019@gmail.com','IV1',NULL,NULL,'$2y$10$sE1nHyTE4z1j0f8PebPJgOl03RUAkXusjFkPOzCtPcmds8Kd0W096','Harrison Wekesa',NULL,4,1,'2026-01-25 06:47:55',1,NULL,NULL,0),(5,'mimi@gmail.com','003',NULL,NULL,'$2y$10$9Lro0AdX9kcX28vfxxLV.ecH39ILoD9Z1PF5hgQOkBZNxvQUEupLG','mimi',NULL,4,1,'2026-01-25 14:54:45',0,NULL,NULL,0),(6,'hod@gmail.com','HOD1',NULL,NULL,'$2y$10$WIIJG1ekvnLSs5l3B/1UFuTLo5nOjV2cJI2bk9TRNLoXFK.rnYDyG','hod',NULL,3,1,'2026-01-25 16:12:55',0,1,NULL,0),(7,'student2@gmail.com','st/002',NULL,NULL,'$2y$10$g0dfM8apyBu6TYu60uTWG./iDhBRAhAdQR.QtruZ8Qiq1fZiHYRVW','student2',NULL,5,1,'2026-02-14 19:58:53',1,NULL,NULL,1),(8,'student209@gmail.com','st/002/ci/26',NULL,NULL,'$2y$10$WSc/bk3C8ZQurp0SFoFyQ.S4gqBMOHO4F6Ng4fdRACoQfXTPTJdoK','student2',NULL,5,1,'2026-02-14 20:01:48',0,1,NULL,0),(9,'john@example.com','ST/001/24',NULL,NULL,'$2y$10$RNCcIrTmh5n0h121q2DaR.V8RYHK6IDzcdxjUe4mZepikawKu3X2O','John Doe',NULL,5,1,'2026-02-15 06:06:18',0,11,NULL,0),(11,'jane@example.com','PF-12345',NULL,NULL,'$2y$10$zwr9MEQNW.geKq6PfiXDB.rfUtULu2IR.8gYy5sb8nAdbhRl4W.MO','Jane Staff',NULL,5,1,'2026-02-15 06:10:04',1,11,NULL,0);
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

-- Dump completed on 2026-02-16 20:51:04
