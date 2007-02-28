{add file="popup.js"}
{include file='jipTitle.tpl' title="Права по умолчанию. Раздел: <b>$section</b>, класс: <b>$class</b>."}

<p>Пользователи</p>
<table border="0" width="99%" cellpadding="5" cellspacing="1" class="list">
    <tr>
        <td align="center">0</td>
        <td><a href="{url section=access action=editOwner params="$section/$class"}" class="jipLink">Владелец объекта</a></td>
        <td>&nbsp;</td>
    </tr>
    {foreach from=$users item=user}
        <tr>
            <td align="center">{$user->getId()}</td>
            {assign var=user_id value=$user->getId()}
            <td><a href="{url route=withAnyParam section=access action=editUserDefault name="$section/$class/$user_id"}" class="jipLink">{$user->getLogin()}</a></td>
            <td><a href="{url route=withAnyParam section=access action=deleteUserDefault name="$section/$class/$user_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $usersExists}
        <tr>
            <td align="center"><a href="{url route=withAnyParam section=access name="$section/$class" action=addUserDefault}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url route=withAnyParam section=access name="$section/$class" action=addUserDefault}" class="jipLink">Добавить пользователя</a></td>
        </tr>
    {/if}
</table>
<p>Группы</p>
<table border="0" width="99%" cellpadding="0" cellspacing="1" class="list">
     {foreach from=$groups item=group}
        <tr>
            <td align="center">{$group->getId()}</td>
            {assign var=group_id value=$group->getId()}
            <td><a href="{url route=withAnyParam section=access action=editGroupDefault name="$section/$class/$group_id"}" class="jipLink">{$group->getName()}</a></td>
            <td><a href="{url route=withAnyParam section=access action=deleteGroupDefault name="$section/$class/$group_id"}" class="jipLink"><img src="{$SITE_PATH}/templates/images/delete.gif" width="16" height="16" /></a></td>
        </tr>
    {/foreach}
    {if $groupsExists}
        <tr>
            <td align="center"><a href="{url route=withAnyParam section=access name="$section/$class" action=addGroupDefault}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
            <td colspan=2><a href="{url route=withAnyParam section=access name="$section/$class" action=addGroupDefault}" class="jipLink">Добавить группу</a></td>
        </tr>
    {/if}
</table>