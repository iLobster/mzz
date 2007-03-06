{include file='jipTitle.tpl' title='Редактирование свойства'}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{$form.title.label}</strong></td>
            <td>{$form.title.html}</td>
        </tr>
        <tr>
            <td><strong>{$form.name.label}</strong></td>
            <td>{$form.name.html}</td>
        </tr>
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>