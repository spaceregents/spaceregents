#!/usr/local/bin/php
<?
/*

Spaceregents Time Modul

*/
include "../spaceregentsconf/config.inc.php";

include "../spaceregentsinc/gp/dbwrap.inc";
include "../spaceregentsinc/func.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/alliances.inc.php";
include "../spaceregentsinc/users.inc.php";
include "../spaceregentsinc/admirals.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/research.inc.php";
include "../spaceregentsinc/population.inc.php";
include "../spaceregentsinc/class_graph_builder.inc.php";
include "../spaceregentsinc/domain.inc.php";

set_time_limit(3599);

function build_trade_statistic()
{
  $intervall = 48;      // zeige $intervall wochen an

  // color array
  $color_array["MET"] = "white";
  $color_array["ENE"] = "yellow";
  $color_array["MOP"] = "green";
  $color_array["ERK"] = "blue";
  $color_array["GOR"] = "red";
  $color_array["SUS"] = "purple";
  
  $title_array["MET"] = "Metal";
  $title_array["ENE"] = "Energy";
  $title_array["MOP"] = "Mopgas";
  $title_array["ERK"] = "Erkunum";
  $title_array["GOR"] = "Gortium";
  $title_array["SUS"] = "Susebloom";
  
  // get week
  $sth = mysql_query("SELECT week FROM timeinfo");
  
  if (!$sth || mysql_num_rows($sth)==0)
  {
    echo("ERROR:: GET WEEK");
    return false;
  }
  
  list($week) = mysql_fetch_row($sth);
  
  // get values and create curve arrays
  $sth = mysql_query("SELECT * FROM stockmarket_statistics where time > ".($week - $intervall)." ORDER BY time");
  
  if (!$sth)
  {
    echo("ERROR::GET STOCKMARKET STATS");
    return false;
  }
  
  if (mysql_num_rows($sth) > 0)
  {
    $stats          = array();
    $max_avg_price  = 0;
    
    while ($stats_query = mysql_fetch_array($sth))
      $stats[$stats_query["stockmarket"]][] = $stats_query["avg_price"];
  }


  // create the graph  
  if (is_array($stats))
  {
    $new_graph = new graph_builder("Average prices (experimental)", "../spaceregentsportal/portal/trade_stats.svg");
    $new_graph->set_size(500, 200, 30, 80, 30, 30);
    $new_graph->set_x_axis("week", $week - $intervall, 1, $week);
    $new_graph->set_y_axis("average price");
    $new_graph->set_color("#20313C", "white", "silver");
    
    foreach($stats as $stock => $data)
    {
      $new_graph->add_curve($title_array[$stock], $color_array[$stock], $data);
    }
    
    $new_graph->build();
  }


  /*  
  // STATS
  $stats_width = 480;
  $stats_height= 200;
  $margin_left  = 20;
  $margin_bottom= 20;
  
  $file_name = "../spaceregentsportal/portal/trade_stats.svg";
    
  //show_message("This is where the trade statistics will go. (as a reminder to myself)");
  
  if ($max_avg_price == 0)
    $max_avg_price = 1;
    
  $max_y  = $max_avg_price * 1.25;
  $y_step = $stats_height / $max_y;
  $x_step = $stats_width  / ($intervall * 1.25);
      
  // baue svg path
  $svg_paths = array();
  
  if (is_array($stats))
  {
    foreach($stats as $stock => $data)
    {
      $i = 0;
      $svg_stats .= "<g style=\"fill:none;stroke:".$color_array[$stock].";\" transform=\"translate(".$margin_left." -".$margin_bottom.")\">\n";
      $svg_stats .= "<path d=\"M";
      foreach ($data as $week => $value)
      {
        if ($i > 0)
        $svg_stats .= " ";
        $svg_stats .= ($x_step * $i).",".($stats_height - ($y_step * $value));
        $i++;
      }
      $svg_stats .= "\"/>\n</g>\n";
    }       
  }
  
  $svg  = "<svg width=\"".($stats_width + $margin_left)."\" height=\"".($stats_height + $margin_bottom)."\">\n";
  $svg  .= "<line x1=\"20\" y1=\"".$stats_height."\" x2=\"".($stats_width + $margin_width)."\" y2=\"".$stats_height."\"/>\n";    // X-Achse
  $svg  .= "<line x1=\"20\" y1=\"".$stats_height."\" x2=\"".$margin_left."\" y2=\"0\"/>\n";    // Y-Achse
  $svg  .= $svg_stats;
  $svg  .= "</svg>";
  
  
  $file = fopen($file_name,"w");
  fputs($file, $svg);
  fclose($file);
  */
  
  // reset statistics
  $sth = mysql_query("UPDATE stockmarket_statistics SET stocks_traded = 0");
  $sth = mysql_query("INSERT INTO stockmarket_statistics (SELECT stockmarket, time + 1, avg_price, 0 FROM stockmarket_statistics WHERE time = ".$week.")");
}

