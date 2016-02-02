<?php
define("SYSTEM_UNKNOWN",0);
define("SYSTEM_VISIBLE",1);
define("SYSTEM_FOGGED" ,2);

if ($_GET["debug"])
{
  $time_begin = microtime();
}

// ____________________________________________________ includes
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/alliances.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/class_universe.inc.php";
include "../spaceregentsinc/class_map_info.inc.php";

$ses->page_birth();
// mop: nur debug

// wird eh immer benötigt
//_____________________________________________________________________________
//***************
//
// function draw_star($x, $y, $sid , $selectable)
//
//***************
function draw_star($x, $y, $sid , $selectable)
{
  global $globalTranslate;
  global $map_info;

  $translate=explode(" ",$globalTranslate);

  $pos_x = $translate[0];
  $pos_y = $translate[1];

  if ($selectable!=SYSTEM_UNKNOWN)
  {
    $typ = $map_info->get_sid_type($sid);
    switch ($typ)
    {
      case 1:
      $typ = "#pWStar";
      $x  += 2.5;
      $y  += 2.5;
      break;
          case 2:
      $typ = "#pBStar";
      $x  += 2.5;
      $y  += 2.5;
      break;
          case 3:
      $typ = "#pYStar";
      $x  += 4;
      $y  += 4;
      break;
          case 4:
      $typ = "#pRStar";
      $x  += 4;
      $y  += 4;
      break;
    }
    $its_star = "<use x=\"".$x."\" y=\"".$y."\" tagX=\"".($x+$pos_x)."\" tagY=\"".($y + $pos_y)."\" tagView=\"1\" xlink:href=\"".$typ."\" id=\"s".$sid."\" cursor=\"pointer\"".($selectable==SYSTEM_FOGGED ? " style=\"opacity: 0.5\"" : "")."/>";
  }
  else
    $its_star = "<use x=\"".$x."\" y=\"".$y."\" tagX=\"".($x+$pos_x)."\" tagY=\"".($y + $pos_y)."\" tagView=\"0\" xlink:href=\"#pGStar\" id=\"s".$sid."\" />";

  return $its_star;
}

