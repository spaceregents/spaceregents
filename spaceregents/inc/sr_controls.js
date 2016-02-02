function executeItemControl(evt, controlType) {
  var itsCaller;
  var itsItem;
  var itsClass;

  // mop: stop propagation to sr_class_MASTA
  evt.stopPropagation();

  // rune: nur bei einfachem click  
  if (evt.detail == 1)
  {
    itsCaller=evt.target.correspondingUseElement ? evt.target.correspondingUseElement : evt.target;
    itsItem = itsCaller.parentNode.parentNode;

    itsClass = masta.itemBox.item[Number(itsItem.getAttribute("itemNo"))];
    switch (controlType)
    {
      case "Tachyon Scan":
        itemControlDoTachyonScan(itsClass);
      break;
      case "manage fleet":
        itemControlManageFleet(itsClass);
      break;
      case "transfer infantry":
        itemControlTransferInfantry(itsClass);
      break;
      case "examine fleet":
        itemControlExamineFleet(itsClass);
      break;
    }
  }
}
//-------------------------------------------------


function itemControlDoTachyonScan(itsClass)
{
  var newWindow;
  var newTextBox;
  var wWidth  = 400;
  var wHeight = 400;

  newWindow   = new SR_CLASS_WINDOW(masta.getWindowCount(), (Number(window.innerWidth) / 2) - (wWidth / 2), (Number(window.innerHeight) / 2) - (wHeight / 2), wWidth, wHeight, "Tachyon Scan on "+itsClass.topic, false, true);
  getURL("map_control.php?act=tachyonscan&oid="+itsClass.oid, newTextBox  = new SR_CLASS_TEXTBOX(0, masta.getWindowCount(), 10, 25, wWidth -20, wHeight - 25, "scanning...", "mapDialogText1", false, false));

  newWindow.addComponent(newTextBox);
  masta.addWindow(newWindow);
}
//-------------------------------------------------


function itemControlManageFleet(itsClass)
{
  var i;
  var wWidth  = 400;
  var wHeight = 400;
  var curFleets;

  if (!masta.containers["fManage"])
  {
    masta.containers["fManage"]=new SR_CLASS_FLEET_MANAGEMENT((Number(window.innerWidth) / 2) - (wWidth / 2), (Number(window.innerHeight) / 2) - (wHeight / 2), wWidth, wHeight);
  }
  fleet=itsClass.fleet;
  found=false;
  for (i=0;(i<masta.containers["fManage"].fleets.length && !found);i++)
  {
    if (masta.containers["fManage"].fleets[i].id==fleet.id)
      found=true;
  }
  if (!found)
  {
    masta.containers["fManage"].addFleet(fleet);
  }
}
//-------------------------------------------------

function itemControlTransferInfantry(itsClass)
{
  masta.createInfTransfer(itsClass);
}

function itemControlExamineFleet(itsClass)
{
  var wWidth = 335;
  var wHeight= 400;
  var newWindow;
  
  newWindow = new SR_CLASS_WINDOW(masta.getWindowCount(), (Number(window.innerWidth) / 2) - (wWidth / 2), (Number(window.innerHeight) / 2) - (wHeight / 2), wWidth, wHeight, "Examing fleet "+itsClass.topic, false, true);  
  getURL("map_control.php?act=examine_fleet&fid="+itsClass.oid, newWindow);
}