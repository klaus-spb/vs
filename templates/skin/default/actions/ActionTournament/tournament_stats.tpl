{include file='header.tpl' menu_content='tournament' noSidebar=true }
<style>
#sidebar {
display: none;
}
</style>
{if ($oTournament->getShowFullStatTable()+$oTournament->getShowGroupStatTable()+$oTournament->getShowParentStatTable())>1}
<div class="navstat1"> 
   <div class="navstat2"> 
		<ul class="nav nav-pills custom " style="">
		{if $oTournament->getShowFullStatTable()}	<li {if $table_type=="full"}class="active"{/if}><a href="{$oTournament->getUrlFull()}stats/full/">сводная</a></li>	{/if}
		{if $oTournament->getShowParentStatTable()}	<li {if $table_type=="conf"}class="active"{/if}><a href="{$oTournament->getUrlFull()}stats/conf/">по конференция</a></li>	{/if}
		{if $oTournament->getShowGroupStatTable()}	<li {if $table_type=="group"}class="active"{/if}><a href="{$oTournament->getUrlFull()}stats/group/">по группам/дивизионам</a></li>	{/if}
		</ul>
	</div>
</div>
{/if}
<small>
{if $Tournamentstat and $oTournament->getShowFullStatTable()!=0}

<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams">
<thead>
<tr>		
	<th class="cside" align="center">№</th>	
	<th class="cside" align="center"></th>
	<th class="cside">Team</th>
	<th class="cside"></th>
	<th class="cside" align="center" title="Game played">GP</th>
	<th class="cside" align="center" title="Wins">W</th>
	<th class="cside" align="center" title="Wins OT">WOT</th>
	<th class="cside" align="center" title="Wins SO">WSO</th>
	<th class="cside" align="center" title="Loses OT">LOT</th>
	<th class="cside" align="center" title="Loses SO">LSO</th>
	<th class="cside" align="center" title="Loses">L</th>
	<th class="cside" align="center" title="Points">P</th>
	<th class="cside" align="center" title="Wins on zero">WS</th>
	<th class="cside" align="center" title="Loses on zero">LS</th>
	<th class="cside" align="center" title="Pucks scored">PS</th>
	<th class="cside" align="center" title="Pucks attemp">PA</th>
	<th class="cside" align="center" title="±">±</th>
	<th class="cside" align="center" title="Pucks scored average">PSA</th>
	<th class="cside" align="center" title="Pucks attemp average">PAA</th>
	<th class="cside" align="center" title="Percent of taken points">%</th>
	<th class="cside" align="center" title="Last 10 games W-L-LO">L10</th>
	<th class="cside" align="center"></th> 

</tr>
</thead>
{foreach from=$Tournamentstat item=oTournamentstat name=el2}
{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=oTeamintournament value=$oTournamentstat->getTeamtournament()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
<tr> 
	<td class="{$className}"align="center">{$oTournamentstat->getPosition()}</td>	
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
		{else}
			{if $oTeam}
				<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
			{else}
				<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
			{/if}
		{/if}	
	</td>
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
		{/if}
	</td>	
	<td class="{$className}">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()}</td>
    <td class="{$className}" align="center">{$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}</td>	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()}</td>
    <td class="{$className}" align="center">{$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
	<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()|string_format:"%.0f"}</b></td>
	<td class="{$className}" align="center">{$oTournamentstat->getSuhW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getSuhL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGf()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGa()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGf()-$oTournamentstat->getGa()}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGf()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGa()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches && $oTournament->getWin()}{($oTournamentstat->getPoints()/($TotalMatches*$oTournament->getWin()) )|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getLastTen()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()+$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}-{$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td> 
</tr>
{/foreach}
</table>

{literal}
<script type="text/javascript"> 
  	$(document).ready(function() 
		{ 
			$("#allteams").tablesorter(); 
		} 
	); 
</script> 
{/literal}
{/if}

{*по группам*}
{if $aTournamentstatparentgroup and $oTournament->getShowParentStatTable()!=0}
{assign var=Parentgroup value=0}
{assign var=Group value=0}
{assign var=PrevGroup value=0}
{assign var=Position value=1}
{foreach from=$aTournamentstatparentgroup item=oTournamentstat name=el2}

{assign var=oParentgroup value=$oTournamentstat->getParentgroup()}
{if $oParentgroup->getGroupId()!=0}
	{if $oParentgroup->getGroupId() != $Parentgroup and $Parentgroup !=0}
	</table>
	{literal}
	<script type="text/javascript"> 
	$(document).ready(function() 
		{ 
			$("#allteams{/literal}{$Parentgroup}{literal}").tablesorter(); 
		} 
	); 
	  
	</script> 
	{/literal}
	{/if}
	
{if $oParentgroup->getGroupId() != $Parentgroup }
	{assign var=Position value=1}
	<br/>
	<p align="center"><b>{$oParentgroup->getName()}</b></p>	
	<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams{$oParentgroup->getGroupId()}">
	<thead>
 
	<tr> 
		<th class="cside" align="center">№</th>	
		<th class="cside" align="center"></th>
		<th class="cside">Team</th>
		<th class="cside"></th>
		<th class="cside" align="center">GP</th>
		<th class="cside" align="center">W</th>
		<th class="cside" align="center">WOT</th>
		<th class="cside" align="center">WSO</th>
		<th class="cside" align="center">LOT</th>
		<th class="cside" align="center">LSO</th>
		<th class="cside" align="center">L</th>
		<th class="cside" align="center">P</th>
		<th class="cside" align="center">WS</th>
		<th class="cside" align="center">LS</th>
		<th class="cside" align="center">PS</th>
		<th class="cside" align="center">PA</th>
		<th class="cside" align="center">±</th>
		<th class="cside" align="center">PSA</th>
		<th class="cside" align="center">PAA</th>
		<th class="cside" align="center">%</th>
		<th class="cside" align="center">L10</th> 
	</tr>
	</thead>
	{assign var=PrevGroup value=$Parentgroup}
	{assign var=Parentgroup value=$oParentgroup->getGroupId()}
{/if}	
{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=oTeamintournament value=$oTournamentstat->getTeamtournament()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
<tr>

	<td class="{$className}" align="center">{$Position}{if $oTournamentstat->getGrouplead()==1}*{/if}</td>	
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
		{else}
			{if $oTeam}
				<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
			{else}
				<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
			{/if}
		{/if}	
	</td>
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
		{/if}
	</td>
	<td class="{$className}">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()}</td>
    <td class="{$className}" align="center">{$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}</td>	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()}</td>
    <td class="{$className}" align="center">{$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
	<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()|string_format:"%.0f"}</b></td>
	<td class="{$className}" align="center">{$oTournamentstat->getSuhW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getSuhL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGf()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGa()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGf()-$oTournamentstat->getGa()}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGf()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGa()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches && $oTournament->getWin()}{($oTournamentstat->getPoints()/($TotalMatches*$oTournament->getWin()) )|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getLastTen()}</td>

