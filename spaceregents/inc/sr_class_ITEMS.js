// global item vars
var baseItemHeight          = 84;
var baseItemWidth           = 180;
var baseItemSpacer          = 3;
var baseItemX               = window.innerWidth - 200;
var baseItemY               = 320;
var baseItemMaxVisibleItems = Math.floor((window.innerHeight - baseItemY - 10) / (baseItemHeight + 3));


// *************************************
// SR_CLASS_BASIC_ITEM
// *************************************
function SR_CLASS_BASIC_ITEM(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid) {
  if (arguments.length > 0)
    this.init(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid);
}


SR_CLASS_BASIC_ITEM.prototype.init = function(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid) {
    this.itemType     = itemType;
    this.itemNo       = itemNo;
    this.picture      = picture;
    this.topic        = topic;
    this.clickAction  = clickAction;
    this.description  = description;
    this.mouseoverAction = mouseoverAction;
    this.mouseoutAction  = mouseoutAction;
    this.oid             = oid;

    this.itemElement  = 0;
    this.x            = baseItemX;
    this.y            = Number(itemNo)*(baseItemHeight + baseItemSpacer);
    this.entity   = "SR_BASIC_ITEM";
    this.entity2  = "SR_BASIC_ITEM2";

    this.buttons = new Array();
    this.buttonExpanded = false;
}


SR_CLASS_BASIC_ITEM.prototype.generate = function() {
  var newItemChilds = new Array();

  // item image
  newItemChilds[0] = sr_create_image("inc/sr_GUI_basicItem.svgz",0,0,baseItemWidth, baseItemHeight)

  // title
  newItemChilds[1] = sr_create_text(this.topic, 10, 15, "mapGUIItemTopic");

  // picture
  if (this.picture == "animationRauschen")
    newItemChilds[2] = sr_create_use(this.picture, 6, 19);
  else
    newItemChilds[2] = sr_create_image(this.picture, 6, 19, 50, 50);

  // item_control_button
  newItemChilds[3] = sr_create_use("item_control_button",-8, 0, "");
  newItemChilds[3].setAttribute("onclick","show_item_control(evt);");
  newItemChilds[3].setAttribute("cursor","pointer");
  newItemChilds[3] = sr_add_status_text(newItemChilds[3],"expand");

  this.itemElement = sr_create_basic_element("g","itemNumber","", "display", "none");
  // this.itemElement.setAttribute("onmouseover","updateStatusText('"+this.description+"');");
  // this.itemElement.setAttribute("onmouseout","updateStatusText('');");
  this.itemElement = sr_append_child_nodes(this.itemElement, newItemChilds);
  this.itemElement.setAttribute("itemNo",this.itemNo);
  this.itemElement.setAttribute("transform","translate(0 "+this.y+")");

  pSvg.appendChild(this.itemElement);
}

SR_CLASS_BASIC_ITEM.prototype.destroyElement = function()
{
  this.itemElement.parentNode.removeChild(this.itemElement);
  delete this.itemElement;
}

SR_CLASS_BASIC_ITEM.prototype.setPosition = function(x, y) {
  if (arguments.length > 0) {
    this.x = x;
    this.y = y;
  }

  this.itemElement.setAttribute("transform", "translate("+this.x+" "+this.y+")");
}


SR_CLASS_BASIC_ITEM.prototype.show = function() {
  this.itemElement.setAttribute("display","inherit");
}


SR_CLASS_BASIC_ITEM.prototype.hide = function() {
  this.itemElement.setAttribute("display","none");
}


// *************************************
// SR_CLASS_FLEET_ITEM
// *************************************
SR_CLASS_FLEET_ITEM.prototype             = new SR_CLASS_BASIC_ITEM();
SR_CLASS_FLEET_ITEM.prototype.constructor = SR_CLASS_FLEET_ITEM;
SR_CLASS_FLEET_ITEM.superclass            = SR_CLASS_BASIC_ITEM.prototype;

