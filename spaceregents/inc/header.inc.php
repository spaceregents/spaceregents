<html>
<head>
<title>
Spaceregents
</title>
<?

include "inc/func.inc.php";
include "inc/design.inc.php";
connect();

if (!cookies_ok())
{
  echo("<html>");
  echo("<head>");
  echo("<body scroll=\"auto\">\n");
  echo("You seem to have a Problem with your cookies! Please click <a href=\"login.php\" target=\"_blank\">here</A> to login again");
  echo("</head>");
  echo("</html>");
  $not_ok=true;
  return 0;
}
else
{ 
  echo("<link rel=stylesheet type=\"text/css\" href=\"inc/srdesign.css\">\n");
  echo("<meta http-equiv=\"expires\" content=\"0\">");
  echo("<meta name=\MSSmartTagsPreventParsing\ content=\TRUE\>");
  echo("</head>");
  echo("<body link=\"#b0aed9\" vlink=\"#b0aed9\" alink=\"#320ff9\" text=\"#cdc9f5\">");  
  $not_ok=false;
}
$sth=mysql_query("select u.id,s.name from users as u, skins as s where u.name='$sr_name' and u.skin=s.id");

$uid_db=mysql_fetch_array($sth);
$uid=$uid_db["id"];

$skin=$uid_db["name"];

$sth=mysql_query("select * from ressources where uid=$uid");

if (!$sth)
{
  show_error("Datenbankfehler!");
  return 0;
}

$date=date("YmdHis");

$date=substr($date,6,2).".".substr($date,4,2).".".substr($date,0,4)." ".substr($date,8,2).":".substr($date,10,2);

$data=mysql_fetch_array($sth);

$sth=mysql_query("select * from ads order by rand() limit 1");

if (!$sth)
{
  show_error("Database failure!");
  return 0;
}

$ad=mysql_fetch_array($sth);

table_start("center");
table_text(array("<a href=\"ad.php?id=".$ad["id"]."\" target=\"_blank\"><img src=\"".$ad["image"]."\"></a>"));
table_text(array("&nbsp;"));
table_end();

table_start("center");
table_head_text(array("<a href=\"manual/metal_help.html\" target=\"_blank\"><img src=\"arts/metal.gif\" title=\"Metal\" alt=\"Metal\" border=\"0\"></a>",
                       "<a href=\"manual/energy_help.html\" target=\"_blank\"><img src=\"arts/energy.gif\" title=\"Energy\" alt=\"Energy\" border=\"0\"></a>",
					   "<a href=\"manual/mopgas_help.html\" target=\"_blank\"><img src=\"arts/mopgas.gif\" title=\"MopGas\" alt=\"MopGas\" border=\"0\"></a>",
					   "<a href=\"manual/erkunum_help.html\" target=\"_blank\"><img src=\"arts/erkunum.gif\" title=\"Erkunum\" alt=\"Erkunum\" border=\"0\"></a>",
					   "<a href=\"manual/gortium_help.html\" target=\"_blank\"><img src=\"arts/gortium.gif\" title=\"Gortium\" alt=\"Gortium\" border=\"0\"></a>",
					   "<a href=\"manual/susebloom_help.html\" target=\"_blank\"><img src=\"arts/susebloom.gif\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\"></a>","&nbsp;","Date"));
table_text(array($data["metal"],$data["energy"],$data["mopgas"],$data["erkunum"],$data["gortium"],$data["susebloom"],"&nbsp;",$date),"center","","","head");
table_end();
?>
