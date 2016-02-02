<?php
class login extends master_auth
{
  var $db;
  var $uid;

  function auth($name,$pass)
  {
    $sth=$this->db->execute("select id,password,active from users where name='".$name."'");
    
    if (!$sth || $this->db->num_rows($sth)==0)
    {
      $this->throw_error("acc_denied");
      return false;
    }
    
    list($uid,$passwd,$active)=$this->db->fetch_row($sth);
    
    if (crypt($pass,substr($passwd,0,12))==$passwd)
    {
      if ($active!=1)
      {
	$this->throw_error("not_active");
	return false;
      }
      else
      {
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
