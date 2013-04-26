<h1>{_ login}</h1>
{form action=$form_action method="post"}
    <div>
        {form->hidden name="url" id="backUrlField" value=$backURL}
        <table border="0" cellpadding="1" cellspacing="0" width="140">
            <tr>
                <td colspan="2">{form->caption name="login" value="_ username"}</td>
            </tr>
            <tr>
                <td colspan="2">
                    {form->text name="login" size=30}
                    {if $validator->isFieldError('login')}<div class="error">{$validator->getFieldError('login')}</div>{/if}
                </td>
            </tr>
            <tr>
                <td colspan="2">{form->caption name="password" value="_ password"}</td>
            </tr>
            <tr>
                <td colspan="2">
                    {form->password name="password" size=30}
                    {if $validator->isFieldError('password')}<div class="error">{$validator->getFieldError('password')}</div>{/if}
                </td>
            </tr>

            <tr>
                <td>{form->checkbox name="save" id="saveLogin" value="1"}</td>
                <td style="width: 100%"><label for="saveLogin">{_ remember_login}</label></td>
            </tr>

            <tr>
                <td colspan="2">{form->submit name="submit" value="_ login_process"}</td>
            </tr>

        </table>
    </div>
</form>