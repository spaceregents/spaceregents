<?php
/**
 * Klasse um oft genutzte map informationen zu verpacken
 * mit cache funktion
 *
 * @author
 * @version
 */
class map_info
{
  /**
   * alliancestati
   */
  var $alliancestatus;

  /**
   * allianzen
   */
  var $alliances;
  /**
   * flotteninfos
   */
  var $fleetinfo;
  /**
   * sterneninfo
   */
  var $stars;
  /**
   * WAS WOHL?!?!?!?!?
   */
  var $uid;

  /**
   * flotten pro system
   */
  var $systemfleets;

  /**
   * flotten pro planet
   */
  var $planetfleets;

  /**
   * Flotten pro system
   */
  var $fleetsbysid;

  /**
   * starowners
   */
  var $starowners;

  /**
   * fleetuid
   */
  var $fleetuid;

  /**
   * flotte je system
   */
  var $sidbyfid;

  /**
   * array mit cid=>sid
   */
  var $constellations;

  /**
   * constellationsids um die es sich in der berechnung hier handelt
   */
  var $cids;

  /**
   * systeme
   */
  var $systems;

  /**
   * spezielle sachen in nem system
   */
  var $specials;

  /**
   * welche user sind in welchem system
   */
  var $usersystems;

  /**
   * was die flotten scannen könenn
   */
  var $fleetscans;

  /**
   * scanradien der flotten
   */
  var $fleetscanradius;

  /**
   * was die systeme scannen konnten
   */
  var $systemscans;

  var $systemscanradius;

  // mop: userspezifische optionen
  var $options;

  /**
   * woche festhalten, wegen persistenter map
   */
  var $week;

  /**
   * planeten eines systems
   */
  var $systemplanets;

  /**
   * planeteninfos
   */
  var $planets;

  /**
   * alle jumpgates
   */
  var $jumpgates;

  /**
   * alle sichtbaren sterne
   */
  var $scanned_sids;
  
  
  /**
   * derzeitige warp reichweite
   */
  var $warp_range;

  /** 
   * fog of war infos 
   */
  var $fog_of_war;

  /**
   * super konstruktor
   *
   * @param $uid
   * @return
   */

  function map_info($uid,$cids=0)
  {
    $this->uid=$uid;
    $this->cids=$cids;
    $this->alliancestatus = false;
    $this->alliances      = false;
    $this->fleetinfo      = false;
    $this->systemfleets   = false;
    $this->starowners     = false;
    $this->fleetuid       = false;
    $this->constellations = false;
    $this->systems        = false;
    $this->sidbyfid       = false;
    $this->options        = false;
    $this->systemscans    = false;
    $this->jumpgates      = false;
    $this->scanned_sids   = false;
    $this->fog_of_war     = false;
  }

  /**
   * alliiert oder nicht
   *
   * @return
   */
  function is_allied($uid)
  {
    if (!$this->alliances)
      $this->_get_alliances();

    if ($this->alliances[$this->uid]==$this->alliances[$uid] && $this->alliances[$this->uid]!=0)
      return true;
    else
      return false;
  }

  /**
   * freundliche allianz. umfasst NICHT ob der in der gleichen allianz wie man selber ist
   *
   * @param $uid
   * @return
   */
  function is_friendly($uid)
  {
    if (!$this->alliancestatus)
      $this->_get_alliancestatus();

    if (!$this->alliances)
      $this->_get_alliances();

    // mop: 2 is "Friend" allianz
    if ($this->alliancestatus[$this->alliances[$this->uid]][$this->alliances[$uid]]==2)
      return true;
    else
      return false;
  }

  /**
   * is das nen feind? sucht in dem allianzdiplomatiestatus
   *
   * @param $uid
   * @return
   */
  function is_enemy($uid)
  {
    if (!$this->alliancestatus)
      $this->_get_alliancestatus();

    if (!$this->alliances)
      $this->_get_alliances();

    // mop: 0 is der FEIND
    if ($this->alliancestatus[$this->alliances[$this->uid]][$this->alliances[$uid]]==="0")
      return true;
    else
      return false;
  }

  /**
   * returnt alle allianzen
   *
   * @return
   */
  function get_allies()
  {
    if (!$this->alliances)
      $this->_get_alliances();

    // mop: hmmm...müsste man theoretisch auch intelligenter machen können glaube ich :S
    if (is_array($this->alliances))
    {
      reset($this->alliances);

      foreach ($this->alliances as $uid => $alliance)
      {
  if ($alliance==$this->alliances[$this->uid] && $uid!=$this->uid)
    $allies[]=$uid;
      }
    }
    else
      $allies=false;

    return $allies;
  }

