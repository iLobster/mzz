{add file="popup.js"}
{add file="confirm.js"}
Права по умолчанию. Раздел: <b>{$section}</b>, класс: <b>{$class}</b>.
<br /><br />
Пользователи
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td align="center">0</td>
        <td><a href="{url section=access action=editOwner params="$section/$class"}" onClick="openWin('{url section=access action=editOwner params="$section/$class"}', 'access_editowner_{$section}_{$class}', 500, 400); return false;">Владелец объекта</a></td>
        <td>&nbsp;</td>
    </td>
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUserDefault params="$section/$class/$user_id"}" onClick="openWin('{url section=access action=editUserDefault params="$section/$class/$user_id"}', 'access_adduserdefault_{$section}_{$class}_{$user_id}', 500, 400); return false;">{$user->getLogin()}</a></td>
            <td><a href="{url section=access action=deleteUserDefault params="$section/$class/$user_id"}" onClick="mzz_confirm('Вы хотите удалить этого пользователя?') &&  openWin('{url section=access action=deleteUserDefault params="$section/$class/$user_id"}', 'access_deleteuserdefault_{$section}_{$class}_{$user_id}', 500, 400); return false;"><img src="{url section="" params="templates/images/delete.gif"}" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $usersExists}
        <tr>
            <td align="center"><a href="{url section=access params="$section/$class" action=addUserDefault}" onClick="openWin('{url section=access params="$section/$class" action=addUserDefault}', 'access_adduserdefault_{$section}_{$class}', 500, 400); return false;"><img src="{url section="" params="templates/images/add.gif"}" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url section=access params="$section/$class" action=addUserDefault}" onClick="openWin('{url section=access params="$section/$class" action=addUserDefault}', 'access_adduserdefault_{$section}_{$class}', 500, 400); return false;">Добавить пользователя</a></td>
        </tr>
    {/if}
</table>
Группы
<table border="0" width="100%" cellpadding="0" cellspacing="1">
     {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url section=access action=editGroupDefault params="$section/$class/$group_id"}" onClick="openWin('{url section=access action=editGroupDefault params="$section/$class/$group_id"}', 'access_addgroupdefault_{$section}_{$class}_{$group_id}', 500, 400); return false;">{$group->getName()}</a></td>
            <td><a href="{url section=access action=deleteGroupDefault params="$section/$class/$group_id"}" onClick="mzz_confirm('Вы хотите удалить эту группу?') && openWin('{url section=access action=deleteGroupDefault params="$section/$class/$group_id"}', 'access_deletegroupdefault_{$section}_{$class}_{$group_id}', 500, 400); return false;"><img src="{url section="" params="templates/images/delete.gif"}" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $groupsExists}
        <tr>
            <td align="center"><a href="{url section=access params="$section/$class" action=addGroupDefault}" onClick="openWin('{url section=access params="$section/$class" action=addGroupDefault}', 'access_addgroupdefault_{$section}_{$class}', 500, 400); return false;"><img src="{url section="" params="templates/images/add.gif"}" width="16" height="16" /></a></td>
            <td colspan=2><a href="{url section=access params="$section/$class" action=addGroupDefault}" onClick="openWin('{url section=access params="$section/$class" action=addGroupDefault}', 'access_addgroup_{$section}_{$class}', 500, 400); return false;">Добавить группу</a></td>
        </tr>
    {/if}
</table>