function SR_CLASS_FLEET_ITEM(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid, text1, text2, footer, allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list) {

  if (arguments.length > 0)
    this.init(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid, text1, text2, footer, allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list);
}


SR_CLASS_FLEET_ITEM.prototype.init = function(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid, text1, text2, footer,allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list) {
  SR_CLASS_FLEET_ITEM.superclass.init.call(this, itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid);
  this.text1  = text1;      // target
  this.text2  = text2;      // alliance, additoinal info if not full_fleet_item
  this.footer = footer;     // shipcount
  this.footerIcon = "button_face_ship";
  this.allianceColor  = allianceColor;
  this.allianceSymbol = allianceSymbol;
  this.allianceName   = allianceName;
  this.relationClass  = relationClass;

  this.baseTextRectX  = 59;
  this.baseText1RectY = 21;
  this.baseText2RectY = 41;
  this.baseTextRectWidth = 116;
  this.baseTextRectHeight= 13;

  this.baseTextX = 61;
  this.baseText1Y = 32;
  this.baseText2Y = 52;

  if (fleet_control_node_list)
    this.generateControlButtons(fleet_control_node_list);

}


SR_CLASS_FLEET_ITEM.prototype.generate = function() {

  var newItemChilds = new Array();
  var i = 0;
  try {
    SR_CLASS_FLEET_ITEM.superclass.generate.call(this);

    // text1
    newItemChilds[i] = sr_create_rect(this.baseTextRectX, this.baseText1RectY, this.baseTextRectWidth, this.baseTextRectHeight, "mapGUIItemTextRect", 2, 2);
    newItemChilds[++i] = sr_create_text(this.text1, this.baseTextX, this.baseText1Y, "mapGUIItemText");

    // text2
    if (this.text2 != "SR_SYMBOLS") {
      newItemChilds[++i] = sr_create_rect(this.baseTextRectX, this.baseText2RectY, this.baseTextRectWidth, this.baseTextRectHeight, "mapGUIItemTextRect", 2, 2);
      newItemChilds[++i] = sr_create_text(this.text2, this.baseTextX, this.baseText2Y, "mapGUIItemText");
    }

    // footer fleet icon
    newItemChilds[++i] = sr_create_use(this.footerIcon, 62, 64, "mapGUIItemFooterIcon");
    newItemChilds[i].setAttribute("onmouseover","updateStatusText('shipcount');");
    newItemChilds[i].setAttribute("onmouseout","updateStatusText(' ');");

    // footer
    var footerRegEx = /(\d*)\s(\d*)\s(\d*)/;
    footerRegEx.exec(this.footer);

    // Olymp class
    newItemChilds[i] = sr_create_use(this.footerIcon, 62, 64, "mapGUIItemFooterIcon");
    newItemChilds[i].setAttribute("onmouseover","updateStatusText('Olymp Class count');");
    newItemChilds[i].setAttribute("onmouseout","updateStatusText(' ');");
    newItemChilds[++i] = sr_create_text(RegExp.$1, 80, 77, "mapGUIItemFooterText");

    // Zeus class
    var zeus_x = Number(newItemChilds[i].getComputedTextLength()) + 80;

    newItemChilds[++i] = sr_create_use(this.footerIcon, zeus_x * 1.25 + 12, 64 * 1.25 + 7.5, "mapGUIItemFooterIcon", "scale(0.75)");
    newItemChilds[i].setAttribute("onmouseover","updateStatusText('Zeus Class count');");
    newItemChilds[i].setAttribute("onmouseout","updateStatusText(' ');");
    zeus_x += 16;
    newItemChilds[++i] = sr_create_text(RegExp.$2, zeus_x, 77, "mapGUIItemFooterText");

    // Europa class
    var europa_x = Number(newItemChilds[i].getComputedTextLength()) + 3 + zeus_x;

    newItemChilds[++i] = sr_create_use(this.footerIcon, europa_x * 2, 64 * 2 + 7, "mapGUIItemFooterIcon", "scale(0.5)");
    newItemChilds[i].setAttribute("onmouseover","updateStatusText('Europa Class count');");
    newItemChilds[i].setAttribute("onmouseout","updateStatusText(' ');");
    newItemChilds[++i] = sr_create_text(RegExp.$3, europa_x + 10, 77, "mapGUIItemFooterText");
    
    //relationshipClass
    newItemChilds[++i] = sr_create_use("item_relation_indicator",2,2, this.relationClass);

    // alliance circle
    if (this.allianceColor != 0){      
      newItemChilds[++i] = sr_create_circle(17, 71, 9);
      newItemChilds[i].setAttribute("style","fill:black;stroke:"+this.allianceColor+";stroke-width:2px;");
      newItemChilds[i].setAttribute("onmouseover","updateStatusText('Alliance: "+this.allianceName+"')");
      newItemChilds[i].setAttribute("onmouseout","updateStatusText('')");
 
      // alliance Symbol
      if (this.allianceSymbol){
        newItemChilds[++i] = sr_create_clippath(newItemChilds[i-1], "symb_"+this.itemNo);
        newItemChilds[++i] = sr_create_image(this.allianceSymbol, 8, 62, 18, 18);
        newItemChilds[i].setAttribute("pointer-events","none");
        newItemChilds[i].setAttribute("clip-path","url(#symb_"+this.itemNo+")");
      }
    }
    this.itemElement = sr_append_child_nodes(this.itemElement, newItemChilds);
  }
  catch (e) {
    alert("SR_CLASS_FLEET_ITEM.prototype.generate caused an error\n\n"+e.name+"\n"+e.message);
  }
}

