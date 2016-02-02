<?php
include "../spaceregentsconf/config.inc.php";
require_once(SMARTY_DIR."Smarty.class.php");
include "../spaceregentsconf/krieg_config.inc.php";
include "../spaceregentsinc/gp/dbwrap.inc";
include "../spaceregentsinc/func.inc.php";
include "../spaceregentsinc/missiontypes.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/users.inc.php";
include "../spaceregentsinc/alliances.inc.php";
include "../spaceregentsinc/timer.inc.php";
include "../spaceregentsinc/domain.inc.php";
include "../spaceregentsinc/admirals.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/fleet.inc.php";

/*

INFO:
- position: O => orbital (Schiffe UND orbitale gebäude)
            T => auf transporter
            P => Planetar
            U => Unloaded infaterie
            L => gelandet (bei transportern)
*/

function combat_validate_index($pos)
{
  global $combat;
  
  foreach($combat as $index => $unit)
  {
    if ($index!=$unit["id"])
    {
      echo ("$pos: INDEX BROKEN!");
      break;
    }
  }
}

function combat_acquire_target($unit, $target_pos, $sensor_check, $digger_luck)
{
  global $combat;
  global $combat_targets;

  $pos_array=split(",", $target_pos);
  $retval=false;
  $prios=0;
  
  if (sizeof($combat_targets[abs($unit["aid"])]) > 0)
    foreach ($combat_targets[abs($unit["aid"])] AS $target)
    {
      if (in_array($target["position"], $pos_array))    
      {
        if ($target["ecm"]<=$sensor_check)
        {
          if ($target["digin_depth"]+$target["digin_bonus"]<=$digger_luck)
          {
            if ($target["size_num"]==$unit["target1_num"] && $target["priority"]>=0)
            {
              $retval=$target["id"];
              break;
            }
            elseif ($target["size_num"]!=$unit["target1_num"] && $target["priority"]>=0)
              $prio[0][]=$combat[$target["id"]]["id"];
            elseif ($target["size_num"]==$unit["target1_num"])
              $prio[1][]=$combat[$target["id"]]["id"];
            elseif ($target["size_num"]!=$unit["target1_num"])
              $prio[2][]=$combat[$target["id"]]["id"];
          }
        }
      }
    }
  
  if (!$retval)
    for ($i=0;$i<=2;$i++)
      if (sizeof($prio[$i])>0)
      {
        $retval=$prio[$i][0];
        break;
      }
  
  return $retval;
} 

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_split_table
// Teilt einen Eintrag der Combattabelle, um spezielle Informationen (erobert, außer Gefecht, etc.)
// speichern zu können
//-----------------------------------------------------------------------------------------------------

function combat_split_table($id, $count)
{
  global $combat;
  
  $retval=false;
  
  if (dlookup("count","combat","id=$id")>$count)
  {
    $query=$GLOBALS["db"]->query("SELECT * FROM combat WHERE id=$id") or die ($GLOBALS["db"]->error);
    
    while ($field_name=$query->fetch_field())
    {
      if ($field_name->name!="id")
      { 
        if (substr($field_name->name,0,5)=="count")
        {
          $field_list.=$field_name->name.", ";
          $query_list.=$count." AS ".$field_name->name.", ";
        }
        else
        {
          $field_list.=$field_name->name.", ";
          $query_list.=$field_name->name.", ";
        }
        
      }
    }
    
    $field_list=rtrim($field_list, ", ");
    $query_list=rtrim($query_list, ", ");
    
    $sth=$GLOBALS["db"]->query("INSERT INTO combat ($field_list) SELECT $query_list FROM combat WHERE id=$id")
or die ($GLOBALS["db"]->error);

    $retval=$GLOBALS["db"]->insert_id;
    
    $sth=$GLOBALS["db"]->query("UPDATE combat SET count=count-$count, count_max=count_max-$count WHERE id=$id") or die ($GLOBALS["db"]->error);
  }
  
  return $retval;
}   

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_split
// Teilt einen Eintrag der Combattabelle, um spezielle Informationen (erobert, außer Gefecht, etc.)
// speichern zu können
//-----------------------------------------------------------------------------------------------------

function combat_split($id, $count)
{
  global $combat;
  global $combat_targets;
  
  $retval=false;
  
  if ($combat[$id]["count"]>$count)
  {
    $query=$GLOBALS["db"]->query("SELECT * FROM combat WHERE id=$id") or die ($GLOBALS["db"]->error);
    
    while ($field_name=$query->fetch_field())
    {
      if ($field_name->name!="id")
      { 
        if (substr($field_name->name,0,5)=="count")
        {
          $field_list.=$field_name->name.", ";
          $query_list.=$count." AS ".$field_name->name.", ";
        }
        else
        {
          $field_list.=$field_name->name.", ";
          $query_list.=$field_name->name.", ";
        }
        
      }
    }
    
    $field_list=rtrim($field_list, ", ");
    $query_list=rtrim($query_list, ", ");
    
    $sth=$GLOBALS["db"]->query("INSERT INTO combat ($field_list) SELECT $query_list FROM combat WHERE id=$id")
or die ($GLOBALS["db"]->error);

    $retval=$GLOBALS["db"]->insert_id;
    
    $sth=$GLOBALS["db"]->query("UPDATE combat SET count=count-$count, count_max=count_max-$count WHERE id=$id") or die ($GLOBALS["db"]->error);
    
    $combat[$id]["count"]-=$count;
    $combat[$id]["count_max"]-=$count;
    $combat[$retval]=$combat[$id];
    
    $combat[$retval]["id"]=$retval;
    $combat[$retval]["count"]=$count;
    $combat[$retval]["count_max"]=$count;
  }
  
  return $retval;
}   

