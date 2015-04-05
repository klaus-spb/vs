{if $aTournaments}
<section class="block">
<ul class="nav nav-list custom">
	{foreach from=$aTournaments item=oTournament}
		<li>
			<a href="#" class="dropdown-toggle">
				{if $oTournament->getLogoSmall()}<img src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}" alt="" style="height:23px;"/>{/if}
				<span>{$oTournament->getName()}</span>{if $oTournament->getZavershen()==1} <small>(завершен)</small>{/if}
				<b class="arrow icon-angle-down"></b>
			</a>
			<ul class="submenu">
				<li><a href="{$oTournament->getUrlFull()}"><i class="icon-double-angle-right"></i> {$aLang.plugin.vs.blog}</a></li>
				<li><a href="{$oTournament->getUrlFull()}players/"><i class="icon-double-angle-right"></i> {$aLang.plugin.vs.players}</a></li>
				<li><a href="{$oTournament->getUrlFull()}stats/"><i class="icon-double-angle-right"></i> {$aLang.plugin.vs.standings}</a></li>
				<li><a href="{$oTournament->getUrlFull()}shedule/"><i class="icon-double-angle-right"></i> {$aLang.plugin.vs.schelude}</a></li>
				<li><a href="{$oTournament->getUrlFull()}events/"><i class="icon-double-angle-right"></i> {$aLang.plugin.vs.games}</a></li>
				<li><a href="{$oTournament->getUrlFull()}rules/"><i class="icon-double-angle-right"></i> {$aLang.plugin.vs.rules}</a></li>
			</ul>
		</li>
	{/foreach}
</ul>
</section>
{/if}