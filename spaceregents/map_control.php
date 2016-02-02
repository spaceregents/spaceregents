<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/special_actions.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/ressources.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/admirals.inc.php";
include "../spaceregentsinc/missiontypes.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/systems.inc.php";

define (DEFENSE_MASQ_VALUE, 3);
define (JAMMING_TONNAGE_PER_UNIT, 3000);

function get_number_sensor_jammers_at_fleet($fleet)
{
  // hard coded, jedes schiff deckt 3000 tonnage ab
  // schiffe
  $sth = mysql_query("SELECT sum(count) FROM fleet f JOIN shipvalues s USING(prod_id) WHERE f.fid = ".$fleet->fid." AND s.special='N'");
  
  if (!$sth)
  {
    echo("ERROR::GET COUNT HIDE SHIPS");
    return false;
  }
  
  list($count) = mysql_fetch_row($sth);

  if ($fleet->pid > 0)
  {
    $allies = get_allied_ids($fleet->uid);
    
    if (is_array($allies))
      array_push($allies,$fleet->uid);
    else
      $allies[] = $fleet->uid;

    // gebäude
    $sth = mysql_query("SELECT count(c.prod_id), s.special FROM constructions c JOIN shipvalues s using(prod_id), planets p WHERE c.pid = p.id AND p.id = ".$fleet->pid." AND p.uid IN (".(implode(",",$allies)).") GROUP BY s.special HAVING s.special = 'N'");
    
    $constructions = mysql_fetch_row($sth);

    $count += DEFENSE_MASQ_VALUE * $constructions[0];
  }
  
  return $count;
}

function execute_tachyonscan()
{
  global $uid;
  global $oid;

  $actions_price    = get_special_action_price(TACHYON_SCAN);
  $user_resources   = get_users_resources($uid);
  $can_pay          = true;

  if ($actions_price["metal"] != 0)
    (($user_resources["metal"] - $actions_price["metal"]) < 0) ? $can_pay = false : $price_string .= "- Metal: ".$actions_price["metal"];

  if ($actions_price["energy"] != 0)
    (($user_resources["energy"] - $actions_price["energy"]) < 0) ? $can_pay = false : $price_string .= "- Energy: ".$actions_price["energy"];

  if ($actions_price["mopgas"] != 0)
    (($user_resources["mopgas"] - $actions_price["mopgas"]) < 0) ? $can_pay = false : $price_string .= "- Mopgas: ".$actions_price["mopgas"];

  if ($actions_price["erkunum"] != 0)
    (($user_resources["erkunum"] - $actions_price["erkunum"]) < 0) ? $can_pay = false : $price_string .= "- Erkunum: ".$actions_price["erkunum"];

  if ($actions_price["gortium"] != 0)
    (($user_resources["gortium"] - $actions_price["gortium"]) < 0) ? $can_pay = false : $price_string .= "- Gortium: ".$actions_price["gortium"];

  if ($actions_price["susebloom"] != 0)
    (($user_resources["susebloom"] - $actions_price["susebloom"]) < 0) ? $can_pay = false : $price_string .= "- Susebloom: ".$actions_price["susebloom"];


  if ($can_pay)
  {
    $fleet = new fleet($oid);
    
    $sensor_jammers = get_number_sensor_jammers_at_fleet($fleet);
    $tonnage        = $fleet->get_total_tonnage();
    
    $jam_probability = round((($sensor_jammers * JAMMING_TONNAGE_PER_UNIT) / $tonnage) * 100);
    
    if ($jam_probability > 90)
      $jam_probability = 90;

    $request_content .= svg_text_paragraph("----------------------------------------------\n");
    $request_content .= svg_text_paragraph("SCAN REPORT\n");

    if ($price_string)
      $request_content .= svg_text_paragraph("You have payed ".$price_string.".\n");

    $request_content .= svg_text_paragraph("----------------------------------------------\n");


    mt_srand ((double) microtime() * 1000000);
    
    $random = mt_rand(1,100);

    // erfolgreicher scan
    if ($random >= $jam_probability)
    {
      // fleets Admiral
      $itsAdmiral = $fleet->get_admiral();

      if ($itsAdmiral)
        $request_content .= svg_text_paragraph("Admiral: ".(get_admiral_name($itsAdmiral)));
      else
        $request_content .= svg_text_paragraph("Admiral: none");

      foreach($fleet->ships as $prod_id => $count)
      {
        $its_name = get_name_by_prod_id($prod_id);
        $request_content .= svg_text_paragraph($count[0]." ".strtoupper($its_name)." must refuel ".$count[1]." turns.\n");
      }
    }
    else
    {
      // misglückter scan
        $request_content .= svg_text_paragraph("We were not able to scan the fleet.");
    }

    // resourcen abziehen

    foreach ($actions_price as $res => $value)
    {
      if ($value!=NULL)
        subtract_users_resources($uid, $res, $value);
    }
  }
  else
    $request_content = svg_text_paragraph("Not enough resources to execute action");

  $sr_request = "<SR_REQEST>";
  $sr_request .= $request_content;
  $sr_request .= "</SR_REQEST>";

  echo($sr_request);
}

