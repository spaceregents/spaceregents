<?php

class stockmarket
{
  var $stocktype;         // der typ der resource die gehadelt wird(metal etc)
  var $trade_price;        // der preis zu dem in diesem moment gehandelt wird
  var $trade_number;       // die Anzahl der zu handelden waren zu diesem preis
  var $last_price;        // der preis, zu dem zuletzt gehandelt wurde
  var $max_price;         // der maximale preis zu dem gehandelt werden kann (99)
  var $stocks_traded;     // die anzahl der gesamten waren die gehandelt wurden
                          // die buy_orders und sell_orders werden via 'direct addressing' (der preis ist key) gespeichert
  var $buy_orders   = Array();
  var $sell_orders  = Array();
  var $user_money   = Array();    // speichert via direct adressing das geld aller user die eine BUY ORDER abgegeben haben user_money[uid] = money
  var $user_fail_chance = Array();  // speichert via direct adressing dir fial_chance aller user die irgendeine order abgegeben haben user_fail_chance[uid] = fail_chance;
  var $highest_buy_price = 0;      // der maximalste preis wo noch jemand was kaufen will  
    
  function stockmarket($stocktype)
  {
    $sth = mysql_query("SELECT * FROM stockmarkets WHERE type = '".$stocktype."'");
    
    if (!$sth || mysql_num_rows($sth) == 0)
    {
      echo("ERROR::GETTING STOCKMARKETS");
      return false;
    }
    
    $stockmarket = mysql_fetch_assoc($sth);
    
    $this->stocktype      = $stocktype;
    $this->last_price     = $stockmarket["last_price"];
    $this->max_price      = $stockmarket["max_price"];
    $this->stocks_traded  = $stockmarket["stocks_traded"];
    $this->trade_price     = 0;
    $this->trade_number    = 0;
  }
  //------------------------------------------------------------------

  
  function get_user_money()
  {
    $sth = mysql_query(" SELECT r.uid, money from ressources r join stockmarket_orders s using(uid) where s.stockmarket = '".$this->stocktype."' group by r.uid;");
    
    if (!$sth)
    {
      echo("ERROR::GET MONEY");
      return false;
    }

    while ($money = mysql_fetch_row($sth))
      $this->user_money[$money[0]] = $money[1];
  }
  //------------------------------------------------------------------
  
  
  function get_user_fail_chance()
  {
    $sth = mysql_query("SELECT uid, fail_chance FROM tradestations WHERE uid IN (SELECT DISTINCT uid FROM stockmarket_orders)");

    if (!$sth)
    {
      echo("ERROR::GET FAIL CHANCE");
      return false;
    }

    while ($fail_chance = mysql_fetch_row($sth))
      $this->user_fail_chance[$fail_chance[0]] = $fail_chance[1];
  }
  //------------------------------------------------------------------

  
  function add_buy_order($price, $amount, $uid)
  {
    $sth = mysql_query("INSERT INTO stockmarket_orders (stockmarket, type, price, amount, uid) values ('".$this->stocktype."', '".BUY_ORDER."','".$price."', '".$amount."', '".$uid."')");
    
    if (!$sth)
    {
      echo("ERROR::INSERT BUY ORDER");
      return false;
    }
    
    $this->trade();
  }
  //------------------------------------------------------------------

  
  function add_unlimited_buy_order($amount, $uid)
  {
    $this->add_buy_order($this->max_price+1, $amount, $uid);
  }
  //------------------------------------------------------------------

  
  function add_sell_order($price, $amount, $uid)
  {
    $resource = get_resource_name($this->stocktype);
    
    $sth = mysql_query("SELECT ".$resource." FROM ressources WHERE uid = ".$uid);
    
    if (!$sth || mysql_num_rows($sth) == 0)
    {
      show_error("ERROR::GET RESOURCE ".$resource);
      return false;
    }
    
    list($resource_count) = mysql_fetch_row($sth);
    
    if ($resource_count >= $amount)
    {
      $sth = mysql_query("UPDATE ressources SET ".$resource." = ".$resource." - ".$amount." WHERE uid = ".$uid);

      if (!$sth)
      {
        show_error("ERROR::REMOVE RESOURCE ".$resource);
        return false;
      }

      $sth = mysql_query("UPDATE tradestations SET ".$resource." = ".$resource." + ".$amount." WHERE uid = ".$uid);

      if (!$sth)
      {
        show_error("ERROR::TRANSFER RESOURCE ".$resource." TO TRADESTATION");
        return false;
      }
    }
    else
    {
      show_message("Not enough ".$resource." on stocks to enter the Sell Order");
      return false;
    }
    
    $sth = mysql_query("INSERT INTO stockmarket_orders (stockmarket, type, price, amount, uid) values ('".$this->stocktype."', '".SELL_ORDER."','".$price."', '".$amount."', '".$uid."')");
    
    if (!$sth)
    {
      echo("ERROR::INSERT SELL ORDER");
      return false;
    }
    $this->trade();
  }
  //------------------------------------------------------------------