SR_CLASS_FLEET_ITEM.prototype.generateControlButtons= function(node_list) {
  var i;
  var buttonY = (baseItemHeight / 3) - 15;
  var buttonX;
  var buttonDesc;


  node_list.length > 4 ? buttonY = (baseItemHeight / 3) - 15 : buttonY = (baseItemHeight / 2) - 15;
  
  try {
    for (i = 0; i < node_list.length; i++) {
      // wenn mehr als 5, in der naechsten Zeile weiterzeichnen
      if (i > 4)
        buttonY = (baseItemHeight * (2/3)) - 15;

      buttonDesc = node_list.item(i).getAttribute("controlName");

      // preis ebenfalls in die desc einbeziehen
      if (Number(node_list.item(i).getAttribute("metal")) > 0)
        buttonDesc += " - metal: "+node_list.item(i).getAttribute("metal");

      if (Number(node_list.item(i).getAttribute("energy")) > 0)
        buttonDesc += " - energy: "+node_list.item(i).getAttribute("energy");

      if (Number(node_list.item(i).getAttribute("mopgas")) > 0)
        buttonDesc += " - mopgas: "+node_list.item(i).getAttribute("mopgas");

      if (Number(node_list.item(i).getAttribute("erkunum")) > 0)
        buttonDesc += " - erkunum: "+node_list.item(i).getAttribute("erkunum");

      if (Number(node_list.item(i).getAttribute("gortium")) > 0)
        buttonDesc += " - gortium: "+node_list.item(i).getAttribute("gortium");

      if (Number(node_list.item(i).getAttribute("susebloom")) > 0)
        buttonDesc += " - susebloom: "+node_list.item(i).getAttribute("susebloom");

      buttonX = (i * -35) - 35;
      this.buttons[i] = new SR_CLASS_BUTTON(i, buttonX, buttonY, "BUTTON_CIRCLE_BIG", "arts/"+node_list.item(i).getAttribute("face"), "executeItemControl(evt, '"+node_list.item(i).getAttribute("controlName")+"')", buttonDesc, "masta.itemBox.item["+this.itemNo+"]");
      this.buttons[i].generate();
    }
  }
  catch (e) {
    alert("SR_CLASS_FLEET_ITEM::generateControlButtons caused an error!\n"+e.name+"\n"+e.message);
  }
}



