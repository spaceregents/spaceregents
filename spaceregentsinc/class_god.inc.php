<?
/**********
 * runes comment:
 *  ist zwar ne klasse, aber davon mach ich reichlich wenig gebrauch :/
 *  falls irgendwas schiefläuft, der kritischste punkt ist der startpunkt
 *  alle sachen, bis auf die constellation und scanrange einträge werden am schluss in update_database gemacht 
 *  include vector_math.inc.php
 **********/
 
define(CONST_W,1000);       // konstante Breite einer Konstellation
define(CONST_H,1000);       // konstante Höhe einer Konstellation
define(MIN_DIST,150);        // minimale Entfernung zwischen zwei Sternen
define(MAX_DIST,300);        // maximale Entfernung zwischen einem neuen und dem letzten Stern
define(MAX_DIST_FROM_HOMESYSTEM,200);       // maximale Entfernung zwischen einem homesystem und dem letzten Stern
define(MIN_DIST_BETWEEN_HOMESYSTEM, 500);
define(HOMESYSTEMS_PER_CONST, 2);     // Anzahl der home systeme pro const, n(stars) - n(homesystems)*2 > 0 !!

define(PLANET_ROCK,     1);
define(PLANET_ANCIENT,  2);
define(PLANET_ORIGIN,   3);
define(PLANET_EDEN,     4);
define(PLANET_MARS,     5);
define(PLANET_DESERT,   6);
define(PLANET_GASGIANT, 7);
define(PLANET_HEAVYGRAV,8);
define(PLANET_TOXIC,    9);
define(PLANET_ICE,      10);

// NON MEMBERS
function verbose($lvl, $text)
{
  global $v;
  
  if (!$lvl)
    show_error($text);
  elseif ($v >= $lvl)
    echo($text."\n");
}

function print_result($stars)
{
  echo("<svg width=\"1000\" height=\"1000\">\n");
  echo("<rect x=\"0\" y=\"0\" width=\"1000\" height=\"1000\" fill=\"none\" stroke=\"black\"/>");
  foreach($stars as $i => $new_point)
  {
      if ($new_point["homesystem"])
        $fill = "blue";
      else
        $fill = "red";
        
      echo("<text x=\"".$new_point["x"]."\" y=\"".$new_point["y"]."\" fill=\"".$fill."\" stroke=\"none\">".$i."</text>\n");
  }
  echo("</svg>\n");
}

// CLASS GOD BEGIN
class god
{
  function god()
  {
    // ein paar vars setzen. die bei bedarf editieren
    $this->universe=new universe();
/*  $this->universe->max_user_systems_per_const=30; // in prozent
    $this->universe->constwidth=1000;
    $this->universe->constheight=1000;
    $this->universe->systems_per_const_min=10;
    $this->universe->systems_per_const_max=20;*/
    
    $this->startpoint = Array();
    $this->systems    = Array();
  }

  function find_a_neat_home()
  {
    $pid=$this->enough_space();

    if (!$pid)
          $pid = $this->spawn_new_constellation();

    return $pid;
  }

  function enough_space()
  {
  
    $sth = mysql_query("select id from planets where start=1 and uid=0 order by rand() LIMIT 1");
  
    if (!$sth) {
      echo("ERR::GETTING START PLANETS");
      return false;
    }
    
    if (mysql_num_rows($sth) > 0) {
      list($pid) = mysql_fetch_row($sth);
      return $pid;
    }

    // alles gescheitert false zurückgeben
    return false;
  }


