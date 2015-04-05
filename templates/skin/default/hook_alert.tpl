{if $oAdvert}
	{assign var=var_alert value="alert_"|cat:$oAdvert->getAdvertId()}

	{if !$smarty.cookies.$var_alert=='closed'}
	<div class="alert alert-block alert-success" id="{$oAdvert->getAdvertId()}">
		<button type="button" class="close" data-dismiss="alert" onclick="setCookies('{$oAdvert->getAdvertId()}'); return false;">
			<i class="icon-remove"></i>
		</button>
		{$oAdvert->getText()}
	</div>
	{/if}
{/if}