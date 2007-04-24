<div id="loginForm">
    <form action="{$form.action}" method="post" name="userLogin" id="userLogin">
        {form->hidden name="url" id="backUrlField" value=$form.backUrl}
        <table border="0" cellpadding="1" cellspacing="0" width="230">
            <tr>
                <td align="right">Логин</td>
                <td align="center">{form->text name="login" size=10 id="loginField"}</td>
                <td align="center">{form->checkbox name="save" text="Запомнить" value="1"}</td>
            </tr>
            <tr>
                <td align="right">Пароль</td>
                <td align="center">{form->password name="password" size=10 id="passwordField"}</td>
                <td align="center" colspan="2">{form->submit name="submit" value="Вход"}</td>
            </tr>
        </table>
    </form>
</div>