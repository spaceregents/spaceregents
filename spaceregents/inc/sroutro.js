text1 = new Array
(
  "H-Thanks for Playing Space Regents",
  "",
  "",
  "H-Here comes the gang",
  "",
  "",
  "H-Insane guys that started it",
  "",
  "N-Andreas 'Mop' Streichhardt",
  "N-Erik 'Runelord' Oey",
  "",
  "",
  "H-Poor slaves that coded it",
  "",
  "N-Andreas 'Mop' Streichhardt",
  "N-Erik 'Runelord' Oey",
  "",
  "",
  "H-Kick-Ass Battle Engine Coder",
  "",
  "N-Janne 'Julius' Vehreschild",
  "",
  "",
  "H-2D-Arts Jerk",
  "",
  "N-Erik 'Runelord' Oey",
  "",
  "",
  "H-3D-Arts Dumbheads",
  "",
  "N-Andreas 'Lucius' Koch",
  "N-Kevin 'toXic' who knows his last name?",
  "N-Rob 'starfleet' Graham",
  "N-Erik 'Runelord' Oey",
  "",
  "",
  "H-Lost Portal Designer",
  "",
  "N-John 'Nemesis' Milsom",
  "Z-who sadly left our chaotic team",
  "",
  "",
  "H-Extreme Special Thanks",
  "",
  "N-Global Park GmbH",
  "Z-for taking our traffic",
  "",
  "N-NASA and ESA",
  "Z-for shooting those great space pictures",
  "",
  "N-Hans Ruedinger Peter Andreas 'Gorlord' Geis",
  "Z-for being a great and mostly useless teammember ;)",
  "",
  "N-Kai 'Kai Allard Liao' Oey",
  "Z-for being my brother and a great help",
  "", "",
  "N-Tank",
  "Z-for helping us out with ideas and testing",
  "", "",
  "N-Jim Ley and Doug Schepers",
  "Z-for their great SVG help",
  "", "",
  "N-Martin Jost",
  "Z-for helping us out with maths",
  "", "",
  "N-David Heuskel",
  "Z-for his hints concerning route planning",
  "", "",
  "",
  "",
  "H-Great Testers that took part in ALPHA I",
  "",
  "N-Alsvartr",
  "N-achnecromancer",
  "N-benoit",
  "N-canderson",
  "N-Crossbreed",
  "N-Emperor",
  "N-Fireangle",
  "N-Kai Allard Liao",
  "N-kamta",
  "N-Killercore",
  "N-Luminus",
  "N-Malachai",
  "N-michael",
  "N-Morgoth",
  "N-mph",
  "N-Pan",
  "N-Pelvica",
  "N-pielicke",
  "N-Raphael",
  "N-reverence",
  "N-sirjun",
  "N-Space Wombat",
  "N-thebeast",
  "N-Throatcancer",
  "N-warblesnarf",
  "N-Woody",
  "N-Xel",
  "",
  "",
  "",
  "",
  "H-Great Testers that took part in ALPHA II",
  "",
  "N-Ooops, I lost their names...",
  "N-The Team thanx them anyway",  
  "",
  "",
  "",
  "",
  "H-Pre-Beta! :D",
  "",
  "Z-many thanx to (ordered by final score)",
  "",
  "N-Mastermind - North - Julius",
  "N-Lord Ares - Eminence - Throatcancer",
  "N-Wulfen - Lord Lommel - Link",
  "N-Sabot X-51 - Gesierich - Matt Garforth",
  "N-Linke_Arie - Gerindar - Nelder",
  "N-Gandarion - -=CHEF=- - Xofia",
  "N-RiQ - Hrun - blast666",
  "N-Spawn von Borg - toXic - =N=Danny",
  "N-Moonblade - Locutus von Borg - Starfleet",
  "N-Aldaris - Grufti - Ar Pharazon",
  "N-ChrisP - Lucius - elmo",
  "N-oncelbens - luminus - Kai Allard Liao",
  "N-Klonia - Rufus T. Firefly - Captain Amazing",
  "N-Samus - Wuergezwerg - Shizoid Man",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "Z-Bye!",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-What are you waiting for?",
  "",
  "",
  "N-Christmas?",
  "",
  "N-hrhr /me is SOO funny",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-....boring....",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-lalallalla",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-lulululul",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-geez, go find a life",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-I hereby greet my gorgeous girlfriend Katja",
  "Z-I LOVE YOU",
  "",
  "N-:)",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-Okay thats it, get away",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-PLEASE",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "",
  "N-I told ya" 
);
  

var lastText = "have a good day";

function init(evt)
{
  svgdoc = evt.target.ownerDocument;
  svgroot = svgdoc.documentElement;
  startAnimations(text1);
}


