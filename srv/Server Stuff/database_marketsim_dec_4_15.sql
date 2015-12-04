-- MySQL dump 10.14  Distrib 5.5.46-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: marketsim
-- ------------------------------------------------------
-- Server version	5.5.46-MariaDB-1ubuntu0.14.04.2

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
-- Table structure for table `admin`
--

DROP TABLE IF EXISTS `admin`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` tinytext NOT NULL,
  `lname` tinytext,
  `email` tinytext NOT NULL,
  `password` char(64) NOT NULL,
  `secQuestion` varchar(64) NOT NULL,
  `secAnswer` char(64) NOT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admin`
--

LOCK TABLES `admin` WRITE;
/*!40000 ALTER TABLE `admin` DISABLE KEYS */;
INSERT INTO `admin` VALUES (1,'Administrator','','admin@marketsim.com','92d4ab45f821941bc06265eebf765074a7fc0294da2776a447c888becd1f959b','Its raining cats and ..','6f072fda980fc0906b6a31aa1e6dfb6ca375d8a7faac5ba2decced25cdfd68fe',1),(2,'Javier','Andrial','theboss@marketsim.com','9ab0d66e6d3d5e76ae1fa8fd4eb5f66a68ecc1846cb9f6ce7c55a97a25d7d0c3','new recovery','01792c3f35e899d4d4c36f42158209ca3e1b5e17d6e53032fc1eef96ac7007fc',1),(10,'Test','account','test@test.com','b778f7e6d305cf7af4eddf1660eef2a897794c46741e6a4933d761cf8190c5c5','Test question','testanwer',1),(12,'test','tes','admin@market.com','9c517c2ba3fe0efad38ea4e72967add2663546a9b4b85e1c70cd70a494c173f5','what is my question','23258042f1185c3f48f742976e5c31e829046001cf74bc9ff2537080f917047a',1),(13,'new','Admin','newadmin@fiu.edu','6cf5e8647844d6614ae330d8efc2cccdd1e2369308af5444bb8d16999b768978','new admin','2ad19f99a05fa49d351df8ee3754fd7199d6e576ad7c23b0a72109d1c170b4ef',1);
/*!40000 ALTER TABLE `admin` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `advertising`
--

DROP TABLE IF EXISTS `advertising`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `advertising` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinytext NOT NULL,
  `impact` decimal(12,2) DEFAULT NULL,
  `cost` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `advertising`
--

LOCK TABLES `advertising` WRITE;
/*!40000 ALTER TABLE `advertising` DISABLE KEYS */;
INSERT INTO `advertising` VALUES (1,'Direct_Marketing',1.09,3000.00),(2,'Public_Relations',1.18,6000.00),(3,'print',1.15,4000.00),(4,'Bill_Boards',1.12,3500.00),(5,'facebook',1.10,2500.00),(6,'google',1.25,9000.00),(7,'radio',1.15,4000.00),(8,'tv',1.30,10000.00),(9,'promo',1.05,2000.00),(10,'eMarketing',1.05,2000.00),(11,'city_bus_ads',1.03,1500.00);
/*!40000 ALTER TABLE `advertising` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game`
--

DROP TABLE IF EXISTS `game`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `semester` tinytext NOT NULL,
  `course` tinytext NOT NULL,
  `section` tinytext NOT NULL,
  `schedule` tinytext,
  `isActive` tinyint(4) DEFAULT '1',
  `courseNumber` tinytext,
  `periodNum` int(3) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game`
--

LOCK TABLES `game` WRITE;
/*!40000 ALTER TABLE `game` DISABLE KEYS */;
INSERT INTO `game` VALUES (1,'FALL','MAR3251','eu-65215','MF 3:45-5:15',1,'75648',1),(3,'Spring','MAR 3615','eu-9873','MWF 6:30-7:50',1,'85426',2),(4,'FALL 2016','MAR2016','U02','MWF 12pm',1,'87658',1),(115,'semsef ','cop 4620','U03','MWF 12pm',1,'58458',1),(122,'56565','56565','56565','56565',1,'56565',1),(125,'Spring 2016','COP 4545','U05','MWF 1pm',1,'12345',1);
/*!40000 ALTER TABLE `game` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `game_period`
--

DROP TABLE IF EXISTS `game_period`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `game_period` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` int(11) NOT NULL,
  `pstart` datetime NOT NULL,
  `pend` datetime DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  `period` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `game` (`game`),
  CONSTRAINT `game_period_ibfk_1` FOREIGN KEY (`game`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `game_period`
--

LOCK TABLES `game_period` WRITE;
/*!40000 ALTER TABLE `game_period` DISABLE KEYS */;
INSERT INTO `game_period` VALUES (1,4,'2016-08-20 00:00:00','2016-09-30 00:00:00',1,1),(2,3,'2016-08-20 00:00:00','2015-11-30 00:00:00',1,1),(3,1,'2016-08-20 00:00:00','2016-09-30 00:00:00',1,1),(8,115,'2015-10-20 00:00:00','2015-02-20 00:00:00',1,1),(25,125,'2016-01-15 00:00:00','2016-01-28 00:00:00',1,1),(26,125,'2016-01-29 00:00:00','2016-02-11 00:00:00',1,2),(27,125,'2016-02-12 00:00:00','2016-02-25 00:00:00',1,3),(28,125,'2016-02-26 00:00:00','2016-03-10 00:00:00',1,4),(29,125,'2016-03-11 00:00:00','2016-03-24 00:00:00',1,5),(30,125,'2016-03-25 00:00:00','2016-04-07 00:00:00',1,6);
/*!40000 ALTER TABLE `game_period` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `hotel`
--

DROP TABLE IF EXISTS `hotel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` tinytext NOT NULL,
  `location` int(11) NOT NULL,
  `type` enum('economy','midrange','luxury') DEFAULT NULL,
  `game` int(11) NOT NULL,
  `balance` decimal(12,2) DEFAULT NULL,
  `revenue` decimal(12,2) DEFAULT NULL,
  `roomsFilled` float DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  `budget` decimal(12,2) DEFAULT NULL,
  `purpose` enum('business','leisure') DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `game` (`game`),
  KEY `location` (`location`),
  CONSTRAINT `hotel_ibfk_1` FOREIGN KEY (`game`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `hotel_ibfk_2` FOREIGN KEY (`location`) REFERENCES `location` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=126 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hotel`
--

LOCK TABLES `hotel` WRITE;
/*!40000 ALTER TABLE `hotel` DISABLE KEYS */;
INSERT INTO `hotel` VALUES (46,'ABC Marketing',12345,'midrange',1,50000.00,0.00,0,1,50000.00,NULL),(48,'Jeff\'s Group',12345,'midrange',3,50000.00,15000.00,0,1,50000.00,'business'),(50,'Brooke Marketing',12345,'economy',3,50000.00,22000.00,0,1,50000.00,'leisure'),(51,'XYZ Group',12345,'economy',3,50000.00,16000.00,0,1,50000.00,'leisure'),(110,'XYZ Marketing',12348,'economy',3,50000.00,32000.00,0,1,50000.00,'leisure'),(111,'zzz Marketing',12347,NULL,1,50000.00,0.00,0,1,50000.00,NULL),(112,'Best Group',12345,NULL,1,50000.00,0.00,0,1,50000.00,NULL),(113,'Best Group Ever',12345,'luxury',3,50000.00,21000.00,0,1,50000.00,'business'),(114,'Bot Hotel',12310,'midrange',4,50000.00,0.00,0,1,50000.00,NULL),(115,'FIU BOT INN',12310,'luxury',4,50000.00,0.00,0,1,50000.00,NULL),(116,'CPU Inn',12310,'economy',4,50000.00,0.00,0,1,50000.00,NULL),(117,'Hotel name',12345,'midrange',4,50000.00,0.00,0,1,50000.00,NULL),(118,'MyNewGroup',12310,NULL,1,50000.00,0.00,0,1,50000.00,NULL),(119,'Another new Group',12345,'midrange',3,50000.00,12000.00,0,1,50000.00,'business'),(120,'Mikes Groups',12310,NULL,1,50000.00,NULL,NULL,1,50000.00,NULL),(121,'some new gr',12347,NULL,1,50000.00,NULL,NULL,1,50000.00,NULL),(122,'Hotel Miami',12310,'luxury',115,50000.00,20000.00,0,1,50000.00,NULL),(123,'Hotel Havana',12347,'luxury',115,50000.00,20000.00,0,1,50000.00,NULL),(124,'testbot10',12310,'economy',3,0.00,600.00,0,1,50000.00,NULL),(125,'Bot Hotel',12347,'midrange',125,0.00,0.00,0,1,50000.00,NULL);
/*!40000 ALTER TABLE `hotel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `location`
--

DROP TABLE IF EXISTS `location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `location` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinytext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12350 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `location`
--

LOCK TABLES `location` WRITE;
/*!40000 ALTER TABLE `location` DISABLE KEYS */;
INSERT INTO `location` VALUES (12310,'Commercial'),(12345,'Beachfront'),(12347,'Downtown'),(12348,'Airport'),(12349,'Resedential');
/*!40000 ALTER TABLE `location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `market_share`
--

DROP TABLE IF EXISTS `market_share`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `market_share` (
  `gameid` int(6) DEFAULT NULL,
  `period` int(6) DEFAULT NULL,
  `hotel` int(6) DEFAULT NULL,
  `roomsSold` int(6) DEFAULT NULL,
  `groupSold` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `market_share`
--

LOCK TABLES `market_share` WRITE;
/*!40000 ALTER TABLE `market_share` DISABLE KEYS */;
INSERT INTO `market_share` VALUES (3,1,119,7142,1295),(3,1,48,7142,1295),(3,1,110,7142,1214),(3,1,51,7142,906),(3,1,124,7142,809),(3,1,113,7142,809),(3,1,50,7142,1234);
/*!40000 ALTER TABLE `market_share` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` int(11) DEFAULT NULL,
  `article` text,
  `periodNum` int(3) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
INSERT INTO `news` VALUES (1,1,'<h1>Header 1</h1>\r\n<h2>Header 2</h2>\r\n<h3>Header 3</h3>\r\n<h4>Header 4</h4>\r\n<h5>Header 5</h5>\r\n<b>Bold</b>\r\n<br />\r\n<mark>Marked</mark>\r\n<br />\r\n<small>Small</small>\r\n<br />\r\n<strong>Strong</strong>\r\n<br />\r\n<del>Delete</del>\r\n<br />\r\n<ins>inserted</ins>\r\n<br />\r\n<sub>subscripted</sub>\r\n<br />\r\n<sup>Superscripted</sup>\r\n<br />\r\n<p>Paragraph</p>\r\n<br />',1),(2,2,'This Article has not yet been set for this period.',1),(3,3,'Game 3\r\n\r\nThis Article has not yet been set for this period.',1),(4,4,'<div align=center style=\'margin:auto; width:50%;\'>\r\n<h2><b>Breaking News</b></h2>\r\n<h3>Urgent Matter!</h3>\r\n\r\n<br />\r\n<h4 align=left>\r\nThings that are <b>Dangerous!</b>\r\n</h4>\r\n<ul>\r\n\r\n<li>\r\n<h5 align=left>\r\nLions!\r\n</h5>\r\n</li>\r\n\r\n<li>\r\n<h5 align=left>\r\nTigers!\r\n</h5>\r\n</li>\r\n\r\n<li>\r\n<h5 align=left>\r\nBears!\r\n</h5>\r\n\r\n</li>\r\n<li>\r\n<h5 align=left>\r\nOh My!\r\n</h5>\r\n</li>\r\n\r\n</ul>\r\n</div>',1),(14,115,'<div align=center style=\'margin:auto; width:80%;\'>\r\n<h1 class=\"entry-title\">OU football: Board of Regents approves updated stadium renovation plan</h1>\r\n<br />\r\n<img src=\"http://cdn2.newsok.biz/cache/w620-a5c54b153317b6c31d41109426c69857.jpg\" width=\"620\" class=\"photo\" alt=\"photo - \" title=\"\">\r\n</div>\r\n<br />\r\n<br />\r\n<div align=left style=\'margin:auto; width:65%;\'>\r\n<p>\r\nDespite the project being scaled down from its initial scope, University of Oklahoma athletic director Joe Castiglione was thrilled Tuesday when the OU Board of Regents approved the plan for the first phase of renovation to Gaylord Family-Oklahoma Memorial Stadium.\r\n</p>\r\n<p>\r\nThe project, which is expected to cost $160 million, will be funded in part by $117 million in bonds. Those funds were approved at the meeting at the OU Health Sciences Center as well.\r\n</p>\r\n<p>\r\nâ€œWeâ€™ve always been the program that embraces an opportunity when itâ€™s developed to do it at a state-of-the-art standard. Period,â€ Castiglione said. â€œWe donâ€™t leave anything left in our discovery to find out what it is that can make ours the best of the best.â€\r\n</p>\r\n<p>\r\nConstruction will start within the next four to eight weeks, though the stadium will remain fully functional until after the end of the 2015 season.\r\n</p>\r\n<p>\r\nThe most striking change with the renovation will be the bowling in of the south end zone. Other changes that affect fans will be an expanded concourse, additional restrooms and concessions in that area and additional suites (22), open-air lodge boxes (60) and club seats (1,976).\r\n</p>\r\n<p>\r\nThe team facilities in the south end zone will also be overhauled, with the weight room nearly tripling in size to 26,000 feet. It will also include a 70-yard indoor turfed surface and an expanded training room.\r\n</p>\r\n<p>\r\nIn the initial renovation plans announced in June, plans called for the weight room to be 30,852 square feet.\r\n</p>\r\n<p>\r\nThose plans, which also called for a renovation of the west side upper deck of the stadium in a different phase, had to be scaled back in large part due to sagging oil prices.\r\n</p>\r\n<p>\r\nâ€œIn one week, when half the net worth of our major donors was wiped out by the fallen oil prices,â€ OU President David Boren said of when he started realizing there could be a problem. â€œYou know you are sitting there and someone is worth so many million dollars and three days later, they are worth half that â€” thatâ€™s exactly what happened to a lot of our major donors and supporters. Also, then you look at what it does to the rest of the economy, what it does to the rest of the university. So we had to take that into account immediately.â€\r\n</p>\r\n\r\n</div>',1),(42,115,'<h1>Header 1</h1>\r\n<h2>Header 2</h2>\r\n<h3>Header 3</h3>\r\n<h4>Header 4</h4>\r\n<h5>Header 5</h5>\r\n<b>Bold</b>\r\n<br />\r\n<mark>Marked</mark>\r\n<br />\r\n<small>Small</small>\r\n<br />\r\n<strong>Strong</strong>\r\n<br />\r\n<del>Delete</del>\r\n<br />\r\n<ins>inserted</ins>\r\n<br />\r\n<sub>subscripted</sub>\r\n<br />\r\n<sup>Superscripted</sup>\r\n<br />\r\n<p>Paragraph</p>\r\n<br />',2),(43,3,'This Article Has Not Yet Been Set.',2),(47,2,'',4),(50,5,'',7),(52,2,'',4),(54,2,'',4),(55,3,'This Article Has Not Yet Been Set.',3),(56,3,'This Article Has Not Yet Been Set.',4),(58,2,'',4),(60,2,'',4),(63,2,'',4),(64,2,'',4),(67,122,'This Article Has Not Yet Been Set.',1),(70,125,'This Article Has Not Yet Been Set.',1);
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news_parameters`
--

DROP TABLE IF EXISTS `news_parameters`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news_parameters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `news_id` int(11) NOT NULL,
  `effect` enum('Very Bad','Fairly Bad','None','Fairly Good','Very Good') DEFAULT NULL,
  `hotel_type` enum('Economic','Midrange','Luxury') DEFAULT NULL,
  `hotel_location` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news_parameters`
--

LOCK TABLES `news_parameters` WRITE;
/*!40000 ALTER TABLE `news_parameters` DISABLE KEYS */;
INSERT INTO `news_parameters` VALUES (20,1,'Fairly Good','Economic',12310),(21,1,'Very Good','Midrange',12345),(22,1,'None','Luxury',12345),(23,1,'None','Economic',12310),(28,1,'Very Bad','Luxury',12345),(31,4,'Very Good','Economic',12310),(32,4,'Very Bad','Luxury',12349),(33,4,'None','Midrange',12345),(37,99,'Very Bad','Midrange',99),(38,99,'Very Bad','Midrange',99),(39,99,'Very Bad','Midrange',99),(44,57,'None','Economic',12310),(45,3,'Fairly Bad','Economic',12310),(46,3,'Very Good','Economic',12345);
/*!40000 ALTER TABLE `news_parameters` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ota`
--

DROP TABLE IF EXISTS `ota`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ota` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `discount` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ota`
--

LOCK TABLES `ota` WRITE;
/*!40000 ALTER TABLE `ota` DISABLE KEYS */;
INSERT INTO `ota` VALUES (1,0.70);
/*!40000 ALTER TABLE `ota` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personnel`
--

DROP TABLE IF EXISTS `personnel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personnel` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(30) NOT NULL,
  `cost` decimal(12,2) DEFAULT NULL,
  `impact` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personnel`
--

LOCK TABLES `personnel` WRITE;
/*!40000 ALTER TABLE `personnel` DISABLE KEYS */;
INSERT INTO `personnel` VALUES (1,'Entry Level',3000.00,1.05),(2,'Manager in training',5000.00,1.15),(3,'Experienced professional',7500.00,1.30);
/*!40000 ALTER TABLE `personnel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `research`
--

DROP TABLE IF EXISTS `research`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `research` (
  `id` int(6) NOT NULL AUTO_INCREMENT,
  `cost` double(12,2) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `research`
--

LOCK TABLES `research` WRITE;
/*!40000 ALTER TABLE `research` DISABLE KEYS */;
INSERT INTO `research` VALUES (1,5000.00);
/*!40000 ALTER TABLE `research` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenue`
--

DROP TABLE IF EXISTS `revenue`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revenue` (
  `game` int(6) NOT NULL DEFAULT '0',
  `period` int(6) NOT NULL DEFAULT '0',
  `hotel` int(6) NOT NULL DEFAULT '0',
  `revenue` decimal(12,2) DEFAULT NULL,
  PRIMARY KEY (`game`,`period`,`hotel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenue`
--

LOCK TABLES `revenue` WRITE;
/*!40000 ALTER TABLE `revenue` DISABLE KEYS */;
INSERT INTO `revenue` VALUES (3,1,48,3400200.00),(3,1,50,4801520.00),(3,1,51,3362716.00),(3,1,110,4803725.00),(3,1,113,4795000.00),(3,1,119,4827475.00),(3,1,124,9675.00);
/*!40000 ALTER TABLE `revenue` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `strat_decisions`
--

DROP TABLE IF EXISTS `strat_decisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `strat_decisions` (
  `gameID` int(6) NOT NULL DEFAULT '0',
  `periodNum` int(6) NOT NULL DEFAULT '0',
  `aveRate` double(12,2) DEFAULT NULL,
  `hotel` int(6) NOT NULL DEFAULT '0',
  `adv1` int(2) DEFAULT NULL,
  `adv2` int(2) DEFAULT NULL,
  `adv3` int(2) DEFAULT NULL,
  `adv4` int(2) DEFAULT NULL,
  `adv5` int(2) DEFAULT NULL,
  `adv6` int(2) DEFAULT NULL,
  `adv7` int(2) DEFAULT NULL,
  `adv8` int(2) DEFAULT NULL,
  `adv9` int(2) DEFAULT NULL,
  `adv10` int(2) DEFAULT NULL,
  `adv11` int(2) DEFAULT NULL,
  `P1` int(3) DEFAULT NULL,
  `P2` int(3) DEFAULT NULL,
  `P3` int(3) DEFAULT NULL,
  `OTA` int(3) DEFAULT NULL,
  `research1` tinytext,
  `research2` tinytext,
  `research3` tinytext,
  `research4` tinytext,
  PRIMARY KEY (`gameID`,`periodNum`,`hotel`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `strat_decisions`
--

LOCK TABLES `strat_decisions` WRITE;
/*!40000 ALTER TABLE `strat_decisions` DISABLE KEYS */;
INSERT INTO `strat_decisions` VALUES (3,1,50.00,48,2,5,11,0,0,0,0,0,0,0,0,1,1,0,90,NULL,'NULL','NULL','NULL'),(3,1,80.00,50,3,5,8,9,0,0,0,0,0,0,0,1,1,1,50,NULL,'NULL','NULL','NULL'),(3,1,56.00,51,2,5,11,0,0,0,0,0,0,0,0,1,0,2,65,NULL,'NULL','NULL','NULL'),(3,1,80.00,113,1,8,11,0,0,0,0,0,0,0,0,1,1,2,75,NULL,'NULL','NULL','NULL'),(3,1,50.00,119,1,5,7,0,0,0,0,0,0,0,0,1,2,0,75,NULL,'NULL','NULL','NULL'),(3,1,75.00,124,3,8,9,0,0,0,0,0,0,0,0,1,1,0,100,NULL,NULL,NULL,NULL),(3,1,45.00,131,4,6,9,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,1,55.00,114,5,0,0,0,0,0,0,0,0,0,0,2,0,3,10,'CPU Inn','Hotel name',NULL,NULL);
/*!40000 ALTER TABLE `strat_decisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student`
--

DROP TABLE IF EXISTS `student`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student` (
  `id` char(7) NOT NULL,
  `fname` tinytext NOT NULL,
  `lname` tinytext NOT NULL,
  `email` tinytext NOT NULL,
  `bot` tinyint(4) DEFAULT NULL,
  `hotel` int(11) DEFAULT NULL,
  `password` char(64) NOT NULL,
  `secQuestion` varchar(64) DEFAULT NULL,
  `secAnswer` char(64) DEFAULT NULL,
  `isActive` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `hotel` (`hotel`),
  CONSTRAINT `student_ibfk_1` FOREIGN KEY (`hotel`) REFERENCES `hotel` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student`
--

LOCK TABLES `student` WRITE;
/*!40000 ALTER TABLE `student` DISABLE KEYS */;
INSERT INTO `student` VALUES ('-1','JavierBot','AndrialBot','javierbot@marketsim.com',1,114,'21d3e136d5e6e09b1dd3470e58f0ac9272378f32fcb04301625528e6992ae7fe','what are you trying to do?','939bbf7d9bd4bd853c9f0183a62978a9705ff274c77931d4469d54064ae9f7bd',1),('-2','Android','18','bot@marketsim.com',1,115,'dae2d37c8fee89ddef6d2bdf47e9e653889c7a11eabc5c3ea9987f1ae3e79010','what are you trying to do?','515868769ea3b489d1ca261757246f7a0831e13e0a58f132253f78838bddd2d2',1),('-3','Comqaq','Computers','badpc@marketsim.com',1,116,'2931bed65b1ebe335149afcae1d3f08ff6d7afa6c526bdde78f3be4ebfa7e7e9','what are you trying to do?','bdb957485a50e580402a3091164e132df8000a47353df20599b3637e445b4abe',1),('-4','bot name','bot last name','bot@fiu.edu',1,117,'3e036c506ad669cd5e3634577ef95e8ae2dbf898d9e257afbe523fca713df57a','what are you trying to do?','4d735e788c36c1340cdc93656bf2ccb953637cc8f6da4fdf2731a7d67e21d83f',1),('-5','somebot','','bot@marketsim2.com',1,124,'4e05634c504f5ee85ef17c8a61b4e2dafd9a949fdcbcaa0943f717aff07b6fb8','what are you trying to do?','c4b2829866de61754ae052ae0be7b9f6b5ee4477100474d1adbc7b3e00dd76a4',1),('-6','bot','bot','bot@bot.com',1,125,'c717c345cb21b9c83933ab19ed62a0d33b115e6a8a51f0b717e239b7e3c01d27','what are you trying to do?','92cc57cb92d3279f5fe0edea06f3d0f7e9476f2f9ac0bf9b3f2fc62b34ad25cc',1),('1234512','John','simmons','simmons@account.com',0,115,'55831fe762e1cace48ac9000b2f345e751cabd329c5ba2f8a81799e71fbb240f','asdflkj','01771ab12b3a564fee40ade52dd8add500bf9f39295339767acf521ddad77acb',1),('1234567','John','seyer','seyer@account.com',0,46,'937ddd91ffb74604bfc5c2c46d3a8a0e5330287676c8b735e7bc53d099c2db93','What is your favorite color?','4729dad544e8c51144a00281c1b990ee90b778dbb3cad49e00313c28681bb84e',1),('1239875','robert','paulson','paulson@account.com',0,112,'a3c181dda81f4b325fa92dc85c824d654fe32eff995ce76ccbb45ea1e97f0305','where','2ced49a7f0ce3ea1a165edc42e2f4adad0e89aca8b5dabd58fb14204bc0f3e03',1),('1254125','mickel','simmons','ahd@dom.com',0,121,'013f9d193d61fa1c8c3f8bf17e87475ad63c5976867d482965014bf1b4a543fc','asdfas','8e7a3321453c970c87fc5d8e62c9226791397f5ab640963364de62d7bbbfdda8',1),('1254159','bobby','tomms','tomms@acc.com',0,51,'5806eba4f398e83daabbd1745c31daffc4fe457fa6da29ed7e9ea95f5e8358c7','where are you','0031f7794392d2a66db966890656162eec9272049345f20ddae373f1fda81c13',1),('1254199','mickeld','simmons','ahd@dom.com',0,121,'013f9d193d61fa1c8c3f8bf17e87475ad63c5976867d482965014bf1b4a543fc','asdfas','8e7a3321453c970c87fc5d8e62c9226791397f5ab640963364de62d7bbbfdda8',1),('1289105','Joe','Cilli','cillij@fiu.esu',0,NULL,'648f8dfdc79eeb413f47d04de15fefbb115d5f31a996cc3dc1660fe7f64322a3','Eyes?','eefa1e2448b5ddff1f84e8fabe71d8601ae284789cf7c8c698503161995ffca8',1),('1346521','Mary','Thompson','mtom999@fiu.edu',0,NULL,'a152a9c26a30fcaec20665a560af36810376f36b008cb14b3f7b58048489ba52','What is your favorite class?','404ed6c2895fad547cae5685eac6e4f144618ae81c16eb826cd25c76b6bbbc25',1),('1346952','john','smith','account2@email.com',0,50,'c67e81e54316a0255923700d85e771c9b411f33cc63b60f61e443481d264bf98','what color','60ab79f4c8c559ad1ead7ef6678f61009bc60eddbacf3bb3c2b6bfc2cb4b4bf3',1),('1542549','bobby','simmonz','aa@a45668.com',0,120,'3a51b16b12afd449ca0d804bebb049b76371c462340c4fa9ec4dbb153aab154e','where are you going','8278a6cfec00b3130131308fc5553607c22478bfde4c6d89d85a4531f5250b3c',1),('1548595','robert','smith','smith@account.com',0,NULL,'7893723f9f42dbeb121fddc8bca861b573a656a602f4f07d75dd85bf5057295c','Where are you','d77778710cd068929034b204b58d59bc88393e129a9b56aaf2dd4de51dafde4d',1),('1591915','Johnaton','weights','weights@fiu.edu',0,NULL,'82a6140b713ca5389e662b4780e677c414a549297ef4fe3fd254544d214e0790','What is your favorite class?','c60878054403d67d0760c2657fc98c1931610dba93ad652e689db1021e24eee2',1),('1591952','Mary','Townsen','townsent@fiu.edu',0,NULL,'bb09c589568fc2e0c5dacc7ad0f6f2f5b48489d915f17369c4bbd0837a06a987','What is your favorite class?','18d238c4825a0122ade54cdfd72666a51aa6fd9384dcaa58e83ce75d391dc833',1),('1591966','Mary','Brewer','Brewer@fiu.edu',0,46,'d1a625b5f965957511e3bf525fde900d935bac67c3ce8d2c4146124b5f5dd8a7','What is your favorite class?','662a1e87cd009b288a3feee22f9a44db37003eae986079ffea203cef9b47bb2a',1),('1651248','ricky','roberts','Ricke@roberts.com',0,NULL,'1253481','where am I','everywhere',1),('2255184','mike','hunter','hunter@fiu.edu',0,112,'b776bc2ad186c3435e08d043e20cb86e14fbefad12b999866f0eb6439af9255f','What is your favorite class?','5d091abfc9f524028a6b4dc4092ef447063e6dc084e322c4a180738ce0939896',1),('2255189','Barbie','Does','Deos@fiu.edu',0,113,'40d42458202792db697bb3aa85062b792769768f6315b2ba96b4d99b02fab3a9','What is your favorite class?','e63541ca6dfc91a5ac4b5101566552092b4c717884e5548307e9b824ca235aa6',1),('2654698','jeff','carman','jcarm012@fiu.edu',0,110,'c595ebfb69a73823c7152997aa1d4765a1e4d05d36c1e66ab9b4120691e8c8d8','where are you?','1bceebf4d569096772ac59f2c9d8f51d93405269d4b9ea438578651090829235',1),('2691915','Johnaton','weigzz','weighzz@fiu.edu',0,51,'61761d76b6a5498489cef68874a4e2be1dcc7043f9d78b3a460a2f792cf730f9','What is your favorite class?','04fcbaa0aec24fce626dafad941c101e6b49a67a5cb25499b8a8c06cc20623ca',1),('3578336','Javier','Andrial','jandr018@fiu.edu',0,114,'68be9fd8617a31791e09f654a4b875c78e5e104857e0e72b4dfc304b758c786f','what is your favorite color?','af759393212fd9f018122e53b5325e456cf2618f814acff495bfba41c5067510',1),('5125489','john','mickkkk','asdf@asdf.com',0,NULL,'c6bf7f873b30c1f0325989f4a2d262261809a219de3a23e64828879f58740462','asdf','363e0f099523816bfbeb299793a2e2f970fa98d571136005fc4cd4916db4af65',1),('5214589','mike','huntsman','mikes@account.com',0,120,'2b62c478d9539252bb1db3decb81f3c2e0af610a586e90d3160c720caf285f53','where are you','737c78bea122225e55529661136c670f3f85331e8475782c6b2ca21fd7d6806f',1),('5435756','maccount','myLastname','email@email.com',0,118,'fef239fea839602374f59ab700ee859b8a97f5b4d23b63698d3540aece831b60','my question','638ec97426dee8b8715bff4285dfc068a6612f39844c6599d81aae56b19a7a42',1),('6543598','mike','hunters','mike@mike.com',0,119,'0c9b78a7368be32bb0fce255c09eb0fc26737e362b506271f34d11d0d6df507f','what','4d7b84d2f391477d3ee0e43011c23d7ca37ae58fb49134f422a3993babb57a47',1),('6549513','mike','hunter','accoun@ung.com',0,46,'ad26c681e11d9fb62c4d9362a4bfdc87529866a1045aa74a05daf12fe230d467','What time','8cff6a1d2fe17d930b7bccc0dd50d17025e0aabd284ab4d1d6ee7e2c1b25791c',1),('7654321','Bob','Newhart','newhart@account.com',0,46,'16383011d8cea7a1ddc5570451b5cf394f8033c93ce78c6b2c5493dc080a1f8d','What car do you have?','7babd3e822d7f56fd555abeb525b404c55eb158091203fc20013e24b6a6351bc',1),('9876543','Robert','Paulson','paulson@account.com',0,112,'a3c181dda81f4b325fa92dc85c824d654fe32eff995ce76ccbb45ea1e97f0305','What time is it?','273451384c4c0c223a5a9dca8e08c65173a0c9ac4a72845c3a38d433acac7d47',1);
/*!40000 ALTER TABLE `student` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `student_comments`
--

DROP TABLE IF EXISTS `student_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `student_comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` int(11) NOT NULL DEFAULT '0',
  `period` int(4) NOT NULL DEFAULT '0',
  `hotel` int(11) DEFAULT NULL,
  `comments` text,
  `feedback` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `student_comments`
--

LOCK TABLES `student_comments` WRITE;
/*!40000 ALTER TABLE `student_comments` DISABLE KEYS */;
INSERT INTO `student_comments` VALUES (1,1,1,120,'Here are my comments','h'),(2,1,2,120,'Here are my comments',''),(8,4,1,114,'students comments here','Well done Javier! I\'m very Impressed with your work!'),(9,4,2,114,'End of period comment!','feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback feedback'),(18,3,1,51,'End of period explanation','This is my feedback for your comment'),(19,3,1,50,'End of period explanation',''),(20,1,1,46,'End of period explanation','Feedback'),(21,3,1,48,'End of period explanation','End of period feedback'),(22,1,1,118,'End of period explanation','Nice Job!'),(23,4,1,116,'End of period explanation',''),(24,1,1,112,'End of period explanation','wow very good!!'),(25,115,1,122,'End of period explanation',''),(26,115,1,123,'End of period explanation',''),(27,3,1,110,'end of period comment!','Great Job!');
/*!40000 ALTER TABLE `student_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `totalrooms`
--

DROP TABLE IF EXISTS `totalrooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `totalrooms` (
  `rooms` int(6) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `totalrooms`
--

LOCK TABLES `totalrooms` WRITE;
/*!40000 ALTER TABLE `totalrooms` DISABLE KEYS */;
INSERT INTO `totalrooms` VALUES (50000);
/*!40000 ALTER TABLE `totalrooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `ID` varchar(10) DEFAULT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `groupID` int(6) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `coureid` varchar(10) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `admin` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('123456','John','Smith',100000,'jsmith123@fiu.edu','12345','65487',0);
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

-- Dump completed on 2015-12-04 12:33:07
