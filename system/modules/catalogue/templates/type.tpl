<div class="jipTitle">{if $isEdit}Редактирование типа "{$type.name}"{else}Создание типа{/if}</div>
{strip}
{literal}<script language="javascript">
function switchChckbox(id, self) {
    var element = $("full[" + id + "]");
    element.disabled = !self.checked;
    element.checked = element.disabled && self.checked;

    var element = $("sort[" + id + "]");
    element.disabled = !self.checked;
}
</script>{/literal}
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td><strong>{form->caption name="title" value="Заголовок:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="title" size="60" value=$type.title onError="style=border: red 1px solid;"}{$errors->get('title')}</td>
        </tr>

        <tr>
            <td><strong>{form->caption name="name" value="Название:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="name" size="60" value=$type.name onError="style=border: red 1px solid;"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Параметр:</strong></td>
            <td><strong>Сортировка:</strong></td>
            <td><strong>Для краткого:</strong></td>
        </tr>
        {foreach from=$type.properties key="id" item="property"}
            <tr>
                <td>{form->checkbox value=1 name="properties[$id]" onclick="javascript:switchChckbox($id, this);"} {$property.title}</td>
                <td>{form->text name="sort[$id]" id="sort[$id]" size=3 maxlength=4 value=$property.sort}</td>
                <td>{form->checkbox value=$property.isShort name="full[$id]" id="full[$id]"}</td>
            </tr>
        {/foreach}
        {foreach from=$properties key="id" item="property"}
            <tr>
                <td>{form->checkbox value=0 name="properties[$id]" onclick="javascript:switchChckbox($id, this);"} {$property.title}</td>
                <td>{form->text name="sort[$id]" id = "sort[$id]" size=3 maxlength=4 disabled="true"}</td>
                <td>{form->checkbox value=0 name="full[$id]" id="full[$id]" disabled="true"}</td>
            </tr>
        {/foreach}
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{/strip}