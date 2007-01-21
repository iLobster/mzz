{if $action eq 'createFolder'}
{include file='jipTitle.tpl' title='Создание папки'}
{else}
{include file='jipTitle.tpl' title='Редактирование папки'}
{/if}

<form {$form.attributes} onsubmit="return sendFormWithAjax(this);return false;">
{$form.hidden}
<table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
    <tr>
        <td style='width: 15%;'>{$form.label.label}</td>
        <td style='width: 85%;'>{$form.label.html}</td>
    </tr>
    <tr>
        <td>{$form.name.label}</td>
        <td>{$form.name.html} {$form.name.error}</td>
    </tr>
    <tr>
        <td>{$form.title.label}</td>
        <td>{$form.title.html} {$form.title.error}</td>
    </tr>
    <tr>
        <td colspan=2>{$form.submit.html} {$form.reset.html}</td>
    </tr>
</table>
</form>
