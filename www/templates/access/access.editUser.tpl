<div class="jipTitle">Изменение прав на объект ... {if $users === false}для пользователя <code>{$user->getLogin()}</code>{/if}</div>
<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
<table border="0" width="100%" cellpadding="4" cellspacing="1" class="list">
        {if $users !== false}
            Выберите пользователя
            <select name="user_id">
                <option value="-1" selected="selected"></option>
                {foreach from=$users item=user}
                    <option value="{$user->getId()}">{$user->getLogin()}</option>
                {/foreach}
            </select>
        {/if}
        {foreach from=$actions item=action}
            <tr>
                <td><input type="checkbox" name="access[{$action}]" id="access[{$action}]" value="1" {if not empty($acl.$action)}{if $users === false}checked="checked"{/if}{/if} /></td>
                <td style="width: 100%"><label for="access[{$action}]">{$action}</label></td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="2"><input type="submit" value="Установить права"> <input type="reset" value="Сброс"></td>
        </tr>
</table>
</form>