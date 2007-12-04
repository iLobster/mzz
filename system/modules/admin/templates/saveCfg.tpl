<div class="jipTitle">{if $isEdit}Редактирование параметра{else}Создание параметра{/if}</div>

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{form->caption name="proptype" value="Тип" onError="style=color: red;"}</td>
            <td>{form->select name="proptype" options=$properties disabled="true"} {$errors->get('proptype')}</td>
        </tr>
        <tr>
            <td>{form->caption name="proptitle" value="Название" onError="style=color: red;"}</td>
            <td>{form->text name="proptitle"} {$errors->get('proptitle')}</td>
        </tr>
        <tr>
            <td>{form->caption name="propname" value="Имя (латиница)" onError="style=color: red;"}</td>
            <td>{form->text name="propname"} {$errors->get('propname')}</td>
        </tr>
        <tr>
            <td>{form->caption name="propdefault" value="Значение по-умолчанию" onError="style=color: red;"}</td>
            <td>{form->text name="propdefault"} {$errors->get('propdefault')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>

{*
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="param" value="Параметр" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="param" value=$configInfo.param size="60"}{$errors->get('param')}</td>
        </tr>
        <tr>
            <td>{form->caption name="title" value="Заголовок" onError="style=color: red;"}</td>
            <td>{form->text name="title" value=$configInfo.title size="60"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="value" value="Значение" onError="style=color: red;"}</td>
            <td>{form->text name="value" value=$configInfo.value size="60"}{$errors->get('value')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
*}