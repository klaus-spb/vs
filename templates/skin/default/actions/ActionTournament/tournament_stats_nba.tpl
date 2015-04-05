{include file='header.tpl' menu_content='tournament' noSidebar=true }
<style>
#sidebar {
display: none;
}
.navstat1 { 
    width:100%; 
	padding-bottom: 30px;
} 
.navstat2 { 
    float:right; 
    right:50%; 
    position:relative; 
} 
.navstat2 ul { 
    float:left; 
    left:50%; 
    position:relative; 
} 
tr.under td {
	border-bottom: 1px solid black;
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
	<th class="cside">User</th>
	<th class="cside" align="center">G</th>
	<th class="cside" align="center">W</th>
	<th class="cside" align="center">L</th>
	<th class="cside" align="center">GB</th>
	<th class="cside" align="center">PCT</th>	
	<th class="cside" align="center">Home</th>
	<th class="cside" align="center">Road</th>	
{if $oTournament->getShowGroupStatTable()}	<th class="cside" align="center">Div</th>{/if}
{if $oTournament->getShowParentStatTable()}	<th class="cside" align="center">Conf</th>{/if}
	<th class="cside" align="center">PFA</th>
	<th class="cside" align="center">PAA</th>
	<th class="cside" align="center">DIFF</th>
	<th class="cside" align="center">L10</th>
</tr>
</thead>
{assign var=Max_diff value=0}
{foreach from=$Tournamentstat item=oTournamentstat name=el2}
	{if $oTournamentstat->getDifWinLose()>$Max_diff}{$Max_diff = $oTournamentstat->getDifWinLose()}{/if}
{/foreach}
{foreach from=$Tournamentstat item=oTournamentstat name=el2}

{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=oTeamintournament value=$oTournamentstat->getTeamtournament()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
{assign var=Wins value=($oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() + $oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot())}
{assign var=Loses value=($oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+ $oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot())}
<tr>
	<td class="{$className}" width="25" align="center">{if $oTournamentstat->getPosition()}{$oTournamentstat->getPosition()}{/if}</td>	
	<td class="{$className}" width="30">
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
	<td class="{$className}" width="150">
		{if $oTournament->getKnownTeams()!=3}
			<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
		{/if}
	</td>
	<td class="{$className}" width="100">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$Wins}</td>
	<td class="{$className}" align="center">{$Loses}</td>
	<td class="{$className}" align="center">{if ($Max_diff - $oTournamentstat->getDifWinLose())}{($Max_diff - $oTournamentstat->getDifWinLose())/2}{else}-{/if}</td>
	<td class="{$className}" align="center"><b>{if $TotalMatches}{($Wins/$TotalMatches)|string_format:"%.3f"}{else}0.000{/if}</b></td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getHomeWot()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getHomeLot()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getAwayW()+$oTournamentstat->getAwayWot()}-{$oTournamentstat->getAwayL()+$oTournamentstat->getAwayLot()}</td>

{if $oTournament->getShowGroupStatTable()}<td class="{$className}" align="center">{$oTournamentstat->getDivW()+$oTournamentstat->getDivWot()}-{$oTournamentstat->getDivL()+$oTournamentstat->getDivLot()}</td>{/if}
{if $oTournament->getShowParentStatTable()}<td class="{$className}" align="center">{$oTournamentstat->getConfW()+$oTournamentstat->getConfWot()}-{$oTournamentstat->getConfL()+$oTournamentstat->getConfLot()}</td>{/if}
	
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGf()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGa()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{if ($oTournamentstat->getGf()-$oTournamentstat->getGa())>0}+{/if}{(($oTournamentstat->getGf()/$TotalMatches)-($oTournamentstat->getGa()/$TotalMatches))|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getLastTen()}</td>
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
{if $aTournamentstatparentgroup}
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
	
{if $oParentgroup->getGroupId() != $Parentgroup}
	{assign var=Position value=1}
	<br/>
	<p align="center"><b>{$oParentgroup->getName()}</b></p>	
	<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams{$oParentgroup->getGroupId()}">
<thead>
<tr>
	<th class="cside" align="center">№</th>	
	<th class="cside" align="center"></th>
	<th class="cside">Team</th>
	<th class="cside">User</th>
	<th class="cside" align="center">G</th>
	<th class="cside" align="center">W</th>
	<th class="cside" align="center">L</th>
	<th class="cside" align="center">GB</th>
	<th class="cside" align="center">PCT</th>	
	<th class="cside" align="center">Home</th>
	<th class="cside" align="center">Road</th>	
{if $oTournament->getShowGroupStatTable()}	<th class="cside" align="center">Div</th>{/if}
{if $oTournament->getShowParentStatTable()}	<th class="cside" align="center">Conf</th>{/if}
	<th class="cside" align="center">PFA</th>
	<th class="cside" align="center">PAA</th>
	<th class="cside" align="center">DIFF</th>
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
{assign var=Wins value=($oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() + $oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot())}
{assign var=Loses value=($oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+ $oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot())}
<tr {if $Position==8}class="under"{/if}>
	<td class="{$className}" width="25" align="center">{$Position}{if $oTournamentstat->getGrouplead()==1}*{/if}</td>	
	<td class="{$className}" width="30">
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
	<td class="{$className}" width="150">
		{if $oTournament->getKnownTeams()!=3}
			<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
		{/if}
	</td>
	<td class="{$className}" width="100">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$Wins}</td>
	<td class="{$className}" align="center">{$Loses}</td>
	<td class="{$className}" align="center">{if ($group_record.$Parentgroup - $oTournamentstat->getDifWinLose())}{($group_record.$Parentgroup - $oTournamentstat->getDifWinLose())/2}{else}-{/if}</td>
	<td class="{$className}" align="center"><b>{if $TotalMatches}{($Wins/$TotalMatches)|string_format:"%.3f"}{else}0.000{/if}</b></td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getHomeWot()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getHomeLot()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getAwayW()+$oTournamentstat->getAwayWot()}-{$oTournamentstat->getAwayL()+$oTournamentstat->getAwayLot()}</td>

