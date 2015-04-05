{assign var=HomeTeam value=$oMatch->getHometeam()}
{assign var=AwayTeam value=$oMatch->getAwayteam()}
{if $oMatch->getPlayed()==1}	
	{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
		<li><a class="ddm" href="{$oTournament->getUrlFull()}match_comment/{$oMatch->getMatchId()}">{$aLang.plugin.vs.commentsg}</a></li>
		<li><a class="ddm" href="javascript:result_otchet({$oMatch->getMatchId()});">{$aLang.plugin.vs.game_report}</a></li>
	{else}	
		<li><a class="ddm" href="{$oTournament->getUrlFull()}match_comment/{$oMatch->getMatchId()}">{$aLang.plugin.vs.game_report}</a></li>
	{/if}
{/if}
{if $oMatch->getPlayed()==0 && ( $myteam!=0 || $myteamtournament!=0)}
	{if $myteamtournament==$oMatch->getAwayTeamtournament() && $oMatch->getAwayInsert()==0} 
		<li><a class="ddm" href="{$oTournament->getUrlFull()}match/{$oMatch->getMatchId()}">{$aLang.plugin.vs.suggest_time}</a></li>
		{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
			<li><a class="ddm" href="javascript:result_insert({$oMatch->getMatchId()},{$myteamtournament},0);">{$aLang.plugin.vs.submit_result}</a></li>
		{else}	
			<li><a class="ddm" href="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}">{$aLang.plugin.vs.submit_result}</a></li>
		{/if}
	{/if}
	{if $myteamtournament==$oMatch->getHomeTeamtournament() && $oMatch->getHomeInsert()==0}
		{*<li><a class="ddm" href="{$oTournament->getUrlFull()}match/{$oMatch->getMatchId()}">{$aLang.plugin.vs.suggest_time}</a>*}
		{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
			<li><a class="ddm" href="javascript:result_insert({$oMatch->getMatchId()},{$myteamtournament},0);">{$aLang.plugin.vs.submit_result}</a></li>
		{else}	
			<li><a class="ddm" href="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}">{$aLang.plugin.vs.submit_result}</a></li>
		{/if}
	{/if}
{/if}
{if $myteamtournament==$oMatch->getAwayTeamtournament() || $isAdmin || $myteamtournament==$oMatch->getHomeTeamtournament()}
	<li><a class="ddm" href="javascript:result_insertvideo({$oMatch->getMatchId()});">{$aLang.plugin.vs.add_video}</a></li>
{/if}
{if $isAdmin==1}	
	{if $oMatch->getAwayInsert()==0}		
		{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
			<li><a class="ddm" href="javascript:result_edit({$oMatch->getMatchId()},{$oMatch->getAwayTeamtournament()});">{$aLang.plugin.vs.submit} {if $AwayTeam}{$AwayTeam->getName()}{else}команда слева{/if}</a></li>
		{else}	
			<li><a class="ddm" href="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}/{$oMatch->getAwayTeamtournament()}">{$aLang.plugin.vs.submit} {if $AwayTeam}{$AwayTeam->getName()}{else}команда слева{/if}</a></li>
		{/if}
	{else}
		{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
			<li><a class="ddm" href="javascript:result_edit({$oMatch->getMatchId()},{$oMatch->getAwayTeamtournament()});">{$aLang.plugin.vs.edit} {if $AwayTeam}{$AwayTeam->getName()}{else}команда слева{/if}</a></li>
		{else}	
			<li><a class="ddm" href="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}/{$oMatch->getAwayTeamtournament()}">{$aLang.plugin.vs.edit} {if $AwayTeam}{$AwayTeam->getName()}{else}команда слева{/if}</a></li>
		{/if}
		<li><a class="ddm" href="javascript:result_team_delete({$oMatch->getMatchId()},{$oMatch->getAwayTeamtournament()});">{$aLang.plugin.vs.delete} {if $AwayTeam}{$AwayTeam->getName()}{else}команда слева{/if}</a></li>
	{/if}
	{if $oMatch->getHomeInsert()==0}
		{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
			<li><a class="ddm" href="javascript:result_edit({$oMatch->getMatchId()},{$oMatch->getHomeTeamtournament()});">{$aLang.plugin.vs.submit} {if $HomeTeam}{$HomeTeam->getName()}{else}команда справа{/if}</a></li>
		{else}	
			<li><a class="ddm" href="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}/{$oMatch->getHomeTeamtournament()}">{$aLang.plugin.vs.submit}  {if $HomeTeam}{$HomeTeam->getName()}{else}команда справа{/if}</a></li>
		{/if}
	{else}
		{if $oMatch->getGametypeId()!=3 && $oMatch->getGametypeId()!=7 && $oMatch->getGametypeId()!=8}
			<li><a class="ddm" href="javascript:result_edit({$oMatch->getMatchId()},{$oMatch->getHomeTeamtournament()});">{$aLang.plugin.vs.edit}  {if $HomeTeam}{$HomeTeam->getName()}{else}команда справа{/if}</a></li>
		{else}	
			<li><a class="ddm" href="{$oTournament->getUrlFull()}match_insert/{$oMatch->getMatchId()}/{$oMatch->getHomeTeamtournament()}">{$aLang.plugin.vs.edit}  {if $HomeTeam}{$HomeTeam->getName()}{else}команда справа{/if}</a></li>
		{/if}		
		<li><a class="ddm" href="javascript:result_team_delete({$oMatch->getMatchId()},{$oMatch->getHomeTeamtournament()});">{$aLang.plugin.vs.delete}  {if $HomeTeam}{$HomeTeam->getName()}{else}команда справа{/if}</a></li>
	{/if}
		<li><a class="ddm" href="javascript:match_lookup({$oMatch->getMatchId()});">{$aLang.plugin.vs.timelog}</a></li>
	{if $oMatch->getPlayed()==1}			
		<li><a class="ddm" href="javascript:result_anul({$oMatch->getMatchId()});">{$aLang.plugin.vs.delete_result}</a></li>
		<li><a class="ddm" href="javascript:result_anul_without_pred({$oMatch->getMatchId()});">{$aLang.plugin.vs.delete_result_keep}</a></li>
	{/if}
	
	{if $oMatch->getAwayInsert()==0 && $oMatch->getHomeInsert()==0}
		<li><a class="ddm" href="javascript:match_prolong({$oMatch->getMatchId()});">{$aLang.plugin.vs.prolong_game}</a></li>
	{/if}
		<li><a class="ddm" href="javascript:match_perenos({$oMatch->getMatchId()}, {$oMatch->getDates()|date_format:"%Y,%m,%d,%k,%M"});">{$aLang.plugin.vs.redate_game}</a></li>
	
{/if}
