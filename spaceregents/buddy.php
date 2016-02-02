<link rel=stylesheet type="text/css" href="inc/srbuddy.css">
<table class="buddy">
<tr>
  <td colspan="2" class="top" align="center">Buddylist</td>
</tr>
<tr align="center">
  <td class="top" width="140">
    <a href="<?php print $_SERVER["PHP_SELF"]; ?>" class="menu">Overview</a>
  </td>
  <td class="top" width="140">
    <a href="<?php print $_SERVER["PHP_SELF"]."?act=invitations"; ?>" class="menu">Invitations</a>
  </td>
</tr>
</table>

<?
include "../spaceregentsinc/buddies.inc.php";

function show_buddies()
{
  global $uid;
  global $PHP_SELF;

  if ($buddies=get_online_buddies($uid))
  {
    reset ($buddies);

    echo("<table class=\"list\">\n");

    while (list($buid,$name)=each($buddies))
    {
      echo("<tr><td class=\"list\"><img src=\"arts/bon.jpg\" alt=\"online\" width=\"10\" height=\"10\" align=\"baseline\">&nbsp;<a class=\"list\" href=\"".$PHP_SELF."?act=msg&fuid=".$buid."\">$name</a></td><td class=\"list\" width=\"80\"><a href=\"mail.php?act=show_messages&name=$name#mailform\"><img src=\"arts/bmail.jpg\" border=\"0\" width=\"15\" height=\"15\" alt=\"send mail\" onmouseover=\"this.src='arts/bmail2.jpg'\" onmouseout=\"this.src='arts/bmail.jpg'\"></a><a href=\"".$PHP_SELF."?act=drop&fuid=".$buid."\"><img src=\"arts/bdrop.jpg\" border=\"0\" width=\"15\" height=\"15\" alt=\"remove from buddylist\" onmouseover=\"this.src='arts/bdrop2.jpg'\" onmouseout=\"this.src='arts/bdrop.jpg'\"></a></td></tr>\n");
    }
    echo("</table>");
  }

  if ($buddies=get_offline_buddies($uid))
  {
    echo("<table class=\"list\">\n");

    while (list($buid,$name)=each($buddies))
    {
      echo("<tr><td class=\"list\"><img src=\"arts/boff.jpg\" alt=\"offline\" width=\"10\" height=\"10\" align=\"baseline\">&nbsp; $name</td><td class=\"list\" width=\"80\"><a href=\"mail.php?act=show_messages&name=$name#mailform\"><img src=\"arts/bmail.jpg\" border=\"0\" width=\"15\" height=\"15\" alt=\"send mail\" onmouseover=\"this.src='arts/bmail2.jpg'\" onmouseout=\"this.src='arts/bmail.jpg'\"></a><a href=\"".$PHP_SELF."?act=drop&fuid=".$buid."\"><img src=\"arts/bdrop.jpg\" border=\"0\" width=\"15\" height=\"15\" alt=\"remove from buddylist\" onmouseover=\"this.src='arts/bdrop2.jpg'\" onmouseout=\"this.src='arts/bdrop.jpg'\"></a></td></tr>\n");
    }
    echo("</table>");
  }
}

function show_pending_messages()
{
  global $uid;
  global $PHP_SELF;
  global $index;

  if ($index=="")
    $index=0;

  if (!list($fuid,$message,$time)=get_pending_message($uid,$index))
    return 0;

  echo("<table width=\"280\">\n");
  echo("<tr><td class=\"top\">From: ".get_name_by_uid($fuid)." at ".$time."</td></tr><tr><td class=\"list\">".$message."</td></tr>\n");
  if (get_pending_message($uid,++$index))
    echo(" <a href=\"".$PHP_SELF."?index=".($index)."\">Next</a><br>");
  else
    echo("<br>");

  del_buddy_msg($uid,$fuid,$time);
}

function msg_user()
{
  global $uid;
  global $fuid;
  global $PHP_SELF;

  if (!is_buddy($uid,$fuid))
    return 0;

  if (!is_online($fuid))
    return 0;

  echo("<form action=\"".$PHP_SELF."\" method=post>");

  echo("<input name=\"msg\" size=\"25\" maxsize=\"255\"><input type=\"hidden\" name=\"act\" value=\"proc_msg\">");
  echo("<input type=\"hidden\" name=\"fuid\" value=\"".$fuid."\">");
  echo("<input type=\"submit\" value=\"Send\">");
  echo("</form>");
}

function proc_msg()
{
  global $msg;
  global $uid;
  global $fuid;

  if (!is_buddy($uid,$fuid))
    return 0;

  if (strlen($msg)>255)
    return 0;

  if (!is_online($fuid))
    return 0;

  if (buddy_msg($fuid,$uid,addslashes($msg)))
  {
    set_reload($fuid);
    echo("Message sent!");
  }
  else
    echo("An error occured!<br>");
}

