<div class="">
<div class="span12">
	<div class="widget-box transparent">
		{*<div class="widget-header-small">
			<h4 class="title">Участие в турнирах</h4>
		</div>*}
		<div class="widget-body">
			<div class="widget-main">
{if $Playerstat}
<small>

{assign var=game_id value=0}

{foreach from=$Playerstat item=oPlayerstat name=el2}
{assign var=oTeam value=$oPlayerstat->getTeam()}
{assign var=oTournament value=$oPlayerstat->getTournament()}
{assign var=oGame value=$oPlayerstat->getGame()}
{assign var=oGametype value=$oPlayerstat->getGametype()}


{if $oPlayerstat->getGameId() != $game_id && $game_id!=0}
{if $oPreviousGame->getSportId()==2}
<tr>
	<td width="11"></td>
	<td class="{$className}" width="25"></td>
	<td class="{$className}"><b>Итого</b></td>
	<td class="{$className}" align="left"></td>	
	<td class="{$className}" align="center"><b>{$sumTotalMatches}</b></td>
	<td class="{$className}" align="center"><b>{$sumWins + $sumWinsOT + $sumWinsWB}</b></td>
	<td class="{$className}" align="center"><b>{$sumT}</b></td>
    <td class="{$className}" align="center"><b>{$sumL + $sumLOT + $sumLB}</b></td>	
	<td class="{$className}" align="center"></td>	
	<td class="{$className}" align="center"></td>
	<td class="{$className}" align="center"></td>
	
</tr>
{/if}
{if $oPreviousGame->getSportId()==1}
<tr>
	<td width="11"></td>
	<td class="{$className}" width="25"></td>
	<td class="{$className}"><b>Итого</b></td>
	<td class="{$className}" align="left"></td>	
	<td class="{$className}" align="center"><b>{$sumTotalMatches}</b></td>
	<td class="{$className}" align="center"><b>{$sumWins}</b></td>
	<td class="{$className}" align="center"><b>{$sumWinsOT}</b></td>
    <td class="{$className}" align="center"><b>{$sumWinsWB}</b></td>	
	<td class="{$className}" align="center"><b>{$sumLOT}</b></td>
    <td class="{$className}" align="center"><b>{$sumLB}</b></td>
	<td class="{$className}" align="center"><b>{$sumL}</b></td>
	<td class="{$className}" align="center"></td>
	<td class="{$className}" align="center"><b>{$sumSuhW}</b></td>
	<td class="{$className}" align="center"><b>{$sumSuhL}</b></td>
	<td class="{$className}" align="center"><b>{$sumGf}</b></td>
	<td class="{$className}" align="center"><b>{$sumGa}</b></td>
	<td class="{$className}" align="center"><b>{$sumGf-$sumGa}</b></td>
	<td class="{$className}" align="center"><b>{($sumGf/$sumTotalMatches)|string_format:"%.2f"}</b></td>
	<td class="{$className}" align="center"><b>{($sumGa/$sumTotalMatches)|string_format:"%.2f"}</b></td>
 	<td width="11"></td>
</tr>
{/if}
			</tbody>
		</table>
	
{/if}
{assign var=oPreviousGame value=$oPlayerstat->getGame()}

{if $oPlayerstat->getGameId() != $game_id }
{assign var=game_id value=$oPlayerstat->getGameId()}
<h4 class="title">{$oGame->getName()}</h4>
<table width="100%" cellspacing="0" class="table table-striped table-bordered table-hover" id="allteams">
			<thead>
{if $oGame->getSportId()==2}
<tr>
	<th class="lside"></th>	
	<th class="cside" align="center"></th>
	<th class="cside">Команда</th>
	<th class="cside">Турнир</th>	
	<th class="cside" align="center">И</th>
	<th class="cside" align="center">В</th>
	<th class="cside" align="center">Н</th>
	<th class="cside" align="center">П</th>
	<th class="cside" align="center">Мячи</th>
	<th class="cside" align="center">О</th>
	<th class="cside" align="center">Рейт</th>
