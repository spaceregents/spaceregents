<?php
include $__base_inc_dir       ."gp/class_session.inc.php";
include $__base_inc_dir       ."gp/class_master_auth.inc.php";
include $__base_inc_dir       ."gp/class_anon_auth.inc.php";
/* SESSION HANDLING */

$auth_conf=array("ses_name"=>"SR-SES","expire"=>"7200","fid"=>"0","cookies"=>true);
// mop: typ 3 für admin session
$ses_conf=array("type"=>"1");

$auth=new anon_auth($db,$auth_conf,$ses_conf);

if ($_GET["logout"]==1 && $auth->ses->validate())
  $auth->close_session();

if (!$auth->ses->validate())
{
  if (!$auth->auth())
  {
    print "INTERNAL ERROR!";
    $db->execute("########## SESSION ERROR ##### ".$db->errstr());
    die();
  }
}
  
$GLOBALS["ses"]=&$auth->session();

// mop: logindaten....wrong_logins verhindert bruteforce attacken
if ($GLOBALS["ses"]->get_uid()==0 && isset($_POST["__portal_user"]) && isset($_POST["__portal_pass"]) && $GLOBALS["ses"]->get_var("wrong_logins")<10)
{
  include "class_login.inc.php";
  $login=new login($db,$auth_conf,$GLOBALS["ses"]);
  if (!$uid=$login->auth($_POST["__portal_user"],$_POST["__portal_pass"],$ses->get_var("wrong_logins")))
  {
    $wrong_logins=$ses->get_var("wrong_logins");
    $GLOBALS["ses"]->reg("wrong_logins",$wrong_logins++);
  }
  else
  {
    $GLOBALS["ses"]->update_uid($uid);
  }
}
/* ENDE */
?>