function show_invitations()
{
  global $uid;
  global $PHP_SELF;

  $invitations=get_user_invitations($uid);

  if (!$invitations)
  {
    echo("<table width=\"280\" class=\"list\">\n");
    echo("<center>No invitation requests!</center><br>");
    echo("</table>\n");
  }
  else
  {
    echo("<table width=\"280\" class=\"list\">\n");
    table_text_open();
    table_text_design("Invitation requests","240","center","2","top");
    table_text_close();

    while (list($user)=mysql_fetch_row($invitations))
    {
      table_text_open();
      table_text_design(get_name_by_uid($user),"200","right","","list");
      table_text_design("<a href=\"".$PHP_SELF."?act=add&fuid=$user\"><img src=\"arts/bok.jpg\" alt=\"accept\" width=\"15\" height=\"15\" onmouseover=\"this.src='arts/bok2.jpg'\" onmouseout=\"this.src='arts/bok.jpg'\" border=\"0\"></a><a href=\"".$PHP_SELF."?act=del_foreign_invite&fuid=$user\"><img src=\"arts/bdrop.jpg\" alt=\"decline\" width=\"15\" height=\"15\" onmouseover=\"this.src='arts/bdrop2.jpg'\" onmouseout=\"this.src='arts/bdrop.jpg'\" border=\"0\"></a>","40","right","","list");
      table_text_close();
    }
    echo("</table>\n");
  }

  $invitations=get_buddy_invitations($uid);

  if ($invitations)
  {
    echo("<table width=\"280\" class=\"list\">\n");
    table_text_open();
    table_text_design("pending invitations!","240","center","2","top");
    table_text_close();

    while (list($user)=mysql_fetch_row($invitations))
    {
      table_text_open();
      table_text_design(get_name_by_uid($user),"200","right","","list");
      table_text_design("<a href=\"".$PHP_SELF."?act=del_invitation&fuid=$user\"><img src=\"arts/bdrop.jpg\" alt=\"drop\" width=\"15\" height=\"15\" onmouseover=\"this.src='arts/bdrop2.jpg'\" onmouseout=\"this.src='arts/bdrop.jpg'\" border=\"0\"></a>","40","right","","list");
      table_text_close();
    }
    echo("</table>\n");
    echo("<br>");
  }

}

function invite_buddy()
{
  global $PHP_SELF;

    echo("<table width=\"280\" class=\"list\">\n");
    table_text_open();
    table_text_design("invite a user","240","center","2","top");
    table_text_close();
    echo("<form action=\"".$PHP_SELF."\" method=post>");
    echo("<tr><td class=\"list\"><input name=\"buddy\"><input type=hidden name=\"act\" value=\"proc_invite_buddy\"><input type=\"submit\" value=\"send\"></td></tr>");
    echo("</table>\n");
  echo("</form>");
}

function proc_invite_buddy()
{
  global $uid;
  global $buddy;

  if (!$fuid=get_uid_by_name($buddy))
  {
    echo("<center>Username doesn't exist!</center><br>");
    invite_buddy();
  }
  else
  {
    if (!is_buddy($fuid,$uid))
      buddy_invite($uid,$fuid);
    echo("Invitation sent!<br>");
    send_ticker_from_to($uid,$fuid,"w","wants to add you to her/his buddylist");
    show_pending_messages();
    show_buddies();
  }
}

function del_invitation()
{
  global $uid;
  global $fuid;

  del_buddy_invite($uid,$fuid);
}

function del_foreign_invitation()
{
  global $uid;
  global $fuid;

  del_buddy_invite($fuid,$uid);
  send_ticker_from_to($uid,$fuid,"w","declined your invitation request");
}

function add_buddy_to_list()
{
  global $uid;
  global $fuid;

  if (is_invited($uid,$fuid))
  {
    add_buddy($uid,$fuid);
    add_buddy($fuid,$uid);
    del_buddy_invite($fuid,$uid);
  }
  else
    echo("<center>User did not invite you!</center>");
}

function remove_buddy_from_list()
{
  global $uid;
  global $fuid;

  if (is_buddy($uid,$fuid))
  {
    del_buddy($uid,$fuid);
    del_buddy($fuid,$uid);
    del_buddy_invite($fuid,$uid);
    send_ticker_from_to($uid,$fuid,"w","removed you from his/her buddylist");
  }
  else
    echo("<center>User's not your buddy!</center>");
}


switch ($act)
{
  case "proc_msg":
    proc_msg();
    show_pending_messages();
    show_buddies();
    break;
  case "msg":
    msg_user();
    show_pending_messages();
    show_buddies();
    break;
  case "invitations":
    invite_buddy();
    show_invitations();
    break;
  case "proc_invite_buddy":
    proc_invite_buddy();
    break;
  case "del_invitation":
    del_invitation();
    show_invitations();
    break;
  case "del_foreign_invite":
    del_foreign_invitation();
    show_invitations();
    break;
  case "add":
    add_buddy_to_list();
    show_pending_messages();
    show_buddies();
    break;
  case "drop":
    remove_buddy_from_list();
    show_pending_messages();
    show_buddies();
    break;
  default:
    show_pending_messages();
    show_buddies();
}
?>