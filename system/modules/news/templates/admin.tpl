{*<div style='width: 99%;'>
<div style="padding: 4px 10px; text-align: right; float: right; margin-top: -2px; background-image: url('{$SITE_PATH}/images/submenu_background.png');"><img src="{$SITE_PATH}/images/filter.gif" align=absmiddle /> Поиск</div>

</div>*}
<div class="title">{_ news_list}</div>

{include file="admin/breadcrumbs.tpl" breadCrumbs=$breadCrumbs action="admin" module="news"}

<table class="admin">
    <thead>
        <tr class="first center">
            <th class="first" style="width: 30px;">&nbsp;</th>
            <th class="left">{_ title}</th>
            <th style="width: 120px;">{_ creating_date}</th>
            <th style="width: 120px;">{_ update_date}</th>
            <th class="last" style="width: 30px;">JIP</th>
        </tr>
    </thead>

    {if $newsFolder->getTreeLevel() ne 1}
        <tr class="center">
            <td class="first"><img src="{$SITE_PATH}/images/news/folder.gif" alt="folder" /></td>
            <td class="left"><a href="{url route='admin' params=$newsFolder->getTreeParent()->getTreePath() action_name=admin module_name=news}">..</a></td>
            <td>—</td>
            <td>—</td>
            <td class="last">{$newsFolder->getJip()}</td>
        </tr>
    {/if}

    {foreach from=$newsFolder->getTreeBranch(1) item=current_folder name=folders}
        {if $current_folder->getId() != $newsFolder->getId()}
            <tr class="center">
                <td class="first"><img src="{$SITE_PATH}/images/news/folder.gif" alt="folder" /></td>
                <td class="left"><a href="{url route='admin' params=$current_folder->getTreePath() action_name=admin module_name=news}">{$current_folder->getTitle()|htmlspecialchars}</a></td>
                <td>—</td>
                <td>—</td>
                <td class="last">{$current_folder->getJip()}</td>
            </tr>
        {/if}
    {/foreach}

    {foreach from=$news item=current_news}
        <tr class="center">
            <td class="first" style="width: 30px;"><img src="{$SITE_PATH}/images/news/news.gif" alt="" title="{_ author}: {$current_news->getEditor()->getLogin()}" /></td>
            <td class="left"><a href="{url route='withId' module=news id=$current_news->getId()}">{$current_news->getTitle()|htmlspecialchars}</a></td>
            <td>{$current_news->getCreated()|date_format:"%d/%m/%Y %H:%M"}</td>
            <td>{$current_news->getUpdated()|date_format:"%d/%m/%Y %H:%M"}</td>
            <td class="last">{$current_news->getJip()}</td>
        </tr>
    {/foreach}

    <tr class="last">
        <td class="first"></td>
        <td>{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last" colspan="3" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>