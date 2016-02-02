<?php
class SQLException extends Exception
{
  function SQLException()
  {
    parent::__construct();
    $this->message="SQL FAILURE => ".mysql_error()." in ".$this->file." on line ".$this->line."\n";
  }
}

class GenericException extends Exception
{
  function __construct($message)
  {
    $this->message=$message;
  }
}
?>
