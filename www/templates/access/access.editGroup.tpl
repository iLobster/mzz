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
        {foreach from=$actions item=action}
            <tr>
                <td><input type="checkbox" name="access[{$action}]" id="access[{$action}]" value="1" {if not empty($acl.$action)}{if $groups === false}checked="checked"{/if}{/if} /></td>
                <td style="width: 100%;"><label for="access[{$action}]">{$action}</label></td>
            </tr>
        {/foreach}
        <tr>
            <td colspan="2"><input type="submit" value="���������� �����"> <input type="reset" value="�����"></td>
        </tr>
</table>
</form>