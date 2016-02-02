function SR_CLASS_FLEET_MANAGEMENT(x ,y, width, height)
{
  if (arguments.length > 0)
    this.init(x, y, width, height);
}

SR_CLASS_FLEET_MANAGEMENT.prototype.init = function(x,y,width,height)
{
  this.window         =new SR_CLASS_WINDOW("fManage", x,y, width, height, "Manage Fleets", false, true);
  this.fleets         =new Array;
  this.currentY       =0;
  this.cElements      =new Array;
  this.name           ="fManage";
  this.scrollBar      =false;
  this.fleetButtons   =new Array;
  this.offset         =5;
  this.oldScrollbar   =false;
  this.actionButtons  =new Array;
  this.lists          =new Array;
  this.transferWindow =false;
  this.action         =0;

  masta.addWindow(this.window);
}

SR_CLASS_FLEET_MANAGEMENT.prototype.addFleet = function(fleet)
{
  var contents;
  var list;
  var scrollBar;
  var buttonY;
  var fleetElement;
  var firstFleet;
  var count, countRect, its_reload;
  var fleetName;
  var i;
  var reloadX = 20;
  var reloadY = 40;

  if (this.fleets.length>0)
  {
    firstFleet=this.fleets[0];
    if (firstFleet.sid!=fleet.sid || firstFleet.pid!=fleet.pid)
    {
      return;
    }
  }

  this.fleets[this.fleets.length]=fleet;
  fleetElement=sr_create_basic_element("g","id","fleetManage_"+(this.fleets.length-1));
  fleetElement.appendChild(sr_create_rect(5,this.currentY+this.offset,this.window.width-40-2*this.window.border,20,"mapGUIWindowTitleRect",5,5));
  fleetName=sr_create_text(fleet.name,30,this.currentY+this.offset+14,"mapDialogText2edit");
  fleetName.setAttribute("id","fleet_name_"+fleet.id);
  fleetName.setAttribute("editable","true");
  fleetElement.appendChild(fleetName);

  buttonY=this.currentY;
  this.currentY+=30;

  contents=new Array;
  for (i in fleet.ships)
  {
    var reloadChilds = new Array();

    count=sr_create_text(0,60,45,"mapDialogText2edit");
    count.setAttribute("editable","true");
    count.setAttribute("id","count_"+fleet.id+"_"+i);

    countRect = sr_create_rect(55, 31, 100, 20, "mapGUIWindowBgRect",2,2);
    sr_add_status_text(countRect, "Click on the digit to enter the number of ships to transfer");

    its_reload      = sr_create_element("g");
    reloadChilds[0] = sr_create_rect(reloadX, reloadY, 30, 13, "itemDarkBg", 5, 5);
    reloadChilds[1] = sr_create_circle(reloadX + 7, reloadY + 6, 7, "itemDargBg");
    reloadChilds[2] = sr_create_circle(reloadX + 7, reloadY + 6, 5);

    if (fleet.ships[i][1] > 0) {
      reloadChilds[2].setAttribute("fill","url(#gREnemy)");
      sr_add_status_text(its_reload,"These ships must refuel their engines for "+fleet.ships[i][1]+" "+masta.zeitEinheit);
    }
    else {
      reloadChilds[2].setAttribute("fill","url(#gROwn)");
      sr_add_status_text(its_reload,"These ships are READY to jump.");
    }
    reloadChilds[3]   = sr_create_text(fleet.ships[i][1], reloadX + 15, reloadY + 10, "mapGUIItemFooterText");
    its_reload        = sr_append_child_nodes(its_reload, reloadChilds);


    contents[contents.length] = new Array(i,
                                          sr_create_image(__prodInfo[i].getImage(),0,0,50,50),
                                          sr_create_text(fleet.ships[i][2],55, 10,"mapDialogText2"),
                                          sr_create_text("# "+fleet.ships[i][0],55,23,"mapDialogText2"),
                                          countRect,
                                          count,
                                          its_reload);

    reloadChilds = null;
  }
  try
  {
    list=new SR_CLASS_LIST(this,fleet,10,this.currentY,this.window.width-60-2*this.window.border,50,contents);
  }
  catch (e)
  {
    alert("new SR_CLASS_LIST kaputt\n\n"+e.name+"\n"+e.message+"\n");
    alert(this+" "+fleet+" "+this.currentY+" "+contents);
  }
  list.setMarkCallBack("masta.containers['"+this.name+"'].markCallback(this.id,evt.currentTarget.getAttribute('listElementNo'))");
  list.setClassMember("itemHeight",60);
  list.generate();
  fleetElement.appendChild(list.element);

  this.lists[fleet.id]=list;
  this.currentY+=list.element.getBBox().height+5;

  this.window.addRawContent(fleetElement);

  this.fleetButtons[fleet.id]=new Array;
  this.fleetButtons[fleet.id].push(this.window.addButton(this.window.width-55,buttonY+22,"BUTTON_CIRCLE_SMALL","button_face_close","masta.containers['"+this.name+"'].removeFleet("+(this.fleets.length-1)+")","Remove Fleet",0));
  this.fleetButtons[fleet.id].push(this.window.addButton(this.window.width-70,buttonY+22,"BUTTON_CIRCLE_SMALL","button_face_mark","masta.containers['"+this.name+"'].selectAll("+(this.fleets.length-1)+"); masta.containers['"+this.name+"'].cElements["+list.id+"].markAll(); masta.containers['"+this.name+"'].updateButtons("+list.id+")","Mark/Unmark all",0));

  this.fleetButtons[fleet.id].push(this.window.addButton(10,buttonY+22,"BUTTON_CIRCLE_SMALL","button_face_ok","masta.containers['"+this.name+"'].rename("+(fleet.id)+")","Save Fleetname",0));
  try
  {
    this.updateScrollbar();
  }
  catch(e)
  {
    alert("FLEET_MANAGEMENT::updateScrollbar() caused an error\n\n"+e.name+"\n"+e.message);
  }
}

