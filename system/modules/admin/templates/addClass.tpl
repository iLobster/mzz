{if $isEdit}
{include file='jipTitle.tpl' title='�������������� ������'}
{else}
{include file='jipTitle.tpl' title='���������� ������'}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="name" value="��������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="name" value=$data.name size="60"}{$errors->get('name')}</td>
        </tr>
        <tr>
        {*if !$isEdit*}
            <td style='width: 20%;'>{form->caption name="dest" value="������� ���������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->select name="dest" options=$data.dest one_item_freeze=1}{$errors->get('dest')}</td>
        {*/if*}
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>