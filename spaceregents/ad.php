<?

include "inc/config.inc.php";

mysql_connect($mysql_host,$mysql_user,$mysql_pw);
mysql_select_db($mysql_db);

$sth=mysql_query("update ads set hits=hits+1 where id=$id");

$sth=mysql_query("select * from ads where id=$id");

if (!$sth)
  Header("Location: http://www.spaceregents.de/");

if (mysql_num_rows($sth)==0)
  Header("Location: http://www.spaceregents.de/");

$ad=mysql_fetch_array($sth);

Header("Location: ".$ad["link"]);
?>
