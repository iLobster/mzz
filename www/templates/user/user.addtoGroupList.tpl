{if !is_null($filter[0])}
    ������� �������������: <b>{$users|@count}</b><br />
    <form method="post" action="{url}">
    <table border="0" width="100%" cellpadding="0" cellspacing="1">
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