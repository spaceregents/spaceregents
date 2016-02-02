<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/alliances.inc.php";
include "../spaceregentsinc/research.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/ressources.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/missiontypes.inc.php";

function change_tactic($tactic)
{
  global $uid;

  $sth=mysql_query("update fleet_info set tactic='".$tactic."' where uid=$uid and fid=".$_GET["fid"]);

  if ($sth)
    return true;
  else
    return false;
}

/*************************
*
* function move_fleet()
*
*
* tag SR_REQUEST: attribs: oid(fid), type(FLEET_ROUTE)
* tag SR_ROUTE_INFO: attribs: eta, targetName, mission, missionName, missionSymbol, sid (weil das javascript die nicht noch, schon kennt), x, y, (weil js das auch nicht immer kennt)
* tag SR_ROUTE_SYSTEM_TO_PLANET: attribs: jumpNumber, pid
* tag SR_ROUTE_PLANET_TO_PLANET: attribs: pid1, pid2, sid
* tag SR_ROUTE_SYSTEM          : attribs: jumpNo, sid
*
**************************/
function move_fleet($mission)
{
  global $uid;
  $fid        = $_GET["fid"];
  $targetId   = $_GET["targetId"];
  $targetType = $_GET["targetType"];       // planet || system

  $fleet = new fleet($fid);

  // validation
  if ($uid != $fleet->uid)
  {
    if ($fleet->milminister == 1) {
      $sth = mysql_query("select a.milminister from users u left join alliance a on u.alliance = a.id where u.id = ".$uid);

      if (!$sth) {
        show_svg_message("ERR::GET MoD");
        return false;
      }

      list($its_mod) = mysql_fetch_row($sth);

      if ($its_mod != $uid ) {
        show_svg_message("You can not command that fleet");
        return false;
      }
    }
    else {
      show_svg_message("You can not command that fleet");
      return false;
    }
  }


  if ($targetType == "system")
  {
    $destination_system   = $targetId;
    $destination_planet   = 0;
    $destination_name     = get_systemname($targetId);
  }
  else
  {
    $sth = mysql_query("select sid, name, uid from planets where id = '$targetId'");

    if ((!$sth) || (!mysql_num_rows($sth)))
      return 0;

    $dest_data = mysql_fetch_row($sth);
    $destination_system = $dest_data[0];

    $destination_name   = $dest_data[1];
    $destination_planet = $targetId;
    $destination_planet_uid = $dest_data[2];
  }

  $max_warp = get_max_warp($uid);
  $route    = move_to($fleet->sid,$destination_system,$max_warp);

  if (is_array($route))
  {    
    $fleet_mode = "defensive";
    
    // gucken ob der zielplanet ein feindlicher ist
    if ($destination_planet != 0 && $destination_planet_uid != 0)
    {
      if (get_uids_relation($uid, $destination_planet_uid) == "enemy")
        $fleet_mode = "aggressive";
    }
    
    set_mission($fid, $mission, $destination_system, $destination_planet);    
    $its_mission = get_mission_by_mission_id($mission, $fleet_mode);    
    set_route($route, $fid);
    $true_eta = get_true_ETA_by_fid($fid);

    $request .= "<SR_REQUEST oid=\"".$fid."\" type=\"FLEET_ROUTE\">";
    $request .= "<SR_ROUTE_INFO eta=\"".$true_eta."\" targetName=\"".$destination_name."\" sid=\"".$fleet->sid."\" mission=\"".$mission."\" missionName=\"".$its_mission[0]."\" missionSymbol=\"".$its_mission[2]."\" />";    // general info

    if ($fleet->sid == $destination_system)
    {
      if ($destination_planet == 0 || $fleet->pid == 0)
      {
        if ($destination_planet == 0)
        {
          $target_planet = $fleet->pid;
          $target_system = $destination_system;
        }
        else
        {
          $target_planet = $destination_planet;
          $target_system = $fleet->sid;
        }

        $request .= "<SR_ROUTE_SYSTEM_TO_PLANET jumpNumber=\"0\" pid=\"".$target_planet."\" sid=\"".$target_system."\"/>";
      }
      else
        $request .= "<SR_ROUTE_PLANET_TO_PLANET jumpNumber=\"0\" pid1=\"".$fleet->pid."\" pid2=\"".$destination_planet."\" sid=\"".$fleet->sid."\"/>";

    }
    else
    {
      // wenn die flotte nicht schon überm stern hängt, muss sie erst dahin fliegen um das system zu verlassen
      $a = 0;
      if ($fleet->pid != 0)
        $request .= "<SR_ROUTE_SYSTEM_TO_PLANET jumpNumber=\"".($a++)."\" pid=\"".$fleet->pid."\" sid=\"".$fleet->sid."\"/>";

      for ($i = 0; $i < sizeof($route); $i++) {
        $request   .= "<SR_ROUTE_SYSTEM jumpNumber=\"".($i + $a)."\" sid=\"".$route[$i]."\"/>";
      }

      // wenn die flotte nicht zum einem anderen stern fliegt, sondern zu einem planeten, kommt noch ein inter-planetärer flug hinzu
      if ($destination_planet != 0)
        $request .= "<SR_ROUTE_SYSTEM_TO_PLANET jumpNumber=\"".(++$i)."\" pid=\"".$destination_planet."\" sid=\"".$destination_system."\"/>";
    }

    $request .= "</SR_REQUEST>";

    echo($request);
    return true;
  }
  else {
    show_svg_message("Sir! Our fleet '".(get_fleet_name($_GET["fid"]))."' can't carry out your command. The targets destination has an insuperable gap that exceeds our warp technolgy of ".$max_warp." parsec.");
    return false;
  }
}

