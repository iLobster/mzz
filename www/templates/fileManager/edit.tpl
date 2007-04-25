{assign var="path" value=$file->getFolder()->getPath()}
{assign var="name" value=$file->getName()}
{include file='jipTitle.tpl' title="Редактирование файла `$path`/`$name`"}
<form {$form.attributes} onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.name.label}</td>
            <td>{$form.name.html}{$form.name.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>