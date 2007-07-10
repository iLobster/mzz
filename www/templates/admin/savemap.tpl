{if not $isEdit}
    {include file='jipTitle.tpl' title='�������� ����'}
{else}
    {include file='jipTitle.tpl' title="�������������� ���� '`$field_name`'"}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td width="40%">{form->caption name="field[name]" value="���"}</td>
            <td>{form->text name="field[name]" size="30" value=$defaults->get('name') freeze=$isEdit}{$errors->get('field[name]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[accessor]" value="��������"}</td>
            <td>{form->text name="field[accessor]" size="30" value=$defaults->get('accessor')}{$errors->get('field[accessor]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[mutator]" value="�������"}</td>
            <td>{form->text name="field[mutator]" size="30" value=$defaults->get('mutator')}{$errors->get('field[mutator]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[once]" value="������ ������"}</td>
            <td>{form->checkbox name="field[once]" value=$defaults->get('once')}{$errors->get('field[once]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[orderBy]" value="������� ����������"}</td>
            <td>{form->text name="field[orderBy]" size="30" value=$defaults->get('orderBy')}{$errors->get('field[orderBy]')}</td>
        </tr>
        <tr>
            <td>{form->caption name="field[orderByDirection]" value="����������� ����������"}</td>
            <td>{form->select name="field[orderByDirection]" options=$directions value=$defaults->get('orderByDirection') emptyFirst=true}{$errors->get('field[orderByDirection]')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>