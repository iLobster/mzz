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
            {if $property.type == 'select'}
                <strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>
            {elseif $property.type == 'datetime'}
                <strong>{$property.title}:</strong> {$property.value|date_format:$property.args}<br/>
            {elseif $property.type == 'dynamicselect'}
                {if $property.value != 0}<strong>{$property.title}:</strong> {$property.args[$property.value]}<br/>{/if}
            {else}<strong>{$property.title}:</strong> {$property.value}<br/>{/if}
        {/if}
        {/foreach}
</div>