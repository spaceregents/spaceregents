<?php
define(UNITTYPE_LIGHTSHIP,0x1);
define(UNITTYPE_MEDIUMSHIP,0x2);
define(UNITTYPE_HEAVYSHIP,0x4);
define(UNITTYPE_PLANETAR,0x8);
define(UNITTYPE_ORBITAL,0x10);
define(UNITTYPE_INFANTERY,0x20);

define(DESTROYED,1);
define(DISABLED,2);
define(CAPTURED,3);
/**
  * class battle
  * 
  */

class battle
{
  /** 
   * ctor
   * 
   * @return 
   */
  function battle()
  {
    try
    {
      $reporter=new battlereporter;
    }
    catch (Exception $e)
    {
      throw $e;
    }

    $battles=$this->get_battles();

    if (!is_array($battles))
    {
      echo("AAAAAAAAARRRRRRGH KAMPF KAPUTT!");
      return false;
    }

    foreach ($battles as $battle)
    {
      list($sid,$pid)=$battle;
      try
      {
	$battlefield=new battlefield($sid,$pid);
	$battlefield->execute_battle();
	if (BATTLE_DESTROY)
	{
	  $battlefield->capture_units();
	  $battlefield->flee_units();
	  $battlefield->destroy_units();
	  // mop: lieber mehrmals ausführen....nicht, dass wir da nen segfault zwischendurch bekommen und dann die schiffe da bleiben
	  delete_empty_fleets();
	  $sth1=mysql_query("delete from inf_transports where count<=0");
	  $sth1=mysql_query("delete from infantery where count<=0");

	  if ($pid)
	  {
	    $owner=get_uid_by_pid($pid);
	    
	    // Mop: derjenigen mit den meisten einheiten erobert den planeten
	    // => idealsituation : der mit der prolligsten armee
	    $sth1=mysql_query("select i.uid,sum(i.count) as total_count from infantery i left join infantery i2 on i.pid=i2.pid and i2.uid=".$owner." where i.pid=".$pid." and i.uid!=".$owner." and i2.uid is null group by i.uid order by total_count desc limit 1");

	    if (!$sth1)
	    {
	      echo("invade kaputt =>".$pid."\n");
	    }

	    if (mysql_num_rows($sth1)!=0)
	    {
	      list($new_owner)=mysql_fetch_row($sth1);

	      $sth1=mysql_query("update planets set uid=".$new_owner." where id=".$pid);
	      
	      if (!$sth1)
		echo("invade kaputt 2 => ".$pid." ".$new_owner."\n");

	      $battlefield->set_invasion($new_owner);
	    }
	  }
	}
	$reporter->set_field($battlefield);
	$reporter->generate_reports();
      }
      catch (Exception $e)
      {
	echo($e->getMessage()."\n");
      }
    }
  }

  function get_battles()
  {
    if (SIMULATION_MODE)
    {
      $sth=mysql_query("select distinct side from battle_".$GLOBALS["sim_uid"]);

      if (!$sth || mysql_num_rows($sth)!=2)
	return false;
      else
        return array("0"=>"0");
    }
    else
    {
      $battles=array();

      $sth=mysql_query("select distinct f1.sid,f1.pid from fleet_info f1,fleet_info f2, users u1, users u2,diplomacy d where f1.pid=f2.pid and f1.sid=f2.sid and f1.fid!=f2.fid and f1.uid!=f2.uid and u1.id=f1.uid and u2.id=f2.uid and d.alliance1=u1.alliance and d.alliance2=u2.alliance and d.status=0");

      if (!$sth)
	return false;

      while (list($sid,$pid)=mysql_fetch_row($sth))
      {
	$battles[]=array($sid,$pid);
      }

      $sth=mysql_query("select distinct p.id,p.sid from planets p, fleet_info f,users u1, users u2,diplomacy d where f.sid=p.sid and f.pid=p.id and u1.id=p.uid and u2.id=f.uid and d.alliance1=u1.alliance and d.alliance2=u2.alliance and d.status=0 and f.mission in (1,2)");

      if (!$sth)
	return false;

      while (list($pid,$sid)=mysql_fetch_row($sth))
      {
	if (!in_array(array($sid,$pid),$battles))
	  $battles[]=array($sid,$pid);
      }

      $sth=mysql_query("select distinct i1.pid from infantery i1, infantery i2, users u1, users u2,diplomacy d where i1.pid=i2.pid and u1.id=i1.uid and u2.id=i2.uid and d.alliance1=u1.alliance and d.alliance2=u2.alliance and d.status=0"); 

      if (!$sth)
	return false;

      while (list($pid)=mysql_fetch_row($sth))
      {
	if (!in_array(array($sid,$pid),$battles))
	  $battles[]=array(get_sid_by_pid($pid),$pid);
      }

      return $battles;
    }
  }
}
?>
