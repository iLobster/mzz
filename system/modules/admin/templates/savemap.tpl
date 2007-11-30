{if not $isEdit}
    {include file='jipTitle.tpl' title='Создание поля'}
{else}
    {include file='jipTitle.tpl' title="Редактирование поля '`$field_name`'"}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td width="40%">{form->caption name="field[name]" value="Имя"}</td>
            <td>{form->text name="field[name]" size="30" value=$defaults->get('name') freeze=$isEdit}{$errors->get('field[name]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[accessor]" value="Акцессор"}</td>
            <td>{form->text name="field[accessor]" size="30" value=$defaults->get('accessor')}{$errors->get('field[accessor]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[mutator]" value="Мутатор"}</td>
            <td>{form->text name="field[mutator]" size="30" value=$defaults->get('mutator')}{$errors->get('field[mutator]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[once]" value="Только чтение"}</td>
            <td>{form->checkbox name="field[once]" value=$defaults->get('once')}{$errors->get('field[once]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[orderBy]" value="Порядок сортировки"}</td>
            <td>{form->text name="field[orderBy]" size="30" value=$defaults->get('orderBy')}{$errors->get('field[orderBy]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[orderByDirection]" value="Направление сортировки"}</td>
            <td>{form->select name="field[orderByDirection]" options=$directions value=$defaults->get('orderByDirection') emptyFirst=true}{$errors->get('field[orderByDirection]')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>