<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/systems.inc.php";

if ($not_ok)
  return 0;

// Bis hier immer so machen

function show_planet()
{
  global $uid;
  global $pid;

  $sth=mysql_query("select * from planets where id=$pid");

  if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }
  
  $planet=mysql_fetch_array($sth);

  if ($planet["name"]=="unnamed")
    $planet["name"]=get_planetname($planet["id"]);
  
  center_headline("Planet ".$planet["name"]);
  
  if ($planet["uid"]==0)
    $owner["name"]="Nobody";

  else
    {
      $sth=mysql_query("select u.name from users as u where u.id=".$planet["uid"]);
      
      if (!$sth)
 {
   show_error("Database failure!");
   return 0;
 }
      
      $owner=mysql_fetch_array($sth);

      $sth=mysql_query("select a.name from alliance as a,users as u where a.id=u.alliance and u.id=".$planet["uid"]);

      if (mysql_num_rows($sth)==0)
 $alliance["name"]="No alliance";
      else
 $alliance=mysql_fetch_array($sth);

    }

  table_border_start("center","","#302859","#100666","#D2CCF9");
  echo("<tr>\n");
  echo(" <td rowspan=\"13\">\n");
  echo("   <img src=\"arts/".$planet["type"].".jpg\">\n");
  echo(" <td>\n");
  echo("</tr>\n");
  table_head_text(array("Information"),"2");
  table_text_open();
  table_text_design("Owner","","center","1","head");
  table_text_design($owner["name"],"","center","1","text");
  table_text_close();  
  
  if ($planet["uid"]!=0)
  table_text_open();
  table_text_design("Alliance","","center","1","head");
  table_text_design($alliance["name"],"","center","1","text");
  table_text_close();  
  table_text_open();
  table_text_design("Population","","center","1","head");
  table_text_design($planet["population"],"","center","1","text");
  table_text_close();  
  table_text_open();
  table_text_design("Planettype","","center","1","head");
  table_text_design($planet["type"],"","center","1","text");
  table_text_close();  

  if ($planet["uid"]==0)
    {
      switch ($planet["type"])
 {
 case "E":
   $bewohnbar=true;
   break;
 case "O":
   $bewohnbar=true;
   break;
 case "M":
   $bewohnbar=true;
   break;
 case "D":
   $bewohnbar=true;
   break;
 case "I":
   $bewohnbar=true;
   break;
 case "A":
   $bewohnbar=true;
   break;
 case "R":
   $bewohnbar=true;
   break;
 default:
   $bewohnbar=false;
 }

      if ($bewohnbar)
  {  
    table_text_open();
      table_text_design("Habitable","","center","1","head");
      table_text_design("<font color=\"green\">Yes</font>","","center","1","text");
    table_text_close();  
  }
      else
    {
    table_text_open();
      table_text_design("Habitable","","center","1","head");
      table_text_design("<font color=\"red\">No</font>","","center","1","text");
    table_text_close();  
    }
    }

    table_text_open();
      table_text_design("<img src=\"arts/metal.gif\" title=\"Metal\" alt=\"Metal\">","","center","1","head");
      table_text_design($planet["metal"],"","center","1","text");
    table_text_close();  
    table_text_open();
      table_text_design("<img src=\"arts/energy.gif\" title=\"Energy\" alt=\"Energy\">","","center","1","head");
      table_text_design($planet["energy"],"","center","1","text");
    table_text_close();  
    table_text_open();
      table_text_design("<img src=\"arts/mopgas.gif\" title=\"Mopgas\" alt=\"Mopgas\">","","center","1","head");
      table_text_design($planet["mopgas"],"","center","1","text");
    table_text_close();  
    table_text_open();
      table_text_design("<img src=\"arts/erkunum.gif\" title=\"Erkunum\" alt=\"Erkunum\">","","center","1","head");
      table_text_design($planet["erkunum"],"","center","1","text");
    table_text_close();  
    table_text_open();
      table_text_design("<img src=\"arts/gortium.gif\" title=\"Gortium\" alt=\"Gortium\">","","center","1","head");
      table_text_design($planet["gortium"],"","center","1","text");
    table_text_close();  
    table_text_open();
      table_text_design("<img src=\"arts/susebloom.gif\" title=\"Susebloom\" alt=\"Susebloom\">","","center","1","head");
      table_text_design($planet["susebloom"],"","center","1","text");
    table_text_close();  
  table_end();
  echo("<br><br>\n");

  echo("<center>\n");
  echo("<a href=\"plmapgen.php?id=".$planet["sid"]."\" target=\"_parent\">view solar system</a>\n");
  if ($planet["uid"]==$uid)
    echo("<a href=\"production.php?act=Production&pid=".$planet["id"]."\">production</a>\n");
  echo("</center>\n");

  echo("<br><br>\n");

  return $bewohnbar;
}

