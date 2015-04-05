{include file='header.tpl' menu_content='tournament' noSidebar=true }
<style>
{literal}

#sidebar {
display: none;
}
#wrapper {
padding: 10px;
min-height: 1000px;
}
.metroBtn {
				background-color: #2E7BCC;
				color: #fff;
				font-size: 1.1em;
				padding: 10px;
				display: inline-block;
				margin-bottom: 30px;
				cursor: pointer;
			}
			.brackets > div {
				vertical-align: top;
				clear: both;
			}
			.brackets > div > div {
				float: left;
				height: 100%;
			}
			.brackets > div > div > div {
				margin: 50px 0;
			}
			.brackets div.bracketbox {
				position: relative;
				width: 100%; height: 100%;
				border-top: 1px solid #555;
				border-right: 1px solid #555;
				border-bottom: 1px solid #555;
			}
			.brackets div.bracketbox > span.info {
				position: absolute;
				top: 25%;
				left: 25%;
				font-size: 0.8em;
				color: #BBB;
			}
			.brackets div.bracketbox > span {
				position: absolute;
				left: 20px;
				font-size: 0.85em;
				background-color:#fff;
			}
			.brackets div.r1 div.bracketbox  > span.teama,.brackets div.r1 div.bracketbox  > span.teamb {
				left: 0px;
			}
			
			.brackets div.bracketbox > span.teama {
				top: -10px;
			}
			.brackets div.bracketbox > span.teamb {
				bottom: -10px;
			}
			.brackets div.bracketbox > span.teamc {
				bottom: 1px;
			}
			/*.brackets > .group2 {
				height: 260px;
			}*/
			.brackets > .group2 > div {
				width: 49%;
			}
			/*.brackets > .group3 {
				height: 320px;
			}*/
			.brackets > .group3 > div {
				width: 32.7%;
			}
			.brackets > .group4 > div {
				width: 24.5%;
			}
			.brackets > .group5 > div {
				width: 19.6%;
			}
			.brackets > .group6 {
				height: 2000px;
			}
			.brackets > .group6 > div {
				width: 16.3%;
			}
			.brackets > div > .r1 > div {
				height: 60px;
			}
			.brackets > div > .r2 > div {
				margin: 80px 0 110px 0;
				height: 110px;
			}
			.brackets > div > .r3 > div {
				margin: 135px 0 220px 0;
				height: 220px;
			}
			.brackets > div > .r4 > div {
				margin: 250px 0 445px 0;
				height: 445px;
			}
			.brackets > div > .r5 > div {
				margin: 460px 0 0 0;
				height: 900px;
			}
			.brackets > div > .r6 > div {
				margin: 900px 0 0 0;
			}
			.brackets div.final > div.bracketbox {
				border-top: 0px;
				border-right: 0px;
				height: 0px;
			}
			.brackets > div > .r4 > div.drop {
				height: 180px;
				margin-bottom: 0px;
			}
			.brackets > div > .r5 > div.final.drop {
				margin-top: 345px;
				margin-bottom: 0px;
				height: 1px;
			}
			.brackets > div > div > div:last-of-type {
				margin-bottom: 0px;
			}
			
			.brackets div.bracketbox  > span.seriea,.brackets div.bracketbox  > span.serieb {
				right: 5px;
				left: inherit;
				font-size: 1em;
				font-weight: 700;
				width: 20px;
				text-align: center;
			}
			
			.brackets div.bracketbox > span.seriea {
				top: -10px;
			}
			.brackets div.bracketbox > span.serieb {
				bottom: -10px;
			}
			
</style>
{/literal}

<div class="brackets" id="brackets">
{if $aPlayoff}
{assign var=key value=0}
{assign var=round value=''}
{foreach from=$aPlayoff item=oPlayoff name=el2}
{if $round!=$oPlayoff.round and $round!=''} 
	</div>	
{/if}

{if $key==0}
	{assign var=group value=$oPlayoff.round|substr:2}
	{if $group=='32'} 
		<div class="group6" id="b0">
	{elseif $group=='16'}
		<div class="group5" id="b0"> 
	{elseif $group=='8'}
		<div class="group4" id="b0"> 
	{elseif $group=='4'}
		<div class="group3" id="b0"> 
	{elseif $group=='2'}
		<div class="group2" id="b0">  
	{else}
		<div class="group1" id="b0">
	{/if}
{/if}

{if $round!=$oPlayoff.round}
{assign var=key value=$key+1} 
	<div class="r{$key}">

