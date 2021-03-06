<?php
/**
  * class battleparticipant
  * 
  */

class battleparticipant
{
  /**Attributes: */

    /**
      * userid
      */
    var $uid;
    /**
      * taktik
      */
    var $tactic;
    /**
      * unitcontainer
      */
    var $units=false;
    /**
      * zeigt auf das derzeit ausgew�hlte ziel...d.h. auf ein ziel, dass von einer
      * gegnerischen einheit derzeit in dieser gruppe anvisiert ist
      */
    var $target=false;
    /**
      * array der zerst�rten einheiten...werden beim abschluss des kampfes gel�scht.
      */
    var $destroyed_units;

    /** 
     * die abgeladenen einheiten 
     */
    var $unloaded_units=array();

    /** 
     * name...wichtig f�r den report
     */
    var $name;
    
    /**
     * array der feinde
     */
    var $enemies;

    /** 
     * array der freunde
     */
    var $friends;

    /** 
     * allianz
     */
    var $alliance;

    /** 
     * s�mtliche unittypen, die dieser teilnehmer hat
     */
    var $unittypes;

    /** 
     * da werden die units drinn gecached f�r die zuf�llige auswahl von einheiten
     */
    var $unit_cacher;

    /** 
     * abgearbeitete einheiten
     */
    var $handled_units;

    /** 
     * admiral
     */
    var $admiral;

    /** 
     * das schiff wo der admiral drauf is
     */
    var $admiral_unit;

    /** 
     * herausforderungspunkte (f�r die admirals)
     */
    var $challenge_points;

    /** 
     * foreign id (pid,fid etc.)
     */
    var $fo_id;

    /** 
     * die eroberten einheiten
     */
    var $captured_units;
    
    /** 
     * geflohenen einheiten
     */
    var $fled_units;

  /**
    * gibt array der feindlichen uids zur�ck
    */
  function get_enemies( )
  {
    if (!$this->enemies)
    {
      $this->enemies=array();
      
      $sth=mysql_query("select alliance2 from diplomacy where alliance1=".$this->alliance." and status=0");

      if (!$sth)
	return false;

      while (list($this->enemies[])=mysql_fetch_row($sth));
    }

    return $this->enemies;
  }

  function get_friends()
  {
    if (!$this->friends)
    {
      $this->friends=array();
      
      $sth=mysql_query("select alliance2 from diplomacy where alliance1=".$this->alliance." and status=2");

      if (!$sth)
	return false;

      while (list($this->friends[])=mysql_fetch_row($sth));
    }

    return $this->friends;
  }


  /**
    * 
    */
  function get_uid( )
  {
    return $this->uid; 
  }


  /**
    * 
    */
  function get_tactic( )
  {
    return $this->tactic; 
  }


  /**
    * gibt derzeitige einheit zur�ck
    */
  function get_current_unit( )
  {
    if ($this->units)
      return $this->units->get_unit();
    else
      return false;
  }

  function get_num_same_ini()
  {
    $cur_unit=$this->units;
    if ($cur_unit)
      $cur_ini=$cur_unit->get_unit()->get_initiative();
    else
      $cur_ini=0;
   
    $counter=0;

    while ($cur_unit && $cur_unit->get_unit()->get_initiative()==$cur_ini)
    {
      $counter++;
      $cur_unit=$cur_unit->get_next();
    }

    return $counter;
  }


  /**
    * derzeitige einheit hat ihre aktionen ausgef�hrt. ini pointer weitersetzen
    */
  function set_current_handled()
  {
    if (!$this->units->get_next())
      $this->handled_units=clone $this->units;
    $this->units=$this->units->get_next();
  }


