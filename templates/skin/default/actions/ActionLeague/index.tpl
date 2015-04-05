{*{include file='header.tpl' menu_content='league'}*}
{include file='header.tpl'  menu_content='league'}
<div id="mainpage">
   {*Результаты игр*}
    <div class="bottom-block">
        {include file='blocks.tpl' group='matches'}
    </div>


    {*Слайдер и Таблица*}
    <div class="top-block">
        <ul class="colums">
            <li class="colum1">
                {include file='blocks.tpl' group='sliders'}
            </li>
            <li class="colum2">
                {*{include file='blocks.tpl' group='advertlist'}*}

            </li>
        </ul>
    </div>

    {*Видео и Новости и Прямой эфир*}
{*    <div class="center-block">
        <ul class="colums">
            <li class="colum1">
                {include file='blocks.tpl' group='videolist'}
            </li>
            <li class="colum2">
                {include file='blocks.tpl' group='newslist'}
            </li>
            <li class="colum3">
                {include file='blocks.tpl' group='stream'}
            </li>
        </ul>
    </div>
*}
 
</div>



{assign var="aForums" value=$oBlog->getSubForums()}
{if $aForums}
<div>	
	<table class="table table-talk item-list">
	{foreach from=$aForums.collection item=oForum} 
		<tr>
			<td width="60%">
				{*<a href="{$oForum->getUrlFull()}"><img src="{$oForum->getAvatarPath(48)}" alt="avatar" class="avatar" /></a>*}
				<a href="{$oForum->getUrlFull()}">{$oForum->getTitle()|escape:'html'}</a> </br>
				<small>
				{assign var="aSubForums" value=$oForum->getSubForums()}
				{foreach from=$aSubForums.collection item=oSubForum}				
					<a href="{$oSubForum->getUrlFull()}">{$oSubForum->getTitle()}</a>, 				 
				{/foreach}
				</small>
				
			</td>
			<td>
				
			</td>
			<td>
				{assign var="oLastTopic" value=$oForum->getTopic(1, 1)}
				{if $oLastTopic}
					{*<a href="{$oLastTopic->getUser()->getUserWebPath()}"><img src="{$oLastTopic->getUser()->getProfileAvatarPath(48)}" alt="avatar" class="avatar" /></a>
					*}
					<a href="{$oLastTopic->getUser()->getUserWebPath()}" class="author">{$oLastTopic->getUser()->getLogin()}</a> &rarr;
					<a href="{$oLastTopic->getBlog()->getUrlFull()}" class="blog-name">{$oLastTopic->getBlog()->getTitle()|escape:'html'}</a> &rarr;
					<a href="{$oLastTopic->getUrl()}?cmtpage=last">{$oLastTopic->getTitle()|escape:'html'}</a>
					
					<p>
						<time datetime="{date_format date=$oLastTopic->getLastUpdate() format='c'}">{date_format date=$oLastTopic->getLastUpdate() hours_back="12" minutes_back="60" now="60" day="day H:i" format="j F Y, H:i"}</time> |
					<a href="{$oLastTopic->getUrl()}{if $oUserCurrent && $oLastTopic->getIsRead()!= -1 && $oLastTopic->getCommentIdLast()!=0}?cmtpage={$oLastTopic->getPage()}#comment{$oLastTopic->getCommentIdLast()}{else}#comments{/if}">
						{$oLastTopic->getCountComment()} {if $oLastTopic->getCountCommentNew()}/+{$oLastTopic->getCountCommentNew()}{/if}
					</a>
					</p>
					{*<p>
						{$oLastTopic->getCountComment()} {$oLastTopic->getCountComment()|declension:$aLang.comment_declension:'russian'}
					</p>*}
				{/if}
			</td>
		</tr>
	{/foreach}
	</table>
</div>
{/if}

{include file='topic_list.tpl'}
{include file='footer.tpl'}