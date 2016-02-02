-- MySQL dump 10.2
--
-- Host: localhost    Database: spaceregents
-- ------------------------------------------------------
-- Server version	4.1.1-alpha-log

/*!40101 SET NAMES latin1*/;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE=NO_AUTO_VALUE_ON_ZERO */;

--
-- Table structure for table `production`
--

DROP TABLE IF EXISTS production;
CREATE TABLE production (
  com_time tinyint(3) default NULL,
  typ char(2) default NULL,
  tech int(11) NOT NULL default '0',
  prod_id int(11) NOT NULL auto_increment,
  name varchar(255) default NULL,
  description blob,
  susebloom int(11) NOT NULL default '0',
  gortium int(11) NOT NULL default '0',
  erkunum int(11) NOT NULL default '0',
  mopgas int(11) NOT NULL default '0',
  energy int(11) NOT NULL default '0',
  metal int(11) NOT NULL default '0',
  special char(1) default '',
  p_depend int(11) default '0',
  manual varchar(255) default NULL,
  pic varchar(255) NOT NULL default 'default.jpg',
  colonists int(11) default '0',
  upgrade tinyint(1) default '0',
  PRIMARY KEY  (prod_id),
  UNIQUE KEY prod_id (prod_id)
) TYPE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;

--
-- Dumping data for table `production`
--

