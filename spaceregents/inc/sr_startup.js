var mSvgDoc, fSvgDoc, pSvgDoc;
var mSvgRoot, fSvgRoot, pSvgRoot;
var mSvg, pSvg;
var currentPlanets;

function initPanel(evt)
{
  pSvgDoc   = evt.target.ownerDocument;
  pSvgRoot  = pSvgDoc.documentElement;
  pSvg      = pSvgDoc.getElementById("pSvg");
}


function initFather(evt)
{
  fSvgDoc   = evt.target.ownerDocument;
  fSvgRoot  = mSvgDoc.documentElement;
  fSvg      = fSvgDoc.getElementById("fSvg");
  
  window.onunload = unload;
  if (check_svg_viewer())
    loadDefinitions()
}


function initMap(evt)
{
  mSvgDoc   = evt.target.ownerDocument;
  mSvgRoot  = mSvgDoc.documentElement;
  mSvg    = mSvgDoc.getElementById("mSvg");
  somethingSelected = false;
}

function check_svg_viewer() {
  var my_regex = /(\w+);\s(\d+)/;
  my_regex.exec(getSVGViewerVersion());

  if (RegExp.$1 == "Adobe" && RegExp.$2 == 6)
    return true;
  else {
    alert("Sorry, you are using "+RegExp.$1+" Viewer "+RegExp.$2+".\nAdobe SVG Viewer 6 is needed to run the map propertly.\n You can find it at http://www.adobe.com/svg/viewer/install/beta.html.");
  }
  return false;  
}

function unload(evt) {
  fSvg.removeEventListener("keydown",registerKeyDown, false);
  fSvg.removeEventListener("keyup",registerKeyDown, false);
  fSvgRoot.removeEventListener("mouseup", cancelWindowMouseMove, true);
  fSvgRoot.removeEventListener("mousemove",doWindowMouseMove, true);
}