    <tr>
        <td><strong>��</strong></td>
        <td><strong>���</strong></td>
        <td style="width: 100%;"><strong>��� �����</strong></td>
    </tr>
{foreach from=$actions item=action key=key}
    <tr>
        <td><input type="checkbox" name="access[{$key}][allow]" value="1" {if not empty($acl.$key.allow)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td><input type="checkbox" name="access[{$key}][deny]" value="1" {if not empty($acl.$key.deny)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td style="width: 100%"><label for="access[{$key}]">{if not empty($action.title)}{$action.title}{else}{$key}{/if}</label></td>
    </tr>
{/foreach}
<tr>
    <td colspan="3"><input type="submit" value="���������� �����"> <input type="reset" value="������" onclick="javascript: hideJip();"></td>
</tr>