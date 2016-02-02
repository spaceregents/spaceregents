<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return 0;

// Bis hier immer so machen:)

function show_fleet()
{
  global $fid;
  global $uid;

  $no_scan=100;

  $sth=mysql_query("select u.alliance,u.id from fleet_info as f,users as u where u.id=f.uid and f.fid=$fid limit 1");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Either this fleet doesn't exist or you are trying to hack :)");
    return 0;
  }

  $sth=mysql_query("select alliance from users where id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $u_alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select u.alliance,u.id from users as u,fleet_info as f where f.uid=u.id and f.fid=$fid and u.alliance!=0");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
  
  if (mysql_num_rows($sth)==0)
  {
    $allowed=false;
  }
  else
  {
    $f_alliance=mysql_fetch_array($sth);

    if ($f_alliance["id"]==$uid)
      $allowed=true;
    elseif (($f_alliance["alliance"]==$u_alliance["alliance"]) and ($u_alliance!=0))
      $allowed=true;
    else
      $allowed=false;
  }
  if (!$allowed)
  {
    $sth=mysql_query("select sid from fleet_info where fid=$fid");

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    $system=mysql_fetch_array($sth);

    $sth=mysql_query("select fid from fleet_info where uid=$uid and sid=".$system["sid"]);

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    if (mysql_num_rows($sth)>0)
      $allowed=true;
  }
    

  if (!$allowed)
  {
    $sth=mysql_query("select p.id,p.uid,p.name,s.x,s.y from planets as p,systems as s where uid=$uid and p.sid=s.id");

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    $allowed=false;

    while (($planets=mysql_fetch_array($sth)) and (!$allowed))
    {
      $sth1=mysql_query("select max(s.radius) from scanradius as s,constructions as o where s.prod_id=o.prod_id and o.pid=".$planets["id"]);

      if (!$sth1)
      {
	show_error("Dataabse failure!");
	return 0;
      }

      $radius=mysql_fetch_row($sth1);

      if ($radius[0]==NULL)
        $radius[0]=$no_scan;

      $sth1=mysql_query("select * from systems as s,fleet_info as f where (s.x-".$planets["x"].")*(s.x-".$planets["x"].")+(s.y-".$planets["y"].")*(s.y-".$planets["y"].")<=".$radius[0]."*".$radius[0]." and f.sid=s.id and f.fid=$fid");

      if (!$sth1)
      {
	show_error("Database failure!");
	return 0;
      }

      if (mysql_num_rows($sth1)>0)
	$allowed=true;

    }
  }

  if (!$allowed)
  {
    show_error("Your scanning abilities aren't sufficient to view this fleet!");
    return 0;
  }

  $sth=mysql_query("select f.count,f.fid,f.prod_id,p.name from fleet as f, production as p where p.prod_id=f.prod_id and f.fid=$fid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Either this fleet doesn't exist or you are trying to hack :)");
    return 0;
  }

  table_start("center","500");
  table_head_text(array("Fleet Overview"),"2");
  
  while ($fleet=mysql_fetch_array($sth))
  {
    table_text_open("head","center");
    table_text_design($fleet["name"],"250","","","text");
    table_text_design($fleet["count"],"250","","","text");
    table_text_close();
  }
}

switch ($act)
{
  default:
    show_fleet();
}


// ENDE
include "inc/footer.inc.php";
?>
