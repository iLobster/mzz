{if $isEdit}<div class="jipTitle">Редактирование</div>{else}
{if $type === null || !isset($smarty.get.type) || isset($smarty.post.type)}<div class="jipTitle">Добавление нового элемента</div>{/if}
<div id="ajaxGetForm">
{literal}<script language="javascript">
function loadForm(id)
{{/literal}
    {if $isRoot}var url = '{url route="menuCreateAction" name=$menu->getName() id="0"}';{else}var url = '{url route="withId" section="menu" id=$id action="create"}';{/if}
    {literal}
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

<form action="{$action}" method="post" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" cellpadding="0" cellspacing="1" width="99%">
        {if !$isEdit}<tr>
            <td>Тип:</td>
            <td>{form->select name="type" options=$select id="type" onchange="javascript:loadForm(this.value);" onkeypress="this.onchange();"}{$errors->get('type')}</td>
        </tr>{/if}
        {if $type != 0}<tr>
            <td>{form->caption name="title" value="Заголовок:"}</td>
            <td>{form->text name="title" size="60" value=$item->getTitle()}{$errors->get('title')}</td>
        </tr>{/if}
        {foreach from=$properties item="element"}
            <tr>
                <td>{form->caption name=$element.name value=$element.title}:</td>
                <td>{if $element.type eq 'text'}
                {form->textarea name=$element.name value=$element.value style="width:500px;height:300px;"}{$errors->get($element.name)}
                {elseif $element.type eq 'select' || $element.type == 'dynamicselect'}
                    {form->select name=$element.name options=$element.args value=$element.value}
                {elseif $element.name == 'url'}{$request->getUrl()}{form->text name=$element.name size="60" value=$element.value}{$errors->get($element.name)}
                {else}{form->text name=$element.name size="60" value=$element.value}{$errors->get($element.name)}{/if}</td>
            </tr>{/foreach}
        <tr>
            <td style="text-align:left;">{form->submit name="submit" value="Сохранить"} {form->reset jip=true name="reset" value="Отмена"}</td>
        </tr>
    </table>
</form>