selectedBaseX = 20;
selectedBaseY = 45;
var selectedBaseWidth = 50;
var selectedBaseHeight= 50;
var selectedBaseSpacer= 5;
var selected_max_per_column = Math.floor((Number(window.innerHeight) - (2*selectedBaseY)) / (selectedBaseHeight + selectedBaseSpacer));

function SR_CLASS_SELECTED(picture, description, itemNo, itemClass){
  if (arguments.length > 0)
    this.init(picture, description, itemNo, itemClass);
}

SR_CLASS_SELECTED.prototype.init = function(picture, description, itemNo, itemClass) {
  this.itemNo       = itemNo;
  this.oid          = itemClass.oid;
  this.itemClass    = itemClass;
  this.picture      = picture;
  this.description  = description;
  this.element      = 0;
}


SR_CLASS_SELECTED.prototype.generate = function(){
  var newSelectedChilds = new Array();
  var i = 0;
  var x, y;
  var itemPos = this.itemNo;

  if (itemPos % selected_max_per_column == 0 && itemPos > 0) {
    selectedBaseX += selectedBaseWidth + selectedBaseSpacer;
    selectedBaseY -= selected_max_per_column * (selectedBaseHeight + selectedBaseSpacer);
  }
  x = selectedBaseX;


  y = selectedBaseY+(itemPos * (selectedBaseHeight + selectedBaseSpacer));

  this.element = sr_create_basic_element("g","itemNo",this.itemNo,"transform","translate("+x+" "+y+")");
  sr_add_status_text(this.element, "Fleet "+this.description+" (Shift + Click to remove)");

  newSelectedChilds[i]    = sr_create_image(this.picture, 0, 0, selectedBaseWidth, selectedBaseHeight);
  newSelectedChilds[++i]  = sr_create_rect(0,0, selectedBaseWidth, selectedBaseHeight, "mapGUISelected");

  this.element = sr_append_child_nodes(this.element, newSelectedChilds);
  this.element.setAttribute("cursor","pointer");
  this.element.addEventListener("click", this, true);
}


SR_CLASS_SELECTED.prototype.destroy = function() {
  this.element.parentNode.removeChild(this.element);
  this.element.removeEventListener("click", this, true);
}


SR_CLASS_SELECTED.prototype.show = function() {
  pSvg.getElementById("sr_selectedBox").appendChild(this.element);
}


SR_CLASS_SELECTED.prototype.getCommands = function() {
  if (this.itemClass.fleet.commands.length > 0)
    return this.itemClass.fleet.commands;
  else
    return false;
}

SR_CLASS_SELECTED.prototype.handleEvent = function(evt) {
  switch (evt.type) {
    case "click":
      if (evt.button == 0 && !(evt.shiftKey)) {
        masta.removeAllSelectedBut(this);
      }

      if (evt.button == 0 && evt.shiftKey) {
        masta.removeSelected(this.oid);
      }
    break;
  }
}