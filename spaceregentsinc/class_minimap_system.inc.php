<?
class MINIMAP_SYSTEM extends SYSTEM
{
  var $minimap_colors = array();
  var $minimap_fleets = array();
  var $minimap_systems_in_scanrange = array();

  //*******************-----------------------------------------------------------------| constructor;
  function MINIMAP_SYSTEM($sid=0)
  {
    if ($sid)
    {
      $this->SYSTEM($sid);
    }
    
  }
  //-------------------*

  

  //*******************-----------------------------------------------------------------| get_minimap_values();
  // Note: Ohne colors keine scanrange möglich!
  //
  //-------------------
  function get_minimap_values($colors = true, $scanrange = true, $fleets = true)
  {
    global $uid;
    
    $user_alliance  = get_alliance($uid);    
    
    if (!$colors)
      $scanrange = false;
        
    $sth = mysql_query("select id, uid from planets where sid=".$this->id." and uid != 0");
    
    if (!$sth)
      return 0;
      
    while ($its_planets = mysql_fetch_array($sth))
    {
      $its_uid = $its_planets["uid"];
      $its_id  = $its_planets["id"];
      
      
      // minimap_colors
      if ($colors)
      {
        if ($its_uid == $uid)
        {
          $this->minimap_colors[] = "lime";
          $this->scan = true;

          // scanrange
          if ($scanrange)
            $its_scanradius = get_max_scan_range_by_pid($its_id);
        }
        elseif (is_allied($its_uid, $uid))
        {
          $this->minimap_colors[] = "yellow";
          $this->scan = true;

          // scanrange              
          if ($scanrange)
            $its_scanradius = get_max_scan_range_by_pid($its_id);
        }
        else
        {
          $planet_alliance= get_alliance($its_uid);
          if (($user_alliance) && ($planet_alliance) && (is_friendly($user_alliance, $planet_alliance)))
            $this->minimap_colors[] = "orange";
          elseif (($user_alliance) && ($planet_alliance) && (is_enemy($user_alliance, $planet_alliance)))
            $this->minimap_colors[] = "red";
          else
            $this->minimap_colors[] = "blue";
        }
      }

       // max scanrange ermitteln
      if (($its_scanradius) && ($this->scanradius < $its_scanradius))
        $this->scanradius = $its_scanradius;
    }
    
        
    // minimap_fleets
    if ($fleets)
    {
      $sth = mysql_query("select distinct(uid) as unique_uid from fleet_info where sid=".$this->id);

      if ((!$sth) || (!mysql_num_rows($sth)))
        return 0;

      while ($its_fleets = mysql_fetch_array($sth))
      {
        $its_uid = $its_fleets["unique_uid"];

        if ($its_uid == $uid)
        {
          $this->minimap_fleets[] = "lime";
          $this->scan = true;

          // scanrange der Flotten
          if ($scanrange)
            $fleet_scanradius =  get_max_fleet_scanrange_by_sid($this->id);
        }
        elseif (is_allied($its_uid, $uid))
        {
          $this->minimap_fleets[] = "yellow";
          $this->scan = true;

          // scanrange der Flotten
          if ($scanrange)
            $fleet_scanradius =  get_max_fleet_scanrange_by_sid($this->id);            
        }
        else
        {
          $fleet_alliance = get_alliance($its_uid);
          if (($user_alliance) && ($fleet_alliance) && (is_friendly($user_alliance, $fleet_alliance)))
            $this->minimap_fleets[] = "orange";
          elseif (($user_alliance) && ($fleet_alliance) && (is_enemy($user_alliance, $fleet_alliance)))
            $this->minimap_fleets[] = "red";
          else
            $this->minimap_fleets[] = "blue";
        }

        if (($fleet_scanradius) && ($this->scanradius < $fleet_scanradius))
          $this->scanradius = $fleet_scanradius;
      }
        
      // Scanrange
      if ($scanrange)
      {
        // Systeme in Scanrange
        $visible_systems = get_systems_in_scanrange($this->id, $this->scanradius);

        if (is_array($visible_systems))
        for ($j = 0; $j < sizeof($visible_systems); $j++)
        {
          $this->systems_in_scanrange[] = new MINIMAP_SYSTEM($visible_systems[$j]);
        }
        
        for ($j = 0; $j < sizeof($this->systems_in_scanrange); $j++)
        {
          $this->systems_in_scanrange[$j]->get_minimap_values(true,false,true);
          $this->systems_in_scanrange[$j]->make_visible();
        }
        
      }     
    }// ende WHILE  
            
    if (isset($this->minimap_colors[0]))
      $this->minimap_colors = array_unique($this->minimap_colors);

    if (isset($this->minimap_fleets[0]))      
      $this->minimap_fleets = array_unique($this->minimap_fleets);    
      
  }
  //-------------------*
}
?>