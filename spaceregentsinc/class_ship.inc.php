<?
class ship extends unit
{
  var $fid;
  var $prod_id;
  var $uid;
  var $side;
  var $has_admiral;

  // die wichtigsten sachen kommen aus der class unit und werden vererbt

  function ship($prod_id,$fid,$uid,$side)
  {
    $sth=mysql_query("select s.hull,s.armor,s.agility,s.shield,s.weaponpower,s.weaponskill,s.initiative,s.ecm,s.target1,s.sensor,s.special,s.num_attacks from shipvalues as s where s.prod_id=$prod_id");

    if ((!$sth) || (mysql_num_rows($sth)==0))
    {
      echo("Database failure!");
      return false;
    }

    $ship=mysql_fetch_array($sth);

    $this->prod_id=$prod_id;
    $this->fid=$fid;
    $this->uid=$uid;
    $this->side=$side;

    // diese eigenschaften sind in class_unit definiert

    $this->hull=$ship["hull"];
    $this->currenthull=$ship["hull"];
    $this->armor=$ship["armor"];
    $this->agility=$ship["agility"];
    $this->shield=$ship["shield"];
    $this->currentshield=$ship["shield"];
    $this->weaponpower=$ship["weaponpower"];
    $this->weaponskill=$ship["weaponskill"];
    $this->initiative=$ship["initiative"];
    $this->ecm=$ship["ecm"];
    $this->target1=$ship["target1"];
    $this->sensor=$ship["sensor"];
    $this->special=$ship["special"];

    $this->has_admiral=false;

  }

  function destroy()
  {
    $sth=mysql_query("update fleet set count=count-1 where prod_id=".$this->prod_id." and fid=".$this->fid);

    if (!$sth)
    {
      echo("Database failure!");
      return false;
    }
  }
}
?>
