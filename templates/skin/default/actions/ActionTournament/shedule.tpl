
{if $oMatches}
<table width="100%" cellspacing="0" class="table">
<thead>
<tr>
	<th class="lside"></th>		
	<th class="cside" align="center">№</th>
	<th class="cside">{if $oGame}{if $oGame->getSportId()==2}Home{else}Away{/if}{/if}</th>
	<th class="cside">{if $oGame}{if $oGame->getSportId()==2}Away{else}Home{/if}{/if}</th>
	<th class="cside" align="center">Score</th>
    <th class="cside" align="center"></th>
	<th class="cside" align="center"></th>
</tr>
</thead>
<tbody>

{assign var=timeonline value=600}

    {foreach from=$oMatches item=oMatch name=el2}
    {if $smarty.foreach.el2.iteration % 2  == 0}
     	{assign var=className value='light'}
    {else}
     	{assign var=className value='vlight'}
    {/if}
	<tr>

		<td align="center"><small>{$oMatch.dates}</small></td>
		<td class="{$className}" width="30" align="center"><small>{$oMatch.number} {if $oMatch.round_po<>""}{if $oMatch.round_po=="1"}F{else}{$oMatch.round_po}{/if}{/if}</small></td>
        <td class="{$className}" width="250">
		{if $oMatch.known_teams == 3}
			{if $oMatch.away_user_profile_avatar}<img style="height:20px;width:20px;" src="{$oMatch.away_user_profile_avatar}"/>{/if}
			{if $oMatch.away_player}<a href="{router page='profile'}{$oMatch.away_player}" target="_blank" >{$oMatch.away_player}{if $oMatch.away_seconds < $timeonline}{if !($oUserCurrent && $oUserCurrent->getUserLogin()==$oMatch.away_player)}<i class="icon-circle icon-1 green" title="online"></i>{/if}{/if}</a>{/if}			
		{else}
			{if $oMatch.away_logo}<img style="height:20px;width:20px;" src="/images/teams/small/{$oMatch.away_logo}"/>{/if} <a href="#" onclick="ls.au.simple_toggles(this,{if isset($month)}'monthes'{/if}{if isset($week)}'weeks'{/if}, {literal}{{/literal} tournament: {$oMatch.tournament_id} {if isset($month)}, monthes:{$month}{/if}{if isset($week)}, week:{$week}{/if}, team:'{$oMatch.away_brief}' {literal}}{/literal}); return false;" class="teamrasp {if $myteamtournament==$oMatch.away_teamtournament}myteam{/if}">{$oMatch.away_name}</a>
			{if $oMatch.away_player}<small>(<a href="{router page='profile'}{$oMatch.away_player}" target="_blank" >{$oMatch.away_player}</a>{if $oMatch.away_seconds < $timeonline}{if !($oUserCurrent && $oUserCurrent->getUserLogin()==$oMatch.away_player)}<i class="icon-circle icon-1 green" title="online"></i>{/if}{/if})</small>{/if}
		{/if}
		</td>
		<td class="{$className}" width="250">
		{if $oMatch.known_teams == 3}		
			{if $oMatch.home_user_profile_avatar}<img style="height:20px;width:20px;" src="{$oMatch.home_user_profile_avatar}"/>{/if}
			{if $oMatch.home_player}<a href="{router page='profile'}{$oMatch.home_player}" target="_blank">{$oMatch.home_player}{if $oMatch.home_seconds < $timeonline}{if !($oUserCurrent && $oUserCurrent->getUserLogin()==$oMatch.home_player)}<i class="icon-circle icon-1 green" title="online"></i>{/if}{/if}</a>{/if}
		{else}
		{if $oMatch.home_logo}<img style="height:20px;width:20px;" src="/images/teams/small/{$oMatch.home_logo}"/>{/if} <a href="#" onclick="ls.au.simple_toggles(this,{if isset($month)}'monthes'{/if}{if isset($week)}'weeks'{/if}, {literal}{{/literal} tournament: {$oMatch.tournament_id} {if isset($month)}, monthes:{$month}{/if}{if isset($week)}, week:{$week}{/if}, team:'{$oMatch.home_brief}' {literal}}{/literal}); return false;" class="teamrasp {if $myteamtournament==$oMatch.home_teamtournament}myteam{/if}">{$oMatch.home_name}</a>
			{if $oMatch.home_player}<small>(<a href="{router page='profile'}{$oMatch.home_player}" target="_blank">{$oMatch.home_player}</a>{if $oMatch.home_seconds < $timeonline}{if !($oUserCurrent && $oUserCurrent->getUserLogin()==$oMatch.home_player)}<i class="icon-circle icon-1 green" title="online"></i>{/if}{/if})</small>{/if}
		{/if}
		</td>
		<td class="{$className}" width="70" align="center">
			{if $oMatch.played==1}
