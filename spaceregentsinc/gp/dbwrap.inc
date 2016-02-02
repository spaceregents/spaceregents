<?php

class dbwrap
{
    public function connect()
    {
        mysql_connect($GLOBALS["mysql_host"], $GLOBALS["mysql_user"], $GLOBALS["mysql_pw"]);
        mysql_select_db($GLOBALS["mysql_db"]);
    }

    public function execute($query)
    {
        return mysql_query($query);
    }

    public function num_rows($handle)
    {
        return mysql_num_rows($handle);
    }

    public function fetch_row($handle)
    {
        return mysql_fetch_row($handle);
    }
}
