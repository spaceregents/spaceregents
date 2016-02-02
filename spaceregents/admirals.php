<?php
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/gp/class_browser.inc.php";
include "../spaceregentsinc/gp/class_searchform.inc.php";
include "../spaceregentsinc/class_srbrowser.inc.php";
include "../spaceregentsinc/admirals.inc.php";
include "../spaceregentsinc/fleet.inc.php";

/** 
 * callback um xp => level zu machen
 * 
 * @param $spaltenname,$values,$unmod_values 
 * @return 
 */
function browser_calc_level($spaltenname,$values,$unmod_values)
{
  return calculate_admiral_level($values[$spaltenname]);
}

/** 
 * wenn fleet NULL ist, muss da natürlich was sinnvolles stehen
 * 
 * @param $spaltenname,$values,$unmod_values 
 * @return 
 */
function browser_check_fleet($spaltenname,$values,$unmod_values)
{
  if (!$values[$spaltenname])
    return "-- Not yet assigned --";
  else
    return $values[$spaltenname];
}

/** 
 * was kann man mit dem admiral machen? assignen und dismissen
 * 
 * @param $spaltenname,$values,$unmod_values 
 * @return 
 */
function create_admiral_options($spaltenname,$values,$unmod_values)
{
  if (!$values["f.name"])
    return "<a href=\"".$_SERVER["PHP_SELF"]."?act=assign&aid={a.id}\">Assign</a>";
  else
    return "<a href=\"".$_SERVER["PHP_SELF"]."?act=dismiss&id={a.id}\">Dismiss</a>";
}

function create_fleet_options($spaltenname,$values,$unmod_values)
{
  return "<a href=\"".$_SERVER["PHP_SELF"]."?act=proc_assign&aid=".$_REQUEST["aid"]."&fid={f.fid}\">Assign</a>";
}

function browser_check_planet($spaltenname,$values,$unmod_values)
{
  if (!$values[$spaltenname])
    return "-";
  else
    return $values[$spaltenname];
}

/** 
 * zeiugt alle admiräle an 
 * 
 * @return 
 */
function show_admirals()
{
  global $uid;
  
  // mop: instanzname
  $instanz="admirals";
  // mop: betroffene tabellen
  $tables="admirals a left join fleet_info f on (a.fid=f.fid)";
  // mop: alle felder, die angezeigt werden sollen
  $fields=array("Name"=>"a.name",
                "Level"=>"a.value",
                "Fleet"=>"f.name",
                "Portrait"=>"a.pic",
                "Initiative"=>"a.initiative",
                "Agility"=>"a.agility",
                "Sensor"=>"a.sensor",
                "Weaponskill"=>"a.weaponskill",
                );

  $where_addon="where a.uid=".$uid;
 
  $browser=new srbrowser($tables,"a.name",$fields,"show_admirals",$instanz,"a.id",$GLOBALS["db"]);
  $browser->showgroup=0;
  $browser->wrap=1000000;
  // mop: callbackfunktionen zum rumhuren
  $browser->col_function=array("a.value"=>"browser_calc_level",
                               "f.name" =>"browser_check_fleet",
                               "options"=>"create_admiral_options",
                              );
  // mop: zellentemplates
  $browser->col_template=array("a.pic"=>"<img src=\"portraits/{a.pic}\" alt=\"{a.name}\" title=\"{a.name}\"/>");
  $browser->zusatz_head["options"]="Options";
  $browser->zusatz_body["options"]="";
  $browser->extra_fields["a.id"]="a.id";
  $browser->browse($where_addon);
}

function assign()
{
  global $uid;
  global $ses;
  
  // mop: instanzname
  $instanz="fleets";
  
  // mop: betroffene tabellen
  $tables="fleet_info f,systems s left join planets p on (p.id=f.pid) left join admirals a on (a.fid=f.fid)";
  // mop: alle felder, die angezeigt werden sollen
  $fields=array("Name"=>"f.name",
                "System"=>"s.name",
                "Planet"=>"p.name",
                );

  $where_addon="where f.uid=".$uid." and f.sid=s.id and a.id is null";
 
  $browser=new srbrowser($tables,"f.name",$fields,"assign&aid=".$_REQUEST["aid"],$instanz,"f.fid",$GLOBALS["db"]);
  $browser->showgroup=0;
  $browser->wrap=1000000;
  $browser->tabellenkopftext="Select a fleet";

  $browser->col_function=array("p.name"=>"browser_check_planet",
                               "options"=>"create_fleet_options",
                               );
  $browser->zusatz_head["options"]="Options";
  $browser->zusatz_body["options"]="";
  $browser->browse($where_addon);
}

function proc_assign()
{
  global $uid;
  
  if (get_admiral_owner($_REQUEST["aid"])!=$uid)
  {
    show_error("FUFUFUFUFUFFU");
    return false;
  }
  
  if (get_uid_by_fid($_REQUEST["fid"])!=$uid)
  {
    show_error("NANANANANANAN");
    return false;
  }

  set_admiral($_REQUEST["aid"],$_REQUEST["fid"]);
}

function dismiss()
{
  global $uid;
  
  if (get_admiral_owner($_REQUEST["id"])!=$uid)
  {
    show_error("FUFUFUFUFUFFU");
    return false;
  }
  set_admiral($_REQUEST["id"],0);
}

switch ($_REQUEST["act"])
{
  case "assign":
    assign();
    break;
  case "proc_assign":
    proc_assign();
    show_admirals();
    break;
  case "dismiss":
    dismiss();
    show_admirals();
    break;
  default:
    show_admirals();
}
include "../spaceregentsinc/footer.inc.php";
?>
