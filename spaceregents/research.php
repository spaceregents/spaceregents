<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/research.inc.php";

if ($not_ok)
  return 0;

  // Bis hier immer so machen:)

function show_research()
{
  global $uid;
  global $PHP_SELF;
  
  $queue=get_research_queue($uid);
  
  $sth=mysql_query("select * from research as r,tech as t where uid=$uid and r.t_id=t.t_id order by t.com_time asc");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $i=0;

  if (mysql_num_rows($sth)!=0)
  {

    while ($research=mysql_fetch_array($sth))
    {
      // mop: Theorie
      if ($research["flag"]=="T")
      {
        $theory[$i]=$research;
        $theory[$i]["researched"]=true;
        $i++;
      }
      else
      {
        // mop: technologie hinzufügen
        $research["researched"]=true;
        $techs[$research["depend"]][]=$research;
      }
    }
  }
  else
    show_message("You haven't researched anything so far!");


  $sth=mysql_query("select t.* from tech as t left join research as r on t.t_id=r.t_id and r.uid=$uid where r.t_id is NULL order by t.com_time asc");
  if (!$sth)
  {
    show_error("Database failuer!");
    return 0;
  }

  while ($research=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select * from tech where t_id=".$research["t_id"]." and depend is NULL");

    $sth2=mysql_query("select * from tech as t,research as r where r.t_id=t.excl and t.t_id=".$research["t_id"]);

    $sth3=mysql_query("select * from tech as t,research as r where t.depend=r.t_id and r.uid=$uid and t.t_id=".$research["t_id"]);

    if (((mysql_num_rows($sth1)>0) or (mysql_num_rows($sth3)>0)) and (mysql_num_rows($sth2)==0))
    {
      if ($research["flag"]=="T")
      {
        $theory[$i]=$research;
        $i++;
      }
      else
      {
        $techs[$research["depend"]][]=$research;
      }
    }
  }

  $sth=mysql_query("select * from researching as r,tech as t where uid=$uid and r.t_id=t.t_id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $researching=false;

  if (mysql_num_rows($sth)!=0)
  {
    $tech=mysql_fetch_array($sth);

    if ($tech["flag"]=="T")
    {
      for ($k=0;$k<sizeof($theory);$k++)
      {
        if ($theory[$k]["t_id"]==$tech["t_id"])
          $theory[$k]["researching"]=true;
      } 
    }
    else
    {
      $j=0;

      while (isset($techs[$tech["depend"]][$j]))
      {
        if ($techs[$tech["depend"]][$j]["t_id"]==$tech["t_id"])
        {
          $techs[$tech["depend"]][$j]["researching"]=true;
        }
        $j++;
      }
    }

    $researching=true;
  }

  if (!(is_array($tech)) and !(is_array($theory)))
  {
    show_error("Something is really going wrong:((( Sorry....");
    return 0;
  }

  table_start("center","500");
  table_head_text(array("Techtree"),"10");
  table_text(array("&nbsp;"),"","","10","head");
  for ($i=(sizeof($theory)-1);$i>=0;$i--)
  {
    table_text_open();
    // mop: theorien
    if (!$theory[$i]["researched"])
    {
      if ($theory[$i]["researching"])
        table_text_design("<img src='arts/t".$theory[$i]["t_id"].".jpg' width='50' height='50' alt='".$theory[$i]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$theory[$i]["t_id"]."&time=".$theory[$i]["com_time"]."'>researching</a>","50");
      elseif (in_array($theory[$i]["t_id"],$queue))
        table_text_design("<img src='arts/t".$theory[$i]["t_id"].".jpg' width='50' height='50' alt='".$theory[$i]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$theory[$i]["t_id"]."&time=".$theory[$i]["com_time"]."'>Enqueued</a>","50");
      else
        table_text_design("<img src='arts/t".$theory[$i]["t_id"].".jpg' width='50' height='50' alt='".$theory[$i]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$theory[$i]["t_id"]."&time=".$theory[$i]["com_time"]."'>Info</a>","50");
      table_text_design("&nbsp;","","","9");
      table_text_close();

      if ($i>0)
      {
        table_text_open();
        table_text_design("<img src='arts/tech_vborder.gif' width='5' height='21'>","50","center");
        table_text_design("&nbsp;","","","9");
        table_text_close();
      }
    }
    // mop: techs
    else
    {
      table_text_open();
      table_text_design("<img src='arts/t".$theory[$i]["t_id"].".jpg' width='50' height='50' alt='".$theory[$i]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$theory[$i]["t_id"]."&time=".$theory[$i]["com_time"]."'>finished</a>","50");
      table_text_design("<img src='arts/tech_hborder.gif' width='21' height='5'>","50");
      for ($j=0;$j<sizeof($techs[$theory[$i]["t_id"]]);$j++)
      {
        if (!$techs[$theory[$i]["t_id"]][$j]["researched"])
        {
          if ($techs[$theory[$i]["t_id"]][$j]["researching"])
          {
            table_text_design("<img src='arts/t".$techs[$theory[$i]["t_id"]][$j]["t_id"].".jpg' width='50' height='50' alt='".$techs[$theory[$i]["t_id"]][$j]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$techs[$theory[$i]["t_id"]][$j]["t_id"]."&time=".$techs[$theory[$i]["t_id"]][$j]["com_time"]."'>researching</a>","50");
            if (($j+1)<sizeof($techs[$theory[$i]["t_id"]]))
              table_text_design("<img src='arts/tech_hborder.gif' width='21' height='5'>","50");
          }
          elseif (in_array($techs[$theory[$i]["t_id"]][$j]["t_id"],$queue))
          {
            table_text_design("<img src='arts/t".$techs[$theory[$i]["t_id"]][$j]["t_id"].".jpg' width='50' height='50' alt='".$techs[$theory[$i]["t_id"]][$j]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$techs[$theory[$i]["t_id"]][$j]["t_id"]."&time=".$techs[$theory[$i]["t_id"]][$j]["com_time"]."'>Enqueued</a>","50");
            if (($j+1)<sizeof($techs[$theory[$i]["t_id"]]))
              table_text_design("<img src='arts/tech_hborder.gif' width='21' height='5'>","50");
          }
          else
          {
            table_text_design("<img src='arts/t".$techs[$theory[$i]["t_id"]][$j]["t_id"].".jpg' width='50' height='50' alt='".$techs[$theory[$i]["t_id"]][$j]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$techs[$theory[$i]["t_id"]][$j]["t_id"]."&time=".$techs[$theory[$i]["t_id"]][$j]["com_time"]."'>Info</a>","50");
            if (($j+1)<sizeof($techs[$theory[$i]["t_id"]]))

              table_text_design("<img src='arts/tech_hborder.gif' width='21' height='5'>","50");
          }
        }
        else
        {
          table_text_design("<img src='arts/t".$techs[$theory[$i]["t_id"]][$j]["t_id"].".jpg' width='50' height='50' alt='".$techs[$theory[$i]["t_id"]][$j]["name"]."'><br><a href='".$PHP_SELF."?act=show&tid=".$techs[$theory[$i]["t_id"]][$j]["t_id"]."&time=".$techs[$theory[$i]["t_id"]][$j]["com_time"]."'>finished</a>","50");
          if (($j+1)<sizeof($techs[$theory[$i]["t_id"]]))

            table_text_design("<img src='arts/tech_hborder.gif' width='21' height='5'>","50");
        }

      }

      if ($i>0)
      {
        table_text_close();
        table_text_open();
        table_text_design("<img src='arts/tech_vborder.gif' width='5' height='21'>","50","center");
        table_text_design("&nbsp;","","","9");
        table_text_close();
      }
    }
  }
  table_end();

}

function start()
{
  global $uid;
  global $tid;
  global $time;

  $sth=mysql_query("select * from tech where t_id=$tid and com_time=$time");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Little hacker, eh? :D");
    return 0;
  }

  $sth=mysql_query("select * from researching where uid='".$uid."'");

  if (mysql_num_rows($sth)>0)
  {
    show_error("You are already researching!");
    status();
    show_research();
    return 0;
  }

  $sth=mysql_query("select t.* from tech as t left join research as r on t.t_id=r.t_id and r.uid=$uid and r.t_id=$tid where r.t_id is NULL");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $ausgabe=false;

  while ($research=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select * from tech where t_id=".$research["t_id"]." and depend is NULL");

    // $sth2=mysql_query("select * from tech as t left join research as r on (t.excl=r.t_id and r.uid=$uid) where r.t_id is NULL and t.t_id=".$research["t_id"]);

    $sth2=mysql_query("select t.* from tech as t,research as r where r.t_id=t.excl and t.t_id=".$research["t_id"]);

    $sth3=mysql_query("select t.* from tech as t,research as r where t.depend=r.t_id and r.uid=$uid and t.t_id=".$research["t_id"]);

    if (((mysql_num_rows($sth1)>0) or (mysql_num_rows($sth3)>0)) and (mysql_num_rows($sth2)==0) and ($research["t_id"]==$tid))
    {
      $ausgabe=true;
    }

  }

  if ($ausgabe!=true)
  {
    show_error("You are not permitted to research this technology!");
    status();
    show_research();
    return 0;
  }

  $sth=mysql_query("insert into researching (t_id,uid,time) values ('$tid','$uid','$time')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
}

function show()
{
  global $PHP_SELF;
  global $uid;
  global $tid;
  global $time;

  $queue=get_research_queue($uid);
  
  $sth = mysql_query("select t_id from research where uid=".$uid."");
  
  if (!$sth) {
    show_error("ERR::DB failure");
    return false;
  }
  
  while ($researched = mysql_fetch_array($sth)) {
    $already_researched[] = $researched["t_id"];
  }
  

  $sth=mysql_query("select * from tech where t_id=$tid and com_time=$time");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Little hacker, eh? :D");
    return 0;
  }

  $tech=mysql_fetch_array($sth);

  table_start("center","500");
  table_head_text(array("Information"),"5");
  table_text(array("&nbsp;"),"","","5","text");
  table_text(array("<br><strong>".$tech["name"]."</strong>"),"center","","5","head");
  table_text(array("<img src='arts/t".$tid."big.jpg' width='100' height='100' alt='".$tech["name"]."' align='left'>
        <br>".$tech["description"]."
        <br><a href='manual/tech".$tech["t_id"].".html'>learn more</a>"),"center","","5","text");
  table_text_open();
  table_text_design("Time to research:","200","center","3","head");
  table_text_design($time,"400","center","2","text");
  table_text_close();

  print_advancements($tid);

  $sth1=mysql_query("select r.t_id from tech as t, research as r where r.uid=$uid and r.t_id=t.t_id and r.t_id=$tid");

  if (!$sth1)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth1)>0)
    $has_tech=true;

  $sth1=mysql_query("select * from researching where uid=$uid");

  $status=mysql_fetch_array($sth1);
  if (($status=="") and (!$has_tech))
    table_text(array("<a href='".$PHP_SELF."?act=start&tid=".$tid."&time=".$time."&time=".$time."'>establish research</a>"),"center","","5","head");
  elseif (!in_array($tid,$queue) && !in_array($tid,$already_researched) && sizeof($queue)<=5 && $status["t_id"] != $tid)
    table_text(array("<a href='".$PHP_SELF."?act=enqueue&tid=".$tid."'>enqueue</a>"),"center","","5","head");
  else
    table_text(array("&nbsp;"),"center","","5","head");

  table_end();
  echo("<br><br>\n");
}

