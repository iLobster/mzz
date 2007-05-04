{if $action eq 'addAction'}
    {include file='jipTitle.tpl' title='���������� ��������'}
{else}
    {include file='jipTitle.tpl' title='�������������� ��������'}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td width="40%">{form->caption name="name" value="��������"}</td>
            <td>{form->text name="name" size="30" value=$defaults->get('name')}{$errors->get('name')}</td>
        </tr>
        {if $action eq 'addAction'}
            <tr>
                <td>{form->caption name="dest" value="������� ���������"}</td>
                <td>{form->select name="dest" options=$dests one_item_freeze=1}</td>
            </tr>
        {/if}
        <tr>
            <td>{form->caption name="controller" value="����������"}</td>
            <td>{form->text name="controller" size="30" value=$defaults->get('controller')}</td>
        </tr>
        <tr>
            <td>{form->caption name="title" value="��������� ��� ���� JIP"}</td>
            <td>{form->text name="title" size="30" value=$defaults->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="icon" value="���� �� ����� ����� �� ������ ��� ���� JIP"}</td>
            <td>{form->text name="icon" size="30" value=$defaults->get('icon')}</td>
        </tr>
        <tr>
            <td>{form->caption name="confirm" value="��������� ��� ���������� ������� ��������"}</td>
            <td>{form->text name="confirm" size="30" value=$defaults->get('confirm')}</td>
        </tr>
        <tr>
            <td>{form->caption name="alias" value="�����"}</td>
            <td>{form->select name="alias" null=true options=$aliases value=$defaults->get('alias')}</td>
        </tr>
        <tr>
            <td>{form->caption name="inACL" value="�� �������������� � ACL"}</td>
            <td>{form->checkbox name="inACL" value=$defaults->get('inACL')}</td>
        </tr>
        <tr>
            <td>{form->caption name="jip" value="�������� � JIP"}</td>
            <td>{form->checkbox name="jip" value=$defaults->get('jip')}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset onclick="javascript: jipWindow.close();" name="reset" value="������"}</td>
        </tr>
    </table>
</form>