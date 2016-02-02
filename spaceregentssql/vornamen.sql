# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'vornamen'
#

DROP TABLE IF EXISTS vornamen;
CREATE TABLE vornamen (
  name varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  gender char(1) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

#
# Dumping data for table 'vornamen'
#

INSERT INTO vornamen VALUES ('Hans',1,'m');
INSERT INTO vornamen VALUES ('John',2,'m');
INSERT INTO vornamen VALUES ('Joe',3,'m');
INSERT INTO vornamen VALUES ('James',4,'m');
INSERT INTO vornamen VALUES ('Peter',5,'m');
INSERT INTO vornamen VALUES ('Karl-Heinz',6,'m');
INSERT INTO vornamen VALUES ('Chen-Yu',7,'m');
INSERT INTO vornamen VALUES ('Oleg',8,'m');
INSERT INTO vornamen VALUES ('Alex',9,'m');
INSERT INTO vornamen VALUES ('Nelson',10,'m');
INSERT INTO vornamen VALUES ('Bart',11,'m');
INSERT INTO vornamen VALUES ('Tobias',12,'m');
INSERT INTO vornamen VALUES ('Hans-Ruediger Andreas Peter',13,'m');
INSERT INTO vornamen VALUES ('Erik',14,'m');
INSERT INTO vornamen VALUES ('Daniel',15,'m');
INSERT INTO vornamen VALUES ('Michael',16,'m');
INSERT INTO vornamen VALUES ('Janne',17,'m');
INSERT INTO vornamen VALUES ('Marcus',18,'m');
INSERT INTO vornamen VALUES ('Andre',19,'m');
INSERT INTO vornamen VALUES ('Susanne',20,'w');
INSERT INTO vornamen VALUES ('Judith',21,'w');
INSERT INTO vornamen VALUES ('Anette',22,'w');
INSERT INTO vornamen VALUES ('Jeanette',23,'w');
INSERT INTO vornamen VALUES ('Sandra',24,'w');
INSERT INTO vornamen VALUES ('Joe-Ann',25,'w');
INSERT INTO vornamen VALUES ('Maria',26,'w');
INSERT INTO vornamen VALUES ('Mary',27,'w');
INSERT INTO vornamen VALUES ('Mailin',28,'w');
INSERT INTO vornamen VALUES ('Sue',29,'w');
INSERT INTO vornamen VALUES ('Alexandra',30,'w');
INSERT INTO vornamen VALUES ('Charlotte',31,'w');
INSERT INTO vornamen VALUES ('Birgit',32,'w');
INSERT INTO vornamen VALUES ('Pamela',33,'w');
INSERT INTO vornamen VALUES ('Julia',34,'w');
INSERT INTO vornamen VALUES ('Juliette',35,'w');
INSERT INTO vornamen VALUES ('Nicole',36,'w');
INSERT INTO vornamen VALUES ('William',37,'m');
INSERT INTO vornamen VALUES ('Victor',38,'m');
INSERT INTO vornamen VALUES ('Juli',39,'w');
INSERT INTO vornamen VALUES ('Robert',40,'m');
INSERT INTO vornamen VALUES ('Charles',41,'m');
INSERT INTO vornamen VALUES ('Kelly',42,'w');
INSERT INTO vornamen VALUES ('Dave',43,'m');
INSERT INTO vornamen VALUES ('Brad',44,'m');
INSERT INTO vornamen VALUES ('Brian',45,'m');
INSERT INTO vornamen VALUES ('Clark',46,'m');
INSERT INTO vornamen VALUES ('Jesse',47,'w');
INSERT INTO vornamen VALUES ('Sabrina',48,'w');
INSERT INTO vornamen VALUES ('Ian',49,'m');
INSERT INTO vornamen VALUES ('Paul',50,'m');
INSERT INTO vornamen VALUES ('Matthew',51,'m');
INSERT INTO vornamen VALUES ('Thomas',52,'m');
INSERT INTO vornamen VALUES ('Linda',53,'w');
INSERT INTO vornamen VALUES ('Aaron',54,'m');
INSERT INTO vornamen VALUES ('Phillip',55,'m');
INSERT INTO vornamen VALUES ('Drew',56,'w');
INSERT INTO vornamen VALUES ('Chris',57,'m');
INSERT INTO vornamen VALUES ('Christian',58,'m');
INSERT INTO vornamen VALUES ('Mark',59,'m');
INSERT INTO vornamen VALUES ('Helen',60,'w');
INSERT INTO vornamen VALUES ('Ti',61,'w');
INSERT INTO vornamen VALUES ('Tim',62,'m');
INSERT INTO vornamen VALUES ('Ilknur',63,'w');
INSERT INTO vornamen VALUES ('Rick',64,'m');
INSERT INTO vornamen VALUES ('Richard',65,'m');
INSERT INTO vornamen VALUES ('Diana',66,'w');
INSERT INTO vornamen VALUES ('Scott',67,'m');
INSERT INTO vornamen VALUES ('Shawn',68,'m');
INSERT INTO vornamen VALUES ('Claudia',69,'w');
INSERT INTO vornamen VALUES ('Hillary',70,'w');
INSERT INTO vornamen VALUES ('Laura',71,'w');
INSERT INTO vornamen VALUES ('Jason',72,'m');
INSERT INTO vornamen VALUES ('Max',73,'m');
INSERT INTO vornamen VALUES ('Kim',74,'w');
INSERT INTO vornamen VALUES ('Kevin',75,'m');
INSERT INTO vornamen VALUES ('Lou',76,'w');
INSERT INTO vornamen VALUES ('Kiamalise',77,'w');
INSERT INTO vornamen VALUES ('Naomi',78,'w');
INSERT INTO vornamen VALUES ('Nicoletta',79,'w');
INSERT INTO vornamen VALUES ('Sophia',80,'w');
INSERT INTO vornamen VALUES ('Sonja',81,'w');
INSERT INTO vornamen VALUES ('Mira',82,'w');
INSERT INTO vornamen VALUES ('Mia',83,'w');
INSERT INTO vornamen VALUES ('Vladimir',84,'m');
INSERT INTO vornamen VALUES ('Andrej',85,'m');
INSERT INTO vornamen VALUES ('Mej-Yu',86,'w');
INSERT INTO vornamen VALUES ('Victoria',87,'w');
INSERT INTO vornamen VALUES ('Brigitte',88,'w');

