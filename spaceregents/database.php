<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
 return 0;
  


function find_alliance()
 {
  global $name;

  $sth1 = mysql_query("select * from alliance where name like '%".$name."%'");

  if (!$sth1)
   {
   show_message("Data failure");
   return 0;
   } 

  if ($name!="")
    {
    if (mysql_num_rows($sth1)==0) 
      show_message("No match found");
    else
     { 
     table_start("center","500");
     table_head_text(array("Searchresults"),"4");
     table_text(array("&nbsp;"),"","","4","text");
     table_text(array("Name","&nbsp;","Homepage","Members"),"center","","","head");
     while ($alliance=mysql_fetch_array($sth1))
          {
          $sth2=mysql_query("select count(id) from users where alliance=".$alliance["id"]);

          if (!$sth2)
          {
            show_error("Database failure!");
            return 0;
          }

          $members=mysql_fetch_row($sth2);
         table_text_open();
         table_text_design("<a href=\"".$PHP_SELF."?act=info_alliance&aid=".$alliance["id"]."\">".$alliance["name"]."</a>","220","","","text");
         table_text_design("&nbsp;","20","","","","",$alliance["color"]);
         table_text_design("&nbsp;<a href=\"".$alliance["url"]."\">".$alliance["url"]."</a>","240","","","text");
         table_text_design("&nbsp;".$members[0],"20","","","text");
         table_text_close();
         }   
     table_end();
     echo("<br><br>\n");
    } 
  }
   else
    show_message("Enter a searchstring please");

 }

function alliance_findform()
 {
  global $uid;
  global $PHP_SELF;
  
  $sth=mysql_query("select * from alliance");
  
    if (!$sth)
      {
  show_error("Database failure!");
  return 0;
      }
    
  echo("<br><br>\n");
  table_start("center","500");
    table_head_text(array("Find Alliance"),"2");
    table_text(array("&nbsp;","&nbsp;"),"","","","head");
    echo("<form method=post action=\"".$PHP_SELF."\">\n");
        table_form_text("Alliance","name","".$name."","20","20","text");
        table_form_submit("Find","find_alliance","0");
    table_end();
  echo("</form><br><br>\n");    
 }
  
function show_database()
 {
  global $PHP_SELF;
  global $uid;
  
  $sth=mysql_query("select * from alliance order by name");
  
    if (!$sth)
      {
  show_error("Database failure!");
  return 0;
      }
    
    if (mysql_num_rows($sth)<=0)
    {
   show_message("There are no alliances");
    }
  else
   {
   table_start("center","500");
   table_head_text(array("Current alliances"),"4");
   table_text(array("&nbsp;"),"","","4","text");
     table_text_open("head","center");
      table_text_design("Name","220","","","head");
      table_text_design("&nbsp;","20","","","head");
      table_text_design("Homepage","240","","","head");
      table_text_design("Members","20","","","head");
     table_text_close();
   while ($alliance=mysql_fetch_array($sth))
    {
      $sth2=mysql_query("select count(id) from users where alliance=".$alliance["id"]);

      if (!$sth2)
      {
        show_error("Database failure!");
        return 0;
      }

      $members=mysql_fetch_row($sth2);
      
     table_text_open("text");
      table_text_design("<a href=\"".$PHP_SELF."?act=info_alliance&aname=".$alliance["name"]."&aid=".$alliance["id"]."\">".$alliance["name"]."</a>","","","","text");
    table_text_design("&nbsp;","","","","","",$alliance["color"]);
    table_text_design("&nbsp;<a href=\"".$alliance["url"]."\" class=\"normal\">".$alliance["url"]."</a>","","","","textnote");
    table_text_design("&nbsp;".$members[0],"20","","","text");
    
     table_text_close();
    }
   }
 }

