{if $isEdit}
    {include file='jipTitle.tpl' title='�������������� ���������'}
{else}
    {include file='jipTitle.tpl' title='�������� ���������'}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="param" value="��������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="param" value=$configInfo.param size="60"}{$errors->get('param')}</td>
        </tr>
        <tr>
            <td>{form->caption name="title" value="���������" onError="style=color: red;"}</td>
            <td>{form->text name="title" value=$configInfo.title size="60"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="value" value="��������" onError="style=color: red;"}</td>
            <td>{form->text name="value" value=$configInfo.value size="60"}{$errors->get('value')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>