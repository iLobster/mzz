<form {$form.attributes} {if $action eq 'edit'}onsubmit="return sendFormWithAjax(this);return false;"{/if}>
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td>{$form.text.label}</td>
        </tr>
        <tr>
            <td>{$form.text.html}</td>
        </tr>
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>