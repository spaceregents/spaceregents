<?php
include "../spaceregentsinc/init.inc.php";

function str_removescript($text)
{
  $text=preg_replace('/<\s*script.*?<\s*\/\s*script\s*>/ims','',$text);
  $text=preg_replace('/<\s*script\s*[^>]*>/ims','',$text);
  
  $text=preg_replace('/on(Load|Click|DblClick|DragStart|KeyDown|KeyPress|'.
    'KeyUp|MouseDown|MouseMove|MouseOut|MouseOver|SelectStart|Blur|Focus|'.
    'Scroll|Select|Unload|Change)\s*=\s*(\'|").*?\\2/smi','',$text);
  $text=preg_replace('/(\'|")Javascript:.*?\\1/smi','',$text);
  return preg_replace('/[^\'"]\s*Javascript:\s*[^\s]+/smi','',$text);
}

$GLOBALS["depth"]=0;
$GLOBALS["beauty_data"]="";

function print_depth()
{
  for ($i=0;$i<$GLOBALS["depth"];$i++)
    $GLOBALS["beauty_data"].="  ";
}

function startElement($parser, $name, $attrs) 
 {
    global $depth;
    
    print_depth();
    $GLOBALS["beauty_data"].="<".$name;
    
    foreach ($attrs as $attr => $value)
      $GLOBALS["beauty_data"].=" ".$attr."=\"".$value."\"";
    
    $GLOBALS["beauty_data"].=">\n";
    $GLOBALS["depth"]++;
 }
 
 function endElement($parser, $name) 
 {
    $GLOBALS["depth"]--;
    print_depth();
    $GLOBALS["beauty_data"].="</".$name.">\n";
 }
 
$xml_parser = xml_parser_create();
xml_set_element_handler($xml_parser, "startElement", "endElement");
xml_parser_set_option($xml_parser,XML_OPTION_CASE_FOLDING,0);

$data=str_removescript(stripslashes(urldecode($HTTP_RAW_POST_DATA)));

xml_parse($xml_parser, $data,true);

$SVG_Output  = "<".chr(63)."xml version=\"1.0\" standalone=\"no\"".chr(63).">\n";
$SVG_Output .= "<".chr(63)."xml-stylesheet href=\"css/sr_map.css\" type=\"text/css\"".chr(63).">\n";
$SVG_Output .= "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\" \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">\n";

$GLOBALS["beauty_data"]=$SVG_Output.$GLOBALS["beauty_data"];

$fp=fopen("snapshot_".$uid.".svg","w+");
fwrite($fp,$GLOBALS["beauty_data"]);
fclose($fp);
echo("alles ok");
?>
