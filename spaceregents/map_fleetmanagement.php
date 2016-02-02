<?php
include "../spaceregentsinc/init.inc.php";
include "../spaceregentsinc/fleet.inc.php";
include "../spaceregentsinc/production.inc.php";
include "../spaceregentsinc/class_fleet.inc.php";

function transfer($target,$request)
{
  global $uid;

  $doc=domxml_new_doc("1.0");
  $rootElem=$doc->create_element("SR_REQUEST");

  $trans=parse_fleetlist($request);

  $trans_fleet=new fleet($target);
  $trans_elem=$doc->create_element("SR_FLEET");
  $trans_elem->set_attribute("fid",$target);

  $sid=$trans_fleet->sid;
  $pid=$trans_fleet->pid;

  $fleets=array();
  $new_inf=array();
  $i=0;
  foreach ($trans as $fid => $data)
  {
    $fleet_elem=$doc->create_element("SR_FLEET");
    $fleet_elem->set_attribute("fid",$fid);
    $fleets[$i]=new fleet($fid);
    if ($fleets[$i]->uid!=$uid)
    {
      return false;
    }

    // mop: sofort raus hier, falls da irgendwas nicht stimmt
    if ($fleets[$i]->sid!=$sid || $fleets[$i]->pid!=$pid)
    {
      return false;
    }

    $infantery=get_fleet_infantery($fid);
    $tmp_new_inf=transfer_ships($fleets[$i],$trans_fleet,$doc,$fleet_elem,$trans_elem,$infantery,$data);
    foreach ($tmp_new_inf as $prod_id => $count)
      $new_inf[$prod_id]+=$count;

    $rootElem->append_child($fleet_elem);
    $i++; // flottenschleife
  }
  $rootElem->append_child($trans_elem);
  $trans_fleet->update_all_prod_ids();

  for ($i=0;$i<sizeof($fleets);$i++)
  {
    $fleets[$i]->update_all_prod_ids();
  }  

  add_infantery($trans_fleet->fid,$new_inf);
  delete_empty_fleets();

  $sth=mysql_query("delete from inf_transports where count=0");

  if (!$sth)
    return 0;

  $doc->append_child($rootElem);
  echo($doc->dump_mem());
}

function transfer_ships(&$source,&$target,&$doc,&$source_elem,&$target_elem,&$infantery,$data)
{
  $new_inf=array();
  $fid=$source->fid;
  foreach ($data as $prod_id => $count)
  {
    if (($source->ships[$prod_id]) && ($source->ships[$prod_id][0]>=$count) && ((int) $count>0))
    {
      $source->ships[$prod_id][0]-=$count;
      $target->add_ships_arr(array($prod_id=>array($count,$source->ships[$prod_id][1])));
      $shipname=get_name_by_prod_id($prod_id);

      $ship_elem=$doc->create_element("SR_SHIP");
      $ship_elem->set_attribute("prod_id",$prod_id);
      $ship_elem->set_attribute("count",$source->ships[$prod_id][0]);
      $ship_elem->set_attribute("reload",$source->ships[$prod_id][1]);
      $ship_elem->set_attribute("name",$shipname);
      $tship_elem=$doc->create_element("SR_SHIP");
      $tship_elem->set_attribute("prod_id",$prod_id);
      $tship_elem->set_attribute("count",$target->ships[$prod_id][0]);
      $tship_elem->set_attribute("reload",$target->ships[$prod_id][1]);
      $tship_elem->set_attribute("name",$shipname);

      $source_elem->append_child($ship_elem);
      $target_elem->append_child($tship_elem);

      if ($infantery>0)
      {
        $sth=mysql_query("select i.storage*".$count." from fleet as f , inf_transporters as i where i.prod_id=f.prod_id and f.prod_id=".$prod_id." and f.prod_id=".$prod_id." and f.fid=".$fid);

        $trans_storage=mysql_fetch_row($sth);

        $j=0;

        if ($trans_storage[0]>0)
        {
          while (($infantery>0) and ($trans_storage[0]>0))
          {
            $sth=mysql_query("select if(i.tonnage*it.count>".$trans_storage[0].",floor(".$trans_storage[0]."/i.tonnage),it.count),it.prod_id,it.count,i.tonnage AS storage from inf_transports as it, shipvalues as i, production as p where p.prod_id=i.prod_id and p.typ='I' and i.prod_id=it.prod_id and it.fid=".$fid." limit ".$j.",".($j+1));

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

            $sth=mysql_query("update inf_transports set count=count-".$new[0]." where fid=".$fid." and prod_id=".$new[1]);

            if (!$sth)
              return 0;
          }
        }
      }
    }
  }
  return $new_inf;
}

