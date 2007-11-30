{if !$isAjax}
<script type="text/javascript">
var count = 0;
var CATALOGUE_PATH = '{url onlyPath=true}';
var CATALOGUE_TYPES_WITH_CONFIG = [5, 6, 7, 8];

fileLoader.loadJS(SITE_PATH + '/templates/js/catalogue.js');

fileLoader.onJsLoad(function () {ldelim}
mzzCatalogue.setValues({ldelim}
{if $propertyForm.type_id == 8}
'sections': '{$propertyForm.typeConfig.section}',
'folders': '{$propertyForm.typeConfig.folderId}'
{elseif $propertyForm.type_id == 7}
'sections': '{$propertyForm.typeConfig.section}',
'modules': '{$propertyForm.typeConfig.module}',
'classes': '{$propertyForm.typeConfig.class}',
'methods': '{$propertyForm.typeConfig.searchMethod}',
'extractMethods': '{$propertyForm.typeConfig.extractMethod}',
'methodArgs': $H({ldelim}{foreach name="methodArgsLoop" from=$propertyForm.typeConfig.methodArgs item="methodArgValue" key="methodArgNumber"}
arg{$methodArgNumber}: "{$methodArgValue|addslashes}"{if $smarty.foreach.methodArgsLoop.last eq false},{/if}
{/foreach}{rdelim})
{/if}
{rdelim});
mzzCatalogue.autoloadSelects();
{rdelim});
</script>
<div class="jipTitle">{if $isEdit}Редактирование свойства{else}Создание свойства{/if}</div>

<div style="padding: 10px;">
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td><strong>{form->caption name="title" value="Название:" onRequired=false}</strong></td>
            <td><div class="errorText">{$errors->get('title')}</div>{form->text name="title" size="40" value=$propertyForm.title}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name" value="Имя (латиница):" onRequired=false}</strong></td>
            <td><div class="errorText">{$errors->get('name')}</div>{form->text name="name" size="40" value=$propertyForm.name}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="type_id" value="Тип:" onRequired=false}</strong></td>
            <td><div class="errorText">{$errors->get('type_id')}</div>{form->select name="type_id" options=$selectdata value=$propertyForm.type_id onchange="mzzLoadTypeConfig(this.value);"}</td>
        </tr>
    </table>

<div id="catalogueTypeConfig" style="border-top: 1px solid #EBEBEB; margin: 10px 5px 5px; padding: 5px;">
{/if}
{if $loadType == 'select'}
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td colspan="2"><a href="javascript:addOne();" class="jsLink">Добавить вариант</a></td>
        </tr>
        <tbody id="selectvariants">
        {if $isEdit && !empty($property)}
            {foreach from=$property.args item="val" key="key" name="variantsIterator"}
                <tr>
                <td width="20%">Значение:</td>
                <td width="80%"><input type="text" name="selectvalues[{$smarty.foreach.variantsIterator.iteration}]" value="{$val}" /><img src="{$SITE_PATH}/templates/images/delete.gif" onclick="javascript:deleteOne(this.parentNode.parentNode);" /></td>
                </tr>
            {/foreach}
            <script type="text/javascript">count = {$smarty.foreach.variantsIterator.total+1};</script>
        {/if}
        </tbody>
    </table>

