{include file='header.tpl' menu_content='tournament' noSidebar=true }
<style>
#sidebar {
display: none;
}
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
width: 30px;
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

{if $Tournamentstat and ( $oTournament->getShowFullStatTable()!=0 || $oTournament->getShowFullStatTable()==null)}

{*чемпион*}

{if isset($TitulTournamentStat)}
	{assign var=oTournamentstat value=$TitulTournamentStat}

	{assign var=oTeam value=$oTournamentstat->getTeam()}
	{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
	{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}

	{if $oTournamentstat->getTitul()}
		<div class="alert alert-block alert-success center"> 
			Чемпион - 
			{if $oTournament->getKnownTeams()!=3}
				<a href="#" class="teamrasp">{$oTeam->getName()}</a>
			{else}
				<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
			{/if}
		</div>		
	{else}
		{if !$oTournament->getWin()}
		<div class="alert alert-block  center" > 
			Нет чемпиона
		</div>
		{/if}
	{/if}

{else}
	<div class="alert alert-block  center" > 
		Нет чемпиона
	</div>
{/if}
{*champion*}



<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams">
<thead>
 
<tr>
	<th class="cside" align="center">№</th>	
	<th class="cside" align="center"></th>
	<th class="cside">Боец</th>
	{*<th class="cside">тех инф</th>*}
	<th class="cside" align="center" title="общее количество побед">W</th>
	<th class="cside" align="center" title="общее количество поражений">L</th>
	{*<th class="cside" align="center" title="">T</th>*}
    <th class="cside" align="center" title="количество побед нокаутом">WKO</th>
	{*<th class="cside" align="center" title="">WTKO</th>*}
	<th class="cside" align="center" title="количество побед сабмишеном">WSUB</th>
	{*<th class="cside" align="center" title="">WDEC</th>*}
	<th class="cside" align="center" title="количество поражений нокаутом">LKO</th>
	{*<th class="cside" align="center" title="">LTKO</th>*}
	<th class="cside" align="center" title="количество поражений сабмишеном">LSUB</th>
	{*<th class="cside" align="center" title="">LDEC</th>*}
	
	<th class="cside" align="center" title="количество нокдаунов">KD</th>
	<th class="cside" align="center" title="количество пребываний в нокдауне">KDa</th>	
	<th class="cside" align="center" title="количество успешно проведенных значимых ударов">SS</th>
	<th class="cside" align="center" title="процент успешно проведенных значимых ударов из общего числа попыток">SS%</th>	
	<th class="cside" align="center" title="среднее значение успешно проведенных значимых ударов за бой">SSF</th>
	{*<th class="cside" align="center" title="">SSa</th>*}
	<th class="cside" align="center" title="процент защиты от значимых ударов">SSd%</th>
	<th class="cside" align="center" title="общее количество успешно проведенных ударов">TS</th>
	{*<th class="cside" align="center" title="">TS%</th>*}
	{*<th class="cside" align="center" title="">TSa</th>*}
	<th class="cside" align="center" title="процент защиты от ударов">TSd%</th>
	<th class="cside" align="center" title="количество успешно проведенных тейкдаунов">TD</th>
	<th class="cside" align="center" title="процент успешно проведенных тейкдаунов">TD%</th>
	<th class="cside" align="center" title="среднее значение успешно проведенных тейкдаунов за бой">TDF</th>
	{*<th class="cside" align="center" title="">TDa</th>*}
	<th class="cside" align="center" title="процент защиты от тейкдаунов">TDd%</th>
	<th class="cside" align="center" title="количество попыток сабмишена">SM</th>
	<th class="cside" align="center" title="количество смен позиций в партере">GP</th>
</tr>
</thead>
{foreach from=$Tournamentstat item=oTournamentstat name=el2}
{if $oTournament->getKnownTeams()!=3}
	{assign var=oTeam value=$oTournamentstat->getTeam()}
{else}
	{assign var=oTeam value=$oTournamentstat->getTeamtournament()->getTeam()}
{/if}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
<tr> 
	<td class="{$className}" align="center">{$oTournamentstat->getPosition()}	
	
	</td>	
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
		{else}
			{*<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">*}
			{if $oTeam}<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}
		{/if}
	</td>
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<a href="#" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
			{if $oTournamentstat->getPositionDiff()}	
				<div class="rankingMovement">		
						<div class="movementMarker">			
								<div class="{if $oTournamentstat->getPositionDiff()>0}upArrow{else}downArrow{/if}"></div>				
						</div>			
					{abs($oTournamentstat->getPositionDiff())}				
				</div>
			{/if}
		{/if}
	</td>
{*	<td class="{$className}" align="center">{$oTournamentstat->getId()}-{$oTournamentstat->getTeamId()}-{$oTournamentstat->getUserId()}-{$oTournamentstat->getTeamintournamentId()}</td>*}
{*	<td class="{$className}" align="center">{$TotalMatches}</td>*}
{* +$oTournamentstat->getWko()+$oTournamentstat->getWtko()+$oTournamentstat->getWsub()+$oTournamentstat->getWdec()	*}
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()+$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getWko()+$oTournamentstat->getWtko()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getWtko()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getWsub()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getWdec()}</td>*}

	<td class="{$className}" align="center">{$oTournamentstat->getLko() + $oTournamentstat->getLtko()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getLtko()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getLsub()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getLdec()}</td>*}	
	
