<?php
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/gp/class_browser_modified.inc.php";
include "../spaceregentsinc/gp/class_searchform_modified.inc.php";
include "../spaceregentsinc/missiontypes.inc.php";
include "../spaceregentsinc/admirals.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/class_fleet_manager.inc.php";

// ------------------------------- hier funkltionen

function show_menu()
{
 global $skin;
 global $PHP_SELF;
 
 echo("<br><br>\n");
 table_start("center","300");
 table_text(array("<a href='".$PHP_SELF."?act=browse_fleets'><img src=\"skins/".$skin."_fleetov.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Fleets Functions\"></a>","<a href='".$PHP_SELF."?act=show_totalfleets'><img src=\"skins/".$skin."_fleet.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Fleets\"></a>","<a href='".$PHP_SELF."?act=show_infantry'><img src=\"skins/".$skin."_infan.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Ground Forces\">"),"center","100");
 table_text(array("<h5>Fleet Control</h5>","<h5>Fleets</h5>","<h5>Ground Forces</h5>"),"center");
 table_end();
} 

function show_totalfleets()
{
 global $uid;
 
 $sth = mysql_query("select fid from fleet_info where uid=$uid order by sid, pid, name");
 
 if (!$sth)
 {
   show_message("DB Error");   
   return 0;
 }
 
 if (mysql_num_rows($sth)==0)
 {
   show_message("You don't have any fleets :(");
 }
 
 while ($its_fleets = mysql_fetch_array($sth))
 {
   $fleets[] = new fleet($its_fleets["fid"]);
 }
 
 // Farbendefinition für verschiedene Flotten Befehle
 $mission[0] = "defend.jpg";
 $mission[1] = "attack.jpg";
 $mission[2] = "intercept.jpg";
 $mission[3] = "bomb.jpg";
 $mission[4] = "colonize.jpg";
 $mission[5] = "invade.jpg";
 

 $prev_sid = 0;
 
 table_start("center","500");
 for ($i = 0; $i < sizeof($fleets); $i++)
 {
   if ($fleets[$i]->sid != $prev_sid)
   {
     $system_name = get_systemname($fleets[$i]->sid);
     table_head_text(array("System: ".$system_name),"6");
     $prev_sid = $fleets[$i]->sid;
   }
   
   // Flotten-Bild
   $fleet_pic = get_fleet_pic($fleets[$i]->fid);
   $fleet_pic = "<img src=\"".$fleet_pic."\" border=\"0\" alt=\"".$fleets[$i]->name."\" width=\"16\" height=\"16\" />";
   
   
   // Mission
   $mission_pic_alt     = $fleets[$i]->get_mission();
   $mission_pic = "<img src=\"".(PIC_ROOT . "fleet_mission_" . $mission[$fleets[$i]->mission])."\" border=\"0\" alt=\"".$mission_pic_alt[0]."\" height=\"15\" />";
   
   // Position
   if ($fleets[$i]->tpid || $fleets[$i]->tsid)
    $position = "<img src=\"".PIC_ROOT."fleet_icon_move.jpg\" alt=\"moving\" height=\"15\" />&nbsp;" . $system_name . "<br>";
   else
    $position = $system_name;
   
   // Ziel
   if ($fleets[$i]->tpid)
    $target = get_planetname($fleets[$i]->tpid);
   elseif ($fleets[$i]->tsid)
    $target = get_systemname($fleets[$i]->tsid);
   else
    $target = "";
    
   $misc = "";
  
   // misc
   if ($infantry_count = $fleets[$i]->get_infantry_count_aboard())
     $misc = "<img src=\"".(PIC_ROOT)."fleet_icon_infantry.jpg\" height=\"15\" border=\"0\" alt=\"Infantry aboard (".$infantry_count.")\" />";
    
   $sth = mysql_query("select 1 from fleet f, production p where f.prod_id = p.prod_id and f.fid = ".$fleets[$i]->fid." and (p.special='O' or p.special='C')");
  
   if (!$sth)
     return 0;
  
   if (list($has_colonists) = mysql_fetch_row($sth))
     $misc .= "&nbsp;<img src=\"".(PIC_ROOT)."fleet_icon_colonists.jpg\" height=\"15\" border=\"0\" alt=\"Colonists aboard\" />";
     
   // tonnage
   $tonnage = $fleets[$i]->get_total_tonnage();
   
    
   

   // erst die Flotten die in keinem Orbit sind   
   if (!$fleets[$i]->pid)
   {
     table_text_open();
     table_text_design($fleet_pic,"15","","","smallhead");
     table_text_design($fleets[$i]->name,"135","","2","smallhead");
     table_text_design($position." ".$mission_pic." ".$target,"200","","","smallhead");
     table_text_design($misc,"100","","","smallhead");
     table_text_close();
     list_fleet_ships($fleets[$i]->ships);
     table_text(array("&nbsp","&nbsp;","&nbsp","Total: ".$fleets[$i]->get_total_shipcount(),$tonnage." t"),"","","","smallhead");
   }
   else
   {
     $planetname = get_planetname($fleets[$i]->pid);
     $planet_pic = "<img src=\"".(PIC_ROOT . get_planets_type($fleets[$i]->pid) . "_small.gif\" height=\"12\" width=\"12\" border=\"0\" alt=\"".$planetname."\"/>");
     
     table_text_open();
     table_text_design($planet_pic,"15","","","head");
     table_text_design("Planet: ".$planetname,"485","","5","head");
     table_text_close();
     table_text_open();
     table_text_design($fleet_pic,"15","","","smallhead");
     table_text_design($fleets[$i]->name,"135","","2","smallhead");
     table_text_design($position." ".$mission_pic." ".$target,"200","","","smallhead");
     table_text_design($misc,"100","","","smallhead");
     table_text_close();
     list_fleet_ships($fleets[$i]->ships);
     table_text(array("&nbsp","&nbsp;","&nbsp","Total: ".$fleets[$i]->get_total_shipcount(),$tonnage." t"),"","","","smallhead");
   }
     table_text(array("&nbsp;"));
 }
 table_end();
}

