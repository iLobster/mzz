<div class="pageTitle">�������� ������</div>
<div class="moduleActions"><img src="{$SITE_PATH}/templates/images/fileManager/upload.gif" width="15" height="15" alt="" /> <a href="{url route=withAnyParam action=upload name=$current_folder->getPath()}" class="jipLink">��������� ����</a></div>
<div style="height: 45px;"></div>

{include file="breadcrumbs.tpl" breadCrumbs=$breadCrumbs section=$current_section module="fileManager"}

<div class="pageContent">
    <table cellspacing="0" cellpadding="3" class="tableList">
        <thead class="tableListHead">
            <tr>
                <td style="width: 30px;">&nbsp;</td>
                <td style="text-align: left;">���</td>
                <td style="width: 75px; text-align: right;">������</td>
                <td style="width: 50px;">���</td>
                <td style="width: 60px;">md5-���</td>
                <td style="width: 85px;">�������</td>
                <td style="width: 30px;">JIP</td>
            </tr>
        </thead>

        {if $current_folder->getTreeLevel() ne 1}
            <tr align="center">
                <td style="color: #8B8B8B;"><img src="{$SITE_PATH}/templates/images/pages/folder.gif" /></td>
                <td style="text-align: left;"><a href="{url route='admin' params=$current_folder->getTreeParent()->getPath() section_name=$current_section module_name=fileManager}">..</a></td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td>{$current_folder->getJip()}</td>
            </tr>
        {/if}

        {foreach from=$current_folder->getFolders() item=folder}
            <tr align="center">
              <td><img src="{$SITE_PATH}/templates/images/fileManager/folder.gif" /></td>
              <td align="left"><a href="{url route='admin' params=$folder->getPath() section_name=$current_section module_name=fileManager}">{$folder->getTitle()}</a></td>
              <td>&nbsp;</td>
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
                <td style="text-align: left;"><a href="{url route=withAnyParam name=$filename}">{$file->getName()}</a></td>
                <td style="text-align: right;">{$file->getSize()|filesize}</td>
                <td>{$file->getExt()}</td>
                <td>{$file->getMd5()}</td>
                <td>{$file->getDownloads()}</td>
                <td>{$file->getJip()}</td>
            </tr>
        {/foreach}

        <tr class="tableListFoot">
            <td colspan="4">{$pager->toString('adminPager.tpl')}</td>
            <td colspan="2" style="text-align: right; color: #7A7A7A;">�����: {$pager->getItemsCount()}</td>
        </tr>
    </table>
</div>