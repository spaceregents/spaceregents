var loadingStep = 0;


/*********
*
*  postURLCallbackStartup(urlRequestStatus)
*
*********/
function postURLCallbackStartup(urlRequestStatus)
{
	switch(loadingStep)
	{
		case 0:
			targetDocument	= fSvgDoc;
			targetElement		= fSvg;
			statusElement		= "status_starmap";
			statusText			= "starmap......succes";
			statusTextFail	= "starmap......failure";
		break;
		case 1:
			targetDocument	= mSvgDoc;
			targetElement		= mSvg.getElementById("sterne");
		break;
		case 2:
			targetDocument	= pSvgDoc;
			targetElement		= pSvgDoc.getElementById("minimap_rahmen");
		break;
		default:
			targetDocument	= null;
			targetElement		= null;
	}

	if (urlRequestStatus.success && targetDocument != null)
	{
		var new_obj = parseXML(urlRequestStatus.content, targetDocument);
		targetElement.appendChild(new_obj);
//	mSvgRoot.appendChild(new_obj); //debug

		writeLoadingStatus(statusElement, statusText,"lime");

		new_obj		= null;			// wieder aufräumen
		homesystem= null;		
		
		loadingStep++;
		mapStartUp(loadingStep);
	}
	else
	{
		writeLoadingStatus("status_starmap","starmap......failure","red");
	}

}


/*********
*
*  mapStartUp(loadingStep)
*
*********/

function mapStartUp(loadingStep)
{
	switch(loadingStep)
	{
		case 0:
			nextLoad = "map_getdefinitions.php";
		break;
		case 1:
			nextLoad = "map_getstarmap.php";
		break;
		case 2:
			nextLoad = "map_getminimap.php";
		break;
		default:
			nextLoad = null;
	}
	
	if (nextLoad != null)
	getURL(nextLoad,postURLCallbackStartup);
}

/*********
*
*  postURLCallbackMinimap(urlRequestStatus)
*
*********/
function postURLCallbackMinimap(urlRequestStatus)
{
	if (urlRequestStatus.success)
	{
		var new_obj = parseXML(urlRequestStatus.content,pSvgDoc);
		pSvgDoc.getElementById("minimap_rahmen").appendChild(new_obj);
//		pSvgRoot.appendChild(new_obj);  	//debug
//		alert("content: "+urlRequestStatus.content);
		new_obj		= null;
		homesystem	= null;
		writeLoadingStatus("status_minimap","minimap...succes","lime");
		createInfoText(urlRequestStatus.content,"green");
	}
	else
	{
		writeLoadingStatus("status_minimap","minimap...failure","red");
	}

}


/*********
*
*  postURLCallbackPanel(urlRequestStatus)
*
*********/
function postURLCallbackPanel(urlRequestStatus)
{
	if (urlRequestStatus.success)
	{
		var new_obj = parseXML(urlRequestStatus.content,pSvgDoc);
		pSvg.getElementById("unitDisplay").appendChild(new_obj);
		new_obj		= null;
		homesystem	= null;
		createInfoText(urlRequestStatus.content,"yellow");
	}
	else
	{
		createInfoText("Failure!","red");
	}

}
