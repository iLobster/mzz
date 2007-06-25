<div class="breadcrumbs">
 <span class="breadcrumbsItems">
 {foreach from=$breadCrumbs item="crumb" name="crumb"}
    {if !$smarty.foreach.crumb.first}{if !is_a($crumb, 'catalogue')}{title append=$crumb->getTitle()}{/if}{/if}
    {if $smarty.foreach.crumb.last}
        <strong>{if is_a($crumb, 'catalogue')}{$crumb->getName()}{else}{$crumb->getTitle()}{/if}</strong>{$crumb->getJip()}
    {else}
        <a href="{url route="withAnyParam" name=$crumb->getPath() section=$current_section action="list" module="catalogue"}">{$crumb->getTitle()}</a> / {*<img src="{$SITE_PATH}/templates/images/breadcrumb_arrow.gif" alt="" width="10" height="10" />*} 
    {/if}
 {/foreach}
 </span>
</div>