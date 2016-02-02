# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'inf_transporters'
#

DROP TABLE IF EXISTS inf_transporters;
CREATE TABLE inf_transporters (
  prod_id int(11) default NULL,
  storage int(11) default NULL
) TYPE=MyISAM;

#
# Dumping data for table 'inf_transporters'
#

INSERT INTO inf_transporters VALUES (9,300);

