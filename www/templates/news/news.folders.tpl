{foreach from=$folders item=current_folder}
    <a href="/news/{$current_folder->getName()}/list">{$current_folder->getName()}</a> /
{/foreach}