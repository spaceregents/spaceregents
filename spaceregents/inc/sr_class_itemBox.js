/***********************
 *
 * class ITEMBOX(evtType, oid, caller)
 *
 **********************/
function ITEMBOX(evtType, oid, caller)
{
  this.evtType  = evtType;

  this.header = 0;
  this.item   = new Array();
  this.baseX  = window.innerWidth - 200;
  this.baseY  = 200;
  this.oid    = oid;                      // object ID
  this.caller = caller;                   // object type (planet, star...)
  this.itemContainer  = sr_create_basic_element("g","transform","translate(0 0)","","");
  this.itemBoxElement = 0;
  this.lastScrollPos  = 0;
  this.availItemHeight= 0;
  this.max_visible_items  = 0;
  this.scroll_pos         = 1;
  
  // methods
  this.newItemBox     = ITEMBOX_newItemBox;
  this.generate       = ITEMBOX_generate;
  this.show           = ITEMBOX_show;
  this.addItems       = ITEMBOX_addItems;
  this.showAllItems   = ITEMBOX_showAllItems;
  this.deleteAllItems = ITEMBOX_deleteAllItems;
  this.destroy        = ITEMBOX_destroy;
  this.scroll         = ITEMBOX_scroll;
  this.operationComplete=ITEMBOX_operationComplete;


      /***********************
       * ITEMBOX.prototype.operationComplete(operation)
       **********************/
      function ITEMBOX_operationComplete(operation)
      {
        var dataHandlingHint;
        var eol;
        var newContent;

        destroyLoadingAnimation();
        try
        {
          if (operation.success)
          {
            eol = operation.content.indexOf("\n");

            // get dataHandlingHint
            dataHandlingHint = operation.content.substring(0, eol);

            // slice hint out of content
            newContent = operation.content.slice(eol+1);
            switch (dataHandlingHint)
            {
              case "newItemBox":
                this.newItemBox(newContent);
              break;
              case "newItems":
                this.addItems(newContent);
              break;
            }

          }
          else
            alert("Server error");
        }
        catch (e)
        {
          alert("ITEMBOX::operationComplete() caused an error\n\n"+e.name+"\n"+e.message);
        }
      }

      /***********************
       * ITEMBOX_newItemBox(operation_content)
       **********************/
      function ITEMBOX_newItemBox(operation_content)
      {
        var parsedData  = parseXML(operation_content);
        var newHeader   = parsedData.getElementsByTagName("SR_HEAD");
        var newItems    = parsedData.getElementsByTagName("SR_ITEM");
        var i           = 0;

        try {
          newHeader   = parsedData.getElementsByTagName("SR_HEAD");
          newItems    = parsedData.getElementsByTagName("SR_ITEM");

          // create new header
          this.header = new ITEMBOX_HEADER(newHeader.item(0));
        }
        catch (e) {
          alert("ITEMBOX::newItemBox() caused an error\n\n"+e.name+"\n"+e.message);
        }

        this.generate();
        this.show();
      }


      /***********************
       * ITEMBOX_generate()
       **********************/
      function ITEMBOX_generate() {
        try {
          var newItemBox = sr_create_basic_element("g","id","sr_itemBox","","");
          var newHeader = this.header.create();
          var i;
          
          for (i = 0; i < this.header.buttons.length; i++)
            newHeader.appendChild(this.header.buttons[i].element);

          newItemBox.appendChild(newHeader);

          this.max_visible_items = Math.floor((window.innerHeight - this.baseY - this.header.height) / (baseItemHeight + baseItemSpacer));

          var clipRect = sr_create_rect(-200, 0, 400, this.max_visible_items * (baseItemHeight + baseItemSpacer));
          var clipPath = sr_create_clippath(clipRect, "itemBoxClipper_"+this.oid);
          newItemBox.appendChild(clipPath);

          var globalContainer = sr_create_element("g");
          globalContainer     = sr_create_basic_element("g","transform","translate("+baseItemX+" "+baseItemY+")");
          globalContainer.setAttribute("clip-path","url(#itemBoxClipper_"+this.oid+")");

          globalContainer.appendChild(this.itemContainer);

          newItemBox.appendChild(globalContainer);

          this.itemBoxElement = newItemBox;
          // put ITEMBOX into cache

          if (typeof(this.header.hasFleet) != "boolean") {
            eval(this.header.buttons[this.header.hasFleet].action);
            this.header.buttons[this.header.hasFleet].click();
          }

          
          masta.cache.addObject("itemBox",this);
        }
        catch (e) {
          alert("ITEMBOX::generate() caused an error\n\n"+e.name+"\n"+e.message);
        }
      }


      /***********************
       * ITEMBOX_show()
       **********************/
      function ITEMBOX_show()
      {
        var oldItemBox;

        try {
          if (oldItemBox = pSvgDoc.getElementById("sr_itemBox"))
          {
            oldItemBox.parentNode.removeChild(oldItemBox);
          }

          pSvg.appendChild(this.itemBoxElement);
        }
        catch (e) {
          alert("ITEMBOX::show() caused an error\n\n"+e.name+"\n"+e.message);
        }
      }


      /***********************
       * ITEMBOX_addItems(operation_content)
       **********************/
      function ITEMBOX_addItems(operation_content)
      {
        try {
          var xml_content = parseXML(operation_content);
          var newItemsNodeList = xml_content.getElementsByTagName("SR_ITEM");
          var itemType;
          var i;

          for (i = 0; i < newItemsNodeList.length; i++)
          {
            switch (newItemsNodeList.item(i).getAttribute("itemType"))
            {
              case "FLEET_ITEM":
               this.item[i] = createFleetItem(newItemsNodeList.item(i), i);
              break;
              case "ADVANCED_FLEET_ITEM":
               this.item[i] = createAdvancedFleetItem(newItemsNodeList.item(i), i);
              break;
              case "FULL_FLEET_ITEM":
               this.item[i] = createFullFleetItem(newItemsNodeList.item(i), i);
              break;
              case "BASIC_ITEM":
              break;
            }

            this.item[i].generate();
            this.itemContainer.appendChild(this.item[i].itemElement);
          }
          
          var scrollGroup = this.itemBoxElement.lastChild;
          if (scrollGroup.getAttribute("id") == "scrollGroup_"+this.oid)
            scrollGroup.parentNode.removeChild(scrollGroup);
            
          if (this.item.length > this.max_visible_items)
          {
            scrollGroup = sr_create_basic_element("g","id","scrollGroup_"+this.oid);
            
            var scrollY = this.baseY+this.header.height;
            var scrollImg   = sr_create_image("arts/item_box_scroller.svgz", this.baseX - 49, scrollY+4, 231, 37);
            var scrollImgUp   = sr_create_image("arts/item_box_scroll_up.svgz",   this.baseX - 49, scrollY + 7, 30, 14);
            var scrollImgDown = sr_create_image("arts/item_box_scroll_down.svgz", this.baseX - 49, scrollY + 22, 30, 14);
            scrollImgUp.setAttribute("onclick","masta.itemBox.scroll('UP')");
            scrollImgUp.setAttribute("cursor","pointer");
            scrollImgDown.setAttribute("onclick","masta.itemBox.scroll('DOWN')");
            scrollImgDown.setAttribute("cursor","pointer");
            sr_add_status_text(scrollImgUp, "Scroll fleets up");
            sr_add_status_text(scrollImgDown, "Scroll fleets down");
            
            var scrollMax = this.max_visible_items * (baseItemHeight+baseItemSpacer);
            var scrollRel = scrollMax / this.item.length;
            
            var scrollIndiactorBG = sr_create_rect(this.baseX + 170, scrollY + 30, 10, scrollMax, "mapGUIWindowBgRect");
            var scrollIndicator   = sr_create_rect(this.baseX + 171, scrollY + 30, 8, this.max_visible_items * scrollRel, "mapGUIWindowTextBoxRect", 2, 2);
            scrollIndicator.setAttribute("id","scrollIndi_"+this.oid);
            
            scrollGroup.appendChild(scrollImg);
            scrollGroup.appendChild(scrollImgUp);
            scrollGroup.appendChild(scrollImgDown);
            scrollGroup.appendChild(scrollIndiactorBG);
            scrollGroup.appendChild(scrollIndicator);   // Dieses Element muss das letzte child der scrollGroup sein
            
            this.itemBoxElement.appendChild(scrollGroup); // Die scrollGroup muss letztes child des itemBoxElement sein
            
            this.itemContainer.setAttribute("transform","translate(-10 0)");
          }
          
          this.showAllItems();
        }
        catch (e) {
          alert("ITEMBOX::addItems() caused an error\n\n"+e.name+"\n"+e.message);
        }
      }
      
      function ITEMBOX_scroll(scroll_to) {
        var scroll_it = false;
        switch (scroll_to)
        {
          case "UP":
            if (this.scroll_pos > 1)
            {
              this.scroll_pos--;
              scroll_it = true;
            }
          break;
          case "DOWN":
            if (this.scroll_pos <= this.item.length - this.max_visible_items)
            {
              this.scroll_pos++;
              scroll_it = true;
            }
          break;
        }
        
        if (scroll_it)
        {
          var scrollMax = this.max_visible_items * (baseItemHeight+baseItemSpacer);
          var scrollRel = scrollMax / this.item.length;          
          this.itemContainer.setAttribute("transform","translate(-10 "+((this.scroll_pos - 1) * -(baseItemHeight + baseItemSpacer))+")");
          this.itemBoxElement.lastChild.lastChild.setAttribute("transform", "translate(0 "+((this.scroll_pos - 1) * scrollRel)+")");
        }
      }

      /***********************
       * ITEMBOX_showAllItems()
       **********************/
       function ITEMBOX_showAllItems() {
         var i;
         for (i = 0; i < this.item.length; i++)
           this.item[i].show();
       }

      /***********************
       * ITEMBOX_deleteAllItems()
       **********************/
       function ITEMBOX_deleteAllItems() {
         var i;
         var parent;

          for (i in this.item)
            this.item[i] = null;

         this.item=new Array;
         parent=this.itemContainer.parentNode;
         parent.removeChild(this.itemContainer);
         this.itemContainer  = sr_create_basic_element("g","transform","translate(0 0)");
         parent.appendChild(this.itemContainer);
       }


      /***********************
       * ITEMBOX_destroy()
       **********************/
       function ITEMBOX_destroy() {
         try {
           this.deleteAllItems();
           this.header.destroy();
           this.header = null;
           this.caller = null;
           this.itemBoxElement = null;
         }
         catch (e) {
          alert("ITEMBOX::destroy() caused an error\n\n"+e.name+"\n"+e.message);
        }
       }

    ITEMBOX.prototype.handleEvent=function(evt)
    {
    }
 };
