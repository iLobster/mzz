{include file='admin/title.tpl' title='Список страниц'}

{include file='admin/breadcrumbs.tpl' breadCrumbs=$breadCrumbs action='admin' module='page' titleMethod='getName'}

<table class="admin">
    <thead>
        <tr class="center">
            <th class="first" style="width: 30px;">&nbsp;</th>
            <th class="left" style="width: 1%;">{_ identifier}</th>
            <th class="left">{_ title}</th>
            <th class="left" style="width: 1%;">{_ compilable}</th>
            <th class="left" style="width: 1%;">{_ commented}</th>
            <th class="last" style="width: 50px;">JIP</th>
        </tr>
    </thead>
    <tbody>
    {if $pageFolder->getTreeLevel() != 1}
        <tr>
            <td class="first center"><img src="{$SITE_PATH}/images/page/folder.gif" alt="" /></td>
            <td colspan="4"><a href="{url route="admin" params=$pageFolder->getTreeParent()->getTreePath() module_name="page" action_name="admin"}">..</a></td>
            <td class="last center">{$pageFolder->getJip()}</td>
        </tr>
    {/if}

    {foreach from=$pageFolder->getTreeBranch(1) item=current_folder}
        {if $current_folder->getId() != $pageFolder->getId()}
        <tr class="center">
            <td><img src="{$SITE_PATH}/images/page/folder.gif" alt="" /></td>
            <td class="left"><a href="{url route='admin' params=$current_folder->getTreePath() action_name=admin module_name=page}">{$current_folder->getName()|h}</a></td>
            <td class="left" colspan="3"><a href="{url route='admin' params=$current_folder->getTreePath() action_name=admin module_name=page}">{$current_folder->getTitle()|h}</a></td>
            <td class="last">{$current_folder->getJip()}</td>
        </tr>
        {/if}
    {/foreach}

    {foreach from=$pages item=current_page}
        <tr class="center">
            <td><img src="{$SITE_PATH}/images/page/page.gif" alt="" /></td>
            <td class="left"><a href="{url route="pageActions" name=$current_page->getName()}">{$current_page->getName()|h}</a></td>
            <td class="left">{if $current_page->getTitle()}<a href="{url route="pageActions" name=$current_page->getFullPath()}">{$current_page->getTitle()|h}</a>{else}<span style="color: #848484;">&lt;Не указано&gt;</span>{/if}</td>
            <td>{if $current_page->getCompiled()}{_ simple/yes}{else}{_ simple/no}{/if}</td>
            <td>{if $current_page->getAllowComment()}{_ simple/yes}{else}{_ simple/no}{/if}</td>
            <td class="last">{$current_page->getJip()}</td>
        </tr>
    {/foreach}
    </tbody>
    <tfoot>
    <tr class="last">
        <td class="first"></td>
        <td colspan="4">{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last center" style="color: #7A7A7A; white-space: nowrap;">{_ simple/total}: {$pager->getItemsCount()}</td>
    </tr>
    </tfoot>
</table>