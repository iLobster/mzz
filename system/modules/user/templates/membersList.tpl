{assign var=name value=$group->getName()}
{include file='jipTitle.tpl' title="������ �������������, ��������� � ������ $name"}
<form method="post" action="{url}" onsubmit="return jipWindow.sendForm(this);">
    <table border="0" width="50%" cellpadding="4" cellspacing="1" class="systemTable">

        {foreach from=$users item=user}
            <tr>
                <td align="center" width="10%">{$user->getUser()->getId()}</td>
                <td width="10%" align="center"><input type="checkbox" name="users[{$user->getUser()->getId()}]" value="1" /></td>
                <td width="80%">{$user->getUser()->getLogin()}</td>
                {*<td>{$group->getJip()}</td> *}
            </tr>
        {/foreach}
        {if sizeof($users)}
            <tr>
                <td><input type="submit" value="�������"></td>
                <td colspan="2"><input type="reset" value="�����" onclick="javascript: jipWindow.close();"></td>
            </tr>
        {else}
            � ���� ������ ���� ��� �� ������ ������������
        {/if}
        <tr>
            <td align="center"><a href="{url route=withAnyParam section=user action=addToGroup name=$group->getId()}" class="jipLink"><img src="{$SITE_PATH}/templates/images/useradd.gif" width="16" height="16" /></a></td>
            <td colspan="2"><a href="{url route=withAnyParam section=user action=addToGroup name=$group->getId()}" onclick="javascript: return jipWindow.open(this.href, true);">�������� ������������ � ������</a></td>
        </tr>
    </table>
</form>