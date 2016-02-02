/* This file is part of SPACE REGENTS (http://www.spaceregents.de)
   You must not copy or reuse this code without prior confirmation of one of the SPACE REGENTS developers.
   You must not reuse any code of this file in a commercial or public matter.
   Though, feel free to learn from the code.

   Also, manipulating the code will be useless, since everything is being validated serverside. =P

   Erik Oey & Andreas Streichardt
*/

function SR_CLASS_MASTA(animations, autoUpdate, volume,minimap) {
  if (arguments.length > 0)
    this.init(animations, autoUpdate, volume,minimap);
}
//-----------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.init = function(animations, autoUpdate, volume, minimap) {
  this.animations       = animations;
  this.autoUpdate       = autoUpdate;
  this.scrollSpeed      = 75;
  this.volume           = volume;
  this.animationsPaused = false;

  this.mapAntiAliasing  = true;
  this.guiAntiAliasing  = true;

  this.selectedUnits    = new Array();
  this.currentCommands  = new Array();

  this.buttons          = new Array();
  this.currentTarget    = false;

  this.mapTransformX    = 0;
  this.mapTransformY    = 0;

  this.itemBox       = null;
  this.minimap       = minimap;
  this.minimapWindow = false;
  this.cache         = new SR_CLASS_CACHE();
  this.windows       = new Array();
  this.hookedWindow  = false;        // stores the window (index) currently hooked to mouse
  this.currentSystem = false;
  this.gStarsMinX    = 0;
  this.gStarsMinY    = 0;
  this.gStarsMaxX    = 0;
  this.gStarsMaxY    = 0;
  this.iMoves        = Array();
  this.sJumpGate     = false;
  this.tJumpGate     = false;
  this.containers    = Array();
  this.loadingSystems= false;
  this.warprange     = false;

  this.infTransfer   = false;

  this.zeitEinheit   = " ticks";
  
  this.keysPressed   = new Array();   // speichert welche tasten gedrueckt sind
}
//-----------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------

SR_CLASS_MASTA.prototype.initSecondaryValues = function() {

  this.minimap.positionRect     = pSvgDoc.getElementById("positionRect");

  if (!this.minimap.positionRect)
  {
    alert("Could not find the minimaps positionrect!");
  }

  fSvg.addEventListener("keydown",registerKeyDown, false);
  fSvg.addEventListener("keyup",registerKeyUp, false);
}
//-----------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.scroll = function(direction)
{
  newX=this.mapTransformX+baseWidth/2;
  newY=this.mapTransformY+baseHeight/2;

  switch (direction)
  {
    case 1:
      newY += -this.scrollSpeed;
    break;
    case 2:
      newY += -this.scrollSpeed;
      newX += this.scrollSpeed;
    break;
    case 3:
      newX += this.scrollSpeed;
    break;
    case 4:
      newY += this.scrollSpeed;
      newX += this.scrollSpeed;
    break;
    case 5:
      newY += this.scrollSpeed;
    break;
    case 6:
      newY += this.scrollSpeed;
      newX += -this.scrollSpeed;
    break;
    case 7:
      newX += -this.scrollSpeed;
    break;
    case 8:
      newY += -this.scrollSpeed;
      newX += -this.scrollSpeed;
    break;
  }

  this.map_focus_to(newX,newY);
}

