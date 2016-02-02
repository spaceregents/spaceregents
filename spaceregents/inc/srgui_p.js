/*********
*  postURLCallbackRoutes(urlRequestStatus)
*********/
function postURLCallbackRoutes(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    if (urlRequestStatus.content.length>0)
    {
      var new_obj = parseXML(urlRequestStatus.content,pSvgDoc);

      if (mSvgDoc.getElementById("route"+new_obj.firstChild.getAttribute("id").substr(5)))
        removeObject(mSvgDoc.getElementById("route"+new_obj.firstChild.getAttribute("id").substr(5)));

      if (mSvgDoc.getElementById("proute"+new_obj.firstChild.getAttribute("id").substr(5)))
        removeObject(mSvgDoc.getElementById("proute"+new_obj.firstChild.getAttribute("id").substr(5)));

      if (mSvgDoc.getElementById("planet"+fleetSystem))
      {
        removeObject(mSvgDoc.getElementById("planet"+fleetSystem));
      }

      destroyLoadingAnimation();
      mSvg.getElementById("flottenpfade").appendChild(new_obj);
      new_obj   = null;
      createInfoText("Orders received","lime");
      displayPlanets(currentPlanets,1);
    }
    else
    {
      createInfoText("Can NOT execute Order: Target may be too far away!","red");
    }
  }
  else
  {
    createInfoText("Failure setting new Route!","red");
  }
        clearUnitsDisplay();
}

/*********
*  postURLCallbackStarRoutes(urlRequestStatus)
*********/
function postURLCallbackStarRoutes(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    var new_obj = parseXML(urlRequestStatus.content,pSvgDoc);

    if (mSvgDoc.getElementById("route"+new_obj.firstChild.getAttribute("id").substr(5)))
      removeObject(mSvgDoc.getElementById("route"+new_obj.firstChild.getAttribute("id").substr(5)));

    if (mSvgDoc.getElementById("proute"+new_obj.firstChild.getAttribute("id").substr(5)))
      removeObject(mSvgDoc.getElementById("proute"+new_obj.firstChild.getAttribute("id").substr(5)));

    destroyLoadingAnimation();
    mSvg.getElementById("flottenpfade").appendChild(new_obj);
    new_obj   = null;
  }
  else
    createInfoText("Failure setting new Route!","red");
}

/*********
*  postURLCallbackJumps(urlRequestStatus)
*********/
function postURLCallbackJumps(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    alert(urlRequestStatus.content);
    switch (urlRequestStatus.content)
    {
      case "no":
        createInfoText("Couldn't jump!","red");
        break;
      case "bug":
        createInfoText("Critical error. This is a bug :(!","red");
        break;
      case "same":
        createInfoText("Please select a different Jumpgate than the startjumpgate!","red");
        break;
      case "max_tonnage":
        createInfoText("Maximum Tonnage exceeded!","red");
        break;
      case "not_yours":
        createInfoText("One of the Jumpgates doesn't belong to your empire!","red");
        break;
      case "success":
        createInfoText("Your fleet has successfully jumped!","lime");
        break;
    }
    destroyLoadingAnimation();
    displayPlanets(currentPlanets,1);
  }
  else
    createInfoText("Critical error. This is a bug :(!","red");
}


