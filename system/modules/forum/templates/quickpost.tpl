<br />
{form action=$action method="post"}
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center" style="background-color: #fff; border: 1px solid #D2DCE6;">
     <tr>
        <td colspan="2" class="threadHeader"><strong>Быстрый ответ</strong></td>
    </tr>
    <tr>
        <td width="200"></td>
        <td style='vertical-align: top;'>
            {form->caption name="text" value="Текст сообщения" onError="style=color: red;" onRequired=""}<br />
            {form->textarea name="text" rows="7" cols="60"  value=$post->getText()}{$errors->get('text')}<br />
            {form->submit name="submit" value="Отправить"} {form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>