SR_CLASS_MASTA.prototype.map_focus_to = function(new_x,new_y)
{
  var posRectX;
  var posRectY;
  var posRectXRight;
  var posRectYBottom;

  if (this.currentPlanets) {
    mSvg.getElementById("planet"+this.currentPlanets).setAttribute("display","none");
  }

  //mSvg.setAttribute("shape-rendering","optimizeSpeed");

  // position rect in richtige position bringen
  this.mapTransformX = new_x  - (baseWidth/2);
  this.mapTransformY = new_y - (baseHeight/2);

  this.minimap.positionRect.setAttribute("transform","translate("+ (this.mapTransformX) +" "+(this.mapTransformY)+")");

  mSvg.setAttribute("viewBox", this.mapTransformX+" "+this.mapTransformY+" "+window.innerWidth+" "+window.innerHeight);

  posRectX      =Number(this.mapTransformX);
  posRectY      =Number(this.mapTransformY);
  posRectXRight =posRectX+window.innerWidth;
  posRectYBottom=posRectY+window.innerHeight;

  if (posRectX < starsMinX || posRectXRight > starsMaxX || posRectY < starsMinY || posRectYBottom > starsMaxY)
  {
    if (posRectX >= this.gStarsMinX && posRectY >= this.gStarsMinY && posRectXRight <= this.gStarsMaxX && posRectYBottom <= this.gStarsMaxY)
    {
      if (!check_screen())
      {
        doStarsPostLoad(new_x,new_y);
      }
    }
  }

  if (this.currentPlanets)
    mSvg.getElementById("planet"+this.currentPlanets).setAttribute("display","inherit");
}
//-----------------------------------------------------------------------------------------------------


