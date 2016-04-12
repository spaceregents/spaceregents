<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/class_universe.inc.php";
include "../spaceregentsinc/class_map_info.inc.php";

// Todo: Scanradien der Schiffe
//       Jumpgates

$GLOBALS["__starinfo"]["own"]=array("color"=>"lime",
            "width"=>100,
            "stars"=>array()
            );
$GLOBALS["__starinfo"]["all"]=array("color"=>"yellow",
            "width"=>80,
            "stars"=>array()
            );
$GLOBALS["__starinfo"]["fri"]=array("color"=>"orange",
            "width"=>60,
            "stars"=>array()
            );
$GLOBALS["__starinfo"]["neu"]=array("color"=>"blue",
            "width"=>20,
            "stars"=>array()
            );
$GLOBALS["__starinfo"]["ene"]=array("color"=>"red",
            "width"=>40,
            "stars"=>array()
            );

function add_system_ownership($sid,$info)
{
  global $uid;
  global $map_info;

  if ($users=$map_info->get_uid_by_sid($sid))
  {
    $colors=array();
    $users=array_unique($users);

    for ($i=0;$i<sizeof($users);$i++)
    {
      if ($users[$i]==$uid)
        $GLOBALS["__starinfo"]["own"]["stars"][]=$info;
            elseif ($map_info->is_allied($users[$i]))
        $GLOBALS["__starinfo"]["all"]["stars"][]=$info;
            elseif ($map_info->is_enemy($users[$i]))
        $GLOBALS["__starinfo"]["ene"]["stars"][]=$info;
            elseif ($map_info->is_friendly($users[$i]))
        $GLOBALS["__starinfo"]["fri"]["stars"][]=$info;
            else
        $GLOBALS["__starinfo"]["neu"]["stars"][]=$info;
    }
  }
}

function get_fleet_minimap_color($fid)
{
  global $uid;
  global $map_info;

  if ($owner = $map_info->get_uid_by_fid($fid))
  {
    if ($owner == $uid)
      $color="lime";
    elseif ($map_info->is_allied($owner))
      $color="yellow";
    elseif ($map_info->is_enemy($owner))
      $color="red";
    elseif ($map_info->is_friendly($owner))
      $color="orange";
    else
      $color="blue";

    return $color;
  }
  else
  {
    return false;
  }
}

//____________________________________________________________________________________________| draw_point
function draw_system($system) // ,$colors)
{
  $x = round(($system["x"]),1);
  $y = round(($system["y"]),1);

  $width=20;
  // mop: ersma hinmalen
  $SVG_output .= "<rect x=\"".$x."\" y=\"".$y."\" width=\"".$width."\" height=\"".$width."\" class=\"minimapDefaultStar\"/>\n";
  return $SVG_output;
}

function draw_colonized_stars()
{
  $SVG_output="";

  foreach ($GLOBALS["__starinfo"] as $who => $data)
  {
    $SVG_output.="<g id=\"".$who."MMap\" style=\"fill:".$data["color"].";stroke:".$data["color"].";stroke-width:20;fill-opacity:0.2;\">\n";
    foreach ($data["stars"] as $info)
    {
      $x = round((($info["x"]) - ($data["width"] / 2)),1);
      $y = round((($info["y"]) - ($data["width"] / 2)),1);

      $SVG_output.="<rect x=\"".$x."\" y=\"".$y."\" width=\"".$data["width"]."\" height=\"".$data["width"]."\"/>\n";
    }
    $SVG_output.="</g>\n";
  }

  return $SVG_output;
}


