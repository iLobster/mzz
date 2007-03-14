{foreach from=$breadCrumbs item="crumb" name="crumb"}
    {if $smarty.foreach.crumb.last}
        <strong>{$crumb->getTitle()}</strong>{$crumb->getJip()}
    {else}
        <a href="{url route='admin' params=$crumb->getPath() section_name=$section module_name=$module}">{$crumb->getTitle()}</a> / 
    {/if}
{/foreach}