//**************************************************************************************************************************
function show_fleets()
{
  global $uid;
  global $pid;
  global $bewohnbar;
  global $PHP_SELF;
  
  $sth=mysql_query("select a.milminister, u.alliance from alliance as a, users as u where a.id=u.alliance and u.id=$uid");
  
  if (!$sth)
   {
    show_message("Database Failure");
 return 0;
   }
  
  $minister=mysql_fetch_array($sth);
  
  if ($minister["milminister"]==$uid)
   {
    table_start("center","500");
 table_text(array("<a href=\"".$PHP_SELF."?act=show_fleets&pid=".$pid."&bewohnbar=".$bewohnbar."\">Show your own fleets</a>","<a href=\"".$PHP_SELF."?act=show_available_fleets&pid=".$pid."&bewohnbar=".$bewohnbar."\">Show fleets assigned to you</a>"));
 table_end();
   }

  $sth=mysql_query("select f.*,fi.*,p.typ,p.special from fleet as f,production as p left join fleet_info as fi on fi.fid=f.fid where fi.uid='$uid' and p.prod_id=f.prod_id order by f.fid");  

  if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

  if (mysql_num_rows($sth)==0)
    return 0;

  table_start("center","80%");
  table_head_text(array("Fleets"),"9");
  table_text(array("&nbsp;"),"","","9","text");
  table_text(array("Fleet name","Light Ships","Medium Ships","Heavy Ships","Current Mission","New Mission","Status","ETA","&nbsp;"),"center","","","head");

  while ($part_fleet=mysql_fetch_array($sth))
    {
      if ($part_fleet["fid"]!=$fid_old)
 {
   $fid_old=$part_fleet["fid"];
   $counter++;
 }
      $fleet[$counter][]=$part_fleet;
    }
  
  for ($i=1;$i<=sizeof($fleet);$i++)
    {
      $light="";
      $medium="";
      $heavy="";
      for ($j=0;$j<sizeof($fleet[$i]);$j++)
 {
   if ($fleet[$i][$j]["typ"]=="L")
     $light+=$fleet[$i][$j]["count"];
   if ($fleet[$i][$j]["typ"]=="M")
     $medium+=$fleet[$i][$j]["count"];
   if ($fleet[$i][$j]["typ"]=="H")
     $heavy+=$fleet[$i][$j]["count"];
   if ($fleet[$i][$j]["special"]=="O")
     $fleet[$i][0]["orbital_colony"]="O";
 }

 switch ($fleet[$i][0]["mission"])
 {
 case "0":
   $mission_text["a"]="Defending";
   $mission_text["b"]="defend";
   break;
 case "1":
   $mission_text["a"]="Attacking";
   $mission_text["b"]="attack";
   break;
 case "2":
   $mission_text["a"]="Intercepting fleets in";
   $mission_text["b"]="intercept fleets in";
   break;
 case "4":
   $mission_text["a"]="";
   $mission_text["b"]="colonize";
   break;
 case "5":
   $mission_text["a"]="Invading";
   $mission_text["b"]="invade";
 }

 if (($fleet[$i][0]["pid"]!=0) and ($fleet[$i][0]["tsid"]==0) and ($fleet[$i][0]["tpid"]==0))
 {
   $planetname=get_planetname($fleet[$i][0]["pid"]);
   
   $mission=$mission_text["a"]." planet ".$planetname;
 }
      
      if (($fleet[$i][0]["pid"]==0) and ($fleet[$i][0]["tsid"]==0) and ($fleet[$i][0]["tpid"]==0))
      {
        $systemname=get_systemname($fleet[$i][0]["sid"]);
        $mission=$mission_text["a"]." system ".$systemname;
      }

      if (($fleet[$i][0]["tsid"]!=0) and ($fleet[$i][0]["tpid"]==0))
      {
        $systemname=get_systemname($fleet[$i][0]["sid"]);
        $mission="On its way to ".$mission_text["b"]." system ".$systemname;
      }

      if (($fleet[$i][0]["tsid"]!=0) and ($fleet[$i][0]["tpid"]!=0))
      {
        $planetname=get_planetname($fleet[$i][0]["tpid"]);
        $mission="On its way to ".$mission_text["b"]." planet ".$planetname;
      }

      if (($fleet[$i][0]["sid"]!=0) and ($fleet[$i][0]["pid"]==0) and ($fleet[$i][0]["tsid"]==0))
      {
        $systemname=get_systemname($fleet[$i][0]["sid"]);
        $mission=$mission_text["a"]." system ".$systemname;
      }

      $sth=mysql_query("select x,y,id from systems where id=".$fleet[$i][0]["sid"]);

      $system=mysql_fetch_array($sth);

      $sth=mysql_query("select s.x,s.y,s.id from systems as s,planets as p where s.id=p.sid and p.id=$pid");

      $targetsystem=mysql_fetch_array($sth);

      if ($targetsystem["id"]==$system["id"])
      {
        $eta="Already here!";
      }
      else
      {
        $sth1=mysql_query("select max(w.range) from warp as w,research as r where w.tid=r.t_id and r.uid=".$uid);

        $range=mysql_fetch_row($sth1);

        if ($range[0]==NULL)
         {
           global $no_warp_tech;
           $range[0]=$no_warp_tech;
         }

        list($eta)=eta_to_planet($system["x"],$system["y"],$targetsystem["x"],$targetsystem["y"],$range[0],$old);

        if (!$eta)
         $eta="No route to system";
      }

      $sth=mysql_query("select uid from planets where id=$pid");

      if (!$sth)
      {
         show_error("Database failure!");
         return 0;
      }

      $planet_uid=mysql_fetch_array($sth);

      if (($planet_uid["uid"]==0) and ($fleet[$i][0]["orbital_colony"]=="O"))
        $obewohnbar=true;
      else
        $obewohnbar=false;

     if (($bewohnbar) or ($obewohnbar))
     {
       $colony="";

       $sth=mysql_query("select f.fid from fleet as f,colonyships as c where c.prod_id=f.prod_id and f.fid=".$fleet[$i][0]["fid"]);

       if (mysql_num_rows($sth)!=0)
         $colony="<option value=\"4\"> Colonize Planet";

     }

     $sth=mysql_query("select uid from planets where id=$pid and uid!=0 and uid!=$uid");

     if (mysql_num_rows($sth)!=0)
     {
       $invade="<option value=\"5\"> Invade Planet";
     }

     if ($fleet[$i][0]["pid"]==$pid)
     {
       $sth=mysql_query("select f.fid from inf_transporters as i,fleet as f where i.prod_id=f.prod_id and f.fid=".$fleet[$i][0]["fid"]);

       if (mysql_num_rows($sth)!=0)
         $transport="<option value=\"9\"> Transfer Infantery";
     }

     $new_mission="<select name=\"newmission\">\n";
     $new_mission=$new_mission."<option value=\"0\">Defend this planet<option value=\"1\">Attack this planet<option value=\"2\">Intercept Fleets".$colony.$transport.$invade."</select>";

     if ($fleet[$i][0]["reload"]==0)
       $status="<font color=\"green\">Ready";
     else
       $status="<font color=\"red\">Reloading ".$fleet[$i][0]["reload"]." turns";
 
     if ($light=="")
      $light="0";
     if ($medium=="")
      $medium="0";
     if ($heavy=="")
      $heavy="0";

     echo("<form action=\"".$PHP_SELF."\" method=post>");
     table_text(array(($fleet[$i][0]["name"])."<input type=hidden name=\"fid\" value=\"".$fleet[$i][0]["fid"]."\"",$light,$medium,$heavy,$mission,$new_mission,$status,$eta,"<input type=hidden name=\"act\" value=\"newmission\"><input type=hidden name=\"pid\" value=\"".$pid."\"><input type=submit value=\"Execute\""),"center","","","text");
     echo("</form>");
   }
   table_end();
 }

