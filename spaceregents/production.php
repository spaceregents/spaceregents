<?php
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/population.inc.php";

if ($not_ok)
  return 0;

  // Bis hier immer so machen:)
  // **************************************************************************** FLEET ****************************************

/** 
 * macht fieses html mit bildchen aus nem ressourcen array 
 * 
 * @param $what 
 * @return 
 */
function ressources_html($what)
{
  $res=array();

  if ($what["metal"]!=0)
    $res[]="<img src=\"arts/metal.jpg\" title=\"Metal\" alt=\"Metal\" border=\"0\">".$what["metal"];
  if ($what["energy"]!=0)
    $res[]="<img src=\"arts/energy.jpg\" title=\"Energy\" alt=\"Energy\" border=\"0\">".$what["energy"];
  if ($what["mopgas"]!=0)
    $res[]="<img src=\"arts/mopgas.jpg\" title=\"Mopgas\" alt=\"Mopgas\" border=\"0\">".$what["mopgas"];
  if ($what["erkunum"]!=0)
    $res[]="<img src=\"arts/erkunum.jpg\" title=\"erkunum\" alt=\"erkunum\" border=\"0\">".$what["erkunum"];
  if ($what["gortium"]!=0)
    $res[]="<img src=\"arts/gortium.jpg\" title=\"Gortium\" alt=\"Gortium\" border=\"0\">".$what["gortium"];
  if ($what["susebloom"]!=0)
    $res[]="<img src=\"arts/susebloom.jpg\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\">".$what["susebloom"];
  if ($what["colonists"]!=0)
    $res[]="<img src=\"arts/colonists.png\" title=\"Colonists\" alt=\"Colonists\" border=\"0\">".$what["colonists"];

  return implode($res," ");
}

function print_building_info($prod_id)
{
  $sth=mysql_query("select initiative,agility,hull,weaponpower,shield,ecm,target1,sensor,weaponskill,armor,num_attacks from shipvalues s where prod_id=".$prod_id);

  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("ERR::GET BATTLEVALUES");
    return false;
  }

  $battle_values=mysql_fetch_assoc($sth);

  $sth=mysql_query("select value from covertopsupgrades where prod_id=".$prod_id);

  if (!$sth)
  {
    show_error("ERR::COVERT OPS");
    return false;
  }
  
  if (mysql_num_rows($sth)>0)
    $covertops=mysql_fetch_assoc($sth);
  else
    $covertops=array();

  $sth=mysql_query("select factor,ressource from prod_upgrade where prod_id=".$prod_id);

  if (!$sth)
  {
    show_error("ERR::GET PROD_UPGRADE");
    return false;
  }
  
  if (mysql_num_rows($sth)>0)
    $prod_upgrade=mysql_fetch_assoc($sth);
  else
    $prod_upgrade=array();

  $sth=mysql_query("select p.name,p.typ,p.special,p.p_depend,p.metal,p.energy,p.mopgas,p.erkunum,p.gortium,p.susebloom,p.tech,ifnull(t.name,'Nothing') as rname from production p left join tech t on p.tech=t.t_id where p.prod_id=".$prod_id);

  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("ERR::GET PRODUCTION");
  }

  $production=mysql_fetch_assoc($sth);

  $sth=mysql_query("select radius from scanradius where prod_id=".$prod_id);

  if (!$sth)
  {
    show_error("ERR::GET SCAN");
    return false;
  }

  if (mysql_num_rows($sth)>0)
    $scanradius=mysql_fetch_assoc($sth);
  else
    $scanradius=array();

  $sth=mysql_query("select tonnage,reload from jumpgatevalues where prod_id=".$prod_id);

  if (!$sth)
  {
    show_error("ERR::GET JUMP");
    return false;
  }

  if (mysql_num_rows($sth)>0)
    $jumpgatevalue=mysql_fetch_assoc($sth);
  else
    $jumpgatevalue=array();

  $sth=mysql_query("select name as depend_name from production where p_depend='".$prod_id."'");

  if (!$sth)
  {
    show_error("ERR::GET DEPEND STUFF");
    return false;
  }
  
  $depends=array();
  while (list($depend)=mysql_fetch_row($sth))
    $depends[]=$depend;

  $depends["required_for"]=implode($depends,"<br>");
      
  $info=array_merge($production,$battle_values,$jumpgatevalue,$scanradius,$prod_upgrade,$depends);

  table_start("center","500");
  table_head_text(array("Constructioninfo for ".$info["name"]),"6");
  table_text_open("head");
  table_text_design("&nbsp;","500","","2","head");
  table_text_close();
  
  if ($info["p_depend"]>0)
    $info["p_depend"]=get_name_by_prod_id($info["p_depend"]);
  else
    $info["p_depend"]="Nothing";

  switch($info["target1"])
  {
    case "L":
      $info["target1"]="Europe Class";
    break;
    case "M":
      $info["target1"]="Zeus Class";
    break;
    case "H":
      $info["target1"]="Olymp Class";
    break;
  }

  switch($info["special"])
  {
    case "F":
      $info["special"]="Orbital Refueling Station";
    break;
    case "G":
      $info["special"]="Increases population growth";
    break;
    case "L":
      $info["special"]="Increases population limit";
    break;
    case "P":
      $info["special"]="Increases population limit and growth";
    break;
    case "S":
      $info["special"]="Can only be built once per system";
    break;
    case "U":
      $info["special"]="Can only be built once per imperium";
    break;
    default:
    $info["special"]="Nothing";
  }


  foreach (array("name"=>"Name","metal"=>"Metal","energy"=>"Energy","mopgas"=>"Mopgas","erkunum"=>"Erkunum","gortium"=>"Gortium","susebloom"=>"Susebloom","rname"=>"Needs tech","p_depend"=>"Needs building","initiative"=>"Initiative","agility"=>"Agility","hull"=>"Hull","weaponpower"=>"Weaponpower","shield"=>"Shield","ecm"=>"ECM","sensor"=>"Sensor","weaponskill"=>"Weaponskill","target1"=>"Attacks","special"=>"Special abilities","armor"=>"Armor","num_attacks"=>"Attacks","required_for"=>"Required for") as $key=>$show)
  {
    table_text_open("text");
    table_text_design($show,"250","","","text");
    table_text_design($info[$key],"250","","","text");
    table_text_close();
  }
  table_end();

}

function print_ship_info_prod($prod_id)
{
  print_ship_info($prod_id);
}

