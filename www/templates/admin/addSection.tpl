{if $action eq 'addSection'}
{include file='jipTitle.tpl' title='Добавление раздела'}
{else}
{include file='jipTitle.tpl' title='Редактирование раздела'}
{/if}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.name.label}</td>
            <td>{$form.name.html}{$form.name.error}</td>
        </tr>
        <tr>
            <td>{$form.title.label}</td>
            <td>{$form.title.html}{$form.title.error}</td>
        </tr>
        <tr>
            <td>{$form.order.label}</td>
            <td>{$form.order.html}{$form.order.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>