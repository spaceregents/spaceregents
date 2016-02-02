function JSONRequest(returnToObject)
{
        this.returnedObject = returnToObject;
}

function JSONRequest.prototype.operationComplete(request)
{
  alert(request.content);
  this.returnedObject = request.content;
}