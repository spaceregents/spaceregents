<?
include "../spaceregentsinc/init.inc.php";

if ($not_ok)
  return 0;

  // Bis hier immer so machen:)

function show_taxes()
{
  global $uid;
  global $PHP_SELF;

  $sth=mysql_query("select t.*,u.alliance,u.id from taxes as t, users as u where u.id='$uid' and u.alliance=t.aid");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $tax = mysql_fetch_array($sth);
  $sth=mysql_query("select name, devminister from alliance where id=".$tax["aid"]."");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);

  center_headline("Taxes");
  echo("<br>\n");
  table_start("center","500");

  if ($alliance["devminister"]==$uid)
  {
    $o="";
    for ($i=0;$i<=30;$i++)
    {
      $o.="<option value=\"".$i."\">".($i)."%";
    }
    table_start("center","500");
    table_head_text(array("Your options as Minister of Developement"),"5");
    table_text(array("&nbsp;"),"","","5","text");
    table_text(array("Tax","Rate","Total income last turn","Set","&nbsp;"),"center","","","head");
    table_text_open();
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text_design("<img src=\"arts/metal.gif\" alt=\"metal\">","","center","","text");
    table_text_design($tax["taxmetal"]."%","50","center","","text");
    table_text_design($tax["incomemetal"]." units","330","center","","text");
    table_text_design("<select name=\"resource\">".$o."</select>","50","center","","text");
    table_text_design("<input type=\"hidden\" value=\"metal\" name=\"type\"><input type=\"submit\" value=\"set\">","50","center","","text");
    echo("</form>\n");
    table_text_close();   
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text(array("<img src=\"arts/energy.gif\" alt=\"Energy\">",$tax["taxenergy"]."%",$tax["incomeenergy"]." units","<select name=\"resource\">".$o."</select>","<input type=\"hidden\" value=\"energy\" name=\"type\"><input type=\"submit\" value=\"set\">"),"center","","","text");
    echo("</form>\n");
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text(array("<img src=\"arts/mopgas.gif\" alt=\"Mopgas\">",$tax["taxmopgas"]."%",$tax["incomemopgas"]." units","<select name=\"resource\">".$o."</select>","<input type=\"hidden\" value=\"mopgas\" name=\"type\"><input type=\"submit\" value=\"set\">"),"center","","","text");
    echo("</form>\n");
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text(array("<img src=\"arts/erkunum.gif\" alt=\"Erkunum\">",$tax["taxerkunum"]."%",$tax["incomeerkunum"]." units","<select name=\"resource\">".$o."</select>","<input type=\"hidden\" value=\"erkunum\" name=\"type\"><input type=\"submit\" value=\"set\">"),"center","","","text");
    echo("</form>\n");
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text(array("<img src=\"arts/gortium.gif\" alt=\"Gortium\">",$tax["taxgortium"]."%",$tax["incomegortium"]." units","<select name=\"resource\">".$o."</select>","<input type=\"hidden\" value=\"gortium\" name=\"type\"><input type=\"submit\" value=\"set\">"),"center","","","text");
    echo("</form>\n");
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text(array("<img src=\"arts/susebloom.gif\" alt=\"Susebloom\">",$tax["taxsusebloom"]."%",$tax["incomesusebloom"]." units","<select name=\"resource\">".$o."</select>","<input type=\"hidden\" value=\"susebloom\" name=\"type\"><input type=\"submit\" value=\"set\">"),"center","","","text");
    echo("</form>\n");

    $taxsum = 100-($tax["taxleader"]+$tax["taxdevelopement"]+$tax["taxmilitary"]+$tax["taxforeign"]);
    $o="<option value=\"0\">0%";
    for ($i=1;$i<=($tax["taxleader"]+$taxsum);$i++)
    {
      if ($i==$tax["taxleader"])
        $o=$o."<option value=\"".$i."\" selected>".($i)."%";
      else
        $o=$o."<option value=\"".$i."\">".($i)."%";
    }

    table_text(array("&nbsp;"),"center","","5","text");
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text_open();
    table_text_design("Leader received (".$tax["taxleader"]."%)","","center","3","head");
    table_text_design("<select name=\"resource\">".$o."</select>","","center","","head");
    table_text_design("<input type=\"hidden\" value=\"leader\" name=\"type\"><input type=\"submit\" value=\"set\">","","center","","head");
    table_text_close();
    echo("</form>\n");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxleader"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxleader"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxleader"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxleader"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxleader"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxleader"]/100).""),"center","","5","text");
    $o="<option value=\"0\">0%";
    for ($i=1;$i<=($tax["taxdevelopement"]+$taxsum);$i++)
    {
      if ($i==$tax["taxdevelopement"])
        $o=$o."<option value=\"".$i."\" selected>".($i)."%";
      else
        $o=$o."<option value=\"".$i."\">".($i)."%";
    }
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text_open();
    table_text_design("Minister of Developement received (".$tax["taxdevelopement"]."%)","","center","3","head");
    table_text_design("<select name=\"resource\">".$o."</select>","","center","","head");
    table_text_design("<input type=\"hidden\" value=\"developement\" name=\"type\"><input type=\"submit\" value=\"set\">","","center","","head");
    table_text_close();
    echo("</form>\n");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxdevelopement"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxdevelopement"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxdevelopement"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxdevelopement"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxdevelopement"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxdevelopement"]/100).""),"center","","5","text");
    $o="<option value=\"0\">0%";
    for ($i=1;$i<=($tax["taxmilitary"]+$taxsum);$i++)
    {
      if ($i==$tax["taxmilitary"])
        $o=$o."<option value=\"".$i."\" selected>".($i)."%";
      else
        $o=$o."<option value=\"".$i."\">".($i)."%";
    }
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text_open();
    table_text_design("Minister of Defence received (".$tax["taxmilitary"]."%)","","center","3","head");
    table_text_design("<select name=\"resource\">".$o."</select>","","center","","head");
    table_text_design("<input type=\"hidden\" value=\"military\" name=\"type\"><input type=\"submit\" value=\"set\">","","center","","head");
    table_text_close();
    echo("</form>\n");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxmilitary"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxmilitary"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxmilitary"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxmilitary"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxmilitary"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxmilitary"]/100).""),"center","","5","text");
    $o="<option value=\"0\">0%";
    for ($i=1;$i<=($tax["taxforeign"]+$taxsum);$i++)
    {
      if ($i==$tax["taxforeign"])
        $o=$o."<option value=\"".$i."\" selected>".($i)."%";
      else
        $o=$o."<option value=\"".$i."\">".($i)."%";
    }
    echo("<form method=\"post\" action=\"".$PHP_SELF."?act=set_tax\">\n");
    table_text_open();
    table_text_design("Foreign Minister received (".$tax["taxforeign"]."%)","","center","3","head");
    table_text_design("<select name=\"resource\">".$o."</select>","","center","","head");
    table_text_design("<input type=\"hidden\" value=\"foreign\" name=\"type\"><input type=\"submit\" value=\"set\">","","center","","head");
    table_text_close();
    echo("</form>\n");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxforeign"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxforeign"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxforeign"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxforeign"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxforeign"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxforeign"]/100).""),"center","","5","text");
    table_end();
  }
  else
  {
    table_head_text(array("Taxrate of Alliance: ".$alliance["name"]),"3");
    table_text(array("&nbsp;"),"","","3","text");
    table_text(array("Tax","Rate","Total income last turn"),"center","","","head");
    table_text_open();
    table_text_design("<img src=\"arts/metal.gif\" alt=\"metal\">","","center","","text");
    table_text_design($tax["taxmetal"]."%","50","center","","text");
    table_text_design($tax["incomemetal"]." units","430","center","","text");
    table_text_close();   
    table_text(array("<img src=\"arts/energy.gif\" alt=\"Energy\">",$tax["taxenergy"]."%",$tax["incomeenergy"]." units"),"center","","","text");
    table_text(array("<img src=\"arts/mopgas.gif\" alt=\"Mopgas\">",$tax["taxmopgas"]."%",$tax["incomemopgas"]." units"),"center","","","text");
    table_text(array("<img src=\"arts/erkunum.gif\" alt=\"Erkunum\">",$tax["taxerkunum"]."%",$tax["incomeerkunum"]." units"),"center","","","text");
    table_text(array("<img src=\"arts/gortium.gif\" alt=\"Gortium\">",$tax["taxgortium"]."%",$tax["incomegortium"]." units"),"center","","","text");
    table_text(array("<img src=\"arts/susebloom.gif\" alt=\"Susebloom\">",$tax["taxsusebloom"]."%",$tax["incomesusebloom"]." units"),"center","","","text");
    table_text(array("&nbsp;"),"center","","3","text");
    table_text(array("Leader recieved (".$tax["taxleader"]."%)"),"center","","3","head");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxleader"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxleader"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxleader"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxleader"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxleader"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxleader"]/100).""),"center","","3","text");
    table_text(array("Minister of Developement recieved (".$tax["taxdevelopement"]."%)"),"center","","3","head");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxdevelopement"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxdevelopement"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxdevelopement"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxdevelopement"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxdevelopement"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxdevelopement"]/100).""),"center","","3","text");
    table_text(array("Minister of Defence recieved (".$tax["taxmilitary"]."%)"),"center","","3","head");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxmilitary"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxmilitary"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxmilitary"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxmilitary"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxmilitary"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxmilitary"]/100).""),"center","","3","text");
    table_text(array("Foreign Minister recieved (".$tax["taxforeign"]."%)"),"center","","3","head");
    table_text(array("<img src=\"arts/metal.gif\" alt=\"metal\"> ".round($tax["incomemetal"]*$tax["taxforeign"]/100)." <img src=\"arts/energy.gif\" alt=\"energy\"> ".round($tax["incomeenergy"]*$tax["taxforeign"]/100)." <img src=\"arts/mopgas.gif\" alt=\"mopgas\"> ".round($tax["incomemopgas"]*$tax["taxforeign"]/100)." <img src=\"arts/erkunum.gif\" alt=\"Erkunum\"> ".round($tax["incomeerkunum"]*$tax["taxforeign"]/100)." <img src=\"arts/gortium.gif\" alt=\"Gortium\"> ".round($tax["incomegortium"]*$tax["taxforeign"]/100)." <img src=\"arts/susebloom.gif\" alt=\"Susebloom\"> ".round($tax["incomesusebloom"]*$tax["taxforeign"]/100).""),"center","","3","text");
    table_end();
  }
  echo("<br><br>\n");

}

