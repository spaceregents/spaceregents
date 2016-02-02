{strip}
Battle in {$location}

{foreach key=participant item=result from=$results}
<table>
<tr>
<th class="head" colspan="4">
<b>{$users.$participant}</b>
</th>
</tr>
<tr class="head"><th>Unit</th><th>Count</th><th>Lost Units</th><th>Remaining Units</th></tr>
{foreach key=key item=ship from=$result.ships}
<tr class="text"><td>{$key}</td><td>{$ship}</td><td>{$result.destroyed_ships.$key|default:"-"}</td><td>{$result.remaining_ships.$key|default:"-"}</td></tr>
{/foreach}
</table>
{foreach key=key item=admiral from=$result.admirals}
{$admiral.name|string_format:"%-30s"} {if $admiral.newxp}(xp {$admiral.xp}&nbsp;=&gt; {$admiral.newxp}){if $admiral.lvlup} gained a level! {else}. {/if}{else} died. {/if} 

{/foreach}

{/foreach}

{if $invasion}{$invasion}{/if}
{/strip}
