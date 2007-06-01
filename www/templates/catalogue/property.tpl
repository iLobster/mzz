<div class="jipTitle">{if $isEdit}Редактирование свойства{else}Создание свойства{/if}</div>
{assign var="title" value=''}{if isset($property.title)}{assign var="title" value=$property.title}{/if}
{assign var="name" value=''}{if isset($property.name)}{assign var="name" value=$property.name}{/if}
{assign var="type" value=''}{if isset($property.type)}{assign var="type" value=$property.type}{/if}
{assign var="type_id" value=''}{if isset($property.type_id)}{assign var="type_id" value=$property.type_id}{/if}
<script type="text/javascript">
var count = 0;
var types = new Array();
{foreach from=$types key="type_tmp_id" item="type_name"}
types[{$type_tmp_id}] = "{$type_name}";
{/foreach}

{strip}
{literal}
var modulesInSection = $H({
{/literal}
{foreach name=sections_loop key=sectionName item=modulesNames from=$modules}
'{$sectionName}' : {literal}{{/literal}
    {foreach item=moduleName from=$modulesNames name=modules_loop}
        '{$moduleName}':  '{$moduleName}' {if $smarty.foreach.modules_loop.last eq false},{/if}
    {/foreach}{literal}}{/literal}
    {if $smarty.foreach.sections_loop.last eq false},{/if}
{/foreach}
{literal}
});

var classesInModuleSection = $H({
{/literal}
{foreach name=sections_loop key=sectionName item=modulesNames from=$classes}
'{$sectionName}' : {literal}{{/literal}
    {foreach key=moduleName item=moduleClasses from=$modulesNames name=modules_loop}

                     {if !empty($moduleClasses)}
        '{$moduleName}':  {literal}{{/literal} {foreach item=className key=classId from=$moduleClasses name=classes_loop}
                              {$classId}: '{$className}'
                              {if $smarty.foreach.classes_loop.last eq false},{/if}
                          {/foreach}{literal}}{/literal}
                     {/if}
        {if $smarty.foreach.modules_loop.last eq false},{/if}
    {/foreach}{literal}}{/literal}
    {if $smarty.foreach.sections_loop.last eq false},{/if}
{/foreach}
{literal}
});
{/literal}
{/strip}

{literal}
function showHidden(value)
{
    value = types[value];
    $('selectvariants').style.display = (value == 'select') ? '' : 'none';
    $('datetimeformat').style.display = (value == 'datetime') ? '' : 'none';
    $('dynamicselect').style.display = (value == 'dynamicselect') ? '' : 'none';
    $('img').style.display = (value == 'img') ? '' : 'none';
    jipWindow.lockContent();
}
function addOne()
{
    var tbody = $('selectvariants');
	var tr = tbody.insertRow(tbody.rows.length);
	var td = tr.insertCell(tr.cells.length);
	td.innerHTML = 'Значение';
	td = tr.insertCell(tr.cells.length);


	var newInput = document.createElement('input');
	newInput.maxLength = 10;
	newInput.name = 'selectvalues[' + count + ']';
	newInput.type = "text";

	var newImg = document.createElement('img');
	newImg.src = SITE_PATH + "/templates/images/delete.gif";
	newImg.onclick = function () {
	    deleteOne(this.parentNode.parentNode);
	}

	td.appendChild(newInput);
	td.appendChild(newImg);
	//td.innerHTML = '<input maxlength="10" name="selectvalues[' + count + ']" type="text" />
	//<img src="/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" />';
    count++;
    jipWindow.lockContent();
}

function deleteOne(trelem)
{
    $('selectvariants').removeChild(trelem);
}

function catalogueChangeModulesList(select)
{
    var modulesList = $('catalogue_modules_list');
    modulesList.options.length = 0;
    var i = 0;
    $H(modulesInSection[$F(select)]).each(function(pair) {
        modulesList.options[i++] = new Option(pair.value, pair.key);
    });
    (i > 0) ? modulesList.enable() : modulesList.disable();
    modulesList.selectedIndex = 0;
}

