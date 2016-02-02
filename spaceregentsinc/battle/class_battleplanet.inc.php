<?php
/**
  * class battleplanet
  * 
  */

class battleplanet extends battleparticipant
{
  /** 
   * ctor
   * 
   * @param $pid 
   * @return 
   */
  function battleplanet($pid,$uid)
  {
    // mop: eventuell mal generäle? :S
    $this->admiral=false;
    $this->pid=$pid;

    $sth=mysql_query("select name,uid from planets where id=$pid");

    if (!$sth)
    {
      throw new SQLException();
    }

    list($this->name,$owner)=mysql_fetch_row($sth);

    $this->uid=$uid;

    // mop: gebäude nur beim owner hinzufügen
    if ($owner==$uid)
    {
      $sth=mysql_query("select p.prod_id from production p,constructions b,shipvalues s where b.prod_id=p.prod_id and b.prod_id=s.prod_id and b.pid=".$pid);

      if (!$sth)
      {
	throw new SQLException();
      }

      $prev=false;

      while (list($prod_id)=mysql_fetch_row($sth))
      {
	try
	{
	  $building=new battlebuilding($prod_id);
	  $this->units=new battleunitcontainer($building,$prev,false);
	  if ($prev)
	  {
	    $prev->set_next($this->units);
	  }
	  $prev=$this->units;
	}
	catch (Exception $e)
	{
	  echo $e->getMessage();
	}
      }
    }
    
    $sth=mysql_query("select alliance from users where id=".$this->uid);

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    list($this->alliance)=mysql_fetch_row($sth);

    $sth=mysql_query("select prod_id,count from infantery where pid=".$pid." and uid=".$this->uid);

    if (!$sth)
      throw new SQLException();

    while (list($prod_id,$count)=mysql_fetch_row($sth))
    {
      $unit=new battleinfantery($prod_id,array());
      for ($i=0;$i<$count;$i++)
      {
        $this_unit=clone $unit;
        $this->units=new battleunitcontainer($this_unit,$prev,false);
        if ($prev)
        {
          $prev->set_next($this->units);
        }
        $prev=$this->units;
      }
    }

    $this->check_unittypes();

    $this->fo_id=$pid;
  }

  function destroy_units()
  {
    $inf_destroy=array();
    $cst_destroy=array();

    if (is_array($this->destroyed_units))
    {
      foreach ($this->destroyed_units as $unit)
      {
	// Mop: ersma nur inf berücklsichtigen....gebäude später
	if ($unit->get_unittype()==UNITTYPE_INFANTERY)
	{
	  if (!$inf_destroy[$unit->get_prod_id()])
	    $inf_destroy[$unit->get_prod_id()]=0;

	  $inf_destroy[$unit->get_prod_id()]++;

	  if ($unit->has_subunits())
	  {
	    print "ja\n";
	    $unit->destroy_subunits(); 
	  }
	}
	else
	{
	  $cst_destroy[]=$unit->get_prod_id();
	}
      }
    }

    foreach ($inf_destroy as $prod_id => $count)
    {
      $sth=mysql_query("update infantery set count=count-".$count." where pid=".$this->fo_id." and prod_id=".$prod_id." and uid=".$this->uid);
    }

    foreach ($cst_destroy as $prod_id)
    {
      $sth=mysql_query("delete from constructions where pid=".$this->fo_id." and prod_id=".$prod_id);

      if (!$sth)
	echo("ERR::DEL BUILDING ".$prod_id);
    }
  }
}
?>
