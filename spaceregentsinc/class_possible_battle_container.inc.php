<?
class possible_battle_container
{
  var $sid;
  var $pid;
  var $fleets;

  function find_intercepting_uid()
  {
    reset ($this->fleets);

    while (list($uid,$fleets)=each($this->fleets))
    {
      for ($j=0;$j<sizeof($fleets);$i++)
      {
	if ($fleets[$j]["mission"]==2)
	  return $uid;
      }
    }
  }
}
?>
