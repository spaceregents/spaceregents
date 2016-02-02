function createExamineFleet(window, requestXML) {
  var ships = requestXML.getElementsByTagName("SR_SHIP");
  var admiral = requestXML.getElementsByTagName("SR_ADMIRAL");
  var i;
  var listElements = new Array();
  var fList;
  var fPage;
  var fPicElem;
  var fid = requestXML.firstChild.getAttribute("fid");
  var cElementId = "ctrl_exfl_"+fid;

  window.generate();
  
  window.addRawContent(sr_create_image("arts/exam_fleet_bg.svgz",0,0,335,400));
  
  var fPic_clipPath = sr_create_clippath(sr_create_circle(47,47,40), "ctrl_exfl_"+fid+"_clip");
  window.addRawContent(fPic_clipPath);
  
  var fPic = requestXML.firstChild.getAttribute("pic");
  if (fPic != "ADMIRAL")
    fPicElem = sr_create_image(__prodInfo[fPic].getImage(),7,7,80,80);
  else {
    if (admiral.length > 0) {
      admiral = admiral.item(0);
      fPicElem = sr_create_image("portraits/"+admiral.getAttribute("pic"),7,7,80,80);
      
      window.addRawContent(sr_create_text("Admiral :", 35, 120, "mapGUIBigTopic"));
      
      var admiral_flow_region = sr_create_flow_text_region_def(5, 140, 60, 50, cElementId+"_admiral");
      window.addRawContent(admiral_flow_region);
      window.addRawContent(sr_create_flow_text(new Array(admiral.getAttribute("name")), cElementId+"_admiral", "mapGUIBigTopic"));
      window.addRawContent(sr_create_text("Level "+admiral.getAttribute("level"), 35, 190, "mapGUIBigTopic"));
    }
  }
  
  if (fPicElem) {
    fPicElem.setAttribute("clip-path","url(#ctrl_exfl_"+fid+"_clip)");
    window.addRawContent(fPicElem);
  }
  
  // mission
  var missionElem = requestXML.getElementsByTagName("SR_FLEET_MISSION");
  
  if (missionElem.length > 0){
    missionElem = missionElem.item(0);
    var missionPic = sr_create_image("arts/"+missionElem.getAttribute("mission"), 101, 12, 30, 30);
    sr_add_status_text(missionPic, missionElem.getAttribute("missionText"));
    window.addRawContent(missionPic);
    
    window.addRawContent(sr_create_text("Going to:", 165, 15, "mapGUIBigTopic"));
    window.addRawContent(sr_create_text("ETA: "+requestXML.firstChild.getAttribute("eta"), 250, 15, "mapGUIWindowTitle"));
    
    var tpla_name = missionElem.getAttribute("tpla_name");
    if (tpla_name) {
      window.addRawContent(sr_create_image("arts/"+missionElem.getAttribute("tpla_type")+"_small.gif", 150, 22, 10, 10));
      window.addRawContent(sr_create_text(tpla_name, 165, 30, "mapGUIWindowTitle"));
    }
    else
      window.addRawContent(sr_create_text(" - ", 165, 30, "mapGUIWindowTitle"));
    
    var tsys_name = missionElem.getAttribute("tsys_name");
    if (tsys_name) {
      window.addRawContent(sr_create_text(tsys_name, 165, 45, "mapGUIWindowTitle"));
    }
    
    //tactic
    var fTactic = Number(missionElem.getAttribute("tactic"));
    var fTacticPic;
    var tacX = 101;
    var tacY = 55;
    
    if (fTactic == -1) {
      for (var i = 0; i < 6; i++)
      {        
        fTacticPic = sr_create_image("arts/fleet_tactic_UNKNOWN.svgz", tacX, tacY, 30, 30);
        sr_add_status_text(fTacticPic, "unknown");
        window.addRawContent(fTacticPic);
        tacX += 40.5;
      }
    }
    else {
      if ((fTactic & 1) == 1)
        fTacticPic = sr_create_image("arts/fleet_tactic_SCOUT2.svgz", tacX, tacY, 30, 30);
      else
        fTacticPic = sr_create_image("arts/fleet_tactic_SCOUT.svgz", tacX, tacY, 30, 30);
      sr_add_status_text(fTacticPic, "SCOUT");
      window.addRawContent(fTacticPic);
      tacX += 40.5;

      if ((fTactic & 2) == 2)
        fTacticPic = sr_create_image("arts/fleet_tactic_FLEE252.svgz", tacX, tacY, 30, 30);
      else
        fTacticPic = sr_create_image("arts/fleet_tactic_FLEE25.svgz", tacX, tacY, 30, 30);
      sr_add_status_text(fTacticPic, "FLEE 25");
      window.addRawContent(fTacticPic);
      tacX += 40.5;
      
      if ((fTactic & 4) == 4)
        fTacticPic = sr_create_image("arts/fleet_tactic_FLEE502.svgz", tacX, tacY, 30, 30);
      else
        fTacticPic = sr_create_image("arts/fleet_tactic_FLEE50.svgz", tacX, tacY, 30, 30);
      sr_add_status_text(fTacticPic, "FLEE 50");
      window.addRawContent(fTacticPic);
      tacX += 40.5;

      if ((fTactic & 8) == 8)
        fTacticPic = sr_create_image("arts/fleet_tactic_FLEE752.svgz", tacX, tacY, 30, 30);
      else
        fTacticPic = sr_create_image("arts/fleet_tactic_FLEE75.svgz", tacX, tacY, 30, 30);
      sr_add_status_text(fTacticPic, "FLEE 75");
      window.addRawContent(fTacticPic);
      tacX += 40.5;

      if ((fTactic & 16) == 16)
        fTacticPic = sr_create_image("arts/fleet_tactic_TRANSPORTERRAID2.svgz", tacX, tacY, 30, 30);
      else
        fTacticPic = sr_create_image("arts/fleet_tactic_TRANSPORTERRAID.svgz", tacX, tacY, 30, 30);
      sr_add_status_text(fTacticPic, "TRANSPORTER RAID");
      window.addRawContent(fTacticPic);
      tacX += 40.5;

      if ((fTactic & 32) == 32)
        fTacticPic = sr_create_image("arts/fleet_tactic_STORMATTACK2.svgz", tacX, tacY, 30, 30);
      else
        fTacticPic = sr_create_image("arts/fleet_tactic_STORMATTACK.svgz", tacX, tacY, 30, 30);
      sr_add_status_text(fTacticPic, "STORMATTACK");
      window.addRawContent(fTacticPic);
    }        
  }
  
  fPage = new SR_CLASS_PAGE(0, window, cElementId, 95, 110, 230, 300);
  fPage.generate();
  masta.addContainer(cElementId, fPage);  
    
  for (i = 0; i < ships.length; i++) {
    listElements[i] = create_examine_fleet_lElement(i, ships.item(i));  
  }

  fList = new SR_CLASS_LIST(fPage, null, 3, 3, fPage.width - 30, fPage.height - 25, listElements);
  fList.setClassMember("itemHeight", 60);
  fList.generate();
  fList.removeListElementsEventListener();
  
  fPage.addList(fList);
  fPage.updateScrollbar();
  
  window.addComponent(fPage, true);
  masta.addWindow(window);
}


