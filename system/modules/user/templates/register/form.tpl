{title append="Регистрация пользователя"}
<h2>Регистрация пользователя</h2>
{form action=$form_action method="post"}
    <table>
        <tr>
            <td><strong>{form->caption name="login" value="Логин:"}</strong></td>
            <td>{form->text name="login" size="30" maxlength="255"} {$errors->get('login')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="email" value="E-mail:"}</strong></td>
            <td>{form->text name="email" size="30" maxlength="255"} {$errors->get('email')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="password" value="Пароль:"}</strong></td>
            <td>{form->password value="" name="password" size="30" maxlength="255"} {$errors->get('password')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="repassword" value="Повтор пароля:"}</strong></td>
            <td>{form->password value="" name="repassword" size="30" maxlength="255"} {$errors->get('repassword')}</td>
        </tr>
        <tr>
            <td colspan="2">{form->submit name="submit" value="Зарегистрировать"}</td>
        </tr>
    </table>
</form>