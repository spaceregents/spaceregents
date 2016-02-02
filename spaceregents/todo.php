<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return 0;

$mysql_todo = "todo";


//---------------------------------------------------------------------------------------
function check_for_auth()
{
  global $uid;
  global $mysql_todo;
  
  $sth = mysql_query("select u.id as its_id, b.developer as its_dev, u.name as its_name from bughunters b, users u where u.id = b.uid and u.id=".$uid);
  
  if (!$sth)
  {
    echo("putt");
    return 0;
  }
    
  if (mysql_num_rows($sth)>0)
  {
    $bughunter = mysql_fetch_array($sth);
    mysql_select_db($mysql_todo);    
    
    $sth = mysql_query("select * from guy where id=".$bughunter["its_id"]);
    
    if (!$sth)
    {
      echo("putt2");
      return 0;
    }
      
    if (mysql_num_rows($sth) == 0)
    {
      $sth1 = mysql_query("insert into guy (id, name, developer) values ('".$bughunter["its_id"]."','".$bughunter["its_name"]."','".$bughunter["its_dev"]."')");
      
      if (!$sth1)
      {
        echo("putt3");
        return 0;
      }
      else
      {
        mysql_select_db($mysql_todo);    
        check_for_auth();
      }
    }
    else
      return true;
  }
  else
    return false;
  
}



//---------------------------------------------------------------------------------------
function schreib_zeile($priority, $time, $subject, $description, $status, $guy, $id, $typ)
{
  global $PHP_SELF;
  global $uid;
  
  $sth = mysql_query("select name, farbe from status where id='$status'");
  
  if ((!$sth) || (!mysql_num_rows($sth)))
  {
    echo("fehler");
    return 0;
  }
    
  $its_status = mysql_fetch_row($sth);
  
  $sth = mysql_query("select name from typ where id='$typ'");

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
  
  list($its_typ) = mysql_fetch_row($sth);
  
  echo("<tr class=\"text\">\n");
  echo("<td>".$priority."</td>\n");
  echo("<td>".$subject."</td>\n");
  echo("<td>".$its_typ."</td>\n");
  echo("<td>".$time."</td>\n");
  echo("<td><span style=\"color:".$its_status[1].";\">".$its_status[0]."</span></td>\n");
  echo("<td><a href=\"".$PHP_SELF."?act=view_info&item=".$id."\">info</a></td>\n");
  echo("</tr>\n");
}



