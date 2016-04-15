var syncClock = new Array();

function removeObject(obj)
{
  if (obj)
  {
    if (obj.getLastChild)
    {
      objLastChild = obj.getLastChild();
      while (objLastChild != obj)
      {
        if (objLastChild.getPreviousSibling() != null)
        {
          objTemp = objLastChild.getPreviousSibling();
          obj.removeChild(objLastChild);
          objLastChild = objTemp;
        }
        else
        {
          obj.removeChild(objLastChild);
          break;
        }
      }
    }
    if(obj.getParentNode())
      obj.getParentNode().removeChild(obj);
    // fSvgRoot.removeChild(obj);
    obj     = null;
    objTemp   = null;
    objLastChild  = null;
  }
}

function deleteChildren(obj)
{
  if (obj.hasChildNodes() == true)
  {
    obj.removeChild(obj.getLastChild());
    deleteChildren(obj);
  }
}

function enable_screen(its_type)
{
  var disabler;

    if (its_type == 0)
    {
      disabler = pSvgDoc.getElementById("disabler");
      if (disabler)
        pSvg.removeChild(disabler);
    }
    else
    {
      send_message(fSvgDoc.getElementById("inputText").firstChild);
      removeObject(fSvgDoc.getElementById("inputText"));
      removeObject(fSvgDoc.getElementById("disabler"));
    }
}

function disable_screen()
{
  disabler = sr_create_rect(0,0,"100%","100%","disabler","","");
  disabler.setAttribute("id","disabler");

  status_panel = pSvgDoc.getElementById("status_panel_full");

  pSvg.insertBefore(disabler, status_panel);
}

function check_screen()
{
  if (fSvgRoot.getElementById("disabler"))
    return true;
  else
    return false;
}


/*********
*  updateStatusText(newText)
*********/
function updateStatusText(newText)
{
  var num_rows;
  if (newText=="")
    num_rows  = 1;
  else
    num_rows  = Math.ceil(newText.length/36);
  pSvgDoc.getElementById("status_text_rect").height.baseVal.value =  20*num_rows;
  if (pSvgDoc.getElementById("status_text"))
  {
    pSvgDoc.getElementById("status_text").firstChild.setData(newText);
  }
}


/*********
*  updateStatusTime()
*********/
function updateStatusTime()
{
  timeObj = pSvgDoc.getElementById("status_time").firstChild;

  syncClock[1] += 1;

  if (syncClock[1] > 59)
  {
    syncClock[0] += 1;
    syncClock[1] = 0;

    if (syncClock[0] > 59)
    {
      syncClock[0] = 0;
      if (masta.autoUpdate) {
        showMessage("The server should calculating the next tick currently. Since you activated the \"automatic update\" the complete map will be reloaded in 60 seconds!");
        window.setTimeout("completeReload()",60000);
      }
      else {
        showMessage("The server should calculating the next tick currently. Your map-cache will be cleared in 60 seconds to provide an almost up to date map.");
        window.setTimeout("masta.cache.freeCache()",60000);
      }
    }
  }
  timeOutput = (59-syncClock[0])+":";
  secs=59-syncClock[1];
  secs=secs.toString();
  if (secs.length==1)
    timeOutput = timeOutput+"0"+secs;
  else
    timeOutput = timeOutput+secs;
  timeObj.setData(timeOutput);
}


/*********
*  synchronizeClock()
*********/
function synchronizeClock()
{
  time = new Date();

  syncClock[0] = time.getMinutes();
  syncClock[1] = time.getSeconds();
  getURL("map_getinfo.php?act=syncClock",postURLCallbackSyncClock);
}


/*********
*  postURLCallbackSyncClock()
*********/
function postURLCallbackSyncClock(urlRequestStatus)
{
  var serverTime;
  var serverMinutes;
  var serverSeconds;
  var time = new Date();
  var reg_expression = /(\d.+)\s(\d.+)/;

  if (urlRequestStatus.success)
  {
    if (urlRequestStatus.content.length>0)
    {
      serverTime      = urlRequestStatus.content;

      reg_expression.exec(serverTime);
      serverMinutes   = RegExp.$1;
      serverSeconds = RegExp.$2;

  syncClock[0]  = Number(serverMinutes) + (Math.round((time.getMinutes() - syncClock[0]) / 2));
  syncClock[1]  = Number(serverSeconds) + (Math.round((time.getSeconds() - syncClock[1]) / 2));

    window.setInterval("updateStatusTime()",1000);
    }
  }
}

