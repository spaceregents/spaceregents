<?php
class battleunitcontainer
{
  /** 
   * die einheit, die der container erfasst
   */
  var $unit;

  /** 
   * die vorherige einheit
   */
  var $prev=false;

  /** 
   * nächste einheit
   */
  var $next=false;

  function battleunitcontainer($unit,$prev,$next)
  {
    $this->unit=$unit;
    $this->prev=$prev;
    $this->next=$next;
  }

  function get_prev()
  {
    return $this->prev;
  }

  function get_next()
  {
    return $this->next;
  }

  function get_unit()
  {
    return $this->unit;
  }

  function set_prev($prev)
  {
    $this->prev=$prev;
  }
  
  function set_next($next)
  {
    $this->next=$next;
  }

  function begin()
  {
    $current=$this;
    $prev=$current->get_prev();
  
    while ($prev)
    {
      $current=$prev;
      $prev=$current->get_prev();
    }
    return $current;
  }

  function inisort($units)
  {
    while ($units)
    {
      $unit_arr[$units->get_unit()->get_initiative()][]=$units->get_unit();
      $units=$units->get_next();
    }

    $prev=false;
   
    krsort($unit_arr);
   
    foreach ($unit_arr as $initiative => $unitlist)
    {
      for ($i=0;$i<sizeof($unitlist);$i++)
      {
	$new_units=new battleunitcontainer($unitlist[$i],$prev,false);
	if ($prev)
	{
	  $prev->set_next($new_units);
	}
	$prev=$new_units;
      }
    }

    return $new_units;
  }

  function remove()
  {
    if (is_object($this->prev))
    {
      $this->prev->set_next($this->next);
    }
    
    if (is_object($this->next))
    {
      $this->next->set_prev($this->prev);
    }
  }

  function find_lower_ini($units,$ini)
  {
    $current=$units->get_next();

    if (!$current || $current->get_unit()->get_initiative()<=$ini)
      return $current;
    else
      $current=$current->get_next();
  }

  /*function __destruct()
  {
    echo("SHWUP\n");
  }*/
}
?>
