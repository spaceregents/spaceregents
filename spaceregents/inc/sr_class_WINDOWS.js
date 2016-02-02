function SR_CLASS_WINDOW(windowNo, x ,y, width, height, title, fixed,close) {
  if (arguments.length > 0)
    this.init(windowNo, x, y, width, height, title, fixed,close);
}
//---------------------------------------------------


SR_CLASS_WINDOW.prototype.init = function(windowNo, x, y, width, height, title, fixed, close) {

  this.windowNo           = windowNo;
  this.x                  = x;
  this.y                  = y;
  this.width              = width;
  this.height             = height;
  this.fixed              = fixed;              // boolean, can move window?
  this.title              = title;               // title of the window
  this.components         = new Array();    // stores window components, such as text areas
  this.buttons            = new Array();    // stores "inside-the-window-buttons"
  this.internalButtons    = new Array();    // stores buttons directly embeded in window (such as the close button);
  this.element            = false;          // stores the actually XML element
  this.close              = close;          // boolean, close button?
  this.rawContents        = new Array();
  this.generated          = false;
  this.titleHeight        = 15;
  this.border             = 2;
  this.iconify            = true;
  this.content            = false;
  this.tag                = false;          // nen tag, falls man mal irgendwas 'anderes' speichern muss
  this.clipPath           = "clipper_"+this.windowNo; // wird jetzt hier gespeichert
}
//---------------------------------------------------


SR_CLASS_WINDOW.prototype.generate = function() {
  if (this.generated)
    return;

  var newWindowChilds = new Array();
  var i = 0;
  var j = 0;
  var clip;
  var clipper;
  var globalContainer;
  var defs;
  var bg;
  var contentG;

  this.element = sr_create_basic_element("g","windowNo", this.windowNo, "transform", "translate("+this.x+" "+this.y+")");

  defs = sr_create_element("defs");
  clip = sr_create_element("clipPath");
  clip.setAttribute("id", this.clipPath);
  clipper = sr_create_rect("0",this.titleHeight,this.width,this.height+2*this.border+2);
  clip.appendChild(clipper);
  defs.appendChild(clip);

  this.element.appendChild(defs);

  if (typeof(this.windowNo) == "number")
    this.element.setAttribute("onmousedown","masta.windows["+this.windowNo+"].bringToFront();");
  else
  if (typeof(this.windowNo) == "string")
    this.element.setAttribute("onmousedown","masta.windows['"+this.windowNo+"'].bringToFront();");

  // title rect
  newWindowChilds[i++] = sr_create_rect(0,0, this.width, this.titleHeight, "mapGUIWindowTitleRect", this.border, this.border);

  if (!this.fixed)
    newWindowChilds[i-1].setAttribute("onmousedown","hookWindowOnMouse(evt)");

  // title text
  newWindowChilds[i++] = sr_create_text(this.title, 12, this.titleHeight * 3/4, "mapGUIWindowTitle");
  newWindowChilds[i-1].setAttribute("pointer-events", "none");

  // window components
  for (j = 0; j < this.components.length; j++) {
    this.components[j].generate();
    this.element.appendChild(this.components[j].element);
  }

  // append childs to this.element
  this.element = sr_append_child_nodes(this.element, newWindowChilds);

  // close button
  if (this.close)
    this.internalButtons.push(new SR_CLASS_BUTTON(0, this.width - 5, 0, "BUTTON_CIRCLE_SMALL", "button_face_close", "masta.closeWindow('"+this.windowNo+"')", "close window", 0));

  if (this.iconify)
    this.internalButtons.push(new SR_CLASS_BUTTON(this.buttons.length, -5, 0, "BUTTON_CIRCLE_SMALL", "button_face_iconify", "masta.iconifyWindow('"+this.windowNo+"')", "iconify window", 0));

  for (j = 0; j < this.internalButtons.length; j++)
  {
    this.internalButtons[j].generate();
    newWindowChilds[i++]=this.internalButtons[j].element;
  }

  // bg rect
  bg=sr_create_rect(0, this.titleHeight, this.width, this.height + 5, "mapGUIWindowBgRect", this.border, this.border);
  bg.setAttribute("id","bgrect_"+this.windowNo);
  this.element.appendChild(bg);

  newWindowChilds[i++] = sr_create_element("g");
  newWindowChilds[i-1].setAttribute("id","clipperg_"+this.windowNo);
  newWindowChilds[i-1].setAttribute("clip-path","url(#clipper_"+this.windowNo+")");

  contentG = sr_create_element("g");
  contentG.setAttribute("id","wContent");
  contentG.setAttribute("display","inline");

  newWindowChilds[i-1].appendChild(contentG);
  this.content = contentG;

  sr_append_child_nodes(this.element, newWindowChilds);

  for (j = 0; j < this.buttons.length; j++)
  {
    this.buttons[j].generate();
    this.content.appendChild(this.buttons[j].element);
  }

  for (j=0;j<this.rawContents.length;j++)
  {
    this.content.appendChild(this.rawContents[j]);
  }

  this.generated=true;
}
//---------------------------------------------------


