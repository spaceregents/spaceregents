<?php
class battleinfantery extends battleunit
{
  function battleinfantery($prod_id,$bonus)
  {
    $this->prod_id=$prod_id;

    $sth=mysql_query("select p.name,p.typ,i.attack,i.defense,i.armour,i.initiative,i.tonnage as storage from production p,shipvalues i where p.prod_id=".$prod_id." and i.prod_id=p.prod_id and p.typ='I'");

    if (!$sth || mysql_num_rows($sth)==0)
      throw new SQLException();

    list($name,$type,$attack,$defense,$armor,$initiative,$this->storage)=mysql_fetch_row($sth);

    if (!$this->name)
      $this->name=$name;

    // mop: hmmm...die kampfsysteme sind ja jetzt in einem....irgendwie die komischen infwerte auf neues system anpassen
    $this->agility        =round($defense/10);
    $this->currenthull    =$armor;
    $this->weaponpower    =$attack;
    $this->shield         =round($defense/10);
    $this->ecm            =round($defense/10);
    $this->sensor         =$attack;
    $this->weaponskill    =round($this->attack/2);
    $this->special        ="";
    $this->armor          =$armor;
    $this->base_initiative=$initiative;
    $this->num_attacks    =1;


    // mop: bonus vom admiral
    if ($bonus)
    {
      $this->agility        +=$bonus["agility"];
      $this->base_initiative+=$bonus["initiative"];
      $this->sensor         +=$bonus["sensor"];
      $this->weaponskill    +=$bonus["weaponskill"];
    }

    $this->type=battleunit::typetranslate($type);
    $this->target1=battleunit::typetranslate($type);

    $this->can_attack=UNITTYPE_INFANTERY | UNITTYPE_PLANETAR;

    $this->challenge_points=$this->base_initiative+$this->agility+$this->hull+$this->weaponpower+$this->shield+$this->ecm+$target+$this->sensor+$this->weaponskill+$this->armor;
  }

  function get_storage()
  {
    return $this->storage;
  }
}
?>