function completeReload()
{
  browserEval("javascript:window.location.reload()");
}

function resizeWindow(newWidth, newHeight)
{
  browserEval("javascript:window.resizeTo("+newWidth+","+newHeight+")");
}

function saveOptions(act, value)
{
  getURL("map_saveMap.php?act="+act+"&value="+value, postURLCallbackSafeMap);
}

function postURLCallbackSafeMap(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
  createInfoText(urlRequestStatus.content,"lime");
  }
  else
  {
  createInfoText("Operation failed :(","red");
  }
}


/*********
*  createPopupWindow()
*********/
function createPopupWindow(its_width, its_height, its_topic)
{
  // altes Popupfenster entfernen
  removePopupWindow();

  // alles abschalten
  disable_screen();

  // neues Erstellen
  popupWindow = pSvgDoc.createElement("g");
  popupWindow.setAttribute("id","popupWindow");

  // gegebenenfalls bereits rahmen erzeugen

  if (its_width && its_height)
  {
    var popup_childs   = new Array();
    var window_centerX = Number(window.innerWidth) / 2;
    var window_centerY = Number(window.innerHeight) / 2;

    var zeroX = window_centerX - (its_width / 2);
    var zeroY = window_centerY - (its_height / 2);

    // rahmen
    popup_childs[0] = sr_create_rect(zeroX, zeroY, its_width, its_height,"mapGUI",2,2);

    // close button
    popup_childs[1] = sr_create_rect(zeroX + its_width + 10, zeroY, 15, 15, "mapGUI2",2,2);
    popup_childs[1].setAttribute("onclick","removePopupWindow();");

    if (its_topic)
    {
      // ** Ueberschrift **
      // Laenge der Ueberschrift um festzustellen wie gross der Rahmen der Ueberschrift werden soll
      text_length = Number(its_topic.length) * 5 + 100;

      // Topic Rahmen
      popup_childs[2]    = sr_create_rect(window_centerX - (text_length / 2),zeroY - 18, text_length, 18, "mapGUI2",2,2);

      // Topic
      popup_childs[3]    = sr_create_text(its_topic, window_centerX, (window_centerY - (its_height / 2) - 5),"mapDialogText1");
    }

    popupWindow = sr_append_child_nodes(popupWindow, popup_childs);
  }

  return popupWindow;
}


/*********
*  removePopupWindow()
*********/
function removePopupWindow()
{
  // alte container entfernen
  transfer_container = pSvgDoc.getElementById("transfer_container");

  if (transfer_container)
    transfer_container.parentNode.removeChild(transfer_container);

  // altes Popupfenster entfernen
  popupWindow = pSvgDoc.getElementById("popupWindow");

  if (popupWindow)
    popupWindow.parentNode.removeChild(popupWindow);

  enable_screen(0);
}

/*********
*  createInfoText(zeichenkette, farbe)
*********/
function createInfoText(zeichenkette, farbe)
{
  tx = 20;
  ty = window.innerHeight - 30;       // ------------ muss noch angepasst werden
  newText = fSvgDoc.createElement("text");
  newText.setAttribute("id","infoText");
  newTextValue = fSvgDoc.createTextNode(zeichenkette);
  newText.appendChild(newTextValue);
  newText.setAttribute("x",tx);
  newText.setAttribute("y",ty);
  newText.setAttribute("pointer-events","none");
  newText.setAttribute("style","fill:"+ farbe +";font-family:verdana,arial;font-size:8pt;");
  fSvgRoot.appendChild(newText);
  setTimeout("removeObject(newText)",2000);
}

//*******************************************************************************************************************
function sr_create_element(element_name)
{
  var new_element = pSvgDoc.createElement(element_name);

  return new_element;
}

function sr_create_elementNS(ns, tagName){
  var new_element = pSvgDoc.createElementNS(ns ,tagName);

  return new_element;
}