<div id="match{$oMatch.match_id}">{$oMatch.g_away} : {$oMatch.g_home}{if $oMatch.so==1} SO{/if}{if $oMatch.ot==1} ОТ{/if}{if $oMatch.teh==1} teh.{/if}{if $oMatch.ko==1} KO{/if}{if $oMatch.tehko==1} TKO{/if}{if $oMatch.submission==1} SUB{/if}{if $oMatch.decision==1} DEC{/if}{if $oMatch.disqualification==1} DSQ{/if}</div>
			{else}
			<div id="match{$oMatch.match_id}"></div>
				{if $oMatch.home_insert==1 && $oMatch.away_insert==1}different{/if}
				{if $oMatch.home_insert != $oMatch.away_insert}wait{/if}
				{if $oMatch.myteam==1}					
					{if $oMatch.timetoplay != '0000-00-00 00:00:00'}<a href="{$link_match}{$oMatch.match_id}">{$oMatch.timetoplay|date_format :"%H:%M"} CET</a>{/if}
					
				{else}
				{if $oMatch.timetoplay != '0000-00-00 00:00:00'}{$oMatch.timetoplay|date_format :"%H:%M"} CET{/if}
				{/if}
			{/if}
		</td>
		<td width="80">
			{if ( $oMatch.myteam==1 || $oMatch.played==1 && $oMatch.teh==0 || $isAdmin || $admin=="yes")}
				
				<div class="btn-group">
					{if ( $oMatch.date_openrasp!='20000101' and $oMatch.date_openrasp>=$oMatch.date_match ) or $oMatch.date_openrasp == '20000101' }
					<button data-toggle="dropdown" class="btn btn-info btn-small ajaxer dropdown-toggle" data-ajaxer="match/getbuttons/" name="{$oMatch.match_id}">
						Action
						<i class="icon-angle-down icon-on-right"></i>
					</button>

					<ul class="dropdown-menu dropdown-default" id="{$oMatch.match_id}">
						
					{/if}
				</div>
			{/if}

		</td>
		{*{if $oMatch.played==0}
			{assign var=classprodlenie value=''}
			{if (( ( $smarty.now|date_format:"%Y"==$oMatch.prodlenyear && $smarty.now|date_format:"%V">$oMatch.prodlenweek  ) || ($smarty.now|date_format:"%Y">$oMatch.prodlenyear ) ))}
				{assign var=classprodlenie value='reds'}
			{/if}
			
			{if ( ($oMatch.prodlen>0) &&(( $smarty.now|date_format:"%Y"==$oMatch.prodlenyear && $smarty.now|date_format:"%V"<=$oMatch.prodlenweek  ) || ($smarty.now|date_format:"%Y"<$oMatch.prodlenyear )) )}
				{assign var=classprodlenie value='greens'}
			{/if}
			
			<td width="11" class="{$classprodlenie}">{if $oMatch.prodlen>0}{$oMatch.prodlen}{/if}</td>
		{/if}*}
		<td style="padding:0; width:20px;">
		{if $oMatch.tournament_logo_small}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oMatch.tournament_url}/{$oMatch.tournament_logo_small}"/>{/if}
		{if $oMatch.titul!=0}TF{/if} <div id="match_video{$oMatch.match_id}">{if $oMatch.with_video ==1}<i class="icon-facetime-video"></i>{/if}</div>
		</td>
	</tr>

	{assign var=dates_before value=$oMatch.dates}	
	{assign var=first value=0}
    {/foreach}
</tbody>
</table>
<div style="margin-top:170px;padding-top:170px;"></div>
{else}
<p align="center">no matches</p>
{/if}