SR_CLASS_WINDOW.prototype.addComponent = function(newComponent, append) {
  var componentNo = this.components.length;
  this.components[componentNo] = newComponent;

  if (append == true)
    this.content.appendChild(this.components[componentNo].element);
}
//---------------------------------------------------


SR_CLASS_WINDOW.prototype.addButton = function(x, y, buttonType, buttonFace, buttonAction, buttonDescription, fatherClass) {
  var newBtn;
  var last;

  if (fatherClass != 0)
    newBtn = new SR_CLASS_BUTTON(this.buttons.length, x, y, buttonType, buttonFace, buttonAction, buttonDescription, fatherClass+"["+this.windowNo+"]");
  else
    newBtn = new SR_CLASS_BUTTON(this.buttons.length, x, y, buttonType, buttonFace, buttonAction, buttonDescription, 0);

  last=this.buttons.push(newBtn);
  this.buttons[last-1].generate();
  this.content.appendChild(this.buttons[last-1].element);
  //this.addFinishedButton(newBtn);

  return last-1;
}

SR_CLASS_WINDOW.prototype.removeButton = function(btnNo)
{
  this.buttons[btnNo].destroy();
  delete this.buttons[btnNo];
}
//---------------------------------------------------

SR_CLASS_WINDOW.prototype.addFinishedButton = function(btn)
{
  var last=this.buttons.push(btn);
  this.buttons[last-1].generate();
  this.content.appendChild(this.buttons[last-1].element);
}
//---------------------------------------------------

SR_CLASS_WINDOW.prototype.addRawContent=function(rawContent)
{
  var trans;

  try {
    this.rawContents.push(rawContent);

    trans=sr_create_element("g");
    trans.setAttribute("transform","translate("+this.border+" "+this.titleHeight+")");
    trans.appendChild(rawContent);
    if (this.content)
      this.content.appendChild(trans);
    else
      this.content=trans;
  }
  catch (e) {
    alert("SR_CLASS_WINDOW.prototype.addRawContent caused an Error!\nCould not append rawContent!\nname: "+e.name+"\nmessage: "+e.message+"\n"+printNode(trans));
  }
}

SR_CLASS_WINDOW.prototype.addRawElement=function(rawContent)
{
  var trans;

  try {
    this.rawContents.push(rawContent);

    trans=sr_create_element("g");
    trans.setAttribute("transform","translate("+this.border+" "+this.titleHeight+")");
    trans.appendChild(rawContent);
    this.element.appendChild(trans);
  }
  catch (e) {
    alert("SR_CLASS_WINDOW.prototype.addRawElement caused an Error!\nCould not append rawElement!\nname: "+e.name+"\nmessage: "+e.message);
  }
}

SR_CLASS_WINDOW.prototype.destroyElement = function() {
  this.content.parentNode.removeChild(this.element);
  this.element = null;
}
//---------------------------------------------------


SR_CLASS_WINDOW.prototype.destroy = function() {
  var i;

  // buttons zerstoeren
  for (i in this.buttons) {
    if (this.buttons[i])
    {
      this.buttons[i].destroy();
      delete this.buttons[i];
    }
  }

  // components zerstoeren
  for (i = 0; i < this.components.length; i++) {
    this.components[i].destroy();
    delete this.components[i];
  }

  // svg node zerstoeren
  this.element.parentNode.removeChild(this.element);
  this.element = null;
}

SR_CLASS_WINDOW.prototype.getButtons = function()
{
  return this.buttons;
}


SR_CLASS_WINDOW.prototype.updateTitle = function(newTitle) {
  this.element.getElementsByTagName("text").item(0).firstChild.data = newTitle;
}


