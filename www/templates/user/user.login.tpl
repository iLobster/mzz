<form {$form.attributes}>
{$form.hidden}
<table border="0" cellpadding="0" cellspacing="1" width="70%">
    <tr>
        <td colspan="2">{$form.login.label} {$form.login.html}</td>
        <td colspan="2">{$form.password.label} {$form.password.html}</td>

        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
    {*
    <tr>
        <td colspan=3><a href="{url section=user action=view params=$news->getId()}">�����</a></td>
    </tr>*}
</table>
</form>
<br />