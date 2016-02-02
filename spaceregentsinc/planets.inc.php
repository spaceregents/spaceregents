<?
/********************
*
* function get_uid_by_pid($pid)
*
* function get_planetname($pid)
*
* function get_planets_by_uid($uid)
*
* function get_coords_by_pid($pid)
*
* function get_planets_by_sid($sid)
*
* function get_planets_type($pid); - gibt einen Char zurück (E, O, M, D, I, A, R)
*
* function get_planets_resource($pid, $resource); - gibt den Output des Planeten dieser einen Ressource zurück
*
* function get_planetcount_by_sid_and_uid($uid, $sid)
*
* function get_population($pid)
*
* function get_buildings($pid, $type)
*
* function get_infantry($pid, $type)
*
* function get_max_scan_range_by_pid($pid)
*
* function get_jumpgate_by_pid($pid)
*
* function has_tradingstation($pid)
*
* function get_x_by_pid($pid)
*
* function get_full_planets_type($typ_char);
*
* function has_a_planet_in_system($uid, $sid);
*
* function is_planet_in_homesystem($pid);  // gibt 'true' zurück wenn der planet sich in einem system befindet wo ein startplanet ist
********************/


function get_uid_by_pid($pid)
{
  if ($pid)
  {
    $sth=mysql_query("select uid from planets where id=$pid");

    if (!$sth)
      return false;

    if (mysql_num_rows($sth)==0)
      return false;

    list($uid)=mysql_fetch_row($sth);

    return $uid;
  }
  else
    return false;
}


//**************************---------------------------------------------------| get_planetname
function get_planetname($pid)
{
  $sth=mysql_query("select name, sid, x from planets where id=$pid");

  if (!$sth)
    return 0;

  if (mysql_num_rows($sth)==0)
    return false;

  $name=mysql_fetch_array($sth);

  if ($name["name"]=="Unnamed")
  {
    $latin_letters = array("I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII");

    $sth = mysql_query("select name from systems where id=".$name["sid"]);

    if ((!$sth) || (!mysql_num_rows($sth)))
      return 0;

    list($system_name) = mysql_fetch_row($sth);

    return ($system_name . " " . $latin_letters[$name["x"]-1]);
  }
  else
    return $name["name"];
}
//---------------<



function get_planets_by_uid($uid)
{
  $sth=mysql_query("select * from planets where uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  return $sth;
}

function get_planetcount_by_uid($uid)
{
  $sth=mysql_query("select sum(id) from planets where uid=$uid");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)==0)
    return 0;

  $count=mysql_fetch_row($sth);

  return $count[0];
}

