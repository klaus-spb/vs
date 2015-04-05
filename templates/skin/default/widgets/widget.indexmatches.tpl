<style>
.scrollable_matches {
width: 930px;
}
</style>
{if $aMatches}
<div class="scheduler">
   <div class="ui-tabs">
      <div id="tabs_top-38" class="ui-tabs-panel ui-widget-content ui-corner-bottom">
         <a class="prev browse lefts">
         </a>
         <div class="scrollable_matches">
            <div class="items">
               {*-----------------*}  
			   {foreach from=$aMatches item=oMatch name=control}
			   {assign var=oTournament value=$oMatch->getTournament()}
				{assign var=oAwayTeam value=$oMatch->getAwayteam()}
				{assign var=oHomeTeam value=$oMatch->getHometeam()}
               <div>
                  <a rel="nofollow" href="{$oTournament->getUrlFull()}match_comment/{$oMatch->getMatchId()}" target="_blank">
                     <div class="plashka">
                        <div class="short">
                           <div class="shedtr">
                              <div class="shed_subhead_l">
                                 {$oMatch->getPlayDates()|date_format:"%e.%m.%Y"}
                              </div>
                              <div class="shed_subhead_r">
							  {$oMatch->getAdditionalResult()}
                              </div>
                           </div>
                           <div class="shedtr">
                              <div class="shed_row">
                                 {if $oTournament->getKnownTeams()==3}{$oMatch->getAwayteamtournament()->getUser1()->getLogin()}{else}{$oAwayTeam->getShortname()|truncate:15:''}{/if}
                             </div>
                              <div class="shed_row_g">
                                 {$oMatch->getLeftGoals()}
                              </div>
                           </div>
                           <div class="shedtr">
                              <div class="shed_row">
                                 {if $oTournament->getKnownTeams()==3}{$oMatch->getHometeamtournament()->getUser1()->getLogin()}{else}{$oHomeTeam->getShortname()|truncate:15:''}{/if}
                              </div>
                              <div class="shed_row_g">
                                 {$oMatch->getRightGoals()}
                              </div>
                           </div>
                           <div class="shedtr">
                              <div class="shed_subfoot_l">
							  {if $oMatch->getWithVideo() ==1}<i class="icon-facetime-video"></i>{/if}
                              </div>
                              <div class="shed_subfoot_r">
                                 {$oTournament->getName()}
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
			   {/foreach}
               {*-----------------*}    
            </div>
         </div>
         <a class="next browse rigth">
         </a>
      </div>
   </div>
</div>
{/if}
{literal}
<script>
   $(document).ready(function() {
   $('.scrollable_matches').scrollable({
              size: 40, mousewheel: true
          });
   });
</script>
{/literal}