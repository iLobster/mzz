{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог :: $catalogueFolderName"}
{add file="catalogue.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}

<div class="catalogueList">
    {include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
        <h3>{$catalogue->getName()}</a>{$catalogue->getJip()}</h3>
        {foreach from=$catalogue->exportOldProperties() key="propertyName" item="property"}
            {if $property.value ne ''}
            <strong>{$property.title}:</strong> {$property.value}<br/>
            {/if}
        {/foreach}
</div>