<?php
define("BATTLE_DESTROY",false);
define("BATTLEREPORT_SHOW",true);
define("SIMULATION_MODE",true);
define("BATTLE_DURATION",intval($argv[2]));
define("COMBAT_NEWLINE","<br>");

if (intval($argv[3])==2)
{
	define("COMBAT_MAXIMUM_VERBOSITY", true);
	define("COMBAT_VERBOSE", true);
}
elseif (intval($argv[3])==1)
{
	define("COMBAT_MAXIMUM_VERBOSITY", false);
	define("COMBAT_VERBOSE", true);
}
else
{
	define("COMBAT_MAXIMUM_VERBOSITY", false);
	define("COMBAT_VERBOSE", false);
}

define("COMBAT_MAX_FRACTION",intval($argv[4]));
define("COMBAT_DIGIN_ORBIT",intval($argv[5]));
define("COMBAT_DIGIN_PLANET",intval($argv[6]));
define("COMBAT_DIGIN_BONUS_ORBIT",intval($argv[7]));
define("COMBAT_DIGIN_BONUS_PLANET",intval($argv[8]));
define("COMBAT_BOOST",intval($argv[9]));

$GLOBALS["sim_uid"]=$argv[1];

//print_r($argv);

if (!$GLOBALS["sim_uid"])
  die("Keine uid; Parameter: ".$argc);

include "../spaceregentsinc/battle/krieg.inc.php";
?>
