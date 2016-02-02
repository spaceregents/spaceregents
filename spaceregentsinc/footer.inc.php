<?php
// mop: den inhalt des jeweiligen scriptes holen
$content=ob_get_contents();
ob_end_clean();

// Mop: den header in nen buffer "ausgeben"
ob_start();
include "../spaceregentsinc/header.inc.php";
$header=ob_get_contents();
ob_end_clean();

$sth=mysql_query("select * from ressources where uid=$uid");

if (!$sth)
{
  show_error("Datenbankfehler!");
  return 0;
}

$data=mysql_fetch_assoc($sth);

foreach ($data as $res => $amount)
  $trans["{".$res."}"]=$amount;

$header=strtr($header,$trans);

// mop: srzeit feststellen
$sth=mysql_query("select week from timeinfo");

if (!$sth || mysql_num_rows($sth)!=1)
  print "ERR::GETTING SRTIME";

list($week)=mysql_fetch_row($sth);

$date=date("H:i");

$header=str_replace("{date}",$date."<br/>Week: ".$week,$header);

ob_start();
?>
</div>
<!--[if IE]></div><![endif]-->
</body>
</html>
<?php
$footer=ob_get_contents();
ob_end_clean();

ob_start("ob_gzhandler");
print $header;
print $content;
print $footer;
?>