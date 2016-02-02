{if $is_admin}
<form action="{$links.$this_page}" method="POST">
<table>
<tr>
<th class="head_text" colspan="2">
New news
</th>
</tr>
<tr>
<td class="undertext">
Title
</td>
<td>
<input name="title" size="100" maxlength="255">
</td>
</tr>
<tr>
<td class="undertext">
Body
</td>
<td>
<textarea name="body" cols="60" rows="10">
</textarea>
</td>
</tr>
<tr>
<td>
<input type="hidden" name="act" value="proc_new_news">
<input type="submit">
</td>
</tr>
</table>
</form>
{/if}
{foreach item=newsline from=$news}
<table border="0" cellpadding="3" cellspacing="0" align="center" width="100%">
<tr>
<th class="head_text" colspan="2">{$newsline.title}</th>
</tr>
<tr>
<td class="spacer" colspan="2"></td>
</tr>
<tr>
<td width="22">&nbsp;</td>
<td width="588" align="left"class="undertext">Submitted by {$newsline.name} on {$newsline.date}</td>
</tr>
<tr>
<td width="22">&nbsp;</td>
<td width="588" align="left"class="text">{$newsline.body|nl2br|smilies}</td>
</tr>
<tr>
<td width="22">&nbsp;</td>
{if $is_admin}
<td class="undertext"><a href="{$links.$this_page}&act=delete_news&nid={$newsline.nid}">Delete this news</a></td>
{/if}
</tr>
</table>
{/foreach}
{foreach from=$news_pages item=pagenum}
{if $pagenum==$cur_pagenum}
{$pagenum} 
{else}
<a href="{$links.$this_page}&pagenum={$pagenum}">{$pagenum}</a>
{/if}
{/foreach}
