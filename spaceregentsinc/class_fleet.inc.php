<?
/* Zentrale Flottenklasse... alle wichtigen variablen werden im objekt gepeichert...aufruf über $fleet=new fleet($fid) */

class fleet
{
  var $fid;
  var $uid;
  var $ships=array(); // array der schiffe $ships[$prod_id]=array($count,$reload);
  var $mission;
  var $pid;
  var $sid;
  var $tpid;
  var $tsid;
  var $milminister;
  var $name;

  // Konstruktor

  function fleet($fid=0)
  {
    if ($fid!=0)
    {
      // erst nur die globalen Sachen holen...dürfte schneller sein

      $sth=mysql_query("select * from fleet_info where fid=$fid");

      if (!$sth)
        return false;

      if (mysql_num_rows($sth)!=0)
      {
        $fleet=mysql_fetch_array($sth);

        // $this ist das objekt...$fleet=new fleet(14); würde ein neues objekt erstellen...$this wäre = $fleet
        // Dementsprechend kann man mit $fleet->fid nachher im Programm die flottenid ausgeben

        $this->fid=$fleet["fid"];
        $this->uid=$fleet["uid"];
        $this->mission=$fleet["mission"];
        $this->pid=$fleet["pid"];
        $this->tpid=$fleet["tpid"];
        $this->tsid=$fleet["tsid"];
        $this->sid=$fleet["sid"];
        $this->milminister=$fleet["milminister"];
        $this->name=$fleet["name"];
        $this->tactic=$fleet["tactic"];

        // Jetzt die schiffe der flotte

        $sth=mysql_query("select prod_id,count,reload from fleet where fid=$fid");

        if (!$sth)
          return false;

        // $ships bezieht sich NICHT auf das Objekt sondern ist eine lokal variable...$this->ships bezieht sich auf das objekt

        while ($ships=mysql_fetch_array($sth))
        {
          $this->ships[$ships["prod_id"]]=array($ships["count"],$ships["reload"]);
        }

        // Objekt ist fertig
        // Nun können sämtlichen methoden dieser klasse benutzt werden
      }
    }
  }
  //----------------------------------------------------------------------------------------------------------------------



