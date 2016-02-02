<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/admirals.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/tactics.inc.php";
include "../spaceregentsinc/class_map_info.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/population.inc.php";

/*********************** INFO *****************************
 map_getData.php
 needs paras: act
 wenn act = clickOnPlanet dann pid = planet id

 map_getData kann vier arten von tags zurück
 1. <SR_REQUEST> tag, enthält als child alle anderen tags, dient als ROOT
 2. Ein (nur ein!) <SR_HEAD>-tag
 3. Als Childs vom <SR_HEAD>-tag können optional max. 4 <SR_BUTTON> tags stehen
 4. 0..n <SR_ITEM>-tags

 Vor den tags muss IMMER eine line (durch \n abgeschlossen) geschrieben werden, welche das data handling in JS beschreibt (ich nenns es ma data handling hint)

 newItemBox | Wenn eine neue ItemBox genebriert werden soll
 newItems   | Wenn neue Items hinzugefügt werden sollen

 Der <HEAD> Tag:
 Er hat einige Attribute die gesetzt sein müssen!
 diese sind:
 - picture (Das bild, welches in der grösse 80x80 und kreisförmig angezeigt wird
 - topic   (Die Überschrift die den Header dominiert)

 optional sind:
 - text   (Text, der kleiner und unter das topic geschrieben wird. zB. wem das objekt gehört)
 - symbol (Ein symbol das unten link in der ecke des bildes dargestellt wird. Dort werden Alliance Symbole zu finden sein.)
 - kontur (Eine CSS id für CLASS)


 Die <SR_BUTTON> Tags:
 max 4 als childs des <SR_HEAD> tags
 Es muss folgende Attribute besitzen:
 - face   (ist eine ID eines SVG_DEFS_ELEMENTS, MUSS VOM TYP BUTTON SEIN)
 - action (JavaScript der beim anclicken ausgeführt werden soll)
 - shape  (das shape, wird vie USE aufgerufen)
 - active (0 = OFF (default), 1 = ON, zeigt an ob ein Button schon direkt ausgewählt ist, dadurch werden die entsprechenden Item direkt geladen)
 - tooltip (text, der beim drüberfahren erscheint) (default: " ")

 Die <ITEM> Tags:
 Ein Item tag muss diese Attribute haben:
 - picture    STRING
 - topic      STRING  meistens der name des objektes
 - text1      STRING  meistens der besitzer
 - text2      STRING  meistens das empire
 - footer
 - oid        INT     die id in der datenbank
 - type       STRING  fleet, infantry etc. benötigt um items in der map zu sortieren und um später den key in der db herauszufinden
- itemType (derzeit: BASIC_ITEM, FLEET_ITEM, ADVANCED_FLEET_ITEM, FULL_FLEET_ITEM)

 // ist das item vom typ fleet kann es eine vielzahl von weiteren attributen besitzen:
 - relationClass STRING  [colorOwn, colorAllied, colorFriend, colorEnemy, colorNeutral]      // css class
 - allianceColor
 - allianceName
 - allianceSymbol

 - f_reload           INT                                               // nur bei eigenen
 - f_on_way_to        STRING                                            // nur bei eigenen und alleierten
 - f_has_colonists    BOOL                                              // nur bei eigenen
 - f_has_infantry     BOOL                                              // nur bei eigenen
 - f_mod_order        BOOL  (Minister of Defence may give orders)       // nur bei eigenen und alleierten
 - f_tactic           // noch nicht definiert

 - f_order_colonize   BOOL
 - f_order_move       BOOL
 - f_order_tactic     BOOL
 - f_order_view       BOOL
 - f_order_control    BOOL        // Schiff, Infanterie transfer




 In JavaScript verarbeitet NUR das erzeugte Object aus sr_class_ITEMBOX.js diese Daten.
 Diese Daten werden nicht in dieser Form an den SVGDOM angehängt
 *********************************************************/



/****************************************************************************************************************************************************
 * getPlanetData()
 **********************/
