# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'covertopsupgrades'
#

DROP TABLE IF EXISTS covertopsupgrades;
CREATE TABLE covertopsupgrades (
  prod_id int(11) default NULL,
  value int(11) default NULL
) TYPE=MyISAM;

#
# Dumping data for table 'covertopsupgrades'
#

INSERT INTO covertopsupgrades VALUES (56,10);
INSERT INTO covertopsupgrades VALUES (57,20);
INSERT INTO covertopsupgrades VALUES (58,35);
INSERT INTO covertopsupgrades VALUES (59,50);

