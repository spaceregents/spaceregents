<?
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/trade.inc.php";
include "../spaceregentsinc/class_stockmarket.inc.php";

if ($not_ok)
  return 0;


function show_stockmarket()
{
}


function show_stockmarket_stats()
{
  table_start("center",500);

  echo("<tr><td>");
  echo("<embed width=\"500\" height=\"200\" type=\"text/image+svg\" src=\"http://www.spaceregents.de/trade_stats.svg\" align=\"center\" />");
  echo("</tr></td>");
  table_end();
  // LAST PRICE
  $sth = mysql_query("SELECT type, last_price FROM stockmarkets");
  
  if (!$sth || mysql_num_rows($sth) == 0)
  {
    show_error("ERROR:GET LAST PRICES");
    return false;
  }
  
  table_start("center", "500");
  table_text(Array("Last prices (&euro;)"),"","","6","head");
  
  while ($stats = mysql_fetch_assoc($sth))
  {
    $res_name = get_resource_name($stats["type"]);
    $pic_arr[] = "<img src=\"arts/".$res_name.".gif\" alt=\"".$res_name."\" border=\"0\" />";
    $price_arr[] = $stats["last_price"];
  }
  table_text($pic_arr,"center","","","head");
  table_text($price_arr,"center","","","text");
  table_end();
}


function show_orders()
{
  global $uid;
  global $PHP_SELF;
  
  // BUY ORDERS
  $sth = mysql_query("SELECT * FROM stockmarket_orders WHERE uid=".$uid." AND type=".BUY_ORDER." ORDER by stockmarket, time");
  
  if (!$sth)
  {
    show_message("ERROR:: GET BUY ORDERS");
    return false;
  }
  
  if (mysql_num_rows($sth) == 0)
  {
    table_start("center",500);
    table_text(Array("Buy Orders"),"","","5","head");
    table_text(Array("No orders"),"","","5","text");
    table_end();
  }
  else
  {
    table_start("center",500);
    table_text(Array("Buy Orders"),"","","5","head");
    table_text(Array("&nbsp;", "amount", "max buy price", "time", "&nbsp;"),"","","","text");
    while ($buy_order = mysql_fetch_assoc($sth))
    {
      $resource = get_resource_name($buy_order["stockmarket"]);
      $pic      = "<img src=\"arts/".$resource.".gif\" alt=\"".$resource."\" border=\"0\" />\n";
      $link     = "<a href=\"".$PHP_SELF."?act=remove_order&type=".BUY_ORDER."&res=".$buy_order["stockmarket"]."&time=".$buy_order["time"]."\">remove order</a>";
      table_text(Array($pic, $buy_order["amount"], ($buy_order["price"] < 100) ? $buy_order["price"] : "unlimited", $buy_order["time"], $link), "", "", "", "text");
    }
    table_end();
  }

  echo("<br />\n");  
  
  // SELL ORDERS
  $sth = mysql_query("SELECT * FROM stockmarket_orders WHERE uid=".$uid." AND type=".SELL_ORDER." ORDER by stockmarket, time");
  
  if (!$sth)
  {
    show_message("ERROR:: GET SELL ORDERS");
    return false;
  }
  
  if (mysql_num_rows($sth) == 0)
  {
    table_start("center",500);
    table_text(Array("Sell Orders"),"","","5","head");
    table_text(Array("No orders"),"","","5","text");
    table_end();
  }
  else
  {
    table_start("center",500);
    table_text(Array("Sell Orders"),"","","5","head");
    table_text(Array("&nbsp;", "amount", "min sell price", "time", "&nbsp;"),"","","","text");
    while ($sell_order = mysql_fetch_assoc($sth))
    {
      $resource = get_resource_name($sell_order["stockmarket"]);
      $pic      = "<img src=\"arts/".$resource.".gif\" alt=\"".$resource."\" border=\"0\" />\n";
      $link     = "<a href=\"".$PHP_SELF."?act=remove_order&type=".SELL_ORDER."&res=".$sell_order["stockmarket"]."&time=".$sell_order["time"]."\">remove order</a>";
      table_text(Array($pic, $sell_order["amount"], ($sell_order["price"] > 0) ? $sell_order["price"] : "unlimited", $sell_order["time"], $link), "", "", "", "text");
    }
    table_end();
  }
}
//-----------------------------------------------------------


