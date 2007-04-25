{assign var="path" value=$page->getFolder()->getPath()}
{assign var="name" value=$page->getTitle()}
{include file='jipTitle.tpl' title="Перемещение страницы '$name' из каталога '$path'"}
<form {$form.attributes} onsubmit="return jipWindow.sendForm(this);">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.dest.label}</td>
            <td>{$form.dest.html}{$form.dest.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>