  function add_unlimited_sell_order($amount, $uid)
  {
    $this->add_sell_order(0, $amount, $uid);
  }
  //------------------------------------------------------------------
  
  
  function delete_buy_order($timestamp, $uid)
  {
    $sth = mysql_query("DELETE FROM stockmarket_orders WHERE time = '".$timestamp."' and uid = '".$uid."' and stockmarket='".$this->stocktype."' and type='".BUY_ORDER."'");

    if (!$sth)
    {
      echo("ERROR::DELETE BUY ORDER");
      return false;
    }
  }
  //------------------------------------------------------------------

  
  function delete_sell_order($timestamp, $uid)
  {
    $sth = mysql_query("SELECT amount FROM stockmarket_orders WHERE time = '".$timestamp."' and uid = '".$uid."' and stockmarket='".$this->stocktype."' and type='".SELL_ORDER."'");

    if (!$sth || mysql_num_rows($sth) == 0)
    {
      echo("ERROR::GET SELL ORDER AMOUNT");
      return false;
    }
    
    list($amount) = mysql_fetch_row($sth);

    $sth = mysql_query("DELETE FROM stockmarket_orders WHERE time = '".$timestamp."' and uid = '".$uid."' and stockmarket='".$this->stocktype."' and type='".SELL_ORDER."'");

    if (!$sth)
    {
      echo("ERROR::DELETE SELL ORDER");
      return false;
    }
    
    $resource = get_resource_name($this->stocktype);
    
    $sth = mysql_query("UPDATE ressources SET ".$resource." = ".$resource." + ".$amount." WHERE uid = ".$uid);

    if (!$sth)
    {
      show_error("ERROR::TRANSFER RESOURCE ".$resource." TO GLOBAL RESOURCES");
      return false;
    }

    $sth = mysql_query("UPDATE tradestations SET ".$resource." = ".$resource." - ".$amount." WHERE uid = ".$uid);

    if (!$sth)
    {
      show_error("ERROR::SUBSTRACT RESOURCE ".$resource." FROM TRADESTATION");
      return false;
    }
  }
  //------------------------------------------------------------------

  
  function get_buy_orders()
  {
    $sth = mysql_query("SELECT * FROM stockmarket_orders WHERE stockmarket='".$this->stocktype."' and type = ".BUY_ORDER." ORDER BY time");
    
    if (!$sth)
    {
      echo("ERROR::GETTING BUY ORDER");
      return false;
    }

    $this->highest_buy_price = 0;
    
    if (mysql_num_rows($sth) > 0)
    {
      while ($_buy_orders = mysql_fetch_assoc($sth))
      {
        if ($_buy_orders["price"] > $this->highest_buy_price && $_buy_orders["price"] <= $this->max_price) $this->highest_buy_price = $_buy_orders["price"];
        
        $order = new order($_buy_orders["amount"], $_buy_orders["price"], $_buy_orders["uid"], $_buy_orders["time"], $this->stocktype);
        
        if ($this->buy_orders[$_buy_orders["price"]] == null)
          $this->buy_orders[$_buy_orders["price"]] = $order;
        else
          $this->buy_orders[$_buy_orders["price"]]->add_order($order);
      }
    }
  }
  //------------------------------------------------------------------
  

