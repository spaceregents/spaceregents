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
-- Table structure for table `scanradius`
--

DROP TABLE IF EXISTS scanradius;
CREATE TABLE scanradius (
  prod_id int(11) default NULL,
  radius int(11) default NULL
) TYPE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `scanradius`
--

INSERT INTO scanradius VALUES (10,250);
INSERT INTO scanradius VALUES (36,400);
INSERT INTO scanradius VALUES (57,600);
INSERT INTO scanradius VALUES (35,200);
INSERT INTO scanradius VALUES (3,100);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

