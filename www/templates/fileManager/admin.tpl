<p class="pageTitle">Менеджер файлов</p>

{*
<div style="margin-left: 80px;">
    <table border="0" cellpadding="4" cellspacing="0" width="100%" class="list">
        <tr>
            <td><strong>Имя</strong></td>
            <td><strong>Размер</strong></td>
            <td><strong>Расширение</strong></td>
        </tr>
        {foreach from=$files item=file}
            <tr>
                {assign var="filename" value=$file->getFullPath()}
                <td>{$file->getJip()}<img src="{$SITE_PATH}/templates/images/fileManager/{$file->getExt()}.gif" align="absmiddle" style="padding: 0px 5px;" /><a href="{url route=withAnyParam action=get name=$filename}">{$file->getName()}</a></td>
                <td align="right">{$file->getSize()|filesize}</td>
                <td align="center">{$file->getExt()}&nbsp;</td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="3">
                <img src="{$SITE_PATH}/templates/images/fileManager/upload.gif" align="absmiddle" style="padding-right: 5px;" />
                <a href="{url route=withAnyParam action=upload name=$current_folder->getPath()}" class="jipLink">Загрузить файл</a>
            </td>
        </tr>
    </table>
</div> *}

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Имя</td>
                <td style="width: 120px;">Размер</td>
                <td style="width: 120px;">Расширение</td>
                <td style="width: 120px;">Скачиваний</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>

        {foreach from=$current_folder->getFolders() item=folder}
            <tr align="center">
              <td><img src="{$SITE_PATH}/templates/images/news/folder.gif" /></td>
              <td align="left"><a href="{url route='admin' params=$current_folder->getPath() section_name=news module_name=news}">{$folder->getTitle()}</a></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>{$folder->getJip()}</td>
            </tr>
        {/foreach}
        
        {foreach from=$files item=file}
            {assign var="filename" value=$file->getFullPath()}
            <tr align="center">
                <td style="width: 30px;"><img src="{$SITE_PATH}/templates/images/fileManager/{$file->getExt()}.gif" align="absmiddle" style="padding: 0px 5px;" /></td>
                <td align="left"><a href="{url route=withAnyParam action=get name=$filename}">{$file->getName()}</a></td>
                <td>{$file->getSize()|filesize}</td>
                <td>{$file->getExt()}</td>
                <td>{$file->getDownloads()}</td>
                <td>{$file->getJip()}</td>
            </tr>
        {/foreach}
        
        <tr>
            <td align="center"><img src="{$SITE_PATH}/templates/images/fileManager/upload.gif" align="absmiddle" style="padding-right: 5px;" /></td>
            <td colspan="5"><a href="{url route=withAnyParam action=upload name=$current_folder->getPath()}" class="jipLink">Загрузить файл</a></td>
        </tr>
    </table>
</div>