<form {$form.attributes}>
<table width="50%" border="0" cellpadding="0" cellspacing="1" align="center">
    <tr>
        <td><b>ID:</b> {$news->getId()}</td>
        <td>{$form.title.label} {$form.title.html}</td>
    </tr>
    <tr>
        <td colspan="2">{$form.text.html}</td>
    </tr>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
    {*
    <tr>
        <td colspan="3"><a href="{url section=news action=view params=$news->getId()}">назад</a></td>
    </tr>
    *}
</table>
</form>
