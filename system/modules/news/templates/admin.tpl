<div style='width: 99%;'>
<div style="padding: 4px 10px; text-align: right; float: right; margin-top: -2px; background-image: url('{$SITE_PATH}/templates/images/submenu_background.png');"><img src="{$SITE_PATH}/templates/images/filter.gif" align=absmiddle /> Поиск</div>

<div class="pageTitle">{_ news_list}</div>
</div>

{include file="breadcrumbs.tpl" breadCrumbs=$breadCrumbs section=$current_section module="news"}

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">{_ title}</td>
                <td style="width: 120px;">{_ creating_date}</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>

        {if $newsFolder->getTreeLevel() ne 1}
            <tr align="center">
                <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$newsFolder->getTreeParent()->getTreePath() section_name=$current_section module_name=news}">..</a></td>
                <td>-</td>
                <td>{$newsFolder->getJip()}</td>
            </tr>
        {/if}

        {foreach from=$newsFolder->getTreeBranch(1) item=current_folder name=folders}
            {if $current_folder->getId() != $newsFolder->getId()}
                <tr align="center">
                    <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                    <td style="text-align: left;"><a href="{url route='admin' params=$current_folder->getTreePath() section_name=$current_section module_name=news}">{$current_folder->getTitle()|htmlspecialchars}</a></td>
                    <td>-</td>
                    <td>{$current_folder->getJip()}</td>
                </tr>
            {/if}
        {/foreach}

        {foreach from=$news item=current_news}
            <tr align="center">
                <td style="width: 30px; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/news.gif" alt="" title="{_ author}: {$current_news->getEditor()->getLogin()}" /></td>
                <td style="text-align: left;"><a href="{url route='withId' id=$current_news->getId()}">{$current_news->getTitle()|htmlspecialchars}</a></td>
                <td>{$current_news->getUpdated()|date_format:"%d/%m/%Y %H:%M"}</td>
                <td>{$current_news->getJip()}</td>
            </tr>
        {/foreach}

        <tr class="tableListFoot">
            <td colspan="2">{$pager->toString('admin/main/adminPager.tpl')}</td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
        </tr>
    </table>
</div>