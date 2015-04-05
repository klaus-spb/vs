{include file='header.tpl'  }
{if $aForums}
<div>	
<table class="ipb_table" summary="Sub-forums within the category 'New Forum'">
   <tbody>
	{foreach from=$aForums item=oForum} 
      <tr class="notnew">
         {*<td class="col_c_icon">
            <img src="http://www.skinbox.net/demo/public/style_images/surface/f_icon_read.png">
         </td>*}
         <td class="col_c_forum">
            <h4>
               <strong class="highlight_unread"><a href="{$oForum->getUrlFull()}" title="{$oForum->getTitle()|escape:'html'}">{$oForum->getTitle()|escape:'html'}</a></strong>
            </h4>
            {*<p class="desc __forum_desc forum_desc ipsType_small">This is a subforum.</p>*}
			<ol class="ipsList_inline ipsType_small subforums" id="subforums_6">
				{assign var="aSubForums" value=$oForum->getSubForums()}
				{foreach from=$aSubForums.collection item=oSubForum}				
				<li>
					<a href="{$oSubForum->getUrlFull()}" title="{$oSubForum->getTitle()}">{$oSubForum->getTitle()}</a>
				</li>					
				{/foreach}		
			</ol>
         </td>
         {*<td class="col_c_stats ipsType_small">
            <ul>
               <li>1 topics</li>
               <li>2 replies</li>
            </ul>
         </td>*}
         <td class="col_c_post">
		{assign var="oLastTopic" value=$oForum->getTopic(1, 1)}
		{if $oLastTopic}
            <a href="{$oLastTopic->getUser()->getUserWebPath()}" class="ipsUserPhotoLink left">
            <img src="{$oLastTopic->getUser()->getProfileAvatarPath(48)}" alt="" class="ipsUserPhoto ipsUserPhoto_mini">
            </a>
            <ul class="last_post ipsType_small list-unstyled">
               <li><span class="highlight_unread"><a href="{$oLastTopic->getUrl()}" title="{$oLastTopic->getTitle()|escape:'html'}">{$oLastTopic->getTitle()|escape:'html'}</a></span></li>
               <li>
                  <span class="desc lighter blend_links">
                  <a href="{$oLastTopic->getUrl()}{if $oUserCurrent && $oLastTopic->getIsRead()!= -1 && $oLastTopic->getCommentIdLast()!=0}?cmtpage={$oLastTopic->getPage()}#comment{$oLastTopic->getCommentIdLast()}{else}#comments{/if}" title="View last post">{date_format date=$oLastTopic->getLastUpdate() format='d M Y'}</a>
                  </span>
                  {*By <a hovercard-ref="member" hovercard-id="7" class="url fn name  ___hover___member _hoversetup" href="{$oLastTopic->getUser()->getUserWebPath()}" title="" id="anonymous_element_1"><span itemprop="name">{$oLastTopic->getUser()->getLogin()}</span></a>*}
               </li>
            </ul>
		{/if}
         </td>
      </tr>
      
	{/foreach}
   </tbody>
</table>

</div>
{/if}	
{include file='footer.tpl'}