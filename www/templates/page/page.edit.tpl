<form {$form.attributes}>
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
    {*
    <tr>
        <td colspan="3"><a href="{url section=page action=view params=$[age->getName()}"><img src="{url section="" params="templates/images/back.gif"}" width="16" height="16" /></a></td>

    </tr>
    *}
</table>
</form>