//---------------------------------------------------------------------------------------
function show_items()
{
  global $PHP_SELF;
  global $order;
  
  if (!$order)
    $order = "status, priority, time ASC";
  
  $sth = mysql_query("select * from items order by '$order'");
  
  if (!$sth)
  {
    return 0;
  }

  echo("<table width=\"80%\" align=\"center\">\n");    
  echo("<tr class=\"head\" align=\"center\">
        <td><a href=\"".$PHP_SELF."?order=priority\" class=\"head\">Priorit&auml;t</td>
        <td><a href=\"".$PHP_SELF."?order=subject\" class=\"head\">Subjekt</td>
        <td><a href=\"".$PHP_SELF."?order=typ\" class=\"head\">Typ</td>
        <td><a href=\"".$PHP_SELF."?order=time\" class=\"head\">hinzugef&uuml;gt am:</td>
        <td><a href=\"".$PHP_SELF."?order=status\" class=\"head\">Status</td>
        <td>&nbsp;</td>
        </tr>\n");
  while ($items = mysql_fetch_array($sth))  
  {
    schreib_zeile($items["priority"],$items["time"],$items["subject"],$items["description"],$items["status"],$items["guy"],$items["id"], $items["typ"]);
  }
  echo("</table><br><br>\n");
}



//---------------------------------------------------------------------------------------
function show_menu()
{
  global $PHP_SELF;
  
  
  table_start("center","80%");
  table_head_text(array("Menu"),"12");
  echo("<tr align=\"center\" class=\"head\">
        <td>Subjekt</td>
        <td>Priorit&auml;t</td>
        <td>Typ</td>
        </tr>\n");
  echo("\n");
  
  echo("<form method=\"post\" action=\"".$PHP_SELF."?act=add\">");
  echo("<tr align=\"center\">\n");
  echo("<td><input type=\"text\" name=\"subject\" size=\"40\" maxsize=\"255\" /></td>");
  echo("<td><select name=\"priority\" size=\"1\"><option>1 <option>2 <option>3</select></td>\n");
  echo("<td><select name=\"typ\" size=\"1\">");
  
  $sth = mysql_query("select id, name from typ");
  
  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
    
  while ($its_types = mysql_fetch_array($sth))
  {
    echo("<option value=\"".$its_types["id"]."\">".$its_types["name"]);
  }
  
  echo("</tr>");
  echo("<tr>");
  echo("<td colspan=\"3\">Description: <textarea type=\"text\" name=\"description\" cols=\"80\" rows=\"10\"></textarea></td>");
  echo("</tr>");
  echo("<tr>");
  echo("<td colspan=\"3\"><input type=\"submit\" value=\"add\" /></td></tr>");
  echo("</tr>");
  echo("</table>\n");
}



//---------------------------------------------------------------------------------------
function add()
{
  global $priority;
  global $subject;
  global $description;
  global $typ;
  global $uid;
  
  if ((!$priority) || (!$subject) || (!$description))
  {
    echo("Wurm, musst alle angaben ausf&uuml;llen!!!!!!");
  }
  else
  {
    $sth = mysql_query("insert into items (priority, time, subject, description, status, guy, typ, added_by) values('$priority','".date('d.m.Y')."','$subject','$description',1,'none','$typ','$uid')");
    
    if (!$sth)
    {
      echo("Fehler: Konnte Eintrag nicht hinzuf&uuml;gen");
      return 0;
    }
  }
}




//---------------------------------------------------------------------------------------
function delete_it()
{
  global $item;
  global $PHP_SELF;
  
  $sth = mysql_query("delete from items where id='$item'");
  
    if (!$sth)
    {
      echo("Fehler: Konnte Eintrag nicht l&ouml;schen");
      return 0;
    }
    else
    {
      echo("<hr><center><span style=\"color:red;\">Eintrag wurde gel&ouml;scht</span></center><hr><br><br>");
    }
  echo("<center><a href=\"".$PHP_SELF."\">zur&uuml;ck</a><center>\n");
}


//---------------------------------------------------------------------------------------
function change_status()
{
  global $value;
  global $item;
  global $uid;
  global $PHP_SELF;
  
  if ($value != 1)
    $sth = mysql_query("update items set status='$value', guy='$uid' where id='$item'");
  else
    $sth = mysql_query("update items set status='$value', guy=0 where id='$item'");
  
  if (!$sth)
  {
    echo("Konnte Status nicht &auml;ndern!");
    return 0;
  }
  else
  {
    echo("Status ge&auml;ndert!");
  }
  echo("<center><a href=\"".$PHP_SELF."\">zur&uuml;ck</a><center>\n");
}



//---------------------------------------------------------------------------------------
function is_dev()
{
  global $uid;
  
  $sth = mysql_query("select developer from guy where id=".$uid);
  
  if (!$sth || (!mysql_num_rows($sth)))
    return 0;
  
  list($dev) = mysql_fetch_row($sth);
  
  if ($dev)
    return true;
  else
    return false;
}



//---------------------------------------------------------------------------------------
function get_name($uid)
{
  $sth = mysql_query("select name from guy where id=".$uid);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
  
  list($name) = mysql_fetch_row($sth);
  
  return $name;
}



//---------------------------------------------------------------------------------------
function get_status($status_id)
{
  $sth = mysql_query("select name, farbe from status where id=".$status_id);

  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
 
  $status = mysql_fetch_array($sth);
  
  return $status;
}



//---------------------------------------------------------------------------------------
function get_bearbeiter($item_id)
{
  $sth = mysql_query("select guy from items where id=".$item_id);
  
  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
  
  list($guy) = mysql_fetch_row($sth);

  return $guy;  
}


//---------------------------------------------------------------------------------------
function view_info()
{
  global $uid;
  global $item;
  global $PHP_SELF;
  
  $sth = mysql_query("select * from items where id=".$item);
  
  if ((!$sth) || (!mysql_num_rows($sth)))
    return 0;
  
  $werte = mysql_fetch_array($sth);
  
  $status = get_status($werte["status"]);
  $its_guy= get_bearbeiter($werte["id"]);
  
  echo("<table width=\"80%\" align=\"center\">\n");
  echo("<tr><td align=\"center\" colspan=\"4\"><a href=\"".$PHP_SELF."\">zur&uuml;ck</a></td></tr>\n");
  echo("<tr class=\"head\" align=\"left\">\n");
  echo("<td>Priority</td>\n");
  echo("<td>Subject</td>\n");
  echo("<td>Added</td>\n");
  echo("<td>by</td>\n");
  echo("</tr>");
  echo("<tr class=\"text\" align=\"left\">\n");
  echo("<td>".$werte["priority"]."</td>\n");
  echo("<td>".$werte["subject"]."</td>\n");
  echo("<td>".$werte["time"]."</td>\n");
  echo("<td>".(get_name($werte["added_by"]))."</td>\n");
  echo("</tr>");
  echo("<tr align=\"left\">\n");
  echo("<td colspan=\"4\">&nbsp;</td>\n");
  echo("</tr>");
  echo("<tr align=\"left\">\n");
  echo("<td>Status: <span style=\"color:".$status["farbe"]."\">".$status["name"]."</span></td>\n");
  echo("</tr>");
  if ($its_guy)
  {
    echo("<tr align=\"left\">\n");
    echo("<td>Bearbeiter: ".(get_name($its_guy))."</td>\n");
    echo("</tr>");
  }
  echo("<tr align=\"left\">\n");
  echo("<td colspan=\"4\">&nbsp;</td>\n");
  echo("</tr>");
  echo("<tr class=\"head\" align=\"left\">\n");
  echo("<td colspan=\"4\">Description</td>\n");
  echo("</tr>\n");
  echo("<tr class=\"text\" align=\"left\">\n");
  echo("<td colspan=\"4\">".$werte["description"]."</td>\n");
  echo("</tr>");
  
  if (is_dev($uid))
  {
    echo("<tr align=\"left\">\n");
    echo("<td colspan=\"4\">&nbsp;</td>\n");
    echo("</tr>");
    echo("<tr class=\"head\" align=\"left\">\n");
    echo("<td colspan=\"4\">Options as a developer</td>\n");
    echo("</tr>\n");
    
    if (!$its_guy)
    {
      echo("<tr class=\"text\" align=\"left\">\n");
      echo("<td colspan=\"4\"><a href=\"".$PHP_SELF."?act=change_status&item=".$werte["id"]."&value=2\">&Uuml;bernehmen</a></td>\n");
      echo("</tr>");
    }
    elseif($its_guy == $uid)
    {
      echo("<tr align=\"left\">\n");
      echo("<td colspan=\"4\"><a href=\"".$PHP_SELF."?act=change_status&item=".$werte["id"]."&value=3\">Fertisch</a></td>\n");
      echo("</tr>");
      echo("<tr align=\"left\">\n");
      echo("<td colspan=\"4\"><a href=\"".$PHP_SELF."?act=change_status&item=".$werte["id"]."&value=1\">Ich bin zu doof, jemand anders soll das machen</a></td>\n");
      echo("</tr>");
      echo("<tr align=\"left\">\n");
      echo("<td colspan=\"4\"><a href=\"".$PHP_SELF."?act=delete&item=".$werte["id"]."\">l&ouml;schen!!</a></td>\n");
      echo("</tr>");
    }
    else
    {
      echo("<tr class=\"text\" align=\"left\">\n");
      echo("<td colspan=\"4\">keine :P</td>\n");
      echo("</tr>");
    }
  }
  
  echo("</table>"); 
}

if ($bughunter = check_for_auth())
{
  switch ($act)
  {
    case "add":
      add();
      show_items();
      show_menu();
    break;
    case "delete":
      delete_it();
    break;
    case "change_status":
      change_status();
    break;
    case "view_info":
      view_info();
    break;
    default:
      show_items();
      show_menu();
    break;
  }
}
?>
