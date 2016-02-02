<?php
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/alliances.inc.php";
include "../spaceregentsinc/systems.inc.php";

if ($not_ok)
  return 0;

  // Bis hier immer so machen:)

function show_journal()
{
  global $PHP_SELF;
  global $uid;
  global $name;
  global $text;
  global $subject;

  $sth=mysql_query("select * from journal where uid='$uid' order by time");

  if (!$sth)
  {
    show_error("Database Failure!");
    return 0;
  }

  center_headline("Journal");

  if (mysql_num_rows($sth)==0)
  {
    show_message("No Entry!");
  }

  table_start("center","500");

  while  ($journal=mysql_fetch_array($sth))
  {
    table_text_open("head");
    table_text_design("<strong>".$journal["subject"]."</strong>","400","","","head");
    table_text_design($journal["time"],"100","","","smallhead");
    table_text_close();
    table_text(array(nl2br($journal["text"])),"","","2","text");
    table_text(array("&nbsp;","<a href=\"".$PHP_SELF."?act=delete_note&nid=".$journal["id"]."\">delete</a>"),"","","","head");
    table_text(array("&nbsp;"),"","","2","none");
  }
  table_end();
  echo("<br><br>\n");
  echo("<a href=\"".$PHP_SELF."?act=delete_note\"><h3 align=\"center\">Delete all notes</h3></A>");

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  table_border_start("center","500","#302859");
  table_head_text(array("New Note"),"2");
  table_form_text("Subject","subject",$subject);
  table_form_textarea("Message","text",$text);
  table_form_submit("note","send_note");
  echo("</form>");
  table_end();
}

function delete_note()
{
  global $uid;
  global $nid;

  if ($nid=="")
  {
    $sth=mysql_query("delete from journal where uid=$uid");
    show_message("All notes have been deleted");
  }
  else
  {
    $sth=mysql_query("delete from journal where uid=$uid and id=$nid");
    show_message("Note has been deleted");
  }

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
}


function send_note()
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

  if ($text=="")
  {
    show_error("Don't you think you need to enter a note? :)!");
    return 0;
  }

  $sth=mysql_query("select id from users where name='$name'");
  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }


  $sth=mysql_query("insert into journal (uid,subject,text,time) values ('$uid','$subject','".nl2br(strip_tags($text))."','".date("Y-m-d H:i:s")."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  show_message("Your note has been stored");
}

function show_alliance()
{
  global $uid;
  global $PHP_SELF;
  global $name;

  $sth=mysql_query("select a.* from alliance as a,users as u where a.id=u.alliance and u.id='$uid'");

  center_headline("Alliance menu");

  $alliance=mysql_fetch_assoc($sth);
  center_headline("You are currently in alliance ".$alliance["name"]);

  if ($alliance["leader"]==$uid)
  {
    center_headline("You are currently the leader of the alliance");
  }

  $sth=mysql_query("select * from vote where aid=".$alliance["id"]);

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    table_start("center","500");
    table_head_text(array("Voting"),"3");
    table_text(array("&nbsp;"),"","","3","head");
    $vote=true;
  }


  $sth=mysql_query("select u.name,u.id from users as u,alliance as a where u.alliance=".$alliance["id"]." and a.id=u.alliance and u.id!=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    if (!$vote)
    {
      table_start("center","500");
      table_head_text(array("Members"),"2");
      table_text(array("&nbsp;"),"","","2","head");
      table_text(array("Members limit: ".MAX_ALLIANCE_MEMBERS),"","","2","text");

      while ($members=mysql_fetch_assoc($sth))
      {
        if ($members["id"]==$alliance["leader"])
          $members["name"]=$members["name"]." (leader)";

        table_text(array($members["name"]),"","","","text");
      }
    }
    else
    {
      while ($members=mysql_fetch_row($sth))
      {
        $sth1=mysql_query("select count(vote) from votes where vote=".$members[1]);

        if (!$sth1)
        {
          show_error("Database failure!");
          return 0;
        }

        $votes=mysql_fetch_row($sth1);

        $user[$members[1]]=$votes[0];
      }

      $sth=mysql_query("select id from users where id=$uid");

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      $id_leader=mysql_fetch_row($sth);

      $sth=mysql_query("select count(vote) from votes where vote=".$id_leader[0]);

      if (!$sth)
      {
        show_error("Database failure!");
        return 0;
      }

      $votes=mysql_fetch_row($sth);

      $user[$id_leader[0]]=$votes[0];
    }

    if ($vote)
    {
      $sth=mysql_query("select uid from votes where uid=$uid");

      if (!$sth)
      {
        show_error("Database error!");
        return 0;
      }

      if (mysql_num_rows($sth)>0)
        $already_voted=true;


      arsort($user);
      reset($user);

      table_text(array("Members limit: ".MAX_ALLIANCE_MEMBERS),"","","3","text");
      while (list($key,$value)=each($user))
      {
        $sth=mysql_query("select name from users where id=$key");

        if (!$sth)
        {
          show_error("Database error!");
          return 0;
        }

        $name=mysql_fetch_array($sth);

        if ($already_voted)
          table_text(array($name["name"],$value),"left","","","text");
        else
        {
          if ($key==$uid)
            table_text(array($name["name"],$value,"&nbsp;"),"left","","","text");
          else
            table_text(array($name["name"],$value,"<a href=\"".$PHP_SELF."?act=vote&id=$key\">Vote<A>"),"left","","","text");
        }

      }
      table_end();
      echo("<br><br>\n");
    }


  }
  else
  {
    table_end();
    show_message("You have no members at the moment. Bad luck:)");
  }

  $options=array();
  switch ($uid)
  {
    case $alliance["leader"]:
      $options=array("color",
          "broadcast",
          "picture",
          "mailforms",
          "resign",
          );
    $posten="leader";
    break;
    case $alliance["forminister"]:
      $options=array("broadcast",
          "resign",
          );
    $posten="Foreign Minister";
    break;
    case $alliance["devminister"]:
      $options=array("broadcast",
          "resign",
          );
    $posten="Minister of Development";
    break;
    case $alliance["milminister"]:
      $options=array("broadcast",
          "resign",
          );
    $posten="Minister of Defence";
    break;
  }

  table_start("center","500");
  table_head_text(array("Your options as leader"),"2");
  table_text(array("&nbsp;"),"","","2","head");
  if (in_array("color",$options))
    table_text(array("<a href=\"".$PHP_SELF."?act=changecolor\">Alliance Color</A>","This is where you can change your alliance color ."),"","","","text");
  if (in_array("broadcast",$options))
    table_text(array("<a href=\"".$PHP_SELF."?act=broadcast\">Broadcast</A>","Broadcast a message to your allies."),"","","","text");
  table_text(array("<a href=\"".$PHP_SELF."?act=forum\">Alliance Forum</A>","Communicate with your allies"),"","","","text");
  table_text(array("<a href=\"".$PHP_SELF."?act=show_foreign_forum\">Foreign Forum</A>","View communication between Foreign Ministers"),"","","","text");
  if (in_array("picture",$options))
    table_text(array("<a href=\"".$PHP_SELF."?act=info\">Info</A>","Set an alliance picture, info and homepage."),"","","","text");
  if (in_array("mailforms",$options))
    table_text(array("<a href=\"".$PHP_SELF."?act=mailforms\">Mailforms</A>","This is were you can setup standard mails which you can send to people."),"","","","text");
  table_text(array("<a href=\"".$PHP_SELF."?act=show_parliament\">Parliament</A>","View, appoint ministers, start votes and set rules"),"","","","text");
  if (in_array("resign",$options))
    table_text(array("<a href=\"".$PHP_SELF."?act=resign\" onclick=\"return confirm('Are you sure you want to resign?');\">Resign</a>","Resign"),"","","","text");
  table_text(array("<a href=\"tax.php\">Taxes</A>","View the Taxrates"),"","","","text");
  table_text(array("<a href=\"".$PHP_SELF."?act=show_diplomacy\">Show diplomatic alliance status</A>","Shows the diplomatic  status with the rest of the alliances"),"","","","text");
  table_text(array("<a href=\"battlereport.php?act=show_alliance\">Show alliance battlereports</A>","Shows an archive of the battles the alliance was involved in"),"","","","text");
  table_text(array("&nbsp;"),"","","2","smallhead");
  table_text(array("<a href=\"http://www.spaceregents.de/portal.php?page=forum\" target=\"_blank\" title=\"Game Forum\">Game Forum</a>","Enter the game forum"),"","","","text");
  table_end();
}

function mailforms()
{
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id from alliance where leader='$uid'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not leader of an alliance!");
    return 0;
  }

  $aid=mysql_fetch_array($sth);

  $sth=mysql_query("select * from mailforms where aid='".$aid["id"]."'");

  if (!$sth)
  {
    show_error("Database Failure!");
    return 0;
  }

  if (mysql_num_rows($sth)<3)
  {
    show_message("You didn't fill out every mailform!");
  }

  $option_arr["Invitation"]="I";
  $option_arr["Kick"]="K";
  $option_arr["Resign"]="R";

  center_headline("Mailforms");
  echo("<form action=\"".$PHP_SELF."\" method=post>");
  table_start("center");
  table_form_select("Mailform","typ",$option_arr);
  table_form_submit("Edit","edit_mailform");
  table_end();
  echo("</form>");
}

