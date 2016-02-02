function SR_CLASS_INF_TRANSFER(itemClass)
{
  if (arguments.length > 0)
    this.init(itemClass);
}

SR_CLASS_INF_TRANSFER.prototype.init = function(itemClass)
{
  var wWidth  = 400;
  var wHeight = 465;

  this.itemClass        = itemClass;
  this.fInf             = new Array();
  this.pInf             = new Array();
  this.fInfOriginal     = new Array();
  this.pInfOriginal     = new Array();
  this.storageInfo      = new Array();
  this.window           = new SR_CLASS_WINDOW("infTransfer",  (Number(window.innerWidth) / 2) - (wWidth / 2), (Number(window.innerHeight) / 2) - (wHeight / 2), wWidth, wHeight, "Infantry Transfer", false, true);
  this.fid              = itemClass.fleet.id;
  this.pid              = false;
  this.maxFleetStorage  = 0;
  this.curFleetStorage  = 0;
  this.baseDef          = 0;      // basis id fuer alle container, flow text regions etc die hier verwendet werden
  this.new_inf_count    = 0;
}


SR_CLASS_INF_TRANSFER.prototype.operationComplete = function(request)
{
  destroyLoadingAnimation();
  if (request.success) {
    // alert(request.content);  // debug
    var requestXML  = parseXML(request.content);
    var requestType = requestXML.firstChild.getAttribute("type");

    switch (requestType) {
      case "inf_transfer_values":
        this.feedFromXML(requestXML);
      break;
      case "MESSAGE":
        showMessage(requestXML.firstChild.firstChild.data);
      break;
      case "transfer_response":
          if (requestXML.firstChild.getAttribute("v") == "1")
          {
            this.itemClass.fleet.setInfCount(this.new_inf_count);
            this.itemClass.fleet.updateCorrespondingItem();
          }
          masta.closeWindow(this.window.windowNo);
      break;
      default:
        throw new Error("SR_CLASS_WINDOW::operationComplete\nunknown requestType: "+requestType+"\nrequest content:\n"+request.content);
      break;
    }
  }
}


SR_CLASS_INF_TRANSFER.prototype.feedFromXML = function(requestXML)
{
  var fleetTag, planetTag, fInfs, pInfs, i, prod_id, count;

  try {
    fleetTag  = requestXML.getElementsByTagName("SR_FLEET").item(0);
    planetTag = requestXML.getElementsByTagName("SR_PLANET").item(0);

    fInfs     = fleetTag.getElementsByTagName("SR_INF");
    pInfs     = planetTag.getElementsByTagName("SR_INF");

    for (i = 0; i < fInfs.length; i++) {
      prod_id = Number(fInfs.item(i).getAttribute("prod_id"));
      count   = Number(fInfs.item(i).getAttribute("count"));
      this.fInf[prod_id]        = count;
      this.fInfOriginal[prod_id]= count;
      this.storageInfo[prod_id] = Number(fInfs.item(i).getAttribute("ton"));
    }

    for (i = 0; i < pInfs.length; i++) {
      prod_id = Number(pInfs.item(i).getAttribute("prod_id"));
      count   = Number(pInfs.item(i).getAttribute("count"));
      this.pInf[prod_id]        = count;
      this.pInfOriginal[prod_id]= count;
      this.storageInfo[prod_id] = Number(pInfs.item(i).getAttribute("ton"));
    }


    this.pid              = Number(planetTag.getAttribute("pid"));
    this.maxFleetStorage  = Number(fleetTag.getAttribute("cap"));
    this.baseDef = "infTrans_"+this.pid+"_"+this.fid;

    this.generate();
  }
  catch (e) {
    alert("SR_CLASS_INF_TRANSFER.prototype.feedFromXML caused an Error!\nCould not construct infantry transfer dialog!\nname: "+e.name+"\nmessage: "+e.message);
    masta.infTransfer = null;
    masta.infTransfer = false;
  }
}


SR_CLASS_INF_TRANSFER.prototype.destroy = function()
{
  this.window.destroy();  
  this.fInf = null;;
  this.pInf = null;
  this.storageInfo = null;
  this.window = null;
}