function list_fleet_ships($ships)
{
  if (is_array($ships))
  {
    for ($i = 0; $i < sizeof($ships); $i++)
    {
      $ship = each($ships);
      $ship_name = get_name_by_prod_id($ship[0]);
      
      if ($ship[1][1])
        $ship_reload = "<img src=\"".PIC_ROOT."fleet_icon_refuel.jpg\" height=\"15\" border=\"0\" alt=\"refueling\" />" . $ship[1][1] . " weeks";
      else
        $ship_reload = "";
        
        
      $ship_pic = "<img src=\"".(PIC_ROOT . get_pic($ship[0]))."\" border=\"0\" alt=\"".($ship_name)."\" width=\"15\" height=\"15\" />";
      
      table_text_open();
      table_text_design("&middot;","15","center","","text");
      table_text_design($ship_pic,"15","","","text");
      table_text_design($ship_name,"170","","","text");
      table_text_design("count: ".$ship[1][0],"200","","","text");
      table_text_design($ship_reload,"100","","2","text");
      table_text_close();
    }
  }
}

function show_infantry()
{
 global $uid;
 global $skin;
 
 $sth=mysql_query("select p.id as pid,p.name as pname,s.x,s.y,s.id as sid,c.name as cname from constellations as c,planets as p,systems as s where p.uid=$uid and c.id=s.cid and p.sid=s.id order by s.x,s.y,p.name");
   
 if (!$sth)
  {
   show_message("Da Databse Failure");
   return 0;
  }

center_headline("Groundforces");

if (mysql_num_rows($sth)==0)
 show_message("You don't have any ground forces.");
else
 {
  while ($planets=mysql_fetch_array($sth))
   {
   if (($system_old[0]!=$planets["x"]) or ($system_old[1]!=$planets["y"]))
     {
      $system_old[0]=$planets["x"];
      $system_old[1]=$planets["y"];
    if ($system_old[0]!="")
     table_end();
    echo("<br><br>\n");
    table_start("center","500");
    table_head_text(array("System ".get_systemname($planets["sid"])),"2");
     }
    if ($planets["pname"]=="Unnamed")
     $planets["pname"] = get_planetname($planets["id"]);
    table_text_open();
    table_text_design("<a href='production.php?pid=".$planets["pid"]."&act=inf'>".$planets["pname"]."</a>","300","","","smallhead");
    table_text_design("&nbsp;","200","","","smallhead");
    table_text_close();
      $sth1=mysql_query("select i.*,p.name from infantery as i,production as p where i.uid=$uid and i.prod_id=p.prod_id and i.pid=".$planets["pid"]." order by p.name");
    if (!$sth1)
     {
      show_message("Database Faulure");
      return 0;
     }
    if (mysql_num_rows($sth1)!="")
    while ($infantry=mysql_fetch_array($sth1))
      table_text(array($infantry["name"],$infantry["count"]),"left","","","text");
    else
      table_text(array("<font color='red'>No Units</font>"),"left","","2","text");
     }
} 
 table_end();
}
//------------------------------------------------------------------------------------------------------------------------

