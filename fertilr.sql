-- MySQL dump 10.13  Distrib 5.5.40, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: ksend
-- ------------------------------------------------------
-- Server version	5.5.40-0+wheezy1

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
-- Table structure for table `Doswiadczenia`
--

DROP TABLE IF EXISTS `Doswiadczenia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Doswiadczenia` (
  `id_doswiadczenie` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `data_rozpoczecia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_zakonczenia` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_doswiadczenie`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Doswiadczenia`
--

LOCK TABLES `Doswiadczenia` WRITE;
/*!40000 ALTER TABLE `Doswiadczenia` DISABLE KEYS */;
/*!40000 ALTER TABLE `Doswiadczenia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Pomiary`
--

DROP TABLE IF EXISTS `Pomiary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pomiary` (
  `id_pomiar` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_laborant` int(11) unsigned NOT NULL,
  `id_obszar` int(11) unsigned NOT NULL,
  `pomiar` double DEFAULT NULL,
  `data_pomiaru` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pomiar`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Pomiary`
--

LOCK TABLES `Pomiary` WRITE;
/*!40000 ALTER TABLE `Pomiary` DISABLE KEYS */;
INSERT INTO `Pomiary` VALUES (1,1,1,13.5,'2014-12-25 18:10:23'),(2,2,4,15.9,'2014-12-25 18:16:44');
/*!40000 ALTER TABLE `Pomiary` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Uzytkownicy`
--

DROP TABLE IF EXISTS `Uzytkownicy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Uzytkownicy` (
  `id_uzytkownik` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `login` varchar(128) NOT NULL DEFAULT '',
  `haslo` varchar(128) NOT NULL DEFAULT '',
  `imie` varchar(128) DEFAULT NULL,
  `nazwisko` varchar(128) DEFAULT NULL,
  `admin` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id_uzytkownik`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Uzytkownicy`
--

LOCK TABLES `Uzytkownicy` WRITE;
/*!40000 ALTER TABLE `Uzytkownicy` DISABLE KEYS */;
INSERT INTO `Uzytkownicy` VALUES (1,'admin','21232f297a57a5a743894a0e4a801fc3','Krzysztof','Sendor',1);
/*!40000 ALTER TABLE `Uzytkownicy` ENABLE KEYS */;
UNLOCK TABLES;