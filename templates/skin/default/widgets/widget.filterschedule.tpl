<div class="block">
{literal}
<script>
jQuery(document).ready(function($){
	//$(".chzn-select").chosen(); 
	//$(".chzn-select-deselect").chosen({allow_single_deselect:true});
	$(".chosen-select").chosen(); 
	$('#chosen-multiple-style').on('click', function(e){
		var target = $(e.target);
		var which = parseInt($.trim(target.text()));
		if(which == 2) $('#teams').addClass('tag-input-style');
		 else $('#teams').removeClass('tag-input-style');
		if(which == 2) $('#players').addClass('tag-input-style');
		 else $('#players').removeClass('tag-input-style');
	});

				
	$('#dates').daterangepicker(
	{
		
		minDate: '2012-01-01',
		maxDate: '2016-12-31',
		//dateLimit: { days: 60 },
		showDropdowns: true,
		showWeekNumbers: true,
		timePicker: false,
		timePickerIncrement: 1,
		timePicker12Hour: false,
		ranges: {
		   'Today': [moment(), moment()],
		   'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
		   'Last 7 Days': [moment().subtract('days', 6), moment()],
		   'Last 30 Days': [moment().subtract('days', 29), moment()],
		   'This Month': [moment().startOf('month'), moment().endOf('month')],
		   'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
		},
		opens: 'left',
{/literal}		
{if isset($aFilter.date_start) && isset($aFilter.date_end)}
    startDate: '{$aFilter.date_start}',
    endDate: '{$aFilter.date_end}',
{else}
startDate: moment().subtract('days', 29),
		endDate: moment(),
{/if}
{literal}		
		buttonClasses: ['btn btn-default'],
		applyClass: 'btn-small btn-primary',
		cancelClass: 'btn-small',
		format: 'YYYY-MM-DD',
		separator: ' - ',
		locale: {
			applyLabel: 'Submit',
			fromLabel: 'From',
			toLabel: 'To',
			customRangeLabel: 'Custom Range',
			daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr','Sa'],
			monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
			firstDay: 1
		}
	}
	);
});
function  schedule_filter(){
	var params = {};
	params['tournament_id']={/literal}{$oTournament->getTournamentId()} {literal}; 
	params['security_ls_key']=LIVESTREET_SECURITY_KEY;							
	if( $('#dates').val()!='' )params['dates']=$('#dates').val();
	params['teams']=$('#teams').val();
	params['players']=$('#players').val();
	if($('#not_played').is(':checked')){params['not_played']=1;}else{params['not_played']=0;}
	params['round']=$('#round').val();
	params['round_po']=$('#round_po').val();
	params['event']=$('#event').val();
	
	var url = location.protocol + '//' + location.host + location.pathname;    
	url += '?f=1'
	if( $('#dates').val()!='' ){
		params['dates']=$('#dates').val();
		dates=$('#dates').val();	
		dates=dates.replace(" ","+");
		dates=dates.replace(" ","+");			
		url += '&dates=' + dates;
	}
	if($('#not_played').is(':checked')){
		params['not_played']=1;
		url += '&not_played=1';
	}else{
		params['not_played']=0;
	}
	if($('#teams').val()!=null){
		for (var i = 0; i < teams.length; i++){

		  if(teams[i].selected == true)url += '&teams[]='+teams[i].value;
		  }

	}
	if($('#players').val()!=null){
		for (var i = 0; i < players.length; i++){

		  if(players[i].selected == true)url += '&players[]='+players[i].value;
		  }

	}
	if($('#round').val()!=null && $('#round').val()!=-1){
		url += '&round=' + $('#round').val();
	}
	if($('#round_po').val()!=null && $('#round_po').val()!=-1){
		url += '&round_po=' + $('#round_po').val();
	}
	if($('#event').val()!=null && $('#event').val()!=-1){
		url += '&event=' + $('#event').val();
	}
	
 
window.history.pushState({path:url},'',url);


	ls.ajax(aRouter['ajax']+'raspisanie/schedule_filter/', params, function(result){
		if (!result) {
			ls.msg.error('Error','Please try again later');
		}
		if (result.bStateError) {
			ls.msg.error(result.sMsgTitle,result.sMsg);
		} else { 
			$('#div_raspisanie').html(result.sText);
			 $('a.teamrasp').mouseover(function() {
				 Tipped.create(this,  aRouter['ajax']+'team/info/',{
						skin: 'cloud',
						hook: 'topleft',
						maxWidth: 300,
						showDelay: 300, 
						ajax: { data: { 
									team: $(this).text(), 
									security_ls_key: LIVESTREET_SECURITY_KEY, 
									tournament_id: tournament_for_hover,
									game_id: miniturnir_game_for_hover,
									gametype_id: miniturnir_gametype_for_hover
								}, type: 'post' }
					  });
					});
		}
	});
 
}