SR_CLASS_INF_TRANSFER.prototype.generate = function()
{
  var fPage, pPage, fList, pList;
  var pageX = 113;
  var pageW = 280;
  var pageH = 220;
  var fListElements = new Array();
  var pListElements = new Array();
  var fChilds       = new Array();
  var pChilds       = new Array();
  var fInfoElem, pInfoElem, progress;
  var j = 0;
  var m = -1;

  this.window.generate();
  this.curFleetStorage = 0;

  // flotte
  fPage = new SR_CLASS_PAGE(0, window, this.baseDef+"_0", pageX, 20, pageW, pageH);
  fPage.generate();
  masta.addContainer(this.baseDef+"_0", fPage);

  var fChilds = new Array();

  for (i in this.fInf)
  {
    this.curFleetStorage += this.fInf[i] * this.storageInfo[i];
    fListElements[j++] = createInfantryTransferListElement(j, i,  this.fInf[i], this.storageInfo[i],this.baseDef+"_0_", "fleet");
  }

  fList = new SR_CLASS_LIST(fPage, null, 3, 3, pageW - 30, pageH - 25, fListElements);
  fList.setClassMember("itemHeight", 70);
  fList.generate();
  fList.removeListElementsEventListener();
  fPage.addList(fList);
  fPage.updateScrollbar();

  fInfoElem    = sr_create_element("g","transform");
  fChilds[++m] = sr_create_rect(5, 100, 90, 100, "mapGUIWindowTextBoxRect", 5, 5);
  fChilds[++m] = sr_create_text("Fleet", 50, 115, "mapDialogTextSmall2");
  fChilds[++m] = sr_create_flow_text_region_def(0, 120, 100, 20, this.baseDef+"_0_topic");
  fChilds[++m] = sr_create_flow_text(Array(this.itemClass.topic), this.baseDef+"_0_topic", "mapGUITopic");

  fChilds[++m] = sr_create_text("Storage capacity:", 50, 145, "mapDialogTextSmall2");
  fChilds[++m] = sr_create_text((this.maxFleetStorage - this.curFleetStorage)+" / "+this.maxFleetStorage, 50, 160, "mapGUITopic");
  fChilds[m].setAttribute("id","infTransfer_Fleet_Storage_Info");

  fChilds[++m] = sr_create_basic_element("clipPath","id",this.baseDef+"_0_fClip");
    fChilds[m].appendChild(sr_create_circle(50, 50, 40));
  fChilds[++m] = sr_create_image(this.itemClass.picture, 10, 10, 80, 80);
    fChilds[m].setAttribute("clip-path","url(#infTrans_"+this.pid+"_"+this.fid+"_0_fClip)");

  // progress bar
  progress = calculateInfantryTransferProgressbar(this.maxFleetStorage, this.curFleetStorage);
  fChilds[++m] = sr_create_image("arts/storage_symbol.svgz", 2, 201, 20, 17);
  fChilds[++m] = sr_create_static_progress_bar(25, 205, 70, progress, (progress * 100).toFixed(1)+"% of the storage is taken","colorEnemy");
  fChilds[m].setAttribute("id","infTransfer_Fleet_Progress");

  fInfoElem = sr_append_child_nodes(fInfoElem, fChilds);


  // planet
  pPage = new SR_CLASS_PAGE(1, window, this.baseDef+"_1", pageX, 255, pageW, pageH);
  pPage.generate();
  masta.addContainer(this.baseDef+"_1", pPage);

  j = 0;
  for (i in this.pInf)
  {
    pListElements[j++] = createInfantryTransferListElement(j, i,  this.pInf[i], this.storageInfo[i], this.baseDef+"_1_", "planet");
  }

  pList = new SR_CLASS_LIST(pPage, null, 3, 3, pageW - 30, pageH - 25, pListElements);
  pList.setClassMember("itemHeight", 70);
  pList.generate();
  pList.removeListElementsEventListener();
  pPage.addList(pList);
  pPage.updateScrollbar();

  m = -1;

  pInfoElem    = sr_create_basic_element("g","transform", "translate(0 245)");
  pChilds[++m] = sr_create_rect(5, 5, 90, 100, "mapGUIWindowTextBoxRect", 5, 5);
  pChilds[++m] = sr_create_text("Planet", 50, 20, "mapDialogTextSmall2");
  pChilds[++m] = sr_create_flow_text_region_def(0, 25, 100, 50, this.baseDef+"_1_topic");
  pChilds[++m] = sr_create_flow_text(Array(masta.itemBox.header.topic), this.baseDef+"_1_topic", "mapGUITopic");
  pChilds[++m] = sr_create_image(masta.itemBox.header.picture, 10, 130, 80, 80);
  pInfoElem = sr_append_child_nodes(pInfoElem, pChilds);

  // submit button
  var submitBtn = sr_create_basic_element("g","onclick","masta.infTransfer.submit(evt)","cursor","pointer");
  submitBtn.setAttribute("transform","translate("+35+" "+217+")");
  submitBtn.appendChild(sr_create_use("button_circle_big", 0, 0, "mapGUIButton"));
  submitBtn.appendChild(sr_create_text("OK",16, 18, "mapGUITopic"));
  sr_add_status_text(submitBtn, "Click to finish transfer");


  this.window.addRawContent(sr_create_image("arts/inf_transfer_dialog_bg.svgz",0,0, 400, 465));
  this.window.addRawContent(fInfoElem);
  this.window.addRawContent(pInfoElem);
  this.window.addRawContent(submitBtn);
  this.window.addComponent(fPage, true);
  this.window.addComponent(pPage, true);
  masta.addWindow(this.window);
}


