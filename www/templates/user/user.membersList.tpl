{add file="popup.js"}
{add file="confirm.js"}
������ �������������, ��������� � ������ <b>{$group->getName()}</b><br />
<table border="0" width="100%" cellpadding="0" cellspacing="1">
    <form method="post" action="{url}">
    {foreach from=$users item=user}
        <tr>
            <td align="center" width="10%">{$user->getUser()->getId()}</td>
            <td width="10%" align="center"><input type="checkbox" name="users[{$user->getUser()->getId()}]" value="1" /></td>
            <td width="80%">{$user->getUser()->getLogin()}</td>
            {*<td>{$group->getJip()}</td> *}
        </tr>
    {/foreach}
        <tr>
            <td><input type="submit" value="�������" onClick="return mzz_confirm('�� ������������� ������ ������� ��������� ������������� �� ������?');"></td>
            <td colspan="2"><input type="reset" value="�����"></td>
        </tr>
    </form>
    <tr>
        <td align="center"><a href="{url section=user action=addToGroup params=$group->getId()}" onClick="openWin('{url section=user action=addToGroup params=$group->getId()}', 'user_addToGroup_{$group->getId()}', 500,400); return false;"><img src="/templates/images/useradd.gif" width="16" height="16" border="0" /></a></td>
        <td colspan="2"><a href="{url section=user action=addToGroup params=$group->getId()}" onClick="openWin('{url section=user action=addToGroup params=$group->getId()}', 'user_addToGroup_{$group->getId()}', 500,400); return false;">�������� ������������ � ������</a></td>
    </tr>
</table>