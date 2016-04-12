<?php
if ($_GET["debug"]==1)
  header("Content-type:text/plain");
else
  header("Content-type: image/svg+xml");

// mop: komischer IE bug...drumherumarbeiten :S:S:S:S
/*
[12:42:22] <6,10[mop]> ob_start sends a gzip header
[12:42:28] <6,10[mop]> IE thinks it is evil then
[12:42:32] <6,10[mop]> (not sure why)
[12:42:33] <6,10[mop]> but
[12:42:38] <6,10[mop]> if one just compresses the content
[12:42:48] <6,10[mop]> and doesn't send that header
[12:42:51] <6,10[mop]> (which is evil)
[12:42:54] <6,10[mop]> it works anyway
[12:43:09] <6,10[mop]> the plugin seems to detect it somehow
*/
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/systems.inc.php";
include "../spaceregentsinc/planets.inc.php";
include "../spaceregentsinc/constellations.inc.php";
include "../spaceregentsinc/svg.inc.php";
include "../spaceregentsinc/class_map_info.inc.php";


function open_svg($tag_parameter)
{
  echo("<svg ".$tag_parameter.">\n");
}

function close_svg()
{
  echo("</svg>\n");
}

function write_defs()
{
  global $my_map_size;
  echo("<defs>\n");
  echo("    <rect id=\"status_text_rect\" x=\"".(($my_map_size["width"]-250)/2 - 75)."px\" y=\"20px\" width=\"400px\" height=\"20px\" rx=\"2px\" ry=\"2px\" class=\"mapGUI\"/>\n");
  echo("</defs>\n");
}

function write_javascript($map_info)
{
  global $uid;

  echo("<script xlink:href=\"inc/sr_class_WINDOWS.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_itemBox.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_startup.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_MASTA.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_stars.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_planets.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_fleets.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_jumpgate.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_commands.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_controls.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_common.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_genesis.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_audio.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/srgui.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/srgui_p.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/srkeyevents.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_examineFleet.js\" type=\"text/ecmascript\"></script>\n");

  echo("<script xlink:href=\"inc/sr_class_FLEET.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_SELECTED.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_CACHE.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_BUTTON.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_ITEMS.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_MINIMAP.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_FLEET_MANAGEMENT.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_PLANET.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_OTHER_CLASSES.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_class_INF_TRANSFER.js\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_tactics.php\" type=\"text/ecmascript\"></script>\n");
  echo("<script xlink:href=\"inc/sr_images.php\" type=\"text/ecmascript\"></script>\n");

  echo("<script type=\"text/ecmascript\">\n");
  echo("<![CDATA[\n");
  echo("var global_map_anims = ".($map_info->has_map_anims() ? "true" : "false").";\n");
  echo("minimap=new SR_CLASS_MINIMAP(".MINIMAP_X.",".MINIMAP_Y.",".MINIMAP_SIZE.");\n");
  echo("var masta = new SR_CLASS_MASTA(".($map_info->has_map_anims() ? "true" : "false").",".($map_info->has_map_autoupdate() ? "true" : "false").",\"100\",minimap);\n");
  echo("masta.warprange = ".$map_info->get_warprange().";");
  echo("]]>\n");
  echo("</script>\n");
}



//_____________________________________________________________________________
function write_first_svg_content()
{
  open_svg("id=\"mSvg\" onload=\"initMap(evt)\"");
  echo("<g id=\"background\">");
  echo("</g>\n");
  echo("<g id=\"sterne\">\n");
  echo("</g>\n");
  echo("<g id=\"objekte\">\n");
  echo("</g>\n");
  close_svg();
}


