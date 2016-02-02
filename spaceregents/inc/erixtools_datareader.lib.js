/* Data Reader by Erik Oey, part of ERIXTOOLS-JS
	 This is a libary created for Spaceregents (http://www.spaceregents.de)
	 This Code must not be used in commercial or public projects
	 without prior confirmation from the creator of this code
	 07.09.2004 erik@oey.de
*/	 


// class DataReader
function et_cDataReader(textString)
{
	if (arguments.length > 0)
		this.init(textString);
}

et_cDataReader.prototype.init = function(textString)
{
	this.textString = textString;
}

et_cDataReader.prototype.readLn = function()
// cuts first line and returns it
{
	with (this)
	{
		if (textString && textString.length > 0)
		{
			var br = textString.indexOf("\n");
			if (br > 0)
			{
				var ln = textString.slice(0, br);
				textString = textString.slice(br+1);
			}			
			else
			{
				var ln = textString.slice(0);
				textString = null;
			}
		}
		else
			var ln = null;
	}	
	return ln;
}

et_cDataReader.prototype.toString = function()
// gives value of current string back (is being called by alert e.g.)
{
	if (this.textString && this.textString.length > 0)
		return this.textString;
	else
		return null;
}

// ---------------- NON MEMBER FUNCTIONS, but usefull ------------------------------- //
function et_fDataReader_StrToArr(textString, seperator)
// textString : a string,
// seperator 	: char, that seperates the values, which should be put into an array
{
	if (!textString ||textString.length < 0)
		return new Array();

	if (typeof seperator == "undefined" || seperator.length == 0)
		return false;
				
	var Arr = textString.split(seperator);	
	return Arr;
}