<script type="text/javascript">

 var map;
 function openMap()
 {
<?
 global $uid;
 $sth = mysql_query("select m.width, m.height from map_sizes m, options o where o.map_size = m.id and o.uid=".$uid);

 if ((!$sth) ||(!mysql_num_rows($sth)))
  return 0;

 $my_map_size = mysql_fetch_array($sth);

 if ($my_map_size["width"] == 800)
 echo("map = window.open('map.php?ie_ignores_mimetypes=.svg','srmap','width=".($my_map_size["width"]).",height=".($my_map_size["height"]).",screenX=0,screenY=0,dependant=yes,menubar=no,hotkeys=no,resizeable=yes');\n");
 else
 echo("map = window.open('map.php?ie_ignores_mimetypes=.svg','srmap','width=".($my_map_size["width"]-8).",height=".($my_map_size["height"]-56).",screenX=0,screenY=0,dependant=yes,menubar=no,hotkeys=no');\n");
  
?>
 map.window.moveTo(0,0);
 }
</script>

<map name="menu_button_map">
 <area shape=circle coords="61,17,15"   href="overview.php" alt="HQ" title="HQ">
 <area shape=circle coords="103,25,15" href="communication.php" alt="Communication" title="Communication">
 <area shape=circle coords="143,41,15" href="ranking.php" alt="Ranking" title="Ranking">
 <area shape=circle coords="185,65,15" href="production.php" alt="Planets, Production" title="Planets, Production">
 <area shape=circle coords="215,93,15" href="fleet.php" alt="Fleet Management" title="Fleet Management">

<?

$sth=mysql_query("select moz from users where name='$sr_name'");

if (!$sth)
    echo("<area shape=circle coords=\"242,124,15\" href=\"menu_frame.php\" onClick=\"openMap();\" alt=\"Map\" title=\"Map\" type=\"image/svg-xml\">");
else
{
  $moz=mysql_fetch_row($sth);

  if ($moz[0]==1)
    echo("<area shape=circle coords=\"242,124,15\" href=\"map_moz.php\" target=\"_blank\" alt=\"Map\" title=\"Map\">");
  else
    echo("<area shape=circle coords=\"242,124,15\" href=\"javascript:openMap();\" onMouseOver=\"javascript: status = 'Spaceregents Map'\" alt=\"Map\" title=\"Map\" type=\"image/svg+xml\">");
}
?>
 <area shape=circle coords="262,162,15" href="research.php" alt="Research & Developement" Title="Research & Developement">
 <area shape=circle coords="276,197,15" href="covertops.php" alt="Covert Ops" title="Covert Ops">
 <area shape=circle coords="284,233,15" href="trade.php" alt="Trade" title="Trade">
 <area shape=circle coords="20,236,20" href="preferences.php" alt="Preferences" title="Preferences">
 <area shape=circle coords="84,269,20" href="logout.php" alt="Logout" title="Logout">
</MAP>
<div id="menuimg">
<img class="menuimg" src="skins/metal_blue_menu800.jpg" id="menu" name="menu" border="0" width="300" height="292" useMap=#menu_button_map />
</div>