  function get_sell_orders()
  {
    $sth = mysql_query("SELECT * FROM stockmarket_orders WHERE stockmarket='".$this->stocktype."' and type = ".SELL_ORDER." ORDER BY time");
    
    if (!$sth)
    {
      echo("ERROR::GETTING SELL ORDER");
      return false;
    }

    if (mysql_num_rows($sth) > 0)
    {
      $i = 0;
      while ($_sell_orders = mysql_fetch_array($sth))
      {
        $order = new order($_sell_orders["amount"], $_sell_orders["price"], $_sell_orders["uid"], $_sell_orders["time"], $this->stocktype);
        if ($this->sell_orders[$_sell_orders["price"]] == null)
          $this->sell_orders[$_sell_orders["price"]] = $order;
        else
          $this->sell_orders[$_sell_orders["price"]]->add_order($order);          
      }
    }
  }
  //------------------------------------------------------------------

  
  function trade()  
  {
    $this->get_user_money();
    $this->sell_orders = Array();
    $this->buy_orders  = Array();
    $this->get_buy_orders();
    $this->get_sell_orders();
    $this->get_trade_price();
    
    $shares_to_trade      = $this->trade_number;
    $current_transactions = 0;
    
    // BUY ORDERS    
    for ($i = $this->max_price+1;$i >= $this->trade_price && $shares_to_trade > 0; $i--)
    {
      while ($this->buy_orders[$i] != null && $shares_to_trade > 0)
      {
        $shares_to_trade = $this->buy_orders[$i]->buy($shares_to_trade, $this->trade_price, &$this->user_money, $this->user_fail_chance);
        
        if ($this->buy_orders[$i]->amount < 1)
          $this->buy_orders[$i] = $this->buy_orders[$i]->get_next();          
          
        if ($this->buy_orders[$i] == null)
          $this->highest_buy_price = ($i > 0) ? $i - 1 : 0;
          
        $current_transactions++;        
      }
    }
    
    $shares_to_trade = $this->trade_number - $shares_to_trade;
        
    // SELL ORDERS    
    for ($i = 0; $i <= $this->trade_price && $shares_to_trade > 0; $i++)
    {
      while ($this->sell_orders[$i] != null && $shares_to_trade > 0)
      {
        $shares_to_trade = $this->sell_orders[$i]->sell($shares_to_trade, $this->trade_price, $this->user_fail_chance);
        
        if ($this->sell_orders[$i]->amount < 1)
          $this->sell_orders[$i] = $this->sell_orders[$i]->get_next();
      }
    }
    
    $this->store_values();
  }
  //------------------------------------------------------------------
  
  
  
