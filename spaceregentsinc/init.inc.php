<?
foreach ($_POST as $key => $value) {
    $$key = $value;
}
foreach ($_GET as $key => $value) {
    $$key = $value;
}

include "../spaceregentsconf/config.inc.php";
include "../spaceregentsinc/func.inc.php";
include "../spaceregentsinc/design.inc.php";
include "../spaceregentsinc/users.inc.php";
include "../spaceregentsinc/gp/dbwrap.inc";
include "../spaceregentsinc/gp/class_session.inc.php";
include "../spaceregentsinc/gp/class_master_auth.inc.php";
include "../spaceregentsinc/gp/class_anon_auth.inc.php";
include "../spaceregentsinc/class_login.php";
include "../spaceregentsinc/class_login_activate.inc.php";

connect();
/* SESSION HANDLING */

$auth_conf=array("ses_name"=>"SR-GAMESES","expire"=>"3600","fid"=>"0","cookies"=>true);
// mop: typ 3 f�r admin session
$ses_conf=array("type"=>"0");
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
  
$ses=&$auth->session();

// mop: logindaten....wrong_logins verhindert bruteforce attacken
if (isset($_POST["__user"]) && isset($_POST["__pass"]) && isset($_POST["activationcode"]))
{
  $GLOBALS["__login"]=new login_activate($db,$auth_conf,$ses);
  if (!$uid=$GLOBALS["__login"]->auth())
  {
    $wrong_logins=$ses->get_var("wrong_logins");
    header("Location: login.php?act=activate&message=".$GLOBALS["__login"]->err_msg);
    die();
  }
  else
  {
    $ses->update_uid($uid);
  }
}
elseif (isset($_POST["__user"]) && isset($_POST["__pass"]))
{
  $GLOBALS["__login"]=new login($db,$auth_conf,$ses);
  if (!$uid=$GLOBALS["__login"]->auth($_POST["__user"],$_POST["__pass"],$ses->get_var("wrong_logins")))
  {
    $wrong_logins=$ses->get_var("wrong_logins");
    header("Location: login.php?message=".$GLOBALS["__login"]->err_msg."&username=".$_POST["__user"]);
    die();
  }
  else
  {
    if ($ses->get_uid()>0)
    {
      setcookie($auth_conf["ses_name"],"",time() - 3600,"/");
      $ses->close_user_session();
      $ses->create_session($uid,$auth_conf["expire"]);
      setcookie($auth_conf["ses_name"],$ses->get_session_id(),time()+$auth_conf["expire"],"/");
    }
    else
    {
      $ses->update_uid($uid);
    }
  }
}
elseif ($ses->get_uid()==0)
{
  header("Location: login.php?message=inv_session");
  die();
}

ob_start();

$uid=$ses->get_uid();

$sth=mysql_query("select s.name from users as u, skins as s where u.id=$uid and u.skin=s.id");

$skin_db=mysql_fetch_assoc($sth);
$skin=$skin_db["name"];

$sth=mysql_query("delete from online where last_chg<=date_sub(now(),interval 3 minute)");

if (!$sth)
  show_error("ERR::DELETE OFFLINE");

$sth=mysql_query("replace into online (uid) values (".$uid.")");

if (!$sth)
  show_error("ERR::REPLACE ONLINE");
?>