/*********
*  postURLCallbackMinimap(urlRequestStatus)
*********/
function postURLCallbackMinimap(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    var new_obj = parseXML(urlRequestStatus.content,pSvgDoc);
//    pSvgDoc.getElementById("minimap_rahmen").appendChild(new_obj);
    minimap_loaded = true;

    coords= /<!-- ([0-9\.-]+) ([0-9\.-]+) -->/;
    coords.exec(urlRequestStatus.content);
    masta.gStarsMaxX=Number(RegExp.$1)+masta.gStarsMinX;
    masta.gStarsMaxY=Number(RegExp.$2)+masta.gStarsMinY;
    
    masta.minimapWindow=new SR_CLASS_WINDOW("minimapWindow", masta.minimap.x, masta.minimap.y, masta.minimap.size + 20, masta.minimap.size+20, "Minimap", false,false);
    try
    {
      masta.minimapWindow.generate();
    }
    catch(e)
    {
      alert(e.message+" "+masta.minimapWindow.generate);
    }
    masta.minimapWindow.addRawContent(new_obj.firstChild);

    var g;
    var circle;
    var showflagsPlanet = new Array();
    var showflagsShip   = new Array();
    var colors          = new Array();
    var colors2         = new Array();
    var i, j, x, y, r;
    var shipSymbol, planetSymbol;
    var resetButton, homeButton;
    var my_minimap;

    showflagsPlanet[0] = "Toggle own planets";
    showflagsPlanet[1] = "Toggle allied planets";
    showflagsPlanet[2] = "Toggle friendly planets";
    showflagsPlanet[3] = "Toggle neutral planets";
    showflagsPlanet[4] = "Toggle enemy planets";

    showflagsShip[0] = "Toggle own fleets";
    showflagsShip[1] = "Toggle allied fleets";
    showflagsShip[2] = "Toggle friendly fleets";
    showflagsShip[3] = "Toggle neutral fleets";
    showflagsShip[4] = "Toggle enemy fleets";

    colors[0]="gROwn";
    colors[1]="gRAllied";
    colors[2]="gRFriend";
    colors[3]="gRNeutral";
    colors[4]="gREnemy";

    colors2[0]="colorOwnOutlineDisabled";
    colors2[1]="colorAlliedOutlineDisabled";
    colors2[2]="colorFriendOutlineDisabled";
    colors2[3]="colorNeutralOutlineDisabled";
    colors2[4]="colorEnemyOutlineDisabled";

    shipSymbol    = sr_create_use("button_face_ship",masta.minimap.size,5, "mapGUIButtonFace");
    planetSymbol  = sr_create_image("arts/O_small.gif",4,masta.minimap.size + 4, 12, 12);

    masta.minimapWindow.addRawContent(sr_create_rect(-2,(masta.minimap.size+masta.minimapWindow.titleHeight-20+6),masta.minimapWindow.width,20,"mapGUIWindowTitleRect",masta.minimapWindow.border,masta.minimapWindow.border));
    masta.minimapWindow.addRawContent(sr_create_rect(masta.minimap.size-2, 0,20,masta.minimapWindow.height, "mapGUIWindowTitleRect",masta.minimapWindow.border,masta.minimapWindow.border));
    masta.minimapWindow.addRawContent(shipSymbol);
    masta.minimapWindow.addRawContent(planetSymbol);

    r = 5;    // button radius

    // planets
    y = masta.minimap.size + (masta.minimapWindow.titleHeight / 2) + 2.5;
    for (i = 0, j = 0; i < showflagsPlanet.length; i++, j++) {
      x = i * 15 + i + 25;

      g = sr_create_element("g");
      sr_add_status_text(g,showflagsPlanet[i]);
      g.setAttribute("id","gFlag"+j);
      g.setAttribute("cursor","pointer");
      g.setAttribute("onclick", "masta.minimap.handleEvent(evt)");
      
      circle = sr_create_circle(x, y, r, colors2[i]);
      g.appendChild(circle);

      //circle = sr_create_circle(x, y, r, colors[i]);
      circle = sr_create_circle(x, y, r,"");
      circle.setAttribute("fill","url(#"+colors[i]+")");
      circle.setAttribute("id","showflag"+j);
      g.appendChild(circle);

      masta.minimapWindow.addRawContent(g);
    }

    // fleets
    x = masta.minimap.size + 8;
    for (i = 0; i < showflagsPlanet.length; i++, j++) {
      y = 32 + (i * 15);

      g = sr_create_element("g");
      sr_add_status_text(g,showflagsShip[i]);
      g.setAttribute("id","gFlag"+j);
      g.setAttribute("cursor","pointer");
      g.addEventListener("click",masta.minimap,true);

      circle = sr_create_circle(x, y, r, colors2[i]);
      g.appendChild(circle);

      circle = sr_create_circle(x, y, r,"");
      circle.setAttribute("fill","url(#"+colors[i]+")");
      circle.setAttribute("id","showflag"+j);
      g.appendChild(circle);

      masta.minimapWindow.addRawContent(g);
    }

    // reset button
    var resetImage = sr_create_image("arts/minimap_reset_btn.svgz", masta.minimap.size + 1, masta.minimap.size + 3, 16, 16);

    resetButton = sr_create_element("g");
    resetButton.setAttribute("id","minimap_resetBtn");
    sr_add_status_text(resetButton, "Reset minimap zoom");
    resetButton.setAttribute("cursor","pointer");
    resetButton.setAttribute("onclick", "masta.minimap.handleEvent(evt)");
    resetButton.appendChild(resetImage);
    masta.minimapWindow.addRawContent(resetButton);

    // home button
    var homeImage = sr_create_image("arts/minimap_home_btn.svgz", masta.minimap.size -18, masta.minimap.size + 3, 16, 16);
    homeImage.setAttribute("id","minimap_homeBtn");

    homeButton = sr_create_element("g");
    sr_add_status_text(homeButton, "Jump to your homesystem");
    homeButton.setAttribute("cursor","pointer");
    homeButton.setAttribute("onclick","masta.map_focus_to("+(Number(window.innerWidth)/2)+","+(Number(window.innerHeight) / 2)+");");
    homeButton.appendChild(homeImage);
    masta.minimapWindow.addRawContent(homeButton);


    masta.addWindow(masta.minimapWindow);

    my_minimap = mSvg.getElementById("minimap");
    my_minimap.setAttribute("onclick","masta.minimap.handleEvent(evt)");
    my_minimap.setAttribute("onmousedown","masta.minimap.handleEvent(evt)");
    my_minimap.setAttribute("onmousemove","masta.minimap.handleEvent(evt)");
    my_minimap.setAttribute("onmouseover","masta.minimap.handleEvent(evt)");
    my_minimap.setAttribute("onmouseout","masta.minimap.handleEvent(evt)");

    masta.minimap.y+=masta.minimapWindow.titleHeight;
    masta.minimap.x+=masta.minimapWindow.border;
    
    masta.minimap.originalCTM = pSvgDoc.getElementById("minimap").getCTM();
    synchronizeClock();
    if (masta.animations)
    {
      destroyLoadingAnimation();
      destroyLoadingText();
      pSvg.removeChild(pSvgDoc.getElementById("loadingBlackRect"));
      //removeObject(pSvgDoc.getElementById("loadingBlackRect"));
    }
    masta.initSecondaryValues();
  }
  else if (masta.animations)
    createLoadingText("Galaxy Empire Network is not reachable!");
}

/*********
*  loadMinimap()
*********/
function loadMinimap()
{
  if (masta.animations)
    createLoadingText("Connecting to Galaxy Empire Network!");
   
  getURL("map_getminimap.php?size="+masta.minimap.size,postURLCallbackMinimap);
}
