# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'skins'
#

DROP TABLE IF EXISTS skins;
CREATE TABLE skins (
  name varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'skins'
#

INSERT INTO skins VALUES ('metal_blue',1);

