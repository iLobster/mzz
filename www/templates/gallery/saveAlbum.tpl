{if $isEdit}
    <div class="jipTitle">�������������� ������� ID: {$album->getId()}</div>
{else}
    <div class="jipTitle">�������� �������</div>
{/if}

<form action="{$form_action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="name" value="��������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="name" value=$album->getName() size="60"}{$errors->get('name')}</td>
        </tr>
        {if $isEdit}
        <tr>
            <td style='width: 20%;'>{form->caption name="main_photo" value="���������� ��� �������" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->select name="main_photo" value=$album->getMainPhoto()->getId() emptyFirst=true options=$photos}{$errors->get('main_photo')}</td>
        </tr>
        {/if}
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="���������"} {form->reset jip=true name="reset" value="������"}</td>
        </tr>
    </table>
</form>