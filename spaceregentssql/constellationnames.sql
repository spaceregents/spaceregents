# MySQL dump 8.14
#
# Host: localhost    Database: spaceregents
#--------------------------------------------------------
# Server version	3.23.40-log

#
# Table structure for table 'constellationnames'
#

DROP TABLE IF EXISTS constellationnames;
CREATE TABLE constellationnames (
  name varchar(255) NOT NULL default '',
  id int(11) NOT NULL auto_increment,
  genetiv varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY genetiv (genetiv),
  KEY name (name)
) TYPE=MyISAM;

#
# Dumping data for table 'constellationnames'
#

INSERT INTO constellationnames VALUES ('Canis Major',1,'Canis Majoris');
INSERT INTO constellationnames VALUES ('Carina',2,'Carinae');
INSERT INTO constellationnames VALUES ('Rigel Centaurus',3,'Rigel Centauri');
INSERT INTO constellationnames VALUES ('Lyra',4,'Lyrae');
INSERT INTO constellationnames VALUES ('Auriga',5,'Aurigae');
INSERT INTO constellationnames VALUES ('Bootor',6,'Bootis');
INSERT INTO constellationnames VALUES ('Orion',7,'Orionis');
INSERT INTO constellationnames VALUES ('Canis Minor',8,'Canis Minoris');
INSERT INTO constellationnames VALUES ('Eridanus',9,'Eridani');
INSERT INTO constellationnames VALUES ('Aquila',10,'Aquilae');
INSERT INTO constellationnames VALUES ('Centaurus',11,'Centauri');
INSERT INTO constellationnames VALUES ('Scorpius',12,'Scorpii');
INSERT INTO constellationnames VALUES ('Taurus',13,'Tauri');
INSERT INTO constellationnames VALUES ('Virgo',14,'Virginis');
INSERT INTO constellationnames VALUES ('Gemini',15,'Geminorium');
INSERT INTO constellationnames VALUES ('Cygnus',16,'Cygni');
INSERT INTO constellationnames VALUES ('Piscis Austrinus',17,'Piscis Austrini');
INSERT INTO constellationnames VALUES ('Leo',18,'Leonis');
INSERT INTO constellationnames VALUES ('Crucis',19,'Crucis');
INSERT INTO constellationnames VALUES ('Ursa Major',20,'Ursa Majoris');
INSERT INTO constellationnames VALUES ('Perseus',21,'Persei');
INSERT INTO constellationnames VALUES ('Velorum',22,'Velorum');
INSERT INTO constellationnames VALUES ('Kaus Sagittarus',23,'Kaus Sagittari');
INSERT INTO constellationnames VALUES ('Cetus',24,'Ceti');
INSERT INTO constellationnames VALUES ('Andromeda',25,'Andromedae');
INSERT INTO constellationnames VALUES ('Ras Ophiuchus',26,'Ras Ophiuchi');
INSERT INTO constellationnames VALUES ('Sagittarus',27,'Sagittari');
INSERT INTO constellationnames VALUES ('Pavor',28,'Pavonis');
INSERT INTO constellationnames VALUES ('Ursa Minor',29,'Ursa Minoris');
INSERT INTO constellationnames VALUES ('Al Na\'Gru',30,'Al Na\'Gruis');
INSERT INTO constellationnames VALUES ('Hydra',31,'Hydrae');
INSERT INTO constellationnames VALUES ('Aries',32,'Arietis');
INSERT INTO constellationnames VALUES ('Umus',33,'Umi');
INSERT INTO constellationnames VALUES ('Gruis',34,'Gruis');
INSERT INTO constellationnames VALUES ('Corona Borealis',35,'Coronae Borealis');
INSERT INTO constellationnames VALUES ('Puppis',36,'Puppis');
INSERT INTO constellationnames VALUES ('Cassiopeia',37,'Cassiopeiae');
INSERT INTO constellationnames VALUES ('Phoenic',38,'Phoenicis');
INSERT INTO constellationnames VALUES ('Draco',39,'Draconis');
INSERT INTO constellationnames VALUES ('Pegasus',40,'Pegasi');
INSERT INTO constellationnames VALUES ('Cepheus',41,'Cephei');
INSERT INTO constellationnames VALUES ('Al Leo',42,'Al Leonis');
INSERT INTO constellationnames VALUES ('Ophiuchus',43,'Ophiuchi');
INSERT INTO constellationnames VALUES ('Zubenel Libra',44,'Zubenel Librae');
INSERT INTO constellationnames VALUES ('Lepo',45,'Leporis');
INSERT INTO constellationnames VALUES ('Lupus',46,'Lupi');
INSERT INTO constellationnames VALUES ('Columba',47,'Columbae');
INSERT INTO constellationnames VALUES ('Corvus',48,'Corvi');
INSERT INTO constellationnames VALUES ('Serpentis',49,'Serpentis');
INSERT INTO constellationnames VALUES ('Hercules',50,'Herculis');
INSERT INTO constellationnames VALUES ('Ara',51,'Arae');
INSERT INTO constellationnames VALUES ('Cor Canum Venaticorum',52,'Cor Canum Venaticorum');
INSERT INTO constellationnames VALUES ('Zuben El Libra',53,'Zuben El Librae');
INSERT INTO constellationnames VALUES ('Musca',54,'Muscae');
INSERT INTO constellationnames VALUES ('Kelbal Ophiuchus',55,'Kelbal Ophiuchi');
INSERT INTO constellationnames VALUES ('Tucana',56,'Tucanae');
INSERT INTO constellationnames VALUES ('Na\'iral Orion',57,'Na\'iral Orionis');
INSERT INTO constellationnames VALUES ('Deneb Capricornus',58,'Deneb Capricorni');
INSERT INTO constellationnames VALUES ('Ras Hercules',59,'Ras Herculis');
INSERT INTO constellationnames VALUES ('Yed Ophiuchus',60,'Yed Ophiuchi');
INSERT INTO constellationnames VALUES ('Talitha Ursa Major',61,'Talitha Ursa Majoris');
INSERT INTO constellationnames VALUES ('Triangulus',62,'Trianguli');
INSERT INTO constellationnames VALUES ('Al Scorpius',63,'Al Scorpii');
INSERT INTO constellationnames VALUES ('Aquarius',64,'Aquarii');
INSERT INTO constellationnames VALUES ('Al Sagittarus',65,'Al Sagittari');
INSERT INTO constellationnames VALUES ('Kaou Draco',66,'Kaou Draconis');
INSERT INTO constellationnames VALUES ('Al Gruis',67,'Al Gruis');
INSERT INTO constellationnames VALUES ('Al Indus',68,'Al Indi');
INSERT INTO constellationnames VALUES ('Tania Ursa Major',69,'Tania Ursa Majoris');
INSERT INTO constellationnames VALUES ('Capricornus',70,'Capricorni');
INSERT INTO constellationnames VALUES ('Pictoris',71,'Pictoris');
INSERT INTO constellationnames VALUES ('Lynx',72,'Lynx');
INSERT INTO constellationnames VALUES ('Circinus',73,'Circini');
INSERT INTO constellationnames VALUES ('Reticulus',74,'Reticuli');
INSERT INTO constellationnames VALUES ('Er Cepheus',75,'Er Cephei');
INSERT INTO constellationnames VALUES ('Libra',76,'Librae');
INSERT INTO constellationnames VALUES ('Doradus',77,'Doradus');
INSERT INTO constellationnames VALUES ('Al Aquila',78,'Al Aquilae');
INSERT INTO constellationnames VALUES ('Volantis',79,'Volantis');
INSERT INTO constellationnames VALUES ('Pyxidis',80,'Pyxidis');
INSERT INTO constellationnames VALUES ('Tseen Velorum',81,'Tseen Velorum');
INSERT INTO constellationnames VALUES ('Delphinus',82,'Delphini');
INSERT INTO constellationnames VALUES ('Piscium',83,'Piscium');
INSERT INTO constellationnames VALUES ('Alula Ursa Major',84,'Alula Ursa Majoris');
INSERT INTO constellationnames VALUES ('Indus',85,'Indi');
INSERT INTO constellationnames VALUES ('Octan',86,'Octanis');
INSERT INTO constellationnames VALUES ('Sagitta',87,'Sagittae');
INSERT INTO constellationnames VALUES ('Telescopius',88,'Telescopii');
INSERT INTO constellationnames VALUES ('Electra',89,'Electra');
INSERT INTO constellationnames VALUES ('Atlas',90,'Atlas');
INSERT INTO constellationnames VALUES ('Al Capricornus',91,'Al Capricorni');
INSERT INTO constellationnames VALUES ('Horologius',92,'Horologii');
INSERT INTO constellationnames VALUES ('Crater',93,'Crateris');
INSERT INTO constellationnames VALUES ('Cancrus',94,'Cancri');
INSERT INTO constellationnames VALUES ('Apodis',95,'Apodis');
INSERT INTO constellationnames VALUES ('Lacerta',96,'Lacertae');
INSERT INTO constellationnames VALUES ('Primus Taurus',97,'Primus Tauri');
INSERT INTO constellationnames VALUES ('Praecipula',98,'Praecipula');
INSERT INTO constellationnames VALUES ('Alcor',99,'Alcor');
INSERT INTO constellationnames VALUES ('Maia',100,'Maia');
INSERT INTO constellationnames VALUES ('Equuleus',101,'Equulei');
INSERT INTO constellationnames VALUES ('Monocerotis',102,'Monocerotis');
INSERT INTO constellationnames VALUES ('Norma',103,'Normae');
INSERT INTO constellationnames VALUES ('Chamaeleon',104,'Chamaeleontis');
INSERT INTO constellationnames VALUES ('Camelopardalis',105,'Camelopardalis');
INSERT INTO constellationnames VALUES ('Asellus Cancrus',106,'Asellus Cancri');
INSERT INTO constellationnames VALUES ('Kaitain',107,'Kaitain');
INSERT INTO constellationnames VALUES ('Merope',108,'Merope');
INSERT INTO constellationnames VALUES ('Canum Venaticorum',109,'Canum Venaticorum');
INSERT INTO constellationnames VALUES ('Coma Berenices',110,'Comae Berenices');
INSERT INTO constellationnames VALUES ('Taygeta',111,'Taygeta');
INSERT INTO constellationnames VALUES ('Sculptor',112,'Sculptoris');
INSERT INTO constellationnames VALUES ('Leo Minor',113,'Leonis Minoris');
INSERT INTO constellationnames VALUES ('Antlia',114,'Antliae');
INSERT INTO constellationnames VALUES ('Caelus',115,'Caeli');
INSERT INTO constellationnames VALUES ('Minharal Hydra',116,'Minharal Hydrae');
INSERT INTO constellationnames VALUES ('Fornacus',117,'Fornacis');
INSERT INTO constellationnames VALUES ('Vulpecula',118,'Vulpeculae');
INSERT INTO constellationnames VALUES ('Scutus',119,'Scuti');
INSERT INTO constellationnames VALUES ('Microscopius',120,'Microscopii');
INSERT INTO constellationnames VALUES ('Corona Australis',121,'Coronae Australis');
INSERT INTO constellationnames VALUES ('Mensa',122,'Mensae');
INSERT INTO constellationnames VALUES ('Pleione',123,'Pleione');
INSERT INTO constellationnames VALUES ('Sextant',124,'Sextantis');

