<div class="widget-box">
<div class="widget-header">
	<h4>Создание расписания</h4>
</div>

<div class="widget-body">
	<div class="widget-main no-padding">
		<form action="javascript:void(null);" onsubmit="SendFormSchedule()">

			<fieldset>
				<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-1" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-2" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-3" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-4" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-5" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-6" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>
<div class="row-fluid input-append">
	<input class="span4 date-picker" id="id-date-picker-7" type="text" data-date-format="dd-mm-yyyy">
	<span class="add-on">
		<i class="icon-calendar"></i>
	</span>
</div>

 
<div class="controls">
	<label>
		<input id="sparenno" name="sparenno" type="checkbox" class="ace" value="1">
		<span class="lbl"> Матчи спаренные</span>
	</label>
</div>
<div class="controls">
	<label>
		<label for="obratka">Второй круг</label>
		<select class="w200" id="obratka" > 
				<option value="0" selected="">Не нужен</option>
				<option value="1">Зеркальный</option>
				<option value="2">Повторяет первый, но команды наоборот</option>
		</select>		
	</label>
</div>
<div class="row-fluid">
	<label for="parentgroup_id">Конференция</label>
	<select class="w200" id="parentgroup_id" > 
				<option value="0" selected="">Все</option>
				<option value="20">AFC</option>
				<option value="29">all</option>
				<option value="22">East (AFC)</option>
				<option value="23">East (NFC)</option>
				<option value="14">Group A</option>
				<option value="15">Group B</option>
				<option value="16">Group C</option>
				<option value="17">Group D</option>
				<option value="18">Group H</option>
				<option value="19">Group S</option>
				<option value="27">Kosmodrom</option>
				<option value="21">NFC</option>
				<option value="26">VirtualSports</option>
				<option value="24">West (AFC)</option>
				<option value="25">West (NFC)</option>
				<option value="7">Атлантический дивизион</option>
				<option value="3">Восточная конференция</option>
				<option value="10">Восточный дивизион</option>
				<option value="2">Западная конференция</option>
				<option value="13">Западный дивизион</option>
				<option value="28">Метрополитан дивизион</option>
				<option value="11">Северный дивизион</option>
				<option value="8">Северо-Восточный дивизион</option>
				<option value="5">Северо-Западный дивизион</option>
				<option value="12">Средне-Западный дивизион</option>
				<option value="6">Тихоокеанский дивизион</option>
				<option value="4">Центральный дивизион</option>
				<option value="9">Юго-Восточный дивизион</option>
		</select>
</div>
<div class="row-fluid">
	<label for="group_id">Группа</label>
	<select class="w200" id="group_id" > 
				<option value="0" selected="">Все</option>
				<option value="20">AFC</option>
				<option value="29">all</option>
				<option value="22">East (AFC)</option>
				<option value="23">East (NFC)</option>
				<option value="14">Group A</option>
				<option value="15">Group B</option>
				<option value="16">Group C</option>
				<option value="17">Group D</option>
				<option value="18">Group H</option>
				<option value="19">Group S</option>
				<option value="27">Kosmodrom</option>
				<option value="21">NFC</option>
				<option value="26">VirtualSports</option>
				<option value="24">West (AFC)</option>
				<option value="25">West (NFC)</option>
				<option value="7">Атлантический дивизион</option>
				<option value="3">Восточная конференция</option>
				<option value="10">Восточный дивизион</option>
				<option value="2">Западная конференция</option>
				<option value="13">Западный дивизион</option>
				<option value="28">Метрополитан дивизион</option>
				<option value="11">Северный дивизион</option>
				<option value="8">Северо-Восточный дивизион</option>
				<option value="5">Северо-Западный дивизион</option>
				<option value="12">Средне-Западный дивизион</option>
				<option value="6">Тихоокеанский дивизион</option>
				<option value="4">Центральный дивизион</option>
				<option value="9">Юго-Восточный дивизион</option>
		</select>
</div>
<div class="row-fluid">
	<label for="round_id">Раунд</label>
	<select class="w200" id="round_id" > 
		{foreach from=$aRounds item=oRound name=el2}
			<option value="{$oRound->getRoundId()}">{$oRound->getName()}</option>
		{/foreach}
		</select>
</div>

<div class="row-fluid">
	<label for="protivnik_group_id">Группа противника(почти наверняка вам это не нужно)</label>
	<select class="w200" id="protivnik_group_id" > 
				<option value="0" selected="">Все</option>
				<option value="20">AFC</option>
				<option value="29">all</option>
				<option value="22">East (AFC)</option>
				<option value="23">East (NFC)</option>
				<option value="14">Group A</option>
				<option value="15">Group B</option>
				<option value="16">Group C</option>
				<option value="17">Group D</option>
				<option value="18">Group H</option>
				<option value="19">Group S</option>
				<option value="27">Kosmodrom</option>
				<option value="21">NFC</option>
				<option value="26">VirtualSports</option>
				<option value="24">West (AFC)</option>
				<option value="25">West (NFC)</option>
				<option value="7">Атлантический дивизион</option>
				<option value="3">Восточная конференция</option>
				<option value="10">Восточный дивизион</option>
				<option value="2">Западная конференция</option>
				<option value="13">Западный дивизион</option>
				<option value="28">Метрополитан дивизион</option>
				<option value="11">Северный дивизион</option>
				<option value="8">Северо-Восточный дивизион</option>
				<option value="5">Северо-Западный дивизион</option>
				<option value="12">Средне-Западный дивизион</option>
				<option value="6">Тихоокеанский дивизион</option>
				<option value="4">Центральный дивизион</option>
				<option value="9">Юго-Восточный дивизион</option>
		</select>
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
		