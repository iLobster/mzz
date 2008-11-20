<div class="jipTitle">{if $isEdit}Редактирование типа "{$type.name}"{else}Создание типа{/if}</div>
{strip}
{literal}<script language="javascript">
function switchChckbox(id, self) {
    var element = $("full[" + id + "]");
    element.disabled = !self.checked;
    element.checked = element.disabled && self.checked;

    var element = $("short[" + id + "]");
    element.disabled = !self.checked;
    element.checked = element.disabled && self.checked;

    var element = $("sort[" + id + "]");
    element.disabled = !self.checked;
}
</script>{/literal}
{form action=$action method="post" jip=true}
    <table border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td><strong>{form->caption name="title" value="Заголовок:"}</strong></td>
            <td>{form->text name="title" size="60" value=$type.title}{$errors->get('title')}</td>
        </tr>

        <tr>
            <td><strong>{form->caption name="name" value="Название:"}</strong></td>
            <td>{form->text name="name" size="60" value=$type.name}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Параметр:</strong></td>
            <td><strong>Сортировка:</strong></td>
            <td><strong>Для полного:</strong></td>
            <td><strong>Для краткого:</strong></td>
        </tr>
        {foreach from=$type.properties key="id" item="property"}
            <tr>
                <td>{form->checkbox value=1 name="properties[$id]" onclick="javascript:switchChckbox($id, this);"} {$property.title}</td>
                <td>{form->text name="sort[$id]" id="sort[$id]" size=3 maxlength=4 value=$property.sort}</td>
                <td>{form->checkbox value=$property.isFull name="full[$id]" id="full[$id]"}</td>
                <td>{form->checkbox value=$property.isShort name="short[$id]" id="short[$id]"}</td>
            </tr>
        {/foreach}
        {foreach from=$properties key="id" item="property"}
            <tr>
                <td>{form->checkbox value=0 name="properties[$id]" onclick="javascript:switchChckbox($id, this);"} {$property.title}</td>
                <td>{form->text name="sort[$id]" id = "sort[$id]" size=3 maxlength=4 disabled="true"}</td>
                <td>{form->checkbox value="1" name="full[$id]" id="full[$id]" disabled="true"}</td>
                <td>{form->checkbox value="0" name="short[$id]" id="short[$id]" disabled="true"}</td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="2" style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{/strip}