// *************************************
// SR_CLASS_FULL_FLEET_ITEM
// *************************************
SR_CLASS_FULL_FLEET_ITEM.prototype             = new SR_CLASS_FLEET_ITEM();
SR_CLASS_FULL_FLEET_ITEM.prototype.constructor = SR_CLASS_FULL_FLEET_ITEM;
SR_CLASS_FULL_FLEET_ITEM.superclass            = SR_CLASS_FLEET_ITEM.prototype;

function SR_CLASS_FULL_FLEET_ITEM(itemType,
                                  itemNo,
                                  picture,
                                  topic,
                                  description,
                                  clickAction,
                                  mouseoverAction,
                                  mouseoutAction,
                                  oid,
                                  text1,
                                  text2,
                                  footer,
                                  allianceColor,
                                  allianceSymbol,
                                  allianceName,
                                  relationClass,
                                  fleet_control_node_list,
                                  newFleet) {

  if (arguments.length > 0)
    this.init(itemType, itemNo,picture,topic,description,clickAction,mouseoverAction,mouseoutAction,oid,text1, text2, footer, allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list, newFleet);
}


SR_CLASS_FULL_FLEET_ITEM.prototype.init = function(itemType, itemNo,picture,topic,description,clickAction,mouseoverAction,mouseoutAction,oid,text1, text2, footer, allianceColor, allianceSymbol, allianceName, relationClass,fleet_control_node_list, newFleet) {


  SR_CLASS_FULL_FLEET_ITEM.superclass.init.call(this, itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid, text1, text2, footer,  allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list);

  this.fleet          = newFleet;
  this.eta            = newFleet.eta;
  this.mission        = newFleet.mission;
  this.reloadSymbol   = newFleet.reload;

  this.selected       = false;

  this.symbolBaseX      = 60;
  this.symbolBaseY      = 46;
  this.symbolBaseWidth  = 20;
  this.symbolBaseSpacer = 4;
}


