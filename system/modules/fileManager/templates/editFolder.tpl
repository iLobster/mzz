{if $isEdit}
    <div class="jipTitle">�������������� ��������</div>
{else}
    <div class="jipTitle">�������� ��������</div>
{/if}

<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 30%;'>{form->caption name="name" value="�������������" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->text name="name" value=$folder->getName() size="40"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="title" value="��������" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->text name="title" value=$folder->getTitle() size="40"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="filesize" value="������������ ������ ����� (� ��)" onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->text name="filesize" value=$folder->getFilesize() size="40"}{$errors->get('filesize')}</td>
        </tr>
        <tr>
            <td style='width: 30%;'>{form->caption name="exts" value='����������� ����������:<br /><span style="font-size: 90%; color: #777;">(���������� ������ ";")</span>' onError="style=color: red;"}</td>
            <td style='width: 70%;'>{form->text name="exts" value=$folder->getExts() size="40"}{$errors->get('exts')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>