//_____________________________________________________________________________
//**********************
//*
//* draw_fleets(int $x, int $y, array $fleets, int $sid)
//*
//**********************
function draw_fleets($x, $y, $fleets, $sid)
{
  global $uid;
  global $map_info;

  $own_fleet_count      = 0;
  $own_ship_count       = 0;

  $allied_fleet_count   = 0;
  $allied_ship_count    = 0;
  $allied_count         = 0;
  $allied_old_uid       = 0;

  $enemy_fleet_count    = 0;
  $enemy_ship_count     = 0;
  $enemy_count          = 0;
  $enemy_old_uid        = 0;

  $friendly_fleet_count = 0;
  $friendly_ship_count  = 0;
  $friendly_count       = 0;
  $friendly_old_uid     = 0;

  $neutral_fleet_count  = 0;
  $neutral_ship_count   = 0;
  $neutral_count        = 0;
  $neutral_old_uid      = 0;

  $abstand_x            = 10;
  $abstand_y            = 13;

  for ($i = 0; $i < sizeof($fleets); $i++)
  {
    $fleet_owner = $map_info->get_uid_by_fid($fleets[$i]);

    if ($fleet_owner == $uid)                             // ist es eine eigene Flotte
    {
      $own_count++;
      $own_ship_count += get_shipcount_by_fid($fleets[$i]);
    }
    elseif ($map_info->is_allied($fleet_owner))        // oder eine alliierte
    {
      $allied_fleet_count++;
      $allied_ship_count += get_shipcount_by_fid($fleets[$i]);
      if ($allied_old_uid != $fleet_owner)
      {
  $allied_count++;
  $allied_old_uid = $fleet_owner;
      }
    }
    elseif ($map_info->is_friendly($fleet_owner))                  // oder eine freundliche?
    {
      $friendly_fleet_count++;
      $friendly_ship_count += get_shipcount_by_fid($fleets[$i]);
      if ($friendly_old_uid != $fleet_owner)
      {
  $friendly_count++;
  $friendly_old_uid = $fleet_owner;
      }
    }
    elseif ($map_info->is_enemy($fleet_owner))                 // oder eine feindliche?
    {
      $enemy_fleet_count++;
      $enemy_ship_count += get_shipcount_by_fid($fleets[$i]);
      if ($enemy_old_uid != $fleet_owner)
      {
        $enemy_count++;
        $enemy_old_uid = $fleet_owner;
      }
    }
    else
    {
      $neutral_fleet_count++;                             // nein? dann muss es eine neutrale sein
      $neutral_ship_count += get_shipcount_by_fid($fleets[$i]);
      if ($neutral_old_uid != $fleet_owner)
      {
        $neutral_count++;
        $neutral_old_uid = $fleet_owner;
      }
    }
  }

  $system_fleets .= "<g id=\"fleets_star_s".$sid."\" pointer-events=\"none\">";
  if ($own_count > 0)
  {
    $system_fleets .= "<g class=\"colorOwn\">";
    $system_fleets .= "<use xlink:href=\"#sShip\" x=\"".($x + $abstand_x)."\" y=\"".($y - $abstand_y)."\"/>";
    for ($i = 0; $i <= log10($own_ship_count); $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sFleetStarCount\" x=\"".(($x + $abstand_x)+($i*5))."\" y=\"".($y - $abstand_y + 11)."\"/>";
    }
    $system_fleets .= "</g>";
    $abstand_y += $abstand_y+5;
  }

  if ($allied_fleet_count > 0)
  {
    $system_fleets .= "<g class=\"colorAllied\">";
    for ($i = 0; $i < $allied_count; $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sShip\" x=\"".($x + $abstand_x + ($i * 4))."\" y=\"".($y - $abstand_y)."\" style=\"fill:yellow;\"/>";
    }
    for ($i = 0; $i <= log10($allied_ship_count); $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sFleetStarCount\" x=\"".(($x + $abstand_x)+($i*5))."\" y=\"".($y - $abstand_y + 11)."\" style=\"fill:yellow;\"/>";
    }
    $system_fleets .= "</g>";
    $abstand_y += $abstand_y / 2 + 5;
  }

  if ($friendly_fleet_count > 0)
  {
    $system_fleets .= "<g class=\"colorFriend\">";
    for ($i = 0; $i < $friendly_count; $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sShip\" x=\"".($x + $abstand_x + ($i * 4))."\" y=\"".($y - $abstand_y)."\" style=\"fill:orange;\"/>";
    }
    for ($i = 0; $i <= log10($friendly_ship_count); $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sFleetStarCount\" x=\"".(($x + $abstand_x)+($i*5))."\" y=\"".($y - $abstand_y + 11)."\" style=\"fill:orange;\"/>";
    }
    $system_fleets .= "</g>";
    $abstand_y += $abstand_y / 2 + 5;
  }

  if ($enemy_fleet_count > 0)
  {
    $system_fleets .= "<g class=\"colorEnemy\">";
    for ($i = 0; $i < $enemy_count; $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sShip\" x=\"".($x + $abstand_x + ($i * 4))."\" y=\"".($y - $abstand_y)."\" style=\"fill:red;\"/>";
    }
    for ($i = 0; $i <= log10($enemy_ship_count); $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sFleetStarCount\" x=\"".(($x + $abstand_x)+($i*5))."\" y=\"".($y - $abstand_y + 11)."\" style=\"fill:red;\"/>";
    }
    $system_fleets .= "</g>";
    $abstand_y += $abstand_y / 2 + 5;
  }
  if ($neutral_fleet_count > 0)
  {
    $system_fleets .= "<g class=\"colorNeutral\">";
    for ($i = 0; $i < $neutral_count; $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sShip\" x=\"".($x + $abstand_x + ($i * 4))."\" y=\"".($y - $abstand_y)."\" style=\"fill:blue;\"/>";
    }
    for ($i = 0; $i <= log10($neutral_ship_count); $i++)
    {
      $system_fleets .= "<use xlink:href=\"#sFleetStarCount\" x=\"".(($x + $abstand_x)+($i*5))."\" y=\"".($y - $abstand_y + 11)."\" style=\"fill:blue;\"/>";
    }
    $system_fleets .= "</g>";
  }
  $system_fleets .= "</g>";

  return $system_fleets;
}