function getPlanetData()
{
  global $uid;
  global $pid;            // übergeben in der URL
  global $map_info;

  // BUTTON Definitionen
  $buttonShape = "button_circle_30x30_shadow";

  $my_alliance = get_alliance($uid);

  $fog_of_war=$map_info->get_fog_of_war();

  // *** HEADER ****
  // Zuerst allgemeine Informationen über den Planeten
  //$sth = mysql_query("SELECT p.name, p.type as picture, p.sid, u.name as user_name, u.id as p_uid, p.metal, p.energy, p.mopgas, p.erkunum, p.gortium, p.susebloom, u.alliance FROM planets p LEFT OUTER JOIN users u ON p.uid = u.id WHERE p.id = $pid");
  $sth = mysql_query("SELECT p.name, p.type as picture, p.sid, b.name as user_name, b.id as p_uid, p.metal, p.energy, p.mopgas, p.erkunum, p.gortium, p.susebloom, b.a_name, b.symbol, b.color FROM planets p left join (SELECT u.id, u.name, a.name as a_name, a.color, a.symbol from users u left join alliance a on u.alliance = a.id) b on b.id = p.uid where p.id = '".$pid."'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  $planet_info = mysql_fetch_assoc($sth);

  // gucken ob der planet nicht einen falschen namen hat
  if ($planet_info["name"] == "" || $planet_info["name"] == "Unnamed")
    $planet_info["name"] = get_planetname($pid);
  else
    $planet_info["name"] = $planet_info["name"];


  // Besitzer des planeten
  if (!$planet_info["user_name"])
    $planet_info["user_name"] = 0;
  else
    $planet_info["user_name"] = "of ". $planet_info["user_name"];


  // Kontur und Alliancen Symbol
  if (!$planet_info["a_name"])
  {
    $planet_info["a_name"] = 0;
    $planet_info["symbol"] = 0;
    $planet_info["color"] = 0;

    if ($planet_info["p_uid"])
    {
      if ($uid == $planet_info["p_uid"])
        $kontur = "colorOwn";
      else
        $kontur = "colorNeutral";
    }

  }
  else
    $kontur = get_uids_relation($uid, $planet_info["p_uid"], 1);


  // Buttons
  $planet_fleets = false;   // Flotten button
  $planet_troops = false;    // Infatry button
  $planet_planet = false;   // planet button

  // Wenn es ein eigener oder alleierter Planet ist, ebenfalls die Buttons: fleets, buildings, infantry darstellen
  // den fleet button auch darstellen , wenn eine eigene (alleierte Flotte) in dem System ist

  if ($uids_relation == "same" || $uids_relation == "allied") {
    // Ok, der Planet gehört mir oder nem Alleierten, also kann ich die Flotten und Truppen sehen
    $planet_fleets = true;
    $planet_troops = true;
    $planet_planet = true;
  }
  else
  {
    $scanned_sids=$map_info->get_scanned_systems();

    if (in_array($planet_info["sid"],$scanned_sids))
    {
      $planet_fleets=true;
      $planet_planet=true;
    }
  }

  // Check ob flotten vorort
  // Wenn keine Flotten da sind muss ich auch keinen Button anzeigen
  if ($planet_fleets)
  {
    $sth = mysql_query("SELECT 1 FROM fleet_info WHERE pid = $pid LIMIT 1");

    if (!$sth)
      return false;

    if (!mysql_num_rows($sth))
      $planet_fleets = false;
  }

  // Check ob Infantry vor Ort
  // Wenn keine Truppen da sind muss ich auch keinen Button anzeigen
  if ($planet_troops)
  {
    $sth = mysql_query("SELECT 1 FROM infantery WHERE pid = $pid LIMIT 1");

    if (!$sth)
      return false;

    if (!mysql_num_rows($sth))
      $planet_troops = false;
  }

  // Ok, Buttons kreieren und in $new_button[] speichern
  if ($planet_planet)
    $new_button[] = create_button($buttonShape, "button_face_info", "showPlanetInfo(evt, ".$pid.",'".addslashes($planet_info["name"])."')", 0, "show planet details");

  if ($planet_fleets)
    $new_button[] = create_button($buttonShape, "button_face_ship", "showItemBoxItems('fleet')", 0,  "show fleets");

  if ($planet_troops)
    $new_button[] = create_button($buttonShape, "button_face_infantry", "showItemBoxItems('infantry')", 0 ,"show groundforces");


  $new_header = create_header(PIC_ROOT . $planet_info["picture"] . ".png", $planet_info["name"], $planet_info["user_name"], $kontur, $planet_info["symbol"], $planet_info["a_name"], $planet_info["color"], $planet_info["metal"], $planet_info["energy"], $planet_info["mopgas"], $planet_info["erkunum"], $planet_info["gortium"], $planet_info["susebloom"]);

    // Button in das Header Tag einfügen
    for ($i = 0; $i < sizeof($new_button); $i++)
    {
      $new_header .= $new_button[$i];
    }

  $new_header .= "</SR_HEAD>";

  echo("newItemBox\n");   // nötig um zu ermitteln wie der inhalt behnadelt werden soll!
  echo($new_header);
}


/***********************
 * function create_header($picture, $topic, $text = 0, $kontur = 0, $symbol = 0)
 **********************/
function create_header($picture, $topic, $text = 0, $kontur = 0, $a_symbol = 0, $a_name = 0, $a_color = 0, $me = 0, $en = 0, $mo = 0, $er = 0, $go = 0, $su = 0)
{
  $new_header = "<SR_HEAD picture=\"".$picture."\" topic=\"".htmlspecialchars($topic)."\"";

  if ($text)
    $new_header .= " text=\"".htmlspecialchars($text)."\"";

  if ($kontur)
    $new_header .= " kontur=\"".$kontur."\"";

  if ($a_symbol) $new_header .= " a_symbol=\"".$a_symbol."\"";
  if ($a_name)  $new_header .= " a_name=\"".htmlspecialchars($a_name)."\"";
  if ($a_color) $new_header .= " a_color=\"".$a_color."\"";    
  if ($me) $new_header .= " me=\"".$me."\"";
  if ($en) $new_header .= " en=\"".$en."\"";
  if ($mo) $new_header .= " mo=\"".$mo."\"";
  if ($er) $new_header .= " er=\"".$er."\"";
  if ($go) $new_header .= " go=\"".$go."\"";
  if ($su) $new_header .= " su=\"".$su."\"";


  $new_header .= ">";

  return $new_header;
}


/****************************************************************************************************************************************************
 * function create_button($b_shape, $b_face, $b_action, $b_active = 0)
 **********************/
function create_button($b_shape, $b_face, $b_action, $b_active = 0, $b_tooltip = " ")
{
  $new_button = "<SR_BUTTON shape=\"".$b_shape."\" face=\"".$b_face."\" action=\"".$b_action."\" active=\"".$b_active."\" tooltip=\"".$b_tooltip."\"/>";

  return $new_button;
}


/****************************************************************************************************************************************************
 * function get_items()
 **********************/
function get_items()
{
  global $caller_id;    // enthält die ID wonach die Items gewählt werden (pid, sid...)
  global $caller_type;  // enthält die art des 'callers' (planet, system..) (z.B. der planet dessen [item_type] agezeigt werden sollen)
  global $item_type;    // enthält die art der items (fleet, infantry..)

  switch ($caller_type)
  {
    case "planet":
      $sql_foreign_key = "pid";
    break;
    // mop: super hack :P
    case "star":
      $sql_foreign_key="pid=0 and sid";
    break;
  }

  switch ($item_type)
  {
    case "fleet":
      list($items_array,$ships) = get_fleet_items($caller_id, $sql_foreign_key);
    break;
  }

  for ($i = 0; $i < sizeof($items_array); $i++)
  {
    $write_childs = false;
    $items_output .= "<SR_ITEM ";
    
    foreach ($items_array[$i] as $attribute => $value)
    {
      if ($attribute != "fleet_control" && $attribute != "fleet_command")
        $items_output .= $attribute ."=\"".$value."\" ";
    }
    $items_output .= ">\n";

    $itemaddon="";

    if (is_array($ships[$i]))
    foreach ($ships[$i] as $prod_id => $data)
    {
      $itemaddon.="<SR_SHIP name=\"".$data[2]."\" typ=\"".$data[3]."\" count=\"".$data[0]."\" reload=\"".$data[1]."\" prod_id=\"".$prod_id."\"/>\n";
    }
    // Mop: hack continued...
    $items_output .= $items_array[$i]["fleet_control"];
    $items_output .= $items_array[$i]["fleet_command"];
    $items_output .= $itemaddon; // mop: ...
    $items_output .= "</SR_ITEM>\n";
  }

  echo("newItems\n"); // JS Data Handling hint
  echo("<SR_REQUEST>\n");
  echo($items_output);
  echo("</SR_REQUEST>");
}


/**********************
 * function get_fleet_items($id, $sql_foreign_key)
 **********************/
function get_fleet_items($id, $sql_foreign_key)
{
  global $uid;
  global $map_info;

  $sth = mysql_query("SELECT * FROM fleet_info WHERE ".$sql_foreign_key."=".$id." order by uid");

  if (!$sth || (!mysql_num_rows($sth)))
    return false;

  $i = 0;
  $ships=array();

  while ($fleets = mysql_fetch_assoc($sth))
  {
    $ships[$i]=array();
    $its_fleet = new fleet($fleets["fid"]);
    $its_fid = $fleets["fid"];

    // get fleets userdata

    // ALLIANZ
    $sth2 = mysql_query("select u.name, u.imperium, a.name as alliance_name, a.color, a.symbol, a.milminister from users u left outer join alliance a on a.id=u.alliance where u.id=".$fleets["uid"]);

    if ((!$sth2) || (!mysql_num_rows($sth2)))
      return 0;

    $fleets_user_info = mysql_fetch_array($sth2);

    if ($fleets_user_info["alliance_name"])
    {
      $return_array[$i]["allianceName"]   = htmlspecialchars($fleets_user_info["alliance_name"]);
      $return_array[$i]["allianceColor"]  = $fleets_user_info["color"];

      if ($fleets_user_info["symbol"])
        $return_array[$i]["allianceSymbol"] = $fleets_user_info["symbol"];
      else
        $return_array[$i]["allianceSymbol"] = 0;
    }
    else
    {
      $return_array[$i]["allianceName"]   = 0;
      $return_array[$i]["allianceColor"]  = 0;
      $return_array[$i]["allianceSymbol"] = 0;
    }


    // all items same data
    $return_array[$i]["picture"]        = get_fleet_pic($its_fid);

    $return_array[$i]["topic"]          = htmlspecialchars($fleets["name"]);
    $return_array[$i]["description"]    = htmlspecialchars($fleets["name"]);
    $return_array[$i]["oid"]            = $fleets["fid"];
    $return_array[$i]["sid"]            = $fleets["sid"];
    $return_array[$i]["pid"]            = $fleets["pid"];
    $return_array[$i]["tsid"]           = $fleets["tsid"];
    $return_array[$i]["tpid"]           = $fleets["tpid"];
    $return_array[$i]["relationClass"]  = get_uids_relation($uid, $fleets["uid"], 1);
    $return_array[$i]["footer"]         = false;
    
    $is_commanded_by_mod = $its_fleet->milminister == 1 && $fleets_user_info["milminister"] == $uid;

    if (($uid == $its_fleet->uid) || $is_commanded_by_mod)
    {
      $its_mission = get_mission_by_mission_id($fleets["mission"]);
      $its_target  = get_fleets_target($its_fid);

      // full fleet item, own or borrowed units
      $return_array[$i]["itemType"] = "FULL_FLEET_ITEM";
      $return_array[$i]["type"]     = "fleet";

      // sounds
      // okay, suboptimal weil gleiche funkiion schon bei get_fleet_pic aufgerufen wird :S, bin jetzt aba faul
      $strongest_ship = get_strongest_ship_by_fid($its_fid);

      // ggf noch sounds von admirälen einfügen
      $sound_array    = get_sound_by_prod_id($strongest_ship);


      $return_array[$i]["soundReport"]   = $sound_array["report"];
      $return_array[$i]["soundConfirm"]  = $sound_array["confirm"];


      // Target
      if ($its_target["planet"]["tid"] || $its_target["system"]["tid"])
      {

        // ETA berechnen
        $return_array[$i]["eta"] = get_true_ETA_by_fid($its_fid);

        if ($its_target["planet"]["tid"])
          $return_array[$i]["target"] = get_planetname($its_target["planet"]["tid"]);
        else
          $return_array[$i]["target"] = get_systemname($its_target["system"]["tid"]);
      }


      // Mission
      $return_array[$i]["missionSymbol"]   = $its_mission[2];
      $return_array[$i]["missionName"]     = $its_mission[0];
      $return_array[$i]["mission"]         = $fleets["mission"];

      // Tactics
      $return_array[$i]["tactic"]           = $fleets["tactic"];
      $return_array[$i]["tacticSymbol"]     = 0;
      $return_array[$i]["tacticName"]       = get_tactic_by_tacticflag($fleets["tactic"]);

      // Reloading?
      $return_array[$i]["reloadSymbol"]     = get_reload($its_fid);

      // Infantry aboard?
      $return_array[$i]["infantrySymbol"]   = get_infantrycount_by_fid($its_fid);

      // Minister of Defence
      $return_array[$i]["modSymbol"]        = $fleets["milminister"];

      // FLEET CONTROL
      //manage fleet
      if (!$is_commanded_by_mod)
        $return_array[$i]["fleet_control"] .= "<SR_FLEET_CONTROL type=\"SR_SIMPLE_ACTION\" face=\"control_button_manage_fleet.svgz\" controlName=\"manage fleet\" description=\"manage fleet\"/>";

      $planet_uid = get_uid_by_pid($its_fleet->pid);
      // transfer infantry
      if ($its_fleet->get_total_transporter_capacity() > 0 && (($planet_uid == $its_fleet->uid || is_allied($planet_uid, $its_fleet->uid))) || (has_infantry_on_planet($its_fleet->pid, $its_fleet->uid)))
      //if ($its_fleet->get_total_transporter_capacity() > 0 && has_infantry_on_planet($its_fleet->pid, $its_fleet->uid))
      {
       $return_array[$i]["fleet_control"] .= "<SR_FLEET_CONTROL type=\"SR_SIMPLE_ACTION\" face=\"control_button_inf_transfer.svgz\" controlName=\"transfer infantry\" description=\"transfer infantry\"/>";
      }
    }
    else
    {
      // bäh, mir fällt kein anständiges query ein
      $light = 0;
      $medium = 0;
      $heavy = 0;

      $sth3 = mysql_query("select sum(count), typ as shipcount from fleet join production using(prod_id) where fid='".$its_fid."' group by typ");

      if ((!$sth3) || (!mysql_num_rows($sth3)))
        return 0;

      while (list($shipcount, $typ) = mysql_fetch_row($sth3))
      {
        switch ($typ)
        {
          case "L":
            $light = $shipcount;
          break;
          case "M":
            $medium = $shipcount;
          break;
          case "H":
            $heavy = $shipcount;
          break;
        }
      }

      $return_array[$i]["footer"] = $heavy." ".$medium." ".$light;

      $return_array[$i]["type"]     = "fleet";
      $return_array[$i]["text1"]    = htmlspecialchars($fleets_user_info["name"]);
      $return_array[$i]["text2"]    = htmlspecialchars($fleets_user_info["imperium"]);

      if ($return_array[$i]["relationClass"] == "colorAllied")
      {
        $return_array[$i]["itemType"] = "ADVANCED_FLEET_ITEM";
        $return_array[$i]["fleet_control"] .= "<SR_FLEET_CONTROL type=\"SR_SIMPLE_ACTION\" face=\"control_button_examine_fleet.svgz\" controlName=\"examine fleet\" description=\"view fleet details\"/>";
      }
      else
      {
        $return_array[$i]["itemType"] = "FLEET_ITEM";
        // fleet control buttons, keine Attribute sondern childs, nur nach den Attributen im $return_array auflisten!

        // special actions
        $special_actions = get_special_fleet_actions($its_fid, "fleet");

        if (is_array($special_actions))
        {
          for ($j = 0; $j < sizeof($special_actions); $j++)
          {
            $return_array[$i]["fleet_control"] .= "<SR_FLEET_CONTROL type=\"SR_SPECIAL_ACTION\" face=\"".$special_actions[$j]["picture"]."\" controlName=\"".$special_actions[$j]["name"]."\" description=\"".$special_actions[$j]["description"]."\" controlId=\"".$special_actions[$j]["action_id"]."\"";
            $return_array[$i]["fleet_control"] .= " metal=\"".$special_actions[$j]["metal"]."\" energy=\"".$special_actions[$j]["energy"]."\" mopgas=\"".$special_actions[$j]["mopgas"]."\" erkunum=\"".$special_actions[$j]["erkunum"]."\" gortium=\"".$special_actions[$j]["gortium"]."\" susebloom=\"".$special_actions[$j]["susebloom"]."\"/>";
          }
        }

        // fleet control EXAMINE FLEET falls die flotte sich in unmittelbarer Nähe zu dem user und seinen alliierten befindet
        if (fleet_is_examinable($its_fid, $its_fleet->sid) == "true")
        {
          $return_array[$i]["fleet_control"] .= "<SR_FLEET_CONTROL type=\"SR_SIMPLE_ACTION\" face=\"control_button_examine_fleet.svgz\" controlName=\"examine fleet\" description=\"view fleet details\"/>";
          
          if (has_noscan_ships_and_constructions($its_fid)) {
            $return_array[$i]["picture"] = "animationRauschen";
            $return_array[$i]["footer"] = "0 0 0";
          }
        }
        else
        {
          // wenn in scanrange, aber nicht wirklih sichbar, picture zu p_unknown.jpg ändern
          $return_array[$i]["picture"] = PIC_ROOT."p_unknown.png";
          
          if (has_noscan_ships_and_constructions($its_fid)) {
            $return_array[$i]["footer"] = "0 0 0";
          }
        }
      }
    }

    if ($uid==$its_fleet->uid || $map_info->is_allied($its_fleet->uid) || fleet_is_examinable($its_fid))
    {

      // mop: alle schiffsnamen
      $prod_ids=array_keys($its_fleet->ships);

      $sth2=mysql_query("select prod_id,name,typ from production where prod_id in (".implode(",",$prod_ids).")");

      while (list($prod_id,$name, $typ)=mysql_fetch_row($sth2))
      {
        $ship_data=$its_fleet->ships[$prod_id];
        $ship_data[]=$name;
        $ship_data[]=$typ;
        $ships[$i][$prod_id]=$ship_data; // mop: enthält dann array aus count und reload
      }
    }
  $i++;
  }

  return array($return_array,$ships);
}

function get_star($sid)
{
  global $uid;
  global $map_info;

  $fog_of_war=$map_info->get_fog_of_war();

  $fogged=false;

  if (!in_array($sid,$map_info->get_scanned_systems()))
  {
    if (!$fog_of_war[$sid])
      return false;
    else
      $fogged=true;
  }

  // BUTTON Definitionen
  $buttonShape = "button_circle_30x30_shadow";

  $system_info = $map_info->get_system($sid);

  // Ok, Buttons kreieren und in $new_button[] speichern
  $new_button=array();

  if (!$fogged)
  {
    $sth=mysql_query("select fid from fleet_info where sid=".$sid." and pid=0 limit 1");

    if (!$sth)
      return false;

    if (mysql_num_rows($sth)>0)
      $new_button[] = create_button($buttonShape, "button_face_ship", "showItemBoxItems('fleet')", 0,  "show fleets");
  }
  
  $new_header = create_header(PIC_ROOT . "system".$system_info["type"].".svgz", $system_info["name"], "", "", "");

  // Button in das Header Tag einfügen
  for ($i = 0; $i < sizeof($new_button); $i++)
  {
    $new_header .= $new_button[$i];
  }

  $new_header .= "</SR_HEAD>";

  echo("newItemBox\n");   // nötig um zu ermitteln wie der inhalt behnadelt werden soll!
  echo($new_header);
}

function get_jumpgate($sid)
{
  global $uid;
  global $map_info;

  if (!in_array($sid,$map_info->get_possible_scan_systems()) && !in_array($sid,$map_info->get_all_fleet_scans()))
    return false;

  // BUTTON Definitionen
  $buttonShape = "button_circle_30x30_shadow";

  $system_info = $map_info->get_system($sid);
  $j_pid        = get_pid_of_jumpgate($sid);        // pid des jumpgates
  $j_uname      = get_name_by_uid($j_uid);          // name des jumpgatebesitzers

  $sth = mysql_query("select prod_id from jumpgates where pid='$j_pid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  list($j_prodid) = mysql_fetch_row($sth);
  $j_prodname     = get_name_by_prod_id($j_prodid);
  $j_pic          = PIC_ROOT . get_pic($j_prodid);

  // Ok, Buttons kreieren und in $new_button[] speichern
  $new_button=array();

  $new_button[] = create_button($buttonShape, "button_face_info", "alert('not yet implemented')", 0,  "show info");

  $new_header = create_header($j_pic, "Jumpgate in ".$system_info["name"], "", "", "");

    // Button in das Header Tag einfügen
    for ($i = 0; $i < sizeof($new_button); $i++)
    {
      $new_header .= $new_button[$i];
    }

  $new_header .= "</SR_HEAD>";

  echo("newItemBox\n");   // nötig um zu ermitteln wie der inhalt behnadelt werden soll!
  echo($new_header);
}


/****************************
 *
 * planet detail
 *
 ****************************/
function get_planetDetail($pid)
{
  global $uid;
  global $map_info;

  $sth = mysql_query("select * from planets where id='".$pid."'");

  if (!$sth || (!mysql_num_rows($sth)))
    return false;

  $p_info = mysql_fetch_array($sth);

  // erzeuge den user tag, der alles nötige über den Besitzer des Planet enthält
  if ($p_info["uid"]) {
    $sth = mysql_query("select u.name, u.imperium, a.name as aname, a.color, a.symbol from users u LEFT JOIN alliance a ON u.alliance = a.id where u.id=".$p_info["uid"]);

    if (!$sth || (!mysql_num_rows($sth)))
      return false;

    $u_info = mysql_fetch_array($sth);
    $p_relation = get_uids_relation($uid, $p_info["uid"]);

    $user_tag = create_user_tag($p_info["uid"], htmlspecialchars($u_info["name"]), htmlspecialchars($u_info["imperium"]), htmlspecialchars($u_info["aname"]), $u_info["color"], $u_info["symbol"], $p_relation);
  }
  else
    $p_relation = false;

  // erzeuge den resource tag, der den derzeitigen resourcen output wiedergibt
  $resource_tag = create_resource_tag($p_info["metal"],$p_info["energy"],$p_info["mopgas"],$p_info["erkunum"],$p_info["gortium"],$p_info["susebloom"], $p_info["popgain"]);

  // erzeuge den planeten tag, das alle nötigen infos des planeten enthält
  if ($p_info["name"] == "Unnamed")
    $p_info["name"] = get_planetname($pid);

  if ($p_relation == "same" || $p_relation == "allie")
  {
    $planet_tag   = create_planet_tag($pid, htmlspecialchars($p_info["name"]), $p_info["type"], PIC_ROOT . $p_info["pic"], $p_info["start"], get_poplevel_by_pop($p_info["population"]));
    $building_tag   = create_buildings_tag($pid);
    $production_tag = create_production_tag($pid);
  }
  else
  {
    $planet_tag   = create_planet_tag($pid, htmlspecialchars($p_info["name"]), $p_info["type"], PIC_ROOT . $p_info["pic"], $p_info["start"]);

    if (can_scan_planet_surface($pid))
        $building_tag = create_buildings_tag($pid);
  }

  echo("<SR_REQUEST type=\"planet_info\">");
  echo($user_tag);
  echo($resource_tag);
  echo($planet_tag);
  echo($building_tag);
  echo($production_tag);
  echo("</SR_REQUEST>");
}


function get_planetProduction($pid)
{
  global $uid;

  $puid = get_uid_by_pid($pid);
  $p_relation = get_uids_relation($uid, $puid);


  if ($p_relation == "same" || $p_relation == "allie")
  {
    $production_tag = create_production_tag($pid);
  }
  echo("<SR_REQUEST type=\"planet_info_prod\" pid=\"".$pid."\">");
  echo($production_tag);
  echo("</SR_REQUEST>");
}


$map_info=new map_info($uid);
switch ($_GET["act"])
{
  case "clickOnPlanet":
    getPlanetData();
  break;
  case "clickOnGetItems":
    get_items();
  break;
  case "clickOnStar":
    get_star($_GET["sid"]);
    break;
  case "clickOnJumpGate":
    get_jumpgate($_GET["sid"]);
    break;
  case "clickOnGetPlanetInfo":
    get_planetDetail($_GET["pid"]);
  break;
  case "getPlanetInfoProduction":
    get_planetProduction($_GET["pid"]);
  break;
}
$content=ob_get_contents();
ob_end_clean();

if ($_GET["debug"])
  print $content;
else
  print gzcompress($content);
// mop: wer is lasse? :S:S:S:S:S:S:S
// 0345 - 6140735 // Lasses telenr.
//  select sum(count) as shipcount from fleet join production using(prod_id) where fid=28 group by typ;
?>
