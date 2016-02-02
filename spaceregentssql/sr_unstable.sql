-- MySQL dump 8.22
--
-- Host: localhost    Database: spaceregents_unstable
---------------------------------------------------------
-- Server version	3.23.55-log

--
-- Table structure for table 'activationcodes'
--

DROP TABLE IF EXISTS activationcodes;
CREATE TABLE activationcodes (
  code varchar(255) default NULL,
  uid int(11) default NULL,
  date timestamp(14) NOT NULL
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'activationcodes'
--


INSERT INTO activationcodes VALUES ('4439831',1,20021222141313);
INSERT INTO activationcodes VALUES ('77592449',2,20021222142031);
INSERT INTO activationcodes VALUES ('14720182',3,20030108205240);
INSERT INTO activationcodes VALUES ('93731625',4,20030112121229);
INSERT INTO activationcodes VALUES ('37959801',5,20030228135430);
INSERT INTO activationcodes VALUES ('88638217',6,20030301143050);
INSERT INTO activationcodes VALUES ('95992646',7,20030302085751);
INSERT INTO activationcodes VALUES ('4096927',8,20030302145431);
INSERT INTO activationcodes VALUES ('65979035',9,20030302184149);

--
-- Table structure for table 'admirals'
--

DROP TABLE IF EXISTS admirals;
CREATE TABLE admirals (
  value int(11) default NULL,
  name varchar(255) default NULL,
  fid int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  uid int(11) default NULL,
  pic varchar(255) default NULL,
  agility int(11) default '0',
  initiative int(11) default '0',
  sensor int(11) default '0',
  weaponskill int(11) default '0',
  uniform int(11) default NULL,
  implantat int(11) default NULL,
  belt int(11) default NULL,
  used_xp int(11) default NULL,
  used_upgrades int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'admirals'
--


INSERT INTO admirals VALUES (0,'Christian Govanni',0,1,1,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Max Steel',2,2,2,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Christian Thoma',47,3,4,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Papadopolus',0,4,3,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Shawn Keller',0,5,5,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Stewart',0,6,6,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Juliette Taylor',219,7,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe Musaka',22,8,1,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sabrina Steel',28,9,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'James Hood',0,10,8,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mark Taylor',0,11,9,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Erik Lau',66,12,2,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Pamela Bullock',68,21,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sonja Walker',13,13,4,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Peter N\'Gong',0,14,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Alexandra Musaka',0,15,8,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sophia Geis',330,16,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Hans Pansen',0,17,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Hans Virgin',0,18,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Susanne Geis',67,19,2,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Lou Harrison',38,20,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Karl-Heinz Harrison',46,22,4,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mia Hartz',0,23,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia N\'Gong',0,24,8,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Behl',225,25,7,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ian Putin',0,26,1,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'James Geis',20,28,2,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ti Pansen',323,27,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nicoletta Oey',98,29,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Juli McDonald',0,30,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charles South',0,31,1,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Matthew Harrison',0,33,8,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Hans-Ruediger Andreas Peter Steiner',0,32,1,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charles Popescu',0,178,7,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Shawn Lau',59,34,4,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe-Ann Kohl',0,35,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nicoletta Peterson',352,36,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Peter Musaka',0,37,2,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Brad Keller',0,161,2,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Juli N\'Gong',342,38,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Jeanette Peterson',0,39,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Koh',0,40,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Alex Harrison',0,41,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Michael Hunt',0,42,1,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sophia Harrison',95,43,4,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Susanne Lee',0,44,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Max Koh',0,45,9,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Lou Koh',0,46,5,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Clark McAllister',8,47,5,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Alex Clinton',0,48,7,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Geis',0,49,1,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Aaron McLeod',0,50,7,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Maria Lau',119,51,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Diana Tchekow',0,52,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Max N\'Gong',0,53,7,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe-Ann Clinton',0,54,8,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Dave Lau',0,55,4,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Clinton',0,56,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Laura North',365,57,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Drew Peterson',0,58,5,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Drew Il',0,59,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Paul Il',0,60,5,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mailin East',0,61,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ilknur Popescu',0,62,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mej-Yu Versace',0,63,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Papadopolus',0,64,8,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Harrison',0,65,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mej-Yu Hyatt',0,66,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Thomas Mueller',0,67,5,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charles Kohl',0,68,5,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Lou McLeod',0,69,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Chen-Yu Putin',0,70,7,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Max Alesi',0,71,7,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Drew Kandinski',0,72,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Oleg Govanni',0,73,9,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe-Ann Hunt',0,74,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mark McFurley',0,75,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'John Musaka',196,76,9,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Alexandra Campbell',0,77,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Diana Campbell',0,78,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ti Il',0,79,1,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe-Ann Mueller',0,80,1,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe Hood',0,81,1,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Helen Stahl',0,82,1,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Paul Jauch',0,83,4,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'William Marshall',0,84,1,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Bart Liedke',0,85,5,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ilknur Pansen',0,86,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sabrina Hunt',0,87,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Christian Lee',0,88,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Karl-Heinz Il',237,89,2,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Vladimir Andersson',0,90,9,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Chen-Yu Mueller',99,91,9,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nelson Liedke',0,107,7,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Vladimir Lee',0,92,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Aaron McLeod',0,93,7,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sue Lee',0,94,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Scott Popescu',0,95,1,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Jason Hartz',0,96,7,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Robert Walker',0,97,7,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'James East',0,98,1,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charlotte East',0,99,1,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Aaron Musaka',0,100,1,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Thoma',0,101,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Daniel McAllister',0,102,9,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe-Ann Oey',202,103,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sophia Hildon',0,104,8,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nicoletta Bullock',0,105,8,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Pamela Taylor',0,106,8,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Matthew North',0,108,7,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Scott Zmak',0,109,5,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Janne Peterson',0,110,7,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Harrison',0,111,8,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Richard Jauch',0,112,9,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Alexandra Gates',0,113,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charlotte Mueller',0,114,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Michael Pansen',0,115,2,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Pamela Bush',0,116,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Hyatt',0,117,2,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Jeanette Virgin',0,118,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe Hyatt',0,119,2,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sabrina Schumacher',0,120,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Paul Stewart',290,122,9,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charlotte Musaka',0,121,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Pamela Koh',0,123,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sandra McFurley',0,124,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Brigitte Geis',130,125,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sabrina Popescu',260,126,2,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Chen-Yu Gates',327,127,2,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Paul Schumacher',0,128,2,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Kim Muyomi',0,129,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Susanne Musaka',0,130,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nicole Frohnmayer',0,131,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Judith Steel',0,132,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Shawn Kohl',0,133,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Erik Campbell',0,149,5,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Alex Mueller',0,134,7,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Peterson',0,135,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charles Mueller',0,136,4,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Oleg Geis',0,137,7,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Juli Jauch',0,138,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Oleg N\'Gong',0,139,7,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charles East',0,140,9,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mej-Yu Kandinski',0,141,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Kim Marshall',0,142,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Mandela',0,143,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Maria Streichardt',0,144,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Robert Oey',0,145,7,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ti Govanni',0,146,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Jeanette N\'Gong',0,147,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nelson Peterson',0,148,5,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Chris Hood',0,150,5,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Birgit Hyatt',0,151,5,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Julia Lee',0,152,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Karl-Heinz Clinton',0,153,7,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Karl-Heinz Koh',0,154,2,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'James McDonald',0,155,2,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Scott Steiner',0,156,2,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Pamela Keller',0,157,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mej-Yu Oey',0,158,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Peter Kandinski',0,159,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Oleg Jauch',0,160,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andre Hunt',0,162,2,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mary South',0,163,2,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Kiamalise Il',0,164,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Claudia Graf',0,165,5,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe Putin',0,166,7,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charlotte Kayal',0,169,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Laura Hood',0,167,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Phillip South',0,168,4,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sophia N\'Gong',0,170,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Erik Taylor',0,171,4,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mailin Hyatt',0,172,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Hillary North',0,173,5,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Robert Kayal',0,174,7,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Paul Alesi',0,175,7,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Max Steel',0,176,9,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Mira Gates',0,177,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Michael Mueller',0,179,7,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sandra Papadopolus',0,180,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Thomas Lau',0,181,7,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Marcus Jauch',0,182,7,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andre West',0,183,7,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nicoletta Zmak',0,184,7,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nelson Bullock',0,185,7,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Diana Liedke',0,186,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sue Govanni',0,187,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Kelly McLeod',0,188,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Hildon',0,189,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Brigitte Lee',0,190,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Bart Jauch',0,191,7,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe South',0,192,9,'p7.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Erik North',0,193,9,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Victoria Kayal',0,194,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Scott Clinton',0,195,7,'p1.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nicole Mandela',0,196,2,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Juli Graf',0,197,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sue Keller',0,198,2,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Sandra McDonald',0,199,4,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej Harrison',0,200,2,'p4.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Aaron Kandinski',0,201,2,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej East',0,202,2,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Nelson Mueller',0,203,9,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Bart Thoma',0,204,4,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Joe-Ann Koh',0,205,7,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Vladimir Muyomi',0,206,2,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Claudia McFurley',0,207,9,'p6.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Charles Campbell',0,208,9,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Kevin Kohl',0,209,2,'p5.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Andrej McAllister',0,210,2,'p3.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Bart Hood',175,211,2,'p8.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Ian Marshall',0,212,7,'p9.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);
INSERT INTO admirals VALUES (0,'Kim Hunt',0,213,9,'p2.jpg',20,20,20,20,NULL,NULL,NULL,NULL,0);

--
-- Table structure for table 'ads'
--

DROP TABLE IF EXISTS ads;
CREATE TABLE ads (
  image varchar(255) default NULL,
  link varchar(255) default NULL,
  hits int(11) default '0',
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'ads'
--


INSERT INTO ads VALUES ('http://www.spaceregents.de/images/add_banner.jpg','http://www.spaceregents.de',0,1);

--
-- Table structure for table 'alliance'
--

DROP TABLE IF EXISTS alliance;
CREATE TABLE alliance (
  name varchar(255) default NULL,
  leader int(11) NOT NULL default '0',
  id int(11) NOT NULL auto_increment,
  last_vote datetime default NULL,
  vote_interval tinyint(4) default NULL,
  color varchar(7) default '#FF00FF',
  picture varchar(255) default NULL,
  info blob,
  url varchar(255) default NULL,
  milminister int(11) NOT NULL default '0',
  devminister int(11) NOT NULL default '0',
  forminister int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'alliance'
--


INSERT INTO alliance VALUES ('Hund',1,1,'2003-04-03 00:00:00',10,'#663300',NULL,NULL,NULL,7,0,3);
INSERT INTO alliance VALUES ('Out Of Order',9,2,'2003-04-09 00:00:00',10,'#66cc00','http://www.erik.oey.de/bilder/entrance.jpg','We are a alliance of idiots! Only idiots are being accepted as full members. In order to join you must prove your idiotic existance by doing something extraordinary idiotic.',NULL,5,2,0);

--
-- Table structure for table 'battlereports'
--

DROP TABLE IF EXISTS battlereports;
CREATE TABLE battlereports (
  uid int(11) default NULL,
  pid int(11) default NULL,
  sid int(11) default NULL,
  report text,
  time timestamp(14) NOT NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'battlereports'
--



--
-- Table structure for table 'buddies'
--

DROP TABLE IF EXISTS buddies;
CREATE TABLE buddies (
  uid int(11) NOT NULL default '0',
  fuid int(11) NOT NULL default '0',
  KEY uid (uid),
  KEY fuid (fuid)
) TYPE=MyISAM;

--
-- Dumping data for table 'buddies'
--


INSERT INTO buddies VALUES (2,4);
INSERT INTO buddies VALUES (4,2);
INSERT INTO buddies VALUES (5,4);
INSERT INTO buddies VALUES (4,5);
INSERT INTO buddies VALUES (5,2);
INSERT INTO buddies VALUES (2,5);
INSERT INTO buddies VALUES (1,4);
INSERT INTO buddies VALUES (4,1);
INSERT INTO buddies VALUES (1,2);
INSERT INTO buddies VALUES (2,1);
INSERT INTO buddies VALUES (1,5);
INSERT INTO buddies VALUES (5,1);
INSERT INTO buddies VALUES (4,6);
INSERT INTO buddies VALUES (6,4);
INSERT INTO buddies VALUES (9,4);
INSERT INTO buddies VALUES (4,9);
INSERT INTO buddies VALUES (7,1);
INSERT INTO buddies VALUES (1,7);
INSERT INTO buddies VALUES (7,4);
INSERT INTO buddies VALUES (4,7);
INSERT INTO buddies VALUES (8,4);
INSERT INTO buddies VALUES (4,8);
INSERT INTO buddies VALUES (8,1);
INSERT INTO buddies VALUES (1,8);
INSERT INTO buddies VALUES (2,9);
INSERT INTO buddies VALUES (9,2);
INSERT INTO buddies VALUES (1,9);
INSERT INTO buddies VALUES (9,1);
INSERT INTO buddies VALUES (5,9);
INSERT INTO buddies VALUES (9,5);

--
-- Table structure for table 'buddy_invite'
--

DROP TABLE IF EXISTS buddy_invite;
CREATE TABLE buddy_invite (
  uid int(11) NOT NULL default '0',
  fuid int(11) NOT NULL default '0',
  KEY uid (uid,fuid),
  KEY fuid (fuid)
) TYPE=MyISAM;

--
-- Dumping data for table 'buddy_invite'
--


INSERT INTO buddy_invite VALUES (1,3);
INSERT INTO buddy_invite VALUES (4,3);

--
-- Table structure for table 'buddy_msg'
--

DROP TABLE IF EXISTS buddy_msg;
CREATE TABLE buddy_msg (
  uid int(11) NOT NULL default '0',
  fuid int(11) NOT NULL default '0',
  message varchar(255) default NULL,
  time timestamp(14) NOT NULL,
  KEY uid (uid),
  KEY fuid (fuid)
) TYPE=MyISAM;

--
-- Dumping data for table 'buddy_msg'
--



--
-- Table structure for table 'bughunters'
--

DROP TABLE IF EXISTS bughunters;
CREATE TABLE bughunters (
  id int(11) NOT NULL auto_increment,
  uid int(11) NOT NULL default '0',
  developer tinyint(1) default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'bughunters'
--


INSERT INTO bughunters VALUES (1,1,1);
INSERT INTO bughunters VALUES (2,2,0);
INSERT INTO bughunters VALUES (3,3,0);
INSERT INTO bughunters VALUES (4,4,1);
INSERT INTO bughunters VALUES (5,5,0);
INSERT INTO bughunters VALUES (6,6,0);
INSERT INTO bughunters VALUES (7,7,0);
INSERT INTO bughunters VALUES (8,8,0);
INSERT INTO bughunters VALUES (9,9,0);

--
-- Table structure for table 'buildings'
--

DROP TABLE IF EXISTS buildings;
CREATE TABLE buildings (
  pid int(11) NOT NULL default '0',
  prod_id int(11) default NULL,
  KEY pid (pid)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'buildings'
--


INSERT INTO buildings VALUES (30,53);
INSERT INTO buildings VALUES (109,53);
INSERT INTO buildings VALUES (109,60);
INSERT INTO buildings VALUES (30,4);
INSERT INTO buildings VALUES (30,5);
INSERT INTO buildings VALUES (30,60);
INSERT INTO buildings VALUES (109,1);
INSERT INTO buildings VALUES (30,1);
INSERT INTO buildings VALUES (109,4);
INSERT INTO buildings VALUES (109,5);
INSERT INTO buildings VALUES (205,53);
INSERT INTO buildings VALUES (109,46);
INSERT INTO buildings VALUES (205,60);
INSERT INTO buildings VALUES (205,1);
INSERT INTO buildings VALUES (109,23);
INSERT INTO buildings VALUES (254,53);
INSERT INTO buildings VALUES (205,4);
INSERT INTO buildings VALUES (254,4);
INSERT INTO buildings VALUES (294,53);
INSERT INTO buildings VALUES (254,60);
INSERT INTO buildings VALUES (34,4);
INSERT INTO buildings VALUES (439,53);
INSERT INTO buildings VALUES (34,53);
INSERT INTO buildings VALUES (415,53);
INSERT INTO buildings VALUES (352,53);
INSERT INTO buildings VALUES (352,60);
INSERT INTO buildings VALUES (109,63);
INSERT INTO buildings VALUES (415,60);
INSERT INTO buildings VALUES (439,60);
INSERT INTO buildings VALUES (89,53);
INSERT INTO buildings VALUES (109,15);
INSERT INTO buildings VALUES (415,4);
INSERT INTO buildings VALUES (89,4);
INSERT INTO buildings VALUES (205,5);
INSERT INTO buildings VALUES (109,19);
INSERT INTO buildings VALUES (205,13);
INSERT INTO buildings VALUES (352,5);
INSERT INTO buildings VALUES (89,19);
INSERT INTO buildings VALUES (439,1);
INSERT INTO buildings VALUES (415,1);
INSERT INTO buildings VALUES (89,5);
INSERT INTO buildings VALUES (207,1);
INSERT INTO buildings VALUES (207,53);
INSERT INTO buildings VALUES (439,4);
INSERT INTO buildings VALUES (89,60);
INSERT INTO buildings VALUES (439,5);
INSERT INTO buildings VALUES (294,60);
INSERT INTO buildings VALUES (207,4);
INSERT INTO buildings VALUES (109,13);
INSERT INTO buildings VALUES (294,4);
INSERT INTO buildings VALUES (294,1);
INSERT INTO buildings VALUES (89,63);
INSERT INTO buildings VALUES (6,4);
INSERT INTO buildings VALUES (415,5);
INSERT INTO buildings VALUES (352,4);
INSERT INTO buildings VALUES (205,23);
INSERT INTO buildings VALUES (207,63);
INSERT INTO buildings VALUES (207,5);
INSERT INTO buildings VALUES (416,65);
INSERT INTO buildings VALUES (352,1);
INSERT INTO buildings VALUES (439,23);
INSERT INTO buildings VALUES (380,65);
INSERT INTO buildings VALUES (352,19);
INSERT INTO buildings VALUES (149,65);
INSERT INTO buildings VALUES (416,53);
INSERT INTO buildings VALUES (380,4);
INSERT INTO buildings VALUES (380,53);
INSERT INTO buildings VALUES (149,53);
INSERT INTO buildings VALUES (439,19);
INSERT INTO buildings VALUES (30,63);
INSERT INTO buildings VALUES (195,65);
INSERT INTO buildings VALUES (416,4);
INSERT INTO buildings VALUES (415,11);
INSERT INTO buildings VALUES (195,53);
INSERT INTO buildings VALUES (149,4);
INSERT INTO buildings VALUES (207,23);
INSERT INTO buildings VALUES (97,65);
INSERT INTO buildings VALUES (83,53);
INSERT INTO buildings VALUES (439,63);
INSERT INTO buildings VALUES (89,46);
INSERT INTO buildings VALUES (182,65);
INSERT INTO buildings VALUES (89,1);
INSERT INTO buildings VALUES (205,19);
INSERT INTO buildings VALUES (182,4);
INSERT INTO buildings VALUES (439,13);
INSERT INTO buildings VALUES (30,23);
INSERT INTO buildings VALUES (182,1);
INSERT INTO buildings VALUES (207,19);
INSERT INTO buildings VALUES (149,63);
INSERT INTO buildings VALUES (68,65);
INSERT INTO buildings VALUES (182,60);
INSERT INTO buildings VALUES (195,63);
INSERT INTO buildings VALUES (416,5);
INSERT INTO buildings VALUES (68,53);
INSERT INTO buildings VALUES (97,60);
INSERT INTO buildings VALUES (260,65);
INSERT INTO buildings VALUES (68,4);
INSERT INTO buildings VALUES (97,4);
INSERT INTO buildings VALUES (195,4);
INSERT INTO buildings VALUES (260,1);
INSERT INTO buildings VALUES (416,60);
INSERT INTO buildings VALUES (170,53);
INSERT INTO buildings VALUES (182,5);
INSERT INTO buildings VALUES (34,23);
INSERT INTO buildings VALUES (6,23);
INSERT INTO buildings VALUES (260,60);
INSERT INTO buildings VALUES (441,65);
INSERT INTO buildings VALUES (441,53);
INSERT INTO buildings VALUES (260,53);
INSERT INTO buildings VALUES (97,53);
INSERT INTO buildings VALUES (352,63);
INSERT INTO buildings VALUES (441,4);
INSERT INTO buildings VALUES (30,46);
INSERT INTO buildings VALUES (149,23);
INSERT INTO buildings VALUES (182,21);
INSERT INTO buildings VALUES (149,60);
INSERT INTO buildings VALUES (380,63);
INSERT INTO buildings VALUES (195,23);
INSERT INTO buildings VALUES (97,5);
INSERT INTO buildings VALUES (337,65);
INSERT INTO buildings VALUES (68,63);
INSERT INTO buildings VALUES (376,65);
INSERT INTO buildings VALUES (34,63);
INSERT INTO buildings VALUES (170,60);
INSERT INTO buildings VALUES (376,53);
INSERT INTO buildings VALUES (182,19);
INSERT INTO buildings VALUES (364,65);
INSERT INTO buildings VALUES (376,4);
INSERT INTO buildings VALUES (205,63);
INSERT INTO buildings VALUES (260,63);
INSERT INTO buildings VALUES (364,53);
INSERT INTO buildings VALUES (441,23);
INSERT INTO buildings VALUES (439,15);
INSERT INTO buildings VALUES (364,1);
INSERT INTO buildings VALUES (205,21);
INSERT INTO buildings VALUES (109,26);
INSERT INTO buildings VALUES (364,60);
INSERT INTO buildings VALUES (341,65);
INSERT INTO buildings VALUES (337,53);
INSERT INTO buildings VALUES (416,1);
INSERT INTO buildings VALUES (89,23);
INSERT INTO buildings VALUES (341,53);
INSERT INTO buildings VALUES (364,4);
INSERT INTO buildings VALUES (260,5);
INSERT INTO buildings VALUES (380,23);
INSERT INTO buildings VALUES (170,1);
INSERT INTO buildings VALUES (341,4);
INSERT INTO buildings VALUES (89,27);
INSERT INTO buildings VALUES (260,4);
INSERT INTO buildings VALUES (415,19);
INSERT INTO buildings VALUES (337,19);
INSERT INTO buildings VALUES (416,19);
INSERT INTO buildings VALUES (440,65);
INSERT INTO buildings VALUES (337,5);
INSERT INTO buildings VALUES (441,63);
INSERT INTO buildings VALUES (352,26);
INSERT INTO buildings VALUES (337,1);
INSERT INTO buildings VALUES (182,26);
INSERT INTO buildings VALUES (440,4);
INSERT INTO buildings VALUES (260,13);
INSERT INTO buildings VALUES (53,65);
INSERT INTO buildings VALUES (441,1);
INSERT INTO buildings VALUES (56,65);
INSERT INTO buildings VALUES (337,4);
INSERT INTO buildings VALUES (440,1);
INSERT INTO buildings VALUES (260,21);
INSERT INTO buildings VALUES (53,53);
INSERT INTO buildings VALUES (376,23);
INSERT INTO buildings VALUES (56,53);
INSERT INTO buildings VALUES (364,23);
INSERT INTO buildings VALUES (337,60);
INSERT INTO buildings VALUES (352,21);
INSERT INTO buildings VALUES (419,65);
INSERT INTO buildings VALUES (439,22);
INSERT INTO buildings VALUES (53,4);
INSERT INTO buildings VALUES (56,4);
INSERT INTO buildings VALUES (6,60);
INSERT INTO buildings VALUES (267,65);
INSERT INTO buildings VALUES (441,60);
INSERT INTO buildings VALUES (207,21);
INSERT INTO buildings VALUES (260,19);
INSERT INTO buildings VALUES (376,19);
INSERT INTO buildings VALUES (116,65);
INSERT INTO buildings VALUES (83,65);
INSERT INTO buildings VALUES (369,65);
INSERT INTO buildings VALUES (89,11);
INSERT INTO buildings VALUES (369,53);
INSERT INTO buildings VALUES (83,60);
INSERT INTO buildings VALUES (441,5);
INSERT INTO buildings VALUES (341,63);
INSERT INTO buildings VALUES (369,4);
INSERT INTO buildings VALUES (83,4);
INSERT INTO buildings VALUES (6,1);
INSERT INTO buildings VALUES (364,63);
INSERT INTO buildings VALUES (68,60);
INSERT INTO buildings VALUES (116,4);
INSERT INTO buildings VALUES (97,23);
INSERT INTO buildings VALUES (440,23);
INSERT INTO buildings VALUES (441,22);
INSERT INTO buildings VALUES (116,60);
INSERT INTO buildings VALUES (440,60);
INSERT INTO buildings VALUES (116,53);
INSERT INTO buildings VALUES (364,5);
INSERT INTO buildings VALUES (440,5);
INSERT INTO buildings VALUES (408,65);
INSERT INTO buildings VALUES (380,19);
INSERT INTO buildings VALUES (260,26);
INSERT INTO buildings VALUES (352,23);
INSERT INTO buildings VALUES (408,53);
INSERT INTO buildings VALUES (441,19);
INSERT INTO buildings VALUES (331,65);
INSERT INTO buildings VALUES (366,65);
INSERT INTO buildings VALUES (494,65);
INSERT INTO buildings VALUES (408,4);
INSERT INTO buildings VALUES (494,4);
INSERT INTO buildings VALUES (380,60);
INSERT INTO buildings VALUES (439,21);
INSERT INTO buildings VALUES (331,53);
INSERT INTO buildings VALUES (440,19);
INSERT INTO buildings VALUES (376,63);
INSERT INTO buildings VALUES (341,23);
INSERT INTO buildings VALUES (83,63);
INSERT INTO buildings VALUES (369,23);
INSERT INTO buildings VALUES (440,53);
INSERT INTO buildings VALUES (366,4);
INSERT INTO buildings VALUES (195,60);
INSERT INTO buildings VALUES (56,60);
INSERT INTO buildings VALUES (42,60);
INSERT INTO buildings VALUES (331,60);
INSERT INTO buildings VALUES (42,1);
INSERT INTO buildings VALUES (440,22);
INSERT INTO buildings VALUES (366,60);
INSERT INTO buildings VALUES (380,1);
INSERT INTO buildings VALUES (331,4);
INSERT INTO buildings VALUES (494,19);
INSERT INTO buildings VALUES (380,21);
INSERT INTO buildings VALUES (17,65);
INSERT INTO buildings VALUES (260,23);
INSERT INTO buildings VALUES (494,22);
INSERT INTO buildings VALUES (364,46);
INSERT INTO buildings VALUES (267,1);
INSERT INTO buildings VALUES (341,19);
INSERT INTO buildings VALUES (255,65);
INSERT INTO buildings VALUES (252,65);
INSERT INTO buildings VALUES (251,65);
INSERT INTO buildings VALUES (450,65);
INSERT INTO buildings VALUES (207,56);
INSERT INTO buildings VALUES (182,56);
INSERT INTO buildings VALUES (205,56);
INSERT INTO buildings VALUES (251,53);
INSERT INTO buildings VALUES (494,5);
INSERT INTO buildings VALUES (260,56);
INSERT INTO buildings VALUES (450,4);
INSERT INTO buildings VALUES (255,4);
INSERT INTO buildings VALUES (408,23);
INSERT INTO buildings VALUES (252,4);
INSERT INTO buildings VALUES (341,60);
INSERT INTO buildings VALUES (426,65);
INSERT INTO buildings VALUES (17,53);
INSERT INTO buildings VALUES (441,13);
INSERT INTO buildings VALUES (55,65);
INSERT INTO buildings VALUES (494,60);
INSERT INTO buildings VALUES (116,63);
INSERT INTO buildings VALUES (53,63);
INSERT INTO buildings VALUES (17,1);
INSERT INTO buildings VALUES (426,53);
INSERT INTO buildings VALUES (34,60);
INSERT INTO buildings VALUES (494,1);
INSERT INTO buildings VALUES (83,23);
INSERT INTO buildings VALUES (450,60);
INSERT INTO buildings VALUES (341,1);
INSERT INTO buildings VALUES (56,63);
INSERT INTO buildings VALUES (34,1);
INSERT INTO buildings VALUES (17,60);
INSERT INTO buildings VALUES (254,11);
INSERT INTO buildings VALUES (450,1);
INSERT INTO buildings VALUES (55,4);
INSERT INTO buildings VALUES (83,5);
INSERT INTO buildings VALUES (17,4);
INSERT INTO buildings VALUES (55,60);
INSERT INTO buildings VALUES (356,65);
INSERT INTO buildings VALUES (426,60);
INSERT INTO buildings VALUES (55,1);
INSERT INTO buildings VALUES (356,1);
INSERT INTO buildings VALUES (406,65);
INSERT INTO buildings VALUES (341,5);
INSERT INTO buildings VALUES (406,53);
INSERT INTO buildings VALUES (170,4);
INSERT INTO buildings VALUES (426,4);
INSERT INTO buildings VALUES (493,65);
INSERT INTO buildings VALUES (406,60);
INSERT INTO buildings VALUES (83,19);
INSERT INTO buildings VALUES (349,65);
INSERT INTO buildings VALUES (369,63);
INSERT INTO buildings VALUES (426,1);
INSERT INTO buildings VALUES (83,46);
INSERT INTO buildings VALUES (408,63);
INSERT INTO buildings VALUES (331,23);
INSERT INTO buildings VALUES (261,65);
INSERT INTO buildings VALUES (493,1);
INSERT INTO buildings VALUES (349,4);
INSERT INTO buildings VALUES (406,5);
INSERT INTO buildings VALUES (116,23);
INSERT INTO buildings VALUES (261,53);
INSERT INTO buildings VALUES (53,23);
INSERT INTO buildings VALUES (53,1);
INSERT INTO buildings VALUES (261,1);
INSERT INTO buildings VALUES (494,23);
INSERT INTO buildings VALUES (260,15);
INSERT INTO buildings VALUES (406,4);
INSERT INTO buildings VALUES (68,5);
INSERT INTO buildings VALUES (56,23);
INSERT INTO buildings VALUES (261,4);
INSERT INTO buildings VALUES (53,60);
INSERT INTO buildings VALUES (343,65);
INSERT INTO buildings VALUES (341,22);
INSERT INTO buildings VALUES (343,4);
INSERT INTO buildings VALUES (276,65);
INSERT INTO buildings VALUES (275,65);
INSERT INTO buildings VALUES (270,65);
INSERT INTO buildings VALUES (55,23);
INSERT INTO buildings VALUES (465,65);
INSERT INTO buildings VALUES (341,21);
INSERT INTO buildings VALUES (343,21);
INSERT INTO buildings VALUES (331,63);
INSERT INTO buildings VALUES (400,65);
INSERT INTO buildings VALUES (397,65);
INSERT INTO buildings VALUES (465,53);
INSERT INTO buildings VALUES (102,65);
INSERT INTO buildings VALUES (332,65);
INSERT INTO buildings VALUES (102,53);
INSERT INTO buildings VALUES (400,53);
INSERT INTO buildings VALUES (450,23);
INSERT INTO buildings VALUES (200,65);
INSERT INTO buildings VALUES (397,4);
INSERT INTO buildings VALUES (244,65);
INSERT INTO buildings VALUES (261,19);
INSERT INTO buildings VALUES (267,19);
INSERT INTO buildings VALUES (465,4);
INSERT INTO buildings VALUES (426,23);
INSERT INTO buildings VALUES (420,65);
INSERT INTO buildings VALUES (97,46);
INSERT INTO buildings VALUES (389,65);
INSERT INTO buildings VALUES (406,23);
INSERT INTO buildings VALUES (420,53);
INSERT INTO buildings VALUES (424,65);
INSERT INTO buildings VALUES (102,19);
INSERT INTO buildings VALUES (275,53);
INSERT INTO buildings VALUES (424,53);
INSERT INTO buildings VALUES (244,53);
INSERT INTO buildings VALUES (200,53);
INSERT INTO buildings VALUES (426,5);
INSERT INTO buildings VALUES (269,65);
INSERT INTO buildings VALUES (389,4);
INSERT INTO buildings VALUES (420,1);
INSERT INTO buildings VALUES (276,4);
INSERT INTO buildings VALUES (270,4);
INSERT INTO buildings VALUES (481,65);
INSERT INTO buildings VALUES (424,1);
INSERT INTO buildings VALUES (102,60);
INSERT INTO buildings VALUES (493,60);
INSERT INTO buildings VALUES (425,65);
INSERT INTO buildings VALUES (420,4);
INSERT INTO buildings VALUES (424,4);
INSERT INTO buildings VALUES (102,5);
INSERT INTO buildings VALUES (343,23);
INSERT INTO buildings VALUES (406,19);
INSERT INTO buildings VALUES (376,1);
INSERT INTO buildings VALUES (419,1);
INSERT INTO buildings VALUES (366,23);
INSERT INTO buildings VALUES (420,22);
INSERT INTO buildings VALUES (349,23);
INSERT INTO buildings VALUES (425,4);
INSERT INTO buildings VALUES (381,65);
INSERT INTO buildings VALUES (102,4);
INSERT INTO buildings VALUES (389,1);
INSERT INTO buildings VALUES (332,4);
INSERT INTO buildings VALUES (381,53);
INSERT INTO buildings VALUES (481,53);
INSERT INTO buildings VALUES (376,22);
INSERT INTO buildings VALUES (465,1);
INSERT INTO buildings VALUES (498,65);
INSERT INTO buildings VALUES (352,22);
INSERT INTO buildings VALUES (498,53);
INSERT INTO buildings VALUES (408,19);
INSERT INTO buildings VALUES (481,60);
INSERT INTO buildings VALUES (424,19);
INSERT INTO buildings VALUES (255,23);
INSERT INTO buildings VALUES (251,63);
INSERT INTO buildings VALUES (254,63);
INSERT INTO buildings VALUES (252,23);
INSERT INTO buildings VALUES (349,19);
INSERT INTO buildings VALUES (420,19);
INSERT INTO buildings VALUES (269,53);
INSERT INTO buildings VALUES (115,65);
INSERT INTO buildings VALUES (414,65);
INSERT INTO buildings VALUES (389,19);
INSERT INTO buildings VALUES (426,63);
INSERT INTO buildings VALUES (414,53);
INSERT INTO buildings VALUES (415,23);
INSERT INTO buildings VALUES (416,23);
INSERT INTO buildings VALUES (276,23);
INSERT INTO buildings VALUES (270,23);
INSERT INTO buildings VALUES (337,63);
INSERT INTO buildings VALUES (406,63);
INSERT INTO buildings VALUES (192,65);
INSERT INTO buildings VALUES (226,65);
INSERT INTO buildings VALUES (225,65);
INSERT INTO buildings VALUES (242,65);
INSERT INTO buildings VALUES (493,4);
INSERT INTO buildings VALUES (425,23);
INSERT INTO buildings VALUES (441,21);
INSERT INTO buildings VALUES (450,5);
INSERT INTO buildings VALUES (425,22);
INSERT INTO buildings VALUES (424,63);
INSERT INTO buildings VALUES (394,65);
INSERT INTO buildings VALUES (102,23);
INSERT INTO buildings VALUES (284,65);
INSERT INTO buildings VALUES (200,63);
INSERT INTO buildings VALUES (275,63);
INSERT INTO buildings VALUES (244,63);
INSERT INTO buildings VALUES (284,53);
INSERT INTO buildings VALUES (254,23);
INSERT INTO buildings VALUES (481,63);
INSERT INTO buildings VALUES (465,63);
INSERT INTO buildings VALUES (420,63);
INSERT INTO buildings VALUES (424,22);
INSERT INTO buildings VALUES (406,46);
INSERT INTO buildings VALUES (446,65);
INSERT INTO buildings VALUES (440,21);
INSERT INTO buildings VALUES (414,63);
INSERT INTO buildings VALUES (493,5);
INSERT INTO buildings VALUES (269,63);
INSERT INTO buildings VALUES (425,19);
INSERT INTO buildings VALUES (337,23);
INSERT INTO buildings VALUES (415,63);
INSERT INTO buildings VALUES (414,22);
INSERT INTO buildings VALUES (498,63);
INSERT INTO buildings VALUES (254,1);
INSERT INTO buildings VALUES (270,1);
INSERT INTO buildings VALUES (109,22);
INSERT INTO buildings VALUES (450,19);
INSERT INTO buildings VALUES (369,1);
INSERT INTO buildings VALUES (349,1);
INSERT INTO buildings VALUES (446,1);
INSERT INTO buildings VALUES (74,65);
INSERT INTO buildings VALUES (464,65);
INSERT INTO buildings VALUES (481,4);
INSERT INTO buildings VALUES (498,4);
INSERT INTO buildings VALUES (376,5);
INSERT INTO buildings VALUES (446,60);
INSERT INTO buildings VALUES (498,1);
INSERT INTO buildings VALUES (446,53);
INSERT INTO buildings VALUES (369,5);
INSERT INTO buildings VALUES (102,63);
INSERT INTO buildings VALUES (414,19);
INSERT INTO buildings VALUES (376,60);
INSERT INTO buildings VALUES (420,23);
INSERT INTO buildings VALUES (446,4);
INSERT INTO buildings VALUES (369,60);
INSERT INTO buildings VALUES (239,65);
INSERT INTO buildings VALUES (424,23);
INSERT INTO buildings VALUES (102,22);
INSERT INTO buildings VALUES (74,4);
INSERT INTO buildings VALUES (376,21);
INSERT INTO buildings VALUES (244,4);
INSERT INTO buildings VALUES (356,60);
INSERT INTO buildings VALUES (464,4);
INSERT INTO buildings VALUES (465,60);
INSERT INTO buildings VALUES (440,13);
INSERT INTO buildings VALUES (74,22);
INSERT INTO buildings VALUES (464,60);
INSERT INTO buildings VALUES (284,63);
INSERT INTO buildings VALUES (426,26);
INSERT INTO buildings VALUES (361,65);
INSERT INTO buildings VALUES (74,60);
INSERT INTO buildings VALUES (464,1);
INSERT INTO buildings VALUES (464,53);
INSERT INTO buildings VALUES (481,1);
INSERT INTO buildings VALUES (498,60);
INSERT INTO buildings VALUES (340,65);
INSERT INTO buildings VALUES (426,22);
INSERT INTO buildings VALUES (74,5);
INSERT INTO buildings VALUES (378,65);
INSERT INTO buildings VALUES (102,46);
INSERT INTO buildings VALUES (426,21);
INSERT INTO buildings VALUES (322,65);
INSERT INTO buildings VALUES (437,65);
INSERT INTO buildings VALUES (436,65);
INSERT INTO buildings VALUES (446,23);
INSERT INTO buildings VALUES (340,53);
INSERT INTO buildings VALUES (482,65);
INSERT INTO buildings VALUES (334,65);
INSERT INTO buildings VALUES (334,1);
INSERT INTO buildings VALUES (356,26);
INSERT INTO buildings VALUES (378,4);
INSERT INTO buildings VALUES (426,19);
INSERT INTO buildings VALUES (334,60);
INSERT INTO buildings VALUES (284,4);
INSERT INTO buildings VALUES (465,23);
INSERT INTO buildings VALUES (493,23);
INSERT INTO buildings VALUES (406,25);
INSERT INTO buildings VALUES (115,4);
INSERT INTO buildings VALUES (464,23);
INSERT INTO buildings VALUES (334,5);
INSERT INTO buildings VALUES (481,23);
INSERT INTO buildings VALUES (429,65);
INSERT INTO buildings VALUES (30,36);
INSERT INTO buildings VALUES (465,5);
INSERT INTO buildings VALUES (498,23);
INSERT INTO buildings VALUES (436,36);
INSERT INTO buildings VALUES (242,53);
INSERT INTO buildings VALUES (436,1);
INSERT INTO buildings VALUES (481,5);
INSERT INTO buildings VALUES (242,4);
INSERT INTO buildings VALUES (498,5);
INSERT INTO buildings VALUES (16,65);
INSERT INTO buildings VALUES (435,65);
INSERT INTO buildings VALUES (53,36);
INSERT INTO buildings VALUES (334,19);
INSERT INTO buildings VALUES (415,15);
INSERT INTO buildings VALUES (446,63);
INSERT INTO buildings VALUES (416,15);
INSERT INTO buildings VALUES (337,15);
INSERT INTO buildings VALUES (340,63);
INSERT INTO buildings VALUES (16,53);
INSERT INTO buildings VALUES (435,53);
INSERT INTO buildings VALUES (429,53);
INSERT INTO buildings VALUES (348,65);
INSERT INTO buildings VALUES (334,21);
INSERT INTO buildings VALUES (244,23);
INSERT INTO buildings VALUES (378,23);
INSERT INTO buildings VALUES (446,5);
INSERT INTO buildings VALUES (415,22);
INSERT INTO buildings VALUES (369,19);
INSERT INTO buildings VALUES (348,4);
INSERT INTO buildings VALUES (352,13);
INSERT INTO buildings VALUES (334,22);
INSERT INTO buildings VALUES (446,13);
INSERT INTO buildings VALUES (464,63);
INSERT INTO buildings VALUES (369,22);
INSERT INTO buildings VALUES (348,22);
INSERT INTO buildings VALUES (482,1);
INSERT INTO buildings VALUES (334,4);
INSERT INTO buildings VALUES (340,19);
INSERT INTO buildings VALUES (122,65);
INSERT INTO buildings VALUES (419,60);
INSERT INTO buildings VALUES (429,60);
INSERT INTO buildings VALUES (332,60);
INSERT INTO buildings VALUES (482,60);
INSERT INTO buildings VALUES (369,21);
INSERT INTO buildings VALUES (109,36);
INSERT INTO buildings VALUES (340,22);
INSERT INTO buildings VALUES (457,65);
INSERT INTO buildings VALUES (482,4);
INSERT INTO buildings VALUES (483,65);
INSERT INTO buildings VALUES (421,65);
INSERT INTO buildings VALUES (483,1);
INSERT INTO buildings VALUES (340,21);
INSERT INTO buildings VALUES (408,1);
INSERT INTO buildings VALUES (63,53);
INSERT INTO buildings VALUES (421,4);
INSERT INTO buildings VALUES (261,21);
INSERT INTO buildings VALUES (267,56);
INSERT INTO buildings VALUES (242,56);
INSERT INTO buildings VALUES (408,22);
INSERT INTO buildings VALUES (457,53);
INSERT INTO buildings VALUES (435,63);
INSERT INTO buildings VALUES (16,63);
INSERT INTO buildings VALUES (415,25);
INSERT INTO buildings VALUES (76,65);
INSERT INTO buildings VALUES (457,60);
INSERT INTO buildings VALUES (348,23);
INSERT INTO buildings VALUES (182,11);
INSERT INTO buildings VALUES (260,11);
INSERT INTO buildings VALUES (261,56);
INSERT INTO buildings VALUES (300,60);
INSERT INTO buildings VALUES (77,65);
INSERT INTO buildings VALUES (485,65);
INSERT INTO buildings VALUES (112,65);
INSERT INTO buildings VALUES (435,60);
INSERT INTO buildings VALUES (83,22);
INSERT INTO buildings VALUES (16,60);
INSERT INTO buildings VALUES (483,4);
INSERT INTO buildings VALUES (429,63);
INSERT INTO buildings VALUES (76,4);
INSERT INTO buildings VALUES (415,21);
INSERT INTO buildings VALUES (353,65);
INSERT INTO buildings VALUES (348,21);
INSERT INTO buildings VALUES (267,11);
INSERT INTO buildings VALUES (483,60);
INSERT INTO buildings VALUES (76,60);
INSERT INTO buildings VALUES (415,13);
INSERT INTO buildings VALUES (353,53);
INSERT INTO buildings VALUES (369,26);
INSERT INTO buildings VALUES (482,23);
INSERT INTO buildings VALUES (98,4);
INSERT INTO buildings VALUES (334,23);
INSERT INTO buildings VALUES (112,4);
INSERT INTO buildings VALUES (68,46);
INSERT INTO buildings VALUES (77,4);
INSERT INTO buildings VALUES (109,25);
INSERT INTO buildings VALUES (76,5);
INSERT INTO buildings VALUES (207,26);
INSERT INTO buildings VALUES (205,26);
INSERT INTO buildings VALUES (428,65);
INSERT INTO buildings VALUES (421,23);
INSERT INTO buildings VALUES (348,19);
INSERT INTO buildings VALUES (428,1);
INSERT INTO buildings VALUES (98,60);
INSERT INTO buildings VALUES (428,4);
INSERT INTO buildings VALUES (408,26);
INSERT INTO buildings VALUES (348,1);
INSERT INTO buildings VALUES (74,23);
INSERT INTO buildings VALUES (98,5);
INSERT INTO buildings VALUES (421,1);
INSERT INTO buildings VALUES (112,19);
INSERT INTO buildings VALUES (103,65);
INSERT INTO buildings VALUES (491,65);
INSERT INTO buildings VALUES (408,60);
INSERT INTO buildings VALUES (421,22);
INSERT INTO buildings VALUES (98,22);
INSERT INTO buildings VALUES (491,1);
INSERT INTO buildings VALUES (103,4);
INSERT INTO buildings VALUES (473,65);
INSERT INTO buildings VALUES (485,60);
INSERT INTO buildings VALUES (112,22);
INSERT INTO buildings VALUES (112,53);
INSERT INTO buildings VALUES (267,21);
INSERT INTO buildings VALUES (278,65);
INSERT INTO buildings VALUES (491,60);
INSERT INTO buildings VALUES (77,32);
INSERT INTO buildings VALUES (337,11);
INSERT INTO buildings VALUES (376,26);
INSERT INTO buildings VALUES (74,11);
INSERT INTO buildings VALUES (112,60);
INSERT INTO buildings VALUES (82,65);
INSERT INTO buildings VALUES (353,63);
INSERT INTO buildings VALUES (491,4);
INSERT INTO buildings VALUES (92,65);
INSERT INTO buildings VALUES (393,65);
INSERT INTO buildings VALUES (66,65);
INSERT INTO buildings VALUES (393,53);
INSERT INTO buildings VALUES (242,19);
INSERT INTO buildings VALUES (408,21);
INSERT INTO buildings VALUES (421,19);
INSERT INTO buildings VALUES (205,11);
INSERT INTO buildings VALUES (100,1);
INSERT INTO buildings VALUES (450,22);
INSERT INTO buildings VALUES (464,22);
INSERT INTO buildings VALUES (446,22);
INSERT INTO buildings VALUES (465,22);
INSERT INTO buildings VALUES (481,22);
INSERT INTO buildings VALUES (482,22);
INSERT INTO buildings VALUES (485,22);
INSERT INTO buildings VALUES (491,22);
INSERT INTO buildings VALUES (493,22);
INSERT INTO buildings VALUES (353,21);
INSERT INTO buildings VALUES (414,21);
INSERT INTO buildings VALUES (349,22);
INSERT INTO buildings VALUES (380,22);
INSERT INTO buildings VALUES (421,21);
INSERT INTO buildings VALUES (109,56);
INSERT INTO buildings VALUES (408,5);
INSERT INTO buildings VALUES (473,4);
INSERT INTO buildings VALUES (457,63);
INSERT INTO buildings VALUES (473,1);
INSERT INTO buildings VALUES (406,56);
INSERT INTO buildings VALUES (278,1);
INSERT INTO buildings VALUES (392,65);
INSERT INTO buildings VALUES (98,32);
INSERT INTO buildings VALUES (392,53);
INSERT INTO buildings VALUES (66,4);
INSERT INTO buildings VALUES (439,11);
INSERT INTO buildings VALUES (353,22);
INSERT INTO buildings VALUES (74,46);
INSERT INTO buildings VALUES (16,25);
INSERT INTO buildings VALUES (261,63);
INSERT INTO buildings VALUES (441,15);
INSERT INTO buildings VALUES (406,22);
INSERT INTO buildings VALUES (440,15);
INSERT INTO buildings VALUES (485,53);
INSERT INTO buildings VALUES (260,36);
INSERT INTO buildings VALUES (205,36);
INSERT INTO buildings VALUES (392,21);
INSERT INTO buildings VALUES (468,65);
INSERT INTO buildings VALUES (16,5);
INSERT INTO buildings VALUES (483,5);
INSERT INTO buildings VALUES (482,5);
INSERT INTO buildings VALUES (473,22);
INSERT INTO buildings VALUES (464,5);
INSERT INTO buildings VALUES (16,1);
INSERT INTO buildings VALUES (428,23);
INSERT INTO buildings VALUES (341,26);
INSERT INTO buildings VALUES (182,36);
INSERT INTO buildings VALUES (66,19);
INSERT INTO buildings VALUES (66,53);
INSERT INTO buildings VALUES (353,19);
INSERT INTO buildings VALUES (464,13);
INSERT INTO buildings VALUES (412,65);
INSERT INTO buildings VALUES (342,65);
INSERT INTO buildings VALUES (342,53);
INSERT INTO buildings VALUES (412,53);
INSERT INTO buildings VALUES (353,1);
INSERT INTO buildings VALUES (242,1);
INSERT INTO buildings VALUES (337,25);
INSERT INTO buildings VALUES (406,36);
INSERT INTO buildings VALUES (393,63);
INSERT INTO buildings VALUES (468,60);
INSERT INTO buildings VALUES (450,15);
INSERT INTO buildings VALUES (468,1);
INSERT INTO buildings VALUES (446,15);
INSERT INTO buildings VALUES (242,21);
INSERT INTO buildings VALUES (334,26);
INSERT INTO buildings VALUES (337,22);
INSERT INTO buildings VALUES (16,11);
INSERT INTO buildings VALUES (468,4);
INSERT INTO buildings VALUES (242,60);
INSERT INTO buildings VALUES (450,13);
INSERT INTO buildings VALUES (337,21);
INSERT INTO buildings VALUES (393,21);
INSERT INTO buildings VALUES (428,19);
INSERT INTO buildings VALUES (406,27);
INSERT INTO buildings VALUES (439,26);
INSERT INTO buildings VALUES (16,13);
INSERT INTO buildings VALUES (382,65);
INSERT INTO buildings VALUES (428,21);
INSERT INTO buildings VALUES (450,21);
INSERT INTO buildings VALUES (92,33);
INSERT INTO buildings VALUES (392,63);
INSERT INTO buildings VALUES (393,22);
INSERT INTO buildings VALUES (337,13);
INSERT INTO buildings VALUES (92,60);
INSERT INTO buildings VALUES (473,19);
INSERT INTO buildings VALUES (468,19);
INSERT INTO buildings VALUES (428,22);
INSERT INTO buildings VALUES (483,19);
INSERT INTO buildings VALUES (464,19);
INSERT INTO buildings VALUES (465,19);
INSERT INTO buildings VALUES (482,19);
INSERT INTO buildings VALUES (446,19);
INSERT INTO buildings VALUES (481,19);
INSERT INTO buildings VALUES (485,63);
INSERT INTO buildings VALUES (92,5);
INSERT INTO buildings VALUES (382,19);
INSERT INTO buildings VALUES (16,19);
INSERT INTO buildings VALUES (372,65);
INSERT INTO buildings VALUES (485,4);
INSERT INTO buildings VALUES (446,21);
INSERT INTO buildings VALUES (406,15);
INSERT INTO buildings VALUES (211,65);
INSERT INTO buildings VALUES (393,19);
INSERT INTO buildings VALUES (92,4);
INSERT INTO buildings VALUES (16,21);
INSERT INTO buildings VALUES (342,63);
INSERT INTO buildings VALUES (412,63);
INSERT INTO buildings VALUES (382,22);
INSERT INTO buildings VALUES (242,36);
INSERT INTO buildings VALUES (372,4);
INSERT INTO buildings VALUES (392,19);
INSERT INTO buildings VALUES (16,22);
INSERT INTO buildings VALUES (382,21);
INSERT INTO buildings VALUES (409,65);
INSERT INTO buildings VALUES (392,22);
INSERT INTO buildings VALUES (465,21);
INSERT INTO buildings VALUES (412,19);
INSERT INTO buildings VALUES (342,19);
INSERT INTO buildings VALUES (468,23);
INSERT INTO buildings VALUES (440,26);
INSERT INTO buildings VALUES (491,23);
INSERT INTO buildings VALUES (373,65);
INSERT INTO buildings VALUES (332,1);
INSERT INTO buildings VALUES (450,11);
INSERT INTO buildings VALUES (373,53);
INSERT INTO buildings VALUES (412,22);
INSERT INTO buildings VALUES (332,53);
INSERT INTO buildings VALUES (342,22);
INSERT INTO buildings VALUES (412,1);
INSERT INTO buildings VALUES (375,65);
INSERT INTO buildings VALUES (342,21);
INSERT INTO buildings VALUES (464,11);
INSERT INTO buildings VALUES (332,27);
INSERT INTO buildings VALUES (473,23);
INSERT INTO buildings VALUES (446,26);
INSERT INTO buildings VALUES (428,26);
INSERT INTO buildings VALUES (372,23);
INSERT INTO buildings VALUES (441,26);
INSERT INTO buildings VALUES (375,4);
INSERT INTO buildings VALUES (372,19);
INSERT INTO buildings VALUES (108,65);
INSERT INTO buildings VALUES (337,26);
INSERT INTO buildings VALUES (16,26);
INSERT INTO buildings VALUES (373,63);
INSERT INTO buildings VALUES (440,11);
INSERT INTO buildings VALUES (439,25);
INSERT INTO buildings VALUES (493,19);
INSERT INTO buildings VALUES (498,19);
INSERT INTO buildings VALUES (382,33);
INSERT INTO buildings VALUES (491,19);
INSERT INTO buildings VALUES (82,4);
INSERT INTO buildings VALUES (77,60);
INSERT INTO buildings VALUES (464,15);
INSERT INTO buildings VALUES (16,27);
INSERT INTO buildings VALUES (108,4);
INSERT INTO buildings VALUES (337,27);
INSERT INTO buildings VALUES (68,13);
INSERT INTO buildings VALUES (83,56);
INSERT INTO buildings VALUES (332,26);
INSERT INTO buildings VALUES (108,60);
INSERT INTO buildings VALUES (16,4);
INSERT INTO buildings VALUES (375,23);
INSERT INTO buildings VALUES (108,1);
INSERT INTO buildings VALUES (103,60);
INSERT INTO buildings VALUES (68,56);
INSERT INTO buildings VALUES (441,11);
INSERT INTO buildings VALUES (446,11);
INSERT INTO buildings VALUES (66,5);
INSERT INTO buildings VALUES (373,19);
INSERT INTO buildings VALUES (102,56);
INSERT INTO buildings VALUES (66,60);
INSERT INTO buildings VALUES (373,22);
INSERT INTO buildings VALUES (74,32);
INSERT INTO buildings VALUES (76,32);
INSERT INTO buildings VALUES (356,33);
INSERT INTO buildings VALUES (373,21);
INSERT INTO buildings VALUES (409,33);
INSERT INTO buildings VALUES (375,19);
INSERT INTO buildings VALUES (335,65);
INSERT INTO buildings VALUES (450,26);
INSERT INTO buildings VALUES (74,56);
INSERT INTO buildings VALUES (352,38);
INSERT INTO buildings VALUES (426,38);
INSERT INTO buildings VALUES (409,21);
INSERT INTO buildings VALUES (375,21);
INSERT INTO buildings VALUES (77,23);
INSERT INTO buildings VALUES (350,65);
INSERT INTO buildings VALUES (377,65);
INSERT INTO buildings VALUES (98,23);
INSERT INTO buildings VALUES (409,22);
INSERT INTO buildings VALUES (284,23);
INSERT INTO buildings VALUES (375,22);
INSERT INTO buildings VALUES (335,1);
INSERT INTO buildings VALUES (77,5);
INSERT INTO buildings VALUES (485,1);
INSERT INTO buildings VALUES (465,11);
INSERT INTO buildings VALUES (464,26);
INSERT INTO buildings VALUES (108,23);
INSERT INTO buildings VALUES (350,4);
INSERT INTO buildings VALUES (82,32);
INSERT INTO buildings VALUES (493,21);
INSERT INTO buildings VALUES (377,4);
INSERT INTO buildings VALUES (494,21);
INSERT INTO buildings VALUES (498,22);
INSERT INTO buildings VALUES (473,15);
INSERT INTO buildings VALUES (211,1);
INSERT INTO buildings VALUES (482,15);
INSERT INTO buildings VALUES (491,5);
INSERT INTO buildings VALUES (481,15);
INSERT INTO buildings VALUES (253,65);
INSERT INTO buildings VALUES (257,65);
INSERT INTO buildings VALUES (332,25);
INSERT INTO buildings VALUES (272,65);
INSERT INTO buildings VALUES (464,21);
INSERT INTO buildings VALUES (278,5);
INSERT INTO buildings VALUES (108,21);
INSERT INTO buildings VALUES (485,5);
INSERT INTO buildings VALUES (82,5);
INSERT INTO buildings VALUES (66,63);
INSERT INTO buildings VALUES (428,60);
INSERT INTO buildings VALUES (465,13);
INSERT INTO buildings VALUES (211,5);
INSERT INTO buildings VALUES (468,11);
INSERT INTO buildings VALUES (409,19);
INSERT INTO buildings VALUES (278,56);
INSERT INTO buildings VALUES (98,46);
INSERT INTO buildings VALUES (211,56);
INSERT INTO buildings VALUES (278,60);
INSERT INTO buildings VALUES (491,21);
INSERT INTO buildings VALUES (408,38);
INSERT INTO buildings VALUES (369,38);
INSERT INTO buildings VALUES (446,25);
INSERT INTO buildings VALUES (441,25);
INSERT INTO buildings VALUES (440,25);
INSERT INTO buildings VALUES (439,30);
INSERT INTO buildings VALUES (426,36);
INSERT INTO buildings VALUES (428,38);
INSERT INTO buildings VALUES (483,23);
INSERT INTO buildings VALUES (414,1);
INSERT INTO buildings VALUES (425,1);
INSERT INTO buildings VALUES (481,11);
INSERT INTO buildings VALUES (473,11);
INSERT INTO buildings VALUES (334,38);
INSERT INTO buildings VALUES (108,19);
INSERT INTO buildings VALUES (82,60);
INSERT INTO buildings VALUES (89,22);
INSERT INTO buildings VALUES (211,19);
INSERT INTO buildings VALUES (76,22);
INSERT INTO buildings VALUES (428,5);
INSERT INTO buildings VALUES (465,15);
INSERT INTO buildings VALUES (424,26);
INSERT INTO buildings VALUES (350,23);
INSERT INTO buildings VALUES (377,23);
INSERT INTO buildings VALUES (483,22);
INSERT INTO buildings VALUES (450,25);
INSERT INTO buildings VALUES (332,23);
INSERT INTO buildings VALUES (468,13);
INSERT INTO buildings VALUES (211,60);
INSERT INTO buildings VALUES (439,36);
INSERT INTO buildings VALUES (66,23);
INSERT INTO buildings VALUES (89,56);
INSERT INTO buildings VALUES (332,22);
INSERT INTO buildings VALUES (267,5);
INSERT INTO buildings VALUES (211,21);
INSERT INTO buildings VALUES (485,19);
INSERT INTO buildings VALUES (83,15);
INSERT INTO buildings VALUES (482,26);
INSERT INTO buildings VALUES (332,21);
INSERT INTO buildings VALUES (66,56);
INSERT INTO buildings VALUES (76,19);
INSERT INTO buildings VALUES (82,46);
INSERT INTO buildings VALUES (278,11);
INSERT INTO buildings VALUES (66,22);
INSERT INTO buildings VALUES (441,36);
INSERT INTO buildings VALUES (323,65);
INSERT INTO buildings VALUES (82,22);
INSERT INTO buildings VALUES (112,63);
INSERT INTO buildings VALUES (96,65);
INSERT INTO buildings VALUES (159,65);
INSERT INTO buildings VALUES (95,65);
INSERT INTO buildings VALUES (332,19);
INSERT INTO buildings VALUES (260,30);
INSERT INTO buildings VALUES (159,53);
INSERT INTO buildings VALUES (205,30);
INSERT INTO buildings VALUES (323,1);
INSERT INTO buildings VALUES (95,53);
INSERT INTO buildings VALUES (112,5);
INSERT INTO buildings VALUES (390,65);
INSERT INTO buildings VALUES (323,53);
INSERT INTO buildings VALUES (96,4);
INSERT INTO buildings VALUES (261,23);
INSERT INTO buildings VALUES (278,19);
INSERT INTO buildings VALUES (242,63);
INSERT INTO buildings VALUES (159,4);
INSERT INTO buildings VALUES (96,1);
INSERT INTO buildings VALUES (332,13);
INSERT INTO buildings VALUES (278,21);
INSERT INTO buildings VALUES (390,4);
INSERT INTO buildings VALUES (473,21);
INSERT INTO buildings VALUES (468,22);
INSERT INTO buildings VALUES (96,22);
INSERT INTO buildings VALUES (108,26);
INSERT INTO buildings VALUES (450,36);
INSERT INTO buildings VALUES (95,19);
INSERT INTO buildings VALUES (464,36);
INSERT INTO buildings VALUES (406,1);
INSERT INTO buildings VALUES (122,53);
INSERT INTO buildings VALUES (11,65);
INSERT INTO buildings VALUES (8,65);
INSERT INTO buildings VALUES (490,65);
INSERT INTO buildings VALUES (159,19);
INSERT INTO buildings VALUES (247,65);
INSERT INTO buildings VALUES (272,4);
INSERT INTO buildings VALUES (257,4);
INSERT INTO buildings VALUES (95,5);
INSERT INTO buildings VALUES (332,11);
INSERT INTO buildings VALUES (8,53);
INSERT INTO buildings VALUES (11,53);
INSERT INTO buildings VALUES (490,53);
INSERT INTO buildings VALUES (317,65);
INSERT INTO buildings VALUES (473,13);
INSERT INTO buildings VALUES (278,4);
INSERT INTO buildings VALUES (178,65);
INSERT INTO buildings VALUES (179,65);
INSERT INTO buildings VALUES (159,22);
INSERT INTO buildings VALUES (95,60);
INSERT INTO buildings VALUES (440,30);
INSERT INTO buildings VALUES (96,19);
INSERT INTO buildings VALUES (163,65);
INSERT INTO buildings VALUES (186,65);
INSERT INTO buildings VALUES (189,65);
INSERT INTO buildings VALUES (332,5);
INSERT INTO buildings VALUES (8,22);
INSERT INTO buildings VALUES (179,53);
INSERT INTO buildings VALUES (490,22);
INSERT INTO buildings VALUES (11,22);
INSERT INTO buildings VALUES (178,53);
INSERT INTO buildings VALUES (186,53);
INSERT INTO buildings VALUES (473,5);
INSERT INTO buildings VALUES (159,60);
INSERT INTO buildings VALUES (95,22);
INSERT INTO buildings VALUES (96,60);
INSERT INTO buildings VALUES (208,65);
INSERT INTO buildings VALUES (290,65);
INSERT INTO buildings VALUES (163,4);
INSERT INTO buildings VALUES (426,15);
INSERT INTO buildings VALUES (189,4);
INSERT INTO buildings VALUES (323,63);
INSERT INTO buildings VALUES (468,5);
INSERT INTO buildings VALUES (490,5);
INSERT INTO buildings VALUES (317,53);
INSERT INTO buildings VALUES (323,60);
INSERT INTO buildings VALUES (109,57);
INSERT INTO buildings VALUES (317,1);
INSERT INTO buildings VALUES (440,36);
INSERT INTO buildings VALUES (426,13);
INSERT INTO buildings VALUES (446,30);
INSERT INTO buildings VALUES (293,65);
INSERT INTO buildings VALUES (296,65);
INSERT INTO buildings VALUES (11,19);
INSERT INTO buildings VALUES (8,19);
INSERT INTO buildings VALUES (390,23);
INSERT INTO buildings VALUES (491,33);
INSERT INTO buildings VALUES (186,19);
INSERT INTO buildings VALUES (108,33);
INSERT INTO buildings VALUES (482,33);
INSERT INTO buildings VALUES (178,19);
INSERT INTO buildings VALUES (179,19);
INSERT INTO buildings VALUES (334,36);
INSERT INTO buildings VALUES (406,26);
INSERT INTO buildings VALUES (100,65);
INSERT INTO buildings VALUES (109,27);
INSERT INTO buildings VALUES (293,53);
INSERT INTO buildings VALUES (296,53);
INSERT INTO buildings VALUES (189,19);
INSERT INTO buildings VALUES (390,22);
INSERT INTO buildings VALUES (11,5);
INSERT INTO buildings VALUES (490,19);
INSERT INTO buildings VALUES (189,1);
INSERT INTO buildings VALUES (8,5);
INSERT INTO buildings VALUES (468,21);
INSERT INTO buildings VALUES (108,5);
INSERT INTO buildings VALUES (406,13);
INSERT INTO buildings VALUES (296,21);
INSERT INTO buildings VALUES (293,21);
INSERT INTO buildings VALUES (179,1);
INSERT INTO buildings VALUES (178,1);
INSERT INTO buildings VALUES (163,1);
INSERT INTO buildings VALUES (186,1);
INSERT INTO buildings VALUES (100,5);
INSERT INTO buildings VALUES (11,60);
INSERT INTO buildings VALUES (390,21);
INSERT INTO buildings VALUES (293,1);
INSERT INTO buildings VALUES (490,60);
INSERT INTO buildings VALUES (296,1);
INSERT INTO buildings VALUES (8,60);
INSERT INTO buildings VALUES (446,36);
INSERT INTO buildings VALUES (207,60);
INSERT INTO buildings VALUES (189,21);
INSERT INTO buildings VALUES (390,1);
INSERT INTO buildings VALUES (261,5);
INSERT INTO buildings VALUES (182,23);
INSERT INTO buildings VALUES (465,26);
INSERT INTO buildings VALUES (267,13);
INSERT INTO buildings VALUES (100,60);
INSERT INTO buildings VALUES (179,56);
INSERT INTO buildings VALUES (186,56);
INSERT INTO buildings VALUES (441,30);
INSERT INTO buildings VALUES (334,15);
INSERT INTO buildings VALUES (473,60);
INSERT INTO buildings VALUES (108,36);
INSERT INTO buildings VALUES (92,56);
INSERT INTO buildings VALUES (481,21);
INSERT INTO buildings VALUES (317,63);
INSERT INTO buildings VALUES (163,19);
INSERT INTO buildings VALUES (205,15);
INSERT INTO buildings VALUES (323,26);
INSERT INTO buildings VALUES (92,22);
INSERT INTO buildings VALUES (74,19);
INSERT INTO buildings VALUES (68,19);
INSERT INTO buildings VALUES (82,19);
INSERT INTO buildings VALUES (333,65);
INSERT INTO buildings VALUES (108,13);
INSERT INTO buildings VALUES (76,46);
INSERT INTO buildings VALUES (66,46);
INSERT INTO buildings VALUES (485,23);
INSERT INTO buildings VALUES (77,46);
INSERT INTO buildings VALUES (333,53);
INSERT INTO buildings VALUES (326,65);
INSERT INTO buildings VALUES (66,1);
INSERT INTO buildings VALUES (100,19);
INSERT INTO buildings VALUES (326,53);
INSERT INTO buildings VALUES (82,56);
INSERT INTO buildings VALUES (298,65);
INSERT INTO buildings VALUES (211,26);
INSERT INTO buildings VALUES (108,22);
INSERT INTO buildings VALUES (242,23);
INSERT INTO buildings VALUES (298,53);
INSERT INTO buildings VALUES (260,34);
INSERT INTO buildings VALUES (89,32);
INSERT INTO buildings VALUES (189,56);
INSERT INTO buildings VALUES (178,63);
INSERT INTO buildings VALUES (163,56);
INSERT INTO buildings VALUES (77,27);
INSERT INTO buildings VALUES (296,63);
INSERT INTO buildings VALUES (293,63);
INSERT INTO buildings VALUES (92,19);
INSERT INTO buildings VALUES (8,63);
INSERT INTO buildings VALUES (490,63);
INSERT INTO buildings VALUES (11,63);
INSERT INTO buildings VALUES (95,63);
INSERT INTO buildings VALUES (159,63);
INSERT INTO buildings VALUES (450,32);
INSERT INTO buildings VALUES (440,32);
INSERT INTO buildings VALUES (77,22);
INSERT INTO buildings VALUES (63,65);
INSERT INTO buildings VALUES (315,65);
INSERT INTO buildings VALUES (314,65);
INSERT INTO buildings VALUES (74,15);
INSERT INTO buildings VALUES (315,53);
INSERT INTO buildings VALUES (314,53);
INSERT INTO buildings VALUES (186,63);
INSERT INTO buildings VALUES (293,22);
INSERT INTO buildings VALUES (296,22);
INSERT INTO buildings VALUES (339,65);
INSERT INTO buildings VALUES (315,1);
INSERT INTO buildings VALUES (8,56);
INSERT INTO buildings VALUES (490,13);
INSERT INTO buildings VALUES (314,1);
INSERT INTO buildings VALUES (95,56);
INSERT INTO buildings VALUES (103,56);
INSERT INTO buildings VALUES (98,56);
INSERT INTO buildings VALUES (482,21);
INSERT INTO buildings VALUES (66,15);
INSERT INTO buildings VALUES (483,21);
INSERT INTO buildings VALUES (112,56);
INSERT INTO buildings VALUES (96,56);
INSERT INTO buildings VALUES (18,65);
INSERT INTO buildings VALUES (186,5);
INSERT INTO buildings VALUES (18,53);
INSERT INTO buildings VALUES (317,26);
INSERT INTO buildings VALUES (159,56);
INSERT INTO buildings VALUES (439,27);
INSERT INTO buildings VALUES (446,27);
INSERT INTO buildings VALUES (441,27);
INSERT INTO buildings VALUES (440,27);
INSERT INTO buildings VALUES (468,32);
INSERT INTO buildings VALUES (63,13);
INSERT INTO buildings VALUES (163,60);
INSERT INTO buildings VALUES (311,65);
INSERT INTO buildings VALUES (92,46);
INSERT INTO buildings VALUES (317,22);
INSERT INTO buildings VALUES (77,19);
INSERT INTO buildings VALUES (76,23);
INSERT INTO buildings VALUES (63,60);
INSERT INTO buildings VALUES (11,46);
INSERT INTO buildings VALUES (179,63);
INSERT INTO buildings VALUES (329,65);
INSERT INTO buildings VALUES (333,63);
INSERT INTO buildings VALUES (317,21);
INSERT INTO buildings VALUES (68,25);
INSERT INTO buildings VALUES (82,23);
INSERT INTO buildings VALUES (326,63);
INSERT INTO buildings VALUES (464,25);
INSERT INTO buildings VALUES (296,19);
INSERT INTO buildings VALUES (77,56);
INSERT INTO buildings VALUES (311,1);
INSERT INTO buildings VALUES (326,1);
INSERT INTO buildings VALUES (293,19);
INSERT INTO buildings VALUES (333,1);
INSERT INTO buildings VALUES (298,63);
INSERT INTO buildings VALUES (120,65);
INSERT INTO buildings VALUES (311,53);
INSERT INTO buildings VALUES (76,56);
INSERT INTO buildings VALUES (189,23);
INSERT INTO buildings VALUES (63,56);
INSERT INTO buildings VALUES (11,56);
INSERT INTO buildings VALUES (8,46);
INSERT INTO buildings VALUES (395,65);
INSERT INTO buildings VALUES (317,60);
INSERT INTO buildings VALUES (298,1);
INSERT INTO buildings VALUES (329,21);
INSERT INTO buildings VALUES (490,46);
INSERT INTO buildings VALUES (179,21);
INSERT INTO buildings VALUES (95,46);
INSERT INTO buildings VALUES (68,22);
INSERT INTO buildings VALUES (326,21);
INSERT INTO buildings VALUES (333,21);
INSERT INTO buildings VALUES (97,33);
INSERT INTO buildings VALUES (83,30);
INSERT INTO buildings VALUES (46,65);
INSERT INTO buildings VALUES (355,65);
INSERT INTO buildings VALUES (63,22);
INSERT INTO buildings VALUES (83,1);
INSERT INTO buildings VALUES (100,33);
INSERT INTO buildings VALUES (179,5);
INSERT INTO buildings VALUES (117,65);
INSERT INTO buildings VALUES (490,56);
INSERT INTO buildings VALUES (120,1);
INSERT INTO buildings VALUES (117,1);
INSERT INTO buildings VALUES (477,65);
INSERT INTO buildings VALUES (97,56);
INSERT INTO buildings VALUES (46,53);
INSERT INTO buildings VALUES (13,65);
INSERT INTO buildings VALUES (355,1);
INSERT INTO buildings VALUES (314,63);
INSERT INTO buildings VALUES (315,63);
INSERT INTO buildings VALUES (329,19);
INSERT INTO buildings VALUES (108,25);
INSERT INTO buildings VALUES (117,60);
INSERT INTO buildings VALUES (163,23);
INSERT INTO buildings VALUES (100,36);
INSERT INTO buildings VALUES (97,22);
INSERT INTO buildings VALUES (117,53);
INSERT INTO buildings VALUES (312,65);
INSERT INTO buildings VALUES (426,40);
INSERT INTO buildings VALUES (312,53);
INSERT INTO buildings VALUES (63,19);
INSERT INTO buildings VALUES (475,65);
INSERT INTO buildings VALUES (278,30);
INSERT INTO buildings VALUES (329,22);
INSERT INTO buildings VALUES (315,60);
INSERT INTO buildings VALUES (46,60);
INSERT INTO buildings VALUES (312,21);
INSERT INTO buildings VALUES (469,65);
INSERT INTO buildings VALUES (163,36);
INSERT INTO buildings VALUES (63,5);
INSERT INTO buildings VALUES (315,21);
INSERT INTO buildings VALUES (312,1);
INSERT INTO buildings VALUES (13,53);
INSERT INTO buildings VALUES (173,65);
INSERT INTO buildings VALUES (163,21);
INSERT INTO buildings VALUES (469,53);
INSERT INTO buildings VALUES (173,53);
INSERT INTO buildings VALUES (475,53);
INSERT INTO buildings VALUES (76,1);
INSERT INTO buildings VALUES (68,1);
INSERT INTO buildings VALUES (105,65);
INSERT INTO buildings VALUES (73,65);
INSERT INTO buildings VALUES (72,65);
INSERT INTO buildings VALUES (13,60);
INSERT INTO buildings VALUES (103,5);
INSERT INTO buildings VALUES (163,5);
INSERT INTO buildings VALUES (13,1);
INSERT INTO buildings VALUES (475,22);
INSERT INTO buildings VALUES (311,63);
INSERT INTO buildings VALUES (469,60);
INSERT INTO buildings VALUES (120,32);
INSERT INTO buildings VALUES (18,63);
INSERT INTO buildings VALUES (492,65);
INSERT INTO buildings VALUES (182,30);
INSERT INTO buildings VALUES (173,36);
INSERT INTO buildings VALUES (133,65);
INSERT INTO buildings VALUES (317,40);
INSERT INTO buildings VALUES (477,19);
INSERT INTO buildings VALUES (100,11);
INSERT INTO buildings VALUES (311,60);
INSERT INTO buildings VALUES (18,60);
INSERT INTO buildings VALUES (120,60);
INSERT INTO buildings VALUES (469,56);
INSERT INTO buildings VALUES (98,19);
INSERT INTO buildings VALUES (97,19);
INSERT INTO buildings VALUES (475,56);
INSERT INTO buildings VALUES (300,65);
INSERT INTO buildings VALUES (18,1);
INSERT INTO buildings VALUES (108,15);
INSERT INTO buildings VALUES (173,60);
INSERT INTO buildings VALUES (205,38);
INSERT INTO buildings VALUES (120,4);
INSERT INTO buildings VALUES (89,15);
INSERT INTO buildings VALUES (300,1);
INSERT INTO buildings VALUES (475,5);
INSERT INTO buildings VALUES (173,4);
INSERT INTO buildings VALUES (469,22);
INSERT INTO buildings VALUES (133,53);
INSERT INTO buildings VALUES (46,63);
INSERT INTO buildings VALUES (46,1);
INSERT INTO buildings VALUES (315,26);
INSERT INTO buildings VALUES (117,63);
INSERT INTO buildings VALUES (300,21);
INSERT INTO buildings VALUES (317,19);
INSERT INTO buildings VALUES (173,56);
INSERT INTO buildings VALUES (492,60);
INSERT INTO buildings VALUES (300,53);
INSERT INTO buildings VALUES (100,21);
INSERT INTO buildings VALUES (32,65);
INSERT INTO buildings VALUES (112,23);
INSERT INTO buildings VALUES (63,63);
INSERT INTO buildings VALUES (96,23);
INSERT INTO buildings VALUES (315,22);
INSERT INTO buildings VALUES (312,63);
INSERT INTO buildings VALUES (449,65);
INSERT INTO buildings VALUES (498,36);
INSERT INTO buildings VALUES (85,65);
INSERT INTO buildings VALUES (73,53);
INSERT INTO buildings VALUES (72,53);
INSERT INTO buildings VALUES (105,53);
INSERT INTO buildings VALUES (86,65);
INSERT INTO buildings VALUES (87,65);
INSERT INTO buildings VALUES (103,23);
INSERT INTO buildings VALUES (475,19);
INSERT INTO buildings VALUES (469,19);
INSERT INTO buildings VALUES (8,1);
INSERT INTO buildings VALUES (11,1);
INSERT INTO buildings VALUES (74,1);
INSERT INTO buildings VALUES (82,1);
INSERT INTO buildings VALUES (102,1);
INSERT INTO buildings VALUES (490,1);
INSERT INTO buildings VALUES (87,53);
INSERT INTO buildings VALUES (46,22);
INSERT INTO buildings VALUES (107,65);
INSERT INTO buildings VALUES (163,38);
INSERT INTO buildings VALUES (108,11);
INSERT INTO buildings VALUES (85,53);
INSERT INTO buildings VALUES (133,38);
INSERT INTO buildings VALUES (73,60);
INSERT INTO buildings VALUES (317,36);
INSERT INTO buildings VALUES (32,5);
INSERT INTO buildings VALUES (86,4);
INSERT INTO buildings VALUES (20,65);
INSERT INTO buildings VALUES (441,38);
INSERT INTO buildings VALUES (439,38);
INSERT INTO buildings VALUES (450,38);
INSERT INTO buildings VALUES (475,60);
INSERT INTO buildings VALUES (446,38);
INSERT INTO buildings VALUES (72,5);
INSERT INTO buildings VALUES (440,38);
INSERT INTO buildings VALUES (66,13);
INSERT INTO buildings VALUES (105,5);
INSERT INTO buildings VALUES (70,65);
INSERT INTO buildings VALUES (46,21);
INSERT INTO buildings VALUES (469,5);
INSERT INTO buildings VALUES (312,22);
INSERT INTO buildings VALUES (311,22);
INSERT INTO buildings VALUES (117,19);
INSERT INTO buildings VALUES (173,19);
INSERT INTO buildings VALUES (133,4);
INSERT INTO buildings VALUES (465,38);
INSERT INTO buildings VALUES (464,38);
INSERT INTO buildings VALUES (86,5);
INSERT INTO buildings VALUES (468,38);
INSERT INTO buildings VALUES (133,1);
INSERT INTO buildings VALUES (18,26);
INSERT INTO buildings VALUES (311,21);
INSERT INTO buildings VALUES (20,53);
INSERT INTO buildings VALUES (63,46);
INSERT INTO buildings VALUES (92,1);
INSERT INTO buildings VALUES (103,19);
INSERT INTO buildings VALUES (107,4);
INSERT INTO buildings VALUES (494,33);
INSERT INTO buildings VALUES (315,19);
INSERT INTO buildings VALUES (20,1);
INSERT INTO buildings VALUES (493,33);
INSERT INTO buildings VALUES (87,19);

--
-- Table structure for table 'constellationnames'
--

DROP TABLE IF EXISTS constellationnames;
CREATE TABLE constellationnames (
  name varchar(255) NOT NULL default '',
  id int(11) NOT NULL auto_increment,
  genetiv varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY genetiv (genetiv),
  KEY name (name)
) TYPE=MyISAM;

--
-- Dumping data for table 'constellationnames'
--


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

--
-- Table structure for table 'constellations'
--

DROP TABLE IF EXISTS constellations;
CREATE TABLE constellations (
  id int(11) NOT NULL auto_increment,
  name varchar(255) default NULL,
  PRIMARY KEY  (id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'constellations'
--


INSERT INTO constellations VALUES (1,'Mensa');
INSERT INTO constellations VALUES (2,'Gruis');
INSERT INTO constellations VALUES (3,'Tucana');
INSERT INTO constellations VALUES (4,'Al Sagittarus');
INSERT INTO constellations VALUES (5,'Canis Major');
INSERT INTO constellations VALUES (6,'Carina');
INSERT INTO constellations VALUES (7,'Rigel Centaurus');
INSERT INTO constellations VALUES (8,'Al Gruis');
INSERT INTO constellations VALUES (9,'Lyra');

--
-- Table structure for table 'covertops'
--

DROP TABLE IF EXISTS covertops;
CREATE TABLE covertops (
  count int(11) default NULL,
  uid int(11) default NULL,
  time int(11) default NULL,
  target int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  cid int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'covertops'
--


INSERT INTO covertops VALUES (5000,2,6,298,234,8);
INSERT INTO covertops VALUES (5000,2,6,408,233,8);
INSERT INTO covertops VALUES (5000,2,6,369,232,8);
INSERT INTO covertops VALUES (500,7,6,4,248,2);
INSERT INTO covertops VALUES (500,7,6,9,247,3);
INSERT INTO covertops VALUES (1000,2,4,1,238,5);
INSERT INTO covertops VALUES (500,7,6,9,246,2);
INSERT INTO covertops VALUES (1000,2,4,7,237,5);
INSERT INTO covertops VALUES (2000,2,12,1,236,6);
INSERT INTO covertops VALUES (2000,2,12,7,235,6);
INSERT INTO covertops VALUES (500,7,6,2,245,3);
INSERT INTO covertops VALUES (500,7,6,2,244,2);
INSERT INTO covertops VALUES (1000,7,6,4,243,1);
INSERT INTO covertops VALUES (1000,7,6,9,242,1);
INSERT INTO covertops VALUES (1000,7,6,2,241,1);

--
-- Table structure for table 'covertopsmissions'
--

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

--
-- Dumping data for table 'covertopsmissions'
--


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
INSERT INTO covertopsmissions VALUES ('Propaganda',2000,0,1000,0,0,0,3000,0,'O','I','P',0,11,32,30);

--
-- Table structure for table 'covertopsupgrades'
--

DROP TABLE IF EXISTS covertopsupgrades;
CREATE TABLE covertopsupgrades (
  prod_id int(11) default NULL,
  value int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'covertopsupgrades'
--


INSERT INTO covertopsupgrades VALUES (56,10);
INSERT INTO covertopsupgrades VALUES (57,20);
INSERT INTO covertopsupgrades VALUES (58,35);
INSERT INTO covertopsupgrades VALUES (59,50);

--
-- Table structure for table 'diplomacy'
--

DROP TABLE IF EXISTS diplomacy;
CREATE TABLE diplomacy (
  alliance1 int(11) NOT NULL default '0',
  alliance2 int(11) NOT NULL default '0',
  status tinyint(1) default NULL,
  PRIMARY KEY  (alliance1,alliance2)
) TYPE=MyISAM;

--
-- Dumping data for table 'diplomacy'
--


INSERT INTO diplomacy VALUES (2,1,0);
INSERT INTO diplomacy VALUES (1,2,0);

--
-- Table structure for table 'diplomatic_change_request'
--

DROP TABLE IF EXISTS diplomatic_change_request;
CREATE TABLE diplomatic_change_request (
  aid1 int(11) NOT NULL default '0',
  aid2 int(11) NOT NULL default '0',
  status tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (aid1,aid2)
) TYPE=MyISAM;

--
-- Dumping data for table 'diplomatic_change_request'
--



--
-- Table structure for table 'fleet'
--

DROP TABLE IF EXISTS fleet;
CREATE TABLE fleet (
  prod_id int(11) NOT NULL default '0',
  count int(11) default NULL,
  reload int(11) default '0',
  fid int(11) NOT NULL default '0',
  KEY fid (fid),
  KEY prod_id (prod_id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'fleet'
--


INSERT INTO fleet VALUES (6,150,0,173);
INSERT INTO fleet VALUES (3,2,0,130);
INSERT INTO fleet VALUES (14,16,0,202);
INSERT INTO fleet VALUES (16,10,0,11);
INSERT INTO fleet VALUES (9,4,0,17);
INSERT INTO fleet VALUES (9,4,0,225);
INSERT INTO fleet VALUES (16,2,0,59);
INSERT INTO fleet VALUES (3,1,0,32);
INSERT INTO fleet VALUES (2,1,0,56);
INSERT INTO fleet VALUES (14,6,0,2);
INSERT INTO fleet VALUES (14,20,0,130);
INSERT INTO fleet VALUES (64,2,0,2);
INSERT INTO fleet VALUES (14,14,0,4);
INSERT INTO fleet VALUES (3,2,0,4);
INSERT INTO fleet VALUES (2,1,0,253);
INSERT INTO fleet VALUES (3,1,0,6);
INSERT INTO fleet VALUES (2,85,0,85);
INSERT INTO fleet VALUES (3,1,0,41);
INSERT INTO fleet VALUES (3,1,0,8);
INSERT INTO fleet VALUES (3,1,0,9);
INSERT INTO fleet VALUES (3,1,0,10);
INSERT INTO fleet VALUES (24,25,3,338);
INSERT INTO fleet VALUES (48,1,0,13);
INSERT INTO fleet VALUES (9,4,0,18);
INSERT INTO fleet VALUES (3,1,0,59);
INSERT INTO fleet VALUES (6,5,0,20);
INSERT INTO fleet VALUES (14,5,0,98);
INSERT INTO fleet VALUES (14,900,0,22);
INSERT INTO fleet VALUES (3,1,0,23);
INSERT INTO fleet VALUES (3,1,0,24);
INSERT INTO fleet VALUES (3,1,0,109);
INSERT INTO fleet VALUES (64,100,0,38);
INSERT INTO fleet VALUES (2,10,0,80);
INSERT INTO fleet VALUES (3,1,0,151);
INSERT INTO fleet VALUES (3,1,0,126);
INSERT INTO fleet VALUES (28,2,0,66);
INSERT INTO fleet VALUES (3,1,0,68);
INSERT INTO fleet VALUES (6,1,0,99);
INSERT INTO fleet VALUES (9,3,0,40);
INSERT INTO fleet VALUES (3,1,0,33);
INSERT INTO fleet VALUES (6,8,0,175);
INSERT INTO fleet VALUES (9,3,0,46);
INSERT INTO fleet VALUES (14,4,0,46);
INSERT INTO fleet VALUES (3,1,0,43);
INSERT INTO fleet VALUES (3,1,0,44);
INSERT INTO fleet VALUES (3,1,0,45);
INSERT INTO fleet VALUES (6,37,0,46);
INSERT INTO fleet VALUES (3,1,0,64);
INSERT INTO fleet VALUES (6,55,0,47);
INSERT INTO fleet VALUES (24,15,0,80);
INSERT INTO fleet VALUES (14,10,0,47);
INSERT INTO fleet VALUES (3,2,0,47);
INSERT INTO fleet VALUES (18,5,0,80);
INSERT INTO fleet VALUES (3,1,0,63);
INSERT INTO fleet VALUES (2,1,0,58);
INSERT INTO fleet VALUES (12,4,0,248);
INSERT INTO fleet VALUES (3,1,0,55);
INSERT INTO fleet VALUES (3,2,0,46);
INSERT INTO fleet VALUES (6,1,0,59);
INSERT INTO fleet VALUES (3,2,0,82);
INSERT INTO fleet VALUES (3,1,0,67);
INSERT INTO fleet VALUES (9,1,0,99);
INSERT INTO fleet VALUES (37,10,0,227);
INSERT INTO fleet VALUES (3,1,0,214);
INSERT INTO fleet VALUES (6,23,0,95);
INSERT INTO fleet VALUES (3,1,0,129);
INSERT INTO fleet VALUES (3,4,0,119);
INSERT INTO fleet VALUES (37,2,9,361);
INSERT INTO fleet VALUES (3,1,0,128);
INSERT INTO fleet VALUES (2,1,0,99);
INSERT INTO fleet VALUES (6,100,0,80);
INSERT INTO fleet VALUES (29,1,0,363);
INSERT INTO fleet VALUES (64,10,0,80);
INSERT INTO fleet VALUES (3,5,0,80);
INSERT INTO fleet VALUES (14,30,0,80);
INSERT INTO fleet VALUES (6,15,0,363);
INSERT INTO fleet VALUES (37,2,8,338);
INSERT INTO fleet VALUES (3,1,0,127);
INSERT INTO fleet VALUES (3,1,0,227);
INSERT INTO fleet VALUES (18,4,0,323);
INSERT INTO fleet VALUES (18,1,0,121);
INSERT INTO fleet VALUES (6,20,2,338);
INSERT INTO fleet VALUES (9,2,0,365);
INSERT INTO fleet VALUES (3,1,0,169);
INSERT INTO fleet VALUES (24,36,0,323);
INSERT INTO fleet VALUES (3,1,0,155);
INSERT INTO fleet VALUES (3,1,0,134);
INSERT INTO fleet VALUES (3,1,0,152);
INSERT INTO fleet VALUES (3,1,0,136);
INSERT INTO fleet VALUES (3,1,0,137);
INSERT INTO fleet VALUES (24,33,0,363);
INSERT INTO fleet VALUES (3,1,0,139);
INSERT INTO fleet VALUES (3,1,0,175);
INSERT INTO fleet VALUES (3,1,0,167);
INSERT INTO fleet VALUES (3,1,0,168);
INSERT INTO fleet VALUES (3,1,0,166);
INSERT INTO fleet VALUES (24,50,0,173);
INSERT INTO fleet VALUES (12,1,0,145);
INSERT INTO fleet VALUES (3,1,0,189);
INSERT INTO fleet VALUES (3,1,0,183);
INSERT INTO fleet VALUES (3,1,0,182);
INSERT INTO fleet VALUES (3,1,0,181);
INSERT INTO fleet VALUES (3,5,0,202);
INSERT INTO fleet VALUES (3,1,0,153);
INSERT INTO fleet VALUES (3,1,0,154);
INSERT INTO fleet VALUES (37,3,0,66);
INSERT INTO fleet VALUES (3,1,0,156);
INSERT INTO fleet VALUES (3,1,0,157);
INSERT INTO fleet VALUES (6,20,0,202);
INSERT INTO fleet VALUES (24,10,0,225);
INSERT INTO fleet VALUES (3,1,0,199);
INSERT INTO fleet VALUES (3,1,0,160);
INSERT INTO fleet VALUES (3,1,0,161);
INSERT INTO fleet VALUES (3,1,0,162);
INSERT INTO fleet VALUES (3,1,0,170);
INSERT INTO fleet VALUES (3,1,0,201);
INSERT INTO fleet VALUES (16,3,0,225);
INSERT INTO fleet VALUES (18,20,0,173);
INSERT INTO fleet VALUES (3,1,0,176);
INSERT INTO fleet VALUES (3,1,0,177);
INSERT INTO fleet VALUES (3,1,0,321);
INSERT INTO fleet VALUES (35,4,0,219);
INSERT INTO fleet VALUES (3,1,0,180);
INSERT INTO fleet VALUES (3,1,0,236);
INSERT INTO fleet VALUES (12,5,0,197);
INSERT INTO fleet VALUES (37,10,0,173);
INSERT INTO fleet VALUES (24,6,0,196);
INSERT INTO fleet VALUES (12,1,7,188);
INSERT INTO fleet VALUES (18,10,0,326);
INSERT INTO fleet VALUES (24,9,4,362);
INSERT INTO fleet VALUES (35,2,7,338);
INSERT INTO fleet VALUES (3,1,0,198);
INSERT INTO fleet VALUES (3,1,0,211);
INSERT INTO fleet VALUES (16,10,0,130);
INSERT INTO fleet VALUES (16,10,0,202);
INSERT INTO fleet VALUES (24,10,0,202);
INSERT INTO fleet VALUES (3,1,0,213);
INSERT INTO fleet VALUES (14,10,0,219);
INSERT INTO fleet VALUES (3,1,0,224);
INSERT INTO fleet VALUES (6,10,0,225);
INSERT INTO fleet VALUES (3,1,0,222);
INSERT INTO fleet VALUES (3,1,0,248);
INSERT INTO fleet VALUES (29,2,0,248);
INSERT INTO fleet VALUES (3,1,0,121);
INSERT INTO fleet VALUES (37,19,0,237);
INSERT INTO fleet VALUES (2,1,0,252);
INSERT INTO fleet VALUES (3,1,0,215);
INSERT INTO fleet VALUES (6,130,0,330);
INSERT INTO fleet VALUES (6,25,0,219);
INSERT INTO fleet VALUES (16,5,0,219);
INSERT INTO fleet VALUES (9,6,0,219);
INSERT INTO fleet VALUES (37,20,0,326);
INSERT INTO fleet VALUES (24,19,0,219);
INSERT INTO fleet VALUES (29,14,0,330);
INSERT INTO fleet VALUES (18,2,12,361);
INSERT INTO fleet VALUES (35,10,0,330);
INSERT INTO fleet VALUES (35,2,8,361);
INSERT INTO fleet VALUES (3,10,0,327);
INSERT INTO fleet VALUES (18,13,0,330);
INSERT INTO fleet VALUES (37,1,0,290);
INSERT INTO fleet VALUES (29,5,0,323);
INSERT INTO fleet VALUES (35,7,0,323);
INSERT INTO fleet VALUES (24,5,0,366);
INSERT INTO fleet VALUES (35,10,0,227);
INSERT INTO fleet VALUES (24,500,0,326);
INSERT INTO fleet VALUES (37,13,0,352);
INSERT INTO fleet VALUES (3,1,0,260);
INSERT INTO fleet VALUES (3,1,0,256);
INSERT INTO fleet VALUES (16,20,0,330);
INSERT INTO fleet VALUES (2,5,0,327);
INSERT INTO fleet VALUES (12,12,0,277);
INSERT INTO fleet VALUES (29,2,0,365);
INSERT INTO fleet VALUES (37,8,0,323);
INSERT INTO fleet VALUES (12,1,4,350);
INSERT INTO fleet VALUES (16,2,0,290);
INSERT INTO fleet VALUES (24,3,0,290);
INSERT INTO fleet VALUES (14,1,0,290);
INSERT INTO fleet VALUES (2,1,0,290);
INSERT INTO fleet VALUES (24,10,0,354);
INSERT INTO fleet VALUES (29,1,5,361);
INSERT INTO fleet VALUES (24,113,0,330);
INSERT INTO fleet VALUES (37,12,0,330);
INSERT INTO fleet VALUES (6,2,1,327);
INSERT INTO fleet VALUES (12,1,1,328);
INSERT INTO fleet VALUES (12,20,0,326);
INSERT INTO fleet VALUES (62,10,0,326);
INSERT INTO fleet VALUES (35,10,0,248);
INSERT INTO fleet VALUES (24,10,0,248);
INSERT INTO fleet VALUES (6,1000,0,326);
INSERT INTO fleet VALUES (12,1,1,357);
INSERT INTO fleet VALUES (35,2,0,365);
INSERT INTO fleet VALUES (16,6,0,323);
INSERT INTO fleet VALUES (9,2,0,323);
INSERT INTO fleet VALUES (6,90,0,323);
INSERT INTO fleet VALUES (18,3,11,338);
INSERT INTO fleet VALUES (9,1,4,364);
INSERT INTO fleet VALUES (12,2,0,321);
INSERT INTO fleet VALUES (16,7,0,342);
INSERT INTO fleet VALUES (18,4,4,342);
INSERT INTO fleet VALUES (29,1,0,342);
INSERT INTO fleet VALUES (24,12,0,342);
INSERT INTO fleet VALUES (37,4,1,342);
INSERT INTO fleet VALUES (6,22,0,342);
INSERT INTO fleet VALUES (18,12,0,352);
INSERT INTO fleet VALUES (24,101,0,352);
INSERT INTO fleet VALUES (35,6,0,352);
INSERT INTO fleet VALUES (6,130,0,352);
INSERT INTO fleet VALUES (64,6,0,352);
INSERT INTO fleet VALUES (16,20,0,352);
INSERT INTO fleet VALUES (29,19,0,352);
INSERT INTO fleet VALUES (3,1,0,352);

--
-- Table structure for table 'fleet_info'
--

DROP TABLE IF EXISTS fleet_info;
CREATE TABLE fleet_info (
  fid int(11) NOT NULL default '0',
  pid int(11) NOT NULL default '0',
  sid int(11) NOT NULL default '0',
  tpid int(11) NOT NULL default '0',
  tsid int(11) NOT NULL default '0',
  mission tinyint(1) NOT NULL default '0',
  milminister int(11) NOT NULL default '0',
  name varchar(255) NOT NULL default 'Unnamed fleet',
  uid int(11) NOT NULL default '0',
  UNIQUE KEY fid (fid),
  KEY pid (pid),
  KEY sid (sid),
  KEY tpid (tpid),
  KEY tsid (tsid),
  KEY uid (uid)
) TYPE=MyISAM;

--
-- Dumping data for table 'fleet_info'
--


INSERT INTO fleet_info VALUES (224,0,10,0,0,0,0,'Fox Eye 9th Grp',7);
INSERT INTO fleet_info VALUES (2,34,8,0,0,0,0,'1. Armee',2);
INSERT INTO fleet_info VALUES (99,0,13,0,0,0,0,'MTransport01',9);
INSERT INTO fleet_info VALUES (4,73,16,0,0,0,0,'1. Flotille',2);
INSERT INTO fleet_info VALUES (6,0,57,0,0,0,0,'Finger 1',4);
INSERT INTO fleet_info VALUES (82,0,84,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (8,0,42,0,0,0,0,'Probe1',5);
INSERT INTO fleet_info VALUES (9,0,77,0,0,0,0,'Probe2',5);
INSERT INTO fleet_info VALUES (10,0,47,0,0,0,0,'Probe3',5);
INSERT INTO fleet_info VALUES (11,109,25,0,0,0,0,'Da PeaceKeepers',2);
INSERT INTO fleet_info VALUES (33,0,3,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (58,0,35,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (17,98,22,0,0,0,0,'CragoFleet 1',2);
INSERT INTO fleet_info VALUES (13,6,1,0,0,1,0,'Lahmei',4);
INSERT INTO fleet_info VALUES (18,68,15,0,0,0,0,'CargoFleet 2',2);
INSERT INTO fleet_info VALUES (20,66,15,0,0,1,0,'Intercept',2);
INSERT INTO fleet_info VALUES (22,364,92,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (85,170,45,0,0,0,0,'Unnamed fleet',3);
INSERT INTO fleet_info VALUES (32,0,48,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (23,357,90,0,0,0,0,'Eagle Eye 2nd Grp',7);
INSERT INTO fleet_info VALUES (24,0,106,0,0,0,0,'Eagle Eye 3rd Grp',7);
INSERT INTO fleet_info VALUES (68,0,76,0,0,0,0,'Unnamed fleet',2);
INSERT INTO fleet_info VALUES (119,0,14,0,0,0,5,'MOD Fleet',2);
INSERT INTO fleet_info VALUES (366,315,81,0,0,0,0,'Unnamed fleet',7);
INSERT INTO fleet_info VALUES (129,407,100,0,0,0,0,'Eagle Eye 5th Grp',7);
INSERT INTO fleet_info VALUES (182,0,77,0,0,0,0,'Fox Eye Leader',7);
INSERT INTO fleet_info VALUES (151,478,117,0,0,0,0,'Eagle Eye 14th Grp',7);
INSERT INTO fleet_info VALUES (59,0,48,0,0,2,0,'System Patrol: Hot Red',4);
INSERT INTO fleet_info VALUES (38,0,1,0,0,0,0,'2. Chaostrupp',4);
INSERT INTO fleet_info VALUES (43,0,38,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (40,366,92,0,0,0,0,'1. Transall',4);
INSERT INTO fleet_info VALUES (41,0,51,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (67,79,17,0,0,0,0,'Unnamed fleet',2);
INSERT INTO fleet_info VALUES (66,0,107,0,0,0,0,'Duempeldingsda',2);
INSERT INTO fleet_info VALUES (44,0,80,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (45,0,83,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (46,0,65,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (47,267,65,0,0,0,0,'1. Runeblade',4);
INSERT INTO fleet_info VALUES (176,0,5,0,0,0,0,'Fox Eye 1st Grp',7);
INSERT INTO fleet_info VALUES (80,0,63,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (55,0,102,0,0,0,0,'Eagle Eye 1st Grp',7);
INSERT INTO fleet_info VALUES (161,313,80,0,0,0,0,'Eagle Eye 18th Grp',7);
INSERT INTO fleet_info VALUES (352,0,105,0,0,0,0,'Dragoner 3rd Reg',7);
INSERT INTO fleet_info VALUES (56,457,113,0,0,0,0,'Eagle Eye Leader',7);
INSERT INTO fleet_info VALUES (136,455,112,0,0,0,0,'Eagle Eye 9th Grp',7);
INSERT INTO fleet_info VALUES (222,0,12,0,0,0,0,'Fox Eye 8th Grp',7);
INSERT INTO fleet_info VALUES (63,0,110,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (64,0,87,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (128,402,99,0,0,0,0,'Eagle Eye 6th Grp',7);
INSERT INTO fleet_info VALUES (95,0,50,0,0,2,0,'System Patrol: Biohazard',4);
INSERT INTO fleet_info VALUES (98,494,121,0,0,0,0,'MBomber01',9);
INSERT INTO fleet_info VALUES (121,262,65,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (134,438,110,0,0,0,0,'Eagle Eye 10th Grp',7);
INSERT INTO fleet_info VALUES (153,484,119,0,0,0,0,'Eagle Eye 16th Grp',7);
INSERT INTO fleet_info VALUES (109,0,87,0,0,0,0,'Eagle Eye 4th Grp',7);
INSERT INTO fleet_info VALUES (126,434,109,0,0,0,0,'Eagle Eye 7th Grp',7);
INSERT INTO fleet_info VALUES (196,431,109,0,0,0,0,'MBomber02',9);
INSERT INTO fleet_info VALUES (130,205,55,0,0,0,0,'System Patrol Upsilon Al Saggitary',4);
INSERT INTO fleet_info VALUES (127,0,107,0,0,0,0,'Eagle Eye 8th Grp',7);
INSERT INTO fleet_info VALUES (137,462,114,0,0,0,0,'Eagle Eye 11th Grp',7);
INSERT INTO fleet_info VALUES (139,445,111,0,0,0,0,'Eagle Eye 13th Grp',7);
INSERT INTO fleet_info VALUES (290,439,110,0,0,0,0,'MBomber03',9);
INSERT INTO fleet_info VALUES (177,0,70,0,0,0,0,'Fox Eye 2nd Grp',7);
INSERT INTO fleet_info VALUES (175,77,17,0,0,0,0,'Unnamed fleet',2);
INSERT INTO fleet_info VALUES (145,485,119,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (189,27,7,0,0,0,0,'Fox Eye 7th Grp',7);
INSERT INTO fleet_info VALUES (197,0,40,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (152,471,116,0,0,0,0,'Eagle Eye 15th Grp',7);
INSERT INTO fleet_info VALUES (166,0,71,0,0,0,0,'Eagle Eye 22th Grp',7);
INSERT INTO fleet_info VALUES (160,0,76,0,0,0,0,'Eagle Eye 19th Grp',7);
INSERT INTO fleet_info VALUES (183,307,79,0,0,0,0,'Fox Eye 3rd Grp',7);
INSERT INTO fleet_info VALUES (154,0,103,0,0,0,0,'Eagle Eye 17th Grp',7);
INSERT INTO fleet_info VALUES (155,9,2,0,0,0,0,'Eagle Eye 20th Grp',7);
INSERT INTO fleet_info VALUES (156,0,24,0,0,0,0,'Eagle Eye 21th Grp',7);
INSERT INTO fleet_info VALUES (157,488,120,0,0,0,0,'Eagle Eye 22th Grp',7);
INSERT INTO fleet_info VALUES (162,388,96,0,0,0,0,'Eagle Eye 23th Grp',7);
INSERT INTO fleet_info VALUES (167,69,16,0,0,0,0,'Eagle Eye 23th Grp',7);
INSERT INTO fleet_info VALUES (168,88,19,0,0,0,0,'Eagle Eye 24th Grp',7);
INSERT INTO fleet_info VALUES (169,101,22,0,0,0,0,'Eagle Eye 25th Grp',7);
INSERT INTO fleet_info VALUES (170,0,4,0,0,0,0,'Eagle Eye 26th Grp',7);
INSERT INTO fleet_info VALUES (342,0,81,0,74,0,0,'Saudakar 1st Reg',7);
INSERT INTO fleet_info VALUES (256,205,55,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (173,0,33,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (180,0,6,0,0,0,0,'Fox Eye 4th Grp',7);
INSERT INTO fleet_info VALUES (181,0,74,0,0,0,0,'Fox Eye 5th Grp',7);
INSERT INTO fleet_info VALUES (198,25,7,0,0,0,0,'Fox Eye 8th Grp',7);
INSERT INTO fleet_info VALUES (188,0,0,300,300,4,0,'Unnamed fleet',8);
INSERT INTO fleet_info VALUES (199,38,9,0,0,0,0,'Fox Eye 9th Grp',7);
INSERT INTO fleet_info VALUES (201,0,78,0,0,0,0,'Fox Eye 12th Grp',7);
INSERT INTO fleet_info VALUES (357,0,16,101,22,4,0,'MCShip02',9);
INSERT INTO fleet_info VALUES (202,284,70,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (323,334,85,0,0,0,0,'Dragoner 1st Reg',7);
INSERT INTO fleet_info VALUES (211,207,55,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (363,0,74,0,0,0,0,'Unnamed fleet',7);
INSERT INTO fleet_info VALUES (277,16,3,0,0,0,0,'Unnamed fleet',8);
INSERT INTO fleet_info VALUES (237,406,100,0,0,0,0,'Muhahaha',2);
INSERT INTO fleet_info VALUES (213,179,48,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (214,190,50,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (215,186,49,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (326,30,8,0,0,0,0,'Unnamed fleet',1);
INSERT INTO fleet_info VALUES (219,420,105,0,0,0,0,'Wolfpack 1st Bat',7);
INSERT INTO fleet_info VALUES (225,408,101,0,0,0,0,'Wolfpack 2nd Bat',7);
INSERT INTO fleet_info VALUES (253,0,18,0,0,0,0,'Fox Eye 11th Grp',7);
INSERT INTO fleet_info VALUES (227,205,55,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (365,317,82,0,0,0,0,'Wolfpack 3nd Bat',7);
INSERT INTO fleet_info VALUES (327,0,4,23,6,0,0,'Unnamed fleet',2);
INSERT INTO fleet_info VALUES (236,3,1,0,0,0,0,'Fox Eye 10th Grp',7);
INSERT INTO fleet_info VALUES (364,0,82,317,82,0,0,'Unnamed fleet',7);
INSERT INTO fleet_info VALUES (362,0,74,0,74,0,0,'Unnamed fleet',7);
INSERT INTO fleet_info VALUES (338,0,81,0,74,0,0,'Sau Add',7);
INSERT INTO fleet_info VALUES (252,0,15,0,0,0,0,'Fox Eye 6th Grp',7);
INSERT INTO fleet_info VALUES (248,260,65,0,0,0,0,'Unnamed fleet',4);
INSERT INTO fleet_info VALUES (260,0,32,0,0,0,0,'Hopp Hopp',2);
INSERT INTO fleet_info VALUES (328,0,1,28,7,4,0,'Unnamed fleet',2);
INSERT INTO fleet_info VALUES (354,334,85,0,0,0,0,'Unnamed fleet',7);
INSERT INTO fleet_info VALUES (350,0,120,84,19,4,0,'MCShip03',9);
INSERT INTO fleet_info VALUES (361,0,81,0,74,0,0,'Unnamed fleet',7);
INSERT INTO fleet_info VALUES (330,0,108,0,0,0,0,'Dragoner 2nd Reg',7);
INSERT INTO fleet_info VALUES (321,133,35,0,0,0,0,'Unnamed fleet',4);

--
-- Table structure for table 'foreignforum'
--

DROP TABLE IF EXISTS foreignforum;
CREATE TABLE foreignforum (
  aid int(11) default '0',
  uid int(11) default '0',
  topic varchar(255) default NULL,
  text blob,
  time datetime default '0000-00-00 00:00:00',
  id int(11) NOT NULL auto_increment,
  fid int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'foreignforum'
--


INSERT INTO foreignforum VALUES (2,9,'Peace, not War...','auch wenn zur Zeit die einzelnen<br />\r\nParteien (Hund, Out of Order),<br />\r\nnicht gerade friedlich gestimmt<br />\r\nsind, sollte Kampf keine Lösung sein.<br />\r\n<br />\r\nDenn Krieg ist keine Lösung<br />\r\n<br />\r\nbleibt friedlich<br />\r\n<br />\r\neuer Lord Magnus<br />\r\n<br />\r\n<br />\r\n','2003-03-28 23:40:42',1,NULL);

--
-- Table structure for table 'forums'
--

DROP TABLE IF EXISTS forums;
CREATE TABLE forums (
  text blob,
  aid int(11) default NULL,
  uid int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  topic varchar(255) default NULL,
  fid int(11) default NULL,
  time datetime default NULL,
  lastpost datetime default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'forums'
--



--
-- Table structure for table 'greek_abc'
--

DROP TABLE IF EXISTS greek_abc;
CREATE TABLE greek_abc (
  name varchar(255) NOT NULL default '',
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  KEY name (name)
) TYPE=MyISAM;

--
-- Dumping data for table 'greek_abc'
--


INSERT INTO greek_abc VALUES ('alpha',1);
INSERT INTO greek_abc VALUES ('beta',2);
INSERT INTO greek_abc VALUES ('gamma',3);
INSERT INTO greek_abc VALUES ('delta',4);
INSERT INTO greek_abc VALUES ('epsilon',5);
INSERT INTO greek_abc VALUES ('nu',6);
INSERT INTO greek_abc VALUES ('mu',7);
INSERT INTO greek_abc VALUES ('eta',8);
INSERT INTO greek_abc VALUES ('iota',9);
INSERT INTO greek_abc VALUES ('pi',10);
INSERT INTO greek_abc VALUES ('upsilon',11);
INSERT INTO greek_abc VALUES ('lambda',12);
INSERT INTO greek_abc VALUES ('omicron',13);
INSERT INTO greek_abc VALUES ('sigma',14);
INSERT INTO greek_abc VALUES ('rho',15);
INSERT INTO greek_abc VALUES ('omega',16);
INSERT INTO greek_abc VALUES ('xi',17);
INSERT INTO greek_abc VALUES ('chi',18);
INSERT INTO greek_abc VALUES ('phi',19);
INSERT INTO greek_abc VALUES ('kappa',20);
INSERT INTO greek_abc VALUES ('zeta',21);
INSERT INTO greek_abc VALUES ('tau',22);
INSERT INTO greek_abc VALUES ('psi',23);
INSERT INTO greek_abc VALUES ('theta',24);

--
-- Table structure for table 'i_production'
--

DROP TABLE IF EXISTS i_production;
CREATE TABLE i_production (
  prod_id int(11) default NULL,
  planet_id int(11) default NULL,
  time int(11) default NULL,
  count int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'i_production'
--


INSERT INTO i_production VALUES (55,18,2,40);

--
-- Table structure for table 'inf_transporters'
--

DROP TABLE IF EXISTS inf_transporters;
CREATE TABLE inf_transporters (
  prod_id int(11) default NULL,
  storage int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'inf_transporters'
--


INSERT INTO inf_transporters VALUES (9,300);

--
-- Table structure for table 'inf_transports'
--

DROP TABLE IF EXISTS inf_transports;
CREATE TABLE inf_transports (
  fid int(11) default NULL,
  prod_id int(11) default NULL,
  count int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'inf_transports'
--


INSERT INTO inf_transports VALUES (17,7,100);
INSERT INTO inf_transports VALUES (40,7,120);
INSERT INTO inf_transports VALUES (352,55,24);
INSERT INTO inf_transports VALUES (352,20,33);

--
-- Table structure for table 'inf_values'
--

DROP TABLE IF EXISTS inf_values;
CREATE TABLE inf_values (
  prod_id int(11) default NULL,
  armour int(11) default NULL,
  attack int(11) default NULL,
  defense int(11) default NULL,
  storage int(11) default NULL,
  initiative int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'inf_values'
--


INSERT INTO inf_values VALUES (7,1,2,1,1,30);
INSERT INTO inf_values VALUES (20,2,4,2,1,40);
INSERT INTO inf_values VALUES (41,8,3,1,2,25);
INSERT INTO inf_values VALUES (44,16,6,2,4,20);
INSERT INTO inf_values VALUES (50,1,2,1,1,60);
INSERT INTO inf_values VALUES (54,12,5,4,6,35);
INSERT INTO inf_values VALUES (55,30,10,8,16,10);

--
-- Table structure for table 'infantery'
--

DROP TABLE IF EXISTS infantery;
CREATE TABLE infantery (
  prod_id int(11) default NULL,
  count int(11) default NULL,
  pid int(11) default NULL,
  iid int(11) default NULL,
  uid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'infantery'
--


INSERT INTO infantery VALUES (7,200,30,0,1);
INSERT INTO infantery VALUES (20,184,380,NULL,7);
INSERT INTO infantery VALUES (20,50,439,0,9);
INSERT INTO infantery VALUES (7,100,109,0,2);
INSERT INTO infantery VALUES (7,50,439,0,9);
INSERT INTO infantery VALUES (20,400,207,0,4);
INSERT INTO infantery VALUES (20,109,352,0,7);
INSERT INTO infantery VALUES (20,250,182,0,4);
INSERT INTO infantery VALUES (7,100,260,0,4);
INSERT INTO infantery VALUES (20,500,260,0,4);
INSERT INTO infantery VALUES (20,177,376,NULL,7);
INSERT INTO infantery VALUES (7,250,364,0,1);
INSERT INTO infantery VALUES (20,103,341,NULL,7);
INSERT INTO infantery VALUES (7,50,441,0,9);
INSERT INTO infantery VALUES (55,151,352,0,7);
INSERT INTO infantery VALUES (7,50,440,0,9);
INSERT INTO infantery VALUES (20,50,441,0,9);
INSERT INTO infantery VALUES (55,5,182,0,4);
INSERT INTO infantery VALUES (55,87,376,NULL,7);
INSERT INTO infantery VALUES (55,6,380,NULL,7);
INSERT INTO infantery VALUES (20,50,440,0,9);
INSERT INTO infantery VALUES (20,97,369,NULL,7);
INSERT INTO infantery VALUES (55,41,369,NULL,7);
INSERT INTO infantery VALUES (55,30,341,NULL,7);
INSERT INTO infantery VALUES (20,189,408,NULL,7);
INSERT INTO infantery VALUES (55,75,408,NULL,7);
INSERT INTO infantery VALUES (20,500,267,0,4);
INSERT INTO infantery VALUES (7,50,17,0,1);
INSERT INTO infantery VALUES (7,50,6,0,1);
INSERT INTO infantery VALUES (7,150,42,0,1);
INSERT INTO infantery VALUES (7,50,494,0,9);
INSERT INTO infantery VALUES (20,50,494,0,9);
INSERT INTO infantery VALUES (7,100,34,0,1);
INSERT INTO infantery VALUES (7,50,55,0,1);
INSERT INTO infantery VALUES (7,50,450,0,9);
INSERT INTO infantery VALUES (20,50,450,0,9);
INSERT INTO infantery VALUES (20,122,356,0,7);
INSERT INTO infantery VALUES (20,421,426,0,7);
INSERT INTO infantery VALUES (55,100,260,0,4);
INSERT INTO infantery VALUES (7,50,493,0,9);
INSERT INTO infantery VALUES (20,50,493,0,9);
INSERT INTO infantery VALUES (20,500,261,0,4);
INSERT INTO infantery VALUES (20,196,420,0,7);
INSERT INTO infantery VALUES (20,192,424,0,7);
INSERT INTO infantery VALUES (7,50,465,0,9);
INSERT INTO infantery VALUES (20,50,389,0,7);
INSERT INTO infantery VALUES (20,100,465,0,9);
INSERT INTO infantery VALUES (20,30,349,0,7);
INSERT INTO infantery VALUES (7,50,498,0,9);
INSERT INTO infantery VALUES (20,50,498,0,9);
INSERT INTO infantery VALUES (55,232,426,0,7);
INSERT INTO infantery VALUES (7,50,481,0,9);
INSERT INTO infantery VALUES (20,50,481,0,9);
INSERT INTO infantery VALUES (20,226,334,0,7);
INSERT INTO infantery VALUES (55,46,356,0,7);
INSERT INTO infantery VALUES (7,50,464,0,9);
INSERT INTO infantery VALUES (7,50,446,0,9);
INSERT INTO infantery VALUES (20,50,464,0,9);
INSERT INTO infantery VALUES (7,50,482,0,9);
INSERT INTO infantery VALUES (20,50,482,0,9);
INSERT INTO infantery VALUES (20,50,446,0,9);
INSERT INTO infantery VALUES (7,50,483,0,9);
INSERT INTO infantery VALUES (20,50,483,0,9);
INSERT INTO infantery VALUES (20,188,428,0,7);
INSERT INTO infantery VALUES (20,9,348,0,7);
INSERT INTO infantery VALUES (20,100,421,0,7);
INSERT INTO infantery VALUES (7,50,491,0,9);
INSERT INTO infantery VALUES (20,50,491,0,9);
INSERT INTO infantery VALUES (20,50,353,0,7);
INSERT INTO infantery VALUES (55,55,334,0,7);
INSERT INTO infantery VALUES (7,50,473,0,9);
INSERT INTO infantery VALUES (7,100,468,0,9);
INSERT INTO infantery VALUES (20,50,473,0,9);
INSERT INTO infantery VALUES (20,50,468,0,9);
INSERT INTO infantery VALUES (20,200,242,0,4);
INSERT INTO infantery VALUES (20,43,412,0,7);
INSERT INTO infantery VALUES (55,49,428,0,7);
INSERT INTO infantery VALUES (7,50,108,0,9);
INSERT INTO infantery VALUES (20,50,108,0,9);
INSERT INTO infantery VALUES (7,50,485,0,9);
INSERT INTO infantery VALUES (20,200,278,0,4);
INSERT INTO infantery VALUES (20,50,485,0,9);
INSERT INTO infantery VALUES (20,88,335,0,7);
INSERT INTO infantery VALUES (20,200,211,0,4);
INSERT INTO infantery VALUES (55,50,109,0,2);
INSERT INTO infantery VALUES (20,15,414,0,7);
INSERT INTO infantery VALUES (20,15,425,0,7);
INSERT INTO infantery VALUES (55,40,424,0,7);
INSERT INTO infantery VALUES (20,222,323,0,7);
INSERT INTO infantery VALUES (20,222,317,0,7);
INSERT INTO infantery VALUES (55,50,406,0,2);
INSERT INTO infantery VALUES (20,80,296,0,7);
INSERT INTO infantery VALUES (20,80,293,0,7);
INSERT INTO infantery VALUES (20,35,390,0,7);
INSERT INTO infantery VALUES (20,200,186,0,4);
INSERT INTO infantery VALUES (55,60,323,0,7);
INSERT INTO infantery VALUES (20,400,163,0,4);
INSERT INTO infantery VALUES (20,150,314,0,7);
INSERT INTO infantery VALUES (20,217,315,0,7);
INSERT INTO infantery VALUES (20,40,333,0,7);
INSERT INTO infantery VALUES (55,84,317,0,7);
INSERT INTO infantery VALUES (20,30,326,0,7);
INSERT INTO infantery VALUES (20,211,311,0,7);
INSERT INTO infantery VALUES (7,50,100,0,9);
INSERT INTO infantery VALUES (20,50,100,0,9);
INSERT INTO infantery VALUES (20,122,298,0,7);
INSERT INTO infantery VALUES (20,20,355,0,7);
INSERT INTO infantery VALUES (7,50,120,0,9);
INSERT INTO infantery VALUES (20,100,312,0,7);
INSERT INTO infantery VALUES (41,235,426,0,7);
INSERT INTO infantery VALUES (7,50,117,0,9);
INSERT INTO infantery VALUES (20,50,117,0,9);
INSERT INTO infantery VALUES (20,200,18,0,7);
INSERT INTO infantery VALUES (41,111,317,0,7);
INSERT INTO infantery VALUES (7,50,13,0,9);
INSERT INTO infantery VALUES (20,50,13,0,9);
INSERT INTO infantery VALUES (20,150,46,0,7);
INSERT INTO infantery VALUES (55,100,315,0,7);
INSERT INTO infantery VALUES (20,220,300,0,7);
INSERT INTO infantery VALUES (20,50,120,0,9);

--
-- Table structure for table 'invitations'
--

DROP TABLE IF EXISTS invitations;
CREATE TABLE invitations (
  aid int(11) default NULL,
  uid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'invitations'
--



--
-- Table structure for table 'journal'
--

DROP TABLE IF EXISTS journal;
CREATE TABLE journal (
  uid int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  subject varchar(255) default NULL,
  text blob,
  time datetime default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'journal'
--


INSERT INTO journal VALUES (4,3,'Jumpgate PW','$1$cWgo.pUE$81tsP6M682pq.BJbWcVRx1','2003-03-31 21:31:06');
INSERT INTO journal VALUES (2,4,'colonize1','tetha lyrae: 2 mars class','2003-04-02 20:51:18');
INSERT INTO journal VALUES (2,6,'Gortium minen','oldie v 1 und oldie III 1','2003-04-07 17:59:06');

--
-- Table structure for table 'jumpgates'
--

DROP TABLE IF EXISTS jumpgates;
CREATE TABLE jumpgates (
  prod_id int(11) default NULL,
  password varchar(255) default NULL,
  sid int(11) default NULL,
  used_tonnage int(11) default '0',
  pid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'jumpgates'
--


INSERT INTO jumpgates VALUES (61,'$1$dYHwpRpi$9vSHRb8DvAKuhP2qmzKkA1',25,0,109);
INSERT INTO jumpgates VALUES (61,'$1$cWgo.pUE$81tsP6M682pq.BJbWcVRx1',65,0,260);
INSERT INTO jumpgates VALUES (61,'$1$e5MxS.i2$eDxZZXZ6WIw0zDfGNsjMi1',100,0,406);
INSERT INTO jumpgates VALUES (61,'$1$L2XLS3Jk$Zlc33dffhGJxvrLycap63.',55,0,205);
INSERT INTO jumpgates VALUES (61,'$1$am3hCJef$5Tb10Q6YG1F9jn1mzGmaj1',110,0,439);
INSERT INTO jumpgates VALUES (61,'$1$Ez9Q1xP6$fnrUdvzpTi7U512SfxjUJ/',18,0,83);

--
-- Table structure for table 'jumpgatevalues'
--

DROP TABLE IF EXISTS jumpgatevalues;
CREATE TABLE jumpgatevalues (
  prod_id int(11) default NULL,
  tonnage int(11) default NULL,
  reload int(11) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table 'jumpgatevalues'
--


INSERT INTO jumpgatevalues VALUES (61,5000,100);

--
-- Table structure for table 'keksession'
--

DROP TABLE IF EXISTS keksession;
CREATE TABLE keksession (
  uid int(11) NOT NULL default '0',
  session varchar(255) default NULL,
  time timestamp(14) NOT NULL,
  UNIQUE KEY uid (uid)
) TYPE=MyISAM;

--
-- Dumping data for table 'keksession'
--


INSERT INTO keksession VALUES (4,'55e83f30e48355f21f492b0282b44775',20030409103856);

--
-- Table structure for table 'kekvars'
--

DROP TABLE IF EXISTS kekvars;
CREATE TABLE kekvars (
  vars text,
  sid varchar(255) NOT NULL default '',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

--
-- Dumping data for table 'kekvars'
--


INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','eef6f396fdc766dc0ebf2b1267223010');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','c84651a0f1cb25c3d678985b2efe144a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','bbd54f4f0a3cec63ac987b0aafaa4c80');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','fb84d7791bd25520f4ed5fd6514941d7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','41f46ac90edee97257e2d404c722e4a3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','447b9d9a3cff0474706aec84303f517a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','d030993465c4aa19f4e05fc1bca3644d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-768.333333333 -380\";}','5ff6a014761787893fc79b0035bbae29');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-384.333333333 -2625\";}','92b93631b42091baeebb1a1a6fd7180b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','8bd495127b5ce1c786d2281e02ed5e98');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','9bc2b9058be1a0e9467a1acf0c7cdd05');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','e9f2080772f60a69135fbccb5bc19e73');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','8011bcfcd0806408c24f74574bdd1fa2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','75af0d35b90322d37bce92e39f66e9c0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','3b93bfe9a245d0a5782f8890403b249a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','bef95a7e58eaaf71a4ca2fdd5938dd15');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','46cfa2c8a33d3eaee90597d1f2840534');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','cbb1adffebb7dcb86ff002faafab86f2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','08aebfbb6fd58375807f1b0df8b206dc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','d7bf1eaedee8a1e60715d27e337b7e3e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','bfb76c7e6a0bceed479beddd61039701');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','3c490ffe4d3d5dc75407db780f8e08a7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-550.333333333 266\";}','9f02f57c82b02abed1f4eb4cd36a6103');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','8d0b33e7732589da9381689b0b182373');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-384.333333333 -2625\";}','9c494babf9ec4ec66357f50476e8fdfe');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','c419a59236bcf9984ca138bcc70d8f22');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','7f4628f16a6617a0d98ebdb6ef37437b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','63cda4a13ee1d55c009cedbe986c7df6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-2609.33333333 -2006\";}','861595a7b30874d82988bcb919dc89c8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','9d731137f21e124319e7cd9e09e0ffe4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','f1783bef721b97da6b570d9348f65506');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','54ded90a3c35f97cc6601e6c9e3ec29f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','ab5dfa0696e42623e0c39078a0ce8ea6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','55fb0f90d44470c5736b79e920b6bcae');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','cd65f081108eb815f1f5f344275f4362');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','565830be652f62bdd8fd5fe9274ec2e6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','ef0b85a37c6ffe8e65bceec385ac3dd7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','a2f429099b6922235cc5d2e1af6fe11b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','f3fc1aa3bbe81a488a136950c3088209');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','6fcb5c7fdce9ad224e4c7c2dde8f4d9a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','7766cf07abf7aacd0fece6bacf3bacf8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','799172f9cfa69cfc62e05294526296af');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','0ecd116485a6ab8e3d45ccdbe757883d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','eb87b7b96ad4dde63515aca32b2c96de');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','bd098c0d2c1a8182078925491caa6bc8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','84d295ad1b90ad3261a276833ce3026b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','63176a8b496a0edadddd535aa20e9325');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','35c3c36e5bbc7436af0705a605fb303d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','99e6aea304e5d76e1a3b45c168ae54f6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','fe734121c7c9c9767e2791adc5c7b174');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','3f3e00d5e2649658813d736406ebcc0d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-550.333333333 266\";}','070ff93a3047c374732ce3eb1a23c41e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','ac5a0c717f3cd563b3c2b9c3052240ec');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','ec50835c517ecad73350cd55f599324d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','47ea68c100543e632348344d8323aebf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','964b49e8679550548ba8906e18519c1a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','37170fe188fffccb814ac568edcda997');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','fbd1acfe73c31d52438a467d0583392b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','5f4ce8314f817eb61c6004efae0a8f40');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','acf4bb847e3869260dd642a7fc0dceff');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','00b04be1e8fc3a1a35c39ea9a67b9b78');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','c95fbee9afcd015bd4908d98ab973a71');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1253\";}','bc5b0658aeeebbbc26955126a7ed6eb3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','c8d8c9947a123cce60294008d6a80bda');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','b649d8d06e311ccae5c8d2dc6c0c4221');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','8bad42b72804e2ed0709a6a0a598209c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','d05c1443f2465a6c543676ebbefb1038');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','b225459f17b367fea3a3038c75ef946b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','d4f707b4301dbc0e13109b1531b6b8bb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','c26479be50ccdba9d0d73ce01bf496ca');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','3f1b21586618ab114f84f70f59f5d836');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','c401b88a0fda0f389521f91ce635884e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','204a12a9eac4af6496f627e34216540e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','622c9f3cd5cdb6b2195b6075fa05fe66');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','95d379a4b90ac02b8180702a8a702da3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','b20b6a4bc2ef23826efc66893f248070');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','5e4463d4ff254af1ceffdeecd8b87d50');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','683bf2f3ea928c7b371d0b9b39f7d8f0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','2410da50bb429d3a835c72c583be3127');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','b8bd4dde19f9a3b0dc63c9127d09977e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','0909cccc3f41debbe25fdc805c948c52');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','8822bb100a52b46772d17c49a66fd371');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','fd1bcc5897065f31e9e317a434494cae');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','cbddc4e41af0b0515bfb352b5db917df');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','e77d0abc85ae36b265853394758ff297');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','2739c05be566cdf2b19dcb882348578d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','59081fbf3a1c88561690b4a22114fbca');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','ff5678c025f00b5e7e541a0513d6622c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','feaa624f1446d65d59fe3b44d83d2cdf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','12ec863e054e3e017e404180dbe3b345');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','fc587b8c07285590add7438c20907929');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','d51e7f0f77440bd480cc62ca67901031');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','bf8910db108d34dae9ba69aa000a0c81');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','d8dbad465a0a2218ddf16438addc37dd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','0180facfc21af0d38e51e1638e2a9366');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','a76611f4d6b52e2bc4b74e37054c3151');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','4822bed8a9ebd5732a6689f0d15b524b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-768.333333333 -380\";}','9996f961920e148634c2ab30dcbb08c0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','cf853042981c21b3d7bc6e2169bf1c8c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','4100e33b724eda90430520674361f3c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','a60bdfd32ab057ad3f7698c39aee05e8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','e7fe9cf71edad8a86c34d203dc86d1e7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','9cbd67625b73e76630e12ac7d5084c99');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','66a679a6960ac98c93e7f807f971d267');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','c01fafa21e81bc624de65e91ef865482');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','8e61df0536c262978a2a456768e3f431');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','c3009a633ba3bbb29490c4ec0e6d476e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','f1357e4f12c0c67d406a989dbb0d0fe7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','5c3205e63a1cf9c8aee8060027e052e9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','62b0ca460d298e86f68bce7675d143a7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','98c360f887c280937ce428da39815a74');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','23ce2f162eb19fa0d57526048be1ba6e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','8373fd1f8f665f86adaf53d17ceaa018');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','fdb138ddf30c2ede2b582c0bf816d959');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','d280aad3d0f2851532d585385b30825e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','9b392e35f07b878767ecf2435e1e845e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','9c66eff3d8ef1dded7d5c243100a7f92');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-768.333333333 -380\";}','1b408e0c0d96def2980bde73864124c5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','352988d4a925e0a3424753652ba3ad0d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','b5aa4062e7e095613bf4780143b7d3ce');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','c6d1f9a43ce869520227865492240c31');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','cd9a5dabf0b20904e825c740e1e698b5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','5d6d21824828e92bbee732a57de86fc4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','781d02908b83c9fd8ea5a5f2a48a7f5c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','c659d026a1b1ae42fe3388666373e0f4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','8f48919c73be6b4464c96829ae586999');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','6dff04cbbe69ab0e10a2c2d8e841f9b1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','3e9165dfc4bdc87b72ec8a2ce9639566');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','28ac7dcab092461fe32d15d69ff12dd0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','3ddd6951eb9424ac45fcd571139695ec');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','f9c832c23c1a0a3e3f3be0f408d761d9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','eac80c77e09b953f0c6a269da5ede365');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','2178dd686dd75df352820cc2385ee111');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','98f39893dd3af3097dfa353547cc9480');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','2a49fd2d054b6394f586f599443afb71');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','25b31aa1601e33191781baaa7c059970');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','68246f1b529a055aeca32fec300fd349');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','a5f95d2c995dc3a98abf5ba83494b02c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','3925d60085c4d54529eca8ca6eb6919e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','ab61136c66eb2dc69a64264a90467360');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','a763fe1373afe492b8380af637cf6b8b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:21:\"-550.333333333 9748.5\";}','e3e245e493080ac10ad18df50615da15');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','3f5188ae388e81a72327ee16dabe4208');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','37eea1e307b81b220687f8f4ca2aaf4f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','b3f8a02dbb84af8178b8de85c928ad10');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','9eeaac9685383cd74d6b939e917338ed');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','8eb5ceb92c77700d4f427f4f4543f83f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','5b678d30829f09a8373a7c5434f6efcb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:18:\"-2217.33333333 -45\";}','09973851f6a09d0699c637f9652220cf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','c0545625792a1a1adf09b9082c158f8c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','572706f8a63d40eff21a3b81324b999f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','19b45507683673ac2ee0dc54f85f59a2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','56b57efa527087a476ab9febac3dfb62');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','e439c00e7307aea206e62755638b560e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','51db7820f72663e26e317675baa2290c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','d30487cff340fa4c30ce1924d93815b1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','a082723d8f9f08528c679589bc00ade8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','0921cf64909262b0927869ccb2c4eef4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','84c169391b24691aa47b5cfa8dbb0468');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','fbc3e06b9388cfcbff7efb47db8275d2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','77921facfe94423f63fd2b20a804e76b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','afc759f10cf347844b41a28da30bbedf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-550.333333333 266.5\";}','51736b0faee34c07a07d31b65e2567fa');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-873.333333333 -2374\";}','e04d4fb4b81977aee4549a033d5075ba');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:19:\"-1971.33333333 -902\";}','0eb5461d2865925c8f660474711c4ec1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:20:\"-1443.33333333 -1243\";}','0115da1f178144acb89c1068a57d0119');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:22:\"-1368.66666667 -1150.5\";}','192b1bd0a771e6645891e1efd30d5fa5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:21:\"-1971.33333333 -893.5\";}','50b6b1103f48b908476bb30a9afeae2d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:22:\"-798.666666667 -2281.5\";}','5545c15a0463070510a746b4462ab571');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:22:\"-798.666666667 -2281.5\";}','b7a5853ddf33c660a0309dfe0fe4bfb8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:21:\"-1971.33333333 -893.5\";}','3a990306682c954e388ad503e430ac2b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:22:\"-798.666666667 -2281.5\";}','247c72d6dc53d144f1ef7052f4f3c441');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-505 -2191\";}','070870fe65e4e9535c06ab0e4b62e7ef');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','6390215ff5a165c53b2ec21a1ee0d93f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -902\";}','2164e242c2f79017a2f514ffc2418989');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -902\";}','9462fca5b7ad6e5e1047eb6b1c698096');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:13:\"-2241 -1822.5\";}','87dd5bfa02579608a929f1f8c73c67be');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','8eb8a53deba946881125515e38ed2b67');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1203 -1188\";}','1145947baa7209b1f2465636abd7f831');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','c61b03d22db2740b7ff3f056cee2917d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:13:\"-2241 -1822.5\";}','53c5a10719ea8e1eb5236824b5d00470');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','bb290c1914677df3bc1171b68469169b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1203 -1188\";}','bee556afe3aeaaebfed71d3a24dba74a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','27c70207c02fcbfcc94c032e03c34c50');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','4cbddf513b7aafb9fd8affd901fd0515');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','8773e943a20f53062dcf5768e283473f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -902\";}','ef1b7756cac3eabf6940948e0e251888');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','705a64d6636982ba3ff452113d78ec2b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','edf561ca7eb5aeac1ef16218921a819a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 266.5\";}','21058e69c93c58b82a73472109b54291');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','5384683345497527713bf4631dde0836');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -902\";}','00622e2cc6bd1aa7ec4749a1bbe57ae3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','bb898c7d1f5c6bd18b9b8b74301bb7c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','b19ab6df645cbc5e09d7af26ac275b9b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','3cb8a5fa3eefc8047aa2df0f515880ff');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1203 -1188\";}','77bc58ea5c94dfdabbab37d743b4fa80');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 266.5\";}','47c55ca27e3b5b49c3b0fba4f0edc8f6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','6b0824f48bea4313a10b9a651780992f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -902\";}','f9ad5db7d7ec541e0692022f5fed09b8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1203 -1188\";}','650d62858b78ea5997fa9fbf5c6520b4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','988ad068fa7c05de112a309738566c35');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','d2760f22f2008fef7208012d8d753e34');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -380\";}','ff552efbe7c206b9d536921842de026d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -45\";}','d0743679e90d58eae9417c773bb0fdcc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-569 -2271\";}','16794b53040d8e04a66414738f17ab35');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -380\";}','b4ee0b9d8de4a123754c7d64390ef394');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -902\";}','5a5c768d2848ba105b20c1450a487a68');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1203 -1188\";}','1093caeefbdcf341f82c0d961458eca8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:13:\"-1203 -1197.5\";}','46a797fd426da1a9ac908800edd2f70f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 256.5\";}','ba4228491ea844a64870c4682c81fe21');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-569 -2280.5\";}','7eec67362aae3f59b9f69cbbb1847303');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-1838 -911.5\";}','c8dff17c2427aafc81c513aefa7241f9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-2084 -54.5\";}','43f47e1c1d7b25b58630ef1cdc4c2356');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-569 -2280.5\";}','ebac2df7714d1b2a16d4ef8b6c3a00c5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-1838 -911.5\";}','a60c9eda718f7c76182ed7129c87df38');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 256.5\";}','2dc729341203f1dc16e6fd2817006d13');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 256.5\";}','813058079532a83c4abd3776e31bf416');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 256.5\";}','43ab397c8e8397c910e51c10170f1d38');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-1838 -911.5\";}','4288c9e90256f7046b760b8a93b6d635');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:13:\"-1203 -1197.5\";}','5ed8139b1d953899a2e9d3c167a5c62a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-2084 -54.5\";}','43bae5426c8c502d45a3efed0e95a495');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-1838 -911.5\";}','24d744e49a3d9409dcffab3f58348d12');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-2084 -54.5\";}','bcc1c9bc9caabe20f939d6c3c74e37bf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-417 256.5\";}','33ef0656ec86990c1affa18ccffa0c23');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:12:\"-569 -2280.5\";}','7b8bdb75db4cbd68eb175f9598e913ae');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-2084 -54.5\";}','4429524fad6fbefa350dbd4c3f252d29');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-504 -2191\";}','ab85ae7a344aca1578e58273d2f65f56');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -46\";}','96574f8538af1cde43e0ecee7174fc4d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','ab181c3dec9f84e2686e1e08ce318585');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','59eb8dc8cb420dc0594ccb65cd3f4e71');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','c8495fa712dc0c117f6e1511b64b5b8d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','c8b7a267e828f1a93380f66407877b33');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','e2d066d674c496a055700ca3c4a369ee');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','c735617abf66f69176b46353aabe5772');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','437f6074fa70d6a606339cffc3ec6b1c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-2084 -46\";}','782f7308d18d33a5c6ad4c47ba24a5b2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','7a6587cb92ca3548ece3cd9f240c54a7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','16f9828a1eb816ef6af3949978807201');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','7876b1caf55dbd586b221613fb87c848');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','48cb60d5a7b34f861eda74e48bd4abf7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','cd0a800b2a30084516d2386ffa655d06');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','b7d2b250ace488f8f945e2bf016f897b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','5d96f98404fc16389ae15c00ef5c676c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-2240 -1823\";}','0cbc97d4c5c1827079d6bd5a1ad8b580');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','c1b0e1f2d5cd9d30ed93e4cbe67a3f7e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','8764e5a7c994c444df76d61e93968107');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','4e8af2b96ae9f048febe0395247af74c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','fabb0a976e202b23c1d0da26783b8648');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','e0397e5ed808974e2c96231645ade6b9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','dd40611e6161c425cea83aa9d4262518');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','86261f11bdaa94cd079fa9f784eca4be');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','f416b6c4e25964930490eed185a42799');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','97b35c31eb78486f0d6ef99c8fa96830');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','955bc802e4ca8702aea8803b30f69a82');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','eb0bf6ef449d3d8faedf06051e18e651');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','cbde98842759725e6d1887cd769f8256');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','6a8e4b6a01f6b433dd4ef083dd600bd7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','fba55bce6e3ce580adf89c3e55f3de7c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','d397457abb050edf12f38394b09feff6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','07451eba6cde14ee6ddfd89ae743095a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','dc30aaac1ffda794bf4bf1e82332ea70');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','a64e310dea4e3f508c13a8c53d4a5264');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','53f1a8317caac037a7000d1743cd1e29');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','03e39505f59631b13f8f2111fd9d5a50');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','8443bd49f7e083a4f96d0aaa7b74eeab');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','f5e3540849828933d3e202b0f4a13600');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','765b3fb955dae02cd84526781048102e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','f932cabd9cef1f405c792091d7259586');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','cd5b4493266f44aa0c66a422bf949a2b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','ec87f57735e139cd96778ea36dc963a5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','17c924f9a141b9bcf53a3c98c095ec73');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','66deaa20e22819c58a2f42aec2161364');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','c7d2aa22f1dad5d454b24ae358e59eec');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','f01cf57f30a31e3f6a17f83eb7d6ba0b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','5d62503b3c3d6c0c986ad13552251217');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','c9ab10dcf543450d438dda9e542630b1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','bfa7573d4bd8b85c0051ddf60c82a601');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','7a5bef4c20bb5c37d19873e637de25d2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','850f4d52a7725c876502937ef6213ee0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','aec021739614aea9a8578847c03ff761');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','3828096df6cfdff85443367bbb4285d0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','d588496b504d226afd543a0f5cb4c07e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','36ee85e4a334ca8072c40ab17f4758d0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','0f253002967aa2e8b566df9e8e8bc765');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','697d3f7949e48ba55bcb177764735b3c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','0f97fa45c43db112236944d21ab6e4df');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','0636830d132e754165f0f7cb410422ac');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','3fe42ce296417f619a977965a09d3bad');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','5e78087732b8d1152c8088fb6c5fe156');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','429ab1db3249b96e5705aef9cc2d80af');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','afff832ec28e813d31988103811f93ff');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','31db0b86d23a36c3c4cde526c2a35d52');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','feb28a27d93c01e3c0d0ea8c47f7501f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','ab0d5fcc0d02d80690e44e6e04634bac');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','ff1f0dc854f5e0fb04a927711241d32e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','4e723d2e13fe26e85b893f577777c5a4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','f16ca217b452fd81f5ce20ea0d7ffea4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','311a37d77f8e17367284a7225e998103');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','0428f19055c47e7af8458923779355d2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','0a88a0c4e2ab914d4257070842e8b8dc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','238ddda18a6dfccbc7fb197c0b43dea4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','f166a592f85e75ee31ee6045bfb036c9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','c9621b3e6a6b249f8c155885715eec80');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1976 10\";}','e57b90c4483f45e40bc6b67939c2d1c4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','f6e577ca2da483e886fafebf60355cea');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','126bccccc5278ccbfde95c7a3618e9c7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','94ef5a445c9ddd994a5f884911ec34d9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','7c9a54bff1044aec1565ddfd20571c80');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','0fe04d4fa815378af1f1c8e5ccc89a60');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','0757f6e77154ebe109619e3fa857cf65');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','68b2bb98eb2a1fda30131e2b8d296c0a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','491ce3e54fc3fb2a6eab87dd2fc76cf6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-740 -2375\";}','87a6937fc660a83a5cc66575dfc35c85');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1310 -1243\";}','368c6a18033375408dd78364ad6ba7c7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','b880bde80ed463168ec6151d9b4611d9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','97d9f3290c993c781314b70735bd21d8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','497f92919a1e0d5c81ab1f7b413ccbad');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','e098314572462bdd619f9a2416877ce4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','da6a76853d6570131ebf3fc651c60811');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','fe1597802e76bb32bb8681dd2c46fdf6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','0752a0993464c801dac3024241105a07');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','e64774410f23acbb2009f84bf7a08486');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','166f55e8b88cf2f99b962e4bf79d2bbb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','1d485e6030866d46672e8dd84efcb9f9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','53d3177e5423c42688da42229ddff4c9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','eb261b544fa81daa2fd2a72cf9f5c449');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','835440c1c5a810e78ca9df3f22e40452');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','e4e0e54eeb9bb2375fa8371279cb2122');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','bdf2b6fdce180e23771566786924d1cd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','83bfbee6f2a536c6320b39bec8e173e0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','4366f4d1cb96100c83d49ed927df44ea');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','f33d4159beb4c26add85d0860f5791ff');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','e99f285ecaa9d3fd1932ed421b7a4dc1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','bea7be5f662fc5bc91a62535f33263d8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','29f7948528b6bb7931013f9b675f0782');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','174109187d7cedbaf85da83afe1e92c5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','2395e607929373dc2e7e01229452cca8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','f716fd21bbf4ef1a70bb3e6ddedd62b9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','e8973c66d54889abcd3e28107a6b422c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','25f498e86df7697c8086bb0c977e867a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','34239603ca668989b4ac6f38ddba12d2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','fefb40c743b40ac58e62a29a222fa8ed');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','c40c2a61aa5d6122f264f22a9c4f1b62');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','90a65b25bfff80ae6cdba8517b30530b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','382b76d83260db2f1ec27c2aa402dce2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','07db1970f32748d7c36ab1dfab21e8b2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','9b250547661cf7afa5d1e54790155148');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','7c4a42f6bd49047714fb385525cda617');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','d14802e406ccc301b2df81dddfa46c42');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','c8dc769cc777553c7d52165a71e6298c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','46ba5744489cacdefee750400578460e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','481838b017a77a536e605e2b5b120e45');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','e85fe15f4870db7569d50fbe94b68309');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','78943854db4897fd31811b72f2f2830d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','4ba0cdcfb1a094c0e6b5988f0ab60dd8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','76b9380766ec880361cc1f2c47f8956d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','6e022e485ef7992016f683690bc766e9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','12450b6fb6db7cb74c7a4d9d690b30ad');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','22e4598f06d22334367248d1c65f34c5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','33163b06ad0358c118795c0572955a1d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','e2b1972b80646597156addcb261484cd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','aaa77ef3c4bbc37d42eb5c8612a55155');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','9f31d2fa05a25bbfcc874b3ad48a9f62');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','8f45e2ac73dc7ff93131352e0999539d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','9dfeac857aeb23fee1b2720d276b51b8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','d36f8f3a58992a242a42bd964c597100');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','9ce3914f3367768e74710b24ce76579e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','e100e10cdd5552283343a15bb475b6fd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','1921523833eba82162744032bd7ced86');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','f55102d40ad0a2eace2dbfba25c868c5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','1c2444021bdd58b2a62ce0ae7ebfc35f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','8e9951a78079900914587e534e0d6fa6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','d82ebf4726f6f627bfd16ce0b3931bff');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','c1c1d73c16baf4f868b22436fe5042a2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','4b4191001bd816d41b5413651aa6ed99');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','f4b1a2f1c6cedf7f0013bcb794b627ab');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','0652ae45d5511938227dd52c5047e7c3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','8f7e6f36bf689f9202b8e3a9a857a9d5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','ab5fbf245ed872156647673e2e811c37');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','55be55245dc8bf25cde4f747a29158b9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','ba2e1ed4526f95e1dea6b987df5a0ec5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','34a43f4fa26932e1b6bd2b2fb4206164');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','a88b175620a29842e988e5f5d2930746');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','f89dda5a1016c7f889129cb9dcbc321e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','78c2c4b9d2312d42c86a6814efc77a63');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','f29e6e2e3af97c1d29cadec10a0af067');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','34feb269bcc0a2dd4d236a856352c97c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','fe3af3f908f436e396722777257c55da');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','722711d0dd159fe3a8d4c4f07e35da61');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','88f49ccf290c6d9363e933e799af5fb8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','2bcc142ca206f498a60b9d1cb30cac06');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','64ec84a312a2c1d70892b26b0e944e58');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','5b86c032e36b72c741282065a6dcf388');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','2e877703ad433a9630b6a791ff1b8ba9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-417 265\";}','cf14843b05efb5cfd2127d08c8686075');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','169425f8abd734f14dbb59fa616c10f7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-309 321\";}','7a4f732e638558f771549f815a5430f5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','39bc3a15285a30ed3c66f559a3a1062f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','40b27de5aaf8a293ae09c595e99728ea');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','9b1d09971927c684bf764bed1c8a5dc8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','42c2e1caf03aea77e301438c90c16200');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-309 321\";}','dddba95039bb547b070b7fdf9b8846ca');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-309 321\";}','d6feea7dfddc94d03113449bdcb6f2f2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-309 321\";}','4d8685ac2bd9711a01533407ac009725');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','5fcb302b23784875f8df0f20b7abd3ef');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','b35e56b73209a1d04c2d192a939a84f6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','f322f91ca6ed33b5e243f92ae805c3dd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','6c4de0d3a0a40e672488d1f0836c8f35');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-309 321\";}','2976f37d8bdd35185fca70d7629bb6d0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','5d4c803e055f1a571595c95d82650a50');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','b919ec6cf7d955e502dd7722f8fec258');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','38177299fa80af734c01b70b64335721');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','29d518f3dded4016726c14dd599ac4bf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','d19f93921b24169862f5c58b3169b33a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','8fd6276c96d0fc2844b8a2f6beb34d9c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','1b417b4292fe0c6fc13940073039cd0a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','19ad3236bc190b34652ec84030a1fbe2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','456c415d2fdeace56217c83ca8a2fbdf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','3d2fc7d2dff3c0ec90646100754a62cd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','7719b01969338b434d6d4e572f97627a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','644f15609046a67461ade3d150fed257');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','8ecfd54b42b86cf3f762db98c146fd1a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','da0ef8cf34601db891330c9540070f3f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','4339ddd649fac34e5ecc3972a18a8a5b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','ef2c8e28f646161a60238153eccc6dea');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','ef2f8eb017543db3b6098b999e3f7eba');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','73f5680e07001208ebbe2fcbadbe7505');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','c1f45272d65095637cbdce3e4bdb55c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','aade507c4a5b83922d9012e4b5e4bcc9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','efba426733471f5082356018ca42f3bb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','f7ae87478e2ee8f572783963cbcd396b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','3c9f27c0a3d22b262f2a01b196f1b0fd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','0d51d2711e5818297d789de272a962ed');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','a03ce5f50900bcdf5471c76683403835');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','ea820d958a615cc56fc4c84654129f7f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8231ef64f2ce5afa4eed42b628810b3e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','3095c6000674af8e5d2fc49ce323dc44');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','d2f38d7bf652e6185987793b175c8594');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','64f9a054bb899050ae1aadb2568e2a49');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','b1c4bad51e37ecd83d74461cb722df90');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-2240 -1823\";}','223314f2966cfa5ff13b3954de151e63');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','3f0ef4bd98d3fe6a81276c7848d460ae');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','9e7e770223520af09fdf7a786bba2953');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','0aeb747279f435dbc09f06a3bc1169bf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','29e4d041479659c779351dae220ba0cd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','4ca622c6067640019c26ec1399edb928');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','8c0d1745e1b2c834731139473640961a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','6ff7c58ef2739bac86681b09106550bb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','50d0bc062df0e14271f92d668787ecc4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','49f0352e47dd9c9d759da23e858258d7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','ff4e4991da50766bc3e4d080378df585');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','703339ca70faf2b73e5591169e9085f3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','6d1ce3357687c6187de970efb325378f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8967c81851ee265610d8f94a7e6e3f55');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','c7158c36766882a4e5fa2c8554283fd8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','f269d8f3809135282169729f0523ed43');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8e1a0d96fe60be3a94522a68fe85f745');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','7de7674699d8d36666b6e96abccd18fc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','a4a779a0d131a71d2e39c441a8bbb252');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','1b4e1fd4d1b4a8169df35c084e1ea520');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','c6864835aa5c4d859176baf50d4ff92c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','e1acfdd7e83f3f0268b23fecdf0d8cb6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','848c389e12a7c200243e6007619668c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','62c1bd3091dc4eacaaba1cf6c879111f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','e071963297b737571f4587461c9fad5c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','6a6ca0c0c760e2e944f2375f645d5d51');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','e414b2b40e109d9098595a7d14627875');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','fb49a7c9322e1aa608be91b7b7919399');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','09ad2655b421436f42557e6c450326eb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','956ce3a592886de155ce8256ebab4422');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','c173a477ae485f29740276b2dffe3610');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','632d0baeaea499e53bd22bb9ea97de9a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','7cc3bb1b3309c8ba3f5efce244f9afa0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','fa99596877090e3d5c8e6749ae01e9b3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','25323870b5240322b8657319103ceb84');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','b4811de48d60ccd943a41d6f4f7f440f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','3efc04f6043767bb47ef2f26bbdecaa9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','f75037b10c72014d8fe4298d76c3fd26');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','ef905413b1a48902fa32d30cf3ed5fa5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1838 -903\";}','6031267cad152336a54a940c45269261');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','d0bf6c792d020f5fcfb0639ba5da61dd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','c8b93f3b4d96dfad6deab3dd7a23b3d7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','4664154bba57bd2ceacb7ac46b9cc3ce');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','bf62f98cfe57b44857d8d5b5517afb0b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','554ac7253762075f1d05a6da65347339');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','7a5fb630c5378c1844eeecf2a7961846');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','ecb58126a5d81f2da9186e907c127e2d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','17fe2338893301b241cdcf765b430348');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','4a866fec003355da2fafb6db56d7532a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','865c24d9e0302cc8566c8bbd7ca27193');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','a4cb33306a8d39208279cbe3ebbbc058');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','94013626e3a867c730b8adb1e2b8d463');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','05ea07a4792f11d4d8f4432e761971b6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','cc339c7665ca954b34a61e3630a4e6db');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','f833e52c6b2b048a9381141bac2d8ef9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','3ac91759196bb4d614a550566de176b0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','e8f80c609d16122d0d3b24a1a2d9d420');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','a7f8803661a53091a19623fea6492e85');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','43c7d48e8fad9a1050af0e8471872c07');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','3eab69e317bd8ad7ef854bdc6d140b1e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','781a49e010f48b49820e1a40016d748e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','eb1d7541fa3343331a8aba95fd828330');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','fd8719a8fa36e48349bb975f1d3a4fc9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','ed35b514e3e76111cd400c35a35bb2c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','ab4e88d498efb04bde868940b3ce53bc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','e506fdcb55f1f5c403546b4966a86e2d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','0d828635815866831ab4f12b3ec21b41');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','91b36e8eb6b81caf1d6a5ecb7cc62fb2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','80b866bbd7ebbfd5f4b633126a063890');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','24957570ccd648e4d69a29840d91edcf');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','542a3364080212ffe3bae77f694c829c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','8a7f1020b7357feeb5b30b44cace5676');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','0d6f5bcbbdc063da1d2f5fe41310bab3');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8573c18c4d63236a4239679e1ff1097b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','b6b1719642865880efdded87c86a31b4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','6c49e10cf85e2fb710e6cc532f517f2f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','0a6df1cfd50f33274b3af7935ba1730f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','107e5d8f24fb0e85c8aebd9d9ef4636d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','eac0242b8ba18ddb64492ad7e5133f41');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','f62341d3ecfa6c594aabbde7bfa3ccc2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','73cd9fde4514f0a9375d18f04c06bcd8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','2fa4dd4fa1f9d75476cf4a04aa02b892');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','82705634e71e53e0337c73e52a7d7601');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','06aee8a9f8661c454e35fafadf2b0271');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','5d77a36d5af965dce7968fb750996972');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','2487992835c283edf6b1736bf442e844');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8306d32804959f479cd9a77593e5550a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','488e1c2486f2003a4ce58fae9af981e0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','b937ed031a141e1eac68c0e18caf043c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','3b518061740cac1ab578a9ca10d5dc07');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','cb53e0e8d76af6e0cbf9cd3ce29e2d15');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','394c167d807cfb68ce47cb2ca608da61');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','4e3904149cff9c5056a5b45800d44cd8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','4ed059395179de6b45715f85baba4ff7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','06571738ed9d27e4b2a35b8aeef8e5a6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','5a523b82b5d771e2e2b6934bf7fcd1f4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','d162a5ad152712d8da61e70648e925ab');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','a77a0d757b24fb865bb699b98df3260a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','4ef4cad45b4f7ec988ddc4378faac5ff');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','de97cd5630c6f1587ab9e2015c81fd78');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','6c889deb0a271d21fc22d9710b0a2754');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','6bc15e1b0ce86acdea90aa96833cb7f8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','ac0557a9a64cb50223fcc29a78ded615');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8e71d50e35f9c3fc17bd23395da4f834');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','4665a32bc463938c96fb613b67f88f8c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','2e080cbe74f2eb6e01fb1d18306673c0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','b7d8e8f41a14fd47e693158c62f17b84');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','1fd92c369c7a64eac3ede32c2fda6ea5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','3d3c860d0700a3110a15389269f35ba1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','7cfb355104b04dd39fbb1e02bc0122b1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','b1a5775685e7c6c1f1564df3aa711e7f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','5330e520f8949e71765ae8dc03eb8e11');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','75dfac8b8886ae53387e9ccf88c0178e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','e8f7bd012768349a5d6df7637b68fd34');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','41a88da43ab40919448f8765e5a20d4c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','19ab347c6386ad82d2e5e26357ba293e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','6137695d26c77670d80e81d45b189cc9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','96318aea4137d637839c71e4dfdefc93');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','08ebdb54631af8bb4e33aa5ba8d57597');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','ce49cd9a123bdacdec7287ac3bef4e04');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','a146a2d31d318dfe3d951303393ca18b');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','0ce7e9de344d020cb18e211f0048559a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-251 -2628\";}','a17c36ef2856af380cc7910873732510');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','c11b4366aed17c0fb030408bb3321655');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','1c9b7d0a807d1b1293663207d87bf6f8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','08e5a40a379721b3cf3206993951f3c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','e534091af87a3fb8e39fd9053220fb1f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','eb7c73740c95a7e3b8484171b8f439dc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','058483e496a5c027b01f669e80dcc6a8');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','37f3cc4b7f1bd2863d87a6c0f5717705');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','5874f2df6690a2aeee6af4bfded7da9a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','6f6b34515e861d50f6c018f64f6bc60f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','5cd134b2f9dc54c7aebcceef9af378c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','2359952099794acec3f1a8456b0574a9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','d4332a147ec07f261ba4190aed0e7cb6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','71cfecfaefd2187d4cd41a979e5add36');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','b1feda9eea7486766ab29d0d1b905ac0');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','3341e466c63253bf860f638b28aa0c8e');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','cfa0d5a723b8035e974a277a71fe40a1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','4f9e6c47d332698053ca7e6036e51ac2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','9c856b4912f42962675d3071cdbe11cd');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:9:\"-635 -381\";}','1dde6d7bf47c10d563e0245d4e6f80c6');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','02411b0938d0348c335a96c1ceb29aa7');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','9357dd9166273092e22fbd5de3db99af');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','bc9700ec8c4793f04a98d2d18b6e03ac');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','6b33836b494e159fd5319705495f2079');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','b0561dbcdcf2b277b4b17d994d66e542');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','9ba258ec332399ca09e6008e819b27f2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','26a867063492e2eab4677bd109d38e5a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','424f81542e8bddc184685c0e77cce1b5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','dba97b860c50e43166f3c6a171ccaae9');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','56d57df6dc473a582aa13847148de7a2');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','cb80c6bae6eca5b589704eeaa7711423');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','7fc863564d8c31664b1090d0b6fc684f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','2687c9eb1d625cd001e238899224b11f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','bf552d3f2bad735f174368792036376d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','f010488cb31ec3f58657e19eab87e749');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','75b26a3b06288b15019588e8c621430d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','d2b65ae9b4829f381443f684d3aabc9f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','6a67d13166b43ea821bc7bffebfab3ef');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','363b46e0fa2e829cdff496889de86c2a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','8f2dbbcfb44bd01906faef5e6933cd7f');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','dfd7fd1fda3077eaf283c8b9db3808e1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','1a89288b360b819550eaf3dcd3f3a78d');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','5be271c9913399c50e534d7be29558eb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','43831ebbe1aeb1d9e11ecc26b58ce1ec');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','8efd4a15309bd7eddc4650adb8fde02a');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','782b84e8dcd526f8884d1a7fa8ae0121');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','dc0d8d61adaef8ce83f1020982edac22');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','3980a06d68238e2c3e43e2458207f623');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','2e207b6c7c4cfdca8f54131e81ae5cda');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','1ffa949f032c5b12fdb5b0713afe22ec');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','b27da6046a85315ccf456a31fb28d1ee');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','c7ca2ade836dd665fa33984ef477d9f4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','ab1107e8414cd9964e71e1daecbd27ea');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','0161bab1971657c504822afbb67ca8ae');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','eb1759f0b2d9b408ae98ff78e425d2fc');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','e5a52b74b298ec8aeb804d5699cb488c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','9d3e77ef2a8c24bced55271b93a3d0d5');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','8fd1e38f3e1d4b18daeb947d35b61568');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:11:\"-1202 -1188\";}','bfc15720f303578bccb81359dc7c8968');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','45a5b4e9d3b2abd6e85d83e7ccb1b0aa');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','57dfe009085b5c8eee3a7486c0c33436');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','168a4dd1f3f0a0f63242bb761c588cb4');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','da65f867d734995cbe05235ccd8b8bbe');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','4010620cb789c5e2aec94e1883131c62');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','cfd0a2eddd03f50f8e340e130dc396b1');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','fcbedd9ae4872879912590337be0eddb');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-1912 58\";}','51ddf427961d6ca65126229fa9876d51');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','b2a66d31e1a31d990dc0815f04093b39');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-1730 -847\";}','550ee1ceab11266144ae7b660301603c');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:8:\"-181 449\";}','e5e6ef1bd46525eeaded946488d97dac');
INSERT INTO kekvars VALUES ('a:1:{s:15:\"globalTranslate\";s:10:\"-632 -2319\";}','55e83f30e48355f21f492b0282b44775');

--
-- Table structure for table 'mail'
--

DROP TABLE IF EXISTS mail;
CREATE TABLE mail (
  uid int(11) default NULL,
  fuid int(11) default NULL,
  text blob,
  subject varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  time timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'mail'
--


INSERT INTO mail VALUES (1,7,'hey mop - der fleetorders-link auf der planeten-produktions-seite ist weg, nu kann ich auch keine infantry mehr transferieren...\r\nwo habt ihr das hingepackt?','infantry transfer',65,20030315220832);
INSERT INTO mail VALUES (2,9,'na du bist Lustig...\r\n\r\nmein passwort okay aber meinste ich hab meine icqnummer im kopf\r\n\r\nWann sollte ich heut nochmal bei dir sein?','RE',55,20030314101553);
INSERT INTO mail VALUES (2,9,'Hast schonmal geguckt wer neuerdings bei uns Leader is...\r\n\r\nOder is etwa mop und Runelord die gleiche\r\nPerson...   :)','Allianzmenü',57,20030314102546);
INSERT INTO mail VALUES (2,9,'Meine Nr. kann das garnich sein weil ich weiß das meine mit 118 anfängt','ICQ',58,20030314102657);
INSERT INTO mail VALUES (1,7,'ersma ins nirvana ;)\r\n- dann kann ich nu gar nicht transferieren?\r\n- wann isses denn dann wieder so weit?\r\n- solange keiner angreifen kann aber auch nicht schlimm. oder geht infantrykampf noch?','RE: infantry transfer',67,20030315221806);
INSERT INTO mail VALUES (2,9,'du bist lustig...\r\n\r\nich sagte ja schon das ich sie nicht im kopf hab nur das ich eben weiß das sie mit 118 anfängt\r\n\r\nmuß halt so gehen','RE: oha :)',60,20030314103511);
INSERT INTO mail VALUES (1,7,'hey mop - wie macht ihr das mit den bugs eigentlich?\r\ninfantrytransfer2 z.b. ist \"fertig\" aber dem ist definitiv nicht so / zumindest in der map, die ich bekomme...','bugfixes',68,20030317041318);
INSERT INTO mail VALUES (2,0,'Welcome to Spaceregents, the ultimate Space Strategy!\n\nThis is a short quickstart and should give you the\nfirst hints on how to play SpaceRegents.\n  \nOn the left you\'ll find your buddy list and the\nNavgationpanel.\n\nNavigationbuttons (in top-down order):\n\nOverview (the page you saw when logging in)\nCommunication (Communiction, Alliance menus.)\nRanking\nPlanets and Production (Planets, Build menu)\nFleet (Fleetmanagement)\nMap (The SpaceRegents starmap)\nResearch\nCovertops (Espionage and sabotage your enemies)\nTrade (Trading of ressources and ships)\n\nFurthermore you\'ll see the Preferences and Logout\nbuttons in the lower left corner.\n  \nFirst you should start your research and build\nsomething on a planet (Metal mine is recommended).\nThe time is estimated in weeks. 1 week in\nSpaceRegents is equal to 1 hour in reality.\nAfter that you should have a look at the Map (make\nsure you have a supported SVG Viewer on your\nsystem) to get an idea where you are located and\nwho is in your neighbourhood. If you want you can\nexamine the alliances which exist in Spaceregents\nso far. As a neutral player you can\'t be attacked\nbut you have several limitations in the game. If\nyou join an alliance you don\'t have these\nlimitations but you can be attacked. So you are\nsafe for now but should consider to join/create an\nalliance soon. It may be a good idea to contact\nyour direct neighbours as well.\n\nThis should have given you a first glance at\nSpaceRegents. More about the features of\nSpaceregents is explained in the manual. If you\nneed help feel free to join the forum and post\nyour questions there.\n\nGood luck and have fun!\n\nThe Spaceregents Team.','Quickstart',2,20021222142031);
INSERT INTO mail VALUES (3,0,'Welcome to Spaceregents, the ultimate Space Strategy!\n\nThis is a short quickstart and should give you the\nfirst hints on how to play SpaceRegents.\n  \nOn the left you\'ll find your buddy list and the\nNavgationpanel.\n\nNavigationbuttons (in top-down order):\n\nOverview (the page you saw when logging in)\nCommunication (Communiction, Alliance menus.)\nRanking\nPlanets and Production (Planets, Build menu)\nFleet (Fleetmanagement)\nMap (The SpaceRegents starmap)\nResearch\nCovertops (Espionage and sabotage your enemies)\nTrade (Trading of ressources and ships)\n\nFurthermore you\'ll see the Preferences and Logout\nbuttons in the lower left corner.\n  \nFirst you should start your research and build\nsomething on a planet (Metal mine is recommended).\nThe time is estimated in weeks. 1 week in\nSpaceRegents is equal to 1 hour in reality.\nAfter that you should have a look at the Map (make\nsure you have a supported SVG Viewer on your\nsystem) to get an idea where you are located and\nwho is in your neighbourhood. If you want you can\nexamine the alliances which exist in Spaceregents\nso far. As a neutral player you can\'t be attacked\nbut you have several limitations in the game. If\nyou join an alliance you don\'t have these\nlimitations but you can be attacked. So you are\nsafe for now but should consider to join/create an\nalliance soon. It may be a good idea to contact\nyour direct neighbours as well.\n\nThis should have given you a first glance at\nSpaceRegents. More about the features of\nSpaceregents is explained in the manual. If you\nneed help feel free to join the forum and post\nyour questions there.\n\nGood luck and have fun!\n\nThe Spaceregents Team.','Quickstart',3,20030108205240);
INSERT INTO mail VALUES (2,4,'Okay,\r\n\r\nerstmal wann kommt das?\r\n\r\nWenn das direkt beim map laden passiert, also bevor man auch nur irgendwas geamcht hat, liegt das in der Regel an einem veraltetem SVG Viewer!\r\n\r\nWenn es nicht das ist versuch das Problem ein bisschen näher zu beschreiben. \"Objekt erwartet\" ist in JavaScript eine Fehlermeldung die bei allem möglichem auftauchen kann.\r\n\r\nciao\r\n\r\nRune','\"Objekt erwartet\" ?',14,20030303130017);
INSERT INTO mail VALUES (7,4,'der kampf ist abgeschaltet und muss ganz neu programmiert werden.\r\nEr endetet immer in einer Endlosschleife.\r\n(Seltsam, wo er vorher klappte)\r\n\r\nFür irgendwelche ideen bezüglich des Kampfes ist somit jetzt der beste Zeitpunkt :)\r\n\r\nciao\r\n\r\nEriks\r\n\r\nps: wie teuer ist flugunterricht in den USA?','kampf',44,20030311151445);
INSERT INTO mail VALUES (2,9,'hmmm...\r\n\r\nwo kann man denn nen passwort eingeben (beim Jumpgate)?\r\n\r\nähm...was wolltest du denn ändern am GB\r\nkönntest du nicht das nächste mal bescheidsagen\r\nich fand es war doch gut so.\r\n\r\nDenn jetzt ist ne lücke zwischen dem\r\nbestehenden text und der option neuer eintrag','Na du Pappnase...',83,20030403214055);
INSERT INTO mail VALUES (2,9,'Hi','Na du...',16,20030303170918);
INSERT INTO mail VALUES (2,9,'vergiß es hat sich erledigt','RE: Gortium',49,20030312110818);
INSERT INTO mail VALUES (2,9,'en...\r\n\r\nalso ne Mine bringt nix,\r\nman kriegt kein Metall.\r\nUnd scheinbar ist auch nur\r\nauf Planeten der Ancient-Class\r\nEnergiegewinnung möglich den\r\nauf nem Eisplaneten gehts nich.','Wollte mal Hallo sag',63,20030315121719);
INSERT INTO mail VALUES (2,0,'$1$dYHwpRpi$9vSHRb8DvAKuhP2qmzKkA1','Password for your jumpgate in system 25',69,20030324170002);
INSERT INTO mail VALUES (2,0,'So jungens,\r\n\r\nwenn es euch noch nicht aufgefallen ist...direkt unterm banner befindet sich nen lustiger link \'Bug Report\', da könnt ihr nu bugs und zeugs eintragen und \"genau\" *hust* spezifizieren :)\r\n\r\nciao\r\n\r\nRune','Bug Report',19,20030303062822);
INSERT INTO mail VALUES (3,0,'So jungens,\r\n\r\nwenn es euch noch nicht aufgefallen ist...direkt unterm banner befindet sich nen lustiger link \'Bug Report\', da könnt ihr nu bugs und zeugs eintragen und \"genau\" *hust* spezifizieren :)\r\n\r\nciao\r\n\r\nRune','Bug Report',20,20030303062822);
INSERT INTO mail VALUES (2,9,'Muß ich bei nem ColCU\r\nauch auf Mission Colonize machen oder baut die automatisch das gas ab wenn ich in der Umlaufbahn bin?','ColCU',52,20030314101030);
INSERT INTO mail VALUES (2,9,'Jupp macht das...\r\n\r\nich muß mal gucken...\r\nwas ich ihm schenken kann\r\n','RE',51,20030312142048);
INSERT INTO mail VALUES (2,9,'bei Runelord und goelord\r\nist beim voting ne 1\r\nwas haben die da gemacht\r\n\r\n???','Voting',42,20030310145338);
INSERT INTO mail VALUES (9,0,'$1$am3hCJef$5Tb10Q6YG1F9jn1mzGmaj1','Password for your jumpgate in system 110',80,20030402160002);
INSERT INTO mail VALUES (4,7,'sag mal, wie kann ich denn handeln?','handel',81,20030403074931);
INSERT INTO mail VALUES (4,7,'Für irgendwelche ideen bezüglich des Kampfes ist somit jetzt der beste Zeitpunkt :)\r\n\r\nBEhaviors für flotten vergeben: 3-4 stufen (erkundschaftung = sofortige flucht vor dem Feind; Patrolie = bei gutem Kräftegleichgewicht dem Kampf stellen, aber nur ein zwei runden lang; Wachdienst = dem Kampf stellen und bei auch bei nicht guter Aussicht mindestens eine Runde kämpfen. wenn eine niederlage definitiv absehbar ist flucht; Angriff = kämpfen bis zum letzten mann, evtl. kommen 2% der Schiffe zurück...)\r\nSo kann man \"jahrelange\" kämpfe vermeiden und flotten einen \"sinn\" geben. Kransportflotten z.B. können sich schnell zurückziehen während Kampfflotten den Feind aufhalten.\r\nÜbrigens heißt erkunfschaftung dann nicht, dass diese flotte nicht doch kämpfen muss, sie versucht halt möglichst schnell zu entkommen und dass evtl. auf anhieb (z.b. wenn es ein schnelles kleines schiff ist)\r\nDer Outer-Space sollte nicht per definition EIN Kampfplatz sein, sondern seine größe wiederspiegeln. Man sollte also durchaus durchbrechen können, ohne kämfen zu müssen, wenn z.B. nur sehr wenige Schiffe im outer-space stationiert sind.\r\n\r\ndas wars erstmal','RE: kampf',47,20030311203108);
INSERT INTO mail VALUES (8,1,'gfh','you teh leader',43,20030311081034);
INSERT INTO mail VALUES (2,9,'man kann zur Zeit die Jumpgates von\r\nFreunden doch nicht benutzen.','schade...',89,20030406215912);
INSERT INTO mail VALUES (9,2,'komm mal schnell bei icq online. hab dich so lange nich mehr gesehen :)','hi',90,20030407213424);
INSERT INTO mail VALUES (4,7,'ich bin mir sicher, dass OFT ein Schifftyp NICHT angezeigt wird (Array-index-fehler?)\r\n\r\n>---------------\r\nsicher das der nicht angezeigt wird? kann sein das es ne weile gedauert hatte bis er geladen wurde, aber mein mir wird er ohne probs angezeigt.\r\n:S','RE: n-bomber',92,20030408225159);
INSERT INTO mail VALUES (3,1,'The alliance leader is too lame to setup his invitation mailform but inivited you to his alliance:). Got to Communications and the to the alliance menu to see your new options','You have been invited to an alliance!',40,20030309192218);
INSERT INTO mail VALUES (8,0,'Welcome to Spaceregents, the ultimate Space Strategy!\n\nThis is a short quickstart and should give you the\nfirst hints on how to play SpaceRegents.\n  \nOn the left you\'ll find your buddy list and the\nNavgationpanel.\n\nNavigationbuttons (in top-down order):\n\nOverview (the page you saw when logging in)\nCommunication (Communiction, Alliance menus.)\nRanking\nPlanets and Production (Planets, Build menu)\nFleet (Fleetmanagement)\nMap (The SpaceRegents starmap)\nResearch\nCovertops (Espionage and sabotage your enemies)\nTrade (Trading of ressources and ships)\n\nFurthermore you\'ll see the Preferences and Logout\nbuttons in the lower left corner.\n  \nFirst you should start your research and build\nsomething on a planet (Metal mine is recommended).\nThe time is estimated in weeks. 1 week in\nSpaceRegents is equal to 1 hour in reality.\nAfter that you should have a look at the Map (make\nsure you have a supported SVG Viewer on your\nsystem) to get an idea where you are located and\nwho is in your neighbourhood. If you want you can\nexamine the alliances which exist in Spaceregents\nso far. As a neutral player you can\'t be attacked\nbut you have several limitations in the game. If\nyou join an alliance you don\'t have these\nlimitations but you can be attacked. So you are\nsafe for now but should consider to join/create an\nalliance soon. It may be a good idea to contact\nyour direct neighbours as well.\n\nThis should have given you a first glance at\nSpaceRegents. More about the features of\nSpaceregents is explained in the manual. If you\nneed help feel free to join the forum and post\nyour questions there.\n\nGood luck and have fun!\n\nThe Spaceregents Team.','Quickstart',12,20030302145431);
INSERT INTO mail VALUES (8,1,'The alliance leader is too lame to setup his invitation mailform but inivited you to his alliance:). Got to Communications and the to the alliance menu to see your new options','You have been invited to an alliance!',13,20030302194439);
INSERT INTO mail VALUES (5,0,'So jungens,\r\n\r\nwenn es euch noch nicht aufgefallen ist...direkt unterm banner befindet sich nen lustiger link \'Bug Report\', da könnt ihr nu bugs und zeugs eintragen und \"genau\" *hust* spezifizieren :)\r\n\r\nciao\r\n\r\nRune','Bug Report',22,20030303062822);
INSERT INTO mail VALUES (2,9,'Kannste mal auch für mich die Taxes\r\neinstellen.\r\n\r\ndanke','Taxes',31,20030305143507);
INSERT INTO mail VALUES (3,4,'The alliance leader is too lame to setup his invitation mailform but inivited you to his alliance:). Got to Communications and the to the alliance menu to see your new options','You have been invited to an alliance!',41,20030309192604);
INSERT INTO mail VALUES (8,0,'So jungens,\r\n\r\nwenn es euch noch nicht aufgefallen ist...direkt unterm banner befindet sich nen lustiger link \'Bug Report\', da könnt ihr nu bugs und zeugs eintragen und \"genau\" *hust* spezifizieren :)\r\n\r\nciao\r\n\r\nRune','Bug Report',25,20030303062822);
INSERT INTO mail VALUES (2,9,'schade eigentlich,\r\n\r\naber das kann ja noch mit eingebaut werden','RE',26,20030304142317);
INSERT INTO mail VALUES (2,9,'brauch man um Gortium abzubauen auch nen Gebäude ???','Gortium',48,20030312102843);
INSERT INTO mail VALUES (2,0,'$1$e5MxS.i2$eDxZZXZ6WIw0zDfGNsjMi1','Password for your jumpgate in system 100',72,20030330100001);
INSERT INTO mail VALUES (2,9,'Was bedeutet denn das Autobahnzeichen...?\r\n( In der Map )','Hi',73,20030330163837);
INSERT INTO mail VALUES (4,0,'$1$L2XLS3Jk$Zlc33dffhGJxvrLycap63.','Password for your jumpgate in system 55',84,20030404140001);
INSERT INTO mail VALUES (2,0,'$1$Ez9Q1xP6$fnrUdvzpTi7U512SfxjUJ/','Password for your jumpgate in system 18',85,20030405070001);
INSERT INTO mail VALUES (2,9,'sag mal wie benutzt man die jg\r\nwenn ich versuche die anzuwählen, gibs ne\r\nFehlermeldung.','jumpgate...',86,20030405075857);
INSERT INTO mail VALUES (2,9,'also mit schicken ist da nicht viel...\r\ndenn die Sache dürfte insgesamt nen\r\nbißchen groß sein.\r\n\r\nPS: jupp bin ja schon dabei nen jumpgate zu bauen\r\n    und wie is dein Passwort...?\r\n\r\naso ok.\r\nkannste mir die dann mal schicken?\r\n\r\nklar kannst du nen jumpgate von mir benutzen, brauchst nur das pw :)\r\nkannst doch selbst eins bei dir bauen, dann könnten wir das zusammen nutzen :)\r\n\r\nciao bis später.\r\n','RE: Hi',77,20030331092645);
INSERT INTO mail VALUES (2,9,'Hmmm...,\r\n\r\nalso die Sachen die man für den Host braucht\r\nkann ich dir gern geben...was das Erklären betrifft weiß ich nicht ob ich das noch richtig zusammenkriege. Aber Helge würde das bestimmt machen.\r\n\r\nAuf ne neue Runde VGA-Pl., hab ich persönlich nicht\r\nmehr so nen Bock.\r\n\r\nPS: Können Allianzmitglieder die Jumpgates anderer mitnutzen ? \r\n\r\nhöhö\r\n\r\ndas bedeutet, daß ich da nen jumpgate (jetzt hab ich schon zwei) hab :)\r\n\r\nbtw, ich hab 2 kumpels überredet bekommen, bei nem vgap game mitzumachen. wennde willst, kannste natürlich auch. ich bräuchte mal die ganzen host-tools und ne kleine anleitung :)','RE: Hi',75,20030330214831);
INSERT INTO mail VALUES (2,0,'\nFleet Fox Eye 10th Grp: arrived at planet nu Mensae III\nRichol: 1 Beholder(s) produced.\nFalkenhorst -R: Agriculture Command Center constructed.\nOutpost: 37 Stonewall Tank(s) produced.\nRichol: 7 N-2103 Bomber(s) produced.\nFalkenhorst II-M: Agriculture Command Center constructed.\nYou have colonised a new planet\nDieron: 1 Orbital Colony Center Unit(s) produced.\nShanghai: Metal Mine constructed.\nRichol: 12 N-2103 Bomber(s) produced.\nFleet Unnamed fleet: arrived at planet alpha Rigel Centauri I\nRichol: 3 Beholder(s) produced.\nFleet Wolfpack 1st Bat: arrived at planet Richol II\nShanghai II-M: Metal Mine constructed.\nYou have colonised a new planet\nShanghai II-M: Barracks constructed.\nMilepost: 4 Space Marines(s) produced.\nShanghai: Barracks constructed.\nYou have colonised a new planet','News of Draconis Combine',87,20030406010007);
INSERT INTO mail VALUES (4,7,'bei den mengen die du haben dprftest kein prob glaub ich, keine Ahnung wieviele abgezogen werden\r\n>---------\r\n\r\nda wollte ich auch noch anmerken: bei den Kolonisten wäre es am besten, wenn die pro planet vergeben und gespeichert werden. sonst kommt es vor, dass ich an einem planeten mehr Colonyschiffe baue, als dort überhaupt Einwohner wohnen...\r\nUnd die Funktion, die berechnet, wieviele Einwohner pro Zug zu Kolonisten werden (werden, also auch von der Einwohnerzahl wieder abgezogen werden) sollte erst ab einem Mindestwert (ein Millionen z.B.) greifen, erst ganz langsam steigen (quadratisch) irgendwann eine maximale steigung erreicht hat und dann nur noch wenig steigt... Am genialsten wäre natürlich, wenn es Auswanderer gibt: Einwohner, die den Planeten wechseln, wenn er zu voll wird...','RE: was heist das?',79,20030401002046);
INSERT INTO mail VALUES (7,0,'\nYour spies have successfully hacked a news network. Check Mails.\nphi Gruis V: Ground batteries constructed.\nThe Erkunum Pumping Station on planet Outer World was destroyed misteriously!\nR0KKY H0RR0R: Planetary Shield Generator constructed.\nOldie 3: Gen Factory constructed.\nYou have colonised a new planet\nOldie III 1: Neural Secrurity Network constructed.\nOldie V I: Neural Secrurity Network constructed.\nHomie: Neural Secrurity Network constructed.\nOldie 3: Laser Weapons Factory II constructed.\nR0KKY H0RR0R: Barracks constructed.\nOldie IV 1: Neural Secrurity Network constructed.\nOldie II 1: Neural Secrurity Network constructed.\nHambry: Jumpgate in orbit constructed.\nMars II: Neural Secrurity Network constructed.\nR0KKY H0RR0R: Laser Weapons Factory II constructed.\nIce Planet V2: Agriculture Command Center constructed.\nYour research has been finished!\nOldie 3: Agriculture Command Center constructed.\nFleet Unnamed fleet: arrived at planet phi Gruis V\nIce Planet V2: Neural Secrurity Network constructed.\nNew3: Ground batteries constructed.\nOldie 3: Missle Base constructed.\nOldie IV 1: Gen Factory constructed.\nOldie 2: Laser Weapons Factory II constructed.\nDune: Gen Factory constructed.\nLuciopodia: Gortium Mine constructed.\nYour spies intercepted some enemy spies!\nOldie: Gen Factory constructed.\nphi Gruis V: Metal Mine constructed.\nIce Planet V2: Laser Weapons Factory II constructed.\nNew1: Neural Secrurity Network constructed.\nYou have recieved a message from Lord_Magnus\nHomie II: Neural Secrurity Network constructed.\nHomie II: Mining Complex constructed.\nMars II: Mining Complex constructed.\nNew2: Mining Complex constructed.\nOldie: Planetary Shield Generator constructed.\nNew1: Mining Complex constructed.\nIce Planet V2: Gen Factory constructed.\nFleet Duempeldingsda: arrived at system\nSR hat nu nen neues Portal :) könnt ja mal vorbeigucken\nNew3: Mining Complex constructed.','News of DARKENCY',88,20030406080006);

--
-- Table structure for table 'mailforms'
--

DROP TABLE IF EXISTS mailforms;
CREATE TABLE mailforms (
  content blob,
  aid int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  typ char(1) NOT NULL default '',
  PRIMARY KEY  (id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'mailforms'
--



--
-- Table structure for table 'map_sizes'
--

DROP TABLE IF EXISTS map_sizes;
CREATE TABLE map_sizes (
  id int(11) NOT NULL auto_increment,
  width int(4) NOT NULL default '800',
  height int(4) NOT NULL default '600',
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'map_sizes'
--


INSERT INTO map_sizes VALUES (1,800,600);
INSERT INTO map_sizes VALUES (2,1024,768);
INSERT INTO map_sizes VALUES (3,1152,864);
INSERT INTO map_sizes VALUES (4,1280,1024);

--
-- Table structure for table 'nachnamen'
--

DROP TABLE IF EXISTS nachnamen;
CREATE TABLE nachnamen (
  name varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

--
-- Dumping data for table 'nachnamen'
--


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

--
-- Table structure for table 'o_production'
--

DROP TABLE IF EXISTS o_production;
CREATE TABLE o_production (
  prod_id int(11) default NULL,
  planet_id int(11) NOT NULL default '0',
  time tinyint(3) default NULL,
  pos int(11) NOT NULL default '1'
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'o_production'
--


INSERT INTO o_production VALUES (10,300,10,1);
INSERT INTO o_production VALUES (61,491,31,1);
INSERT INTO o_production VALUES (61,159,86,1);
INSERT INTO o_production VALUES (17,46,6,1);
INSERT INTO o_production VALUES (61,163,59,1);

--
-- Table structure for table 'online'
--

DROP TABLE IF EXISTS online;
CREATE TABLE online (
  uid int(11) NOT NULL default '0',
  last_chg timestamp(14) NOT NULL,
  PRIMARY KEY  (uid)
) TYPE=MyISAM;

--
-- Dumping data for table 'online'
--


INSERT INTO online VALUES (4,20030409103856);

--
-- Table structure for table 'options'
--

DROP TABLE IF EXISTS options;
CREATE TABLE options (
  uid int(11) NOT NULL default '0',
  map_size int(11) NOT NULL default '1',
  map_constellation_cache tinyint(2) default '9',
  map_system_cache tinyint(2) default '10'
) TYPE=MyISAM;

--
-- Dumping data for table 'options'
--


INSERT INTO options VALUES (1,2,9,10);
INSERT INTO options VALUES (2,2,9,10);
INSERT INTO options VALUES (3,4,9,10);
INSERT INTO options VALUES (4,2,9,10);
INSERT INTO options VALUES (5,1,9,10);
INSERT INTO options VALUES (6,1,9,10);
INSERT INTO options VALUES (7,4,9,10);
INSERT INTO options VALUES (8,1,9,10);
INSERT INTO options VALUES (9,3,9,10);

--
-- Table structure for table 'orbital'
--

DROP TABLE IF EXISTS orbital;
CREATE TABLE orbital (
  pid int(11) NOT NULL default '0',
  prod_id int(11) default NULL,
  KEY pid (pid)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'orbital'
--


INSERT INTO orbital VALUES (79,66);
INSERT INTO orbital VALUES (439,17);
INSERT INTO orbital VALUES (220,66);
INSERT INTO orbital VALUES (89,10);
INSERT INTO orbital VALUES (30,8);
INSERT INTO orbital VALUES (1090,8);
INSERT INTO orbital VALUES (2633,10);
INSERT INTO orbital VALUES (2633,17);
INSERT INTO orbital VALUES (205,17);
INSERT INTO orbital VALUES (109,17);
INSERT INTO orbital VALUES (30,17);
INSERT INTO orbital VALUES (439,10);
INSERT INTO orbital VALUES (205,10);
INSERT INTO orbital VALUES (109,8);
INSERT INTO orbital VALUES (30,10);
INSERT INTO orbital VALUES (109,10);
INSERT INTO orbital VALUES (205,8);
INSERT INTO orbital VALUES (364,10);
INSERT INTO orbital VALUES (190,66);
INSERT INTO orbital VALUES (79,31);
INSERT INTO orbital VALUES (260,10);
INSERT INTO orbital VALUES (415,10);
INSERT INTO orbital VALUES (182,10);
INSERT INTO orbital VALUES (352,10);
INSERT INTO orbital VALUES (83,10);
INSERT INTO orbital VALUES (344,66);
INSERT INTO orbital VALUES (260,17);
INSERT INTO orbital VALUES (230,66);
INSERT INTO orbital VALUES (431,66);
INSERT INTO orbital VALUES (89,17);
INSERT INTO orbital VALUES (97,10);
INSERT INTO orbital VALUES (220,31);
INSERT INTO orbital VALUES (230,31);
INSERT INTO orbital VALUES (110,66);
INSERT INTO orbital VALUES (102,10);
INSERT INTO orbital VALUES (110,31);
INSERT INTO orbital VALUES (472,66);
INSERT INTO orbital VALUES (439,8);
INSERT INTO orbital VALUES (222,66);
INSERT INTO orbital VALUES (471,66);
INSERT INTO orbital VALUES (254,10);
INSERT INTO orbital VALUES (426,10);
INSERT INTO orbital VALUES (379,66);
INSERT INTO orbital VALUES (254,17);
INSERT INTO orbital VALUES (426,17);
INSERT INTO orbital VALUES (411,66);
INSERT INTO orbital VALUES (352,17);
INSERT INTO orbital VALUES (262,66);
INSERT INTO orbital VALUES (334,8);
INSERT INTO orbital VALUES (450,10);
INSERT INTO orbital VALUES (190,31);
INSERT INTO orbital VALUES (410,66);
INSERT INTO orbital VALUES (334,10);
INSERT INTO orbital VALUES (415,8);
INSERT INTO orbital VALUES (391,66);
INSERT INTO orbital VALUES (450,17);
INSERT INTO orbital VALUES (415,17);
INSERT INTO orbital VALUES (440,10);
INSERT INTO orbital VALUES (441,10);
INSERT INTO orbital VALUES (446,10);
INSERT INTO orbital VALUES (416,10);
INSERT INTO orbital VALUES (486,66);
INSERT INTO orbital VALUES (431,31);
INSERT INTO orbital VALUES (410,31);
INSERT INTO orbital VALUES (379,31);
INSERT INTO orbital VALUES (411,31);
INSERT INTO orbital VALUES (446,17);
INSERT INTO orbital VALUES (109,61);
INSERT INTO orbital VALUES (334,17);
INSERT INTO orbital VALUES (97,17);
INSERT INTO orbital VALUES (262,31);
INSERT INTO orbital VALUES (464,10);
INSERT INTO orbital VALUES (486,31);
INSERT INTO orbital VALUES (406,10);
INSERT INTO orbital VALUES (376,10);
INSERT INTO orbital VALUES (494,10);
INSERT INTO orbital VALUES (482,10);
INSERT INTO orbital VALUES (16,10);
INSERT INTO orbital VALUES (337,10);
INSERT INTO orbital VALUES (464,17);
INSERT INTO orbital VALUES (182,17);
INSERT INTO orbital VALUES (376,17);
INSERT INTO orbital VALUES (472,31);
INSERT INTO orbital VALUES (471,31);
INSERT INTO orbital VALUES (494,17);
INSERT INTO orbital VALUES (481,10);
INSERT INTO orbital VALUES (482,17);
INSERT INTO orbital VALUES (473,10);
INSERT INTO orbital VALUES (481,17);
INSERT INTO orbital VALUES (473,17);
INSERT INTO orbital VALUES (260,61);
INSERT INTO orbital VALUES (491,10);
INSERT INTO orbital VALUES (491,17);
INSERT INTO orbital VALUES (242,10);
INSERT INTO orbital VALUES (16,17);
INSERT INTO orbital VALUES (337,17);
INSERT INTO orbital VALUES (332,10);
INSERT INTO orbital VALUES (406,61);
INSERT INTO orbital VALUES (406,17);
INSERT INTO orbital VALUES (74,10);
INSERT INTO orbital VALUES (68,10);
INSERT INTO orbital VALUES (380,10);
INSERT INTO orbital VALUES (102,17);
INSERT INTO orbital VALUES (83,17);
INSERT INTO orbital VALUES (111,66);
INSERT INTO orbital VALUES (351,66);
INSERT INTO orbital VALUES (347,66);
INSERT INTO orbital VALUES (413,66);
INSERT INTO orbital VALUES (250,66);
INSERT INTO orbital VALUES (273,66);
INSERT INTO orbital VALUES (111,31);
INSERT INTO orbital VALUES (428,10);
INSERT INTO orbital VALUES (74,17);
INSERT INTO orbital VALUES (68,17);
INSERT INTO orbital VALUES (428,17);
INSERT INTO orbital VALUES (242,17);
INSERT INTO orbital VALUES (278,10);
INSERT INTO orbital VALUES (439,61);
INSERT INTO orbital VALUES (108,10);
INSERT INTO orbital VALUES (368,66);
INSERT INTO orbital VALUES (374,66);
INSERT INTO orbital VALUES (370,66);
INSERT INTO orbital VALUES (112,10);
INSERT INTO orbital VALUES (408,10);
INSERT INTO orbital VALUES (465,10);
INSERT INTO orbital VALUES (259,66);
INSERT INTO orbital VALUES (408,17);
INSERT INTO orbital VALUES (205,61);
INSERT INTO orbital VALUES (278,17);
INSERT INTO orbital VALUES (211,10);
INSERT INTO orbital VALUES (83,61);
INSERT INTO orbital VALUES (371,66);
INSERT INTO orbital VALUES (163,10);
INSERT INTO orbital VALUES (100,10);
INSERT INTO orbital VALUES (317,10);
INSERT INTO orbital VALUES (81,66);
INSERT INTO orbital VALUES (159,10);
INSERT INTO orbital VALUES (163,17);
INSERT INTO orbital VALUES (317,17);
INSERT INTO orbital VALUES (315,10);
INSERT INTO orbital VALUES (81,31);
INSERT INTO orbital VALUES (315,17);
INSERT INTO orbital VALUES (311,10);
INSERT INTO orbital VALUES (18,10);
INSERT INTO orbital VALUES (173,10);
INSERT INTO orbital VALUES (159,17);
INSERT INTO orbital VALUES (311,17);
INSERT INTO orbital VALUES (46,10);

--
-- Table structure for table 'p_production'
--

DROP TABLE IF EXISTS p_production;
CREATE TABLE p_production (
  prod_id int(11) default NULL,
  planet_id int(11) NOT NULL default '0',
  time tinyint(3) default NULL,
  pos int(11) NOT NULL default '1',
  UNIQUE KEY planet_id (planet_id,pos)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'p_production'
--


INSERT INTO p_production VALUES (19,107,12,3);
INSERT INTO p_production VALUES (5,107,5,1);
INSERT INTO p_production VALUES (1,73,2,6);
INSERT INTO p_production VALUES (1,72,2,6);
INSERT INTO p_production VALUES (60,32,4,4);
INSERT INTO p_production VALUES (56,72,6,5);
INSERT INTO p_production VALUES (19,46,5,1);
INSERT INTO p_production VALUES (56,73,6,5);
INSERT INTO p_production VALUES (63,20,24,1);
INSERT INTO p_production VALUES (60,72,4,4);
INSERT INTO p_production VALUES (22,73,5,7);
INSERT INTO p_production VALUES (13,133,6,7);
INSERT INTO p_production VALUES (19,86,8,1);
INSERT INTO p_production VALUES (5,73,5,4);
INSERT INTO p_production VALUES (5,315,5,1);
INSERT INTO p_production VALUES (63,173,18,1);
INSERT INTO p_production VALUES (60,107,4,6);
INSERT INTO p_production VALUES (19,133,9,1);
INSERT INTO p_production VALUES (19,73,3,1);
INSERT INTO p_production VALUES (22,107,5,4);
INSERT INTO p_production VALUES (25,100,12,1);
INSERT INTO p_production VALUES (23,120,2,1);
INSERT INTO p_production VALUES (56,107,6,5);
INSERT INTO p_production VALUES (1,173,2,5);
INSERT INTO p_production VALUES (63,300,12,1);
INSERT INTO p_production VALUES (19,32,3,1);
INSERT INTO p_production VALUES (56,32,6,3);
INSERT INTO p_production VALUES (19,72,4,1);
INSERT INTO p_production VALUES (23,173,24,4);
INSERT INTO p_production VALUES (56,133,6,6);
INSERT INTO p_production VALUES (33,32,22,5);
INSERT INTO p_production VALUES (60,133,4,5);
INSERT INTO p_production VALUES (32,103,20,1);
INSERT INTO p_production VALUES (32,96,3,1);
INSERT INTO p_production VALUES (63,13,2,1);
INSERT INTO p_production VALUES (19,85,2,1);
INSERT INTO p_production VALUES (22,32,5,6);
INSERT INTO p_production VALUES (19,312,5,1);
INSERT INTO p_production VALUES (40,315,8,3);
INSERT INTO p_production VALUES (5,96,5,2);
INSERT INTO p_production VALUES (15,96,15,3);
INSERT INTO p_production VALUES (15,97,1,1);
INSERT INTO p_production VALUES (19,311,9,1);
INSERT INTO p_production VALUES (46,103,15,4);
INSERT INTO p_production VALUES (19,105,4,1);
INSERT INTO p_production VALUES (56,105,6,4);
INSERT INTO p_production VALUES (60,105,4,5);
INSERT INTO p_production VALUES (22,105,5,6);
INSERT INTO p_production VALUES (1,105,2,7);
INSERT INTO p_production VALUES (46,112,1,1);
INSERT INTO p_production VALUES (23,159,10,1);
INSERT INTO p_production VALUES (1,159,2,2);
INSERT INTO p_production VALUES (63,469,17,1);
INSERT INTO p_production VALUES (63,475,16,1);
INSERT INTO p_production VALUES (46,475,15,4);
INSERT INTO p_production VALUES (1,475,2,5);
INSERT INTO p_production VALUES (26,300,24,2);
INSERT INTO p_production VALUES (56,86,6,4);
INSERT INTO p_production VALUES (60,86,4,5);
INSERT INTO p_production VALUES (22,86,5,6);
INSERT INTO p_production VALUES (1,86,2,7);
INSERT INTO p_production VALUES (21,18,2,1);
INSERT INTO p_production VALUES (56,87,6,1);
INSERT INTO p_production VALUES (22,87,5,4);
INSERT INTO p_production VALUES (5,87,5,5);
INSERT INTO p_production VALUES (60,87,4,6);
INSERT INTO p_production VALUES (1,87,2,7);

--
-- Table structure for table 'planets'
--

DROP TABLE IF EXISTS planets;
CREATE TABLE planets (
  x int(11) default NULL,
  sid int(11) NOT NULL default '0',
  uid int(11) NOT NULL default '0',
  metal int(3) default NULL,
  energy int(3) default NULL,
  mopgas int(3) default NULL,
  erkunum int(3) default NULL,
  gortium int(3) default NULL,
  susebloom int(3) default NULL,
  start tinyint(1) default '0',
  id int(11) NOT NULL auto_increment,
  name varchar(255) NOT NULL default 'Unnamed',
  type char(1) default NULL,
  popgain tinyint(4) default NULL,
  population int(11) default '0',
  pic varchar(50) default 'default.jpg',
  PRIMARY KEY  (id),
  KEY sid (sid),
  KEY uid (uid)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'planets'
--


INSERT INTO planets VALUES (1,1,0,96,0,0,0,0,0,0,1,'Unnamed','R',93,1040,'default.jpg');
INSERT INTO planets VALUES (2,1,0,0,140,0,0,0,0,0,2,'Unnamed','D',82,1039,'default.jpg');
INSERT INTO planets VALUES (3,1,0,45,0,0,0,0,0,0,3,'Unnamed','M',93,1026,'default.jpg');
INSERT INTO planets VALUES (4,1,0,0,147,0,0,0,0,0,4,'Unnamed','D',80,1012,'default.jpg');
INSERT INTO planets VALUES (5,1,0,89,0,0,0,0,0,0,5,'Unnamed','M',57,1017,'default.jpg');
INSERT INTO planets VALUES (6,1,1,0,74,0,0,132,0,0,6,'VIER','A',89,17879473,'default.jpg');
INSERT INTO planets VALUES (7,1,0,42,0,0,0,0,0,0,7,'Unnamed','M',75,1024,'default.jpg');
INSERT INTO planets VALUES (1,2,2,94,0,0,0,0,0,0,8,'New1','M',74,24913,'default.jpg');
INSERT INTO planets VALUES (2,2,0,0,82,0,0,0,0,0,9,'Unnamed','G',0,1003,'default.jpg');
INSERT INTO planets VALUES (3,2,0,0,141,0,0,0,0,0,10,'Unnamed','D',42,1007,'default.jpg');
INSERT INTO planets VALUES (4,2,2,94,0,0,0,0,0,0,11,'New2','R',59,19860,'default.jpg');
INSERT INTO planets VALUES (5,2,0,0,208,0,0,0,0,0,12,'Unnamed','H',0,1016,'default.jpg');
INSERT INTO planets VALUES (6,2,9,40,0,0,0,0,0,0,13,'Magnopolis XXV','M',42,10453,'default.jpg');
INSERT INTO planets VALUES (1,3,0,0,185,0,0,0,0,0,14,'Unnamed','H',0,1003,'default.jpg');
INSERT INTO planets VALUES (2,3,0,0,107,0,0,0,0,0,15,'Unnamed','G',0,1026,'default.jpg');
INSERT INTO planets VALUES (3,3,8,82,0,0,0,0,0,0,16,'Chicken Wing','M',98,482280,'default.jpg');
INSERT INTO planets VALUES (4,3,1,100,100,0,0,0,0,1,17,'VIERZEHN','O',100,3366478,'default.jpg');
INSERT INTO planets VALUES (5,3,7,100,100,0,0,0,0,1,18,'Dubai','O',100,17348,'default.jpg');
INSERT INTO planets VALUES (6,3,0,0,120,0,0,0,0,0,19,'Unnamed','G',0,1020,'default.jpg');
INSERT INTO planets VALUES (7,3,7,57,0,0,0,0,0,0,20,'Dubai II-M','M',94,8607,'default.jpg');
INSERT INTO planets VALUES (1,5,0,0,157,0,0,0,0,0,21,'Unnamed','H',0,1069,'default.jpg');
INSERT INTO planets VALUES (2,5,0,0,171,0,0,0,0,0,22,'Unnamed','H',0,1013,'default.jpg');
INSERT INTO planets VALUES (1,6,0,48,0,0,0,0,0,0,23,'Unnamed','M',93,1054,'default.jpg');
INSERT INTO planets VALUES (1,7,0,99,0,0,0,0,0,0,24,'Unnamed','R',44,1058,'default.jpg');
INSERT INTO planets VALUES (2,7,0,0,71,0,0,0,0,0,25,'Unnamed','G',0,1011,'default.jpg');
INSERT INTO planets VALUES (3,7,0,97,0,0,0,0,0,0,26,'Unnamed','R',47,1007,'default.jpg');
INSERT INTO planets VALUES (4,7,0,0,84,0,0,0,0,0,27,'Unnamed','G',0,1004,'default.jpg');
INSERT INTO planets VALUES (5,7,0,0,0,0,144,0,0,0,28,'Unnamed','I',59,1034,'default.jpg');
INSERT INTO planets VALUES (6,7,0,0,0,118,0,0,0,0,29,'Unnamed','T',0,1016,'default.jpg');
INSERT INTO planets VALUES (1,8,1,100,100,0,0,0,0,1,30,'EINS','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (2,8,0,0,181,0,0,0,0,0,31,'Unnamed','H',0,1061,'default.jpg');
INSERT INTO planets VALUES (3,8,2,0,0,0,159,0,0,0,32,'ice 3','I',81,9204,'default.jpg');
INSERT INTO planets VALUES (4,8,0,0,148,0,0,0,0,0,33,'Unnamed','D',45,1018,'default.jpg');
INSERT INTO planets VALUES (5,8,1,100,100,0,0,0,0,1,34,'ZWO','O',100,34039818,'default.jpg');
INSERT INTO planets VALUES (6,8,0,0,193,0,0,0,0,0,35,'Unnamed','H',0,1028,'default.jpg');
INSERT INTO planets VALUES (7,8,0,46,0,0,0,0,0,0,36,'Unnamed','R',48,1077,'default.jpg');
INSERT INTO planets VALUES (8,8,0,0,0,152,0,0,0,0,37,'Unnamed','T',0,1002,'default.jpg');
INSERT INTO planets VALUES (1,9,0,0,187,0,0,0,0,0,38,'Unnamed','H',0,1007,'default.jpg');
INSERT INTO planets VALUES (2,9,0,0,180,0,0,0,0,0,39,'Unnamed','H',0,1062,'default.jpg');
INSERT INTO planets VALUES (3,9,0,0,113,0,0,0,0,0,40,'Unnamed','D',61,1045,'default.jpg');
INSERT INTO planets VALUES (4,9,0,86,0,0,0,0,0,0,41,'Unnamed','R',94,1066,'default.jpg');
INSERT INTO planets VALUES (1,10,1,0,0,0,133,0,0,0,42,'DREI','I',40,339098,'default.jpg');
INSERT INTO planets VALUES (2,10,0,40,0,0,0,0,0,0,43,'Unnamed','R',70,1048,'default.jpg');
INSERT INTO planets VALUES (3,10,0,0,184,0,0,0,0,0,44,'Unnamed','H',0,1009,'default.jpg');
INSERT INTO planets VALUES (1,11,0,0,82,0,0,0,0,0,45,'Unnamed','G',0,1053,'default.jpg');
INSERT INTO planets VALUES (2,11,7,42,0,0,0,0,0,0,46,'Pune -M','M',86,14082,'default.jpg');
INSERT INTO planets VALUES (3,11,0,0,160,0,0,0,0,0,47,'Unnamed','H',0,1024,'default.jpg');
INSERT INTO planets VALUES (1,12,0,0,78,0,0,0,0,0,48,'Unnamed','G',0,1096,'default.jpg');
INSERT INTO planets VALUES (2,12,0,0,0,0,138,0,0,0,49,'Unnamed','I',84,1071,'default.jpg');
INSERT INTO planets VALUES (3,12,0,0,88,0,0,145,0,0,50,'Unnamed','A',56,1043,'default.jpg');
INSERT INTO planets VALUES (1,13,0,0,159,0,0,0,0,0,51,'Unnamed','H',0,1006,'default.jpg');
INSERT INTO planets VALUES (2,13,0,0,0,0,119,0,0,0,52,'Unnamed','I',66,1005,'default.jpg');
INSERT INTO planets VALUES (3,13,1,113,85,0,0,0,0,0,53,'ACHT','O',105,9064733,'default.jpg');
INSERT INTO planets VALUES (4,13,0,0,119,0,0,0,0,0,54,'Unnamed','D',96,1075,'default.jpg');
INSERT INTO planets VALUES (5,13,1,0,91,0,0,136,0,0,55,'FÜNFZEHN','A',98,2741467,'default.jpg');
INSERT INTO planets VALUES (6,13,1,92,92,0,0,0,0,0,56,'NEUN','O',127,35145490,'default.jpg');
INSERT INTO planets VALUES (7,13,0,0,133,0,0,0,0,0,57,'Unnamed','D',98,1080,'default.jpg');
INSERT INTO planets VALUES (8,13,0,96,0,0,0,0,0,0,58,'Unnamed','M',53,1063,'default.jpg');
INSERT INTO planets VALUES (1,14,0,0,187,0,0,0,0,0,59,'Unnamed','H',0,1063,'default.jpg');
INSERT INTO planets VALUES (2,14,0,0,198,0,0,0,0,0,60,'Unnamed','H',0,1036,'default.jpg');
INSERT INTO planets VALUES (3,14,0,0,0,165,0,0,0,0,61,'Unnamed','T',0,1094,'default.jpg');
INSERT INTO planets VALUES (4,14,0,0,158,0,0,0,0,0,62,'Unnamed','D',80,1046,'default.jpg');
INSERT INTO planets VALUES (5,14,2,96,0,0,0,0,0,0,63,'marsupilami 1','M',69,14917,'default.jpg');
INSERT INTO planets VALUES (6,14,0,0,127,0,0,0,0,0,64,'Unnamed','G',0,1036,'default.jpg');
INSERT INTO planets VALUES (1,15,0,0,177,0,0,0,0,0,65,'Unnamed','H',0,1056,'default.jpg');
INSERT INTO planets VALUES (2,15,2,97,0,0,0,0,0,0,66,'R0KKY H0RR0R','R',66,83579,'default.jpg');
INSERT INTO planets VALUES (3,15,0,0,163,0,0,0,0,0,67,'Unnamed','H',0,1062,'default.jpg');
INSERT INTO planets VALUES (4,15,2,83,0,0,0,0,0,0,68,'Dune','M',55,448324,'default.jpg');
INSERT INTO planets VALUES (1,16,0,0,74,0,0,0,0,0,69,'Unnamed','G',0,1001,'default.jpg');
INSERT INTO planets VALUES (2,16,9,40,0,0,0,0,0,0,70,'Unnamed','M',76,8653,'default.jpg');
INSERT INTO planets VALUES (3,16,0,0,134,0,0,0,0,0,71,'Unnamed','D',91,1064,'default.jpg');
INSERT INTO planets VALUES (4,16,2,49,0,0,0,0,0,0,72,'Felsen','R',40,9452,'default.jpg');
INSERT INTO planets VALUES (5,16,2,48,0,0,0,0,0,0,73,'Ars','M',96,11419,'default.jpg');
INSERT INTO planets VALUES (1,17,2,0,97,0,0,147,0,0,74,'Oldie','A',59,135447,'default.jpg');
INSERT INTO planets VALUES (2,17,0,0,126,0,0,0,0,0,75,'Unnamed','D',55,1028,'default.jpg');
INSERT INTO planets VALUES (3,17,2,0,85,0,0,125,0,0,76,'Oldie 2','A',67,104059,'default.jpg');
INSERT INTO planets VALUES (4,17,2,0,42,0,0,118,0,0,77,'Oldie 3','A',58,70777,'default.jpg');
INSERT INTO planets VALUES (5,17,0,0,161,0,0,0,0,0,78,'Unnamed','D',94,1077,'default.jpg');
INSERT INTO planets VALUES (6,17,2,0,0,133,0,0,0,0,79,'Toxica','T',0,5351,'default.jpg');
INSERT INTO planets VALUES (7,17,0,0,139,0,0,0,0,0,80,'Unnamed','D',81,1028,'default.jpg');
INSERT INTO planets VALUES (1,18,9,0,0,147,0,0,0,0,81,'Magnopolis XXVII','T',0,5024,'default.jpg');
INSERT INTO planets VALUES (2,18,2,0,80,0,0,146,0,0,82,'Oldie IV 1','A',72,106145,'default.jpg');
INSERT INTO planets VALUES (3,18,2,100,100,0,0,0,0,1,83,'Hambry','O',100,6236338,'default.jpg');
INSERT INTO planets VALUES (1,19,0,43,0,0,0,0,0,0,84,'Unnamed','R',91,1009,'default.jpg');
INSERT INTO planets VALUES (2,19,9,56,0,0,0,0,0,0,85,'Magnopolis XXIX','M',85,9506,'default.jpg');
INSERT INTO planets VALUES (3,19,2,0,135,0,0,0,0,0,86,'Power1','D',74,8877,'default.jpg');
INSERT INTO planets VALUES (4,19,2,57,0,0,0,0,0,0,87,'Oars','M',60,8642,'default.jpg');
INSERT INTO planets VALUES (5,19,0,0,201,0,0,0,0,0,88,'Unnamed','H',0,1087,'default.jpg');
INSERT INTO planets VALUES (6,19,2,0,46,0,0,118,0,0,89,'Luciopodia','A',71,4646862,'default.jpg');
INSERT INTO planets VALUES (7,19,0,0,199,0,0,0,0,0,90,'Unnamed','H',0,1038,'default.jpg');
INSERT INTO planets VALUES (1,20,0,0,148,0,0,0,0,0,91,'Unnamed','D',100,1005,'default.jpg');
INSERT INTO planets VALUES (2,20,2,0,0,0,157,0,0,0,92,'Ice Planet V2','I',83,137901,'default.jpg');
INSERT INTO planets VALUES (3,20,0,0,86,0,0,0,0,0,93,'Unnamed','G',0,1003,'default.jpg');
INSERT INTO planets VALUES (1,21,0,0,162,0,0,0,0,0,94,'Unnamed','H',0,1064,'default.jpg');
INSERT INTO planets VALUES (2,21,2,87,0,0,0,0,0,0,95,'Mars II','M',83,31044,'default.jpg');
INSERT INTO planets VALUES (3,21,2,0,73,0,0,135,0,0,96,'Oldie V I','A',96,36217,'default.jpg');
INSERT INTO planets VALUES (1,22,2,0,0,0,139,0,0,0,97,'Outer World','I',43,247074,'default.jpg');
INSERT INTO planets VALUES (2,22,2,0,66,0,0,111,0,0,98,'Oldie II 1','A',62,80015,'default.jpg');
INSERT INTO planets VALUES (3,22,0,0,110,0,0,0,0,0,99,'Unnamed','D',48,1014,'default.jpg');
INSERT INTO planets VALUES (4,22,9,0,0,0,132,0,0,0,100,'Magnopolis XXII','I',63,17805,'default.jpg');
INSERT INTO planets VALUES (5,22,0,43,0,0,0,0,0,0,101,'Unnamed','R',61,1040,'default.jpg');
INSERT INTO planets VALUES (1,23,2,100,100,0,0,0,0,1,102,'Ravenhurst','O',100,1456885,'default.jpg');
INSERT INTO planets VALUES (2,23,2,0,44,0,0,140,0,0,103,'Oldie III 1','A',79,113202,'default.jpg');
INSERT INTO planets VALUES (3,23,0,0,86,0,0,0,0,0,104,'Unnamed','G',0,1014,'default.jpg');
INSERT INTO planets VALUES (1,25,2,77,0,0,0,0,0,0,105,'Arsch','M',89,11289,'default.jpg');
INSERT INTO planets VALUES (2,25,0,0,167,0,0,0,0,0,106,'Unnamed','H',0,1009,'default.jpg');
INSERT INTO planets VALUES (3,25,2,0,166,0,0,0,0,0,107,'Power2','D',75,8590,'default.jpg');
INSERT INTO planets VALUES (4,25,9,0,0,0,128,0,0,0,108,'Magnopolis','I',62,34541,'default.jpg');
INSERT INTO planets VALUES (5,25,2,100,100,0,0,0,0,1,109,'Moongarden','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (1,26,2,0,0,162,0,0,0,0,110,'Waste Lands','T',0,5245,'default.jpg');
INSERT INTO planets VALUES (2,26,2,0,0,161,0,0,0,0,111,'Toxica 2','T',0,5115,'default.jpg');
INSERT INTO planets VALUES (3,26,2,90,106,0,0,0,0,0,112,'Homie','O',105,449023,'default.jpg');
INSERT INTO planets VALUES (1,27,0,0,144,0,0,0,0,0,113,'Unnamed','D',68,1004,'default.jpg');
INSERT INTO planets VALUES (2,27,0,0,180,0,0,0,0,0,114,'Unnamed','H',0,1020,'default.jpg');
INSERT INTO planets VALUES (3,27,1,0,73,0,0,122,0,0,115,'NEUNZEHN','A',86,619078,'default.jpg');
INSERT INTO planets VALUES (4,27,1,102,102,0,0,0,0,0,116,'ELF','O',74,956439,'default.jpg');
INSERT INTO planets VALUES (1,30,9,57,0,0,0,0,0,0,117,'Magnopolis XXIII','M',82,13636,'default.jpg');
INSERT INTO planets VALUES (2,30,0,0,162,0,0,0,0,0,118,'Unnamed','H',0,1016,'default.jpg');
INSERT INTO planets VALUES (3,30,0,0,177,0,0,0,0,0,119,'Unnamed','H',0,1074,'default.jpg');
INSERT INTO planets VALUES (4,30,9,0,42,0,0,111,0,0,120,'Magnopolis XXIV','A',42,10740,'default.jpg');
INSERT INTO planets VALUES (1,31,0,55,0,0,0,0,0,0,121,'Unnamed','R',72,1022,'default.jpg');
INSERT INTO planets VALUES (2,31,5,100,100,0,0,0,0,1,122,'O11','O',100,520080,'default.jpg');
INSERT INTO planets VALUES (1,33,0,97,0,0,0,0,0,0,123,'Unnamed','R',92,1090,'default.jpg');
INSERT INTO planets VALUES (2,33,0,0,0,0,142,0,0,0,124,'Unnamed','I',58,1004,'default.jpg');
INSERT INTO planets VALUES (3,33,0,0,128,0,0,0,0,0,125,'Unnamed','D',92,1031,'default.jpg');
INSERT INTO planets VALUES (4,33,0,65,0,0,0,0,0,0,126,'Unnamed','M',81,1031,'default.jpg');
INSERT INTO planets VALUES (5,33,0,44,0,0,0,0,0,0,127,'Unnamed','R',70,1027,'default.jpg');
INSERT INTO planets VALUES (6,33,0,0,196,0,0,0,0,0,128,'Unnamed','H',0,1008,'default.jpg');
INSERT INTO planets VALUES (7,33,0,0,140,0,0,0,0,0,129,'Unnamed','D',50,1013,'default.jpg');
INSERT INTO planets VALUES (1,35,0,62,0,0,0,0,0,0,130,'Unnamed','M',49,1002,'default.jpg');
INSERT INTO planets VALUES (2,35,0,0,121,0,0,0,0,0,131,'Unnamed','D',60,1039,'default.jpg');
INSERT INTO planets VALUES (3,35,0,60,0,0,0,0,0,0,132,'Unnamed','M',77,1019,'default.jpg');
INSERT INTO planets VALUES (4,35,4,84,116,0,0,0,0,0,133,'G Tucanae O1','O',119,11731,'default.jpg');
INSERT INTO planets VALUES (1,36,0,0,163,0,0,0,0,0,134,'Unnamed','H',0,1060,'default.jpg');
INSERT INTO planets VALUES (2,36,0,0,73,0,0,0,0,0,135,'Unnamed','G',0,1008,'default.jpg');
INSERT INTO planets VALUES (3,36,0,0,141,0,0,0,0,0,136,'Unnamed','D',56,1012,'default.jpg');
INSERT INTO planets VALUES (4,36,0,59,0,0,0,0,0,0,137,'Unnamed','M',64,1087,'default.jpg');
INSERT INTO planets VALUES (5,36,0,0,199,0,0,0,0,0,138,'Unnamed','H',0,1019,'default.jpg');
INSERT INTO planets VALUES (6,36,0,0,0,142,0,0,0,0,139,'Unnamed','T',0,1029,'default.jpg');
INSERT INTO planets VALUES (7,36,0,93,0,0,0,0,0,0,140,'Unnamed','M',45,1041,'default.jpg');
INSERT INTO planets VALUES (8,36,0,0,161,0,0,0,0,0,141,'Unnamed','H',0,1009,'default.jpg');
INSERT INTO planets VALUES (1,37,0,0,176,0,0,0,0,0,142,'Unnamed','H',0,1005,'default.jpg');
INSERT INTO planets VALUES (2,37,0,0,187,0,0,0,0,0,143,'Unnamed','H',0,1064,'default.jpg');
INSERT INTO planets VALUES (3,37,0,80,0,0,0,0,0,0,144,'Unnamed','R',68,1053,'default.jpg');
INSERT INTO planets VALUES (4,37,0,0,136,0,0,0,0,0,145,'Unnamed','D',50,1040,'default.jpg');
INSERT INTO planets VALUES (5,37,0,0,188,0,0,0,0,0,146,'Unnamed','H',0,1006,'default.jpg');
INSERT INTO planets VALUES (6,37,0,0,46,0,0,111,0,0,147,'Unnamed','A',98,1017,'default.jpg');
INSERT INTO planets VALUES (7,37,0,0,74,0,0,0,0,0,148,'Unnamed','G',0,1011,'default.jpg');
INSERT INTO planets VALUES (1,38,1,75,112,0,0,0,0,0,149,'FÜNF','O',105,36943254,'default.jpg');
INSERT INTO planets VALUES (2,38,0,0,183,0,0,0,0,0,150,'Unnamed','H',0,1004,'default.jpg');
INSERT INTO planets VALUES (3,38,0,94,0,0,0,0,0,0,151,'Unnamed','M',97,1045,'default.jpg');
INSERT INTO planets VALUES (1,39,0,53,0,0,0,0,0,0,152,'Unnamed','R',79,1053,'default.jpg');
INSERT INTO planets VALUES (1,40,0,0,0,0,114,0,0,0,153,'Unnamed','I',42,1060,'default.jpg');
INSERT INTO planets VALUES (2,40,0,48,0,0,0,0,0,0,154,'Unnamed','M',47,1065,'default.jpg');
INSERT INTO planets VALUES (3,40,0,0,0,132,0,0,0,0,155,'Unnamed','T',0,1052,'default.jpg');
INSERT INTO planets VALUES (4,40,0,0,0,170,0,0,0,0,156,'Unnamed','T',0,1023,'default.jpg');
INSERT INTO planets VALUES (5,40,0,0,188,0,0,0,0,0,157,'Unnamed','H',0,1013,'default.jpg');
INSERT INTO planets VALUES (1,41,0,0,192,0,0,0,0,0,158,'Unnamed','H',0,1025,'default.jpg');
INSERT INTO planets VALUES (2,41,2,86,109,0,0,0,0,0,159,'Homie II','O',117,48699,'default.jpg');
INSERT INTO planets VALUES (3,41,0,52,0,0,0,0,0,0,160,'Unnamed','M',80,1023,'default.jpg');
INSERT INTO planets VALUES (1,42,0,0,0,0,142,0,0,0,161,'Unnamed','I',99,1039,'default.jpg');
INSERT INTO planets VALUES (2,42,0,0,0,164,0,0,0,0,162,'Unnamed','T',0,1009,'default.jpg');
INSERT INTO planets VALUES (3,42,4,0,145,0,0,0,0,0,163,'Kappa Tucanae D1','D',51,16648,'default.jpg');
INSERT INTO planets VALUES (1,43,0,0,124,0,0,0,0,0,164,'Unnamed','G',0,1036,'default.jpg');
INSERT INTO planets VALUES (2,43,0,100,100,0,0,0,0,1,165,'Unnamed','O',100,10000000,'default.jpg');
INSERT INTO planets VALUES (3,43,0,59,0,0,0,0,0,0,166,'Unnamed','M',74,1079,'default.jpg');
INSERT INTO planets VALUES (1,44,0,0,181,0,0,0,0,0,167,'Unnamed','H',0,1077,'default.jpg');
INSERT INTO planets VALUES (1,45,0,68,0,0,0,0,0,0,168,'Unnamed','M',79,1053,'default.jpg');
INSERT INTO planets VALUES (2,45,0,42,0,0,0,0,0,0,169,'Unnamed','M',64,1014,'default.jpg');
INSERT INTO planets VALUES (3,45,3,100,100,0,0,0,0,1,170,'Core','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (4,45,0,0,162,0,0,0,0,0,171,'Unnamed','D',91,1077,'default.jpg');
INSERT INTO planets VALUES (5,45,0,83,0,0,0,0,0,0,172,'Unnamed','M',95,1014,'default.jpg');
INSERT INTO planets VALUES (1,46,4,109,100,0,0,0,0,0,173,'O-Tucanae O1','O',92,11246,'default.jpg');
INSERT INTO planets VALUES (1,47,0,61,0,0,0,0,0,0,174,'Unnamed','M',73,1007,'default.jpg');
INSERT INTO planets VALUES (2,47,0,82,0,0,0,0,0,0,175,'Unnamed','M',44,1059,'default.jpg');
INSERT INTO planets VALUES (3,47,0,0,200,0,0,0,0,0,176,'Unnamed','H',0,1053,'default.jpg');
INSERT INTO planets VALUES (4,47,0,0,175,0,0,0,0,0,177,'Unnamed','H',0,1052,'default.jpg');
INSERT INTO planets VALUES (1,48,4,88,0,0,0,0,0,0,178,'Omega Al Sag. M1','M',63,21076,'default.jpg');
INSERT INTO planets VALUES (2,48,4,72,0,0,0,0,0,0,179,'Omega Al Sag. M2','M',53,18025,'default.jpg');
INSERT INTO planets VALUES (3,48,0,0,190,0,0,0,0,0,180,'Unnamed','H',0,1030,'default.jpg');
INSERT INTO planets VALUES (4,48,0,0,162,0,0,0,0,0,181,'Unnamed','H',0,1013,'default.jpg');
INSERT INTO planets VALUES (5,48,4,0,81,0,0,146,0,0,182,'Omega Al Sag. A1','A',61,916898,'default.jpg');
INSERT INTO planets VALUES (6,48,0,0,183,0,0,0,0,0,183,'Unnamed','H',0,1012,'default.jpg');
INSERT INTO planets VALUES (1,49,0,0,125,0,0,0,0,0,184,'Unnamed','D',73,1044,'default.jpg');
INSERT INTO planets VALUES (2,49,0,0,103,0,0,0,0,0,185,'Unnamed','G',0,1019,'default.jpg');
INSERT INTO planets VALUES (3,49,4,94,0,0,0,0,0,0,186,'Psi Al Sag. M1','M',45,14774,'default.jpg');
INSERT INTO planets VALUES (4,49,0,0,122,0,0,0,0,0,187,'Unnamed','G',0,1010,'default.jpg');
INSERT INTO planets VALUES (5,49,0,0,121,0,0,0,0,0,188,'Unnamed','D',40,1002,'default.jpg');
INSERT INTO planets VALUES (1,50,4,0,122,0,0,0,0,0,189,'Beta Al Sag. D1','D',87,27640,'default.jpg');
INSERT INTO planets VALUES (2,50,4,0,0,151,0,0,0,0,190,'Beta Al Sag. T1','T',0,5319,'default.jpg');
INSERT INTO planets VALUES (1,51,0,0,149,0,0,0,0,0,191,'Unnamed','D',55,1038,'default.jpg');
INSERT INTO planets VALUES (2,51,1,78,90,0,0,0,0,0,192,'Unnamed','O',91,798003,'default.jpg');
INSERT INTO planets VALUES (3,51,0,0,129,0,0,0,0,0,193,'Unnamed','D',64,1035,'default.jpg');
INSERT INTO planets VALUES (4,51,0,0,72,0,0,0,0,0,194,'Unnamed','G',0,1075,'default.jpg');
INSERT INTO planets VALUES (5,51,1,127,89,0,0,0,0,0,195,'SECHS','O',108,33201132,'default.jpg');
INSERT INTO planets VALUES (6,51,0,0,176,0,0,0,0,0,196,'Unnamed','H',0,1049,'default.jpg');
INSERT INTO planets VALUES (7,51,0,0,0,144,0,0,0,0,197,'Unnamed','T',0,1011,'default.jpg');
INSERT INTO planets VALUES (8,51,0,0,194,0,0,0,0,0,198,'Unnamed','H',0,1059,'default.jpg');
INSERT INTO planets VALUES (1,53,0,0,0,142,0,0,0,0,199,'Unnamed','T',0,1010,'default.jpg');
INSERT INTO planets VALUES (2,53,5,63,0,0,0,0,0,0,200,'M8','M',93,1160316,'default.jpg');
INSERT INTO planets VALUES (1,54,0,0,176,0,0,0,0,0,201,'Unnamed','H',0,1049,'default.jpg');
INSERT INTO planets VALUES (2,54,0,0,0,0,118,0,0,0,202,'Unnamed','I',62,1004,'default.jpg');
INSERT INTO planets VALUES (3,54,0,0,127,0,0,0,0,0,203,'Unnamed','D',44,1025,'default.jpg');
INSERT INTO planets VALUES (4,54,0,0,210,0,0,0,0,0,204,'Unnamed','H',0,1019,'default.jpg');
INSERT INTO planets VALUES (1,55,4,100,100,0,0,0,0,1,205,'Rune Prime','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (2,55,0,0,127,0,0,0,0,0,206,'Unnamed','G',0,1055,'default.jpg');
INSERT INTO planets VALUES (3,55,4,100,100,0,0,0,0,1,207,'Rune New Eden','O',100,77910934,'default.jpg');
INSERT INTO planets VALUES (4,55,5,79,0,0,0,0,0,0,208,'Unnamed','M',49,16012,'default.jpg');
INSERT INTO planets VALUES (5,55,0,0,210,0,0,0,0,0,209,'Unnamed','H',0,1043,'default.jpg');
INSERT INTO planets VALUES (6,55,0,0,204,0,0,0,0,0,210,'Unnamed','H',0,1029,'default.jpg');
INSERT INTO planets VALUES (1,56,4,0,0,0,134,0,0,0,211,'Angry White','I',95,117863,'default.jpg');
INSERT INTO planets VALUES (2,56,0,91,0,0,0,0,0,0,212,'Unnamed','M',81,1001,'default.jpg');
INSERT INTO planets VALUES (3,56,0,0,172,0,0,0,0,0,213,'Unnamed','H',0,1010,'default.jpg');
INSERT INTO planets VALUES (4,56,0,0,95,0,0,0,0,0,214,'Unnamed','G',0,1018,'default.jpg');
INSERT INTO planets VALUES (5,56,0,0,161,0,0,0,0,0,215,'Unnamed','D',50,1005,'default.jpg');
INSERT INTO planets VALUES (6,56,0,0,134,0,0,0,0,0,216,'Unnamed','D',60,1097,'default.jpg');
INSERT INTO planets VALUES (7,56,0,0,157,0,0,0,0,0,217,'Unnamed','H',0,1011,'default.jpg');
INSERT INTO planets VALUES (1,57,0,0,0,0,114,0,0,0,218,'Unnamed','I',51,1059,'default.jpg');
INSERT INTO planets VALUES (2,57,0,0,165,0,0,0,0,0,219,'Unnamed','H',0,1000,'default.jpg');
INSERT INTO planets VALUES (3,57,1,0,0,170,0,0,0,0,220,'ZEHN','T',0,5353,'default.jpg');
INSERT INTO planets VALUES (4,57,0,0,183,0,0,0,0,0,221,'Unnamed','H',0,1040,'default.jpg');
INSERT INTO planets VALUES (5,57,1,0,0,154,0,0,0,0,222,'Unnamed','T',0,5226,'default.jpg');
INSERT INTO planets VALUES (6,57,0,0,122,0,0,0,0,0,223,'Unnamed','D',49,1015,'default.jpg');
INSERT INTO planets VALUES (7,57,0,0,193,0,0,0,0,0,224,'Unnamed','H',0,1009,'default.jpg');
INSERT INTO planets VALUES (1,58,1,0,49,0,0,119,0,0,225,'Unnamed','A',97,859964,'default.jpg');
INSERT INTO planets VALUES (2,58,1,0,62,0,0,137,0,0,226,'Unnamed','A',94,886547,'default.jpg');
INSERT INTO planets VALUES (3,58,0,0,112,0,0,0,0,0,227,'Unnamed','D',55,1018,'default.jpg');
INSERT INTO planets VALUES (4,58,0,0,160,0,0,0,0,0,228,'Unnamed','H',0,1003,'default.jpg');
INSERT INTO planets VALUES (5,58,0,0,194,0,0,0,0,0,229,'Unnamed','H',0,1040,'default.jpg');
INSERT INTO planets VALUES (6,58,1,0,0,156,0,0,0,0,230,'SECHZEHN','T',0,5293,'default.jpg');
INSERT INTO planets VALUES (7,58,0,44,0,0,0,0,0,0,231,'Unnamed','R',41,1060,'default.jpg');
INSERT INTO planets VALUES (1,59,0,0,116,0,0,0,0,0,232,'Unnamed','D',42,1049,'default.jpg');
INSERT INTO planets VALUES (2,59,0,73,0,0,0,0,0,0,233,'Unnamed','M',87,1060,'default.jpg');
INSERT INTO planets VALUES (1,60,0,0,94,0,0,0,0,0,234,'Unnamed','G',0,1036,'default.jpg');
INSERT INTO planets VALUES (2,60,0,0,130,0,0,0,0,0,235,'Unnamed','G',0,1022,'default.jpg');
INSERT INTO planets VALUES (3,60,0,0,178,0,0,0,0,0,236,'Unnamed','H',0,1022,'default.jpg');
INSERT INTO planets VALUES (4,60,0,0,165,0,0,0,0,0,237,'Unnamed','D',66,1031,'default.jpg');
INSERT INTO planets VALUES (5,60,0,0,114,0,0,0,0,0,238,'Unnamed','G',0,1001,'default.jpg');
INSERT INTO planets VALUES (6,60,1,0,44,0,0,140,0,0,239,'Unnamed','A',80,379302,'default.jpg');
INSERT INTO planets VALUES (7,60,0,0,116,0,0,0,0,0,240,'Unnamed','D',44,1020,'default.jpg');
INSERT INTO planets VALUES (1,61,0,0,0,0,116,0,0,0,241,'Unnamed','I',90,1019,'default.jpg');
INSERT INTO planets VALUES (2,61,4,85,71,0,0,0,0,0,242,'Sagittari I','O',100,1269463,'default.jpg');
INSERT INTO planets VALUES (3,61,0,0,172,0,0,0,0,0,243,'Unnamed','H',0,1079,'default.jpg');
INSERT INTO planets VALUES (1,62,5,100,100,0,0,0,0,1,244,'O7','O',100,1723743,'default.jpg');
INSERT INTO planets VALUES (2,62,0,0,163,0,0,0,0,0,245,'Unnamed','H',0,1023,'default.jpg');
INSERT INTO planets VALUES (3,62,0,0,116,0,0,0,0,0,246,'Unnamed','G',0,1026,'default.jpg');
INSERT INTO planets VALUES (4,62,5,0,123,0,0,0,0,0,247,'Unnamed','D',47,15783,'default.jpg');
INSERT INTO planets VALUES (5,62,0,0,185,0,0,0,0,0,248,'Unnamed','H',0,1052,'default.jpg');
INSERT INTO planets VALUES (6,62,0,0,182,0,0,0,0,0,249,'Unnamed','H',0,1055,'default.jpg');
INSERT INTO planets VALUES (1,63,5,0,0,116,0,0,0,0,250,'G12','T',0,5106,'default.jpg');
INSERT INTO planets VALUES (2,63,5,61,0,0,0,0,0,0,251,'M1','M',75,741868,'default.jpg');
INSERT INTO planets VALUES (3,63,5,0,158,0,0,0,0,0,252,'D2','D',41,92894,'default.jpg');
INSERT INTO planets VALUES (4,63,5,0,0,0,111,0,0,0,253,'I13','I',64,31480,'default.jpg');
INSERT INTO planets VALUES (5,63,5,100,100,0,0,0,0,1,254,'Gore','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (6,63,5,0,118,0,0,0,0,0,255,'D3','D',45,119805,'default.jpg');
INSERT INTO planets VALUES (7,63,0,0,155,0,0,0,0,0,256,'Unnamed','H',0,1048,'default.jpg');
INSERT INTO planets VALUES (8,63,5,0,121,0,0,0,0,0,257,'D14','D',70,38627,'default.jpg');
INSERT INTO planets VALUES (1,64,0,0,171,0,0,0,0,0,258,'Unnamed','H',0,1022,'default.jpg');
INSERT INTO planets VALUES (2,64,5,0,0,130,0,0,0,0,259,'Unnamed','T',0,5067,'default.jpg');
INSERT INTO planets VALUES (1,65,4,105,139,0,0,0,110,0,260,'Fine Green','E',127,72942596,'default.jpg');
INSERT INTO planets VALUES (2,65,4,100,100,0,0,0,0,1,261,'Fine Blue','O',100,3855930,'default.jpg');
INSERT INTO planets VALUES (3,65,4,0,0,147,0,0,0,0,262,'Fine Ocean','T',0,5242,'default.jpg');
INSERT INTO planets VALUES (4,65,0,0,0,156,0,0,0,0,263,'Unnamed','T',0,1008,'default.jpg');
INSERT INTO planets VALUES (5,65,0,69,0,0,0,0,0,0,264,'Unnamed','M',77,1031,'default.jpg');
INSERT INTO planets VALUES (6,65,0,0,178,0,0,0,0,0,265,'Unnamed','H',0,1030,'default.jpg');
INSERT INTO planets VALUES (7,65,0,68,0,0,0,0,0,0,266,'Unnamed','M',99,1010,'default.jpg');
INSERT INTO planets VALUES (8,65,4,0,0,0,154,0,0,0,267,'Fine White','I',57,449500,'default.jpg');
INSERT INTO planets VALUES (1,67,0,0,108,0,0,0,0,0,268,'Unnamed','G',0,1025,'default.jpg');
INSERT INTO planets VALUES (2,67,5,67,0,0,0,0,0,0,269,'M9','M',41,78691,'default.jpg');
INSERT INTO planets VALUES (1,68,5,0,67,0,0,148,0,0,270,'A4','A',67,343293,'default.jpg');
INSERT INTO planets VALUES (2,68,0,64,0,0,0,0,0,0,271,'Unnamed','R',91,1088,'default.jpg');
INSERT INTO planets VALUES (3,68,5,0,126,0,0,0,0,0,272,'D15','D',60,27516,'default.jpg');
INSERT INTO planets VALUES (1,69,5,0,0,170,0,0,0,0,273,'G16','T',0,5099,'default.jpg');
INSERT INTO planets VALUES (2,69,0,0,174,0,0,0,0,0,274,'Unnamed','H',0,1068,'default.jpg');
INSERT INTO planets VALUES (3,69,5,98,0,0,0,0,0,0,275,'M5','M',53,182527,'default.jpg');
INSERT INTO planets VALUES (4,69,5,0,166,0,0,0,0,0,276,'D6','D',58,217373,'default.jpg');
INSERT INTO planets VALUES (1,70,0,0,194,0,0,0,0,0,277,'Unnamed','H',0,1044,'default.jpg');
INSERT INTO planets VALUES (2,70,4,0,91,0,0,149,0,0,278,'Dark Red','A',98,226097,'default.jpg');
INSERT INTO planets VALUES (3,70,0,0,188,0,0,0,0,0,279,'Unnamed','H',0,1035,'default.jpg');
INSERT INTO planets VALUES (4,70,0,0,161,0,0,0,0,0,280,'Unnamed','H',0,1021,'default.jpg');
INSERT INTO planets VALUES (5,70,0,0,150,0,0,0,0,0,281,'Unnamed','H',0,1003,'default.jpg');
INSERT INTO planets VALUES (6,70,0,0,178,0,0,0,0,0,282,'Unnamed','H',0,1068,'default.jpg');
INSERT INTO planets VALUES (7,70,0,63,0,0,0,0,0,0,283,'Unnamed','M',87,1008,'default.jpg');
INSERT INTO planets VALUES (8,70,5,87,129,0,0,0,0,0,284,'O10','O',78,320446,'default.jpg');
INSERT INTO planets VALUES (1,71,0,0,135,0,0,0,0,0,285,'Unnamed','D',76,1027,'default.jpg');
INSERT INTO planets VALUES (2,71,0,0,194,0,0,0,0,0,286,'Unnamed','H',0,1069,'default.jpg');
INSERT INTO planets VALUES (3,71,0,0,120,0,0,0,0,0,287,'Unnamed','D',66,1015,'default.jpg');
INSERT INTO planets VALUES (4,71,0,0,132,0,0,0,0,0,288,'Unnamed','D',87,1041,'default.jpg');
INSERT INTO planets VALUES (5,71,0,0,0,136,0,0,0,0,289,'Unnamed','T',0,1073,'default.jpg');
INSERT INTO planets VALUES (1,72,5,0,57,0,0,150,0,0,290,'Unnamed','A',57,16406,'default.jpg');
INSERT INTO planets VALUES (2,72,0,0,128,0,0,0,0,0,291,'Unnamed','D',74,1044,'default.jpg');
INSERT INTO planets VALUES (1,73,0,0,117,0,0,0,0,0,292,'Unnamed','D',69,1014,'default.jpg');
INSERT INTO planets VALUES (2,73,7,85,0,0,0,0,0,0,293,'Falkenhorst -R','R',52,15009,'default.jpg');
INSERT INTO planets VALUES (3,73,6,100,100,0,0,0,0,1,294,'Horst','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (4,73,0,0,136,0,0,0,0,0,295,'Unnamed','D',51,1039,'default.jpg');
INSERT INTO planets VALUES (5,73,7,72,0,0,0,0,0,0,296,'Falkenhorst II-M','M',57,17361,'default.jpg');
INSERT INTO planets VALUES (6,73,0,0,138,0,0,0,0,0,297,'Unnamed','D',75,1003,'default.jpg');
INSERT INTO planets VALUES (1,75,7,67,0,0,0,0,0,0,298,'Ankes Stern','R',75,16834,'default.jpg');
INSERT INTO planets VALUES (2,75,0,0,194,0,0,0,0,0,299,'Unnamed','H',0,1012,'default.jpg');
INSERT INTO planets VALUES (1,76,7,95,0,0,0,0,0,0,300,'Paris -M','M',81,10480,'default.jpg');
INSERT INTO planets VALUES (2,76,0,0,118,0,0,0,0,0,301,'Unnamed','D',96,1032,'default.jpg');
INSERT INTO planets VALUES (1,77,0,62,0,0,0,0,0,0,302,'Unnamed','R',41,1013,'default.jpg');
INSERT INTO planets VALUES (2,77,0,0,152,0,0,0,0,0,303,'Unnamed','H',0,1017,'default.jpg');
INSERT INTO planets VALUES (3,77,0,80,0,0,0,0,0,0,304,'Unnamed','R',73,1055,'default.jpg');
INSERT INTO planets VALUES (4,77,0,40,0,0,0,0,0,0,305,'Unnamed','M',42,1036,'default.jpg');
INSERT INTO planets VALUES (1,78,0,0,185,0,0,0,0,0,306,'Unnamed','H',0,1005,'default.jpg');
INSERT INTO planets VALUES (1,79,0,0,162,0,0,0,0,0,307,'Unnamed','H',0,1040,'default.jpg');
INSERT INTO planets VALUES (2,79,0,0,198,0,0,0,0,0,308,'Unnamed','H',0,1025,'default.jpg');
INSERT INTO planets VALUES (3,79,0,0,151,0,0,0,0,0,309,'Unnamed','H',0,1019,'default.jpg');
INSERT INTO planets VALUES (1,80,0,0,141,0,0,0,0,0,310,'Unnamed','D',74,1018,'default.jpg');
INSERT INTO planets VALUES (2,80,7,45,0,0,0,0,0,0,311,'Berlin -M','M',49,11500,'default.jpg');
INSERT INTO planets VALUES (3,80,7,42,0,0,0,0,0,0,312,'Berlin II-M','M',61,10888,'default.jpg');
INSERT INTO planets VALUES (4,80,0,0,154,0,0,0,0,0,313,'Unnamed','H',0,1001,'default.jpg');
INSERT INTO planets VALUES (1,81,7,80,0,0,0,0,0,0,314,'Shanghai II-M','M',65,14181,'default.jpg');
INSERT INTO planets VALUES (2,81,7,91,95,0,0,0,0,0,315,'Shanghai','O',88,17506,'default.jpg');
INSERT INTO planets VALUES (1,82,0,0,146,0,0,0,0,0,316,'Unnamed','D',79,1013,'default.jpg');
INSERT INTO planets VALUES (2,82,7,105,130,0,0,0,0,0,317,'Milepost','O',83,26463,'default.jpg');
INSERT INTO planets VALUES (3,82,0,0,155,0,0,0,0,0,318,'Unnamed','D',54,1052,'default.jpg');
INSERT INTO planets VALUES (4,82,0,0,71,0,0,0,0,0,319,'Unnamed','G',0,1016,'default.jpg');
INSERT INTO planets VALUES (5,82,0,0,0,0,130,0,0,0,320,'Unnamed','I',92,1005,'default.jpg');
INSERT INTO planets VALUES (1,83,0,0,191,0,0,0,0,0,321,'Unnamed','H',0,1012,'default.jpg');
INSERT INTO planets VALUES (2,83,1,100,100,0,0,0,0,1,322,'Unnamed','O',100,618611,'default.jpg');
INSERT INTO planets VALUES (3,83,7,100,100,0,0,0,0,1,323,'Outpost','O',100,42847,'default.jpg');
INSERT INTO planets VALUES (4,83,0,0,119,0,0,0,0,0,324,'Unnamed','D',91,1058,'default.jpg');
INSERT INTO planets VALUES (5,83,0,0,0,0,128,0,0,0,325,'Unnamed','I',42,1018,'default.jpg');
INSERT INTO planets VALUES (6,83,7,84,0,0,0,0,0,0,326,'Outpost II-M','M',67,15805,'default.jpg');
INSERT INTO planets VALUES (1,84,0,0,112,0,0,0,0,0,327,'Unnamed','D',56,1066,'default.jpg');
INSERT INTO planets VALUES (2,84,0,0,141,0,0,0,0,0,328,'Unnamed','D',82,1043,'default.jpg');
INSERT INTO planets VALUES (3,84,7,0,67,0,0,138,0,0,329,'Old Times -A','A',65,13334,'default.jpg');
INSERT INTO planets VALUES (4,84,0,0,207,0,0,0,0,0,330,'Unnamed','H',0,1022,'default.jpg');
INSERT INTO planets VALUES (5,84,1,91,117,0,0,0,0,0,331,'ZWÖLF','O',117,9737021,'default.jpg');
INSERT INTO planets VALUES (1,85,8,0,82,0,0,150,0,0,332,'Fettbrand','A',49,114693,'default.jpg');
INSERT INTO planets VALUES (2,85,7,44,0,0,0,0,0,0,333,'Marktplatz III-M','R',99,21656,'default.jpg');
INSERT INTO planets VALUES (3,85,7,0,82,0,0,125,0,0,334,'Marktplatz','A',50,78203,'default.jpg');
INSERT INTO planets VALUES (4,85,7,0,121,0,0,0,0,0,335,'Marktplatz II-D','D',73,42588,'default.jpg');
INSERT INTO planets VALUES (5,85,0,0,155,0,0,0,0,0,336,'Unnamed','H',0,1050,'default.jpg');
INSERT INTO planets VALUES (6,85,8,84,108,0,0,0,0,0,337,'Backpapier','O',83,2843821,'default.jpg');
INSERT INTO planets VALUES (7,85,0,0,0,0,158,0,0,0,338,'Unnamed','I',61,1011,'default.jpg');
INSERT INTO planets VALUES (1,86,7,0,0,0,112,0,0,0,339,'Sian V-I','I',70,14656,'default.jpg');
INSERT INTO planets VALUES (2,86,7,46,0,0,0,0,0,0,340,'Sian III-M','M',96,799074,'default.jpg');
INSERT INTO planets VALUES (3,86,7,129,128,0,0,0,0,0,341,'Sian','O',77,2029129,'default.jpg');
INSERT INTO planets VALUES (4,86,7,89,0,0,0,0,0,0,342,'Sian IV-R','R',41,28177,'default.jpg');
INSERT INTO planets VALUES (5,86,7,0,81,0,0,113,0,0,343,'Sian II-A','A',92,1810927,'default.jpg');
INSERT INTO planets VALUES (1,87,8,0,0,166,0,0,0,0,344,'Knackwurst','T',0,8455,'default.jpg');
INSERT INTO planets VALUES (2,87,0,0,123,0,0,0,0,0,345,'Unnamed','G',0,1010,'default.jpg');
INSERT INTO planets VALUES (3,87,0,0,161,0,0,0,0,0,346,'Unnamed','H',0,1035,'default.jpg');
INSERT INTO planets VALUES (1,88,7,0,173,0,0,0,0,0,347,'Luthien V-H','H',0,5112,'default.jpg');
INSERT INTO planets VALUES (2,88,7,0,134,0,0,0,0,0,348,'Luthien III-D','D',55,73612,'default.jpg');
INSERT INTO planets VALUES (3,88,7,0,50,0,0,110,0,0,349,'Luthien II-A','A',97,1164079,'default.jpg');
INSERT INTO planets VALUES (4,88,7,0,131,0,0,0,0,0,350,'Luthien VI-D','D',93,51720,'default.jpg');
INSERT INTO planets VALUES (5,88,7,0,74,0,0,0,0,0,351,'Luthien VII-G','G',0,5112,'default.jpg');
INSERT INTO planets VALUES (6,88,7,100,100,0,0,0,0,1,352,'Luthien','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (7,88,7,65,0,0,0,0,0,0,353,'Luthien IV-M','M',53,61371,'default.jpg');
INSERT INTO planets VALUES (1,89,0,0,193,0,0,0,0,0,354,'Unnamed','H',0,1009,'default.jpg');
INSERT INTO planets VALUES (2,89,7,0,120,0,0,0,0,0,355,'New Avalon','D',76,13345,'default.jpg');
INSERT INTO planets VALUES (1,90,7,0,0,0,113,0,0,0,356,'Xeropal-I','I',90,1376002,'default.jpg');
INSERT INTO planets VALUES (2,90,0,0,178,0,0,0,0,0,357,'Unnamed','H',0,1022,'default.jpg');
INSERT INTO planets VALUES (1,91,0,0,0,164,0,0,0,0,358,'Unnamed','T',0,1037,'default.jpg');
INSERT INTO planets VALUES (2,91,0,0,47,0,0,130,0,0,359,'Unnamed','A',66,1083,'default.jpg');
INSERT INTO planets VALUES (3,91,0,0,133,0,0,0,0,0,360,'Unnamed','D',63,1015,'default.jpg');
INSERT INTO planets VALUES (4,91,1,0,75,0,0,131,0,0,361,'Unnamed','A',52,79052,'default.jpg');
INSERT INTO planets VALUES (1,92,0,0,124,0,0,0,0,0,362,'Unnamed','G',0,1023,'default.jpg');
INSERT INTO planets VALUES (2,92,0,0,83,0,0,0,0,0,363,'Unnamed','G',0,1040,'default.jpg');
INSERT INTO planets VALUES (3,92,1,122,141,0,0,0,122,0,364,'SIEBEN','E',127,67687701,'default.jpg');
INSERT INTO planets VALUES (4,92,0,0,0,148,0,0,0,0,365,'Unnamed','T',0,1023,'default.jpg');
INSERT INTO planets VALUES (5,92,1,0,42,0,0,125,0,0,366,'DREIZEHN','A',81,1221705,'default.jpg');
INSERT INTO planets VALUES (6,92,0,0,0,0,111,0,0,0,367,'Unnamed','I',73,1027,'default.jpg');
INSERT INTO planets VALUES (1,93,7,0,161,0,0,0,0,0,368,'Atreus V-H','H',0,5083,'default.jpg');
INSERT INTO planets VALUES (2,93,7,105,112,0,0,0,0,0,369,'Atreus','O',92,3589150,'default.jpg');
INSERT INTO planets VALUES (3,93,7,0,151,0,0,0,0,0,370,'Atreus VI-H','H',0,5088,'default.jpg');
INSERT INTO planets VALUES (4,93,7,0,77,0,0,0,0,0,371,'Atreus VIII-G','G',0,5038,'default.jpg');
INSERT INTO planets VALUES (5,93,7,0,159,0,0,0,0,0,372,'Atreus II-D','D',75,66837,'default.jpg');
INSERT INTO planets VALUES (6,93,7,62,0,0,0,0,0,0,373,'Atreus III-M','M',99,128374,'default.jpg');
INSERT INTO planets VALUES (7,93,7,0,95,0,0,0,0,0,374,'Atreus VII-G','G',0,5065,'default.jpg');
INSERT INTO planets VALUES (8,93,7,0,40,0,0,116,0,0,375,'Atreus IV-A','A',65,44614,'default.jpg');
INSERT INTO planets VALUES (1,94,7,100,100,0,0,0,0,1,376,'Dieron','O',100,8586631,'default.jpg');
INSERT INTO planets VALUES (1,95,7,0,146,0,0,0,0,0,377,'Pesht VI-D','D',67,30959,'default.jpg');
INSERT INTO planets VALUES (2,95,7,0,155,0,0,0,0,0,378,'Pesht IV-D','D',73,212802,'default.jpg');
INSERT INTO planets VALUES (3,95,7,0,0,158,0,0,0,0,379,'Pesht III-T','T',0,5221,'default.jpg');
INSERT INTO planets VALUES (4,95,7,100,100,0,0,0,0,1,380,'Pesht','O',100,27070000,'default.jpg');
INSERT INTO planets VALUES (5,95,7,94,0,0,0,0,0,0,381,'Pesht II-M','M',92,993932,'default.jpg');
INSERT INTO planets VALUES (6,95,7,0,0,0,128,0,0,0,382,'Pesht V-I','I',74,80653,'default.jpg');
INSERT INTO planets VALUES (1,96,0,0,209,0,0,0,0,0,383,'Unnamed','H',0,1005,'default.jpg');
INSERT INTO planets VALUES (2,96,0,0,148,0,0,0,0,0,384,'Unnamed','D',43,1007,'default.jpg');
INSERT INTO planets VALUES (3,96,0,0,116,0,0,0,0,0,385,'Unnamed','D',50,1062,'default.jpg');
INSERT INTO planets VALUES (4,96,0,0,124,0,0,0,0,0,386,'Unnamed','G',0,1027,'default.jpg');
INSERT INTO planets VALUES (5,96,0,0,190,0,0,0,0,0,387,'Unnamed','H',0,1059,'default.jpg');
INSERT INTO planets VALUES (6,96,0,0,122,0,0,0,0,0,388,'Unnamed','G',0,1001,'default.jpg');
INSERT INTO planets VALUES (1,97,7,0,130,0,0,0,0,0,389,'Tokio -D','D',85,771561,'default.jpg');
INSERT INTO planets VALUES (2,97,7,0,116,0,0,0,0,0,390,'Tokio V-D','D',56,20136,'default.jpg');
INSERT INTO planets VALUES (3,97,7,0,207,0,0,0,0,0,391,'Tokio II-H','H',0,5202,'default.jpg');
INSERT INTO planets VALUES (4,97,7,71,0,0,0,0,0,0,392,'Tokio IV-R','R',88,138829,'default.jpg');
INSERT INTO planets VALUES (5,97,7,84,0,0,0,0,0,0,393,'Tokio III-M','M',46,36299,'default.jpg');
INSERT INTO planets VALUES (1,98,1,0,0,0,112,0,0,0,394,'Unnamed','I',80,346570,'default.jpg');
INSERT INTO planets VALUES (2,98,7,0,85,0,0,139,0,0,395,'New Pune','A',94,16084,'default.jpg');
INSERT INTO planets VALUES (3,98,0,0,172,0,0,0,0,0,396,'Unnamed','H',0,1034,'default.jpg');
INSERT INTO planets VALUES (4,98,1,0,0,0,128,0,0,0,397,'SIEBZEHN','I',56,181771,'default.jpg');
INSERT INTO planets VALUES (5,98,0,0,194,0,0,0,0,0,398,'Unnamed','H',0,1029,'default.jpg');
INSERT INTO planets VALUES (6,98,0,0,178,0,0,0,0,0,399,'Unnamed','H',0,1051,'default.jpg');
INSERT INTO planets VALUES (7,98,1,100,100,0,0,0,0,1,400,'ACHTZEHN','O',100,1566710,'default.jpg');
INSERT INTO planets VALUES (8,98,0,0,186,0,0,0,0,0,401,'Unnamed','H',0,1072,'default.jpg');
INSERT INTO planets VALUES (1,99,0,0,124,0,0,0,0,0,402,'Unnamed','G',0,1078,'default.jpg');
INSERT INTO planets VALUES (2,99,0,0,165,0,0,0,0,0,403,'Unnamed','H',0,1041,'default.jpg');
INSERT INTO planets VALUES (3,99,0,0,166,0,0,0,0,0,404,'Unnamed','D',80,1008,'default.jpg');
INSERT INTO planets VALUES (4,99,0,0,178,0,0,0,0,0,405,'Unnamed','H',0,1045,'default.jpg');
INSERT INTO planets VALUES (1,100,2,100,100,0,0,0,0,1,406,'River Crossing','O',100,2976967,'default.jpg');
INSERT INTO planets VALUES (2,100,0,0,172,0,0,0,0,0,407,'Unnamed','H',0,1009,'default.jpg');
INSERT INTO planets VALUES (1,101,7,110,74,0,0,0,0,0,408,'Aleron','O',87,1482940,'default.jpg');
INSERT INTO planets VALUES (2,101,7,0,0,0,110,0,0,0,409,'Aleron VI-I','I',86,95745,'default.jpg');
INSERT INTO planets VALUES (3,101,7,0,0,110,0,0,0,0,410,'Aleron IV-T','T',0,5216,'default.jpg');
INSERT INTO planets VALUES (4,101,7,0,0,159,0,0,0,0,411,'Aleron III-T','T',0,5240,'default.jpg');
INSERT INTO planets VALUES (5,101,7,53,0,0,0,0,0,0,412,'Aleron V-M','M',67,73960,'default.jpg');
INSERT INTO planets VALUES (6,101,7,0,203,0,0,0,0,0,413,'Aleron VII-H','H',0,5108,'default.jpg');
INSERT INTO planets VALUES (7,101,7,100,0,0,0,0,0,0,414,'Aleron II-M','M',100,1509857,'default.jpg');
INSERT INTO planets VALUES (1,104,8,100,100,0,0,0,0,1,415,'Ventilator','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (2,104,8,0,124,0,0,0,0,0,416,'Backblech','D',46,333927,'default.jpg');
INSERT INTO planets VALUES (3,104,0,0,198,0,0,0,0,0,417,'Unnamed','H',0,1002,'default.jpg');
INSERT INTO planets VALUES (4,104,0,0,160,0,0,0,0,0,418,'Unnamed','H',0,1003,'default.jpg');
INSERT INTO planets VALUES (5,104,8,0,0,0,118,0,0,0,419,'Wursthaut','I',83,2083281,'default.jpg');
INSERT INTO planets VALUES (1,105,7,100,100,0,0,0,0,1,420,'Richol II','O',100,1886606,'default.jpg');
INSERT INTO planets VALUES (2,105,7,0,154,0,0,0,0,0,421,'Richol V-D','D',71,128300,'default.jpg');
INSERT INTO planets VALUES (3,105,0,0,169,0,0,0,0,0,422,'Unnamed','H',0,1074,'default.jpg');
INSERT INTO planets VALUES (4,105,0,0,200,0,0,0,0,0,423,'Unnamed','H',0,1088,'default.jpg');
INSERT INTO planets VALUES (5,105,7,100,100,0,0,0,0,1,424,'Richol III','O',100,1768891,'default.jpg');
INSERT INTO planets VALUES (6,105,7,0,99,0,0,149,0,0,425,'Richol IV-A','A',94,1414710,'default.jpg');
INSERT INTO planets VALUES (7,105,7,117,109,0,0,0,0,0,426,'Richol','O',127,17241811,'default.jpg');
INSERT INTO planets VALUES (1,108,0,0,158,0,0,0,0,0,427,'Unnamed','H',0,1004,'default.jpg');
INSERT INTO planets VALUES (2,108,7,0,150,0,0,0,0,0,428,'Hongkong -M','D',77,138242,'default.jpg');
INSERT INTO planets VALUES (3,108,8,46,0,0,0,0,0,0,429,'Fettfleisch','R',47,64149,'default.jpg');
INSERT INTO planets VALUES (4,108,0,0,198,0,0,0,0,0,430,'Unnamed','H',0,1021,'default.jpg');
INSERT INTO planets VALUES (1,109,9,0,0,133,0,0,0,0,431,'Magnopolis I','T',0,5274,'default.jpg');
INSERT INTO planets VALUES (2,109,0,0,91,0,0,0,0,0,432,'Unnamed','G',0,1085,'default.jpg');
INSERT INTO planets VALUES (3,109,0,0,169,0,0,0,0,0,433,'Unnamed','H',0,1003,'default.jpg');
INSERT INTO planets VALUES (4,109,0,0,116,0,0,0,0,0,434,'Unnamed','G',0,1024,'default.jpg');
INSERT INTO planets VALUES (5,109,8,73,0,0,0,0,0,0,435,'Dampfnudel','M',80,202294,'default.jpg');
INSERT INTO planets VALUES (6,109,1,0,0,0,147,0,0,0,436,'Unnamed','I',51,83101,'default.jpg');
INSERT INTO planets VALUES (7,109,1,0,0,0,153,0,0,0,437,'Unnamed','I',53,88424,'default.jpg');
INSERT INTO planets VALUES (1,110,0,0,113,0,0,0,0,0,438,'Unnamed','G',0,1044,'default.jpg');
INSERT INTO planets VALUES (2,110,9,100,100,0,0,0,0,1,439,'Magnopolis II','O',100,2147483647,'default.jpg');
INSERT INTO planets VALUES (3,110,9,0,79,0,0,130,0,0,440,'Magnopolis III','A',42,129603,'default.jpg');
INSERT INTO planets VALUES (4,110,9,120,75,0,0,0,0,0,441,'Magnopolis IV','O',108,22732997,'default.jpg');
INSERT INTO planets VALUES (5,110,0,0,146,0,0,0,0,0,442,'Unnamed','D',80,1006,'default.jpg');
INSERT INTO planets VALUES (6,110,0,0,181,0,0,0,0,0,443,'Unnamed','H',0,1053,'default.jpg');
INSERT INTO planets VALUES (7,110,0,0,151,0,0,0,0,0,444,'Unnamed','D',88,1055,'default.jpg');
INSERT INTO planets VALUES (1,111,0,0,128,0,0,0,0,0,445,'Unnamed','D',76,1016,'default.jpg');
INSERT INTO planets VALUES (2,111,9,100,100,0,0,0,0,1,446,'Magnopolis V','O',100,1018431,'default.jpg');
INSERT INTO planets VALUES (3,111,0,0,126,0,0,0,0,0,447,'Unnamed','D',44,1092,'default.jpg');
INSERT INTO planets VALUES (1,112,0,0,190,0,0,0,0,0,448,'Unnamed','H',0,1003,'default.jpg');
INSERT INTO planets VALUES (2,112,9,59,0,0,0,0,0,0,449,'Magnopolis XXX','M',61,8923,'default.jpg');
INSERT INTO planets VALUES (3,112,9,0,46,0,0,150,0,0,450,'Magnopolis VI','A',40,90091,'default.jpg');
INSERT INTO planets VALUES (4,112,0,0,158,0,0,0,0,0,451,'Unnamed','D',74,1037,'default.jpg');
INSERT INTO planets VALUES (5,112,0,0,146,0,0,0,0,0,452,'Unnamed','D',62,1093,'default.jpg');
INSERT INTO planets VALUES (6,112,0,0,163,0,0,0,0,0,453,'Unnamed','H',0,1021,'default.jpg');
INSERT INTO planets VALUES (7,112,0,0,186,0,0,0,0,0,454,'Unnamed','H',0,1008,'default.jpg');
INSERT INTO planets VALUES (8,112,0,0,101,0,0,0,0,0,455,'Unnamed','G',0,1007,'default.jpg');
INSERT INTO planets VALUES (1,113,0,0,136,0,0,0,0,0,456,'Unnamed','D',47,1071,'default.jpg');
INSERT INTO planets VALUES (2,113,8,42,0,0,0,0,0,0,457,'Nudelauflauf','M',48,51890,'default.jpg');
INSERT INTO planets VALUES (1,114,0,0,118,0,0,0,0,0,458,'Unnamed','G',0,1039,'default.jpg');
INSERT INTO planets VALUES (2,114,0,0,159,0,0,0,0,0,459,'Unnamed','D',76,1034,'default.jpg');
INSERT INTO planets VALUES (3,114,0,0,190,0,0,0,0,0,460,'Unnamed','H',0,1007,'default.jpg');
INSERT INTO planets VALUES (4,114,0,0,175,0,0,0,0,0,461,'Unnamed','H',0,1002,'default.jpg');
INSERT INTO planets VALUES (5,114,0,0,192,0,0,0,0,0,462,'Unnamed','H',0,1027,'default.jpg');
INSERT INTO planets VALUES (6,114,0,0,210,0,0,0,0,0,463,'Unnamed','H',0,1054,'default.jpg');
INSERT INTO planets VALUES (7,114,9,100,100,0,0,0,0,1,464,'Magnopolis VIII','O',100,999205,'default.jpg');
INSERT INTO planets VALUES (8,114,9,104,77,0,0,0,0,0,465,'Magnopolis VII','O',71,424222,'default.jpg');
INSERT INTO planets VALUES (1,115,0,0,195,0,0,0,0,0,466,'Unnamed','H',0,1029,'default.jpg');
INSERT INTO planets VALUES (2,115,0,0,161,0,0,0,0,0,467,'Unnamed','H',0,1050,'default.jpg');
INSERT INTO planets VALUES (1,116,9,0,94,0,0,148,0,0,468,'Magnopolis XII','A',87,139162,'default.jpg');
INSERT INTO planets VALUES (2,116,2,86,0,0,0,0,0,0,469,'Rock','R',44,9866,'default.jpg');
INSERT INTO planets VALUES (3,116,0,0,160,0,0,0,0,0,470,'Unnamed','H',0,1016,'default.jpg');
INSERT INTO planets VALUES (4,116,9,0,0,136,0,0,0,0,471,'Magnopolis X','T',0,5259,'default.jpg');
INSERT INTO planets VALUES (5,116,9,0,0,164,0,0,0,0,472,'Magnopolis IX','T',0,5236,'default.jpg');
INSERT INTO planets VALUES (6,116,9,0,95,0,0,123,0,0,473,'Magnopolis XI','A',96,243110,'default.jpg');
INSERT INTO planets VALUES (1,117,0,0,167,0,0,0,0,0,474,'Unnamed','D',57,1028,'default.jpg');
INSERT INTO planets VALUES (2,117,2,63,0,0,0,0,0,0,475,'marsupilami 2','M',57,10578,'default.jpg');
INSERT INTO planets VALUES (3,117,0,0,121,0,0,0,0,0,476,'Unnamed','D',99,1025,'default.jpg');
INSERT INTO planets VALUES (4,117,9,81,0,0,0,0,0,0,477,'Magnopolis XXVI','M',83,13132,'default.jpg');
INSERT INTO planets VALUES (5,117,0,0,122,0,0,0,0,0,478,'Unnamed','D',86,1045,'default.jpg');
INSERT INTO planets VALUES (6,117,0,0,161,0,0,0,0,0,479,'Unnamed','D',64,1036,'default.jpg');
INSERT INTO planets VALUES (7,117,0,0,158,0,0,0,0,0,480,'Unnamed','D',93,1003,'default.jpg');
INSERT INTO planets VALUES (8,117,9,100,100,0,0,0,0,1,481,'Magnopolis XIII','O',100,1618282,'default.jpg');
INSERT INTO planets VALUES (1,119,9,0,0,0,111,0,0,0,482,'Magnopolis XV','I',50,71089,'default.jpg');
INSERT INTO planets VALUES (2,119,9,0,81,0,0,115,0,0,483,'Magnopolis XVI','A',42,45210,'default.jpg');
INSERT INTO planets VALUES (3,119,0,0,139,0,0,0,0,0,484,'Unnamed','D',96,1045,'default.jpg');
INSERT INTO planets VALUES (4,119,9,100,100,0,0,0,0,1,485,'Magnopolis XIV','O',100,369078,'default.jpg');
INSERT INTO planets VALUES (5,119,9,0,0,133,0,0,0,0,486,'Magnopolis XVII','T',0,5183,'default.jpg');
INSERT INTO planets VALUES (1,120,0,0,170,0,0,0,0,0,487,'Unnamed','D',78,1001,'default.jpg');
INSERT INTO planets VALUES (2,120,0,0,156,0,0,0,0,0,488,'Unnamed','D',72,1053,'default.jpg');
INSERT INTO planets VALUES (3,120,0,0,151,0,0,0,0,0,489,'Unnamed','H',0,1018,'default.jpg');
INSERT INTO planets VALUES (4,120,2,54,0,0,0,0,0,0,490,'New3','M',66,20192,'default.jpg');
INSERT INTO planets VALUES (5,120,9,0,0,0,138,0,0,0,491,'Magnopolis XIIX','I',99,250677,'default.jpg');
INSERT INTO planets VALUES (1,121,9,41,0,0,0,0,0,0,492,'Magnopolis XXIIX','R',67,9856,'default.jpg');
INSERT INTO planets VALUES (2,121,9,0,0,0,125,0,0,0,493,'Magnopolis XIX','I',55,186826,'default.jpg');
INSERT INTO planets VALUES (3,121,9,0,0,0,113,0,0,0,494,'Magnopolis XX','I',52,181802,'default.jpg');
INSERT INTO planets VALUES (4,121,0,0,179,0,0,0,0,0,495,'Unnamed','H',0,1002,'default.jpg');
INSERT INTO planets VALUES (5,121,0,0,81,0,0,0,0,0,496,'Unnamed','G',0,1039,'default.jpg');
INSERT INTO planets VALUES (6,121,0,0,96,0,0,0,0,0,497,'Unnamed','G',0,1010,'default.jpg');
INSERT INTO planets VALUES (7,121,9,119,80,0,0,0,0,0,498,'Magnopolis XXI','O',121,3891149,'default.jpg');
INSERT INTO planets VALUES (8,121,0,0,98,0,0,0,0,0,499,'Unnamed','G',0,1014,'default.jpg');

--
-- Table structure for table 'popupgrade'
--

DROP TABLE IF EXISTS popupgrade;
CREATE TABLE popupgrade (
  prod_id int(11) NOT NULL default '0',
  value int(11) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table 'popupgrade'
--


INSERT INTO popupgrade VALUES (19,10);
INSERT INTO popupgrade VALUES (21,20);
INSERT INTO popupgrade VALUES (22,5);
INSERT INTO popupgrade VALUES (25,50);
INSERT INTO popupgrade VALUES (40,2);
INSERT INTO popupgrade VALUES (43,4);
INSERT INTO popupgrade VALUES (47,30);
INSERT INTO popupgrade VALUES (11,2);

--
-- Table structure for table 'portraits'
--

DROP TABLE IF EXISTS portraits;
CREATE TABLE portraits (
  pic varchar(255) default NULL,
  gender char(1) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'portraits'
--


INSERT INTO portraits VALUES ('p1.jpg','m',1);
INSERT INTO portraits VALUES ('p2.jpg','w',2);
INSERT INTO portraits VALUES ('p3.jpg','m',3);
INSERT INTO portraits VALUES ('p4.jpg','m',4);
INSERT INTO portraits VALUES ('p5.jpg','m',5);
INSERT INTO portraits VALUES ('p6.jpg','w',6);
INSERT INTO portraits VALUES ('p7.jpg','m',7);
INSERT INTO portraits VALUES ('p9.jpg','m',8);
INSERT INTO portraits VALUES ('p8.jpg','m',9);

--
-- Table structure for table 'prod_upgrade'
--

DROP TABLE IF EXISTS prod_upgrade;
CREATE TABLE prod_upgrade (
  factor decimal(10,0) default NULL,
  prod_id int(11) default NULL,
  ressource varchar(255) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'prod_upgrade'
--


INSERT INTO prod_upgrade VALUES (2,4,'energy');
INSERT INTO prod_upgrade VALUES (4,23,'energy');
INSERT INTO prod_upgrade VALUES (2,100,'metal');
INSERT INTO prod_upgrade VALUES (3,31,'mopgas');
INSERT INTO prod_upgrade VALUES (3,32,'gortium');
INSERT INTO prod_upgrade VALUES (3,33,'erkunum');
INSERT INTO prod_upgrade VALUES (3,34,'susebloom');
INSERT INTO prod_upgrade VALUES (4,63,'metal');
INSERT INTO prod_upgrade VALUES (8,51,'energy');
INSERT INTO prod_upgrade VALUES (2,53,'metal');

--
-- Table structure for table 'production'
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
  PRIMARY KEY  (prod_id),
  UNIQUE KEY prod_id (prod_id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'production'
--


INSERT INTO production VALUES (2,'P',0,1,'Barracks','Allows building of Ground Units',0,0,0,0,1000,1000,'',NULL,NULL,'p_barracks.jpg',0);
INSERT INTO production VALUES (2,'L',2,2,'Scout','Small ship to visit the stars',0,0,0,0,100,100,'',60,NULL,'p_scout.jpg',0);
INSERT INTO production VALUES (2,'L',2,3,'Probe','Let me be your eye',0,0,0,0,50,50,'',NULL,NULL,'p_probe.jpg',0);
INSERT INTO production VALUES (4,'P',3,4,'Nuclear Power Plant','Nuclear Energy',0,0,0,0,200,1000,'',NULL,NULL,'p_nuclear_plant.jpg',0);
INSERT INTO production VALUES (5,'P',4,5,'Laser Weapons Factory','First weapon for use in Space',0,0,0,0,700,500,'',NULL,NULL,'p_lwf.jpg',0);
INSERT INTO production VALUES (3,'L',4,6,'Interceptor','Maybe there are some dangers in space.',0,0,0,0,200,200,'',5,NULL,'p_interceptor.jpg',0);
INSERT INTO production VALUES (1,'I',4,7,'Soldier','Protection for our cities',0,0,0,0,10,10,'',1,NULL,'default.jpg',0);
INSERT INTO production VALUES (10,'R',6,8,'Tradestation','Galactic interrelationships depend on galactic trade.',0,0,0,0,5000,5000,'U',NULL,NULL,'p_tradestation.jpg',0);
INSERT INTO production VALUES (4,'M',6,9,'Transporters','Transports infantery and cargo',0,0,0,0,200,200,'',60,NULL,'default.jpg',0);
INSERT INTO production VALUES (12,'O',7,10,'Spacestation','Building of large ships depends on it',0,0,0,0,3000,6000,'',60,NULL,'p_spacestation.jpg',0);
INSERT INTO production VALUES (12,'P',8,11,'Arcology','The autonom City',0,0,0,0,2000,5000,'',NULL,NULL,'p_arcology.jpg',0);
INSERT INTO production VALUES (24,'H',8,12,'Colony ship','Earth is just too small for mankind',0,0,0,0,4000,4000,'C',60,NULL,'p_colonyship.jpg',8000);
INSERT INTO production VALUES (6,'P',10,13,'Ground batteries','So far our planets are defenseless (not implemented)',0,0,0,0,2000,3000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (3,'L',10,14,'B-5056 Bomber','Very effective attack unit',0,0,0,0,200,250,'',60,NULL,'p_b5056.jpg',0);
INSERT INTO production VALUES (15,'P',11,15,'Planetary Shield Generator','not yet implemented',0,0,0,0,5000,2000,'',23,NULL,'p_planetary_shield.jpg',0);
INSERT INTO production VALUES (3,'M',11,16,'Peacekeeper Corvette','EMP-weapon armed corvette',0,0,0,0,350,350,'',60,NULL,'p_peace_corv.jpg',0);
INSERT INTO production VALUES (8,'O',12,17,'Orbital Refueling Station','Reduces recharging time (not implemented)',0,0,0,0,4000,1000,'F',10,NULL,'default.jpg',0);
INSERT INTO production VALUES (12,'H',12,18,'Carrier','Transports light ships ',0,0,0,0,8000,3000,'',10,NULL,'default.jpg',0);
INSERT INTO production VALUES (12,'P',14,19,'Gen Factory','Increases poplation grow',0,0,0,0,600,400,'',NULL,NULL,'p_gen_fac.jpg',0);
INSERT INTO production VALUES (2,'I',14,20,'Space Marines','Elite Ground Troopers',0,0,0,0,20,20,'',1,NULL,'default.jpg',0);
INSERT INTO production VALUES (4,'P',15,21,'Cloning Vaults','...',0,0,0,0,2000,500,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (5,'P',16,22,'Agriculture Command Center','Imporved Farming',0,0,0,0,900,200,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (24,'P',18,23,'Fusion Power Plant','Advanced energy scource',0,0,0,0,1000,2000,'',4,NULL,'default.jpg',0);
INSERT INTO production VALUES (3,'L',22,24,'N-2103 Bomber','More destructiv? Yesss...',0,200,0,200,600,500,'',60,NULL,'p_n2103.jpg',0);
INSERT INTO production VALUES (30,'P',23,25,'Clima Controlling Facillity','Impoves living conditions on a planet',0,0,0,0,10000,4000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (24,'P',25,26,'Instant Plasma Facility','Produces plasma weapons',0,0,0,0,5000,4000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (6,'P',26,27,'Missle Base','Planetary Missle Defense [not implemented]',0,0,0,0,2000,4000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (6,'M',26,28,'Hijacker','Able to caputre enemy ships (M)',0,0,0,0,2000,1000,'',60,NULL,'p_hijacker.jpg',0);
INSERT INTO production VALUES (6,'M',27,29,'Freezer','Able to disable enemy ships (M)',0,0,500,500,3000,800,'',60,NULL,'p_freezer.jpg',0);
INSERT INTO production VALUES (48,'P',29,30,'Labour Training Camp','Increases production (not implemented)',0,0,0,0,8000,8000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (18,'O',34,31,'Mopgas Extraction Platform','Extracts mopgas from the atmosphere of toxic planets',0,0,0,0,4000,6000,'',66,NULL,'default.jpg',0);
INSERT INTO production VALUES (20,'P',35,32,'Gortium Mine','Extracts Gortium from ancient planets',0,0,0,0,2000,8000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (22,'P',36,33,'Erkunum Pumping Station','Exploits the erkunum deposits on ice planets',0,0,0,0,6000,4000,'',NULL,NULL,'p_erk_pump.jpg',0);
INSERT INTO production VALUES (16,'P',37,34,'Mobile Susebloom Harvester','Increases the susebloom harvest on eden planets',0,0,0,0,5000,5000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (10,'M',39,35,'Dreamcatcher Frigatte','Detects hidden ships',0,0,0,0,800,600,'',60,NULL,'default.jpg',0);
INSERT INTO production VALUES (8,'P',40,36,'Surveillance Cluster','Sensor array',0,0,2000,0,10000,5000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (11,'H',40,37,'Beholder','...',0,0,0,0,2700,3700,'',10,NULL,'p_beholder.jpg',0);
INSERT INTO production VALUES (14,'P',41,38,'Defence Masquerader','Hides your defence from enemy sensors',0,0,0,0,3000,900,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (9,'M',41,39,'Octopus Corvette','Hides the accompaning fleet from detection',0,0,0,0,1600,400,'',46,NULL,'default.jpg',0);
INSERT INTO production VALUES (8,'P',43,40,'Cybersurgery Facility','Improves organic live through technological means',0,0,0,0,10000,12000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (2,'I',43,41,'Cyborg','High tech soldier',0,0,0,0,50,50,'',40,NULL,'default.jpg',0);
INSERT INTO production VALUES (12,'P',44,42,'Living/Rigged Factory','Mind controlled factory',0,0,0,0,2000,2000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (11,'P',45,43,'Pleasure Studio','Improves your people moral',0,0,0,0,1600,600,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (4,'V',48,44,'Droid','Ground combat robot',0,0,0,0,100,300,'',NULL,NULL,'p_droid.jpg',0);
INSERT INTO production VALUES (10,'M',49,45,'Hydra','More guns...more power',0,0,0,0,1000,2000,'',10,NULL,'default.jpg',0);
INSERT INTO production VALUES (15,'P',50,46,'Laser Weapons Factory II','...',0,0,0,0,2300,1400,'',5,NULL,'p_lwf2.jpg',0);
INSERT INTO production VALUES (16,'P',58,47,'Cure Hospital','Improves living conditions',1000,0,0,0,6000,4300,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (18,'L',60,48,'Behemoth','Big ship...big guns...big...',0,5000,1000,5000,16000,20000,'',10,NULL,'default.jpg',0);
INSERT INTO production VALUES (17,'O',61,49,'Orbital Batterie','',0,0,0,0,5000,6000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (2,'I',64,50,'Shadow','Stealth Infantrie',0,0,100,0,100,10,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (92,'P',69,51,'Antimatter Power Plant','Ultimate power scource',0,1000,5000,3000,20000,40000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (16,'H',73,52,'Wrath','Cloaks accompanding fleet',0,0,4000,0,12000,6000,'',10,NULL,'default.jpg',0);
INSERT INTO production VALUES (1,'P',0,53,'Metal Mine','Produces Metal',0,0,0,0,1000,200,'',NULL,NULL,'p_metal_mine.jpg',0);
INSERT INTO production VALUES (3,'V',18,54,'Mad Max','Light ground combat vehicle',0,0,0,0,30,50,'',5,NULL,'default.jpg',0);
INSERT INTO production VALUES (4,'I',25,55,'Stonewall Tank','Heavy plasma tank',0,0,0,0,80,100,'',26,NULL,'p_stonewalltank.jpg',0);
INSERT INTO production VALUES (6,'P',30,56,'Neural Secrurity Network','Improves security conditions on your planet',0,0,0,0,800,800,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (8,'P',47,57,'Observation Center','...',0,0,10000,0,15000,15000,'',NULL,NULL,'p_observation_center.jpg',0);
INSERT INTO production VALUES (10,'P',64,58,'Infiltration Training Camp','...',0,0,0,0,1500,2000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (24,'P',74,59,'Cloaking Suit Factory','Makes your agents invisible...',0,0,0,0,8000,5000,'',NULL,NULL,'default.jpg',0);
INSERT INTO production VALUES (4,'P',0,60,'Starport','First step away from your homeworld',0,0,0,0,800,800,'',NULL,NULL,'p_starport.jpg',0);
INSERT INTO production VALUES (92,'O',27,61,'Jumpgate','...',0,10000,10000,10000,20000,20000,'S',10,NULL,'p_jumpgate.jpg',0);
INSERT INTO production VALUES (48,'H',8,62,'Orbital Colony Center Unit','...',0,0,0,0,6000,6000,'O',10,NULL,'p_orbital_colony_center.jpg',5000);
INSERT INTO production VALUES (24,'P',18,63,'Mining Complex','Expands the miningsystem around the hole planet',0,0,0,0,2000,1000,'',53,NULL,'default.jpg',0);
INSERT INTO production VALUES (10,'M',50,64,'Gunship','Gunship - in testing',0,0,0,0,600,600,'',10,NULL,'p_gunship.jpg',0);
INSERT INTO production VALUES (0,'P',-1,65,'Colony','The Living and Workingplace where our Colonists increases our empires honour',0,0,0,0,0,0,'',0,NULL,'default.jpg',0);
INSERT INTO production VALUES (0,'O',-1,66,'Orbital Colony','Orbital Living and Workingplace where our Colonists increases our empires honour',0,0,0,0,0,0,'',0,NULL,'p_orbital_colony_center.jpg',0);

--
-- Table structure for table 'reload'
--

DROP TABLE IF EXISTS reload;
CREATE TABLE reload (
  uid int(11) NOT NULL default '0',
  UNIQUE KEY uid (uid)
) TYPE=MyISAM;

--
-- Dumping data for table 'reload'
--


INSERT INTO reload VALUES (1);
INSERT INTO reload VALUES (2);
INSERT INTO reload VALUES (5);
INSERT INTO reload VALUES (6);
INSERT INTO reload VALUES (7);
INSERT INTO reload VALUES (8);
INSERT INTO reload VALUES (9);

--
-- Table structure for table 'res_to_trade'
--

DROP TABLE IF EXISTS res_to_trade;
CREATE TABLE res_to_trade (
  metal int(11) default NULL,
  energy int(11) default NULL,
  mopgas int(11) default NULL,
  erkunum int(11) default NULL,
  gortium int(11) default NULL,
  susebloom int(11) default NULL,
  uid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'res_to_trade'
--


INSERT INTO res_to_trade VALUES (0,1,1,1,1,0,7);
INSERT INTO res_to_trade VALUES (0,0,100,100,100,0,9);
INSERT INTO res_to_trade VALUES (1,1,0,0,0,0,4);

--
-- Table structure for table 'research'
--

DROP TABLE IF EXISTS research;
CREATE TABLE research (
  uid int(11) NOT NULL default '0',
  t_id int(11) default NULL,
  KEY uid (uid)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'research'
--


INSERT INTO research VALUES (1,0);
INSERT INTO research VALUES (2,0);
INSERT INTO research VALUES (1,1);
INSERT INTO research VALUES (2,1);
INSERT INTO research VALUES (1,4);
INSERT INTO research VALUES (2,5);
INSERT INTO research VALUES (1,3);
INSERT INTO research VALUES (2,9);
INSERT INTO research VALUES (2,13);
INSERT INTO research VALUES (1,2);
INSERT INTO research VALUES (1,5);
INSERT INTO research VALUES (1,7);
INSERT INTO research VALUES (2,17);
INSERT INTO research VALUES (2,2);
INSERT INTO research VALUES (1,9);
INSERT INTO research VALUES (2,3);
INSERT INTO research VALUES (2,4);
INSERT INTO research VALUES (1,8);
INSERT INTO research VALUES (2,6);
INSERT INTO research VALUES (1,46);
INSERT INTO research VALUES (1,50);
INSERT INTO research VALUES (2,46);
INSERT INTO research VALUES (2,50);
INSERT INTO research VALUES (2,7);
INSERT INTO research VALUES (2,10);
INSERT INTO research VALUES (3,0);
INSERT INTO research VALUES (4,0);
INSERT INTO research VALUES (4,1);
INSERT INTO research VALUES (4,2);
INSERT INTO research VALUES (2,18);
INSERT INTO research VALUES (2,11);
INSERT INTO research VALUES (2,8);
INSERT INTO research VALUES (4,5);
INSERT INTO research VALUES (2,12);
INSERT INTO research VALUES (4,7);
INSERT INTO research VALUES (4,6);
INSERT INTO research VALUES (5,0);
INSERT INTO research VALUES (4,3);
INSERT INTO research VALUES (5,1);
INSERT INTO research VALUES (5,3);
INSERT INTO research VALUES (2,14);
INSERT INTO research VALUES (5,2);
INSERT INTO research VALUES (4,8);
INSERT INTO research VALUES (5,5);
INSERT INTO research VALUES (6,0);
INSERT INTO research VALUES (1,12);
INSERT INTO research VALUES (5,8);
INSERT INTO research VALUES (4,4);
INSERT INTO research VALUES (6,1);
INSERT INTO research VALUES (4,9);
INSERT INTO research VALUES (2,20);
INSERT INTO research VALUES (4,12);
INSERT INTO research VALUES (7,0);
INSERT INTO research VALUES (5,7);
INSERT INTO research VALUES (4,10);
INSERT INTO research VALUES (8,0);
INSERT INTO research VALUES (1,10);
INSERT INTO research VALUES (8,1);
INSERT INTO research VALUES (9,0);
INSERT INTO research VALUES (5,9);
INSERT INTO research VALUES (9,1);
INSERT INTO research VALUES (4,13);
INSERT INTO research VALUES (8,5);
INSERT INTO research VALUES (9,5);
INSERT INTO research VALUES (1,13);
INSERT INTO research VALUES (7,1);
INSERT INTO research VALUES (2,21);
INSERT INTO research VALUES (9,9);
INSERT INTO research VALUES (7,2);
INSERT INTO research VALUES (4,17);
INSERT INTO research VALUES (5,12);
INSERT INTO research VALUES (8,3);
INSERT INTO research VALUES (1,6);
INSERT INTO research VALUES (7,3);
INSERT INTO research VALUES (7,4);
INSERT INTO research VALUES (8,9);
INSERT INTO research VALUES (4,19);
INSERT INTO research VALUES (9,13);
INSERT INTO research VALUES (7,5);
INSERT INTO research VALUES (1,17);
INSERT INTO research VALUES (9,17);
INSERT INTO research VALUES (4,18);
INSERT INTO research VALUES (7,8);
INSERT INTO research VALUES (2,24);
INSERT INTO research VALUES (9,2);
INSERT INTO research VALUES (9,3);
INSERT INTO research VALUES (8,6);
INSERT INTO research VALUES (4,14);
INSERT INTO research VALUES (9,4);
INSERT INTO research VALUES (7,7);
INSERT INTO research VALUES (8,7);
INSERT INTO research VALUES (9,12);
INSERT INTO research VALUES (8,8);
INSERT INTO research VALUES (7,6);
INSERT INTO research VALUES (1,19);
INSERT INTO research VALUES (7,9);
INSERT INTO research VALUES (2,27);
INSERT INTO research VALUES (4,20);
INSERT INTO research VALUES (8,2);
INSERT INTO research VALUES (6,3);
INSERT INTO research VALUES (9,20);
INSERT INTO research VALUES (7,13);
INSERT INTO research VALUES (6,2);
INSERT INTO research VALUES (8,4);
INSERT INTO research VALUES (9,8);
INSERT INTO research VALUES (7,11);
INSERT INTO research VALUES (8,10);
INSERT INTO research VALUES (9,6);
INSERT INTO research VALUES (2,22);
INSERT INTO research VALUES (4,22);
INSERT INTO research VALUES (7,12);
INSERT INTO research VALUES (8,11);
INSERT INTO research VALUES (1,18);
INSERT INTO research VALUES (7,10);
INSERT INTO research VALUES (9,18);
INSERT INTO research VALUES (4,11);
INSERT INTO research VALUES (9,7);
INSERT INTO research VALUES (7,14);
INSERT INTO research VALUES (2,23);
INSERT INTO research VALUES (9,14);
INSERT INTO research VALUES (4,15);
INSERT INTO research VALUES (8,12);
INSERT INTO research VALUES (7,17);
INSERT INTO research VALUES (9,19);
INSERT INTO research VALUES (1,20);
INSERT INTO research VALUES (7,18);
INSERT INTO research VALUES (9,10);
INSERT INTO research VALUES (2,19);
INSERT INTO research VALUES (4,24);
INSERT INTO research VALUES (7,19);
INSERT INTO research VALUES (9,22);
INSERT INTO research VALUES (1,22);
INSERT INTO research VALUES (2,26);
INSERT INTO research VALUES (7,20);
INSERT INTO research VALUES (8,13);
INSERT INTO research VALUES (9,24);
INSERT INTO research VALUES (4,27);
INSERT INTO research VALUES (7,24);
INSERT INTO research VALUES (8,14);
INSERT INTO research VALUES (1,24);
INSERT INTO research VALUES (3,1);
INSERT INTO research VALUES (4,25);
INSERT INTO research VALUES (2,25);
INSERT INTO research VALUES (9,23);
INSERT INTO research VALUES (7,25);
INSERT INTO research VALUES (9,11);
INSERT INTO research VALUES (7,15);
INSERT INTO research VALUES (1,28);
INSERT INTO research VALUES (3,2);
INSERT INTO research VALUES (2,28);
INSERT INTO research VALUES (4,28);
INSERT INTO research VALUES (7,22);
INSERT INTO research VALUES (9,25);
INSERT INTO research VALUES (9,15);
INSERT INTO research VALUES (3,3);
INSERT INTO research VALUES (9,16);
INSERT INTO research VALUES (7,26);
INSERT INTO research VALUES (1,32);
INSERT INTO research VALUES (4,32);
INSERT INTO research VALUES (2,33);
INSERT INTO research VALUES (8,15);
INSERT INTO research VALUES (9,28);
INSERT INTO research VALUES (7,28);
INSERT INTO research VALUES (5,13);
INSERT INTO research VALUES (4,30);
INSERT INTO research VALUES (1,33);
INSERT INTO research VALUES (2,34);
INSERT INTO research VALUES (5,17);
INSERT INTO research VALUES (8,16);
INSERT INTO research VALUES (9,33);
INSERT INTO research VALUES (7,32);
INSERT INTO research VALUES (8,17);
INSERT INTO research VALUES (7,27);
INSERT INTO research VALUES (5,19);
INSERT INTO research VALUES (9,29);
INSERT INTO research VALUES (3,4);
INSERT INTO research VALUES (7,16);
INSERT INTO research VALUES (4,29);
INSERT INTO research VALUES (2,38);
INSERT INTO research VALUES (8,18);
INSERT INTO research VALUES (1,34);
INSERT INTO research VALUES (5,18);
INSERT INTO research VALUES (7,21);
INSERT INTO research VALUES (7,23);
INSERT INTO research VALUES (5,20);
INSERT INTO research VALUES (8,19);
INSERT INTO research VALUES (4,33);
INSERT INTO research VALUES (9,38);
INSERT INTO research VALUES (2,40);
INSERT INTO research VALUES (2,16);
INSERT INTO research VALUES (7,29);
INSERT INTO research VALUES (5,24);
INSERT INTO research VALUES (8,20);
INSERT INTO research VALUES (1,38);
INSERT INTO research VALUES (9,34);
INSERT INTO research VALUES (4,34);
INSERT INTO research VALUES (2,32);
INSERT INTO research VALUES (5,28);
INSERT INTO research VALUES (7,33);
INSERT INTO research VALUES (8,21);
INSERT INTO research VALUES (5,32);
INSERT INTO research VALUES (9,42);
INSERT INTO research VALUES (2,36);
INSERT INTO research VALUES (7,34);
INSERT INTO research VALUES (8,22);
INSERT INTO research VALUES (1,40);
INSERT INTO research VALUES (3,5);
INSERT INTO research VALUES (8,23);
INSERT INTO research VALUES (7,35);
INSERT INTO research VALUES (5,33);
INSERT INTO research VALUES (4,38);
INSERT INTO research VALUES (9,46);
INSERT INTO research VALUES (1,42);
INSERT INTO research VALUES (2,35);
INSERT INTO research VALUES (8,24);
INSERT INTO research VALUES (7,38);
INSERT INTO research VALUES (4,40);
INSERT INTO research VALUES (2,30);
INSERT INTO research VALUES (8,25);
INSERT INTO research VALUES (7,41);
INSERT INTO research VALUES (2,29);
INSERT INTO research VALUES (9,51);
INSERT INTO research VALUES (4,39);
INSERT INTO research VALUES (8,26);
INSERT INTO research VALUES (9,27);
INSERT INTO research VALUES (7,36);
INSERT INTO research VALUES (9,32);
INSERT INTO research VALUES (8,27);
INSERT INTO research VALUES (2,51);
INSERT INTO research VALUES (5,38);
INSERT INTO research VALUES (7,40);
INSERT INTO research VALUES (9,40);
INSERT INTO research VALUES (7,39);
INSERT INTO research VALUES (9,36);
INSERT INTO research VALUES (2,47);
INSERT INTO research VALUES (4,42);
INSERT INTO research VALUES (5,42);
INSERT INTO research VALUES (9,35);
INSERT INTO research VALUES (7,42);
INSERT INTO research VALUES (4,37);
INSERT INTO research VALUES (2,42);
INSERT INTO research VALUES (9,26);
INSERT INTO research VALUES (5,46);
INSERT INTO research VALUES (6,4);
INSERT INTO research VALUES (4,41);
INSERT INTO research VALUES (7,43);
INSERT INTO research VALUES (9,41);
INSERT INTO research VALUES (2,53);
INSERT INTO research VALUES (1,47);

--
-- Table structure for table 'researching'
--

DROP TABLE IF EXISTS researching;
CREATE TABLE researching (
  t_id int(11) default NULL,
  uid int(11) default NULL,
  time int(11) default '0'
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'researching'
--


INSERT INTO researching VALUES (39,2,40);
INSERT INTO researching VALUES (46,7,5);
INSERT INTO researching VALUES (43,4,8);
INSERT INTO researching VALUES (50,9,27);

--
-- Table structure for table 'ressources'
--

DROP TABLE IF EXISTS ressources;
CREATE TABLE ressources (
  metal int(11) default NULL,
  energy int(11) default NULL,
  mopgas int(11) default NULL,
  erkunum int(11) default NULL,
  gortium int(11) default NULL,
  susebloom int(11) default NULL,
  uid int(11) default NULL,
  money int(11) NOT NULL default '1000',
  colonists int(11) default NULL
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'ressources'
--


INSERT INTO ressources VALUES (327860,428371,78859,134271,132202,42805,1,1000,128432);
INSERT INTO ressources VALUES (15110,33218,136334,86150,238421,268,2,1000,190165);
INSERT INTO ressources VALUES (109177,102639,1808,583,0,0,3,1000,99517);
INSERT INTO ressources VALUES (64010,64906,84673,13173,27308,27537,4,1000,150442);
INSERT INTO ressources VALUES (485287,685948,24796,8739,41516,0,5,1000,83078);
INSERT INTO ressources VALUES (123324,118094,0,0,0,0,6,1000,72348);
INSERT INTO ressources VALUES (8369,26905,52165,87646,47935,0,7,1000,159147);
INSERT INTO ressources VALUES (201256,235182,32417,33345,31060,2,8,1000,55902);
INSERT INTO ressources VALUES (23410,31904,10140,10107,10228,268,9,1000,80184);

--
-- Table structure for table 'routes'
--

DROP TABLE IF EXISTS routes;
CREATE TABLE routes (
  route mediumtext,
  fid int(11) NOT NULL default '0',
  PRIMARY KEY  (fid)
) TYPE=MyISAM;

--
-- Dumping data for table 'routes'
--


INSERT INTO routes VALUES ('a:0:{}',3);
INSERT INTO routes VALUES ('a:0:{}',6);
INSERT INTO routes VALUES ('a:0:{}',236);
INSERT INTO routes VALUES ('a:0:{}',2);
INSERT INTO routes VALUES ('a:0:{}',1);
INSERT INTO routes VALUES ('a:0:{}',8);
INSERT INTO routes VALUES ('a:0:{}',11);
INSERT INTO routes VALUES ('a:0:{}',251);
INSERT INTO routes VALUES ('a:0:{}',12);
INSERT INTO routes VALUES ('a:0:{}',9);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"15\";}',20);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"113\";}',56);
INSERT INTO routes VALUES ('a:0:{}',22);
INSERT INTO routes VALUES ('a:0:{}',25);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"1\";}',13);
INSERT INTO routes VALUES ('a:0:{}',82);
INSERT INTO routes VALUES ('a:0:{}',14);
INSERT INTO routes VALUES ('a:0:{}',15);
INSERT INTO routes VALUES ('a:0:{}',16);
INSERT INTO routes VALUES ('a:0:{}',27);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"90\";}',23);
INSERT INTO routes VALUES ('a:0:{}',24);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"88\";}',21);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"9\";}',26);
INSERT INTO routes VALUES ('a:0:{}',4);
INSERT INTO routes VALUES ('a:0:{}',17);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"8\";}',31);
INSERT INTO routes VALUES ('a:0:{}',10);
INSERT INTO routes VALUES ('a:0:{}',43);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"92\";}',40);
INSERT INTO routes VALUES ('a:0:{}',33);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"48\";}',59);
INSERT INTO routes VALUES ('a:0:{}',32);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"50\";}',95);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"2\";}',155);
INSERT INTO routes VALUES ('a:0:{}',44);
INSERT INTO routes VALUES ('a:0:{}',34);
INSERT INTO routes VALUES ('a:0:{}',35);
INSERT INTO routes VALUES ('a:0:{}',45);
INSERT INTO routes VALUES ('a:0:{}',41);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"65\";}',46);
INSERT INTO routes VALUES ('a:0:{}',38);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"65\";}',47);
INSERT INTO routes VALUES ('a:0:{}',81);
INSERT INTO routes VALUES ('a:0:{}',347);
INSERT INTO routes VALUES ('a:0:{}',99);
INSERT INTO routes VALUES ('a:0:{}',269);
INSERT INTO routes VALUES ('a:0:{}',55);
INSERT INTO routes VALUES ('a:0:{}',58);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"121\";}',98);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"88\";}',61);
INSERT INTO routes VALUES ('a:0:{}',18);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',104);
INSERT INTO routes VALUES ('a:0:{}',63);
INSERT INTO routes VALUES ('a:0:{}',64);
INSERT INTO routes VALUES ('a:0:{}',66);
INSERT INTO routes VALUES ('a:0:{}',67);
INSERT INTO routes VALUES ('a:0:{}',68);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',94);
INSERT INTO routes VALUES ('a:0:{}',74);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"70\";}',202);
INSERT INTO routes VALUES ('a:0:{}',189);
INSERT INTO routes VALUES ('a:0:{}',109);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"110\";}',134);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"117\";}',151);
INSERT INTO routes VALUES ('a:0:{}',224);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"112\";}',136);
INSERT INTO routes VALUES ('a:0:{}',93);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"99\";}',128);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"100\";}',129);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"109\";}',126);
INSERT INTO routes VALUES ('a:0:{}',80);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"100\";}',232);
INSERT INTO routes VALUES ('a:0:{}',259);
INSERT INTO routes VALUES ('a:0:{}',127);
INSERT INTO routes VALUES ('a:0:{}',119);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',240);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"114\";}',137);
INSERT INTO routes VALUES ('a:0:{}',201);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"9\";}',199);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"116\";}',152);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"111\";}',139);
INSERT INTO routes VALUES ('a:0:{}',173);
INSERT INTO routes VALUES ('a:0:{}',160);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"7\";}',198);
INSERT INTO routes VALUES ('a:0:{}',175);
INSERT INTO routes VALUES ('a:0:{}',358);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"79\";}',183);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"119\";}',153);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"80\";}',161);
INSERT INTO routes VALUES ('a:0:{}',154);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"120\";}',157);
INSERT INTO routes VALUES ('a:0:{}',156);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"96\";}',162);
INSERT INTO routes VALUES ('a:0:{}',145);
INSERT INTO routes VALUES ('a:0:{}',207);
INSERT INTO routes VALUES ('a:0:{}',225);
INSERT INTO routes VALUES ('a:0:{}',222);
INSERT INTO routes VALUES ('a:0:{}',181);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',285);
INSERT INTO routes VALUES ('a:0:{}',180);
INSERT INTO routes VALUES ('a:0:{}',235);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"5\";}',176);
INSERT INTO routes VALUES ('a:0:{}',182);
INSERT INTO routes VALUES ('a:0:{}',177);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',220);
INSERT INTO routes VALUES ('a:0:{}',217);
INSERT INTO routes VALUES ('a:0:{}',166);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"16\";}',167);
INSERT INTO routes VALUES ('b:0;',188);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"19\";}',168);
INSERT INTO routes VALUES ('a:0:{}',362);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"22\";}',169);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"65\";}',121);
INSERT INTO routes VALUES ('a:0:{}',170);
INSERT INTO routes VALUES ('a:0:{}',197);
INSERT INTO routes VALUES ('a:0:{}',196);
INSERT INTO routes VALUES ('a:0:{}',249);
INSERT INTO routes VALUES ('a:0:{}',253);
INSERT INTO routes VALUES ('a:0:{}',252);
INSERT INTO routes VALUES ('a:0:{}',332);
INSERT INTO routes VALUES ('a:0:{}',260);
INSERT INTO routes VALUES ('a:0:{}',324);
INSERT INTO routes VALUES ('a:0:{}',354);
INSERT INTO routes VALUES ('a:0:{}',284);
INSERT INTO routes VALUES ('a:0:{}',268);
INSERT INTO routes VALUES ('a:0:{}',215);
INSERT INTO routes VALUES ('a:0:{}',325);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',275);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"48\";}',213);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',282);
INSERT INTO routes VALUES ('a:0:{}',281);
INSERT INTO routes VALUES ('a:0:{}',311);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',304);
INSERT INTO routes VALUES ('a:0:{}',305);
INSERT INTO routes VALUES ('a:0:{}',294);
INSERT INTO routes VALUES ('a:0:{}',295);
INSERT INTO routes VALUES ('a:0:{}',292);
INSERT INTO routes VALUES ('a:0:{}',345);
INSERT INTO routes VALUES ('a:0:{}',321);
INSERT INTO routes VALUES ('a:1:{i:0;s:1:\"7\";}',328);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"74\";}',338);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',219);
INSERT INTO routes VALUES ('a:0:{}',333);
INSERT INTO routes VALUES ('a:0:{}',335);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"81\";}',348);
INSERT INTO routes VALUES ('a:0:{}',364);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"85\";}',317);
INSERT INTO routes VALUES ('a:0:{}',334);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"74\";}',342);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"19\";}',350);
INSERT INTO routes VALUES ('a:1:{i:0;s:3:\"105\";}',346);
INSERT INTO routes VALUES ('a:0:{}',359);
INSERT INTO routes VALUES ('a:3:{i:0;s:1:\"8\";i:1;s:1:\"9\";i:2;s:1:\"6\";}',327);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"74\";}',361);
INSERT INTO routes VALUES ('a:1:{i:0;s:2:\"22\";}',357);

--
-- Table structure for table 's_production'
--

DROP TABLE IF EXISTS s_production;
CREATE TABLE s_production (
  prod_id int(11) default NULL,
  planet_id int(11) default NULL,
  time tinyint(3) default NULL,
  count int(11) unsigned default NULL
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 's_production'
--


INSERT INTO s_production VALUES (37,315,7,1);
INSERT INTO s_production VALUES (18,315,10,1);
INSERT INTO s_production VALUES (62,260,7,2);
INSERT INTO s_production VALUES (12,108,13,3);
INSERT INTO s_production VALUES (18,315,8,1);
INSERT INTO s_production VALUES (12,300,13,1);
INSERT INTO s_production VALUES (35,315,8,4);

--
-- Table structure for table 'scanradius'
--

DROP TABLE IF EXISTS scanradius;
CREATE TABLE scanradius (
  prod_id int(11) default NULL,
  radius int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'scanradius'
--


INSERT INTO scanradius VALUES (10,250);
INSERT INTO scanradius VALUES (36,400);
INSERT INTO scanradius VALUES (57,600);
INSERT INTO scanradius VALUES (39,200);
INSERT INTO scanradius VALUES (3,100);
INSERT INTO scanradius VALUES (3,100);

--
-- Table structure for table 'shipoffers'
--

DROP TABLE IF EXISTS shipoffers;
CREATE TABLE shipoffers (
  count int(11) default NULL,
  uid int(11) NOT NULL default '0',
  prod_id int(11) default NULL,
  price int(11) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'shipoffers'
--



--
-- Table structure for table 'shipvalues'
--

DROP TABLE IF EXISTS shipvalues;
CREATE TABLE shipvalues (
  prod_id int(11) default NULL,
  initiative int(11) default NULL,
  agility int(11) default NULL,
  warpreload int(11) default NULL,
  hull int(11) default NULL,
  tonnage int(11) default NULL,
  weaponpower int(11) default NULL,
  shield int(11) default NULL,
  ecm int(11) default NULL,
  target1 char(1) default NULL,
  sensor int(11) default NULL,
  weaponskill int(11) default NULL,
  special char(1) default '',
  armor int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'shipvalues'
--


INSERT INTO shipvalues VALUES (2,80,80,2,10,4,5,0,0,'L',10,60,'',0);
INSERT INTO shipvalues VALUES (3,10,1,1,1,2,1,0,0,'L',50,1,'',0);
INSERT INTO shipvalues VALUES (6,75,75,3,50,8,10,5,0,'P',15,50,'',0);
INSERT INTO shipvalues VALUES (9,10,50,4,80,200,5,0,0,'L',20,30,'',0);
INSERT INTO shipvalues VALUES (12,10,20,10,200,1000,5,10,0,'L',20,10,'',0);
INSERT INTO shipvalues VALUES (14,70,65,4,75,30,100,60,0,'H',40,15,'B',0);
INSERT INTO shipvalues VALUES (16,50,45,6,80,50,60,8,0,'L',20,50,'E',0);
INSERT INTO shipvalues VALUES (18,20,60,12,200,500,100,30,0,'L',30,80,'',0);
INSERT INTO shipvalues VALUES (24,60,60,4,100,35,185,80,0,'H',60,10,'B',0);
INSERT INTO shipvalues VALUES (28,5,40,5,60,40,50,25,0,'M',10,50,'R',0);
INSERT INTO shipvalues VALUES (29,55,50,5,40,35,60,20,0,'L',30,40,'',0);
INSERT INTO shipvalues VALUES (35,40,45,8,80,100,15,0,0,'L',30,10,'S',0);
INSERT INTO shipvalues VALUES (39,40,35,6,70,120,15,44,0,'M',90,50,'S',0);
INSERT INTO shipvalues VALUES (37,30,40,9,160,1000,140,40,0,'M',40,50,'',0);
INSERT INTO shipvalues VALUES (45,45,55,7,30,60,70,15,0,'M',50,30,'',0);
INSERT INTO shipvalues VALUES (48,20,10,14,1000,25,800,50,0,'H',30,10,'',0);
INSERT INTO shipvalues VALUES (52,65,70,6,400,20,70,25,0,'L',10,80,'C',0);
INSERT INTO shipvalues VALUES (62,10,5,12,300,2000,5,10,0,'L',15,10,'',0);
INSERT INTO shipvalues VALUES (64,45,50,4,300,2000,20,10,0,'L',20,15,'',0);
INSERT INTO shipvalues VALUES (1,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (4,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (5,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (8,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (10,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (11,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (13,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (15,21,22,23,24,25,0,100,28,'L',29,20,'H',10);
INSERT INTO shipvalues VALUES (17,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (19,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (21,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (22,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (23,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (25,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (26,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (27,21,22,23,24,25,50,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (30,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (31,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (32,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (33,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (34,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (36,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (38,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (40,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (42,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (43,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (46,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (47,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (49,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (51,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (53,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (56,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (57,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (58,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (59,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (60,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (61,21,22,23,24,25,0,0,28,'L',29,20,'',10);
INSERT INTO shipvalues VALUES (63,21,22,23,24,25,0,0,28,'L',29,20,'',10);

--
-- Table structure for table 'skins'
--

DROP TABLE IF EXISTS skins;
CREATE TABLE skins (
  name varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

--
-- Dumping data for table 'skins'
--


INSERT INTO skins VALUES ('metal_blue',1);

--
-- Table structure for table 'systems'
--

DROP TABLE IF EXISTS systems;
CREATE TABLE systems (
  x int(11) NOT NULL default '0',
  y int(11) NOT NULL default '0',
  id int(11) NOT NULL auto_increment,
  type int(11) default NULL,
  cid int(11) default NULL,
  name varchar(255) default NULL,
  PRIMARY KEY  (id),
  KEY x (x),
  KEY y (y)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'systems'
--


INSERT INTO systems VALUES (1525,1776,1,4,1,'nu Mensae');
INSERT INTO systems VALUES (1968,1012,2,3,1,'omicron Mensae');
INSERT INTO systems VALUES (1431,1080,3,3,1,'rho Mensae');
INSERT INTO systems VALUES (1891,1279,4,2,1,'omega Mensae');
INSERT INTO systems VALUES (1442,1230,5,2,1,'delta Mensae');
INSERT INTO systems VALUES (1184,1742,6,3,1,'alpha Mensae');
INSERT INTO systems VALUES (1355,1983,7,3,1,'phi Mensae');
INSERT INTO systems VALUES (1710,1544,8,1,1,'zeta Mensae');
INSERT INTO systems VALUES (1461,1600,9,4,1,'upsilon Mensae');
INSERT INTO systems VALUES (1808,1466,10,4,1,'theta Mensae');
INSERT INTO systems VALUES (1019,1002,11,2,1,'eta Mensae');
INSERT INTO systems VALUES (1504,1046,12,4,1,'xi Mensae');
INSERT INTO systems VALUES (2291,1902,13,2,2,'pi Gruis');
INSERT INTO systems VALUES (2912,1886,14,2,2,'phi Gruis');
INSERT INTO systems VALUES (2157,1397,15,4,2,'kappa Gruis');
INSERT INTO systems VALUES (2265,1240,16,4,2,'iota Gruis');
INSERT INTO systems VALUES (2591,1460,17,1,2,'beta Gruis');
INSERT INTO systems VALUES (2601,1334,18,3,2,'tau Gruis');
INSERT INTO systems VALUES (2253,1063,19,3,2,'nu Gruis');
INSERT INTO systems VALUES (2653,1795,20,3,2,'rho Gruis');
INSERT INTO systems VALUES (2813,1963,21,4,2,'xi Gruis');
INSERT INTO systems VALUES (2423,1234,22,3,2,'eta Gruis');
INSERT INTO systems VALUES (2743,1582,23,4,2,'upsilon Gruis');
INSERT INTO systems VALUES (2184,1172,24,2,2,'epsilon Gruis');
INSERT INTO systems VALUES (2238,1203,25,4,2,'omega Gruis');
INSERT INTO systems VALUES (2866,1632,26,3,2,'gamma Gruis');
INSERT INTO systems VALUES (2202,1725,27,3,2,'theta Gruis');
INSERT INTO systems VALUES (2352,1954,28,2,2,'sigma Gruis');
INSERT INTO systems VALUES (2776,1798,29,2,2,'lambda Gruis');
INSERT INTO systems VALUES (2406,1728,30,4,2,'alpha Gruis');
INSERT INTO systems VALUES (2137,2886,31,1,3,'lambda Tucanae');
INSERT INTO systems VALUES (2906,2212,32,2,3,'phi Tucanae');
INSERT INTO systems VALUES (2619,2627,33,4,3,'pi Tucanae');
INSERT INTO systems VALUES (2095,2977,34,1,3,'tau Tucanae');
INSERT INTO systems VALUES (2702,2769,35,1,3,'gamma Tucanae');
INSERT INTO systems VALUES (2959,2632,36,2,3,'chi Tucanae');
INSERT INTO systems VALUES (2484,2738,37,2,3,'epsilon Tucanae');
INSERT INTO systems VALUES (2356,2038,38,4,3,'zeta Tucanae');
INSERT INTO systems VALUES (2322,2088,39,1,3,'nu Tucanae');
INSERT INTO systems VALUES (2160,2219,40,1,3,'rho Tucanae');
INSERT INTO systems VALUES (2844,2078,41,4,3,'theta Tucanae');
INSERT INTO systems VALUES (2138,2648,42,1,3,'kappa Tucanae');
INSERT INTO systems VALUES (2317,2292,43,3,3,'iota Tucanae');
INSERT INTO systems VALUES (2700,2950,44,2,3,'xi Tucanae');
INSERT INTO systems VALUES (2876,2307,45,1,3,'sigma Tucanae');
INSERT INTO systems VALUES (2303,2973,46,3,3,'omega Tucanae');
INSERT INTO systems VALUES (1043,2137,47,4,4,'mu Al Sagittari');
INSERT INTO systems VALUES (1274,2276,48,1,4,'omega Al Sagittari');
INSERT INTO systems VALUES (1647,2896,49,3,4,'psi Al Sagittari');
INSERT INTO systems VALUES (1373,2339,50,4,4,'beta Al Sagittari');
INSERT INTO systems VALUES (1693,2272,51,3,4,'alpha Al Sagittari');
INSERT INTO systems VALUES (1280,2933,52,2,4,'lambda Al Sagittari');
INSERT INTO systems VALUES (1087,2645,53,2,4,'tau Al Sagittari');
INSERT INTO systems VALUES (1574,2075,54,4,4,'nu Al Sagittari');
INSERT INTO systems VALUES (1140,2675,55,1,4,'upsilon Al Sagittari');
INSERT INTO systems VALUES (1576,2493,56,1,4,'xi Al Sagittari');
INSERT INTO systems VALUES (1762,2383,57,3,4,'zeta Al Sagittari');
INSERT INTO systems VALUES (1245,2272,58,2,4,'kappa Al Sagittari');
INSERT INTO systems VALUES (1650,2514,59,4,4,'gamma Al Sagittari');
INSERT INTO systems VALUES (1346,2235,60,4,4,'phi Al Sagittari');
INSERT INTO systems VALUES (1825,2771,61,3,4,'omicron Al Sagittari');
INSERT INTO systems VALUES (863,2528,62,2,5,'beta Canis Majoris');
INSERT INTO systems VALUES (651,2928,63,2,5,'upsilon Canis Majoris');
INSERT INTO systems VALUES (698,2589,64,2,5,'psi Canis Majoris');
INSERT INTO systems VALUES (3,2225,65,1,5,'nu Canis Majoris');
INSERT INTO systems VALUES (363,2309,66,1,5,'tau Canis Majoris');
INSERT INTO systems VALUES (865,2435,67,1,5,'sigma Canis Majoris');
INSERT INTO systems VALUES (998,2960,68,3,5,'omicron Canis Majoris');
INSERT INTO systems VALUES (348,2919,69,4,5,'omega Canis Majoris');
INSERT INTO systems VALUES (508,2328,70,1,5,'xi Canis Majoris');
INSERT INTO systems VALUES (98,2180,71,3,5,'gamma Canis Majoris');
INSERT INTO systems VALUES (302,2303,72,4,5,'zeta Canis Majoris');
INSERT INTO systems VALUES (138,1082,73,2,6,'gamma Carinae');
INSERT INTO systems VALUES (496,1908,74,3,6,'mu Carinae');
INSERT INTO systems VALUES (273,1281,75,3,6,'theta Carinae');
INSERT INTO systems VALUES (991,1388,76,3,6,'sigma Carinae');
INSERT INTO systems VALUES (335,1971,77,3,6,'pi Carinae');
INSERT INTO systems VALUES (833,1683,78,4,6,'upsilon Carinae');
INSERT INTO systems VALUES (871,1369,79,1,6,'psi Carinae');
INSERT INTO systems VALUES (653,1041,80,1,6,'delta Carinae');
INSERT INTO systems VALUES (416,1458,81,3,6,'lambda Carinae');
INSERT INTO systems VALUES (427,1339,82,1,6,'phi Carinae');
INSERT INTO systems VALUES (166,1102,83,4,6,'kappa Carinae');
INSERT INTO systems VALUES (202,497,84,4,7,'nu Rigel Centauri');
INSERT INTO systems VALUES (870,581,85,4,7,'pi Rigel Centauri');
INSERT INTO systems VALUES (395,42,86,3,7,'alpha Rigel Centauri');
INSERT INTO systems VALUES (616,981,87,4,7,'xi Rigel Centauri');
INSERT INTO systems VALUES (817,35,88,2,7,'mu Rigel Centauri');
INSERT INTO systems VALUES (9,941,89,2,7,'lambda Rigel Centauri');
INSERT INTO systems VALUES (264,335,90,2,7,'tau Rigel Centauri');
INSERT INTO systems VALUES (908,924,91,2,7,'upsilon Rigel Centauri');
INSERT INTO systems VALUES (33,679,92,3,7,'iota Rigel Centauri');
INSERT INTO systems VALUES (407,78,93,4,7,'gamma Rigel Centauri');
INSERT INTO systems VALUES (742,214,94,4,7,'eta Rigel Centauri');
INSERT INTO systems VALUES (565,233,95,2,7,'phi Rigel Centauri');
INSERT INTO systems VALUES (932,842,96,2,7,'sigma Rigel Centauri');
INSERT INTO systems VALUES (505,244,97,4,7,'rho Rigel Centauri');
INSERT INTO systems VALUES (194,863,98,4,7,'omega Rigel Centauri');
INSERT INTO systems VALUES (188,555,99,4,7,'zeta Rigel Centauri');
INSERT INTO systems VALUES (1516,555,100,4,8,'iota Al Gruis');
INSERT INTO systems VALUES (1110,4,101,2,8,'xi Al Gruis');
INSERT INTO systems VALUES (1452,641,102,4,8,'nu Al Gruis');
INSERT INTO systems VALUES (1708,952,103,4,8,'lambda Al Gruis');
INSERT INTO systems VALUES (1035,681,104,1,8,'omega Al Gruis');
INSERT INTO systems VALUES (1467,212,105,2,8,'psi Al Gruis');
INSERT INTO systems VALUES (1712,404,106,3,8,'alpha Al Gruis');
INSERT INTO systems VALUES (1170,588,107,1,8,'mu Al Gruis');
INSERT INTO systems VALUES (1158,286,108,3,8,'delta Al Gruis');
INSERT INTO systems VALUES (1923,342,109,2,8,'chi Al Gruis');
INSERT INTO systems VALUES (2484,346,110,2,9,'nu Lyrae');
INSERT INTO systems VALUES (2201,540,111,2,9,'alpha Lyrae');
INSERT INTO systems VALUES (2213,322,112,2,9,'iota Lyrae');
INSERT INTO systems VALUES (2659,208,113,3,9,'gamma Lyrae');
INSERT INTO systems VALUES (2144,523,114,1,9,'kappa Lyrae');
INSERT INTO systems VALUES (2144,208,115,1,9,'epsilon Lyrae');
INSERT INTO systems VALUES (2815,671,116,4,9,'chi Lyrae');
INSERT INTO systems VALUES (2535,549,117,4,9,'theta Lyrae');
INSERT INTO systems VALUES (2199,517,118,2,9,'xi Lyrae');
INSERT INTO systems VALUES (2862,811,119,4,9,'phi Lyrae');
INSERT INTO systems VALUES (2066,851,120,2,9,'upsilon Lyrae');
INSERT INTO systems VALUES (2298,361,121,1,9,'omicron Lyrae');

--
-- Table structure for table 'taxes'
--

DROP TABLE IF EXISTS taxes;
CREATE TABLE taxes (
  aid int(11) NOT NULL default '0',
  taxmetal int(2) NOT NULL default '0',
  taxenergy int(2) NOT NULL default '0',
  taxleader int(2) NOT NULL default '40',
  taxmilitary int(2) NOT NULL default '20',
  taxdevelopement int(2) NOT NULL default '20',
  taxforeign int(2) NOT NULL default '20',
  taxmopgas int(2) NOT NULL default '0',
  taxerkunum int(2) NOT NULL default '0',
  taxgortium int(2) NOT NULL default '0',
  taxsusebloom int(2) NOT NULL default '0',
  incomemetal int(11) NOT NULL default '0',
  incomeenergy int(11) NOT NULL default '0',
  incomemopgas int(11) NOT NULL default '0',
  incomeerkunum int(11) NOT NULL default '0',
  incomegortium int(11) NOT NULL default '0',
  incomesusebloom int(11) NOT NULL default '0'
) TYPE=MyISAM;

--
-- Dumping data for table 'taxes'
--


INSERT INTO taxes VALUES (1,2,2,40,20,20,20,2,2,2,2,171,200,16,17,18,2);
INSERT INTO taxes VALUES (2,10,7,31,23,23,23,5,5,5,5,770,616,43,32,71,11);

--
-- Table structure for table 'tech'
--

DROP TABLE IF EXISTS tech;
CREATE TABLE tech (
  name varchar(255) default NULL,
  depend int(11) default NULL,
  excl int(11) default NULL,
  t_id int(11) NOT NULL auto_increment,
  description blob,
  com_time int(11) default NULL,
  flag char(1) default 'N',
  PRIMARY KEY  (t_id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'tech'
--


INSERT INTO tech VALUES ('Theory of Space Exploration',NULL,NULL,1,'Covers the basic technologies of Exploration',3,'T');
INSERT INTO tech VALUES ('Instellar Jump Drive',1,NULL,2,'Allows jumping between the stars',3,'N');
INSERT INTO tech VALUES ('Nuclear provided power cells',1,NULL,3,'Energy compression',3,'N');
INSERT INTO tech VALUES ('Laser Wave Switch',1,NULL,4,'Designed for defending against Asteroids. Very Basic Laser weapon',3,'N');
INSERT INTO tech VALUES ('Theory of Space Expansion',1,NULL,5,'Space doesn\'t just give us the right to use its ressources but also offers unlimited room for our citizens',4,'T');
INSERT INTO tech VALUES ('Modular Cargo System',5,NULL,6,'Features a new generation of Cargo modules. Quickly exchangeable. This enables you to profit from trade and transport Infantery.',4,'N');
INSERT INTO tech VALUES ('Docking absorption Unit',5,NULL,7,'Eases the process of Docking.',4,'N');
INSERT INTO tech VALUES ('Integrated Living',5,NULL,8,'Combines the needs of humans in one building.',4,'N');
INSERT INTO tech VALUES ('Theory of Space War',5,NULL,9,'We are helpless against Space aggression. New needs cover new possibilities.',5,'T');
INSERT INTO tech VALUES ('Orbital Bombing Procedure',9,NULL,10,'Our enemies will never know what hit them.',5,'N');
INSERT INTO tech VALUES ('Applied Electromagnetic Pulse',9,NULL,11,'Features a powerful EMP attack on enemy ships.',5,'N');
INSERT INTO tech VALUES ('Advanced Space Travelling',9,NULL,12,'Nobody wins a war or even a batlle with big weapons. History has shown that the one thats faster has a very big advantage.',5,'N');
INSERT INTO tech VALUES ('Theory of Life',9,NULL,13,'If we know what life is we can manipulate the world to our needs. Fascinating imagination, isn\'t it?',8,'T');
INSERT INTO tech VALUES ('Genetic Engineering',13,NULL,14,'An improved genetic structure will improve the human Performance.',8,'N');
INSERT INTO tech VALUES ('Cloning',13,NULL,15,'This will give the term \'masses\' a new meaning. Unlimited human ressources.',8,'N');
INSERT INTO tech VALUES ('Improved Farming',13,NULL,16,'Why do we try to adapt to the plants. The plants have to adapt to us!',8,'N');
INSERT INTO tech VALUES ('Theory of Advanced Energy sources',13,NULL,17,'It\'s time for a new energy. Let\'s see what the world can give us.',11,'T');
INSERT INTO tech VALUES ('Cold Fusion provided Energycells',17,NULL,18,'Highly compressed Energy allows new ships.',11,'N');
INSERT INTO tech VALUES ('Warpengine',17,NULL,19,'The faster we are the better we are',11,'N');
INSERT INTO tech VALUES ('Theory of Nanotechnology',17,NULL,20,'We always get bigger and bigger. Why not go into detail?',16,'T');
INSERT INTO tech VALUES ('Nano scanner',20,NULL,21,'Can you see nanobots? No. But they can see you!',16,'N');
INSERT INTO tech VALUES ('Nanobot container',20,NULL,22,'One Nanobot could destroy hundreds of cells. But how many would billions of these destory? Nested in one Container they are a powerful weapon',16,'N');
INSERT INTO tech VALUES ('Terraforming',20,NULL,23,'What about Nanobots changing our enviroment? Useful? I guess so.',16,'N');
INSERT INTO tech VALUES ('Theory of Particel acceleration',20,NULL,24,'The traditional weapons are outdated. This will give us the power to build devastating weapons.',21,'T');
INSERT INTO tech VALUES ('Plasma Heater',24,NULL,25,'Plasma weapons feature a very devastating impact. They are very slow though. So it\'s the ideal weapon for large and slow ships.',21,'N');
INSERT INTO tech VALUES ('Hullbreaker Gate Device',24,NULL,26,'The \'Antitank grenade launcher\' for space combat. Hit\'s the ship and developes its power inside the ship.',21,'N');
INSERT INTO tech VALUES ('Ionization Module',24,NULL,27,'Activates a Sphere around its victim which makes the enemy unmoveable for a while.',21,'N');
INSERT INTO tech VALUES ('Theory of Human Mind',24,NULL,28,'Be a step beyond your enemies. Know what they think and plan your further steps. Furthermore it enables you to improve your colonies and make them more efficient.',28,'T');
INSERT INTO tech VALUES ('Efficient Working',28,NULL,29,'Think like your workers and make their production enviroment more motivating because motivated workers work harder and better.',28,'N');
INSERT INTO tech VALUES ('Neural Sensors',28,NULL,30,'Go through the streets and know what people think.',28,'N');
INSERT INTO tech VALUES ('Persuation Rays',28,NULL,31,'People don\'t like you? People don\'t follow you? Arguing would be too exhausting so why not persuade them by pressing a button?.',28,'N');
INSERT INTO tech VALUES ('Shock Dispenser',28,NULL,32,'Acts as the counterpart to the biological shock resulting from a jump. Decreases jumptimes.',28,'N');
INSERT INTO tech VALUES ('Theory of Galactic Ressources',28,NULL,33,'Space is more than metal and energy. Research the facilities of the Interstellar Ressources.',35,'T');
INSERT INTO tech VALUES ('Secrets of Mopgas',33,NULL,34,'Highly energetic.',35,'N');
INSERT INTO tech VALUES ('Secrets of Gortium',33,NULL,35,'Gortium. The ressource of the ancient planets.',35,'N');
INSERT INTO tech VALUES ('Secrets of Erkunum',33,NULL,36,'The supraconducting ressource.',35,'N');
INSERT INTO tech VALUES ('Secrets of Susebloom',33,NULL,37,'The most interesting ressource in Space but VERY rare. It\'s use cover drugs, medicaments etc.',35,'N');
INSERT INTO tech VALUES ('Theory of Space Surveillance',33,NULL,38,'The one who knows what is going on is always a step further. Control through knowledge!',44,'T');
INSERT INTO tech VALUES ('Mobile Emission Detector',38,NULL,39,'Very sensible ship detectors.',44,'N');
INSERT INTO tech VALUES ('Deep Scanning',38,NULL,40,'This technology reveals almost every movement in space.',44,'N');
INSERT INTO tech VALUES ('Long Range Jamming',38,NULL,41,'Hides you from enemy detection. If you can\'t be seen you can\'t be hit.',44,'N');
INSERT INTO tech VALUES ('Theory of Synthetic Devices',38,NULL,42,'Manpower is too weak and not reliable. Androids are smarter, faster and stronger. Furthermore you could replace human organs through synthetic.',53,'T');
INSERT INTO tech VALUES ('Cyberbiological Engineering',42,NULL,43,'Sex, 9 Months of waiting and lots of years of development. Build your fully equipped Android in one hour.',53,'N');
INSERT INTO tech VALUES ('Symbiotic Shipsystems',42,NULL,44,'Computers can do maths. But do they really think? No. Sysmbiotic Shipsystems combine the tactical understanding of your captains with your systems and enable you to crush your enemies faster than they can react.',53,'N');
INSERT INTO tech VALUES ('Virtual Entertainment',42,NULL,45,'Moral and motivation will never be a problem. This new generation of virtual entertainment connects to the human mind and displays what the user wants to see.',53,'N');
INSERT INTO tech VALUES ('Theory of Artificial Intelligence',42,NULL,46,'The biological brain wastes most of its performance in doing nothing. Todays computers must be feed with human creativity and their failures! Thats a matter we can not tolerate! The only solution are devices controlled by an artificial intelligence.',64,'T');
INSERT INTO tech VALUES ('AI Insects',46,NULL,47,'That enemy Admiral will never know that the fly in his soup knows him better than heself does.',64,'N');
INSERT INTO tech VALUES ('Battleprocedure Algorithm',46,NULL,48,'Being able to construct autonom warships will not just make you more popular, you\'ll safe a lot expensive human resources, too!',64,'N');
INSERT INTO tech VALUES ('Multiple Synchron Targeting System',46,NULL,49,'The idea is: Target dozends of enemy ships that none of your guns will never idle nor loose target at a time. From now our guns will always know where the enemy was, is and will be!',64,'N');
INSERT INTO tech VALUES ('Rapid Laser Wave Switch',46,NULL,50,'Good old Laser Switch, your honor will be restored when their battleships will be cut up in thousends of pieces in a row!',64,'N');
INSERT INTO tech VALUES ('Theory of total material processing',46,NULL,51,'These rare and very special galatic resources are still holding some of their secrets. I say NO MORE!',75,'T');
INSERT INTO tech VALUES ('Gortium radiation insulation',51,NULL,52,'kommt noch',75,'N');
INSERT INTO tech VALUES ('Erkunum Condesation',51,NULL,53,'Its last secret! Its strange behaviour in gaseous condition is solved!Gaining Erkunum will now be cheaper, easyer and faster!',75,'N');
INSERT INTO tech VALUES ('Mopgas Binding',51,NULL,54,'Toxic planets hold more mopgas than we thought! We never believed that the hypercomplex and ultracritic mopgas molecule could be binded!',75,'N');
INSERT INTO tech VALUES ('Artificial Susebloom planting',51,NULL,55,'Sadly Susebloom will  only grow on Eden Planets, but these complex planting machines will know be able to find, harvest and care for the flower more efficient.',75,'N');
INSERT INTO tech VALUES ('Theory of Human Hardening',51,NULL,56,'The gift of the galactic resources makes it possible  that on human can easly match a Wardroid in close combat.',88,'T');
INSERT INTO tech VALUES ('Susebloom packs',56,NULL,57,'A soldier cought in a battle will encounter terror and pain. Susebloom packs will reduce those experiences to a minimum,  give the soldier independence from sleep and food for days.',88,'N');
INSERT INTO tech VALUES ('Advanced Pharmaceutics',56,NULL,58,'Today there is no desease that can\'t be cured, no wound that can\'t be healed. The only question is: can you pay?',88,'N');
INSERT INTO tech VALUES ('Theory of Advanced Space Warfare',56,NULL,59,'What were those toys our men played with? Plasma rifles? Fusion bombs? pah! Lets get rid of those childish stuff and have a look at these freaking weapons!',101,'T');
INSERT INTO tech VALUES ('Plasma Cluster',59,NULL,60,'Seen Hell? No? At least you can unleash hell!',101,'N');
INSERT INTO tech VALUES ('Ionization Cluster Module',59,NULL,61,'A one billion tons ship crushed like a peanut? Well I\'d say, release just for a second a tiny wormhole in its very heart. The Implusionimpact is one of the most beautyfull wonders in the known galaxy.',101,'N');
INSERT INTO tech VALUES ('Chaos Engines',59,NULL,62,'Coordinating the ways of chaos is quite difficult. Describing either. But the breath you just took could have launched the hurrican on the ocean.',101,'N');
INSERT INTO tech VALUES ('Theory of Material Alteration',59,NULL,63,'What is it? Is not a organism, not a machine nor a nanobot but behaves like those?',116,'T');
INSERT INTO tech VALUES ('Chameleon Fibres',63,NULL,64,'You wouldn\'t see your assassin even when you\'d hit him with your nose.',116,'N');
INSERT INTO tech VALUES ('Polyurethane Pilot Suit',63,NULL,65,'A Pilot, made of flesh or steel wouldn\'t survive a acceleration from zero to lightspeed in less than a blink. Now they will!',116,'N');
INSERT INTO tech VALUES ('The Autonom City',63,NULL,66,'And then I said: \"I\'d like to have a swimmingpool!\" After a few seconds I had a swimmingpool in my backyard! Fascinating, isn\'t it?',116,'N');
INSERT INTO tech VALUES ('Theory of Enemy Domination',63,NULL,67,'If you want to feel like armageddon, we can make you feel so. I promise!',134,'T');
INSERT INTO tech VALUES ('Graviation Field Generator',67,NULL,68,'Who said that artificial moon can not move? Who said that? Jesus, wheres that moon now?',134,'N');
INSERT INTO tech VALUES ('Antimatter provided Energycells',67,NULL,69,'Ultraeffective compressed Energy! You won\'t find such power in a small black hole!',134,'N');
INSERT INTO tech VALUES ('Giant Mass Controler',67,NULL,70,'Ravaging a planet is NOT nice!',134,'N');
INSERT INTO tech VALUES ('Applied Gravitionik',67,NULL,71,'Brought the gravtionik to miniature! Living will be so much easier than it is today!',134,'N');
INSERT INTO tech VALUES ('Theory of Light Diversion',67,NULL,72,'Light! Another thing that\'d support us greatly I guess.',151,'T');
INSERT INTO tech VALUES ('Optical Cloaking Device',72,NULL,73,'That device mount on a big big ship will hide your fleets from enemy eyes!',151,'N');
INSERT INTO tech VALUES ('Cloaking',72,NULL,74,'Being the invisble man, your soldiers will experience the feeling of being not there! Well at least of a couple of hours.',151,'N');

--
-- Table structure for table 'ticker'
--

DROP TABLE IF EXISTS ticker;
CREATE TABLE ticker (
  uid int(11) default NULL,
  tid int(11) NOT NULL auto_increment,
  type char(1) default NULL,
  text varchar(255) default NULL,
  time timestamp(14) NOT NULL,
  PRIMARY KEY  (tid)
) TYPE=MyISAM;

--
-- Dumping data for table 'ticker'
--


INSERT INTO ticker VALUES (8,547,'w','*lplmapgen.php?id=104*Fleet Unnamed fleet: arrived at planet Unnamed / Al Gruis.',20030306200001);
INSERT INTO ticker VALUES (8,847,'w','*lproduction.php?pid=337*You have colonised a new planet',20030310210002);
INSERT INTO ticker VALUES (8,784,'w','morgoth has joined your alliance',20030309195913);
INSERT INTO ticker VALUES (8,2584,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Instant Plasma Facility constructed.',20030330100001);
INSERT INTO ticker VALUES (8,903,'w','Your leader dismissed the Minister of Developement',20030311172219);
INSERT INTO ticker VALUES (8,970,'w','*lproduction.php?pid=416*Backblech: 1 Colony ship(s) produced.',20030311230001);
INSERT INTO ticker VALUES (8,2253,'r','*lresearch.php*Your research has been finished!',20030326140005);
INSERT INTO ticker VALUES (1,1547,'w','*lproduction.php?pid=30*EINS: 11 Colony ship(s) produced.',20030318200002);
INSERT INTO ticker VALUES (8,1353,'w','*lproduction.php?pid=344*You have colonised a new planet',20030316140003);
INSERT INTO ticker VALUES (8,571,'r','*lresearch.php*Your research has been finished!',20030306230801);
INSERT INTO ticker VALUES (5,3528,'s','Your spies intercepted some enemy spies!',20030408090007);
INSERT INTO ticker VALUES (9,3651,'w','*lproduction.php?act=build&pid=450*Magnopolis VI: Defence Masquerader constructed.',20030409020001);
INSERT INTO ticker VALUES (8,1054,'r','*lresearch.php*Your research has been finished!',20030313050002);
INSERT INTO ticker VALUES (8,913,'w','Your leader dismissed the Foreign Minister',20030311172232);
INSERT INTO ticker VALUES (1,1647,'s','Your spies intercepted some enemy spies. Their leader is Runelord (Delecious Cows)!',20030319180004);
INSERT INTO ticker VALUES (3,910,'w','Your leader dismissed the Foreign Minister',20030311172232);
INSERT INTO ticker VALUES (8,1347,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet xi Rigel Centauri I',20030316140001);
INSERT INTO ticker VALUES (8,908,'w','Your leader appointed mop as your new Minister of Developement',20030311172224);
INSERT INTO ticker VALUES (8,2835,'w','*lproduction.php?act=build&pid=332*Fettbrand: Agriculture Command Center constructed.',20030402060001);
INSERT INTO ticker VALUES (8,1446,'w','*lproduction.php?pid=332*You have colonised a new planet',20030317200004);
INSERT INTO ticker VALUES (1,1437,'w','*lproduction.php?pid=400*You have colonised a new planet',20030317180003);
INSERT INTO ticker VALUES (1,1438,'w','*lproduction.php?pid=397*You have colonised a new planet',20030317180003);
INSERT INTO ticker VALUES (3,1327,'w','*lproduction.php?pid=170*Core: 75 Scout(s) produced.',20030316110001);
INSERT INTO ticker VALUES (1,1871,'w','*lproduction.php?act=build&pid=115*NEUNZEHN: Nuclear Power Plant constructed.',20030322200001);
INSERT INTO ticker VALUES (5,3014,'w','*lproduction.php?pid=208*You have colonised a new planet',20030403210008);
INSERT INTO ticker VALUES (5,3015,'w','*lproduction.php?pid=290*You have colonised a new planet',20030403210008);
INSERT INTO ticker VALUES (4,3639,'w','*lproduction.php?act=build&pid=133*G Tucanae O1: Defence Masquerader constructed.',20030409010001);
INSERT INTO ticker VALUES (2,3690,'w','*lproduction.php?act=build&pid=92*Ice Planet V2: Barracks constructed.',20030409080001);
INSERT INTO ticker VALUES (3,1538,'s','Your spies intercepted some enemy spies!',20030318180004);
INSERT INTO ticker VALUES (8,928,'w','Your Minister of Developement has increased the tax on energy by 2 points to 2%',20030311172353);
INSERT INTO ticker VALUES (3,905,'w','Your leader appointed mop as your new Minister of Developement',20030311172224);
INSERT INTO ticker VALUES (3,777,'w','Runelord wants to add you to her/his buddylist',20030309191416);
INSERT INTO ticker VALUES (8,1012,'w','*lproduction.php?act=build&pid=337*Backpapier: Nuclear Power Plant constructed.',20030312170002);
INSERT INTO ticker VALUES (1,1449,'w','*lproduction.php?act=build&pid=400*ACHTZEHN: Metal Mine constructed.',20030317210001);
INSERT INTO ticker VALUES (8,1646,'w','*lproduction.php?act=build&pid=337*Backpapier: Mining Complex constructed.',20030319180001);
INSERT INTO ticker VALUES (1,1422,'w','*lproduction.php?act=build&pid=55*FÜNFZEHN: Fusion Power Plant constructed.',20030317120002);
INSERT INTO ticker VALUES (8,2612,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Nuclear Power Plant constructed.',20030330200002);
INSERT INTO ticker VALUES (3,1338,'w','*lproduction.php?act=build&pid=170*Core: Nuclear Power Plant constructed.',20030316130001);
INSERT INTO ticker VALUES (3,1336,'r','*lresearch.php*Your research has been finished!',20030316120003);
INSERT INTO ticker VALUES (8,584,'w','Hi! Erstmal DANKE :)  für die bisher gefunden Bugs. Wenn ihr nen Bug angebt, dann wäre es hilfreich wenn ihr pro bug (es sei denn die hängen zusammen) jeweils einen Eintrag einbaut.   Rune',20030307014511);
INSERT INTO ticker VALUES (8,662,'w','*lproduction.php?act=build&pid=416*Backblech: Nuclear Power Plant constructed.',20030308010001);
INSERT INTO ticker VALUES (8,976,'w','*lproduction.php?act=build&pid=415*Ventilator: Gen Factory constructed.',20030312050002);
INSERT INTO ticker VALUES (1,3363,'w','*lproduction.php?pid=30*EINS: 500 N-2103 Bomber(s) produced.',20030406190001);
INSERT INTO ticker VALUES (3,975,'r','*lresearch.php*Your research has been finished!',20030312030002);
INSERT INTO ticker VALUES (8,918,'w','Your leader appointed morgoth as your new Foreign Minister',20030311172242);
INSERT INTO ticker VALUES (8,520,'w','*lproduction.php?pid=415*Ventilator: 1 Colony ship(s) produced.',20030306130001);
INSERT INTO ticker VALUES (3,966,'w','*lproduction.php?pid=170*Core: 10 Scout(s) produced.',20030311220001);
INSERT INTO ticker VALUES (3,965,'w','*lproduction.php?act=build&pid=170*Core: Barracks constructed.',20030311220001);
INSERT INTO ticker VALUES (8,877,'m','*lmail.php*You have recieved a message from mop',20030311081034);
INSERT INTO ticker VALUES (1,1456,'w','*lproduction.php?act=build&pid=397*SIEBZEHN: Nuclear Power Plant constructed.',20030318000001);
INSERT INTO ticker VALUES (1,3407,'w','*lproduction.php?pid=30*EINS: 10 Carrier(s) produced.',20030407040001);
INSERT INTO ticker VALUES (1,3362,'w','*lproduction.php?pid=30*EINS: 1000 Interceptor(s) produced.',20030406190001);
INSERT INTO ticker VALUES (8,551,'w','*lproduction.php?pid=416*You have colonised a new planet',20030306200002);
INSERT INTO ticker VALUES (1,1546,'w','*lproduction.php?act=build&pid=366*DREIZEHN: Fusion Power Plant constructed.',20030318200002);
INSERT INTO ticker VALUES (8,393,'r','*lresearch.php*Your research has been finished!',20030305120001);
INSERT INTO ticker VALUES (3,925,'w','Your Minister of Developement has increased the tax on energy by 2 points to 2%',20030311172353);
INSERT INTO ticker VALUES (8,357,'r','*lresearch.php*Your research has been finished!',20030305010001);
INSERT INTO ticker VALUES (9,3671,'s','Your spies intercepted some enemy spies!',20030409050007);
INSERT INTO ticker VALUES (8,997,'w','*lproduction.php?act=build&pid=337*Backpapier: Barracks constructed.',20030312130001);
INSERT INTO ticker VALUES (1,1384,'w','*lproduction.php?pid=230*You have colonised a new planet',20030316210003);
INSERT INTO ticker VALUES (8,695,'w','Alliance  changed status to Enemy',20030308152417);
INSERT INTO ticker VALUES (8,2527,'w','*lproduction.php?act=build&pid=332*Fettbrand: Metal Mine constructed.',20030329120001);
INSERT INTO ticker VALUES (1,3451,'w','*lproduction.php?pid=30*EINS: 20 Colony ship(s) produced.',20030407160001);
INSERT INTO ticker VALUES (8,559,'w','Your leader appointed toXic as your new Minister of Developement',20030306213102);
INSERT INTO ticker VALUES (8,2320,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Barracks constructed.',20030327060001);
INSERT INTO ticker VALUES (8,1440,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet pi Rigel Centauri I',20030317200002);
INSERT INTO ticker VALUES (3,866,'w','*lproduction.php?act=build&pid=170*Core: Starport constructed.',20030311020001);
INSERT INTO ticker VALUES (4,3669,'w','*lproduction.php?act=build&pid=133*G Tucanae O1: Nuclear Power Plant constructed.',20030409050001);
INSERT INTO ticker VALUES (8,387,'w','toXic has joined your alliance',20030305105138);
INSERT INTO ticker VALUES (3,920,'w','Your Minister of Developement has increased the tax on metal by 2 points to 2%',20030311172344);
INSERT INTO ticker VALUES (8,692,'r','*lresearch.php*Your research has been finished!',20030308150726);
INSERT INTO ticker VALUES (8,979,'w','*lproduction.php?act=build&pid=416*Backblech: Gen Factory constructed.',20030312070001);
INSERT INTO ticker VALUES (8,923,'w','Your Minister of Developement has increased the tax on metal by 2 points to 2%',20030311172344);
INSERT INTO ticker VALUES (8,493,'r','*lresearch.php*Your research has been finished!',20030306030001);
INSERT INTO ticker VALUES (8,990,'w','*lproduction.php?act=build&pid=337*Backpapier: Laser Weapons Factory constructed.',20030312110002);
INSERT INTO ticker VALUES (8,2522,'w','*lproduction.php?act=build&pid=332*Fettbrand: Barracks constructed.',20030329110001);
INSERT INTO ticker VALUES (8,491,'w','*lproduction.php?act=build&pid=415*Ventilator: Laser Weapons Factory constructed.',20030306030001);
INSERT INTO ticker VALUES (2,3589,'s','The Colony on planet Oldie II 1 was destroyed misteriously!',20030408190008);
INSERT INTO ticker VALUES (3,915,'w','Your leader appointed morgoth as your new Foreign Minister',20030311172242);
INSERT INTO ticker VALUES (8,617,'w','*lproduction.php?act=build&pid=416*Backblech: Metal Mine constructed.',20030307150001);
INSERT INTO ticker VALUES (8,2507,'w','*lfleet.php* An enemy fleet is closing in to system of planet Dampfnudel!',20030329050006);
INSERT INTO ticker VALUES (8,826,'w','*lproduction.php?pid=415*Ventilator: 1 Colony ship(s) produced.',20030310080002);
INSERT INTO ticker VALUES (9,3666,'w','*lproduction.php?act=build&pid=117*Magnopolis XXIII: Gen Factory constructed.',20030409040002);
INSERT INTO ticker VALUES (2,3571,'w','*lproduction.php?act=build&pid=96*Oldie V I: Fusion Power Plant constructed.',20030408170001);
INSERT INTO ticker VALUES (2,3620,'w','*lfleet.php*Fleet 3: arrived at planet omega Gruis III',20030408230001);
INSERT INTO ticker VALUES (8,442,'r','*lresearch.php*Your research has been finished!',20030305160001);
INSERT INTO ticker VALUES (1,1385,'w','*lproduction.php?act=build&pid=53*ACHT: Barracks constructed.',20030316220001);
INSERT INTO ticker VALUES (1,1514,'w','*lproduction.php?act=build&pid=220*ZEHN: Mopgas Extraction Platform in orbit constructed.',20030318140001);
INSERT INTO ticker VALUES (8,666,'w','*lproduction.php?act=build&pid=415*Ventilator: Arcology constructed.',20030308020002);
INSERT INTO ticker VALUES (8,471,'r','*lresearch.php*Your research has been finished!',20030305220001);
INSERT INTO ticker VALUES (3,2283,'s','Your spies intercepted some enemy spies!',20030326200005);
INSERT INTO ticker VALUES (2,3675,'s','Your spies intercepted some enemy spies. Their leader is Kai Allard Liao (Draconis Combine)!',20030409050008);
INSERT INTO ticker VALUES (6,3317,'r','*lresearch.php*Your research has been finished!',20030406120006);
INSERT INTO ticker VALUES (3,778,'w','*lcommunication.php?act=show_alliance*You have been invited to join alliance :Hund',20030309192218);
INSERT INTO ticker VALUES (8,707,'w','Mitglieder von Hund dürften gerade ne message \"Alliance  changed status to Enemy\" gekriegt haben, den bug das der Name nicht angezeigt wurde ignorieren, ist schon gefixt',20030308152930);
INSERT INTO ticker VALUES (8,1035,'w','*lproduction.php?pid=419*You have colonised a new planet',20030312220002);
INSERT INTO ticker VALUES (3,799,'r','*lresearch.php*Your research has been finished!',20030309220002);
INSERT INTO ticker VALUES (8,774,'w','*lproduction.php?act=build&pid=416*Backblech: Starport constructed.',20030309190001);
INSERT INTO ticker VALUES (8,1545,'w','*lproduction.php?act=build&pid=419*Wursthaut: Barracks constructed.',20030318200002);
INSERT INTO ticker VALUES (3,780,'w','*lcommunication.php?act=show_alliance*You have been invited to join alliance :Out Of Order',20030309192604);
INSERT INTO ticker VALUES (8,1470,'r','*lresearch.php*Your research has been finished!',20030318030003);
INSERT INTO ticker VALUES (8,844,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet pi Rigel Centauri VI',20030310210001);
INSERT INTO ticker VALUES (3,900,'w','Your leader dismissed the Minister of Developement',20030311172219);
INSERT INTO ticker VALUES (8,1030,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet omega Al Gruis V',20030312220001);
INSERT INTO ticker VALUES (8,766,'r','*lresearch.php*Your research has been finished!',20030309160001);
INSERT INTO ticker VALUES (3,864,'r','*lresearch.php*Your research has been finished!',20030311010001);
INSERT INTO ticker VALUES (3,779,'w','mop wants to add you to her/his buddylist',20030309192224);
INSERT INTO ticker VALUES (1,1406,'s','The Fusion Power Plant on planet DREIZEHN was destroyed misteriously!',20030317050003);
INSERT INTO ticker VALUES (1,1436,'w','*lproduction.php?act=build&pid=331*ZWÖLF: Mining Complex constructed.',20030317180001);
INSERT INTO ticker VALUES (8,952,'w','*lproduction.php?act=build&pid=416*Backblech: Barracks constructed.',20030311190002);
INSERT INTO ticker VALUES (8,761,'w','*lproduction.php?act=build&pid=416*Backblech: Laser Weapons Factory constructed.',20030309132112);
INSERT INTO ticker VALUES (8,1563,'w','*lproduction.php?act=build&pid=332*Fettbrand: Nuclear Power Plant constructed.',20030318220001);
INSERT INTO ticker VALUES (8,1643,'w','*lproduction.php?act=build&pid=416*Backblech: Fusion Power Plant constructed.',20030319180001);
INSERT INTO ticker VALUES (3,930,'w','Your Minister of Developement has increased the tax on mopgas by 2 points to 2%',20030311172359);
INSERT INTO ticker VALUES (8,1028,'w','*lproduction.php?act=build&pid=337*Backpapier: Starport constructed.',20030312210001);
INSERT INTO ticker VALUES (8,933,'w','Your Minister of Developement has increased the tax on mopgas by 2 points to 2%',20030311172359);
INSERT INTO ticker VALUES (3,935,'w','Your Minister of Developement has increased the tax on erkunum by 2 points to 2%',20030311172407);
INSERT INTO ticker VALUES (8,978,'w','*lproduction.php?act=build&pid=337*Backpapier: Gen Factory constructed.',20030312060002);
INSERT INTO ticker VALUES (8,938,'w','Your Minister of Developement has increased the tax on erkunum by 2 points to 2%',20030311172407);
INSERT INTO ticker VALUES (3,940,'w','Your Minister of Developement has increased the tax on gortium by 2 points to 2%',20030311172415);
INSERT INTO ticker VALUES (8,943,'w','Your Minister of Developement has increased the tax on gortium by 2 points to 2%',20030311172415);
INSERT INTO ticker VALUES (8,949,'w','*lproduction.php?act=build&pid=337*Backpapier: Metal Mine constructed.',20030311180001);
INSERT INTO ticker VALUES (3,945,'w','Your Minister of Developement has increased the tax on susebloom by 2 points to 2%',20030311172419);
INSERT INTO ticker VALUES (7,3701,'w','*lproduction.php?pid=315*Shanghai: 40 Stonewall Tank(s) produced.',20030409100002);
INSERT INTO ticker VALUES (2,3689,'w','*lproduction.php?act=build&pid=63*marsupilami 1: Laser Weapons Factory II constructed.',20030409080001);
INSERT INTO ticker VALUES (8,948,'w','Your Minister of Developement has increased the tax on susebloom by 2 points to 2%',20030311172419);
INSERT INTO ticker VALUES (8,1166,'s','Your spies intercepted some enemy spies!',20030314180002);
INSERT INTO ticker VALUES (1,1397,'w','*lproduction.php?act=build&pid=53*ACHT: Starport constructed.',20030317020002);
INSERT INTO ticker VALUES (1,1435,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet omega Rigel Centauri IV',20030317180001);
INSERT INTO ticker VALUES (1,1377,'w','*lproduction.php?act=build&pid=53*ACHT: Fusion Power Plant constructed.',20030316200001);
INSERT INTO ticker VALUES (8,2200,'w','*lproduction.php?act=build&pid=337*Backpapier: Arcology constructed.',20030326060002);
INSERT INTO ticker VALUES (8,1277,'r','*lresearch.php*Your research has been finished!',20030315210003);
INSERT INTO ticker VALUES (1,1393,'w','*lproduction.php?act=build&pid=56*NEUN: Fusion Power Plant constructed.',20030317000001);
INSERT INTO ticker VALUES (8,2198,'w','*lproduction.php?act=build&pid=337*Backpapier: Spacestation in orbit constructed.',20030326060002);
INSERT INTO ticker VALUES (8,2197,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Spacestation in orbit constructed.',20030326060002);
INSERT INTO ticker VALUES (1,1390,'r','*lresearch.php*Your research has been finished!',20030316230003);
INSERT INTO ticker VALUES (1,1375,'w','*lproduction.php?act=build&pid=116*ELF: Fusion Power Plant constructed.',20030316200001);
INSERT INTO ticker VALUES (8,2347,'w','*lproduction.php?act=build&pid=337*Backpapier: Clima Controlling Facillity constructed.',20030327120001);
INSERT INTO ticker VALUES (1,1367,'w','*lproduction.php?act=build&pid=366*DREIZEHN: Fusion Power Plant constructed.',20030316180001);
INSERT INTO ticker VALUES (8,1184,'r','*lresearch.php*Your research has been finished!',20030314220002);
INSERT INTO ticker VALUES (1,1434,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet omega Rigel Centauri VII',20030317180001);
INSERT INTO ticker VALUES (2,3665,'w','*lproduction.php?act=build&pid=159*Homie II: Orbital Refueling Station in orbit constructed.',20030409040002);
INSERT INTO ticker VALUES (8,2446,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Gen Factory constructed.',20030328120001);
INSERT INTO ticker VALUES (8,1378,'r','*lresearch.php*Your research has been finished!',20030316200003);
INSERT INTO ticker VALUES (1,1382,'w','*lproduction.php?pid=30*EINS: 1 Carrier(s) produced.',20030316210001);
INSERT INTO ticker VALUES (1,1369,'w','*lproduction.php?act=build&pid=331*ZWÖLF: Fusion Power Plant constructed.',20030316180001);
INSERT INTO ticker VALUES (1,1400,'m','*lmail.php*You have recieved a message from Kai Allard Liao',20030317041318);
INSERT INTO ticker VALUES (8,1278,'w','*lproduction.php?act=build&pid=415*Ventilator: Spacestation in orbit constructed.',20030315220001);
INSERT INTO ticker VALUES (1,1380,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet Knackwurst',20030316210001);
INSERT INTO ticker VALUES (1,3520,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408070008);
INSERT INTO ticker VALUES (1,1379,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet kappa Al Sagittari VI',20030316210001);
INSERT INTO ticker VALUES (8,1234,'w','*lproduction.php?pid=337*Backpapier: 2 Colony ship(s) produced.',20030315140001);
INSERT INTO ticker VALUES (1,1515,'w','*lproduction.php?act=build&pid=230*SECHZEHN: Mopgas Extraction Platform in orbit constructed.',20030318140001);
INSERT INTO ticker VALUES (7,3697,'w','*lproduction.php?act=build&pid=315*Shanghai: Gen Factory constructed.',20030409100002);
INSERT INTO ticker VALUES (9,3699,'w','*lproduction.php?act=build&pid=493*Magnopolis XIX: Erkunum Pumping Station constructed.',20030409100002);
INSERT INTO ticker VALUES (1,3523,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408080007);
INSERT INTO ticker VALUES (1,2186,'s','Your spies intercepted some enemy spies!',20030326020005);
INSERT INTO ticker VALUES (8,2564,'w','*lproduction.php?act=build&pid=332*Fettbrand: Spacestation in orbit constructed.',20030329210001);
INSERT INTO ticker VALUES (8,2266,'w','*lproduction.php?act=build&pid=457*Nudelauflauf: Mining Complex constructed.',20030326170001);
INSERT INTO ticker VALUES (1,1751,'w','*lproduction.php?pid=30*EINS: 20 Carrier(s) produced.',20030321080001);
INSERT INTO ticker VALUES (1,1607,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet theta Gruis III',20030319090001);
INSERT INTO ticker VALUES (1,3516,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408060008);
INSERT INTO ticker VALUES (8,1642,'w','*lproduction.php?act=build&pid=415*Ventilator: Fusion Power Plant constructed.',20030319180001);
INSERT INTO ticker VALUES (1,1618,'w','*lproduction.php?pid=115*You have colonised a new planet',20030319090004);
INSERT INTO ticker VALUES (9,3696,'w','*lproduction.php?act=build&pid=494*Magnopolis XX: Erkunum Pumping Station constructed.',20030409100002);
INSERT INTO ticker VALUES (2,3660,'w','*lproduction.php?act=build&pid=469*Rock: Laser Weapons Factory constructed.',20030409030001);
INSERT INTO ticker VALUES (8,1625,'r','*lresearch.php*Your research has been finished!',20030319100003);
INSERT INTO ticker VALUES (2,3700,'w','*lproduction.php?act=build&pid=87*Oars: Gen Factory constructed.',20030409100002);
INSERT INTO ticker VALUES (1,1639,'r','*lresearch.php*Your research has been finished!',20030319160003);
INSERT INTO ticker VALUES (8,1982,'w','*lproduction.php?act=build&pid=415*Ventilator: Orbital Refueling Station in orbit constructed.',20030324050001);
INSERT INTO ticker VALUES (2,3538,'w','*lproduction.php?act=build&pid=469*Rock: Agriculture Command Center constructed.',20030408100001);
INSERT INTO ticker VALUES (1,1648,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet alpha Al Sagittari II',20030319190001);
INSERT INTO ticker VALUES (1,1649,'w','*lfleet.php*Fleet 1: arrived at planet kappa Al Sagittari II',20030319190001);
INSERT INTO ticker VALUES (1,1650,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet kappa Al Sagittari I',20030319190001);
INSERT INTO ticker VALUES (8,2097,'w','*lproduction.php?act=build&pid=415*Ventilator: Ground batteries constructed.',20030325070001);
INSERT INTO ticker VALUES (1,1653,'w','*lproduction.php?pid=192*You have colonised a new planet',20030319190003);
INSERT INTO ticker VALUES (1,1654,'w','*lproduction.php?pid=226*You have colonised a new planet',20030319190003);
INSERT INTO ticker VALUES (1,1655,'w','*lproduction.php?pid=225*You have colonised a new planet',20030319190003);
INSERT INTO ticker VALUES (8,2084,'w','*lproduction.php?act=build&pid=415*Ventilator: Cloning Vaults constructed.',20030325010001);
INSERT INTO ticker VALUES (1,1804,'w','*lproduction.php?pid=361*You have colonised a new planet',20030321190004);
INSERT INTO ticker VALUES (1,3511,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408050008);
INSERT INTO ticker VALUES (1,1668,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet omega Rigel Centauri I',20030320050001);
INSERT INTO ticker VALUES (5,2966,'w','*lproduction.php?pid=259*You have colonised a new planet',20030403110006);
INSERT INTO ticker VALUES (5,2967,'w','*lproduction.php?pid=247*You have colonised a new planet',20030403110006);
INSERT INTO ticker VALUES (1,1672,'w','*lproduction.php?pid=394*You have colonised a new planet',20030320050004);
INSERT INTO ticker VALUES (8,1981,'w','*lproduction.php?pid=457*You have colonised a new planet',20030324040005);
INSERT INTO ticker VALUES (8,2290,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Clima Controlling Facillity constructed.',20030326230001);
INSERT INTO ticker VALUES (1,1859,'r','*lresearch.php*Your research has been finished!',20030322160004);
INSERT INTO ticker VALUES (1,3539,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408100008);
INSERT INTO ticker VALUES (2,3597,'w','*lfleet.php*Fleet 2: arrived at planet nu Gruis IV',20030408210001);
INSERT INTO ticker VALUES (2,3657,'w','*lproduction.php?act=build&pid=105*Arsch: Laser Weapons Factory constructed.',20030409020002);
INSERT INTO ticker VALUES (2,3640,'w','*lproduction.php?act=build&pid=73*Ars: Starport constructed.',20030409010001);
INSERT INTO ticker VALUES (1,1726,'w','*lproduction.php?pid=222*You have colonised a new planet',20030320230004);
INSERT INTO ticker VALUES (1,2002,'w','*lproduction.php?pid=30*EINS: 5 Colony ship(s) produced.',20030324120001);
INSERT INTO ticker VALUES (1,1724,'w','*lproduction.php?pid=30*EINS: 20 Interceptor(s) produced.',20030320230002);
INSERT INTO ticker VALUES (8,2077,'w','*lproduction.php?act=build&pid=16*Chicken Wing[mc]: Starport constructed.',20030325000001);
INSERT INTO ticker VALUES (1,1723,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet zeta Al Sagittari V',20030320230001);
INSERT INTO ticker VALUES (1,1867,'w','*lproduction.php?pid=30*EINS: 130 Interceptor(s) produced.',20030322190002);
INSERT INTO ticker VALUES (1,1752,'w','*lfleet.php*Fleet 1: arrived at planet phi Al Sagittari VI',20030321090001);
INSERT INTO ticker VALUES (8,1702,'w','*lproduction.php?act=build&pid=337*Backpapier: Fusion Power Plant constructed.',20030320180001);
INSERT INTO ticker VALUES (8,1703,'w','*lproduction.php?act=build&pid=415*Ventilator: Mining Complex constructed.',20030320180001);
INSERT INTO ticker VALUES (8,2315,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Laser Weapons Factory constructed.',20030327040001);
INSERT INTO ticker VALUES (2,3536,'w','*lproduction.php?act=build&pid=475*marsupilami 2: Laser Weapons Factory constructed.',20030408100001);
INSERT INTO ticker VALUES (8,1746,'r','*lresearch.php*Your research has been finished!',20030321060004);
INSERT INTO ticker VALUES (1,1799,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet upsilon Rigel Centauri IV',20030321190001);
INSERT INTO ticker VALUES (8,2129,'r','*lresearch.php*Your research has been finished!',20030325140004);
INSERT INTO ticker VALUES (9,3630,'w','*lproduction.php?act=build&pid=108*Magnopolis: Arcology constructed.',20030409000001);
INSERT INTO ticker VALUES (1,1868,'w','*lproduction.php?pid=30*EINS: 50 N-2103 Bomber(s) produced.',20030322190002);
INSERT INTO ticker VALUES (1,1764,'w','*lproduction.php?pid=239*You have colonised a new planet',20030321090004);
INSERT INTO ticker VALUES (7,3693,'w','*lproduction.php?pid=315*Shanghai: 5 N-2103 Bomber(s) produced.',20030409090001);
INSERT INTO ticker VALUES (2,3587,'s','Your spies intercepted some enemy spies!',20030408190008);
INSERT INTO ticker VALUES (2,3522,'w','*lproduction.php?act=build&pid=89*Luciopodia: Planetary Shield Generator constructed.',20030408080001);
INSERT INTO ticker VALUES (8,1807,'w','*lproduction.php?pid=415*Ventilator: 5 Colony ship(s) produced.',20030321200002);
INSERT INTO ticker VALUES (1,3561,'w','*lfleet.php* An enemy fleet is closing in to system of planet ZWO!',20030408150008);
INSERT INTO ticker VALUES (1,2052,'r','*lresearch.php*Your research has been finished!',20030324210005);
INSERT INTO ticker VALUES (1,3553,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408140007);
INSERT INTO ticker VALUES (2,3656,'w','*lproduction.php?act=build&pid=66*R0KKY H0RR0R: Ground batteries constructed.',20030409020001);
INSERT INTO ticker VALUES (8,1881,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet delta Al Gruis III',20030322220001);
INSERT INTO ticker VALUES (8,1975,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet gamma Lyrae II',20030324040002);
INSERT INTO ticker VALUES (8,2050,'w','*lproduction.php?act=build&pid=415*Ventilator: Clima Controlling Facillity constructed.',20030324210001);
INSERT INTO ticker VALUES (1,1830,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet kappa Carinae II',20030322050001);
INSERT INTO ticker VALUES (1,1831,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet chi Al Gruis VII',20030322050001);
INSERT INTO ticker VALUES (1,1832,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet chi Al Gruis VI',20030322050001);
INSERT INTO ticker VALUES (1,1833,'w','*lproduction.php?pid=322*You have colonised a new planet',20030322050004);
INSERT INTO ticker VALUES (1,1834,'w','*lproduction.php?pid=437*You have colonised a new planet',20030322050004);
INSERT INTO ticker VALUES (1,1835,'w','*lproduction.php?pid=436*You have colonised a new planet',20030322050004);
INSERT INTO ticker VALUES (8,1837,'r','*lresearch.php*Your research has been finished!',20030322080004);
INSERT INTO ticker VALUES (9,3655,'w','*lproduction.php?act=build&pid=440*Magnopolis III: Defence Masquerader constructed.',20030409020001);
INSERT INTO ticker VALUES (8,2055,'w','*lproduction.php?act=build&pid=457*Nudelauflauf [mc: Starport constructed.',20030324220002);
INSERT INTO ticker VALUES (2,3590,'s','Your spies intercepted some enemy spies. Their leader is Kai Allard Liao (Draconis Combine)!',20030408190008);
INSERT INTO ticker VALUES (8,1887,'w','*lproduction.php?pid=429*You have colonised a new planet',20030322220004);
INSERT INTO ticker VALUES (1,1890,'w','*lproduction.php?act=build&pid=30*EINS: Surveillance Cluster constructed.',20030323000001);
INSERT INTO ticker VALUES (1,1893,'w','*lproduction.php?act=build&pid=436*chi Al Gruis VI: Surveillance Cluster constructed.',20030323000001);
INSERT INTO ticker VALUES (3,1894,'r','*lresearch.php*Your research has been finished!',20030323000004);
INSERT INTO ticker VALUES (1,1896,'w','*lproduction.php?act=build&pid=436*chi Al Gruis VI: Barracks constructed.',20030323020002);
INSERT INTO ticker VALUES (8,1897,'r','*lresearch.php*Your research has been finished!',20030323020004);
INSERT INTO ticker VALUES (1,1899,'w','*lproduction.php?pid=30*EINS: 10 Beholder(s) produced.',20030323030001);
INSERT INTO ticker VALUES (8,1907,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet chi Al Gruis V',20030323080001);
INSERT INTO ticker VALUES (8,1908,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet rho Mensae III',20030323080001);
INSERT INTO ticker VALUES (8,1927,'w','*lproduction.php?act=build&pid=429*Fettfleisch [mc]: Metal Mine constructed.',20030323120001);
INSERT INTO ticker VALUES (2,3623,'w','*lproduction.php?pid=107*You have colonised a new planet',20030408230007);
INSERT INTO ticker VALUES (8,1912,'w','*lproduction.php?pid=16*You have colonised a new planet',20030323080004);
INSERT INTO ticker VALUES (8,1913,'w','*lproduction.php?pid=435*You have colonised a new planet',20030323080004);
INSERT INTO ticker VALUES (1,1914,'w','*lproduction.php?act=build&pid=53*ACHT: Surveillance Cluster constructed.',20030323090001);
INSERT INTO ticker VALUES (8,1926,'w','*lproduction.php?act=build&pid=435*Dampfnudel [mc]: Metal Mine constructed.',20030323120001);
INSERT INTO ticker VALUES (8,1918,'w','*lproduction.php?act=build&pid=415*Ventilator: Planetary Shield Generator constructed.',20030323100002);
INSERT INTO ticker VALUES (8,1920,'w','*lproduction.php?act=build&pid=416*Backblech: Planetary Shield Generator constructed.',20030323100002);
INSERT INTO ticker VALUES (8,1921,'w','*lproduction.php?act=build&pid=337*Backpapier: Planetary Shield Generator constructed.',20030323100002);
INSERT INTO ticker VALUES (8,1925,'w','*lproduction.php?act=build&pid=16*Chicken Wing[mc]: Metal Mine constructed.',20030323120001);
INSERT INTO ticker VALUES (2,3562,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet zeta Mensae III',20030408160001);
INSERT INTO ticker VALUES (2,3654,'w','*lproduction.php?act=build&pid=72*Felsen: Laser Weapons Factory constructed.',20030409020001);
INSERT INTO ticker VALUES (2,3695,'w','*lproduction.php?act=build&pid=107*Power2: Nuclear Power Plant constructed.',20030409100002);
INSERT INTO ticker VALUES (1,3548,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408120008);
INSERT INTO ticker VALUES (8,1936,'w','*lproduction.php?act=build&pid=415*Ventilator: Agriculture Command Center constructed.',20030323150001);
INSERT INTO ticker VALUES (8,2900,'w','*lproduction.php?act=build&pid=332*Fettbrand: Gen Factory constructed.',20030402220002);
INSERT INTO ticker VALUES (1,3560,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408150008);
INSERT INTO ticker VALUES (8,1964,'w','*lproduction.php?act=build&pid=332*Fettbrand: Starport constructed.',20030324000001);
INSERT INTO ticker VALUES (8,1962,'w','*lproduction.php?act=build&pid=419*Wursthaut: Starport constructed.',20030324000001);
INSERT INTO ticker VALUES (8,1963,'w','*lproduction.php?act=build&pid=429*Fettfleisch [mc]: Starport constructed.',20030324000001);
INSERT INTO ticker VALUES (8,1943,'w','*lproduction.php?act=build&pid=415*Ventilator: Tradestation in orbit constructed.',20030323210001);
INSERT INTO ticker VALUES (8,2583,'w','*lproduction.php?act=build&pid=337*Backpapier: Instant Plasma Facility constructed.',20030330100001);
INSERT INTO ticker VALUES (8,2075,'w','*lproduction.php?act=build&pid=435*Dampfnudel [mc]: Starport constructed.',20030325000001);
INSERT INTO ticker VALUES (8,1988,'w','*lproduction.php?act=build&pid=416*Backblech: Spacestation in orbit constructed.',20030324080002);
INSERT INTO ticker VALUES (8,2039,'w','*lproduction.php?act=build&pid=435*Dampfnudel [mc]: Mining Complex constructed.',20030324200001);
INSERT INTO ticker VALUES (8,2040,'w','*lproduction.php?act=build&pid=16*Chicken Wing[mc]: Mining Complex constructed.',20030324200001);
INSERT INTO ticker VALUES (2,3652,'w','*lproduction.php?act=build&pid=475*marsupilami 2: Starport constructed.',20030409020001);
INSERT INTO ticker VALUES (8,2079,'w','*lproduction.php?act=build&pid=429*Fettfleisch [mc]: Mining Complex constructed.',20030325000001);
INSERT INTO ticker VALUES (8,2036,'w','*lproduction.php?act=build&pid=457*Nudelauflauf [mc: Metal Mine constructed.',20030324180001);
INSERT INTO ticker VALUES (9,3653,'w','*lproduction.php?act=build&pid=446*Magnopolis V: Defence Masquerader constructed.',20030409020001);
INSERT INTO ticker VALUES (8,2396,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Ground batteries constructed.',20030328000001);
INSERT INTO ticker VALUES (8,2380,'w','*lproduction.php?act=build&pid=337*Backpapier: Cloning Vaults constructed.',20030327210001);
INSERT INTO ticker VALUES (9,3650,'w','*lproduction.php?act=build&pid=439*Magnopolis II: Defence Masquerader constructed.',20030409020001);
INSERT INTO ticker VALUES (4,3619,'m','*lmail.php*You have recieved a message from Kai Allard Liao',20030408225159);
INSERT INTO ticker VALUES (8,2545,'w','*lproduction.php?act=build&pid=332*Fettbrand: Missle Base constructed.',20030329180001);
INSERT INTO ticker VALUES (5,3243,'s','Some ships vanished from your radar!',20030405200006);
INSERT INTO ticker VALUES (9,3631,'w','*lproduction.php?act=build&pid=85*Magnopolis XXIX: Metal Mine constructed.',20030409000001);
INSERT INTO ticker VALUES (8,2365,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Arcology constructed.',20030327180002);
INSERT INTO ticker VALUES (1,2508,'w','*lfleet.php* An enemy fleet is closing in to system of planet chi Al Gruis VI!',20030329050006);
INSERT INTO ticker VALUES (8,2483,'s','Your spies intercepted some enemy spies!',20030328200006);
INSERT INTO ticker VALUES (8,2364,'w','*lproduction.php?act=build&pid=337*Backpapier: Agriculture Command Center constructed.',20030327170001);
INSERT INTO ticker VALUES (8,2578,'r','*lresearch.php*Your research has been finished!',20030330070005);
INSERT INTO ticker VALUES (8,2411,'w','*lproduction.php?act=build&pid=337*Backpapier: Ground batteries constructed.',20030328030001);
INSERT INTO ticker VALUES (8,2462,'r','*lresearch.php*Your research has been finished!',20030328160005);
INSERT INTO ticker VALUES (1,2832,'s','Enemy spies launched a deadly nuclear attack agaonst Planet ZWO 6507961 were killed!',20030402040005);
INSERT INTO ticker VALUES (2,3643,'w','*lproduction.php?act=build&pid=86*Power1: Nuclear Power Plant constructed.',20030409010001);
INSERT INTO ticker VALUES (2,3642,'w','*lproduction.php?act=build&pid=32*ice 3: Laser Weapons Factory constructed.',20030409010001);
INSERT INTO ticker VALUES (2,3637,'r','*lresearch.php*Your research has been finished!',20030409000007);
INSERT INTO ticker VALUES (8,2540,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Orbital Refueling Station in orbit constructed.',20030329170001);
INSERT INTO ticker VALUES (8,2460,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Cloning Vaults constructed.',20030328160002);
INSERT INTO ticker VALUES (9,3645,'w','*lproduction.php?pid=13*Magnopolis XXV: 16 Space Marines(s) produced.',20030409010001);
INSERT INTO ticker VALUES (4,3629,'w','*lproduction.php?act=build&pid=163*Kappa Tucanae D1: Defence Masquerader constructed.',20030409000001);
INSERT INTO ticker VALUES (3,2488,'s','Your spies intercepted some enemy spies!',20030328200006);
INSERT INTO ticker VALUES (8,2489,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Agriculture Command Center constructed.',20030328210002);
INSERT INTO ticker VALUES (1,2509,'w','*lfleet.php* An enemy fleet is closing in to system of planet chi Al Gruis VII!',20030329050006);
INSERT INTO ticker VALUES (8,2598,'w','*lproduction.php?act=build&pid=16*Chicken Wing: Missle Base constructed.',20030330160001);
INSERT INTO ticker VALUES (9,3682,'w','*lproduction.php?act=build&pid=468*Magnopolis XII: Defence Masquerader constructed.',20030409060001);
INSERT INTO ticker VALUES (8,2541,'w','*lproduction.php?act=build&pid=337*Backpapier: Orbital Refueling Station in orbit constructed.',20030329170001);
INSERT INTO ticker VALUES (8,2550,'','Enemy Propaganda convinced  colonists of your imperium to leave.',20030329180005);
INSERT INTO ticker VALUES (3,2553,'s','Your spies intercepted some enemy spies. Their leader is Runelord (Delecious Cows)!',20030329180005);
INSERT INTO ticker VALUES (1,2575,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet Magnopolis XIV',20030330040001);
INSERT INTO ticker VALUES (5,3262,'r','*lresearch.php*Your research has been finished!',20030406000006);
INSERT INTO ticker VALUES (2,3681,'w','*lproduction.php?act=build&pid=86*Power1: Laser Weapons Factory constructed.',20030409060001);
INSERT INTO ticker VALUES (9,3680,'w','*lproduction.php?act=build&pid=464*Magnopolis VIII: Defence Masquerader constructed.',20030409060001);
INSERT INTO ticker VALUES (8,2600,'w','*lproduction.php?act=build&pid=337*Backpapier: Missle Base constructed.',20030330160001);
INSERT INTO ticker VALUES (1,3691,'r','*lresearch.php*Your research has been finished!',20030409080007);
INSERT INTO ticker VALUES (8,2610,'w','*lproduction.php?act=build&pid=332*Fettbrand: Instant Plasma Facility constructed.',20030330190002);
INSERT INTO ticker VALUES (9,3679,'w','*lproduction.php?act=build&pid=465*Magnopolis VII: Defence Masquerader constructed.',20030409060001);
INSERT INTO ticker VALUES (2,3572,'w','*lproduction.php?pid=89*Luciopodia: 3 Colony ship(s) produced.',20030408170001);
INSERT INTO ticker VALUES (9,3648,'w','*lfleet.php*Fleet MCShip01: arrived at planet iota Gruis II',20030409020001);
INSERT INTO ticker VALUES (9,3649,'w','*lproduction.php?act=build&pid=441*Magnopolis IV: Defence Masquerader constructed.',20030409020001);
INSERT INTO ticker VALUES (1,2830,'s','Your spies intercepted some enemy spies!',20030402040005);
INSERT INTO ticker VALUES (7,3698,'w','*lproduction.php?act=build&pid=20*Dubai II-M: Barracks constructed.',20030409100002);
INSERT INTO ticker VALUES (2,3610,'w','*lproduction.php?act=build&pid=8*New1: Barracks constructed.',20030408220001);
INSERT INTO ticker VALUES (8,2999,'w','*lproduction.php?act=build&pid=332*Fettbrand: Laser Weapons Factory constructed.',20030403180001);
INSERT INTO ticker VALUES (2,3570,'w','*lproduction.php?act=build&pid=63*marsupilami 1: Mining Complex constructed.',20030408170001);
INSERT INTO ticker VALUES (1,3550,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408130008);
INSERT INTO ticker VALUES (1,3403,'w','*lproduction.php?pid=30*EINS: 20 Beholder(s) produced.',20030407030001);
INSERT INTO ticker VALUES (2,3672,'s','Your spies intercepted some enemy spies!',20030409050007);
INSERT INTO ticker VALUES (9,3673,'s','Your spies intercepted some enemy spies!',20030409050007);
INSERT INTO ticker VALUES (4,3674,'s','Your spies intercepted some enemy spies. Their leader is Kai Allard Liao (Draconis Combine)!',20030409050007);
INSERT INTO ticker VALUES (2,3608,'w','*lproduction.php?act=build&pid=475*marsupilami 2: Gen Factory constructed.',20030408220001);
INSERT INTO ticker VALUES (2,3616,'w','*lproduction.php?act=build&pid=87*Oars: Metal Mine constructed.',20030408220001);
INSERT INTO ticker VALUES (2,3615,'w','*lproduction.php?act=build&pid=490*New3: Barracks constructed.',20030408220001);
INSERT INTO ticker VALUES (2,3614,'w','*lproduction.php?act=build&pid=102*Ravenhurst: Barracks constructed.',20030408220001);
INSERT INTO ticker VALUES (2,3613,'w','*lproduction.php?act=build&pid=82*Oldie IV 1: Barracks constructed.',20030408220001);
INSERT INTO ticker VALUES (8,2953,'w','*lproduction.php?pid=16*Chicken Wing: 12 Colony ship(s) produced.',20030403080001);
INSERT INTO ticker VALUES (2,3598,'w','*lproduction.php?act=build&pid=73*Ars: Metal Mine constructed.',20030408210001);
INSERT INTO ticker VALUES (1,3094,'s','Your spies intercepted some enemy spies!',20030404150006);
INSERT INTO ticker VALUES (2,3612,'w','*lproduction.php?act=build&pid=74*Oldie: Barracks constructed.',20030408220001);
INSERT INTO ticker VALUES (2,3611,'w','*lproduction.php?act=build&pid=11*New2: Barracks constructed.',20030408220001);
INSERT INTO ticker VALUES (2,3609,'w','*lproduction.php?act=build&pid=469*Rock: Gen Factory constructed.',20030408220001);
INSERT INTO ticker VALUES (5,3058,'w','*lproduction.php?pid=254*Gore: 5 Colony ship(s) produced.',20030404080001);
INSERT INTO ticker VALUES (2,3607,'w','*lproduction.php?act=build&pid=103*Oldie III 1: Fusion Power Plant constructed.',20030408220001);
INSERT INTO ticker VALUES (8,2722,'w','*lproduction.php?act=build&pid=332*Fettbrand: Clima Controlling Facillity constructed.',20030401010002);
INSERT INTO ticker VALUES (9,3658,'w','*lproduction.php?pid=70*You have colonised a new planet',20030409020007);
INSERT INTO ticker VALUES (5,2969,'w','*lproduction.php?act=build&pid=272*D15: Nuclear Power Plant constructed.',20030403120002);
INSERT INTO ticker VALUES (5,2970,'w','*lproduction.php?act=build&pid=257*D14: Nuclear Power Plant constructed.',20030403120002);
INSERT INTO ticker VALUES (4,3667,'w','*lproduction.php?act=build&pid=173*O-Tucanae O1: Gen Factory constructed.',20030409040002);
INSERT INTO ticker VALUES (2,3605,'w','*lproduction.php?pid=87*You have colonised a new planet',20030408210007);
INSERT INTO ticker VALUES (8,2973,'w','*lproduction.php?act=build&pid=332*Fettbrand: Arcology constructed.',20030403130001);
INSERT INTO ticker VALUES (9,3634,'w','*lproduction.php?pid=120*Magnopolis XXIV: 6 Soldier(s) produced.',20030409000001);
INSERT INTO ticker VALUES (2,3604,'w','*lproduction.php?pid=86*You have colonised a new planet',20030408210007);
INSERT INTO ticker VALUES (2,3569,'w','*lproduction.php?act=build&pid=112*Homie: Fusion Power Plant constructed.',20030408170001);
INSERT INTO ticker VALUES (1,3567,'w','*lproduction.php?pid=30*EINS: 10 Orbital Colony Center Unit(s) produced.',20030408160001);
INSERT INTO ticker VALUES (5,2957,'w','*lproduction.php?act=build&pid=122*O11: Metal Mine constructed.',20030403090002);
INSERT INTO ticker VALUES (2,3599,'w','*lproduction.php?act=build&pid=72*Felsen: Metal Mine constructed.',20030408210001);
INSERT INTO ticker VALUES (2,3600,'w','*lproduction.php?act=build&pid=105*Arsch: Metal Mine constructed.',20030408210001);
INSERT INTO ticker VALUES (2,3533,'s','Your spies intercepted some enemy spies. Their leader is Kai Allard Liao (Draconis Combine)!',20030408090008);
INSERT INTO ticker VALUES (2,3596,'w','*lfleet.php*Fleet 1: arrived at planet nu Gruis III',20030408210001);
INSERT INTO ticker VALUES (9,3646,'w','*lproduction.php?pid=120*Magnopolis XXIV: 50 Space Marines(s) produced.',20030409010001);
INSERT INTO ticker VALUES (2,3568,'w','*lproduction.php?pid=32*You have colonised a new planet',20030408160007);
INSERT INTO ticker VALUES (5,3010,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet upsilon Al Sagittari IV',20030403210002);
INSERT INTO ticker VALUES (1,3545,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408110008);
INSERT INTO ticker VALUES (8,2815,'w','*lproduction.php?act=build&pid=332*Fettbrand: Fusion Power Plant constructed.',20030402010001);
INSERT INTO ticker VALUES (8,3117,'w','SR hat nu nen neues Portal :) könnt ja mal vorbeigucken',20030404185110);
INSERT INTO ticker VALUES (5,2963,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet beta Canis Majoris IV',20030403110001);
INSERT INTO ticker VALUES (5,3114,'w','SR hat nu nen neues Portal :) könnt ja mal vorbeigucken',20030404185110);
INSERT INTO ticker VALUES (1,3534,'w','*lfleet.php* An enemy fleet is closing in to system of planet EINS!',20030408090008);
INSERT INTO ticker VALUES (2,3532,'s','Enemy spies destroyed some of your ships!',20030408090008);
INSERT INTO ticker VALUES (3,3112,'w','SR hat nu nen neues Portal :) könnt ja mal vorbeigucken',20030404185110);
INSERT INTO ticker VALUES (2,3694,'w','*lproduction.php?act=build&pid=103*Oldie III 1: Gen Factory constructed.',20030409100002);
INSERT INTO ticker VALUES (8,2849,'w','*lproduction.php?act=build&pid=332*Fettbrand: Cloning Vaults constructed.',20030402100002);
INSERT INTO ticker VALUES (5,3011,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet zeta Canis Majoris I',20030403210002);
INSERT INTO ticker VALUES (8,2927,'w','*lproduction.php?act=build&pid=332*Fettbrand: Ground batteries constructed.',20030403010001);
INSERT INTO ticker VALUES (1,3110,'w','SR hat nu nen neues Portal :) könnt ja mal vorbeigucken',20030404185110);
INSERT INTO ticker VALUES (5,2962,'w','*lfleet.php*Fleet Unnamed fleet: arrived at planet psi Canis Majoris II',20030403110001);
INSERT INTO ticker VALUES (4,3685,'w','*lproduction.php?act=build&pid=133*G Tucanae O1: Barracks constructed.',20030409070002);

--
-- Table structure for table 'traderules'
--

DROP TABLE IF EXISTS traderules;
CREATE TABLE traderules (
  rate float default NULL,
  sid int(11) default NULL,
  rid int(11) NOT NULL auto_increment,
  friend_alliance decimal(11,2) default '150.00',
  neutral_alliance decimal(11,2) default '200.00',
  enemy_alliance decimal(11,2) default '400.00',
  ressource char(1) default NULL,
  PRIMARY KEY  (rid)
) TYPE=MyISAM;

--
-- Dumping data for table 'traderules'
--


INSERT INTO traderules VALUES (2,1,1,4.00,4.20,20.00,'M');
INSERT INTO traderules VALUES (2,1,10,4.00,4.20,20.00,'E');
INSERT INTO traderules VALUES (5,3,3,7.00,10.00,20.00,'S');
INSERT INTO traderules VALUES (7,3,4,10.00,14.00,28.00,'R');
INSERT INTO traderules VALUES (1,5,5,1.00,2.00,6.00,'M');
INSERT INTO traderules VALUES (1,5,6,1.00,2.00,6.00,'E');
INSERT INTO traderules VALUES (3,5,7,4.00,4.00,18.00,'O');
INSERT INTO traderules VALUES (4,5,8,6.00,8.00,24.00,'R');
INSERT INTO traderules VALUES (3,5,9,4.00,6.00,18.00,'G');
INSERT INTO traderules VALUES (1,4,11,1.15,1.65,2.65,'E');
INSERT INTO traderules VALUES (7,4,12,8.05,11.55,18.55,'O');
INSERT INTO traderules VALUES (4,4,13,4.60,6.60,10.60,'R');
INSERT INTO traderules VALUES (4,4,14,4.60,6.60,10.60,'G');
INSERT INTO traderules VALUES (3,4,15,3.45,4.95,7.95,'M');
INSERT INTO traderules VALUES (20,4,16,23.00,33.00,53.00,'S');

--
-- Table structure for table 'tradestations'
--

DROP TABLE IF EXISTS tradestations;
CREATE TABLE tradestations (
  metal int(11) default NULL,
  energy int(11) default NULL,
  gortium int(11) default NULL,
  erkunum int(11) default NULL,
  mopgas int(11) default NULL,
  susebloom int(11) default NULL,
  uid int(11) default NULL,
  pid int(11) default NULL,
  sid int(11) NOT NULL auto_increment,
  fail_chance int(11) NOT NULL default '1',
  global_friend_alliance int(11) NOT NULL default '150',
  global_neutral_alliance int(11) NOT NULL default '200',
  global_enemy_alliance int(11) NOT NULL default '400',
  PRIMARY KEY  (sid)
) TYPE=MyISAM;

--
-- Dumping data for table 'tradestations'
--


INSERT INTO tradestations VALUES (4596,6589,0,0,0,14,4,205,1,1,200,210,1000);
INSERT INTO tradestations VALUES (0,0,0,0,0,0,2,109,2,1,400,400,400);
INSERT INTO tradestations VALUES (0,2000,0,5000,0,0,1,30,3,1,150,200,400);
INSERT INTO tradestations VALUES (0,0,125117,105521,183465,0,9,439,4,1,115,165,265);
INSERT INTO tradestations VALUES (0,17971,3428,5885,11797,0,7,334,5,1,150,150,600);
INSERT INTO tradestations VALUES (0,0,0,0,0,0,8,415,6,1,150,200,400);

--
-- Table structure for table 'users'
--

DROP TABLE IF EXISTS users;
CREATE TABLE users (
  name varchar(255) default NULL,
  password varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  email varchar(255) default NULL,
  imperium varchar(255) default NULL,
  active tinyint(1) default '0',
  last_login timestamp(14) NOT NULL,
  homeworld int(11) default NULL,
  alliance int(11) NOT NULL default '0',
  score int(11) NOT NULL default '0',
  skin int(11) default NULL,
  moz int(1) NOT NULL default '0',
  admin int(1) default NULL,
  apw varchar(255) default NULL,
  map_anims int(1) default '1',
  PRIMARY KEY  (id)
) TYPE=ISAM PACK_KEYS=1;

--
-- Dumping data for table 'users'
--


INSERT INTO users VALUES ('mop','$1$WEe6ngOI$Mfb3VLPDTQZDqZlcL3kIR0',1,'mop@spaceregents.de','Wurstimperium',1,20030409100007,30,1,189134,1,0,NULL,NULL,1);
INSERT INTO users VALUES ('Lucius','HX.ZuM5qr5PBs',2,'lucius@spaceregents.de','DARKENCY',1,20030409100007,109,2,251205,1,0,NULL,NULL,1);
INSERT INTO users VALUES ('morgoth','$1$/DBoMZm0$wZxDQyMQH9ifFi3QRm8aR0',3,'morg0th@gmx.net','Ssraa',1,20030409100007,170,1,11699,1,0,NULL,NULL,1);
INSERT INTO users VALUES ('Runelord','$1$AG0RaRbr$g.s3J02goA1sgiKv2Ffgm1',4,'runelord@spaceregents.de','Delecious Cows',1,20030409102934,205,2,144583,1,0,1,'Hamster',1);
INSERT INTO users VALUES ('gorlord','$1$uGhLrtN7$0HkI3i3aNKoAtzISsDadu0',5,'gorlord@gmx.net','gorfest',1,20030409100007,254,2,132949,1,0,NULL,NULL,1);
INSERT INTO users VALUES ('toXic','$1$gXo8S8xu$8E7cH24RyaL1e9YJLtvrj.',6,'toxic@space-project.de','The Syndrome',1,20030409090007,294,1,10641,1,0,NULL,NULL,1);
INSERT INTO users VALUES ('Kai Allard Liao','$1$UoVqjOev$L3ChguoIOPuX0k82KD1Ni1',7,'kai@oey.de','Draconis Combine',1,20030409100007,352,1,412224,1,0,NULL,NULL,0);
INSERT INTO users VALUES ('AlSvartr','$1$cLhqDCJl$R8U06oEXOGsLCMI5rOiH11',8,'d2n@alsvartr.de','Umluft',1,20030409100008,415,1,88085,1,0,NULL,NULL,1);
INSERT INTO users VALUES ('Lord_Magnus','$1$1NmfvhLH$2PwTNQcPMfqH7rJleCCoT1',9,'jan_magnus@web.de','Magnoterrian',1,20030409100008,439,2,232422,1,0,NULL,NULL,1);

--
-- Table structure for table 'version'
--

DROP TABLE IF EXISTS version;
CREATE TABLE version (
  version int(11) NOT NULL default '0',
  dummy_key int(11) NOT NULL default '0',
  PRIMARY KEY  (dummy_key)
) TYPE=MyISAM;

--
-- Dumping data for table 'version'
--


INSERT INTO version VALUES (30,1);

--
-- Table structure for table 'vornamen'
--

DROP TABLE IF EXISTS vornamen;
CREATE TABLE vornamen (
  name varchar(255) default NULL,
  id int(11) NOT NULL auto_increment,
  gender char(1) default NULL,
  PRIMARY KEY  (id),
  UNIQUE KEY name (name)
) TYPE=MyISAM;

--
-- Dumping data for table 'vornamen'
--


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

--
-- Table structure for table 'vote'
--

DROP TABLE IF EXISTS vote;
CREATE TABLE vote (
  end timestamp(14) NOT NULL,
  aid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'vote'
--


INSERT INTO vote VALUES (20030411000000,2);

--
-- Table structure for table 'votes'
--

DROP TABLE IF EXISTS votes;
CREATE TABLE votes (
  uid int(11) default NULL,
  vote int(11) default NULL,
  aid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'votes'
--


INSERT INTO votes VALUES (2,9,2);

--
-- Table structure for table 'warp'
--

DROP TABLE IF EXISTS warp;
CREATE TABLE warp (
  range int(11) default NULL,
  tid int(11) default NULL
) TYPE=MyISAM;

--
-- Dumping data for table 'warp'
--


INSERT INTO warp VALUES (300,12);
INSERT INTO warp VALUES (500,19);
INSERT INTO warp VALUES (800,62);

