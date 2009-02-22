{block align="left:120" name="news_tree_view"}
<div>
    <div id="newsFolders">
        <span class="title">{_ categories}</span><br />
{*
        {foreach from=$source->getTreeForMenu() item=current_folder name=folders}
            {'&nbsp;&nbsp;'|str_repeat:$current_folder->getTreeLevel()}
            {if $source->getPath() ne $current_folder->getPath()}
                <a href="{url route=withAnyParam section=news action=list name=$current_folder->getPath()}">{$current_folder->getTitle()|htmlspecialchars}</a>
            {else}
                <strong>{$current_folder->getTitle()|htmlspecialchars}</strong>
            {/if}
             {$current_folder->getJip()}
            <br />
        {/foreach}
*}
    </div>
</div>
{/block}