{*KD*}	<td class="{$className}" align="center">{$oTournamentstat->getKd()}</td>
{*KDa*}	<td class="{$className}" align="center">{$oTournamentstat->getKda()}</td>
	
{*SS*}	<td class="{$className}" align="center">{$oTournamentstat->getSs()}</td>
{*SS%*}	<td class="{$className}" align="center">{if $oTournamentstat->getSsAt()}{($oTournamentstat->getSs()/$oTournamentstat->getSsAt())|string_format:"%.2f"}{/if}</td>	

{*SSF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getSs()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*SSa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getSsa()}</td>*}
{*SSd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getSsaAt()}{(($oTournamentstat->getSsaAt() - $oTournamentstat->getSsa())/$oTournamentstat->getSsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TS*}	<td class="{$className}" align="center">{$oTournamentstat->getTs()}</td>
{*TS%*}	{*<td class="{$className}" align="center">{if $oTournamentstat->getTsAt()}{($oTournamentstat->getTs()/$oTournamentstat->getTsAt())|string_format:"%.2f"}{/if}</td>*}	
{*TSa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getTsa()}</td>*}
{*TSd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTsaAt()}{(($oTournamentstat->getTsaAt() - $oTournamentstat->getTsa())/$oTournamentstat->getTsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TD*}	<td class="{$className}" align="center">{$oTournamentstat->getTd()}</td>
{*TD%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTdAt()}{($oTournamentstat->getTd()/$oTournamentstat->getTdAt())|string_format:"%.2f"}{/if}</td>	

{*TDF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getTd()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*TDa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getTda()}</td>*}
{*TDd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTdaAt()}{(($oTournamentstat->getTdaAt() - $oTournamentstat->getTda())/$oTournamentstat->getTdaAt())|string_format:"%.2f"}{/if}</td>
	
{*SM*}	<td class="{$className}" align="center">{$oTournamentstat->getSm()}</td>
{*GP*}	<td class="{$className}" align="center">{$oTournamentstat->getGp()}</td>


</tr>
{/foreach}


</table>
{literal}
<script type="text/javascript"> 
  /*window.addEvent('domready',function(){ 
	var allteams = new HtmlTable($('allteams'));
	allteams.enableSort();
  }); // addEvent 
  */
  	$(document).ready(function() 
		{ 
			$("#allteams").tablesorter(); 
		} 
	); 
</script> 
{/literal}
{/if}

