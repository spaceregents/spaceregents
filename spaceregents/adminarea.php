<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
return 0;

// Bis hier immer so machen:)

function admin_secure()
{
global $PHP_SELF;
global $uid;

$sth=mysql_query("select name,admin from users where id=$uid");

if (mysql_num_rows($sth)=="")
{
show_message("Forbidden");
return 0;
}


if (!$sth)
{
show_message("Database Failure");
return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]=="")
{
show_message("Forbidden");
return 0;
}

show_message("Your password :");
echo("<center><form action=\"".$PHP_SELF."?act=enter\" method=post>");
echo("<p><input type=password name=\"password\"></p>");
echo("<input type=submit value=\"Enter\" name=\"adminlogin\">");
echo("</form></center>\n");
}

function show_menu()
{
  global $uid;
  
  $sth=mysql_query("select admin,name from users where id=$uid");

  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }

  $admin=mysql_fetch_array($sth);

  if ($admin["admin"]=="")
  {
    show_message("Forbidden");
    return 0;
  }

  switch ($admin["admin"])
   {
    case 1:
     show_message("Welcome noble God ".$admin["name"]);
     table_start("center","500");
     table_head_text(array("Admin Area - Level 1"),"2");
     table_text(array("&nbsp;"),"","","2","text");
     table_text(array("<a href=\"".$PHP_SELF."?act=messenges\">Messenger</a>","Send Messages"),"","","","text");
     table_text(array("<a href='".$PHP_SELF."?act=users&order=name'>Users</a>","List and Modify Users"),"","","","text");
     table_text(array("<a href='".$PHP_SELF."?act=ships&order=prod_id'>Ships</a>","List and Modify Ships"),"","","","text");
     table_text(array("<a href='".$PHP_SELF."?act=buildings&order=prod_id'>Buildings</a>","List and Modify Buildings"),"","","","text");
    break;
    case 2:
    show_message("Greetings good Gamemaster ".$admin["name"]);
     table_start("center","500");
     table_head_text(array("Admin Area - Level 2"),"2");
     table_text(array("&nbsp;"),"","","2","text");
     table_text(array("<a href=\"".$PHP_SELF."?act=messenges\">Messenger</a>","Send Messages"),"","","","text");
     table_text(array("<a href=\"".$PHP_SELF."?act=users&order=id\">Users</a>","List and Users"),"","","","text");
     table_text(array("<a href='".$PHP_SELF."?act=ships&order=id'>Ships</a>","List and Modify Ships"),"","","","text");
    break;
    case 3:
     show_message("Hello Choosen ".$admin["name"]);
     table_start("center","500");
     table_head_text(array("Admin Area - Level 3"),"2");
     table_text(array("&nbsp;"),"","","2","text");
     table_text(array("<a href=\"".$PHP_SELF."?act=messenges\">Messenger</a>","Send Messages"),"","","","text");
     table_text(array("<a href=\"".$PHP_SELF."?act=users&order=id\">Users</a>","List Users"),"","","","text");
//   table_text(array("<a href='".$PHP_SELF."?act=ships&order=id'>Ships</a>","List Ships"),"","","","text");
    break;
   }
  table_end();
}

function gate()
{
  global $PHP_SELF;
  global $uid;
  global $password;

  $sth=mysql_query("select admin,name,apw from users where id=$uid");

  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }

  $admin=mysql_fetch_array($sth);

  if ($admin["apw"]!=$password or $admin["admin"]=="")
  {
    show_message("Acces denied");
    return 0;
  }
  else
  {
    show_menu();
  }
}

function list_users()
{
global $PHP_SELF;
global $uid;
global $order;

$sth=mysql_query("select admin,name from users where id=$uid");

if (!$sth)
{
show_message("Databse Failure");
return 0;
}

if (mysql_num_rows($sth)==0)
{
show_message("Forbidden");
return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]=="")
{
show_message("Forbidden");
return 0;
}

$sth=mysql_query("select * from users order by ".$order."");

if (!$sth)
{
  show_message("Databse Failure");
  return 0;
}

echo("<br><br>\n");
echo("<a href='".$PHP_SELF."?act=menu'>back</a>\n");
echo("<br><br>\n");

table_start("center","100%");

switch ($admin["admin"])
{
case 1:
   table_head_text(array("Admin Area - Users - Level 1"),"14");
   table_text(array("&nbsp;","<a href='".$PHP_SELF."?act=users&order=id'>ID</a>","<a href='".$PHP_SELF."?act=users&order=name'>Name</a>","<a href='".$PHP_SELF."?act=users&order=password'>Password</a>","<a href='".$PHP_SELF."?act=users&order=imperium'>Imperium</a>","<a href='".$PHP_SELF."?act=users&order=email'>E-mail</a>","<a href='".$PHP_SELF."?act=users&order=active'>Active</a>","<a href='".$PHP_SELF."?act=users&order=last_login'>Last Login</a>","<a href='".$PHP_SELF."?act=users&order=homeworld'>Homeworld</a>","<a href='".$PHP_SELF."?act=users&order=alliance'>Alliance</a>","<a href='".$PHP_SELF."?act=users&order=score'>Score</a>","<a href='".$PHP_SELF."?act=users&order=moz'>Mozilla</a>","<a href='".$PHP_SELF."?act=users&order=admin'>Admin</a>"),"","","","smallhead");
   while ($user=mysql_fetch_array($sth))
    {
         $user["last_login"]=substr($user["last_login"],6,2).".".substr($user["last_login"],4,2).".".substr($user["last_login"],0,4)." ".substr($user["last_login"],8,2).":".substr($user["last_login"],10,2);
         table_text(array("<a href='".$PHP_SELF."?act=user_mod&id=".$user["id"]."'>modify</a>",$user["id"],"<a href=\"".$PHP_SELF."?act=messenges&uname=".$user["name"]."\">".$user["name"]."</a>",$user["password"],$user["imperium"],"<a href='mailto:".$user["email"]."'>".$user["email"]."</a>",$user["active"],$user["last_login"],$user["homeworld"],$user["alliance"],$user["score"],$user["moz"],$user["admin"]),"","","","text");
        }
break;
case 2:
   table_head_text(array("Admin Area - Users - Level 2"),"13");
   table_text(array("&nbsp;","<a href='".$PHP_SELF."?act=users&order=id'>ID</a>","<a href='".$PHP_SELF."?act=users&order=name'>Name</a>","<a href='".$PHP_SELF."?act=users&order=imperium'>Imperium</a>","<a href='".$PHP_SELF."?act=users&order=email'>E-mail</a>","<a href='".$PHP_SELF."?act=users&order=active'>Active</a>","<a href='".$PHP_SELF."?act=users&order=last_login'>Last Login</a>","<a href='".$PHP_SELF."?act=users&order=homeworld'>Homeworld</a>","<a href='".$PHP_SELF."?act=users&order=alliance'>Alliance</a>","<a href='".$PHP_SELF."?act=users&order=score'>Score</a>","<a href='".$PHP_SELF."?act=users&order=moz'>Mozilla</a>","<a href='".$PHP_SELF."?act=users&order=admin'>Admin</a>"),"","","","smallhead");
   while ($user=mysql_fetch_array($sth))
    {
         $user["last_login"]=substr($user["last_login"],6,2).".".substr($user["last_login"],4,2).".".substr($user["last_login"],0,4)." ".substr($user["last_login"],8,2).":".substr($user["last_login"],10,2);
         table_text(array("<a href='".$PHP_SELF."?act=user_mod&id=".$user["id"]."'>modify</a>",$user["id"],"<a href=\"".$PHP_SELF."?act=messenges&uname=".$user["name"]."\">".$user["name"]."</a>",$user["imperium"],"<a href='mailto:".$user["email"]."'>".$user["email"]."</a>",$user["active"],$user["last_login"],$user["homeworld"],$user["alliance"],$user["score"],$user["moz"],$user["admin"]),"","","","text");
        }
break;
case 3:
   table_head_text(array("Admin Area - Users - Level 3"),"12");
   table_text(array("<a href='".$PHP_SELF."?act=users&order=id'>ID</a>","<a href='".$PHP_SELF."?act=users&order=name'>Name</a>","<a href='".$PHP_SELF."?act=users&order=imperium'>Imperium</a>","<a href='".$PHP_SELF."?act=users&order=email'>E-mail</a>","<a href='".$PHP_SELF."?act=users&order=active'>Active</a>","<a href='".$PHP_SELF."?act=users&order=last_login'>Last Login</a>","<a href='".$PHP_SELF."?act=users&order=homeworld'>Homeworld</a>","<a href='".$PHP_SELF."?act=users&order=alliance'>Alliance</a>","<a href='".$PHP_SELF."?act=users&order=score'>Score</a>","<a href='".$PHP_SELF."?act=users&order=moz'>Mozilla</a>","<a href='".$PHP_SELF."?act=users&order=admin'>Admin</a>"),"","","","smallhead");
   while ($user=mysql_fetch_array($sth))
    {
         $user["last_login"]=substr($user["last_login"],6,2).".".substr($user["last_login"],4,2).".".substr($user["last_login"],0,4)." ".substr($user["last_login"],8,2).":".substr($user["last_login"],10,2);
         table_text(array($user["id"],"<a href=\"".$PHP_SELF."?act=messenges&uname=".$user["name"]."\">".$user["name"]."</a>",$user["imperium"],"<a href='mailto:".$user["email"]."'>".$user["email"]."</a>",$user["active"],$user["last_login"],$user["homeworld"],$user["alliance"],$user["score"],$user["moz"],$user["admin"]),"","","","text");
        }
break;
}

}

