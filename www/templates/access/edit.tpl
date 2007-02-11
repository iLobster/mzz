{add file="popup.js"}
{include file='jipTitle.tpl' title='Права доступа'}

<table border="0" width="99%" cellpadding="5" cellspacing="1" class="list">
    <tr>
        <th colspan="3">Пользователи</th>
    </tr>

    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUser params="$id/$user_id"}" class="jipLink">{$user->getLogin()}</a></td>
            <td><a href="{url section=access action=deleteUser params="$id/$user_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $usersExists}
        <tr>
            <td align="center"><a href="{url section=access params=$id action=addUser}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url section=access params=$id action=addUser}" class="jipLink">Добавить пользователя</a></td>
        </tr>
    {/if}

    <tr>
        <th colspan="3">Группы</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url section=access action=editGroup params="$id/$group_id"}" class="jipLink">{$group->getName()}</a></td>
            <td><a href="{url section=access action=deleteGroup params="$id/$group_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $groupsExists}
        <tr>
            <td align="center"><a href="{url section=access params=$id action=addGroup}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan=2><a href="{url section=access params=$id action=addGroup}" class="jipLink">Добавить группу</a></td>
        </tr>
    {/if}
</table>
