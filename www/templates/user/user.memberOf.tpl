Список групп для пользователя <b>{$user->getLogin()}</b><br />
<form method="post" action="{url}">
<table border="0" width="50%" cellpadding="0" cellspacing="1">
    {*<tr>
        <td colspan="3">Страницы ({$pager->getPagesTotal()}): {$pager->toString()}</td>
    </tr>*}
    {foreach from=$groups item=group}
        <tr>
            <td align="center" width="10%">{$group->getId()}</td>
            {assign var="group_id" value=$group->getId()}
            <td width="10%" align="center"><input type="checkbox" name="groups[{$group->getId()}]" value="1" {if isset($selected.$group_id)}checked="checked"{/if}></td>
            <td width="80%">{$group->getName()}</td>
            {*<td>{$group->getJip()}</td> *}
        </tr>
    {/foreach}
        <tr>
            <td><input type="submit" value="Сохранить"></td>
            <td colspan="2"><input type="reset" value="Сброс"></td>
        </tr>
    {*
    <tr>
        <td align="center"><a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;"><img src="/templates/images/add.gif" width="16" height="16" /></a></td>
        <td colspan="2"><a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;">Добавить пользователя</a></td>
    </tr>
    *}
</table>
</form>