<?php
/**
  * class battle_reporter
  * 
  */

class battlereporter
{

  /**Attributes: */

    /**
      * das derzeitige battlefield
      */
    var $battlefield;
    /**
      * die templateengine
      */
    var $smarty;

    /** 
     * die kampfergebnisse
     */
    var $results;

    /** 
     * beteiligten user
     */
    var $users;

    /** 
     * die benachrichtigen user 
     */
    var $noticed_users=array();
    
    /** 
     * die informierten allianzen 
     */
    var $noticed_alliances=array();

    /** 
     *die derzeitige woche 
     */
    var $week;

  function battlereporter()
  {
    $this->smarty=new Smarty;
    $this->setup_smarty();

    $sth=mysql_query("select week from timeinfo");

    if (!$sth)
    {
      throw new SQLException();
    }

    if (mysql_num_rows($sth)!=1)
    {
      throw new GenericException("oops...timeinfo is broken");
    }

    list($this->week)=mysql_fetch_row($sth);
  }

  /**
    * setzt das battlefield neu
    * @param battlefield
    *      
    */
  function set_field( $battlefield )
  {
    $this->results=NULL;
    $this->users=NULL;
    $this->battlefield=$battlefield;
  }


  /**
    * generiert zu einem battlefield alle nötigen reports
    */
  function generate_reports( )
  {
    $this->gather_results();
    $participants=$this->battlefield->get_participants();
    
    $uids=array();
    for ($i=0;$i<sizeof($participants);$i++)
    {
      if (!in_array($participants[$i]->get_uid(),$uids))
        $uids[]=$participants[$i]->get_uid();
    }
    
    if ($invader=$this->battlefield->get_invasion())
    {
      $invasion=$this->battlefield->get_name()." has been invaded by ".$this->users[$invader];
    }
    else
    {
      $invasion=false;
    }
      
    $this->smarty->assign("location",$this->battlefield->get_name());
    $this->smarty->assign("invasion",$invasion);
    $this->smarty->assign("results",$this->results);
    $this->smarty->assign("users",$this->users);
    ob_start();
    $this->smarty->display("battlereport.tpl");
    $report=ob_get_contents();
    ob_end_clean();
    // mop: alles zurücksetzen für den nächsten kampf
    $this->smarty->clear_all_assign();
    
    // mop: allianzen aller user rausfinden
    $alliances=array();
   
    for ($i=0;$i<sizeof($uids);$i++)
    {
      $alliance=get_alliance($uids[$i]);
      if (!in_array($alliance,$alliances))
        $alliances[]=$alliance;
    }
    
    $this->save_report($alliances,$uids,$this->battlefield,$report);
  }



  /**
    * sammelt die ergebnisse
    */
  function gather_results( )
  {
    $participants=$this->battlefield->get_participants();

    foreach ($participants as $participant)
    {
      if (!$this->users[$participant->get_uid()])
	$this->users[$participant->get_uid()]=get_name_by_uid($participant->get_uid())." (".get_empire_by_uid($participant->get_uid()).")";

      $this->results[$participant->get_uid()]["enemies"]=$participant->get_enemies();
      
      $units=$participant->get_units();

      foreach ($units as $unit)
      {
        if ($unit->has_subunits())
        {
          $sub_units=$unit->get_subunits();
          for ($i=0;$i<sizeof($sub_units);$i++)
          {
            $this->results[$participant->get_uid()]["remaining_ships"][$sub_units[$i]->get_name()]++;
            $this->results[$participant->get_uid()]["ships"][$sub_units[$i]->get_name()]++;
          }
        }
	$this->results[$participant->get_uid()]["remaining_ships"][$unit->get_name()]++;
	$this->results[$participant->get_uid()]["ships"][$unit->get_name()]++;
      }

      $units=$participant->get_unloaded_units();

      foreach ($units as $unit)
      {
        $name=$unit->get_name()." (unloaded)";
	$this->results[$participant->get_uid()]["remaining_ships"][$name]++;
	$this->results[$participant->get_uid()]["ships"][$name]++;
      }
    
      if ($participant->admiral)
      {
	if (!is_array($this->results[$participant->get_uid()]["admirals"]))
	  $aidx=0;
	else
	  $aidx=sizeof($this->results[$participant->get_uid()]["admirals"]);

	echo("=> ".$aidx."\n");
    
	$this->results[$participant->get_uid()]["admirals"][$aidx]["name"] =$participant->admiral->name;
	$this->results[$participant->get_uid()]["admirals"][$aidx]["xp"]   =$participant->admiral->value;
	$this->results[$participant->get_uid()]["admirals"][$aidx]["newxp"]=$participant->admiral->newvalue;
	$this->results[$participant->get_uid()]["admirals"][$aidx]["lvlup"]=calculate_admiral_level($participant->admiral->newvalue)!=calculate_admiral_level($participant->admiral->value);
      }

      $units=$participant->get_destroyed_units();
      
      if (!is_array($units))
	$units=array();

      foreach ($units as $unit)
      {
	$this->results[$participant->get_uid()]["destroyed_ships"][$unit->get_name()]++;
	$this->results[$participant->get_uid()]["ships"][$unit->get_name()]++;
      }
      
      $units=$participant->get_fled_units();
      
      if (!is_array($units))
	$units=array();

      foreach ($units as $unit)
      {
	$this->results[$participant->get_uid()]["remaining_ships"][$unit->get_name()]++;
	$this->results[$participant->get_uid()]["ships"][$unit->get_name()]++;
      }
    }
  }


