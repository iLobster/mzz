{if $isEdit}
<div class="jipTitle">�������������� ������������</div>
{else}
<div class="jipTitle">�������� ������������</div>
{/if}
<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        {if $isEdit}
            <tr>
                <td>�������������:</td><td><strong>{$user->getId()}</strong></td>
            </tr>
        {/if}
        <tr>
            <td style='width: 30%;'>{form->caption name="user[login]" value="�����" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->text name="user[login]" value=$user->getLogin() size="40"}{$errors->get('user[login]')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="user[password]" value="������" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->password name="user[password]" size="40"}{$errors->get('user[password]')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>
