<?php
/**
  * class battleunit
  * 
  */

/******************************* Abstract Class ****************************
  battleunit does not have any pure virtual methods, but its author
  defined it as an abstract class, so you should not use it directly.
  Inherit from it instead and create only objects from the derived classes
*****************************************************************************/

class battleunit
{
  /**Attributes: */

    /**
      * 
      */
    var $type;
    /**
      * 
      */
    var $initiative;
    /**
      * 
      */
    var $base_initiative;
    /**
      * 
      */
    var $name;
  
    var $currenthull;
    var $armor;
    var $agility;
    var $shield;
    var $currentshield;
    var $weaponpower;
    var $weaponskill;
    var $ecm;
    var $target1;
    var $sensor;
    var $special;

    var $can_attack;

    var $prod_id;

    /** 
     * wertigkeit für admiral
     */
    var $challenge_points;

    /** 
     * transportierte einheiten etc...barracks, carrier transporter...
     */
    var $subunits;

    /** 
     * foreign id
     */
    var $fo_id;

    var $num_attacks;

  // mop: evtl doch die konstruktoren allgemeingültig machen....
  //      zB mit ner MERGE table für shipvalues etc
  /*function battleunit($prod_id)
  {
  }*/

  /**
    * 
    * @param target
    *      
    */
  function attack( $unit )
  {
    mt_srand((double) microtime() * 10000000);

    if ($unit->ecm<=0)
      $ecm=0;
    else
      $ecm=mt_rand(0,$unit->ecm);

    if ($this->sensor<=0)
      $sensor=0;
    else
      $sensor=mt_rand(0,$this->sensor);

    if ($ecm<=$sensor)
    {
      if ($this->weaponskill<=0)
	$weaponskill=0;
      else
	$weaponskill=mt_rand(0,$this->weaponskill);
      
      // mop: wenn ziel nicht dem lieblingsgegner entsprecht, dann hat das schiff nur 1/4 seiner schlagkraft
      if ($this->target1!=$unit->get_unittype())
	$modifier=0.25;
      else
	$modifier=1;
     
      $destroyed=$unit->hit(((1000-(100-$weaponskill*$modifier))*$this->weaponpower*$modifier)/100); // damage
    }
    
    if ($destroyed)
    {
      if ($this->special=="R")
	return CAPTURED;
      elseif ($this->special=="E")
	return DISABLED;
      else
	return DESTROYED;
    }
    else
    {
      return false;
    }
  }
  
  function hit($damage)
  {
    // wird die einheit durch ihre agility vielleicht an einer nich ganz so empfindlichen stelle getroffen?

    mt_srand((double) microtime() * 10000000);

    if ($this->agility>0)
      $damage=$damage*((100-mt_rand(0,$this->agility))/100);

    if ($damage<=0)
      return false;
    
    if ($this->shield>0)
      $damage=$this->do_shield_damage($damage);
    
    if (($damage>0) && ($this->armor>0))
      $damage=$this->do_armor_damage($damage);

    if ($damage>0)
      $damage=$this->do_hull_damage($damage);

    if ($damage>0)
      return true;

    return false;
  }

  function do_shield_damage($damage)
  {
    if ($this->currentshield<$this->shield)
    {
      mt_srand((double) microtime() * 10000000);

      $this->currentshield=$this->currentshield+(mt_rand(0,10*$this->shield/100));

      // wenner mehr zurückbekommen hat als er haben dürfte auf die originalgrösse setzen

      if ($this->currentshield>$this->shield)
	$this->currentshield=$this->shield;
    }

    $rem_damage=$damage-$this->currentshield;

    if ($rem_damage>0)
    {
      $this->currentshield=0;
      return $rem_damage;
    }
    else
    {
      $this->currentshield=$this->currentshield-$damage;
      return 0;
    }

    return $rem_damage;
  }

  function do_armor_damage($damage)
  {
    $rem_damage=$damage-$this->armor;

    if ($rem_damage>0)
    {
      $this->armor=0;
      return $rem_damage;
    }
    else
    {
      $this->armor=$this->armor-$damage;
      return 0;
    }
    return $rem_damage; //fedja
  }

