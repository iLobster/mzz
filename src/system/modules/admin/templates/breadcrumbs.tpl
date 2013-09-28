<div class="breadcrumbs">
	<span class="breadcrumbsTitle">Путь:</span> <span class="breadcrumbsItems">
	{if !$titleMethod}{$titleMethod = 'getTitle'}{/if}
	{foreach from=$breadCrumbs item="crumb" name="crumb"}
		<a href="{url route='admin' params=$crumb->getTreePath() action_name=$action module_name=$module}">{$crumb->$titleMethod()}</a>
		{if !$smarty.foreach.crumb.last}    
		<img src="{$SITE_PATH}/images/breadcrumb_arrow.gif" alt="" width="10" height="10" />
		{else}
		{$crumb->getJip()}
		{/if}
	{/foreach}
	</span>
</div>