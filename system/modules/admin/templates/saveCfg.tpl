<div class="jipTitle">{if $isEdit}Редактирование параметра "{$property.title}"{else}Создание параметра{/if}</div>

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="proptype" value="Тип" onError="style=color: red;"}</td>
            <td>{form->select name="proptype" options=$properties} {$errors->get('proptype')}</td>
        </tr>
        <tr>
            <td>{form->caption name="proptitle" value="Название" onError="style=color: red;"}</td>
            <td>{form->text name="proptitle" value=$property.title} {$errors->get('proptitle')}</td>
        </tr>
        <tr>
            <td>{form->caption name="propname" value="Имя (латиница)" onError="style=color: red;"}</td>
            <td>{form->text name="propname" value=$property.name} {$errors->get('propname')}</td>
        </tr>
        <tr>
            <td>{form->caption name="propdefault" value="Значение по-умолчанию" onError="style=color: red;"}</td>
            <td>{form->text name="propdefault" value=$property.default} {$errors->get('propdefault')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>