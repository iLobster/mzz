<form {$form.attributes} onsubmit="return sendFormWithAjax(this);return false;">
{$form.hidden}
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td>{$form.title.label}</td>
        <td>{$form.title.html}</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td>{$form.text.html}</td>
    </tr>
    <tr>
        <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
    </tr>
</table>
</form>
