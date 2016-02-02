<?
include "../spaceregentsinc/init.inc.php";

// Bis hier immer so machen:)

function show_rankings_name()
{
  global $PHP_SELF;
  global $uid;

  table_text_open("text");
  table_text_design("User rankings by score","","","5","head");
  table_text_close();
  table_text_open("text");
  table_text_design("<br>","","","5","text");
  table_text_close();
  table_text_open("head");
  table_text_design("Place","","","","head");
  table_text_design("Player","","","","head");
  table_text_design("Empire","","","","head");
  table_text_design("Alliance","","","","head");
  table_text_design("Score","","","","head");
  table_text_close();

  $sth=mysql_query("select score,name,imperium,alliance, id from users order by score DESC,name limit 100");
  $counter=1;
  while ($score=mysql_fetch_array($sth))
    {
      $sth1=mysql_query("select name,color from alliance where id=".$score["alliance"]);

      if (!$sth1) { show_error("Database failure!"); return 0; }            

      if (mysql_num_rows($sth1)==0)
        $alliance="No alliance";
      else
      {
        $all_temp=mysql_fetch_array($sth1);

        $alliance="<a href=\"database.php?act=info_alliance&aid=".$score["alliance"]."\"><font color=\"".$all_temp["color"]."\">".$all_temp["name"]."</font></a>";
      }
      
      $class = $uid == $score["id"] ? "head" : "text";

      table_text(array($counter++,$score["name"],$score["imperium"],$alliance,$score["score"]),"","","", $class);
    }
  table_text(array("<a href=\"#top\">Top</a>"),"center","","5","head");
}
//-------------------------------------------------------------------------------------------------



function show_alliance_rankings()
{
  global $PHP_SELF;

  $counter=1;

  table_text_open("text");
  table_text_design("Alliance rankings by score","","","5","head");
  table_text_close();
  table_text_open("text");
  table_text_design("<br>","","","5","text");
  table_text_close();
  table_text_open("head");
  table_text_design("Place","","","","head");
  table_text_design("Alliance","","","","head");
  table_text_design("Empires","","","","head");
  table_text_design("Average Score","","","","head");
  table_text_design("Total Score","","","","head");
  table_text_close();


  $sth=mysql_query("select sum(u.score),sum(u.score)/count(u.id),a.name,a.color,count(u.id), a.id from users as u,alliance as a where u.alliance=a.id and u.alliance!=0 group by u.alliance order by 1 desc");

  if (!$sth)
  {
    show_error("Database failure!");
    return 0;
  }

  while ($score=mysql_fetch_row($sth))
  {
    table_text(array($counter++,"<a href=\"database.php?act=info_alliance&aid=".$score[5]."\"><font color=\"".$score[3]."\">".$score[2]."</font></a>",$score[4],round($score[1]),$score[0]),"","","","text");
  }
  table_text(array("<a href=\"#top\">Top</a>"),"center","","5","head");
}
//-------------------------------------------------------------------------------------------------



function show_planets_rankings()
{
  global $PHP_SELF;
  global $uid;

  $user_alliance = get_alliance($uid);

  $counter = 1;

  table_text_open("text");
  table_text_design("User rankings by planets","","","5","head");
  table_text_close();
  table_text_open("text");
  table_text_design("<br>","","","5","text");
  table_text_close();
  table_text_open("head");
  table_text_design("Place","","","","head");
  table_text_design("Player","","","","head");
  table_text_design("Empire","","","","head");
  table_text_design("Alliance","","","","head");
  table_text_design("Planets","","","","head");
  table_text_close();

  $sth = mysql_query("select count(p.id) as planet_count, u.name as uname, u.imperium, a.name as aname, a.color, a.id as aid,u.id as uid from planets p, users u left join alliance a on a.id = u.alliance where u.id = p.uid group by u.id order by planet_count DESC LIMIT 100");

  if ((!$sth) ||(!mysql_num_rows($sth)))
  {
    show_error("Can't display user rankings by planets");
    return 0;
  }

  while ($score=mysql_fetch_assoc($sth))
  {
    if ($score["aid"] == $user_alliance || $score["uid"]==$uid)
      $planet_count = $score["planet_count"];
    else
      $planet_count = "&nbsp;";

    $class = $uid == $score["uid"] ? "head" : "text";


    $alliance = "<a href=\"database.php?act=info_alliance&aid=".$score["aid"]."\"><font color=\"".$score["color"]."\">".$score["aname"]."</font></a>";
    table_text(array($counter++,$score["uname"],$score["imperium"],$alliance,$planet_count),"","","", $class);
  }

  table_text(array("<a href=\"#top\">Top</a>"),"center","","5","head");
}
//-------------------------------------------------------------------------------------------------



