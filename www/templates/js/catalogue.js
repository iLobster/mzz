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
    new Ajax.Updater({success: 'catalogueTypeConfig' }, CATALOGUE_PATH, {
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

    new Ajax.Request(CATALOGUE_PATH, {
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

    new Ajax.Request(CATALOGUE_PATH, {
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