  /**
    * holt ein zuf�lliges ziel aus der liste. wenn eins gefunden wurde, dann wird auch
    * der target_pointer gesetzt
    * @param can_attack
    *      welche einheitentypen die einheit �berhaupt angreifen kann
    * @param favorite_type
    *      welchen einheitentyp die einheit am liebsten angreifen w�rde
    */
  function get_random_target($can_attack,$favorite_type)
  {
    // ----------------------------
    if (!is_object($this->unit_cacher) || $this->unit_cacher->can_attack!=$can_attack || $this->unit_cacher->favorite_type!=$favorite_type || sizeof($this->unit_cacher->units)==0)
    {
      $this->unit_cacher                   =new stdClass;
      $this->unit_cacher->can_attack       =$can_attack;
      $this->unit_cacher->favorite_type    =$favorite_type;
      $this->unit_cacher->units=array();

      $comparison=$this->has_unittype($favorite_type) ? $favorite_type : $can_attack;

      $units=false;

      if ($this->units)
      {
	$units=$this->units->begin();
      }
      elseif ($this->handled_units)
      {
	$this->handled_units=$this->handled_units->begin();
	$units=$this->handled_units;
      }
      
      $no_attacks=array();
      while ($units)
      {
        // mop: logischer undvergleich ... 001 & 101 = 1
        //echo("=>".$units->get_unit()->get_unittype()." & ".$comparison." = ".($units->get_unit()->get_unittype() & $comparison)."\n");
	if (!is_object($units->get_unit()))
	  var_dump($units);
	
        if (($units->get_unit()->get_unittype() & $comparison) && $units->get_unit()->get_num_attacks()>0)
          $this->unit_cacher->units[]=$units;
        // mop: probes etc. festhalten
        elseif ($units->get_unit()->get_num_attacks()==0 && ($units->get_unit()->get_unittype() & $comparison))
          $no_attacks[]=$units;
          
	$units=$units->get_next();
      }
    }
    
    // mop: dann probes etc angreifen
    if (sizeof($this->unit_cacher->units)==0)
      $this->unit_cacher->units=$no_attacks;
    
    if (sizeof($this->unit_cacher->units)>0)
    {
      // mop: die zwei zeilen auskommentieren...dann gehts schneller (nur zum debuggen von irgendwas...dadurch wird immer dieselbe)
      //      einheit angegriffen
      srand ((double) microtime() * 10000000);
      shuffle($this->unit_cacher->units);

      $enemy=$this->unit_cacher->units[0];
      $this->target_pointer=$enemy;

      return $enemy->get_unit();
    }
    else
    {
      return false;
    }
  }


  /**
    * ziel wurde abgehandelt....resettet den target_pointer und f�gt das ziel dem
    * destroyed_units array hinzu bei bedarf....
    */
  function set_target_handled($result)
  {
    if ($result==DESTROYED || $result==CAPTURED)
    {
      // mop: jetzt die zerst�rte einheit aus dem cache schmeissen
      $new_cache=array();
      for ($i=0;$i<sizeof($this->unit_cacher->units);$i++)
      {
        if ($this->target_pointer->get_unit()!==$this->unit_cacher->units[$i]->get_unit())
        {
          $new_cache[]=$this->unit_cacher->units[$i];
        }
      }
      $this->unit_cacher->units=$new_cache;
      $this->destroyed_units[]=clone $this->target_pointer->get_unit();
      
      if ($this->target_pointer->get_unit()->has_subunits())
      {
        $sub_units=$this->target_pointer->get_unit()->clean_subunits();
        for ($i=0;$i<sizeof($sub_units);$i++)
          $this->destroyed_units[]=clone $sub_units[$i];
      }
      
      // mop: bah...php5 :S
      if ($this->target_pointer===$this->units)
      {
	if ($this->units->get_next())
	{
	  $this->units=$this->units->get_next();
	  $this->target_pointer->remove();
	}
	elseif ($this->units->get_prev())
	{
	  $this->units=$this->units->get_prev();
          $this->target_pointer->remove();
	}
	else
	{
	  $this->units=false;
	}
      }
      elseif ($this->target_pointer===$this->handled_units)
      {
	if ($this->handled_units->get_next())
	{
	  $this->handled_units=$this->handled_units->get_next();
	  $this->target_pointer->remove();
	}
	elseif ($this->handled_units->get_prev())
	{
	  $this->handled_units=$this->handled_units->get_prev();
          $this->target_pointer->remove();
	}
	else
	{
	  $this->handled_units=false;
	}
      }
      else
      {
        $this->target_pointer->remove();
      }
      
      $this->unittypes[$this->target_pointer->get_unit()->get_unittype()]--;
      
      
      // mop: alt
      //unset($this->unit_cacher->units);
      
      $destroyed=true;
      // mop: ohoh...es is der admiral
      if ($this->admiral_unit===$this->target_pointer->get_unit())
      {
        // mop: eigentlich m�sste es hier jetzt nen malus geben f�r alle...aber das dauert wohl lange, den �berall wieder abzuziehen
	unset($this->admiral_unit);
      }
    }
  
    unset($this->target_pointer);

    return $destroyed;
  }