SR_CLASS_FULL_FLEET_ITEM.prototype.generate = function() {
  try {
    SR_CLASS_FULL_FLEET_ITEM.superclass.generate.call(this);
    var newItemChilds = new Array();
    var i = 0;

    // mission symbol
    newItemChilds[i] = sr_create_image("arts/"+this.fleet.missionSymbol, this.symbolBaseX, this.symbolBaseY - (this.symbolBaseWidth / 2), "20", "20");
    sr_add_status_text(newItemChilds[i], "Mission: "+this.fleet.missionName);

    // tactic symbol
    newItemChilds[i] = sr_create_circle(this.symbolBaseX+(this.symbolBaseWidth / 2) + this.symbolBaseWidth + this.symbolBaseSpacer, this.symbolBaseY, (this.symbolBaseWidth / 2), "mapGUItemSymbolCircle");
    sr_add_status_text(newItemChilds[i], "Tactic: "+this.fleet.tacticName);
    i++;
    
    // infantry symbol
    if (this.fleet.hasTransporters())    
    {
      if (this.fleet.infCount > 0)
      {
        newItemChilds[i] = sr_create_use("button_face_infantry",this.symbolBaseX + 2*(this.symbolBaseWidth + this.symbolBaseSpacer) + 3, this.symbolBaseY - 6, "colorAllied");
        sr_add_status_text(newItemChilds[i], "Groundforces aboard: "+this.fleet.infCount+" units");
      }
      else
      {
        newItemChilds[i] = sr_create_use("button_face_infantry",this.symbolBaseX + 2*(this.symbolBaseWidth + this.symbolBaseSpacer) + 3, this.symbolBaseY - 6, "colorNone");
        sr_add_status_text(newItemChilds[i], "No groundforces aboard");
      }
      i++;
    }
    
    // colonists symbol    
    if (this.fleet.getColonyships() > 0) {
      newItemChilds[i] = sr_create_image("arts/icon_colonists.svgz", this.symbolBaseX + 3*(this.symbolBaseWidth + this.symbolBaseSpacer), this.symbolBaseY - 7, 17, 17);
      sr_add_status_text(newItemChilds[i], "Colonyships: "+this.fleet.getColonyships());
      i++;
    }

    // mod symbol
    var modText;
    var modImg;
    if (this.fleet.mod == 0) {
      modText = "Minister of Defence MUST NOT give orders";
      modImg = "button_mod2.svgz";
    }
    else {
      modText = "Minister Of Defence may give orders";
      modImg = "button_mod.svgz";
    }

    newItemChilds[i] = sr_create_image("arts/"+modImg, this.symbolBaseX + 4*(this.symbolBaseWidth + this.symbolBaseSpacer), this.symbolBaseY - 10, this.symbolBaseWidth, this.symbolBaseWidth);
    newItemChilds[i].setAttribute("onclick","switch_mod(evt, "+this.fleet.id+")");
    sr_add_status_text(newItemChilds[i], modText);
    i++;
    // reload
    var maxReload = this.fleet.getMaxReload();
    var reloadX = 30;
    var reloadY = 58;
    var reloadChilds = new Array();

    newItemChilds[i] = sr_create_element("g");
    reloadChilds[0] = sr_create_rect(reloadX, reloadY, 30, 13, "itemDarkBg", 5, 5);
    reloadChilds[1] = sr_create_circle(reloadX + 7, reloadY + 6, 7, "itemDargBg");
    reloadChilds[2] = sr_create_circle(reloadX + 7, reloadY + 6, 5);
    if (maxReload > 0) {
      reloadChilds[2].setAttribute("fill","url(#gREnemy)");
      newItemChilds[i]   = sr_add_status_text(newItemChilds[i],"This fleet must refuel its engines for "+maxReload+" "+masta.zeitEinheit);
    }
    else {
      reloadChilds[2].setAttribute("fill","url(#gROwn)");
      newItemChilds[i]   = sr_add_status_text(newItemChilds[i],"This fleet is READY to jump.");
    }
    reloadChilds[3] = sr_create_text(maxReload, reloadX + 15, reloadY + 10, "mapGUIItemFooterText");
    newItemChilds[i] = sr_append_child_nodes(newItemChilds[i], reloadChilds);
    i++; 
    // eta
    newItemChilds[i] = sr_create_text(this.fleet.eta, 55, 30, "fleetItemETA");

    this.itemElement = sr_append_child_nodes(this.itemElement, newItemChilds);
    // onClick
    this.itemElement.setAttribute("onclick","masta.addSelected(evt);");

    // Cursor
    this.itemElement.setAttribute("cursor","pointer");
  }
  catch (e) {
    alert("SR_CLASS_FULL_FLEET_ITEM.prototype.generate caused an error\n\n"+e.name+"\n"+e.message);
  }
}

SR_CLASS_FULL_FLEET_ITEM.prototype.addCommandButtons = function(commandButtonNode) {
}

SR_CLASS_FULL_FLEET_ITEM.prototype.destroyElement = function()
{
  SR_CLASS_FULL_FLEET_ITEM.superclass.destroyElement.call(this);
}

SR_CLASS_FULL_FLEET_ITEM.prototype.update = function()
{
  delete this.buttons;
  //SR_CLASS_FULL_FLEET_ITEM.superclass.init.call(this, this.itemType, this.itemNo, this.picture, this.fleet.name, this.description, this.clickAction, this.mouseoverAction, this.mouseoutAction, this.fleet.id, this.fleet.targetName, this.text2, this.footer, this.allianceColor, this.allianceSymbol, this.allianceName, this.relationClass, false);
  this.init(this.itemType, this.itemNo, this.picture, this.fleet.name, this.description, this.clickAction, this.mouseoverAction, this.mouseoutAction, this.fleet.id, this.fleet.targetName, this.text2, this.footer, this.allianceColor, this.allianceSymbol, this.allianceName, this.relationClass, false, this.fleet);
}



