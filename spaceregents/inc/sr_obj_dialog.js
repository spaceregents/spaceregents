function dialog(x, y, w, h, url, paramter)
{
	this.x 		= x;
	this.y 		= y;
	this.width 	= w;
	this.height 	= h;
	this.url	= url;
	
	var this.content;
	
	this.getContent = dialog_getContent();
}

function dialog_setContent(request)
{
	if (request.success)
	{
		this.content = 
	}
}