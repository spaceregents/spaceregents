<?
// function trade_fail($uid)
// function get_tstation_owner($pid)
// function get_tstation_ressources($pid)
// function get_price_modifier($pid, $type);
// function establish_trade($seller, $buyer, $ressource, $count);
// function get_tstation_price_rates($pid, $ressource = 0)
// function has_tradestation($uid)
// function sells_ressources($pid);
// function sells_ships($pid);
// function get_tid_by_pid($pid);
// function get_uid_by_tid($station_id);
// function get_tid_by_uid($uid);
// function add_shipoffer($station_id, $prod_id, $count, $price);
// function get_tstation_level($sid);
// function remove_shipoffer($station_id, $prod_id, $count);

define (BUY_ORDER,  0);
define (SELL_ORDER, 1);


/***********************
*
* function trade_fail($uid)
*
***********************/
function trade_fail($uid)
{
  $sth=mysql_query("select if(fail_chance>=rand()*100,1,0) from tradestations where uid=$uid");

  if ((!$sth) || (mysql_num_rows($sth)==0))
    return false;

  list($fail)=mysql_fetch_row($sth);

  return $fail;
}
//-----------------------------------------------------------------------


/***********************
*
* function get_tstation_owner($pid)
*
***********************/
function get_tstation_owner($pid)
{
 $sth = mysql_query("select uid from tradestations where pid='$pid'");
 
 if ((!$sth) || (!mysql_num_rows($sth)))
  return false;
  
 list($its_uid) = mysql_fetch_row($sth);
 
 return $its_uid;
}
//-----------------------------------------------------------------------


/***********************
*
* function get_tstation_ressources($pid)
*
***********************/
function get_tstation_ressources($pid, $type = 0)
{
 $sth = mysql_query("select metal, energy, mopgas, erkunum, gortium, susebloom from tradestations where pid='$pid'");
 
 if ((!$sth) || (!mysql_num_rows($sth)))
  return false;
  
 $its_ressources = mysql_fetch_row($sth);
 
 if ($type == 0)
 {
   $return_array["metal"]     = $its_ressources[0];
   $return_array["energy"]  = $its_ressources[1];
   $return_array["gortium"]   = $its_ressources[2];
   $return_array["erkunum"]   = $its_ressources[3];
   $return_array["mopgas"]  = $its_ressources[4];
   $return_array["susebloom"]= $its_ressources[5];
 }
 elseif ($type == 1)
 {
   $return_array["M"]     = $its_ressources[0];
   $return_array["E"]  = $its_ressources[1];
   $return_array["O"]   = $its_ressources[2];
   $return_array["R"]   = $its_ressources[3];
   $return_array["G"]  = $its_ressources[4];
   $return_array["S"]= $its_ressources[5];
 }
 
 return $return_array;
}
//-----------------------------------------------------------------------



/***********************
*
* function has_tradestation($uid)
*
***********************/
function has_tradestation($uid)
{
 $sth = mysql_query("select sid from tradestations where uid='$uid'");
 
 if ((!$sth) || (!mysql_num_rows($sth)))
  return 0;
 else
 {
  list($its_sid) = mysql_fetch_row($sth);
  return $its_sid;
 }
}
//-----------------------------------------------------------------------


function get_tid_by_pid($pid)
{
  // sid = station id! NICHT system id
  $sth = mysql_query("select sid from tradestations where pid='$pid'");
  
  if ((!$sth) ||(!mysql_num_rows($sth)))
    return 0;

  list($tid) = mysql_fetch_row($sth);
  return $tid;
}


//------------------------------------------------------------------------
function get_pid_by_tid($station_id)
{
  $sth = mysql_query("select pid from tradestations where sid='$station_id'");
  
  if ((!$sth) ||(!mysql_num_rows($sth)))
    return 0;

  list($pid) = mysql_fetch_row($sth);
  return $pid;
}


//------------------------------------------------------------------------
function get_uid_by_tid($station_id)
{
  $sth = mysql_query("select uid from tradestations where sid='$station_id'");

  if ((!$sth) ||(!mysql_num_rows($sth)))
    return 0;

  list($uid) = mysql_fetch_row($sth);
  return $uid;
}
//------------------------------------------------------------------------


function get_tid_by_uid($uid)
{
  $sth = mysql_query("select sid from tradestations where uid=$uid");

  if ((!$sth) ||(!mysql_num_rows($sth)))
    return 0;

  list($station_id) = mysql_fetch_row($sth);
  return $station_id;
}
//------------------------------------------------------------------------


function get_resource_name($stockmarket)
{
    switch ($stockmarket)
    {
      case "MET":
        return "metal";
      break;
      case "ENE":
        return "energy";
      break;
      case "MOP":
        return "mopgas";
      break;
      case "ERK":
        return "erkunum";
      break;
      case "GOR":
        return "gortium";
      break;
      case "SUS":
        return "susebloom";
      break;
    }
    return false;
}
//------------------------------------------------------------------------


function send_stockmarket_ticker($uid, $message)
{
  $sth = mysql_query("INSERT INTO stockmarket_ticker (uid, message) values (".$uid.", '".$message."')");

  if (!$sth)
  {
    show_error("ERROR::INSERT SOCKMARKET TICKER");
    return false;
  }
}
?>