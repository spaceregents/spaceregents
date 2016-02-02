<?
/********************
*
* function get_name_by_uid($uid)
*
* function get_uid_by_name($name)
*
* function get_homeworld($uid)
*
* function get_alliance($uid, $type = 0)    // $type = 1 => name
*
* function get_allied_ids($uid);
*
* function send_ticker_from_to($uid,$fuid,$type,$message)
*
* function is_enemy($alliance1, $alliance2)
*
* function is_allied($uid, $uid2)
*
* function is_friendly($alliance, $alliance2)
*
* function get_uids_relation($uid1, $uid2)
* function get_random_uid()
*
* function get_empire_by_uid($uid);
*
* function get_mapsize($uid);
*
* function get_enemy_aids($uid);
*
********************/


function get_name_by_uid($uid)
{
  $sth=mysql_query("select name from users where id=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $uname=mysql_fetch_row($sth);

  return $uname[0];
}

function get_uid_by_name($name)
{
  $sth=mysql_query("select id from users where name='".addslashes($name)."'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $uid=mysql_fetch_row($sth);

  return $uid[0];
}

function get_homeworld($uid)
{
  $sth=mysql_query("select homeworld from users where id=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $homeworld=mysql_fetch_row($sth);

  return $homeworld[0];
}

function get_alliance($uid, $type = 0)
{
  if ($type == 0)
    $sth  = mysql_query("select alliance from users where id = $uid");
  else
    $sth  = mysql_query("select a.name from alliance as a, users as u where u.id = $uid and u.alliance = a.id");

  if (!$sth || (mysql_num_rows($sth) == 0))
    return false;

  $alliance = mysql_fetch_row($sth);

  return $alliance[0];
}


/*******************
*
* function get_allied_ids($uid)
*
*******************/
function get_allied_ids($uid)
{
  $its_alliance = get_alliance($uid);

  if ($its_alliance)
  {
    $sth = mysql_query("select id from users where alliance = '$its_alliance' and (id != $uid)");

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return false;

    while($allied_ids = mysql_fetch_array($sth))
    {
      $allied_array[] = $allied_ids["id"];
    }
    return $allied_array;
  }
  else
    return false;
}

/*******************
*
* function send_ticker_from_to($uid,$fuid,$type,$message)
*
*******************/
function send_ticker_from_to($uid,$fuid,$type,$message)
{
  if ($uid)
  {
    $name=get_name_by_uid($uid);
    $sth=mysql_query("insert into ticker (uid,type,text,time) values ('".$fuid."','".$type."','".$name.": ".$message."','".date("YmdHis")."')");
  }
  else
    $sth=mysql_query("insert into ticker (uid,type,text,time) values ('".$fuid."','".$type."','".$message."','".date("YmdHis")."')");

  if (!$sth)
    return 0;

}

/*******************
*
* function is_enemy($alliance1, $alliance2)
*
*******************/
function is_enemy($alliance1, $alliance2)
{
  $sth = mysql_query("select status from diplomacy where alliance1 = $alliance1 and alliance2 = $alliance2 and status=0");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}


/*******************
*
* function is_allied($uid, $uid2)
*
*******************/
function is_allied($uid, $uid2)
{
  static $val;

  if ($val[$uid][$uid2]===NULL)
  {
    $alliance1=get_alliance($uid);
    if ($alliance1==0)
    {
      $val[$uid][$uid2]=false;
    }
    else
    {
      if ($alliance1==(get_alliance($uid2)))
        $val[$uid][$uid2]=true;
      else
        $val[$uid][$uid2]=false;
    }
  }
  return $val[$uid][$uid2];
}


/*******************
*
* function is_friendly($alliance1, $alliance2)
*
*******************/
function is_friendly($alliance1, $alliance2)
{
  $sth = mysql_query("select status from diplomacy where alliance1 = $alliance1 and alliance2 = $alliance2 and status=2");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

/*******************
*
* function get_uids_relation($uid1, $uid2, type)
*
* liefert:
*   same (uid1 = uid2)
*   enemy
*   allie
*   friend oder
*   neutral
*
*  type != 0 liefert die css class (colorOwn, colorAllied, colorNeutral, colorFriend, colorEnemy)
*
*******************/
function get_uids_relation($uid1, $uid2, $type = 0)
{
  if ($uid1 == $uid2)
    ($type == 0) ? ($relation = "same") : ($relation = "colorOwn");
  elseif (is_allied($uid1, $uid2))
    $type == 0 ? $relation = "allie" : $relation = "colorAllied";
  else
  {
    $alliance1 = get_alliance($uid1);
    $alliance2 = get_alliance($uid2);

    if ($alliance1 && $alliance2)
    {
      if (is_friendly($alliance1, $alliance2))
        $type == 0 ? $relation = "friend" : $relation = "colorFriend";
      elseif (is_enemy($alliance1, $alliance2))
        $type == 0 ? $relation = "enemy" : $relation = "colorEnemy";
      else
        $type == 0 ? $relation = "neutral" : $relation = "colorNeutral";
    }
    else
      $type == 0 ? $relation = "neutral" : $relation = "colorNeutral";
  }

  return $relation;
}

function get_random_uid()
{
  $sth=mysql_query("select id from users order by rand() limit 1");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
  {
    list($uid)=mysql_fetch_row($sth);
    return $uid;
  }
}

function get_empire_by_uid($uid)
{
  $sth = mysql_query("select imperium from users where id='$uid'");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
  {
    list($empire)=mysql_fetch_row($sth);
    return $empire;
  }

}

function get_mapsize($uid)
{
  $sth = mysql_query("select m.width, m.height from map_sizes m, options o where o.map_size = m.id and o.uid=".$uid);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $map_size = mysql_fetch_array($sth);

  return $map_size;
}

/*******************
*
* function get_enemy_aids($uid)
*
*******************/
function get_enemy_aids($uid)
{
  $its_alliance = get_alliance($uid);

  if ($its_alliance)
  {
    $sth = mysql_query("SELECT alliance2 FROM diplomacy WHERE alliance1=
$its_alliance and status=0") or die(mysql_error());

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return false;

    while($enemy_ids = mysql_fetch_array($sth))
    {
      $enemy_array[] = $enemy_ids["alliance2"];
    }
    return $enemy_array;
  }
  else
    return false;
}
?>