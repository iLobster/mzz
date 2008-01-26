<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table>
        <tr>
            <td><strong>{form->caption name="login" value="Логин:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="login" size="30" maxlength="255" onError="style=border: red 1px solid;"} {$errors->get('login')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="email" value="E-mail:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="email" size="30" maxlength="255" onError="style=border: red 1px solid;"} {$errors->get('email')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="password" value="Пароль:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->password value="" name="password" size="30" maxlength="255" onError="style=border: red 1px solid;"} {$errors->get('password')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="repassword" value="Повтор пароля:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->password value="" name="repassword" size="30" maxlength="255" onError="style=border: red 1px solid;"} {$errors->get('repassword')}</td>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip="true" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>