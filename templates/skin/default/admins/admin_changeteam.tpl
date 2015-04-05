<div align="center"><b>{$oUser->getLogin()} меняем с </b></div>
{if $aTeamsintournament}
<table>
{foreach from=$aTeamsintournament item=oTeamsintournament name=el2}
{assign var=oTeam value=$oTeamsintournament->getTeam()}
{assign var=aUser value=$oTeamsintournament->getUser1()}
<tr>
	<td>
		{if $oTeam}<img height="20" src="http://virtualsports.ru/images/teams/small/{$oTeam->getLogo()}">{/if}
	</td>
	<td>
		{if $oTeam}{$oTeam->getName()}{/if} {$aUser->getLogin()} <a href="javascript:change_team('{$oTeamsintournament->getTournamentId()}','{$oUser->getId()}','{$oTeamsintournament->getPlayerId()}');">поменять</a>
	</td>
</tr>
{/foreach}
</table>
{/if}