SR_CLASS_FLEET_MANAGEMENT.prototype.updateScrollbar = function()
{
  var i;

  if (this.scrollBar)
  {
    this.oldScrollbar=this.scrollBar.id;
    this.scrollBar.destroy();
    this.scrollBar=false;
  }

  this.scrollBar=new SR_CLASS_SCROLLBAR(this);
  this.scrollBar.generate();
  this.window.addRawElement(this.scrollBar.element);
  try
  {
    this.updateButtons();
  }
  catch(e)
  {
    alert("FLEET_MANAGEMENT::updateButtons() caused an error\n\n"+e.name+"\n"+e.message+"\n"+this.action);
  }
}

SR_CLASS_FLEET_MANAGEMENT.prototype.removeFleet = function(fleetNo)
{
  var i;
  var element;
  var ctm;
  var bbox;
  var oBbox;
  var other;
  var globalCTM;
  var transY;
  var buttons;
  var buttonParent;
  var j;
  var nextElem;

  element=mSvg.getElementById("fleetManage_"+fleetNo);
  bbox=element.getBBox();
  for (i=0;i<this.fleets.length;i++)
  {
    if (!nextElem && i>fleetNo)
      nextElem=mSvg.getElementById("fleetManage_"+i);
  }

  transY=bbox.height+this.offset+5;
  if (nextElem)
  {
    oBbox=nextElem.getBBox();

    globalCTM=element.parentNode.getCTM();
    buttons=this.window.getButtons();

    for (i=0;i<this.fleets.length;i++)
    {
      if (i>fleetNo)
      {
  other=mSvg.getElementById("fleetManage_"+i);
  ctm=other.getCTM();
  other.setAttribute("transform","translate("+(ctm.e-globalCTM.e)+" "+(ctm.f-globalCTM.f-transY)+")");
  other.setAttribute("id","fleetManage_"+(i-1));

  for (j=0;j<this.fleetButtons[this.fleets[i].id].length;j++)
  {
    other=buttons[this.fleetButtons[this.fleets[i].id][j]].element;
    buttonParent=other.parentNode;
    ctm=other.getCTM();
    other.setAttribute("transform","translate("+(ctm.e-buttonParent.getCTM().e)+" "+(ctm.f-buttonParent.getCTM().f-transY)+")");
    other.setAttribute("onclick","masta.containers['"+this.name+"'].removeFleet("+(i-1)+")");
  }
      }
    }
  }
  this.lists[this.fleets[fleetNo].id].destroy();
  delete this.lists[this.fleets[fleetNo].id];
  this.currentY-=transY;
  element.parentNode.removeChild(element);

  for (i=0;i<this.fleetButtons[this.fleets[fleetNo].id].length;i++)
    this.window.removeButton(this.fleetButtons[this.fleets[fleetNo].id][i]);

  delete this.fleetButtons[this.fleets[fleetNo].id];
  delete this.actionButtons[this.fleets[fleetNo].id];

  var ok=this.fleets[fleetNo].id;
  this.fleets=delArrayElem(fleetNo,this.fleets);

  this.updateScrollbar();
}

SR_CLASS_FLEET_MANAGEMENT.prototype.markCallback = function(listId,listElementNo)
{
  this.updateButtons(listId);
}

