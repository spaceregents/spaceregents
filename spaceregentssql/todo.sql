-- MySQL dump 8.21
--
-- Host: localhost    Database: todo
---------------------------------------------------------
-- Server version	3.23.49-log

--
-- Table structure for table 'guy'
--

CREATE TABLE guy (
  name char(50) default 'No Name',
  developer tinyint(1) default '0',
  id int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'guy'
--



--
-- Table structure for table 'items'
--

CREATE TABLE items (
  id int(11) NOT NULL auto_increment,
  priority int(3) default '3',
  time varchar(100) default NULL,
  subject varchar(255) default 'No Subject',
  description blob,
  status smallint(6) default '1',
  guy int(11) default NULL,
  typ int(11) default '1',
  added_by int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'items'
--



--
-- Table structure for table 'status'
--

CREATE TABLE status (
  id int(11) NOT NULL auto_increment,
  name varchar(50) default NULL,
  farbe varchar(50) default 'black',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'status'
--


INSERT INTO status VALUES (1,'unbearbeitet','red');
INSERT INTO status VALUES (2,'in bearbeitung','blue');
INSERT INTO status VALUES (3,'fertig','lime');

--
-- Table structure for table 'typ'
--

CREATE TABLE typ (
  id int(11) NOT NULL auto_increment,
  name varchar(50) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'typ'
--


INSERT INTO typ VALUES (1,'nicht spezifiziert');
INSERT INTO typ VALUES (2,'Feature');
INSERT INTO typ VALUES (3,'Bug');
INSERT INTO typ VALUES (4,'Graphik');
INSERT INTO typ VALUES (5,'Portal');
INSERT INTO typ VALUES (6,'Manual');

