/* URL by Erik Oey, part of ERIXTOOLS-JS
	 This is a libary created for Spaceregents (http://www.spaceregents.de)
	 This Code must not be used in commercial or public projects
	 without prior confirmation from the creator of this code
	 07.09.2004 erik@oey.de
*/	 

function et_cServerRequest(URL, data)
{
	if (arguments.length > 0)
		this.init(URL, data);
}

et_cServerRequest.prototype.init = function(URL, data)
{
	this.url 		= URL;
	
	if (typeof data != "undefined")
		this.data		= data;
	else
		this.data = "";
		
	this.state 	= "IDLE";
	this.mime		= "";
	this.enc		= "";
	this.timePassed = 0;
}

et_cServerRequest.prototype.get = function()
// use method GET
{
	this.timePassed = new Date().getTime();
	getURL(this.url+"?"+this.data, this);
	this.state = "WAIT";
}

et_cServerRequest.prototype.post = function()
// use method POST
{	
	this.timePassed = new Date().getTime();
	postURL(this.url, this.data,  this, this.mime, this.enc);
	this.state = "WAIT";
}

et_cServerRequest.prototype.operationComplete = function(asyncAnswer)
// called upon any transfer or timeout
{
	with (this)
	{
		timePassed = new Date().getTime() - timePassed;
		if (asyncAnswer.success)
		{
			state 	= "DONE";
			et_fServerRequest_Forward(new et_cDataReader(asyncAnswer.content));		
		}
		else
		{
			state = "FAIL";
			et_fServerRequest_Failure(URL, data);
		}
	}
}

et_cServerRequest.prototype.setMime	= function(mime)
{
	if (typeof mime == "undefined")
		this.mime = "";
	else
		this.mime	= mime;
}

et_cServerRequest.prototype.setEnc = function(enc)
{
	if (typeof enc == "undefined")
		this.enc = "";
	else
		this.enc = enc;
}

function et_fServerRequest_Forward(dr)
// called upon successful connection
// dr of class dataReader
{	
	try
	{
		var hndNote = dr.readLn();
		switch (hndNote)
		// put the handle notes here to foward the data to the right functions
		{
			case "STARTUP_STARMAP":
				build_starmap(dr.toString());
			break;
			case "STARTUP_DEFINITIONS":
				build_definitions(dr.toString());
			break;
			case "STARTUP_MINIMAP":
				build_minimap(dr.toString());
			break;
			default:
				alert("unhandled server request\n"+dr);
			break;
		}
	}
	catch(E)
	{
		alert("ERROR\n"+E.message+"\n"+E.name);
	}
}

function et_fServerRequest(URL, data)
// this is being called when the server does not respond, 404, etc...
// you can put some kind of 'server does not respond' message in here
{
	alert("SERVER ERROR");
}