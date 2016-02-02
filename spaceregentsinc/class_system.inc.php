<?
class SYSTEM
{
	var $id;
	var $x;
	var $y;
	var $name;
	var $cid;
	var $type;
	var $scan;			// boolean, gibt an ob das System für den User! in Scanreichweite ist, als FALSE initialisiert
	var $jumpgate;	// gibt den Planeten des Jumpgates an, wenn nicht vorhande $jumpgate = 0
	var $scanradius;
	var $planeten 			= array();
	
	//*******************-----------------------------------------------------------------| constructor;
	function SYSTEM($sid=0)
	{
		global $standard_scan_radius;
		if ($sid)
		{
			// globale System Variablen
			$sth = mysql_query("SELECT * FROM systems WHERE id='$sid'");
			
			if (!$sth || (!mysql_num_rows($sth)))
				return 0;
			
			$its_system = mysql_fetch_array($sth);
			
			$this->id		= $sid;
			$this->x		= $its_system["x"];
			$this->y		= $its_system["y"];
			$this->name	= $its_system["name"];
			$this->cid	= $its_system["cid"];
			$this->type	= $its_system["type"];
			$this->scan = false;
			$this->jumpgate 	= false;
			$this->scanradius = $standart_scan_radius;
		}
	}
	//-------------------*

	

	//*******************-----------------------------------------------------------------| get_planets();
	function get_planets()
	{
		/*
			$sth = mysql_query("SELECT id FROM planets WHERE sid=$sid");

			if (!$sth || (!mysql_num_rows($sth)))
			return 0;
			
			while ($its_planets = mysql_fetch_array($sth))
			{
				$planeten[] = new PLANET($its_planets["id"], $this->$name);
			}			
		*/
	}	
	//-------------------*


	
	//*******************-----------------------------------------------------------------| make_visible();
	function make_visible()
	{
		$this->scan = true;
	}
	//-------------------*



	//*******************-----------------------------------------------------------------| make_invisible();
	function make_invisible()
	{
		$this->scan = false;
	}
	//-------------------*
}
?>