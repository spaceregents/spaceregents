<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return false;

include "../spaceregentsinc/research.inc.php";
include "../spaceregentsinc/systems.inc.php";

function overview()
{
  global $uid;
  
  $sth=mysql_query("select b.prod_id,b.count,b.side,p.name,p.typ,b.initiative,b.agility,b.hull,b.weaponpower,b.shield,b.ecm,b.target1,b.sensor,b.weaponskill,b.special,b.armor,b.num_attacks,s.initiative,s.agility,s.hull,s.weaponpower,s.shield,s.ecm,s.target1,s.sensor,s.weaponskill,s.special,s.armor,s.num_attacks from battle_".$uid." b, production p, shipvalues s where b.prod_id=p.prod_id and b.prod_id=s.prod_id order by side");

  echo("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">"); 
  table_start("center","700");
  table_head_text(array("Battlesimulator"),20);

  if (!$sth || mysql_num_rows($sth)==0)
  {
    table_text(array("No ships"),"","","","text"); 
  }
  else
  {
    table_head_text(array("Side","Name","Type","count","initiative","agility","hull","power","shield","ecm","target1","sensors","skill","special","armor","num_attacks","mail"));
    while (list($prod_id,$count,$side,$name,$typ,$cur_ini,$cur_agi,$cur_hull,$cur_pow,$cur_shield,$cur_ecm,$cur_tar1,$cur_sen,$cur_skill,$cur_spec,$cur_arm,$cur_num,$ini,$agi,$hull,$pow,$shield,$ecm,$tar1,$sen,$skill,$spec,$arm,$num)=mysql_fetch_row($sth))
    {
      table_text(array(
  $side,
  $name,
  $typ,
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][count]\" size=\"4\" value=\"".$count."\">",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][initiative]\" size=\"3\" value=\"".$cur_ini."\"> (".$ini.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][agility]\" size=\"3\" value=\"".$cur_agi."\"> (".$agi.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][hull]\" size=\"3\" value=\"".$cur_hull."\"> (".$hull.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][weaponpower]\" size=\"3\" value=\"".$cur_pow."\"> (".$pow.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][shield]\" size=\"3\" value=\"".$cur_shield."\"> (".$shield.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][ecm]\" size=\"3\" value=\"".$cur_ecm."\"> (".$ecm.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][target1]\" size=\"3\" value=\"".$cur_tar1."\"> (".$tar1.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][sensor]\" size=\"3\" value=\"".$cur_sen."\"> (".$sen.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][weaponskill]\" size=\"3\" value=\"".$cur_skill."\"> (".$skill.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][special]\" size=\"3\" value=\"".$cur_spec."\"> (".$spec.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][armor]\" size=\"3\" value=\"".$cur_arm."\"> (".$arm.")",
  "<input type=\"text\" name=\"battle[".$side."][".$prod_id."][num_attacks]\" size=\"3\" value=\"".$cur_num."\"> (".$num.")",
  "<a href=\"".$_SERVER["PHP_SELF"]."?act=suggest&side=".$side."&prod_id=".$prod_id."\">suggest change</a>"
      ),"","","","text");
    }
  }
  table_form_submit("Change","proc_change_values");
  table_end();
  echo("</form>"); 

  $sth=mysql_query("select prod_id,name from production where typ in ('L','M','H','I') 
order by name");

  if (!$sth)
  {
    show_error("database failersdfiosd");
    return false;
  }

  echo("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">"); 
  table_start("center","500");
  table_head_text(array("Add ships"),"2");

  while (list($prod_id,$name)=mysql_fetch_row($sth))
  {
    $select[$name]=$prod_id;
  }
  table_form_select("Ship","prod_id",$select,"2","text","text");
  table_form_select("Side","side",array(1=>1,2=>2),"2","text","text");
  table_form_text("Count","count");
  table_form_submit("Add ships","proc_add_ships");
  table_end();
  echo("</form>");

  echo("<br>");
  
	echo("<form action=\"".$_SERVER["PHP_SELF"]."\" method=\"POST\">");
	table_start("center", "500");
	table_head_text(array("Config"),"2");
	
	table_form_select("Combat rounds","rounds",array(1=>1,2=>2,3=>3,4=>4,5=>5,10=>10),"1","text","text");
	table_form_select("Fraction limit","fraction",array(100=>100,250=>250,500=>500,1000=>1000,2000=>2000,"no limit"=>0),"250","text","text");
	table_form_select("Orbital Dig-In factor (Side 1)","digino",array("no dig-in"=>0,20=>20,40=>40,60=>60,65=>65,70=>70,75=>75,80=>80,85=>85,90=>90,95=>95,99=>99),"0","text","text");
	table_form_select("Orbital Dig-In bonus (Side 1)","diginob",array("no bonus"=>0,5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,55=>55),"0","text","text");
	table_form_select("Planetary Dig-In factor (Side 1)","diginp",array("no dig-in"=>0,20=>20,40=>40,60=>60,65=>65,70=>70,75=>75,80=>80,85=>85,90=>90,95=>95,99=>99),"70","text","text");
	table_form_select("Planetary Dig-In bonus (Side 1)","diginpb",array("no bonus"=>0,5=>5,10=>10,15=>15,20=>20,25=>25,30=>30,35=>35,40=>40,45=>45,50=>50,55=>55),"20","text","text");
	table_form_select("Overall combat boost","boost",array("no boost"=>1,2=>2,3=>3,5=>5),"1","text","text");
	table_form_select("Verbosity","verbosity",array("Results only"=>0,"Overview"=>1,"Full details"=>2),"1","text","text");
	table_form_submit("Execute battle","execute_battle");
	table_end();
	echo("</form>");
	
  //print "<a href=\"".$_SERVER["PHP_SELF"]."?act=execute_battle\">Execute battle</a>";
}

function check_simulation_table()
{
  global $uid;

  $sth=mysql_query("show tables like 'battle_".$uid."'");

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)==0)
  {
    $sth=mysql_query("create table battle_".$uid." (prod_id int not null,side int not null,count int not null,initiative int not null,agility int not null,hull int not null,weaponpower int not null,shield int not null,ecm int not null,target1 varchar(255) not null,sensor int not null,weaponskill int not null,special varchar(255) not null,armor int not null,num_attacks int not null,primary key(prod_id,side))");

    if (!$sth)
      return false;
  }
  return true;
}

