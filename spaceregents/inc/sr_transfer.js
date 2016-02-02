function transfer_selectItem(evt)
{
	var select_item	= evt.target;
	
	// gucken ob es schon ein anderes selektiert war
	var old_item = pSvgDoc.getElementById("transfer_selectedItem");
	
	if (old_item)
	{
		old_item.setAttribute("class","mapGUI2");
		old_item.removeAttribute("id");
	}
	
	
	var popupWindow = pSvgDoc.getElementById("popupWindow");

	var selected_Item = evt.target;
	
	
	// item selectieren
	select_item.setAttribute("class","mapGUIItemSelected");
	select_item.setAttribute("id","transfer_selectedItem");
}

function transfer(plus_count)
{
	var selected_item = pSvgDoc.getElementById("transfer_selectedItem");
	var popupWindow = pSvgDoc.getElementById("popupWindow");
	var its_prod_id;
	var donator_count;
	var its_type;
	var corresponding_element, new_item, append_to, button_r;
	var search_in;
	var found;
	var i;
	var transfer_container;
	var actual_count = 0;
	var donator_count_element;
	var receiver_count_element;
	
	if (selected_item)
	{
		transfer_container = pSvgDoc.getElementById("transfer_container");
		act = transfer_container.getAttribute("act");
		selected_item 	= selected_item.parentNode;
		its_prod_id 	= selected_item.getAttribute("prod_id");
		its_type	= selected_item.parentNode.getAttribute("type");
		its_storage	= selected_item.getAttribute("storage");
		

		// Wenn source..dann gleiches element in target suchen..ansonsten andersrum
		if (its_type == "source")
		{
			search_in = selected_item.parentNode.nextSibling.childNodes;
			append_to = selected_item.parentNode.nextSibling;
			button_r = selected_item.parentNode.nextSibling.lastChild.previousSibling;
		}
		else
		{
			search_in = selected_item.parentNode.previousSibling.childNodes;
			append_to = selected_item.parentNode.previousSibling;
			button_r = selected_item.parentNode.previousSibling.lastChild.previousSibling;
		}
			

		max_items	= Number(button_r.getAttribute("max_items"));
		for (i = 0; i < (Number(search_in.length) - 2); i++)
		{
			if (search_in.item(i).getAttribute("prod_id") == its_prod_id)
			{
				corresponding_element = search_in.item(i);
				break;
			}
		}
		
		
		// neues item erstellen wenn keins vorhanden ist und plus_count positiv
		if (!corresponding_element)
		{
			item_count = Number(search_in.length) - 2;
			item_width = Number(button_r.getAttribute("item_width"));
			item_height= Number(button_r.getAttribute("item_height"));
			item_sep   = Number(button_r.getAttribute("item_sep"));
			
			max_items = Number(button_r.getAttribute("max_items"));
			
			new_x = Number(button_r.getAttribute("zeroX")) + (item_count * item_width) + (item_count * item_sep) + (item_sep / 2);
			new_y = Number(button_r.getAttribute("zeroY")) + (Number(button_r.getAttribute("box_height")) - item_height)/2;

			its_pic		= selected_item.lastChild.firstChild.getAttribute("xlink:href");
			its_name	= selected_item.getElementsByTagName("flowPara").item(0).firstChild.data;
			
			new_item = sr_create_basic_element("item","prod_id",its_prod_id,"pic_width",50);
			new_item.setAttribute("pic",its_pic);
			new_item.setAttribute("name",its_name);
			
			if (its_storage)
			{
				new_item.setAttribute("storage",its_storage);
				new_item.setAttribute("total_storage",0);
				new_item.setAttribute("original_storage",0);
			}
			
			new_count = sr_create_text_node(0);
			new_item.appendChild(new_count);
			
			corresponding_element = createTransferItem(new_item, new_x, new_y, item_width, item_height, act);
			
			append_to.insertBefore(corresponding_element, append_to.lastChild.previousSibling);
			
			// falls das element ueber den rand der box hinausgeht..scrollen
			if (item_count >= max_items)
			{
				button_r.setAttribute("override","true");
				button_r.parentNode.setAttribute("item_pos", item_count - max_items + 1);
				button_r.firstChild.firstChild.dispatchEvent(pSvgDoc.createEvent("click"));
			}
		}
		
		
		// plus_count > 0 bedeuted auf flotte (source) laden, plus_count  < 0 entladen
		// dafuer sorgen dass das obere element immer der receiver ist :S		
		if (its_type == "source")
		{			
			receiver = selected_item;
			donator  = corresponding_element;
		}
		else
		{			
			receiver = corresponding_element;
			donator  = selected_item;
		}

		// receiver (oben) werte ermitteln
		receiver_count_element = receiver.getElementsByTagName("flowPara").item(1).firstChild;
		receiver_old_count = Number(receiver_count_element.data);

		// donator (unter) werte ermitteln
		donater_count_element = donator.getElementsByTagName("flowPara").item(1).firstChild;
		donator_old_count     = Number(donater_count_element.data);		

						
		// Werte check
		
		
			// Check ob auch genuegend einheiten da sind wenn einheiten dazukommen
			if (plus_count > 0)
			{
				if (plus_count > donator_old_count)
					plus_count = donator_old_count;
			}
			else
			{
				// Check ob auch genuegend einheiten da sind, wenn einheiten abgezogen werden
				if ((plus_count * -1) > receiver_old_count)
					plus_count = receiver_old_count * -1;
			}


			// storage check
			if (act == "inf_transfer")
			{			
				receiver_free_storage_element = popupWindow.getElementsByTagName("text").item(13).firstChild;
				receiver_free_storage 	      = Number(receiver_free_storage_element.data);

				// Check ob genug Platz da ist falls auf eine Flotte geldaden wird
				if (plus_count > 0)
				{		
					needed_storage = plus_count * its_storage;
					
					if (receiver_free_storage - needed_storage < 0)
					{
						// anzahl anpassen
						plus_count = Math.floor(receiver_free_storage / its_storage);						
					}
					
				}
				
				receiver_free_storage_element.setData(receiver_free_storage - (plus_count * its_storage));
			}
		
		
		
		// receiver
			// Item aktualisieren
			receiver_new_count = receiver_old_count + plus_count;
			
			// Wenn kleiner gleich 0 Item entfernen
			if (receiver_new_count <= 0)
			{
				removeTransferItem(receiver);
			}
			else			
				receiver_count_element.setData(receiver_new_count);
			
		// donator
			// item akutualisieren
			donator_new_count  = donator_old_count - plus_count;
			
			if (donator_new_count <= 0)
			{
				removeTransferItem(donator);
			}
			else			
			donater_count_element.setData(donator_new_count);
			
			
		
		
	}
}


