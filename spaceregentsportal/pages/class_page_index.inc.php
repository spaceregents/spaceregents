<?php
class page_index extends base_page
{
  function exec()
  {
    switch ($_REQUEST["act"])
    {
      case "proc_new_news":
	$this->proc_new_news($_POST["title"],$_POST["body"]);
	$this->show_news();
	break;
      case "delete_news":
	$this->delete_news($_GET["nid"]);
	$this->show_news();
	break;
      default:
	if ($_GET["pagenum"])
	  $this->show_news($_GET["pagenum"]);
	else
	  $this->show_news();
    }
  }

  function proc_new_news($title,$body)
  {
    if ($this->adminmode())
      $sth=$this->db->execute("insert into news set title='".$_POST["title"]."',body='".$_POST["body"]."',uid=".$GLOBALS["ses"]->get_uid().",date=now()");
  }

  function delete_news($nid)
  {
    if ($this->adminmode())
      $sth=$this->db->execute("delete from news where nid=".$nid);
  }

  function show_news($pagenum=1)
  {
    $limit=5;
    
    $sth=$this->db->execute("select SQL_CALC_FOUND_ROWS n.title,n.body,n.date,u.name,n.nid from news n,users u where u.uid=n.uid order by n.date desc limit ".(($pagenum-1)*$limit).",".$limit);

    if (!$sth)
    {
      $this->smarty->assign("critical_error","ERR::GETTING_NEWS");
      return false;
    }
    
    $news=array();
    
    while ($newsrow=$this->db->fetch_assoc($sth))
    {
      $news[]=$newsrow;
    }

    $sth=$this->db->execute("select FOUND_ROWS()");

    if (!$sth)
      return false;

    list($found_rows)=$this->db->fetch_row($sth);
    
    // mop: immer mindestens eine seite....also abrunden und eins drauf
    $num_pages=floor($found_rows/10)+1;
    
    // mop: gibt keine simple for schleife in smarty also array machen
    for ($i=1;$i<=$num_pages;$i++)
    {
      $pages[]=$i;
    }
    
    $this->smarty->assign("news",$news);
    $this->smarty->assign("news_pages",$pages);
    $this->smarty->assign("cur_pagenum",$pagenum);
    $this->smarty->display("content_index.tpl");
  }
}
?>
