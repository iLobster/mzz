{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог"}
{add file="catalogue.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}

<div class="catalogueList">
    {include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
    {title append=$catalogue->getName()}
        <h3>{$catalogue->getName()}</a>{$catalogue->getJip()}</h3>
        {foreach from=$catalogue->exportOldProperties() key="propertyName" item="property"}
        {if $property.value != ''}
            {include file="catalogue/viewProperties.tpl"}
        {/if}
        {/foreach}
</div>