function join_fleets()
{
  global $uid;
  global $fleet;

  if (!is_array($fleet))
  {
    show_error("You have to select at least 2 fleets in order to join them!");
    return 0;
  }

  while (list($key,$value)=each($fleet))
  {
    if ($value=="Y")
    {
      $fleets[]=new fleet($key);
    }
  }

  if (sizeof($fleets)<2)
  {
    show_error("You have to select at least 2 fleets in order to join them!");
    return 0;
  }
  
  $data=array();
  for ($i=0;$i<sizeof($fleets);$i++)
  {
    // mop: einfach alle schiffe der flotten nehmen ($ship_info[0] ist der count)
    foreach ($fleets[$i]->ships as $prod_id => $ship_info)
      $data[$fleets[$i]->fid][$prod_id]=$ship_info[0];
  }
  
  $manager=new fleet_manager($data);
  $manager->execute();
}

function new_fleet()
{
  global $PHP_SELF;
  global $fleet;
  global $uid;

  if (!is_array($fleet))
  {
    show_error("You have to select a fleet and some ships in order to create a new fleet!");
    return 0;
  }

  while (list($key,$value)=each($fleet))
  {
    if ($value=="Y")
    {
      $fleets[]=new fleet($key);
    }
  }

  // mop: daten für den flottenmanager initialisieren
  $data=array();
  for ($i=0;$i<sizeof($fleets);$i++)
  {
    $data[$fleets[$i]->fid]=$_REQUEST["fleet_".$fleets[$i]->fid];
  }
  
  $manager=new fleet_manager($data);
  $manager->execute();
}

