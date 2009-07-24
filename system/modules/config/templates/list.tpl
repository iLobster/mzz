<div class="jipTitle">Опции конфигурации модуля <strong>{$folder->getName()|h}</strong></div>
<table width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <td colspan="4"><a href="{url route="withId" id=$folder->getName() action="add"}" class="mzz-jip-link">Добавить новую опцию {icon sprite="sprite:mzz-icon/page/add"}</a></td>
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
            <td>{$option->getTypeTitle()|h}</td>
            <td>
                <a href="{url route="withId" id=$option->getId() action="edit"}"  class="mzz-jip-link" title="Редактировать параметр">{icon sprite="sprite:mzz-icon/page-text/edit"}</a>
                <a href="{url route="withId" id=$option->getId() action="delete"}" class="mzz-jip-link" title="Удалить параметр">{icon sprite="sprite:mzz-icon/page-text/del"}</a>
            </td>
        </tr>
    {foreachelse}
        <tr>
            <td colspan="4" style="color: #999;">Для данного модуля не определено ни одного параметра</td>
        </tr>
    {/foreach}

</table>