function found_alliance()
{
  global $uid;
  global $name;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  if (strlen($name)==0)
  {
    show_error("The alliance name must contain at least one character:)");
    return 0;
  }

  $sth=mysql_query("select id from alliance where name='$name'");

  if (mysql_num_rows($sth)>0)
  {
    show_error("An alliance with this name already exists!");
    return 0;
  }

  $sth=mysql_query("select alliance from users where id=$uid");

  if (!$sth)
  {
    show_message("Database failure!");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  if ($alliance["alliance"]!=0)
  {
    $sth=mysql_query("select count(id) from users where alliance='".$alliance["alliance"]."' and id!=$uid");

    if (!$sth)
    {
      show_message("Database failure!");
      return 0;
    }

    $members=mysql_fetch_row($sth);

    $sth=mysql_query("select leader from alliance where id=".$alliance["alliance"]);

    if (!$sth)
    {
      show_message("Database failure!");
      return 0;
    }

    $leader=mysql_fetch_array($sth);

    if (($leader["leader"]==$uid) and ($members[0]>0))
    {
      resign();
    }

    if ($members[0]==0)
    {
      $sth=mysql_query("delete from alliance where id='".$alliance["alliance"]."'");

      $sth=mysql_query("delete from invitations where aid='".$alliance["alliance"]."'");
    }
  }

  $sth=mysql_query("insert into alliance (name,leader,last_vote,vote_interval) values ('$name','$uid','".date("Y-m-d H:i:s")."','10')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $aid=mysql_insert_id();

  $sth=mysql_query("update users set alliance='".$aid."' where id='$uid'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("insert into taxes (aid) values ('".$aid."')");

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
  table_text_design("<a href=\"".$PHP_SELF."?act=show_alliance\"><img src=\"skins/".$skin."_alliance.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Alliance Menu\"></A>","163","center");
  table_text_design("<a href=\"database.php\"><img src=\"skins/".$skin."_database.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Galactic Database\"></A>","163","center");
  table_text_design("<a href=\"".$PHP_SELF."?act=show_journal\"><img src=\"skins/".$skin."_notebook.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Personal journal\"></A>","163","center");
  table_text_design("<a href=\"mail.php\"><img src=\"skins/".$skin."_mail.jpg\" border=\"0\" width=\"50\" height=\"50\" alt=\"Mailbox\"></A>","164","center");
  table_text_close();
  table_text_open("");
  table_text_design("Alliance Menu","","center");
  table_text_design("Galactic Database","","center");
  table_text_design("Journal","","center");
  table_text_design("Mailbox","","center");
  table_text_close();
  table_end();
  echo("<br><br>\n");
}

function edit_mailform()
{
  global $uid;
  global $typ;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader from alliance where leader='$uid'");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  switch ($typ)
  {
    case "I":
      break;
    case "K":
      break;
    case "R":
      break;
    default:
    show_message("bbbbbbbbbbbbllllllll!");
    return 0;
  }

  $sth=mysql_query("select content from mailforms where aid='".$alliance["id"]."' and typ='$typ'");

  if (!$sth)
  {
    show_message("Database failure!");
    return 0;
  }

  $mailform=mysql_fetch_array($sth);

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  table_start();
  table_form_textarea("Content","content",$mailform["content"]);
  form_hidden("typ",$typ);
  table_form_submit("Edit","proc_edit_mailform");
  table_end();
}

function proc_edit_mailform()
{
  global $typ;
  global $content;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader from alliance where leader='$uid'");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  switch ($typ)
  {
    case "I":
      break;
    case "K":
      break;
    case "R":
      break;
    default:
    show_message("bbbbbbbbbbbbllllllll!");
    return 0;
  }

  $sth=mysql_query("select typ from mailforms where typ='$typ' and aid='".$alliance["id"]."'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    $sth=mysql_query("insert into mailforms (aid,typ,content) values ('".$alliance["id"]."','".$typ."','".(strip_tags($content))."')");
  }
  else
  {
    $sth=mysql_query("update mailforms set content='".(strip_tags($content))."' where aid='".$alliance["id"]."' and typ='".$typ."'");
  }

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  show_message("Mailform updated!");

}

function invite()
{
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader from alliance where leader='$uid'");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  echo("<form action=\"".$PHP_SELF."\" method=post>");
  table_start("center","500");
  table_head_text(array("Invite a user"),"2");
  table_form_text("User","fuid","","20","20","text");
  table_form_submit("Invite","proc_invite","0");
  table_end();
  echo("</form>");
}

function proc_invite()
{
  global $uid;
  global $fuid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader,name from alliance where leader='$uid'");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select id from users where name='".$fuid."'");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("No such user!");
    return 0;
  }

  $user=mysql_fetch_array($sth);

  $sth=mysql_query("select * from invitations where aid=".$alliance["id"]." and uid=".$user["id"]);

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("User already invited!");
    return 0;
  }

  $sth=mysql_query("insert into invitations (aid,uid) values ('".$alliance["id"]."','".$user["id"]."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("select content from mailforms where typ='I' and aid='".$alliance["id"]."'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    $mailform["content"]="The alliance leader is too lame to setup his invitation mailform but inivited you to his alliance:). Got to Communications and the to the alliance menu to see your new options";
  }
  else
    $mailform=mysql_fetch_array($sth);

  $sth=mysql_query("insert into mail (uid,fuid,text,subject,time) values ('".$user["id"]."','".$uid."','".$mailform["content"]."','You have been invited to an alliance!','".date("YmdHis")."')");
  $sth=mysql_query("insert into ticker (uid,type,text,time) values ('".$user["id"]."','w','*lcommunication.php?act=show_alliance*You have been invited to join alliance :".$alliance["name"]."','".date("YmdHis")."')");

  show_message("User has been invited!");
}

function join_alliance()
{
  global $id;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select * from invitations where aid=$id and uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("HUND!");
    return 0;
  }
  
  if (!alliance_not_full($id))
  {
    show_message("Alliance can not hold any more members.");
    return false;
  }
    
  
  $sth = mysql_query("select alliance from users where id=".$uid);
  
  if (!$sth) {
    show_message("ERR::get alliance");
    return false;
  }
  
  list($its_alliance) = mysql_fetch_row($sth);
  
  if ($its_alliance != 0) {
    show_message("First you must leave the alliance and recieve an alliance lock.");
    return false;
  }

  $sth=mysql_query("select * from alliance where leader=$uid");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("You're leader of an alliance! Please resign first!");
    return 0;
  }

  $sth=mysql_query("select * from alliance where milminister=$uid or forminister=$uid or devminister=$uid");

  if (!$sth)
  {
    show_error("Database error!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("You're a minister of an alliance! Please resign first!");
    return 0;
  }


  $sth=mysql_query("update users set alliance=$id where id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("delete from invitations where uid=$uid and aid=$id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  // Nachticht an alle Allianzenmitglieder schicken
  $allies   = get_allied_ids($uid);
  $username = get_name_by_uid($uid);

  if (is_array($allies))
  {
    for ($i = 0; $i < sizeof($allies); $i++)
    {
      send_ticker_from_to(0,$allies[$i],"w",$username." has joined your alliance");
    }
  }

  show_message("You have joined!");

}

function kick()
{
  global $uid;
  global $aid;
  global $id;
  
  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader from alliance where leader='$uid' and id=$aid");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select 1 from alliance where devminister=".$id." or milminister=".$id." or forminister=".$id);

  if (!$sth)
  {
    show_error("ERR::GET MINISTERS");
    return false;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_error("You are trying to kick a minister. Please dismiss him first!");
    return 0;
  }

  $sth=mysql_query("select * from vote where aid=".$alliance["id"]);

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("You can't kick somebody if a vote is in progress!");
    return 0;
  }

  $sth=mysql_query("select id from users where alliance=$aid and id=$id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("l33t!");
    return 0;
  }
  
  // mop: abfindung holen
  $pay_off=get_pay_off($id);
  
  // mop: alle mitglieder holen und berechnen, wieviel jeder aufgebrummt bekommt
  $members=get_alliance_members($aid);
  $divisor=sizeof($members)-1;
  
  $segments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $ressource)
    $segments[]="r.".$ressource."=r.".$ressource."-".($pay_off[$ressource]/$divisor);
    
  $sth=mysql_query("update ressources r,users u set ".implode(",",$segments)." where r.uid=u.id and u.alliance=".$aid." and u.id!=".$id);

  if (!$sth)
  {
    show_error("ERR::PAY PAYOFF");
    return false;
  }

  $segments=array();
  foreach (array("metal","energy","mopgas","erkunum","gortium","susebloom") as $ressource)
    $segments[]=$ressource."=".$ressource."+".($pay_off[$ressource]);
  
  $sth=mysql_query("update ressources set ".implode(",",$segments)." where uid=".$id);

  if (!$sth)
  {
    show_error("ERR::GET PAYOFF");
    return false;
  }
  
  remove_from_alliance($id);

  $sth=mysql_query("select content from mailforms where typ='K' and aid='".$aid."'");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    $mailform["content"]="The alliance leader is too lame to setup his kick mailform but kicks you out of the alliance anyway:)";
  }
  else
    $mailform=mysql_fetch_array($sth);

  $sth=mysql_query("insert into mail (uid,fuid,text,subject,time) values ('".$id."','".$uid."','".$mailform["content"]."','You have been kicked out of the alliance!!!','".date("YmdHis")."')");

  show_message("User has been kicked!");
}

