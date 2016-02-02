<?php

include "../spaceregentsconf/config.inc.php";

require_once(SMARTY_DIR."Smarty.class.php");
include $__base_inc_dir."gp/dbwrap.inc";
include $__base_inc_dir."func.inc.php";
include $__base_inc_dir."fleet.inc.php";
include $__base_inc_dir."systems.inc.php";
include $__base_inc_dir."planets.inc.php";
include $__base_inc_dir."users.inc.php";
include $__base_inc_dir."admirals.inc.php";
include $__base_inc_dir."alliances.inc.php";
include $__base_inc_dir."battle/exceptions.inc.php";

include $__base_inc_dir."battle/class_battle.inc.php";
include $__base_inc_dir."battle/class_battlefield.inc.php";
include $__base_inc_dir."battle/class_battleparticipant.inc.php";
include $__base_inc_dir."battle/class_battlefleet.inc.php";
include $__base_inc_dir."battle/class_battleplanet.inc.php";
include $__base_inc_dir."battle/class_battleunit.inc.php";
include $__base_inc_dir."battle/class_battleship.inc.php";
include $__base_inc_dir."battle/class_battletransporter.inc.php";
include $__base_inc_dir."battle/class_battlebuilding.inc.php";
include $__base_inc_dir."battle/class_battleinfantery.inc.php";
include $__base_inc_dir."battle/class_battlereporter.inc.php";
include $__base_inc_dir."battle/class_battleunitcontainer.inc.php";

include $__base_inc_dir."battle/class_battlefleetsimulator.inc.php";
include $__base_inc_dir."battle/class_battleunitsimulator.inc.php";

include $__base_inc_dir."missiontypes.inc.php";
include $__base_inc_dir."tactics.inc.php";

mysql_connect($mysql_host,$mysql_user,$mysql_pw);
mysql_select_db($mysql_db);

try
{
  $battle=new battle;
}
catch (Exception $e)
{
  print $e->getMessage()."\n";
}

?>
