<table width="100%">
<tr>
<th class="head_text" colspan="4">
You are here <b><a href="{$links.$this_page}">Forums</a> / {$forum}</b>
</th>
</tr>
{if $logged_in}
<tr>
<td class="text" colspan="4">
<a href="{$links.$this_page}&act=new_topic&fid={$fid}">New topic</a>
</td>
</tr>
{/if}
<tr>
<td class="text">
Thread
</td>
<td class="text">
Started by
</td>
<td class="text">
Thread started
</td>
<td class="text">
Replies
</td>
</tr>
{foreach item=post from=$posts}
<tr>
<td class="undertext">
<a href="{$links.$this_page}&act=show_topic&pid={$post.pid}">{$post.topic}</a>
</td>
<td class="undertext">
{$post.name}
</td>
<td class="undertext">
{$post.postdate}
</td>
<td class="undertext">
{$post.replies}
</td>
</tr>
{/foreach}
</table>