function set_tax()
{
  global $uid;
  global $resource;
  global $type;


  $sth=mysql_query("select id from alliance where devminister=$uid");

  if (!$sth)
  {
    show_message("Database Failure");
    return 0;
  }

  $alliance=mysql_fetch_array($sth);


  $sth=mysql_query("select tax".$type." from taxes where aid=".$alliance["id"]."");

  if (!$sth)
  {
    show_message("Database Failure T1");
    return 0;
  }

  if (mysql_num_rows($sth)==0)
  {
    show_message("You are not allowed to do that!");
    return 0;
  }
  $tax=mysql_fetch_array($sth);

  if ($resource==$tax["tax".$type])
  {
    show_message("Please enter a altered taxrate");
    return 0;
  }

  $sth=mysql_query("update taxes set tax".$type."=".$resource." where aid=".$alliance["id"]);
  $sth=mysql_query("select tax".$type." from taxes where aid=".$alliance["id"]);
  if (!$sth)
  {
    show_message("Database Failure T2");
    return 0;
  }
  $newtax=mysql_fetch_array($sth);

  $sth=mysql_query("select id from users where alliance=".$alliance["id"]);

  if (!$sth)
  {
    show_message("Database Failure T3");
    return 0;
  }


  if ($tax["tax".$type]>$newtax["tax".$type])
  {
    show_message("You have decreased the tax on ".$type." by ".($tax["tax".$type]-$newtax["tax".$type])." points to ".$newtax["tax".$type]."%");
    while ($members=mysql_fetch_array($sth))
    {
      $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$members["id"]."','w','Your Minister of Developement has decreased the tax on ".$type." by ".($tax["tax".$type]-$newtax["tax".$type])." points to ".$newtax["tax".$type]."%','".date("YmdHis")."')");
    } 
  }
  else
  {
    show_message("You have increased the tax on ".$type." by ".($newtax["tax".$type]-$tax["tax".$type])." points to ".$newtax["tax".$type]."%");
    while ($members=mysql_fetch_array($sth))
    {
      $sth1=mysql_query("insert into ticker (uid,type,text,time) values ('".$members["id"]."','w','Your Minister of Developement has increased the tax on ".$type." by ".($newtax["tax".$type]-$tax["tax".$type])." points to ".$newtax["tax".$type]."%','".date("YmdHis")."')");
    }
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
  echo("<br><br>\n");
}

switch ($act)
{
  case "set_tax":
    set_tax();
  show_menu();
  show_taxes();
  break;
  default:
  show_menu();
  show_taxes();
  break;
}

include "../spaceregentsinc/footer.inc.php";
?>
