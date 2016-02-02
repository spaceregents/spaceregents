<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/alliances.inc.php";

if ($not_ok)
  return 0;

// Bis hier immer so machen:)

function mails()
{
  global $uid;

  $sth=mysql_query("select * from mail as m,users as u where m.time>u.last_login and u.id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    echo("<a href=\"mail.php\"><img src=\"skins/mail.jpg\" border=\"0\" alt=\"You have new mail\"><br>You have new Mail</A>");
  }  
}

function del()
 {
  global $uid;
  global $id;

  $sth = mysql_query("delete from ticker where uid=$uid and tid=$id");
  show_message("Selected message has been deleted");
 }


function delete_all()
 {
  global $uid;

  $sth = mysql_query("delete from ticker where uid=$uid");
  show_message("All news have been deleted");
 }

function news()
{
 global $uid;
 global $PHP_SELF;

 $sth=mysql_query("select * from ticker where uid=$uid order by time DESC");

 if (!$sth)
  {
   show_message("Database error");
   return 0;
  }

 table_start("center","500");
 table_head_text(array("News"),"4");
 table_text(array("&nbsp;"),"","","4","text");
 table_text_open();
 table_text_design("&nbsp;","15","center","","head");
 table_text_design("Time","85","center","","head");
 table_text_design("Message","350","center","","head");
 table_text_design("&nbsp;","15","center","","head");
 table_text_close();

 while ($news = mysql_fetch_array($sth))

  {
   switch ($news["type"])
    {
   case "w" :
    $bild = "<img src=\"arts/wichtig.jpg\" width=\"15\" height=\"15\" alt=\"Anouncement\">";
    break;
   case "r" :
    $bild = "<img src=\"arts/research.jpg\" width=\"15\" height=\"15\" alt=\"Scientists Report\">";
    break;
   case "s" :
    $bild = "<img src=\"arts/spy.jpg\" width=\"15\" height=\"15\" alt=\"Covert Operations Report\">";
    break;
   case "m" :
    $bild = "<img src=\"arts/mail.jpg\" width=\"15\" height=\"15\" alt=\"Mailbox\">";
    break;
   case "a" :
    $bild = "<img src=\"arts/underattack.jpg\" width=\"15\" height=\"15\" alt=\"Military Report\">";
    break;
   case "" :
    $bild = "&nbsp;";
    break;
  }
   //$zeit = substr($news["time"],6,2)."-".substr($news["time"],4,2)." ".substr($news["time"],8,2).":".substr($news["time"],10,2);
   $zeit=$news["time"];
   $pos1 = strpos($news["text"],"*");
    if ($pos1 === false)
      table_text(array($bild,"<span class=\"textsmall\">".$zeit."</span>",strip_tags($news["text"]),"<a href=\"".$PHP_SELF."?act=del&id=".$news["tid"]."\">delete</a>"),"","","","text");
  else
   {
    $pos2 = strrpos($news["text"],"*");
    $link = substr($news["text"],$pos1+2,$pos2-2);
    $text = strrchr($news["text"],"*");
    $text = substr_replace($text,"",0,1);
      table_text(array($bild,"<span class=\"textsmall\">".$zeit."</span>","<a href=\"".$link."\">".$text."</a>","<a href=\"".$PHP_SELF."?act=del&id=".$news["tid"]."\">delete</a>"),"","","","text");
   }
  }
table_text(array("<a href=\"".$PHP_SELF."?act=delete_all\"<strong>Delete all news</strong></a>"),"center","","4","head");
table_end();
echo("<br><br>\n");

}

