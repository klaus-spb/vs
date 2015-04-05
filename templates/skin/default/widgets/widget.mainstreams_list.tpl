<small>
			
<table width="100%" cellspacing="0" class="table">
	<thead>
<tr>		
	<th class="cside" align="center">Игрок</th>
	<th class="cside">Статус</th>
</tr>
</thead>
<tbody>
{if $aOnlines}
	{foreach from=$aOnlines item=aOnline name=el2}
	<tr>
		<td width="150"><a class="authors" href="http://virtualsports.ru/profile/{$aOnline.user_login}/" target="_blank">{$aOnline.user_login}</a></td>	
		<td width="210"><a href="{$aOnline.url}" target="_blank" title="{$aOnline.game}">{if $aOnline.status}{$aOnline.status}{else}stream{/if}</a></td>
	</tr>
	{/foreach}
{else}
<tr>
	<td style="text-align:center;" colspan="2">нет трансляций</td>
</tr>
{/if}
</tbody>
</table>


</small>