<?php
class battleunitsimulator extends battleunit
{
  function battleunitsimulator($uid,$side,$prod_id)
  {
    $this->fo_id=$side;
    $this->prod_id=$prod_id;

    $sth=mysql_query("select p.name,p.typ,s.initiative,s.agility,s.hull,s.weaponpower,s.shield,s.ecm,s.target1,s.sensor,s.weaponskill,s.special,s.armor,s.num_attacks from battle_".$uid." s, production p where s.prod_id=".$prod_id." and s.prod_id=p.prod_id and s.side=".$side);

    if (!$sth || mysql_num_rows($sth)==0)
      return false;
    
    list($this->name,$type,$this->base_initiative,$this->agility,$this->currenthull,$this->weaponpower,$this->shield,$this->ecm,$target,$this->sensor,$this->weaponskill,$this->special,$this->armor,$this->num_attacks)=mysql_fetch_row($sth);

    $this->target1=battleunit::typetranslate($target);
    $this->type=battleunit::typetranslate($type);

    $this->currentshield=$this->shield;
    
    // mop: super bitoperatoren....da steht dann bei schiffen 0111 drinn....bei planetaren (0x8) 1000...schneller als arrays
    $this->can_attack=UNITTYPE_LIGHTSHIP | UNITTYPE_MEDIUMSHIP | UNITTYPE_HEAVYSHIP | UNITTYPE_PLANETAR | UNITTYPE_ORBITAL | UNITTYPE_INFANTERY;

    $this->challenge_points=$this->base_initiative+$this->agility+$this->currenthull+$this->weaponpower+$this->shield+$this->ecm+$target+$this->sensor+$this->weaponskill+$this->armor;
  }
}
?>