function execute_examinefleet()
{
  global $uid;
  $its_fleet    = new fleet($_GET["fid"]);
  $can_see      = false;
  
  if ($its_fleet->uid == $uid)
  {
    show_svg_message("There should be no button that would allow you doing this. :S");
    return false;
  }

  $allies = get_allied_ids($uid);
  
  if (is_array($allies))
    array_push($allies, $uid);
  else
    $allies[] = $uid;
  
  $allied_fleet = in_array($its_fleet->uid, $allies);
  
  // check ob eigene oder alleierte planeten im system sind
  $sth = mysql_query("select 1 from planets where sid=".$its_fleet->sid." and uid in (".(implode(",",$allies)).") LIMIT 1");
  
  if (!$sth)
  {
    show_svg_message("There was an Database error #mcontrol:exec_exam_fleet:1");
    return false;
  }
  
  if (mysql_num_rows($sth) > 0)
    $can_see = true;
    
  // check ob eigene oder alleierte flotten im system sind
  if (!$can_see)
  {
    $sth = mysql_query("select 1 from fleet_info where sid=".$its_fleet->sid." and uid in (".(implode(",",$allies)).") LIMIT 1");

    if (!$sth)
    {
      show_svg_message("There was an Database error #mcontrol:exec_exam_fleet:2");
      return false;
    }

    if (mysql_num_rows($sth) > 0)
      $can_see = true;
  }
  
  if (can_see)
  {
    $doc      = domxml_new_doc("1.0");
    $rootElem = $doc->create_element("SR_REQUEST");
    $rootElem->set_attribute("type","examine_fleet");
    $rootElem->set_attribute("fid",$its_fleet->fid);
    $rootElem->set_attribute("owner",$its_fleet->uid);    
    $missionElem = $doc->create_element("SR_FLEET_MISSION");
    $no_scan = false;
    
    // mission
    if ($allied_fleet)
    {
      // alleierte Flotte, wir sehen die mission
      // mission kann sich unterscheiden wenn das ziel feindlich ist.
      $no_target       = false;
      $target_relation = false;
      if ($its_fleet->tsid > 0 && $its_fleet->tpid > 0)
        $sth = mysql_query("SELECT s.name as s_name, p.name, p.uid, p.type, p.id FROM systems s LEFT JOIN planets p on s.id = p.sid WHERE s.id = ".$its_fleet->tsid." and p.id=".$its_fleet->tpid);
      elseif ($its_fleet->tsid > 0)
        $sth = mysql_query("SELECT name as s_name from systems where id = ".$its_fleet->tsid);
      else
        $no_target = true;
      
      if (!$no_target)
      {
        if (!$sth || mysql_num_rows($sth) == 0)
        {
          show_svg_message("ERR::Can not get Target");
          return false;
        }
        
        $target_info = mysql_fetch_assoc($sth);
        
        if ($target_info["s_name"])
          $missionElem->set_attribute("tsys_name", htmlspecialchars($target_info["s_name"]));

        if ($target_info["name"])
        {
          if ($target_info["name"] == "Unnamed")
            $target_info["name"] = get_planetname($target_info["id"]);
            
          $missionElem->set_attribute("tpla_name", htmlspecialchars($target_info["name"]));
          $missionElem->set_attribute("tpla_type", $target_info["type"]);            
          
          if ($target_info["uid"] > 0)
            $target_relation = get_uids_relation($its_fleet->uid, $target_info["uid"]);
        }
        
        $eta = get_true_ETA_by_fid($its_fleet->fid);
        $rootElem->set_attribute("eta",$eta);
      }            


      switch ($its_fleet->mission)
      {
        case M_MOVE:
          if ($target_relation == "enemy")
          {
            $missionElem->set_attribute("mission", "fleet_mission_attack.svgz");
            $missionElem->set_attribute("missionText", "Attacking");
          }
          elseif ($target_relation == "allie" || $target_relation == "same" || $its_fleet->tsid == 0)
          {
            $missionElem->set_attribute("mission", "fleet_mission_defend.svgz");
            $missionElem->set_attribute("missionText", "Defending");            
          }
          else
          {
            $missionElem->set_attribute("mission", "fleet_mission_move.svgz");
            $missionElem->set_attribute("missionText", "Moving");                        
          }
        break;
        case M_INVADE:
          $missionElem->set_attribute("mission", "fleet_mission_invade.svgz");
          $missionElem->set_attribute("missionText", "Invading");                                  
        break;
        case M_BOMB:
          $missionElem->set_attribute("mission", "fleet_mission_bomb.svgz");
          $missionElem->set_attribute("missionText", "Bombarding");                                  
        break;
        case M_COLONIZE:
          $missionElem->set_attribute("mission", "fleet_mission_colonize.svgz");
          $missionElem->set_attribute("missionText", "Colonizing");                                  
        break;
      }
    $missionElem->set_attribute("tactic", $its_fleet->tactic);
    }
    else
    {
      $missionElem->set_attribute("mission", "fleet_mission_unknown.svgz");
      $missionElem->set_attribute("missionText", "unknown mission");
      $missionElem->set_attribute("tactic", "-1");
      
      // gucken ob wir no-scan schiffe haben (special 'N' in shipvalues)
      $sth = mysql_query("SELECT s.prod_id FROM fleet f, shipvalues s WHERE s.special = 'N' AND s.prod_id = f.prod_id AND f.fid = ".$its_fleet->fid);
      
      if (!$sth)
      {
        show_svg_message("ERROR::Getting NOSCAN ships");
        return false;
      }
      
      if (mysql_num_rows($sth) > 0)      
        $no_scan = true;
      
      // gucken ob der planet vielleicht so nen gebäude hat??
      if (!$no_scan && $its_fleet->pid > 0)
      {
        // alleierte der flotte
        $fleet_allies = get_allied_ids($its_fleet->uid);
        
        if (is_array($fleet_allies))
          array_push($fleet_allies, $its_fleet->uid);
        else
          $fleet_allies[] = $its_fleet->uid;
          
        $sth = mysql_query("SELECT s.prod_id FROM planets p, constructions c join shipvalues s using(prod_id) where s.special='N' and c.pid = p.id and p.id = ".$its_fleet->pid." and p.uid in (".(implode(",",$fleet_allies)).")");

        if (!$sth)
        {
          show_svg_message("ERROR::Getting NOSCAN buildings");
          return false;
        }

        if (mysql_num_rows($sth) > 0)      
          $no_scan = true;
      }
    }      
    $rootElem->append_child($missionElem);
    
    // ships
    if (!$no_scan)
    foreach($its_fleet->ships as $prod_id => $values)
    {
      $shipElem = $doc->create_element("SR_SHIP");
      $shipElem->set_attribute("prod_id", $prod_id);
      $shipElem->set_attribute("count", $values[0]);
      
      if ($allied_fleet)
        $shipElem->set_attribute("reload", $values[1]);
      else
        $shipElem->set_attribute("reload", -1);
              
      $rootElem->append_child($shipElem);
    }
    
    // admiral
    $sth = mysql_query("SELECT a.pic, a.name, a.id, a.fid from admirals a join fleet_info f using(fid) having a.fid=".$its_fleet->fid."");
    
    if (!$sth)
    {
      show_svg_message("There was an Database error #mcontrol:exec_exam_fleet:3");
      return false;
    }
    
    if (mysql_num_rows($sth) > 0)
    {
      list($a_pic, $a_name, $a_id) = mysql_fetch_row($sth);
      $admiralElem = $doc->create_element("SR_ADMIRAL");
      $admiralElem->set_attribute("name", $a_name);
      $admiralElem->set_attribute("pic", $a_pic);
      $admiralElem->set_attribute("level", get_admiral_level($a_id));
      $rootElem->append_child($admiralElem);
      $rootElem->set_attribute("pic", "ADMIRAL");
    }
    else {
      if (!$no_scan)
        $rootElem->set_attribute("pic", get_strongest_ship_by_fid($its_fleet->fid));
      else
        $rootElem->set_attribute("pic", 0);
    } 
    
    $doc->append_child($rootElem);
    echo($doc->dump_mem());    
  }
  else
    show_svg_message("Either this is a bug or you're a  h4xx0r. :S");
}

switch ($act)
{
  case "tachyonscan":
    execute_tachyonscan();
  break;
  case "examine_fleet":
    execute_examinefleet();
  break;
}
$content=ob_get_contents();
ob_end_clean();

//print gzcompress($content);
print $content;
?>
