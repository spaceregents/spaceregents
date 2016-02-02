<?
/*************************
*
* function get_global_SVGTransform($uid, $type = 0, $sid = 0)
*
* function write_svg_header();
*
* function create_fleet_route($fid, $type, $globalTransform)
*
*************************/
//______________________________________________________________________
function get_global_SVGTransform($uid, $type = 0, $sid = 0, $innerHeight = 0, $innerWidth = 0)
{
 $homeWorld     = get_homeworld($uid);
 $homeSystem  = get_sid_by_pid($homeWorld);
 $homeCoords    = get_system_coords($homeSystem, 2);
 $homeX       = $homeCoords[x];
 $homeY       = $homeCoords[y];

 if ($type == 1)
 {
  $systemCoords   = get_system_coords($sid,2);
  $systemX        = $systemCoords[x];
  $systemY        = $systemCoords[y];
  if ($innerWidth < 800)
    $systemCoords   = ($systemX - $homeX + ($innerWidth / 3))." ".($systemY - $homeY  + ($innerHeight / 2));
  else
    $systemCoords   = ($systemX - $homeX + ($innerWidth / 2))." ".($systemY - $homeY  + ($innerHeight / 2));

  return $systemCoords;
 }
 else
 {
  if ($innerWidth < 800)
   $systemCoords   = (- $homeX + ($innerWidth / 3))." ".(- $homeY + ($innerHeight / 2));
  else
   $systemCoords   = (- $homeX + ($innerWidth / 2))." ".(- $homeY + ($innerHeight / 2));
  return $systemCoords;
 }
}


function create_user_tag($uid, $name, $empire, $alliance, $alliance_color, $alliance_symbol, $relation)
{
  $name     = addslashes($name);
  $empire   = addslashes($empire);
  $alliance = addslashes($alliance);

  $user_tag = "<SR_USER uid=\"".$uid."\" name=\"".$name."\" empire=\"".$empire."\" alliance=\"".$alliance."\" allianceColor=\"".$alliance_color."\" allianceSymbol=\"".$alliance_symbol."\" relation=\"".$relation."\" />";

  return $user_tag;
}


function create_resource_tag($metal, $energy, $mopgas, $erkunum, $gortium, $susebloom, $popgain)
{
  $resource_tag = "<SR_RESOURCES m=\"".$metal."\" e=\"".$energy."\" o=\"".$mopgas."\" r=\"".$erkunum."\" g=\"".$gortium."\" s=\"".$susebloom."\" popgain=\"".$popgain."\"/>";

  return $resource_tag;
}


function create_planet_tag($id, $name, $type, $pic, $startplanet, $population = false)
{
  $name = addslashes($name);
  $planet_tag = "<SR_PLANET pid=\"".$id."\" name=\"".$name."\" type=\"".$type."\" pic=\"".$pic."\" startplanet=\"".$startplanet."\" population=\"".$population."\"/>";

  return $planet_tag;
}


function create_buildings_tag($pid)
{
  // planetar buildings
  $sth = mysql_query("select p.prod_id, pid from production p, constructions c where p.prod_id=c.prod_id and pid='$pid' and type=0 order by name");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)) {
    while ($b = mysql_fetch_array($sth))
    {
      $buildings_tag .= "<SR_P_BUILD prod_id=\"".$b["prod_id"]."\"/>";
    }
  }

  // orbital buildings
  $sth = mysql_query("select p.prod_id, pid from production p, constructions c where p.prod_id=c.prod_id and pid='$pid' and type=1 order by name");
  if (!$sth)
    return false;

  if (mysql_num_rows($sth)) {
    while ($o = mysql_fetch_array($sth))
    {
      $buildings_tag .= "<SR_O_BUILD prod_id=\"".$o["prod_id"]."\"/>";
    }
  }

  return $buildings_tag;
}


function create_production_tag($pid)
{
  // planetar production
  $sth = mysql_query("select p.prod_id, planet_id, time, com_time from production p join p_production using(prod_id) having planet_id='$pid' order by pos");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)) {
    while ($p = mysql_fetch_array($sth))
      $production_tag .= "<SR_P_PROD prod_id=\"".$p["prod_id"]."\" time=\"".$p["time"]."\" comtime=\"".$p["com_time"]."\"/>";
  }

  // orbital production
  $sth = mysql_query("select p.prod_id, planet_id, time, com_time from production p join o_production using(prod_id) having planet_id='$pid' order by pos");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)) {
    while ($o = mysql_fetch_array($sth))
      $production_tag .= "<SR_O_PROD prod_id=\"".$o["prod_id"]."\" time=\"".$o["time"]."\" comtime=\"".$o["com_time"]."\"/>";
  }

  // ship production
  $sth = mysql_query("select p.prod_id, planet_id, time, com_time, count from production p join s_production using(prod_id) having planet_id='$pid' order by time");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)) {
    while ($s = mysql_fetch_array($sth))
      $production_tag .= "<SR_S_PROD prod_id=\"".$s["prod_id"]."\" time=\"".$s["time"]."\" comtime=\"".$s["com_time"]."\" count=\"".$s["count"]."\"/>";
  }

  // ifantry production
  $sth = mysql_query("select p.prod_id, planet_id, time, com_time, count from production p join i_production using(prod_id) having planet_id='$pid' order by time");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)) {
    while ($i = mysql_fetch_array($sth))
      $production_tag .= "<SR_I_PROD prod_id=\"".$i["prod_id"]."\" time=\"".$i["time"]."\" comtime=\"".$i["com_time"]."\" count=\"".$i["count"]."\"/>";
  }

  return $production_tag;
}


