<?
/************************
*
* get_production_type($prod_id)
*
* get_sorted_prod_ids_by_type($typ)
*
* get_name_by_prod_id($prod_id)
*
* get_description($prod_id)
*
* get_pproduction_count($pid)
*
* next_in_queue($qtyp,$pid)
*
* has_ressources($uid,$prod_id)
*
* get_prodid_by_special($special)
*
* get_construction_list($pid)
*
* get_special_buildings_by_sid($sid, $type = 0)
*
* get_jumpgate_max_tonnage($prod_id)
*
* get_jumpgate_used_tonnage($pid)
*
* get_jumpgate_reload($prodid)
*
* get_pic($prodid)
*
* get_buildings_sense($prod_id, $pid)
*
* get_sound($prod_id)
*
*************************/

function get_production_type($prod_id)
{
  $sth=mysql_query("select typ from production where prod_id=$prod_id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
      return 0;

  $typ=mysql_fetch_row($sth);

  return $typ[0];
}

function get_sorted_prod_ids_by_type($typ)
{
  $sth=mysql_query("select prod_id from production where typ='".$typ."' order by name");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  while ($prod_id=mysql_fetch_row($sth))
  {
    $sorted[]=$prod_id[0];
  }

  return $sorted;
}

function get_name_by_prod_id($prod_id)
{
  $sth=mysql_query("select name from production where prod_id=$prod_id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  $name=mysql_fetch_row($sth);

  return $name[0];
}

function get_description($prod_id)
{
  $sth=mysql_query("select description from production where prod_id=$prod_id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  $description=mysql_fetch_row($sth);

  return $description[0];
}

function get_pproduction_count($pid)
{
  $sth=mysql_query("select max(pos) from p_production where planet_id=$pid");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)==0)
    return 0;

  $count=mysql_fetch_row($sth);

  return $count[0];
}

// qtyp=0 => orbital, 1 => planetar

function next_in_queue($qtyp,$pid)
{
  switch ($qtyp)
  {
    case 0:
      $tab="o_production";
      break;
    case 1:
      $tab="p_production";
      break;
  }

  $sth=mysql_query("select prod_id from $tab where planet_id=$pid order by pos ASC limit 1");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $prod_id=mysql_fetch_row($sth);

  return $prod_id[0];
}

/*
* Hat der mensch genügend ressourcen für ein produkt?
*/
function has_ressources($uid,$prod_id)
{
  $sth=mysql_query("select metal,energy,mopgas,erkunum,gortium,susebloom from ressources where uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($metal,$energy,$mopgas,$erkunum,$gortium,$susebloom)=mysql_fetch_row($sth);

  $sth=mysql_query("select prod_id from production where metal<=$metal and energy<=$energy and mopgas<=$mopgas and erkunum<=$erkunum and gortium<=$gortium and susebloom<=$susebloom and prod_id=$prod_id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  return true;
}

function get_prodid_by_special($special)
{
  $sth=mysql_query("select prod_id from production where special=$special");

  if (!$sth)
    return false;
    
  $prod_ids=array();
  
  while (list($prod_id)=mysql_fetch_row($sth))
  {
    $prod_ids[]=$prod_id;
  }

  return $prod_ids;
}

// holt komplette construction list eines planetens

function get_construction_list($pid)
{
  $sth=mysql_query("select prod_id from constructions where pid=$pid");

  if (!$sth)
    return false;
  
  $prod_ids=array();
  while (list($prod_id)=mysql_fetch_row($sth))
  {
    $prod_ids[]=$prod_id;
  }

  return $prod_ids;
}



/******************
*
*  get_special_buildings_by_sid($sid, $type = 0)
*
******************/
function get_special_buildings_by_sid($sid, $type = 0)
{
  // type 0:
  // S = Jumpgate
  // U = Tradingstation
  // type 1:
  // wie type 0 +
  // F = Orbital Refueling Station

  $planets = get_planets_by_sid($sid);

  if (is_array($planets))
  {
    if ($type == 0)
    {
      for ($i = 0; $i < sizeof($planets); $i++)
      {
        $sth = mysql_query("select p.special, o.pid from constructions as o, production as p where o.pid=".$planets[$i]." and o.prod_id = p.prod_id and (p.special = 'S' or p.special = 'U')");

        if (!$sth)
          return 0;

        $j = 0;
        while ($specials = mysql_fetch_array($sth))
        {
          $specials_array[$j][special] = $specials["special"];
          $specials_array[$j][pid] = $specials["pid"];
          $j++;
        }
      }
      return $specials_array;
    }
    else
    {
      for ($i = 0; $i < sizeof($planets); $i++)
      {
        $sth = mysql_query("select p.special, o.pid from constructions as o, production as p where o.pid=".$planets[$i]." and o.prod_id = p.prod_id and (p.special = 'S' or p.special = 'U' or p.special = 'F')");

        if (!$sth)
          return 0;

        $j = 0;
        while ($specials = mysql_fetch_array($sth))
        {
          $specials_array[$j][special] = $specials["special"];
          $specials_array[$j][pid] = $specials["pid"];
          $j++;
        }
      }
      // if (is_array($specials_array))
      // $specials_array = array_unique($specials_array);
      return $specials_array;
    }
  }
}



/******************
*
*  get_jumpgate_max_tonnage($prod_id)
*
******************/
function get_jumpgate_max_tonnage($prod_id)
{
  $sth = mysql_query("select tonnage from jumpgatevalues where prod_id='$prod_id'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  return 0;

  $max_tonnage = mysql_fetch_row($sth);

  return $max_tonnage[0];
}

/******************
*
*  get_jumpgate_used_tonnage($pid)
*
******************/
function get_jumpgate_used_tonnage($pid)
{
  $sth = mysql_query("select used_tonnage from jumpgates where pid='$pid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  return 0;

  $used_tonnage = mysql_fetch_row($sth);

  return $used_tonnage[0];
}



/******************
*
*  get_jumpgate_reload($prod_id)
*
******************/
function get_jumpgate_reload($prod_id)
{
  $sth = mysql_query("select reload from jumpgatevalues where prod_id='$prod_id'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  return 0;

  $reload = mysql_fetch_row($sth);

  return $reload[0];
}


/******************
*
*  get_pic($prod_id)
*
******************/
function get_pic($prod_id)
{
  $sth=mysql_query("select pic from production where prod_id=$prod_id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  list($pic)=mysql_fetch_row($sth);

  return $pic;
}


/******************
*
*  get_buildings_sense($prod_id, $pid)
*
******************/
function get_buildings_sense($prod_id, $pid)
{
  $sth = mysql_query("select ressource from prod_upgrade where prod_id=".$prod_id);

  if (!$sth)
    return false;

  if (mysql_num_rows($sth) == 0)
    return true;

  list($its_ressource) = mysql_fetch_row($sth);

  if ($its_ressource=="all")
    return true;

  $sth = mysql_query("select ".$its_ressource." from planets where id=".$pid);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  list($ressource_gibts) = mysql_fetch_row($sth);

  if ($ressource_gibts > 0)
    return true;
  else
    return false;
}

function get_sound_by_prod_id($prod_id) {
  $sth = mysql_query("select sound_file, type from unit_sounds where prod_id = ".$prod_id." and type <> 'admiral'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;
  $i = 0;
  while ($sound = mysql_fetch_array($sth)) {
    $sound_array["".$sound["type"].""] = $sound["sound_file"];
  }

  return $sound_array;
}

function construction_exists($prod_id,$pid)
{
  $sth=mysql_query("select prod_id from constructions where pid=".$pid." and prod_id=".$prod_id);

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
    return true;
}

/** 
 * wieviel ressourcen kostet was pro woche? 
 * 
 * @param $what 
 * @return array
 */
function get_ressources_per_week($what)
{
  $arr=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
  {
    if ($what[$res]>0 && $what["count"]>0 && $what["com_time"]>0)
      $arr[$res]=ceil($what[$res]*$what["count"]/$what["com_time"]);
  }
  return $arr;
}
?>