  /**
    * speichert einen report
    * @param uid
    * @param report
    *      
    */
  function save_report($alliances,$uids,$battlefield,$report)
  {
    if (BATTLEREPORT_SHOW)
    {
      echo($report);
    }
    else
    {
      $sth=mysql_query("insert into battlereports set pid=".$battlefield->pid.",sid=".$battlefield->sid.",report='".addslashes($report)."',week=".$this->week);

      if (!$sth)
      {
        echo("ERR::INSERT BATTLEREPORT\n");
        return false;
      }
      $rid=mysql_insert_id();
      
      // mop: allen allianzen zugänglich machen
      foreach ($alliances as $alliance)
      {
        $sth=mysql_query("insert into battlereports_alliance set aid=".$alliance.",rid=".$rid);

        if (!$sth)
        {
          echo("ERR::INSERT BATTLEREPORT_ALLIANCE\n");
          return false;
        }
        
        // mop: die allianzmitglieder EINMAL über allianzkämpfe infomieren
        if (!in_array($alliance,$this->noticed_alliances))
        {
          $members=get_alliance_members($alliance);

          foreach ($members as $uid => $name)
          {
            // mop: beteiligte user bekommen eh nochmal ne separate message, also ausklammern
            if (!in_array($uid,$uids))
              ticker($uid,"*lbattlereport.php?act=show_alliance&_minw=".$this->week."&_maxw=".$this->week."*Your alliance was involved in one or more battles!","a");
          }
          $this->noticed_alliances[]=$alliance;
        }
      }
      
      // mop: und auch den jeweiligen usern
      foreach ($uids as $uid)
      {
        $sth=mysql_query("insert into battlereports_user set uid=".$uid.",rid=".$rid);

        if (!$sth)
        {
          echo("ERR::INSERT BATTLEREPORT_UID\n");
          return false;
        }
        
        if (!in_array($uid,$this->noticed_users))
        {
          ticker($uid,"*lbattlereport.php?act=show_own&_minw=".$this->week."&_maxw=".$this->week."*You were involved in one or more battles!","a");
          $this->noticed_users[]=$uid;
        }
      }
    }
  }

  function setup_smarty()
  {
    global $__base_inc_dir;
    $this->smarty->template_dir = $__base_inc_dir."battle/templates/";
    $this->smarty->compile_dir  = $__base_inc_dir."battle/templates_c/";
    $this->smarty->config_dir   = $__base_inc_dir."battle/configs/";
    $this->smarty->cache_dir    = $__base_inc_dir."battle/cache/";
  }

  function invasion($name,$imperium)
  {
    $this->results["invasion"]=$this->battlefield->get_name()." has been invaded by ".$name." (".$imperium.")";
  }
}
?>
