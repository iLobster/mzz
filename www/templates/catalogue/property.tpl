<div class="jipTitle">{if $isEdit}�������������� ��������{else}�������� ��������{/if}</div>
{assign var="title" value=''}{if isset($property.title)}{assign var="title" value=$property.title}{/if}
{assign var="name" value=''}{if isset($property.name)}{assign var="name" value=$property.name}{/if}
{assign var="type" value=''}{if isset($property.type_id)}{assign var="type" value=$property.type}{/if}
<script language="JavaScript">
var count = 0;
var types = new Array();
{foreach from=$types key="type_id" item="type_name"}
types[{$type_id}] = "{$type_name}";
{/foreach}
{literal}
function showHidden(value)
{
    value = types[value];
    $('selectvariants').style.display = (value == 'select') ? '' : 'none';
    $('datetimeformat').style.display = (value == 'datetime') ? '' : 'none';
}
function addOne()
{
    var tbody = $('selectvariants');
	var tr = tbody.insertRow(tbody.rows.length);
	var td = tr.insertCell(tr.cells.length);
	td.innerHTML = '��������';
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
            <td><strong>{form->caption name="title" value="���������:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="title" size="60" value=$title onError="style=border: red 1px solid;"}{$errors->get('title')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name" value="���:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->text name="name" size="60" value=$name onError="style=border: red 1px solid;"}{$errors->get('name')}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="type" value="���:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>{form->select name="type" options=$selectdata value=$property.type_id onchange="javascript:showHidden(this.value);" onError="style=border: red 1px solid;"}{$errors->get('type')}</td>
        </tr>
        <tr>
            <table>
                <tbody id="selectvariants" {if !$isEdit || $type != 'select'}style="display:none;"{/if}>
                <input type="button" value="+" onclick="javascript:addOne();">
                {if $isEdit && $type == 'select'}
                    {foreach from=$property.args item="val" key="key" name="argsIterator"}
                    <tr>
                        <td>��������:</td>
                        <td><input type="text" name="selectvalues[{$smarty.foreach.argsIterator.iteration}]" value="{$val}" /><img src="{$SITE_PATH}/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" /></td>
                    </tr>
                    {/foreach}
                    <script language="JavaScript">count = {$smarty.foreach.argsIterator.total+1};</script>
                {/if}
                </tbody>
                <tbody id="datetimeformat" {if !$isEdit || $type != 'datetime'}style="display:none;"{/if}>
                    <tr>
                        <td>������:</td>
                        <td><input type="text" size="60" name="datetimeformat" {if $isEdit && $type == 'datetime'}value="{$property.args}"{else}value="%H:%M:%S %d/%m/%Y"{/if}/></td>
                    </tr>
                </tbody>
            </table>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="���������"}</td><td>{form->reset jip=true name="reset" value="������"}</td>
        </tr>
        </tbody>
    </table>
</form>