function planets()
{
  global $uid;

  table_start("center","500");
  table_head_text(array("Planets"),"5");
  table_text(array("&nbsp;"),"","","5","text");
  table_text(array("Planet","Planetar","Orbital","Fleet","Infantry"),"","","","head");

  $sth=mysql_query("select * from planets where uid='$uid' order by name ASC");

  while ($planet=mysql_fetch_array($sth))
  {
    $array="";

    // name
    $array["planet"] = "<a href=\"production.php?act=Production&pid=".$planet["id"]."\">";
    if ($planet["name"]=="")
      $array["planet"] .= "&lt;Unnamed&gt;";
    else
      $array["planet"] .= $planet["name"];      
    $array["planet"] .= "</a>";
    
    // planetar
    unset($p_prod);
    unset($p_title);
    $sth1=mysql_query("select name, time from p_production as pp,production as p where pp.planet_id='".$planet["id"]."' and p.prod_id=pp.prod_id order by pp.pos DESC");
    while ($planetar=mysql_fetch_array($sth1))
    {
      $p_title  .= $planetar["name"]." [".$planetar["time"]."]\n";
      $p_prod  = $planetar["name"]." [".$planetar["time"]."]"; 
    }

    $array["planetar"] = "<a href=\"production.php?act=build&pid=".$planet["id"]."\" title=\"".$p_title."\">";
    if (!isset($p_prod))
      $array["planetar"] .= "IDLE";
    else
      $array["planetar"] .= $p_prod;    
    $array["planetar"] .= "</a>";
      
    // orbital  
    unset($o_prod);
    unset($o_title);
    $sth1=mysql_query("select name, time from o_production as op,production as p where op.planet_id='".$planet["id"]."' and p.prod_id=op.prod_id order by op.pos DESC");
    while ($orbital=mysql_fetch_array($sth1))
    {
      $o_title  .= $orbital["name"]." [".$orbital["time"]."]\n";
      $o_prod  = $orbital["name"]." [".$orbital["time"]."]"; 
    }
    
    $array["orbital"] = "<a href=\"production.php?act=build&pid=".$planet["id"]."\" title=\"".$o_title."\">";
    
    if (!isset($o_prod))
      $array["orbital"] .= "IDLE";
    else
      $array["orbital"] .= $o_prod;          
    $array["orbital"] .= "</a>";
    
    // fleet
    unset($fleet_prod);
    unset($fleet_title);
    $sth1=mysql_query("select * from s_production as sp,production as p where sp.planet_id='".$planet["id"]."' and p.prod_id=sp.prod_id order by sp.time DESC");
    while ($fleet=mysql_fetch_array($sth1))
    {
      $fleet_title .= $fleet["count"]." ".$fleet["name"]."[".$fleet["time"]."]\n";
      $fleet_prod  = $fleet["count"]." ".$fleet["name"]." [".$fleet["time"]."]"; 
    }
    $array["fleet"] = "<a href=\"production.php?act=fleet&pid=".$planet["id"]."\" title=\"".$fleet_title."\">";
    if (!$fleet_prod)
      $array["fleet"] .= "IDLE";
    else
      $array["fleet"] .= $fleet_prod;
    $array["fleet"] .= "</a>";
    
    // infantry
    unset($inf_prod);
    unset($inf_title);
    $sth1=mysql_query("select * from i_production as ip,production as p where ip.planet_id='".$planet["id"]."' and p.prod_id=ip.prod_id order by ip.time DESC");
    while ($inf=mysql_fetch_array($sth1))
    {
      $inf_title .= $inf["count"]." ".$inf["name"]."[".$inf["time"]."]\n";
      $inf_prod  = $inf["count"]." ".$inf["name"]." [".$inf["time"]."]"; 
    }
    $array["inf"] = "<a href=\"production.php?act=inf&pid=".$planet["id"]."\" title=\"".$inf_title."\">";
    if (!$inf_prod)
      $array["inf"] .= "IDLE";
    else
      $array["inf"] .= $inf_prod;
    $array["inf"] .= "</a>";

    table_text($array,"","","","text");    }
  table_end();
}


function fleet()
{
  global $uid;

  $sth=mysql_query("select alliance from users where id=$uid");

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select count(f.fid),p.name from fleet_info as f,planets as p,users as u where p.uid=$uid  and f.tsid=p.sid and f.uid!=2 and u.alliance!=".$alliance["alliance"]."");

  $efleets=mysql_fetch_row($sth);

  if ($efleets[0]!=0)
    {
      if ($efleets[1]=="")
      $efleets[1]="Unnamed";
      echo($efleets[0]." enemy fleet(s) are on the way to your planet ".$efleets[1]);
    }
}