  /**
    * l�scht die zerst�rten einheiten...virtuelle funktion, da f�r jeden typ anders
    * (planet, schiff etc.)
    */
  function destroy_units( )
  {
    
  }

  /**
    * 
    */
  function get_units( )
  {
    if (!$this->handled_units)
    {
      return array();
    }
    else
    {
      $unitarr=array();
      $units=$this->handled_units->begin();

      while ($units)
      {
	$unitarr[]=$units->get_unit();
	$units=$units->get_next();
      }
      return $unitarr;
    }
  }


  /**
    * 
    */
  function get_destroyed_units( )
  {
    return $this->destroyed_units;
  }

  /**
    *  initialisiert den kampf...berechnet initiative der schiffe und sortiert die units entsprechend
    */ 
  function init_battle()
  {
    if ($this->units)
    {
      $units=$this->units->begin();
    
      while ($units)
      {
	$units->get_unit()->calc_initiative();
	$units=$units->get_next();
      }
  
      $this->units=$this->units->begin();
      $this->units=battleunitcontainer::inisort($this->units);
      $this->units=$this->units->begin();
    }
  }

  function get_alliance()
  {
    if (!$this->alliance)
    {
      $sth=mysql_query("select alliance from users where id=".$this->uid);

      if (!$sth || mysql_num_rows($sth)==0)
	return false;

      list($this->alliance)=mysql_fetch_row($sth);
    }
    return $this->alliance;
  }
  
  function get_unittypes()
  {
    $types=array();
    foreach ($this->unittypes as $key => $value)
    {
      if ($value>0)
	$types[]=$key;
    }
    return $types;
  }

  function check_unittypes()
  {
    $this->unittypes=array();
    
    if ($this->units)
    {
      $unit=$this->units->begin();

      for (;is_object($unit);$unit=$unit->get_next())
      {
	if (!$this->unittypes[$unit->get_unit()->get_unittype()])
	  $this->unittypes[$unit->get_unit()->get_unittype()]=1;
	else
	  $this->unittypes[$unit->get_unit()->get_unittype()]++;
      }
    }
  }

  function has_unittype($unittype)
  {
    return $this->unittypes[$unittype]>0;
  }
  
  function get_challenge_points()
  {
    return $this->challenge_points;
  }

  function get_unitcontainer()
  {
    return $this->units; 
  }
  
  function set_unitcontainer($units)
  {
    return $this->units=$units;
  }

  function get_fo_id()
  {
    return $this->fo_id;
  }

  function capture_unit($unit)
  {
    $this->captured_units[]=clone $unit;
  }
  
  function capture_units()
  {
  }
  
  function flee_units()
  {
  }

  function flee_unit()
  {
    $unit=$this->units;

    $this->fled_units[]=clone $unit->get_unit(); 
    if ($this->units->get_next())
    {
      $this->units=$this->units->get_next();
      $unit->remove();
    }
    elseif ($this->units->get_prev())
    {
      $this->units=$this->units->get_prev();
      $unit->remove();
    }
    else
    {
      $this->units=false;
    }
    $this->unit_cacher=false;

    unset($unit);
  }

  function get_fled_units()
  {
    return $this->fled_units;
  }

  function register_unloaded_units($units)
  {
    foreach ($units as $unit)
      $this->unloaded_units[]=$unit;
  }

  function get_unloaded_units()
  {
    return $this->unloaded_units;
  }
}
?>
