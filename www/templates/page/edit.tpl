<form {$form.attributes} onsubmit="return sendFormWithAjax(this);return false;">
<table border="0" cellpadding="0" cellspacing="1" width="50%">
    <tr>
        <td>{$form.name.label} {$form.name.html}</td>
        <td>{$form.title.label} {$form.title.html}</td>
    </tr>
    <tr>
        <td colspan="2">{$form.content.html}</td>
    </tr>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
</table>
</form>
