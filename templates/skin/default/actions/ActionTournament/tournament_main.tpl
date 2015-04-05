{include file='header.tpl' menu_content='tournament'}
{*
{if $bCloseBlog}
	<div class="padding">{$aLang.blog_close_show}</div>
{else}
	{include file='topic_list.tpl'}
{/if}
*}

<div class="span6">
<header class="block-header sep">
        <h3>Статьи</h3>
    </header>
{if $bCloseBlog}
	<div class="padding">{$aLang.blog_close_show}</div>
{else}
	{include file='topic_list_short.tpl'}
{/if}
</div>
<div class="span6">

    <header class="block-header sep">
        <h3><a class="links_head" href="{if $oTournament}{$oTournament->getUrlFull()}events/{/if}">Последние сыгранные</a></h3>
    </header>
	<small>
	<table width="100%" cellspacing="0" class="table">
		<thead>
	<tr>
		<th class="lside">Date</th>		
		<th class="cside" align="center">№</th>
		<th class="cside">Away</th>
		<th class="cside">Home</th>
		<th class="cside" align="center">Score</th>
		<th class="cside" align="center">Report</th>
	</tr>
	</thead>
	<tbody>
	{foreach from=$Indexmatches item=oStreamEvent}
	{assign var=oTarget value=$oStreamEvent->getWhat()}
	{assign var=oTournament value=$oTarget->getTournament()}
	{*{assign var=oAwayTeam value=$oTarget->getAwayteam()}
	{assign var=oHomeTeam value=$oTarget->getHometeam()}*}
	<tr>	
		<td align="center">{date_format date=$oStreamEvent->getDateAdd() format="d M"}</td>
		<td class="{$className}"  align="center">{$oTarget->getNumber()}</td>
		<td class="{$className}" >
			{if $oStreamEvent->getAwayName()}
				<img style="height:32px;width:32px;" src="{cfg name='path.root.web'}/images/teams/small/{$oStreamEvent->getAwayLogo()}" title="{$oStreamEvent->getAwayName()}" /> 
			{else}
				<img style="height:32px;width:32px;" src="{$oStreamEvent->getAwayUserProfileAvatar()}" title="{$oStreamEvent->getAwayPlayer()}" /> 
			{/if}
			</td>
		<td class="{$className}" >
			{if $oStreamEvent->getHomeName()}
				<img style="height:32px;width:32px;" src="{cfg name='path.root.web'}/images/teams/small/{$oStreamEvent->getHomeLogo()}" title="{$oStreamEvent->getHomeName()}" /> 
			{else}
				<img style="height:32px;width:32px;" src="{$oStreamEvent->getHomeUserProfileAvatar()}" title="{$oStreamEvent->getHomePlayer()}" /> 
			{/if}
		</td>
		<td class="{$className}" align="center">{$oTarget->getLeftGoals()} - {$oTarget->getRightGoals()} {$oTarget->getAdditionalResult()}</td>
		<td><a title="Match comments №{$oTarget->getNumber()} tournament {$oStreamEvent->getTournamentName()}({$oTarget->getCountComment()})" href="{$oTournament->getUrlFull()}match_comment/{$oTarget->getMatchId()}/" target="_blank" ><span class="badge badge-custom-comments ">{$oTarget->getCountComment()}</span></a> {if $oTarget->getWithVideo() ==1}<i class="icon-facetime-video"></i>{/if}</td>
	</tr>	
	{/foreach}
	</tbody>
	</table>
	</small>
</div>

{include file='footer.tpl'}