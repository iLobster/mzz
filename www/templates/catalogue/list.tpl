{add file="catalogue.css"}
{*{include file="catalogue/tree.tpl" source=$catalogueFolder}*}
{include file="catalogue/dtree.tpl" source=$folders}

<div class="catalogueList">
    {foreach from=$items item="item"}
        {foreach from=$item->exportOldProperties() key="property" item="value"}
            {$item->getPropertyTitle($property)}: {$value}<br/>
        {/foreach}
        {$item->getJip()}
        <br/><br/>
    {foreachelse}
        Нет элементов
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>