</tr>
{/if}
{if $oGame->getSportId()==1}
<tr>
	<th class="lside"></th>	
	<th class="cside" align="center"></th>
	<th class="cside">Команда</th>
	<th class="cside">Турнир</th>	
	<th class="cside" align="center">И</th>
	<th class="cside" align="center">В</th>
	<th class="cside" align="center">ВО</th>
	<th class="cside" align="center">ВБ</th>
	<th class="cside" align="center">ПО</th>
	<th class="cside" align="center">ПБ</th>
	<th class="cside" align="center">П</th>
	<th class="cside" align="center">О</th>
	<th class="cside" align="center">СВ</th>
	<th class="cside" align="center">СП</th>
	<th class="cside" align="center">ШЗ</th>
	<th class="cside" align="center">ШП</th>
	<th class="cside" align="center">±</th>
	<th class="cside" align="center">ШЗМ</th>
	<th class="cside" align="center">ШПМ</th>
	<th class="cside" align="center">%</th> 
</tr>
{/if}
{if $oGame->getSportId()==5}
<tr>
	<th class="lside"></th>	
	<th class="cside" align="center"></th>
	<th class="cside">Команда</th>
	<th class="cside">Турнир</th>
	<th class="cside" align="center">W</th>
	<th class="cside" align="center">L</th>
	<th class="cside" align="center">T</th>
	<th class="cside" align="center">Pct</th>
	<th class="cside" align="center">PF</th>
	<th class="cside" align="center">PA</th>
	<th class="cside" align="center">Net Pts</th>
	<th class="cside" align="center">Home</th>
	<th class="cside" align="center">Road</th>
</tr>
{/if}
{if $oGame->getSportId()==3}
<tr>
	<th class="lside"></th>	
	<th class="cside" align="center"></th>
	<th class="cside">Команда</th>
	<th class="cside">Турнир</th>
	<th class="cside" align="center">W</th>
	<th class="cside" align="center">L</th>
	<th class="cside" align="center">Pct</th>
	<th class="cside" align="center">PFA</th>
	<th class="cside" align="center">PAA</th>
	<th class="cside" align="center">Home</th>
	<th class="cside" align="center">Road</th>
</tr>
{/if}
{if $oGame->getSportId()==6}
{*типа W L WKO WSUB LKO LSUB SSpF TDpF*}
<tr>
	<th class="cside" align="center">№</th>
	<th class="cside"></th>	
	<th class="cside">Турнир</th>	
	<th class="cside" align="center" title="общее количество побед">W</th>
	<th class="cside" align="center" title="общее количество поражений">L</th>
    <th class="cside" align="center" title="количество побед нокаутом">WKO</th>
	<th class="cside" align="center" title="количество побед сабмишеном">WSUB</th>
	<th class="cside" align="center" title="количество поражений нокаутом">LKO</th>
	<th class="cside" align="center" title="количество поражений сабмишеном">LSUB</th>
	
	<th class="cside" align="center" title="количество нокдаунов">KD</th>
	{*<th class="cside" align="center" title="количество пребываний в нокдауне">KDa</th>
	<th class="cside" align="center" title="количество успешно проведенных значимых ударов">SS</th>*}
	<th class="cside" align="center" title="процент успешно проведенных значимых ударов из общего числа попыток">SS%</th>	
	<th class="cside" align="center" title="среднее значение успешно проведенных значимых ударов за бой">SSF</th>
	<th class="cside" align="center" title="процент защиты от значимых ударов">SSd%</th>
	{*<th class="cside" align="center" title="общее количество успешно проведенных ударов">TS</th>
	<th class="cside" align="center" title="процент защиты от ударов">TSd%</th>
	<th class="cside" align="center" title="количество успешно проведенных тейкдаунов">TD</th>*}
	<th class="cside" align="center" title="процент успешно проведенных тейкдаунов">TD%</th>
	<th class="cside" align="center" title="среднее значение успешно проведенных тейкдаунов за бой">TDF</th>
	<th class="cside" align="center" title="процент защиты от тейкдаунов">TDd%</th>
	<th class="cside" align="center" title="количество попыток сабмишена">SM</th>
	<th class="cside" align="center" title="количество смен позиций в партере">GP</th>
</tr>

{/if}

			</thead>
			<tbody>
			
{assign var=TotalMatches value=0}
{assign var=sumTotalMatches value=0}
{assign var=sumWins value=0}
{assign var=sumWinsOT value=0}
{assign var=sumWinsWB value=0}
{assign var=sumLOT value=0}
{assign var=sumLB value=0}
{assign var=sumL value=0}
{assign var=sumT value=0}
{assign var=sumSuhW value=0}
{assign var=sumSuhL value=0}
{assign var=sumGf value=0}
{assign var=sumGa value=0}
{/if}

