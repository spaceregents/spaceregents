<?php
include "../portalinc/init.inc.php";
include "../portalinc/class_portal.inc.php";
include "../portalinc/class_structure_reader.inc.php";
include "../portalinc/class_page.inc.php";
include "../pages/class_base_page.inc.php";
require_once(SMARTY_DIR."Smarty.class.php");
$portal=new portal($db,$__portal_structure,$_GET["page"]);
include "../portalinc/final.inc.php";
?>
