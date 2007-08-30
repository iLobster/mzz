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
        $('catalogueSubmitProperty').enable();
        return false;
    }
    var loadingDiv = $(document.createElement('div'));
    loadingDiv.className = "jipAjaxLoading";
    loadingDiv.update('Загрузка данных...');
    $('catalogueTypeConfig').appendChild(loadingDiv);

    $('catalogueSubmitProperty').disable();

    new Ajax.Updater({success: 'catalogueTypeConfig' }, CATALOGUE_PATH, {
        parameters: {loadType: value}, method: 'GET',
        onFailure: function () {
            loadingDiv.className = 'jipAjaxLoadingError';
            loadingDiv.update('Ошибка загрузки.');
        },
        onComplete: function(transport, param) {
            mzzCatalogue.autoloadSelects();
            $('catalogueSubmitProperty').enable();
        }
    });
}


var mzzCatalogue = {
    setValues: function(values) {
        this.values = $H(values);
    },

    getList: function(select, type)
    {
        type = (['classes', 'methods', 'modules', 'folders'].indexOf(type) >= 0) ? type : 'modules';
        var optList = $('catalogue_' + type + '_list');
        if (!select || !optList) {
            return false;
        }

        var validValue = true;
        if ($F(select) == '') {
            var types = $A(['modules', 'classes', 'methods', 'extractMethods', 'folders']);
            types.each(function(value, index) {
                if (index <= types.indexOf(type) || !$('catalogue_' + value + '_list') ||
                $('catalogue_' + value + '_list').disabled) {
                    return;
                }
                validValue = false;
                $('catalogue_' + value + '_list').disable().options.length = 0;
                if (value == 'methods') {
                    $('methodArgsValues').update('');
                }
            });
        }

        $('catalogueSubmitProperty').disable();
        optList.disable();
        optList.options.length = 0;

        if (!validValue) {
            return false;
        }

        switch (type) {
            case 'modules':
            this.setLoadingMode($('catalogue_classes_list'));
            case 'classes':
            this.setLoadingMode($('catalogue_methods_list'));
            //this.setLoadingMode($('catalogue_extractMethods_list'));
            this.setLoadingMode($('catalogue_folders_list'));
            case 'methods':
            this.setLoadingMode($('catalogue_extractMethods_list'));
        }
        if ($('methodArgsValues')) {
            $('methodArgsValues').update('Загрузка данных...');
        }
        optList.options[0] = new Option('Загрузка...', '');

        var params = $H({loadType: type, for_id: $F(select)});
        if (type == 'folders') {
            params.merge({
            'section': $F('catalogue_sections_list')
            });
        }

        new Ajax.Request(CATALOGUE_PATH, {
            method: 'get', parameters: params, onSuccess: function(transport) {
                if (transport.responseText.match(/\(\{/)) {
                    $('catalogueSubmitProperty').enable();
                    var optListData = eval(transport.responseText);
                    var i = 0;
                    var selectedIndex = false;
                    var extractMethods = false;


                    if (type == 'methods' && typeof(optListData) == 'object') {
                        var extractMethods = $A(optListData.extractMethods);
                        optListData = optListData.searchMethods;
                    }

                    $H(optListData).each(function(pair) {
                        if (typeof(pair.value) == 'string') {
                            optList.options[i] = new Option(pair.value, pair.key);
                        } else {
                            optList.options[i] = new Option(String.fromCharCode(160).times(pair.value[1] * 5) + pair.value[0], pair.key);
                        }

                        if (typeof(mzzCatalogue.values[type]) != 'undefined' && mzzCatalogue.values[type] === pair.key) {
                            selectedIndex = i;
                            $(optList.options[i]).setStyle({fontWeight: 'bold'});
                            mzzCatalogue.values.remove(type);
                        }
                        i++;
                    });

                    if (extractMethods && $('catalogue_extractMethods_list')) {
                        var extractMethodsList = $('catalogue_extractMethods_list');
                        var m = 0;
                        extractMethods.each(function(methodName) {
                            extractMethodsList.options[m] = new Option(methodName, methodName);
                            if (typeof(mzzCatalogue.values['extractMethods']) != 'undefined' && mzzCatalogue.values['extractMethods'] === methodName) {
                                extractMethodsList.selectedIndex = m;
                                $(extractMethodsList.options[m]).setStyle({fontWeight: 'bold'});
                                mzzCatalogue.values.remove('extractMethods');
                            }
                            m++;
                        });

                        if (m > 0) {
                            extractMethodsList.enable();
                        } else {
                            extractMethodsList.options[0] = new Option('Данных нет', '');
                        }
                    } else if (type == 'methods' && $('catalogue_extractMethods_list')) {
                        $('catalogue_extractMethods_list').options[0] = new Option('Данные не получены.', '');
                    }

                    optList.selectedIndex = selectedIndex || 0;

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
        return id ? $(id).options[$(id).selectedIndex].text : false;
    },


    getMethodInfo: function(select)
    {
        var classId = $F($('catalogue_classes_list'));
        $('methodArgsValues').update('Загрузка данных...');
        $('catalogueSubmitProperty').disable();

        new Ajax.Request(CATALOGUE_PATH, {
            method: 'get', parameters: { loadType: 'method',  class_id: classId, method_name: $F(select)}, onSuccess: function(transport) {
                if (transport.responseText.match(/\(\{/)) {
                    var methodInfo = $H(eval(transport.responseText));

                    if (typeof(methodInfo.notCallable) != 'undefined') {
                        $('methodArgsValues').update('<span style="color: #9C0303; font-weight: bold;">Данный метод не может быть вызван. Возможно, один из его обязательных аргументов нескалярного типа или отсутствует PHPDoc-комментарий к нему. Укажите другой метод.</span>');
                    } else {
                        var description = methodInfo.description || 'Описание не указано';
                        methodInfo.remove('description');

                        $('methodArgsValues').update(description);


                        var descTable = document.createElement('table');
                        descTable.style.border = '0';
                        descTable.cellPadding = "3";
                        descTable.cellSadding = "3";
                        descTable.width = "70%";

                        var i = 0;
                        methodInfo.each(function (pair) {

                            var argValueRow   = descTable.insertRow(-1);
                            var nameCell  = argValueRow.insertCell(-1);
                            nameCell.rowSpan = "2";
                            nameCell.vAlign = "top";
                            nameCell.style.color = "#515151";

                            var cellText  = document.createTextNode(pair.key + String.fromCharCode(160) + '=');
                            nameCell.appendChild(cellText);

                            var valueCell  = argValueRow.insertCell(-1);
                            var editable = pair.value.editable == '1';
                            if (editable) {


                                if (pair.value.type == 'boolean') {
                                    var valueInput = $(document.createElement('select')).setStyle({width: '60px'});
                                } else {
                                    var valueInput = document.createElement('input');
                                }

                                valueInput.name = 'typeConfig[methodArgs][' + i + ']';

                                if (pair.value.type == 'boolean') {
                                    valueInput.options[0] = new Option('да','true');
                                    valueInput.options[1] = new Option('нет','false');

                                    if (typeof(mzzCatalogue.values.methodArgs) != 'undefined' &&
                                        typeof(mzzCatalogue.values.methodArgs['arg' + i]) != 'undefined') {
                                        valueInput.selectedIndex = mzzCatalogue.values.methodArgs['arg' + i] == 'false' ? 1 : 0;
                                        $(valueInput.options[valueInput.selectedIndex]).setStyle({fontWeight: 'bold'});
                                        mzzCatalogue.values.methodArgs.remove('arg' + i);
                                    } else if (typeof(pair.value.defaultValue) != 'undefined') {
                                        valueInput.selectedIndex = pair.value.defaultValue == 'false' ? 1 : 0;
                                    }

                                    if (typeof(pair.value.defaultValue) != 'undefined') {
                                        if (pair.value.defaultValue == 'false') {
                                            pair.value.defaultValue = 'нет';
                                        } else if (pair.value.defaultValue == 'true') {
                                            pair.value.defaultValue = 'да'
                                        }
                                    }
                                } else {
                                    if (typeof(mzzCatalogue.values.methodArgs) != 'undefined' &&
                                        typeof(mzzCatalogue.values.methodArgs['arg' + i]) != 'undefined') {
                                        valueInput.value = mzzCatalogue.values.methodArgs['arg' + i];
                                        mzzCatalogue.values.methodArgs.remove('arg' + i);
                                    } else {
                                        valueInput.value = typeof(pair.value.defaultValue) != 'undefined' ? pair.value.defaultValue : '';
                                    }
                                }

                                valueCell.appendChild(valueInput);
                            }

                            if (typeof(pair.value.defaultValue) != 'undefined') {
                                if (pair.value.defaultValue != '') {
                                    var defaultText = 'по умолчанию: ' + pair.value.defaultValue;
                                } else {
                                    var defaultText = 'пустое значение по умолчанию';
                                }

                                if (editable) {
                                    defaultText = ' (' + defaultText + ')';
                                } else {
                                   defaultText += ', нередактируемое значение';
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

                            i++;
                        });

                        $('catalogueSubmitProperty').enable();
                        $('methodArgsValues').appendChild(descTable);
                    }
                } else {
                    $('methodArgsValues').update('Данные не получены');
                }
            }, onFailure: function(transport) {
                $('methodArgsValues').update('Данные не получены');
            }
        });
    },

    autoloadSelects: function() {
        if (mzzCatalogue.values.size() && $('catalogue_sections_list') && $F('catalogue_sections_list') != '') {
            $('catalogue_sections_list').onchange();
        }
    }
}

mzzCatalogue.setValues({});