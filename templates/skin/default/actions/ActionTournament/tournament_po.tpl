{include file='header.tpl' menu_content='tournament' noSidebar=true }
<style>
{literal}
#sidebar {
display: none;
}
.column-container{
margin-left: 15px;
}
.column1 {
float: left;
width: 148px; 
}
.column1 .afc-block {
margin-top: 15px;
}
.column1 .game-tile {
margin-bottom: 45px;
}
.column2 {
float: left;
margin-left: 2px;
width: 148px;
}
.column2 .afc-block {
margin-top: 60px;
}
.column2 .game-tile {
margin-bottom: 145px;
}
.column3 {
float: left;
margin-left: 2px;
width: 148px;
}
.column3 .afc-block {
margin-top: 165px;
}
.column3 .game-tile {
margin-bottom: 350px;
}

.column4 {
float: left;
margin-left: 2px;
width: 148px;
}

.column4 .afc-block {
margin-top: 365px;
}
.column-container .cell {
/*background-color: #EDF5F8;*/
height: 18px;
margin-bottom: 7px;
padding: 7px 0 0 6px;
position: relative;
} 
</style>
{/literal}

<div class="column-container">
{if $aPlayoff}
{assign var=key value=0}
{assign var=round value=''}
{foreach from=$aPlayoff item=oPlayoff name=el2}
{if $round!=$oPlayoff.round and $round!=''}
		</div>
	</div>	
{/if}

{if $round!=$oPlayoff.round}
{assign var=key value=$key+1}
	<div class="column{$key}">
		<div class="afc-block">
{assign var=round value=$oPlayoff.round}
{/if}
			{if $oPlayoff.num % 2  == 1}		
			<div class="game-tile">
			{/if}
				<div class="cell">
				{if $oPlayoff.teamintournament_id!=0}
					<table>
						<tr>
							<td width="25">
								{if $oPlayoff.team}<img width="20" src="{cfg name='path.root.web'}/images/teams/small/{$oPlayoff.team->getLogo()}"/>{/if}
								{if $oPlayoff.user}<img style="height:20px; width:20px;" src="{$oPlayoff.user->getAvatarUrl()}">{/if}
							</td>
							<td width="150">
								<a href="#" class="teamrasp">
									{if $oPlayoff.team}<a href="{if $oPlayoff.team->getBlog()}{$oPlayoff.team->getBlog()->getTeamUrlFull()}{else}{router page='team'}{$oPlayoff.team->getTeamId()}{/if}" class="teamrasp">{$oPlayoff.team->getName()}</a>{/if}
									{if $oPlayoff.user}{$oPlayoff.user->getLogin()}{/if}
								</a>
							</td>
							{if $oGame->getSportId()=='2'}
								{foreach from=$oPlayoff.matches_played item=match name=el2}
									{if $match.match_id}
										<td width="10"><a href="{$oTournament->getUrlFull()}match_comment/{$match.match_id}" target="_blank" title="{$match.result}">{$match.goals}</a></td>
									{/if}
								{/foreach}
							{elseif $oGame->getSportId()=='6'}
								{foreach from=$oPlayoff.matches_played item=match name=el2}
									{if $match.match_id}
										<td width="10"><a href="{$oTournament->getUrlFull()}match_comment/{$match.match_id}" target="_blank" title="{$match.result}">{if $match.goals==2}W{/if}{if $match.goals==0}L{/if}</a></td>
									{/if}
								{/foreach}
							{else}
								<td width="20"> {$oPlayoff.wins|number_format}</td>
							{/if}
						</tr>
					</table>
				{/if}
				</div>
			{if $oPlayoff.num % 2  == 0}	
			</div>
			{/if}


{/foreach}
		</div>
	</div>		
{/if}
</div>

{include file='footer.tpl'} 