function eta_to_planet($x,$y,$tx,$ty,$range,$old,$count="0")
{
  if (!is_array($old))
    $old=array();

// is das System schon in Reichweite???

  $count++;

  $temp_x1=$tx-$x;
  $temp_x2=$ty-$y;

  $temp_betrag=sqrt(($temp_x1*$temp_x1)+($temp_x2*$temp_x2));

  $sth=mysql_query("select id from systems where ".($range).">=".$temp_betrag." and x=".$tx." and y=".$ty);
  
  if (mysql_num_rows($sth)!=0)
  {
    reset ($old);

    for($i=0;$i<sizeof($old);$i++)
    {
      reset ($old[$i]);

      list($x,$y)=each($old[$i]);
      
      $sth1=mysql_query("select id from systems where x=$x and y=$y");

      if (!$sth1)
      {
 show_error("Database failure!");
 return 0;
      }

      list($systemid)=mysql_fetch_row($sth1);

      $route[]=$systemid;
    }
    
    $target=mysql_fetch_row($sth);
    $route[]=$target[0];
    return array($count++,$route);
  }
      
  // Ersma Zielvektor berechnen
  
  $x1=$tx-$x;
  $x2=$ty-$y;
  
  // Betrag berechnen
  
  $betrag=sqrt((($x1*$x1)+($x2*$x2)));

  //echo("Betrag: ".$betrag."\n");
  
  // Vektor auf Länge $range abschneiden und zum Ortsvektor machen
  
  $x1=$x1*($range/$betrag)+$x;
  $x2=$x2*($range/$betrag)+$y;
  
  /* Naechste System suchen
  Erster Abschnitt : Abstand der Systeme vom temp. Vektor
  Zweiter Abschnitt: Nur die Systeme , für die der Abstand vom jetzigen System auch der max. Sprungweite entspricht
  */

  if (is_array($old))
    {
      for ($i=0;$i<sizeof($old);$i++)
 {
   reset($old[$i]);
   list($key,$value)=each($old[$i]);
   $excl=$excl." and x!=".$key." and y!=".$value;
 }
    }
  else
    $i=0;

  $sth=mysql_query("select sqrt((x-".$x1.")*(x-".$x1.")+(y-".$x2.")*(y-".$x2.")),x,y,id from systems where ".($range).">=sqrt((x-".$x.")*(x-".$x.")+(y-$y)*(y-$y)) and x!=".$x." and y!=".$y.$excl." order by 1 limit 1");
  
  if (mysql_num_rows($sth)==0)
    return false;
  
  $system=mysql_fetch_array($sth);
  
  //echo("ID ist: ".$system["id"]."\n");

  $old[$i++][$x]=$y;

  $way=eta_to_planet($system["x"],$system["y"],$tx,$ty,$range,$old,$count);
  
  if ($way)
    {
      //echo($system["id"]."\n");
      return $way;
    }
  
  return false;
  

}

