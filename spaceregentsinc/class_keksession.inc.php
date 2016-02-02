<?
class keksession
{
  /*
  keksession 0.1
  */

  var $sess_vars;
  var $page_brith;

  function keksession()
  {
    // Find out if our global configvar exists
    
    if (!$GLOBALS["__keksession_cfg"])
    {
      echo("Couldn't find keksession config variables! RTFM:)");
      return false;
    }
    else
    {
      global $__keksession_cfg;
    }
    
    $this->login_page=$__keksession_cfg["login_page"]; // loginform
    $this->entrance_page=$__keksession_cfg["entrance_page"]; // Page to be redirected to on successful login
    $this->activation_page=$__keksession_cfg["activation_page"]; 
    
    $this->check_active=$__keksession_cfg["check_active"];
    $this->session_name=$__keksession_cfg["session_name"]; // name of session
    $this->session_expire=$__keksession_cfg["session_expire"];
    $this->cookie_expire=$__keksession_cfg["cookie_expire"];
    $this->page_birth=false;

    $this->check();
  }

  function check()
  {
    global ${$this->session_name};	// make the sessionvar global
    global $_POST;
    global $PHP_SELF;

    // on loginpage

    if ($PHP_SELF==$this->login_page && !$_POST)
    {
      return false;
    }

    // variables have to be submitted via post to prevent "wget login.php?kek_user=test&kek_password=testpassword"

    if ($_POST)
    {
      $kek_user=addslashes($_POST["kek_user"]);			// uservar submitted by loginform
      $kek_password=addslashes($_POST["kek_password"]);			// passwordvar submitted by loginform
    }
    
    if ($kek_user || $kek_password)
    {
      switch($this->check_auth($kek_user,$kek_password))
      {
	// default is no error
	case 0:
	  $session=$this->generate_session();
	  $this->redirect("ok");
	  break;
	case 1:
	  $this->redirect("no_db");
	  break;
	case 2:
	  // handle wrong user and wrong password in one step
	  // so hackers don't get a clue if a user is valid or not
	  $this->redirect("pass_user_wrong");
	  break;
	case 3:
	  // can't get encryption method..hope that never happens:)
	  $this->redirect("unknown_encryption_method");
	  break;
	case 4:
	  $this->redirect("unsupported_encryption_method");
	  break;
	case 5:
	  $this->redirect("not_active");
	  break;
	default:
	  echo("An unhandled event occured! Contact the author!");
	  return false;
      }
    }
    else
    {
      // first do the garbage collection

      $this->delete_expired_cookies();
      
      // if we are on on "secure" page
      $session=${$this->session_name}; // put session into $session for easier access
      
      // if no session exists redirect to loginpage
      if (!$session)
      {
	// redirect to login_page
	$this->redirect("login");
      }

      if (!$this->validate_session($session))
      {
	// session has expired or isn't valid anymore
	$this->redirect("not_valid");
      }
      else
      {
	$this->session=$session;
      }
    }
    return true;
  }

  /*
    Called by check() if session doesn't exist and user/pass have been
    submited by login_page
    Args: User and submitted password
    */
  
  function check_auth($user,$password)
  {
    $sth=mysql_query("select id,password,active from users where name='$user'");

    if (!$sth)
      return 1;

    if (mysql_num_rows($sth)==0)
      return 2;

    list($uid,$pass_db,$active)=mysql_fetch_row($sth);

    $encryption_method=$this->get_encryption_method($pass_db);

    switch($encryption_method)
    {
      /*
	we put each crypt in a seperate method
	as of now php decides which encryption method
	based on the salt it gets.
	if php gets a salt/method which is not supported
	it falls back to DES. This is obviously not desired.
	so we put each method in a seperate method and check
	if we can crypt it this way.
      */
      case 1:
	$encrypted=$this->md5_crypt($password,$this->get_md5_salt($pass_db));
	break;
      case 2:
	$encrypted=$this->blowfish_crypt($password,$this->get_blowfish_salt($pass_db));
	break;
      case 3:
	$encrypted=$this->des_crypt($password,$this->get_des_salt($pass_db));
	break;
      case 4:
	$encrypted=$this->edes_crypt($password,$this->get_edes_salt($pass_db));
	break;
      default:
	return 3;
    }

    // if we have an unsupported encryption method for this machine return
    if (!$encrypted)
      return 4;

    if ($this->check_active)
    {
      if ($active==0)
	return 5;
    }

    if ($encrypted==$pass_db)
    {
      // register uid
      $this->uid=$uid;
      return 0;
    }
    else
      return 2;
  }

