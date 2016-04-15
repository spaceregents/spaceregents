<?php
include "../../spaceregentsconf/config.inc.php";
include "../../spaceregentsinc/gp/dbwrap.inc";
include "../../spaceregentsinc/func.inc.php";

ob_start();
connect();

$sth=mysql_query("select pic, p. prod_id, p.name, IF(s.special != '', s.special, NULL) as shipval_special, IF(p.special != '', p.special, NULL) as prod_special from production p left join shipvalues s using(prod_id)");

if (!$sth)
  return false;

echo("var __prodInfo=new Array;\n");

echo("__prodInfo[0]=new SR_CLASS_PROD_INFO(\"p_unknown.png\",null,null,null);\n");
while (list($pic,$prod_id,$name, $sv_special, $pr_special)=mysql_fetch_row($sth))
{
  echo("__prodInfo[".$prod_id."]=new SR_CLASS_PROD_INFO(\"".$pic."\",\"".$name."\",\"".$sv_special."\",\"".$pr_special."\");\n");
}
$content=ob_get_contents();
ob_end_clean();

print $content;
#print gzcompress($content);
?>
