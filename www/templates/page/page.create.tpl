<form {$form.attributes}>
{$form.hidden}
<table border="0" cellpadding="0" cellspacing="1" width="100%">
    <tr>
        <td colspan="2">{$form.name.label} {$form.name.html}</td>   
    </tr>
    <tr>
        <td colspan="2">{$form.title.label} {$form.title.html}</td>
    </tr>
    <tr>
        <td colspan="2">{$form.content.html}</td>
    </tr>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
    {*<tr>
        <td colspan="3"><a href="{url section=news action=list}">�����</a></td>
    </tr>*}
</table>
</form>