<form {$form.attributes}>
<table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <td><b>ID:</b></td><td>{$user->getId()}</td>
    </tr>
    <tr>
        <td><b>{$form.login.label}</b></td><td>{$form.login.html}</td>
    </tr>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
{*    <tr>
        <td colspan="3"><a href="{url section=news action=view params=$news->getId()}">назад</a></td>
    </tr> *}
</table>
</form>
