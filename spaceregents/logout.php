<?
include "../spaceregentsinc/init.inc.php";

$ses->delete_session();

echo("<html><head>");
echo("<style type=\"text/css\">\n<!--h3,p,h1,h2,table,tr,td,th {color:white;} --></style>\n");
echo("</head>");
echo("<body bgcolor=\"black\" text=\"white\">");  
center_headline("You are now logged out!");
echo("<br><br><br>\n");
echo("<center>\n");
echo("<embed src=\"outro.svg\" type=\"image/svg+xml\" width=\"600\" height=\"300\">\n");
echo("</center>\n");
echo("</body>");
echo("</html>");
?>