 /********************
  * 
  * spawn_new_constellation()
  *******************/
  function spawn_new_constellation()
  {
    verbose(1, "Yeah, lets rock!\n\n");

    mt_srand ((double) microtime() * 1000000);
    $systemcount= mt_rand($this->universe->systems_per_const_min,$this->universe->systems_per_const_max);  
    verbose(1, "- We will create ".$systemcount." systems :)");
    
    $cid          = $this->get_last_constellation();         // gibt -1 zurück wenn keine da ist
    
    if ($cid > 0)
    {
      $new_cid      = $cid+1;
      $direction  = $this->get_direction_to_append($cid);
      $startpoint = $this->get_starting_point($cid, $direction);
      
      if ($startpoint) {
        $constname_id = $this->create_constellation($new_cid);
        $stars      = $this->place_stars($startpoint, $systemcount);
      }
    }
    elseif ($cid == -1)
    {
      $new_cid = 1;
      $startpoint["x"] = 0;
      $startpoint["y"] = 0;
      $startpoint["x_shift"] = 0;
      $startpoint["y_shift"] = 0;
      $constname_id  = $this->create_constellation($new_cid);
      $stars         = $this->place_stars($startpoint, $systemcount);
    }
    else
    {
      verbose(0, "this sucks!");
      return false;
    }
    
    
    if ($stars)
    {
      $new_homeworld = $this->update_database($stars, $new_cid, $constname_id);
      verbose(1, "I'm done! bye m8");
    }
    else
    {
      verbose(0,"There seems to be a problem. Rolling Back");
      
      $sth = mysql_query("DELETE FROM constellations WHERE id=".$new_cid);
      $sth = mysql_query("DROP TABLE __scanranges_".$new_cid);
      return false;
    }
    
    return $new_homeworld;
  }
  