function user_mod()
{
  global $PHP_SELF;
  global $uid;
  global $id;

  $sth=mysql_query("select admin,name from users where id=$uid");

  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }

  $admin=mysql_fetch_array($sth);

  if (($admin["admin"]=="") or ($admin["admin"]=="3"))
  {
  show_message("Forbidden");
  return 0;
  }
  else
  {
    $sth=mysql_query("select * from users where id=$id");

    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }

    $user=mysql_fetch_array($sth);

    echo("<br><br>\n");
    echo("<a href='".$PHP_SELF."?act=users&order=id'>back</a>\n");
    echo("<br><br>\n");

    table_start("center","500");
    table_head_text(array("Editing User ".$user["name"]),"3");
    table_text(array("&nbsp;"),"","","3","text");
    if ($admin["admin"]==1)
    {
      table_text(array("variable","old","new"),"","","","head");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=name&tid=".$user["id"]."\" method=post>");
      table_text(array("Name",$user["name"],"<input type=\"Text\" name=\"new\" value=\"".$user["name"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=password&tid=".$user["id"]."\" method=post>");
      table_text(array("Password",$user["password"],"<input type=\"Text\" name=\"new\" value=\"".$user["password"]."\"><input type=\"Submit\" name=\"f2\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=imperium&tid=".$user["id"]."\" method=post>");
      table_text(array("Imperium",$user["imperium"],"<input type=\"Text\" name=\"new\" value=\"".$user["imperium"]."\"><input type=\"Submit\" name=\"f3\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=email&tid=".$user["id"]."\" method=post>");
      table_text(array("E-mail",$user["email"],"<input type=\"Text\" name=\"new\" value=\"".$user["email"]."\"><input type=\"Submit\" name=\"f4\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=homeworld&tid=".$user["id"]."\" method=post>");
      table_text(array("Homeworld",$user["homeworld"],"<input type=\"Text\" name=\"new\" value=\"".$user["homeworld"]."\"><input type=\"Submit\" name=\"f5\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=alliance&tid=".$user["id"]."\" method=post>");
      table_text(array("Alliance",$user["alliance"],"<input type=\"Text\" name=\"new\" value=\"".$user["alliance"]."\"><input type=\"Submit\" name=\"f6\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=score&tid=".$user["id"]."\" method=post>");
      table_text(array("Score",$user["score"],"<input type=\"Text\" name=\"new\" value=\"".$user["score"]."\"><input type=\"Submit\" name=\"f7\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=admin&tid=".$user["id"]."\" method=post>");
      table_text(array("Admin Level",$user["admin"],"<input type=\"Text\" name=\"new\" value=\"".$user["admin"]."\"><input type=\"Submit\" name=\"f8\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=apw&tid=".$user["id"]."\" method=post>");
      table_text(array("Admin Password",$user["apw"],"<input type=\"Text\" name=\"new\" value=\"".$user["apw"]."\"><input type=\"Submit\" name=\"f9\" value=\"set\">"),"","","","text");
      echo("</table><br><center></form>\n");
      echo("<form action=\"".$PHP_SELF."?act=delete_user&tid=".$user["id"]."\" method=post>");
      echo("<input type=\"submit\" value=\"Delete User\">\n");
      echo("</form></center>\n");
      echo("<br>\n");
    }
    else
    {
      table_text(array("variable","old","new"),"","","","head");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=name&tid=".$user["id"]."\" method=post>");
      table_text(array("Name",$user["name"],"<input type=\"Text\" name=\"new\" value=\"".$user["name"]."\"><input type=\"Submit\" name=\"value\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=imperium&tid=".$user["id"]."\" method=post>");
      table_text(array("Imperium",$user["imperium"],"<input type=\"Text\" name=\"new\" value=\"".$user["imperium"]."\"><input type=\"Submit\" name=\"f3\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=email&tid=".$user["id"]."\" method=post>");
      table_text(array("E-mail",$user["email"],"<input type=\"Text\" name=\"new\" value=\"".$user["email"]."\"><input type=\"Submit\" name=\"f4\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=homeworld&tid=".$user["id"]."\" method=post>");
      table_text(array("Homeworld",$user["homeworld"],"<input type=\"Text\" name=\"new\" value=\"".$user["homeworld"]."\"><input type=\"Submit\" name=\"f5\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=alliance&tid=".$user["id"]."\" method=post>");
      table_text(array("Alliance",$user["alliance"],"<input type=\"Text\" name=\"new\" value=\"".$user["alliance"]."\"><input type=\"Submit\" name=\"f4\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=users&var=score&tid=".$user["id"]."\" method=post>");
      table_text(array("Score",$user["score"],"<input type=\"Text\" name=\"new\" value=\"".$user["score"]."\"><input type=\"Submit\" name=\"f4\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("</table><br><center></form>\n");
    }

    $sth=mysql_query("select * from ressources where uid=".$user["id"]."");
    if (!$sth)
     {
      show_message("Database Failure");
      return 0;
     }
    $ressources=mysql_fetch_array($sth);
    table_start("center","500");
    table_head_text(array("Resources"),"3");
    table_text(array("&nbsp;"),"","","3","head");
    echo("<form action=\"".$PHP_SELF."?act=edit&table=ressources&var=metal&tid=".$user["id"]."\" method=post>");
    table_text(array("Metal",$ressources["metal"],"<input type=\"Text\" name=\"new\" value=\"".$ressources["metal"]."\"><input type=\"Submit\" name=\"f10\" value=\"set\">"),"","","","text");
    echo("</form>\n");
    echo("<form action=\"".$PHP_SELF."?act=edit&table=ressources&var=energy&tid=".$user["id"]."\" method=post>");
    table_text(array("Energy",$ressources["energy"],"<input type=\"Text\" name=\"new\" value=\"".$ressources["energy"]."\"><input type=\"Submit\" name=\"f11\" value=\"set\">"),"","","","text");
    echo("</form>\n");
    echo("<form action=\"".$PHP_SELF."?act=edit&table=ressources&var=mopgas&tid=".$user["id"]."\" method=post>");
    table_text(array("Mopgas",$ressources["mopgas"],"<input type=\"Text\" name=\"new\" value=\"".$ressources["mopgas"]."\"><input type=\"Submit\" name=\"f12\" value=\"set\">"),"","","","text");
    echo("</form>\n");
    echo("<form action=\"".$PHP_SELF."?act=edit&table=ressources&var=erkunum&tid=".$user["id"]."\" method=post>");
    table_text(array("Erkunum",$ressources["erkunum"],"<input type=\"Text\" name=\"new\" value=\"".$ressources["erkunum"]."\"><input type=\"Submit\" name=\"f13\" value=\"set\">"),"","","","text");
    echo("</form>\n");
    echo("<form action=\"".$PHP_SELF."?act=edit&table=ressources&var=gortium&tid=".$user["id"]."\" method=post>");
    table_text(array("Gortium",$ressources["gortium"],"<input type=\"Text\" name=\"new\" value=\"".$ressources["gortium"]."\"><input type=\"Submit\" name=\"f14\" value=\"set\">"),"","","","text");
    echo("</form>\n");
    echo("<form action=\"".$PHP_SELF."?act=edit&table=ressources&var=susebloom&tid=".$user["id"]."\" method=post>");
    table_text(array("Susebloom",$ressources["susebloom"],"<input type=\"Text\" name=\"new\" value=\"".$ressources["susebloom"]."\"><input type=\"Submit\" name=\"f15\" value=\"set\">"),"","","","text");
    echo("</form>\n");
    echo("</table><br><center></form>\n");
  }
}

//______________________________________________________________________________

function edit()
{
global $table;
global $var;
global $new;
global $uid;
global $tid;

$sth=mysql_query("select admin,name from users where id=$uid");

if (!$sth)
{
show_message("Databse Failure");
return 0;
}

if (mysql_num_rows($sth)==0)
{
show_message("Forbidden");
return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]=="")
{
  show_message("Forbidden");
  return 0;
}
else
{
  switch ($table)
{
  case "users":
  if (($var=="password")&&($admin["admin"]!=1))
           {
              show_message("Forbidden u1");
              return 0;
           }
  if (($admin["admin"]!=1)&&($admin["admin"]!=2))
           {
              show_message("Forbidden u2");
              return 0;
           }
    $identifier = id;
    echo("<a href='".$PHP_SELF."?act=user_mod&id=".$tid."'>back</a>\n");
  break;
  case "production":
  if (($admin["admin"]!=1)&&($admin["admin"]!=2))
           {
              show_message("Forbidden");
              return 0;
           }
    $identifier = prod_id;
    $sth=mysql_query("select typ from production where prod_id = '$tid'");
    
    if (!$sth)
    {
      show_message("Database Failure - couldn't get Production Type");
      break;
    }
    
    $itsTyp = mysql_fetch_array($sth);
    
    if ($itsTyp["typ"]=="P" || $itsTyp["typ"]=='O')
    {
      echo("<a href='".$PHP_SELF."?act=building_edit&id=".$tid."'>back</a>\n");
    }

    if ($itsTyp["typ"]=="L" || $itsTyp["typ"]=='M' || $itsTyp["typ"]=='H')
    {
      echo("<a href='".$PHP_SELF."?act=ship_edit&id=".$tid."'>back</a>\n");
    }
  break;  
  case "shipvalues":
  if (($admin["admin"]!=1)&&($admin["admin"]!=2))
           {
              show_message("Forbidden");
              return 0;
           }
    $identifier = prod_id;
    echo("<a href='".$PHP_SELF."?act=ship_edit&id=".$tid."'>back</a>\n");
  break;  
  default:
   $identifier = uid;
  break;
}
  $sth=mysql_query("update $table set $var='$new' where $identifier=$tid");
            if (!$sth)
              {
                show_message("Warning: Database Failure while trying to set table ".$table.",".$var." to ".$new."");
                return 0;
              }
     show_message("[".$var."] in [".$table."] has been set to [".$new."]");
}
}

//______________________________________________________________________________

function delete_user()
{
global $uid;
global $PHP_SELF;
global $tid;

$sth=mysql_query("select admin,name from users where id=$uid");

if (!$sth)
{
show_message("Databse Failure");
return 0;
}

if (mysql_num_rows($sth)==0)
{
show_message("Forbidden");
return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]!=1)
{
show_message("Forbidden");
return 0;
}
else
{
$sth=mysql_query("select * from users where id=".$tid."");
if (!$sth)
{
show_message("Step 1 - Databse Failure");
return 0;
}
$victim=mysql_fetch_array($sth);

//******************* check auf alliance **************************************************************************************

if ($victim["alliance"]!="")
{
$sth=mysql_query("select * from alliance where id=".$victim["alliance"]."");
  if (!$sth)
   {
    show_message("Step A - Database Failure by retrieving Alliance from victim");
        return 0;
   }
$alliance=mysql_fetch_array($sth);

$sth=mysql_query("select id from users where alliance=".$victim["alliance"]."");

  if (!$sth)
   {
    show_message("Databse Failure");
        return 0;
   }

If (mysql_num_rows($sth)=="")
{
      $sth=mysql_query("Delete from alliance where id=".$victim["alliance"]."");

            if (!$sth)
                {
                  show_error("Database failure - deleting alliance!");
                  return 0;
                }

      $sth=mysql_query("delete from invitations where aid=".$alliance["id"]);

            if (!$sth)
                {
                  show_error("Database failure - deleting invitations!");
                  return 0;
                }

      $sth=mysql_query("delete from taxes where aid=".$alliance["id"]);

            if (!$sth)
                {                 
                  show_error("Database failure - deleting taxes!");
                  return 0;
                }

      $sth=mysql_query("delete from forums where aid=".$alliance["id"]);

            if (!$sth)
                {
                  show_error("Database failure - deleting forums!");
                  return 0;
                }

  show_message("Alliance has been deleted, because user was only member");
}
}
else
{
 $victim_alliance_members=mysql_fetch_array($sth);
//*******************
//
//einfügen, neuer leader wenn in der allianz nur noch ein member übrigbleibt
//
//*******************
 if ($alliance["leader"]==$victim["id"])
         {
          $sth=mysql_query("update alliance set leader=0 where id=".$victim["alliance"]."");
          if (!$sth)
           {
            show_message("Step A 1 -  Databse Failure - Failed to delete user as leader from alliance ".$alliance["id"]);
                return 0;
           }
           show_message("Victim was deleted as leader");
         }
 if ($alliance["devminister"]==$victim["id"])
         {
          $sth=mysql_query("update alliance set devminister=0 where id=".$victim["alliance"]."");
          if (!$sth)
           {
            show_message("Step A 1 -  Databse Failure - Failed to delete user as devminister from alliance ".$alliance["id"]);
                return 0;
           }
           show_message("Victim was deleted as devminister from alliance");
         }
 if ($alliance["milminister"]==$victim["id"])
         {
          $sth=mysql_query("update alliance set milminister=0 where id=".$victim["alliance"]."");
          if (!$sth)
           {
            show_message("Step A 1 -  Databse Failure - Failed to delete user as milminister from alliance ".$alliance["id"]);
                return 0;
           }
           show_message("Victim was deleted as milminister from alliance");
          $sth=mysql_query("update fleet set milminister=0 where milminister=".$victim["id"]."");
          if (!$sth)
           {
            show_message("Step A 1a -  Databse Failure - Failed to delete victim as milminister from fleets");
                return 0;
           }
           show_message("Victim was deleted as milminister from fleets");
         }
 if ($alliance["forminister"]==$victim["id"])
         {
          $sth=mysql_query("update alliance set forminister=0 where id=".$victim["alliance"]."");
          if (!$sth)
           {
            show_message("Step A 1 -  Databse Failure - Failed to delete user as devminister from alliance ".$alliance["id"]);
                return 0;
           }
           show_message("Victim was deleted as forminister from alliance");
         }
}

//*************** ticker-nachrichten löschen
//**************
$sth=mysql_query("delete from ticker where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Ticker");
   return 0;
  }
show_message("Ticker has been deleted");

//*************** mails löschen
//**************
$sth=mysql_query("delete from mail where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Mails");
   return 0;
  }
show_message("mails have been deleted");

//*************** journal löschen
//**************
$sth=mysql_query("delete from journal where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Journal");
   return 0;
  }
show_message("journal has been deleted");

//*************** fleets und infantry transports löschen
//**************
$sth=mysql_query("select fid from fleet where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - selecting fleet");
   return 0;
  }

if(mysql_num_rows($sth)!="")
 {

        $fleet=mysql_fetch_array($sth);

        $sth=mysql_query("delete from inf_transports where fid=".$fleet["fid"]."");

         if (!$sth)
          {
           show_message("Database Failure - deleting infantry transports");
           return 0;
          }
        show_message("Infantry Transports have been deleted");

        $sth=mysql_query("delete from fleet where uid=".$victim["id"]."");

         if (!$sth)
          {
           show_message("Database Failure - Deleting fleets");
           return 0;
          }
        show_message("fleets have been deleted");
}
 else
        show_message("NO fleets to delete");


//*************** tradetransports löschen
//**************
$sth=mysql_query("delete from tradetransports where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Tradestransports");
   return 0;
  }
show_message("Tradetransports have been deleted");

//*************** tradetransports umkehren und tradestation, traderules löschen
//**************
$sth=mysql_query("select pid,sid from tradestations where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Selecting Tradestation");
   return 0;
  }

 if (mysql_num_rows($sth)!="")
  {
   $tradestation=mysql_fetch_array($sth);
   $sth=mysql_query("select id,uid from tradetransports where tid=".$tradestation["pid"]."");
                 if (!$sth)
                  {
                   show_message("Database Failure - Selecting incoming tradetransports");
                   return 0;
                  }
         if (mysql_num_rows($sth)!="")
          {
           while ($in_trades=mysql_fetch_array($sth))
            {
                 $sth1=mysql_query("select pid from tradestations where uid=".$in_trades["uid"]."");
                         if (!$sth1)
                          {
                           show_message("Databases Failure");
                           return 0;
                          }
                 $backstation=mysql_fetch_array($sth1);
                 $sth1=mysql_query("update tradetransports set tid=".$backstation["pid"]." where uid=".$in_trades["uid"]."");
                         if (!$sth1)
                          {
                           show_message("Databasesa Failure");
                           return 0;
                          }
                  show_message("Tradingfleet recalled");
                }
           $sth=mysql_query("delete from tradestations where uid=".$victim["id"]."");
                 if (!$sth)
                  {
                   show_message("Database Failure - deleting tradestation");
                   return 0;
                  }
           show_message("Tradingstation deleted");

           $sth=mysql_query("delete from traderules where sid=".$tradestation["sid"]."");
                 if (!$sth)
                  {
                   show_message("Database Failure - deleting tradestation");
                   return 0;
                  }
           show_message("Tradingstation deleted");
          }
   }

//*************** pirates löschen
//**************
$sth=mysql_query("delete from pirates where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Pirates");
   return 0;
  }
show_message("Pirates have been deleted");

//*************** researching löschen
//**************
$sth=mysql_query("delete from researching where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Researching");
   return 0;
  }
show_message("Researching has been deleted");

//*************** research löschen
//**************
$sth=mysql_query("delete from research where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Research");
   return 0;
  }
show_message("Research has been deleted");

//*************** covertops löschen
//**************
$sth=mysql_query("delete from covertops where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Covert Ops");
   return 0;
  }
show_message("Covert Ops has been deleted");

//*************** incoming covert ops löschen
//**************
$sth=mysql_query("delete from covertops where target=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Incoming Covert Ops");
   return 0;
  }
show_message("Incoming Covert Ops have been deleted");

//*************** infantry löschen
//**************
$sth=mysql_query("delete from infantery where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Infantry");
   return 0;
  }
