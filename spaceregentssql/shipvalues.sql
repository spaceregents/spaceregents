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
-- Table structure for table `shipvalues`
--

DROP TABLE IF EXISTS shipvalues;
CREATE TABLE shipvalues (
  prod_id int(11) NOT NULL default '0',
  initiative int(11) default NULL,
  agility int(11) default NULL,
  warpreload int(11) default NULL,
  hull int(11) default NULL,
  tonnage int(11) default NULL,
  weaponpower int(11) default NULL,
  shield int(11) default NULL,
  ecm int(11) default NULL,
  target1 char(1) default NULL,
  sensor int(11) default NULL,
  weaponskill int(11) default NULL,
  special char(1) default '',
  armor int(11) default NULL,
  num_attacks int(11) NOT NULL default '0',
  PRIMARY KEY  (prod_id)
) TYPE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `shipvalues`
--

INSERT INTO shipvalues VALUES (2,80,80,1,13,50,10,0,0,'L',10,60,'',7,1);
INSERT INTO shipvalues VALUES (3,10,1,1,6,25,1,0,0,'L',50,1,'',3,0);
INSERT INTO shipvalues VALUES (6,75,70,3,25,100,25,0,0,'L',15,50,'',13,1);
INSERT INTO shipvalues VALUES (9,10,50,4,25,100,10,5,5,'L',20,50,'',13,2);
INSERT INTO shipvalues VALUES (12,10,20,10,500,2000,10,50,0,'L',20,5,'',267,2);
INSERT INTO shipvalues VALUES (14,55,65,4,31,125,50,3,0,'H',40,25,'B',17,1);
INSERT INTO shipvalues VALUES (16,50,45,4,50,200,30,15,10,'L',20,30,'E',27,2);
INSERT INTO shipvalues VALUES (18,45,45,10,408,1700,120,150,10,'H',50,50,'',217,10);
INSERT INTO shipvalues VALUES (24,45,50,4,71,300,75,7,0,'H',45,20,'B',38,1);
INSERT INTO shipvalues VALUES (28,5,50,5,208,1000,50,20,15,'M',20,50,'R',108,1);
INSERT INTO shipvalues VALUES (29,52,50,5,158,700,25,10,10,'L',30,35,'',83,2);
INSERT INTO shipvalues VALUES (35,40,45,5,133,600,25,10,10,'L',70,25,'S',70,3);
INSERT INTO shipvalues VALUES (39,40,35,5,142,600,25,15,10,'L',50,20,'N',75,4);
INSERT INTO shipvalues VALUES (37,40,40,10,629,2850,125,220,20,'M',75,40,'',330,20);
INSERT INTO shipvalues VALUES (45,45,55,5,250,1000,70,10,10,'M',50,35,'',133,4);
INSERT INTO shipvalues VALUES (48,35,10,14,3333,15000,200,50,30,'H',50,40,'B',1750,30);
INSERT INTO shipvalues VALUES (52,50,70,10,833,3500,70,45,0,'L',10,80,'C',442,15);
INSERT INTO shipvalues VALUES (64,50,55,4,75,300,25,5,5,'L',15,45,'',40,4);
INSERT INTO shipvalues VALUES (1,1,1,1,125,1,0,0,0,'L',10,0,'',67,0);
INSERT INTO shipvalues VALUES (4,1,1,1,125,1,0,0,0,'L',0,0,'',67,0);
INSERT INTO shipvalues VALUES (5,1,1,1,63,1,0,0,0,'L',0,0,'',33,0);
INSERT INTO shipvalues VALUES (8,21,22,23,24,25,0,0,28,'L',29,20,'',10,1);
INSERT INTO shipvalues VALUES (10,50,1,1,750,1,15,50,0,'L',50,10,'',400,10);
INSERT INTO shipvalues VALUES (11,1,1,1,625,1,0,0,0,'L',0,0,'',333,0);
INSERT INTO shipvalues VALUES (13,60,1,1,375,1,50,100,0,'L',75,20,'',200,20);
INSERT INTO shipvalues VALUES (15,1,1,1,333,1,0,1000,0,'L',0,0,'H',175,0);
INSERT INTO shipvalues VALUES (17,1,1,1,250,1,0,50,0,'L',0,0,'',133,0);
INSERT INTO shipvalues VALUES (19,1,1,1,50,1,0,0,0,'L',0,0,'',27,0);
INSERT INTO shipvalues VALUES (21,1,1,1,63,1,0,0,0,'L',0,0,'',33,0);
INSERT INTO shipvalues VALUES (22,1,1,1,25,1,0,0,0,'L',0,0,'',13,0);
INSERT INTO shipvalues VALUES (23,1,1,1,250,1,0,0,0,'L',0,0,'',133,0);
INSERT INTO shipvalues VALUES (25,1,1,1,500,1,0,0,0,'L',0,0,'',267,0);
INSERT INTO shipvalues VALUES (26,1,1,1,500,1,0,0,0,'L',0,0,'',267,0);
INSERT INTO shipvalues VALUES (27,55,1,1,583,1,100,120,0,'M',80,40,'',308,15);
INSERT INTO shipvalues VALUES (30,1,1,1,1000,1,0,0,0,'L',0,0,'',533,0);
INSERT INTO shipvalues VALUES (31,1,1,1,583,1,0,0,0,'L',0,0,'',308,0);
INSERT INTO shipvalues VALUES (32,1,1,1,1000,1,0,0,0,'L',0,0,'',533,0);
INSERT INTO shipvalues VALUES (33,1,1,1,500,1,0,0,0,'L',0,0,'',267,0);
INSERT INTO shipvalues VALUES (34,1,1,1,625,1,0,0,0,'L',0,0,'',333,0);
INSERT INTO shipvalues VALUES (36,1,1,1,625,1,0,0,0,'L',99,0,'',333,0);
INSERT INTO shipvalues VALUES (38,1,1,1,113,1,0,0,0,'L',0,0,'N',60,0);
INSERT INTO shipvalues VALUES (40,1,1,1,1500,1,0,0,0,'L',0,0,'',800,0);
INSERT INTO shipvalues VALUES (42,1,1,1,250,1,0,0,0,'L',0,0,'',133,0);
INSERT INTO shipvalues VALUES (43,1,1,1,75,1,0,0,0,'L',0,0,'',40,0);
INSERT INTO shipvalues VALUES (46,1,1,1,258,1,0,0,0,'L',0,0,'',135,0);
INSERT INTO shipvalues VALUES (47,1,1,1,500,1,0,0,0,'L',0,0,'',267,0);
INSERT INTO shipvalues VALUES (49,80,1,1,1083,1,150,200,0,'H',90,50,'',575,10);
INSERT INTO shipvalues VALUES (51,1,1,1,5167,1,0,0,0,'L',0,0,'',2750,0);
INSERT INTO shipvalues VALUES (53,1,1,1,25,1,0,0,0,'L',0,0,'',13,0);
INSERT INTO shipvalues VALUES (56,1,1,1,100,1,0,0,0,'L',0,0,'',53,0);
INSERT INTO shipvalues VALUES (57,1,1,1,1875,1,0,0,0,'L',99,0,'',1000,0);
INSERT INTO shipvalues VALUES (58,1,1,1,250,1,0,0,0,'L',0,0,'',133,0);
INSERT INTO shipvalues VALUES (59,1,1,1,625,1,0,0,0,'L',0,0,'',333,0);
INSERT INTO shipvalues VALUES (60,1,1,1,100,1,0,0,0,'L',50,0,'',53,0);
INSERT INTO shipvalues VALUES (61,1,1,1,4167,1,0,200,0,'L',0,0,'',2167,0);
INSERT INTO shipvalues VALUES (63,1,1,1,125,1,0,0,0,'L',0,0,'',67,0);
INSERT INTO shipvalues VALUES (65,1,1,1,125,1,0,0,0,'L',0,0,'0',67,0);
INSERT INTO shipvalues VALUES (67,1,1,1,708,1,0,100,0,'L',0,0,'0',375,0);
INSERT INTO shipvalues VALUES (68,1,1,1,208,1,0,10,0,'L',0,0,'0',108,0);
INSERT INTO shipvalues VALUES (69,1,1,1,96,1,0,10,0,'L',0,0,'0',50,0);
INSERT INTO shipvalues VALUES (70,1,1,1,417,1,0,0,0,'L',0,0,'',217,0);
INSERT INTO shipvalues VALUES (71,80,75,3,64,200,40,5,5,'L',40,70,'',22,1);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

