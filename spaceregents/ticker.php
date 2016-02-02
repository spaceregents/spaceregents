<?
Header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
?>
var i, pos1,pos2, botschaft, bild, filter, IE, OP;
 i = 0; pos1 = 1; bild = "";bild2="";bild3="";linkr="";linkl="";startstring = 2;


 

<?
include "inc/func.inc.php";
include "inc/config.inc.php";

connect();

if (!cookies_ok())
{
  return 0;
}
else
{
  $sth=mysql_query("select id from users where name='$sr_name'");
  $uid_db=mysql_fetch_array($sth);
  $uid=$uid_db["id"];

  $sth=mysql_query("select * from ticker where uid=$uid");

  if (!$sth)
    {
      show_error("Dtabase failure!");
      return 0;
    }

  echo("botschaft = new Array();\n");
  echo("id = new Array();\n");

  for ($i=0;$i<mysql_num_rows($sth);$i++)
    {
      echo("botschaft[".$i."] =  \"\";\n");
      echo("id[".$i."] = \"\";\n");
    }
   
    echo("\n\n");
      
    echo("function getBotschaft()\n");
    echo("{\n");
    echo("var e;\n");
    echo("botschaft = new Array();\n");
    echo("id = new Array();\n");
    if (mysql_num_rows($sth)==0)
      {
	echo("botschaft[0]=\"\";\n");
	echo("id[0]=\"\";\n");
      }
  
  echo("\n\n");
  for ($i=0;$i<mysql_num_rows($sth);$i++)
    {
      $botschaft=mysql_fetch_array($sth);
	  $test="<br>".substr($botschaft["time"],6,2)."-".substr($botschaft["time"],4,2)." ".substr($botschaft["time"],8,2).":".substr($botschaft["time"],10,2);
	  
      if ($botschaft["type"]=="")
	$botschaft["type"]="  ";
      else
	$botschaft["type"]="*".$botschaft["type"];
      
      echo("botschaft[".$i."] = \"".$botschaft["type"].$botschaft["text"].$test."\";\n");
      echo("id[".$i."] = \"".$botschaft["tid"]."\";\n");
      
    }
  
  if (mysql_num_rows($sth)==0)
    {
      echo("botschaft[0]=\"  We are sadly to report that we have nothing to report!\";\n");
      echo("id[0]=\"0\";");
    }
  echo("}");
  
} 
?>

 
 attack = "<img src='arts/underattack.jpg' align='left' width='15' height='15'>"; 
 important = "<img src='arts/wichtig.jpg' align='left' width='15' height='15'>";
 spy = "<img src='arts/spy.jpg' align='left' width='15' height='15'>";
 research = "<img src='arts/research.jpg' align='left' width='10' height='15'>";
 mailpic = "<img src='arts/mail.jpg' align='left' width='10' height='15'>"; 
 linkstart = "<a target='anzeige_frame' href='";
 linkend = "</a>";
 
function muell(wert)
 {
  wohin = "delticker.php?id="+id[wert];
  doof = "<a href="+wohin+"><img src='arts/eimer.jpg' border='0' width='10' height='15' alt='Delete message' align='right'></a>";
  return doof;
 }
  
 
function typuserkennung(bildwert) 
{
		 	  pos1++;
			  switch (bildwert)
			   {
			    case "a":
 				    bild = attack;
					break; 
			    case "w":
					bild = important;
					break; 
			    case "s":
					bild = spy;
					break; 
			    case "r":
					bild = research;
					break; 
			    case "m":
					bild = mailpic;
					break; 
			    case "l":
					bild2 = linkstart;
					bild3 = linkend;
					linkl = "'>";					
					break; 					
			   }	
			  return bildwert;
   } 

function filtercheck()
 {
  	  save_i = i;
		  save_e = false;
           do 
		    { 
    			if (i < botschaft.length-1) i++;
				else i=0;
				if (i == save_i) filter= " ";
 			}
		   while (botschaft[i].substring(1,2) != filter && filter != " ");
		   save_i = null;
		   save_e = null;
 } 
 
function linktest(typus)
 {
			 if (typus=="l")
			  {
			   do
 			    {
				 linkr = linkr + botschaft[i].substring(pos1,pos1+1);
				 pos1++;
	    		 startstring++;
				}
				while (botschaft[i].substring(pos1,pos1+1) != '*');
	    		startstring+=3;
			  }
 } 
 
