{foreach from=$actions item=action key=key}
    <tr>
        <td><input type="checkbox" name="access[{$key}][allow]"  value="1" {if not empty($acl.$key.allow)}{if $adding === false}checked="checked"{/if}{/if} /><input type="checkbox" name="access[{$key}][deny]"  value="1" {if not empty($acl.$key.deny)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td style="width: 80%"><label for="access[{$key}]">{if not empty($action.title)}{$action.title}{else}{$key}{/if}</label></td>
    </tr>
{/foreach}
<tr>
    <td colspan="2"><input type="submit" value="Установить права"> <input type="reset" value="Отмена" onclick="javascript: hideJip();"></td>
</tr>