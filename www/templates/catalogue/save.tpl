{if $isEdit}<div class="jipTitle">Редактирование</div>{else}
{if $type === null || !isset($smarty.get.type) || isset($smarty.post.type)}<div class="jipTitle">Добавление нового элемента</div>{/if}
<div id="ajaxGetForm">
{literal}<script language="javascript">
function loadForm(id)
{{/literal}
    var url = '{url route="withAnyParam" section="catalogue" name=$folder->getPath() action="create"}';{literal}
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
    });
}
</script>{/literal}
{/if}

{strip}
<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        {if !$isEdit}<tr>
            <td>Тип:</td>
            <td>{form->select name="type" options=$select id="type" value=$defType onchange="javascript:loadForm(this.value);" onkeypress="this.onchange();"}{$errors->get('type')}</td>
        </tr>{/if}
        <tr>
            <td>{form->caption name="name" value="Имя:"}</td>
            <td>{form->text name="name" size="60" value=$item->getName()}{$errors->get('name')}</td>
        </tr>
        {foreach from=$properties item="element"}
            <tr>
                <td>{form->caption name=$element.name value=$element.title}:</td>
                <td>{if $element.type eq 'text'}
                {form->textarea name=$element.name value=$element.value style="width:500px;height:300px;"}{$errors->get($element.name)}
                {elseif $element.type eq 'select' || $element.type == 'dynamicselect'}
                    {form->select name=$element.name options=$element.args value=$element.value}
                {elseif $element.type == 'datetime'}
                    {literal}<script type="text/javascript">Calendar.setup({"ifFormat":"%H:%M:%S %d/%m/%Y","daFormat":"%d/%m/%Y","firstDay":1,"showsTime":true,"showOthers":true,"timeFormat":24, "align":"BR", "inputField":"calendar-field-created","button":"calendar-trigger-created","cache":"false"});</script>{/literal}
                    {if $isEdit}{assign var="calendarvalue" value=$element.value}{else}{assign var="calendarvalue" value=$smarty.now}{/if}
                    {form->text name=$element.name size="20" id="calendar-field-created" value=$calendarvalue|date_format:"%H:%M:%S %d/%m/%Y"} <button type="button" id="calendar-trigger-created" class="calendar_button"><img src="{$SITE_PATH}/templates/images/calendar.png" /></button>{$errors->get($element.name)}
                {elseif $element.type == 'img'}
                    {foreach from=$element.args item="img"}
                        <img src="{url route="galleryPicAction" action="viewThumbnail" id=$img->getId() album=$img->getAlbum()->getId() name=$img->getAlbum()->getGallery()->getOwner()->getLogin()}" />
                    {/foreach}
                {else}{form->text name=$element.name size="60" value=$element.value}{$errors->get($element.name)}{/if}</td>
            </tr>{/foreach}
        <tr>
            <td>{form->submit name="submit" value="Сохранить"}</td><td>{form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>
{/strip}
</div>