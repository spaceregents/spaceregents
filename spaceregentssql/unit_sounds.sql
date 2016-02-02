-- MySQL dump 10.2
--
-- Host: localhost    Database: spaceregents
---------------------------------------------------------
-- Server version	4.1.0-alpha-log

--
-- Table structure for table 'unit_sounds'
--

DROP TABLE IF EXISTS unit_sounds;
CREATE TABLE unit_sounds (
  prod_id int(11) NOT NULL default '0',
  sound_file varchar(255) default NULL,
  type varchar(20) default 'report'
) TYPE=MyISAM CHARSET=latin1;

--
-- Dumping data for table 'unit_sounds'
--

/*!40000 ALTER TABLE unit_sounds DISABLE KEYS */;
LOCK TABLES unit_sounds WRITE;
INSERT INTO unit_sounds VALUES (2,'Scout_report.mp3','report'),(3,'Probe_report.mp3','report'),(6,'Interceptor_report.mp3','report'),(9,'Transporters_report.mp3','report'),(12,'Colony_ship_report.mp3','report'),(14,'B-5056_Bomber_report.mp3','report'),(16,'Peacekeeper_Corvette_report.mp3','report'),(18,'Draconis_Destroyer_report.mp3','report'),(24,'N-2103_Bomber_report.mp3','report'),(28,'Hijacker_report.mp3','report'),(29,'Freezer_report.mp3','report'),(35,'Dreamcatcher_Frigatte_report.mp3','report'),(37,'Beholder_report.mp3','report'),(39,'Octopus_Corvette_report.mp3','report'),(45,'Hydra_report.mp3','report'),(48,'Behemoth_report.mp3','report'),(52,'Wrath_report.mp3','report'),(62,'Orbital_Colony_Center_Unit_report.mp3','report'),(64,'Gunship_report.mp3','report'),(2,'Scout_confirm.mp3','confirm'),(3,'Probe_confirm.mp3','confirm'),(6,'Interceptor_confirm.mp3','confirm'),(9,'Transporters_confirm.mp3','confirm'),(12,'Colony_ship_confirm.mp3','confirm'),(14,'B-5056_Bomber_confirm.mp3','confirm'),(16,'Peacekeeper_Corvette_confirm.mp3','confirm'),(18,'Draconis_Destroyer_confirm.mp3','confirm'),(24,'N-2103_Bomber_confirm.mp3','confirm'),(28,'Hijacker_confirm.mp3','confirm'),(29,'Freezer_confirm.mp3','confirm'),(35,'Dreamcatcher_Frigatte_confirm.mp3','confirm'),(37,'Beholder_confirm.mp3','confirm'),(39,'Octopus_Corvette_confirm.mp3','confirm'),(45,'Hydra_confirm.mp3','confirm'),(48,'Behemoth_confirm.mp3','confirm'),(52,'Wrath_confirm.mp3','confirm'),(62,'Orbital_Colony_Center_Unit_confirm.mp3','confirm'),(64,'Gunship_confirm.mp3','confirm');
UNLOCK TABLES;
/*!40000 ALTER TABLE unit_sounds ENABLE KEYS */;