function fleet($sth)
{
  global $uid;
  global $PHP_SELF;
  global $pid;

  if (mysql_num_rows($sth)>0)
  {
    echo("<form action=\"".$PHP_SELF."\" method=post>");
    table_head_text(array("Ships currently in production"),"8");
    table_text(array("&nbsp;","Shipname","Count","Ressources per week","Priority","ETC","&nbsp;","Count"),"center","",1,"head");

    while ($fleet=mysql_fetch_assoc($sth))
    {
      table_text_open("text","center");
      table_text_design("<a href='".$fleet["manual"]."' target=\"_blank\"><img src='arts/".$fleet["pic"]."' border='0' title='".$fleet["description"]."' align='center'></a><br><a href=\"".$PHP_SELF."?act=print_ship_info&prod_id=".$fleet["prod_id"]."\">Info</a>","80","","","text");
      table_text_design($fleet["name"],"300","","","text");
      table_text_design($fleet["count"],"100","","","text");
      table_text_design(ressources_html(get_ressources_per_week($fleet)),"100","","","text");
      table_text_design("ETC :".($fleet["com_time"]-$fleet["time"]),"","","","text");
      
      $higher=false;
      $lower=false;

      switch ($fleet["priority"])
      {
        case 2:
          $text="<span style=\"color: red\">High</span>";
          $lower=true;
          break;
        case 1:
          $text="<span style=\"color: white\">Normal</span>";
          $lower=true;
          $higher=true;
          break;
        case 0:
          $text="<span style=\"color: green\">Low</span>";
          $higher=true;
          break;
      }
      
      $base_prio="<a href=\"".$_SERVER["PHP_SELF"]."?act=fprio&prod_id=".$fleet["prod_id"]."&pid=".$fleet["planet_id"]."&time=".$fleet["time"]."&change=%d\">%s</a>";
      $priority="";
      if ($lower)
        $priority.=sprintf($base_prio,-1,"-")."<br>";
      $priority.=$text;
      if ($higher)
        $priority.="<br>".sprintf($base_prio,1,"+");
      
      table_text_design($priority,"","center","","text");
      table_text_design("<input type=\"checkbox\" name=\"prod_id[".$fleet["prod_id"]."]\" value=\"Y\">","","","","text");
      table_text_design("<input type=\"hidden\" name=\"time[".$fleet["prod_id"]."]\" value=\"".$fleet["time"]."\"><input type=\"text\" name=\"count[".$fleet["prod_id"]."]\" size=\"3\" value=\"".$fleet["count"]."\">","","","","text");
      table_text_close();
    }
    
    table_text(array("<input type=\"hidden\" name=\"pid\" value=\"".$pid."\"><input type=\"hidden\" name=\"act\" value=\"fscrap\"><input type=\"submit\" value=\"Scrap\"></form>"),"right","","8");
  }
  else
    table_text(array("Your Fleet Production is IDLE"));

  table_end();
  echo("<br>\n");

  $sth=mysql_query("select ifnull(sum(p.tonnage),0) from production_slots p,constructions c where c.pid=".$pid." and c.prod_id=p.prod_id and p.types='L,M,H'");

  if (!$sth)
  {
    show_error("ERR::GET PRODUCTION SLOTS");
    return false;
  }

  list($avail_tonnage)=mysql_fetch_row($sth);

  $sth=mysql_query("select ifnull(sum(f.count*s.tonnage),0) from s_production f,shipvalues s where f.planet_id=".$pid." and s.prod_id=f.prod_id");
  
  if (!$sth)
  {
    show_error("ERR::GET USED PRODUCTION SLOTS");
    return false;
  }

  list($used_tonnage)=mysql_fetch_row($sth);
  
  table_start("center","500");
  table_head_text(array("Production slots"),"3");
  table_text_open();
  table_text_design("&nbsp;","","center","3","text");
  table_text_close();
  table_text(array("Used Tonnage","Maximum Tonnage","Remaining Tonnage"),"center","",1,"head");
  table_text(array($used_tonnage,$avail_tonnage,($avail_tonnage-$used_tonnage)),"center","",1,"text");
  table_end();
  echo("<br><br>");

  table_start("center","500");
  table_head_text(array("Shipconstruction"),"5");
  table_text_open();
  table_text_design("&nbsp;","","center","5","text");
  table_text_close();

  table_text(array("Shipname","Ressources","Tonnage","Time","&nbsp;"),"center","",1,"head");

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  $sth=mysql_query("select p.*,s.tonnage from production as p,shipvalues s,research as r where (p.typ='L' or p.typ='M' or p.typ='H') and r.uid='$uid' and p.tech=r.t_id and s.prod_id=p.prod_id");
  while ($fleet=mysql_fetch_array($sth))
  {
    $darf_bauen=false;

    if ($fleet["p_depend"]==NULL)
    {
      $darf_bauen=true;
    }
    else
    {
      $darf_bauen=construction_exists($fleet["p_depend"],$pid);
    }

    if ($darf_bauen)
    {
      $ress="";

      if ($fleet["metal"]!=0)
  $ress=$ress."<img src=\"arts/metal.jpg\" title=\"Metal\" alt=\"Metal\" border=\"0\">".$fleet["metal"]." ";
      if ($fleet["energy"]!=0)
  $ress=$ress."<img src=\"arts/energy.jpg\" title=\"Energy\" alt=\"Energy\" border=\"0\">".$fleet["energy"]." ";
      if ($fleet["mopgas"]!=0)
  $ress=$ress."<img src=\"arts/mopgas.jpg\" title=\"Mopgas\" alt=\"Mopgas\" border=\"0\">".$fleet["mopgas"]." ";
      if ($fleet["erkunum"]!=0)
  $ress=$ress."<img src=\"arts/erkunum.jpg\" title=\"erkunum\" alt=\"erkunum\" border=\"0\">".$fleet["erkunum"]." ";
      if ($fleet["gortium"]!=0)
  $ress=$ress."<img src=\"arts/gortium.jpg\" title=\"Gortium\" alt=\"Gortium\" border=\"0\">".$fleet["gortium"]." ";
      if ($fleet["susebloom"]!=0)
  $ress=$ress."<img src=\"arts/susebloom.jpg\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\">".$fleet["susebloom"]." ";
      if ($fleet["colonists"]!=0)
  $ress=$ress."<img src=\"arts/colonists.png\" title=\"Colonists\" alt=\"Colonists\" border=\"0\">".$fleet["colonists"]." ";

      table_text_open("text");
      table_text_design("<a href='".$fleet["manual"]."' target=\"_blank\">".$fleet["name"]."</a><br><a href=\"".$PHP_SELF."?act=print_ship_info&prod_id=".$fleet["prod_id"]."\">Info</a>","250","","","text");
      table_text_design($ress,"125","","","text");
      table_text_design($fleet["tonnage"],"50","","","text");
      table_text_design("ETA: ".$fleet["com_time"],"50","","","text");
      table_text_design("<input size='5' maxlength='6' name=\"fleet[".$fleet["prod_id"]."]\"><input type=image src='skins/".$skin."_production.jpg' width='25' height='25' alt='begin construction' border='0'>","80","","","text");
      table_text_close();
    }
  }
  echo("<input type=hidden name=\"pid\" value=\"$pid\">");
  echo("<input type=hidden name=\"act\" value=\"fproduction\">");
  echo("</form>");
  return 0;

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  table_head_text(array("Pic","Name","Time","Ressources","Count"));
  $sth=mysql_query("select p.* from production as p,research as r where (p.typ='L' or p.typ='M' or p.typ='H') and r.uid='$uid' and p.tech=r.t_id");
  while ($fleet=mysql_fetch_array($sth))
  {
    $ress="";

    if ($fleet["metal"]!=0)
    {
      $ress=$ress."<img src=\"arts/metal.jpg\" title=\"Metal\" alt=\"Metal\" border=\"0\">".$fleet["metal"]." ";
    }
    if ($fleet["energy"]!=0)
    {
      $ress=$ress."<img src=\"arts/energy.jpg\" title=\"Energy\" alt=\"Energy\" border=\"0\">".$fleet["energy"]." ";
    }
    if ($fleet["mopgas"]!=0)
    {
      $ress=$ress."<img src=\"arts/mopgas.jpg\" title=\"Mopgas\" alt=\"Mopgas\" border=\"0\">".$fleet["mopgas"]." ";
    }
    if ($fleet["erkunum"]!=0)
    {
      $ress=$ress."<img src=\"arts/erkunum.jpg\" title=\"erkunum\" alt=\"erkunum\" border=\"0\">".$fleet["erkunum"]." ";
    }
    if ($fleet["gortium"]!=0)
    {
      $ress=$ress."<img src=\"arts/gortium.jpg\" title=\"Gortium\" alt=\"Gortium\" border=\"0\">".$fleet["gortium"]." ";
    }
    if ($fleet["susebloom"]!=0)
    {
      $ress=$ress."<img src=\"arts/susebloom.jpg\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\">".$fleet["susebloom"]." ";
    }
    if ($fleet["colonists"]!=0)
      $ress=$ress."<img src=\"arts/colonists.png\" title=\"Colonists\" alt=\"Colonists\" border=\"0\">".$fleet["colonists"]." ";

    table_form_text(array("<img src=\"arts/".$fleet["pic"]."\" border=\"0\" width=\"25\" height=\"25\" alt=\"".$fleet["description"]."\">",$fleet["name"],$fleet["com_time"],$ress),"fleet[".$fleet["prod_id"]."]");
  }
  echo("<input type=hidden name=\"pid\" value=\"$pid\">");
  table_form_submit("Start","fproduction","4");
  echo("</form>");
}

// ************************************************************ INFANTERY ***********************************************