{*по группам*}
{if $aTournamentstatparentgroup and ($oTournament->getShowParentStatTable()!=0 || $oTournament->getShowFullStatTable()==null )}
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
	  /*window.addEvent('domready',function(){ 
		var allteams = new HtmlTable($('allteams{/literal}{$Parentgroup}{literal}'));
		allteams.enableSort();
	  }); // addEvent 
*/	  
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
		<th class="cside">Боец</th>
		{*<th class="cside">тех инф</th>*}
		<th class="cside" align="center" title="общее количество побед">W</th>
		<th class="cside" align="center" title="общее количество поражений">L</th>
		{*<th class="cside" align="center" title="">T</th>*}
		<th class="cside" align="center" title="количество побед нокаутом">WKO</th>
		{*<th class="cside" align="center" title="">WTKO</th>*}
		<th class="cside" align="center" title="количество побед сабмишеном">WSUB</th>
		{*<th class="cside" align="center" title="">WDEC</th>*}
		<th class="cside" align="center" title="количество поражений нокаутом">LKO</th>
		{*<th class="cside" align="center" title="">LTKO</th>*}
		<th class="cside" align="center" title="количество поражений сабмишеном">LSUB</th>
		{*<th class="cside" align="center" title="">LDEC</th>*}
		
		<th class="cside" align="center" title="количество нокдаунов">KD</th>
		<th class="cside" align="center" title="количество пребываний в нокдауне">KDa</th>	
		<th class="cside" align="center" title="количество успешно проведенных значимых ударов">SS</th>
		<th class="cside" align="center" title="процент успешно проведенных значимых ударов из общего числа попыток">SS%</th>	
		<th class="cside" align="center" title="среднее значение успешно проведенных значимых ударов за бой">SSF</th>
		{*<th class="cside" align="center" title="">SSa</th>*}
		<th class="cside" align="center" title="процент защиты от значимых ударов">SSd%</th>
		<th class="cside" align="center" title="общее количество успешно проведенных ударов">TS</th>
		{*<th class="cside" align="center" title="">TS%</th>*}
		{*<th class="cside" align="center" title="">TSa</th>*}
		<th class="cside" align="center" title="процент защиты от ударов">TSd%</th>
		<th class="cside" align="center" title="количество успешно проведенных тейкдаунов">TD</th>
		<th class="cside" align="center" title="процент успешно проведенных тейкдаунов">TD%</th>
		<th class="cside" align="center" title="среднее значение успешно проведенных тейкдаунов за бой">TDF</th>
		{*<th class="cside" align="center" title="">TDa</th>*}
		<th class="cside" align="center" title="процент защиты от тейкдаунов">TDd%</th>
		<th class="cside" align="center" title="количество попыток сабмишена">SM</th>
		<th class="cside" align="center" title="количество смен позиций в партере">GP</th>
	</tr>
	</thead>
	{assign var=PrevGroup value=$Parentgroup}
	{assign var=Parentgroup value=$oParentgroup->getGroupId()}
{/if}	
{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
 
<tr> 
	<td class="{$className}" align="center">{$Position}	
	
	</td>	
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
		{else}
			{*<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">*}
			{if $oTeam}<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}
		{/if}
	</td>
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<a href="#" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
			{if $oTournamentstat->getPositionDiff()}	
				<div class="rankingMovement">		
						<div class="movementMarker">			
								<div class="{if $oTournamentstat->getPositionDiff()>0}upArrow{else}downArrow{/if}"></div>				
						</div>			
					{abs($oTournamentstat->getPositionDiff())}				
				</div>
			{/if}
		{/if}
	</td>
{*	<td class="{$className}" align="center">{$oTournamentstat->getId()}-{$oTournamentstat->getTeamId()}-{$oTournamentstat->getUserId()}-{$oTournamentstat->getTeamintournamentId()}</td>*}
{*	<td class="{$className}" align="center">{$TotalMatches}</td>*}
{* +$oTournamentstat->getWko()+$oTournamentstat->getWtko()+$oTournamentstat->getWsub()+$oTournamentstat->getWdec()	*}
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()+$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getWko()+$oTournamentstat->getWtko()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getWtko()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getWsub()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getWdec()}</td>*}

	<td class="{$className}" align="center">{$oTournamentstat->getLko() + $oTournamentstat->getLtko()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getLtko()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getLsub()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getLdec()}</td>*}	
	
{*KD*}	<td class="{$className}" align="center">{$oTournamentstat->getKd()}</td>
{*KDa*}	<td class="{$className}" align="center">{$oTournamentstat->getKda()}</td>
	
