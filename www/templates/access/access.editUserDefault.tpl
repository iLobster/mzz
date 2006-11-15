Изменение прав на объект типа <b>{$class}</b> раздела <b>{$section}</b> {if $users === false}для пользователя <b>{$user->getLogin()}</b>{/if}
<form action="{url}" method="post">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
        {if $users !== false}
            Выберите пользователя
            <select name="id">
                <option value="-1" selected="selected"></option>
                {foreach from=$users item=user}
                    <option value="{$user->getId()}">{$user->getLogin()}</option>
                {/foreach}
            </select>
        {/if}
        {foreach from=$actions item=action}
            <tr>
                <td>{$action}</td>
                <td><input type="checkbox" name="access[{$action}][allow]" value="1" {if not empty($acl.$action.allow)}{if $users === false}checked="checked"{/if}{/if} /><input type="checkbox" name="access[{$action}][deny]" value="1" {if not empty($acl.$action.deny)}{if $users === false}checked="checked"{/if}{/if} /></td>
            </tr>
        {/foreach}
        <tr>
            <td><input type="submit" value="Установить права"></td>
            <td><input type="reset" value="Сброс"></td>
        </tr>
</table>
</form>