function sr_create_basic_element(its_element_type, x_bez, x, y_bez, y)
{
  var new_element = sr_create_element(its_element_type);
  new_element.setAttribute(x_bez,x);
  if (typeof(y_bez)!="undefined" && typeof(y)!="undefined")
    new_element.setAttribute(y_bez,y);

  return new_element;
}


function sr_create_text_node(its_text)
{
  var new_text_node;

  new_text_node = pSvgDoc.createTextNode(its_text);

  return new_text_node;
}


function sr_create_text(its_text, its_x, its_y, its_class)
{
  var new_text = sr_create_basic_element("text","x",its_x, "y", its_y);
  new_text.setAttribute("class",its_class);

  var new_text_data = pSvgDoc.createTextNode(its_text);
  new_text.appendChild(new_text_data);

  return new_text;
}


function sr_create_flow_text_region_def(x,y,width, height, id) {
  var i;
  var new_def = sr_create_element("defs");
  new_def.appendChild(sr_create_rect(x, y, width, height));
  new_def.firstChild.setAttribute("id",id);

  return new_def;
}


function sr_create_flow_text(text_array, flow_region_def_id, its_class)
{
  var new_flow;
  var new_flow_region;
  var new_region;
  var new_flow_div;
  var new_flow_para;
  var new_text_node;
  var i;

  new_flow  = sr_create_basic_element("flow","class",its_class);

  new_flow_region = sr_create_element("flowRegion");

  new_region  = sr_create_element("region");
  new_region.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","#"+flow_region_def_id);

  new_flow_region.appendChild(new_region);

  new_flow_div  = sr_create_element("flowDiv");

  for (i = 0; i < text_array.length; i++)
  {
    new_flow_para = sr_create_element("flowPara");
    new_text_node = sr_create_text_node(text_array[i]);

    new_flow_para.appendChild(new_text_node);
    new_flow_div.appendChild(new_flow_para);
  }

  new_flow.appendChild(new_flow_region);
  new_flow.appendChild(new_flow_div);

  return new_flow;
}


function sr_create_rect(its_x, its_y, its_width, its_height, its_class, its_rx, its_ry)
{
  var new_rect = sr_create_basic_element("rect", "x", its_x, "y", its_y);

  new_rect.setAttribute("width",its_width);
  new_rect.setAttribute("height",its_height);

  if (its_class)
    new_rect.setAttribute("class",its_class);

  if (its_rx)
    new_rect.setAttribute("rx",its_rx);

  if (its_ry)
    new_rect.setAttribute("ry",its_ry);

  return new_rect;
}


function sr_create_image(url, its_x, its_y, its_width, its_height)
{
  var new_image = sr_create_basic_element("image", "x", its_x, "y", its_y);
  new_image.setAttribute("width",its_width);
  new_image.setAttribute("height",its_height);
  new_image.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href",url);

  return new_image;
}

function sr_create_use(def_element, its_x, its_y, its_class, its_transform)
{
  var new_use = sr_create_basic_element("use","x",its_x,"y",its_y);
  new_use.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","#"+def_element);

  if (typeof(its_class)!= "undefined")
    sr_set_class(new_use, its_class);

  if (typeof(its_transform) != "undefined")
    new_use.setAttribute("transform",its_transform);

  return new_use;
}

function sr_create_link(its_link, its_title, its_target)
{
  var new_link = pSvgDoc.createElement("a");
  new_link.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href",its_link);
  new_link.setAttributeNS("http://www.w3.org/1999/xlink","xlink:title",its_title);

  if (typeof(its_target)!="undefined")
    new_link.setAttribute("target",its_target);

  return new_link;
}

function sr_create_line(x1, y1, x2, y2, its_class)
{
  var new_line = sr_create_basic_element("line","x1",x1,"y1",y1);
  new_line.setAttribute("x2",x2);
  new_line.setAttribute("y2",y2);
  new_line.setAttribute("class",its_class);

  return new_line;
}


function sr_append_child_nodes(its_parent, its_childs)
{
  try {
    for (i = 0; i < its_childs.length; i++)
    {
      its_parent.appendChild(its_childs[i]);
    }
  }
  catch (e) {
    alert("sr_append_child_nodes caused an error\n\n"+e.name+"\n"+e.message);
  }

  return its_parent;
}