show_message("Infantry have been deleted");

//*************** admirals löschen
//**************
$sth=mysql_query("delete from admirals where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting admirals");
   return 0;
  }
show_message("Admirals have been deleted");

//*************** invitations löschen
//**************
$sth=mysql_query("delete from invitations where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting invitations");
   return 0;
  }
show_message("Invitations have been deleted");


//*************** resource to tradingstation löschen
//**************
$sth=mysql_query("delete from res_to_trade where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting Resources to Tradingstation");
   return 0;
  }
show_message("Resources to Tradingstation have been deleted");

//*************** production löschen, planeten zurücksetzen
//**************
$sth=mysql_query("select id from planets where uid=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - selecting planets");
   return 0;
  }

while ($planets=mysql_fetch_array($sth))
 {
  $sth1=mysql_query("Delete from s_production where planet_id=".$planets["id"]."");
  if (!$sth1)
   {
    show_message("Databse Failure - deleting s_productions");
        return 0;
   }

  $sth1=mysql_query("Delete from p_production where planet_id=".$planets["id"]."");
  if (!$sth1)
   {
    show_message("Databse Failure - deleting p_productions");
        return 0;
   }

  $sth1=mysql_query("Delete from i_production where planet_id=".$planets["id"]."");
  if (!$sth1)
   {
    show_message("Databse Failure - deleting i_productions");
        return 0;
   }

  $sth1=mysql_query("Delete from o_production where planet_id=".$planets["id"]."");
  if (!$sth1)
   {
    show_message("Databse Failure - deleting o_productions");
        return 0;
   }

  $sth1=mysql_query("Delete from constructions where pid=".$planets["id"]."");
  if (!$sth1)
   {
    show_message("Databse Failure - deleting orbital)");
        return 0;
   }

  $sth1=mysql_query("Delete from jumpgates where pid=".$planets["id"]."");
  if (!$sth1)
   {
    show_message("Databse Failure - deleting jumpgates");
        return 0;
   }

  $sth1=mysql_query("update planets set population=0 where id=".$planets["id"]."");

  if (!$sth1)
   {
    show_message("Databse Failure - resetting population");
        return 0;
   }

  $sth1=mysql_query("update planets set name='' where id=".$planets["id"]."");

  if (!$sth1)
   {
    show_message("Databse Failure - resetting planet names");
        return 0;
   }

  $sth1=mysql_query("update planets set uid=0 where id=".$planets["id"]."");

  if (!$sth1)
   {
    show_message("Databse Failure - resetting planet uid");
        return 0;
   }
 }
