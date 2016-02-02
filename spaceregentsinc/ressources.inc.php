<?php
function get_money($uid)
{
  $sth=mysql_query("select money from ressources where uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;
  else
  {
    list($money)=mysql_fetch_row($sth);
    return $money;
  }
}

function get_ressourcen_kurzbezeichner($ressource, $type=0)
{
  $ressource = strtolower($ressource);

  if (!$type)
  {
    switch ($ressource)
    {
      case "metal":
        $return_value = "M";
      break;
      case "energy":
        $return_value = "E";
      break;
      case "mopgas":
        $return_value = "O";
      break;
      case "erkunum":
        $return_value = "R";
      break;
      case "gortium":
        $return_value = "G";
      break;
      case "susebloom":
        $return_value = "S";
      break;
    }
  }
  else
  {
    switch ($ressource)
    {
      case "m":
        $return_value = "metal";
      break;
      case "e":
        $return_value = "energy";
      break;
      case "o":
        $return_value = "mopgas";
      break;
      case "r":
        $return_value = "erkunum";
      break;
      case "g":
        $return_value = "gortium";
      break;
      case "s":
        $return_value = "susebloom";
      break;
    }
  }

  return $return_value;
}

function get_users_resources($uid)
{
  $sth = mysql_query("select * from ressources where uid=".$uid);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;

  $user_resources = mysql_fetch_array($sth);

  return $user_resources;
}


function subtract_users_resources($uid, $r_name, $r_count)
{
  $sth = mysql_query("update ressources set ".$r_name."=".$r_name."-".$r_count." where uid=".$uid);

  if (!$sth)
    return false;
}
?>