//_____________________________________________________________________________
//**********************
//*
//* draw_special_symbols(int $x, int $y, array $specials, int $sid)
//*
//**********************
function draw_special_symbols($x, $y, $specials, $sid)
{
  global $uid;
  global $map_info;

  $abstand_x = -40;
  $abstand_y = -25;

  for ($i = 0; $i < sizeof($specials); $i++)
  {
    if (isset($specials[$i]))
    {
      $its_uid = get_uid_by_pid($specials[$i][pid]);

      if (($uid == $its_uid) || ($map_info->is_allied($its_uid)))
        $allied_special[] = $specials[$i][special];
      else
      {
        if ($map_info->is_friendly($its_uid))
          $friendly_special[] = $specials[$i][special];
        elseif ($map_info->is_enemy($its_uid))
          $enemy_special[] = $specials[$i][special];
        else
          $neutral_special[] = $specials[$i][special];
      }
    }
  }

  if (is_array($allied_special))
  {
    $allied_special = array_unique($allied_special);
    for ($i = 0; $i < sizeof($allied_special); $i++)
    {
      $its_specials = each($allied_special);

      $special_symbols .= "<use xlink:href=\"#sStarSpecialSymbol_".$its_specials[1]."\" x=\"".($x + $abstand_x - ($i * 25))."\" y=\"".($y + $abstand_y)."\"  class=\"colorOwnDiscreet\"/>";
    }
    $abstand_y += (-25);
  }

  if (is_array($friendly_special))
  {
    $friendly_special = array_unique($friendly_special);
    for ($i = 0; $i < sizeof($friendly_special); $i++)
    {
      $its_specials = each($friendly_special);
      $special_symbols .= "<use xlink:href=\"#sStarSpecialSymbol_".$its_specials[1]."\" x=\"".($x + $abstand_x - ($i * 25))."\" y=\"".($y + $abstand_y)."\"  class=\"colorFriendDiscreet\"/>";
    }
    $abstand_y += (-25);
  }

  if (is_array($enemy_special))
  {
    $enemy_special = array_unique($enemy_special);
    for ($i = 0; $i < sizeof($enemy_special); $i++)
    {
      $its_specials = each($enemy_special);
      $special_symbols .= "<use xlink:href=\"#sStarSpecialSymbol_".$its_specials[1]."\" x=\"".($x + $abstand_x - ($i * 25))."\" y=\"".($y + $abstand_y)."\"  class=\"colorEnemyDiscreet\"/>";
    }
    $abstand_y += (-25);
  }

  if (is_array($neutral_special))
  {
    $neutral_special = array_unique($neutral_special);
    for ($i = 0; $i < sizeof($neutral_special); $i++)
    {
      $its_specials = each($neutral_special);
      $special_symbols .= "<use xlink:href=\"#sStarSpecialSymbol_".$its_specials[1]."\" x=\"".($x + $abstand_x - ($i * 25))."\" y=\"".($y + $abstand_y)."\" class=\"colorNeutralDiscreet\"/>";
    }
    $abstand_y += (-25);
  }

  return $special_symbols;
}

//_____________________________________________________________________________
//**********************
//*
//* draw_system_name($sid, $name, $its_x, $its_y)
//*
//**********************
function draw_system_name($sid, $scan, $name, $its_x, $its_y)
{
  $its_name = "<g><text x=\"".$its_x."\" y=\"".($its_y + 20)."\" text-anchor=\"middle\">".$name."</text>";
  
  if ($scan)
  if (is_homesystem($sid))
    $its_name .= "<use xlink:href=\"#sHomeSystem\" x=\"".($its_x - (strlen($name) / 2 * 6) - 15)."\" y=\"".($its_y + 12)."\"/>";
  
  return $its_name . "</g>";
}




