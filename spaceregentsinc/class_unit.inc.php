<?
class unit
{
  var $hull;
  var $currenthull;
  var $armor;
  var $agility;
  var $shield;
  var $currentshield;
  var $weaponpower;
  var $weaponskill;
  var $initiative;
  var $ecm;
  var $target1;
  var $sensor;
  var $special;
  var $current_ini;
  var $b_order_idx;
 
  function unit($prod_id)
  {
    // Konstruktor muss von der eigebntlichen klasse definiert werden
    // reichlich sinnlos sonst
  }

  function get_initiative()
  {
    mt_srand((double) microtime() * 10000000);

    $this->current_ini=$this->initiative+mt_rand(0,100);

    return ($this->current_ini);
  }

  function attack($unit) // ein anderes unit objekt
  {
    mt_srand((double) microtime() * 10000000);

    if ($unit->ecm==0)
      $ecm=0;
    else
      $ecm=mt_rand(0,$unit->ecm);

    if ($this->sensor==0)
      $sensor=0;
    else
      $sensor=mt_rand(0,$this->sensor);

    if ($ecm<=$sensor)
    {
      if ($this->weaponskill==0)
	$weaponskill=0;
      else
	$weaponskill=mt_rand(0,$this->weaponskill);

      $destroyed=$unit->hit(((1000-(100-$weaponskill))*$this->weaponpower)/100); // damage
    }

    return $destroyed; // returnt ob ziel zerstört wurde
  }

  function hit($damage)
  {
    // wird die einheit durch ihre agility vielleicht an einer nich ganz so empfindlichen stelle getroffen?

    mt_srand((double) microtime() * 10000000);

    if ($this->agility>0)
      $damage=$damage*((100-mt_rand(0,$this->agility))/100);

    if ($damage<=0)
      return 0;

    if ($this->shield>0)
      $damage=$this->do_shield_damage($damage);
    
    if (($damage>0) && ($this->armor>0))
      $damage=$this->do_armor_damage($damage);

    if ($damage>0)
      $damage=$this->do_hull_damage($damage);

    if ($damage>0)
    {
      return true;
    }

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

    $damage=$damage-$this->currentshield;

    if ($damage>0)
    {
      $this->currentshield=0;
      return $damage;
    }
    else
    {
      $this->currentshield=$this->currentshield-$damage;
      return 0;
    }
  }

  function do_armor_damage($damage)
  {
    $damage=$damage-$this->armor;

    if ($damage>0)
    {
      $this->armor=0;
      return $damage;
    }
    else
    {
      $this->armor=$this->armor-$damage;
      return 0;
    }
  }

  function do_hull_damage($damage)
  {
    $damage=$damage-$this->currenthull;

    if ($damage>0)
      return 1; // Wenn die damage eh grösser ist als es da schiff verkraften könnte direkt zurückspringen und zerstören
      
    $this->currenthull=$this->currenthull-$damage;

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

    return $damage;
  }

  function destroy()
  {
    // den ganzen quatsch in der db löschen
    // logischweise muss diese funktion überschreiben werden.
  }

  function is_active()
  {
    return true;
  }

  function is_building()
  {
    return false;
  }
}
?>
