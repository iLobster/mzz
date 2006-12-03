{add file="popup.js"}
{add file="confirm.js"}
<div class="jipTitle">Права доступа</div>

<table border="0" width="99%" cellpadding="5" cellspacing="1" class="list">
    <tr>
        <th colspan="3">Пользователи</th>
    </tr>

    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUser params="$id/$user_id"}" onClick="return showJip('{url section=access action=editUser params="$id/$user_id"}');">{$user->getLogin()}</a></td>
            <td><a href="{url section=access action=deleteUser params="$id/$user_id"}" onClick="mzz_confirm('Вы хотите удалить этого пользователя?') &&  showJip('{url section=access action=deleteUser params="$id/$user_id"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $usersExists}
        <tr>
            <td align="center"><a href="{url section=access params=$id action=addUser}" onClick="return showJip('{url section=access params=$id action=addUser}');"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url section=access params=$id action=addUser}" onClick="return showJip('{url section=access params=$id action=addUser}');">Добавить пользователя</a></td>
        </tr>
    {/if}

    <tr>
        <th colspan="3">Группы</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url section=access action=editGroup params="$id/$group_id"}" onClick="return showJip('{url section=access action=editGroup params="$id/$group_id"}' {*, 'access_addgroup_{$id}_{$group_id}', 500, 400); return false *});">{$group->getName()}</a></td>
            <td><a href="{url section=access action=deleteGroup params="$id/$group_id"}" onClick="mzz_confirm('Вы хотите удалить эту группу?') && showJip('{url section=access action=deleteGroup params="$id/$group_id"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $groupsExists}
        <tr>
            <td align="center"><a href="{url section=access params=$id action=addGroup}" onClick="return showJip('{url section=access params=$id action=addGroup}');"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan=2><a href="{url section=access params=$id action=addGroup}" onClick="return showJip('{url section=access params=$id action=addGroup}');">Добавить группу</a></td>
        </tr>
    {/if}
</table>
