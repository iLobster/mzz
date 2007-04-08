{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог :: $catalogueFolderName"}
{add file="catalogue.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}

<div class="catalogueList">
    {include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
    {foreach from=$items item="item"}
        <h3>{$item->getName()}{$item->getJip()}</h3>
        {foreach from=$item->exportOldProperties() key="propertyName" item="property"}
            {if $property.value ne ''}
            <strong>{$property.title}:</strong> {$property.value}<br/>
            {/if}
        {/foreach}
        <br/><br/>
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>