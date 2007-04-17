{if $isEdit}
    <div class="jipTitle">Редактирование комментария</div>
{/if}
<form action="{$action}" method="post" {if $isEdit}onsubmit="return mzzAjax.sendForm(this);"{/if}>
    {form->hidden name="url" value=$url}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>Комментарий</strong></td>
        </tr>
        <tr>
            <td>{form->textarea name="text" value=$text rows="6" cols="70"}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset name="reset" value="Сброс"}</td>
        </tr>
    </table>
</form>