 /********************
  * 
  * create_constellation($new_cid)
  *******************/
  function create_constellation($new_cid)
  {
    verbose(2, "ENTERING function create_constellation($new_cid)");
    
    // constellation
    $const = $this->create_const_name($new_cid);
    list($const_name,$constname_id) = $const;
    
    $sth=mysql_query("insert into constellations (id, name) values ('".$new_cid."','".addslashes($const_name)."')");
    
    if (!$sth)
    {
      verbose(0,"Could not insert new constellation into DB");
      return false;
    }

    $this->create_scanranges($new_cid);
    
    verbose(2, "- new_cid is ".$new_cid);
    verbose(2, "- constname_id is ".$constname_id);
    return $constname_id;
  }
  
  
 /********************
  * 
  * update_database($stars, $cid)
  *******************/
  function update_database($stars, $cid, $constname_id)
  {
    verbose(2,"ENTERING function update_database\n");
    verbose(2,"- cid is ".$cid);
    // von 1 an, das der stern im index 0 zu der alten const gehört
    // von dem startpunkt nehmen shift_x und shift_y und addieren das zu system x und y
    
    $x_shift = $stars[0]["x_shift"];
    $y_shift = $stars[0]["y_shift"];

    // gnarz, wenn x_shift oder y_shift < 0 ist, müssen wir alle systeme so verschieben dass es > 0 ist ...
    if ($x_shift < 0)
    {
      verbose(1,"-- Shifting x from all systems by ".$x_shift);
      $sth = mysql_query("UPDATE systems SET x = x - ".$x_shift);
      
      if (!$sth)
        return false;
        
      $x_shift = 0;
    }
    
    if ($y_shift < 0)
    {
      verbose(1,"-- Shifting y from all systems by ".$y_shift);
      $sth = mysql_query("UPDATE systems SET y = y - ".$y_shift);
      
      if (!$sth)
        return false;
        
      $y_shift = 0;
    }
      
    verbose(2,"- x_shift is ".$x_shift);
    verbose(2,"- y_shift is ".$y_shift);
    for ($i = 1; $i < sizeof($stars); $i++)
    {
      verbose(2,"---------------------------------");
      $stars[$i]["x"] += $x_shift;
      $stars[$i]["y"] += $y_shift;
      
      // noch schnell den namen ermitteln
      $sth=mysql_query("select concat(g.name,' ',c.genetiv) from constellationnames c,greek_abc g left join systems s on concat(g.name,' ',c.genetiv)=s.name where s.name is null and c.id=".$constname_id." order by rand() limit 1");

      if (!$sth)
        echo("dsjfhsdkfj");

      // FIXME - keine namen mehr frei :S 
      if (mysql_num_rows($sth)==0)
        $stars[$i]["name"] = uniqid("STAR");
      else
        list($stars[$i]["name"])=mysql_fetch_row($sth);
      
      // system
      $sth = mysql_query("INSERT INTO systems (x, y, type, cid, name) values ('".$stars[$i]["x"]."','".$stars[$i]["y"]."','".$stars[$i]["type"]."','".$cid."','".addslashes($stars[$i]["name"])."')");
      
      if (!$sth)
        verbose(0, "THERE WAS AN DB ERROR! COULD NOT INSERT NEW SYSTEM!");
      else
      {
        verbose(2,"- Adding system No ".$i." to DB at x=".$stars[$i]["x"].", y=".$stars[$i]["y"]." and type=".$stars[$i]["type"]);
        verbose(2,"- Its name is ".$stars[$i]["name"]);
      }
        
      $sid = mysql_insert_id();      
      verbose(1,"- New SID is ".$sid);
      
      // planeten zum system
      verbose(2,"- Going to add some planets");
      
      if (is_array($stars[$i]["planets"]))
      foreach($stars[$i]["planets"] as $pos => $planet)
      {
        $start_planet = 0;
        switch ($planet["class"])
        {
          case PLANET_ROCK:
            $pType = "R";
          break;
          case PLANET_ANCIENT:
            $pType = "A";
          break;
          case PLANET_ORIGIN:
            $pType = "O";           
            if ($stars[$i]["homesystem"])
            {
              $start_planet = 1;
              verbose(2,"- we have a new homeplanet");
            }
          break;
          case PLANET_MARS:
            $pType = "M";
          break;
          case PLANET_DESERT:
            $pType = "D";
          break;
          case PLANET_GASGIANT:
            $pType = "G";
          break;
          case PLANET_HEAVYGRAV:
            $pType = "H";
          break;
          case PLANET_TOXIC:
            $pType = "T";
          break;
          case PLANET_EDEN:
            $pType = "E";
          break;
          case PLANET_ICE:
            $pType = "I";
          break;
        }
        $sth = mysql_query("INSERT INTO planets (x, sid, metal, energy, mopgas, erkunum, gortium, susebloom, start, type)
                            VALUES (".($pos+1).",".$sid.",".$planet["res"]["metal"].",".$planet["res"]["energy"].",".$planet["res"]["mopgas"].",
                                    ".$planet["res"]["erkunum"].",".$planet["res"]["gortium"].",".$planet["res"]["susebloom"].",".$start_planet.",
                                    '".$pType."')");
                                    
        if (!$sth)
        {
          verbose(0, "DAMNIT!, Could not insert new Planet!!!!");
        }
        else
          verbose(2,"- added planet No ".$pos." as type ".$pType);

        // homeworld speichern und zurückgeben          
        if ($start_planet == 1)                     
          $new_homeworld = mysql_insert_id();
      }
    }
    
    verbose(1, "New homeworld is ".$new_homeworld);
    return $new_homeworld;
  }

  
  /******************************
   * get_last_constellations()
   * 
   * return: int; id der letzten constellationen
   *
   ******************************/
  function get_last_constellation()
  {
    verbose(2,"ENTERING function get_last_constellations().");

    $sth = mysql_query("select IFNULL(max(id),-1) from constellations");

    if (!$sth)
    {
      verbose(0,"Ooops, DB macht Stress!");
      return false;
    }

    if (mysql_num_rows($sth) > 0)
    {
      list($max_const_id) = mysql_fetch_row($sth);
      
      if ($max_const_id > 0)
        verbose(1, "- found last constellation id ->".$max_const_id);
      else
        verbose(1, "- creating intial constellation");        
    }
    else
      return false;
      
    return $max_const_id;
  }


 /********************
  * 
  * create_scanranges($cid)
  *******************/
  function create_scanranges($cid)
  {
    verbose(2, "ENTERING function create_scanranges($cid)");
    $sth=mysql_query("CREATE TABLE __scanranges_".$cid." 
                        (sid int(11) NOT NULL default '0',
                         uid int(11) NOT NULL default '0',
                         type tinyint(1) NOT NULL default '0',
                         range int(11) default NULL,
                         last_update int(11) default NULL,
                         PRIMARY KEY  (sid,uid,type))
                        TYPE=MyISAM;");                        
  }


 /********************
  * 
  * check_distance($stars, $new_point, $is_homesystem)
  *******************/
  function check_distance($stars, $new_point, $is_homesystem)
  {
    $check = true;

    // wir überprüfen hier die entfernung zu JEDEM stern
    for ($i = 0; $i < sizeof($stars) && $check == true; $i++)
    {
      $dist_check   = MIN_DIST;
      $its_distance = vector_get_norm($stars[$i]["x"], $stars[$i]["y"], $new_point["x"], $new_point["y"]);

      // wenn beide ein homesystem dürfen sie nicht zu nah aneinander liegen
      if ($stars[$i]["homesystem"] && $is_homesystem)
        $dist_check = MIN_DIST_BETWEEN_HOMESYSTEM;
  
      // sind die sterne zu nah aneinander?
      if ($its_distance < $dist_check)
        $check = false;     
    }

    // in unmittelbarer nähe zu einem Homesystem muss ein system sein, dass mit dem default warp zu erreichen sein muss
    if ($is_homesystem && $its_distance > MAX_DIST_FROM_HOMESYSTEM)
      $check = false;

    return $check;
  }



 /********************
  * 
  * create_system_planets($is_homesystem)
  *******************/
  function create_system_planets($is_homesystem)
  {
    verbose(2,"ENTERING function create_system_planets(".$is_homesystem.")");
    $planets = Array();
    // ein homesystem ist fix für jedermann
    if ($is_homesystem)
    {
      verbose(2,"creating homesystem planets");
      $planets[] = PLANET_ROCK;      
      $planets[] = PLANET_HEAVYGRAV;      
      $planets[] = PLANET_GASGIANT;      
      $planets[] = PLANET_MARS;      
      $planets[] = PLANET_ORIGIN;      
      $planets[] = PLANET_DESERT;      
      $planets[] = PLANET_ROCK;      
    }
    else
    {
      mt_srand ((double) microtime() * 1000000);

      // anzahl planeten
      $random = mt_rand(0,6);
      verbose(2,"creating ".$random." random planets");
      for ($j = 0; $j < $random; $j++)
      {
        // die planeten classen sind hier als nummern angegeben, damit man sie später sortieren kann
        // um es so ein wenig realistischer machen
        $random_class = mt_rand(1,101);
        if ($random_class==1)
          $planets[$j] = PLANET_EDEN;
        if (($random_class>1) and ($random_class<=11))
          $planets[$j] = PLANET_ORIGIN;
        if (($random_class>11) and ($random_class<=28))
          $planets[$j] = PLANET_MARS;
        if (($random_class>27) and ($random_class<=35))
          $planets[$j] = PLANET_TOXIC;
        if (($random_class>35) and ($random_class<=53))
          $planets[$j] = PLANET_DESERT;
        if (($random_class>53) and ($random_class<=61))
          $planets[$j] = PLANET_ICE;
        if (($random_class>61) and ($random_class<=67))
          $planets[$j] = PLANET_GASGIANT;;
        if (($random_class>67) and ($random_class<=75))
          $planets[$j] = PLANET_ANCIENT;
        if (($random_class>75) and ($random_class<=95))
          $planets[$j] = PLANET_HEAVYGRAV;
        if (($random_class>95))
          $planets[$j] = PLANET_ROCK;

        verbose(2,"creating planet class: ".$planets[$j]);
      }
    }

    sort($planets);
    return $planets;
  }


 /********************
  * 
  * place_stars($startpoint, $num_stars)
  *******************/
  function place_stars($startpoint, $num_stars, $try = 0)
  {
    verbose(2,"ENTERING place_stars(".$startpoint["x"].":".$startpoint["y"].",  ".$num_stars.").");
    $max_while = $num_stars * 50;
    $i = $j = 0;  
    $k = 0;

    $stars[0] = $startpoint;
    mt_srand((double)microtime()*1000000);

    // wähle ein system welches ein homesystem wird, nicht 0, da 0 nicht zur const gehört
    // teile die anzahl der sterne durch die homesysteme;
    if (HOMESYSTEMS_PER_CONST > 0)
      $star_range_per_homesystem = floor($num_stars / HOMESYSTEMS_PER_CONST);
    else
      $star_range_per_homesystem = $num_stars / 1;

    for ($m = 0;$m < HOMESYSTEMS_PER_CONST; $m++)
    {
      $homesystems[$m] = mt_rand(1, $star_range_per_homesystem - 1);
      $homesystems[$m] += $m * $star_range_per_homesystem;
    }

    while ($i < $num_stars && $j <= $max_while) 
    {
      // wähle eine zufällige richtung 0-359°
      $angle     = mt_rand(0, 359);
      $new_point = vector_get_point_by_angle($angle);

      // wähle eine zufällige entfernung, beim homesystem begrenze die entfernung.
      if (in_array($i,$homesystems)) {
        $new_point["homesystem"] = 1;
        $distance = rand(MIN_DIST, MAX_DIST_FROM_HOMESYSTEM);    
      }
      else
        $distance = rand(MIN_DIST, MAX_DIST);        

      // gehe vom letzten stern, im winkel von 'angle' über eine entfernung von 'distance'    
      $new_point["x"] = round($new_point["x"] * $distance) + $stars[$i]["x"];
      $new_point["y"] = round($new_point["y"] * $distance) + $stars[$i]["y"];

      // check ob der neue stern nicht ausserhalb der const liegt und in gültger entfernung zu allen anderes sternen ist
      if ($new_point["x"] > 0 && $new_point["y"] > 0 && $new_point["x"] < CONST_W && $new_point["y"] < CONST_H && $this->check_distance($stars, $new_point,$new_point["homesystem"]))
      {
        // die neue sternen position erfüllt alle vorraussetzungen
        // erstelle die planeten
        $new_planets = $this->create_system_planets($new_point["homesystem"]);
        
        // hole dir resourcen zu jedem planet
        if (is_array($new_planets))
        foreach ($new_planets as $pos => $planet_class)
        {
          $new_star["planets"][$pos]["class"]  = $planet_class;
          $new_star["planets"][$pos]["res"]    = $this->get_resources($planet_class, $new_point["homesystem"]);
        }
       
        $new_star["x"] = $new_point["x"];
        $new_star["y"] = $new_point["y"];
        $new_star["homesystem"] = $new_point["homesystem"];
        
        // sternen typ
        $new_star["type"] = mt_rand(1,4);
                
        $stars[++$i] = $new_star;
        verbose(1,"- placing star number ".$i." at ".$new_point["x"].":".$new_point["y"]."\n");
      }
      $j++;
    }

    if ($j >= $max_while && $k < $max_while)
    {      
      verbose(1, "Max while loop exeeded, trying new round");
      unset($stars);
      $k++;
      $stars = $this->place_stars($startpoint, $num_stars, $k);
    }
    elseif ($k >= $max_while)
    {
      verbose(0,"I apologize. I wasn't able to create a new constellation...damnit");
    }
    else
    {  
      verbose(2,"LEAVING place_stars(...).");
      //print_result($stars);
    }
    
    return $stars;
  }
  
  
 /********************
  * 
  * get_starting_point($cid, $direction)
  *******************/
  function get_starting_point($cid, $direction)
  {
    verbose(2,"ENTERING get_starting_point(".$cid.", ".$direction.")");
    $verschieb_x = 0;   // diese vars speichern in welche richtung der startpunkt verschoben werden muss, wenn die
    $verschieb_y = 0;   // nächste const oben angebracht wird, nehmen wir den obersten aus der letzten const und verschieben in in der neuen const nach unten
    
    switch ($direction)
    {
      case "HOCH":     // hol sterne am oberen rand der const
        $sth = mysql_query("select x, y from systems where cid=".$cid." order by y limit 1");
      break;
      case "RUNTER":   // hol sterne am unteren rand der const
        $sth = mysql_query("select x, y from systems where cid=".$cid." order by y DESC limit 1");
      break;
      case "LINKS":    // hol sterne am linken rand der const
        $sth = mysql_query("select x, y from systems where cid=".$cid." order by x limit 1");
      break;
      case "RECHTS":   // hol sterne am rechten rand der const
        $sth = mysql_query("select x, y from systems where cid=".$cid." order by x DESC limit 1");      
      break;
    }

    if (!$sth || (!mysql_num_rows($sth)))
    {
      verbose(0,"Boese DB!");
      return false;
    }

    list($startpoint["x"], $startpoint["y"]) = mysql_fetch_row($sth);
    
    switch ($direction)
    {
      case "HOCH":
        $startpoint["x_shift"] = CONST_W * floor($startpoint["x"] / CONST_W);       //x_shift, y_shift: die sterne müssen noch die relative richtige position gebracht werden

        if ($startpoint["y"] >= 0)        
          $startpoint["y_shift"] = CONST_H * (floor($startpoint["y"] / CONST_H)-1);
        else
          $startpoint["y_shift"] = CONST_H * (floor($startpoint["y"] / CONST_H));
          
        $verschieb_y = CONST_H;
      break;
      case "RUNTER":
        $startpoint["x_shift"] = CONST_W * floor($startpoint["x"] / CONST_W);
        $startpoint["y_shift"] = CONST_H * ceil($startpoint["y"] / CONST_H);
        $verschieb_y = - CONST_H;
      break;
      case "LINKS":
        if ($startpoint["x"] >= 0)
          $startpoint["x_shift"] = CONST_W * (floor($startpoint["x"] / CONST_W)-1);
        else
          $startpoint["x_shift"] = CONST_W * floor($startpoint["x"] / CONST_W);

        $startpoint["y_shift"] = CONST_H * floor($startpoint["y"] / CONST_H);
        $verschieb_x = CONST_W;
      break;
      case "RECHTS":
        $startpoint["x_shift"] = CONST_W * ceil($startpoint["x"] / CONST_W);
        $startpoint["y_shift"] = CONST_H * floor($startpoint["y"] / CONST_H);
        $verschieb_x = -CONST_W;
      break;
    }
    
    // bring den startpunkt in eine position zwischen 0 und CONST_W bzw. CONST_H
    if ($startpoint["x"] > CONST_W)
      $startpoint["x"] = $startpoint["x"] % CONST_W;

    if ($startpoint["y"] > CONST_H)
      $startpoint["y"] = $startpoint["y"] % CONST_H;    
      

    // Noch ein check ob der startpunkt vielleicht nicht vieeeel zu weit von der grenze weg ist (hier > MAX_DIST / 2)
    $max_dist_from_border = MAX_DIST / 2;
    switch ($direction)
    {
      case "HOCH":
        if ($startpoint["y"] > $max_dist_from_border)
          $startpoint["y"] = $max_dist_from_border;
      break;
      case "RUNTER":
        if (CONST_H - $startpoint["y"] > $max_dist_from_border)
          $startpoint["y"] = CONST_H - $max_dist_from_border;
      break;
      case "LINKS":
        if ($startpoint["x"] > $max_dist_from_border)
          $startpoint["x"] = $max_dist_from_border;
      break;
      case "RECHTS":
        if (CONST_W - $startpoint["x"] > $max_dist_from_border)
          $startpoint["x"] = CONST_W - $max_dist_from_border;
      break;
    }
      
    // schnell auf die richtige seite verschieben
    $startpoint["x"] += $verschieb_x;
    $startpoint["y"] += $verschieb_y;

    return $startpoint;
  }

 /********************
  * 
  * get_unique_system_name()
  *******************/
  function get_unique_system_name()
  {
    $sth=mysql_query("select concat(g.name,' ',c.genetiv) from constellationnames c,greek_abc g left join systems s on concat(g.name,' ',c.genetiv)=s.name where s.name is null and c.id=$constname_id order by rand() limit 1");

    if (!$sth)
      echo("dsjfhsdkfj");

    // FIXME - keine namen mehr frei :S
    if (mysql_num_rows($sth)==0)
      $name=uniqid("STAR");
    else
      list($name)=mysql_fetch_row($sth);
      
    return $name;
  }


 /********************
  * 
  * get_direction_to_append($cid)
  *******************/
  function get_direction_to_append($cid)
  {
    verbose(2,"ENTERING function get_direction_to_append().");
    verbose(2,"-- cid is ".$cid);  

    $circle_lvl           = 1;
    $max_const_per_level  = 4;

    if ($cid > 4)
    {
      while ($max_const_per_level < $cid)
      {
        $circle_lvl += 2;
        $max_const_per_level += ($circle_lvl * 4);
      }

      $max_const_from_previous_level = $max_const_per_level - ($circle_lvl * 4);
    }
    else  
      $max_const_from_previous_level = 0;

    $direction = ($cid - $max_const_from_previous_level) / $circle_lvl;

    verbose(2,"-- circle_lvl is ".$circle_lvl);
    verbose(2,"-- max_const_from_previous_level is ".$max_const_from_previous_level);
    verbose(2,"-- direction is ".$direction);

    if ($direction < 1)
    {
      verbose(1, "-- new constellation will be appended ABOVE\n");
      return "HOCH";
    }
    elseif ($direction < 2)
    {
      verbose(1, "-- new constellation will be appended RIGHT\n");
      return "RECHTS";
    }
    elseif ($direction < 3)
    {
      verbose(1, "-- new constellation will be appended BELOW\n");
      return "RUNTER";
    }
    else
    {
      verbose(1, "-- new constellation will be appended LEFT\n");
      return "LINKS";
    }
  }
  
  

 /********************
  * 
  * create_new_constellation($startx,$endx,$starty,$endy)
  *******************/
  function create_new_constellation($startx,$endx,$starty,$endy)
  {
    $const=$this->create_const_name();

    list($name,$constname_id)=$const;

    $sth=mysql_query("insert into constellations (name) values ('".addslashes($name)."')");

    if (!$sth)
    {
      echo("Database failure!2");
    }


    $this->create_systems($startx,$endx,$starty,$endy,$cid,$constname_id);

    return $cid;
  }


 /********************
  * 
  * create_planets($sid)
  *******************/
  function create_planets($sid)
  {
      mysql_query("insert into planets (x,sid,metal,energy,mopgas,erkunum,gortium,susebloom,type) values ('$j','$sid','".$res["metal"]."','".$res["energy"]."','".$res["mopgas"]."','".$res["erkunum"]."','".$res["gortium"]."','".$res["susebloom"]."','".$class."')");
  }


 /********************
  * 
  * get_resources($planetType, $is_homesystem = false)
  *******************/
  function get_resources($planetType, $is_homesystem = false)
  {
    mt_srand ((double) microtime() * 1000000);    
    switch ($planetType)
    {
      case PLANET_EDEN:
          $res["metal"]=mt_rand(110,170);
          $res["energy"]=mt_rand(110,170);
          $res["mopgas"]=0;
          $res["erkunum"]=0;
          $res["gortium"]=0;
          $res["susebloom"]=mt_rand(70,130);
          break;
      case PLANET_ORIGIN:
          if ($is_homesystem)
          {
            $res["metal"] = 100;
            $res["energy"]= 100;
          }
          else
          {
            $res["metal"]   = mt_rand(70,130);
            $res["energy"]  = mt_rand(70,130);
          }
          $res["mopgas"]    = 0;
          $res["erkunum"]   = 0;
          $res["gortium"]   = 0;
          $res["susebloom"] = 0;
          break;
      case PLANET_MARS:
          if ($is_homesystem)
            $res["metal"] = 60;
          else
            $res["metal"] = mt_rand(50,100);

          $res["energy"]    =0;
          $res["mopgas"]    =0;
          $res["erkunum"]   =0;
          $res["gortium"]   =0;
          $res["susebloom"] =0;
          break;
      case PLANET_TOXIC:
          $res["metal"]     =0;
          $res["energy"]    =0;
          $res["mopgas"]    =mt_rand(110,170);
          $res["erkunum"]   =0;
          $res["gortium"]   =0;
          $res["susebloom"] =0;
          break;
      case PLANET_DESERT:
          $res["metal"]=0;

          if ($is_homesystem)
            $res["energy"] = 130;
          else
            $res["energy"]=mt_rand(110,170);
          $res["mopgas"]=0;
          $res["erkunum"]=0;
          $res["gortium"]=0;
          $res["susebloom"]=0;
          break;
      case PLANET_ICE:
          $res["metal"]=0;
          $res["energy"]=0;
          $res["mopgas"]=0;
          $res["erkunum"]=mt_rand(110,160);
          $res["gortium"]=0;
          $res["susebloom"]=0;
          break;
      case PLANET_GASGIANT:
          $res["metal"]=0;
          $res["energy"]=mt_rand(70,130);
          $res["mopgas"]=0;
          $res["erkunum"]=0;
          $res["gortium"]=0;
          $res["susebloom"]=0;
          break;
      case PLANET_ANCIENT:
          $res["metal"]=0;
          $res["energy"]=mt_rand(20,80);
          $res["mopgas"]=0;
          $res["erkunum"]=0;
          $res["gortium"]=mt_rand(110,150);
          $res["susebloom"]=0;
          break;
      case PLANET_ROCK:
          if ($is_homesystem)
            $res["metal"] = 90;
          else
            $res["metal"]=mt_rand(90,150);            
          $res["energy"]=0;
          $res["mopgas"]=0;
          $res["erkunum"]=0;
          $res["gortium"]=0;
          $res["susebloom"]=0;
          break;
      case PLANET_HEAVYGRAV:
          $res["metal"]=0;
          $res["energy"]=mt_rand(150,210);
          $res["mopgas"]=0;
          $res["erkunum"]=0;
          $res["gortium"]=0;
          $res["susebloom"]=0;
          break;
    }

    return $res;
  }


 /********************
  * 
  * create_const_name()
  *******************/
  function create_const_name()
  {
    $sth=mysql_query("select cn.name,cn.id from constellationnames cn left join constellations c on c.name=cn.name where c.name is null order by rand() limit 1");

    return mysql_fetch_row($sth);
  }
}
?>