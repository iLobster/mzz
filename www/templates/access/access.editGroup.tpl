<div class="jipTitle">Изменение прав на объект ... {if $groups === false}для группы <code>{$group->getName()}</code>{/if}</div>
<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
<table border="0" width="99%" cellpadding="4" cellspacing="1" class="list">
        {if $groups !== false}
            Выберите группу
            <select name="user_id">
                <option value="-1" selected="selected"></option>
                {foreach from=$groups item=group}
                    <option value="{$group->getId()}">{$group->getName()}</option>
                {/foreach}
            </select>
        {/if}
        {foreach from=$actions item=action}
            <tr>
                <td><input type="checkbox" name="access[{$action}][allow]" id="access[{$action}][allow]" value="1" {if not empty($acl.$action.allow)}{if $groups === false}checked="checked"{/if}{/if} /><input type="checkbox" name="access[{$action}][deny]" id="access[{$action}][deny]" value="1" {if not empty($acl.$action.deny)}{if $groups === false}checked="checked"{/if}{/if} /></td>
                <td style="width: 90%;"><label for="access[{$action}]">{$action}</label></td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="2"><input type="submit" value="Установить права"> <input type="reset" value="Отмена" onclick="javascript: hideJip();"></td>
        </tr>
</table>
</form>