<form {$form.attributes} {if $action eq 'edit'}onsubmit="return mzzAjax.sendForm(this);"{/if}>
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{$form.text.label}</strong></td>
        </tr>
        <tr>
            <td>{$form.text.html}{$form.text.error}</td>
        </tr>
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>