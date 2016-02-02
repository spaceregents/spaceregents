// ************
// class dialog
// ************

// ----------------------------------------------------------------------------- Constructor 
function dialog(its_width, its_height)
{
	if (arguments.length > 0)
	{
		this.init(its_width, its_height);
	}
}


// ----------------------------------------------------------------------------- dialog.init
function dialog.prototype.init(x, y, width, height)
{
	this.its_width 	= its_width;
	this.its_height = its_height;
	this.its_x = get_x(its_width);
	this.its_y = get_y(its_height);
}


// ----------------------------------------------------------------------------- dialog.getFrame
function dialog.prototype.getFrame()
{
	
}


function dialog.prototype.get_x(its_width)
{
	return ((window.innerWidth / 2) - (its_width / 2));
}

function dialog.prototype.get_y(its_height)
{
	return ((window.innerHeight / 2) - (its_height / 2));
}


// ************************
// subclass jumpgate_dialog
// ************************
jumpgate_dialog.prototype 		= new dialog();
jumpgate_dialog.prototype.constructor 	= jumpgate_dialog;
jumpgate_dialog.superclass 		= dialog.prototype;

function jumpgate_dialog()
{
	this.its_width 	= 400;
	this.its_height	= 400;
	this.init(its_width, its_height);
}

function jumpgate_dialog.get_jumpgates()
{
	jumpgates = fSvgDoc.getElementByTagName("jumpgate");
	
	for (i = 0; i < jumpgates.length; i++)
	{
	}
}






/*****
*
*    Person constructor
*
*****/
function Person(first, last) {
    if ( arguments.length > 0 )
        this.init(first, last);
}

/*****
*
*    Person init
*
*****/
Person.prototype.init = function(first, last) {
    this.first = first;
    this.last  = last;
};

/*****
*
*    Person toString
*
*****/
Person.prototype.toString = function() {
    return this.first + "," + this.last;
};


/*****
*
*    Setup Employee inheritance
*
*****/
Employee.prototype = new Person();
Employee.prototype.constructor = Employee;
Employee.superclass = Person.prototype;

/*****
*
*    Employee constructor
*
*****/
function Employee(first, last, id) {
    if ( arguments.length > 0 )
        this.init(first, last, id);
}

/*****
*
*    Employee init
*
*****/
Employee.prototype.init = function(first, last, id) {    
    // Call superclass method
    Employee.superclass.init.call(this, first, last);

    // init properties
    this.id = id;
}

/*****
*
*    Employee toString
*
*****/
Employee.prototype.toString = function() {
    var name = Employee.superclass.toString.call(this);

    return this.id + ":" + name;
};


/*****
*
*    Setup Manager inheritance
*
*****/
Manager.prototype = new Employee;
Manager.prototype.constructor = Manager;
Manager.superclass = Employee.prototype;

/*****
*
*    Manager constructor
*
*****/
function Manager(first, last, id, department) {
    if ( arguments.length > 0 )
        this.init(first, last, id, department);
}

/*****
*
*    Manager init
*
*****/
Manager.prototype.init = function(first, last, id, department){
    // Call superclass method
    Manager.superclass.init.call(this, first, last, id);

    // init properties
    this.department = department;
}

/*****
*
*    Manager toString
*
*****/
Manager.prototype.toString = function() {
    var employee = Manager.superclass.toString.call(this);

    return employee + " manages " + this.department;
}
