<?php
include "../../spaceregentsinc/tactics.inc.php";
ob_start();

echo("var __tactics=new Array();\n");

$constants=get_defined_constants();

foreach ($constants as $constant => $value)
{
  if (preg_match("/^TAC_(.*)$/",$constant,$match))
  {
    echo("__tactics[\"".($match[1])."\"]=".$value.";\n");
  }
}
$content=ob_get_contents();
ob_end_clean();

print $content;
#print gzcompress($content);
?>
