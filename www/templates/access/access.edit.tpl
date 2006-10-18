{add file="popup.js"}
Пользователи
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUser params="$id/$user_id"}" onClick="openWin('{url section=access action=editUser params="$id/$user_id"}', 'access_adduser_{$id}_{$user_id}', 500, 400); return false;">{$user->getLogin()}</a></td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url section=access params="$id" action=addUser}" onClick="openWin('{url section=access params=$id action=addUser}', 'access_adduser_{$id}', 500, 400); return false;"><img src="/templates/images/add.gif" width="16" height="16" border="0" /></a></td>
        <td><a href="{url section=access params=$id action=addUser}" onClick="openWin('{url section=access params=$id action=addUser}', 'access_adduser_{$id}', 500, 400); return false;">Добавить пользователя</a></td>
    </tr>
</table>
Группы
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    {foreach from=$groups item=group}
        <tr>
            <td align="center">{$user->getId()}</td>
            <td>{$group->getName()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url section=access params=$id action=addGroup}" onClick="openWin('{url section=access params=$id action=addGroup}', 'access_addgroup_{$id}', 500, 400); return false;"><img src="/templates/images/add.gif" width="16" height="16" border="0" /></a></td>
        <td><a href="{url section=access params=$id action=addGroup}" onClick="openWin('{url section=access params=$id action=addGroup}', 'access_addgroup_{$id}', 500, 400); return false;">Добавить группу</a></td>
    </tr>
</table>