function transfer_infantery($uid,$fid,$pid)
{
  global $PHP_SELF;

  $sth=mysql_query("select id from planets where uid='".$uid."' and id='".$pid."'");

  if (mysql_num_rows($sth)==0)
    return 0;

  $planet=mysql_fetch_array($sth);

  $planetname = get_planetname($planet["id"]);

  $sth=mysql_query("select uid,name from fleet_info where uid=$uid and fid=$fid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Stop that!");
    return 0;
  }
  
  $itsFleet = mysql_fetch_array($sth);

  $sth=mysql_query("select i.*,p.name,v.tonnage as storage from infantery as i,production as p,shipvalues as v where i.pid=$pid and i.uid=$uid and i.prod_id=p.prod_id and i.prod_id = v.prod_id order by prod_id");

  if (mysql_num_rows($sth)>0)
    {
   echo("<form action=\"".$PHP_SELF."?who=1\" method=post>");
   table_start("center","500");   
   table_head_text(array("planet ".$planetname,"5"));
   table_text(array("unit","count","tonnage / unit","total tonnage","&nbsp;"),"","","","smallhead");
   
   while ($infantery=mysql_fetch_array($sth))
     {
        $tempTotalSpace = $infantery["count"] * $infantery["storage"];  
       table_text(array($infantery["name"],$infantery["count"],$infantery["storage"]." t",$tempTotalSpace." t","<input name=\"count[".$infantery["prod_id"]."]\">"),"","","","text");
     }
   form_hidden("fid",$fid);
   form_hidden("pid",$pid);
   table_form_submit("Transfer to fleet ".$itsFleet["name"],"transfer",5);
   table_end();
   echo("</form>");
    }

 $sth = mysql_query("select sum(f.count*i.storage) from fleet as f,inf_transporters as i where f.fid=$fid and i.prod_id = f.prod_id"); 
