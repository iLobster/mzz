{assign var="catalogueFolderName" value=$catalogueFolder->getTitle()}
{title append="Каталог"}
{add file="catalogue.css"}
{include file="catalogue/tree.tpl" source=$catalogueFolder}
<div class="catalogueList">
    {include file="catalogue/breadcrumbs.tpl" breadCrumbs=$chains}
    {foreach from=$items item="item"}
        <h3><a href="{url route="withId" module="catalogue" action="view" id=$item->getId()}">{$item->getName()}</a>{$item->getJip()}</h3>
        {include file="catalogue/viewProperties.tpl" properties=$item->exportOldProperties() action="list"}
        <br/><br/>
    {/foreach}
    {if $pager->getPagesTotal() > 1}
        <div class="pages">{$pager->toString()}</div>
    {/if}
</div>