//_____________________________________________________________________________
//**********************
//*
//* constellation_grid()
//*
//**********************
function constellation_grid()
{
  $sth = mysql_query("select max(x), max(y), min(x), min(y) from systems group by cid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  while ($system_max_coords = mysql_fetch_array($sth))
  {
    $universe = new universe;
    $bla = $universe->get_start_coords($system_max_coords["min(x)"],$system_max_coords["max(x)"],$system_max_coords["min(y)"], $system_max_coords["max(y)"]);
    $min_x = $bla[0];
    $max_x = $bla[1];
    $min_y = $bla[2];
    $max_y = $bla[3];
    echo("<rect x=\"".$min_x."\" y=\"".$min_y."\" width=\"".($max_x - $min_x)."\" height=\"".($max_y - $min_y)."\" class=\"constellationGrid\" pointer-events=\"none\"/>");

    $its_name = $constellations["name"];
    $its_name_length = strlen($its_name) * 7;

    echo("<text x=\"".($min_x + 10)."\" y=\"".($min_y + 10)."\" class=\"constellationText\" pointer-events=\"none\">".$its_name."</text>");
    echo("<text x=\"".($min_x + 10)."\" y=\"".($max_y - 10)."\" class=\"constellationText\" pointer-events=\"none\">".$its_name."</text>");
    echo("<text x=\"".($max_x - $its_name_length)."\" y=\"".($min_y + 10)."\" class=\"constellationText\" pointer-events=\"none\">".$its_name."</text>");
    echo("<text x=\"".($max_x - $its_name_length)."\" y=\"".($max_y - 10)."\" class=\"constellationText\" pointer-events=\"none\">".$its_name."</text>");
  }
}


/*****************
 *
 * function get_userstypes_in_system($sid)
 *
 *****************/
function get_userstypes_in_system($sid)
{
  global $map_info;
  global $uid;

  $users_in_system = $map_info->get_uid_by_sid($sid, true);

  $system=$map_info->get_system($sid);
  $system_name_length = strlen($system["name"]) * 6;

  if (is_array($users_in_system))
  {
    $color[0]["count"] = 0;
    $color[0]["class"] = "colorOwn";

    $color[1]["count"] = 0;
    $color[1]["class"] = "colorAllied";

    $color[2]["count"] = 0;
    $color[2]["class"] = "colorFriend";

    $color[3]["count"] = 0;
    $color[3]["class"] = "colorNeutral";

    $color[4]["count"] = 0;
    $color[4]["class"] = "colorEnemy";

    for ($i = 0; $i < sizeof($users_in_system); $i++)
    {
      if (isset($users_in_system[$i]))
      {
        if ($users_in_system[$i] == $uid)
          $color[0]["count"] += 1;
        elseif ($map_info->get_alliance($users_in_system[$i]) == "0")      // wenn der user keine allianz hat ist er NEUTRAL
          $color[3]["count"]  += 1;
        else
        {
          if ($map_info->is_allied($users_in_system[$i]))            //allied #FFF7A
            $color[1]["count"] += 1;
          elseif ($map_info->is_friendly($users_in_system[$i]))     //friend
            $color[2]["count"] += 1;
          elseif ($map_info->is_enemy($users_in_system[$i]))        //enemy #820000
            $color[4]["count"] += 1;
          else
            $color[3]["count"] += 1;     //neutral #006AFF
        }
      }   // end if (ifset...)
    }     // end for ($j = 0; ...)

  if (sizeof($users_in_system) > 0)
  {
    $sum_count = 0;
    $userstypes_in_system .= "<g id=\"user_in_system_".$sid."\">";
    for ($i = 0; $i < sizeof($color); $i++)
    {
      if ($i == 0)
        $its_x = round(($system_name_length / -2),1);
      else
        $its_x = round((($system_name_length/sizeof($users_in_system) * $sum_count) + ($system_name_length / -2)),1);

      $its_width = round(($system_name_length/sizeof($users_in_system) * $color[$i]["count"]),1);

      $userstypes_in_system .= "<rect x=\"".$its_x."\" y=\"0\" width=\"".$its_width."px\" height=\"1px\" class=\"".$color[$i]["class"]."\"/>";

      $sum_count += $color[$i]["count"];
    }
    $userstypes_in_system .= "</g>";
  }
}
return $userstypes_in_system;
}


/*****************
*
* function get_fleet_routes($fleets)
*
*****************/
function get_fleet_routes($fleets)
{
global $map_info;

for ($i = 0; $i < sizeof($fleets); $i++)
{
  $fleet_routes .= create_fleet_route($fleets[$i],$map_info, 0);
}
return $fleet_routes;
}


/*****************
*
* function get_stars($constellations)
*
*****************/
function get_stars()
{
global $uid;
global $map_info;

// Systeme in denen Planeten sind und die die Gebäuden Scanrange sind

//  $possible_scan_systems = get_possible_scan_systems($uid, $constellations);
$possible_scan_systems = $map_info->get_scanned_systems();
$fog_of_war=$map_info->get_fog_of_war();

$stars=$map_info->get_stars_info();

foreach ($stars as $sid => $star_info)
{
  $closest_stars[$sid]["x"] = $star_info["x"];
  $closest_stars[$sid]["y"] = $star_info["y"];
  $closest_stars[$sid]["name"] = $star_info["name"];
  $closest_stars[$sid]["scan"] = SYSTEM_UNKOWN;

  if (in_array($sid, $possible_scan_systems) || $map_info->fleet_in_sid($uid,$sid))
  {
    $userstypes_in_system = get_userstypes_in_system($sid);
    $closest_stars[$sid]["userstypes"] = $userstypes_in_system;
    $closest_stars[$sid]["scan"] = SYSTEM_VISIBLE;
  }
  elseif ($fog_of_war[$sid])
  {
    $closest_stars[$sid]["scan"] = SYSTEM_FOGGED;
  }
}                             // end foreach

// Systeme in denen Flotten sind;
// - nur die Flotten in den Constellationen raussuchen
$allies = $map_info->get_allies();
if (is_array($allies))
{
  array_push($allies, $uid);
  for ($i = 0; $i < sizeof($allies);$i++)
  {
    if (is_array($user_fleets))
    {
      $user_fleets  = array_merge($user_fleets, $map_info->get_fids_by_uid($allies[$i]));
    }
    else
      $user_fleets  = $map_info->get_fids_by_uid($allies[$i]);
  }
}
else
{
  $user_fleets  = $map_info->get_fids_by_uid($uid);
}

$fleet_systems=$map_info->get_all_fleet_scans();

if (is_array($fleet_systems))
{
  for ($i = 0; $i < sizeof($fleet_systems); $i++)
  {
    //echo($fleet_systems." =>\n");
    //var_dump($closest_stars[$fleet_systems[$i]]);
    //echo("============================\n\n");

    $closest_stars[$fleet_systems[$i]][scan] = true;
    //var_dump($closest_stars[$fleet_systems[$i]]);
    //echo("============================FERTIG\n\n");

    if ($userstypes_in_system = get_userstypes_in_system($fleet_systems[$i]))
      $closest_stars[$fleet_systems[$i]]["userstypes"] = $userstypes_in_system;
  }
}
//  var_dump($closest_stars);
return $closest_stars;
}

function draw_scancircles($x, $y, $r)
{
$scancircles = "<circle cx=\"".$x."\" cy=\"".$y."\" r=\"".$r."\" style=\"fill:#001243;stroke:none;\" pointer-events=\"none\"/>";

return $scancircles;
}

function draw_fleet_scancircles($x,$y,$sid)
{
global $map_info;

if ($r = $map_info->get_fleet_scan_radius($sid))
{
  $scancircles = "<circle cx=\"".$x."\" cy=\"".$y."\" r=\"".$r."\" style=\"fill:#404283;stroke:none;\" pointer-events=\"none\"/>";
}
return $scancircles;
}


//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//----------------------------------------------------------------------------
//_____________________________________________________________________________

/**
* holt alle sterne zu gegebenen constellationen
*
* @param $cids
* @return
*/
function get_svg_stars_of_cids($cids,&$fleet_symbols,&$fleet_routes,&$scans, &$systems)
{
global $uid;
global $map_info;

$closest_stars = get_stars($cids);

$system_user_type_defs = "<defs>";
$system_user_type = "<g pointer-events=\"none\">";
if (is_array($closest_stars))
{
  $scans            = "<g pointer-events=\"none\" id=\"scanradien\">";
  $system_names     = "<g style=\"font-size:7pt;fill:#A5D9FF;stroke:none;font-family:verdana,arial;letter-spacing:1pt;\" pointer-events=\"none\">";
  $systems          = "<g onclick=\"clickOnStar(evt);\" onmouseover=\"mouseoverStar(evt);\" onmouseout=\"mouseoutStar(evt);\">";

  foreach ($closest_stars as $sid => $its_star)
  {
    if ($its_star["userstypes"])
    {
      $system_user_type_defs.= $its_star["userstypes"];
      $system_user_type     .= "<use xlink:href=\"#user_in_system_".$sid."\" x=\"".($its_star[x])."\" y=\"".($its_star[y]+25)."\"/>";

      // scanradien, wenn ein system ein system_user_type hat, ist jemand in dem system, können also scanradien vorhanden sein
      if ($map_info->is_own_star($sid))
      {
        $scanrange = $map_info->get_systemscanradius($sid);
        $scans .= draw_scancircles($its_star[x], $its_star[y], $scanrange);
      }
    }

    $systems      .= draw_star($its_star["x"], $its_star["y"],$sid, $its_star["scan"]);
    $system_names .= draw_system_name($sid, $its_star["scan"], $its_star["name"],$its_star["x"], $its_star["y"]);

    //___________________________ System Flotten
    if ($its_star["scan"]==SYSTEM_VISIBLE)
    {
      $system_fleets   = $map_info->get_fids_by_sid($sid);
      if (is_array($system_fleets))
      {
        $fleet_symbols  .= draw_fleets($its_star[x], $its_star[y], $system_fleets, $sid);
        $fleet_routes   .= get_fleet_routes($system_fleets);
      }
      $fleet_scans          .= draw_fleet_scancircles($its_star[x], $its_star[y],$sid);
    }

    //___________________________ Spezial Symbole
    $special_symbols = $map_info->get_special_buildings_by_sid($sid,1);
    if (is_array($special_symbols))
    {
      $specials     .= "<g id=\"specialSymbols_".$sid."\" pointer-events=\"none\">";
      $specials     .= draw_special_symbols($its_star[x], $its_star[y], $special_symbols, $sid);
      $specials     .= "<set attributeType=\"XML\" attributeName=\"display\" to=\"none\" begin=\"s".$sid.".mouseover\"/>";
      $specials     .= "<set attributeType=\"XML\" attributeName=\"display\" to=\"inherit\" begin=\"s".$sid.".mouseout\"/>";
      $specials     .= "</g>";
    }
  }
}
$system_user_type_defs .= "</defs>";
$system_user_type .= "</g>";
$system_names .= "</g>";
$systems      .= "</g>";
$scans .= $fleet_scans;
$scans .= "</g>";

$systems = $system_user_type_defs . $system_user_type . $systems . $system_names . $specials;
}

//**********************
//*
//* startup()
//*
//**********************
function startup()
{
global $uid;
global $ses;
global $globalTranslate;
$availHeight = $_GET["availHeight"];
$availWidth  = $_GET["availWidth"];

$globalTranslate = get_global_SVGTransform($uid, 0, 0, $availHeight, $availWidth);

$ses->reg("globalTranslate");
$universe=new universe;

$cids=$universe->get_surrounding_constellations(get_cid_by_sid(get_sid_by_pid(get_homeworld($uid))));
$GLOBALS["map_info"]=new map_info($uid,$cids);

get_svg_stars_of_cids($cids,$fleet_symbols,$fleet_routes,$scans, $systems);

echo("<g id=\"startranslate\" transform=\"translate(".$globalTranslate.")\">");
// runelord: zuerst die scans, damit die nix verdecken
echo("<g id=\"fleet_scans\">\n");
echo($scans);
echo("</g>\n");
// mop: dann die constellationen malen, damit die sterne drüberliegen können
echo("<g id=\"constellationgrid\">");
constellation_grid();
echo("</g>");
echo("<g id=\"stars\">");
echo($systems);
echo("</g>");
echo("<g id=\"flottenpfade\">\n");
echo($fleet_routes);
echo("</g>\n");
echo("<g id=\"fleet_symbols\">\n");
echo($fleet_symbols);
echo("</g>\n");
echo("</g>");

$coords=$universe->get_coords_by_cids($cids);

$translate=explode(" ",$globalTranslate);

echo("\n<!-- ".($coords[0]+$translate[0])." ".($coords[1]+$translate[0])." ".($coords[2]+$translate[1])." ".($coords[3]+$translate[1])." -->");
}

/**
* lädt sterne nach
*
* @return
*/
function postload_stars()
{
/**
 * von geturl
 */

global $x,$y;
global $globalTranslate;
global $uid;

$translate=explode(" ",$globalTranslate);

$x+=(-$translate[0]);
$y+=(-$translate[1]);

if ($x<=0)
  $x=1;
if ($y<=0)
  $y=1;

$universe=new universe;

$cids=$universe->get_surrounding_constellations($universe->const_exists($universe->get_start_coords($x,$x,$y,$y)));
$GLOBALS["map_info"]=new map_info($uid,$cids);

if (sizeof($cids)>0)
{
  get_svg_stars_of_cids($cids,$fleet_symbols,$fleet_routes,$scans, $systems);
  // runelord: XML Root benötigt
  echo("<g id=\"universe_temp_container\">");
  echo("<g id=\"fleet_scans\">\n");
  echo($scans);
  echo("</g>\n");
  echo("<g id=\"stars\">\n");
  echo($systems);
  echo("</g>\n");
  echo("<g id=\"flottenpfade\">\n");
  echo($fleet_routes);
  echo("</g>\n");
  echo("<g id=\"fleet_symbols\">\n");
  echo($fleet_symbols);
  echo("</g>\n");
  echo("</g>");

  // mop: arrays zusammenfügen, um sie in der session zu speichern

  $coords=$universe->get_coords_by_cids($cids);

  echo("\n<!-- ".($coords[0]+$translate[0])." ".($coords[1]+$translate[0])." ".($coords[2]+$translate[1])." ".($coords[3]+$translate[1])." -->");
}
}

/*************************
*
* function show_fleet_route()
*
**************************/
function show_fleet_route()
{
global $fid;
global $uid;
$availHeight = $_GET["availHeight"];
$availWidth  = $_GET["availWidth"];
global $map_info;

$its_uid = $map_info->get_uid_by_fid($fid);
if ($uid == $its_uid or $map_info->is_allied($its_uid))
{
  $its_route = create_fleet_route($fid,$map_info, 1);
}
echo($its_route);
}

//_____________________________________________________________________________
//**********************
//*
//* main
//*
//**********************
switch ($_GET["act"])
{
case "startup":
  startup();
break;
case "postload_stars":
  postload_stars();
break;
case "fleet_route":
  show_fleet_route();
break;
}
$ses->page_end();
if ($_GET["debug"])
{
  $text=ob_get_contents();
  ob_end_clean();

  echo(str_replace(">",">\n",str_replace("\n","",$text)));
  $time_end = microtime();
  list($time_end_msec,$time_end_sec) = split(" ",$time_end);
  list($time_beg_msec,$time_beg_sec) = split(" ",$time_begin);
  $timediff = $time_end_sec + $time_end_msec - $time_beg_sec - $time_beg_msec;
  print "<p class=txt>&nbsp;&nbsp;<i>Zeitverbrauch (in Sekunden): $timediff</i>";
}
else {
  $content=ob_get_contents();
  ob_end_clean();

  print gzcompress($content);
  //print $content;
}
?>