function infantery($sth)
{
  global $uid;
  global $PHP_SELF;
  global $pid;
  global $skin;

  echo("<br><br>");

  table_start("center","500");

  while ($infantery=mysql_fetch_array($sth))
  {
    if (!isset($dummy))
    {
      table_head_text(array("Infantry currently in production"),"4");

      table_text_open("head");
      table_text_design("&nbsp;","80","","","head");
      table_text_design("&nbsp;","420","","3","head");
      table_text_close();
    }

    table_text_open("text","center");
    table_text_design("<a href='".$infantery["manual"]."' target=\"_blank\"><img src='arts/".$infantery["pic"]."' border='0' alt='".$infantery["description"]."' align='center'></a>","80","","","text");
    table_text_design($infantery["name"],"320","","","text");
    table_text_design($infantery["count"],"100","","","text");
    table_text_design("ETC: ".$infantery["time"],"","","","text");
    table_text_close();

    $dummy="";
  }
  if (!isset($dummy))
    table_text(array("Your Infantry Production is IDLE"),"center","",4);


  table_end();

  echo("<br><br>");

  table_start("center","500");
  table_head_text(array("Infantry production"),"4");

  table_text_open("head");
  table_text_design("&nbsp;","80","","","head");
  table_text_design("&nbsp;","420","","3","head");
  table_text_close();

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  $sth=mysql_query("select p.* from production as p,research as r where (p.typ='I' or p.typ='T') and r.uid='$uid' and p.tech=r.t_id");
  while ($infantery=mysql_fetch_array($sth))
  {
    $darf_bauen=false;

    if ($infantery["p_depend"]==NULL)
      $darf_bauen=true;
    else
    {
      $darf_bauen=construction_exists($infantery["p_depend"],$pid);
    }


    if ($darf_bauen)
    {

      $ress="";

      if ($infantery["metal"]!=0)
      {
  $ress=$ress."<img src=\"arts/metal.jpg\" title=\"Metal\" alt=\"Metal\" border=\"0\">".$infantery["metal"]." ";
      }
      if ($infantery["energy"]!=0)
      {
  $ress=$ress."<img src=\"arts/energy.jpg\" title=\"Energy\" alt=\"Energy\" border=\"0\">".$infantery["energy"]." ";
      }
      if ($infantery["mopgas"]!=0)
      {
  $ress=$ress."<img src=\"arts/mopgas.jpg\" title=\"Mopgas\" alt=\"Mopgas\" border=\"0\">".$infantery["mopgas"]." ";
      }
      if ($infantery["erkunum"]!=0)
      {
  $ress=$ress."<img src=\"arts/erkunum.jpg\" title=\"erkunum\" alt=\"erkunum\" border=\"0\">".$infantery["erkunum"]." ";
      }
      if ($infantery["gortium"]!=0)
      {
  $ress=$ress."<img src=\"arts/gortium.jpg\" title=\"Gortium\" alt=\"Gortium\" border=\"0\">".$infantery["gortium"]." ";
      }
      if ($infantery["susebloom"]!=0)
      {
  $ress=$ress."<img src=\"arts/susebloom.jpg\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\">".$infantery["susebloom"]." ";
      }
      table_text_open("text","center");
      table_text_design("<a href='".$infantery["manual"]."' target=\"_blank\"><img src='arts/".$infantery["pic"]."' alt='".$infantery["description"]."' border='0'></a>","80","","","text","2");
      table_text_design($infantery["name"],"226","","","text","2");
      table_text_design($ress,"77","","","text","2");
      table_text_design("ETA: ".$infantery["com_time"],"45","","","text");
      table_text_close();
      table_text_open("text","center");
      table_text_design("<input size='5' maxlength='6' name=\"infantery[".$infantery["prod_id"]."]\"><input type=image src='skins/metal_blue_production.jpg' width='25' height='25' alt='begin construction' border='0'>","45","","","text");
    }
  }
  echo("<input type=hidden name=\"pid\" value=\"$pid\">");
  echo("<input type=hidden name=\"act\" value=\"iproduction\">");
  echo("</form>");

}
// ************************************************************ PLANETAR **********************************************
function planetar()
{
  global $uid;
  global $PHP_SELF;
  global $pid;
  global $skin;

  table_text_open();
  table_text_design("&nbsp;","","center","5","text");
  table_text_close();
  table_text_open();
  table_text_design("<h3>Planetary Buildings</h3>","","center","5","head");
  table_text_close();


  $sth1=mysql_query("select p.* from production as p,research as r left join constructions as b on p.prod_id=b.prod_id and b.pid=".$pid." and b.type=0 left join p_production as pp on pp.prod_id=p.prod_id and pp.planet_id=$pid where p.typ='P' and r.uid=$uid and p.tech=r.t_id and b.prod_id is NULL and pp.prod_id is NULL");
  if (mysql_num_rows($sth1)==0)
  {
    table_text_open();
    table_text_design("You have built everything you can build","","center","5","text");
    table_text_close();
  }
  else
  {
    while ($planetar=mysql_fetch_array($sth1))
    {
      // Runelord: gucken ob das Gebäude überhaupt etwas auf dem planeten bringt (wie metal-mine auf ice-planeten)
      $makes_sense = get_buildings_sense($planetar["prod_id"], $pid);

      $darf_bauen=false;

      if ($makes_sense)
      {
        if ($planetar["p_depend"]==NULL)
          $darf_bauen=true;
        else
        {
          $darf_bauen=construction_exists($planetar["p_depend"],$pid);
        }
      }


    if ($darf_bauen)
    {

  $ress="";

  if ($planetar["metal"]!=0)
  {
    $ress=$ress."<img src=\"arts/metal.jpg\" title=\"Metal\" alt=\"Metal\" border=\"0\">".$planetar["metal"]." ";
  }
  if ($planetar["energy"]!=0)
  {
    $ress=$ress."<img src=\"arts/energy.jpg\" title=\"Energy\" alt=\"Energy\" border=\"0\">".$planetar["energy"]." ";
  }
  if ($planetar["mopgas"]!=0)
  {
    $ress=$ress."<img src=\"arts/mopgas.jpg\" title=\"Mopgas\" alt=\"Mopgas\" border=\"0\">".$planetar["mopgas"]." ";
  }
  if ($planetar["erkunum"]!=0)
  {
    $ress=$ress."<img src=\"arts/erkunum.jpg\" title=\"erkunum\" alt=\"erkunum\" border=\"0\">".$planetar["erkunum"]." ";
  }
  if ($planetar["gortium"]!=0)
  {
    $ress=$ress."<img src=\"arts/gortium.jpg\" title=\"Gortium\" alt=\"Gortium\" border=\"0\">".$planetar["gortium"]." ";
  }
  if ($planetar["susebloom"]!=0)
  {
    $ress=$ress."<img src=\"arts/susebloom.jpg\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\">".$planetar["susebloom"]." ";
  }

  table_text_open("text","center");
  table_text_design("<a href='".$_SERVER["PHP_SELF"]."?act=print_building_info&prod_id=".$planetar["prod_id"]."'><img src='arts/".$planetar["pic"]."' alt='".$planetar["description"]."' border='0' width=\"50px\" height=\"50px\" /></a>","50px","","","text","2");
  table_text_design($planetar["name"],"350","","","text","2");
  table_text_design($ress,"105","","","text","2");

  table_text_design("ETC: ".$planetar["com_time"],"40","","","text");
  table_text_close();
  table_text_open("text","center");
  table_text_design("<a href=\"".$PHP_SELF."?act=pproduction&pid=".$pid."&prod_id=".$planetar["prod_id"]."\"><img src='skins/".$skin."_production.jpg' width='25' height='25' alt='begin construction' border='0'></a>","45","","","text");

  $dummy="";
      }
    }
  }
}

// *************************************************************** ORBITAL ***********************************************

function orbital()
{
  global $uid;
  global $PHP_SELF;
  global $pid;
  global $skin;

  table_text_open();
  table_text_design("&nbsp;","","center","5","text");
  table_text_close();

  table_text_open();
  table_text_design("<h3>Orbital Buildings</h3>","","center","5","head");
  table_text_close();


  $sth1=mysql_query("select p.* from production as p,research as r left join constructions as b on p.prod_id=b.prod_id and b.pid=".$pid." and b.type=1 left join o_production as pp on pp.prod_id=p.prod_id and pp.planet_id=$pid where (p.typ='O' or p.typ='R') and r.uid=$uid and p.tech=r.t_id and b.prod_id is NULL and pp.prod_id is NULL and 1=1");
  if (mysql_num_rows($sth1)==0)
  {
    table_text_open();
    table_text_design("You have built everything you can build","","center","5","text");
    table_text_close();
  }
  else
  {
    while ($planetar=mysql_fetch_array($sth1))
    {
      $makes_sense = get_buildings_sense($planetar["prod_id"], $pid);
      $darf_bauen=false;

      if ($makes_sense)
      {
        if ($planetar["p_depend"]==NULL)
          $darf_bauen=true;
        else
        {
    $darf_bauen=construction_exists($planetar["p_depend"],$pid);
        }
      }


      if ($darf_bauen)
      {

  $ress="";

  if ($planetar["metal"]!=0)
  {
    $ress=$ress."<img src=\"arts/metal.jpg\" title=\"Metal\" alt=\"Metal\" border=\"0\">".$planetar["metal"]." ";
  }
  if ($planetar["energy"]!=0)
  {
    $ress=$ress."<img src=\"arts/energy.jpg\" title=\"Energy\" alt=\"Energy\" border=\"0\">".$planetar["energy"]." ";
  }
  if ($planetar["mopgas"]!=0)
  {
    $ress=$ress."<img src=\"arts/mopgas.jpg\" title=\"Mopgas\" alt=\"Mopgas\" border=\"0\">".$planetar["mopgas"]." ";
  }
  if ($planetar["erkunum"]!=0)
  {
    $ress=$ress."<img src=\"arts/erkunum.jpg\" title=\"erkunum\" alt=\"erkunum\" border=\"0\">".$planetar["erkunum"]." ";
  }
  if ($planetar["gortium"]!=0)
  {
    $ress=$ress."<img src=\"arts/gortium.jpg\" title=\"Gortium\" alt=\"Gortium\" border=\"0\">".$planetar["gortium"]." ";
  }
  if ($planetar["susebloom"]!=0)
  {
    $ress=$ress."<img src=\"arts/susebloom.jpg\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\">".$planetar["susebloom"]." ";
  }

  table_text_open("text","center");
  table_text_design("<a href='".$_SERVER["PHP_SELF"]."?act=print_building_info&prod_id=".$planetar["prod_id"]."'><img src='arts/".$planetar["pic"]."' alt='".$planetar["description"]."' border='0' width=\"50px\" height=\"50px\" /></a>","50px","","","text","2");
  table_text_design($planetar["name"],"300","","","text","2");
  table_text_design($ress,"105","","","text","2");

  table_text_design("ETC: ".$planetar["com_time"],"45","","","text");
  table_text_close();
  table_text_open("text","center");
  table_text_design("<a href=\"".$PHP_SELF."?act=oproduction&pid=".$pid."&prod_id=".$planetar["prod_id"]."\"><img src='skins/".$skin."_production.jpg' width='25' height='25' alt='begin construction' border='0'></a>","45","","","text");

  $dummy="";
      }
    }
  }
}