{assign var=TotalMatches value=($oPlayerstat->getHomeW()+$oPlayerstat->getHomeL()+$oPlayerstat->getHomeT()+$oPlayerstat->getHomeWot()+$oPlayerstat->getHomeLot()+$oPlayerstat->getHomeWb()+$oPlayerstat->getHomeLb()+$oPlayerstat->getAwayW()+$oPlayerstat->getAwayL()+$oPlayerstat->getAwayT()+$oPlayerstat->getAwayWot()+$oPlayerstat->getAwayLot()+$oPlayerstat->getAwayWb()+$oPlayerstat->getAwayLb())}
{assign var=sumTotalMatches value=$sumTotalMatches+$TotalMatches}
{assign var=sumWins value=$sumWins+$oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()}
{assign var=sumWinsOT value=$sumWinsOT+$oPlayerstat->getHomeWot()+$oPlayerstat->getAwayWot()}
{assign var=sumWinsWB value=$sumWinsWB+$oPlayerstat->getHomeWb()+$oPlayerstat->getAwayWb()}
{assign var=sumLOT value=$sumLOT+$oPlayerstat->getHomeLot()+$oPlayerstat->getAwayLot()}
{assign var=sumLB value=$sumLB+$oPlayerstat->getHomeLb()+$oPlayerstat->getAwayLb()}
{assign var=sumL value=$sumL+$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()}
{assign var=sumT value=$sumL+$oPlayerstat->getHomeT()+$oPlayerstat->getAwayT()}
{assign var=sumSuhW value=$sumSuhW+$oPlayerstat->getSuhW()}
{assign var=sumSuhL value=$sumSuhL+$oPlayerstat->getSuhL()}
{assign var=sumGf value=$sumGf+$oPlayerstat->getGf()}
{assign var=sumGa value=$sumGa+$oPlayerstat->getGa()}
{if $oGame->getSportId()==2}
<tr> 
	<td class="{$className}" align="center">{if $oPlayerstat->getPosition() > 0}{$oPlayerstat->getPosition()}{/if}</td>	
	<td class="{$className}" width="25">{if $oTeam}<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}</td>
	<td class="{$className}">{if $oTeam}<a href="#" >{$oTeam->getName()}</a>{/if}</td>
	<td class="{$className}" align="left"><a href="{$oTournament->getUrlFull()}">{$oTournament->getBrief()}{if $oPlayerstat->getRoundId()=='100'} Кубок{/if}</a></td>	
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()+$oPlayerstat->getHomeWot()+$oPlayerstat->getAwayWot()+$oPlayerstat->getHomeWb()+$oPlayerstat->getAwayWb()}</td>
    <td class="{$className}" align="center">{$oPlayerstat->getHomeT()+$oPlayerstat->getAwayT()}</td>	
	<td class="{$className}" align="center">{$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()+$oPlayerstat->getHomeLot()+$oPlayerstat->getAwayLot()+$oPlayerstat->getHomeLb()+$oPlayerstat->getAwayLb()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getGf()}-{$oPlayerstat->getGa()}</td>
	<td class="{$className}" align="center">{if $oPlayerstat->getRoundId()!='100'}<b>{$oPlayerstat->getPoints()|string_format:"%.0f"}</b>{/if}</td>
	<td class="{$className}" align="center">{if $oTournament->getRatingLfrm()}{$oPlayerstat->getRatingLfrm()|string_format:"%.2f"}{/if}</td>
</tr>
{/if}
{if $oGame->getSportId()==5}
<tr> 
	<td class="{$className}" align="center">{if $oPlayerstat->getPosition() > 0}{$oPlayerstat->getPosition()}{/if}</td>	
	<td class="{$className}" width="25">{if $oTeam}<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}</td>
	<td class="{$className}">{if $oTeam}<a href="#" >{$oTeam->getName()}</a>{/if}</td>
	<td class="{$className}" align="left"><a href="{$oTournament->getUrlFull()}">{$oTournament->getBrief()}{if $oPlayerstat->getRoundId()==100} Кубок{/if}</a></td>	
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeT()+$oPlayerstat->getAwayT()}</td>
	
	<td class="{$className}" align="center"><b>{if $oPlayerstat->getPoints()>1}{(($oPlayerstat->getHomeW()+$oPlayerstat->getAwayW())/($oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()+$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()+$oPlayerstat->getHomeT()+$oPlayerstat->getAwayT()))|string_format:"%.3f"}{else}{$oPlayerstat->getPoints()}{/if}</b></td>
	<td class="{$className}" align="center">{$oPlayerstat->getYardW()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getYardW() - $oPlayerstat->getYardL()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()}-{$oPlayerstat->getHomeL()}{if $oPlayerstat->getHomeT()}-{$oPlayerstat->getHomeT()}{/if}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getAwayW()}-{$oPlayerstat->getAwayL()}{if $oPlayerstat->getAwayT()}-{$oPlayerstat->getAwayT()}{/if}</td>
