<div id="jipTitle">
<div class="jipMove">&nbsp;</div>
��������� ���� �� ��������� �� ������ ���� <b>{$class}</b> ������� <b>{$section}</b> {if $groups === false}��� ������ <b>{$group->getName()}</b>{/if}
</div>

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