function startAnimations(its_text)
{
  for (i=0;i < its_text.length;i++)
  {
    text_frag = its_text[i];
    if (text_frag != "" && text_frag)
    {
    bla_type = text_frag.substring(0,1);
    bla_text = text_frag.substr(2);
    switch (bla_type)
    {
      case "H":
        itsStyle="fill:white;stroke:none;font-family:helvetica,verdana,arial;font-size:12pt;opacity:0;letter-spacing:5pt;text-anchor:middle;";
      break;
      case "N":
        itsStyle="fill:white;stroke:none;font-family:verdana,arial;font-size:10pt;text-anchor:middle;opacity:0;";
      break;
      case "Z":
        itsStyle="fill:white;stroke:none;font-family:verdana,arial;font-size:8pt;opacity:0;text-anchor:middle;";
      break;
    }
    newTextNode = svgdoc.createElement("text");
    newTextNode.setAttribute("x","300");
    newTextNode.setAttribute("y","300");
    newTextNode.setAttribute("style",itsStyle);
    newTextNode.setAttribute("display","none");
    newTextNodeData = svgdoc.createTextNode(bla_text);
    
    itsAnimation1 = svgdoc.createElement("animate");
    itsAnimation1.setAttribute("attributeType","CSS");
    itsAnimation1.setAttribute("attributeName","opacity");
    itsAnimation1.setAttribute("from","0");
    itsAnimation1.setAttribute("to","1");
    itsAnimation1.setAttribute("dur","1s");
    itsAnimation1.setAttribute("fill","freeze");
    itsAnimation1.setAttribute("begin",(i+1)+"s");
    itsAnimation1.setAttribute("id","ani1"+String(i));
    itsAnimation1.addEventListener("begin",showIt,false);
    
    itsAnimation2 = svgdoc.createElement("animateMotion");
    itsAnimation2.setAttribute("path","m0,0 v-280");
    itsAnimation2.setAttribute("dur","10s");
    itsAnimation2.setAttribute("id","ani2"+String(i));
    itsAnimation2.setAttribute("begin","ani1"+String(i)+".begin");
    
    itsAnimation3 = svgdoc.createElement("animate");
    itsAnimation3.setAttribute("attributeType","CSS");
    itsAnimation3.setAttribute("attributeName","opacity");
    itsAnimation3.setAttribute("from","1");
    itsAnimation3.setAttribute("to","0");
    itsAnimation3.setAttribute("dur","1s");
    itsAnimation3.setAttribute("fill","freeze");
    itsAnimation3.setAttribute("begin","ani2"+String(i)+".begin + 9s");
    itsAnimation3.addEventListener("end",delNode,false);
    
    newTextNode.appendChild(itsAnimation1);
    newTextNode.appendChild(itsAnimation2);
    newTextNode.appendChild(itsAnimation3);
    newTextNode.appendChild(newTextNodeData);
    svgroot.appendChild(newTextNode);
    }
  }
  
  
          newTextNode = svgdoc.createElement("text");
          newTextNode.setAttribute("x","300");
                newTextNode.setAttribute("y","300");
                newTextNode.setAttribute("style","fill:white;stroke:none;font-family:helvetica,verdana,arial;font-size:14pt;opacity:0;letter-spacing:8pt;text-anchor:middle;");
                newTextNode.setAttribute("display","none");
                newTextNodeData = svgdoc.createTextNode(lastText);

                itsAnimation1 = svgdoc.createElement("animate");
                itsAnimation1.setAttribute("attributeType","CSS");
                itsAnimation1.setAttribute("attributeName","opacity");
                itsAnimation1.setAttribute("from","0");
                itsAnimation1.setAttribute("to","1");
                itsAnimation1.setAttribute("dur","1s");
                itsAnimation1.setAttribute("fill","freeze");
                itsAnimation1.setAttribute("begin",(i+5)+"s");
                itsAnimation1.setAttribute("id","ani1"+String(i));
                itsAnimation1.addEventListener("begin",showIt,false);

                itsAnimation2 = svgdoc.createElement("animateMotion");
                itsAnimation2.setAttribute("path","m0,0 v-140");
                itsAnimation2.setAttribute("dur","5s");
                itsAnimation2.setAttribute("id","ani2"+String(i));
                itsAnimation2.setAttribute("fill","freeze");
                itsAnimation2.setAttribute("begin","ani1"+String(i)+".begin");

                itsAnimation3 = svgdoc.createElement("animate");
                itsAnimation3.setAttribute("attributeType","CSS");
                itsAnimation3.setAttribute("attributeName","opacity");
                itsAnimation3.setAttribute("from","1");
                itsAnimation3.setAttribute("to","0");
                itsAnimation3.setAttribute("dur","1s");
                itsAnimation3.setAttribute("fill","freeze");
                itsAnimation3.setAttribute("begin","ani2"+String(i)+".begin + 14s");
                itsAnimation3.addEventListener("end",delNode,false);

                newTextNode.appendChild(itsAnimation1);
                newTextNode.appendChild(itsAnimation2);
                newTextNode.appendChild(itsAnimation3);
                newTextNode.appendChild(newTextNodeData);
                svgroot.appendChild(newTextNode);
  
  
}

function showIt(evt)
{
  obj = evt.target.parentNode;
  obj.removeEventListener("begin",showIt,false);
  obj.setAttribute("display","inherit");
}

function delNode(evt)
{
  obj = evt.target.parentNode;
  obj.removeEventListener("end",delNode,false); 
  svgroot.removeChild(obj); 
}