show_message("Production, buildings and jumpagtes deleted + planets reset");

//*************** user löschen
//**************
$sth=mysql_query("delete from users where id=".$victim["id"]."");

 if (!$sth)
  {
   show_message("Database Failure - Deleting user");
   return 0;
  }
show_message("User has been deleted");

show_message("User was completly deleted");
/// ende
//*************** nachricht and alle senden
//**************
$sth=mysql_query("select id from users where active=1;");

 if (!$sth)
  {
   show_message("Database Failure - selecting user");
   return 0;
  }
while ($users=mysql_fetch_array($sth))
 {
  $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$users["id"]."','w','Alien empire ".$victim["imperium"]." under leadership of ".$victim["name"]." committed mass suicide.','".date("YmdHis")."')");
         if (!$sth1)
          {
           show_message("Database Failure - inserting ticker message");
           return 0;
          }
 }
show_message("Other users were notified");
echo("<br><br>\n");
echo("<a href='".$PHP_SELF."?act=users&order=id'>back</a>\n");
echo("<br><br>\n");
}
}

function messenges()
{
global $uid;
global $PHP_SELF;
global $uname;

$sth=mysql_query("select admin,name from users where id=$uid");

if (!$sth)
{
  show_message("Databse Failure");
  return 0;
}

if (mysql_num_rows($sth)==0)
{
  show_message("Forbidden");
  return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]=="")
{
  show_message("Forbidden");
  return 0;
}
else
{
  echo("<a href=\"".$PHP_SELF."?act=menu\">back</a>\n");
  table_start("center","500");
  table_head_text(array("Send ticker message"));
  table_text(array("&nbsp;"),"","","","head");
  echo("<form method=post action=\"".$PHP_SELF."?act=send_ticker\">\n");
  table_text(array("<input type='radio' name='target' value='global'>Send to all Users"),"","","","text");
  table_text(array("<input type='radio' name='target' value='specific' checked><input type='text' size='20' maxlenght='40' name='tname' value='".$uname."'>Send to specific Users"),"","","","text");
  table_text(array("Text<br><input type='text' maxlength='255' size='60' name='text'>"),"","","","text");
  table_text(array("<input type='radio' name='type' value='' checked>none<br><input type='radio' name='type' value='w'>important<br><input type='radio' name='type' value='m'>mails<br><input type='radio' name='type' value='r'>research<br><input type='radio' name='type' value='s'>covert operations<br><input type='radio' name='type' value='a'>military<br>"),"","","","text");
  table_text(array("<input type='submit' name='submit_ticker' value='send'>"),"","","","head");
  echo("</form>\n");
  table_end();
  echo("<br><br>\n");
  table_start("center","500");
  table_head_text(array("Send Mails"));
  table_text(array("&nbsp"),"","","","head");
  echo("<form method=post action='".$PHP_SELF."?act=send_mails'>\n");
  table_text(array("<input type='radio' name='mtarget' value='global'>Send to all users"),"","","","text");
  table_text(array("<input type='radio' name='mtarget' value='specific' checked><input type='text' size='20' maxlenght='40' name='mname'  value='".$uname."'>Send to specific Users"),"","","","text");
  table_text(array("Subject<br><input type='text' maxlength='255' size='60' name='subject'>"),"","","","text");
  table_text(array("Text<br><textarea type='formfield' cols='55' rows='10' name='mtext'></textarea>"),"","","","text");
  table_text(array("<input type='submit' name='submit_mail' value='send'>"),"","","","head");
  echo("</form>\n");
  table_end();
}

}