  /**
   * hat $uid flotten im system?
   *
   * @param $uid,$sid
   * @return
   */
  function fleet_in_sid($uid,$sid)
  {
    if (!$this->systemfleets)
      $this->_get_flocations();
    if (is_array($this->systemfleets[$uid]))
      return in_array($sid,$this->systemfleets[$uid]);
    else
      return false;
  }

  /**
   * flotten pro system rausholen
   *
   * @param $sid
   * @return
   */
  function get_fids_by_sid($sid)
  {
    if (!$this->fleetsbysid)
      $this->_get_flocations();

    return $this->fleetsbysid[$sid];
  }

  /**
   * holt die fids zu einer uid
   *
   * @param $uid
   * @return
   */
  function get_fids_by_uid($uid,$constellations=0)
  {
    if (!$this->systemfleets)
      $this->_get_flocations();

    if ($this->systemfleets[$uid])
    {
      return array_keys($this->systemfleets[$uid]);
    }
    else
    {
      $fids=array();
      return $fids;
    }
  }

  function get_sid_by_fid($fid)
  {
    if (!$this->sidbyfid)
      $this->_get_flocations();

    return $this->sidbyfid[$fid];
  }

  /**
   * returnt allianz von $uid
   *
   * @param $uid
   * @return
   */
  function get_alliance($uid)
  {
    if (!$this->alliances)
      $this->_get_alliances();

    if (!$this->alliances[$uid])
      return "0";
    else
      return $this->alliances[$uid];
  }

  /**
   * eigener stern?
   *
   * @param $sid
   * @return
   */
  function is_own_star($sid)
  {
    if (!$this->starowners)
      $this->_get_starowners();

    return $this->starowners[$sid];
  }

  function get_uid_by_fid($fid)
  {
    if (!$this->fleetuid)
      $this->_get_flocations();

    return $this->fleetuid[$fid];
  }

  function get_stars_info()
  {
    if (!$this->systems)
      $this->_get_systems();

    return $this->systems;
  }

  function get_system($sid)
  {
    if (!$this->systems)
      $this->_get_systems();

    return $this->systems[$sid];
  }

  function is_own_fleet($fid,$type=0)
  {
    if (!$this->fleetuid)
      $this->_get_flocations();

    if ($type==0)
    {
      if ($this->fleetuid[$fid]==$this->uid)
  return true;
      else
  return false;
    }
    else
    {
      if (!$this->alliances)
  $this->_get_alliances();

      if ($this->fleetuid[$fid]==$this->uid || $this->alliances[$this->uid]==$this->alliances[$this->fleetuid[$fid]])
  return true;
      else
  return false;
    }
  }

  function get_sid_type($sid)
  {
    if (!$this->systems)
      $this->_get_systems();

    return $this->systems[$sid]["type"];
  }

  function get_star_info($sid)
  {
    if (!$this->systems)
      $this->_get_systems();

    return $this->systems[$sid];
  }

  function get_special_buildings_by_sid($sid,$type=0)
  {
    if (!$this->specials)
      $this->_get_specials();

    if ($type===0)
    {
      for ($i=0;$i<sizeof($this->specials[$sid]);$i++)
      {
        if ($this->specials[$sid][$i]["special"]!="F")
        $special_tmp[]=$this->specials[$sid][$i];
      }

      return $special_tmp;
    }
    else
      return $this->specials[$sid];
  }

  function get_possible_scan_systems()
  {
    if (!$this->systemscans)
      $this->_get_systemscans();

    $scanned_sids=array();

    if (!is_array($this->systemscans))
      return array();

    foreach ($this->systemscans as $sid => $scans)
    {
      $scanned_sids=array_merge($scanned_sids,$scans);
      $scanned_sids[]=$sid;
    }
    return array_unique($scanned_sids);
  }

  function get_all_fleet_scans()
  {
    if (!is_array($this->fleetscans))
      $this->_get_fleetscans();

    if (!is_array($this->fleetscans))
      return array();

    $scanned_sids=array();
    foreach ($this->fleetscans as $sid => $scans)
    {
      $scanned_sids=array_merge($scanned_sids,$scans);
      $scanned_sids[]=$sid;
    }
    return array_unique($scanned_sids);
  }

