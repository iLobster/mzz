{if $groups === false}
{assign var="groupName" value=$group->getName()}
{include file='jipTitle.tpl' title="��������� ���� �� ������ ��� ������ <code>$groupName</code>"}
{else}
{include file='jipTitle.tpl' title='��������� ���� �� ������'}
{/if}

<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
    <table border="0" width="99%" cellpadding="4" cellspacing="1" class="list">
            {if $groups !== false}
                �������� ������
                <select name="user_id">
                    <option value="-1" selected="selected"></option>
                    {foreach from=$groups item=group}
                        <option value="{$group->getId()}">{$group->getName()}</option>
                    {/foreach}
                </select>
            {/if}
            {include file="access/checkboxes.tpl" actions=$actions adding=$groups}
    </table>
</form>