function send_ticker()
{
  global $text;
  global $type;
  global $target;
  global $tname;
  global $uid;
  
  $sth=mysql_query("select admin,name from users where id=$uid");
  
  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }
  
  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }
  
  $admin=mysql_fetch_array($sth);
  
  if ($admin["admin"]=="")
  {
    show_message("Forbidden");
    return 0;
  }
  else
  {
  if ($target=='global')
  {
    $sth=mysql_query("select id from users where active=1");
    
    if (!$sth)
    {
      show_message("Databse Failure");
      return 0;
    }
    
    while ($users=mysql_fetch_array($sth))
    {
      $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$users["id"]."','".$type."','".$text."','".date("YmdHis")."')");
      
      if (!$sth)
      {
        show_message("Databse Failure");
        return 0;
      }
    }
    show_message("All active users have received your ticker message");
  }
  else
  {
    $sth=mysql_query("select id from users where name='$tname'");
    
    If (!$sth)
    {
      show_message("database failure");
      return 0;
    }
    
    $user=mysql_fetch_array($sth);
    
    $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$user["id"]."','".$type."','".$text."','".date("ymdhis")."')");

    If (!$sth1)
    {
      show_message("databases failure");
      return 0;
    }
    
    show_message("User has received a ticker message");
  }
    
  }

}

function send_mails()
{
  global $uid;
  global $mname;
  global $mtarget;
  global $mtext;
  global $subject;
  
  $sth=mysql_query("select admin,name from users where id=$uid");
  
  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }
  
  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }
  
  $admin=mysql_fetch_array($sth);
  
  if ($admin["admin"]=="")
  {
    show_message("Forbidden");
    return 0;
  }
  else
  {
  if ($mtarget=='global')
  {
    $sth=mysql_query("select id from users where active=1");
    
    if (!$sth)
    {
      show_message("Databse Failure");
      return 0;
    }
    
    while ($users=mysql_fetch_array($sth))
    {
      $sth1=mysql_query("insert into mail (uid,fuid,text,subject,time) values ('".$users["id"]."','0','".$mtext."','".$subject."','".date("ymdhis")."')");
      
      if (!$sth1)
      {
        show_message("Database Failure");
        return 0;
      }

      $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$users["id"]."','m','<a href=\"mail.php\">You have received a mail from an admin</a>','".date("ymdhis")."')");
      
      if (!$sth1)
      {
        show_message("Database Failure");
        return 0;
      }
    }
    show_message("All active users have received your mail");
  }
  else
  {
    $sth=mysql_query("select id from users where name='$mname'");
    
    if (!$sth)
    {
      show_message("Databse Failure");
      return 0;
    }
    
    $user=mysql_fetch_array($sth);
    
    $sth=mysql_query("insert into mail (uid,fuid,text,subject,time) values ('".$user["id"]."','0','".$mtext."','".$subject."','".date("ymdhis")."')");
      
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
      
    $sth=mysql_query("insert into ticker (uid,type,text,time) values ('".$user["id"]."','m','<a href=\"mail.php\">You have received a mail from an admin</a>','".date("ymdhis")."')");

    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
    show_message("User has received your mail");
  }
}
}

