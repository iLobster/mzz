{if $groups === false}
{assign var="groupName" value=$group->getName()}
{include file='jipTitle.tpl' title="Изменение прав по умолчанию на объект типа <b>$class</b> раздела <b>$section</b> для группы <b>$groupName</b>"}
{else}
{include file='jipTitle.tpl' title="Изменение прав по умолчанию на объект типа <b>$class</b> раздела <b>$section</b>"}
{/if}

<form action="{url}" method="post" onsubmit="return jipWindow.sendForm(this);">
<table border="0" width="99%" cellpadding="4" cellspacing="1" class="systemTable">
        <tr>
            <td colspan="3">
        {if $groups !== false}
            Выберите группу
            <select name="id">
                <option value="-1" selected="selected"></option>
                {foreach from=$groups item=group}
                    <option value="{$group->getId()}">{$group->getName()}</option>
                {/foreach}
            </select>
        {/if}</td>
        </tr>
        {include file="access/checkboxes.tpl" actions=$actions adding=$groups}
</table>
</form>


