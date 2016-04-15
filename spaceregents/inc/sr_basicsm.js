function init(evt)
{
 svgdoc = evt.getCurrentNode().getOwnerDocument();
 plbuttons = svgdoc.getElementById('plbuttons');
 plbuttons.addEventListener('mouseover',rphighlight,false);
}

function rphighlight(evt)
{
 dieID = evt.getTarget().getParentNode().firstChild.getNextSibling().getId();dieID = dieID.slice(2);
 if (dieID != oldPlanetBar)
 {
  if (oldPlanetBar != 0)
  {
   oldObj = svgdoc.getElementById('rp'+oldPlanetBar);
//   oldObj.getStyle().setProperty('fill','#3821a4');
   oldObj.setAttribute('fill','url(#plbuttongrad1)');
  }
  obj = evt.getTarget().getParentNode().firstChild.getNextSibling();
//  obj.getStyle().setProperty('fill','#3821ff')
  obj.setAttribute('fill','url(#plbuttongrad2)');
  oldPlanetBar = dieID;
 }
}

function popup(dieID, x , y, i)
{
fenster=svgdoc.getElementById('targetcross');
fenster_name=svgdoc.getElementById('fenster_name');
fenster_name=fenster_name.firstChild;
fenster_name.setData(planetsname[dieID]);
fenster_owner=svgdoc.getElementById('fenster_owner');
fenster_owner=fenster_owner.firstChild;
fenster_owner.setData(planetsowner[dieID]);
fenster_alliance=svgdoc.getElementById('fenster_alliance');
fenster_alliance=fenster_alliance.firstChild;
fenster_alliance.setData(planetsalliance[dieID]);
fenster=svgdoc.getElementById('targetcross');
new_pos=fenster.setAttribute("transform","translate("+(x)+" "+(y)+")");
fenster_rot=svgdoc.getElementById('fenster_rotate');
new_rot=fenster_rot.setAttribute("dur", i);
fenster_rot2=svgdoc.getElementById('fenster_g_rotate');
new_rot2=fenster_rot2.setAttribute("dur",i);
fenster.setAttribute("visibility","show");
if (dieID != oldPlanetBar)
{
 if (oldPlanetBar != 0)
 {
  planetbar = svgdoc.getElementById('rp'+oldPlanetBar);
//  planetbar.getStyle().setProperty('fill','#3821a4');
  planetbar.setAttribute('fill','url(#plbuttongrad1)');
 }
 planetbar = svgdoc.getElementById('rp'+dieID);
// planetbar.getStyle().setProperty('fill','#3821ff');
 planetbar.setAttribute('fill','url(#plbuttongrad2)');
 oldPlanetBar = dieID;
}
return true;
}

function popout(dieID)
{
}