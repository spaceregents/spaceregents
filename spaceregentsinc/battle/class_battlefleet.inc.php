<?php
/**
  * class battlefleet
  * 
  */

class battlefleet extends battleparticipant
{
  /** 
   * die mission (invade, oder normal)
   */
  var $mission;

  /**
   * komplette anzahl der schiffe
   */
  var $total_count;
  
  /** 
   * ctor
   * 
   * @param $fid 
   */
  function battlefleet($fid,$planet)
  {
    $sth=mysql_query("select id,name,value,agility,initiative,sensor,weaponskill from admirals where fid=$fid");

    if ($sth && mysql_num_rows($sth)>0)
    {
      $this->admiral=new stdClass;
      list($this->admiral->id,$this->admiral->name,$this->admiral->value,$bonus["agility"],$bonus["initiative"],$bonus["sensor"],$bonus["weaponskill"])=mysql_fetch_row($sth);
    }
    else
    {
      $this->admiral=false;
      $bonus=false;
    }

    $sth=mysql_query("select f.count,fi.uid,fi.name,fi.tactic,f.prod_id,it.storage,fi.mission from fleet_info fi, fleet f left join inf_transporters it on it.prod_id=f.prod_id where fi.fid=".$fid." and fi.fid=f.fid");

    if (!$sth)
    {
      throw new SQLException();
    }

    $prev=false;

    $transporter=array();

    while (list($count,$uid,$name,$tactic,$prod_id,$storage,$mission)=mysql_fetch_row($sth))
    {
      if ($tactic & TAC_STORMATTACK)
      {
	$bonus["initiative"]+=10;
	$bonus["sensor"]-=10;
	$bonus["agility"]-=10;
      }
      
      if (!$this->uid && !$this->tactic && !$this->name && !$this->mission)
      {
	$this->uid=$uid;
	$this->tactic=$tactic;
	$this->name=$name;
	$this->mission=$mission;
      }
     
      if ($storage)
      {
	$unit=new battletransporter($prod_id,$fid,$bonus,$planet,$this->uid,$this->get_alliance(),$this->get_enemies(),$this->get_friends(),$this->mission==M_INVADE);
      }
      else
      {
	$unit=new battleship($prod_id,$fid,$bonus);
      }

      $this->total_count+=$count;

      // mop: das objekt so oft kopieren wie es schiffe gibt
      for ($i=0;$i<$count;$i++)
      {
	$this_unit=clone $unit;
	if ($storage)
	  $transporter[]=$this_unit;
	$this->units=new battleunitcontainer($this_unit,$prev,false);
	if ($prev)
	{
	  /** 
	   * wenn admiral, dann das beste schiff suchen
	   */
	  if ($this->admiral)
	  {
	    if ($this_unit->get_challenge_points()>$this->admiral_unit->get_challenge_points())
	    {
	      $this->admiral_unit=$this_unit;
	    }
	  }
	  $prev->set_next($this->units);
	}
	elseif ($this->admiral)
	{
	  $this->admiral_unit=$this_unit;
	}
	$prev=$this->units;
	$this->challenge_points+=$this_unit->get_challenge_points();
      }
    }

    $sth=mysql_query("select i.prod_id,i.count from inf_transports i where i.fid=$fid");

    if (!$sth)
      throw new SQLException();
   
    while (list($prod_id,$count)=mysql_fetch_row($sth))
    {
      $inf_unit=new battleinfantery($prod_id,$bonus);
      $inf_unit->set_name($inf_unit->get_name()." (on transport)");

      for ($i=0;$i<$count;$i++)
      {
	$assigned=false;
	
	for ($j=0;$j<sizeof($transporter) && !$assigned;$j++)
	{
	  $assigned=$transporter[$j]->assign_infantery(clone $inf_unit);
	}

	if (!$assigned)
	{
	  echo("hmm...kaputt\n");
	}
      }
    }

    $this->check_unittypes();

    $this->fo_id=$fid;
  }

