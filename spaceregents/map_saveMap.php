<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return false;
  
function update_automatic_update()
{
  global $uid;
  global $value;
  
  $sth = mysql_query("update options set map_autoupdate = '".$_GET["value"]."' where uid=$uid");
  
  if (!sth)
    echo("There was an error");
  else
    echo("Options: Automatic Update changed.");
}
  
function update_screen_size()
{
  global $uid;
  global $value;
  
  $sth = mysql_query("update options set map_size = '$value' where uid=$uid");
  
  if (!sth)
    echo("There was an error");
  else
    echo("Video: Window size changed.");
}
  
switch ($act)
{
  case "automatic_update":
    update_automatic_update();
  break;
  case "screenSize":
    update_screen_size();
  break;
}

$content=ob_get_contents();
ob_end_clean();

print gzcompress($content);
?>
