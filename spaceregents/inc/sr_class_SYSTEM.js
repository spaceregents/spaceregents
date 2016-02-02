// *************************************************
//
// CLASS SR_CLASS_SYSTEM
//
// *************************************************

function SR_CLASS_SYSTEM(oid, systemStarId) {
  if (arguments.length > 0)
    this.init(oid, systemStarId);
}


SR_CLASS_SYSTEM.prototype.init = function(oid, systemStarId) {
  try {
    this.oid = oid;
    this.systemStarElement = pSvgDoc.getElementById(systemStarId);
    this.planets = new Array();
    this.x       = this.systemStarElement.getAttribute("x");
    this.y       = this.systemStarElement.getAttribute("y");
  }
  catch (e) {
    alert("SR_CLASS_SYSTEM::init caused an error!\n"+e.name+"\n"+e.message);
  }
}


SR_CLASS_SYSTEM.prototype.operationComplete = function(operation) {
  if (operation.success) {
  }
  else {
    alert("Server error! Please try again.");
  }
}

function SYSTEM.prototype.operationComplete(content)
{
  eval(content);
}