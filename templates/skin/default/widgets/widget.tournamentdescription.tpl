{if $oTournament->getGametypeId()!=3 and $myteamintournament_id==0 and $oTournament->getDatezayavki()!='0000-00-00' and $oTournament->getDatezayavki()|date_format:"%Y%m%d" >= $smarty.now|date_format:"%Y%m%d"}

<section class="block">
    <a href="{$oTournament->getUrlFull()}players/enter/" class="btn btn-danger btn-block">Прими участие, подай заявку</a>
									
</section>

{if $aZayvki}
<table class="table table-striped table-hover">
<tr>
	<th colspan="3">Список приоритетов</th>
</tr>
	{foreach from=$aZayvki item=oZayvka name=el2}
		{assign var=oTeam value=$oZayvka->getTeam()}
		{assign var=zanyato value=0}		
		
		{if $oTeam}
			{foreach from=$aZanTeams item=aTeam name=el2}
				{if $aTeam.team_id==$oTeam->getTeamId()}
				{assign var=zanyato value=1}
				{/if}
			{/foreach}
			<tr>
				<td>{$oZayvka->getPrioritet()}</td>
				<td><img style="height:20px;" src="http://virtualsports.ru/images/teams/small/{$oTeam->getLogo()}"></td>
				<td>{$oTeam->getName()} {if $zanyato==1}занята{/if}</td>
			</tr>
		{/if}
	{/foreach}
</table>
{/if}


{/if}

{if $oTournament->getGametypeId()==8  && $oTeamTournament && $aEvents }
{foreach from=$aEvents item=oEvent}

<section id="when_event_{$oEvent->getEventId()}" class="block">
    <a href="#" onclick="to_event({$oEvent->getEventId()});" class="btn btn-danger btn-block">Запишись на Ивент {$oEvent->getDates()|date_format:"%e %B %Y"}</a>
									
</section>
{/foreach}
{/if}

<div class="block block-tour-page">
	<div class="block-content">	
		<div class="block-tour-page-content">
			{if $oTournament->getLogoFull()}
            <div class="logo" align="center">				
				<img src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoFull()}" alt="" />
            </div>
			{/if}
            <h2>{$oTournament->getName()}</h2>						
			<p><b>Date start: </b>{$oTournament->getDatestart()|date_format:"%e %B %Y"}</p>
		{if $oTournament->getDatezayavki()!='0000-00-00' and $oTournament->getDatezayavki()|date_format:"%Y%m%d" >= $smarty.now|date_format:"%Y%m%d"}<p><b>Registration end: </b>{$oTournament->getDatezayavki()|date_format:"%e %B %Y"}</p>{/if}
			{if $aTournamentAdmins}
			<p><b>Admins: </b>
			{foreach from=$aTournamentAdmins item=oTournamentAdmins name=el2}
				{assign var=oAdmins value=$oTournamentAdmins->getUser()}
				<a class="authors" target="_blank" href="{$oAdmins->getUserWebPath()}"> {$oAdmins->getLogin()}</a>
			{/foreach}
			</p>
			{if $oUserCurrent}
				<p>
					<a href="{router page='content'}topic/add/?blog_id={$oTournament->getBlog()->getId()}" class="blue">
                        <i class="icon-pencil"></i> {$aLang.topic_topic_create} топик
                    </a>
				</p>
			{/if}
			
			{/if}
			{if $aTournamentAssists}
			<p><b>Ассистенты: </b>
			{foreach from=$aTournamentAssists item=oTournamentAssists name=el2}
				{assign var=oAdmins value=$oTournamentAssists->getUser()}
				<a class="authors" target="_blank" href="{$oAdmins->getUserWebPath()}"> {$oAdmins->getLogin()}</a>
			{/foreach}
			</p>
			{/if}
			{if $myteam}
			{if $oTournament->getLeagueName()!=''}
			<p>
				<b>Title</b>: {$oTournament->getLeagueName()}
			</p>
			{/if}
			{if $oTournament->getLeaguePass()!=''}
			<p>
				<b>Пароль</b>: {$oTournament->getLeaguePass()}
			</p>	
			{/if}
			{/if}	
			{if isset($matches_total)}
			<p>
				<b>Played</b>: {$matches_played} / {$matches_total} matches
			</p>
			{/if}
			{if $oTournament->getFond() != 0}
			<p>
				<b>Призовой фонд</b>: {$oTournament->getFond()|string_format:"%.2f"}
			</p>
			{/if}
			{if $oTournament->getWaitlistTopicId() != 0}
			{assign var=oTopic value=$oTournament->getWaitlist()}
			<p>
				<b>Лист ожидания</b>: <a target="_blank" href="{$oTopic->getUrl()}">ссылка</a>
			</p>			
			{/if}
			{if $oTournament->getProlongTopicId() != 0}
			{assign var=oTopic value=$oTournament->getProlong()}
			<p>
				<b>Продление матчей</b>: <a target="_blank" href="{$oTopic->getUrl()}">ссылка</a>
			</p>			
			{/if}

		</div>
	</div>
</div>

<div class="modal modal-login jqmWindow" id="teamplay_form">
    <a href="#" class="close jqmClose"></a>
</div>

<div class="modal modal-login jqmWindow" id="otchetmatch_form">
    <a href="#" class="close jqmClose"></a>
    <div id="divmatchotchet" class="modal-content"></div>
</div>
 
<div class="modal modal-login jqmID4" id="video_form">
	<header class="modal-header">
		<h3>Add video</h3>
		<a href="#" class="close jqmClose"></a>
	</header>
	<div class="modal-content">	
		<form action="javascript:video_save();" >
			<p>
				<input id="video_url" type="text" SIZE="70" maxlength="100"/>
			</p>
			<p>
				<input type="submit" class="button" value="Add video" />
			</p>
		</form>
	</div>
</div>

<div class="modal modal-login jqmWindow" id="prolongmatch_form">
    <a href="#" class="close jqmClose"></a>
    <h3>Продлить матч</h3>
    <form action="javascript:prolong_save();" >
        <select id="srok" class="w70">
            <option value="-3">-3</option>
            <option value="-2">-2</option>
            <option value="-1">-1</option>
            <option value="1" selected="selected">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
        </select>
        <p>
            <textarea id="prichina" class="comment_textarea" cols="1" rows="1"></textarea>
        </p>
        <input type="submit" class="button" value="Внести" /><br />

        <div id="divmatchprolong"></div>
    </form>
</div>

<div class="modal modal-login jqmWindow" id="perenos_form">

	<header class="modal-header">
		<h3>Change match day</h3>
		<a href="#" class="close jqmClose"></a>
	</header>
	<div class="modal-content">
		<form action="javascript:perenos_save();" >
			<p>
				<input data-format="dd.MM.yyyy" name="perenos_time" type='text' id="perenos_time" value='' class='date demo_ranged'/>
			</p>
			<p>
				<input type="submit" class="button" value="Change" />
			</p>
		</form>
	</div>
</div>

<div id="dialog-confirm" style="display:none;" title="Внимание!">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>
        <span id="error_text"></span></p>
</div>





<script type="text/javascript"> 
var tournament_for_hover={$oTournament->getTournamentId()};
var miniturnir_game_for_hover=0;
var miniturnir_gametype_for_hover=0;
 
  {*{literal}
  $(document).ready(function()
	{
		turn_on_hover_team();
	});

{/literal}*}
</script> 	