//_____________________________________________________________________________
function write_panel_svg_content($map_info)
{
  global $uid;
  global $my_map_size;

  open_svg("id=\"pSvg\" onload=\"initPanel(evt)\" width=\"100%\" height=\"100%\"");

  if ($my_map_size["width"] == 800 && $my_map_size["height"] == 600)
  {
    $x_transform = $my_map_size["width"] - 800 - 2; // -10 sind die ränder
    $y_transform = $my_map_size["height"] - 600; // -55 ist die statusleiste
  }
  else
  {
    //$x_transform = $my_map_size["width"] + 150; // -10 sind die ränder
    //$y_transform = $my_map_size["height"] - 600 + 17 - 75; // -55 ist die statusleiste
    $x_transform = $my_map_size["width"] - 800 - 10; // -10 sind die ränder
    $y_transform = $my_map_size["height"] - 600 + 17 - 75; // -55 ist die statusleiste
  }

  //echo("<g transform=\"translate(".$x_transform." ".$y_transform.")\">");
//  echo("<clipPath id=\"cMinimap\">\n");
  //echo("<path d=\"M751.585,196.293h-145v-145h145V196.293z\"/>\n");
//  echo("<circle cx=\"".MINIMAP_X."\" cy=\"".MINIMAP_Y."\" r=\"".MINIMAP_SIZE."\"/>\n");
//  echo("</clipPath>\n");

  //echo("<path id=\"haupt_panel\" style=\"fill:#2965ce;stroke-width:1pt;stroke:black;\" d=\"M641.27,16.25c0.29,2.41-3.69,3.89-3.69,3.89c-32,14.67-66.61,49.5-66.61,103.16c0,40.02,22.69,88.6,85.28,107.54l0.48,5.28c-12.86,8.76-21.3,23.51-21.3,40.24c0,16.67,8.38,31.37,21.15,40.14l-0.02,27.52c-7.96,0.21-14.36,6.72-14.36,14.73c0,8,6.38,14.51,14.33,14.73l0,4.04c-7.95,0.22-14.33,6.72-14.33,14.73c0,8,6.37,14.49,14.31,14.73l-0.1,132.93c11.88,10.82,20.54,26.23,23.46,44.68l27.08-0.04l77.62,0.17V16.25H641.27z\"/>\n");
//  echo("<circle id=\"minimap_kreis\" cx=\"".MINIMAP_X."\" cy=\"".MINIMAP_Y."\" r=\"".MINIMAP_R."\" style=\"fill:#000074;stroke:black;\"/>\n");
//  echo("<g clip-path=\"url(#cMinimap)\" id=\"minimap_rahmen\">\n");
//  echo("</g>\n");
//echo("</g>\n"); // Ende Transform Translate

  // Status Anzeige
  echo("<g id=\"status_panel_full\">\n");
  echo("  <g id=\"status_panel_menu\" onmousedown=\"createMenuDialog('Menu','None');\" onmouseover=\"updateStatusText('Open Menu');\" onmouseout=\"updateStatusText(' ');\">\n");
  echo("    <rect x=\"20px\" y=\"20px\" width=\"20px\" height=\"20px\" rx=\"2px\" ry=\"2px\" class=\"mapGUI\">\n");
  if ($map_info->has_map_anims())
  {
    echo("      <set attributeType=\"CSS\" attributeName=\"class\" to=\"mapGUIHover\" begin=\"status_panel_menu.mouseover\"/>\n");
    echo("      <set attributeType=\"CSS\" attributeName=\"class\" to=\"mapGUI\" begin=\"status_panel_menu.mouseout\"/>\n");
  }
  echo("    </rect>\n");
  echo("  </g>\n");
  echo("  <g id=\"status_panel_time\" onmouseover=\"updateStatusText('Next Tick');\" onmouseout=\"updateStatusText(' ');\">\n");
  echo("    <rect x=\"50px\" y=\"20px\" width=\"70px\" height=\"20px\" rx=\"2px\" ry=\"2px\" class=\"mapGUI\"/>\n");
  echo("    <text id=\"status_time\" x=\"85px\" y=\"36px\" class=\"mapGUIText\">--:--</text>\n");
  echo("  </g>\n");
  echo("  <g id=\"status_panel_text\">\n");
  echo("    <use xlink:href=\"#status_text_rect\"/>\n");
  // mop: vertical align noch nicht unterstützt :@
  echo("    <flow style=\"text-align :center\">\n");
  echo("      <flowRegion>\n");
  echo("        <region xlink:href=\"#status_text_rect\"/>\n");
  echo("      </flowRegion>\n");
  echo("      <flowDiv>\n");
  echo("        <flowPara id=\"status_text\" class=\"mapGUIText\">Welcome to Spaceregents :)</flowPara>\n");
  echo("      </flowDiv>\n");
  echo("    </flow>\n");
  echo("  </g>\n");
  echo("</g>\n");


  echo("<!-- map scrolling control -->\n");
    echo("<g style=\"fill:blue;fill-opacity:0.5;stroke:black;stroke-width:1pt;\" id=\"scroll_control\" onmouseover=\"highlight(evt, 1);sr_pause_animation();\" onmouseout=\"highlight(evt, 0);sr_resume_animation();\">\n");
    echo("<path id=\"rechts_runter\" transform=\"translate(".$x_transform." ".$y_transform.")\" d=\"M784.68,561.84v22.76h-22.76v15.9h22.76h15.9v-15.9v-22.76h-15.9z\" onmousedown=\"masta.scroll(4);\"/>\n");
    echo("<path id=\"runter_links\" transform=\"translate(0 ".$y_transform.")\" d=\"M39.25,584.6H16.49v-22.76H0.59v22.76v15.9h15.9h22.76v-15.9z\" onmousedown=\"masta.scroll(6);\"/>\n");
    echo("<path id=\"hoch_links\" d=\"M16.49,39.16V16.4h22.76V0.5H16.49H0.59v15.9v22.76h15.9z\" onmousedown=\"masta.scroll(8);\"/>\n");
    echo("<path id=\"hoch_rechts\" transform=\"translate(".$x_transform." 0)\" d=\"M761.92,16.4h22.76v22.76h15.9V16.4V0.5h-15.9h-22.76v15.9z\" onmousedown=\"masta.scroll(2);\"/>\n");
    echo("<path id=\"runter\" transform=\"translate(0 ".$y_transform.")\" d=\"M762.2,600.5H39.23v-15.91H".(762.2 + $x_transform)."v15.91z\" onmousedown=\"masta.scroll(5);\"/>\n");
    echo("<path id=\"hoch\" d=\"M762.48,16.41H39.23V0.5h".(723.25 + $x_transform)."v15.91z\" onmousedown=\"masta.scroll(1);\"/>\n");
    echo("<path id=\"rechts\" transform=\"translate(".$x_transform." 0)\" d=\"M800.59,".(561.97 + $y_transform)."h-15.9V39.16h15.9z\" onmousedown=\"masta.scroll(3);\"/>\n");
    echo("<path id=\"links\" d=\"M16.49,".(561.99 + $y_transform)."H0.59V39.19h15.9z\" onmousedown=\"masta.scroll(7);\"/>\n");
    echo("</g>\n");

  echo("<g id=\"sr_selectedBox\"/>");

  if ($map_info->has_map_anims())
    echo("<rect id=\"loadingBlackRect\" x=\"0\" y=\"0\" width=\"100%\" height=\"100%\" style=\"fill:black;\"/>\n");


  // Audio
  echo("<a:audio id=\"SR_AUDIO_BUTTON_DOWN\" xlink:href=\"sounds/button_pressed.mp3\" begin=\"12h\"/>\n");

  echo("<a:audio id=\"SR_AUDIO_SPEECH_REPORT\" begin=\"12h\"/>\n");
  echo("<a:audio id=\"SR_AUDIO_SPEECH_CONFIRM\" begin=\"12h\"/>\n");
  //echo("<!-- Modifing any values in here won't change a thing. Everything es being validated by the server //-->\n");
  echo("<nonsvg>\n");
  /* Resourcen als XML gespeichert
   * hier werden mal die resourcen wie folgt hingeschrieben:
   * <resource_name timestamp="hh mm">anzahl + 1</resource_name>
   *
   * es können noch temporär:
   *
   * <obj_to_update resource="resource" obj_id="object_id"/>stehen
   * da getURL ansynchron ist.
   */
  echo("<user_resources id=\"user_resources\"/>\n");
/*  echo("<cache>\n");
  echo("<cache_stars/>\n");
  echo("<cache_fleets/>\n");
  echo("<cache_infantry/>\n");
  echo("</cache>\n");
*/
  echo("</nonsvg>\n");
  close_svg();
}

