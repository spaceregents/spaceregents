<?
Header("Content-type: text/xml");
echo("<?xml version=\"1.0\"?>\n");
?>
<html xmlns="http://www.w3.org/1999/xhtml">
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
  echo("<style type=\"text/css\">\n
		  th {color:#daddde; font-size:16;};
		  td {color:#f3f2ff; font-size:14;};
          h5 {color:#303167; font-size:10;};
          h3 {color:#f4f2ff; font-size:18;};
          h2 {color:#990000; font-size:20;};
		  h1 {color:#f4f2ff; font-size:20;};
		  table {BORDER-RIGHT: thin; BORDER-TOP: thin; BORDER-LEFT: thin; BORDER-BOTTOM: thin;};
		  body {scrollbar-face-color: #4a4787;scrollbar-shadow-color: #2F1F40;scrollbar-highlight-color: #FFFFFF;
                scrollbar-3dlight-color: #6F4FD0;scrollbar-darkshadow-color: #000000;scrollbar-track-color: #302859;
                scrollbar-arrow-color: #8E8FB1;
               }
          input {background-color:#4a4787;border-color:#FFFFFF;color:#FFFFFF; -moz-border-radius:10px;}
		  tr.text {background-color:#302859;}
		  tr.head {background-color:#4a4787;}
		  td.text {background-color:#302859;}
		  td.head {background-color:#4a4787;}
   		  td.smallhead {background-color:#4a4787;font-size:10pt;}
		  td.none{}
		  td.leader {background-color:white;color:black;}
   		  td.dev    {background-color:yellow;}
   		  td.military {background-color:red;}
   		  td.foreign {background-color:orange;}
	 </style>\n");
  echo("<meta http-equiv=\"expires\" content=\"0\" />");
  echo("\n<script> <![CDATA".chr(ord("["))."\n\n");
echo("var transform_list;\n");

echo("var svg_element;\n");
echo("function init()\n");
echo("{\n");
echo("planet = document.getElementById('planets');\n");
echo("if (planet)\n");
echo("planet.addEventListener(\"mousedown\", go_planet, false);\n");
echo("jumps = document.getElementById('jump');\n");
echo("if (jumps)\n");
echo("jumps.addEventListener(\"mousedown\",jump, false);\n");
echo("fleets = document.getElementById('fleets');\n");
echo("if (fleets)\n");
echo("fleets.addEventListener(\"mousedown\",fleetinfo, false);\n");
echo("fleets2 = document.getElementById('systemfleets');\n");
echo("if (fleets2)\n");
echo("fleets2.addEventListener(\"mousedown\",fleetinfo, false);\n");
$sth=mysql_query("select count(x) from planets where sid=$id");

if (!$sth)
{
  show_error("Database failuer!");
  return 0;
}

$count=mysql_fetch_row($sth);

if ($count[0]>0)
{
  $sth=mysql_query("select x,id from planets where sid=$id");

  if (!$sth)
  {
    echo("Database failuer!");
    return 0;
  }

}
echo("}\n");
echo("function go_planet(evt)\n");
echo("{\n");
echo("if (evt.target.id != '')\n");
echo("{\n");
echo("open(\"planet.php?pid=\"+evt.target.id,\"_blank\",\"width=500,height=500,screenX=320,screenY=0,menubar=yes,location=yes,status=yes,toolbar=yes,directories=yes\");\n");
echo("}\n");
echo("}\n");
echo("function jump(evt2)\n");
echo("{\n");
echo("if (evt2.target.id != '')\n");
echo("{\n");
echo("open(\"jump.php?sid=\"+evt2.target.id,\"_blank\",\"width=500,height=500,screenX=320,screenY=0,menubar=yes,location=yes,status=yes,toolbar=yes,directories=yes\");\n");
echo("}\n");
echo("}\n");
echo("function fleetinfo(evt3)\n");
echo("{\n");
echo("if (evt3.target.id != '')\n");
echo("{\n");
echo("open(\"fleetinfo.php?fid=\"+evt3.target.id,\"_blank\",\"width=500,height=500,screenX=320,screenY=0,menubar=yes,location=yes,status=yes,toolbar=yes,directories=yes\");\n");
echo("}\n");
echo("}\n");
echo("]]>\n");
echo("</script>\n");

  echo("</head>");
  echo("<body bgcolor=\"black\" link=\"#b0aed9\" vlink=\"#b0aed9\" alink=\"#320ff9\" text=\"#cdc9f5\" onload=\"init();\">");  
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

$data=mysql_fetch_array($sth);
table_start("center");
table_head_text(array("<a href=\"manual/metal_help.html\" target=\"_blank\"><img src=\"arts/metal.gif\" title=\"Metal\" alt=\"Metal\" border=\"0\" /></a>",
                       "<a href=\"manual/energy_help.html\" target=\"_blank\"><img src=\"arts/energy.gif\" title=\"Energy\" alt=\"Energy\" border=\"0\" /></a>",
					   "<a href=\"manual/mopgas_help.html\" target=\"_blank\"><img src=\"arts/mopgas.gif\" title=\"MopGas\" alt=\"MopGas\" border=\"0\" /></a>",
					   "<a href=\"manual/erkunum_help.html\" target=\"_blank\"><img src=\"arts/erkunum.gif\" title=\"Erkunum\" alt=\"Erkunum\" border=\"0\" /></a>",
					   "<a href=\"manual/gortium_help.html\" target=\"_blank\"><img src=\"arts/gortium.gif\" title=\"Gortium\" alt=\"Gortium\" border=\"0\" /></a>",
					   "<a href=\"manual/susebloom_help.html\" target=\"_blank\"><img src=\"arts/susebloom.gif\" title=\"Susebloom\" alt=\"Susebloom\" border=\"0\" /></a>"));
table_text(array($data["metal"],$data["energy"],$data["mopgas"],$data["erkunum"],$data["gortium"],$data["susebloom"]));
table_end();
?>
