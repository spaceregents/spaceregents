function preload()
{
  pre_bild = new Array();
  pre_bilder = new Array();
  pre_bilder[1] = "skins/metal_blue_menu800.jpg";
  pre_bilder[2] = "skins/metal_blue_texture.jpg";
  pre_bilder[3] = "skins/metal_blue/allbutton.jpg";
  pre_bilder[4] = "skins/metal_blue/G_allbutton.jpg";
  pre_bilder[5] = "skins/metal_blue/anouncementbutton.jpg";
  pre_bilder[6] = "skins/metal_blue/G_anouncementbutton.jpg";
  pre_bilder[7] = "skins/metal_blue/attackbutton.jpg";
  pre_bilder[8] = "skins/metal_blue/G_attackbutton.jpg";
  pre_bilder[9] = "skins/metal_blue/mailbutton.jpg";
  pre_bilder[10] = "skins/metal_blue/G_mailbutton.jpg";
  pre_bilder[11] = "skins/metal_blue/researchbutton.jpg";
  pre_bilder[12] = "skins/metal_blue/G_researchbutton.jpg";
  pre_bilder[13] = "skins/metal_blue/spybutton.jpg";
  pre_bilder[14] = "skins/metal_blue/G_spybutton.jpg";
  pre_bilder[15] = "arts/mopgas.jpg";
  pre_bilder[16] = "arts/susebloom.jpg";
  pre_bilder[17] = "arts/gortium.jpg";
  pre_bilder[18] = "arts/erkunum.jpg";
  pre_bilder[19] = "arts/metal.jpg";
  pre_bilder[19] = "arts/energy.jpg";
  pre_bilder[20] = "arts/spy.jpg";
  pre_bilder[21] = "arts/wichtig.jpg";
  pre_bilder[22] = "arts/mail.jpg";
  pre_bilder[23] = "arts/research.jpg";
  pre_bilder[24] = "arts/underattack.jpg";
  pre_bilder[25] = "arts/help.jpg";
  pre_bilder[26] = "skins/metal_blue_infan.jpg";
  pre_bilder[27] = "skins/metal_blue_fleet.jpg";
  pre_bilder[28] = "skins/metal_blue_left.jpg";
  pre_bilder[29] = "skins/metal_blue_right.jpg";
  pre_bilder[30] = "skins/metal_blue_database.jpg";
  pre_bilder[31] = "skins/metal_blue_mail.jpg";
  pre_bilder[32] = "skins/metal_blue_notebook.jpg";
  pre_bilder[33] = "skins/metal_blue_planetinfo.jpg";
  pre_bilder[34] = "skins/metal_blue_production.jpg";
  pre_bilder[35] = "arts/minus.jpg";
  pre_bilder[36] = "arts/minus_over.jpg";
  pre_bilder[37] = "arts/plus.jpg";
  pre_bilder[38] = "arts/plus_over.jpg";
  pre_bilder[39] = "arts/hoch.jpg";
  pre_bilder[40] = "arts/hoch_over.jpg";
  pre_bilder[41] = "arts/runter.jpg";
  pre_bilder[42] = "arts/runter_over.jpg";
  pre_bilder[43] = "arts/dblhoch.jpg";
  pre_bilder[44] = "arts/dblhoch_over.jpg";
  pre_bilder[45] = "arts/dblrunter.jpg";
  pre_bilder[46] = "arts/dblrunter_over.jpg";
  pre_bilder[47] = "arts/links.jpg";
  pre_bilder[48] = "arts/links_over.jpg";
  pre_bilder[49] = "arts/dbllinks.jpg";
  pre_bilder[50] = "arts/dbllinks_over.jpg";
  pre_bilder[51] = "arts/rechts.jpg";
  pre_bilder[52] = "arts/rechts_over.jpg";
  pre_bilder[53] = "arts/dblrechts.jpg";
  pre_bilder[54] = "arts/dblrechts_over.jpg";
  pre_bilder[55] = "arts/T.jpg";
  pre_bilder[56] = "arts/M.jpg";
  pre_bilder[57] = "arts/A.jpg";
  pre_bilder[58] = "arts/D.jpg";
  pre_bilder[59] = "arts/G.jpg";
  pre_bilder[60] = "arts/H.jpg";
  pre_bilder[61] = "arts/R.jpg";
  pre_bilder[62] = "arts/O.jpg";
  pre_bilder[63] = "arts/I.jpg";
  pre_bilder[64] = "arts/E.jpg";

  status = "preloading images..."
  if (document.all)
   {
	  for (i = 1; i < pre_bilder.length; i++)
	    {
		 p = Math.round((i * 100)/pre_bilder.length);
		 pre_bild[i] = new Image();
	     pre_bild[i].src = pre_bilder[i];
//		  if (pre_bild[i].complete==true)
		  status = "preloading Images : "+p+"% completed ("+pre_bilder[i]+")";
//		  else
//		  i=i-1;
		}
    }
  else
   {
	  for (i = 0; i < pre_bilder.length; i++)
	    {
		 geladen=false;
		 p = Math.round((i * 100)/pre_bilder.length);
	 	 pre_bild[i] = new Image();
		 pre_bild[i].src = pre_bilder[i];
	 	 status = "preloading Images : "+Math.round(p)+"% completed ("+pre_bilder[i]+")";
		}
    }
  
	
     status = "preloading Images : finished ("+pre_bilder.length+" Images)";

   for (i = 1; i < pre_bilder.length; i++)
    {pre_bild[i] = null;
	 pre_bilder[i] = null;
	}
p = null;	
pre_bild = null;
pre_bilder= null;	
i = null; 
}  
  
