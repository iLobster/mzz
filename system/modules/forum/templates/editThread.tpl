<div class="jipTitle">�������������� ����� '<b>{$thread->getTitle()}</b>'</div>

<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="title" value="��������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="title" size="60" value=$thread->getTitle()}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td>{form->caption name="title" value="����� ���������" onError="style=color: red;"}</td>
            <td>{form->textarea name="text" rows="7" cols="50" value=$thread->getFirstPost()->getText()}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td style='width: 20%;'>{form->caption name="closed" value="���� �������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->checkbox name="closed" size="60" value=$thread->getIsClosed()}{$errors->get('closed')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>