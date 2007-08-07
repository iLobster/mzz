{if $action eq 'addAction'}
    {include file='jipTitle.tpl' title='���������� ��������'}
{else}
    {include file='jipTitle.tpl' title='�������������� ��������'}
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="99%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td width="40%">{form->caption name="action[name]" value="��������"}</td>
            <td>{form->text name="action[name]" size="30" value=$defaults->get('name')}{$errors->get('action[name]')}</td>
        </tr>
        {if $action eq 'addAction'}
            <tr>
                <td>{form->caption name="action[dest]" value="������� ���������"}</td>
                <td>{form->select name="action[dest]" options=$dests one_item_freeze=1}</td>
            </tr>
        {else}
            {$defaults->get('dest')}
        {/if}
        <tr>
            <td>{form->caption name="action[controller]" value="����������"}</td>
            <td>{form->text name="action[controller]" size="30" value=$defaults->get('controller')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[title]" value="��������� ��� ���� JIP"}</td>
            <td>{form->text name="action[title]" size="30" value=$defaults->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[icon]" value="���� �� ����� ����� �� ������ ��� ���� JIP"}</td>
            <td>{form->text name="action[icon]" size="30" value=$defaults->get('icon')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[confirm]" value="��������� ��� ���������� ������� ��������"}</td>
            <td>{form->text name="action[confirm]" size="30" value=$defaults->get('confirm')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[alias]" value="�����"}</td>
            <td>{form->select name="action[alias]" emptyFirst=true options=$aliases value=$defaults->get('alias')}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[inACL]" value="�� �������������� � ACL"}</td>
            <td>{form->checkbox name="action[inACL]" value=$defaults->get('inACL') values="1|0"}</td>
        </tr>
        <tr>
            <td>{form->caption name="action[jip]" value="�������� � JIP"}</td>
            <td>{form->checkbox name="action[jip]" value=$defaults->get('jip')}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align:center;">{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>