function changecolor()
{
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader,color from alliance where leader='$uid'");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  echo("<head>\n");
  echo("<script language=\"JavaScript\" type=\"text/javascript\">
      var hexadec = new Array(\"0\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\",\"7\",\"8\",\"9\",\"A\",\"B\",\"C\",\"D\",\"E\",\"F\");
      var brennt = false;

      function zuruecksetzen()
      {
      document.forms[0].elements[0].value = \"255\";
      document.forms[0].elements[1].value = \"0\";
      document.forms[0].elements[2].value = \"255\";
      brennt = false;
      }

      function setzewert(r,s,t)
      {
      zuruecksetzen();
      browse_tube(r,s,t);
      document.forms[0].elements[4].value = r;
      document.forms[0].elements[5].value = s;
      document.forms[0].elements[6].value = t;
      }

      function zahlen_check(wert)
      {
        for (i=0; i < wert.length;++i)
          if (wert.charAt(i) >= 10 || wert>=256 || wert < 0)
          {
            alert(\"You must enter a decimal betwenn 0-255\");
            brennt = true;
            return 0;
          }
        if (isNaN(vermittler = parseInt(wert,10)))
        {
          alert(\"please enter a decimal number\");
          brennt = true;
        }
        return vermittler;
      }

      function inHexwandeln(v2)
      {
        save = \"\";
        while (v2 >= 16)
        {
          save += hexadec[v2 % 16];
          v2 = Math.floor(v2 / 16);
        }
        return und_nu(save += hexadec[v2]);
      }

      function und_nu(save)
      {
        t = save.length;
        for (i = 0, h = \"\"; i < t; i++)
          h += save.substring(t-i-1,t-i);
        return h;
      }

      function browse_tube(farben1,farben2,farben3)
      {
        if (document.all)
        {
          if (window.innerHeight) farb_auswahlOP(farben1,farben2,farben3);
          else farb_auswahlIE(farben1,farben2,farben3);
        }
        else
        {
          if (document.layers) farb_auswahlNS(farben1,farben2,farben3);
          else farb_auswahlOP(farben1,farben2,farben3);
        }
      }

      function farb_auswahl()
      {
        var retter = \"0\";
        farben = new Array();
        farben[0] = document.forms[0].elements[0].value;
        farben[1] = document.forms[0].elements[1].value;
        farben[2] = document.forms[0].elements[2].value;

        if ((farben[0]<30 && farben[1]<30 && farben[2]<30) || (farben[0]>225 && farben[1]>225 && farben[2]>225))
        {
          alert(\"The color you have entered is too dark or too bright\");
          brennt = true;
        }
        for (e = 0; e < 3; e++)
        {
          vermittler = zahlen_check(farben[e]);
          farben[e] = inHexwandeln(vermittler);
          if (farben[e].length <= 1) farben[e] = retter.concat(farben[e]);
          if (brennt == true) farben[e] = \"\";
          document.forms[0].elements[4+e].value = farben[e];
        }
        browse_tube(farben[0],farben[1],farben[2]);
      }

      function farb_auswahlIE(rot,gruen,blau)
      {
        ding = document.getElementById(\"showfarbe\");
        if (brennt == false)
        {
          farbe = rot+gruen+blau;
          ding.bgColor = \"#\"+farbe;
        }
        else
        {
          ding.bgColor = \"#ff00ff\";
          zuruecksetzen();
        }
      }


      function farb_auswahlOP(rot,gruen,blau)
      {
        browsercheck = navigator.userAgent.search(/Gecko.+/);
        if (browsercheck != -1) farb_auswahlIE(rot,gruen,blau);
        else
        {
          if (brennt == false)
          {
            farbe = rot+gruen+blau;
          }
          else
          {
            document.layers[0].bgColor = \"#ff00ff\";
            zuruecksetzen();
          }
        }
      }

      function farb_auswahlNS(rot,gruen,blau)
      {
        if (brennt == false)
        {
          farbe = rot+gruen+blau;
          document.layers[0].bgColor = \"#\"+farbe;
        }
        else
        {
          document.layers[0].bgColor = \"#ff00ff\";
          zuruecksetzen();
        }
      }
      </script>\n");
      echo("</head>\n");
      center_headline("Your alliance color");
      echo("<center>
          <br>
          <table  style=\"border-style:none; border-width:thin;\">
          <tr>
          <td bgcolor=\"#000000\" width=\"5\" height=\"5\">&nbsp;</td>
          <td bgcolor=\"#000033\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','00','33');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#000066\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','00','66');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#000099\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','00','99');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#0000cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','00','cc');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#0000ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','00','ff');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#330000\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','00','00');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#330033\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','00','33');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#330066\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','00','66');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#330099\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','00','99');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#3300cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','00','cc');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#3300ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','00','ff');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#660000\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','00','00');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#660033\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','00','33');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#660066\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','00','66');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#660099\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','00','99');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#6600cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','00','cc');return false;\">&nbsp;</a></td>
          <td bgcolor=\"#6600ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','00','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#990000\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','00','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#990033\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','00','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#990066\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','00','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#990099\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','00','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9900cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','00','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9900ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','00','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc0000\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','00','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc0033\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','00','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc0066\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','00','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc0099\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','00','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc00cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','00','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc00ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','00','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff0000\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','00','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff0033\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','00','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff0066\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','00','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff0099\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','00','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff00cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','00','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff00ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','00','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#003300\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','33','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#003333\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','33','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#003366\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','33','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#003399\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','33','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#0033cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','33','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#0033ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','33','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#333300\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','33','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#333333\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','33','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#333366\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','33','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#333399\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','33','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#3333cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','33','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#3333ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','33','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#663300\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','33','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#663333\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','33','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#663366\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','33','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#663399\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','33','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#6633cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','33','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#6633ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','33','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#993300\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','33','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#993333\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','33','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#993366\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','33','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#993399\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','33','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9933cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','33','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9933ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','33','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc3300\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','33','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc3333\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','33','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc3366\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','33','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc3399\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','33','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc33cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','33','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc33ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','33','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff3300\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','33','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff3333\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','33','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff3366\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','33','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff3399\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','33','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff33cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','33','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff33ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','33','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#006600\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','66','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#006633\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','66','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#006666\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','66','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#006699\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','66','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#0066cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','66','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#0066ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','66','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#336600\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','66','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#336633\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','66','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#336666\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','66','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#336699\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','66','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#3366cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','66','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#3366ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','66','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#666600\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','66','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#666633\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','66','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#666666\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','66','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#666699\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','66','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#6666cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','66','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#6666ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','66','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#996600\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','66','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#996633\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','66','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#996666\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','66','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#996699\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','66','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9966cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','66','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9966ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','66','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc6600\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','66','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc6633\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','66','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc6666\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','66','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc6699\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','66','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc66cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','66','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc66ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','66','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff6600\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','66','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff6633\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','66','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff6666\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','66','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff6699\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','66','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff66cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','66','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff66ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','66','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#009900\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','99','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#009933\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','99','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#009966\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','99','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#009999\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','99','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#0099cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','99','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#0099ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','99','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#339900\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','99','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#339933\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','99','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#339966\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','99','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#339999\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','99','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#3399cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','99','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#3399ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','99','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#669900\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','99','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#669933\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','99','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#669966\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','99','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#669999\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','99','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#6699cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','99','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#6699ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','99','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#999900\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','99','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#999933\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','99','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#999966\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','99','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#999999\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','99','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9999cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','99','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#9999ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','99','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc9900\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','99','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc9933\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','99','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc9966\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','99','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc9999\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','99','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc99cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','99','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cc99ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','99','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff9900\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','99','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff9933\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','99','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff9966\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','99','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff9999\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','99','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff99cc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','99','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ff99ff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','99','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#00cc00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','cc','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00cc33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','cc','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00cc66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','cc','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00cc99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','cc','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00cccc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','cc','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00ccff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','cc','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33cc00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','cc','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33cc33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','cc','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33cc66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','cc','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33cc99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','cc','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33cccc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','cc','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ccff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','cc','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66cc00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','cc','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66cc33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','cc','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66cc66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','cc','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66cc99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','cc','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66cccc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','cc','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ccff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','cc','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#99cc00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','cc','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99cc33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','cc','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99cc66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','cc','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99cc99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','cc','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99cccc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','cc','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99ccff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','cc','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cccc00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','cc','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cccc33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','cc','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cccc66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','cc','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cccc99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','cc','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#cccccc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','cc','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccccff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','cc','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffcc00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','cc','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffcc33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','cc','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffcc66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','cc','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffcc99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','cc','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffcccc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','cc','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffccff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','cc','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#00ff00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','ff','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00ff33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','ff','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00ff66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','ff','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00ff99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','ff','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00ffcc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','ff','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#00ffff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('00','ff','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ff00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','ff','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ff33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','ff','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ff66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','ff','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ff99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','ff','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ffcc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','ff','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#33ffff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('33','ff','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ff00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','ff','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ff33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','ff','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ff66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','ff','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ff99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','ff','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ffcc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','ff','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#66ffff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('66','ff','ff');return false;\">&nbsp;</a></td>
        </tr>
        <tr>
        <td bgcolor=\"#99ff00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','ff','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99ff33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','ff','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99ff66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','ff','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99ff99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','ff','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99ffcc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','ff','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#99ffff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('99','ff','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccff00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','ff','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccff33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','ff','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccff66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','ff','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccff99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','ff','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccffcc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','ff','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ccffff\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('cc','ff','ff');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffff00\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','ff','00');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffff33\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','ff','33');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffff66\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','ff','66');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffff99\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','ff','99');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffffcc\" width=\"5\" height=\"5\"><a href=\"\" onClick=\"setzewert('ff','ff','cc');return false;\">&nbsp;</a></td>
        <td bgcolor=\"#ffffff\" width=\"5\" height=\"5\">&nbsp;</td>
        </tr>
        </table>\n");

      echo("<table border=\"1\">
          <tr>
          <td colspan=\"3\" height=\"30\" align=\"center\">current color</td>
          <td height =\"30\" colspan=\"1\" bgcolor=\"".$alliance["color"]."\">&nbsp;</td>
          </tr>
          <tr>
          <td style=\"color:red;\">red</td>
          <td style=\"color:green;\">green</td>
          <td style=\"color:blue;\">blue</td>
          <td rowspan=\"4\" bgcolor=\"#ff00ff\" id=\"showfarbe\" width=\"50\" style=\"border-style:none; border-width:thin;\">
          <layer height=\"50\" width=\"50\" left=\"445\" top=\"500\" id=\"farbzeign\">
          &nbsp;
          </layer>
          </td>
          </tr>
          <tr>
          <form id=\"farb_form\" name=\"farb_form\" onReset=\"this.reset()\" action=\"".$PHP_SELF."\" method=post>
          <td>
          <input size=\"3\" maxlength=\"3\" id=\"feld_rot\" value=\"255\"></input>
          </td>
          <td>
          <input size=\"3\" maxlength=\"3\" id=\"feld_gruen\" value=\"0\"></input>
        </td>
        <td>
        <input size=\"3\" maxlength=\"3\" id=\"feld_blau\" value=\"255\"></input>
        </td>
        </tr>
        <tr>
        <td colspan=\"3\" align=\"center\">
        <input type=\"button\" value=\"test\" onClick=\"farb_auswahl();return false;\" id=\"test\"></input>
        </td>
        </tr>
        <tr>
        <td align=\"center\">
        <input name=\"test0\" id=\"test0\" size=\"2\" maxlength=\"2\" readonly=\"\"></input>
        </td>
        <td align=\"center\">
        <input name=\"test1\" id=\"test1\" size=\"2\" maxlength=\"2\" readonly=\"\"></input>
        </td>
        <td align=\"center\">
        <input name=\"test2\" id=\"test2\" size=\"2\" maxlength=\"2\" readonly=\"\"></input>
        </td>
        </tr>
        <tr>
        <td align=\"right\" colspan=\"4\" height=\"10\">
        <input type=hidden name=\"act\" value=\"save_color\">
        <input type=\"submit\" value=\"use\"></input>
        </form>
        </td>
        </tr>
        </table>
        </center>
        \n");

}

function resign()
{
  global $uid;

  $sth=mysql_query("select a.id,a.leader,a.devminister,a.milminister,a.forminister from alliance a,users u where u.alliance=a.id and u.id=".$uid);

  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("ERR::GET INFOS");
    return false;
  }

  $alliance=mysql_fetch_assoc($sth);

  // mop: hatter denn nen posten?
  switch ($uid)
  {
    case $alliance["leader"]:
      $field="leader";
      $text="Leader";
      break;
    case $alliance["devminister"]:
      $field="devminister";
      $text="Minister of Development";
      break;
    case $alliance["forminister"]:
      $field="forminister";
      $text="Foreign Minister";
      break;
    case $alliance["milminister"]:
      $field="milminister";
      $text="Minister of Defence";
      break;
    default:
      $field=false;
  }

  if (!$field)
  {
    show_error("EVIL! EVIL!");
    return false;
  }

  $sth=mysql_query("update alliance set ".$field."=0 where id=".$alliance["id"]);

  if (!$sth)
  {
    show_error("ERR::RESIGN");
    return false;
  }

  show_menu();
  show_message("You have resigned as ".$text);
  
  // mop: leute informieren
  $members=get_alliance_members($alliance["id"]);

  foreach ($members as $uid => $name)
    ticker($uid,"Your ".$text." has resigned!","w");
}

function vote()
{
  global $uid;
  global $id;

  $sth=mysql_query("select * from votes where uid=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("You have already voted!");
    return 0;
  }

  if ($id==$uid)
  {
    show_message("Don't try it!");
    return 0;
  }

  $sth=mysql_query("select alliance from users where id=$id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("asdf!");
    return 0;
  }

  $sth=mysql_query("select alliance from users where id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select alliance from users where id=$id and alliance=".$alliance["alliance"]);

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("asdf!");
    return 0;
  }

  $sth=mysql_query("select * from vote where aid=".$alliance["alliance"]);

  if (!$sth)
  {
    show_error("No Vote in progress!=§");
    return 0;
  }

  $sth=mysql_query("insert into votes (aid,uid,vote) values ('".$alliance["alliance"]."','$uid','$id')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  show_message("Voting finished!");

}

function save_color()
{
  global $uid;
  global $test0;
  global $test1;
  global $test2;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,leader from alliance where leader='$uid'");

  if (mysql_num_rows($sth)==0)
  {
    show_error("You're not a leader of an alliance. Your email has been forwarded to some spammers. \$5 for me and lots of spam for you. Perhaps you won't try to hack anymore now:)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("update alliance set color='#".$test0.$test1.$test2."' where id=".$alliance["id"]);

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  show_message("Color has been set!");
}

function forum()
{
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select alliance from users where id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $aid=mysql_fetch_row($sth);

  $sth=mysql_query("select f.topic,u.name,f.time,f.id,f.lastpost from forums as f,users as u where f.aid=".$aid[0]." and f.fid is NULL and u.id=f.uid order by f.lastpost DESC");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  center_headline("Alliance forum");

  if (mysql_num_rows($sth)==0)
    show_message("There are no entrys so far!");
  else
  {
    table_start("center","500");
    table_head_text(array("Messages"),"4");
    table_text(array("&nbsp;"),"","","4","text");
    table_text(array("Topic","Posted by","Date","Last Post"),"center","","","head");
  }

  while ($topics=mysql_fetch_array($sth))
  {
    table_text(array("<a href=\"".$PHP_SELF."?act=show_topic&id=".$topics["id"]."\">".$topics["topic"]."</A>",$topics["name"],substr($topics["time"],5,11),substr($topics["lastpost"],5,11)),"center","","","text");
  }
  table_text(array("&nbsp;"),"","","4","none");
  table_text(array("<a href=\"".$PHP_SELF."?act=new_topic&art=alliance\">New Topic</a>"),"left","","4","none");
  table_end();
}

function new_topic()
{
  global $uid;
  global $PHP_SELF;
  global $art;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  echo("<form action=\"".$PHP_SELF."\" method=post>");

  table_border_start("center","500","#302859","#140f55","#f1edfc");
  table_head_text(array("Start a new Topic"),"2");
  table_form_text("Topic","topic");
  table_form_textarea("Content","content");
  if ($art=="foreign")
  {
    $sth=mysql_query("select id from alliance where forminister=$uid");

    if(!$sth)
    {
      show_message("Database Failure");
      return 0;
    }

    if($sth==0)
    {
      show_message("HACKER! HACKER! muahhahhhahha get off");
      return 0;
    }

    table_form_submit("Post","topic_forpost");
  }
  else
    table_form_submit("Post","topic_post");
  table_end();
  echo("</form>");
}

function topic_post()
{
  global $uid;
  global $content;
  global $topic;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select alliance from users where id=$uid");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $aid=mysql_fetch_row($sth);

  $sth=mysql_query("insert into forums (topic,text,aid,uid,time,lastpost) values ('".nl2br(strip_tags($topic))."','".nl2br(strip_tags($content))."','".$aid[0]."','$uid','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s")."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
}


function show_topic()
{
  global $uid;
  global $id;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }
  
  $sth = mysql_query("select 1 from forums f join users u on f.aid = u.alliance where u.id = ".$uid." and f.id = ".$id);
  
  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("ERROR::SHOW TOPIC You have been marked as an exploit user.!");
    return false;
  }
  
  
  $sth=mysql_query("select * from forums as f,alliance as a,users as u where a.id=u.alliance and a.id=f.aid and u.id=f.uid and (f.id=$id or f.fid=$id) order by f.time");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  while ($postings=mysql_fetch_array($sth))
  {
    if ($postings["fid"]==NULL)
    {
      table_start("center","500");
      table_text(array("<a href=\"".$PHP_SELF."?act=forum\">alliance forum</a> : ".$postings["topic"]),"","","2");
      table_head_text(array($postings["topic"]),"2");
      table_text(array("&nbsp;"),"","","2","text");
    }
    table_text_open("head","left");
    table_text_design("<strong>".$postings["name"]."</strong>","100","","","head");
    table_text_design(substr($postings["time"],5,11),"400","right","","smallhead");
    table_text_close();
    table_text_open("head","left");
    table_text_design("&nbsp;","100","","","smallhead");
    table_text_design("".$postings["text"]."","400","","","text");
    table_text_close();
  }
  table_text(array("&nbsp;"),"","","2","none");
  table_text(array("<a href=\"".$PHP_SELF."?act=reply&id=".$id."\">Reply</a>"),"","","2","none");
  table_end();
}



function reply()
{
  global $id;
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth = mysql_query("select 1 from forums f join users u on f.aid = u.alliance where u.id = ".$uid." and f.id = ".$id);
  
  if (!$sth || mysql_num_rows($sth)==0)
  {
    show_error("ERROR:: REPLY You have been marked as an exploit user.!");
    return false;
  }

  //  $sth=mysql_query("select f.id,f.text from forums as f,users as u where u.alliance=f.aid and u.id=$uid and f.id=$id");

  $sth=mysql_query("select f.*,a.id as name from forums as f,alliance as a,users as u where a.id=u.alliance and a.id=f.aid and u.id=$uid and (f.id=$id or f.fid=$id) order by f.time desc limit 1");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Sending all processes the TERM signal");
    return 0;
  }

  $posting=mysql_fetch_array($sth);

  $sth=mysql_query("select name from users where id=".$posting["uid"]);

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $poster=mysql_fetch_array($sth);

  echo("<form action=\"".$PHP_SELF."\" method=post>");

  table_start("center","500");
  table_text_open("head");
  table_text_design("<strong>".$poster["name"]."</strong>","100","","","head");
  table_text_design($posting["time"],"400","right","","smallhead");
  table_text_close();
  table_text_open("head","left");
  table_text_design("&nbsp;","100","","","smallhead");
  table_text_design("".$posting["text"]."","400","","","text");
  table_text_close();
  table_end();
  echo("<br>\n");
  table_border_start("center","500","#302859","#140f55","#f1edfc");
  table_head_text(array("Reply"),"2");
  table_form_textarea("Content","content");
  form_hidden("id",$id);
  table_form_submit("Post","proc_reply");
  table_end();
  echo("</form>");
}

function proc_reply()
{
  global $id;
  global $content;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select u.alliance from forums as f,users as u where u.alliance=f.aid and u.id=$uid and f.id=$id");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Sending all processes the TERM signal");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("insert into forums (text,aid,uid,fid,time) values ('".nl2br(strip_tags($content))."','".$alliance["alliance"]."','$uid','".$id."','".date("Y-m-d H:i:s")."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  $sth=mysql_query("update forums set lastpost='".date("Y-m-d H:i:s")."' where id='$id'");

  if (!$sth)
  {
    show_error("Databasse failure!");
    return 0;
  }

}

function show_info()
{
  global $PHP_SELF;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth = mysql_query("select a.*,u.alliance from alliance as a, users as u where u.id=$uid and u.alliance=a.id");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $info=mysql_fetch_array($sth);

  center_headline("Alliance Info");
  table_start("center","500");
  table_head_text(array("Alliance Picture"));

  if ($info["picture"]!="")
    table_text(array("<img src=\"".$info["picture"]."\" alt=\"".$info["name"]."\">"));
  else
    table_text(array("No picture defined"),"center","","","text");

  if ($info["url"]!="")
    table_text(array("<a href=\"".$info["url"]."\" target=\"_blank\">".$info["url"]."</a>"),"center");
  else
    table_text(array("No Homepage available"),"center","","","text");
  table_end();
  echo("<br><br>\n");

  table_start("center","500");
  table_head_text(array("Alliance Information"));
  table_text(array("&nbsp;"),"","","","head");

  if ($info["info"]!="")
    table_text(array(nl2br($info["info"])),"","","","text");
  else
    table_text(array("The lazy leader didn't enter any information about his alliance"),"","","","text");
  table_end();
  echo("<br><br>\n");

  if ($info["leader"]==$uid)
  {
    table_border_start("center","500","#302859");
    table_head_text(array("Leader Options"),"3");
    table_text(array("&nbsp;"),"center","","3","text");
    table_text(array("Set Picture URL"),"center","","3","head");
    echo("<form method=\"post\" action=\"".$PHP_SELF."\">\n");
    table_text(array("current url: ".$info["picture"].""),"","","3","text");
    table_form_text("New URL","url","","40","");
    table_form_submit("Set URL","setpic","2","text");
    echo("</form>\n");
    table_text(array("&nbsp;"),"center","","3","text");
    table_text(array("Set Alliancesymbol (small picture for the map)"),"center","","3","head");
    echo("<form method=\"post\" action=\"".$PHP_SELF."\">\n");
    table_text(array("current url: ".$info["symbol"].""),"","","3","text");
    table_form_text("New URL","symbolurl",$symbolurl,"40","");
    table_form_submit("Set URL","setsymbol","2","text");
    echo("</form>\n");
    table_text(array("Please enter the full the URL of a picture (e.g: http://www.example.net/example.jpg) and note that only .jpg, .gif and .png pictures are allowed. The alliancesymbol may also be a svg.<br>Choose a picture as small as possible to prevent annoying loading times.<br>Also note that any pictures,symbols represening organisations, countrys, partys etc. that exist or existed will not be tolerated exspecially those that abuse and/or are forbidden through german or international law."),"","","3","textnote");
    table_text(array("&nbsp;"),"center","","3","text");
    echo("<form method=\"post\" action=\"".$PHP_SELF."\">\n");
    table_text(array("Set Alliance Information"),"center","","3","head");
    table_form_textarea("New Info","dasinfo",$dasinfo,"40","10");
    table_form_submit("Set info",setinfo,"","text");
    echo("</form>\n");
    table_text(array("&nbsp;"),"center","","3","text");
    echo("<form method=\"post\" action=\"".$PHP_SELF."\">\n");
    table_text(array("Set Alliance Homepage"),"center","","3","head");
    table_text(array("current url: ".$info["url"].""),"","","3","text");
    table_form_text("New URL","homepage",$homepage,"40","");
    table_form_submit("Set homepage-URL",sethomepage,"","text");
    echo("</form>\n");
    table_text(array("Please enter the full the URL of an Alliance Homepage (e.g: http://www.example.net/)"),"","","3","textnote");
    table_end();
  }
}

function set_homepage()
{
  global $homepage;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.picture,a.id, u.alliance from alliance as a, users as u where u.id=$uid and u.alliance=a.id");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);
  if ($homepage!="")
    $sth=mysql_query("update alliance set url='".$homepage."' where id=".$alliance["id"]."");
  else
    show_message("I guess you should enter the URL of your Alliance's Homepage!");

}


function set_info()
{
  global $dasinfo;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.picture,a.id, u.alliance from alliance as a, users as u where u.id=$uid and u.alliance=a.id");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);
  if ($dasinfo!="")
    $sth=mysql_query("update alliance set info='".$dasinfo."' where id=".$alliance["id"]."");
  else
    show_message("Please enter more information that zero!");

}

function set_pic()
{
  global $url;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.picture,a.id, u.alliance from alliance as a, users as u where u.id=$uid and u.alliance=a.id and a.leader=".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);
  $checkstr = strrchr($url,".");

  if (($checkstr==".jpg")||($checkstr==".gif")||($checkstr==".png"))
    $sth=mysql_query("update alliance set picture ='".$url."' where id=".$alliance["id"]."");
  else
    show_message($url." is not a valid url for a picture");

}

function set_symbol()
{
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.picture,a.id, u.alliance from alliance as a, users as u where u.id=$uid and u.alliance=a.id and a.leader=".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  if (preg_match("/\.(jpe?g|png|svgz?|gif)$/i",$_POST["symbolurl"]))
    $sth=mysql_query("update alliance set symbol ='".$_POST["symbolurl"]."' where id=".$alliance["id"]."");
  else
    show_message($_POST["symbolurl"]." is not a valid url for a picture");

}

function show_parliament()
{
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.*, u.alliance from alliance as a, users as u where u.id=$uid and u.alliance=a.id");


  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  center_headline("Parliament");
  table_start("center","500");
  table_head_text(array("Current Ministers"),"2");
  table_text(array("Minister","Name"),"center","","","head");
  table_text_open();

  table_text_design("Leader","250","","","head");
  if ($alliance["leader"]!="0")
  {
    $sth=mysql_query("select name from users where id=".$alliance["leader"]."");
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
    $minister=mysql_fetch_array($sth);
    table_text_design($minister["name"],"250","","","text");
  }
  else
    table_text_design("Noone appointed","250","","","text");
  table_text_close();

  table_text_design("Minister of Developement","250","","","head");
  if ($alliance["devminister"]!="0")
  {
    $sth=mysql_query("select name from users where id=".$alliance["devminister"]."");
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
    $minister=mysql_fetch_array($sth);
    table_text_design($minister["name"],"250","","","text");
  }
  else
    table_text_design("Noone appointed","250","","","text");
  table_text_close();

  table_text_design("Minister of Defence","250","","","head");
  if ($alliance["milminister"]!="0")
  {
    $sth=mysql_query("select name from users where id=".$alliance["milminister"]."");
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
    $minister=mysql_fetch_array($sth);
    table_text_design($minister["name"],"250","","","text");
  }
  else
    table_text_design("Noone appointed","250","","","text");
  table_text_close();

  table_text_design("Foreign Minister","250","","","head");
  if ($alliance["forminister"]!="0")
  {
    $sth=mysql_query("select name from users where id=".$alliance["forminister"]."");
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }
    $minister=mysql_fetch_array($sth);
    table_text_design($minister["name"],"250","","","text");
  }
  else
    table_text_design("Noone appointed","250","","","text");
  table_text_close();
  table_end();
  echo("<br><br>\n");

  if ($alliance["leader"]==$uid)
  {
    $sth=mysql_query("select name, id from users where alliance=".$alliance["id"]." order by name");
    if (!$sth)
    {
      show_message("Database Failure");
      return 0;
    }

    table_border_start("center","500","#302859");
    table_head_text(array("Your options as leader"),"3");
    table_text(array("&nbsp;"),"","","3","text");
    table_text(array("appoint a minister"),"","","3","head");

    if (($alliance["devminister"]=="0")||($alliance["milminister"]=="0")||($alliance["forminister"]=="0"))
    {
      echo("<form method=\"post\" action=\"".$PHP_SELF."\">\n");
      table_text_open();
      echo("<td class=\"head\" colspan=\"3\">appoint\n");
      echo("<select name=\"userid\" size=\"1\">\n");
      while ($user=mysql_fetch_array($sth))
      {
        if (($user["id"]!=$alliance["leader"])&&($user["id"]!=$alliance["devminister"])&&($user["id"]!=$alliance["milminister"])&&($user["id"]!=$alliance["forminister"]))
          echo("<option value=\"".$user["id"]."\">".$user["name"]."\n");
      }
      echo("</select> as \n");
      echo("<select name=\"minister\" size=\"1\">\n");
      echo("<option value=\"1\">Minister of Developement\n");
      echo("<option value=\"2\">Minister of Defence\n");
      echo("<option value=\"3\">Foreign Minister\n");
      echo("</select>\n");
      echo("</td>\n");
      table_form_submit("appoint",appoint,"","text");
      table_text_close();
      echo("</form>\n");
    }


    table_text(array("Dismiss a minister"),"","","3","head");
    if ($alliance["devminister"]!="0")
    {
      $sth=mysql_query("select name from users where id=".$alliance["devminister"]."");

      if (!$sth)
      {
        show_message("Database Failure");
        return 0;
      }
      $minister=mysql_fetch_array($sth);
      table_text(array("<a href=\"".$PHP_SELF."?act=dismiss&minister=devminister\">Dismiss ".$minister["name"]." as Minister of Developement</a>"),"","","3","text");
    }
    if ($alliance["milminister"]!="0")
    {
      $sth=mysql_query("select name from users where id=".$alliance["milminister"]."");

      if (!$sth)
      {
        show_message("Database Failure");
        return 0;
      }
      $minister=mysql_fetch_array($sth);
      table_text(array("<a href=\"".$PHP_SELF."?act=dismiss&minister=milminister\">Dismiss ".$minister["name"]." as Minister of Defence</a>"),"","","3","text");
    }
    if ($alliance["forminister"]!="0")
    {
      $sth=mysql_query("select name from users where id=".$alliance["forminister"]."");

      if (!$sth)
      {
        show_message("Database Failure");
        return 0;
      }
      $minister=mysql_fetch_array($sth);
      table_text(array("<a href=\"".$PHP_SELF."?act=dismiss&minister=forminister\">Dismiss ".$minister["name"]." as Foreign Minister</a>"),"","","3","text");
    }
  }

}

function dismiss_minister()
{
  global $minister;
  global $uid;

  $sth=mysql_query("select id from alliance where leader=".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  if (mysql_numrows($sth)==0)
  {
    show_message("You little cheater you!");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select * from vote where aid=".$alliance["id"]."");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("There's currently a vote in progress!");
    return 0;
  }


  $sth=mysql_query("update alliance set ".$minister."=0 where leader=$uid");
  show_message("Minister has been dismissed");

  $sth=mysql_query("select id from users where alliance=".$alliance["id"]."");

  if (!$sth)
  {
    show_message("Dastabse Failure");
    return 0;
  }

  switch ($minister)
  {
    case "devminister":
      $text="Your leader dismissed the Minister of Developement";
    break;
    case "milminister":
      $text="Your leader dismissed the Minister of Defence";      
    break;
    case "forminister":
      $text="Your leader dismissed the Foreign Minister";
    break;
  }

  while ($members=mysql_fetch_array($sth))
    $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$members["id"]."','w','".$text."','".date("YmdHis")."')");
}

function appoint_minister()
{
  global $minister;
  global $userid;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id from alliance where leader=".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("I got a BIG brownie for ya!");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("select * from vote where aid=".$alliance["id"]."");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)>0)
  {
    show_message("There's currently a vote in progress!");
    return 0;
  }

  $sth=mysql_query("select name from users where id=".$userid."");

  if (!$sth)
  {
    show_message("Dastabbse Failure");
    return 0;
  }

  $milname=mysql_fetch_array($sth);


  switch ($minister)
  {
    case "1":
      $sth=mysql_query("update alliance set devminister=".$userid." where leader=$uid");
    $text="Your leader appointed ".$milname["name"]." as your new Minister of Developement";
    break;
    case "2":
      $sth=mysql_query("update alliance set milminister=".$userid." where leader=$uid");
    $text="Your leader appointed ".$milname["name"]." as your new Minister of Defence";
    break;
    case "3":
      $sth=mysql_query("update alliance set forminister=".$userid." where leader=$uid");
    $text="Your leader appointed ".$milname["name"]." as your new Foreign Minister";
    break;
  }
  show_message("Minister has been appointed");


  $sth=mysql_query("select id from users where alliance=".$alliance["id"]."");

  if (!$sth)
  {
    show_message("Dastabse Failure");
    return 0;
  }

  while ($members=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$members["id"]."','w','".$text."','".date("YmdHis")."')");
  }
}

function show_foreign_forum()
{
  global $PHP_SELF;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.id,a.name,u.name as u_name from users u left join alliance a on u.id = a.forminister where u.id =".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return false;
  }

  $alliance = mysql_fetch_array($sth);

  if ($alliance["name"] == null)
    show_message("You are not a Foreign Minister! You can read but not write.");

  $sth=mysql_query("select * from foreignforum where fid is NULL order by time DESC");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  center_headline("Foreign Ministers Forum");

  if (mysql_num_rows($sth)==0)
    show_message("There are no entrys so far!");
  else
  {
    table_start("center","500");
    table_head_text(array("Messages"),"3");
    table_text(array("&nbsp;"),"","","3","text");
    table_text(array("Topic","Posted by","Date"),"center","","","head");
  }

  while ($topics=mysql_fetch_array($sth))
  {
    $sth1=mysql_query("select a.name as aname,u.name as uname from users as u,alliance as a where u.alliance=a.id and u.id=".$topics["uid"]);

    if (!$sth1)
    {
      show_error("Database failure!");
      return 0;
    }

    $forumnames=mysql_fetch_array($sth1);

    table_text(array("<a href=\"".$PHP_SELF."?act=show_foreign_topic&id=".$topics["id"]."\">".$topics["topic"]."</A>",$forumnames["aname"]." (".$forumnames["uname"].")",$topics["time"]),"center","","","text");
  }
  table_text(array("&nbsp;"),"","","3","none");
  if ($alliance["name"] != null)
    table_text(array("<a href=\"".$PHP_SELF."?act=new_topic&art=foreign\">New Topic</a>"),"left","","3","none");
    
  table_end();
}

function topic_forpost()
{
  global $PHP_SELF;
  global $uid;
  global $content;
  global $topic;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,name from alliance where forminister=$uid");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("You are not a Foreign Minister!");
    return false;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("insert into foreignforum (aid,uid,topic,text,time) values ('".$alliance["id"]."','$uid','".nl2br(strip_tags($topic))."','".nl2br(strip_tags($content))."','".date("Y-m-d H:i:s")."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }
}

function show_foreign_topic()
{
  global $uid;
  global $id;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select a.id,a.name,u.name as u_name from users u left join alliance a on u.id = a.forminister where u.id =".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return false;
  }
  
  $alliance = mysql_fetch_array($sth);
  
  if ($alliance["name"] == null)
    show_message("You are not a Foreign Minister! You can read, but not write!");


  $sth=mysql_query("select * from foreignforum where id=$id or fid=$id order by time");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  while ($postings=mysql_fetch_array($sth))
  {
    if ($postings["fid"]==NULL)
    {
      table_start("center","500");
      table_text(array("<a href=\"".$PHP_SELF."?act=show_foreign_forum\">Foreign Minister Forum</a> : ".$postings["topic"]),"","","2");
      table_head_text(array($postings["topic"]),"2");
      table_text(array("&nbsp;"),"","","2","text");
    }
    table_text_open("head","left");
    $sth1=mysql_query("select a.name as aname,u.name as uname from alliance as a, users as u where a.id=".$postings["aid"]." and u.id=".$postings["uid"]."");
    $user=mysql_fetch_array($sth1);
    if (!$sth1)
    {
      show_error("Database failure!");
      return 0;
    }
    table_text_design("<strong>".$user["aname"]."</strong> (".$user["uname"].")","100","","","head");
    table_text_design($postings["time"],"400","right","","smallhead");
    table_text_close();
    table_text_open("head","left");
    table_text_design("&nbsp;","100","","","smallhead");
    table_text_design("".$postings["text"]."","400","","","text");
    table_text_close();
  }
  table_text(array("&nbsp;"),"","","2","none");
  if ($alliance["name"] != null)
    table_text(array("<a href=\"".$PHP_SELF."?act=foreignreply&id=".$id."\">Reply</a>"),"","","2","none");
  table_end();
}

function foreignreply()
{
  global $id;
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select *,a.name as aname, u.name as uname from foreignforum as f,alliance as a,users as u where (f.id=$id or f.fid=$id) order by f.time desc");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("Sending all processes the TERM signal");
    return 0;
  }

  $posting=mysql_fetch_array($sth);

  echo("<form action=\"".$PHP_SELF."\" method=post>");

  table_start("center","500");
  table_text_open("head");
  table_text_design("<strong>".$posting["aname"]."</strong> (".$posting["uname"]."","100","","","head");
  table_text_design($posting["time"],"400","right","","smallhead");
  table_text_close();
  table_text_open("head","left");
  table_text_design("&nbsp;","100","","","smallhead");
  table_text_design("".$posting["text"]."","400","","","text");
  table_text_close();
  table_end();
  echo("<br>\n");
  table_border_start("center","500","#302859","#140f55","#f1edfc");
  table_head_text(array("Reply"),"2");
  table_form_textarea("Content","content");
  form_hidden("id",$id);
  table_form_submit("Post","proc_foreignreply");
  table_end();
  echo("</form>");
}

function proc_foreignreply()
{
  global $id;
  global $content;
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,name from alliance where forminister=$uid");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("You are not a Foreign Minister! Stop hacking now!");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("insert into foreignforum (aid,uid,topic,text,time,fid) values ('".$alliance["id"]."','$uid','".nl2br(strip_tags($topic))."','".nl2br(strip_tags($content))."','".date("Y-m-d H:i:s")."','".$id."')");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

}

function leave_alliance()
{
  global $uid;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }
  $sth=mysql_query("select a.name,u.alliance from alliance as a, users as u where a.id=u.alliance and u.id not in (a.milminister, a.leader, a.forminister, a.devminister) and u.id=".$uid);

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("No matter what, that was a hack attempt. ;)");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  table_start("center","500");
  table_head_text(array("Warning"));
  table_text(array("&nbsp;"),"","","","head");
  table_text(array("You are going to leave the alliance ".$alliance["name"]."! <br> You'll become neutral<br>You'll recieve an 'Alliance Lock' of 7 days.<br>Only your 3 best planets will produce.<br> Are you sure?"),"","","","text");
  table_text(array("<a href=\"".$PHP_SELF."?act=proc_leave\">Yes, I want to leave</a> <a href=\"".$PHP_SELF."?act=show_alliance\">Cancel</a>"),"right","","","head");
}

function proc_leave()
{
  global $uid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }
  $sth=mysql_query("select u.alliance from users u, alliance a where a.id = u.alliance and u.id not in (a.milminister, a.leader, a.forminister, a.devminister) and u.id=".$uid);

  if (!$sth)
  {
    show_message("Database Failure C1");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("AgaFu Bloeck");
    return 0;
  }

  if (!remove_from_alliance($uid))
  {
    show_error("ERR::REMOVE FROM ALLIANCE");
    return false;
  }

  $homeworld=get_homeworld($uid);

  // mop: eigentlich suboptimal. dann kommt die ganze flotte zum heimatplaneten (also auch kriegsschiffe) 
  $sth=mysql_query("update fleet_info set sid=".get_sid_by_pid($homeworld).",pid=$homeworld where uid=$uid");

  if (!$sth)
    show_error("Database failure!");

  show_message("Your fleets have been moved to your homeplanet!");
  show_message("You have left the alliance");

}

function proc_dropInvitation()
{
  global $uid;
  global $id;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $sth=mysql_query("select id,name from alliance where leader=$uid");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  if (mysql_num_rows($sth)<=0)
  {
    show_message("Dead End");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  $sth=mysql_query("delete from invitations where aid=".$alliance["id"]." and uid=$id");

  if (!$sth)
  {
    show_message("Remove failed");
    return 0;
  }

  $sth=mysql_query("insert into ticker (uid,type,text,time) values ('$id','w','The alliance: ".$alliance["name"]." removed your alliance invitation','".date("YmdHis")."')");

  if (!$sth)
  {
    show_message("DB Failure :Messaging Victim failed");
    return 0;
  }

}

function show_diplomacy()
{
  global $uid;
  global $start;
  global $PHP_SELF;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $aid = get_alliance($uid);
  $is_leader = is_leader($uid, $aid);
  
  $sth = mysql_query("select a.name, d.alliance2, d.status, if(status = 0, 0,(if(status=1, 2, 1))) as my_order from diplomacy d, alliance a where d.alliance1='".$aid."' and a.id = d.alliance2 order by my_order, a.name");
  
  if (!$sth) {
    echo("ERR::DIPLOMACY, could not get relationships");
    return false;
  }
  
  table_start("center", "500");
  table_head_text(array("Galactic diplomacy status"),2);
  table_text_open("head","center");
  table_text_design("&nbsp","27","left","","head");
  table_text_design("&nbsp","","left","","head");
  table_text_close();
  
  if (mysql_num_rows($sth) > 0) 
  {
    while ($diplomacy = mysql_fetch_assoc($sth)) {
      if ($diplomacy["status"] == 0) {
        $dip_image = "arts/alliance_enemy.gif";
        $alt = "Enemy";
      }
      elseif($diplomacy["status"] == 2) {
        $dip_image = "arts/alliance_friend.gif";
        $alt = "Enemy";
      }
      else {
        $dip_image = false;
        $alt = false;
      }
      
      table_text_open("head","center");
      table_text_design("<img src=\"".$dip_image."\" width=\"25\" height=\"25\" alt=\"".$alt."\" border=\"0\" />","27","center","","text");
      table_text_design("<a href=\"database.php?act=info_alliance&aid=".$diplomacy["alliance2"]."\">".$diplomacy["name"]."</a>","","left","","text");
      table_text_close();
    }
  }
  else
    table_text(array("no relations to other alliances"),"center","","2","text");  
  table_end();

  //***********************+  

  $alliances=get_alliances($aid,true);

  table_start("center","500");
  table_head_text(array("Status"),2);
  table_text(array("&nbsp;"),"","",2,"head");

  if (sizeof($alliances)==0)
  {
    table_text(array("No alliances so far"),"","",2,"text");
  }
  else
  {
    for ($i=0;$i<sizeof($alliances);$i++)
    {
      table_text(array(get_alliance_name($alliances[$i]),get_diplomatic_status_text(get_diplomatic_status($aid,$alliances[$i]))),"","","","text");
      if (is_leader($uid,$aid))
      {
        $pending_status=get_pending_diplomacy_change($aid,$alliances[$i]);
        $f_pending_status=get_pending_diplomacy_change($alliances[$i],$aid);

        if ($pending_status)
        {
          table_text(array("&nbsp;",get_diplomatic_status_text($pending_status)." status pending <a href=\"".$PHP_SELF."?act=drop_pending&aid2=".$alliances[$i]."&aid1=".$aid."\">Drop</a>"),"","","","head");
        }
        elseif ($f_pending_status)
        {
          table_text(array("&nbsp;",get_diplomatic_status_text($f_pending_status)." status awaiting your approval <a href=\"".$PHP_SELF."?act=drop_pending&aid1=".$alliances[$i]."&aid2=".$aid."\">Drop</a> <a href=\"".$PHP_SELF."?act=accept_pending&faid=".$alliances[$i]."\">Accept</a>"),"","","","head");
        }
        else
        {
          table_text(array("&nbsp;","<a href=\"".$PHP_SELF."?act=change_diplomacy&faid=".$alliances[$i]."&new_status=0\" onclick=\"javascript:return confirm('Are you sure you want to declare war?');\">Change to <span style=\"color: #FF0000\">Enemy</span></a>&nbsp;|&nbsp;<a href=\"".$PHP_SELF."?act=change_diplomacy&faid=".$alliances[$i]."&new_status=1\">Change to <span style=\"color: #FFFF00\">Neutral</span></a>&nbsp;|&nbsp;<a href=\"".$PHP_SELF."?act=change_diplomacy&faid=".$alliances[$i]."&new_status=2\">Change to <span style=\"color: #00FF00\">Friend</span></a>"),"","","","head");
        }
      }
    }
  }
  table_text(array("&nbsp;"),"","",2,"head");

  table_end();
}

function change_diplomacy()
{
  global $uid;
  global $faid;
  global $new_status;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $aid=get_alliance($uid);

  if (!is_leader($uid,$aid))
  {
    show_message("...no");
    return 0;
  }

  if (!is_diplomatic_status($new_status))
  {
    show_message("...nonono");
    return 0;
  }

  if (!alliance_exists($faid))
  {
    show_message("...nonono!!!!!!!!!!!!!!!!!!!!!!!!");
    return 0;
  }

  $old_status=get_diplomatic_status($aid,$faid);

  if ($old_status==$new_status)
  {
    show_message("No change necessary");
    return 0;
  }
  else
  {
    if ($old_status>$new_status)
    {
      if (change_diplomatic_status($aid,$faid,$new_status))
      {        
        // runelord: foreign alliance
        $foreign_leader = get_leader($faid);
        $foreign_allies = get_allied_ids($foreign_leader);
        $status_text    = get_diplomatic_status_text($new_status);

        $alliance_name   = get_alliance_name($aid);
        $foreign_name    = get_alliance_name($faid);

        for ($i = 0; $i < sizeof($foreign_allies); $i++)
        {
          ticker($foreign_allies[$i],"Alliance ".$alliance_name." changed status to ".$status_text,"w");
        }
        ticker($foreign_leader,"*lcommunication.php?act=show_diplomacy*Alliance ".$foreign_name." changed status to ".$status_text,"w");

        // own alliance
        $allies = get_allied_ids($uid);

        for ($i = 0; $i < sizeof($allies); $i++)
        {
          ticker($allies[$i],"Your Leader changend your relationship to Alliance ".$foreign_name." from ".get_diplomatic_status_text($old_status)." to ".$status_text,"w");
        }

        show_message("Status changed");
      }
      else
        show_error("Database failure!");
    }
    else
    {
      request_for_diplomatic_change($aid,$faid,$new_status);
      ticker(get_leader($faid),"*lcommunication.php?act=show_diplomacy*Alliance ".get_alliance_name($aid)." wants to change status to ".get_diplomatic_status_text($new_status),"w");
      show_message("This action will need the approval of the foreign alliance leader!");
    }
  }

}

function drop_pending()
{
  global $uid;
  global $aid1;
  global $aid2;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  if ((!is_leader($uid,$aid1)) && (!is_leader($uid,$aid2)))
  {
    show_message("may the spam fill your mailbox");
    return 0;
  }

  if (drop_pending_diplomatic_request($aid1,$aid2))
    show_message("Request dropped!");
  else
    show_error("Database failure!");

}

function accept_pending()
{
  global $uid;
  global $faid;

  if (has_alliance_lock($uid))
  {
    show_message("You can't use any alliance options due to an alliance lock!");
    return false;
  }

  $aid=get_alliance($uid);

  if (!is_leader($uid,$aid))
  {
    show_message("Be aware of the dark side!");
    return 0;
  }

  $pending_status=get_pending_diplomacy_change($faid,$aid);

  if (!$pending_status)
  {
    show_message("fu! ;)");
    return 0;
  }

  if (!drop_pending_diplomatic_request($faid,$aid))
  {
    show_error("Database failure!");
    return 0;
  }

  if (!change_diplomatic_status($aid,$faid,$pending_status))
  {
    show_error("Database failure2!");
    return 0;
  }

  $f_leader = get_leader($faid);
  $f_allies = get_allied_ids($f_leader);
  ticker($f_leader,"*lcommunication.php?act=show_diplomacy*Alliance ".get_alliance_name($aid)." has accepted your request to change status to ".get_diplomatic_status_text($pending_status),"w");

  for ($i = 0; $i < sizeof($f_allies); $i++)
  {
    ticker($f_allies[$i],"Alliance ".get_alliance_name($aid)." has accepted your leaders request to change status to ".get_diplomatic_status_text($pending_status),"w");    
  }


  $allies = get_allied_ids(get_leader($aid));

  for ($i = 0; $i < sizeof($allies); $i++)
  {
    ticker($allies[$i],"Your leader accepted a request from Alliance ".get_alliance_name($faid)." to change status to ".get_diplomatic_status_text($pending_status),"w");
  }

  show_message("Status changed!");
}

function proc_delete_alliance()
{
  global $uid;

  /** 
   * isser denn auch leader? ;) 
   */
  $sth=mysql_query("select id from alliance where leader=".$uid);

  if (!$sth)
  {
    show_error("ERR::GET ALLIANCE");
    return false;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_error("OMG!!! YOU TRIED TO H4XX=R!!!R!!$!$!!%&");
    return false;
  }

  list($aid)=mysql_fetch_row($sth);
  
  // mop: von allianz entfernen...dabei allianzlock setzen
  if (!remove_from_alliance($uid))
  {
    show_error("ERR::REMOVE ALLIANCE");
    return false;
  }
  
  if (delete_alliance($aid))
    show_message("Your alliance has been deleted!");
}

function broadcast_msg()
{
  global $uid;
  global $PHP_SELF;
  
  // check ob im parlament
  $sth = mysql_query("select 1 from alliance where leader = $uid or devminister = $uid or forminister = $uid or milminister = $uid");
  
  if (!$sth) {
    show_error("ERR::BROADCAST MSG");
    return false;
  }
  
  if (mysql_num_rows($sth) == 0) {
    show_message("You can't broadcast, since you're not in the parliament.");
    return false;
  }
  else {
    table_start("center","500");
    table_text(array("Broadcast"),"left","","2","smallhead");
    echo("<form action=\"".$PHP_SELF."\" method=post>");
    table_form_text("Message (max 255)","message","","50","255","text");
    table_form_submit("Broadcast","proc_broadcast","0");
    echo("</form><br><br>");    
  }  
}

function proc_broadcast_msg()
{
  global $uid;
  $sth = mysql_query("select u.id from users u, alliance a where u.alliance = a.id and ".$uid." in (a.leader, a.forminister, a.milminister, a.devminister)");
  
  if (!$sth || !mysql_num_rows($sth))
  {
    show_error("ERR::PROC BROADCAST");
    return false;
  }
  
  while ($allies = mysql_fetch_array($sth))
  {
    send_ticker_from_to($uid, $allies["id"], "w", $_POST["message"]);
  }
}

switch ($act)
{
  case "proc_leave":
    proc_leave();
  show_menu();
  show_alliance();
  break;
  case "leave_alliance":
    leave_alliance();
  break;
  case "proc_foreignreply":
    proc_foreignreply();
  show_menu();
  show_foreign_topic();
  break;
  case "foreignreply":
    show_menu();
  foreignreply();
  break;
  case "show_foreign_topic":
    show_menu();
  show_foreign_topic();
  break;
  case "topic_forpost":
    topic_forpost();
  show_menu();
  show_foreign_forum();
  break;
  case "show_foreign_forum":
    show_menu();
  show_foreign_forum();
  break;
  case "dismiss":
    dismiss_minister();
  show_menu();
  show_parliament();
  break;
  case "appoint":
    appoint_minister();
  show_menu();
  show_parliament();
  break;
  case "show_parliament":
    show_menu();
  show_parliament();
  break;
  case "sethomepage":
    set_homepage();
  show_menu();
  show_info();
  break;
  case "setinfo":
    set_info();
  show_menu();
  show_info();
  break;
  case "setpic":
    set_pic();
  show_menu();
  show_info();
  break;
  case "setsymbol":
    set_symbol();
  show_menu();
  show_info();
  break;
  case "info":
    show_menu();
  show_info();
  break;
  case "delete_note":
    delete_note();
  show_menu();
  show_journal();
  break;
  case "send_note":
    send_note();
  show_menu();
  show_journal();
  break;
  case "show_journal":
    show_menu();
  show_journal();
  break;
  case "proc_reply":
    proc_reply();
  show_menu();
  show_topic();
  break;
  case "reply":
    show_menu();
  reply();
  break;
  case "show_topic":
    show_menu();
  show_topic();
  break;
  case "forum":
    show_menu();
  forum();
  break;
  case "new_topic":
    show_menu();
  new_topic();
  break;
  case "topic_post":
    topic_post();
  show_menu();
  forum();
  break;
  case "show_alliance":
    show_menu();
  show_alliance();
  break;
  case "found_alliance":
    found_alliance();
  show_menu();
  show_alliance();
  break;
  case "mailforms":
    mailforms();
  break;
  case "edit_mailform":
    edit_mailform();
  break;
  case "proc_edit_mailform":
    proc_edit_mailform();
  show_menu();
  break;
  case "invite":
    invite();
  break;
  case "proc_invite":
    proc_invite();
  show_menu();
  show_alliance();
  break;
  case "join":
    join_alliance();
  show_menu();
  show_alliance();
  break;
  case "kick":
    kick();
  show_menu();
  show_alliance();
  break;
  case "resign":
    resign();
  break;
  case "nojoin":
    nojoin();
  show_menu();
  show_alliance();
  break;
  case "vote":
    vote();
  show_menu();
  show_alliance();
  break;
  case "changecolor":
    show_menu();
  changecolor();
  break;
  case "save_color":
    save_color();
  show_menu();
  show_alliance();
  break;
  case "dropInvitation":
    proc_dropInvitation();
  show_menu();
  show_alliance();
  break;
  case "show_diplomacy":
    show_diplomacy();
  break;
  case "change_diplomacy":
    change_diplomacy();
  show_diplomacy();
  break;
  case "drop_pending":
    drop_pending();
  show_diplomacy();
  break;
  case "accept_pending":
    accept_pending();
  show_diplomacy();
  break;
  case "proc_delete_alliance":
    proc_delete_alliance();
    break;
  case "broadcast":
    show_menu();
    broadcast_msg();
  break;
  case "proc_broadcast":
    proc_broadcast_msg();
    show_menu();
    show_alliance();
  break;
  default:
  show_menu();
  show_alliance();
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
