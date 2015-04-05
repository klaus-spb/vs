<div class="">
<div class="span12">
	<div class="widget-box transparent">
		<div class="widget-header-small">
			<h4 class="title">Teamplay</h4>
		</div>
		<div class="widget-body">
			<div class="widget-main">
<small>
<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams">
{if $aStats}
<thead> 
<tr> 
<th>&nbsp;</th>
    <th>Player</th> 
	<th>&nbsp;</th>
    <th>Team</th> 
    <th align="center" width="35">GP</th> 
    <th align="center" width="35">G</th> 
    <th align="center" width="35">A</th>
	<th align="center" width="35">P</th>
	<th  width="35">+/-</th>		
	<th>PiM</th>
	<th width="30">Gpp</th>
	<th width="30">Gsh</th>
	<th width="30">GW</th>
	<th>Hits</th>
	<th align="center" width="30">S</th>	
	<th width="30">%S</th>
	<th width="35">Star</th>	
</tr> 
</thead> 
{assign var=num value=1}
{foreach from=$aStats item=oStat name=el2}
{assign var=team_id value=$oStat.team_id}
{assign var=oTeam value=$aTeams.$team_id}
{assign var=tournament_id value=$oStat.tournament_id}
{assign var=oTournament value=$aTournaments.$tournament_id}
<tr> 
	<td width="20" align="center">{$num}</td>
	<td width="250" align="left"><a href="{$oTournament->getUrlFull()}" title="{$oTournament->getName()}">{$oTournament->getName()} ({$oStat.round_name})</a></td> 
	<td width="37">{if $oStat.team_id>0}<a href="{$oTeam->getUrlFull()}" title="{$oTeam->getName()}"> <img style="height:20px;"  src="{cfg name='path.root.web'}/images/teams/{if $oStat.user_id==0}small{else}teamplay{/if}/{$oStat.team_logo}" alt="{$oTeam->getName()}"/></a>{/if}</td>
	<td align="center">{if $oStat.team_id>0}<a href="{$oTeam->getUrlFull()}" class="teamrasp" title="{$oTeam->getName()}">{$oStat.team_brief}</a>{/if}</td>
	<td align="center">{$oStat.games}</td>
	<td align="center">{$oStat.goals}</td> 
	<td align="center">{$oStat.assist}</td> 

	<td align="center" class="points"><b>{$oStat.points}</b></td>
	<td align="center">{$oStat.plus_minus}</td>

	<td align="center">{$oStat.penalty}</td>
	<td align="center">{$oStat.pp}</td>
	<td align="center">{$oStat.pk}</td>
	<td align="center">{$oStat.win_goal}</td>
	<td align="center">{$oStat.hits}</td>
	<td align="center">{$oStat.shots}</td>
	<td align="center">{$oStat.prcnt}</td>
	<td align="center">{$oStat.mv}</td>						
</tr>
{assign var=num value=$num+1}
{/foreach}
{/if}

{if $aStats_Goalkeeper}
<thead> 
<tr> 
    <th>&nbsp;</th>
    <th>Goalkeeper</th> 
	<th>&nbsp;</th> 
    <th>Team</th> 
    <th>GP</th> 
    <th>W</th> 
    <th >L</th> 
    <th >GAA</th>
    <th >SA</th>
 	<th >GA</th>
	<th >S</th>		
	<th >%S</th>
	<th >SO</th>
	<th >G</th>	
	<th >A</th>
	<th  >PiM</th>
	<th  >Star</th>
</tr> 
</thead> 
{assign var=num value=1}
{foreach from=$aStats_Goalkeeper item=oStat name=el2}
{assign var=team_id value=$oStat.team_id}
{assign var=oTeam value=$aTeams.$team_id}
{assign var=tournament_id value=$oStat.tournament_id}
{assign var=oTournament value=$aTournaments.$tournament_id}
<tr> 
	<td width="20" align="center">{$num}</td>
	<td width="250" align="left"><a href="{$oTournament->getUrlFull()}" title="{$oTournament->getName()}">{$oTournament->getName()} ({$oStat.round_name})</a></td> 
	<td width="37">{if $oStat.team_id>0}<a href="{$oTeam->getUrlFull()}" title="{$oTeam->getName()}"> <img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/{if $oStat.user_id==0}small{else}teamplay{/if}/{$oStat.team_logo}" alt="{$oTeam->getName()}"/></a>{/if}</td>
	<td align="center">{if $oStat.team_id>0}<a href="{$oTeam->getUrlFull()}" class="teamrasp" title="{$oTeam->getName()}">{$oStat.team_brief}</a>{/if}</td>
	<td align="center">{$oStat.games}</td>
	<td align="center">{$oStat.wins}</td> 
	<td align="center">{$oStat.loses}</td> 

	<td align="center" class="points"><b>{$oStat.sr_ga}</b></td>
	<td align="center">{$oStat.total_shots}</td>

	<td align="center">{$oStat.ga}</td>
	<td align="center">{$oStat.shots}</td>
	<td align="center">{$oStat.shots_prcn}</td>
	<td align="center">{$oStat.ibp}</td>
	<td align="center">{$oStat.goals}</td>
	<td align="center">{$oStat.assists}</td>
	<td align="center">{$oStat.penalty}</td>
	<td align="center">{$oStat.mv}</td>						
</tr>
{assign var=num value=$num+1}
{/foreach}
{/if}
</table>
</small>			
			</div>
		</div>
	</div>
</div>