//-----------------------------------------------------------------------------------------------------------------------------
//-----------------------------------------------------------------------------------------------------------------------------



//*****************************************************************************************************************************
//                              ITEMBOX HEADER
//*****************************************************************************************************************************
function ITEMBOX_HEADER(headerNode)
{
  // this.node     = headerNode;
  this.picture  = headerNode.getAttribute("picture");
  this.topic    = headerNode.getAttribute("topic");
  this.text     = headerNode.getAttribute("text");
  this.symbol   = headerNode.getAttribute("a_symbol");
  this.acolor   = headerNode.getAttribute("a_color");
  this.aname    = headerNode.getAttribute("a_name");
  this.kontur   = headerNode.getAttribute("kontur");
  this.me       = headerNode.getAttribute("me");
  this.en       = headerNode.getAttribute("en");
  this.mo       = headerNode.getAttribute("mo");
  this.er       = headerNode.getAttribute("er");
  this.go       = headerNode.getAttribute("go");
  this.su       = headerNode.getAttribute("su");

  this.buttons  = new Array();    // max 3
  this.buttonActivated = 0;       // 0 keins, 1-3 von links

  this.stencil  = "inc/sr_GUI_itemBoxHeader.svgz#itemBoxHeader";
  this.x          = window.innerWidth - 220;
  this.y          = 220;
  this.width      = 200;
  this.height     = 90;
  this.picWidth  = 80;
  this.picHeight = 80;
  this.picX       = 5;
  this.picY       = 5;
  this.topicX     = 145;
  this.topicY     = 15;
  this.textX      = 145;
  this.textY      = 40;
  this.buttonX    = 90;
  this.buttonY    = 55;
  this.buttonWidth  = 30;
  this.buttonSpacer = 7;
  this.hasFleet   = false;

  this.element = 0;

  // METHODS
  this.addButtons         = ITEMBOX_HEADER_addButtons;
  this.showButtons        = ITEMBOX_HEADER_showButtons;
  this.create             = ITEMBOX_HEADER_create;
  this.setActivatedButton = ITEMBOX_HEADER_setActivatedButton;
  this.destroy            = ITEMBOX_HEADER_destroy;

  this.addButtons(headerNode);


      function ITEMBOX_HEADER_addButtons(headerNode)
      {
        var i;
        var buttonNodes = headerNode.getElementsByTagName("SR_BUTTON");
        var new_face;
        var new_action;
        var new_active;
        var new_shape;
        var new_tooltip;

        try {
          for (i = 0; i < buttonNodes.length; i++) {
            new_face   = buttonNodes.item(i).getAttribute("face");
            new_action = buttonNodes.item(i).getAttribute("action");
            new_active = buttonNodes.item(i).getAttribute("active");
            new_shape  = buttonNodes.item(i).getAttribute("shape");
            new_tooltip= buttonNodes.item(i).getAttribute("tooltip");

            if (new_face == "button_face_ship")
              this.hasFleet = i;

            this.buttons[i] = new SR_CLASS_BUTTON(i, (this.buttonX+(i * this.buttonWidth)+(i * this.buttonSpacer)), this.buttonY,  "BUTTON_CIRCLE_BIG", new_face, new_action, new_tooltip, "masta.itemBox.header");
            this.buttons[i].generate();
          }
        }
        catch (e) {
          alert("ITEMBOX_HEADER::addButtons caused an error.\n"+e.name+"\n"+e.message);
        }
      }


      function ITEMBOX_HEADER_showButtons() {
        var i;

        for (i = 0; i < this.buttons.length; i++) {
          this.element.appendChild(this.buttons[i].element);
        }
      }


      function ITEMBOX_HEADER_create()
      {
        var newHeader;
        var newHeaderChilds = new Array();
        var newClipPath;
        var newRegion;
        var i = 0;

        // first create stencil
        newHeaderChilds[i] = sr_create_image(this.stencil, 0, 0, this.width, this.height);

        // create image clippath
        newClipPath = sr_create_circle(this.picX + (this.picWidth / 2), this.picY + (this.picHeight / 2), this.picHeight / 2);

        newHeaderChilds[++i] = sr_create_basic_element("clipPath","id","itemBoxHeader_imageClipPath","","");
        newHeaderChilds[i].appendChild(newClipPath);
        // create Background Circle
        if (this.kontur)
          newHeaderChilds[++i] = sr_create_circle(this.picX + (this.picWidth / 2), this.picY + (this.picHeight / 2), (this.picHeight / 2) + 1,this.kontur);

        // create image
        newHeaderChilds[++i] = sr_create_image(this.picture, this.picX, this.picY, this.picWidth, this.picHeight);
        newHeaderChilds[i].setAttribute("clip-path","url(#itemBoxHeader_imageClipPath)");

        // create topic
        newRegion = sr_create_rect(this.topicX - 60, 5, 115, 30);
        newRegion.setAttribute("id","itemBoxHeader_topicRegion");

        newHeaderChilds[++i] = sr_create_element("defs");
        newHeaderChilds[i].appendChild(newRegion);

        newHeaderChilds[++i] = sr_create_flow_text(Array(this.topic), "itemBoxHeader_topicRegion", "mapGUIBigTopic");

        // create text
        if (this.text)
        {
          newRegion = sr_create_rect(this.textX - 60, this.textY - 5, 115, 30);
          newRegion.setAttribute("id","itemBoxHeader_textRegion");

          newHeaderChilds[++i] = sr_create_element("defs");
          newHeaderChilds[i].appendChild(newRegion);

          newHeaderChilds[++i] = sr_create_flow_text(Array(this.text), "itemBoxHeader_textRegion", "mapGUITopic");
        }
        
        // alliance
        if (this.aname) {
          newHeaderChilds[++i] = sr_create_circle(this.picX + 15, this.picY + this.picHeight - 15, 15);
          newHeaderChilds[i].setAttribute("style","fill:black;stroke:"+this.acolor+";stroke-width:2px;");
          newHeaderChilds[i].setAttribute("onmouseover","updateStatusText('Alliance: "+this.aname+"')");
          newHeaderChilds[i].setAttribute("onmouseout","updateStatusText('')");
          
          if (this.symbol) {
            newHeaderChilds[++i] = sr_create_clippath(newHeaderChilds[i-1], "head_symb_clip");
            newHeaderChilds[++i] = sr_create_image(this.symbol, this.picX, this.picY + this.picHeight - 30, 30, 30);
            newHeaderChilds[i].setAttribute("pointer-events","none");
            newHeaderChilds[i].setAttribute("clip-path","url(#head_symb_clip)");            
          }
        }
        
        // resources
        var resX = this.picX + this.picWidth - 15;
        var resY = this.picY + 5;
        
        if (this.me) {
          newHeaderChilds[++i] = sr_create_circle(resX+5, resY+7.5, 8, "mapGUI3");
          sr_add_status_text(newHeaderChilds[i], this.me);
          newHeaderChilds[++i] = sr_create_image("arts/metal.gif", resX, resY,10,15);
          newHeaderChilds[i].setAttribute("pointer-events","none");
          resY += 20;
        }
        
        if (this.en) {
          newHeaderChilds[++i] = sr_create_circle(resX+5, resY+7.5, 8, "mapGUI3");
          sr_add_status_text(newHeaderChilds[i], this.en);
          newHeaderChilds[++i] = sr_create_image("arts/energy.gif", resX, resY,10,15);
          newHeaderChilds[i].setAttribute("pointer-events","none");
          resY += 20;
        }

        if (this.mo) {
          newHeaderChilds[++i] = sr_create_circle(resX+5, resY+7.5, 8, "mapGUI3");
          sr_add_status_text(newHeaderChilds[i], this.mo);
          newHeaderChilds[++i] = sr_create_image("arts/mopgas.gif", resX, resY,10,15);
          newHeaderChilds[i].setAttribute("pointer-events","none");
          resY += 20;
        }

        if (this.er) {
          newHeaderChilds[++i] = sr_create_circle(resX+5, resY+7.5, 8, "mapGUI3");
          sr_add_status_text(newHeaderChilds[i], this.er);
          newHeaderChilds[++i] = sr_create_image("arts/erkunum.gif", resX, resY,10,15);
          newHeaderChilds[i].setAttribute("pointer-events","none");
          resY += 20;
        }

        if (this.go) {
          newHeaderChilds[++i] = sr_create_circle(resX+5, resY+7.5, 8, "mapGUI3");
          sr_add_status_text(newHeaderChilds[i], this.go);
          newHeaderChilds[++i] = sr_create_image("arts/gortium.gif", resX, resY,10,15);
          newHeaderChilds[i].setAttribute("pointer-events","none");
          resY += 20;
        }

        if (this.su) {
          newHeaderChilds[++i] = sr_create_circle(resX+5, resY+7.5, 8, "mapGUI3");
          sr_add_status_text(newHeaderChilds[i], this.su);
          newHeaderChilds[++i] = sr_create_image("arts/susebloom.gif", resX, resY,10,15);
          newHeaderChilds[i].setAttribute("pointer-events","none");
        }
        

        // create header group
        newHeader = sr_create_basic_element("g", "transform", "translate("+this.x+" "+this.y+")");

        newHeader = sr_append_child_nodes(newHeader, newHeaderChilds);

        this.element = newHeader;

        this.showButtons();
        
        return this.element;
      }

      function ITEMBOX_HEADER_setActivatedButton(buttonNr)
      {
        this.buttonActivated = buttonNr;
      }

      function ITEMBOX_HEADER_destroy() {
        var i;

        for (i = 0; i < this.buttons.length; i++) {
          this.buttons[i] = null;
        }
      }
};


