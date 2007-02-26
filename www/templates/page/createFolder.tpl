{if $action eq 'createFolder'}
{include file='jipTitle.tpl' title='Создание папки'}
{else}
{include file='jipTitle.tpl' title='Редактирование папки'}
{/if}

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td style='width: 15%;'>{$form.label.label}</td>
            <td>{$form.label.html}</td>
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
            <td>{$form.submit.html}</td>
            <td>{$form.reset.html}</td>
        </tr>
    </table>
</form>