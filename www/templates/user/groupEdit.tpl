{if $isEdit}
    {assign var=name value=$group->getName()}
    {include file='jipTitle.tpl' title="�������������� ������ $name"}
{else}
    {include file='jipTitle.tpl' title='�������� ������'}
{/if}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        {if $isEdit}
            <tr>
                <td>�������������:</td>
                <td><strong>{$group->getId()}</strong></td>
            </tr>
        {/if}
        <tr>
            <td style='width: 30%;'>{form->caption name="name" value="���" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->text name="name" value=$group->getName() size="40"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="is_default" value="�������� � ��� ������<br /> ����������� �������������:" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->checkbox name="is_default" value=$group->getIsDefault() size="40"}{$errors->get('is_default')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset onclick="javascript: jipWindow.close();" name="reset" value="������"}</td>
        </tr>
    </table>
</form>