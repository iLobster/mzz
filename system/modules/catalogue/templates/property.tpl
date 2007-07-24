{if empty($ajaxRequest)}
<script type="text/javascript">
var count = 0;
var CATALOGUE_PATH = '{url onlyPath=true}';
jsLoader.load(SITE_PATH + '/templates/js/catalogue.js');

jsLoader.setOnLoad(function () {literal}{{/literal}
{if $isEdit}ajaxLoadTypeConfig({$propertyForm.type_id});{/if}
{literal}});{/literal}
</script>

<div class="jipTitle">{if $isEdit}Редактирование свойства{else}Создание свойства{/if}</div>

{capture name=requestConfigForType}
{literal}

$('catalogueTypeConfig').innerHTML = '<div class="jipAjaxLoading">Загрузка данных...</div>';
new Ajax.Updater({ success: 'catalogueTypeConfig' }, '{/literal}{url onlyPath=true}{literal}', {parameters: { ajaxRequest: this.value}, method: 'GET', onFailure: function () {
$('catalogueTypeConfig').innerHTML = '<div class="jipAjaxLoadingError">Ошибка загрузки!</div>';
}});{/literal}
{/capture}
<div style="padding: 10px;">
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td><strong>{form->caption name="title" value="Заголовок:" onError=false onRequired=false}</strong></td>
            <td><div class="errorText">{$errors->get('title')}</div>{form->text name="title" size="40" value=$propertyForm.title onError="class=errorField"}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="name" value="Имя:" onError='' onRequired=""}</strong></td>
            <td><div class="errorText">{$errors->get('name')}</div>{form->text name="name" size="40" value=$propertyForm.name onError="class=errorField"}</td>
        </tr>
        <tr>
            <td><strong>{form->caption name="type_id" value="Тип:" onError='' onRequired=""}</strong></td>
            <td><div class="errorText">{$errors->get('type_id')}</div>{form->select name="type_id" options=$selectdata value=$propertyForm.type_id onchange="ajaxLoadTypeConfig(this.value);" onError="class=errorField"}</td>
        </tr>
    </table>

<div id="catalogueTypeConfig" style="border-top: 1px solid #EBEBEB; margin: 10px 5px 5px; padding: 5px;"></div>

{form->submit name="submit" value="Сохранить"} {*или <a class="cancelLink" href="javascript: jipWindow.close();">отменить</a>*}{form->reset jip=true name="reset" value="Отмена"}

</form>
</div>
{elseif $ajaxRequest == 'select'}
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

{elseif $ajaxRequest == 'datetime'}
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td width="20%">Формат:</td>
            <td width="80%">{form->text name="datetimeformat" size="30" value=$propertyForm.args}</td>
        </tr>
    </table>
{elseif $ajaxRequest == 'dynamicselect'}
    <table border="0" cellpadding="0" cellspacing="3" width="100%">
        <tr>
            <td width="40%" valign="top">
                <table border="0" cellpadding="0" cellspacing="3" width="100%">
                    <tr>
                        <td><strong>{form->caption name="dynamicselect_section" value="Секция:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong><br /></td>
                    </tr>
                    <tr>
                        <td>
                        {form->select name="dynamicselect_section" options=$sections value=$dynamicselect_section emptyFirst=1 style="width: 270px;" id="catalogue_section_list" onchange="catalogueChangeList(this);" onkeypress="this.onchange();"}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="dynamicselect_module" value="Модуль:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong><br /></td>
                    </tr>
                    <tr>
                        <td>
                        {form->select name="dynamicselect_module" style="width: 270px;" id="catalogue_modules_list" disabled=1 onchange="catalogueChangeList(this, 'classes');" onkeypress="this.onchange();"}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="dynamicselect_class" value="Класс:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong><br /></td>
                    </tr>
                    <tr>
                        <td>
                        {form->select name="dynamicselect_class" style="width: 270px;" id="catalogue_classes_list" disabled=1 onchange="catalogueChangeList(this, 'methods');" onkeypress="this.onchange();"}
                        </td>
                    </tr>

                    <tr>
                        <td><strong>{form->caption name="dynamicselect_method" value="Метод:" onError='style="color: red;"' onRequired='<span style="color: red; font-size: 150%;">*</span> '}</strong><br /></td>
                    </tr>
                    <tr>
                        <td>
                        {form->select name="dynamicselect_method" style="width: 270px;" id="catalogue_methods_list" onchange="catalogueGetMethodInfo(this);" onkeypress="this.onchange();" disabled=1}
                        </td>
                    </tr>
                </table>

            </td>
            <td width="60%" valign="top">
            <span style="font-size: 120%; font-weight: bold;">Параметры метода:</span>
            <div id="methodData"></div>
            </td>
        </tr>
    </table>
{elseif $ajaxRequest == 'dynamicselect_modules' || $ajaxRequest == 'dynamicselect_classes'}
{literal}
({
{/literal}
{foreach name="dataLoop" key="dataId" item="dataName" from=$data}
{$dataId}: '{$dataName[0].name}'{if $smarty.foreach.dataLoop.last eq false},{/if}
{/foreach}
{literal}
})
{/literal}

{elseif $ajaxRequest == 'dynamicselect_methods'}
{literal}
({
{/literal}
{foreach name="dataLoop" item="dataName" from=$data}
'{$dataName}': '{$dataName}'{if $smarty.foreach.dataLoop.last eq false},{/if}
{/foreach}
{literal}
})
{/literal}
{elseif $ajaxRequest == 'dynamicselect_method'}
{literal}({{/literal}
{if $data !== false && $data !== null}
description: '{$description}'{if !empty($data)},
{foreach name="argsLoop" item="arg" key="argName" from=$data}
'{$argName}': {literal}{{/literal}'type': '{$arg[0]}', desc: '{$arg[1]}', editable: '{$arg[2]}'{if isset($arg[3])},
 'defaultValue': {if $arg[3] === false}'false'{elseif $arg[3] === true}'true'{else}'{$arg[3]}'{/if}
 {/if}{literal}}{/literal} {if $smarty.foreach.argsLoop.last eq false},{/if}
{/foreach}
{/if}
{elseif $data === null}
'notCallable': true
{/if}{literal}}){/literal}
{/if}