{*SS*}	<td class="{$className}" align="center">{$oTournamentstat->getSs()}</td>
{*SS%*}	<td class="{$className}" align="center">{if $oTournamentstat->getSsAt()}{($oTournamentstat->getSs()/$oTournamentstat->getSsAt())|string_format:"%.2f"}{/if}</td>	

{*SSF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getSs()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*SSa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getSsa()}</td>*}
{*SSd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getSsaAt()}{(($oTournamentstat->getSsaAt() - $oTournamentstat->getSsa())/$oTournamentstat->getSsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TS*}	<td class="{$className}" align="center">{$oTournamentstat->getTs()}</td>
{*TS%*}	{*<td class="{$className}" align="center">{if $oTournamentstat->getTsAt()}{($oTournamentstat->getTs()/$oTournamentstat->getTsAt())|string_format:"%.2f"}{/if}</td>*}	
{*TSa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getTsa()}</td>*}
{*TSd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTsaAt()}{(($oTournamentstat->getTsaAt() - $oTournamentstat->getTsa())/$oTournamentstat->getTsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TD*}	<td class="{$className}" align="center">{$oTournamentstat->getTd()}</td>
{*TD%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTdAt()}{($oTournamentstat->getTd()/$oTournamentstat->getTdAt())|string_format:"%.2f"}{/if}</td>	

{*TDF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getTd()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*TDa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getTda()}</td>*}
{*TDd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTdaAt()}{(($oTournamentstat->getTdaAt() - $oTournamentstat->getTda())/$oTournamentstat->getTdaAt())|string_format:"%.2f"}{/if}</td>
	
{*SM*}	<td class="{$className}" align="center">{$oTournamentstat->getSm()}</td>
{*GP*}	<td class="{$className}" align="center">{$oTournamentstat->getGp()}</td>


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
{assign var=Round value=-1}
{assign var=PrevGroup value=0}
{assign var=Position value=1}

