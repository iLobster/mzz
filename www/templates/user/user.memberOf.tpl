������ ����� ��� ������������ <b>{$user->getLogin()}</b><br />
<table border="0" width="50%" cellpadding="0" cellspacing="1">
    {*<tr>
        <td colspan="3">�������� ({$pager->getPagesTotal()}): {$pager->toString()}</td>
    </tr>*}
    <form method="post" action="{url}">
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
            <td><input type="submit" value="���������"></td>
            <td colspan="2"><input type="reset" value="�����"></td>
        </tr>
    </form>
    {*
    <tr>
        <td align="center"><a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;"><img src="/templates/images/add.gif" width="16" height="16" border="0" /></a></td>
        <td colspan="2"><a href="{url section=user action=create}" onClick="openWin('{url section=user action=create}', 'user_create', 500,400); return false;">�������� ������������</a></td>
    </tr>
    *}
</table>