{include file='jipTitle.tpl' title='Права доступа'}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url route=withId section=access id=$id action=addUser}" class="jipLink">добавить <span class="mzz-icon mzz-icon-user-add"></span></a>){/if}</th>
    </tr>

    {foreach from=$users item=user}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url route=withAnyParam section=access action=editUser name="$id/$user_id"}" class="jipLink">{$user->getLogin()}</a></td>
            <td style="text-align: right;"><span class="mzz-icon mzz-icon-user-del"><a href="{url route=withAnyParam section=access action=deleteUser name="$id/$user_id"}" class="mzz-jip-link" title="Удалить пользователя"></a></span></td>
        </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url route=withId section=access id=$id action=addGroup}" class="jipLink">добавить <span class="mzz-icon mzz-icon-group-add"></span></a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=withAnyParam section=access action=editGroup name="$id/$group_id"}" class="jipLink">{$group->getName()}</a></td>
            <td style="text-align: right;"><span class="mzz-icon mzz-icon-group-del"><a href="{url route=withAnyParam section=access action=deleteGroup name="$id/$group_id"}" class="mzz-jip-link" title="Удалить группу"></a></span></td>
        </tr>
    {/foreach}
</table>
