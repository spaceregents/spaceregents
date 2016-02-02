-- MySQL dump 10.2
--
-- Host: localhost    Database: spaceregents
---------------------------------------------------------
-- Server version	4.1.0-alpha-log

--
-- Table structure for table 'special_actions'
--

DROP TABLE IF EXISTS special_actions;
CREATE TABLE special_actions (
  action_id int(11) NOT NULL auto_increment,
  t_id int(11) NOT NULL default '0',
  name varchar(255) default 'no name',
  description varchar(255) default 'no description available',
  metal int(6) default '0',
  energy int(6) default '0',
  mopgas int(6) default '0',
  erkunum int(6) default '0',
  gortium int(6) default '0',
  susebloom int(6) default '0',
  type varchar(50) NOT NULL default 'unspecified',
  picture varchar(225) default NULL,
  PRIMARY KEY  (action_id)
) TYPE=MyISAM CHARSET=latin1;

--
-- Dumping data for table 'special_actions'
--

/*!40000 ALTER TABLE special_actions DISABLE KEYS */;
LOCK TABLES special_actions WRITE;
INSERT INTO special_actions VALUES (3,21,'Tachyon Scan','Allows to scan fleets to retrieve their ship signatures',0,100,0,0,0,0,'fleet','control_button_tachyon_scan.svgz'),(4,40,'Starborne Computer Trojan','Allows to scan shipsystems to retrieve their target, mission and tactic',0,200,0,200,0,0,'fleet','none.svgz');
UNLOCK TABLES;
/*!40000 ALTER TABLE special_actions ENABLE KEYS */;

