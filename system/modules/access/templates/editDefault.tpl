{include file='jipTitle.tpl' title="Права по умолчанию для класса: <b>$class</b>."}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url route=withAnyParam section=access name="$class" action=addUserDefault}" class="jipLink">добавить <span class="mzz-icon mzz-icon-user"><span class="mzz-overlay mzz-overlay-add"></span></span></a>){/if}</th>
    </tr>
    <tr>
        <td style="text-align: right; width: 15px; color: #999;">0</td>
        <td><a href="{url route=withAnyParam section=access action=editOwner name="$class"}" class="jipLink">Владелец объекта</a></td>
        <td style="text-align: right;">&nbsp;</td>
    </tr>
    {foreach from=$users item=user}
    <tr>
        <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
        {assign var=user_id value=$user->getId()}
        <td><a href="{url route=withAnyParam section=access action=editUserDefault name="$class/$user_id"}" class="jipLink">{$user->getLogin()}</a></td>
        <td style="text-align: right;"><span class="mzz-icon mzz-icon-user"><span class="mzz-overlay mzz-overlay-del"><a href="{url route=withAnyParam section=access action=deleteUserDefault name="$class/$user_id"}" class="mzz-jip-link" title="Удалить пользователя"></a></span></span></td>
    </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url route=withAnyParam section=access name="$class" action=addGroupDefault}" class="jipLink">добавить <span class="mzz-icon mzz-icon-group"><span class="mzz-overlay mzz-overlay-add"></span></span></a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=withAnyParam section=access action=editGroupDefault name="$class/$group_id"}" class="jipLink">{$group->getName()}</a></td>
            <td style="text-align: right;"><span class="mzz-icon mzz-icon-group"><span class="mzz-overlay mzz-overlay-del"><a href="{url route=withAnyParam section=access action=deleteGroupDefault name="$class/$group_id"}" class="mzz-jip-link" title="Удалить группу"></a></span></span></td>
        </tr>
    {/foreach}
</table>