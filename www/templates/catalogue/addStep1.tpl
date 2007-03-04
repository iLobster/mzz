<div class="jipTitle">Добавление нового элемента - выбор типа создаваемого элемента</div>
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{$form.type.label}</strong></td>
            <td>{$form.type.html}</td>
        </tr>
        <tr>
            <td>{$form.submit.html}</td>
        </tr>
        <tr>
            <td>{$form.reset.html}</td>
        </tr>
    </table>
</form>