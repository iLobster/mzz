<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
<table border="0" cellpadding="0" cellspacing="1" width="50%">
    {if $action eq 'edit'}
    <tr>
        <td><b>ID:</b></td><td>{$user->getId()}</td>
    </tr>
    {/if}
    <tr>
        <td><b>{$form.login.label}</b></td><td>{$form.login.html}{$form.login.error}</td>
    </tr>
    <tr>
        <td><b>{$form.password.label}</b></td><td>{$form.password.html}{$form.password.error}</td>
    </tr>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
</table>
</form>