function create_infantry_tag($prod_id, $count, $tonnage = false)
{
  $inf_tag = "<SR_INF prod_id=\"".$prod_id."\" count=\"".$count."\"";

  if ($tonnage)
    $inf_tag .= " ton=\"".$tonnage."\"";

  $inf_tag .= "/>";

  return $inf_tag;
}


function can_scan_planet_surface($pid)
{
  global $map_info;
  global $uid;

  $can_scan = false;
  $sid = get_sid_by_pid($pid);

  // planetary shield und defence masquerader (15 & 38) können planeten scan verhindern)
  $sth = mysql_query("select distinct 1 from constructions where pid='".$pid."' and (prod_id=15 or prod_id=38)");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth) == 0)    // wir haben kein shield und keinen masquerader auf dem planeten
  {
    $allies = $map_info->get_allies();
    $allies[] = $uid;

    // probe sowie dreamcatcher können die planetenoberfläche scannen
    $sth = mysql_query("select distinct 1 from fleet_info fi join fleet f using(fid) where fi.uid in (".(implode(",",$allies)).") and fi.pid = '".$pid."' and (f.prod_id = 3 or f.prod_id = 35)");

    if (!$sth)
      return false;

    if (mysql_num_rows($sth) > 0)
      $can_scan = true;
  }
  return $can_scan;
}


//______________________________________________________________________
function write_svg_header()
{
 // klappt nicht
 echo("<?xml version=\"1.0\" standalone=\"no\" encoding=\"iso-8859-1\"?>\n");
 echo("<?xml-stylesheet href=\"css/minimap.css\" type=\"text/css\"?>\n");
 echo("<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 20000303 Stylable//EN\"   \"http://www.w3.org/TR/2000/03/WD-SVG-20000303/DTD/svg-20000303-stylable.dtd\">\n");
}


/*************************
*
* function show_svg_message($message)
*
**************************/
function show_svg_message($message)
{
 echo("<message type=\"MESSAGE\">".$message."</message>");
}


/*************************
*
* function svg_text_paragraph($message)
*
**************************/
function svg_text_paragraph($text)
{
  $para = "<SR_TEXT_PARA>";
  $para .= $text;
  $para .= "</SR_TEXT_PARA>";

  return $para;
}


/*************************
*
* function create_fleet_route($fid, $type, $globalTransform)
*
*
* type = 0: normale anzeige, keine zeitinfos
* type = 1: blinked, mit zeitanzeige und dauer
**************************/
function create_fleet_route($fid,$map_info, $type = 0, $globalTransform = 0)
{
 global $uid;

 $its_uid = $map_info->get_uid_by_fid($fid);

  if ($uid == $its_uid)
    $class = "fleetsRoutes";
  elseif ($map_info->is_allied($its_uid))
    $class = "alliedRoute";
    
 if ($class)
 {
   $sth = mysql_query("select route from routes where fid='".$fid."'");

   if (!$sth)
    return 0;

   if (mysql_num_rows($sth))
   {
    list($its_route) = mysql_fetch_row($sth);
    $its_route = unserialize($its_route);

    // start coordinaten
    $star_info  = $map_info->get_star_info($map_info->get_sid_by_fid($fid));

    if ($star_info)
      $polyline = $star_info["x"].",".$star_info["y"];

    for ($j = 0; $j < sizeof($its_route); $j++)
    {
      $star_info = $map_info->get_star_info($its_route[$j]);

      if ($star_info) {
        if ($polyline)
          $polyline .= " ";
        $polyline .= $star_info["x"].",".$star_info["y"];
      }
    }

    if ($globalTransform)
      $route = "<g id=\"route".$fid."\" transform=\"translate(".$globalTransform.")\">";
    else
      $route = "<g id=\"route".$fid."\">";

    $route .= "<polyline class=\"".$class."\" points=\"".$polyline."\"/></g>";

    return $route;
   }
  }
  
  return null;
}
?>
