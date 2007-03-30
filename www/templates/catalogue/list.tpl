{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог :: $catalogueFolderName"}
{add file="catalogue.css"}
{include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
{include file="catalogue/flat.tpl" source=$catalogueFolder}

<div class="catalogueList">
    {foreach from=$items item="item"}
        <h3>{$item->getName()}{$item->getJip()}</h3>
        {foreach from=$item->exportOldProperties() key="property" item="value"}
            <strong>{$item->getPropertyTitle($property)}:</strong> {$value}<br/>
        {/foreach}
        <br/><br/>
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>