SR_CLASS_WINDOW.prototype.setTag = function(tag) {
  this.tag = tag;
}


SR_CLASS_WINDOW.prototype.bringToFront = function() {
  if (this.element.nextSibling) {
    var my_parent = this.element.parentNode;
    my_parent.insertBefore(this.element, null);
  }
}


SR_CLASS_WINDOW.prototype.operationComplete = function(request) {
  destroyLoadingAnimation();
  if (request.success) {
    // alert(request.content);  // debug
    var requestXML  = parseXML(request.content);
    
    if (requestXML.firstChild.getAttribute("type"))
      var requestType = requestXML.firstChild.getAttribute("type");
    else    
      throw new Error("SR_CLASS_WINDOW::operationComplete\ninvalid request: No TYPE found.\nrequest content:\n"+request.content);    

    switch (requestType) {
      case "planet_info":
        var new_planet = createPlanet(requestXML);

        masta.cache.addPlanet(new_planet);
        createPlanetInfoDialog(this, new_planet);
      break;
      case "planet_info_prod":
        var its_planet = masta.cache.getPlanet(Number(requestXML.firstChild.getAttribute("pid")));

        if (its_planet) {
          updatePlanetsProduction(its_planet, requestXML);
          createPlanetInfoDialog(this, its_planet);
        }
      break;
      case "inf_transfer_values":
        createInfantryTransferDialog(this, requestXML);
      break;
      case "examine_fleet":
          createExamineFleet(this, requestXML);
      break;
      case "MESSAGE":
        showMessage(requestXML.firstChild.firstChild.data);
      break;
      default:
        throw new Error("SR_CLASS_WINDOW::operationComplete\nunknown requestType: "+requestType+"\nrequest content:\n"+request.content);
      break;
    }
  }
}

//*************************************************************
// SR_CLASS_LABEL
//*************************************************************
function SR_CLASS_LABEL(componentNo, x, y, text, textClass) {
  if (arguments.length > 0)
    this.init(componentNo, x, y, text, textClass);
}


SR_CLASS_LABEL.prototype.init = function(componentNo, x, y, text, textClass) {
  this.componentNo = componentNo;
  this.text = text;
  this.textClass = textClass;
  this.x    = x;
  this.y    = y;

  this.element = false;
}


SR_CLASS_LABEL.prototype.generate = function() {
  var newLabelChilds;

  this.element = sr_create_basic_element("g", "componentNo", this.componentNo, "transform", "translate("+this.x+" "+this.y+")");

  newLabelChilds = sr_create_text(this.text, 0, 0, this.textClass);

  this.element.appendChild(newLabelChilds);
}


//*************************************************************
// SR_CLASS_TEXTBOX
//*************************************************************
function SR_CLASS_TEXTBOX(componentNo, windowNo, x, y, width, height, text, textClass, verticalScroll, horizontalScroll) {
  if (arguments.length > 0)
    this.init(componentNo, windowNo, x, y, width, height, text, textClass, verticalScroll, horizontalScroll);
}

SR_CLASS_TEXTBOX.prototype.init = function(componentNo,  windowNo, x, y, width, height, text, textClass, verticalScroll, horizontalScroll) {
  this.componentNo  = componentNo;
  this.windowNo     = windowNo;
  this.x            = x;
  this.y            = y;
  this.width        = width;
  this.height       = height;
  this.text         = new Array(text);
  this.textClass    = textClass;
  this.vScroll      = verticalScroll   = false; // boolean
  this.hScroll      = horizontalScroll = false; // boolean

  this.element = false;
}


SR_CLASS_TEXTBOX.prototype.generate = function() {
  var newTextBoxChilds = new Array();
  var regionDefId = "textBoxFlowRegion"+this.windowNo+"_"+this.componentNo;
  var defRect;
  var i = 0;

  var textBoxRectClass = "mapGUIWindowTextBoxRect";

  this.element = sr_create_basic_element("g","componentNo", this.componentNo, "transform", "translate("+this.x+" "+this.y+")");

  defRect = sr_create_rect(2,2,this.width - 4, this.width - 4);
  defRect.setAttribute("id", regionDefId);

  newTextBoxChilds[i] = sr_create_element("def");
  newTextBoxChilds[i].appendChild(defRect);

  newTextBoxChilds[++i] = sr_create_rect(0,0,this.width, this.height, textBoxRectClass);

  if (this.text[0] != "SR_REQUEST")
    newTextBoxChilds[++i] = sr_create_flow_text(this.text, regionDefId, this.textClass);

  this.element = sr_append_child_nodes(this.element, newTextBoxChilds);
}