function info_alliance()
 {
  global $aid;
  global $PHP_SELF;
  
  $sth=mysql_query("select * from users where alliance=$aid order by name");
  $sth1=mysql_query("select * from alliance where id=$aid");
  $alliance=mysql_fetch_array($sth1);
  
  if (!$sth)
   {
    show_message("Database failure");
  return 0;
   }

  if (!$sth1)
   {
    show_message("Database failure");
  return 0;
   }
  
  center_headline("Alliance ".$alliance["name"]."");
  echo("<br><br>\n");
  table_start("center","500");
  table_head_text(array("Picture"));
  table_text(array("&nbsp;"),"","","","head");
  if ($alliance["picture"]!="")
       table_text(array("<img src=\"".$alliance["picture"]."\" border=\"0\" align=\"center\">"),"center","","","text");
  else 
       table_text(array("No Picture available"),"center","","","text");

  if ($alliance["url"]!="")
   table_text(array("<a href=\"".$alliance["url"]."\" target=\"_blank\">".$alliance["url"]."</a>"),"center");
  else
   table_text(array("No Homepage available"),"center","","","text");
     
  table_end();
  echo("<br>\n");

  table_start("center","500");
  table_head_text(array("Alliance Information"),"2");
  table_text(array("&nbsp;"),"","","","head");
  if ($alliance["info"]!="")
   table_text(array(nl2br($alliance["info"])),"","","","text");
  else
   table_text(array("No information available"),"","","","text");
  table_end();
  echo("<br>\n");
    
  table_start("center","500");
  table_head_text(array("Members"),"2");
  table_text(array("&nbsp;"),"","","2","text");
  table_text_open("head","center");
   table_text_design("Name","225","center","","head");
   table_text_design("Empire","225","center","","head");
  table_text_close();
  
  
  while ($users=mysql_fetch_array($sth))
   {
    table_text_open();
     switch ($users["id"])
    {
     case ($alliance["leader"]):
        $class="leader";
      $color="#000000";
      break;
     case ($alliance["devminister"]):
        $class="dev";
      $color="#000000";
      break;
     case ($alliance["milminister"]):
        $class="military";
      $color="#ffffff";
      break;
     case ($alliance["forminister"]):
        $class="foreign";
      $color="#000000";
      break;
     default: 
       $class="text";
     $color="";
    }
      table_text_design("<a class=\"".$class."\" href=\"mail.php?act=show_messages&name=".$users["name"]."#mailform\">".$users["name"]."</a>","","","",$class);  
    table_text_design($users["imperium"],"","","",$class);  
  table_text_close();
   }
  table_end();
  echo("<br>\n");
  table_start("center","500");
  table_text_open("head","center");
   table_text_design("&nbsp;","25","","","leader");
   table_text_design("Leader","100","","","head");
   table_text_design("&nbsp;","25","","","dev");
   table_text_design("Developement","100","","","head");
   table_text_design("&nbsp;","25","","","military");
   table_text_design("Military","100","","","head");
   table_text_design("&nbsp;","25","","","foreign");
   table_text_design("Foreign","100","","","head");
  table_text_close();
  table_end();
  
  echo("<br>");
  $sth = mysql_query("select a.name, d.alliance2, d.status from diplomacy d, alliance a where d.alliance1='".$aid."' and a.id = d.alliance2 and d.status != 1 order by d.status, a.name");
  
  if (!$sth) {
    echo("ERR::DATABASE.PHP, could not get relationships");
    return false;
  }
  
  table_start("center", "500");
  table_text_open("head","center");
  table_text_design("&nbsp","27","left","","head");
  table_text_design("Alliance Relations","","left","","head");
  table_text_close();
  
  if (mysql_num_rows($sth) > 0) 
  {
    while ($diplomacy = mysql_fetch_assoc($sth)) {
      if ($diplomacy["status"] == 0) {
        $dip_image = "arts/alliance_enemy.gif";
        $alt = "Enemy";
      }
      else {
        $dip_image = "arts/alliance_friend.gif";
        $alt = "Friend";
      }
      table_text_open("head","center");
      table_text_design("<img src=\"".$dip_image."\" width=\"25\" height=\"25\" alt=\"".$alt."\" border=\"0\" />","27","center","","text");
      table_text_design("<a href=\"".$PHP_SELF."?act=info_alliance&aid=".$diplomacy["alliance2"]."\">".$diplomacy["name"]."</a>","","left","","text");
      table_text_close();
    }
  }
  else
    table_text(array("no relations to other alliances"),"center","","2","text");  
  table_end();
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
  center_headline("Galactic Database");
}


switch ($act)
{
 case "find_alliance":
    show_menu();
    alliance_findform();
    find_alliance();
  show_database();
    break;
 case "info_alliance":
     show_menu();
     info_alliance();
    break;
 default:
   show_menu();
   alliance_findform();
   show_database();
}

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
