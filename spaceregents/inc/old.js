function destroySelectCircles()
{
  if (mSvgDoc.getElementById("einSelectCircle"))
  {
    toDestroy = mSvgDoc.getElementById("einSelectCircle");
    mSvgRoot.removeChild(toDestroy);
    destroySelectCircles();
  }
}

/*********
*
*  deleteSelectedObjects(evt)
*
*********/
function deleteSelectedObjects()
{
  for (i = selectedObj.length; i >= 0; i--)
  {
    selectedObj[i] = null;
  }
}


/*********
*
*  resizeSelectRect(evt)
*
*********/
function resizeSelectRect(evt)
{
  if (theBox = mSvgDoc.getElementById("theBox")) // checken ob das rect exisitiert und in der var theBox speichern
  {
    newWidth  = evt.clientX - theBox.getAttribute("x");
    newHeight = evt.clientY - theBox.getAttribute("y");
    
    if ((newWidth < 0) || (newHeight < 0))
    {
    }
    else
    {   
      theBox.setAttribute("width", newWidth);
      theBox.setAttribute("height",newHeight);
    }
  }   
}




// 001 804 334 4808 <- was is das :S:S:S:S <-- das ist die handy nummer meines vaters :)