SR_CLASS_TEXTBOX.prototype.operationComplete = function(request) {
  var newContentNodes;
  var i;
  if (request.success)
  {
    //alert(request.content);
    newContentNodes = parseXML(request.content);
    newContentNodes = newContentNodes.getElementsByTagName("SR_TEXT_PARA");

    for (i = 0; i < newContentNodes.length; i++)
    {
      this.text[i] = newContentNodes.item(i).firstChild.data;
    }

    // redraw entire textbox
    this.element.parentNode.removeChild(this.element);
    this.generate();
    masta.windows[this.windowNo].element.appendChild(this.element);
  }
  else
  {
    alert("server error");
  }
}

SR_CLASS_TEXTBOX.prototype.destroy = function() {
  this.text     = null;
  this.element.parentNode.removeChild(this.element);
  this.element  = null;
}

//*************************************************************
// SR_CLASS_LIST
//*************************************************************
function SR_CLASS_LIST(ref,target,x,y,width,height,contents)
{
  if (arguments.length > 0)
    this.init(ref,target,x, y, width, height,contents);
}

SR_CLASS_LIST.prototype.init = function(ref,target,x,y,width,height,listElements)
{
  this.x                 =x;
  this.y                 =y;
  this.width             =width;
  this.height            =height;
  this.listElements      =listElements;
  this.element           =false;
  this.currentY          =0;
  this.ref               =ref;
  this.listElementObjects=new Array;
  this.id                =genUniqueCIdentifier(ref);
  this.markCallBack      =false;
  this.type              ="LIST";
  this.target            =target;
  this.itemHeight        = 50;
  this.itemSpacer        = 5;

  masta.containers[ref.name].cElements[this.id]=this;
}

SR_CLASS_LIST.prototype.generate = function()
{
  var g;
  var i;
  var listElement;
  var id;

  this.element = sr_create_basic_element("g","transform","translate("+this.x+" "+this.y+")");

  for (i=0;i<this.listElements.length;i++)
  {
    id=this.listElements[i].shift();
    this.listElementObjects.push(new SR_CLASS_LISTELEMENT(this,id,i,this.itemHeight,this.listElements[i]));
    this.listElementObjects[this.listElementObjects.length-1].generate();

    g = sr_create_basic_element("g","transform","translate("+this.x+" "+this.currentY+")");
    g.appendChild(this.listElementObjects[this.listElementObjects.length-1].element);

    this.element.appendChild(g);
    this.currentY += this.itemHeight + this.itemSpacer;
  }
}

SR_CLASS_LIST.prototype.handleEvent = function(evt)
{
  this.listElementObjects[evt.currentTarget.getAttribute("listElementNo")].handleEvent(evt);
  if (this.markCallBack)
    eval(this.markCallBack);
}

SR_CLASS_LIST.prototype.markAll = function()
{
  var i;
  for (i=0;i<this.listElementObjects.length;i++)
    this.listElementObjects[i].mark();
}

SR_CLASS_LIST.prototype.setMarkCallBack = function(callBack)
{
  this.markCallBack=callBack;
}

SR_CLASS_LIST.prototype.getMarked = function()
{
  var i;
  var marked=new Array;
  for (i in this.listElementObjects)
  {
    if (this.listElementObjects[i].isMarked())
      marked.push(this.listElementObjects[i]);
  }
  return marked;
}

SR_CLASS_LIST.prototype.setClassMember = function(bez, wert) {
  eval("this."+bez+" = "+wert+";");
}


SR_CLASS_LIST.prototype.removeListElementsEventListener = function()
{
  var i;
  for (i=0;i<this.listElementObjects.length;i++)
    this.listElementObjects[i].removeItsEventListener();
}

SR_CLASS_LIST.prototype.destroy = function()
{
  delete this.ref.cElements[this.id];
}

SR_CLASS_LIST.prototype.replaceListElement = function (pos, newListElement)
{
  if (this.listElements[pos].clickable)
    this.listElements[pos].element.removeEventListener("click",masta.containers[this.listElements[pos].list.ref.name].cElements[this.listElements[pos].list.id],true);
    
  this.listElements[pos].element.parentNode.removeChild(this.listElements[pos].element);
  this.listElements[pos].element = null;
  this.listElements[pos] = null;
  this.listElements[pos] = newListElement;
  this.listElements[pos].generate();
}

