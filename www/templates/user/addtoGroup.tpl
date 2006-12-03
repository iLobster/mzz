{if is_null($filter)}
Добавление пользователей в группу <b>{$group->getName()}</b><br />
<form action="{url}" id='filterForm' method="get"  onsubmit="return sendFormInAjax(this, 'users'); return false;">
    <input type="text" value="{$filter}" name="filter"><input type="image" src="{$SITE_PATH}/templates/images/search.gif">
</form>
<div id='users' style='width: 100%;'>
</div>
{else}
    Найдено пользователей: <b>{$users|@count}</b><br />
    <form method="post" action="{url}" onsubmit="return sendFormWithAjax(this);return false;">
    <table border="0" width="100%" cellpadding="0" cellspacing="1">
        {foreach from=$users item=user}
            <tr>
                <td align="center" width="10%">{$user->getId()}</td>
                <td width="10%" align="center"><input type="checkbox" name="users[{$user->getId()}]" value="1" /></td>
                <td width="80%">{$user->getLogin()}</td>
            </tr>
        {/foreach}
            <tr>
                <td><input type="submit" value="Добавить"></td>
                <td colspan="2"><input type="reset" value="Отмена" onclick="javascript: hideJip();"></td>
            </tr>
    </table>
    </form>
{/if}