//  $sth=mysql_query("select sum(f.count*i.storage) from inf_transporters as i,fleet as f where f.fid=$fid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $total_space=mysql_fetch_row($sth);

  $sth=mysql_query("select i.count,iv.tonnage as storage,p.name,i.prod_id from inf_transports as i,shipvalues as iv,production as p where p.prod_id=i.prod_id and p.prod_id=iv.prod_id and i.prod_id=iv.prod_id and i.fid=$fid");
  
  if (mysql_num_rows($sth)>0)
   {
      $spacetaken=0;
   echo("<form action=\"".$PHP_SELF."?who=2\" method=post>");
   table_start("center","500");
   table_head_text(array("Fleet"),"5");
   table_text(array("unit","count","space/unit","space used","&nbsp;"),"","","","smallhead");
 
   while ($infantery=mysql_fetch_array($sth))
     {
       table_text(array($infantery["name"],$infantery["count"],$infantery["storage"]." t",($infantery["storage"]*$infantery["count"])." t","<input name=\"count[".$infantery["prod_id"]."]\">"),"","","","text");
       $spacetaken+=($infantery["storage"]*$infantery["count"]);
     }
   table_text(array("&nbsp;"),"","","5","head");
   table_text_open();
   table_text_design("Total space","","","3","head");
   table_text_design($total_space[0]." t","","","2","text");
   table_text_close();
   table_text_open();
   table_text_design("space used","","","3","head");
   table_text_design($spacetaken." t","","","2","text");
   table_text_close();
   table_text_open();
   table_text_design("space left","","","3","head");
   table_text_design($total_space[0]-$spacetaken." t","","","2","text");
   table_text_close();
   form_hidden("fid",$fid);
   form_hidden("pid",$pid);
   table_form_submit("Transfer to planet","transfer",5);
   table_end();
   echo("</form>");
   }   
}

function transfer()
{
  global $count;
  global $pid;
  global $fid;
  global $uid;
  global $who;

  reset($count);

  switch ($who)
  {
  case "1":
    while (list($key,$value)=each($count))
      {
        if ($value<0)
       {
        show_message("You can not transfer negative numbers! =P");
        $value=0;
       }
        if ($value=="")
          $value=0;
  
        $sth=mysql_query("select * from infantery where pid=$pid and count>=$value and prod_id=$key");
        
        if (mysql_num_rows($sth)==0)
    {
      show_message("Can't proceed your request (Did you select more units than you have?:)");
      return 0;
    }
        $sth=mysql_query("select tonnage as storage from shipvalues where prod_id=$key");
        
        $stor_temp=mysql_fetch_row($sth);
  
        $stor_needed+=$stor_temp[0]*$value;
      }
  
    $sth=mysql_query("select * from inf_transporters as i,fleet_info as fi left join fleet as f on f.fid=fi.fid and f.prod_id=i.prod_id where fi.pid=$pid and f.prod_id is not null");
  
    while ($transportships=mysql_fetch_array($sth))
      {
        $stor_avail+=$transportships["storage"]*$transportships["count"];
      }
    
    $sth=mysql_query("select * from inf_transports as it , shipvalues as iv where it.fid=$fid and it.prod_id=iv.prod_id");
  
    while ($transports=mysql_fetch_array($sth))
      {
        $stor_avail-=$transports["tonnage"]*$transports["count"];
      }
  
    if ($stor_needed>$stor_avail)
      {
        show_message("You don't have enough Tranporters!");
        return 0;
      }
    
    reset($count);
  
    while (list($key,$value)=each($count))
      {
      if ($value<=0)
        $value=0;
        if ($value=="")
        $value=0;
      
        if ($count>0)
    {
      $sth=mysql_query("select prod_id from inf_transports where prod_id=".$key." and fid=$fid");
      
      if (mysql_num_rows($sth)==0)
        $sth=mysql_query("insert into inf_transports (fid,prod_id,count) values ('".$fid."','".$key."','".$value."')");
      else
        $sth=mysql_query("update inf_transports set count=count+".$value." where prod_id=$key and fid=$fid");      
      
      $sth=mysql_query("update infantery set count=count-".$value." where prod_id=".$key." and pid=$pid");
      
      $sth=mysql_query("delete from infantery where count=0");
    }
      }
    show_message("Units have been transfered to local fleet");
    break;
  case "2":
    while (list($key,$value)=each($count))
      {
        if ($value<=0)
       {
        $value=0;
       }
        if ($value=="")
        $value=0;
  
        $sth=mysql_query("select * from inf_transports where fid=$fid and count>=$value and prod_id=$key");
        
        if (mysql_num_rows($sth)==0)
    {
      show_message("Can't proceed your request (Did you select more units than you have?:)");
      return 0;
    }
        $sth=mysql_query("select tonnage as storage from shipvalues where prod_id=$key");
        
        $stor_temp=mysql_fetch_row($sth);
  
        $stor_needed+=$stor_temp[0]*$value;
      }
        
    reset($count);
  
    while (list($key,$value)=each($count))
      {
      if ($value<=0)
        $value=0;
        if ($value=="")
        $value=0;
      
        if ($count>0)
    {
      $sth=mysql_query("select prod_id from infantery where prod_id=".$key." and pid=$pid");
      
      if (mysql_num_rows($sth)==0)
        $sth=mysql_query("insert into infantery (prod_id,count,pid,uid) values ('".$key."','".$value."','".$pid."','".$uid."')");
      else
        $sth=mysql_query("update infantery set count=count+".$value." where prod_id=$key and pid=$pid");      
      
      $sth=mysql_query("update inf_transports set count=count-".$value." where prod_id=".$key." and fid=$fid");
      
      $sth=mysql_query("delete from inf_transports where count=0");
    }
      }
    show_message($value." Units have been stationed on planet");
   break;
 }

}

