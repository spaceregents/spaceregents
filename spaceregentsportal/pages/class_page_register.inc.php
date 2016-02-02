<?php
class page_register extends base_page
{
  function exec()
  {
    switch ($_REQUEST["act"])
    {
      case "proc_register":
	$errors=$this->check_form($_POST);
	if (!is_array($errors))
	  $this->proc_register($_POST);
	else
	  $this->register($_POST,$errors);
	break;
      default:
	$this->register();
    }
  }

  function register($pre=array(),$errors=array())
  {
    $pre["name"]=stripslashes($pre["name"]);
    $pre["email"]=stripslashes($pre["email"]);
    $this->smarty->assign("pre",$pre);
    $this->smarty->assign("errors",$errors);

    $this->smarty->display("content_register.tpl");
  }

  function check_form($pre)
  {
    $errors=false;
    
    if (!$pre["name"])
      $errors[]="Please provide a name";  
    if (!ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_a-z{|}~]+'.// Zugelassene Zeichen vor dem '@' Symbol
     '@'.                                 // '@' Symbol
     '[-!#$%&\'*+\\/0-9=?A-Z^_a-z{|}~]+'.// Zugelassene Zeichen nach dem '@' Symbol
     '[.]+'.                             // Mindestens 1 Punkt nach dem '@' Symbol
     '[-!#$%&\'*+\\./0-9=?A-Z^_a-z{|}~]+$'// Zugelassene Zeichen nach dem ersten Punkt nach '@'-Symbol
  , $pre["email"]))
      $errors[]="Please provide a valid email";
    if ($pre["password"]!=$pre["password2"])
      $errors[]="Passwords don't match!";
    if (strlen($pre["password"])<4)
      $errors[]="Password must be at least 4 characters long";

    $sth=$this->db->execute("select name from users where name='".$pre["name"]."'");

    if (!$sth)
      $errors[]="Database failure";

    if ($this->db->num_rows($sth)!=0)
      $errors[]="Name already registered";
    
    $sth=$this->db->execute("select email from users where name='".$pre["email"]."'");

    if (!$sth)
      $errors[]="Database failure";

    if ($this->db->num_rows($sth)!=0)
      $errors[]="Email already registered";

    return $errors;
  }

  function proc_register($pre)
  {
    $errors=false;
    
    $sth=$this->db->execute("insert into users set name='".$pre["name"]."',email='".$pre["email"]."',passwd='".crypt($pre["password"],substr(md5(rand()),0,2))."'");

    if (!$sth)
      $errors[]="Database failure";

    if (!$errors)
    {
      $this->smarty->assign("errors",$errors);
      $this->smarty->display("content_proc_register.tpl");
    }
    else
    {
      $this->register($pre,$errors);
    }
  }
}
?>
