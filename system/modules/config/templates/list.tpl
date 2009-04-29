<div class="jipTitle">Опции конфигурации модуля <strong>{$folder->getName()|h}</strong></div>
<table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <td colspan="4"><a href="{url route="withId" id=$folder->getId() action="add"}" class="jipLink">Добавить новую опцию</a></td>
    </tr>
    <tr>
        <td><strong>Имя</strong></td>
        <td><strong>Заголовок</strong></td>
        <td><strong>Тип</strong></td>
        <td style="width: 15%;"><strong>Действия</strong></td>
    </tr>
    {foreach from=$options item="option"}
        <tr>
            <td width="20%">{$option->getName()|h}</td>
            <td>{$option->getTitle()|h}</td>
            <td>{$option|@get_class}</td>
            <td>{$option->getTypeTitle()|h}</td>
            <td>
                <a href="{url route="withId" id=$option->getId() action="edit"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/edit.gif" alt="Редактировать" title="Редактировать параметр" /></a>
                <a href="{url route="withId" id=$option->getId() action="delete"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" alt="Удалить" title="Удалить параметр" /></a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="4" style="color: #999;">Для данного модуля не определено ни одного параметра</td>
        </tr>
    {/foreach}

</table>