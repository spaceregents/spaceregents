<?
define(COLONIST_BOOST,0x1);

/**********************
*
* function get_production_by_tech($tid)
* function get_fastest_tech_steps($tid,$steps=1)
* function get_max_warp($uid)
*
**********************/


/****************************
*
* function get_production_by_tech($tid)
*
*****************************/
function get_production_by_tech($tid)
{
  $sth=mysql_query("select prod_id,name,manual,typ from production where tech=".$tid);

  if (!$sth)
    return false;

  while (list($prod_id,$name,$manual,$type)=mysql_fetch_row($sth))
  {
    switch ($type)
    {
      case "L":
      case "M":
      case "H":
	$type="S";
	break;
      case "R":
	$type="O";
	break;
    }
    $prod_arr[$type][$prod_id]=array("name"=>$name,"manual"=>$manual);
  }

  $sth=mysql_query("select * from warp as w, tech as t where t.t_id=w.tid and t.t_id=$tid");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)>0)
  {
    $misc=mysql_fetch_array($sth);

    $prod_arr["M"]["dummy"]=array("name"=>"Warp Upgrade ".$misc["range"]);
  }

  if (sizeof($prod_arr)==0)
    return false;

  return $prod_arr;
}



/****************************
*
* function get_fastest_tech_steps($tid,$steps=1)
*
*****************************/
function get_fastest_tech_steps($tid,$steps=1)
{
  $sth=mysql_query("select depend from tech where t_id=$tid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $tech=mysql_fetch_array($sth);

  if ($tech["depend"]!=NULL)
  {
    $steps++;
    $steps=get_fastest_tech_steps($tech["depend"],$steps);
  }

  return $steps;
}


/****************************
*
* get_max_warp($uid)
*
*****************************/
function get_max_warp($uid)
{
  $sth = mysql_query("select max(w.range) from warp as w,research as r where w.tid=r.t_id and r.uid=".$uid);
  
  if ((!$sth) || (!mysql_num_rows($sth)))
  	return 0;
 
  $range = mysql_fetch_row($sth);

  if ($range[0] == NULL)
  {
      global $no_warp_tech;
      $range[0] = $no_warp_tech;
  }
  
  return $range[0];
}

function get_research_queue($uid)
{
  $sth=mysql_query("select queue from research_queue where uid=".$uid);

  if (!$sth)
    return false;

  $queue=array();

  if (mysql_num_rows($sth)>0)
  {
    list($db_queue)=mysql_fetch_row($sth);
    $queue=unserialize($db_queue);
  }

  return $queue;
}

function can_research($uid,$tid)
{
  $sth1=mysql_query("select * from tech where t_id=".$tid." and depend is NULL");

  $sth2=mysql_query("select * from tech as t,research as r where r.t_id=t.excl and t.t_id=".$tid);

  $sth3=mysql_query("select * from tech as t,research as r where t.depend=r.t_id and r.uid=$uid and t.t_id=".$tid);
    
  if (((mysql_num_rows($sth1)>0) or (mysql_num_rows($sth3)>0)) and (mysql_num_rows($sth2)==0))
    return true;
  return false;
}

function save_research_queue($uid,$queue)
{
  $sth=mysql_query("replace into research_queue set uid=".$uid.",queue='".serialize($queue)."'");

  if (!$sth)
    return false;
  return true;
}
?>
