function SR_CLASS_FLEET(id,
                        name,
                        picture) {

  if (arguments.length > 0)
    this.init(id, name, picture);
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.init = function(id, name, picture) {
  this.id           = Number(id);
  this.name         = name;
  this.picture      = picture;
  this.sid          = false;
  this.pid          = false;
  this.tpid         = false;
  this.tsid         = false;

  this.mission      = false;
  this.missionSymbol= false;
  this.missionName  = false;

  this.tactic       = false;
  this.tacticSymbol = false;
  this.tacticName   = false;

  this.targetName   = false;
  this.eta          = false;
  this.reload       = false;

  this.infCount         = false;
  this.mod              = false;

  this.allianceName   = false;
  this.allianceColor  = false;
  this.allianceSymbol = false;


  this.soundConfirm = false;
  this.soundReport  = false;

  this.systemSystemJumps  = false;
  this.systemPlanetJumps  = false;
  this.PlanetPlanetJumps  = false;

  this.ships = new Array();
  this.controls = new Array();

  this.callBack = false;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setSid = function(sid) {
  this.sid = sid;
}
//---------------------------------------------------------------------------------------------------

SR_CLASS_FLEET.prototype.setPid = function(pid) {
  this.pid = pid;
}
//---------------------------------------------------------------------------------------------------
SR_CLASS_FLEET.prototype.setTsid = function(tsid) {
  this.tsid = tsid;
}
//---------------------------------------------------------------------------------------------------

SR_CLASS_FLEET.prototype.setTpid = function(tpid) {
  this.tpid = tpid;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setMission = function(mission, symbol, name) {
  this.mission        = Number(mission);
  this.missionSymbol  = symbol;
  this.missionName    = name;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setTactic = function(tactic, symbol, name) {
  this.tactic       = Number(tactic);
  this.tacticSymbol = symbol;
  this.tacticName   = name;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setSound = function(report, confirm) {
  if (report != 0)
    this.soundReport = report;

  if (confirm != 0)
    this.soundConfirm = confirm;
}
//---------------------------------------------------------------------------------------------------

SR_CLASS_FLEET.prototype.setInfCount = function(count) {
  this.infCount = Number(count);
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setMod = function(mod) {
  this.mod = mod;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setReload = function(reload) {
  this.reload = reload;
}
//---------------------------------------------------------------------------------------------------

SR_CLASS_FLEET.prototype.setAlliance = function(color, symbol, name) {
  this.allianceColor = color;
  this.allianceSymbol= symbol;
  this.allianceName  = name;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setTargetName = function(name) {
  this.targetName = name;
}
//---------------------------------------------------------------------------------------------------


SR_CLASS_FLEET.prototype.setEta = function(eta) {
  this.eta = Number(eta);
}
//---------------------------------------------------------------------------------------------------

SR_CLASS_FLEET.prototype.setShips = function(ships) {
  this.ships = ships;
}
//---------------------------------------------------------------------------------------------------

SR_CLASS_FLEET.prototype.say = function(type) {
  var whatToSay;
  switch (type) {
    case "REPORT":
      whatToSay = this.soundReport;
    break;
    case "CONFIRM":
      whatToSay = this.soundConfirm;
    break;
  }

  sr_play_audio(whatToSay, type);
}
//---------------------------------------------------------------------------------------------------


// COMMANDS
//***************************************************************************************************
SR_CLASS_FLEET.prototype.getCommands = function() {
  var commands = new Array();
  var i = 0;
  
  commands[i] = "FLEET_MOVE";
  
  if (this.canBomb())
    commands[++i] = "FLEET_BOMB";
  
  if (this.getColonyships() > 0) {
    commands[++i] = "FLEET_COLONIZE";
  }
    
  if (this.hasTransporters())
    commands[++i] = "FLEET_INVADE";
    
  return commands;
}

SR_CLASS_FLEET.prototype.move = function(targetType) {
  var targetId;
  
  try {
    switch (targetType) {
      case "planet":
        targetId = masta.currentTarget.parentNode.getAttribute("id").substring(1);
      break;
      case "system":
        targetId = masta.currentTarget.getAttribute("id").substring(1);
      break;
    }

    if (!targetId)
      throw new Error("invalid targetId!");
    else {
      var requestString = "map_command.php?act=move&fid="+this.id+"&targetId="+targetId+"&targetType="+targetType;

      // send command to server
      createLoadingAnimation();
      getURL(requestString, this);
    }
  }
  catch (e) {
    alert("SR_CLASS_FLEET::move() caused an error!\n"+e.name+"\n"+e.message);
  }
}


SR_CLASS_FLEET.prototype.colonize = function(targetType) {
  var targetId;
  
  try {
    switch (targetType) {
      case "planet":
        targetId = masta.currentTarget.parentNode.getAttribute("id").substring(1);
      break;
      case "system":
        throw new Error("Can't colonize stars! :S");
      break;
    }

    if (!targetId)
      throw new Error("invalid targetId!");
    else {
      var requestString = "map_command.php?act=colonize&fid="+this.id+"&targetId="+targetId+"&targetType="+targetType;
      // send command to server
      createLoadingAnimation();
      getURL(requestString, this);
    }
  }
  catch (e) {
    alert("SR_CLASS_FLEET::colonize() caused an error!\n"+e.name+"\n"+e.message);
  }
}


SR_CLASS_FLEET.prototype.bomb = function(targetType) {
  var targetId;

  try {
    switch (targetType) {
      case "planet":
        targetId = masta.currentTarget.parentNode.getAttribute("id").substring(1);
      break;
      case "system":
        throw new Error("Can't bomb stars! :S");
      break;
    }

    if (!targetId)
      throw new Error("invalid targetId!");
    else {
      var requestString = "map_command.php?act=bomb&fid="+this.id+"&targetId="+targetId+"&targetType="+targetType;
      // send command to server
      createLoadingAnimation();
      getURL(requestString, this);
    }
  }
  catch (e) {
    alert("SR_CLASS_FLEET::bomb() caused an error!\n"+e.name+"\n"+e.message);
  }
}


SR_CLASS_FLEET.prototype.invade = function(targetType) {
  var targetId;

  try {
    switch (targetType) {
      case "planet":
        targetId = masta.currentTarget.parentNode.getAttribute("id").substring(1);
      break;
      case "system":
        throw new Error("Can't invade stars! :S");
      break;
    }

    if (!targetId)
      throw new Error("invalid targetId!");
    else {
      var requestString = "map_command.php?act=invade&fid="+this.id+"&targetId="+targetId+"&targetType="+targetType;
      // send command to server
      createLoadingAnimation();
      getURL(requestString, this);
    }
  }
  catch (e) {
    alert("SR_CLASS_FLEET::invade() caused an error!\n"+e.name+"\n"+e.message);
  }
}


SR_CLASS_FLEET.prototype.change_tactic = function(callBack) {
  var requestString = "map_command.php?act=change_tactic&fid="+this.id+"&tactic="+this.tactic;

  this.callBack = callBack;

  // send command to server
  createLoadingAnimation();
  getURL(requestString, this);
}


//***************************************************************************************************
// general
//***************************************************************************************************
SR_CLASS_FLEET.prototype.operationComplete = function(request) {
  var XML_request;
  var requestType;
  destroyLoadingAnimation();
  if (request.success) {
    try {
      // debug
      //alert(request.content);
      
      if (this.callBack)
      {
        eval(this.callBack);
        this.callBack = false;
      }
      else
      {
        XML_request = parseXML(request.content);
        requestType = XML_request.firstChild.getAttribute("type");
        
        switch (requestType) {
          case "FLEET_ROUTE":
            this.generateRouteByXML(XML_request);
          break;
          case "MESSAGE":
            showMessage(XML_request.firstChild.firstChild.data);
          break;
          case "MOD":
            this.setMod(XML_request.firstChild.getAttribute("mod"));
            this.updateCorrespondingItem();
          break;
          default:
            throw new Error("unknown requestType: "+requestType+"\nrequest content:\n"+request.content);
          break;
        }
      }
    }
    catch (e) {
      alert("SR_CLASS_FLEET::operationComplete() caused an error!\n"+e.name+"\n"+e.message);
    }
  }
  else {
    masta.say("SERVER_FAILURE");
  }
}

SR_CLASS_FLEET.prototype.getShipCount = function()
{
  var count=0;
  for (i in this.ships)
  {
    count+=Number(this.ships[i][0]);
  }
  return count;
}

SR_CLASS_FLEET.prototype.getShipCountByTyp = function(typ) {
  var count = 0;

  for (i in this.ships)
  {
    if (this.ships[i][3] == typ)
      count+=Number(this.ships[i][0]);
  }

  return count;
}


SR_CLASS_FLEET.prototype.getMaxReload = function() {
  var its_reload = 0;
  var i;
  for (i in this.ships)
  {
    if (this.ships[i][1] > its_reload)
      its_reload = Number(this.ships[i][1]);
  }

  return its_reload;
}


SR_CLASS_FLEET.prototype.canBomb = function() {
  var bomb = false;
  var i;
  for (i in this.ships)
  {
    if (__prodInfo[i].sv_special == "B") {
      bomb = true;
      break;
    }
  }
  return bomb;
}


SR_CLASS_FLEET.prototype.hasTransporters = function() {
  var trans = false;
  var i;
  for (i in this.ships)
  {
    if (__prodInfo[i].pr_special == "T") {
      trans = true;
      break;
    }
  }
  return trans;
}


SR_CLASS_FLEET.prototype.getColonyships = function() {
  var count = 0;
  var i;
  
  for (i in this.ships)
  {
    if (__prodInfo[i].pr_special == "C") {
      count += Number(this.ships[i][0]);
    }
  }
  return count;
}


SR_CLASS_FLEET.prototype.updateCorrespondingItem = function() {
  var itemClass, i, j, k;
  var controlButtons;

  for (i = 0; i < masta.cache.itemBoxes.length; i++) {
    for (j = 0; j < masta.cache.itemBoxes[i].item.length; j++) {
      if (masta.cache.itemBoxes[i].item[j].oid == this.id) {
        itemClass = masta.cache.itemBoxes[i].item[j];
        controlButtons = itemClass.buttons;
        itemClass.destroyElement();
        itemClass.update();
        itemClass.buttons = controlButtons;
        itemClass.generate();
        
        if (masta.itemBox)
        for (k in masta.itemBox.item) {
          if (masta.itemBox.item[k].oid == this.id) {
            itemClass.show();
            masta.itemBox.itemContainer.appendChild(itemClass.itemElement);
            break;
          }
        }
        
        
        for (k in masta.selectedUnits) {
          if (masta.selectedUnits[k].oid == itemClass.oid) {
            itemClass.select(true);
            break;
          }
        }

        break;
      }
    }
  }  
}
//---------------------------------------------------------------------------------------------------


//***************************************************************************************************
// ROUTES
//***************************************************************************************************
SR_CLASS_FLEET.prototype.removeSystemSystemRoute = function() {

  var oldRoute = mSvgDoc.getElementById("route"+this.id);
  if (oldRoute) {
    oldRoute.parentNode.removeChild(oldRoute);
  }
}

SR_CLASS_FLEET.prototype.removeSystemPlanetRoute = function()
{
  var route;
 
  while (route=mSvg.getElementById("proute"+this.id))
    route.parentNode.removeChild(route);
}

SR_CLASS_FLEET.prototype.removePlanetPlanetRoute = function()
{
  var route;
 
  while (route=mSvg.getElementById("proutei_"+this.id))
  {
    window.clearTimeout(masta.iMoves["proutei_"+this.id]);
    masta.iMoves["proutei_"+this.id] = null;
    route.parentNode.removeChild(route);
  }
}

SR_CLASS_FLEET.prototype.drawSystemPlanetRoute = function(sid,pid)
{
  var route;
  var pnodeG;
  var pnode;
  
  pnodeG=mSvg.getElementById("p"+pid);
  if (pnodeG) {
    pnode=mSvg.getElementById("p"+pid+"s"+sid);
    route=sr_create_line(0,0,pnodeG.getAttribute("rhint")-pnode.getAttribute("r"),0,"fleetsRoutes");
    route.setAttribute("id","proute"+this.id);
    pnodeG.appendChild(route);
  }
}

SR_CLASS_FLEET.prototype.drawSystemSystemRoute = function() {
  var i;
  var newRoute;
  var pos;
  var currentStar;
  var newPathData="";
  
  for (i = 0; i < this.systemSystemJumps.length; i++) {
    currentStar = mSvgDoc.getElementById("s"+this.systemSystemJumps[i]);

    if (currentStar) {
      newPathData += currentStar.getAttribute("x");
      newPathData += ",";
      newPathData += currentStar.getAttribute("y");
      newPathData += "L";
    }
  }
  
  pos = mSvgDoc.getElementById("s"+this.sid);
  newPathData = newPathData.substr(0,(newPathData.length - 1));
  
  if (pos)
    newPathData = "M"+pos.getAttribute("x")+","+pos.getAttribute("y")+"L"+newPathData;
  else
    newPathData = "M"+newPathData;
  
  newRoute = sr_create_basic_element("path","d", newPathData,"pointer-events","none");
  newRoute.setAttribute("id", "route"+this.id);
  mSvgDoc.getElementById("flottenpfade").appendChild(newRoute);
  this.highlightRoute();
}


SR_CLASS_FLEET.prototype.drawPlanetPlanetRoute = function() {

}


SR_CLASS_FLEET.prototype.generateRouteByXML = function(XML_request) {
  var system_system_jumps = XML_request.getElementsByTagName("SR_ROUTE_SYSTEM");
  var system_planet_jumps = XML_request.getElementsByTagName("SR_ROUTE_SYSTEM_TO_PLANET");
  var planet_planet_jumps = XML_request.getElementsByTagName("SR_ROUTE_PLANET_TO_PLANET");
  var route_info          = XML_request.getElementsByTagName("SR_ROUTE_INFO").item(0);
  var i;
  
  // gleich mal die infos speichern
  this.sid        = Number(route_info.getAttribute("sid"));
  this.targetName = route_info.getAttribute("targetName");
  this.eta        = Number(route_info.getAttribute("eta"));
  this.mission        = Number(route_info.getAttribute("mission"));
  this.missionName    = route_info.getAttribute("missionName");
  this.missionSymbol  = route_info.getAttribute("missionSymbol");
    
  this.removeSystemSystemRoute();
  this.removeSystemPlanetRoute();
  this.removePlanetPlanetRoute();

  // wenn interplanetar, dann kann nicht insterstellar sein
  if (planet_planet_jumps.length > 0)
  {
    createInterPlanetaryRoute(this.id,"planets"+this.sid,"p"+planet_planet_jumps.item(0).getAttribute("pid1"),"p"+planet_planet_jumps.item(0).getAttribute("pid2"));
  }
  else
  {
    if (this.systemSystemJumps) {
      this.systemSystemJumps = false;
    }

    if (system_planet_jumps.length>0)
    {
      for (i=0;i<system_planet_jumps.length;i++)
        this.drawSystemPlanetRoute(system_planet_jumps.item(i).getAttribute("sid"),system_planet_jumps.item(i).getAttribute("pid"));
    }
    if (system_system_jumps.length > 0)
    {
      this.systemSystemJumps = new Array();
      for (i = 0; i < system_system_jumps.length; i++) {
        this.systemSystemJumps[i] = system_system_jumps.item(i).getAttribute("sid");
      }

      this.drawSystemSystemRoute();
    }
  }

  this.updateCorrespondingItem();
}


SR_CLASS_FLEET.prototype.highlightRoute = function() {
  var its_route = mSvgDoc.getElementById("route"+this.id);

  if (its_route)
    sr_set_class(its_route, "fleetsRoutesHighlight");
}

SR_CLASS_FLEET.prototype.delightRoute = function() {
  var its_route = mSvgDoc.getElementById("route"+this.id);

  if (its_route)
    sr_set_class(its_route, "fleetsRoutes");
}
//______________________________________________________________________________