//____________________________________________________________________________________________| draw_fleets
function draw_fleets($x, $y, $fleets)
{
  global $map_info;
  global $uid;

  $new_x  = round(($x),1);
  $new_y  = round(($y),1);

  $use = Array("0","0","0","0","0");

  for ($i = 0; $i < sizeof($fleets); $i++)
  {
    $color = get_fleet_minimap_color($fleets[$i]);
    switch ($color)
    {
      case "lime":
        $use[0]  = "aMinimapOwnFleet";
      break;
      case "yellow":
        $use[1]  = "aMinimapAlliedFleet";
      break;
      case "orange":
        $use[2]  = "aMinimapFriendFleet";
      break;
      case "red":
        $use[3]  = "aMinimapEnemyFleet";
      break;
      case "blue":
        $use[4]  = "aMinimapNeutralFleet";
      break;
    }

  }

  for ($i = 0; $i < sizeof($use); $i++)
  {
    if ($use[$i] != "0")
    {
      $SVG_output .= "<use xlink:href=\"#".$use[$i]."\" x=\"".$new_x."\" y=\"".$new_y."\"/>\n";
    }
  }

  return $SVG_output;
}


//____________________________________________________________________________________________| draw_scancircles
function draw_scancircles($x, $y, $r)
{
  $r  = round(($r),1);

  if ($r > 0)
  {
    $x  = round(($x),1);
    $y  = round(($y),1);
    $SVG_output = "<circle cx=\"".$x."\" cy=\"".$y."\" r=\"".$r."\"/>\n";
  }

  return $SVG_output;
}




//____________________________________________________________________________________________| draw_minimap
function draw_minimap()
{
  global $map_info;
  global $uid;

  $systems=$map_info->get_stars_info();
  $scans=$map_info->get_scanned_systems();

  $SVG_scanradien = "<g class=\"minimapScancircles\">\n";
  foreach ($systems as $sid => $info)
  {
    $SVG_systems    .= draw_system($info); // mop: system zeichnen
    // Alle Systeme zeichnen
    if (in_array($sid,$scans) || $map_info->fleet_in_sid($uid,$sid))
    {
      add_system_ownership($sid,$info);
      if ($map_info->is_own_star($sid))
      {
        $SVG_scanradien .= draw_scancircles($info["x"], $info["y"], $map_info->get_systemscanradius($sid));
      }
      // mop: irgendwie suboptimal
      $fleets = $map_info->get_fids_by_sid($sid);
      $SVG_fleets .= draw_fleets($info["x"], $info["y"], $fleets);
      $SVG_scanradien.=draw_scancircles($info["x"],$info["y"],$map_info->get_fleet_scan_radius($sid));
    }
  }
  $SVG_systems.=draw_colonized_stars();
  $SVG_scanradien .= "</g>";
  $SVG_output = $SVG_scanradien . $SVG_systems . $SVG_fleets;
  return $SVG_output;
}


//____________________________________________________________________________________________| calculate_scale
function calculate_scale()
{
  $width = $_GET["size"];
  // $width = 2 * $circle_radius;

  $sth = mysql_query("select min(x), max(x), min(y), max(y) from systems");

  if (!$sth)
  return 0;

  $max_coords = mysql_fetch_array($sth);

  //$map_width = $max_coords["max(x)"] - $max_coords["min(x)"] - 10;
  //$map_height = $max_coords["max(y)"] - $max_coords["min(y)"] - 55;

  $map_width = $max_coords["max(x)"] - $max_coords["min(x)"] + 140;
  $map_height = $max_coords["max(y)"] - $max_coords["min(y)"] + 140;

//  $map_width += $map_width - $map_height;

  if ($map_width >= $map_height)
    $scale = $map_width / $width;
  else
    $scale = $map_height / $width;

  return $scale;
}



//____________________________________________________________________________________________| draw_position_rect
function draw_position_rect()
{
  global $uid;

  $map_size = get_mapsize($uid);

  $width  = ($map_size["width"]);  //-10 wegen dem rand des browsers
  $height = ($map_size["height"]); // -55 wegen der Statuszeile des browsers
  $homecoords = get_homeworld_coords($uid);
  $x      = ($homecoords[0]) - ($width / 2);
  $y      = ($homecoords[1]) - ($height / 2);
  $SVG_output = "<rect id=\"positionRect\" x=\"".$x."\" y=\"".$y."\" width=\"".$width."\" height=\"".$height."\" class=\"minimapPositionRect\" pointer-events=\"none\"/>";

  return $SVG_output;
}