//*****************************************************************************************************************************
//                              NON CLASS MEMBERS
function showItemBoxItems(itemType)
{
  var itemRequest = true;
  var i;
  // gucken ob wir die daten nich schon haben

  for (i = 0; i < masta.itemBox.item.length; i++) {
    if (masta.itemBox.item[i].itemType = itemType) {
      itemRequest = false;
      break;
    }
  }

  if (masta.itemBox && itemRequest)
  {
    createLoadingAnimation(0,0);
    getURL("map_getdata.php?act=clickOnGetItems&item_type="+itemType+"&caller_type="+masta.itemBox.caller+"&caller_id="+masta.itemBox.oid, masta.itemBox);
  }
}

function pressButton(evt)
{
  var pressedButton = evt.target.correspondingUseElement;
  var oldPressedButton;

  if (pressedButton.getAttribute("activated") == 0) {

      // press new button
      pressedButton.setAttribute("display","none");
      pressedButton.nextSibling.setAttribute("display","inherit");

      // release old button
      if (masta.itemBox.header.buttonActivated > 0)
      {
        oldPressedButton = masta.itemBox.header.buttons[sr_itemBox.header.buttonActivated - 1].button;
        oldPressedButton.firstChild.setAttribute("display","inherit");
        oldPressedButton.firstChild.nextSibling.setAttribute("display","none");
      }

      // update header.buttonActivated
      masta.itemBox.header.setActivatedButton(Number(pressedButton.parentNode.getAttribute("buttonNr"))+1);

      pSvgDoc.getElementById("SR_AUDIO_BUTTON_PRESSED").setAttribute("begin",pSvg.getCurrentTime());
  }
}

