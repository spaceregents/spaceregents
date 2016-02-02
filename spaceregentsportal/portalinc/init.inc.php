<?php
include "../../spaceregentsconf/config.inc.php";
include "../../spaceregentsinc/gp/dbwrap.inc";
// mop: DB initialisierung
$db=new dbwrap;
if (!$db->connect($mysql_host,$mysql_user,$mysql_pw,$__portal_db))
  die("No db");
include "session_handling.inc.php";
$GLOBALS["ses"]->page_birth();
?>
