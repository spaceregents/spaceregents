<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     eval
 * Purpose:  evaluate a template variable as a template
 * -------------------------------------------------------------
 */
function smarty_function_label($params, &$this)
{
    extract($params);
/*
 * Verursacht 'Fehler' wenn der var-parameter auf num. 0 steht 
 * 
   if (empty($var)) {
        $this->trigger_error("assign: missing 'var' parameter");
        return;
    }
*/  
    if (empty($label)) {
        $this->trigger_error("assign: missing 'label' parameter");
        return;
    }    
    
    echo $label[$var];

}

/* vim: set expandtab: */

?>