function removeTransferItem(its_item)
{
	var update = "false";

	var items  	 = its_item.parentNode.childNodes;
	var its_button_r = its_item.parentNode.lastChild.previousSibling;
	
	var max_items   = Number(its_button_r.getAttribute("max_items"));
	var item_pos	= Number(its_item.parentNode.getAttribute("item_pos"));
	
	var old_x 	= Number(its_item.firstChild.getAttribute("x"));
	var old_pic_x 	= Number(its_item.lastChild.firstChild.getAttribute("x"));
	
	var new_x, new_pic_x;
	var i;
	
	for (i = 0; i < (Number(items.length) - 2); i++)
	{
		if (update == "true")
		{
			new_x		= old_x;
			new_pic_x	= old_pic_x;
			
			old_x 		= Number(items.item(i).firstChild.getAttribute("x"));
			old_pic_x	= Number(items.item(i).lastChild.firstChild.getAttribute("x"));

			// rechteck
			items.item(i).firstChild.setAttribute("x",new_x);
			
			// bild			
			items.item(i).lastChild.firstChild.setAttribute("x",new_pic_x);
			
			// flow_text
			items.item(i).lastChild.getElementsByTagName("rect").item(0).setAttribute("x", new_x + 2);
			
			// gegebenenfalls anzeigen
			if (i <= max_items)
			{				
				items.item(i).setAttribute("display","inherit");
			}
				
		}
		
		if ((update == "false") && (its_item == items.item(i)))
		{
			update = "true";
		}
		
	}
	
	// item entfernen	
	its_item.parentNode.removeChild(its_item);
	
	// vielleicht auch den rechts scroll button verstecken?
	if (Number(items.length) - 2 <= max_items)
		its_button_r.setAttribute("display","none");
	
	// item position zurueckstellen
	if ((Number(items.length) - 2) < (item_pos + 1))
		its_button_r.parentNode.setAttribute("item_pos", Number(items.length) - 2);
}



