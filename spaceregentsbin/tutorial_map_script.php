<?
DEFINE(NUM_PLAYERS, 64);

function connect_db()
{
	$db = @mysql_connect("localhost","root","") or die (mysql_error());
	mysql_select_db("spaceregents_tutorial");
}

function prepare_db()
{
	// USERS
	//$q = mysql_query("DROP TABLE IF EXISTS users") or die ("Konnte Tabelle USERS nicht löschen\n");
	/*$q = mysql_query("CREATE TABLE users (
										name varchar(255) default NULL,
										password varchar(255) default NULL,
									  id int(11) NOT NULL auto_increment,
									  email varchar(255) default NULL,
									  imperium varchar(255) default NULL,
									  active tinyint(1) default 0,
									  last_login timestamp NOT NULL default CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP,
									  homeworld int(11) default NULL,
									  alliance int(11) NOT NULL default 0,
									  score int(11) NOT NULL default 0,
									  skin int(11) default NULL,
									  moz int(1) NOT NULL default 0,
									  admin int(1) default NULL,
									  apw varchar(255) default NULL,
									  PRIMARY KEY  (id)
									) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1") or die ("Konnte Tabelle USERS nicht erstellen\n"+mysql_error());
  */									
		
	// CONSTELLATIONS							
	$q = mysql_query("DROP TABLE IF EXISTS constellations") or die ("Konnte Tabelle CONSTELLATIONS nicht löschen\n");
	$q = mysql_query("CREATE TABLE constellations (
									  id int(11) NOT NULL auto_increment,
									  name varchar(255) default NULL,
									  PRIMARY KEY  (id)
										) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1") or die ("Konnte Tabelle CONSTELLATIONS nicht erstellen\n");
										
	$q = mysql_query("DROP TABLE IF EXISTS systems") or die ("Konnte Tabelle SYSTEMS nicht löschen\n");
	$q = mysql_query("CREATE TABLE systems (
									  x int(11) NOT NULL default 0,
									  y int(11) NOT NULL default 0,
									  id int(11) NOT NULL auto_increment,
									  type int(11) default NULL,
									  cid int(11) default NULL,
									  name varchar(255) default NULL,
									  PRIMARY KEY  (id),
									  KEY x (x),
									  KEY y (y)
										) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;") or die ("Konnte Tabelle SYSTEMS nicht erstellen\n");
										
	// PLANETS
	$q = mysql_query("DROP TABLE IF EXISTS planets") or die ("Konnte Tabelle PLANETS nicht löschen\n");
	$q = mysql_query("CREATE TABLE planets (
									  x int(11) default NULL,
									  sid int(11) NOT NULL default '0',
									  uid int(11) NOT NULL default '0',
									  metal int(3) default 0,
									  energy int(3) default 0,
									  mopgas int(3) default 0,
									  erkunum int(3) default 0,
									  gortium int(3) default 0,
									  susebloom int(3) default 0,
									  start tinyint(1) default '0',
									  id int(11) NOT NULL auto_increment,
									  name varchar(255) NOT NULL default 'Unnamed',
									  type char(1) default NULL,
									  population bigint(11) default NULL,
									  last_combat int(11) default NULL,
									  production_factor double(3,2) not null default '1.00',
									  PRIMARY KEY  (id),
									  KEY sid (sid),
									  KEY uid (uid)
										) ENGINE=MyISAM DEFAULT CHARSET=latin1 PACK_KEYS=1;") or die ("Konnte Tabelle PLANETS nicht erstellen\n");
											
}

function write_systemplanets($home_sid, $sid1, $sid2)
{	
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(1, ".$home_sid.", 90, 0, 0, 0, 'R')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(2, ".$home_sid.", 0, 0, 0, 0, 'H')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(3, ".$home_sid.", 0, 0, 0, 0, 'G')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(4, ".$home_sid.", 60, 0, 0, 0, 'M')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(5, ".$home_sid.", 100, 100, 0, 1, 'O')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(6, ".$home_sid.", 0, 130, 0, 0, 'D')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(6, ".$home_sid.", 90, 0, 0, 0, 'R')") or die (mysql_error());
	
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(1, ".$sid1.", 110, 90, 0, 0, 'O')") or die (mysql_error());
	$q = mysql_query("INSERT INTO planets(x,sid,metal,energy,susebloom,start,type) VALUES(1, ".$sid2.", 150, 150, 120, 0, 'E')") or die (mysql_error());
}

function generate_tutorial_db()
{
	echo("creating constellations");
	for ($i = 0; $i < NUM_PLAYERS; $i++)
	{
		$q = mysql_query("INSERT INTO constellations(name) VALUES ('Constellation ".$i."')") or die (mysql_error());	
		
		$cid = mysql_insert_id();
		$q = mysql_query("DROP TABLE IF EXISTS __scanranges_".$cid) or die ("Could not drop scanrange table");
	  $q=mysql_query("CREATE TABLE __scanranges_".$cid." 
                      (sid int(11) NOT NULL default '0',
                       uid int(11) NOT NULL default '0',
                       type tinyint(1) NOT NULL default '0',
                       range int(11) default NULL,
                       last_update int(11) default NULL,
                       PRIMARY KEY  (sid,uid,type))
                       TYPE=MyISAM;") or die ("Could not create scanrange table");
    echo(".");                       
	}
	echo("done.\n");
	
	$row = sqrt(NUM_PLAYERS);
	
	echo("creating systems");
	for ($i = 0; $i < $row; $i++)
	{
		for ($j = 0; $j < $row; $j++)
		{
			$cx = 1000 * $j + 500;
			$cy = 1000 * $i + 500;
			$q = mysql_query("INSERT INTO systems (x,y, type, cid, name) VALUES (".$cx.",".$cy.",1,".($i * $row + $j).",'Your Homesystem')") or die (mysql_error());
			$home_sid = mysql_insert_id();			
			$q = mysql_query("INSERT INTO systems (x,y, type, cid, name) VALUES (".($cx-100).",".($cy-100).",2,".($i * $row + $j).",'Another System')") or die (mysql_error());
			$sid1 = mysql_insert_id();			
			$q = mysql_query("INSERT INTO systems (x,y, type, cid, name) VALUES (".($cx+300).",".$cy.",3,".($i * $row + $j).",'Some Place')") or die (mysql_error());
			$sid2 = mysql_insert_id();			
			if ($home_sid && $sid1 && $sid2)
				write_systemplanets($home_sid, $sid1, $sid2);
			echo(".");
		}
	}
		
	// fixe sterne damit die minimap richtg dargestellt wird
	$q = mysql_query("INSERT INTO systems (x,y, type, cid, name) VALUES (0,0,1,1,'Polarstar 1')");
	$q = mysql_query("INSERT INTO systems (x,y, type, cid, name) VALUES (".($row * 1000 - 1).",".($row * 1000 - 1).",".NUM_PLAYERS.",1,'Polarstar 1')");
	echo("done\n");
}

connect_db();
prepare_db();
generate_tutorial_db();
?>