function write_css()
{
  $SVG_Output  = "<".chr(63)."xml version=\"1.0\" encoding=\"UTF-8\"".chr(63).">\n";
  $SVG_Output .= "<".chr(63)."xml-stylesheet href=\"css/sr_map.css\" type=\"text/css\"".chr(63).">\n";
  // $SVG_Output .= "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.1//EN\"  \"http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd\">"; // 1.1
  $SVG_Output .= "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.0//EN\"    \"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd\">";
  echo($SVG_Output);
}

$map_info=new map_info($uid);
 //__________________________________ main
$my_map_size = get_mapsize($uid);

define(MINIMAP_SIZE,150);
define(MINIMAP_X,$my_map_size["width"]-200);
define(MINIMAP_Y,30);

write_css();
open_svg("id=\"fSvg\" onload=\"initFather(evt);\" onkeydown=\"key_functions(evt);\" xmlns=\"http://www.w3.org/2000/svg\" externalResourcesRequired=\"true\" xmlns:a=\"http://www.adobe.com/svg10-extensions\" a:timeline=\"independent\" onmousedown=\"evt.preventDefault()\"  onmouseup=\"evt.preventDefault()\" zoomAndPan=\"disable\"");
echo("<rect id=\"hintergrundfarbe\" x=\"0\" y=\"0\" width=\"100%\" height=\"100%\" fill=\"#001233\"/>\n");
write_defs();
write_javascript($map_info);
echo("<g id=\"allesDrin\">\n");
write_first_svg_content();
write_panel_svg_content($map_info);
echo("</g>\n");
close_svg();

// mop: siehe oben
$content=ob_get_contents();
ob_end_clean();

#if ($_GET["debug"]==1)
  print $content;
#else
#  print gzcompress($content);
?>