  function destroy()
  {
    // Löscht die flotte

    if (!$this->fid)
      return 0;

    $sth=mysql_query("delete from fleet where fid=".$this->fid);

    $sth=mysql_query("delete from fleet_info where fid=".$this->fid);
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_mission()
  {
    switch ($this->mission)
    {
      case "0":
        $mission_text[0]="Defending";
        $mission_text[1]="defend";
        $mission_text[2]="#icon_Defend";
      break;
      case "1":
        $mission_text[0]="Attacking";
        $mission_text[1]="attack";
        $mission_text[2]="#icon_Attack";
      break;
      case "2":
        $mission_text[0]="Intercepting fleets in";
        $mission_text[1]="intercept fleets in";
        $mission_text[2]="#icon_Intercept";
      break;
      case "3":
        $mission_text[0]="Bombarding";
        $mission_text[1]="bombard";
        $mission_text[2]="#icon_Bomb";
      break;
      case "4":
        $mission_text[0]="Colonizing";
        $mission_text[1]="colonize";
        $mission_text[2]="#icon_Colonize";
        break;
      case "5":
        $mission_text[0]="Invading";
        $mission_text[1]="invade";
        $mission_text[2]="#icon_Invade";
      break;
    }

    return $mission_text;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_location()
  {
    // returnt array z.B. $location[$type]=array($location=>$locationtype)
    // also $type=bewegend oder stehend $locationtype=system oder planet

    /*

       $type=0 : stehend
       $type=1 : bewegend
       $locationtype=0 : planet
       $locationtype=1 : system

     */

    if (($this->pid!=0) and ($this->tsid==0) and ($this->tpid==0))
    {
      $type=0;
      $location=$this->pid;
      $locationtype=0;
    }
    elseif (($this->pid==0) and ($this->tsid) and ($this->tpid==0))
    {
      $type=0;
      $location=$this->sid;
      $locationtype=1;
    }
    elseif (($this->tsid!=0) and ($this->tpid==0))
    {
      $type=1;
      $location=$this->sid;
      $locationtype=1;
    }
    elseif (($this->tsid!=0) and ($this->tpid!=0))
    {
      $type=1;
      $location=$this->pid;
      $locationtype=0;
    }
    elseif (($this->sid!=0) and ($this->pid==0) and ($this->tsid==0))
    {
      $type=0;
      $location=$this->sid;
      $locationtype=1;
    }
    elseif ($this->pid!=0)
    {
      $type=0;
      $location=$this->pid;
      $locationtype=0;
    }
    else
      echo("8[");

    return array($type,array($location,$locationtype));
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_admiral()
  {
    $sth=mysql_query("select a.id from admirals as a, fleet_info as f where f.fid=a.fid and a.fid=".$this->fid);

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return false;
    else
    {
      $admiral=mysql_fetch_row($sth);

      return $admiral[0];
    }
  }
  //----------------------------------------------------------------------------------------------------------------------



  // runelord: 2 neue admiral funktionen zum neu setzen und zum absetzen ^^
  function unset_admiral()
  {
    $sth = mysql_query("update admirals set fid=0 where fid=".$this->fid);

    if (!$sth)
      return false;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function set_admiral($admiral)
  {
    $this->unset_admiral();

    $sth = mysql_query("update admirals set fid=".$this->fid." where id=".$admiral);

    if (!$sth)
      return false;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_max_reload()
  {
    $reload=0;

    reset($this->ships);

    while (list($dummy,$ships)=each($this->ships))
    {
      if ($ships[1]>$reload)
  $reload=$ships[1];
    }

    return $reload;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_total_shipcount()
  {
    // Hmm mysql dürfte schneller als php sein

    $sth=mysql_query("select sum(count) from fleet where fid=".$this->fid);

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return 0;

    $count=mysql_fetch_row($sth);

    return $count[0];
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_tonnage($prod_id)
  {
    $sth=mysql_query("select sum(f.count*s.tonnage) from fleet as f,shipvalues as s where s.prod_id=f.prod_id and f.prod_id=".$prod_id." and f.fid=".$this->fid);

    if ((!$sth) || (mysql_num_rows($sth)==0))
      return 0;

    $tonnage=mysql_fetch_row($sth);

    return $tonnage[0];
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_total_tonnage()
  {
    reset($this->ships);

    while (list($prod_id,$ships)=each($this->ships))
    {
      $tonnage+=$this->get_tonnage($prod_id);
    }

    return $tonnage;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_ships_by_prod_ids($prod_ids)
  {
    for ($i=0;$i<sizeof($prod_ids);$i++)
    {
      $ships[]=$this->ships[$prod_ids[$i]][0];
    }

    return $ships;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function add_ships_arr($ships)
  {
    reset ($ships);

    while (list($prod_id,$ship_arr)=each($ships))
    {
      if ($ship_arr[0]>0)
      {
        $this->ships[$prod_id][0]+=$ship_arr[0];

        if (!$this->ships[$prod_id][1])
          $this->ships[$prod_id][1] = $ship_arr[1];
        elseif ($ship_arr[1] > $this->ships[$prod_id][1])
          $this->ships[$prod_id][1] = $ship_arr[1];
      }
    }
  }
  //----------------------------------------------------------------------------------------------------------------------



  function remove_ships_arr($ships)
  {
    reset ($ships);

    while (list($prod_id,$ship_arr)=each($ships))
    {
      if ($ship_arr[0]>0)
      {
        $this->ships[$prod_id][0]-=$ship_arr[0];

        if ($this->ships[$prod_id][0]<0)
          $this->ships[$prod_id][0]=0;
      }
    }
  }
  //----------------------------------------------------------------------------------------------------------------------




  function create_fleet()
  {
    if ($this->fid!=0)
      return false;

    // Das is die fleet_info

    $sth=mysql_query("insert into fleet_info (pid,sid,tpid,tsid,mission,milminister,uid) values ('".$this->pid."','".$this->sid."','".$this->tpid."','".$this->tsid."','".$this->mission."','".$this->milminister."','".$this->uid."')");

    if (!$sth)
      return false;

    $this->fid=mysql_insert_id();

    // Jetzt kommen die einzelnen schiffe
    if (is_array($this->ships))
    {
      while (list($prod_id,$ship_arr)=each($this->ships))
      {
        $sth=mysql_query("insert into fleet (prod_id,count,reload,fid) values ('".$prod_id."','".$ship_arr[0]."','".$ship_arr[1]."','".$this->fid."')");

        if (!$sth)
          return false;
      }
    }

    return true;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function update_prod_id($prod_id)
  {
    if (!$this->ships[$prod_id])
      return false;

    if ($prod_id==0)
      return false;

    if ($this->ships[$prod_id]==0)
      return false;

    if ($this->fid==0)
      return false;

    // runelord: wenn count <= 0, dann den eintrag entfernen
    if ($this->ships[$prod_id][0] <= 0)
    {
      $sth=mysql_query("delete from fleet where prod_id=$prod_id and fid=".$this->fid);
    }
    else
    {
      $sth=mysql_query("update fleet set count=".$this->ships[$prod_id][0]." where prod_id=$prod_id and fid=".$this->fid);
    }

    $aff_rows=mysql_affected_rows();

    if ($aff_rows==0)
    {
      $sth=mysql_query("select fid from fleet where prod_id=$prod_id and fid=".$this->fid);

      if (!$sth)
        return false;

      if (mysql_num_rows($sth)==0)
      {
        $sth=mysql_query("insert into fleet (prod_id,count,fid) values ('".$prod_id."','".$this->ships[$prod_id][0]."','".$this->fid."')");

        if (!$sth)
          return false;
      }
    }
    return true;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function update_all_prod_ids()
  {
    ob_start();
    var_dump($this->ships);
    $peter=ob_get_contents();
    ob_end_clean();
    mysql_query("======>".$peter);
    while (list($prod_id,$ship_arr)=each($this->ships))
    {
      $sth=mysql_query("update fleet set count=".$ship_arr[0].",reload=".$ship_arr[1]." where fid=".$this->fid." and prod_id=".$prod_id);

      if (!$sth)
  return false;

      $aff_rows=mysql_affected_rows();

      if ($aff_rows==0)
      {
  $sth=mysql_query("select prod_id from fleet where fid=".$this->fid." and prod_id=".$prod_id);

  if (!$sth)
    return false;

  if (mysql_num_rows($sth)==0)
  {
    $sth=mysql_query("insert into fleet (prod_id,count,fid,reload) values ('".$prod_id."','".$this->ships[$prod_id][0]."','".$this->fid."','".$this->ships[$prod_id][1]."')");

    if (!$sth)
      return false;
  }
      }
    }

    return true;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function set_name()
  {
    $sth=mysql_query("update fleet_info set name='".addslashes($this->name)."' where fid=".$this->fid);

    if (!$sth)
      return false;
    else
      return true;
  }
  //----------------------------------------------------------------------------------------------------------------------



  function get_infantry_count_aboard()
  {
    $sth = mysql_query("select sum(count) from inf_transports where fid=".$this->fid);

    if ((!$sth) || (!mysql_num_rows($sth)))
      return 0;

    list($its_infantry_count) = mysql_fetch_row($sth);

    return $its_infantry_count;
  }
  //----------------------------------------------------------------------------------------------------------------------


  function get_total_transporter_capacity()
  {
    $capacity = false;
    $sth = mysql_query("select IFNULL(sum(count*storage),false) as fleet_capacity from fleet f join inf_transporters i using(prod_id) where f.fid='".$this->fid."'");

    if (!$sth || (!mysql_num_rows($sth)))
      return false;

    list($capacity) = mysql_fetch_row($sth);

    return $capacity;
  }
  //----------------------------------------------------------------------------------------------------------------------


  /* gibt nen array
     [i][0] = prod_id
     [1][1] = count
     [i][2] = storage / unit
     zurück
  */
  function get_infantry()
  {
    $infantry = array();

    $sth = mysql_query("select i.prod_id, count, iv.tonnage from inf_transports i join fleet_info f using(fid), shipvalues iv where f.fid='".$this->fid."' and iv.prod_id = i.prod_id");
    if (!$sth || (!mysql_num_rows($sth)))
      return false;

    $i = 0;
    while (list($prod_id, $count, $tonnage) = mysql_fetch_row($sth))
    {
      $infantry[$i][0] = $prod_id;
      $infantry[$i][1] = $count;
      $infantry[$i][2] = $tonnage;
      $i++;
    }

    return $infantry;
  }
  //----------------------------------------------------------------------------------------------------------------------


  function get_coordinates()
  {
    $sth = mysql_query("select x,y from systems where id=".$this->sid);

    if ((!$sth) || (!mysql_num_rows($sth)))
      return 0;

    $system_coordinates = mysql_fetch_array($sth);

    $its_coordinates[x] = $system_coordinates["x"];
    $its_coordinates[y] = $system_coordinates["y"];

    return $its_coordinates;
  }
  //----------------------------------------------------------------------------------------------------------------------


  function get_constellation()
  {
    $sth = mysql_query("select c.id from constellations c, systems s where s.cid = c.id and s.id=".$this->sid);

    if ((!$sth) || (!mysql_num_rows($sth)))
      return 0;

    list($its_constellation) = mysql_fetch_row($sth);

    return $its_constellation;
  }
  //----------------------------------------------------------------------------------------------------------------------
}
?>
