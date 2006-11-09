Список пользователей, состоящих в группе <b>{$group->getName()}</b><br />
<form method="post" action="{url}">
    <table border="0" width="50%" cellpadding="0" cellspacing="1">

        {foreach from=$users item=user}
            <tr>
                <td align="center" width="10%">{$user->getUser()->getId()}</td>
                <td width="10%" align="center"><input type="checkbox" name="users[{$user->getUser()->getId()}]" value="1" /></td>
                <td width="80%">{$user->getUser()->getLogin()}</td>
                {*<td>{$group->getJip()}</td> *}
            </tr>
        {/foreach}
            <tr>
                <td><input type="submit" value="Удалить" onClick="return mzz_confirm('Вы действительно хотите удалить выбранных пользователей из группы?');"></td>
                <td colspan="2"><input type="reset" value="Сброс"></td>
            </tr>
        <tr>
            <td align="center"><a href="{url section=user action=addToGroup params=$group->getId()}" onClick="openWin('{url section=user action=addToGroup params=$group->getId()}', 'user_addToGroup_{$group->getId()}', 500,400); return false;"><img src="/templates/images/useradd.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url section=user action=addToGroup params=$group->getId()}" onClick="return showJip('{url section=user action=addToGroup params=$group->getId()}'); return false;">Добавить пользователя в группу</a></td>
        </tr>
    </table>
</form>