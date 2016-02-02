<?
/***********************
*
*  function get_alliance_color($aid)
*  function is_leader($uid,$aid);
*  function get_alliances($aid=0)
*  function get_diplomatic_status_text($status);
*  function get_diplomatic_status($aid1,$aid2);
*  function get_alliance_name($aid);
*  function is_diplomatic_status($status);
*  function alliance_exists($aid);
*  function change_diplomatic_status($aid,$faid,$new_status);
*  function request_for_diplomatic_change($aid,$faid,$new_status);
*  function get_pending_diplomacy_change($aid,$faid);
*  function drop_pending_diplomatic_request($aid1,$aid2);
*  function get_milminister($aid);
*  function get_color_by_alliancestatus
*  function get_leader($aid)
*  function delete_alliance($aid)
*  function get_alliance_members($aid)
*  function get_aid_by_uid($uid)
*  function alliance_not_full($aid)
***********************/

DEFINE(MAX_ALLIANCE_MEMBERS,7);

/***********************
*
*  function get_alliance_color($aid);
*
***********************/
function get_alliance_color($aid)
{
  if ($aid == 0)
    return false;
  else
  {
    $sth = mysql_query("select color from alliance where id = $aid");

    if (!$sth || (mysql_num_rows($sth) == 0))
    return false;

    $color = mysql_fetch_row($sth);

    return $color[0];
  }
}

