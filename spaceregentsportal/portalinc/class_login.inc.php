<?php
class login extends master_auth
{
  var $db;
  var $uid;

  function auth($name,$pass)
  {
    $sth=$this->db->execute("select uid,passwd from users where name='".$name."'");
    
    if (!$sth || $this->db->num_rows($sth)==0)
      return false;
    
    list($uid,$passwd)=$this->db->fetch_row($sth);

    if (crypt($pass,substr($passwd,0,2))==$passwd || md5($pass)==$passwd)
    {
      return $uid;
    }
    else
    {
      return 0;
    }
  }
}
?>
