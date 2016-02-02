<?php
class fleet_manager
{
  /** 
   * $data=array(1=>array(6=>20)) =======> 20 interceptoren (prod_id 6) sollen transferiert werden
   */
  var $source_data;

  /** 
   * zielflotte als objekt
   */
  var $target_fleet;

  /** 
   * zielflottenid 
   */
  var $target_fid;

  /** 
   * quellflotten als objekt 
   */
  var $source_fleets;
  
  /** 
   * ctor 
   * 
   * @param $source_fids - array(fid=>array(prod_id=>count), $target_fid zielflottenid
   */
  function fleet_manager($source_data,$target_fid=0)
  {
    $this->source_data  =$source_data;
    // mop: erstmal initialisieren, damits keinen ärger gibt
    $this->source_fleets=array();
    // mop: dann alle flotten initialisieren...müssen wir eh haben
    foreach ((array) $source_data as $fid => $data)
      $this->source_fleets[$fid]=new fleet($fid);
    
    $this->target_fid   =$target_fid;
    $this->get_target_fleet($target_fid);
  }

  function get_target_fleet()
  {
    // mop: flotte gibts noch nicht...also erstellen wir eine mit den infos der ersten quellflotte
    if ($this->target_fid==0)
    {
      $first_fid=key($this->source_fleets);
      $this->target_fleet             =new fleet();
      $this->target_fleet->pid        =$this->source_fleets[$first_fid]->pid;
      $this->target_fleet->sid        =$this->source_fleets[$first_fid]->sid;
      $this->target_fleet->mission    =$this->source_fleets[$first_fid]->mission;
      $this->target_fleet->tpid       =$this->source_fleets[$first_fid]->tpid;
      $this->target_fleet->tsid       =$this->source_fleets[$first_fid]->tpid;
      $this->target_fleet->milminister=$this->source_fleets[$first_fid]->milminister;
      $this->target_fleet->uid        =$this->source_fleets[$first_fid]->uid;

      $this->target_fleet->create_fleet();

      // mop: route auch mitkopieren...sonst gibts fiese fehler
      $sth=mysql_query("replace into routes (fid,route) select ".$this->target_fleet->fid.",route from routes where fid=".$this->source_fleets[$first_fid]->fid);

      if (!$sth)
        return false;
    }
    else
    {
      $this->target_fleet=new fleet($this->target_fid);
    }
  }

  /** 
   * führe den transfer durch 
   * 
   * @return 
   */
  function execute()
  {
    $new_inf=array();
    foreach ($this->source_data as $fid => $data)
    {
      // mop: quellflotte is nicht da, wo die zielflotte ist...schiffe beamen geht nicht ;)
      if ($this->source_fleets[$fid]->pid!=$this->target_fleet->pid || $this->source_fleets[$fid]->sid!=$this->target_fleet->sid)
        continue;
      
      // mop: die inf holen
      $infantery=$this->get_fleet_infantery($fid);
      $tmp_new_inf=$this->transfer_ships($fid,$data,$infantery);
      foreach ($tmp_new_inf as $prod_id => $count)
        $new_inf[$prod_id]+=$count;
    }
    
    // mop: alle flotten updaten
    $this->target_fleet->update_all_prod_ids();
    $this->add_infantery($this->target_fleet->fid,$new_inf);
    
    foreach ($this->source_fleets as $fid => $fleet)
      $this->source_fleets[$fid]->update_all_prod_ids(); 
  
    delete_empty_fleets();
    
    $sth=mysql_query("delete from inf_transports where count=0");

    if (!$sth)
      return 0;
  }

  /** 
   * flotteninfanterie holen 
   * 
   * @param $fid 
   * @return 
   */
  function get_fleet_infantery($fid)
  {
    $sth=mysql_query("select sum(iv.tonnage*i.count) from inf_transports as i,shipvalues as iv where iv.prod_id=i.prod_id and i.fid=".$fid);

    if (!$sth)
      return 0;

    if (mysql_num_rows($sth)>0)
      list($infantery)=mysql_fetch_row($sth);
    else
      $infantery=0;

    return $infantery;
  }

  /** 
   * schiffe gemäss $data von quell zu zielflotte transferieren und infantery auch nicht vergessen ;) 
   * 
   * @return 
   */
  function transfer_ships($source_fid,$data,&$infantery)
  {
    $new_inf=array();
    
    // mop: alles was der mensch angegeben hat durchgehen
    foreach ($data as $prod_id => $count)
    {
      if (($this->source_fleets[$source_fid]->ships[$prod_id]) && ($this->source_fleets[$source_fid]->ships[$prod_id][0]>=$count) && ((int) $count>0))
      {
        $this->source_fleets[$source_fid]->ships[$prod_id][0]-=$count;
        $this->target_fleet->add_ships_arr(array($prod_id=>array($count,$this->source_fleets[$source_fid]->ships[$prod_id][1])));

        if ($infantery>0)
        {
          $sth=mysql_query("select i.storage*".$count." from fleet as f , inf_transporters as i where i.prod_id=f.prod_id and f.prod_id=".$prod_id." and f.prod_id=".$prod_id." and f.fid=".$source_fid);

          $trans_storage=mysql_fetch_row($sth);

          $j=0;

          if ($trans_storage[0]>0)
          {
            while (($infantery>0) and ($trans_storage[0]>0))
            {
              $sth=mysql_query("select if(i.tonnage*it.count>".$trans_storage[0].",floor(".$trans_storage[0]."/i.tonnage),it.count),it.prod_id,it.count,i.tonnage as storage from inf_transports as it, shipvalues as i where i.prod_id=it.prod_id and it.fid=".$source_fid." limit ".$j.",".($j+1));

              $j++;

              if (!$sth)
                return 0;

              // der schneider hätte mich getötet
              if (mysql_num_rows($sth)==0)
                break;

              // mop: man hab ich früher hässlichen code gemacht...naja...ka was das macht..ich lass das ma so
              $new=mysql_fetch_row($sth);

              $new_inf[$new[1]]+=$new[0];

              $infantery-=$new[2]*$new[3];

              $trans_storage[0]-=$new[0]*$new[3];

              $sth=mysql_query("update inf_transports set count=count-".$new[0]." where fid=".$source_fid." and prod_id=".$new[1]);

              if (!$sth)
                return 0;
            }
          }
        }
      }
    }
    return $new_inf;
  }
 
  function add_infantery($fid,$new_inf)
  {
    foreach ($new_inf as $prod_id => $count)
    {
      $sth=mysql_query("select prod_id from inf_transports where prod_id=$prod_id and fid=".$fid);

      if (!$sth)
      {
        return 0;
      }

      if (mysql_num_rows($sth)>0)
      {
        $sth=mysql_query("update inf_transports set count=count+$count where prod_id=$prod_id and fid=".$fid);
      }
      else
      {
        $sth=mysql_query("insert into inf_transports (prod_id,count,fid) values ('".$prod_id."','".$count."','".($fid)."')");
      }

      if (!$sth)
      {
        return 0;
      }
    }
  }
}
?>