function sr_create_circle(its_cx, its_cy, its_r, its_class)
{
  var new_circle;

  new_circle = sr_create_basic_element("circle","cx",its_cx,"cy",its_cy);
  new_circle.setAttribute("r",its_r);

  if (typeof(its_class)!="undefined")
    new_circle.setAttribute("class",its_class);

  return new_circle;
}

function sr_create_ellipse(its_cx, its_cy, its_rx, its_ry, its_class)
{
  var new_ellipse;

  new_ellipse = sr_create_basic_element("ellipse","cx",its_cx,"cy",its_cy);
  new_ellipse.setAttribute("rx",its_rx);
  new_ellipse.setAttribute("ry",its_ry);
  new_ellipse.setAttribute("class",its_class);

  return new_ellipse;
}


function sr_create_clippath(clip_element, clip_id) {
  var new_clippath;
  var clip_element_clone = clip_element.cloneNode(true);
  
  new_clippath = sr_create_element("clipPath");
  new_clippath.setAttribute("id",clip_id);
  new_clippath.appendChild(clip_element_clone);
  
  return new_clippath;
}


//***************************************************************
//
//    resource functions
//
//***************************************************************
function resources_add_obj_to_update(resource, obj_id)
{
  new_obj_to_update = pSvgDoc.createElement("obj_to_update");
  new_obj_to_update.setAttribute("resource",resource);
  new_obj_to_update.setAttribute("obj_id",obj_id);
  pSvgDoc.getElementById("user_resources").appendChild(new_obj_to_update);
}

function update_resources()
{
  resource_container = pSvgDoc.getElementById("user_resources");

  // Eintraege ueber Update request holen
  if (resource_container.getElementsByTagName("obj_to_update"))
  {
    to_update_node_list = resource_container.getElementsByTagName("obj_to_update");

    for (i = 0; i < to_update_node_list.length; i++)
    {
      to_update_element   = to_update_node_list.item(i);

      // resourcen typ ermitteln (z.b. metal, money, ...)
      resource_type     = to_update_element.getAttribute("resource");

      // Resourcen Wert ermitteln
      resource_value    = resource_container.getElementsByTagName(resource_type).item(0).firstChild.getData();

      // -1...ziemlich sinnlos..aber der spass ist es wert
      resource_value    = Number(resource_value) - 1;

      // Object ID ermitteln, welches geupdated werden soll
      object_id     = to_update_element.getAttribute("obj_id");
      obj_to_update = pSvgDoc.getElementById(object_id);

      // neuen Wert schreiben
      obj_to_update.firstChild.setData(resource_value);
      obj_to_update.setAttribute("original_value",resource_value);

      //update request eintrag loeschen
      resource_container.removeChild(to_update_element);
    }
  }
}


function sr_add_status_text(its_obj, status_text)
{
  its_obj.setAttribute("onmouseover","updateStatusText('"+status_text+"')");
  its_obj.setAttribute("onmouseout","updateStatusText('')");

  return its_obj;
}


function sr_create_SMIL_set(its_attributeType, its_attributeName, its_to, its_begin, its_end)
{
  var new_set;

  new_set = sr_create_basic_element("set","attributeType",its_attributeType,"attributeName",its_attributeName);
  new_set.setAttribute("begin",its_begin);
  new_set.setAttribute("to",its_to);

  if (its_end)
    new_set.setAttribute("end",its_end);

  return new_set;
}


function sr_create_audio(its_xlink, its_begin)
{
  return false;
}


function sr_add_filter(its_obj, filter_id)
{
  its_obj.setAttribute("style","filter:url(#"+filter_id+")");
}

