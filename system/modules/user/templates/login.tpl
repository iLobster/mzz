{side->hide name="user_loginForm"}
{form action=$form_action method="post" name="userLogin" id="userLogin"}
{form->hidden name="url" id="backUrlField" value=$backURL}
<table border="0" cellpadding="1" cellspacing="0" width="230">
    <tr>
        <td align="right">{_ username}</td>
        <td align="center">{form->text name="login" size=20 id="loginField"}</td>
        <td align="center">{form->checkbox name="save" text="_ remember_login" value="1"}</td>
    </tr>
    <tr>
        <td align="right">{_ password}</td>
        <td align="center">{form->password name="password" size=20 id="passwordField"}</td>
        <td align="center" colspan="2">{form->submit name="submit" value="_ login_process"}</td>
    </tr>
</table>
</form>
