<div style="float:left; margin-right: 70px;">
Текущий каталог: <b>{$current_folder->getPath()}</b><br />

    <table border="0">
        {foreach from=$folders item=folder}
            <tr>
                {math equation="((level-1)*15 + 10)" level=$folder->getLevel() assign=padding}
                <td style="padding-left: {$padding}px;">
                    <img src="{$SITE_PATH}/templates/images/fileManager/folder.gif" align="texttop" style="padding-right: 5px;" /><a href="{url route=withAnyParam section=$current_section action=list name=$folder->getPath()}">{$folder->getTitle()}</a> {$folder->getJip()}
                </td>
            </tr>
        {/foreach}
    </table>
    <div id="folderTree" class="dtree"></div>
</div>

<div>
    <table border="0" cellpadding="4" cellspacing="0" class="list">
        <tr>
            <td><strong>Имя</strong></td>
            <td><strong>Размер</strong></td>
            <td><strong>Расширение</strong></td>
        </tr>
        {foreach from=$files item=file}
            <tr>
                <td>{$file->getJip()}<img src="{$SITE_PATH}/templates/images/fileManager/{$file->getExt()}.gif" align="absmiddle" style="padding: 0px 5px;" />{$file->getName()}</td>
                <td align="right">{$file->getSize()|filesize}</td>
                <td align="center">{$file->getExt()}&nbsp;</td>
                {assign var="path" value=$current_folder->getPath()}
                {assign var="name" value=$file->getName()}
                {assign var="filename" value=`$path`/`$name`}
                <td><a href="{url route=withAnyParam action=get name=$filename}">Скачать</a></td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="3">
                <img src="{$SITE_PATH}/templates/images/fileManager/upload.gif" align="absmiddle" style="padding-right: 5px;" />
                <a href="{url route=withAnyParam action=upload name=$current_folder->getPath()}" class="jipLink">Загрузить файл</a>
            </td>
        </tr>
    </table>
</div>


<script type="text/javascript">
var d = new dTree('d');
d.add(0,-1,'mzzFileManager');

{foreach from=$folders item=current_folder}
{assign var="parentFolder" value=$current_folder->getTreeParent()}
d.add({$current_folder->getId()},{if is_object($parentFolder)}{$parentFolder->getId()}{else}0{/if},'{$current_folder->getName()}','');
{/foreach}
document.getElementById('folderTree').innerHTML = d;
</script>