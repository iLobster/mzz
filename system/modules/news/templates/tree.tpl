{block align="left:120" name="news_tree_view"}
<div>
    <div id="newsFolders">
        <span class="title">{_ categories}</span><br />
        {foreach from=$rootFolder->getTreeBranch() item=current_folder name=folders}
            {if $smarty.foreach.folders.first == false}
            {'&nbsp;&nbsp;'|str_repeat:$current_folder->getTreeLevel()-1}
            {if $newsFolder->getPath() ne $current_folder->getPath()}
                <a href="{url route=withAnyParam section=news action=list name=$current_folder->getPath()}">{$current_folder->getTitle()|htmlspecialchars}</a>
            {else}
                <strong>{$current_folder->getTitle()|htmlspecialchars}</strong>
            {/if}
             {$current_folder->getJip()}
            <br />
            {/if}
        {/foreach}
    </div>
</div>
{/block}