SR_CLASS_INF_TRANSFER.prototype.transfer = function(evt, prod_id, count, from)
{
  if (evt.detail == 1)
  {
    var infSource, infTarget;
    var limit = false;
    var free;

    if (from == "fleet")
    {
      infSource = this.fInf;
      infTarget = this.pInf;
    }
    else
    {
      infSource = this.pInf;
      infTarget = this.fInf;
      limit = true;
    }

    if (count > infSource[prod_id])
      count = infSource[prod_id];

    if (limit)
    {
      free = this.maxFleetStorage - this.curFleetStorage;
      if (count * this.storageInfo[prod_id] > free)
        count = Math.floor(free / this.storageInfo[prod_id]);
    }

    infSource[prod_id] -= count;

    if (infTarget[prod_id]) {
      infTarget[prod_id] += count;
    }
    else
      infTarget[prod_id] = count;


    if (from == "fleet")
    {
      this.fInf = infSource;
      this.pInf = infTarget;
    }
    else
    {
      this.pInf = infSource;
      this.fInf = infTarget;
    }

    this.update();
  }
}

SR_CLASS_INF_TRANSFER.prototype.update = function()
{
  var i, j = 0;
  var fList, pList;
  var fListElements = new Array();
  var pListElements = new Array();
  var progress, progressBar;

  this.curFleetStorage = 0;

  for (i in this.fInf)
  {
    if (this.fInf[i] > 0) {
      this.curFleetStorage += this.fInf[i] * this.storageInfo[i];
      fListElements[j++] = createInfantryTransferListElement(j, i,  this.fInf[i], this.storageInfo[i],this.baseDef+"_0_", "fleet");
    }
  }

  fList = new SR_CLASS_LIST(this.window.components[0], null, 3, 3, this.window.components[0].width - 30,this.window.components[0].height - 25, fListElements);
  fList.setClassMember("itemHeight", 70);
  fList.generate();
  fList.removeListElementsEventListener();

  this.window.components[0].replaceList(fList);

  j = 0;
  for (i in this.pInf)
  {
    if (this.pInf[i] > 0)
      pListElements[j++] = createInfantryTransferListElement(j, i,  this.pInf[i], this.storageInfo[i],this.baseDef+"_1_", "planet");
  }

  pList = new SR_CLASS_LIST(this.window.components[1], null, 3, 3, this.window.components[1].width - 30,this.window.components[1].height - 25, pListElements);
  pList.setClassMember("itemHeight", 70);
  pList.generate();
  pList.removeListElementsEventListener();

  this.window.components[1].replaceList(pList);

  progress    = calculateInfantryTransferProgressbar(this.maxFleetStorage, this.curFleetStorage);
  progressBar = sr_create_static_progress_bar(25, 205, 70, progress, (progress * 100).toFixed(1)+"% of the storage is taken","colorEnemy");
  progressBar.setAttribute("id","infTransfer_Fleet_Progress");

  pSvgDoc.getElementById("infTransfer_Fleet_Storage_Info").firstChild.data = (this.maxFleetStorage - this.curFleetStorage)+"/"+this.maxFleetStorage;
  pSvgDoc.getElementById("infTransfer_Fleet_Progress").parentNode.replaceChild(progressBar, pSvgDoc.getElementById("infTransfer_Fleet_Progress"));
}

