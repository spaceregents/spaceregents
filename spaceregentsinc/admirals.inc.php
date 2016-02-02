<?
function get_admiral_owner($aid)
{
  $sth = mysql_query("select uid from admirals where id=".$aid);

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;
    
  list($admiral_owner) = mysql_fetch_row($sth);
  
  return $admiral_owner;
}


function get_admiral_pic($aid)
{
  $sth=mysql_query("select pic from admirals where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;
  
  list($admiral_pic) = mysql_fetch_row($sth);
  
  return $admiral_pic;
}

function get_admiral_name($aid)
{
  $sth=mysql_query("select name from admirals where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;
  else
  {
    $admiral=mysql_fetch_row($sth);
    
    return $admiral[0];
  }
}

function get_admiral_level($aid)
{
  $sth=mysql_query("select value from admirals where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;

  $admiral=mysql_fetch_row($sth);

  if ($admiral[0]<1000)
    $level=0;
  else
    $level=floor((log10($admiral[0]/1000)/log10(2))+1);

  return $level;
}

function set_admiral($aid,$fid=0)
{
  $sth=mysql_query("update admirals set fid=$fid where id=$aid");

  if (!$sth)
    return false;
  else
    return true;

}

function is_admiral_owner($aid,$uid)
{
  $sth=mysql_query("select uid from admirals where id=$aid and uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
    return true;
}

function get_admiral_values($aid)
{
  // die funktion returnt alle werte inklsuive der boni von inventory
  // todo: inventory
  
  $sth=mysql_query("select agility,initiative,sensor,weaponskill from admirals where id=$aid");

  if ((!$sth) || mysql_num_rows($sth)==0)
    return 0;

  $values=mysql_fetch_array($sth);

  return $values;
}

function get_plain_admiral_values($aid)
{
  // die funktion returnt alle werte ohne boni
  
  $sth=mysql_query("select agility,initiative,sensor,weaponskill from admirals where id=$aid");

  if ((!$sth) || mysql_num_rows($sth)==0)
    return 0;

  $values=mysql_fetch_array($sth);

  return $values;
}

function get_fid_by_admiral($aid)
{
  $sth=mysql_query("select fid from admirals where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($fid)=mysql_fetch_row($sth);

  return $fid;
}

function get_admiral_xp($aid)
{
  $sth=mysql_query("select value from admirals where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($value)=mysql_fetch_row($sth);

  return $value;
}

function get_admiral_used_xp($aid)
{
  $sth=mysql_query("select used_xp from admirals where id=$aid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($value)=mysql_fetch_row($sth);

  return $value;
}


function calculate_admiral_level($xp)
{
  if ($xp<1000)
    $level=0;
  else
    $level=floor((log10($xp/1000)/log10(2))+1);

  return $level;
}

function admiral_has_pending_upgrade($id)
{
  $sth=mysql_query("select used_xp from admirals where id=$id");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return 0;
  
  list($used_xp)=mysql_fetch_row($sth);
  
  if (calculate_admiral_level($used_xp)<get_admiral_level($id))
    return true;
  else
    return false;
}

function upgrade_admiral_value($id,$value)
{
  // vorher immer checken ob value auch in ordnung is

  $sth=mysql_query("update admirals set $value=$value+1 where id=$id and used_upgrades<3");

  if (!$sth)
    return 0;

  $sth=mysql_query("select used_upgrades,used_xp from admirals where id=$id");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  list($upgrades,$used_xp)=mysql_fetch_row($sth);

  if ($upgrades>=2)
    $sth=mysql_query("update admirals set used_xp=pow(2,".(calculate_admiral_level($used_xp)).")*1000,used_upgrades=0 where id=$id");
  else
    $sth=mysql_query("update admirals set used_upgrades=used_upgrades+1 where id=$id");

  if (!$sth)
    return false;

  return true;
}
?>
