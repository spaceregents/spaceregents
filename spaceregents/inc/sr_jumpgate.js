function clickOnJumpGate(evt)
{
  eventType="clickOnJumpGate";
  if (evt.target)
  {
    sid=evt.target.correspondingUseElement.parentNode.parentNode.parentNode.id.substr(1);
    if (evt.button==0)
    {
      createLoadingAnimation(0,0);
      getURL("map_getdata.php?act="+eventType+"&sid="+sid, masta.itemBox = new ITEMBOX(eventType, sid, "jumpgate"));
    }
    else if (evt.button==2)
    {
      if (masta.selectedUnits.length==0)
	valid=false;
      else
	valid=true;

      for (i = 0; i < masta.selectedUnits.length; i++)
	valid=valid && masta.selectedUnits[i].itemClass.fleet.sid==sid && masta.selectedUnits[i].itemClass.fleet.pid==0;

      if (valid)
      {
	if (masta.sJumpGate==false && valid)
          setJumpMode(sid);
	else if (masta.sJumpGate!=false && valid)
	  prepareJumpMode(sid);
      }
      else if(masta.sJumpGate!=false)
      {
	prepareJump(sid);
      }
    }
  }
}

function setJumpMode(sid)
{
  masta.sJumpGate=sid;
  mSvg.getElementById("jumpgates").setAttribute("display","inline");
}

function unsetJumpMode()
{
  masta.sJumpGate=false;
  masta.tJumpGate=false;
  mSvg.getElementById("jumpgates").setAttribute("display","none");
}

function prepareJump(sid)
{
  masta.tJumpGate=sid;
  if (masta.sJumpGate!=sid)
  {
    var wWidth =400;
    var wHeight=400;
    
    var relationStart =mSvg.getElementById("j"+masta.sJumpGate).getAttribute("relation");
    var relationTarget=mSvg.getElementById("j"+sid).getAttribute("relation");
    var tonnageStart  =mSvg.getElementById("j"+masta.sJumpGate).getAttribute("tonnage")-mSvg.getElementById("j"+masta.sJumpGate).getAttribute("used_tonnage");
    var tonnageTarget =mSvg.getElementById("j"+sid).getAttribute("tonnage")-mSvg.getElementById("j"+sid).getAttribute("used_tonnage");
    var startName     =mSvg.getElementById("j"+masta.sJumpGate).getAttribute("systemname");
    var targetName    =mSvg.getElementById("j"+sid).getAttribute("systemname");
    
    jumpWindow=new SR_CLASS_WINDOW("jump",(Number(window.innerWidth) / 2) - (wWidth / 2), (Number(window.innerHeight) / 2) - (wHeight / 2),wWidth, wHeight,"Jump",false,true);
    
    var container=sr_create_element("g");
    var i=0;
    var childs=new Array();
    childs[i++] = sr_create_basic_element("path","d","M0,0 L0,400 Q0,0 400,0","class","mapGUIWindowTitleRect");
    childs[i++] = sr_create_text("Initialize Jump",10,30,"mapGUIItemTopic");
    childs[i++] = sr_create_basic_element("path","d","M400,400 L200,400 Q200,200 400,200","class","mapGUIWindowTitleRect");
    childs[i++] = sr_create_rect("250","30","140","160","mapGUIWindowTitleRect");
    childs[i++] = sr_create_image("arts/p_jumpgate.jpg","260","40","75","75");
    childs[i++] = sr_create_text("To: "+targetName,"260","150","mapDialogText2");
    childs[i++] = sr_create_text("Avail. Tonnage: "+tonnageTarget,"260","170","mapDialogText2");
    // --
    childs[i++] = sr_create_rect("40","230","140","160","mapGUIWindowTitleRect");
    childs[i++] = sr_create_image("arts/p_jumpgate.jpg","50","240","75","75");
    childs[i++] = sr_create_text("From: "+startName,"50","350","mapDialogText2");
    childs[i++] = sr_create_text("Avail. Tonnage: "+tonnageStart,"50","370","mapDialogText2");
    // --
    childs[i] = sr_create_basic_element("path","d","M110,220 Q110,95 240,95","stroke","yellow");
    childs[i++].setAttribute("fill","none");
    childs[i] = sr_create_basic_element("path","d","M220,80 L240,95 L220,110","stroke","yellow");
    childs[i++].setAttribute("fill","none");
    // --
    childs[i++] = sr_create_rect(105,105,100,70,"mapGUIWindowTitleRect");
    childs[i++] = sr_create_text("Fleets #"+masta.selectedUnits.length,"110","120","mapDialogText2");
    
    var shipCount=0;
    for (var j = 0; j < masta.selectedUnits.length; j++)
    {
      shipCount+=masta.selectedUnits[j].itemClass.fleet.getShipCount();
    }
    
    childs[i++] = sr_create_text("Ships #"+shipCount,"110","140","mapDialogText2");
    childs[i++] = sr_create_text("Tonnage #todo","110","160","mapDialogText2");
    // --
    childs[i++] = sr_create_rect(255, 255, 135, 135, "mapGUIWindowBgRect",2,2);
    childs[i++] = sr_create_text("Jump possible","260","275","mapGUIItemTopic");
    
    childs[i++] =  sr_create_rect(260,290, 125, 20, "mapGUIWindowBgRect",2,2);
    childs[i] = sr_create_text("Enter startpassword",265,305,"mapDialogText2edit");
    childs[i].setAttribute("editable","true");
    childs[i++].setAttribute("id","startpassword");
    childs[i++] =  sr_create_rect(260,320, 125, 20, "mapGUIWindowBgRect",2,2);
    childs[i] = sr_create_text("Enter targetpassword",265,335,"mapDialogText2edit");
    childs[i].setAttribute("editable","true");
    childs[i++].setAttribute("id","targetpassword");
      
    childs[i++] = sr_create_button("ok","Jump","executeJump("+masta.sJumpGate+","+sid+")",330,360,20,20,"circle");
    //}

    container = sr_append_child_nodes(container,childs);
    container.setAttribute("transform","translate(0,"+jumpWindow.titleHeight+")");
    
    jumpWindow.addRawContent(container);

    masta.addWindow(jumpWindow);
  }
}

function executeJump(src,target)
{
  var fids=new Array;
  for (var j = 0; j < masta.selectedUnits.length; j++)
    fids[fids.length]=masta.selectedUnits[j].itemClass.fleet.id;

  var spass=mSvg.getElementById("startpassword").firstChild.data;
  var tpass=mSvg.getElementById("targetpassword").firstChild.data;

  var url="map_jump.php?src="+src+"&target="+target;

  if (spass)
    url+="&spass="+spass;
  if (tpass)
    url+="&tpass="+tpass;
  
  url+="&fids="+fids.join(",");

  getURL(url,jumpResult);
}

function jumpResult(urlRequestStatus)
{
  if (urlRequestStatus.success)
  {
    if (urlRequestStatus.content=="ok")
    {
      createInfoText("Fleets have successfully jumped!");
      displayPlanets(null,"s"+masta.tJumpGate,true);
    }
    else
    {
      createInfoText(urlRequestStatus.content,"red");
    }
  }
}
