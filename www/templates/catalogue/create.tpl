{if $type === null}<div class="jipTitle">Добавление нового элемента</div>{/if}
<div id="ajaxGetForm">
{literal}<script language="javascript">
function loadForm(id)
{{/literal}
    var url = '{url route="withAnyParam" section="catalogue" name=$folder->getPath() action="create"}';{literal}
    new Ajax.Updater('ajaxGetForm', url, {
        parameters: { type: id }
    });
}
</script>{/literal}
<form action="{$action}" method="post" onsubmit="return mzzAjax.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="50%">
        <tr>
            <td>Тип:</td> 
            <td>{form->select name="type" options=$select id="type" onchange="javascript:loadForm(this.value);" onkeypress="this.onchange();"}{$errors->get('type')}</td>
        <tr>
{if $type ne 0}
        <tr>
            <td>Имя:</td> 
            <td>{form->text name="name" size="60"}{$errors->get('name')}</td>
        <tr>
        {include file="catalogue/properties.tpl" data=$properties}
{/if}
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset onclick="javascript: jipWindow.close();" name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
</div>
