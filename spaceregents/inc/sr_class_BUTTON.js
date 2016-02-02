SR_CLASS_BUTTON = function(buttonNo, x, y, buttonType, buttonFace, buttonAction, buttonDescription, fatherClass) {
  if (arguments.length > 0)
    this.init(buttonNo, x, y, buttonType, buttonFace, buttonAction, buttonDescription, fatherClass);
}


SR_CLASS_BUTTON.prototype.init = function (buttonNo, x, y, buttonType, buttonFace, buttonAction, buttonDescription, fatherClass) {
  this.buttonNo = buttonNo;
  this.x        = x;
  this.y        = y;
  this.width    = 0;
  this.height   = 0;
  this.type     = buttonType;
  this.face     = buttonFace;
  this.action   = buttonAction;
  this.description = buttonDescription;
  this.opacity  = 1;
  this.state    = false;    // false = up, true = down
  this.fatherClass = fatherClass;

  // static
  this.faceClass           = "mapGUIButtonFace";
  this.shapeClass          = "mapGUIButton";
  this.shapeClassActivated = "mapGUIButtonActive";

  this.element  = 0;
}


SR_CLASS_BUTTON.prototype.generate = function() {

  var newButtonChilds = new Array();

  try {
    this.element = sr_create_basic_element("g", "buttonNo", this.buttonNo, "transform", "translate("+this.x+" "+this.y+")");
    this.element.setAttribute("onmouseover","updateStatusText('"+this.description+"');");
    this.element.setAttribute("onmouseout","updateStatusText(' ')");
    this.element.setAttribute("opacity",this.opacity);

    // buttonShape
    switch (this.type) {
      case "BUTTON_CIRCLE_SMALL":
        newButtonChilds[0] = sr_create_use("button_circle_small", 0, 0, this.shapeClass);
        newButtonChilds[1] = sr_create_use("button_circle_small", 0, 0, this.shapeClassActivated);
        this.width = 15;
        this.height = 15;
      break;
      case "BUTTON_TRIANGLE_SMALL":
        newButtonChilds[0] = sr_create_use("button_triangle_small", 0, 0, this.shapeClass);
        newButtonChilds[1] = sr_create_use("button_triangle_small", 0, 0, this.shapeClassActivated);
        this.width = 15;
        this.height = 15;
      break;
      case "BUTTON_CIRCLE_BIG":
        newButtonChilds[0] = sr_create_use("button_circle_big", 0, 0, this.shapeClass);
        newButtonChilds[1] = sr_create_use("button_circle_big", 0, 0, this.shapeClassActivated);
        this.width = 30;
        this.height = 30;
     break;
      case "BUTTON_RECT_SMALL":
        newButtonChilds[0] = sr_create_use("button_rect_small", 0, 0, this.shapeClass);
        newButtonChilds[1] = sr_create_use("button_rect_small", 0, 0, this.shapeClassActivated);
        this.width = 15;
        this.height = 15;
      break;
      case "BUTTON_RECT_BIG":
        newButtonChilds[0] = sr_create_use("button_rect_big", 0, 0, this.shapeClass);
        newButtonChilds[1] = sr_create_use("button_rect_big", 0, 0, this.shapeClassActivated);
        this.width = 30;
        this.height = 30;
      break;
      default:
        newButtonChilds[0] = sr_create_use("button_circle_small", 0, 0, this.shapeClass);
        newButtonChilds[1] = sr_create_use("button_circle_small", 0, 0, this.shapeClassActivated);
        this.width = 15;
        this.height = 15;
      break;
    }

    newButtonChilds[1].setAttribute("display","none");


    // buttonFace
    // gucken ob image oder definition
    if ((this.face.search(/.+svg$/) != -1) || (this.face.search(/.+svgz$/) != -1)) {
      // ist nen bild
      newButtonChilds[2] = sr_create_image(this.face, 0, 0, this.width, this.height);
    }
    else {
      // ist ne definition
      newButtonChilds[2] = sr_create_use(this.face, (this.width/4), (this.height/4), this.faceClass);
    }
    newButtonChilds[2].setAttribute("pointer-events", "none");

    this.element = sr_append_child_nodes(this.element, newButtonChilds);

    if (this.fatherClass == 0)
      this.element.setAttribute("onclick", this.action);
    else{
      this.element.setAttribute("onclick", this.action+";"+this.fatherClass+".buttons["+this.buttonNo+"].click();");
    }

    this.element.setAttribute("cursor","pointer");
    this.element.setAttribute("tooltip","enabled");
  }
  catch (e) {
    alert("SR_CLASS_BUTTON::generate caused an error.\n"+e.name+"\n"+e.message);
  }
}


SR_CLASS_BUTTON.prototype.click = function() {
    var i;

    sr_play_audio("BUTTON_DOWN");
    if (!this.state) {
      // look for other buttons, that must be 'unpressed' in same context
      for (i = 0; i < eval(this.fatherClass+".buttons.length"); i++) {
        if (eval(this.fatherClass+".buttons["+i+"].state"))
          eval(this.fatherClass+".buttons["+i+"].unclick()");
      }

      this.element.firstChild.nextSibling.setAttribute("display","inherit");
      this.state = true;
    }
}

SR_CLASS_BUTTON.prototype.unclick = function() {
    this.element.firstChild.nextSibling.setAttribute("display","none");
    this.state = false;
}

SR_CLASS_BUTTON.prototype.setOpacity = function(opacity)
{
  this.opacity=opacity;
}

SR_CLASS_BUTTON.prototype.destroy = function() {
    this.element.parentNode.removeChild(this.element);
}


SR_CLASS_BUTTON.prototype.focus = function() {
    this.element.firstChild.nextSibling.setAttribute("display","inherit");
    this.state = true;
}
