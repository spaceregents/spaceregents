<?
class shipbattle
{
  var $attackers;
  var $defenders;
  var $a_uids;
  var $d_uids;
  var $report;
  var $b_order;
  var $losses;
  var $attackers_count;
  var $defenders_count;

  function shipbattle($simulation=false,$aarray=null,$darray=null)
  {
    // einfach nur ne simulation?
    if ($simulation)
    {
      $this->prepare_simulation($aarray,$darray);
    }
    else
    {
      // Ersma alle flotten raussuchen, die mit anderen flotten, die einem nich gehören auf einem fleck hocken

      $sth=mysql_query("select f1.fid,f1.pid,f1.sid,f1.uid,f1.mission from fleet_info f1,fleet_info f2 where f1.uid!=f2.uid and f1.pid=f2.pid and f1.sid=f2.sid group by f1.fid order by f1.pid,f1.sid");

      if (!$sth)
	echo("Database failure!");

      while ($poss_battle=mysql_fetch_array($sth))
      {
	// neue pid und sid?
	if ($poss_battle["pid"]!=$last_pid && $poss_battle["sid"]!=$last_sid)
	{
	  if (!isset($i))
	    $i=0;
	  else
	    $i++;
	  // neuen container erzeugen
	  $poss_battle_locations[$i]=new possible_battle_container;
	  $poss_battle_locations[$i]->sid=$poss_battle["sid"];
	  $poss_battle_locations[$i]->pid=$poss_battle["pid"];
	  $last_pid=$poss_battle["pid"];
	  $last_sid=$poss_battle["sid"];
	}

	$poss_battle_locations[$i]->fleets[$poss_battle["uid"]][]=array("fid"=>$poss_battle["fid"],"mission"=>$poss_battle["mission"]);
      }

      // so jetzt die uids pro location vergleichen und schauen ob nen kampf zustande kommt und die battlelocations indizes sichern

      for ($i=0;$i<sizeof($poss_battle_locations);$i++)
      {
	$battle_location[$i]=new possible_battle_container;
	$battle_location[$i]->pid=$poss_battle_locations[$i]->pid;
	$battle_location[$i]->sid=$poss_battle_locations[$i]->sid;
	$nachzuegler=array();
	$uids=array_keys($poss_battle_locations[$i]->fleets);
	$uids=array_flip($uids);
	$owner=get_uid_by_pid($poss_battle_locations[$i]->pid);
	$owner_alliance=get_alliance($owner);
	while (list($uid,$dummy)=each($poss_battle_locations[$i]->fleets))
	{
	  $uids_temp=$uids;

	  unset($uids_temp[$uid]);

	  reset ($uids_temp);

	  while (list($second_uid,$dummy)=each($uids_temp))
	  {
	    $alliance=get_alliance($uid);
	    $sec_alliance=get_alliance($second_uid);
	    if (is_enemy($alliance,$sec_alliance))
	    {
	      $battle_location[$i]->fleets[$uid]=$poss_battle_locations[$i]->fleets[$uid];
	      $battle_location[$i]->fleets[$second_uid]=$poss_battle_locations[$i]->fleets[$second_uid];
	      unset($poss_battle_locations[$i]->fleets[$second_uid]);
	      echo("BLA\n");
	    }
	    elseif ((is_allied($alliance,$sec_alliance)) || (is_friendly($alliance,$sec_alliance)))
	    {
	      $nachzuegler[]=$poss_battle_locations[$i]->fleet[$second_uid];
	      unset($poss_battle_locations[$i]->fleets[$second_uid]);
	    }
	    elseif (is_enemy($alliance,$owner_alliance))
	    {
	      for ($j=0;$j<sizeof($poss_battle_locations[$i]->fleets[$uid]);$j++)
	      {
		if (($poss_battle_locations[$i]->fleets[$uid][$j]["mission"]==3) || ($poss_battle_locations[$i]->fleets[$uid][$j]["mission"]==5)) // invading oder bombarding? ziemlicher gayer hack :S
		  $battle_location[$i]->fleets[$uid]=$poss_battle_locations[$i]->fleets[$uid];
	      }
	    }
	    else
	    {
	      // neutrale müssen nochmal gesondert betrachtet werden deswegen kein unset
	    }
	  }
	}

	// mop: wenn es ne freund/feind situation irgendwie gibt, dann müssen die nachzuegler mit rein

	if (is_array($battle_location[$i]->fleets))
	{
	  for ($j=0;$j<sizeof($nachzuegler);$j++)
	    $battle_location[$i]->fleets=array_merge($battle_location[$i]->fleets,$nachzuegler[$j]);
	  echo("BLA2\n");
	}

      }

      echo("BLA3\n");

      var_dump($battle_location);

      // jetzt haben wir die battlelocations...nun wirds interessant...wir müssen die ganze hundescheisse jetzt nach defenders und
      // attackers umdröseln

      for ($i=0;$i<sizeof($battle_location);$i++)
      {
	echo("=> $i\n");
	$this->a_uids=array();
	$this->d_uids=array();
	$this->attackers=array();
	$this->defenders=array();
	$this->report=new battlereport();
	$this->report->pid=$battle_location[$i]->pid;
	$this->report->sid=$battle_location[$i]->sid;

	if (is_array($battle_location[$i]->fleets))
	{
	  echo("JO\n");
	  // dann muss es da auch irgendwas zum kampftrollen geben

	  if ($battle_location[$i]->pid==0)  // systemkampf
	  {
	    echo("JO=>2\n");
	    if ($intercepting=$battle_location[$i]->find_intercepting_uid())
	    {
	      $this->d_uids[]=$intercepting;

	      for ($j=0;$j<sizeof($battle_location[$i]->fleets[$intercepting]);$j++)
	      {
		$battlefleet=new battlefleet($battle_location[$i]->fleets[$intercepting][$j]["fid"],0);
		$this->report->add_fleet($battlefleet);
		$this->defenders[]=$battlefleet;
	      }

	      $d_alliance=get_alliance($intercepting); // verteidigende allianz sichern

	      reset($battle_location[$i]->fleets);

	      while (list($uid,$fleet)=each($battle_location[$i]->fleets))
	      {
		if ($uid!=$this->d_uids[0])
		{
		  if (is_enemy($d_alliance,get_alliance($uid)))
		  {
		    if (!in_array($uid,$this->a_uids))
		    {
		      $this->a_uids[]=$uid;
		      for ($j=0;$j<sizeof($fleet);$j++)
		      {
			$battlefleet=new battlefleet($fleet[$j]["fid"],1);
			$this->report->add_fleet($battlefleet);
			$this->attackers[]=$battlefleet;
		      }
		    }
		  }
		  elseif ((is_friendly($d_alliance,get_alliance($uid))) || (is_allied($d_alliance,get_alliance($uid))))
		  {
		    if (!in_array($uid,$this->d_uids))
		    {
		      $this->d_uids[]=$uid;
		      for ($j=0;$j<sizeof($fleet);$j++)
		      {
			$battlefleet=new battlefleet($fleet[$j]["fid"],0);
			$this->report->add_fleet($battlefleet);
			$this->defenders[]=$battlefleet;
		      }
		    }
		  }
		  else
		    echo("Neutral Player detected :S\n");
		}
	      }
	    }
	    else
	    {
	      // :S
	    }
	  }
	  else  // planetenkampf
	  {
	    echo("JO2\n");
	    $owner=get_uid_by_pid($battle_location[$i]->pid);
	    $planet_active=false;

	    if (in_array($owner,array_keys($battle_location[$i]->fleets))) // owner des planeten hat flotten da?
	    {
	      $this->d_uids[]=$owner;
	    }
	    else
	    {
	      $owner=array_rand($battle_location[$i]->fleets);
	      $this->d_uids[]=$owner;
	      echo("Owner ist => ".$owner."\n");
	    }

	    for ($j=0;$j<sizeof($battle_location[$i]->fleets[$owner]);$j++)
	    {
	      $battlefleet=new battlefleet($battle_location[$i]->fleets[$owner][$j]["fid"],0);
	      $this->report->add_fleet($battlefleet);
	      $this->defenders[]=$battlefleet;
	    }


	    $d_alliance=get_alliance($owner); // verteidigende allianz sichern

	    reset($battle_location[$i]->fleets);

	    while (list($uid,$fleet)=each($battle_location[$i]->fleets))
	    {
	      if ($uid!=$this->d_uids[0])
	      {
		if (is_enemy($d_alliance,get_alliance($uid)))
		{
		  if (!in_array($uid,$this->a_uids))
		  {
		    $this->a_uids[]=$uid;
		    for ($j=0;$j<sizeof($fleet);$j++)
		    {
		      $battlefleet=new battlefleet($fleet[$j]["fid"],1);
		      if ($battlefleet->mission==3)
		      {
			$planet_active=true;
			$planet_attack_type=0;
		      }
		      elseif ($battlefleet->mission==5)
		      {
			$planet_active=true;
			$planet_attack_type=1;
		      }

		      $this->report->add_fleet($battlefleet);
		      $this->attackers[]=$battlefleet;
		    }
		  }
		}
		elseif ((is_friendly($d_alliance,get_alliance($uid))) || (is_allied($d_alliance,get_alliance($uid))))
		{
		  if (!in_array($uid,$this->d_uids))
		  {
		    $this->d_uids[]=$uid;
		    for ($j=0;$j<sizeof($fleet);$j++)
		    {
		      $battlefleet=new battlefleet($fleet[$j]["fid"],0);
		      $this->report->add_fleet($battlefleet);
		      $this->defenders[]=$battlefleet;
		    }
		  }
		}
		else
		  echo("Neutral Player detected :S\n");
	      }
	    }
	  }

	  if ($planet_active)
	  {
	    // d_uids wurde schon vorher hinzugfügt
	    $battleplanet=new battleplanet($battle_location[0]->pid,$planet_attack_type);
	    $this->report->add_planet($battleplanet);
	    $this->defenders[]=$battleplanet;
	  }
	}

	if (sizeof($this->a_uids)>0 && sizeof($this->d_uids)>0)
	{
	  $this->attackers_count=sizeof($this->attackers);
	  $this->defenders_count=sizeof($this->defenders);

	  $this->prepare_battle();
	  $this->do_battle();
	  $this->destroy_ships();
	  $this->report->do_report();
	}
      }

    }
  }