SR_CLASS_FLEET_MANAGEMENT.prototype.updateButtons = function(id)
{
  var i;
  var selected=new Array;
  var lists=new Array;
  var transfer=false;
  var globalCTM;
  var ctm;

  for (i in this.cElements)
  {
    if(this.cElements[i].type=="LIST")
    {
      lists.push(i);
      selected[i]=this.cElements[i].getMarked();
      if (selected[i].length>0)
        transfer=true;
    }
  }

  this.action=0;
  for (i=0;i<lists.length;i++)
  {
    if (selected[lists[i]].length==0 && !this.actionButtons[this.cElements[lists[i]].target.id] && transfer)
    {
      this.action=1;
      globalCTM=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.parentNode.getCTM();
      ctm=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.getCTM();

      this.actionButtons[this.cElements[lists[i]].target.id]=this.window.addButton(this.window.width-85,ctm.f-globalCTM.f,"BUTTON_CIRCLE_SMALL","button_face_transfer","masta.containers['"+this.name+"'].transferToFleet("+this.cElements[lists[i]].target.id+")","Transfer",0);
      this.fleetButtons[this.cElements[lists[i]].target.id].push(this.actionButtons[this.cElements[lists[i]].target.id]);
    }
    else if (selected[lists[i]].length>0 && this.actionButtons[this.cElements[lists[i]].target.id])
    {
      this.action=2;
      this.window.removeButton(this.actionButtons[this.cElements[lists[i]].target.id]);
      delete this.actionButtons[this.cElements[lists[i]].target.id];

      this.fleetButtons[this.cElements[lists[i]].target.id].pop();
      globalCTM=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.parentNode.getCTM();
      ctm=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.getCTM();

      this.actionButtons[this.cElements[lists[i]].target.id]=this.window.addButton(this.window.width-85,ctm.f-globalCTM.f,"BUTTON_CIRCLE_SMALL","button_face_create","masta.containers['"+this.name+"'].createFleet("+this.cElements[lists[i]].target.id+")","Create new fleet",0);
      this.fleetButtons[this.cElements[lists[i]].target.id].push(this.actionButtons[this.cElements[lists[i]].target.id]);
    }
    else if (selected[lists[i]].length>0 && !this.actionButtons[this.cElements[lists[i]].target.id])
    {
      this.action=3;
      globalCTM=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.parentNode.getCTM();
      ctm=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.getCTM();

      this.actionButtons[this.cElements[lists[i]].target.id]=this.window.addButton(this.window.width-85,ctm.f-globalCTM.f,"BUTTON_CIRCLE_SMALL","button_face_create","masta.containers['"+this.name+"'].createFleet("+this.cElements[lists[i]].target.id+")","Create new fleet",0);
      this.fleetButtons[this.cElements[lists[i]].target.id].push(this.actionButtons[this.cElements[lists[i]].target.id]);
    }
    else if (selected[lists[i]].length==0 && this.actionButtons[this.cElements[lists[i]].target.id] && !transfer)
    {
      this.action=4;
      this.window.removeButton(this.actionButtons[this.cElements[lists[i]].target.id]);
      delete this.actionButtons[this.cElements[lists[i]].target.id];
      this.fleetButtons[this.cElements[lists[i]].target.id].pop();
    }
    else if (selected[lists[i]].length==0 && this.actionButtons[this.cElements[lists[i]].target.id] && transfer)
    {
      this.action=5;
      this.window.removeButton(this.actionButtons[this.cElements[lists[i]].target.id]);
      delete this.actionButtons[this.cElements[lists[i]].target.id];
      this.fleetButtons[this.cElements[lists[i]].target.id].pop();
      globalCTM=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.parentNode.getCTM();
      ctm=this.window.buttons[this.fleetButtons[this.cElements[lists[i]].target.id][0]].element.getCTM();

      this.actionButtons[this.cElements[lists[i]].target.id]=this.window.addButton(this.window.width-85,ctm.f-globalCTM.f,"BUTTON_CIRCLE_SMALL","button_face_transfer","masta.containers['"+this.name+"'].transferToFleet("+this.cElements[lists[i]].target.id+")","Transfer",0);
      this.fleetButtons[this.cElements[lists[i]].target.id].push(this.actionButtons[this.cElements[lists[i]].target.id]);
    }
  }
}

