{if $isEdit}
    <div class="jipTitle">�������������� �����������</div>
{/if}
<form action="{$action}" method="post" {if $isEdit}onsubmit="return mzzAjax.sendForm(this);"{/if}>
    {form->hidden name="url" value=$url}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>�����������</strong></td>
        </tr>
        <tr>
            <td>{form->textarea name="text" value=$text rows="6" cols="70"}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="���������"} {form->reset name="reset" value="�����"}</td>
        </tr>
    </table>
</form>