function show_ships()
{
  global $uid;
  global $order;
  global $PHP_SELF;

  
  $sth=mysql_query("select admin,name from users where id=$uid");
  
  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }
  
  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }
  
  $admin=mysql_fetch_array($sth);
  
  if ($admin["admin"]=="")
  {
    show_message("Forbidden");
    return 0;
  }
  else
  {
    $sth=mysql_query("select * from production where typ='L' or typ='M' or typ='H' order by '$order'");
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
    echo("<a href=\"".$PHP_SELF."?act=menu\">back</a>");
    table_start();
    table_head_text(array("Ships and their values"),"15");
    table_text(array("&nbsp;"),"","","15","text");
    table_text(array("&nbsp;",
                           "<a href=\"".$PHP_SELF."?act=ships&order=name\">name</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=prod_id\">id</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=typ\">type</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=com_time\">time</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=tech\">tech</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=p_depend\">depend</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=special\">special</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=metal\">metal</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=energy\">energy</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=mopgas\">mopgas</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=erkunum\">erkunum</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=gortium\">gortium</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=susebloom\">susebloom</a>",
                           "<a href=\"".$PHP_SELF."?act=ships&order=description\">description</a>"),"","","","smallhead");
   while ($ships=mysql_fetch_array($sth))
   {
     if ($ships["p_depend"])
     {
      $sth1=mysql_query("select name from production where prod_id=".$ships["p_depend"]." ");
      
      if (!$sth1)
      {
        show_message("Databse Failure");
        return 0;
      }     
      $pdepend = mysql_fetch_array($sth1);
     }
     else
     {
      $pdepend["name"]="none";
     }
    
     table_text(array("<a href=\"".$PHP_SELF."?act=ship_edit&id=".$ships["prod_id"]."\">edit</a>",
                            $ships["name"],
                            $ships["prod_id"],
                            $ships["typ"],
                            $ships["com_time"]." h",
                            $ships["tech"],
                            $pdepend["name"]."(".$ships["p_depend"].")",
                            $ships["special"],
                            $ships["metal"],
                            $ships["energy"],
                            $ships["mopgas"],
                            $ships["erkunum"],
                            $ships["gortium"],
                            $ships["susebloom"],
                            $ships["description"]),"","","","text");
                            
   }
   table_text(array("<a href=\"".$PHP_SELF."?act=ship_edit&id=new\">add a ship</a>"),"","","15","smallhead");
   table_end();
  }
}

