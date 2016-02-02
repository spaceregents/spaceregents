<?php
function smarty_modifier_smilies($string)
{
  global $__portal_base_dir;
  global $__portal_base_url;

  if (!$__portal_base_dir || !$__portal_base_url)
    return $string;
  
  // mop: glorreicher hack um nen caching zu machen
  if (!$GLOBALS["__smilies"])
  {
    $GLOBALS["__smilies"]=array();
    
    $dir=$__portal_base_dir."portal/images/smilies";

    if (is_dir($dir))
    {
      if ($dh = opendir($dir))
      {
	while (($file = readdir($dh)) !== false)
	{
	  if (preg_match("/^(.*)\.(png|jpeg|gif|jpg)$/i",$file,$match))
	  {
	    $GLOBALS["__smilies"][$match[1]]="<img src=\"".$__portal_base_url."images/smilies/".urlencode($match[0])."\" alt=\"".$match[1]."\">";
	  }
	}
	closedir($dh);
      }
    }
  }

  return strtr($string,$GLOBALS["__smilies"]);
}
?>
