<div class="jipTitle">��������� ���� �� ������ ... {if $groups === false}��� ������ <code>{$group->getName()}</code>{/if}</div>
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
        {foreach from=$actions item=action key=key}
            <tr>
                <td><input type="checkbox" name="access[{$key}][allow]" id="access[{$key}][allow]" value="1" {if not empty($acl.$key.allow)}{if $groups === false}checked="checked"{/if}{/if} /><input type="checkbox" name="access[{$key}][deny]" id="access[{$key}][deny]" value="1" {if not empty($acl.$key.deny)}{if $groups === false}checked="checked"{/if}{/if} /></td>
                <td style="width: 90%;"><label for="access[{$key}]">{if not empty($action.title)}{$action.title}{else}{$key}{/if}</label></td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="2"><input type="submit" value="���������� �����"> <input type="reset" value="������" onclick="javascript: hideJip();"></td>
        </tr>
</table>
</form>