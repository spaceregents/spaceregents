<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/planets.inc.php";

if ($not_ok)
  return 0;

// Bis hier immer so machen:)

function proc_start_mission($cid,$uid,$target)
{
  $sth=mysql_query("select * from covertops where uid=$uid and cid='".$cid."' and target='".$target."'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_error("You can only start a mission once per target!");
    show_status();
    return 0;
  }

  $sth=mysql_query("select * from covertopsmissions as c , research as r where c.techdepend=r.t_id and r.uid=$uid and c.id=$cid");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("bbbblllllllllllll");
    return 0;
  }

  $covertops=mysql_fetch_array($sth);

  $sth=mysql_query("insert into covertops (count,uid,time,target,cid) values ('".$covertops["count"]."','$uid','".$covertops["time"]."','".$target."','".$covertops["id"]."')");

  if (!$sth)
  {
    show_error("ERR::INSERT COVERTOPS");
    return false;
  }

  $sth=mysql_query("update ressources set metal=metal-".$covertops["metal"].",gortium=gortium-".$covertops["gortium"].",energy=energy-".$covertops["energy"].",mopgas=mopgas-".$covertops["mopgas"].",erkunum=erkunum-".$covertops["erkunum"].",susebloom=susebloom-".$covertops["susebloom"]." where uid=$uid");

  if (!$sth)
  {
    show_error("ERR::UPDATE RESSOURCES");
    return false;
  }
}

function show_status()
{
  global $uid;
  global $PHP_SELF;

  table_start("center","500");
  table_head_text(array("Agents Status"),"2");
  table_text_open("head");
  table_text_design("&nbsp;","","","2");
  table_text_close();


  $sth=mysql_query("select sum(population) from planets where uid=$uid");

  if (!$sth)
    {
      show_error("Database error!");
      return 0;
    }

  $pop=mysql_fetch_row($sth);

  $spies=floor($pop[0]/1000);

  $sth=mysql_query("select sum(count) from covertops where uid=$uid");

  if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

  $count=mysql_fetch_row($sth);

  if ($count[0]==NULL)
    $count[0]=0;

  if (($count[0]==0) and ($spies==0))
    {
      show_message("You don't have enough population to do any covertops!");
      return 0;
    }

  $counter_spies=$spies-$count[0];

  if ($counter_spies<0)
    $counter_spies=0;

  table_text_open("text","center");
  table_text_design("Counter-Espionage","250");
  table_text_design("on Mission","250");
  table_text_close();
  table_text_open("text","center");
  table_text_design($counter_spies,"250");
  table_text_design($count[0],"250");
  table_text_close();
  table_end();
  echo("<br><br>\n");

  $sth=mysql_query("select cm.descr,c.count,c.time,c.target,cm.targettype from covertops as c, covertopsmissions as cm where c.uid=$uid and c.cid=cm.id");

  if (!$sth)
    {
      show_message("Database failure!");
      return 0;
    }

  if (mysql_num_rows($sth)>0)
    {
      table_start("center","500");
      table_head_text(array("Mission Information"),"5");
      table_text_open("head");
      table_text_design("&nbsp;","","","5","head");
      table_text_close();
      table_text(array("&nbsp;","&nbsp;","Time","Agents","Target"),"center","","","text");

      while ($ops=mysql_fetch_array($sth))
 {
   switch ($ops["targettype"])
     {
     case "I":
       $sth1=mysql_query("select imperium from users where id=".$ops["target"]);

       if (!$sth1)
  {
    show_error("Database failure!");
    return 0;
  }

       $target=mysql_fetch_row($sth1);
       break;
     case "P":
       $sth1=mysql_query("select name from planets where id=".$ops["target"]);

       if (!$sth1)
  {
    show_error("Database failure!");
    return 0;
  }

       $target=mysql_fetch_row($sth1);

       if ($target[0]=="")
  $target[0]="Unnamed";
       break;
     }

      table_text_open("head","center");
      table_text_design("<a href='manual/c_help.html'><img src='arts/10.jpg' border='0' width='75' height='50' alt='description'></a>","75");
      table_text_design($ops["descr"],"200");
      table_text_design($ops["time"],"50");
      table_text_design($ops["count"],"50");
      table_text_design($target[0],"125");
      table_text_close();

 }

      table_end();
   echo("<br><br>\n");
    }


  if ($counter_spies>0)
    {
      $sth=mysql_query("select * from covertopsmissions as c , research as r where c.techdepend=r.t_id and r.uid=$uid");

      if (!$sth)
 {
   show_error("Database error!");
   return 0;
 }

      table_start("center","500");
      table_head_text(array("Start new mission"),"12");
      table_text(array("&nbsp;"),"","","12","text");
      table_text_open("head","center");
      table_text_design("&nbsp;","230");
      table_text_design("<img src=\"arts/metal.gif\">","30");
      table_text_design("<img src=\"arts/energy.gif\">","30");
      table_text_design("<img src=\"arts/mopgas.gif\">","30");
      table_text_design("<img src=\"arts/erkunum.gif\">","30");
      table_text_design("<img src=\"arts/gortium.gif\">","30");
      table_text_design("<img src=\"arts/susebloom.gif\">","30");
      table_text_design("Agents","80");
      table_text_design("Target","80");
      table_text_design("Chance","80");
      table_text_design("Special info","100");
      table_text_design("&nbsp;","20");
      table_text_close();

      while ($covertops=mysql_fetch_array($sth))
 {
   if ($covertops["resspend"]=="T")
     $special="Costs these Ressources every tick!<br>";


   if ($covertops["depend"]!="0")
     $special=$special."Depends on <a href=\"".$PHP_SELF."?act=show_mission&id=".$covertops["depend"]."\">this.</A><br>";

   switch ($covertops["targettype"])
     {
     case "P":
       $target="Planet";
       break;
     case "I":
       $target="Imperium";
       break;
     }

   if (!$special)
     $special="&nbsp;";

   table_text(array($covertops["descr"],$covertops["metal"],$covertops["energy"],$covertops["mopgas"],$covertops["erkunum"],$covertops["gortium"],$covertops["susebloom"],$covertops["count"],$target,$covertops["chance"]."%",$special,"<a href='".$PHP_SELF."?act=start_mission&id=".$covertops["id"]."'><img src='arts/spy.jpg' border='0' width='20' height='20' alt='start covert ops'></a>"),"center","","","text");


 }

      table_end();
    }
  else
    show_message("You don't have any unassigned Spies!");
}

