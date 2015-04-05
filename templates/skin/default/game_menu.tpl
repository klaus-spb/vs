
<style>
.yamm .yamm-content {
padding: 0px;
}
</style>
{if {cfg name='sys.site'} == 'vs'}
<div class="navbar yamm">
<div class="navbar-inner">
	<div class="span4 brand_height">
		<div class="logo"><a href="{if $oBrand && $oBlog && $oBrand->getLogoImage()}{$oBlog->getTeamUrlFull()}{else}{cfg name='path.root.web'}{/if}" rel="home" class="logos"><img src="{if $oBrand && $oBrand->getLogoImage()}{cfg name='path.root.web'}{$oBrand->getLogoImage()}{else}http://virtualsports.ru/templates/skin/btch/images/logo.png{/if}"></a></div>
	</div><!-- .span -->
	<div class="span8 brand_height">
		<div class="nav-collapse" id="nav1">
              <ul class="nav">
			  
{foreach from=$aMenus_topics item=oMenu key=k}
			  
                <!-- Classic list -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {$sports_name.$k} <b class="caret"></b> </a>
                  <ul class="dropdown-menu">
                    
					
					<li>
                      <!-- Content container to add padding -->
                      <div class="yamm-content">
						{if $aMenus_tournaments.$k.actual}
						{assign var=aTournaments value=$aMenus_tournaments.$k.actual}
                        <ul class=" menulist">
                          <li><p><strong>Текущие турниры</strong></p></li>
						  {foreach from=$aTournaments item=oTournament}
                          <li>
                           {if $oTournament->getLogoSmall()}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/>{/if} <a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
						{if $aMenus_tournaments.$k.future}
						{assign var=aTournaments value=$aMenus_tournaments.$k.future}
                        <ul class=" menulist">
                          <li><p><strong>Идет набор</strong></p></li>
						  {foreach from=$aTournaments item=oTournament}
                          <li>
                            {if $oTournament->getLogoSmall()}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/>{/if} <a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
						{if $aMenus_tournaments.$k.my}
						{assign var=aTournaments value=$aMenus_tournaments.$k.my}
                        <ul class=" menulist">
                          <li><p><strong>Мои турниры</strong></p></li>
						  {foreach from=$aTournaments item=oTournament}
                          <li>
                            {if $oTournament->getLogoSmall()}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/>{/if} <a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
						{*{if $aMenus_topics.$k.faq.0}
						{assign var=aTopics value=$aMenus_topics.$k.faq.0}
                        <ul class=" menulist">
                          <li><p><strong>Полезное</strong></p></li>
						  {foreach from=$aTopics item=oTopic}
                          <li>
                            <a href="{$oTopic->getUrl()}">{$oTopic->getTitle()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}*}
						
						{if $aMenus_topics.$k.faq_topics.0}
						{assign var=aTopics value=$aMenus_topics.$k.faq_topics.0}
                        <ul class=" menulist">
                          <li><p><strong>Полезное</strong></p></li>
						  {foreach from=$aTopics item=topic}
                          <li>
                            <a href="{$topic.url}">{$topic.title}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
                      </div>
                    </li>
                  </ul>
                </li>
{/foreach}
 <!-- Classic list -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> Сайт <b class="caret"></b> </a>
                  <ul class="dropdown-menu">
					<li>
                      <!-- Content container to add padding -->
                      <div class="yamm-content">
                        <ul class=" menulist">
                          <li><p><strong>Полезные ссылки</strong></p></li>
						  <li>
                            <a href="http://virtualsports.ru/people/online/">Пользователи</a>
                          </li> 
                          <li>
                            <a href="http://virtualsports.ru/page/koshelek/">Как пополнить кошелек</a>
                          </li>
						  <li>
                            <a href="http://virtualsports.ru/donate/">Donate</a>
                          </li> 
						   <li>
                            <a href="http://virtualsports.ru/rating/">Рейтинги</a>
                          </li> 
						  
						  
                          <li>
                            <a href="http://virtualsports.ru/page/faq/">FAQ</a>
                          </li> 				
                          <li>
                            <a href="http://virtualsports.ru/page/rules/">Правила портала</a>
                          </li>
						<li>
                            <a href="http://consolehockey.com/">ConsoleHockey</a>
                          </li> 						  
                        </ul> 	
                    </li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
			<div id="nav-search">
				<form class="form-search" action="{router page='search'}topics/">
					<span class="input-icon">
						<input autocomplete="off" name="q" id="nav-search-input" class="custom" type="text" class="input-small search-query" placeholder="{$aLang.search} ...">
						<i id="nav-search-icon" class="icon-search"></i>
					</span>
				</form>
			
			</div><!--#nav-search-->
			
        </div> <!-- .span -->
		  

</div>
</div>
{/if}

