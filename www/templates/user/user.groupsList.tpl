{add file="popup.js"}
<a href="{url section=user action=list}">Пользователи</a>
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td colspan="4">Страницы ({$pager->getPagesTotal()}): {$pager->toString()}</td>
    </tr>
    <tr>
        <td>Id</td>
        <td>Имя</td>
        <td>Пользователей в группе</td>
        <td>Jip</td>
    </tr>
    {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            <td>{$group->getName()}</td>
            <td>{$group->getUsers()|@count}</td>
            <td>{$group->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url section=user action=groupCreate}" onClick="openWin('{url section=user action=groupCreate}', 'group_create', 500,400); return false;"><img src="/templates/images/add.gif" width="16" height="16" border="0" /></a></td>
        <td colspan="3"><a href="{url section=user action=groupCreate}" onClick="openWin('{url section=user action=groupCreate}', 'group_create', 500,400); return false;">Добавить группу</a></td>
    </tr>
</table>