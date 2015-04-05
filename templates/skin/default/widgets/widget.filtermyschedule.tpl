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
		if(which == 2) $('#tournaments').addClass('tag-input-style');
		 else $('#tournaments').removeClass('tag-input-style');
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
	params['security_ls_key']=LIVESTREET_SECURITY_KEY;							
	if( $('#dates').val()!='' )params['dates']=$('#dates').val();
	
	params['tournaments']=$('#tournaments').val();
	params['players']=$('#players').val();

	
	var url = location.protocol + '//' + location.host + location.pathname;    
	url += '?f=1'
	if( $('#dates').val()!='' ){
		params['dates']=$('#dates').val();
		dates=$('#dates').val();	
		dates=dates.replace(" ","+");
		dates=dates.replace(" ","+");			
		url += '&dates=' + dates;
	}
	if($('#tournaments').val()!=null){
		for (var i = 0; i < tournaments.length; i++){

		  if(tournaments[i].selected == true)url += '&tournaments[]='+tournaments[i].value;
		  }

	}
	if($('#players').val()!=null){
		for (var i = 0; i < players.length; i++){

		  if(players[i].selected == true)url += '&players[]='+players[i].value;
		  }

	}

 
window.history.pushState({path:url},'',url);


	ls.ajax(aRouter['ajax']+'raspisanie/schedule_my_filter/', params, function(result){
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
        <h3>Filter</h3>
    </header>

    <div class="block-content">
		<form method="post" onsubmit="schedule_filter();return false;" >
			<label for="form-field-select-tournament">Tournaments</label>
			<select multiple name="tournaments[]" class="chosen-select" id="tournaments" data-placeholder="Choose a tournament...">
			{foreach from=$aTournaments item=oTournament}
				<option value="{$oTournament->getTournamentId()}" 
				{if isset($aFilter.tournaments) && is_array($aFilter.tournaments)}
					{foreach from=$aFilter.tournaments item=tournament}
						{if $tournament==$oTournament->getTournamentId()}selected{/if}
					{/foreach}
				{/if}
					>{$oTournament->getBrief()}</option>
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