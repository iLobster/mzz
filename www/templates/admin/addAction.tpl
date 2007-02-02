{if $action eq 'addAction'}
{include file='jipTitle.tpl' title='Добавление экшна'}
{else}
{include file='jipTitle.tpl' title='Редактирование экшна'}
{/if}

<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.name.label}</td>
            <td>{$form.name.html}{$form.name.error}</td>
        </tr>
        {if $action eq 'addAction'}
            <tr>
                <td>{$form.dest.label}</td>
                <td>{$form.dest.html}{$form.dest.error}</td>
            </tr>
        {/if}
        <tr>
            <td>{$form.jip.label}</td>
            <td>{$form.jip.html}{$form.jip.error}</td>
        </tr>
        <tr>
            <td>{$form.title.label}</td>
            <td>{$form.title.html}{$form.title.error}</td>
        </tr>
        <tr>
            <td>{$form.icon.label}</td>
            <td>{$form.icon.html}{$form.icon.error}</td>
        </tr>
        <tr>
            <td>{$form.confirm.label}</td>
            <td>{$form.confirm.html}{$form.confirm.error}</td>
        </tr>
        <tr>
            <td>{$form.inacl.label}</td>
            <td>{$form.inacl.html}{$form.inacl.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>