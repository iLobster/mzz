{add file="popup.js"}

<div id="submenu"><a href="{url route=default2 section=user action=groupsList}">Группы</a></div>

<table border="0" width="99%" cellpadding="4" cellspacing="0" class="systemTable">
    {foreach from=$users item=user}
        <tr>
            <td width="30" align="center">{$user->getId()}</td>
            <td>{$user->getLogin()}</td>
            <td width="20" >{$user->getJip()}</td>
        </tr>
    {/foreach}
    <tr>
        <td align="center"><a href="{url route=default2 section=user action=create}" class="jipLink"><img src="{$SITE_PATH}/templates/images/add.gif" width="16" height="16" /></a></td>
        <td colspan="2"><a href="{url route=default2 section=user action=create}" class="jipLink">Добавить пользователя</a></td>
    </tr>
</table>
<div class="pages">{$pager->toString()}</div>
