<table width="100%">
<tr>
<th class="head_text" colspan="4">
List of forums
</th>
</tr>
<tr>
<td class="text">
Forum
</td>
<td class="text">
Posts
</td>
<td class="text">
Last Poster
</td>
<td class="text">
Last Post at
</td>
</tr>
{foreach item=forum from=$forums}
<tr>
<td class="undertext">
<a href="{$links.$this_page}&act=show_forum&fid={$forum.fid}">{$forum.forum}</a>
</td>
<td class="undertext">
{$forum.posts}
</td>
<td class="undertext">
{$forum.poster}
</td>
<td class="undertext">
{$forum.postdate}
</td>
</tr>
{/foreach} 
</table>
