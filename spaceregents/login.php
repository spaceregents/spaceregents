<?
include "../spaceregentsconf/config.inc.php";
include "../spaceregentsinc/func.inc.php";
include "../spaceregentsinc/design.inc.php";
include "../spaceregentsinc/class_medic.php";
include "../spaceregentsinc/class_universe.inc.php";
include "../spaceregentsinc/class_god.inc.php";
include "../spaceregentsinc/gp/dbwrap.inc";
include "../spaceregentsinc/vector_math.inc.php";


connect();

$medic=new medic();
$medic->check_db();

function start_login()
{
  echo("<html>
<head>
<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\">
<title>Space Regents Login</title>
</head>
<body bgcolor=\"black\">
<link rel=\"stylesheet\" type=\"text/css\" href=\"inc/srdesign.css\">
<center>
<table>
<tr class=\"text\">
<td class=\"text\"><img src=\"arts/sr_promopic_small.jpg\"></td><td class=\"text\">
");
}

function end_login()
{
  echo("</td></tr>");
  echo("</table>"); 
  echo("</center>");
  echo("</body>");
  echo("</html>");
}

function print_error($error)
{
  echo("<tr><td height=\"50\" colspan=\"2\" style=\"color: red\"><b>");
  if ($error)
  {
    switch($error)
    {
      case "inv_session":
        echo("Your session is not valid or has expired!");
        break;
      case "acc_denied":
        echo("The supplied password or username is wrong!<br>Forgot your password? Click <a href=\"".$_SERVER["PHP_SELF"]."?act=mail_new_pass&username=".$_GET["username"]."\">here</a>.");
        break;
      case "new_account":
  echo("A mail containing your activationcode should arrive soon");
  break;
      case "wrong_code":
  echo("Wrong activationcode");
  break;
      case "not_active":
  echo("Your account is not yet active");
  break;
      case "new_pass":
        echo("In case your account exists a mail has been sent to your email with a new pass");
        break;
    }
  }
  echo("</b></td></tr>");
  
}

function login($message=false)
{
  start_login();
  echo("<form action=\"overview.php\" method=\"POST\">");
  echo("<table>");
  if ($message)
    print_error($message);
  echo("<tr><td width=\"150\">Username</td><td><input name=\"__user\"></td></tr>");
  echo("<tr><td width=\"150\">Password</td><td><input type=password name=\"__pass\"></td></tr>");
  echo("<tr><td><input type=\"submit\" value=\"Login\"></td></tr>");
  echo("</table>");
  echo("</form>");
  
  end_login();
}

function act_code()
{
  global $PHP_SELF;
  global $name;
  global $act_code;
  global $password;
  
  if ($act_code!="")
    {
      $sth=mysql_query("select ac.code from users as u,activationcodes as ac where u.id=ac.uid and u.name='$name'");
      $code=mysql_fetch_array($sth);
      
      if ($code["code"]==$act_code)
  {
    mysql_query("update users set active=1 where name='$name'");
    return 1;
  }
      else return 0;
    }
  else
    {
      echo("<body bgcolor=\"black\"><center><font color=\"white\">");
      echo("<form action=\"".$PHP_SELF."\" method=post>");
      table_start();
    echo("<p>Please enter your Activation Code</p>");
      table_form_text("","act_code","");
      table_end();
      form_hidden("name",$name);
      form_hidden("password",$password);
      form_submit("Submit");
      echo("</form></center></font>");
    echo("</body>");
      table_end();
      return 0;
    }
}

function activate($error="")
{
  start_login();
  echo("<form action=\"overview.php\" method=\"POST\">");
  echo("<center><h2>Activate your Account</h2>");
  echo("<table border=\"0\">");
  if ($error)
    print_error($error);
  echo("<tr><td width=\"150\">Username</td><td><input name=\"__user\" value=\"".$_POST["__user"]."\"></td></tr>");
  echo("<tr><td width=\"150\">Password</td><td><input type=\"password\" name=\"__pass\"></td></tr>");
  echo("<tr><td width=\"150\">Activationcode</td><td><input name=\"activationcode\" value=\"".$_POST["activationcode"]."\"></td></tr>");
  echo("</table>");
  echo("<input type=\"submit\">");
  echo("</center></form>");
  end_login();
}

function new_account($error="")
{
  start_login();
  echo("<form action=\"".$PHP_SELF."\" method=\"POST\">");
  echo("<center><h2>New Account</h2>");
  if (strlen($error)>0)
    echo("<h3 style=\"color: red\">".$error."</h3>");
  echo("<table border=\"0\">");
  echo("<tr><td width=\"150\">Name</td><td><input name=\"username\" value=\"".$_POST["username"]."\"></td></tr>");
  echo("<tr><td width=\"150\">Name of your imperium</td><td><input name=\"imperium\" value=\"".$_POST["imperium"]."\"></td></tr>");
  echo("<tr><td width=\"150\">E-Mail</td><td><input name=\"email\" value=\"".$_POST["email"]."\"></td></tr>");
  echo("<tr><td width=\"150\">Password</td><td><input type=\"password\" name=\"password\"></td></tr>");
  echo("<tr><td width=\"150\">Re-enter password</td><td><input type=\"password\" name=\"password2\"></td></tr>");
  echo("</table>");
  echo("<input type=\"hidden\" name=\"act\" value=\"proc_new_account\">");
  echo("<input type=\"submit\">");
  echo("</center></form>");
  end_login();
}

function proc_new_account()
{
  global $standard_scan_radius;

  $name=trim($_POST["username"]);
  $imperium=trim($_POST["imperium"]);
  $email=trim($_POST["email"]);
  $password=trim($_POST["password"]);
  $password2=trim($_POST["password2"]);
  
  $error="";
  
  if ($name=="")
    $error=$error."No name selected!<br>";
  
  $sth=mysql_query("select * from users where name='$name'");
  if (mysql_num_rows($sth)>0)
    $error=$error."Name already selected!<br>";
  
  if ($imperium=="")
    $error=$error."No empire selected!<br>";

  $sth=mysql_query("select imperium from users where imperium='$imperium'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
    $error=$error."empire already selected!<br>";

  if (!mail_check($email))
    $error=$error."You must enter a valid email!<br>";

  $sth=mysql_query("select email from users where email='$email'");
  if (mysql_num_rows($sth)>0)
    $error=$error."Email already exists<br>";

  if ($password!=$password2)
    $error=$error."Passwords don't match!<br>";
  
  if (strlen($password)<4)
  $error=$error."Your Password must contain at least 4 characters!";

  if (strlen($error)==0)
  {
    $sth=mysql_query("insert into users (name,imperium,email,password) values ('$name','$imperium','$email','".crypt($password)."')");

    if (!$sth)
    {
      show_error("Database Failure!");
      return 0;
    }

    $uid=mysql_insert_id();

    $sth=mysql_query("insert into ressources (metal,energy,mopgas,erkunum,gortium,susebloom,colonists,money,uid) values ('1000','1000','0','0','0','0','5','1000000','$uid')");

    if (!$sth)
    {
      show_error("Database Failure!");
      return 0;
    }

    $start=startplanet();

    $sth=mysql_query("update planets set uid='$uid',population='1000000' where id='".$start."'");

    if (!$sth)
    {
      show_error("Database Failure!");
      return 0;
    }

    $sth=mysql_query("insert into popgain set pid=".$start);

    if (!$sth)
    {
      show_error("ERR::SET POPGAIN");
      return 0;
    }

    $sth=mysql_query("update users set homeworld=$start where id='".$uid."'");

    if (!$sth)
    {
      show_error("Database Failure!");
      return 0;
    }

    $sth=mysql_query("select p.sid,s.cid from planets p,systems s where p.id=".$start." and p.sid=s.id");

    if (!$sth)
    {
      show_error("ERR::GET SID");
      return 0;
    }

    list($sid,$cid)=mysql_fetch_row($sth);

    $sth1=mysql_query("replace into __scanranges_".$cid." (sid,uid,type,range,last_update) values ('".$sid."','".$uid."','0','".$standard_scan_radius."','".$time."')");


    mt_srand ((double) microtime() * 1000000);
    $act_code=mt_rand(100000,99999999);
    $sth=mysql_query("insert into activationcodes (code,uid) values ('".$act_code."','$uid')");

    // WIIIIIICHTIG!

    $sth=mysql_query("insert into research (uid,t_id) values ('$uid','0')");
    $sth=mysql_query("insert into research (uid,t_id) values ('$uid','1')");

    $sth=mysql_query("update users set skin=1 where id=$uid");

    $the_mail="Welcome to the Pre-Beta-Round Regent!

Your Login: $name
Your Empire: $imperium
Your Pass: $password
Your Activationcode: $act_code

To activate your account click on the following link:

http://www.spaceregents.de/spaceregents/login.php?act=activate

Please not that this is a TEST(!)-Round. That means that SpaceRegents
may still be full of bugs and unimplemented features. As a tester you
are supposed to report any bugs you encounter and report them in
our forums. You can and (maybe should ;) ) try to hack our scripts
but you should (again) report any successfull hacks in the forum.

Last but not least: Good luck and have fun ;)

The SpaceRegents Team
";

    mail($email,"Your Spaceregents Activation Code", $the_mail,"From: webmaster@spaceregents.de\nReply-To: webmaster@spaceregents.de\nX-Mailer: PHP/" . phpversion());

    ticker($uid,"*lmail.php*Hi and welcome to SpaceRegents. A mail with quickstart instructions is in your Inbox. Click here to see your Inbox.","w");

    $quickstart="Welcome to Spaceregents, the ultimate Space Strategy!

This is a short quickstart and should give you the
first hints on how to play SpaceRegents.

On the left you'll find your buddy list and the
Navgationpanel.

Navigationbuttons (in top-down order):

Overview (the page you saw when logging in)
Communication (Communiction, Alliance menus.)
Ranking
Planets and Production (Planets, Build menu)
Fleet (Fleetmanagement)
Map (The SpaceRegents starmap)
Research
Covertops (Espionage and sabotage your enemies)
Trade (Trading of ressources)

Furthermore you'll see the Preferences and Logout
buttons in the lower left corner.

First you should start your research and build
something on a planet (Metal mine is recommended).
The time is estimated in weeks. 1 week in
SpaceRegents is equal to 1 hour in reality.
After that you should have a look at the Map (make
sure you have a supported SVG Viewer on your
system) to get an idea where you are located and
who is in your neighbourhood. If you want you can
examine the alliances which exist in Spaceregents
so far. As a neutral player you can't be attacked
but you have several limitations in the game. If
you join an alliance you don't have these
limitations but you can be attacked. So you are
safe for now but should consider to join/create an
alliance soon. It may be a good idea to contact
your direct neighbours as well.

This should have given you a first glance at
SpaceRegents. More about the features of
Spaceregents is explained in the manual. If you
need help feel free to join the forum and post
your questions there.

Good luck and have fun!

The Spaceregents Team.";

    mail_to_uid($uid,"Quickstart",$quickstart);

    // runelord: options setzen  
    $sth = mysql_query("insert into options (uid, map_size) values(".$uid.",1)");

    if (!$sth)
    {
      show_error("Database Failure!");
      return 0;
    }

    // geben wir noch jedem ein scout :)
    // nächste freie fleet_id finden
    $sth = mysql_query("select if(max(fid) is NULL,1,max(fid)+1) from fleet_info");

    if (!$sth)
    {
      show_error("Database Failure!");
      return 0;
    }

    list($next_fid) = mysql_fetch_row($sth);

    // eintrag in fleet_info
    $sth = mysql_query("insert into fleet_info (fid, pid, sid, name, uid) values('$next_fid','$start','$sid','Explorer','$uid')");

    if (!$sth)
    {
      show_error("Database Failure! 2x");
      return 0;
    }

    $sth = mysql_query("insert into fleet values (2,1,0,'$next_fid')");

    if (!$sth)
    {
      show_error("Database Failure! 3x");
      return 0;
    }
    
    $sth=mysql_query("insert into income_stats set uid=".$uid);

    if (!$sth)
    {
      show_error("ERR::INCOME STATS");
      return 0;
    }
    activate("new_account");
  }
  else
  {
    new_account($error);
  }
}

function startplanet() 
{
  $god = new god();
  return $god->find_a_neat_home();
}

function mail_new_pass($username)
{
  $sth=mysql_query("select id,email from users where name='".$username."'");

  if (!$sth || mysql_num_rows($sth)==0)
    return false;

  list($id,$email)=mysql_fetch_row($sth);

  $new_pass=substr(md5(uniqid("")),0,8);

  $sth=mysql_query("update users set password='".crypt($new_pass)."' where id=".$id);

  if (!$sth)
    return false;

  mail($email,"New SpaceRegents password","You have requested a new password:

".$new_pass,"From: webmaster@spaceregents.de\nReply-To: webmaster@spaceregents.de\nX-Mailer: PHP/" . phpversion());
}

switch($_REQUEST["act"])
{
  case "activate":
    activate($_GET["message"]);
  break;
  break;
  case "new_account":
    new_account();
  break;
  case "proc_new_account":
    proc_new_account();
    break;
  case "mail_new_pass";
    mail_new_pass($_GET["username"]);
    login("new_pass");
    break;
  default:
  login($_GET["message"]);
}
?>