  function prepare_simulation($aarray,$darray)
  {
    $this->report=new battlereport;
    $this->a_uids[]=0;
    $this->d_uids[]=0;

    $battlefleet=new battlefleet(0,1,true,$aarray);
    $this->attackers[]=$battlefleet;
    $this->report->add_fleet($battlefleet);
    $battlefleet=new battlefleet(0,0,true,$darray);
    $this->defenders[]=$battlefleet;
    $this->report->add_fleet($battlefleet);

    $this->attackers_count=sizeof($this->attackers);
    $this->defenders_count=sizeof($this->defenders);

    $this->prepare_battle();
    $this->do_battle();
    $this->destroy_ships();
    $this->report->do_report();
  }

  function prepare_battle()
  {
    // zuerst initiative holen

    /*
       b_order[$reihenfolgen_counter][$attacking_oder_defending][$battlefleetindex][$battlefleet_shipindex]=$initiative;
     */

    $k=0;

    for ($i=0;$i<sizeof($this->attackers);$i++)
    {
      for ($j=0;$j<sizeof($this->attackers[$i]->ships);$j++)
      {
	$this->b_order[$k][1][$i][$j]=&$this->attackers[$i]->ships[$j]->get_initiative();
	$this->attackers[$i]->ships[$j]->b_order_idx=$k;
	$k++;
      }
    }

    for ($i=0;$i<sizeof($this->defenders);$i++)
    {
      for ($j=0;$j<sizeof($this->defenders[$i]->ships);$j++)
      {
	$this->b_order[$k][0][$i][$j]=&$this->defenders[$i]->ships[$j]->get_initiative();
	$this->defenders[$i]->ships[$j]->b_order_idx=$k;
	$k++;
      }
    }

    // siehe battles.inc.php
    usort($this->b_order,"b_order_sort");

  }

