{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог"}
{add file="catalogue.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}

<div class="catalogueList">
    {include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
    {title append=$catalogue->getName()}
        <h3>{$catalogue->getName()} {$catalogue->getJip()}</h3>
        {include file="catalogue/viewProperties.tpl" properties=$catalogue->exportOldProperties() action="view"}
</div>