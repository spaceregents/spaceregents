var SVGAnimationsPaused = false;


SR_CLASS_CACHE = function() {
  this.itemBoxes = new Array();
  this.itemBoxesMaxSize = 20;

  this.systems  = new Array();
  this.systemsMaxSize = 20;

  this.fleets   = new Array();

  this.planets  = new Array();

  this.currentPlanet      = false;
  this.loadedSystemNodes = new Array();
  this.currentTarget = false;

  this.selected         = new Array();
  this.buttons          = new Array();    // hier werden die command buttons gespeichert
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_CACHE.prototype.addObject = function(objectType, newObject) {
  var i;

  try {
    switch (objectType){
      case "itemBox":
        if (this.itemBoxes.length >= this.itemBoxesMaxSize) {
            this.itemBoxes[0].destroy();
            this.itemBoxes[0] = null;
            this.itemBoxes.shift();
          }

          this.itemBoxes.push(newObject);
      break;
      case "system":
        if (this.systems.length >= this.systemsMaxSize) {

        }
      break;
    }
  }
  catch (e) {
    alert("SR_CLASS_CACHE::addObject() caused an error\n\n"+e.name+"\n"+e.message);
  }
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_CACHE.prototype.freeCache = function(){
  var i, j;
  var trash;
  
  masta.removeSelected("all");
  
  for (i in this.itemBoxes) {
    for (j in this.itemBoxes[i].item) {
      this.itemBoxes[i].item[j] = null;
    }
    this.itemBoxes[i] = null;
  }
  this.itemBoxes = null;
  this.itemBoxes = new Array();

  for (i in this.fleets) {
    this.fleets[i] = null;
  }  
  this.fleets = new Array();
      
  if (masta.getCurrentPlanet()) {
    var cp = pSvgDoc.getElementById("p"+masta.currentPlanet);
    
    if (cp)
      trash = cp.removeChild(cp.lastChild);
      
    trash = null;
    
    this.currentPlanet = false;
  }

  var systemNode;
  for (i in this.loadedSystemNodes) {
    systemNode = mSvgDoc.getElementById("planet"+i);
    
    if (systemNode)
      trash = systemNode.parentNode.removeChild(systemNode);
      
    trash = null;
    this.loadedSystemNodes[i] = null;
  }
  this.loadedSystemNodes = new Array();

  this.currentTarget = false;


  if (masta.itemBox) {
    trash = masta.itemBox.itemBoxElement.parentNode.removeChild(masta.itemBox.itemBoxElement);
    trash = null;
    masta.itemBox.destroy();
  }
  masta.itemBox = null;
  
  masta.currentTarget = false;
  masta.hookedWindow  = false;
  masta.currentSystem = false;
  
  masta.iMoves = null;
  masta.iMoves = new Array();
}
//-------------------------------------------------------------------------------------------------


SR_CLASS_CACHE.prototype.getObject = function(objectType, oid, caller) {
  var i;
  var returnObject = false;

  switch (objectType) {
    case "itemBox":
      for (i = 0; i < this.itemBoxes.length && !returnObject; i++) {
        ((this.itemBoxes[i].oid == String(oid)) && (this.itemBoxes[i].caller == String(caller))) ? (returnObject = this.itemBoxes[i]) : (returnObject = false);
      }
    break;
  }

  return returnObject;
}

SR_CLASS_CACHE.prototype.removeItemBox = function(oid) {
  var new_arr = new Array();
  var i, j;
  
  for (i = 0, j = 0; i < this.itemBoxes.length; i++) {
    if (this.itemBoxes[i].oid != oid) {
      new_arr[j] = this.itemBoxes[i];
      j++;
    }
    else
      this.itemBoxes[i] = null;
  }
  
  this.itemBoxes = new_arr;
}


SR_CLASS_CACHE.prototype.addFleet = function(fleet) {
  var i;
  var storeAtPos = this.fleets.length;
  // if same fleet already there, overwrite

  for (i = 0; i < this.fleets.length; i++) {
    if (this.fleets[i].id == fleet.id) {
      storeAtPos = i;
      break;
    }
  }

  this.fleets[storeAtPos] = fleet;
}
//-------------------------------------------------------------------------------------------------

SR_CLASS_CACHE.prototype.addPlanet = function(planet) {
  var i;
  var storeAtPos = this.planets.length;
  // if same fleet already there, overwrite

  for (i = 0; i < this.planets.length; i++) {
    if (this.planets[i].id == planet.id) {
      storeAtPos = i;
      break;
    }
  }

  this.planets[storeAtPos] = planet;
}

SR_CLASS_CACHE.prototype.getPlanet = function(id) {
  var i;
  var result = false;

  for (i in this.planets) {
    if (this.planets[i].id == id) {
      result = this.planets[i];
      break;
    }
  }

  return result;
}

SR_CLASS_CACHE.prototype.getFleet = function(id) {
  var i;
  var result = false;

  for (i in this.fleets) {
    if (this.fleets[i].id == id) {
      result = this.fleets[i];
      break;
    }
  }
  return result;
}