  function get_random_fleet(&$type,$typedef)
  {
    mt_srand((double) microtime() * 10000000);

    // die chance muss an die anzahl der schiffe in den flotten angepasst werden

    $last_chance=0;

    for ($i=0;$i<sizeof($type);$i++)
    {
      $chance[$i]=array($last_chance,($type[$i]->total_shipcount+$last_chance));
      $last_chance=$type[$i]->total_shipcount+$last_chance+1;
    }

    $i--;

    if ($chance[$i][1]==1)
      return 0;

    while (!is_object($type[$idx]))
    {
      $idx_tmp=mt_rand(0,$chance[$i][1]);

      for ($j=0;$j<sizeof($chance);$j++)
      {
	if (($chance[$j][0]<=$idx_tmp) && ($chance[$j][1]>=$idx_tmp))
	  $idx=$j;
      }
    }
    return $idx;
  }

  function do_battle()
  {
    $defending_challenge_points=$this->get_challenge_points($this->attackers);
    $attacking_challenge_points=$this->get_challenge_points($this->defenders);

    $b_size=sizeof($this->b_order);
    for ($i=0;$i<$b_size;$i++)
    {
      if (!isset($this->b_order[$i]))
      {
	continue;
      }

      $fighter_type=key($this->b_order[$i]);

      $fleet_idx=key($this->b_order[$i][$fighter_type]);

      $ship_idx=key($this->b_order[$i][$fighter_type][$fleet_idx]);

      $attacker=false;

      if ($fighter_type==0)
      {
	$vic_key=$this->get_random_fleet($this->attackers,1);

	if (isset($this->defenders[$fleet_idx]->ships[$ship_idx]))
	  $attacker=&$this->defenders[$fleet_idx]->ships[$ship_idx];

	$ship_key=$this->attackers[$vic_key]->get_random_ship();

	$victim=&$this->attackers[$vic_key]->ships[$ship_key];
      }
      elseif ($fighter_type==1)
      {
	$found_vic=false;
	$search_count=0;

	while (!$found_vic && $search_count<10)
	{
	  $vic_key=$this->get_random_fleet($this->defenders,0);
	  if (isset($this->attackers[$fleet_idx]->ships[$ship_idx]))
	    $attacker=&$this->attackers[$fleet_idx]->ships[$ship_idx];
	  $ship_key=$this->defenders[$vic_key]->get_random_ship();
	  $victim=&$this->defenders[$vic_key]->ships[$ship_key];

	  if ($victim && $victim->is_building() && $victim->type==1)
	  {
	    if ($attacker->special=="B")
	    {
	      $found_vic=true;
	    }
	  }
	  else
	    $found_vic=true;

	  $search_count++;
	}

	if ($search_count==10)
	  $victim=false;

      }
      else
      {
	echo("Kampfsystem putt 8[");
      }

      if ($attacker && $victim)
      {
	if ($attacker->attack($victim))
	{
	  if ($victim->has_admiral)
	  {
	    echo("Admiral tot8[\n");
	    $this->report->register_admiral_death($victim->uid,$this->defenders[$vic_key]->admiral);

	    // noch nich löschen;) erst wenn alles geht
	    $sth=mysql_query("delete from admirals where uid=".$victim->uid." and fid=".$victim->fid);

	    if (!$sth)
	    {
	      echo("Database failure!");
	      return false;
	    }
	  }
	  $this->report->register_loss($victim);
	  $this->losses[$victim->fid][$victim->prod_id]++;
	  //$this->b_order=array_slice_remove($this->b_order,$i);
	  unset($this->b_order[$victim->b_order_idx]);
	  if ($fighter_type==1)
	    unset($this->defenders[$vic_key]->ships[$ship_key]);
	  else
	    unset($this->attackers[$vic_key]->ships[$ship_key]);
	}
	else
	{
	}

      }
    }

    // so zum schluss noch den admirals xp geben (sofern sie denn noch da sind;) )

    for ($i=0;$i<sizeof($this->defenders);$i++)
    {
      $sth=mysql_query("update admirals set value=value+".$defending_challenge_points." where fid=".$this->defenders[$i]->fid);

      if (!$sth)
	echo("Database failure1!\n");
    }

    for ($i=0;$i<sizeof($this->attackers);$i++)
    {
      $sth=mysql_query("update admirals set value=value+".$attacking_challenge_points." where fid=".$this->attackers[$i]->fid);

      if (!$sth)
	echo("Database failure2!\n");
    }

  }

  function destroy_ships()
  {
    foreach ($this->losses as $fid=>$ships)
    {
      foreach ($ships as $prod_id=>$count)
      {
	$sth=mysql_query("update fleet set count=count-(".$count.") where fid=$fid and prod_id=$prod_id");

	if (!$sth)
	  echo("Database failure!");
      }
    }
  }

  function get_challenge_points($key)
  {
    for ($i=0;$i<sizeof($key);$i++)
    {
      if ($key[$i]->fid)
	$where.="fid=".$key[$i]->fid." or ";
    }

    $where=substr($where,0,-4);

    $sth=mysql_query("select sum(s.initiative*f.count+s.agility*f.count+s.hull*f.count+s.armor*f.count+s.hull*f.count+s.weaponpower*f.count+s.shield*f.count+s.ecm*f.count+s.sensor*f.count+s.weaponskill*f.count)/1000 as power,fid from shipvalues as s, fleet as f where s.prod_id=f.prod_id and ($where) group by f.fid");

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return 0;

    while (list($points)=mysql_fetch_row($sth))
    {
      $challenge_points+=$points;
    }

    return $challenge_points;
  }
}
?>
