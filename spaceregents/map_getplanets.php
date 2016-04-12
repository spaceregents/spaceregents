<?
// ____________________________________________________ includes
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/trade.inc.php";
include "../spaceregentsinc/ressources.inc.php";
include "../spaceregentsinc/class_map_info.inc.php";

// ____________________________________________________ globals
$sid          = $_GET["sid"];
$availHeight  = $_GET["availHeight"];
$availWidth   = $_GET["availWidth"];

global $sid;
global $availHeight;
global $availWidth;
global $uid;

// ____________________________________________________ functions
// ****************
// *
// * function get_radius($p_type)
// *
// ****************
function get_radius($p_type)
{
  switch ($p_type)
  {
    case "E":
    $radius = 6;
    break;
    case "O":
    $radius = 6;
    break;
    case "M":
    $radius = 5;
    break;
    case "D":
    $radius = 5;
    break;
    case "I":
    $radius = 4;
    break;
    case "A":
    $radius = 6;
    break;
    case "R":
    $radius = 3;
    break;
    case "G":
    $radius = 8;
    break;
    case "H":
    $radius = 10;
    break;
    case "T":
    $radius = 7;
    break;
  }
  return $radius;
}


// ****************
// *
// * function get_style($p_uid)
// *
// ****************
function get_style($p_uid)
{
  global $uid;

  if ($p_uid == 0)
    $relation = "None";
  else
    $relation = get_uids_relation($uid, $p_uid);

  $relation = ucfirst($relation);
  return "planets" . $relation;
}



// ****************
// *
// * function draw_fleet($fid)
// *
// ****************
function draw_fleet($fids, $pid)
{
  global $uid;

  for ($i = 0; $i < sizeof($fids); $i++)
  {
    $its_uid = get_uid_by_fid($fids[$i]);

    $relation = get_uids_relation($uid, $its_uid);

    switch($relation)
    {
      case "same":
        $same++;
      break;
      case "allie":
        $allie++;
      break;
      case "friend":
        $friend++;
      break;
      case "enemy":
        $enemy++;
      break;
      case "neutral":
        $neutral++;
      break;
    }
  }

  $root_x = 10;
  $root_y = 20;

  if ($same)
  {
    $x = $root_x * -1;
    $y = $root_y * -1;

    // $fleets .= "<g onclick=\"showUnits('".$pid."',95);\" class=\"fleetsOwn\">";
    $fleets .= "<g class=\"fleetsOwn\">";
    $fleets .= "<use xlink:href=\"#sShip\" x=\"".$x."\" y=\"".$y."\"/>";
    $x = $x - 3;
    $y = $y + 9;
    for ($i = 0; $i < $same; $i++)
    {
      $y -= 3;
      if ($i >= 4)
      {
        $x += -3;
        $y  = ($root_y * -1) + 9;
      }
      $fleets .= "<rect x=\"".$x."\" y=\"".$y."\" width=\"2\" height=\"1\"/>";
    }
    $fleets .= "</g>";
  }

  if ($allie)
  {
    $x = ($root_x + 10) * -1;
    $y = ($root_y * 0) - 5;

    // $fleets .= "<g onclick=\"showUnits('".$pid."',96);\" class=\"fleetsAllied\">";
    $fleets .= "<g class=\"fleetsAllied\">";
    $fleets .= "<use xlink:href=\"#sShip\" x=\"".$x."\" y=\"".$y."\"/>";
    $x = $x - 3;
    $y = $y + 9;
    for ($i = 0; $i < $allie; $i++)
    {
      $y -= 3;
      if ($i >= 4)
      {
        $x += -3;
        $y  = ($root_y * 0) + 9;
      }
      $fleets .= "<rect x=\"".$x."\" y=\"".$y."\" width=\"2\" height=\"1\"/>";
    }
    $fleets .= "</g>";
  }


  if ($friend)
  {
    $x = $root_x * -1;
    $y = $root_y - 10;

    //$fleets .= "<g onclick=\"showUnits('".$pid."',97);\" class=\"fleetsFriend\">";
    $fleets .= "<g class=\"fleetsFriend\">";
    $fleets .= "<use xlink:href=\"#sShip\" x=\"".$x."\" y=\"".$y."\"/>";
    $x = $x - 3;
    $y = $y + 9;
    for ($i = 0; $i < $friend; $i++)
    {
      $y -= 3;
      if ($i >= 4)
      {
        $x += -3;
        $y  = ($root_y * -1) + 9;
      }
      $fleets .= "<rect x=\"".$x."\" y=\"".$y."\" width=\"2\" height=\"1\"/>";
    }
    $fleets .= "</g>";
  }

  if ($neutral)
  {
    $x = $root_x - 5;
    $y = $root_y - 10;

    //$fleets .= "<g onclick=\"showUnits('".$pid."',98);\" class=\"fleetsNeutral\">";
    $fleets .= "<g class=\"fleetsNeutral\">";
    $fleets .= "<use xlink:href=\"#sShip\" x=\"".$x."\" y=\"".$y."\"/>";
    $x = $x + 10;
    $y = $y+9;
    for ($i = 0; $i < $neutral; $i++)
    {
      $y -= 3;
      if ($i >= 4)
      {
        $x += 3;
        $y  = $root_y + 9;
      }
      $fleets .= "<rect x=\"".$x."\" y=\"".$y."\" width=\"2\" height=\"1\"/>";
    }
    $fleets .= "</g>";
  }

  if ($enemy)
  {
    $x = $root_x;
    $y = ($root_y * 0) - 5;

    //$fleets .= "<g onclick=\"showUnits('".$pid."',99);\" class=\"fleetsEnemy\">";
    $fleets .= "<g class=\"fleetsEnemy\">";
    $fleets .= "<use xlink:href=\"#sShip\" x=\"".$x."\" y=\"".$y."\"/>";
    $x = $x + 10;
    $y = $y+9;
    for ($i = 0; $i < $enemy; $i++)
    {
      $y -= 3;
      if ($i >= 4)
      {
        $x += 3;
        $y  = $root_y + 9;
      }
      $fleets .= "<rect x=\"".$x."\" y=\"".$y."\" width=\"2\" height=\"1\"/>";
    }
    $fleets .= "</g>";
  }

  // hack, custom element, das anzeigt was für flotten bei dem planeten vertreten sind
  $fleets .= "<SR_FLEET_AT_PLANET enemy=\"".$enemy."\" allied=\"".$allied."\" own=\"".$same."\" friendly=\"".$friend."\" neutral=\"".$neutral."\"/>";

  return $fleets;
}


