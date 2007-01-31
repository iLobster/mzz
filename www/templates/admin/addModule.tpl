{if $action eq 'addModule'}
{include file='jipTitle.tpl' title='Добавление модуля'}
{else}
{include file='jipTitle.tpl' title='Редактирование модуля'}
{/if}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.name.label}</td>
            <td>{$form.name.html}{$form.name.error}</td>
        </tr>
        <tr>
            <td>{$form.dest.label}</td>
            <td>{$form.dest.html}{$form.dest.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>