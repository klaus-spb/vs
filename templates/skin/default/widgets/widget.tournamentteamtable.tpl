<div class="block">

<style>
.downArrow {
width: 0;
height: 0;
border-left: 6px solid transparent;
border-right: 6px solid transparent;
border-top: 10px solid #c33;
}
.upArrow {
width: 0;
height: 0;
border-left: 6px solid transparent;
border-right: 6px solid transparent;
border-bottom: 10px solid #393;
}

.rankingMovement {
display: inline-block;
zoom: 1;
width: 40px;
font-size: 11px;
font-weight: bold;
}
.movementMarker {
display: inline-block;
zoom: 1;
width: 10px;
font-weight: normal;
padding-left: 2px;
}

</style>
    <header class="block-header sep">
        <h3><a class="links_head" href="{$oTournament->getUrlFull()}stats/">Top {$number}</a></h3>
    </header>
 

{if $oGame && $oGame->getSportId()==4}
{if $PlayerTable} 
	<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover">
	<thead>
	<tr>
		<th class="cside" align="center">№</th>	 
		<th class="cside" align="center">Гонщик</th> 
		<th class="cside" align="center"></th>
		<th class="cside" align="center">O</th>
	</tr>
	</thead>
	{assign var=num value=1}
	{foreach from=$PlayerTable item=oTournamentstat name=el2}
	{if $smarty.foreach.el2.iteration % 2  == 0}
		{assign var=className value='odd'}
	{else}
		{assign var=className value='even'}
	{/if}
	{assign var=oTeam value=$oTournamentstat->getTeam()}
	{assign var=oUser value=$oTournamentstat->getUser()}
	{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
	<tr class="{$className}">
		<td width="25" align="center">{$num}</td>	
		<td><a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a></td>
		<td width="25"><img width="70" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/></td>
		<td align="center" width="20">{$oTournamentstat->getPoints()|string_format:"%.0f"}</td>
	</tr>
	{assign var=num value=$num+1}
	{/foreach}


	</table> 
	
{/if}
{else}
{if $TournamentTable}
	{if $oGame && $oGame->getSportId()==6}
		<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th class="cside" align="center">№</th>	
			<th class="cside" align="center"></th>
			<th class="cside" align="left">Team</th>
			{*<th class="cside" align="center">P</th>*}
		</tr>
		</thead>
		{foreach from=$TournamentTable item=oTournamentstat name=el2}
			{if $smarty.foreach.el2.iteration % 2  == 0}
				{assign var=className value='odd'}
			{else}
				{assign var=className value='even'}
			{/if}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
			{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
			<tr class="{$className}">
				<td width="25" >{$oTournamentstat->getPosition()}	
					
				</td>	
				<td width="25">
					{if $oTeam}
						<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
					{else}
						<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
					{/if}
				</td>
				<td>{if $oTeam}
						<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
					{else}
						<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
					{/if}
					{if $oTournamentstat->getTitul()==1} (C){/if}
					{if $oTournamentstat->getPositionDiff()}	
					<div class="rankingMovement">		
							<div class="movementMarker">			
									<div class="{if $oTournamentstat->getPositionDiff()>0}upArrow{else}downArrow{/if}"></div>				
							</div>			
						{abs($oTournamentstat->getPositionDiff())}				
					</div>
					{/if}
				</td>	
				{*<td align="center" width="20">{$oTournamentstat->getPoints()|string_format:"%.2f"}</td>*}
				
			</tr>
		{/foreach}
		</table>
	{elseif $oGame && $oGame->getSportId()==5}
		<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover">
		<thead>
		<tr>	
			<th class="cside" align="center"></th>
			<th class="cside" align="left">Team</th>
			<th class="cside" align="center">W</th>
			<th class="cside" align="center">L</th>
			<th class="cside" align="center">T</th>			
			<th class="cside" align="center">PCT</th>
		</tr>
		</thead>
		{foreach from=$TournamentTable item=oTournamentstat name=el2}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
			{if $smarty.foreach.el2.iteration % 2  == 0}
				{assign var=className value='odd'}
			{else}
				{assign var=className value='even'}
			{/if}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
			<tr class="{$className}">	
				<td width="25">
				
				{if $oTeam}
						<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
					{else}
						<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
					{/if}				
					{*<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>*}</td>
				<td>{if $oTeam}
						<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
					{else}
						<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
					{/if}
					{*<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>*}</td>
					<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
					<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
					<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>
					
					<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()}</b></td>
			</tr>
		{/foreach}
		</table>
		{elseif $oGame && $oGame->getSportId()==3}
		<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover">
		<thead>
		<tr>	
			<th class="cside" align="center"></th>
			<th class="cside" align="left">Team</th>
			<th class="cside" align="center">W</th>
			<th class="cside" align="center">L</th>
			{*<th class="cside" align="center">T</th>*}			
			<th class="cside" align="center">PCT</th>
		</tr>
		</thead>
		{foreach from=$TournamentTable item=oTournamentstat name=el2}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
			{if $smarty.foreach.el2.iteration % 2  == 0}
				{assign var=className value='odd'}
			{else}
				{assign var=className value='even'}
			{/if}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
			{assign var=Wins value=($oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() + $oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot())}
			<tr class="{$className}">	
				<td width="25">
				
				{if $oTeam}
						<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
					{else}
						<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
					{/if}				
					{*<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>*}</td>
				<td>{if $oTeam}
						<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
					{else}
						<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
					{/if}
					{*<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>*}</td>
					<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()+$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()}</td>
					<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()}</td>
					{*<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>*}
					
					<td class="{$className}" align="center"><b>{if $TotalMatches}{($Wins/$TotalMatches*100)|string_format:"%.1f"}{else}0.0{/if}%</b></td>
			</tr>
		{/foreach}
		</table>

	{else}
		<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover">
		<thead>
		<tr>
			<th class="cside" align="center">№</th>	
			<th class="cside" align="center"></th>
			<th class="cside" align="left">Team</th>
			<th class="cside" align="center">M</th>
			<th class="cside" align="center">P</th>
		</tr>
		</thead>
		{foreach from=$TournamentTable item=oTournamentstat name=el2}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
			{if $smarty.foreach.el2.iteration % 2  == 0}
				{assign var=className value='odd'}
			{else}
				{assign var=className value='even'}
			{/if}
			{assign var=oTeam value=$oTournamentstat->getTeam()}
			{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
			<tr class="{$className}">
				<td width="25" align="center">{$oTournamentstat->getPosition()}</td>	
				<td width="25">
				
				{if $oTeam}
						<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
					{else}
						<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
					{/if}				
					{*<img style="height:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>*}</td>
				<td>{if $oTeam}
						<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
					{else}
						<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
					{/if}
					{*<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>*}</td>
				<td align="center" width="20">{$TotalMatches}</td>
				<td align="center" width="20">{$oTournamentstat->getPoints()|string_format:"%.0f"}</td>
			</tr>
		{/foreach}
		</table>
	{/if}		
 
	
{/if}

{/if}
 
</div>