function list_planets()
{
  global $PHP_SELF;
  global $uid;
  global $skin;

  $sth=mysql_query("select p.* from planets as p where p.uid='$uid' order by p.sid,p.name");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  table_start("center","500");
  table_head_text(array("Planet Overview"),"8");
  table_text_open("text");
  table_text_design("<br>","","","8","text");
  table_text_close();
  table_text(array("&nbsp;","Name","Planetary","Orbital","Fleet","Infantry","&nbsp;","&nbsp;"),"center","","","head");

  $old_sid=0;

  while ($planet=mysql_fetch_array($sth))
  {
    if ($old_sid!=$planet["sid"])
    {
      $old_sid=$planet["sid"];
      table_text_open("text");
      table_text_design("System [".get_systemname($planet["sid"])."]","","","8","text");
      table_text_close();
    }

    echo("<form action=\"".$PHP_SELF."\" method=post>");

    $array="";

    $array["picture"] = "<img src=\"".PIC_ROOT . $planet["type"]."_small.gif\" width=\"12\" height=\"12\" border=\"0\" alt=\"".get_full_planets_type($planet["type"]) . " Class\" />";

    if ($planet["name"]=="")
      $array["planet"]="<input type=hidden name=\"pid\" value=\"".$planet["id"]."\"><input name=\"name\" value=\"&lt;Unnamed&gt;\" maxlength=\"16\" size=\"16\">";
    else
      $array["planet"]="<input type=hidden name=\"pid\" value=\"".$planet["id"]."\"><input name=\"name\" value=\"".$planet["name"]."\" maxlength=\"16\" size=\"16\">";

    // planetare gebäude
    $sth1 = mysql_query("select * from p_production as pp,production as p where pp.planet_id='".$planet["id"]."' and p.prod_id=pp.prod_id order by pp.pos DESC");
    while ($planetar=mysql_fetch_array($sth1))
      $array["planetar"]="<a href=\"".$PHP_SELF."?act=build&pid=".$planet["id"]."\">".$planetar["name"]." [".$planetar["time"]."]</a>";
    if (!isset($array["planetar"]))
      $array["planetar"]="<a href=\"".$PHP_SELF."?act=build&pid=".$planet["id"]."\">IDLE</a>";

    // orbitale gebäude
    $sth1 = mysql_query("select * from o_production as op,production as p where op.planet_id='".$planet["id"]."' and p.prod_id=op.prod_id order by op.pos DESC");
    while ($orbital=mysql_fetch_array($sth1))
      $array["orbital"]="<a href=\"".$PHP_SELF."?act=build&pid=".$planet["id"]."\">".$orbital["name"]." [".$orbital["time"]."]</a>";
    if (!isset($array["orbital"]))
      $array["orbital"]="<a href=\"".$PHP_SELF."?act=build&pid=".$planet["id"]."\">IDLE</a>";


    $sth1=mysql_query("select * from s_production as sp,production as p where sp.planet_id='".$planet["id"]."' and p.prod_id=sp.prod_id order by sp.time limit 1");
    while ($fleet=mysql_fetch_array($sth1))
      $array["fleet"]="<a href=\"".$PHP_SELF."?act=fleet&pid=".$planet["id"]."\">".$fleet["name"]." [".$fleet["time"]."]</a>";
    if (!isset($array["fleet"]))
      $array["fleet"]="<a href=\"".$PHP_SELF."?act=fleet&pid=".$planet["id"]."\">IDLE</a>";
    $sth1=mysql_query("select * from i_production as ip,production as p where ip.planet_id='".$planet["id"]."' and p.prod_id=ip.prod_id order by ip.time limit 1");
    while ($inf=mysql_fetch_array($sth1))
      $array["inf"]="<a href=\"".$PHP_SELF."?act=inf&pid=".$planet["id"]."\">".$inf["name"]." [".$inf["time"]."]</a>";
    if (!isset($array["inf"]))
      $array["inf"]="<a href=\"".$PHP_SELF."?act=inf&pid=".$planet["id"]."\">IDLE</a>";

    $array[]="<input type=submit name=\"act\" value=\"Rename\">";
    $array[]="<input type=submit name=\"act\" value=\"Production\">";


    /*if ($planet["name"]=="")
      $name="&lt;Unnamed&gt;";
      else
      $name=$planet["name"];
      $options[$name]=$planet["id"];*/

    table_text($array,"","","","text");

    echo("</form>");
  }

  table_end();
}

