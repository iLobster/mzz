{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог"}
{add file="catalogue.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}

<div class="catalogueList">
    {include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
    {foreach from=$items item="item"}
        <h3><a href="{url route="withId" module="catalogue" action="view" id=$item->getId()}">{$item->getName()}</a>{$item->getJip()}</h3>
        {foreach from=$item->exportOldProperties() key="propertyName" item="property"}
            {if $property.value ne '' AND $property.isShort eq TRUE}
                {if $property.type == 'select'}
            <strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>
                {else}
            <strong>{$property.title}:</strong> {$property.value}<br/>
                {/if}
            {/if}
        {/foreach}
        <br/><br/>
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>