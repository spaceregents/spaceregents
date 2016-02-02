function SR_CLASS_MINIMAP(x,y,size)
{
  if (arguments.length>0)
    this.init(x,y,size);
}

SR_CLASS_MINIMAP.prototype.init=function(x,y,size)
{
  this.x            = x;
  this.y            = y;
  this.size         = size;
  this.positionRect = false;
  this.show         = 1023; // mop: 2 ^ 10 -1
  this.currentFactor= 1;
  this.px = this.py = this.pan = this.originalCTM = false;
}

SR_CLASS_MINIMAP.prototype.createMatrix=function(factor, x, y, bBox)
{
  var M     = fSvgRoot.createSVGMatrix();       // stores the final Matrix
  var old_f = this.currentFactor;               // old scale factor

  this.currentFactor *= factor;
  
  if (this.currentFactor < 1)
    this.currentFactor = 1;

  // inititate final matrix
  M.a = M.d = this.originalCTM.a;

  if (this.currentFactor != 1)
  {
    var A = fSvgRoot.createSVGMatrix();       // Translation matrix to origin
    var B = fSvgRoot.createSVGMatrix();       // Scale Matrix
    var C = fSvgRoot.createSVGMatrix();       // Translation matrix to new centerpoint
    var f = this.currentFactor;               // current Scale factor

    var z = this.size / 2;
    var halfWidth  = bBox.width / 2;
    var halfHeight = bBox.height / 2;

    // Translate Maps center to origin
    A.a = A.d = 1;
    A.e -= halfWidth * f;
    A.f -= halfHeight * f;
    M = M.multiply(A);

    // Translate Point at same relation
    x -= halfWidth;
    y -= halfHeight;

    // Scale map
    B.a = B.d = f;    
    M = M.multiply(B);

    // Translate map to z centerpoint
    C.a = C.d = 1;
    C.e = -x + (z / (this.originalCTM.a * f));
    C.f = -y + (z / (this.originalCTM.d * f));

    M = M.multiply(C);
  }
  return M;
}

