{**}


<div class="widget-box">
	<div class="widget-header">
		<h4>Управление ивентами</h4>
	</div>

	<div class="widget-body">
	<fieldset style="padding: 16px;">
		<div class="row-fluid">
			<label for="form-field-select-3">Выберите ивент</label>

			<select class="" id="event_selects" onchange="ls.au.simple_toggles(this,'eventday'); return false;">
				<option value="0"></option>
				{if $aEvents}
					{foreach from=$aEvents item=oEvent name=el2}
						<option value="{$oEvent->getEventId()}">{$oEvent->getName()}</option>
					{/foreach}				
				{/if}
				
			</select>
		</div>
		<div class="row-fluid" id="div_eventday">
		
		</div>
	</fieldset>	
	</div>
</div>

<p> <input class="span2 date-picker" id="event_date" name="event_date" type="text" data-date-format="dd-mm-yyyy"><span class="add-on">
		<i class="icon-calendar"></i>
	</span>
	<input type="text" class="input-wide " id="event_name" name="event_name"  />
	<a href="javascript:add_event();">Добавить ивент</a> 
</p> 
{if $aEvents}
	{literal}
	<script>
	$("#event_selects :nth-child(2)").attr("selected", "selected").change();
	</script>
	{/literal}
{/if}
{*							
	<div class="widget-main no-padding">
		<form action="javascript:void(null);" onsubmit="SendFormSchedule()">

			<fieldset>
				<div class="row-fluid input-append">
	<input class="span4 date-picker" id="event_date" name="event_date" type="text" data-date-format="dd-mm-yyyy"><span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<label for="event_name">Название ивента</label>
	<input type="text" class="input-wide " id="event_name" name="event_name"  />
</div>

			</fieldset>

			<div class="form-actions center">
				<button  class="btn btn-small btn-success">
					Создать
					<i class="icon-arrow-right icon-on-right bigger-110"></i>
				</button>
			</div>
		</form>
	</div>
</div>
</div>

<a href="#" id="" onclick="ls.au.simple_toggles(this,'deleteshedule', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">Удалить расписание</a>
{if $superadmin && 1==0}
<a href="#" id="" onclick="ls.au.simple_toggles(this,'createshedule', {literal}{{/literal} tournament: {$oTournament->getTournamentId()} {literal}}{/literal}); return false;">Создать расписание</a>
<br/>

{/if}
*}		