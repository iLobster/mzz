<div class="jipTitle">�������������� �����</div>

<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='vertical-align: top;'>����</td>
            <td>{form->textarea name="tags" value=$tags rows="4" cols="50"}</td>
        </tr>
        <tr>
            <td style='vertical-align: top;'>������ ����?</td>
            <td>{form->checkbox name="tags" name="shared" text="����� ����" value="0" values="0|1"}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>
