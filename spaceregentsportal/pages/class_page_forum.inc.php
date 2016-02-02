<?php
class page_forum extends base_page
{
  function exec()
  {
    switch ($_GET["act"])
    {
      case "show_forum":
	$this->show_forum($_GET["fid"]);
	break;
      case "new_topic":
	$this->new_topic($_GET["fid"]);
	break;
      case "proc_new_post":
	if (!$errors=$this->check_post($_POST["fid"],$_POST["fpid"],$_POST["subject"],$_POST["content"]))
	  $this->proc_new_post($_POST["fid"],$_POST["fpid"],$_POST["subject"],$_POST["content"],$_POST["puniq"]);
	else
	  $this->new_post($_POST["fid"],$_POST["fpid"],$_POST["subject"],$_POST["content"],$errors);
	break;
      case "show_topic":
	$this->show_topic($_GET["pid"]);
	break;
      case "reply":
	$this->reply($_GET["pid"],$_GET["quote"]);
	break;
      default:
	$this->show_forums();
    }
  }

  function show_forums()
  {
    $sth=$this->db->execute("select f.fid,f.forum from forums f order by f.forum");

    $forums=array();
    $i=0; 
    while ($forum=$this->db->fetch_assoc($sth))
    {
      $sth1=$this->db->execute("select SQL_CALC_FOUND_ROWS p.poster,p.postdate from forum_posts p where p.fid=".$forum["fid"]." order by postdate desc limit 1");

      if (!$sth1)
	return false;

      $post=$this->db->fetch_assoc($sth1);
      $forum=array_merge($post,$forum);

      $sth1=$this->db->execute("select found_rows()");

      if (!$sth1)
	return false;

      list($forum["posts"])=$this->db->fetch_row($sth1);
	
      if ($forum["poster"])
      {
	$sth1=$this->db->execute("select name from users where uid=".$forum["poster"]);

	if (!$sth1)
	  return false;
	elseif ($this->db->num_rows($sth)==0)
	  $forum["poster"]="Deleted user";
	else
	  list($forum["poster"])=$this->db->fetch_row($sth1);
      }
      else
      {
	$forum["poster"]="Nobody";
      }
      $forums[$i]=$forum;
      $i++;
    }
    $this->smarty->assign("forums",$forums);
    $this->smarty->display("content_forum_overview.tpl");
  }

  function show_forum($fid)
  {
    $sth=$this->db->execute("select forum,fid from forums where fid='".$fid."'");
    
    // mop: existiert das fiese forum?
    if (!$sth || $this->db->num_rows($sth)==0)
      return 0;
    
    list($forum,$fid)=$this->db->fetch_row($sth);
    
    $sth=$this->db->execute("select f.topic,u.name,f.postdate,f.pid,count(f2.pid) as replies from forum_posts f,users u left join forum_posts f2 on f.pid=f2.fpid where u.uid=f.poster and f.fid='".$fid."' and f.fpid=0 and f.poster=u.uid group by f.pid order by f.postdate desc limit 50");

    if (!$sth)
      return false;

    while ($post=$this->db->fetch_assoc($sth))
    {
      $posts[]=$post;
    }
    $this->smarty->assign("posts",$posts);
    $this->smarty->assign("forum",$forum);
    $this->smarty->assign("fid",$fid);
    $this->smarty->display("content_forum_show.tpl");
  }

  function new_topic($fid)
  {
    $this->new_post($fid,0,"","");
  }

  function new_post($fid,$fpid,$subject,$content,$errors=false)
  {
    if ($this->uid==0)
      return false;
    if (!$this->check_forum($fid))
      return false;

    if ($errors)
    {
      $this->smarty->assign("errors",$errors);
      // magic quotes plattmachen
      $subject=stripslashes($subject);
      $content=stripslashes($content);
    }
    $this->smarty->assign("fid",$fid);
    $this->smarty->assign("fpid",$fpid);
    $this->smarty->assign("subject",$subject);
    $this->smarty->assign("content",$content);
    // mop: um doppelposts zu verhindern nehmen wir einfach ne sinnlose id
    $this->smarty->assign("puniq",uniqid("sr_"));

    $this->smarty->display("content_forum_new_post.tpl");
  }

