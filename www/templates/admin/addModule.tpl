{if $action eq 'addModule'}
{include file='jipTitle.tpl' title='���������� ������'}
{else}
{include file='jipTitle.tpl' title='�������������� ������'}
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
            <td>{$form.title.label}</td>
            <td>{$form.title.html}{$form.title.error}</td>
        </tr>
        <tr>
            <td>{$form.icon.label}</td>
            <td>{$form.icon.html}{$form.icon.error}</td>
        </tr>
        <tr>
            <td>{$form.order.label}</td>
            <td>{$form.order.html}{$form.order.error}</td>
        </tr>
        {if $action eq 'editModule'}
            <tr>
                <td>{$form.main_class.label}</td>
                <td>{$form.main_class.html}{$form.main_class.error}</td>
            </tr>
        {/if}
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>