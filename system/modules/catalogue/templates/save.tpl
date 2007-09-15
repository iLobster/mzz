{if $isEdit}<div class="jipTitle">Редактирование</div>{else}
{if $type === null || !isset($smarty.get.type) || isset($smarty.post.type)}<div class="jipTitle">Добавление нового элемента</div>{/if}
<div id="ajaxGetForm">
<script type="javascript">
cssLoader.load(SITE_PATH + '/templates/css/catalogue.css');
function loadForm(id)
{ldelim}
    var url = '{url route="withAnyParam" section=$current_section name=$folder->getPath() action="create"}';{literal}
    new Ajax.Request(url,
    {
        method:'get',
            parameters: { type: id },
        onSuccess:
            function(transport){
                $('ajaxGetForm').update(transport.responseText);
            },
        onFailure:
            function(){ alert('Something went wrong...') }
    });{/literal}
{rdelim}
</script>
{/if}

{strip}
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="4" cellspacing="1" width="99%">
        {if !$isEdit}<tr>
            <td>Тип:</td>
            <td>{form->select name="type" options=$select id="type" value=$defType emptyFirst=1 onchange="javascript:loadForm(this.value);" onkeypress="this.onchange();"}{$errors->get('type')}</td>
        </tr>{/if}
        {if $type != 0}<tr>
            <td>{form->caption name="name" value="Имя:"}</td>
            <td>{form->text name="name" size="60" value=$item->getName()}{$errors->get('name')}</td>
        </tr>{/if}
        {foreach from=$properties item="element"}
            <tr>
                <td valign="top">{form->caption name=$element.name value=$element.title}:</td>
                <td valign="top">{if $element.type eq 'text'}
                {form->textarea name=$element.name value=$element.value style="width:500px;height:300px;"}{$errors->get($element.name)}
                {elseif $element.type eq 'select' || $element.type == 'dynamicselect'}
                    {form->select name=$element.name options=$element.args value=$element.value}
                {elseif $element.type == 'datetime'}
                    {literal}<script type="text/javascript">Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created","cache":"false"});</script>{/literal}
                    {if $isEdit}{assign var="calendarvalue" value=$element.value}{else}{assign var="calendarvalue" value=$smarty.now}{/if}
                    {form->text name=$element.name size="20" id="calendar-field-created" value=$calendarvalue|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-created" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button>{$errors->get($element.name)}
                {elseif $element.type == 'img'}
                {*
                    {form->hidden name="images" id="catalogueFormImages"}
<a href="/browser" onclick="mzzRegistry.set('fileBrowseOptions', {literal}{target: 'catalogueImagesList', formElementId: 'catalogueFormImages'}{/literal}); jipWindow.open(this.href, 1); return false;"><img src="{$SITE_PATH}/templates/images/buttonAdd.gif" border="1"></a>
                    <div id="catalogueImagesList"></div>
                *}
                    
                    {assign var="elementname" value=$element.name}
                    {form->hidden name=$elementname[] id="catalogueFormImages_$elementname"}
                    <a href="/browser" onclick="mzzRegistry.set('fileBrowseOptions', {ldelim}target: 'catalogueImagesList_{$elementname}', formElementId: 'catalogueFormImages_{$elementname}'{rdelim}); jipWindow.open(this.href, 1); return false;"><img src="{$SITE_PATH}/templates/images/buttonAdd.gif" border="1"></a>
                    <div id="catalogueImagesList_{$elementname}">
                    {foreach from=$element.value item="file"}
                        <div class="fileThumb"><img src="{url route="fmFolder" name=$file->extra()->getThumbnail()->getFullPath()}" title="{$file->getName()|htmlspecialchars}" alt="{$file->getName()}" /></div><span>Удалить</span>
                    {/foreach}
                    </div>
                {else}{form->text name=$element.name size="60" value=$element.value}{$errors->get($element.name)}{/if}</td>
            </tr>{/foreach}
        <tr>
            <td style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{/strip}
</div>