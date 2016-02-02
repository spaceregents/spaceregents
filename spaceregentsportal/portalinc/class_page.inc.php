<?php
class page
{
  var $name;
  var $smarty;
  var $db;
  var $admin=false;
  var $title;
  
  function page($name)
  {
    $this->name=$name;
  }

  function get_name()
  {
    return $this->name;
  }

  function assign_smarty(&$smarty)
  {
    $this->smarty=$smarty;
  }

  function assign_db($db)
  {
    $this->db=$db;
  }

  function set_title($title)
  {
    $this->title=$title;
  }

  function get_title()
  {
    return $this->title;
  }
  
  function display()
  {
    global $__portal_base_dir;
    $page_file    =$__portal_base_dir."pages/class_page_".$this->get_name().".inc.php";
    $page_template="content_".$this->get_name().".tpl";
    $classname    ="page_".$this->get_name();
    
    $this->smarty->display("header.tpl");
    // mop: ausgabe separat abgehandelt
    if (file_exists($page_file))
    {
      include $page_file;
      $page_code=new $classname($this->db,$GLOBALS["ses"]->get_uid(),$this->smarty);
      $page_code->set_adminmode($this->adminmode());
      $page_code->exec();
    }
    else
    {
      // mop: Ansonsten einfaches template der seite ausgeben
      $this->smarty->display("content_".$this->get_name().".tpl");
    }
    $this->smarty->display("footer.tpl");
  }

  function set_adminmode()
  {
    $this->admin=true;
  }

  function adminmode()
  {
    return $this->admin;
  }
}
?>
