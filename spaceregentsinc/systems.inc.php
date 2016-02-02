<?

/********************
*
* function get_system_coords($sid, $type = 0)
*
* function get_cid_by_sid($sid)
*
* function get_sid_by_pid($pid)
*
* function get_sid_by_cid($cid)
*
* function get_sid_by_uid($uid)
*
* function get_sid_type($sid)
*
* function get_sid_and_scanrange_by_uid($uid);
*
* function get_possible_scan_systems($uid)
*
* function get_systems_in_scanrange($sid, $range)
*
* function calculate_distance(x1,y1,x2,y2)
*
* function get_uid_by_sid($sid)
*
* function get_count_and_uid_by_sid($sid)
*
* function is_own_star($sid)    // auch ob allied drin sind
*
* function is_in_scanrange($uid, $sid)
*
* function get_pid_of_jumpgate($sid);
*
* function get_homeworld_coords($uid);
* function get_systemname($sid);
* function get_planet_count_by_sid($sid);
* function get_max_scanrange_by_sid($sid); //auch von allierten
* function is_homesystem($sid)
********************/

function get_system_coords($sid, $type = 0)
{
  $sth=mysql_query("select x,y from systems where id=$sid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $coords=mysql_fetch_row($sth);

  switch ($type)
  {
    case 0:
      return $coords[0].":".$coords[1];
    break;
    case 1:
      return $coords[0]." ".$coords[1];                     // zum direkt ins SVG translate pasten
    break;
    case 2:
      $system_coords[x] = $coords[0];
      $system_coords[y] = $coords[1];
      return $system_coords;
    break;
    case 3:
      return $coords[0].",".$coords[1];                     // zum direkt ins SVG translate pasten
    break;
  }

}

function get_cid_by_sid($sid)
{
  $sth=mysql_query("select cid from systems where id=$sid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $cid=mysql_fetch_row($sth);

  return $cid[0];
}

/*******************
*
* function get_sid_by_pid($pid)
*
*******************/
function get_sid_by_pid($pid)
{
  $sth=mysql_query("select sid from planets where id=$pid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $sid=mysql_fetch_row($sth);

  return $sid[0];
}

function get_sid_by_cid($cid)
{
  $sth = mysql_query("select id from systems where cid = $cid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  while($sid = mysql_fetch_array($sth))
  {
    $sid_array[] = $sid["id"];
  }

  return $sid_array;
}

/***********************
*
* function get_sid_by_uid($uid)
*
***********************/
function get_sid_by_uid($uid)
{
  $sth = mysql_query("select distinct(s.id) from systems as s, planets as p where p.uid = $uid and p.sid = s.id order by s.id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  while($sid = mysql_fetch_array($sth))
  {
    $sid_array[] = $sid[0];
  }

  return $sid_array;
}


/***********************
*
* function get_sid_type($sid)
*
***********************/
function get_sid_type($sid)
{
  $sth = mysql_query("select type from systems where id = $sid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $type = mysql_fetch_row($sth);

  return $type[0];
}




/***********************
*
* function get_sid_and_scanrange_by_uid($uid, $cid_array = 0)
*
***********************/
function get_sid_and_scanrange_by_uid($uid, $cid_array = 0)
{
  global $standard_scan_radius;

  $default_scanradius = $standard_scan_radius;

  if (is_array($cid_array))
  {
    $query="select sid from planets p, systems s where p.uid='$uid' and p.sid=s.id and (";
    for ($i=0; $i<sizeof($cid_array); $i++)
    {
      $query.="cid=".$cid_array[$i]." or ";
    }

    $sth = mysql_query(substr($query,0,-4).")");

    if (!$sth)
    {
      return 0;
    }

    while ($planets = mysql_fetch_array($sth))
    {
      $systems[$planets["sid"]] = get_max_scanrange_by_sid($planets["sid"], $uid);
    }
  }
  else
  {
    $sth = mysql_query("select sid from planets where uid = '$uid'");

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return false;
    else
    {
      while ($planets = mysql_fetch_array($sth))
      {
        $systems[$planets["sid"]] = get_max_scanrange_by_sid($planets["sid"], $uid);
      }
    }
  }

  return $systems;
}


/***********************
*
* function get_possible_scan_systems($uid)
*
***********************/
function get_possible_scan_systems($uid, $cid_array = 0)
{
  if ($allies = get_allied_ids($uid))
  {
    array_push($allies,$uid);

    for ($i = 0; $i < sizeof($allies); $i++)
    {
      $alliance_systems = get_sid_and_scanrange_by_uid($allies[$i], $cid_array);

      for ($j = 0; $j < sizeof($alliance_systems); $j++)
      {
        $its_sids_and_radius = each ($alliance_systems);
        $systems[$its_sids_and_radius[0]] = $its_sids_and_radius[1];
      }
    }
  }
  else
  {
    $systems = get_sid_and_scanrange_by_uid($uid, $cid_array);
  }

  if (is_array($systems))
  {
    for ($i = 0; $i < sizeof($systems); $i++)
    {
        $system = each($systems);
        $bla = array_merge($bla,get_systems_in_scanrange($system[0], $system[1]));
    }
  }
  return $bla;
}


/***********************
*
* function get_systems_in_scanrange($sid, $range)
*
***********************/
function get_systems_in_scanrange($sid, $range)
{
  $system_coords = get_system_coords($sid);
  $system_x = substr($system_coords,0,strpos($system_coords,":"));
  $system_y = substr($system_coords,strpos($system_coords,":")+1);

  $sth = mysql_query("select id, x, y from systems where (x >= ".($system_x - $range).") and (x <= ".($system_x + $range).") and (y >= ".($system_y - $range).") and (y <= ".($system_y + $range).")");

  if ((!$sth) || (mysql_num_rows($sth) == 0))
      return false;

  while ($sys_in_range = mysql_fetch_array($sth))
  {
    $vektor_betrag = calculate_distance($sys_in_range["x"],$sys_in_range["y"],$system_x,$system_y);
    if ($vektor_betrag <= $range)
    {
      $result_systems[] = $sys_in_range["id"];
    }
  }

  return $result_systems;
}



/***********************
*
* function calculate_distance(x1,y1,x2,y2)
*
***********************/
function calculate_distance($x1,$y1,$x2,$y2)
{
    $vectorX = $x1 - $x2;
    $vectorY = $y1 - $y2;

    $vektor_betrag    = pow($vectorX, 2) + pow($vectorY, 2);
    $vektor_betrag    = sqrt($vektor_betrag);

    return $vektor_betrag;
}


/***********************
*
* get_uid_by_sid($sid)
*
***********************/
function get_uid_by_sid($sid)
{
  $sth = mysql_query("select distinct(uid) from planets where sid = $sid");

  if (!$sth || (mysql_num_rows($sth) == 0))
  return false;

  while ($user = mysql_fetch_array($sth))
  {
    if ($user["uid"] != 0)
      $user_array[] = $user["uid"];
  }

  return $user_array;
}

/***********************
*
* function get_count_and_uid_by_sid($sid)
*
***********************/
function get_count_and_uid_by_sid($sid)
{
  $users = get_uid_by_sid($sid);

  for ($i = 0; $i < sizeof($users); $i ++)
  {
    $sth = mysql_query("select count(id) from planets where sid = $sid and uid = ".$users[$i]."");

    if (!$sth || (mysql_num_rows($sth) == 0))
    return false;

    $anzahl = mysql_fetch_row($sth);

    $user_array[$users[$i]] = $anzahl[0];
  }

  arsort($user_array);
  return $user_array;
}

//**********************
//*
//* is_own_star($sid)       // auch allied
//*
//**********************
function is_own_star($sid)
{
  global $uid;

  $sth = mysql_query("select uid from planets where sid='$sid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  {
    return 0;
  }

  $is_friendly = false;
  while (($planeten = mysql_fetch_array($sth)) && ($is_friendly == false))
  {
    if ($planeten["uid"] != 0)
    {
      if (($uid==$planeten["uid"]) || (is_allied($uid,$planeten["uid"])))
      {
        $is_friendly = true;
      }
    }
  }
  return $is_friendly;
}


/***********************
*
* function is_in_scanrange($uid, $sid)
*
* hier wird gecheckt ob ein speziellen system in scanreichweite eines users ist,
* sie gibt entweder true oder false zurück, funktioniert nicht wie system_in_scanrange,
* welche zu einem system mit gegebener Reichweite die Systeme als array zurückgibt.
*
***********************/
function is_in_scanrange($uid, $sid)
{
  global $uid;

  // erstmal check ob eine eigene bzw. allieerte flotte im system ist
  $is_in_range = false;

  if (is_a_fleet_in_system($uid, $sid))
  {
    $is_in_range = true;
  }
  else
  {
    // flotten von alliierten im system?
    $allied = get_allied_ids($uid);
    for ($i = 0; $i < sizeof($allied); $i++)
    {
      if (is_a_fleet_in_system($allied[$i], $sid))
      {
        $is_in_range = true;
        break;
      }
    }

    // ist es denn wenigstens in irgendeinem scanradius des users oder eines allierten?
    if (!$is_in_range)
    {
      $sth = mysql_query("select max(radius) from scanradius");

      if ((!$sth) || (mysql_num_rows($sth)==0))
        return 0;

      $max_scanrange = mysql_fetch_row($sth);

      $systems = get_systems_in_scanrange($sid, $max_scanrange[0]);

      for ($i = 0; $i < sizeof($systems); $i++)
      {
        $own_star = is_own_star($systems[$i]);      // auch ob er alliiert ist
        if ($own_star)
        {
            // nen gebäude mit ner aussreichenden scanrange?
          $sth = mysql_query("select p.uid,p.id,s.x,s.y from planets as p, systems as s where p.sid='$systems[$i]' and s.id='$systems[$i]'");

          if (!$sth)
            return 0;

          while ($planets = mysql_fetch_array($sth))
          {
            if (($planets["uid"] == $uid) || (is_allied($uid,$planets["uid"])))
            {
              $planets_scan_range = get_max_scan_range_by_pid($planets["id"]);
              if ($planets_scan_range)
              {
                $system_coords = get_system_coords($sid);
                $system_x = substr($system_coords,0,strpos($system_coords,":"));
                $system_y = substr($system_coords,strpos($system_coords,":")+1);
                $entfernung   = calculate_distance($planets["x"], $planets["y"], $system_x, $system_y);
                if ($entfernung <= $planets_scan_range)
                  $is_in_range = true;
              }
            }
          }
        }// end if

        // oder vielleicht ne flotte?
        if (!$is_in_range)
        {
          // $sth = mysql_query("select s.radius,fi.uid,sy.x,sy.y from scanradius as s,systems as sy, fleet as f, fleetinfo as fi where f.prod_id = s.prod_id and f.fid = fi.fid and fi.sid='$systems[$i]' and and sy.id='$systems[$i]'");
          $sth = mysql_query("select fid, uid, sid from fleet_info where sid=".$systems[$i]."");

          if (!$sth)
            return 0;

          if (mysql_num_rows($sth)!=0)
          {
            while ($flotten = mysql_fetch_array($sth))
            {
              if (($flotten["uid"]==$uid) || (is_allied($uid,$flotten["uid"])))
              {
                $sth2 = mysql_query("select max(s.radius) from scanradius as s, fleet as f where f.fid=".$flotten["fid"]." and f.prod_id=s.prod_id");

                $fleet_scan_range = mysql_fetch_row($sth2);
                if ($fleet_scan_range)
                {
                  $system_coords = get_system_coords($sid);
                  $system_x = substr($system_coords,0,strpos($system_coords,":"));
                  $system_y = substr($system_coords,strpos($system_coords,":")+1);
                  $fleet_coords = get_system_coords($flotten["$sid"]);
                  $fleet_x = substr($fleet_coords,0,strpos($fleet_coords,":"));
                  $fleet_y = substr($fleet_coords,strpos($fleet_coords,":")+1);
                  $entfernung   = calculate_distance($fleet_x, $fleet_y, $system_x, $system_y);
                  if ($entfernung <= $fleet_scan_range)
                    $is_in_range = true;
                }
              }
            }
          }



          //if (!$sth)
          //return 0;

        }
      }// end for
    }
  }

  return $is_in_range;
}



/***********************
*
* function get_pid_of_jumpgate($sid)
*
***********************/
function get_pid_of_jumpgate($sid)
{
  $sth = mysql_query("select pid from jumpgates where sid='$sid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  return 0;

  $pid = mysql_fetch_row($sth);
  return ($pid[0]);
}


/***********************
*
* function get_homeworld_coords($uid)
*
***********************/
function get_homeworld_coords($uid)
{
  $sth = mysql_query("select s.x,s.y from systems as s, users as u, planets as p where u.id=$uid and u.homeworld=p.id and p.sid=s.id");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $coords = mysql_fetch_array($sth);
  $homecoords[0] = $coords["x"];
  $homecoords[1] = $coords["y"];

  return $homecoords;
}


/***********************
*
* function get_systemname($sid)
*
***********************/
function get_systemname($sid)
{
  $sth=mysql_query("select name from systems where id=$sid");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
  {
    list($name)=mysql_fetch_row($sth);
    return $name;
  }
}


/***********************
*
* function get_planet_count_by_sid($sid)
*
***********************/
function get_planet_count_by_sid($sid)
{
  $sth = mysql_query("select count(id) from planets where sid='$sid'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  list($planet_count) = mysql_fetch_row($sth);

  return $planet_count;
}


/***********************
*
* function get_max_scanrange_by_sid($sid)
*
***********************/
function get_max_scanrange_by_sid($sid, $user_id = 0)
{
  global $uid;

  if (!$user_id)
    $user_id = $uid;

  $sth = mysql_query("select id from planets where sid='$sid' and uid != 0");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  while ($its_planets = mysql_fetch_array($sth))
  {
    $its_user = get_uid_by_pid($its_planets["id"]);
    if (($its_user == $user_id) || (is_allied($its_user, $user_id)))
    {
      $scanrange[] = get_max_scan_range_by_pid($its_planets["id"]);
    }
  }

  if (is_array($scanrange))
  {
    rsort($scanrange);
    $max_scanrange = $scanrange[0];
  }
  else
  {
    $max_scanrange = 0;
  }

  return $max_scanrange;
}



/***********************
*
* function get_max_fleet_scanrange_by_sid($sid)
*
***********************/
function get_max_fleet_scanrange_by_sid($sid, $user_id = 0)
{
  global $uid;

  if (!$user_id)
    $user_id = $uid;

  $sth = mysql_query("select fid from fleet_info where sid=".$sid);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  while ($its_fleets = mysql_fetch_array($sth))
  {
    $its_user = get_uid_by_fid($its_fleets["fid"]);
    if (($its_user == $user_id) || (is_allied($its_user, $user_id)))
    {
      $scanrange[] = get_max_scanrange_by_fid($its_fleets["fid"]);
    }
  }

  if (is_array($scanrange))
  {
    rsort($scanrange);
    $max_scanrange = $scanrange[0];
  }
  else
  {
    $max_scanrange = 0;
  }

  return $max_scanrange;
}


function is_homesystem($sid)
{
  $sth = mysql_query("select distinct 1 from planets where start=1 and sid=".$sid);
  
  if (!$sth)
    return false;
    
  if (mysql_num_rows($sth) > 0)
    return true;
  else
    return false;
}
?>
