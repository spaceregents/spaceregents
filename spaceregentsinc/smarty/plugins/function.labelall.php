<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     eval
 * Purpose:  evaluate a template variable as a template
 * -------------------------------------------------------------
 */
function smarty_function_labelall($params, &$this)
{
    extract($params);

    if (empty($var)) {
        $this->trigger_error("assign: missing 'var' parameter");
        return;
    }
  
    if (empty($label)) {
        $this->trigger_error("assign: missing 'label' parameter");
        return;
    }    
    

  	foreach ($label as $k => $v)
    {
			if($k == $var)
    		echo "<b>".$label[$k]."</b>".$seperator;
			else
				echo $label[$k].$seperator;
		}

}

/* vim: set expandtab: */

?>