{if $aTournamentstatgroup and ($oTournament->getShowGroupStatTable()!=0 || $oTournament->getShowGroupStatTable()==null)}
{foreach from=$aTournamentstatgroup item=oTournamentstat name=el2}
{assign var=oParentgroup value=$oTournamentstat->getParentgroup()}
{assign var=oGroup value=$oTournamentstat->getGroup()}
{assign var=oRound value=$oTournamentstat->getRound()}
{assign var=oUser value=$oTournamentstat->getTeamtournament()->getUser1()}

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
{if $oRound->getRoundId() != $Round}
<h3>{$oRound->getName()}</h3>
{assign var=Round value=$oRound->getRoundId()}
{/if}
	{if $oGroup->getGroupId() != $Group}
	{assign var=Position value=1}
	
	<p align="center"><b>{$oGroup->getName()}</b></p>
	<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams{$oGroup->getGroupId()}">
	<thead>
	<tr>
		<th class="cside" align="center">№</th>	
		<th class="cside" align="center"></th>
		<th class="cside">Боец</th>
		{*<th class="cside">тех инф</th>*}
		<th class="cside" align="center" title="общее количество побед">W</th>
		<th class="cside" align="center" title="общее количество поражений">L</th>
		{*<th class="cside" align="center" title="">T</th>*}
		<th class="cside" align="center" title="количество побед нокаутом">WKO</th>
		{*<th class="cside" align="center" title="">WTKO</th>*}
		<th class="cside" align="center" title="количество побед сабмишеном">WSUB</th>
		{*<th class="cside" align="center" title="">WDEC</th>*}
		<th class="cside" align="center" title="количество поражений нокаутом">LKO</th>
		{*<th class="cside" align="center" title="">LTKO</th>*}
		<th class="cside" align="center" title="количество поражений сабмишеном">LSUB</th>
		{*<th class="cside" align="center" title="">LDEC</th>*}
		
		<th class="cside" align="center" title="количество нокдаунов">KD</th>
		<th class="cside" align="center" title="количество пребываний в нокдауне">KDa</th>	
		<th class="cside" align="center" title="количество успешно проведенных значимых ударов">SS</th>
		<th class="cside" align="center" title="процент успешно проведенных значимых ударов из общего числа попыток">SS%</th>	
		<th class="cside" align="center" title="среднее значение успешно проведенных значимых ударов за бой">SSF</th>
		{*<th class="cside" align="center" title="">SSa</th>*}
		<th class="cside" align="center" title="процент защиты от значимых ударов">SSd%</th>
		<th class="cside" align="center" title="общее количество успешно проведенных ударов">TS</th>
		{*<th class="cside" align="center" title="">TS%</th>*}
		{*<th class="cside" align="center" title="">TSa</th>*}
		<th class="cside" align="center" title="процент защиты от ударов">TSd%</th>
		<th class="cside" align="center" title="количество успешно проведенных тейкдаунов">TD</th>
		<th class="cside" align="center" title="процент успешно проведенных тейкдаунов">TD%</th>
		<th class="cside" align="center" title="среднее значение успешно проведенных тейкдаунов за бой">TDF</th>
		{*<th class="cside" align="center" title="">TDa</th>*}
		<th class="cside" align="center" title="процент защиты от тейкдаунов">TDd%</th>
		<th class="cside" align="center" title="количество попыток сабмишена">SM</th>
		<th class="cside" align="center" title="количество смен позиций в партере">GP</th>
	</tr>
	</thead>
	{assign var=PrevGroup value=$Group}
	{assign var=Group value=$oGroup->getGroupId()}
	{/if}
{assign var=oTeam value=$oTournamentstat->getTeam()}
{assign var=TotalMatches value=($oTournamentstat->getHomeW()+$oTournamentstat->getHomeL()+$oTournamentstat->getHomeT()+$oTournamentstat->getHomeWot()+$oTournamentstat->getHomeLot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayW()+$oTournamentstat->getAwayL()+$oTournamentstat->getAwayT()+$oTournamentstat->getAwayWot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getAwayWb()+$oTournamentstat->getAwayLb())}
<tr> 
	<td class="{$className}" align="center">{$Position}	
	
	</td>	
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>
		{else}
			{*<img style="height:20px; width:20px;" src="{$oUser->getAvatarUrl()}">*}
			{if $oTeam}<img style="height:20px; width:20px;" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}
		{/if}
	</td>
	<td class="{$className}">
		{if $oTournament->getKnownTeams()!=3}
			<a href="#" class="teamrasp">{$oTeam->getName()}</a>
		{else}
			<a class="author" href="{router page='profile'}{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
			{if $oTournamentstat->getPositionDiff()}	
				<div class="rankingMovement">		
						<div class="movementMarker">			
								<div class="{if $oTournamentstat->getPositionDiff()>0}upArrow{else}downArrow{/if}"></div>				
						</div>			
					{abs($oTournamentstat->getPositionDiff())}				
				</div>
			{/if}
		{/if}
	</td>
{*	<td class="{$className}" align="center">{$oTournamentstat->getId()}-{$oTournamentstat->getTeamId()}-{$oTournamentstat->getUserId()}-{$oTournamentstat->getTeamintournamentId()}</td>*}
{*	<td class="{$className}" align="center">{$TotalMatches}</td>*}
{* +$oTournamentstat->getWko()+$oTournamentstat->getWtko()+$oTournamentstat->getWsub()+$oTournamentstat->getWdec()	*}
	<td class="{$className}" align="center">{$oTournamentstat->getHomeW()+$oTournamentstat->getAwayW()+$oTournamentstat->getHomeWot()+$oTournamentstat->getAwayWot()+$oTournamentstat->getHomeWb()+$oTournamentstat->getAwayWb()}</td>
	<td class="{$className}" align="center">{$oTournamentstat->getHomeL()+$oTournamentstat->getAwayL()+$oTournamentstat->getHomeLot()+$oTournamentstat->getAwayLot()+$oTournamentstat->getHomeLb()+$oTournamentstat->getAwayLb()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getHomeT()+$oTournamentstat->getAwayT()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getWko()+$oTournamentstat->getWtko()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getWtko()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getWsub()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getWdec()}</td>*}

	<td class="{$className}" align="center">{$oTournamentstat->getLko() + $oTournamentstat->getLtko()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getLtko()}</td>*}
	<td class="{$className}" align="center">{$oTournamentstat->getLsub()}</td>
	{*<td class="{$className}" align="center">{$oTournamentstat->getLdec()}</td>*}	
	
