{include file='jipTitle.tpl' title='Права доступа'}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url route=withId module=access id=$id action=addUser}" class="mzz-jip-link">добавить <span class="mzz-icon mzz-icon-user"><span class="mzz-bullet mzz-bullet-add"></span></span></a>){/if}</th>
    </tr>

    {foreach from=$users item=user}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url route=withAnyParam module=access action=editUser name="$id/$user_id"}" class="mzz-jip-link">{$user->getLogin()}</a></td>
            <td style="text-align: right;"><a href="{url route=withAnyParam module=access action=deleteUser name="$id/$user_id"}" class="mzz-jip-link" title="Удалить пользователя"><span class="mzz-icon mzz-icon-user"><span class="mzz-bullet mzz-bullet-del"></span></span></a></td>
        </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url route=withId module=access id=$id action=addGroup}" class="mzz-jip-link">добавить <span class="mzz-icon mzz-icon-group"><span class="mzz-bullet mzz-bullet-add"></span></span></a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=withAnyParam module=access action=editGroup name="$id/$group_id"}" class="mzz-jip-link">{$group->getName()}</a></td>
            <td style="text-align: right;"><a href="{url route=withAnyParam module=access action=deleteGroup name="$id/$group_id"}" class="mzz-jip-link" title="Удалить группу"><span class="mzz-icon mzz-icon-group"><span class="mzz-bullet mzz-bullet-del"></span></span></a></td>
        </tr>
    {/foreach}
</table>
