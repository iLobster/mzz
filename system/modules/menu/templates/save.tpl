<div class="jipTitle">{if $isEdit}Редактирование элемента{else}Добавление нового элемента{/if}</div>

<script type="text/javascript">
    var url = '{$action}';
    {literal}function loadForm(typeId) {
        if (typeId > 0) {
            $('properties').update('<img id="loadingImg" src="' + SITE_PATH +  '/templates/images/menu/propsload.gif" alt="Идёт загрузка..." />');
            new Ajax.Request(url, {
                method: 'post',
                parameters: {type: typeId, onlyProperties: true},
                onSuccess: function(transport) {
                    $('properties').update(transport.responseText);
                }
            });
        } else {
            $('properties').update('<strong>Укажите тип</strong>');
        }
    }{/literal}
</script>

{form action=$action method="post" jip=true}
    <table border="0" cellpadding="3" cellspacing="1" width="100%">
        <tr>
            <td style="width: 10%;">{form->caption name="typeId" value="Тип:"}</td>
            <td style="width: 90%;">{form->select name="typeId" options=$types value=$typeId id="type" emptyFirst=true onchange="javascript: loadForm(this.value);" onkeypress="this.onchange();" style="width: 130px;"} {$errors->get('typeId')}</td>
        </tr>
    </table>
    <hr class="grayPaddingBorder" />
    <div id="properties">
        {if $item}{include file="menu/properties.tpl" typeId=$typeId item=$item}{else}<strong>Укажите тип</strong>{/if}
    </div>
</form>