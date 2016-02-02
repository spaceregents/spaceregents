<?
  define("TACHYON_SCAN",3);
  define("STARBORNE_COMPUTER_TROJAN",4);


  function get_special_action_price($action_id) {
    $sth = mysql_query("select metal, energy, mopgas, erkunum, gortium, susebloom from special_actions where action_id = ".$action_id);

    if ((!$sth) || (!mysql_num_rows($sth)))
      return false;

    $its_costs = mysql_fetch_assoc($sth);

    return $its_costs;
  }
?>