function get_coords_by_pid($pid)
{
  $sth=mysql_query("select s.x,s.y from systems as s, planets as p where p.id=$pid and p.sid=s.id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $coords=mysql_fetch_array($sth);

  return $coords;
}

function get_planets_by_sid($sid)
{
  $sth = mysql_query("select id from planets where sid=$sid order by x");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  while($planets = mysql_fetch_array($sth))
  {
    $planets_array[] = $planets["id"];
  }

  return $planets_array;
}

function get_planets_type($pid)
{
  $sth = mysql_query("select type from planets where id = $pid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $planets_type = mysql_fetch_array($sth);

  return $planets_type[0];
}

function get_planets_resource($pid, $resource)
{
  $sth = mysql_query("select $resource from planets where id = $pid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $planets_resource = mysql_fetch_array($sth);

  return $planets_resource[$resource];
}

function get_planetcount_by_sid_and_uid($uid, $sid)
{
  $sth = mysql_query("select count(id) from planets where sid = $sid and uid = $uid");

  if (!$sth)
  return false;

  $planet_count = mysql_fetch_row($sth);

  return $planet_count[0];
}

function get_population($pid)
{
  $sth = mysql_query("select population from planets where id = $pid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $population = mysql_fetch_row($sth);

  return $population[0];
}

//********************
//*
//* function get_buildings($pid, $type)
//*
//* ------------------
//* $pid = eine planeten id
//* $type = [all, p, o]
//* p = planetar
//* o = orbital
//* up= in construction planetar
//* uo = in construction orbital
//* all = alle (default)
//* ..................
//* liefert ein ARRAY der IDs der betreffenden gebäude zurück, sortiert nach p,o und name
//********************
function get_buildings($pid, $type = "all")
{
  switch ($type)
  {
    case "all":
      $sth = mysql_query("select p.prod_id from constructions c,production p where c.prod_id=p.prod_id and c.pid=".$pid." order by p.name");
    case "p":
      $sth = mysql_query("select p.prod_id from constructions as b, production as p where b.prod_id = p.prod_id and b.pid = '".$pid."' and b.type=0 order by p.name");
    break;
    case "o":
      $sth = mysql_query("select p.prod_id from constructions as b, production as p where b.prod_id = p.prod_id and b.pid = '".$pid."' and b.type=1 order by p.name");
    break;
    case "up":
      $sth = mysql_query("select * from p_production where planet_id = '".$pid."' order by pos");
    break;
    case "uo":
      $sth = mysql_query("select * from o_production where planet_id = '".$pid."' order by pos");
    break;
  }

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  while ($buildings = mysql_fetch_array($sth))
  {
    $buildings_array[] = $buildings["prod_id"];
  }

  return $buildings_array;
}



//********************
//*
//* function get_infantry($pid, $type = "all")
//*
//* ------------------
//* $pid = eine planeten id
//* $type = [all, i, v]
//* i = infantry
//* v = vehicle
//* all = alle (default)
//* ..................
//* liefert ein ARRAY[prod_id,anzahl, storage/unit] der betreffenden infantry zurück, sortiert nach v,i und name
//********************
function get_infantry($pid, $type = "all")
{
  switch ($type)
  {
    case "all":
      $sth = mysql_query("select p.prod_id,i.count, iv.tonnage as storage from infantery as i, production as p, shipvalues iv where (i.pid = $pid and i.prod_id = p.prod_id and iv.prod_id = i.prod_id) order by p.typ DESC, p.name");
    break;
    case "I":
      $sth = mysql_query("select p.prod_id, i.count, iv.tonnage as storage from infantery as i, production as p, shipvalues iv where i.pid = '$pid' and i.prod_id = p.prod_id and p.typ = 'I' and iv.prod_id = i.prod_id order by p.name");
    break;
    case "V":
      $sth = mysql_query("select p.prod_id, i.count, iv.tonnage as storage from infantery as i, production as p, shipvalues iv where i.pid = $pid and i.prod_id = p.prod_id and p.typ = 'V' and iv.prod_id = i.prod_id order by p.name");
    break;
  }

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $i = 0;
  while ($infantry = mysql_fetch_array($sth))
  {
    $infantry_array[$i][0] = $infantry["prod_id"];
    $infantry_array[$i][1] = $infantry["count"];
    $infantry_array[$i][2] = $infantry["storage"];
    $i++;
  }

  return $infantry_array;
}

function habitable($pid)
{
  $sth=mysql_query("select * from planets where id=$pid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }


  $planet=mysql_fetch_array($sth);

  if ($planet["uid"]==0)
  {
    switch ($planet["type"])
    {
      case "E":
        $bewohnbar=true;
      break;
      case "O":
        $bewohnbar=true;
      break;
      case "M":
        $bewohnbar=true;
      break;
      case "D":
        $bewohnbar=true;
      break;
      case "I":
        $bewohnbar=true;
      break;
      case "A":
        $bewohnbar=true;
      break;
      case "R":
        $bewohnbar=true;
      break;
      default:
        $bewohnbar=false;
    }
  }
  return $bewohnbar;
}



/***********************
*
* get_max_scan_range_by_pid($pid)
*
***********************/
function get_max_scan_range_by_pid($pid)
{
  global $standard_scan_radius;

  $sth=mysql_query("select max(s.radius) from scanradius as s, constructions c where c.prod_id=s.prod_id and c.pid=".$pid);

  if (!$sth)
    return 0;
  
  if (mysql_num_rows($sth)==0)
  {
    $max_radius = $standard_scan_radius;
  }
  else
  {
    list($max_radius) = mysql_fetch_row($sth);

    if ($max_radius==NULL)
      $max_radius=$standard_scan_radius;
  }

  return $max_radius;
}



/***********************
*
* function get_jumpgate_by_pid($pid)
*
***********************/
function get_jumpgate_by_pid($pid)
{
  $sth = mysql_query("select prod_id from jumpgates where pid='$pid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  return 0;

  $jumpgate_prod_id = mysql_fetch_row($sth);

  return $jumpgate_prod_id[0];
}

/***********************
*
* function has_tradingstation($pid)
*
***********************/
function has_tradingstation($pid)
{
  $sth = mysql_query("select uid from tradestations where pid=$pid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;
  else
    return 1;
}


function has_shield($pid)
{
	$sth = mysql_query("SELECT 1 FROM planetary_shields WHERE pid = ".$pid);

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;
  else
    return 1;
}

/**
 * holt x anhand der pid
 *
 * @param $pid
 * @return x
 */
function get_x_by_pid($pid)
{
  $sth=mysql_query("select x from planets where id=$pid");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  list($x)=mysql_fetch_row($sth);

  return $x;
}




/**
 * get_full_planets_type($type_char)
 */
function get_full_planets_type($type_char)
{
  switch ($type_char)
  {
      case "E":
        $planet_type = "Eden";
      break;
      case "O":
        $planet_type = "Origin";
      break;
      case "M":
        $planet_type = "Mars";
      break;
      case "D":
        $planet_type = "Desert";
      break;
      case "I":
        $planet_type = "Ice";
      break;
      case "A":
        $planet_type = "Ancient";
      break;
      case "R":
        $planet_type = "Rock";
      break;
      case "T":
        $planet_type = "Toxic";
      break;
      case "H":
        $planet_type = "Heavy Gravity";
      break;
      case "G":
        $planet_type = "Gas Giant";
      break;
  }

  return $planet_type;
}

function get_infantry_and_data_by_pid_uid($pid, $uid)
{
  $sth = mysql_query("select i.*, iv.tonnage, p.name, p.pic from infantery i, shipvalues iv, production p where i.prod_id = iv.prod_id and p.prod_id = i.prod_id and i.pid = '$pid' and i.uid = '$uid' and p.name!='Militia' group by iv.prod_id");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $inf_array = false;
  $i = 0;
  while ($its_infantry = mysql_fetch_array($sth))
  {
    $inf_array[$i]["prod_id"] = $its_infantry["prod_id"];
    $inf_array[$i]["count"]   = $its_infantry["count"];
    $inf_array[$i]["storage"] = $its_infantry["tonnage"];
    $inf_array[$i]["name"]    = $its_infantry["name"];
    $inf_array[$i]["pic"]     = $its_infantry["pic"];
    $i++;
  }

  return $inf_array;
}


function has_infantry_on_planet($pid, $uid)
{
  $sth = mysql_query("SELECT 1 FROM infantery WHERE pid=".$pid." and uid=".$uid);
  
  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
    return true;
}

function has_a_planet_in_system($uid, $sid)
{
  $sth = mysql_query("select if(count(id) = 0, 'false', 'true') from planets where uid=$uid and sid=$sid");

  if ((!$sth)||(!mysql_num_rows($sth)))
    return false;

  list($return_value) = mysql_fetch_row($sth);

  return $return_value;
}

function is_planet_in_homesystem($pid)
{
  $sth = mysql_query("select p.id from planets p, systems s where p.start = 1 and p.sid = s.id and s.id = (select sid from planets where id='".$pid."');");
  
  if (!$sth || !(mysql_num_rows($sth)))
    return false;
  
  list($startplanets) = mysql_fetch_row($sth);
  
  if ($startplanets > 0)
    return $startplanets;
  else
    return false;      
}
?>
