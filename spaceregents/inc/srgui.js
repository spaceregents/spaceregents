var baseWidth, baseHeight;
var system_Hud_Fleets, system_Hud_Alliances;
var baseWidth = window.innerWidth;
var baseHeight = window.innerHeight;
var starsMaxX, starsMaxY=0;
var starsMinX, starsMinY=1000000000;
var minimap_loaded = false;

function getPlanets(evt, force)
{
  var stern     = evt.target;
  var itsId     = stern.correspondingUseElement.id;
  displayPlanets(stern, itsId, force);
}


/**
 * displayPlanets - zeigt die planeten wirklich an
 * @param itsId - starid
 * @param force - reload erzwingen
 * @return
 */
function displayPlanets(stern, itsId,force)
{
  var sternId   = itsId.substr(1);
  if (system_Hud_Fleets)
    system_Hud_Fleets.setAttribute("display","inherit");

  if (system_Hud_Alliances)
    system_Hud_Alliances.setAttribute("display","inherit");

  if (mSvgDoc.getElementById("fleets_star_"+itsId))
  {
    system_Hud_Fleets = mSvgDoc.getElementById("fleets_star_"+itsId);
    system_Hud_Fleets.setAttribute("display","none");
  }

  if (mSvgDoc.getElementById("alliances_star_"+itsId))
  {
    system_Hud_Alliances = mSvgDoc.getElementById("alliances_star_"+itsId);
    system_Hud_Alliances.setAttribute("display","none");
  }

  if (force==1)
  {
    if (mSvgDoc.getElementById("planet"+masta.cache.currentPlanet))
      removeObject(mSvgDoc.getElementById("planet"+masta.cache.currentPlanet));
      
    masta.cache.removeItemBox(Number(masta.cache.currentPlanet.substr(1)));
    
    masta.cache.loadedSystemNodes[masta.cache.currentPlanet] = null;
    masta.cache.currentPlanet = false;
  }

  if (!masta.loadingSystems)
  {    
    // clearInterplanetaryRoutes();
    if (masta.cache.currentPlanet)
    {
      toHide = mSvgDoc.getElementById("planet"+masta.cache.currentPlanet);
      if (toHide)
        toHide.setAttribute("display","none");
    }

    masta.cache.currentPlanet = itsId;

    if (mSvgDoc.getElementById("planet"+masta.cache.currentPlanet))
    {
      var toShow = mSvgDoc.getElementById("planet"+masta.cache.currentPlanet);
      toShow.setAttribute("display","inherit");
      var sid = masta.cache.currentPlanet.substr(1);
      if (toShow.getAttribute("fogged")==0)
        checkInterplanetaryRoutes(mSvg.getElementById("iMoves"+sid));
      getURL("map_getdata.php?act=clickOnStar&sid="+sid,masta.itemBox = new ITEMBOX("clickOnStar", sid, "star"));
    }
    else
    {
      masta.loadingSystems = true;
      createLoadingAnimation(0,0);
      getURL("map_getplanets.php?sid="+sternId+"&availHeight="+baseHeight+"&availWidth="+baseWidth, postURLCallbackPlaneten);
    }
  }

}


/*********
*  postURLCallbackSterne(urlRequestStatus)
*********/
function postURLCallbackSterne(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    var new_obj = parseXML(urlRequestStatus.content,mSvgDoc);

    globalTranslate=/translate\(([0-9\-\.]+) ([0-9\-\.]+)\)/;
    globalTranslate.exec(new_obj.firstChild.getAttribute("transform"));

    masta.gStarsMinX=Number(RegExp.$1);
    masta.gStarsMinY=Number(RegExp.$2);

    coords= /<!-- ([0-9\.-]+) ([0-9\.-]+) ([0-9\.-]+) ([0-9\.-]+) -->/;
    coords.exec(urlRequestStatus.content);

    starsMinX=RegExp.$1;
    starsMaxX=RegExp.$2;
    starsMinY=RegExp.$3;
    starsMaxY=RegExp.$4;

    if (minimap_loaded == false)
    {
      mSvg.getElementById("sterne").appendChild(new_obj);
      loadMinimap();
    }
  }
  else if (masta.animations)
    createLoadingText("Access authorization failed!");

}

/*********
*  postURLCallbackPostLoadSterne(urlRequestStatus)
*********/
function postURLCallbackPostLoadSterne(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    var new_obj = parseXML(urlRequestStatus.content,mSvgDoc);

    coords= /<!-- ([0-9\.-]+) ([0-9\.-]+) ([0-9\.-]+) ([0-9\.-]+) -->/;
    coords.exec(urlRequestStatus.content);

    starsMinX=RegExp.$1;
    starsMaxX=RegExp.$2;
    starsMinY=RegExp.$3;
    starsMaxY=RegExp.$4;

    if (mSvg.getElementById('stars'))
      removeObject(mSvg.getElementById('stars'));
    if (mSvg.getElementById('flottenpfade'))
      removeObject(mSvg.getElementById('flottenpfade'));
    if (mSvg.getElementById('fleet_symbols'))
      removeObject(mSvg.getElementById('fleet_symbols'));
    if (mSvg.getElementById('fleet_scans'))
      removeObject(mSvg.getElementById('fleet_scans'));
    if (mSvg.getElementById('universe_temp_container'))
      removeObject(mSvg.getElementById('universe_temp_container'));

    mSvg.getElementById("startranslate").insertBefore(new_obj.firstChild,mSvg.getElementById("constellationgrid"));

    if (new_obj.firstChild)
    {
      iterator=new_obj.firstChild;

      while (append_g=iterator.nextSibling)
        mSvg.getElementById("startranslate").appendChild(append_g);
    }

    destroyLoadingAnimation();
    enable_screen(0);
  }
  else
    createInfoText("Failed to load new stars!","red");
}


