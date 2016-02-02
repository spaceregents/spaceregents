# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'covertopsmissions'
#

DROP TABLE IF EXISTS covertopsmissions;
CREATE TABLE covertopsmissions (
  descr blob,
  count int(11) default NULL,
  metal int(11) default NULL,
  energy int(11) default NULL,
  mopgas int(11) default NULL,
  erkunum int(11) default NULL,
  gortium int(11) default NULL,
  susebloom int(11) default NULL,
  depend int(11) default NULL,
  resspend char(1) default NULL,
  targettype char(1) default NULL,
  missiontype char(1) default NULL,
  techdepend int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  time int(11) default NULL,
  chance int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table 'covertopsmissions'
#

INSERT INTO covertopsmissions VALUES ('Steal ships',1000,800,800,0,0,0,0,0,'O','I','S',0,1,10,15);
INSERT INTO covertopsmissions VALUES ('Sabotage Building',500,400,500,0,0,0,0,0,'O','I','B',0,2,10,20);
INSERT INTO covertopsmissions VALUES ('Sabotage Fleet',500,500,500,100,0,0,0,0,'O','I','F',0,3,10,15);
INSERT INTO covertopsmissions VALUES ('Hack News Network',500,400,1000,0,100,0,0,0,'O','I','N',0,4,5,30);
INSERT INTO covertopsmissions VALUES ('Hack Military News Network',1000,600,1400,0,100,0,0,0,'O','I','M',21,5,16,15);
INSERT INTO covertopsmissions VALUES ('Hack Intelligence News Network',2000,800,2000,0,100,0,0,0,'O','I','I',0,6,24,10);
INSERT INTO covertopsmissions VALUES ('Assassinate Admiral',1000,1500,1500,200,100,100,0,0,'O','I','A',4,7,48,10);
INSERT INTO covertopsmissions VALUES ('Place Nuklear Bomb',5000,1000,2000,0,0,1000,0,0,'O','P','C',0,8,20,15);
INSERT INTO covertopsmissions VALUES ('Deploy Chimera Virus',7000,1000,3000,0,0,0,1500,0,'O','P','V',14,9,10,10);
INSERT INTO covertopsmissions VALUES ('Sabotage Tradestation',100,0,1000,1000,0,0,0,0,'O','I','T',0,10,60,10);

