<?
// ********************************
//
//  delete_empty_fleets()
//  get_fids_by_pid($pid,$uid=0,$sid=0)
//  get_fcount_by_type($uid,$type,$pid=false)
//  get_admiral($fid)
//  get_fcount($uid)
//  get_fids_by_uid($uid, $constellations = 0,$order_by = 0)
//  get_coords_by_fid($fid)
//  get_ship_info($prod_id)
//  print_ship_info($prod_id)
//  quick_colonize($uid,$pid)
//  eta_to_planet($x,$y,$tx,$ty,$range,$old,$count="0")
//  set_mission($fid,$mission,$sid,$pid=0)
//  is_a_fleet_in_system($uid, $sid)
//  get_fids_by_sid($sid,$uid)
//  get_shipcount_by_fid($fid)
//  get_strongest_ship_by_fid($fid)
//  get_fleet_name($fid)
//  get_shipcount_by_fid($fid, $prod_id = 0)  - wenn prod_id == 0 dann GESAMT schiffzahl
//  get_uid_by_fid($fid)
//  get_sid_by_fid($fid)
//  set_route($route, $fid)
//  get_system_fleets($sid)
//  get_fids_by_prod_id($prod_id,$uid)
//  get_interplanetar_movements($uid,$sid);
//  get_jump_movements($uid,$sid)
//  get_inner_movements($uid,$sid)
//  is_own_fleet($fid, $type = 0) // wenn $type=1 : TRUE wenn die Flotte alliiert ist!
//  get_max_scanrange_by_fid($fid)
//  get_fleet_pic($fid)
//  get_transporters($fid)
//  get_infantry_by_fid($fid)
//  get_transport_data_by_fid($fid)
//  get_max_reload
//  get_special_fleet_actions($fid, $type)
//  fleet_is_examinable($fid, $sid=0)
//  fleet_add($fid, $prod_id, $count)
// get_infantrycount_by_fid($fid)
// get_fleet_target($fid)
// has_bombers($fid)
// has_noscan_ships_and_constructions($fid)   // check die flotte nach schiffen mit special 'N' bzw, gebäuden vor Ort mit special 'N'
// ********************************

DEFINE (PIC_ROOT, "arts/");
DEFINE ("ADMIRAL_ROOT","portraits/");

function delete_empty_fleets()
{
  $sth=mysql_query("delete from fleet where count<=0");

  $sth1=mysql_query("select fi.fid from fleet_info as fi left join fleet as f on fi.fid=f.fid where f.fid is NULL");

  while ($fleets=mysql_fetch_row($sth1))
  {
    $sth2=mysql_query("delete from fleet_info where fid=".$fleets[0]);
    $sth3=mysql_query("delete from routes where fid=".$fleets[0]);
    $sth4=mysql_query("update admirals set fid=0 where fid=".$fleets[0]);
  }

  if ((!$sth) || (!$sth1) || (!$sth2) || (!$sth3) || ($sth4))
    return false;
  else
    return true;
}

function get_fids_by_pid($pid,$uid=0,$sid=0)
{
  if ($uid==0)
    $sth=mysql_query("select fid from fleet_info where pid='$pid'");
  elseif ($sid==0)
    $sth=mysql_query("select fid from fleet_info where pid=$pid and uid=$uid");
  else
    $sth=mysql_query("select fid from fleet_info where pid=$pid and uid=$uid and sid=$sid");


  if (!$sth)
    return false;

  $fid=array();

  while ($fids=mysql_fetch_row($sth))
  {
    $fid[]=$fids[0];
  }

  return $fid;
}

function get_fcount_by_type($uid,$type,$pid=false)
{
  // returnt die anzahl an schiffen nach typ (L,M,H) etc.

  if (!$pid)
    $sth=mysql_query("select sum(f.count) from fleet as f,production as p left join fleet_info as fi on fi.fid=f.fid and fi.uid=".$uid." where p.prod_id=f.prod_id and p.typ='$type' and fi.uid is not null");
  else
    $sth=mysql_query("select sum(f.count) from fleet as f,production as p left join fleet_info as fi on fi.fid=f.fid and fi.uid=".$uid." and fi.pid=$pid where p.prod_id=f.prod_id and p.typ='$type' and fi.uid is not null");

  if (!$sth)
    return false;

  $count=mysql_fetch_row($sth);

  if ($count[0]==NULL)
    $count[0]=0;

  return $count[0];
}