function proc_add_ships($prod_id,$side,$count)
{
  global $uid;

  if (!check_simulation_table())
  {
    show_error("ERR::TABLE");
    return false;
  }

  $count=(int) $count;

  if ($count<1)
  {
    show_error("more than 0 ships required");
    return false;
  }

  $sth=mysql_query("insert into battle_".$uid." select '".$prod_id."','".$side."','".(int)$count."',initiative,agility,hull,weaponpower,shield,ecm,target1,sensor,weaponskill,special,armor,num_attacks from shipvalues s where prod_id=".$prod_id);

  if (!$sth)
  {
    $sth=mysql_query("update battle_".$uid." set count=count+".$count." where prod_id=".$prod_id." and side=".$side);

    if (!$sth)
      show_error("ERR::ADD");
  }
  else
    show_message("ADDED");
}

function proc_change_values($battle)
{
  global $uid;
  
  foreach ($battle as $side => $ships)
  {
    foreach ($ships as $prod_id => $values)
    {
      $sth=mysql_query("replace into battle_".$uid." set prod_id='".$prod_id."',side='".$side."',count='".$values["count"]."',initiative='".$values["initiative"]."',agility='".$values["agility"]."',hull='".$values["hull"]."',weaponpower='".$values["weaponpower"]."',shield='".$values["shield"]."',ecm='".$values["ecm"]."',target1='".$values["target1"]."',sensor='".$values["sensor"]."',weaponskill='".$values["weaponskill"]."',special='".$values["special"]."',armor='".$values["armor"]."',num_attacks='".$values["num_attacks"]."'");

      if (!$sth)
  show_error("ERROR");
    }
  }
  $sth=mysql_query("delete from battle_".$uid." where count<=0");
}

function suggest($prod_id,$side)
{
  global $uid;

  $sth=mysql_query("select if(s.special=b.special,0,b.special) as special,b.initiative-s.initiative as initiative,b.agility-s.agility as agility,b.hull-s.hull as hull,b.weaponpower-s.weaponpower as weaponpower,b.shield-s.shield as shield,b.ecm-s.ecm as ecm,b.sensor-s.sensor as sensor,b.weaponskill-s.weaponskill as weaponskill,b.armor-s.armor as armor,b.num_attacks-s.num_attacks as num_attacks from battle_".$uid." b, production p, shipvalues s where b.prod_id=".$prod_id." and b.side=".$side." and b.prod_id=p.prod_id and b.prod_id=s.prod_id");

  if (!$sth)
  {
    show_error("ERR::GET VALUES");
    return false;
  }

  $new_values=mysql_fetch_assoc($sth);

  $changes="";

  foreach ($new_values as $ident => $change)
  {
    if ($change!=0)
    {
      $changes.=$ident." => ".$change."\n";
    }
  }

  if ($changes!="")
  {

    $sth=mysql_query("select name from production where prod_id=".$prod_id);

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    list($name)=mysql_fetch_row($sth);

    mail("mop@spaceregents.de","Request for Change von ".get_name_by_uid($uid),"Changes für ".$name." (".$prod_id.")\n\n".$changes);
    mail("runelord@spaceregents.de","Request for Change von ".get_name_by_uid($uid),"Changes für ".$name." (".$prod_id.")\n\n".$changes);
    mail("julius@spaceregents.de","Request for Change von ".get_name_by_uid($uid),"Changes für ".$name." (".$prod_id.")\n\n".$changes);
  }
}

function execute_battle($rounds, $fraction, $digino, $diginp, $diginob, $diginpb, $boost, $verbosity)
{
  global $uid;
  
  set_time_limit(3200);
  
  ob_start();
    system("php ../spaceregentsbin/kampfsimulator.php $uid $rounds $verbosity $fraction".
 " $digino $diginp $diginob $diginpb $boost");

    $result=ob_get_contents();
  ob_end_clean();

  echo(nl2br($result));
}

function is_admin()
{
  global $uid;
  
  $sth = mysql_query("select admin from users where id=".$uid);
  
  if (!$sth || mysql_num_rows($sth) == 0)
    return false;
    
  list($admin) = mysql_fetch_row($sth);
  
  if ($admin > 0)
    return true;
  else
    return false;
}

if (is_admin())
{
  switch($act)
  {
    case "execute_battle":
      execute_battle($_POST["rounds"], $_POST["fraction"], $_POST["digino"], $_POST["diginp"], $_POST["diginob"], $_POST["diginpb"], $_POST["boost"], $_POST["verbosity"]);
      overview();
      break;
    case "suggest":
      suggest($_GET["prod_id"],$_GET["side"]);
      overview();
      break;
    case "proc_change_values":
      proc_change_values($_POST["battle"]);
      overview();
      break;
    case "proc_add_ships":
      proc_add_ships($_POST["prod_id"],$_POST["side"],$_POST["count"]);
      overview();
      break;
    default:
    overview();
  }
}
include "../spaceregentsinc/footer.inc.php";
?>
