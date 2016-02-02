function open_window(x1,y1,info1)
      {
       if (document.all)
		   {   		    
		    document.all.argh.style.visibility = "visible";
		    document.all.argh.style.position = "absolute";
		    document.all.argh.style.left = x1;
		    document.all.argh.style.top = y1;
			document.all.argh.style.backgroundImage = "url(mappopup.php)";
		    document.all.argh.style.color = "red";
			document.all.argh.innerText = info1;
		  }
		  else 
		   {
		    document.layers['argh_n'].visibility = "show";
		    document.layers['argh_n'].left = x1;
		    document.layers['argh_n'].top = y1;
			document.layers['argh_n'].document.open();		
			document.layers['argh_n'].document.write("<layer background='mappopup.php'>");		
			document.layers['argh_n'].document.write("<font color='red'>");
			document.layers['argh_n'].document.write(info1);
			document.layers['argh_n'].document.write("</font>");
			document.layers['argh_n'].document.write("</layer>");		
			document.layers['argh_n'].document.close();
		   }
		 }
		 
function hide_window()
  {
       if (document.all)
		   {   
		    document.all.argh.style.visibility = "hidden";
		  }
		  else 
		   {
		    document.layers['argh_n'].visibility = "hide";
		   }
  }
