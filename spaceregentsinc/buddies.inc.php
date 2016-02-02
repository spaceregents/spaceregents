<?
function get_online_buddies($uid)
{
  // Holt die aktuellen buddies sortiert nach name
  
  $sth=mysql_query("select u.id,u.name from users as u,buddies as b,online as o where b.uid=$uid and b.fuid=u.id and o.uid=b.fuid order by u.name");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
    return false;

  while ($buddy=mysql_fetch_row($sth))
  {
    $buddies[$buddy[0]]=$buddy[1];
  }
  
  return $buddies;
}

function get_offline_buddies($uid)
{
  // Holt die aktuellen buddies sortiert nach name
  
  $sth=mysql_query("select u.id,u.name from users as u,buddies as b left join online as o on o.uid=b.fuid where b.uid=$uid and b.fuid=u.id and o.uid is NULL order by u.name");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
    return false;

  while ($buddy=mysql_fetch_row($sth))
  {
    $buddies[$buddy[0]]=$buddy[1];
  }
  
  return $buddies;
}

function get_pending_message($uid,$index=0)
{
  if ($index=="")
    $sth=mysql_query("select fuid,message,time from buddy_msg where uid=$uid");
  else
    $sth=mysql_query("select fuid,message,time from buddy_msg where uid=$uid limit $index,1");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
    return 0;
  
  return mysql_fetch_row($sth);
}

function del_buddy_msg($uid,$fuid,$time)
{
  $sth=mysql_query("delete from buddy_msg where uid=$uid and fuid=$fuid and time='$time'");

  if (!$sth)
    return false; 
  else
    return true;
}

function is_buddy($uid,$fuid)
{
  $sth=mysql_query("select uid from buddies where uid=$uid and fuid=$fuid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

function buddy_msg($uid,$fuid,$msg)
{
  $sth=mysql_query("insert into buddy_msg (uid,fuid,message) values ('$uid','$fuid','$msg')");

  if (!$sth)
    return false;
  else
    return true;
}

function del_reload($uid)
{
  $sth=mysql_query("delete from reload where uid=$uid");
}

function set_reload($uid)
{
  $sth=mysql_query("replace into reload (uid) values ('$uid')");
}

function is_online($uid)
{
  $sth=mysql_query("select uid from online where uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

function buddy_invite($uid,$fuid)
{
  $sth=mysql_query("insert into buddy_invite (uid,fuid) values ('".$uid."','".$fuid."')");

  if (!$sth)
    return false;
  else
    return true;
}

function del_buddy_invite($uid,$fuid)
{
  $sth=mysql_query("delete from buddy_invite where uid=$uid and fuid=$fuid");

  if (!$sth)
    return false;
  else
    return true;
}

function is_invited($uid,$fuid)
{
  $sth=mysql_query("select uid from buddy_invite where uid=$fuid and fuid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

function get_buddy_invitations($uid)
{
  $sth=mysql_query("select fuid from buddy_invite where uid=$uid ");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return $sth;
}

function get_user_invitations($uid)
{
  $sth=mysql_query("select uid from buddy_invite where fuid=$uid ");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return $sth;
}

function add_buddy($uid,$fuid)
{
  $sth=mysql_query("insert into buddies (uid,fuid) values ('$uid','$fuid')");
}

function del_buddy($uid,$fuid)
{
  $sth=mysql_query("delete from buddies where uid=$uid and fuid=$fuid");
}
?>