INSERT INTO production VALUES (1,'P',0,1,'Barracks','Basic infantry training camp',0,0,0,0,1000,1000,'',NULL,NULL,'p_barracks.jpg',0,0);
INSERT INTO production VALUES (2,'L',2,2,'Scout','Small, fast and weak spaceship',0,0,0,0,100,100,'',60,NULL,'p_scout.jpg',0,0);
INSERT INTO production VALUES (1,'L',2,3,'Probe','Small and unarmed drone',0,0,0,0,50,50,'',NULL,NULL,'p_probe.jpg',0,0);
INSERT INTO production VALUES (2,'P',3,4,'Nuclear Power Plant','Nuclear Energy',0,0,0,0,200,1000,'',NULL,NULL,'p_nuclear_plant.jpg',0,0);
INSERT INTO production VALUES (5,'P',4,5,'Laser Weapons Factory','First weapon for use in Space',0,0,0,0,700,500,'',1,NULL,'p_lwf.jpg',0,0);
INSERT INTO production VALUES (3,'L',4,6,'Interceptor','Maybe there are some dangers in space.',0,0,0,0,200,200,'',5,NULL,'p_interceptor.jpg',0,0);
INSERT INTO production VALUES (2,'I',4,7,'Soldier','Protection for our cities',0,0,0,0,10,10,'',1,NULL,'p_soldier.jpg',0,0);
INSERT INTO production VALUES (3,'R',6,8,'Tradestation','Galactic interrelationships depend on galactic trade.',0,0,0,0,5000,5000,'U',NULL,NULL,'p_tradestation.jpg',0,0);
INSERT INTO production VALUES (3,'M',6,9,'Transporters','Basic transporter. Provides up to 300 storage space.',0,0,0,0,200,200,'T',60,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (12,'O',7,10,'Spacestation','Some light defenses, an increased scanrange and the ability to construct orbital buildings makes the station a must have.',0,0,0,0,3000,6000,'',60,NULL,'p_spacestation.jpg',0,0);
INSERT INTO production VALUES (6,'P',8,11,'Arcology','The autonom City',0,0,0,0,2000,5000,'P',NULL,NULL,'p_arcology.jpg',0,0);
INSERT INTO production VALUES (24,'H',8,12,'Colony ship','Earth is just too small for mankind',0,0,0,0,4000,4000,'C',60,NULL,'p_colonyship.jpg',1,0);
INSERT INTO production VALUES (5,'P',10,13,'Ground batteries','Lets rain beams of death over our foes, that dare to land on our terrain',0,0,0,0,2000,3000,'',1,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (3,'L',10,14,'B-5056 Bomber','Very effective attack unit',0,0,0,0,200,250,'',60,NULL,'p_b5056.jpg',0,0);
INSERT INTO production VALUES (15,'P',11,15,'Planetary Shield Generator','No probe or puny Dreamcatcher will scan our surface no more, no bombs will pierce our buildings. (Sorry, the shield is not yet working, though it blocks scans)',0,500,500,1000,5000,2000,'',23,NULL,'p_planetary_shield.jpg',0,0);
INSERT INTO production VALUES (4,'M',11,16,'Peacekeeper Corvette','EMP-weapon armed corvette',0,0,0,0,350,400,'',60,NULL,'p_peace_corv.jpg',0,0);
INSERT INTO production VALUES (8,'O',12,17,'Orbital Refueling Station','Reduces fleet refueling time of bypassing own and allied forces by 1 week',0,0,0,1000,4000,2000,'F',10,NULL,'p_refueling_station.jpg',0,0);
INSERT INTO production VALUES (10,'H',50,18,'Draconis Destroyer','Light and fast destroyer',0,200,100,100,8000,3000,'',67,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (12,'P',14,19,'Gen Factory','Increases poplation grow',0,0,0,0,600,400,'G',NULL,NULL,'p_gen_fac.jpg',0,0);
INSERT INTO production VALUES (3,'I',14,20,'Space Marines','Elite Ground Troopers',0,0,0,0,20,20,'',1,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (4,'P',15,21,'Cloning Vaults','...',0,0,0,0,2000,500,'G',19,NULL,'p_cloning_vaults.jpg',0,0);
INSERT INTO production VALUES (5,'P',16,22,'Agriculture Command Center','Imporved Farming',0,0,0,0,900,200,'G',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (24,'P',18,23,'Fusion Power Plant','Advanced energy scource',0,0,0,0,1000,2000,'',4,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (4,'L',22,24,'N-2103 Bomber','More destructiv? Yesss...',0,50,100,50,500,500,'',69,NULL,'p_n2103.jpg',0,0);
INSERT INTO production VALUES (30,'P',23,25,'Clima Controlling Facillity','Impoves living conditions on a planet',0,0,0,0,10000,4000,'P',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (24,'P',25,26,'Instant Plasma Facility','Produces plasma weapons',0,0,0,0,5000,4000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (6,'P',26,27,'Missile Base',' Beautifull fireworks will brighten the dark of space and burning deathcrys will caress our ears. Let their battleships melt to drops of glass.',0,500,0,0,2000,4000,'',1,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (6,'M',26,28,'Hijacker','Able to caputre enemy ships (M)',0,500,0,0,1000,1000,'',10,NULL,'p_hijacker.jpg',0,0);
INSERT INTO production VALUES (6,'M',27,29,'Freezer','Able to disable enemy ships (M)',0,200,200,200,1200,1000,'',10,NULL,'p_freezer.jpg',0,0);
INSERT INTO production VALUES (48,'P',29,30,'Labour Training Camp','Increases production (not implemented)',0,0,0,0,8000,8000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (16,'O',34,31,'Mopgas Extraction Platform','Extracts mopgas from the atmosphere of toxic planets',0,500,500,0,4000,4000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (16,'P',35,32,'Gortium Mine','Extracts Gortium from ancient planets',0,0,0,0,2000,8000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (16,'P',36,33,'Erkunum Pumping Station','Exploits the erkunum deposits on ice planets',0,0,0,0,6000,4000,'',NULL,NULL,'p_erk_pump.jpg',0,0);
INSERT INTO production VALUES (16,'P',37,34,'Mobile Susebloom Harvester','Increases the susebloom harvest on eden planets',0,0,500,500,5000,5000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (8,'M',39,35,'Dreamcatcher Frigate','Detects hidden ships',0,200,500,0,800,800,'',60,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (8,'P',40,36,'Surveillance Cluster','Sensor array',0,0,2000,0,10000,5000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (10,'H',40,37,'Beholder','...',0,1000,500,500,2700,3700,'',67,NULL,'p_beholder.jpg',0,0);
INSERT INTO production VALUES (14,'P',41,38,'Defence Masquerader','Hides your defence from enemy sensors',0,0,0,0,3000,900,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (8,'M',41,39,'Octopus Corvette','Hides the accompaning fleet from detection',0,100,200,0,1600,1000,'',67,NULL,'p_octopus.jpg',0,0);
INSERT INTO production VALUES (12,'P',43,40,'Cybersurgery Facility','Improves organic live through technological means',0,0,1000,500,10000,12000,'P',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (4,'I',43,41,'Cyborg','High tech soldier',0,0,0,0,50,50,'',40,NULL,'p_cyborg.jpg',0,0);
INSERT INTO production VALUES (12,'P',44,42,'Living/Rigged Factory','Mind controlled factory',0,0,0,0,2000,2000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (11,'P',45,43,'Pleasure Studio','Improves your people moral',1000,0,0,0,1600,600,'G',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (2,'I',48,44,'Droid','Ground combat robot',0,0,0,0,100,300,'',40,NULL,'p_droid.jpg',0,0);
INSERT INTO production VALUES (10,'M',49,45,'Hydra','More guns...more power',0,0,100,100,1500,2000,'',10,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (15,'P',50,46,'Laser Weapons Factory II','...',0,500,500,500,2300,1400,'',5,NULL,'p_lwf2.jpg',0,0);
INSERT INTO production VALUES (16,'P',58,47,'Cure Hospital','Improves living conditions',2000,0,0,0,4000,4000,'P',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (18,'H',60,48,'Behemoth','Big ship...big guns...big...',0,5000,1000,5000,16000,20000,'',67,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (17,'O',61,49,'Orbital Batterie','A platform of deathly beauty, as our enemys will find out soon.',0,500,1000,1000,8000,8000,'',10,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (10,'I',64,50,'Shadow','Stealth Infantrie',0,0,100,0,100,10,'',58,NULL,'p_shadow.jpg',0,0);
INSERT INTO production VALUES (92,'P',69,51,'Antimatter Power Plant','Ultimate power scource',0,1000,5000,3000,20000,40000,'',23,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (16,'H',73,52,'Wrath','Cloaks accompanding fleet',0,500,4000,2000,12000,6000,'',68,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (1,'P',0,53,'Metal Mine','Produces Metal',0,0,0,0,1000,200,'',NULL,NULL,'p_metal_mine.jpg',0,0);
INSERT INTO production VALUES (4,'I',18,54,'Mad Max','Light ground combat vehicle',0,0,0,0,30,50,'',5,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (5,'I',25,55,'Stonewall Tank','Heavy plasma tank',0,0,0,0,80,100,'',26,NULL,'p_stonewalltank.jpg',0,0);
INSERT INTO production VALUES (6,'P',30,56,'Neural Security Network','Improves security conditions on your planet',0,0,0,0,800,800,'',NULL,NULL,'p_neural_security_network.jpg',0,0);
INSERT INTO production VALUES (8,'P',47,57,'Observation Center','...',0,0,10000,0,15000,15000,'',NULL,NULL,'p_observation_center.jpg',0,0);
INSERT INTO production VALUES (10,'P',64,58,'Infiltration Training Camp','...',0,0,0,0,1500,2000,'',1,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (24,'P',74,59,'Cloaking Suit Factory','Makes your agents invisible...',0,0,2000,2000,8000,5000,'',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (4,'P',0,60,'Starport','First step away from your homeworld',0,0,0,0,800,800,'',NULL,NULL,'p_starport.jpg',0,0);
INSERT INTO production VALUES (92,'O',27,61,'Jumpgate','...',0,10000,10000,10000,20000,20000,'S',10,NULL,'p_jumpgate.jpg',0,0);
INSERT INTO production VALUES (24,'P',18,63,'Mining Complex','Expands the Mining System around the whole planet',0,0,0,0,2000,1000,'',53,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (5,'M',12,64,'Gunship','The Gunship is a predator. With it\'s 3 laser guns it pings Europa Class ships ot of the space easyly.',0,0,0,0,600,600,'',10,NULL,'p_gunship.jpg',0,0);
INSERT INTO production VALUES (0,'P',-1,65,'Colony','The Living and Workingplace where our Colonists increases our empires honour',0,0,0,0,0,1000,'',0,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (18,'O',12,67,'Orbital Shipyard','Huge orbital shipyard',0,500,500,500,5000,5000,'',10,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (24,'O',73,68,'Cloaking Module','Builds wrath',0,500,2000,2000,8000,1000,'',10,NULL,'default.jpg',0,1);
INSERT INTO production VALUES (5,'O',22,69,'Nano Warfare Module','Builds N-2103 Bomber',0,200,200,0,500,500,'',10,NULL,'default.jpg',0,1);
INSERT INTO production VALUES (36,'P',66,70,'Subterran Arcology','Increases the planets population limit',0,1000,500,500,4000,2000,'L',NULL,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (4,'L',44,71,'Sabre','The ultimate Europe-Class hunter.',0,100,100,100,200,200,'',67,NULL,'default.jpg',0,0);
INSERT INTO production VALUES (3,'I',37,72,'Berserk','Drugged Elite Soldier',10,0,0,0,20,20,'',1,NULL,'default.jpg',0,0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