  function get_trade_price()
  {
    if ($this->highest_buy_price < 0)
      return false;
      
    $sell_shares_sum  = 0;
    $buy_shares_sum   = 0;       
    $max_shares       = 0;
      
    for ($i = 1; $i < $this->highest_buy_price+1; $i++)
    {
      if ($this->sell_orders[$i] != null)
      {
        $sell_shares_sum += $this->sell_orders[$i]->get_sum_amount(&$this->user_money, 0);
      }
    }

    if ($sell_shares_sum > 0)
    for ($i = $this->highest_buy_price; $i > 0; $i--)
    {
      $overlap = 0;
      if ($this->buy_orders[$i] != null)
        $buy_shares_sum += $this->buy_orders[$i]->get_sum_amount(&$this->user_money, $i);
        
      if ($this->sell_orders[$i+1] != null)
        $sell_shares_sum -= $this->sell_orders[$i+1]->get_sum_amount(&$this->user_money, 0);
  
      $overlap = ($buy_shares_sum > $sell_shares_sum) ? $sell_shares_sum : $buy_shares_sum;

      if ($overlap >= $max_shares)
      {
        $max_shares = $overlap;
        
        if ($i == 1)
        {
         $this->trade_price   = 1;
         $this->trade_number  = $max_shares;
        }
      }
      else
      {
        $this->trade_price   = $i+1;
        $this->trade_number  = $max_shares;
        break;
      }
    }


  // handel zu den üblichen konditionen nicht möglich.
    // jetzt wird der kram zum kleinstmöglichen preis an eine unlimited buy order verkauft
    if ($this->trade_price == 0 && $this->trade_number == 0)
    {
      $this->trade_price = -1;
      
      if ($this->buy_orders[$this->max_price+1] != null)
      {
        $this->trade_price  = $this->get_lowest_sell_price();
        $unlimit_buy        = $this->buy_orders[$this->max_price+1]->get_sum_amount(&$this->user_money, $this->trade_price);
      }
      
      if($this->sell_orders[0] != null)
      {
        if ($this->trade_price < 0) $this->trade_price = $this->highest_buy_price;
        $unlimit_sell = $this->sell_orders[0]->get_sum_amount(&$this->user_money, 0);
      }

      if ($this->trade_price > -1)
      {
        if ($unlimit_sell && $unlimit_buy)
          $this->trade_number = ($unlimit_sell > $unlimit_buy) ? $unlimit_buy : $unlimit_sell;
        elseif($unlimit_sell)
          $this->trade_number = $unlimit_sell;
        elseif($unlimit_buy)
          $this->trade_number = $unlimit_buy;
      }      
    }    
  }
  //------------------------------------------------------------------
  
  
  function get_lowest_sell_price()
  {
    $i = 0;
    while ($this->sell_orders[$i] == null && $i <= $this->max_price + 1) {
        $i++;
    }
    
    if ($i > $this->max_price)
      return -1;
    else
      return $i;  
  }
  //------------------------------------------------------------------
  
  
  function store_values()
  {
    if ($this->trade_price >= 0 && $this->trade_number > 0)
    {
      $sth = mysql_query("SELECT week FROM timeinfo");
      
      if (!$sth)
      {
        show_error("ERROR:: GETTING WEEK");
        return false;
      }
      
      list($week) = mysql_fetch_row($sth);
      
      $sth = mysql_query("UPDATE stockmarkets SET last_price = ".$this->trade_price." WHERE type = '".$this->stocktype."'");

      if (!$sth)
      {
        show_error("ERROR::STORE LAST PRICE");
        return false;
      }
      
      $sth = mysql_query("UPDATE stockmarket_statistics SET avg_price = (((avg_price * stocks_traded) + (".$this->trade_price." * ".$this->trade_number.")) / (stocks_traded + ".$this->trade_number.")), stocks_traded = stocks_traded + ".$this->trade_number." WHERE stockmarket = '".$this->stocktype."' and time = ".$week);

      if (!$sth)
      {
        show_error("ERROR::STORE AVG PRICE");
        return false;
      }
    }
  }
  //------------------------------------------------------------------
}


class order
{
  var $amount;
  var $price;
  var $uid;
  var $time;
  var $stockmarket;
  var $next;  
  
