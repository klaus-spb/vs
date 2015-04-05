<br/>
{if $oPenalty}
<p> 
	<input type="text" class="input-wide autocomplete-users" id="user" name="user" value="{$oPenalty->getUser()->getUserLogin()}" /> - Пользователь</br>
	<input type="text" class="input-wide" id="why" name="why" value="{$oPenalty->getWhy()}" /> - За что</br>
	<input type="hidden" id="penalty_id" name="penalty_id" value="{$oPenalty->getId()}" />
	<a href="javascript:save_player_penalty();" class="btn btn-primary">Сохранить</a>
</p>
{else}
<p> 
	<input type="text" class="input-wide autocomplete-users" id="user" name="user"  /> - Пользователь</br>
	<input type="text" class="input-wide" id="why" name="why"  /> - За что</br>
	<a href="javascript:add_player_penalty();" class="btn">Добавить штраф</a>
</p>
{/if}

<table width="100%" cellspacing="0" class="table table-striped table-bordered">
<tr>
	<th width="100">Дата</td>
	<th width="100">Кому</td>
	<th width="300">За что</td>	
	<td></td>
</tr>
{foreach from=$aPenalty item=oPenalty name=el2}


<tr>
	<td width="100"><small>{$oPenalty->getDates()|date_format:"%e %B %Y"}</small></td>	
	<td width="100"><a href="{$oPenalty->getUser()->getUserWebPath()}">{$oPenalty->getUser()->getUserLogin()}</a></td>
	<td width="300">{$oPenalty->getWhy()}</td>	
	<td><small><a href="javascript:edit_player_penalty({$oPenalty->getId()});">Редактировать</a> <a href="javascript:delete_player_penalty({$oPenalty->getId()});" style="color:red;">Удалить</a></small></td>
</tr>

{/foreach}
</table>