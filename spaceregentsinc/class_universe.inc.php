<?
/** 
 * class universe - beschreibt das sr universum
 * 
 * @author mop
 * @version 
 */
class universe
{
  /** 
   * konstruktor - setzt variablen für universum. siehe class_god und map_getstarmap
   * 
   * @return 
   */
  function universe()
  {
    $this->max_user_systems_per_const=10; // in prozent
    $this->constwidth=1000;
    $this->constheight=1000;
    $this->systems_per_const_min=10;
    $this->systems_per_const_max=15;
  }

  /** 
   * holt zu einer constellation die umliegenden
   * 
   * @param $cid 
   * @return 
   */
  function get_surrounding_constellations($cid)
  {
    // mop: koordinaten der jeweiligen constellation holen
    $sth=mysql_query("select max(x) as maxx,max(y) as maxy,min(x) as minx,min(y) as miny from systems where cid=$cid");

    if (!$sth)
    {
      echo("Database failureblerks");
      return 0;
    }

    $coords=mysql_fetch_array($sth);
    
    // mop: da kommen die cids rein, die drumherum liegen
    $cids[]=$cid;

    // mop: jetzt berechnen wo die umliegenden constellationen liegen müssten
    
    // links davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"]-$this->constwidth,$coords["maxx"]-$this->constwidth,$coords["miny"],$coords["maxy"])))
      $cids[]=$cid;
    // linksoben davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"]-$this->constwidth,$coords["maxx"]-$this->constwidth,$coords["miny"]-$this->constheight,$coords["maxy"]-$this->constheight)))
      $cids[]=$cid;
    // oben davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"],$coords["maxx"],$coords["miny"]-$this->constheight,$coords["maxy"]-$this->constheight)))
      $cids[]=$cid;
    // oben rechts davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"]+$this->constwidth,$coords["maxx"]+$this->constwidth,$coords["miny"]-$this->constheight,$coords["maxy"]-$this->constheight)))
      $cids[]=$cid;
    // rechts davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"]+$this->constwidth,$coords["maxx"]+$this->constwidth,$coords["miny"],$coords["maxy"])))
      $cids[]=$cid;
    // unten rechts davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"]+$this->constwidth,$coords["maxx"]+$this->constwidth,$coords["miny"]+$this->constheight,$coords["maxy"]+$this->constheight)))
      $cids[]=$cid;
    // unten davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"],$coords["maxx"],$coords["miny"]+$this->constheight,$coords["maxy"]+$this->constheight)))
      $cids[]=$cid;
    // unten rechts davon
    if ($cid=$this->const_exists($this->get_start_coords($coords["minx"]-$this->constwidth,$coords["maxx"]-$this->constwidth,$coords["miny"]+$this->constheight,$coords["maxy"]+$this->constheight)))
      $cids[]=$cid;
    
    return $cids;
  }

  /** 
   * prüft ob eine constellation an diesem punkt existiert
   * 
   * @param $coords 
   * @return 
   */
  function const_exists($coords)
  {
    $minx=$coords[0];
    $maxx=$coords[1];
    $miny=$coords[2];
    $maxy=$coords[3];
    
    $sth=mysql_query("select cid from systems where x>=$minx and x<$maxx and y>=$miny and y<$maxy limit 1");

    if (!$sth)
    {
      echo("Database failure!.");
      return 0;
    }

    if (mysql_num_rows($sth)>0)
    {
      list($cid)=mysql_fetch_row($sth);
      return $cid;
    }
    else
      return false;
  }

  
  /** 
   * sucht die minimal und maximal koordinaten einer konstellation
   * 
   * @param $startx,$endx,$starty,$endy 
   * @return 
   */
  function get_start_coords($startx,$endx,$starty,$endy)
  {
//    echo("GET START COORDS VON $startx,$endx,$starty,$endy\n");

//    echo("RESULTAT ".($startx-($startx % $this->constwidth)+1)." - ".($endx+($this->constwidth-$endx%$this->constwidth))." - ".($starty-$starty%$this->constheight+1)."- ".($endy+($this->constheight-$endy%$this->constheight))."\n");
    if ($startx<=0)
      $return[]=-499;
    elseif (($startx-1) % $this->constwidth==0)
      $return[]=$startx;
    else
      $return[]=$startx-($startx % $this->constwidth)+1;
    if ($endx<=0)
      $return[]=0;
    elseif ($endx % $this->constwidth==0)
      $return[]=$endx;
    else
      $return[]=$endx+($this->constwidth-$endx%$this->constwidth);
    if ($starty<=0)
      $return[]=-499;
    elseif (($starty-1) % $this->constheight==0)
      $return[]=$starty;
    else
      $return[]=$starty-$starty%$this->constheight+1;
    if ($endy<=0)
      $return[]=0;
    elseif ($endy % $this->constheight==0)
      $return[]=$endy;
    else
      $return[]=$endy+($this->constheight-$endy%$this->constheight);

    return $return;
  }

  /** 
   * holt die extremsten ausweitungen einer constellationsmasse anhand der cids
   * 
   * @param $cids 
   * @return 
   */
  function get_coords_by_cids($cids)
  {
    $query="select min(x),max(x),min(y),max(y) from systems where ";

    for ($i=0;$i<sizeof($cids);$i++)
      $query.="cid=".$cids[$i]." or ";

    $query=substr($query,0,-4);

    $sth=mysql_query($query);

    if (!$sth || mysql_num_rows($sth)==0)
      return false;
    else
      return mysql_fetch_row($sth);
  }
}
?>
