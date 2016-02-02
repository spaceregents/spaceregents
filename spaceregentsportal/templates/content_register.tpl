{foreach item=error from=$errors}
<h2>{$error}</h2>
{/foreach}
<form action="{$links.$this_page}" method="post">
<table>
<tr>
<td class="undertext">
Name
</td>
<td class="undertext">
<input name="name" value="{$pre.name}">
</td>
</tr>
<tr>
<td class="undertext">
Email
</td>
<td class="undertext">
<input name="email" value="{$pre.email}">
</td>
</tr>
<tr>
<td class="undertext">
Password
</td>
<td class="undertext">
<input type="password" name="password">
</td>
</tr>
<tr>
<td class="undertext">
Reenter Password
</td>
<td class="undertext">
<input type="password" name="password2">
</td>
</tr>
</table>
<input type="hidden" name="act" value="proc_register">
<input type="submit">
</form>
