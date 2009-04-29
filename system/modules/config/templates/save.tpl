<div class="jipTitle">{if $isEdit}Редактирование опции {$option->getName()|h}{else}Создание новой опции{/if} для модуля {$folder->getName()|h}</div>
{form action=$form_action method="post" jip=true}
<table width="99%" cellpadding="4" cellspacing="0">
    <tr>
        <th>{form->caption name="name" value="Имя"}</th>
        <td>{form->text name="name" value=$option->getName()} {$errors->get('name')}</th>
    </tr>
    <tr>
        <th>{form->caption name="title" value="Заголовок"}</th>
        <td>{form->text name="title" value=$option->getTitle()} {$errors->get('title')}</th>
    </tr>
    <tr>
        <th>{form->caption name="type_id" value="Тип"}</th>
        <td>{form->select options=$types name="type_id" value=$option->getType() emptyFirst=true} {$errors->get('type_id')}</th>
    </tr>
    <tr>
        <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
    </tr>
</table>
</form>