SR_CLASS_FULL_FLEET_ITEM.prototype.select = function(override) {
  if (!this.selected || override) {
    this.selected = true;

    if (this.buttonExpanded)
      this.itemElement.firstChild.nextSibling.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","inc/sr_GUI_basicItem_selected.svgz");
    else
      this.itemElement.firstChild.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","inc/sr_GUI_basicItem_selected.svgz");
  }
  else {
    this.selected = false;

    if (this.buttonExpanded)
      this.itemElement.firstChild.nextSibling.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","inc/sr_GUI_basicItem.svgz");
    else
      this.itemElement.firstChild.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","inc/sr_GUI_basicItem.svgz");
  }

  return this.selected;
}




// *************************************
// GLOBAL
// *************************************


function show_item_control(evt) {
  var evtTarget = evt.target;
  var callerClass;      // stores the JS-class
  var callerObj;        // stores the SVG Element of the Item
  var i;

  if (String(evtTarget) == "[object SVGElementInstance]")
    evtTarget = evtTarget.correspondingUseElement;


  callerObj = evtTarget.parentNode;

  callerClass = masta.itemBox.item[Number(callerObj.getAttribute("itemNo"))];

  if (callerClass.buttonExpanded == true)       // collapse control buttons
  {
    collapseControlButtons(evtTarget, callerObj, callerClass);
  }
  else                                                      // expand control buttons
  {
    expandControlButtons(evtTarget, callerObj, callerClass);
  }
}
//-------------------------------------------------------------


function getControlButtonExpandWidth(callerClass) {
  var expandWidth;      // stores how far the panel should be expanded

  // calculate the expandWidth
  callerClass.buttons.length > 4 ? expandWidth = 4 * 40 : expandWidth = callerClass.buttons.length * 40;

  return expandWidth;
}



function collapseControlButtons(evtTarget, callerObj, callerClass)
{
  var i;

  evtTarget.setAttribute("x",Number(evtTarget.getAttribute("x")) + getControlButtonExpandWidth(callerClass));
  evtTarget.setAttribute("onmouseover","updateStatusText('expand');");

  // get rid of BgRect
  evtTarget.parentNode.removeChild(evtTarget.parentNode.firstChild);

  // get rid of the buttons
  for (i = 0; i < callerClass.buttons.length; i++) {
    callerClass.itemElement.removeChild(callerClass.buttons[i].element);
  }

  callerClass.buttonExpanded = false;
}
//-------------------------------------------------------------


function expandControlButtons(evtTarget, callerObj, callerClass)
{
  var buttonBgRect;     // background rectangle
  var i, j;
  var expandWidth = getControlButtonExpandWidth(callerClass);
  var tempNodeList;

    //scan for expanded control buttons and collapse them
    for (i = 0; i < masta.itemBox.item.length; i++)
    {
      if (masta.itemBox.item[i].buttonExpanded == true) {
         tempNodeList = masta.itemBox.item[i].itemElement.getElementsByTagName("use");

         for (j = 0; j < tempNodeList.length; j++) {
           if (tempNodeList.item(j).getAttribute("onclick") == "show_item_control(evt);")
           {
             collapseControlButtons(tempNodeList.item(j), masta.itemBox.item[i].itemElement, masta.itemBox.item[i]);
             break;
           }
         }
      }
    }

    // create background
    buttonBgRect = sr_create_rect(-expandWidth-5, 5, expandWidth+5, baseItemHeight - 10, "controlButtonBgRect");

    // move button to left (expanded)
    evtTarget.setAttribute("x",Number(evtTarget.getAttribute("x"))-expandWidth);
    evtTarget.setAttribute("onmouseover","updateStatusText('collapse');");

    callerClass.buttonExpanded = true;

    // append Bg rect before expand button
    evtTarget.parentNode.insertBefore(buttonBgRect, evtTarget.parentNode.firstChild);

    // make the buttons visible
    for (i = 0; i < callerClass.buttons.length; i++) {
      callerClass.itemElement.appendChild(callerClass.buttons[i].element);
    }

    // set itemBox Class property expandendItem to this item
    masta.itemBox.expandendItem = callerObj.getAttribute("itemNo");
}
//-------------------------------------------------------------