  function destroy_units()
  {
    $to_destroy=array();

    if (is_array($this->destroyed_units))
    {
      foreach ($this->destroyed_units as $unit)
      {
	if (!$to_destroy[$unit->get_prod_id()])
	  $to_destroy[$unit->get_prod_id()]=0;

	$to_destroy[$unit->get_prod_id()]++;

	if ($unit->has_subunits())
	{
	  $unit->destroy_subunits(); 
	}
      }
    }

    foreach ($to_destroy as $prod_id => $count)
      $sth=mysql_query("update fleet set count=count-".$count." where fid=".$this->fo_id." and prod_id=".$prod_id);
  }

  function capture_units()
  {
    $to_capture=array();

    if (is_array($this->captured_units))
    {
      foreach ($this->captured_units as $unit)
      {
	if (!$to_capture[$unit->get_prod_id()])
	  $to_capture[$unit->get_prod_id()]=0;

	$to_capture[$unit->get_prod_id()]++;
      }
    }

    foreach ($to_capture as $prod_id => $count)
      $sth=mysql_query("insert into fleet set count=".$count.",prod_id=".$prod_id.",fid=".$this->fo_id." on duplicate key update count=count+".$count);
  }
  
  function flee_units()
  {
    $to_flee=array();
    $inf_to_flee=array();

    if (is_array($this->fled_units))
    {
      foreach ($this->fled_units as $unit)
      {
	if (!$to_flee[$unit->get_prod_id()])
	  $to_flee[$unit->get_prod_id()]=0;

	$to_flee[$unit->get_prod_id()]++;

	if ($unit->has_subunits())
	{
	  $sub_units=$unit->get_subunits();
	  
	  for ($i=0;$i<sizeof($sub_units);$i++)
	    $inf_to_flee[$sub_units[$i]->get_prod_id()]++;
	}
      }
    }

    if (sizeof($to_flee)>0)
    {
      echo("FLIEH\n");
      $sth=mysql_query("select p.id from planets p, fleet_info f where f.sid=p.sid and f.pid!=p.id and f.fid=".$this->fo_id." order by rand() limit 1");

      if (!$sth)
      {
	echo("ERR::GET NEW PID");
      }
      
      if (mysql_num_rows($sth)==0)
      {
	$new_pid=0;
      }
      else
      {
        list($new_pid)=mysql_fetch_row($sth);
      }
     
      $sth=mysql_query("select pid,sid,tpid,tsid,mission,milminister,name,uid,tactic from fleet_info f where f.fid=".$this->fo_id);

      if (!$sth || mysql_num_rows($sth)==0)
      {
	echo("ERR GET FLEET ".$this->fo_id." in flee\n");
	return false;
      }
      
      $fleet=mysql_fetch_assoc($sth);
     
      $sth=mysql_query("insert into fleet_info (pid,sid,tpid,tsid,mission,milminister,name,uid,tactic) values ('".$new_pid."','".$fleet["sid"]."','".$fleet["tpid"]."','".$fleet["tsid"]."','".$fleet["mission"]."','".$fleet["milminister"]."','".$fleet["name"]."','".$fleet["uid"]."','".$fleet["tactic"]."')");

      if (!$sth)
      {
	echo("FLEE KAPUTT ".$this->fo_id."\n");
      }
      $flee_fid=mysql_insert_id();
  
      foreach ($to_flee as $prod_id => $count)
      {
	$sth=mysql_query("insert into fleet set count=".$count.",prod_id=".$prod_id.",fid=".$flee_fid." on duplicate key update count=count+".$count);

	if (!$sth)
	  echo("ERR::INSERT FLEET (FLEE)\n");

	$sth=mysql_query("update fleet set count=count-".$count." where prod_id=".$prod_id." and fid=".$this->fo_id);

	if (!$sth)
	  echo("ERR::UPDATE FLEE FLEET\n");
      }

      foreach ($inf_to_flee as $prod_id => $count)
      {
	$sth=mysql_query("insert into inf_transports set count=".$count.",prod_id=".$prod_id.",fid=".$flee_fid." on duplicate key update count=count+".$count);

	if (!$sth)
	  echo("ERR::INSERT FLEETINF (FLEE)\n");
      }
    }
  }
}
?>
