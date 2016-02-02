# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'nachnamen'
#

DROP TABLE IF EXISTS nachnamen;
CREATE TABLE nachnamen (
  name varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

#
# Dumping data for table 'nachnamen'
#

INSERT INTO nachnamen VALUES ('Schmitz',1);
INSERT INTO nachnamen VALUES ('Oey',2);
INSERT INTO nachnamen VALUES ('Geis',3);
INSERT INTO nachnamen VALUES ('Bullock',4);
INSERT INTO nachnamen VALUES ('Andersson',5);
INSERT INTO nachnamen VALUES ('Clinton',6);
INSERT INTO nachnamen VALUES ('Gates',7);
INSERT INTO nachnamen VALUES ('Bush',8);
INSERT INTO nachnamen VALUES ('Stewart',9);
INSERT INTO nachnamen VALUES ('Schumacher',10);
INSERT INTO nachnamen VALUES ('Graf',11);
INSERT INTO nachnamen VALUES ('Koh',12);
INSERT INTO nachnamen VALUES ('Kohl',13);
INSERT INTO nachnamen VALUES ('Papadopolus',14);
INSERT INTO nachnamen VALUES ('Pansen',15);
INSERT INTO nachnamen VALUES ('Versace',16);
INSERT INTO nachnamen VALUES ('Alesi',17);
INSERT INTO nachnamen VALUES ('Mueller',18);
INSERT INTO nachnamen VALUES ('Kayal',19);
INSERT INTO nachnamen VALUES ('Hildon',20);
INSERT INTO nachnamen VALUES ('Frohnmayer',21);
INSERT INTO nachnamen VALUES ('Hartz',22);
INSERT INTO nachnamen VALUES ('Sheppert',23);
INSERT INTO nachnamen VALUES ('Campbell',24);
INSERT INTO nachnamen VALUES ('Peterson',25);
INSERT INTO nachnamen VALUES ('Harrison',26);
INSERT INTO nachnamen VALUES ('Keller',27);
INSERT INTO nachnamen VALUES ('Behl',28);
INSERT INTO nachnamen VALUES ('Marshall',29);
INSERT INTO nachnamen VALUES ('Zmak',30);
INSERT INTO nachnamen VALUES ('Hunt',31);
INSERT INTO nachnamen VALUES ('Taylor',32);
INSERT INTO nachnamen VALUES ('Popescu',33);
INSERT INTO nachnamen VALUES ('Walker',34);
INSERT INTO nachnamen VALUES ('McLeod',35);
INSERT INTO nachnamen VALUES ('McAllister',36);
INSERT INTO nachnamen VALUES ('McDonald',37);
INSERT INTO nachnamen VALUES ('McFurley',38);
INSERT INTO nachnamen VALUES ('Hood',39);
INSERT INTO nachnamen VALUES ('Lee',40);
INSERT INTO nachnamen VALUES ('Chong',41);
INSERT INTO nachnamen VALUES ('Il',42);
INSERT INTO nachnamen VALUES ('N\'Gong',43);
INSERT INTO nachnamen VALUES ('Musaka',44);
INSERT INTO nachnamen VALUES ('Muyomi',45);
INSERT INTO nachnamen VALUES ('Thoma',46);
INSERT INTO nachnamen VALUES ('Jauch',47);
INSERT INTO nachnamen VALUES ('Govanni',48);
INSERT INTO nachnamen VALUES ('Mandela',49);
INSERT INTO nachnamen VALUES ('Hyatt',50);
INSERT INTO nachnamen VALUES ('Kandinski',51);
INSERT INTO nachnamen VALUES ('Putin',52);
INSERT INTO nachnamen VALUES ('Tchekow',53);
INSERT INTO nachnamen VALUES ('Steiner',54);
INSERT INTO nachnamen VALUES ('Streichardt',55);
INSERT INTO nachnamen VALUES ('West',56);
INSERT INTO nachnamen VALUES ('Liedke',57);
INSERT INTO nachnamen VALUES ('East',58);
INSERT INTO nachnamen VALUES ('North',59);
INSERT INTO nachnamen VALUES ('South',60);
INSERT INTO nachnamen VALUES ('Virgin',61);
INSERT INTO nachnamen VALUES ('Lau',62);
INSERT INTO nachnamen VALUES ('Lao',63);
INSERT INTO nachnamen VALUES ('Steel',64);
INSERT INTO nachnamen VALUES ('Stahl',65);

