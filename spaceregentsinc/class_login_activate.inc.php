<?php
class login_activate extends master_auth
{
  var $db;
  var $uid;

  function auth()
  {
    $sth=$this->db->execute("select u.id,u.password,a.code from users u,activationcodes a where u.name='".$_POST["__user"]."' and u.id=a.uid");
    
    if (!$sth || $this->db->num_rows($sth)==0)
    {
      $this->throw_error("acc_denied");
      return false;
    }
    
    list($uid,$passwd,$code)=$this->db->fetch_row($sth);
    
    if (crypt($_POST["__pass"],substr($passwd,0,12))==$passwd)
    {
      if ($_POST["activationcode"]!=$code)
      {
	$this->throw_error("wrong_code");
	return false;
      }
      else
      {
	$sth=mysql_query("update users set active=1 where id=$uid");
	return $uid;
      }
    }
    else
    {
      $this->throw_error("acc_denied");
      return 0;
    }
  }
}
?>
