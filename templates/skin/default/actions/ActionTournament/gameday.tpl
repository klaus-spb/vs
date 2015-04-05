{if $aZaezd_kval}
<span class="gonka">Квалификация</span><br/>
<ul class="zaezd" id="kval_list">
	{foreach from=$aZaezd_kval item=oZaezd_kval name=el2}
		{assign var=oUser value=$oZaezd_kval->getUser()}
		{assign var=oTeam value=$oZaezd_kval->getTeam()}
		
		<li id="field_{$oZaezd_kval->getZaezdId()}"><span class="gonschik"><a class="author" href="http://virtualsports.ru/profile/{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a></span>
			 <span class="bollid">{$oTeam->getName()|escape:"html"}</span>
			 <span class="best_lap" align="center">{$oZaezd_kval->getBestLap()|escape:"html"}</span>
			{if $admin=="yes"}
					<div class="uf-actions">
						<a href="javascript:kval_edit({$oZaezd_kval->getZaezdId()},{$oZaezd_kval->getMapintournamentId()},{$oUser->getId()})" title="{$aLang.user_field_update}"><img src="{cfg name='path.static.skin'}/images/edit.gif" alt="image" /></a>
						<a href="javascript:kval_delete({$oZaezd_kval->getZaezdId()},{$oZaezd_kval->getMapintournamentId()},{$oUser->getId()})" title="{$aLang.user_field_update}"><img src="{cfg name='path.static.skin'}/images/delete.gif" alt="image" /></a>
					</div>

			{/if}
		</li>
	{/foreach}
</ul>
</br>
<span class="gonka">Гонка</span><br/>
<ul class="zaezd" >
<li><span class="gonschik"><b>Гонщик</b></span>
	 <span class="bollid"><b>Команда</b></span>
	 <span class="times" align="center"><b>Время</b></span>
	 <span class="best_lap" align="center"><b>Лучший круг</b></span>
	 <span class="gonka_points" align="center"><b>Очки</b></span>
</li>
</ul>
<ul class="zaezd" id="gonka_list">
{assign var=Comments value=0}
	{foreach from=$aZaezd_gonka item=oZaezd_gonka name=el2}
		{assign var=oUser value=$oZaezd_gonka->getUser()}
		{assign var=oTeam value=$oZaezd_gonka->getTeam()}
		
		<li id="field_{$oZaezd_gonka->getZaezdId()}"><span class="gonschik"><a class="author" href="http://virtualsports.ru/profile/{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a></span>
			 <span class="bollid">{$oTeam->getName()|escape:"html"}</span>
			 <span class="times" align="center">{$oZaezd_gonka->getTimes()|escape:"html"}</span>
			 <span class="best_lap" align="center">{$oZaezd_gonka->getBestLap()|escape:"html"}</span>
			 <span class="gonka_points" align="center">{$oZaezd_gonka->getPoints()|escape:"html"}</span>
			{if $admin=="yes"}
					<div class="uf-actions">
						<a href="javascript:gonka_edit({$oZaezd_gonka->getZaezdId()},{$oZaezd_kval->getMapintournamentId()},{$oUser->getId()})" title="{$aLang.user_field_update}"><img src="{cfg name='path.static.skin'}/images/edit.gif" alt="image" /></a>
						<a href="javascript:kval_delete({$oZaezd_gonka->getZaezdId()},{$oZaezd_kval->getMapintournamentId()},{$oUser->getId()})" title="{$aLang.user_field_update}"><img src="{cfg name='path.static.skin'}/images/delete.gif" alt="image" /></a>
					</div>
			{/if}
			{if $oUserCurrent->GetUserId()==$oZaezd_gonka->getUserId() || $admin=='yes'}
					<div class="uf-actions">
						<a href="javascript:gonka_comment_edit({$oZaezd_gonka->getZaezdId()},{$oZaezd_kval->getMapintournamentId()},{$oUser->getId()})" title="{$aLang.user_field_update}"><img src="{cfg name='path.static.skin'}/images/edit.gif" alt="image" /></a>
					</div>
			{/if}
		</li>
		{if $oZaezd_gonka->getComment()!=''}{assign var=Comments value=1}{/if}
	{/foreach}
</ul>
{if $Comments==1}
</br>
<span class="gonka">Комментарии</span><br/>
<ul class="zaezd" id="comment_list">
{foreach from=$aZaezd_gonka item=oZaezd_gonka name=el2}
	{if $oZaezd_gonka->getComment()!=''}
		{assign var=oUser value=$oZaezd_gonka->getUser()}
		{assign var=oTeam value=$oZaezd_gonka->getTeam()}
		
		<li id="comment_{$oZaezd_gonka->getZaezdId()}">
			<span class="ava"><a href="{$oUser->getUserWebPath()}"><img class="rounded" src="{$oUser->getProfileAvatarPath(48)}" alt="" class="avatar" /></a></span>
			<span class="gonschik"><a class="author" href="http://virtualsports.ru/profile/{$oUser->getLogin()|escape:"html"}/"><b>{$oUser->getLogin()|escape:"html"}</b></a>
			<br/> ({$oTeam->getName()|escape:"html"})</span> 
			 <span class="gonka_comment" >{$oZaezd_gonka->getComment()}</span>
		</li>
		{if $oZaezd_gonka->getComment()!=1}{assign var=Comments value=1}{/if}
	{/if}
{/foreach}
</ul>
{/if}
{else}
	{if $admin=="yes"}
		<a href="javascript:fill_uch({$mapintournament_id});">Заполнить участников </a>
	{/if}
{/if}