function show_planet()
{
  global $pid;
  global $uid;
  global $PHP_SELF;
  global $act2;
  global $act;
  global $skin;

  //  go_back($PHP_SELF);

  if ($act2)
    $new_act=$act2;
  else
    $new_act=$act;

  $sth=mysql_query("select * from planets where id='$pid'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $planet=mysql_fetch_array($sth);

  if ($planet["uid"]!=$uid)
  {
    show_error("I'm not stupid man!");
    return 0;
  }

  if ($planet["name"]=="Unnamed")
    $name = get_planetname($planet["id"]);
  else
    $name=$planet["name"];

  center_headline($name);

  $sth=mysql_query("select max(id) from planets where id<$pid and uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $planet=mysql_fetch_row($sth);

  if ($planet[0]==NULL)
  {
    $prev_planet="&nbsp;";
    $prev_head="&nbsp;";
  }
  else
  {
    $prev_planet="<a href='".$PHP_SELF."?act=$new_act&pid=".$planet[0]."'><img src='skins/".$skin."_left.jpg' width='30' height='30' border='0' alt='previous planet'></a>";
    $prev_head="<h5>previous planet</h5>";
  }

  $sth=mysql_query("select min(id) from planets where id>$pid and uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $planet = mysql_fetch_row($sth);

  if ($planet[0]==NULL)
  {
    $next_planet="&nbsp;";
    $next_head="&nbsp;";
  }
  else
  {
    $next_planet="<a href='".$PHP_SELF."?act=$new_act&pid=".$planet[0]."'><img src='skins/".$skin."_right.jpg' width='30' height='30' border='0' alt='next planet'></a>";
    $next_head="<h5>next planet</h5>";
  }

  table_start("center","500");
  table_text(array($prev_planet,"<a href='".$PHP_SELF."?act=Production&pid=$pid'><img src='skins/".$skin."_planetinfo.jpg' width='50' height='50' border='0' alt='Information screen'></a>","<a href='".$PHP_SELF."?act=build&pid=$pid'><img src='skins/".$skin."_buildings.jpg' width='50' height='50' border='0' alt='Bureau of Construction'></a>","<a href='".$PHP_SELF."?pid=$pid&act=inf'><img src='skins/".$skin."_infan.jpg' width='50' height='50' border='0' alt='Base Camp'></a>","<a href='".$PHP_SELF."?act=fleet&pid=$pid'><img src='skins/".$skin."_fleet.jpg' width='50' height='50' border='0' alt='Control Tower'></a>",$next_planet),"center","125");

  table_text(array($prev_head,"<h5>Info</h5>","<h5>Buildings</h5>","<h5>Ground Force</h5>","<h5>Fleet</h5>",$next_head),"center");
  table_end();

  echo("<br><br>\n");

  // return 0;
}

function build()
{
  global $uid;
  global $pid;
  global $PHP_SELF;
  global $skin;

  $sth=mysql_query("select id from planets where id=$pid and uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("müsli!");
    return 0;
  }

  $sth=mysql_query("select * from constructions pr, production as p where pr.pid='$pid' and pr.prod_id=p.prod_id and pr.type=0");

  table_start("center","500");

  while ($planet=mysql_fetch_array($sth))
  {
    if (!isset($dummy))
    {
      table_head_text(array("Planetary Buildings"),"2");
      table_text_open("head");
      table_text_design("&nbsp;","50","","","head");
      table_text_design("&nbsp;","450","","","head");
      table_text_close();
    }

    table_text_open("text");
    table_text_design("<a href='".$_SERVER["PHP_SELF"]."?act=print_building_info&prod_id=".$planet["prod_id"]."'><img src='arts/".$planet["pic"]."' border='0' alt='".$planet["description"]."' align='center' width=\"50px\" height=\"50px\" /></a>","50px","","","text");
    table_text_design($planet["name"],"450","","","text");
    table_text_close();

    $dummy="";
  }

  if (!isset($dummy))
    show_message("You haven't constructed any planetary building yet.");

  table_end();
  echo("<br><br>\n");

  $sth=mysql_query("select * from constructions as o, production as p where o.pid='$pid' and o.prod_id=p.prod_id and o.type=1");

  while ($planet=mysql_fetch_array($sth))
  {
    if (!isset($dummy2))
    {
      table_start("center","500");
      table_head_text(array("Orbital Buildings"),"2");
      table_text_open("head");
      table_text_design("&nbsp;","50","","","head");
      table_text_design("&nbsp;","450","","","head");
      table_text_close();

    }
    table_text_open("text");
    table_text_design("<a href='".$_SERVER["PHP_SELF"]."?act=print_building_info&prod_id=".$planet["prod_id"]."'><img src='arts/".$planet["pic"]."' border='0' alt='".$planet["description"]."' align='center' width=\"50px\" height=\"50px\" /></a>","50","","","text");
    table_text_design($planet["name"],"450","","","text");
    table_text_close();


    $dummy2="";
  }

  if (!isset($dummy2))
    show_message("No structure has been constructed in orbit yet");

  table_end();
  echo("<br><br>\n");

  center_headline("Production on Planet ".$name);
  table_start();
  $planetar=mysql_query("select * from p_production as pp,production as p where pp.planet_id='".$pid."' and p.prod_id=pp.prod_id order by pp.pos");
  $orbital=mysql_query("select * from o_production as op,production as p where op.planet_id='".$pid."' and p.prod_id=op.prod_id order by op.pos");

  prod_queues($planetar,$orbital);

  table_start("center","500");
  table_head_text(array("Construct a building"),"5");

  planetar($planetar);
  orbital($orbital);

  table_end();
}

function prod_queues($planetar,$orbital)
{
  global $pid;

  table_start("center","500");
  table_head_text(array("Production queues"),"5");
  table_text_open();
  table_text_design("&nbsp;","","center","5","text");
  table_text_close();
  table_text_open();
  table_text_design("<h3>Planetary Production Queue</h3>","","center","5","head");
  table_text_close();

  if (mysql_num_rows($planetar)==0)
  {
    table_text_open();
    table_text_design("Planetary Production Queue is empty","","center","5","text");
    table_text_close();
  }
  else
  {
    $first=false;
    while ($building=mysql_fetch_array($planetar))
    {
      if (!$first)
      {
        if ($building["pos"]==1)
          $add_text="<br><div style=\"color: lime\">under construction</div>";
        else
          $add_text="<br><span style=\"color: red\">waiting for resources</span>";
        $first=true;
      }
      else
  $add_text="";
      echo("<form action=\"".$PHP_SELF."\" method=post>");
      table_text_open();
      table_text_design("<img src='arts/".$building["pic"]."' alt='".$building["description"]."' border='0' width=\"50px\" height=\"50px\" /></a>","50px","","","text");
      table_text_design($building["name"].$add_text,"*","","","text");
      table_text_design($building["time"]." weeks","10%","","","text");
      table_text_design("<input type=hidden name=\"act\" value=\"pscrap\"><input type=\"hidden\" name=\"prod_id\" value=\"".$building["prod_id"]."\"><input type=hidden name=\"pid\" value=\"$pid\"><input type=submit value=\"Scrap\">","10%","","","text");
      echo("</form>");
      table_text_close();
    }
  }

  table_text_open();
  table_text_design("&nbsp;","","center","5","text");
  table_text_close();
  table_text_open();
  table_text_design("<h3>Orbital Production Queue</h3>","","center","5","head");
  table_text_close();


  if (mysql_num_rows($orbital)==0)
  {
    table_text_open();
    table_text_design("Orbital Production Queue is empty","","center","5","text");
    table_text_close();
  }
  else
  {
    $first=false;
    while ($orbit=mysql_fetch_array($orbital))
    {
      if (!$first)
      {
  if ($orbit["pos"]==1)
    $add_text="<br><div style=\"color: lime\">under construction</div>";
  else
    $add_text="<br><span style=\"color: red\">waiting for resources</span>";
  $first=true;
      }
      else
  $add_text="";
      echo("<form action=\"".$PHP_SELF."\" method=post>");
      table_text_open();
      table_text_design("<img src='arts/".$orbit["pic"]."' alt='".$orbit["description"]."' border='0' width=\"50px\" height=\"50px\" /></a>","50px","","","text");
      table_text_design($orbit["name"].$add_text,"*","","","text");
      table_text_design($orbit["time"]." weeks","10%","","","text");
      table_text_design("<input type=hidden name=\"act\" value=\"oscrap\"><input type=\"hidden\" name=\"prod_id\" value=\"".$orbit["prod_id"]."\"><input type=hidden name=\"pid\" value=\"$pid\"><input type=submit value=\"Scrap\">","10%","","","text");
      echo("</form>");
      table_text_close();
    }
  }

  table_text_open();
  table_text_design("&nbsp;","","center","5","text");
  table_text_close();

  table_end();
  echo("<br><br>");
}

function fleet_info()
{
  global $pid;
  global $uid;
  global $skin;

  $sth=mysql_query("select uid from planets where id=$pid and uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Databaser failure!");
    return 0;
  }

  $fids=get_fids_by_pid($pid,$uid);

  if (!$fids)
  {
    show_message("You have no fleet on this planet");
  }
  else
  {

    table_start("center","500");
    table_head_text(array("Ships in orbit"),"3");
    table_text_open("head");

    for ($i=0;$i<sizeof($fids);$i++)
    {
      $fleet=new fleet($fids[$i]);

      table_text_open("head");
      table_text_design($fleet->name,"80","","","head");
      table_text_design("Name","300","center","","smallhead");
      table_text_design("Count","100","center","","smallhead");
      table_text_close();

      while (list($prod_id,$ships_arr)=each($fleet->ships))
      {
  $sth=mysql_query("select manual from production where prod_id=$prod_id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $manual=mysql_fetch_array($sth);

  table_text_open("text","center");
  table_text_design("<a href='".$manual["manual"]."' target=\"_blank\"><img src='arts/".get_pic($prod_id)."' border='0' alt='".get_description($prod_id)."' align='center'></a><br><a href=\"".$PHP_SELF."?act=print_ship_info&prod_id=".$prod_id."\">Info</a>","80","","","text");
  table_text_design(get_name_by_prod_id($prod_id),"300","","","text");
  table_text_design($ships_arr[0],"100","","","text");
  table_text_close();

      }
    }

    table_end();
  }


  $sth3=mysql_query("select * from s_production as sp,production as p where sp.planet_id='".$pid."' and p.prod_id=sp.prod_id order by sp.time,sp.prod_id");

  table_start("center","500");
  fleet($sth3);
  table_end();
}

function infantery_info()
{
  global $pid;
  global $uid;
  global $skin;

  $sth=mysql_query("select id from planets where id=$pid and uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Yeah! You just hit one of my security barriers:)!");
    return 0;
  }


  table_start("center","500");
  table_head_text(array("Infantry"),"4");
  table_text_open("head");
  table_text_design("&nbsp;","80","","","head");
  table_text_design("&nbsp;","420","","3","head");
  table_text_close();

  /*
  $sth=mysql_query("select i.prod_id,i.count,i.uid from infantery as i, production as p where i.pid='".$pid."' and i.prod_id=p.prod_id");

  while ($infantery=mysql_fetch_array($sth))
  {
    $total_infantery[$infantery["prod_id"]][$infantery["uid"]] += $infantery["count"];
  }
  */
  
  $sth=mysql_query("select i.prod_id, i.count, i.uid, p.name, p.pic from infantery as i, production as p where i.pid='$pid' and i.prod_id=p.prod_id order by i.uid");

  while ($inf = mysql_fetch_array($sth))
  {
    $inf_on_planet[$inf["uid"]][$inf["prod_id"]]  = $inf["count"];
    $inf_info[$inf["prod_id"]]["name"]            = $inf["name"];
    $inf_info[$inf["prod_id"]]["pic"]             = $inf["pic"];
    
    if (!$user_info[$inf["uid"]])
    {
      $user_info[$inf["uid"]]["relation"] = get_uids_relation($uid, $inf["uid"], 1);
      $user_info[$inf["uid"]]["name"]     = get_name_by_uid($inf["uid"]);
    }

    $dummy3="";
  }

  if(is_array($inf_on_planet))  
  foreach($inf_on_planet as $i_uid => $inf)
  {
    foreach($inf as $prod_id => $count)
    {
      table_text_open("text","center");
      table_text_design("<img src='arts/".$inf_info[$prod_id]["pic"]."' border='1' alt='".$infantery["description"]."' align='center'></a>","80","","","text");
      table_text_design($inf_info[$prod_id]["name"]." (".$user_info[$i_uid]["name"].")","320","","","text");
      table_text_design($count,"100","","","text");
      table_text_close();
    }
  }

  if (!isset($dummy3))
    show_message("You have no infantry on this planet");

  table_end();

  $sth4=mysql_query("select * from i_production as ip,production as p where ip.planet_id='".$pid."' and p.prod_id=ip.prod_id");
  infantery($sth4);

}

function pproduction()
{
  global $uid;
  global $pid;
  global $prod_id;
  global $skin;

  $sth=mysql_query("select uid from planets where id=$pid");
  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $user_id=mysql_fetch_array($sth);

  if ($user_id["uid"]!=$uid)
  {
    show_error("I'm not stupid man!");
    return 0;
  }

  $sth=mysql_query("select p.* from production as p,research as r left join constructions as b on p.prod_id=b.prod_id and b.pid=$pid and b.type=0 where p.typ='P' and p.tech=r.t_id and r.uid=$uid and p.prod_id=$prod_id and b.prod_id is NULL");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("If you try to hack the links i can tell you that you'll always fail:)");
    return 0;
  }

  $prod=mysql_fetch_array($sth);

  if ($prod["p_depend"]!=NULL)
  {
    if (!construction_exists($prod["p_depend"],$pid))
    {
      show_error("Damn Hacker:)");
      return 0;
    }
  }

  $sth=mysql_query("select * from ressources where uid='$uid' and if(metal<0,0,metal)>=".$prod["metal"]." and if(energy<0,0,energy)>=".$prod["energy"]." and if(mopgas<0,0,mopgas)>=".$prod["mopgas"]." and if(erkunum<0,0,erkunum)>=".$prod["erkunum"]." and if(gortium<0,0,gortium)>=".$prod["gortium"]." and if(susebloom<0,0,susebloom)>=".$prod["susebloom"]);

  if (mysql_num_rows($sth)==0)
  {
    show_error("You don't have enough ressources to build this structure!");
    return 0;
  }

  $sth=mysql_query("select com_time from production where prod_id=$prod_id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $time=mysql_fetch_array($sth);

  $sth=mysql_query("select prod_id from p_production where planet_id=$pid and prod_id=$prod_id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_error("You are already building this building here!");
    return 0;
  }


  $sth=mysql_query("select max(pos) from p_production where planet_id=$pid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $max_pos=mysql_fetch_row($sth);

  if ($max_pos[0]==NULL)
    $max_pos[0]=0;


  $sth=mysql_query("insert into p_production (prod_id,planet_id,time,pos) values ('$prod_id','$pid','".$time["com_time"]."','".($max_pos[0]+1)."')");

  if ($max_pos[0]==0)
  {
    $sth=mysql_query("update ressources set metal=metal-".$prod["metal"].",energy=energy-".$prod["energy"].",mopgas=mopgas-".$prod["mopgas"].",erkunum=erkunum-".$prod["erkunum"].",gortium=gortium-".$prod["gortium"].",susebloom=susebloom-".$prod["susebloom"]." where uid=$uid");
  }

}

function oproduction()
{
  global $uid;
  global $pid;
  global $prod_id;
  global $skin;

  $sth=mysql_query("######################## oproduction ###########################");

  $sth=mysql_query("select * from constructions where prod_id=$prod_id and pid=$pid and type=1");

  if (mysql_num_rows($sth)>0)
  {
    show_error("You've already build this building on this planet!");
    return 0;
  }

  $sth=mysql_query("select uid from planets where id=$pid");
  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $user_id=mysql_fetch_array($sth);

  if ($user_id["uid"]!=$uid)
  {
    show_error("I'm not stupid man!");
    return 0;
  }

  $sth=mysql_query("select p.* from production as p,research as r left join constructions as b on p.prod_id=b.prod_id and b.pid=$pid and b.type=1 where (p.typ='O' or p.typ='R') and p.tech=r.t_id and r.uid=$uid and p.prod_id=$prod_id and b.prod_id is NULL");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("If you try to hack the links i can tell you that you'll always fail:)");
    return 0;
  }

  $prod=mysql_fetch_array($sth);

  if ($prod["p_depend"]!=NULL)
  {
    if (!construction_exists($prod["p_depend"],$pid))
    {
      show_error("Damn Hacker:)");
      return 0;
    }
  }


  $sth=mysql_query("select special from production where prod_id=$prod_id and special!=''");

  if (mysql_num_rows($sth)>0)
  {
    $special=mysql_fetch_array($sth);

    switch ($special["special"])
    {
      case "U":
  $sth=mysql_query("select * from constructions as o,planets as p where o.prod_id=".$prod_id." and o.pid=p.id and o.type=1 and p.uid=".$uid);

        if (mysql_num_rows($sth)!=0)
        {
    show_error("You can only build this orbital on ONE planet!");
    return 0;
        }

  $sth=mysql_query("select * from o_production o, planets p where o.prod_id=".$prod_id." and o.planet_id=p.id and p.uid=".$uid);

  if (mysql_num_rows($sth)!=0)
        {
    show_error("You can only build this orbital on ONE planet!");
    return 0;
        }
      break;
      case "S":
  $sid=get_sid_by_pid($pid);

      $sth=mysql_query("select * from constructions as o,planets as p where p.sid=".$sid." and o.pid=p.id and o.type=1 and o.prod_id=".$prod_id);

      if (!$sth)
      {
  show_error("Database failure!");
  return 0;
      }

      if (mysql_num_rows($sth)>0)
      {
  show_message("You can only build this orbital one time per system");
  return 0;
      }
    }
  }

  $sth=mysql_query("select * from ressources where uid='$uid' and if(metal<0,0,metal)>=".$prod["metal"]." and if(energy<0,0,energy)>=".$prod["energy"]." and if(mopgas<0,0,mopgas)>=".$prod["mopgas"]." and if(erkunum<0,0,erkunum)>=".$prod["erkunum"]." and if(gortium<0,0,gortium)>=".$prod["gortium"]." and if(susebloom<0,0,susebloom)>=".$prod["susebloom"]);

  if (mysql_num_rows($sth)==0)
  {
    show_error("You don't have enough ressources to build this structure!");
    return 0;
  }


  $sth=mysql_query("select com_time from production where prod_id=$prod_id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $time=mysql_fetch_array($sth);

  $sth=mysql_query("select prod_id from o_production where planet_id=$pid and prod_id=$prod_id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_error("You are already building this building here!");
    return 0;
  }

  $sth=mysql_query("select max(pos) from o_production where planet_id=$pid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $max_pos=mysql_fetch_row($sth);

  if ($max_pos[0]==NULL)
    $max_pos[0]=0;

  $sth=mysql_query("insert into o_production (prod_id,planet_id,time,pos) values ('$prod_id','$pid','".$time["com_time"]."','".($max_pos[0]+1)."')");

  if ($max_pos[0]==0)
  {
    $sth=mysql_query("update ressources set metal=metal-".$prod["metal"].",energy=energy-".$prod["energy"].",mopgas=mopgas-".$prod["mopgas"].",erkunum=erkunum-".$prod["erkunum"].",gortium=gortium-".$prod["gortium"].",susebloom=susebloom-".$prod["susebloom"]." where uid=$uid");
  }

  $sth=mysql_query("######################## oproduction ENDE ###########################");
}

function fproduction()
{
  global $uid;
  global $PHP_SELF;
  global $pid;
  global $fleet;
  global $skin;

  $sth=mysql_query("select uid from planets where id=$pid");
  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $user_id=mysql_fetch_array($sth);

  if ($user_id["uid"]!=$uid)
  {
    show_error("I'm not stupid man!");
    return 0;
  }

  $sth=mysql_query("select p.* from production as p,research as r where (p.typ='L' or p.typ='M' or p.typ='H') and p.tech=r.t_id and r.uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("If you try to hack the links i can tell you that you'll always fail:)");
    return 0;
  }
  
  while (list($key,$value)=each($fleet))
  {
    $value = floor($value);
    if ($value!=0)
    {
      if ($value<0)
        show_error("Please enter a value higher than 0!");
      else
      {
        $sth=mysql_query("select * from production as p,shipvalues s,research as r where p.prod_id='".$key."' and (p.typ='L' or p.typ='M' or p.typ='H') and p.tech=r.t_id and r.uid=$uid and p.prod_id=s.prod_id");

        if (mysql_num_rows($sth)==0)
        {
          show_error("Don't try to hack the links! Will not work:)))");
          return 0;
        }

        $prod=mysql_fetch_array($sth);

        if ($prod["p_depend"]!=NULL)
        {
          if (!construction_exists($prod["p_depend"],$pid))
          {
            show_error("Damn Hacker:)");
            return 0;
          }
        }
        
        $sth=mysql_query("insert into s_production (prod_id,planet_id,time,count) values ('$key','$pid',0,'$value') on duplicate key update count=count+".$value);

        if (!$sth)
        {
          show_error("Database failure!");
          return 0;
        }
      }
    }
  }
}

function iproduction()
{
  global $uid;
  global $PHP_SELF;
  global $pid;
  global $infantery;
  global $skin;

  $sth=mysql_query("select uid from planets where id=$pid");
  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $user_id=mysql_fetch_array($sth);

  if ($user_id["uid"]!=$uid)
  {
    show_error("I'm not stupid man!");
    return 0;
  }

  $sth=mysql_query("select p.* from production as p,research as r where (p.typ='I' or p.typ='T') and p.tech=r.t_id and r.uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("If you try to hack the links i can tell you that you'll always fail:)");
    return 0;
  }



  while (list($key,$value)=each($infantery))
  {
    $value = floor($value);
    if ($value!=0)
    {
      if ($value<0)
        show_error("Please enter a value higher than 0!");
      else
      {
  $sth=mysql_query("select * from production as p,research as r where p.prod_id='".$key."' and (p.typ='I' or p.typ='T') and p.tech=r.t_id and r.uid=$uid");

  if (mysql_num_rows($sth)==0)
  {
    show_error("Don't try to hack the links! Will not work:)))");
    return 0;
  }

  $prod=mysql_fetch_array($sth);

  if ($prod["p_depend"]!=NULL)
  {
    if (!construction_exists($prod["p_depend"],$pid))
    {
      show_error("Damn Hacker:)");
      return 0;
    }
  }


  $sth=mysql_query("select * from ressources where uid='$uid' and if(metal<0,0,metal)>=".($prod["metal"]*$value)." and if(energy<0,0,energy)>=".($prod["energy"]*$value)." and if(mopgas<0,0,mopgas)>=".($prod["mopgas"]*$value)." and if(erkunum<0,0,erkunum)>=".($prod["erkunum"]*$value)." and if(gortium<0,0,gortium)>=".($prod["gortium"]*$value)." and if(susebloom<0,0,susebloom)>=".($prod["susebloom"]*$value));

  if (mysql_num_rows($sth)==0)
  {
    show_error("You don't have enough ressources to build this infantry!");
    return 0;
  }

  $sth=mysql_query("select com_time from production where prod_id=$key");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $time=mysql_fetch_array($sth);

  $sth=mysql_query("select * from i_production where planet_id='".$pid."' and prod_id='".$key."' and time='".$time["com_time"]."'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    $sth=mysql_query("insert into i_production (prod_id,planet_id,time,count) values ('$key','$pid','".$time["com_time"]."','$value')");
  }
  else
  {
    $sth=mysql_query("update i_production set count=count+".$value." where planet_id='".$pid."' and prod_id='".$key."' and time='".$time["com_time"]."'");
  }

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("update ressources set metal=metal-".($prod["metal"]*$value).",energy=energy-".($prod["energy"]*$value).",mopgas=mopgas-".($value*$prod["mopgas"]).",erkunum=erkunum-".($prod["erkunum"]*$value).",gortium=gortium-".($prod["gortium"]*$value).",susebloom=susebloom-".($prod["susebloom"]*$value)." where uid=$uid");
      }
    }
  }
}

function fscrap()
{
  global $pid;
  global $count;
  global $prod_id;
  global $time;
  global $uid;

  if (is_array($prod_id))
  {
    reset ($prod_id);

    while (list($key,$value)=each($prod_id))
    {
      if (($value="Y") and ($count[$key]>0))
      {
        $sth=mysql_query("select time from s_production where prod_id=".$key." and count>=".$count[$key]." and planet_id=$pid and time=".$time[$key]);

        if (!$sth)
        {
          show_error("Database failure!");
          return 0;
        }

        if (mysql_num_rows($sth)>0)
        {
          $sth=mysql_query("update s_production set count=count-".$count[$key]." where prod_id=".$key." and count>=".$count[$key]." and planet_id=$pid and time=".$time[$key]);

          if (!$sth)
          {
            show_error("Database failure!");
            return 0;
          }

          $sth=mysql_query("delete from s_production where count<=0");

          if (!$sth)
          {
            show_error("Database failure!");
            return 0;
          }
        }
      }
    }
  }
}

function pscrap()
{
  global $uid;
  global $prod_id;
  global $pid;

  $sth=mysql_query("select time,pos from p_production where prod_id=".$prod_id." and planet_id=$pid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    list($time,$pos)=mysql_fetch_row($sth);

    if ($pos==1)
    {
      $sth=mysql_query("select com_time from production where prod_id=$prod_id");

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      $com_time=mysql_fetch_row($sth);

      $ratio=($time/$com_time[0]);

      $sth=mysql_query("select metal*$ratio,energy*$ratio,mopgas*$ratio,erkunum*$ratio,gortium*$ratio,susebloom*$ratio from production where prod_id=".$prod_id);

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      list($metal,$energy,$mopgas,$erkunum,$gortium,$susebloom)=mysql_fetch_row($sth);

      $sth=mysql_query("update ressources set metal=metal+$metal,energy=energy+$energy,mopgas=mopgas+$mopgas,erkunum=erkunum+$erkunum,susebloom=susebloom+$susebloom, gortium=gortium+$gortium where uid=$uid");

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      if ($metal > 0)
        show_message("Received ".round($metal)." units metal.");

      if ($energy > 0)
        show_message("Received ".round($energy)." units energy.");

      if ($mopgas > 0)
        show_message("Received ".round($mopgas)." units mopgas.");

      if ($erkunum > 0)
        show_message("Received ".round($erkunum)." units erkunum.");

      if ($gortium > 0)
        show_message("Received ".round($gortium)." units gortium.");

      if ($susebloom > 0)
        show_message("Received ".round($susebloom)." units susebloom.");
    }

    $sth=mysql_query("delete from p_production where prod_id=$prod_id and planet_id=$pid and pos=".$pos);

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    $sth = mysql_query("update p_production set pos = pos - 1 where pos > ".$pos["pos"]);
  }
}

function oscrap()
{
  global $uid;
  global $prod_id;
  global $pid;

  $sth=mysql_query("select time,pos from o_production where prod_id=".$prod_id." and planet_id=$pid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    list($time,$pos)=mysql_fetch_row($sth);

    if ($pos==1)
    {
      $sth=mysql_query("select com_time from production where prod_id=$prod_id");

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      $com_time=mysql_fetch_row($sth);

      $ratio=($time/$com_time[0]);

      $sth=mysql_query("select metal*$ratio,energy*$ratio,mopgas*$ratio,erkunum*$ratio,gortium*$ratio,susebloom*$ratio from production where prod_id=".$prod_id);

      if (!$sth)
      {
  show_error("Database failure!");
  return 0;
      }

      list($metal,$energy,$mopgas,$erkunum,$gortium,$susebloom)=mysql_fetch_row($sth);

      $sth=mysql_query("update ressources set metal=metal+$metal,energy=energy+$energy,mopgas=mopgas+$mopgas,erkunum=erkunum+$erkunum,susebloom=susebloom+$susebloom, gortium = gortium + $gortium where uid=$uid");

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      if ($metal > 0)
        show_message("Received ".round($metal)." units metal.");

      if ($energy > 0)
        show_message("Received ".round($energy)." units energy.");

      if ($mopgas > 0)
        show_message("Received ".round($mopgas)." units mopgas.");

      if ($erkunum > 0)
        show_message("Received ".round($erkunum)." units erkunum.");

      if ($gortium > 0)
        show_message("Received ".round($gortium)." units gortium.");

      if ($susebloom > 0)
        show_message("Received ".round($susebloom)." units susebloom.");
    }

    $sth=mysql_query("delete from o_production where prod_id=$prod_id and planet_id=$pid and pos=".$pos["pos"]);

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    $sth = mysql_query("update o_production set pos = pos - 1 where pos > ".$pos);
  }
}

function rename_planet()
{
  global $uid;
  global $pid;
  global $name;

  $sth=mysql_query("select * from planets where id='$pid' and uid='$uid'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("You don't own this planet!");
    return 0;
  }

  if ($name=="&lt;Unnamed&gt;")
    return 0;

  $sth=mysql_query("update planets set name='".htmlspecialchars($name)."' where id=$pid");

}

function show_info()
{
  global $uid;
  global $pid;

  $sth=mysql_query("select * from planets p,popgain g where p.id=$pid and p.uid=$uid and p.id=g.pid");

  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("Jailhouse rock!");
    return 0;
  }

  center_headline("Information Screen");

  $planet=mysql_fetch_assoc($sth);

  table_border_start("center","","#302859","#100666","#D2CCF9");
  echo("<tr>\n");
  echo(" <td rowspan=\"14\">\n");
  echo("   <img src=\"arts/".$planet["type"].".jpg\">\n");
  echo(" <td>\n");
  echo("</tr>\n");
  table_head_text(array("Information"),"2");
  table_text_open();
  table_text_design("Owner","","center","1","head");

  $sth=mysql_query("select u.name,ifnull(a.name,'none') as aname from users u left join alliance a on a.id=u.alliance where u.id=".$planet["uid"]);

  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("Database failure!");
    return 0;
  }

  $owner=mysql_fetch_assoc($sth);

  table_text_design($owner["name"],"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("System","","center","1","head");
  table_text_design(get_systemname($planet["sid"]),"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("Alliance","","center","1","head");
  table_text_design($owner["aname"],"","center","1","text");
  table_text_close();
  
  if ($planet["gain"]>0)
    $gain="<span style=\"color: lime\">+".($planet["gain"]*100)."%</span>";
  else
    $gain="+/-0%";

  table_text_open();
  table_text_design("Population","","center","1","head");
  table_text_design(get_poplevel_by_pop($planet["population"])." ".$gain." (".$planet["max_poplevel"].")","","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("Planettype","","center","1","head");

  switch($planet["type"])
  {
    case "O":
      $type="Origin Class";
    break;
    case "M":
      $type="Mars Class";
    break;
    case "A":
      $type="Ancient Class";
    break;
    case "D":
      $type="Desert Class";
    break;
    case "E":
      $type="Eden Class";
    break;
    case "G":
      $type="Gas Giant Class";
    break;
    case "H":
      $type="Heavy Grav Class";
    break;
    case "I":
      $type="Ice Class";
    break;
    case "R":
      $type="Rock Class";
    break;
    case "T":
      $type="Toxic Class";
    break;
  }

  define("planet_raw_metal","8.5");
  define("planet_raw_energy","8.5");
  define("planet_raw_mopgas","8.5");
  define("planet_raw_erkunum","8.5");
  define("planet_raw_gortium","8.5");
  define("planet_raw_susebloom","8.5");
  define("planet_no_upgrade_factor","1");

  $sth=mysql_query("select * from planets where id=$pid");

  $population_factor=(log10($planet["population"]/1000)+3);
  
  $sth=mysql_query("select * from final_prod_factors where pid=".$pid);

  if (!$sth)
  {
    show_error("ERR::GET PROD_FACTORS");
    return false;
  }
  
  if (mysql_num_rows($sth)==1)
    $factors=mysql_fetch_assoc($sth);
  else
    $factors=false;

  $metal_plus=round($factors["metal"]*($planet["metal"]/100)*(planet_raw_metal*$population_factor));
  $energy_plus=round($factors["energy"]*($planet["energy"]/100)*planet_raw_energy*$population_factor);
  $mopgas_plus=round($factors["mopgas"]*($planet["mopgas"]/100)*planet_raw_mopgas*$population_factor);
  $erkunum_plus=round($factors["erkunum"]*($planet["erkunum"]/100)*planet_raw_erkunum*$population_factor);
  $gortium_plus=round($factors["gortium"]*($planet["gortium"]/100)*planet_raw_gortium*$population_factor);
  $susebloom_plus=round($factors["susebloom"]*($planet["susebloom"]/100)*planet_raw_susebloom*$population_factor);



  table_text_design($type,"","center","1","text");
  table_text_close();
  
  table_text_open();
  table_text_design("Production factor","","center","1","head");
  table_text_design(($planet["production_factor"]*100)."%","","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("<img src='arts/metal.gif' title='Metal' alt='Metal'>","","center","1","head");
  table_text_design($metal_plus,"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("<img src='arts/energy.gif' title='Energy' alt='Energy'>","","center","1","head");
  table_text_design($energy_plus,"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("<img src='arts/mopgas.gif' title='Mopgas' alt='Mopgas'>","","center","1","head");
  table_text_design($mopgas_plus,"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("<img src='arts/erkunum.gif' title='Erkunum' alt='Erkunum'>","","center","1","head");
  table_text_design($erkunum_plus,"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("<img src='arts/gortium.gif' title='Gortium' alt='Gortium'>","","center","1","head");
  table_text_design($gortium_plus,"","center","1","text");
  table_text_close();

  table_text_open();
  table_text_design("<img src='arts/susebloom.gif' title='Susebloom' alt='Susebloom'>","","center","1","head");
  table_text_design($susebloom_plus,"","center","1","text");
  table_text_close();
  table_end();


  echo("<br><br>\n");

  echo("<center>\n");

//  echo("<a href=\"planet.php?pid=".$planet["id"]."\" target=\"anzeige_frame\">fleet orders</a>\n");
  echo("</center>\n");

  echo("<br>\n");

  $query=mysql_query("SELECT ps.*, p.pic, p.description, p.name FROM planetary_shields ps 
INNER JOIN production p USING (prod_id) WHERE pid=$pid") or die (mysql_error());
  
  if (mysql_num_rows($query)>0)
  {
  	table_start("center","500");
  	table_head_text(array("Shield generators installed on {$planet['name']}"),"5");
  	
  	table_text_open("head");
  	table_text_design("&nbsp;","50px","","","head");
  	table_text_design("Building","300","","","head");
  	table_text_design("Max","50","center","","head");
  	table_text_design("Power","50","center","","head");
  	table_text_design("Load","50","center","","head");
  
  	while ($result=mysql_fetch_assoc($query))
  	{
		  table_text_open("text","center");
		  table_text_design("<a href='".$_SERVER["PHP_SELF"]."?act=print_building_info&prod_id=".$result["prod_id"]."'><img src='arts/".$result["pic"]."' alt='".$result["description"]."' border='0' width=\"50px\" height=\"50px\" /></a>","50px","","","text","2");
		  table_text_design($result["name"],"300","","","text","2");
		  table_text_design($result["max_value"],"50","","","text","2");
			table_text_design($result["value"],"50","","","text","2");
			table_text_design($result["regeneration"]+$result["regeneration_bonus"],"50","","","text","2");
		  table_text_close(); 		
  	}
  	table_end();
  }
  
  echo("<br>\n");
  
  table_start("center","500");

  table_head_text(array("Units stationed on ".$planet["name"]),"5");

  table_text(array("&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;"),"center","100","","text");

  table_text_open("head");
  table_text_design("Infantry","200","center","2","head");
  table_text_design("&nbsp;","100","","","head");
  table_text_design("Fleet","200","center","2","head");
  table_text_close();

  $sth=mysql_query("select sum(count) from infantery as i,production as p where i.pid=".$pid." and i.prod_id=p.prod_id
      and p.typ='I'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $inf=mysql_fetch_row($sth);

  if ($inf[0]=="")
    $inf[0]="No troops";

  table_text_open("text","center");
  table_text_design("Infantry","","","","text");
  table_text_design($inf[0],"","","","text");
  table_text_design("&nbsp;","100","","","none");

  table_text_design("Europa Class","","","","text");
  table_text_design(get_fcount_by_type($uid,"L",$pid),"","","","text");
  table_text_close();

  $sth=mysql_query("select sum(count) from infantery as i,production as p where i.pid=".$pid." and i.prod_id=p.prod_id and p.typ='T'");

  if(!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $inf=mysql_fetch_row($sth);

  if ($inf[0]=="")
    $inf[0]="No Vehicles";

  table_text_open("text","center");
  table_text_design("Vehicles","","","","text");
  table_text_design($inf[0],"","","","text");
  table_text_design("&nbsp;","100","","","none");

  table_text_design("Zeus Class","","","","text");
  table_text_design(get_fcount_by_type($uid,"M",$pid),"","","","text");
  table_text_close();

  table_text_open("text","center");
  table_text_design("&nbsp;");
  table_text_design("&nbsp;");
  table_text_design("&nbsp;","100","","","none");

  table_text_design("Olymp Class","","","","text");
  table_text_design(get_fcount_by_type($uid,"H",$pid),"","","","text");
  table_text_close();

  table_end();

}

function change_fprio($pid,$prod_id,$time,$change)
{
  global $uid;

  if (get_uid_by_pid($pid)!=$uid)
  {
    show_error("TADA!!!!");
    return false;
  }
  
  switch($change)
  {
    case 1:
    case -1:
      $sth=mysql_query("update s_production set priority=if(priority+".$change.">2 or priority+".$change."<0,priority,priority+".$change.") where planet_id=".$pid." and prod_id=".$prod_id." and time=".$time);

      if (!$sth)
      {
        show_error("ERR::SET PRIO");
      }
  }
}

switch ($act)
{
  case "pproduction":
    $act2="build";
  break;
  case "fproduction":
    $act2="fleet";
  break;
  case "oproduction":
    $act2="build";
  break;
  case "iproduction":
    $act2="inf";
  break;
  case "fscrap":
    $act2="fleet";
    break;
  case "pscrap":
    $act2="build";
    break;
  case "oscrap":
    $act2="build";
    break;
  default:
  $act2=false;
}


switch ($act)
{
  case "build":
    show_planet();
  build();
  break;
  case "fleet":
    show_planet();
  fleet_info();
  break;
  case "inf":
    show_planet();
  infantery_info();
  break;
  case "Rename":
    rename_planet();
  list_planets();
  break;
  case "Production":
    show_planet();
  show_info();
  break;
  case "pproduction":
    pproduction();
  show_planet();
  build();
  break;
  case "oproduction":
    oproduction();
  show_planet();
  build();
  break;
  case "fproduction":
    fproduction();
  show_planet();
  fleet_info();
  break;
  case "iproduction":
    iproduction();
  show_planet();
  infantery_info();
  break;
  case "fscrap":
    fscrap();
  show_planet();
  fleet_info();
  break;
  case "pscrap":
  pscrap();
  show_planet();
  build();
  break;
  case "oscrap":
    oscrap();
  show_planet();
  build();
  break;
  case "print_ship_info":
    print_ship_info_prod($prod_id);
  break;
  case "print_building_info":
    print_building_info($prod_id);
    break;
  case "fprio":
    change_fprio($_REQUEST["pid"],$_REQUEST["prod_id"],$_REQUEST["time"],$_REQUEST["change"]);
    show_planet();
    fleet_info();
    break;
  default:
  list_planets();
  break;
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