function production()
{
  // Orbital Start

  $sth=mysql_query("select * from o_production where time=1 and pos=1");

  if (!$sth)
  {
    echo("Database failure!\n");
    return 0;
  }

  while ($orbital=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("insert into constructions (pid,prod_id,type) values ('".$orbital["planet_id"]."','".$orbital["prod_id"]."',1)");

    if (!$sth1)
    {
      echo("Database failure!");
    }

    $sth1=mysql_query("select uid from planets where id=".$orbital["planet_id"]);

    if (!$sth1)
      echo("Datasbe failure!");

    list($uid)=mysql_fetch_row($sth1);

    $sth1=mysql_query("select name from production where prod_id=".$orbital["prod_id"]);
    if (!$sth1)
      echo("Database failure!");

    $blub=mysql_fetch_array($sth1);

    $planetname = get_planetname($orbital["planet_id"]);

    ticker($uid,"*lproduction.php?act=build&pid=".$orbital["planet_id"]."*".$planetname.": ".$blub["name"]." in orbit constructed.","w");

    $sth1=mysql_query("delete from o_production where planet_id='".$orbital["planet_id"]."' and prod_id='".$orbital["prod_id"]."'");

    if (!$sth1)
    {
      echo("Database failure!");
      return 0;
    }


    $sth1=mysql_query("select typ from production where prod_id=".$orbital["prod_id"]." and typ='R'");

    if (mysql_num_rows($sth1)>0)
    {
      $sth1=mysql_query("select uid from planets where id=".$orbital["planet_id"]);

      list($uid)=mysql_fetch_array($sth1);

      $sth1=mysql_query("delete from tradestations where uid=$uid");

      $sth1=mysql_query("insert into tradestations (metal,energy,mopgas,erkunum,gortium,susebloom,uid,pid) values ('0','0','0','0','0','0','$uid','".$orbital["planet_id"]."')");
    }

    $sth1=mysql_query("select prod_id from production where prod_id='".$orbital["prod_id"]."' and special='S'");

    if (!$sth1)
      echo("Database failure!");

    if (mysql_num_rows($sth1)>0)
    {
      $sth1=mysql_query("select sid from planets where id=".$orbital["planet_id"]);

      if (!$sth1)
        echo("Database failure!");

      $sid=mysql_fetch_row($sth1);

      $sth1=mysql_query("select * from jumpgatevalues where prod_id=".$orbital["prod_id"]);

      if (!$sth1)
        echo("Databaser failure!");

      if (mysql_num_rows($sth1)>0)
      {
        $password=crypt(md5(uniqid(mt_rand())));
        $sth1=mysql_query("insert into jumpgates (prod_id,password,sid,pid) values ('".$orbital["prod_id"]."','".$password."','".$sid[0]."','".$orbital["planet_id"]."')");

        if (!$sth1)
          echo("Dtasabser failuert!");

        $sth1=mysql_query("select uid from planets where id=".$orbital["planet_id"]);

        if (!$sth1)
          echo("Dtasber faileu8r!");

        $uid=mysql_fetch_row($sth1);

        mail_to_uid($uid[0],"Password for your jumpgate in system ".$sid[0],$password);

      }

    }

  }

  $sth=mysql_query("update o_production set time=time-'1' where time>1 and pos=1");

  if (!$sth)
  {
    echo("Database failure!");
    return 0;
  }

  $sth=mysql_query("select distinct p1.planet_id from o_production as p1 left join o_production as p2 on p2.pos=1 and p2.planet_id=p1.planet_id where p1.pos!=1 and p2.pos is NULL");

  if (!$sth)
    echo("Database failure!");

  while ($pids=mysql_fetch_row($sth))
  {
    $next_prod_id=next_in_queue(0,$pids[0]);

    if ($next_prod_id)
    {
      $uid=get_uid_by_pid($pids[0]);

      if (has_ressources($uid,$next_prod_id))
      {
        $sth1=mysql_query("update o_production set pos=1 where planet_id=".$pids[0]." and prod_id=$next_prod_id");

        $sth1=mysql_query("select metal,energy,mopgas,erkunum,gortium,susebloom from production where prod_id=$next_prod_id");

        list($metal,$energy,$mopgas,$erkunum,$gortium,$susebloom)=mysql_fetch_row($sth1);

        $sth1=mysql_query("update ressources set metal=metal-$metal,energy=energy-$energy,mopgas=mopgas-$mopgas,erkunum=erkunum-$erkunum,gortium=gortium-$gortium,susebloom=susebloom-$susebloom where uid=$uid");
      }
    }
  }

  // Orbital Ende

  // Planet production

  $sth=mysql_query("select * from p_production where time=1 and pos=1");

  if (!$sth)
  {
    echo("Database failure!\n");
    return 0;
  }

  while ($buildings=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select uid,name from planets where id=".$buildings["planet_id"]);

    if (!$sth1)
      echo("Database failure!");

    $uid=mysql_fetch_array($sth1);

    if ($uid["name"]=="Unnamed")
      $uid["name"] = get_planetname($buildings["planet_id"]);

    $sth1=mysql_query("select name from production where prod_id=".$buildings["prod_id"]);

    // Schilde einbauen

    list($value, $shield)=dselect("CONV(SUBSTRING(special FROM 2),10,10), shield","shipvalues","special LIKE 'H%' AND prod_id=".$buildings["prod_id"]);

    if ($value)
      $janne=mysql_query("REPLACE INTO planetary_shields (pid, prod_id, value, max_value, regeneration, 
        regeneration_bonus) VALUES (".$buildings["planet_id"].", ".$buildings["prod_id"].", $shield, $shield,
          $value, 0)"); 	

        if (!$sth1)
          echo("Database failure!");

    $blub=mysql_fetch_array($sth1);

    ticker($uid["uid"],"*lproduction.php?act=build&pid=".$buildings["planet_id"]."*".$uid["name"].": ".$blub["name"]." constructed.","w");

    $sth1=mysql_query("insert into constructions (pid,prod_id,type) values ('".$buildings["planet_id"]."','".$buildings["prod_id"]."',0)");

    if (!$sth1)
      echo("Database failure! (CREATING BUILDING ON PLANET)");

    $sth1=mysql_query("delete from p_production where planet_id='".$buildings["planet_id"]."' and prod_id='".$buildings["prod_id"]."'");

    if (!$sth1)
      echo("Database failure! (DELETING PLANETAR PRODUCTION)");
  }

  $sth=mysql_query("update p_production set time=time-'1' where time>1 and pos=1");

  if (!$sth)
  {
    echo("Database failure!");
    return 0;
  }

  $sth=mysql_query("select distinct p1.planet_id from p_production as p1 left join p_production as p2 on p2.pos=1 and p2.planet_id=p1.planet_id where p1.pos!=1 and p2.pos is NULL");

  if (!$sth)
    echo("Database failure!");

  while ($pids=mysql_fetch_row($sth))
  {
    $next_prod_id=next_in_queue(1,$pids[0]);

    if ($next_prod_id)
    {
      $uid=get_uid_by_pid($pids[0]);

      if (has_ressources($uid,$next_prod_id))
      {
        $sth1=mysql_query("update p_production set pos=1 where planet_id=".$pids[0]." and prod_id=$next_prod_id");

        $sth1=mysql_query("select metal,energy,mopgas,erkunum,gortium,susebloom from production where prod_id=$next_prod_id");

        list($metal,$energy,$mopgas,$erkunum,$gortium,$susebloom)=mysql_fetch_row($sth1);

        $sth1=mysql_query("update ressources set metal=metal-$metal,energy=energy-$energy,mopgas=mopgas-$mopgas,erkunum=erkunum-$erkunum,gortium=gortium-$gortium,susebloom=susebloom-$susebloom where uid=$uid");
      }
    }
  }

  // Planetar Ende

  // Fleet Production Start
  $uids=array();
  $sth=mysql_query("select s.planet_id,s.prod_id,s.count,s.time,s.priority,
r.uid,r.metal as rmetal,r.energy as renergy,r.mopgas as rmopgas,r.erkunum as rerkunum,r.gortium as rgortium,r.susebloom as rsusebloom,
pl.id,p.metal,p.energy,p.mopgas,p.erkunum,p.gortium,p.susebloom,
sum(ps.tonnage) as slots,
sv.tonnage,
p.com_time
from s_production s,planets pl,production p,ressources r,production_slots ps,constructions c,shipvalues sv where s.planet_id=pl.id
and s.prod_id=p.prod_id
and p.prod_id=sv.prod_id
and ps.prod_id=c.prod_id
and c.pid=pl.id
and r.uid=pl.uid
group by s.planet_id,s.prod_id,s.time
order by pl.uid,s.priority DESC,s.time DESC");

  if (!$sth)
  {
    echo("ERR::GET S_PRODUCTION");
  }
  else
  {
    while ($data=mysql_fetch_assoc($sth))
    {
      if (!$uids[$data["uid"]])
      {
        $uids[$data["uid"]]=array("production_slots"=>$data["slots"],
                                  "ressources"=>array("metal"    =>$data["rmetal"],
                                                      "energy"   =>$data["renergy"],
                                                      "mopgas"   =>$data["rmopgas"],
                                                      "erkunum"  =>$data["rerkunum"],
                                                      "gortium"  =>$data["rgortium"],
                                                      "susebloom"=>$data["rsusebloom"]),
                                 );
      }

      // mop: maximale anzahl der produzierbaren schiffe ermitteln (durch slots limitiert)
      $prod_count=floor($uids[$data["uid"]]["production_slots"]/$data["tonnage"]);

      $real_count=min($data["count"],$prod_count);
      
      if ($real_count>0)
      {
        // mop: jetzt koenen uns nur noch die ressourcen aufhalten
        foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
        {
          if ($data[$res])
            $real_count=min($real_count,floor($uids[$data["uid"]]["ressources"][$res]/ceil($data[$res]/$data["com_time"])));
        }

        if ($real_count>0)
        {
          // mop: alle schiffe produzierbar?
          if ($real_count==$data["count"])
          {
            // mop: alles easy
            $sth1=mysql_query("update s_production s,ressources r set s.time=s.time+1,
                r.metal=r.metal-".ceil($real_count*$data["metal"]/$data["com_time"]).",
                r.energy=r.energy-".ceil($real_count*$data["energy"]/$data["com_time"]).",
                r.mopgas=r.mopgas-".ceil($real_count*$data["mopgas"]/$data["com_time"]).",
                r.erkunum=r.erkunum-".ceil($real_count*$data["erkunum"]/$data["com_time"]).",
                r.gortium=r.gortium-".ceil($real_count*$data["gortium"]/$data["com_time"]).",
                r.susebloom=r.susebloom-".ceil($real_count*$data["susebloom"]/$data["com_time"])."
                where s.prod_id=".$data["prod_id"]." and s.time=".$data["time"]." and s.planet_id=".$data["planet_id"]." and r.uid=".$data["uid"]);

            if (!$sth1)
            {
              echo ("ERR::UPDATE S_PROD 1");
            }
          }
          else
          {
            // mop: stress...aufsplitten
            $sth1=mysql_query("insert into s_production set prod_id=".$data["prod_id"].",planet_id=".$data["planet_id"].",count=".$real_count.",time=".($data["time"]+1).",priority=".$data["priority"]." on duplicate key update count=count+".$real_count.",priority=".$data["priority"]);

            if (!$sth1)
            {
              echo("ERR::INSERT SPLIT S_PROD");
            }

            // mop: update des rests und der ressourcen
            $sth1=mysql_query("update s_production s,ressources r set s.count=s.count-".$real_count.",
                r.metal=r.metal-".ceil($real_count*$data["metal"]/$data["com_time"]).",
                r.energy=r.energy-".ceil($real_count*$data["energy"]/$data["com_time"]).",
                r.mopgas=r.mopgas-".ceil($real_count*$data["mopgas"]/$data["com_time"]).",
                r.erkunum=r.erkunum-".ceil($real_count*$data["erkunum"]/$data["com_time"]).",
                r.gortium=r.gortium-".ceil($real_count*$data["gortium"]/$data["com_time"]).",
                r.susebloom=r.susebloom-".ceil($real_count*$data["susebloom"]/$data["com_time"])."
                where s.prod_id=".$data["prod_id"]." and s.time=".$data["time"]." and s.planet_id=".$data["planet_id"]." and r.uid=".$data["uid"]);

            if (!$sth1)
              echo("ERR::UPDATE REST S_PROD");
          }
          $uids[$data["uid"]]["production_slots"]-=$real_count*$data["tonnage"];

          foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
            $uids[$data["uid"]]["ressources"][$res]-=ceil($real_count*$data[$res]/$data["com_time"]);
        }
      }
    }
  }
 
  // mop: rundungsfehler fuer die dinger, die jetzt fertig werden ausgleichen
  $fragments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $res)
    $fragments[]="r.".$res."=r.".$res."+ceil(p.".$res."*s.count/p.com_time)*p.com_time-p.".$res."*s.count";

  $sth=mysql_query("update s_production s,production p,planets pl,ressources r set ".implode($fragments,",")." where r.uid=pl.uid and pl.id=s.planet_id and s.prod_id=p.prod_id and p.com_time-s.time=0");

  if (!$sth)
    echo("ERR::CORRECT CEILINGS\n");
  
  $sth=mysql_query("select * from s_production sp,production p where p.com_time-sp.time=0 and sp.prod_id=p.prod_id");

  if (!$sth)
  {
    echo("Database failure!\n");
    return 0;
  }

  while ($ships=mysql_fetch_assoc($sth))
  {
    $sth1=mysql_query("select uid,name from planets where id=".$ships["planet_id"]);

    if (!$sth1)
      echo("Datasbe failure!");

    $uid=mysql_fetch_assoc($sth1);

    ticker($uid["uid"],"*lproduction.php?pid=".$ships["planet_id"]."*".$uid["name"].": ".$ships["count"]." ".$ships["name"]."(s) produced.","w");

    $sth1=mysql_query("select sid from planets where id=".$ships["planet_id"]);

    if (!$sth1)
      echo("Dtabase failuer!");

    $system=mysql_fetch_array($sth1);

    $fids=get_fids_by_pid($ships["planet_id"],$uid["uid"]);

    // Keine Flotte auf dem Planet?

    if (!$fids)
    {
      $new_fleet=new fleet();

      $new_fleet->add_ships_arr(array($ships["prod_id"]=>array($ships["count"],0)));

      $new_fleet->uid=$uid["uid"];
      $new_fleet->pid=$ships["planet_id"];
      $new_fleet->sid=$system["sid"];
      $new_fleet->create_fleet();
    }
    else
    {
      $prod_id_in_fid=false;

      for ($i=0;$i<=sizeof($fids)-1;$i++)
      {
        $fleet=new fleet($fids[$i]);

        if ($fleet->ships[$ships["prod_id"]])
        {
          $prod_id_in_fid=&$fleet; // Das is ne referenz :) Irgendwann musste ich die einfach mal benutzen:)
          break;
        }
      }

      if ($prod_id_in_fid)
      {
        $prod_id_in_fid->ships[$ships["prod_id"]][0]+=$ships["count"];
        $prod_id_in_fid->update_prod_id($ships["prod_id"]);
      }
      else
      {
        $fleet->add_ships_arr(array($ships["prod_id"]=>array($ships["count"],0)));
        if (!$fleet->update_prod_id($ships["prod_id"]))
          echo("Error assigning new prod id to fleet ".$fleet->fid."\n");
      }

    }

    $sth1=mysql_query("delete from s_production where planet_id='".$ships["planet_id"]."' and prod_id='".$ships["prod_id"]."' and count='".$ships["count"]."' and time=".$ships["time"]);

    if (!$sth1)
      echo("Dtaabase failuer!");
  }

  // Fleet Ende

  // Infantery Production Start

  $sth=mysql_query("select * from i_production where time=1");

  if (!$sth)
  {
    echo("Database failure!\n");
    return 0;
  }


  while ($soldiers=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select uid,name from planets where id=".$soldiers["planet_id"]);

    if (!$sth1)
      echo("Datasbe failure!");

    $uid=mysql_fetch_array($sth1);

    $sth1=mysql_query("select name from production where prod_id=".$soldiers["prod_id"]);
    if (!$sth1)
      echo("Database failure!");

    $blub=mysql_fetch_array($sth1);

    ticker($uid["uid"],"*lproduction.php?pid=".$soldiers["planet_id"]."*".$uid["name"].": ".$soldiers["count"]." ".$blub["name"]."(s) produced.","w");

    $sth1=mysql_query("select prod_id from infantery where prod_id=".$soldiers["prod_id"]." and pid=".$soldiers["planet_id"]);

    if (!$sth1)
      echo("Dazsu failu!");

    if (mysql_num_rows($sth1)==0)
    {

      $sth1=mysql_query("insert into infantery (prod_id,pid,count,uid) values ('".$soldiers["prod_id"]."','".$soldiers["planet_id"]."','".$soldiers["count"]."','".$uid[0]."')");

      if (!$sth1)
        echo("Database failuerfleet!");
    }
    else
    {
      $sth1=mysql_query("update infantery set count=count+".$soldiers["count"]." where pid='".$soldiers["planet_id"]."' and prod_id='".$soldiers["prod_id"]."' and uid='".$uid["uid"]."' limit 1");

      if (!$sth1)
        echo("Database failure!");

    }

    $sth1=mysql_query("delete from i_production where planet_id='".$soldiers["planet_id"]."' and prod_id='".$soldiers["prod_id"]."' and count='".$soldiers["count"]."' and time=1");

    if (!$sth1)
      echo("Dtaabase failuer!");
  }

  $sth=mysql_query("select * from infbattle".$soldier["planet_id"]);

  if ($sth)
    $sth=mysql_query("insert into infbattle".$soldier["planet_id"]." (prod_id,count,initiative,side) values ('".$soldier["prod_id"]."','".$soldier["count"]."','0','0')");


  $sth=mysql_query("update i_production set time=time-'1' where time>1");

  if (!$sth)
  {
    echo("Database failure!");
    //      return 0;
  }

  // Infantery Ende

}

function research()
{
  $sth=mysql_query("update researching set time=time-'1'");

  if (!$sth)
  {
    echo("Database failure!");
    return 0;
  }
  
  $sth=mysql_query("select r.*,t.* from researching r, tech t where r.t_id=t.t_id and r.time=0");

  if (!$sth)
  {
    echo("Database failure!");
    return 0;
  }

  while ($research=mysql_fetch_array($sth))
  {
    ticker($research["uid"],"*lresearch.php*Your research has been finished!","r");

    $sth1=mysql_query("insert into research (uid,t_id) values ('".$research["uid"]."','".$research["t_id"]."')");

    if (!$sth1)
    {
      var_dump($research);
      echo("Database failure!");
    }

    $sth1=mysql_query("delete from researching where uid='".$research["uid"]."'");

    if (!$sth1)
    {
      var_dump($research);
      echo("Database failure2!");
    }

    if ($research["special"] & COLONIST_BOOST)
    {
      ticker($research["uid"],"*lresearch.php*Your research has triggered a colonist boost!","r");
      
      $sth1=mysql_query("update ressources set colonists=colonists+5 where uid=".$research["uid"]);

      if (!$sth1)
      {
  var_dump($research);
  echo("ERR::RESEARCH\n");
      }
    }
    
    $queue=get_research_queue($research["uid"]);
    
    if (sizeof($queue)>0)
    {
      $next_tech=array_shift($queue);

      $sth1=mysql_query("insert into researching (t_id,uid,time) select ".$next_tech.",".$research["uid"].",t.com_time from tech t where t_id=".$next_tech);

      if (!$sth1)
        echo("ERR::INSERT QUEUE");

      save_research_queue($research["uid"],array_values($queue));
    }
  }

}

//----------------------------------------------------------------------------------------------------------------------

function get_ressources_normal()
{
  $sth=mysql_query("delete from tmp_prod_factors");
  $sth=mysql_query("delete from final_prod_factors");
  // mop: ideale welt geht nicht...ka warum
  //create table tmp_prod_factors (pid int not null,metal int not null default 1,energy int not null default 1,mopgas int not null default 1,erkunum int not null default 1,gortium int not null default 1,susebloom int not null default 1,primary key(pid));
  //insert into tmp_prod_factors (pid) select id from planets;
  //update tmp_prod_factors t,prod_upgrade p, buildings b set t.metal=if(p.ressource='metal',if(p.factor>t.metal,p.factor,t.metal),t.metal),t.energy=if(p.ressource='energy',if(p.factor>t.energy,p.factor,t.energy),t.energy),t.mopgas=if(p.ressource='mopgas',if(p.factor>t.mopgas,p.factor,t.mopgas),t.mopgas),t.erkunum=if(p.ressource='erkunum',if(p.factor>t.erkunum,p.factor,t.erkunum),t.erkunum),t.gortium=if(p.ressource='gortium',if(p.factor>t.gortium,p.factor,t.gortium),t.gortium),t.susebloom=if(p.ressource='susebloom',if(p.factor>t.susebloom,p.factor,t.susebloom),t.susebloom) where b.pid=t.pid and p.prod_id=b.prod_id;

  $sth=mysql_query("insert into tmp_prod_factors (pid) select p.id from planets p where p.uid!=0");

  if (!$sth)
  {
    echo("ERR::DEFAULT PROD");
    return false;
  }
  
  $sth=mysql_query("insert into tmp_prod_factors select o.pid,if(ressource='metal',p.factor,0),if(ressource='energy',p.factor,0),if(ressource='mopgas',p.factor,0),if(ressource='erkunum',p.factor,0),if(ressource='gortium',p.factor,0),if(ressource='susebloom',p.factor,0),if(ressource='all',p.factor,0) from prod_upgrade p, constructions o,tmp_prod_factors t where p.prod_id=o.prod_id and o.pid=t.pid");

  if (!$sth)
  {
    echo("ERR::INS_TMP_FACTORS\n");
    return false;
  }

  $sth=mysql_query("insert into final_prod_factors select pid,sum(metal)+sum(all_res)+1,sum(energy)+sum(all_res)+1,sum(mopgas)+sum(all_res)+1,sum(erkunum)+sum(all_res)+1,sum(gortium)+sum(all_res)+1,sum(susebloom)+sum(all_res)+1 from tmp_prod_factors group by pid");

  if (!$sth)
  {
    echo("ERR::INS_FINAL_FACTORS\n");
    return false;
  }
  
  // mop: den grössten exponenten herausfinden => also 293 =>  (10^3) (sind ja nur hunderter - und dann +1)
  $sth=mysql_query("select floor(log10(max(id)))+1 from planets");

  if (!$sth)
  {
    echo("ERR::GET EXPONENT");
    return false;
  }

  list($exponent)=mysql_fetch_row($sth);

  $sth=mysql_query("create temporary table tmp_no_alliance_delete (pid int not null,primary key(pid))");

  if (!$sth)
  {
    echo("ERR::CREATE TMPTABLE");
    return false;
  }

  $raw_factor=8.5;
  // mop: berechnung der erwirtschafteten ressourcen
  $segment="round(%s.%s*(%s.%s/100)*%s*(log10(%s.population/1000)+3))";
  
  $f_alias="f2";
  $p_alias="p2";
  $segments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $ressource)
    $segments[]=sprintf($segment,$f_alias,$ressource,$p_alias,$ressource,$raw_factor,$p_alias,$ressource."_plus");
  
  $calc_1=implode("+",$segments);
  
  $f_alias="f";
  $p_alias="p";
  $segments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $ressource)
    $segments[]=sprintf($segment,$f_alias,$ressource,$p_alias,$ressource,$raw_factor,$p_alias,$ressource."_plus");

  $calc_2=implode("+",$segments);

  $sth=mysql_query("insert into tmp_no_alliance_delete
select p.id from final_prod_factors f,planets p,users u where f.pid=p.id and p.uid=u.id and u.alliance=0 and
3<(select count(*) from planets p2,final_prod_factors f2
where p2.uid=p.uid and p2.id=f2.pid and
round((".$calc_1.")+(p2.id/".pow(10,$exponent)."),".$exponent.")
>=round((".$calc_2.")+(p.id/".pow(10,$exponent)."),".$exponent."))");

  if (!$sth)
  {
    echo("ERR::INSERT DELETE NO ALLIANCE");
    return false;
  }

  $sth=mysql_query("delete from final_prod_factors f using tmp_no_alliance_delete t,final_prod_factors f where t.pid=f.pid");

  if (!$sth)
  {
    echo("ERR::DELETE NO ALLIANCE PIDS");
    return false;
  }

  $segment="round(sum(f.%s*(p.%s/100)*%s*(log10(p.population/1000)+3)*p.production_factor)) as %s";
  $segments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $ressource)
    $segments[]=sprintf($segment,$ressource,$ressource,$raw_factor,$ressource."_plus");

  $query="select p.uid,".implode(",",$segments)." from final_prod_factors f,planets p where p.id=f.pid and p.uid!=0 group by p.uid";
    
  $sth=mysql_query($query);

  if (!$sth)
  {
    echo("ERR::GET RESSUM => ".$query);
    return false;
  }

  $res=array(); 

  while ($ressources=mysql_fetch_assoc($sth))
    $res[$ressources["uid"]]=$ressources;

  return $res;
}

