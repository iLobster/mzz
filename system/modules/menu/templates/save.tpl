<div class="jipTitle">{if $isEdit}Редактирование элемента{else}Добавление нового элемента{/if}</div>
<script type="text/javascript">
    var url = '{$action}';
    {literal}
        (function($){
            loadForm = function(typeId) {
                if (typeId > 0) {
                    $('#properties').empty().append('<img id="loadingImg" src="' + SITE_PATH +  '/images/menu/propsload.gif" alt="Идёт загрузка..." />');
                    $('#properties').load(url, {type: typeId, onlyProperties: true}, function(){jipWindow.resize(true);});
                } else {
                    $('#properties').empty().html('<div class="field"><div class="text">Укажите тип</div></div>');
                }
            }
        })(jQuery);
    {/literal}
</script>

{form action=$action method="post" jip=true}
<div class="field">
    <div class="label">
        {form->caption name="typeId" value="Тип:"}
    </div>
    <div class="text">
        {form->select name="typeId" options=$types value=$typeId id="type" emptyFirst=true onchange="javascript: loadForm(this.value);" onkeypress="this.onchange();" style="width: 130px;"}
        <span class="caption error">{$validator->getFieldError('typeId')}</span>
    </div>
</div>
<div id="properties">
{if $item}{include file="menu/properties.tpl" typeId=$typeId item=$item}{else}
<div class="field"><div class="text">Укажите тип</div></div>
</div>
{/if}
</form>