function newmission()
{
  global $uid;
  global $fid;
  global $newmission;
  global $behaviour;
  global $pid;

  if ($newmission==9)
    {
      transfer_infantery($uid,$fid,$pid);
      return 0;
    }
 
  $sth=mysql_query("select u.*, a.* from users as u, alliance as a where u.id='$uid' and u.alliance=a.id");
  
  $alliance=mysql_fetch_array($sth);

  if ($uid==$alliance["milminister"])
   {
    $sth=mysql_query("select uid,fid,sid from fleet_info where fid=$fid and ".$alliance["milminister"]."=$uid");
 
  if (!$sth)
   {
    show_message("Database Failure AUA 0");
    return 0;
   }
   }
  else
   $sth=mysql_query("select fid, sid, name from fleet_info where fid=$fid and uid=$uid");

  if (mysql_num_rows($sth)==0)
    {
      show_error("Don't try to hack...please:)");
      return 0;
    }

  $fleet=mysql_fetch_array($sth);
  
  if (($newmission<0) and ($newmission>4) and ($newmission!=2) and ($newmission!=3) and ($newmission!=5))
    {
      echo($newmission);
      show_error("Arghs...Idiot1!...DON'T TRY TO MODIFY MY VALUES. hmmm...bier");
      return 0;
    }

  if (($behaviour!=0) and ($behaviour!=1))
    {
      show_error("Arghs...Idiot!...DON'T TRY TO MODIFY MY VALUES. hmmm...bier");
      return 0;
    }
  
  if ($newmission==4)
  {

    $sth=mysql_query("select * from planets where id=$pid");
      
    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }  
      
      
    $planet=mysql_fetch_array($sth);

    if ($planet["uid"]==0)
    {
     switch ($planet["type"])
      {
       case "E":
         $bewohnbar=true;
         break;
       case "O":
         $bewohnbar=true;
         break;
       case "M":
         $bewohnbar=true;
         break;
       case "D":
         $bewohnbar=true;
         break;
       case "I":
         $bewohnbar=true;
         break;
       case "A":
         $bewohnbar=true;
         break;
       case "R":
         $bewohnbar=true;
         break;
       default:
         $bewohnbar=false;
      }
    }

 if (!$bewohnbar)
 {
   $sth=mysql_query("select f.fid from fleet as f,production as p where f.prod_id=p.prod_id and f.fid=$fid and p.special='O'");

   if (!$sth)
   {
     show_error("Database failuer!");
     return 0;
   }

   if (mysql_num_rows($sth)==0)
   {
     show_error("Planet is not habitable");
     return 0;
   }

   $sth=mysql_query("select uid from planets where id=$pid");

   if (!$sth)
   {
     show_error("Database failure!");
     return 0;
   }
  
   $planet_uid=mysql_fetch_array($sth);

   if ($planet_uid["uid"]==0)
     $obewohnbar=true;
   else
   {
     show_error("This planet is already colonised!");
     return 0;
   }
 }

  }

  if (($newmission==1) or ($newmission==5) or ($newmission==3))
  {
    $sth=mysql_query("select homeworld from users where homeworld=$pid");

    if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }

    if (mysql_num_rows($sth)>0)
    {
      show_error("You can't attack a homeworld by rules of galactic law!");
      return 0;
    }
  }

  $sth=mysql_query("select sid from planets where id=$pid");

  $sid=mysql_fetch_array($sth);

  $sth=mysql_query("select cid from systems where id=".$sid["sid"]."");

  $cid=mysql_fetch_array($sth);

  $sth=mysql_query("select x,y from systems where id=".$sid["sid"]);

  $targetsystem=mysql_fetch_array($sth);
  
  $sth=mysql_query("select x,y from systems where id=".$fleet["sid"]);

  $homesystem=mysql_fetch_array($sth);

  $sth1=mysql_query("select max(w.range) from warp as w,research as r where w.tid=r.t_id and r.uid=".$uid);
 
  $range=mysql_fetch_row($sth1);

  if ($range[0]==NULL)
  {
      global $no_warp_tech;
      $range[0]=$no_warp_tech;
  }

  $eta=eta_to_planet($homesystem["x"],$homesystem["y"],$targetsystem["x"],$targetsystem["y"],$range[0],$old);

  if (!$eta)
  {
    show_message("Can't reach system!");
    return 0;
  }
  
  if ($newmission==2)
    $pid_temp=0;
  else
    $pid_temp=$pid;
  
  $sth=mysql_query("update fleet_info set tsid='".$sid["sid"]."',tpid='".$pid_temp."',mission='".$newmission."' where fid=$fid");
  

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("replace into routes set route='".addslashes(serialize($eta[1]))."',fid=$fid");

  if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }
 
  if (($uid==$alliance["milminister"]) && ($uid != $fleet["uid"]))
  {
    
    switch ($newmission)
    {
      case "0":
        $newmission="DEFEND planet";
        $targetname = get_planetname($pid);
      break;
      case "1":     
        $newmission="ATTACK planet";
        $targetname = get_planetname($pid);
      break;
      case "2":     
        $newmission="INTERCEPT in system";
        $targetname = get_systemname($sid["sid"]);
      break;
      case "3":     
        $newmission="BOMB planet";
        $targetname = get_systemname($pid);
      break;
      case "5":
        $newmission="INVADE planet";
        $targetname = get_planetname($pid);
      break;
    }

    $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$fleet["uid"]."','a','MoD ordered your Fleet ".$fleet["name"]." to ".$newmission." ".$targetname."','".date("YmdHis")."')");
   
    if (!$sth1)
    {
      show_error("Database failure! AUA2");
      return 0;
    }
  }

  $sth=mysql_query("select fid from fleet_info where tpid=pid and tsid=sid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  while ($arrived_fleets=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("delete from routes where fid=".$arrived_fleets["fid"]);

    if (!$sth1)
    {
      show_error("Database failure!");
      return 0;
    }
  }

  $sth=mysql_query("update fleet_info set tpid=0,tsid=0 where tpid=pid and tsid=sid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

}

