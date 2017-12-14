-- MySQL dump 10.13  Distrib 5.7.20, for Linux (x86_64)
--
-- Host: localhost    Database: register_service
-- ------------------------------------------------------
-- Server version	5.7.20

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admin_panel`
--

DROP TABLE IF EXISTS `admin_panel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin_panel` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `host` varchar(100) NOT NULL,
  `secure_key` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_panel`
--

LOCK TABLES `admin_panel` WRITE;
/*!40000 ALTER TABLE `admin_panel` DISABLE KEYS */;
INSERT INTO `admin_panel` VALUES (4,'test1.com','asdasd23423432adsdsadsa43423','2017-11-15 11:53:37'),(6,'optimization.guide','bd73b8883ba95cf791ec11d72702839e','2017-11-17 12:31:48'),(7,'optimization1.guide','a6fec40d6586861cb4f8e4c52680ebbf','2017-11-17 12:34:16'),(8,'optimization2.guide','6ac7c148eb577633a49f40f50a1ef560','2017-11-17 12:35:10'),(9,'optimization3.guide','286ff1cbf1d771fe93ddaa5b52ceb2c4','2017-11-17 12:36:17'),(11,'optimization5.guide','00907e1be9d98b5804b91e4232ec6f74','2017-11-17 12:41:06'),(12,'optimization7.guide','9a1528e0ed682a2e9ecbc7b2a27ba6d2','2017-11-27 11:49:20'),(13,'optimization6.guide','d6e0e5f4173a6fcb5802859d46c9ccd2','2017-11-27 11:50:34'),(14,'test_nat45','9316fc7dabbe3a5c2509a8ec181c6e66','2017-12-05 17:55:44');
/*!40000 ALTER TABLE `admin_panel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `api_action_log`
--

DROP TABLE IF EXISTS `api_action_log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `api_action_log` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `id_admin_panel` bigint(20) NOT NULL,
  `entity_type` varchar(100) NOT NULL,
  `entity_id` bigint(20) NOT NULL,
  `action_type` varchar(100) NOT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_action_log`
--

LOCK TABLES `api_action_log` WRITE;
/*!40000 ALTER TABLE `api_action_log` DISABLE KEYS */;
INSERT INTO `api_action_log` VALUES (1,5,'admin_panel',11,'create','2017-11-17 12:41:06'),(2,5,'admin_panel',10,'delete','2017-11-17 12:55:32'),(3,5,'admin_panel',12,'create','2017-11-27 11:49:20'),(4,5,'admin_panel',13,'create','2017-11-27 11:50:34'),(5,5,'landing_page',2,'create','2017-12-05 15:52:29'),(6,5,'landing_page',3,'create','2017-12-05 15:53:04'),(7,5,'admin_panel',14,'create','2017-12-05 17:55:44'),(8,5,'scenario',2,'create','2017-12-06 13:15:11'),(9,5,'scenario',3,'create','2017-12-06 13:15:18'),(10,5,'scenario',4,'create','2017-12-06 17:19:31'),(11,5,'scenario',5,'create','2017-12-06 19:59:29'),(12,5,'admin_panel',5,'delete','2017-12-07 11:52:51'),(13,5,'landing_page',4,'create','2017-12-07 15:43:39'),(14,5,'scenario',8,'create','2017-12-07 16:26:01'),(15,5,'scenario',13,'create','2017-12-07 16:46:22'),(16,5,'scenario',14,'create','2017-12-07 16:46:35'),(17,5,'scenario',15,'create','2017-12-07 16:46:53'),(18,5,'scenario',16,'create','2017-12-07 16:47:15'),(19,5,'scenario',17,'create','2017-12-07 16:47:28'),(20,5,'scenario',18,'create','2017-12-07 16:48:45'),(21,5,'scenario',19,'create','2017-12-07 16:49:28'),(22,5,'scenario',20,'create','2017-12-07 16:50:22'),(23,5,'landing_page',6,'create','2017-12-08 11:20:20'),(24,5,'landing_page',7,'create','2017-12-08 11:46:17'),(25,5,'landing_page',8,'create','2017-12-08 11:47:44');
/*!40000 ALTER TABLE `api_action_log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `landing_page`
--

DROP TABLE IF EXISTS `landing_page`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `landing_page` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `admin_panel_id` bigint(20) NOT NULL,
  `url` varchar(2048) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_panel_id` (`admin_panel_id`),
  CONSTRAINT `landing_page_ibfk_1` FOREIGN KEY (`admin_panel_id`) REFERENCES `admin_panel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landing_page`
--

LOCK TABLES `landing_page` WRITE;
/*!40000 ALTER TABLE `landing_page` DISABLE KEYS */;
INSERT INTO `landing_page` VALUES (2,4,'test_nat'),(3,4,'test_nat45'),(4,6,'http:/otball1111155555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555111'),(6,6,'https://1lalalalanr.com'),(7,7,'http:/otball1111155555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555111'),(8,7,'http:/ohttp:/otball1111155555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555111tball111http:/otball1111155555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555111http:/otball11111555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555551111155555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555555111');
/*!40000 ALTER TABLE `landing_page` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `scenario`
--

DROP TABLE IF EXISTS `scenario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `scenario` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `landing_page_id` bigint(11) NOT NULL,
  `popup_id` int(11) NOT NULL,
  `steps` longtext NOT NULL,
  `filters` longtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `landing_page_id` (`landing_page_id`),
  CONSTRAINT `scenario_ibfk_1` FOREIGN KEY (`landing_page_id`) REFERENCES `landing_page` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scenario`
--

LOCK TABLES `scenario` WRITE;
/*!40000 ALTER TABLE `scenario` DISABLE KEYS */;
INSERT INTO `scenario` VALUES (8,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3,\"parameter\":20}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(13,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3,\"parameter\":20}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(14,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3,\"parameter\":20}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(15,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3,\"parameter\":\"\"}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(16,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(17,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(18,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(19,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}'),(20,4,33,'[{\"step_id\":1,\"parameter\":50},{\"step_id\":3,\"parameter\":80}]','{\"geo\":[],\"device\":[],\"time_table\":[],\"user_access\":{\"new\":0,\"old\":1}}');
/*!40000 ALTER TABLE `scenario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-12-08 12:05:33
