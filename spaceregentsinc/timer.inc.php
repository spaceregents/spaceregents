<?php

//-----------------------------------------------------------------------------------------------------
// Funktion: start_timer()
// Speichert die aktuelle Zeit in einer globalen Variable und startet damit 
// eine Stopuhr
//-----------------------------------------------------------------------------------------------------

function start_timer($i)
{
	$GLOBALS["timer_start_".$i]=(float)get_microtime();
	
	return true;
}

//-----------------------------------------------------------------------------------------------------
// Funktion: read_timer()
// Liest die Zeit einer globalen Variable aus und vergleicht sie mit der aktuellen Zeit.
//-----------------------------------------------------------------------------------------------------

function read_timer($i)
{
	return ((float)get_microtime()-(float)$GLOBALS["timer_start_".$i]);
}

function get_microtime() 
{ 
    list($usec, $sec) = explode(" ", microtime()); 
    return (float)((float)$usec + (float)$sec); 
}
?>