  function get_scanned_systems()
  {
    if (!$this->scanned_systems)
    {
      $this->scanned_systems=array_merge($this->get_possible_scan_systems(),$this->get_all_fleet_scans());
      
      // mop: alle allierten flotten erfassen, die kein scanrange haben...die systeme darf man natürlich auch sehen
      $allies=$this->get_allies();

      if (!$allies)
        $allies=array();
      array_push($allies,$this->uid);
      
      if (!$this->systemfleets)
        $this->_get_flocations();

      foreach ($allies as $uid)
      {
        foreach ((array)$this->systemfleets[$uid] as $fid => $sid)
          $this->scanned_systems[]=$sid;
      }

      $this->scanned_systems=array_unique($this->scanned_systems);
    }

    return $this->scanned_systems;
  }

  function get_fleet_scan_radius($sid)
  {
    if (!is_array($this->fleetscanradius))
      $this->_get_fleetscans();

    return $this->fleetscanradius[$sid];
  }

  function get_uid_by_sid($sid, $all = false)
  {
    if (!$this->usersystems)
    {
      if (!$all)
        $this->_get_usersystems();
      else
        $this->_get_usersystems("");
    }

    return $this->usersystems[$sid];
  }

  function get_systemscanradius($sid)
  {
    if (!$this->systemscanradius)
      $this->_get_systemscans();

    return $this->systemscanradius[$sid];
  }

  function has_map_anims()
  {
    if (!$this->options)
      $this->_get_options();

    return $this->options["map_anims"];
  }

  function has_map_autoupdate()
  {
    if (!$this->options)
      $this->_get_options();

    return $this->options["map_autoupdate"];
  }

  function get_user_map_size()
  {
    if (!$this->options)
      $this->_get_options();

    return $this->options["map_size"];
  }

  function get_systemplanets($sid)
  {
    if (!$this->systemplanets[$sid])
      $this->_get_systemplanets($sid);

    return $this->systemplanets[$sid];
  }

  function get_jumpgates()
  {
    if (!$this->jumpgates)
      $this->_get_jumpgates();

    return $this->jumpgates;
  }
  
  function get_warprange()
  {
    if (!$this->warprange)
      $this->_get_warprange();
    
    return $this->warprange;
  }

  function get_fog_of_war()
  {
    if (!$this->fog_of_war)
      $this->_get_fog_of_war();

    return $this->fog_of_war;
  }

/*

AB HIER PRIVATE FUNKTIONEN

*/

  /**
   * holt sämtliche allianzen
   *
   * @access private
   * @return
   */
  function _get_alliances()
  {
    $sth=mysql_query("select u.id,a.id from users u, alliance a where u.alliance=a.id");

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    while (list($uid,$alliance)=mysql_fetch_row($sth))
    {
      $this->alliances[$uid]=$alliance;
    }

    return true;
  }

  /**
   * holt sämtliche diplomatieverbindungen
   *
   * @return
   */
  function _get_alliancestatus()
  {
    $sth=mysql_query("select alliance1,alliance2,status from diplomacy");

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    while (list($aid1,$aid2,$status)=mysql_fetch_row($sth))
    {
      $this->alliancestatus[$aid1][$aid2]=$status;
    }

    return true;
  }

  /**
   * holt fleetinfos
   *
   * @return
   */
  function _get_fleetinfo()
  {
    if ($this->cids==0)
      $sth=mysql_query("select fid,uid,pid,sid,tpid,tsid,mission,name from fleet_info");
    else
    {
      if (!$this->cidquery)
  $this->_get_cidquery();

      $sth=mysql_query("select f.fid,f.uid,f.pid,f.sid,f.tpid,f.tsid,f.mission,f.name from fleet_info f, systems s where s.id=f.sid and (".$this->cidquery.")");
    }

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    $this->fleetinfo=array();

    while ($data=mysql_fetch_assoc($sth))
      $this->fleetinfo[]=$data;

    return true;
  }

  /**
   * holt flottenpositionen und splittet in $systemfleets, $planetfleets und $fleetsbysid auf
   *
   * @return
   */
  function _get_flocations()
  {
    if (!$this->fleetinfo)
      $this->_get_fleetinfo();

    if (is_array($this->fleetinfo))
    {
      reset ($this->fleetinfo);

      foreach ($this->fleetinfo as $key => $finfo)
      {
        $this->systemfleets[$finfo["uid"]][$finfo["fid"]]=$finfo["sid"];
        $this->fleetsbysid[$finfo["sid"]][]=$finfo["fid"];
        // => bla ;)
        $this->planetfleets[$finfo["uid"]][$finfo["fid"]]=$finfo["pid"];
        $this->fleetuid[$finfo["fid"]]=$finfo["uid"];
        $this->sidbyfid[$finfo["fid"]]=$finfo["sid"];
      }
    }

    return true;
  }

