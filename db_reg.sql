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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_panel`
--

LOCK TABLES `admin_panel` WRITE;
/*!40000 ALTER TABLE `admin_panel` DISABLE KEYS */;
INSERT INTO `admin_panel` VALUES (4,'test1.com','asdasd23423432adsdsadsa43423','2017-11-15 11:53:37'),(5,'reg.com','d0c7fb0aae742e21cdc8b57a9021f1d5','2017-11-15 11:54:49'),(6,'optimization.guide','bd73b8883ba95cf791ec11d72702839e','2017-11-17 12:31:48'),(7,'optimization1.guide','a6fec40d6586861cb4f8e4c52680ebbf','2017-11-17 12:34:16'),(8,'optimization2.guide','6ac7c148eb577633a49f40f50a1ef560','2017-11-17 12:35:10'),(9,'optimization3.guide','286ff1cbf1d771fe93ddaa5b52ceb2c4','2017-11-17 12:36:17'),(11,'optimization5.guide','00907e1be9d98b5804b91e4232ec6f74','2017-11-17 12:41:06');
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `api_action_log`
--

LOCK TABLES `api_action_log` WRITE;
/*!40000 ALTER TABLE `api_action_log` DISABLE KEYS */;
INSERT INTO `api_action_log` VALUES (1,5,'admin_panel',11,'create','2017-11-17 12:41:06'),(2,5,'admin_panel',10,'delete','2017-11-17 12:55:32');
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
  `url` varchar(200) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `admin_panel_id` (`admin_panel_id`),
  CONSTRAINT `landing_page_ibfk_1` FOREIGN KEY (`admin_panel_id`) REFERENCES `admin_panel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landing_page`
--

LOCK TABLES `landing_page` WRITE;
/*!40000 ALTER TABLE `landing_page` DISABLE KEYS */;
INSERT INTO `landing_page` VALUES (1,5,'http://redmine.arbooz.com');
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
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scenario`
--

LOCK TABLES `scenario` WRITE;
/*!40000 ALTER TABLE `scenario` DISABLE KEYS */;
INSERT INTO `scenario` VALUES (1,1,3,'[{\"step_id\":\"1\",\"parameters\":{\"param1\":\"1\",\"param2\":\"2\"}},{\"step_id\":\"2\",\"parameters\":{\"param1\":\"1\",\"param2\":\"2\"}}]','{\r\n                    \"geo\": {},\r\n                    \"device\": {},\r\n                    \"time_table\": {},\r\n                    \"user_access\": {\"new\" : 0, \"old\" : 1}\r\n                }');
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

-- Dump completed on 2017-11-17 15:15:38
