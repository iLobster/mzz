{include file='jipTitle.tpl' title="Права по умолчанию для класса: <b>$class</b>."}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url route=withAnyParam module=access name="$class" action=addUserDefault}" class="mzz-jip-link">добавить <span class="mzz-icon mzz-icon-user"><span class="mzz-bullet mzz-bullet-add"></span></span></a>){/if}</th>
    </tr>
    <tr>
        <td style="text-align: right; width: 15px; color: #999;">0</td>
        <td><a href="{url route=withAnyParam module=access action=editOwner name="$class"}" class="mzz-jip-link">Владелец объекта</a></td>
        <td style="text-align: right;">&nbsp;</td>
    </tr>
    {foreach from=$users item=user}
    <tr>
        <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
        {assign var=user_id value=$user->getId()}
        <td><a href="{url route=withAnyParam module=access action=editUserDefault name="$class/$user_id"}" class="mzz-jip-link">{$user->getLogin()}</a></td>
        <td style="text-align: right;"><a href="{url route=withAnyParam module=access action=deleteUserDefault name="$class/$user_id"}" class="mzz-jip-link" title="Удалить пользователя"><span class="mzz-icon mzz-icon-user"><span class="mzz-bullet mzz-bullet-del"></span></span></a></td>
    </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url route=withAnyParam module=access name="$class" action=addGroupDefault}" class="mzz-jip-link">добавить <span class="mzz-icon mzz-icon-group"><span class="mzz-bullet mzz-bullet-add"></span></span></a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=withAnyParam module=access action=editGroupDefault name="$class/$group_id"}" class="mzz-jip-link">{$group->getName()}</a></td>
            <td style="text-align: right;"><a href="{url route=withAnyParam module=access action=deleteGroupDefault name="$class/$group_id"}" class="mzz-jip-link" title="Удалить группу"><span class="mzz-icon mzz-icon-group"><span class="mzz-bullet mzz-bullet-del"></span></span></a></td>
        </tr>
    {/foreach}
</table>