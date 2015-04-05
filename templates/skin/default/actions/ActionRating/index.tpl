{include file='header.tpl'}

<ul class="nav nav-pills custom">		
{foreach from=$aGames item=oGames name=el2}
	{assign var=oPlatform value=$oGames->getPlatform()}
	<li {if $oGame && $oGames->getGameId() == $oGame->getGameId()}class="active"{/if}><a href="{router page='rating'}{$oGames->getBrief()}">{$oGames->getName()} {$oPlatform->getBrief()} </a></li>

{/foreach}
</ul>

{if $oGame}
<div class="hr hr-dotted"></div>

<ul class="nav nav-pills custom">		
{foreach from=$aGametypes item=oGametypes name=el2}
	<li {if $oGametype && $oGametypes->getGametypeId() == $oGametype->getGametypeId()}class="active"{/if}><a href="{router page='rating'}{$oGame->getBrief()}/{$oGametypes->getBrief()}/_rating">{$oGametypes->getName()}</a></li>
{/foreach}
</ul>
{/if}


<div align="center">
{if $aRating}

<table  cellspacing="0" class="raspisanie" id="allteams">
<thead>
<tr>
	<th class="lside" width="11"></th>
	<th class="cside" align="center">№</th>
	<th class="cside" align="center">Ник</th>	
	<th class="cside" align="center">Рейтинг</th>
	<th class="cside">Кол-во матчей</th>
	<th class="rside" width="11"></th>
</tr>
</thead>
{assign var=className value='vlight'}
{assign var=number value=1}
{foreach from=$aRating item=oRating name=el2}
{assign var=oUser value=$oRating->getUser()}
<tr>
	<td  width="11"></td>
	<td class="{$className}" align="center" width="30">{$number}</td>
	<td class="{$className}" width="150"><a class="authors" href="http://virtualsports.ru/profile/{$oUser->getLogin()}/" target="_blank">{$oUser->getLogin()}</a></td>	
	<td class="{$className}" width="80" align="center"><b>{$oRating->getRating()}</b></td>
	<td class="{$className}" width="100" align="center">{$oRating->getMatches()}</td>
	<td width="11"></td>
</tr>
{assign var=number value=$number+1}
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
{else}
Извините, пока в рейтинге по данному типу турнира никого нет.
{/if}
</div>
{include file='footer.tpl'}