<div class="jipTitle">�������� ���������</div>
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="message[recipient]" value="����������"}</td>
            <td style='width: 80%;'>{form->select name="message[recipient]" options=$users value=$recipient}{$errors->get('message[recipient]')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{form->caption name="message[title]" value="����"}</td>
            <td style='width: 80%;'>{form->text name="message[title]" size="60"}{$errors->get('message[title]')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{form->caption name="message[text]" value="�����"}</td>
            <td style='width: 80%;'>{form->textarea name="message[text]" rows="6" cols="50"}{$errors->get('message[text]')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{*{form->caption name="captcha" value="������� ���:"}*}</td>
            <td style='width: 80%;'>{form->captcha name="captcha"}{$errors->get('captcha')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>