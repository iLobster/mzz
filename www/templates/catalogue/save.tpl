{if $isEdit}<div class="jipTitle">��������������</div>{else}
{if $type === null || !isset($smarty.get.type) || isset($smarty.post.type)}<div class="jipTitle">���������� ������ ��������</div>{/if}
<div id="ajaxGetForm">
{literal}<script language="javascript">
function loadForm(id)
{{/literal}
    var folderPath = '{$folder->getPath()}';
    var url = '{url route="withAnyParam" section="catalogue" name="' + folderPath + '" action="create"}';{literal}
    new Ajax.Request(url,
    {
        method:'get',
            parameters: { type: id },
        onSuccess:
            function(transport){
                var response = transport.responseText;
                document.getElementById('ajaxGetForm').innerHTML = response;
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
            <td>���:</td>
            <td>{form->select name="type" options=$select id="type" value=$defType onchange="javascript:loadForm(this.value);" onkeypress="this.onchange();"}{$errors->get('type')}</td>
        <tr>{/if}
        {if $isEdit || $type ne 0}<tr>
            <td>{form->caption name=name value=���:}</td>
            <td>{form->text name="name" size="60" value=$item->getName()}{$errors->get('name')}</td>
        <tr>
        {foreach from=$properties item="element"}
                <tr>
                    <td>{form->caption name=$element.name value=$element.title}:</td>
                    <td>
                        {if $element.type eq 'text'}
                            {form->textarea name=$element.name value=$element.value style="width:500px;height:300px;"}{$errors->get($element.name)}
                        {elseif $element.type eq 'select'}
                            <select name="{$element.name}">
                            {foreach from=$element.args key="key" item="arg"}
                                <option value="{$key}" {if $key == $element.value}selected{/if}>{$arg}</option>
                            {/foreach}
                            </select>
                        {else}
                            {form->text name=$element.name size="60" value=$element.value}{$errors->get($element.name)}
                        {/if}
                    </td>
                <tr>
        {/foreach}{/if}
        <tr>
            <td>{form->submit name="submit" value="���������"}</td><td>{form->reset onclick="javascript: jipWindow.close();" name="reset" value="������"}</td>
        </tr>
    </table>
</form>
{/strip}
</div>