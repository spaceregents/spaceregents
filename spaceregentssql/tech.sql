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
-- Table structure for table `tech`
--

DROP TABLE IF EXISTS tech;
CREATE TABLE tech (
  name varchar(255) default NULL,
  depend int(11) default NULL,
  excl int(11) default NULL,
  t_id int(11) NOT NULL auto_increment,
  description text,
  com_time int(11) default NULL,
  flag char(1) default 'N',
  special tinyint(4) default '0',
  PRIMARY KEY  (t_id)
) TYPE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;

--
-- Dumping data for table `tech`
--

INSERT INTO tech VALUES ('Theory of Space Exploration',NULL,NULL,1,'Covers the basic technologies of Exploration',3,'T',0);
INSERT INTO tech VALUES ('Instellar Jump Drive',1,NULL,2,'Allows jumping between the stars',3,'N',0);
INSERT INTO tech VALUES ('Nuclear provided power cells',1,NULL,3,'Energy compression',3,'N',0);
INSERT INTO tech VALUES ('Laser Wave Switch',1,NULL,4,'Designed for defending against Asteroids. Very Basic Laser weapon',3,'N',0);
INSERT INTO tech VALUES ('Theory of Space Expansion',1,NULL,5,'Space doesn\'t just give us the right to use its ressources but also offers unlimited room for our citizens',4,'T',0);
INSERT INTO tech VALUES ('Modular Cargo System',5,NULL,6,'Features a new generation of Cargo modules. Quickly exchangeable. This enables you to profit from trade and to transport infantry.',4,'N',0);
INSERT INTO tech VALUES ('Docking absorption Unit',5,NULL,7,'Eases the process of Docking.',4,'N',0);
INSERT INTO tech VALUES ('Integrated Living',5,NULL,8,'Combines the needs of humans in one building.',4,'N',0);
INSERT INTO tech VALUES ('Theory of Space War',5,NULL,9,'We are helpless against Space aggression. New needs cover new possibilities.',5,'T',0);
INSERT INTO tech VALUES ('Orbital Bombing Procedure',9,NULL,10,'Our enemies will never know what hit them.',5,'N',0);
INSERT INTO tech VALUES ('Applied Electromagnetic Pulse',9,NULL,11,'Features a powerful EMP attack on enemy ships.',5,'N',0);
INSERT INTO tech VALUES ('Advanced Space Travelling',9,NULL,12,'Nobody wins a war or even a battle with big weapons. History has shown that the one who is faster has a very big advantage.',5,'N',0);
INSERT INTO tech VALUES ('Theory of Life',9,NULL,13,'If we know what life is we can manipulate the world to our needs. Fascinating imagination, isn\'t it?',8,'T',0);
INSERT INTO tech VALUES ('Genetic Engineering',13,NULL,14,'An improved genetic structure will improve the human Performance.',8,'N',0);
INSERT INTO tech VALUES ('Cloning',13,NULL,15,'This will give the term \'masses\' a new meaning. Unlimited human ressources.',8,'N',0);
INSERT INTO tech VALUES ('Improved Farming',13,NULL,16,'Why do we try to adapt to the plants. The plants have to adapt to us!',8,'N',0);
INSERT INTO tech VALUES ('Theory of Advanced Energy sources',13,NULL,17,'It\'s time for a new energy. Let\'s see what the world can give us.',11,'T',0);
INSERT INTO tech VALUES ('Cold Fusion provided Energycells',17,NULL,18,'Highly compressed Energy allows new ships.',11,'N',0);
INSERT INTO tech VALUES ('Warpengine',17,NULL,19,'The faster we are the better we are',11,'N',0);
INSERT INTO tech VALUES ('Theory of Nanotechnology',17,NULL,20,'We always get bigger and bigger. Why not go into detail?',16,'T',0);
INSERT INTO tech VALUES ('Nano scanner',20,NULL,21,'Can you see nanobots? No. But they can see you!',16,'N',0);
INSERT INTO tech VALUES ('Nanobot container',20,NULL,22,'One Nanobot could destroy hundreds of cells. But how many would billions of these destory? Nested in one Container they are a powerful weapon',16,'N',0);
INSERT INTO tech VALUES ('Terraforming',20,NULL,23,'What about Nanobots changing our enviroment? Useful? I guess so.',16,'N',0);
INSERT INTO tech VALUES ('Theory of Particel acceleration',20,NULL,24,'The traditional weapons are outdated. This will give us the power to build devastating weapons.',21,'T',0);
INSERT INTO tech VALUES ('Plasma Heater',24,NULL,25,'Plasma weapons feature a very devastating impact. They are very slow though. So it\'s the ideal weapon for large and slow ships.',21,'N',0);
INSERT INTO tech VALUES ('Hullbreaker Gate Device',24,NULL,26,'The \'Antitank grenade launcher\' for space combat. Hit\'s the ship and developes its power inside the ship.',21,'N',0);
INSERT INTO tech VALUES ('Ionization Module',24,NULL,27,'Activates a Sphere around its victim which makes the enemy unmoveable for a while.',21,'N',0);
INSERT INTO tech VALUES ('Theory of Human Mind',24,NULL,28,'Be a step beyond your enemies. Know what they think and plan your further steps. Furthermore it enables you to improve your colonies and make them more efficient.',28,'T',0);
INSERT INTO tech VALUES ('Efficient Working',28,NULL,29,'Think like your workers and make their production enviroment more motivating because motivated workers work harder and better.',28,'N',0);
INSERT INTO tech VALUES ('Neural Sensors',28,NULL,30,'Go through the streets and know what people think.',28,'N',0);
INSERT INTO tech VALUES ('Persuation Rays',28,NULL,31,'People don\'t like you? People don\'t follow you? Arguing would be too exhausting so why not persuade them by pressing a button?.',28,'N',0);
INSERT INTO tech VALUES ('Shock Dispenser',28,NULL,32,'Enables you to utilize current warptechnologies completely by reducing the biological shock for the travelers.',28,'N',0);
INSERT INTO tech VALUES ('Theory of Galactic Ressources',28,NULL,33,'Space is more than metal and energy. Research the facilities of the Interstellar Ressources.',35,'T',1);
INSERT INTO tech VALUES ('Secrets of Mopgas',33,NULL,34,'Highly energetic.',35,'N',0);
INSERT INTO tech VALUES ('Secrets of Gortium',33,NULL,35,'Gortium. The ressource of the ancient planets.',35,'N',0);
INSERT INTO tech VALUES ('Secrets of Erkunum',33,NULL,36,'The supraconducting ressource.',35,'N',0);
INSERT INTO tech VALUES ('Secrets of Susebloom',33,NULL,37,'The most interesting ressource in Space but VERY rare. It\'s use cover drugs, medicaments etc.',35,'N',0);
INSERT INTO tech VALUES ('Theory of Space Surveillance',33,NULL,38,'The one who knows what is going on is always a step further. Control through knowledge!',44,'T',0);
INSERT INTO tech VALUES ('Mobile Emission Detector',38,NULL,39,'Very sensible ship detectors.',44,'N',0);
INSERT INTO tech VALUES ('Deep Scanning',38,NULL,40,'This technology reveals almost every movement in space.',44,'N',0);
INSERT INTO tech VALUES ('Long Range Jamming',38,NULL,41,'Hides you from enemy detection. If you can\'t be seen you can\'t be hit.',44,'N',0);
INSERT INTO tech VALUES ('Theory of Synthetic Devices',38,NULL,42,'Manpower is too weak and not reliable. Androids are smarter, faster and stronger. Furthermore you could replace human organs through synthetic.',53,'T',0);
INSERT INTO tech VALUES ('Cyberbiological Engineering',42,NULL,43,'Sex, 9 Months of waiting and lots of years of development. Build your fully equipped Android in one hour.',53,'N',0);
INSERT INTO tech VALUES ('Symbiotic Shipsystems',42,NULL,44,'Computers can do maths. But do they really think? No. Sysmbiotic Shipsystems combine the tactical understanding of your captains with your systems and enable you to crush your enemies faster than they can react.',53,'N',0);
INSERT INTO tech VALUES ('Virtual Entertainment',42,NULL,45,'Moral and motivation will never be a problem. This new generation of virtual entertainment connects to the human mind and displays what the user wants to see.',53,'N',0);
INSERT INTO tech VALUES ('Theory of Artificial Intelligence',42,NULL,46,'The biological brain wastes most of its performance in doing nothing. Todays computers must be feed with human creativity and their failures! Thats a matter we can not tolerate! The only solution are devices controlled by an artificial intelligence.',64,'T',0);
INSERT INTO tech VALUES ('AI Insects',46,NULL,47,'That enemy Admiral will never know that the fly in his soup knows him better than heself does.',64,'N',0);
INSERT INTO tech VALUES ('Battleprocedure Algorithm',46,NULL,48,'Being able to construct autonom warships will not just make you more popular, you\'ll safe a lot expensive human resources, too!',64,'N',0);
INSERT INTO tech VALUES ('Multiple Synchron Targeting System',46,NULL,49,'The idea is: Target dozends of enemy ships that none of your guns will never idle nor loose target at a time. From now our guns will always know where the enemy was, is and will be!',64,'N',0);
INSERT INTO tech VALUES ('Rapid Laser Wave Switch',46,NULL,50,'Good old Laser Switch, your honor will be restored when their battleships will be cut up in thousends of pieces in a row!',64,'N',0);
INSERT INTO tech VALUES ('Theory of total material processing',46,NULL,51,'These rare and very special galatic resources are still holding some of their secrets. I say NO MORE!',75,'T',1);
INSERT INTO tech VALUES ('Gortium radiation insulation',51,NULL,52,'kommt noch',75,'N',0);
INSERT INTO tech VALUES ('Erkunum Condesation',51,NULL,53,'Its last secret! Its strange behaviour in gaseous condition is solved!Gaining Erkunum will now be cheaper, easyer and faster!',75,'N',0);
INSERT INTO tech VALUES ('Mopgas Binding',51,NULL,54,'Toxic planets hold more mopgas than we thought! We never believed that the hypercomplex and ultracritic mopgas molecule could be binded!',75,'N',0);
INSERT INTO tech VALUES ('Artificial Susebloom planting',51,NULL,55,'Sadly Susebloom will  only grow on Eden Planets, but these complex planting machines will know be able to find, harvest and care for the flower more efficient.',75,'N',0);
INSERT INTO tech VALUES ('Theory of Human Hardening',51,NULL,56,'The gift of the galactic resources makes it possible  that on human can easly match a Wardroid in close combat.',88,'T',0);
INSERT INTO tech VALUES ('Susebloom packs',56,NULL,57,'A soldier cought in a battle will encounter terror and pain. Susebloom packs will reduce those experiences to a minimum,  give the soldier independence from sleep and food for days.',88,'N',0);
INSERT INTO tech VALUES ('Advanced Pharmaceutics',56,NULL,58,'Today there is no desease that can\'t be cured, no wound that can\'t be healed. The only question is: can you pay?',88,'N',0);
INSERT INTO tech VALUES ('Theory of Advanced Space Warfare',56,NULL,59,'What were those toys our men played with? Plasma rifles? Fusion bombs? pah! Lets get rid of those childish stuff and have a look at these freaking weapons!',101,'T',0);
INSERT INTO tech VALUES ('Plasma Cluster',59,NULL,60,'Seen Hell? No? At least you can unleash hell!',101,'N',0);
INSERT INTO tech VALUES ('Ionization Cluster Module',59,NULL,61,'A one billion tons ship crushed like a peanut? Well I\'d say, release just for a second a tiny wormhole in its very heart. The Implusionimpact is one of the most beautyfull wonders in the known galaxy.',101,'N',0);
INSERT INTO tech VALUES ('Chaos Engines',59,NULL,62,'Coordinating the ways of chaos is quite difficult. Describing either. But the breath you just took could have launched the hurrican on the ocean.',101,'N',0);
INSERT INTO tech VALUES ('Theory of Material Alteration',59,NULL,63,'What is it? Is not a organism, not a machine nor a nanobot but behaves like those?',116,'T',0);
INSERT INTO tech VALUES ('Chameleon Fibres',63,NULL,64,'You wouldn\'t see your assassin even when you\'d hit him with your nose.',116,'N',0);
INSERT INTO tech VALUES ('Polyurethane Pilot Suit',63,NULL,65,'A Pilot, made of flesh or steel wouldn\'t survive a acceleration from zero to lightspeed in less than a blink. Now they will!',116,'N',0);
INSERT INTO tech VALUES ('The Autonom City',63,NULL,66,'And then I said: \"I\'d like to have a swimmingpool!\" After a few seconds I had a swimmingpool in my backyard! Fascinating, isn\'t it?',116,'N',0);
INSERT INTO tech VALUES ('Theory of Enemy Domination',63,NULL,67,'If you want to feel like armageddon, we can make you feel so. I promise!',134,'T',0);
INSERT INTO tech VALUES ('Graviation Field Generator',67,NULL,68,'Who said that artificial moon can not move? Who said that? Jesus, wheres that moon now?',134,'N',0);
INSERT INTO tech VALUES ('Antimatter provided Energycells',67,NULL,69,'Ultraeffective compressed Energy! You won\'t find such power in a small black hole!',134,'N',0);
INSERT INTO tech VALUES ('Giant Mass Controler',67,NULL,70,'Ravaging a planet is NOT nice!',134,'N',0);
INSERT INTO tech VALUES ('Applied Gravitionik',67,NULL,71,'Brought the gravtionik to miniature! Living will be so much easier than it is today!',134,'N',0);
INSERT INTO tech VALUES ('Theory of Light Diversion',67,NULL,72,'Light! Another thing that\'d support us greatly I guess.',151,'T',0);
INSERT INTO tech VALUES ('Optical Cloaking Device',72,NULL,73,'That device mount on a big big ship will hide your fleets from enemy eyes!',151,'N',0);
INSERT INTO tech VALUES ('Cloaking',72,NULL,74,'Being the invisble man, your soldiers will experience the feeling of being not there! Well at least of a couple of hours.',151,'N',0);

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;

