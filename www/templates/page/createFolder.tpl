<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
<table border="0" cellpadding="0" cellspacing="1" width="50%">
    <tr>
        <td colspan="2">{$form.label.label} {$form.label.html}</td>
    </tr>
    <tr>
        <td colspan="2">{$form.name.label} {$form.name.html}{$form.name.error}</td>
    </tr>
    <tr>
        <td colspan="2">{$form.title.label} {$form.title.html}{$form.title.error}</td>
    </tr>
    <tr>
        <td>{$form.submit.html}</td>
        <td>{$form.reset.html}</td>
    </tr>
    <tr>
        <td colspan="3"><a href="{url section=news action=list}"><img src="{$SITE_PATH}/templates/images/back.gif" width="16" height="16" /></a></td>
    </tr>
</table>
</form>