/***************
 * SR_CLASS_RESOURCES
 */
function SR_CLASS_RESOURCES(m, e, o, r, g, s) {
  if (arguments.length > 0)
    this.init(m, e, o, r, g, s);
}

SR_CLASS_RESOURCES.prototype.init = function(m, e, o, r, g, s) {
  this.metal  = Number(m);
  this.energy = Number(e);
  this.mopgas = Number(o);
  this.erkunum= Number(r);
  this.gortium= Number(g);
  this.susebloom = Number(s);
}

SR_CLASS_RESOURCES.prototype.setResource = function(resName, resValue) {
  eval("this."+resName+" = "+resValue+";");
}


/***************
 * SR_CLASS_USER
 */
function SR_CLASS_USER(uid, name, empire, relation) {
  if (arguments.length > 0) {
    this.init(uid, name, empire, relation);
  }
}

SR_CLASS_USER.prototype.init = function(uid, name, empire, relation) {
  this.id     = Number(uid);
  this.name   = name;
  this.empire = empire;
  this.aName    = false;
  this.aColor   = false;
  this.aSymbol  = false;
  this.relation = relation;
}

SR_CLASS_USER.prototype.setAlliance = function(aName, aColor, aSymbol) {
  this.aName    = aName;
  this.aColor   = aColor;
  this.aSymbol  = aSymbol;
}


/***************
 * SR_CLASS_PRODUCTION
 */
function SR_CLASS_PRODUCTION(production, time, com_time) {
  if (arguments.length > 0)
    this.init(production, time, com_time);
}

SR_CLASS_PRODUCTION.prototype.init = function(prod_id, time, com_time) {
  if (com_time == 0)
    com_time = 1;

  this.prod_id = Number(prod_id);
  this.time    = Number(time);
  this.com_time= Number(com_time);
  this.count   = false;
}

SR_CLASS_PRODUCTION.prototype.getPercent = function() {
  var percent = (1 - Number(this.time / this.com_time));
  return percent;
}

SR_CLASS_PRODUCTION.prototype.setCount  = function(count) {
  this.count = count;
}


/***************
 * SR_CLASS_PROD_INFO
 */
function SR_CLASS_PROD_INFO(pic, name, sv_special, pr_special)
{
  if (arguments.length > 0)
   this.init(pic, name, sv_special, pr_special);
}


SR_CLASS_PROD_INFO.prototype.init = function(pic, name, sv_special, pr_special)
{
  this.pic  = pic;
  this.name = name;
  this.sv_special = sv_special; // ship val special
  this.pr_special = pr_special; // production special
}


SR_CLASS_PROD_INFO.prototype.getImage = function() {
  return "arts/"+this.pic;
}