<?
function b_order_sort($a,$b)
{
  $type_a=key($a);
  $type_b=key($b);

  $bfleetidx_a=key($a[$type_a]);
  $bfleetidx_b=key($b[$type_b]);

  $shipidx_a=key($a[$type_a][$bfleetidx_a]);
  $shipidx_b=key($b[$type_b][$bfleetidx_b]);

  if ($a[$type_a][$bfleetidx_a][$shipidx_a]==$b[$type_b][$bfleetidx_b][$shipidx_b])
    return 0;

  return ($a[$type_a][$bfleetidx_a][$shipidx_a]>$b[$type_b][$bfleetidx_b][$shipidx_b]) ? -1 : 1;
}
?>