</script>
{/literal}
    <header class="block-header sep">
        <h3><a class="links_head" href="{$oTournament->getUrlFull()}shedule/">Filter</a></h3>
    </header>

    <div class="block-content">
		<form method="post" onsubmit="schedule_filter();return false;{*{$oTournament->getUrlFull()}shedule/*}" >
			<label for="form-field-select-team">Teams</label>
			<select multiple name="teams[]" class="chosen-select" id="teams" data-placeholder="Choose a team...">
			{foreach from=$aTeamsInTournament item=oTeamInTournament}
			{assign var=oTeam value=$oTeamInTournament->getTeam()}
			{if $oTeam}
				<option value="{$oTeam->getTeamId()}" 
				{if isset($aFilter.teams) && is_array($aFilter.teams)}
					{foreach from=$aFilter.teams item=team}
						{if $team==$oTeam->getTeamId()}selected{/if}
					{/foreach}
				{/if}
					>{$oTeam->getName()}</option>
			{/if}
			{/foreach}
			</select>
			
			
			<br/>
			<br/>
			
			<label for="form-field-select-player">Players</label>
			<select multiple name="players[]" class="chosen-select" id="players" data-placeholder="Choose a player...">
			{foreach from=$aUsers item=oUser}
			{if $oUser}
				<option value="{$oUser->getUserId()}" 
				{if isset($aFilter.players) && is_array($aFilter.players)}
					{foreach from=$aFilter.players item=players}
						{if $players==$oUser->getUserId()}selected{/if}
					{/foreach}
				{/if}
					>{$oUser->getLogin()}</option>
			{/if}
			{/foreach}
			</select>
			
			
			<br/>
			<br/>
			
			<div class="controls">
				<label>
					<input id="not_played" name="not_played" type="checkbox" value="1" {if isset($aFilter.not_played) && $aFilter.not_played==1}checked{/if}/>
					<span class="lbl"> not played</span>
				</label>
			</div>
			<br/>
			
			<div class="controls">
				<label for="form-field-select-round">Round</label>
					<select name="round"  id="round">
						<option value="-1" >All rounds</option>
						{foreach from=$aRounds item=oRound}
							<option value="{$oRound->getRoundId()}" {if isset($aFilter.round_id) && $aFilter.round_id==$oRound->getRoundId() }selected{/if}>{$oRound->getName()}</option> 
						{/foreach}
					</select>
				</label>
			</div> 
			<br/>
			
			{if $rounds_po}
			<div class="controls">
				<label for="form-field-select-round">Round PO</label>
					<select name="round_po"  id="round_po">
						<option value="-1" >All rounds</option>
						{foreach from=$rounds_po item=round_po}
							<option value="{$round_po.round}" {if isset($aFilter.round_po) && $aFilter.round_po==$round_po.round }selected{/if}>{if $round_po.round=='1'}Final{else}{$round_po.round}{/if}</option> 
						{/foreach}
					</select>
				</label>
			</div> 
			<br/>
			{else}
			<input name="round_po" type="hidden" value="">
			{/if}
			
			<div class="controls">
				<label for="form-field-select-round">Events</label>
					<select name="event"  id="event">
						<option value="-1" >All events</option>
						{if $aEvents}
						{foreach from=$aEvents item=oEvent}
							<option value="{$oEvent->getEventId()}" {if isset($aFilter.event_id) && $aFilter.event_id==$oRound->getEventId() }selected{/if}>{$oEvent->getName()}</option> 
						{/foreach}
						{/if}
					</select>
				</label>
			</div> 
			<br/>
			
			<div class="row-fluid">
				<label for="dates">Date Range</label>
			</div>
			<div class="control-group">
				<div class="input-prepend">


					<input  type="text" name="dates" id="dates" {if isset($aFilter.dates) }value="{$aFilter.dates}"{/if}/>
				</div>
			</div>	
			<input name="f" type="hidden" value="1">			
			<br/>
			<input class="btn btn-small btn-info" type="submit" value="Filter">
		</form>	
	</div>
</div>