/***********************
*
* function get_admiral($fid)
*
***********************/
function get_admiral($fid)
{
  $sth=mysql_query("select id from admirals where fid=".$fid);

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $admiral=mysql_fetch_row($sth);

  return $admiral[0];
}

function get_fcount($uid)
{
  $sth=mysql_query("select count(fid) from fleet_info where uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $count=mysql_fetch_row($sth);

  return $count[0];
}


//******************
//
// function get_fids_by_uid($uid, $constellations = 0,$order_by = 0)
// $constellations muss ein ARRAY sein
//
//******************
function get_fids_by_uid($uid, $constellations = 0, $order_by = 0)
{
  if ($constellations == 0)
  {
    if ($order_by)
      $sth=mysql_query("select fid from fleet_info where uid=$uid order by ".$order_by);
     else
      $sth=mysql_query("select fid from fleet_info where uid=$uid");

    if (!$sth)
      return false;

    if (mysql_num_rows($sth)==0)
      return false;

    while ($fleets=mysql_fetch_row($sth))
    {
      $fids[]=$fleets[0];
    }
  }
  else
  {
    if (is_array($constellations))
    {
      for ($i = 0; $i < sizeof($constellations); $i++)
      {
        $systems[] = get_sid_by_cid($constellations[$i]);
      }

      for ($i = 0; $i < sizeof($systems); $i++)
      {
        for ($j = 0; $j < sizeof($systems[$i]); $j++)
        {
          if ($order_by)
            $sth = mysql_query("select fid from fleet_info where uid=$uid and sid='".$systems[$i][$j]."' order by ".$order_by);
          else
            $sth = mysql_query("select fid from fleet_info where uid=$uid and sid='".$systems[$i][$j]."'");

          if (!$sth)
            return 0;

          while ($its_fleets = mysql_fetch_array($sth))
          {
            $fids[]=$its_fleets[0];
          }
        }
      } // end for $i
    }
  }
  return $fids;
}

function get_coords_by_fid($fid)
{
  $sth=mysql_query("select s.x,s.y from fleet_info as f,systems as s where s.id=f.sid and f.fid=$fid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  return mysql_fetch_array($sth);
}

function get_ship_info($prod_id)
{
  $sth=mysql_query("select p.*,r.name as rname,s.* from production as p, shipvalues as s left join tech as r on r.t_id=p.tech where s.prod_id=p.prod_id and p.prod_id=$prod_id and r.t_id is not null");

  if ((!$sth) || (mysql_num_rows($sth)==0))
  {
    show_error("Database failure!");
    return false;
  }

  $info=mysql_fetch_array($sth);

  return $info;
}

function print_ship_info($prod_id)
{
  if ($info=get_ship_info($prod_id))
  {
    table_start("center","500");
    table_head_text(array("Ships info for ".$info["name"]),"6");
    table_text_open("head");
    table_text_design("&nbsp;","500","","2","head");
    table_text_close();

    $info["p_depend"]=get_name_by_prod_id($info["p_depend"]);

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
      case "E":
  $info["special"]="Freezes enemy ships";
  break;
      case "R":
  $info["special"]="Capable of stealing ships";
    break;
      case "S":
  $info["special"]="Detects cloaked ships";
  break;
      case "C":
  $info["special"]="Cloaked";
  break;
      default:
  $info["special"]="Nothing";
    }


    foreach (array("name"=>"Name","metal"=>"Metal","energy"=>"Energy","mopgas"=>"Mopgas","erkunum"=>"Erkunum","gortium"=>"Gortium","susebloom"=>"Susebloom","rname"=>"Needs tech","p_depend"=>"Needs building","initiative"=>"Initiative","agility"=>"Agility","warpreload"=>"Reload time","hull"=>"Hull","tonnage"=>"Tonnage","weaponpower"=>"Weaponpower","shield"=>"Shield","ecm"=>"ECM","sensor"=>"Sensor","weaponskill"=>"Weaponskill","target1"=>"Attacks","special"=>"Special abilities","num_attacks"=>"Number of attacks") as $key=>$show)
    {
      table_text_open("text");
      table_text_design($show,"250","","","text");
      table_text_design($info[$key],"250","","","text");
      table_text_close();
    }
    table_end();
  }
  else
  {
    show_error("Can't get ship info!");
    return 0;
  }
}

function quick_colonize($uid,$pid)
{
  if (!habitable($pid))
    return false;

  $sth=mysql_query("select p.sid,s.x,s.y from planets as p, systems as s where pid=$pid and p.sid=s.id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($sid,$tx,$ty)=mysql_fetch_row($sth);

  $sth=mysql_query("select max(w.range) from warp as w,research as r where w.tid=r.t_id and r.uid=".$uid);

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($range)=mysql_fetch_row($sth);

  $sth=mysql_query("select distinct f.fid,fi.sid from fleet as f, production as p left join fleet_info as fi on f.fid=fi.fid and fi.uid=$uid where p.prod_id=f.prod_id and fi.fid is not NULL and (p.special='O' or p.special='C')");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $found_fid=false;
  $shortest_way=false;

  while ($fid=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select x,y from systems where id=".$fid["sid"]);

    if ((!$sth1) || (mysql_num_rows($sth1)==0))
      return false;

    while ($start=mysql_fetch_array($sth1))
    {
      $length=eta_to_planet($start["x"],$start["y"],$tx,$ty,$range,array());

      if ($length)
      {
  if (!$shortest_way)
  {
    $shortest_way=$length;
    $found_fid=$fid["fid"];
  }
  else
  {
    if ($length<$shortest_way)
    {
      $shortest_way=$length;
      $found_fid=$fid["fid"];
    }
  }
      }
    }
  }

  if ($found_fid)
  {
    set_mission($found_fid,4,$sid,$pid);
    return $found_fid;
  }
  else
    return false;
}


/**************************
*
* function eta_to_planet($x,$y,$tx,$ty,$range,$old,$count="0")
*
***************************/
function eta_to_planet($x,$y,$tx,$ty,$range,$old,$count="0")
{
  if (!is_array($old))
    $old=array();
  else
    $old[][$x]=$y;

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

  $sth=mysql_query("select sqrt((x-".$x1.")*(x-".$x1.")+(y-".$x2.")*(y-".$x2.")),x,y,id from systems where ".($range).">=sqrt((x-".$x.")*(x-".$x.")+(y-$y)*(y-$y)) and x!=".$x." and y!=".$y.$excl." order by 1 limit 1");

  if (mysql_num_rows($sth)==0)
    return false;

  $system=mysql_fetch_array($sth);

  //echo("ID ist: ".$system["id"]."\n");

  $way = eta_to_planet($system["x"],$system["y"],$tx,$ty,$range,$old,$count);

  if ($way)
  {
    //echo($system["id"]."\n");
    return $way;
  }

  return false;
}


/*********************
*
* function set_mission($fid,$mission,$sid,$pid=0)
*
*********************/
function set_mission($fid,$mission,$sid,$pid=0)
{
  if (($mission<0) and ($mission>4) and ($mission!=2) and ($mission!=3) and ($mission!=5))
    return false;

  $sth=mysql_query("update fleet_info set mission=$mission,tsid=$sid,tpid=$pid where fid=$fid");

  if (!$sth)
    return false;
}


/*********************
*
* is_a_fleet_in_system($uid, $sid)
*
*********************/
function is_a_fleet_in_system($uid, $sid)
{
  $sth = mysql_query("select fid from fleet_info where uid='$uid' and sid='$sid'");

  if ((!$sth) ||(mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}


//**********************
//*
//* get_fids_by_sid($sid, $uid)
//*
//**********************
function get_fids_by_sid($sid, $uid=0)
{
  if ($uid==0)
    $sth = mysql_query("select distinct(fid) from fleet_info where sid='$sid' order by uid");
  else
    $sth = mysql_query("select distinct(fid) from fleet_info where sid='$sid' and uid=$uid");

  if (!$sth)
  {
    echo("error");
    return 0;
  }

  while ($fleets = mysql_fetch_array($sth))
  {
    $fleets_array[] = $fleets["fid"];
  }

  return $fleets_array;
}


//**********************
//*
//* get_strongest_ship_by_fid($fid)
//*
//**********************
function get_strongest_ship_by_fid($fid)
{
  $sth=mysql_query("select s.tonnage,s.prod_id from fleet f,shipvalues s where f.fid=".$fid." and f.prod_id=s.prod_id order by s.tonnage desc limit 1");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  list($tonnage,$prod_id)=mysql_fetch_row($sth);
  
  return $prod_id;
}


//**********************
//*
//* get_fleet_name($fid)
//*
//**********************
function get_fleet_name($fid)
{
  $sth = mysql_query("select name from fleet_info where fid='$fid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  $name = mysql_fetch_row($sth);

  return $name[0];
}


//**********************
//*
//* function get_shipcount_by_fid($fid, $prod_id)
//*
//* - wenn die prod_id = 0 dann gesamt zahl aller schiffe der flotte
//**********************
function get_shipcount_by_fid($fid, $prod_id=0)
{
  if ($prod_id == 0)
    $sth = mysql_query("select sum(count) from fleet where fid = '$fid'");
  else
    $sth = mysql_query("select count from fleet where fid='$fid' and prod_id = '$prod_id'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $schiffszahl = mysql_fetch_row($sth);

  return $schiffszahl[0];
}




//**********************
//*
//* has_admiral($fid)
//*
//**********************
function has_admiral($fid)
{
  $sth=mysql_query("select id from admirals where fid=$fid");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
    return true;
}



//**********************
//*
//* get_prod_ids_by_fid($fid)
//*
//**********************
function get_prod_ids_by_fid($fid)
{
  $sth=mysql_query("select prod_id from fleet where fid=$fid");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
  {
    while ($prod_id=mysql_fetch_row($sth))
      $prod_ids[]=$prod_id[0];

    return $prod_ids;
  }
}


//**********************
//*
//* get_uid_by_fid($fid)
//*
//**********************
function get_uid_by_fid($fid)
{
  $sth = mysql_query("select uid from fleet_info where fid = '".$fid."'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $fleets_uid = mysql_fetch_row($sth);

  return $fleets_uid[0];
}


//**********************
//*
//* get_sid_by_fid($fid)
//*
//**********************
function get_sid_by_fid($fid)
{
  $sth = mysql_query("select sid from fleet_info where fid = '".$fid."'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $fleets_sid = mysql_fetch_row($sth);

  return $fleets_sid[0];
}

//**********************
//*
//* get_pid_by_fid($fid)
//*
//**********************
function get_pid_by_fid($fid)
{
  $sth = mysql_query("select pid from fleet_info where fid = '".$fid."'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $fleets_pid = mysql_fetch_row($sth);

  return $fleets_pid[0];
}


//**********************
//*
//* function set_route($route, $fid)
//*
//**********************
function set_route($route, $fid)
{
  $sth=mysql_query("replace into routes set route='".addslashes(serialize($route))."',fid='$fid'");

  if (!$sth)
     return 0;
  else
     return 1;
}

//**********************
//*
//* function get_system_fleets($sid)
//*
//**********************
function get_system_fleets($sid)
{
  $sth = mysql_query("select fid from fleet_info where sid='$sid' and pid=0");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  while ($system_fleets = mysql_fetch_array($sth))
  {
    $system_fleets_array[] = $system_fleets["fid"];
  }

  return $system_fleets_array;
}



//**********************
//*
//* function get_fids_by_prod_id($prod_id,$uid)
//*
//**********************
function get_fids_by_prod_id($prod_id,$uid=0)
{
  if ($uid>0)
    $sth=mysql_query("select fi.fid from fleet_info fi, fleet as f where f.prod_id=$fid and fi.uid=$uid");
  else
    $sth=mysql_query("select f.fid from fleet as f where f.prod_id=$prod_id");

  while (list($fid)=mysql_fetch_row($sth))
    $fids[]=$fid;

  return $fids;
}




//**********************
//*
//* get_jump_movements($uid,$sid)
//*
//**********************
function get_jump_movements($uid,$sid)
{
  $sth=mysql_query("select tpid,fid from fleet_info where uid=$uid and tsid=$sid and sid!=$sid");

  if (!$sth)
    return false;

  while (list($target_pid,$fid)=mysql_fetch_row($sth))
  {
    $interplanetar[$target_pid]=$fid;
  }

  $sth=mysql_query("select pid,fid from fleet_info where uid=$uid and tsid!=$sid and sid=$sid and tsid!=0");

  if (!$sth)
    return false;

  while (list($target_pid,$fid)=mysql_fetch_row($sth))
  {
    $interplanetar[$target_pid]=$fid;
  }

  return $interplanetar;
}




//**********************
//*
//* get_inner_movements($uid,$sid)
//*
//**********************
function get_inner_movements($uid,$sid)
{
  $sth=mysql_query("select pid,tpid,fid from fleet_info where uid=$uid and tsid=$sid and sid=$sid");

  if (!$sth)
    return false;

  while (list($pid,$target_pid,$fid)=mysql_fetch_row($sth))
  {
    $interplanetar[$fid]=array($pid,$target_pid);
  }

  return $interplanetar;
}



//**********************
//*
//* function get_fleet_scan_radius($fid)
//*
//**********************
function get_fleet_scan_radius($fid)
{
  $sth = mysql_query("select max(radius) from fleet left join scanradius using (prod_id) where fid='$fid'");

  if ((!$sth) ||(!mysql_num_rows($sth)))
    return 0;

  list($scanradius) = mysql_fetch_row($sth);
  return $scanradius;
}


//**********************
//*
//* function is_own_fleet($fid, $type=0)
//*
//**********************
function is_own_fleet($fid, $type=0)
{
  global $uid;

  $fleet_uid = get_uid_by_fid($fid);

  if ($type == 0)
  {
    if ($uid == $fleet_uid)
      return true;
    else
      return false;
  }
  else
  {
    if ($uid == $fleet_uid || is_allied($uid, $fleet_uid))
      return true;
    else
      return false;
  }
}

/**
 * kann die flotte kolonisieren?
 *
 * @param $fid
 * @return bool
 */
function can_colonize($fid)
{
  $sth=mysql_query("select f.fid from fleet f,production p where f.prod_id=p.prod_id and f.fid=$fid and (p.special='O' or p.special='C')");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
    return true;
}

/**
 * prüft ob eine flotte eines users in einem system is
 *
 * @param $uid,$sid
 * @param $sid
 * @return bool
 */
function fleet_in_sid($uid,$sid)
{
  $sth=mysql_query("SELECT fid from fleet_info where uid=$uid and sid=$sid");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
    return true;
}


/*******************
*
*  get_max_scanrange_by_fid($fid)
*
*******************/
function get_max_scanrange_by_fid($fid)
{
  $sth = mysql_query("SELECT max(radius) FROM scanradius LEFT JOIN fleet USING (prod_id) where fid=".$fid);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  list($fleet_radius) = mysql_fetch_row($sth);

  if ($fleet_radius == "")
    $fleet_radius = 0;

  return $fleet_radius;
}

/**
 * holt ALLE bewegungen von flotten
 *
 * @return
 */
function get_global_movements()
{
  $sth=mysql_query("select fid,uid,sid,tsid,pid,tpid,name from fleet_info where tsid!=0");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  while ($fleets[]=mysql_fetch_array($sth));

  return $fleets;
}

/**
 * schnelles setzen der location für eine flotte
 *
 * @param $fid,$pid,$sid,$tpid,$tsid
 * @return
 */
function set_flocation($fid,$pid,$sid,$tpid,$tsid)
{
  $sth=mysql_query("update fleet_info set pid=$pid,sid=$sid,tpid=$tpid,tsid=$tsid where fid=$fid");

  if (!$sth)
    return false;
}



/*************************
*
* function get_fleet_pic($fid)
*
*************************/
function get_fleet_pic($fid)
{
  if ($admiral = get_admiral($fid))
  {
    $its_pic = ADMIRAL_ROOT . get_admiral_pic($admiral);
  }
  else
  {
    $strongest_ship = get_strongest_ship_by_fid($fid);
    $its_pic = PIC_ROOT . get_pic($strongest_ship);
  }

  return $its_pic;
}


/*************************
*
* get_transporters($fid)
*
*************************/
function get_transporters($fid)
{
  $sth = mysql_query("select prod_id, count from fleet where fid = '$fid' and prod_id in (select prod_id from inf_transporters)");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  while ($its_transporters = mysql_fetch_array($sth))
  {
    $transporters_array[$its_transporters["prod_id"]] = $its_transporters["count"];
  }

  return $transporters_array;

}

function get_infantry_by_fid($fid)
{
  $sth = mysql_query("SELECT it.prod_id, count, (count * tonnage) AS total_storage, tonnage, name, pic FROM production p, (inf_transports it JOIN shipvalues iv ON it.prod_id = iv.prod_id) WHERE  p.prod_id = it.prod_id and fid = '$fid'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  $i = 0;
  while ($infantry = mysql_fetch_array($sth))
  {
    $inf_array[$i]["prod_id"]       = $infantry["prod_id"];
    $inf_array[$i]["count"]         = $infantry["count"];
    $inf_array[$i]["total_storage"] = $infantry["total_storage"];
    $inf_array[$i]["storage"]       = $infantry["tonnage"];
    $inf_array[$i]["name"]          = $infantry["name"];
    $inf_array[$i]["pic"]           = $infantry["pic"];
    $i++;
  }

  return $inf_array;
}


function get_transport_data_by_fid($fid)
{
  $sth = mysql_query("SELECT a.name, a.fid, sum(b.count * c.tonnage) as used_storage, (d.storage * e.count) as total_storage
                      FROM inf_transporters d, fleet e,
                      (fleet_info a left outer join (shipvalues c join inf_transports b on (b.prod_id = c.prod_id)) ON a.fid = b.fid)
                      WHERE e.prod_id = d.prod_id and e.fid = a.fid GROUP BY a.fid HAVING a.fid = '$fid'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  $fleet = mysql_fetch_array($sth);

  return $fleet;
}


function get_reload($fid)
{
  $sth = mysql_query("select max(reload) from fleet where fid=".$fid."");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  list($reload) = mysql_fetch_row($sth);

  return $reload;
}


function get_max_reload($fid)
{
  $sth = mysql_query("select max(warpreload) from shipvalues where prod_id in (select prod_id from fleet where fid=".$fid.")");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  list($max_reload) = mysql_fetch_row($sth);

  return $max_reload;
}


function get_special_fleet_actions($fid, $type)
{
  global $uid;

  $sth = mysql_query("select * from special_actions where t_id in (select t_id from research where uid=$uid) and type='$type' order by t_id");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  $i = 0;

  while ($special_actions = mysql_fetch_array($sth))
  {
    $special_actions_array[$i]["name"]        = $special_actions["name"];
    $special_actions_array[$i]["description"] = $special_actions["description"];
    $special_actions_array[$i]["metal"]       = $special_actions["metal"];
    $special_actions_array[$i]["energy"]      = $special_actions["energy"];
    $special_actions_array[$i]["mopgas"]      = $special_actions["mopgas"];
    $special_actions_array[$i]["erkunum"]     = $special_actions["erkunum"];
    $special_actions_array[$i]["gortium"]     = $special_actions["gortium"];
    $special_actions_array[$i]["susebloom"]   = $special_actions["susebloom"];
    $special_actions_array[$i]["action_id"]   = $special_actions["action_id"];
    $special_actions_array[$i]["picture"]     = $special_actions["picture"];

    $i++;
  }

  return $special_actions_array;
}


function fleet_is_examinable($fid, $sid = 0)
{
  global $uid;
  $examinable = false;

  if ($sid == 0)
    $sid = get_sid_by_fid($fid);


  $allies = get_allied_ids($uid);


  if (is_array($allies))
    array_push($allies, $uid);
  else
    $allies[] = $uid;

  for ($m = 0; $m < sizeof($allies); $m++)
  {
    if (is_a_fleet_in_system($allies[$m], $sid)) {
      $examinable = true;
      break;
    }

    if (has_a_planet_in_system($allies[$m], $sid) == "true") {
      $examinable = true;
      break;
    }
  }

  return $examinable;
}


function get_mission_by_mission_id($mission_id, $mode = "defensive")
{
    switch ($mission_id)
    {
      case "0":
        if ($mode == "defensive")
        {
          $mission_text[0]="Defending";
          $mission_text[1]="defend";
          $mission_text[2]="fleet_mission_defend.svgz";
        }
        else
        {
          $mission_text[0]="Attacking";
          $mission_text[1]="attack";
          $mission_text[2]="fleet_mission_attack.svgz";
        }
      break;
      case "1":
        $mission_text[0]="Invading";
        $mission_text[1]="invade";
        $mission_text[2]="fleet_mission_invade.svgz";
      break;
      case "2":
        $mission_text[0]="Bombarding";
        $mission_text[1]="bombard";
        $mission_text[2]="fleet_mission_bomb.svgz";
      break;
      case "4":
        $mission_text[0]="Colonizing";
        $mission_text[1]="colonize";
        $mission_text[2]="fleet_mission_colonize.svgz";
        break;
    }

    return $mission_text;
}

function get_tactic_by_tacticflag($flag)
{
  $tactic="";

  if ($flag & TAC_SCOUT)
    $tactic.=",scout";
  if ($flag & TAC_FLEE25)
    $tactic.=",flee at 25% loss";
  if ($flag & TAC_FLEE50)
    $tactic.=",flee at 50% loss";
  if ($flag & TAC_FLEE75)
    $tactic.=",flee at 75% loss";
  if ($flag & TAC_TRANSPORTERRAID)
    $tactic.=",transporterraid";
  if ($flag & TAC_STORMATTACK)
    $tactic.=",stormattack";

  if (strlen($tactic)==0)
    $tactic="normal";
  else
    $tactic=substr($tactic,1);

  return $tactic;
}

function get_infantrycount_by_fid($fid)
{
  $sth = mysql_query("select sum(count) from inf_transports where fid=$fid");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  list($inf_count) = mysql_fetch_row($sth);

  return $inf_count;
}


function get_colonyships_by_fid($fid)
{
  $sth = mysql_query("select sum(f.count) from fleet f, production p where f.fid=$fid and f.prod_id=p.prod_id and p.special='C'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  list($col_count) = mysql_fetch_row($sth);

  return $col_count;
}


function get_fleets_target($fid)
{
  $sth = mysql_query("select tpid, tsid, pid, sid from fleet_info where fid=$fid");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return false;

  $target_id = mysql_fetch_array($sth);

  $fleet_target["planet"]["tid"] = $target_id["tpid"];
  $fleet_target["system"]["tid"] = $target_id["tsid"];
  $fleet_target["planet"]["id"] = $target_id["pid"];
  $fleet_target["system"]["id"] = $target_id["sid"];

  if ($target_id["tpid"])
    $fleet_target["planet"]["name"] = get_planetname($target_id[0]);

  if ($target_id["tsid"])
    $fleet_target["system"]["name"] = get_systemname($target_id[0]);

  return $fleet_target;
}


function get_true_ETA_by_fid($fid)
{
  global $uid;

  $fleets_target = get_fleets_target($fid);
  
  // kein ziel
  if ($fleets_target["system"]["tid"] == 0 && $fleets_target["planet"]["tid"] == 0)
    return 0;
  
  // ziel = standort
  if ($fleets_target["system"]["tid"] == $fleets_target["system"]["id"] && $fleets_target["planet"]["tid"] == $fleets_target["planet"]["id"])
    return 0;
    
  // innerhalb eines systems
  if ($fleets_target["system"]["tid"] == $fleets_target["system"]["id"]  && $fleets_target["planet"]["tid"] != $fleets_planets["planet"]["id"])
    return 1;    
  else
  {
    // Alleierte raussuchen
    $allies = get_allied_ids($uid);

    if (is_array($allies))
      array_push($allies, $uid);
    else
      $allies[0] = $uid;

    // route besorgen
    $sth = mysql_query("select route from routes where fid=$fid");

    if ((!$sth) || (!mysql_num_rows($sth)))
      return false;

    list($route) = mysql_fetch_row($sth);

    $route = unserialize($route);

    // Anzahl sprünge ermitteln
    $jumps = sizeof($route);

    $refueling_stations_count = 0;

    // refueling stations ermitteln
    $refueling_stations = get_prodid_by_special("F");
    // nach refuelingstations auf dem weg suchen
    for ($i = 0; $i < $jumps-1; $i++) {

      $current_system_planets = get_planets_by_sid($route[$i]);

      // Filtern nach alleierten und eigenen Planeten
      for ($j = 0; $j < sizeof($current_system_planets); $j++){
        if (in_array(get_uid_by_pid($current_system_planets[$j]), $allies))
        {
          // construction list des planeten heraussuchen
          $planet_constructions = get_construction_list($current_system_planets[$j]);

          // gucken ob refuelingstation auf planet gebaut
          for ($k = 0; $k < sizeof($refueling_stations); $k++)
          {
            if (in_array($refueling_stations[$k], $planet_constructions)) {
              // refueling statoin gefunden
              $k = sizeof($refueling_stations);
              $j = sizeof($current_system_planets);
              $refueling_stations_count++;
            }
          }
        }
      }

    }
    // derzeitigen refuel status der flotte ermitteln
    $current_refuel_time = get_reload($fid);
    
    if ($current_refuel_time == 0) $current_refuel_time = 1;
    
    $jumps--;       
      
    $max_refuel_time = get_max_reload($fid);
    
    if ($jumps < 0) $jumps = 0;
    
    $eta = $current_refuel_time + ($jumps * $max_refuel_time) - $refueling_stations_count;

    // jetzt noch den weg vom planeten zum system und entgegengesetzt einberechnen
    if ($fleets_target["planet"]["id"] && $current_refuel_time < 2)
      $eta++;
      
    if ($fleets_target["planet"]["tid"] != 0)
      $eta++;    

    // lol, nen hack :S
    if ($eta < 1)
      $eta = 1;     // weil alles was 0 ist der eigene standort ist und schon am anfang abgefangen wird

  }
    
  return $eta;
}


function has_noscan_ships_and_constructions($fid)
{
  // noscan schiffe?
  $sth = mysql_query("SELECT s.prod_id FROM shipvalues s JOIN fleet f USING(prod_id) WHERE s.special = 'N' and f.fid = ".$fid);

  if (!$sth)
  {
    show_svg_message("ERROR::GETTING NOSCAN SHIPS");
    return false;
  }

  if (mysql_num_rows($sth)>0)
    return true;
    
  //noscan gebäude?
  $fleet  = new fleet($fid);
  
  if ($fleet->pid > 0)
  {
    $allies = get_allied_ids($fleet->uid);
    
    if (is_array($allies))
      array_push($allies, $fleet->uid);
    else
      $allies[] = $fleet->uid;
      
    $sth = mysql_query("SELECT s.prod_id FROM planets p, shipvalues s JOIN constructions c USING(prod_id) where s.special='N' and c.pid=p.id and p.id = ".$fleet->pid." and p.uid in (".(implode(",",$allies)).")");

    if (!$sth)
    {
      show_svg_message("ERROR::GETTING NOSCAN CONSTRUCTIONS");
      return false;
    }

    if (mysql_num_rows($sth)>0)
      return true;
  }
  
  return false;
}

function fleet_add($fid, $prod_id, $count, $reload)
{
  $sth=mysql_query("insert into fleet set fid=".$fid.",prod_id=".$prod_id.",count=".$count.",reload=".$reload." on duplicate key update count=count+".$count.",reload=if(reload>".$reload.",reload,".$reload.")");

  if (!$sth)
    return false;
  else
    return true;
}

function get_tonnage($fid)
{
  $sth=mysql_query("select sum(s.tonnage*f.count) from shipvalues s,fleet f where s.prod_id=f.prod_id and f.fid=".$fid);

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  list($tonnage)=mysql_fetch_row($sth);

  return $tonnage;
}


/*

A-STAR FUNKTIONEN

*/

// mop: ideale anzahl an sprüngen (direkter weg zum ziel)
function find_heuristics($sid,$tsid,$warprange)
{
  $sth=mysql_query("select s1.x-s2.x,s1.y-s2.y from systems s1,systems s2 where s1.id=".$sid." and s2.id=".$tsid);

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  list($x,$y)=mysql_fetch_row($sth);

  $betrag=sqrt((($x*$x)+($x*$x)));

  return $betrag/$warprange;
}

function systems_in_range($sid,$warprange)
{
  $sth=mysql_query("select s2.id from systems s1,systems s2 where ".$warprange.">=sqrt((s1.x-s2.x)*(s1.x-s2.x)+(s1.y-s2.y)*(s1.y-s2.y)) and s1.id=".$sid." and s2.id!=".$sid);

  if (!$sth)
    return false;

  $systems=array();
  
  while (list($tsid)=mysql_fetch_row($sth))
    $systems[]=$tsid;

  return $systems;
}

function astar_sort($a,$b)
{
  if ($a["f"]==$b["f"])
    return 0;
  return ($a["f"]>$b["f"] ? 1 : -1);
}

function move_to($sid,$tsid,$warprange)
{
  $open   =array();
  $closed =array();

  $start=array();
  $start["g"]=0;
  $start["h"]=find_heuristics($sid,$tsid,$warprange);
  $start["f"]=$start["h"];
  $start["parent"]=NULL;
  $start["sid"]=$sid;

  $open[$sid]=$start;
  $path=false;
  
  while (sizeof($open)>0)
  {
    reset($open);
    $key=key($open);
    $current=$open[$key];
    unset($open[$key]);

    if ($current["sid"]==$tsid)
    {
      $path=array();
      array_unshift($path,$tsid);
      $parent=$current["parent"];
      while ($parent)
      {
        array_unshift($path,$parent["sid"]);
        $parent=$parent["parent"];
      }
      // mop: erstes element (quell-sid) wieder raus
      array_shift($path);
      return $path;
    }
    $closed[$current["sid"]]=$current;
   
    $systems=systems_in_range($current["sid"],$warprange);
    
    if (is_array($systems))
    {
      foreach ($systems as $new_sid)
      {
        $new_sid=(int) $new_sid;
        $node=array("sid"=>$new_sid);
        $node["g"]=$current["g"]+1;
        $node["h"]=find_heuristics($new_sid,$tsid,$warprange);
        $node["f"]=$node["g"]+$node["h"];
        $node["parent"]=$current;

        $unset=true;
        if ($open[$new_sid] && $open[$new_sid]["g"]<=$node["g"])
          $unset=false;
        if ($closed[$new_sid] && $closed[$new_sid]["g"]<=$node["g"])
          $unset=false;

        if ($unset)
        {
          unset($open[$new_sid]);
          unset($closed[$new_sid]);
          $open[$new_sid]=$node;
          uasort($open,"astar_sort");
        }
      }
    }
  }
  return false;
}
?>