function createFleetItem(itemElement, itemNo)
{
  var newItem;
  var fleet_control_node_list;

  var picture;
  var topic;
  var description;
  var clickAction;
  var mouseoverAction;
  var mouseoutAction;
  var oid;
  var text1;
  var text2;
  var footer;
  var allianceColor;
  var allianceName;
  var allianceSymbol;
  var relationClass;
  var itemType;

  picture         = itemElement.getAttribute("picture");
  topic           = itemElement.getAttribute("topic");
  description     = itemElement.getAttribute("description");
  clickAction     = itemElement.getAttribute("clickAction");
  mouseoverAction = itemElement.getAttribute("mouseoverAction");
  mouseoutAction  = itemElement.getAttribute("mouseoutAction");
  oid             = itemElement.getAttribute("oid");
  text1           = itemElement.getAttribute("text1");
  text2           = itemElement.getAttribute("text2");
  footer          = itemElement.getAttribute("footer");
  allianceColor   = itemElement.getAttribute("allianceColor");
  allianceSymbol  = itemElement.getAttribute("allianceSymbol");
  allianceName    = itemElement.getAttribute("allianceName");
  relationClass   = itemElement.getAttribute("relationClass");
  itemType        = "fleet";

  fleet_control_node_list = itemElement.getElementsByTagName("SR_FLEET_CONTROL");

  if (fleet_control_node_list.length == 0)
    fleet_control_node_list = false;

  try {
    newItem = new SR_CLASS_FLEET_ITEM(itemType, itemNo, picture, topic, description, clickAction, mouseoverAction, mouseoutAction, oid, text1, text2, footer, allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list);
  }
  catch (e) {
    alert("createFleetItem(...) caused an error\n\n"+e.name+"\n"+e.message);
  }

  return newItem;
}

