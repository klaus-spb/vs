<a href="javascript:$( '#award' ).toggle();$( '#adder' ).toggle();" id="adder" class="btn" >Добавить награду</a>
<br/>
<div id="award" {if !$oMedal}style="display:none;"{/if}>
	<input type="hidden" name="security_ls_key" value="{$LIVESTREET_SECURITY_KEY}" /> 
	 <input type="hidden" id="medal_id" name="medal_id" value="{if $oMedal}{$oMedal->getMedalId()}{/if}" />	
	<p>
	   <input type="text" class="input-wide" id="medal_text" name="medal_text" value="{if $oMedal}{$oMedal->getMedalText()}{/if}" />&nbsp;За что
	</p>
	<p>
	   <input type="text" class="input-wide" id="medal_link" name="medal_link" value="{if $oMedal}{$oMedal->getMedalLink()}{/if}" />&nbsp;Ссылка (при нажатии на медаль)
	</p>
	<p> 
		<input type="text" class="input-wide autocomplete-team" id="teams" name="teams"  value="{if $oMedal && $oMedal->getTeam()}{$oMedal->getTeam()->getName()}{/if}" />
		Команда типлея
	</p>
	<p> 
		<input type="text" class="input-wide autocomplete-users" id="users" name="users" value="{if $oMedal && $oMedal->getUser()}{$oMedal->getUser()->getLogin()}{/if}" />
		Юзер
	</p>
	
	<p> 
		<input type="text" class="input-wide autocomplete-playercard" id="playercards" name="playercards" value="{if $oMedal && $oMedal->getPlayercard()}{$oMedal->getPlayercard()->getFamily()} {$oMedal->getPlayercard()->getName()}{/if}" />
		Карточка игрока тимплея
	</p>


	<p>
		<select id="medal" name="medal">  
			<option value=""{if $oMedal && ""==$oMedal->getMedal()} SELECTED{/if}>-</option>
			<option value="gold"{if $oMedal && "gold"==$oMedal->getMedal()} SELECTED{/if}>gold</option>
			<option value="silver"{if $oMedal && "silver"==$oMedal->getMedal()} SELECTED{/if}>silver</option>
			<option value="bronze"{if $oMedal && "bronze"==$oMedal->getMedal()} SELECTED{/if}>bronze</option>
		</select>&nbsp;медаль
	</p>
	<p>
		<select  id="weight" name="weight">  
			<option value=""{if $oMedal && ""==$oMedal->getWeight()} SELECTED{/if}>-</option>
			<option value="big"{if $oMedal && "big"==$oMedal->getWeight()} SELECTED{/if}>значимая</option>
			<option value="medium"{if $oMedal && "medium"==$oMedal->getWeight()} SELECTED{/if}>обычная</option>
			<option value="light"{if $oMedal && "light"==$oMedal->getWeight()} SELECTED{/if}>малозначимая</option>
		</select>&nbsp;медаль
	</p>

	<p>
	<select name="prise" id="prise" onChange="showprise()"> 
		{foreach from=$medals item=medal}   
			<option value="{$medal}" {if $oMedal && $oMedal->getLogo()==$medal}SELECTED{/if}>{$medal}</option>
		{/foreach}
	</select>
	</p>
	<img src="{if $oMedal}http://img.virtualsports.ru/medals/{$oMedal->getLogo()}{/if}" border="0" name="icons" id="icons">
	<br/>
	{if $oMedal}
		<a href="javascript:save_award();" class="btn">Сохранить</a>
	{else}
		<a href="javascript:add_award();" class="btn">Добавить награду</a>
	{/if}
</div>

<table width="100%" cellspacing="0" class="table table-striped table-bordered">
<tr style="font-weight:bold;">
        <th>Какая</th>
        <th>Какая2</th>
		<th>Кому</th>
		<th>Кому</th>
		<th>Кому</th>
		<th></th>
    </tr>
    {foreach from=$aMedals item=oMedal name=el2}
    {if $smarty.foreach.el2.iteration % 2  == 0}
     	{assign var=className value=''}
    {else}
     	{assign var=className value='colored'}
    {/if}
		{assign var="oUser" value=$oMedal->getUser()}  
		{assign var="oTeam" value=$oMedal->getTeam()}
		{assign var="oPlayercard" value=$oMedal->getPlayercard()}
		
	<tr class="{$className}" >
        <td style="text-align:center;"> {$oMedal->getMedal()} &nbsp;</td>
        <td style="text-align:center;"> {$oMedal->getWeight()} &nbsp;</td>
		<td style="text-align:center;"> {if $oUser}<a href="{router page='profile'}{$oUser->getLogin()}">{$oUser->getLogin()}</a> &nbsp;{/if}</td>
		<td style="text-align:center;"> {if $oTeam}{$oTeam->getName()}&nbsp;{/if}</td>
		<td style="text-align:center;"> {if $oPlayercard}{$oPlayercard->getFamily()} {$oPlayercard->getName()}&nbsp;{/if}</td>
        <td><small><a href="javascript:edit_award({$oMedal->getMedalId()});">Редактировать</a> <a href="javascript:delete_award({$oMedal->getMedalId()});" style="color:red;">Удалить</a></small></td>
    </tr>
    {/foreach}
	
</table>


<script language="JavaScript" type="text/javascript">
function showprise() {
	prisename = $('#prise').val();
	$('#icons') .attr("src","http://img.virtualsports.ru/medals/"+prisename); 

}
</script>