//*************************************************************************************************
// COMMANDS
//*************************************************************************************************
SR_CLASS_MASTA.prototype.getCurrentCommands = function(commandTarget) {
  var i, j;
  var currentCommands = new Array();
  var allCommands     = new Array();
  var oldCommand;

  for (i = 0; i < this.selectedUnits.length; i++){
    allCommands = allCommands.concat(this.selectedUnits[i].itemClass.fleet.getCommands());
  }

  // doppelte rausfiltern
  allCommands.sort();

  // extrem cheap filter lol
  for (i = 0, j=0; i < allCommands.length; i++) {
    if (allCommands[i] != oldCommand) {
      oldCommand        = allCommands[i];
      if (allCommands[i] = is_valid_command(commandTarget, allCommands[i])) {
        currentCommands[j] = allCommands[i];
        j++;
      }
    }
  }

  this.currentCommands = currentCommands;

  return currentCommands;
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.generateCommands = function(commandTarget, evtScreenX, evtScreenY, targetType) {
  var i;
  var newCmdBtn;
  var x, y;
  var newAction;
  var newDescription;
  var newFace;
  var newWindowTitle = new Array();   // must be Array, because of regexp
  var newWindowWidth;
  var newWindowHeight = 40;
  var currentCommands;

  var regExpr;

  var baseX = - 15;
  var baseY = 20;

  if (this.freeCommands())
  try {
    currentCommands = this.getCurrentCommands(commandTarget);

    if (targetType == "star") {
      x = evtScreenX;
      y = evtScreenY;
    }
    else {
      var cx = commandTarget.parentNode.getElementsByTagName("circle").item(0).getAttribute("cx");
      var cy = commandTarget.parentNode.getElementsByTagName("circle").item(0).getAttribute("cy");
      matrix = commandTarget.getTransformToElement(commandTarget.parentNode.parentNode);
      x= matrix.a * cx + matrix.c * cy + matrix.e;
      y= matrix.b * cx + matrix.d * cy + matrix.f;
    }


    if (currentCommands.length > 0) {
      // delete old command window, if exists
      if (this.window)
      {
        this.windows["commandWindow"].destroy();
        delete this.windows["commandWindow"];
      }

      // ziel markieren
      if (targetType == "star") {
        this.currentTarget = commandTarget;
        newWindowTitle[1] = commandTarget.parentNode.nextSibling.childNodes.item(sr_get_element_index(commandTarget)).firstChild.firstChild.data;
      }
      else {
        this.currentTarget = commandTarget.getElementsByTagName("circle").item(0);
        regExpr = /^updateStatusText\W\W(.+)\W\W./;
        newWindowTitle = regExpr.exec(commandTarget.getElementsByTagName("image").item(0).getAttribute("onmouseover"));
      }

      this.markTarget();

      // window width
      (currentCommands.length * 35) > (newWindowTitle[1].length * 8) ? (newWindowWidth = currentCommands.length * 35) : (newWindowWidth = newWindowTitle[1].length * 8);

      // reposition if window is partly hidden
      // check on x
      if (newWindowWidth + evtScreenX + 15 > window.innerWidth - 200) {
        x = x - ((newWindowWidth + evtScreenX + 15) - (window.innerWidth - 200));
      }

      // check on y
      if (newWindowHeight + evtScreenY + 15 > window.innerHeight - 40) {
        y = y - ((newWindowHeight + evtScreenY + 15) - (window.innerHeight - 40)) - 30;
      }

      // debug: alert(x+":"+y+"--"+newWindowWidth+":"+newWindowHeight+"  "+newWindowTitle[1]);
      this.windows["commandWindow"] = new SR_CLASS_WINDOW("commandWindow", x + baseX, y + baseY, newWindowWidth, newWindowHeight, newWindowTitle[1], true,true);
      this.windows["commandWindow"].generate();

      for (i = 0; i < currentCommands.length; i++) {

        newAction       = "sr_executeCommand(evt,'"+String(currentCommands[i])+"')";
        newFace         = this.getCommandButtonFace(currentCommands[i]);
        newDescription  = this.getCommandButtonDescription(currentCommands[i]);

        this.windows["commandWindow"].addButton( 2.5 + (i*35), 20, "BUTTON_CIRCLE_BIG", newFace, newAction,newDescription, 0);
      }

      if (targetType == "star") {
        pSvg.appendChild(this.windows["commandWindow"].element);
      }
      else
        commandTarget.parentNode.parentNode.appendChild(this.windows["commandWindow"].element);
    }
  }
  catch(e) {
    alert("SR_CLASS_MASTA::generateCommands caused an error!\n"+e.name+"\n"+e.message);
  }
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.freeCommands = function() {
  var i;

  try {
    this.unmarkTarget();

    if (this.windows["commandWindow"]) {
      this.windows["commandWindow"].destroy();
      delete this.windows["commandWindow"];
      this.windows["commandWindow"] = false;
    }
  }
  catch(e) {
    sr_resume_animation();
    alert("SR_CLASS_MASTA::freeCommands caused an error!\n"+e.name+"\n"+e.message);
  }

  return true;
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.getCommandButtonDescription = function(command) {
  var desc;

  switch (command) {
    case "FLEET_MOVE":
      desc = "Move here!";
    break;
    case "FLEET_DEFEND":
      desc = "Defend this planet!";
    break;
    case "FLEET_ATTACK":
      desc = "Attack here!";
    break;
    case "FLEET_INVADE":
      desc = "Invade here!";
    break;
    case "FLEET_COLONIZE":
      desc = "Colonize this planet!";
    break;
    case "FLEET_BOMB":
      desc = "Bomb this planet!";
    break;
    default:
      desc = "no description for "+command;
    break;
  }

  return desc;
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.getCommandButtonFace = function(command) {
  var face;

  switch (command) {
    case "FLEET_MOVE":
      face = "arts/fleet_mission_move.svgz";
    break;
    case "FLEET_DEFEND":
      face = "arts/fleet_mission_defend.svgz";
    break;
    case "FLEET_ATTACK":
      face = "arts/fleet_mission_attack.svgz";
    break;
    case "FLEET_INVADE":
      face = "arts/fleet_mission_invade.svgz";
    break;
    case "FLEET_COLONIZE":
      face = "arts/fleet_mission_colonize.svgz";
    break;
    case "FLEET_BOMB":
      face = "arts/fleet_mission_bomb.svgz";
    break;
    default:
      face = "none";
    break;
  }

  return face;
}


//*************************************************************************************************
// selectedUnits
//*************************************************************************************************
SR_CLASS_MASTA.prototype.addSelected = function(evt) {
  var newSelected;
  var selectedLength = this.selectedUnits.length;
  var itemClass;
  var itemCaller = evt.target.parentNode;
  var i;
  var alreadySelected;

  if (evt.button == 0 && itemCaller!=null && itemCaller.nodeName == "g" && !this.windows["commandWindow"]) {

    itemClass = this.itemBox.item[Number(itemCaller.getAttribute("itemNo"))];

    // wurde shift gedrueckt? dann neues element hinzufuegen oder entfernen, ansonsten ganz neue liste anlegen
    if (evt.shiftKey) {
      if (itemClass.selected) {
        //itemClass.select()
        this.removeSelected(itemClass.oid);
      }
      else {
        itemClass.select(true)
        itemClass.fleet.say("REPORT");
        newSelected = new SR_CLASS_SELECTED(itemClass.picture, itemClass.description, this.selectedUnits.length, itemClass);
        newSelected.generate();
        newSelected.show();
        this.selectedUnits[this.selectedUnits.length] = newSelected;
      }
    }
    else
    {
      itemClass.fleet.say("REPORT");
      this.removeSelected("all");
      itemClass.select(true)
      newSelected = new SR_CLASS_SELECTED(itemClass.picture, itemClass.description, 0, itemClass);
      newSelected.generate();
      newSelected.show();
      this.selectedUnits[0] = newSelected;
    }
  }
  this.updateTacticPanel();
}
//-------------------------------------------------------------------------------------------------



SR_CLASS_MASTA.prototype.removeSelected = function(oid) {
  var i, j;
  var newSelectedArray = new Array();

  if (oid == "all") {
    for (i = (this.selectedUnits.length-1); i >= 0; i--) {
      this.selectedUnits[i].itemClass.select(false);
      this.selectedUnits[i].element.removeEventListener("click",this.selectedUnits[i], true);
      this.selectedUnits[i].destroy();
      this.selectedUnits[i] = null;
      this.selectedUnits.pop();
    }
  }
  else {
    for (i = 0, j = 0; i < this.selectedUnits.length; i++) {
      this.selectedUnits[i].element.removeEventListener("click",this.selectedUnits[i], true);
      this.selectedUnits[i].destroy();
      if (this.selectedUnits[i].oid != oid) {
        newSelectedArray[j] = this.selectedUnits[i];
        newSelectedArray[j].itemNo = j;
        newSelectedArray[j].element.setAttribute("itemNo", j);
        j++;
      }
      else
      {
        this.selectedUnits[i].itemClass.select(false);
        this.selectedUnits[i].itemClass = null;
        delete this.selectedUnits[i];
      }
    }

    this.selectedUnits = newSelectedArray;
    this.redrawSelected();
  }
  this.updateTacticPanel();
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.removeAllSelectedBut = function(selectedItem) {
  var newSelectedArray = new Array(selectedItem);
  var i;

  for (i in this.selectedUnits) {
    this.selectedUnits[i].itemClass.select(false);
    this.selectedUnits[i].destroy();
    delete this.selectedUnits[i];
  }
  this.selectedUnits = null;

  selectedItem.itemNo = 0;
  this.selectedUnits = newSelectedArray;
  this.selectedUnits[0].itemClass.select(true);
  this.redrawSelected();
  this.updateTacticPanel();
}



SR_CLASS_MASTA.prototype.redrawSelected = function() {
  var i;
  selectedBaseX = 20;
  selectedBaseY = 45;

  for (i = 0; i < this.selectedUnits.length; i++) {
    this.selectedUnits[i].generate();
    this.selectedUnits[i].show();
  }
}
//-------------------------------------------------------------------------------------------------

SR_CLASS_MASTA.prototype.updateTacticPanel = function()
{
  if (this.windows["tacticPanel"])
  {
    this.windows["tacticPanel"].destroy();
    delete this.windows["tacticPanel"];
  }

  if(this.selectedUnits.length > 0)
  {
    var panel_width=220;
    var panel_height=40;
    var panel_x = (Number(window.innerWidth) / 2) - (panel_width / 2);
    var panel_y = Number(window.innerHeight) - panel_height - 20;
    var button_face;
    var button_desc;

    this.windows["tacticPanel"]=new SR_CLASS_WINDOW("tacticPanel",100,100,panel_width,panel_height,"Choose Tactic",true,false);
    this.windows["tacticPanel"].generate();

    var j = 0;
    var opacity_step=0.5/this.selectedUnits.length;

    for (tactic in __tactics)
    {
      //opacity=0.5;

      button_face = "arts/fleet_tactic_"+tactic+".svgz";
      button_desc = get_tactics_description(tactic);

      for (i = 0; i < this.selectedUnits.length; i++)
      {
        if (this.selectedUnits[i].itemClass.fleet.tactic & __tactics[tactic])
        {
          // opacity+=opacity_step;
          button_face = "arts/fleet_tactic_"+tactic+"2.svgz";
        }
      }
      //btn.setOpacity(opacity);
      btn=new SR_CLASS_BUTTON(this.windows["tacticPanel"].getButtons().length,5+(j++)*35,20,"BUTTON_CIRCLE_BIG",button_face,"sr_change_tactic(evt,"+__tactics[tactic]+")",button_desc, 0);
      this.windows["tacticPanel"].addFinishedButton(btn);
    }

    pSvg.appendChild(this.windows["tacticPanel"].element);
  }
}
//*************************************************************************************************
// infantry transfer related
//*************************************************************************************************
SR_CLASS_MASTA.prototype.createInfTransfer = function(itsClass)
{
  var newTransfer;

  if (this.infTransfer) {
    this.infTransfer.destroy();
    this.infTransfer = null;
  }

  this.infTransfer = new SR_CLASS_INF_TRANSFER(itsClass);

  createLoadingAnimation();
  getURL("map_inf_transfer.php?act=transfer&fid="+itsClass.fleet.id+"&pid="+itsClass.fleet.pid, this.infTransfer);
}


//*************************************************************************************************
// window related
//*************************************************************************************************
SR_CLASS_MASTA.prototype.closeWindow = function(windowNo) {
  var i;
  if (windowNo == "fManage")
    this.containers["fManage"] = null;

  if (windowNo == "infTransfer") {
    this.infTransfer.destroy();
    this.infTransfer = null;
  }
  else
  if (windowNo == "commandWindow") {
    sr_resume_animation();
    this.freeCommands();
  }
  else
  {
    this.windows[windowNo].destroy();
    if (windowNo == this.windows.length - 1) {
      var garbage = this.windows.pop();
    }
    else {
      delete this.windows[windowNo];
    }
  }
}

SR_CLASS_MASTA.prototype.iconifyWindow = function(windowNo)
{
  var current = this.windows[windowNo].content.getAttribute("display");
  if (current=="inline")
  {
    mSvg.getElementById("bgrect_"+windowNo).setAttribute("display","none");
    this.windows[windowNo].content.setAttribute("display","none");
  }
  else
  {
    mSvg.getElementById("bgrect_"+windowNo).setAttribute("display","inline");
    this.windows[windowNo].content.setAttribute("display","inline");
  }
}


SR_CLASS_MASTA.prototype.addWindow = function(newWindow) {
  this.windows[newWindow.windowNo] = newWindow;
  this.windows[newWindow.windowNo].generate();
  pSvg.appendChild(this.windows[newWindow.windowNo].element);
}


SR_CLASS_MASTA.prototype.getWindowCount = function() {
  return this.windows.length;
}


SR_CLASS_MASTA.prototype.setHookedWindow = function(windowIndex) {
  this.hookedWindow = windowIndex;
}

// gibt windowNo bei gefunden zurueck, sonst false
SR_CLASS_MASTA.prototype.findWindowByTag = function(tag) {
  var i = Number(this.windows.length);
  var found = false;

   for (var windowIndex in this.windows) {
    if (this.windows[windowIndex].tag == tag) {
      found = this.windows[windowIndex].windowNo;
      break;
    }
  }

  return found;
}

SR_CLASS_MASTA.prototype.addContainer = function(name, obj) {
    this.containers[name] = obj;
}

//*************************************************************************************************
// general
//*************************************************************************************************
SR_CLASS_MASTA.prototype.markTarget = function() {
  this.currentTarget.setAttribute("oldClass",this.currentTarget.getAttribute("class"));
  sr_set_class(this.currentTarget, "targeted");
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.unmarkTarget = function() {

  if (this.currentTarget) {
    sr_set_class(this.currentTarget, this.currentTarget.getAttribute("oldClass"));
    this.currentTarget.removeAttribute("oldClass");
    this.currentTarget = false;
  }
}
//-------------------------------------------------------------------------------------------------

SR_CLASS_MASTA.prototype.getCurrentPlanet = function() {
  return this.currentPlanet;
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_MASTA.prototype.setCurrentPlanet = function(planetId) {
  this.currentPlanet = planetId;
}
//-------------------------------------------------------------------------------------------------

SR_CLASS_MASTA.prototype.setShowFlag = function(evt)
{
  this.minimap.setShowFlag(evt);
}
//-------------------------------------------------------------------------------------------------


//*************************************************************************************************
// NON MEMBER
//*************************************************************************************************
doWindowMouseMove = function(evt) {
  if (typeof(masta.hookedWindow) != "boolean")
  {
    var my_regexp = /^translate\W(\d.+)\s(\d.+)\W/
    my_regexp.exec(masta.windows[masta.hookedWindow].element.getAttribute("transform"));
    var wx = Number(RegExp.$1);
    var wy = Number(RegExp.$2);

    var cx = Number(evt.clientX);
    var cy = Number(evt.clientY);

    var rx = masta.windows[masta.hookedWindow].element.getAttribute("relativeDist");

    if (rx == "")
    {
      rx = (cx - wx);
      masta.windows[masta.hookedWindow].element.setAttribute("relativeDist",rx);
    }

    var nx = (cx - rx);

    masta.windows[masta.hookedWindow].element.setAttribute("transform","translate("+(nx)+" "+(cy)+")");

    if (masta.hookedWindow=="minimapWindow")
    {
      masta.minimap.x+=nx-wx;
      masta.minimap.y+=cy-wy;
    }
  }
}


cancelWindowMouseMove = function(evt) {
  fSvgRoot.removeEventListener("mouseup", cancelWindowMouseMove, true);
  fSvgRoot.removeEventListener("mousemove", doWindowMouseMove, true);

  if (masta.windows[masta.hookedWindow].element.getAttribute("relativeDist"))
    masta.windows[masta.hookedWindow].element.removeAttribute("relativeDist");
  masta.setHookedWindow(false);
}

function get_tactics_description(tactic) {
  switch (tactic) {
    case "SCOUT":
      return "Tactic SCOUT - Flee on sight";
    break;
    case "FLEE25":
      return "Tactic FLEE 25 - Flee at 25% shiploss";
    break;
    case "FLEE50":
      return "Tactic FLEE 50 - Flee at 50% shiploss";
    break;
    case "FLEE75":
      return "Tactic FLEE 75 - Flee at 75% shiploss";
    break;
    case "TRANSPORTERRAID":
      return "Tactic TRANSPORTER RAID - Ignore defenses and invade planet at once";
    break;
    case "STORMATTACK":
      return "Tactic STORM ATTACK - Fight to the end";
    break;
    default:
      return "Tactic description undefined :(";
    break;
  }
}

registerKeyDown = function(evt) {
  if (evt.keyCode)
    masta.keysPressed[Number(evt.keyCode)] = true;    
}


registerKeyUp = function(evt) {
  if (evt.keyCode)
    masta.keysPressed[Number(evt.keyCode)] = false;
    
 if (evt.keyCode == 82)
  hideWarpRange();
  
}
