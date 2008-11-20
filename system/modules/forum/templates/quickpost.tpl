<br />
{form action=$action method="post"}
    <table border="0" cellpadding="5" cellspacing="0" class="quickPost">
     <tr>
        <td colspan="2" class="threadHeader"><strong>Быстрый ответ</strong></td>
    </tr>
    <tr>
        <td class="quickReplyForm"></td>
        <td>
            {form->caption name="text" value="Текст сообщения"}<br />
            {form->textarea name="text" rows="7" cols="60"  value=$post->getText()}{$errors->get('text')}<br />
            {form->submit name="submit" value="Отправить"} {form->reset jip="true" name="reset" value="Сбросить"}
        </td>
    </tr>
    </table>
</form>