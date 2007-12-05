<div class="jipTitle">Опции конфигурации</div>

<table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
    <td colspan="5"><a href="{url route="withAnyParam" name=$name action="addCfg"}" class="jipLink">Добавить новую опцию</a></td>
    </tr>
    <tr>
        <td><strong>Имя</strong></td>
        <td><strong>Заголовок</strong></td>
        <td><strong>Тип</strong></td>
        <td><strong>Значение по-умолчанию</strong></td>
        <td colspan="2"></td>
    </tr>
    {foreach from=$properties item="value" key="param"}
        <tr>
            <td width="20%">{$param}</td>
            <td>{$value.title}</td>
            <td>{$value.type}</td>
            <td>{$value.default}</td>
            <td width="10%" style="text-align: right;">
                <a href="{url route="withId" section="admin" id=$value.id action=editCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать параметр" title="Редактировать параметр" /></a>
                <a href="{url route="withId" section="admin" id=$value.id action=deleteCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить параметр" title="Удалить параметр" /></a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="3" style="color: #999;">Для данного модуля не определено ни одного параметра</td>
        </tr>
    {/foreach}

</table>