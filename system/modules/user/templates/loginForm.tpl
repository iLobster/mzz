<p class="sideBlockTitle">����</p>
<div class="sideBlockContent">
<div id="loginForm">
    <form action="{$form_action}" method="post" name="userLogin" id="userLogin">
        {form->hidden name="url" id="backUrlField" value=$backURL}
        <table border="0" cellpadding="1" cellspacing="0" width="140">
            <tr>
                <td colspan="2"><label for="loginField">�����</label></td>
            </tr>
            <tr>
                <td colspan="2">{form->text name="login" size=10 style="width: 100%;" id="loginField"}</td>
            </tr>
            <tr>
                <td colspan="2"><label for="passwordField">������</label></td>
            </tr>
            <tr>
                <td colspan="2">{form->password name="password" size=10 style="width: 100%;" id="passwordField"}</td>
            </tr>

            <tr>
                <td>{form->checkbox name="save" id="saveLogin" value="1"}</td>
                <td width="100%"><label for="saveLogin">���������</label></td>
            </tr>

            <tr>
                <td colspan="2">{form->submit name="submit" value="�����"}</td>
            </tr>

        </table>
    </form>
</div>        
</div>