SR_CLASS_LIST.prototype.removeListElement = function(pos)
{
  var newListElems = new Array();
  var i, garbage;

  if (this.listElements[pos].clickable)
    this.listElements[pos].element.removeEventListener("click",masta.containers[this.listElements[pos].list.ref.name].cElements[this.listElements[pos].list.id],true);
    
  this.listElements[pos].element.parentNode.removeChild(this.listElements[pos].element);

  for (i=pos; i < this.listElements - 1; i++) {
    this.listElements[i] = this.listElements[i+1];
  }

  garbage = this.listElements.pop();
}


//*************************************************************
// SR_CLASS_LISTELEMENT
//*************************************************************
function SR_CLASS_LISTELEMENT(list,id,number,height,content)
{
  if (arguments.length > 0)
    this.init(list,id,number,height,content);
}

SR_CLASS_LISTELEMENT.prototype.init = function(list,id,number,height,content)
{
  this.width  =list.width;
  this.height =height;
  this.content=content;
  this.number =number;
  this.list   =list;
  this.element=false;
  this.marked =false;
  this.id     =id;
  this.clickable = true;
}

SR_CLASS_LISTELEMENT.prototype.generate = function()
{
  var x;
  var type;
  var availWidth;
  var offset;
  var container;
  var i;

  this.element=sr_create_basic_element("g","listElementNo",this.number);
  this.element.appendChild(sr_create_rect(0,0,this.width,this.height,"mapGUIWindowTextBoxRect",5,5));

  x=5;
  availWidth=this.width-10;
  offset=availWidth/this.content.length;

  for (i=0;i<this.content.length;i++)
  {
    container=sr_create_basic_element("g","listId",i,"transform","translate("+x+" 5)");
    container.appendChild(this.content[i]);
    this.element.appendChild(container);

    //x+=offset;
  }

  if (this.clickable)
    this.element.addEventListener("click",masta.containers[this.list.ref.name].cElements[this.list.id],true);
}

SR_CLASS_LISTELEMENT.prototype.handleEvent = function(evt)
{
  this.mark();
}

SR_CLASS_LISTELEMENT.prototype.mark = function()
{
  if (this.marked)
  {
    this.element.firstChild.setAttribute("class","mapGUIWindowTextBoxRect");
    this.marked=false;
  }
  else
  {
    this.element.firstChild.setAttribute("class","mapGUIItemSelected");
    this.marked=true;
  }
}

SR_CLASS_LISTELEMENT.prototype.isMarked = function()
{
  return this.marked;
}

SR_CLASS_LISTELEMENT.prototype.setClickable = function(clickable) {
  this.clickable = clickable;
}

SR_CLASS_LISTELEMENT.prototype.removeItsEventListener = function()
{
    this.element.removeEventListener("click",masta.containers[this.list.ref.name].cElements[this.list.id],true);
}



//*************************************************************
// SR_CLASS_SCROLLBAR(ref)
//*************************************************************
function SR_CLASS_SCROLLBAR(ref)
{
  if (arguments.length>0)
    this.init(ref);
}

SR_CLASS_SCROLLBAR.prototype.init=function(ref)
{
  this.ref          = ref;
  this.element      = false;
  this.lastScrollPos= 0;
  this.scrollRatio  = false;
  this.availHeight  = false;
  this.id           = genUniqueCIdentifier(ref);
  this.type         = "SCROLLBAR";
  masta.containers[ref.name].cElements[this.id]=this;
}

