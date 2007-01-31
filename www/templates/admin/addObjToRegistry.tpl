{if $action eq 'addObjToRegistry'}
{include file='jipTitle.tpl' title='Добавление объекта в реестре доступа'}
{else}
{include file='jipTitle.tpl' title='Редактирование объекта в реестре доступа'}
{/if}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table border="0" cellpadding="5" cellspacing="0" align="center">
        <tr>
            <td>{$form.class.label}</td>
            <td>{$form.class.html}</td>
            <td>{$form.section.label}</td>
            <td>{$form.section.html}{$form.section.error}</td>
        </tr>
        <tr>
            <td colspan=4 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>
{$form.javascript}