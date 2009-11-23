<p class="sideBlockTitle">{_ login}</p>
<div class="sideBlockContent">
{form action=$form_action method="post"}
    <div>
        {form->hidden name="url" id="backUrlField" value=$backURL}
        <table border="0" cellpadding="1" cellspacing="0" width="140">
            <tr>
                <td colspan="2"><label for="loginField">{_ username}</label></td>
            </tr>
            <tr>
                <td colspan="2">{form->text name="login" size=10 style="width: 135px;" id="loginField"}</td>
            </tr>
            <tr>
                <td colspan="2"><label for="passwordField">{_ password}</label></td>
            </tr>
            <tr>
                <td colspan="2">{form->password name="password" size=10 style="width: 135px;" id="passwordField"}</td>
            </tr>

            <tr>
                <td>{form->checkbox name="save" id="saveLogin" value="1"}</td>
                <td style="width: 100%"><label for="saveLogin">{_ remember_login}</label></td>
            </tr>

            <tr>
                <td colspan="2">{form->hidden name="url" value={url}}{form->submit name="submit" value="_ login_process"}</td>
            </tr>

        </table>
    </div>
</form>
</div>