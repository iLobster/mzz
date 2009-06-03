<div class="pageTitle">Менеджер файлов</div>
<div class="moduleActions"><img src="{$SITE_PATH}/templates/images/fileManager/upload.gif" width="15" height="15" alt="" /> <a href="{url route=withAnyParam action=upload name=$current_folder->getTreePath() section="fileManager"}" class="jipLink">Загрузить файл</a></div>
<div style="height: 45px;"></div>

{include file="breadcrumbs.tpl" breadCrumbs=$breadCrumbs section=$current_section module="fileManager"}

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Имя</td>
                <td style="width: 75px; text-align: right;">Размер</td>
                <td style="width: 50px;">Тип</td>
                <td style="width: 60px;">md5-хэш</td>
                <td style="width: 85px;">Скачано</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>

        {if $current_folder->getTreeLevel() != 1}
            <tr align="center">
                <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/pages/folder.gif" alt="" /></td>
                <td style="text-align: left;"><a href="{url route="admin" params=$current_folder->getTreeParent()->getTreePath() module_name=fileManager}">..</a></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>{$current_folder->getJip()}</td>
            </tr>
        {/if}

        {foreach from=$current_folder->getTreeBranch(1) item=folder}
            {if $current_folder->getId() != $folder->getId()}
            <tr align="center">
                <td><img src="{$SITE_PATH}/templates/images/fileManager/folder.gif" alt=""  /></td>
                <td align="left"><a href="{url route='admin' params=$folder->getTreePath() module_name=fileManager}">{$folder->getTitle()}</a></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>{$folder->getJip()}</td>
            </tr>
            {/if}
        {/foreach}

        {foreach from=$current_folder->getFiles() item=file}
            <tr align="center">
                <td style="width: 30px;"><img src="{$SITE_PATH}/templates/images/fileManager/{$file->getExt()}.gif" align="absmiddle" style="padding: 0px 5px;" alt=""  /></td>
                <td style="text-align: left;"><a href="{$file->getDownloadLink()}">{$file->getName()}</a></td>
                <td style="text-align: right;">{$file->getSize()|filesize}</td>
                <td>{$file->getExt()}</td>
                <td>{$file->getMd5()}</td>
                <td>{$file->getDownloads()}</td>
                <td>{$file->getJip()}</td>
            </tr>
        {/foreach}

        <tr class="tableListFoot">
            <td colspan="4">{$pager->toString('admin/main/adminPager.tpl')}</td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
        </tr>
    </table>
</div>