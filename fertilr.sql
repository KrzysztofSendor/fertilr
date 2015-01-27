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
  `id_doswiadczenia` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(128) NOT NULL,
  `data_rozpoczecia` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `data_zakonczenia` timestamp NULL DEFAULT NULL,
  `id_pola` int(11) NOT NULL,
  PRIMARY KEY (`id_doswiadczenia`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Doswiadczenia_Nawozy`
--

DROP TABLE IF EXISTS `Doswiadczenia_Nawozy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Doswiadczenia_Nawozy` (
  `id_doswiadczenia_nawozy` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_doswiadczenia` int(11) NOT NULL,
  `id_nawozu` int(11) NOT NULL,
  PRIMARY KEY (`id_doswiadczenia_nawozy`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Nawozy`
--

DROP TABLE IF EXISTS `Nawozy`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Nawozy` (
  `id_nawozu` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_nawozu`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Obszary`
--

DROP TABLE IF EXISTS `Obszary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Obszary` (
  `id_obszaru` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `rozmiar` float NOT NULL,
  `id_doswiadczenia` int(11) NOT NULL,
  `id_rosliny` int(11) NOT NULL,
  PRIMARY KEY (`id_obszaru`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Pola`
--

DROP TABLE IF EXISTS `Pola`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pola` (
  `id_pola` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(128) NOT NULL DEFAULT '',
  `rozmiar` float NOT NULL,
  PRIMARY KEY (`id_pola`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Pomiary`
--

DROP TABLE IF EXISTS `Pomiary`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Pomiary` (
  `id_pomiaru` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `id_obszaru` int(11) unsigned NOT NULL,
  `id_uzytkownika` int(11) unsigned NOT NULL,
  `pomiar` int(11) unsigned NOT NULL,
  `data_pomiaru` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_pomiaru`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `Rosliny`
--

DROP TABLE IF EXISTS `Rosliny`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rosliny` (
  `id_rosliny` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nazwa` varchar(128) NOT NULL DEFAULT '',
  PRIMARY KEY (`id_rosliny`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-01-27 14:54:23