  function order($amount, $price, $uid, $time, $stockmarket)
  {
    $this->amount       = $amount;
    $this->price        = $price;
    $this->uid          = $uid;
    $this->time         = $time;
    $this->stockmarket  = $stockmarket;
  }
  //------------------------------------------------------------------
  
  
  function add_order($order)
  {
    if ($this->next == null)
      $this->next = $order;
    else
      $this->next->add_order($order);
  }
  //------------------------------------------------------------------
  
  
  function get_next()
  {
    return $this->next;
  }
  //------------------------------------------------------------------
  
  
  function get_sum_amount(&$user_money, $price_depend = 0)
  { 
    if ($price_depend > 0)
    {
      if (($this->amount * $price_depend) < $user_money[$this->uid])
        $sum_amount = $this->amount;
      else
        $sum_amount = floor($user_money[$this->uid] / $price_depend);
    }
    else
      $sum_amount = $this->amount;
      
    if ($this->next != null)
      $sum_amount += $this->next->get_sum_amount(&$user_money, $price_depend);

    return ($sum_amount);
  }
  //------------------------------------------------------------------

    
  function buy($trade_number, $price, &$user_money, $user_fail_chance)
  {
    if ($user_money[$this->uid] < 1)
    {
      $this->amount = -1;
      return $trade_number;
    }

    if ($this->amount * $price > $user_money[$this->uid])
    {
      $part_trade_number = floor($user_money[$this->uid] / $price);
      
      if ($part_trade_number > 0)
      {
        $trade_number -= $part_trade_number;
        $trade_number += $this->buy_commit($part_trade_number, $price, &$user_money[$this->uid], $user_fail_chance[$this->uid]);
      }
      else
        $this->amount = -1;     // wird nicht gelöscht
    }
    else
      $trade_number = $this->buy_commit($trade_number, $price, &$user_money[$this->uid], $user_fail_chance[$this->uid]);
    
    return $trade_number;
  }
  //------------------------------------------------------------------


