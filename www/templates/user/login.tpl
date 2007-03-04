<div id="loginForm">
<form {$form.attributes}>
{$form.hidden}
<table border="0" cellpadding="1" cellspacing="0" width="230">
    <tr>
        <td align="right">{$form.login.label}</td>
        <td align="center">{$form.login.html}</td>
        <td align="center">{$form.save.html}</td>
    </tr>
    <tr>
        <td align="right">{$form.password.label}</td>
        <td align="center">{$form.password.html}</td>
        <td align="center" colspan="2">{$form.submit.html}</td>
    </tr>
</table>
</form>
</div>