function trade_dialog_bring_to_front(evt)
{
	page = evt.target.parentNode;
	
	// erstmal gucken ob das angeklickte Objekt eine page ist..
	if (page.id.substring(0,16) == "popupWindow_Page")
	{
	
		// Wenn ja, ueberpruefen ob das Objekt unter einer anderen Page liegt
		if (page.nextSibling.id.substring(0,16) == "popupWindow_Page")
		{
			page_to_back = page.nextSibling;
			page.parentNode.insertBefore(page_to_back, page);
		}
	}
}

function trade_select_item(evt)
{
	// altes vorschaufenster leeren
	if (pSvgDoc.getElementById("trade_item_preview"))
	{
		removeObject(pSvgDoc.getElementById("trade_item_preview"));
	}
	
	// alte Daten leeren
	if (pSvgDoc.getElementById("trade_dialog_user_money"))
	{
		pSvgDoc.getElementById("trade_dialog_user_money").firstChild.setData(pSvgDoc.getElementById("trade_dialog_user_money").getAttribute("original_value"));
		pSvgDoc.getElementById("trade_dialog_resource_amount").firstChild.setData(0);
		pSvgDoc.getElementById("trade_dialog_total_price").firstChild.setData(0);

		// position fuer die Vorschau ermitteln
		item_preview_rect 	= pSvgDoc.getElementById("trade_dialog_item_preview");
		item_preview_x		= Number(item_preview_rect.getAttribute("x"));
		item_preview_y		= Number(item_preview_rect.getAttribute("y"));
		item_preview_width	= Number(item_preview_rect.getAttribute("width"));
		item_preview_height	= Number(item_preview_rect.getAttribute("height"));

		trade_obj = evt.target.parentNode;

		// alle noetigen Daten erfassen (preis, menge und das bild)
		price 		= trade_obj.getAttribute("price");
		count 		= trade_obj.getAttribute("count");
		pic   		= trade_obj.getAttribute("pic");
		pic_width  	= Number(trade_obj.getAttribute("pic_width"));
		pic_height 	= Number(trade_obj.getAttribute("pic_height"));
		item_type	= trade_obj.getAttribute("item_type");
		item_id		= trade_obj.getAttribute("item_id");

		pic_x = item_preview_x + (item_preview_width - pic_width) / 2;
		pic_y = item_preview_y + 4.15;

		if (count != "sold out" && price != "-")
		{
			// in dem vorschaufenster anzeigen
			item_preview = pSvgDoc.createElement("g");
			item_preview.setAttribute("id","trade_item_preview");
			item_preview.setAttribute("item_type",item_type);
			item_preview.setAttribute("item_id",item_id);
			item_preview.setAttribute("price",price);
			item_preview.setAttribute("count",count);
			item_preview.setAttribute("current_count",0);

			item_preview_pic = sr_create_image(pic, pic_x, pic_y, pic_width, pic_height);		
			item_preview_price = sr_create_text("$ "+price,item_preview_x + 4.15, (item_preview_y + item_preview_height) - 20, "mapDialogText2");
			item_preview_count = sr_create_text("# "+count,item_preview_x + 4.15, (item_preview_y + item_preview_height) - 5, "mapDialogText2");

			item_preview.appendChild(item_preview_pic);
			item_preview.appendChild(item_preview_price);
			item_preview.appendChild(item_preview_count);

			item_preview_rect.parentNode.appendChild(item_preview);
		}
	}
}

function trade(plus_count)
{
	item_preview = pSvgDoc.getElementById("trade_item_preview");
	
	if (item_preview)
	{
		user_money_data   	= pSvgDoc.getElementById("trade_dialog_user_money").firstChild;
		resource_amount_data  	= pSvgDoc.getElementById("trade_dialog_resource_amount").firstChild;
		total_price_data	= pSvgDoc.getElementById("trade_dialog_total_price").firstChild;

		// Preis und Menge ermitteln
		price = Number(item_preview.getAttribute("price"));
		count = Number(item_preview.getAttribute("count"));
		rate  = Number(item_preview.getAttribute("current_count"));
		money = Number(user_money_data.parentNode.getAttribute("original_value"));

		plus_count += rate;

		if ((count - plus_count) < 0)
		{
			plus_count = count;
		}

		if ((plus_count * price) > money)
		{
			plus_count = Math.floor(money / price);
		}

		if (plus_count < 0)
			plus_count = 0;

		trade_price = plus_count * price;

		user_money_data.setData(money - trade_price);
		resource_amount_data.setData(plus_count);
		total_price_data.setData(Math.ceil(trade_price));
		item_preview.setAttribute("current_count",plus_count);
		item_preview.lastChild.firstChild.setData("# "+(count - plus_count));
	}
}

function trade_submit()
{
	item_preview = pSvgDoc.getElementById("trade_item_preview");
	
	if (item_preview)
	{
		amount  = Number(item_preview.getAttribute("current_count"));
		
		if (amount > 0)
		{
			item_typ= item_preview.getAttribute("item_type");
			item_id = item_preview.getAttribute("item_id");
			station_id = pSvgDoc.getElementById("popupWindow").getAttribute("tid");
			trade_submit_button = pSvgDoc.getElementById("trade_submit_button");
			trade_submit_button.setAttribute("display","none");


			// Handelsanfrage an server senden
			getURL("map_command.php?act=trade&amount="+amount+"&item_typ="+item_typ+"&item_id="+item_id+"&sid="+station_id,trade_submit_callback);
		}
	}
}

function trade_submit_callback(request)
{
	if (request.success)
	{
		trade_submit_button = pSvgDoc.getElementById("trade_submit_button");
		trade_submit_button.removeAttribute("display");
		
		// schnell noch daten reinhole
		item_preview = pSvgDoc.getElementById("trade_item_preview");
		price = Number(item_preview.getAttribute("price"));
		rate  = Number(item_preview.getAttribute("current_count"));
		
		total_price = price * rate;
		
		// jetzt koennen wirs endlich loeschen
		removeObject(item_preview);
						
		$request_content = request.content;
		
		if ($request_content == "true")
		{
			// eigenes geld und die anzahl der items auf der station updaten		
			user_money_data   = pSvgDoc.getElementById("trade_dialog_user_money").firstChild;
			money = Number(user_money_data.parentNode.getAttribute("original_value"));
			money -= total_price;
			user_money_data.setData(money);
			user_money_data.parentNode.setAttribute("original_value",money);

			item_id 	= item_preview.getAttribute("item_id");		
			trade_item 	= pSvgDoc.getElementById("trade_item_"+item_id);
			trade_item_count = Number(trade_item.firstChild.data.substr(2));
			trade_item_count -= rate;
			trade_item.parentNode.setAttribute("count",trade_item_count);
			
			// falls nur noch 0 vorhanden...sold out...
			if (trade_item_count > 0)
				trade_item.firstChild.setData("# "+trade_item_count);
			else			
			{
				trade_item.firstChild.setData("# sold out");
				trade_item.parentNode.removeAttribute("onclick");
			}
			
			createInfoText("We made it","green");
		}
		else
		{
			createInfoText("There was an error :/","red");
		}
	}
	else
	{
		createInfoText("Trade failed!","red");
	}
}
