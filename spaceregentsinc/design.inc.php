<?
function show_error($error)
{
	$err_img = "<img src=\"arts/error.jpg\" width=\"30\" height=\"30\" alt=\"ERROR\" border=\"0\" />";
	$err_text= "<span class=\"err_text\">".$error."</span>";
	$err_capt=  "<span class=\"err_text2\"><strong>Sorry</strong>, <br />we have encountered an error :</span>";
	table_start("center", "200", "tbl_error");
	table_text(array($err_img."<br />".$err_capt));
	table_text(array($err_text), "center", "", 2);
  table_end();
  echo("<br /><br />");
}

function show_message($message)
{
  table_start("center","500");
  table_text(array("Note:"),"left","","1","head");
  table_text(array($message),"left","","1","text");
  table_end();
  // echo("<h2 align=\"center\">$message</h2>\n");
}
//***************************************** tabelle normal ****************************************************************
function table_start($align="",$width="", $class="tbl_norm")
{
	$tbl = "<table";
	if ($align != "") $tbl .= " align=\"".$align."\"";
	if ($width != "") $tbl .= " width=\"".$width."\"";
	if ($class != "") $tbl .= " class=\"".$class."\"";
	$tbl .= ">";
	
	echo($tbl);
}

function table_head_text($text_arr,$colspan="1")
{
  global $skin;

  echo("<tr>\n");
  reset($text_arr);
  while (list($dummy,$key)=each($text_arr))
    {
      echo("<th class=\"head\" colspan=\"".$colspan."\">$key</th>\n");
    }
  echo("</tr>\n");
}

function table_text_open($class="",$align="")
{
  $new_tr = "<tr ";

  if ($class != "")
    $new_tr .= "class=\"".$class."\" ";

  if ($align != "")
    $new_tr .= "align=\"".$align."\" ";

  $new_tr .= ">\n";
  echo($new_tr);
}

function table_text_design($text_arr,$width="",$align="",$colspan="",$class="",$rowspan="", $bgcolor="")
{
  $new_td = "<td ";

  if ($width != "")
    $new_td .= "width=\"".$width."\" ";

  if ($align != "")
    $new_td .= "align=\"".$align."\" ";

  if ($colspan != "")
    $new_td .= "colspan=\"".$colspan."\" ";

  if ($class != "")
    $new_td .= "class=\"".$class."\" ";

  if ($rowspan != "")
    $new_td .= "rowspan=\"".$rowspan."\" ";

  if ($bgcolor != "")
    $new_td .= "bgcolor=\"".$bgcolor."\" ";

  $new_td .= ">".$text_arr."</td>";

  echo($new_td);
}


function table_text_close()
{
  echo("</tr>\n");
}
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

function get_text_arr($arr)
{
  ob_start();
  table_text($arr,"center","",1,"head");
  $content=ob_get_contents();
  ob_end_clean();
  return $content;
}

function table_text($text_arr,$align="center",$width="",$colspan="1",$class="")
{
  $new_td = "<td ";
  if ($width != "")
    $new_td .= "width=\"".$width."\" ";

  if ($class != "")
    $new_td .= "class=\"".$class."\" ";

  if ($align != "")
    $new_td .= "align=\"".$align."\" ";

  if ($colspan != "")
    $new_td .= "colspan=\"".$colspan."\" ";

  $new_td .= ">";

  echo("<tr align=\"".$align."\">\n");
  while (list($dummy,$key)=each($text_arr))
    {
      $td = $new_td.$key."</td>\n";
      echo($td);
    }
  echo("</tr>\n");
}


function table_end()
{
  echo("</table>\n");
}

//***********************************************************************************************************************


function table_form_text($text,$varname,$value="",$size="20",$maxlength="20",$class="text")
{
  if (!is_array($text))
    echo("<tr class=\"".$class."\"><td>$text</td><td><input name=\"".$varname."\" value=\"".$value."\" size=\"".$size."\" maxlength=\"".$maxlength."\"></td></tr>\n");
  else
  {
    echo("<tr>");
    while (list($dummy,$key)=each($text))
      {
  echo("<td align=\"center\">".$key."</td>");
      }
    echo("<td><input name=\"".$varname."\" value=\"".$value."\" size=\"".$size."\" maxlength=\"".$maxlength."\"></td></tr>\n");
  }
}

function table_form_password($text,$varname,$class="")
{
  echo("<tr><td class=\"".$class."\">$text</td><td class=\"".$class."\"><input type=password name=\"".$varname."\"></td></tr>\n");
}

function form_submit($text,$act="")
{
  if ($act!="")
    echo("<input type=hidden name=\"act\" value=\"".$act."\">");
  echo("<input type=submit value=\"".$text."\">\n");
}

function print_form_submit($text,$act)
{
  table_form_submit($text,$act);
}

function table_form_submit($text,$act="",$colspan=2,$class="")
{
  if ($act!="")
    echo("<input type=hidden name=\"act\" value=\"".$act."\">");
  echo("<tr><td class=\"".$class."\">&nbsp;</td><td class=\"".$class."\" align=\"right\" colspan=\"".$colspan."\"><input type=\"submit\" value=\"".$text."\"></td></tr>\n");
}

function form_hidden($name,$value)
{
  echo("<input type=hidden name=\"".$name."\" value=\"".$value."\">");
}


function center_headline($text)
{
  echo("<center><h3>$text</h3></center>");
}

function table_border_start($align="",$width="",$bgcolor="#000000",$bordercolordark="#000000",$bordercolorlight="#000000")
{
  echo("<table border=3 bordercolorlight=\"".$bordercolorlight."\" bordercolordark=\"".$bordercolordark."\" bgcolor=\"".$bgcolor."\" align=\"".$align."\" width=\"".$width."\">\n");
}


function table_form_textarea($text,$varname,$preset="",$width="50",$height="20")
{
  echo("<tr><td >$text</td><td><textarea cols=$width rows=$height name=\"$varname\" wrap=physical>".$preset."</textarea></td></tr>");
}

function table_raw_text($text)
{
  echo("<tr><td>$text</td></tr>");
}

function table_form_select($text,$varname,$select_array,$preselect="",$class1="",$class2="",$align="center")
{
  echo("<tr><td class=\"".$class1."\">$text</td><td class=\"".$class2."\" align=\"".$align."\"><select name=\"".$varname."\">\n");
  while (list($key,$value)=each($select_array))
    {
      if ($preselect==$value)
  echo("<option selected value=\"".$value."\">$key\n");
      else
  echo("<option value=\"".$value."\">$key\n");
    }
  echo("</select></td></tr>\n");
}

function help_button($link,$tab=false)
{
  if (!$tab)
    echo("<a href=\"".$link."\"><img src=\"arts/help.jpg\" alt=\"Give me a clue!\" border=0></A>\n");
  else
    return "<a href=\"".$link."\"><img src=\"arts/help.jpg\" alt=\"Give me a clue!\" border=0></A>\n";
}

function go_back($back)
{
  echo("<a href=\"".$back."\">back</a><br>\n");
}
?>
