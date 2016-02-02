<?php

//-----------------------------------------------------------------------------------------------------
// Funktion: dcount()
// Führt einen Count in einer Tabelle mit einer bestimmte WHERE-Clause aus.
//-----------------------------------------------------------------------------------------------------

function dcount($field, $table, $where="")
{
	$sql="SELECT COUNT($field) FROM $table";
	
	if ($where)
		$sql="$sql WHERE $where";
	
	$query=mysql_query($sql) or die ("DCount ($sql): ".mysql_error());
	
	list($retval)=mysql_fetch_row($query);
	
	return $retval;
}

function dexec($sql)
{
	$query=mysql_query($sql) or die ("DExec ($sql): ".mysql_error());
	
	return mysql_affected_rows();
}

function dlookup($field, $table, $where="")
{
	$sql="SELECT $field FROM $table";
	
	if ($where)
		$sql="$sql WHERE $where";
	
	$query=mysql_query("$sql LIMIT 1") or die ("DLookup ($sql): ".mysql_error());
	
	if (mysql_num_rows($query)>0)
		list($retval)=mysql_fetch_row($query);
	else
		$retval=false;
	
	return $retval;
}

function dselect($field, $table, $where="")
{
	$sql="SELECT $field FROM $table";
	
	if ($where)
		$sql="$sql WHERE $where";
	
	$query=mysql_query("$sql LIMIT 1") or die ("DSelect ($sql): ".mysql_error());
	
	if (mysql_num_rows($query)>0)
		$retval=mysql_fetch_row($query);
	else
		$retval=false;
	
	return $retval;
}

function dmax($field, $table, $where="")
{
	$sql="SELECT MAX(IFNULL($field,0)) FROM $table";
	
	if ($where)
		$sql="$sql WHERE $where";
	
	$query=mysql_query($sql) or die ("DMax ($sql): ".mysql_error());
	
	list($retval)=mysql_fetch_row($query);
	
	return $retval;
}

function dsum($field, $table, $where="")
{
	$sql="SELECT SUM(IFNULL($field,0)) FROM $table";
	
	if ($where)
		$sql="$sql WHERE $where";
	
	$query=mysql_query($sql) or die ("DSum ($sql): ".mysql_error());
	
	list($retval)=mysql_fetch_row($query);
	
	return $retval;
}

?>