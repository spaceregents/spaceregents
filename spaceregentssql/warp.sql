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
-- Table structure for table `warp`
--

DROP TABLE IF EXISTS warp;
CREATE TABLE warp (
  range int(11) default NULL,
  tid int(11) default NULL
) TYPE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `warp`
--

INSERT INTO warp VALUES (300,12);
INSERT INTO warp VALUES (400,19);
INSERT INTO warp VALUES (600,62);
INSERT INTO warp VALUES (500,32);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