function fleets()
{
  global $uid;

    echo("<br><br>\n");
  table_start("center","500");
  table_head_text(array("Fleets"),"4");
    table_text(array("&nbsp;"),"","","4","text");
  table_text(array("Europe Class","Zeus Class","Olymp Class","Fleet Count"),"","","","head");
  table_text(array("&nbsp;".get_fcount_by_type($uid,"L")."","&nbsp;".get_fcount_by_type($uid,"M")."","&nbsp;".get_fcount_by_type($uid,"H")."","&nbsp;".get_fcount($uid).""),"","","","text");
  table_end();echo("<br><br>");
}

function production()
{
  global $uid;

  $sth=mysql_query("select * from income_stats where uid=".$uid);

  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("ERR::GET");
    return false;
  }

  $stats=mysql_fetch_assoc($sth);

  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
  {
    if ($stats["tax_".$res]>0)
      $tax_string[$res] = "<span class=\"red\">- ".$stats["tax_".$res]."</span>";
    else
      $tax_string[$res] = "&nbsp;";

    if ($stats["earned_".$res]>0)
      $earned_string[$res] = "<span class=\"lime\">+ ".$stats["earned_".$res]."</span>";
    else
      $earned_string[$res] = "&nbsp;";
    
    if ($stats["upkeep_".$res]>0)
      $upkeep_string[$res] = "<span class=\"red\">- ".$stats["upkeep_".$res]."</span>";
    else
      $upkeep_string[$res] = "&nbsp;";
  }

  table_start("center","500");
  table_head_text(array("Last incomestats"),"8");
  table_text(array("&nbsp;"),"","","8","text");

  table_text_open("head");
  table_text_design("&nbsp;","100","","","head");
  table_text_design("<img src='arts/metal.gif' width='13' height='20' alt='Metal'>","50","center","","head");
  table_text_design("<img src='arts/energy.gif' width='10' height='20' alt='Energy'>","50","center","","head");
  table_text_design("<img src='arts/mopgas.gif' width='13' height='20' alt='Mopgas'>","50","center","","head");
  table_text_design("<img src='arts/erkunum.gif' width='15' height='20' alt='Erkunum'>","50","center","","head");
  table_text_design("<img src='arts/gortium.gif' width='13' height='20' alt='Gortium'>","50","center","","head");
  table_text_design("<img src='arts/susebloom.gif' width='18' height='20' alt='Susebloom'>","50","center","","head");
  table_text_design("&nbsp;","100","","","head");
  table_text_close();
  table_text_open("text");
  table_text_design("Income","100","","","text");
  table_text_design($stats["metal"],"","center","","text");
  table_text_design($stats["energy"],"","center","","text");
  table_text_design($stats["mopgas"],"","center","","text");
  table_text_design($stats["erkunum"],"","center","","text");
  table_text_design($stats["gortium"],"","center","","text");
  table_text_design($stats["susebloom"],"","center","","text");
  table_text_design("&nbsp;","100","","","text");
  table_text_close();
  table_text_open("text");
  table_text_design("Allowance","100","","","text");
  table_text_design($earned_string["metal"],"","center","","text");
  table_text_design($earned_string["energy"],"","center","","text");
  table_text_design($earned_string["mopgas"],"","center","","text");
  table_text_design($earned_string["erkunum"],"","center","","text");
  table_text_design($earned_string["gortium"],"","center","","text");
  table_text_design($earned_string["susebloom"],"","center","","text");
  table_text_design("&nbsp;","100","","","text");
  table_text_close();
  table_text_open("text");
  table_text_design("Taxes","100","","","text");
  table_text_design($tax_string["metal"],"","center","","text");
  table_text_design($tax_string["energy"],"","center","","text");
  table_text_design($tax_string["mopgas"],"","center","","text");
  table_text_design($tax_string["erkunum"],"","center","","text");
  table_text_design($tax_string["gortium"],"","center","","text");
  table_text_design($tax_string["susebloom"],"","center","","text");
  table_text_design("&nbsp;","100","","","text");
  table_text_close();
  table_text_open("text");
  table_text_design("Upkeep","100","","","text");
  table_text_design($upkeep_string["metal"],"","center","","text");
  table_text_design($upkeep_string["energy"],"","center","","text");
  table_text_design($upkeep_string["mopgas"],"","center","","text");
  table_text_design($upkeep_string["erkunum"],"","center","","text");
  table_text_design($upkeep_string["gortium"],"","center","","text");
  table_text_design($upkeep_string["susebloom"],"","center","","text");
  table_text_design("&nbsp;","100","","","text");
  table_text_close();
  table_text(array("&nbsp;"),"","","8","text");
  table_text_open("text");
  table_text_design("Total","100","","","head");
  table_text_design($stats["metal"]-$stats["trade_metal"]-$stats["tax_metal"]+$stats["earned_metal"]-$stats["upkeep_metal"],"","center","","head");
  table_text_design($stats["energy"]-$stats["trade_energy"]-$stats["tax_energy"]+$stats["earned_energy"]-$stats["upkeep_energy"],"","center","","head");
  table_text_design($stats["mopgas"]-$stats["trade_mopgas"]-$stats["tax_mopgas"]+$stats["earned_mopgas"]-$stats["upkeep_mopgas"],"","center","","head");
  table_text_design($stats["erkunum"]-$stats["trade_erkunum"]-$stats["tax_erkunum"]+$stats["earned_erkunum"]-$stats["upkeep_erkunum"],"","center","","head");
  table_text_design($stats["gortium"]-$stats["trade_gortium"]-$stats["tax_gortium"]+$stats["earned_gortium"]-$stats["upkeep_gortium"],"","center","","head");
  table_text_design($stats["susebloom"]-$stats["trade_susebloom"]-$stats["tax_susebloom"]+$stats["earned_susebloom"]-$stats["upkeep_susebloom"],"","center","","head");
  table_text_design("&nbsp;","100","","","head");
  table_text_close();
  table_end();
}