</tr>
{assign var=Position value=$Position+1}
{/if}
{/foreach}
{if $Parentgroup !=0 }
</table>
{/if}

</table>
{literal}
<script type="text/javascript"> 
  	$(document).ready(function() 
		{ 
			$("#allteams{/literal}{$Parentgroup}{literal}").tablesorter(); 
		} 
	); 
 /* window.addEvent('domready',function(){ 
	var allteams = new HtmlTable($('allteams{/literal}{$Parentgroup}{literal}'));
	allteams.enableSort();
  }); // addEvent 
 */ 
</script> 
{/literal}
{/if}
{*по группам*}

{*по подгруппам*}
{assign var=Parentgroup value=0}
{assign var=Group value=0}
{assign var=PrevGroup value=0}
{assign var=Position value=1}

{if $aTournamentstatgroup and $oTournament->getShowGroupStatTable()!=0}
{foreach from=$aTournamentstatgroup item=oTournamentstat name=el2}
{assign var=oParentgroup value=$oTournamentstat->getParentgroup()}
{assign var=oGroup value=$oTournamentstat->getGroup()}
{if $oGroup->getGroupId()!=0}
	{if $oGroup->getGroupId() != $Group and $Group !=0}
	</table>
	{literal}
	<script type="text/javascript"> 
	  	$(document).ready(function() 
		{ 
			$("#allteams{/literal}{$Group}{literal}").tablesorter(); 
		} 
	); 
	/*  window.addEvent('domready',function(){ 
		var allteams = new HtmlTable($('allteams{/literal}{$Group}{literal}'));
		allteams.enableSort();
	  }); // addEvent 
	*/  
	</script> 
	{/literal}
	{/if}

	{if $oGroup->getGroupId() != $Group }
	{assign var=Position value=1}
	<br/>
	<p align="center"><b>{$oGroup->getName()}</b></p>
	<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams{$oGroup->getGroupId()}">
	<thead>
	<tr> 
		<th class="cside" align="center">№</th>	
		<th class="cside" align="center"></th>
		<th class="cside">Team</th>
		<th class="cside"></th>
		<th class="cside" align="center">GP</th>
		<th class="cside" align="center">W</th>
		<th class="cside" align="center">WOT</th>
		<th class="cside" align="center">WSO</th>
		<th class="cside" align="center">LOT</th>
		<th class="cside" align="center">LSO</th>
		<th class="cside" align="center">L</th>
		<th class="cside" align="center">P</th>
		<th class="cside" align="center">WS</th>
		<th class="cside" align="center">LS</th>
		<th class="cside" align="center">PS</th>
		<th class="cside" align="center">PA</th>
		<th class="cside" align="center">±</th>
		<th class="cside" align="center">PSA</th>
		<th class="cside" align="center">PAA</th>
		<th class="cside" align="center">%</th>
		<th class="cside" align="center">L10</th> 
	</tr>
	
	</thead>
	{assign var=PrevGroup value=$Group}
	{assign var=Group value=$oGroup->getGroupId()}
	{/if}
{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=oTeamintournament value=$oTournamentstat->getTeamtournament()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
<tr>

	<td class="{$className}"align="center">{$Position}</td>	
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
		{else}
			{if $oTeam}
				<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
			{else}
				<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">
			{/if}
		{/if}	
	</td>
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
		{/if}
	</td>
	<td class="{$className}">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()}</td>
    <td class="{$className}" align="center">{$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}</td>	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()}</td>
    <td class="{$className}" align="center">{$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
	<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()|string_format:"%.0f"}</b></td>
	<td class="{$className}" align="center">{$oTournamentstat->getSuhW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getSuhL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGf()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGa()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getGf()-$oTournamentstat->getGa()}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGf()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGa()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches && $oTournament->getWin()}{($oTournamentstat->getPoints()/($TotalMatches*$oTournament->getWin()) )|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getLastTen()}</td>

</tr>
{assign var=Position value=$Position+1}
{/if}
{/foreach}

{if $Group !=0 }
</table>
{/if}


{literal}
<script type="text/javascript"> 
	  	$(document).ready(function() 
		{ 
			$("#allteams{/literal}{$Group}{literal}").tablesorter(); 
		} 
	); 

</script> 
{/literal}
{/if}
</small>
{*по подгруппам*}
<script language="JavaScript" type="text/javascript">


</script>
{include file='footer.tpl'}