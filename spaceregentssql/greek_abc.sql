# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'greek_abc'
#

DROP TABLE IF EXISTS greek_abc;
CREATE TABLE greek_abc (
  name varchar(255) NOT NULL default '',
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  KEY name (name)
) TYPE=MyISAM;

#
# Dumping data for table 'greek_abc'
#

INSERT INTO greek_abc VALUES ('alpha',1);
INSERT INTO greek_abc VALUES ('beta',2);
INSERT INTO greek_abc VALUES ('gamma',3);
INSERT INTO greek_abc VALUES ('delta',4);
INSERT INTO greek_abc VALUES ('epsilon',5);
INSERT INTO greek_abc VALUES ('nu',6);
INSERT INTO greek_abc VALUES ('mu',7);
INSERT INTO greek_abc VALUES ('eta',8);
INSERT INTO greek_abc VALUES ('iota',9);
INSERT INTO greek_abc VALUES ('pi',10);
INSERT INTO greek_abc VALUES ('upsilon',11);
INSERT INTO greek_abc VALUES ('lambda',12);
INSERT INTO greek_abc VALUES ('omicron',13);
INSERT INTO greek_abc VALUES ('sigma',14);
INSERT INTO greek_abc VALUES ('rho',15);
INSERT INTO greek_abc VALUES ('omega',16);
INSERT INTO greek_abc VALUES ('xi',17);
INSERT INTO greek_abc VALUES ('chi',18);
INSERT INTO greek_abc VALUES ('phi',19);
INSERT INTO greek_abc VALUES ('kappa',20);
INSERT INTO greek_abc VALUES ('zeta',21);
INSERT INTO greek_abc VALUES ('tau',22);
INSERT INTO greek_abc VALUES ('psi',23);
INSERT INTO greek_abc VALUES ('theta',24);

