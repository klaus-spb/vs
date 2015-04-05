{if $oUserCurrent}
	<p><label for="topic_interviews">Пользователи интервью:</label>
	<input type="text" id="topic_interviews" name="topic_interviews" value="{if $aTopicInterviews}{foreach $aTopicInterviews as $oTopicInterview}{$oTopicInterview->getUser()->getLogin()}, {/foreach}{/if}" class="input-text input-width-full autocomplete-users-sep ui-autocomplete-input" autocomplete="off" role="textbox" aria-autocomplete="list" aria-haspopup="true">
	<small class="note">Укажите пользователей если в статьей имеется их интервью</small></p>
	
	<p><label><input type="checkbox" id="topic_slider_add" name="topic_slider_add" class="input-checkbox" value="1" {if $oTopicEdit && $oTopicEdit->getSliderAdd()}checked="checked"{/if} />
	{$aLang.plugin.vs.slider_add}</label></p>
	
	<p><label><input type="checkbox" id="topic_sticky" name="topic_sticky" class="input-checkbox" value="1" {if $oTopicEdit && $oTopicEdit->getSticky()}checked="checked"{/if} />
	{$aLang.plugin.vs.sticky}</label></p>
	
	<p><label><input type="checkbox" id="topic_faq" name="topic_faq" class="input-checkbox" value="1" {if $oTopicEdit && $oTopicEdit->getFaq()}checked="checked"{/if} />
	{$aLang.plugin.vs.faq}</label></p>
{/if}