{if $isEdit}
{include file='jipTitle.tpl' title='Редактирование типа'}
{else}
{include file='jipTitle.tpl' title='Создание типа'}
{/if}
{literal}<script language="javascript">
function switchChckbox(elem) {
    var id=
}
</script>{/literal}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
{$form.hidden}
{$form.javascript}
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td><strong>{$form.title.label}</strong></td>
            <td>{$form.title.html}</td>
        </tr>
        <tr>
            <td><strong>{$form.name.label}</strong></td>
            <td>{$form.name.html}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        {foreach from=$form.properties key="id" item="property" name="propertyIterator"}
        {if $smarty.foreach.propertyIterator.first}
            <tr>
                <td><strong>Параметр:</strong></td>
                <td><strong>Для краткого:</strong></td>
            </tr>
        {/if}
            <tr>
                <td>{$property.html}</td>
                <td>{$form.full.$id.html}</td>
            </tr>
        {foreachelse}
            <tr>
                <td>Нет параметров</td>
            <tr>
        {/foreach}
        <tr>
            <td>{$form.submit.html}{$form.reset.html}</td>
        </tr>
    </table>
</form>