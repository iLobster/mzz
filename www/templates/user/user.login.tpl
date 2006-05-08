<form {$form.attributes}>
{$form.hidden}
<table border="0" cellpadding="0" cellspacing="1" width="280">
    <tr>
        <td align="center">{$form.login.label}</td>
        <td align="center">{$form.login.html}</td>
    </tr>
    <tr>
        <td align="center">{$form.password.label}</td>
        <td align="center">{$form.password.html}</td>
    </tr>
    <tr>
        <td align="center" colspan="2">{$form.submit.html} {$form.reset.html}</td>
    </tr>
</table>
</form>
<p />