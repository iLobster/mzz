<table>
    <tr>
        <td><strong>Имя</strong></td>
        <td><strong>Значение</strong></td>
    </tr>
    {foreach from=$params item=value key=param}
        <tr>
            <td>{$param}</td>
            <td>{$value}</td>
            <td>
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=editCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать параметр" title="Редактировать параметр" /></a>
                <a href="{url route="adminCfgEdit" section="admin" id=$data.id name=$param action=deleteCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить параметр" title="Удалить параметр" /></a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="3">Для данного модуля не определено ни одного параметра</td>
        </tr>
    {/foreach}
</table>
<a href="{url route="withId" id=$data.id action=addCfg}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" alt="Добавить параметр" title="Добавить параметр" /></a>
<a href="{url route="withId" id=$data.id action=addCfg}" class="jipLink">Добавить</a>