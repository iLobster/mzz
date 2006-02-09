{foreach from=$folders item=current_folder name=folders}
    <a href="{url section=news action=list params=$current_folder->getName()}">{$current_folder->getName()}</a>
    {if !$smarty.foreach.folders.last}
        /
    {/if}
{/foreach}