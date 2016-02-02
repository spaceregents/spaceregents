<?
include "inc/func.inc.php";
include "inc/config.inc.php";

connect();

if (!cookies_ok())
{
  return 0;
}
else
{
  $sth=mysql_query("select id from users where name='$sr_name'");
  $uid_db=mysql_fetch_array($sth);
  $uid=$uid_db["id"];

  if (isset($id))
    {
      $sth=mysql_query("delete from ticker where uid=$uid and tid=$id");
    }

  header("Location: ticker.html?argh=".time());
}
?>



