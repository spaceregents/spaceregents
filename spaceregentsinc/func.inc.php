<?
function ticker($uid,$text,$type="")
{
  $text=addslashes($text);

  $sth=mysql_query("insert into ticker (uid,text,type) values ('$uid','$text','$type')");
  if (!$sth)
    echo("ticker didn'T work!");
}

function mail_to_uid($uid,$subject,$content)
{
  $subject=addslashes($subject);
  $content=addslashes($content);

  $sth=mysql_query("insert into mail (uid,fuid,text,subject,time) values ('$uid','0','".$content."','$subject','".date("YmdHis")."')");

  if (!$sth)
    echo("Mailsending didn'T work!");
}

function connect()
{
  global $mysql_host;
  global $mysql_user;
  global $mysql_pw;
  global $mysql_db;
  
  $GLOBALS["db"]=new dbwrap;
  $GLOBALS["db"]->connect($mysql_host,$mysql_user,$mysql_pw,$mysql_db);
}

function get_time($time=false)
{
  echo($time);
  // Gibt entweder ne vernünftige Zeit aus (1.12.2001 20:12:45) von einer mysql timestamp oder einfach die aktuelle
  if (!$time)
    return mktime(date("j.n.Y G:i:s"));
  else
    return substr($time,6,2).".".substr($time,4,2).".".substr($time,0,4)." ".substr($time,8,2).":".substr($time,10,2).":".substr($time,12,2);
}

// removt ein index vom array
function array_slice_remove($arr,$i)
{
  if (!is_array($arr))
    return $arr;

  for ($i=0;$i<sizeof($arr);$i++)
  {
    if ($i!=$idx)
      $arr2[]=$arr[$i];
  }

  return $arr2;
}

function mail_check($email)
{
  if (ereg('^[-!#$%&\'*+\\./0-9=?A-Z^_a-z{|}~]+'.// Zugelassene Zeichen vor dem '@' Symbol
	'@'.                                 // '@' Symbol
	'[-!#$%&\'*+\\/0-9=?A-Z^_a-z{|}~]+'.// Zugelassene Zeichen nach dem '@' Symbol
	'[.]+'.                             // Mindestens 1 Punkt nach dem '@' Symbol
	'[-!#$%&\'*+\\./0-9=?A-Z^_a-z{|}~]+$'// Zugelassene Zeichen nach dem ersten Punkt nach '@'-Symbol
	, $email))
    return true;
  else 
    return false;
}
?>
