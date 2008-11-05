{form action=$form_action method="post" id="userLogin"}
<div class="loginForm">
{form->hidden name="url" id="backUrlField" value=$backURL}
    <table border="0" cellpadding="1" cellspacing="0" width="230">
        <tr>
            <td align="right">Логин</td>
            <td align="center">{form->text name="login" size=10 id="loginField" tabindex="1"}</td>
            <td align="center">{form->checkbox name="save" text="Запомнить" value="1" tabindex="3"}</td>
        </tr>
        <tr>
            <td align="right">Пароль</td>
            <td align="center">{form->password name="password" size=10 id="passwordField" tabindex="2"}</td>
            <td align="center" colspan="2">{form->submit name="submit" value="Вход"}</td>
        </tr>
    </table>
</div>
</form>
