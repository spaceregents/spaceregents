<?php
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return 0;

// Bis hier immer so machen:)

function show_messages()
{
  global $PHP_SELF;
  global $uid;
  global $name;
  global $text;
  global $subject;

  $sth=mysql_query("update users set last_login='".date("YmdHis")."' where id=$uid");

  $sth=mysql_query("select * from mail where uid='$uid' order by time desc");

  if (!$sth)
  {
    show_error("Database Failure!");
    return 0;
  }
  if (mysql_num_rows($sth)==0)
  {
    show_message("No Mail!");
    echo("<br><br>\n");
  }

  while ($mail=mysql_fetch_array($sth))
  {
    if ($mail["fuid"]==0)
    {
      $user["name"]="Spaceregent";
      $user["Imperium"]="Spaceregents Universe";
    }
    else
    {
      $sth1=mysql_query("select name,imperium from users where id='".$mail["fuid"]."'");
      $user=mysql_fetch_array($sth1);
    }

    table_start("center","500");
    table_text_open();
    table_text_design("<strong>".$mail["subject"]."</strong> from <strong>".$user["imperium"]." (".$user["name"].")</strong> [ ".$mail["time"]." ]","500","","","head");
    table_text_close();
    table_text(array(nl2br($mail["text"])),"left","","","text");
    table_raw_text("<a href=\"".$PHP_SELF."?act=reply&id=".$mail["id"]."\">Reply</A>&nbsp;&nbsp;&nbsp;<a href=\"".$PHP_SELF."?act=delete&mid=".$mail["id"]."\">Delete</A>");
    table_end();
  }

  echo("<a href=\"".$PHP_SELF."?act=delete\"><h3 align=\"center\">Delete all mails</h3></A>");

  echo("<a name=\"mailform\">\n<form action=\"".$PHP_SELF."\" method=post>\n</a>\n");
  table_border_start("center","500","#302859");
  table_head_text(array("Send a new message"),"4");
  table_form_text("Send to","name",$name);
  table_form_text("Subject","subject",stripslashes($subject),40,255);
  table_form_textarea("Message","text",stripslashes($text));
  table_form_submit("Send message","send");
  echo("</form>");
  table_end();
}

function send()
{
  global $uid;
  global $text;
  global $name;
  global $subject;

  if ($subject=="")
  {
    show_error("No subject specified!");
    return 0;
  }

  if ($name=="")
  {
    show_error("No recipient specified!");
    return 0;
  }

  if ($text=="")
  {
    show_error("Don't you think you need to enter a message? :)!");
    return 0;
  }

  $sth=mysql_query("select id from users where name='$name'");
  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("The Recipient doesn't exist!");
    return 0;
  }

  $fuid=mysql_fetch_array($sth);

  if ($fuid["id"]==$uid)
  {
    show_error("Stop talking with yourself!");
    return 0;
  }

  $sth=mysql_query("select name from users where id='$uid'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $absender=mysql_fetch_array($sth);


  $sth=mysql_query("insert into mail (fuid,uid,text,subject,time) values ('$uid','".$fuid["id"]."','".strip_tags($text)."','".$subject."','".date("YmdHis")."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("insert into ticker (uid,type,text,time) values ('".$fuid["id"]."','m','*lmail.php*You have recieved a message from ".$absender["name"]."','".date("YmdHis")."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  show_message("Your message has been sent!");
}


function reply()
{
  global $PHP_SELF;
  global $uid;
  global $id;

  $sth=mysql_query("select * from mail where id='$id'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $mail=mysql_fetch_array($sth);

  if ($mail["uid"]!=$uid)
  {
    show_error("I'm not stupid guy! :)");
    return 0;
  }

  if (!(substr($mail["subject"],0,4)=="RE: "))
    $subject="RE: ".$mail["subject"];
  else
    $subject=$mail["subject"];

  $sth=mysql_query("select name from users where id='".$mail["fuid"]."'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $user=mysql_fetch_array($sth);


  echo("<form action=\"".$PHP_SELF."\" method=post>\n");
  table_border_start("Send new message");
  table_form_text("Send to","name",$user["name"]);
  table_form_text("Subject","subject",$subject);
  table_form_textarea("Message","text",$mail["text"]);
  table_form_submit("Send message","send");
  echo("</form>");
  table_end();

}

function delete()
{
  global $uid;
  global $mid;

  if ($mid=="")
    $sth=mysql_query("delete from mail where uid=$uid");
  else
    $sth=mysql_query("delete from mail where uid=$uid and id=$mid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
}

function show_menu()
{
  global $PHP_SELF;
  global $skin;

  center_headline("Communications");
  table_start("center","500");
  table_text_open("","center");
  table_text_design("<a href=\"communication.php?act=show_alliance\"><img src=\"skins/".$skin."_alliance.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Alliance Menu\"></A>","163","center");
  table_text_design("<a href=\"database.php\"><img src=\"skins/".$skin."_database.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Galactic Database\"></A>","163","center");
  table_text_design("<a href=\"communication.php?act=show_journal\"><img src=\"skins/".$skin."_notebook.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Personal journal\"></A>","163","center");
  table_text_design("<a href=\"mail.php\"><img src=\"skins/".$skin."_mail.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Mailbox\"></A>","164","center");
  table_text_close();
  table_text_open("");
  table_text_design("Alliance Menu","","center");
  table_text_design("Galactic Database","","center");
  table_text_design("Journal","","center");
  table_text_design("Mailbox","","center");
  table_text_close();
  table_end();
  echo("<br>\n");
  center_headline("Mailbox");
}


switch ($act)
{
  case "send":
    show_menu();
  send();
  show_messages();
  break;
  case "reply":
    show_menu();
  reply();
  break;
  case "delete":
    delete();
  show_menu();
  show_messages();
  break;   
  default:
  show_menu();
  show_messages();
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
