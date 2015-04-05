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
{assign var=Position value=1}
<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams">
<thead>
<tr>
		<th class="cside" align="center"></th>
		<th class="cside">Команда</th>
		<th class="cside"></th>
		<th class="cside" align="center">W</th>
		<th class="cside" align="center">L</th>
		<th class="cside" align="center">T</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">PF</th>
		<th class="cside" align="center">PA</th>
		<th class="cside" align="center">Net Pts</th>
		<th class="cside" align="center">Home</th>
		<th class="cside" align="center">Road</th>
		<th class="cside" align="center">Div</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">Conf</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">Non-Conf</th>
		<th class="cside" align="center">Streak</th>
	</tr>
</thead>
{foreach from=$Tournamentstat item=oTournamentstat name=el2}
{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=oTeamintournament value=$oTournamentstat->getTeamtournament()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
<tr>
	<td class="{$className}" width="25"><img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/></td>
	<td class="{$className}" width="200"><a href="#" class="teamrasp">{$oTeam->getName()}</a></td>
	<td class="{$className}">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>
	
	<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()}</b></td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardW() - $oTournamentstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()}-{$oTournamentstat->getHomeL()}{if $oTournamentstat->getHomeT()}-{$oTournamentstat->getHomeT()}{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getAwayW()}-{$oTournamentstat->getAwayL()}{if $oTournamentstat->getAwayT()}-{$oTournamentstat->getAwayT()}{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getDivW()}-{$oTournamentstat->getDivL()}{if $oTournamentstat->getDivT()}-{$oTournamentstat->getDivT()}{/if}</td>
	<td class="{$className}" align="center">{if ($oTournamentstat->getDivW() + $oTournamentstat->getDivT() + $oTournamentstat->getDivL())}{(($oTournamentstat->getDivW()+ ($oTournamentstat->getDivT())*0.5)/($oTournamentstat->getDivW() + $oTournamentstat->getDivT() + $oTournamentstat->getDivL()))|string_format:"%.3f"}{else}.000{/if}</td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getConfW()}-{$oTournamentstat->getConfL()}{if $oTournamentstat->getConfT()}-{$oTournamentstat->getConfT()}{/if}</td>
	<td class="{$className}" align="center">{if ($oTournamentstat->getConfW() + $oTournamentstat->getConfT() + $oTournamentstat->getConfL())}{(($oTournamentstat->getConfW()+ ($oTournamentstat->getConfT())*0.5)/($oTournamentstat->getConfW() + $oTournamentstat->getConfT() + $oTournamentstat->getConfL()))|string_format:"%.3f"}{else}.000{/if}</td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() - $oTournamentstat->getConfW()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()-$oTournamentstat->getConfL()}{if ($oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()-$oTournamentstat->getConfT())}-{($oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()-$oTournamentstat->getConfT())}{/if}</td>
	
	
	<td class="{$className}" align="center">{abs($oTournamentstat->getStreak())}{if $oTournamentstat->getStreak()>0}W{/if}{if $oTournamentstat->getStreak()<0}L{/if}</td>
