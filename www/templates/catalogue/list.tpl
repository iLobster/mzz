{add file="news.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}
<a href="{url route="admin" module_name="catalogue" section_name="catalogue" params="admin"}">Настройка</a><br/><br/>
<div class="newsList">
    {foreach from=$items item="item"}
        {foreach from=$item->exportOldProperties() key="property" item="value"}
            {$item->getTitle($property)}: {$value}<br/>
        {/foreach}
        {$item->getJip()}
        <br/><br/>
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>