/*******************
 *
 * draw_tradingstation($pid, $y)
 *
 *******************/
function draw_tradingstation($pid, $y)
{
  $SVG_output  = "<g>\n";
  $SVG_output .= "<use x=\"0\" y=\"".$y."\" xlink:href=\"#sTradingStation\"/>\n";
  $SVG_output .= "</g>\n";

  return $SVG_output;
}


function draw_jumpgate($sid)
{
  global $map_info;

  $jumpgate_pid = get_pid_of_jumpgate($sid);

  if ($jumpgate_pid)
  {
    echo("<g onclick=\"clickOnJumpGate(evt)\" id=\"j".$sid."\">\n");
    echo("<g transform=\"translate(10 -30)\">\n");
    echo("<g>\n");
    echo("<use xlink:href=\"#sJumpgate\" id=\"j".$sid."UseElement\" x=\"0\" y=\"0\"/>\n");

    if (($uid == get_uid_by_pid($jumpgate_pid)) || (is_allied($uid, get_uid_by_pid($jumpgate_pid))))
    {
      echo("<noPass />");
      $jumpgate_prod_id = get_jumpgate_by_pid($jumpgate_pid);
      $current_tonnage  = get_jumpgate_used_tonnage($jumpgate_pid);

      if ($current_tonnage != 0)
      {
  $max_tonnage      = get_jumpgate_max_tonnage($jumpgate_prod_id);
  $tonnage_percent  = 0.3 * ($current_tonnage * 100) / $max_tonnage; // 0.3 weil die anzeige exakt 30 pixel groß ist
  echo("<clipPath id=\"cJumpgate".$sid."\">");
  echo("<rect x=\"34\" y=\"".$tonnage_percent."\" width=\"4\" height=\"".(30 - $tonnage_percent)."\"/>");
  echo("</clipPath>");
  echo("<rect x=\"35\" y=\"0\" width=\"2\" height=\"".$tonnage_percent."\" style=\"stroke:blue;stroke-width:0.2pt;fill:black;\"/>");
  echo("<rect clip-path=\"url(#cJumpgate".$sid.")\" clip-rule=\"nonzero\" x=\"35\" y=\"0\" fill=\"url(#gLRedGreen)\" width=\"2\" height=\"30\" style=\"stroke:blue;stroke-width:0.2pt;\"/>");
      }
      else
      {
  echo("<rect x=\"35\" y=\"0\" fill=\"url(#gLRedGreen)\" width=\"2\" height=\"30\" style=\"stroke:blue;stroke-width:0.2pt;\"/>");
      }

    }

    if ($map_info->has_map_anims())
      echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"360;0\" dur=\"".(($j+2) * 100)."\" repeatCount=\"indefinite\"/>");

    echo("</g>");
    echo("</g>");

    if ($map_info->has_map_anims())
      echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"0;360\" dur=\"".(($j+2) * 100)."\" repeatCount=\"indefinite\"/>");

    echo("</g>\n");
  }
}