function transfer()
{
  global $uid;
  global $fleet;
  global $PHP_SELF;
  global $HTTP_REFFERRER;

  if (!is_array($fleet))
  {
    show_error("You have to select a fleet and some ships in order to transfer!");
    return 0;
  }

  $i=0;
  while (list($key,$value)=each($fleet))
  {
    if ($value=="Y")
    {
      $fleets[$i]=new fleet($key);

      if (!$fleets[$i]->uid==$uid)
      {
	show_error("Hello! I'm your friend...Why are you trying such nasty things?");
	return 0;
      }

      if (!$pid)
      {
	$pid=$fleets[$i]->pid;
	$sid=$fleets[$i]->sid;
      }
      else
      {
	if (($fleets[$i]->pid!=$pid) || ($fleets[$i]->sid!=$sid))
	{
	  show_error("You may only select fleets which are at the same planet and system!");
	  return 0;
	}
      }
    }
    $i++;
  }

  $new_fleet=new fleet();

  echo("<form action=\"".$PHP_SELF."\" method=post>");

  for ($i=0;$i<sizeof($fleets);$i++)
  {
    $temp_var="fleet_".$fleets[$i]->fid;

    global ${$temp_var};
    
    foreach ((array) ${$temp_var} as $key => $value)
    {
      // Überprüfen ob die werte ok sind (key=>prod_id, value=>count)
      if (($fleets[$i]->ships[$key]) && ($fleets[$i]->ships[$key][0]>=$value) && ((int) $value>0))
      {
	// Das wird nachher ausgelesen um die flotten auch um den wert zu reduzieren
	$fleets[$i]->ships[$key][0]-=$value;
	$aff_fleets[]=$fleets[$i]->fid;
	$new_fleet->add_ships_arr(array($key=>array($value,$fleets[$i]->ships[$key][1])));
      }
      elseif ($value==0)
	continue;
      else
      {
	show_error("You entered a wrong shipcount for fleet ".$fleets[$i]->name."!");
	return 0;
      }

      form_hidden("fleet_".$fleets[$i]->fid."[".$key."]",$value);
    }
  } 

  $fids=get_fids_by_pid($pid,$uid,$sid);

  for ($i=0;$i<sizeof($fleets);$i++)
  {
    // mop: was für nen toller hack
    if (in_array($fleets[$i]->fid,$fids))
    {
      // mop: umdrehen, damit wir das unsetten können ohne das array komplett durchsuchen zu müssen
      $fids_tmp=array_flip($fids);
      unset($fids_tmp[$fleets[$i]->fid]);
      // mop: und wieder zurück
      $fids=array_flip($fids_tmp);
    }
    form_hidden("fid[".$i."]",$fleets[$i]->fid);
  }

  // mop: wenn fertig fidsarray neubauen
  $fids=array_values($fids);

  // mop: jetzt die ausgewählten flotten abwählen

  for ($i=0;$i<sizeof($fids);$i++)
  {
    $trans_fleets[$i]=new fleet($fids[$i]);
  }

  if (sizeof($trans_fleets)==0)
  {
    center_headline("You have no fleets you could transfer these ships to:)");
    go_back($_SERVER["PHP_SELF"]);
  }
  else
  {
    for ($i=0;$i<sizeof($trans_fleets);$i++)
    {
      $head_array="";
      $text_arr="";
      $prod_arr="";
      table_start("center","80%");
      table_head_text(array("Fleet ".$trans_fleets[$i]->name),"20");
      $head_array[0]="&nbsp;";
      $prod_arr[0]="";
      $text_arr[0]="<input type=radio name=\"fleet\" value=\"".$trans_fleets[$i]->fid."\">";

      reset($trans_fleets[$i]);

      while (list($prod_id,$ship_arr)=each($trans_fleets[$i]->ships))
      {
	$head_array[]=get_name_by_prod_id($prod_id);
	$text_arr[]=$ship_arr[0];
      }
      $mission=$trans_fleets[$i]->get_mission();

      list($type,$location)=$trans_fleets[$i]->get_location();

      if ($type==0)
	$mission_text=$mission[0]." ";
      else
	$mission_text="On its way to ".$mission[1]." ";

      list($location_id,$location_type)=$location;

      if($location_type==0)
      {
	$mission_text.="planet ".get_planetname($trans_fleets[$i]->pid);
	$location_text="Planet ".get_planetname($trans_fleets[$i]->pid)."(".get_systemname($trans_fleets[$i]->sid).")";
      }
      else
      {
	$mission_text.="system ".get_system_coords($trans_fleets[$i]->sid);
	$location_text="System ".get_systemname($trans_fleets[$i]->sid);
      }

      table_text(array("&nbsp;"),"","","20","head");
      table_text_open();
      table_text_design("Mission:","50","","","smallhead");
      table_text_design($mission_text,"","","19","text");
      table_text_close();
      table_text($head_array,"","","","smallhead");
      table_text($text_arr,"","","","text");
      table_end();
      echo("<br><br>\n");
    }
    form_hidden("act","transferab");
    echo("<center>\n");
    echo("<input type=submit value=\"Transfer\">");
    echo("</center>\n");
    echo("</form>");
  }  
}

function transferab()
{
  global $uid;
  global $fleet;
  global $fid;

  if ($fleet=="")
  {
    show_error("You have to select a fleet in order to transfer ships!");
    return 0;
  }
  
  $fleets=array();
  for ($i=0;$i<sizeof($fid);$i++)
  {
    $fleets[]=new fleet($fid[$i]);
  }


  $data=array();
  for ($i=0;$i<sizeof($fleets);$i++)
  {
    $data[$fleets[$i]->fid]=$_REQUEST["fleet_".$fleets[$i]->fid];
  }
  
  $manager=new fleet_manager($data,$fleet);
  $manager->execute();
}

