<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/alliances.inc.php";


function check()
{
  global $uid;
  global $fleet;
  global $capacity;

  $fid = $_GET["fid"];
  $pid = $_GET["pid"];

  // 1. check ob die flotte eigene bzw. einem zugeordnete flotte ist
  if (!($fleet->uid == $uid || ($fleet->milminister == 1 && $uid == get_milminister(get_alliance($uid)))))
  {
    show_svg_message("Darn, thats not your fleet!");
    return false;
  }

  // 2.check ob die flotte transporter hat
  if (!$capacity)
  {
    show_svg_message("Doh! This fleet can't hold any groundforces");
    return false;
  }
  
  // 3. check ob flotte im orbit des planeten ist
  if ($fleet->pid != $pid)
  {
    show_svg_message("There's no beaming! :P");
    return false;
  }
  
  // 4. check ob user infantry auf dem planeten hat
  $sth = mysql_query("SELECT 1 FROM infantery i,production p WHERE i.pid=".$fleet->pid." and i.prod_id=p.prod_id and p.name!='Militia' and i.uid=".$uid);
  
  if (!$sth || mysql_num_rows($sth)==0)
  {
    // 4.5 check ob der Planet zu der flotte gehört
    if (!is_allied($fleet->uid, get_uid_by_pid($pid)))
    {
      show_svg_message("Kidnapping forces ain't looking like a good idea to me!");
      return false;
    }
  }
  
  return true;
}

function get_transfer_values()
{
  global $uid;
  global $fleet;
  global $capacity;

  if (!check())
    return false;

  $fid = $_GET["fid"];
  $pid = $_GET["pid"];

  // der olle fleet tag :D
  $inf_on_fleet = $fleet->get_infantry();

  $fleet_inf_tag = "<SR_FLEET fid=\"".$fid."\" cap=\"".$capacity."\">";
  if (is_array($inf_on_fleet))
  foreach ($inf_on_fleet as $inf)
  {
    $fleet_inf_tag .= create_infantry_tag($inf[0], $inf[1], $inf[2]);
  }
  $fleet_inf_tag .= "</SR_FLEET>";


  // der olle planet tag :D
  $inf_on_planet= get_infantry_and_data_by_pid_uid($pid, $uid);

  $planet_inf_tag = "<SR_PLANET pid=\"".$pid."\">";
  if (is_array($inf_on_planet))
  foreach ($inf_on_planet as $inf)
  {
    $planet_inf_tag .= create_infantry_tag($inf["prod_id"], $inf["count"], $inf["storage"]);
  }
  $planet_inf_tag .= "</SR_PLANET>";


  echo("<SR_REQUEST type=\"inf_transfer_values\">");
  echo($fleet_inf_tag);
  echo($planet_inf_tag);
  echo("</SR_REQUEST>");
}


function transfer()
{
  global $uid;
  global $fleet;
  global $capacity;

  $transfer = $_GET["tr"];

  $fid = $_GET["fid"];
  $pid = $_GET["pid"];

  if (!check())
    return false;

  // check ob nicht mehr transferiert wird als vorhanden
  $inf_on_fleet = $fleet->get_infantry();
  $inf_on_planet= get_infantry_and_data_by_pid_uid($pid, $uid);

  $new_fleet_inf  = Array();
  $new_planet_inf = Array();
  $storage_info   = Array();
  $needep_cap = 0;

  $i = 0;
  if(is_array($inf_on_planet))
  foreach($inf_on_planet as $inf)
  {
    $new_planet_inf[$inf["prod_id"]] = $inf["count"];
    $storage_info[$inf["prod_id"]]   = $inf["storage"];
  }

  if(is_array($inf_on_fleet))
  foreach($inf_on_fleet as $inf)
  {
    $new_fleet_inf[$inf[0]] = $inf[1];
    $storage_info[$inf[0]]  = $inf[2];
  }

  foreach($transfer as $prod_id => $count)
  {
    if (($new_fleet_inf[$prod_id] + $count < 0) || ($new_planet_inf[$prod_id] - $count < 0) || (!$storage_info[$prod_id]))
    {
      show_svg_message("LOL >:)");
      return false;
    }

    $new_fleet_inf[$prod_id] += $count;
    $new_planet_inf[$prod_id] -= $count;
    $needed_cap += $storage_info[$prod_id] * $new_fleet_inf[$prod_id];
  }

  if ($needed_cap > $capacity)
  {
    show_svg_message("haxx0r? Wanna squeeze em?");
    return false;
  }

  // okay, scheint ja alles mit richtigen dingen zuzugehen
  foreach($transfer as $prod_id => $count)
  {
    if ($new_fleet_inf[$prod_id] == 0)
      $sth = mysql_query("delete from inf_transports where fid='".$fid."' and prod_id='".$prod_id."'");
    else
      $sth = mysql_query("replace into inf_transports values('".$fid."','".$prod_id."','".$new_fleet_inf[$prod_id]."')");

    if (!$sth) {
      show_svg_message("Database failure! #1");
      return false;
    }

    if ($new_planet_inf[$prod_id] == 0)
      $sth = mysql_query("delete from infantery where pid='".$pid."' and prod_id='".$prod_id."' and uid='".$uid."'");
    else
      $sth = mysql_query("replace into infantery values('".$prod_id."','".$new_planet_inf[$prod_id]."','".$pid."','".$uid."')");

    if (!$sth) {
      show_svg_message("Database failure! #2");
      return false;
    }
  }
  echo("<SR_REQUEST type=\"transfer_response\" v=\"1\"/>");
}


$fleet    = new fleet($_GET["fid"]);
$capacity = $fleet->get_total_transporter_capacity();

switch ($_GET["act"]) {
  case "transfer":
    get_transfer_values();
  break;
  case "submit":
    transfer();
  break;
}

$content=ob_get_contents();
ob_end_clean();

#if ($_GET["debug"]==1)
	print $content;
#else
#	print gzcompress($content);
?>
