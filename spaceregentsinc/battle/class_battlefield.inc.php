<?php
/**
  * class battlefield
  * 
  */

class battlefield
{
  /**Attributes: */

    /**
      * array der Teilnehmer
      */
    var $participants;

    /** 
     * planetenid
     */
    var $pid;

    /** 
     * systemid
     */
    var $sid;

    /** 
     * initiative ränge
     */
    var $ini_rank;

    /** 
     * feindcacher
     */
    var $enemy_cacher;

    /** 
     * ok
     */
    var $battle_counter=0;

    /** 
     * punkte pro feind
     */
    var $challenge_points;

    /** 
     * hat ne invasion stattgefunden?
     */
    var $invasion=false;

    /** 
     * zerstörungscount
     */
    var $destroyed;

  /** 
   * ctor
   * 
   * @param $pid,$sid 
   */
  function battlefield($sid,$pid)
  {
    $this->pid=$pid;
    $this->sid=$sid;
    
    $this->ini_rank=array();
    
    if (SIMULATION_MODE)
    {
      try
      {
	$participant=new battlefleetsimulator($GLOBALS["sim_uid"],1);
	$this->challenge_points[1]+=$participant->get_challenge_points();
	$this->participants[]=$participant;
      }
      catch (Exception $e)
      {
	echo $e->getMessage();
      }
      
      try
      {
	$participant=new battlefleetsimulator($GLOBALS["sim_uid"],2);
	$this->challenge_points[1]+=$participant->get_challenge_points();
	$this->participants[]=$participant;
      }
      catch (Exception $e)
      {
	echo $e->getMessage();
      }
    }
    else
    {
      $planet=false;

      $sth=mysql_query("select uid from planets where id=$pid and sid=$sid and uid!=0");

      if (!$sth)
	return false;

      if (mysql_num_rows($sth)>0)
      {
	/** 
	 * eigentümer sichern...
	 */
	list($owner)=mysql_fetch_row($sth);

	try
	{
	  $planet=new battleplanet($pid,$owner);
	  $this->challenge_points[$planet->get_alliance()]+=$planet->get_challenge_points();
	  $this->participants[]=$planet;
	}
	catch (Exception $e)
	{
	  echo $e->getMessage();
	}
	/** 
	 * mop: alle infantry, die nicht dem owner gehört muss auch kämpfen...
	 */
	$sth=mysql_query("select distinct uid from infantery where uid!=".$owner." and pid=".$pid);

	if (!$sth)
	  throw new SQLException();

	while (list($uid)=mysql_fetch_row($sth))
	{
	  try
	  {
	    $planet=new battleplanet($pid,$uid);
	    $this->challenge_points[$planet->get_alliance()]+=$planet->get_challenge_points();
	    $this->participants[]=$planet;
	  }
	  catch (Exception $e)
	  {
	    echo $e->getMessage();
	  }
	}
      }


      // mop: erstmal alle flotten und uids holen...
      $sth=mysql_query("select f.fid from fleet_info f where pid=$pid and sid=$sid");

      if (!$sth)
	return false;

      while (list($fid)=mysql_fetch_row($sth))
      {
	try
	{
	  $participant=new battlefleet($fid,$planet);
	  $this->challenge_points[$participant->get_alliance()]+=$participant->get_challenge_points();
	  $this->participants[]=$participant;
	}
	catch (Exception $e)
	{
	  echo $e->getMessage();
	}
      }
    }
  }

