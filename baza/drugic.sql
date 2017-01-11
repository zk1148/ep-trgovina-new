-- MySQL dump 10.13  Distrib 5.7.16, for Linux (x86_64)
--
-- Host: localhost    Database: eptrgovinatk
-- ------------------------------------------------------
-- Server version	5.7.16-0ubuntu0.16.04.1

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
-- Table structure for table `Izdelek`
--

DROP TABLE IF EXISTS `Izdelek`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Izdelek` (
  `idIzdelek` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) DEFAULT NULL,
  `opis` varchar(1024) DEFAULT NULL,
  `cena` double DEFAULT NULL,
  `aktiven` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`idIzdelek`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Izdelek`
--

LOCK TABLES `Izdelek` WRITE;
/*!40000 ALTER TABLE `Izdelek` DISABLE KEYS */;
INSERT INTO `Izdelek` VALUES (1,'Kolebnica','Najboljsa kolebnica na svetu',9.65,1),(2,'Sobno kolouuuuuuuuuu','aaffasNajnovejse sobno kolouuuuu',184.677,1),(3,'Blazina','Zelo mehka blazina za telovadbo, modra',15.8,0),(4,'Fitnes klop','Večnamenska klop za telovadbo',145.5,0),(5,'Uteži','Zelo težke uteži (40 kg)',34.76,0),(8,NULL,NULL,NULL,0),(9,'Kolo','Kolo za gozdne poti',45.7,1),(10,'www','qwerertrt',55,1),(11,'eeee','srgeth',52,1),(12,'fgdfgdfg','sfaesfaef',56,0);
/*!40000 ALTER TABLE `Izdelek` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Log`
--

DROP TABLE IF EXISTS `Log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `uporabnik_id` int(11) DEFAULT NULL,
  `cas` datetime DEFAULT NULL,
  `komentar` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`idLog`),
  KEY `fk_Log_1_idx` (`uporabnik_id`),
  CONSTRAINT `fk_Log_1` FOREIGN KEY (`uporabnik_id`) REFERENCES `Uporabnik` (`idUporabnik`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Log`
--

LOCK TABLES `Log` WRITE;
/*!40000 ALTER TABLE `Log` DISABLE KEYS */;
INSERT INTO `Log` VALUES (5,27,'2017-01-10 20:41:08',NULL),(6,28,'2017-01-10 20:45:14',NULL),(7,29,'2017-01-10 20:48:56',NULL),(8,29,'2017-01-10 23:01:01','10'),(9,29,'2017-01-10 23:01:52','Dodan nov izdelek 11'),(10,29,'2017-01-10 23:05:55','Posodobljen izdelek z id-jem: 2'),(11,29,'2017-01-10 23:06:12','Posodobljen izdelek z id-jem: 2'),(12,29,'2017-01-10 23:06:24','Posodobljen izdelek z id-jem: 2'),(13,29,'2017-01-10 23:17:55','Posodobljen izdelek z id-jem: 2'),(14,29,'2017-01-10 23:22:38','Prijava administratorja.'),(15,29,'2017-01-10 23:39:10','Prijava administratorja.'),(16,29,'2017-01-11 10:14:20','Prijava administratorja.'),(17,29,'2017-01-11 16:33:39','Prijava administratorja.'),(18,29,'2017-01-11 17:26:34','Prijava administratorja.'),(19,29,'2017-01-11 17:27:33','Dodan nov izdelek z id-jem: 12'),(20,29,'2017-01-11 17:27:51','Posodobljen izdelek z id-jem: 12'),(21,29,'2017-01-11 18:34:23','Prijava administratorja.');
/*!40000 ALTER TABLE `Log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Narocilo`
--

DROP TABLE IF EXISTS `Narocilo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Narocilo` (
  `idNarocilo` int(11) NOT NULL AUTO_INCREMENT,
  `znesek` double DEFAULT NULL,
  `status_id` int(11) DEFAULT NULL,
  `datum_oddaje` datetime DEFAULT NULL,
  `datum_potrditve` datetime DEFAULT NULL,
  `stranka_id` int(11) DEFAULT NULL,
  `prodajalec_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`idNarocilo`),
  KEY `fk_Narocilo_1_idx` (`stranka_id`),
  KEY `fk_Narocilo_2_idx` (`prodajalec_id`),
  CONSTRAINT `fk_Narocilo_1` FOREIGN KEY (`stranka_id`) REFERENCES `Uporabnik` (`idUporabnik`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Narocilo_2` FOREIGN KEY (`prodajalec_id`) REFERENCES `Uporabnik` (`idUporabnik`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Narocilo`
--

LOCK TABLES `Narocilo` WRITE;
/*!40000 ALTER TABLE `Narocilo` DISABLE KEYS */;
/*!40000 ALTER TABLE `Narocilo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Ocena`
--

DROP TABLE IF EXISTS `Ocena`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ocena` (
  `uporabnik_id` int(11) NOT NULL,
  `izdelek_id` int(11) NOT NULL,
  `ocena` int(11) DEFAULT NULL,
  PRIMARY KEY (`uporabnik_id`,`izdelek_id`),
  KEY `fk_Ocena_1_idx` (`uporabnik_id`),
  KEY `fk_Ocena_2_idx` (`izdelek_id`),
  CONSTRAINT `fk_Ocena_1` FOREIGN KEY (`uporabnik_id`) REFERENCES `Uporabnik` (`idUporabnik`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Ocena_2` FOREIGN KEY (`izdelek_id`) REFERENCES `Izdelek` (`idIzdelek`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ocena`
--

LOCK TABLES `Ocena` WRITE;
/*!40000 ALTER TABLE `Ocena` DISABLE KEYS */;
INSERT INTO `Ocena` VALUES (33,1,3);
/*!40000 ALTER TABLE `Ocena` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Postavka`
--

DROP TABLE IF EXISTS `Postavka`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Postavka` (
  `narocilo_id` int(11) NOT NULL,
  `izdelek_id` int(11) NOT NULL,
  `kolicina` int(11) DEFAULT NULL,
  PRIMARY KEY (`narocilo_id`,`izdelek_id`),
  KEY `fk_Postavka_2_idx` (`izdelek_id`),
  CONSTRAINT `fk_Postavka_1` FOREIGN KEY (`narocilo_id`) REFERENCES `Narocilo` (`idNarocilo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_Postavka_2` FOREIGN KEY (`izdelek_id`) REFERENCES `Izdelek` (`idIzdelek`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Postavka`
--

LOCK TABLES `Postavka` WRITE;
/*!40000 ALTER TABLE `Postavka` DISABLE KEYS */;
/*!40000 ALTER TABLE `Postavka` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Slika`
--

DROP TABLE IF EXISTS `Slika`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Slika` (
  `idSlika` int(11) NOT NULL AUTO_INCREMENT,
  `izdelek_id` int(11) NOT NULL,
  `slika` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`idSlika`),
  KEY `fk_Slika_1_idx` (`izdelek_id`),
  CONSTRAINT `fk_Slika_1` FOREIGN KEY (`izdelek_id`) REFERENCES `Izdelek` (`idIzdelek`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Slika`
--

LOCK TABLES `Slika` WRITE;
/*!40000 ALTER TABLE `Slika` DISABLE KEYS */;
INSERT INTO `Slika` VALUES (1,1,'blazina.jpg');
/*!40000 ALTER TABLE `Slika` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Uporabnik`
--

DROP TABLE IF EXISTS `Uporabnik`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Uporabnik` (
  `idUporabnik` int(11) NOT NULL AUTO_INCREMENT,
  `ime` varchar(45) DEFAULT NULL,
  `priimek` varchar(45) DEFAULT NULL,
  `email` varchar(45) DEFAULT NULL,
  `geslo` varchar(1024) DEFAULT NULL,
  `telefon` varchar(45) DEFAULT NULL,
  `naslov` varchar(45) DEFAULT NULL,
  `posta` varchar(45) DEFAULT NULL,
  `vloga_id` int(11) DEFAULT NULL,
  `aktiven` tinyint(1) DEFAULT NULL,
  `aktivacija_hash` varchar(1024) DEFAULT NULL,
  `certifikat_id` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`idUporabnik`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Uporabnik`
--

LOCK TABLES `Uporabnik` WRITE;
/*!40000 ALTER TABLE `Uporabnik` DISABLE KEYS */;
INSERT INTO `Uporabnik` VALUES (27,'prodajalec1','prodajalec1','prodajalec1@3xkca.si','$2y$10$w1F4EkJkt9coW4zc9oW0W.zzymd7PsB9a6N2dAz/rO4DQgKYg2mb.','','','',2,1,'',''),(28,'prodajalec2','prodajalec2','prodajalec2@3xkca.si','$2y$10$biem/ulbJ3Bh7MTWO1wqDu161VaXGxov9e2LgEW14SM1F.wv4B8sm','','','',2,1,'',''),(29,'administrator','administrator','administrator@3xkca.si','$2y$10$o44xV2ty5xuUEInNgK9MZOw9lvvphNjCk009V4m6g2mjFXH8ikzZi','','','',1,1,'',''),(30,'test','test','nkkdad@sasjidijad','$2y$10$pEWGwx/.fGN62hlBdAzr3eX.VvTGTt1P2.dZVDpF6GUnGN5m4mzR6','070 986 867','hehejej','Otočec',3,0,'$2y$10$l9PVFIsZF7yXC9RtrpbZROCO..bRpyX6WpxFVx95mDOkoN4aAOXRq',''),(31,'sdgdg','sdfsdfsd','der@gef','$2y$10$lSDa8TB5E/y5N4D6pFtTs.DnZx3BlrWyoUnyYvYA7gQCCpiQf0loy','070 987 869','erete','srterte',3,0,'$2y$10$Ky9mMB4IDdkevWwvlZMWa.oDkxfURBWiE3/8N4Qw5ST4c9G/S7Di2',''),(32,'ertert','erterer','efef@sfsfd','$2y$10$Zho96PHoR1GlPu0Kg1gFseOhDhnh3dw7QLxUmLCJ5Pxp3DZWyCTcW','080 097 867','efef','erfef',3,0,'$2y$10$YLh9s2Bra6vDX3crUL1YqeUCRahPagwiB3s9IDLqvJGJ67PN2rjSO',''),(33,'test','test','test@test.si','$2y$10$yc/fc21A9Bsf0AzJKFiEy.MCkdXadjnTyM6jRc.oH1eE7VsjY66xe','090 987 987','test','test',3,1,'$2y$10$QQMoy2554C.2vUmULUJmEeAqyZg8huNggE482bpF9zG.qA9vI.lQq','');
/*!40000 ALTER TABLE `Uporabnik` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-01-11 19:24:58