function createFullFleetItem(itemElement, itemNo)
{
  var newItem;
  var fleet_control_node_list;
  var fleet_command_node_list;

  var newFleet;

  var picture;
  var topic;
  var description;
  var clickAction;
  var mouseoverAction;
  var mouseoutAction;
  var oid;
  var relationClass;
  var footer;
  var text1;
  var eta;
  var mission;
  var missionSymbol;
  var missionName;
  var tactic;
  var tacticSymbol;
  var tacticName;
  var reloadSymbol;
  var infantrySymbol;
  var modSymbol;
  var allianceColor;
  var allianceName;
  var allianceSymbol;

  var i;
  var ships;
  var shiparr=new Array;


  itemType        = "fleet";

  picture         = itemElement.getAttribute("picture");
  topic           = itemElement.getAttribute("topic");
  description     = itemElement.getAttribute("description");
  clickAction     = itemElement.getAttribute("clickAction");
  mouseoverAction = itemElement.getAttribute("mouseoverAction");
  mouseoutAction  = itemElement.getAttribute("mouseoutAction");
  oid             = itemElement.getAttribute("oid");
  pid             = itemElement.getAttribute("pid");
  sid             = itemElement.getAttribute("sid");
  tpid            = itemElement.getAttribute("tpid");
  tsid            = itemElement.getAttribute("tsid");
  relationClass   = itemElement.getAttribute("relationClass");
  text1           = itemElement.getAttribute("target");
  eta             = itemElement.getAttribute("eta");
  missionSymbol   = itemElement.getAttribute("missionSymbol");
  missionName     = itemElement.getAttribute("missionName");
  mission         = itemElement.getAttribute("mission");
  tactic          = itemElement.getAttribute("tactic");
  tacticSymbol    = itemElement.getAttribute("tacticSymbol");
  tacticName      = itemElement.getAttribute("tacticName");
  reloadSymbol    = itemElement.getAttribute("reloadSymbol");
  infantrySymbol  = itemElement.getAttribute("infantrySymbol");
  modSymbol       = itemElement.getAttribute("modSymbol");
  soundReport     = itemElement.getAttribute("soundReport").toLowerCase();
  soundConfirm    = itemElement.getAttribute("soundConfirm").toLowerCase();

  allianceColor   = itemElement.getAttribute("allianceColor");
  allianceSymbol  = itemElement.getAttribute("allianceSymbol");
  allianceName    = itemElement.getAttribute("allianceName");

  text2           = "SR_SYMBOLS";
  ships=itemElement.getElementsByTagName("SR_SHIP");

  for (i=0;i<ships.length;i++)
    shiparr[ships.item(i).getAttribute("prod_id")]=new Array(ships.item(i).getAttribute("count"),ships.item(i).getAttribute("reload"),ships.item(i).getAttribute("name"), ships.item(i).getAttribute("typ"));

  newFleet = new SR_CLASS_FLEET(oid, topic, picture);

    newFleet.setMission(mission, missionSymbol, missionName);
    newFleet.setTactic(tactic, tacticSymbol, tacticName);
    newFleet.setSound(soundReport, soundConfirm);
    newFleet.setInfCount(infantrySymbol);
    newFleet.setReload(reloadSymbol);
    newFleet.setMod(modSymbol);
    newFleet.setTargetName(text1);
    newFleet.setEta(eta);
    newFleet.setShips(shiparr);
    newFleet.setSid(sid);
    newFleet.setPid(pid);
    newFleet.setTsid(tsid);
    newFleet.setTpid(tpid);

  // controls
  fleet_control_node_list = itemElement.getElementsByTagName("SR_FLEET_CONTROL");

  if (fleet_control_node_list.length > 0) {
  }
  else
    fleet_control_node_list = false;
    
  masta.cache.addFleet(newFleet);

  try {
    newItem = new SR_CLASS_FULL_FLEET_ITEM(itemType,itemNo,picture,topic,description,clickAction,mouseoverAction,mouseoutAction,oid,text1, text2, newFleet.getShipCountByTyp("H")+" "+newFleet.getShipCountByTyp("M")+" "+newFleet.getShipCountByTyp("L"), allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list, newFleet);
  }
  catch (e) {
    alert("createFullFleetItem(...) caused an error\n\n"+e.name+"\n"+e.message);
  }

  return newItem;
}


