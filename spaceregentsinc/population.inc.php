<?php
function get_pop_by_poplevel($poplevel)
{
  return pow(2,$poplevel-1)*1000;
}

function get_poplevel_by_pop($pop)
{
  return floor((log10($pop/1000)/log10(2))+1);
}
?>
