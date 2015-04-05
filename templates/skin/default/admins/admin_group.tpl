

<p> 
	<input type="text" class="input-wide autocomplete-teama" id="team" name="team"  />
	<a href="javascript:add_team(0,'team');">Добавить</a>
</p> 
{if $aTeams}
<table>
<tr>
<td></td>
<td></td>
<td>Конференция</td>
<td>Группа</td>
</tr>
{foreach from=$aTeams item=oTeamint name=el2}
<tr>
	<td>{if $oTeamint->getTeam()}{$oTeamint->getTeam()->getName()}{else}{$oTeamint->getUser1()->getLogin()}{/if}</td>
	{if $oTeamint->getTeam()}
	{$oTeam=$oTeamint->getTeam()}
	<td>
		<input type="text" id="team_att_{$oTeam->getTeamId()}" onchange="update_ratings('{$oTeam->getTeamId()}','att', this); return false;" style="width:30px;" value="{$oTeam->getAttackRating()}" SIZE="3" maxlength="3"/>
		<input type="text" id="team_mid_{$oTeam->getTeamId()}" onchange="update_ratings('{$oTeam->getTeamId()}','mid', this); return false;" style="width:30px;" value="{$oTeam->getMiddleRating()}" SIZE="3" maxlength="3"/>
		<input type="text" id="team_def_{$oTeam->getTeamId()}" onchange="update_ratings('{$oTeam->getTeamId()}','def', this); return false;" style="width:30px;" value="{$oTeam->getDefenseRating()}" SIZE="3" maxlength="3"/>
	</td>
	{/if}
	<td>
		<select class="w200" id="p2_{$oTeamint->getId()}" onchange="saveparentgroup('p2_{$oTeamint->getId()}', {$oTeamint->getId()}, {$oTeamint->getRoundId()});"> 
			{foreach from=$aGroups item=oGroup}
				<option value="{$oGroup->getGroupId()}" {if $oTeamint->getParentgroupId()==$oGroup->getGroupId()}SELECTED{/if}>{$oGroup->getName()}</option>
			{/foreach}
		</select>
	</td>
	<td>
		<select class="w200" id ="g2_{$oTeamint->getId()}" onchange="savegroup('g2_{$oTeamint->getId()}', {$oTeamint->getId()}, {$oTeamint->getRoundId()});"> 
			{foreach from=$aGroups item=oGroup}
				<option value="{$oGroup->getGroupId()}" {if $oTeamint->getGroupId()==$oGroup->getGroupId()}SELECTED{/if}>{$oGroup->getName()}</option>
			{/foreach}
		</select>	
	</td>
	<td> <a href="javascript:delete_teamtournament({$oTeamint->getId()});">Удалить команду</a></td>
</tr>
{/foreach}
</table>
{/if}

<br/>
<br/>
{*{if $aTeams_second}*}
<p> 
	<input type="text" class="input-wide autocomplete-teama" id="team2" name="team2"  />
	<a href="javascript:add_team(2,'team2');">Добавить во 2 раунд</a>
</p> 

<table>
<tr>
<td></td>
<td>Родительская гр.</td>
<td>Гр.</td>
</tr>
{foreach from=$aTeams_second item=oTeamint name=el2}
<tr>
	<td>{if $oTeamint->getTeam()}{$oTeamint->getTeam()->getName()}{else}{$oTeamint->getUser1()->getLogin()}{/if}</td>
	<td>
		<select class="w200" id="p_{$oTeamint->getId()}" onchange="saveparentgroup('p_{$oTeamint->getId()}', {$oTeamint->getId()}, {$oTeamint->getRoundId()});"> 
			{foreach from=$aGroups item=oGroup}
				<option value="{$oGroup->getGroupId()}" {if $oTeamint->getParentgroupId()==$oGroup->getGroupId()}SELECTED{/if}>{$oGroup->getName()}</option>
			{/foreach}
		</select>
	</td>
	<td>
		<select class="w200" id ="g_{$oTeamint->getId()}" onchange="savegroup('g_{$oTeamint->getId()}', {$oTeamint->getId()}, {$oTeamint->getRoundId()});"> 
			{foreach from=$aGroups item=oGroup}
				<option value="{$oGroup->getGroupId()}" {if $oTeamint->getGroupId()==$oGroup->getGroupId()}SELECTED{/if}>{$oGroup->getName()}</option>
			{/foreach}
		</select>	
	</td>
	<td> <a href="javascript:delete_teamtournament({$oTeamint->getId()});">Удалить команду</a></td>
</tr>
{/foreach}
</table>
{*{/if}*}

{*Создать 
<select class="w70" id="add_group_round" onchange="create_group_round();">
{foreach from=$aRounds item=oRound name=el2}
	<option value="{$oRound->getRoundId()}">{$oRound->getName()}</option>
{/foreach}
</select>*}