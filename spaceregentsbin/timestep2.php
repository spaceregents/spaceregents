<?php
include "../spaceregentsconf/config.inc.php";
include "../spaceregentsinc/gp/dbwrap.inc";
include "../spaceregentsinc/func.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/domain.inc.php";

set_time_limit(3599);

function err($text)
{
  printf("%s - ERROR => %s => %s\n",date("Ymd H:i:s"),$text,mysql_error());
}


function scanrange_calculation()
{
  $time=time();
  
  $sth=mysql_query("select id from constellations");

  if (!$sth)
    echo("ERR::GET_CONST\n");

  // mop: da landen alle scanranges drinn
  $scanranges=array();
  
  while (list($cid)=mysql_fetch_row($sth))
  {
    // mop: alle planeten der constellation holen
    $sth1=mysql_query("select p.id,s.id,p.uid from planets p, systems s where p.sid=s.id and s.cid=$cid and uid!=0");

    if (!$sth1)
      echo("ERR::GET_PLANETS\n");

    while (list($pid,$sid,$uid)=mysql_fetch_row($sth1))
    {
      // mop: für alle planeten die maximale scanrange raussuchen und schauen ob die grösser als die
      // bisherige scanrange pro system is
      $pid_scanrange=get_max_scan_range_by_pid($pid);
      if ($scanranges[$sid][$uid]<$pid_scanrange)
  $scanranges[$sid][$uid]=$pid_scanrange;
    }

    // mop: jetzt durchgehen und in db speichern
    foreach ($scanranges as $sid=>$uid_scan)
    {
      foreach ($uid_scan as $uid=>$range)
      {
  $sth1=mysql_query("replace into __scanranges_".$cid." (sid,uid,type,range,last_update) values ('".$sid."','".$uid."','0','".$range."','".$time."')");

  if (!$sth1)
    echo("ERR::REPLACE SCANRANGES\n");
      }
    }

    // mop: scanranges resetten für fleets
    $scanranges=array();

    $sth1=mysql_query("select f.fid,f.sid,f.uid from fleet_info f,systems s where s.id=f.sid and s.cid=".$cid);

    if (!$sth1)
      echo("ERR::GET_FLEETS_SCAN");

    while (list($fid,$sid,$uid)=mysql_fetch_row($sth1))
    {
      // mop: für alle planeten die maximale scanrange raussuchen und schauen ob die grösser als die
      // bisherige scanrange pro system is
      $fid_scanrange=get_max_scanrange_by_fid($fid);
      if ($scanranges[$sid][$uid]<$fid_scanrange)
  $scanranges[$sid][$uid]=$fid_scanrange;
    }

    // mop: jetzt durchgehen und in db speichern
    foreach ($scanranges as $sid=>$uid_scan)
    {
      foreach ($uid_scan as $uid=>$range)
      {
  $sth1=mysql_query("replace into __scanranges_".$cid." (sid,uid,type,range,last_update) values ('".$sid."','".$uid."','1','".$range."','".$time."')");

  if (!$sth1)
    echo("ERR::REPLACE SCANRANGES\n");
      }
    }
    
    // mop: zum schluss alte einträge raushauen
    $sth1=mysql_query("delete from __scanranges_".$cid." where last_update < $time");
  }
}

