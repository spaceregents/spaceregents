<?php
class structure_reader
{
  var $document;
  var $pages;
  
  function structure_reader($structure_file)
  {
    $dom=domxml_open_file($structure_file);
    if (!$dom)
    {
      $this->error="STRUCTURE ERROR";
      return false;
    }
    
    $this->document=$dom->first_child();
    $element=$this->document->first_child();

    $i=0;
    
    while ($element)
    {
      if ($element->node_name()=="page")
      {
	$this->pages[$i]=new page($element->get_attribute("name"));
	if ($element->get_attribute("title"))
	  $this->pages[$i]->set_title($element->get_attribute("title"));
	$i++;
      }
      $element=$element->next_sibling();
    }
  }

  function get_error()
  {
    return $this->error;
  }

  function get_pages()
  {
    return $this->pages;
  }
}
?>
