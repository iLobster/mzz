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


function mzzLoadTypeConfig(value)
{
    $('catalogueTypeConfig').innerHTML = '';
    if (CATALOGUE_TYPES_WITH_CONFIG.indexOf(value) == -1) {
        return false;
    }
    var loadingDiv = document.createElement('div');
    loadingDiv.className = "jipAjaxLoading";
    loadingDiv.update('Загрузка данных...');
    $('catalogueTypeConfig').appendChild(loadingDiv);

    new Ajax.Updater({success: 'catalogueTypeConfig' }, CATALOGUE_PATH, {
        parameters: {ajaxRequest: value}, method: 'GET',
        onFailure: function () {
            loadingDiv.className = 'jipAjaxLoadingError';
            loadingDiv.update('Ошибка загрузки.');
        }
    });
}


var mzzCatalogue = {
    getList: function(select, type)
    {
        type = (['classes', 'methods', 'modules', 'folders'].indexOf(type) >= 0) ? type : 'modules';
        var optList = $('catalogue_' + type + '_list');
        if (!select || !optList) {
            return false;
        }
        optList.disable();
        optList.options.length = 0;

        switch (type) {
            case 'modules':
            this.setLoadingMode($('catalogue_classes_list'));
            case 'classes':
            this.setLoadingMode($('catalogue_methods_list'));
            this.setLoadingMode($('catalogue_folders_list'));
        }

        $('methodData').update('Загрузка данных...');

        optList.options[0] = new Option('Загрузка...', '');
        var params = $H({ajaxRequest: 'dynamicselect_' + type, for_id: $F(select)});
        if (type == 'folders') {
            params.merge({
            'section': this.getSelectedText('catalogue_section_list'),
            'module': this.getSelectedText('catalogue_modules_list'),
            'class': this.getSelectedText('catalogue_classes_list')
            });
        }

        new Ajax.Request(CATALOGUE_PATH, {
            method: 'get', parameters: params, onSuccess: function(transport) {
                if (transport.responseText.match(/\(\{/)) {
                    var optListData = eval(transport.responseText);
                    var i = 0;
                    $H(optListData).each(function(pair) {
                        if (typeof(pair.value) == 'string') {
                            optList.options[i++] = new Option(pair.value, pair.key);
                        } else {
                            optList.options[i++] = new Option(String.fromCharCode(160).times(pair.value[1] * 5) + pair.value[0], pair.key);
                        }
                    });

                    if (i > 0) {
                        if (type == 'modules') {
                            mzzCatalogue.getList($('catalogue_modules_list'), 'classes');
                        } else if (type == 'classes') {
                            mzzCatalogue.getList($('catalogue_classes_list'), 'methods');
                            mzzCatalogue.getList($('catalogue_folders_list'), 'folders');
                        } else if (type == 'methods') {
                            mzzCatalogue.getMethodInfo($('catalogue_methods_list'));
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
    },

    setLoadingMode: function(elm)
    {
        if (elm) {
            elm.disable();
            elm.options.length = 0;
            elm.options[0] = new Option('Загрузка...');
        }
    },

    getSelectedText: function(id)
    {
        return $(id).options[$(id).selectedIndex].text;
    },


    getMethodInfo: function(select)
    {
        var classId = $F($('catalogue_classes_list'));
        $('methodData').update('Загрузка данных...');

        new Ajax.Request(CATALOGUE_PATH, {
            method: 'get', parameters: { ajaxRequest: 'dynamicselect_method',  class_id: classId, method_name: $F(select)}, onSuccess: function(transport) {
                if (transport.responseText.match(/\(\{/)) {
                    var methodInfo = $H(eval(transport.responseText));

                    if (typeof(methodInfo.notCallable) != 'undefined') {
                        $('methodData').update('<span style="color: #9C0303; font-weight: bold;">Данный метод не может быть вызван. Возможно, один из его обязательных аргументов нескалярного типа или отсутствует PHPDoc-комментарий к нему. Укажите другой метод.</span>');
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

}