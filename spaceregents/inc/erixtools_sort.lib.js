/* Sorting Routines by Erik Oey, part of ERIXTOOLS-JS
	 This is a libary created for Spaceregents (http://www.spaceregents.de)
	 This Code must not be used in commercial or public projects
	 without prior confirmation from the creator of this code
	 07.09.2004 erik@oey.de
*/	 

// Bucket Sort
function bSort(toSortArr)
{
  var i;
  var l       = toSortArr.length;
  var bSorted = new Array();
  var c       = new Array();
  var sum     = 0;
  var dum     = 0;

  for (i = 0; i < l; i++)
    c[toSortArr[i]] = 0;
  
  for (i = 0; i < l; i++)
    c[toSortArr[i]]++;
  
  for (i in c)
  {
    dum = c[i];
    c[i] = sum;
    sum += dum;
  }
  
  for (i = 0; i < l; i++)
  {
    bSorted[c[toSortArr[i]]] = toSortArr[i];
    c[toSortArr[i]]++;
  }
  
  return bSorted;
}


// Bucket Sort Index, sortiert nach Wert, gibt aber ein Array aus den Indices zurueck
function bSortIndex(toSortArr)
{
  var i;
  var bSorted = new Array();
  var c       = new Array();
  var sum     = 0;
  var dum     = 0;
  
  for (i in toSortArr)
    c[toSortArr[i]] = 0;
  
  for (i in toSortArr)
    c[toSortArr[i]]++;
  
  for (i in c)
  {
    dum = c[i];
    c[i] = sum;
    sum += dum;
  }
  
  for (i in toSortArr)
  {
    bSorted[c[toSortArr[i]]] = i;
    c[toSortArr[i]]++;
  }
  
  return bSorted;
}

//  var t0 = new Date().getTime();
//  alert("sorting took "+(new Date().getTime() - t0));