SR_CLASS_SCROLLBAR.prototype.generate=function()
{
  var bbox;
  var usedHeight;
  var sHeightPercent;
  var leftPercent;
  var rectHeight;
  var its_window;
  var scrollbar_id;

  if (this.ref.name == "fManage") {
    this.availHeight  = mSvg.getElementById("bgrect_"+this.ref.window.windowNo).height.baseVal.value-4;
    bbox              = this.ref.window.content.getBBox();
    its_window        = this.ref.window;
    scrollbar_id      = "scrollbar_"+its_window.windowNo;
  }
  else {
    this.availHeight = this.ref.height-4;
    bbox             = this.ref.content.getBBox();
    its_window       = this.ref;
    scrollbar_id     = "scrollbar_"+its_window.objNo;
  }

  usedHeight      = bbox.height + bbox.y;
  sHeightPercent  = this.availHeight/usedHeight;
  leftPercent     = 1 - sHeightPercent;
  this.scrollRatio= usedHeight / this.availHeight;

  rectHeight    = sHeightPercent > 1 ? this.availHeight : (this.availHeight * sHeightPercent);
  this.element  = sr_create_basic_element("g", "id", scrollbar_id, "clip-path", its_window.clipPath);
  this.element.appendChild(sr_create_rect(its_window.width-20, 2, 15, rectHeight, "mapGUIWindowTitleRect"));
  this.element.addEventListener("mousedown",masta.containers[this.ref.name].cElements[this.id],true);
}

SR_CLASS_SCROLLBAR.prototype.handleEvent = function(evt)
{
  if (this.ref.name == "fManage") {
    var bbox              = this.ref.window.content.getBBox();
    var its_window        = this.ref.window;
    var scrollbar_id      = "scrollbar_"+its_window.windowNo;
  }
  else {
    var bbox                = this.ref.content.getBBox();
    var its_window          = this.ref;
    var scrollbar_id        = "scrollbar_"+its_window.pageNo;
  }


  switch (evt.type)
  {
    case "mousedown":
      masta.containers[this.ref.name].cElements[this.id].lastScrollPos = evt.clientY;
      masta.containers[this.ref.name].cElements[this.id].element.addEventListener("mousemove",masta.containers[this.ref.name].cElements[this.id],true);
      masta.containers[this.ref.name].cElements[this.id].element.addEventListener("mouseup",masta.containers[this.ref.name].cElements[this.id],true);
      masta.containers[this.ref.name].cElements[this.id].element.addEventListener("mouseout",masta.containers[this.ref.name].cElements[this.id],true);
      break;
    case "mousemove":
        var scrollSize;
        var transformY;
        var newTranslateY;
        var bbox;
        var maxScrollDown;
        var doUpdate;
        var newRectY;

        scrollSize    = evt.clientY - masta.containers[this.ref.name].cElements[this.id].lastScrollPos;
        masta.containers[this.ref.name].cElements[this.id].lastScrollPos = evt.clientY;
        transformY    = its_window.content.getCTM().f - its_window.content.parentNode.getCTM().f;
        newTranslateY = transformY - scrollSize * this.scrollRatio;

        maxScrollDown = -bbox.height - bbox.y + this.availHeight;
        doUpdate      = true;
        newRectY      = masta.containers[this.ref.name].cElements[this.id].element.firstChild.y.baseVal.value + scrollSize + 2;

        if (newTranslateY<0 && newTranslateY>maxScrollDown)
        {}
        else if (newTranslateY>0 && transformY!=0)
        {
          newTranslateY = 0;
          newRectY      = 2;
        }
        else if (newTranslateY>0 && transformY==0)
          doUpdate = false;
        else if (newTranslateY<maxScrollDown && transformY!=maxScrollDown)
        {
          newTranslateY = maxScrollDown;
          newRectY      = its_window.height - masta.containers[this.ref.name].cElements[this.id].element.firstChild.height.baseVal.value;
        }
        else if (newTranslateY<maxScrollDown && transformY==maxScrollDown)
          doUpdate = false;

        if (doUpdate)
        {
          masta.containers[this.ref.name].cElements[this.id].element.firstChild.y.baseVal.value = newRectY;
          its_window.content.setAttribute("transform","translate(0 "+(newTranslateY)+")");
        }
        break;
    case "mouseup":
    case "mouseout":
      masta.containers[this.ref.name].cElements[this.id].lastScrollPos=evt.clientY;
      masta.containers[this.ref.name].cElements[this.id].element.removeEventListener("mousemove",masta.containers[this.ref.name].cElements[this.id],true);
      masta.containers[this.ref.name].cElements[this.id].element.removeEventListener("mouseup",masta.containers[this.ref.name].cElements[this.id],true);
      masta.containers[this.ref.name].cElements[this.id].element.removeEventListener("mouseout",masta.containers[this.ref.name].cElements[this.id],true);
      break;
  }
}

