    {literal}<script type="text/javascript">
    /**
     * @param name access name
     * @param access 1 - allow checkbox, 0 - deny checkbox
     */
    function checkPermissionsForm(name, access) {
        if ($('access_' + name + '_' + (access ? 'allow' : 'deny')).getValue() == 1) {
            $('access_' + name + '_' + (access ? 'deny' : 'allow')).checked = false;
        }
    }

    /**
     * @param access 1 - allow checkboxes, 0 - deny checkboxes
     */
    function selectAllPermissions(access) { 
        $A(document.getElementsByTagName('input')).each(function(elm) { 
        var elmInfo = elm.id.match(new RegExp('access_.*?_(allow|deny)', 'im'));
        if(elmInfo) {
            if ((access && elmInfo[1] == 'deny') || (!access && elmInfo[1] == 'allow')) {
                $(elmInfo[0]).checked = false;
            } else {
                $(elmInfo[0]).checked = 'checked';
            }
        }});
    }
    </script>{/literal}

    <tr>
        <td><a class="jsLink" href="javascript: void(selectAllPermissions(1));">Разрешить</a></td>
        <td><a class="jsLink" href="javascript: void(selectAllPermissions(0));">Запретить</a></td>
        <td style="width: 100%;"><strong>Имя права</strong></td>
    </tr>
{foreach from=$actions item=action key=key}
    <tr>
        <td style='text-align: center;'><input type="checkbox" name="access[{$key}][allow]" id="access_{$key}_allow" onclick="checkPermissionsForm('{$key}', 1)" value="1" {if not empty($acl.$key.allow)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td style='text-align: center;'><input type="checkbox" name="access[{$key}][deny]" id="access_{$key}_deny" onclick="checkPermissionsForm('{$key}', 0)" value="1" {if not empty($acl.$key.deny)}{if $adding === false}checked="checked"{/if}{/if} /></td>
        <td style="width: 100%;{if $adding === false}{if not empty($acl.$key.allow)}color: #00AA00;{elseif not empty($acl.$key.deny)}color: #BF0000;{/if}{/if}"><label for="access[{$key}]">{if not empty($action.title)}{$action.title}{else}{$key}{/if}</label></td>
    </tr>
{/foreach}
<tr>
    <td colspan="3"><input type="submit" value="Сохранить"> <input type="reset" value="Сбросить"> <input type="reset" value="Отмена" onclick="javascript: jipWindow.close();"></td>
</tr>