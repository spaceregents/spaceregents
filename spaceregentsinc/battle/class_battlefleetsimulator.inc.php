<?php
class battlefleetsimulator extends battleparticipant
{
  function battlefleetsimulator($uid,$side)
  {
    $this->uid=$side;
    $this->alliance=$side;
    $this->enemies=$side==1 ? array(2) : array(1);
    $this->friends=array();

    $sth=mysql_query("select prod_id,count from battle_".$uid." where side=".$side);

    if (!$sth)
      throw new SQLException();

    while (list($prod_id,$count)=mysql_fetch_row($sth))
    {
      $unit=new battleunitsimulator($uid,$side,$prod_id);

      // mop: das objekt so oft kopieren wie es schiffe gibt
      for ($i=0;$i<$count;$i++)
      {
	$this_unit=clone $unit;
	$this->units=new battleunitcontainer($this_unit,$prev,false);
	if ($prev)
	{
	  $prev->set_next($this->units);
	}
	$prev=$this->units;
	$this->challenge_points+=$this_unit->get_challenge_points();
      }
    }
  }
}
?>
