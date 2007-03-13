<p class="pageTitle">Менеджер файлов</p>
<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">Имя</td>
                <td style="width: 75px; text-align: right;">Размер</td>
                <td style="width: 50px;">Тип</td>
                <td style="width: 85px;">Скачено</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>

        {foreach from=$current_folder->getFolders() item=folder}
            <tr align="center">
              <td><img src="{$SITE_PATH}/templates/images/fileManager/folder.gif" /></td>
              <td align="left"><a href="{url route='admin' params=$folder->getPath() section_name=$current_section module_name=fileManager}">{$folder->getTitle()}</a></td>
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
                <td style="text-align: left;"><a href="{url route=withAnyParam action=get name=$filename}">{$file->getName()}</a></td>
                <td style="text-align: right;">{$file->getSize()|filesize}</td>
                <td>{$file->getExt()}</td>
                <td>{$file->getDownloads()}</td>
                <td>{$file->getJip()}</td>
            </tr>
        {/foreach}
        
        <tr class="tableListFoot">
            <td align="center"><img src="{$SITE_PATH}/templates/images/fileManager/upload.gif" align="absmiddle" style="padding-right: 5px;" /></td>
            <td colspan="5"><a href="{url route=withAnyParam action=upload name=$current_folder->getPath()}" class="jipLink">Загрузить файл</a></td>
        </tr>
    </table>
</div>