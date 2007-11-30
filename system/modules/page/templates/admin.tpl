<div class="pageTitle">Список страниц</div>

{include file="breadcrumbs.tpl" breadCrumbs=$breadCrumbs section=$current_section module="page"}

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Название</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>
        
        {if $pageFolder->getTreeLevel() ne 1}
            <tr align="center">
                <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/pages/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$pageFolder->getTreeParent()->getPath() section_name=$current_section module_name=page}">..</a></td>
                <td>{$pageFolder->getJip()}</td>
            </tr>
        {/if}
        
        {foreach from=$pageFolder->getFolders(1) item=current_folder name=folders}
            <tr>
                <td align="center"><img src="{$SITE_PATH}/templates/images/pages/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$current_folder->getPath() section_name=$current_section module_name=page}">{$current_folder->getTitle()}</a></td>
                <td style="text-align: center;">{$current_folder->getJip()}</td>
            </tr>
        {/foreach}
        
        {foreach from=$pages item=current_page}
            <tr align="center">
                <td><img src="{$SITE_PATH}/templates/images/pages/page.gif" /></td>
                {assign var=name value=$current_page->getFullPath()}
                <td align="left"><a href="{url route=withAnyParam module=page section=$current_section name=$name}">{$current_page->getTitle()}</a></td>
                <td>{$current_page->getJip()}</td>
            </tr>
        {/foreach}
        <tr class="tableListFoot">
            <td>{$pager->toString('adminPager.tpl')}</td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
        </tr>
    </table>
</div>