function rename_fleet()
{
  global $uid;
  global $fid;
  global $PHP_SELF;

  if (!$fleet=new fleet($fid))
  {
    show_error("Couldn't find fleet!");
    return 0;
  }

  if ($fleet->uid!=$uid)
  {
    show_error("One day you will go to jail:)");
    return 0;
  }

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  
  table_start("center","500");
  table_text_open("head");
  table_text_design("Rename Fleet ".$fleet->name,"","","2","","head");
  table_text_close();
  table_text_open("text");
  table_text_design("<input type=\"text\" name=\"name\" value=\"".$fleet->name."\">","400","","","","text");
  table_text_design("<input type=hidden name=\"fid\" value=\"".$fid."\"><input type=\"submit\" name=\"act\" value=\"Rename\">","100","","","","text");
  table_text_close();
  table_end();

  echo("</form>");
}

function proc_rename_fleet()
{
  global $uid;
  global $fid;
  global $name;

  if (!$fleet=new fleet($fid))
  {
    show_error("Couldn't find fleet!");
    return 0;
  }

  if ($fleet->uid!=$uid)
  {
    show_error("One day you will go to jail:)");
    return 0;
  }
  
  $fleet->name=$name;

  $fleet->set_name();
}

function show_admiral()
{
  global $uid;
  global $fid;
  global $PHP_SELF;

  $sth=mysql_query("select * from admirals where fid=".$fid." and uid=".$uid);

  if (!$sth)
    echo("Database failure!");

  if (mysql_num_rows($sth)==0)
    show_message("You currently don't have any Admiral assigned!");
  else
  {
    $admiral=mysql_fetch_array($sth);

    center_headline("Admiral");

    table_start("center","500");
    table_head_text(array("Admiral ".$admiral["name"].""),"8");
    table_text(array("&nbsp;"),"","","8","text");
    table_text_open();
    table_text_design("&nbsp;","50","","","head");
    table_text_design("Name","200","","","head");
    table_text_design("Rank","75","","","head");
    table_text_design("Initiative","75","","","head");
    table_text_design("Agility","75","","","head");
    table_text_design("Sensor","75","","","head");
    table_text_design("Weaponskill","75","","","head");
    table_text_design("&nbsp","75","","","head");
    table_text_close();

    if ($admiral["value"]<1000)
      $level=0;
    else
      $level=floor((log10($admiral["value"]/1000)/log10(2))+1);

    table_text_open();
    table_text_design("<img src=\"portraits/".$admiral["pic"]."\" border=\"0\" alt=\"".$admiral["name"]."\">",$admiral["name"],"200","center","","text");
    table_text_design($admiral["name"],"75","center","","text");
    table_text_design(get_admiral_level($admiral["id"]),"75","center","","text");

    foreach (array("initiative","agility","sensor","weaponskill") as $dummy => $value)
    {
      if (calculate_admiral_level($admiral["used_xp"])<get_admiral_level($admiral["id"]))
	$upgrade="<a href=\"".$PHP_SELF."?act=upgrade_admiral&id=".$admiral["id"]."&value=".$value."&fid=$fid\"><img src=\"arts/plus.jpg\" border=\"0\" width=\"10\"></a>";
      else
	$upgrade="";
      table_text_design($upgrade.$admiral[$value],"75","center","","text");
    }
    table_text_design("<a href=\"".$PHP_SELF."?act=unassign_admiral&fid=".$fid."\">unassign</a>","75","center","","text");
    table_text_close();

    table_end();
  }

  $sth=mysql_query("select * from admirals where fid=0 and uid=$uid");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
    return 0;

  center_headline("Admiral Pool");

  table_start("center","500");
  table_head_text(array("Admiral Pool"),"8");
  table_text(array("&nbsp;"),"","","8","text");
  table_text_open("head","center");
  table_text_design("&nbsp;","50","","","head");
  table_text_design("Name","180","","","head");
  table_text_design("Rank","75","","","head");
  table_text_design("Initiative","75","","","head");
  table_text_design("Agility","75","","","head");
  table_text_design("Sensor","75","","","head");
  table_text_design("Weaponskill","75","","","head");
  table_text_design("&nbsp;","20","","","head");

  table_text_close();

  while ($admiral=mysql_fetch_array($sth))
  {
    if ($admiral["value"]<1000)
      $level=0;
    else
      $level=floor((log10($admirals["value"]/1000)/log10(2))+1);

    table_text_open();
    table_text_design("<img src=\"portraits/".$admiral["pic"]."\" border=\"0\" alt=\"".$admiral["name"]."\">",$admiral["name"],"200","center","","text");
    table_text_design($admiral["name"],"75","center","","text");
    table_text_design(get_admiral_level($admiral["id"]),"75","center","","text");

    foreach (array("initiative","agility","sensor","weaponskill") as $dummy => $value)
    {
      if (calculate_admiral_level($admiral["used_xp"])<get_admiral_level($admiral["id"]))
	$upgrade="<a href=\"".$PHP_SELF."?act=upgrade_admiral&id=".$admiral["id"]."&value=".$value."&fid=$fid\"><img src=\"arts/plus.jpg\" border=\"0\" width=\"10\"></a>";
      else
	$upgrade="";
      table_text_design($upgrade.$admiral[$value],"75","center","","text");
    }
    table_text_design("<a href=\"".$PHP_SELF."?act=assign&fid=$fid&aid=".$admiral["id"]."\">Assign</a>","75","center","","text");
    table_text_close();
  }
  table_end();

}