{assign var=round value=$oPlayoff.round}
{/if}
			<div>
				<div class="bracketbox">
					{if $oGame->getSportId()=='1' || $oGame->getSportId()=='3'}
						<span class="seriea {if $oPlayoff.matches_played.0.match_id<>""}create-tooltip{/if}" title="{foreach from=$oPlayoff.matches_played item=match name=el2}
								{if $match.match_id}
									<a href='{$oTournament->getUrlFull()}match_comment/{$match.match_id}' target='_blank'>{$match.results_converted}</a><br/>
								{/if}
							{/foreach}"><a href="{$oTournament->getUrlFull()}shedule/?f=1&{if $oPlayoff.team && $oPlayoff.team_2}teams[]={$oPlayoff.team->getTeamId()}&teams[]={$oPlayoff.team_2->getTeamId()}{elseif $oPlayoff.user && $oPlayoff.user_2}players[]={$oPlayoff.user->getId()}&players[]={$oPlayoff.user_2->getId()}{/if}&round=100&&round_po={$oPlayoff.round}">{$oPlayoff.wins|number_format}</a></span>						
						<span class="serieb {if $oPlayoff.matches_played.0.match_id<>""}create-tooltip{/if}" title="{foreach from=$oPlayoff.matches_played item=match name=el2}
								{if $match.match_id}
									<a href='{$oTournament->getUrlFull()}match_comment/{$match.match_id}' target='_blank'>{$match.results_converted}</a><br/>
								{/if}
							{/foreach}"><a href="{$oTournament->getUrlFull()}shedule/?f=1&{if $oPlayoff.team && $oPlayoff.team_2}teams[]={$oPlayoff.team->getTeamId()}&teams[]={$oPlayoff.team_2->getTeamId()}{elseif $oPlayoff.user && $oPlayoff.user_2}players[]={$oPlayoff.user->getId()}&players[]={$oPlayoff.user_2->getId()}{/if}&round=100&&round_po={$oPlayoff.round}">{$oPlayoff.wins_2|number_format}</a></span>
					{else}
						<span class="info">
						{if $oGame->getSportId()=='2'}
							{foreach from=$oPlayoff.matches_played item=match name=el2}
								{if $match.match_id}
									<a href="{$oTournament->getUrlFull()}match_comment/{$match.match_id}" target="_blank" title="{$match.results_converted}">{$match.results_converted}</a>
								{/if}
							{/foreach}
						{elseif $oGame->getSportId()=='6'}
							{foreach from=$oPlayoff.matches_played item=match name=el2}
								{if $match.match_id}
									<td width="10"><a href="{$oTournament->getUrlFull()}match_comment/{$match.match_id}" target="_blank" >{if $match.goals_l==2}W{/if}{if $match.goals_l==0}L{/if} - {if $match.goals_r==2}W{/if}{if $match.goals_r==0}L{/if}</a> </td>
								{/if}
							{/foreach}
						{else}
							<td width="20"><a href="{$oTournament->getUrlFull()}shedule/?f=1&{if $oPlayoff.team && $oPlayoff.team_2}teams[]={$oPlayoff.team->getTeamId()}&teams[]={$oPlayoff.team_2->getTeamId()}{elseif $oPlayoff.user && $oPlayoff.user_2}players[]={$oPlayoff.user->getId()}&players[]={$oPlayoff.user_2->getId()}{/if}&round=100&&round_po={$oPlayoff.round}">{$oPlayoff.wins|number_format} / {$oPlayoff.wins_2|number_format}</a></td>
						{/if}
					{/if}
					
					
					</span>
					<span class="teama">
						{if $oPlayoff.team}
							<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oPlayoff.team->getLogo()}"/>
							{if $oPlayoff.wins== '4'}<b>{/if}<a href="{if $oPlayoff.team->getBlog()}{$oPlayoff.team->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oPlayoff.team->getTeamId()}{/if}" class="teamrasp">{$oPlayoff.team->getName()}</a>{if $oPlayoff.wins== '4'}</b>{/if}
						{/if}
						{if $oPlayoff.user}
							<img style="height:20px; width:20px;" src="{$oPlayoff.user->getAvatarUrl()}">
							{$oPlayoff.user->getLogin()}
						{/if}
					</span>
					<span class="teamb">
						{if $oPlayoff.team_2}
							<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oPlayoff.team_2->getLogo()}"/>
							{if $oPlayoff.wins_2== '4'}<b>{/if}<a href="{if $oPlayoff.team_2->getBlog()}{$oPlayoff.team_2->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oPlayoff.team_2->getTeamId()}{/if}" class="teamrasp">{$oPlayoff.team_2->getName()}</a>{if $oPlayoff.wins_2== '4'}</b>{/if}
						{/if}
						{if $oPlayoff.user_2}
							<img style="height:20px; width:20px;" src="{$oPlayoff.user_2->getAvatarUrl()}">
							{$oPlayoff.user_2->getLogin()}
						{/if}
					</span>
				</div>
			</div>
			


{/foreach}
	</div>		
{/if}
</div>

{include file='footer.tpl'} 