  function _get_starowners()
  {
    if (!$this->cids)
      $sth=mysql_query("select distinct p.sid from planets p,users u where u.alliance=".$this->get_alliance($this->uid)." and p.uid=u.id");
    else
    {
      if (!$this->cidquery)
  $this->_get_cidquery();

      $sth=mysql_query("select distinct p.sid from planets p,users u left join systems as s on p.sid=s.id and (".$this->cidquery.") where u.alliance=".$this->get_alliance($this->uid)." and p.uid=u.id");
    }

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    while (list($sid)=mysql_fetch_row($sth))
      $this->starowners[$sid]=true;

    return true;
  }

  function _get_constellations()
  {
    $sth=mysql_query("select cid,id from systems");

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    while (list($cid,$sid)=mysql_fetch_row($sth))
      $this->constellations[$cid][]=$sid;

    return true;
  }

  function _get_systems()
  {
    if ($this->cids==0)
      $sth=mysql_query("select id,x,y,name,type from systems");
    else
    {
      if (!$this->cidquery)
        $this->_get_cidquery();

      $sth=mysql_query("select id,x,y,name,type from systems s where (".$this->cidquery.")");
    }

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    while ($system=mysql_fetch_assoc($sth))
    {
      $this->systems[$system["id"]]=$system;
    }

    return true;
  }

  function _get_specials()
  {
    if ($this->cids)
    {
      if (!$this->cidquery)
        $this->_get_cidquery();

      $sth = mysql_query("select pl.sid,p.special, o.pid from constructions as o, production as p,planets pl, systems s where pl.sid=s.id and (".$this->cidquery.") and o.prod_id = p.prod_id and (p.special = 'S' or p.special = 'U' or p.special='F') and o.pid=pl.id");
    }
    else
    {
      $sth = mysql_query("select pl.sid,p.special, o.pid from constructions as o, production as p,planets pl where o.prod_id = p.prod_id and (p.special = 'S' or p.special = 'U' or p.special='F') and o.pid=pl.id");
    }
    if (!$sth)
      return false;

    while (list($sid,$special,$pid)=mysql_fetch_row($sth))
      $this->specials[$sid][]=array("special"=>$special,"pid"=>$pid);

    return true;
  }

  function _get_cidquery()
  {
    $this->cidquery="";
    for ($i=0;$i<sizeof($this->cids);$i++)
      $this->cidquery.="s.cid=".$this->cids[$i]." or ";

    $this->cidquery=substr($this->cidquery,0,-4);
  }

  function _get_usersystems($distinct = "distinct")
  {
    if ($this->cids)
    {
      if (!$this->cidquery)
  $this->_get_cidquery();

      $sth=mysql_query("select ".$distinct." p.uid,p.sid from planets p,systems s where (".$this->cidquery.") and p.uid!=0 and p.sid=s.id");
    }
    else
    {
      $sth=mysql_query("select ".$distinct." p.uid,p.sid from planets p where p.uid!=0");
    }

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    while (list($uid,$sid)=mysql_fetch_row($sth))
      $this->usersystems[$sid][]=$uid;

    return true;

  }

  function _get_fleetscans()
  {
    $this->fleetscans=array();
    $this->fleetscanradius=array();

    $allies=$this->get_allies();

    if (!$allies)
      $allies=array();
    array_push($allies,$this->uid);

    $uquery="sr.uid in (".implode($allies,",").")";

    if ($this->cids)
      $constellations=$this->cids;
    else
    {
      if (!$this->constellations)
  $this->_get_constellations();
      $constellations=array_keys($this->constellations);
    }

    $scan_ranges=array();
    for ($i=0;$i<sizeof($constellations);$i++)
    {
      $scan_ranges[]="select s1.id,s2.id,sr.range from systems s1,systems s2, __scanranges_".$constellations[$i]." sr where s2.id=sr.sid and ".$uquery." and sr.type=1 and sqrt(pow(s1.x-s2.x,2)+pow(s1.y-s2.y,2))<=sr.range";
    }

    if (sizeof($scan_ranges)>0)
    {
      $query=implode($scan_ranges," union ");

      $sth=mysql_query($query);

      if (!$sth)
        return 0;

      while (list($sid,$homesid,$radius)=mysql_fetch_row($sth))
      {
        $this->fleetscans[$homesid][]=(int)$sid;
        $this->fleetscanradius[$homesid]=$this->fleetscanradius[$homesid] > $radius ? $this->fleetscanradius[$homesid] : $radius;
      }
    }
    return true;
  }

