Создание нового треда в форуме: {$forum->getTitle()}

<form action="{$action}" method="post">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td style='width: 20%;'>{form->caption name="title" value="Название" onError="style=color: red;"}</td>
            <td style='width: 80%;'>{form->text name="title" size="60"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td style='vertical-align: top;'>{form->caption name="title" value="Текст сообщения" onError="style=color: red;"}</td>
            <td>{form->textarea name="text" rows="7" cols="50"}{$errors->get('text')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>{form->submit name="submit" value="Сохранить"} {form->reset name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>