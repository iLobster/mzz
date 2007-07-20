{if empty($ajaxRequest)}
{literal}
<script type="text/javascript">
var count = 0;

function addOne()
{
    var tbody = $('selectvariants');
    var tr = tbody.insertRow(tbody.rows.length);
    var td = tr.insertCell(tr.cells.length);
    td.width = '20%';
    td.innerHTML = 'Значение';
    td = tr.insertCell(tr.cells.length);
    td.width = '80%';

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


function ajaxLoadTypeConfig(value)
{
    if ([5, 6, 7, 8].indexOf(value) == -1) {
        $('catalogueTypeConfig').innerHTML = '';
        return false;
    }
    $('catalogueTypeConfig').innerHTML = '<div class="jipAjaxLoading">Загрузка данных...</div>';
    new Ajax.Updater({success: 'catalogueTypeConfig' }, '{/literal}{url onlyPath=true}{literal}', {
        parameters: {ajaxRequest: value}, method: 'GET',
        onFailure: function () {
            $('catalogueTypeConfig').innerHTML = '<div class="jipAjaxLoadingError">Ошибка загрузки!</div>';
        }
    });
}


function catalogueChangeList(select, type)
{
    type = (type == 'classes' ? 'classes' : (type == 'methods' ? 'methods' : 'modules'));
    var optList = $('catalogue_' + type + '_list');
    optList.disable();
    optList.options.length = 0;

    if (type == 'modules') {
        $('catalogue_classes_list').disable();
        $('catalogue_classes_list').options.length = 0;
        $('catalogue_classes_list').options[0] = new Option('Данных нет');
    }

    if (type == 'modules' || type == 'classes') {
        $('catalogue_methods_list').disable();
        $('catalogue_methods_list').options.length = 0;
        $('catalogue_methods_list').options[0] = new Option('Данных нет');
    }

    $('methodData').update('Загрузка данных...');

    optList.options[0] = new Option('Загрузка...', '');

    new Ajax.Request({/literal}'{url onlyPath=true}'{literal}, {
        method: 'get', parameters: { ajaxRequest: 'dynamicselect_' + type, for_id: $F(select)}, onSuccess: function(transport) {
            if (transport.responseText.match(/\(\{/)) {
                var optListData = eval(transport.responseText);
                var i = 0;
                $H(optListData).each(function(pair) {
                    optList.options[i++] = new Option(pair.value, pair.key);
                });

                if (i > 0) {
                    if (type == 'modules') {
                        catalogueChangeList($('catalogue_modules_list'), 'classes');
                    } else if (type == 'classes') {
                        catalogueChangeList($('catalogue_classes_list'), 'methods');
                    } else if (type == 'methods') {
                        catalogueGetMethodInfo($('catalogue_methods_list'));
                    }
                    optList.enable();
                } else {
                    optList.options[0] = new Option('Данных нет', '');
                }
                optList.selectedIndex = 0;

            } else {
                optList.options[0] = new Option('Данные не получены.', '');
            }
        }, onFailure: function(transport) {
            optList.options[0] = new Option('Ошибка загрузки.', '');
        }
    });
}

function catalogueGetMethodInfo(select)
{
    var classId = $F($('catalogue_classes_list'));
    $('methodData').update('Загрузка данных...');

    new Ajax.Request({/literal}'{url onlyPath=true}'{literal}, {
        method: 'get', parameters: { ajaxRequest: 'dynamicselect_method',  class_id: classId, method_name: $F(select)}, onSuccess: function(transport) {
            if (transport.responseText.match(/\(\{/)) {
                var methodInfo = $H(eval(transport.responseText));

                if (typeof(methodInfo.notCallable) != 'undefined') {
                    $('methodData').update('<span style="color: #9C0303; font-weight: bold;">Данный метод не может быть вызван. Укажите другой.</span>');
                } else {
                    var description = methodInfo.description || 'Описание не указано';
                    methodInfo.remove('description');

                    $('methodData').update(description);


                    var descTable = document.createElement('table');
                    descTable.style.border = '0';
                    descTable.cellPadding = "3";
                    descTable.cellSadding = "3";
                    descTable.width = "70%";


                    methodInfo.each(function (pair) {

                        var argValueRow   = descTable.insertRow(-1);
                        var nameCell  = argValueRow.insertCell(-1);
                        nameCell.rowSpan = "2";
                        nameCell.vAlign = "top";
                        nameCell.style.color = "#515151";

                        var cellText  = document.createTextNode(pair.key + String.fromCharCode(160) + '=');
                        nameCell.appendChild(cellText);

                        var valueCell  = argValueRow.insertCell(-1);

                        if (pair.value.editable == '1') {
                            if (pair.value.type == 'boolean') {
                                var valueInput = document.createElement('select');
                                valueInput.options[0] = new Option('да','true');
                                valueInput.options[1] = new Option('нет','false');
                                valueInput.selectedIndex = pair.value.defaultValue == 'false' ? 1 : 0;
                                if (typeof(pair.value.defaultValue) != 'undefined') {
                                    if (pair.value.defaultValue == 'false') {
                                        pair.value.defaultValue = 'нет';
                                    } else if (pair.value.defaultValue == 'true') {
                                        pair.value.defaultValue = 'да'
                                    }
                                }
                            } else {
                                var valueInput = document.createElement('input');
                            }
                        } else {
                            var valueInput = pair.value.defaultValue;
                        }

                        valueCell.appendChild(valueInput);

                        if (typeof(pair.value.defaultValue) != 'undefined') {
                            if (pair.value.defaultValue != '') {
                                var defaultText = ' (по умолчанию: ' + pair.value.defaultValue + ')';
                            } else {
                                var defaultText = ' (пустое значение по умолчанию)';
                            }
                            var defaultValueSpan = document.createElement('span');
                            defaultValueSpan.style.color = '#777777';
                            defaultValueSpan.appendChild(document.createTextNode(defaultText));
                            valueCell.appendChild(defaultValueSpan);
                        }


                        var argDescRow   = descTable.insertRow(-1);
                        var descCell  = argDescRow.insertCell(-1);
                        descCell.style.color = "#838383";
                        descCell.style.fontSize = "90%";

                        descCell.innerHTML = 'Тип: <strong>' + pair.value.type + '</strong><br />' + pair.value.desc;


                    });

                    $('methodData').appendChild(descTable);
                }
            } else {
                $('methodData').update('Данные не получены');
            }
        }, onFailure: function(transport) {
            $('methodData').update('Данные не получены');
        }
    });
}



{/literal}
{if $isEdit}
ajaxLoadTypeConfig({$propertyForm.type_id});
{/if}

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