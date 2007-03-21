{if $isEdit}
    {include file='jipTitle.tpl' title='Редактирование параметра'}
{else}
    {include file='jipTitle.tpl' title='Создание параметра'}
{/if}

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.param.label}</td>
            <td>{$form.param.html}{$form.param.error}</td>
        </tr>
        <tr>
            <td>{$form.title.label}</td>
            <td>{$form.title.html}{$form.title.error}</td>
        </tr>
        <tr>
            <td>{$form.value.label}</td>
            <td>{$form.value.html}{$form.value.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>