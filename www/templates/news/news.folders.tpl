{foreach from=$folders item=current_folder name=folders}
    <a href="/news/{$current_folder->getName()}/list">{$current_folder->getName()}</a>{if !$smarty.foreach.folders.last} / {/if}
{/foreach}