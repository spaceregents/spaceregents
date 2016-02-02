// *************************************************
//
// CLASS SR_CLASS_PLANET
//
// *************************************************

function SR_CLASS_PLANET(id) {
  if (arguments.length > 0)
    this.init(id);
}


SR_CLASS_PLANET.prototype.init = function(id) {
  this.id = id;
  this.pType      = false;
  this.pBuildings = false;
  this.oBuildings = false;
  this.resources  = false;
  this.population = false;
  this.popgain    = false;
  this.user       = false;

  this.pProduction = false;
  this.oProduction = false;
  this.sProduction = false;
  this.iProduction = false;
}

SR_CLASS_PLANET.prototype.setResources = function(m, e, o, r, g, s) {
  if (this.resources)
    delete this.resources;

  this.resources = new SR_CLASS_RESOURCES(m, e, o, r, g, s);
}

SR_CLASS_PLANET.prototype.setClassMember = function(bez, wert) {
  eval("this."+bez+" = "+wert+";");
}


SR_CLASS_PLANET.prototype.setBuildings = function(type, b_array) {
  if (type == "P" || type == "p") {
    if (this.pBuildings)
      delete this.pBuildings;

    this.pBuildings = b_array;
  }
  else {
    if (this.oBuildings)
      delete this.oBuildings;

    this.oBuildings = b_array;
  }
}

SR_CLASS_PLANET.prototype.addProduction = function(type, prod) {
  switch (type) {
    case "P":
    case "p":
      if (!this.pProduction)
        this.pProduction = new Array();
        this.pProduction.push(prod);
    break;
    case "O":
    case "o":
      if (!this.oProduction)
        this.oProduction = new Array();
        this.oProduction.push(prod);
    break;
    case "S":
    case "s":
      if (!this.sProduction)
        this.sProduction = new Array();
        this.sProduction.push(prod);
    break;
    case "I":
    case "i":
      if (!this.iProduction)
        this.iProduction = new Array();
        this.iProduction.push(prod);
    break;
  }
}

SR_CLASS_PLANET.prototype.resetProduction = function() {
  var i;

  if (this.pProduction) {
    for (i = 0; i < this.pProduction.length; i++) {
      delete this.pProduction[i];
    }
    delete this.pProduction;
    this.pProduction = false;
  }

  if (this.oProduction) {
    for (i = 0; i < this.oProduction.length; i++) {
      delete this.oProduction[i];
    }
    delete this.oProduction;
    this.oProduction = false;
  }

  if (this.sProduction) {
    for (i = 0; i < this.sProduction.length; i++) {
      delete this.sProduction[i];
    }
    delete this.sProduction;
    this.sProduction = false;
  }

  if (this.iProduction) {
    for (i = 0; i < this.iProduction.length; i++) {
      delete this.iProduction[i];
    }
    delete this.iProduction;
    this.iProduction = false;
  }
}

SR_CLASS_PLANET.prototype.setPType = function(pType) {
  this.pType = pType;
}

SR_CLASS_PLANET.prototype.getPic  = function() {
  var pic = "arts/"+this.pType+".png";

  return pic;
}

SR_CLASS_PLANET.prototype.setUser = function(user) {
  delete this.user;

  this.user = user;
}

SR_CLASS_PLANET.prototype.getPopulation = function() {
  return this.population;
}

SR_CLASS_PLANET.prototype.getPlanetType = function(fullType) {
  var pType;
  if (fullType) {
    switch (this.pType) {
      case "O":
      case "o":
        pType = "Origin";
      break;
      case "E":
      case "e":
        pType = "Eden";
      break;
      case "M":
      case "m":
        pType = "Mars";
      break;
      case "R":
      case "r":
        pType = "Rock";
      break;
      case "A":
      case "a":
        pType = "Ancient";
      break;
      case "I":
      case "i":
        pType = "Ice";
      break;
      case "T":
      case "t":
        pType = "Toxic";
      break;
      case "D":
      case "d":
        pType = "Desert";
      break;
      case "H":
      case "h":
        pType = "Heavy Grav";
      break;
      case "G":
      case "g":
        pType = "Gas Giant";
      break;
    }
  }
  else
    pType = this.pType;

  return pType;
}