function catalogueChangeClassesList(select)
{
    var classesList = $('catalogue_classes_list');
    classesList.options.length = 0;
    var i = 0;
    $H(classesInModuleSection[$F($('catalogue_section_list'))][$F(select)]).each(function(pair) {
        classesList.options[i++] = new Option(pair.value, pair.key);
     });
    (i > 0) ? classesList.enable() : classesList.disable();
    classesList.selectedIndex = 0;
}
{/literal}
</script>
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
            <td>{form->select name="type" options=$selectdata value=$type_id onchange="javascript:showHidden(this.value);" onError="style=border: red 1px solid;"}{$errors->get('type')}</td>
        </tr>
        <tr>
            <table>
                <tbody id="selectvariants" {if !$isEdit || $type != 'select'}style="display:none;"{/if}>
                <input type="button" value="+" onclick="javascript:addOne();">
                {if $isEdit && $type == 'select'}
                    {foreach from=$property.args item="val" key="key" name="argsIterator"}
                    <tr>
                        <td>Значение:</td>
                        <td><input type="text" name="selectvalues[{$smarty.foreach.argsIterator.iteration}]" value="{$val}" /><img src="{$SITE_PATH}/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" /></td>
                    </tr>
                    {/foreach}
                    <script type="text/javascript">count = {$smarty.foreach.argsIterator.total+1};</script>
                {/if}
                </tbody>
                <tbody id="datetimeformat" {if !$isEdit || $type != 'datetime'}style="display:none;"{/if}>
                    <tr>
                        <td>Формат:</td>
                        <td><input type="text" size="60" name="datetimeformat" {if $isEdit && $type == 'datetime'}value="{$property.args}"{else}value="%H:%M:%S %d/%m/%Y"{/if}/></td>
                    </tr>
                </tbody>
                <tbody id="dynamicselect" {if !$isEdit || $type != 'dynamicselect'}style="display:none;"{/if}>
                    <tr>
                        <td>Имя модуля:</td>
                        <td><input type="text" size="60" name="dynamicselect_module" {if $isEdit && $type == 'dynamicselect'}value="{$property.args.module}"{/if}/></td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="dynamicselect_section" value="Секция:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
                        <td>

                        <select name="type" style="width: 200px;" id="catalogue_section_list" onchange="catalogueChangeModulesList(this); catalogueChangeClassesList($('catalogue_modules_list'));" onkeypress="this.onchange();">
                        <option value=""></option>

                        {foreach from=$sections item="sectionName"}
                        <option value="{$sectionName}"{if $isEdit && $type == 'dynamicselect' && $sectionName == $property.args.section}selected="selected"{/if}>{$sectionName}</option>
                        {/foreach}
                        </select>

                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="dynamicselect_module" value="Модуль:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
                        <td>

                        <select name="dynamicselect_module" style="width: 200px;" id="catalogue_modules_list" disabled="disabled" onchange="catalogueChangeClassesList(this)" onkeypress="this.onchange();">
                        <option value=""></option>
                        </select>

                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="dynamicselect_class" value="Класс:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
                        <td>

                        <select name="dynamicselect_class" style="width: 200px;" id="catalogue_classes_list" disabled="disabled">
                        <option value=""></option>
                        </select>

                        </td>
                    </tr>

                    <tr>
                        <td>Имя ДО:</td>
                        <td><input type="text" size="60" name="dynamicselect_do" {if $isEdit && $type == 'dynamicselect'}value="{$property.args.do}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Имя секции:</td>
                        <td><input type="text" size="60" name="dynamicselect_section" {if $isEdit && $type == 'dynamicselect'}value="{$property.args.section}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Имя метода для поиска:</td>
                        <td><input type="text" size="60" name="dynamicselect_searchMethod" {if $isEdit && $type == 'dynamicselect'}value="{$property.args.searchMethod}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Параметры (с "|" в качестве разделителя):</td>
                        <td><input type="text" size="60" name="dynamicselect_params" {if $isEdit && $type == 'dynamicselect'}value="{$property.args.params}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Имя метода извлечения данных:</td>
                        <td><input type="text" size="60" name="dynamicselect_extractMethod" {if $isEdit && $type == 'dynamicselect'}value="{$property.args.extractMethod}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Нулевой элемент:</td>
                        <td><input type="checkbox" name="dynamicselect_nullelement" value="1" {if $isEdit && $type == 'dynamicselect' && $property.args.nullElement}checked{/if}/></td>
                    </tr>
                </tbody>
                <tbody id="img" {if !$isEdit || $type != 'img'}style="display:none;"{/if}>
                    <tr>
                        <td>Имя модуля:</td>
                        <td><input type="text" size="60" name="img_module" {if $isEdit && $type == 'img'}value="{$property.args.module}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Имя ДО:</td>
                        <td><input type="text" size="60" name="img_do" {if $isEdit && $type == 'img'}value="{$property.args.do}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Имя секции:</td>
                        <td><input type="text" size="60" name="img_section" {if $isEdit && $type == 'img'}value="{$property.args.section}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Имя метода для поиска:</td>
                        <td><input type="text" size="60" name="img_searchMethod" {if $isEdit && $type == 'img'}value="{$property.args.searchMethod}"{/if}/></td>
                    </tr>
                    <tr>
                        <td>Параметры (с "|" в качестве разделителя):</td>
                        <td><input type="text" size="60" name="img_params" {if $isEdit && $type == 'img'}value="{$property.args.params}"{/if}/></td>
                    </tr>
                </tbody>
            </table>
        </tr>
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
        </tbody>
    </table>
</form>