/***********************
*
*  function is_leader($uid,$aid);
*
***********************/
function is_leader($uid,$aid)
{
  $sth=mysql_query("select leader from alliance where leader=$uid and id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

/***********************
*
*  function get_alliances($aid=0);
*  bei $aid != 0 wird diese allianz ausgelassen (um z.B. alle allianzen ausser der eigenen zu bekommen)
*
***********************/
function get_alliances($aid=0,$order=false)
{
  if (!$order)
    $sth=mysql_query("select id from alliance where id!=$aid");
  else
    $sth=mysql_query("select id from alliance where id!=$aid order by name");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return array();

  while (list($alliance)=mysql_fetch_row($sth))
  {
    $alliances[]=$alliance;
  }

  return $alliances;
}


/***********************
*
*  function get_diplomatic_status_text($status);
*
***********************/
function get_diplomatic_status_text($status)
{
  switch($status)
  {
    case "0":
      $text="Enemy";
      break;
    case "1":
      $text="Neutral";
      break;
    case "2":
      $text="Friend";
      break;
  }
  return $text;
}

/***********************
*
*  function get_diplomatic_status($aid1,$aid2);
*
***********************/
function get_diplomatic_status($aid1,$aid2)
{
  $sth=mysql_query("select status from diplomacy where alliance1=$aid1 and alliance2=$aid2");

  if (!$sth)
    return false;
    
  if (mysql_num_rows($sth)==0)
  {
    $status=1;
  }
  else
  {
    list($status)=mysql_fetch_row($sth);
  }
  return $status;
}

/***********************
*
*  function get_alliance_name($aid);
*
***********************/
function get_alliance_name($aid)
{
  $sth=mysql_query("select name from alliance where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($name)=mysql_fetch_row($sth);

  return $name;
}

/***********************
*
*  function is_diplomatic_status($status);
*
***********************/
function is_diplomatic_status($status)
{
  switch ($status)
  {
    case 0:
    case 1:
    case 2:
      return true;
    default:
      return false;
  }
}

/***********************
*
*  function alliance_exists($aid);
*
***********************/
function alliance_exists($aid)
{
  $sth=mysql_query("select id from alliance where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

/***********************
*
*  function change_diplomatic_status($aid,$faid,$new_status);
*
***********************/
function change_diplomatic_status($aid,$faid,$new_status)
{
  $sth=mysql_query("replace into diplomacy (alliance1,alliance2,status) values ('$aid','$faid','$new_status')");
  
  if (!$sth)
    return false;

  $sth=mysql_query("replace into diplomacy (alliance1,alliance2,status) values ('$faid','$aid','$new_status')");
  
  if (!$sth)
    return false;

  return true;
}

/***********************
*
*  function request_for_diplomatic_change($aid,$faid,$new_status);
*
***********************/
function request_for_diplomatic_change($aid,$faid,$status)
{
  $sth=mysql_query("replace into diplomatic_change_request (aid1,aid2,status) values ('$aid','$faid','$status')");

  if (!$sth)
    return false;

  return true;  
}

/***********************
*
*  function get_pending_diplomacy_change($aid,$faid);
*
***********************/
function get_pending_diplomacy_change($aid,$faid)
{
  $sth=mysql_query("select status from diplomatic_change_request where aid1=$aid and aid2=$faid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($status)=mysql_fetch_row($sth);

  return $status;
}

/***********************
*
*  function drop_pending_diplomatic_request($aid1,$aid2);
*
***********************/
function drop_pending_diplomatic_request($aid1,$aid2)
{
  $sth=mysql_query("delete from diplomatic_change_request where aid1=$aid1 and aid2=$aid2");

  if (!$sth)
    return false;
  else
    return true;
}


/***********************
*
*  function get_milminister($aid);
*
***********************/
function get_milminister($aid)
{
  $sth = mysql_query("select milminister from alliance where id='$aid'");
  
  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
    
  $milminister = mysql_fetch_row($sth);
  
  return $milminister[0];
}

/***********************
*
*  function get_color_by_alliancestatus($aid1, $aid2)
*
***********************/
function get_color_by_alliancestatus($aid1, $aid2)
{
  $color = "black";
  
  if ($aid1 == $aid2)
    $color = "yellow";
  elseif(is_enemy($aid1, $aid2))
    $color = "red";
  elseif(is_friendly($aid1, $aid2))
    $color = "orange";
  else
    $color = "blue";
    
  return $color;
}

function get_leader($aid)
{
  $sth=mysql_query("select leader from alliance where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($leader)=mysql_fetch_row($sth);

  return $leader;
}

function delete_alliance($aid)
{
  // allianz entfernen
  $sth = mysql_query("delete from alliance where id=".$aid);

  if (!$sth) {
    show_error("ERR::DELETE ALLIANCE");
    return false;
  }

  $sth = mysql_query("delete from taxes where aid=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE TAXES");
    return false;
  }

  $sth = mysql_query("delete from invitations where aid=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE INVITATIONS");
    return false;
  }

  $sth = mysql_query("delete from votes where aid=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE VOTES");
    return false;
  }

  $sth = mysql_query("delete from vote where aid=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE VOTE");
    return false;
  }

  $sth = mysql_query("delete from diplomacy where alliance1=".$aid." or alliance2=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE DIPLOMACY");
    return false;
  }

  $sth = mysql_query("delete from diplomatic_change_request where aid1=".$aid." or aid2=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE DIPLOMACY CHANGE REQUEST");
    return false;
  }

  $sth = mysql_query("delete from battlereports_alliance where aid=".$aid);
  if (!$sth) {
    show_error("ERR::DELETE ALLIANCE BATTLEREPORTS");
    return false;
  }

  $sth=mysql_query("delete from forums where aid=".$aid);

  if (!$sth)
  {
    show_error("ERR::DELETE FORUM");
    return false;
  }

  return true;
}

/*********************************
*
* function get_alliance_members($aid)
*
**********************************/
function get_alliance_members($aid)
{
  if ($aid==0)
    return false;

  $sth=mysql_query("select name,id from users where alliance=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  while (list($name,$uid)=mysql_fetch_row($sth))
  {
    $members[$uid]=$name;
  }

  return $members;
}

/*********************************
*
* function is_minister($uid)
*
**********************************/
function is_minister($uid)
{
 $alliance = get_alliance($uid);

 if ($alliance)
 {
   $sth = mysql_query("select leader, milminister, devminister, forminister from alliance where id=".$alliance);
   
   if ((!$sth) || (!mysql_num_rows($sth)))
    return false;
   
   $ministers = mysql_fetch_array($sth);
   
   switch ($uid)
   {
     case $ministers["leader"]:
      return "leader";
     break;
     case $ministers["milminister"]:
      return "milminister";
     break;
     case $ministers["devminister"]:
      return "devminister";
     break;
     case $ministers["forminister"]:
      return "forminister";
     break;
     default:
      return false;
     break;
   }
 }
 else
  return false;
}

function remove_from_alliance($uid)
{
  $sth=mysql_query("update users set alliance=0, last_login = last_login where id=".$uid);

  if (!$sth)
    return false;
    
    
  $sth = mysql_query("update fleet_info set milminister=0 where uid=".$uid);
  
  if (!$sth) {
    show_message("ERR::RESET FLEET MILMINISTER");
    return false;
  }

  $sth=mysql_query("insert into alliance_lock set uid=".$uid);

  if (!$sth)
    return false;
      
  return true;
}

function has_alliance_lock($uid)
{
  $sth=mysql_query("select uid from alliance_lock where uid=".$uid);

  if (!$sth || mysql_num_rows($sth)==0)
    return false;
  else
    return true;
}

function get_pay_off($uid)
{
  // mop: den grössten exponenten herausfinden => also 293 =>  (10^3) (sind ja nur hunderter - und dann +1)
  $sth=mysql_query("select floor(log10(max(id)))+1 from planets");

  if (!$sth)
  {
    echo("ERR::GET EXPONENT");
    return false;
  }

  list($exponent)=mysql_fetch_row($sth);
  
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
    $segments[]=sprintf($segment,$f_alias,$ressource,$p_alias,$ressource,$raw_factor,$p_alias,$ressource);

  $calc_2=implode("+",$segments);
  
  $sth=mysql_query("select p.id from final_prod_factors f,planets p,users u where f.pid=p.id and p.uid=u.id and u.id=".$uid." and
3<(select count(*) from planets p2,final_prod_factors f2
where p2.uid=p.uid and p2.id=f2.pid and
round((".$calc_1.")+(p2.id/".pow(10,$exponent)."),".$exponent.")
>=round((".$calc_2.")+(p.id/".pow(10,$exponent)."),".$exponent."))");

  if (!$sth)
    return false;
  
  if (mysql_num_rows($sth)==0)
    return array("metal"=>0,"energy"=>0,"mopgas"=>0,"erkunum"=>0,"gortium"=>0,"susebloom"=>0);
  
  $pids=array();

  while (list($pid)=mysql_fetch_row($sth))
    $pids[]=$pid;
  
  $raw_factor=8.5;
  // mop: berechnung der erwirtschafteten ressourcen
  $segment="sum(round(%s.%s*(%s.%s/100)*%s*(log10(%s.population/1000)+3))*24*7) as %s";
  
  $f_alias="f";
  $p_alias="p";
  $segments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $ressource)
    $segments[]=sprintf($segment,$f_alias,$ressource,$p_alias,$ressource,$raw_factor,$p_alias,$ressource);
  
  $calc_3=implode(",",$segments);
  
  $sth=mysql_query("select ".$calc_3." from planets p, final_prod_factors f where p.id=f.pid and p.id in (".implode(",",$pids).")");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  $weekly_income=mysql_fetch_assoc($sth);
  
  return $weekly_income;
}

function get_aid_by_uid ($uid)
{
  if ($uid)
  {
    $sth=mysql_query("select alliance from users where id=$uid");

    if (!$sth)
      return false;

    if (mysql_num_rows($sth)==0)
      return false;

    list($aid)=mysql_fetch_row($sth);

    return $aid;
  }
  else
    return false;
}


function alliance_not_full($aid)
// gibt true zurück wenn die allianz noch nicht das maximum an mitgliedern erreicht hat, ansonsten false
{
  $sth = mysql_query("SELECT count(alliance) FROM users WHERE alliance='".$aid."'");
  
  if (!$sth || mysql_num_rows($sth)==0)
    return false;
    
 list($num_members) = mysql_fetch_row($sth);
 
 if ($num_members < MAX_ALLIANCE_MEMBERS)
  return true;
 else
  return false;
}

?>