SR_CLASS_MINIMAP.prototype.handleEvent = function(evt)
{
  var factor = 2;
  var globalCTM;
  var localCTM;
  var fM;
  var positionRect;
  var posX, posY;
  var new_x, new_y;
  var clickXRel, clickYRel;
  var bBox;
  var currTarget = evt.currentTarget;
  var targetId = currTarget.getAttribute("id");

  if (targetId=="minimap")
  {
    positionRect = masta.minimap.positionRect;
    posX  = Number(positionRect.getAttribute("x"));
    posY  = Number(positionRect.getAttribute("y"));

    localCtm  = currTarget.getCTM();
    clickXRel = (evt.clientX - localCtm.e)/mSvg.getElementById("minimap").getCTM().a;
    clickYRel = (evt.clientY - localCtm.f)/mSvg.getElementById("minimap").getCTM().d;


    switch (evt.type)
    {
      case "mousemove":
      case "mouseover":
        if (!evt.ctrlKey && evt.altKey && !evt.shiftKey && this.currentFactor > 1)
          currTarget.parentNode.setAttribute("cursor","move");
        else
        if (evt.ctrlKey && !evt.altKey && !evt.shiftKey)
          currTarget.parentNode.setAttribute("cursor","url(#crs_zoom_in)");
        else
        if (evt.ctrlKey && !evt.altKey && evt.shiftKey)
          currTarget.parentNode.setAttribute("cursor","url(#crs_zoom_out)");
        else
          currTarget.parentNode.setAttribute("cursor","pointer");
      break;
      case "mousedown":
        if (!evt.ctrlKey && evt.altKey && !evt.shiftKey && this.currentFactor > 1) {
          currTarget.parentNode.setAttribute("cursor","move");
          cM = evt.currentTarget.getCTM();
          cM.e = Number((this.size / 2) - clickXRel * cM.a);
          cM.f = Number((this.size / 2) - clickYRel * cM.d);
          currTarget.setAttribute("transform","matrix("+cM.a+" "+cM.b+" "+cM.c+" "+cM.d+" "+cM.e+" "+cM.f+")");
        }
        else
        if (evt.ctrlKey && !evt.altKey && !evt.shiftKey)
          currTarget.parentNode.setAttribute("cursor","url(#crs_zoom_in)");
        else
        if (evt.ctrlKey && !evt.altKey && evt.shiftKey)
          currTarget.parentNode.setAttribute("cursor","url(#crs_zoom_out)");
        else
          currTarget.parentNode.setAttribute("cursor","pointer");
      break;
      case "click":
        if (!evt.ctrlKey && evt.altKey && !evt.shiftKey && this.currentFactor > 1) {
        }
        else
        if (evt.ctrlKey && !evt.altKey && !evt.shiftKey)
        {
            bBox      = currTarget.getBBox();
            fM = this.createMatrix(factor, clickXRel, clickYRel, bBox);
            currTarget.setAttribute("transform","matrix("+fM.a+" "+fM.b+" "+fM.c+" "+fM.d+" "+fM.e+" "+fM.f+")");
            masta.minimapWindow.updateTitle("minimap ("+this.currentFactor.toFixed(2)+"x)");
        }
        else if (evt.ctrlKey && !evt.altkey && evt.shiftKey)
        {
          if (this.currentFactor > 1) {
            bBox      = currTarget.getBBox();
            fM=this.createMatrix((1/factor), clickXRel, clickYRel, bBox);
            currTarget.setAttribute("transform","matrix("+fM.a+" "+fM.b+" "+fM.c+" "+fM.d+" "+fM.e+" "+fM.f+")");
            masta.minimapWindow.updateTitle("minimap ("+this.currentFactor.toFixed(2)+"x)");
          }
        }
        else {
          new_x = clickXRel - posX;
          new_y = clickYRel - posY;
          masta.map_focus_to(new_x, new_y);
        }
      break;
    }
  }
  else
  {
    if(targetId == "minimap_resetBtn") {
      this.currentFactor = 1;
      finalMatrix = this.createMatrix(0);
      mSvgDoc.getElementById("minimap").setAttribute("transform","matrix("+finalMatrix.a+" "+finalMatrix.b+" "+finalMatrix.c+" "+finalMatrix.d+" "+finalMatrix.e+" "+finalMatrix.f+")");

      // update title
      masta.minimapWindow.updateTitle("minimap ("+this.currentFactor.toFixed(2)+"x)");
    }
    else
        this.setShowFlag(evt);
  }
}

SR_CLASS_MINIMAP.prototype.setShowFlag=function(evt)
{
  target=evt.target.parentNode;
  flag=Number(target.id.substr(5,target.id.length-5));
  this.show^=(1 << flag);

  target.lastChild.setAttribute("visibility",this.show & (1<<flag) ? "visible" : "hidden");
  this.updateMinimap(flag);
}

SR_CLASS_MINIMAP.prototype.updateMinimap=function(flag)
{
  if (this.show & (1<<flag))
    display="inline";
  else
    display="none";

  if (flag==0)
    pSvg.getElementById("ownMMap").setAttribute("display",display);
  if (flag==1)
    pSvg.getElementById("allMMap").setAttribute("display",display);
  if (flag==2)
    pSvg.getElementById("friMMap").setAttribute("display",display);
  if (flag==3)
    pSvg.getElementById("neuMMap").setAttribute("display",display);
  if (flag==4)
    pSvg.getElementById("eneMMap").setAttribute("display",display);
  if (flag==5)
    fSvg.getElementById("aMinimapOwnFleet").setAttribute("display",display);
  if (flag==6)
    fSvg.getElementById("aMinimapAlliedFleet").setAttribute("display",display);
  if (flag==7)
    fSvg.getElementById("aMinimapFriendFleet").setAttribute("display",display);
  if (flag==8)
    fSvg.getElementById("aMinimapNeutralFleet").setAttribute("display",display);
  if (flag==9)
    fSvg.getElementById("aMinimapEnemyFleet").setAttribute("display",display);
}