{if {cfg name='sys.site'} == 'ch'}
<div class="navbar yamm">
<div class="navbar-inner">
	<div class="span4 brand_height">
		<div class="logo"><a href="{if $oBrand && $oBlog && $oBrand->getLogoImage()}{$oBlog->getTeamUrlFull()}{else}{cfg name='path.root.web'}{/if}" rel="home" class="logos"><img src="{if $oBrand && $oBrand->getLogoImage()}{cfg name='path.root.web'}{$oBrand->getLogoImage()}{else}http://virtualsports.ru/templates/skin/btch/images/logo_ch.png{/if}"></a></div>
	</div><!-- .span -->
	<div class="span8 brand_height">
		<div class="nav-collapse" id="nav1">
              <ul class="nav">
			  
{foreach from=$aMenus_topics item=oMenu key=k}
			  
                <!-- Classic list -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> {$sports_name.$k} <b class="caret"></b> </a>
                  <ul class="dropdown-menu">
                    
					
					<li>
                      <!-- Content container to add padding -->
                      <div class="yamm-content">
						{if $aMenus_tournaments.$k.actual}
						{assign var=aTournaments value=$aMenus_tournaments.$k.actual}
                        <ul class=" menulist">
                          <li><p><strong>Tournaments</strong></p></li>
						  {foreach from=$aTournaments item=oTournament}
                          <li>
                           {if $oTournament->getLogoSmall()}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/>{/if} <a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
						{if $aMenus_tournaments.$k.future}
						{assign var=aTournaments value=$aMenus_tournaments.$k.future}
                        <ul class=" menulist">
                          <li><p><strong>Future tournaments</strong></p></li>
						  {foreach from=$aTournaments item=oTournament}
                          <li>
                            {if $oTournament->getLogoSmall()}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/>{/if} <a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
						{if $aMenus_tournaments.$k.my}
						{assign var=aTournaments value=$aMenus_tournaments.$k.my}
                        <ul class=" menulist">
                          <li><p><strong>My tournaments</strong></p></li>
						  {foreach from=$aTournaments item=oTournament}
                          <li>
                            {if $oTournament->getLogoSmall()}<img width="20" src="{cfg name='path.root.web'}/images/tournament/{$oTournament->getUrl()}/{$oTournament->getLogoSmall()}"/>{/if} <a href="{$oTournament->getUrlFull()}">{$oTournament->getName()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}

						{*{if $aMenus_topics.$k.faq.0}
						{assign var=aTopics value=$aMenus_topics.$k.faq.0}
                        <ul class=" menulist">
                          <li><p><strong>Полезное</strong></p></li>
						  {foreach from=$aTopics item=oTopic}
                          <li>
                            <a href="{$oTopic->getUrl()}">{$oTopic->getTitle()}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}*}
						
						{if $aMenus_topics.$k.faq_topics.0}
						{assign var=aTopics value=$aMenus_topics.$k.faq_topics.0}
                        <ul class=" menulist">
                          <li><p><strong>FAQ</strong></p></li>
						  {foreach from=$aTopics item=topic}
                          <li>
                            <a href="{$topic.url}">{$topic.title}</a>
                          </li> 
							{/foreach}
                        </ul> 
						{/if}
						
						
                      </div>
                    </li>
                  </ul>
                </li>
{/foreach}
 <!-- Classic list -->
                <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown"> About <b class="caret"></b> </a>
                  <ul class="dropdown-menu">
					<li>
                      <!-- Content container to add padding -->
                      <div class="yamm-content">
                        <ul class=" menulist">
                          <li><p><strong>Usefull links</strong></p></li>
						  <li>
                            <a href="http://consolehockey.com/people/online/">Users</a>
                          </li> 
						   <li>
                            <a href="http://virtualsports.ru/">VirtualSports.ru</a>
                          </li> 
                          {*<li>
                            <a href="http://virtualsports.ru/page/koshelek/">Как пополнить кошелек</a>
                          </li>
						  <li>
                            <a href="http://virtualsports.ru/donate/">Donate</a>
                          </li> 
						   <li>
                            <a href="http://virtualsports.ru/rating/">Рейтинги</a>
                          </li> 
						  
						  
                          <li>
                            <a href="http://virtualsports.ru/page/faq/">FAQ</a>
                          </li> 				
                          <li>
                            <a href="http://virtualsports.ru/page/rules/">Правила портала</a>
                          </li> *}				  
                        </ul> 	
                    </li>
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
			<div id="nav-search">
				<form class="form-search" action="{router page='search'}topics/">
					<span class="input-icon">
						<input autocomplete="off" name="q" id="nav-search-input" class="custom" type="text" class="input-small search-query" placeholder="{$aLang.search} ...">
						<i id="nav-search-icon" class="icon-search"></i>
					</span>
				</form>
			
			</div><!--#nav-search-->
			
        </div> <!-- .span -->
		  

</div>
</div>
{/if}