{add file="popup.js"}
{include file='jipTitle.tpl' title='Права доступа'}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="list">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url section=access params=$id action=addUser}" class="jipLink">добавить</a>){/if}</th>
    </tr>

    {foreach from=$users item=user}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUser params="$id/$user_id"}" class="jipLink">{$user->getLogin()}</a></td>
            <td style="text-align: right;"><a href="{url section=access action=deleteUser params="$id/$user_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url section=access params=$id action=addGroup}" class="jipLink">добавить</a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url section=access action=editGroup params="$id/$group_id"}" class="jipLink">{$group->getName()}</a></td>
            <td style="text-align: right;"><a href="{url section=access action=deleteGroup params="$id/$group_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
</table>