  function get_encryption_method($pass)
  {
    // MD5
    if (substr($pass,0,3)=='$1$')
      return 1;
    // Blowfish
    elseif (substr($pass,0,3)=='$2$')
      return 2;
    // STD DES
    // is this a valid check for std_des?
    elseif (strlen($pass)==13)
      return 3;
    elseif (strlen($pass)==20)
      return 4;
    else
      return false;
  }

  function get_md5_salt($password)
  {
    // md5 has a 12 characters salt
    return substr($password,0,12);
  }

  function get_blowfish_salt($password)
  {
    // blowfish has a 16 characters salt
    return substr($password,0,16);
  }

  function get_des_salt($password)
  {
    // DES has a 2 characters salt
    return substr($password,0,2);
  }
  
  function get_edes_salt($password)
  {
    // edes has a 9 characters salt
    return substr($password,0,9);
  }

  function md5_crypt($password,$salt)
  {
    if (CRYPT_MD5==1)
      return crypt($password,$salt);
    else
      return false;
  }
  
  function blowfish_crypt($password,$salt)
  {
    if (CRYPT_BLOWFISH==1)
      return crypt($password,$salt);
    else
      return false;
  }
  
  function des_crypt($password,$salt)
  {
    if (CRYPT_STD_DES==1)
      return crypt($password,$salt);
    else
      return false;
  }

  function edes_crypt($password,$salt)
  {
    if (CRYPT_EXT_DES==1)
      return crypt($password,$salt);
    else
      return false;
  }

  function generate_session()
  {
    // first seed the random number generator

    mt_srand((double) microtime() * 20000000);

    $i=0;

    // id really unique?

    do
    {
      $session=md5(uniqid(mt_rand()));
      $i++;
    }
    while (!$this->save_session($session) || $i==100);

    // something really strange must be going on. prevent an endless loop
    if ($i==100)
      return false;
    
    // session is ok and cookie can be set
 
    $this->set_cookie($session);
      
    $this->session=$session;

    return $session;
  }

  function save_session($session)
  {
    $sth=mysql_query("replace into keksession (uid,session) values ('".$this->uid."','".$session."')");

    // session is unique in database - so if this query fails we generate a new one
    if (!$sth)
      return false;
    else
      return true;
  }

  function redirect($message)
  {
    // message is ok if everything worked
    switch($message)
    {
      case "ok":
	Header("Location: ".$this->entrance_page);
	break;
      case "not_active":
	Header("Location: ".$this->activation_page);
	break;
      default:
	Header("Location: ".$this->login_page."?message=$message");
    }
  }
  
  function set_cookie($session)
  {
    // IE doesn't accept cookies if he still has a valid cookie of that site. so we delete the old cookie before setting a new
    setcookie($this->session_name,"");
    setcookie($this->session_name,$session,time()+$this->cookie_expire);
  }

  // Checks if a session is valid

  function validate_session($session)
  {
    $sth=mysql_query("select uid from keksession where session='$session'");

    // session not in database
    if ((!$sth) || (mysql_num_rows($sth)==0))
    {
      return false;
    }
    else
    {
      $uid=mysql_fetch_row($sth);
      
      $sth=mysql_query("update keksession set time=now()+0 where uid=".$uid[0]);
      
      // register uid
      
      $this->uid=$uid[0];
      
      return true;
    }
  }

  function page_birth()
  {
    $sth=mysql_query("select vars from kekvars where sid='".$this->session."'");

    if ((!$sth) || (mysql_num_rows($sth)==0))
    {
      $this->page_birth=true;
      return false;
    }

    $sess_vars=mysql_fetch_row($sth);

    $sess_vars=unserialize($sess_vars[0]);

    if (is_array($sess_vars))
    {
      reset ($sess_vars);
      
      while (list($key,$value)=each($sess_vars))
      {
	global ${$key};
	
	${$key}=$value;
	$this->sess_vars[$key]=&$GLOBALS[$key];
      }
    }

    $this->page_birth=true;
  }

  function page_death()
  {
    global $GLOBALS;

    if (!$this->page_birth)
      return false;
    
    if (is_array($this->sess_vars))
    {
      reset($this->sess_vars);

      $sth=mysql_query("replace into kekvars (vars,sid) values ('".serialize($this->sess_vars)."','".$this->session."')");
    
      if (!$sth)
        return false;
    }
    return true;
  }

  // kek it:) transform it into a kekvar
  function kekit($var)
  {
    global ${$var};
    
    if (isset(${$var}))
    {
      $this->sess_vars[$var]=&${$var};
    }
  }

  function delete_expired_cookies()
  {
    $sth=mysql_query("delete from keksession where time<date_sub(now(),interval ".$this->session_expire." second)-0");
  }

  function get_uid()
  {
    return $this->uid;
  }

  function delete_session()
  {
    $sth=mysql_query("delete from keksession where uid=".$this->uid);
    setcookie($this->session_name,"");
  }
}
?>