/* ****************
 *
 * main
 *
 *****************/
$map_info         = new map_info($uid);
$fog_of_war       = $map_info->get_fog_of_war();

if (!in_array($sid,$map_info->get_scanned_systems()) && !$fog_of_war[$sid])
  return false;

if (!in_array($sid,$map_info->get_scanned_systems()))
  $fog_mode=true;
else
  $fog_mode=false;

if ($fog_mode)
  $planets=array_values($fog_of_war[$sid]);
else
  $planets          = $map_info->get_systemplanets($sid);
$globalTransform  = get_global_SVGTransform($uid, 1, $sid, $availHeight, $availWidth);
$abstand          = 30;

$inner_moves=array();

echo("<g id=\"planets".$sid."\" transform=\"translate(".$globalTransform.")\"".($fog_mode ? " fogged=\"1\" style=\"opacity:0.5\"" : " fogged=\"0\"").">");

if (is_array($planets))
{
  $planet_count = sizeof($planets) + 1;
  $max_size     = $planet_count * $abstand + 10;

  echo("<g class=\"displayMarker\">");
  echo("<path d=\"M-10,0 v-10 h10\"/>");
  echo("<path d=\"M10,0 v10 h-10\"/>");
  echo("</g>");

  echo("<g pointer-events=\"none\" class=\"planetsOrbits\">\n");
  for ($j = 1; $j < $planet_count; $j++)
  {
    echo("<circle cx=\"0\" cy=\"0\" r=\"".($abstand * ($j+1))."\"/>\n");
  }
  echo("</g>\n");
  
  if (!$fog_mode)
  {
    $its_jump_movements = get_jump_movements($uid,$sid);
    $its_inner_movements = get_inner_movements($uid,$sid);

    if (is_array($its_inner_movements))
    {
      reset($its_inner_movements);

      foreach ($its_inner_movements as $fid => $way)
      {
        $src_pid="p".$way[0];
        $dest_pid="p".$way[1];
        $inner_moves[]="<line id=\"proutei_".$fid."\" src_pid=\"".$src_pid."\" dest_pid=\"".$dest_pid."\" x1=\"0\" y1=\"0\" x2=\"0\" y2=\"0\" class=\"fleetsRoutes\"/>";
      }
    }
  }

  for ($j = 0; $j < sizeof($planets); $j++)
  {
    $p_uid      = $planets[$j]["uid"]; //get_uid_by_pid($planets[$j]);
    $p_type     = $planets[$j]["type"]; //get_planets_type($planets[$j]);
    $its_name   = addslashes($planets[$j]["name"]); //get_planetname($planets[$j]);
    // $its_class  = get_style($p_uid);

    if ($p_uid > 0) {
      $its_class  = get_uids_relation($uid, $p_uid, 1);
      $its_relation = strtolower(substr($its_class,5));
      $its_class .= "Outline";
    }
    else{
      $its_class = "colorNoneOutline";
      $its_relation = "none";
    }

    $its_radius = get_radius($p_type);
    if (!$fog_mode)
      $its_fleets = get_fids_by_pid($planets[$j]["id"]);

    if ($p_type != "G")
      $its_image  = "<image onmouseover=\"updateStatusText('".$its_name."');\" onmouseout=\"updateStatusText(' ');\" xlink:href=\"arts/".$p_type."_small.gif\" width=\"".($its_radius * 2)."\" height=\"".($its_radius * 2)."\" x=\"".(($j+2) * $abstand - ($its_radius))."\" y=\"".(- $its_radius)."\"/>\n";
    else
      $its_image  = "<image onmouseover=\"updateStatusText('".$its_name."');\" onmouseout=\"updateStatusText(' ');\" xlink:href=\"arts/".$p_type."_small.gif\" width=\"".($its_radius * 4)."\" height=\"".($its_radius * 4)."\" x=\"".(($j+2) * $abstand - ($its_radius * 2))."\" y=\"".(- $its_radius * 2)."\"/>\n";  // speziell wegen den Ringen der Gas Giganten Klasse

    echo("<g>\n");
    /************************
    - neue Function bei click auf planeten:
    - clickOnPlanet(evt, 'planet')
    - old: echo("<g onclick=\"showInfo(evt, 'planet');\" id=\"p".$planets[$j]."\">\n");
    -
    ************************/
    echo("<g onclick=\"clickOnPlanet(evt);\" id=\"p".$planets[$j]["id"]."\" cursor=\"pointer\" type=\"".$p_type."\" relation=\"".$its_relation."\" rhint=\"".($j+2)*$abstand."\">\n");
    if ($its_jump_movements[$planets[$j]["id"]])
    {
      echo("<line id=\"proute".$its_jump_movements[$planets[$j]["id"]]."\" x1=\"0\" y1=\"0\" x2=\"".(($j+2) * $abstand - ($its_radius))."\" y2=\"0\" class=\"fleetsRoutes\"/>\n");
    }

    echo($its_image);
    echo("<circle id=\"p".$planets[$j]["id"]."s".$sid."\" cx=\"".(($j+2) * $abstand)."\" cy=\"0\" r=\"".$its_radius."\" class=\"".$its_class."\"/>\n");
    
    echo("</g>");
    echo("<g transform=\"translate(".(($j+2) * $abstand)." 0)\">\n");
    echo("<g>\n");
    
    if (!$fog_mode)
    {
	    // planetary shield
			if (has_shield($planets[$j]["id"]))
			{
				echo("<circle cx=\"0\" cy=\"0\" r=\"".($its_radius+4)."\" class=\"pshield\"/>\n");
 		    echo("<circle cx=\"0\" cy=\"0\" r=\"".($its_radius+4)."\" class=\"".$its_class."\"/>\n");
			}
			
      //----------------- Tradingstation
      if (has_tradingstation($planets[$j]["id"]))
      {
        $planets_tradingstation = draw_tradingstation($planets[$j]["id"], (- $its_radius - $abstand));
        echo($planets_tradingstation);
      }
      //----------------- Flotten
      if (is_array($its_fleets))
      {
        $p_fleet = draw_fleet($its_fleets, $planets[$j]["id"]);
        echo("<g>\n");
        echo($p_fleet);
        echo("</g>\n\n");
      }
    }
    if ($map_info->has_map_anims())
      echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"360;0\" dur=\"".(($j+1) * 100)."\" repeatCount=\"indefinite\" begin=\"0;indefinite\" end=\"indefinite\"/>");
    echo("</g>");
    echo("</g>");
    if ($map_info->has_map_anims())
      echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"0;360\" dur=\"".(($j+1) * 100)."\" repeatCount=\"indefinite\" begin=\"0;indefinite\" end=\"indefinite\" fill=\"freeze\"/>");
    echo("</g>");
  }

  //----------------- Jumpgate
  if (!$fog_mode)
    draw_jumpgate($sid);
}

if (!$fog_mode)
{
  $system_fleets= get_system_fleets($sid);

  if (is_array($system_fleets))
  {
    /*if ($j <= 0)
      {
      $j = get_planet_count_by_sid($sid);
      }
     */
    echo("<g>");
    echo("<g transform=\"translate(".$abstand." 0)\">");
    echo("<g>");
    $s_fleet = draw_fleet($system_fleets, "s".$sid);
    echo($s_fleet);
    if ($map_info->has_map_anims())
      echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"360;0\" dur=\"100\" repeatCount=\"indefinite\"/>");
    echo("</g>");
    echo("</g>");
    if ($map_info->has_map_anims())
      echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"0;360\" dur=\"100\" repeatCount=\"indefinite\"/>");
    echo("</g>\n");
  }

  echo("<g id=\"iMoves".$sid."\">");
  foreach ($inner_moves as $move)
  {
    echo($move);
  }
  echo("</g>\n");
}
echo("</g>");

$content=ob_get_contents();
ob_end_clean();

#if ($_GET["debug"] == 1)
  print $content;
#else 
#  print gzcompress($content);
?>
