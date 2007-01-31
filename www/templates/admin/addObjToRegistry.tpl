{if $action eq 'addObjToRegistry'}
{include file='jipTitle.tpl' title='Добавление объекта в реестре доступа'}
{else}
{include file='jipTitle.tpl' title='Редактирование объекта в реестре доступа'}
{/if}
<form {$form.attributes} onsubmit="return mzzAjax.sendForm(this);">
    <table width="100%" border="0" cellpadding="5" cellspacing="0" align="center">
        {if !empty($obj_id)}
        <tr>
            <td>Последний сгенерированый идентификатор объекта</td>
            <td><a href="javascript: void(document.getElementById('obj_id').value={$obj_id})"><strong>{$obj_id}</strong></a></td>
        </tr>
        {/if}
        <tr>
            <td>{$form.obj_id.label}</td>
            <td>{$form.obj_id.html}{$form.obj_id.error}</td>
        </tr>
        <tr>
            <td>{$form.class_section.label}</td>
            <td>{$form.class_section.html}{$form.class_section.error}</td>
        </tr>
        <tr>
            <td colspan=2 style="text-align:center;">{$form.submit.html} {$form.reset.html}</td>
        </tr>
    </table>
</form>