SR_CLASS_FLEET_MANAGEMENT.prototype.transferToFleet = function(fid)
{
  var i,j;
  var selected=new Array;
  var fleets=new Array;
  var count;
  var transArr=new Array;
  var geturlreq="";

  for (i in this.cElements)
  {
    if(this.cElements[i].type=="LIST")
    {
      selected[i]=this.cElements[i].getMarked();
      fleets[i]=this.cElements[i].target;
    }
  }

  for (i in selected)
  {
    if (selected[i].length>0)
    {
      for (j in selected[i])
      {
  count=mSvg.getElementById("count_"+fleets[i].id+"_"+selected[i][j].id).firstChild.data;
  if (typeof(transArr[fleets[i].id])=="undefined")
    transArr[fleets[i].id]=new Array;
  transArr[fleets[i].id][selected[i][j].id]=count;
      }
    }
  }

  for (i in transArr)
  {
    geturlreq+=i+"(";
    for (j in transArr[i])
    {
      geturlreq+=j+"-"+transArr[i][j]+",";
    }
    geturlreq=geturlreq.substring(0,geturlreq.length-1)+"),";
  }
  geturlreq=geturlreq.substring(0,geturlreq.length-1);

  getURL("map_fleetmanagement.php?act=transfer&target="+fid+"&request="+geturlreq,masta.containers[this.name]);
}

SR_CLASS_FLEET_MANAGEMENT.prototype.operationComplete = function (operation)
{
  var i;
  var j;
  try
  {
    if (operation.success)
    {
      masta.itemBox.deleteAllItems();
      showItemBoxItems("fleet");
      var xml_content = parseXML(operation.content);
      var nodes = xml_content.getElementsByTagName("SR_FLEET");

      if (nodes.length==0)
  showMessage(operation.content);

      for (i = 0; i < nodes.length; i++)
      {
  if (nodes.item(i).hasChildNodes())
  {
    var currentNode=nodes.item(i).firstChild;
    var currentFleetNo=this.getFleet(nodes.item(i).getAttribute("fid"));
    if (typeof(currentFleetNo)=="number")
    {
      var currentFleet=this.fleets[currentFleetNo];

      do
      {
        if (currentNode.getAttribute("count")==0)
          delete currentFleet.ships[currentNode.getAttribute("prod_id")];
        else
    currentFleet.ships[currentNode.getAttribute("prod_id")]=new Array(currentNode.getAttribute("count"),currentNode.getAttribute("reload"),currentNode.getAttribute("name"));
      }
      while (currentNode=currentNode.nextSibling);
      try
      {
        this.removeFleet(currentFleetNo);
      }
      catch(e)
      {
        alert("FLEET_MANAGEMENT::removeFleet() caused an error\n\n"+e.name+"\n"+e.message);
      }
      if (currentFleet.getShipCount()>0)
      {
        try
        {
    this.addFleet(currentFleet);
        }
        catch(e)
        {
    alert("FLEET_MANAGEMENT::addFleet() caused an error\n\n"+e.name+"\n"+e.message);
        }
      }
    }
  }
      }
    }
  }
  catch (e)
  {
    alert("FLEET_MANAGEMENT::operationComplete() caused an error\n\n"+e.name+"\n"+e.message);
  }
}

SR_CLASS_FLEET_MANAGEMENT.prototype.getFleet = function(fid)
{
  var i;
  for (i=0;i<this.fleets.length;i++)
  {
    if (this.fleets[i].id==fid)
      return Number(i);
  }
  return false;
}

SR_CLASS_FLEET_MANAGEMENT.prototype.createFleet = function(fid)
{
  var i;
  var selected;
  var fleet;
  var count;
  var transArr=new Array;
  var geturlreq="";

  for (i in this.cElements)
  {
    if(this.cElements[i].type=="LIST")
    {
      if (this.cElements[i].target.id==fid)
      {
  selected=this.cElements[i].getMarked();
  fleet=this.cElements[i].target;
      }
    }
  }

  for (i in selected)
  {
    count=mSvg.getElementById("count_"+fleet.id+"_"+selected[i].id).firstChild.data;
    transArr[selected[i].id]=count;
  }

  geturlreq+=fleet.id+"(";
  for (i in transArr)
  {
    geturlreq+=i+"-"+transArr[i]+",";
  }
  geturlreq=geturlreq.substring(0,geturlreq.length-1)+")";
  getURL("map_fleetmanagement.php?act=create&request="+geturlreq,masta.containers[this.name]);
}

SR_CLASS_FLEET_MANAGEMENT.prototype.rename = function(fid)
{
  getURL("map_fleetmanagement.php?act=rename&fid="+fid+"&new="+mSvg.getElementById("fleet_name_"+fid).firstChild.data,masta.containers[this.name]);
}

SR_CLASS_FLEET_MANAGEMENT.prototype.selectAll = function(number)
{
  var count;
  var i=0;

  for (i in this.fleets[number].ships)
  {
    countText=mSvg.getElementById("count_"+this.fleets[number].id+"_"+i);
    countText.firstChild.setData(this.fleets[number].ships[i][0]);
  }
}
