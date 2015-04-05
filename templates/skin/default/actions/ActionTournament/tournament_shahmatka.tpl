{include file='header.tpl' menu_content='tournament' noSidebar=true }
<style>
#sidebar {
display: none;
}
</style>
{*<br/>
<a href="{$link_stats}#tour-menu">Перейти к турниру</a>
<br/><br/>*}
<small> 
{if $groups}
{foreach from=$groups item=group name=el2}
	{if $aGroups}
		{assign var=oGroup value=$aGroups.$group} 
		<h3>{$oGroup->getName()}</h3>
	{/if}
	<table  class="table table-striped table-bordered table-hover">
		<tr>
			<td width="32"></td>
			{foreach from=$teams.$group item=team} 
				<td>
				{if $team.name}
					<img style="height:32px;width:32px;" title="{$team.name}" src="{cfg name='path.root.web'}/images/teams/small/{$team.logo}"/> 
				{else}
					<img style="height:32px;width:32px;" src="{$team.user_avatar}" title="{$team.user_login}" /> 
				{/if}
				
				</td>
			{/foreach}
		</tr>
	{foreach from=$teams.$group key=num_home item=i}
		{assign var=team_home_id value=$teams.$group[$num_home].id} 
		<tr>
			<td>
				{if $teams.$group[$num_home].name}
					<img style="height:32px;width:32px;" title="{$teams.$group[$num_home].name}" src="{cfg name='path.root.web'}/images/teams/small/{$teams.$group[$num_home].logo}"/>
				{else}
					<img style="height:32px;width:32px;" src="{$teams.$group[$num_home].user_avatar}" title="{$teams.$group[$num_home].user_login}" /> 
				{/if}
			
			</td> 
			{foreach from=$teams.$group key=num_away item=i}
				{assign var=team_away_id value=$teams.$group[$num_away].id} 
				<td style="vertical-align:top;{if $num_away==$num_home} background-color: #ccc;{/if}">  
				{if is_array($wins.$group[$team_home_id][$team_away_id])}
					{foreach from=$wins.$group[$team_home_id][$team_away_id] item=result}
						{$result}</br>
					{/foreach}
				{else}{/if}
				{if is_array($loses.$group[$team_home_id][$team_away_id])}
					{foreach from=$loses.$group[$team_home_id][$team_away_id] item=result}
						{$result}</br>
					{/foreach}
				{else}{/if} 
				</td>
			{/foreach}
		</tr>
	{/foreach}
	</table>
	<br/>
{/foreach} 
{/if}

{if $groups_svod}
{foreach from=$groups_svod item=group name=el2}

	<table  class="table table-striped table-bordered table-hover">
		<tr>
			<td width="20"></td>
			{foreach from=$teams_svod.$group item=team} 
				<td>
				{if $team.name}
					<img style="height:20px;width:20px;" title="{$team.name}" src="{cfg name='path.root.web'}/images/teams/small/{$team.logo}"/> 
				{else}
					<img style="height:20px;width:20px;" src="{$team.user_avatar}" title="{$team.user_login}" /> 
				{/if}
				
				</td>
			{/foreach}
		</tr>
	{foreach from=$teams_svod.$group key=num_home item=i}
		{assign var=team_home_id value=$teams_svod.$group[$num_home].id} 
		<tr>
			<td>
				{if $teams_svod.$group[$num_home].name}
					<img style="height:20px;width:20px;" title="{$teams_svod.$group[$num_home].name}" src="{cfg name='path.root.web'}/images/teams/small/{$teams_svod.$group[$num_home].logo}"/>
				{else}
					<img style="height:20px;width:20px;" src="{$teams_svod.$group[$num_home].user_avatar}" title="{$teams_svod.$group[$num_home].user_login}" /> 
				{/if}
			
			</td> 
			{foreach from=$teams_svod.$group key=num_away item=i}
				{assign var=team_away_id value=$teams_svod.$group[$num_away].id} 
				<td style="vertical-align:top; min-width:25px;padding:1px; font-size:8px;{if $num_away==$num_home} background-color: #ccc;{/if}">  
				{if is_array($wins_svod.$group[$team_home_id][$team_away_id])}
					{foreach from=$wins_svod.$group[$team_home_id][$team_away_id] item=result}
						{$result}</br>
					{/foreach}
				{else}{/if}
				{if is_array($loses_svod.$group[$team_home_id][$team_away_id])}
					{foreach from=$loses_svod.$group[$team_home_id][$team_away_id] item=result}
						{$result}</br>
					{/foreach}
				{else}{/if} 
				</td>
			{/foreach}
		</tr>
	{/foreach}
	</table>
	<br/>
{/foreach} 
{/if}
</small>
{include file='footer.tpl'}