  /**
    * führt den kampf aus zentrale steuerungsmethode
    */
  function execute_battle( )
  {
    for ($i=0;$i<sizeof($this->participants);$i++)
      $this->participants[$i]->init_battle();
    
    for ($participant_idx=$this->get_next_participant();$participant_idx!==false;$participant_idx=$this->get_next_participant())
    {
      $this->do_actions($participant_idx);
    }
    
    for ($i=0;$i<sizeof($this->participants);$i++)
    {
      // mop: admiral is tot
      if ($this->participants[$i]->admiral && !$this->participants[$i]->admiral_unit)
      {
	if (BATTLE_DESTROY)
	  $sth=mysql_query("delete from admirals where id=".$this->participants[$i]->admiral->id);
      }
      elseif ($this->participants[$i]->admiral)
      {
	// mop: ersma auf stdValue setzen
	$this->participants[$i]->admiral->newvalue=$this->participants[$i]->admiral->value;
	
	$enemies=$this->participants[$i]->get_enemies();
	
	for ($j=0;$j<sizeof($enemies);$j++)
	{
	  $this->participants[$i]->admiral->newvalue+=$this->challenge_points[$enemies[$j]];
	}

	$sth=mysql_query("update admirals set value=".$this->participants[$i]->admiral->newvalue." where id=".$this->participants[$i]->admiral->id);
      }
    }
    
    echo($this->battle_counter." Aktionen ausgeführt!!\n");
  }


  /**
    * gibt alle teilnehmer zurück
    */
  function get_participants( )
  {
    return $this->participants;  
  }


  /**
    * löscht alle einen in der db
    */
  function destroy_units( )
  {
    for ($i=0;$i<sizeof($this->participants);$i++)
      $this->participants[$i]->destroy_units();
  }
  
  function capture_units( )
  {
    for ($i=0;$i<sizeof($this->participants);$i++)
      $this->participants[$i]->capture_units();
  }
  
  function flee_units( )
  {
    for ($i=0;$i<sizeof($this->participants);$i++)
      $this->participants[$i]->flee_units();
  }

  /**
    * holt den nächste teilnehmer in der ini reihenfolge aller teilnehmer
    */
  function get_next_participant( )
  {
    if (sizeof($this->ini_rank)==0)
    {
      for ($i=0;$i<sizeof($this->participants);$i++)
      {
        if ($this->participants[$i]->get_current_unit())
        {
          $current_unit=$this->participants[$i]->get_current_unit();

          if (sizeof($this->ini_rank)==0)
          {
            $count_same_ini=$this->participants[$i]->get_num_same_ini();
            $this->ini_rank=array();

            for ($j=0;$j<$count_same_ini;$j++)
              $this->ini_rank[]=$i;

            $last_unit=$current_unit;
          }
          // mop: eintrag hinzufügen
          elseif ($last_unit->get_initiative()==$current_unit->get_initiative())
          {
            $count_same_ini=$this->participants[$i]->get_num_same_ini();

            for ($j=0;$j<$count_same_ini;$j++)
              $this->ini_rank[]=$i;

            $last_unit=$current_unit;
          }
          // mop: array neumachen und damit die bisherigen kicken
          elseif ($last_unit->get_initiative()<$current_unit->get_initiative())
          {
            $count_same_ini=$this->participants[$i]->get_num_same_ini();
            $this->ini_rank=array();

            for ($j=0;$j<$count_same_ini;$j++)
              $this->ini_rank[]=$i;

            $last_unit=$current_unit;
          }
        }
      }

      /*for ($i=0;$i<sizeof($inis);$i++)
        echo($inis[$i]." ");
        echo("\n"); */

      srand ((double) microtime() * 10000000);

      shuffle($this->ini_rank);
    }

    // mop: so jetzt haben wir ein feines array mit leuten, die alle die gleiche ini haben
    if (sizeof($this->ini_rank)>0)
      return array_pop($this->ini_rank);
    else
      return false;
  }