function create_examine_fleet_lElement(pos, elem) {
  var prod_id = elem.getAttribute("prod_id");
  var reload  = Number(elem.getAttribute("reload"));
  var pic   = sr_create_image(__prodInfo[prod_id].getImage(), 0, 0, 50, 50);
  var name  = sr_create_text(__prodInfo[prod_id].name,55, 10,"mapDialogText2");
  var count = sr_create_text("# "+elem.getAttribute("count"),55,23,"mapDialogText2");

  var its_reload    = sr_create_element("g");
  var reloadChilds  = new Array();
  reloadChilds[0]   = sr_create_rect(20, 40, 30, 13, "itemDarkBg", 5, 5);
  reloadChilds[1]   = sr_create_circle(27, 46, 7, "itemDarkBg");
  reloadChilds[2]   = sr_create_circle(27, 46, 5);

  if (reload > 0) {
    reloadChilds[2].setAttribute("fill","url(#gREnemy)");
    sr_add_status_text(its_reload,"These ships must refuel their engines for "+reload+" "+masta.zeitEinheit);
  }
  else
  if (reload < 0)
  {
    reloadChilds[2].setAttribute("fill","#555555");
    sr_add_status_text(its_reload,"unknown refuel time.");
    reload = "?";
  }
  else
  {
    reloadChilds[2].setAttribute("fill","url(#gROwn)");
    sr_add_status_text(its_reload,"These ships are READY to jump.");
  }
  
  reloadChilds[3]   = sr_create_text(reload, 35, 50, "mapGUIItemFooterText");
  its_reload        = sr_append_child_nodes(its_reload, reloadChilds);
  
  return new Array(pos, pic, name, count, its_reload);
}