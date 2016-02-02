<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN">
<html>
<head>
<title>
Spaceregents - The ULTIMATE Space Strategy
</title>
<?
/*
function show_bug_tracking()
{
  global $uid;

  $sth = mysql_query("select id, developer from bughunters where uid=".$uid);

  if (!$sth)
  {
    return 0;
  }
  else
    if (mysql_num_rows($sth) > 0)
    {
      echo("<center><a href=\"todo.php\" target=\"anzeige_frame\">Bug Report</a></center><br>");
    }
}
*/
//echo("<link rel=stylesheet type=\"text/css\" href=\"inc/srdesign.css\">\n");
echo('
<style type="text/css">
  @import "inc/srdesign.css";
</style>
');
echo('<!--[if IE]>
<link
 href="inc/srdesign_ie.css"
 rel="stylesheet"
 type="text/css"
 media="screen">
<script type="text/javascript">
onload = function() { content.focus() }
</script>
<![endif]-->');
echo("<meta http-equiv=\"expires\" content=\"0\">");

echo("<meta name=\"MSSmartTagsPreventParsing\" content=\"TRUE\">");
echo("</head>");
echo("<body>");

$sth=mysql_query("select * from ads order by rand() limit 1");

if (!$sth)
{
  show_error("Database failure!");
  return 0;
}
echo("<div id=\"menu\">");
print "<div id=\"buddy\" class=\"buddy\">\n";
include "buddy.php";
print "</div>\n";
include "menu_frame.php";
echo("</div>");

print "<div id=\"content\" class=\"content\">\n";
print "<!--[if IE]><div id=\"content2\"><![endif]-->\n";
/*
print "<table width=\"100%\"><tr><td>";
print "<table border=\"1\" width=\"100%\" height=\"100%\"><tr><td style=\"vertical-align: top\">";
print "</td></tr>";
print "<tr style=\"height: 100%\"><td>saufen&nbsp;</td></tr>";
print "<tr><td>";
print "</td></tr></table></td><td>";
*/
$ad=mysql_fetch_array($sth);

table_start("center");
//table_text(array("<a href=\"ad.php?id=".$ad["id"]."\" target=\"_blank\"><img src=\"".$ad["image"]."\"></a>"));
table_text(array("<a href=\"http://www.spaceregents.de/\" target=\"_blank\"><img src=\"http://www.spaceregents.de/banners/sr_banner.jpg\" border=\"0\" alt=\"spaceregents\" width=\"468\" height=\"60\" /></a>"));
//table_text(array("&nbsp;"));
table_end();

//show_bug_tracking();


table_start("center");
table_head_text(array("<a href=\"manual/metal_help.html\" target=\"_blank\"><img src=\"arts/metal.gif\" title=\"Metal\" alt=\"Metal\" border=\"0\"></a>",
                      "<a href=\"manual/energy_help.html\" target=\"_blank\"><img src=\"arts/energy.gif\" title=\"Energy\" alt=\"Energy\" border=\"0\"></a>",
                      "<a href=\"manual/mopgas_help.html\" target=\"_blank\"><img src=\"arts/mopgas.gif\" title=\"MopGas\" alt=\"MopGas\" border=\"0\"></a>",
                      "<a href=\"manual/erkunum_help.html\" target=\"_blank\"><img src=\"arts/erkunum.gif\" title=\"Erkunum\" alt=\"Erkunum\" border=\"0\"></a>",
                      "<a href=\"manual/gortium_help.html\" target=\"_blank\"><img src=\"arts/gortium.gif\" title=\"Gortium\" alt=\"Gortium\" border=\"0\"></a>",
                      "<a href=\"manual/susebloom_help.html\" target=\"_blank\"><img src=\"arts/susebloom.gif\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\"></a>",
                      "<a href=\"manual/money_help.html\" target=\"_blank\"><span style=\"color: yellow\">&euro;</span></a>","<a href=\"manual/colonists_help.html\" target=\"_blank\"><img src=\"arts/colonists.png\" border=\"0\"></span></a>","Date"));
print "<tr style=\"padding-left: 10; padding-right: 10\">
<td align=\"center\" class=\"text\">{metal}</td>
<td align=\"center\" class=\"text\">{energy}</td>
<td align=\"center\" class=\"text\">{mopgas}</td>
<td align=\"center\" class=\"text\">{erkunum}</td>
<td align=\"center\" class=\"text\">{gortium}</td>
<td align=\"center\" class=\"text\">{susebloom}</td>
<td align=\"center\" class=\"text\">{money}</td>
<td align=\"center\" class=\"text\">{colonists}</td>
<td align=\"center\" class=\"text\">{date}</td>
</tr>";
table_end();
?>
