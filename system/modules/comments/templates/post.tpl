{if $isEdit}
    <div class="jipTitle">Редактирование комментария</div>
{/if}
<form action="{$action}" method="post" {if $isEdit}onsubmit="return jipWindow.sendForm(this);"{/if}>
    {form->hidden name="url" value=$url}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{form->caption name="text" value="Комментарий" onError="style=color: red;" onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
        </tr>
        <tr>
            <td>{form->textarea name="text" value=$text rows="6" cols="70" onError="style=border: red 1px solid;"}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset name="reset" value="Сброс"}</td>
        </tr>
    </table>
</form>