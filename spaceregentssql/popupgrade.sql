# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'popupgrade'
#

DROP TABLE IF EXISTS popupgrade;
CREATE TABLE popupgrade (
  prod_id int(11) NOT NULL default '0',
  value int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table 'popupgrade'
#

INSERT INTO popupgrade VALUES (19,10);
INSERT INTO popupgrade VALUES (21,20);
INSERT INTO popupgrade VALUES (22,5);
INSERT INTO popupgrade VALUES (25,50);
INSERT INTO popupgrade VALUES (40,2);
INSERT INTO popupgrade VALUES (43,4);
INSERT INTO popupgrade VALUES (47,30);
INSERT INTO popupgrade VALUES (11,2);

