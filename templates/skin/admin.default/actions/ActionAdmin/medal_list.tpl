{extends file='_index.tpl'}

{block name="content-bar"}
<div class="btn-group">
        <a class="btn active" href="{router page='admin'}medals/">
            Medals
        </a>

    </div>

{/block}

{block name="content-body"}
<div class="span12">

    <div class="b-wbox">
        <div class="b-wbox-content nopadding">

            <table class="table table-striped table-condensed pages-list">
                <thead>
 
				<tr style="font-weight:bold;">
					<th>ID</th>
					<th>Какая</th>
					<th>Кому</th>
					<th>Кому</th>
					<th>Кому</th>
					<th>Турнир</th>
					<th></th>
					<th></th>
				</tr>
	
	
                </thead>
				
                <tbody>
					  {foreach from=$aMedals item=oMedal name=el2}
						
							{assign var="oUser" value=$oMedal->getUser()} 
							{assign var="oTournament" value=$oMedal->getTournament()} 
							{assign var="oTeam" value=$oMedal->getTeam()}
							{assign var="oPlayercard" value=$oMedal->getPlayercard()}
							
						<tr  >
							<td style="text-align:center;"> <a href="{router page='adminvs'}medaledit/{$oMedal->getMedalId()}">{$oMedal->getMedalId()}</a></td>
							<td style="text-align:center;"> {$oMedal->getMedal()} &nbsp;</td>
							<td style="text-align:center;"> {if $oUser}<a href="{router page='profile'}{$oUser->getLogin()}">{$oUser->getLogin()}</a> &nbsp;{/if}</td>
							<td style="text-align:center;"> {if $oTeam}{$oTeam->getName()}&nbsp;{/if}</td>
							<td style="text-align:center;"> {if $oPlayercard}{$oPlayercard->getFamily()} {$oPlayercard->getName()}&nbsp;{/if}</td>
							<td style="text-align:center;"> {$oTournament->getBrief()} &nbsp;</td>
							<td style="text-align:center;"> {$oMedal->getMedalText()} </td>
							<td><a href="{router page='admin'}medaldelete/{$oMedal->getMedalId()}">Удалить</a></td>
							
						</tr>
						{/foreach}
	{*
					{foreach $aTeams as $oTeam}
                    <tr>
                        <td>
                            {$oTeam->getTeamId()}
                        </td>
						<td>
                            {$oTeam->getName()|strip_tags|escape:'html'}
                        </td>
						<td>
                            {$oTeam->getBrief()|strip_tags|escape:'html'}
                        </td>
						<td>
                            {$oTeam->getStatus()|strip_tags|escape:'html'}
                        </td>
						<td class="center">
                            <a href="{router page='admin'}newteamedit/{$oTeam->getTeamId()}/"
                               title="edit" class="tip-top i-block">
                                <i class="icon-edit"></i>
                            </a>*}
                            {*<a href="#" title="{$aLang.plugin.seopack.seopack_admin_action_delete}" class="tip-top i-block"
                                  onclick="return admin.confirmDeleteNewTeam('{$oTeam->getTeamId()}', '{cfg name="path.root.web"}{$oTeam->getName()|strip_tags|escape:'html'}'); return false;">
                                <i class="icon-remove"></i>
                            </a>*}
             {*            </td>
                   </tr>
                    {/foreach}*}
                </tbody>
            </table>
        </div>
    </div>

    {include file="inc.paging.tpl"}

</div>

<script>
    var admin = admin || { };

    admin.confirmDeleteNewTeam = function(id, title) {
        admin.confirm({
            header: 'Delete team',
            content: 'Are you sure whant delete team "' + title + '"',
            onConfirm: function() {
                document.location = "{router page='admin'}newteamdelete/" + id + "/?security_ls_key={$ALTO_SECURITY_KEY}";
            }
        })
    }
</script>

{/block}