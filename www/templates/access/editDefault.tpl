{add file="popup.js"}
{add file="confirm.js"}
<div id="jipTitle">
<div class="jipMove">&nbsp;</div>
Права по умолчанию. Раздел: <b>{$section}</b>, класс: <b>{$class}</b>.
</div>
<br /><br />
Пользователи
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <tr>
        <td align="center">0</td>
        <td><a href="{url section=access action=editOwner params="$section/$class"}" onClick="return showJip('{url section=access action=editOwner params="$section/$class"}');">Владелец объекта</a></td>
        <td>&nbsp;</td>
    </td>
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url section=access action=editUserDefault params="$section/$class/$user_id"}" onClick="return showJip('{url section=access action=editUserDefault params="$section/$class/$user_id"}');">{$user->getLogin()}</a></td>
            <td><a href="{url section=access action=deleteUserDefault params="$section/$class/$user_id"}" onClick="mzz_confirm('Вы хотите удалить этого пользователя?') && showJip('{url section=access action=deleteUserDefault params="$section/$class/$user_id"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $usersExists}
        <tr>
            <td align="center"><a href="{url section=access params="$section/$class" action=addUserDefault}" onClick="return showJip('{url section=access params="$section/$class" action=addUserDefault}');"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url section=access params="$section/$class" action=addUserDefault}" onClick="return showJip('{url section=access params="$section/$class" action=addUserDefault}');">Добавить пользователя</a></td>
        </tr>
    {/if}
</table>
Группы
<table border="0" width="100%" cellpadding="0" cellspacing="1">
     {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url section=access action=editGroupDefault params="$section/$class/$group_id"}" onClick="return showJip('{url section=access action=editGroupDefault params="$section/$class/$group_id"}');">{$group->getName()}</a></td>
            <td><a href="{url section=access action=deleteGroupDefault params="$section/$class/$group_id"}" onClick="mzz_confirm('Вы хотите удалить эту группу?') && showJip('{url section=access action=deleteGroupDefault params="$section/$class/$group_id"}'); return false;"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $groupsExists}
        <tr>
            <td align="center"><a href="{url section=access params="$section/$class" action=addGroupDefault}" onClick="return showJip('{url section=access params="$section/$class" action=addGroupDefault}');"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan=2><a href="{url section=access params="$section/$class" action=addGroupDefault}" onClick="return showJip('{url section=access params="$section/$class" action=addGroupDefault}');">Добавить группу</a></td>
        </tr>
    {/if}
</table>