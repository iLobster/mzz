<div class="title">Список страниц</div>

{include file="admin/breadcrumbs.tpl" breadCrumbs=$breadCrumbs action="admin" module="page"}

<table class="admin">
    <thead class="tableListHead">
        <tr class="first center">
            <th class="first" style="width: 30px;">&nbsp;</th>
            <th class="left">Название</th>
            <th class="left" style="width: 260px;">Идентификатор</th>
            <th class="last" style="width: 30px;">JIP</th>
        </tr>
    </thead>

    {if $pageFolder->getTreeLevel() != 1}
        <tr>
            <td class="first center"><img src="{$SITE_PATH}/images/page/folder.gif" alt="" /></td>
            <td><a href="{url route="admin" params=$pageFolder->getTreeParent()->getTreePath() module_name="page" action_name="admin"}">..</a></td>
            <td></td>
            <td class="last center">{$pageFolder->getJip()}</td>
        </tr>
    {/if}

    {foreach from=$pageFolder->getTreeBranch(1) item=current_folder name=folders}
        {if $current_folder->getId() != $pageFolder->getId()}
        <tr>
            <td class="first center"><img src="{$SITE_PATH}/images/page/folder.gif" alt="" /></td>
            <td style="text-align: left;"><a href="{url route='admin' params=$current_folder->getTreePath() action_name=admin module_name=page}">{$current_folder->getTitle()|htmlspecialchars}</a></td>
            <td style="text-align: left;"><a href="{url route='admin' params=$current_folder->getTreePath() action_name=admin module_name=page}">{$current_folder->getName()|htmlspecialchars}</a></td>
            <td class="last center">{$current_folder->getJip()}</td>
        </tr>
        {/if}
    {/foreach}

    {foreach from=$pages item=current_page}
        <tr>
            <td class="first center"><img src="{$SITE_PATH}/images/page/page.gif" alt="" /></td>
            <td align="left">{if $current_page->getTitle()}<a href="{url route="pageActions" name=$current_page->getFullPath()}">{$current_page->getTitle()|htmlspecialchars}</a>{else}<span style="color: #848484;">&lt;Не указано&gt;</span>{/if}</td>
            <td align="left"><a href="{url route="pageActions" name=$current_page->getFullPath()}">{$current_page->getName()|htmlspecialchars}</a></td>
            <td class="last center">{$current_page->getJip()}</td>
        </tr>
    {/foreach}
    <tr class="last">
        <td class="first"></td>
        <td>{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last center" colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>