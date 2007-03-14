<p class="pageTitle">������ ��������</p>

����:
{include file="breadcrumbs.tpl" breadCrumbs=$breadCrumbs section=$current_section module="news"}

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">��������</td>
                <td style="width: 120px;">���� ��������</td>
                <td style="width: 120px;">�����</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>

        {if $newsFolder->getLevel() ne 1}
            <tr align="center">
                <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$newsFolder->getTreeParent()->getPath() section_name=$current_section module_name=news}">..</a></td>
                <td>-</td>
                <td>-</td>
                <td>{$newsFolder->getJip()}</td>
            </tr>
        {/if}

        {foreach from=$newsFolder->getFolders(1) item=current_folder name=folders}
            <tr align="center">
                <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$current_folder->getPath() section_name=$current_section module_name=news}">{$current_folder->getTitle()}</a></td>
                <td>-</td>
                <td>-</td>
                <td>{$current_folder->getJip()}</td>
            </tr>
        {/foreach}

        {foreach from=$news item=current_news}
            <tr align="center">
                <td style="width: 30px; color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/news/news.gif" /></td>
                <td style="text-align: left;">{$current_news->getTitle()}</td>
                <td>{$current_news->getUpdated()|date_format:"%d/%m/%Y %H:%M"}</td>
                <td>{$current_news->getEditor()->getLogin()}</td>
                <td>{$current_news->getJip()}</td>
            </tr>
        {/foreach}
        
        <tr class="tableListFoot">
            <td>&nbsp;</td>
            <td colspan="2">{$pager->toString()}</td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">...</td>
        </tr>
    </table>
</div>