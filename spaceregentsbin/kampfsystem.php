<?php
define("BATTLE_DESTROY",true);
define("BATTLEREPORT_SHOW",true);
define("SIMULATION_MODE",false);
define("COMBAT_MAXIMUM_VERBOSITY", false);
define("COMBAT_VERBOSE", true);
define("COMBAT_MAX_FRACTION",250);
define("COMBAT_DIGIN_ORBIT",0);
define("COMBAT_DIGIN_PLANET",70);
define("COMBAT_DIGIN_BONUS_ORBIT",0);
define("COMBAT_DIGIN_BONUS_PLANET",20);
define("COMBAT_BOOST",2);
define("BATTLE_DURATION",1);
define("COMBAT_NEWLINE","\n");

set_time_limit(3200);
include "../spaceregentsinc/battle/krieg.inc.php";
?>
