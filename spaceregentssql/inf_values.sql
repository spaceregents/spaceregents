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
-- Table structure for table `inf_values`
--

CREATE TABLE inf_values (
  prod_id int(11) default NULL,
  armour int(11) default NULL,
  attack int(11) default NULL,
  defense int(11) default NULL,
  storage int(11) default NULL,
  initiative int(11) default NULL
) TYPE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `inf_values`
--

INSERT INTO inf_values VALUES (7,1,2,1,1,30);
INSERT INTO inf_values VALUES (20,2,4,2,1,40);
INSERT INTO inf_values VALUES (41,8,3,1,2,25);
INSERT INTO inf_values VALUES (44,16,6,2,4,20);
INSERT INTO inf_values VALUES (50,1,4,4,1,60);
INSERT INTO inf_values VALUES (54,12,5,4,5,35);
INSERT INTO inf_values VALUES (55,30,10,8,10,10);
INSERT INTO inf_values VALUES (72,4,4,3,1,45);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

