<?
class medic
{
  var $version;
  var $new_version;

  function medic()
  {
    $sth=mysql_query("select version from version");

    if (!$sth)
      $this->version=0;
    else
    {
      $version=mysql_fetch_row($sth);

      $this->version=$version[0];
    }

    $this->set_new_version();
  }

  function check_db()
  {
    if ($this->version<$this->new_version)
    {
      $this->heal();
      $this->update_db_version();
    }
  }

  function update_db_version()
  {
    $sth=mysql_query("replace into version set version='".$this->new_version."',dummy_key='1'");
  }

  function set_new_version()
  {
    // Hier die neue Version eintragen....immer brav um eins erhöhen und dann klappt das. in heal() kommt dann
    // allerdings die aktuelle version rein...die ergo immer eins niedriger is
    $this->new_version=74;
  }

  function heal()
  {
    switch ($this->version)
    {
      // hier die db statements einsetzen...unter G A R   K E I N E N   U M S T Ä N D E N   ein break; einfügen
      // sonst isses kaputt
      case "0":
  $sth=mysql_query("create table version (version int not null,dummy_key int not null,primary key(dummy_key))");

      case "1":
  $sth=mysql_query("alter table p_production add pos int not null default '1'");
  $sth=mysql_query("alter table o_production add pos int not null default '1'");
  $sth=mysql_query("alter table p_production change planet_id planet_id int not null default '0'");
  $sth=mysql_query("alter table p_production add unique(planet_id,pos)");
  $sth=mysql_query("alter table o_production change planet_id planet_id int not null default '0'");
  $sth=mysql_query("alter table o_production add unique(planet_id,pos)");

      case "2":
  $sth=mysql_query("alter table users add map_scan int default '1'");

      case "3":
  $sth=mysql_query("create table routes (route mediumtext,fid int not null,primary key(fid))");
      case "4":
  $sth=mysql_query("CREATE TABLE keksession (
        uid int(11) NOT NULL default '0',
        session varchar(255) default NULL,
        time timestamp(14) NOT NULL,
        UNIQUE KEY uid (uid)
        ) TYPE=MyISAM;");

  $sth=mysql_query("CREATE TABLE kekvars (
  vars text,
  sid varchar(255) NOT NULL default '',
  PRIMARY KEY  (sid)
) TYPE=MyISAM");
      case "5":
  $sth=mysql_query("update production set special='F' where name='Orbital Refueling Station'");
      case "6":
  $sth=mysql_query("create table diplomacy (alliance1 int not null,alliance2 int not null,status tinyint(1),primary key(alliance1,alliance2))");
      case "7":
  $sth=mysql_query("create table diplomatic_change_request(aid1 int not null,aid2 int not null,status tinyint(1) not null default 0,primary key(aid1,aid2))");
      case "8":
  $sth=mysql_query("alter table jumpgatevalues add reload int not null default '0'");
  $sth=mysql_query("update jumpgatevalues set reload=100");
      case "9":
  $sth=mysql_query("alter table systems add name varchar(255)");
  $sth=mysql_query("CREATE TABLE constellationnames (
  name varchar(255) NOT NULL default '',
  id int(11) NOT NULL auto_increment,
  genetiv varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  KEY genetiv (genetiv),
  KEY name (name)
) TYPE=MyISAM");

  foreach (array("Canis Major"=>"Canis Majoris","Carina"=>"Carinae","Rigel Centaurus"=>"Rigel Centauri","Lyra"=>"Lyrae","Auriga"=>"Aurigae","Bootor"=>"Bootis","Orion"=>"Orionis","Canis Minor"=>"Canis Minoris","Eridanus"=>"Eridani","Aquila"=>"Aquilae","Centaurus"=>"Centauri","Scorpius"=>"Scorpii","Taurus"=>"Tauri","Virgo"=>"Virginis","Gemini"=>"Geminorium","Cygnus"=>"Cygni","Piscis Austrinus"=>"Piscis Austrini","Leo"=>"Leonis","Crucis"=>"Crucis","Ursa Major"=>"Ursa Majoris","Perseus"=>"Persei","Velorum"=>"Velorum","Kaus Sagittarus"=>"Kaus Sagittari","Cetus"=>"Ceti","Andromeda"=>"Andromedae","Ras Ophiuchus"=>"Ras Ophiuchi","Sagittarus"=>"Sagittari","Pavor"=>"Pavonis","Ursa Minor"=>"Ursa Minoris","Al Na'Gru"=>"Al Na'Gruis","Hydra"=>"Hydrae","Aries"=>"Arietis","Umus"=>"Umi","Gruis"=>"Gruis","Corona Borealis"=>"Coronae Borealis","Puppis"=>"Puppis","Cassiopeia"=>"Cassiopeiae","Phoenic"=>"Phoenicis","Draco"=>"Draconis","Pegasus"=>"Pegasi","Cepheus"=>"Cephei","Al Leo"=>"Al Leonis","Ophiuchus"=>"Ophiuchi","Zubenel Libra"=>"Zubenel Librae","Lepo"=>"Leporis","Lupus"=>"Lupi","Columba"=>"Columbae","Corvus"=>"Corvi","Serpentis"=>"Serpentis","Hercules"=>"Herculis","Ara"=>"Arae","Cor Canum Venaticorum"=>"Cor Canum Venaticorum","Zuben El Libra"=>"Zuben El Librae","Musca"=>"Muscae","Kelbal Ophiuchus"=>"Kelbal Ophiuchi","Tucana"=>"Tucanae","Na'iral Orion"=>"Na'iral Orionis","Deneb Capricornus"=>"Deneb Capricorni","Ras Hercules"=>"Ras Herculis","Yed Ophiuchus"=>"Yed Ophiuchi","Talitha Ursa Major"=>"Talitha Ursa Majoris","Triangulus"=>"Trianguli","Al Scorpius"=>"Al Scorpii","Aquarius"=>"Aquarii","Al Sagittarus"=>"Al Sagittari","Kaou Draco"=>"Kaou Draconis","Al Gruis"=>"Al Gruis","Al Indus"=>"Al Indi","Tania Ursa Major"=>"Tania Ursa Majoris","Capricornus"=>"Capricorni","Pictoris"=>"Pictoris","Lynx"=>"Lynx","Circinus"=>"Circini","Reticulus"=>"Reticuli","Er Cepheus"=>"Er Cephei","Libra"=>"Librae","Doradus"=>"Doradus","Al Aquila"=>"Al Aquilae","Volantis"=>"Volantis","Pyxidis"=>"Pyxidis","Tseen Velorum"=>"Tseen Velorum","Delphinus"=>"Delphini","Piscium"=>"Piscium","Alula Ursa Major"=>"Alula Ursa Majoris","Indus"=>"Indi","Octan"=>"Octanis","Sagitta"=>"Sagittae","Telescopius"=>"Telescopii","Electra"=>"Electra","Atlas"=>"Atlas","Al Capricornus"=>"Al Capricorni","Horologius"=>"Horologii","Crater"=>"Crateris","Cancrus"=>"Cancri","Apodis"=>"Apodis","Lacerta"=>"Lacertae","Primus Taurus"=>"Primus Tauri","Praecipula"=>"Praecipula","Alcor"=>"Alcor","Maia"=>"Maia","Equuleus"=>"Equulei","Monocerotis"=>"Monocerotis","Norma"=>"Normae","Chamaeleon"=>"Chamaeleontis","Camelopardalis"=>"Camelopardalis","Asellus Cancrus"=>"Asellus Cancri","Kaitain"=>"Kaitain","Merope"=>"Merope","Canum Venaticorum"=>"Canum Venaticorum","Coma Berenices"=>"Comae Berenices","Taygeta"=>"Taygeta","Sculptor"=>"Sculptoris","Leo Minor"=>"Leonis Minoris","Antlia"=>"Antliae","Caelus"=>"Caeli","Minharal Hydra"=>"Minharal Hydrae","Fornacus"=>"Fornacis","Vulpecula"=>"Vulpeculae","Scutus"=>"Scuti","Microscopius"=>"Microscopii","Corona Australis"=>"Coronae Australis","Mensa"=>"Mensae","Pleione"=>"Pleione","Sextant"=>"Sextantis") as $single => $genetiv)
  {
    $sth=mysql_query("insert into constellationnames (name,genetiv) values ('".addslashes($single)."','".addslashes($genetiv)."')");
  }


  $sth=mysql_query("CREATE TABLE greek_abc (
  name varchar(255) NOT NULL default '',
  id int(11) NOT NULL auto_increment,
  PRIMARY KEY  (id),
  KEY name (name)
) TYPE=MyISAM");

$sth=mysql_query("INSERT INTO greek_abc VALUES ('alpha',1)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('beta',2)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('gamma',3)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('delta',4)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('epsilon',5)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('nu',6)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('mu',7)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('eta',8)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('iota',9)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('pi',10)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('upsilon',11)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('lambda',12)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('omicron',13)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('sigma',14)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('rho',15)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('omega',16)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('xi',17)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('chi',18)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('phi',19)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('kappa',20)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('zeta',21)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('tau',22)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('psi',23)");
$sth=mysql_query("INSERT INTO greek_abc VALUES ('theta',24)");
      case "10":
  $sth=mysql_query("alter table tradestations add fail_chance int default '1' not null");
      case "11":
  $sth=mysql_query("drop table tradetransporters");
  $sth=mysql_query("drop table tradetransports");
  $sth=mysql_query("drop table pirates");
      case "12":
  $sth=mysql_query("alter table tradestations add global_friend_alliance int not null default '150'");
  $sth=mysql_query("alter table tradestations add global_neutral_alliance int not null default '200'");
  $sth=mysql_query("alter table tradestations add global_enemy_alliance int not null default '400'");
  $sth=mysql_query("alter table traderules add friend_alliance int not null default '150'");
  $sth=mysql_query("alter table traderules add neutral_alliance int not null default '200'");
  $sth=mysql_query("alter table traderules add enemy_alliance int not null default '400'");
      case 13:
  $sth = mysql_query("alter table production add column pic varchar(255) not null default 'default.jpg'");
      case "14":
  $sth=mysql_query("alter table traderules drop reshabenwollen");
  $sth=mysql_query("alter table traderules drop resgebenwollen");
  $sth=mysql_query("alter table traderules add ressource char(1)");
  $sth=mysql_query("create table shipoffers (count int,uid int not null,prod_id int,price int,id int not null auto_increment,primary key(id))");
  $sth=mysql_query("alter table ressources add money int not null default '1000'");
      case "15":
  $sth=mysql_query("insert into covertopsmissions VALUES ('Sabotage Tradestation',100,0,1000,1000,0,0,0,0,'O','I','T',0,10,60,10)");
      case "16":
  $sth=mysql_query("alter table admirals add agility int");
  $sth=mysql_query("alter table admirals add initiative int");
  $sth=mysql_query("alter table admirals add sensor int");
  $sth=mysql_query("alter table admirals add weaponskill int");
  $sth=mysql_query("alter table admirals add uniform int");
  $sth=mysql_query("alter table admirals add implantat int");
  $sth=mysql_query("alter table admirals add belt int");
  $sth=mysql_query("alter table admirals add used_xp int");
  $sth=mysql_query("alter table admirals add used_upgrades int not null default '0'");
      case "17":
  $sth=mysql_query("alter table forums add lastpost datetime");
      case "18":
  $sth=mysql_query("alter table users drop map_bgimage");
  $sth=mysql_query("alter table users drop map_const");
  $sth=mysql_query("alter table users drop map_alliance");
  $sth=mysql_query("alter table users drop map_fleets");
  $sth=mysql_query("alter table users drop map_scan");
  $sth=mysql_query("alter table users drop anifleets");
  $sth=mysql_query("alter table users drop aniroutes");
      case "19":
  $sth=mysql_query("create table battlereports (uid int,pid int, sid int, report text,time timestamp,id int not null auto_increment, primary key(id))");
      case "20":
  $sth=mysql_query("alter table ressources add colonists int");
      case "21":
  $sth=mysql_query("alter table production add colonists int(11) default '0'");
  $sth=mysql_query("update production set colonists='8000' where prod_id=12");
  $sth=mysql_query("update production set colonists='5000' where prod_id=62");
      case "22":
  $sth=mysql_query("alter table users add map_anims int(1) default '1'");
      case "23":
  $sth=mysql_query("insert into scanradius (prod_id, radius) values(3,100)");
      case "24":
        $sth=mysql_query("update production set pic='p_hijacker.jpg' where prod_id=28");
        $sth=mysql_query("update production set pic='p_n2103.jpg' where prod_id = 24");
        $sth=mysql_query("update production set pic='p_freezer.jpg' where prod_id = 29");
        $sth=mysql_query("update production set pic='p_b5056.jpg' where prod_id = 14");
        $sth=mysql_query("update production set pic='p_beholder.jpg' where prod_id = 37");
      case "25":
        $sth=mysql_query("alter table admirals modify column agility int(11) default 0, modify column initiative int(11) default 0, modify weaponskill int(11) default 0, modify sensor int(11) default 0");
      case "26":
        $sth = mysql_query("alter table planets add pic varchar(50) default 'default.jpg'");
        $sth = mysql_query("create table bughunters (id int(11) not null primary key auto_increment, uid int(11) not null, developer tinyint(1) default 0, foreign key (uid) references users (id))");
      case "27":
        $sth=mysql_query("drop table if exists colonyships");
      case "28":
        $sth = mysql_query("CREATE TABLE map_sizes (
                            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            width int(4) NOT NULL DEFAULT 800,
                            height int(4) NOT NULL DEFAULT 600)");
        $sth = mysql_query("INSERT INTO map_sizes (width, height) values (800, 600)");
        $sth = mysql_query("INSERT INTO map_sizes (width, height) values (1024, 768)");
        $sth = mysql_query("INSERT INTO map_sizes (width, height) values (1152, 864)");
        $sth = mysql_query("INSERT INTO map_sizes (width, height) values (1280, 1024)");
        $sth = mysql_query("CREATE TABLE options (
                            uid INT(11) NOT NULL DEFAULT 0,
                            map_size INT(11) NOT NULL DEFAULT 1 REFERENCES map_sizes,
                            map_constellation_cache TINYINT(2) DEFAULT 9,
                            map_system_cache TINYINT(2) DEFAULT 10)");
      case "29":
        $sth = mysql_query("alter table traderules modify friend_alliance DECIMAL(11,2) DEFAULT 150, modify neutral_alliance DECIMAL(11,2) DEFAULT 200, modify enemy_alliance DECIMAL(11,2) DEFAULT 400");
      case "30":
        $sth = mysql_query("alter table options add column map_autoupdate tinyint(1) default 0");
      case "31":
  $sth=mysql_query("alter table users drop map_anims");
  $sth=mysql_query("alter table options add map_anims bool default '1'");
      case "32":
        $sth = mysql_query("drop table shipoffers");
        $sth = mysql_query("create table shipoffers (prod_id int(11) not null,station_id int(11) not null,price decimal(9,2) unsigned,count int(11) unsigned not null default 0)");
        $sth = mysql_query("alter table tradestations add column level int(1) default 1");
        $sth = mysql_query("create table building_upgrades(prod_id int(11) not null,level int(1) not null default 2,metal int(11) default 0,energy int(11) default 0,mopgas int(11) default 0,erkunum int(11) default 0,gortium int(11) default 0,susebloom int(11) default 0)");
        $sth = mysql_query("insert into building_upgrades values (8, 2, 5000, 5000, 1000, 500, 0, 0)");
        $sth = mysql_query("insert into building_upgrades values (8, 3, 10000, 10000, 5000, 4000, 1000, 0)");
      case "33":
  $sth=mysql_query("alter table fleet_info add tactic int not null default '0'");
      case "34":
  $sth=mysql_query("alter table infantery drop iid");
  $sth=mysql_query("alter table infantery change uid uid int not null");
  $sth=mysql_query("alter table infantery change prod_id prod_id int not null");
  $sth=mysql_query("alter table infantery change pid pid int not null");
  $sth=mysql_query("alter table infantery add primary key(uid,prod_id,pid)");
      case "35":
  $sth=mysql_query("alter table fleet drop key prod_id");
  $sth=mysql_query("alter table fleet drop key fid");
  $sth=mysql_query("alter table fleet add primary key(prod_id,fid)");
      case "36":
  $sth=mysql_query("alter table fleet_info change fid fid int not null auto_increment");
      case "37":
  $sth=mysql_query("alter table shipvalues add num_attacks int not null");
  $sth=mysql_query("alter table shipvalues change prod_id prod_id int not null");
  $sth=mysql_query("alter table shipvalues add primary key(prod_id)");
  $sth=mysql_query("update shipvalues set num_attacks=1");
      case "38":
      $sth = mysql_query("alter table alliance add column symbol varchar(255)");
      case "39":
  $sth=mysql_query("alter table kekvars change vars vars longtext");
      case "40":
  $stm=mysql_query("create table timeinfo (week int(11) not null default '1',primary key(week))");
  $stm=mysql_query("insert into timeinfo set week=1");
      case "41":
  $sth=mysql_query("create table tmp_prod_factors (pid int not null,metal int not null default 1,energy int not null default 1,mopgas int not null default 1,erkunum int not null default 1,gortium int not null default 1,susebloom int not null default 1,index(pid))");
  $sth=mysql_query("create table final_prod_factors (pid int not null,metal int not null default 1,energy int not null default 1,mopgas int not null default 1,erkunum int not null default 1,gortium int not null default 1,susebloom int not null default 1,primary key(pid))");
      case "42":
  $sth=mysql_query("alter table planets modify population bigint(11)");
      case "43":
  $sth=mysql_query("CREATE TABLE `survey_session` (
  `sid` varchar(255) NOT NULL default '',
  `uid` int(11) default NULL,
  `fid` int(11) default NULL,
  `type` int(1) default NULL,
  `dt_exp` int(10) unsigned default NULL,
  `ip` int(10) NOT NULL default '0',
  PRIMARY KEY  (`sid`),
  KEY `dt_exp` (`dt_exp`),
  KEY `fid` (`fid`),
  KEY `ip` (`ip`)
) TYPE=MyISAM DEFAULT CHARSET=latin1");
  $sth=mysql_query("CREATE TABLE `session_vars` (
  `sid` varchar(255) NOT NULL default '',
  `vars` text,
  PRIMARY KEY  (`sid`)
) TYPE=MyISAM DEFAULT CHARSET=latin1");
      case  "44":
  $sth=mysql_query("create table income_stats (uid int not null,metal int default 0,energy int default 0,mopgas int default 0,erkunum int default 0,gortium int default 0,susebloom int default 0,tax_metal int default 0,tax_energy int default 0,tax_mopgas int default 0,tax_erkunum int default 0,tax_gortium int default 0,tax_susebloom int default 0,trade_metal int default 0,trade_energy int default 0,trade_mopgas int default 0,trade_erkunum int default 0,trade_gortium int default 0,trade_susebloom int default 0,earned_metal int default 0,earned_energy int default 0,earned_mopgas int default 0,earned_erkunum int default 0,earned_gortium int default 0,earned_susebloom int default 0,primary key(uid))");
      case "45":
  $sth=mysql_query("alter table res_to_trade change uid uid int not null default 0");
  $sth=mysql_query("alter table res_to_trade change metal metal int not null default 0");
  $sth=mysql_query("alter table res_to_trade change energy energy int not null default 0");
  $sth=mysql_query("alter table res_to_trade change mopgas mopgas int not null default 0");
  $sth=mysql_query("alter table res_to_trade change erkunum erkunum int not null default 0");
  $sth=mysql_query("alter table res_to_trade change gortium gortium int not null default 0");
  $sth=mysql_query("alter table res_to_trade change susebloom susebloom int not null default 0");
  $sth=mysql_query("alter table res_to_trade add primary key(uid)");
      case "46":
  $sth=mysql_query("alter table tradestations change uid uid int not null");
  $sth=mysql_query("alter table tradestations add unique(uid)");
      case "47":
      $sth = mysql_query("alter table inf_transports modify fid int(11) not null");
      $sth = mysql_query("alter table inf_transports modify prod_id int(11) not null");
      $sth = mysql_query("alter table inf_transports add primary key (fid, prod_id)");
      case "48":
  $sth=mysql_query("drop table popupgrade");
  $sth=mysql_query("alter table planets drop popgain");
  $sth=mysql_query("alter table planets drop pic");
  $sth=mysql_query("alter table planets type=MyISAM");
      case "49":
  $sth=mysql_query("create table constructions (pid int not null,prod_id int not null,type tinyint(1) not null default '0',primary key(pid,prod_id),index(type))");
  $sth=mysql_query("insert into constructions (pid,prod_id,type) select pid,prod_id,0 from buildings");
  $sth=mysql_query("insert into constructions (pid,prod_id,type) select pid,prod_id,1 from orbital");
  $sth=mysql_query("drop table buildings");
  $sth=mysql_query("drop table orbital");
      case "50":
  $sth=mysql_query("create table popgain (pid int not null,gain decimal(3,2) not null,primary key(pid),index(gain))");
      case "51":
  $sth=mysql_query("alter table popgain add max_poplevel int not null");
      case "52":
  $sth=mysql_query("update ressources set money=money+999000");
  $sth=mysql_query("update traderules set rate=rate*1000");
  $sth=mysql_query("alter table traderules change rate rate int(11)");
      case "53":
        $sth=mysql_query("create table alliance_lock (uid int not null,lock_date timestamp,primary key(uid))");
      case "54":
        $sth=mysql_query("create table research_queue (uid int not null,queue blob,primary key(uid))");
      case "55":
        $sth=mysql_query("drop table if exists battlereports");
        $sth=mysql_query("create table battlereports (report text not null default '',week int not null,pid int not null,sid int not null,id int not null auto_increment,index(pid),index(sid),primary key(id))");
        $sth=mysql_query("create table battlereports_alliance (aid int not null,rid int not null,primary key(aid,rid))");
        $sth=mysql_query("create table battlereports_user (uid int not null,rid int not null,primary key(uid,rid))");
      case "56":
        $sth=mysql_query("delete from vote");
        $sth=mysql_query("delete from votes");
        $sth=mysql_query("alter table vote change aid aid int not null");
        $sth=mysql_query("alter table vote add primary key(aid)");
        $sth=mysql_query("alter table votes change uid uid int not null");
        $sth=mysql_query("alter table votes change vote vote int not null");
        $sth=mysql_query("alter table votes change aid aid int not null");
        $sth=mysql_query("alter table votes add primary key(uid,vote,aid)");
      case "57":
        $sth = mysql_query("update fleet_info set milminister = 1 where milminister != 0");
        $sth = mysql_query("alter table fleet_info change milminister milminister tinyint(1) not null default 0");
      case "58":
        $sth = mysql_query("ALTER TABLE income_stats DROP COLUMN trade_metal, DROP COLUMN trade_energy, DROP COLUMN trade_mopgas, DROP COLUMN trade_erkunum, DROP COLUMN trade_gortium, DROP COLUMN trade_susebloom");
        $sth = mysql_query("DROP TABLE traderules");
        $sth = mysql_query("DROP TABLE shipoffers");
        $sth = mysql_query("DROP TABLE res_to_trade");
        $sth = mysql_query("CREATE TABLE stockmarkets (type CHAR(3) NOT NULL, max_price INT(3), last_price INT(2) DEFAULT 0, stocks_traded INT DEFAULT 0, PRIMARY KEY (type))");
        $sth = mysql_query("INSERT INTO stockmarkets (type, max_price, last_price, stocks_traded) values ('MET', 99, 0, 0)");
        $sth = mysql_query("INSERT INTO stockmarkets (type, max_price, last_price, stocks_traded) values ('ENE', 99, 0, 0)");
        $sth = mysql_query("INSERT INTO stockmarkets (type, max_price, last_price, stocks_traded) values ('MOP', 99, 0, 0)");
        $sth = mysql_query("INSERT INTO stockmarkets (type, max_price, last_price, stocks_traded) values ('ERK', 99, 0, 0)");
        $sth = mysql_query("INSERT INTO stockmarkets (type, max_price, last_price, stocks_traded) values ('GOR', 99, 0, 0)");
        $sth = mysql_query("INSERT INTO stockmarkets (type, max_price, last_price, stocks_traded) values ('SUS', 99, 0, 0)");
        $sth = mysql_query("CREATE TABLE stockmarket_orders (stockmarket CHAR(3) NOT NULL, time  TIMESTAMP, type int(1) NOT NULL DEFAULT 0, price INT(3) NOT NULL, amount INT default 0,uid INT(11) NOT NULL)");
        $sth = mysql_query("CREATE TABLE stockmarket_statistics (stockmarket CHAR(3) NOT NULL, time TIMESTAMP, avg_price DECIMAL(3,2) DEFAULT 0, stocks_traded INT DEFAULT 0, PRIMARY KEY (stockmarket, time))");
        $sth = mysql_query("CREATE TABLE stockmarket_ticker (uid int(11) not null, time timestamp, message varchar(255))");
        $sth = mysql_query("ALTER TABLE tradestations DROP COLUMN level, DROP COLUMN global_friend_alliance, DROP COLUMN global_neutral_alliance, DROP COLUMN global_enemy_alliance");
      case 59:
        $sth=mysql_query("alter table tmp_prod_factors add all_res int not null default 1");
        foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom","all_res") as $ressource)
          $sth=mysql_query("alter table tmp_prod_factors change ".$ressource." ".$ressource." int not null default 0");
      case 60:
        $sth = mysql_query("ALTER TABLE stockmarket_statistics MODIFY time int(11) not null");
      case 61:
        $sth=mysql_query("create table fog_of_war (uid int not null,data longblob not null,primary key(uid))");
      case 62:
      	// Dies ist nicht schlau, aber mutig!
      	$sth=mysql_query("DROP TABLE inf_values");
      	
      	$sth=mysql_query("ALTER TABLE o_production ADD COLUMN delay int(11)");
      	$sth=mysql_query("ALTER TABLE p_production ADD COLUMN delay int(11)");
      case 63:
        $sth=mysql_query("CREATE TABLE planetary_shields (pid int(11), prod_id int(11), value int(11), max_value int(11), regeneration int(11), regeneration_bonus int(11), PRIMARY KEY (pid, prod_id))");
        $sth=mysql_query("UPDATE TABLE shipvalues SET shield=12000, special='H500' WHERE prod_id=15");
      case 64:
      	$sth=mysql_query("ALTER TABLE covertopsmissions MODIFY descr text");
      case 65:
      	$sth=mysql_query("UPDATE production SET p_depend=67 WHERE prod_id=75");
      case 66:
      	$sth=mysql_query("ALTER TABLE planets ADD COLUMN last_combat int(11)");
      case 67:
        foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
          $sth=mysql_query("alter table income_stats add upkeep_".$res." int(11) default '0'");
      case 68:
        foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
        {
          $sth=mysql_query("alter table income_stats change ".$res." ".$res." int(11) not null default '0'");
          $sth=mysql_query("alter table income_stats change tax_".$res." tax_".$res." int(11) not null default '0'");
          $sth=mysql_query("alter table income_stats change earned_".$res." earned_".$res." int(11) not null default '0'");
          $sth=mysql_query("alter table income_stats change upkeep_".$res." upkeep_".$res." int(11) not null default '0'");
        }
      case 69:
        foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom","uid","colonists") as $res)
          $sth=mysql_query("alter table ressources change ".$res." ".$res." int(11) not null default '0'");
        $sth=mysql_query("alter table ressources add primary key(uid)");
      case 70:
        $sth=mysql_query("alter table planets add production_factor double(3,2) not null default '1.00'");
      case 71:
        $sth=mysql_query("alter table s_production change prod_id prod_id int not null");
        $sth=mysql_query("alter table s_production change planet_id planet_id int not null");
        $sth=mysql_query("alter table s_production change time time int not null");
        $sth=mysql_query("alter table s_production add primary key(prod_id,planet_id,time)");
      case 72:
      	$sth = mysql_query("alter table planets change metal metal int(3) default 0");
      	$sth = mysql_query("alter table planets change energy energy int(3) default 0");
      	$sth = mysql_query("alter table planets change mopgas mopgas int(3) default 0");
      	$sth = mysql_query("alter table planets change erkunum erkunum int(3) default 0");
      	$sth = mysql_query("alter table planets change gortium gortium int(3) default 0");
      	$sth = mysql_query("alter table planets change susebloom susebloom int(3) default 0");
      case 73:
        $sth=mysql_query("alter table s_production add priority tinyint(1) unsigned not null default 1");
    }
  }
}
?>
