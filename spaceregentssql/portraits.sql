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
-- Table structure for table `portraits`
--

DROP TABLE IF EXISTS portraits;
CREATE TABLE portraits (
  pic varchar(255) default NULL,
  gender char(1) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `portraits`
--

INSERT INTO portraits VALUES ('p1.jpg','m',1);
INSERT INTO portraits VALUES ('p2.jpg','w',2);
INSERT INTO portraits VALUES ('p3.jpg','m',3);
INSERT INTO portraits VALUES ('p4.jpg','m',4);
INSERT INTO portraits VALUES ('p5.jpg','m',5);
INSERT INTO portraits VALUES ('p6.jpg','w',6);
INSERT INTO portraits VALUES ('p7.jpg','m',7);
INSERT INTO portraits VALUES ('p8.jpg','m',8);
INSERT INTO portraits VALUES ('p9.jpg','m',9);
INSERT INTO portraits VALUES ('p10.jpg','m',10);
INSERT INTO portraits VALUES ('p11.jpg','m',11);
INSERT INTO portraits VALUES ('p12.jpg','m',12);
INSERT INTO portraits VALUES ('p13.jpg','m',13);
INSERT INTO portraits VALUES ('p14.jpg','w',14);
INSERT INTO portraits VALUES ('p15.jpg','w',15);
INSERT INTO portraits VALUES ('p16.jpg','m',16);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