</tr>
{assign var=Position value=$Position+1}
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
		<th class="cside" align="center"></th>
		<th class="cside">Команда</th>
		<th class="cside"></th>
		<th class="cside" align="center">W</th>
		<th class="cside" align="center">L</th>
		<th class="cside" align="center">T</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">PF</th>
		<th class="cside" align="center">PA</th>
		<th class="cside" align="center">Net Pts</th>
		<th class="cside" align="center">Home</th>
		<th class="cside" align="center">Road</th>
		<th class="cside" align="center">Div</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">Conf</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">Non-Conf</th>
		<th class="cside" align="center">Streak</th>
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
	<td class="{$className}" width="25"><img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/></td>
	<td class="{$className}" width="200"><a href="#" class="teamrasp">{$oTeam->getName()}</a></td>
	<td class="{$className}">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>
	
	<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()}</b></td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardW() - $oTournamentstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()}-{$oTournamentstat->getHomeL()}{if $oTournamentstat->getHomeT()}-{$oTournamentstat->getHomeT()}{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getAwayW()}-{$oTournamentstat->getAwayL()}{if $oTournamentstat->getAwayT()}-{$oTournamentstat->getAwayT()}{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getDivW()}-{$oTournamentstat->getDivL()}{if $oTournamentstat->getDivT()}-{$oTournamentstat->getDivT()}{/if}</td>
	<td class="{$className}" align="center">{if ($oTournamentstat->getDivW() + $oTournamentstat->getDivT() + $oTournamentstat->getDivL())}{(($oTournamentstat->getDivW()+ ($oTournamentstat->getDivT())*0.5)/($oTournamentstat->getDivW() + $oTournamentstat->getDivT() + $oTournamentstat->getDivL()))|string_format:"%.3f"}{else}.000{/if}</td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getConfW()}-{$oTournamentstat->getConfL()}{if $oTournamentstat->getConfT()}-{$oTournamentstat->getConfT()}{/if}</td>
	<td class="{$className}" align="center">{if ($oTournamentstat->getConfW() + $oTournamentstat->getConfT() + $oTournamentstat->getConfL())}{(($oTournamentstat->getConfW()+ ($oTournamentstat->getConfT())*0.5)/($oTournamentstat->getConfW() + $oTournamentstat->getConfT() + $oTournamentstat->getConfL()))|string_format:"%.3f"}{else}.000{/if}</td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() - $oTournamentstat->getConfW()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()-$oTournamentstat->getConfL()}{if ($oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()-$oTournamentstat->getConfT())}-{($oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()-$oTournamentstat->getConfT())}{/if}</td>
	
	
	<td class="{$className}" align="center">{abs($oTournamentstat->getStreak())}{if $oTournamentstat->getStreak()>0}W{/if}{if $oTournamentstat->getStreak()<0}L{/if}</td>
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
		<th class="cside" align="center"></th>
		<th class="cside">Команда</th>
		<th class="cside"></th>
		<th class="cside" align="center">W</th>
		<th class="cside" align="center">L</th>
		<th class="cside" align="center">T</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">PF</th>
		<th class="cside" align="center">PA</th>
		<th class="cside" align="center">Net Pts</th>
		<th class="cside" align="center">Home</th>
		<th class="cside" align="center">Road</th>
		<th class="cside" align="center">Div</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">Conf</th>
		<th class="cside" align="center">Pct</th>
		<th class="cside" align="center">Non-Conf</th>
		<th class="cside" align="center">Streak</th>
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
	<td class="{$className}" width="25"><img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/></td>
	<td class="{$className}" width="200"><a href="#" class="teamrasp">{$oTeam->getName()}</a></td>
	<td class="{$className}">{if $oTeamintournament && $oTeamintournament->getUser1()}<a href="{router page='profile'}{$oTeamintournament->getUser1()->getLogin()}" >{$oTeamintournament->getUser1()->getLogin()}</a>{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>
	
	<td class="{$className}" align="center"><b>{$oTournamentstat->getPoints()}</b></td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardW()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getYardW() - $oTournamentstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()}-{$oTournamentstat->getHomeL()}{if $oTournamentstat->getHomeT()}-{$oTournamentstat->getHomeT()}{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getAwayW()}-{$oTournamentstat->getAwayL()}{if $oTournamentstat->getAwayT()}-{$oTournamentstat->getAwayT()}{/if}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getDivW()}-{$oTournamentstat->getDivL()}{if $oTournamentstat->getDivT()}-{$oTournamentstat->getDivT()}{/if}</td>
	<td class="{$className}" align="center">{if ($oTournamentstat->getDivW() + $oTournamentstat->getDivT() + $oTournamentstat->getDivL())}{(($oTournamentstat->getDivW()+ ($oTournamentstat->getDivT())*0.5)/($oTournamentstat->getDivW() + $oTournamentstat->getDivT() + $oTournamentstat->getDivL()))|string_format:"%.3f"}{else}.000{/if}</td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getConfW()}-{$oTournamentstat->getConfL()}{if $oTournamentstat->getConfT()}-{$oTournamentstat->getConfT()}{/if}</td>
	<td class="{$className}" align="center">{if ($oTournamentstat->getConfW() + $oTournamentstat->getConfT() + $oTournamentstat->getConfL())}{(($oTournamentstat->getConfW()+ ($oTournamentstat->getConfT())*0.5)/($oTournamentstat->getConfW() + $oTournamentstat->getConfT() + $oTournamentstat->getConfL()))|string_format:"%.3f"}{else}.000{/if}</td>
	
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW() - $oTournamentstat->getConfW()}-{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()-$oTournamentstat->getConfL()}{if ($oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()-$oTournamentstat->getConfT())}-{($oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()-$oTournamentstat->getConfT())}{/if}</td>
	
	
	<td class="{$className}" align="center">{abs($oTournamentstat->getStreak())}{if $oTournamentstat->getStreak()>0}W{/if}{if $oTournamentstat->getStreak()<0}L{/if}</td>
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