function colonize()
{
  global $uid;
  // route setzen
  if ($_GET["targetType"] =="planet")
  {
    $homeplanet   = is_planet_in_homesystem($_GET["targetId"]);
    $can_colonize = can_colonize($_GET["fid"]);
    if (!$homeplanet)
    {
      if ($can_colonize)
        move_fleet(M_COLONIZE);
      else
        move_fleet(M_MOVE);
    }
    else
    {
      // check ob es nicht das eigene heimatsystem ist
      $sth = mysql_query("select 1 from users where homeworld=".$homeplanet." and id=".$uid);
      
      if (!$sth)
      {
        show_svg_message("ERROR::COLONIZE"); 
        return false;
      }
      
      if (mysql_num_rows($sth) > 0)
      {
        if ($can_colonize)
          move_fleet(M_COLONIZE);
        else
          move_fleet(M_MOVE);
      }
      else
        show_svg_message("Sorry, this planet is located in a homesystem and thus is not colonizable"); 
    }
  }
  else
    show_svg_message("Who want's to live on a star anyway?!");
}


function bomb()
{
  if ($_GET["targetType"] == "planet")
  {
    if (!is_planet_in_homesystem($_GET["targetId"]))
    {
      // check ob die Flotte bomber hat
      $sth = mysql_query("select distinct 1 from fleet f, shipvalues s where s.special = 'B' and f.prod_id = s.prod_id and f.fid='".$_GET["fid"]."'");

      if (!$sth)
      {
        show_svg_message("Database Error!");
        return false;
      }

      if (mysql_num_rows($sth) > 0)
      {
        // route setzen
        if ($_GET["targetType"] =="planet")
          move_fleet(M_BOMB);
      }
      else
      {
        // hat keine Bomber, also machen wir nen normalen attack
        move_fleet(M_MOVE);
      }
    }
    else
      show_svg_message("Sorry. A bombing run against a planet located in a homesystem conflicts with the agenda of species preservation.");
  }
  else
    show_svg_message("I'm a Wiener!");
}


function invade()
{
  global $uid;

  if ($_GET["targetType"] == "planet")
  {
    if (!is_planet_in_homesystem($_GET["targetId"]))
    {
      // check ob die Flotte überhaupt transporter hat
      if (is_array(get_transporters($_GET["fid"])))
        move_fleet(M_INVADE);
      else
        move_fleet(M_MOVE);
     }
     else
      show_svg_message("Sorry. An invasion against a planet located in a homesystem conflicts with the agenda of species preservation.");
  }
  else
    show_svg_message("One more try and I put YOU on top of a sun!");
}


function attack()
{
  global $uid;
  global $target1;
  global $target2;
  global $type;
  global $innerHeight;
  global $innerWidth;

  // route setzen
  if ($type=="planet")
  {
    move_fleet(M_MOVE);
  }
}


