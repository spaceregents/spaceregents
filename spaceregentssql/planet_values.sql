-- MySQL dump 10.2
--
-- Host: localhost    Database: spaceregents
-- ------------------------------------------------------
-- Server version	4.1.1-alpha-log

/*!40101 SET NAMES latin1*/;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=NO_AUTO_VALUE_ON_ZERO */;

--
-- Table structure for table `planet_values`
--

DROP TABLE IF EXISTS planet_values;
CREATE TABLE planet_values (
  type char(1) NOT NULL default '',
  max_poplevel int(11) default NULL,
  gain decimal(3,2) default NULL,
  PRIMARY KEY  (type)
) TYPE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `planet_values`
--


/*!40000 ALTER TABLE planet_values DISABLE KEYS */;
LOCK TABLES planet_values WRITE;
INSERT INTO planet_values VALUES ('O',15,0.02),('H',15,0.02),('M',15,0.02),('R',15,0.02),('I',15,0.02),('G',15,0.02),('D',15,0.02),('E',15,0.02),('A',15,0.02),('T',15,0.02);
UNLOCK TABLES;
/*!40000 ALTER TABLE planet_values ENABLE KEYS */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

