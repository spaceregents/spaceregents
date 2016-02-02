function STARMAP()
{
        this.constellations = new Array();
        this.baseX          = 0;
        this.baseY          = 0;
        this.x              = 0;
        this.y              = 0;
}

function STARMAP.prototype.operationComplete(operation)
{
  var newContent;
  if (operation.success) {
    newContent = operation.content;
    alert(newContent[0]);

  }
  else {
    alert("Server error!");
  }

  newContent  = null;
  operation   = null;
}