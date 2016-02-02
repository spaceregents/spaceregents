<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title>Spaceregents</title>
<meta http-equiv="Content-Type" content="text/html;charset=iso-8859-1" />
<meta name="robots" content="index" />
<meta name="robots" content="follow" />      
<meta name="keywords" lang="de" content="Spaceregents,Space Regents,Weltraum Strategy, Multiplayer Spiel, Regents, Space, SVG Spiel" />
<meta name="keywords" lang="en" content="Spaceregents,Space Regents,Space Strategy, Multiplayer Game, Regents, Space, SVG Game" />
<meta name="date" content="2003-04-04T00:00:00+00:00" />

<LINK rel="SHORTCUT ICON" href="http://www.spaceregents.de/favicon.ico" />
<link rel="stylesheet" type="text/css" href="css/spaceregents.css" />
</head>

<body>

<img src="images/sr_head_left.jpg" width="189" height="150" border="0" class="head_left" alt="" />
<img src="images/sr_head_left3.jpg" width="189" height="50" border="0" class="head_left2" alt="" />
<img src="images/sr_head_top.jpg" width="470" height="140" border="0" class="head_top" alt="" />
<img src="images/sr_head_right.jpg" width="143" height="200" border="0" class="head_right" alt="" />
<img src="images/sr_ad_bottom.jpg" width="475" height="9" border="0" class="head_ad_bottom" alt="" />
<!-- WERBUNG -->
<!-- <a href="sr_ad.php?bid=1&PHPSESSID=9c5233a2c1c8d78813850f7c83959731" class="head_banner"> -->
<a href="http://www.spaceregents.de" class="head_banner">
<img src="banners/sr_banner.jpg" width="468" height="60" border="0" alt="Spaceregents - the ultimate space strategy" />
</a>
<!-- start left -->
<img src="images/sr_menu_head3.jpg" width="128" height="25" border="0" class="menu_top" alt="" />
<img src="images/sr_menu_border.jpg" width="7" height="583" border="0" class="menu_left" alt="" />
<img src="images/sr_menu_border2.jpg" width="7" height="583" border="0" class="menu_right" alt="" />
<div class="menu">
&middot;<span class="menu">portal</span>&middot;<br />&nbsp;
{foreach key=idx item=page from=$pagetitles}
<a href="{label label=$links var=$pages.$idx}">{$page}</a><br>&nbsp;
{/foreach}
{if !$logged_in}
<form action="{$links.$this_page}" method="POST">
<img src="images/sr_menu_seperator.jpg" width="115">
<span class="comment">&middot; Username &middot;</span><br>
<input type="text" name="__portal_user" size="15"><br>
<span class="comment">&middot; Password &middot;</span><br>
<input type="password" name="__portal_pass"  size="15"><br>
<input type="submit" value="Login">
<img src="images/sr_menu_seperator.jpg" width="115">
</form>
{else}
<img src="images/sr_menu_seperator.jpg" width="115">
<span class="topic">&nbsp;Hello {$name}</span>
&nbsp;<a href="{$links.index}&logout=1">Logout</a>
<img src="images/sr_menu_seperator.jpg" width="115">
{/if}
<br><img src="images/mopal.jpg" alt="MOPal, the Spaceregents Portal" height="31" width="88" border="0" class="mopal" /><br>
</div>
<div class="content">