function ship_edit()
{
  global $uid;
  global $id;
  global $PHP_SELF;
  
$sth=mysql_query("select admin,name from users where id=$uid");

if (!$sth)
{
show_message("Databse Failure");
return 0;
}

if (mysql_num_rows($sth)==0)
{
show_message("Forbidden");
return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]=="")
{
  show_message("Forbidden");
  return 0;
}
else
{
  if ($id=='new')
  {
    echo("<a href=\"".$PHP_SELF."?act=ships&order=name\">back</a>");
    $sth=mysql_query("insert into production (typ,tech,name,description) values ('L','999','new','no description')");
    if (!$sth)
    {
      show_message("Databse Failure : creating new ship step 1");
      return 0;
    }
    
    $sth=mysql_query("select prod_id from production where tech=999 and name='new' and description='no description' and typ='L'");
    if (!$sth)
    {
      show_message("Databse Failure : creating new ship step 2");
      return 0;
    }
    
    $newid = mysql_fetch_array($sth);
    
    $sth=mysql_query("insert into shipvalues (prod_id,special) values ('".$newid["prod_id"]."','NULL')");
    
    if (!$sth)
    {
      show_message("Databse Failure : creating new ship step 3");
      return 0;
    }
    show_message("Empty Shipslot created, plz edit at least Description,tech or name before creaating a new ship or  ERRORS may accure!");
  }
  else
  {
    $sth=mysql_query("select * from production where prod_id='$id'");
    if (!$sth)
    {
      show_message("Databse Failure");
      return 0;
    }
    
    $ship=mysql_fetch_array($sth);
    
    $sth=mysql_query("select name,t_id from tech");
    if (!$sth)
    {
      show_message("Databse Failuret");
      return 0;
    }
    
    $sth1=mysql_query("select name, prod_id from production where not (prod_id='$id')");
    
    if (!$sth1)
    {
      show_message("Databse Failurep");
      return 0;
    }
    
    echo("<a href=\"".$PHP_SELF."?act=ships&order=name\">back</a>");
    table_start("center","500");
    table_head_text(array("Editing ship ".$ship["name"]),"3");
    table_text(array("&nbsp;"),"","","3","text");
      table_text(array("variable","old","new"),"","","","head");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=name&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Name",$ship["name"],"<input type=\"Text\" name=\"new\" value=\"".$ship["name"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=prod_id&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Id",$ship["prod_id"],"<input type=\"Text\" name=\"new\" value=\"".$ship["prod_id"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=typ&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Type",$ship["typ"],"<input type=\"Text\" name=\"new\" value=\"".$ship["typ"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=com_time&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Time",$ship["com_time"],"<input type=\"Text\" name=\"new\" value=\"".$ship["com_time"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=tech&tid=".$ship["prod_id"]."\" method=post>");
      table_text_open();
      table_text_design("Tech","","","text");
      table_text_design($ship["tech"],"","","text");
      echo("<td><select name=\"new\">");
      while ($techs = mysql_fetch_array($sth))
      {
        if ($techs["t_id"]==$ship["tech"])
          echo("<option value=\"".$techs[t_id]."\" selected>".$techs["name"]."\n");
        else
          echo("<option value=\"".$techs[t_id]."\">".$techs["name"]."\n");
      }
      echo("</select><input type=\"Submit\" name=\"f1\" value=\"set\">\n</td>\n</form>\n");
      table_text_close();
      
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=p_depend&tid=".$ship["prod_id"]."\" method=post>");
      table_text_open();
      table_text_design("Production_depend","","","text");
      table_text_design($ship["p_depend"],"","","text");
      echo("<td><select name=\"new\">");
      while ($productions = mysql_fetch_array($sth1))
      {
        if ($productions["prod_id"]==$ship["p_depend"])
          echo("<option value=\"".$productions[prod_id]."\" selected>".$productions["name"]."\n");
        else
          echo("<option value=\"".$productions[prod_id]."\">".$productions["name"]."\n");
      }
      echo("</select><input type=\"Submit\" name=\"f1\" value=\"set\">\n</td>\n</form>\n");
      table_text_close();     
      
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=special&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Special",$ship["special"],"<input type=\"Text\" name=\"new\" value=\"".$ship["special"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=metal&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Metal",$ship["metal"],"<input type=\"Text\" name=\"new\" value=\"".$ship["metal"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=energy&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Energy",$ship["energy"],"<input type=\"Text\" name=\"new\" value=\"".$ship["energy"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=mopgas&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Mopgas",$ship["mopgas"],"<input type=\"Text\" name=\"new\" value=\"".$ship["mopgas"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=erkunum&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Erkunum",$ship["erkunum"],"<input type=\"Text\" name=\"new\" value=\"".$ship["erkunum"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=gortium&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Gortium",$ship["gortium"],"<input type=\"Text\" name=\"new\" value=\"".$ship["gortium"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=susebloom&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Susebloom",$ship["susebloom"],"<input type=\"Text\" name=\"new\" value=\"".$ship["susebloom"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=description&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Description",$ship["description"],"<input type=\"Text\" name=\"new\" value=\"".$ship["description"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");      
      echo("</table><br>\n");
      echo("<br>\n");
      
    $sth = mysql_query("select * from shipvalues where prod_id=$id");
    
    if (!$sth)
    {
      show_message("Databasse Failuer");
      return 0;
    }
    
    $its_values = mysql_fetch_array($sth);
    
    table_start("center","500");
    table_head_text(array("Editing values of ".$ship["name"]),"3");
    table_text(array("&nbsp;"),"","","3","text");
      table_text(array("variable","old","new"),"","","","head");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=initiative&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Initiative",$its_values["initiative"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["initiative"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=agility&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Agility",$its_values["agility"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["agility"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=warpreload&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Warp Reload",$its_values["warpreload"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["warpreload"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=hull&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Hull",$its_values["hull"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["hull"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=tonnage&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Tonnage",$its_values["tonnage"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["tonnage"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=weaponpower&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Weaponpower",$its_values["weaponpower"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["weaponpower"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=shield&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Shield",$its_values["shield"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["shield"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=ecm&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("ECM",$its_values["ecm"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["ecm"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=target1&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Primary Target",$its_values["target1"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["target1"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=sensor&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Sensors",$its_values["sensor"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["sensor"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=weaponskill&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Weaponskill",$its_values["weaponskill"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["weaponskill"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=shipvalues&var=special&tid=".$ship["prod_id"]."\" method=post>");
      table_text(array("Special",$its_values["special"],"<input type=\"Text\" name=\"new\" value=\"".$its_values["special"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=del_ship&id=".$ship["prod_id"]."\" method=post>");
      echo("<input type=\"Submit\" name=\"f1\" value=\"Delete Ship - all active ships will be deleted too\" disabled>");
      echo("</form>\n");
      table_end();      
  }
}
}

function del_ship()
{
  global $PHP_SELF;
  global $uid;
  global $id;
  
  $sth=mysql_query("select admin,name from users where id=$uid");

  if (!$sth)
  {
    show_message("Databse Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("Forbidden");
    return 0;
  }

  $admin=mysql_fetch_array($sth);

  if ($admin["admin"]!=1&&$admin["admin"]!=2)
  {
    show_message("Forbidden");
    return 0;
  }
  else
  {
    $sth=mysql_query("delete from s_production where prod_id='$id'");
    if (!$sth)
    {
      show_message("Database Failure : Deleting Ship Step 1 - Deleting current prododuction");
      return 0;
    }
    show_message("Deleting current constructions : succes");

    $sth=mysql_query("delete from fleets where prod_id='$id'");
    if (!$sth)
    {
      show_message("Database Failure : Deleting Ship Step 2 - Deleting active ships");
      return 0;
    }
    show_message("Deleting active ships : succes");

    $sth=mysql_query("delete from battle where prod_id='$id'");
    if (!$sth)
    {
      show_message("Database Failure : Deleting Ship Step 3 - Deleting fighting ships");
      return 0;
    }
    show_message("Deleting fighting ships : succes");


    $sth=mysql_query("delete from shipvalues where prod_id='$id'");
    if (!$sth)
    {
      show_message("Database Failure : Deleting Ship Step 4 - Deleting ship values");
      return 0;
    }
    show_message("Deleting ship values : succes");

    $sth=mysql_query("delete from production where prod_id='$id'");
    if (!$sth)
    {
      show_message("Database Failure : Deleting Ship Step 5 - Deleting ship basic values");
      return 0;
    }
    show_message("Deleting ship basic values : succes");

    
  }
  
}

function show_buildings()
{
    global $uid;
    global $order;
    global $PHP_SELF;
  
    
    $sth=mysql_query("select admin,name from users where id=$uid");
    
    if (!$sth)
    {
      show_message("Databse Failure");
      return 0;
    }
    
    if (mysql_num_rows($sth)==0)
    {
      show_message("Forbidden");
      return 0;
    }
    
    $admin=mysql_fetch_array($sth);
    
    if ($admin["admin"]=="")
    {
      show_message("Forbidden");
      return 0;
    }
    else
    {
      $sth = mysql_query("select * from production where typ='P' or typ='O' order by '$order'");
      
      if (!$sth)
      {
        show_message("Database Failure - Getting Buildings");
        return 0;
      }

      echo("<a href=\"".$PHP_SELF."?act=menu\">back</a>");
      table_start();
      table_head_text(array("Buildings"),"15");
      table_text(array("&nbsp;"),"","","15","text");
      table_text(array("&nbsp;",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=name\">name</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=prod_id\">id</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=typ\">type</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=com_time\">time</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=tech\">tech</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=p_depend\">depend</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=special\">special</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=metal\">metal</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=energy\">energy</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=mopgas\">mopgas</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=erkunum\">erkunum</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=gortium\">gortium</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=susebloom\">susebloom</a>",
                           "<a href=\"".$PHP_SELF."?act=buildings&order=description\">description</a>"),"","","","smallhead");
      
      
      while ($buildings = mysql_fetch_array($sth))
      {
        if ($buildings["p_depend"])
        {
          $sth1=mysql_query("select name from production where prod_id=".$buildings["p_depend"]." ");
        
          if (!$sth1)
          {
            show_message("Databse Failure  - buildings - production depend selection");
            return 0;
          }     
          $pdepend = mysql_fetch_array($sth1);
        }
        else
        {
          $pdepend["name"]="none";
        }

        if ($buildings["tech"])
        {
          $sth1=mysql_query("select name from tech where t_id=".$buildings["tech"]." ");
        
          if (!$sth1)
          {
            show_message("Databse Failure - buildings - tech selection");
            return 0;
          }     
          $tdepend = mysql_fetch_array($sth1);
        }
        else
        {
          $tdepend["name"]="none";
        }
        
        table_text(array("<a href=\"".$PHP_SELF."?act=building_edit&id=".$buildings["prod_id"]."\">edit</a>",
                            $buildings["name"],
                            $buildings["prod_id"],
                            $buildings["typ"],
                            $buildings["com_time"]." h",
                            $tdepend["name"]."(".$buildings["tech"].")",
                            $pdepend["name"]."(".$buildings["p_depend"].")",
                            $buildings["special"],
                            $buildings["metal"],
                            $buildings["energy"],
                            $buildings["mopgas"],
                            $buildings["erkunum"],
                            $buildings["gortium"],
                            $buildings["susebloom"],
                            $buildings["description"]),"","","","text");
                            
        }
        table_text(array("<a href=\"".$PHP_SELF."?act=building_edit&id=new\">add a building</a>"),"","","15","smallhead");
        table_end();
        
      }
}

function building_edit()
{
  global $uid;
  global $id;
  global $PHP_SELF;
  
$sth=mysql_query("select admin,name from users where id=$uid");

if (!$sth)
{
show_message("Databse Failure");
return 0;
}

if (mysql_num_rows($sth)==0)
{
show_message("Forbidden");
return 0;
}

$admin=mysql_fetch_array($sth);

if ($admin["admin"]=="")
{
  show_message("Forbidden");
  return 0;
}
else
{
  if ($id=='new')
  {
    echo("<a href=\"".$PHP_SELF."?act=buildings&order=name\">back</a>");
    $sth=mysql_query("insert into production (typ,tech,name,description) values ('P','999','new','no description')");
    if (!$sth)
    {
      show_message("Databse Failure : creating new building step 1");
      return 0;
    }
    
/*    $sth=mysql_query("select prod_id from production where tech=999 and name='new' and description='no description' and typ='P'");
    if (!$sth)
    {
      show_message("Databse Failure : creating new building step 2");
      return 0;
    }
    
    $newid = mysql_fetch_array($sth);
    
    $sth=mysql_query("insert into shipvalues (prod_id,special) values ('".$newid["prod_id"]."','NULL')");
    
    if (!$sth)
    {
      show_message("Databse Failure : creating new ship step 3");
      return 0;
    }
  */
    show_message("Empty Buildingslot created, plz edit at least Description,tech or name before creaating a new ship or  ERRORS may accure!");
  }
  else
  {
    $sth=mysql_query("select * from production where prod_id='$id'");
    if (!$sth)
    {
      show_message("Databse Failure");
      return 0;
    }
    
    $building=mysql_fetch_array($sth);
    
    $sth=mysql_query("select name,t_id from tech");
    if (!$sth)
    {
      show_message("Databse Failuret");
      return 0;
    }
    
    $sth1=mysql_query("select name, prod_id from production where not (prod_id='$id')");
    
    if (!$sth1)
    {
      show_message("Databse Failurep");
      return 0;
    }
    
    echo("<a href=\"".$PHP_SELF."?act=buildings&order=name\">back</a>");
    table_start("center","500");
    table_head_text(array("Editing building ".$building["name"]),"3");
    table_text(array("&nbsp;"),"","","3","text");
      table_text(array("variable","old","new"),"","","","head");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=name&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Name",$building["name"],"<input type=\"Text\" name=\"new\" value=\"".$building["name"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=prod_id&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Id",$building["prod_id"],"<input type=\"Text\" name=\"new\" value=\"".$building["prod_id"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=typ&tid=".$building["prod_id"]."\" method=post>");     
      table_text_open();
      table_text_design("Type","","","","text");
      table_text_design($building["typ"],"","","","text");
      table_text_design("<select name=\"new\"> \n <option value=\"P\" selected>P \n <option value=\"O\">O \n </select><input type=\"Submit\" name=\"f1\" value=\"set\">\n</form>\n","","","","text");
      table_text_close();     
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=com_time&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Time",$building["com_time"],"<input type=\"Text\" name=\"new\" value=\"".$building["com_time"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=tech&tid=".$building["prod_id"]."\" method=post>");
      table_text_open();
      table_text_design("Tech","","","text");
      table_text_design($building["tech"],"","","text");
      echo("<td><select name=\"new\">");
      while ($techs = mysql_fetch_array($sth))
      {
        if ($techs["t_id"]==$building["tech"])
          echo("<option value=\"".$techs[t_id]."\" selected>".$techs["name"]."\n");
        else
          echo("<option value=\"".$techs[t_id]."\">".$techs["name"]."\n");
      }
      echo("</select><input type=\"Submit\" name=\"f1\" value=\"set\">\n</td>\n</form>\n");
      table_text_close();
      
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=p_depend&tid=".$building["prod_id"]."\" method=post>");
      table_text_open();
      table_text_design("Production_depend","","","text");
      table_text_design($building["p_depend"],"","","text");
      echo("<td><select name=\"new\">");
      while ($productions = mysql_fetch_array($sth1))
      {
        if ($productions["prod_id"]==$building["p_depend"])
          echo("<option value=\"".$productions[prod_id]."\" selected>".$productions["name"]."\n");
        else
          echo("<option value=\"".$productions[prod_id]."\">".$productions["name"]."\n");
      }
      echo("</select><input type=\"Submit\" name=\"f1\" value=\"set\">\n</td>\n</form>\n");
      table_text_close();     
      
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=special&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Special",$building["special"],"<input type=\"Text\" name=\"new\" value=\"".$building["special"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=metal&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Metal",$building["metal"],"<input type=\"Text\" name=\"new\" value=\"".$building["metal"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=energy&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Energy",$building["energy"],"<input type=\"Text\" name=\"new\" value=\"".$building["energy"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=mopgas&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Mopgas",$building["mopgas"],"<input type=\"Text\" name=\"new\" value=\"".$building["mopgas"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=erkunum&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Erkunum",$building["erkunum"],"<input type=\"Text\" name=\"new\" value=\"".$building["erkunum"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=gortium&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Gortium",$building["gortium"],"<input type=\"Text\" name=\"new\" value=\"".$building["gortium"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=susebloom&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Susebloom",$building["susebloom"],"<input type=\"Text\" name=\"new\" value=\"".$building["susebloom"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");
      echo("<form action=\"".$PHP_SELF."?act=edit&table=production&var=description&tid=".$building["prod_id"]."\" method=post>");
      table_text(array("Description",$building["description"],"<input type=\"Text\" name=\"new\" value=\"".$building["description"]."\"><input type=\"Submit\" name=\"f1\" value=\"set\">"),"","","","text");
      echo("</form>\n");      
      echo("<form action=\"".$PHP_SELF."?act=del_building&id=".$building["prod_id"]."\" method=post>");
      echo("<input type=\"Submit\" name=\"f1\" value=\"Delete building - all active buildings of this type will be deleted too\" disabled>");
      echo("</form>\n");
      table_end();      
  }
}
}


      


switch ($act)
{
case "enter":
gate();
break;
case "users":
list_users();
break;
case "user_mod":
user_mod();
break;
case "edit":
edit();
break;
case "delete_user":
delete_user();
break;
case "messenges":
messenges();
break;
case "send_ticker":
send_ticker();
messenges();
break;
case "send_mails":
send_mails();
messenges();
break;
case "menu":
show_menu();
break;
case "ships":
show_ships();
break;
case "ship_edit":
ship_edit();
break;
case "del_ship":
del_ship();
break;
case "buildings":
show_buildings();
break;
case "building_edit":
building_edit();
break;
case "del_building":
del_building();
break;
default:
admin_secure();
break;
}
// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
