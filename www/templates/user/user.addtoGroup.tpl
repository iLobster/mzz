���������� ������������� � ������ <b>{$group->getName()}</b><br />
<form action="{url}" method="get">
    <input type="text" value="{$filter}" name="filter"><input type="image" src="/templates/images/search.gif">
</form>
{if !is_null($filter)}
    ������� �������������: <b>{$users|@count}</b><br />
    <table border="0" width="100%" cellpadding="0" cellspacing="1">
    <form method="post" action="{url}">
        {foreach from=$users item=user}
            <tr>
                <td align="center" width="10%">{$user->getId()}</td>
                <td width="10%" align="center"><input type="checkbox" name="users[{$user->getId()}]" value="1" /></td>
                <td width="80%">{$user->getLogin()}</td>
            </tr>
        {/foreach}
            <tr>
                <td><input type="submit" value="��������"></td>
                <td colspan="2"><input type="reset" value="�����"></td>
            </tr>
    </form>
    </table>
{/if}