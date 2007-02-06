<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td colspan=2 style="text-align:center;">Загрузка файла в каталог <b>{$folder->getPath()}</b></td>
        </tr>
        <tr>
            <td>{$form.file.label}</td>
            <td>{$form.file.html}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>