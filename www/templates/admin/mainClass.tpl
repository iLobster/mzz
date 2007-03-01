{include file='jipTitle.tpl' title='Редактирование класса'}

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.main_class.label}</td>
            <td>{$form.main_class.html}{$form.main_class.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>