function show_research()
{
  global $uid;

  $sth=mysql_query("select t.name,t.com_time,r.time from tech t,researching r where t.t_id=r.t_id and r.uid=".$uid);

  if (!$sth)
  {
    show_error("ERR::GET RESEARCH");
    return false;
  }


  table_start("center","500");
  table_head_text(array("Research"),"8");
  table_text(array("&nbsp;"),"","","8","text");
  table_text(array("Tech","Researched","Time to complete"),"","","","head");
  if (mysql_num_rows($sth)==0)
  {
    table_text(array("Nothing","-","-"),"","","","text");
  }
  else
  {
    $data=mysql_fetch_assoc($sth);
    table_text(array($data["name"],round(($data["com_time"]-$data["time"])/$data["com_time"]*100,1)."% (".($data["com_time"]-$data["time"])."/".$data["com_time"].")",($data["time"])),"","","","text");
  }
  table_text_open("head");
  table_text_close();
  table_end();
  echo("<br><br>");
}

function show_battlereports()
{
  table_start("center","500");
  table_head_text(array("Battlereports"),"1");
  table_text(array("<a href=\"battlereport.php?act=show_own\">Battlereports</a>"),"","","","text");
  table_text_open("head");
  table_text_close();
  table_end();
  echo("<br><br>");
}

$sth=mysql_query("select * from users where id=$uid");

if (!$sth)
{
  show_error("Datenbankfehler!");
  return 0;
}

$data=mysql_fetch_assoc($sth);
center_headline($data["name"]." of ".$data["imperium"]);

//mails();
//fleet();
switch ($act)
 {
  case del:
   del();
   news();
   show_battlereports();
   show_research();
   planets();
   fleets();
   production();
  break;
  case delete_all:
   delete_all();
   news();
   show_battlereports();
   show_research();
   planets();
   fleets();
   production();
  break;
  default:
    news();
    show_battlereports();
    show_research();
    planets();
    fleets();
    production();
  break;
 }

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
