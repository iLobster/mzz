<div class="title">Менеджер файлов</div>
{*<div class="moduleActions"><img src="{$SITE_PATH}/images/fileManager/upload.gif" width="15" height="15" alt="" /> <a href="{url route=withAnyParam action=upload name=$current_folder->getTreePath() section="fileManager"}" class="mzz-jip-link">Загрузить файл</a></div>*}

{include file="admin/breadcrumbs.tpl" breadCrumbs=$breadCrumbs action=admin module=fileManager}

<table class="admin">
    <thead>
        <tr class="first center">
            <th class="first" style="width: 30px;">&nbsp;</th>
            <th class="left">Имя</th>
            <th>Размер</th>
            <th>Тип</th>
            <th>Скачано</th>
            <th class="last" style="width: 30px;">JIP</th>
        </tr>
    </thead>

    {if $current_folder->getTreeLevel() != 1}
        <tr class="center">
            <td class="first"><img src="{$SITE_PATH}/images/fileManager/folder.gif" alt="" title="" /></td>
            <td class="left"><a href="{url route='admin' params=$current_folder->getTreeParent()->getTreePath() action_name=admin module_name=fileManager}">..</a></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
            <td class="last">-</td>
        </tr>
    {/if}

    {foreach from=$current_folder->getTreeBranch(1) item=folder}
        {if $current_folder->getId() != $folder->getId()}
            <tr class="center">
                <td class="first"><img src="{$SITE_PATH}/images/fileManager/folder.gif" alt="" title="" /></td>
                <td class="left"><a href="{url route='admin' params=$folder->getTreePath() action_name=admin module_name=fileManager}">{$folder->getTitle()}</a></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td class="last">{$folder->getJip()}</td>
            </tr>
        {/if}
    {/foreach}

    {foreach from=$files item=file}
        <tr class="center">
            <td class="first"><img src="{$SITE_PATH}/images/fileManager/{$file->getExt()}.gif" alt="" title="" /></td>
            <td class="left"><a href="{$file->getDownloadLink()}">{$file->getName()}</a></td>
            <td>{$file->getSize()|filesize}</td>
            <td>{$file->getExt()}</td>
            <td>{$file->getDownloads()|default:0}</td>
            <td class="last">{$file->getJip()}</td>
        </tr>
    {/foreach}

    <tr class="last">
        <td class="first" colspan="4">{$pager->toString('admin/main/adminPager.tpl')}</td>
        <td class="last" colspan="2" style="text-align: right; color: #7A7A7A;">Всего: {$pager->getItemsCount()}</td>
    </tr>
</table>