{*KD*}	<td class="{$className}" align="center">{$oTournamentstat->getKd()}</td>
{*KDa*}	<td class="{$className}" align="center">{$oTournamentstat->getKda()}</td>
	
{*SS*}	<td class="{$className}" align="center">{$oTournamentstat->getSs()}</td>
{*SS%*}	<td class="{$className}" align="center">{if $oTournamentstat->getSsAt()}{($oTournamentstat->getSs()/$oTournamentstat->getSsAt())|string_format:"%.2f"}{/if}</td>	

{*SSF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getSs()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*SSa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getSsa()}</td>*}
{*SSd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getSsaAt()}{(($oTournamentstat->getSsaAt() - $oTournamentstat->getSsa())/$oTournamentstat->getSsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TS*}	<td class="{$className}" align="center">{$oTournamentstat->getTs()}</td>
{*TS%*}	{*<td class="{$className}" align="center">{if $oTournamentstat->getTsAt()}{($oTournamentstat->getTs()/$oTournamentstat->getTsAt())|string_format:"%.2f"}{/if}</td>*}	
{*TSa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getTsa()}</td>*}
{*TSd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTsaAt()}{(($oTournamentstat->getTsaAt() - $oTournamentstat->getTsa())/$oTournamentstat->getTsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TD*}	<td class="{$className}" align="center">{$oTournamentstat->getTd()}</td>
{*TD%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTdAt()}{($oTournamentstat->getTd()/$oTournamentstat->getTdAt())|string_format:"%.2f"}{/if}</td>	

{*TDF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oTournamentstat->getTd()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*TDa*}	{*<td class="{$className}" align="center">{$oTournamentstat->getTda()}</td>*}
{*TDd%*}	<td class="{$className}" align="center">{if $oTournamentstat->getTdaAt()}{(($oTournamentstat->getTdaAt() - $oTournamentstat->getTda())/$oTournamentstat->getTdaAt())|string_format:"%.2f"}{/if}</td>
	
{*SM*}	<td class="{$className}" align="center">{$oTournamentstat->getSm()}</td>
{*GP*}	<td class="{$className}" align="center">{$oTournamentstat->getGp()}</td>


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
 /* window.addEvent('domready',function(){ 
	var allteams = new HtmlTable($('allteams{/literal}{$Group}{literal}'));
	allteams.enableSort();
  }); // addEvent 
  */
</script> 
{/literal}
{/if}
</small>
{*по подгруппам*}

<small>
<ul>
<li>W - общее количество побед</li>
<li>L - общее количество поражений</li>
<li>WKO - количество побед нокаутом</li>
<li>WSUB - количество побед сабмишеном</li>
<li>LKO - количество поражений нокаутом</li>
<li>LSUB - количество поражений сабмишеном</li>
<li>KD - количество нокдаунов</li>
<li>KDa - количество пребываний в нокдауне</li>
<li>SS - количество успешно проведенных значимых ударов</li>
<li>SS% - процент успешно проведенных значимых ударов из общего числа попыток</li>
<li>SSF - среднее значение успешно проведенных значимых ударов за бой</li>
<li>SSd% - процент защиты от значимых ударов</li>
<li>TS - общее количество успешно проведенных ударов</li>
<li>TSd% - процент защиты от ударов (можно скрыть этот столбик)</li>
<li>TD - количество успешно проведенных тейкдаунов</li>
<li>TD% - процент успешно проведенных тейкдаунов</li>
<li>TDF - среднее значение успешно проведенных тейкдаунов за бой</li>
<li>TDd% - процент защиты от тейкдаунов</li>
<li>SM - количество попыток сабмишена</li>
<li>GP - количество смен позиций в партере</li>
</ul>
</small>
<script language="JavaScript" type="text/javascript">


</script>
{include file='footer.tpl'}