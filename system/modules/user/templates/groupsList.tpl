{add file="popup.js"}
<a href="{url route=withId section=access id=$obj_id action=editACL}" class="jipLink"><img src="{$SITE_PATH}/templates/images/acl.gif" /></a>
<div id="submenu"><a href="{url route=default2 section=user action=list}">Пользователи</a></div>

<table border="0" width="99%" cellpadding="4" cellspacing="1" class="systemTable">
    <tr>
        <td><strong>Id</strong></td>
        <td><strong>Имя</strong></td>
        <td><strong>Пользователей в группе</strong></td>
        <td><strong>Jip</strong></td>
    </tr>
    {foreach from=$groups item=group key=key}
        <tr>
            <td align="center">{$group->getId()}</td>
            <td>{$group->getName()}</td>
            <td>{$usersGroups.$key|default:0}</td>
            <td>{$group->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url section=user action=groupCreate}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
        <td colspan="3"><a href="{url route=default2 section=user action=groupCreate}" class="jipLink">Добавить группу</a></td>
    </tr>
</table>
<div class="pages">{$pager->toString()}</div>