function browse_fleets()
{
  global $uid;

  $GLOBALS["ses"]->page_birth();

  $tables  ="fleet_info fi, fleet f, production p,systems s left join planets pl on pl.id=fi.pid left join planets pl2 on fi.tpid=pl2.id left join systems s2 on fi.tsid=s2.id left join admirals a on fi.fid=a.fid";
  $order   ="fi.fid,p.name";
  $fields=array();
  $setact  ="browse_fleets";
  $instance="fleetbrowser";
  $prikey  ="fi.fid";

  $form[]=array("type"=>"text",
		"text"=>"Fleetname",
		"varname"=>"fleet_name",
		"size"=>"40"
		);

  $where[]=array("where"=>"fi.name like '%{fleet_name}%'");
  
  $form[]=array("type"=>"text",
		"text"=>"Planet",
		"varname"=>"planet_name",
		"size"=>"40"
		);

  $where[]=array("where"=>"pl.name like '%{planet_name}%'");
  
  $form[]=array("type"=>"text",
		"text"=>"System",
		"varname"=>"system_name",
		"size"=>"40"
		);

  $where[]=array("where"=>"s.name like '%{system_name}%'");
  echo("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">\n");
  $search = new searchform("fleet_search",$setact,"Search",$form,$where);
  $search->do_output=false;
  
  table_start("center","500",2);
  table_head_text(array("Search"),2);
  table_form_text("Fleet","fleet_name",$_POST["fleet_name"]);
  table_form_text("Planet","planet_name",$_POST["planet_name"]);
  table_form_text("System","system_name",$_POST["system_name"]);
  table_form_submit("Search",$setact);
  table_end();
  
  $where_addon=$search->print_searchform();
  echo("</form>\n");

  if (!$where_addon)
    $where_addon="where";
  else
    $where_addon.=" and";
  
  $where   =$where_addon." fi.uid=".$uid." and fi.fid=f.fid and f.prod_id=p.prod_id and s.id=fi.sid";

  $browser=new dbbrowser($tables,$order,$fields,$setact,$instance,$prikey,$GLOBALS["db"]);
  $browser->tabellenkopftext="Fleet Management";
  $browser->zeilenfarbe="text";
  $browser->zeilenfarbe2="text";
  $browser->fastpagefarbe="head";
  $browser->navigationfarbe="head";
  $browser->gruppenfarbe="head";
  $browser->tablehead_bgcolor="head";
  $browser->showgroup=1;
  $browser->fixed_grouper="fi.fid";
  $browser->fixed_groupshow="concat('<span style=\"color: lime\"><a href=\"".$_SERVER["PHP_SELF"]."?act=show_admiral&fid=',fi.fid,'\">',ifnull(concat(a.name,'(',if(a.value=0,0,floor((log10(value/1000)/log10(2))+1)),')'),'Noone'),'</a></span> ". // Admiral: Peter Wurst(1) oder Noone
			    "commanding fleet <span style=\"color: cyan\"><a href=\"".$_SERVER["PHP_SELF"]."?act=rename&fid=',fi.fid,'\">',fi.name,'</a></span><br><span style=\"color: yellow\">',sum(count),'</span> ". // Anzahl Schiffe
			    "ships at <span style=\"color: pink\">',ifnull(concat(pl.name,' (',s.name,')'),concat('System ',s.name)),'</span> ". // derzeitige Position
			    "targeting <span style=\"color: orange\">',ifnull(ifnull(concat(pl2.name,' (',s2.name,')'),concat('System ',s2.name)),'No target'),'</span>'". // ziel
			    ",' (<span style=\"color: magenta\">',elt(fi.mission+1,if(tsid=0,'Defend','Moving'),'Invade','Bomb','','Colonize'),'</span>)')"; // missionsausgabe
  $browser->gruppenkopf="<table><tr><td>{klappe} <input type='checkbox' name=\"fleet[{key}]\" value=\"Y\"></td><td>{gname}: <b><a href=\"{PHP_SELF}?act={setact}&{rname}={rwert}\">{gwert}</a></b> Shiptypes: <b>{ganzahl}</b></td></tr></table>";
  $browser->navigation="<div align=\"center\">
		[ <a href=\"{PHP_SELF}?act={setact}&page={last_page}\">&lt;&lt; back</a> ]
		&nbsp;&nbsp;&nbsp;&nbsp;
		 &nbsp;|&nbsp; <b>{max_entrys}</b> Entries on <b>{max_pages}</b> pages &nbsp;|&nbsp; Page: <b>{page}</b> &nbsp;|&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;
		[ <a href=\"{PHP_SELF}?act={setact}&page={next_page}\">forward &gt;&gt;</a> ]
		</div>";
  $browser->zusatz_head=array("Shipname","Shipcount","Reload");
  $browser->zusatz_body=array("{p.name}",
			      "<table><tr><td width=\"60\">{f.count}</td><td><input name=\"fleet_{fi.fid}[{f.prod_id}]\" value=\"0\" size=\"7\"></td></tr></table>",
			      "{f.reload}"
			     );
  $browser->extra_fields  =array("p.name",
				 "f.count",
				 "f.reload",
				 "f.prod_id"
	    );
  $browser->browser_footer="<span style=\"text-align: right\"><input type='submit' name='act' value='Join'><input type='submit' name='act' value='Transfer'><input type='submit' name='act' value='Create new fleet'></span>";
  $browser->group_output=1;
  echo("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">");
  $browser->browse($where);
  echo("</form>");
  $GLOBALS["ses"]->page_end();
}

function admiral_pool()
{
  global $uid;

  $sth=mysql_query("select * from admirals where uid=$uid and fid=0");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
    return 0;

  center_headline("Admiral Pool");

  table_start("center","500");
  table_head_text(array("Admirals"),"7");
  table_text(array("&nbsp;"),"","","7","text");
  table_text_open();
  table_text_design("&nbsp;","50","","","head");
  table_text_design("Name","200","","","head");
  table_text_design("Rank","75","","","head");
  table_text_design("Initiative","75","","","head");
  table_text_design("Agility","75","","","head");
  table_text_design("Sensor","75","","","head");
  table_text_design("Weaponskill","75","","","head");
  table_text_close();

  while ($admiral=mysql_fetch_array($sth))
  {
    if ($admiral["value"]<1000)
      $level=0;
    else
      $level=floor((log10($admiral["value"]/1000)/log10(2))+1);

    table_text_open();
    table_text_design("<img src=\"portraits/".$admiral["pic"]."\" border=\"0\" alt=\"".$admiral["name"]."\">",$admiral["name"],"200","center","","text");
    table_text_design($admiral["name"],"75","center","","text");
    table_text_design($level,"75","center","","text");

    foreach (array("initiative","agility","sensor","weaponskill") as $dummy => $value)
    {
      if (calculate_admiral_level($admiral["used_xp"])<$level)
	$upgrade="<a href=\"".$PHP_SELF."?act=upgrade_admiral_pool&id=".$admiral["id"]."&value=".$value."\"><img src=\"arts/plus.jpg\" border=\"0\" width=\"10\"></a>";
      else
	$upgrade="";
      table_text_design($upgrade.$admiral[$value],"75","center","","text");
    }
    table_text_close();
  }
  table_end();

}

function assign()
{
  global $PHP_SELF;
  global $uid;
  global $fid;
  global $aid;

  if (!$fleet=new fleet($fid))
  {
    show_error("Couldn't find fleet!");
    return 0;
  }

  if ($fleet->uid!=$uid)
  {
    show_error("Du hund!");
    return 0;
  }

  if ($aid_old=$fleet->get_admiral())
  {
    // alten admiral auf flotte 0 setzen
    set_admiral($aid_old,0);
  }

  if (is_admiral_owner($aid,$uid))
    set_admiral($aid,$fleet->fid);
  else
  {
    show_error("You Hund!");
    return 0;
  }
}

function unassign_admiral()
{
  global $uid;
  global $fid;

  $sth = mysql_query("select uid from fleet_info where fid=".$fid);
  
  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;
  
  list($fleet_uid) = mysql_fetch_row($sth);
  
  if ($uid != $fleet_uid)
  {
    show_error("nice try :P");
    return 0;
  }
  else
  {
    $sth = mysql_query("update admirals set fid=0 where fid=".$fid);
    
    if (!$sth)
      return 0;
  }
}

function upgrade_admiral()
{
  global $uid;
  global $id;
  global $value;

  if (!in_array($value,array("initiative","agility","sensor","weaponskill")))
  {
    show_error("Penis!");
    return 0;
  }

  if (!is_admiral_owner($id,$uid))
  {
    show_error("Upgrading foreign admirals?!?!?!?!?!?!?");
    return 0;
  }

  if (!admiral_has_pending_upgrade($id))
  {
    show_error("HACKER!");
    return 0;
  }

  if (!upgrade_admiral_value($id,$value))
  {
    show_error("Error upgrading admiral!");
    return 0;
  }
}

show_message("Creating, transfering and joining are disabled, you got to use the map to do so.<br/>Sorry, a big nasty bug forces us to do so :(");

switch ($act)
{
  case "unassign_admiral":
    unassign_admiral();
    show_menu();
    browse_fleets();
    admiral_pool();
  break;
  case "assign":
    assign();
    show_menu();
    browse_fleets();
    admiral_pool();
  break;
  case "rename":
    show_menu();
  	rename_fleet();
  break;
  case "Rename":
    proc_rename_fleet();
  show_menu();
  browse_fleets();
  admiral_pool();
  break;
  case "Create new fleet":
  	/*
    new_fleet();
    show_menu();
    browse_fleets();
    admiral_pool();
    */
  break;
  case "Join":
  	/*
    join_fleets();
    show_menu();
    browse_fleets();
    admiral_pool();
    */
  break;
  case "Transfer":
  	/*
    transfer();
    */
    break;
  case "transferab":
  	/*
    transferab();
    show_menu();
    browse_fleets();
    admiral_pool();
    */
  break;
  case "show_totalfleets":   
   show_menu();
   show_totalfleets();
   break;
  case "show_infantry":   
   show_menu();
   show_infantry();
   break;
  case "show_admiral":
    show_menu();
    show_admiral();
    break;
  case "upgrade_admiral":
    upgrade_admiral();
    show_admiral();
    break;
  case "upgrade_admiral_pool":
    show_menu();
    upgrade_admiral();
    browse_fleets();
    admiral_pool();
    break;
  default:
    show_menu();
    browse_fleets();
    admiral_pool();
}
// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
