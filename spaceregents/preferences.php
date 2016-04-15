<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return 0;

// Bis hier immer so machen:)

include "../spaceregentsinc/class_map_info.inc.php";

function show_preferences()
{
  global $uid;
  global $skin;
  global $PHP_SELF;

  $sth=mysql_query("select * from skins");

  while ($skins=mysql_fetch_array($sth))
    {
      $options[$skins["name"]]=$skins["id"];
    }
 
  $sth=mysql_query("select admin from users where id=$uid");
  
  if (!$sth)
  {
    show_error("Database failuer!");
    return 0;
  }
  
  $admin=mysql_fetch_array($sth);
  
  if ($admin["admin"]!="")
   show_message("<a href='adminarea.php'>Enter Admin Area</a>");

  $map_info=new map_info($uid);

  if ($map_info->has_map_anims()==1)
    $checked="checked";

  echo("<form method=POST action=\"".$PHP_SELF."\">");
  table_start("center","400");
  table_head_text(array("Appearence"),"2");
  table_text(array("&nbsp;"),"","","2","head");
  table_form_select("Skin","skin_new",$options,$skin,"head","text");
  table_form_submit("Change","change_skin","","text");
  table_end();
  echo("</form>\n");
  
  
  //runelord: map_sizes
  $sth = mysql_query("select map_size from options where uid=".$uid);
  
  if ((!$sth) || (!mysql_num_rows($sth)))
  {
    show_error("oops, DB Failure");
    return 0;
  }
  
  list($current_map_size) = mysql_fetch_row($sth);
  
  $map_sizes_output = "<select name=\"map_size\" size=\"1\">";
  $sth = mysql_query("SELECT * FROM map_sizes ORDER BY width ASC");
  
  if ((!$sth) || (!mysql_num_rows($sth)))
  {
    show_error("Database Failureeeeerrerererererere");
    return 0;
  }
  
  while ($map_sizes = mysql_fetch_array($sth))
  {
    if ($current_map_size == $map_sizes["id"])
      $map_sizes_output .= "<option selected value=\"".$map_sizes["id"]."\">".$map_sizes["width"]." : ".$map_sizes["height"]."</option>";
    else
      $map_sizes_output .= "<option value=\"".$map_sizes["id"]."\">".$map_sizes["width"]." : ".$map_sizes["height"]."</option>";      
  }
  
  $map_sizes_output .= "</select>";
  
  
  echo("<form method=POST action=\"".$PHP_SELF."\">");
  table_start("center","400");
  table_head_text(array("Map Settings"),"2");
  table_text(array("&nbsp;"),"","","2","head");
  table_text(array("Map Size"),"","","2","head");
  table_text(array($map_sizes_output),"","","2","text");
  table_form_submit("Change","change_map_size","","text");
  echo("</form>\n");
  echo("<form method=POST action=\"".$PHP_SELF."\">");
  table_text(array("&nbsp;"),"","","2","head");
  table_text(array("Animations (KSVG needs disabled animations)","<input type=\"checkbox\" name=\"animations\" value=\"1\" $checked>"),"","","","head");
  table_form_submit("Change","change_anims","","text");
  table_end();
  echo("</form>\n");
 
  table_start("center","400");
  echo("<form method=POST action=\"".$PHP_SELF."\">");
  table_text(array("Change Password","&nbsp;"),"","","","head");
  table_text_open();
  table_text_design("Old Password","300","left","","text");
  table_text_design("<input type=\"password\" align=\"right\" name=\"old\">","100","right","","text");
  table_text_close();
  table_text_open();
  table_text_design("New Password","300","left","","text");
  table_text_design("<input type=\"password\" align=\"right\" name=\"new1\">","100","right","","text");
  table_text_close();
  table_text_open();
  table_text_design("Re-type new Password","300","left","","text");
  table_text_design("<input type=\"password\" align=\"right\" name=\"new2\">","100","right","","text");
  table_text_close();


    table_form_submit("Set","change_pw","","text");

  
  table_end();
  echo("</form>"); 
}
//---------------------------------------------------------------------------------------------------------------------------



function change_skin()
{
  global $skin_new;
  global $uid;
  
  $sth=mysql_query("select id from skins where id=$skin_new");
  
  if (mysql_num_rows($sth)==0)
    {
      show_error("Couldn't select skin!");
      return 0;
    }

  $sth=mysql_query("update users set skin=$skin_new where id='$uid'");
  
  if (!$sth)
    {
      show_error("Database failure!");
      return 0;
    }
}
//---------------------------------------------------------------------------------------------------------------------------



function change_pw()
{
  global $old;
  global $new1;
  global $new2;
  global $uid;

  $sth=mysql_query("select password from users where id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  list($pass_db)=mysql_fetch_row($sth);
  
  $encrypted=crypt($old,substr($pass_db,0,12));
  
  if ($encrypted!=$pass_db)
  {
    show_error("Old Password wrong!");
    return 0;
  }

  if ((strlen($new1)<4) or (strlen($new1)>20))
  {
    show_error("Password is either too long or too short! Please choose a password between 4 and 20 characters!");
    return 0;
  }

  if ($new1!=$new2)
  {
    show_error("New Passwords don't match!");
    return 0;
  }

  $sth=mysql_query("update users set password='".crypt($new1)."' where id=$uid");

  if (!$sth)
  {
    show_error("Database failure! Please avoid special characters!");
    return 0;
  }

  show_message("Your password has been changed!");
}
//---------------------------------------------------------------------------------------------------------------------------



function change_anims()
{
  global $animations;
  global $uid;

  $sth=mysql_query("update options set map_anims=".($animations ? 1 : 0)." where uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
  
}
//---------------------------------------------------------------------------------------------------------------------------


function change_map_size()
{
  global $uid;
  global $map_size;

  $sth = mysql_query("UPDATE options SET map_size = ".$map_size." WHERE uid = ".$uid);
  
  if (!$sth)
  {
    show_error("Couldn't set new Map Size");
    return 0;
  }
  echo("<body onLoad=\"parent.menu_frame.location.reload();parent.map.close();\"></body>");
  
  show_message("Map Size has been changed");
}
//---------------------------------------------------------------------------------------------------------------------------


switch($act)
{
  
  case "change_skin":
    change_skin();

/*    global $skin_new;
    global $uid;

    $sth=mysql_query("select id from skins where id=$skin_new");

    if (mysql_num_rows($sth)==0)
    {
      show_error("Couldn't select skin!");
      return 0;
    }
*/
  break;    
  case "change_pw":
    change_pw();
    show_preferences();
    break;
  case "change_anims":
    change_anims();
    show_preferences();
    break;
  case "change_map_size":
    change_map_size();
    show_preferences();
    break;
  default:
    show_preferences();  
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
