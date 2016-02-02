<?php
class portal
{
  var $db;
  var $pages;
  
  function portal($db,$structure_file,$pagename)
  {
    global $__portal_base_dir;
    
    $this->db=$db;
    $this->reader=new structure_reader($structure_file);
    $this->pages=$this->reader->get_pages();

    if (!$this->pages)
      die($this->reader->get_error());
    
    $i=0;
    for ($my_page=$this->pages[0];$my_page && $my_page->get_name()!=$pagename;$my_page=$this->pages[++$i]);
    
    if (!$my_page)
      die("Page not found");

    $smarty=new Smarty;
    $smarty->template_dir=$__portal_base_dir."templates/";
    $smarty->compile_dir =$__portal_base_dir."templates_c/";
    $smarty->config_dir  =$__portal_base_dir."configs/";
    $smarty->cache_dir   =$__portal_base_dir."cache/";
    
    foreach ($this->pages as $page)
    {
      $links[$page->get_name()]="portal.php?page=".$page->get_name()."&SES=".$GLOBALS["ses"]->get_session_id();
      $pagenames[]=$page->get_name();
      $pagetitles[]=$page->get_title() ? $page->get_title() : $page->get_name();
    }
    
    $smarty->assign("is_admin",false);

    if ($GLOBALS["ses"]->get_uid()!==0)
    {
      $sth=$this->db->execute("select name,admin from users where uid=".$GLOBALS["ses"]->get_uid());

      if (!$sth)
	return false;

      list($name,$admin)=$this->db->fetch_row($sth);
      
      $smarty->assign("name",$name);
      if ($admin==1)
      {
	$smarty->assign("is_admin",true);
        $my_page->set_adminmode();
      }
    }
    
    $smarty->assign("this_page",$my_page->get_name());
    $smarty->assign("links",$links);
    $smarty->assign("pages",$pagenames);
    $smarty->assign("pagetitles",$pagetitles);
    $smarty->assign("logged_in",$GLOBALS["ses"]->get_uid()==0 ? false : true);
    $smarty->assign("uid",$GLOBALS["ses"]->get_uid());
    
    $my_page->assign_smarty($smarty);
    $my_page->assign_db($db);
    $my_page->display();
  }
}
?>
