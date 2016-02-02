<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/class_map_info.inc.php";

DEFINE ("MINIMAP_FLEET_RADIUS",40);
DEFINE ("MINIMAP_FLEET_BLINK",2);
DEFINE ("MINIMAP_FLEET_DUR", MINIMAP_FLEET_BLINK * 5);

// | "l"  = loading status
// | "s"  = shape
// | "sB" = shape Button
// | "c"  = clipPath
// | "gR" = radialGradient
// | "gL" = linearGradient
// | "p"  = ?
// | "m"  = marker
// | "i"  = image
//header("Content-Length: 1000");
//header("Content-Type: application/octet-stream");

//**************
//
//    map_definitions()
//
//**************
function map_definitions($map_info)
{
 //______________ Planeten Markierer

  echo("<g id=\"sPlanetMarker\" transform=\"translate(-15 -15)\" class=\"displayMarker\">");
  echo("<g transform=\"translate(15 15)\">");
  echo("<g id=\"outerCircle\">");
  echo("<g transform=\"translate(-15 -15)\">");
  echo("<path d=\"M7.51,19.18l-6,2.18c1.52,3.48,4.31,6.27,7.79,7.79l2.18-6c-1.72-0.85-3.12-2.25-3.97-3.97z M9.04,28.08c-1.36-0.67-2.63-1.57-3.76-2.7c-1.13-1.13-2.02-2.4-2.69-3.76h6.45v6.46z\"/>");
  echo("<path d=\"M23.16,19.18c-0.85,1.72-2.25,3.12-3.97,3.97l2.18,6c3.48-1.52,6.27-4.31,7.79-7.79l-6-2.18z M25.39,25.39c-1.13,1.13-2.4,2.02-3.76,2.69v-6.45h6.45c-0.67,1.36-1.57,2.63-2.69,3.76z\"/>");
  echo("<path d=\"M7.51,11.48c0.85-1.72,2.25-3.12,3.97-3.97l-2.18-6C5.82,3.03,3.03,5.82,1.51,9.3l6,2.18z M5.28,5.28c1.13-1.13,2.4-2.03,3.76-2.69l0,6.45l-6.45,0c0.67-1.36,1.56-2.63,2.69-3.76z\"/>");
  echo("<path d=\"M23.16,11.48l6-2.18c-1.52-3.48-4.31-6.27-7.79-7.79l-2.18,6c1.72,0.85,3.12,2.25,3.97,3.97z M25.39,5.28c1.13,1.13,2.02,2.4,2.69,3.76h-6.45V2.58c1.36,0.67,2.63,1.57,3.76,2.7z\"/>");
  echo("</g>");
  if ($map_info->has_map_anims())
    echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"360;0\" begin=\"0s\" dur=\"10s\" repeatCount=\"indefinite\"/>");
  echo("</g>");
  echo("</g>");
  echo("</g>");


  //______________ weißer Stern gradient
  echo("<radialGradient id=\"gRWhitestar\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"0%\" stop-color=\"#ffffff\"/>");
  echo("<stop offset=\"25%\" stop-color=\"#DDDDDD\" stop-opacity=\"0.8\"/>");
  echo("<stop offset=\"50%\" stop-color=\"#BBBBBB\" stop-opacity=\"0.4\"/>");
  echo("<stop offset=\"75%\" stop-color=\"#999999\" stop-opacity=\"0.2\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#888888\" stop-opacity=\"0\"/>");
  echo("</radialGradient>");

  //______________ roter Stern gradient
  echo("<radialGradient id=\"gRRedstar\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"0%\" stop-color=\"#ff9999\"/>");
  echo("<stop offset=\"25%\" stop-color=\"#FF6666\" stop-opacity=\"0.8\"/>");
  echo("<stop offset=\"50%\" stop-color=\"#DD0000\" stop-opacity=\"0.4\"/>");
  echo("<stop offset=\"75%\" stop-color=\"#BB0000\" stop-opacity=\"0.2\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#990000\" stop-opacity=\"0\"/>");
  echo("</radialGradient>");

  //______________ blauer Stern gradient
  echo("<radialGradient id=\"gRBluestar\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"0%\" stop-color=\"#BBBBFF\"/>");
  echo("<stop offset=\"25%\" stop-color=\"#9999FF\" stop-opacity=\"0.8\"/>");
  echo("<stop offset=\"50%\" stop-color=\"#6666DD\" stop-opacity=\"0.4\"/>");
  echo("<stop offset=\"75%\" stop-color=\"#3333BB\" stop-opacity=\"0.2\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#666666\" stop-opacity=\"0\"/>");
  echo("</radialGradient>");

  //______________ gelber Stern gradient
  echo("<radialGradient id=\"gRYellowstar\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"0%\" stop-color=\"#FFFF99\"/>");
  echo("<stop offset=\"25%\" stop-color=\"#FFFF66\" stop-opacity=\"0.8\"/>");
  echo("<stop offset=\"50%\" stop-color=\"#DDDD00\" stop-opacity=\"0.4\"/>");
  echo("<stop offset=\"75%\" stop-color=\"#BBBB00\" stop-opacity=\"0.2\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#999900\" stop-opacity=\"0\"/>");
  echo("</radialGradient>");


  //______________ grauer Stern gradient
  echo("<radialGradient id=\"gRGraystar\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"0%\" stop-color=\"#999999\"/>");
  echo("<stop offset=\"25%\" stop-color=\"#666666\" stop-opacity=\"0.8\"/>");
  echo("<stop offset=\"50%\" stop-color=\"#444444\" stop-opacity=\"0.4\"/>");
  echo("<stop offset=\"75%\" stop-color=\"#333333\" stop-opacity=\"0.2\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#222222\" stop-opacity=\"0\"/>");
  echo("</radialGradient>");

  //______________ rot-grün vertikal linear gradient
  echo("<linearGradient x1=\"50%\" y1=\"0%\" x2=\"50%\" y2=\"100%\" id=\"gLRedGreen\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"0%\" stop-color=\"lime\"/>");
  echo("<stop offset=\"100%\" stop-color=\"red\"/>");
  echo("</linearGradient>");

  //jumpmode...asv6 is gay...der kann irgendwie nix...
  echo("<radialGradient id=\"jumpMode\" cx=\"50%\" cy=\"50%\" r=\"10%\" gradientUnits=\"objectBoundingBox\" spreadMethod=\"reflect\">
  <stop stop-color=\"#de0027\" offset=\"0\"/>
  <stop stop-color=\"#5f5fd5\" offset=\"1\"/>
  </radialGradient>");


  echo("<radialGradient id=\"gROwn\" cx=\"50%\" cy=\"50%\" gradientUnits=\"objectBoundingBox\">
        <stop stop-color=\"#FFFFFF\" offset=\"0.1\"/>
        <stop stop-color=\"lime\" offset=\"1\" stop-opacity=\"0.2\"/>
        </radialGradient>");


  echo("<radialGradient id=\"gRAllied\" cx=\"50%\" cy=\"50%\" gradientUnits=\"objectBoundingBox\">
        <stop stop-color=\"#FFFFFF\" offset=\"0.1\"/>
        <stop stop-color=\"yellow\" offset=\"1\" stop-opacity=\"0.2\"/>
        </radialGradient>");

  echo("<radialGradient id=\"gRFriend\" cx=\"50%\" cy=\"50%\" gradientUnits=\"objectBoundingBox\">
        <stop stop-color=\"#FFFFFF\" offset=\"0.1\"/>
        <stop stop-color=\"orange\" offset=\"1\" stop-opacity=\"0.2\"/>
        </radialGradient>");

  echo("<radialGradient id=\"gREnemy\" cx=\"50%\" cy=\"50%\" gradientUnits=\"objectBoundingBox\">
        <stop stop-color=\"#FFFFFF\" offset=\"0.1\"/>
        <stop stop-color=\"red\" offset=\"1\" stop-opacity=\"0.2\"/>
        </radialGradient>");

  echo("<radialGradient id=\"gRNeutral\" cx=\"50%\" cy=\"50%\" gradientUnits=\"objectBoundingBox\">
        <stop stop-color=\"#FFFFFF\" offset=\"0.1\"/>
        <stop stop-color=\"blue\" offset=\"1\" stop-opacity=\"0.2\"/>
        </radialGradient>");

  //______________ Stern circles
  echo("<circle id=\"pWStar\" cx=\"-3\" cy=\"-3\" r=\"8\" fill=\"url(#gRWhitestar)\"/>");
  echo("<circle id=\"pRStar\" cx=\"-5\" cy=\"-5\" r=\"12\" fill=\"url(#gRRedstar)\"/>");
  echo("<circle id=\"pBStar\" cx=\"-3\" cy=\"-3\" r=\"8\" fill=\"url(#gRBluestar)\"/>");
  echo("<circle id=\"pYStar\" cx=\"-5\" cy=\"-5\" r=\"12\" fill=\"url(#gRYellowstar)\"/>");
  echo("<circle id=\"pGStar\" cx=\"-4\" cy=\"-4\" r=\"10\" fill=\"url(#gRGraystar)\"/>");

  //______________ Flotten
  echo("<circle id=\"sFleetStar\" cx=\"4\" cy=\"4\" r=\"4\" style=\"stroke:#000000;stroke-width:0.5pt;\"/>");
  echo("<rect id=\"sFleetStarCount\" x=\"0\" y=\"0\" width=\"3\" height=\"3\" style=\"stroke:#000000;stroke-width:0.5pt;\"/>");

  //______________ Allianzen Schild
  echo("<path id=\"sAllianceShield\" style=\"stroke:#000000;stroke-width:0.5pt;\" d=\"M14.79,0.25h-7.3H0.25C0.26,1.77,0.5,16.64,7.49,16.72v0c0.01,0,0.02,0,0.03,0s0.02,0,0.03,0v0c6.99-0.09,7.23-14.96,7.24-16.47z\"/>");

  //______________ Orbital Refueling Station Symbol
  echo("<g id=\"sStarSpecialSymbol_F\" style=\"stroke:#FFFFFF;stroke-width:0.1pt;\">");
  echo("<path style=\"fill:#FFFFFF;\" d=\"M19.81,18.26c0,0.98-0.79,1.77-1.77,1.77H1.81c-0.98,0-1.77-0.79-1.77-1.77V1.81c0-0.98,0.79-1.77,1.77-1.77h16.23c0.98,0,1.77,0.79,1.77,1.77v16.45z\"/>");
  echo("<path d=\"M17.46,0.75H2.39c-0.91,0-1.64,0.73-1.64,1.64v15.27c0,0.91,0.74,1.64,1.64,1.64h15.07c0.91,0,1.64-0.74,1.64-1.64V2.4c0-0.91-0.74-1.64-1.64-1.64z\"/>");
  echo("<path style=\"fill:#FFFFFF;\" d=\"M12.89,16.29c0.06-0.17,0.09-0.35,0.09-0.54V9.29c0.06,0.01,0.18,0.05,0.24,0.21c0.08,0.21,0.51,5.1,0.51,5.1s1.37,0.84,1.97,0.84c0.6,0,1.08-0.37,1.12-0.89c0.04-0.52-1.06-2.51-1.06-2.51l-0.08-6.23c0,0-2.31-1.31-2.71-1.64
        c-0.03-0.88-0.75-1.58-1.64-1.58H8.78c-0.91,0-1.64,0.73-1.64,1.63v11.52c0,0.19,0.03,0.37,0.09,0.54H3.94v1.19H15.9v-1.19h-3.02z M11.89,7.16H8.05v-3.1h3.83v3.1z M14.01,6.67c0.75,0.62-0.23-0.44,1.14,2.8l0.02,2.36c0.62,2.23,0.92,1.44,0.9,2.43
        c0,0.1-0.14,0.56-0.37,0.56c-0.23,0-1.51-0.45-1.53-0.69c-0.02-0.23-0.55-5.51-0.55-5.51s-0.44-0.36-0.65-0.42v-1.8c0.31,0.02,0.83,0.1,1.03,0.26z\"/>");
  echo("</g>");

  //______________ Jumpgate Symbol
  echo("<g id=\"sStarSpecialSymbol_S\" style=\"stroke:none;\">");
  echo("<path style=\"fill:#FFFFFF;\" d=\"M20.34,18.49c0,0.8-0.65,1.44-1.44,1.44H1.5c-0.8,0-1.44-0.65-1.44-1.44V1.5c0-0.8,0.65-1.44,1.44-1.44H18.9c0.8,0,1.44,0.65,1.44,1.44v16.99z\"/>");
  echo("<path d=\"M19.31,17.4c0,0.8-0.65,1.44-1.44,1.44H2.53c-0.8,0-1.44-0.64-1.44-1.44V2.6c0-0.8,0.65-1.44,1.44-1.44h15.34c0.8,0,1.44,0.65,1.44,1.44v14.8z\"/>");
  echo("<g style=\"fill:#FFFFFF;\">");
  echo("<path d=\"M6.64,9.53h2.89l-0.06,7.82H3.88l2.77-7.82z\"/>");
  echo("<path d=\"M13.77,9.53h-2.89l0.06,7.82h5.59l-2.77-7.82z\"/>");
  echo("<path d=\"M7.3,7.38h2.35l0.18-4.69L9.04,2.64L7.3,7.38z\"/>");
  echo("<path d=\"M13.08,7.38h-2.35l-0.18-4.69l0.79-0.04l1.73,4.73z\"/>");
  echo("<path d=\"M17.73,8.01H2.67v0.61h1.58V9.5H5.8V8.62h8.86v0.84h1.48V8.62h1.58V8.01z\"/>");
  echo("</g>");
  echo("</g>");


  //______________ Tradingstation Symbol
  echo("<g id=\"sStarSpecialSymbol_U\" style=\"stroke:none;\">");
  echo("<path style=\"fill:#FFFFFF;\" d=\"M20.34,18.49c0,0.8-0.65,1.44-1.44,1.44H1.5c-0.8,0-1.44-0.65-1.44-1.44V1.5c0-0.8,0.65-1.44,1.44-1.44H18.9c0.8,0,1.44,0.65,1.44,1.44v16.99z\"/>");
  echo("<path d=\"M19.31,17.4c0,0.8-0.65,1.44-1.44,1.44H2.53c-0.8,0-1.44-0.64-1.44-1.44V2.6c0-0.8,0.65-1.44,1.44-1.44h15.34c0.8,0,1.44,0.65,1.44,1.44v14.8z\"/>");
  echo("<g style=\"fill:#FFFFFF;stroke:none;font-family:verdana;font-size:13pt;\">");
  echo("<text x=\"10\" y=\"15\" text-anchor=\"middle\">$</text>");
  echo("</g>");
  echo("</g>");


  //______________ Jumpgate shape
  echo("<g id=\"sJumpgate\" style=\"fill-rule:nonzero;clip-rule:nonzero;fill:#FFFF00;stroke:#FFFFFF;stroke-width:0.0369;stroke-miterlimit:4;\">");
  echo("<path style=\"fill:#4A4A4A;stroke:#000000;stroke-width:0.0697;\" d=\"M20.47,6.66c0.03,0.08,0.06,0.16,0.09,0.24l-0.49,0.16c0.48,1.2,0.75,2.51,0.75,3.88c0,1.42-0.29,2.77-0.8,4.01l0.48,0.15c-0.06,0.17-0.12,0.34-0.18,0.51h1.55V6.66h-1.39z\"/>");
  echo("<path style=\"fill:#BFBFBF;stroke:#000000;stroke-width:0.06971;\" d=\"M10.43,19.8c-4.89,0-8.86-3.97-8.86-8.86c0-1.2,0.24-2.34,0.67-3.38L0.77,7.08C0.3,8.27,0.03,9.57,0.03,10.94c0,1.4,0.28,2.73,0.78,3.95l1.4-0.45c0.74,1.75,2.03,3.2,3.65,4.16l-0.68,1.32c1.54,0.9,3.33,1.42,5.24,1.42
    c1.85,0,3.58-0.48,5.09-1.33l-0.7-1.37c-1.29,0.74-2.79,1.16-4.39,1.16z\"/>");
  echo("<path style=\"fill:#BFBFBF;stroke:#000000;stroke-width:0.06971;\" d=\"M19.29,10.94c0,1.26-0.26,2.45-0.73,3.53l1.47,0.47c0.52-1.23,0.8-2.59,0.8-4.01c0-1.37-0.27-2.68-0.75-3.88l-1.46,0.47c0.44,1.05,0.68,2.2,0.68,3.4z\"/>");
  echo("<path style=\"fill:#BFBFBF;stroke:#000000;stroke-width:0.06971;\" d=\"M10.43,2.08c1.64,0,3.17,0.45,4.48,1.22l0.7-1.37c-1.53-0.88-3.3-1.38-5.18-1.38c-1.91,0-3.7,0.52-5.24,1.42l0.7,1.37c1.33-0.8,2.88-1.25,4.54-1.25z\"/>");
  echo("<path style=\"fill:#F6F6F6;stroke:#000000;stroke-width:0.0697;\" d=\"M2.27,7.56c0.74-1.75,2.03-3.2,3.65-4.16L5.88,3.33l-0.7-1.37L4.85,1.31C2.73,2.47,1.02,4.42,0.22,6.9l0.56,0.18l1.46,0.47l0.03,0.01z\"/>");
  echo("<path style=\"fill:#F6F6F6;stroke:#000000;stroke-width:0.0697;\" d=\"M14.85,3.41c1.62,0.95,2.91,2.41,3.65,4.16l0.1-0.03l1.46-0.47l0.49-0.16c-0.03-0.08-0.06-0.16-0.09-0.24c-0.83-2.37-2.49-4.22-4.55-5.34l-0.31,0.61l-0.7,1.37l-0.06,0.11z\"/>");
  echo("<path style=\"fill:#F6F6F6;stroke:#000000;stroke-width:0.0697;\" d=\"M2.21,14.44l-1.4,0.45L0.16,15.1c0.8,2.49,2.51,4.43,4.63,5.59l0.4-0.77l0.68-1.32c-1.62-0.95-2.91-2.41-3.65-4.16z\"/>");
  echo("<path style=\"fill:#F6F6F6;stroke:#000000;stroke-width:0.0697;\" d=\"M20.02,14.94l-1.47-0.47l-0.11-0.03c-0.74,1.75-2.03,3.2-3.65,4.16l0.02,0.04l0.7,1.37l0.35,0.68c1.98-1.08,3.59-2.84,4.45-5.08c0.06-0.17,0.13-0.34,0.18-0.51l-0.48-0.15z\"/>");
  echo("<path style=\"fill:#BFBFBF;stroke:#000000;stroke-width:0.0697;\" d=\"M27.9,5.04h-0.09v-1.5h-1.98v1.5h-0.9V0.05h-2.16V5.1c-0.52,0.17-0.9,0.65-0.9,1.23v0.3c0,0,0,0,0,0v0.03v8.95v0.09c0,0.58,0.38,1.07,0.9,1.23v1.56h0.54v11.35h0.42V18.49h0.54v-1.5h0.81c0.71,0,1.29-0.58,1.29-1.29V7.92h1.53
    c0.71,0,1.29-0.58,1.29-1.29v-0.3c0-0.71-0.58-1.29-1.29-1.29z\"/>");
  echo("<path style=\"fill:#4A4A4A;stroke:#000000;stroke-width:0.06972;\" d=\"M26.07,7.02c-1.14,0.12-0.9,0.3-0.9,1.02c0,0.72,0,6.43,0,6.43s0.07,1.55-0.53,1.85c-0.6,0.3-1.31,0.58-1.31,0.58l-0.06,12.98h0.42V18.52h0.54v-1.5h0.81c0.71,0,1.29-0.58,1.29-1.29V7.95h1.53c0.71,0,1.29-0.58,1.29-1.29V6.6
    c-0.71,0.11-2.24,0.33-3.09,0.42z\"/>");
  echo("<path style=\"stroke-width:0.0977;\" d=\"M28.12,7.2h-5.9V6.66h5.9V7.2z\"/>");
  echo("<path style=\"stroke-width:0.0697;\" d=\"M25.26,8.46h-3V7.92h3v0.54z\"/>");
  echo("<g id=\"rotesLicht\">");
    echo("<path style=\"fill:#FF0000;stroke:none;\" d=\"M24.09,29.85c0,0.3-0.24,0.54-0.54,0.54s-0.54-0.24-0.54-0.54c0-0.3,0.24-0.54,0.54-0.54s0.54,0.24,0.54,0.54z\">");
  if ($map_info->has_map_anims())
      echo("<animateColor attributeType=\"CSS\" attributeName=\"fill\" from=\"red\" to=\"black\" dur=\"2s\" repeatCount=\"indefinite\" begin=\"0s\"/>");
    echo("</path>");
  echo("</g>");
  echo("<path d=\"M24.15,14.53h-0.84v-0.54h0.84v0.54z\"/>");
  echo("<path d=\"M24.15,12.03h-0.84v-0.54h0.84v0.54z\"/>");
  echo("<path d=\"M24.15,9.54h-0.84V9h0.84v0.54z\"/>");
  echo("<path style=\"fill:#4A4A4A;stroke:#000000;stroke-width:0.06972;\" d=\"M24.87,5.04h-0.7v-5h0.7v5z\"/>");
  echo("<path style=\"fill:#4A4A4A;stroke:#000000;stroke-width:0.06972;\" d=\"M27.81,5.04h-0.67V3.54h0.67v1.49z\"/>");
  echo("<path d=\"M24.24,4.06H23.4V3.52h0.84v0.54z\"/>");
  echo("<path d=\"M24.24,1.57H23.4V1.02h0.84v0.54z\"/>");
  echo("<path d=\"M27.27,4.48h-0.84V3.94h0.84v0.54z\"/>");
  echo("<path style=\"fill:#5C5C5C;stroke:#000000;stroke-width:0.0697;\" d=\"M20.03,14.98l-0.14-0.04c-0.03,0.09-0.07,0.19-0.1,0.28c-0.83,2.15-2.34,3.85-4.21,4.94l0.29,0.57c1.98-1.08,3.59-2.84,4.45-5.08c0.06-0.17,0.13-0.34,0.18-0.51l-0.48-0.15z\"/>");
  echo("<path style=\"fill:#BFBFBF;stroke:#000000;stroke-width:0.06970;\" d=\"M20.03,7.1l-0.54,0.18c0.45,1.17,0.7,2.43,0.7,3.76c0,1.34-0.25,2.62-0.71,3.79l0.5,0.16c0.52-1.23,0.8-2.59,0.8-4.01c0-1.37-0.27-2.68-0.75-3.88z\"/>");
  echo("<path style=\"fill:#5C5C5C;stroke:#000000;stroke-width:0.0697;\" d=\"M20.02,7.08l0.1-0.03l0.49-0.16c-0.03-0.08-0.06-0.16-0.09-0.24c-0.83-2.37-2.49-4.22-4.55-5.34l-0.3,0.59c1.96,1.12,3.53,2.91,4.35,5.19z\"/>");
  echo("<g transform=\"translate(10 10.5)\">");
  echo("<g id=\"whirl\">");
    echo("<g transform=\"translate(-10 -10.5)\">");
    echo("<path style=\"fill:none;stroke:#00FFFF;stroke-width:2;\" stroke-dasharray=\"2\" d=\"M8.37,18.54c-3.96-1.96-5.58-6.75-3.63-10.7c1.56-3.17,5.4-4.46,8.56-2.9c2.53,1.25,3.57,4.32,2.32,6.85c-1,2.03-3.45,2.86-5.48,1.86c-1.62-0.8-2.29-2.76-1.49-4.38c0.64-1.3,2.21-1.83,3.51-1.19
    c1.04,0.51,1.46,1.77,0.95,2.81c-0.41,0.83-1.42,1.17-2.25,0.76c-0.66-0.33-0.94-1.13-0.61-1.8c0.26-0.53,0.91-0.75,1.44-0.49\"/>");
    echo("</g>");
  if ($map_info->has_map_anims())
    echo("<animateTransform attributeType=\"XML\" attributeName=\"transform\" type=\"rotate\" values=\"0;360\" dur=\"5s\" repeatCount=\"indefinite\" begin=\"0s\"/>");
  echo("</g>");
  echo("</g>");
  echo("</g>");

  //______________ Tradingstation shape
  echo("<g id=\"sTradingStation\" style=\"fill-rule:nonzero;clip-rule:nonzero;fill:#565656;stroke:#000000;stroke-miterlimit:4;\">");
  echo("<path style=\"fill:none;stroke:none;\" d=\"M11.8,9.1c0.12,0.06,0.23,0.15,0.35,0.22c-0.11-0.08-0.23-0.15-0.34-0.22l0,0z\"/>");
  echo("<path style=\"fill:#D5D5D5;stroke:none;\" d=\"M11.17,15.44c0.14-0.02,0.27-0.05,0.41-0.09c-0.13,0.04-0.27,0.06-0.4,0.08l0,0z\"/>");
  echo("<path style=\"fill:#D5D5D5;stroke:none;\" d=\"M10.88,15.4c-0.65,0.04-1.35-0.06-2.02-0.36c-0.53-0.24-0.98-0.57-1.35-0.95c0.33,0.29,0.7,0.54,1.12,0.74c1.42,0.63,2.97,0.44,3.98-0.35l-6.12-2.73c0,0.66,0.2,1.33,0.59,1.91l-0.99,2.21l0.59,0.26l-2.3,5.16l1.44,0.64l0.02-0.03l-0.22-0.1
    l2.3-5.16l0.26,0.12l-0.02,0.03l0.42,0.19L3.42,28.52l0.52,0.23l0.02-0.03l-0.22-0.1l5.15-11.55l0.26,0.12l-0.01,0.03l1.01,0.45l0.01-0.03l-0.22-0.1l0.95-2.13z\"/>");
  echo("<path style=\"fill:#D5D5D5;stroke:none;\" d=\"M13.72,12.21c0,0,0,0,0-0.01c-0.01-1.09-0.59-2.17-1.57-2.88c-0.11-0.07-0.22-0.15-0.35-0.22l0,0c-0.07-0.04-0.14-0.09-0.21-0.13l3.71-8.33l-0.23-0.11L11.34,8.9C9.83,8.33,8.21,8.7,7.27,9.74l6.41,2.85c0.02-0.13,0.04-0.26,0.04-0.38z\"/>");
  echo("<path style=\"stroke:none;\" d=\"M7.9,16.63l-2.3,5.16l0.22,0.1l0.04,0.02l2.3-5.16L7.9,16.63z\"/>");
  echo("<path style=\"stroke:none;\" d=\"M3.99,28.73l-0.04-0.02l-0.22-0.1l5.15-11.55l0.26,0.12\"/>");
  echo("<path style=\"stroke:none;\" d=\"M12.61,14.47c-1.02,0.8-2.56,0.99-3.98,0.35c-0.43-0.19-0.8-0.45-1.12-0.74c0.37,0.38,0.82,0.71,1.35,0.95c0.67,0.3,1.36,0.4,2.02,0.36l-0.95,2.13l0.22,0.1l0.04,0.02l0.98-2.21l0,0c0.14-0.02,0.27-0.05,0.4-0.08
    c0.52-0.14,0.99-0.39,1.38-0.73l-0.34-0.15z\"/>");
  echo("<path style=\"stroke:none;\" d=\"M12.15,9.32c0.98,0.72,1.56,1.8,1.57,2.88c0,0,0,0,0,0.01c0,0.13-0.02,0.26-0.04,0.38l0.25,0.11c0.17-1.4-0.63-2.87-2.08-3.62l3.73-8.36l-0.26-0.11l-3.73,8.36c0.07,0.04,0.45,0.27,0.56,0.35z\"/>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M20.27,16.04c0.03,0.14,0.02,0.28-0.04,0.4l-0.15,0.34c-0.2,0.45-0.88,0.57-1.52,0.29L0.84,9.18C0.42,8.99,0.13,8.67,0.03,8.34c0.08,0.34,0.39,0.69,0.83,0.89l5.63,2.51l6.12,2.73l0.34,0.15l5.61,2.5c0.64,0.29,1.32,0.16,1.52-0.29
    l0.15-0.34c0.06-0.14,0.07-0.3,0.02-0.45z\"/>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M18.34,16.66c0.64,0.29,1.32,0.16,1.52-0.29l0.15-0.34c0.06-0.13,0.06-0.26,0.04-0.41c-0.15-0.18-0.36-0.35-0.62-0.46l-5.5-2.45l-0.25-0.11L7.27,9.74L1.73,7.27C1.09,6.99,0.4,7.12,0.21,7.56L0.05,7.9C0,8.03-0.01,8.17,0.02,8.31
    c0.15,0.18,0.36,0.35,0.62,0.46l17.71,7.89z M16.58,14.62l2.81,1.25l-0.23,0.52l-2.81-1.25l0.23-0.52z M11.38,12.3l2.81,1.25l-0.23,0.52l-2.81-1.25l0.23-0.52z M6.18,9.99l2.81,1.25l-0.23,0.52l-2.81-1.25l0.23-0.52z M0.98,7.67l2.81,1.25L3.56,9.44l-2.8-1.25
    l0.23-0.52z\"/>");
  echo("<path style=\"fill:#F8F8F8;stroke:none;\" d=\"M1.77,7.72l5.55,2.47l6.41,2.85l0.25,0.11l5.51,2.45c0.21,0.09,0.39,0.22,0.53,0.37c0.04-0.11,0.05-0.24,0.02-0.36c-0.15-0.18-0.36-0.35-0.62-0.46l-5.5-2.45l-0.25-0.11L7.25,9.73L1.71,7.26C1.07,6.97,0.39,7.1,0.19,7.55L0.04,7.89
    C-0.02,8.01-0.03,8.15,0,8.3c0.03,0.03,0.06,0.06,0.09,0.1c0.01-0.02,0-0.03,0.01-0.05L0.25,8c0.2-0.45,0.88-0.57,1.52-0.29z\"/>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M20.23,15.92c0.01,0.02,0.02,0.05,0.03,0.07c-0.01-0.02-0.02-0.05-0.03-0.07z\"/>");
  echo("<path style=\"stroke:none;\" d=\"M18.55,17.07c0.64,0.29,1.32,0.16,1.52-0.29l0.15-0.34c0.06-0.13,0.06-0.26,0.04-0.4c0-0.02-0.01-0.03-0.01-0.05c-0.01-0.02-0.02-0.05-0.03-0.07c-0.04-0.11-0.1-0.22-0.18-0.33c0,0.01,0,0.03,0,0.04c0.03,0.14,0.02,0.28-0.04,0.41
    l-0.15,0.34c-0.2,0.45-0.88,0.58-1.52,0.29L0.63,8.77C0.38,8.66,0.17,8.49,0.02,8.31c0,0-0.01-0.01-0.01-0.01c0,0.01,0.01,0.03,0.02,0.04c0.1,0.33,0.4,0.65,0.82,0.84l17.71,7.89z\"/>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M3.79,8.92L0.98,7.67L0.75,8.19l2.8,1.25l0.23-0.52z\">");
  if ($map_info->has_map_anims())
    echo("<set id=\"Tradingstation_Blink1\" attributeType=\"CSS\" attributeName=\"fill\" to=\"red\" begin=\"0s;Tradingstation_Blink4.end\" dur=\"1s\"/>");
  echo("</path>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M8.76,11.76l0.23-0.52L6.18,9.99l-0.23,0.52l2.81,1.25z\">");
  if ($map_info->has_map_anims())
    echo("<set id=\"Tradingstation_Blink2\" attributeType=\"CSS\" attributeName=\"fill\" to=\"red\" begin=\"Tradingstation_Blink1.end\" dur=\"1s\"/>");
  echo("</path>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M13.96,14.08l0.23-0.52l-2.81-1.25l-0.23,0.52l2.81,1.25z\">");
  if ($map_info->has_map_anims())
    echo("<set id=\"Tradingstation_Blink3\" attributeType=\"CSS\" attributeName=\"fill\" to=\"red\" begin=\"Tradingstation_Blink2.end\" dur=\"1s\"/>");
  echo("</path>");
  echo("<path style=\"fill:#E4E4E4;stroke:none;\" d=\"M19.39,15.87l-2.81-1.25l-0.23,0.52l2.81,1.25l0.23-0.52z\">");
  if ($map_info->has_map_anims())
    echo("<set id=\"Tradingstation_Blink4\" attributeType=\"CSS\" attributeName=\"fill\" to=\"red\" begin=\"Tradingstation_Blink3.end\" dur=\"1s\"/>");
  echo("</path>");
  echo("<path onclick=\"lichtunten\" style=\"fill:#FF0000;stroke:none;\" d=\"M4.38,29.13c-0.17,0.38-0.62,0.55-1,0.38C3,29.34,2.83,28.89,3,28.51c0.17-0.38,0.61-0.55,1-0.38c0.38,0.17,0.55,0.61,0.38,1z\">");
  if ($map_info->has_map_anims())
    echo("<animateColor attributeType=\"CSS\" attributeName=\"fill\" from=\"red\" to=\"black\" dur=\"2s\" repeatCount=\"indefinite\" begin=\"0s\"/>");
  echo("</path>");
  echo("<path onclick=\"lichtoben\" style=\"fill:#FF0000;stroke:none;\" d=\"M16.03,1c-0.17,0.38-0.62,0.55-1,0.38c-0.38-0.17-0.55-0.62-0.38-1C14.82,0,15.27-0.17,15.65,0c0.38,0.17,0.55,0.61,0.38,1z\">");
  if ($map_info->has_map_anims())
      echo("<animateColor attributeType=\"CSS\" attributeName=\"fill\" from=\"lime\" to=\"black\" dur=\"2s\" repeatCount=\"indefinite\" begin=\"0s\"/>");
  echo("</path>");
  echo("</g>");

  //_________________________ Homesystem shape
  echo("<g id=\"sHomeSystem\" style=\"fill:#A5D9FF;stroke:none;\">");
  echo("<path d=\"M5.25,0.35l-5,4.82v7.39h1.34V6.7h2.53v5.86h6.12V5.16L5.25,0.35z M8.72,8.96h-2.8V6.7h2.8V8.96z\"/>");
  echo("</g>");
  //_________________________ Uhren Symbol shape
  echo("<g id=\"sUhrSymbol\" style=\"fill-rule:nonzero;clip-rule:nonzero;stroke:#000000;stroke-width:0.0578;stroke-miterlimit:4;\">");
  echo("<path style=\"fill:#FFFF00;stroke-width:0.3994;\" d=\"M10.23,5.22c0,2.77-2.25,5.02-5.02,5.02S0.2,7.99,0.2,5.22S2.45,0.2,5.22,0.2s5.02,2.25,5.02,5.02z\"/>");
  echo("<path style=\"stroke:none;\" d=\"M5.22,5.11L2,3.4L1.47,4.28L5.2,6.26l0.02-0.03l0.01,0.02l2.4-1.03L7.22,4.26l-2,0.85z\"/>");
  echo("<path d=\"M5.5,9.29v0.88H4.94V9.29H5.5z\"/>");
  echo("<path d=\"M5.5,0.26v0.88H4.94V0.26H5.5z\"/>");
  echo("<path d=\"M1.14,5.5H0.26V4.94h0.88V5.5z\"/>");
  echo("<path d=\"M10.17,5.5H9.29V4.94h0.88V5.5z\"/>");
  echo("</g>");

  //_________________________ Schiff Bouncing Symbol
  echo("<g id=\"sShip\" style=\"stroke:black;stroke-width:1px;\" transform=\"scale(0.5)\">");
  echo("<path d=\"M10.95,7.54C11.04,4.81,7.99,0.04,7.97,0v0v0l0,0v0C7.95,0.04,4.9,4.81,4.98,7.54c0.08,2.74-1.66,6.24-4.98,8.37h7.96h0h7.96c-3.32-2.13-5.06-5.63-4.98-8.37z\"/>");
  echo("</g>");

  //_________________________ Shape Planet Cross
  echo("<g id=\"sPlanetCross\" style=\"fill-rule:nonzero;clip-rule:nonzero;fill:#FFFFFF;stroke:#000000;stroke-width:0.2001;stroke-miterlimit:4;stroke-dasharray:3.4173;\">");
  echo("<path d=\"M15.1,34.77V0\"/>");
  echo("<path d=\"M0.04,26.08L30.16,8.69\"/>");
  echo("<path d=\"M30.16,26.08L0.04,8.69\"/>");
  echo("</g>");

  //_________________________ Shape Fleet Ring -- zeigt die flotten routen richtung an
  echo("<g id=\"sFleetRing\" style=\"fill-rule:nonzero;clip-rule:nonzero;stroke:#000000;stroke-miterlimit:4;\">");
  echo("<path style=\"fill:#001ADF;stroke:#3FEDFF;stroke-width:0.25;\" d=\"M8.4,0.944c-4.57,0-8.275,3.705-8.275,8.276c0,4.57,3.705,8.275,8.275,8.275c4.571,0,8.276-3.705,8.276-8.275c0-4.571-3.705-8.276-8.276-8.276z M8.4,15.687c-3.569,0-6.465-2.896-6.465-6.466c0-3.57,2.896-6.464,6.465-6.464
    c3.571,0,6.465,2.894,6.465,6.464c0,3.569-2.894,6.466-6.465,6.466z\"/>");
  echo("<path style=\"fill:#BFC6FF;stroke:#FFFFFF;stroke-width:0.25;\" d=\"M4.415,0.125L8.4,4.112l3.987-3.987H4.415z\"/>");
  echo("</g>");

  //_________________________ Shape Fleet Route Point -- zeigt die stationsnummer einer flottenroute an
  echo("<g id=\"sFleetRouteNumber\">");
      echo("<path style=\"fill:#1D7EB7;stroke:#82D0E3;\" d=\"M22.686,29.895H5.366V0.561h17.32V29.895z\"/>");
      echo("<path style=\"fill:#184272;stroke:#ACFFF6;\" d=\"M7.56,25.736v2.903h8.08l5.873-7.299V3.52h-2.191V2.114h-0.723v2.177h2.041v16.414
        l-5.248,7.002H8.394v-2.722H6.762v0.751H7.56z\"/>");
      echo("<path style=\"fill:#184272;stroke:#1A356F;\" d=\"M21.36,0.812h-2.352v2.338h2.352v17.623l-6.049,7.518H7.247v-2.925H5.366v5.262
        h0.941h0.94h15.994v-1.754V28.29V3.149V0.812H21.36z\"/>");
      echo("<path style=\"fill:#1D4CB7;stroke:#82D0E3;\" d=\"M10.157,5.323c0,2.67-2.164,4.834-4.833,4.834c-2.67,0-4.833-2.164-4.833-4.834
        c0-2.669,2.164-4.833,4.833-4.833C7.993,0.49,10.157,2.654,10.157,5.323z\"/>");
  echo("</g>");

  //_________________________ Shape Fleet Route Move Symbol
  echo("<g id=\"sFleetRouteSymbolMove\">");
    echo("<path style=\"fill:#F7F619;\" d=\"M6.188,2.419H3.394V0L0.006,2.902H0l0.003,0.001L0,2.905h0.005l3.388,2.9V3.389h2.795\"/>");
  echo("</g>");

  
  //_________________________ rauschen
  echo("<g id=\"animationRauschen\">");
  echo("<image xlink:href=\"arts/rauschen1.gif\" x=\"0\" y=\"0\" width=\"50\" height=\"50\" opacity=\"1\"/>");
  echo("<image xlink:href=\"arts/rauschen2.gif\" x=\"0\" y=\"0\" width=\"50\" height=\"50\" style=\"opacity:0;\">");
  echo("<animate attributeType=\"CSS\" attributeName=\"opacity\" values=\"0;0.75;0\" dur=\"500ms\" repeatCount=\"indefinite\"/>");
  echo("</image>");
  echo("</g>");  
}

//**************
//
//    function gui_definitions()
//
//**************
function gui_definitions($map_info)
{
  //______________ Sateliten Schüssel
  echo("<g id=\"sSatelite_dish\" style=\"stroke:black;stroke-width:0.2mm;\">");
  echo("<path d=\"M10.705,3.704c-0.221-0.35-0.652-0.475-0.963-0.279c-0.206,0.13-0.307,0.369-0.287,0.617L6.439,5.948l0.408,0.646l3.017-1.906c0.216,0.124,0.474,0.135,0.68,0.005c0.311-0.196,0.383-0.639,0.161-0.99z\"/>");
  echo("<path d=\"M2.811,0.868C0.997,3.196,0.738,6.503,2.405,9.142c0.035,0.054,0.07,0.107,0.106,0.161c0.021-0.034,0.033-0.054,0.033-0.054s3.414,2.638,4.143,3.015c1.09,0.282,2.244,0.311,3.365,0.062l-3.481-5.51L6.162,6.17L2.811,0.868z\"/>");
  echo("<path d=\"M0.495,14.621h6.314c0,0-0.056-1.883-0.609-2.105c-0.019-0.007-0.041-0.018-0.066-0.031C5.404,12.108,1.99,9.47,1.99,9.47S1.978,9.49,1.958,9.523c-0.256,0.42-1.207,3.252-1.463,5.098\"/>");
  echo("</g>");

  //*************************************** Basic Shapes
  //_________________________________ Pfeil 50 x 50 Orientation: points to 3 o'clock
  echo("<path id=\"shape_Pfeil_50x50\" d=\"M6.188,2.419H3.394V0L0.006,2.902H0l0.003,0.001L0,2.905h0.005l3.388,2.9V3.389h2.795\"/>");


  //_________________________________ Häkchen 30 x 30
  echo("<path id=\"shape_Ok_30x30\" class=\"ok\" d=\"M9.53,30.95c0,0,15.23-20.5,18.98-26c10.63-15.62-13.9,13.12-18.59,17.81c-4.55,4.55-6.11-3.51-8.97-3.51c-2.86,0,8.58,11.7,8.58,11.7z\"/>");


  //***************************************  Filter
  echo("<filter id=\"filterButton1\" filterUnits=\"userSpaceOnUse\">\n");
  echo("<!--Copyright 1999 Adobe Systems. You may copy, modify, and distribute this file, if you include this notice & do not charge for the distribution. This file is provided \"AS-IS\" without warranties of any kind, including any implied warranties.-->\n");
  echo("<feGaussianBlur in=\"SourceAlpha\" stdDeviation=\"4\" result=\"blur\"/>\n");
  //echo("<feOffset in=\"blur\" dx=\"4\" dy=\"4\" result=\"offsetBlurredAlpha\"/>\n");
  echo("<feSpecularLighting in=\"blur\" surfaceScale=\"5\" specularConstant=\"0.9\" specularExponent=\"20\" lightColor=\"white\" result=\"specularOut\">\n");
  echo("<fePointLight x=\"50%\" y=\"-50%\" z=\"10\"/>\n");
  echo("</feSpecularLighting>\n");
  echo("<feComposite in=\"specularOut\" in2=\"SourceAlpha\" operator=\"in\" result=\"specularOut\"/>\n");
  echo("<feComposite in=\"SourceGraphic\" in2=\"specularOut\" operator=\"arithmetic\" k1=\"0\" k2=\"1\" k3=\"1\" k4=\"0\" result=\"litPaint\"/>\n");
  echo("<feMerge>\n");
  //echo("<feMergeNode in=\"offsetBlurredAlpha\"/>\n");
  echo("<feMergeNode in=\"litPaint\"/>\n");
  echo("</feMerge>\n");
  echo("</filter>\n");


  echo("<filter id=\"dropShadow\" filterUnits=\"userSpaceOnUse\">\n");
  echo("<feGaussianBlur in=\"SourceAlpha\" stdDeviation=\"3\" result=\"blur\"/>\n");
  echo("<feOffset in=\"blur\" dx=\"5\" dy=\"5\" result=\"offsetBlur\"/>\n");
  echo("<feMerge>\n");
  echo("<feMergeNode in=\"offsetBlur\"/>\n");
  echo("<feMergeNode in=\"SourceGraphic\"/>\n");
  echo("</feMerge>\n");
  echo("</filter>\n");


  //***************************************  ITEMBOX_ITEMS
  echo("<path id=\"item_relation_indicator\" d=\"M0.39,15.73c-2.43,5.69,4.06,7.9,4.06,10.63V0H0.39V15.73z\" transform=\"scale(0.9)\"/>");

  echo("<g id=\"item_control_button\">");
  echo("<path class=\"mapGUIButton\" d=\"M9.22,71.48c0-0.21,0.02-0.41,0.03-0.62c-0.02-0.19-0.03-0.38-0.03-0.57V26.86c0-2.73-6.48-4.93-4.06-10.63V0.54C2.56,0.71,0.5,2.85,0.5,5.5v74c0,2.76,2.24,5,5,5h10c1.02,0,1.96-0.31,2.75-0.83C13.03,82.08,9.22,77.23,9.22,71.48z\"/>\n");
  echo("<path class=\"mapGUIButtonFace\" d=\"M9.22,41.71l-6.07-6.07l6.07-6.07V41.71z\"/>\n");
  echo("<path class=\"mapGUIButtonFace\" d=\"M9.22,57.71l-6.07-6.07l6.07-6.07V57.71z\"/>\n");
  echo("<path class=\"mapGUIButtonFace\" d=\"M9.22,74.37L3.15,68.3l6.07-6.07V74.37z\"/>\n");
  echo("</g>");


    //***************************************  BUTTONS
//  echo("<path id=\"button_ellipse_20x27_shadow\" style=\"filter:url(#filterButton1);\" d=\"M30.08,24.33c0,7.46-4.37,13.5-9.75,13.5c-5.38,0-9.75-6.04-9.75-13.5s4.37-13.5,9.75-13.5C25.72,10.83,30.08,16.88,30.08,24.33z\"/>");
//  echo("<circle id=\"button_circle_30x30_shadow\" style=\"filter:url(#filterButton1);\" cx=\"15\" cy=\"15\" r=\"15\" transform=\"translate(7.5 7.5)\"/>\n");
  echo("<path id=\"button_ellipse_20x27_shadow\" d=\"M30.08,24.33c0,7.46-4.37,13.5-9.75,13.5c-5.38,0-9.75-6.04-9.75-13.5s4.37-13.5,9.75-13.5C25.72,10.83,30.08,16.88,30.08,24.33z\"/>");
  echo("<circle id=\"button_circle_30x30_shadow\" cx=\"15\" cy=\"15\" r=\"15\" transform=\"translate(7.5 7.5)\"/>\n");

  echo("<circle id=\"button_circle_small\" cx=\"7.5\" cy=\"7.5\" r=\"7.5\"/>\n");
  echo("<circle id=\"button_circle_big\" cx=\"15\" cy=\"15\" r=\"15\"/>\n");
  echo("<rect id=\"button_rect_small\" x=\"0\" y=\"0\" width=\"15\" height=\"15\"/>\n");
  echo("<rect id=\"button_rect_big\" x=\"0\" y=\"0\" width=\"30\" height=\"30\"/>\n");
    //***************************************  BUTTON FACES

  // schiffs kontur
  echo("<path id=\"button_face_ship\" pointer-events=\"none\" d=\"M14.64,12.61V8.89h-0.61v3.19c-1.44-1.23-3.16-2.65-3.19-3.88C10.6,6.97,9.69,5.38,9.29,4.06
      c-1.19-3.87-1.1-4-1.29-4.06V0c0,0-0.01,0-0.01,0c0,0-0.01,0-0.01,0v0.01c-0.2,0.05-0.1,0.19-1.29,4.06
      C6.27,5.38,5.37,6.97,5.12,8.2c-0.03,1.23-1.75,2.65-3.19,3.88V8.89H1.32v3.72c-0.8,0.71-1.39,1.33-1.32,1.77
      c0.13,0.8,5.5,1.2,5.5,1.2h0.38v1h1.65v-1h0.44h0.02h0.44v1h1.65v-1h0.38c0,0,5.38-0.39,5.51-1.2
      C16.03,13.94,15.44,13.32,14.64,12.61z\"/>\n");

  // infantery symbol
  echo("<path id=\"button_face_infantry\" d=\"M 5.65935 12.6319 L 4.58135 12.9419 L 3.67535 10.6519 L 1.05734 15.2319 L -1.55267 12.6619 L 1.44134 10.3819 L 0.773341 9.33187 L 6.11936 4.13191 L 7.38131 5.06191 L 10.8853 1.66191 L 11.4293 1.84191 L 13.0873 0.231868 L 13.4473 0.601908 L 11.7873 2.21191 L 11.9633 2.76191 L 7.49731 7.01191 L 10.8453 7.55191 L 10.7993 9.60187 L 5.72335 8.58187 C 6.47136 9.72187 5.79935 10.3819 4.69135 9.78187 L 5.65935 12.6319z\"/>\n");

  // info button
  echo("<text x=\"7.5\" y=\"17\" id=\"button_face_info\" pointer-events=\"none\" text-anchor=\"middle\" style=\"font-size:20pt;font-weight:bold;font-family:'times new roman';\">i</text>\n");


  // move command
  echo("<g id=\"button_face_FLEET_MOVE\" transform=\"translate(-5 -5)\">\n");
  echo("<path d=\"M12.65,0.5C5.94,0.5,0.5,5.94,0.5,12.65c0,6.71,5.44,12.15,12.15,12.15s12.15-5.44,12.15-12.15
  C24.81,5.94,19.37,0.5,12.65,0.5z M15.62,22.29c-5.32,0-12.6-4.31-12.6-9.64c0-5.32,7.28-9.64,12.6-9.64
  c2.38,0,3.69,3.86,3.94,8.12h-3.69V6.22L4.96,12.65l10.91,6.43v-4.92h3.69C19.31,18.43,18,22.29,15.62,22.29z\"/>\n");
  echo("<path d=\"M12.65,0.5C5.94,0.5,0.5,5.94,0.5,12.65c0,6.71,5.44,12.15,12.15,12.15s12.15-5.44,12.15-12.15
  C24.81,5.94,19.37,0.5,12.65,0.5z M15.62,22.29c-5.32,0-12.6-4.31-12.6-9.64c0-5.32,7.28-9.64,12.6-9.64
  c2.38,0,3.69,3.86,3.94,8.12h-3.69V6.22L4.96,12.65l10.91,6.43v-4.92h3.69C19.31,18.43,18,22.29,15.62,22.29z\"/>\n");
  echo("</g>\n");

  // close/cancel button
  echo("<g id=\"button_face_close\" style=\"fill:none;stroke:yellow;stroke-width:2px;\">");
  echo("<line x1=\"0\" y1=\"0\" x2=\"8\" y2=\"8\"/>");
  echo("<line x1=\"0\" y1=\"8\" x2=\"8\" y2=\"0\"/>");
  echo("</g>");

  // mark all button
  echo("<g id=\"button_face_mark\" style=\"fill:none;stroke:yellow;stroke-width:2px;\">");
  echo("<path d=\"M0,0 L4,4 L8,0\"/>");
  echo("<path d=\"M0,4 L4,8 L8,4\"/>");
  echo("</g>");

  // mop: transfer
  echo("<g id=\"button_face_transfer\" style=\"fill:none;stroke:yellow;stroke-width:2px\">");
  echo("<path d=\"M0,4 L7,4 L5,2 L5,6 L7,4\"/>");
  echo("</g>");
  
  // mop: ok
  echo("<g id=\"button_face_ok\" style=\"fill:none;stroke:yellow;stroke-width:2px\">");
  echo("<path d=\"M0,6 L3,8 L8,0\"/>");
  echo("</g>");

  // mop: create
  echo("<g id=\"button_face_create\" style=\"fill:none;stroke:yellow;stroke-width:2px\">");
  echo("<line x1=\"0\" y1=\"0\" x2=\"8\" y2=\"8\"/>");
  echo("<line x1=\"0\" y1=\"4\" x2=\"8\" y2=\"4\"/>");
  echo("<line x1=\"4\" y1=\"0\" x2=\"4\" y2=\"8\"/>");
  echo("<line x1=\"0\" y1=\"8\" x2=\"8\" y2=\"0\"/>");
  echo("</g>");

  echo("<path id=\"button_face_iconify\" d=\"M0 0 L8 0 L4 8z\" style=\"fill:none;stroke:yellow;stroke-width:2px;\"/>\n");


  //***************************************  BUTTON GRADIANTS

  echo("<radialGradient id=\"button_gradient_normal\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"50%\" stop-color=\"#195CA7\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#000099\" stop-opacity=\"0.8\"/>");
  echo("</radialGradient>");


  echo("<radialGradient id=\"button_gradient_activated\" gradientUnits=\"objectBoundingBox\">");
  echo("<stop offset=\"80%\" stop-color=\"#3366CC\"/>");
  echo("<stop offset=\"100%\" stop-color=\"#4DAEDF\" stop-opacity=\"0.8\"/>");
  echo("</radialGradient>");
  //***************************************  ICONS
  /*
  //_________________________________ Refuel
  echo("<path id=\"icon_Refuel\" d=\"M4.229,0.121C3.76,2.729,2.512,5.152,1.578,7.612
      c-0.685,1.801-1.809,4.543-0.52,6.336c1.342,1.863,4.613,1.895,6.134,0.254c1.506-1.629,0.506-4.357-0.143-6.135
      C6.092,5.443,4.726,2.89,4.229,0.121\"/>\n");


  //_________________________________ Man
  echo("<g id=\"icon_Man\">\n");
  echo("<path d=\"M6.009,2.812c0,1.297-1.053,2.349-2.351,2.349c-1.297,0-2.348-1.052-2.348-2.349
        s1.051-2.35,2.348-2.35C4.956,0.462,6.009,1.514,6.009,2.812z\"/>\n");
  echo("<path d=\"M2.001,10.488v5.258H5.06v-5.258h1.758V8.574c0-1.744-1.414-3.159-3.158-3.159
        C1.914,5.416,0.5,6.83,0.5,8.574v1.914H2.001z\"/>\n");
  echo("</g>\n");

  //_________________________________ Invade
  echo("<g id=\"icon_Invade\" style=\"stroke:red;\">\n");
  echo("<path style=\"fill:black;\" d=\"M10.098,5.999c0,2.654-2.151,4.805-4.804,4.805S0.49,8.653,0.49,5.999
        c0-2.65,2.151-4.802,4.804-4.802S10.098,3.348,10.098,5.999z\"/>\n");
  echo("<path style=\"fill:red;\" d=\"M2.805,0.5l2.489,7.807L7.783,0.5H2.805z\"/>\n");
  echo("</g>\n");

  //_________________________________ Tonnage
  echo("<path id=\"icon_Tonnage\" style=\"fill:#BFCAE2;stroke:#666666;\" d=\"M5.921,0.5H3.022L0.585,15.966h8.102L5.921,0.5zM4.856,6.185v7.084H4.323V6.185H3.078V5.312h3.03v0.873H4.856z\"/>\n");


  //_________________________________ Move
  echo("<g id=\"icon_Move\" style=\"stroke:lime;\">\n");
  echo("<path style=\"fill:#000000;\" d=\"M10.212,5.352c0,2.685-2.176,4.861-4.861,4.861c-2.685,0-4.861-2.177-4.861-4.861
        S2.667,0.49,5.351,0.49C8.037,0.49,10.212,2.667,10.212,5.352z\"/>\n");
  echo("<g style=\"adobe-knockout:true;\">\n");
  echo("<path style=\"fill:none;adobe-knockout:false;\" d=\"M0.597,5.352h4.105\"/>\n");
  echo("<path style=\"fill:lime;adobe-knockout:false;\" d=\"M2.923,7.697l0.997-2.346L2.923,3.006l5.559,2.346L2.923,7.697z\"/>\n");
  echo("</g>\n");
  echo("</g>\n");


  //_________________________________ Colonize
  echo("<g id=\"icon_Colonize\">\n");
  echo("<path style=\"fill:black;\" d=\"M10.061,10.275c0.007-0.12,0.031-0.235,0.031-0.357v-3.93
        c0-3.038-2.149-5.501-4.799-5.501c-2.652,0-4.801,2.463-4.801,5.501v3.93c0,0.122,0.025,0.237,0.031,0.357H10.061z\"/>\n");
  echo("<path d=\"M6.653,5.704H3.932v4.571h2.721V5.704z\"/>\n");
  echo("</g>\n");


  //_________________________________ Bomb
  echo("<g id=\"icon_Bomb\" style=\"stroke:red;\">\n");
  echo("<path style=\"fill:black;\" d=\"M5.979,1.129L7.495,4.2l3.389,0.492L8.432,7.083l0.578,3.375L5.979,8.864
      L2.95,10.458l0.578-3.375L1.075,4.692L4.463,4.2L5.979,1.129z\"/>\n");
  echo("</g>\n");


  //_________________________________ Attack
  echo("<g id=\"icon_Attack\" style=\"stroke:red;\">\n");
  echo("<path style=\"fill:black;\" d=\"M9.172,5.14c0,2.223-1.801,4.022-4.021,4.022c-2.222,0-4.023-1.8-4.023-4.022
        c0-2.22,1.801-4.021,4.023-4.021C7.372,1.119,9.172,2.92,9.172,5.14z\"/>\n");
  echo("<path style=\"fill:none;\" d=\"M0,5.151h10.299\"/>\n");
  echo("<path style=\"fill:none;\" d=\"M5.15,10.301V0\"/>\n");
  echo("<path style=\"fill:black;\" d=\"M6.408,5.184c0,0.719-0.583,1.302-1.302,1.302S3.804,5.903,3.804,5.184
        s0.583-1.302,1.302-1.302S6.408,4.465,6.408,5.184z\"/>\n");
  echo("</g>\n");


  //_________________________________ Intercept
  echo("<g id=\"icon_Intercept\" style=\"stroke:yellow;\">\n");
  echo("<path style=\"fill:black;\" d=\"M0.571,0.5C0.528,0.935,0.5,1.377,0.5,1.833
        c0,4.514,2.204,8.173,4.924,8.173c2.721,0,4.924-3.659,4.924-8.173c0-0.456-0.027-0.898-0.07-1.333H0.571z\"/>\n");
  echo("<path style=\"fill:none;\" d=\"M6.191,0.5L3.125,3.566h4.744L4.947,6.489\"/>\n");
  echo("</g>\n");


  //_________________________________ Defend
  echo("<g id=\"icon_Defend\" style=\"stroke:lime;\">\n");
  echo("<path style=\"fill:#000000;\" d=\"M0.571,0.5C0.528,0.935,0.5,1.377,0.5,1.833
        c0,4.515,2.205,8.173,4.924,8.173c2.72,0,4.925-3.658,4.925-8.173c0-0.456-0.029-0.897-0.072-1.333H0.571z\"/>\n");
  echo("<path style=\"fill:#000000;\" d=\"M5.424,3.178V0.825\"/>\n");
  echo("<path style=\"fill:#000000;\" d=\"M5.424,6.148v3.857\"/>\n");
  echo("<path style=\"fill:#000000;\" d=\"M7.218,4.915c0,0.959-0.777,1.735-1.736,1.735c-0.959,0-1.736-0.776-1.736-1.735
        s0.777-1.736,1.736-1.736C6.44,3.178,7.218,3.956,7.218,4.915z\"/>\n");
  echo("<path style=\"fill:none;\" d=\"M0.775,5.254l2.623-0.003\"/>\n");
  echo("<path style=\"fill:none;\" d=\"M7.449,5.253h2.315\"/>\n");
  echo("</g>\n");


  //_________________________________ Park (stationierte Flotten)
  echo("<g id=\"icon_Park\" style=\"stroke:lime;\">\n");
  echo("<path style=\"fill:#000000;\" d=\"M10.443,5.467c0,2.75-2.229,4.978-4.977,4.978S0.49,8.216,0.49,5.467
  c0-2.748,2.229-4.977,4.977-4.977S10.443,2.719,10.443,5.467z\"/>\n");
  echo("<path style=\"fill:lime;\" d=\"M3.834,3.194c0,0,1.812-0.932,2.744-0.466c0.932,0.466,1.45,0.466,1.45,0.466
  v2.434c0,0-1.14-0.776-1.968-0.776S4.403,5.214,4.403,5.214H3.834V3.194z\"/>\n");
  echo("<path style=\"fill:none;\" d=\"M3.834,5.214v2.844\"/>\n");
  echo("</g>\n");
  */

  //****************************++ MINIMAP DEFINITIONEN ++********************************************

  //_________________________________ Eigene Flotte
  echo("<circle id=\"aMinimapOwnFleet\" cx=\"0\" cy=\"0\" r=\"".MINIMAP_FLEET_RADIUS."\" style=\"fill:lime;stroke:none;opacity:0;\">");
  if ($map_info->has_map_anims())
    echo("<animate attributeType=\"CSS\" attributeName=\"opacity\" values=\"1;0;0;0;0;\" begin=\"0s\" dur=\"".MINIMAP_FLEET_DUR."s\" repeatCount=\"indefinite\"/>");
  echo("</circle>");

  //_________________________________ Alliierte Flotte
  echo("<circle id=\"aMinimapAlliedFleet\" cx=\"0\" cy=\"0\" r=\"".MINIMAP_FLEET_RADIUS."\" style=\"fill:yellow;stroke:none;opacity:0;\">");
  if ($map_info->has_map_anims())
    echo("<animate attributeType=\"CSS\" attributeName=\"opacity\" values=\"1;0;0;0;0;\" begin=\"".(MINIMAP_FLEET_BLINK)."s\" dur=\"".MINIMAP_FLEET_DUR."s\" repeatCount=\"indefinite\"/>");
  echo("</circle>");

  //_________________________________ Freundliche Flotte
  echo("<circle id=\"aMinimapFriendFleet\" cx=\"0\" cy=\"0\" r=\"".MINIMAP_FLEET_RADIUS."\" style=\"fill:orange;stroke:none;opacity:0;\">");
  if ($map_info->has_map_anims())
    echo("<animate attributeType=\"CSS\" attributeName=\"opacity\" values=\"1;0;0;0;0;\" begin=\"".(2 * MINIMAP_FLEET_BLINK)."s\" dur=\"".MINIMAP_FLEET_DUR."s\" repeatCount=\"indefinite\"/>");
  echo("</circle>");

  //_________________________________ Feindliche Flotte
  echo("<circle id=\"aMinimapEnemyFleet\" cx=\"0\" cy=\"0\" r=\"".MINIMAP_FLEET_RADIUS."\" style=\"fill:red;stroke:none;opacity:0;\">");
  if ($map_info->has_map_anims())
    echo("<animate attributeType=\"CSS\" attributeName=\"opacity\" values=\"1;0;0;0;0;\" begin=\"".(3 * MINIMAP_FLEET_BLINK)."s\" dur=\"".MINIMAP_FLEET_DUR."s\" repeatCount=\"indefinite\"/>");
  echo("</circle>");

  //_________________________________ Neutrale Flotte
  echo("<circle id=\"aMinimapNeutralFleet\" cx=\"0\" cy=\"0\" r=\"".MINIMAP_FLEET_RADIUS."\" style=\"fill:blue;stroke:none;opacity:0;\">");
  if ($map_info->has_map_anims())
    echo("<animate attributeType=\"CSS\" attributeName=\"opacity\" values=\"1;0;0;0;0;\" begin=\"".(4 * MINIMAP_FLEET_BLINK)."s\" dur=\"".MINIMAP_FLEET_DUR."s\" repeatCount=\"indefinite\"/>");
  echo("</circle>");


  //**************************** PATTERNS *************************************************************
  echo("<pattern id=\"patternBlackDots\" patternUnits=\"userSpaceOnUse\" x=\"0\" y=\"0\" width=\"100\" height=\"100\" viewBox=\"0 0 2 2\">");
  echo("<path d=\"M 0 0 L 1 0 L 1 1 L 0 1 z\" stroke=\"black\" fill=\"black\"/>");
  echo("</pattern>");


  //**************************** Cursors *************************************************************
  // rune: Zoom in and Zoom out cursors
  echo("<cursor id=\"crs_zoom_in\" x=\"0\" y=\"0\" xlink:href=\"arts/cursor_zoom_in.png\"/>");
  echo("<cursor id=\"crs_zoom_out\" x=\"0\" y=\"0\" xlink:href=\"arts/cursor_zoom_out.png\"/>");
}


//**************
//
//    main
//
//**************
echo("<defs>");
$map_info=new map_info($uid);
map_definitions($map_info);
gui_definitions($map_info);
echo("</defs>");
$content=ob_get_contents();
ob_end_clean();

print gzcompress($content);

?>