  function _get_systemscans()
  {
    global $standard_scan_radius;

    $this->systemscans=array();
    $this->systemscanradius=array();

    $allies=$this->get_allies();

    if (!$allies)
      $allies=array();

    array_push($allies,$this->uid);

    $uquery="";
    for ($i=0;$i<sizeof($allies);$i++)
    {
      $uquery.="sr.uid=".$allies[$i]." or ";
    }

    $uquery=substr($uquery,0,-4);

    if ($this->cids)
      $constellations=$this->cids;
    else
    {
      if (!$this->constellations)
  $this->_get_constellations();
      $constellations=array_keys($this->constellations);
    }

    $scan_ranges=array();
    for ($i=0;$i<sizeof($constellations);$i++)
    {
      $scan_ranges[]="select s1.id,s2.id,sr.range from systems s1,systems s2, __scanranges_".$constellations[$i]." sr where s2.id=sr.sid and (".$uquery.") and sr.type=0 and sqrt(pow(s1.x-s2.x,2)+pow(s1.y-s2.y,2))<=sr.range";
    }

    if (sizeof($scan_ranges)>0)
    {
      $query=implode($scan_ranges," union ");

      $sth=mysql_query($query);

      if (!$sth)
  return 0;

      while (list($sid,$homesid,$radius)=mysql_fetch_row($sth))
      {
  $this->systemscans[$homesid][]=(int)$sid;
  $this->systemscanradius[$homesid]=$this->systemscanradius[$homesid]>$radius ? $this->systemscanradius[$homesid] : $radius;
      }
    }

    return true;
  }

  function _get_options()
  {
    $sth=mysql_query("select map_size,map_constellation_cache,map_system_cache,map_anims, map_autoupdate from options where uid=".$this->uid);

    if (!$sth || mysql_num_rows($sth)==0)
      return false;

    $this->options=mysql_fetch_array($sth);

    return true;
  }

  function _get_systemplanets($sid)
  {
    $sth=mysql_query("select x,sid,uid,metal,energy,mopgas,erkunum,gortium,susebloom,start,id,name,type,population from planets where sid=".$sid." order by x");

    if (!$sth)
      return false;

    if (!is_array($this->systemplanets))
      $this->systemplanets=array();
    if (!is_array($this->planets))
      $this->planets=array();

    while ($planet=mysql_fetch_assoc($sth))
    {
      if ($planet["name"] == "Unnamed")
        $planet["name"] = get_planetname($planet["id"]);

      addslashes($planet["name"]);

      $this->systemplanets[$sid][]=$planet;
      $this->planets[$planet["id"]]=$planet;
    }
  }

  function _get_jumpgates()
  {
    $sth=mysql_query("select j.password as password,j.sid as sid,j.pid as pid,jv.tonnage as tonnage,j.used_tonnage as used_tonnage,p.uid from jumpgates j,jumpgatevalues jv,planets p where j.prod_id=jv.prod_id and p.id=j.pid");

    if (!$sth)
      return false;

    $this->jumpgates=array();

    while ($jumpgate=mysql_fetch_assoc($sth))
      $this->jumpgates[]=$jumpgate;
  }
  
  
  function _get_warprange()
  {
    global $no_warp_tech;
    
    $sth = mysql_query("select IFNULL(max(range),".$no_warp_tech.") from warp w join research r on w.tid = r.t_id where r.uid=".$this->uid);

    if (!$sth)
      return false;

    list($this->warprange) = mysql_fetch_row($sth);    
  }

  function _get_fog_of_war()
  {
    $sth=mysql_query("select data from fog_of_war where uid=".$this->uid);

    if (!$sth)
      return false;
    
    if (mysql_num_rows($sth)==0)
      $this->fog_of_war=array();
    else
    {
      list($data)=mysql_fetch_row($sth);
      $this->fog_of_war=unserialize($data);
    }
  }
}
?>
