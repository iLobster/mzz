{if $isEdit}
    <div class="jipTitle">�������������� �����</div>
{/if}

<form action="{$action}" method="post"{if $isEdit} onsubmit="return jipWindow.sendForm(this);"{/if}>
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='vertical-align: top;'>{form->caption name="text" value="����� ���������" onError="style=color: red;"}</td>
        </tr>
        <tr>
            <td>{form->textarea name="text" rows="7" cols="50" value=$post->getText()}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="���������"} {form->reset jip="true" name="reset" value="������"}</td>
        </tr>
    </table>
</form>