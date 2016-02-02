<?php
class base_page
{
  var $admin=false;
  
  function base_page(&$db,$uid,&$smarty)
  {
    $this->uid=$uid;
    $this->db=$db;
    $this->smarty=$smarty;
    $this->smarty->debugging=false;
    $this->smarty->debug_tpl=SMARTY_DIR."debug.tpl";
  }

  function set_adminmode($value)
  {
    $this->admin=$value;
  }

  function adminmode()
  {
    return $this->admin;
  }
}
?>
