<div id="loginForm">
<form action="{$form.action}" method="post" name="userLogin" id="userLogin">
{textfield type="hidden" name="url" size=10 id="backUrlField" value=$form.backUrl}

<table border="0" cellpadding="1" cellspacing="0" width="230">
    <tr>
        <td align="right">Ћогин</td>
        <td align="center">{textfield name="login" size=10 id="loginField"}</td>
        {* @todo <td align="center">{$form.save.html}</td>*}
    </tr>
    <tr>
        <td align="right">ѕароль</td>
        <td align="center">{textfield type="password" name="password" size=10 id="passwordField"}</td>
        <td align="center" colspan="2"><input name="submit" value="¬ход" type="submit" /></td>
    </tr>
</table>
</form>
</div>