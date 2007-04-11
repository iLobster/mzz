<div class="breadcrumbs">
 <span class="breadcrumbsItems">
 {foreach from=$breadCrumbs item="crumb" name="crumb"}
    {if !$smarty.foreach.crumb.first}{title append=$crumb->getTitle()}{/if}
    {if $smarty.foreach.crumb.last}
        <strong>{$crumb->getTitle()}</strong>{$crumb->getJip()}
    {else}
        <a href="{url route="withAnyParam" name=$crumb->getPath() action="list" section=$current_section module="catalogue"}">{$crumb->getTitle()}</a> / {*<img src="{$SITE_PATH}/templates/images/breadcrumb_arrow.gif" alt="" width="10" height="10" />*} 
    {/if}
 {/foreach}
 </span>
</div>