function print_advancements($tid)
{
  $production=get_production_by_tech($tid);

  // hier wird die advance ausgabe vorbereitet (also was die tech bringt)

  if (is_array($production))
  {
    while (list($type,$prod_arr)=each($production))
    {
      while (list($prod_id,$info)=each($production[$type]))
      {
        if (isset($info["manual"]))
          $advance[$type].="<a href=\"".$info["manual"]."\" target=\"_blank\"><img src=\"arts/".$prod_id.".jpg\" width=\"50\" height=\"50\" alt=\"".$info["name"]."\" border=\"0\"></a><br>".$info["name"]."<br>";
        else
          $advance[$type].=$info["name"]."<br>";

      }
    }
  }

  // mop: Colonistenboost berücksichtigen
  if ($tech["special"] & COLONIST_BOOST)
    $advance["M"].="Colonist boost<br>";

  $sth=mysql_query("select s.name from special_actions s,tech t where t.t_id=s.t_id and t.t_id=".$tid);

  if (!$sth)
  {
    show_error("ERR::GET SPECIAL ACTIONS");
    return false;
  }

  while (list($special)=mysql_fetch_row($sth))
    $advance["M"].=$special."<br>";

  if (isset($advance))
  {
    table_text_open();
    table_text_design("Planetary","100","center","","head");
    table_text_design("Orbital","100","center","","head");
    table_text_design("Infantry","100","center","","head");
    table_text_design("Fleet","100","center","","head");
    table_text_design("Misc","100","center","","head");
    table_text_close();
    table_text_open();

    foreach (array("P","O","I","S","M") as $index)
    {
      if (!isset($advance[$index]))
        $advance[$index]="&nbsp;";
      table_text_design($advance[$index],"100","center","","text");
    }
  }
}

