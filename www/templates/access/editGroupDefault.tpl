{if $groups === false}
{assign var="groupName" value=$group->getName()}
{include file='jipTitle.tpl' title="��������� ���� �� ��������� �� ������ ���� <b>$class</b> ������� <b>$section</b> ��� ������ <b>$groupName</b>"}
{else}
{include file='jipTitle.tpl' title="��������� ���� �� ��������� �� ������ ���� <b>$class</b> ������� <b>$section</b>"}
{/if}

<form action="{url}" method="post" onsubmit="return sendFormWithAjax(this);return false;">
<table border="0" width="100%" cellpadding="0" cellspacing="1">
        {if $groups !== false}
            �������� ������
            <select name="id">
                <option value="-1" selected="selected"></option>
                {foreach from=$groups item=group}
                    <option value="{$group->getId()}">{$group->getName()}</option>
                {/foreach}
            </select>
        {/if}
        {include file="access/checkboxes.tpl" actions=$actions adding=$groups}
</table>
</form>