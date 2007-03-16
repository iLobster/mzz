{include file='jipTitle.tpl' title="Опции конфигурации"}

<table width="99%" cellpadding="4" cellspacing="0" class="list">
    <tr>
        <td colspan="3"><a href="{url route="withId" id=$data.id action=addCfg}" class="jipLink">Добавить новую опцию</a></td>
    </tr>
    <tr>
        <td><strong>Имя</strong></td>
        <td colspan="2"><strong>Значение</strong></td>
    </tr>
    {foreach from=$params item=value key=param}
        <tr>
            <td width="20%">{$param}</td>
            <td width="70%">{$value}</td>
            <td width="10%" style="text-align: right;">
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=editCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать параметр" title="Редактировать параметр" /></a>
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=deleteCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить параметр" title="Удалить параметр" /></a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="3" style="color: #999;">Для данного модуля не определено ни одного параметра</td>
        </tr>
    {/foreach}

</table>