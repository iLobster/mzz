{include file='jipTitle.tpl' title="Права по умолчанию для раздела: <b>$section</b>, класса: <b>$class</b>."}

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    <tr>
        <th colspan="3">Пользователи{if $usersExists} (<a href="{url route=withAnyParam section=access name="$section/$class" action=addUserDefault}" class="jipLink">добавить</a>){/if}</th>
    </tr>
    <tr>
        <td style="text-align: right; width: 15px; color: #999;">0</td>
        <td><a href="{url route=withAnyParam section=access action=editOwner name="$section/$class"}" class="jipLink">Владелец объекта</a></td>
        <td style="text-align: right;">&nbsp;</td>
    </tr>
    {foreach from=$users item=user}
    <tr>
        <td style="text-align: right; width: 15px; color: #999;">{$user->getId()}</td>
        {assign var=user_id value=$user->getId()}
        <td><a href="{url route=withAnyParam section=access action=editUserDefault name="$section/$class/$user_id"}" class="jipLink">{$user->getLogin()}</a></td>
        <td style="text-align: right;"><a href="{url route=withAnyParam section=access action=deleteUserDefault name="$section/$class/$user_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
    </tr>
    {/foreach}

    <tr>
        <th colspan="3">Группы{if $groupsExists} (<a href="{url route=withAnyParam section=access name="$section/$class" action=addGroupDefault}" class="jipLink">добавить</a>){/if}</th>
    </tr>

    {foreach from=$groups item=group}
        <tr>
            <td style="text-align: right; width: 15px; color: #999;">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=withAnyParam section=access action=editGroupDefault name="$section/$class/$group_id"}" class="jipLink">{$group->getName()}</a></td>
            <td style="text-align: right;"><a href="{url route=withAnyParam section=access action=deleteGroupDefault name="$section/$class/$group_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
</table>