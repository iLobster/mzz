{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог :: $catalogueFolderName"}
{add file="catalogue.css"}

{include file="catalogue/flat.tpl" source=$catalogueFolder}

<div>
    {foreach from=$items item="item"}
        {$item->getJip()}
        <h3>{$item->getName()}</h3>
        {foreach from=$item->exportOldProperties() key="property" item="value"}
            {$item->getPropertyTitle($property)}: {$value}<br/>
        {/foreach}
        {$item->getJip()}
        <br/><br/>
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>