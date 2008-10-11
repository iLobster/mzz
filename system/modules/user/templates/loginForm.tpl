<p class="sideBlockTitle">Вход</p>
<div class="sideBlockContent">
<div id="loginForm">
    {form action=$form_action method="post" id="userLogin"}
        {form->hidden name="url" id="backUrlField" value=$backURL}
        <table border="0" cellpadding="1" cellspacing="0" width="140">
            <tr>
                <td colspan="2"><label for="loginField">Логин</label></td>
            </tr>
            <tr>
                <td colspan="2">{form->text name="login" size=10 style="width: 135px;" id="loginField"}</td>
            </tr>
            <tr>
                <td colspan="2"><label for="passwordField">Пароль</label></td>
            </tr>
            <tr>
                <td colspan="2">{form->password name="password" size=10 style="width: 135px;" id="passwordField"}</td>
            </tr>

            <tr>
                <td>{form->checkbox name="save" id="saveLogin" value="1"}</td>
                <td width="100%"><label for="saveLogin">Запомнить</label></td>
            </tr>

            <tr>
                <td colspan="2">{form->submit name="submit" value="Войти"}</td>
            </tr>

        </table>
    </form>
</div>
</div>


