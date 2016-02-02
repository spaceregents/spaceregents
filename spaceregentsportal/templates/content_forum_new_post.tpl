{if $errors }
{foreach item=error from=$errors }
<h2>{$error}</h2>
{/foreach}
{/if}
<a href="{$links.$this_page}&act=show_topic&pid={$fpid}">Back</a><br>
<form action="{$links.$this_page}&act=proc_new_post" method="post">
<table>
<tr>
<td class="undertext">
Subject
</td>
<td class="undertext">
<input type="text" name="subject" value="{$subject}" maxlength="255" size="50">
</td>
</tr>
<tr>
<td class="undertext">
Content
</td>
<td class="undertext">
<textarea name="content" cols="50" rows="20">
{$content}
</textarea>
</td>
</tr>
</table>
<input type="hidden" name="fid" value="{$fid}">
<input type="hidden" name="fpid" value="{$fpid}">
<input type="hidden" name="puniq" value="{$puniq}">
<input type="submit">
</form>