function status()
{
  global $uid;

  $sth=mysql_query("select * from researching where uid=$uid");

  if (!$sth)
  {
    show_message("Database Failure!");
    return 0;
  }

  $status=mysql_fetch_array($sth);

  table_start("center","500");
  table_head_text(array("Current research"),"5");
  table_text(array("&nbsp;"),"","","5","text");

  if ($status!="")
  {
    $sth2=mysql_query("select * from tech where t_id=".$status["t_id"]."");
    $tech=mysql_fetch_array($sth2);

    table_text(array("<br><strong>".$tech["name"]."</strong>"),"center","","5","head");
    table_text(array("<img src='arts/t".$tech["t_id"]."big.jpg' width='100' height='100' alt='".$tech["name"]."' align='left'>
          <br>".$tech["description"]."
          <br><a href='manual/tech".$tech["t_id"].".html'>learn more</a>"),"center","","5","text");
    table_text_open();
    table_text_design("Time left:","100","center","3","head");
    table_text_design($status["time"],"400","center","2","text");
    table_text_close();
    print_advancements($status["t_id"]);
    table_end();
  }
  else
  {
    table_text(array("<br><strong>No Research established</strong>"),"center","","5","head");
    table_end();
  } 
  echo("<br><br>\n");
  
  // mop: research_queue holen
  $queue=get_research_queue($uid);
  
  table_start("center","500");
  table_head_text(array("Research queue"),sizeof($queue));
  table_text(array("&nbsp;"),"","",sizeof($queue),"text");
  
  if (sizeof($queue)==0)
  {
    table_text(array("<br><strong>Research queue is empty</strong>"),"center","",sizeof($queue),"head");
  }
  else
  {
    $output_arr=array();
    $option_arr=array();
    for ($i=0;$i<sizeof($queue);$i++)
    {
      $t_id=$queue[$i];
      $sth2=mysql_query("select * from tech where t_id=".$t_id);
      $tech=mysql_fetch_assoc($sth2);
      
      $output_arr[]="<img src='arts/t".$t_id.".jpg' alt='".$tech["name"]."' align='center'>";
      // mop: optionen dazu bauen
      $options="";
      if ($i!=0)
        $options.="<a href=\"".$_SERVER["PHP_SELF"]."?act=qmove&direction=l&tid=".$t_id."\">&lt;</a>";
      $options.="<a href=\"".$_SERVER["PHP_SELF"]."?act=qremove&tid=".$t_id."\">x</a>";
      if ($i!=sizeof($queue)-1)
        $options.="<a href=\"".$_SERVER["PHP_SELF"]."?act=qmove&direction=r&tid=".$t_id."\">&gt;</a>";
      $option_arr[]=$options;
    }
    table_text($output_arr,"center");
    table_text($option_arr,"center");
  }
  table_end();
  echo("<br><br>\n");
}

function enqueue()
{
  global $uid;

  $queue=get_research_queue($uid);
  
  // mop: maximal 5 sachen in der queue
  if (sizeof($queue)>=5)
  {
    show_error("You can't enqueue more than 5 techs");
    return false;
  }

  if (!can_research($uid,$_GET["tid"]))
  {
    show_error("blalbla....damn hackattack...FUFUUFUFUFUFUF!");
    return false;
  }

  if (in_array($_GET["tid"],$queue))
  {
    show_error("Researching one thing two times doesn't make much sense ;)");
    return false;
  }
  $queue[]=$_GET["tid"];

  save_research_queue($uid,$queue);
}

function qremove()
{
  global $uid;
  
  $queue=get_research_queue($uid);

  $old_queue=$queue;
  
  foreach ($old_queue as $i => $tid)
  {
    if ($tid==$_GET["tid"])
    {
      unset($queue[$i]);
    }
  }
  save_research_queue($uid,array_values($queue));
}

function qmove()
{
  global $uid;
  $queue=get_research_queue($uid);

  if (sizeof($queue)<=1)
    return;
    
  $done=false;
  
  for ($i=0;$i<sizeof($queue) && !$done;$i++)
  {
    if ($queue[$i]==$_GET["tid"])
    {
      if ($_GET["direction"]=="l" && $i!=0)
      {
        $tmp=$queue[$i];
        $queue[$i]=$queue[$i-1];
        $queue[$i-1]=$tmp;
        $done=true;
      }
      elseif ($_GET["direction"]=="r" && $i+1<sizeof($queue))
      {
        $tmp=$queue[$i];
        $queue[$i]=$queue[$i+1];
        $queue[$i+1]=$tmp;
        $done=true;
      }
    }
  }
  save_research_queue($uid,array_values($queue));
}

switch ($act)
{
  case "show":
    show();
  status();
  show_research();
  break;
  case "start":
    start();
  status();
  show_research();
  break;
  case "enqueue":
    enqueue();
  status();
  show_research();
  break;
  case "qremove":
    qremove();
  status();
  show_research();
  break;
  case "qmove":
    qmove();
  status();
  show_research();
  break;
  default:
  status();
  show_research();
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
