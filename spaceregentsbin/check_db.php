<?

// Spaceregents Datenbank Checkmodul

function connect()
{
  mysql_connect("localhost","root","");
  mysql_select_db("spaceregents");
}

function check_ships()
{
  $sth=mysql_query("select p.prod_id as pid,s.prod_id from production as p left join shipvalues as s on s.prod_id=p.prod_id where (p.typ='L' or p.typ='M' or p.typ='H') and s.prod_id is NULL");

  if (!$sth)
    echo("Dtasber failure!");
  
  while ($na=mysql_fetch_array($sth))
    echo($na["pid"]." has no shipvalues!!!!!!!!!\n");
}


connect();
check_ships();

?>