  function check_forum($fid)
  {
    $sth=$this->db->execute("select fid from forums where fid='".$fid."'");

    if (!$sth || $this->db->num_rows($sth)==0)
      return false;
    else
      return true;
  }

  function check_post($fid,$fpid,$subject,$content)
  {
    $errors=false;
    if (!$this->check_forum($fid))
      $errors[]="Forum doesn't exist";
    if ($fpid!=0)
    {
      $sth=$this->db->execute("select pid from forum_posts where pid='".$pid."' and fid='".$fid."'");

      if (!$sth || $this->db->num_rows($sth))
	$errors[]="No Post";
    }
    if (empty($subject))
      $errors[]="No subject";
    if (empty($content))
      $errors[]="No Content";

    return $errors;
  }

  function proc_new_post($fid,$fpid,$subject,$content,$puniq)
  {
    if ($this->uid==0)
      return false;

    $puniqs=$GLOBALS["ses"]->get_var("puniqs");

    // mop: uniqid noch nicht da gewesen?
    if (!is_array($puniqs) || !in_array($puniq,$puniqs))
    {
      $sth=$this->db->execute("insert into forum_posts set topic='".$subject."',post='".$content."',poster=".$GLOBALS["ses"]->get_uid().",fid=".$fid.",fpid=".$fpid);

      if (!$sth)
	return false;
      
      $pid=$this->db->last_id();
      
      $puniqs[]=$puniq;
      $GLOBALS["ses"]->reg("puniqs",$puniqs);
      
      if ($fpid!=0)
	$this->smarty->assign("postlink",$GLOBALS["ses"]->wurl($_SERVER["PHP_SELF"]."?page=forum&act=show_topic&pid=".$fpid));
      else
	$this->smarty->assign("postlink",$GLOBALS["ses"]->wurl($_SERVER["PHP_SELF"]."?page=forum&act=show_topic&pid=".$pid));
      $this->smarty->display("content_proc_new_post.tpl");
    }
  }

  function show_topic($pid)
  {
    $sth=$this->db->execute("select f.forum,f.fid from forums f,forum_posts p where p.pid='".$pid."'");

    if (!$sth || $this->db->num_rows($sth)==0)
      return false;

    list($forum,$fid)=$this->db->fetch_row($sth);
    
    $sth=$this->db->execute("select topic,name,postdate,pid,post from forum_posts f,users u where (pid='".$pid."' or fpid='".$pid."') and pid!=0 and f.poster=u.uid order by postdate asc limit 50");

    if (!$sth)
      return false;

    while ($post=$this->db->fetch_assoc($sth))
    {
      $posts[]=$post;
    }
    $this->smarty->assign("pid",$pid);
    $this->smarty->assign("fid",$fid);
    $this->smarty->assign("posts",$posts);
    $this->smarty->assign("forum",$forum);
    $this->smarty->display("content_forum_topic_show.tpl");
  }

  function reply($pid,$quote)
  {
    $sth=$this->db->execute("select topic,post,pid,fid,fpid from forum_posts where pid='".$pid."'");

    if (!$sth || $this->db->num_rows($sth)==0)
      return false;

    list($topic,$post,$pid,$fid,$fpid)=$this->db->fetch_row($sth);

    if ($quote)
    {
      // mop: >'s voranstellen, schon gequotetes ignorieren
      $post=preg_replace("/^> /m","",$post);
      $post=preg_replace("/^/m","> ",$post);
      // mop: bei quotes muss auf die fpid verwiesen werden, sonst geht die zuordnung vor die hunde
      if ($fpid!=0)
        $pid=$fpid;
    }
    else
    {
      // mop: post zurücksetzen....kein quoten
      $topic=$topic;
      $post="";
    }
    $this->new_post($fid,$pid,$topic,$post);
  }
}
?>