//***************************************************************
//
//    button functions
//
//***************************************************************
function sr_create_button(its_type, its_text, its_onclick, its_x, its_y, its_width, its_height, its_appearence)
{
  var new_button, set1;
  var new_button_childs = new Array();
  var use_shape, shape_x, shape_y, shape_class;
  var new_def;

  switch (its_type)
  {
    case "ok":
      use_shape = "shape_Ok_30x30";
      shape_width = 30;
      shape_height = 30;
      shape_x   = (its_width  / 2) - (shape_width / 2);
      shape_y   = (its_height / 2) - (shape_height / 2);
      shape_class = "okButton";
      statusText  = "Ok";
    break;
  }

  new_button = sr_create_basic_element("g","onclick",its_onclick,"transform","translate("+its_x+" "+its_y+")");
  new_button = sr_add_status_text(new_button, statusText);

  sr_add_filter(new_button, "filterButton1");


  switch (its_appearence)
  {
    case "rect":
      new_button_childs[0] = sr_create_rect(0,0,its_width, its_height, "mapGUI3", 5, 5);
    break;
    case "circle":
      new_button_childs[0] = sr_create_circle(its_width / 2, its_height / 2, its_width / 2, "mapGUI3");
    break;
    case "ellipse":
      new_button_childs[0] = sr_create_ellipse(its_width / 2, its_height / 2, its_width / 2, its_height /2, "mapGUI3");
    break;
  }

  new_button_childs[0].appendChild(sr_create_SMIL_set("CSS","fill","#00A2FF", "mouseover", "mouseout"));

  new_button_childs[1] = sr_create_use("shape_Ok_30x30", shape_x, shape_y, shape_class);

  if (typeof(its_text)!="undefined")
    new_button_childs[2] = sr_create_text(its_text, shape_x + shape_width + 5, its_height / 2 + 2, "mapDialogText2");

  new_button = sr_append_child_nodes(new_button, new_button_childs);

  return new_button;
}

function sr_button_hilight(evt)
{
  obj = evt.target;


  old_class = obj.getAttribute("class");

  obj.setAttribute("class","buttonHighlight1");
  window.setTimeout("sr_button_delight(obj,old_class)",10);
}

function sr_button_delight(obj, old_class)
{
  obj.setAttribute("class",old_class);

}



//***************************************************************
//
//    cache functions
//
//***************************************************************


/*-----------------------*
 |  function sr_push
 |
 |  pushes stuff into the cache xml
 |  located in <cache>
 ------------------------*/
function sr_push(its_type, its_content)
{
  var sr_cache_holder;

  switch (its_type)
  {
    case "infantry":
      sr_cache_holder = pSvgDoc.getElementsByTagName("cache_infantry").item(0);
    break;
  }
  alert(its_content);
}



//-----------------------------------------------------------------------------------------------------------
sr_set_class = function(element, newClass) {
  try {
    element.setAttribute("class", newClass);
  }
  catch (e) {
    alert("Could not set new class\n"+e.name+"\n"+e.message);
  }
}


function sr_switch_animation() {

  if (masta.animations) {
    if (SVGAnimationsPaused)
    {
      SVGAnimationsPaused = false;
      mSvgRoot.unpauseAnimations();
    }
    else
    {
      SVGAnimationsPaused = true;
      mSvgRoot.pauseAnimations();
    }
  }
}


function sr_pause_animation() {
  if (masta.animations) {
    if (!SVGAnimationsPaused) {
      SVGAnimationsPaused = true;
      mSvgRoot.pauseAnimations();
    }
  }
}


function sr_resume_animation() {
  if (masta.animations) {
    if (SVGAnimationsPaused) {
      SVGAnimationsPaused = false;
      mSvgRoot.unpauseAnimations();
    }
  }
}


function sr_get_element_index(elem)
{
  var node_list  = elem.parentNode.childNodes;
  var i;
  var pos = 0;

  for (i = 0; i < node_list.length; i++) {
    if (elem == node_list.item(i)) {
      pos = i;
      break;
    }
  }

  return pos;
}

function delArrayElem(idx,arr)
{
  var i;
  var newArr=new Array;

  for (i in arr)
  {
    if (i!=idx)
      newArr[newArr.length]=arr[i];
  }
  return newArr;
}


function showMessage(message) {
  var width = 400;
  var height = 100;
  var x = (window.innerWidth / 2) - (width / 2);
  var y = (window.innerHeight / 2) - (height / 2);
  var mwin = new SR_CLASS_WINDOW(masta.windows.length, x, y, width, height, "Message", true, true);

  var newMessage= sr_create_element("g");
  var regionDef = sr_create_flow_text_region_def(5, 5, width - 10, height - 10, "messageWindow");
  var flowText  = sr_create_flow_text(new Array(message), "messageWindow", "mapGUITopic");

  newMessage.appendChild(regionDef);
  newMessage.appendChild(flowText);

  mwin.generate();
  mwin.addRawContent(newMessage);

  masta.addWindow(mwin);
}