function createAdvancedFleetItem(itemElement, itemNo) {
  var newItem;
  var fleet_control_node_list;

  var newFleet;

  var picture;
  var topic;
  var description;
  var oid;
  var relationClass;
  var footer;
  var text1;
  var clickAction;
  var mouseoverAction;
  var mouseoutAction;
  var allianceColor;
  var allianceName;
  var allianceSymbol;

  var i;
  var ships;
  var shiparr=new Array;

  try {
    itemType        = "fleet";

    picture         = itemElement.getAttribute("picture");
    topic           = itemElement.getAttribute("topic");
    description     = itemElement.getAttribute("description");
    oid             = itemElement.getAttribute("oid");
    pid             = itemElement.getAttribute("pid");
    sid             = itemElement.getAttribute("sid");
    relationClass   = itemElement.getAttribute("relationClass");
    text1           = itemElement.getAttribute("text1");
    text2           = itemElement.getAttribute("text2");
    clickAction     = itemElement.getAttribute("clickAction");
    mouseoverAction = itemElement.getAttribute("mouseoverAction");
    mouseoutAction  = itemElement.getAttribute("mouseoutAction");

    allianceColor   = itemElement.getAttribute("allianceColor");
    allianceSymbol  = itemElement.getAttribute("allianceSymbol");
    allianceName    = itemElement.getAttribute("allianceName");

    footer          = itemElement.getAttribute("footer");

    // controls
    fleet_control_node_list = itemElement.getElementsByTagName("SR_FLEET_CONTROL");

    if (fleet_control_node_list.length > 0) {
    }
    else
      fleet_control_node_list = false;

    // masta.cache.addFleet(newFleet);

    newItem = new SR_CLASS_FLEET_ITEM(itemType,itemNo,picture,topic,description,clickAction,mouseoverAction,mouseoutAction,oid,text1, text2, footer, allianceColor, allianceSymbol, allianceName, relationClass, fleet_control_node_list);
  }
  catch (e) {
    alert("createAdvancedFleetItem(...) caused an error\n\n"+e.name+"\n"+e.message);
  }

  return newItem;
}
