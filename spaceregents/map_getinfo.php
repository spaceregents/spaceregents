<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/ressources.inc.php";

function get_server_time()
{
  $now = getDate();

  if ($now["minutes"] < 10)
    $now["minutes"] = "0" . $now["minutes"];

  if ($now["seconds"] < 10)
    $now["seconds"] = "0" . $now["seconds"];

  echo($now["minutes"]." ".$now["seconds"]);
}


switch ($act)
{
  case "syncClock":
    get_server_time();
  break;
}
 $content=ob_get_contents();
 ob_end_clean();

print $content;
#print gzcompress($content);

?>