function start_mission()
{
  global $id;
  global $uid;
  global $PHP_SELF;
  global $imperium;
  global $pid;

  $sth=mysql_query("select sum(population) from planets where uid=$uid");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  $pop=mysql_fetch_row($sth);

  $spies=floor($pop[0]/1000);

  $sth=mysql_query("select sum(count) from covertops where uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $count=mysql_fetch_row($sth);

  if ($count[0]==NULL)
    $count[0]=0;

  if (($count[0]==0) and ($spies==0))
  {
    show_message("You don't have enough population to do any covertops!");
    return 0;
  }

  $sth=mysql_query("select * from covertopsmissions as c , research as r where c.techdepend=r.t_id and r.uid=$uid and c.id=$id");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("bbbblllllllllllll");
    return 0;
  }

  $covertops=mysql_fetch_array($sth);

  if (($spies-$count[0])<$covertops["count"])
  {
    show_message("You don't have enough free spies!");
    return 0;
  }

  $sth=mysql_query("select c.id from covertopsmissions as c,ressources as r where c.metal<=r.metal and c.energy<=r.energy and c.mopgas<=r.mopgas and c.erkunum<=r.erkunum and c.gortium<=r.gortium and c.susebloom<=r.susebloom and r.uid=$uid and c.id=$id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("You don't have enough ressources to start this mission!");
    show_status();
    return 0;
  }


  if ($imperium!="")
  {
    //$sth=mysql_query("select id from users where imperium='".addslashes($imperium)."' and id!=$uid");
    $sth=mysql_query("select id from users where imperium='".$imperium."' and id!=$uid");

    if (!$sth)
    {
      show_error("Database error!");
      return 0;
    }

    if (mysql_num_rows($sth)==0)
    {
      show_message("Hund! 1");
      return 0;
    }

    if ($covertops["targettype"]=="P" && $pid=="")
    {
      $sth=mysql_query("select id from users where imperium='$imperium'");

      if (!$sth)
      {
  show_error("Database failure13!");
  return 0;
      }

      $uid_target=mysql_fetch_array($sth);

      $sth=mysql_query("select id,name from planets where uid=".$uid_target["id"]." order by name");

      if (!$sth)
      {
  show_error("Database failure!12");
  return 0;
      }

      while ($planets=mysql_fetch_array($sth))
      {
  if ($planets["name"]=="Unnamed")
    $planets["name"] = get_planetname($planets["id"]);

  $select[$planets["name"]] = $planets["id"];
      }

      echo("<form action=\"".$PHP_SELF."\" method=post>");


      table_start("center","500");
      table_head_text(array("Mission: ".$covertops["descr"]),"2");
      table_text(array("&nbsp;"),"","","2","center","head");
      table_text_open("text","center");
      table_text_design("<img src='arts/idnummer.jpg' width='75' height='50' alt='".$covertops["descr"]."'>","75");
      table_text_design($covertops["descr"],"425");
      table_text_close();

      table_text_open("text","center");
      table_text_design("Target empire","75");
      table_text_design($imperium,"425");
      table_text_close();

      table_text_open("text","center");
      table_text_design("Time","75");
      table_text_design($covertops["time"],"425");
      table_text_close();

      table_text_open("text","center");
      table_text_design("Special Info","75");
      table_text_design("dummy","425");
      table_text_close();

      table_form_select("Select the targetplanet","pid",$select,"2","text","text");
      table_form_submit("Start","start_mission","2","text");
      table_end();
      form_hidden("imperium",$imperium);
      form_hidden("id",$id);
      echo("</form>");
      table_end();
    }
    elseif ($covertops["targettype"]=="P")
    {
      $sth=mysql_query("select id from planets where id=$pid and uid!=$uid and uid!=0");

      if (!$sth)
      {
  show_error("Database failure!1");
  return 0;
      }

      if (mysql_num_rows($sth)==0)
      {
  show_error("Hund! 2");
  return 0;
      }

      proc_start_mission($covertops["id"],$uid,$pid);

      show_status();
    }
    else
    {
      $sth=mysql_query("select id from users where id!=$uid and imperium='$imperium'");

      if (!$sth)
      {
  show_error("Database failure1!");
  return 0;
      }

      if (mysql_num_rows($sth)==0)
      {
  show_message("Du Klobrillenvergewaltiger!");
  return 0;
      }

      $target_uid=mysql_fetch_array($sth);

      proc_start_mission($covertops["id"],$uid,$target_uid["id"]);

      show_status();
    }
  }
  else
  {
    $sth=mysql_query("select imperium from users where id!=$uid order by imperium");

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    while ($imperiums=mysql_fetch_array($sth))
      $select[$imperiums["imperium"]]=$imperiums["imperium"];

    echo("<form action=\"".$PHP_SELF."\" method=post>");

    table_start("center","500");
    table_head_text(array("Mission: ".$covertops["descr"]),"2");
    table_text(array("&nbsp;"),"","","2","head");
    table_text_open("text","center");
    table_text_design("<img src='arts/o".$covertops["id"].".jpg' width='75' height='50' alt='".$covertops["descr"]."'>","75");
    table_text_design($covertops["descr"],"425");
    table_text_close();

    table_text_open("text","center");
    table_text_design("Time","75");
    table_text_design($covertops["time"],"425","head");
    table_text_close();

    table_text_open("text","center");
    table_text_design("Special Info","75");
    table_text_design("dummy","425","head");
    table_text_close();

    table_form_select("Select the target empire","imperium",$select,"","text","text");
    table_form_submit("Start","start_mission","2","text");

    table_end();
    form_hidden("id",$id);
    echo("</form>");
  }
}

switch ($act)
{
 case "start_mission":
   start_mission();
   break;
 default:
   show_status();
 break;
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