SR_CLASS_INF_TRANSFER.prototype.submit = function(evt)
{
  if (evt.detail == 1)
  {
    var submitStr = "map_inf_transfer.php?act=submit&fid="+this.fid+"&pid="+this.pid;
    var i;
    var jo = false;
    this.new_inf_count = 0;

    for (i in this.fInf)
    {
      if (this.fInf[i] != this.fInfOriginal[i])
      {
        jo = true;      
        this.new_inf_count += this.fInf[i];

        if (!this.fInfOriginal[i])
          this.fInfOriginal[i] = 0;

        submitStr += "&tr["+i+"]="+(this.fInf[i] - this.fInfOriginal[i]);
      }
    }

    if (jo == true)
    {
      createLoadingAnimation();
      getURL(submitStr, this);
    }
    else
      masta.closeWindow(this.window.windowNo);
  }
}



function createInfantryTransferListElement(pos, prod_id, count, storage, baseDef, from)
{
  var listElemPic = sr_create_image(__prodInfo[prod_id].getImage(), 1.5, 1.5, 60, 60);
  var listElemTopicDef = sr_create_flow_text_region_def(65, 0, 155, 40, baseDef+"item_"+pos);
  var listElemTopic    = sr_create_flow_text(Array(__prodInfo[prod_id].name, "# "+count), baseDef+"item_"+pos, "mapDialogText2");
  var listElemBtnRect  = sr_create_rect(65, 35, 175, 25, "mapGUIWindowBgRect", 5, 5);
  var storageSymbol    = sr_create_image("arts/storage_symbol.svgz", 173, 10, 20, 17);
  sr_add_status_text(storageSymbol, "Storage room needed per unit");
  var storageText      = sr_create_text(storage, 198, 22, "mapDialogText2");


  // transfer buttons
  var buttons = sr_create_basic_element("g","cursor","pointer");
  var btn1   = sr_create_basic_element("g","onclick","masta.infTransfer.transfer("+prod_id+",1,'"+from+"');", "transform","translate("+68+" "+32+")");
      sr_add_status_text(btn1, "Transfer 1 unit");
      btn1.appendChild(sr_create_use("button_circle_big", 0, 0, "mapGUIButton"));
      btn1.appendChild(sr_create_text("1",16, 18, "mapGUITopic"));


  var btn10   = sr_create_basic_element("g","onclick","masta.infTransfer.transfer(evt, "+prod_id+",10,'"+from+"');", "transform","translate("+103+" "+32+")");
      sr_add_status_text(btn10, "Transfer 10 units");
      btn10.appendChild(sr_create_use("button_circle_big", 0, 0, "mapGUIButton"));
      btn10.appendChild(sr_create_text("10",16, 18, "mapGUITopic"));

  var btn100   = sr_create_basic_element("g","onclick","masta.infTransfer.transfer(evt, "+prod_id+",100,'"+from+"');", "transform","translate("+138+" "+32+")");
      sr_add_status_text(btn100, "Transfer 100 units");
      btn100.appendChild(sr_create_use("button_circle_big", 0, 0, "mapGUIButton"));
      btn100.appendChild(sr_create_text("100",16, 18, "mapGUITopic"));

  var btn500   = sr_create_basic_element("g","onclick","masta.infTransfer.transfer(evt, "+prod_id+",500,'"+from+"');", "transform","translate("+173+" "+32+")");
      sr_add_status_text(btn500, "Transfer 500 units");
      btn500.appendChild(sr_create_use("button_circle_big", 0, 0, "mapGUIButton"));
      btn500.appendChild(sr_create_text("500",16, 18, "mapGUITopic"));

  var btn1k   = sr_create_basic_element("g","onclick","masta.infTransfer.transfer(evt, "+prod_id+",1000,'"+from+"');", "transform","translate("+208+" "+32+")");
      sr_add_status_text(btn1k, "Transfer 1000 units");
      btn1k.appendChild(sr_create_use("button_circle_big", 0, 0, "mapGUIButton"));
      btn1k.appendChild(sr_create_text("1k",16, 18, "mapGUITopic"));

  buttons.appendChild(btn1);
  buttons.appendChild(btn10);
  buttons.appendChild(btn100);
  buttons.appendChild(btn500);
  buttons.appendChild(btn1k);


  var listElement = new Array(pos, listElemPic, listElemTopicDef, listElemTopic, storageSymbol, storageText, listElemBtnRect, buttons);

  return listElement;
}


function calculateInfantryTransferProgressbar(max_cap, curr_storage)
{
  var progress = (curr_storage / max_cap).toFixed(3);
  return progress;
}