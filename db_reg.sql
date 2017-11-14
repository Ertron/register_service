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
  `key` varchar(100) NOT NULL,
  `reg_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin_panel`
--

LOCK TABLES `admin_panel` WRITE;
/*!40000 ALTER TABLE `admin_panel` DISABLE KEYS */;
INSERT INTO `admin_panel` VALUES (1,'silex.symfony.com','23423432423@sadasSA#@sdas','2017-11-09 18:15:23'),(2,'habrahabr.ru','334fsd@fds!~sadas#sds','2017-11-09 18:15:23');
/*!40000 ALTER TABLE `admin_panel` ENABLE KEYS */;
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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `landing_page`
--

LOCK TABLES `landing_page` WRITE;
/*!40000 ALTER TABLE `landing_page` DISABLE KEYS */;
INSERT INTO `landing_page` VALUES (1,1,'http://redmine.arbooz.com/issues/10114'),(2,1,'http://magic.testing.digital-forest.info/administrator/index.php'),(3,2,'http://magic.testing.digital-forest.info/administrator/index.php'),(4,2,'https://www.tassos.gr/joomla-extensions/engagebox/docs/using-javascript-api');
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
  `landing_page_id` int(11) NOT NULL,
  `scenario_id` int(11) NOT NULL,
  `popup_id` int(11) NOT NULL,
  `steps` longtext NOT NULL,
  `filters` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `scenario`
--

LOCK TABLES `scenario` WRITE;
/*!40000 ALTER TABLE `scenario` DISABLE KEYS */;
INSERT INTO `scenario` VALUES (1,1,1,1,'                  {\r\n                        \"step_id\": \"1\",\r\n                        \"parameters\": {\r\n                            \"param1\": \"1\",\r\n                            \"param2\": \"2\" \r\n                        }\r\n                    }','{\r\n                    \"geo\": {},\r\n                    \"device\": {},\r\n                    \"time_table\": {},\r\n                    \"user_access\": {\"new\" : 0, \"old\" : 1}\r\n                }'),(2,1,2,3,'                  {\r\n                        \"step_id\": \"1\",\r\n                        \"parameters\": {\r\n                            \"param1\": \"777\",\r\n                            \"param2\": \"775\" \r\n                        }\r\n                    }','{\r\n                    \"geo\": {},\r\n                    \"device\": {},\r\n                    \"time_table\": {},\r\n                    \"user_access\": {\"new\" : 0, \"old\" : 1}\r\n                }');
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

-- Dump completed on 2017-11-14 19:24:23