function ranking()
{
  define(planet_points,"5000"); // Punkte pro Planet
  define(research_points,"1000"); // Punkte pro Technologie
  define(ress_points,0.001);
  define(l_ships,1);
  define(m_ships,2);
  define(h_ships,4);
  define(construction,100);
  
  $sth=mysql_query("update users u set last_login = last_login, u.score=
(select ifnull(count(p.id)*".planet_points.",0) from planets p where p.uid=u.id)+
(select ifnull(count(r.t_id)*".research_points.",0) from research r where r.uid=u.id)+
(select ifnull((r.metal+r.energy+r.mopgas+r.erkunum+r.gortium+r.susebloom)*".ress_points.",0) from ressources r where r.uid=u.id)+
(select ifnull(count(b.prod_id)*".construction.",0) from constructions as b,planets as p where b.pid=p.id and p.uid=u.id)+
(select ifnull(count(f.count)*".l_ships.",0) from fleet f,fleet_info fi,production p where f.fid=fi.fid and f.prod_id=p.prod_id and p.typ='L' and fi.uid=u.id)+
(select ifnull(count(f.count)*".m_ships.",0) from fleet f,fleet_info fi,production p where f.fid=fi.fid and f.prod_id=p.prod_id and p.typ='M' and fi.uid=u.id)+
(select ifnull(count(f.count)*".h_ships.",0) from fleet f,fleet_info fi,production p where f.fid=fi.fid and f.prod_id=p.prod_id and p.typ='H' and fi.uid=u.id)");

  if (!$sth)
  {
    echo("ERR::SCORE");
    return false;
  }
}

function fog_of_war()
{
  // mop: arrays, wo drinsteht, was aus den jeweiligen tabellen für felder rausgeholt werden soll
  $planets=array("p.x","p.sid","p.uid","p.metal","p.energy","p.mopgas","p.erkunum","p.gortium","p.susebloom","p.id","p.name","p.type");

  // mop: erstmal die alten infos holen
  $sth=mysql_query("select uid,data from fog_of_war");

  if (!$sth)
  {
    err("GET FOG");
    return false;
  }

  $real_data=array();
  while (list($uid,$data)=mysql_fetch_row($sth))
    $real_data[$uid]=unserialize($data);
  
  $query="(select distinct p2.uid as duid,".implode(",",$planets)." from planets p,planets p2 where p.sid=p2.sid and p2.uid!=0 order by p.x)
union (select distinct f.uid as duid,".implode(",",$planets)." from planets p,fleet_info f where p.sid=f.sid order by p.x)
";
  // mop: scanranges tabellen rausfinden
  $sth=mysql_query("select id from constellations");

  if (!$sth)
  {
    err("GET CIDS");
    return false;
  }
  
  while (list($cid)=mysql_fetch_row($sth))
    $query.="union (select distinct sr.uid as duid,".implode(",",$planets)." from planets p,systems s1,systems s2, __scanranges_".$cid." sr where s2.id=sr.sid and sqrt(pow(s1.x-s2.x,2)+pow(s1.y-s2.y,2))<=sr.range and s1.id=p.sid order by p.x)\n";

  $sth=mysql_query($query);

  if (!$sth)
  {
    err("NEW FOG");
    return false;
  }

  while ($data=mysql_fetch_assoc($sth))
    $real_data[$data["duid"]][$data["sid"]][$data["id"]]=$data;
  
  foreach ($real_data as $uid => $data)
  {
    $sth=mysql_query("replace into fog_of_war set uid=".$uid.",data='".addslashes(serialize($data))."'");

    if (!$sth)
    {
      err("REPLACE FOG");
      return false;
    }
  }
}


// Verzögert die Produktion auf umkämpften Planeten!

function combat_production_delay()
{
	$week=dlookup("week","timeinfo");
	
	if ($week)
	{
		$sth=mysql_query("UPDATE o_production p INNER JOIN planets pl ON pl.id=p.pid SET p.delay=-1, 
p.time=p.time*10 WHERE (p.delay IS NULL or p.delay=0) AND pl.last_combat=$week");
		if (!sth)
			echo(mysql_error());

		$sth=mysql_query("UPDATE p_production p INNER JOIN planets pl ON pl.id=p.pid SET p.delay=-1, 
p.time=p.time*10 WHERE (p.delay IS NULL or p.delay=0) AND pl.last_combat=$week");
		if (!sth)
			echo(mysql_error());

		$sth=mysql_query("UPDATE o_production p INNER JOIN planets pl ON pl.id=p.pid SET p.delay=0, 
p.time=ceil(p.time/10) WHERE p.delay=-1 AND (pl.last_combat<$week OR pl.last_combat IS NULL)");
		if (!sth)
			echo(mysql_error());

		$sth=mysql_query("UPDATE p_production p INNER JOIN planets pl ON pl.id=p.pid SET p.delay=0, 
p.time=ceil(p.time/10) WHERE p.delay=-1 AND (pl.last_combat<$week OR pl.last_combat IS NULL)");
		if (!sth)
			echo(mysql_error());

	}
}

function score_to_portal()
{
	$sth = mysql_query("SELECT name, score FROM users ORDER BY score DESC LIMIT 5");
	
	if (!sth)
		echo(mysql_error());

	$i = 0;
	while ($qtop_users = mysql_fetch_assoc($sth))
	{
		$top_users[$i]["name"] = $qtop_users["name"];
		$top_users[$i]["score"] = $qtop_users["score"];
		$i++;
	}

	mysql_select_db("spaceregentsportal") or die("! Could not select spaceregentsportal\n");
	
	$sth1 = mysql_query("DELETE FROM top_users");

	if (!sth1)
		echo("COULD NOT DELETE TOP USERS! -> ".mysql_error());
	
	foreach ($top_users as $user)
	{
		$sth = mysql_query("INSERT INTO top_users (name, score) VALUES ('".$user["name"]."','".$user["score"]."')");
		
		if (!sth)
			echo("COULD NOT INSERT TOP USERS! -> ".mysql_error());
	}


	mysql_select_db("spaceregents") or die("! Could not reselect spaceregents\n");
}

echo("Step2\n");
echo("=====================\n");
echo ("Connect!\n");
connect();
echo("Production delay\n");
combat_production_delay();
echo("Scanrangecalculation\n");
scanrange_calculation();
echo("Ranking\n");
ranking();
echo("Fog of war\n");
fog_of_war();

echo("INCREASING WEEK\n");
$sth=mysql_query("update timeinfo set week=week+1");

// PORTAL zeugs
echo("Writing Score to Portal DB\n");
score_to_portal();
?>