{if $oTournament->getShowGroupStatTable()}<td class="{$className}" align="center">{$oTournamentstat->getDivW()+$oTournamentstat->getDivWot()}-{$oTournamentstat->getDivL()+$oTournamentstat->getDivLot()}</td>{/if}
{if $oTournament->getShowParentStatTable()}<td class="{$className}" align="center">{$oTournamentstat->getConfW()+$oTournamentstat->getConfWot()}-{$oTournamentstat->getConfL()+$oTournamentstat->getConfLot()}</td>{/if}
	
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGf()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGa()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{if ($oTournamentstat->getGf()-$oTournamentstat->getGa())>0}+{/if}{(($oTournamentstat->getGf()/$TotalMatches)-($oTournamentstat->getGa()/$TotalMatches))|string_format:"%.1f"}{else}0{/if}</td>
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

{if $aTournamentstatgroup}
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

	{if $oGroup->getGroupId() != $Group}
	{assign var=Position value=1}
	<br/>
	<p align="center"><b>{$oGroup->getName()}</b></p>
	<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams{$oGroup->getGroupId()}">
<thead>
<tr>
	<th class="cside" align="center">№</th>	
	<th class="cside" align="center"></th>
	<th class="cside">Team</th>
	<th class="cside">User</th>
	<th class="cside" align="center">G</th>
	<th class="cside" align="center">W</th>
	<th class="cside" align="center">L</th>
	<th class="cside" align="center">GB</th>
	<th class="cside" align="center">PCT</th>	
	<th class="cside" align="center">Home</th>
	<th class="cside" align="center">Road</th>	
{if $oTournament->getShowGroupStatTable()}	<th class="cside" align="center">Div</th>{/if}
{if $oTournament->getShowParentStatTable()}	<th class="cside" align="center">Conf</th>{/if}
	<th class="cside" align="center">PFA</th>
	<th class="cside" align="center">PAA</th>
	<th class="cside" align="center">DIFF</th>
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
{assign var=Wins value=($oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() + $oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot())}
{assign var=Loses value=($oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+ $oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot())}
<tr>
	<td class="{$className}" width="25" align="center">{$Position}{if $oTournamentstat->getGrouplead()==1}*{/if}</td>	
	<td class="{$className}" width="30">
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
	<td class="{$className}" width="150">
		{if $oTournament->getKnownTeams()!=3}
			<a href="{if $oTeam->getBlog()}{$oTeam->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oTeam->getTeamId()}{/if}" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
		{/if}
	</td>
	<td class="{$className}" width="100">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$Wins}</td>
	<td class="{$className}" align="center">{$Loses}</td>
	<td class="{$className}" align="center">{if ($group_record.$Group - $oTournamentstat->getDifWinLose())}{($group_record.$Group - $oTournamentstat->getDifWinLose())/2}{else}-{/if}</td>
	<td class="{$className}" align="center"><b>{if $TotalMatches}{($Wins/$TotalMatches)|string_format:"%.3f"}{else}0.000{/if}</b></td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getHomeWot()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getHomeLot()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getAwayW()+$oTournamentstat->getAwayWot()}-{$oTournamentstat->getAwayL()+$oTournamentstat->getAwayLot()}</td>

{if $oTournament->getShowGroupStatTable()}<td class="{$className}" align="center">{$oTournamentstat->getDivW()+$oTournamentstat->getDivWot()}-{$oTournamentstat->getDivL()+$oTournamentstat->getDivLot()}</td>{/if}
{if $oTournament->getShowParentStatTable()}<td class="{$className}" align="center">{$oTournamentstat->getConfW()+$oTournamentstat->getConfWot()}-{$oTournamentstat->getConfL()+$oTournamentstat->getConfLot()}</td>{/if}
	
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGf()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getGa()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{if ($oTournamentstat->getGf()-$oTournamentstat->getGa())>0}+{/if}{(($oTournamentstat->getGf()/$TotalMatches)-($oTournamentstat->getGa()/$TotalMatches))|string_format:"%.1f"}{else}0{/if}</td>
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
{*по подгруппам*}
<script language="JavaScript" type="text/javascript">


</script>
{include file='footer.tpl'}