/*********
*  postURLCallbackPlaneten(urlRequestStatus)
*********/
function postURLCallbackPlaneten(urlRequestStatus)
{
  var sid, new_obj, fogged;
  
  try {
    if (urlRequestStatus.success)
    {
      new_obj = parseXML(urlRequestStatus.content,mSvgDoc);
      destroyLoadingAnimation();
     
      fogged=new_obj.firstChild.getAttribute("fogged");
     
      mSvg.getElementById("sterne").appendChild(new_obj);
      masta.cache.loadedSystemNodes[masta.cache.currentPlanet] = 1;
      
      if (masta.cache.currentPlanet)
      {
        sid = masta.cache.currentPlanet.substr(1);
        if (fogged==0)
          checkInterplanetaryRoutes(mSvg.getElementById("iMoves"+sid));
        try
        {
        masta.itemBox=new ITEMBOX("clickOnStar", sid, "star");
        }
        catch(e)
        {
          alert(")>"+e.message+masta.itemBox);
        }
        getURL("map_getdata.php?act=clickOnStar&sid="+sid,masta.itemBox);
      }
    }
    else    createInfoText("Failure!","red");
  }
  catch(e) {
    alert("postURLCallbackPlaneten caused en error:\n"+e.name+"\n"+e.message);
  }
  finally {
    masta.loadingSystems = false;
  }
}

/*********
*  loadMap()
*********/
function loadMap()
{
  if (masta.animations)
    createLoadingText("Checking access authorization");
  getURL("map_getstarmap.php?act=startup&availHeight="+window.innerHeight+"&availWidth="+window.innerWidth+"&positionX=0&positionY=0",postURLCallbackSterne)
}


/*********
*  loadDefinitions()
*********/
function loadDefinitions()
{
  x = Number(window.innerWidth) / 2 - 50;
  y = Number(window.innerHeight) / 2 - 50;
  if (masta.animations)
  {
    createLoadingAnimation(x,y);
    createLoadingText("Establishing satellite uplink",x+50,y+120);
  }
  getURL("map_getdefinitions.php",postURLCallbackDefinitions)
}

/*********
*  postURLCallbackDefinitions(urlRequestStatus)
*********/
function postURLCallbackDefinitions(urlRequestStatus)
{
  //alert("content: "+urlRequestStatus.success);
  if (urlRequestStatus.success)
  {
    var new_obj = parseXML(urlRequestStatus.content,mSvgDoc);
    mSvgRoot.appendChild(new_obj);
    new_obj   = null;
    loadMap();                   // hier werden die sterne geladen
  }
  else if (masta.animations)
  {
    createLoadingText("Error: Server not reachable");
    destroyLoadingAnimation();
  }
}


/*********
*  highlight(mode)
*********/
function highlight(evt, mode)
{
  obj = evt.target;
  if (mode == 0)
    obj.getStyle().setProperty("fill-opacity",0.5);
  else
    obj.getStyle().setProperty("fill-opacity",1);
}

/*************************
* minimap_focus(evt)
**************************/
function minimap_focus(evt)
{
  positionRect = masta.minimap.positionRect;
  posX=Number(positionRect.getAttribute("x"));
  posY=Number(positionRect.getAttribute("y"));
  // mop: rel. clickposition von rechts (auf start minimap) bezogen)
  clickXRel=evt.clientX-(masta.minimap.x);
  clickYRel=evt.clientY-(masta.minimap.y);

  new_x=(clickXRel-posX)*masta.minimap.transform;
  new_y=(clickYRel-posY)*masta.minimap.transform;

  masta.map_focus_to(new_x,new_y);
}

function doStarsPostLoad(new_x,new_y)
{
  disable_screen();

  newLocation = "map_getstarmap.php?act=postload_stars&availHeight="+window.innerHeight+"&availWidth="+window.innerWidth+"&x="+new_x+"&y="+new_y;
  createLoadingAnimation(0,0);
  getURL(newLocation,postURLCallbackPostLoadSterne);
}

function snapshot()
{
  alert("snapshotting....");
  postURL("snapshot.php",encodeURIComponent(printNode(fSvg)),dummypost,"image/svg+xml",null);
}

function dummypost(status)
{
  if (status.success)
  {
    alert(status.content);
    alert("...done");
  }
  else
    alert("failed");
}
