{add file="popup.js"}
<a href="{url section=user action=groupsList}">Группы</a>
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td colspan="3">Страницы ({$pager->getPagesTotal()}): {$pager->toString()}</td>
    </tr>
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            <td>{$user->getLogin()}</td>
            <td>{$user->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;"><img src="/templates/images/add.png" width="16" height="16" border="0" /></a></td>
        <td colspan="2"><a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;">Добавить пользователя</a></td>
    </tr>
</table>