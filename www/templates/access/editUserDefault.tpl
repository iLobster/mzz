{if $users === false}
{assign var="userLogin" value=$user->getLogin()}
{include file='jipTitle.tpl' title="��������� ���� �� ������ ���� <b>$class</b> ������� <b>$section</b> ��� ������������ <b>$userLogin</b>"}
{else}
{include file='jipTitle.tpl' title="��������� ���� �� ������ ���� <b>$class</b> ������� <b>$section</b>"}
{/if}
<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
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
        {include file="access/checkboxes.tpl" actions=$actions adding=$users}
</table>
</form>