  function do_hull_damage($damage)
  {
    $rem_damage=$damage-$this->currenthull;

    if ($rem_damage>0)
    {
      $this->currenthull=-1;
      return 1; // Wenn die damage eh grösser ist als es da schiff verkraften könnte direkt zurückspringen und zerstören
    }
      
    $this->currenthull-=$damage;

    // Jetzt nen paar schiffssysteme zerstören:) is zwar eh zu langsam, aber wer weiss:D

    // schiffssysteme definieren

    $systems=array(0=>"sensors",1=>"ecm",2=>"agility",3=>"weaponskill",4=>"weaponpower");

    mt_srand((double) microtime() * 10000000);

    // betroffenes system finden

    $aff_system=mt_rand(0,(sizeof($systems)-1));

    $this->$aff_system=($this->$aff_system-mt_rand(0,100));

    // System mehr zerstört als möglich?
    
    if ($this->$aff_system<0)
      $this->$aff_system=0;

    return $rem_damage;
  }


  /**
    * 
    */
  function calc_initiative($max=false)
  {
    mt_srand((double) microtime() * 10000000);

    $this->initiative=$this->base_initiative+mt_rand(0,100);

    if ($max && $max<$this->initiative) // wozu fedja
      $this->initiative=$max;           //
  }


  /**
    * 
    */
  function get_initiative( )
  {
    return $this->initiative;    
  }

  function set_initiative($ini)
  {
    $this->initiative=$ini;
  }


  /**
    * 
    */
  function get_name( )
  {
    return $this->name; 
  }


  /**
    * 
    * @param type
    *      
    */
  function can_attack()
  {
    return $this->can_attack; 
  }

  function fav_target()
  {
    return $this->target1;
  }

  function get_unittype()
  {
    return $this->type;
  }

  function get_currenthull()
  {
    return $this->currenthull;
  }

  function get_prod_id()
  {
    return $this->prod_id;
  }

  function typetranslate($type)
  {
    switch ($type)
    {
      case "L":
	return UNITTYPE_LIGHTSHIP;
      case "M":
	return UNITTYPE_MEDIUMSHIP;
      case "H":
	return UNITTYPE_HEAVYSHIP;
      case "P":
	return UNITTYPE_PLANETAR;
      case "O":
      // mop: Tradestation
      case "R":
	return UNITTYPE_ORBITAL;
      // mop: unterscheidung im kampfsystem erscheint sinnlos
      case "I":
      case "V":
	return UNITTYPE_INFANTERY;
    }
  }

  function get_challenge_points()
  {
    return $this->challenge_points;
  }

  function has_subunits()
  {
    return false;
  }

  function get_subunits()
  {
    return $this->subunits;
  }

  function unload()
  {
    if ($this->has_subunits())
    {
      for ($i=0;$i<sizeof($this->subunits);$i++)
      {
	$to_unload[$this->subunits[$i]->get_prod_id()]++;
      }
    
      foreach ($to_unload as $prod_id => $count)
      {
	$sth=mysql_query("insert into infantery set prod_id=".$prod_id.",pid=".$this->planet->get_fo_id().",uid=".$this->uid.",count=".$count." on duplicate key update count=count+".$count);

	if (!$sth)
	  return false;
	
	$sth=mysql_query("update inf_transports set count=count-".$count." where prod_id=".$prod_id." and fid=".$this->fo_id);

	if (!$sth)
	  return false;
      }
      $subunits=$this->subunits;
      $this->subunits=false;
      return $subunits;
    }
    return false;
  }

  function get_fo_id()
  {
    return $this->fo_id;
  }

  function set_name($name)
  {
    $this->name=$name;
  }

  function get_special()
  {
    return $this->special;
  }

  function get_num_attacks()
  {
    return $this->num_attacks;
  }

  function clean_subunits()
  {
    $subunits=$this->get_subunits();
    $this->subunits=false;
    return $subunits;
  }
}
?>