// *********************************************************************************************************************************
function show_available_fleets()
{
  global $uid;
  global $pid;
  global $bewohnbar;
  global $PHP_SELF;
  

    table_start("center","500");
 table_text(array("<a href=\"".$PHP_SELF."?act=show_fleets&pid=".$pid."&bewohnbar=".$bewohnbar."\">Show your own fleets</a>","<a href=\"".$PHP_SELF."?act=show_available_fleets&pid=".$pid."&bewohnbar=".$bewohnbar."\">Show fleets assigned to you</a>"));
 table_end();
  $sth=mysql_query("select a.milminister,a.id,u.alliance from alliance as a, users as u where a.milminister='$uid' and u.alliance = a.id");
  
  if (!$sth)
   {
    show_message("Database Failure 1");
 return 0;
   }
  
   if ($sth==0)
  {
   show_message("Not working! Fool >:o");
   return 0;
  }

  $sth=mysql_query("select f.*,p.typ,p.special from fleet as f,production as p where f.milminister='$uid' and p.prod_id=f.prod_id order by f.fid");  

  if (!$sth)
    {
      show_error("Database failure! 2");
      return 0;
    }

  if (mysql_num_rows($sth)==0)
    {
     center_headline("No allied fleets under your command");   
     return 0;
 }
  table_start("center","80%");
  table_head_text(array("Allied Fleets under your command"),"9");
  table_text(array("&nbsp;"),"","","9","text");
  table_text(array("Fleet number","Light Ships","Medium Ships","Heavy Ships","Current Mission","New Mission","Behaviour","ETA","&nbsp;"),"center","","","head");

  while ($part_fleet=mysql_fetch_array($sth))
    {
      if ($part_fleet["fid"]!=$fid_old)
 {
   $fid_old=$part_fleet["fid"];
   $counter++;
 }
      $fleet[$counter][]=$part_fleet;
    }
  
  for ($i=1;$i<=sizeof($fleet);$i++)
    {
      $light="";
      $medium="";
      $heavy="";
      for ($j=0;$j<sizeof($fleet[$i]);$j++)
 {
   if ($fleet[$i][$j]["typ"]=="L")
     $light+=$fleet[$i][$j]["count"];
   if ($fleet[$i][$j]["typ"]=="M")
     $medium+=$fleet[$i][$j]["count"];
   if ($fleet[$i][$j]["typ"]=="H")
     $heavy+=$fleet[$i][$j]["count"];
   if ($fleet[$i][$j]["special"]=="O")
     $fleet[$i][0]["orbital_colony"]="O";
 }

      switch ($fleet[$i][0]["mission"])
 {
 case "0":
   $mission_text["a"]="Defending";
   $mission_text["b"]="defend";
   break;
 case "1":
   $mission_text["a"]="Attacking";
   $mission_text["b"]="attack";
   break;
 case "4":
   $mission_text["a"]="Colonizing";
   $mission_text["b"]="colonize";
   break;
 case "5":
   $mission_text["a"]="Invading";
   $mission_text["b"]="invade";
 }

      if (($fleet[$i][0]["pid"]!=0) and ($fleet[$i][0]["tsid"]==0) and ($fleet[$i][0]["tpid"]==0))
       {
         $planetname = get_planetname($fleet[$i][0]["pid"]);   
         $mission=$mission_text["a"]." planet ".$planetname;
       }
      
      if (($fleet[$i][0]["pid"]==0) and ($fleet[$i][0]["tsid"]==0) and ($fleet[$i][0]["tpid"]==0))
 {
   $systemname = get_systemname($fleet[$i][0]["sid"]);
   $mission=$mission_text["a"]." system ".$systemname;
 }
      
      if (($fleet[$i][0]["tsid"]!=0) and ($fleet[$i][0]["tpid"]==0))
 {
   $systemname = get_systemname($fleet[$i][0]["tsid"]);
   
   $mission="On its way to ".$mission_text["b"]." system ".$systemname;
 }
      
      if (($fleet[$i][0]["tsid"]!=0) and ($fleet[$i][0]["tpid"]!=0))
 {
   $planetname = get_planetname($fleet[$i][0]["tpid"]);      
   $mission="On its way to ".$mission_text["b"]." planet ".$planetname;
 }

      $sth=mysql_query("select x,y,id from systems where id=".$fleet[$i][0]["sid"]);

      $system=mysql_fetch_array($sth);

      $sth=mysql_query("select s.x,s.y,s.id from systems as s,planets as p where s.id=p.sid and p.id=$pid");

      $targetsystem=mysql_fetch_array($sth);

      if ($targetsystem["id"]==$system["id"])
 {
   $eta="Already here!";
 }
      else
 {
   $sth1=mysql_query("select max(w.range) from warp as w,research as r where w.tid=r.t_id and r.uid=".$uid);
   
   $range=mysql_fetch_row($sth1);
   
   if ($range[0]==NULL)
     {
       global $no_warp_tech;
       $range[0]=$no_warp_tech;
     }
   
   $eta=eta_to_planet($system["x"],$system["y"],$targetsystem["x"],$targetsystem["y"],$range[0],$old);
  
   if (!$eta)
     $eta="No route to system";
   else
     $eta=$eta[0];
 }

      $sth=mysql_query("select uid from planets where id=$pid and uid!=0 and uid!=$uid");

      if (mysql_num_rows($sth)!=0)
 {
   $invade="<option value=\"5\"> Invade Planet";
 }

      if ($fleet[$i][0]["pid"]==$pid)
 {
   $sth=mysql_query("select f.fid from inf_transporters as i,fleet as f where i.prod_id=f.prod_id and f.fid=".$fleet[$i][0]["fid"]);

   if (mysql_num_rows($sth)!=0)
     $transport="<option value=\"9\"> Transfer Infantery";
 }

      $new_mission="<select name=\"newmission\">\n";
      $new_mission=$new_mission."<option value=\"0\">Defend this planet<option value=\"1\">Attack this planet".$transport.$invade."</select>";

      $behaviour="<select name=\"behaviour\">\n";
      
      if ($fleet[$i][0]["behaviour"]==0)
 {
   $behaviour=$behaviour."<option selected value=\"0\">Evasive";
   $behaviour=$behaviour."<option value=\"1\">Aggressive";
 }
      else
 {
   $behaviour=$behaviour."<option value=\"0\">Evasive";
   $behaviour=$behaviour."<option selected value=\"1\">Aggressive";
 }
      $behaviour=$behaviour."</select>";

      if ($light=="")
 $light="0";
      if ($medium=="")
 $medium="0";
      if ($heavy=="")
 $heavy="0";

      echo("<form action=\"".$PHP_SELF."\" method=post>");
      table_text(array(($k+=1)."<input type=hidden name=\"fid\" value=\"".$fleet[$i][0]["fid"]."\"",$light,$medium,$heavy,$mission,$new_mission,$behaviour,$eta,"<input type=hidden name=\"act\" value=\"newmission\"><input type=hidden name=\"pid\" value=\"".$pid."\"><input type=submit value=\"Execute\""),"center","","","text");
      echo("</form>");
    }
  table_end();
 }


switch ($act)
{
 default:
   $bewohnbar=show_planet();
} 

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
