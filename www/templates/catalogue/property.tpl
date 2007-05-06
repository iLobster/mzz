<div class="jipTitle">{if $isEdit}Редактирование свойства{else}Создание свойства{/if}</div>
{assign var="title" value=''}{if isset($property.title)}{assign var="title" value=$property.title}{/if}
{assign var="name" value=''}{if isset($property.name)}{assign var="name" value=$property.name}{/if}
{assign var="type" value=''}{if isset($property.type_id)}{assign var="type" value=$property.type_id}{/if}
{literal}<script language="JavaScript">
var count = 0;
function showHidden(value)
{
    $('selectvariants').style.display = (value == 5) ? '' : 'none';
}
function addOne()
{
    var tbody = $('selectvariants');
	var tr = tbody.insertRow(tbody.rows.length);
	var td = tr.insertCell(tr.cells.length);
	td.innerHTML = 'Значение';
	td = tr.insertCell(tr.cells.length);
	td.innerHTML = '<input maxlength="10" name="selectvalues[' + count + ']" type="text" /><img src="/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" />';
    count++;
}

function deleteOne(trelem)
{
    $('selectvariants').removeChild(trelem);
}
</script>{/literal}
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="100%">
        <tr>
            <td><strong>{form->caption name="title" value="Заголовок:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="title" size="60" value=$title onError="style=border: red 1px solid;"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name" value="Имя:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="name" size="60" value=$name onError="style=border: red 1px solid;"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="type" value="Тип:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->select name="type" options=$types value=$type onchange="javascript:showHidden(this.value);" onError="style=border: red 1px solid;"}{$errors->get('type')}</td>
        </tr>
        <tr>
            <table>
                <tbody id="selectvariants" {if !$isEdit || $type != 5}style="display:none;"{/if}>
                <input type="button" value="+" onclick="javascript:addOne();">
                {if $isEdit && $type == 5}
                    {foreach from=$property.args item="val" key="key" name="argsIterator"}
                    <tr>
                        <td>Значение:</td>
                        <td><input type="text" name="selectvalues[{$smarty.foreach.argsIterator.iteration}]" value="{$val}" /><img src="{$SITE_PATH}/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" /></td>
                    </tr>
                    {/foreach}
                    <script language="JavaScript">count = {$smarty.foreach.argsIterator.total+1};</script>
                {/if}
            </table>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
        </tbody>
    </table>
</form>