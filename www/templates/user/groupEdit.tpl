{if $isEdit}
    {assign var=name value=$group->getName()}
    {include file='jipTitle.tpl' title="Редактирование группы $name"}
{else}
    {include file='jipTitle.tpl' title='Создание группы'}
{/if}
<form {$form.attributes} onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        {if $action eq 'groupEdit'}
            <tr>
                <td>ID:</td><td>{$group->getId()}</td>
            </tr>
        {/if}
        <tr>
            <td>{$form.name.label}</td><td>{$form.name.html}{$form.name.error}</td>
        </tr>
        <tr>
            <td>{$form.is_default.label}</td><td>{$form.is_default.html}{$form.is_default.error}</td>
        </tr>
        <tr>
            <td>{$form.submit.html}</td>
            <td>{$form.reset.html}</td>
        </tr>
    </table>
</form>
