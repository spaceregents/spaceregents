<?php
class srbrowser extends dbbrowser
{
  // Template für den Gruppenkopf
  var $gruppenkopf = "{klappe} | {gname}: <b><a href=\"{PHP_SELF}?act={setact}&{rname}={rwert}\">{gwert}</a></b> Count: <b>{ganzahl}</b>";
  
  // Template für die Navigation
  var $navigation = "<div align=\"center\">
    [ <a href=\"{PHP_SELF}?act={setact}&page={last_page}\">&lt;&lt; back</a> ]
    &nbsp;&nbsp;&nbsp;&nbsp;
     &nbsp;&nbsp;|&nbsp; <b>{max_entrys}</b> Entries on <b>{max_pages}</b> pages &nbsp;|&nbsp; Page: <b>{page}</b> &nbsp;|&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;
    [ <a href=\"{PHP_SELF}?act={setact}&page={next_page}\">forward &gt;&gt;</a> ]
    </div>";
   // mop: text der über den auswahlcheckboxen rumhängt
  var $selection_text="<b>Please select the visible columns:</b>";
  // kein wert für gruppenhead vorhanden
  var $novalue = "no value";
  
  var $use_htmlfunc=0;

  function print_table_start($title="",$col="",$width=100)
  {
    table_start("center","100%");
    table_head_text(array($title));
    table_end();
    table_start("center","100%");
  }

  function print_table_end()
  {
    table_end();
  }

  function print_text_line($line,$cols,$align="left",$col="#ffffff")
  {
    table_text_open("text",$align);
    table_text_design($line,"",$align,$cols,"text");
    table_text_close();
  }

  function print_table_head($arr,$col="#000000",$colspan=NULL)
  {
    table_text_open("head");
    foreach ($arr as $text)
      table_text_design($text,"","",$colspan,"head");
    table_text_close();
  }

  function print_text_arr($arr,$col="#ffffff",$wid="",$opt="",$optstr=1,$hidden=NULL)
  {
    table_text($arr,"center","","","text");
  }
}
?>