{elseif $loadType == 'datetime'}
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td width="20%">Формат:</td>
            <td width="80%">{form->text name="datetimeformat" size="30" value=$propertyForm.typeConfig}</td>
        </tr>
    </table>
{elseif $loadType == 'dynamicselect'}
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td width="40%" valign="top">
                <table border="0" cellpadding="0" cellspacing="3" width="100%">
                    <tr>
                        <td><strong>{form->caption name="typeConfig[section]" value="Секция:" onError='style="color: red;"' onRequired=''}</strong><br /></td>
                    </tr>
                    <tr>
                        <td><div class="errorText">{$errors->get('typeConfig[section]')}</div>
                        {form->select name="typeConfig[section]" options=$sections value=$propertyForm.typeConfig.section emptyFirst=1 style="width: 270px;" id="catalogue_sections_list" onchange="mzzCatalogue.getList(this);" onkeypress="this.onchange();"}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="typeConfig[module]" value="Модуль:" onError='style="color: red;"' onRequired=''}</strong><br /></td>
                    </tr>
                    <tr>
                        <td><div class="errorText">{$errors->get('typeConfig[module]')}</div>
                        {form->select name="typeConfig[module]" style="width: 270px;" id="catalogue_modules_list" disabled=1 onchange="mzzCatalogue.getList(this, 'classes');" onkeypress="this.onchange();"}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="typeConfig[class]" value="Класс:" onError='style="color: red;"' onRequired=''}</strong><br /></td>
                    </tr>
                    <tr>
                        <td><div class="errorText">{$errors->get('typeConfig[class]')}</div>
                        {form->select name="typeConfig[class]" style="width: 270px;" id="catalogue_classes_list" disabled=1 onchange="mzzCatalogue.getList(this, 'methods');" onkeypress="this.onchange();"}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="typeConfig[searchMethod]" value="Метод поиска:" onError='style="color: red;"' onRequired=''}</strong><br /></td>
                    </tr>
                    <tr>
                        <td><div class="errorText">{$errors->get('typeConfig[searchMethod]')}</div>
                        {form->select name="typeConfig[searchMethod]" style="width: 270px;" id="catalogue_methods_list" onchange="mzzCatalogue.getMethodInfo(this);" onkeypress="this.onchange();" disabled=1}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="typeConfig[extractMethod]" value="Метод извлечения данных:" onError='style="color: red;"' onRequired=''}</strong><br /></td>
                    </tr>
                    <tr>
                        <td><div class="errorText">{$errors->get('typeConfig[extractMethod]')}</div>
                        {form->select name="typeConfig[extractMethod]" style="width: 270px;" id="catalogue_extractMethods_list" disabled=1}
                        </td>
                    </tr>

                    <tr>
                        <td colspan="2"">{form->checkbox name="typeConfig[optional]" text="Добавить первым пустое значение" value=$propertyForm.typeConfig.optional}</td>
                    </tr>
                </table>

            </td>
            <td width="60%" valign="top">
            <span style="font-size: 120%; font-weight: bold;">Параметры метода поиска:</span>
            <div id="methodArgsValues"></div>
            </td>
        </tr>
    </table>

{elseif $loadType == 'img'}
    <table border="0" cellpadding="0" cellspacing="6" width="100%">
        <tr>
            <td><strong>{form->caption name="typeConfig[section]" value="Секция:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong></td>
            <td>
            {form->select name="typeConfig[section]" options=$sections value=$propertyForm.typeConfig.section emptyFirst=1 style="width: 270px;" id="catalogue_sections_list" onchange="mzzCatalogue.getList(this, 'folders');" onkeypress="this.onchange();"}
            </td>
        </tr>
        <tr>
            <td colspan="2">
            <strong>{form->caption name="typeConfig[folder]" value="Папка:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong><br />
            {form->select name="typeConfig[folder]" style="width: 450px;" size="8" id="catalogue_folders_list" options="Выберите секцию" disabled=1}
            </td>
        </tr>
    </table>
{elseif in_array($loadType, array('modules', 'classes'))}
({ldelim}
{foreach name="dataLoop" key="dataId" item="dataName" from=$data}
{$dataId}: '{$dataName[0].name}'{if $smarty.foreach.dataLoop.last eq false},{/if}
{/foreach}
{rdelim})

{elseif $loadType == 'folders'}
({ldelim}
{foreach name="dataLoop" key="dataId" item="dataName" from=$data}
{$dataId}: ['{$dataName[0]}', '{$dataName[1]}']{if $smarty.foreach.dataLoop.last eq false},{/if}
{/foreach}
{rdelim})

{elseif $loadType == 'methods'}
({ldelim}searchMethods: {ldelim}
{foreach name="dataLoop" item="dataName" from=$searchMethods}
'{$dataName}': '{$dataName}'{if $smarty.foreach.dataLoop.last eq false},{/if}
{/foreach}
{rdelim},
extractMethods: [
{foreach name="extractMethodsLoop" item="extractMethodName" from=$extractMethods}
'{$extractMethodName}'{if $smarty.foreach.extractMethodsLoop.last eq false},{/if}
{/foreach}
]{rdelim})

{elseif $loadType == 'method'}
({ldelim}
{if $data !== false && $data !== null}
description: '{$description}'{if !empty($data)},
{foreach name="argsLoop" item="arg" key="argName" from=$data}
'{$argName}': {ldelim}'type': '{$arg[0]}', desc: '{$arg[1]}', editable: '{$arg[2]}'{if isset($arg[3])},
 'defaultValue': {if $arg[3] === false}'false'{elseif $arg[3] === true}'true'{else}'{$arg[3]}'{/if}
 {/if}{rdelim}{if $smarty.foreach.argsLoop.last eq false},{/if}
{/foreach}
{/if}
{elseif $data === null}
'notCallable': true
{/if}{rdelim})
{/if}

{if !$isAjax}
</div>
{form->submit name="submit" value="Сохранить" id="catalogueSubmitProperty"} {form->reset jip=true name="reset" value="Отмена"}
</form>
</div>
{/if}