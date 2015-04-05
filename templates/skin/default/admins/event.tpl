<p> <input class="span2 date-picker" id="event_edit_date" name="event_edit_date" type="text" value="{$oEvent->getDates()|date_format:"%e-%m-%Y"}" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
	<input type="hidden" class="input-wide " id="event_edit_id" value="{$oEvent->getEventId()}" name="event_edit_id"  />
	<input type="text" class="input-wide " id="event_edit_name" value="{$oEvent->getName()}" name="event_edit_name"  />
	<a href="javascript:edit_event();">Сохранить ивент</a> / <small>{if $oEvent->getClosed()==0}<a href="javascript:calc_event();">посчитать рейтинг</a>{else}посчитан рейтинг{/if}</small> / <small><a href="javascript:delete_event();">x</a></small>
</p> 

{if $aEventPairs}

{foreach from=$aEventPairs item=oEventPair}

	<div class='row-fluid' >
	Команда слева - 
	<SELECT style='width:150px;' onchange="check_team(this,'{$oEvent->getEventId()}','{$oEventPair->getEventPairId()}'); return false;" id='left_{$oEventPair->getEventPairId()}'>
		<OPTION value='0'>-</OPTION>
		{foreach from=$aEventPlayers item=oEventPlayer}
			{assign var="oTeamTournament" value=$oEventPlayer->getTeamtournament()}
			{assign var="oUser" value=$oTeamTournament->getUser1()}
			<option value='{$oEventPlayer->getTeamintournamentId()}' {if $oEventPlayer->getTeamintournamentId()==$oEventPair->getLeftTeamintournamentId()}SELECTED{/if}>{$oUser->getLogin()} </option>
		{/foreach}
	</SELECT> 

	Команда справа - 
	<SELECT style='width:150px;' onchange="check_team(this,'{$oEvent->getEventId()}','{$oEventPair->getEventPairId()}'); return false;" id='right_{$oEventPair->getEventPairId()}' >
		<OPTION value='0'>-</OPTION>
		{foreach from=$aEventPlayers item=oEventPlayer}
			{assign var="oTeamTournament" value=$oEventPlayer->getTeamtournament()}
			{assign var="oUser" value=$oTeamTournament->getUser1()}
			<option value='{$oEventPlayer->getTeamintournamentId()}' {if $oEventPlayer->getTeamintournamentId()==$oEventPair->getRightTeamintournamentId()}SELECTED{/if}>{$oUser->getLogin()} </option>
		{/foreach}
		</SELECT>
	<input type="checkbox" id='titul_{$oEventPair->getEventPairId()}' onchange="check_team(this,'{$oEvent->getEventId()}','{$oEventPair->getEventPairId()}'); return false;" class="checkbox" value="1" {if $oEventPair->getTitul()}checked="yes"{/if} >титул
	</div>
{/foreach}
{/if}

{if $aEventPlayers}
<br/>
<a href="javascript:add_row({$oEvent->getEventId()});">Добавить пару</a><br/>
<div id="divTxt"></div>
<table>
	{foreach from=$aEventPlayers item=oEventPlayer}
		
    {assign var="oTeamTournament" value=$oEventPlayer->getTeamtournament()}
	{assign var="oUser" value=$oTeamTournament->getUser1()}
		<tr>
			<td><a class="authors" target="_blank" href="{$oUser->getUserWebPath()}"> {$oUser->getLogin()}</a></td>
			<td> - <small>{$oEventPlayer->getDates()}</small></td> 
		</tr>
	{/foreach}	
</table>
{/if}
 
{literal}
<script>
var players="{/literal}{foreach from=$aEventPlayers item=oEventPlayer}{assign var="oTeamTournament" value=$oEventPlayer->getTeamtournament()}{assign var="oUser" value=$oTeamTournament->getUser1()}<option value='{$oEventPlayer->getTeamintournamentId()}'>{$oUser->getLogin()} </option>{/foreach}{literal}";

		
function check_team(el, event_id, event_pair_id){
	var params = {};
	params['event_id']   = event_id;
	params['event_pair_id']   = event_pair_id;
	params['left_teamtournament_id'] = $('#left_'+event_pair_id).val();
	params['right_teamtournament_id'] = $('#right_'+event_pair_id).val();
	if($('#titul_'+event_pair_id).is(':checked')){params['titul']=1;}else{params['titul']=0;}
	params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
	ls.ajax(aRouter['ajax']+'au/editeventpair/', params, function(result){
		if (!result) {
			ls.msg.error('Error','Please try again later');
		}
		if (result.bStateError) {
			ls.msg.error(result.sMsgTitle,result.sMsg);
		} else { 
			ls.msg.notice('Сохранено',' ');	
		}
	});
}
		
function add_row(event_id){
	var params = {};
	params['event_id']   = event_id;
	params['event_pair_id']   = 0;
	params['left_teamtournament_id'] = 0;
	params['right_teamtournament_id'] = 0; 
	params['security_ls_key'] = LIVESTREET_SECURITY_KEY;
	ls.ajax(aRouter['ajax']+'au/editeventpair/', params, function(result){
		if (!result) {
			ls.msg.error('Error','Please try again later');
		}
		if (result.bStateError) {
			ls.msg.error(result.sMsgTitle,result.sMsg);
		} else { 
			$("#divTxt").append("<div class='row-fluid' >Команда слева - <SELECT style='width:150px;' onchange=\"check_team(this,'"+ result.event_id +"','"+ result.event_pair_id +"'); return false;\" id='left_"+ result.event_pair_id +"'><OPTION value='0'>-</OPTION>"+ players +"</SELECT> Команда справа - <SELECT style='width:150px;' id='right_"+ result.event_pair_id +"' onchange=\"check_team(this,'"+ result.event_id +"','"+ result.event_pair_id +"'); return false;\"><OPTION value='0'>-</OPTION>"+ players +"</SELECT><input type='checkbox' id='titul_"+ result.event_pair_id +"' onchange='check_team(this,'"+ result.event_id +"','"+ result.event_pair_id +"'); return false;' class='checkbox' value='1' >титул</div>");
		}
	});	
}		
		
</script>
{/literal}