SR_CLASS_SCROLLBAR.prototype.destroy = function ()
{
  masta.containers[this.ref.name].cElements[this.id].element.removeEventListener("mousemove",masta.containers[this.ref.name].cElements[this.id],true);
  masta.containers[this.ref.name].cElements[this.id].element.removeEventListener("mouseup",masta.containers[this.ref.name].cElements[this.id],true);
  masta.containers[this.ref.name].cElements[this.id].element.removeEventListener("mouseout",masta.containers[this.ref.name].cElements[this.id],true);
  //this.ref.cElements[this.id] = null;
  this.element.parentNode.removeChild(this.element);
  this.element = null;
}

//*************************************************************
// SR_CLASS_PAGE(ref, x, y, width, height, content)
//*************************************************************
function SR_CLASS_PAGE(pageNo, ref, name, x, y, width, height) {
  if (arguments.length > 0)
    this.init(pageNo, ref, name, x, y, width, height);
}

SR_CLASS_PAGE.prototype.init = function(pageNo, ref, name, x, y, width, height) {
  this.x = x;
  this.y = y;
  this.width      = width;
  this.height     = height;
  this.ref        = ref;              // switch_page oder window
  this.element    = false;
  this.cElements  = new Array();
  this.name       = name;
  this.scrollBar  = false;
  this.pageNo     = pageNo;
  this.content    = false;
  this.components = new Array();
  this.clipPath   = "clipper_"+this.ref.windowNo+"_page_"+this.pageNo;  //clip path id fuer scrollbar
  this.list       = false;    // wird nicht im planet info verwendet.
}


SR_CLASS_PAGE.prototype.generate = function() {
  var bg, contentG;
  var newPageChilds = new Array();
  var i = 0;
  var newPageDef;

  this.element = sr_create_basic_element("g","transform","translate("+this.x+" "+this.y+")");

  // bg rect
  bg=sr_create_rect(0, 0, this.width, this.height, "mapGUIWindowBgRect", 2, 2);
  bg.setAttribute("id","bgrect_"+this.windowNo);
  this.element.appendChild(bg);

  newPageChilds[i] = sr_create_element("defs");
  newPageClip     = sr_create_basic_element("clipPath","id", this.clipPath);
  newPageClipper  = sr_create_rect(0, 0, this.width, this.height);

  newPageClip.appendChild(newPageClipper);
  newPageChilds[i].appendChild(newPageClip);

  newPageChilds[++i] = sr_create_element("g");
  newPageChilds[i].setAttribute("id","clipperg_page_"+this.ref.windowNo);
  newPageChilds[i].setAttribute("clip-path","url(#"+this.clipPath+")");

  this.element = sr_append_child_nodes(this.element, newPageChilds);

  contentG = sr_create_element("g");
  contentG.setAttribute("id","pContent");
  contentG.setAttribute("display","inline");
  this.content = contentG;

  newPageChilds[i].appendChild(contentG);
}

SR_CLASS_PAGE.prototype.addRawElement = function(newElements) {
  if (newElements && this.element) {
    this.element.appendChild(newElements);
  }
}

SR_CLASS_PAGE.prototype.addList = function(list) {
  this.list = list;
  this.content.appendChild(list.element);
}

SR_CLASS_PAGE.prototype.replaceList = function(list) {
  this.list.element.parentNode.removeChild(this.list.element);
  //this.list.element = null;
  this.list = list;
  this.content.appendChild(list.element);
}

SR_CLASS_PAGE.prototype.updateScrollbar = function() {
  var i;

  if (this.scrollBar)
  {
    this.oldScrollbar=this.scrollBar.id;
    this.scrollBar.destroy();
    this.scrollBar=false;
  }

  this.scrollBar=new SR_CLASS_SCROLLBAR(this);
  this.scrollBar.generate();
  this.addRawElement(this.scrollBar.element);
}

SR_CLASS_PAGE.prototype.destroy = function() {
  var i;
  if (this.list)
    delete this.list;

  if (this.scrollbar)
    this.scrollbar.destroy();

  for (i in this.cElements)
    delete this.cElements[i];

  delete this.cElements;

  this.element.parentNode.removeChild(this.element);
}


SR_CLASS_PAGE.prototype.show = function() {
  this.element.setAttribute("display","inherit");
}

SR_CLASS_PAGE.prototype.hide = function() {
  this.element.setAttribute("display","none");
}


