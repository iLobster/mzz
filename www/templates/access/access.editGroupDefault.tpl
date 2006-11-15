Изменение прав по умолчанию на объект типа <b>{$class}</b> раздела <b>{$section}</b> {if $groups === false}для группы <b>{$group->getName()}</b>{/if}
<form action="{url}" method="post">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
        {if $groups !== false}
            Выберите группу
            <select name="id">
                <option value="-1" selected="selected"></option>
                {foreach from=$groups item=group}
                    <option value="{$group->getId()}">{$group->getName()}</option>
                {/foreach}
            </select>
        {/if}
        {foreach from=$actions item=action}
            <tr>
                <td>{$action}</td>
                <td><input type="checkbox" name="access[{$action}][allow]" value="1" {if not empty($acl.$action.allow)}{if $groups === false}checked="checked"{/if}{/if} /><input type="checkbox" name="access[{$action}][deny]" value="1" {if not empty($acl.$action.deny)}{if $groups === false}checked="checked"{/if}{/if} /></td>
            </tr>
        {/foreach}
        <tr>
            <td><input type="submit" value="Установить права"></td>
            <td><input type="reset" value="Сброс"></td>
        </tr>
</table>
</form>