function combat_kill_ship($killed, $killer)
{
  global $combat;
  global $combat_targets;
  
  $retval=false;

  // EMP-Schiffe zerstören keine Truppen!

  if ($combat[$killer]["special"]!="E")
  {
    // Infanteristen auf Transporter?
    
    if ($combat[$killed]["transport_capacity"]>0)
    {
      $perc_killed=1/$combat[$killed]["count"];
      
      if (COMBAT_MAXIMUM_VERBOSITY)
        echo ("(killing ".round($perc_killed*100,0)."% of passengers) ");
      
      $query=$GLOBALS["db"]->query("SELECT id FROM combat WHERE on_transport=$killed") or die ($GLOBALS["db"]->error);
      
      while ($result=$query->fetch_assoc())
      {
        $combat[$result["id"]]["count"]-=ceil($combat[$result["id"]]["count"]*$perc_killed);
        
        $sth=$GLOBALS["db"]->query("UPDATE combat SET count=count-ceil(count*$perc_killed) 
WHERE id=".$result["id"]);          
      }
    }
  }

  if ($combat[$killed]["count"]>1)
  {
    if (COMBAT_MAXIMUM_VERBOSITY)
      echo ("(fetch next from group) ");
      
    $killed_id=combat_split($killed, 1);
    $combat[$killed_id]["killed_by"]=$killer;
    $combat[$killed_id]["count"]--;
    
    if ($combat[$killer]["special"]=="E" || $combat[$killer]["special"]=="R")
      $combat[$killed_id]["killed_special"]=$combat[$killer]["special"];

    $combat[$killed]["hull"]=$combat[$killed]["hull_max"];
    $combat[$killed]["shield"]=$combat[$killed]["shield_max"];
    $combat[$killed]["armor"]=$combat[$killed]["armor_max"];
    
    $retval=$killed_id;
  }
  else
  {
    foreach ($combat_targets AS $list_alliance => $target_alliance)
      if(array_key_exists($killed, $target_alliance))
        unset($combat_targets[$list_alliance][$killed]);
          
    $combat[$killed]["killed_by"]=$killer;
    
    if ($combat[$killer]["special"]=="E" || $combat[$killer]["special"]=="R")
      $combat[$killed]["killed_special"]=$combat[$killer]["special"];
    
    $combat[$killed]["count"]--;
  }
  
  return($retval);
} 

function combat_update_table($id)
{
  global $combat;

  // mop: is das alles evil...aber sonst klappts net mit den prepared statements
  static $stmt;
  static $hull;
  static $armor;
  static $shield;
  static $killed_by;
  static $killed_special;
  static $count;
  static $uid;
  static $cid;

  $hull=$combat[$id]["hull"];
  $armor=$combat[$id]["armor"];
  $shield=$combat[$id]["shield"];
  $count=$combat[$id]["count"];
  $uid=$combat[$id]["uid"];
  $cid=$id;
  
  /*
    $sql=$GLOBALS["db"]->prepare("UPDATE combat SET hull=".$combat[$id]["hull"].", armor=".$combat[$id]["armor"].
    ", shield=".$combat[$id]["shield"].", killed_by=$killed_by, killed_special=$killed_special, 
    count=".$combat[$id]["count"].", uid=".$combat[$id]["uid"]." WHERE id=$id"; 
    */
  
  if (is_null($combat[$id]["killed_by"]))
    $killed_by=NULL;
  else
    $killed_by=$combat[$id]["killed_by"];
      
  if (is_null($combat[$id]["killed_special"]))
    $killed_special=NULL;
  else
    $killed_special=$combat[$id]["killed_special"];
 
  // mop: das erste in SR dokumentierte prepared statement ;)
  if (!$stmt)
  {
    $stmt=$GLOBALS["db"]->prepare("UPDATE combat SET hull=?, armor=?".
    ", shield=?, killed_by=?, killed_special=?, 
    count=?, uid=? WHERE id=?");
    $stmt->bind_param("ddddsddd",$hull,$armor,$shield,$killed_by,$killed_special,$count,$uid,$cid);
  }

  $sth=$stmt->execute() or die ($GLOBALS["db"]->error);
}


//-----------------------------------------------------------------------------------------------------
// Funktion: combat_shoot_unit
// Gibt einen einzelnen Schuss auf ein Ziel ab.
//-----------------------------------------------------------------------------------------------------

function combat_shoot_unit($a_id, $d_id, $is_counterfire)
{
  global $combat;
  
  $combat["shots_fired"]++;
  
  if (mt_rand(1,100)==100)
  {
    if (COMBAT_MAXIMUM_VERBOSITY)
      echo("*critical* ");
      
    $critical=10;
  }
  else
    $critical=1;
  
  if ($critical==10)
    $gunnery_check_attack=$combat[$a_id]["weaponskill"];
  else
    $gunnery_check_attack=mt_rand(0, $combat[$a_id]["weaponskill"]);
  
  $gunnery_check_evasion=mt_rand(0, round($combat[$d_id]["agility"]*2/3));
  
  $gunnery_check_follow=mt_rand(0, floor($combat[$a_id]["agility"]/2));
  
  $gunnery_check_defense=$gunnery_check_evasion-$gunnery_check_follow;
  
  if ($is_counterfire)
  {
    $gunnery_check_attack=round($gunnery_check_attack*3/4);
    
    $gunnery_check_follow=0;
  }
  
  if (COMBAT_MAXIMUM_VERBOSITY)
    if ($combat[$d_id]["size_num"]<$combat[$a_id]["target1_num"])
      echo("size-handicap +".($combat[$a_id]["target1_num"]*2-$combat[$d_id]["size_num"]*2)." ");
    elseif ($combat[$d_id]["size_num"]>$combat[$a_id]["target1_num"])
      echo("size-handicap -".($combat[$d_id]["size_num"]*2-$combat[$a_id]["target1_num"]*2)." ");
  
  if ($gunnery_check_defense<0)
    $gunnery_check_defense=0;
  
  // zu kleine Ziele sind schwer zu treffen!
  
  if ($combat[$d_id]["size_num"]<$combat[$a_id]["target1_num"])
    $gunnery_check_attack=round($gunnery_check_attack/($combat[$a_id]["target1_num"]*2-
$combat[$d_id]["size_num"]*2));
  
  $gunnery_check=$gunnery_check_attack-$gunnery_check_defense;

  if (COMBAT_MAXIMUM_VERBOSITY)
    echo("attack(".$gunnery_check_attack."+".$gunnery_check_follow."-".$gunnery_check_evasion
."=".$gunnery_check."/".$combat[$a_id]["weaponskill"].") ");

  if ($gunnery_check>0)
  {   
    $retval="HIT";

    $damage=round($combat[$a_id]["weaponpower"]*1/3+$combat[$a_id]["weaponpower"]*2/3*
$gunnery_check/$combat[$a_id]["weaponskill"])*$critical;

    // zu große Ziele kriegen weniger Schaden!

    if ($combat[$d_id]["size_num"]>$combat[$a_id]["target1_num"])
      $damage=round($damage/($combat[$d_id]["size_num"]*2-$combat[$a_id]["target1_num"]*2));
          
    if (COMBAT_MAXIMUM_VERBOSITY)
      echo("damage(".$damage." vs. ".$combat[$d_id]["shield"]."/".$combat[$d_id]["armor"]
."/".$combat[$d_id]["hull"].") ");

    // Planetarer Schild wird beim Kampf von Bodentruppen nicht gezählt!

    if ($combat["d_id"]["special"]!="H" || $combat["a_id"]["position"]!="P")
    {
      $damage_pass=$damage-$combat[$d_id]["shield"];
    
      $combat[$d_id]["shield"]-=ceil($damage/4);
    
      if ($combat[$d_id]["shield"]<0)
        $combat[$d_id]["shield"]=0;
    }
    else
      $damage_pass=$damage;
      
    if ($damage_pass>0)
    {   
      $damage=$damage_pass;
      
      $damage_pass=$damage-$combat[$d_id]["armor"];
      
      $combat[$d_id]["armor"]-=$damage;
      
      if ($combat[$d_id]["armor"]<0)
        $combat[$d_id]["armor"]=0;
      
      if ($damage_pass>0)
      {
        $combat[$d_id]["hull"]-=$damage_pass;     
      }
    }

    if ($combat[$d_id]["hull"]<1)
    {
      $retval="KILLED";

      if (COMBAT_MAXIMUM_VERBOSITY)
        if ($combat[$a_id]["special"]=="E")
          echo("*disabled* ");
        elseif ($combat[$a_id]["special"]=="R")
          echo("*captured* ");
        else
          echo("*destroyed* ");
      
      $kill_split=combat_kill_ship($d_id, $a_id);
    }
  } 
  else
  {
    if (COMBAT_MAXIMUM_VERBOSITY)
      echo("missed ");
      
    $retval="MISSED";
  }

  if ($gunnery_check>0)
  {
    combat_update_table($d_id);
    
    if ($kill_split)
      combat_update_table($kill_split);
  }

  return $retval;
}

//-----------------------------------------------------------------------------------------------------
  
//-----------------------------------------------------------------------------------------------------
// Funktion: combat_create_temporary
// Legt eine Kampftabelle im Speicher an, die einen Datensatz für jede am Kampf beteiligte Einheit
// enthält.
//-----------------------------------------------------------------------------------------------------

function combat_create_temporary()
{
  if (COMBAT_VERBOSE)
  {
    echo ("Temporärtabelle erstellen...");
    
    start_timer(1);
  }

  $sth=$GLOBALS["db"]->query("DROP TABLE IF EXISTS combat");

  if (!$sth)
    return false;
  
  // Anlegen der Heaptabelle mit aaaaallen Kampfteilnehmern... 123todo: Als TEMPORARY anlegen!  

  $sth=$GLOBALS["db"]->query("CREATE TABLE combat
(id int(11) NOT NULL auto_increment, uid int(11), aid int(11), fid int(11), prod_id int(11), 
admiral_id int(11), initiative int(11), initiative_max int(11), hull int(11), hull_max int(11), 
warpreload int(11), 
shield int(11), shield_max int(11), armor int(11), armor_max int(11), weaponpower int(11), 
ecm int(11), ecm_max int(11), target1 char(1), target1_num int(11), size char(1), size_num int(11), 
sensor int(11), weaponskill int(11), special varchar(5), 
num_attacks int(11), counterfire int(11), 
killed_by int(11), killed_special varchar(5), count int(11), count_max int (11), 
agility int(11), type char(1), 
position char(1), 
tactic int(11), mission int(11), transport_capacity int(11) DEFAULT 0, on_transport int(11), 
priority int(11) DEFAULT 0, digin_depth int(11) DEFAULT 0, 
digin_bonus int(11) DEFAULT 0, admiral_carried int(11), 
random_pos int(11), category int(11), challenge int(11), PRIMARY KEY (id), 
KEY(position), KEY(aid), KEY(ecm), KEY(random_pos)) TYPE=MEMORY") or die ($GLOBALS["db"]->error);

  if (!$sth)
    return false;
  
  if (COMBAT_VERBOSE)
    echo ("OK! (".round(read_timer(1),2)."s)".COMBAT_NEWLINE);
}

//-----------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_insert_simulator
// Trägt die Flotten aus dem Kampfsimulator in die Kampftabelle ein
//-----------------------------------------------------------------------------------------------------

function combat_insert_simulator($uid)
{
  // Eintrag der beteiligten Flotten

  if (COMBAT_VERBOSE)
  {
    start_timer(1);
    
    echo ("Flotten eintragen...");
  }

  if (defined("COMBAT_MAX_FRACTION"))
  { 
    $sth=$GLOBALS["db"]->query("SELECT -1*side AS aid, SUM(count) AS shipcount FROM battle_$uid GROUP BY aid");
    
    while ($fraction=$sth->fetch_assoc())
    {
      $fraction_total[$fraction["aid"]]=$fraction["shipcount"];
      
      $fraction_group[$fraction["aid"]]=ceil($fraction["shipcount"]/COMBAT_MAX_FRACTION);
    }
  } 
  
  $sth=$GLOBALS["db"]->query("SELECT -1 AS fid, -1*side AS uid, -1*side AS aid, 2 AS mission, 0 as tactic, 
b.prod_id, b.count, 0 AS reload, 0 AS storage, 0 AS transport_capacity, 0 AS admiral_id,
b.initiative AS ini, b.initiative AS initiative_max, b.hull, b.armor, b.agility, b.shield, 
b.ecm, b.target1, b.sensor, b.weaponskill, b.special, 
b.num_attacks, b.weaponpower, IF(p.typ='I', 'P', 'O') AS position FROM battle_".$uid." b 
INNER JOIN production p USING (prod_id)")
or die ($GLOBALS["db"]->error);

  if (!$sth)
    return false;

  $total=0;

  while ($fleet=$sth->fetch_assoc())
  {

    // Jedes Schiffchen ein Einträgchen

    if (defined("COMBAT_MAX_FRACTION"))
      $inc=$fraction_group[$fleet["aid"]];
    else
      $inc=1;

    for ($i=0;$i<$fleet["count"];$i+=$inc)
    {

      if (defined("COMBAT_MAX_FRACTION"))
        if ($i+$inc > $fleet["count"])
          $thisgroup=$fleet["count"]-$i;
        else
          $thisgroup=$inc;
      else
        $thisgroup=1;
    
      $total+=$thisgroup;

      if(is_null($fleet["special"]) || $fleet["special"]=="" )
        $special="NULL";
      else
        $special="'".$fleet["special"]."'";
      
      $target1="'".$fleet["target1"]."'";
      
      $sth1=$GLOBALS["db"]->query("INSERT INTO combat (uid, aid, fid, prod_id, mission, tactic, warpreload, admiral_id, 
position, transport_capacity, initiative, hull, hull_max, armor, armor_max, agility, shield, shield_max, 
ecm, target1, sensor,
weaponskill, special, num_attacks, weaponpower, initiative_max, ecm_max, category, count, count_max) VALUES
(".$fleet["uid"].", ".$fleet["aid"].", ".$fleet["fid"].", ".$fleet["prod_id"].", ".$fleet["mission"].", ".$fleet["tactic"].", 
".$fleet["reload"].", ".$fleet["admiral_id"].", '".$fleet["position"]."', ".$fleet["transport_capacity"].", ".
mt_rand(1, $fleet["ini"]).", ".$fleet["hull"].", ".$fleet["hull"].", ".$fleet["armor"].", ".$fleet["armor"].
", ".$fleet["agility"].", ".
$fleet["shield"].", ".$fleet["shield"].", ".mt_rand(1, $fleet["ecm"]).", ".($target1).", ".$fleet["sensor"].", ".
$fleet["weaponskill"].", ".$special.", ".$fleet["num_attacks"].", ".$fleet["weaponpower"].
", ".$fleet["initiative_max"].", ".$fleet["ecm"].", 0, $thisgroup, $thisgroup)") or die ($GLOBALS["db"]->error);
    }
  }

  if (COMBAT_VERBOSE)
    echo ($total." Schiffchen! (".round(read_timer(1),4).")".COMBAT_NEWLINE); 
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_reroll_initiative
// Trägt die beteiligten Flotten in die Kampftabelle ein.
//-----------------------------------------------------------------------------------------------------

function combat_reroll_initiative($puid)
{
  global $combat_targets;

  if (COMBAT_VERBOSE)
  {
    start_timer(1);
    
    echo ("Neue Initiative...");
  }
  
  // Schiffe erobern...
  
  $sth=$GLOBALS["db"]->query("UPDATE combat c1 INNER JOIN combat c2 ON (c1.killed_by=c2.id) 
SET c1.uid=c2.uid, c1.aid=c2.aid, c1.fid=c2.fid, c1.hull=1, c1.killed_by=NULL, 
c1.killed_special=NULL, c1.count=c1.count_max WHERE c1.killed_special='R'");

  // Deaktivierte Schiffe reanimieren
  
  $sth=$GLOBALS["db"]->query("UPDATE combat SET killed_by=NULL, killed_special=NULL, hull=1, count=count_max
WHERE killed_special='E'");
    
  // Derzeit werden alle Schiffe nach jeder Runde repariert
  
  $sth=$GLOBALS["db"]->query("UPDATE combat SET hull=hull_max, armor=armor_max, shield=shield_max");
  
  // Buddeltiefe bedenken...

  $sth=$GLOBALS["db"]->query("SELECT id, digin_depth FROM combat WHERE killed_by IS NULL") or die ($GLOBALS["db"]->error);
  
  while ($ship=$sth->fetch_assoc())
  {
    $skip=0;
    
    if ($ship["digin_depth"]>0)
      if (mt_rand(1,100)<=$ship["digin_depth"])
        $skip=10000;
              
    $sth1=$GLOBALS["db"]->query("UPDATE combat SET counterfire=0, initiative=floor(rand()*initiative_max+1)-$skip,
ecm=floor(rand()*ecm_max+1), random_pos=floor(rand()*100000) WHERE 
id=".$ship["id"]) or die ($GLOBALS["db"]->error);
    
  }

  // Zielarray anlegen
  
  $query=$GLOBALS["db"]->query("SELECT DISTINCT c1.aid AS me, GROUP_CONCAT(DISTINCT d.alliance2 SEPARATOR ', ') 
AS enemy FROM combat c1 INNER JOIN diplomacy d ON d.alliance1=c1.aid WHERE d.status=0 
GROUP BY c1.aid") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    $query2=$GLOBALS["db"]->query("SELECT 
id, position, size_num, ecm, priority, random_pos, digin_depth, digin_bonus FROM combat WHERE killed_by IS NULL AND 
position <> 'L' AND position <> 'T' AND position <> 'U' AND aid IN (".$result["enemy"].") 
ORDER BY priority DESC, random_pos") or die ($GLOBALS["db"]->error);

    while ($result2=$query2->fetch_assoc())
      $combat_targets[abs($result["me"])][$result2["id"]]=$result2;
      
  }
  
  if (COMBAT_VERBOSE)
    echo ("OK! (".round(read_timer(1),4)."s) ".COMBAT_NEWLINE);
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_insert_combatants
// Trägt die beteiligten Flotten in die Kampftabelle ein.
//-----------------------------------------------------------------------------------------------------

function combat_insert_combatants($sid, $pid)
{
  
  // Eintrag der beteiligten Flotten

  if (COMBAT_VERBOSE)
  {
    echo ("Flotten eintragen...");
    
    start_timer(1);
  }
  
  if (defined("COMBAT_MAX_FRACTION"))
  {
    $sth=$GLOBALS["db"]->query("SELECT IFNULL(alliance, 0) AS aid, SUM(f.count) AS shipcount FROM fleet_info fi INNER JOIN 
fleet f USING(fid) INNER JOIN users u ON u.id=fi.uid WHERE fi.pid=".$pid." AND fi.sid=".$sid
." GROUP BY alliance") or die ("SEL1: ".$GLOBALS["db"]->error);
    
    while ($fraction=$sth->fetch_assoc())
    {
      $fraction_total[$fraction["aid"]]=$fraction["shipcount"];
      
      $fraction_group[$fraction["aid"]]=ceil($fraction["shipcount"]/COMBAT_MAX_FRACTION);
    } 
  }

  $sth=$GLOBALS["db"]->query("SELECT fi.fid, fi.uid, fi.mission, fi.tactic, fl.prod_id, fl.count, fl.reload, 
IFNULL(it.storage,0) AS transport_capacity, IFNULL(ad.id, 0) AS admiral_id FROM fleet_info fi LEFT JOIN admirals 
as ad ON ad.fid=fi.fid LEFT JOIN inf_transporters it ON it.prod_id = fl.prod_id INNER JOIN fleet fl ON 
fl.fid=fi.fid WHERE fi.pid=".$pid." AND fi.sid=".$sid) or die("SEL2: ".$GLOBALS["db"]->error);

  if (!$sth)
    return false;

  $total=0;

  while ($fleet=$sth->fetch_assoc())
  {

    $aid=get_alliance($fleet["uid"]);

    if (!$aid)
      $aid=0;
    
    if (defined("COMBAT_MAX_FRACTION"))
      $inc=$fraction_group[$aid];
    else
      $inc=1;
  
    if ($inc<=0)
      $inc=1;

    // Jedes Schiffchen ein Einträgchen

    for ($i=0;$i<$fleet["count"];$i+=$inc)
    { 
      if (defined("COMBAT_MAX_FRACTION"))
        if (($i+$inc) > $fleet["count"])
        {
          $thisgroup=$fleet["count"]-$i;
        }
        else
          $thisgroup=$inc;
      else
        $thisgroup=1;   
      
      $total+=$thisgroup;

  $sth1=$GLOBALS["db"]->query("INSERT INTO combat (uid, aid, fid, prod_id, mission, tactic, warpreload, admiral_id, 
position, transport_capacity, category, count, count_max) VALUES
(".$fleet["uid"].", ".$aid.", ".$fleet["fid"].", ".$fleet["prod_id"].", ".$fleet["mission"].", ".$fleet["tactic"].", 
".$fleet["reload"].", ".$fleet["admiral_id"].", 'O', ".($fleet["transport_capacity"]*$thisgroup).", 1, $thisgroup, 
$thisgroup)") or die ("INS1: ".$GLOBALS["db"]->error);
    }
  }

  if (COMBAT_VERBOSE)
    echo ($total." Schiffchen! (".round(read_timer(1),4)."s)".COMBAT_NEWLINE);

  // Eintrag der beteiligten Landetruppen

  if (COMBAT_VERBOSE)
  {
    echo ("Landetrüppchen eintragen...");
    
    start_timer(1);
  }

  // Ermitteln der Truppen an Bord von Transportern

  $sth=$GLOBALS["db"]->query("SELECT it.fid, fl.uid, it.prod_id, SUM(it.count) AS CountSum FROM fleet_info fl INNER JOIN
inf_transports it ON it.fid=fl.fid WHERE it.fid IN (SELECT DISTINCT c.fid FROM combat c) GROUP BY it.fid, 
it.prod_id, fl.uid HAVING CountSum > 0") or die ("INS2: ".$GLOBALS["db"]->error);

  if (!$sth)
    return false;
  
  $total=0;

  if ($sth->num_rows>0)
  {

    // Außenschleife: Durchlaufen der beteiligten Flotten mit Infanteristen

    while ($fleet=$sth->fetch_assoc())
    {

      $aid=get_alliance($fleet["uid"]);

      // Ermitteln der Gesamt-Transportkapazität der Flotte

      $sth1=$GLOBALS["db"]->query("SELECT SUM(transport_capacity) AS total_capacity FROM combat 
          WHERE fid=".$fleet["fid"]) or die ("SEL3: ".$GLOBALS["db"]->error);

      if (!$sth1)
        return false;

      $to_divide = $fleet["CountSum"];

      $total_capacity=$sth1->fetch_row();

      if ($total_capacity>0)
      {

        // Innenschleife: Verteilen der Infanteristen auf den verschiedenen Schiffen der Flotte

        $sth1=$GLOBALS["db"]->query("SELECT id, transport_capacity FROM combat WHERE transport_capacity>0 AND fid=".$fleet["fid"]) 
          or die ($GLOBALS["db"]->error);

        if (!$sth1)
          return false;

        while ($transport=$sth1->fetch_assoc())
        {

          // Jedes Männchen ein Einträgchen

          //echo ($transport["transport_capacity"]." / ".$total_capacity[0]." * ".$to_divide);

          $this_divide=floor($transport["transport_capacity"] / $total_capacity[0] * $to_divide);

          $to_divide-=$this_divide;

          $total_capacity[0]-=$transport["transport_capacity"];

          $total+=$this_divide;

          $sth2=$GLOBALS["db"]->query("INSERT INTO combat (uid, aid, fid, prod_id, position, count, count_max, on_transport, category) VALUES
              (".$fleet["uid"].", $aid, ".$fleet["fid"].", ".$fleet["prod_id"].", 'T', ".$this_divide.", $this_divide, ".$transport["id"].", 4)") or die ($GLOBALS["db"]->error);
        }
      }
    }
  }
  
  if (COMBAT_VERBOSE)
    echo ($total." Männchen! (".round(read_timer(1),4)."s)".COMBAT_NEWLINE);      

  if ($pid>0)
  {

    // Eintrag der beteiligten Gebäude

    if (COMBAT_VERBOSE)
    {
      echo ("Häuser eintragen...");
      
      start_timer(1);
    }

    $sth=$GLOBALS["db"]->query("SELECT p.uid, co.prod_id, IFNULL(co.type, 0) AS type FROM planets p INNER JOIN constructions co ON co.pid=p.id 
WHERE p.id=".$pid." AND p.sid=".$sid) or die("SEL1: ".$GLOBALS["db"]->error);

    if (!$sth)
      return false;

    $total=0;

    $aid=get_aid_by_uid(get_uid_by_pid($pid));
    
    if (!$aid)
      $aid=0;
    
    while ($fleet=$sth->fetch_assoc())
    {

      // Jedes Häuschen ein Einträgchen

      $total++;
  
      $sth1=$GLOBALS["db"]->query("INSERT INTO combat (uid, aid, prod_id, position, category, count, count_max) VALUES
(".$fleet["uid"].", ".$aid.", ".$fleet["prod_id"].", IF(".$fleet["type"]."=1,'O','P'),3,1,1)") or 
die ("INS1: ".$GLOBALS["db"]->error);
    }
    
    if (COMBAT_VERBOSE)
      echo ($total." Häuschen! (".round(read_timer(1),4).")".COMBAT_NEWLINE);
    
    // Eintrag der beteiligten Bodentruppen
    
    if (COMBAT_VERBOSE)
    {
      echo ("Bodentrüppchen eintragen...");
      
      start_timer(1);
    }

    if (defined("COMBAT_MAX_FRACTION"))
    {
      unset($fraction_total, $fraction_group);
      
      $sth=$GLOBALS["db"]->query("SELECT IFNULL(u.alliance, 0) AS aid, SUM(count) AS infcount FROM infantery INNER JOIN 
users u ON u.id=uid WHERE pid=$pid GROUP BY u.alliance") or die ("FRA1: ".$GLOBALS["db"]->error);
      
      while ($fraction=$sth->fetch_assoc())
      {
        $fraction_total[$fraction["aid"]]=$fraction["infcount"];
        
        $fraction_group[$fraction["aid"]]=ceil($fraction["infcount"]/COMBAT_MAX_FRACTION);
      } 
    }
    
    $sth=$GLOBALS["db"]->query("SELECT SUM(Count) AS CountSum, prod_id, uid FROM infantery 
WHERE pid=".$pid." GROUP BY prod_id, uid") or die ("SEL1: ".$GLOBALS["db"]->error);

    if (!$sth)
      return false;
    
    $total=0;
      
    while ($fleet=$sth->fetch_assoc())
    {
      
      // Jedes Männchen ein Einträgchen
      
      $aid=get_aid_by_uid($fleet["uid"]);
      print "=>".$aid."\n";
      if (!$aid)
        $aid=0;
  
      if (defined("COMBAT_MAX_FRACTION"))
        $inc=$fraction_group[$aid];
      else
        $inc=1;

      for ($i=0; $i<$fleet["CountSum"]; $i+=$inc)
      {
        if (defined("COMBAT_MAX_FRACTION"))
          if ($i+$inc > $fleet["CountSum"])
            $thisgroup=$fleet["CountSum"]-$i;
          else
            $thisgroup=$inc;
        else
          $thisgroup=1;
      
        $total+=$thisgroup;
            
        //echo ("$i+$thisgroup=$total/".$fleet["CountSum"]."".COMBAT_NEWLINE);
            
        $sth1=$GLOBALS["db"]->query("INSERT INTO combat (uid, aid, prod_id, position, category, count, count_max) VALUES (".$fleet["uid"].
", ".$aid.", ".$fleet["prod_id"].", 'P', 2, $thisgroup, $thisgroup)") or die ("INS1: ".$GLOBALS["db"]->error);
      
      }
    }
    
    if (COMBAT_VERBOSE)
      echo ($total." Männchen! ".round(read_timer(1),4)."s)".COMBAT_NEWLINE);   
  }
}

//-----------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------------------------
// Funktion: finalize_table
// Trägt die Werte der Tabelleninhalte ein
//-----------------------------------------------------------------------------------------------------

function combat_finalize_table($puid, $pid)
{ 
  // Jetzt werden die Kampfwerte eingefüllt...

  if (COMBAT_VERBOSE)
  {
    echo ("Trage die Kampfwerte ein...");
    
    start_timer(1);
  }
  
  // Größenklassen

  $sth=$GLOBALS["db"]->query("UPDATE combat c INNER JOIN production p USING(prod_id) SET c.type=p.typ, 
c.size=IF(p.typ='O','H',IF(p.typ='P','H',IF (p.typ='R','H',IF(p.typ='I','L',p.typ))))") 
or die ($GLOBALS["db"]->error);

  $sth=$GLOBALS["db"]->query("UPDATE combat c INNER JOIN shipvalues sv USING(prod_id) SET 
c.size='M' WHERE c.size='L' AND sv.tonnage>1 AND c.type='I'") or die ($GLOBALS["db"]->error);

  // Kampfwerte

  $sth=$GLOBALS["db"]->query("UPDATE combat c INNER JOIN shipvalues sv USING(prod_id) SET 
c.initiative_max=sv.initiative, c.agility=sv.agility, 
c.hull=sv.hull, c.hull_max=sv.hull, c.weaponpower=sv.weaponpower, c.shield=sv.shield, 
c.shield_max=sv.shield, c.ecm_max=sv.ecm, c.target1=sv.target1, 
c.sensor=sv.sensor, c.weaponskill=sv.weaponskill, c.special=sv.special, c.armor=sv.armor, 
c.armor_max=sv.armor, c.num_attacks=sv.num_attacks WHERE c.hull IS NULL") or die ($GLOBALS["db"]->error);

  if (!$sth)
    return false;

  if (!$sth)
    return false;

  // Admiralsbonus hinterherkippen
  
  $sth=$GLOBALS["db"]->query("UPDATE combat c INNER JOIN admirals ad ON ad.id=c.admiral_id SET 
c.agility=c.agility+ad.agility, c.sensor=c.sensor+ad.sensor, c.initiative=c.initiative+ad.initiative, 
c.weaponskill=c.weaponskill+ad.weaponskill") or die ($GLOBALS["db"]->error);

  // Numerisch Größen berechnen und Prioritäten vergeben
  
  $sth=$GLOBALS["db"]->query("UPDATE combat SET size_num=IF(size='L',1,IF(size='M',2,IF(size='H',3,NULL))),
target1_num=IF(target1='L',1,IF(target1='M',2,IF(target1='H',3,NULL))), 
priority=IF(prod_id=3,-100,IF(special LIKE 'H%',1000,IF(num_attacks=0 AND position='P' AND 
IFNULL(special,'')='',-50,priority
)))") 
or die ("PRIO: ".$GLOBALS["db"]->error);

  // Letzte Schildwerte berechnen
  
  $query=$GLOBALS["db"]->query("SELECT * FROM combat WHERE special LIKE 'H%'") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
    if ($shield=dlookup("value","planetary_shields","pid=$pid AND 
prod_id={$result['prod_id']}"))
      $sql=$GLOBALS["db"]->query("UPDATE combat SET shield=$shield, shield_max=$shield WHERE id={$result['id']}");
      
  // Dig-Ins berechnen
  
  if (COMBAT_DIGIN_ORBIT>1)
    $sth=$GLOBALS["db"]->query("UPDATE combat c SET digin_depth=".COMBAT_DIGIN_ORBIT."
WHERE position='O' AND uid=$puid") or die ($GLOBALS["db"]->error)
or die ($GLOBALS["db"]->error);

  if (COMBAT_DIGIN_BONUS_ORBIT>1)
    $sth=$GLOBALS["db"]->query("UPDATE combat c SET digin_bonus=".COMBAT_DIGIN_BONUS_ORBIT."
WHERE position='O' AND uid=$puid") or die ($GLOBALS["db"]->error)
or die ($GLOBALS["db"]->error);
  
  if (COMBAT_DIGIN_PLANET>1)
    $sth=$GLOBALS["db"]->query("UPDATE combat c SET digin_depth=".COMBAT_DIGIN_PLANET." 
WHERE position='P' AND (size='L' or size='M') AND uid=$puid") or die ($GLOBALS["db"]->error)
or die ($GLOBALS["db"]->error);

  if (COMBAT_DIGIN_BONUS_PLANET>1)
    $sth=$GLOBALS["db"]->query("UPDATE combat c SET digin_bonus=".COMBAT_DIGIN_BONUS_PLANET." 
WHERE position='P' AND (size='L' or size='M') AND uid=$puid") or die ($GLOBALS["db"]->error)
or die ($GLOBALS["db"]->error);
    
  if (COMBAT_BOOST>1)
    $sth=$GLOBALS["db"]->query("UPDATE combat c SET num_attacks=num_attacks*".COMBAT_BOOST.", 
sensor=sensor*".COMBAT_BOOST.", weaponskill=weaponskill*".COMBAT_BOOST." WHERE
position='O' OR (position='P' AND size='H')") or die ($GLOBALS["db"]->error);
    
  $sth=$GLOBALS["db"]->query("UPDATE combat SET digin_bonus=digin_bonus+IFNULL(CONV(SUBSTRING(special FROM 2),10,10),0)
WHERE special LIKE 'U%'") or die ($GLOBALS["db"]->error);
    
  // Extra Dig-In von Einheiten berechnen
  
  $digin_extra=dsum("CONV(SUBSTRING(special FROM 2),10,10)","combat","special LIKE 'F%'");
  
  if ($digin_extra>0)
  {
    $digin_extra_half=round($digin_extra)/2;
    
    $sth=$GLOBALS["db"]->query("UPDATE combat SET digin_depth=digin_depth-$digin_extra_half, 
digin_bonus=digin_bonus+$digin_extra WHERE position='P' AND (size='L' or size='M') AND uid=$puid") 
or die ($GLOBALS["db"]->error);
  } 
    
  // Challenge-Wert ausrechnen (fuer Admiraele)
  
  $sth=$GLOBALS["db"]->query("UPDATE combat SET challenge=round(((num_attacks*weaponpower)+pow(10,size_num)+hull_max+
shield_max*5+armor_max+agility+weaponskill+ecm_max+sensor)*(1+digin_bonus/100))") or die($GLOBALS["db"]->error);

  // Admiraele plazieren
  
  $query=$GLOBALS["db"]->query("SELECT DISTINCT admiral_id, fid FROM combat WHERE IFNULL(admiral_id,0)<>0") 
or die ($GLOBALS["db"]->error);
  
  while ($result=$query->fetch_assoc())
  {
    $admiral_vessel=dlookup("id","combat","admiral_id=".$result["admiral_id"]." AND challenge="
.dmax("challenge","combat","admiral_id=".$result["admiral_id"]));

    if (dlookup("count","combat","id=$admiral_vessel")>1)
      $admiral_vessel=combat_split_table($admiral_vessel, 1);

    $sth=$GLOBALS["db"]->query("UPDATE combat SET admiral_carried=".$result["admiral_id"].
" WHERE id=$admiral_vessel");
  }
  
  if (!$sth)
    return false;
    
  if (COMBAT_VERBOSE)
    echo ("OK! (".round(read_timer(1), 4)."s)".COMBAT_NEWLINE); 
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_commit
// Führt einen Kampf basierend auf der wertegefüllten Kampftabelle aus
//-----------------------------------------------------------------------------------------------------

function combat_commit($pid) 
{
  global $combat;
  
  if (COMBAT_VERBOSE)
    echo ("Kampf wird durchgeführt...".COMBAT_NEWLINE);

  // Los geht's! Alle Einheiten werden durchlaufen...
  
  $puid=get_uid_by_pid($pid);
  
  $paid=get_alliance($puid);
  
  $ini_loop_qry=$GLOBALS["db"]->query("SELECT id FROM combat WHERE aid<>0 AND initiative >= 0 
AND killed_by IS NULL AND position <> 'T' AND position <> 'L' ORDER BY initiative DESC, 
Rand()") or die ($GLOBALS["db"]->error);

  $time_target=0; 
  $time_shoot=0;
  
  if (!$ini_loop_qry)
    return false;
    
  while ($ini_unit=$ini_loop_qry->fetch_assoc())
  {
    $unit=&$combat[$ini_unit["id"]];

    $startcount=$unit["count"];
    
    for ($group=1;$group<=$startcount;$group++)
    {
      if (COMBAT_MAXIMUM_VERBOSITY) 
      {
        $verbose_info_qry=$GLOBALS["db"]->query("SELECT * FROM production WHERE prod_id=".$unit["prod_id"]) or die
  ($GLOBALS["db"]->error);
  
        $verbose_info=$verbose_info_qry->fetch_assoc();
        
        echo("&nbsp;&nbsp;".$unit["uid"]."/".$unit["aid"]."/".$unit["initiative"]."/".$unit["ecm"]." ".$verbose_info["name"]." ".$unit["id"]." Squad $group/$startcount: ");
      }
      
      if ($unit["position"]=="L")
      {
        if (COMBAT_MAXIMUM_VERBOSITY)
          echo ("group has landed already!");
        
        break;
      }
      
      // Lebe ich überhaupt noch?
                        
      if (is_null($unit["killed_by"]))
      {
    
        // Bin ich ein beladener Transporter? Mag ich abladen?
        
        if ($unit["transport_capacity"]>0  && $unit["mission"]==M_INVADE && 
dcount("id","combat","on_transport=".$unit["id"])>0)
        { 
          
          // Und ist der Planet überhaupt feindlich?? Sind die Schilde schon aus? 
          // Oder darf ich durch Schilde durchfliegen?
          
          if (is_enemy($paid,$unit["aid"]))
          {
            if (dcount("id","combat","count > 0 AND special LIKE 'H%'")==0 || $unit["special"]=="P")
            {
              // Okaydo, los geht's mit Abwehrfeuer
              
              if (COMBAT_MAXIMUM_VERBOSITY)
                echo("INVADE ");
  
              $query=$GLOBALS["db"]->query("SELECT id FROM combat WHERE special='D' AND count>0 
  AND counterfire<num_attacks*2") or die ($GLOBALS["db"]->error);
  
              while (list($d_id)=$query->fetch_row())
              {
                if (COMBAT_MAXIMUM_VERBOSITY)
                  echo("counterfire ");       
                  
                for ($i=$combat[$d_id]["counterfire"];$i<$combat[$d_id]["num_attacks"]*2;$i++)
                {
                  if (combat_shoot_unit($d_id, $unit["id"], true)=="KILLED")
                    break;
                }
                
                if ($unit["count"]<=0)
                  break;
              }
              
              if ($unit["count"]>0)
              {
                $combat["shots_fired"]++;
                
                $sth=$GLOBALS["db"]->query("UPDATE combat SET position='U', on_transport=NULL WHERE 
        on_transport=".$unit["id"]." AND killed_by IS NULL") or die ($GLOBALS["db"]->error);
        
                // Transporter gelandet?
              
                if ($GLOBALS["db"]->affected_rows > 0)
                {
                  $sth=$GLOBALS["db"]->query("UPDATE combat SET position='L' WHERE id=".$unit["id"]);     
                  
                  $unit["position"]="L";
                  
                  if (COMBAT_MAXIMUM_VERBOSITY)
                    echo("UNLOAD ");
                }
              }
            } 
          }
        }
        
        // Kann ich denn schießen?
        
        if ($unit["weaponpower"]>0 && $unit["num_attacks"]>0 && $unit["count"]>0 )
        {
            
          // Jau, also schnell ein paar Werte geladen...
          
          unset($target_pos_ar);
            
          $target_pos=$unit["position"];
          $target_pos_ar[]=$unit["position"];
              
          if ($unit["special"]=="B" && ($unit["mission"]==M_BOMB || $unit["mission"]==M_INVADE))
          {
            $target_pos="P,O";
            $target_pos_ar[]="P";
          }
          
          if ($unit["special"]=="D")
          {
            if (COMBAT_MAXIMUM_VERBOSITY)
              echo ("orbital defense ");
            
            $target_pos="O";
            unset($target_pos_ar);
            $target_pos_ar[]="O";
          }
        
          // Dann schauen wir doch mal nach einem Primärziel
          
          $guns_fired=0;
          $living=1;
    
          do
          {
            $found_target=false;
                      
            // Sensoren ausreichend?
            
            $sensor_check=mt_rand(0, $unit["sensor"]);
            $digger_luck=mt_rand(1,100+$sensor_check);

            // Letztes Ziel noch mal?
            
            if ($last_target[$unit["aid"]] && $last_target[$unit["aid"]]["ecm"]<=$sensor_check && 
$last_target[$unit["aid"]]["size_num"]==$unit["target1_num"])
            {             
              if (is_null($last_target[$unit["aid"]]["killed_by"]) && 
$digger_luck>$last_target[$unit["aid"]]["digin_depth"]+$last_target[$unit["aid"]]["digin_bonus"] &&
in_array($last_target[$unit["aid"]]["position"], $target_pos_ar))
              {
                if (COMBAT_MAXIMUM_VERBOSITY)
                  echo ("(last trg) ");

                $found_target=true;
                $target=&$combat[$last_target[$unit["aid"]]["id"]];
              }
              else
                unset($last_target[$unit["aid"]]);
            }
            else
              unset($last_target[$unit["aid"]]);
            
            start_timer(1);
            
            if (!$found_target)
            {           
              $target_id=combat_acquire_target($unit, $target_pos, $sensor_check, $digger_luck);

              if ($target_id)
              {
                $target=&$combat[$target_id];
                $found_target=true;

                if ($target["aid"] == $unit["aid"])
                {
                  echo ("ALERT($target_id)!!");
                  combat_validate_index("alert_trigger");
                }              
              }
            }
            
            $time_target+=read_timer(1);
      
            if ($found_target)
            {         

              $last_target[$unit["aid"]]=&$combat[$target["id"]];
                        
              if (COMBAT_MAXIMUM_VERBOSITY)
              {
                $verbose_info_qry=$GLOBALS["db"]->query("SELECT * FROM production WHERE prod_id=".$target["prod_id"]) or die
    ($GLOBALS["db"]->error);
          
                $verbose_info=$verbose_info_qry->fetch_assoc();           
                echo("TARGET(".$target["uid"]."/".$target["aid"]." ".$verbose_info["name"]." [".$target["count"]."] ".$target["id"].") ");
              }
              
              do
              {
                $guns_fired++;
            
                start_timer(1);
                
                $shoot_val=combat_shoot_unit($unit["id"], $target["id"], false);
                
                if ($shoot_val=="KILLED")
                  $target["counterfire"]=0;
    
                $time_shoot+=read_timer(1);
    
                if ($shoot_val!="KILLED" && $target["hull"]>0 && 
$target["counterfire"]<$target["num_attacks"] && 
($target["position"]==$unit["position"] || ($target["position"]!=$unit["position"] && 
$target["special"]=="D")))
                {
                  if (COMBAT_MAXIMUM_VERBOSITY)
                    echo("counterfire ");           
                  
                  $target["counterfire"]++; 
    
                  start_timer(1);
    
                  $shoot_val=combat_shoot_unit($target["id"], $unit["id"], true);
                    
                  if ($shoot_val=="KILLED")
                    $guns_fired=$unit["num_attacks"];
    
                  $time_shoot+=read_timer(1);
                }
                
              } while ($guns_fired<$unit["num_attacks"] && $unit["hull"]>0 && $target["hull"]>0);         
                            
              if ($target["hull"]>0)
                $sth=$GLOBALS["db"]->query("UPDATE combat SET counterfire=".$target["counterfire"]." WHERE id=".$target["id"]);
              else
                unset($last_target[$unit["aid"]]);
              
            }
            else
              if (COMBAT_MAXIMUM_VERBOSITY)
                echo ("no more targets, ");
          } while  ($found_target && $guns_fired<$unit["num_attacks"] && $unit["hull"]>0);
          
          if (COMBAT_MAXIMUM_VERBOSITY)
            echo("finished. Totally ".$guns_fired." guns fired.".COMBAT_NEWLINE);
        }
        else
          if (COMBAT_MAXIMUM_VERBOSITY)
            echo ("unarmed!".COMBAT_NEWLINE);
      } 
      else
        if (COMBAT_MAXIMUM_VERBOSITY)
          echo ("dead already!".COMBAT_NEWLINE);
    }
  }
  
  
  
  if (COMBAT_VERBOSE)
    echo ("...Kampf beendet! Schießen: ".round($time_shoot, 4)."s; Zielen: "
.round($time_target, 4)."s".COMBAT_NEWLINE.COMBAT_NEWLINE);
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_report
// Spuckt bei Bedarf einen Bericht aus und speichert ihn irgendwo hin...
//-----------------------------------------------------------------------------------------------------

function combat_report ($pid, $sid) {
  global $combat;
  
  if (COMBAT_VERBOSE)
  {
    start_timer(1);
    
    echo("Erstelle Kampfbericht...");
  } 
  
  $combat_smarty=new Smarty;
  
  global $__base_inc_dir;
  
  $combat_smarty->template_dir = $__base_inc_dir."battle/templates/"; 
  $combat_smarty->compile_dir  = $__base_inc_dir."battle/templates_c";  
  $combat_smarty->config_dir   = $__base_inc_dir."battle/configs/";  
  $combat_smarty->cache_dir    = $__base_inc_dir."battle/cache/";
  
  $puid=get_uid_by_pid($pid);
  
  if ($pid)
  {
    
    
    if ($puid)
      $puname=get_name_by_uid($puid);
    else
      $puname="no owner";
    
    if ($pid==-1)
      $combat_smarty->assign("location", "SimOrbit");
    else
      $combat_smarty->assign("location", get_planetname($pid)." ($puname)");
  }
  else
    $combat_smarty->assign("location", get_systemname($sid));
    

  $invader_id=combat_get_conqueror($pid);
  
  if (!$invader_id)
    $combat_smarty->assign("invasion", "");
  else
  {
    $combat["shots_fired"]++;
    if ($invader_id<0 && $invader_id>-100)
      $combat_smarty->assign("invasion", "Planet1 has been invaded by Side2");
    elseif ($invader_id==-100)
      $combat_smarty->assign("invasion", "Planetary combat, production was delayed.");
    else
      $combat_smarty->assign("invasion", get_planetname($pid)." has been invaded by ".get_name_by_uid($invader_id));
  }
  
  // Admiraele berichten

  $query=$GLOBALS["db"]->query("SELECT SUM(c1.challenge) AS xp_earned, c2.admiral_id AS admiral_id, c2.uid 
AS uid FROM combat c1 INNER JOIN combat c2 ON (c1.killed_by=c2.id) WHERE c2.admiral_id <> 0 
GROUP BY c2.admiral_id") or die ("Admiral-XP: ".$GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    if (!is_array($results[$result["uid"]]["admirals"]))
      $aidx=0;
    else
      $aidx=sizeof($results[$result["uid"]]["admirals"]);
    
    $results[$result["uid"]]["admirals"][$aidx]["name"] =
dlookup("name","admirals","id=".$result["admiral_id"]);

    if (is_null(dlookup("killed_by","combat","admiral_carried=".$result["admiral_id"])))
    {
      $results[$result["uid"]]["admirals"][$aidx]["xp"]   =
dlookup("value","admirals","id=".$result["admiral_id"]);  
      $results[$result["uid"]]["admirals"][$aidx]["newxp"]=
dlookup("value","admirals","id=".$result["admiral_id"])+$result["xp_earned"];
      $results[$result["uid"]]["admirals"][$aidx]["lvlup"]=
calculate_admiral_level(dlookup("value","admirals","id=".$result["admiral_id"])+$result["xp_earned"])!=
calculate_admiral_level(dlookup("value","admirals","id=".$result["admiral_id"]));
    }
  }
  
  $users_query=$GLOBALS["db"]->query("SELECT DISTINCT uid, aid FROM combat") or die ($GLOBALS["db"]->error);
  
  if (!$users_query)
    return false;
    
  while ($users_result=$users_query->fetch_assoc())
  {
    // Feinde
    
    $results_query=$GLOBALS["db"]->query("SELECT alliance2 FROM diplomacy dp WHERE status=0 AND 
alliance1=".$users_result["aid"]) or die ($GLOBALS["db"]->error);
        
    if (!$results_query)
      return false;
    
    while (list($results[$users_result["uid"]]["enemies"][])=$results_query->fetch_row());    
        
    // Schiffe gesamt
    
    $namefield="CONCAT(p.name, ' ', IF(c.position='L','[unloaded]',
IF(c.position='T','[on transport]',IF(c.position='U','[landed]',IF(IFNULL(c.killed_special,'')='E',
'[disabled]',IF(IFNULL(c.killed_special,'')='R', '[captured]', ''))))))";
    
    $results_query=$GLOBALS["db"]->query("SELECT $namefield AS name, 
SUM(c.count_max) AS count FROM combat c INNER JOIN production p 
USING (prod_id) WHERE uid=".$users_result["uid"]." GROUP BY p.name, c.position, c.killed_special") or die ($GLOBALS["db"]->error);

    if (!$results_query)
      return false;
      
    while ($unit=$results_query->fetch_assoc())
    {   
      $results[$users_result["uid"]]["ships"][$unit["name"]]=$unit["count"];
    }

    // Schiffe zerstört

    $results_query=$GLOBALS["db"]->query("SELECT $namefield AS name, SUM(c.count_max-c.count) AS count,
IFNULL(c.killed_special,'') AS killed_special FROM combat c INNER JOIN production p 
USING (prod_id) WHERE uid=".$users_result["uid"]." GROUP BY p.name, c.position, c.killed_special") or die ($GLOBALS["db"]->error);

    if (!$results_query)
      return false;
      
    while ($unit=$results_query->fetch_assoc())
    {
      if ($unit["killed_special"]!="E" && $unit["killed_special"]!="R")
        $results[$users_result["uid"]]["destroyed_ships"][$unit["name"]]=$unit["count"];    
    }
    
    // Schiffe lebendig

    $results_query=$GLOBALS["db"]->query("SELECT $namefield AS name, SUM(c.count) AS count,
IFNULL(c.killed_special,'') AS killed_special FROM combat c INNER JOIN production p 
USING (prod_id) WHERE c.killed_by IS NULL AND uid=".$users_result["uid"]." GROUP BY p.name, c.position, 
c.killed_special") or die ($GLOBALS["db"]->error);

    if (!$results_query)
      return false;
      
    while ($unit=$results_query->fetch_assoc())
    {
      if ($unit["killed_special"]!="E" && $unit["killed_special"]!="R")
        $results[$users_result["uid"]]["remaining_ships"][$unit["name"]]=$unit["count"];    
    }
  }
  
  // Planetare Schilde berichten
  
  $query=$GLOBALS["db"]->query("SELECT 'Planetary shields' AS name, SUM(c.shield) AS shieldsum, 
SUM(c.shield_max) AS maxsum FROM combat c INNER JOIN production p USING (prod_id) WHERE c.special 
LIKE 'H%'") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    if($result["maxsum"]>0)
    {
      $results[$puid]["ships"][$result["name"]]=$result["maxsum"];
      $results[$puid]["destroyed_ships"][$result["name"]]=$result["maxsum"]-$result["shieldsum"];
      $results[$puid]["remaining_ships"][$result["name"]]=$result["shieldsum"];
    }
  } 
  
  $combat_smarty->assign("results", $results);
  
  $users_query=$GLOBALS["db"]->query("SELECT DISTINCT uid FROM combat") or die ($GLOBALS["db"]->error);
  
  if (!$users_query)
    return false;
    
  while ($users_result=$users_query->fetch_assoc())
  {
    if ($users_result["uid"]<0)
      $users[$users_result["uid"]]="BattleSim Side ".($users_result["uid"]*-1);
    else
      $users[$users_result["uid"]]=get_name_by_uid($users_result["uid"]);
  } 
  
  $combat_smarty->assign("users", $users);

  ob_start();

  $combat_smarty->display("battlereport.tpl");

  $report=ob_get_contents();

  ob_end_clean();

  $combat_smarty->clear_all_assign();
  
  // Report abspeichern
  
  if (BATTLE_DESTROY && $combat["shots_fired"]>0)
  {
    $week=dlookup("week","timeinfo");
    
    $sth=$GLOBALS["db"]->query("INSERT INTO battlereports SET pid=$pid, sid=$sid, 
report='".addslashes($report)."', week=$week") or die ($GLOBALS["db"]->error);
    $report_id=$GLOBALS["db"]->insert_id;
    
    $query=$GLOBALS["db"]->query("SELECT DISTINCT uid FROM combat") or die ($GLOBALS["db"]->error); 
    while (list($id)=$query->fetch_row())
      $sth=$GLOBALS["db"]->query("INSERT INTO battlereports_user (uid, rid) VALUES ($id, $report_id)") or
die ($GLOBALS["db"]->error);

    $query=$GLOBALS["db"]->query("SELECT DISTINCT aid FROM combat") or die ($GLOBALS["db"]->error); 
    while (list($id)=$query->fetch_row())
      $sth=$GLOBALS["db"]->query("INSERT INTO battlereports_alliance (aid, rid) VALUES ($id, $report_id)") or
die ($GLOBALS["db"]->error);
  }     
  
  if (COMBAT_VERBOSE)
    echo ("OK! (".round(read_timer(1),4)."s)".COMBAT_NEWLINE.COMBAT_NEWLINE);

  if (!BATTLE_DESTROY)
    echo("$report".COMBAT_NEWLINE.COMBAT_NEWLINE);  
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_store_commit()
// Je nach Modus wird das SQL-Statement ausgeführt oder nur ausgegeben.
//-----------------------------------------------------------------------------------------------------

function combat_store_commit($sql, $commit) {
  if ($commit)
    $sth=$GLOBALS["db"]->query($sql) or die ($sql.": ".$GLOBALS["db"]->error);

  if (COMBAT_VERBOSE)
    echo(round(read_timer(1),4)."s: $sql".COMBAT_NEWLINE);
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_get_conqueror()
// Gibt die User-ID des Eroberers oder false zurueck, oder auch -100 wenn ein Boden-
// kampf stattgefunden hat.
//-----------------------------------------------------------------------------------------------------

function combat_get_conqueror($pid)
{
  $retval=false;
  
  if ($pid>0)
  {
    $puid=get_uid_by_pid($pid);
  
    $paid=get_aid_by_uid($puid);
    
    if (!$paid)
      return false;
  }
  elseif ($pid==0 || !$pid)
  {
    return false;
  }
  else
  {
    $puid=-1;
    
    $paid=-1;
  }
  
  if ($paid>0) 
    $enemies=get_enemy_aids($puid);
  else
    $enemies[]=-2;

  if (sizeof($enemies)>0)
  {
    $query=$GLOBALS["db"]->query("SELECT uid, SUM((susebloom+mopgas+erkunum+energy+metal+gortium)*count) 
  AS inf_power FROM combat INNER JOIN production USING (prod_id) WHERE position='P' AND aid 
  IN (".implode(",", $enemies).") AND killed_by IS NULL GROUP BY uid 
  HAVING inf_power>0 ORDER BY inf_power DESC LIMIT 1") or die ($GLOBALS["db"]->error);
  
    if ($query->num_rows>0)
    {
      list($bestenemy, $bla)=$query->fetch_row();
    }
  } 
    
  $query=$GLOBALS["db"]->query("SELECT SUM(count) AS CountSum FROM combat WHERE position='P' AND
aid=$paid AND size<>'H'") or die ($GLOBALS["db"]->error);

  list($result)=$query->fetch_row();
  
  if ($result==0)
  {
    // Uh-Oh, keine Verteidiger mehr! Angreifer denn?
      
    if ($bestenemy)
    {
      $retval=$bestenemy;
    }
  }
  else
  {
    // Es sind noch Verteidiger da, waren denn auch Angreifer da?
    
    if ($bestenemy)
      $retval=-100;
  }
  
  return $retval;
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_store()
// Wertet die Kampftabelle aus und speichert die Effekte in der Datenbank
//-----------------------------------------------------------------------------------------------------

function combat_store ($pid, $commit) {
  
  global $combat;
  
  if (COMBAT_VERBOSE)
  {
    echo ("Werte Ergebnisse aus...".COMBAT_NEWLINE);
    
    start_timer(1);
  }
  
  $query=$GLOBALS["db"]->query("SELECT uid, fid, prod_id, special, category, killed_special, SUM(count_max-count) 
AS destroyed FROM combat GROUP BY uid, fid, prod_id, special, category, killed_special HAVING destroyed>0") 
or die ("DEST1: ".$GLOBALS["db"]->error);
  
  if (!$query)
    return false;
    
  while ($result=$query->fetch_assoc())
  {
    
    switch ($result["category"])
    {
      // Schiffchens
      case 1:
        if ($result["killed_special"]!="E")
        {
          $sql="UPDATE fleet SET count=count-".$result["destroyed"]." WHERE fid=".$result["fid"]. " AND prod_id=".$result["prod_id"];     
        
          combat_store_commit($sql, $commit);
        }        
        break;
        
      // Trüppchens (Planet)
      case 2:
        $sql="UPDATE infantery SET count=count-".$result["destroyed"]." WHERE pid=".$pid." AND uid=".$result["uid"]." AND prod_id=".$result["prod_id"];      
        combat_store_commit($sql, $commit);    
        break;
      
      // Gebäude
      case 3:
        switch ($result["killed_special"]{0})
        {
        	case "H":
		        // Planetare Schilde entfernen
	          $sql="DELETE FROM planetary_shields WHERE pid=".$pid." AND prod_id = ".$result["prod_id"];
  	        combat_store_commit($sql, $commit);
        	break;
        	case "T":
            // rune: Tradestation entfernen
		    		$sql="DELETE FROM tradestations WHERE uid = ".$result["uid"];
  	        combat_store_commit($sql, $commit);
        		$sql="DELETE FROM stockmarket_orders WHERE uid = ".$result["uid"];
  	        combat_store_commit($sql, $commit);
        	break;
        }
        
        
        $sql="DELETE FROM constructions WHERE pid=".$pid." AND prod_id=".$result["prod_id"];
      
        combat_store_commit($sql, $commit);

        break;
        
      // Truppen auf Transportern
      case 4:
        $sql="UPDATE inf_transports SET count=count-".$result["destroyed"]." WHERE  fid=".$result["fid"]." AND prod_id=".$result["prod_id"];
        combat_store_commit($sql, $commit);
        
        break;
    }
  }

  // Schiffe klauen
  
  $query=$GLOBALS["db"]->query("SELECT prod_id, killed_by, warpreload, SUM(count_max) AS CountSum FROM combat 
WHERE killed_special='R' GROUP BY prod_id, killed_by, warpreload") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    if ($commit)
    {
      if (!fleet_add($combat[$result["killed_by"]]["fid"], $result["prod_id"], $result["CountSum"], $result["warpreload"]))
        die("FLEET ADD:".$GLOBALS["db"]->error);
    }
  }

  // Truppen entladen
  
  $query=$GLOBALS["db"]->query("SELECT prod_id, SUM(count) AS SumCount, uid, fid FROM
combat WHERE position='U' GROUP BY uid, prod_id, fid") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    $sql="UPDATE inf_transports SET count=count-".$result["SumCount"]." WHERE 
fid=".$result["fid"]." AND prod_id=".$result["prod_id"];

    combat_store_commit($sql, $commit);
    
    if (dcount("prod_id","infantery","prod_id=".$result["prod_id"]." AND pid=$pid AND uid="
.$result["uid"])>0)
      $sql="UPDATE infantery SET count=count+".$result["SumCount"]." WHERE 
prod_id=".$result["prod_id"]." AND pid=$pid AND uid=".$result["uid"];
    else
      $sql="INSERT INTO infantery (prod_id, count, pid, uid) VALUES 
(".$result["prod_id"].", ".$result["SumCount"].", $pid, "
.$result["uid"].")";

    combat_store_commit($sql, $commit);
  }

  // Schildgeneratoren speichern

  $query=$GLOBALS["db"]->query("SELECT * FROM combat WHERE special LIKE 'H%' AND count>0") 
or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    $sql="UPDATE planetary_shields SET value={$result['shield']} WHERE prod_id=
{$result['prod_id']} AND pid=$pid";

    combat_store_commit($sql, $commit);
  }       

  // Planet erobert?
  
  if ($pid!=0)
  {
    $winner=combat_get_conqueror($pid);
    
    if ($winner)
    {
      $combat["shots_fired"]++;
      if ($winner==-100)
      {
        $sql="UPDATE planets SET last_combat=".dlookup("week","timeinfo");
	      combat_store_commit($sql, $commit);
      }
      else
      {        
        $sql="UPDATE planets SET uid=$winner,production_factor=0.01 WHERE id=$pid";
        combat_store_commit($sql, $commit);
      	// rune: wenn tradestation vorhanden, löschen, res dem eroberer gutschreiben
      	$sql = "UPDATE ressources r, tradestations t SET r.metal = r.metal + t.metal, r.energy = r.energy + t.energy, r.mopgas = r.mopgas + t.mopgas, r.erkunum = r.erkunum + t.erkunum, r.gortium = r.gortium + t.gortium, r.susebloom = r.susebloom + t.susebloom WHERE r.uid = $winner AND t.pid = ". $pid;
        combat_store_commit($sql, $commit);
        $sql = "DELETE t.*, c.*, s.* FROM tradestations t, constructions c, stockmarket_orders s, shipvalues sv WHERE t.pid = $pid and t.uid = s.uid and c.pid = t.pid and sv.special = 'T' and c.prod_id = sv.prod_id";
        combat_store_commit($sql, $commit);
      }
      
    }
  }
  
  // Erfahrungspunkte fuer Admiraele
  
  $query=$GLOBALS["db"]->query("SELECT SUM(c1.challenge*c1.count_max) AS xp_earned, c2.admiral_id AS admiral_id FROM 
combat c1 INNER JOIN combat c2 ON (c1.killed_by=c2.id) WHERE c2.admiral_id <> 0 
GROUP BY c2.admiral_id") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    $sql="UPDATE admirals SET value=value+".$result["xp_earned"]." WHERE id="
.$result["admiral_id"];
    
    combat_store_commit($sql, $commit);
  }
  
  // Töten der armen Admiräller
  
  $query=$GLOBALS["db"]->query("SELECT admiral_carried FROM combat WHERE killed_by IS NOT NULL AND 
admiral_carried IS NOT NULL");

  while ($result=$query->fetch_assoc())
  {
    $sql="DELETE FROM admirals WHERE id=".$result["admiral_carried"];
    
    combat_store_commit($sql, $commit);
  }
  
  if (COMBAT_VERBOSE)
    echo ("...fertig! (".round(read_timer(1),4)."s)".COMBAT_NEWLINE);
    
  echo(COMBAT_NEWLINE);
  
}

//-----------------------------------------------------------------------------------------------------
// Funktion: combat_cleanup_db()
// Räumt die Datenbank nach abgeschlossenen Kämpfen auf und löscht leere Einträge.
//-----------------------------------------------------------------------------------------------------

function combat_cleanup_db($commit)
{
  // Aufräumen in Datenbank
  
  if (COMBAT_VERBOSE)
  {
    start_timer(1);
    
    echo ("Datenbank wird aufgeräumt...".COMBAT_NEWLINE);
  } 
  
  $query=$GLOBALS["db"]->query("SELECT f.fid, SUM(f.count) AS CountSum FROM fleet f 
GROUP BY f.fid HAVING CountSum=0") or die ($GLOBALS["db"]->error);

  while ($result=$query->fetch_assoc())
  {
    $sql="DELETE FROM fleet_info WHERE fid=".$result["fid"];
  
    combat_store_commit($sql, $commit);
  }

  $sql="DELETE FROM fleet WHERE count=0";
  
  combat_store_commit($sql, $commit);
  
  
  $sql="DELETE FROM inf_transports WHERE count=0";
  
  combat_store_commit($sql, $commit);
  
  $sql="DELETE FROM infantery WHERE count=0";
  
  combat_store_commit($sql, $commit);
  
  if (COMBAT_VERBOSE)
    echo ("...fertig! (".round(read_timer(1),4).")".COMBAT_NEWLINE);
}
  
function combat_ticker_prepare(&$alliances, &$users)
{
  if (COMBAT_VERBOSE)
    echo("Bereite Tickermeldungen vor...");
    
  $query=$GLOBALS["db"]->query("SELECT DISTINCT uid FROM combat");
  while (list($id)=$query->fetch_row())
    $users[$id]++;
      
  $query=$GLOBALS["db"]->query("SELECT DISTINCT aid FROM combat");
  while (list($id)=$query->fetch_row())
    $alliances[$id]++;
      
  if (COMBAT_VERBOSE)
    echo("OK!".COMBAT_NEWLINE.COMBAT_NEWLINE);      
}

function combat_ticker($alliances, $users)
{
  $week=dlookup("week","timeinfo");
  
  foreach ($users as $uid => $count)
    ticker($uid, "*lbattlereport.php?act=show_own&_minw=$week&_maxw=$week*You were involved in ".$count." battles!","a");
    
  foreach ($alliances as $aid => $count)
  {
    $members=get_alliance_members($aid);
    
    foreach ($members as $uid => $name)
    {
      // mop: gabs ausser den eigenen auch noch kämpfe?
      if ($count-$users[$uid]>0)
        ticker($uid, "*lbattlereport.php?act=show_alliance&_minw=$week&_maxw=$week*Your alliance was involved in ".($count-$users[$uid])." battles!","a");
    }
  }
}
  
function combat_read_table()
{
  // Einlesen der Kontrahenten in den Speicher
  
  if (COMBAT_VERBOSE)
  {
    start_timer(1);
    
    echo ("Lese Kampfdaten in den Speicher...");
  }
  
  $query=$GLOBALS["db"]->query("SELECT * FROM combat") or die ($GLOBALS["db"]->error);;
  
  while ($result=$query->fetch_assoc())
    $retval[$result["id"]]=$result;
    
  if (COMBAT_VERBOSE)
    echo ("OK! (".round(read_timer(1),4).")".COMBAT_NEWLINE.COMBAT_NEWLINE);
    
  return $retval;
}

  
//-----------------------------------------------------------------------------------------------------
// MAIN
// Führt nacheinander die Einzelschritte des Kampfes für jeden einzelnen Konflikt aus.
//-----------------------------------------------------------------------------------------------------

// mop: die includes brauchen noch den alten mysqlconnect :(
connect();

$db=new mysqli($mysql_host,$mysql_user,$mysql_pw,$mysql_db);

start_timer("combat");

if (COMBAT_VERBOSE)
  echo (COMBAT_NEWLINE."-----".COMBAT_NEWLINE."KAMPF".COMBAT_NEWLINE."-----".COMBAT_NEWLINE);

if (!SIMULATION_MODE)
{
  if (COMBAT_VERBOSE)
  {
    echo ("Hauptschleife initialisieren...");
    
    start_timer(1);
  }

  $loop_battles=$db->query("SELECT DISTINCT p.sid AS sid, p.id AS pid FROM planets p, 
fleet_info f,users u1, users u2,diplomacy d 
WHERE f.sid=p.sid AND f.pid=p.id AND u1.id=p.uid AND u2.id=f.uid AND d.alliance1=u1.alliance AND 
d.alliance2=u2.alliance AND d.status=0 AND f.mission in (1,2) 
UNION DISTINCT 
SELECT DISTINCT p.sid AS sid, p.id AS pid FROM planets p, 
infantery i,users u1, users u2,diplomacy d 
WHERE i.pid=p.id AND u1.id=p.uid AND u2.id=i.uid AND d.alliance1=u1.alliance AND 
d.alliance2=u2.alliance AND d.status=0 
UNION DISTINCT 
SELECT DISTINCT p.sid AS sid, i1.pid AS pid FROM infantery i1, infantery i2, users u1, users u2, diplomacy d, planets p WHERE 
i1.pid=i2.pid AND u1.id=i1.uid AND u2.id=i2.uid AND d.alliance1=u1.alliance AND d.alliance2=u2.alliance 
AND d.status=0 AND p.id=i1.pid") or die ($db->error);

  if (!$loop_battles)
    return false;
  
  $battles=array();
    
  while (list($sid, $pid)=$loop_battles->fetch_row())
    $battles[]=array("sid"=>$sid, "pid"=>$pid);
  
  $query=$db->query("SELECT DISTINCT sid, pid, COUNT(DISTINCT alliance) AS UserCount 
FROM fleet_info INNER JOIN users ON users.id=fleet_info.uid INNER JOIN diplomacy ON 
users.alliance=diplomacy.alliance1 WHERE status=0 GROUP BY sid, pid HAVING UserCount > 1")
or die ($db->error);
 
  while ($result=$query->fetch_assoc())
  {
    $query2=$db->query("SELECT DISTINCT f1.sid AS sid, f1.pid AS pid FROM fleet_info f1,
 fleet_info f2, users u1, users u2,diplomacy d WHERE f1.pid=".$result["pid"]." AND f1.sid="
 .$result["sid"]." AND f1.pid=f2.pid AND f1.sid=f2.sid AND 
 f1.fid!=f2.fid AND f1.uid!=f2.uid AND u1.id=f1.uid AND u2.id=f2.uid AND 
 d.alliance1=u1.alliance AND d.alliance2=u2.alliance AND d.status=0") or die ($db->error);
 
    while (list($sid, $pid)=$query2->fetch_row())
      if (!in_array(array("sid"=>$sid,"pid"=>$pid),$battles))
        $battles[]=array("sid"=>$sid,"pid"=>$pid);
  }
  
  if (COMBAT_VERBOSE)
    echo ("OK! (".round(read_timer(1),4)."s)".COMBAT_NEWLINE.COMBAT_NEWLINE);   
  
  $alliances=array();
  $users=array();
  
  // Durchlaufen der Hauptschleife
  
  foreach ($battles as $battle)
  { 
    $puid=get_uid_by_pid($battle["pid"]);
    
    if(!$puid)
      $puid=0;
      
    if (COMBAT_VERBOSE)
      echo ("Kampf in sys ".$battle["sid"]." pl ".$battle["pid"].":".COMBAT_NEWLINE);
    
    combat_create_temporary();
    
    combat_insert_combatants($battle["sid"], $battle["pid"]);
    
    combat_finalize_table($puid, $battle["pid"]);
          
    for ($i=0;$i<BATTLE_DURATION;$i++)
    {
      unset($combat_targets);
      
      combat_reroll_initiative($puid);
      
      $combat=combat_read_table();
      
      $combat["shots_fired"]=0;     
   
      combat_commit($battle["pid"]);  
    }
    
    combat_report($battle["pid"],$battle["sid"]);
      
    combat_store($battle["pid"], BATTLE_DESTROY);
      
    if ($combat["shots_fired"]>0)
      combat_ticker_prepare($alliances, $users);
  }
  
  if (BATTLE_DESTROY)
    combat_ticker($alliances, $users);
  
  if (sizeof($battles)>0)
    combat_cleanup_db(BATTLE_DESTROY);
}
else
{
  if (COMBAT_VERBOSE)
    echo ("Simuliere Kampf:".COMBAT_NEWLINE);
  
  $sth=$GLOBALS["db"]->query("DELETE FROM diplomacy WHERE alliance1=-1 OR alliance1=-2") or die ($GLOBALS["db"]->error);
  
  $sth=$GLOBALS["db"]->query("INSERT INTO diplomacy (alliance1, alliance2, status) VALUES (-1, -2, 0)") or die ($GLOBALS["db"]->error);
  
  $sth=$GLOBALS["db"]->query("INSERT INTO diplomacy (alliance1, alliance2, status) VALUES (-2, -1, 0)") or die ($GLOBALS["db"]->error);
  
  combat_create_temporary();
  
  combat_insert_simulator($GLOBALS["sim_uid"]);
  
  combat_finalize_table(-1, -1);
  
  for ($i=0;$i<BATTLE_DURATION;$i++)
  {
    combat_reroll_initiative(-1);
    
    $combat=combat_read_table();
    
    $combat["shots_fired"]=0;
    
    combat_commit(-1);
  }
    
  combat_report(-1,-1);
  
  $sth=$GLOBALS["db"]->query("DELETE FROM diplomacy WHERE alliance1=-1 OR alliance1=-2") or die ($GLOBALS["db"]->error);  
}

if (COMBAT_VERBOSE)
  echo ("Kampfdauer: ".round(read_timer("combat"),4)."s".COMBAT_NEWLINE.COMBAT_NEWLINE);

?>
