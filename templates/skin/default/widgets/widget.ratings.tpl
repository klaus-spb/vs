<small>
			
<table width="100%" cellspacing="0" class="table">
	<thead>
<tr>
	<th class="lside">№</th>		
	<th class="cside" align="center">Игрок</th>
	<th class="cside">Матчей</th>
	<th class="cside">Рейтинг</th>
</tr>
</thead>
<tbody>
{if $aRatings}
	{assign var=number value=1}
	{foreach from=$aRatings item=oRating name=el2}
	{assign var=oUser value=$oRating->getUser()}
	<tr>
		<td class="{$className}" align="center" width="30">{$number}</td>
		<td class="{$className}" width="150"><a class="authors" href="http://virtualsports.ru/profile/{$oUser->getLogin()}/" target="_blank">{$oUser->getLogin()}</a></td>	
		<td class="{$className}" width="100" align="center">{$oRating->getMatches()}</td>
		<td class="{$className}" width="80" align="center"><b>{$oRating->getRating()}</b></td>
	</tr>
	{assign var=number value=$number+1}
	{/foreach}
{/if}
</tbody>
</table>
<footer>
	<a href="http://virtualsports.ru/rating/{$oGame->getBrief()}/{$oGametype->getBrief()}/_rating">Весь рейтинг</a>
</footer>


</small>