//*************************************************************
// SR_CLASS_SWITCH_PAGE(x, y, width, height)
//*************************************************************
function SR_CLASS_SWITCH_PAGE(ref, x, y, width, height) {
  if (arguments.length > 0)
    this.init(ref, x, y, width, height);
}

SR_CLASS_SWITCH_PAGE.prototype.init = function(ref, x, y, width, height) {
  this.x       = x;
  this.y       = y;
  this.width   = width;
  this.height  = height;
  this.pages   = new Array();   // array vom typ sr_class_page
  this.buttons  = new Array();   // buttons die die jeweilige page zum vordergrund bringt
  this.element = false;
  this.ref     = false;         // sollte ein window sein
  this.activePage = -1;
  this.ref     = ref;
}

SR_CLASS_SWITCH_PAGE.prototype.generate = function() {
  this.element = sr_create_basic_element("g", "transform", "translate("+this.x+" "+this.y+")");
}

SR_CLASS_SWITCH_PAGE.prototype.addPage = function(button_face, button_desc, page) {
  var newPage;
  var btn_x, btn_y;
  var btnWidth = 35;
  var pageNo = this.pages.length;
  var actionStr = "masta.windows["+(this.ref.windowNo)+"].components["+(this.ref.components.length)+"].showPage("+pageNo+")";
  btn_x = pageNo * btnWidth;
  btn_y = this.y;

  this.pages[pageNo] = page;    // pages muessen vorher generiert werden!

  this.buttons[pageNo] = new SR_CLASS_BUTTON(this.buttons.length, btn_x, btn_y, "BUTTON_CIRCLE_BIG", button_face, actionStr, button_desc, "masta.windows["+(this.ref.windowNo)+"].components["+(this.ref.components.length)+"]")
  this.buttons[pageNo].generate();

  this.element.appendChild(this.buttons[pageNo].element);
  this.element.appendChild(page.element);
}


SR_CLASS_SWITCH_PAGE.prototype.showPage = function(pageNo) {
  var i;
  if (this.activePage != pageNo) {
    for (i in this.pages)
      this.pages[i].hide();

    this.pages[pageNo].show();
  }
  this.activePage = pageNo;
}


SR_CLASS_SWITCH_PAGE.prototype.destroy = function() {
  var i;

  for (i in this.pages) {
    this.pages[i].destroy();
    this.buttons[i].destroy();
  }


  delete this.pages;
  delete this.buttons;

  this.element.parentNode.removeChild(this.element);
}


//*************************************************************
// Progress bar
// gibt ein svg <g> element zurueck, mit der progress bar
// progress zwischen [0..1]
//*************************************************************
function sr_create_static_progress_bar(x, y, width, progress, topic, fillClass) {
  var new_bar;
  var new_childs = new Array();
  var i = -1;

  if (!fillClass)
    fillClass = "progressBar";

  try {
    new_bar = sr_create_basic_element("g", "transform", "translate("+x+" "+y+")", "display", "inherit");
    new_bar = sr_add_status_text(new_bar, topic);

    if (progress == 1)
      new_childs[++i] = sr_create_rect(0,0,width,10, fillClass,2,2);
    else {
      if (progress == 0)
        new_childs[++i] = sr_create_rect(0,0,width,10, "progressBarBg",2,2);
      else {
        new_childs[++i] = sr_create_rect(0,0,width,10, "progressBarBg",2,2);
        new_childs[++i] = sr_create_rect(0,0,(width * progress), 10, fillClass, 5, 5);
      }
    }

    new_bar = sr_append_child_nodes(new_bar, new_childs);
  }
  catch (e) {
    alert("sr_create_static_progress_bar() caused an Error!\nCould not create static progress bar!\nname: "+e.name+"\nmessage: "+e.message);
  }

  return new_bar;
}


//*************************************************************
// GENERAL
//*************************************************************
function hookWindowOnMouse(evt) {
  if (evt.button == 0 && masta.hookedWindow == false) {
    masta.setHookedWindow(evt.target.parentNode.getAttribute("windowNo"));
    fSvgRoot.addEventListener("mouseup", cancelWindowMouseMove, true);
    fSvgRoot.addEventListener("mousemove",doWindowMouseMove, true);
  }
}

function genUniqueCIdentifier(container)
{
  var j;
  var currentIds=new Array;
  var found=false;

  while (!found)
  {
    id=Math.random();
    id=Math.round(id*10000000000);
    if (!currentIds[id])
      found=true;
  }
  return id;
}
