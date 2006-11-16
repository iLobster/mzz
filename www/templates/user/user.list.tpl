{add file="popup.js"}

<div id="submenu"><a href="{url section=user action=groupsList}">Группы</a> <a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;">Добавить пользователя</a></div>

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="list">
    {foreach from=$users item=user}
        <tr>
            <td width="30" align="center">{$user->getId()}</td>
            <td>{$user->getLogin()}</td>
            <td width="20" >{$user->getJip()}</td>
        </tr>
    {/foreach}
</table>
<div class="pages">{$pager->toString()}</div>
