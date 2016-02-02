<?php
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/gp/class_browser.inc.php";
include "../spaceregentsinc/gp/class_searchform.inc.php";
include "../spaceregentsinc/class_srbrowser.inc.php";
include "../spaceregentsinc/class_srsearchform.inc.php";
include "../spaceregentsinc/alliances.inc.php";

$GLOBALS["ses"]->page_birth();

function print_searchform($instanz,$act)
{
  $instanz="search_".$instanz;
    
  $form[] = array("type"    => "clearall",
		    "text"    => "Clear all conditions",
		    "varname" => "clearall"
	           );

  $form[]=array("type"=>"text",
                "text"=>"Minimum Week",
                "varname"=>"_minw",
                "size"=>40,
                );

  $where[]=array("where"=>"(b.week>='{_minw}')");

  $form[]=array("type"=>"text",
                "text"=>"Maximum Week",
                "varname"=>"_maxw",
                "size"=>40,
                );
  
  $where[]=array("where"=>"(b.week<='{_maxw}')");
  
  $form[]=array("type"=>"text",
                "text"=>"System",
                "varname"=>"_system",
                "size"=>40,
                );

  $where[]=array("where"=>"(s.name like '%{_system}%')");
  
  $form[]=array("type"=>"text",
                "text"=>"Planet",
                "varname"=>"_planet",
                "size"=>40,
                );

  $where[]=array("where"=>"(p.name like '%{_planet}%')");

  $search=new srsearchform($instanz,$act,"Search",$form,$where);

  return $search->print_searchform();
}

/** 
 * zeiugt eigene reports an
 * 
 * @return 
 */
function show_own()
{
  global $uid;
  
  // mop: instanzname
  $instanz="reports_own";
  // mop: act
  $act="show_own";
  // mop: betroffene tabellen
  $tables="battlereports b,battlereports_user bu,systems s left join planets p on (p.id=b.pid)";
  // mop: alle felder, die angezeigt werden sollen
  $fields=array("Week"=>"b.week",
                "System"=>"s.name",
                "Planet"=>"p.name",
                );
  
  $where_addon=print_searchform($instanz,$act);
  
  if (!$where_addon)
    $where_addon.="where 1=1";

  $where_addon.=" and b.id=bu.rid and s.id=b.sid and bu.uid=".$uid;
 
  $browser=new srbrowser($tables,"b.week",$fields,$act,$instanz,"b.id",$GLOBALS["db"]);
  $browser->tabellenkopftext="Your Battlereports";

  browse_reports($browser,$where_addon);
}

/** 
 * zeigt die reports der allianz an 
 * 
 * @return 
 */
function show_alliance()
{
  global $uid;
  
  // mop: instanzname
  $instanz="reports_own";
  // mop: act
  $act="show_alliance";
  // mop: betroffene tabellen
  $tables="battlereports b,battlereports_alliance ba,systems s left join planets p on (p.id=b.pid)";
  // mop: alle felder, die angezeigt werden sollen
  $fields=array("Week"=>"b.week",
                "System"=>"s.name",
                "Planet"=>"p.name",
                );

  $where_addon=print_searchform($instanz,$act);
  
  if (!$where_addon)
    $where_addon.="where 1=1";

  $where_addon.=" and b.id=ba.rid and s.id=b.sid and ba.aid=".get_alliance($uid);
 
  $browser=new srbrowser($tables,"b.week",$fields,$act,$instanz,"b.id",$GLOBALS["db"]);
  $browser->tabellenkopftext="Alliance Battlereports";
  browse_reports($browser,$where_addon);
}

/** 
 * report endgültig anzeigen 
 * 
 * @param $browser 
 * @return 
 */
function browse_reports($browser,$where_addon)
{
  $browser->extra_fields[]="b.report";
  $browser->zusatz_head[]="Report";
  $browser->zusatz_body[]="{b.report}";
  $browser->showgroup=1;
  $browser->wrap=1000000;
  
  $browser->browse($where_addon);
}

switch ($_REQUEST["act"])
{
  case "show_alliance":
    show_alliance();
    break;
  default:
    show_own();
}
$GLOBALS["ses"]->page_end();
include "../spaceregentsinc/footer.inc.php";
?>
