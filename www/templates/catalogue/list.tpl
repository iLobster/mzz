{add file="catalogue.css"}
{*{include file="catalogue/tree.tpl" source=$catalogueFolder}*}
{include file="catalogue/dtree.tpl" source=$folders}

<div class="catalogueList">
    {foreach from=$items item="item"}
        {capture name="tpl"}catalogue/types/{$item->getTypeName()}.tpl{/capture}
        {include file=$smarty.capture.tpl item=$item}
    {/foreach}
{*
    {foreach from=$items item="item"}
        {foreach from=$item->exportOldProperties() key="property" item="value"}
            {$item->getPropertyTitle($property)}: {$value}<br/>
        {/foreach}
        {$item->getJip()}
        <br/><br/>
    {foreachelse}
        ��� ���������
    {/foreach}
*}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>