</tr>
{/if}
{if $oGame->getSportId()==3}
<tr> 
	<td class="{$className}" align="center">{if $oPlayerstat->getPosition() > 0}{$oPlayerstat->getPosition()}{/if}</td>	
	<td class="{$className}" width="25">{if $oTeam}<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}</td>
	<td class="{$className}">{if $oTeam}<a href="#" >{$oTeam->getName()}</a>{/if}</td>
	<td class="{$className}" align="left"><a href="{$oTournament->getUrlFull()}">{$oTournament->getBrief()}{if $oPlayerstat->getRoundId()==100} Кубок{/if}</a></td>	
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()}</td>
	
	<td class="{$className}" align="center"><b>{if $oPlayerstat->getPoints()>1}{(($oPlayerstat->getHomeW()+$oPlayerstat->getAwayW())/($oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()+$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()+$oPlayerstat->getHomeT()+$oPlayerstat->getAwayT()))|string_format:"%.3f"}{else}{$oPlayerstat->getPoints()}{/if}</b></td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oPlayerstat->getGf()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oPlayerstat->getGa()/$TotalMatches)|string_format:"%.1f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()+$oPlayerstat->getHomeWot()}-{$oPlayerstat->getHomeL()+$oPlayerstat->getHomeLot()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getAwayW()+$oPlayerstat->getAwayWot()}-{$oPlayerstat->getAwayL()+$oPlayerstat->getAwayLot()}</td>
</tr>
{/if}
{if $oGame->getSportId()==1}
<tr>
	<td width="11">{if $oPlayerstat->getPosition() > 0}{$oPlayerstat->getPosition()}{/if}</td>
	<td class="{$className}" width="25">{if $oTeam}<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oTeam->getLogo()}"/>{/if}</td>
	<td class="{$className}">{if $oTeam}<a href="#" >{$oTeam->getName()}</a>{/if}</td>
	<td class="{$className}" align="left"><a href="{$oTournament->getUrlFull()}">{$oTournament->getBrief()}{if $oPlayerstat->getRoundId()==100} ПО{/if}</a></td>	
	<td class="{$className}" align="center">{$TotalMatches}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeWot()+$oPlayerstat->getAwayWot()}</td>
    <td class="{$className}" align="center">{$oPlayerstat->getHomeWb()+$oPlayerstat->getAwayWb()}</td>	
	<td class="{$className}" align="center">{$oPlayerstat->getHomeLot()+$oPlayerstat->getAwayLot()}</td>
    <td class="{$className}" align="center">{$oPlayerstat->getHomeLb()+$oPlayerstat->getAwayLb()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()}</td>
	<td class="{$className}" align="center">{if $oPlayerstat->getRoundId()!='100'}<b>{$oPlayerstat->getPoints()|string_format:"%.0f"}</b>{/if}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getSuhW()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getSuhL()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getGf()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getGa()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getGf()-$oPlayerstat->getGa()}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oPlayerstat->getGf()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches}{($oPlayerstat->getGa()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
	<td class="{$className}" align="center">{if $TotalMatches*$oTournament->getWin()}{($oPlayerstat->getPoints()/($TotalMatches*$oTournament->getWin()) )|string_format:"%.2f"}{else}0{/if}</td>
 
</tr>
{/if}
{if $oGame->getSportId()==6}
<tr> 
	<td class="{$className}" align="center">{if $oPlayerstat->getPosition() > 0}{$oPlayerstat->getPosition()}{/if}</td>	
	<td class="{$className}" width="25"><img width="20" src="{cfg name='path.root.web'}images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/></td>
	<td class="{$className}"><a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}{if $oPlayerstat->getRoundId()==100} ПО{/if}</a></td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeW()+$oPlayerstat->getAwayW()+$oPlayerstat->getHomeWot()+$oPlayerstat->getAwayWot()+$oPlayerstat->getHomeWb()+$oPlayerstat->getAwayWb()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getHomeL()+$oPlayerstat->getAwayL()+$oPlayerstat->getHomeLot()+$oPlayerstat->getAwayLot()+$oPlayerstat->getHomeLb()+$oPlayerstat->getAwayLb()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getWko()+$oPlayerstat->getWtko()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getWsub()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getLko() + $oPlayerstat->getLtko()}</td>
	<td class="{$className}" align="center">{$oPlayerstat->getLsub()}</td>
	