  function sell($trade_number, $price)
  {
    $trade_number = $this->sell_commit($trade_number, $price, $user_fail_chance[$this->uid]);
    
    return $trade_number;
  }
  //------------------------------------------------------------------

  
  function buy_commit($trade_number, $price, &$money, $fail_chance)
  {
      if ($trade_number >= $this->amount)
      {
        $stocks_to_buy = $this->amount;
        $sth = mysql_query("DELETE FROM stockmarket_orders WHERE uid=".$this->uid." AND stockmarket = '".$this->stockmarket."' AND time = '".$this->time."' AND type=".BUY_ORDER);
      }
      else
      {
        $stocks_to_buy = $trade_number;
        $sth = mysql_query("UPDATE stockmarket_orders SET amount = amount - ".$trade_number.", time = time WHERE uid=".$this->uid." AND stockmarket = '".$this->stockmarket."' AND time = '".$this->time."' AND type=".BUY_ORDER);
      }
      
      if (!$sth)
      {
        show_error("ERROR::DELETE / UPDATE BUY ORDER");
        return false;
      }
      
      $resource = get_resource_name($this->stockmarket);
      $money -= $stocks_to_buy * $price;

      $trade_number -= $stocks_to_buy;
      $this->amount -= $stocks_to_buy;
      
      // FAIL CHANCE
      $credit_uid = $this->uid;
      $failed     = $this->transaction_fails($fail_chance);

      if ($failed)
        $credit_uid = $this->get_random_trade_uid();
      
      if ($credit_uid == $this->uid)
      {
        $sth = mysql_query("UPDATE ressources SET ".$resource." = ".$resource." + ".$stocks_to_buy.", money = money - ".($stocks_to_buy * $price)." WHERE uid=".$this->uid);      

        if (!$sth)
        {
          show_error("ERROR::CREDIT RESOURCE");
          return false;
        }

        if ($this->amount > 0)
          send_stockmarket_ticker($this->uid, "PARTIAL BOUGHT: ".$stocks_to_buy." units of ".(get_resource_name($this->stockmarket))." for ".$price." &euro; each.");
        else
          send_stockmarket_ticker($this->uid, "COMPLETE BOUGHT: ".$stocks_to_buy." units of ".(get_resource_name($this->stockmarket))." for ".$price." &euro; each.");
      }
      else
      {
        $sth = mysql_query("UPDATE ressources SET ".$resource." = ".$resource." + ".$stocks_to_buy." WHERE uid=".$credit_uid);      

        if (!$sth)
        {
          show_error("ERROR::BUY FAIL - CREDIT RESOURCE");
          return false;
        }
        
        $sth = mysql_query("UPDATE ressources SET money = money - ".($stocks_to_buy * $price)." WHERE uid=".$this->uid);      

        if (!$sth)
        {
          show_error("ERROR::BUY FAIL - PAY");
          return false;
        }
        
        send_stockmarket_ticker($this->uid, "SIR! Our files say that we have BOUGHT: ".$stocks_to_sell." units of ".(get_resource_name($this->stockmarket))." for ".$price." &euro; each!<br> <strong>But we have never recieved the resources!</strong>");
        send_ticker_from_to(false, $credit_uid, "w", "Sir! ".($stocks_to_sell)." ".$resource." from a trade transaction seems to be misleaded to us! Lucky, isn't it?");
      }
      
      return $trade_number;      
  }
  //------------------------------------------------------------------
    
  
  function sell_commit($trade_number, $price, $fail_chance)
  {
    // Resourcen von der Tradestation entfernen und geld gutschreiben
    $resource = get_resource_name($this->stockmarket);

    if ($trade_number >= $this->amount)
    {
      $stocks_to_sell = $this->amount;
      $sth = mysql_query("DELETE FROM stockmarket_orders WHERE uid=".$this->uid." AND stockmarket = '".$this->stockmarket."' AND time = '".$this->time."' AND type=".SELL_ORDER);
    }
    else
    {
      $stocks_to_sell = $trade_number;
      $sth = mysql_query("UPDATE stockmarket_orders SET amount = amount - ".$stocks_to_sell.", time = time WHERE uid=".$this->uid." AND stockmarket = '".$this->stockmarket."' AND time = '".$this->time."' AND type=".SELL_ORDER);
    }

    if (!$sth)
    {
      show_error("ERROR::DELETE / UPDATE BUY ORDER");
      return false;
    }
    
    $credit_uid = $this->uid;
    $failed     = $this->transaction_fails($fail_chance);
    
    // FAIL CHANCE
    if ($failed)
      $credit_uid = $this->get_random_trade_uid();

    $sth = mysql_query("UPDATE ressources SET money = money + ".($stocks_to_sell * $price)." WHERE uid=".$credit_uid);

    if (!$sth)
    {
      show_error("ERROR::PAY SELLER");
      return false;
    }
    
    $sth = mysql_query("UPDATE tradestations set ".$resource." = ".$resource." - ".$stocks_to_sell." WHERE uid=".$this->uid);

    if (!$sth)
    {
      show_error("ERROR::REMOVE RES FROM STATION");
      return false;
    }
    
    $trade_number -= $stocks_to_sell;
    $this->amount -= $stocks_to_sell;

    if ($failed && $credit_uid != $this->uid)
    {
        send_stockmarket_ticker($this->uid, "SIR! Our files say that we have SOLD: ".$stocks_to_sell." units of ".(get_resource_name($this->stockmarket))." for ".$price." &euro; each!<br> <strong>But we have never recieved the money!</strong>");
        send_ticker_from_to(false, $credit_uid, "w", "Sir! ".($price * $stocks_to_sell)." &euro; from a trade transaction seems to be misleaded to us! Lucky, isn't it?");
    }
    else
    {
      if ($this->amount > 0)
        send_stockmarket_ticker($this->uid, "PARTIAL SOLD: ".$stocks_to_sell." units of ".(get_resource_name($this->stockmarket))." for ".$price." &euro; each.");
      else
        send_stockmarket_ticker($this->uid, "COMPLETE SOLD: ".$stocks_to_sell." units of ".(get_resource_name($this->stockmarket))." for ".$price." &euro; each.");
    }      
    
    return $trade_number;
  }
  //------------------------------------------------------------------    
  
      
  function transaction_fails($fail_chance)
  {
    mt_srand ((double) microtime() * 1000000);
    $random = mt_rand(0,100);
    
    if ($random <= $fail_chance)
      return true;
    else
      return false;
  }
  
  function get_random_trade_uid()
  {
    $sth = mysql_query("SELECT uid FROM tradestations WHERE uid != ".$this->uid." ORDER BY RAND() LIMIT 1");
    
    if (!$sth)
    {
      show_error("ERROR:: GET RAND UID");
      return false;
    }
    
    if (mysql_num_rows($sth) > 0)
    {
    	list($uid) = mysql_fetch_row($sth);
      return $uid;
    }
    else
      return $this->uid;
  }
}
?>