  /**
   * sucht einen zufälligen feind eines teilnehmers
   * @param enemies
   *     	mögliche feinde 
   * @param can_attack
   * 		was für einheiten das vieh angreifen kann
   */
  function get_random_enemy($idx,&$enemy_idx,$can_attack,$want_attack)
  {
    if (!is_object($this->enemy_cacher[$idx]))
    {
      $this->enemy_cacher[$idx]                   =new stdClass;
      $this->enemy_cacher[$idx]->enemies          =array();

      foreach ($this->participants as $key => $participant)
      {
        // mop: wenn feind dann in die auswahl mit einbeziehen
	if (in_array($participant->get_alliance(),$this->participants[$idx]->get_enemies()))
	{
	  $this->enemy_cacher[$idx]->enemies[]=$key;
	}
      }
    }

    $enemy=false;

    shuffle($this->enemy_cacher[$idx]->enemies);

    reset($this->enemy_cacher[$idx]->enemies);
    
    $bah=microtime();
    // mop: enemy idx is ne referenz
    for ($eidx=current($this->enemy_cacher[$idx]->enemies);$eidx!==false && !$enemy;$eidx=next($this->enemy_cacher[$idx]->enemies))
    {
      $enemy_idx=$eidx;
      $enemy=$this->participants[$enemy_idx]->get_random_target($can_attack,$want_attack);
    }

    return $enemy;
  }


  /**
   * führt die aktionen einer unit aus
   * @param unit
   *      
   */
  function do_actions($participant_idx)
  {
    $this->battle_counter++;
    $unit=&$this->participants[$participant_idx]->get_current_unit();

    if (!is_object($unit))
    {
      echo("IDX was ".$participant_idx."\n");
      var_dump($this->participants[$participant_idx]->units);
    }
    
    if ($unit->get_currenthull()>0)
    {
      $remove=false;
      
      $tactic=$this->participants[$participant_idx]->get_tactic();

      if ($tactic & TAC_SCOUT)
      {
	$this->participants[$participant_idx]->flee_unit();
	$this->ini_rank=array();
	return;
      }
      elseif (($tactic & TAC_FLEE25) && $this->participants[$participant_idx]->get_destroyed_units() && (sizeof($this->participants[$participant_idx]->get_destroyed_units())/$this->participants[$participant_idx]->total_count>0.25))
      {
	$this->participants[$participant_idx]->flee_unit();
	$this->ini_rank=array();
	return;
      }
      elseif (($tactic & TAC_FLEE50) && $this->participants[$participant_idx]->get_destroyed_units() && (sizeof($this->participants[$participant_idx]->get_destroyed_units())/$this->participants[$participant_idx]->total_count>0.50))
      {
	$this->participants[$participant_idx]->flee_unit();
	$this->ini_rank=array();
	return;
      }
      elseif (($tactic & TAC_FLEE75) && $this->participants[$participant_idx]->get_destroyed_units() && (sizeof($this->participants[$participant_idx]->get_destroyed_units())/$this->participants[$participant_idx]->total_count>0.75))
      {
	$this->participants[$participant_idx]->flee_unit();
	$this->ini_rank=array();
	return;
      }
      // mop: transporter etc. greifen nicht an, sondern laden ihre truppen ab, sofern sie können
      elseif ($unit->has_subunits() && $unit->can_unload())
      {
	$unloaded_units=$unit->unload();
        $this->participants[$participant_idx]->register_unloaded_units($unloaded_units);
      }
      else
      {
	for ($i=0;$i<$unit->get_num_attacks();$i++)
	{
	  $enemy_unit=&$this->get_random_enemy($participant_idx,$enemy,$unit->can_attack(),$unit->fav_target());

	  if ($enemy_unit!==false)
	  {
	    $result=$unit->attack($enemy_unit);

	    if ($result==CAPTURED)
	    {
	      $this->participants[$participant_idx]->capture_unit($enemy_unit);
	    }

	    // mop: das muss schlauer werden
	    if ($this->participants[$enemy]->set_target_handled($result))
	    {
              if ($enemy_unit->get_initiative()==$unit->get_initiative())
	        $this->ini_rank=array();
	      $this->destroyed[$enemy]++;
	    }
	  }
	}
      }
    }
    $this->participants[$participant_idx]->set_current_handled();
  }

  function get_name()
  {
    $location=get_systemname($this->sid);
    if ($this->pid)
      $location.=" (Orbit of ".get_planetname($this->pid).")";
    return $location;
  }

  function set_invasion($invader)
  {
    $this->invasion=$invader;
  }

  function get_invasion()
  {
    return $this->invasion;
  }
}
?>
