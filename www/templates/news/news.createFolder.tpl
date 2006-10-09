<form {$form.attributes}>
{$form.hidden}
<table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <td colspan="2">{$form.title.label} {$form.title.html}</td>
    </tr>
    {*
    <tr>
        <td colspan="2">{$form.text.html}</td>
    </tr>
    *}
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
    <tr>
        <td colspan="3"><a href="{url section=news action=list}"><img src="/templates/images/back.png" width="16" height="16" border="0" /></a></td>
    </tr>
</table>
</form>