//____________________________________________________________________________________________| draw_constellation_grid
function draw_constellation_grid()
{
  $sth = mysql_query("select max(x), max(y), min(x), min(y) from systems group by cid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  return 0;

  $SVG_output = "<g class=\"constellationMMapGrid\">";

  $gMaxX=0;
  $gMaxY=0;

  while ($system_max_coords = mysql_fetch_array($sth))
  {
    if ($gMaxX<$system_max_coords["max(x)"])
      $gMaxX=$system_max_coords["max(x)"];
    if ($gMaxY<$system_max_coords["max(y)"])
      $gMaxY=$system_max_coords["max(y)"];

    $universe = new universe;
    $bla = $universe->get_start_coords($system_max_coords["min(x)"],$system_max_coords["max(x)"],$system_max_coords["min(y)"], $system_max_coords["max(y)"]);
    $min_x = round(($bla[0]),1);
    $max_x = round(($bla[1]),1);
    $min_y = round(($bla[2]),1);
    $max_y = round(($bla[3]),1);
    $SVG_output .= "<rect x=\"".$min_x."\" y=\"".$min_y."\" width=\"".($max_x - $min_x)."\" height=\"".($max_y - $min_y)."\"/>\n";
  }
  $SVG_output .= "</g>\n";

  $SVG_output .= "<!-- ".$gMaxX." ".$gMaxY." -->\n";

  return $SVG_output;
}

function draw_hidden_jumpgates()
{
  global $map_info;
  global $uid;

  $jumpgates=$map_info->get_jumpgates();
  $scans=$map_info->get_scanned_systems();

  $output="<g id=\"jumpgates\" display=\"none\">\n";
  foreach ($jumpgates as $data)
  {
    if (in_array($data["sid"],$scans))
    {
      if ($data["uid"]==$uid)
        $relation="own";
      elseif ($map_info->is_allied($data["uid"]))
        $relation="allied";
      elseif ($map_info->is_friendly($data["uid"]))
        $relation="friendly";
      elseif ($map_info->is_enemy($data["uid"]))
        $relation="enemy";
      else
        $relation="neutral";

      $system=$map_info->get_system($data["sid"]);

      $output.="<circle id=\"j".$data["sid"]."\" cx=\"".round(($system["x"]),1)."\" cy=\"".round(($system["y"]),1)."\" r=\"60\" relation=\"".$relation."\" tonnage=\"".$data["tonnage"]."\" used_tonnage=\"".$data["used_tonnage"]."\" style=\"fill:darkgreen\" systemname=\"".addslashes($system["name"])."\" onmouseover=\"updateStatusText('Jumpgate in ".addslashes($system["name"])."')\" onmouseout=\"updateStatusText('')\"/>\n";
    }
  }
  $output.="</g>\n";
  return $output;
}




//____________________________________________________________________________________________
//*********************************
//*
//* MAIN
//*
//*********************************
$map_info=new map_info($uid);
$scale = calculate_scale();

$SVG_output .= "<g>\n";
$SVG_output .= "<clipPath id=\"cMinimap\">\n";
$SVG_output .= "<rect x=\"0\" y=\"0\" width=\"".$_GET["size"]."\" height=\"".$_GET["size"]."\"/>\n";
$SVG_output .= "</clipPath>\n";
$SVG_output .= "<g clip-path=\"url(#cMinimap)\" pointer-events=\"all\">\n";
$SVG_output .= "<g id=\"minimap\" transform=\"scale(".(1/$scale)." ".(1/$scale).")\">\n";
// Systeme ladem
//$systems = get_systems();
$SVG_output .= draw_minimap();
$SVG_output .= draw_constellation_grid();
$SVG_output .= draw_position_rect();
$SVG_output .= draw_hidden_jumpgates();
$SVG_output .= "</g>";
$SVG_output .= "</g>";
$SVG_output .= "</g>";

echo($SVG_output);

$content=ob_get_contents();
ob_end_clean();

#if (!$_GET["debug"])
#  print gzcompress($content);
#else
  print $content;
?>