function jump($fid,$sid)
{
  global $uid;

  $pid  = get_pid_of_jumpgate($sid);

  if (!$pid)
  {
    echo("no");
    return 0;
  }

  $start_sid=get_sid_by_fid($fid);

  $start_pid=get_pid_of_jumpgate($start_sid);

  if (!$start_pid)
  {
    echo("no");
    return 0;
  }

  $sth=mysql_query("select jv.tonnage,j.used_tonnage from jumpgates as j,jumpgatevalues as jv where j.sid=$sid and j.pid=$pid and jv.prod_id=j.prod_id");

  if (!$sth || mysql_num_rows($sth)==0)
  {
    echo("bug");
    return 0;
  }

  $targetj=mysql_fetch_array($sth);

  $sth=mysql_query("select f.fid from fleet_info as f,jumpgates as j where f.sid=j.sid and j.sid!=$sid and j.sid=$start_sid and f.fid=$fid");

  if (!$sth)
  {
    echo("bug");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    echo("same");
    return 0;
  }

  $sth=mysql_query("select fi.name as fname ,fi.sid,p.name,p.typ,fi.fid,s.tonnage,f.count from fleet_info as fi,production as p,shipvalues as s left join fleet as f on fi.fid=f.fid where p.prod_id=f.prod_id and f.fid=".$fid." and s.prod_id=f.prod_id and s.prod_id=p.prod_id and f.fid is not null");

  if (!$sth)
  {
    echo("bug");
    return 0;
  }

  while ($fleet=mysql_fetch_array($sth))
  {
    if (!$max_tonnage)
    {
      if (!$sid_fleet)
  $sid_fleet=$fleet["sid"];

      $sth1=mysql_query("select jv.tonnage,j.used_tonnage from jumpgates as j,jumpgatevalues as jv where j.sid=".$fleet["sid"]." and jv.prod_id=j.prod_id");

      if (!$sth1)
      {
  echo("bug");
  return 0;
      }

      $home=mysql_fetch_array($sth1);

      $home_avail=$home["tonnage"]-$home["used_tonnage"];
      $target_avail=$targetj["tonnage"]-$targetj["used_tonnage"];

      if ($home_avail<$target_avail)
        $max_tonnage=$home_avail;
      else
        $max_tonnage=$target_avail;
    }

    $fleet_tonnage=$fleet_tonnage+($fleet["tonnage"]*$fleet["count"]);
  }

  if ($fleet_tonnage>$max_tonnage)
  {
    echo("max_tonnage");
    return 0;
  }

  $sth=mysql_query("select j.password,p.uid from jumpgates as j,planets as p,orbital as o where p.sid=j.sid and j.sid=$sid and o.pid=p.id and o.prod_id=j.prod_id and j.pid=p.id");

  if (!$sth)
  {
    echo("bug");
    return 0;
  }

  $target_pass=mysql_fetch_array($sth);

  $sth=mysql_query("select j.password,p.uid from jumpgates as j,planets as p,orbital as o where p.sid=j.sid and j.sid=".$sid_fleet." and o.pid=p.id and o.prod_id=j.prod_id and j.pid=p.id");

  if (!$sth)
  {
    echo("bug");
    return 0;
  }

  $start_pass=mysql_fetch_array($sth);

  if ($start_pass["uid"]!=$uid || $target_pass["uid"]!=$uid)
  {
    echo("not_yours");
    return 0;
  }
  else
  {
    $sth=mysql_query("update fleet_info set sid=$sid,pid=0,tsid=0,tpid=0,mission=0 where fid=$fid");

    if (!$sth)
    {
      echo("bug");
      return 0;
    }

    $sth=mysql_query("update jumpgates set used_tonnage=used_tonnage+$fleet_tonnage where (sid=$sid) or (sid=$start_sid)");

    echo("success");
  }
}


function switch_mod($fid) {
  global $uid;
  $sth = mysql_query("select milminister from fleet_info where uid=".$uid." and fid='".$fid."'");
  
  if (!$sth){
    show_svg_message("ERR::SWITCH MINISTER OF DEFENSE");
    return false;
  }
  
  if(mysql_num_rows($sth)==0) {
    show_svg_message("You are not allowed for such an operation.");
    return false;
  }
  
  list($current_mod) = mysql_fetch_row($sth);

  if ($current_mod != "0"){
    $new_mod  = 0;
  }
  else {
    $new_mod = 1;
  }
  
  $sth = mysql_query("update fleet_info set milminister=".$new_mod." where fid='".$fid."'");
  
  if (!$sth)
      show_svg_message("ERR:: SETTING NEW MINISTER OF DEFENCE");
  else
    echo("<SR_REQUEST type=\"MOD\" mod=\"".$new_mod."\"/>");
}

switch ($_GET["act"])
{
  case "move":
    move_fleet(0);
  break;
  case "colonize":
    colonize();
  break;
  case "jumpgate":
    jump($target1,$target2);
  break;
  case "attack":
    attack();
  break;
  case "bomb":
    bomb();
  break;
  case "trade":
    trade();
  break;
  case "invade":
    invade();
  break;
  case "change_tactic":
    change_tactic($_GET["tactic"]);
  break;
  case "switch_mod":
    switch_mod($_GET["fid"]);
  break;
}
$content=ob_get_contents();
ob_end_clean();

if ($_GET["debug"] == 1)
  print $content;
else
  print gzcompress($content);
?>