function clear_werte()
 {
	   bild = " ";
	   bild2 = " ";
	   bild3 = " ";
	   linkr = " ";
	   linkl = " ";
	   startstring = 2;
	   pos1 =0;
	   igitt = " ";
 } 
 
 function tickitIE()
  {
   if (pos1 <= botschaft[i].length)
     {
       if (botschaft[i].substring(pos1-1,pos1) == '*') 
	       {
		     test = typuserkennung(botschaft[i].substring(pos1,pos1+1));
			 linktest(test);
		    }
	   else
	   	 document.all.positiontop.innerHTML=bild+bild2+linkr+linkl+botschaft[i].substring(startstring,pos1)+bild3;
	   pos1 ++;
	   setTimeout("tickitIE()",100);
	 }  
	else
	  {	   
	   clear_werte();
	   igitt = muell(i);
	   document.all.positiontop.innerHTML += igitt;
	   document.all.position4.innerHTML = document.all.position3.innerHTML;
       document.all.position3.innerHTML = document.all.position2.innerHTML;
	   document.all.position2.innerHTML = document.all.position1.innerHTML;
	   document.all.position1.innerHTML = document.all.positiontop.innerHTML;
	   document.all.positiontop.innerHTML = " ";
	  if (filter != " ")
	     { 
	 	   filtercheck();
		   setTimeout("tickitIE()",1000);
    	 } 
	      else 
		  {
		   if (i<botschaft.length-1) 
			{
				i++;			  
			} 
	       else i = 0;	   
		   setTimeout("tickitIE()",1000);
		   }
		 }	 
  }
  

 function tickitNS()
  {
   if (pos1 <= botschaft[i].length)
     { 
       if (botschaft[i].substring(pos1-1,pos1) == '*') 
	       {
		     test = typuserkennung(botschaft[i].substring(pos1,pos1+1));
			 linktest(test);
		    }
	   document.layers[0].document.open();
	   document.layers[0].document.write(bild+bild2+linkr+linkl+"<font color='blue' pointsize='10'><center>"+botschaft[i].substring(startstring,pos1)+"</center></font>"+bild3+muell(i));	
	   document.layers[0].document.close();
	   pos1 ++;
	   setTimeout("tickitNS()",100);}
	else
	  {	   
	   clear_werte();
	   if (filter != " ")
	    { 
		  filtercheck();
		  setTimeout("tickitNS()",5000);
    	 } // if schleife
	  else
		   {
			 if (i<botschaft.length-1) 
			   {
			    i++;	    	
			   }
			 else i = 0;  
	         setTimeout("tickitNS()",5000);
		   }		
	 }
  }
  
function tickitMoz()
 {  
   if (pos1 <= botschaft[i].length)
     {
       if (botschaft[i].substring(pos1-1,pos1) == '*') 
	       {
		     test = typuserkennung(botschaft[i].substring(pos1,pos1+1));
			 linktest(test);
		    }
       mozdoc = document.getElementById('positiontop');			
	   mozdoc.innerHTML = bild+bild2+linkr+linkl+botschaft[i].substring(startstring,pos1)+bild3;
	   pos1 ++;
	   setTimeout("tickitMoz()",100);
	 }  
	else
	  {	   
	   clear_werte();
       mozdoc = document.getElementById('positiontop');
	   mozdoc.innerHTML += muell(i);
	   
       mozdoc = document.getElementById('position4');
       mozdoc2 = document.getElementById('position3');
	   mozdoc.innerHTML = mozdoc2.innerHTML;
       mozdoc = document.getElementById('position2');
	   mozdoc2.innerHTML = mozdoc.innerHTML;
       mozdoc2 = document.getElementById('position1');
	   mozdoc.innerHTML = mozdoc2.innerHTML;
       mozdoc = document.getElementById('positiontop');
	   mozdoc2.innerHTML = mozdoc.innerHTML;
	   mozdoc.innerHTML =" ";
	   mozdoc = null;
	   mozdoc2 = null;
	   if (i<botschaft.length-1) 
		{
			i++;			  
		} 
	  else i = 0;	   
	  if (filter != " ")
	    { 
		   filtercheck();
		   setTimeout("tickitMoz()",1000);
    	 } 
	  else setTimeout("tickitMoz()",1000);

		 }	 
 }
  
function tickitOP()
 {
//   alert("OPERA! AHHHHHHHHHHHHH Bisher sehe ich keinen Weg den Ticker in Opera zu verwirklichen! Du WURM!");
   bla = document.getElementById('positiontop');
   bla = bla.setAttribute('text');
   bla = "auaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa";
   
 }  
 
  
 function Bildleiste(wb,undsrc)
  { 
      document.images[0].src = "skins/metal_blue/G_allbutton.jpg";
      document.images[1].src = "skins/metal_blue/G_anouncementbutton.jpg";
      document.images[2].src = "skins/metal_blue/G_mailbutton.jpg";
      document.images[3].src = "skins/metal_blue/G_attackbutton.jpg";
      document.images[4].src = "skins/metal_blue/G_researchbutton.jpg";
      document.images[5].src = "skins/metal_blue/G_spybutton.jpg";
      document.images[wb-1].src = undsrc;

   switch(wb)
    {
	 case 1:
	    filter=" ";
		break;
	 case 2:
	    filter="w";
		break;
	 case 3:
	    filter="m";
		break;
	 case 4:
	    filter="a";
		break;
	 case 5:
	    filter="r";
		break;
	 case 6:
	    filter="s";
		break;
	}
  }
	

function tickit()
  { 
   getBotschaft();
   if (IE == true) 
	 tickitIE();
   else 
   {    
	 if (OP == true) 
	  {
	    browsercheck = navigator.userAgent.search(/Gecko.+/);
		if (browsercheck != -1)
		{
		 browsercheck = null;
	     tickitMoz();
		} 
		else 
		{
		 browsercheck = null;
	     tickitOP();
		} 
	  }	
	 else tickitNS();
   }	 
  }
