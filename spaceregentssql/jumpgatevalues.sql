# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'jumpgatevalues'
#

DROP TABLE IF EXISTS jumpgatevalues;
CREATE TABLE jumpgatevalues (
  prod_id int(11) default NULL,
  tonnage int(11) default NULL,
  reload int(11) NOT NULL default '0'
) TYPE=MyISAM;

#
# Dumping data for table 'jumpgatevalues'
#

INSERT INTO jumpgatevalues VALUES (61,5000,100);

