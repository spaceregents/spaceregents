function show_fleet_control(evt) {
  var callerObj = evt.target;

  if (String(callerObj) == "[object SVGElementInstance]")
    callerObj = callerObj.correspondingUseElement.parentNode;
  else
    callerObj = callerObj.parentNode;

  alert(callerObj.getAttribute("itemNo"));
}

function createInterPlanetaryRoute(fid,systemNode,src,dest)
{
  if (fid && src && dest && systemNode) {
    var route = sr_create_basic_element("line","id","proutei_"+fid,"class","fleetsRoutes");
    route.setAttribute("src_pid",src);
    route.setAttribute("dest_pid",dest);
    route.setAttribute("pointer-events","none");
    mSvgDoc.getElementById(systemNode).appendChild(route);
    masta.iMoves["proutei_"+fid]=window.setTimeout("updateInterPlanetaryRoute('proutei_"+fid+"')",500);
  }
}

function updateInterPlanetaryRoute(routeid)
{
  var route;
  var srcElem  = false;
  var destElem = false;
  var srcCTM;
  var destCTM;
  var srcPos;
  var destPos;
  
  try
  {
    route = mSvgDoc.getElementById(routeid);    
    if (route) {
      if (mSvg.getElementById(route.getAttribute("src_pid")))
        srcElem =mSvg.getElementById(route.getAttribute("src_pid"));      
      if (mSvg.getElementById(route.getAttribute("dest_pid")))
        destElem=mSvg.getElementById(route.getAttribute("dest_pid"));
      if (srcElem && destElem) {
        srcCTM=srcElem.getCTM();
        destCTM=destElem.getCTM();

        srcPos=new Array;
        srcPos[0]=srcCTM.a*srcElem.getAttribute("rhint");
        srcPos[1]=srcCTM.b*srcElem.getAttribute("rhint");

        destPos=new Array;
        destPos[0]=destCTM.a*destElem.getAttribute("rhint");
        destPos[1]=destCTM.b*destElem.getAttribute("rhint");

        route.setAttribute("x1",srcPos[0]);
        route.setAttribute("x2",destPos[0]);
        route.setAttribute("y1",srcPos[1]);
        route.setAttribute("y2",destPos[1]);
        masta.iMoves[routeid]=window.setTimeout("updateInterPlanetaryRoute('"+routeid+"')",200);
      }
    }
  }
  catch(e) {
    alert("updateInterPlanetaryRoute()::generate caused an error.\n"+e.name+"\n"+e.message);
  }
}

function checkInterplanetaryRoutes(routeContainer)
{
  var current;
  if (routeContainer && routeContainer.hasChildNodes())
  {
    current=routeContainer.firstChild;

    do
    {
      masta.iMoves[current.getAttribute("id")]=window.setTimeout("updateInterPlanetaryRoute('"+current.getAttribute("id")+"')",500);
      current=current.nextSibling;
    }
    while (current);
  }
}

function clearInterplanetaryRoutes()
{
  for (i in masta.iMoves)
    window.clearTimeout(masta.iMoves[i]);

  masta.iMoves=new Array;
}

function switch_mod(evt, fid) {
  evt.stopPropagation();
  var its_fleet = masta.cache.getFleet(fid);
  var val;
  
  if (its_fleet) {
    createLoadingAnimation();
    getURL("map_command.php?act=switch_mod&fid="+fid, its_fleet);
  }  
}

function showWarpRange(obj, x, y) {
  var i, j;
  var opa = 1;
  var wt, wc;
  x = Number(x);
  y = Number(y);
  var wr = sr_create_basic_element("g","pointer-events","none","id","userWarpRange");
  var wl = sr_create_line(x,y,x+masta.warprange,y, "colorOwnOutline");
  wr.appendChild(wl);
  
  for (i = masta.warprange, j = 1; i > 0; i -= 100, j++) {
    wc = sr_create_circle(x,y,i, "colorOwnOutline");
    wc.setAttribute("stroke-opacity", 1 / j);
    wt = sr_create_text(i, x+i, y-5, "fleetItemETA");
    wr.appendChild(wc);
    wr.appendChild(wt);
  }
  
  obj.appendChild(wr);
}

function hideWarpRange() {
  warpRange = mSvg.getElementById("userWarpRange");
  
  if (warpRange)
    warpRange.parentNode.removeChild(warpRange);
}