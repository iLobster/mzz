<div class="jipTitle">{if $isEdit}Редактирование опции {$option->getName()|h}{else}Создание новой опции{/if} модуля {$folder->getName()|h}</div>
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
        <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
    </tr>
</table>
</form>