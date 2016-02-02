<table>
<tr>
<th class="head_text">
You are here <b><a href="{$links.$this_page}">Forums</a> / <a href="{$links.$this_page}&act=show_forum&fid={$fid}">{$forum}</a> / {$posts.0.topic}</b>
</th>
</tr>
</table>
{if $logged_in}
<a href="{$links.$this_page}&act=reply&pid={$pid}">Reply</a>
{/if}
{foreach item=post from=$posts}
<table width="100%">
<tr>
<th class="head_text">
<b>{$post.name} at {$post.postdate}</b><br>
{$post.topic}
</th>
</tr>
<tr>
<td class="undertext">
{$post.post|nl2br|regex_replace:"/^> (.*)/m":"<span style=\"color: yellow\">\$1</span>"|smilies}
</td>
</tr>
<tr>
<td>
{if $logged_in}
<a href="{$links.$this_page}&act=reply&pid={$post.pid}&quote=1">Quote</a>
{/if}
</td>
</tr>
</table>
{/foreach}
