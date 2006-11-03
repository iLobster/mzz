<div class="jipTitle">Редактирование новости</div>

<form {$form.attributes}>
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td style='width: 15%;'>ID:</td>
        <td style='width: 85%;'>{$news->getId()}</td>
    </tr>
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
    {*
    <tr>
        <td colspan="3"><a href="{url section=news action=view params=$news->getId()}">назад</a></td>
    </tr>
    *}
</table>
</form>
