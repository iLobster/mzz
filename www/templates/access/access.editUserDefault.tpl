��������� ���� �� ������ ���� <b>{$class}</b> ������� <b>{$section}</b> {if $users === false}��� ������������ <b>{$user->getLogin()}</b>{/if}
<form action="{url}" method="post">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
        {if $users !== false}
            �������� ������������
            <select name="id">
                <option value="-1" selected="selected"></option>
                {foreach from=$users item=user}
                    <option value="{$user->getId()}">{$user->getLogin()}</option>
                {/foreach}
            </select>
        {/if}
        {foreach from=$actions item=action}
            <tr>
                <td>{$action}</td>
                <td><input type="checkbox" name="access[{$action}][allow]" value="1" {if not empty($acl.$action.allow)}{if $users === false}checked="checked"{/if}{/if} /><input type="checkbox" name="access[{$action}][deny]" value="1" {if not empty($acl.$action.deny)}{if $users === false}checked="checked"{/if}{/if} /></td>
            </tr>
        {/foreach}
        <tr>
            <td><input type="submit" value="���������� �����"></td>
            <td><input type="reset" value="�����"></td>
        </tr>
</table>
</form>