function show_ships_rankings()
{
  global $PHP_SELF;
  global $uid;

  $user_alliance = get_alliance($uid);

  $counter = 1;

  table_text_open("text");
  table_text_design("User rankings by ships","","","5","head");
  table_text_close();
  table_text_open("text");
  table_text_design("<br>","","","5","text");
  table_text_close();
  table_text_open("head");
  table_text_design("Place","","","","head");
  table_text_design("Player","","","","head");
  table_text_design("Empire","","","","head");
  table_text_design("Alliance","","","","head");
  table_text_design("Ships","","","","head");
  table_text_close();

  $sth = mysql_query("select sum(f.count) as ship_count, u.name as uname, u.imperium, a.name as aname, a.color, a.id as aid,u.id as uid from fleet f left join fleet_info fi using(fid), users u left join alliance a on a.id = u.alliance where u.id = fi.uid group by u.id order by ship_count DESC LIMIT 100");

  if ((!$sth) ||(!mysql_num_rows($sth)))
  {
    show_error("Can't display user rankings by ships");
    return 0;
  }

  while ($score=mysql_fetch_assoc($sth))
  {
    if ($score["aid"] == $user_alliance || $score["uid"]==$uid)
      $planet_count = $score["ship_count"];
    else
      $planet_count = "&nbsp;";

    $class = $uid == $score["uid"] ? "head" : "text";
    $alliance = "<a href=\"database.php?act=info_alliance&aid=".$score["aid"]."\"><font color=\"".$score["color"]."\">".$score["aname"]."</font></a>";
    table_text(array($counter++,$score["uname"],$score["imperium"],$alliance,$planet_count),"","","", $class);
  }

  table_text(array("<a href=\"#top\">Top</a>"),"center","","5","head");
}
//-------------------------------------------------------------------------------------------------


function show_rankings_menu()
{
  global $PHP_SELF;
  echo("<br />");
  echo("<a name=\"top\" />\n");
  table_start("center","500",4);
  table_head_text(array("Rankings"),"5");
  table_text_open("text");
  table_text_design("<br>","","","5","text");
  table_text_close();
  table_text_open("head");
  table_text_design("Users","","","2","head");
  table_text_design("&nbsp;","","","","head");
  table_text_design("Alliances","","","2","head");
  table_text_close();
  table_text_open("head");
  table_text_design("&middot;&nbsp;<a href=\"".$PHP_SELF."\">Score</a>","","","2","text");
  table_text_design("&nbsp;","","","","text");
  table_text_design("&middot;&nbsp;<a href=\"".$PHP_SELF."?act=show_alliance_rankings\">Score</a>","","","2","text");
  table_text_close();
  table_text_open("text");
  table_text_design("&middot;&nbsp;<a href=\"".$PHP_SELF."?act=show_planets_rankings\">Planets (Top 100)</a>","","","2","text");
  table_text_design("&nbsp;","","","","text");
  table_text_design("&nbsp;","","","2","text");
  table_text_close();
  table_text_open("text");
  table_text_design("&middot;&nbsp;<a href=\"".$PHP_SELF."?act=show_ships_rankings\">Ships (Top 100)</a>","","","2","text");
  table_text_design("&nbsp;","","","","text");
  table_text_design("&nbsp;","","","2","text");
  table_text_close();
  table_text_open("text");
  table_text_design("<br>","","","5","text");
  table_text_close();
}
//-------------------------------------------------------------------------------------------------


show_rankings_menu();
switch ($act)
{
 case "show_alliance_rankings":
  show_alliance_rankings();
  break;
 case "show_planets_rankings":
  show_planets_rankings();
  break;
 case "show_ships_rankings":
  show_ships_rankings();
  break;
 default:
   show_rankings_name();
}
table_end();

// ENDE
include "../spaceregentsinc/footer.inc.php";
?>
