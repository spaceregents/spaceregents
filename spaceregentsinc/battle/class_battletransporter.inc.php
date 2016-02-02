<?php
class battletransporter extends battleship
{
  /** 
   * nur bei transportern
   */
  var $storage;

  /** 
   * kanner unloaden?
   */
  var $can_unload;

  var $uid;

  var $planet;
 
  function battletransporter($prod_id,$fid,$bonus,$planet,$uid,$alliance,$enemies,$friends,$invade)
  {
    parent::battleship($prod_id,$fid,$bonus);
    $this->planet=$planet;
    $this->uid=$uid;

    $sth=mysql_query("select storage from inf_transporters where prod_id=".$prod_id);

    if (!$sth || mysql_num_rows($sth)==0)
      throw new SQLException();

    list($this->storage)=mysql_fetch_row($sth);
    
    $this->can_unload=false;

    if ($planet)
    {
      // mop: freunde, feinde und mitglieder der allianz wollen/können einheiten auf den planeten transferieren
      if ((in_array($planet->get_alliance(),$enemies) && $invade) || in_array($planet->get_alliance(),$friends) || $alliance==$planet->get_alliance())
      {
	$this->can_unload=true;
      }
      else
      {
	$this->can_unload=false;
      }
    }
  }
  
  function get_storage()
  {
    return $this->storage;
  }

  function assign_infantery($inf_unit)
  {
    if ($inf_unit->get_storage()<=$this->storage)
    {
      $this->storage-=$inf_unit->get_storage();
      $this->subunits[]=$inf_unit;
      return true;
    }
    else
    {
      return false;
    }
  }

  function can_unload()
  {
    return $this->can_unload;
  }

  function destroy_subunits()
  {
    $to_destroy=array();

    $sub_units=$this->get_subunits();

    if (is_array($sub_units))
    {
      foreach ($sub_units as $unit)
      {
	if (!$to_destroy[$unit->get_prod_id()])
	  $to_destroy[$unit->get_prod_id()]=0;

	$to_destroy[$unit->get_prod_id()]++;
      }
    }

    foreach ($to_destroy as $prod_id => $count)
    {
      $sth=mysql_query("update inf_transports set count=count-".$count." where fid=".$this->fo_id." and prod_id=".$prod_id);

      mysql_query("==============>JA");
    }
  }
    
  function has_subunits()
  {
    return is_array($this->subunits);
  }
}
?>