{*KD*}	<td class="{$className}" align="center">{$oPlayerstat->getKd()}</td>

{*SS%*}	<td class="{$className}" align="center">{if $oPlayerstat->getSsAt()}{($oPlayerstat->getSs()/$oPlayerstat->getSsAt())|string_format:"%.2f"}{/if}</td>	
{*SSF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oPlayerstat->getSs()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*SSd%*}	<td class="{$className}" align="center">{if $oPlayerstat->getSsaAt()}{(($oPlayerstat->getSsaAt() - $oPlayerstat->getSsa())/$oPlayerstat->getSsaAt())|string_format:"%.2f"}{/if}</td>
	
{*TD%*}	<td class="{$className}" align="center">{if $oPlayerstat->getTdAt()}{($oPlayerstat->getTd()/$oPlayerstat->getTdAt())|string_format:"%.2f"}{/if}</td>	

{*TDF*}	<td class="{$className}" align="center">{if $TotalMatches}{($oPlayerstat->getTd()/$TotalMatches)|string_format:"%.2f"}{else}0{/if}</td>
{*TDd%*}	<td class="{$className}" align="center">{if $oPlayerstat->getTdaAt()}{(($oPlayerstat->getTdaAt() - $oPlayerstat->getTda())/$oPlayerstat->getTdaAt())|string_format:"%.2f"}{/if}</td>
	
{*SM*}	<td class="{$className}" align="center">{$oPlayerstat->getSm()}</td>
{*GP*}	<td class="{$className}" align="center">{$oPlayerstat->getGp()}</td>
</tr>
{/if}
{/foreach}
{if $oGame->getSportId()==2}
<tr>
	<td width="11"></td>
	<td class="{$className}" width="25"></td>
	<td class="{$className}"><b>Итого</b></td>
	<td class="{$className}" align="left"></td>	
	<td class="{$className}" align="center"><b>{$sumTotalMatches}</b></td>
	<td class="{$className}" align="center"><b>{$sumWins + $sumWinsOT + $sumWinsWB}</b></td>
	<td class="{$className}" align="center"><b>{$sumT}</b></td>
    <td class="{$className}" align="center"><b>{$sumL + $sumLOT + $sumLB}</b></td>	
	<td class="{$className}" align="center"></td>	
	<td class="{$className}" align="center"></td>
</tr>
{/if}
{if $oGame->getSportId()==1}
<tr>
	<td width="11"></td>
	<td class="{$className}" width="25"></td>
	<td class="{$className}"><b>Итого</b></td>
	<td class="{$className}" align="left"></td>	
	<td class="{$className}" align="center"><b>{$sumTotalMatches}</b></td>
	<td class="{$className}" align="center"><b>{$sumWins}</b></td>
	<td class="{$className}" align="center"><b>{$sumWinsOT}</b></td>
    <td class="{$className}" align="center"><b>{$sumWinsWB}</b></td>	
	<td class="{$className}" align="center"><b>{$sumLOT}</b></td>
    <td class="{$className}" align="center"><b>{$sumLB}</b></td>
	<td class="{$className}" align="center"><b>{$sumL}</b></td>
	<td class="{$className}" align="center"></td>
	<td class="{$className}" align="center"><b>{$sumSuhW}</b></td>
	<td class="{$className}" align="center"><b>{$sumSuhL}</b></td>
	<td class="{$className}" align="center"><b>{$sumGf}</b></td>
	<td class="{$className}" align="center"><b>{$sumGa}</b></td>
	<td class="{$className}" align="center"><b>{$sumGf-$sumGa}</b></td>
	<td class="{$className}" align="center"><b>{($sumGf/$sumTotalMatches)|string_format:"%.2f"}</b></td>
	<td class="{$className}" align="center"><b>{($sumGa/$sumTotalMatches)|string_format:"%.2f"}</b></td>
 	<td width="11"></td>
</tr>
{/if}
			</tbody>
		</table>
</small>
{/if}			
 
			</div>
		</div>
	</div>
</div>
</div>