function show_add_orders()
{
  global $PHP_SELF;
  echo("<form method=\"post\" action=\"".$PHP_SELF."?act=add_order\">\n");
  table_start("center",500);
  table_text(Array("Give trade Order"),"","","5","head");
  table_text(Array("resource", "amount", "price", "type", "&nbsp;"),"center","","","text");
  
  $resource = "<select name=\"res\" size=\"1\">
               <option value=\"MET\" selected>Metal</option>
               <option value=\"ENE\">Energy</option>
               <option value=\"MOP\">Mopgas</option>
               <option value=\"ERK\">Erkunum</option>
               <option value=\"GOR\">Gortium</option>
               <option value=\"SUS\">Susebloom</option>
               </select>\n";
               
  $amount = "<input name=\"amount\" value=\"0\" size=\"6\" />\n";
  $price  = "<input name=\"price\" value=\"0\" size=\"2\" maxlength=\"2\" />\n";
  $type   = "<select name=\"type\" size=\"1\">
             <option value=\"".BUY_ORDER."\" selected>BUY</option>
             <option value=\"".SELL_ORDER."\">SELL</option>
             </select>\n";
  
  $commit = "<input type=\"submit\" value=\"enter order\" />\n";
  table_text(Array($resource, $amount, $price, $type, $commit),"center","","","text");
  table_text(Array("&middot; The price determines the <strong>highest price</strong> you'd pay if you <strong>buy</strong> or<br />
                    &nbsp;&nbsp;the <strong>lowest price</strong>, at your are willing to <strong>sell</strong>.<br />
                    &nbsp;&nbsp;It might be that you trade at better conditions."),"left","","5","textnote");
  
  table_text(Array("&middot; Leaving the price at zero will enter an unlimited order.<br />
                    &nbsp;&nbsp;That means that you don't care about the price at what you will sell or buy.<br>
                    &nbsp;&nbsp;The price might be pretty bad then. =P"),"left","","5","textnote");
  table_end();
  echo("</form>\n");  
  echo("<br />\n");
}
//-----------------------------------------------------------


function func_remove_order($stocktype, $type, $timestamp)
{
  global $uid;
  
  if (!$stocktype)  
  {
    show_message("No resource defined");
    return false;
  }
  
  $stockmarket = new stockmarket($stocktype);
  
  if ($type == BUY_ORDER)
    $stockmarket->delete_buy_order($timestamp, $uid);
  else
    $stockmarket->delete_sell_order($timestamp, $uid);
}
//-----------------------------------------------------------


function func_add_order($stocktype, $type, $amount, $price)
{
  global $uid;
  
  if (!$stocktype)  
  {
    show_message("No resource defined");
    return false;
  }
  
  $stockmarket = new stockmarket($stocktype);
  
  $amount = floor((float) $amount);
  $price  = floor((float) $price);
  
  if ($amount < 1)
  {
    show_message("You must enter a higher amount than zero");
    return false;
  }
  
  if ($price < 0 || $price > $stockmarket->max_price)
  {
    show_message("The price may not be smaller than zero or greater than ".$stockmarket->max_price);
    return false;
  }
  $type = (int) $type;

  if ($type == BUY_ORDER)
  {
    if ($price == 0)
      $stockmarket->add_unlimited_buy_order($amount, $uid);
    else
      $stockmarket->add_buy_order($price, $amount, $uid);      
  }
  else
  {
      if ($price == 0)
      $stockmarket->add_unlimited_sell_order($amount, $uid);
    else
      $stockmarket->add_sell_order($price, $amount, $uid);      
  }
}
//-----------------------------------------------------------


function show_stock_ticker()
{
  global $uid;
  
  $sth = mysql_query("SELECT time, message FROM stockmarket_ticker WHERE uid=".$uid." ORDER BY time");
  
  if (!$sth)
  {
    show_error("ERROR::GET TRADE TICKER");
    return false;
  }
  
  if (mysql_num_rows($sth)==0)
  {
    table_start("center",500);
    table_text(Array("Trade Ticker"),"","","","head");
    table_text(Array("No transactions"),"","","","text");
    table_end();
  }
  else
  {
    table_start("center",500);
    table_text(Array("Trade Ticker"),"","","2","head");
    
    while ($ticker = mysql_fetch_row($sth))
    {
      table_text(Array($ticker[0],$ticker[1]),"","","","text");
    }
    table_end();
    echo("<br />\n");
    
    $sth = mysql_query("DELETE FROM stockmarket_ticker WHERE uid=".$uid);

    if (!$sth)
    {
      show_error("ERROR::GET DELETE TICKER");
      return false;
    }
  }
}
//-----------------------------------------------------------


function check_tradestation()
{
  global $uid;
  
  return has_tradestation($uid);
}
//-----------------------------------------------------------


if (!check_tradestation())
{
  show_message("You must build a tradestation if you want to trade");
}
else
{
  switch ($act)
  {
    case "remove_order":
      show_stockmarket_stats();
      func_remove_order($_GET["res"], $_GET["type"], $_GET["time"]);
      show_add_orders();
      show_stock_ticker();
      show_orders();
    break;
    case "add_order":
      show_stockmarket_stats();
      func_add_order($_POST["res"], $_POST["type"], $_POST["amount"], $_POST["price"]);
      show_add_orders();
      show_stock_ticker();
      show_orders();
    break;
    default:
      show_stockmarket_stats();
      show_add_orders();
      show_stock_ticker();
      show_orders();
    break;
  }
}

// ENDE
include "../spaceregentsinc/footer.inc.php";

?>