function ressources_new()
{
  $sth=mysql_query("update taxes set incomemetal=0,incomeenergy=0,incomemopgas=0,incomeerkunum=0,incomesusebloom=0,incomegortium=0");

  if (!$sth)
    echo("Database failure!");

  $ressources = get_ressources_normal();
  foreach ($ressources as $uid => $ressources)
  {
    $sth=mysql_query("replace into income_stats set uid=".$uid.",metal=".$ressources["metal_plus"].",energy=".$ressources["energy_plus"].",mopgas=".$ressources["mopgas_plus"].",erkunum=".$ressources["erkunum_plus"].",gortium=".$ressources["gortium_plus"].",susebloom=".$ressources["susebloom_plus"]);

    if (!$sth)
      echo("ERR::ASSIGN INCOME");
  }
  $sth=mysql_query("update income_stats i1,users u,alliance a,taxes t set
i1.tax_metal=floor(i1.metal*t.taxmetal/100),
i1.tax_energy=floor(i1.energy*t.taxenergy/100),
i1.tax_mopgas=floor(i1.mopgas*t.taxmopgas/100),
i1.tax_erkunum=floor(i1.erkunum*t.taxerkunum/100),
i1.tax_gortium=floor(i1.gortium*t.taxgortium/100),
i1.tax_susebloom=floor(i1.susebloom*t.taxsusebloom/100) where i1.uid=u.id and u.alliance=a.id and t.aid=a.id");

  if (!$sth)
    echo("ERR::ASSIGN INCOME=>TAX"); 
    
  $sth=mysql_query("select id from alliance");

  if (!$sth)
  {
    echo("ERR::ALLIANCES PUTT");
    return false;
  }

  while (list($aid)=mysql_fetch_row($sth))
  {
    // mop: keine multi table updates + group by :(
    $sth1=mysql_query("select sum(i.tax_metal),
sum(i.tax_energy),
sum(i.tax_mopgas),
sum(i.tax_erkunum),
sum(i.tax_gortium),
sum(i.tax_susebloom)
from income_stats i,users u where i.uid=u.id and u.alliance=".$aid);
  
  if (!$sth1)
  {
    echo("ERR::GET INCOMEALLIANCE");
    return false;
  }
  list($metal,$energy,$mopgas,$erkunum,$gortium,$susebloom)=mysql_fetch_row($sth1);

  $sth1=mysql_query("update taxes set
incomemetal=".$metal.",
incomeenergy=".$energy.",
incomemopgas=".$mopgas.",
incomeerkunum=".$erkunum.",
incomegortium=".$gortium.",
incomesusebloom=".$susebloom."
where aid=".$aid);
/*
    $sth1=mysql_query("update income_stats i,users u,taxes t set
t.incomemetal=sum(i.tax_metal),
t.incomeenergy=sum(i.tax_energy),
t.incomemopgas=sum(i.tax_mopgas),
t.incomeerkunum=sum(i.tax_erkunum),
t.incomegortium=sum(i.tax_gortium),
t.incomesusebloom=sum(i.tax_susebloom)
where i.uid=u.id and u.alliance=t.aid group by u.alliance");
*/
    if (!$sth1)
      echo("ERR::ASSIGN TAXES ".$aid);
  }

  foreach (array("leader"=>"taxleader","milminister"=>"taxmilitary","devminister"=>"taxdevelopement","forminister"=>"taxforeign") as $position => $tax)
  {
    $sth=mysql_query("update income_stats i1,users u,alliance a,taxes t set
i1.earned_metal=t.incomemetal*(if(a.leader=u.id,t.taxleader,if(a.milminister=u.id,t.taxmilitary,if(a.devminister=u.id,t.taxdevelopement,if(a.forminister=u.id,t.taxforeign,0)))))/100,
i1.earned_energy=t.incomeenergy*(if(a.leader=u.id,t.taxleader,if(a.milminister=u.id,t.taxmilitary,if(a.devminister=u.id,t.taxdevelopement,if(a.forminister=u.id,t.taxforeign,0)))))/100,
i1.earned_mopgas=t.incomemopgas*(if(a.leader=u.id,t.taxleader,if(a.milminister=u.id,t.taxmilitary,if(a.devminister=u.id,t.taxdevelopement,if(a.forminister=u.id,t.taxforeign,0)))))/100,
i1.earned_erkunum=t.incomeerkunum*(if(a.leader=u.id,t.taxleader,if(a.milminister=u.id,t.taxmilitary,if(a.devminister=u.id,t.taxdevelopement,if(a.forminister=u.id,t.taxforeign,0)))))/100,
i1.earned_gortium=t.incomegortium*(if(a.leader=u.id,t.taxleader,if(a.milminister=u.id,t.taxmilitary,if(a.devminister=u.id,t.taxdevelopement,if(a.forminister=u.id,t.taxforeign,0)))))/100,
i1.earned_susebloom=t.incomesusebloom*(if(a.leader=u.id,t.taxleader,if(a.milminister=u.id,t.taxmilitary,if(a.devminister=u.id,t.taxdevelopement,if(a.forminister=u.id,t.taxforeign,0)))))/100
where i1.uid=u.id and a.id=u.alliance and t.aid=a.id and i1.uid=a.".$position);

    if (!$sth)
      echo("ERR::ASSIGN EARNEDTAXES => ".$position);
  }
  
  $sth=mysql_query("update income_stats i set
i.upkeep_metal    =(select ifnull(ceil(sum(p.metal*f.count)*0.001),0) from fleet_info fi,fleet f,production p where fi.uid=i.uid and f.fid=fi.fid and f.prod_id=p.prod_id),
i.upkeep_energy   =(select ifnull(ceil(sum(p.energy*f.count)*0.001),0) from fleet_info fi,fleet f,production p where fi.uid=i.uid and f.fid=fi.fid and f.prod_id=p.prod_id),
i.upkeep_mopgas   =(select ifnull(ceil(sum(p.mopgas*f.count)*0.001),0) from fleet_info fi,fleet f,production p where fi.uid=i.uid and f.fid=fi.fid and f.prod_id=p.prod_id),
i.upkeep_erkunum  =(select ifnull(ceil(sum(p.erkunum*f.count)*0.001),0) from fleet_info fi,fleet f,production p where fi.uid=i.uid and f.fid=fi.fid and f.prod_id=p.prod_id),
i.upkeep_gortium  =(select ifnull(ceil(sum(p.gortium*f.count)*0.001),0) from fleet_info fi,fleet f,production p where fi.uid=i.uid and f.fid=fi.fid and f.prod_id=p.prod_id),
i.upkeep_susebloom=(select ifnull(ceil(sum(p.susebloom*f.count)*0.001),0) from fleet_info fi,fleet f,production p where fi.uid=i.uid and f.fid=fi.fid and f.prod_id=p.prod_id)
");

  if (!$sth)
    echo("ERR::UPKEEP FLEET");
  
  $sth=mysql_query("update income_stats i set
i.upkeep_metal    =i.upkeep_metal+(select ifnull(ceil(sum(p.metal*fi.count)*0.001),0) from infantery fi,production p where fi.uid=i.uid and fi.prod_id=p.prod_id),
i.upkeep_energy   =i.upkeep_energy+(select ifnull(ceil(sum(p.energy*fi.count)*0.001),0) from infantery fi,production p where fi.uid=i.uid and fi.prod_id=p.prod_id),
i.upkeep_mopgas   =i.upkeep_mopgas+(select ifnull(ceil(sum(p.mopgas*fi.count)*0.001),0) from infantery fi,production p where fi.uid=i.uid and fi.prod_id=p.prod_id),
i.upkeep_erkunum  =i.upkeep_erkunum+(select ifnull(ceil(sum(p.erkunum*fi.count)*0.001),0) from infantery fi,production p where fi.uid=i.uid and fi.prod_id=p.prod_id),
i.upkeep_gortium  =i.upkeep_gortium+(select ifnull(ceil(sum(p.gortium*fi.count)*0.001),0) from infantery fi,production p where fi.uid=i.uid and fi.prod_id=p.prod_id),
i.upkeep_susebloom=i.upkeep_susebloom+(select ifnull(ceil(sum(p.susebloom*fi.count)*0.001),0) from infantery fi,production p where fi.uid=i.uid and fi.prod_id=p.prod_id)
");

  if (!$sth)
    echo("ERR::UPKEEP INF");

  $sth=mysql_query("update ressources r,income_stats i set
r.metal=r.metal+i.metal-i.tax_metal+i.earned_metal-i.upkeep_metal,
r.energy=r.energy+i.energy-i.tax_energy+i.earned_energy-i.upkeep_energy,
r.mopgas=r.mopgas+i.mopgas-i.tax_mopgas+i.earned_mopgas-i.upkeep_mopgas,
r.erkunum=r.erkunum+i.erkunum-i.tax_erkunum+i.earned_erkunum-i.upkeep_erkunum,
r.gortium=r.gortium+i.gortium-i.tax_gortium+i.earned_gortium-i.upkeep_gortium,
r.susebloom=r.susebloom+i.susebloom-i.tax_susebloom+i.earned_susebloom-i.upkeep_susebloom
where r.uid=i.uid");

  if (!$sth)
    echo("ERR::INCOME => RESSOURCES");
}
//----------------------------------------------------------------------------------------------------------------------

function move_system_system($fleet)
{
  define("no_tech_warp","200");

  $sth1=mysql_query("select max(reload) from fleet where fid=".$fleet["fid"]);

  if (!$sth1)
    echo("Database failure!");

  list($reload)=mysql_fetch_row($sth1);

  if ($reload==0)
  {
    $sth1=mysql_query("select route from routes where fid=".$fleet["fid"]);

    if (!$sth1)
      echo("Database failure!");

    list($route)=mysql_fetch_row($sth1);

    $route=unserialize($route);

    // var_dump($route);

    $sth1=mysql_query("update fleet_info set sid='".$route[0]."' where fid=".$fleet["fid"]);

    if (!$sth1)
      echo("Database failure!");

    $sth1=mysql_query("select s.warpreload,f.prod_id from fleet as f,shipvalues as s where s.prod_id=f.prod_id and f.fid=".$fleet["fid"]);

    if (!$sth1)
      echo("Database failure!");

    while ($reload=mysql_fetch_row($sth1))
    {
      $sth2=mysql_query("update fleet set reload=".$reload[0]." where fid=".$fleet["fid"]." and prod_id=".$reload[1]);

      if (!$sth2)
      echo("Database failure!");
    }
    
    if ($route)
    {
      // allied refuelling stations suchen
      // zuerst alle planeten raussuchen die einem selbst oder alleiertem gehören
      $sth = mysql_query("SELECT p.id
                          FROM  planets p 
                          WHERE
                          (p.uid in (SELECT u1.id from users u1 join users u2 using(alliance) WHERE u2.id = ".$fleet["uid"]." and u1.alliance > 0)
                          OR p.uid = ".$fleet["uid"].")
                          AND p.sid = ".$route[0]);

      if (!$sth) {
        echo("ERROR :: REFUEL -> getting allied planets");
        echo("FLEET is:");
        var_dump($fleet);
        echo("ROUTE is:");
        var_dump($route);
        echo("-----------------------------------------");
      }

      if (mysql_num_rows($sth) > 0) 
      {
        $pids = mysql_fetch_assoc($sth);

        $sth = mysql_query("SELECT DISTINCT 1 FROM constructions c, production p where p.special = 'F' and p.prod_id = c.prod_id and c.pid in (".(implode(",",$pids)).")");

        if (!$sth) {
          echo("ERROR :: REFUEL -> getting refueling stations");
          echo("PIDS is:");
          var_dump($pids);
          echo("-----------------------------------------");
        }

        if (mysql_num_rows($sth) > 0) {
          list($refuel_station_exists) = mysql_fetch_row($sth);

          if ($refuel_station_exists == 1) {
            $sth3=mysql_query("update fleet set reload = reload - 1 where reload > 0 and fid=".$fleet["fid"]);
          }
        }
      }

      array_shift($route);

      $sth1=mysql_query("replace into routes set route='".addslashes(serialize($route))."',fid=".$fleet["fid"]);

      if (!$sth1)
      {
        show_error("ERROR :: REPLACE ROUTE");
      }
    } // end if (route)
  }
}
//----------------------------------------------------------------------------------------------------------------------



function colonisations()
{
  $sth=mysql_query("select f.fid,fi.pid,fi.uid,f.prod_id,pr.colonists,fi.sid from fleet as f,production pr,planets as p left join fleet_info as fi on fi.fid=f.fid where fi.tpid=0 and fi.tsid=0 and fi.mission=4 and f.prod_id=pr.prod_id and p.uid='0' and p.id=fi.pid and pr.special='C'");

  while ($colony=mysql_fetch_assoc($sth))
  {
    $sth1=mysql_query("select p.id from planets p, users u where u.homeworld=p.id and p.sid=".$colony["sid"]." and u.id!=".$colony["uid"]);

    if (!$sth1)
    {
      echo("ERR::COLONY CHECK=> select p.id from planets p, users u where u.homeworld=p.id and p.sid=".$colony["sid"]." and u.uid!=".$colony["uid"]."\n");
      continue;
    }

    if (mysql_num_rows($sth1)>0)
      continue; // nur planeten besiedelbar, die nicht in nem heimatsystem sind
    
    ticker($colony["uid"],"*lproduction.php?pid=".$colony["pid"]."*You have colonised a new planet","w");

    $sth1=mysql_query("update fleet set count=count-1 where prod_id=".$colony["prod_id"]." and fid=".$colony["fid"]);

    $sth1=mysql_query("update planets set uid=".$colony["uid"].",population=".(get_pop_by_poplevel($colony["colonists"]))." where id=".$colony["pid"]);
    
    if (!$sth1)
      echo("Colonisation: Database failure!");
      
      
    //runelord: ne Colony-Gebäude auf so nen planeten setzen
    //Productionid einer Colony: 65    
    $planet_type = get_planets_type($colony["pid"]);
    
    $sth1 = mysql_query("insert into constructions values(".$colony["pid"].",65,0)");
    
    if (!$sth1)
      echo("Colonisation - setting new building failed!");
    
    $sth1=mysql_query("insert into popgain set pid=".$colony["pid"]);

    if (!$sth1)
      echo("ERR::SET POPGAIN");
  }

  delete_empty_fleets();

  $sth=mysql_query("update fleet_info set mission='0' where mission=4 and tpid=0");

}
//----------------------------------------------------------------------------------------------------------------------

function alliances()
{
  // mop: alle allianzen, wo der vote gerade zu ende geht auswerten
  $sth=mysql_query("select a.id from alliance a,vote v where a.id=v.aid and v.end<=now()");

  if (!$sth)
    echo("ERR::GET ALLIANCE VOTING");

  while (list($aid)=mysql_fetch_row($sth))
  {
    // mop: neuen leader ermitteln
    $sth1=mysql_query("select count(*),vote from votes where aid=".$aid." group by vote order by 1 desc,rand() limit 1");

    if (!$sth1)
      echo("ERR::GET NEW LEADER");
    
    // mop: keine stimme abgegeben => alles bleibt beim alten
    if (mysql_num_rows($sth1)==0)
      continue;
    
    list($count,$new_leader)=mysql_fetch_row($sth1);

    // mop: neuen leader und last_vote setzen...ausserdem als minister dismissen, falls er einer ist
    $sth1=mysql_query("update alliance set leader=".$new_leader.",last_vote=now() where id=".$aid);

    if (!$sth1)
      echo("ERR::SET NEW LEADER");

    $fragments=array();
    foreach (array("milminister","devminister","forminister") as $posten)
      $fragments[]=$posten."=if(".$posten."=".$new_leader.",0,".$posten.")";

    $sth1=mysql_query("update alliance set ".implode(",",$fragments)." where id=".$aid);

    if (!$sth1)
      echo("ERR::UPDATE MINISTERS");

    // mop: zum schluss alle voteinfos killen
    $sth1=mysql_query("delete from vote v,votes vs using vote v,votes vs where v.aid=".$aid." and v.aid=vs.aid");

    if (!$sth1)
      echo("ERR::DEL VOTEINFOS");
  }

  // mop: jetzt die neuen votings setzen
  $sth=mysql_query("replace into vote (aid,end) select a.id,date_add(now(),interval 2 day) from alliance a left join vote v on (a.id=v.aid) where a.last_vote<=date_sub(now(),interval 10 day) and v.aid is null");

  if (!$sth)
    echo("ERR::SET NEW VOTES");
}

function covertops()
{
  $sth=mysql_query("select * from covertops as c,covertopsmissions as cm where c.time=1 and c.cid=cm.id");

  if (!$sth)
    {
      echo("Dtaabaser failure!");
    }
  
  while ($covertops=mysql_fetch_array($sth))
    {
      $success=false;

      $sth1=mysql_query("select sum(c.value) from covertopsupgrades as c,constructions as b,planets as p where p.id=b.pid and b.prod_id=c.prod_id and p.uid=".$covertops["uid"]);

      if (!$sth1)
 echo("Dast FDS!");

      $f_co_upgrades=mysql_fetch_row($sth1);

      $sth1=mysql_query("select count(id) from planets where uid=".$covertops["uid"]);

      if (!$sth1)
 echo("Datasbe failure!");
      
      $f_planets=mysql_fetch_row($sth1);

      $f_rate=$f_co_upgrades[0]/$f_planets[0];

//      echo("Friendly Rate: ".$f_rate."\n");

      if ($covertops["targettype"]=="I")
 $imperium=$covertops["target"];
      else
 {
   $sth1=mysql_query("select uid from planets where id=".$covertops["target"]);
   
   if (!$sth1)
     echo("Datasbe failuer!");

   $uid=mysql_fetch_array($sth1);

   $imperium=$uid["uid"];
 }
      
      $sth1=mysql_query("select sum(population)/10000 from planets where uid=".$imperium);

      if (!$sth1)
 echo("Datasber faileur!");

      $spies=mysql_fetch_row($sth1);

      $sth1=mysql_query("select sum(count) from covertops where uid=".$imperium);

      if (!$sth1)
 echo("Database failuer!");
      
      $used_spies=mysql_fetch_row($sth1);

      if ($used_spies[0]==NULL)
 $rate=100;
      else  
 $rate=(($spies[0]-$used_spies[0])/$spies[0])*100;

//      echo("Grundrate: $rate\n");

      $sth1=mysql_query("select sum(c.value) from covertopsupgrades as c,constructions as b,planets as p where p.id=b.pid and b.prod_id=c.prod_id and p.uid=$imperium");

      if (!$sth1)
 echo("Dtasabr failuer!");
      
      $co_upgrades=mysql_fetch_row($sth1);

      $sth1=mysql_query("select count(id) from planets where uid=$imperium");

      if (!$sth1)
 echo("Datasbe failure!");
      
      $planets=mysql_fetch_row($sth1);

      $rate=$rate+($co_upgrades[0]/$planets[0]);

//      echo("Rate mit Upgrades: $rate\n");

      if ($rate<=0)
 $success=true;
      else
      {
      
        mt_srand ((double) microtime() * 1000000);

        $random=mt_rand(0,$rate-$f_rate);

//  echo("Berechnung: Rate->$rate Frindly Rate->$f_rate Zufall->$random Chance->".$covertops["chance"]."\n");

        if ($random<=$covertops["chance"])
   $success=true;
      }
      
//      if ($success)
//  echo("Success!\n");

      // DEBUG!

//      $success=true;

      if ($success)
 {
   switch($covertops["missiontype"])
   {
     case "S":

       define("MAX_STEAL",25);

     $sth1=mysql_query("select f.prod_id,f.fid,f.count,p.typ, p.name, f.reload from fleet as f,production as p left join fleet_info as fi on fi.fid=f.fid where fi.uid=$imperium and fi.mission=0 and fi.tpid=0 and fi.tsid=0 and fi.pid!=0 and f.prod_id=p.prod_id order by rand() limit 1");

     if (!$sth1)
       echo("Datsbe faileur!");

     if (mysql_num_rows($sth1)>0)
     {
       $fleet=mysql_fetch_array($sth1);

       $sth2=mysql_query("select p.id,p.sid from planets as p,users as u where p.id=u.homeworld and u.id=".$covertops["uid"]);

       if (!$sth2)
   echo("Dtabaser faileur!");

       $home=mysql_fetch_array($sth2);

       switch ($fleet["typ"])
       {
   case "L":
     $multiplikator=1;
   break;
   case "M":
     $multiplikator=5;
   break;
   case "H":
     $multiplikator=10;
   break;
       }

       if (($multiplikator*$fleet["count"])>MAX_STEAL)
   $fleet["count"]=floor(MAX_STEAL/$multiplikator);

       $new_fleet=new fleet();

       $new_fleet->add_ships_arr(array($fleet["prod_id"]=>array($fleet["count"],$fleet["reload"])));

       $new_fleet->uid=$covertops["uid"];
       $new_fleet->pid=$home["id"];
       $new_fleet->sid=$home["sid"];

       $new_fleet->create_fleet();

       $sth2=mysql_query("update fleet set count=count-".$fleet["count"]." where fid=".$fleet["fid"]." and prod_id=".$fleet["prod_id"]);

       delete_empty_fleets();

       ticker($covertops["uid"],"You have stolen ".$fleet["count"]." ".$fleet["name"],"s");

       ticker($imperium,$fleet["count"]." ".$fleet["name"]." vanished from your radar!","s");
     }
     else
       ticker($covertops["uid"],"Your spies didn't find any ships. The target imperium doesn't have any!","s");
     break;

     case "B":
       $sth1=mysql_query("select b.prod_id,b.pid,pl.name,p.name as pname from planets as pl,production as p,constructions as b where b.prod_id=p.prod_id and b.pid=pl.id and pl.uid=$imperium order by rand()");

     if (!$sth1)
       echo("Database failoer!");

     if (mysql_num_rows($sth1)>0)
     {
       $building=mysql_fetch_array($sth1);

       $sth1=mysql_query("delete from constructions where prod_id=".$building["prod_id"]." and pid=".$building["pid"]);

       if (!$sth1)
   echo("DDFatabf failur!");

       if ($building["name"]=="Unnamed")
   $building["name"]=get_planetname("pid");

       ticker($covertops["uid"],"Your spies destroyed the ".$building["pname"]." on planet ".$building["name"]."!","s");

       ticker($imperium,"The ".$building["pname"]." on planet ".$building["name"]." was destroyed misteriously!","s");

     }
     break;
     case "F":
       $sth1=mysql_query("select f.prod_id,f.fid from fleet as f,fleet_info as fi where fi.uid=$imperium and fi.fid=f.fid");

     if (!$sth1)
       echo("Datsbe faileur!");

     if (mysql_num_rows($sth1)>0)
     {
       if (mysql_num_rows($sth1)==1)
   $random=0;
       else
       {
   mt_srand ((double) microtime() * 1000000);

   $random=mt_rand(0,(mysql_num_rows($sth1)-1));
       }

       for ($i=0;$i<=$random;$i++)
   $fleet=mysql_fetch_array($sth1);

       $sth2=mysql_query("delete from fleet where fid=".$fleet["fid"]." and prod_id=".$fleet["prod_id"]);

       delete_empty_fleets();

       ticker($covertops["uid"],"You spies destroyed some ships!","s");

       ticker($imperium,"Enemy spies destroyed some of your ships!","s");
     }
     else
       ticker($covertops["uid"],"Your spies didn't find any ships. The target imperium doesn't have any!","s");
     break;
     case "N":
       $sth1=mysql_query("select * from ticker where uid=$imperium");

     if (!$sth1)
       echo("Database failure!");

     while ($ticker=mysql_fetch_array($sth1))
     {
       if ($end=strrpos($ticker["text"],"*"))
   $text=substr($ticker["text"],$end+1);
       else
   $text=$ticker["text"];
       $mail=$mail."\n".$text;
     }

     if (mysql_num_rows($sth1)==0)
       $mail="This Imperium doesn't have any news at the moment!";

     $sth1=mysql_query("select imperium from users where id=".$imperium);

     if (!$sth1)
       echo("Datsabe failure!");

     $imp_name=mysql_fetch_array($sth1);

     mail_to_uid($covertops["uid"],"News of ".$imp_name["imperium"],$mail);

     ticker($covertops["uid"],"Your spies have successfully hacked a news network. Check Mails.","s");
     break;
     case "M":
       $mail="";
     $sth1=mysql_query("select fi.*,f.prod_id,f.count,f.reload,p.name,s.x,s.y  from fleet as f,production as p,systems as s left join fleet_info as fi on fi.fid=f.fid and fi.uid=$imperium where p.prod_id=f.prod_id and s.id=fi.sid order by fid");

     if (mysql_num_rows($sth1)==0)
     {
       $mail="Target imperium doesn't have any fleets";
     }
     else
     {
       while ($part_fleet=mysql_fetch_array($sth1))
       {
   if ($part_fleet["fid"]!=$fid_old)
   {
     $fid_old=$part_fleet["fid"];
     $counter++;
   }
   $fleet[$counter][]=$part_fleet;
       }

       $counter=1;
       for ($i=1;$i<=sizeof($fleet);$i++)
       {
   $mail=$mail."Fleet ".($counter++)."<br>";
   $mail=$mail."<table>";

   $head_array="";
   $text_arr="";
   $prod_arr="";

   for ($j=0;$j<sizeof($fleet[$i]);$j++)
   {
     $head_array[($j)]=$fleet[$i][$j]["name"];
     $text_arr[($j)]=$fleet[$i][$j]["count"];
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
       $mission_text["a"]="";
     $mission_text["b"]="colonize";
     break;
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
     $planetname= get_planetname($fleet[$i][0]["tpid"]);   
     $mission="On its way to ".$mission_text["b"]." planet ".$planetname;
   }

   $text_arr[]=$mission;
   $head_array[]="Mission";

   reset($head_array);

   $mail=$mail."<tr>";
   while (list($key,$dummy)=each($head_array))
   {
     //echo($dummy."\n");
     $mail=$mail."<th>$dummy</th>";
   }
   $mail=$mail."</tr>";

   reset($text_arr);
   $mail=$mail."<tr>";

   while (list($key,$dummy)=each($text_arr))
   {
     echo($key." - ".$dummy."\n");
     $mail=$mail."<td>$dummy</td>";
   }
   $mail=$mail."</tr>";

   $mail=$mail."</table>";


       }

     }

     $sth1=mysql_query("select imperium from users where id=".$imperium);

     if (!$sth1)
       echo("Datsabe failure!");

     $imp_name=mysql_fetch_array($sth1);

     mail_to_uid($covertops["uid"],"Military overview of ".$imp_name["imperium"],$mail);

     ticker($covertops["uid"],"Your spies have successfully hacked a military network. Check Mails.","s");
     break;

     case "I":
       $mail="";
     $sth1=mysql_query("select c.target,cm.descr,cm.targettype from covertops as c,covertopsmissions as cm where uid=$imperium and cm.id=c.cid");

     if (!$sth1)
       echo("Databasdf faileru!");

     while ($missions=mysql_fetch_array($sth1))
     {
       if ($missions["targettype"]=="I")
       {
   $sth2=mysql_query("select imperium from users where id=".$missions["target"]);

   if (!$sth2)
     echo("Datasbae failuer!");

   $imp_tname=mysql_fetch_array($sth2); 

   $target="Imperium ".$imp_tname["imperium"];
       }
       else
       {
   $planetname = get_planetname($missions["target"]);
   $target="Planet ".$planetname;

       }


       $mail=$mail."\n".$missions["descr"]." Target :".$target;
     }

     $sth1=mysql_query("select imperium from users where id=".$imperium);

     if (!$sth1)
       echo("Datsabe failure!");

     $imp_name=mysql_fetch_array($sth1);

     mail_to_uid($covertops["uid"],"CovertOps overview of ".$imp_name["imperium"],$mail);
     break;
     case "C":
       $sth1=mysql_query("select population from planets where id=".$covertops["target"]);

     if (!$sth1)
       echo("Datasb faileur!");

     $pop=mysql_fetch_array($sth1);

     if ($pop["population"]>10000000)
     {
       mt_srand ((double) microtime() * 1000000);

       $killed=mt_rand(5000000,8000000);
     }
     else
     {
       mt_srand ((double) microtime() * 1000000);

       $killed=round($pop["population"]*(mt_rand(30,80)/100));
     }
     $planetname = get_planetname($covertops["target"]);

     $sth1=mysql_query("update planets set population=population-$killed where id=".$covertops["target"]);

     if (!$sth1)
       echo("udFH failuewr!");

     ticker($covertops["uid"],"Your spies launched a nuclear assault on Planet ".$planetname." $killed were killed!","s");

     $sth1=mysql_query("select uid from planets where id=".$covertops["target"]);

     if (!$sth1)
       echo("Database dfasi!");

     $uid_target=mysql_fetch_array($sth1);

     ticker($uid_target["uid"],"Enemy spies launched a deadly nuclear attack agaonst Planet ".$planetname." $killed were killed!","s");
     break;
     case "V":
       $sth1=mysql_query("select population from planets where id=".$covertops["target"]);

     if (!$sth1)
       echo("Datasb faileur!");

     $pop=mysql_fetch_array($sth1);

     mt_srand ((double) microtime() * 1000000);

     $killed=round($pop["population"]*((mt_rand(30,80))/(100)));

     $planetname = get_planetname($covertops["target"]);

     $sth1=mysql_query("update planets set population=population-$killed where id=".$covertops["target"]);

     if (!$sth1)
       echo("udFH failuewr!");

     ticker($covertops["uid"],"Your spies deployed a deadly virus on Planet ".$planetname." $killed were killed!","s");

     $sth1=mysql_query("select uid from planets where id=".$covertops["target"]);

     if (!$sth1)
       echo("Database dfasi!");

     $uid_target=mysql_fetch_array($sth1);

     ticker($uid_target["uid"],"Enemy spies deployed a deadly virus on Planet ".$planetname." $killed were killed!","s");
     break;
     case "A":
       $sth1=mysql_query("select imperium from users where id=$imperium");

     if (!$sth1)
       echo("Databsae faileru!");

     $imp_name=mysql_fetch_array($sth1);

     $sth1=mysql_query("select id,name,value from admirals where uid=$imperium order by rand()");

     if (!$sth1)
       echo("Dtzasa faielru!");

     if (mysql_num_rows($sth1)==0)
     {
       ticker($covertops["uid"],"Your spies didn't find an admiral of Imperium ".$imp_name["imperium"]."!","s");
       return 0;
     }

     $admiral=mysql_fetch_array($sth1);

     $sth1=mysql_query("delete from admirals where id=".$admiral["id"]);

     if (!$sth1)
       echo("Dzasakhbd faileur!");

     ticker($covertops["uid"],"Your spies killed Admiral ".$admiral["name"]." of Imperium ".$imp_name["imperium"]."!","s");

     ticker($imperium,"Admiral ".$admiral["name"]." was assasinated!","w");
     break;
     case "T":
       $sth1=mysql_query("select imperium from users where id=$imperium");

     if (!$sth1)
       echo("Databsae faileru!");

     $imp_name=mysql_fetch_array($sth1);

     $sth1=mysql_query("select sid from tradestations where uid=$imperium");

     if (!$sth1)
       echo("Dtasgha faij!");

     if (mysql_num_rows($sth1)==0)
       ticker($covertops["uid"],$imp_name["imperium"]." doesn't have a tradestation. Mission aborted.","w");

     list($stationid)=mysql_fetch_row($sth1);

     $sth1=mysql_query("update tradestations set fail_chance=fail_chance+(rand()*10+1) where sid=$stationid");

     if (!$sth1)
       echo("Datsbae fauO!");

     ticker($covertops["uid"],"Your spies have successfully sabotaged ".$imp_name["imperium"]."'s tradestation","w");

     break;
   }
 }
 else
 {
   mt_srand((double) microtime() * 10000000);

   $random=mt_rand(0,100);

   if ($random<=50) // % Chance, dass die Attacke bemerkt wurde
   {
     if ($random<=20) // % Chance, dass Ursprung bekannt ist
     {
       $sth1=mysql_query("select name,imperium from users where id=".$covertops["uid"]);

       if (!$sth1)
  echo("Dtas afa!");

       $att_name=mysql_fetch_array($sth1);

       ticker($imperium,"Your spies intercepted some enemy spies. Their leader is ".$att_name["name"]." (".$att_name["imperium"].")!","s");
     }
     else
     {
       ticker($imperium,"Your spies intercepted some enemy spies!","s");
     }
   }
 }
    }

  $sth=mysql_query("delete from covertops where time<=1");

  if (!$sth)
    echo("Dtabas faislru!");
  
  $sth=mysql_query("update covertops set time=time-'1'");

  if (!$sth)
    echo("Dtasbwer failure!");
}

function admirals()
{
  $sth=mysql_query("select u.id from users u where (select count(*) from planets p where p.uid=u.id)-(select count(*) from admirals a where a.uid=u.id)>0 order by rand() limit 1");

  if (mysql_num_rows($sth)==0)
  {
    return true;
  }

  list($uid)=mysql_fetch_row($sth);

  $sth=mysql_query("select * from vornamen order by rand() limit 1");

  if (!$sth)
    echo("Database error!");

  $vor=mysql_fetch_array($sth);

  $sth=mysql_query("select * from nachnamen order by rand() limit 1");

  if (!$sth)
    echo("Database error!");

  $nach=mysql_fetch_array($sth);

  $sth=mysql_query("select * from portraits where gender='".$vor["gender"]."' order by rand()");

  if (!$sth)
    echo("Datasbe failure!");

  $pic=mysql_fetch_array($sth);

  $sth=mysql_query("insert into admirals (value,uid,name,fid,pic,initiative,agility,sensor,weaponskill) values ('0','".$uid."','".addslashes($vor["name"])." ".addslashes($nach["name"])."','0','".$pic["pic"]."',1,1,1,1)");

  if (!$sth)
    echo("Datasbe failuer!");
}

function forums()
{
  $sth=mysql_query("delete from forums where time<'".date("Y-m-d H:i:s",mktime(0,0,0,date("m"),(date("d")-10),date("Y")))."' and fid is not null");

  if (!$sth)
    echo("Dtaabase failure!");

  $sth=mysql_query("select f.id from forums as f left join forums as f2 on f.id=f2.fid where f2.fid is null and f.fid is null and f.time<'".date("Y-m-d H:i:s",mktime(0,0,0,date("m"),(date("d")-10),date("Y")))."'"); 

  if (!$sth)
    echo("Dtaabase failure!");

  while ($ids=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("delete from forums where id=".$ids["id"]);

    if (!$sth1)
      echo("Dtaabase faileur!");
  }

}

function population()
{
  $sth=mysql_query("drop table if exists __tmp_maxpop");

  if (!$sth)
  {
    echo("ERR::DROP TMPPOP");
    return false;
  }

  $sth=mysql_query("create table __tmp_maxpop (pid int not null,max_pop int not null,primary key(pid))");

  if (!$sth)
  {
    echo("ERR::CREATE TMPPOP");
    return false;
  }

  $sth=mysql_query("insert into __tmp_maxpop select p.id,v.max_poplevel+count(pr.prod_id) from planets p,planet_values v left join constructions c on c.pid=p.id left join production pr on pr.prod_id=c.prod_id and pr.special in ('P','L') where p.type=v.type and p.uid!=0 group by p.id");

  if (!$sth)
  {
    echo("ERR::INSERT TMP MAXPOP");
    return false;
  }
  
  // mop: fuck fuck fuck...multi table updates können keine group by funktionen....also mal wieder ne lustige zwischentabelle...
  $sth=mysql_query("replace into popgain (pid,gain,max_poplevel) select p.id,if(p.population+p.population*(v.gain+(count(pr.prod_id)*0.01))>pow(2,t.max_pop-1)*1000 and p.population=pow(2,t.max_pop-1)*1000,0,v.gain+(count(pr.prod_id)*0.01)),t.max_pop from planets p,planet_values v,__tmp_maxpop t left join constructions c on c.pid=p.id left join production pr on pr.prod_id=c.prod_id and pr.special in ('P','G') where p.type=v.type and p.uid!=0 and t.pid=p.id group by p.id");

  if (!$sth)
    echo("ERR::CALC POPGAIN\n");
  
  $sth=mysql_query("update planets p,popgain g set p.population=if(p.population+p.population*g.gain>pow(2,g.max_poplevel-1)*1000,pow(2,g.max_poplevel-1)*1000,p.population+p.population*g.gain) where p.uid!=0 and g.pid=p.id");

  if (!$sth)
    echo("ERR::POPULATION\n");
}

function fleet_scan()
{
  $no_scan=100;

  $sth=mysql_query("select p.id,p.uid,p.name,s.x,s.y from planets as p,systems as s where uid!=0 and p.sid=s.id");

  if (!$sth)
    echo("Databaser failuer!");

  while ($planets=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select max(s.radius) from scanradius as s,constructions as b where s.prod_id=b.prod_id and b.pid=".$planets["id"]);

    if (!$sth1)
      echo("Database failure!");

    $radius=mysql_fetch_row($sth1);

    if ($radius[0]==NULL)
      $radius[0]=$no_scan;

    $sth1=mysql_query("select * from systems where (x-".$planets["x"].")*(x-".$planets["x"].")+(y-".$planets["y"].")*(y-".$planets["y"].")<=".$radius[0]."*".$radius[0]);

    if (!$sth1)
      echo("Database failure!");

    while ($systems=mysql_fetch_array($sth1))
    {
      // XXX KAPUTT....was macht das?! :S:S:
      $sth2=mysql_query("select f.uid,f.fid,f.sid from fleet_info as f,planets as p where f.pid=0 and f.tsid!=0 and f.tpid!=0 and f.uid!=".$planets["id"]." and f.tsid=p.sid and p.id=".$planets["id"]." and f.sid=".$systems["id"]);

      if (!$sth2)
        echo("Database failure!");

      while ($fleets=mysql_fetch_array($sth2))
      {
        $sth3=mysql_query("select alliance from users where id=".$fleets["uid"]);

        if (!$sth3)
          echo("Databsae failure!");

        $fleet_alliance=mysql_fetch_array($sth3);

        $sth3=mysql_query("select alliance from users where id=".$planets["uid"]);

       if (!$sth3)
         echo("Databsae failure!");

       $planet_alliance=mysql_fetch_array($sth3);

       if ($planet_alliance["alliance"]!=$fleet_alliance["alliance"])
       {
         if ($planets["name"]=="Unnamed")
           $planets["name"]=get_planetname($planets["id"]);

         ticker($planets["uid"],"*lfleet.php* An enemy fleet is closing in to system of planet ".$planets["name"]."!","w");
       }
      }
    }
  }
}

function jumpgates()
{
  // mop: anstatt die jumpgates einzeln rauszusuchen und dann zu updaten nehme ich lieber einfach alle jumpgates, die es gibt und mache dann nen update auf die prod_id

  $sth=mysql_query("select prod_id,reload from jumpgatevalues");

  if (!$sth)
    echo("ajjajajaja failuer");
  
  while (list($prod_id,$reload)=mysql_fetch_row($sth))
  {
    $sth1=mysql_query("update jumpgates set used_tonnage=used_tonnage-$reload where used_tonnage>0 and prod_id=$prod_id");
    
    if (!$sth)
      echo("DSUaut fa!");
  }
  
  $sth=mysql_query("update jumpgates set used_tonnage=0 where used_tonnage<0");

  if (!$sth)
    echo("Database failure!");
}

function tradestationrepair()
{
  $sth=mysql_query("update tradestations set fail_chance=fail_chance-(rand()*2+1) where fail_chance>1");

  if (!$sth)
    echo("Database failure!");

  $sth=mysql_query("update tradestations set fail_chance=1 where fail_chance<1");
  
  if (!$sth)
    echo("Database failure!");
}

function movements()
{
  // mop: reload updaten
  $sth=mysql_query("update fleet set reload=reload-1 where reload>0");

  if (!$sth)
    echo("Database failure reload!");
  
  // mop: alle bewegungen erfassen
  $fleets=get_global_movements();

  for ($i=0;$i<sizeof($fleets);$i++)
  {
    // mop: bewegung an rand des systems (flotte will springen sitzt aber noch auf nem planeten)
    if ($fleets[$i]["tsid"]!=$fleets[$i]["sid"] && $fleets[$i]["pid"]!=0)
    {
      // mop: einfach an den rand des systems setzen => pid=0 und der rest bleibt
      set_flocation($fleets[$i]["fid"],0,$fleets[$i]["sid"],$fleets[$i]["tpid"],$fleets[$i]["tsid"]);
    }
    // mop: in den restlichen fällen befindet sich die flotte schon am rand und kann (bei reload=0) springen.
    //      reload etc wird hier noch nicht ausgewertet
    elseif ($fleets[$i]["tsid"]!=$fleets[$i]["sid"])
    {
      move_system_system($fleets[$i]);
    }
    // mop: innerer system flug
    elseif ($fleets[$i]["tsid"]==$fleets[$i]["sid"])
    {
      // mop: zu nem planeten
      if ($fleets[$i]["pid"]!=$fleets[$i]["tpid"] && $fleets[$i]["tpid"]!=0)
  ticker($fleets[$i]["uid"],"*lfleet.php*Fleet ".$fleets[$i]["name"].": arrived at planet ".get_planetname($fleets[$i]["tpid"]),"w");
      
      set_flocation($fleets[$i]["fid"],$fleets[$i]["tpid"],$fleets[$i]["tsid"],0,0);
    }
    else
    {
      echo("Kaputter Flug!!!!!!!!!\n");
      var_dump($fleets[$i]);
      echo("===================\n");
    }
  }
}

function alliance_locks()
{
  $sth=mysql_query("delete from alliance_lock where lock_date<date_sub(now(),interval 7 day)");

  if (!$sth)
    echo("ERR::alliance lock\n");
}

function reload_shields()
{
	$sth=mysql_query("UPDATE planetary_shields SET value=value+regeneration+regeneration_bonus");
	$sth=mysql_query("UPDATE planetary_shields SET value=max_value WHERE value>max_value");
}

function production_factor()
{
  $sth=mysql_query("update planets set production_factor=production_factor+0.01 where production_factor<1.00");

  if (!$sth)
    echo("ERR::UPDATE PRODUCTION FACTOR\n");
}

function militia()
{
  $sth=mysql_query("select prod_id from production where name='Militia'");

  if (!$sth || mysql_num_rows($sth)!=1)
  {
    echo("ERR::GET MILITIA\n");
    return false;
  }

  list($prod_id)=mysql_fetch_row($sth);
 
  $poplevel="floor((log10(p.population/1000)/log10(2))+1)";
 
  $sth=mysql_query("replace into infantery (prod_id,count,pid,uid) select ".$prod_id.",ifnull(if(i.count+".$poplevel.">=".$poplevel."*100,".$poplevel."*100,i.count+".$poplevel."),".$poplevel."),p.id,p.uid from planets p left join infantery i on p.id=i.pid and p.uid=i.uid and i.prod_id=".$prod_id." where p.uid!=0");

  if (!$sth)
    echo("ERR::UPDATE INFANTRY\n");
}

echo("Start : ".date("H:i:s")."\n");
echo ("Connect!\n");
connect();
/*
echo("TRADE STATS\n");
build_trade_statistic();
echo("Movements!\n");
movements();*/
echo("Production\n");
production();/*
echo("Reload planetary shields\n");
reload_shields();
echo("Ressources\n");
ressources_new();
echo("Research\n");
research();
echo("Colonisations\n");
colonisations();
echo("Alliances!\n");
alliances();
echo("Covertops\n");
covertops();
echo("Admirals\n");
admirals();
echo("Forums\n");
forums();
echo("Population\n");
population();
echo("Fleet scan\n");
fleet_scan();
echo("Jumpgates\n");
jumpgates();
echo("Tradestationwartung\n");
tradestationrepair();
echo("Alliance locks\n");
alliance_locks();
echo("Production factor upgrade\n");
production_factor();
echo("Milizen\n");
militia();*/
echo("Ende : ".date("H:i:s")."\n");
?>
