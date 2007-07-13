{include file='jipTitle.tpl' title="Структура объекта класса '`$class`'"}

<table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <td colspan="3"><a href="{url route="withAnyParam" section="admin" name=$class action="addmap"}" class="jipLink">Создать поле</a></td>
    </tr>
    {foreach from=$fields item=field key=key}
        <tr {if in_array($key, $delete)}style="background-color: red;"{/if}>
            <td width="50%">{$key}</td>
            <td style="width: 50%; text-align: right;">
                <a href="{url route="adminMap" section="admin" class=$class field=$key action="editmap"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать поле" /></a>
                {if in_array($key, $delete)}<a href="{url route="adminMap" section="admin" class=$class field=$key action="deletemap"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить поле" /></a>{/if}
           </td>
        </tr>
    {/foreach}
</table>