function parse_fleetlist($request)
{
  $trans=array();
  // mop: die flottenid schnappen und den transferpart
  if (preg_match_all("/(\d+)\((.*)\)/U",$request,$matches))
  {
    for ($i=0;$i<sizeof($matches[0]);$i++)
    {
      // mop: jeden transferpart nehmen und den prod_id-count teil schnappen
      if (preg_match_all("/(\d+)\-(\d+),?/",$matches[2][$i],$matches_2))
      {
        for($j=0;$j<sizeof($matches_2[0]);$j++)
        {
          // mop: und in array packen ===> array("fid"=>array("prod_id"=>"count"))
          $trans[$matches[1][$i]][$matches_2[1][$j]]=$matches_2[2][$j];
        }
      }
    }
  }
  return $trans;
}

function get_fleet_infantery($fid)
{
  $sth=mysql_query("select sum(iv.tonnage*i.count) from inf_transports as i, shipvalues as iv where iv.prod_id=i.prod_id and i.fid=".$fid);

  if (!$sth)
    return 0;

  if (mysql_num_rows($sth)>0)
    list($infantery)=mysql_fetch_row($sth);
  else
    $infantery=0;

  return $infantery;
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

function create($request)
{
  global $uid;

  $doc=domxml_new_doc("1.0");
  $rootElem=$doc->create_element("SR_REQUEST");

  $create_arr=parse_fleetlist($request);
  $new_inf=array();

  $i=0;
  $fleets=array();
  $new_fleet=new fleet();
  $new_elem=$doc->create_element("SR_FLEET");

  foreach ($create_arr as $fid => $data)
  {
    $fleet_elem=$doc->create_element("SR_FLEET");
    $fleet_elem->set_attribute("fid",$fid);

    $fleets[$i]=new fleet($fid);

    if ($i==0)
    {
      $new_fleet->pid=$fleets[$i]->pid;
      $new_fleet->sid=$fleets[$i]->sid;
      $new_fleet->mission=$fleets[$i]->mission;
      $new_fleet->tpid=$fleets[$i]->tpid;
      $new_fleet->tsid=$fleets[$i]->tpid;
      $new_fleet->milminister=$fleets[$i]->milminister;
      $new_fleet->uid=$fleets[$i]->uid;
      $pid=$fleets[$i]->pid;
      $sid=$fleets[$i]->sid;
    }

    if ($fleets[$i]->pid!=$pid || $fleets[$i]->sid!=$sid || $fleets[$i]->uid!=$uid)
      return false;

    $infantery=get_fleet_infantery($fid);
    $tmp_new_inf=transfer_ships($fleets[$i],$new_fleet,$doc,$fleet_elem,$new_elem,$infantery,$data);
    foreach ($tmp_new_inf as $prod_id => $count)
      $new_inf[$prod_id]+=$count;

    $rootElem->append_child($fleet_elem);
    $i++;
  }

  if (!$new_fleet->create_fleet())
  {
    echo "Please select some ships";
    return false;
  }

  $new_elem->set_attribute("fid",$new_fleet->fid);
  //$rootElem->append_child($new_elem);

  for ($i=0;$i<sizeof($fleets);$i++)
    $fleets[$i]->update_all_prod_ids();

  add_infantery($new_fleet->fid,$new_inf);
  delete_empty_fleets();

  $sth=mysql_query("delete from inf_transports where count=0");

  if (!$sth)
    return 0;

  $doc->append_child($rootElem);

  // mop: route muss dupliziert werden, sonst ist alles kaputt
  $sth=mysql_query("replace into routes (fid,route) select ".$new_fleet->fid.",route from routes where fid=".$fleets[0]->fid);

  if (!$sth)
    return false;

  echo($doc->dump_mem());
}

function rename_fleet($fid,$new)
{
  global $uid;

  $sth=mysql_query("update fleet_info set name='".$new."' where fid='".$fid."' and uid=".$uid);

  echo("Fleetname successfully changed.");
}

switch($_GET["act"])
{
  case "create":
    create($_GET["request"]);
  break;
  case "transfer":
    transfer($_GET["target"],$_GET["request"]);
  break;
  case "rename":
    rename_fleet($_GET["fid"],$_GET["new"]);
  break;
}
$content=ob_get_contents();
ob_end_clean();

print gzcompress($content);
?>
