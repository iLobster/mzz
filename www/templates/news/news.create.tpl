
<form {$form.attributes}>
{$form.hidden}
<table border="1" width="50%">
    <tr>
        <td colspan="2">{$form.title.label} {$form.title.html}</td>
    </tr>
    <tr>
        <td colspan="2">{$form.text.html}</td>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
    <tr>
        <td colspan=3><a href="{url section=news action=list}">�����</a></td>
    </tr>
</table>
</form>
