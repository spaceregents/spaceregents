<?
function get_constellation_name($cid)
{
  $sth=mysql_query("select name from constellations where id=$cid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  $name=mysql_fetch_row($sth);

  return $name[0];
}
?>