function transfer_itemScroll(evt, scroll_to)
{
	var item_box;
	var item_pos, item_count, max_items, item_sep, item_width;
	var scroll_button;
	var new_translate;
	var i;
	
	scroll_button 	= evt.target.parentNode.parentNode;
	item_box	= scroll_button.parentNode;
	item_pos	= Number(item_box.getAttribute("item_pos"));
	
	item_childs 	= item_box.childNodes;
	item_count	= Number(item_childs.length) - 2;		// die letzten beiden childs sind die buttons
	max_items	= Number(scroll_button.getAttribute("max_items"));
	
	item_sep	= Number(scroll_button.getAttribute("item_sep"));
	item_width	= Number(scroll_button.getAttribute("item_width"));
	
	if (scroll_button.getAttribute("override") == "true")
	{
		scroll_button.removeAttribute("override");
		for (i = 0; i < item_count; i++)
		{
			if (i < item_pos)
				item_childs.item(i).setAttribute("display","none");
			else
				item_childs.item(i).setAttribute("display","inherit");		
		}
		
	}
	else
	{	
		if (scroll_to == "90")
		{
			item_childs.item(item_pos).setAttribute("display","none");
			item_childs.item(max_items + item_pos).setAttribute("display","inherit");
			item_pos	+= 1;
		}
		else
		{
			item_pos	-= 1;
			
			if (item_childs.item(max_items + item_pos))
				item_childs.item(max_items + item_pos).setAttribute("display","none");
				
			item_childs.item(item_pos).setAttribute("display","inherit");
		}
	}

	new_translate = item_pos * ((item_sep + item_width) * -1);
	item_box.setAttribute("transform","translate("+(new_translate)+" 0)");	
	
	item_childs.item(item_count).setAttribute("transform","translate("+(-new_translate)+" 0)");
	item_childs.item(item_count + 1).setAttribute("transform","translate("+(-new_translate)+" 0)");
	
	
	
	// derzeitige item position notieren		
	item_box.setAttribute("item_pos",item_pos);
	
	
	// button anzeigen bzw. ausblenden
	if (item_pos == 0)
		item_box.lastChild.setAttribute("display","none");
	else
		item_box.lastChild.setAttribute("display","inherit");
	
	
	if ((item_pos  == item_count - max_items) || (item_count < max_items))
		item_box.lastChild.previousSibling.setAttribute("display","none");
	else
		item_box.lastChild.previousSibling.setAttribute("display","inherit");		
}


function transfer_commit()
{
	var items = new Array();
	
	var transfer_container 	= pSvgDoc.getElementById("transfer_container");
	var popupWindow		= pSvgDoc.getElementById("popupWindow");
	
	var source_type		= transfer_container.getElementsByTagName("source").item(0).getAttribute("type");
	var source_id		= transfer_container.getElementsByTagName("source").item(0).getAttribute("source_id");

	var target_type		= transfer_container.getElementsByTagName("target").item(0).getAttribute("type");
	var target_id		= transfer_container.getElementsByTagName("target").item(0).getAttribute("target_id");
	
	
	// es werden nur die daten einer seite gebraucht, der rest wird berechnet
	// in diesem fall, der donator (unten)
	
	var donator_childs	= popupWindow.lastChild.childNodes;
	var act			= transfer_container.getAttribute("act");
	
	var i;
	var prod_ids	= new Array();
	var counts	= new Array();
	
	for (i = 0; i < Number(donator_childs.length) - 2; i++)	
	{
		prod_ids[i]	= Number(donator_childs.item(i).getAttribute("prod_id"));
		counts[i]	= Number(donator_childs.item(i).getElementsByTagName("flowPara").item(1).firstChild.data);
	}
	
	getURL("map_command.php?act="+act+"&productions[]="+prod_ids+"&counts[]="+counts+"&s_type="+source_type+"&s_id="+source_id+"&t_type="+target_type+"&t_id="+target_id, transfer_commit_request);
}


function transfer_commit_request(request)
{
	if (request.success)	
	{
		if (request.content != "")
		{
			createInfoText("Units transfered!","lime");
			
			var reg_exp = /^true\s(\d*)\s(\d*)/;
			
			reg_exp.exec(request.content);
			
			// flotte neu laden
			getURL("map_getinfo.php?act=fleet_detail&target="+RegExp.$1+"&current_planet="+RegExp.$2,postURLCallbackPanel);
			clearUnitsDisplay();			
			removePopupWindow()
		}
	}
	else
	{
		createInfoText("Your request failed!","red");
	}
}