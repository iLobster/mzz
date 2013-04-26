{fblock position="left" name="news_tree_view"}
<div>
    <div id="newsFolders">
        <span class="title">{_ categories}</span>
        <ul>
        {foreach from=$rootFolder->getTreeBranch() item="current_folder" name="folders"}
            {strip}{if !$smarty.foreach.folders.first}
                {if $current_folder->getTreeLevel() < $lastLevel}
                    {math equation="x - y" x=$lastLevel y=$current_folder->getTreeLevel() assign="levelDown"}
                    {"</li></ul>"|@str_repeat:$levelDown}</li>
                {elseif $lastLevel == $current_folder->getTreeLevel()}
                    </li>
                {else}
                    <ul>
                {/if}
            {/if}{/strip}
            <li>
            {if $newsFolder->getTreePath() != $current_folder->getTreePath()}
                <a href="{url route="withAnyParam" module="news" action="list" name=$current_folder->getTreePath()}">{$current_folder->getTitle()|h}</a>
            {else}
                <strong>{$current_folder->getTitle()|h}</strong>
            {/if}
            {$current_folder->getJip()}
            {strip}{assign var="lastLevel" value=$current_folder->getTreeLevel()}
            {if $smarty.foreach.folders.last}
                {math equation="x - y" x=$lastLevel y=1 assign="levelDown"}
                {"</li></ul>"|@str_repeat:$levelDown}</li>
            {/if}{/strip}
        {foreachelse}
            <li></li>
        {/foreach}
        </ul>
    </div>
</div>
{/fblock}